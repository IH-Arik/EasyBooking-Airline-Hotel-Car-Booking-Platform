<?php
$pageTitle = "Add Your Property";
require_once 'includes/db_connect.php';
require_once 'includes/session.php';

// Redirect if not logged in
requireLogin();

$success = false;
$errors = [];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price_per_night = floatval($_POST['price_per_night'] ?? 0);
    
    // Validate inputs
    if (empty($name)) {
        $errors[] = "Property name is required";
    }
    
    if (empty($location)) {
        $errors[] = "Location is required";
    }
    
    if (empty($description)) {
        $errors[] = "Description is required";
    }
    
    if ($price_per_night <= 0) {
        $errors[] = "Price per night must be greater than zero";
    }
    
    // Handle image upload
    $image_url = 'images/hotel1.jpg'; // Default image
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = $_FILES['image']['type'];
        
        if (!in_array($file_type, $allowed_types)) {
            $errors[] = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
        } else {
            $upload_dir = 'uploads/';
            
            // Create directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_name = uniqid() . '_' . $_FILES['image']['name'];
            $upload_path = $upload_dir . $file_name;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                $image_url = $upload_path;
            } else {
                $errors[] = "Failed to upload image";
            }
        }
    }
    
    // If no errors, insert property into database
    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("INSERT INTO hotels (name, location, description, price_per_night, rating, image_url) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $location, $description, $price_per_night, 0, $image_url]);
            
            $success = true;
            
            // Clear form data
            $name = $location = $description = '';
            $price_per_night = 0;
        } catch (PDOException $e) {
            $errors[] = "Failed to add property: " . $e->getMessage();
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

  <!-- Add Property Section -->
  <section class="add-property">
    <div class="container">
      <h1>Add Your Property</h1>
      <p>Fill in the details below to list your property on Easybooking.com</p>
      
      <?php if ($success): ?>
        <div class="alert alert-success">
          Your property has been added successfully! Our team will review it shortly.
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
      
      <form method="post" action="" enctype="multipart/form-data">
        <div class="input-group">
          <label for="name">Property Name</label>
          <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($name ?? ''); ?>">
        </div>
        
        <div class="input-group">
          <label for="location">Location</label>
          <input type="text" id="location" name="location" required value="<?php echo htmlspecialchars($location ?? ''); ?>">
        </div>
        
        <div class="input-group">
          <label for="description">Description</label>
          <textarea id="description" name="description" rows="5" required><?php echo htmlspecialchars($description ?? ''); ?></textarea>
        </div>
        
        <div class="input-group">
          <label for="price_per_night">Price Per Night ($)</label>
          <input type="number" id="price_per_night" name="price_per_night" min="1" step="0.01" required value="<?php echo $price_per_night ?? ''; ?>">
        </div>
        
        <div class="input-group">
          <label for="image">Property Image</label>
          <input type="file" id="image" name="image">
          <small>Recommended size: 800x600 pixels. Max file size: 2MB.</small>
        </div>
        
        <button type="submit" class="submit-btn">Add Property</button>
      </form>
    </div>
  </section>

  <style>
    .add-property {
      max-width: 800px;
      margin: 50px auto;
      padding: 0 20px;
    }
    
    .add-property h1 {
      text-align: center;
      margin-bottom: 10px;
    }
    
    .add-property p {
      text-align: center;
      margin-bottom: 30px;
      color: #666;
    }
    
    .add-property form {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .input-group {
      margin-bottom: 20px;
    }
    
    .input-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    
    .input-group input,
    .input-group textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    
    .input-group textarea {
      resize: vertical;
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
      width: 100%;
      transition: background-color 0.3s;
    }
    
    .submit-btn:hover {
      background-color: #ff5252;
    }
  </style>

<?php include 'includes/footer.php'; ?>
