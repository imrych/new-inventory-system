<?php
include 'nav.php';
include 'topnav.php';
include 'includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_role = $_POST['user_role'];

    // Using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO manage_user (Name, Username, Password, User_role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $username, $password, $user_role);

    // Execute the statement
    $stmt_executed = $stmt->execute();

    if ($stmt_executed) {
        // Redirect to manageuser.php after successful user addition
        header("Location: manageuser.php");
        exit();
    } else {
        // Return error message
        echo "Error adding user: " . $stmt->error;
    }

    // Close statement
    $stmt->close();

    // Close database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/addgroup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>   
<div class="container">
    <form id="addUserForm" class="form" method="post">
        <div class="header-container">
            <h4>Add New User</h4>
            <button type="button" class="custom-close-btn" onclick="window.location.href='manageuser.php'">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
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
        <button type="submit" style=" width: 20%;
    padding: 5px;
    background: #f2af4a;
    border: none;
    outline: none;
    color: #FFFFFF;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    border-radius: 10px;
    margin-left: 80%;">Submit</button>
    </form>
</div>

<script>
    $(document).ready(function(){
        $('#addUserForm').submit(function(e){
            e.preventDefault(); // Prevent form submission
            
            // Submit the form using Ajax
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response){
                    alert("Successfully Added New User");
                    window.location.href = "manageuser.php";
                },
                error: function(xhr, status, error){
                    alert("Error adding user: " + error);
                    location.reload();
                }
            });
        });
    });
</script>

</body>
</html>
