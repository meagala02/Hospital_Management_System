-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2025 at 10:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medicareplus`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `appointment_date`, `appointment_time`, `patient_id`, `doctor_id`) VALUES
(5, '1996-06-19', '03:08:00', 3, 3),
(6, '2025-11-25', '16:00:00', 6, 5),
(7, '2025-11-21', '10:30:00', 6, 4);

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `doctor_name` varchar(150) NOT NULL,
  `user_id` int(11) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `experience` int(11) NOT NULL,
  `availability_start` time NOT NULL,
  `availability_end` time NOT NULL,
  `consultation_charges` decimal(10,2) NOT NULL,
  `location` varchar(255) NOT NULL,
  `qualifications` text NOT NULL,
  `service_id` int(10) UNSIGNED DEFAULT NULL,
  `profile_photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `doctor_name`, `user_id`, `specialization`, `experience`, `availability_start`, `availability_end`, `consultation_charges`, `location`, `qualifications`, `service_id`, `profile_photo`) VALUES
(3, 'jathu', 6, 'Occaecat laboris exc', 0, '00:04:00', '13:16:00', 15000.00, 'Voluptatem numquam b', 'Ipsa eligendi quis ', 7, '1764146760_Vision.jpg'),
(4, 'Dr. Anushka Raman', 9, 'Cardiology', 8, '09:00:00', '14:00:00', 2500.00, 'Colombo General Hospital', 'MBBS, MD (Cardiology), Fellow in Heart Failure Care', 7, '1764146608_Gdoctor3.jpg'),
(5, 'Dr. Aakash Fernando', 10, 'Orthopedics', 9, '14:00:00', '19:00:00', 2500.00, 'Colombo Ortho Care Centre', 'MBBS, MS (Orthopedics), Sports Injury Specialist', 9, '1764146655_Bdoctor2.jpg'),
(6, 'Dr. Nilan Tharindu', 11, 'ENT', 7, '10:00:00', '15:00:00', 1900.00, 'Batticaloa District Hospital', 'MBBS, MS (ENT), Sinus Surgery Expert', 14, '1764146723_Bdoctor3.jpg'),
(7, 'Dr. Meera Senthil', 12, 'Neurology', 6, '16:00:00', '19:30:00', 2300.00, 'Kandy National Hospital', 'MBBS, MD (Neurology), Stroke Specialist', 8, '1764146741_Gdoctor1.jpg'),
(8, 'Dr. Pavithra Nandani', 13, 'Dermatology', 7, '14:00:00', '17:30:00', 2200.00, 'Jaffna Hospital', 'MBBS, MD (Dermatology), Laser Treatment Specialist', 12, '1764146788_Gdoctor4.jpg'),
(9, 'Dr. Shalini Jayawardena', 14, 'Pediatrics', 5, '08:30:00', '14:00:00', 1800.00, 'Galle Teaching Hospital', 'MBBS, DCH, Pediatric Emergency Care', 10, '1764146804_Gdoctor5.jpg'),
(10, 'Dr. Manoj Rajapaksha', 15, 'General Surgery', 11, '09:30:00', '12:30:00', 3000.00, 'Kurunegala Teaching Hospital', 'MBBS, MS (General Surgery), Minimally Invasive', 13, '1764146830_Bdoctor6.jpg'),
(11, 'Dr. Rojan Abeysekara', 16, 'Emergency & Trauma', 12, '05:00:00', '17:00:00', 3500.00, 'Colombo Emergency Unit', 'MBBS, MD (Emergency Medicine), Trauma Life Support Certified', 16, '1764146859_Bdoctor4.jpg'),
(12, 'Dr. Thivakaran Suresh', 17, 'Physiotherapy', 4, '13:30:00', '18:00:00', 1500.00, 'Trincomalee Rehabilitation Centre', 'BPT, MPT (Neuro Rehab), Sports Physio', 15, '1764146876_Bdoctor5.jpg'),
(13, 'Dr. Harini Perera', 18, 'Gynecology & Obstetrics', 10, '09:00:00', '14:00:00', 2600.00, 'Negombo Base Hospital', 'MBBS, MD (Obstetrics & Gynecology), Prenatal Specialist', 11, '1764146899_Gdoctor6.jpg'),
(14, 'Dr.Theebana', 23, 'ENT', 3, '18:30:00', '21:00:00', 1500.00, 'Colombo General Hospital', 'MBBS, MS (ENT), Sinus Surgery Expert', 14, '1764146919_Bdoctor1.jpg'),
(15, 'Raja', 24, 'Neurology', 3, '15:40:00', '19:40:00', 2500.00, 'Colombo General Hospital', 'MBBS, MD (Neurology), Stroke Specialist', 8, ''),
(16, 'Raja', 25, 'mlkmk', 8, '22:43:00', '03:52:00', 15000.00, 'Colombo Ortho Care Centre', 'MBBS, MS (ENT), Sinus Surgery Expert', 16, '');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `feedback_id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `appointment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`feedback_id`, `content`, `rating`, `patient_id`, `appointment_id`) VALUES
(1, 'Hiiikfkndfgknjdf', 5, 3, 5),
(2, 'vdvjidoovd', 3, 3, 5),
(3, 'grthtrhr', 3, 3, 5),
(4, 'Average Management ', 2, 6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `nic` varchar(20) DEFAULT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `user_id`, `name`, `date_of_birth`, `gender`, `nic`, `blood_group`, `address`, `mobile`, `profile_photo`) VALUES
(3, 4, 'Grady Gillespie', '1999-12-15', 'other', 'Provident non volup', 'A+', 'Maxime aliquid repud', 'Impedit omnis rerum', ''),
(4, 5, 'Jelani Buck', '1970-05-03', 'other', 'Totam et impedit te', 'AB-', 'Autem dolores maxime', 'Voluptatum non esse ', ''),
(5, 7, 'Meagalayani Kuvendrean', '2025-11-13', 'female', '200280500106', 'A-', 'no.05,college road, Vavuniya.', '0767755456', ''),
(6, 19, 'Kamal Kanagarasa', '2025-11-23', 'male', '196852644785V', 'O+', 'railway station road,Galle', '0769955423', '');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `name`, `description`) VALUES
(7, 'Cardiology', 'Cardiology deals with the diagnosis and treatment of heart-related conditions. This service helps patients with chest pain, high blood pressure, heart failure, and irregular heartbeat. It includes advanced tests such as ECG, echocardiogram, stress tests, and angiography. Highly skilled cardiologists provide preventative care and emergency treatment to maintain a healthy heart.'),
(8, 'Neurology', 'Neurology focuses on disorders of the brain, spinal cord, and nerves. This includes treating stroke, migraines, seizures, neuropathy, and memory issues. Neurologists use advanced scans and tests to identify problems early. The goal is to improve brain function, reduce symptoms, and support long-term recovery for complex nerve-related conditions.'),
(9, 'Orthopedics', 'Orthopedics provides treatment for bones, joints, muscles, and ligaments. Services include fracture care, arthritis management, joint pain treatment, and sports injury rehabilitation. Orthopedic specialists use modern imaging and surgical techniques to improve movement, reduce pain, and restore mobility. It plays a key role in helping patients return to daily activities.'),
(10, 'Pediatrics', 'Pediatrics focuses on medical care for infants, children, and teenagers. Services include vaccination, growth monitoring, illness treatment, and developmental guidance. Pediatricians provide compassionate care tailored to children’s health needs. They ensure early detection of health issues and support families in maintaining healthy lifestyles for their children.'),
(11, 'Gynecology & Obstetrics', 'This service covers women’s reproductive health, pregnancy care, childbirth, and hormonal issues. Gynecologists manage menstrual problems, infections, infertility, and menopause. Obstetricians ensure safe pregnancy monitoring, prenatal checkups, and delivery support. The service aims to protect women’s health at every stage of life with personalized care.'),
(12, 'Dermatology', 'Dermatology deals with skin, hair, and nail conditions. Services include treatment for acne, allergies, eczema, infections, pigmentation, and hair loss. Dermatologists provide advanced therapies such as laser procedures and skin rejuvenation. The goal is to improve skin health, enhance appearance, and manage chronic skin issues effectively.'),
(13, 'General Surgery', 'General surgery includes surgical treatment for abdominal issues, hernias, gallstones, appendix removal, and trauma injuries. Surgeons use modern, minimally invasive techniques for faster recovery and reduced pain. The service ensures safe procedures and proper postoperative care, helping patients return to normal daily activities quickly.'),
(14, 'ENT (Ear, Nose, Throat)', 'ENT services treat problems related to hearing, nasal congestion, allergies, sinus infections, throat pain, and voice issues. Specialists provide accurate diagnosis using modern equipment and offer treatments such as endoscopy, hearing tests, and minor surgeries. The service aims to restore proper breathing, hearing, and overall head–neck health.'),
(15, 'Physiotherapy', 'Physiotherapy helps patients recover from injuries, surgeries, strokes, and chronic pain conditions. Therapists use exercises, manual therapy, heat treatment, and mobility training to improve strength and flexibility. The service promotes long-term health by reducing pain, restoring movement, and preventing future injuries through guided rehabilitation.'),
(16, 'Emergency & Trauma Care', 'This service provides immediate treatment for accidents, heart attacks, strokes, fractures, breathing problems, and other critical emergencies. A skilled emergency team works 24/7 with advanced equipment to stabilize patients quickly. The goal is to save lives through rapid diagnosis, urgent procedures, and continuous monitoring until recovery.');

