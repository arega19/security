CREATE DATABASE IF NOT EXISTS study_planner;
USE study_planner;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL
);
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(255) NOT NULL,
    priority ENUM('high', 'medium', 'low'),
    difficulty ENUM('easy', 'medium', 'hard'),
    due_date DATE,
    completed TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE study_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    topic_aes VARBINARY(1024),
    -- Encrypted Topic
    category VARCHAR(50),
    priority VARCHAR(20),
    deadline DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(50),
    topic VARCHAR(50),
    file_path VARCHAR(500),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE resource_time (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    resource_id INT,
    time_spent INT,
    -- in minutes
    date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (resource_id) REFERENCES resources(id) ON DELETE CASCADE
);
CREATE TABLE pomodoro_stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_time INT DEFAULT 0,
    -- in minutes
    sessions_completed INT DEFAULT 0,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE focus_ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    rating INT,
    -- 1-5
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    session_length INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE user_preferences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,
    session_length INT DEFAULT 25,
    study_time_preference VARCHAR(20) DEFAULT 'afternoon',
    break_length INT DEFAULT 5,
    sync_frequency INT DEFAULT 15,
    offline_mode TINYINT(1) DEFAULT 1,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE analytics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,
    daily_time JSON,
    subject_time JSON,
    completion_rates JSON,
    productivity JSON,
    focus_ratings_data JSON,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(255),
    date DATE,
    start_time TIME,
    end_time TIME,
    type VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE undo_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action_type VARCHAR(50),
    data JSON,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE sync_state (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,
    last_sync TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sync_data JSON,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
-- Insert a test user (password: "student123")
INSERT INTO users (username, password_hash)
VALUES (
        'Student',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    );