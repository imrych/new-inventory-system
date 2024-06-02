<?php
include 'includes/config.php';

// Check if order_id and status are set in the POST request
if(isset($_POST['order_id'], $_POST['status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Only proceed if status is 'delivered'
    if ($status === 'delivered') {
        // Debugging: Log received data
        file_put_contents('debug.log', "Received order_id: $order_id, status: $status\n", FILE_APPEND);

        // Retrieve order details
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $order_sql = "SELECT product, quantity FROM `order` WHERE order_id = ?";
        $stmt = $conn->prepare($order_sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($product_id, $quantity);
        $stmt->fetch();
        $stmt->close();

        // Debugging: Log retrieved data
        file_put_contents('debug.log', "Retrieved product_id: $product_id, quantity: $quantity\n", FILE_APPEND);

        // Check if product already exists in inventory
        $inventory_sql = "SELECT inventory_id, quantity FROM inventory WHERE inventory_id = ?";
        $stmt = $conn->prepare($inventory_sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            // Product exists, update quantity
            $stmt->bind_result($inventory_id, $inventory_quantity);
            $stmt->fetch();
            $new_quantity = $inventory_quantity + $quantity;
            $update_sql = "UPDATE inventory SET quantity = ? WHERE inventory_id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("ii", $new_quantity, $inventory_id);
            $stmt->execute();
        } else {
            // Product doesn't exist, insert new row
            $insert_sql = "INSERT INTO inventory (inventory_id, quantity) VALUES (?, ?)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("ii", $product_id, $quantity);
            $stmt->execute();
        }
        echo "success";
    } else {
        echo "failed";
    }
}
?>
