<?php 
include 'nav.php'; 
include 'includes/config.php';

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product details for editing
$product = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM inventory WHERE inventory_id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "<script>alert('Product not found'); window.location.href = 'inventory.php';</script>";
    }
}

// Update product details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $product_name = ucwords(strtolower(trim($_POST['product_name'])));
    $brand_name = ucwords(strtolower(trim($_POST['brand_name'])));
    $category = ucwords(strtolower(trim($_POST['category'])));
    $size = intval(trim($_POST['size']));
    $quantity = intval(trim($_POST['quantity']));
    $price = str_replace('₱', '', trim($_POST['price']));
    $price = number_format((float)$price, 2, '.', '');

    $errors = [];

    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $product_name)) {
        $errors[] = "Product Name can only contain letters and numbers.";
    }
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $brand_name)) {
        $errors[] = "Brand Name can only contain letters and numbers.";
    }
    if (!preg_match('/^[a-zA-Z\s]+$/', $category)) {
        $errors[] = "Category can only contain letters.";
    }
    if (!preg_match('/^\d{1,3}$/', $size)) {
        $errors[] = "Size must be an integer with a maximum of 3 digits.";
    }
    if (!preg_match('/^\d{1,3}$/', $quantity)) {
        $errors[] = "Quantity must be an integer with a maximum of 3 digits.";
    }
    if (!preg_match('/^\d{1,6}(\.\d{1,2})?$/', $price)) {
        $errors[] = "Price must be a number with a maximum of 6 digits and up to 2 decimal places.";
    }

    if (empty($errors)) {
        $sql = "UPDATE inventory SET 
                product_name='$product_name', 
                brand_name='$brand_name', 
                category='$category', 
                size='$size', 
                order_quantity='$quantity', 
                price='$price' 
                WHERE inventory_id='$id'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Product updated successfully'); window.location.href = 'inventory.php';</script>";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/addproduct.css">
    <title>Edit Product</title>
    <script>
        function validateForm() {
            var productName = document.forms["productForm"]["product_name"].value.trim();
            var brandName = document.forms["productForm"]["brand_name"].value.trim();
            var category = document.forms["productForm"]["category"].value.trim();
            var size = document.forms["productForm"]["size"].value.trim();
            var quantity = document.forms["productForm"]["quantity"].value.trim();
            var price = document.forms["productForm"]["price"].value.trim();

            var productNameRegex = /^[a-zA-Z0-9\s]+$/;
            var brandNameRegex = /^[a-zA-Z0-9\s]+$/;
            var categoryRegex = /^[a-zA-Z\s]+$/;
            var sizeRegex = /^\d{1,3}$/;
            var quantityRegex = /^\d{1,3}$/;
            var priceRegex = /^\₱?\d{1,6}(\.\d{1,2})?$/;

            if (!productNameRegex.test(productName)) {
                alert("Product Name can only contain letters and numbers.");
                return false;
            }
            if (!brandNameRegex.test(brandName)) {
                alert("Brand Name can only contain letters and numbers.");
                return false;
            }
            if (!categoryRegex.test(category)) {
                alert("Category can only contain letters.");
                return false;
            }
            if (!sizeRegex.test(size)) {
                alert("Size must be an integer with a maximum of 3 digits.");
                return false;
            }
            if (!quantityRegex.test(quantity)) {
                alert("Quantity must be an integer with a maximum of 3 digits.");
                return false;
            }
            if (!priceRegex.test(price)) {
                alert("Price must be a number with a maximum of 6 digits and up to 2 decimal places, including a pesos sign.");
                return false;
            }

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
    <div class="top-nav">
        <h1>Edit Product</h1>
        <div class="user_and_date">
            <div class="dropdown">
                <div class="username">Avril Abelarde</div>
                <div class="dropdown-content">
                    <a href="profile.php">Profile</a>
                    <a href="#">Settings</a>
                </div>
            </div>
            <div class="date">April 14, 2024</div>
        </div>
    </div>

    <div class="container">
        <form name="productForm" action="editproduct.php" method="post" class="form" onsubmit="return validateForm()">
            <h4>Edit Product</h4>
            <input type="hidden" name="id" value="<?php echo $product['inventory_id']; ?>">
            <div class="row1">
                <div class="input-box">
                    <label>Product Name</label>
                    <input type="text" name="product_name" placeholder="Enter product name" value="<?php echo $product['product_name']; ?>" required>
                </div>
                <div class="input-box">
                    <label>Size</label>
                    <input type="text" name="size" placeholder="Enter size" value="<?php echo $product['size']; ?>" required>
                </div>
                <div class="input-box">
                    <label>Quantity</label>
                    <input type="text" name="quantity" placeholder="Enter Quantity" value="<?php echo $product['order_quantity']; ?>" required>
                </div>
            </div>
            <div class="row2">
                <div class="input-box">
                    <label>Categories</label>
                    <input type="text" name="category" placeholder="Enter categories" value="<?php echo $product['category']; ?>" required>
                </div>
                <div class="input-box">
                    <label>Brand Name</label>
                    <input type="text" name="brand_name" placeholder="Enter Brand Name" value="<?php echo $product['brand_name']; ?>" required>
                </div>
            </div>
            <div class="row3">
                <div class="input-box">
                    <label>Price</label>
                    <input type="text" name="price" placeholder="Enter Price" value="₱<?php echo number_format($product['price'], 2); ?>" required oninput="formatPriceInput(event)">
                </div>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
