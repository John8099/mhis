-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2024 at 07:03 PM
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
(54, 15, 'PARARA SUR', 1);

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
  `iodNum` int(11) DEFAULT NULL,
  `iodDate` date DEFAULT NULL,
  `nutritionalAssessment` tinyint(4) DEFAULT NULL COMMENT '1 = low; 2 = medium; 3 = high',
  `isPosted` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 = posted; 0 = not posted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calcium_info`
--

INSERT INTO `calcium_info` (`calID`, `patientID`, `calNum1`, `calDate1`, `calNum2`, `calDate2`, `calNum3`, `calDate3`, `iodNum`, `iodDate`, `nutritionalAssessment`, `isPosted`) VALUES
(1, 5, NULL, NULL, NULL, '2024-10-10', 30, '2024-10-17', 20, '2024-10-31', 2, 0),
(2, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(3, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(4, 10, 30, '2024-10-22', NULL, '2024-10-30', NULL, '2024-10-30', NULL, '2024-11-06', 2, 0),
(5, 11, 0, '0000-00-00', 0, '0000-00-00', 0, '0000-00-00', 0, '0000-00-00', 0, 0),
(6, 12, 30, '2025-01-21', 30, '2025-04-22', 30, '2025-06-03', 20, '2024-10-29', 2, 1),
(7, 13, 30, '2024-10-16', 30, '2024-10-29', 30, '2024-10-24', 30, '2024-10-31', 2, 1);

--
-- Triggers `calcium_info`
--
DELIMITER $$
CREATE TRIGGER `calcium_isPosted_update` AFTER UPDATE ON `calcium_info` FOR EACH ROW BEGIN
    IF NEW.isPosted = 1 AND NEW.isPosted <> OLD.isPosted THEN
        IF NEW.iodDate IS NOT NULL THEN
            INSERT INTO calcium_sched (patientID, calSchedTrimesterType, calSchedTablets, calSchedDate, calSchedStatus)
            VALUES (NEW.patientID, '1st Trimester', NEW.iodNum, NEW.iodDate, 'Pending');
        END IF;

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
(13, 12, '1st Trimester', 20, '2024-10-29', 'Pending'),
(14, 12, '2nd Trimester', 30, '2025-01-21', 'Pending'),
(15, 12, '3rd Trimester', 30, '2025-04-22', 'Pending'),
(16, 12, '4th Trimester', 30, '2025-06-03', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `deworming_info`
--

CREATE TABLE `deworming_info` (
  `dwID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `dwDate` date DEFAULT NULL,
  `isPosted` tinyint(4) NOT NULL COMMENT '1 = posted; 0 = not posted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deworming_info`
--

INSERT INTO `deworming_info` (`dwID`, `patientID`, `dwDate`, `isPosted`) VALUES
(1, 5, '2024-10-10', 0),
(2, 8, '0000-00-00', 0),
(3, 9, '0000-00-00', 0),
(4, 10, '2024-11-08', 0),
(5, 11, '0000-00-00', 0),
(6, 12, NULL, 0),
(7, 13, '2024-10-30', 0);

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
  `dwSchedStatus` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 5, '2024-10-24', 1, '2024-10-22', 0, '2024-10-29'),
(2, 8, '0000-00-00', 0, '0000-00-00', 0, '0000-00-00'),
(3, 9, '0000-00-00', 0, '0000-00-00', 0, '0000-00-00'),
(4, 10, '2024-11-01', 1, '2024-10-31', 1, '2024-11-01'),
(5, 11, '0000-00-00', 0, '0000-00-00', 0, '0000-00-00'),
(6, 12, '2024-10-31', NULL, '2024-10-22', NULL, '2024-11-06'),
(7, 13, '2024-11-01', 1, '2024-10-30', 1, '2024-10-29');

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
(2, 19, 2, 15, '2024-10-29');

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
(1, 5, '2024-10-17', 1, '2024-10-23', 1, 12),
(2, 8, '0000-00-00', 0, '0000-00-00', 0, 0),
(3, 9, '0000-00-00', 0, '0000-00-00', 0, 0),
(4, 10, '2024-11-21', 1, '2024-11-14', 1, 12),
(5, 11, '0000-00-00', 0, '0000-00-00', 0, 0),
(6, 12, '2024-10-24', NULL, '2024-10-31', NULL, 20),
(7, 13, '2024-10-23', 1, '2024-11-01', 1, 12);

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
(1, 'Iron Med Name', 'iron', 100, '2024-10-16'),
(2, 'Calcium Med Name', 'calcium', 85, '2024-10-29'),
(3, 'Iodine Med Name', 'iodine', 50, '2024-10-29'),
(4, 'Deworming Med Name', 'deworming', 20, '2024-10-21');

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
(1, 5, 30, '2024-10-10', 30, '2024-10-17', 30, '2024-11-05', 30, '2024-10-31', 0),
(2, 8, 0, '0000-00-00', 0, '0000-00-00', 0, '0000-00-00', 0, '0000-00-00', 0),
(3, 9, 0, '0000-00-00', 0, '0000-00-00', 0, '0000-00-00', 0, '0000-00-00', 0),
(4, 10, 30, '2024-10-22', 30, '2024-10-30', 60, '2024-10-31', 30, '2024-11-07', 0),
(5, 11, 0, '0000-00-00', 0, '0000-00-00', 0, '0000-00-00', 0, '0000-00-00', 0),
(6, 12, 30, '2024-10-29', 30, '2025-01-21', 60, '2025-04-22', 30, '2025-06-03', 0),
(7, 13, 30, '2024-10-24', 30, '2024-10-23', 30, '2024-10-22', 30, '2024-10-23', 0);

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

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patientID` int(11) NOT NULL,
  `barangayID` int(11) NOT NULL,
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
  `patientContactNumber` varchar(20) NOT NULL,
  `patientEmergencyContact` varchar(20) NOT NULL,
  `patientNHTS` tinyint(4) NOT NULL COMMENT '1 = yes; 0 = no',
  `isActive` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = active; 0 = inactive	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patientID`, `barangayID`, `patientSerialNumber`, `registrationDate`, `patientFname`, `patientMname`, `patientLname`, `patientBirthday`, `patientAge`, `patientWeight`, `patientHeight`, `patientBMI`, `patientBMICategory`, `patientBloodType`, `patientContactNumber`, `patientEmergencyContact`, `patientNHTS`, `isActive`) VALUES
