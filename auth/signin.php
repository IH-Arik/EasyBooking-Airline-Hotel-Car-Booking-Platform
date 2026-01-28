<?php
$pageTitle = "Sign In";
require_once 'includes/db_connect.php';
require_once 'includes/session.php';

$errors = [];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validate inputs
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    
    // If no errors, check credentials
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT user_id, fullname, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['fullname'] = $user['fullname'];
            
            // Redirect to home page
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Invalid email or password";
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

  <!-- Services Section -->
  <div class="services">
    <a href="index.php">&#127976;<b>Hotels</b></a>
    <a href="flights.php">&#128746;<b>Flights</b></a>
    <a href="car-rentals.php">&#128662;<b>Car Rentals</b></a>
  </div>

  <!-- Sign In Section -->
  <section class="auth-container">
    <div class="auth-box">
      <h2>Sign In</h2>
      <p>Access your account to manage your bookings and get personalized recommendations</p>
      
      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      
      <form method="post" action="signin.php">
        <div class="input-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? '  id="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
        </div>
        
        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="auth-btn">Sign In</button>
      </form>
      
      <div class="switch-link">
        <p>Don't have an account? <a href="register.php">Register</a></p>
        <p><a href="forgot-password.php">Forgot your password?</a></p>
      </div>
    </div>
  </section>

<?php include 'includes/footer.php'; ?>
