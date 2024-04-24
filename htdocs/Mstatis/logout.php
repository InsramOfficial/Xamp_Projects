<?php
session_start();

// Check if the user is an admin
if ($_SESSION['role'] === 'admin') {
    // Destroy only the admin's session variables
    $_SESSION['username'] = null;
    $_SESSION['role'] = null;
    $_SESSION['success'] = null;
} else {
    // Destroy the entire session for non-admin users
    $_SESSION = array();
    session_destroy();
}

// Redirect to the login page
header("location: login.php");
exit();
?>