(5, 35, '123456789123', '2024-09-11', 'Froizel Rej', 'Duletin', 'Apolonio', '2001-09-28', 23, 64, 1.65, 23.51, 'Normal', 'AB+', '09271855232', '09217376482', 1, 1),
(8, 36, '987654321', '2024-10-07', 'Albedo', 'Lawrence', 'Santos', '1992-05-07', 32, 56, 1.6, 21.87, 'Normal', 'A+', '12312312', '12312312', 1, 1),
(9, 38, '47853948', '2024-10-09', 'test', 'test', 'test', '1986-06-12', 38, 69, 1.7, 23.88, 'Normal', 'O-', '123123', '12312312', 1, 1),
(10, 39, '12345678987654321', '2024-10-10', 'Test First Name', 'Test MiddleName', 'Test Last Name', '1986-07-17', 38, 67, 1.7, 23.18, 'Normal', 'O-', '123123123', '123123123', 1, 1),
(11, 35, '12321312', '2024-10-26', 'Test123', 'Test123', 'Test123', '1986-06-20', 38, 60, 1.6, 23.44, 'Normal', 'O-', '12312321', '12312321321', 1, 1),
(12, 37, '45687456', '2024-10-27', 'Test123123123', 'Test123123123', 'Test123123123', '1994-06-23', 30, 50, 1.5, 22.22, 'Normal', '', '12312313213', '12312312312', 1, 1),
(13, 36, '68574864', '2024-10-27', 'Andrie', 'Marc', 'Test', '1997-11-22', 26, 65, 1.7, 22.49, 'Normal', 'A-', '234234', '23432432', 1, 1);

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
(1, 5, '2024-10-10', 12, 24, '2025-07-17', '2024-10-26', '2025-01-18', '2025-04-19', '2025-05-31', 1),
(2, 8, '0000-00-00', 0, 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0),
(3, 9, '0000-00-00', 12, 23, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0),
(4, 10, '2024-10-17', 0, 25, '2025-07-24', NULL, NULL, NULL, NULL, 1),
(5, 11, '0000-00-00', 0, 0, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0),
(6, 12, '2024-10-14', 20, 20, '2025-07-21', '2024-10-29', '2025-01-21', '2025-04-22', '2025-06-03', 0),
(7, 13, '2024-10-10', 20, 20, '2025-07-17', '2024-10-29', '2025-01-21', '2025-04-22', '2025-06-03', 0);

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
  `poBabyWeight` decimal(10,0) DEFAULT NULL,
  `poDeliveryType` text DEFAULT NULL,
  `poPlaceType` text DEFAULT NULL,
  `poBEmONCCEmONC` tinyint(4) DEFAULT NULL COMMENT '1 = check; 0 = unchecked',
  `poBirthAttendant` text DEFAULT NULL,
  `poDeliveryDate` date DEFAULT NULL,
  `poDeliveryTime` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pregnancy_outcome`
--

INSERT INTO `pregnancy_outcome` (`poID`, `patientID`, `poTerminatedDate`, `poOutcome`, `poBabySex`, `poBabyWeight`, `poDeliveryType`, `poPlaceType`, `poBEmONCCEmONC`, `poBirthAttendant`, `poDeliveryDate`, `poDeliveryTime`) VALUES
(1, 5, '2024-10-23', 'FT', 'M', 20, 'Vaginal Delivery', 'Birthing Homes', 1, 'RN', '2024-10-23', '04:05:00'),
(2, 8, '0000-00-00', '', 'F', 2, '', '', 0, '', '0000-00-00', '00:00:00'),
(3, 9, '0000-00-00', '', 'M', 0, '', '', 0, '', '0000-00-00', '00:00:00'),
(4, 10, '2024-10-31', 'PT', 'F', 6, 'Vaginal Delivery', 'Lying-in', 1, 'RN', '2024-10-31', '16:28:00'),
(5, 11, '0000-00-00', '', 'M', 0, '', '', 0, '', '0000-00-00', '00:00:00'),
(6, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01:00:00'),
(7, 13, '2024-10-30', 'FT', 'F', 5, 'Vaginal Delivery', 'BHS', 1, 'MD', '2024-10-23', '20:25:00');

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
(29, 'BARROC', 1);

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
(1, 5, '2024-10-10', '2024-10-24', '2024-11-02', '2024-10-28', '2024-10-29', 1, 1),
(2, 8, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, 0),
(3, 9, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, 0),
(4, 10, '2024-10-29', '2024-10-31', '2024-11-01', '2024-10-26', '2024-11-29', NULL, 0),
(5, 11, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, 0),
(6, 12, '2024-10-23', '2024-10-30', '2024-10-31', '2024-11-01', '2024-11-02', 1, 0),
(7, 13, '2024-10-29', '2024-10-23', '2024-10-15', '2024-10-23', '2024-10-22', 1, 0);

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
(5, 29, 'NIDA', 'AMATORIO', 'bhs_amatorio', 'bhs_amatorio', '09123456789', 'BHS', 1),
(6, 15, 'JELYN', 'GARAY', 'bhs_garay', 'bhs_garay', '09123456789', 'BHS', 1),
(7, 27, 'CHERRY JOY', 'COLUMNA', 'bhs_columna', 'bhs_columna', '09123456789', 'BHS', 1),
(8, 20, 'JEDABELLE', 'PILLO', 'bhs_pillo', 'bhs_pillo', '09123456789', 'BHS', 1),
(9, 24, 'MARY JOY', 'TUHAO', 'bhs_tuhao', 'bhs_tuhao', '09123456789', 'BHS', 1),
(10, 16, 'LORNA', 'TIRASOL', 'bhs_tirasol', 'bhs_tirasol', '09123456789', 'BHS', 1),
(11, 25, 'ANA BELLE', 'NARIDO', 'bhs_narido', 'bhs_narido', '09123456789', 'BHS', 1),
(12, 26, 'MERCELITA', 'TAROK', 'bhs_tarok', 'bhs_tarok', '09123456789', 'BHS', 1),
(13, 22, 'FELINA', 'ESCAROLA', 'bhs_escarola', 'bhs_escarola', '09123456789', 'BHS', 1),
(14, 17, 'ANABELLE', 'TORRARO', 'bhs_torraro', 'bhs_torraro', '09123456789', 'BHS', 1),
(15, 21, 'MENCHIE', 'TABORETE', 'bhs_taborete', 'bhs_taborete', '09123456789', 'BHS', 1);

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
  MODIFY `barangayID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `calcium_info`
