-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2025 at 05:07 AM
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
-- Database: `mhis`
--

-- --------------------------------------------------------

--
-- Table structure for table `barangay`
--

CREATE TABLE `barangay` (
  `barangayID` int(11) NOT NULL,
  `stationID` int(11) NOT NULL,
  `barangayName` text NOT NULL,
  `isActive` tinyint(2) DEFAULT 1 COMMENT '0 = inactive; 1 = active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay`
--

INSERT INTO `barangay` (`barangayID`, `stationID`, `barangayName`, `isActive`) VALUES
(2, 28, 'ATABAYAN', 1),
(3, 28, 'BARROC', 1),
(4, 27, 'BAGACAY', 1),
(5, 27, 'BUGASONGAN', 1),
(6, 27, 'DANAO', 1),
(7, 26, 'BANGKAL', 1),
(8, 26, 'BANTUD', 1),
(9, 26, 'OLO BARROC', 1),
(10, 25, 'BAROSONG', 1),
(11, 25, 'CANABUAN', 1),
(12, 25, 'ISIAN', 1),
(13, 24, 'BINALIUAN MAYOR', 1),
(14, 24, 'BINALIUAN MENOR', 1),
(15, 24, 'LANAG', 1),
(16, 24, 'NAGBA', 1),
(17, 24, 'SAN RAFAEL', 1),
(18, 24, 'SERMON', 1),
(19, 23, 'BUYU-AN', 1),
(20, 23, 'CANSILAYAN', 1),
(21, 23, 'SUPA', 1),
(22, 22, 'CORDOVA NORTE', 1),
(23, 22, 'CORDOVA SUR', 1),
(24, 22, 'LINOBAYAN', 1),
(25, 22, 'SIPITAN', 1),
(26, 21, 'ALUPIDIAN', 1),
(27, 21, 'DAPDAP', 1),
(28, 21, 'ISAUAN', 1),
(29, 21, 'JAMOG', 1),
(30, 21, 'LUBOG', 1),
(31, 21, 'TARO', 1),
(32, 20, 'BAYUCO', 1),
(33, 20, 'BUENAVISTA', 1),
(34, 20, 'GUISIAN', 1),
(35, 19, 'BARANGAY 01', 1),
(36, 19, 'BARANGAY 02', 1),
(37, 19, 'BARANGAY 03', 1),
(38, 19, 'BARANGAY 04', 1),
(39, 19, 'BARANGAY 05', 1),
(40, 18, 'BARANGAY 06', 1),
(41, 18, 'BARANGAY 07', 1),
(44, 18, 'BARANGAY 08', 1),
(45, 18, 'BARANGAY 09', 1),
(46, 18, 'TAN PAEL', 1),
(47, 17, 'BAGUINGIN', 1),
(48, 17, 'NAMOCON', 1),
(49, 16, 'BAGUMBAYAN', 1),
(50, 16, 'BITAS', 1),
(51, 16, 'NAPNAPAN NORTE', 1),
(52, 16, 'NAPNAPAN SUR', 1),
(53, 15, 'PARARA NORTE', 1),
(54, 15, 'PARARA SUR', 1),
(55, 30, 'BARANGAY 10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `calcium_info`
--

CREATE TABLE `calcium_info` (
  `calID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `calNum1` int(11) DEFAULT NULL,
  `calDate1` date DEFAULT NULL,
  `calNum2` int(11) DEFAULT NULL,
  `calDate2` date DEFAULT NULL,
  `calNum3` int(11) DEFAULT NULL,
  `calDate3` date DEFAULT NULL,
  `nutritionalAssessment` tinyint(4) DEFAULT NULL COMMENT '1 = low; 2 = medium; 3 = high',
  `isPosted` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 = posted; 0 = not posted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calcium_info`
--

INSERT INTO `calcium_info` (`calID`, `patientID`, `calNum1`, `calDate1`, `calNum2`, `calDate2`, `calNum3`, `calDate3`, `nutritionalAssessment`, `isPosted`) VALUES
(29, 22, 150, '2022-02-04', 150, '2022-04-01', 150, '2022-05-13', 2, 0),
(30, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(36, 29, 150, '1012-08-07', 150, '1012-10-02', 150, '1012-11-13', 2, 0),
(37, 30, 150, '2023-04-05', 150, '2023-05-21', 150, '2023-07-25', 2, 0),
(38, 31, 150, '2023-03-22', 150, '2023-05-25', 150, '2023-06-01', 2, 0),
(39, 32, 150, '2022-09-19', 150, '2022-11-14', 150, '2022-12-26', 2, 0),
(40, 33, NULL, '2023-03-29', NULL, '2023-05-02', NULL, '2023-08-03', NULL, 0),
(41, 34, 150, '2021-09-21', 150, '2021-11-16', 150, '2021-12-28', 2, 0),
(42, 35, 150, '2023-06-15', 150, '2023-07-15', 150, '2023-08-31', 2, 0),
(43, 36, 150, '2022-08-31', 150, '2022-10-26', 150, '2022-12-07', 2, 0),
(44, 37, 150, '2020-08-04', 150, '2020-09-29', 150, '2020-11-10', 2, 0),
(45, 38, NULL, '2024-08-22', NULL, '2024-10-17', NULL, '2024-11-28', NULL, 0),
(46, 39, 150, '2024-10-04', 150, '2024-11-29', 150, '2025-01-10', 2, 0),
(47, 40, 150, '2024-08-06', 150, '2024-10-01', 150, '2024-11-12', 2, 1),
(48, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(49, 42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(50, 43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(51, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(52, 45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(53, 46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(54, 47, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(55, 48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(56, 49, 150, '2024-07-23', 150, '2024-09-17', 150, '2024-10-29', 2, 0),
(57, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(58, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(59, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(60, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(61, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(62, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(63, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(64, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(65, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(66, 35, 150, '2023-06-15', 150, '2023-07-15', 150, '2023-08-31', 2, 0),
(67, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(68, 37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(69, 38, NULL, '2024-08-22', NULL, '2024-10-17', NULL, '2024-11-28', NULL, 0),
(70, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(71, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(72, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(73, 42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(74, 43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(75, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(76, 45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(77, 46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(78, 47, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(79, 48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(80, 49, 150, '2024-07-23', 150, '2024-09-17', 150, '2024-10-29', 2, 0),
(81, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(82, 51, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(83, 52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(84, 53, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(85, 54, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(86, 55, 150, '2024-09-04', 150, '2024-10-30', 150, '2024-12-11', 2, 1),
(87, 56, 150, '2022-11-10', 150, '2023-01-05', 150, '2023-02-16', 2, 0),
(88, 57, NULL, '2023-03-28', NULL, '2023-05-23', NULL, '2023-07-04', NULL, 0),
(89, 58, 150, '2024-08-24', 150, '2024-10-19', 150, '2024-11-30', NULL, 0),
(90, 59, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(91, 60, 150, '2024-08-22', 150, '2024-10-17', 150, '2024-11-28', 2, 1),
(95, 64, NULL, '2025-07-11', NULL, '2025-09-05', NULL, '2025-10-17', NULL, 0),
(96, 65, 150, '2025-08-07', 150, '2025-10-02', 150, '2025-11-13', NULL, 1),
(97, 66, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

--
-- Triggers `calcium_info`
--
DELIMITER $$
CREATE TRIGGER `calcium_isPosted_update` AFTER UPDATE ON `calcium_info` FOR EACH ROW BEGIN
    IF NEW.isPosted = 1 AND NEW.isPosted <> OLD.isPosted THEN
        IF NEW.calNum1 IS NOT NULL THEN
            INSERT INTO calcium_sched (patientID, calSchedTrimesterType, calSchedTablets, calSchedDate, calSchedStatus)
            VALUES (NEW.patientID, '2nd Trimester', NEW.calNum1, NEW.calDate1, 'Pending');
        END IF;

        IF NEW.calNum2 IS NOT NULL THEN
            INSERT INTO calcium_sched (patientID, calSchedTrimesterType, calSchedTablets, calSchedDate, calSchedStatus)
            VALUES (NEW.patientID, '3rd Trimester', NEW.calNum2, NEW.calDate2, 'Pending');
        END IF;

        IF NEW.calNum3 IS NOT NULL THEN
            INSERT INTO calcium_sched (patientID, calSchedTrimesterType, calSchedTablets, calSchedDate, calSchedStatus)
            VALUES (NEW.patientID, '4th Trimester', NEW.calNum3, NEW.calDate3, 'Pending');
        END IF;

    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `calcium_sched`
--

CREATE TABLE `calcium_sched` (
  `calSchedID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `calSchedTrimesterType` text NOT NULL,
  `calSchedTablets` int(11) NOT NULL,
  `calSchedDate` date NOT NULL,
  `calSchedStatus` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calcium_sched`
--

INSERT INTO `calcium_sched` (`calSchedID`, `patientID`, `calSchedTrimesterType`, `calSchedTablets`, `calSchedDate`, `calSchedStatus`) VALUES
(20, 55, '2nd Trimester', 150, '2024-09-04', 'Pending'),
(21, 55, '3rd Trimester', 150, '2024-10-30', 'Pending'),
(22, 55, '4th Trimester', 150, '2024-12-19', 'Pending'),
(23, 60, '2nd Trimester', 150, '2024-08-22', 'Pending'),
(24, 60, '3rd Trimester', 150, '2024-10-17', 'Pending'),
(25, 60, '4th Trimester', 150, '2024-11-30', 'Completed'),
(26, 65, '2nd Trimester', 150, '2025-08-07', 'Pending'),
(27, 65, '3rd Trimester', 150, '2025-10-02', 'Pending'),
(28, 65, '4th Trimester', 150, '2025-11-13', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `deworming_info`
--

CREATE TABLE `deworming_info` (
  `dwID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `dwDate` date DEFAULT NULL,
  `dwTablet` int(11) DEFAULT NULL,
  `isPosted` tinyint(4) NOT NULL COMMENT '1 = posted; 0 = not posted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deworming_info`
--

INSERT INTO `deworming_info` (`dwID`, `patientID`, `dwDate`, `dwTablet`, `isPosted`) VALUES
(29, 22, NULL, 1, 0),
(30, 23, NULL, NULL, 0),
(36, 29, '2022-07-01', 1, 0),
(37, 30, '2023-05-10', NULL, 0),
(38, 31, NULL, 1, 0),
(39, 32, '2022-08-17', 1, 0),
(40, 33, '2023-04-16', 1, 0),
(41, 34, '2021-09-21', 1, 0),
(42, 35, '2023-07-06', 1, 0),
(43, 36, NULL, 1, 0),
(44, 37, '2021-04-08', 1, 0),
(45, 38, NULL, NULL, 0),
(46, 39, '2024-11-14', 1, 0),
(47, 40, '2024-06-19', 1, 1),
(48, 41, NULL, NULL, 0),
(49, 42, NULL, NULL, 0),
(50, 43, NULL, NULL, 0),
(51, 44, NULL, NULL, 0),
(52, 45, NULL, NULL, 0),
(53, 46, NULL, NULL, 0),
(54, 47, NULL, NULL, 0),
(55, 48, NULL, NULL, 0),
(56, 49, '2024-07-07', 1, 0),
(57, 50, NULL, NULL, 0),
(58, 22, NULL, NULL, 0),
(59, 23, NULL, NULL, 0),
(60, 29, NULL, NULL, 0),
(61, 30, NULL, NULL, 0),
(62, 31, NULL, NULL, 0),
(63, 32, NULL, NULL, 0),
(64, 33, NULL, NULL, 0),
(65, 34, NULL, NULL, 0),
(66, 35, '2023-07-06', 1, 0),
(67, 36, NULL, NULL, 0),
(68, 37, NULL, NULL, 0),
(69, 38, NULL, NULL, 0),
(70, 39, NULL, NULL, 0),
(71, 40, NULL, NULL, 0),
(72, 41, NULL, NULL, 0),
(73, 42, NULL, NULL, 0),
(74, 43, NULL, NULL, 0),
(75, 44, NULL, NULL, 0),
(76, 45, NULL, NULL, 0),
(77, 46, NULL, NULL, 0),
(78, 47, NULL, NULL, 0),
(79, 48, NULL, NULL, 0),
(80, 49, '2024-07-07', 1, 0),
(81, 50, NULL, NULL, 0),
(82, 51, NULL, NULL, 0),
(83, 52, NULL, NULL, 0),
(84, 53, NULL, NULL, 0),
(85, 54, NULL, NULL, 0),
(86, 55, '2024-11-20', 1, 1),
(87, 56, '2021-10-28', 1, 0),
(88, 57, NULL, NULL, 0),
(89, 58, NULL, NULL, 0),
(90, 59, NULL, NULL, 0),
(91, 60, '2024-11-17', 1, 0),
(95, 64, NULL, NULL, 0),
(96, 65, '2025-01-08', 1, 1),
(97, 66, NULL, NULL, 0);

--
-- Triggers `deworming_info`
--
DELIMITER $$
CREATE TRIGGER `deworming_isPosted_update` AFTER UPDATE ON `deworming_info` FOR EACH ROW BEGIN
    IF NEW.isPosted = 1 AND NEW.isPosted <> OLD.isPosted THEN
        INSERT INTO deworming_sched (patientID, dwSchedDate, dwSchedStatus)
        VALUES (NEW.patientID, NEW.dwDate, 'Pending');
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `deworming_sched`
--

CREATE TABLE `deworming_sched` (
  `dwSchedID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `dwSchedDate` date NOT NULL,
  `dwSchedTablet` int(11) NOT NULL,
  `dwSchedStatus` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deworming_sched`
--

INSERT INTO `deworming_sched` (`dwSchedID`, `patientID`, `dwSchedDate`, `dwSchedTablet`, `dwSchedStatus`) VALUES
(4, 55, '2024-11-20', 0, 'Pending'),
(5, 65, '2025-01-08', 0, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `infectious`
--

CREATE TABLE `infectious` (
  `infectiousID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `syphilisDate` date DEFAULT NULL,
  `syphilisResult` tinyint(4) DEFAULT NULL COMMENT '1 = positive; 0 = negative',
  `hepatitisDate` date DEFAULT NULL,
  `hepatitisResult` tinyint(4) DEFAULT NULL COMMENT '1 = positive; 0 = negative',
  `hivScreeningDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `infectious`
--

INSERT INTO `infectious` (`infectiousID`, `patientID`, `syphilisDate`, `syphilisResult`, `hepatitisDate`, `hepatitisResult`, `hivScreeningDate`) VALUES
(29, 22, '2022-04-01', NULL, '2022-04-01', NULL, NULL),
(30, 23, NULL, NULL, NULL, NULL, NULL),
(36, 29, '2022-07-01', NULL, '2022-07-01', NULL, NULL),
(37, 30, '2023-02-28', NULL, '2023-02-28', NULL, NULL),
(38, 31, NULL, NULL, NULL, NULL, NULL),
(39, 32, '2022-06-01', NULL, '2022-06-01', 1, NULL),
(40, 33, '2023-03-31', NULL, '2023-03-31', NULL, NULL),
(41, 34, '2021-01-07', NULL, '2021-01-07', NULL, NULL),
(42, 35, '2023-04-27', NULL, '2023-04-27', NULL, NULL),
(43, 36, '2022-07-01', NULL, '0222-07-01', 1, NULL),
(44, 37, NULL, NULL, NULL, NULL, NULL),
(45, 38, NULL, NULL, NULL, NULL, NULL),
(46, 39, NULL, NULL, NULL, NULL, NULL),
(47, 40, '2024-03-13', NULL, '2024-03-13', NULL, NULL),
(48, 41, NULL, NULL, NULL, NULL, NULL),
(49, 42, NULL, NULL, NULL, NULL, NULL),
(50, 43, NULL, NULL, NULL, NULL, NULL),
(51, 44, NULL, NULL, NULL, NULL, NULL),
(52, 45, NULL, NULL, NULL, NULL, NULL),
(53, 46, NULL, NULL, NULL, NULL, NULL),
(54, 47, NULL, NULL, NULL, NULL, NULL),
(55, 48, NULL, NULL, NULL, NULL, NULL),
(56, 49, '2024-08-08', NULL, '2024-08-08', NULL, '2024-08-08'),
(57, 50, NULL, NULL, NULL, NULL, NULL),
(58, 22, NULL, NULL, NULL, NULL, NULL),
(59, 23, NULL, NULL, NULL, NULL, NULL),
(60, 29, NULL, NULL, NULL, NULL, NULL),
(61, 30, NULL, NULL, NULL, NULL, NULL),
(62, 31, NULL, NULL, NULL, NULL, NULL),
(63, 32, NULL, NULL, NULL, NULL, NULL),
(64, 33, NULL, NULL, NULL, NULL, NULL),
(65, 34, NULL, NULL, NULL, NULL, NULL),
(66, 35, '2023-04-27', NULL, '2023-04-27', NULL, NULL),
(67, 36, NULL, NULL, NULL, NULL, NULL),
(68, 37, NULL, NULL, NULL, NULL, NULL),
(69, 38, NULL, NULL, NULL, NULL, NULL),
(70, 39, NULL, NULL, NULL, NULL, NULL),
(71, 40, NULL, NULL, NULL, NULL, NULL),
(72, 41, NULL, NULL, NULL, NULL, NULL),
(73, 42, NULL, NULL, NULL, NULL, NULL),
(74, 43, NULL, NULL, NULL, NULL, NULL),
(75, 44, NULL, NULL, NULL, NULL, NULL),
(76, 45, NULL, NULL, NULL, NULL, NULL),
(77, 46, NULL, NULL, NULL, NULL, NULL),
(78, 47, NULL, NULL, NULL, NULL, NULL),
(79, 48, NULL, NULL, NULL, NULL, NULL),
(80, 49, '2024-08-08', NULL, '2024-08-08', NULL, '2024-08-08'),
(81, 50, NULL, NULL, NULL, NULL, NULL),
(82, 51, NULL, NULL, NULL, NULL, NULL),
(83, 52, '2022-12-12', NULL, '2022-12-12', NULL, '2022-12-12'),
(84, 53, NULL, NULL, NULL, NULL, NULL),
(85, 54, NULL, NULL, NULL, NULL, NULL),
(86, 55, '2024-11-21', NULL, '2024-11-22', NULL, '2024-11-23'),
(87, 56, '2021-07-07', NULL, '2021-07-07', NULL, '2021-07-07'),
(88, 57, NULL, NULL, NULL, NULL, NULL),
(89, 58, '2024-03-02', NULL, '2024-03-02', NULL, '2024-03-02'),
(90, 59, NULL, NULL, NULL, NULL, NULL),
(91, 60, '2024-11-17', NULL, '2024-11-18', NULL, NULL),
(95, 64, NULL, NULL, NULL, NULL, NULL),
(96, 65, NULL, NULL, NULL, NULL, NULL),
(97, 66, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventoryID` int(11) NOT NULL,
  `stationID` int(11) DEFAULT NULL,
  `medicineID` int(11) DEFAULT NULL,
  `availableStock` int(11) NOT NULL,
  `dateUpdate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventoryID`, `stationID`, `medicineID`, `availableStock`, `dateUpdate`) VALUES
(9, 25, 9, 500, '2024-11-14'),
(10, 25, 11, 1020, '2024-11-14'),
(11, 19, 9, 600, '2024-11-14'),
(12, 25, 8, 50, '2024-11-14'),
(13, 19, 11, 40, '2024-11-14'),
(14, 19, 10, 40, '2024-11-14'),
(15, 28, 8, 500, '2024-11-15'),
(16, 28, 9, 500, '2024-11-15'),
(17, 19, 8, 100, '2024-12-16'),
(18, 20, 9, 15, '2025-01-01'),
(19, 18, 11, 12, '2025-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_history`
--

CREATE TABLE `inventory_history` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `medicine_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_history`
--

INSERT INTO `inventory_history` (`id`, `patient_id`, `medicine_id`, `quantity`, `date_created`) VALUES
(1, 55, 10, 1, '2024-12-18 19:04:07'),
(2, 55, 10, 1, '2024-12-18 19:05:10'),
(3, 55, 10, 1, '2024-12-18 19:07:31');

-- --------------------------------------------------------

--
-- Table structure for table `iodine_info`
--

CREATE TABLE `iodine_info` (
  `iodID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `iodDate` date DEFAULT NULL,
  `iodTablet` int(11) DEFAULT NULL COMMENT '1 = posted; 0 = not posted',
  `isPosted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `iodine_info`
--

INSERT INTO `iodine_info` (`iodID`, `patientID`, `iodDate`, `iodTablet`, `isPosted`) VALUES
(75, 22, '2021-10-08', 1, 0),
(76, 23, NULL, NULL, 0),
(77, 29, '1012-04-10', 1, 0),
(78, 30, '2023-01-09', NULL, 0),
(79, 31, '2022-12-11', 1, 0),
(80, 32, '2022-05-23', 1, 0),
(81, 33, '2023-02-09', NULL, 0),
(82, 34, '2021-05-25', 1, 0),
(83, 35, '2023-04-27', NULL, 0),
(84, 36, '2022-05-04', 1, 0),
(85, 37, '2020-04-07', 1, 0),
(86, 38, '2024-04-25', NULL, 0),
(87, 39, '2024-06-07', NULL, 0),
(88, 40, '2024-04-09', 1, 1),
(89, 41, NULL, NULL, 0),
(90, 42, NULL, NULL, 0),
(91, 43, NULL, NULL, 0),
(92, 44, NULL, NULL, 0),
(93, 45, NULL, NULL, 0),
(94, 46, NULL, NULL, 0),
(95, 47, NULL, NULL, 0),
(96, 48, NULL, NULL, 0),
(97, 49, '2024-03-26', NULL, 0),
(98, 50, NULL, NULL, 0),
(99, 51, NULL, NULL, 0),
(100, 52, NULL, NULL, 0),
(101, 53, NULL, NULL, 0),
(102, 54, NULL, NULL, 0),
(103, 55, '2024-05-08', 1, 1),
(104, 56, '2022-07-14', 1, 0),
(105, 57, '2022-11-29', NULL, 0),
(106, 58, '2024-04-27', NULL, 0),
(107, 59, NULL, NULL, 0),
(108, 60, '2024-04-25', 1, 0),
(112, 64, NULL, NULL, 0),
(114, 66, NULL, NULL, 0),
(115, 65, '2025-01-06', 1, 1);

--
-- Triggers `iodine_info`
--
DELIMITER $$
CREATE TRIGGER ` iodine_isPosted_update` AFTER UPDATE ON `iodine_info` FOR EACH ROW BEGIN
    IF NEW.isPosted = 1 AND NEW.isPosted <> OLD.isPosted THEN
        INSERT INTO iodine_sched (patientID, iodSchedDate, iodSchedStatus)
        VALUES (NEW.patientID, NEW.iodDate, 'Pending');
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `iodine_sched`
--

CREATE TABLE `iodine_sched` (
  `iodSchedID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `iodSchedDate` date NOT NULL,
  `iodSchedTablet` int(11) NOT NULL,
  `iodSchedStatus` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `iodine_sched`
--

INSERT INTO `iodine_sched` (`iodSchedID`, `patientID`, `iodSchedDate`, `iodSchedTablet`, `iodSchedStatus`) VALUES
(6, 55, '2024-12-20', 1, 'Pending'),
(7, 55, '2024-05-08', 1, 'Pending'),
(8, 65, '2025-01-06', 1, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `laboratory`
--

CREATE TABLE `laboratory` (
  `labID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `gestationalDate` date DEFAULT NULL,
  `gestationalResult` tinyint(4) DEFAULT NULL COMMENT '1 = positive; 0 = negative',
  `cbcHgbHctDate` date DEFAULT NULL,
  `cbcHgbHctResult` tinyint(4) DEFAULT NULL COMMENT '1 = with anemia; 0 = without anemia',
  `cbcHgbHctIron` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laboratory`
--

INSERT INTO `laboratory` (`labID`, `patientID`, `gestationalDate`, `gestationalResult`, `cbcHgbHctDate`, `cbcHgbHctResult`, `cbcHgbHctIron`) VALUES
(29, 22, '2022-04-01', NULL, '2022-04-01', NULL, NULL),
(30, 23, NULL, NULL, NULL, NULL, NULL),
(36, 29, '2022-07-01', NULL, '2022-07-01', NULL, NULL),
(37, 30, '2023-02-28', NULL, '2023-02-28', NULL, 180),
(38, 31, NULL, NULL, NULL, NULL, NULL),
(39, 32, '2022-06-01', 1, '2022-06-01', NULL, NULL),
(40, 33, '2023-03-31', 1, '2023-03-31', NULL, 180),
(41, 34, '2021-01-07', NULL, '2021-01-07', NULL, NULL),
(42, 35, '2023-04-27', NULL, '2023-04-27', NULL, 180),
(43, 36, '2022-07-01', NULL, '2022-07-01', NULL, NULL),
(44, 37, NULL, NULL, NULL, NULL, NULL),
(45, 38, NULL, NULL, NULL, NULL, NULL),
(46, 39, NULL, NULL, NULL, NULL, NULL),
(47, 40, '2024-03-13', NULL, NULL, NULL, NULL),
(48, 41, NULL, NULL, NULL, NULL, NULL),
(49, 42, NULL, NULL, NULL, NULL, NULL),
(50, 43, NULL, NULL, NULL, NULL, NULL),
(51, 44, NULL, NULL, NULL, NULL, NULL),
(52, 45, NULL, NULL, NULL, NULL, NULL),
(53, 46, NULL, NULL, NULL, NULL, NULL),
(54, 47, NULL, NULL, NULL, NULL, NULL),
(55, 48, NULL, NULL, NULL, NULL, NULL),
(56, 49, '2024-08-08', NULL, '2024-08-08', NULL, NULL),
(57, 50, NULL, NULL, NULL, NULL, NULL),
(58, 22, NULL, NULL, NULL, NULL, NULL),
(59, 23, NULL, NULL, NULL, NULL, NULL),
(60, 29, NULL, NULL, NULL, NULL, NULL),
(61, 30, NULL, NULL, NULL, NULL, NULL),
(62, 31, NULL, NULL, NULL, NULL, NULL),
(63, 32, NULL, NULL, NULL, NULL, NULL),
(64, 33, NULL, NULL, NULL, NULL, NULL),
(65, 34, NULL, NULL, NULL, NULL, NULL),
(66, 35, '2023-04-27', NULL, '2023-04-27', NULL, 180),
(67, 36, NULL, NULL, NULL, NULL, NULL),
(68, 37, NULL, NULL, NULL, NULL, NULL),
(69, 38, NULL, NULL, NULL, NULL, NULL),
(70, 39, NULL, NULL, NULL, NULL, NULL),
(71, 40, NULL, NULL, NULL, NULL, NULL),
(72, 41, NULL, NULL, NULL, NULL, NULL),
(73, 42, NULL, NULL, NULL, NULL, NULL),
(74, 43, NULL, NULL, NULL, NULL, NULL),
(75, 44, NULL, NULL, NULL, NULL, NULL),
(76, 45, NULL, NULL, NULL, NULL, NULL),
(77, 46, NULL, NULL, NULL, NULL, NULL),
(78, 47, NULL, NULL, NULL, NULL, NULL),
(79, 48, NULL, NULL, NULL, NULL, NULL),
(80, 49, '2024-08-08', NULL, '2024-08-08', NULL, NULL),
(81, 50, NULL, NULL, NULL, NULL, NULL),
(82, 51, NULL, NULL, NULL, NULL, NULL),
(83, 52, '2022-12-12', NULL, '2022-12-12', NULL, NULL),
(84, 53, NULL, NULL, NULL, NULL, NULL),
(85, 54, NULL, NULL, NULL, NULL, NULL),
(86, 55, '2024-11-24', NULL, '2024-11-25', NULL, NULL),
(87, 56, '2021-07-07', NULL, '2021-07-07', NULL, 180),
(88, 57, NULL, NULL, NULL, NULL, NULL),
(89, 58, '2024-03-02', 1, '2024-03-02', NULL, NULL),
(90, 59, NULL, NULL, NULL, NULL, NULL),
(91, 60, '2024-11-19', NULL, '2024-11-20', NULL, NULL),
(95, 64, NULL, NULL, NULL, NULL, NULL),
(96, 65, NULL, NULL, NULL, NULL, NULL),
(97, 66, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `medicineID` int(11) NOT NULL,
  `medicineName` text DEFAULT NULL,
  `medicineCategory` text DEFAULT NULL,
  `medicineStock` int(11) DEFAULT NULL,
  `dateUpdate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`medicineID`, `medicineName`, `medicineCategory`, `medicineStock`, `dateUpdate`) VALUES
(8, 'IRON', 'iron', 957, '2025-01-01'),
(9, 'CALCIUM', 'calcium', 970, '2025-01-01'),
(10, 'IODINE', 'iodine', 1500, '2024-11-15'),
(11, 'DEWORM', 'deworming', 488, '2024-11-15'),
(14, 'IRON 2', 'iron', 150, '2024-12-30');

-- --------------------------------------------------------

--
-- Table structure for table `micronutrient_info`
--

CREATE TABLE `micronutrient_info` (
  `ironID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `ironNum1` int(11) DEFAULT NULL,
  `ironDate1` date DEFAULT NULL,
  `ironNum2` int(11) DEFAULT NULL,
  `ironDate2` date DEFAULT NULL,
  `ironNum3` int(11) DEFAULT NULL,
  `ironDate3` date DEFAULT NULL,
  `ironNum4` int(11) DEFAULT NULL,
  `ironDate4` date DEFAULT NULL,
  `isPosted` tinyint(4) NOT NULL COMMENT '1 = posted; 0 = not posted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `micronutrient_info`
--

INSERT INTO `micronutrient_info` (`ironID`, `patientID`, `ironNum1`, `ironDate1`, `ironNum2`, `ironDate2`, `ironNum3`, `ironDate3`, `ironNum4`, `ironDate4`, `isPosted`) VALUES
(29, 22, 30, '2021-10-08', 30, '2022-02-04', 30, '2022-04-01', 30, '2022-05-13', 1),
(30, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(36, 29, 30, '1012-04-10', 30, '1012-08-07', 30, '1012-10-02', 30, '1012-11-13', 0),
(37, 30, 60, '2023-01-09', 60, '2023-04-05', 60, '2023-05-21', 60, '2023-07-25', 0),
(38, 31, 30, '2022-12-11', 30, '2023-03-22', 30, '2023-05-25', 30, '2023-06-01', 0),
(39, 32, 30, '2022-05-23', 30, '2022-09-19', 30, '2022-11-14', 30, '2022-12-26', 0),
(40, 33, 60, '2023-02-09', 60, '2023-03-29', 60, '2023-05-02', 60, '2023-08-03', 0),
(41, 34, 30, '2021-05-25', 30, '2021-09-21', 30, '2021-11-16', 30, '2021-12-28', 0),
(42, 35, 60, '2023-04-27', 60, '2023-06-15', 30, '2023-07-15', 30, '2023-08-31', 0),
(43, 36, 30, '2022-05-04', 30, '2022-08-31', 30, '2022-10-26', 30, '2022-12-07', 0),
(44, 37, 30, '2020-04-07', 30, '2020-08-04', 30, '2020-09-29', 30, '2020-11-10', 0),
(45, 38, NULL, '2024-04-25', NULL, '2024-08-22', NULL, '2024-10-17', NULL, '2024-11-28', 0),
(46, 39, 30, '2024-06-07', 30, '2024-10-04', 30, '2024-11-29', 30, '2025-01-10', 1),
(47, 40, 60, '2024-04-09', 60, '2024-08-06', 60, '2024-10-01', 60, '2024-11-12', 1),
(48, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(49, 42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(50, 43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(51, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(52, 45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(53, 46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(54, 47, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(55, 48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(56, 49, 60, '2024-03-26', 60, '2024-07-23', 30, '2024-09-17', 60, '2024-10-29', 0),
(57, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(58, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(59, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(60, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(61, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(62, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(63, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(64, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(65, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(66, 35, 60, '2023-04-27', 60, '2023-06-15', 30, '2023-07-15', 30, '2023-08-31', 0),
(67, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(68, 37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(69, 38, NULL, '2024-04-25', NULL, '2024-08-22', NULL, '2024-10-17', NULL, '2024-11-28', 0),
(70, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(71, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(72, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(73, 42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(74, 43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(75, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(76, 45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(77, 46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(78, 47, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(79, 48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(80, 49, 60, '2024-03-26', 60, '2024-07-23', 30, '2024-09-17', 60, '2024-10-29', 0),
(81, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(82, 51, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(83, 52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(84, 53, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(85, 54, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(86, 55, 30, '2024-05-08', 30, '2024-09-04', 30, '2024-10-30', 30, '2024-12-11', 1),
(87, 56, 30, '2022-07-14', 30, '2022-11-10', 60, '2023-01-05', 60, '2023-02-16', 0),
(88, 57, NULL, '2022-11-29', NULL, '2023-03-28', NULL, '2023-05-23', NULL, '2023-07-04', 0),
(89, 58, 30, '2024-04-27', 30, '2024-08-24', 30, '2024-10-19', 30, '2024-11-30', 0),
(90, 59, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(91, 60, 60, '2024-04-25', 60, '2024-08-22', 60, '2024-10-17', 60, '2024-11-28', 0),
(95, 64, NULL, '2025-03-14', NULL, '2025-07-11', NULL, '2025-09-05', NULL, '2025-10-17', 0),
(96, 65, 30, '2025-04-10', 30, '2025-08-07', 30, '2025-10-02', 30, '2025-11-13', 1),
(97, 66, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

--
-- Triggers `micronutrient_info`
--
DELIMITER $$
CREATE TRIGGER `micronutrient_isPosted_update` AFTER UPDATE ON `micronutrient_info` FOR EACH ROW BEGIN
    IF NEW.isPosted = 1 AND NEW.isPosted <> OLD.isPosted THEN
        IF NEW.ironNum1 IS NOT NULL THEN
            INSERT INTO micronutrient_sched (patientID, ironSchedTrimesterType, ironSchedTablets, ironSchedDate, ironSchedStatus)
            VALUES (NEW.patientID, '1st Trimester', NEW.ironNum1, NEW.ironDate1, 'Pending');
        END IF;

        IF NEW.ironNum2 IS NOT NULL THEN
            INSERT INTO micronutrient_sched (patientID, ironSchedTrimesterType, ironSchedTablets, ironSchedDate, ironSchedStatus)
            VALUES (NEW.patientID, '2nd Trimester', NEW.ironNum2, NEW.ironDate2, 'Pending');
        END IF;

        IF NEW.ironNum3 IS NOT NULL THEN
            INSERT INTO micronutrient_sched (patientID, ironSchedTrimesterType, ironSchedTablets, ironSchedDate, ironSchedStatus)
            VALUES (NEW.patientID, '3rd Trimester', NEW.ironNum3, NEW.ironDate3, 'Pending');
        END IF;

        IF NEW.ironNum4 IS NOT NULL THEN
            INSERT INTO micronutrient_sched (patientID, ironSchedTrimesterType, ironSchedTablets, ironSchedDate, ironSchedStatus)
            VALUES (NEW.patientID, '4th Trimester', NEW.ironNum4, NEW.ironDate4, 'Pending');
        END IF;

    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `micronutrient_sched`
--

CREATE TABLE `micronutrient_sched` (
  `ironSchedID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `ironSchedTrimesterType` text NOT NULL,
  `ironSchedTablets` int(11) NOT NULL,
  `ironSchedDate` date NOT NULL,
  `ironSchedStatus` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `micronutrient_sched`
--

INSERT INTO `micronutrient_sched` (`ironSchedID`, `patientID`, `ironSchedTrimesterType`, `ironSchedTablets`, `ironSchedDate`, `ironSchedStatus`) VALUES
(13, 55, '1st Trimester', 30, '2024-12-30', 'Pending'),
(14, 55, '2nd Trimester', 30, '2024-09-04', 'Pending'),
(15, 55, '3rd Trimester', 30, '2024-10-30', 'Pending'),
(16, 55, '4th Trimester', 30, '2024-12-11', 'Pending'),
(17, 65, '1st Trimester', 30, '2025-01-01', 'Pending'),
(18, 65, '2nd Trimester', 30, '2025-08-07', 'Pending'),
(19, 65, '3rd Trimester', 30, '2025-10-02', 'Pending'),
(20, 65, '4th Trimester', 30, '2025-11-13', 'Pending'),
(21, 39, '1st Trimester', 30, '2024-06-07', 'Pending'),
(22, 39, '2nd Trimester', 30, '2024-10-04', 'Pending'),
(23, 39, '3rd Trimester', 30, '2024-11-29', 'Pending'),
(24, 39, '4th Trimester', 30, '2025-01-10', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patientID` int(11) NOT NULL,
  `barangayID` int(11) DEFAULT NULL,
  `patientSerialNumber` varchar(20) NOT NULL,
  `registrationDate` date NOT NULL,
  `patientFname` text NOT NULL,
  `patientMname` text NOT NULL,
  `patientLname` text NOT NULL,
  `patientBirthday` date NOT NULL,
  `patientAge` int(11) NOT NULL,
  `patientWeight` float NOT NULL,
  `patientHeight` float NOT NULL,
  `patientBMI` float NOT NULL,
  `patientBMICategory` text NOT NULL,
  `patientBloodType` text NOT NULL,
  `patientContactNumber` varchar(20) DEFAULT NULL,
  `patientEmergencyContact` varchar(20) DEFAULT NULL,
  `patientNHTS` tinyint(4) NOT NULL COMMENT '1 = yes; 0 = no',
  `isActive` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = active; 0 = inactive	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patientID`, `barangayID`, `patientSerialNumber`, `registrationDate`, `patientFname`, `patientMname`, `patientLname`, `patientBirthday`, `patientAge`, `patientWeight`, `patientHeight`, `patientBMI`, `patientBMICategory`, `patientBloodType`, `patientContactNumber`, `patientEmergencyContact`, `patientNHTS`, `isActive`) VALUES
(22, 10, '71335848', '2024-11-14', 'Ava', 'Harris', 'Clark', '1995-08-24', 29, 45, 1.47, 20.82, 'Normal', 'O+', NULL, NULL, 2, 1),
(23, 10, '31944117', '2024-11-14', 'Emma', 'Brown', 'Anderson', '1995-02-01', 29, 40, 1.32, 22.96, 'Normal', 'O+', NULL, NULL, 1, 1),
(29, 10, '09237750', '2024-11-14', 'Pearl', 'Solis', 'Medina', '1996-01-17', 28, 48, 1.52, 20.78, 'Normal', 'O-', NULL, NULL, 1, 1),
(30, 54, '83957308', '2024-11-14', 'Maria', 'Elena', 'Santos', '2001-07-27', 23, 55, 1.55, 22.89, 'Normal', 'A+', NULL, NULL, 1, 1),
(31, 44, '99375332', '2024-11-14', 'Carla', 'Yan', 'Santos', '1992-07-19', 32, 53, 1.58, 21.23, 'Normal', 'O+', NULL, NULL, 2, 1),
(32, 10, '34938967', '2024-11-14', 'Riza', 'Castro', 'Mendoza', '1978-10-20', 46, 52, 1.5, 23.11, 'Normal', '', NULL, NULL, 1, 1),
(33, 54, '96218298', '2024-11-14', 'Isabelle ', 'Santos', 'Torres', '1997-06-27', 27, 60, 1.58, 24.03, 'Normal', 'B-', NULL, NULL, 2, 1),
(34, 45, '51987388', '2024-11-14', 'Shane', 'Corros', 'Yap', '2006-10-15', 18, 42, 1.5, 18.67, 'Normal', 'A+', NULL, NULL, 1, 1),
(35, 54, '90787392', '2024-11-14', 'Gabrielle ', 'Sofia', 'Cruz', '1997-02-10', 27, 60, 1.6, 23.44, 'Normal', 'A+', NULL, NULL, 1, 1),
(36, 10, '44755976', '2024-11-14', 'Sofia', 'Medine', 'Rivera', '1996-08-23', 28, 48, 1.48, 21.91, 'Normal', 'B+', NULL, NULL, 1, 1),
(37, 45, '07522228', '2024-11-14', 'Jane ', 'Kai', 'Palma', '1990-10-09', 34, 53, 1.5, 23.56, 'Normal', 'B+', NULL, NULL, 1, 1),
(38, 53, '70632331', '2024-11-14', 'Luisa', 'Cruz', 'Reyes', '1995-01-14', 29, 57, 1.6, 22.27, 'Normal', '', NULL, NULL, 1, 1),
(39, 35, '59022408', '2024-11-14', 'Maria Isabel', 'Flores ', 'Santos', '2000-05-09', 24, 40, 1.64, 14.87, 'Underweight', 'O+', NULL, NULL, 1, 1),
(40, 35, '37840850', '2024-11-14', 'Jenny Rose', 'Elumbra', 'Francisco', '2000-07-06', 24, 56, 1.21, 38.25, 'Obese', 'O+', NULL, NULL, 1, 1),
(41, 35, '98545734', '2024-11-14', ' Lea Patricia', 'Francisco', 'Ramos', '1999-07-08', 25, 47, 1.57, 19.07, 'Normal', 'O-', NULL, NULL, 2, 1),
(42, 35, '50238349', '2024-11-14', 'Kristine Joy', 'Castillo', 'Bautista', '1998-04-14', 26, 55, 1.75, 17.96, 'Underweight', 'O+', NULL, NULL, 1, 1),
(43, 36, '97399639', '2024-11-14', 'Jessa Marie', 'Aquino', 'Cruz', '1999-03-17', 25, 66, 2.15, 14.28, 'Underweight', 'O+', NULL, NULL, 1, 1),
(44, 36, '58118213', '2024-11-14', 'Patricia Ann', 'Lopez', 'Garcia', '1997-06-10', 27, 54, 1.7, 18.69, 'Normal', 'O+', NULL, NULL, 1, 1),
(45, 36, '81518498', '2024-11-14', 'Shaira Lyn', 'Domingo', 'Flores', '1999-02-10', 25, 78, 1.9, 21.61, 'Normal', 'O+', NULL, NULL, 2, 1),
(46, 36, '16775328', '2024-11-14', 'Louella May', 'Soriano', 'Mendoza', '1997-05-05', 27, 54, 1.6, 21.09, 'Normal', 'O+', NULL, NULL, 2, 1),
(47, 37, '23155581', '2024-11-14', 'Nicole Therese', 'Hernandez', 'Ramos', '1997-01-08', 27, 61, 1.75, 19.92, 'Normal', 'O+', NULL, NULL, 1, 1),
(48, 37, '98589779', '2024-11-14', 'Lara Mae', 'Dizon', 'Reyes', '1997-06-12', 27, 69, 1.6, 26.95, 'Overweight', 'O+', NULL, NULL, 2, 1),
(49, 37, '42360286', '2024-11-14', 'Camille Joy', 'Torres', 'Garcia', '1998-07-11', 26, 50, 1.4, 25.51, 'Overweight', 'O+', NULL, NULL, 2, 1),
(50, 37, '85651083', '2024-11-14', 'Bianca Marie', 'Esteban', 'Cruz', '1998-06-12', 26, 40, 1.45, 19.02, 'Normal', 'O+', '', '', 0, 1),
(51, 38, '10946122', '2024-11-14', 'Patricia Grace ', 'Cabrera ', 'Lopez', '1997-07-09', 27, 67, 1.4, 34.18, 'Obese', 'O+', '', '', 0, 1),
(52, 2, '88654042', '2024-11-15', 'Liza Jane ', 'Cruz ', 'Santos', '2000-03-20', 24, 60, 1.7, 20.76, 'Normal', 'O+', NULL, NULL, 1, 1),
(53, 2, '53229238', '2024-11-15', 'Hazel Ann', 'Garcia', 'Flores', '1998-06-15', 26, 59, 1.7, 20.42, 'Normal', 'O+', NULL, NULL, 2, 1),
(54, 38, '93925371', '2024-11-15', 'Glenda May ', 'Sandoval ', 'Navarro', '1997-01-02', 27, 70, 1.8, 21.6, 'Normal', 'O+', NULL, NULL, 2, 1),
(55, 39, '19049927', '2024-11-15', 'Mari Jane', 'Elumbra', 'Antes', '1996-10-15', 28, 59, 1.78, 18.62, 'Normal', 'O+', NULL, NULL, 1, 1),
(56, 13, '72889706', '2024-11-15', 'Catherine', 'Ramos', 'Garcia', '1999-09-15', 25, 55, 1.6, 21.48, 'Normal', 'A+', NULL, NULL, 2, 1),
(57, 18, '08464986', '2024-11-15', 'Jessie', 'Lopez', 'Ramos', '2000-07-20', 24, 68, 1.72, 22.99, 'Normal', 'AB+', '09307504445', '09307504432', 1, 1),
(58, 39, '18280200', '2024-11-15', 'Isabel', 'Mendoza', 'Trinidad', '1990-11-02', 34, 50, 1.7, 17.3, 'Underweight', 'O+', NULL, NULL, 1, 1),
(59, 15, '49649908', '2024-11-15', 'Victoria', 'Mercado', 'Aquino', '2001-12-31', 22, 54, 1.49, 24.32, 'Normal', 'A+', '09978235329', NULL, 2, 1),
(60, 39, '55268206', '2024-11-15', 'Carla', 'Kai', 'Sotto', '2000-01-15', 24, 50, 1.7, 17.3, 'Underweight', 'O+', NULL, NULL, 2, 1),
(64, 39, '05342422', '2024-12-19', 'awd', 'awd', 'awd', '2024-12-20', -1, 123, 123, 0.01, 'Underweight', '', '09463895102', '123123', 1, 1),
(65, 35, '07181992', '2025-01-05', 'test', 'test', 'test', '1997-01-09', 27, 165, 57, 0.05, 'Underweight', 'O+', '09463895102', '123123', 1, 1),
(66, 35, '94975256', '2025-01-05', 'test 2', 'test 2', 'test2', '1997-05-04', 27, 156, 57, 0.05, 'Underweight', 'O-', '09463895102', '123123', 1, 1);

--
-- Triggers `patient`
--
DELIMITER $$
CREATE TRIGGER `after_patient_insert` AFTER INSERT ON `patient` FOR EACH ROW BEGIN
    -- Insert into calcium_info
    INSERT INTO calcium_info (patientID) VALUES (NEW.patientID);
    
    -- Insert into deworming_info
    INSERT INTO deworming_info (patientID) VALUES (NEW.patientID);
    
    -- Insert into infectious
    INSERT INTO infectious (patientID) VALUES (NEW.patientID);
    
    -- Insert into laboratory
    INSERT INTO laboratory (patientID) VALUES (NEW.patientID);
    
    -- Insert into micronutrient_info
    INSERT INTO micronutrient_info (patientID) VALUES (NEW.patientID);
    
    -- Insert into `pre-natal_info`
    INSERT INTO `pre-natal_info` (patientID) VALUES (NEW.patientID);
    
    -- Insert into pregnancy_outcome
    INSERT INTO pregnancy_outcome (patientID) VALUES (NEW.patientID);
    
    -- Insert into tetanus_info
    INSERT INTO tetanus_info (patientID) VALUES (NEW.patientID);
    
    -- Insert into iodines_info
    INSERT INTO iodine_info (patientID) VALUES (NEW.patientID);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pre-natal_info`
--

CREATE TABLE `pre-natal_info` (
  `pnID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `pnLMP` date DEFAULT NULL,
  `pnGravidity` int(11) DEFAULT NULL,
  `pnParity` int(11) DEFAULT NULL,
  `pnEDC` date DEFAULT NULL,
  `pnTrimester1` date DEFAULT NULL,
  `pnTrimester2` date DEFAULT NULL,
  `pnTrimester3` date DEFAULT NULL,
  `pnTrimester4` date DEFAULT NULL,
  `isPosted` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 = posted; 0 = not posted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pre-natal_info`
--

INSERT INTO `pre-natal_info` (`pnID`, `patientID`, `pnLMP`, `pnGravidity`, `pnParity`, `pnEDC`, `pnTrimester1`, `pnTrimester2`, `pnTrimester3`, `pnTrimester4`, `isPosted`) VALUES
(29, 22, '2021-07-16', 1, 0, '2022-04-23', '2021-10-08', '2022-02-04', '2022-04-01', '2022-05-13', 0),
(30, 23, '2021-12-20', 1, NULL, '2022-09-27', NULL, NULL, NULL, NULL, 0),
(36, 29, '1012-01-17', 1, NULL, '1012-10-24', '1012-04-10', '1012-08-07', '1012-10-02', '1012-11-13', 0),
(37, 30, '2022-10-20', 1, NULL, '2023-07-27', '2023-01-09', '2023-04-05', '2023-05-21', '2023-07-25', 0),
(38, 31, '2022-09-18', 2, 1, '2023-06-25', '2022-12-11', '2023-03-22', '2023-05-25', '2023-06-01', 0),
(39, 32, '2022-02-28', 3, 4, '2022-12-05', '2022-05-23', '2022-09-19', '2022-11-14', '2022-12-26', 0),
(40, 33, '2022-11-21', 1, NULL, '2023-08-28', '2023-02-09', '2023-03-29', '2023-05-02', '2023-08-03', 0),
(41, 34, '2021-03-02', 1, NULL, '2021-12-09', '2021-05-25', '2021-09-21', '2021-11-16', '2021-12-28', 0),
(42, 35, '2023-02-10', 1, NULL, '2023-11-17', '2023-04-27', '2023-06-15', '2023-07-15', '2023-08-31', 1),
(43, 36, '2022-02-09', 1, NULL, '2022-11-16', '2022-05-04', '2022-08-31', '2022-10-26', '2022-12-07', 0),
(44, 37, '2020-01-14', 4, 3, '2020-10-21', '2020-04-07', '2020-08-04', '2020-09-29', '2020-11-10', 0),
(45, 38, '2024-02-01', NULL, NULL, '2024-11-08', '2024-04-25', '2024-08-22', '2024-10-17', '2024-11-28', 0),
(46, 39, '2024-03-15', 1, NULL, '2024-12-22', '2024-06-07', '2024-10-04', '2024-11-29', '2025-01-10', 1),
(47, 40, '2024-01-16', 2, 1, '2024-10-23', '2024-04-09', '2024-08-06', '2024-10-01', '2024-11-12', 1),
(48, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(49, 42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(50, 43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(51, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(52, 45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(53, 46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(54, 47, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(55, 48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(56, 49, '2024-01-02', 1, 0, '2024-10-09', '2024-03-26', '2024-07-23', '2024-09-17', '2024-10-29', 0),
(57, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(58, 51, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(59, 52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(60, 53, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(61, 54, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(62, 55, '2024-02-14', 1, NULL, '2024-11-21', '2024-05-08', '2024-09-04', '2024-10-30', '2024-12-11', 1),
(63, 56, '2022-04-21', 2, 1, '2023-01-28', '2022-07-14', '2022-11-10', '2023-01-05', '2023-02-16', 0),
(64, 57, '2022-09-06', 2, 1, '2023-06-13', '2022-11-29', '2023-03-28', '2023-05-23', '2023-07-04', 0),
(65, 58, '2024-02-03', 1, NULL, '2024-11-10', '2024-04-27', '2024-08-24', '2024-10-19', '2024-11-30', 0),
(66, 59, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(67, 60, '2024-02-01', 1, 0, '2024-11-08', '2024-04-25', '2024-08-22', '2024-10-17', '2024-11-28', 1),
(71, 64, '2024-12-20', NULL, NULL, '2025-09-27', '2025-03-14', '2025-07-11', '2025-09-05', '2025-10-17', 1),
(72, 65, '2025-01-16', NULL, NULL, '2025-10-23', '2025-04-10', '2025-08-07', '2025-10-02', '2025-11-13', 1),
(73, 66, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

--
-- Triggers `pre-natal_info`
--
DELIMITER $$
CREATE TRIGGER `prenatal_isPosted_update` AFTER UPDATE ON `pre-natal_info` FOR EACH ROW BEGIN
    -- Check if the isPosted value was changed to 1
    IF NEW.isPosted = 1 AND NEW.isPosted <> OLD.isPosted THEN

        -- Insert Trimester 1
        INSERT INTO `pre-natal_sched` (patientID, pnSchedTrimesterType, pnSchedCheckupDate, pnSchedStatus)
        VALUES 
            (NEW.patientID, '1st Trimester', NEW.pnTrimester1, 'Pending');

        -- Insert Trimester 2, if pnTrimester2 is NULL, calculate it as 14 weeks from pnTrimester1
        INSERT INTO `pre-natal_sched` (patientID, pnSchedTrimesterType, pnSchedCheckupDate, pnSchedStatus)
        VALUES 
            (NEW.patientID, '2nd Trimester', 
                IFNULL(NEW.pnTrimester2, DATE_ADD(NEW.pnTrimester1, INTERVAL 14 WEEK)), 'Pending');

        -- Insert Trimester 3, if pnTrimester3 is NULL, calculate it as 28 weeks from pnTrimester1
        INSERT INTO `pre-natal_sched` (patientID, pnSchedTrimesterType, pnSchedCheckupDate, pnSchedStatus)
        VALUES 
            (NEW.patientID, '3rd Trimester (1st Visit)', 
                IFNULL(NEW.pnTrimester3, DATE_ADD(NEW.pnTrimester1, INTERVAL 28 WEEK)), 'Pending');

        -- Insert Trimester 4, if pnTrimester4 is NULL, calculate it as 36 weeks from pnTrimester1
        INSERT INTO `pre-natal_sched` (patientID, pnSchedTrimesterType, pnSchedCheckupDate, pnSchedStatus)
        VALUES 
            (NEW.patientID, '3rd Trimester (2nd Visit)', 
                IFNULL(NEW.pnTrimester4, DATE_ADD(NEW.pnTrimester1, INTERVAL 36 WEEK)), 'Pending');

    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pre-natal_sched`
--

CREATE TABLE `pre-natal_sched` (
  `pnSchedID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `pnSchedTrimesterType` text NOT NULL,
  `pnSchedCheckupDate` date NOT NULL,
  `pnSchedStatus` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pre-natal_sched`
--

INSERT INTO `pre-natal_sched` (`pnSchedID`, `patientID`, `pnSchedTrimesterType`, `pnSchedCheckupDate`, `pnSchedStatus`) VALUES
(57, 55, '1st Trimester', '2024-05-08', 'Pending'),
(58, 55, '2nd Trimester', '2024-09-04', 'Pending'),
(59, 55, '3rd Trimester (1st Visit)', '2024-10-30', 'Pending'),
(60, 55, '3rd Trimester (2nd Visit)', '2024-12-11', 'Pending'),
(61, 60, '1st Trimester', '2024-04-25', 'Cancelled'),
(62, 60, '2nd Trimester', '2024-08-22', 'Pending'),
(63, 60, '3rd Trimester (1st Visit)', '2024-10-17', 'Pending'),
(64, 60, '3rd Trimester (2nd Visit)', '2024-11-28', 'Pending'),
(65, 64, '1st Trimester', '2025-01-13', 'Pending'),
(66, 64, '2nd Trimester', '2025-07-11', 'Pending'),
(67, 64, '3rd Trimester (1st Visit)', '2025-09-05', 'Pending'),
(68, 64, '3rd Trimester (2nd Visit)', '2025-10-17', 'Pending'),
(69, 65, '1st Trimester', '2025-04-10', 'Pending'),
(70, 65, '2nd Trimester', '2025-08-07', 'Pending'),
(71, 65, '3rd Trimester (1st Visit)', '2025-10-02', 'Pending'),
(72, 65, '3rd Trimester (2nd Visit)', '2025-11-13', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `pregnancy_outcome`
--

CREATE TABLE `pregnancy_outcome` (
  `poID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `poTerminatedDate` date DEFAULT NULL,
  `poOutcome` text DEFAULT NULL,
  `poBabySex` text DEFAULT NULL,
  `poBabyWeight` float DEFAULT NULL,
  `poDeliveryType` text DEFAULT NULL,
  `poPlaceType` text DEFAULT NULL,
  `poBirthAttendant` text DEFAULT NULL,
  `poDeliveryDate` date DEFAULT NULL,
  `poDeliveryTime` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pregnancy_outcome`
--

INSERT INTO `pregnancy_outcome` (`poID`, `patientID`, `poTerminatedDate`, `poOutcome`, `poBabySex`, `poBabyWeight`, `poDeliveryType`, `poPlaceType`, `poBirthAttendant`, `poDeliveryDate`, `poDeliveryTime`) VALUES
(29, 22, '2022-04-10', 'FT', 'F', 2.7, 'Vaginal Delivery', 'Hospital', 'MD', '2022-04-10', '23:52:00'),
(30, 23, '2022-10-02', 'FT', 'M', 2500, 'Cesarian Section', 'Hospital', 'RN', '2022-10-02', '06:01:00'),
(36, 29, '2022-10-15', 'FT', 'M', 2000, 'Vaginal Delivery', 'Hospital', 'MD', '2022-10-15', '23:50:00'),
(37, 30, '2023-08-06', 'FT', 'M', 26000, 'Vaginal Delivery', 'Hospital', 'MD', '2023-08-06', '22:30:00'),
(38, 31, NULL, NULL, NULL, NULL, NULL, 'Others', 'O', NULL, NULL),
(39, 32, '2022-09-01', 'FD', 'F', 2500, 'Cesarian Section', 'Hospital', 'MD', '2022-09-01', '20:50:00'),
(40, 33, '2023-08-09', 'FD', 'F', 2500, 'Cesarian Section', 'Hospital', 'MD', '2023-08-09', '09:10:00'),
(41, 34, '2021-05-12', 'PT', 'M', 2.8, 'Vaginal Delivery', 'Hospital', 'MW', '2021-05-12', '14:15:00'),
(42, 35, '2023-09-06', 'FT', 'F', 2.3, 'Vaginal Delivery', 'Hospital', 'MD', '2023-09-06', '07:21:00'),
(43, 36, '2022-11-10', 'PT', 'F', 2000, 'Cesarian Section', 'Hospital', 'MD', '2022-11-10', '21:14:00'),
(44, 37, NULL, NULL, NULL, NULL, NULL, 'Others', 'O', NULL, NULL),
(45, 38, '2024-11-07', 'FT', 'F', 2.6, 'Vaginal Delivery', 'Hospital', 'MD', '2024-11-12', NULL),
(46, 39, '2024-12-12', 'FT', 'F', 2700, 'Cesarian Section', 'Hospital', 'MD', '2024-12-12', '21:19:00'),
(47, 40, '2024-10-23', 'FT', 'M', 2400, 'Vaginal Delivery', 'BHS', 'MW', '2024-10-23', '14:24:00'),
(48, 41, '2024-08-14', 'FT', 'F', 3000, 'Cesarian Section', 'Lying-in', 'RN', '2024-08-14', '15:25:00'),
(49, 42, '2024-11-14', 'FT', 'F', 2400, 'Vaginal Delivery', 'RHUMIHC', 'RN', '2024-11-14', NULL),
(50, 43, NULL, 'PT', NULL, 2000, 'Cesarian Section', 'Birthing Homes', 'Person in charge', NULL, NULL),
(51, 44, '2024-11-14', 'FT', 'M', NULL, 'Vaginal Delivery', 'Lying-in', 'MW', '2024-11-14', NULL),
(52, 45, '2024-11-14', 'FT', 'M', 2.3, 'Cesarian Section', 'Hospital', 'RN', '2024-11-14', NULL),
(53, 46, NULL, 'FD', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 47, '2024-11-14', 'PT', 'F', 2.3, 'Vaginal Delivery', 'DOH Licensed Ambulance', 'MW', '2024-11-14', NULL),
(55, 48, '2024-11-14', 'PT', 'F', NULL, 'Vaginal Delivery', 'house', 'MW', '2024-11-14', NULL),
(56, 49, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 51, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 53, '2024-11-15', 'FT', 'M', 2.3, 'Vaginal Delivery', 'BHS', 'MW', '2024-11-15', NULL),
(61, 54, '2024-11-15', 'PT', 'F', 2.1, 'Vaginal Delivery', 'BHS', 'MW', '2024-11-15', NULL),
(62, 55, NULL, NULL, NULL, NULL, NULL, 'Others', 'O', NULL, NULL),
(63, 56, '2023-01-22', 'FT', 'M', 2.9, 'Vaginal Delivery', 'Hospital', 'MD', '2023-01-22', '21:20:00'),
(64, 57, '2023-06-14', 'FT', 'M', 3.3, 'Vaginal Delivery', 'Hospital', 'MD', '2023-06-14', '03:00:00'),
(65, 58, NULL, 'PT', 'M', 2.5, 'Cesarian Section', 'Hospital', 'MD', '2024-11-10', NULL),
(66, 59, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 60, '2024-11-09', 'FT', 'F', 2.6, 'Vaginal Delivery', 'Lying-in', 'MW', '2024-11-09', '16:52:00'),
(71, 64, NULL, NULL, NULL, NULL, NULL, 'Others', 'O', NULL, NULL),
(72, 65, NULL, NULL, NULL, NULL, NULL, 'Others', 'O', NULL, NULL),
(73, 66, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rhu_inventory_history`
--

CREATE TABLE `rhu_inventory_history` (
  `id` int(11) NOT NULL,
  `medicine_id` int(11) DEFAULT NULL,
  `station_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `category` enum('added','distributed') NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `station`
--

CREATE TABLE `station` (
  `stationID` int(11) NOT NULL,
  `stationName` text NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1 COMMENT '1 = active; 0 = inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `station`
--

INSERT INTO `station` (`stationID`, `stationName`, `isActive`) VALUES
(15, 'PARARA', 1),
(16, 'NAPNAPAN', 1),
(17, 'NAMOCON', 1),
(18, 'MAIN HEALTH CENTER II', 1),
(19, 'MAIN HEALTH CENTER I', 1),
(20, 'DORONG-AN', 1),
(21, 'DAPDAP', 1),
(22, 'CORDOVA', 1),
(23, 'BUYU-AN', 1),
(24, 'BINALIUAN', 1),
(25, 'BAROSONG', 1),
(26, 'BANGKAL', 1),
(27, 'BAGACAY', 1),
(28, 'ATABAYAN', 1),
(30, 'MHIS', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tetanus_info`
--

CREATE TABLE `tetanus_info` (
  `ttID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `tt1` date DEFAULT NULL,
  `tt2` date DEFAULT NULL,
  `tt3` date DEFAULT NULL,
  `tt4` date DEFAULT NULL,
  `tt5` date DEFAULT NULL,
  `ttFIM` tinyint(4) DEFAULT NULL COMMENT '1 = check; 0 = not checked',
  `isPosted` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 = posted; 0 = not posted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tetanus_info`
--

INSERT INTO `tetanus_info` (`ttID`, `patientID`, `tt1`, `tt2`, `tt3`, `tt4`, `tt5`, `ttFIM`, `isPosted`) VALUES
(29, 22, '2022-02-02', '2022-02-02', NULL, NULL, NULL, 1, 1),
(30, 23, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(36, 29, '2022-03-16', '2022-07-06', NULL, NULL, NULL, NULL, 0),
(37, 30, '2022-02-15', '2023-03-31', NULL, NULL, NULL, NULL, 0),
(38, 31, NULL, NULL, '2023-11-16', '2022-04-26', NULL, NULL, 0),
(39, 32, '2022-04-25', '2022-07-06', '2022-08-17', NULL, NULL, NULL, 0),
(40, 33, NULL, NULL, NULL, '2023-03-29', NULL, 1, 0),
(41, 34, '2021-01-07', '2021-03-04', '2021-11-04', '2022-04-16', NULL, NULL, 0),
(42, 35, '2023-06-11', '2023-07-15', NULL, NULL, NULL, 1, 0),
(43, 36, '2022-04-09', '2022-01-01', NULL, NULL, NULL, NULL, 0),
(44, 37, NULL, NULL, NULL, NULL, '2021-04-08', NULL, 0),
(45, 38, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(46, 39, '2024-11-14', '2024-11-14', NULL, NULL, NULL, NULL, 0),
(47, 40, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(48, 41, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(49, 42, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(50, 43, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(51, 44, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(52, 45, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(53, 46, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(54, 47, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(55, 48, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(56, 49, '2024-03-26', '2024-07-23', '0000-00-00', '2024-09-30', '2024-10-29', NULL, 0),
(57, 50, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(58, 51, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(59, 52, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(60, 53, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(61, 54, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(62, 55, '2024-11-17', '2024-11-18', NULL, NULL, NULL, NULL, 1),
(63, 56, NULL, NULL, NULL, '2022-10-08', NULL, NULL, 0),
(64, 57, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(65, 58, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(66, 59, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(67, 60, '2024-11-16', '2024-11-17', NULL, NULL, NULL, NULL, 0),
(71, 64, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(72, 65, '2025-01-10', '2025-01-17', '2025-01-24', '2025-01-31', '2025-02-07', NULL, 1),
(73, 66, NULL, NULL, NULL, NULL, NULL, NULL, 0);

--
-- Triggers `tetanus_info`
--
DELIMITER $$
CREATE TRIGGER `tetanus_isPosted_update` AFTER UPDATE ON `tetanus_info` FOR EACH ROW BEGIN
    IF NEW.isPosted = 1 AND NEW.isPosted <> OLD.isPosted THEN
        -- Insert for tt1 (Td1/TT1)
        IF NEW.tt1 IS NOT NULL THEN
            INSERT INTO tetanus_sched (patientID, ttSchedType, ttSchedDate, ttSchedStatus)
            VALUES (NEW.patientID, 'Td1/TT1', NEW.tt1, 'Pending');
        END IF;

        -- Insert for tt2 (Td2/TT2)
        IF NEW.tt2 IS NOT NULL THEN
            INSERT INTO tetanus_sched (patientID, ttSchedType, ttSchedDate, ttSchedStatus)
            VALUES (NEW.patientID, 'Td2/TT2', NEW.tt2, 'Pending');
        END IF;

        -- Insert for tt3 (Td3/TT3)
        IF NEW.tt3 IS NOT NULL THEN
            INSERT INTO tetanus_sched (patientID, ttSchedType, ttSchedDate, ttSchedStatus)
            VALUES (NEW.patientID, 'Td3/TT3', NEW.tt3, 'Pending');
        END IF;

        -- Insert for tt4 (Td4/TT4)
        IF NEW.tt4 IS NOT NULL THEN
            INSERT INTO tetanus_sched (patientID, ttSchedType, ttSchedDate, ttSchedStatus)
            VALUES (NEW.patientID, 'Td4/TT4', NEW.tt4, 'Pending');
        END IF;

        -- Insert for tt5 (Td5/TT5)
        IF NEW.tt5 IS NOT NULL THEN
            INSERT INTO tetanus_sched (patientID, ttSchedType, ttSchedDate, ttSchedStatus)
            VALUES (NEW.patientID, 'Td5/TT5', NEW.tt5, 'Pending');
        END IF;

        -- Insert for ttFIM
        IF NEW.ttFIM IS NOT NULL THEN
            INSERT INTO tetanus_sched (patientID, ttSchedType, ttSchedDate, ttSchedStatus)
            VALUES (NEW.patientID, 'Td/FIM', NEW.ttFIM, 'Pending');
        END IF;

    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tetanus_sched`
--

CREATE TABLE `tetanus_sched` (
  `ttSchedID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `ttSchedType` text NOT NULL,
  `ttSchedDate` date NOT NULL,
  `ttSchedStatus` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tetanus_sched`
--

INSERT INTO `tetanus_sched` (`ttSchedID`, `patientID`, `ttSchedType`, `ttSchedDate`, `ttSchedStatus`) VALUES
(12, 55, 'Td1/TT1', '2024-11-17', 'Pending'),
(13, 55, 'Td2/TT2', '2024-11-18', 'Pending'),
(14, 65, 'Td1/TT1', '2025-01-10', 'Pending'),
(15, 65, 'Td2/TT2', '2025-01-17', 'Pending'),
(16, 65, 'Td3/TT3', '2025-01-24', 'Pending'),
(17, 65, 'Td4/TT4', '2025-01-31', 'Pending'),
(18, 65, 'Td5/TT5', '2025-02-07', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `stationID` int(11) DEFAULT NULL,
  `userFname` text NOT NULL,
  `userLname` text NOT NULL,
  `userUname` text NOT NULL,
  `userPassword` text NOT NULL,
  `userContactNumber` varchar(20) NOT NULL,
  `userType` text NOT NULL,
  `isActive` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = active; 0 = inactive	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `stationID`, `userFname`, `userLname`, `userUname`, `userPassword`, `userContactNumber`, `userType`, `isActive`) VALUES
(1, NULL, 'Jane', 'Doe', 'rhu_admin', 'rhu_admin', '09123456789', 'RHU', 1),
(2, 19, 'MARYCAR', 'TORRENTO', 'bhs_torrento', 'bhs_torrento', '09123456789', 'BHS', 1),
(3, 18, 'MARY ANN', 'SEARES', 'bhs_seares', 'bhs_seares', '09123456789', 'BHS', 1),
(4, 23, 'MIA MAE', 'JIMENEZ', 'bhs_jimenez', 'bhs_jimenez', '09123456789', 'BHS', 1),
(6, 15, 'JELYN', 'GARAY', 'bhs_garay', 'bhs_garay', '09123456789', 'BHS', 1),
(7, 27, 'CHERRY JOY', 'COLUMNA', 'bhs_columna', 'bhs_columna', '09123456789', 'BHS', 1),
(8, 20, 'JEDABELLE', 'PILLO', 'bhs_pillo', 'bhs_pillo', '09123456789', 'BHS', 1),
(9, 24, 'MARY JOY', 'TUHAO', 'bhs_tuhao', 'bhs_tuhao', '09123456789', 'BHS', 1),
(10, 16, 'LORNA', 'TIRASOL', 'bhs_tirasol', 'bhs_tirasol', '09123456789', 'BHS', 1),
(11, 25, 'ANA BELLE', 'NARIDO', 'bhs_narido', 'bhs_narido', '09123456789', 'BHS', 1),
(12, 26, 'MERCELITA', 'TAROK', 'bhs_tarok', 'bhs_tarok', '09123456789', 'BHS', 1),
(13, 22, 'FELINA', 'ESCAROLA', 'bhs_escarola', 'bhs_escarola', '09123456789', 'BHS', 1),
(14, 17, 'ANABELLE', 'TORRARO', 'bhs_torraro', 'bhs_torraro', '09123456789', 'BHS', 1),
(15, 21, 'MENCHIE', 'TABORETE', 'bhs_taborete', 'bhs_taborete', '09123456789', 'BHS', 1),
(16, 28, 'NIDA', 'AMATORIO', 'bhs_amatorio', 'bhs_amatorio', '091234567890', 'BHS', 1),
(17, 30, 'JANINE', 'DIAZ', 'janine', '123', '', 'BHS', 1),
(18, 19, 'EMILY', 'NALUIS', 'naluis', '123', '', 'BHS', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangay`
--
ALTER TABLE `barangay`
  ADD PRIMARY KEY (`barangayID`),
  ADD KEY `barangay_fk1` (`stationID`);

--
-- Indexes for table `calcium_info`
--
ALTER TABLE `calcium_info`
  ADD PRIMARY KEY (`calID`),
  ADD KEY `cal_info_fk1` (`patientID`);

--
-- Indexes for table `calcium_sched`
--
ALTER TABLE `calcium_sched`
  ADD PRIMARY KEY (`calSchedID`),
  ADD KEY `cal_sched_fk1` (`patientID`);

--
-- Indexes for table `deworming_info`
--
ALTER TABLE `deworming_info`
  ADD PRIMARY KEY (`dwID`),
  ADD KEY `dw_info_fk1` (`patientID`);

--
-- Indexes for table `deworming_sched`
--
ALTER TABLE `deworming_sched`
  ADD PRIMARY KEY (`dwSchedID`),
  ADD KEY `dw_sched_fk1` (`patientID`);

--
-- Indexes for table `infectious`
--
ALTER TABLE `infectious`
  ADD PRIMARY KEY (`infectiousID`),
  ADD KEY `inf_fk1` (`patientID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventoryID`),
  ADD KEY `inventory_fk1` (`medicineID`),
  ADD KEY `inventory_fk2` (`stationID`);

--
-- Indexes for table `inventory_history`
--
ALTER TABLE `inventory_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `iodine_info`
--
ALTER TABLE `iodine_info`
  ADD PRIMARY KEY (`iodID`),
  ADD KEY `iodine_fk1` (`patientID`);

--
-- Indexes for table `iodine_sched`
--
ALTER TABLE `iodine_sched`
  ADD PRIMARY KEY (`iodSchedID`);

--
-- Indexes for table `laboratory`
--
ALTER TABLE `laboratory`
  ADD PRIMARY KEY (`labID`),
  ADD KEY `lab_fk1` (`patientID`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`medicineID`);

--
-- Indexes for table `micronutrient_info`
--
ALTER TABLE `micronutrient_info`
  ADD PRIMARY KEY (`ironID`),
  ADD KEY `mic_info_fk1` (`patientID`);

--
-- Indexes for table `micronutrient_sched`
--
ALTER TABLE `micronutrient_sched`
  ADD PRIMARY KEY (`ironSchedID`),
  ADD KEY `mic_sched_fk1` (`patientID`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patientID`),
  ADD KEY `patient_fk1` (`barangayID`);

--
-- Indexes for table `pre-natal_info`
--
ALTER TABLE `pre-natal_info`
  ADD PRIMARY KEY (`pnID`),
  ADD KEY `pn_info_fk1` (`patientID`);

--
-- Indexes for table `pre-natal_sched`
--
ALTER TABLE `pre-natal_sched`
  ADD PRIMARY KEY (`pnSchedID`),
  ADD KEY `pn_sched_fk1` (`patientID`);

--
-- Indexes for table `pregnancy_outcome`
--
ALTER TABLE `pregnancy_outcome`
  ADD PRIMARY KEY (`poID`),
  ADD KEY `po_fk1` (`patientID`);

--
-- Indexes for table `rhu_inventory_history`
--
ALTER TABLE `rhu_inventory_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `station_id` (`station_id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- Indexes for table `station`
--
ALTER TABLE `station`
  ADD PRIMARY KEY (`stationID`);

--
-- Indexes for table `tetanus_info`
--
ALTER TABLE `tetanus_info`
  ADD PRIMARY KEY (`ttID`),
  ADD KEY `tt_info_fk1` (`patientID`);

--
-- Indexes for table `tetanus_sched`
--
ALTER TABLE `tetanus_sched`
  ADD PRIMARY KEY (`ttSchedID`),
  ADD KEY `tt_sched_fk1` (`patientID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `user_fk1` (`stationID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `barangayID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `calcium_info`
--
ALTER TABLE `calcium_info`
  MODIFY `calID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `calcium_sched`
--
ALTER TABLE `calcium_sched`
  MODIFY `calSchedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `deworming_info`
--
ALTER TABLE `deworming_info`
  MODIFY `dwID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `deworming_sched`
--
ALTER TABLE `deworming_sched`
  MODIFY `dwSchedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `infectious`
--
ALTER TABLE `infectious`
  MODIFY `infectiousID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `inventory_history`
--
ALTER TABLE `inventory_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `iodine_info`
--
ALTER TABLE `iodine_info`
  MODIFY `iodID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `iodine_sched`
--
ALTER TABLE `iodine_sched`
  MODIFY `iodSchedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `laboratory`
--
ALTER TABLE `laboratory`
  MODIFY `labID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `medicineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `micronutrient_info`
--
ALTER TABLE `micronutrient_info`
  MODIFY `ironID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `micronutrient_sched`
--
ALTER TABLE `micronutrient_sched`
  MODIFY `ironSchedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `pre-natal_info`
--
ALTER TABLE `pre-natal_info`
  MODIFY `pnID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `pre-natal_sched`
--
ALTER TABLE `pre-natal_sched`
  MODIFY `pnSchedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `pregnancy_outcome`
--
ALTER TABLE `pregnancy_outcome`
  MODIFY `poID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `rhu_inventory_history`
--
ALTER TABLE `rhu_inventory_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `station`
--
ALTER TABLE `station`
  MODIFY `stationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tetanus_info`
--
ALTER TABLE `tetanus_info`
  MODIFY `ttID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tetanus_sched`
--
ALTER TABLE `tetanus_sched`
  MODIFY `ttSchedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barangay`
--
ALTER TABLE `barangay`
  ADD CONSTRAINT `barangay_fk1` FOREIGN KEY (`stationID`) REFERENCES `station` (`stationID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `calcium_info`
--
ALTER TABLE `calcium_info`
  ADD CONSTRAINT `cal_info_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `calcium_sched`
--
ALTER TABLE `calcium_sched`
  ADD CONSTRAINT `cal_sched_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `deworming_info`
--
ALTER TABLE `deworming_info`
  ADD CONSTRAINT `dw_info_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `deworming_sched`
--
ALTER TABLE `deworming_sched`
  ADD CONSTRAINT `dw_sched_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `infectious`
--
ALTER TABLE `infectious`
  ADD CONSTRAINT `inf_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_fk1` FOREIGN KEY (`medicineID`) REFERENCES `medicine` (`medicineID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_fk2` FOREIGN KEY (`stationID`) REFERENCES `station` (`stationID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `iodine_info`
--
ALTER TABLE `iodine_info`
  ADD CONSTRAINT `iodine_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `laboratory`
--
ALTER TABLE `laboratory`
  ADD CONSTRAINT `lab_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `micronutrient_info`
--
ALTER TABLE `micronutrient_info`
  ADD CONSTRAINT `mic_info_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `micronutrient_sched`
--
ALTER TABLE `micronutrient_sched`
  ADD CONSTRAINT `mic_sched_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`barangayID`) REFERENCES `barangay` (`barangayID`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `pre-natal_info`
--
ALTER TABLE `pre-natal_info`
  ADD CONSTRAINT `pn_info_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pre-natal_sched`
--
ALTER TABLE `pre-natal_sched`
  ADD CONSTRAINT `pn_sched_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pregnancy_outcome`
--
ALTER TABLE `pregnancy_outcome`
  ADD CONSTRAINT `po_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rhu_inventory_history`
--
ALTER TABLE `rhu_inventory_history`
  ADD CONSTRAINT `rhu_inventory_history_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `station` (`stationID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `rhu_inventory_history_ibfk_2` FOREIGN KEY (`medicine_id`) REFERENCES `medicine` (`medicineID`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `tetanus_info`
--
ALTER TABLE `tetanus_info`
  ADD CONSTRAINT `tt_info_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tetanus_sched`
--
ALTER TABLE `tetanus_sched`
  ADD CONSTRAINT `tt_sched_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_fk1` FOREIGN KEY (`stationID`) REFERENCES `station` (`stationID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
