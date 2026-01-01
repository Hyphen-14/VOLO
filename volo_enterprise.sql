-- ==========================================
-- 1. STRUKTUR TABEL (CREATE TABLE)
-- ==========================================

-- 1. TABEL USERS
CREATE TABLE `users` (
  `user_id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(100) DEFAULT NULL,
  `role` ENUM('passenger','admin') DEFAULT 'passenger',
  `phone_number` VARCHAR(20) DEFAULT NULL,
  `profile_picture_url` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. TABEL AIRLINES
CREATE TABLE `airlines` (
  `airline_id` VARCHAR(5) PRIMARY KEY,
  `airline_name` VARCHAR(100) NOT NULL,
  `image_url` VARCHAR(255) DEFAULT NULL,
  `contact_number` VARCHAR(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. TABEL AIRPORTS
CREATE TABLE `airports` (
  `airport_id` VARCHAR(5) PRIMARY KEY,
  `airport_name` VARCHAR(150) NOT NULL,
  `city` VARCHAR(100) NOT NULL,
  `country` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. TABEL AIRCRAFT
CREATE TABLE `aircraft` (
  `aircraft_id` VARCHAR(10) PRIMARY KEY,
  `airline_id` VARCHAR(5),
  `model` VARCHAR(50) NOT NULL,
  `total_seats` INT NOT NULL,
  FOREIGN KEY (`airline_id`) REFERENCES `airlines`(`airline_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. TABEL SEAT_CLASSES
CREATE TABLE `seat_classes` (
  `class_id` INT AUTO_INCREMENT PRIMARY KEY,
  `class_name` ENUM('Economy', 'Business', 'First') NOT NULL,
  `baggage_allowance` INT DEFAULT 20
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. TABEL AIRCRAFT_SEATS
CREATE TABLE `aircraft_seats` (
  `seat_id` INT AUTO_INCREMENT PRIMARY KEY,
  `aircraft_id` VARCHAR(10),
  `seat_number` VARCHAR(5) NOT NULL,
  `class_id` INT,
  FOREIGN KEY (`aircraft_id`) REFERENCES `aircraft`(`aircraft_id`) ON DELETE CASCADE,
  FOREIGN KEY (`class_id`) REFERENCES `seat_classes`(`class_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. TABEL FLIGHTS
CREATE TABLE `flights` (
  `flight_id` INT AUTO_INCREMENT PRIMARY KEY,
  `flight_number` VARCHAR(10) NOT NULL,
  `aircraft_id` VARCHAR(10),
  `departure_airport_id` VARCHAR(5),
  `arrival_airport_id` VARCHAR(5),
  `departure_time` DATETIME NOT NULL,
  `arrival_time` DATETIME NOT NULL,
  `status` ENUM('Scheduled','Delayed','Cancelled','Landed') DEFAULT 'Scheduled',
  FOREIGN KEY (`aircraft_id`) REFERENCES `aircraft`(`aircraft_id`) ON DELETE SET NULL,
  FOREIGN KEY (`departure_airport_id`) REFERENCES `airports`(`airport_id`) ON DELETE SET NULL,
  FOREIGN KEY (`arrival_airport_id`) REFERENCES `airports`(`airport_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. TABEL FLIGHT_PRICES
CREATE TABLE `flight_prices` (
  `price_id` INT AUTO_INCREMENT PRIMARY KEY,
  `flight_id` INT,
  `class_id` INT,
  `price` DECIMAL(12,2) NOT NULL,
  FOREIGN KEY (`flight_id`) REFERENCES `flights`(`flight_id`) ON DELETE CASCADE,
  FOREIGN KEY (`class_id`) REFERENCES `seat_classes`(`class_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 9. TABEL PROMOTIONS
CREATE TABLE `promotions` (
  `promo_id` INT AUTO_INCREMENT PRIMARY KEY,
  `code` VARCHAR(20) NOT NULL UNIQUE,
  `discount_amount` DECIMAL(10,2) NOT NULL,
  `description` VARCHAR(255),
  `image_color` VARCHAR(20) DEFAULT 'blue',
  `valid_until` DATE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 10. TABEL BOOKINGS
CREATE TABLE `bookings` (
  `booking_id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT,
  `booking_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('pending','waiting_payment','paid','cancelled') DEFAULT 'pending',
  `total_amount` DECIMAL(12,2) NOT NULL,
  `total_passengers` INT DEFAULT 1,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 11. TABEL BOOKING_DETAILS
CREATE TABLE `booking_details` (
  `detail_id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT,
  `flight_id` INT,
  `class_id` INT,
  `price_at_booking` DECIMAL(12,2),
  FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`booking_id`) ON DELETE CASCADE,
  FOREIGN KEY (`flight_id`) REFERENCES `flights`(`flight_id`) ON DELETE SET NULL,
  FOREIGN KEY (`class_id`) REFERENCES `seat_classes`(`class_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 12. TABEL PASSENGERS
CREATE TABLE `passengers` (
  `passenger_id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_detail_id` INT,
  `full_name` VARCHAR(100) NOT NULL,
  `nik_passport` VARCHAR(50),
  FOREIGN KEY (`booking_detail_id`) REFERENCES `booking_details`(`detail_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 13. TABEL PAYMENTS
CREATE TABLE `payments` (
  `payment_id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT,
  `payment_method` VARCHAR(50),
  `amount` DECIMAL(12,2),
  `payment_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('verified','failed','refunded') DEFAULT 'verified',
  FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`booking_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 14. TABEL TICKETS (DIPERBAIKI: Tambah FK ke booking_details)
CREATE TABLE `tickets` (
  `ticket_id` VARCHAR(20) PRIMARY KEY,
  `booking_detail_id` INT,
  `seat_id` INT,
  `check_in_status` TINYINT(1) DEFAULT 0,
  `qr_code_url` VARCHAR(255),
  FOREIGN KEY (`booking_detail_id`) REFERENCES `booking_details`(`detail_id`) ON DELETE CASCADE,
  FOREIGN KEY (`seat_id`) REFERENCES `aircraft_seats`(`seat_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 15. TABEL REVIEWS
CREATE TABLE `reviews` (
  `review_id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT,
  `flight_id` INT,
  `rating` INT CHECK (rating BETWEEN 1 AND 5),
  `comment` TEXT,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,
  FOREIGN KEY (`flight_id`) REFERENCES `flights`(`flight_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- 2. INSERT DATA (Urutan Benar Sesuai Dependency)
-- ==========================================

-- A. USERS (15 Data: 1 Admin, 14 Penumpang)
INSERT INTO `users` (`username`, `email`, `password_hash`, `full_name`, `role`, `phone_number`, `profile_picture_url`) VALUES
('admin_volo', 'admin@volo.com', '123', 'Super Admin', 'admin', '081234567890', NULL),
('budi_santoso', 'budi@gmail.com', '123', 'Budi Santoso', 'passenger', '081234567891', NULL),
('siti_aminah', 'siti@gmail.com', '123', 'Siti Aminah', 'passenger', '081234567892', NULL),
('agus_purnomo', 'agus@gmail.com', '123', 'Agus Purnomo', 'passenger', '081234567893', NULL),
('dewi_sartika', 'dewi@gmail.com', '123', 'Dewi Sartika', 'passenger', '081234567894', NULL),
('eko_patrio', 'eko@gmail.com', '123', 'Eko Patrio', 'passenger', '081234567895', NULL),
('fajar_sadboy', 'fajar@gmail.com', '123', 'Fajar Sadboy', 'passenger', '081234567896', NULL),
('gita_gutawa', 'gita@gmail.com', '123', 'Gita Gutawa', 'passenger', '081234567897', NULL),
('hadi_tjahjanto', 'hadi@gmail.com', '123', 'Hadi Tjahjanto', 'passenger', '081234567898', NULL),
('indah_permatasari', 'indah@gmail.com', '123', 'Indah Permatasari', 'passenger', '081234567899', NULL),
('joko_anwar', 'joko@gmail.com', '123', 'Joko Anwar', 'passenger', '081234567800', NULL),
('kartini_putri', 'kartini@gmail.com', '123', 'Kartini Putri', 'passenger', '081234567801', NULL),
('luna_maya', 'luna@gmail.com', '123', 'Luna Maya', 'passenger', '081234567802', NULL),
('maudy_ayunda', 'maudy@gmail.com', '123', 'Maudy Ayunda', 'passenger', '081234567803', NULL),
('nagan_lor', 'nagan@gmail.com', '123', 'Nagan Lor', 'passenger', '081234567804', NULL);

-- B. AIRLINES (15 Maskapai) - dengan placeholder inisial (Rounded & Bold)
INSERT INTO `airlines` (`airline_id`, `airline_name`, `image_url`, `contact_number`) VALUES
('GA', 'Garuda Indonesia', 'https://ui-avatars.com/api/?name=Garuda+Indonesia&size=200&background=0066cc&color=fff&bold=true&rounded=true', '021-234567'),
('JT', 'Lion Air', 'https://ui-avatars.com/api/?name=Lion+Air&size=200&background=e31e25&color=fff&bold=true&rounded=true', '021-555555'),
('QG', 'Citilink', 'https://ui-avatars.com/api/?name=Citilink&size=200&background=00a651&color=fff&bold=true&rounded=true', '0804-1-080808'),
('ID', 'Batik Air', 'https://ui-avatars.com/api/?name=Batik+Air&size=200&background=8B4513&color=fff&bold=true&rounded=true', '021-63798000'),
('QZ', 'AirAsia Indonesia', 'https://ui-avatars.com/api/?name=AirAsia&size=200&background=ff0000&color=fff&bold=true&rounded=true', '021-29270999'),
('SQ', 'Singapore Airlines', 'https://ui-avatars.com/api/?name=Singapore+Airlines&size=200&background=003087&color=fff&bold=true&rounded=true', '+65 6223 8888'),
('MH', 'Malaysia Airlines', 'https://ui-avatars.com/api/?name=Malaysia+Airlines&size=200&background=CE1126&color=fff&bold=true&rounded=true', '+603 7843 3000'),
('EK', 'Emirates', 'https://ui-avatars.com/api/?name=Emirates&size=200&background=d71921&color=fff&bold=true&rounded=true', '+971 600 555555'),
('QR', 'Qatar Airways', 'https://ui-avatars.com/api/?name=Qatar+Airways&size=200&background=8D1B3D&color=fff&bold=true&rounded=true', '+974 4023 0000'),
('NH', 'ANA All Nippon', 'https://ui-avatars.com/api/?name=ANA&size=200&background=16539C&color=fff&bold=true&rounded=true', '+81 3 6735 1000'),
('JL', 'Japan Airlines', 'https://ui-avatars.com/api/?name=JAL&size=200&background=DC143C&color=fff&bold=true&rounded=true', '+81 3 5460 3109'),
('CX', 'Cathay Pacific', 'https://ui-avatars.com/api/?name=Cathay+Pacific&size=200&background=00664F&color=fff&bold=true&rounded=true', '+852 2747 3333'),
('TG', 'Thai Airways', 'https://ui-avatars.com/api/?name=Thai+Airways&size=200&background=7B1FA2&color=fff&bold=true&rounded=true', '+66 2 356 1111'),
('TR', 'Scoot', 'https://ui-avatars.com/api/?name=Scoot&size=200&background=FFD700&color=000&bold=true&rounded=true', '+65 3157 6434'),
('SJ', 'Sriwijaya Air', 'https://ui-avatars.com/api/?name=Sriwijaya+Air&size=200&background=006747&color=fff&bold=true&rounded=true', '021-29270999');

-- C. AIRPORTS (16 Bandara - DITAMBAH HLP)
INSERT INTO `airports` (`airport_id`, `airport_name`, `city`, `country`) VALUES
('CGK', 'Soekarno-Hatta Intl Airport', 'Jakarta', 'Indonesia'),
('HLP', 'Halim Perdanakusuma Airport', 'Jakarta', 'Indonesia'),
('DPS', 'Ngurah Rai Intl Airport', 'Bali', 'Indonesia'),
('SUB', 'Juanda Intl Airport', 'Surabaya', 'Indonesia'),
('KNO', 'Kualanamu Intl Airport', 'Medan', 'Indonesia'),
('UPG', 'Sultan Hasanuddin Intl Airport', 'Makassar', 'Indonesia'),
('YIA', 'Yogyakarta Intl Airport', 'Yogyakarta', 'Indonesia'),
('BPN', 'Sepinggan Intl Airport', 'Balikpapan', 'Indonesia'),
('MLG', 'Abdul Rachman Saleh Airport', 'Malang', 'Indonesia'),
('SIN', 'Changi Airport', 'Singapore', 'Singapore'),
('KUL', 'Kuala Lumpur Intl Airport', 'Kuala Lumpur', 'Malaysia'),
('NRT', 'Narita Intl Airport', 'Tokyo', 'Japan'),
('HND', 'Haneda Airport', 'Tokyo', 'Japan'),
('DXB', 'Dubai Intl Airport', 'Dubai', 'UAE'),
('LHR', 'Heathrow Airport', 'London', 'UK'),
('JFK', 'John F. Kennedy Intl Airport', 'New York', 'USA'),
-- Insert Airport yang belum ada (disesuaikan dengan struktur tabel)
-- Qatar (Doha)
('DOH', 'Hamad International Airport', 'Doha', 'Qatar'),

-- Hong Kong
('HKG', 'Hong Kong International Airport', 'Hong Kong', 'Hong Kong'),

-- Thailand (Bangkok)
('BKK', 'Suvarnabhumi Airport', 'Bangkok', 'Thailand'),

-- Indonesia - Padang
('PDG', 'Minangkabau International Airport', 'Padang', 'Indonesia'),

-- Indonesia - Palembang
('PLM', 'Sultan Mahmud Badaruddin II Airport', 'Palembang', 'Indonesia'),

-- Indonesia - Bandung
('BDO', 'Husein Sastranegara International Airport', 'Bandung', 'Indonesia');

-- D. SEAT CLASSES
INSERT INTO `seat_classes` (`class_name`, `baggage_allowance`) VALUES
('Economy', 20),
('Business', 30),
('First', 40);

-- E. PROMOTIONS (15 Promo Code)
INSERT INTO `promotions` (`code`, `discount_amount`, `description`, `image_color`, `valid_until`) VALUES
('VOLOHEMAT', 20000, 'Diskon 20rb All Route', 'blue', '2025-12-31'),
('LIBURAN', 50000, 'Liburan Akhir Tahun', 'yellow', '2025-12-31'),
('FIRSTFLY', 100000, 'Pengguna Baru', 'red', '2025-12-31'),
('WEEKEND', 30000, 'Diskon Sabtu Minggu', 'blue', '2025-12-31'),
('GAJIAN', 45000, 'Promo Tanggal Muda', 'yellow', '2025-12-31'),
('BALI', 75000, 'Khusus Penerbangan ke Bali', 'blue', '2025-12-31'),
('JAKARTA', 25000, 'Khusus Penerbangan ke Jakarta', 'blue', '2025-12-31'),
('SURABAYA', 25000, 'Khusus Penerbangan ke Surabaya', 'blue', '2025-12-31'),
('MALANG', 20000, 'Khusus Penerbangan ke Malang', 'blue', '2025-12-31'),
('SINGAPORE', 150000, 'International Flight Promo', 'red', '2025-12-31'),
('JAPAN', 300000, 'Winter in Japan Promo', 'red', '2025-12-31'),
('FLASH', 50000, 'Flash Sale 1 Jam', 'yellow', '2025-12-31'),
('STUDENT', 40000, 'Promo Pelajar/Mahasiswa', 'blue', '2025-12-31'),
('BUSINESS', 200000, 'Potongan Kelas Bisnis', 'red', '2025-12-31'),
('RAMADHAN', 60000, 'Promo Mudik Lebaran', 'yellow', '2025-12-31');

-- F. AIRCRAFT (15 Pesawat)
INSERT INTO `aircraft` (`aircraft_id`, `airline_id`, `model`, `total_seats`) VALUES
('PK-GIA', 'GA', 'Boeing 777-300ER', 300),
('PK-GIB', 'GA', 'Airbus A330-900', 250),
('PK-LNI', 'JT', 'Boeing 737-800', 180),
('PK-LNJ', 'JT', 'Boeing 737-900ER', 200),
('PK-GLQ', 'QG', 'Airbus A320-200', 180),
('PK-LID', 'ID', 'Airbus A320-200', 160),
('PK-AXD', 'QZ', 'Airbus A320', 180),
('9V-SKA', 'SQ', 'Airbus A380', 450),
('9V-SKB', 'SQ', 'Boeing 787 Dreamliner', 300),
('9M-MNA', 'MH', 'Boeing 737-800', 160),
('A6-EEA', 'EK', 'Airbus A380', 500),
('A7-BAA', 'QR', 'Boeing 777', 300),
('JA-801A', 'NH', 'Boeing 787', 250),
('JA-701J', 'JL', 'Boeing 777', 280),
('B-HAA', 'CX', 'Airbus A350', 300),
-- Qatar Airways
('A7-BAB', 'QR', 'Boeing 777-300ER', 350),
('A7-BAC', 'QR', 'Airbus A350-900', 280),
-- ANA All Nippon
('JA-802A', 'NH', 'Boeing 787-9', 240),
('JA-803A', 'NH', 'Airbus A320', 166),
-- Cathay Pacific
('B-HAB', 'CX', 'Airbus A350-900', 280),
('B-HAC', 'CX', 'Boeing 777-300', 340),
-- Thai Airways
('HS-TKA', 'TG', 'Boeing 777-300', 364),
('HS-TKB', 'TG', 'Airbus A350', 321),
-- Scoot
('9V-OFA', 'TR', 'Boeing 787-8', 335),
('9V-OFB', 'TR', 'Airbus A320', 180),
-- Sriwijaya Air
('PK-CLC', 'SJ', 'Boeing 737-800', 168),
('PK-CLD', 'SJ', 'Boeing 737-900ER', 189),
-- Tambahan untuk maskapai yang sudah ada (untuk variasi jadwal)
('PK-GIC', 'GA', 'Boeing 737-800', 160),
('PK-LNK', 'JT', 'Airbus A320', 180),
('PK-GLR', 'QG', 'Airbus A320-200', 180),
('PK-LIE', 'ID', 'Boeing 737-800', 180),
('PK-AXE', 'QZ', 'Airbus A320-200', 180),
('9V-SKC', 'SQ', 'Boeing 777-300ER', 264),
('9M-MNB', 'MH', 'Airbus A350-900', 286),
('A6-EEB', 'EK', 'Boeing 777-300ER', 354),
('JA-702J', 'JL', 'Boeing 787-9', 246);

-- G. AIRCRAFT_SEATS (15 Kursi di PK-GIA)
INSERT INTO `aircraft_seats` (`aircraft_id`, `seat_number`, `class_id`) VALUES
('PK-GIA', '1A', 2), ('PK-GIA', '1B', 2), ('PK-GIA', '2A', 2),
('PK-GIA', '2B', 2), ('PK-GIA', '3A', 2), ('PK-GIA', '5A', 1),
('PK-GIA', '5B', 1), ('PK-GIA', '5C', 1), ('PK-GIA', '6A', 1),
('PK-GIA', '6B', 1), ('PK-GIA', '6C', 1), ('PK-GIA', '7A', 1),
('PK-GIA', '7B', 1), ('PK-GIA', '7C', 1), ('PK-GIA', '8A', 1);

-- H. FLIGHTS (15 Jadwal Penerbangan)
INSERT INTO `flights` (`flight_number`, `aircraft_id`, `departure_airport_id`, `arrival_airport_id`, `departure_time`, `arrival_time`, `status`) VALUES
('GA-404', 'PK-GIA', 'CGK', 'DPS', '2025-12-25 08:00:00', '2025-12-25 10:50:00', 'Scheduled'),
('GA-408', 'PK-GIB', 'CGK', 'DPS', '2025-12-25 14:00:00', '2025-12-25 16:50:00', 'Scheduled'),
('JT-22', 'PK-LNI', 'CGK', 'DPS', '2025-12-25 09:30:00', '2025-12-25 12:20:00', 'Scheduled'),
('QG-77', 'PK-GLQ', 'HLP', 'DPS', '2025-12-25 13:00:00', '2025-12-25 15:50:00', 'Scheduled'),
('ID-6500', 'PK-LID', 'CGK', 'SUB', '2025-12-26 07:00:00', '2025-12-26 08:30:00', 'Scheduled'),
('QZ-202', 'PK-AXD', 'CGK', 'SIN', '2025-12-26 10:00:00', '2025-12-26 12:45:00', 'Scheduled'),
('SQ-950', '9V-SKA', 'SIN', 'CGK', '2025-12-27 15:00:00', '2025-12-27 15:50:00', 'Scheduled'),
('GA-303', 'PK-GIA', 'SUB', 'CGK', '2025-12-27 06:00:00', '2025-12-27 07:30:00', 'Scheduled'),
('MH-711', '9M-MNA', 'KUL', 'CGK', '2025-12-28 09:00:00', '2025-12-28 10:10:00', 'Scheduled'),
('EK-356', 'A6-EEA', 'DXB', 'CGK', '2025-12-29 04:00:00', '2025-12-29 15:30:00', 'Scheduled'),
('GA-601', 'PK-GIB', 'UPG', 'CGK', '2025-12-30 11:00:00', '2025-12-30 12:20:00', 'Scheduled'),
('JT-555', 'PK-LNI', 'YIA', 'DPS', '2025-12-30 08:00:00', '2025-12-30 10:30:00', 'Scheduled'),
('GA-290', 'PK-GIA', 'MLG', 'CGK', '2025-12-31 08:00:00', '2025-12-31 09:30:00', 'Scheduled'),
('ID-777', 'PK-LID', 'MLG', 'HLP', '2025-12-31 10:00:00', '2025-12-31 11:30:00', 'Scheduled'),
('JL-729', 'JA-701J', 'NRT', 'CGK', '2026-01-01 17:00:00', '2026-01-01 23:00:00', 'Scheduled'),
('QR-955', 'A7-BAB', 'DOH', 'CGK', '2025-12-25 23:00:00', '2025-12-26 13:30:00', 'Scheduled'),
('QR-956', 'A7-BAC', 'CGK', 'DOH', '2025-12-26 02:00:00', '2025-12-26 08:45:00', 'Scheduled'),
('QR-957', 'A7-BAB', 'DOH', 'SUB', '2025-12-27 22:30:00', '2025-12-28 13:00:00', 'Scheduled'),

-- ANA All Nippon (NH) - 3 flights
('NH-836', 'JA-802A', 'NRT', 'CGK', '2025-12-25 19:00:00', '2025-12-26 01:30:00', 'Scheduled'),
('NH-837', 'JA-803A', 'CGK', 'NRT', '2025-12-26 08:00:00', '2025-12-26 17:00:00', 'Scheduled'),
('NH-838', 'JA-802A', 'HND', 'DPS', '2025-12-27 10:00:00', '2025-12-27 16:30:00', 'Scheduled'),

-- Cathay Pacific (CX) - 3 flights
('CX-776', 'B-HAB', 'HKG', 'CGK', '2025-12-25 15:00:00', '2025-12-25 19:00:00', 'Scheduled'),
('CX-777', 'B-HAC', 'CGK', 'HKG', '2025-12-26 10:30:00', '2025-12-26 14:30:00', 'Scheduled'),
('CX-778', 'B-HAB', 'HKG', 'SUB', '2025-12-27 14:00:00', '2025-12-27 18:00:00', 'Scheduled'),

-- Thai Airways (TG) - 3 flights
('TG-434', 'HS-TKA', 'BKK', 'CGK', '2025-12-25 12:00:00', '2025-12-25 15:30:00', 'Scheduled'),
('TG-435', 'HS-TKB', 'CGK', 'BKK', '2025-12-26 16:30:00', '2025-12-26 18:00:00', 'Scheduled'),
('TG-436', 'HS-TKA', 'BKK', 'DPS', '2025-12-27 09:00:00', '2025-12-27 13:00:00', 'Scheduled'),

-- Scoot (TR) - 3 flights
('TR-285', '9V-OFA', 'SIN', 'DPS', '2025-12-25 07:00:00', '2025-12-25 10:00:00', 'Scheduled'),
('TR-286', '9V-OFB', 'DPS', 'SIN', '2025-12-26 11:00:00', '2025-12-26 12:00:00', 'Scheduled'),
('TR-287', '9V-OFA', 'SIN', 'CGK', '2025-12-27 16:00:00', '2025-12-27 17:00:00', 'Scheduled'),

-- Sriwijaya Air (SJ) - 3 flights
('SJ-230', 'PK-CLC', 'CGK', 'PDG', '2025-12-25 06:00:00', '2025-12-25 08:00:00', 'Scheduled'),
('SJ-231', 'PK-CLD', 'PDG', 'CGK', '2025-12-26 09:00:00', '2025-12-26 11:00:00', 'Scheduled'),
('SJ-232', 'PK-CLC', 'CGK', 'PLM', '2025-12-27 07:30:00', '2025-12-27 09:00:00', 'Scheduled'),

-- Tambahan untuk maskapai yang sudah ada (12 flights)
-- Garuda Indonesia (GA) - 2 tambahan
('GA-410', 'PK-GIC', 'CGK', 'SIN', '2025-12-25 11:00:00', '2025-12-25 13:45:00', 'Scheduled'),
('GA-620', 'PK-GIA', 'BDO', 'CGK', '2025-12-26 13:00:00', '2025-12-26 15:30:00', 'Scheduled'),

-- Lion Air (JT) - 2 tambahan
('JT-33', 'PK-LNK', 'CGK', 'UPG', '2025-12-25 05:30:00', '2025-12-25 08:30:00', 'Scheduled'),
('JT-44', 'PK-LNJ', 'SUB', 'DPS', '2025-12-26 12:00:00', '2025-12-26 13:30:00', 'Scheduled'),

-- Citilink (QG) - 2 tambahan
('QG-88', 'PK-GLR', 'CGK', 'SUB', '2025-12-25 15:00:00', '2025-12-25 16:30:00', 'Scheduled'),
('QG-99', 'PK-GLQ', 'DPS', 'CGK', '2025-12-26 17:00:00', '2025-12-26 19:50:00', 'Scheduled'),

-- Batik Air (ID) - 2 tambahan
('ID-6501', 'PK-LIE', 'SUB', 'DPS', '2025-12-25 10:00:00', '2025-12-25 11:30:00', 'Scheduled'),
('ID-6502', 'PK-LID', 'CGK', 'YIA', '2025-12-26 14:00:00', '2025-12-26 15:30:00', 'Scheduled'),

-- AirAsia (QZ) - 2 tambahan
('QZ-203', 'PK-AXE', 'SIN', 'CGK', '2025-12-25 13:30:00', '2025-12-25 14:30:00', 'Scheduled'),
('QZ-204', 'PK-AXD', 'CGK', 'KUL', '2025-12-26 08:00:00', '2025-12-26 11:00:00', 'Scheduled'),

-- Singapore Airlines (SQ) - 1 tambahan
('SQ-951', '9V-SKC', 'CGK', 'SIN', '2025-12-25 18:00:00', '2025-12-25 20:45:00', 'Scheduled'),

-- Malaysia Airlines (MH) - 1 tambahan
('MH-712', '9M-MNB', 'CGK', 'KUL', '2025-12-25 12:00:00', '2025-12-25 15:00:00', 'Scheduled'),

-- Emirates (EK) - 1 tambahan
('EK-357', 'A6-EEB', 'CGK', 'DXB', '2025-12-25 20:00:00', '2025-12-26 03:30:00', 'Scheduled'),

-- Japan Airlines (JL) - 1 tambahan
('JL-730', 'JA-702J', 'CGK', 'NRT', '2025-12-26 00:30:00', '2025-12-26 09:30:00', 'Scheduled');


-- I. FLIGHT_PRICES (15 Harga)
INSERT INTO `flight_prices` (`flight_id`, `class_id`, `price`) VALUES
(1, 1, 1500000), (1, 2, 3500000),
(2, 1, 1450000),
(3, 1, 850000),
(4, 1, 1100000),
(5, 1, 900000), (5, 2, 2100000),
(6, 1, 750000),
(7, 1, 1800000), (7, 2, 5000000),
(8, 1, 1300000),
(10, 1, 9000000),
(13, 1, 1200000),
(14, 1, 1150000),
(15, 3, 25000000),
(16, 1, 8500000), (16, 2, 18000000), (16, 3, 35000000),  -- QR-955 DOH-CGK
(17, 1, 8500000), (17, 2, 18000000), (17, 3, 35000000),  -- QR-956 CGK-DOH
(18, 1, 9000000), (18, 2, 19000000), (18, 3, 37000000),  -- QR-957 DOH-SUB

-- ANA All Nippon (flight_id 19-21)
(19, 1, 7500000), (19, 2, 16000000), (19, 3, 32000000),  -- NH-836 NRT-CGK
(20, 1, 7500000), (20, 2, 16000000), (20, 3, 32000000),  -- NH-837 CGK-NRT
(21, 1, 8000000), (21, 2, 17000000), (21, 3, 33000000),  -- NH-838 HND-DPS

-- Cathay Pacific (flight_id 22-24)
(22, 1, 4500000), (22, 2, 10000000), (22, 3, 22000000),  -- CX-776 HKG-CGK
(23, 1, 4500000), (23, 2, 10000000), (23, 3, 22000000),  -- CX-777 CGK-HKG
(24, 1, 4800000), (24, 2, 10500000), (24, 3, 23000000),  -- CX-778 HKG-SUB

-- Thai Airways (flight_id 25-27)
(25, 1, 3500000), (25, 2, 8000000), (25, 3, 18000000),   -- TG-434 BKK-CGK
(26, 1, 3500000), (26, 2, 8000000), (26, 3, 18000000),   -- TG-435 CGK-BKK
(27, 1, 3800000), (27, 2, 8500000), (27, 3, 19000000),   -- TG-436 BKK-DPS

-- Scoot (flight_id 28-30)
(28, 1, 1200000), (28, 2, 3500000),                       -- TR-285 SIN-DPS
(29, 1, 1200000), (29, 2, 3500000),                       -- TR-286 DPS-SIN
(30, 1, 900000), (30, 2, 2800000),                        -- TR-287 SIN-CGK

-- Sriwijaya Air (flight_id 31-33)
(31, 1, 800000),                                          -- SJ-230 CGK-PDG
(32, 1, 800000),                                          -- SJ-231 PDG-CGK
(33, 1, 850000),                                          -- SJ-232 CGK-PLM

-- Garuda Indonesia tambahan (flight_id 34-35)
(34, 1, 1600000), (34, 2, 4000000),                       -- GA-410 CGK-SIN
(35, 1, 1100000), (35, 2, 2800000),                       -- GA-620 BDO-CGK

-- Lion Air tambahan (flight_id 36-37)
(36, 1, 1400000),                                         -- JT-33 CGK-UPG
(37, 1, 950000),                                          -- JT-44 SUB-DPS

-- Citilink tambahan (flight_id 38-39)
(38, 1, 850000),                                          -- QG-88 CGK-SUB
(39, 1, 1000000),                                         -- QG-99 DPS-CGK

-- Batik Air tambahan (flight_id 40-41)
(40, 1, 900000),                                          -- ID-6501 SUB-DPS
(41, 1, 800000),                                          -- ID-6502 CGK-YIA

-- AirAsia tambahan (flight_id 42-43)
(42, 1, 850000),                                          -- QZ-203 SIN-CGK
(43, 1, 950000),                                          -- QZ-204 CGK-KUL

-- Singapore Airlines tambahan (flight_id 44)
(44, 1, 1800000), (44, 2, 5000000), (44, 3, 12000000),   -- SQ-951 CGK-SIN

-- Malaysia Airlines tambahan (flight_id 45)
(45, 1, 1900000), (45, 2, 5200000), (45, 3, 12500000),   -- MH-712 CGK-KUL

-- Emirates tambahan (flight_id 46)
(46, 1, 9500000), (46, 2, 20000000), (46, 3, 40000000),  -- EK-357 CGK-DXB

-- Japan Airlines tambahan (flight_id 47)
(47, 1, 7800000), (47, 2, 16500000), (47, 3, 33000000);  -- JL-730 CGK-NRT


-- J. BOOKINGS (15 Transaksi)
INSERT INTO `bookings` (`user_id`, `booking_date`, `status`, `total_amount`) VALUES
(2, '2025-11-01 10:00:00', 'paid', 1500000),
(3, '2025-11-02 11:00:00', 'waiting_payment', 850000),
(4, '2025-11-03 12:00:00', 'cancelled', 1100000),
(5, '2025-11-04 13:00:00', 'paid', 2100000),
(6, '2025-11-05 14:00:00', 'paid', 750000),
(7, '2025-11-06 15:00:00', 'paid', 5000000),
(8, '2025-11-07 16:00:00', 'pending', 1300000),
(9, '2025-11-08 17:00:00', 'paid', 9000000),
(2, '2025-11-09 09:00:00', 'paid', 1200000),
(3, '2025-11-10 10:00:00', 'waiting_payment', 1150000),
(4, '2025-11-11 11:00:00', 'paid', 1500000),
(5, '2025-11-12 12:00:00', 'paid', 3500000),
(6, '2025-11-13 13:00:00', 'cancelled', 1450000),
(7, '2025-11-14 14:00:00', 'paid', 850000),
(8, '2025-11-15 15:00:00', 'paid', 1800000);

-- K. BOOKING_DETAILS
INSERT INTO `booking_details` (`booking_id`, `flight_id`, `class_id`, `price_at_booking`) VALUES
(1, 1, 1, 1500000),
(2, 3, 1, 850000),
(3, 4, 1, 1100000),
(4, 5, 2, 2100000),
(5, 6, 1, 750000),
(6, 7, 2, 5000000),
(7, 8, 1, 1300000),
(8, 10, 1, 9000000),
(9, 13, 1, 1200000),
(10, 14, 1, 1150000),
(11, 1, 1, 1500000),
(12, 1, 2, 3500000),
(13, 2, 1, 1450000),
(14, 3, 1, 850000),
(15, 7, 1, 1800000);

-- L. PASSENGERS
INSERT INTO `passengers` (`booking_detail_id`, `full_name`, `nik_passport`) VALUES
(1, 'Budi Santoso', '3507123456789001'),
(2, 'Siti Aminah', '3507123456789002'),
(3, 'Agus Purnomo', '3507123456789003'),
(4, 'Dewi Sartika', '3507123456789004'),
(5, 'Eko Patrio', '3507123456789005'),
(6, 'Fajar Sadboy', '3507123456789006'),
(7, 'Gita Gutawa', '3507123456789007'),
(8, 'Hadi Tjahjanto', 'A12345678'),
(9, 'Budi Santoso', '3507123456789001'),
(10, 'Siti Aminah', '3507123456789002'),
(11, 'Dewi Sartika', '3507123456789004'),
(12, 'Eko Patrio', '3507123456789005'),
(13, 'Fajar Sadboy', '3507123456789006'),
(14, 'Gita Gutawa', '3507123456789007'),
(15, 'Hadi Tjahjanto', '3507123456789008');

-- M. PAYMENTS (Hanya untuk booking status PAID)
INSERT INTO `payments` (`booking_id`, `payment_method`, `amount`, `status`) VALUES
(1, 'BCA Transfer', 1500000, 'verified'),
(4, 'GoPay', 2100000, 'verified'),
(5, 'Mandiri VA', 750000, 'verified'),
(6, 'Credit Card', 5000000, 'verified'),
(8, 'Credit Card', 9000000, 'verified'),
(9, 'BCA Transfer', 1200000, 'verified'),
(11, 'OVO', 1500000, 'verified'),
(12, 'BCA Transfer', 3500000, 'verified'),
(14, 'Dana', 850000, 'verified'),
(15, 'Credit Card', 1800000, 'verified');

-- N. TICKETS (E-Ticket untuk yang sudah bayar)
INSERT INTO `tickets` (`ticket_id`, `booking_detail_id`, `seat_id`, `check_in_status`, `qr_code_url`) VALUES
('TIX-001', 1, 6, 0, 'qr_001.png'),
('TIX-004', 4, 1, 1, 'qr_004.png'),
('TIX-005', 5, 7, 0, 'qr_005.png'),
('TIX-006', 6, 2, 1, 'qr_006.png'),
('TIX-008', 8, 8, 0, 'qr_008.png'),
('TIX-009', 9, 9, 0, 'qr_009.png'),
('TIX-011', 11, 10, 0, 'qr_011.png'),
('TIX-012', 12, 3, 0, 'qr_012.png'),
('TIX-014', 14, 11, 0, 'qr_014.png'),
('TIX-015', 15, 12, 0, 'qr_015.png');

-- O. REVIEWS (Ulasan User)
INSERT INTO `reviews` (`user_id`, `flight_id`, `rating`, `comment`) VALUES
(2, 1, 5, 'Penerbangan sangat nyaman, makanan enak!'),
(5, 6, 4, 'Pesawat bersih, tapi sedikit delay.'),
(6, 7, 5, 'Singapore Airlines emang terbaik!'),
(7, 8, 5, 'Pramugari ramah sekali.'),
(9, 13, 4, 'Malang-Jakarta lancar jaya.'),
(2, 1, 5, 'Love Garuda Indonesia!'),
(5, 6, 3, 'AC nya agak panas pas nunggu take off.'),
(6, 7, 5, 'Kursi bisnis sangat lega.'),
(7, 8, 4, 'Landing mulus banget.'),
(9, 13, 5, 'On time, mantap!'),
(2, 1, 4, 'Harga promo bikin hemat.'),
(5, 6, 4, 'Bagasinya aman.'),
(6, 7, 5, 'Hiburan di pesawat lengkap.'),
(7, 8, 5, 'Makanan enak, dapet nasi goreng.'),
(9, 13, 4, 'Check in cepat dan mudah.');

-- ==========================================
-- SELESAI - DATABASE SIAP DIGUNAKAN!
-- ==========================================