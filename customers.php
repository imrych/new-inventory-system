<?php 
include 'includes/config.php';
include 'nav.php';
include 'topnav.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

$sql = "SELECT * FROM customers";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: ". $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/customers.css">
    <title>Customer Table</title>
</head>

<body>
<div class="group_names">
    <div class="group_content">
        <div class="title_and_button">
            <h2>Customers</h2>
            <button type="button" onclick="location.href='addcustomers.php'">Add Customer's Order</button>
        </div>
        <table class="group_table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Staff</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>". $row["customer_id"]. "</td>";
                        echo "<td>". $row["customer_name"]. "</td>";
                        // Update the column names to match your actual table structure
                        echo "<td>". $row["product"]. "</td>";
                        echo "<td>". $row["brand"]. "</td>";
                        echo "<td>". $row["category"]. "</td>"; //category
                        echo "<td>". $row["size"]. "</td>";
                        echo "<td>". $row["quantity"]. "</td>";
                        echo "<td>". $row["price"]. "</td>";
                        echo "<td>". $row["order_date"]. "</td>";
                        echo "<td>". $row["staff"]. "</td>";
                        echo "<td>
                               
                                <button onclick=\"deleteCustomer(". $row["customer_id"]. ")\" style=\"margin-right: 0px; padding: 3px 9px; font-weight: bold; border-radius: 4px; background-color: #DC2626; color: #ffffff; border: none;\">
                                    <i class=\"fa-solid fa-xmark\" style=\"color: #ffffff;\"></i>
                                </button>
                                </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No records found</td></tr>";
                }
               ?>
            </tbody>
        </table>
    </div>
</div>

<?php
if ($conn->ping()) {
    $conn->close();
}
?>

<script>
    function deleteCustomer(id) {
        if (confirm("Are you sure you want to delete this customer?")) {
            window.location.href = 'deletecustomer.php?id=' + id;
        }
    }
</script>
</body>

</html>