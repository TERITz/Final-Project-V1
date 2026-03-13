-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2026 at 04:12 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_registration_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `max_attendees` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `user_id`, `event_name`, `description`, `start_date`, `end_date`, `max_attendees`) VALUES
(1, 1, 'Bootcamp: Web Dev & Tailwind CSS', 'เรียนรู้การสร้างเว็บไซต์สวยงามด้วย HTML, CSS และ Tailwind ตั้งแต่พื้นฐาน', '2026-03-15 09:00:00', '2026-03-15 16:00:00', 50),
(2, 2, 'แข่งขัน E-Sports มหาวิทยาลัย (FC Online)', 'ทัวร์นาเมนต์สำหรับสายเกมเมอร์ ชิงเงินรางวัล', '2026-04-10 10:00:00', '2026-04-12 18:00:00', 100),
(3, 1, 'Workshop: Data Structures & Algorithms', 'ติวเข้มเรื่อง Stacks, Queues, Trees และ Big O Notation สำหรับเด็กคอม', '2026-05-05 13:00:00', '2026-05-05 17:00:00', 40),
(4, 3, 'แชร์ทริค สร้างเว็บจัดการการเงินรายบุคคล', 'นำความรู้มาสร้างเว็บ Expense Tracking ด้วยตัวเอง', '2026-06-20 09:00:00', '2026-06-20 12:00:00', 30),
(5, 4, 'ชมรมคนรักมันหวานญี่ปุ่น (Baking Class)', 'สอนอบมันหวานญี่ปุ่นให้หอมหวานเยิ้มๆ', '2026-07-01 14:00:00', '2026-07-01 16:00:00', 20),
(6, 4, 'ทำความดีเพื่อชุมชน', 'ทำดีเพื่อชุมชน กวาดขยะ เก็บขยะ หรือไปช่วยเหลือชุมชน', '2026-07-03 09:00:00', '2026-10-03 00:00:00', 50),
(7, 7, 'ทำความดีเพื่อจังหวัด', 'ทำทำไม', '2026-02-28 10:00:00', '2026-03-01 00:00:00', 5),
(8, 7, 'ทำความดีเพื่อประเทศ', 'ครับ', '2026-03-03 08:00:00', '2026-03-08 00:00:00', 5);

-- --------------------------------------------------------

--
-- Table structure for table `event_images`
--

CREATE TABLE `event_images` (
  `image_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_images`
--

INSERT INTO `event_images` (`image_id`, `event_id`, `image_path`) VALUES
(1, 1, 'tailwind.jpg'),
(2, 2, 'fconline.jpg'),
(3, 3, 'algo.jpg'),
(4, 4, 'finance.jpg'),
(5, 5, 'sweetpotato.jpg'),
(6, 6, 'event_6_1772103730.jpg'),
(7, 7, 'event_7_1772194125.jpg'),
(8, 8, 'event_8_1772194331.png');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `reg_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `reg_date` datetime DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `checked_in_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`reg_id`, `user_id`, `event_id`, `reg_date`, `status`, `checked_in_at`) VALUES
(1, 2, 1, '2026-02-26 17:34:10', 'Approved', NULL),
(2, 3, 1, '2026-02-26 17:34:10', 'checked-in', NULL),
(3, 4, 1, '2026-02-26 17:34:10', 'Pending', NULL),
(4, 5, 2, '2026-02-26 17:34:10', 'Approved', NULL),
(5, 1, 4, '2026-02-26 17:34:10', 'Rejected', NULL),
(7, 7, 6, '2026-02-27 19:13:44', 'Approved', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `prefix` varchar(50) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `birthdate` date NOT NULL,
  `province` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `prefix`, `firstname`, `lastname`, `gender`, `birthdate`, `province`) VALUES
(1, 'user0@gmail.com', '$2y$10$X8ybqLC0uafWB9q97zt0ReZItwv.Vsmqd8hXWW16NpF/l94c/O8Yq', 'นาย', 'สมชาย', 'สายโค้ด', 'ชาย', '2004-05-10', 'มหาสารคาม'),
(2, 'user1@gmail.com', '$2y$10$X8ybqLC0uafWB9q97zt0ReZItwv.Vsmqd8hXWW16NpF/l94c/O8Yq', 'นางสาว', 'สมหญิง', 'ใจดี', 'หญิง', '2005-08-15', 'ขอนแก่น'),
(3, 'user2@gmail.com', '$2y$10$X8ybqLC0uafWB9q97zt0ReZItwv.Vsmqd8hXWW16NpF/l94c/O8Yq', 'นาย', 'มานะ', 'อดทน', 'ชาย', '2003-11-20', 'กรุงเทพมหานคร'),
(4, 'user3@gmail.com', '$2y$10$X8ybqLC0uafWB9q97zt0ReZItwv.Vsmqd8hXWW16NpF/l94c/O8Yq', 'นางสาว', 'ปิติ', 'มีสุข', 'หญิง', '2004-02-28', 'เชียงใหม่'),
(5, 'user4@gmail.com', '$2y$10$X8ybqLC0uafWB9q97zt0ReZItwv.Vsmqd8hXWW16NpF/l94c/O8Yq', 'นาย', 'ชูใจ', 'ใฝ่รู้', 'ชาย', '2005-12-05', 'ภูเก็ต'),
(6, 'test@gmail.com', '$2y$10$X8ybqLC0uafWB9q97zt0ReZItwv.Vsmqd8hXWW16NpF/l94c/O8Yq', 'นาย', 'เทวฤทธิ์', 'กุลบุตร', 'ชาย', '2005-08-15', 'มหาสารคาม'),
(7, 'test1@gmail.com', '$2y$10$MApnW4mi.4q3G6TG2kdv.eIzXdyk9FuvTK51lF6P6FdCm.vbpkpfm', 'นาย', 'เทวฤทธิ์', 'กุลบุตร', 'ชาย', '2005-08-15', 'มหาสารคาม');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `event_images`
--
ALTER TABLE `event_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`reg_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `event_images`
--
ALTER TABLE `event_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `reg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `event_images`
--
ALTER TABLE `event_images`
  ADD CONSTRAINT `event_images_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
