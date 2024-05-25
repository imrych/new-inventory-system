<?php
include 'topnav.php';
include 'nav.php';
include 'includes/config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sup_id = $_POST['sup_id'];
    $sup_name = ucwords(strtolower($_POST['sup_name']));
    $sup_country = ucwords(strtolower($_POST['sup_country']));
    $sup_num = $_POST['sup_num'];
    $sup_brand = ucwords(strtolower($_POST['sup_brand']));

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE suppliers SET sup_name=?, sup_country=?, sup_num=?, sup_brand=? WHERE sup_id=?");
    $stmt->bind_param("ssssi", $sup_name, $sup_country, $sup_num, $sup_brand, $sup_id);

    if ($stmt->execute()) {
        $message = "Supplier details updated successfully!";
        header("Location: supplier.php"); // Redirect to supplier.php
        exit();
    } else {
        $message = "Error updating supplier details: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $sup_id = $_GET['id'];

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM suppliers WHERE sup_id = ?");
    $stmt->bind_param("i", $sup_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $sup_name = $row['sup_name'];
        $sup_country = $row['sup_country'];
        $sup_num = $row['sup_num'];
        $sup_brand = $row['sup_brand'];
    } else {
        echo "Supplier not found";
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Edit Supplier</title>
</head>
<style>
.container {
    width: 80%;
    margin-left: 260px;
}

.form {
    gap: 20px;
    padding: 20px;
    width: 35%;
    background: #FFFFFF;
    box-shadow: 1px 0 2px 2px rgba(0, 0, 0, 0.2);
    border-radius: 10px;
    display: flex;
    flex-direction: column;
}
.input-box {
    display: flex;
    flex-direction: column;
}
.input-box label {
    color: #000000;
    font-size: 15px;
    font-weight: 500;
    margin-left: 5px;
}
.input-box input {
    border: 1px solid #ddd;
    border-radius: 10px;
    color: black;
    height: 50px;
    outline: none;
    padding: 0 15px;
}
.input-box input:first-letter {
    text-transform: uppercase;
}
button {
    background: #f2af4a;
    border: none;
    border-radius: 10px;
    color: #FFFFFF;
    cursor: pointer;
    font-size: 16px;
    font-weight: 500;
    margin-left: auto;
    outline: none;
    padding: 5px;
    width: 20%;
}
h4 {
    color: #FFA318;
    font-size: 19px;
    font-weight: 600;
    margin: 0;
}
.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 20px;
    height: 20px;
    background: #FFF;
    border: 1px solid #000;
    font-size: 14px;
    font-weight: bold;
    text-align: center;
    cursor: pointer;
    outline: none;
}
.close-btn:hover {
    background: #FFA318;
    color: #FFFFFF;
}
/* editsupplier.css */

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #fafafa;
}
</style>
<body>
<!-- Supplier Edit Form -->
<div class="container">
    <form name="editSupplierForm" class="form" method="POST" action="editsupplier.php?id=<?php echo $sup_id; ?>"
        onsubmit="return validateForm()">
        <input type="hidden" name="sup_id" value="<?php echo $sup_id; ?>">
        <button class="close-btn" onclick="window.location.href='supplier.php'">&times;</button>
        <h4>Edit Supplier Details</h4>

        <!-- Form fields for editing supplier details -->
        <div class="input-box">
            <label>Supplier Name</label>
            <input type="text" name="sup_name" value="<?php echo $sup_name; ?>" placeholder="Enter supplier name" required>
        </div>
        <div class="input-box">
            <label>Country</label>
            <input type="text" name="sup_country" value="<?php echo $sup_country; ?>" placeholder="Enter country" required>
        </div>
        <div class="input-box">
            <label>Phone Number</label>
            <input type="tel" name="sup_num" value="<?php echo $sup_num; ?>" placeholder="Enter phone number" required>
        </div>
        <div class="input-box">
            <label>Brand</label>
            <input type="text" name="sup_brand" value="<?php echo $sup_brand; ?>" placeholder="Enter brand" required>
        </div>

        <!-- Submit button for updating supplier details -->
        <button type="submit">Update</button>
    </form>

    <!-- Display message after form submission -->
    <?php echo $message; ?>
</div>

<!-- JavaScript Validation -->
<script>
    function validateForm() {
        var supName = document.forms["editSupplierForm"]["sup_name"].value;
        var supCountry = document.forms["editSupplierForm"]["sup_country"].value;
        var supNum = document.forms["editSupplierForm"]["sup_num"].value;
        var supBrand = document.forms["editSupplierForm"]["sup_brand"].value;

        if (supName.match(/\d/)) {
            alert("Supplier name must not contain any digits.");
            return false;
        }

        if (supCountry.match(/\d/)) {
            alert("Country must not contain any digits.");
            return false;
        }

        if (!supNum.match(/^\d{11}$/)) {
            alert("Phone number must contain exactly 11 digits and no other characters.");
            return false;
        }

        return true;
    }
</script>
</body>

</html>
