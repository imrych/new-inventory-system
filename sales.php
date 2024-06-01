<?php 
include 'includes/config.php';
include 'nav.php';
include 'topnav.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
                        echo "<td>" . $row["sale_size"] . "</td>";
                        echo "<td>" . $row["sold_quantity"] . "</td>";
                        echo "<td>" . $row["sale_total"] . "</td>";
                        echo "<td>" . $row["sale_date"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found</td></tr>";
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
