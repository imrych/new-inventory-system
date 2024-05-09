<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fontawesome.com" rel=stylesheet>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Home</title>
</head>

<body>

    <div class="navbar">
        <div class="logo">Ping-Ping's Fruit Dealer</div>
        <div class="sidebar">
            <ul>
                <li>
                    <a href="dashbroad.php"><i class="fa-solid fa-house"></i>
                        Dashboard
                    </a>
                </li>

                <li>
                    <a class="user-container">
                        <i class="fa-solid fa-user-plus"></i>
                        User's Management</a>
                    <div class="dropdown-container">
                        <a class="item" href="managegroup.php">Manage Group</a>
                        <a class="item" href="manageuser.php">Manage Users</a>
                    </div>
                </li>
                    <li>
                    <a href="inventory.php"><i class="fa-solid fa-boxes-stacked"></i>
                        Inventory
                    </a>
                </li>
                <li>
                    <a href="supplier.php"><i class="fas fa-ship"></i>
                        Supplier
                    </a>
                </li>
                <li>
                    <a href="order.php"><i class="fas fa-truck"></i>
                        Order
                    </a>
                </li>
                <li>
                    <a href="customers.php"><i class="fas fa-users"></i>
                        Customers
                    </a>
                </li>
                <li>
                    <a href="sales.php"><i class="fas fa-chart-line"></i>
                        <span>Sales</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php"><i class="fas fa-sign-out"></i>
                        <span>Log-out</span>
                    </a>
                </li>
            </ul>

        </div>
    </div>

<script>
var userContainers = document.querySelectorAll(".user-container");

userContainers.forEach(function(userContainer) {
var dropdownContent = userContainer.nextElementSibling; // Get the dropdown content
dropdownContent.style.display = "none";
    userContainer.addEventListener("click", function(event) {
     event.preventDefault();
    this.classList.toggle("active");
    if (this.classList.contains("active")) {
        dropdownContent.style.display = "block";
        } else {
            dropdownContent.style.display = "none";
        }
        });
    });
</script>


</body>

</html>