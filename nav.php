<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="includes/main.css">
    <link rel="stylesheet" href="includes/dashboard.css">
    <title>Home</title>
</head>

<body>
<div class=" top-nav">
        <h1>Dashboard</h1>
        <div class=user_and_date>
            <div class="dropdown">
                <div class="username">Avril Abelarde</div>
                <div class="dropdown-content">
                    <a href="#">Profile</a>
                    <a href="#">Settings</a>
                </div>
            </div>
            <div class="date">April 14, 2024</div>
        </div>
    </div>

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
                        <a class="item" href="manageuser.php">Manage user</a>
                        <a class="item" href="#">Manage group</a>
</div>
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
                    <a href="products.php"><i class="fas fa-box"></i>
                        Products
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
    var dropdown = document.getElementsByClassName("user-container");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
</script>
</body>

</html>