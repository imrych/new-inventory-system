<?php
ob_start(); // Start output buffering

include 'includes/config.php';
include 'topnav.php';
include 'nav.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header('location: index.php');
    exit();
}

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($order_id === 0) {
    die("Invalid order ID.");
}

// Fetch order details
$order_sql = "SELECT * FROM `order` WHERE order_id = ?";
$stmt = $conn->prepare($order_sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows === 0) {
    die("Order not found.");
}

$order = $order_result->fetch_assoc();

// Fetch inventory data
$inventory_sql = "SELECT inventory_id, product_name FROM inventory";
$inventory_result = $conn->query($inventory_sql);

// Fetch categories
$categories_sql = "SELECT cat_name FROM categories";
$categories_result = $conn->query($categories_sql);

// Fetch suppliers
$suppliers_sql = "SELECT sup_id, sup_brand FROM suppliers";
$suppliers_result = $conn->query($suppliers_sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $cat_id = $_POST['cat_id'];
    $size = $_POST['size'];
    $brand_name = $_POST['brand_name'];
    $quantity = $_POST['quantity'];
    $status = 'Pending'; // Set status to Pending directly

    $update_sql = "UPDATE `order` SET product = ?, brand = ?, category = ?, size = ?, quantity = ?, status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("iisdiss", $product_id, $brand_name, $cat_id, $size, $quantity, $status, $order_id);

    if ($stmt->execute()) {
        echo "<script>alert('Order updated successfully'); window.location.href='order.php';</script>";
        exit();
    } else {
        echo "Error: " . $update_sql . "<br>" . $conn->error;
    }
}

$conn->close();
ob_end_flush(); // Send the buffer contents to the browser
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="css/addorder.css">
<title>Edit Order</title>
<script>
    function validateForm() {
        var size = document.forms["orderForm"]["size"].value;
        var quantity = document.forms["orderForm"]["quantity"].value;
        if (isNaN(size) || size <= 0) {
            alert("Size must be a positive number.");
            return false;
        }
        if (isNaN(quantity) || quantity <= 0) {
            alert("Quantity must be a positive number.");
            return false;
        }
        return true;
    }
</script>
</head>
<body>
<div class="container">
    <form name="orderForm" action="editorder.php?id=<?php echo $order_id; ?>" method="post" class="form" onsubmit="return validateForm()">
        <h4>Edit Order</h4>
        <div class="row1">
            <div class="input-box">
                <label>Product ID</label>
                <select name="product_id" required>
                    <option value="" disabled>Select Product</option>
                    <?php
                    if ($inventory_result->num_rows > 0) {
                        while ($row = $inventory_result->fetch_assoc()) {
                            $selected = $row['inventory_id'] == $order['product'] ? 'selected' : '';
                            echo "<option value='" . $row['inventory_id'] . "' $selected>" . htmlspecialchars($row['product_name']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="input-box">
                <label>Category</label>
                <select name="cat_id" required>
                    <option value="" disabled>Select Category</option>
                    <?php
                    if ($categories_result->num_rows > 0) {
                        while ($row = $categories_result->fetch_assoc()) {
                            $selected = $row['cat_name'] == $order['category'] ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($row['cat_name']) . "' $selected>" . htmlspecialchars($row['cat_name']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row2">
            <div class="input-box">
                <label>Size</label>
                <input type="number" name="size" placeholder="Enter Size" required value="<?php echo htmlspecialchars($order['size']); ?>">
            </div>
            <div class="input-box">
                <label>Brand Name</label>
                <select name="brand_name" required>
                    <option value="" disabled>Select Brand</option>
                    <?php
                    if ($suppliers_result->num_rows > 0) {
                        while ($row = $suppliers_result->fetch_assoc()) {
                            $selected = $row['sup_id'] == $order['brand'] ? 'selected' : '';
                            echo "<option value='" . $row['sup_id'] . "' $selected>" . htmlspecialchars($row['sup_brand']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row3">
            <div class="input-box">
                <label>Quantity</label>
                <input type="number" name="quantity" placeholder="Enter Quantity" required value="<?php echo htmlspecialchars($order['quantity']); ?>">
            </div>
        </div>
        <button type="submit">Submit</button>
    </form>
</div>
</body>
</html>
