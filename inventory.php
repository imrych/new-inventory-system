<?php include 'nav.php'; ?>

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

    <button type="button" onclick="location.href='addproduct.php'">Add New Product</a></button>

    <div class="group_names">
        <div class="group_content">
            <h2>Inventory</h2>
            <table class="group_table">
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
                <tr>
                    <td>1</td>
                    <td>Admin</td>
                    <td>1</td>
                    <td><buton>Active</button></td>
                    <td>Y/N</td>

                </tr>
                <tr>
                    <td>Banana</td>
                    <td>1</td>
                    <td>115</td>
                    <td>Active</td>
                    <td>Y/N</td>
                </tr>
                <tr>
                    <td class="border-bottom-left">Mango</td>
                    <td>1</td>
                    <td>111</td>
                    <td>Active</td>
                    <td class="border-bottom-right">Y/N</td>
                </tr>
            </table>
        </div>

</body>
</html>