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
    $price = $_POST['price'];

    $errors = [];

    if (empty($product_name) || empty($brand_name) || empty($category) || empty($size) || empty($quantity) || empty($price)) {
        $errors[] = "All fields are required.";
    }

    // Validate price format
    $price_regex = "/^\₱?\d{1,6}(\.\d{1,2})?$/";
    if (!preg_match($price_regex, $price)) {
        $errors[] = "Price must be a number with a maximum of 6 digits and up to 2 decimal places, including a pesos sign.";
    }

    if (empty($errors)) {
        // Format price to two decimal places
        $formatted_price = (float) preg_replace("/[^0-9.]/", "", $price);

        // Insert into database
        $sql = "INSERT INTO inventory (product_name, brand_name, category, size, order_quantity, price) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssidd", $product_name, $brand_name, $category, $size, $quantity, $formatted_price);

        if ($stmt->execute()) {
            // Success message to display on inventory.php
            echo "<script>alert('Successfully added product to the system'); window.location.href = 'inventory.php';</script>";
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
