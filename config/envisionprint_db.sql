-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2024 at 05:03 PM
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

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `BookID` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

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
(1, 'Kyle Cedric', '0', 'kyle.cedric@gmail.com', 'Tilapayong, Baliuag, Bulacan', '09911180766', 'upload/profile/Bag_ Cloud Shape Handbag-₱268.png');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

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
(1, 'BINI | Solo Photocard | With Backprint | 9pcs', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\item\\BINI  Solo Photocards  With Backprint  9pcs.jpeg', 79.00, 0, 32),
(42, 'PUREGOLD x BINI | With Backprint | 9pcs | Matte Coat Back to Back', 'Elevate your style with the exclusive PUREGOLD x BINI collection! This unique set includes 9 pieces featuring a trendy backprint design. Each item is crafted with a high-quality matte coat finish, offering a sleek and modern look that\'s perfect for any occasion. The back-to-back design ensures a striking appearance from every angle, making this collection a must-have for fashion enthusiasts.', 'Photocards', 'upload\\item\\PUREGOLD x BINI.jpeg', 89.00, 0, 54),
(43, 'BINI | BINI WAND | Fanmade Photocards | With Backprint', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\item\\BINI WAND.jpeg', 84.00, 0, 523),
(44, 'Test4', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(45, 'BINI | Solo Photocard | With Backprint | 9pcs', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(46, 'Test2', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(47, 'Test3', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(48, 'Test4', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(49, 'BINI | Solo Photocard | With Backprint | 9pcs', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(50, 'Test2', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(51, 'Test3', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(52, 'Test4', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(53, 'BINI | Solo Photocard | With Backprint | 9pcs', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(54, 'Test2', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(55, 'Test3', 'sdsahdsha dsadsadhsad', 'Photocards', 'upload\\category\\bini_fanmade_card.png', 100.00, 0, 423),
(56, 'Spotify Keychain', 'Carry your favorite tunes with you wherever you go with the Spotify Keychain. This stylish and functional accessory lets you showcase your love for music in a unique way. Featuring a sleek design with the iconic Spotify logo, this keychain is perfect for music lovers and Spotify enthusiasts alike.', 'Keychain', 'upload\\item\\Spotify Keychain.jpeg', 100.00, 0, 423);

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

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
-- Table structure for table `purchase_history`
--

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
(2, 'Kyle Cedric', 'kyle', '$2y$10$GEOwpbsdWLr4arEBunA8LeDbPct4/rTe6YZORIBSwjiE6rhKgxS06', 'kyle.cedric@gmail.com', '09911180766', 'Tilapayong, Baliuag, Bulacan', 0, 0, 0, 'upload/profile/Bag_ Cloud Shape Handbag-₱268.png', '1', '72240');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`BookID`),
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
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`ItemID`);

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
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

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
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
