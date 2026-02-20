-- ============================================================
-- Question One: Hospital Patient Appointment Management System
-- Database Setup Script
-- ============================================================

CREATE DATABASE IF NOT EXISTS hospital_db;
USE hospital_db;

-- Patients table
CREATE TABLE IF NOT EXISTS patients (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone_number VARCHAR(20) NOT NULL
);

-- Appointments table
CREATE TABLE IF NOT EXISTS appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    doctor_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- Sample data for demonstration
INSERT INTO patients (name, phone_number) VALUES
('John Doe', '0781234567'),
('Jane Smith', '0729876543'),
('Alice Mwangi', '0711223344');

INSERT INTO appointments (patient_id, appointment_date, doctor_name) VALUES
(1, '2026-03-01', 'Dr. Ochieng'),
(2, '2026-03-02', 'Dr. Kamau'),
(3, '2026-03-03', 'Dr. Wanjiku');
