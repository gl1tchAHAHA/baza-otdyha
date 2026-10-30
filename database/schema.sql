CREATE DATABASE IF NOT EXISTS lesnaya_gavan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lesnaya_gavan;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(30) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS accommodations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    type VARCHAR(40) NOT NULL,
    description TEXT NOT NULL,
    capacity TINYINT UNSIGNED NOT NULL,
    price_per_night DECIMAL(10,2) NOT NULL,
    amenities VARCHAR(500) NOT NULL DEFAULT '',
    image VARCHAR(255) NOT NULL DEFAULT 'cabin.svg',
    status VARCHAR(20) NOT NULL DEFAULT 'active',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_accommodation_status (status),
    INDEX idx_accommodation_capacity (capacity)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS bookings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    accommodation_id INT UNSIGNED NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    guests TINYINT UNSIGNED NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_booking_dates (accommodation_id, check_in, check_out, status),
    INDEX idx_booking_user (user_id),
    CONSTRAINT fk_booking_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT,
    CONSTRAINT fk_booking_accommodation FOREIGN KEY (accommodation_id) REFERENCES accommodations(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Учебная учётная запись администратора: admin@lesnaya-gavan.ru / password
-- Перед размещением проекта в интернете замените пароль и удалите тестовые данные.
INSERT INTO users (full_name, email, phone, password_hash, role)
SELECT 'Администратор базы отдыха', 'admin@lesnaya-gavan.ru', '+7 (900) 000-00-00', '$2y$12$h2H5LPPeG4lOQWIUrBCyIeI2sJk1MQAjtM2q30cSW0bH.NbUZNYry', 'admin'
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email='admin@lesnaya-gavan.ru');

INSERT INTO accommodations (title,type,description,capacity,price_per_night,amenities,status) VALUES
('Домик у сосен','Домик','Небольшой деревянный домик для спокойного отдыха в окружении сосен. Подходит для пары или небольшой семьи.',2,4200,'Терраса, Wi-Fi, отопление','active'),
('Семейный коттедж','Коттедж','Просторный коттедж с отдельной зоной отдыха. Удобный вариант для семейной поездки или компании друзей.',6,8500,'Кухня, гостиная, терраса, парковка','active'),
('Номер «Тихий берег»','Номер','Уютный номер с базовыми удобствами для короткого отдыха на природе.',2,3200,'Санузел, Wi-Fi, чайная зона','active'),
('Дом A-frame','Домик','Современный треугольный дом с панорамным окном и видом на лес.',4,6900,'Кухня, панорамное окно, терраса','active'),
('Лесной глэмпинг','Глэмпинг','Комфортная палатка с настоящей кроватью и местом для отдыха на открытом воздухе.',3,5100,'Кровать, электричество, зона костра','active');
