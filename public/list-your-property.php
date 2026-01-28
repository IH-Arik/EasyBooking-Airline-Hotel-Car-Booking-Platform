<?php
$pageTitle = "List Your Property";
require_once 'includes/db_connect.php';
require_once 'includes/session.php';
?>
<?php include 'includes/header.php'; ?>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <h1>List your property on <span class="highlight">Easybooking.com</span></h1>
      <p>Join thousands of property owners who are already earning with us</p>
      <a href="#register-box" class="cta-button">Get Started</a>
    </div>
  </section>

  <!-- Register Box -->
  <section id="register-box" class="register-box">
    <h2>Start earning today</h2>
    <ul>
      <li><i class="fas fa-check-circle"></i> Reach millions of travelers</li>
      <li><i class="fas fa-check-circle"></i> Manage bookings easily</li>
      <li><i class="fas fa-check-circle"></i> 24/7 support</li>
      <li><i class="fas fa-check-circle"></i> Free to list, pay only when you get bookings</li>
    </ul>
    <?php if (isLoggedIn()): ?>
      <a href="add-property.php" class="cta-button">List Your Property</a>
    <?php else: ?>
      <a href="register.php" class="cta-button">Create an Account</a>
    <?php endif; ?>
  </section>

  <!-- Features Section -->
  <section class="features">
    <h2>Why list with us?</h2>
    <div class="features-grid">
      <div class="feature-item">
        <i class="fas fa-globe"></i>
        <h3>Global Reach</h3>
        <p>Connect with millions of travelers looking for unique places to stay around the world.</p>
      </div>
      <div class="feature-item">
        <i class="fas fa-money-bill-wave"></i>
        <h3>Earn Extra Income</h3>
        <p>Set your own prices and availability. We only charge a small commission when you get bookings.</p>
      </div>
      <div class="feature-item">
        <i class="fas fa-shield-alt"></i>
        <h3>Secure Platform</h3>
        <p>Our secure platform ensures safe transactions and protects your personal information.</p>
      </div>
      <div class="feature-item">
        <i class="fas fa-headset"></i>
        <h3>24/7 Support</h3>
        <p>Our dedicated support team is available around the clock to help you with any questions or issues.</p>
      </div>
    </div>
  </section>

  <style>
    .hero {
      background-image: url('images/hero-bg.jpg');
      background-size: cover;
      background-position: center;
      color: white;
      text-align: center;
      padding: 100px 20px;
      position: relative;
    }
    
    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
    }
    
    .hero-content {
      position: relative;
      z-index: 1;
    }
    
    .highlight {
      color: #ff6b6b;
    }
    
    .register-box {
      max-width: 600px;
      margin: 50px auto;
      padding: 30px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    
    .register-box h2 {
      margin-bottom: 20px;
      color: #333;
    }
    
    .register-box ul {
      text-align: left;
      margin-bottom: 30px;
    }
    
    .register-box ul li {
      margin-bottom: 10px;
    }
    
    .register-box ul li i {
      color: #ff6b6b;
      margin-right: 10px;
    }
  </style>

<?php include 'includes/footer.php'; ?>
