<?php
require_once 'includes/db_connect.php';
require_once 'includes/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>Easybooking.com</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar">
    <div class="logo">Easybooking.com</div>
    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="services.php">Services</a>
      <a href="contact.php">Contact</a>
      <a href="list-your-property.php">List your property</a>
      <?php if (isLoggedIn()): ?>
        <div class="user-menu">
          <a href="#" class="user-menu-btn">
            <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['fullname']); ?>
          </a>
          <div class="user-dropdown">
            <a href="my-bookings.php">My Bookings</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
          </div>
        </div>
      <?php else: ?>
        <a href="register.php" class="cta-button">Register</a>
        <a href="signin.php" class="cta-button">Sign in</a>
      <?php endif; ?>
    </div>
  </nav>
