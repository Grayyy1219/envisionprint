-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2024 at 03:12 PM
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
(145, 3, 43, '', 1, '2024-07-08 11:26:02'),
(146, 3, 46, '', 1, '2024-07-08 11:26:11'),
(147, 3, 56, '', 1, '2024-07-08 11:26:21'),
(148, 3, 44, '', 4, '2024-07-08 11:26:32'),
(149, 3, 1, '', 1, '2024-07-08 12:06:09'),
(150, 3, 47, '', 2, '2024-07-08 12:06:59'),
(151, 3, 48, '', 1, '2024-07-08 12:08:22'),
(152, 3, 55, '', 1, '2024-07-08 12:10:24');

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
(1, 'Photocards', 'upload\\category\\bini_fanmade_card.png'),
(4, 'Photostrips', 'upload\\category\\Photostrips.png'),
(5, 'Sample', 'upload\\category\\Sample.png');

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
(1, 'Kim Jisoo', 'lance', 'lance.musngi@gmail.com', 'Sanbon-dong, Gunpo-si, South Korea', '09911180766', 'upload/profile/449612955_7814687338627856_4325307237619088894_n.jpg');

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
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ItemID`, `ItemName`, `Description`, `Category`, `ItemImg`, `Price`, `Solds`, `Quantity`) VALUES
(1, 'BINI | Solo Photocard | With Backprint | 9pcs', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\item\\BINI  Solo Photocards  With Backprint  9pcs.jpeg', 79.00, 1, 31),
(42, 'PUREGOLD x BINI | With Backprint | 9pcs | Matte Coat Back to Back', 'Elevate your style with the exclusive PUREGOLD x BINI collection! This unique set includes 9 pieces featuring a trendy backprint design. Each item is crafted with a high-quality matte coat finish, offering a sleek and modern look that\'s perfect for any occasion. The back-to-back design ensures a striking appearance from every angle, making this collection a must-have for fashion enthusiasts.', 'Photocards', 'upload\\item\\PUREGOLD x BINI.jpeg', 89.00, 58, 752),
(43, 'BINI | BINI WAND | Fanmade Photocards | With Backprint', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\item\\BINI WAND.jpeg', 84.00, 1, 522),
(44, 'Test1', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(45, 'BINI | Solo Photocard | With Backprint | 9pcs', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(46, 'Test2', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(47, 'Test3', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 2, 421),
(48, 'Test4', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(49, 'BINI | Solo Photocard | With Backprint | 9pcs', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(50, 'Test5', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(51, 'Test6', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(52, 'Test7', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(53, 'BINI | Solo Photocard | With Backprint | 9pcs', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(54, 'Test8', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(55, 'Test9', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(56, 'Spotify Keychain', 'Carry your favorite tunes with you wherever you go with the Spotify Keychain. This stylish and functional accessory lets you showcase your love for music in a unique way. Featuring a sleek design with the iconic Spotify logo, this keychain is perfect for music lovers and Spotify enthusiasts alike.', 'Keychain', 'upload\\item\\Spotify Keychain.jpeg', 100.00, 6, 417);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_quantity` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `product_id`, `order_date`, `order_quantity`, `total_amount`, `status`) VALUES
(46, 3, ',47', '2024-07-08 05:40:28', 0, 200.00, 0),
(47, 3, '47', '2024-07-08 05:40:56', 2, 200.00, 0),
(48, 3, '56,42', '2024-07-08 06:01:53', 6, 5406.00, 0),
(49, 3, '43', '2024-07-08 06:35:29', 1, 84.00, 0),
(50, 3, '', '2024-07-08 06:44:11', 0, 0.00, 0),
(51, 3, '42,1', '2024-07-08 11:42:58', 4, 435.00, 0),
(52, 3, '', '2024-07-08 12:02:13', 0, 0.00, 0);

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
(1, 'Logo', 'css/img/logo.png'),
(2, 'Company Name', ''),
(3, 'Background Image', 'upload/page/pexels-pixabay-139398.jpg'),
(4, 'Background Color', '#B15EFF'),
(5, 'Text Color', '#000000');

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
(435412, 47, 3, '2024-07-08 05:40:56', 200.00, 'Gcash'),
(435413, 48, 3, '2024-07-08 06:01:53', 5406.00, 'Cash on Delivery'),
(435414, 49, 3, '2024-07-08 06:35:29', 84.00, 'Credit Card'),
(435415, 50, 3, '2024-07-08 06:44:11', 0.00, 'Credit Card'),
(435416, 51, 3, '2024-07-08 11:42:58', 435.00, 'Cash on Delivery'),
(435417, 52, 3, '2024-07-08 12:02:13', 0.00, 'Visa');

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
-- Table structure for table `purchase_history`
--

DROP TABLE IF EXISTS `purchase_history`;
CREATE TABLE `purchase_history` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date NOT NULL,
  `penalty_paid` int(11) NOT NULL,
  `returned` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'EnVision Print', 'admin', 'admin', 'envision.print@gmail.com', '09911180769', 'Tilapayong, Baliuag, Bulacan', 0, 0, 1, 'upload/profile/Bag_ Cloud Shape Handbag-₱268.png', '1', '72240'),
(2, 'Kyle Cedric', 'kyle', '$2y$10$GEOwpbsdWLr4arEBunA8LeDbPct4/rTe6YZORIBSwjiE6rhKgxS06', 'kyle.cedric@gmail.com', '09911180766', 'Tilapayong, Baliuag, Bulacan', 0, 0, 0, 'upload/profile/Bag_ Cloud Shape Handbag-₱268.png', '1', '72240'),
(3, 'Kim Jisoo', 'lance', '$2y$10$5C5gf8EuGrhIrv0RtFsAxOyrF6iSe8E71HaNOdMlRdunw88LtA56K', 'lance.musngi@gmail.com', '09911180766', 'Sanbon-dong, Gunpo-si, South Korea', 0, 0, 0, 'upload/profile/449612955_7814687338627856_4325307237619088894_n.jpg', '1', '25911');

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
-- Indexes for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`);

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
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `currentuser`
--
ALTER TABLE `currentuser`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=435418;

--
-- AUTO_INCREMENT for table `promo_codes`
--
ALTER TABLE `promo_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slideshow`
--
ALTER TABLE `slideshow`
  MODIFY `SlideID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
