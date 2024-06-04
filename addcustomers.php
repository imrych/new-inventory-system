<?php
include 'includes/connection.php';
include 'nav.php';
include 'topnav.php';



if (isset($_POST['submit'])) {
    $customer_name = $_POST['customer_name'];
    $product = $_POST['product'];
    $brand = $_POST['brand_name'];
    $quantity = $_POST['quantity'];
    $size = $_POST['size'];
    $order_date = $_POST['order_date'];
    $staff = $_SESSION['name'];

    
    if ($conn) {
        // Prepare SQL statement
        $insert_sql = "INSERT INTO `customers` (customer_name, product, brand, size, quantity, order_date, staff) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        
        // Check if the statement was prepared successfully
        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("sssisss", $customer_name, $product, $brand, $size, $quantity, $order_date, $staff );
            
            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>alert('Order successfully added');</script>";
                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'customers.php';
                        }, 1000); // 1000 milliseconds delay
                      </script>";
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
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

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/addorder.css">
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
        <form name="orderForm" action="addcustomers.php" method="POST" class="form" onsubmit="return validateForm()">
            <h4>Add new customer</h4>
            <button type="button" class="custom-close-btn" onclick="window.location.href='customers.php'">
                <i class="fa-solid fa-xmark"></i>
            </button>
            
            <div class="row1">
                <div class="input-box">
                    <label>Customer Name</label>
                    <input type="text" name="customer_name" placeholder="Enter Customer Name" required>
                </div>
                <div class="input-box">
                    <label>Product</label>
                    <select name="product" required>
                        <option value="" disabled selected>Select Product</option>  
                        <?php
                        if ($inventory_result->num_rows > 0) {
                            while($row = $inventory_result->fetch_assoc()) {
                                echo "<option value='" . $row['inventory_id'] . "'>" . htmlspecialchars($row['product_name']) . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="input-box">
                    <label>Brand Name</label>
                    <select name="brand_name" required>
                        <option value="" disabled selected>Select Brand Name</option>
                        <?php
                        if ($brands_result->num_rows > 0) {
                            while($row = $brands_result->fetch_assoc()) {
                                echo "<option value='" . $row['sup_brand'] . "'>" . htmlspecialchars($row['sup_brand']) . "</option>";
                            }
                        }
                        ?>
                    </select>
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
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
</body>
</html>
