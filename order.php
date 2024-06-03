<?php
include 'nav.php'; 
include 'topnav.php';
include 'includes/connection.php';

// Fetch data from 'order' table
$sql = "SELECT o.order_id, i.product_name AS product, s.sup_brand AS brand, o.category, o.size, o.quantity, i.price AS price, o.staff, o.order_date, o.status 
        FROM `order` o
        LEFT JOIN inventory i ON o.product = i.inventory_id
        LEFT JOIN suppliers s ON o.brand = s.sup_id";

$result = $conn->query($sql);
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
       
function updateStatus(order_id, status, product, brand, category, size, quantity, price) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "includes/update_status.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText;
            if (response === 'success') {
                alert("Status updated successfully.");
                location.reload(); // Reload the page to reflect changes
            } else {
                alert("Failed to update status: " + response);
                location.reload(); 
            }
        }
    };
    xhr.send("order_id=" + order_id + "&status=" + status + "&product=" + encodeURIComponent(product) + "&brand=" + encodeURIComponent(brand) + "&category=" + encodeURIComponent(category) + "&size=" + encodeURIComponent(size) + "&quantity=" + quantity + "&price=" + price);

        function editOrder(order_id) {
            window.location.href = "editorder.php?id=" + order_id;
        }

        function deleteOrder(order_id) {
            if (confirm("Are you sure you want to delete this order?")) {
                window.location.href = "deleteorder.php?id=" + order_id;
            }
        }}
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
                        while($row = $result->fetch_assoc()) {
                            $order_id = $row['order_id'];
                            $product = addslashes($row['product']);
                            $brand = addslashes($row['brand']);
                            $category = addslashes($row['category']);
                            $size = addslashes($row['size']);
                            $quantity = $row['quantity'];
                            echo "<tr>";
                            echo "<td>" . $order_id . "</td>";
                            echo "<td>" . $product . "</td>";
                            echo "<td>" . $brand . "</td>";
                            echo "<td>" . $category . "</td>";
                            echo "<td>" . $size . "</td>";
                            echo "<td>" . $quantity . "</td>";
                            echo "<td>₱" . number_format($row["price"], 2) . "</td>";
                            echo "<td>" . $row["staff"] . "</td>";  
                            echo "<td>" . date("d M Y", strtotime($row["order_date"])) . "</td>";
                            
                            // Assuming $price is being fetched and formatted appropriately from the database
                            echo "<td>
                                    <select onchange=\"updateStatus(" . $order_id . ", this.value, '" . $product . "', '" . $brand . "', '" . $category . "', '" . $size . "', " . $quantity . ", " . $row["price"] . ")\">
                                        <option value='pending'" . ($row['status'] == 'pending' ? ' selected' : '') . ">Pending</option>
                                        <option value='delivered'" . ($row['status'] == 'delivered' ? ' selected' : '') . ">Delivered</option>
                                    </select>
                                  </td>";
                            
                            echo "<td>
                                    <button onclick=\"editOrder(" . $order_id . ")\" style=\"margin-right: 0px; padding: 3px 9px; font-weight: bold; border-radius: 4px; background-color: #F59607; color: #ffffff; border: none;\">
                                        <i class=\"fa-regular fa-pen-to-square\" style=\"color: #ffffff;\"></i>
                                    </button>
                                    <button onclick=\"deleteOrder(" . $order_id . ")\" style=\"margin-right: 0px; padding: 3px 9px; font-weight: bold; border-radius: 4px; background-color: #DC2626; color: #ffffff; border: none;\">
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

