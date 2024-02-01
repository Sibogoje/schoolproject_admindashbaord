<?php
require_once '../config.php'; // Ensure this points to your database configuration file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $firstName = $conn->real_escape_string(trim($_POST['firstName']));
    $lastName = $conn->real_escape_string(trim($_POST['lastName']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = $conn->real_escape_string(trim($_POST['password']));
    
    // Hash the password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare SQL and bind parameters
    $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, username, password_hash) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstName, $lastName, $email, $username, $passwordHash);
    
    if ($stmt->execute()) {
        echo "Registration successful!";
        // Redirect or inform the user of success
    } else {
        echo "Error: " . $stmt->error;
        // Handle error
    }
    $stmt->close();
}
$conn->close();
?>
