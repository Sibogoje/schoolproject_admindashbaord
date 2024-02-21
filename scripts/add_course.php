<?php
// Start the session and include the database configuration
session_start();
require_once '../config.php'; // Adjust the path as needed to point to your config file

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize the input data
    $name = $conn->real_escape_string(trim($_POST['courseName']));
    $year = $conn->real_escape_string(trim($_POST['year']));
    $classroom = $conn->real_escape_string(trim($_POST['classroom']));
    $department = $conn->real_escape_string(trim($_POST['department']));


    // Prepare an INSERT statement
    $query = "INSERT INTO courses (name, year, department, classroom) VALUES (?, ?)";

    if($stmt = $conn->prepare($query)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssss", $className, $year, $department, $classroom);

        // Attempt to execute the prepared statement
        if($stmt->execute()) {
            // Respond with a success message
            echo json_encode(array("status" => "success", "message" => "Course added successfully."));
        } else {
            // Respond with an error message
            echo json_encode(array("status" => "error", "message" => "Error adding Course."));
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
