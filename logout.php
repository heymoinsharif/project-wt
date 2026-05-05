<?php
/**
 * FitForge | Logout Logic
 */
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Start a new session just to show the flash message on the login page
session_start();
$_SESSION['flash_message'] = "You have been successfully logged out.";
$_SESSION['flash_type'] = "info";

header("Location: auth.php");
exit();
