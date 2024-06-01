<?php
session_start();

// Check if a message is present in the URL
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    // Display the message
    echo "<script>alert('$message');</script>";
}

include 'includes/connection.php';

if (isset($_POST['login_btn'])) {
    
    $username_login = $_POST['username'];
    $password_login = $_POST['password'];

    $query = "SELECT * FROM manage_user WHERE username = '$username_login' AND password = '$password_login'";
    $results = mysqli_query($conn, $query);
    $user = mysqli_fetch_array($results);

    if ($user) {
        $_SESSION['username'] = $username_login;    
        $_SESSION['name'] = $user['Name'];
        $_SESSION['user_role'] = $user['User_role'];

        if ($user['User_role'] == 'Admin') {
            header('location: dashboard.php');
            exit();
        } elseif ($user['User_role'] == 'Stock Clerk') {
            header('location: dashcheck.php');
            exit();
        } elseif ($user['User_role'] == 'Cashier') {
            header('location: dashcashier.php');
            exit();
        }
    } else {
        $_SESSION['status'] = 'Username/Password is Invalid';
        header('location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <title>Log-in</title>
</head>
<body class="login-page">
    <div class="container">
        <div class="box form-box">
            <header>Ping-Ping's Fruit Dealer</header>

            <?php 
                if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
                    echo '<h4 style="background-color: #EE4B2B; color:white;">'. $_SESSION['status'] .'</h4>';
                    unset($_SESSION['status']); 
                }
            ?>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username : </label>
                    <input type="text" name="username" placeholder="username" id="username" required>
                </div>

                <div class="field input">
                    <label for="password">Password : </label>
                    <input type="password" name="password" placeholder="password" id="password" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="login_btn" value="Login">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