-- --------------------------------------------------------

--
-- Table structure for table `test_results`
--

CREATE TABLE `test_results` (
  `test_id` int(11) NOT NULL,
  `test_type` varchar(150) DEFAULT NULL,
  `test_date` date DEFAULT NULL,
  `result_file` varchar(255) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_results`
--

INSERT INTO `test_results` (`test_id`, `test_type`, `test_date`, `result_file`, `patient_id`) VALUES
(1, 'blood sugar', '2025-11-20', '1763797623_Vision.jpg', 6),
(2, 'blood pressure ', '2025-11-26', '1763798376_Gdoctor6.jpg', 5),
(3, 'blood sugar', '2025-11-20', '1763798576_Bdoctor2.jpg', 4),
(4, 'blood pressure ', '2025-11-28', '1764176682_admin.png', 6),
(5, 'blood pressure ', '2025-11-26', '1764222912_back.jpg', 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_role` enum('admin','doctor','patient','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `user_role`) VALUES
(1, 'doctor', 'doctor', 'doctor'),
(4, 'raj', '$2y$10$oDVvzmMf5fWDC33LS1buauZ96bp2PgXZGBwaEOOQ7nXHZcgPYywJG', 'patient'),
(5, 'shan', '$2y$10$ieoCMnxUOk1LL4gsgf//q.YbVHps2I8DG7CLvLv1HfjcsvROwAXN6', 'admin'),
(6, 'jathu', '$2y$10$bymEw8iVOlUY2VbUHni2xewksHjTmzlStmty16osoDtait/V.pn8y', 'doctor'),
(7, 'meagalayani', '$2y$10$IbCK9yGuEefaJbnlSZvzGeZa6feuT/Y..L2Bze95yal0znp4VE/Iy', 'patient'),
(8, 'admin', '$2y$10$Vz1rlMfjVuTj2zmjCyyqN.rlFopP1a.zoYRVzzAVNrdGEEKGyt.fq', 'admin'),
(9, 'dr._anushka_raman', '$2y$10$yJJCzt1wUIwrF6jwRu6VceVygGuuqIfEWECkbvGirGuXut89TCPgK', 'doctor'),
(10, 'dr._aakash_fernando', '$2y$10$8YYe5eEXlHsrRlxl7KBOwOPaR2W9AXw9SMqIGDytBZ5s19cFAHQrW', 'doctor'),
(11, 'dr._nilan_tharindu', '$2y$10$E8lCSeP1sk0tBt6w276XQ.fWe8WPVO7s27WQJ2eTLmhKGrqCQsKFO', 'doctor'),
(12, 'dr._meera_senthil', '$2y$10$fssJcJKjCyzdyN7ZEpcYOuI.t8nirXvUxPiTnv0LJImsw0uo7WXQe', 'doctor'),
(13, 'dr._pavithra_nandani', '$2y$10$/W4pzm73hAbxw4hZ/V/slOWL/UdlVhP1JjocDEqfYwOGVvQ0k0w82', 'doctor'),
(14, 'dr._shalini_jayawardena', '$2y$10$oDcKzzjcgibG5GiYvSatPey9vCZ2ahxH/xuWVNgyiZ54t92Obapw.', 'doctor'),
(15, 'dr._manoj_rajapaksha', '$2y$10$mF.OSrKcwBLqzNQxq8Alauql0/0DlpUOaRdMYWCevrhSvs.dRITtK', 'doctor'),
(16, 'dr._rojan_abeysekara', '$2y$10$/wvAgqBblXB7UJJP1th1AOIQ48O1lWPlZXb9H6cxHfLfaYFkbUaOi', 'doctor'),
(17, 'dr._thivakaran_suresh', '$2y$10$4P9eMNzlyxcp2f27cEmBPeg66S.Y9hoMGfsTg1C2qirhycEL4uOPi', 'doctor'),
(18, 'dr._harini_perera', '$2y$10$Li6hQDihzoquwLPj/DbHHegV5wAvZVAt5bCuRsDXxI.JBsi9aOu.e', 'doctor'),
(19, 'K.Kamal', '$2y$10$82hynCOIj18H1tR8Vw/TRenJWqmbk.yYxerGQ6fhgfllL6i9XIA9a', 'patient'),
(20, 'Vijay', '$2y$10$w1aI1j04Ibme4U3SuXLuJuzGfWh.n54413ooMbIaSo41mXm520UXW', 'admin'),
(21, 'Reanu', '$2y$10$uTutFZWsajPxKWj0S5kHWerd86Ohhcj6dlDvWr6tjcF4xOidyBWpW', 'admin'),
(22, 'dr.theebana', '$2y$10$JVlse42xzTdp2E6srcdEd.LlIFfWpvyIS8KV99bZR/KAz58zZjJj.', 'doctor'),
(23, 'dr.theebana1', '$2y$10$D5aVviuU6YCpO05ukH5ma.bgVXb.Deuv2jqBEbPQuuMIQDyO.MroC', 'doctor'),
(24, 'raja', '$2y$10$HLIoWEcMH/qXB1.g1h4SBOFdgEQFN0NYWWImIKJ52z.NsGzYlUNWa', 'doctor'),
(25, 'raja1', '$2y$10$Zux/qJucGhPl3X.0gjMNyu8q8ASi/3TwGLyuve.rX6cpSniDuYFIq', 'doctor'),
(26, 'jathu1', '$2y$10$clQqPIlAfszRHnZ3n04vxuf.gesgEWPqhyEC1S8OeXgquo2.tya/e', 'doctor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `fk_appointment_patient` (`patient_id`),
  ADD KEY `fk_appointment_doctor` (`doctor_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD KEY `fk_doctor_user` (`user_id`),
  ADD KEY `fk_doctor_service` (`service_id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `fk_feedback_patient` (`patient_id`),
  ADD KEY `fk_feedback_appointment` (`appointment_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD KEY `fk_patient_user` (`user_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `test_results`
--
ALTER TABLE `test_results`
  ADD PRIMARY KEY (`test_id`),
  ADD KEY `fk_testresults_patient` (`patient_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `test_results`
--
ALTER TABLE `test_results`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_appointment_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_appointment_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `fk_doctor_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_doctor_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `fk_feedback_appointment` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`appointment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_feedback_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `fk_patient_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `test_results`
--
ALTER TABLE `test_results`
  ADD CONSTRAINT `fk_testresults_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
