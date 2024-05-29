<?php include 'nav.php';
include 'topnav.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/sales.css">
    <title>Customer Table</title>
</head>

<body>
    <div class="group_names">
        <div class="group_content">
            <div class="title_and_button">
                <h2>Customer Table</h2>
                <!-- You can add buttons or actions here if needed -->
            </div>
            <table class="group_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Customer Order Date</th>
                        <th>Staff</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Fuji</td>
                        <td>Fruit Brand</td>
                        <td>Fruit</td>
                        <td>Large</td>
                        <td>15</td>
                        <td>2024-08-04</td>
                        <td>John Doe</td>
                        <td>Pending</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
