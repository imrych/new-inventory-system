<?php
include 'nav.php';
include 'includes/config.php';

$message = 'Succesfully Added';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sup_name = $_POST['sup_name'];
    $sup_country = $_POST['sup_country'];
    $sup_num = $_POST['sup_num'];
    $sup_brand = $_POST['sup_brand'];

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO suppliers (sup_name, sup_country, sup_num, sup_brand)
            VALUES ('$sup_name', '$sup_country', '$sup_num', '$sup_brand')";

    if ($conn->query($sql) === TRUE) {
        $message = "Supplier successfully added to the database!";
        echo "<script>window.location.href='supplier.php?message=$message';</script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/addsupplier.css">
    <title>Add New Supplier</title>
</head>

<body>
    <div class="top-nav">
        <h1>Add New Supplier</h1>
        <div class="user-and-date">
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

    <div class="container">
    <form action="addsupplier.php" class="form" method="POST">
    <button class="close-btn" onclick="window.location.href='supplier.php'">&times;</button>
    <h4>Add New Supplier</h4>
        <div class="input-box">
            <label>Supplier Name</label>
            <input type="text" name="sup_name" placeholder="Enter supplier name" required>
        </div>
        <div class="input-box">
            <label>Country</label>
            <input type="text" name="sup_country" placeholder="Enter country" required>
        </div>
        <div class="input-box">
            <label>Phone Number</label>
            <input type="text" name="sup_num" placeholder="Enter phone number" required>
        </div>
        <div class="input-box">
            <label>Brand</label>
            <input type="text" name="sup_brand" placeholder="Enter brand" required>
        </div>
        <button type="submit">Submit</button>
    </form>
    </div>


</body>

</html>