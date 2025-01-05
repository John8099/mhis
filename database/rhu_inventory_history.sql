-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2025 at 06:22 PM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rhu_inventory_history`
--
ALTER TABLE `rhu_inventory_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `station_id` (`station_id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rhu_inventory_history`
--
ALTER TABLE `rhu_inventory_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rhu_inventory_history`
--
ALTER TABLE `rhu_inventory_history`
  ADD CONSTRAINT `rhu_inventory_history_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `station` (`stationID`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `rhu_inventory_history_ibfk_2` FOREIGN KEY (`medicine_id`) REFERENCES `medicine` (`medicineID`) ON DELETE SET NULL ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
