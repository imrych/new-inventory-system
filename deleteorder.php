<?php
include 'includes/config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Initialize a message variable

if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']);
    
    // Prepare DELETE query
    $sql = "DELETE FROM `order` WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Bind parameters and execute the query
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $message = "Order deleted successfully.";
        } else {
            $message = "No order found with the specified ID.";
        }
        
        $stmt->close();
    } else {
        $message = "Failed to prepare statement.";
    }
} else {
    $message = "No order ID specified.";
}

$conn->close();

// Redirect back to order management with the message
header("Location: order.php?message=" . urlencode($message));
exit();
?>
