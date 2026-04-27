<?php
// delete_task.php — Handles task deletion (Delete operation in CRUD)
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = (int)$_SESSION['user_id'];
$task_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($task_id > 0) {
    // Verify ownership before deleting
    $res = mysqli_query($conn, "SELECT title FROM tasks WHERE id=$task_id AND user_id=$user_id LIMIT 1");
    if ($res && mysqli_num_rows($res) === 1) {
        $task = mysqli_fetch_assoc($res);
        mysqli_query($conn, "DELETE FROM tasks WHERE id=$task_id AND user_id=$user_id");
        $_SESSION['flash'] = "Task \"{$task['title']}\" deleted successfully.";
    }
}

header('Location: dashboard.php');
exit;
