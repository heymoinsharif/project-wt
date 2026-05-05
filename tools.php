<?php
/**
 * FitForge | Fitness Tools Page
 */
require_once 'includes/db_connect.php';
$page_title = 'Tools';
include 'includes/header.php';
?>

<div class="container" style="padding-top: calc(var(--nav-height) + var(--spacing-xl)); min-height: 80vh;">
    <div class="section-header">
        <h1 class="section-title">Fitness <span class="text-gradient">Tools</span></h1>
        <p class="section-subtitle">Interactive calculators and generators powered by JavaScript.</p>
    </div>

    <div class="grid grid-2">
        <!-- BMI Calculator Tool -->
        <div class="card" id="bmi">
            <h2 style="color: var(--secondary);"><i class="fas fa-weight"></i> BMI Calculator</h2>
            <p style="color: var(--text-muted); margin-bottom: 20px;">Calculate your Body Mass Index dynamically.</p>
            
            <form id="bmiForm">
                <div class="form-group">
                    <label class="form-label" for="weight">Weight (kg)</label>
                    <input type="number" step="0.1" id="weight" class="form-control" placeholder="e.g., 70" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="height">Height (cm)</label>
                    <input type="number" step="0.1" id="height" class="form-control" placeholder="e.g., 175" required>
                </div>
                <button type="submit" class="btn btn-outline" style="width: 100%; margin-top: 10px;">Calculate BMI</button>
            </form>

            <div id="bmiResult" style="display: none; margin-top: 20px; padding: 15px; background: rgba(0,0,0,0.2); border-radius: var(--radius-sm); text-align: center;">
                <h3 style="margin-bottom: 5px;">Your BMI: <span id="bmiValue" style="color: var(--primary);"></span></h3>
                <p>Category: <strong id="bmiCategory"></strong></p>
            </div>
        </div>

        <!-- Calorie Calculator Tool -->
        <div class="card" id="calorie">
            <h2 style="color: var(--secondary);"><i class="fas fa-apple-alt"></i> Calorie Calculator</h2>
            <p style="color: var(--text-muted); margin-bottom: 20px;">Calculate daily maintenance calories & diet plan.</p>
            
            <form id="calorieForm">
                <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                    <div style="flex: 1;">
                        <label class="form-label" for="calAge">Age</label>
                        <input type="number" id="calAge" class="form-control" placeholder="Years" required>
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label" for="calGender">Gender</label>
                        <select id="calGender" class="form-control">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                    <div style="flex: 1;">
                        <label class="form-label" for="calWeight">Weight (kg)</label>
                        <input type="number" step="0.1" id="calWeight" class="form-control" placeholder="kg" required>
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label" for="calHeight">Height (cm)</label>
                        <input type="number" step="0.1" id="calHeight" class="form-control" placeholder="cm" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="calActivity">Activity Level</label>
                    <select id="calActivity" class="form-control">
                        <option value="1.2">Sedentary (Little/No Exercise)</option>
                        <option value="1.375">Lightly Active (1-3 days/wk)</option>
                        <option value="1.55">Moderately Active (3-5 days/wk)</option>
                        <option value="1.725">Very Active (6-7 days/wk)</option>
                        <option value="1.9">Extra Active (Physical Job/Training)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="calDiet">Diet Goal</label>
                    <select id="calDiet" class="form-control">
                        <option value="maintain">Maintain Weight</option>
                        <option value="cut">Cut (-500 cal)</option>
                        <option value="bulk">Bulk (+500 cal)</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-outline" style="width: 100%; margin-top: 10px;">Calculate Calories</button>
            </form>

            <div id="calorieResult" style="display: none; margin-top: 20px; padding: 15px; background: rgba(0,0,0,0.2); border-radius: var(--radius-sm); text-align: center;">
                <h3 style="margin-bottom: 5px;">Target: <span id="calValue" style="color: var(--primary);"></span> kcal/day</h3>
                <p id="calMacros" style="color: var(--text-muted); font-size: 0.9rem; margin-top: 5px;"></p>
                <button type="button" id="autoGenerateWorkoutBtn" class="btn btn-primary" style="margin-top: 15px; font-size: 0.9rem; padding: 8px 15px;">
                    <i class="fas fa-magic"></i> Auto-fill Workout Plan
                </button>
            </div>
        </div>
        <div class="card" id="quotes" style="display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;">
            <h2 style="color: var(--accent);"><i class="fas fa-fire"></i> Need Motivation?</h2>
            <p style="color: var(--text-muted); margin-bottom: 30px;">Hit the button below for instant fitness inspiration.</p>
            
            <div id="quoteDisplay" style="min-height: 100px; font-size: 1.2rem; font-style: italic; margin-bottom: 30px; transition: opacity 0.3s ease;">
                <i class="fas fa-quote-left" style="color: var(--primary); margin-right: 10px;"></i> Click the button to generate a quote.
            </div>
            
            <button id="quoteBtn" class="btn btn-primary" style="width: 100%;">
                <i class="fas fa-bolt"></i> Generate Quote
            </button>
        </div>
    </div>

    <!-- Workout Planner -->
    <div class="card" id="workout" style="margin-top: 30px;">
        <h2 style="color: var(--primary);"><i class="fas fa-calendar-alt"></i> Workout Planner</h2>
        <p style="color: var(--text-muted); margin-bottom: 20px;">Plan your weekly workout routine. Add exercises to your list.</p>
        
        <div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
            <input type="text" id="exerciseInput" class="form-control" placeholder="e.g., 3 sets of 10 Pushups" style="flex: 1; min-width: 200px;">
            <select id="daySelect" class="form-control" style="width: auto;">
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>
            <button id="addExerciseBtn" class="btn btn-primary"><i class="fas fa-plus"></i> Add Exercise</button>
        </div>

        <div id="workoutList" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
            <!-- Days will be generated by JS -->
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
