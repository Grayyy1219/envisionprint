-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2024 at 10:53 PM
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
-- Database: `envisionprint_db`
--
CREATE DATABASE IF NOT EXISTS `envisionprint_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `envisionprint_db`;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `customer_id`, `ItemID`, `product_name`, `quantity`, `timestamp`) VALUES
(208, 3, 52, '', 1, '2024-07-22 20:23:59');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `Category` varchar(200) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `Category`, `img`) VALUES
(2, 'Insta-inspired', 'upload\\category\\Insta-inspired.png'),
(3, 'Keychain', 'upload\\category\\keychain.png'),
(1, 'Photocards', 'upload/bini_fanmade_card.png'),
(4, 'Photostrips', 'upload/Photostrips.png'),
(5, 'Sample', 'upload/sample.png');

-- --------------------------------------------------------

--
-- Table structure for table `currentuser`
--

DROP TABLE IF EXISTS `currentuser`;
CREATE TABLE `currentuser` (
  `UserId` int(11) NOT NULL,
  `FName` varchar(50) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `profile` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currentuser`
--

INSERT INTO `currentuser` (`UserId`, `FName`, `username`, `email`, `address`, `phone`, `profile`) VALUES
(1, 'Kim Jisoo', 'Jisoo', 'lance.musngi@gmail.com', 'Sanbon-dong, Gunpo-si, South Korea', '09911180766', 'upload/profile/449612955_7814687338627856_4325307237619088894_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `ItemID` int(11) NOT NULL,
  `ItemName` varchar(200) NOT NULL,
  `Description` varchar(2000) NOT NULL,
  `Category` varchar(50) NOT NULL,
  `ItemImg` varchar(200) NOT NULL,
  `Price` decimal(11,2) DEFAULT NULL,
  `Solds` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `rating` float DEFAULT 0,
  `rating_count` int(11) DEFAULT 0,
  `onsale` int(11) NOT NULL COMMENT '0 = No\r\n1 = Yes',
  `oldprice` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ItemID`, `ItemName`, `Description`, `Category`, `ItemImg`, `Price`, `Solds`, `Quantity`, `rating`, `rating_count`, `onsale`, `oldprice`) VALUES
(1, 'BINI | Solo Photocard | With Backprint | 9pcs', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\item\\BINI  Solo Photocards  With Backprint  9pcs.jpeg', 159.00, 49, 558, 2.38, 25, 1, 200.00),
(42, 'PUREGOLD x BINI | With Backprint | 9pcs | Matte Coat Back to Back', 'Elevate your style with the exclusive PUREGOLD x BINI collection! This unique set includes 9 pieces featuring a trendy backprint design. Each item is crafted with a high-quality matte coat finish, offering a sleek and modern look that\'s perfect for any occasion. The back-to-back design ensures a striking appearance from every angle, making this collection a must-have for fashion enthusiasts.', 'Photocards', 'upload\\item\\PUREGOLD x BINI.jpeg', 89.00, 69, 698, 2.625, 24, 0, 0.00),
(43, 'BINI | BINI WAND | Fanmade Photocards | With Backprint', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\item\\BINI WAND.jpeg', 84.00, 60, 311, 3.31818, 22, 0, 0.00),
(44, 'BINI | BiniWockeez Photocards | With Back Print | 9pcs', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\item\\BINI BiniWockeez Photocards With Back Print 9pcs.jpeg', 50.00, 40, 404, 3.96667, 30, 1, 89.00),
(45, 'BINI JolliBINI With Backprint 9pcs', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\item\\BINI JolliBINI With Backprint  9pcs.jpeg', 99.00, 24, 436, 4.3913, 23, 0, 0.00),
(46, 'BINI Karera Fanmade Photocards With Backprint', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\item\\BINI Karera Fanmade Photocards With Backprint.jpeg', 150.00, 5, 409, 4.33333, 3, 0, 0.00),
(47, 'BINIVERSE Back-to-Back With Backprint', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\item\\BINIVERSE Back-to-Back With Backprint.jpeg', 299.00, 0, 419, 0, 0, 0, 0.00),
(48, 'BINI Cherry on Top With Backprint 9pcs', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\item\\BINI Cherry on Top With Backprint 9pcs.jpeg', 150.00, 7, 481, 4.33333, 3, 1, 199.00),
(49, 'BINI | Solo Photocard | With Backprint | 9pcs', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 89.00, 0, 423, 0, 0, 1, 102.00),
(50, 'ENHYPEN BOYFRIEND POLA SET REPOST', 'sdsahdsha dsadsadhsad', 'Photostrips', 'upload\\item\\ENHYPEN BOYFRIEND POLA SET REPOST.jpg', 50.00, 9, 496, 4.16667, 6, 1, 75.00),
(51, 'BINI FANMADE MINI PHOTOSTRIPS BY BESTIE PRINTS', 'sdsahdsha dsadsadhsad', 'Photostrips', 'upload\\item\\BINI FANMADE MINI PHOTOSTRIPS BY BESTIE PRINTS.jpg', 33.00, 3, 410, 4.33333, 3, 0, 0.00),
(52, '2x6 customized photostrip  filmstrip', 'sdsahdsha dsadsadhsad', 'Photostrips', 'upload\\item\\2x6 customized photostrip  filmstrip.jpg', 23.00, 7, 527, 4.33333, 3, 0, 0.00),
(53, '10 pcs Instax Inspired Photo Print', 'sdsahdsha dsadsadhsad', 'Insta-inspired', 'upload\\item\\10 pcs Instax Inspired Photo Print.jpg', 50.00, 0, 423, 0, 0, 0, 0.00),
(54, 'Cartoon Cute Style keychain backpack pendant accessories McDonald', 'sdsahdsha dsadsadhsad', 'Keychain', 'upload/1721663005_Cartoon Cute Style keychain backpack pendant accessories McDonald.png', 16.00, 3, 422, 4.33333, 3, 0, 0.00),
(55, 'Cartoon Space Rabbit Keychain Cute Space Astronaut Couple Chain', 'sdsahdsha dsadsadhsad', 'Keychain', 'upload\\item\\Cartoon Space Rabbit Keychain Cute Space Astronaut Couple Chain.webp', 87.00, 15, 413, 3.26667, 15, 0, 0.00),
(56, 'Spotify Keychain', 'Carry your favorite tunes with you wherever you go with the Spotify Keychain. This stylish and functional accessory lets you showcase your love for music in a unique way. Featuring a sleek design with the iconic Spotify logo, this keychain is perfect for music lovers and Spotify enthusiasts alike.', 'Keychain', 'upload\\item\\Spotify Keychain.jpeg', 399.00, 41, 368, 3.375, 8, 1, 400.00),
(78, 'test', 'sss', 'Sample', 'upload/item/449760235_401341559067552_2862476995722678376_n.png', 1.00, 1, 1, 4, 1, 0, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_quantity` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` int(11) NOT NULL DEFAULT -1 COMMENT '0=otw\r\n1=recived\r\n2=req return\r\n3=return approved\r\n4=return rejected',
  `rating` int(1) DEFAULT 0,
  `Reason` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `product_id`, `order_date`, `order_quantity`, `total_amount`, `status`, `rating`, `Reason`) VALUES
(6454459, 3, '44,43', '2024-07-20 19:41:43', '10,1', 1084.00, 4, 0, ''),
(6454460, 3, '56,42,46', '2024-07-20 19:42:06', '1,9,2', 1400.00, 3, 0, ''),
(6454461, 3, '1,45,48,50,52', '2024-07-20 19:42:23', '9,1,4,5,7', 2411.00, 2, 0, ''),
(6454462, 3, '43', '2024-07-20 19:53:48', '3', 252.00, 1, 0, 'Received wrong item'),
(6454463, 3, '1,42', '2024-07-20 19:55:56', '5,8', 1107.00, 0, 0, 'Other'),
(6454465, 3, '50', '2024-07-22 18:06:58', '1', 50.00, -1, 0, ''),
(6454466, 3, '78', '2024-07-22 19:27:43', '1', 1.00, -2, 0, 'Changed mind'),
(6454467, 13, '43', '2024-07-22 20:30:15', '1', 84.00, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `ItemID` int(11) NOT NULL,
  `Itemname` varchar(50) NOT NULL,
  `value` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`ItemID`, `Itemname`, `value`) VALUES
(1, 'Logo', 'upload/page/logo.ico'),
(4, 'Background Color', '#B15EFF'),
(5, 'Text Color', '#000');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_mode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `order_id`, `customer_id`, `payment_date`, `amount_paid`, `payment_mode`) VALUES
(435442, 6454459, 3, '2024-07-20 19:41:43', 1084.00, 'BPI'),
(435443, 6454460, 3, '2024-07-20 19:42:06', 1400.00, 'Cash On Delivery'),
(435444, 6454461, 3, '2024-07-20 19:42:23', 2411.00, 'Visa'),
(435445, 6454462, 3, '2024-07-20 19:53:48', 252.00, 'Maya'),
(435446, 6454463, 3, '2024-07-20 19:55:56', 1107.00, 'Debit Card'),
(435447, 6454465, 3, '2024-07-22 18:06:58', 50.00, 'BPI'),
(435448, 6454466, 3, '2024-07-22 19:27:43', 1.00, 'BPI'),
(435449, 6454467, 13, '2024-07-22 20:30:15', 84.00, 'Maya'),
(435450, 6454468, 13, '2024-07-22 20:30:18', 0.00, 'Maya');

-- --------------------------------------------------------

--
-- Table structure for table `paymethod`
--

DROP TABLE IF EXISTS `paymethod`;
CREATE TABLE `paymethod` (
  `method_name` varchar(255) NOT NULL,
  `method_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paymethod`
--

INSERT INTO `paymethod` (`method_name`, `method_img`) VALUES
('BPI', 'upload\\method\\link-91720ed84858d490ca62142de0494559.png'),
('Debit Card', 'upload\\method\\link-cf7aaa8b59e07c8548d2f03f0d930acb.png'),
('Maya', 'upload\\method\\link-4a1f1c2d9ee1820ccc9621b44f277387.png'),
('Visa', 'upload\\method\\link-8efc3b564e08e9e864ea83ab43d9f913.png');

-- --------------------------------------------------------

--
-- Table structure for table `promo_codes`
--

DROP TABLE IF EXISTS `promo_codes`;
CREATE TABLE `promo_codes` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promo_codes`
--

INSERT INTO `promo_codes` (`id`, `code`, `discount`) VALUES
(1, 'promo', 20),
(2, 'test', 100),
(3, 'minecraft', 69),
(4, 'payday', 15),
(5, 'discount', 20);

-- --------------------------------------------------------

--
-- Table structure for table `slideshow`
--

DROP TABLE IF EXISTS `slideshow`;
CREATE TABLE `slideshow` (
  `SlideID` int(11) NOT NULL,
  `imagename` varchar(50) NOT NULL,
  `imagelocation` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slideshow`
--

INSERT INTO `slideshow` (`SlideID`, `imagename`, `imagelocation`) VALUES
(1, 'slide1', 'upload/slideshow/1.png'),
(2, 'slide2', 'upload/slideshow/2.png'),
(3, 'slide3', 'upload/slideshow/3.png'),
(4, 'slide4', 'upload/slideshow/4.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `FName` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `attempt` int(11) NOT NULL,
  `block` int(11) NOT NULL,
  `admin` int(1) NOT NULL,
  `profile` varchar(200) NOT NULL,
  `verification` varchar(10) NOT NULL,
  `verification_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FName`, `username`, `password`, `email`, `phone`, `address`, `attempt`, `block`, `admin`, `profile`, `verification`, `verification_code`) VALUES
(1, 'EnVision Print', 'admin', 'admin', 'envision.print@gmail.com', '09911180769', 'Tilapayong, Baliuag, Bulacan', 0, 0, 1, 'upload/profile/logo.ico', '1', '72240'),
(3, 'Kim Jisoo', 'Jisoo', '$2y$10$5C5gf8EuGrhIrv0RtFsAxOyrF6iSe8E71HaNOdMlRdunw88LtA56K', 'lance.musngi@gmail.com', '09911180766', 'Sanbon-dong, Gunpo-si, South Korea', 0, 0, 0, 'upload/profile/449612955_7814687338627856_4325307237619088894_n.jpg', '1', '18046'),
(13, 'Test', 'test', '$2y$10$5C5gf8EuGrhIrv0RtFsAxOyrF6iSe8E71HaNOdMlRdunw88LtA56K', 'lanceka456@gmail.com', '09911180766', 'Sanbon-dong, Gunpo-si, South Korea', 0, 0, 0, 'upload/profile/BINI Cherry on Top With Backprint 9pcs.jpeg', '1', '18046');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`ItemID`),
  ADD KEY `cart_ibfk_1` (`customer_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category`),
  ADD UNIQUE KEY `GenreID` (`CategoryID`);

--
-- Indexes for table `currentuser`
--
ALTER TABLE `currentuser`
  ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`ItemID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`ItemID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `paymethod`
--
ALTER TABLE `paymethod`
  ADD PRIMARY KEY (`method_name`);

--
-- Indexes for table `promo_codes`
--
ALTER TABLE `promo_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `slideshow`
--
ALTER TABLE `slideshow`
  ADD PRIMARY KEY (`SlideID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `currentuser`
--
ALTER TABLE `currentuser`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6454469;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=435451;

--
-- AUTO_INCREMENT for table `promo_codes`
--
ALTER TABLE `promo_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `slideshow`
--
ALTER TABLE `slideshow`
  MODIFY `SlideID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
