<?php
include 'topnav.php';
include 'nav.php';
include 'includes/config.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if delete action is requested
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    // Delete the supplier with the given ID
    $sql_delete = "DELETE FROM suppliers WHERE sup_id = $id";
    if ($conn->query($sql_delete) === TRUE) {
        $message = "Supplier deleted successfully";
    } else {
        $message = "Error deleting supplier: " . $conn->error;
    }
}

$sql = "SELECT * FROM suppliers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/supplier.css">
    <title>Manage Supplier</title>
</head>

<body>
<div class="table-container">
    <div class="title_and_button">
        <h2>Suppliers</h2>
        <button type="button" onclick="location.href='addsupplier.php'">Add New Supplier</button>
    </div>
    <?php
// Display data in a table
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<thead><tr>
        <th>No.</th>
        <th>Name</th>
        <th>Country</th>
        <th>Phone Number</th>
        <th>Brand</th>
        <th>Action</th>
        </tr>
        </thead>";
    while ($row = $result->fetch_assoc()) {
        echo "<tbody>";
        echo "<tr>";
        echo "<td>" . $row["sup_id"] . "</td>";
        echo "<td>" . $row["sup_name"] . "</td>";
        echo "<td>" . $row["sup_country"] . "</td>";
        echo "<td>" . $row["sup_num"] . "</td>";
        echo "<td>" . $row["sup_brand"] . "</td>";
        // Inside the while loop where you display supplier details
        echo "<td>
                <button onclick=\"window.location.href='editsupplier.php?id=" . $row["sup_id"] . "'\" style=\"margin-right: 0px; padding: 3px 9px; font-weight: bold; border-radius: 4px; background-color: #F59607; color: #ffffff; border: none;\">
                    <i class=\"fa-regular fa-pen-to-square\" style=\"color: #ffffff;\"></i>
                </button>
                <button onclick=\"deleteSupplier(" . $row["sup_id"] . ")\" style=\"margin-right: 0px; padding: 3px 9px; font-weight: bold; border-radius: 4px; background-color: #DC2626; color: #ffffff; border: none;\">
                    <i class=\"fa-solid fa-xmark\" style=\"color: #ffffff;\"></i>
                </button>
                </td>";
        echo "</tr>";
        echo "</tbody>";
    }
    echo "</table>";
} else {
    echo "No suppliers found";
}
// Close the database connection
$conn->close();

// Check if a message is present in the URL
if (isset($message)) {
    // Display the message using JavaScript
    echo "<script>alert('$message');</script>";
}
?>
</div>

<script>
    function deleteSupplier(id) {
        if (confirm("Are you sure you want to delete this supplier?")) {
            window.location.href = 'supplier.php?action=delete&id=' + id;
        }
    }
</script>
</body>
</html>
