<?php
/**
 * FitForge | About Page
 */
require_once 'includes/db_connect.php';
$page_title = 'About Us';
include 'includes/header.php';
?>

<div class="container" style="padding-top: calc(var(--nav-height) + var(--spacing-xl)); min-height: 80vh;">
    <div class="section-header">
        <h1 class="section-title">About <span class="text-gradient">FitForge</span></h1>
        <p class="section-subtitle">Forging stronger bodies and sharper minds through technology.</p>
    </div>

    <div class="grid grid-2" style="align-items: center;">
        <div>
            <h2 style="color: var(--primary);">Our Mission</h2>
            <p style="color: var(--text-muted); font-size: 1.1rem; margin-bottom: 20px;">
                At FitForge, we believe that fitness is not just a hobby—it's a lifestyle. Our mission is to provide an accessible, powerful, and beautiful platform that empowers individuals to take control of their health journey.
            </p>
            <p style="color: var(--text-muted); font-size: 1.1rem; margin-bottom: 20px;">
                Built as a Capstone Web Project, this application demonstrates the seamless integration of frontend design (HTML, CSS, JS) with a robust backend architecture (PHP, MySQL).
            </p>
            
            <div style="margin-top: 30px; display: flex; gap: 20px;">
                <div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: var(--radius-sm); flex: 1; text-align: center;">
                    <h3 style="color: var(--secondary); margin-bottom: 5px;">10k+</h3>
                    <p style="font-size: 0.9rem; color: var(--text-muted);">Lines of Code</p>
                </div>
                <div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: var(--radius-sm); flex: 1; text-align: center;">
                    <h3 style="color: var(--accent); margin-bottom: 5px;">100%</h3>
                    <p style="font-size: 0.9rem; color: var(--text-muted);">Responsive</p>
                </div>
            </div>
        </div>
        
        <div class="card" style="padding: 0; overflow: hidden; border: none;">
            <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=1470&auto=format&fit=crop" alt="Gym Workout" style="width: 100%; height: 100%; object-fit: cover; display: block;">
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
