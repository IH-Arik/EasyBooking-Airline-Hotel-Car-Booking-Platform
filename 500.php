<?php
$pageTitle = "Server Error";
require_once 'includes/db_connect.php';
require_once 'includes/session.php';
?>
<?php include 'includes/header.php'; ?>

  <!-- 500 Section -->
  <section class="error-page">
    <div class="container">
      <h1>500</h1>
      <h2>Server Error</h2>
      <p>Something went wrong on our end. Please try again later.</p>
      <a href="index.php" class="btn">Go to Homepage</a>
    </div>
  </section>

  <style>
    .error-page {
      text-align: center;
      padding: 100px 20px;
    }
    
    .error-page h1 {
      font-size: 6rem;
      color: #ff6b6b;
      margin-bottom: 20px;
    }
    
    .error-page h2 {
      font-size: 2rem;
      margin-bottom: 20px;
    }
    
    .error-page p {
      margin-bottom: 30px;
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
