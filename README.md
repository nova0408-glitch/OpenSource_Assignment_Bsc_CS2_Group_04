# 🏫 School Student Information Management System (SIMS)

> **CP 222 – Open Source Technologies | University of Dodoma (UDOM)**
> College of Informatics and Virtual Education (CIVE)

---

## 📌 Project Overview

The **School Student Information Management System (SIMS)** is a PHP-based web application designed to manage student records for **primary and secondary schools in Tanzania**. It allows administrators and teachers to register students, browse all student records, and quickly search for a student by their registration number or other details.

The system includes a full **user management module** with role-based access (Admin and Teacher), session-based authentication, and a clean, responsive interface.

---

## 👨‍💻 Project Details

| Field | Details |
|---|---|
| **Course** | CP 222 – Open Source Technologies |
| **Degree Program** | Bachelor of Science in Computer Science |
| **Institution** | University of Dodoma (UDOM) |
| **College** | College of Informatics and Virtual Education (CIVE) |
| **Academic Year** | 2025/2026 |
| **Assignment** | Lab Assignment – PHP Project with Git/GitHub |
| **Deadline** | 18th June 2026 |

---

## ✨ Features

- 🔐 **User Authentication** – Secure login/logout with session management
- 👥 **User Management** – Admin can add and delete system users (Admin/Teacher roles)
- 📝 **Student Registration** – Register primary and secondary school students with full details
- 📋 **Student Records** – View and filter all registered students by school level
- 🔍 **Search** – Search students by registration number, name, region, or class
- 👁 **Student Profile** – Detailed individual student view with parent contact info
- 📊 **Dashboard** – Summary stats and recent registrations at a glance
- 🗑 **Delete Records** – Admin-only student record deletion

---

## 🛠 Technologies Used

| Technology | Purpose |
|---|---|
| PHP 8.x | Server-side scripting and logic |
| MySQL | Database for storing student and user records |
| HTML5 / CSS3 | Frontend structure and styling |
| Apache (XAMPP/WAMP) | Local web server |
| Git | Version control |
| GitHub | Remote repository hosting |

---

## ⚙️ Installation Steps

### Prerequisites
- XAMPP or WAMP installed (includes PHP + MySQL + Apache)
- Git installed on your machine
- A web browser

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/nova0408-glitch/OpenSource_Assignment_ComputerScience_Group1.git
   ```

2. **Move the project to your server root**
   ```bash
   # For XAMPP (Windows):
   Move the 'student_system' folder to: C:/xampp/htdocs/
   
   # For XAMPP (Linux/Mac):
   Move to: /opt/lampp/htdocs/
   ```

3. **Start Apache and MySQL** from the XAMPP control panel.

4. **Set up the database**
   - Open your browser and go to `http://localhost/phpmyadmin`
   - Click **New** to create a database named `school_db`
   - Click **Import**, then select and upload the file: `db/school_db.sql`
   - Click **Go** to run the SQL

5. **Access the application**
   ```
   http://localhost/student_system/
   ```

6. **Login credentials (default)**
   ```
   Username: admin
   Password: password
   ```

---

## 🗂 Project Structure

```
student_system/
├── index.php           # Dashboard (home page)
├── login.php           # Login page
├── logout.php          # Logout handler
├── register.php        # Student registration form
├── students.php        # View all students
├── search.php          # Search students
├── view_student.php    # Individual student profile
├── users.php           # User management (admin only)
├── css/
│   └── style.css       # Main stylesheet
├── includes/
│   ├── auth_guard.php  # Session authentication guard
│   ├── db_connect.php  # Database connection
│   └── navbar.php      # Shared navigation bar
└── db/
    └── school_db.sql   # Database setup script
```

---

## 🔧 Git Commands Used

```bash
# Initialize repository
git init

# Stage all files
git add .

# Commits
git commit -m "Initial project setup and folder structure"
git commit -m "Added database schema and connection configuration"
git commit -m "Implemented user authentication (login/logout/session)"
git commit -m "Added student registration form with validation"
git commit -m "Implemented student records display and search feature"
git commit -m "Added user management module (admin role)"
git commit -m "Styled UI with responsive CSS and improved dashboard"

# Create development branch
git checkout -b development

# Work on new feature, then merge back
git checkout main
git merge development

# Push to GitHub
git remote add origin https://github.com/nova0408-glitch/OpenSource_Assignment_Bsc-CS2_Group_04.git
git push -u origin main
```

---

## 🔗 GitHub Repository

**[https://github.com/nova0408-glitch/OpenSource_Assignment_Bsc-CS2_Group_04](https://github.com/nova0408-glitch/OpenSource_Assignment_Bsc_CS2_Group_04)**

---

## 📄 License

This project was developed for academic purposes at the University of Dodoma.

---

*Built with ❤️ using PHP, MySQL, and open source technologies.*
