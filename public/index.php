<?php
$pageTitle = "Home";
require_once 'includes/db_connect.php';
require_once 'includes/session.php';

// Fetch trending destinations
$stmt = $conn->query("SELECT * FROM destinations ORDER BY destination_id LIMIT 5");
$destinations = $stmt->fetchAll();
?>
<?php include 'includes/header.php'; ?>

  <!-- Services Section -->
  <div class="services">
    <a href="index.php" class="active">&#127976;<b>Hotels</b></a>
    <a href="flights.php">&#128746;<b>Flights</b></a>
    <a href="car-rentals.php">&#128662;<b>Car Rentals</b></a>
  </div>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <h1>Find your next stay</h1>
      <p>Search low prices on hotels, homes, and much more...</p>
      <div class="search-box">
        <div class="search-input-group">
          <i class="fas fa-map-marker-alt"></i>
          <input type="text" id="destination" class="search-input" placeholder="Where are you going?">
        </div>
        <div class="search-input-group">
          <i class="fas fa-calendar-alt"></i>
          <input type="date" id="check-in" class="search-input">
        </div>
        <div class="search-input-group">
          <i class="fas fa-calendar-alt"></i>
          <input type="date" id="check-out" class="search-input">
        </div>
        <div class="search-input-group">
          <i class="fas fa-user"></i>
          <input type="number" id="adults" class="search-input" placeholder="Adults" min="1" value="2">
        </div>
        <div class="search-input-group">
          <i class="fas fa-child"></i>
          <input type="number" id="children" class="search-input" placeholder="Children" min="0" value="0">
        </div>
        <div class="search-input-group">
          <i class="fas fa-building"></i>
          <input type="number" id="rooms" class="search-input" placeholder="Rooms" min="1" value="1">
        </div>
        <button class="search-btn">
          <i class="fas fa-search"></i> Search
        </button>
      </div>
    </div>
  </section>

  <!-- Offers Section -->
  <section class="offers">
    <h2>Promotions, deals, and special offers for you</h2>
    <div class="offer-card">
      <img src="images/offer1.jpg" alt="Offer 1">
      <div class="offer-content">
        <h3>Save 15% with Late Escape Deals</h3>
        <p>Explore thousands of destinations worldwide and save 15% or more</p>
        <button class="offer-btn">Explore deals</button>
      </div>
    </div>
  </section>

  <!-- Trending Destinations Section -->
  <section class="trending">
    <h2>Trending destinations</h2>
    <p>Most popular choices for travellers</p>
    <div class="destination-grid">
      <?php foreach ($destinations as $destination): ?>
        <div class="destination-card">
          <img src="<?php echo htmlspecialchars($destination['image_url']); ?>" alt="<?php echo htmlspecialchars($destination['name']); ?>">
          <h3><?php echo htmlspecialchars($destination['name']); ?></h3>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

<?php include 'includes/footer.php'; ?>
