<?php
/**
 * FitForge | Authentication Page (Login & Register)
 */
require_once 'includes/db_connect.php';
session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$page_title = 'Login & Register';
$auth_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'register') {
        $username = trim($_POST['reg_username'] ?? '');
        $email = trim($_POST['reg_email'] ?? '');
        $password = $_POST['reg_password'] ?? '';
        $confirm = $_POST['reg_confirm'] ?? '';

        if (empty($username) || empty($email) || empty($password)) {
            $auth_error = "All registration fields are required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $auth_error = "Invalid email format.";
        } elseif ($password !== $confirm) {
            $auth_error = "Passwords do not match.";
        } elseif (strlen($password) < 6) {
            $auth_error = "Password must be at least 6 characters.";
        } else {
            // Check if user exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->fetch()) {
                $auth_error = "Username or Email already exists.";
            } else {
                // Register new user
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
                if ($stmt->execute([$username, $email, $hash])) {
                    $_SESSION['flash_message'] = "Registration successful! Please login.";
                    $_SESSION['flash_type'] = "success";
                    header("Location: auth.php");
                    exit();
                } else {
                    $auth_error = "Registration failed. Try again.";
                }
            }
        }
    } elseif ($action === 'login') {
        $username = trim($_POST['log_username'] ?? '');
        $password = $_POST['log_password'] ?? '';

        if (empty($username) || empty($password)) {
            $auth_error = "Both fields are required to login.";
        } else {
            $stmt = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['flash_message'] = "Welcome back, " . htmlspecialchars($user['username']) . "!";
                $_SESSION['flash_type'] = "success";
                
                header("Location: dashboard.php");
                exit();
            } else {
                $auth_error = "Invalid username/email or password.";
            }
        }
    }
}

// Don't start session again in header
$skip_session_start = true;
include 'includes/header.php';
?>

<div class="container" style="padding-top: calc(var(--nav-height) + var(--spacing-xl)); min-height: 80vh; display: flex; justify-content: center; align-items: center;">
    
    <div class="card" style="width: 100%; max-width: 500px;">
        
        <?php if (!empty($auth_error)): ?>
            <div style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #ef4444; padding: 15px; border-radius: var(--radius-sm); margin-bottom: 20px;">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($auth_error); ?>
            </div>
        <?php endif; ?>

        <!-- Tabs -->
        <div style="display: flex; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px;">
            <button id="tabLogin" class="btn" style="flex: 1; background: transparent; border-radius: 0; color: var(--primary); border-bottom: 2px solid var(--primary);" onclick="switchTab('login')">Login</button>
            <button id="tabRegister" class="btn" style="flex: 1; background: transparent; border-radius: 0; color: var(--text-muted); border-bottom: 2px solid transparent;" onclick="switchTab('register')">Register</button>
        </div>

        <!-- Login Form -->
        <form id="formLogin" method="POST" action="auth.php">
            <input type="hidden" name="action" value="login">
            <div class="form-group">
                <label class="form-label" for="log_username">Username or Email</label>
                <input type="text" id="log_username" name="log_username" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="log_password">Password</label>
                <input type="password" id="log_password" name="log_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Login</button>
        </form>

        <!-- Register Form -->
        <form id="formRegister" method="POST" action="auth.php" style="display: none;">
            <input type="hidden" name="action" value="register">
            <div class="form-group">
                <label class="form-label" for="reg_username">Username</label>
                <input type="text" id="reg_username" name="reg_username" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="reg_email">Email</label>
                <input type="email" id="reg_email" name="reg_email" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="reg_password">Password</label>
                <input type="password" id="reg_password" name="reg_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="reg_confirm">Confirm Password</label>
                <input type="password" id="reg_confirm" name="reg_confirm" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-accent" style="width: 100%; margin-top: 10px;">Create Account</button>
        </form>

    </div>
</div>

<script>
function switchTab(tab) {
    const fLogin = document.getElementById('formLogin');
    const fReg = document.getElementById('formRegister');
    const tLogin = document.getElementById('tabLogin');
    const tReg = document.getElementById('tabRegister');

    if (tab === 'login') {
        fLogin.style.display = 'block';
        fReg.style.display = 'none';
        tLogin.style.color = 'var(--primary)';
        tLogin.style.borderBottomColor = 'var(--primary)';
        tReg.style.color = 'var(--text-muted)';
        tReg.style.borderBottomColor = 'transparent';
    } else {
        fLogin.style.display = 'none';
        fReg.style.display = 'block';
        tReg.style.color = 'var(--accent)';
        tReg.style.borderBottomColor = 'var(--accent)';
        tLogin.style.color = 'var(--text-muted)';
        tLogin.style.borderBottomColor = 'transparent';
    }
}
</script>

<?php include 'includes/footer.php'; ?>
