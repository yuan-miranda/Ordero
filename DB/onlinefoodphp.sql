-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 09:21 PM
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
-- Database: `onlinefoodphp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adm_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `code` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `username`, `password`, `email`, `code`, `date`) VALUES
(1, 'admin', 'CAC29D7A34687EB14B37068EE4708E7B', 'admin@mail.com', '', '2025-05-20 18:20:14'),
(2, 'group1', '513772ee53011ad9f4dc374b2d34d0e9', 'group1@mail.com', '', '2025-05-20 18:20:14'),
(3, 'group2', 'f617868bd8c41043dc4bebc7952c7024', 'group2@mail.com', '', '2025-05-20 18:20:14'),
(4, 'group3', '78733d0dd44e9bbca1d931c569676531', 'group3@mail.com', '', '2025-05-20 18:20:14'),
(5, 'group4', 'baf5d52135cbcd978e0083939e9f3071', 'group4@mail.com', '', '2025-05-20 18:20:14'),
(6, 'group5', '28f745f0b69377f5f945845a36cce4a1', 'group5@mail.com', '', '2025-05-20 18:20:14');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `d_id` int(222) NOT NULL,
  `adm_id` int(222) NOT NULL,
  `rs_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `slogan` varchar(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(222) NOT NULL DEFAULT 0,
  `img` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`d_id`, `adm_id`, `rs_id`, `title`, `slogan`, `price`, `quantity`, `img`) VALUES
(1, 2, 1, 'Mustalicious', 'Mustalicious is a pack of crunchy chips made from Mustard Greens (mustasa). It aims to promote food conservation by introducing original plant-based chips that serve as an alternative to traditional chips.', 15.00, 20, '682ccb3fdec01.jpg'),
(2, 3, 2, 'Peeling Puto', 'The Unpeeling’s product is a modified version of the Filipino snack called Puto (steamed rice cake). Peeling Puto is inspired by puto with the twist of using banana as the main ingredient and utilizing its peels to create.', 55.00, 20, '682ccdf03b1d0.png'),
(3, 4, 3, 'Sotang-hai', 'Sotang-hai is unique in that it only has the savory flavor of Sotanghon but instead of appearing as a soup, it is wrapped in lumpia wrappers and deep fried. Additionally, Sotang-hai consists of ground pork instead of shred', 25.00, 20, '682cce128fb7d.png'),
(4, 5, 4, 'Muggets', 'Muggets is the vegetable version of traditional nuggets. These are a delicious fusion of Mung beans and carrots, coated with golden and crispy batter with bursting flavor and are beneficial for one’s health. This is served', 40.00, 20, '682ccea6cdbea.jpg'),
(5, 6, 5, 'Emfunada', 'Emfunada is a Filipino snack featuring various versions, with meat fillings made from papaya. Variations include classic, double meat, double egg, and overload. Add-ons include cheese and chili for cheese lovers and spicy ', 15.00, 20, '682ccf5d1df9a.png');

-- --------------------------------------------------------

--
-- Table structure for table `remark`
--

CREATE TABLE `remark` (
  `id` int(11) NOT NULL,
  `frm_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remark` mediumtext NOT NULL,
  `remarkDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `rs_id` int(222) NOT NULL,
  `adm_id` int(222) NOT NULL,
  `c_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `url` varchar(222) NOT NULL,
  `o_hr` varchar(222) NOT NULL,
  `c_hr` varchar(222) NOT NULL,
  `o_days` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `image` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`rs_id`, `adm_id`, `c_id`, `title`, `email`, `phone`, `url`, `o_hr`, `c_hr`, `o_days`, `address`, `image`, `date`) VALUES
(1, 2, 1, 'GROUP #1', 'zoeannebernardino@gmail.com', '(044) 766-6722', 'https://www.sti.edu/campuses-details.asp?campus_id=QkxH', '10am', '5pm', '24hr-x7', 'Gil Carlos Street, Poblacion, Baliuag, 3006 Bulacan', '682ccafaec7dc.jpg', '2025-05-20 18:33:30'),
(2, 3, 2, 'GROUP #2', 'jillianmanaol360@gmail.com', '(044) 766-6722', 'https://www.sti.edu/campuses-details.asp?campus_id=QkxH', '10am', '5pm', '24hr-X7', 'Gil Carlos Street, Poblacion, Baliuag, 3006 Bulacan', '682ccc7f58532.jpg', '2025-05-20 18:36:59'),
(3, 4, 3, 'GROUP #3', 'dayegok@gmail.com', '(044) 766-6722', 'https://www.sti.edu/campuses-details.asp?campus_id=QkxH', '10am', '5pm', '24hr-x7', 'Gil Carlos Street, Poblacion, Baliuag, 3006 Bulacan', '682ccd1a015e6.jpg', '2025-05-20 18:42:34'),
(4, 5, 4, 'GROUP #4', 'rizettegarcia123@gmail.com', '(044) 766-6722', 'https://www.sti.edu/campuses-details.asp?campus_id=QkxH', '10am', '5pm', '24hr-x7', 'Gil Carlos Street, Poblacion, Baliuag, 3006 Bulacan', '682cce66f20ef.jpg', '2025-05-20 18:48:06'),
(5, 6, 5, 'GROUP #5', 'aiceljhade10@gmail.com', '(044) 766-6722', 'https://www.sti.edu/campuses-details.asp?campus_id=QkxH', '10am', '5pm', '24hr-x7', 'Gil Carlos Street, Poblacion, Baliuag, 3006 Bulacan', '682ccf14f0c59.jpg', '2025-05-20 18:51:00');

-- --------------------------------------------------------

--
-- Table structure for table `res_category`
--

CREATE TABLE `res_category` (
  `c_id` int(222) NOT NULL,
  `adm_id` int(222) NOT NULL,
  `c_name` varchar(222) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `res_category`
--

INSERT INTO `res_category` (`c_id`, `adm_id`, `c_name`, `date`) VALUES
(1, 2, 'Group 1 STEM2A', '2025-05-20 18:21:55'),
(2, 3, 'Group 2 STEM2A', '2025-05-20 18:37:28'),
(3, 4, 'Group 3 STEM2A', '2025-05-20 18:41:39'),
(4, 5, 'Group 4 STEM2A', '2025-05-20 18:47:11'),
(5, 6, 'Group 5 STEM2A', '2025-05-20 18:49:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(222) NOT NULL,
  `username` varchar(222) NOT NULL,
  `f_name` varchar(222) NOT NULL,
  `l_name` varchar(222) NOT NULL,
  `email` varchar(222) NOT NULL,
  `phone` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL,
  `address` text NOT NULL,
  `status` int(222) NOT NULL DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_orders`
--

CREATE TABLE `users_orders` (
  `o_id` int(222) NOT NULL,
  `rs_id` int(222) NOT NULL,
  `d_id` int(222) NOT NULL,
  `u_id` int(222) NOT NULL,
  `title` varchar(222) NOT NULL,
  `quantity` int(222) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` varchar(222) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `arrive` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `remark`
--
ALTER TABLE `remark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`rs_id`);

--
-- Indexes for table `res_category`
--
ALTER TABLE `res_category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `users_orders`
--
ALTER TABLE `users_orders`
  ADD PRIMARY KEY (`o_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adm_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `d_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `remark`
--
ALTER TABLE `remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `rs_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `res_category`
--
ALTER TABLE `res_category`
  MODIFY `c_id` int(222) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(222) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_orders`
--
ALTER TABLE `users_orders`
  MODIFY `o_id` int(222) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
