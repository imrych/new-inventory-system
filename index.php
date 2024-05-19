<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "db_inventory";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM users WHERE username=? AND user_pass=?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $bind_result = $stmt->bind_param("ss", $username, $password);
    if (!$bind_result) {
        die("Error binding parameters: " . $stmt->error);
    }

    $execute_result = $stmt->execute();
    if (!$execute_result) {
        die("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Login failed');</script>";
    }

    $stmt->close();
    $conn->close();


}

{
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    echo "<script>alert('$message');</script>";}
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
            <p>Log-In</p>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username : </label>
                    <input type="text" name="username" placeholder="username" id="username" required>
                </div>

                <div class="field input">
                    <label for="password">Password : </label>
                    <input type="password" name="password" placeholder="password" id="password" required>
                </div>

                <div class= "field">
                    <input type="submit" class="btn" name="submit" value="Submit" required>
                </div>
            </form>
        </div>
    </div>
</body>
</html>