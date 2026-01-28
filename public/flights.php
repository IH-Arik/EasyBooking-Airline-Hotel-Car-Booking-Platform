<?php
$pageTitle = "Flights";
require_once 'includes/db_connect.php';
require_once 'includes/session.php';

// Fetch trending destinations
$stmt = $conn->query("SELECT * FROM destinations ORDER BY destination_id LIMIT 5");
$destinations = $stmt->fetchAll();
?>
<?php include 'includes/header.php'; ?>

  <!-- Services Section -->
  <div class="services">
    <a href="index.php">&#127976;<b>Hotels</b></a>
    <a href="flights.php" class="active">&#128746;<b>Flights</b></a>
    <a href="car-rentals.php">&#128662;<b>Car Rentals</b></a>
  </div>

  <!-- Flight Search Section -->
  <section class="flight-search">
    <h1>Search Flights</h1>
    <div class="flight-tabs">
      <button class="active" id="roundtrip-tab">
        <i class="fas fa-exchange-alt"></i> Roundtrip
      </button>
      <button id="oneway-tab">
        <i class="fas fa-arrow-right"></i> One-way
      </button>
      <button id="multicity-tab">
        <i class="fas fa-map-marker-alt"></i> Multi-city
      </button>
    </div>

    <!-- Economy Class Dropdown (Always Visible) -->
    <div class="economy-dropdown">
      <label for="class"><i class="fas fa-chair"></i> Class:</label>
      <select id="class">
        <option value="economy">Economy Class</option>
        <option value="premium-economy">Premium Economy Class</option>
        <option value="business">Business Class</option>
        <option value="first">First Class</option>
      </select>
    </div>

    <!-- Roundtrip Search Form -->
    <div class="search-box" id="roundtrip-form">
      <div class="search-input-group">
        <i class="fas fa-plane-departure"></i>
        <input type="text" id="leaving-from" placeholder="Leaving from">
      </div>
      <div class="search-input-group">
        <i class="fas fa-plane-arrival"></i>
        <input type="text" id="going-to" placeholder="Going to">
      </div>
      <div class="search-input-group">
        <i class="fas fa-calendar-alt"></i>
        <input type="date" id="departure-date">
      </div>
      <div class="search-input-group">
        <i class="fas fa-calendar-alt"></i>
        <input type="date" id="return-date">
      </div>
      <div class="search-input-group">
        <i class="fas fa-users"></i>
        <select id="passengers">
          <option value="1">1 traveler</option>
          <option value="2">2 travelers</option>
          <option value="3">3 travelers</option>
          <option value="4">4 travelers</option>
        </select>
      </div>
      <button class="search-btn">
        <i class="fas fa-search"></i> Search Flights
      </button>
    </div>

    <!-- One-way Search Form -->
    <div class="search-box" id="oneway-form" style="display: none;">
      <div class="search-input-group">
        <i class="fas fa-plane-departure"></i>
        <input type="text" id="oneway-leaving-from" placeholder="Leaving from">
      </div>
      <div class="search-input-group">
        <i class="fas fa-plane-arrival"></i>
        <input type="text" id="oneway-going-to" placeholder="Going to">
      </div>
      <div class="search-input-group">
        <i class="fas fa-calendar-alt"></i>
        <input type="date" id="oneway-departure-date">
      </div>
      <div class="search-input-group">
        <i class="fas fa-users"></i>
        <select id="oneway-passengers">
          <option value="1">1 traveler</option>
          <option value="2">2 travelers</option>
          <option value="3">3 travelers</option>
          <option value="4">4 travelers</option>
        </select>
      </div>
      <button class="search-btn">
        <i class="fas fa-search"></i> Search Flights
      </button>
    </div>

    <!-- Multi-city Search Form -->
    <div class="search-box" id="multicity-form" style="display: none;">
      <div class="flight-segment">
        <div class="search-input-group">
          <i class="fas fa-plane-departure"></i>
          <input type="text" id="multicity-leaving-from-1" placeholder="Leaving from">
        </div>
        <div class="search-input-group">
          <i class="fas fa-plane-arrival"></i>
          <input type="text" id="multicity-going-to-1" placeholder="Going to">
        </div>
        <div class="search-input-group">
          <i class="fas fa-calendar-alt"></i>
          <input type="date" id="multicity-departure-date-1">
        </div>
      </div>
      <div class="flight-segment">
        <div class="search-input-group">
          <i class="fas fa-plane-departure"></i>
          <input type="text" id="multicity-leaving-from-2" placeholder="Leaving from">
        </div>
        <div class="search-input-group">
          <i class="fas fa-plane-arrival"></i>
          <input type="text" id="multicity-going-to-2" placeholder="Going to">
        </div>
        <div class="search-input-group">
          <i class="fas fa-calendar-alt"></i>
          <input type="date" id="multicity-departure-date-2">
        </div>
      </div>
      <div class="search-input-group">
        <i class="fas fa-users"></i>
        <select id="multicity-passengers">
          <option value="1">1 traveler</option>
          <option value="2">2 travelers</option>
          <option value="3">3 travelers</option>
          <option value="4">4 travelers</option>
        </select>
      </div>
      <button class="search-btn">
        <i class="fas fa-search"></i> Search Flights
      </button>
    </div>

    <!-- Additional Options -->
    <div class="additional-options">
      <label><input type="checkbox"> <i class="fas fa-hotel"></i> Add a place to stay</label>
    </div>
  </section>

  <!-- Offers Section -->
  <section class="offers">
    <h2>Promotions, deals, and special offers for you</h2>
    <div class="offer-card">
      <img src="images/offer1.jpg" alt="Offer 1">
      <div class="offer-content">
        <h3>Save on flights worldwide</h3>
        <p>Start your year with a sense of adventure, saving 15% or more with Early 2024 Deals.</p>
        <button class="offer-btn">Save 15% or more</button>
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
