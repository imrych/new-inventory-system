<?php
session_start(); 

$user_role = $_SESSION['user_role'] ?? 'Guest';
$name = $_SESSION['name'] ?? 'Guest User';
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
            <div class="date" id="current-datetime"></div>
        </div>
    </div>

    <script>
        function updateDateTime() {
            const now = new Date();
            const formattedDate = now.toLocaleDateString('en-US', {
                year: 'numeric', month: 'long', day: 'numeric'
            });
            const formattedTime = now.toLocaleTimeString('en-US', {
                hour: '2-digit', minute: '2-digit',
                hour12: true
            });
            document.getElementById('current-datetime').textContent = `${formattedDate} ${formattedTime}`;
        }

        setInterval(updateDateTime, 60000); // Update the time every minute
        updateDateTime();  
    </script>
</body>
</html>
