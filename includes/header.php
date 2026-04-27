<?php
// ============================================================
// Shared Navigation Header
// WEB TECHNOLOGIES (23CSE404) | TaskFlow Capstone Project
// ============================================================

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentPage = $currentPage ?? '';
$pageTitle   = $pageTitle   ?? 'TaskFlow';
$loggedIn    = isset($_SESSION['user_id']);
$username    = htmlspecialchars($_SESSION['username'] ?? '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="TaskFlow – A smart personal task management app. Organize, track, and complete your goals efficiently." />
  <title><?= htmlspecialchars($pageTitle) ?> | TaskFlow</title>
  <link rel="stylesheet" href="/css/style.css" />
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>✅</text></svg>" />
</head>
<body>

<nav id="mainNav" aria-label="Main Navigation">
  <div class="nav-container">
    <a href="/index.php" class="nav-logo" id="navLogo">✅ TaskFlow</a>

    <button class="hamburger" id="hamburger" aria-label="Toggle navigation menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>

    <ul class="nav-links" id="navLinks" role="list">
      <li><a href="/index.php"   <?= $currentPage==='home'      ? 'class="active"' : '' ?>>Home</a></li>
      <li><a href="/about.php"   <?= $currentPage==='about'     ? 'class="active"' : '' ?>>About</a></li>
      <?php if ($loggedIn): ?>
        <li><a href="/dashboard.php" <?= $currentPage==='dashboard' ? 'class="active"' : '' ?>>Dashboard</a></li>
        <li><a href="/profile.php"   <?= $currentPage==='profile'   ? 'class="active"' : '' ?>>Profile</a></li>
        <li><a href="/logout.php" class="btn-nav" id="navLogout">Logout</a></li>
      <?php else: ?>
        <li><a href="/login.php"    <?= $currentPage==='login'    ? 'class="active"' : '' ?>>Login</a></li>
        <li><a href="/register.php" class="btn-nav" id="navRegister">Get Started</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
