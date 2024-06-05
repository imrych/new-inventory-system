<?php
include 'includes/config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = ucwords(strtolower(trim($_POST['product_name'])));
    $brand_name = ucwords(strtolower(trim($_POST['brand_name'])));
    $category = ucwords(strtolower(trim($_POST['category'])));
    $size = intval(trim($_POST['size']));
    $quantity = intval(trim($_POST['quantity']));
    
    $errors = [];

    if (empty($product_name) || empty($brand_name) || empty($category) || empty($size) || empty($quantity)) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        // Insert into database
        $sql = "INSERT INTO inventory (product_name, brand_name, category, size, order_quantity) 
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $product_name, $brand_name, $category, $size, $quantity);

        if ($stmt->execute()) {
            // Success message to display on inventory.php
            echo "<script>alert('Successfully added product to the system'); window.location.href = 'cashier_inventory.php';</script>";
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
    } else {
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
    }
}

$conn->close();
?>
