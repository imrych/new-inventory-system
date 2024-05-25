<?php 
include 'topnav.php';
include 'nav.php';
include "includes/connection.php";
    

    if(isset($_POST['submit'])){
        $Name = $_POST['name'];
        $Username = $_POST['username'];
        $Password = $_POST['password'];
        $User_role = $_POST['user_role'];

        // Corrected SQL query with backticks (`) around table and column names
        $q = "INSERT INTO `manage_user` (`name`, `username`, `password`, `user_role`) VALUES ('$Name', '$Username', '$Password', '$User_role')";
        $query = mysqli_query($conn, $q);
        
        if($query) {
            // Use JavaScript to show the alert and then redirect
            echo "<script>
                    alert('Successfully added new user!!');
                    window.location.href = 'manageuser.php';
                  </script>";
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
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
    <title>Manage Group</title>
</head>
<body>   
    <div class="container">
    <form action="" method = "post" class="form">
    <h4>Add New User</h4>
        <div class="input-box">
            <label>Name</label>
            <input type="text" name= "name" placeholder="Enter your name"required>
        </div>
        <div class="input-box">
            <label>Username</label>
            <input type="text" name= "username"  placeholder="Enter your username" required>
        </div>
        <div class="input-box">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your passowrd " required>
        </div>
        <div class="input-box">
            <label>User Role</label>
            <div class="column">
                <div class="select-box">
                    <select name = 'user_role' required>
                        <option value="" disabled selected>Select Role</option>
                        <option value="Admin" name= "admin" >Admin</option>
                        <option value="Stock Clerk" name= "checker">Stock Clerk</option>
                        <option value="Cashier" name= "cashier">Cashier</option>
                    </select>
                </div>
            </div>
        </div>

    <button type="submit" name="submit">
     Submit
    </button>

</form>
</div>
</body>
</html>