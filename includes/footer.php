<?php
/**
 * FitForge | Footer Include
 */
?>
<footer class="footer">
    <div class="footer-container">
        <div class="footer-brand">
            <a href="index.php" class="nav-logo">
                <span class="logo-icon"><i class="fas fa-bolt"></i></span>
                <span class="logo-text">Fit<span class="logo-accent">Forge</span></span>
            </a>
            <p>Your ultimate fitness companion. Build strength, track progress, and forge the best version of yourself.</p>
            <div class="footer-social">
                <a href="#" aria-label="Instagram" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Twitter" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="YouTube" class="social-icon"><i class="fab fa-youtube"></i></a>
                <a href="#" aria-label="GitHub" class="social-icon"><i class="fab fa-github"></i></a>
            </div>
        </div>

        <div class="footer-links">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="index.php"><i class="fas fa-chevron-right"></i> Home</a></li>
                <li><a href="about.php"><i class="fas fa-chevron-right"></i> About</a></li>
                <li><a href="tools.php"><i class="fas fa-chevron-right"></i> Fitness Tools</a></li>
                <li><a href="contact.php"><i class="fas fa-chevron-right"></i> Contact</a></li>
            </ul>
        </div>

        <div class="footer-links">
            <h4>Tools</h4>
            <ul>
                <li><a href="tools.php#bmi"><i class="fas fa-chevron-right"></i> BMI Calculator</a></li>
                <li><a href="tools.php#calorie"><i class="fas fa-chevron-right"></i> Calorie Calculator</a></li>
                <li><a href="tools.php#quotes"><i class="fas fa-chevron-right"></i> Motivation</a></li>
                <li><a href="tools.php#workout"><i class="fas fa-chevron-right"></i> Workout Planner</a></li>
            </ul>
        </div>

        <div class="footer-newsletter">
            <h4>Stay Motivated</h4>
            <p>Get daily fitness tips right in your inbox.</p>
            <div class="newsletter-form">
                <input type="email" id="newsletterEmail" placeholder="Enter your email" />
                <button type="button" onclick="subscribeNewsletter()" class="btn-primary btn-sm">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
            <div id="newsletterMsg" class="newsletter-msg"></div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> FitForge. Built with <span class="heart">❤️</span> for the Capstone Web Project.</p>
        <p class="footer-tech">HTML &bull; CSS &bull; JavaScript &bull; PHP &bull; MySQL</p>
    </div>
</footer>

<!-- Main JavaScript -->
<script src="assets/js/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>
