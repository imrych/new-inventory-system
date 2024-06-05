<?php 
include 'includes/config.php';
include 'nav.php';
include 'topnav.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from customers table
$fetch_customers_sql = "SELECT * FROM customers";
$customers_result = $conn->query($fetch_customers_sql);

if ($customers_result->num_rows > 0) {
    while($customer_row = $customers_result->fetch_assoc()) {
        $product = $customer_row['product'];
        $brand = $customer_row['brand'];
        $size = $customer_row['size'];
        $quantity = $customer_row['quantity'];
        $order_date = $customer_row['order_date'];
        $price = $customer_row['price'];

        // Check if the record already exists in the sales table
        $check_sales_sql = "SELECT * FROM sales WHERE sale_product = '$product' AND sales_brand = '$brand' AND sale_size = '$size' AND sold_quantity = '$quantity' AND sale_date = '$order_date'";
        $check_sales_result = $conn->query($check_sales_sql);

        if ($check_sales_result->num_rows == 0) {
            // Insert into sales table
            $insert_sales_sql = "INSERT INTO sales (sale_product, sales_brand, sale_size, sold_quantity, sale_date, sale_total)
                                 VALUES ('$product', '$brand', '$size', '$quantity', '$order_date', '$price')";
            $conn->query($insert_sales_sql);
        }
    }
}

$sql = "SELECT * FROM sales";
$result = $conn->query($sql);
$total_sales = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/sales.css">
    <title>Manage Sales</title>
</head>

<body>
<div class="group_names">
    <div class="group_content">
        <div class="title_and_button">
            <h2>Sales</h2>
            <form method="post" action="generate_pdf.php" target="_blank">
                <button type="submit">Print</button>
            </form>
        </div>
        <table class="group_table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Brand</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Total Sale</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $total_sales += $row["sale_total"];
                        echo "<tr>";
                        echo "<td>" . $row["sales_id"] . "</td>";
                        echo "<td>" . $row["sale_product"]. "</td>";
                        echo "<td>" . $row["sales_brand"] . "</td>";
                        echo "<td>" . $row["sale_size"] . "</td>";
                        echo "<td>" . $row["sold_quantity"] . "</td>";
                        echo "<td>₱" . number_format($row["sale_total"], 2) . "</td>";
                        echo "<td>" . date('M j, Y', strtotime($row['sale_date'])) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="total_sales">
            <strong>Total Sales: </strong>₱<?php echo number_format($total_sales, 2); ?>
        </div>
    </div>
</div>

<?php
// Close the database connection
$conn->close();
?>
</body>
</html>
