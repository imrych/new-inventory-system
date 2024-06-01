<?php 
include 'nav.php';
include 'topnav.php';
include 'includes/connection.php';

if(isset($_POST['submit'])){
    $Name = $_POST['name'];
    $Username = $_POST['username'];
    $Password = $_POST['password'];
    $User_role = $_POST['user_role'];

    // Check if the combination of Name and Username already exists in the database
    $check_query = "SELECT * FROM `manage_user` WHERE `name`='$Name' AND `username`='$Username'";
    $result = mysqli_query($conn, $check_query);

    if(mysqli_num_rows($result) > 0) {
        // If the record already exists, send back the specific error message
        echo "This already exists in the database.";
        exit(); // Stop further execution of the script
    } else {
        // Insert the new record into the database
        $q = "INSERT INTO `manage_user` (`name`, `username`, `password`, `user_role`) VALUES ('$Name', '$Username', '$Password', '$User_role')";
        $query = mysqli_query($conn, $q);

        if($query) {
            // Set a session variable to indicate success
            $_SESSION['success_message'] = "Successfully added new user!!";
            echo "success"; // Indicate successful insertion
            exit(); // Stop further execution of the script
        } else {
            echo "Error: " . mysqli_error($conn);
            exit(); // Stop further execution of the script
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/addgroup.css">
    <title>Add New User</title>

<script>
function addUser() {
    var form = document.getElementById('addUserForm');
    var formData = new FormData(form);
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'adduser.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = xhr.responseText.trim();
            if (response === 'success') {
                alert('Successfully added new user!!');
                window.location.reload(); // Reload the page after successful submission
            } else {
                alert("This already exists in the database"); // Generic error message
            }
        }
    };
    xhr.send(formData);
}
</script>

</head>

<body>   
<div class="container">
    <form id="addUserForm" class="form">
    <button class="close-btn" onclick="window.location.href='manageuser.php'">&times;</button>
        <h4>Add New User</h4>
        <div class="input-box">
            <label>Name</label>
            <input type="text" name="name" placeholder="Enter your name" required>
        </div>
        <div class="input-box">
            <label>Username</label>
            <input type="text" name="username" placeholder="Enter your username" required>
        </div>
        <div class="input-box">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
        </div>
        <div class="input-box">
            <label>User Role</label>
            <div class="column">
                <div class="select-box">
                    <select name="user_role" required>
                        <option value="" disabled selected>Select Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Stock Clerk">Stock Clerk</option>
                        <option value="Cashier">Cashier</option>
                    </select>
                </div>
            </div>
        </div>
        <button type="button" onclick="addUser()" name="submit">Submit</button>
    </form>
</div>
</body>
</html>