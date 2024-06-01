<?php
require_once('includes/tcpdf/tcpdf.php'); // Ensure this path is correct
include 'includes/config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM sales";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Sales Report');
    $pdf->SetSubject('Sales Report');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set font
    $pdf->SetFont('dejavusans', '', 10);

    // add a page
    $pdf->AddPage();

    // create table
    $tbl = '<table cellspacing="0" cellpadding="1" border="1">';
    $tbl .= '<tr>
                <th>#</th>
                <th>Product</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Total Sale</th>
                <th>Date</th>
            </tr>';
    $total_sales = 0;
    while($row = $result->fetch_assoc()) {
        $total_sales += $row["sale_total"];
        $tbl .= '<tr>
                    <td>' . $row["sales_id"] . '</td>
                    <td>' . $row["sale_product"]. '</td>';
                    $tbl .= '<td>' . $row["sale_size"] . '</td>';
                    $tbl .= '<td>' . $row["sold_quantity"] . '</td>';
                    $tbl .= '<td>' . $row["sale_total"] . '</td>';
                    $tbl .= '<td>' . $row["sale_date"] . '</td>';
                    $tbl .= '</tr>';
    }
    $tbl .= '</table>';
    $tbl .= '<div><strong>Total Sales: </strong>₱' . number_format($total_sales, 2) . '</div>';

    // output the HTML content
    $pdf->writeHTML($tbl, true, false, false, false, '');

    // Close and output PDF document
    $pdf->Output('sales_report.pdf', 'I');
} else {
    echo "No records found";
}

$conn->close();
?>
