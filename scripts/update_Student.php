<?php
// Start session and include database configuration
session_start();
require_once '../config.php'; // Adjust the path as needed

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract and sanitize the input data
    $id = $conn->real_escape_string(trim($_POST['editId']));
    $editStudent_id = $conn->real_escape_string(trim($_POST['editStudent_id']));
    $editName = $conn->real_escape_string(trim($_POST['editName']));
    $editSurname = $conn->real_escape_string(trim($_POST['editSurname']));
    $editPhone = $conn->real_escape_string(trim($_POST['editPhone']));
    $editEmail = $conn->real_escape_string(trim($_POST['editEmail']));



    // Prepare the SQL statement
    $sql = "UPDATE `students` SET `name` = ?, `surname` = ?, `phone`, `email` = ? WHERE `id` = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the prepared statement
        $stmt->bind_param("sssi", $editName, $editSurname, $editPhone, $editEmail, $id);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Check if the update was successful
            if ($stmt->affected_rows > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Student updated successfully.']);
            } else {
                // If no rows were updated, send a different message
                echo json_encode(['status' => 'info', 'message' => 'No changes made to the Student.']);
            }
        } else {
            // Handle errors during execution
            echo json_encode(['status' => 'error', 'message' => 'Could not update Student.']);
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