--
ALTER TABLE `calcium_info`
  MODIFY `calID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `calcium_sched`
--
ALTER TABLE `calcium_sched`
  MODIFY `calSchedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `deworming_info`
--
ALTER TABLE `deworming_info`
  MODIFY `dwID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `deworming_sched`
--
ALTER TABLE `deworming_sched`
  MODIFY `dwSchedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `infectious`
--
ALTER TABLE `infectious`
  MODIFY `infectiousID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `laboratory`
--
ALTER TABLE `laboratory`
  MODIFY `labID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `medicineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `micronutrient_info`
--
ALTER TABLE `micronutrient_info`
  MODIFY `ironID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `micronutrient_sched`
--
ALTER TABLE `micronutrient_sched`
  MODIFY `ironSchedID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pre-natal_info`
--
ALTER TABLE `pre-natal_info`
  MODIFY `pnID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pre-natal_sched`
--
ALTER TABLE `pre-natal_sched`
  MODIFY `pnSchedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `pregnancy_outcome`
--
ALTER TABLE `pregnancy_outcome`
  MODIFY `poID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `station`
--
ALTER TABLE `station`
  MODIFY `stationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tetanus_info`
--
ALTER TABLE `tetanus_info`
  MODIFY `ttID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tetanus_sched`
--
ALTER TABLE `tetanus_sched`
  MODIFY `ttSchedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  ADD CONSTRAINT `patient_fk1` FOREIGN KEY (`barangayID`) REFERENCES `barangay` (`barangayID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
