<?php
    include "connection.php";
    if(isset($_GET['id'])){
        $Id = $_GET['id'];
        $sql = "DELETE FROM manage_user WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $Id);
        
        if ($stmt->execute()) {
            header('location:/new-inventory-system/manageuser.php');
            exit;
        }
    }
        ?>