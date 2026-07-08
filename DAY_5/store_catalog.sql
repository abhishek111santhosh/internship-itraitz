-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2026 at 08:16 AM
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
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `store_catalog`
--

CREATE TABLE `store_catalog` (
  `item_id` int(11) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `marketing_copy` text NOT NULL,
  `unit_price` decimal(8,2) NOT NULL,
  `item_condition` enum('new','refurbished','clearance') NOT NULL,
  `is_digital_download` tinyint(1) NOT NULL,
  `official_launch_date` date NOT NULL,
  `last_edited_timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store_catalog`
--

INSERT INTO `store_catalog` (`item_id`, `product_name`, `marketing_copy`, `unit_price`, `item_condition`, `is_digital_download`, `official_launch_date`, `last_edited_timestamp`) VALUES
(1, 'Pro Video Editing Suite 2026', 'The ultimate software for creators. Includes all standard plugins.', 12500.50, 'new', 1, '2026-08-15', '2026-07-08 10:15:00'),
(2, 'Wireless Noise-Cancelling Headphones', 'Factory restored and tested. Minor cosmetic scratches may be present.', 4999.00, 'refurbished', 0, '2025-11-20', '2026-07-07 16:45:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `store_catalog`
--
ALTER TABLE `store_catalog`
  ADD PRIMARY KEY (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `store_catalog`
--
ALTER TABLE `store_catalog`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
