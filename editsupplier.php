<?php
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
.top-nav {
    background-color:#F59607;
    width: auto;
    height: 80px;
    margin-left: 260px;
    display: flex;
    gap: 61%;
    align-items: center;
    flex-direction: row;
}

h1 {
    font-size: 28px;
    font-weight: 400;
    color: #FAFAFA;
    margin-bottom: 20px;
    margin-top: 20px;
    margin-left: 15px;
    padding: 15px;
}

.date {
    font-size: 12px;
    font-weight: 450;
    color: #FAFAFA;
    margin-bottom: 15px;
    text-align: center;
}
.username {
    font-size: 12px;
    font-weight: 450;
    color: #000000;
    margin-bottom: 15px;
    text-align: center;
    cursor: pointer;
}

.username:hover {
    color: #FAFAFA;
}

.dropbtn {
    color: black;
    font-size: 13px;
    cursor: pointer;
  }

  .dropdown {
    position: relative;
    display: inline-block;
    gap: 5px;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    border-radius: 10px;
    font-size: 14px;
  }

  .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
  }

  .dropdown-content a:hover {
    background-color: #f1f1f1;
    border-radius: 10px;

}

  .dropdown:hover .dropdown-content {
    display: block;
  }

  .dropdown:hover .dropbtn {
    color: orange;
  }

.user_and_date {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    margin-top: 20px;
    margin-left: 10px;
    margin-right: 10px;
    gap: 15px;
}
.container {
    margin: 20px auto;
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

@media only screen and (max-width: 600px) {
    .container {
        width: 100%;
    }
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
<div class="top-nav">
    <h1>Edit Supplier</h1>
    <div class="user_and_date">
        <div class="dropdown">
            <div class="username">Avril Abelarde</div>
            <div class="dropdown-content">
                <a href="profile.php">Profile</a>
                <a href="#">Settings</a>
            </div>
        </div>
        <div class="date">April 14, 2024</div>
    </div>
</div>

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
