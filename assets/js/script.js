/**
 * FitForge - Main JavaScript
 * Handles DOM manipulation, interactive tools, and animations.
 */

document.addEventListener('DOMContentLoaded', () => {
    initNavigation();
    initParticleCanvas();
    
    // Initialize tools if they exist on the page
    if (document.getElementById('bmiForm')) initBMICalculator();
    if (document.getElementById('calorieForm')) initCalorieCalculator();
    if (document.getElementById('quoteBtn')) initQuoteGenerator();
    if (document.getElementById('workout')) initWorkoutPlanner();
});

/* ==========================================================================
   Navigation Toggle
   ========================================================================== */
function initNavigation() {
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');

    if (navToggle && navMenu) {
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            navToggle.classList.toggle('active');
            
            // Animate hamburger to X (simplified)
            const spans = navToggle.querySelectorAll('span');
            if (navMenu.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(7px, -7px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });
    }

    // Scroll effect for navbar
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.style.background = 'rgba(15, 23, 42, 0.95)';
            navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.3)';
        } else {
            navbar.style.background = 'rgba(15, 23, 42, 0.8)';
            navbar.style.boxShadow = 'none';
        }
    });
}

/* ==========================================================================
   BMI Calculator
   ========================================================================== */
function initBMICalculator() {
    const form = document.getElementById('bmiForm');
    const resultDiv = document.getElementById('bmiResult');
    const valueSpan = document.getElementById('bmiValue');
    const categorySpan = document.getElementById('bmiCategory');

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const weight = parseFloat(document.getElementById('weight').value);
        const heightCm = parseFloat(document.getElementById('height').value);
        
        if (isNaN(weight) || isNaN(heightCm) || weight <= 0 || heightCm <= 0) {
            alert('Please enter valid numbers.');
            return;
        }

        const heightM = heightCm / 100;
        const bmi = (weight / (heightM * heightM)).toFixed(1);
        
        valueSpan.textContent = bmi;
        
        let category = '';
        let color = '';

        if (bmi < 18.5) {
            category = 'Underweight';
            color = '#06b6d4';
        } else if (bmi >= 18.5 && bmi <= 24.9) {
            category = 'Normal weight';
            color = '#10b981';
        } else if (bmi >= 25 && bmi <= 29.9) {
            category = 'Overweight';
            color = '#f59e0b';
        } else {
            category = 'Obese';
            color = '#ef4444';
        }

        categorySpan.textContent = category;
        categorySpan.style.color = color;
        
        resultDiv.style.display = 'block';
        
        // Add a small animation
        resultDiv.style.animation = 'none';
        resultDiv.offsetHeight; /* trigger reflow */
        resultDiv.style.animation = 'slideIn 0.5s ease forwards';
    });
}

/* ==========================================================================
   Calorie Calculator
   ========================================================================== */
