-- ============================================================
-- Question Two: Amazon College Student System
-- Database Setup Script
-- Database: amazon_db at IP 10.10.10.1
-- ============================================================

CREATE DATABASE IF NOT EXISTS amazon_db;
USE amazon_db;

-- Student table with the required fields
CREATE TABLE IF NOT EXISTS student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    program VARCHAR(100) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    registration_number VARCHAR(50) NOT NULL UNIQUE
);

-- Sample student data
INSERT INTO student (first_name, last_name, program, gender, registration_number) VALUES
('James', 'Omondi', 'Computer Science', 'Male', 'AMZ/BCS/001/2026'),
('Mary', 'Wanjiku', 'Information Technology', 'Female', 'AMZ/BIT/002/2026'),
('Peter', 'Kamau', 'Business Administration', 'Male', 'AMZ/BBA/003/2026'),
('Grace', 'Achieng', 'Computer Science', 'Female', 'AMZ/BCS/004/2026'),
('David', 'Mwangi', 'Networking', 'Male', 'AMZ/BNT/005/2026'),
('Sarah', 'Njeri', 'Information Technology', 'Female', 'AMZ/BIT/006/2026');
