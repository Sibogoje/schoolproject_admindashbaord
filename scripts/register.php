<?php
require_once '../config.php'; // Ensure this points to your database configuration file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $firstName = $conn->real_escape_string(trim($_POST['firstName']));
    $lastName = $conn->real_escape_string(trim($_POST['lastName']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $username = $conn->real_escape_string(trim($_POST['username']));
    $role = $conn->real_escape_string(trim($_POST['role']));
    $password = $conn->real_escape_string(trim($_POST['password']));
    
    // Hash the password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare SQL and bind parameters
    $stmt = $conn->prepare("INSERT INTO adminlogin (`first_name`, `last_name`, `email`, `username`, `role`, `password_hash`) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $firstName, $lastName, $email, $username, $role, $passwordHash);
    
    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Registration Successful';
    } else {
        $response['message'] = 'Registration Failed';

    }
    $stmt->close();
}

echo json_encode($response);
$conn->close();
?>