function initCalorieCalculator() {
    const form = document.getElementById('calorieForm');
    const resultDiv = document.getElementById('calorieResult');
    const valueSpan = document.getElementById('calValue');
    const macrosP = document.getElementById('calMacros');

    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const age = parseInt(document.getElementById('calAge').value);
        const gender = document.getElementById('calGender').value;
        const weight = parseFloat(document.getElementById('calWeight').value);
        const height = parseFloat(document.getElementById('calHeight').value);
        const activity = parseFloat(document.getElementById('calActivity').value);
        const diet = document.getElementById('calDiet').value;
        
        if (isNaN(age) || isNaN(weight) || isNaN(height)) {
            alert('Please enter valid numbers.');
            return;
        }

        // Mifflin-St Jeor Equation
        let bmr = (10 * weight) + (6.25 * height) - (5 * age);
        bmr = gender === 'male' ? bmr + 5 : bmr - 161;
        
        // TDEE (Total Daily Energy Expenditure)
        let tdee = bmr * activity;
        
        // Adjust for diet goal
        let targetCalories = tdee;
        if (diet === 'cut') targetCalories -= 500;
        if (diet === 'bulk') targetCalories += 500;
        
        // Calculate Macros
        // Protein: ~2.2g per kg of body weight
        // Fat: ~0.8g per kg of body weight
        // Carbs: Remaining calories
        const proteinGrams = Math.round(weight * 2.2);
        const fatGrams = Math.round(weight * 0.8);
        const proteinCals = proteinGrams * 4;
        const fatCals = fatGrams * 9;
        
        let carbCals = targetCalories - (proteinCals + fatCals);
        if (carbCals < 0) carbCals = 0; // fallback for extreme cuts
        const carbGrams = Math.round(carbCals / 4);

        valueSpan.textContent = Math.round(targetCalories);
        macrosP.innerHTML = `<strong>Protein:</strong> ${proteinGrams}g &nbsp;|&nbsp; <strong>Fats:</strong> ${fatGrams}g &nbsp;|&nbsp; <strong>Carbs:</strong> ${carbGrams}g`;
        
        resultDiv.style.display = 'block';
        
        // Add a small animation
        resultDiv.style.animation = 'none';
        resultDiv.offsetHeight; /* trigger reflow */
        resultDiv.style.animation = 'slideIn 0.5s ease forwards';
    });

    const autoGenBtn = document.getElementById('autoGenerateWorkoutBtn');
    if (autoGenBtn) {
        autoGenBtn.addEventListener('click', () => {
            const diet = document.getElementById('calDiet').value;
            let plan = {};
            
            if (diet === 'cut') {
                plan = {
                    'Monday': ['Full Body Circuit (4 sets)', '30 min LISS Cardio'],
                    'Tuesday': ['45 min HIIT Cardio', 'Core Workout (15 min)'],
                    'Wednesday': ['Active Recovery (Yoga/Walking)'],
                    'Thursday': ['Upper Body Hypertrophy', '20 min Rowing'],
                    'Friday': ['Lower Body Hypertrophy', '15 min Stairmaster'],
                    'Saturday': ['60 min Outdoor Cardio'],
                    'Sunday': ['Rest & Stretching']
                };
            } else if (diet === 'bulk') {
                plan = {
                    'Monday': ['Heavy Bench Press (5x5)', 'Incline Dumbbell Press (4x8)', 'Tricep Extensions (3x10)'],
                    'Tuesday': ['Barbell Rows (5x5)', 'Pull-ups (4xMax)', 'Bicep Curls (3x10)'],
                    'Wednesday': ['Rest & Recovery'],
                    'Thursday': ['Heavy Squats (5x5)', 'Leg Press (4x8)', 'Calf Raises (4x15)'],
                    'Friday': ['Overhead Press (5x5)', 'Lateral Raises (4x12)', 'Core (3x15)'],
                    'Saturday': ['Full Body Hypertrophy (3x10)'],
                    'Sunday': ['Rest & Meal Prep']
                };
            } else { // maintain
                plan = {
                    'Monday': ['Upper Body Push (4x8)'],
                    'Tuesday': ['Lower Body Quad Focus (4x8)'],
                    'Wednesday': ['30 min Moderate Cardio', 'Core (15 min)'],
                    'Thursday': ['Upper Body Pull (4x8)'],
                    'Friday': ['Lower Body Hamstring Focus (4x8)'],
                    'Saturday': ['Active Recreation (Sports/Hiking)'],
                    'Sunday': ['Rest']
                };
            }
            
            localStorage.setItem('fitforge_workout_plan', JSON.stringify(plan));
            
            if (typeof window.loadWorkoutPlan === 'function') {
                window.loadWorkoutPlan();
                
                const oldText = autoGenBtn.innerHTML;
                autoGenBtn.innerHTML = '<i class="fas fa-check"></i> Plan Applied!';
                autoGenBtn.classList.remove('btn-primary');
                autoGenBtn.classList.add('btn-accent');
                
                document.getElementById('workout').scrollIntoView({ behavior: 'smooth' });
                
                setTimeout(() => {
                    autoGenBtn.innerHTML = oldText;
                    autoGenBtn.classList.remove('btn-accent');
                    autoGenBtn.classList.add('btn-primary');
                }, 3000);
            }
        });
    }
}

/* ==========================================================================
   Motivation Generator
   ========================================================================== */
function initQuoteGenerator() {
    const quotes = [
        "The only bad workout is the one that didn't happen.",
        "What seems impossible today will one day become your warm-up.",
        "Don't stop when you're tired. Stop when you're done.",
        "It never gets easier, you just get stronger.",
        "Success starts with self-discipline.",
        "Your body can stand almost anything. It's your mind that you have to convince.",
        "Wake up with determination. Go to bed with satisfaction.",
        "Push yourself, because no one else is going to do it for you."
    ];

    const btn = document.getElementById('quoteBtn');
    const display = document.getElementById('quoteDisplay');

    btn.addEventListener('click', () => {
        const randomIndex = Math.floor(Math.random() * quotes.length);
        
        // Fade out
        display.style.opacity = 0;
        
        setTimeout(() => {
            display.innerHTML = `<i class="fas fa-quote-left" style="color: var(--primary); margin-right: 10px;"></i> ${quotes[randomIndex]}`;
            // Fade in
            display.style.opacity = 1;
        }, 300);
    });
}

/* ==========================================================================
   Newsletter Subscription (Mock)
   ========================================================================== */
window.subscribeNewsletter = function() {
    const email = document.getElementById('newsletterEmail').value;
    const msg = document.getElementById('newsletterMsg');
    
    if (!email || !email.includes('@')) {
        msg.textContent = 'Please enter a valid email.';
        msg.style.color = '#f43f5e';
    } else {
        msg.textContent = 'Subscribed successfully!';
        msg.style.color = '#10b981';
        document.getElementById('newsletterEmail').value = '';
    }
    
    setTimeout(() => { msg.textContent = ''; }, 3000);
};

