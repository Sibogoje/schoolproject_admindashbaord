<?php
// Start the session and include the database configuration
session_start();
require_once '../config.php'; // Adjust the path as needed to point to your config file

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize the input data
    $className = $conn->real_escape_string(trim($_POST['class']));
    $A = $conn->real_escape_string(trim($_POST['A']));
    $B = $conn->real_escape_string(trim($_POST['B']));
    $C = $conn->real_escape_string(trim($_POST['C']));
    $D = $conn->real_escape_string(trim($_POST['D']));

    // Prepare an INSERT statement
    $query = "INSERT INTO class (class, A, B, C, D) VALUES (?, ?, ?, ?, ?)";

    if($stmt = $conn->prepare($query)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sssss", $className, $A, $B, $C, $D);

        // Attempt to execute the prepared statement
        if($stmt->execute()) {
            // Respond with a success message
            echo json_encode(array("status" => "success", "message" => "Class Geo-Fence added successfully."));
        } else {
            // Respond with an error message
            echo json_encode(array("status" => "error", "message" => "Error adding Geo-fence."));
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
