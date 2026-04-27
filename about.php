<?php
$pageTitle   = 'About';
$currentPage = 'about';
include 'includes/header.php';
?>

<!-- ABOUT HERO -->
<section class="about-hero">
  <div class="hero-badge">📖 Our Story</div>
  <h1>Built for <span style="background:linear-gradient(135deg,var(--primary),var(--secondary));-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Doers</span></h1>
  <p style="color:var(--text-muted);font-size:1.1rem;max-width:540px;margin:0 auto;">TaskFlow was designed as a Capstone project for Web Technologies (23CSE404), demonstrating a fully integrated HTML, CSS, JavaScript, PHP, and MySQL web application.</p>
</section>

<!-- ABOUT CONTENT -->
<div class="about-content">
  <div class="about-block">
    <h2>🎯 Our Mission</h2>
    <p>TaskFlow aims to make personal task management simple, beautiful, and effective. We believe that great software should be accessible to everyone — from students to professionals — and should never compromise on design or functionality.</p>
    <p style="margin-top:14px;">Every feature in TaskFlow is crafted with purpose: clean code, secure architecture, and a premium user experience that rivals modern productivity tools.</p>
  </div>
  <div class="about-block">
    <h2>⚙️ Technology Stack</h2>
    <p>TaskFlow is built entirely with core web technologies, showcasing real-world integration across the full stack:</p>
    <div class="tech-stack" style="margin-top:18px;">
      <span class="tech-badge">HTML5</span>
      <span class="tech-badge">CSS3</span>
      <span class="tech-badge">JavaScript (ES6+)</span>
      <span class="tech-badge">PHP 8</span>
      <span class="tech-badge">MySQL</span>
      <span class="tech-badge">Sessions & Cookies</span>
      <span class="tech-badge">File Uploads</span>
      <span class="tech-badge">CRUD Operations</span>
    </div>
  </div>
</div>

<!-- FEATURES DETAIL -->
<div style="padding:0 5% 80px;">
  <h2 class="section-title" style="text-align:left;margin-bottom:28px;">What's Under the Hood</h2>
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;">
    <?php
    $features = [
      ['icon'=>'🏗️','title'=>'Multi-Page Structure','desc'=>'7 logically connected pages with consistent navigation, styling, and information architecture.'],
      ['icon'=>'📐','title'=>'Responsive CSS Layout','desc'=>'Box Model, Flexbox, and media queries ensure perfect rendering on every device and screen size.'],
      ['icon'=>'⚡','title'=>'DHTML & JS Validation','desc'=>'Real-time client-side form validation, animated counters, modal dialogs, and dynamic task filtering.'],
      ['icon'=>'🔄','title'=>'PHP Sessions & Cookies','desc'=>'Secure login sessions and "Remember Me" cookies persist across pages to protect user data.'],
      ['icon'=>'🗄️','title'=>'MySQL CRUD','desc'=>'Full Create, Read, Update, Delete operations on tasks and user accounts via PHP and MySQL.'],
      ['icon'=>'📁','title'=>'File Uploads','desc'=>'Profile picture upload with PHP validation of file type, size, and secure storage on the server.'],
    ];
    foreach($features as $f): ?>
    <div class="feature-card">
      <div class="feature-icon"><?= $f['icon'] ?></div>
      <h3><?= $f['title'] ?></h3>
      <p><?= $f['desc'] ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- BLOOM'S TAXONOMY TABLE -->
<div style="padding:0 5% 80px;">
  <h2 class="section-title" style="text-align:left;margin-bottom:24px;">Bloom's Taxonomy Alignment</h2>
  <div class="task-table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Level</th>
          <th>Bloom's Level</th>
          <th>Application in TaskFlow</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $blooms = [
          ['1','Remember','HTML tags, CSS properties, PHP syntax, MySQL queries used throughout.'],
          ['2','Understand','Explains DOM manipulation, PHP session flow, and database connectivity.'],
          ['3','Apply','HTML/CSS pages, JS validation, PHP-MySQL CRUD fully implemented.'],
          ['4','Analyze','Debug-ready code structure with clear data flow from frontend to backend.'],
          ['5','Evaluate','Responsive design, security (password hashing), and performance considered.'],
          ['6','Create','A fully original, functional multi-page web application from scratch.'],
        ];
        foreach($blooms as $b): ?>
        <tr>
          <td><span class="badge badge-in_progress"><?= $b[0] ?></span></td>
          <td><strong><?= $b[1] ?></strong></td>
          <td style="color:var(--text-muted);"><?= $b[2] ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- COURSE INFO -->
<div style="padding:0 5% 80px;">
  <div class="card" style="max-width:640px;margin:0 auto;text-align:center;">
    <div style="font-size:2.5rem;margin-bottom:16px;">🎓</div>
    <h2 style="margin-bottom:10px;">Course Information</h2>
    <p style="color:var(--text-muted);margin-bottom:20px;">This project fulfills all requirements of the WEB TECHNOLOGIES (23CSE404) Capstone Web Project as defined by the Teaching, Learning & Evaluation Plan.</p>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;text-align:left;">
      <div><span style="color:var(--text-muted);font-size:0.85rem;">Course</span><br><strong>23CSE404</strong></div>
      <div><span style="color:var(--text-muted);font-size:0.85rem;">Instructor</span><br><strong>Mir Junaid Rasool</strong></div>
      <div><span style="color:var(--text-muted);font-size:0.85rem;">Total Marks</span><br><strong>50</strong></div>
      <div><span style="color:var(--text-muted);font-size:0.85rem;">Topic</span><br><strong>Task Management App</strong></div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
