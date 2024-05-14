<?php include 'nav.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/managegroup.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <title>Manage Group</title>
</head>

<body>
<div class=" top-nav">
        <h1>Manage Group</h1>
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

    <div class="group_names">
        <div class="group_content">
            <div class="title_and_button">
            <h2>Groups</h2>
            <button type="button" onclick="location.href='addgroup.php'">Add New Group</a>
            </button>
            </div>
            <table class="group_table">
                <thead>
                <tr>
                    <th class="border-top-left">#</th>
                    <th>Group Name</th>
                    <th>Group Level</th>
                    <th>Status</th>
                    <th class="border-top-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Admin</td>
                    <td>1</td>
                    <td><button style="margin-right: 0px; padding: 3px 16px; font-weight: 0px; border-radius: 4px; background-color: #A0CE90; color: #ffffff; border: none;
">Active</button></td>
                    <td>
                    <button style="margin-right: 0px; padding: 3px 9px ; font-weight: 0px; border-radius: 4px; background-color: #F59607; color: #ffffff; border: none;
"><i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i></button>
                    <button style="margin-right: 0px; padding: 3px 9px; font-weight: 0px; border-radius: 4px; background-color: #DC2626; color: #ffffff; border: none;
"><i class="fa-solid fa-xmark" style="color: #ffffff;"></i></button>
                    </td>
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