<?php
$pageTitle = "Hotel Details";
require_once 'includes/db_connect.php';
require_once 'includes/session.php';

// Get hotel ID and booking parameters
$hotel_id = intval($_GET['hotel_id'] ?? 0);
$check_in = $_GET['check_in'] ?? '';
$check_out = $_GET['check_out'] ?? '';
$adults = intval($_GET['adults'] ?? 1);
$children = intval($_GET['children'] ?? 0);
$rooms = intval($_GET['rooms'] ?? 1);

// Validate parameters
if ($hotel_id <= 0 || empty($check_in) || empty($check_out)) {
    header("Location: index.php");
    exit();
}

// Get hotel details
try {
    $stmt = $conn->prepare("SELECT * FROM hotels WHERE hotel_id = ?");
    $stmt->execute([$hotel_id]);
    $hotel = $stmt->fetch();
    
    if (!$hotel) {
        header("Location: index.php");
        exit();
    }
} catch (PDOException $e) {
    $error = "Failed to retrieve hotel details: " . $e->getMessage();
}

// Calculate number of nights
$check_in_date = new DateTime($check_in);
$check_out_date = new DateTime($check_out);
$interval = $check_in_date->diff($check_out_date);
$nights = $interval->days;

// Calculate total price
$total_price = $hotel['price_per_night'] * $nights * $rooms;

// Handle booking submission
$booking_success = false;
$booking_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_now'])) {
    // Check if user is logged in
    if (!isLoggedIn()) {
        // Store booking details in session and redirect to login
        $_SESSION['booking_details'] = [
            'type' => 'hotel',
            'hotel_id' => $hotel_id,
            'check_in' => $check_in,
            'check_out' => $check_out,
            'adults' => $adults,
            'children' => $children,
            'rooms' => $rooms,
            'total_price' => $total_price
        ];
        
        header("Location: signin.php?redirect=hotel-details.php?hotel_id=$hotel_id&check_in=$check_in&check_out=$check_out&adults=$adults&children=$children&rooms=$rooms");
        exit();
    }
    
    // Process booking
    try {
        $stmt = $conn->prepare("INSERT INTO hotel_bookings (user_id, hotel_id, check_in_date, check_out_date, adults, children, rooms, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_SESSION['user_id'],
            $hotel_id,
            $check_in,
            $check_out,
            $adults,
            $children,
            $rooms,
            $total_price
        ]);
        
        $booking_success = true;
    } catch (PDOException $e) {
        $booking_error = "Booking failed: " . $e->getMessage();
    }
}
?>
<?php include 'includes/header.php'; ?>

  <!-- Hotel Details Section -->
  <section class="hotel-details">
    <div class="container">
      <?php if (isset($error)): ?>
        <div class="alert alert-danger">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php else: ?>
        <div class="hotel-header">
          <h1><?php echo htmlspecialchars($hotel['name']); ?></h1>
          <div class="hotel-rating">
            <i class="fas fa-star"></i> <?php echo number_format($hotel['rating'], 1); ?>
          </div>
        </div>
        
        <div class="hotel-location">
          <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($hotel['location']); ?>
        </div>
        
        <div class="hotel-image">
          <img src="<?php echo htmlspecialchars($hotel['image_url']); ?>" alt="<?php echo htmlspecialchars($hotel['name']); ?>">
        </div>
        
        <div class="hotel-description">
          <h2>About this hotel</h2>
          <p><?php echo htmlspecialchars($hotel['description']); ?></p>
        </div>
        
        <?php if ($booking_success): ?>
          <div class="alert alert-success">
            Your booking has been confirmed! You can view your booking details in <a href="my-bookings.php">My Bookings</a>.
          </div>
        <?php elseif ($booking_error): ?>
          <div class="alert alert-danger">
            <?php echo htmlspecialchars($booking_error); ?>
          </div>
        <?php endif; ?>
        
        <div class="booking-summary">
          <h2>Booking Summary</h2>
          <div class="booking-details">
            <div class="booking-detail">
              <span>Check-in:</span>
              <?php echo htmlspecialchars($check_in); ?>
            </div>
            <div class="booking-detail">
              <span>Check-out:</span>
              <?php echo htmlspecialchars($check_out); ?>
            </div>
            <div class="booking-detail">
              <span>Nights:</span>
              <?php echo $nights; ?>
            </div>
            <div class="booking-detail">
              <span>Guests:</span>
              <?php echo $adults; ?> adult(s), <?php echo $children; ?> child(ren)
            </div>
            <div class="booking-detail">
              <span>Rooms:</span>
              <?php echo $rooms; ?>
            </div>
            <div class="booking-detail total-price">
              <span>Total Price:</span>
              $<?php echo number_format($total_price, 2); ?>
            </div>
          </div>
          
          <form method="post" action="">
            <button type="submit" name="book_now" class="book-now-btn">Book Now</button>
          </form>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <style>
    .hotel-details {
      max-width: 1000px;
      margin: 50px auto;
      padding: 0 20px;
    }
    
    .hotel-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }
    
    .hotel-rating {
      color: #ff6b6b;
      font-size: 1.2rem;
    }
    
    .hotel-location {
      margin-bottom: 20px;
      color: #666;
    }
    
    .hotel-image {
      margin-bottom: 30px;
    }
    
    .hotel-image img {
      width: 100%;
      border-radius: 10px;
    }
    
    .hotel-description {
      margin-bottom: 30px;
    }
    
    .hotel-description h2 {
      margin-bottom: 15px;
    }
    
    .booking-summary {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .booking-summary h2 {
      margin-bottom: 20px;
    }
    
    .booking-details {
      margin-bottom: 30px;
    }
    
    .booking-detail {
      margin-bottom: 15px;
      display: flex;
      justify-content: space-between;
    }
    
    .booking-detail span {
      font-weight: bold;
    }
    
    .total-price {
      font-size: 1.2rem;
      border-top: 1px solid #eee;
      padding-top: 15px;
    }
    
    .book-now-btn {
      background-color: #ff6b6b;
      color: white;
      border: none;
      padding: 15px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1rem;
      width: 100%;
      transition: background-color 0.3s;
    }
    
    .book-now-btn:hover {
      background-color: #ff5252;
    }
  </style>

<?php include 'includes/footer.php'; ?>
