<?php
$pageTitle = "Contact Us";
require_once 'includes/db_connect.php';
require_once 'includes/session.php';

$success = false;
$errors = [];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Validate inputs
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($subject)) {
        $errors[] = "Subject is required";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    // If no errors, save message to database
    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $subject, $message]);
            
            $success = true;
            
            // Clear form data
            $name = $email = $subject = $message = '';
        } catch (PDOException $e) {
            $errors[] = "Failed to send message: " . $e->getMessage();
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

  <!-- Contact Section -->
  <section class="contact">
    <h1>Contact Us</h1>
    <p>Have questions or need assistance? We're here to help!</p>
    
    <?php if ($success): ?>
      <div class="alert alert-success">
        Your message has been sent successfully. We'll get back to you soon!
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
    
    <form class="contact-form" method="post" action="contact.php">
      <div class="input-group">
        <label for="name">Your Name</label>
        <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($name ?? ''); ?>">
      </div>
      
      <div class="input-group">
        <label for="email">Your Email</label>
        <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($email ?? ''); ?>">
      </div>
      
      <div class="input-group">
        <label for="subject">Subject</label>
        <input type="text" id="subject" name="subject" required value="<?php echo htmlspecialchars($subject ?? ''); ?>">
      </div>
      
      <div class="input-group">
        <label for="message">Message</label>
        <textarea id="message" name="message" rows="5" required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
      </div>
      
      <button type="submit" class="submit-btn">Send Message</button>
    </form>
    
    <div class="contact-info">
      <p><strong>Email:</strong> support@easybooking.com</p>
      <p><strong>Phone:</strong> +1 (555) 123-4567</p>
      <p><strong>Address:</strong> 123 Travel Street, Tourism City, TC 12345</p>
    </div>
  </section>

<?php include 'includes/footer.php'; ?>
