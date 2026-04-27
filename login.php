<?php
$pageTitle   = 'Login';
$currentPage = 'login';
include 'includes/header.php';
require_once 'config/db.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

// Pre-fill from "Remember Me" cookie
$remembered_email = '';
if (isset($_COOKIE['taskflow_remember'])) {
    $remembered_email = htmlspecialchars($_COOKIE['taskflow_remember']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim(mysqli_real_escape_string($conn, $_POST['login_email']    ?? ''));
    $password = $_POST['login_password'] ?? '';
    $remember = isset($_POST['remember']);

    if ($email === '' || $password === '') {
        $error = 'Please fill in all fields.';
    } else {
        $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' LIMIT 1");
        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email']    = $user['email'];
                $_SESSION['profile_pic'] = $user['profile_pic'];

                // Set / clear "Remember Me" cookie
                if ($remember) {
                    setcookie('taskflow_remember', $email, time() + (30 * 24 * 3600), '/', '', false, true);
                } else {
                    setcookie('taskflow_remember', '', time() - 3600, '/');
                }

                header('Location: dashboard.php');
                exit;
            } else {
                $error = 'Incorrect password. Please try again.';
            }
        } else {
            $error = 'No account found with that email.';
        }
    }
}
?>

<div class="form-page">
  <div class="form-box">
    <h2>Welcome Back 👋</h2>
    <p class="sub">Sign in to your TaskFlow account to continue.</p>

    <?php if ($error): ?>
      <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['registered'])): ?>
      <div class="alert alert-success">✅ Registration successful! Please log in.</div>
    <?php endif; ?>

    <form id="loginForm" method="POST" action="login.php" novalidate>
      <div class="form-group">
        <label for="login_email">Email Address</label>
        <input type="email" id="login_email" name="login_email" placeholder="you@example.com"
               value="<?= $remembered_email ?>" autocomplete="email" />
        <div class="error-msg">Email is required.</div>
      </div>

      <div class="form-group">
        <label for="login_password">Password</label>
        <input type="password" id="login_password" name="login_password" placeholder="Your password" autocomplete="current-password" />
        <div class="error-msg">Password is required.</div>
      </div>

      <div class="remember-row">
        <label for="remember">
          <input type="checkbox" id="remember" name="remember"
                 <?= $remembered_email ? 'checked' : '' ?> />
          Remember Me (30 days)
        </label>
        <a href="#" style="color:var(--primary);font-size:0.88rem;text-decoration:none;" id="forgotLink">Forgot password?</a>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;" id="loginBtn">
        Sign In →
      </button>
    </form>

    <div class="form-link">Don't have an account? <a href="register.php" id="goRegister">Create one</a></div>

    <!-- Demo credentials hint -->
    <div style="margin-top:20px;padding:14px;background:rgba(108,99,255,0.08);border:1px dashed var(--border);border-radius:10px;font-size:0.82rem;color:var(--text-muted);">
      💡 <strong>Demo:</strong> demo@taskflow.com / <em>password</em>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
