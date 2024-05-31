<?php
include 'nav.php';
include 'topnav.php';
include 'includes/config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to update order status
function updateStatus($order_id, $status, $conn) {
    // Prepare UPDATE query
    $sql = "UPDATE `order` SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Bind parameters and execute the query
        $stmt->bind_param("si", $status, $order_id);
        $stmt->execute();

        // Check if update was successful
        if ($stmt->affected_rows > 0) {
            $stmt->close(); // Close statement
            return true; // Update successful
        } else {
            $stmt->close(); // Close statement
            return false; // Update failed
        }
    } else {
        return false; // Statement preparation failed
    }
}

// Fetch data from 'order' table
$sql = "SELECT o.order_id, i.product_name AS product, s.sup_brand AS brand, o.category, o.size, o.quantity, o.staff, o.order_date, o.status 
        FROM `order` o
        LEFT JOIN `inventory` i ON o.product = i.inventory_id
        LEFT JOIN `suppliers` s ON o.brand = s.sup_id";
$result = $conn->query($sql);

if (!$result) {
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
    <title>Manage Orders</title>
    <script>
        function updateStatus(order_id, status) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "includes/update_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    if (response === 'success') {
                        alert("Status updated successfully.");
                        // Optional: Update UI as needed
                    } else {
                        alert("Failed to update status.");
                    }
                }
            };
            xhr.send("order_id=" + order_id + "&status=" + status);
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
                        <th>Staff</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["order_id"] . "</td>";
                            echo "<td>" . $row["product"] . "</td>";
                            echo "<td>" . $row["brand"] . "</td>";
                            echo "<td>" . $row["category"] . "</td>";
                            echo "<td>" . $row["size"] . "</td>";
                            echo "<td>" . $row["quantity"] . "</td>";
                            echo "<td>" . $row["staff"] . "</td>";  
                            echo "<td>" . $row["order_date"] . "</td>";
                            echo "<td>
                                    <select onchange=\"updateStatus(" . $row['order_id'] . ", this.value)\">
                                        <option value='pending'" . ($row['status'] == 'pending' ? ' selected' : '') . ">Pending</option>
                                        <option value='delivered'" . ($row['status'] == 'delivered' ? ' selected' : '') . ">Delivered</option>
                                    </select>
                                  </td>";
                            echo "<td>
                                    <button onclick=\"editOrder(" . $row["order_id"] . ")\" style=\"margin-right: 0px; padding: 3px 9px; font-weight: bold; border-radius: 4px; background-color: #F59607; color: #ffffff; border: none;\">
                                        <i class=\"fa-regular fa-pen-to-square\" style=\"color: #ffffff;\"></i>
                                    </button>
                                    <button onclick=\"deleteOrder(" . $row["order_id"] . ")\" style=\"margin-right: 0px; padding: 3px 9px; font-weight: bold; border-radius: 4px; background-color: #DC2626; color: #ffffff; border: none;\">
                                        <i class=\"fa-solid fa-xmark\" style=\"color: #ffffff;\"></i> 
                                    </button>                          
                                 </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>No orders found</td></tr>";
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
