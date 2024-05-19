<?php include 'checker_nav.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/inventory.css">
    <title>Manage Group</title>
</head>

<body>
<div class=" top-nav">
        <h1>Manage Inventory</h1>
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
    <div class="group_names">
        <div class="group_content">
        <div class="title_and_button">
            <h2>Inventory</h2>
            <button type="button" onclick="location.href='addproduct.php'">Add New Product
            </button>
            </div>
            <table class="group_table">
                <thead>
                <tr>
                    <th class="border-top-left">Product ID</th>
                    <th>Brand Name</th>
                    <th>Categories</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Selling</th>
                    <th>Arrive Date</th>
                    <th>Expiration Date</th>
                    <th class="border-top-right">Supplier ID</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Fuji</td>
                    <td>Ping Ping</td>
                    <td>Apples</td>
                    <td>75</td>
                    <td>1500</td>
                    <td>35</td>
                    <td>2024-04-08</td>
                    <td>2024-04-08</td>
                    <td>Supplier 1</td>

                </tr>
                </tbody>
            </table>
        </div>

</body>
</html>