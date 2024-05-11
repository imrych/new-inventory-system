<?php include 'nav.php';
include 'includes/config.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM suppliers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/supplier.css">
    <title>Manage Supplier</title>
</head>

<body>
<div class=" top-nav">
        <h1>Suppliers</h1>
        <div class=user_and_date>
            <div class="dropdown">
                <div class="username">Avril Abelarde</div>
                <div class="dropdown-content">
                    <a href="#">Profile</a>
                    <a href="#">Settings</a>
                </div>
                </div>
            <div class="date">April 14, 2024</div>
        </div>
</div>
<div class="table-container">
    <div class="title_and_button">
        <h2>Supplier</h2>
        <button type="button" onclick="location.href='addsupplier.php'">Add New Supplier
        </button>
    </div>
        <?php

        // Display data in a table
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead><tr><th>Supplier ID</th><th>Name</th><th>Country</th><th>Phone Number</th><th>Brand</th></tr></thead>";
            while ($row = $result->fetch_assoc()) {
                echo "<tbody>";
                echo "<tr>";
                echo "<td>" . $row["sup_id"] . "</td>";
                echo "<td>" . $row["sup_name"] . "</td>";
                echo "<td>" . $row["sup_country"] . "</td>";
                echo "<td>" . $row["sup_num"] . "</td>";
                echo "<td>" . $row["sup_brand"] . "</td>";
                echo "</tr>";
                echo "</tbody>";
            }
            echo "</table>";
        } else {
            echo "No suppliers found";
        }
        // Close the database connection
        $conn->close();

        // Check if a message is present in the URL
        if (isset($_GET['message'])) {
            // Retrieve the message
            $message = $_GET['message'];
            // Display the message using JavaScript
            echo "<script>alert('$message');</script>";
        }
        ?>
</div>
</body>

</html>
