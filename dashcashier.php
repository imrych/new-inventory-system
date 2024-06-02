<?php include 'cashier_nav.php'; 
include 'topnav.php';
include 'includes/connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Dashboard</title>
<body>

<div class="dashboard_content">
        <div class="boxes">
            <div class="card">
                <i class="fas fa-user"></i>
                <div class="first_text_total">No. of users
                </div>
                <?php   
                    $query = "SELECT ID FROM manage_user ORDER BY ID "; 
                    $query_run = mysqli_query($conn,$query);

                    $row = mysqli_num_rows($query_run);  
                    echo "$row Users";
                ?>
            </div>

            <div class="card">
                <i class="fa fa-th-large"></i>
                <div class="first_text_total">No. of categories</div>
                <div class="text_total"> 9 categories
                </div>
                 
                
              
            </div>
            <div class="card">
                <i class="fa fa-shopping-cart"></i>
                <div class="first_text_total">No. of products
                </div>

                <?php   
                    $query = "SELECT inventory_id FROM inventory"; 
                    $results = mysqli_query($conn,$query);

                    $row = mysqli_num_rows($results);  
                    echo "$row products";
                ?>
            </div>

            <div class="card">
                <i class="fa fa-tags"></i>
                <div class="first_text_total">No. of sales</div>
                <?php   
                    $query = "SELECT sales_ID FROM sales "; 
                    $query_run = mysqli_query($conn,$query);

                    $row = mysqli_num_rows($query_run);  
                    echo "$row Sales";
                ?>
        </div>
</div>

    <div class="table_names">
        <div class="first_part_content">
        <h2>Highest Selling Products</h2>
<table class="first_table">
    <tr>
        <th class="border-top-left">Product</th>
        <th>Total Sold</th>
        <th class="border-top-right">Total Quantity</th>
    </tr>
    <?php 
    $sql = "SELECT sale_product, SUM(sale_total) AS sale_total, SUM(sold_quantity) AS sold_quantity 
            FROM sales 
            GROUP BY sale_product 
            ORDER BY sale_total DESC 
            LIMIT 3";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['sale_product']) . '</td>';
            echo '<td>' . htmlspecialchars($row['sale_total']) . '</td>';
            echo '<td>' . htmlspecialchars($row['sold_quantity']) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="3">No records found</td></tr>';
    }
    
    ?>
</table>

        </div>

        <div class="second_part_content">
            <h2>Latest Sales</h2>
            <table class="second_table">
                <tr>
                    <th class="border-top-left">#</th>
                    <th>Product</th>
                    <th>Date</th>
                    <th class="border-top-right">Total Sales</th>
                </tr>
                <?php 
            $sql = "SELECT sale_product, sale_date, sale_total FROM sales ORDER BY sales_id DESC LIMIT 3";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
            $counter = 1;
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $counter . '</td>';
                echo '<td>' . htmlspecialchars($row['sale_product']) . '</td>';
                echo '<td>' . htmlspecialchars($row['sale_date']) . '</td>';
                echo '<td>' . htmlspecialchars($row['sale_total']) . '</td>';
                echo '</tr>';
                $counter++;
            }
        } else {
            echo '<tr><td colspan="4">No records found</td></tr>';
        }
        
                ?>
            </table>
        </div>
        <div class="third_part_content">
            <h2>Recently Added Product</h2>
            <table class="third_table">
                <tr>
                    <th class="border-top-left" class="border-top-right">#</th>
                    <th>Product </th>
                    <th>Category</th>
                </tr>

        <?php 
            $sql = "SELECT product_name, category FROM inventory ORDER BY inventory_id DESC LIMIT 3";
            $result = $conn->query($sql);


            if ($result->num_rows > 0) {
            $counter = 1;
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $counter . '</td>';
                echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['category']) . '</td>';
                echo '</tr>';
                $counter++;
            }
        } 
                ?>
            </table> 
            
        </div>      
                
        

    </div>
</div>

</body>

</html>