-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2024 at 01:44 AM
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
(8, 'Dragonfruits'),
(9, 'Pineapple');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `size` decimal(50,0) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `price` varchar(255) NOT NULL,
  `staff` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `product`, `brand`, `size`, `quantity`, `order_date`, `price`, `staff`, `category`) VALUES
(16, 'ralph', 'Chibi', '5 Stars', 100, 100, '2024-06-07', '130000', 'Test', 'Pineapple'),
(17, 'carl', 'Gala', 'Hotdog', 70, 100, '2024-06-29', '120000', 'Test', 'Orange'),
(19, 'Lach', 'Chibi', '5 Stars', 100, 100, '2024-06-22', '130000', 'Test', 'Cherry'),
(20, 'ralph', 'Chibi', '5 Stars', 100, 50, '2024-06-29', '65000', 'Test', 'Cherry'),
(21, 'ude', 'Gala', 'Hotdog', 113, 100, '2024-06-13', '120000', 'Test', 'Kiwi');

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
  `price` decimal(10,0) NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `product_name`, `brand_name`, `category`, `size`, `order_quantity`, `price`, `status`) VALUES
(35, 'Gala Apple', 'Test 1', 'Apple', 88, 2000, 120000, NULL),
(38, 'Gala Apple', 'Hotdog', 'Grapes', 12, 100, 120000, NULL),
(39, 'Gala Apple', '5 Stars', 'Cherry', 10, 550, 0, NULL),
(43, 'Gala', '5 Stars', 'Kiwi', 20, 100, 2000, NULL),
(44, 'Gala', 'Hotdog', 'Kiwi', 113, 50, 1200, NULL),
(47, 'Chibi', '5 Stars', 'Cherry', 100, 150, 2300, NULL);

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
(3, 'Erych', 'erych30', 'erych1', 'Admin', '2024-05-17 00:00:00'),
(7, 'Ralph', 'ralph07', 'ralph', 'Admin', '2024-05-25 22:45:03'),
(9, 'Test', 'admin', 'admin', 'Admin', '2024-05-25 22:57:26'),
(10, 'check', 'checker', 'hatdog', 'Stock Clerk', '2024-06-05 04:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) UNSIGNED NOT NULL,
  `product` varchar(50) NOT NULL,
  `brand` varchar(11) NOT NULL,
  `category` varchar(11) NOT NULL,
  `size` tinyint(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `staff` varchar(50) NOT NULL,
  `order_date` date NOT NULL,
  `status` enum('pending','delivered') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `product`, `brand`, `category`, `size`, `quantity`, `price`, `staff`, `order_date`, `status`) VALUES
(137, '35', '3', 'Grapes', 10, 450, 1500.00, 'Test', '2024-06-05', 'delivered'),
(138, '36', '2', 'Kiwi', 20, 200, 2000.00, 'Test', '2024-06-05', 'delivered'),
(139, '31', '3', 'Kiwi', 113, 250, 1200.00, 'Test', '2024-06-05', 'delivered'),
(144, '30', '2', 'Orange', 88, 120, 1000.00, 'Test', '2024-06-05', 'delivered'),
(145, '45', '2', 'Cherry', 100, 200, 2300.00, 'Test', '2024-06-29', 'delivered');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(11) NOT NULL,
  `sale_product` varchar(50) NOT NULL,
  `sale_size` int(50) NOT NULL,
  `sold_quantity` int(11) NOT NULL,
  `sale_total` int(11) NOT NULL,
  `sale_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `sale_product`, `sale_size`, `sold_quantity`, `sale_total`, `sale_date`) VALUES
(1, 'fuiji', 150, 200, 50, '2024-07-01'),
(2, 'burat', 180, 300, 100, '0000-00-00'),
(2, 'burat', 180, 300, 100, '2024-07-07'),
(3, 'Princess Apples', 200, 200, 50, '2024-12-30');

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
(3, 'Ralp', 'America', '87690543219', 'Hotdog'),
(5, 'Polenday', 'Burat', '09467663345', 'Nike');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

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
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

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
  MODIFY `cat_id` int(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` int(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `manage_user`
--
ALTER TABLE `manage_user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `sup_id` int(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
