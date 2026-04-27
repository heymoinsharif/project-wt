<?php
// ============================================
// Database Configuration
// WEB TECHNOLOGIES (23CSE404) Capstone Project
// ============================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // Change if your MySQL user is different
define('DB_PASS', '');           // Change if your MySQL password is set
define('DB_NAME', 'taskflow_db');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die('<div style="color:red;padding:20px;font-family:sans-serif;">
         <h2>Database Connection Failed</h2>
         <p>' . mysqli_connect_error() . '</p>
         <p>Please ensure:<br>
         1. XAMPP/WAMP MySQL server is running.<br>
         2. You have imported <code>database.sql</code> into phpMyAdmin.<br>
         3. Credentials in <code>config/db.php</code> are correct.</p>
         </div>');
}

// Set charset to UTF-8
mysqli_set_charset($conn, 'utf8mb4');
?>
