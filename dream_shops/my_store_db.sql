-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 14, 2017 at 12:08 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_store_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `adverts`
--

CREATE TABLE `adverts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `description` text NOT NULL,
  `featured` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

--
-- Dumping data for table `adverts`
--

INSERT INTO `adverts` (`id`, `title`, `image`, `description`, `featured`) VALUES
(1, 'Boom!!ioooo', '/dream_shops/images/products/d9b2195241ba88889e4afae9462f0ae9.jpg', 'Lolosest', 1),
(2, 'Second Advertss', '/dream_shops/images/ads/c5197c7dec480656e3e875952c6bbfe9.jpg', 'From inception, the company has been experiencing sustained growth in its operations and the clientele volume due to the management???s commitment to continuous growth in a fast growing market and our client-friendly policies, as we are ardent believers in fair trade for the benefit of the both business and consumer, as ascribed by section 12 of the Competition and Fair Trading Act, Chapter 417 of the laws of the Republic of Zambia.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand`) VALUES
(1, 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `items` text NOT NULL,
  `expiry_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `items`, `expiry_date`) VALUES
(8, '[{\"id\":\"3\",\"size\":\"Small\",\"quantity\":23}]', '2018-01-08 02:14:05');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_category` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent_category`) VALUES
(1, 'Gadgets', 0),
(2, 'Men\'s Clothes', 0),
(3, 'Women\'s Clothes', 0),
(4, 'Kid\'s Clothes', 0),
(5, 'Accessories', 0),
(6, 'Cell Phones', 1),
(7, 'Computers', 1),
(8, 'Smart Watches', 1),
(9, 'Bottoms', 2),
(10, 'Tops', 2),
(11, 'Shoes', 2),
(12, 'Miscellaneous', 2),
(13, 'Bottoms', 3),
(14, 'Tops', 3),
(15, 'Shoes', 3),
(16, 'Miscellaneous', 3),
(17, 'Bottoms', 4),
(18, 'Tops', 4),
(19, 'Shoes', 4),
(20, 'Miscellaneous', 4),
(21, 'Necklaces', 5),
(22, 'Earings', 5),
(23, 'Watches', 5),
(24, 'Glasses', 5),
(25, 'VR Gear', 1),
(26, 'Caps', 2),
(27, 'Hoverboards', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `delivered` int(11) NOT NULL DEFAULT '0',
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` varchar(750) NOT NULL,
  `zip` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `items` text NOT NULL,
  `payment_type` int(11) NOT NULL DEFAULT '0',
  `transaction_id` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `shipped` int(11) NOT NULL DEFAULT '0',
  `paid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `cart_id`, `delivered`, `fullname`, `phone`, `province`, `city`, `address`, `zip`, `email`, `items`, `payment_type`, `transaction_id`, `amount`, `invoice`, `shipped`, `paid`) VALUES
(2, 4, 1, 'Thulani Tembo', '260976245430', 'Lusaka Province', 'Lusaka', '157/13, Ngombe Cmp', 10101, 'tembothulani@gmail.com', '[{\"id\":\"3\",\"size\":\"Small\",\"quantity\":\"9\"}]', 0, '', '', 'OESU4ZS2', 0, 1),
(3, 5, 1, 'Tutu Tutu', '0987', 'Lusaka Province', 'Lusaka', 'Tutu', 10101, 'Tutu@gmail.com', '[{\"id\":\"3\",\"size\":\"Small\",\"quantity\":\"9\"}]', 0, '', '', 'OESF89BG', 0, 1),
(4, 7, 1, 'Lani Tutu', '09876755', 'Lusaka Province', 'Lusaka', 'thu', 1234, 'te@gmail.com', '[{\"id\":\"3\",\"size\":\"Small\",\"quantity\":\"10\"}]', 0, '', '', 'OESN6GWD', 0, 1),
(5, 8, 1, 'Thulani Tembo', '0976245430', 'Lusaka Province', 'Lusaka', '123 Lusaka', 10101, 'tembothulani@gmail.com', '[{\"id\":\"3\",\"size\":\"Small\",\"quantity\":\"22\"}]', 0, '', '', 'OES84283', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `brand` int(11) NOT NULL,
  `categories` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sub_category` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `featured` tinyint(4) NOT NULL,
  `sizes` text COLLATE utf8_unicode_ci NOT NULL,
  `sold` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `brand`, `categories`, `sub_category`, `image`, `description`, `featured`, `sizes`, `sold`) VALUES
(3, 'Kid&#039;s Jeans', '20.00', 1, '4', 17, '/dream_shops/images/products/158e04f52be40c9323eea5eac691c132.png', 'hey', 1, 'Small:68', 0),
(4, 'Motion T-Sirt', '20.00', 1, '2', 10, '/dream_shops/images/products/f1f681f23e9e138b19eb8dde91cca502.jpeg', 'Motion T--sirts', 1, 'Small:12,Medium:10', 0),
(5, 'Hoodie', '120.00', 1, '2', 10, '/dream_shops/images/products/66dc02b855230a4dfbbbd974e3b078b1.jpeg', 'Hoodie', 1, 'Medium:12', 0),
(6, 'Mens Shoe', '25.00', 1, '2', 10, '/dream_shops/images/products/023f69b1bd21f7c0415be104b18733b5.jpeg', 'Men&#039;s Shoe', 1, 'Small:12,Medium:15', 0),
(7, 'Tigre Snicker', '45.00', 1, '2', 11, '/dream_shops/images/products/eb9295b6ad19cadb970dc3e84e6cc851.jpeg', 'Tigre moon sneakers.', 1, '6:12', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `review_author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `review` text COLLATE utf8_unicode_ci NOT NULL,
  `featured` int(11) NOT NULL DEFAULT '0',
  `archived` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `review_author`, `author_email`, `review`, `featured`, `archived`) VALUES
(1, 'Thulani Tembo', 'tembothulani@gmail.com', 'vvvvvvvvvvvvvvvvvvvvvvvvvvvxxzz', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `grand_total` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `customer_name`, `transaction_id`, `grand_total`, `date`) VALUES
(6, 'Lani Tutu', 'OESN6GWD', 10.5, '2017-12-09'),
(7, 'Thulani Tembo', 'OES84283', 462, '2017-12-09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(180) NOT NULL,
  `password` varchar(255) NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `permissions` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `join_date`, `last_login`, `permissions`) VALUES
(1, 'Thulani Tembo', 'tembothulani@gmail.com', '$2y$10$A8B2bkx0UUDHVjXNGfDuCue3t3xesygfRccB2vKWir79x.0j0x.6W', '2017-05-16 21:05:48', '2017-12-14 00:03:40', 'admin,editor'),
(6, 'Sibongile', 'sibongile@yahoo.com', '$2y$10$37fujYv03Babfx4Ogn9xgesvUb1070Z4QUGtzz1nhpjS5zLSmAanO', '2017-05-19 00:05:27', '2017-05-24 22:36:07', 'editor'),
(7, 'admin', 'admin@admin.com', '$2y$10$b7c7O21YyoroaZNUfnCixee/bGLryQRy5BXRsWDcFtyIGFlywJ/bu', '2017-12-14 00:12:04', '0000-00-00 00:00:00', 'editor,admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adverts`
--
ALTER TABLE `adverts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adverts`
--
ALTER TABLE `adverts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
