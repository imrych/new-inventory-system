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

$sql = "SELECT * FROM sales";
$result = $conn->query($sql);
$total_sales = 0;
$sales_data = '';

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $total_sales += $row["sale_total"];
        $sales_data .= "<tr>
            <td>{$row['sales_id']}</td>
            <td>{$row['sale_product']}</td>
            <td>{$row['sale_size']}</td>
            <td>{$row['sold_quantity']}</td>
            <td>&#8369;" . number_format($row['sale_total'], 2) . "</td>
            <td>" . date('M j, Y', strtotime($row['sale_date'])) . "</td>
        </tr>";
    }
} else {
    $sales_data .= "<tr><td colspan='6'>No records found</td></tr>";
}

// Fetching month and year from sales table
$sql_month_year = "SELECT DISTINCT MONTH(sale_date) AS month, YEAR(sale_date) AS year FROM sales";
$result_month_year = $conn->query($sql_month_year);
if ($result_month_year->num_rows > 0) {
    $row_month_year = $result_month_year->fetch_assoc();
    $month = date("F", mktime(0, 0, 0, $row_month_year["month"], 1));
    $year = $row_month_year["year"];
    $sub_header = "<div class='sub-header'>For <strong>$month $year</strong></div>";
} else {
    $sub_header = "<div class='sub-header'>For Month Year</div>";
}

$conn->close();

$total_sales_formatted = "&#8369;" . number_format($total_sales, 2);

// DOMPDF Configuration
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

// HTML Content
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
        border: 1px solid black; /* Add border around the entire A4 page */
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
    
    .address {
        text-align: left;
        margin-top: 10px;
        line-height: 1.2;
    }
    
    .address p {
        margin: 2px 0;
    }
    
    .date {
        text-align: right;
        margin-top: 10px;
    }
    
    .date p {
        margin: 2px 0;
    }
    
    /* Table styles */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
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
    
    td:nth-child(odd) {
        background-color: #F9F9F9;
    }
    
    .total-row {
        font-weight: bold;
        background-color: #F9F9F9;
    }
    
    .total-label {
        text-align: right;
    }
    
    /* Additional styles */
    .footer {
        margin-top: 20px;
        text-align: left;
    }
    
    .footer p {
        margin: 2px 0;
    }
    
    .watermark {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 400px;
        opacity: 0.1;
        z-index: -1;
    }
</style>    
</head>
<body>
    <div class='watermark'>
        <img src='ping logo.png' alt='Ping Ping Fruit Dealer' width='500'> <!-- Adjusted image path -->
    </div>
    <div class='container'>
        <div class='header'>
            <strong>SALES REPORT</strong>
        </div>
        $sub_header
        <div class='address'>
            <p><strong>Ping Ping Fruit Dealer</strong><br>639 Aljo Crista Street, San Nicolas, Manila, Philippines<br>+112-334-665-2233</p>
        </div>
        <div class='date'>
            <p><strong>Date:</strong> " . date('F j - ', strtotime('first day of this month')) . date('F j', strtotime('last day of this month')) . "</p>
        </div>
        <table>
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
            <tbody>
                $sales_data
                <tr class='total-row'>
                    <td colspan='5' class='total-label'>Grand Total</td>
                    <td>$total_sales_formatted</td>
                </tr>
            </tbody>
        </table>
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
