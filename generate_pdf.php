<?php
require 'dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

include 'includes/config.php';

// Database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM sales ORDER BY sale_date"; // Ensure sales data is sorted by date
$result = $conn->query($sql);
$total_sales = 0;
$grand_total = 0;
$sales_data = '';
$current_month = null; // Track current month
$sub_total = 0; // Track subtotal for each month

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $sale_month = date('F Y', strtotime($row["sale_date"]));
        if ($current_month != $sale_month) {
            // If month changes, start a new table
            if ($current_month !== null) {
                // Close previous table and add subtotal
                $sales_data .= "<tr class='subtotal-row'>
                                    <td colspan='5' class='subtotal-label'><strong>Subtotal</strong></td>
                                    <td>" . number_format($sub_total, 2) . "</td>
                                </tr></tbody></table>"; 
                $grand_total += $sub_total; // Add subtotal to grand total
                $sub_total = 0; // Reset subtotal
            }
            $current_month = $sale_month;
            $sales_data .= "<div class='sub-header'>Sales for $current_month</div>";
            $sales_data .= "<table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                        <th>Total Sale</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>";
        }

        $sub_total += $row["sale_total"];
        $total_sales += $row["sale_total"];
        $sales_data .= "<tr>
                            <td>{$row['sales_id']}</td>
                            <td>{$row['sale_product']}</td>
                            <td>{$row['sale_size']}</td>
                            <td>{$row['sold_quantity']}</td>
                            <td>" . number_format($row['sale_total'], 2) . "</td>
                            <td>" . date('d-m-Y', strtotime($row['sale_date'])) . "</td>
                        </tr>";
    }
    $grand_total += $sub_total; // Add last month's subtotal to grand total
    $sales_data .= "<tr class='subtotal-row'>
                        <td colspan='5' class='subtotal-label'><strong>Subtotal</strong></td>
                        <td>" . number_format($sub_total, 2) . "</td>
                    </tr></tbody></table>"; // Close the last table and add subtotal
} else {
    $sales_data .= "<tr><td colspan='5'>No records found</td></tr>";
}

$conn->close();

$total_sales_formatted = number_format($total_sales, 2);
$grand_total_formatted = number_format($grand_total, 2);

// Convert image to Base64
$image_path = 'C:/xampp/htdocs/new-inventory-system/ping logo.png';
$image_data = base64_encode(file_get_contents($image_path));
$src = 'data:image/png;base64,' . $image_data;

// DOMPDF Configuration
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

$html = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Sales Report</title>
    <style>
    body {
        font-family: 'Poppins', Arial, sans-serif; /* Use Poppins font */
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    .container {
        width: 95%;
        height: 95%;
        margin: auto;
        padding: 20px;
        border: 1px solid black;
        position: relative;
    }

    .watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: -1;
        opacity: 0.1;
        width: 800px; /* Adjust width */
        height: auto; /* Maintain aspect ratio */
    }
    
    /* Header styles */
    .header {
        text-align: center;
        background-color: #FFA500;
        color: white;
        padding: 10px 0;
        font-size: 24px;
        font-weight: bold;
    }
    
    .sub-header {
        text-align: center;
        margin: 10px 0;
        font-size: 18px;
        font-weight: bold;
    }
    
    .info {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        margin-bottom:25px;
        line-height: 1.2;
    }
    
    .address p, .contact p {
        margin: 2px 0;
    }
    
    .contact {
        text-align: left;
        margin-left: 455px;
        margin-top: -100px;
    }
    
    /* Table styles */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        margin-bottom: 50px;
        border: 1px solid #000;
        font-family: 'Poppins', Arial, sans-serif; /* Use Poppins font */
    }
    
    th, td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
    }
    
    th {
        background-color: #FFA500;
        color: white;
        font-weight: bold;
    }
    
    .total-row {
        border: 1px solid #000;
        width: -50px;
    }
    
    .total-label {
        text-align: right;
        font-weight: bold;
    }
    
    .underline {
        text-decoration: underline;
        font-weight: bold;
    }

    </style>
</head>
<body>
    <div class='container'>
        <img src='$src' class='watermark' />
        <div class='header'>
            <strong>MONTHLY SALES REPORT</strong>
        </div>
        <div class='info'>
            <div class='address'>
                <p><strong>Ping Ping Fruit Dealer</strong></p>
                <p>103 Dona Pecita Bldg</p>
                <p>639 Sto. Cristo St, San Nicolas,</p>
                <p>Barangay 281, Manila, Philippines</p>
            </div>
            <div class='contact'>
                <p><strong>Tel No.</strong> #245-6728 
                <br><strong>Cell No.</strong> #0922-87104289</p>
                <p><strong>REG TIN:</strong> 410-451-934-000</p>
            </div>
        </div>
        $sales_data
        <div class='total-row'>
            <p class='total-label'><strong>Grand Total</strong>: <span class='underline'>$grand_total_formatted</span></p>
        </div>
    </div>
</body>
</html>";

// Load HTML to DOMPDF
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("sales_report.pdf", array("Attachment" => 0));
?>
