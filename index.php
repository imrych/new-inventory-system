<?php
    include 'connection.php';
    session_start();

if (isset($_POST['login_btn'])) {
    
    $username_login = $_POST['username'];
    $password_login = $_POST['password'];
    $usertype = $_POST['user_role'];

    $query = "SELECT * FROM manage_user WHERE username = '$username_login' AND password = '$password_login' ";
    $results = mysqli_query($conn,$query);
    $usertype = mysqli_fetch_array($results);


    if($usertype['User_role'] == 'Admin'){
        $_SESSION['username'] = $username_login;    
        header('location: dashboard.php');
        exit();
    }
    elseif($usertype['User_role'] == 'Stock Clerk'){
        $_SESSION['username'] = $username_login;    
        header('location: dashcheck.php');
        exit();
    }
    elseif($usertype['User_role'] == 'Cashier'){
        $_SESSION['username'] = $username_login;    
        header('location: dashcashier.php');
        exit();
    }
    else {
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <title>Log-in</title>
</head>
<body class="login-page">
    <div class="container">
        <div class="box form-box">
            <header>Ping-Ping's Fruit Dealer</header>

            <?php 
                if(isset($_SESSION['status']) && $_SESSION['status'] !='')
            {
                echo '<h4 style="background-color: #EE4B2B; color:white;">'. $_SESSION['status'].'</h4>';
                unset($_SESSION['status']); 
            }
            
            
            ?>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username : </label>
                    <input type="text" name="username" placeholder="username" id="username" >
                </div>

                <div class="field input">
                    <label for="password">Password : </label>
                    <input type="password" name="password" placeholder="password" id="password" >
                </div>

                <div class= "field">
                    <input type="submit" class="btn" name="login_btn" value="Login" required>
                </div>
            </form>
        </div>
    </div>
</body>
</html>