<?php
session_start();

$_SESSION = array();

session_destroy();
header("Location: login.php?message=Successfully logged out");
exit;

?>
