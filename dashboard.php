<?php
/**
 * FitForge | User Dashboard
 * Protected route, requires authentication.
 */
require_once 'includes/db_connect.php';
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash_message'] = "Please log in to access your dashboard.";
    $_SESSION['flash_type'] = "error";
    header("Location: auth.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Create workout_logs table automatically if it doesn't exist
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS workout_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        workout_type VARCHAR(100) NOT NULL,
        duration_minutes INT NOT NULL,
        calories_burned INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");
} catch (\PDOException $e) {
    // Ignore if constraint exists or table creation fails due to permissions, etc.
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'log_workout') {
    $type = trim($_POST['workout_type']);
    $duration = (int)$_POST['duration'];
    $calories = (int)$_POST['calories'];
    
    if (!empty($type) && $duration > 0) {
        $stmt = $pdo->prepare("INSERT INTO workout_logs (user_id, workout_type, duration_minutes, calories_burned) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$user_id, $type, $duration, $calories])) {
            $_SESSION['flash_message'] = "Workout logged successfully!";
            $_SESSION['flash_type'] = "success";
        } else {
            $_SESSION['flash_message'] = "Failed to log workout.";
            $_SESSION['flash_type'] = "error";
        }
    } else {
        $_SESSION['flash_message'] = "Please enter valid workout details.";
        $_SESSION['flash_type'] = "error";
    }
    header("Location: dashboard.php");
    exit();
}

// Handle Workout Deletion
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM workout_logs WHERE id = ? AND user_id = ?");
    if ($stmt->execute([$delete_id, $user_id])) {
        $_SESSION['flash_message'] = "Workout removed.";
        $_SESSION['flash_type'] = "success";
    }
    header("Location: dashboard.php");
    exit();
}

