<?php
$pageTitle   = 'Task';
$currentPage = 'dashboard';
include 'includes/header.php';
require_once 'config/db.php';

// Auth guard
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = (int)$_SESSION['user_id'];
$error   = '';
$task    = null;
$isEdit  = false;

// Load task for editing
if (isset($_GET['id'])) {
    $tid  = (int)$_GET['id'];
    $res  = mysqli_query($conn, "SELECT * FROM tasks WHERE id=$tid AND user_id=$user_id LIMIT 1");
    if ($res && mysqli_num_rows($res) === 1) {
        $task   = mysqli_fetch_assoc($res);
        $isEdit = true;
        $pageTitle = 'Edit Task';
    } else {
        header('Location: dashboard.php');
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim(mysqli_real_escape_string($conn, $_POST['title']       ?? ''));
    $description = trim(mysqli_real_escape_string($conn, $_POST['description'] ?? ''));
    $priority    = mysqli_real_escape_string($conn, $_POST['priority']  ?? 'medium');
    $status      = mysqli_real_escape_string($conn, $_POST['status']    ?? 'pending');
    $due_date    = mysqli_real_escape_string($conn, $_POST['due_date']  ?? '');

    // Validate priority and status
    $valid_priorities = ['low','medium','high'];
    $valid_statuses   = ['pending','in_progress','completed'];
    if (!in_array($priority, $valid_priorities)) $priority = 'medium';
    if (!in_array($status,   $valid_statuses))   $status   = 'pending';

    if (strlen($title) < 3) {
        $error = 'Task title must be at least 3 characters.';
    } else {
        $due_val = $due_date ? "'$due_date'" : 'NULL';

        if ($isEdit) {
            $tid = (int)$_POST['task_id'];
            mysqli_query($conn, "UPDATE tasks SET title='$title', description='$description',
                priority='$priority', status='$status', due_date=$due_val
                WHERE id=$tid AND user_id=$user_id");
            $_SESSION['flash'] = "Task \"$title\" updated successfully!";
        } else {
            mysqli_query($conn, "INSERT INTO tasks (user_id, title, description, priority, status, due_date)
                VALUES ($user_id, '$title', '$description', '$priority', '$status', $due_val)");
            $_SESSION['flash'] = "Task \"$title\" created successfully!";
        }
        header('Location: dashboard.php');
        exit;
    }
}
?>

<div class="dash-layout">
  <!-- SIDEBAR (same as dashboard) -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-user">
      <img src="<?= htmlspecialchars($_SESSION['profile_pic'] ?? 'uploads/default_avatar.png') ?>"
           alt="Avatar" class="sidebar-avatar" onerror="this.src='uploads/default_avatar.png'" />
      <div>
        <div class="sidebar-username"><?= htmlspecialchars($_SESSION['username']) ?></div>
        <div class="sidebar-email"><?= htmlspecialchars($_SESSION['email'] ?? '') ?></div>
      </div>
    </div>
    <ul class="sidebar-nav">
      <li><a href="dashboard.php"><span class="icon">📋</span> My Tasks</a></li>
      <li><a href="task_form.php" class="active"><span class="icon">➕</span> Add Task</a></li>
      <li><a href="profile.php"><span class="icon">👤</span> Profile</a></li>
      <li><a href="about.php"><span class="icon">📖</span> About</a></li>
      <li class="logout-link" style="margin-top:20px;border-top:1px solid var(--border);padding-top:16px;">
        <a href="logout.php"><span class="icon">🚪</span> Logout</a>
      </li>
    </ul>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="dash-content">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:8px;">
      <div>
        <h1 class="page-title"><?= $isEdit ? '✏️ Edit Task' : '➕ New Task' ?></h1>
        <p class="page-sub"><?= $isEdit ? 'Update task details below.' : 'Fill in the details to create a new task.' ?></p>
      </div>
      <div style="display:flex;gap:10px;">
        <button class="btn btn-outline btn-sm" id="sidebarToggle" style="display:none;">☰</button>
        <a href="dashboard.php" class="btn btn-outline btn-sm" id="backDash">← Back</a>
      </div>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="card" style="max-width:680px;">
      <form id="taskForm" method="POST" action="task_form.php<?= $isEdit ? '?id='.$task['id'] : '' ?>" novalidate>
        <?php if ($isEdit): ?>
          <input type="hidden" name="task_id" value="<?= (int)$task['id'] ?>" />
        <?php endif; ?>

        <div class="form-group">
          <label for="title">Task Title <span style="color:var(--danger);">*</span></label>
          <input type="text" id="title" name="title" placeholder="e.g. Complete project report"
                 value="<?= htmlspecialchars($task['title'] ?? $_POST['title'] ?? '') ?>" />
          <div class="error-msg">Title must be at least 3 characters.</div>
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea id="description" name="description" placeholder="Add details about this task..."><?= htmlspecialchars($task['description'] ?? $_POST['description'] ?? '') ?></textarea>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="priority">Priority</label>
            <select id="priority" name="priority">
              <option value="low"    <?= ($task['priority'] ?? '') === 'low'    ? 'selected' : '' ?>>🟢 Low</option>
              <option value="medium" <?= ($task['priority'] ?? 'medium') === 'medium' ? 'selected' : '' ?>>🟡 Medium</option>
              <option value="high"   <?= ($task['priority'] ?? '') === 'high'   ? 'selected' : '' ?>>🔴 High</option>
            </select>
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
              <option value="pending"     <?= ($task['status'] ?? 'pending') === 'pending'     ? 'selected' : '' ?>>⏳ Pending</option>
              <option value="in_progress" <?= ($task['status'] ?? '') === 'in_progress' ? 'selected' : '' ?>>🔄 In Progress</option>
              <option value="completed"   <?= ($task['status'] ?? '') === 'completed'   ? 'selected' : '' ?>>✅ Completed</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="due_date">Due Date</label>
          <input type="date" id="due_date" name="due_date"
                 value="<?= htmlspecialchars($task['due_date'] ?? $_POST['due_date'] ?? '') ?>"
                 min="<?= date('Y-m-d') ?>" />
        </div>

        <div style="display:flex;gap:12px;flex-wrap:wrap;">
          <button type="submit" class="btn btn-primary" id="saveTaskBtn">
            <?= $isEdit ? '💾 Save Changes' : '✅ Create Task' ?>
          </button>
          <a href="dashboard.php" class="btn btn-outline" id="cancelTaskBtn">Cancel</a>
        </div>
      </form>
    </div>
  </main>
</div>

<style>@media(max-width:900px){#sidebarToggle{display:inline-flex!important;}}</style>
<?php include 'includes/footer.php'; ?>
