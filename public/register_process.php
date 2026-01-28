<?php
// This is a placeholder file for demonstration purposes
// In a real application, you would process the form data and store it in a database

// Simulate processing delay
sleep(1);

// Get form data
$fullname = $_POST['fullname'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validate data
$errors = [];

if (empty($fullname)) {
    $errors[] = 'Full name is required';
}

if (empty($email)) {
    $errors[] = 'Email is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format';
}

if (empty($password)) {
    $errors[] = 'Password is required';
} elseif (strlen($password) < 6) {
    $errors[] = 'Password must be at least 6 characters';
}

if ($password !== $confirm_password) {
    $errors[] = 'Passwords do not match';
}

// Return response
header('Content-Type: application/json');

if (count($errors) > 0) {
    echo json_encode([
        'success' => false,
        'errors' => $errors
    ]);
} else {
    echo json_encode([
        'success' => true,
        'message' => 'Registration successful! Welcome to Easybooking.com'
    ]);
}
?>
