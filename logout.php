<?php
// logout.php - Handles user logout

session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Clear the remember me cookie
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, '/');
}

// Redirect to the login page
header('Location: login.php');
exit;
?> 