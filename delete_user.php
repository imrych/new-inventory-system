<?php
include "includes/connection.php";

if (isset($_GET['id'])) {
    $Id = $_GET['id'];

    // Prepare and execute the DELETE statement
    $sql = "DELETE FROM manage_user WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $Id);

    if ($stmt->execute()) {
        // Deletion successful
        echo "<script>
                alert('User deleted successfully');
                window.location.href = '/new-inventory-system/manageuser.php';
              </script>";
        exit; // Exit after successful deletion
    } else {
        // Error handling
        echo "<script>
                alert('Failed to delete user. Please try again.');
                window.location.href = '/new-inventory-system/manageuser.php';
              </script>";
        exit; // Exit after failed deletion
    }
} else {
    // Redirect if user ID is not provided
    header('location:/new-inventory-system/manageuser.php');
    exit;
}
?>
