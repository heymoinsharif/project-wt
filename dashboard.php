<?php
$pageTitle   = 'Dashboard';
$currentPage = 'dashboard';
include 'includes/header.php';
require_once 'config/db.php';

// Auth guard
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id  = (int)$_SESSION['user_id'];
$username = htmlspecialchars($_SESSION['username']);
$profile_pic = htmlspecialchars($_SESSION['profile_pic'] ?? 'uploads/default_avatar.png');
$email    = htmlspecialchars($_SESSION['email'] ?? '');

// Fetch task counts
$counts = ['total'=>0,'pending'=>0,'in_progress'=>0,'completed'=>0];
$cRes = mysqli_query($conn, "SELECT status, COUNT(*) as cnt FROM tasks WHERE user_id=$user_id GROUP BY status");
while ($row = mysqli_fetch_assoc($cRes)) {
    $counts[$row['status']] = (int)$row['cnt'];
    $counts['total'] += (int)$row['cnt'];
}

// Fetch all tasks
$tasksRes = mysqli_query($conn, "SELECT * FROM tasks WHERE user_id=$user_id ORDER BY created_at DESC");

// Flash message (after redirect)
$flash = '';
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}
?>

<div class="dash-layout">
  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-user">
      <img src="<?= $profile_pic ?>" alt="Avatar" class="sidebar-avatar" id="sideAvatar" onerror="this.src='uploads/default_avatar.png'" />
      <div>
        <div class="sidebar-username"><?= $username ?></div>
        <div class="sidebar-email"><?= $email ?></div>
      </div>
    </div>
    <ul class="sidebar-nav">
      <li><a href="dashboard.php" class="active"><span class="icon">📋</span> My Tasks</a></li>
      <li><a href="task_form.php"><span class="icon">➕</span> Add Task</a></li>
      <li><a href="profile.php"><span class="icon">👤</span> Profile</a></li>
      <li><a href="about.php"><span class="icon">📖</span> About</a></li>
      <li class="logout-link" style="margin-top:20px;border-top:1px solid var(--border);padding-top:16px;">
        <a href="logout.php" id="sideLogout"><span class="icon">🚪</span> Logout</a>
      </li>
    </ul>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="dash-content">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
      <div>
        <h1 class="page-title">Hello, <?= $username ?>! 👋</h1>
        <p class="page-sub">Here's an overview of your tasks today.</p>
      </div>
      <div style="display:flex;gap:10px;align-items:center;">
        <button class="btn btn-outline btn-sm" id="sidebarToggle" style="display:none;">☰ Menu</button>
        <a href="task_form.php" class="btn btn-primary btn-sm" id="addTaskBtn">+ Add Task</a>
      </div>
    </div>

    <!-- Flash message -->
    <?php if ($flash): ?>
      <div class="alert alert-success">✅ <?= htmlspecialchars($flash) ?></div>
    <?php endif; ?>

    <!-- STAT CARDS -->
    <div class="dash-stats">
      <div class="dash-stat-card">
        <div class="dash-stat-icon ds-purple">📋</div>
        <div>
          <div class="dash-stat-num count-up" data-target="<?= $counts['total'] ?>"><?= $counts['total'] ?></div>
          <div class="dash-stat-label">Total Tasks</div>
        </div>
      </div>
      <div class="dash-stat-card">
        <div class="dash-stat-icon ds-yellow">⏳</div>
        <div>
          <div class="dash-stat-num"><?= $counts['pending'] ?></div>
          <div class="dash-stat-label">Pending</div>
        </div>
      </div>
      <div class="dash-stat-card">
        <div class="dash-stat-icon ds-purple">🔄</div>
        <div>
          <div class="dash-stat-num"><?= $counts['in_progress'] ?></div>
          <div class="dash-stat-label">In Progress</div>
        </div>
      </div>
      <div class="dash-stat-card">
        <div class="dash-stat-icon ds-green">✅</div>
        <div>
          <div class="dash-stat-num"><?= $counts['completed'] ?></div>
          <div class="dash-stat-label">Completed</div>
        </div>
      </div>
    </div>

    <!-- PROGRESS -->
    <?php if ($counts['total'] > 0):
      $pct = round(($counts['completed'] / $counts['total']) * 100); ?>
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius);padding:22px;margin-bottom:28px;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
        <span style="font-weight:600;">Overall Progress</span>
        <span style="color:var(--primary);font-weight:700;"><?= $pct ?>%</span>
      </div>
      <div class="progress-bar" style="height:10px;">
        <div class="progress-fill" style="width:<?= $pct ?>%;"></div>
      </div>
    </div>
    <?php endif; ?>

    <!-- TASKS TABLE -->
    <div class="tasks-header">
      <h3>All Tasks</h3>
      <div class="task-filters">
        <button class="filter-btn active" data-filter="all" id="filterAll">All (<?= $counts['total'] ?>)</button>
        <button class="filter-btn" data-filter="pending"     id="filterPending">Pending</button>
        <button class="filter-btn" data-filter="in_progress" id="filterInProgress">In Progress</button>
        <button class="filter-btn" data-filter="completed"   id="filterCompleted">Completed</button>
      </div>
    </div>

    <?php if ($counts['total'] === 0): ?>
      <div class="empty-state">
        <div class="empty-icon">📭</div>
        <h4>No tasks yet!</h4>
        <p>Click "Add Task" to create your first task.</p>
        <a href="task_form.php" class="btn btn-primary btn-sm" style="margin-top:16px;">+ Create First Task</a>
      </div>
    <?php else: ?>
    <div class="task-table-wrapper">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Due Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while ($task = mysqli_fetch_assoc($tasksRes)):
            $due = $task['due_date'] ? date('d M Y', strtotime($task['due_date'])) : '—';
            $isOverdue = $task['due_date'] && strtotime($task['due_date']) < time() && $task['status'] !== 'completed';
          ?>
          <tr class="task-row" data-status="<?= $task['status'] ?>">
            <td style="color:var(--text-muted);"><?= $i++ ?></td>
            <td>
              <strong><?= htmlspecialchars($task['title']) ?></strong>
              <?php if ($task['description']): ?>
                <div style="color:var(--text-muted);font-size:0.8rem;margin-top:2px;"><?= htmlspecialchars(substr($task['description'],0,60)) ?>...</div>
              <?php endif; ?>
            </td>
            <td><span class="badge badge-<?= $task['priority'] ?>"><?= ucfirst($task['priority']) ?></span></td>
            <td><span class="badge badge-<?= $task['status'] ?>"><?= str_replace('_',' ',ucfirst($task['status'])) ?></span></td>
            <td style="<?= $isOverdue ? 'color:var(--danger);' : '' ?>">
              <?= $due ?><?= $isOverdue ? ' ⚠️' : '' ?>
            </td>
            <td>
              <div class="task-actions">
                <a href="task_form.php?id=<?= $task['id'] ?>" class="btn btn-outline btn-sm" id="editTask<?= $task['id'] ?>">✏️ Edit</a>
                <button class="btn btn-danger btn-sm delete-task-btn"
                        id="deleteTask<?= $task['id'] ?>"
                        data-url="delete_task.php?id=<?= $task['id'] ?>"
                        data-title="<?= htmlspecialchars($task['title']) ?>">🗑️ Delete</button>
              </div>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </main>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div class="modal-overlay" id="deleteModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
  <div class="modal">
    <div style="font-size:2.5rem;margin-bottom:12px;">🗑️</div>
    <h3 id="modalTitle">Delete Task?</h3>
    <p>Are you sure you want to delete <strong id="deleteTaskName"></strong>? This action cannot be undone.</p>
    <div class="modal-btns">
      <button class="btn btn-outline" id="cancelDelete">Cancel</button>
      <a href="#" class="btn btn-danger" id="confirmDelete">Yes, Delete</a>
    </div>
  </div>
</div>

<style>
@media(max-width:900px){#sidebarToggle{display:inline-flex!important;}}
</style>

<?php include 'includes/footer.php'; ?>
