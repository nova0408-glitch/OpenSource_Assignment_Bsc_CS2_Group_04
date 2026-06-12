-- ===========================================
-- School Student Information Management System
-- Database Setup Script
-- University of Dodoma - CP 222 Assignment
-- ===========================================

CREATE DATABASE IF NOT EXISTS school_db;
USE school_db;

-- Users table (for login/authentication)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'teacher') DEFAULT 'teacher',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Students table
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reg_number VARCHAR(20) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    date_of_birth DATE NOT NULL,
    school_level ENUM('Primary', 'Secondary') NOT NULL,
    class_grade VARCHAR(10) NOT NULL,
    region VARCHAR(50) NOT NULL,
    parent_name VARCHAR(100) NOT NULL,
    parent_phone VARCHAR(15) NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default admin user (password: admin123)
INSERT INTO users (username, password, full_name, role)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator', 'admin')
ON DUPLICATE KEY UPDATE username = username;

-- Sample student data
INSERT INTO students (reg_number, first_name, last_name, gender, date_of_birth, school_level, class_grade, region, parent_name, parent_phone) VALUES
('PS-2024-001', 'Amina', 'Juma', 'Female', '2015-03-12', 'Primary', 'Standard 4', 'Dodoma', 'Fatuma Juma', '0712345678'),
('PS-2024-002', 'Baraka', 'Mwangi', 'Male', '2014-07-22', 'Primary', 'Standard 5', 'Arusha', 'Joseph Mwangi', '0754321098'),
('SS-2024-001', 'Zawadi', 'Hassan', 'Female', '2008-11-05', 'Secondary', 'Form 3', 'Dar es Salaam', 'Hassan Salim', '0765432109'),
('SS-2024-002', 'Omari', 'Kipchoge', 'Male', '2007-01-18', 'Secondary', 'Form 4', 'Mwanza', 'Kipchoge Ali', '0723456789'),
('PS-2024-003', 'Neema', 'Augustino', 'Female', '2016-05-30', 'Primary', 'Standard 3', 'Morogoro', 'Grace Augustino', '0734567890')
ON DUPLICATE KEY UPDATE reg_number = reg_number;
