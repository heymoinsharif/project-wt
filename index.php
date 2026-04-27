<?php
$pageTitle   = 'Home';
$currentPage = 'home';
include 'includes/header.php';
?>

<!-- HERO SECTION -->
<section class="hero" id="hero">
  <div>
    <div class="hero-badge">🚀 Your Productivity Companion</div>
    <h1>Manage Tasks,<br><span>Achieve More.</span></h1>
    <p>TaskFlow is a smart, elegant task management app that helps you stay organized, hit your deadlines, and get things done — beautifully.</p>
    <div class="hero-btns">
      <a href="register.php" class="btn btn-primary" id="heroGetStarted">Get Started Free</a>
      <a href="#features" class="btn btn-outline" id="heroLearnMore">Explore Features</a>
    </div>
  </div>
</section>

<!-- STATS BAR -->
<div class="stats-bar">
  <div class="stats-grid">
    <div>
      <div class="stat-num"><span class="count-up" data-target="1200">0</span>+</div>
      <div class="stat-label">Tasks Managed</div>
    </div>
    <div>
      <div class="stat-num"><span class="count-up" data-target="320">0</span>+</div>
      <div class="stat-label">Active Users</div>
    </div>
    <div>
      <div class="stat-num"><span class="count-up" data-target="98">0</span>%</div>
      <div class="stat-label">Satisfaction Rate</div>
    </div>
    <div>
      <div class="stat-num"><span class="count-up" data-target="7">0</span></div>
      <div class="stat-label">Full Pages</div>
    </div>
  </div>
</div>

<!-- FEATURES SECTION -->
<section class="section" id="features">
  <h2 class="section-title">Everything You Need</h2>
  <p class="section-sub">A complete toolkit to help you plan, track and achieve your goals.</p>
  <div class="features-grid">
    <div class="feature-card">
      <div class="feature-icon">📋</div>
      <h3>Task Management</h3>
      <p>Create, update, and delete tasks with titles, descriptions, priorities, and due dates.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">🔐</div>
      <h3>Secure Authentication</h3>
      <p>Password hashing with PHP, session management, and "Remember Me" cookie support.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">📊</div>
      <h3>Progress Dashboard</h3>
      <p>Visual stats showing pending, in-progress, and completed tasks at a glance.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">📱</div>
      <h3>Fully Responsive</h3>
      <p>Works flawlessly on desktop, tablet, and mobile devices using pure CSS.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">🖼️</div>
      <h3>Profile & Uploads</h3>
      <p>Personalize your account with a custom profile picture via PHP file uploads.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">✅</div>
      <h3>Smart Filtering</h3>
      <p>Filter tasks by status instantly with dynamic JavaScript — no page reload.</p>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="section" style="background:var(--bg-card2);border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
  <h2 class="section-title">How It Works</h2>
  <p class="section-sub">Three simple steps to a more productive you.</p>
  <div class="features-grid" style="max-width:900px;margin:0 auto;">
    <div class="feature-card" style="text-align:center;">
      <div class="feature-icon" style="margin:0 auto 20px;">1️⃣</div>
      <h3>Register / Login</h3>
      <p>Create your free account securely or log in to access your personal dashboard.</p>
    </div>
    <div class="feature-card" style="text-align:center;">
      <div class="feature-icon" style="margin:0 auto 20px;">2️⃣</div>
      <h3>Add Your Tasks</h3>
      <p>Create tasks with priorities, due dates, and detailed descriptions from any device.</p>
    </div>
    <div class="feature-card" style="text-align:center;">
      <div class="feature-icon" style="margin:0 auto 20px;">3️⃣</div>
      <h3>Track & Complete</h3>
      <p>Update task statuses, monitor progress on your dashboard, and celebrate done tasks.</p>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section" style="text-align:center;">
  <h2 class="section-title">Ready to Get Organized?</h2>
  <p class="section-sub">Join TaskFlow today and take control of your productivity.</p>
  <a href="register.php" class="btn btn-primary" id="ctaRegister" style="font-size:1.1rem;padding:16px 40px;">Create Your Free Account →</a>
</section>

<?php include 'includes/footer.php'; ?>
