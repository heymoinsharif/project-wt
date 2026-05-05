<?php
/**
 * FitForge | Home Page
 */
require_once 'includes/db_connect.php';
$page_title = 'Home';
include 'includes/header.php';
?>

<!-- Hero Section -->
<header class="hero" style="min-height: 100vh; display: flex; align-items: center; text-align: center; padding-top: var(--nav-height);">
    <div class="container">
        <h1 class="section-title" style="font-size: 4rem; margin-bottom: 20px;">
            Forge Your <span class="text-gradient">Ultimate Form</span>
        </h1>
        <p class="section-subtitle" style="font-size: 1.2rem; margin-bottom: 40px; color: var(--text-main);">
            Join the premium fitness platform designed to track your progress, calculate your metrics, and keep you motivated every step of the way.
        </p>
        <div class="hero-actions">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="btn btn-primary" style="font-size: 1.1rem; padding: 1rem 2.5rem;">Go to Dashboard</a>
            <?php else: ?>
                <a href="auth.php" class="btn btn-primary" style="font-size: 1.1rem; padding: 1rem 2.5rem;">Start Free Journey</a>
            <?php endif; ?>
            <a href="tools.php" class="btn btn-outline" style="font-size: 1.1rem; padding: 1rem 2.5rem; margin-left: 15px;">Explore Tools</a>
        </div>
    </div>
</header>

<!-- Features Section -->
<section class="container">
    <div class="section-header">
        <h2 class="section-title">Everything You Need</h2>
        <p class="section-subtitle">A comprehensive suite of tools built for real results.</p>
    </div>

    <div class="grid grid-3">
        <!-- Feature 1 -->
        <div class="card" style="text-align: center;">
            <i class="fas fa-calculator" style="font-size: 3rem; color: var(--secondary); margin-bottom: 20px;"></i>
            <h3>Advanced BMI Calculator</h3>
            <p style="color: var(--text-muted); margin-top: 10px;">Instantly calculate your Body Mass Index and find out which health category you belong to with our dynamic tool.</p>
        </div>
        
        <!-- Feature 2 -->
        <div class="card" style="text-align: center;">
            <i class="fas fa-fire" style="font-size: 3rem; color: var(--accent); margin-bottom: 20px;"></i>
            <h3>Daily Motivation</h3>
            <p style="color: var(--text-muted); margin-top: 10px;">Lacking energy? Hit our motivation generator to get a random, hard-hitting quote to fuel your next workout.</p>
        </div>

        <!-- Feature 3 -->
        <div class="card" style="text-align: center;">
            <i class="fas fa-chart-pie" style="font-size: 3rem; color: var(--primary); margin-bottom: 20px;"></i>
            <h3>Progress Tracking</h3>
            <p style="color: var(--text-muted); margin-top: 10px;">Create an account to access a personalized dashboard where you can log workouts and see your stats.</p>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section style="background: linear-gradient(rgba(15,23,42,0.9), rgba(15,23,42,0.9)), url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1470&auto=format&fit=crop'); background-size: cover; background-position: center; padding: var(--spacing-xl) 0; margin-top: var(--spacing-xl); text-align: center;">
    <div class="container">
        <h2 class="section-title text-gradient">Ready to Transform?</h2>
        <p style="max-width: 600px; margin: 20px auto 40px; font-size: 1.2rem;">Join FitForge today. It only takes 30 seconds to sign up and start utilizing our premium tools.</p>
        <a href="auth.php" class="btn btn-primary" style="font-size: 1.2rem;">Create Account Now <i class="fas fa-arrow-right" style="margin-left: 8px;"></i></a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
