-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2025 at 05:12 PM
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
-- Database: `rolebased_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `specification` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `delivery_charge` decimal(10,2) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `specification`, `description`, `price`, `discount`, `delivery_charge`, `photo`) VALUES
(1, 'Hikvision DS-D5022F2-CBD 21.5 Inch FHD Displa ...', 'dfda', 'adsfxc', 34432.00, 2.00, 34.00, '1761417388_Screenshot 2025-10-21 191849.png'),
(2, 'MONITOR', 'VCV', 'd', 3456.00, 4.00, 34.00, '1761417380_Screenshot 2025-10-21 172450.png'),
(3, 'HP V22v G5 21.5 Inch FHD Display HDMI, VGA Bl ...', 'd', 'dfsadfa', 20000.00, 30.00, 0.00, '1761419496_Screenshot 2025-10-21 171748.png'),
(5, 'MSI PRO MP225 22 Inch (21.5 Inch Viewable) FH ...', 'dsf', 'asdf', 456.00, 20.00, 0.00, '1761421483_pexels-laryssa-suaid-798122-1667088.jpg'),
(6, 'Acer Aspire Lite AL15-52 12th Gen Intel Core i3 1215U 16GB RAM, 512GB SSD Steel Gray Laptop', 'Processor Type. - Core i3 Generation - 12th (Intel) RAM - 16GB Storage - 512GB SSD Graphics Memory - Shared Display Size (Inch) - 15.6 Color - Steel Gray', 'What Makes it Special?\r\nPortability: The Aspire Lite AL15-52 boasts a slim and lightweight design, making it easy to carry around for work, school, or travel.\r\nPerformance: The 12th Gen Intel Core i3 processor and 16GB of RAM deliver smooth and efficient performance for daily tasks. The 512GB SSD provides ample storage space and fast boot times.\r\nDisplay: The 15.6-inch display offers a good viewing experience for movies, videos, and browsing.\r\nConnectivity: The laptop includes Wi-Fi and Bluetooth 5.0 for seamless connectivity to the internet and other devices.\r\n', 51900.00, 20.00, 120.00, '1761421934_Screenshot 2025-10-26 015140.png'),
(7, 'Laptop A', 'Intel i5, 8GB RAM, 256GB SSD', '', 50000.00, 20.00, 500.00, '1761447275_pexels-laryssa-suaid-798122-1667088.jpg'),
(8, 'Mouse B', 'Wireless, Ergonomic', '', 800.00, 0.00, 0.00, '1761447266_Screenshot 2025-10-26 015140.png'),
(9, 'Keyboard C', 'Mechanical, RGB', '', 1500.00, 25.00, 0.00, '1761447235_Screenshot 2025-09-30 084259.jpg'),
(10, 'Gigabyte GS25F2 24.5 Inch FHD Display Dual HD ...', 'dfdsfds', 'dfsdf', 2200.00, 12.00, 0.00, '1761447255_Screenshot 2025-10-21 171748.png'),
(11, 'BenQ Mobiuz EX270QM 27 Inch 2K QHD Display dual-hdmi,-dp,-usb Gaming Monitor', 'Display Size (Inch) - 27 Display Resolution - 2560x1440 Panel Type - IPS Refresh Rate (Hz) - 240Hz Rotatable - No HDMI Port - 2 Color - Black', 'What is the screen size of this monitor? It has a 27-inch 2K QHD display.\r\nWhat is the refresh rate? It has a 240Hz refresh rate for smooth gameplay.\r\nDoes it support FreeSync? Yes, it supports AMD FreeSync Premium for tear-free gaming.\r\nWhat is the response time? It has a 1ms response time for minimal motion blur.\r\nDoes it have built-in speakers? Yes, it includes built-in speakers for immersive sound.', 40000.00, 20.00, 120.00, '1761485732_Screenshot 2025-10-26 191803.png');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 2, 5, 'fdf', '2025-10-25 17:54:07'),
(2, 1, 2, 2, 'ddd', '2025-10-25 17:54:13'),
(3, 1, 2, 4, 'dd', '2025-10-25 17:54:17'),
(4, 1, 2, 1, 'very bad\r\n', '2025-10-25 17:57:30'),
(5, 1, 2, 5, 'nice\r\n', '2025-10-25 17:57:50'),
(6, 2, 5, 3, '0', '2025-10-25 18:44:42'),
(7, 3, 8, 4, 'nice products\r\n', '2025-10-25 19:45:16'),
(8, 6, 8, 3, 'nice laptop\r\n', '2025-10-25 19:52:54'),
(9, 3, 7, 2, 'ss', '2025-10-26 02:14:13'),
(10, 5, 7, 3, 'q', '2025-10-26 02:17:09'),
(11, 2, 7, 5, '010', '2025-10-26 02:51:49'),
(12, 6, 5, 5, 'df', '2025-10-26 02:55:27'),
(13, 7, 11, 5, 'dfsd', '2025-10-26 02:56:17'),
(14, 6, 5, 4, 'dsf', '2025-10-26 03:26:50'),
(15, 9, 5, 4, '12', '2025-10-26 03:32:41'),
(16, 6, 11, 4, 'we', '2025-10-26 13:12:51'),
(17, 11, 12, 5, 'nice products', '2025-10-26 14:00:51'),
(18, 6, 12, 4, 'nice', '2025-11-06 16:01:08'),
(19, 8, 5, 5, 'dfa', '2025-11-06 16:02:04');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `status`, `created_at`) VALUES
(1, 5, 'approved', '2025-10-25 18:29:09'),
(2, 6, 'approved', '2025-10-25 18:33:13'),
(3, 7, 'approved', '2025-10-25 19:00:20'),
(4, 8, 'approved', '2025-10-25 19:12:55'),
(5, 9, 'approved', '2025-10-25 19:18:51'),
(6, 10, 'approved', '2025-10-25 19:40:00'),
(7, 11, 'approved', '2025-10-25 20:04:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'admin', 'admin@example.com', '0192023a7bbd73250516f069df18b500', 'admin'),
(2, 'admin', 'hassanjahid317@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(3, 'admin', 'df@sdgf', '202cb962ac59075b964b07152d234b70', 'user'),
(4, 'admin', 'jahidgaming99@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(5, 'admin', 'hasan@gd', '202cb962ac59075b964b07152d234b70', 'user'),
(6, 'seam', 'seam@email.com', '202cb962ac59075b964b07152d234b70', 'user'),
(7, 'mmm', 'm@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(8, 'dddd', 'hello@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(9, 'jahid', 'hi@email.com', '202cb962ac59075b964b07152d234b70', 'user'),
(10, 'fardin', 'fardin@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(11, 'a@', 'a@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(12, 'Jahid Hasan', 'bb@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(13, 'jahid', 'jahid@gmail.com', '12345', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
