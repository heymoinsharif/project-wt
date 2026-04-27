<?php
$pageTitle   = 'Register';
$currentPage = 'register';
include 'includes/header.php';
require_once 'config/db.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username'] ?? ''));
    $email    = trim(mysqli_real_escape_string($conn, $_POST['email']    ?? ''));
    $password = $_POST['password']         ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // Server-side validation
    if (strlen($username) < 3) {
        $error = 'Username must be at least 3 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        // Check if user exists
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' OR username='$username'");
        if (mysqli_num_rows($check) > 0) {
            $error = 'Username or email is already registered.';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $insert = mysqli_query($conn,
                "INSERT INTO users (username, email, password) VALUES ('$username','$email','$hashed')"
            );
            if ($insert) {
                $success = 'Account created successfully! Redirecting to login...';
                header('Refresh: 2; url=login.php');
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>

<div class="form-page">
  <div class="form-box">
    <h2>Create Account</h2>
    <p class="sub">Join TaskFlow and start organizing your tasks today.</p>

    <?php if ($error): ?>
      <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="alert alert-success">✅ <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form id="registerForm" method="POST" action="register.php" novalidate>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="e.g. john_doe"
               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" autocomplete="username" />
        <div class="error-msg">Username must be at least 3 characters.</div>
      </div>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="you@example.com"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" autocomplete="email" />
        <div class="error-msg">Please enter a valid email address.</div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Min. 6 chars" autocomplete="new-password" />
          <div class="error-msg">Password must be at least 6 characters.</div>
          <!-- Strength indicator -->
          <div style="margin-top:8px;display:flex;align-items:center;gap:10px;">
            <div class="progress-bar" style="flex:1;"><div class="progress-fill" id="passBar" style="width:0%;"></div></div>
            <span id="passStrength" style="font-size:0.78rem;color:var(--text-muted);width:46px;"></span>
          </div>
        </div>
        <div class="form-group">
          <label for="confirm_password">Confirm Password</label>
          <input type="password" id="confirm_password" name="confirm_password" placeholder="Repeat password" autocomplete="new-password" />
          <div class="error-msg">Passwords do not match.</div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;" id="registerBtn">
        Create Account →
      </button>
    </form>

    <div class="form-link">Already have an account? <a href="login.php" id="goLogin">Sign In</a></div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
