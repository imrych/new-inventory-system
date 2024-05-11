<?php include 'nav.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/addgroup.css">
    <title>Manage Group</title>
</head>
<body>
<div class=" top-nav">
        <h1>Manage Users</h1>
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

    <div class="container">
    <form action="#" class="form">
    <h4>Add New User</h4>
        <div class="input-box">
            <label>Name</label>
            <input type="text" placeholder="Enter group name">
        </div>
        <div class="input-box">
            <label>Username</label>
            <input type="text"  placeholder="Enter group level">
        </div>
        <div class="input-box">
            <label>Password</label>
            <input type="text"  placeholder="Enter group level">
        </div>
        <div class="input-box">
            <label>User Role</label>
            <div class="column">
                <div class="select-box">
                    <select>
                    <option value="" disabled selected>Select Role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
            </div>
        </div>

    <button>
     Submit
    </button>

</form>
</div>
</body>
</html>