<?php
$pageTitle = "Register";
require_once 'includes/db_connect.php';
require_once 'includes/session.php';

$errors = [];
$success = false;

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validate inputs
    if (empty($fullname)) {
        $errors[] = "Full name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    // Check if email already exists
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = "Email already exists";
        }
    }
    
    // If no errors, insert user into database
    if (empty($errors)) {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$fullname, $email, $hashed_password]);
            
            $success = true;
            
            // Auto login after registration
            $_SESSION['user_id'] = $conn->lastInsertId();
            $_SESSION['fullname'] = $fullname;
            
            // Redirect to home page
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            $errors[] = "Registration failed: " . $e->getMessage();
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

  <!-- Registration Section -->
  <section class="register">
    <div class="register-container">
      <h1>Create an Account</h1>
      <p>Join Easybooking.com for the best travel deals and personalized recommendations</p>
      
      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      
      <?php if ($success): ?>
        <div class="alert alert-success">
          Registration successful! You are now logged in.
        </div>
      <?php endif; ?>
      
      <form method="post" action="register.php">
        <div class="input-group">
          <i class="fas fa-user"></i>
          <input type="text" name="fullname" placeholder="Full Name" required value="<?php echo htmlspecialchars($_POST['fullname'] ?? ''); ?>">
        </div>
        
        <div class="input-group">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" placeholder="Email Address" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
        </div>
        
        <div class="input-group">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" placeholder="Password" required>
        </div>
        
        <div class="input-group">
          <i class="fas fa-lock"></i>
          <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        </div>
        
        <button type="submit" class="register-btn">Register</button>
      </form>
      
      <p>Already have an account? <a href="signin.php">Sign In</a></p>
    </div>
  </section>

<?php include 'includes/footer.php'; ?>
