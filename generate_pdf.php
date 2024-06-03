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
            <td>₱" . number_format($row['sale_total'], 2) . "</td>
            <td>{$row['sale_date']}</td>
        </tr>";
    }
} else {
    $sales_data .= "<tr><td colspan='6'>No records found</td></tr>";
}

$conn->close();

$total_sales_formatted = "₱" . number_format($total_sales, 2);

// DOMPDF Configuration
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

// HTML Content
$html = "
<html>
<head>
    <style>
        @page { margin: 1in; }
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
        }
        .header p {
            margin: 5px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .total_sales {
            margin-top: 20px;
            text-align: right;
        }
        .watermark {
            position: fixed;
            top: 40%;
            left: 10%;
            width: 80%;
            opacity: 0.1;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class='watermark'>
        <img src='css/ping logo.png' alt='Ping Ping Fruit Dealer'>
    </div>
    <div class='header'>
        <h2>SALES REPORT</h2>
        <p>For (Month) (Year)</p>
        <p>Ping Ping Fruit Dealer</p>
        <p>639 Sto. Cristo Street, San Nicolas, Manila, Philippines</p>
        <p>Date: " . date('Y-m-d') . "</p>
    </div>
    <table class='table'>
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
        </tbody>
    </table>
    <div class='total_sales'>
        <strong>Total Sales: </strong>$total_sales_formatted
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
