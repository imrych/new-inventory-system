<?php include 'cashier_nav.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/addproduct.css">
    <title>Manage Group</title>
</head>
<body>
<div class=" top-nav">
        <h1>Add Order</h1>
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

    <div class="container">
    <form action="#" class="form">
    <h4>Add New Order</h4>
    <div class="row1">
        <div class="input-box">
            <label>Customer ID</label>
            <input type="text" placeholder="Enter product id">
        </div>
        <div class="input-box">
            <label>Product ID</label>
            <input type="text"  placeholder="Enter size">
        </div>
</div>
<div class="row2">
        <div class="input-box">
            <label>Size</label>
            <input type="text"  placeholder="Enter supplier">
        </div>
        <div class="input-box">
            <label>Sold</label>
            <input type="text"  placeholder="Enter categories">
        </div>
</div>
<div class="row3">
        <div class="input-box">
            <label>Status</label>
            <div class="column">
                <div class="select-box">
                    <select>
                    <option value="" disabled selected>Select Staus</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </div>
</div>
    <button>
     Submit
    </button>

</form>
</div>
</div>
<script>
        // Open .dropdown-container by default
        document.querySelector(".dropdown-container").style.display = "block";

</script>
</body>
</html>