/* ==========================================================================
   Workout Planner
   ========================================================================== */
function initWorkoutPlanner() {
    const addBtn = document.getElementById('addExerciseBtn');
    const input = document.getElementById('exerciseInput');
    const daySelect = document.getElementById('daySelect');
    const workoutList = document.getElementById('workoutList');

    if (!addBtn || !workoutList) return;

    const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    const plan = JSON.parse(localStorage.getItem('fitforge_workout_plan')) || {};

    // Initialize days
    days.forEach(day => {
        if (!plan[day]) plan[day] = [];
        
        const dayCol = document.createElement('div');
        dayCol.className = 'day-col';
        dayCol.style.background = 'rgba(0,0,0,0.2)';
        dayCol.style.padding = '15px';
        dayCol.style.borderRadius = 'var(--radius-sm)';
        
        dayCol.innerHTML = `
            <h3 style="color: var(--accent); margin-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 5px; font-size: 1.1rem;">${day}</h3>
            <ul id="list-${day}" style="list-style: none; padding: 0; margin: 0; min-height: 50px;"></ul>
        `;
        workoutList.appendChild(dayCol);
    });

    window.loadWorkoutPlan = function() {
        const currentPlan = JSON.parse(localStorage.getItem('fitforge_workout_plan')) || {};
        days.forEach(day => {
            const ul = document.getElementById(`list-${day}`);
            if (ul) ul.innerHTML = ''; // clear existing
            
            if (currentPlan[day]) {
                currentPlan[day].forEach(exercise => renderExercise(day, exercise, currentPlan));
            }
        });
    };

    // Initial load
    window.loadWorkoutPlan();

    addBtn.addEventListener('click', () => {
        const exercise = input.value.trim();
        const day = daySelect.value;
        
        if (exercise === '') {
            alert('Please enter an exercise.');
            return;
        }

        const currentPlan = JSON.parse(localStorage.getItem('fitforge_workout_plan')) || {};
        if (!currentPlan[day]) currentPlan[day] = [];
        currentPlan[day].push(exercise);
        
        localStorage.setItem('fitforge_workout_plan', JSON.stringify(currentPlan));
        renderExercise(day, exercise, currentPlan);
        input.value = '';
    });
    
    // Allow pressing Enter to add exercise
    input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            addBtn.click();
        }
    });

    function renderExercise(day, exercise, currentPlanRef) {
        const ul = document.getElementById(`list-${day}`);
        const li = document.createElement('li');
        li.style.background = 'rgba(255,255,255,0.05)';
        li.style.padding = '8px 10px';
        li.style.marginBottom = '8px';
        li.style.borderRadius = '4px';
        li.style.display = 'flex';
        li.style.justifyContent = 'space-between';
        li.style.alignItems = 'center';
        li.style.fontSize = '0.9rem';
        
        li.innerHTML = `
            <span style="word-break: break-word; flex: 1; padding-right: 10px;">${exercise}</span>
            <button class="delete-btn" title="Remove" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 5px;"><i class="fas fa-times"></i></button>
        `;

        li.querySelector('.delete-btn').addEventListener('click', () => {
            li.style.transform = 'scale(0.9)';
            li.style.opacity = '0';
            setTimeout(() => {
                li.remove();
                // Fetch fresh plan from storage to update correctly
                const freshPlan = JSON.parse(localStorage.getItem('fitforge_workout_plan')) || {};
                if (freshPlan[day]) {
                    freshPlan[day] = freshPlan[day].filter(e => e !== exercise);
                    localStorage.setItem('fitforge_workout_plan', JSON.stringify(freshPlan));
                }
            }, 200);
        });

        ul.appendChild(li);
    }
}

/* ==========================================================================
   Particle Background Effect (Simple Canvas)
   ========================================================================== */
function initParticleCanvas() {
    const canvas = document.getElementById('particle-canvas');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const particlesArray = [];
    const numberOfParticles = 50;

    class Particle {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 2 + 0.5;
            this.speedX = Math.random() * 0.5 - 0.25;
            this.speedY = Math.random() * 0.5 - 0.25;
        }
        update() {
            this.x += this.speedX;
            this.y += this.speedY;
            if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
            if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
        }
        draw() {
            ctx.fillStyle = 'rgba(16, 185, 129, 0.5)';
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();
        }
    }

    for (let i = 0; i < numberOfParticles; i++) {
        particlesArray.push(new Particle());
    }

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        for (let i = 0; i < particlesArray.length; i++) {
            particlesArray[i].update();
            particlesArray[i].draw();
        }
        requestAnimationFrame(animate);
    }
    animate();

    window.addEventListener('resize', () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    });
}
