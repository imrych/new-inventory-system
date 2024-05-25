<?php
session_start(); // Start the session

// Assuming these session variables are set when the user logs in
$user_role = $_SESSION['user_role'] ?? 'Guest';
$name = $_SESSION['name'] ?? 'Guest User';

// Get the current date and time
$current_datetime = date('F j, Y h:i A');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/topnav.css">
    <title>Top Nav</title>
</head>
<body>
    <div class="top-nav">
        <h1 class="user-role"><?php echo htmlspecialchars($user_role); ?></h1>
        <div class="user-and-date">
            <div class="username"><?php echo htmlspecialchars($name); ?></div>
            <div class="date"><?php echo $current_datetime; ?></div>
        </div>
    </div>
</body>
</html>
