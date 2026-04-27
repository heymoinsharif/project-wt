<?php
$pageTitle   = 'Profile';
$currentPage = 'profile';
include 'includes/header.php';
require_once 'config/db.php';

// Auth guard
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = (int)$_SESSION['user_id'];
$error   = '';
$success = '';

// Fetch fresh user data from DB
$userRes = mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id LIMIT 1");
$user    = mysqli_fetch_assoc($userRes);

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username'] ?? ''));
    $email    = trim(mysqli_real_escape_string($conn, $_POST['email']    ?? ''));
    $new_pass = $_POST['new_password'] ?? '';
    $pic_path = $user['profile_pic']; // default to existing

    // Validate username & email
    if (strlen($username) < 3) {
        $error = 'Username must be at least 3 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } else {
        // --- File Upload ---
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
            $file      = $_FILES['profile_pic'];
            $allowed   = ['image/jpeg','image/png','image/gif','image/webp'];
            $max_size  = 2 * 1024 * 1024; // 2 MB

            if (!in_array($file['type'], $allowed)) {
                $error = 'Only JPG, PNG, GIF, and WEBP images are allowed.';
            } elseif ($file['size'] > $max_size) {
                $error = 'Image must be smaller than 2 MB.';
            } else {
                $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = 'user_' . $user_id . '_' . time() . '.' . $ext;
                $dest     = 'uploads/' . $filename;
                if (!is_dir('uploads')) mkdir('uploads', 0755, true);
                if (move_uploaded_file($file['tmp_name'], $dest)) {
                    $pic_path = $dest;
                } else {
                    $error = 'Failed to upload image. Check folder permissions.';
                }
            }
        }

        if (!$error) {
            // Update password if provided
            if ($new_pass !== '') {
                if (strlen($new_pass) < 6) {
                    $error = 'New password must be at least 6 characters.';
                } else {
                    $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
                    mysqli_query($conn, "UPDATE users SET password='$hashed' WHERE id=$user_id");
                }
            }

            if (!$error) {
                // Update profile info
                $pic_safe = mysqli_real_escape_string($conn, $pic_path);
                mysqli_query($conn, "UPDATE users SET username='$username', email='$email', profile_pic='$pic_safe' WHERE id=$user_id");

                // Refresh session
                $_SESSION['username']    = $username;
                $_SESSION['email']       = $email;
                $_SESSION['profile_pic'] = $pic_path;

                $success = 'Profile updated successfully!';
                // Refresh user data
                $userRes = mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id LIMIT 1");
                $user    = mysqli_fetch_assoc($userRes);
            }
        }
    }
}

// Task stats for profile card
$statsRes = mysqli_query($conn, "SELECT status, COUNT(*) as cnt FROM tasks WHERE user_id=$user_id GROUP BY status");
$stats = ['pending'=>0,'in_progress'=>0,'completed'=>0,'total'=>0];
while ($row = mysqli_fetch_assoc($statsRes)) {
    $stats[$row['status']] = (int)$row['cnt'];
    $stats['total'] += (int)$row['cnt'];
}
?>

