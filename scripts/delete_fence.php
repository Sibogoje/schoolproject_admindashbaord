<?php
require_once '../config.php'; // Include your database configuration file

if(isset($_POST['id'])) {
    $id = $conn->real_escape_string($_POST['id']);

    // Prepare a delete statement
    $sql = "DELETE FROM geo_fence WHERE id = ?";
    
    if($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        
        if($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Geo Fence deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error deleting Geo fence.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error preparing the query.']);
    }
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID not provided.']);
}
?>
