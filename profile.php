<?php
include 'nav.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/profile.css">
    <title>Customers</title>
</head>

<body>
<div class=" top-nav">
        <h1>Edit Profiile</h1>
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
    <div class="profile_boxes">
        <div class="first_box">
            <h2>Change photo</h2>
                <img src="images/user.png" alt="user" class="user">
                <button type="button" onclick="location.href='addcustomers.php'">
                    Change Photo </button>
        </div>
        <div class="second_box">
            <h2>Edit my account</h2>
                <img src="images/user.png" alt="user" class="user">
                    <div class="input-box">
                        <label>Name</label>
                        <input type="text" name="sup_country" placeholder="Enter your new username" required>
                    </div>
                    <div class="input-box">
                        <label>Username</label>
                        <input type="text" name="sup_country" placeholder="Enter your new username" required>
                    </div>
                    <button type="button" onclick="location.href='addcustomers.php'">
                        Save Changes </button>
        </div>
    </div>
</body>
</html>