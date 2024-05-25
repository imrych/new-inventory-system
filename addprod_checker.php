<?php
include 'topnav.php';
include 'checker_nav.php';
include_once 'includes/config.php';
include_once 'includes/addprodprocess_checker.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch supplier brands
$suppliers_sql = "SELECT sup_brand FROM suppliers";
$suppliers_result = $conn->query($suppliers_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/addproduct.css">
<title>Add Product</title>

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
<div class="container">
    <h4>Add New Product</h4>
    <form name="productForm" action="addprod_checker.php" method="post" onsubmit="return validateForm()">
        <div class="row1">
            <div class="input-box">
                <label for="product_name">Product Name</label>
                <input type="text" id="product_name" name="product_name" placeholder="Enter product name" required>
            </div>
            <div class="input-box">
                <label for="size">Size</label>
                <input type="text" id="size" name="size" placeholder="Enter size" required>
            </div>
            <div class="input-box">
                <label for="quantity">Quantity</label>
                <input type="text" id="quantity" name="quantity" placeholder="Enter Quantity" required>
            </div>
        </div>
        <div class="row2">
            <div class="input-box">
                <label for="category">Category</label>
                <input type="text" id="category" name="category" placeholder="Enter category" required>
            </div>
            <div class="input-box select-box">
                <label for="brand_name">Brand Name</label>
                <select id="brand_name" name="brand_name" required>
                    <option value="" disabled selected>Select a brand</option>
                    <?php
                    if ($suppliers_result->num_rows > 0) {
                        while($row = $suppliers_result->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['sup_brand']) . "'>" . htmlspecialchars($row['sup_brand']) . "</option>";
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
                <label for="price">Price</label>
                <input type="text" id="price" name="price" placeholder="Enter Price" required oninput="formatPriceInput(event)">
            </div>
        </div>
        <button type="submit">Submit</button>
    </form>
</div>
</body>
</html>

<?php
$conn->close();
?>
