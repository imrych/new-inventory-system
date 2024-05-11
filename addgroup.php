<?php include 'nav.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="csss/addgroup.css">
    <title>Manage Group</title>
</head>
<body>
<div class=" top-nav">
        <h1>Manage Group</h1>
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
    <h4>Add New Group</h4>
        <div class="input-box">
            <label>Group Name</label>
            <input type="text" placeholder="Enter group name">
        </div>
        <div class="input-box">
            <label>Group Level</label>
            <input type="text"  placeholder="Enter group level">
        </div>

        <div class="input-box">
            <label>Status</label>
            <div class="column">
                <div class="select-box">
                    <select>
                    <option value="" disabled selected>Select Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </div>

    <button>
     Submit
    </button>

</form>
</div>
<script>
        // Open .dropdown-container by default
        document.querySelector(".dropdown-container").style.display = "block";

</script>
</body>
</html>