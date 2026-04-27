<?php
// logout.php — Destroys session and clears cookie
if (session_status() === PHP_SESSION_NONE) session_start();

// Destroy all session data
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();

// Optionally clear remember-me cookie
setcookie('taskflow_remember', '', time() - 3600, '/');

header('Location: login.php?logged_out=1');
exit;
