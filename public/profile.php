<?php
$pageTitle = "My Profile";
require_once 'includes/db_connect.php';
require_once 'includes/session.php';

// Redirect if not logged in
requireLogin();

// Get user data
$user = getCurrentUser();

$success = false;
$errors = [];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validate inputs
    if (empty($fullname)) {
        $errors[] = "Full name is required";
    }
    
    // If user wants to change password
    if (!empty($current_password) || !empty($new_password) || !empty($confirm_password)) {
        // Verify current password
        $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user_data = $stmt->fetch();
        
        if (!password_verify($current_password, $user_data['password'])) {
            $errors[] = "Current password is incorrect";
        }
        
        if (empty($new_password)) {
            $errors[] = "New password is required";
        } elseif (strlen($new_password) < 6) {
            $errors[] = "New password must be at least 6 characters";
        }
        
        if ($new_password !== $confirm_password) {
            $errors[] = "New passwords do not match";
        }
    }
    
    // If no errors, update user data
    if (empty($errors)) {
        try {
            if (!empty($new_password)) {
                // Update name and password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET fullname = ?, password = ? WHERE user_id = ?");
                $stmt->execute([$fullname, $hashed_password, $_SESSION['user_id']]);
            } else {
                // Update name only
                $stmt = $conn->prepare("UPDATE users SET fullname = ? WHERE user_id = ?");
                $stmt->execute([$fullname, $_SESSION['user_id']]);
            }
            
            // Update session
            $_SESSION['fullname'] = $fullname;
            
            $success = true;
        } catch (PDOException $e) {
            $errors[] = "Update failed: " . $e->getMessage();
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

  <!-- Profile Section -->
  <section class="profile-container">
    <div class="profile-header">
      <h1>My Profile</h1>
      <p>Manage your account information</p>
    </div>
    
    <?php if ($success): ?>
      <div class="alert alert-success">
        Your profile has been updated successfully.
      </div>
    <?php endif; ?>
    
    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <ul>
          <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
    
    <div class="profile-content">
      <div class="profile-section">
        <h2>Account Information</h2>
        <form method="post" action="">
          <div class="input-group">
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
          </div>
          
          <div class="input-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
            <small>Email address cannot be changed</small>
          </div>
          
          <div class="profile-section">
            <h3>Change Password</h3>
            <div class="input-group">
              <label for="current_password">Current Password</label>
              <input type="password" id="current_password" name="current_password">
            </div>
            
            <div class="input-group">
              <label for="new_password">New Password</label>
              <input type="password" id="new_password" name="new_password">
            </div>
            
            <div class="input-group">
              <label for="confirm_password">Confirm New Password</label>
              <input type="password" id="confirm_password" name="confirm_password">
            </div>
          </div>
          
          <button type="submit" class="submit-btn">Save Changes</button>
        </form>
      </div>
    </div>
  </section>

  <style>
    .profile-container {
      max-width: 800px;
      margin: 50px auto;
      padding: 0 20px;
    }
    
    .profile-header {
      text-align: center;
      margin-bottom: 30px;
    }
    
    .profile-content {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }
    
    .profile-section {
      margin-bottom: 30px;
    }
    
    .profile-section h2 {
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
    }
    
    .profile-section h3 {
      margin: 20px 0 15px;
    }
    
    .input-group {
      margin-bottom: 20px;
    }
    
    .input-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    
    .input-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    
    .input-group small {
      display: block;
      margin-top: 5px;
      color: #666;
    }
    
    .submit-btn {
      background-color: #ff6b6b;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1rem;
      transition: background-color 0.3s;
    }
    
    .submit-btn:hover {
      background-color: #ff5252;
    }
  </style>

<?php include 'includes/footer.php'; ?>
