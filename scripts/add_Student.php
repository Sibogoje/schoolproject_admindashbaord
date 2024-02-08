<?php
// Start the session and include the database configuration
session_start();
require_once '../config.php'; // Adjust the path as needed to point to your config file

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize the input data
    $Student_No = intval($_POST['studentNo']);
    $StudentName = $conn->real_escape_string(trim($_POST['studentName']));
    $StudentSurname = $conn->real_escape_string(trim($_POST['studentSurname']));
    $StudentEmail = $conn->real_escape_string(trim($_POST['studentEmail']));
    $StudentPhone = $conn->real_escape_string(trim($_POST['studentPhone']));

    // Prepare an INSERT statement
    $query = "INSERT INTO students (student_id, name, surname, phone, email) VALUES (?, ?, ?, ?, ?)";

    if($stmt = $conn->prepare($query)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("issss", $Student_No, $StudentName, $StudentSurname, $StudentPhone, $StudentEmail);

        // Attempt to execute the prepared statement
        if($stmt->execute()) {
            // Respond with a success message
            echo json_encode(array("status" => "success", "message" => "Student added successfully."));
        } else {
            // Respond with an error message
            echo json_encode(array("status" => "error", "message" => "Error adding Student."));
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
