<?php
include 'nav.php';
include 'topnav.php';
include 'includes/config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from 'order' table
$sql = "SELECT o.order_id, i.product_name AS product, s.sup_brand AS brand, o.category, o.size, o.quantity, i.price AS price, o.staff, o.order_date, o.status 
        FROM `order` o
        LEFT JOIN `inventory` i ON o.product = i.inventory_id
        LEFT JOIN `suppliers` s ON o.brand = s.sup_id";
$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/order.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <title>Manage Orders</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>

function updateStatus(order_id, status) {
    console.log("Updating status...");
    console.log("Order ID:", order_id);
    console.log("New status:", status);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "includes/update_inventory.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText;
            console.log("Response:", response);
            if (response === 'success') {
                toastr.success("Status updated successfully.");
                if (status === 'deliver') {
                    document.getElementById('order_row_' + order_id).remove();
                    console.log("Order status changed to delivered.");
                    alert("Order status changed to delivered.");
                }
            } else {
                toastr.error("Failed to update status.");
            }
        } else if (xhr.readyState === 4) {
            toastr.error("An error occurred. Please try again.");
        }
    };
    xhr.send("order_id=" + order_id + "&status=" + status);
}

</script>

</head>

<body>
    <div class="group_names">
        <div class="group_content">
            <div class="title_and_button">
                <h2>Orders</h2>
                <button type="button" onclick="location.href='addorder.php'">Add New Order</button>
            </div>
            <table class="group_table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Product name</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Staff</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Format the order_date
        $order_date = date("d M Y", strtotime($row["order_date"]));

        echo "<tr id='order_row_" . $row["order_id"] . "'>";
        echo "<td>" . $row["order_id"] . "</td>";
        echo "<td>" . $row["product"] . "</td>";
        echo "<td>" . $row["brand"] . "</td>";
        echo "<td>" . $row["category"] . "</td>";
        echo "<td>" . $row["size"] . "</td>";
        echo "<td>" . $row["quantity"] . "</td>";
        echo "<td>₱" . number_format($row["price"], 2) . "</td>"; // Display price in Pesos with ₱
        echo "<td>" . $row["staff"] . "</td>";
        echo "<td>" . $order_date . "</td>"; // Display formatted order date
        echo "<td>
            <select onchange=\"updateStatus(" . $row['order_id'] . ", this.value)\">
                <option value='pending'" . ($row['status'] == 'pending' ? ' selected' : '') . ">Pending</option>
                <option value='delivered'" . ($row['status'] == 'delivered' ? ' selected' : '') . ">Delivered</option>
            </select>
        </td>";
        echo "<td>
        <button onclick=\"window.location.href='editorder.php?id=" . $row["order_id"] . "'\" style=\"margin-right: 0px; padding: 3px 9px; font-weight: bold; border-radius: 4px; background-color: #F59607; color: #ffffff; border: none;\">

                <i class=\"fa-regular fa-pen-to-square\" style=\"color: #ffffff;\"></i>
            </button>
            <button onclick=\"deleteOrder(" . $row["order_id"] .")\" style=\"margin-right: 0px; padding: 3px 9px; font-weight: bold; border-radius: 4px; background-color: #DC2626; color: #ffffff; border: none;\">
                <i class=\"fa-solid fa-xmark\" style=\"color: #ffffff;\"></i>
            </button>
        </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='11'>No orders found</td></tr>";
}
?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<?php
$conn->close();
?>
