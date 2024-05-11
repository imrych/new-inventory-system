<?php include 'nav.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/manageuser.css">
    <title>Manage Users</title>
</head>

<body>
<div class=" top-nav">
        <h1>Manage User</h1>
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
            <h2>Users</h2>
            <button type="button" onclick="location.href='adduser.php'">Add New User
            </button>
            </div>
            <table class="group_table">
                <thead>
                <tr>
                    <th class="border-top-left">#</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>User role</th>
                    <th>Status</th>
                    <th>Last Login</th>
                    <th class="border-top-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Alessandra</td>
                    <td>Ping</td>
                    <td>Admin</td>
                    <td><button style="margin-right: 0px; padding: 3px 16px; font-weight: 0px; border-radius: 4px; background-color: #A0CE90; color: #ffffff; border: none;
">Active</button></td>
                    <td>August 22, 2021, 7:05:06 am</td>
                    <td>                    <button style="margin-right: 0px; padding: 3px 9px ; font-weight: 0px; border-radius: 4px; background-color: #F59607; color: #ffffff; border: none;
"><i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i>

</button>
                    <button style="margin-right: 0px; padding: 3px 9px; font-weight: 0px; border-radius: 4px; background-color: #DC2626; color: #ffffff; border: none;
"><i class="fa-solid fa-xmark" style="color: #ffffff;"></i></button></td>
                </tr>
                <tbody>
            </table>
        </div>
        <script>
        // Open .dropdown-container by default
        document.querySelector(".dropdown-container").style.display = "block";

</script>
</body>
</html>