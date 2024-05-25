<?php 
include 'topnav.php';
include 'cashier_nav.php';
include 'includes/config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete_sql = "DELETE FROM inventory WHERE inventory_id = $id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Product deleted successfully'); window.location.href = 'cashier_inventory.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch inventory data
$sql = "SELECT * FROM inventory";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/inventory.css">
    <title>Manage Inventory</title>
</head>
<body>
<div class="group_names">
    <div class="group_content">
        <div class="title_and_button">
            <h2>Inventory</h2>
            <button type="button" onclick="location.href='cashier_addprod.php'">Add New Product</button>
        </div>
        <table class="group_table">
            <thead>
                <tr>
                    <th class="border-top-left">No.</th>
                    <th>Product Name</th>
                    <th>Brand</th>
                    <th>Categories</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th class="border-top-right">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["inventory_id"] . "</td>";
                        echo "<td>" . $row["product_name"] . "</td>";
                        echo "<td>" . $row["brand_name"] . "</td>";
                        echo "<td>" . $row["category"] . "</td>";
                        echo "<td>" . $row["size"] . "</td>";
                        echo "<td>" . $row["order_quantity"] . "</td>";
                        echo "<td>₱" . number_format($row["price"], 2) . "</td>";
                        echo "<td>
                        <button onclick=\"window.location.href='editprod_cashier.php?id=" . $row["inventory_id"] . "'\" style=\"margin-right: 0px; padding: 3px 9px; font-weight: bold; border-radius: 4px; background-color: #F59607; color: #ffffff; border: none;\">
                            <i class=\"fa-regular fa-pen-to-square\" style=\"color: #ffffff;\"></i>
                        </button>
                        <button onclick=\"deleteProduct(" . $row["inventory_id"] . ")\" style=\"margin-right: 0px; padding: 3px 9px; font-weight: bold; border-radius: 4px; background-color: #DC2626; color: #ffffff; border: none;\">
                            <i class=\"fa-solid fa-xmark\" style=\"color: #ffffff;\"></i>
                        </button>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No records found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
function deleteProduct(id) {
    if (confirm("Are you sure you want to delete this product?")) {
        window.location.href = 'cashier_inventory.php?action=delete&id=' + id;
    }
}
</script>
</body>
</html>
