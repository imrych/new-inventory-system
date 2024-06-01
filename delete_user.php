<?php
include "includes/connection.php";

$response = array();

if (isset($_POST['id'])) {
    $Id = $_POST['id'];

    // Prepare and execute the DELETE statement
    $sql = "DELETE FROM manage_user WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $Id);

    if ($stmt->execute()) {
        // Deletion successful
        $response['success'] = true;
        $response['message'] = "User deleted successfully";
    } else {
        // Error handling
        $response['success'] = false;
        $response['message'] = "Failed to delete user. Please try again.";
        $response['error'] = $conn->error;
    }
} else {
    // No ID provided
    $response['success'] = false;
    $response['message'] = "No user ID provided for deletion.";
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
