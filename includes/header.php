<?php
/**
 * FitForge | Header Include
 * Starts session and renders the navigation bar.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Detect current page for active nav link
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FitForge – Your ultimate fitness companion. Track workouts, calculate BMI, and stay motivated.">
    <meta name="keywords" content="fitness, workout, BMI calculator, health, exercise tracker">
    <meta name="author" content="FitForge Team">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' | FitForge' : 'FitForge – Forge Your Fitness'; ?></title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>

<!-- Particle Background Canvas -->
<canvas id="particle-canvas"></canvas>

<!-- Navigation -->
<nav class="navbar" id="navbar">
    <div class="nav-container">
        <a href="index.php" class="nav-logo">
            <span class="logo-icon"><i class="fas fa-bolt"></i></span>
            <span class="logo-text">Fit<span class="logo-accent">Forge</span></span>
        </a>

        <div class="nav-menu" id="navMenu">
            <a href="index.php" class="nav-link <?php echo $current_page === 'index' ? 'active' : ''; ?>">
                <i class="fas fa-home"></i> Home
            </a>
            <a href="about.php" class="nav-link <?php echo $current_page === 'about' ? 'active' : ''; ?>">
                <i class="fas fa-users"></i> About
            </a>
            <a href="tools.php" class="nav-link <?php echo $current_page === 'tools' ? 'active' : ''; ?>">
                <i class="fas fa-dumbbell"></i> Tools
            </a>
            <a href="contact.php" class="nav-link <?php echo $current_page === 'contact' ? 'active' : ''; ?>">
                <i class="fas fa-envelope"></i> Contact
            </a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="nav-link <?php echo $current_page === 'dashboard' ? 'active' : ''; ?>">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a href="logout.php" class="nav-btn btn-outline">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            <?php else: ?>
                <a href="auth.php" class="nav-btn btn-primary <?php echo $current_page === 'auth' ? 'active' : ''; ?>">
                    <i class="fas fa-fire"></i> Get Started
                </a>
            <?php endif; ?>
        </div>

        <button class="nav-toggle" id="navToggle" aria-label="Toggle Navigation">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

<!-- Flash Messages -->
<?php if (isset($_SESSION['flash_message'])): ?>
<div class="flash-message flash-<?php echo htmlspecialchars($_SESSION['flash_type'] ?? 'info'); ?>" id="flashMsg">
    <i class="fas fa-<?php echo $_SESSION['flash_type'] === 'success' ? 'check-circle' : ($_SESSION['flash_type'] === 'error' ? 'exclamation-circle' : 'info-circle'); ?>"></i>
    <?php echo htmlspecialchars($_SESSION['flash_message']); ?>
    <button onclick="this.parentElement.remove()" class="flash-close"><i class="fas fa-times"></i></button>
</div>
<?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
<?php endif; ?>
