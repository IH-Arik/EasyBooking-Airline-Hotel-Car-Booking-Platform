<?php
$pageTitle = "Our Services";
require_once 'includes/db_connect.php';
require_once 'includes/session.php';
?>
<?php include 'includes/header.php'; ?>

  <!-- Services Section -->
  <div class="services">
    <a href="index.php">&#127976;<b>Hotels</b></a>
    <a href="flights.php">&#128746;<b>Flights</b></a>
    <a href="car-rentals.php">&#128662;<b>Car Rentals</b></a>
  </div>

  <!-- Services Content -->
  <section class="services-content">
    <h1>Our Services</h1>
    <p>Discover the wide range of travel services we offer to make your journey memorable</p>
    
    <div class="service-card">
      <h2>Hotel Booking</h2>
      <p>Find the perfect accommodation for your trip from our vast selection of hotels, resorts, apartments, and more. We offer competitive prices, flexible cancellation policies, and verified reviews to help you make the right choice.</p>
      <a href="index.php" class="btn">Book Now</a>
    </div>
    
    <div class="service-card">
      <h2>Flight Booking</h2>
      <p>Search and compare flights from hundreds of airlines to find the best deals. Whether you're looking for a roundtrip, one-way, or multi-city flight, we've got you covered with our easy-to-use flight search engine.</p>
      <a href="flights.php" class="btn">Book Now</a>
    </div>
    
    <div class="service-card">
      <h2>Car Rentals</h2>
      <p>Rent a car for your trip and enjoy the freedom to explore at your own pace. We partner with leading car rental companies worldwide to offer you a wide selection of vehicles at competitive prices.</p>
      <a href="car-rentals.php" class="btn">Book Now</a>
    </div>
    
    <div class="service-card">
      <h2>Travel Insurance</h2>
      <p>Protect your trip with our comprehensive travel insurance plans. Coverage includes trip cancellation, medical emergencies, lost luggage, and more, giving you peace of mind during your travels.</p>
      <a href="#" class="btn">Learn More</a>
    </div>
    
    <div class="service-card">
      <h2>Airport Transfers</h2>
      <p>Start and end your trip smoothly with our reliable airport transfer services. Choose from a variety of vehicle options to suit your needs and budget.</p>
      <a href="#" class="btn">Book Now</a>
    </div>
  </section>

  <style>
    .services-content {
      max-width: 800px;
      margin: 50px auto;
      padding: 0 20px;
    }
    
    .services-content h1 {
      text-align: center;
      margin-bottom: 10px;
    }
    
    .services-content > p {
      text-align: center;
      margin-bottom: 30px;
      color: #666;
    }
    
    .service-card {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      padding: 30px;
      margin-bottom: 30px;
    }
    
    .service-card h2 {
      margin-bottom: 15px;
      color: #333;
    }
    
    .service-card p {
      margin-bottom: 20px;
      color: #666;
    }
    
    .btn {
      display: inline-block;
      background-color: #ff6b6b;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      transition: background-color 0.3s;
    }
    
    .btn:hover {
      background-color: #ff5252;
    }
  </style>

<?php include 'includes/footer.php'; ?>
