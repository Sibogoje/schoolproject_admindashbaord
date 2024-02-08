<?php
// Start session and include database configuration
session_start();
require_once '../config.php'; // Adjust the path as needed

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract and sanitize the input data
    $id = $conn->real_escape_string(trim($_POST['editId']));
    $name = $conn->real_escape_string(trim($_POST['editName']));
    $editDepartment = $conn->real_escape_string(trim($_POST['editDepartment']));
    $editFaculty = $conn->real_escape_string(trim($_POST['editFaculty']));

    // Prepare the SQL statement
    $sql = "UPDATE `class` SET `name` = ?, `department` = ?, `faculty` = ? WHERE `id` = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the prepared statement
        $stmt->bind_param("sssi", $name, $editDepartment, $editFaculty, $id);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Check if the update was successful
            if ($stmt->affected_rows > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Class updated successfully.']);
            } else {
                // If no rows were updated, send a different message
                echo json_encode(['status' => 'info', 'message' => 'No changes made to the Class.']);
            }
        } else {
            // Handle errors during execution
            echo json_encode(['status' => 'error', 'message' => 'Could not update Class.']);
        }

        // Close statement
        $stmt->close();
    } else {
        // Handle errors in preparing the statement
        echo json_encode(['status' => 'error', 'message' => 'Could not prepare SQL statement.']);
    }

    // Close database connection
    $conn->close();
} else {
    // If not a POST request, send an error message
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
