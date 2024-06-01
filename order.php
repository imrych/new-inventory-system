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
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "includes/update_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    if (response === 'success') {
                        toastr.success("Status updated successfully.");
                        // Check if the status is 'delivered'
                        if (status === 'delivered') {
                            notifyUser(order_id); // Call the notifyUser function
                            // Subtract quantity from inventory
                            subtractQuantity(order_id);
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

        // Function to notify user when order is delivered
        function notifyUser(order_id) {
            toastr.info("Order " + order_id + " has been delivered!");
        }

        // Function to subtract quantity from inventory
        function subtractQuantity(order_id) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "includes/subtract_quantity.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    if (response === 'success') {
                        toastr.success("Quantity subtracted from inventory successfully.");
                    } else {
                        toastr.error("Failed to subtract quantity from inventory.");
                    }
                } else if (xhr.readyState === 4) {
                    toastr.error("An error occurred while subtracting quantity from inventory.");
                }
            };
            xhr.send("order_id=" + order_id);
        }

        function editOrder(order_id) {
            window.location.href = "editorder.php?id=" + order_id;
        }

        function deleteOrder(order_id) {
            if (confirm("Are you sure you want to delete this order?")) {
                window.location.href = "deleteorder.php?id=" + order_id;
            }
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
                        <th>Product</th>
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

                            echo "<tr>";
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
                                    <button onclick=\"editOrder(" . $row["order_id"] . ")\" style=\"margin-right: 0px; padding: 3px 9px;\">Edit</button>
                                    <button onclick=\"deleteOrder(" . $row["order_id"] . ")\" style=\"margin-right: 0px; padding: 3px 9px;\">Delete</button>
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
