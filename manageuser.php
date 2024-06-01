<?php 
include 'nav.php'; 
include 'topnav.php';
include 'includes/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/manageuser.css">
    <title>Manage Users</title>
    <script>
    function deleteUser(userId) {
        var confirmation = confirm("Are you sure you want to delete this user?");
        if (confirmation) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_user.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert(response.message);
                            window.location.reload(); // Reload the page after successful deletion
                        } else {
                            alert(response.message);
                            console.error('Error: ' + response.error);
                        }
                    } else {
                        alert('Failed to delete user. Please try again.');
                        console.error('Error: ' + xhr.status);
                    }
                }
            };
            xhr.send("id=" + userId);
        }
    }
    </script>
</head>

<body>
<div class="group_names">
    <div class="group_content">
    <?php
        // Check if success parameter is set in the URL
        if(isset($_GET['success']) && $_GET['success'] == 1) {
            echo "<script>alert('Successfully added new user');</script>";
        }
    ?>
        <div class="title_and_button">
            <h2>Users</h2>
            <button type="button" onclick="location.href='adduser.php'">Add New User</button>
        </div>
        <table class="group_table">
                <thead>
                    <tr>
                        <th class="border-top-left">#</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>User role</th>
                        <th>Created</th>
                        <th class="border-top-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM manage_user";
                    $result = $conn->query($sql);
                    if (!$result) {
                        die("Invalid query!");
                    }
                    while ($row = $result->fetch_assoc()) {
                        $createdDatetime = $row['Created'];
                        $timestamp = strtotime($createdDatetime);
                        $formattedDate = date('F j, Y', $timestamp);

                        echo "
                            <tr>
                                <td>{$row['Id']}</td>
                                <td>{$row['Name']}</td>
                                <td>{$row['Username']}</td>
                                <td>{$row['User_role']}</td>
                                <td>{$formattedDate}</td>
                                <td>
                                    <a href='edituser.php?updateid={$row['Id']}' style='margin-right: 0px; padding: 5px 14px ; font-weight: 0px; border-radius: 4px; background-color: #F59607; color: #ffffff; border: none;'>
                                        <i class='fa-regular fa-pen-to-square' style='color: #ffffff;'></i>
                                    </a>
                                    <button class='btn btn-danger' onclick='deleteUser({$row['Id']})' style='margin-right: 0px; padding: 5px 15px; border-radius: 4px; background-color: #DC2626; color: #ffffff; border: none;'>
                                        <i class='fas fa-times' style='color: #ffffff;'></i>
                                    </button>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
