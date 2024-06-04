<?php
include 'connection.php';

// Check if all required data is received
if (isset($_POST['order_id'], $_POST['status'], $_POST['product'], $_POST['brand'], $_POST['category'], $_POST['size'], $_POST['quantity'], $_POST['price'])) {
    // Extract POST data
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $product = $_POST['product'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];
    $size = $_POST['size'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Update order status
    $update_order_sql = "UPDATE `order` SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($update_order_sql);
    if (!$stmt) {
        echo 'error preparing statement: ' . $conn->error;
        exit();
    }
    $stmt->bind_param("si", $status, $order_id);

    if ($stmt->execute()) {
        if ($status == 'delivered') {
            // Check if the product exists in inventory
            $check_inventory_sql = "SELECT * FROM inventory WHERE product_name = ? AND brand_name = ? AND category = ? AND size = ?";
            $stmt_check_inventory = $conn->prepare($check_inventory_sql);
            if (!$stmt_check_inventory) {
                echo 'error preparing check inventory statement: ' . $conn->error;
                exit();
            }
            $stmt_check_inventory->bind_param("ssss", $product, $brand, $category, $size);
            $stmt_check_inventory->execute();
            $result = $stmt_check_inventory->get_result();

            if ($result->num_rows > 0) {
                // Product exists, update the quantity and price
                $row = $result->fetch_assoc();
                $new_quantity = $row['order_quantity'] + $quantity; // Adjusted column name for quantity
                $update_inventory_sql = "UPDATE inventory SET order_quantity = ?, price = ? WHERE inventory_id = ?";
                $stmt_update_inventory = $conn->prepare($update_inventory_sql);
                if (!$stmt_update_inventory) {
                    echo 'error preparing update inventory statement: ' . $conn->error;
                    exit();
                }
                $stmt_update_inventory->bind_param("idi", $new_quantity, $price, $row['inventory_id']);
                if ($stmt_update_inventory->execute()) {
                    echo 'success';
                } else {
                    echo 'error updating inventory: ' . $stmt_update_inventory->error;
                }
            } else {
                // Product does not exist, insert a new row
                $insert_inventory_sql = "INSERT INTO inventory (product_name, brand_name, category, size, order_quantity, price) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_insert_inventory = $conn->prepare($insert_inventory_sql);
                if (!$stmt_insert_inventory) {
                    echo 'error preparing insert inventory statement: ' . $conn->error;
                    exit();
                }
                $stmt_insert_inventory->bind_param("sssidi", $product, $brand, $category, $size, $quantity, $price);
                if ($stmt_insert_inventory->execute()) {
                    echo 'success';
                } else {
                    echo 'error inserting into inventory: ' . $stmt_insert_inventory->error;
                }
            }
        } else {
            echo 'success';
        }
    } else {
        echo 'error updating order: ' . $stmt->error;
    }
    $stmt->close();
} else {
    echo 'missing_data';
}

$conn->close();
?>
