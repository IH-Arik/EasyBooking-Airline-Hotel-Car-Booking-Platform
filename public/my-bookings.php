<?php
$pageTitle = "My Bookings";
require_once 'includes/db_connect.php';
require_once 'includes/session.php';

// Redirect if not logged in
requireLogin();

// Get user's hotel bookings
try {
    $stmt = $conn->prepare("
        SELECT hb.*, h.name as hotel_name, h.location as hotel_location, h.image_url 
        FROM hotel_bookings hb
        JOIN hotels h ON hb.hotel_id = h.hotel_id
        WHERE hb.user_id = ?
        ORDER BY hb.booking_date DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $hotel_bookings = $stmt->fetchAll();
} catch (PDOException $e) {
    $hotel_error = "Failed to retrieve hotel bookings: " . $e->getMessage();
}

// Get user's flight bookings
try {
    $stmt = $conn->prepare("
        SELECT fb.*, f.airline, f.flight_number, f.departure_location, f.arrival_location, 
               f.departure_date, f.departure_time, f.arrival_date, f.arrival_time
        FROM flight_bookings fb
        JOIN flights f ON fb.flight_id = f.flight_id
        WHERE fb.user_id = ?
        ORDER BY fb.booking_date DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $flight_bookings = $stmt->fetchAll();
} catch (PDOException $e) {
    $flight_error = "Failed to retrieve flight bookings: " . $e->getMessage();
}

// Get user's car bookings
try {
    $stmt = $conn->prepare("
        SELECT cb.*, c.brand, c.model, c.year, c.type, c.image_url
        FROM car_bookings cb
        JOIN cars c ON cb.car_id = c.car_id
        WHERE cb.user_id = ?
        ORDER BY cb.booking_date DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $car_bookings = $stmt->fetchAll();
} catch (PDOException $e) {
    $car_error = "Failed to retrieve car bookings: " . $e->getMessage();
}

// Handle booking cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_booking'])) {
    $booking_id = intval($_POST['booking_id'] ?? 0);
    $booking_type = $_POST['booking_type'] ?? '';
    
    if ($booking_id > 0 && in_array($booking_type, ['hotel', 'flight', 'car'])) {
        try {
            switch ($booking_type) {
                case 'hotel':
                    $stmt = $conn->prepare("UPDATE hotel_bookings SET status = 'cancelled' WHERE booking_id = ? AND user_id = ?");
                    break;
                case 'flight':
                    $stmt = $conn->prepare("UPDATE flight_bookings SET status = 'cancelled' WHERE booking_id = ? AND user_id = ?");
                    break;
                case 'car':
                    $stmt = $conn->prepare("UPDATE car_bookings SET status = 'cancelled' WHERE booking_id = ? AND user_id = ?");
                    break;
            }
            
            $stmt->execute([$booking_id, $_SESSION['user_id']]);
            
            if ($stmt->rowCount() > 0) {
                $cancel_success = "Your booking has been cancelled successfully.";
                
                // Refresh the page to update the booking status
                header("Location: my-bookings.php?cancelled=1");
                exit();
            } else {
                $cancel_error = "Failed to cancel booking. Please try again.";
            }
        } catch (PDOException $e) {
            $cancel_error = "Error cancelling booking: " . $e->getMessage();
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

  <!-- My Bookings Section -->
  <section class="bookings-container">
    <h1>My Bookings</h1>
    
    <?php if (isset($_GET['cancelled'])): ?>
      <div class="alert alert-success">
        Your booking has been cancelled successfully.
      </div>
    <?php endif; ?>
    
    <?php if (isset($cancel_error)): ?>
      <div class="alert alert-danger">
        <?php echo htmlspecialchars($cancel_error); ?>
      </div>
    <?php endif; ?>
    
    <div class="booking-tabs">
      <button class="booking-tab active" data-tab="hotel-bookings">Hotel Bookings</button>
      <button class="booking-tab" data-tab="flight-bookings">Flight Bookings</button>
      <button class="booking-tab" data-tab="car-bookings">Car Bookings</button>
    </div>
    
    <!-- Hotel Bookings -->
    <div class="booking-content" id="hotel-bookings">
      <h2>Hotel Bookings</h2>
      
      <?php if (isset($hotel_error)): ?>
        <div class="alert alert-danger">
          <?php echo htmlspecialchars($hotel_error); ?>
        </div>
      <?php elseif (empty($hotel_bookings)): ?>
        <div class="alert alert-info">
          You don't have any hotel bookings yet.
        </div>
      <?php else: ?>
        <?php foreach ($hotel_bookings as $booking): ?>
          <div class="booking-card">
            <div class="booking-header">
              <h3><?php echo htmlspecialchars($booking['hotel_name']); ?></h3>
              <span class="booking-status status-<?php echo $booking['status']; ?>">
                <?php echo ucfirst($booking['status']); ?>
              </span>
            </div>
            <div class="booking-details">
              <div class="booking-detail-item">
                <span>Location:</span>
                <?php echo htmlspecialchars($booking['hotel_location']); ?>
              </div>
              <div class="booking-detail-item">
                <span>Check-in:</span>
                <?php echo htmlspecialchars($booking['check_in_date']); ?>
              </div>
              <div class="booking-detail-item">
                <span>Check-out:</span>
                <?php echo htmlspecialchars($booking['check_out_date']); ?>
              </div>
              <div class="booking-detail-item">
                <span>Guests:</span>
                <?php echo $booking['adults']; ?> adult(s), <?php echo $booking['children']; ?> child(ren)
              </div>
              <div class="booking-detail-item">
                <span>Rooms:</span>
                <?php echo $booking['rooms']; ?>
              </div>
              <div class="booking-detail-item">
                <span>Total Price:</span>
                $<?php echo number_format($booking['total_price'], 2); ?>
              </div>
              <div class="booking-detail-item">
                <span>Booking Date:</span>
                <?php echo date('M j, Y', strtotime($booking['booking_date'])); ?>
              </div>
            </div>
            <?php if ($booking['status'] === 'pending' || $booking['status'] === 'confirmed'): ?>
              <div class="booking-actions">
                <form method="post" action="" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                  <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                  <input type="hidden" name="booking_type" value="hotel">
                  <button type="submit" name="cancel_booking">Cancel Booking</button>
                </form>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    
    <!-- Flight Bookings -->
    <div class="booking-content" id="flight-bookings" style="display: none;">
      <h2>Flight Bookings</h2>
      
      <?php if (isset($flight_error)): ?>
        <div class="alert alert-danger">
          <?php echo htmlspecialchars($flight_error); ?>
        </div>
      <?php elseif (empty($flight_bookings)): ?>
        <div class="alert alert-info">
          You don't have any flight bookings yet.
        </div>
      <?php else: ?>
        <?php foreach ($flight_bookings as $booking): ?>
          <div class="booking-card">
            <div class="booking-header">
              <h3><?php echo htmlspecialchars($booking['airline']); ?> - Flight <?php echo htmlspecialchars($booking['flight_number']); ?></h3>
              <span class="booking-status status-<?php echo $booking['status']; ?>">
                <?php echo ucfirst($booking['status']); ?>
              </span>
            </div>
            <div class="booking-details">
              <div class="booking-detail-item">
                <span>From:</span>
                <?php echo htmlspecialchars($booking['departure_location']); ?>
              </div>
              <div class="booking-detail-item">
                <span>To:</span>
                <?php echo htmlspecialchars($booking['arrival_location']); ?>
              </div>
              <div class="booking-detail-item">
                <span>Departure:</span>
                <?php echo htmlspecialchars($booking['departure_date']); ?> at <?php echo htmlspecialchars($booking['departure_time']); ?>
              </div>
              <div class="booking-detail-item">
                <span>Arrival:</span>
                <?php echo htmlspecialchars($booking['arrival_date']); ?> at <?php echo htmlspecialchars($booking['arrival_time']); ?>
              </div>
              <div class="booking-detail-item">
                <span>Passengers:</span>
                <?php echo $booking['passengers']; ?>
              </div>
              <div class="booking-detail-item">
                <span>Total Price:</span>
                $<?php echo number_format($booking['total_price'], 2); ?>
              </div>
              <div class="booking-detail-item">
                <span>Booking Date:</span>
                <?php echo date('M j, Y', strtotime($booking['booking_date'])); ?>
              </div>
            </div>
            <?php if ($booking['status'] === 'pending' || $booking['status'] === 'confirmed'): ?>
              <div class="booking-actions">
                <form method="post" action="" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                  <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                  <input type="hidden" name="booking_type" value="flight">
                  <button type="submit" name="cancel_booking">Cancel Booking</button>
                </form>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    
    <!-- Car Bookings -->
    <div class="booking-content" id="car-bookings" style="display: none;">
      <h2>Car Bookings</h2>
      
      <?php if (isset($car_error)): ?>
        <div class="alert alert-danger">
          <?php echo htmlspecialchars($car_error); ?>
        </div>
      <?php elseif (empty($car_bookings)): ?>
        <div class="alert alert-info">
          You don't have any car bookings yet.
        </div>
      <?php else: ?>
        <?php foreach ($car_bookings as $booking): ?>
          <div class="booking-card">
            <div class="booking-header">
              <h3><?php echo htmlspecialchars($booking['brand']); ?> <?php echo htmlspecialchars($booking['model']); ?> (<?php echo $booking['year']; ?>)</h3>
              <span class="booking-status status-<?php echo $booking['status']; ?>">
                <?php echo ucfirst($booking['status']); ?>
              </span>
            </div>
            <div class="booking-details">
              <div class="booking-detail-item">
                <span>Car Type:</span>
                <?php echo htmlspecialchars($booking['type']); ?>
              </div>
              <div class="booking-detail-item">
                <span>Pick-up:</span>
                <?php echo htmlspecialchars($booking['pickup_location']); ?> on <?php echo htmlspecialchars($booking['pickup_date']); ?> at <?php echo htmlspecialchars($booking['pickup_time']); ?>
              </div>
              <div class="booking-detail-item">
                <span>Drop-off:</span>
                <?php echo htmlspecialchars($booking['dropoff_location']); ?> on <?php echo htmlspecialchars($booking['dropoff_date']); ?> at <?php echo htmlspecialchars($booking['dropoff_time']); ?>
              </div>
              <div class="booking-detail-item">
                <span>Total Price:</span>
                $<?php echo number_format($booking['total_price'], 2); ?>
              </div>
              <div class="booking-detail-item">
                <span>Booking Date:</span>
                <?php echo date('M j, Y', strtotime($booking['booking_date'])); ?>
              </div>
            </div>
            <?php if ($booking['status'] === 'pending' || $booking['status'] === 'confirmed'): ?>
              <div class="booking-actions">
                <form method="post" action="" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                  <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                  <input type="hidden" name="booking_type" value="car">
                  <button type="submit" name="cancel_booking">Cancel Booking</button>
                </form>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <style>
    .booking-tabs {
      display: flex;
      margin-bottom: 30px;
      border-bottom: 1px solid #ddd;
    }
    
    .booking-tab {
      background: none;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      font-size: 1rem;
      border-bottom: 3px solid transparent;
      transition: all 0.3s;
    }
    
    .booking-tab.active {
      border-bottom-color: #ff6b6b;
      font-weight: bold;
    }
    
    .booking-content {
      margin-bottom: 50px;
    }
    
    .booking-content h2 {
      margin-bottom: 20px;
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const tabs = document.querySelectorAll('.booking-tab');
      const contents = document.querySelectorAll('.booking-content');
      
      tabs.forEach(tab => {
        tab.addEventListener('click', function() {
          // Remove active class from all tabs
          tabs.forEach(t => t.classList.remove('active'));
          
          // Add active class to clicked tab
          this.classList.add('active');
          
          // Hide all content
          contents.forEach(content => content.style.display = 'none');
          
          // Show corresponding content
          const contentId = this.getAttribute('data-tab');
          document.getElementById(contentId).style.display = 'block';
        });
      });
    });
  </script>

<?php include 'includes/footer.php'; ?>
