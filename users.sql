-- users.sql
CREATE DATABASE IF NOT EXISTS test_database 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE test_database;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_email ON users(email);

-- Новые данные пользователей
INSERT INTO users (name, email) VALUES
('Екатерина Соколова', 'ekaterina@example.com'),
('Сергей Смирнов', 'sergey@example.com'),
('Анна Петрова', 'anna.petrova@example.com');