<div class="dash-layout">
  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-user">
      <img src="<?= htmlspecialchars($user['profile_pic']) ?>" alt="Avatar" class="sidebar-avatar"
           onerror="this.src='uploads/default_avatar.png'" />
      <div>
        <div class="sidebar-username"><?= htmlspecialchars($user['username']) ?></div>
        <div class="sidebar-email"><?= htmlspecialchars($user['email']) ?></div>
      </div>
    </div>
    <ul class="sidebar-nav">
      <li><a href="dashboard.php"><span class="icon">📋</span> My Tasks</a></li>
      <li><a href="task_form.php"><span class="icon">➕</span> Add Task</a></li>
      <li><a href="profile.php" class="active"><span class="icon">👤</span> Profile</a></li>
      <li><a href="about.php"><span class="icon">📖</span> About</a></li>
      <li class="logout-link" style="margin-top:20px;border-top:1px solid var(--border);padding-top:16px;">
        <a href="logout.php"><span class="icon">🚪</span> Logout</a>
      </li>
    </ul>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="dash-content">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;flex-wrap:wrap;gap:12px;">
      <div>
        <h1 class="page-title">👤 My Profile</h1>
        <p class="page-sub">Manage your account details and profile picture.</p>
      </div>
      <button class="btn btn-outline btn-sm" id="sidebarToggle" style="display:none;">☰</button>
    </div>

    <?php if ($error):   ?><div class="alert alert-danger">⚠️  <?= htmlspecialchars($error)   ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success">✅ <?= htmlspecialchars($success) ?></div><?php endif; ?>

    <div class="profile-grid">
      <!-- Profile Card -->
      <div class="profile-card">
        <div class="profile-avatar-wrap">
          <img src="<?= htmlspecialchars($user['profile_pic']) ?>"
               alt="Profile Picture" class="profile-avatar" id="avatarPreview"
               onerror="this.src='uploads/default_avatar.png'" />
          <label for="profile_pic" class="avatar-edit" title="Change photo">📷</label>
        </div>
        <div class="profile-name"><?= htmlspecialchars($user['username']) ?></div>
        <div class="profile-email"><?= htmlspecialchars($user['email']) ?></div>
        <div class="profile-joined">Joined <?= date('d M Y', strtotime($user['created_at'])) ?></div>

        <!-- Mini stats -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:24px;text-align:center;">
          <div style="background:var(--bg-card2);border-radius:10px;padding:14px;">
            <div style="font-size:1.5rem;font-weight:800;color:var(--primary);"><?= $stats['total'] ?></div>
            <div style="font-size:0.78rem;color:var(--text-muted);">Total Tasks</div>
          </div>
          <div style="background:var(--bg-card2);border-radius:10px;padding:14px;">
            <div style="font-size:1.5rem;font-weight:800;color:var(--success);"><?= $stats['completed'] ?></div>
            <div style="font-size:0.78rem;color:var(--text-muted);">Completed</div>
          </div>
        </div>
      </div>

      <!-- Edit Form -->
      <div class="card">
        <h3 style="font-size:1.2rem;font-weight:700;margin-bottom:24px;">Edit Profile</h3>
        <form method="POST" action="profile.php" enctype="multipart/form-data" id="profileForm">

          <!-- Hidden file input triggered by avatar label -->
          <input type="file" id="profile_pic" name="profile_pic" accept="image/*"
                 style="display:none;" />

          <div class="form-group">
            <label for="p_username">Username</label>
            <input type="text" id="p_username" name="username"
                   value="<?= htmlspecialchars($user['username']) ?>" />
          </div>

          <div class="form-group">
            <label for="p_email">Email Address</label>
            <input type="email" id="p_email" name="email"
                   value="<?= htmlspecialchars($user['email']) ?>" />
          </div>

          <div style="border-top:1px solid var(--border);padding-top:20px;margin-top:8px;margin-bottom:20px;">
            <h4 style="font-size:0.95rem;font-weight:600;margin-bottom:16px;color:var(--text-muted);">Change Password (optional)</h4>
            <div class="form-group">
              <label for="new_password">New Password</label>
              <input type="password" id="new_password" name="new_password" placeholder="Leave blank to keep current" />
            </div>
          </div>

          <div style="background:rgba(108,99,255,0.08);border:1px dashed var(--border);border-radius:10px;padding:14px;margin-bottom:20px;font-size:0.85rem;color:var(--text-muted);">
            📷 To change your profile photo, click the camera icon on your avatar. Max size: <strong>2 MB</strong>. Formats: JPG, PNG, GIF, WEBP.
          </div>

          <button type="submit" class="btn btn-primary" id="saveProfileBtn">💾 Save Changes</button>
        </form>
      </div>
    </div>
  </main>
</div>

<style>@media(max-width:900px){#sidebarToggle{display:inline-flex!important;}}</style>
<?php include 'includes/footer.php'; ?>
