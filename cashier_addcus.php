<?php
include 'includes/connection.php';
include 'cashier_nav.php';
include 'topnav.php';

if (isset($_POST['submit'])) {
    $customer_name = $_POST['customer_name'];
    $product = $_POST['product'];
    $brand = $_POST['brand_name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $size = $_POST['size'];
    $order_date = $_POST['order_date'];
    $staff = $_SESSION['name'];

    if ($conn) {
        // Start a transaction
        $conn->begin_transaction();

        // Fetch the price of the selected product from the inventory
        $price_sql = "SELECT price FROM inventory WHERE product_name = ? AND brand_name = ? AND category = ? AND size = ?";
        $price_stmt = $conn->prepare($price_sql);
        if ($price_stmt) {
            $price_stmt->bind_param("sssi", $product, $brand, $category, $size);
            $price_stmt->execute();
            $price_result = $price_stmt->get_result();
            if ($price_result->num_rows > 0) {
                $row = $price_result->fetch_assoc();
                $price = $row['price'];

                // Calculate total price
                $total_price = $price * $quantity;

                // Prepare SQL statement to insert into customers table
                $insert_sql = "INSERT INTO customers (customer_name, product, brand, category, size, quantity, order_date, staff, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insert_sql);
                if ($stmt) {
                    // Bind parameters and execute insert statement
                    $stmt->bind_param("ssssisssd", $customer_name, $product, $brand, $category, $size, $quantity, $order_date, $staff, $total_price);
                    if ($stmt->execute()) {
                        // Update the inventory quantity
                        $update_sql = "UPDATE inventory SET order_quantity = order_quantity - ? WHERE product_name = ? AND brand_name = ? AND category = ? AND size = ?";
                        $update_stmt = $conn->prepare($update_sql);
                        if ($update_stmt) {
                            $update_stmt->bind_param("isssi", $quantity, $product, $brand, $category, $size);
                            if ($update_stmt->execute()) {
                                $conn->commit(); // Commit the transaction
                                echo "<script>alert('Order successfully added. Total Price: ₱$total_price');</script>";
                                echo "<script>
                                        setTimeout(function() {
                                            window.location.href = 'cashier_cus.php';
                                        }, 1000); // 1000 milliseconds delay
                                      </script>";
                                exit();
                            } else {
                                $conn->rollback(); // Rollback the transaction if update fails
                                echo "Error updating inventory quantity: " . $update_stmt->error;
                            }
                            $update_stmt->close();
                        } else {
                            $conn->rollback(); // Rollback the transaction if update statement preparation fails
                            echo "Error preparing update statement: " . $conn->error;
                        }
                    } else {
                        $conn->rollback(); // Rollback the transaction if customer insertion fails
                        echo "Error adding customer order: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "Error preparing statement: " . $conn->error;
                }
            } else {
                echo "Error fetching price: Product not found in inventory.";
            }
            $price_stmt->close();
        } else {
            echo "Error preparing price statement: " . $conn->error;
        }
    } else {
        echo "Error: Unable to connect to database.";
    }
}

// Fetch inventory data
$inventory_sql = "SELECT inventory_id, product_name FROM inventory";
$inventory_result = $conn->query($inventory_sql);

// Fetch brand names from the database
$brands_sql = "SELECT sup_id, sup_brand FROM suppliers";
$brands_result = $conn->query($brands_sql);

// Fetch categories from the database
$categories_sql = "SELECT DISTINCT category FROM inventory";
$categories_result = $conn->query($categories_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/addcustomers.css">
    <title>Add New Customer</title>
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
        <form name="orderForm" action="cashier_addcus.php" method="POST" class="form" onsubmit="return validateForm()">
        <div class="button_title">
    <h4>Add New Customer</h4>
    <button type="button" class="custom-close-btn" style=" width: 40px;
    height: 40px;
    background: #f2af4a;
    border: none;
    outline: none;
    color: #FFFFFF;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: 10px;" onclick="window.location.href='cashier_cus.php'">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
            
            <div class="row1">
                <div class="input-box">
                    <label>Customer Name</label>
                    <input type="text" name="customer_name" placeholder="Enter Customer Name" required>
                </div>
                <div class="input-box">
                    <label>Product</label>
                    <div class="column">
                    <div class="select-box">
                    <select name="product" required>
                        <option value="" disabled selected>Select Product</option>  
                        <?php
                        if ($inventory_result->num_rows > 0) {
                            while($row = $inventory_result->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($row['product_name']) . "'>" . htmlspecialchars($row['product_name']) . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                </div>
                </div>
                <div class="input-box">
                    <label>Brand Name</label>
                    <div class="column">
                    <div class="select-box">
                    <select name="brand_name" required>
                        <option value="" disabled selected>Select Brand Name</option>
                        <?php
                        if ($brands_result->num_rows > 0) {
                            while($row = $brands_result->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($row['sup_brand']) . "'>" . htmlspecialchars($row['sup_brand']) . "</option>";
                            }
                        }
                        ?>
                    </select>
                    </div>
                    </div>
                </div>
                <div class="input-box">
                    <label>Category</label>
                    <div class="column">
                    <div class="select-box">
                    <select name="category" required>
                        <option value=""disabled selected>Select Category</option>
                        <?php
                        if ($categories_result->num_rows > 0) {
                            while($row = $categories_result->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($row['category']) . "'>" . htmlspecialchars($row['category']) . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                </div>
                </div>
            </div>
            <div class="row2">
                <div class="input-box">
                    <label>Size</label>
                    <input type="number" name="size" placeholder="Enter Size" required>
                </div>
                <div class="input-box">
                    <label>Quantity</label>
                    <input type="number" name="quantity" placeholder="Enter Quantity" required>
                </div>
            </div>
            <div class="row3">
                <div class="input-box">
                    <label>Order Date</label>
                    <input type="date" name="order_date" required>
                </div>
            </div>
            <button type="submit" name="submit" style=" width: 20%;
    padding: 5px;
    background: #f2af4a;
    border: none;
    outline: none;
    color: #FFFFFF;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    border-radius: 10px;
    margin-left: 80%;">Submit</button>
        </form>
    </div>
</body>
</html>
                        