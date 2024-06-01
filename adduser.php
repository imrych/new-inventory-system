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

    if ($stmt->execute()) {
        echo "<script>
            alert('User added successfully!');
            window.location.href='manageuser.php';
        </script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/addgroup.css">
</head>
<body>   
<div class="container">
    <form id="addUserForm" class="form" method="post" action="adduser.php">
        <button class="close-btn" type="button" onclick="window.location.href='manageuser.php'"></button>
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
        <button type="submit" name="submit">Submit</button>
    </form>
</div>
</body>
</html>