// Fetch user data
$stmt = $pdo->prepare("SELECT username, email, full_name, fitness_goal, created_at FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Fetch recent workouts
$stmt = $pdo->prepare("SELECT * FROM workout_logs WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
$stmt->execute([$user_id]);
$recent_workouts = $stmt->fetchAll();

// Fetch total stats
$stmt = $pdo->prepare("SELECT COUNT(*) as total_workouts, SUM(duration_minutes) as total_minutes, SUM(calories_burned) as total_calories FROM workout_logs WHERE user_id = ?");
$stmt->execute([$user_id]);
$stats = $stmt->fetch();

$page_title = 'Dashboard';
$skip_session_start = true;
include 'includes/header.php';
?>

<div class="container" style="padding-top: calc(var(--nav-height) + var(--spacing-xl)); min-height: 80vh;">
    <div class="section-header" style="text-align: left; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h1 class="section-title" style="margin-bottom: 5px;">Welcome back, <span class="text-gradient"><?php echo htmlspecialchars($user['username']); ?></span>!</h1>
            <p class="section-subtitle" style="margin: 0;">Here is your fitness progress.</p>
        </div>
        <a href="logout.php" class="btn btn-outline" style="border-color: var(--accent); color: var(--accent);">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-3" style="margin-bottom: var(--spacing-lg);">
        <div class="card" style="text-align: center; padding: var(--spacing-md); border-top: 3px solid var(--primary);">
            <i class="fas fa-dumbbell" style="font-size: 2rem; color: var(--primary); margin-bottom: 10px;"></i>
            <h2 style="margin: 0; font-size: 2.5rem;"><?php echo $stats['total_workouts'] ?: 0; ?></h2>
            <p style="color: var(--text-muted);">Total Workouts</p>
        </div>
        <div class="card" style="text-align: center; padding: var(--spacing-md); border-top: 3px solid var(--secondary);">
            <i class="fas fa-clock" style="font-size: 2rem; color: var(--secondary); margin-bottom: 10px;"></i>
            <h2 style="margin: 0; font-size: 2.5rem;"><?php echo $stats['total_minutes'] ?: 0; ?> <span style="font-size: 1rem; color: var(--text-muted);">min</span></h2>
            <p style="color: var(--text-muted);">Time Active</p>
        </div>
        <div class="card" style="text-align: center; padding: var(--spacing-md); border-top: 3px solid var(--accent);">
            <i class="fas fa-fire" style="font-size: 2rem; color: var(--accent); margin-bottom: 10px;"></i>
            <h2 style="margin: 0; font-size: 2.5rem;"><?php echo $stats['total_calories'] ?: 0; ?> <span style="font-size: 1rem; color: var(--text-muted);">kcal</span></h2>
            <p style="color: var(--text-muted);">Calories Burned</p>
        </div>
    </div>

    <div class="grid grid-2">
        <!-- Log Workout Form -->
        <div class="card" style="border-top: 4px solid var(--primary);">
            <h3 style="margin-bottom: 20px;"><i class="fas fa-plus-circle" style="color: var(--primary);"></i> Log a Workout</h3>
            <form method="POST" action="dashboard.php">
                <input type="hidden" name="action" value="log_workout">
                
                <div class="form-group">
                    <label class="form-label" for="workout_type">Workout Type</label>
                    <input type="text" name="workout_type" id="workout_type" class="form-control" placeholder="e.g., Upper Body, Running, Yoga" required>
                </div>
                
                <div style="display: flex; gap: 10px; margin-bottom: var(--spacing-md);">
                    <div style="flex: 1;">
                        <label class="form-label" for="duration">Duration (mins)</label>
                        <input type="number" name="duration" id="duration" class="form-control" placeholder="e.g., 45" required min="1">
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label" for="calories">Calories Burned</label>
                        <input type="number" name="calories" id="calories" class="form-control" placeholder="Optional" min="0">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;"><i class="fas fa-save"></i> Save Workout</button>
            </form>
        </div>

        <!-- Activity Feed -->
        <div class="card" style="border-top: 4px solid var(--secondary);">
            <h3 style="margin-bottom: 20px;"><i class="fas fa-history" style="color: var(--secondary);"></i> Recent Activity</h3>
            
            <?php if (empty($recent_workouts)): ?>
                <div style="background: rgba(255,255,255,0.05); padding: 25px; border-radius: var(--radius-sm); text-align: center; color: var(--text-muted);">
                    <i class="fas fa-running" style="font-size: 3rem; margin-bottom: 15px; color: rgba(255,255,255,0.2);"></i>
                    <p>No recent workouts logged.</p>
                    <p style="font-size: 0.9rem;">Log your first workout to start tracking your progress!</p>
                </div>
            <?php else: ?>
                <ul style="list-style: none; padding: 0; margin: 0; max-height: 400px; overflow-y: auto; padding-right: 10px;">
                    <?php foreach ($recent_workouts as $workout): ?>
                        <li style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: var(--radius-sm); padding: 15px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="margin: 0; color: var(--text-main);"><?php echo htmlspecialchars($workout['workout_type']); ?></h4>
                                <div style="color: var(--text-muted); font-size: 0.85rem; margin-top: 5px; display: flex; gap: 15px;">
                                    <span><i class="fas fa-clock"></i> <?php echo $workout['duration_minutes']; ?> min</span>
                                    <?php if ($workout['calories_burned']): ?>
                                        <span><i class="fas fa-fire" style="color: var(--accent);"></i> <?php echo $workout['calories_burned']; ?> kcal</span>
                                    <?php endif; ?>
                                </div>
                                <div style="font-size: 0.8rem; color: rgba(255,255,255,0.3); margin-top: 5px;">
                                    <?php echo date('M j, g:i a', strtotime($workout['created_at'])); ?>
                                </div>
                            </div>
                            <a href="dashboard.php?delete_id=<?php echo $workout['id']; ?>" onclick="return confirm('Are you sure you want to remove this workout?');" style="color: var(--accent); padding: 5px;" title="Delete">
                                <i class="fas fa-trash"></i>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
