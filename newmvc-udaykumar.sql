-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2023 at 05:55 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newmvc-udaykumar`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `password`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Uday', 'udaymor@gmail.com', 'Uday@12345', 1, '2023-04-10 05:52:50', '2023-04-10 05:53:08');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT 0,
  `path` varchar(100) DEFAULT NULL,
  `name` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `parent_id`, `path`, `name`, `status`, `description`, `created_at`, `updated_at`) VALUES
(29, NULL, '29->', 'root', 1, 'Laptop Description', '2023-02-27 21:24:49', '2023-03-30 08:12:34'),
(57, 29, '29->57->', 'Laptop', 1, '', '2023-04-04 06:40:04', NULL),
(58, 57, '29->57->58->', 'I3 Laptops', 2, '', '2023-04-04 06:40:30', NULL),
(59, 58, '29->57->58->59->', 'HP ', 2, '', '2023-04-04 06:40:48', NULL),
(60, 57, '29->57->60->', 'I5', 1, 'I5 Laptops', '2023-04-06 08:50:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(10) NOT NULL,
  `last_name` varchar(10) NOT NULL,
  `email` varchar(25) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `first_name`, `last_name`, `email`, `mobile`, `gender`, `status`, `created_at`, `updated_at`) VALUES
(59, 'sachin', 'detroja', 'sachindetroja@gmail.com', '7285078529', 'male', 1, '2023-02-14 09:46:45', '2023-03-27 07:57:22'),
(61, 'uday', 'mor', 'udaymor414@gmail.com', '7285078529', 'male', 1, '2023-02-20 11:13:35', '2023-03-19 05:43:37'),
(62, 'uday', 'mor', 'udaymor414@gmail.com', '1234567890', 'male', 1, '2023-02-20 11:14:31', '2023-03-27 08:12:06'),
(63, 'uday', 'mor', 'udaymor414@gmail.com', '09737581174', 'male', 1, '2023-03-06 05:23:17', '2023-03-12 10:43:56');

-- --------------------------------------------------------

--
-- Table structure for table `customer_address`
--

CREATE TABLE `customer_address` (
  `address_id` int(11) NOT NULL,
  `customer_address_id` int(11) DEFAULT NULL,
  `address` text NOT NULL,
  `city` varchar(10) NOT NULL,
  `state` varchar(10) NOT NULL,
  `country` varchar(10) NOT NULL,
  `zip_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_address`
--

INSERT INTO `customer_address` (`address_id`, `customer_address_id`, `address`, `city`, `state`, `country`, `zip_code`) VALUES
(1, 59, '414 ,Dhruv park soc. , Godadara naher ,Godadara ,Surat', 'SURAT', 'GUJRAT', 'India', 395010),
(2, 61, '414, Dhruv park soc. , Godadara Naher ,Godadara , Surat', 'SURAT', 'Gujarat', 'India', 395010),
(3, 62, '414, Dhruv park soc. , Godadara Naher ,Godadara , Surat', 'SURAT', 'Gujarat', 'India', 395010),
(4, 63, '414 ,Dhruv park soc. , Godadara naher ,Godadara ,Surat', 'SURAT', 'GUJRAT', 'India', 395010);

-- --------------------------------------------------------

--
-- Table structure for table `eav_attribute`
--

CREATE TABLE `eav_attribute` (
  `attribute_id` int(11) NOT NULL,
  `entity_type_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `backend_type` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `backend_model` varchar(255) NOT NULL,
  `input_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eav_attribute`
--

INSERT INTO `eav_attribute` (`attribute_id`, `entity_type_id`, `code`, `backend_type`, `name`, `status`, `backend_model`, `input_type`) VALUES
(4, 1, 'color', 'int', 'Color', 2, '', 'text'),
(8, 1, '', '', '', 1, '', 'text');

-- --------------------------------------------------------

--
-- Table structure for table `eav_attribute_option`
--

