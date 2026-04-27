// ============================================================
// TaskFlow - Main JavaScript | WEB TECHNOLOGIES 23CSE404
// ============================================================

// ── Hamburger / Mobile Nav ──
const hamburger = document.getElementById('hamburger');
const navLinks  = document.getElementById('navLinks');
if (hamburger) {
  hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('open');
    hamburger.setAttribute('aria-expanded', navLinks.classList.contains('open'));
  });
}

// ── Sidebar Toggle (Dashboard) ──
const sidebarToggle = document.getElementById('sidebarToggle');
const sidebar       = document.getElementById('sidebar');
if (sidebarToggle && sidebar) {
  sidebarToggle.addEventListener('click', () => sidebar.classList.toggle('open'));
  document.addEventListener('click', e => {
    if (sidebar.classList.contains('open') && !sidebar.contains(e.target) && e.target !== sidebarToggle)
      sidebar.classList.remove('open');
  });
}

// ── Form Validation (Register) ──
const registerForm = document.getElementById('registerForm');
if (registerForm) {
  registerForm.addEventListener('submit', function(e) {
    let valid = true;
    const fields = ['username','email','password','confirm_password'];
    fields.forEach(id => clearError(id));

    const username = document.getElementById('username');
    const email    = document.getElementById('email');
    const password = document.getElementById('password');
    const confirm  = document.getElementById('confirm_password');

    if (!username || username.value.trim().length < 3) {
      showError('username', 'Username must be at least 3 characters.'); valid = false;
    }
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
      showError('email', 'Please enter a valid email address.'); valid = false;
    }
    if (!password || password.value.length < 6) {
      showError('password', 'Password must be at least 6 characters.'); valid = false;
    }
    if (!confirm || confirm.value !== password.value) {
      showError('confirm_password', 'Passwords do not match.'); valid = false;
    }
    if (!valid) e.preventDefault();
  });
}

// ── Form Validation (Login) ──
const loginForm = document.getElementById('loginForm');
if (loginForm) {
  loginForm.addEventListener('submit', function(e) {
    let valid = true;
    clearError('login_email'); clearError('login_password');
    const email    = document.getElementById('login_email');
    const password = document.getElementById('login_password');
    if (!email || email.value.trim() === '') {
      showError('login_email', 'Email is required.'); valid = false;
    }
    if (!password || password.value.trim() === '') {
      showError('login_password', 'Password is required.'); valid = false;
    }
    if (!valid) e.preventDefault();
  });
}

// ── Form Validation (Task Form) ──
const taskForm = document.getElementById('taskForm');
if (taskForm) {
  taskForm.addEventListener('submit', function(e) {
    let valid = true;
    clearError('title');
    const title = document.getElementById('title');
    if (!title || title.value.trim().length < 3) {
      showError('title', 'Task title must be at least 3 characters.'); valid = false;
    }
    if (!valid) e.preventDefault();
  });
}

// ── Helper: Show/Clear Validation Errors ──
function showError(fieldId, message) {
  const field = document.getElementById(fieldId);
  if (!field) return;
  const group = field.closest('.form-group');
  if (group) {
    group.classList.add('field-error');
    const errEl = group.querySelector('.error-msg');
    if (errEl) errEl.textContent = message;
  }
}
function clearError(fieldId) {
  const field = document.getElementById(fieldId);
  if (!field) return;
  const group = field.closest('.form-group');
  if (group) group.classList.remove('field-error');
}

// ── Delete Confirmation Modal ──
const deleteModal   = document.getElementById('deleteModal');
const confirmDelete = document.getElementById('confirmDelete');
const cancelDelete  = document.getElementById('cancelDelete');
let   deleteUrl     = '';

document.querySelectorAll('.delete-task-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    deleteUrl = btn.dataset.url;
    const title = btn.dataset.title || 'this task';
    const msg = document.getElementById('deleteTaskName');
    if (msg) msg.textContent = `"${title}"`;
    if (deleteModal) deleteModal.classList.add('open');
  });
});

if (confirmDelete) {
  confirmDelete.addEventListener('click', () => {
    if (deleteUrl) window.location.href = deleteUrl;
  });
}
if (cancelDelete) {
  cancelDelete.addEventListener('click', () => deleteModal.classList.remove('open'));
}
if (deleteModal) {
  deleteModal.addEventListener('click', e => {
    if (e.target === deleteModal) deleteModal.classList.remove('open');
  });
}

// ── Task Filter Buttons ──
document.querySelectorAll('.filter-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const filter = btn.dataset.filter;
    document.querySelectorAll('tbody .task-row').forEach(row => {
      if (filter === 'all' || row.dataset.status === filter)
        row.style.display = '';
      else
        row.style.display = 'none';
    });
  });
});

// ── Profile Picture Preview ──
const picInput   = document.getElementById('profile_pic');
const picPreview = document.getElementById('avatarPreview');
if (picInput && picPreview) {
  picInput.addEventListener('change', () => {
    const file = picInput.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => { picPreview.src = e.target.result; };
      reader.readAsDataURL(file);
    }
  });
}

// ── Password Strength Indicator ──
const passInput = document.getElementById('password');
const passStrength = document.getElementById('passStrength');
const passBar = document.getElementById('passBar');
if (passInput && passStrength && passBar) {
  passInput.addEventListener('input', () => {
    const val = passInput.value;
    let strength = 0;
    if (val.length >= 6) strength++;
    if (/[A-Z]/.test(val)) strength++;
    if (/[0-9]/.test(val)) strength++;
    if (/[^A-Za-z0-9]/.test(val)) strength++;
    const levels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
    const colors = ['', '#ef476f', '#ffd166', '#06d6a0', '#06d6a0'];
    const widths = ['0%', '25%', '50%', '75%', '100%'];
    passStrength.textContent = levels[strength] || '';
    passBar.style.width = widths[strength];
    passBar.style.background = colors[strength];
  });
}

// ── Auto-dismiss Alerts ──
document.querySelectorAll('.alert').forEach(alert => {
  setTimeout(() => {
    alert.style.transition = 'opacity 0.5s';
    alert.style.opacity = '0';
    setTimeout(() => alert.remove(), 500);
  }, 4000);
});

// ── Animate Numbers (Stats) ──
function animateCount(el) {
  const target = parseInt(el.dataset.target, 10);
  let current = 0;
  const step = Math.max(1, Math.floor(target / 40));
  const timer = setInterval(() => {
    current = Math.min(current + step, target);
    el.textContent = current;
    if (current >= target) clearInterval(timer);
  }, 30);
}
document.querySelectorAll('.count-up').forEach(el => animateCount(el));

// ── Smooth scroll for anchor links ──
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const target = document.querySelector(a.getAttribute('href'));
    if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
  });
});
