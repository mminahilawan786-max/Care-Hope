-- Care-Hope database schema
-- Import with: mysql -u <username> -p < database/schema.sql
-- The application should connect using a least-privilege MySQL user.

CREATE DATABASE IF NOT EXISTS care_hope
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE care_hope;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role ENUM('patient', 'admin') NOT NULL DEFAULT 'patient',
    first_name VARCHAR(80) NOT NULL,
    last_name VARCHAR(80) NOT NULL,
    email VARCHAR(190) NOT NULL,
    phone VARCHAR(30) DEFAULT NULL,
    password_hash VARCHAR(255) NOT NULL,
    date_of_birth DATE DEFAULT NULL,
    gender ENUM('female', 'male', 'non_binary', 'prefer_not_to_say') DEFAULT NULL,
    address VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_users_email (email),
    KEY idx_users_role (role)
) ENGINE=InnoDB;

CREATE TABLE specialties (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_specialties_name (name)
) ENGINE=InnoDB;

CREATE TABLE doctors (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    specialty_id INT UNSIGNED NOT NULL,
    first_name VARCHAR(80) NOT NULL,
    last_name VARCHAR(80) NOT NULL,
    email VARCHAR(190) NOT NULL,
    phone VARCHAR(30) DEFAULT NULL,
    qualification VARCHAR(150) NOT NULL,
    experience_years TINYINT UNSIGNED NOT NULL DEFAULT 0,
    bio TEXT DEFAULT NULL,
    photo_path VARCHAR(255) DEFAULT NULL,
    consultation_fee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_doctors_specialty
        FOREIGN KEY (specialty_id) REFERENCES specialties (id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE KEY uq_doctors_email (email),
    KEY idx_doctors_specialty_active (specialty_id, is_active)
) ENGINE=InnoDB;

CREATE TABLE doctor_availability (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT UNSIGNED NOT NULL,
    weekday TINYINT UNSIGNED NOT NULL COMMENT '0 = Sunday, 6 = Saturday',
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    slot_minutes SMALLINT UNSIGNED NOT NULL DEFAULT 30,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_availability_weekday CHECK (weekday BETWEEN 0 AND 6),
    CONSTRAINT chk_availability_time CHECK (end_time > start_time),
    CONSTRAINT chk_availability_slot CHECK (slot_minutes BETWEEN 10 AND 240),
    CONSTRAINT fk_availability_doctor
        FOREIGN KEY (doctor_id) REFERENCES doctors (id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    KEY idx_availability_doctor_day (doctor_id, weekday, is_active)
) ENGINE=InnoDB;

CREATE TABLE appointments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    patient_id INT UNSIGNED NOT NULL,
    doctor_id INT UNSIGNED NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    reason VARCHAR(500) NOT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    admin_notes VARCHAR(500) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_appointments_patient
        FOREIGN KEY (patient_id) REFERENCES users (id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_appointments_doctor
        FOREIGN KEY (doctor_id) REFERENCES doctors (id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    UNIQUE KEY uq_doctor_appointment_slot (doctor_id, appointment_date, appointment_time),
    KEY idx_patient_appointments (patient_id, appointment_date, appointment_time),
    KEY idx_appointment_status_date (status, appointment_date)
) ENGINE=InnoDB;

CREATE TABLE contact_messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(160) NOT NULL,
    email VARCHAR(190) NOT NULL,
    phone VARCHAR(30) DEFAULT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_contact_messages_read_created (is_read, created_at)
) ENGINE=InnoDB;

-- Create administrators through the application or generate a PHP hash first:
-- php -r "echo password_hash('replace-with-a-strong-password', PASSWORD_DEFAULT), PHP_EOL;"
-- Then insert the generated value in password_hash, never a plaintext password.

INSERT INTO specialties (name, description) VALUES
    ('Cardiology', 'Care for heart and cardiovascular health.'),
    ('Dermatology', 'Care for skin, hair, and nail concerns.'),
    ('General Medicine', 'Primary care for everyday health needs.'),
    ('Pediatrics', 'Healthcare for infants, children, and adolescents.')
ON DUPLICATE KEY UPDATE description = VALUES(description);

INSERT INTO doctors (specialty_id, first_name, last_name, email, phone, qualification, experience_years, bio, consultation_fee)
SELECT id, 'Rachel', 'Morgan', 'rachel.morgan@carehope.test', '+1 555 010 1001', 'MD, Family Medicine', 12, 'Compassionate primary care for individuals and families.', 75.00 FROM specialties WHERE name = 'General Medicine'
ON DUPLICATE KEY UPDATE specialty_id = VALUES(specialty_id), qualification = VALUES(qualification), experience_years = VALUES(experience_years), bio = VALUES(bio), consultation_fee = VALUES(consultation_fee);

INSERT INTO doctors (specialty_id, first_name, last_name, email, phone, qualification, experience_years, bio, consultation_fee)
SELECT id, 'James', 'Allen', 'james.allen@carehope.test', '+1 555 010 1002', 'MD, Cardiology', 15, 'Focused on helping patients build healthier hearts and lives.', 110.00 FROM specialties WHERE name = 'Cardiology'
ON DUPLICATE KEY UPDATE specialty_id = VALUES(specialty_id), qualification = VALUES(qualification), experience_years = VALUES(experience_years), bio = VALUES(bio), consultation_fee = VALUES(consultation_fee);

INSERT INTO doctors (specialty_id, first_name, last_name, email, phone, qualification, experience_years, bio, consultation_fee)
SELECT id, 'Sofia', 'Patel', 'sofia.patel@carehope.test', '+1 555 010 1003', 'MD, Dermatology', 10, 'Evidence-based skin care with a personal approach.', 95.00 FROM specialties WHERE name = 'Dermatology'
ON DUPLICATE KEY UPDATE specialty_id = VALUES(specialty_id), qualification = VALUES(qualification), experience_years = VALUES(experience_years), bio = VALUES(bio), consultation_fee = VALUES(consultation_fee);
