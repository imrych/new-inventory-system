<?php 
include 'includes/config.php';
include 'nav.php';
include 'topnav.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM customers";
$result = $conn->query($sql);
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
            <button type="button" onclick="location.href='addorder.php'">Add Customer's Order</button>
        </div>
        <table class="group_table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Brand</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Staff</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["cus_id"] . "</td>";
                        echo "<td>" . $row["cus_name"]. "</td>";
                        echo "<td>" . $row["cus_order-product"] . "</td>";
                        echo "<td>" . $row["cus_brand"] . "</td>";
                        echo "<td>" . $row["cus_size"] . "</td>";
                        echo "<td>" . $row["cus_quantity"] . "</td>";
                        echo "<td>" . $row["cus_date"] . "</td>";
                        echo "<td>" . $row["cus_stat"] . "</td>";
                        echo "<td>
                                <button onclick=\"window.location.href='editcustomer.php?id=" . $row["cus_id"] . "'\" style=\"margin-right: 0px; padding: 3px 9px; font-weight: bold; border-radius: 4px; background-color: #F59607; color: #ffffff; border: none;\">
                                    <i class=\"fa-regular fa-pen-to-square\" style=\"color: #ffffff;\"></i>
                                </button>
                                <button onclick=\"deleteCustomer(" . $row["cus_id"] . ")\" style=\"margin-right: 0px; padding: 3px 9px; font-weight: bold; border-radius: 4px; background-color: #DC2626; color: #ffffff; border: none;\">
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
// Close the database connection
$conn->close();
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