<?php
$pageTitle = "Page Not Found";
require_once 'includes/db_connect.php';
require_once 'includes/session.php';
?>
<?php include 'includes/header.php'; ?>

  <!-- 404 Section -->
  <section class="error-page">
    <div class="container">
      <h1>404</h1>
      <h2>Page Not Found</h2>
      <p>The page you are looking for does not exist or has been moved.</p>
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
