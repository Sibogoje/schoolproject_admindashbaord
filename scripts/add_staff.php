<?php
// Start the session and include the database configuration
session_start();
require_once '../config.php'; // Adjust the path as needed to point to your config file

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize the input data
    $name = $conn->real_escape_string(trim($_POST['staffName']));
    $email = $conn->real_escape_string(trim($_POST['staffEmail']));
    $role = $conn->real_escape_string(trim($_POST['staffRole']));
    // password make it to be first 2 letters of the name 
    $password = substr($name, 0, 2) . "AUCE1234";
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $last_login = date("Y-m-d H:i:s"); // Set the last login to the current date/time

    // Prepare an INSERT statement
    $query = "INSERT INTO staff (name, email, role, password_hash, last_login) VALUES (?, ?, ?, ?, ?)";

    if($stmt = $conn->prepare($query)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sssss", $name, $email, $role, $password_hash, $last_login);

        // Attempt to execute the prepared statement
        if($stmt->execute()) {
            // Respond with a success message
            echo json_encode(array("status" => "success", "message" => "Staff member added successfully."));
        } else {
            // Respond with an error message
            echo json_encode(array("status" => "error", "message" => "Error adding staff member."));
        }

        // Close statement
        $stmt->close();
    } else {
        echo json_encode(array("status" => "error", "message" => "Error preparing the query."));
    }

    // Close connection
    $conn->close();
} else {
    // Respond with an error if not a POST request
    echo json_encode(array("status" => "error", "message" => "Invalid request method."));
}
?>
