<?php
include 'nav.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/customers.css">
    <title>Customers</title>
</head>

<body>
<div class=" top-nav">
        <h1>Manage Customer</h1>
        <div class=user_and_date>
            <div class="dropdown">
                <div class="username">Avril Abelarde</div>
                <div class="dropdown-content">
                    <a href="profile.php">Profile</a>
                    <a href="#">Settings</a>
                </div>
            </div>
            <div class="date">April 14, 2024</div>
        </div>
</div>

<button type="button" onclick="location.href='addcustomers.php'">
    Add New Customers
</button>

</div>
</body>
</html>