<?php
/**
 * FitForge | Contact Page
 * Demonstrates PHP Form Handling & Basic Server-Side Validation
 */
require_once 'includes/db_connect.php';
$page_title = 'Contact';

// Handle form submission
$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Server-side validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error_msg = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "Invalid email format.";
    } else {
        // Insert into database (Assuming a contact_messages table exists, created in database.sql)
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (sender_name, sender_email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $subject, $message]);
            
            $success_msg = "Thank you for reaching out, $name! We'll get back to you soon.";
            
            // Clear fields after success
            $name = $email = $subject = $message = '';
        } catch (PDOException $e) {
            $error_msg = "A database error occurred. Please try again later.";
        }
    }
}

include 'includes/header.php';
?>

<div class="container" style="padding-top: calc(var(--nav-height) + var(--spacing-xl)); min-height: 80vh;">
    <div class="section-header">
        <h1 class="section-title">Get in <span class="text-gradient">Touch</span></h1>
        <p class="section-subtitle">Have a question or feedback? Send us a message.</p>
    </div>

    <div class="grid grid-2">
        <div class="card">
            <h2 style="margin-bottom: 20px;">Send a Message</h2>
            
            <?php if (!empty($success_msg)): ?>
                <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: var(--radius-sm); margin-bottom: 20px;">
                    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success_msg); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($error_msg)): ?>
                <div style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #ef4444; padding: 15px; border-radius: var(--radius-sm); margin-bottom: 20px;">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error_msg); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="contact.php">
                <div class="form-group">
                    <label class="form-label" for="name">Your Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" class="form-control" value="<?php echo htmlspecialchars($subject ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="message">Message</label>
                    <textarea id="message" name="message" class="form-control" rows="5" required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
            </form>
        </div>

        <div style="display: flex; flex-direction: column; gap: 20px;">
            <div class="card">
                <h3 style="color: var(--primary);"><i class="fas fa-map-marker-alt"></i> Location</h3>
                <p style="color: var(--text-muted); margin-top: 10px;">JP NAGAR 5th Block<br>Bangalore, 560078</p>
            </div>
            <div class="card">
                <h3 style="color: var(--secondary);"><i class="fas fa-envelope"></i> Email Us</h3>
                <p style="color: var(--text-muted); margin-top: 10px;">support@fitforge.com<br>info@fitforge.com</p>
            </div>
            <div class="card">
                <h3 style="color: var(--accent);"><i class="fas fa-phone-alt"></i> Call Us</h3>
                <p style="color: var(--text-muted); margin-top: 10px;">+91 9662547869<br>Mon-Sat, 9am - 6pm</p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
