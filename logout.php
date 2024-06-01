<?php
session_start();

// Clear session data
$_SESSION = array();
session_destroy();

// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Redirect to login page with logout message
header("Location: index.php?message=Successfully logged out");
exit;
?>
