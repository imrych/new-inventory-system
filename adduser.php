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
        // Return success message
        $response = [
            'success' => true,
            'message' => 'User added successfully!'
        ];
    } else {
        // Return error message
        $response = [
            'success' => false,
            'message' => 'Error adding user: ' . $stmt->error
        ];
        http_response_code(500); // Internal Server Error
    }

    // Close statement
    $stmt->close();

    // Close database connection
    $conn->close();

    // Output JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
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
$(document).ready(function() {
    $('#addUserForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        $.ajax({
            type: 'POST',
            url: 'adduser.php',
            data: $(this).serialize(), // Serialize form data
            dataType: 'json',
            success: function(response) {
                alert(response.message); // Show success or error message
                if (response.success) {
                    window.location.href = 'manageuser.php'; // Redirect to manageuser.php on success
                } else {
                    // Handle specific error scenario if needed
                }
            },
            error: function(xhr, status, error) {
                alert('Error adding user. Please try again.'); // Show generic error message
                console.error('Error: ' + error);
            }
        });
    });
});
</script>
</body>
</html>
