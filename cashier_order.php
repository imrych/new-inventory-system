<?php include 'cashier_nav.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/order.css">
    <title>Manage Group</title>
</head>

<body>
<div class=" top-nav">
        <h1>Manage Order</h1>
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
            <h2>Orders</h2>
            <button type="button" onclick="location.href='cashier_addorder.php'">Add New Order
            </button>
            </div>
            <table class="group_table">
                <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Sold</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Avril</td>
                    <td>Fuji</td>
                    <td>75</td>
                    <td>15</td>
                    <td>Pickup/Not</td>
                </tr>
                </tbody>
            </table>
        </div>

</body>
</html>