<?php 
include 'topnav.php';
include 'nav.php';
include 'includes/connection.php';

    $Id=$_GET['updateid'];
    $q = "SELECT * FROM manage_user WHERE id='$Id'";
    $result = mysqli_query($conn, $q);
    $row=mysqli_fetch_assoc($result);
    

    if(isset($_POST['edit'])){
        $Name = $_POST['name'];
        $Username = $_POST['username'];
        $Password = $_POST['password'];
        $User_role = $_POST['user_role'];


        $q = "UPDATE manage_user SET Name='$Name', Username='$Username', Password='$Password', User_role='$User_role' WHERE id='$Id'";
        $query = mysqli_query($conn, $q);
        
        if($query) {
            echo "<script>
                    alert('Successfully Updated User!!');
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
    <h4>Edit User</h4>
        <div class="input-box">
            <label>Name</label>
            <input type="text" name= "name" value="<?php echo $row['Name']; ?>">
        </div>
        <div class="input-box">
            <label>Username</label>
            <input type="text" name= "username"  value="<?php echo $row['Username']; ?>">
        </div>
        <div class="input-box">
    <label>Password</label>
    <div style="position: relative;">
        <input type="password" id="password" name="password" value="<?php echo $row['Password']; ?>" style="padding-right: 30px;">
        <i id="togglePassword" class="fas fa-eye" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                    </div>
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
        
    <button type="submit" name="edit">
     Update
    </button>

</form>
</div>
</body>
</html>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        var passwordField = document.getElementById('password');
        var toggleIcon = document.getElementById('togglePassword');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    });
</script>