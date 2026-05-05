# FitForge - Capstone Web Project

FitForge is a fully functional, responsive, multi-page fitness web application designed as a capstone project to demonstrate the seamless integration of frontend and backend web technologies.

## 🚀 Features & Technologies

### Frontend (UI/UX)
- **HTML5 & Vanilla CSS3**: Built with a premium, dark-themed aesthetic featuring CSS variables, flexbox, grid, neon gradients, and glassmorphism.
- **JavaScript (Vanilla)**:
  - Dynamic BMI Calculator (calculates and updates DOM without reload).
  - Motivation Quote Generator with fade transitions.
  - Interactive navigation toggle and scroll-based styling.
  - Canvas-based particle background animation.
- **Responsive Design**: Mobile-first approach ensuring perfect rendering across all devices.

### Backend (Server-Side)
- **PHP 8+**: Handles core logic including dynamic component inclusion, form processing, and routing.
- **Authentication**: Secure user registration and login system with `password_hash()` and `password_verify()`.
- **Session Management**: Persistent login states across the application and protected dashboard access.
- **Flash Messages**: Dynamic, session-based notifications for success/error alerts.

### Database
- **MySQL**: Relational database (`fitness`) managing users and contact messages.
- **PDO**: Secure database interaction using Prepared Statements to prevent SQL injection.

## 📁 Project Structure

```text
Fitforge/
├── assets/
│   ├── css/style.css       # Core styles and design system
│   └── js/script.js        # DOM manipulation and interactive tools
├── includes/
│   ├── header.php          # Reusable navbar and session logic
│   ├── footer.php          # Reusable footer
│   └── db_connect.php      # PDO database configuration
├── index.php               # Landing page
├── about.php               # Project information
├── tools.php               # BMI and Quote generators
├── contact.php             # Contact form handling
├── auth.php                # Unified Login/Registration interface
├── dashboard.php           # Secure user portal
├── logout.php              # Session termination logic
└── database.sql            # Database schema definitions
```

## ⚙️ Setup & Installation

1. **Environment Setup**: Install a local development server like XAMPP or WAMP.
2. **Clone/Copy Project**: Place the `Fitforge` folder into your server's root directory (e.g., `C:\xampp\htdocs\Fitforge`).
3. **Database Setup**:
   - Open phpMyAdmin (usually `http://localhost/phpmyadmin`).
   - You can either run the `database.sql` file via the Import tab, OR copy its contents into the SQL tab and execute.
   - This will create the `fitness` database and the required tables.
4. **Configuration**: If your MySQL setup uses a password for the `root` user, update `includes/db_connect.php` accordingly.
5. **Launch**: Open your browser and navigate to `http://localhost/Fitforge`.

## 🎓 Academic Alignment (Bloom's Taxonomy)
- **Create**: Designed a complete, original application from scratch.
- **Evaluate**: Assessed and ensured responsiveness and security.
- **Analyze**: Structured clean separation of concerns (includes, assets, core pages).
- **Apply**: Connected PHP to MySQL and styled with CSS.
- **Understand**: Implemented sessions to persist state.
- **Remember**: Utilized standard tags, queries, and syntax correctly.
