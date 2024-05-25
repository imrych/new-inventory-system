<?php
include 'cashier/cashier_nav.php'; 
include 'topnav.php';
include 'includes/config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product details for editing
$product = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql_product = "SELECT * FROM inventory WHERE inventory_id = $id";
    $result_product = $conn->query($sql_product);
    if ($result_product->num_rows > 0) {
        $product = $result_product->fetch_assoc();
    } else {
        echo "<script>alert('Product not found'); window.location.href = 'cashier/cashier_inventory.php';</script>";
        exit;
    }
}

// Fetch brand names from suppliers table
$sql_brands = "SELECT sup_brand FROM suppliers";
$result_brands = $conn->query($sql_brands);

if (!$result_brands) {
    echo "Error fetching brands: " . $conn->error;
    exit; 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/addproduct.css">
    <script>
        function validateForm() {
            return true;
        }

        function formatPriceInput(event) {
            var input = event.target;
            var value = input.value.replace(/[^0-9.]/g, '');
            if (value) {
                input.value = '₱' + parseFloat(value).toFixed(2);
            } else {
                input.value = '';
            }
        }
    </script>
</head>
<body>
<div class="container">
    <form name="productForm" action="cashier/editprod_cashier.php?id=<?php echo $product['inventory_id']; ?>" method="post" class="form" onsubmit="return validateForm()">
        <input type="hidden" name="id" value="<?php echo $product['inventory_id']; ?>">
        <div class="row1">
            <div class="input-box">
                <label>Product Name</label>
                <input type="text" name="product_name" placeholder="Enter product name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
            </div>
            <div class="input-box">
                <label>Size</label>
                <input type="text" name="size" placeholder="Enter size" value="<?php echo intval($product['size']); ?>" required>
            </div>
            <div class="input-box">
                <label>Quantity</label>
                <input type="text" name="quantity" placeholder="Enter Quantity" value="<?php echo intval($product['order_quantity']); ?>" required>
            </div>
        </div>
        <div class="row2">
            <div class="input-box">
                <label>Category</label>
                <input type="text" name="category" placeholder="Enter category" value="<?php echo htmlspecialchars($product['category']); ?>" required>
            </div>
            <div class="input-box select-box">
                <label for="brand_name">Brand Name</label>
                <select id="brand_name" name="brand_name" required>
                    <option value="" disabled>Select a brand</option>
                    <?php
                    // Populate brand name dropdown
                    if ($result_brands->num_rows > 0) {
                        while($row = $result_brands->fetch_assoc()) {
                            $selected = ($row['sup_brand'] == $product['brand_name']) ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($row['sup_brand']) . "' $selected>" . htmlspecialchars($row['sup_brand']) . "</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No brands available</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row3">
            <div class="input-box">
                <label>Price</label>
                <input type="text" name="price" placeholder="Enter Price" value="<?php echo '₱' . number_format($product['price'], 2); ?>" required oninput="formatPriceInput(event)">
            </div>
        </div>
        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>

<?php
// Handle form submission and database update here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $product_name = ucwords(strtolower(trim($_POST['product_name'])));
    $brand_name = ucwords(strtolower(trim($_POST['brand_name'])));
    $category = ucwords(strtolower(trim($_POST['category'])));
    $size = intval(trim($_POST['size']));
    $quantity = intval(trim($_POST['quantity']));
    $price = $_POST['price']; // Price is handled separately below for formatting

    $errors = [];

    // Validate inputs (same as your original validation logic)

    if (empty($errors)) {
        // Format price to two decimal places
        $formatted_price = (float) preg_replace("/[^0-9.]/", "", $price);

        // Update SQL query
        $sql_update = "UPDATE inventory SET 
                product_name='$product_name', 
                brand_name='$brand_name', 
                category='$category', 
                size='$size', 
                order_quantity='$quantity', 
                price='$formatted_price' 
                WHERE inventory_id='$id'";

        if ($conn->query($sql_update) === TRUE) {
            echo "<script>alert('Product updated successfully'); window.location.href = 'cashier/cashier_inventory.php';</script>";
            exit;
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
    }
}

$conn->close();
?>
