<?php
session_start();
include '../config.php'; // Include your database connection settings

$username = $_POST['username'];
$password = $_POST['password'];

$response = ['status' => 'error', 'message' => 'Invalid username or password'];

if (!empty($username) && !empty($password)) {
    $stmt = $conn->prepare("SELECT * FROM adminlogin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password_hash'])) {            
            //set logged in session
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['admin_id'];
            $_SESSION['username'] = $row['username'];
            // Set any other session variables you need
            $response['status'] = 'success';
            $response['message'] = 'Login successful';
        }
    }
    $stmt->close();
}

echo json_encode($response);
?>
