-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2024 at 05:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(50) UNSIGNED NOT NULL,
  `cat_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`) VALUES
(1, 'Apple'),
(2, 'Orange'),
(3, 'Kiwi'),
(4, 'Grapes'),
(5, 'Cherry'),
(8, 'Dragonfruits');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` int(50) UNSIGNED NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `brand_name` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `size` int(50) NOT NULL,
  `order_quantity` int(50) NOT NULL,
  `price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `product_name`, `brand_name`, `category`, `size`, `order_quantity`, `price`) VALUES
(1, 'Fuji', '5 Stars', 'Apple', 15, 50, 1500),
(2, 'Singapore Red Pineapple', 'Hotdog', 'Cherry', 35, 50, 1600),
(3, 'Yang Tao', '5 Stars', 'Orange', 45, 50, 5000);

-- --------------------------------------------------------

--
-- Table structure for table `manage_user`
--

CREATE TABLE `manage_user` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `User_role` varchar(255) NOT NULL,
  `Created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manage_user`
--

INSERT INTO `manage_user` (`Id`, `Name`, `Username`, `Password`, `User_role`, `Created`) VALUES
(1, 'Ralph', 'ralph07', 'ralph', 'Admin', '2024-05-17 00:00:00'),
(2, 'Carl', 'carl22', 'carl', 'Stock Clerk', '2024-05-17 00:00:00'),
(3, 'Erych', 'erych30', 'erych', 'Cashier', '2024-05-17 00:00:00'),
(5, 'KIm', 'kim_cardashian', 'kim', 'Stock Clerk', '2024-05-20 00:00:00'),
(6, 'Test', 'admin', 'admin', 'Admin', '2024-05-21 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `sup_id` int(50) UNSIGNED NOT NULL,
  `sup_name` varchar(50) NOT NULL,
  `sup_country` varchar(50) NOT NULL,
  `sup_num` varchar(11) NOT NULL,
  `sup_brand` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`sup_id`, `sup_name`, `sup_country`, `sup_num`, `sup_brand`) VALUES
(1, 'Kim Joy Lonzaga', 'New York America', '11223344556', 'Test 1'),
(2, 'Carl Lachica', 'Japan', '34567891120', '5 Stars'),
(3, 'Ralp', 'America', '87690543219', 'Hotdog');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`);

--
-- Indexes for table `manage_user`
--
ALTER TABLE `manage_user`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`sup_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` int(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `manage_user`
--
ALTER TABLE `manage_user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `sup_id` int(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
