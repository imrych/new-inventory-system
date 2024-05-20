<?php include 'nav.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/manageuser.css">
    <title>Manage Users</title>
</head>

<body>
<div class=" top-nav">
        <h1>Manage User</h1>
        <div class=user_and_date>
            <div class="dropdown">
                <div class="username">Avril Abelarde</div>
                <div class="dropdown-content">
                    <a href="profile.php">Profile</a>
                    <a href="#">Settings</a>
                </div>
            </div>
            <div class="date">April 14, 2024</div>
        </div>
    </div>

    <div class="group_names">
        <div class="group_content">
            <div class="title_and_button">
            <h2>Users</h2>
            <button type="button" onclick="location.href='adduser.php'">Add New User
            </button>
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
                    include 'includes/connection.php';
                    $sql = "select * from manage_user";
                    $result = $conn->query($sql);
                    if(!$result){
                      die("Invalid query!");
                    }
                    while($row=$result->fetch_assoc()){
                        $createdDatetime = $row['Created'];
                        $timestamp = strtotime($createdDatetime);
                        $formattedDate = date('m/d/Y h:i A', $timestamp);

                      echo "
                <tr>
                    <td>$row[Id]</td>
                    <td>$row[Name]</td>
                    <td>$row[Username]</td>
                    <td>$row[User_role]</td>
                    <td>{$formattedDate}</td>
                    <td>
                <a href='edituser.php?updateid=$row[Id]; ?>' style='margin-right: 0px; padding: 5px 14px ; font-weight: 0px; border-radius: 4px; background-color: #F59607; color: #ffffff; border: none;
                        '><i class='fa-regular fa-pen-to-square' style='color: #ffffff;'></i>
                        </a>
                    <a href='delete_user.php?id=$row[Id]; ?>' class='btn btn-danger' style='margin-right: 0px; padding: 5px 15px; border-radius: 4px; background-color: #DC2626; color: #ffffff; border: none;'>
                <i class='fas fa-times' style='color: #ffffff;'></i>
                     </a>
                    </td>
                </tr>
                    
                ";
               }
              ?>
                </tbody>


            </table>
        </div>
        <script>
        // Open .dropdown-container by default
        document.querySelector(".dropdown-container").style.display = "block";

</script>
</body>
</html>