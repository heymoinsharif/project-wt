# TaskFlow 🚀
### A Smart Personal Task Management Web Application

> **Course:** WEB TECHNOLOGIES (23CSE404) | **Instructor:** Mir Junaid Rasool | **Total Marks:** 50

---

## 📌 Project Overview

**TaskFlow** is a fully functional, multi-page web application built as the Capstone Web Project for Web Technologies (23CSE404). It allows users to register, log in, and manage personal tasks with priorities, statuses, and due dates — all backed by a PHP + MySQL stack.

---

## ✨ Features

| Feature | Technology |
|---|---|
| User Registration & Login | PHP, MySQL, Sessions |
| Remember Me | PHP Cookies |
| Task CRUD (Create, Read, Update, Delete) | PHP + MySQL |
| Client-side Form Validation | JavaScript (DHTML) |
| Dynamic Task Filtering | JavaScript DOM Manipulation |
| Profile Picture Upload | PHP File Uploads |
| Password Strength Indicator | JavaScript |
| Delete Confirmation Modal | JavaScript |
| Responsive Layout | CSS (Box Model, Flexbox, Media Queries) |
| Progress Dashboard | PHP + MySQL aggregation |

---

## 🗂️ Pages (7 Total)

| Page | File | Description |
|---|---|---|
| Home | `index.php` | Landing page with hero, stats, and features |
| About | `about.php` | Tech stack, Bloom's taxonomy, course info |
| Register | `register.php` | Account creation with JS validation |
| Login | `login.php` | Auth with sessions and "Remember Me" cookie |
| Dashboard | `dashboard.php` | Task overview with filters and stats |
| Task Form | `task_form.php` | Add/Edit tasks (Create + Update) |
| Profile | `profile.php` | Edit profile + file upload |

---

## 🛠️ Technologies Used

- **HTML5** — Semantic markup and structure
- **CSS3** — Box Model, Flexbox, Positioning, Floats, Media Queries
- **JavaScript (ES6+)** — Form validation, DOM manipulation, modals, filters
- **PHP 8** — Server-side logic, sessions, cookies, file uploads
- **MySQL** — Database with CRUD operations
- **Google Fonts** — Inter typeface for premium typography

---

## ⚙️ Setup & Installation

### Prerequisites
- [XAMPP](https://www.apachefriends.org/) or WAMP installed
- PHP 7.4+ and MySQL 5.7+

### Steps

1. **Clone / Copy** the project folder into your XAMPP `htdocs` directory:
   ```
   C:\xampp\htdocs\project\
   ```

2. **Import the Database** — Open [phpMyAdmin](http://localhost/phpmyadmin), then:
   - Click **"Import"**
   - Select the `database.sql` file from this project
   - Click **"Go"**

3. **Configure DB credentials** (if needed) in `config/db.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');        // your MySQL password
   define('DB_NAME', 'taskflow_db');
   ```

4. **Create uploads folder** (should exist already, but verify):
   ```
   project/uploads/
   ```

5. **Start XAMPP** — Start both **Apache** and **MySQL** servers.

6. **Open in browser:**
   ```
   http://localhost/project/index.php
   ```

---

## 👤 Demo Account

| Field | Value |
|---|---|
| Email | `demo@taskflow.com` |
| Password | `password` |

*(This account is created by `database.sql` on import.)*

---

## 📁 Project Structure

```
project/
├── config/
│   └── db.php              # Database connection
├── css/
│   └── style.css           # Main stylesheet
├── js/
│   └── script.js           # JavaScript / DHTML
├── includes/
│   ├── header.php          # Shared nav header
│   └── footer.php          # Shared footer
├── uploads/                # Profile pictures stored here
├── index.php               # Home page
├── about.php               # About page
├── register.php            # Registration
├── login.php               # Login
├── dashboard.php           # Task dashboard
├── task_form.php           # Add / Edit task
├── profile.php             # User profile
├── delete_task.php         # Delete task handler
├── logout.php              # Logout handler
├── database.sql            # DB schema + demo data
└── README.md               # This file
```

---

## 📊 Evaluation Rubric Coverage

| Criteria | Marks | Implementation |
|---|---|---|
| Design & UI (HTML + CSS) | 10 | Premium dark theme, responsive, Box Model + Flexbox |
| JavaScript / DHTML | 10 | Form validation, modals, filters, animations |
| PHP Server-side Features | 10 | Sessions, cookies, file uploads, PHP functions |
| Database Integration | 10 | Full CRUD: Create, Read, Update, Delete on tasks |
| GitHub + Deployment | 5 | README, meaningful commits, deployment-ready |
| Viva / Demonstration | 5 | Clean, well-commented code throughout |
| **TOTAL** | **50** | |

---

## 📜 License

This project is developed for academic purposes under Web Technologies (23CSE404).
