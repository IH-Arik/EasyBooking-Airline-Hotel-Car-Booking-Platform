<?php
$pageTitle = "Hotel Search Results";
require_once 'includes/db_connect.php';
require_once 'includes/session.php';

// Get search parameters
$destination = $_GET['destination'] ?? '';
$check_in = $_GET['check_in'] ?? '';
$check_out = $_GET['check_out'] ?? '';
$adults = intval($_GET['adults'] ?? 1);
$children = intval($_GET['children'] ?? 0);
$rooms = intval($_GET['rooms'] ?? 1);

// Validate search parameters
if (empty($destination) || empty($check_in) || empty($check_out)) {
    header("Location: index.php");
    exit();
}

// Search hotels
try {
    $stmt = $conn->prepare("SELECT * FROM hotels WHERE location LIKE ?");
    $stmt->execute(['%' . $destination . '%']);
    $hotels = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Search failed: " . $e->getMessage();
}

// Calculate number of nights
$check_in_date = new DateTime($check_in);
$check_out_date = new DateTime($check_out);
$interval = $check_in_date->diff($check_out_date);
$nights = $interval->days;
?>
<?php include 'includes/header.php'; ?>

  <!-- Services Section -->
  <div class="services">
    <a href="index.php" class="active">&#127976;<b>Hotels</b></a>
    <a href="flights.php">&#128746;<b>Flights</b></a>
    <a href="car-rentals.php">&#128662;<b>Car Rentals</b></a>
  </div>

  <!-- Search Results Section -->
  <section class="search-results">
    <div class="search-results-header">
      <h1>Hotels in <?php echo htmlspecialchars($destination); ?></h1>
      <p><?php echo htmlspecialchars($check_in); ?> to <?php echo htmlspecialchars($check_out); ?> · <?php echo $nights; ?> night(s) · <?php echo $adults; ?> adult(s) · <?php echo $children; ?> child(ren) · <?php echo $rooms; ?> room(s)</p>
    </div>
    
    <?php if (isset($error)): ?>
      <div class="alert alert-danger">
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>
    
    <?php if (empty($hotels)): ?>
      <div class="alert alert-info">
        No hotels found matching your search criteria. Please try a different search.
      </div>
    <?php else: ?>
      <?php foreach ($hotels as $hotel): ?>
        <div class="hotel-card">
          <div class="hotel-card-image">
            <img src="<?php echo htmlspecialchars($hotel['image_url']); ?>" alt="<?php echo htmlspecialchars($hotel['name']); ?>">
          </div>
          <div class="hotel-card-content">
            <div class="hotel-card-header">
              <div class="hotel-card-title">
                <h2><?php echo htmlspecialchars($hotel['name']); ?></h2>
                <p><?php echo htmlspecialchars($hotel['location']); ?></p>
              </div>
              <div class="hotel-card-rating">
                <i class="fas fa-star"></i> <?php echo number_format($hotel['rating'], 1); ?>
              </div>
            </div>
            <div class="hotel-card-description">
              <p><?php echo htmlspecialchars($hotel['description']); ?></p>
            </div>
            <div class="hotel-card-footer">
              <div class="hotel-card-price">
                $<?php echo number_format($hotel['price_per_night'] * $nights * $rooms, 2); ?> <span>for <?php echo $nights; ?> night(s)</span>
              </div>
              <a href="hotel-details.php?hotel_id=<?php echo $hotel['hotel_id']; ?>&check_in=<?php echo urlencode($check_in); ?>&check_out=<?php echo urlencode($check_out); ?>&adults=<?php echo $adults; ?>&children=<?php echo $children; ?>&rooms=<?php echo $rooms; ?>" class="hotel-card-btn">View Details</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </section>

<?php include 'includes/footer.php'; ?>
