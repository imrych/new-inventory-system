<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" href="css/main.css">
    <title>Home</title>

</head>

<body>
    <div class="navbar">
        <div class="logo">Ping-Ping's Fruit Dealer</div>
        <div class="sidebar">
            <ul>
                <li>
                    <a href="dashcheck.php"><i class="fa-solid fa-house"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="suppcheck.php"><i class="fas fa-ship"></i>
                        Supplier
                    </a>
                </li>
                <li>
                    <a href="ordcheck.php"><i class="fas fa-truck"></i>
                        Stock Order
                    </a>
                </li>
                <li>
                    <a href="invcheck.php"><i class="fa-solid fa-boxes-stacked fa-lg" style="color: #000000;"></i>
                        Inventory
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
        // Hide .dropdown-container by default
        document.querySelector(".dropdown-container").style.display = "none";

        // Add event listener to .user-container
        document.querySelector(".user-container").addEventListener("click", function () {
            // Toggle .dropdown-container
            document.querySelector(".dropdown-container").style.display = document.querySelector(".dropdown-container").style.display === "none" ? "block" : "none";
        });
    </script>


</body>

</html>