CREATE TABLE `eav_attribute_option` (
  `option_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eav_attribute_option`
--

INSERT INTO `eav_attribute_option` (`option_id`, `name`, `attribute_id`, `position`) VALUES
(2, 'Red', 4, 0),
(4, 'Black', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `entity_type`
--

CREATE TABLE `entity_type` (
  `entity_type_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `entity_model` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `entity_type`
--

INSERT INTO `entity_type` (`entity_type_id`, `name`, `entity_model`) VALUES
(1, 'product', ''),
(2, 'category', ''),
(3, 'customer', ''),
(4, 'salesman', ''),
(5, 'payment', ''),
(6, 'shipping', ''),
(7, 'vendor', '');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Nokia 1200', 2, '2023-02-20 10:14:12', NULL),
(2, 'Nokia 1200', 2, '2023-02-20 10:14:12', NULL),
(4, 'Nokia', 2, '2023-02-20 10:14:12', '2023-03-23 10:36:45'),
(5, 'Nokia 1200', 2, '2023-02-20 10:14:12', NULL),
(6, 'Nokia', 1, '2023-02-20 10:14:12', '2023-03-07 06:40:24'),
(7, 'Nokia 1200', 2, '2023-02-20 10:14:12', NULL),
(8, 'Nokia 1200', 2, '2023-02-20 10:14:12', NULL),
(9, 'Nokia ', 1, '2023-02-20 10:14:12', '2023-02-20 10:15:47'),
(10, 'Nokia 1200', 2, '2023-02-20 10:14:12', NULL),
(11, 'Nokia 1200', 2, '2023-02-20 10:14:12', NULL),
(13, 'Nokia 1200', 2, '2023-02-20 10:14:12', NULL),
(14, 'Nokia', 2, '2023-02-20 10:14:12', '2023-03-12 10:57:00');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `sku_id` varchar(50) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(5) NOT NULL DEFAULT 5,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `color` varchar(10) NOT NULL,
  `material` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `sku_id`, `cost`, `price`, `quantity`, `description`, `status`, `color`, `material`, `created_at`, `updated_at`) VALUES
(71, 'Nokia 1200', '0.00', '0.00', 0, 'tbfc', 1, '', '', '2023-03-20 04:23:14', '2023-03-22 10:28:28'),
(88, 'sdzvfv', '0.00', '0.00', 5, 'bdbvdfgb', 2, 'black', '', '2023-03-20 04:23:14', '2023-04-09 07:00:06');

-- --------------------------------------------------------

--
-- Table structure for table `product_int`
--

CREATE TABLE `product_int` (
  `value_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_media`
--

CREATE TABLE `product_media` (
  `product_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` datetime NOT NULL,
  `base` tinyint(4) NOT NULL DEFAULT 0,
  `thumnail` tinyint(4) NOT NULL DEFAULT 0,
  `small` tinyint(4) NOT NULL DEFAULT 0,
  `gallary` tinyint(4) NOT NULL DEFAULT 0,
  `file_name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_media`
--

INSERT INTO `product_media` (`product_id`, `image_id`, `name`, `created_at`, `base`, `thumnail`, `small`, `gallary`, `file_name`) VALUES
(49, 2, 'nokia 1500', '2023-02-15 07:50:36', 0, 0, 0, 1, '2.jpg'),
(49, 3, 'nokia 1500', '2023-02-15 08:00:18', 1, 0, 1, 0, '3.jpg'),
(50, 4, 'nokia 1500', '2023-02-15 08:15:11', 0, 0, 1, 1, '4.jpg'),
(50, 5, 'nokia 1500', '2023-02-15 08:15:40', 0, 1, 0, 1, '5.jpg'),
(49, 6, 'nokia 1500', '2023-02-16 04:57:05', 0, 1, 0, 1, '6.jpg'),
(50, 7, 'nokia 1500', '2023-02-16 07:10:48', 1, 0, 0, 1, '7.jpg'),
(59, 14, 'nokia 1500', '2023-03-02 10:06:34', 0, 1, 0, 0, '14.jpg'),
(58, 15, 'nokia 1500', '2023-03-07 05:47:58', 1, 0, 0, 1, '15.jpg'),
(58, 16, 'nokia 1500', '2023-03-07 05:51:01', 0, 1, 1, 1, '16.jpg'),
(66, 17, 'nokia 1500', '2023-03-13 06:29:40', 17, 1, 0, 1, '17.jpg'),
(66, 18, '', '2023-03-20 04:22:45', 0, 0, 0, 0, '18.'),
(71, 20, 'nokia 1500', '2023-03-20 04:24:26', 0, 1, 0, 1, '20.jpg'),
(71, 21, 'nokia 1500', '2023-03-20 04:25:18', 0, 0, 1, 0, '21.jpg'),
(71, 32, 'nokia 1500', '2023-03-27 11:44:49', 1, 0, 0, 1, '32.jpg'),
(88, 33, 'nokia 1500', '2023-04-02 07:40:03', 0, 1, 0, 0, '33.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `salesman`
--

CREATE TABLE `salesman` (
  `salesman_id` int(11) NOT NULL,
  `first_name` varchar(10) NOT NULL,
  `last_name` varchar(10) NOT NULL,
  `email` varchar(25) NOT NULL,
  `mobile` int(10) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `status` tinyint(4) NOT NULL,
  `company` varchar(25) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salesman`
--

INSERT INTO `salesman` (`salesman_id`, `first_name`, `last_name`, `email`, `mobile`, `gender`, `status`, `company`, `created_at`, `updated_at`) VALUES
(40, 'uday', 'mor', 'udaymor414@gmail.com', 2147483647, 'male', 1, 'cybercom', '2023-02-14 09:50:04', '2023-03-27 09:21:41'),
(41, 'sachin', 'detroja', 'sachindetroja@gmail.com', 2147483647, 'male', 2, 'cybercom', '2023-02-14 09:50:32', '2023-04-09 08:00:23'),
(42, 'dax', 'panara', 'daxpanara@gmail.com', 1234567890, 'male', 1, 'cybercom', '2023-02-17 09:11:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `salesman_address`
--

CREATE TABLE `salesman_address` (
  `address_id` int(11) NOT NULL,
  `salesman_address_id` int(11) DEFAULT NULL,
  `address` text NOT NULL,
  `city` varchar(10) NOT NULL,
  `state` varchar(10) NOT NULL,
  `country` varchar(10) NOT NULL,
  `zip_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salesman_address`
--

INSERT INTO `salesman_address` (`address_id`, `salesman_address_id`, `address`, `city`, `state`, `country`, `zip_code`) VALUES
(1, 40, '414 ,Dhruv park soc. , Godadara naher ,Godadara ,Surat cdsc', 'SURAT', 'GUJRAT', 'India', 123456),
(2, 41, '414 ,Dhruv park soc. , Godadara naher ,Godadara ,Surat', 'SURAT', 'GUJRAT', 'India', 395010),
(3, 42, 'shivranjani', 'ahemdabad', 'gujarat', 'india', 395010);

-- --------------------------------------------------------

--
-- Table structure for table `salesman_price`
--

CREATE TABLE `salesman_price` (
  `entity_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `salesman_id` int(11) NOT NULL,
  `salesman_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salesman_price`
--

INSERT INTO `salesman_price` (`entity_id`, `product_id`, `salesman_id`, `salesman_price`) VALUES
(40, 71, 41, 65365),
(45, 88, 40, 12365);

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `shipping_id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`shipping_id`, `name`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(4, 'Nokia 123', '1200.00', 1, '2023-02-20 09:21:34', '2023-04-01 09:46:55'),
(7, 'Nokia sfdss', '1200.00', 1, '2023-02-20 09:21:34', '2023-03-27 10:37:48'),
(8, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-03-13 07:24:04'),
(9, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-02-20 09:21:56'),
(10, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-02-20 09:21:56'),
(11, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-02-20 09:21:56'),
(13, 'Nokia', '1200.00', 2, '2023-02-20 09:21:34', '2023-04-01 09:55:03'),
(14, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-02-20 09:21:56'),
(15, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-02-20 09:21:56'),
(16, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-02-20 09:21:56'),
(17, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-02-20 09:21:56'),
(18, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-02-20 09:21:56'),
(21, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-02-20 09:21:56'),
(22, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-02-20 09:21:56'),
(23, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-02-20 09:21:56'),
(24, 'Nokia', '1200.00', 2, '2023-02-20 09:21:34', '2023-02-20 09:21:56'),
(25, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-02-20 09:21:56'),
(26, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-02-20 09:21:56'),
(27, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-02-20 09:21:56'),
(28, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-02-20 09:21:56'),
(30, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-02-20 09:21:56'),
(32, 'Nokia', '1200.00', 1, '2023-02-20 09:21:34', '2023-02-20 09:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` int(11) NOT NULL,
  `first_name` varchar(10) NOT NULL,
  `last_name` varchar(10) NOT NULL,
  `email` varchar(25) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `status` tinyint(4) NOT NULL,
  `company` varchar(25) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendor_id`, `first_name`, `last_name`, `email`, `mobile`, `gender`, `status`, `company`, `created_at`, `updated_at`) VALUES
(30, 'uday', 'mor', 'udaymor414@gmail.com', '7285078529', 'male', 1, '', '2023-02-14 09:47:12', '2023-04-06 06:58:58'),
(31, 'sachin', 'detroja', 'sachindetroja@gmail.com', '09737581174', 'male', 1, '', '2023-02-14 09:48:12', '2023-03-27 09:08:17');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_address`
--

CREATE TABLE `vendor_address` (
  `address_id` int(11) NOT NULL,
  `vendor_address_id` int(11) DEFAULT NULL,
  `address` text NOT NULL,
  `city` varchar(10) NOT NULL,
  `state` varchar(10) NOT NULL,
  `country` varchar(10) NOT NULL,
  `zip_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_address`
--

INSERT INTO `vendor_address` (`address_id`, `vendor_address_id`, `address`, `city`, `state`, `country`, `zip_code`) VALUES
(1, 30, '414 ,Dhruv park soc. , Godadara naher ,Godadara ,Surat', 'SURAT', 'GUJRAT', 'India', 123456),
(2, 31, '414 ,Dhruv park soc. , Godadara naher ,Godadara ,Surat', 'SURAT', 'GUJRAT', 'India', 395010);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `eav_attribute`
--
ALTER TABLE `eav_attribute`
  ADD PRIMARY KEY (`attribute_id`),
  ADD KEY `entity_type_id` (`entity_type_id`);

--
-- Indexes for table `eav_attribute_option`
--
ALTER TABLE `eav_attribute_option`
  ADD PRIMARY KEY (`option_id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- Indexes for table `entity_type`
--
ALTER TABLE `entity_type`
  ADD PRIMARY KEY (`entity_type_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_int`
--
ALTER TABLE `product_int`
  ADD PRIMARY KEY (`value_id`),
  ADD KEY `entity_id` (`entity_id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- Indexes for table `product_media`
--
ALTER TABLE `product_media`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `salesman`
--
ALTER TABLE `salesman`
  ADD PRIMARY KEY (`salesman_id`);

--
-- Indexes for table `salesman_address`
--
ALTER TABLE `salesman_address`
  ADD PRIMARY KEY (`address_id`),
  ADD UNIQUE KEY `address_id` (`salesman_address_id`);

--
-- Indexes for table `salesman_price`
--
ALTER TABLE `salesman_price`
  ADD PRIMARY KEY (`entity_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `salesman_id` (`salesman_id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`shipping_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- Indexes for table `vendor_address`
--
ALTER TABLE `vendor_address`
  ADD PRIMARY KEY (`address_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `customer_address`
--
ALTER TABLE `customer_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `eav_attribute`
--
ALTER TABLE `eav_attribute`
  MODIFY `attribute_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `eav_attribute_option`
--
ALTER TABLE `eav_attribute_option`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `entity_type`
--
ALTER TABLE `entity_type`
  MODIFY `entity_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `product_int`
--
ALTER TABLE `product_int`
  MODIFY `value_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_media`
--
ALTER TABLE `product_media`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `salesman`
--
ALTER TABLE `salesman`
  MODIFY `salesman_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `salesman_address`
--
ALTER TABLE `salesman_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `salesman_price`
--
ALTER TABLE `salesman_price`
  MODIFY `entity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `shipping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `vendor_address`
--
ALTER TABLE `vendor_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `eav_attribute`
--
ALTER TABLE `eav_attribute`
  ADD CONSTRAINT `eav_attribute_ibfk_1` FOREIGN KEY (`entity_type_id`) REFERENCES `entity_type` (`entity_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `eav_attribute_option`
--
ALTER TABLE `eav_attribute_option`
  ADD CONSTRAINT `eav_attribute_option_ibfk_1` FOREIGN KEY (`attribute_id`) REFERENCES `eav_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_int`
--
ALTER TABLE `product_int`
  ADD CONSTRAINT `product_int_ibfk_1` FOREIGN KEY (`entity_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_int_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `eav_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `salesman_price`
--
ALTER TABLE `salesman_price`
  ADD CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salesman_id` FOREIGN KEY (`salesman_id`) REFERENCES `salesman` (`salesman_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
