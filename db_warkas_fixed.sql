-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2026 at 06:53 AM
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
-- Database: `db_warkas`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'MIE'),
(2, 'SUSU'),
(3, 'KOPI'),
(4, 'ES'),
(5, 'SABUN'),
(6, 'BUMBU DAPUR'),
(7, 'CHIKI & BISKUIT');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_type` enum('in','out','adjust') NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`inventory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `product_id`, `user_id`, `transaction_type`, `quantity`, `description`, `created_at`) VALUES
(1, 98, 57, 'in', 10, 'Masuk dari Pembelian ID #1', '2026-01-04 19:50:38'),
(2, 98, 57, 'out', 5, 'Penjualan Kasir Nota #202601041', '2026-01-04 23:25:54'),
(3, 98, 57, 'out', 2, 'Penjualan Kasir Nota #202601051', '2026-01-05 14:01:04'),
(4, 98, 57, 'out', 2, 'Penjualan Kasir Nota #202601052', '2026-01-05 14:44:41'),
(5, 1, 57, 'in', 10, 'Masuk dari Pembelian ID #2', '2026-01-05 14:52:00'),
(6, 22, 57, 'in', 10, 'Masuk dari Pembelian ID #2', '2026-01-05 14:52:53'),
(7, 21, 57, 'in', 10, 'Masuk dari Pembelian ID #3', '2026-01-05 15:10:27'),
(8, 24, 1, 'in', 12, 'Masuk dari Pembelian ID #4', '2026-01-12 12:37:47'),
(9, 25, 1, 'in', 12, 'Masuk dari Pembelian ID #4', '2026-01-12 12:38:04'),
(10, 6, 1, 'in', 3500, 'Masuk dari Pembelian ID #4', '2026-01-12 12:38:39'),
(11, 6, 1, 'adjust', -3488, 'Edit Pembelian ID #4 (Qty 3500 -> 12)', '2026-01-12 12:39:00'),
(12, 6, 1, 'adjust', 0, 'Edit Pembelian ID #4 (Qty 12 -> 12)', '2026-01-12 12:39:01'),
(13, 6, 1, 'adjust', 0, 'Edit Pembelian ID #4 (Qty 12 -> 12)', '2026-01-12 12:39:01'),
(14, 6, 1, 'adjust', 0, 'Edit Pembelian ID #4 (Qty 12 -> 12)', '2026-01-12 12:39:01'),
(15, 6, 1, 'adjust', 0, 'Edit Pembelian ID #4 (Qty 12 -> 12)', '2026-01-12 12:39:01'),
(16, 6, 1, 'adjust', 0, 'Edit Pembelian ID #4 (Qty 12 -> 12)', '2026-01-12 12:39:01'),
(17, 1, 57, 'out', 1, 'Penjualan Kasir Nota #202601121', '2026-01-12 12:52:24'),
(18, 24, 57, 'out', 2, 'Penjualan Kasir Nota #202601121', '2026-01-12 12:52:24'),
(19, 6, 57, 'out', 2, 'Penjualan Kasir Nota #202601121', '2026-01-12 12:52:24');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `purchase_price` decimal(12,2) DEFAULT NULL,
  `selling_price` decimal(12,2) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `product_img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `unit_id`, `product_name`, `purchase_price`, `selling_price`, `stock`, `product_img`) VALUES
(1, 1, 1, 'Indomie Ayam Bawang', 3000.00, 3500.00, 9, '1767512426_c76cdb39a95273298293.jpg'),
(2, 1, 1, 'Indomie Goreng', 3000.00, 3500.00, 0, '1767512475_07ff297a567d1ed3ea42.jpg'),
(3, 1, 1, 'Indomie Soto', 3000.00, 3500.00, 0, '1767512514_4fbb3999699f585e37c8.jpg'),
(4, 1, 1, 'Indomie Kari', 3000.00, 3500.00, 0, '1767512558_17e848d618b3aba626e2.jpg'),
(5, 1, 1, 'Indomie Aceh', 3000.00, 3500.00, 0, '1767512594_f4e0b5d7fc209e4e5ee5.jpg'),
(6, 1, 1, 'Indomie Rendang', 3000.00, 3500.00, 10, '1767512638_97164e9ee3c1f09b0249.jpg'),
(7, 1, 2, 'Sarimie Gelas', 1000.00, 1500.00, 0, '1767512700_d19188029fcbf72fe6e2.jpg'),
(8, 1, 1, 'Sakura Goreng', 1700.00, 2000.00, 0, '1767512768_f173b47ae64da56851b2.jpg'),
(9, 1, 1, 'Sakura Seblak', 1700.00, 2500.00, 0, '1767512803_3b6355d5b60169b96585.jpg'),
(10, 1, 1, 'Spageti Wow Carbonara', 3500.00, 4000.00, 0, '1767512836_828f9173325d9a0524d6.jpg'),
(11, 1, 1, 'Spageti Wow Aglio Olio', 4000.00, 3500.00, 0, '1767512869_21e1951ca85bfde7fa50.jpg'),
(12, 1, 1, 'Spageti Wow Bolognese', 3500.00, 4000.00, 0, '1767512898_171b7ab63874ed40febc.jpg'),
(13, 1, 1, 'Pop spageti Bolognese', 3500.00, 4000.00, 0, '1767512923_05e5a6c3e85a411f2154.jpg'),
(14, 1, 1, 'Pop spageti Spicy Carbonara', 3500.00, 4000.00, 0, '1767512968_08fe6ad1f09024e16673.jpg'),
(15, 1, 1, 'Pop Mie', 4500.00, 5000.00, 0, '1767512997_e6c59e8b0c231250bb09.jpg'),
(16, 2, 2, 'Milo', 2000.00, 2500.00, 0, '1767513061_357071324921435fbd71.jpg'),
(17, 2, 2, 'Champion', 1800.00, 2000.00, 0, '1767513130_7f98bad3fe0978eb2eda.jpg'),
(18, 2, 2, 'Frisian Flag Kental Manis', 1500.00, 2000.00, 0, '1767513204_4b3cb985dd38a8ffbe6d.jpg'),
(19, 2, 2, 'Frisian Flag Coklat', 1500.00, 2000.00, 0, '1767513240_76b9f0192103af913067.jpg'),
(20, 3, 2, 'Kopi Kapal Api Mix', 1800.00, 2000.00, 0, '1767513276_2bc9ef7824c0dc9c22fb.jpg'),
(21, 3, 2, 'Kopi Kapal Api Mix Kecil', 2000.00, 3000.00, 10, '1767600875_2a3cc80717fdb54d50d5.jpg'),
(22, 3, 2, 'Kopi ABC susu', 1800.00, 2000.00, 10, '1767513344_acd1919cded55f77240d.jpg'),
(23, 3, 2, 'Good day Cappucino', 2200.00, 2500.00, 0, '1767513446_32ef66c05a8d5f8980b9.jpg'),
(24, 3, 2, 'Good Day Freeze', 2800.00, 3000.00, 10, '1767513487_149e540b2ad42993b956.jpg'),
(25, 3, 2, 'Good day Mocacino', 1600.00, 2000.00, 12, '1767513574_8b8eb4422538c70279e3.jpg'),
(26, 3, 2, 'Good day Vanilla late', 1600.00, 2000.00, 0, '1767514102_7577ece0eaf4749cd011.jpg'),
(27, 3, 2, 'Indocafe Mix', 1800.00, 2000.00, 0, '1767514207_1c88a7b5310a9d9b1076.jpg'),
(28, 3, 2, 'Luwak White Coffe', 1800.00, 2000.00, 0, '1767514239_440c99bdb17e9d89e6d2.jpg'),
(29, 3, 2, 'Tora bika Creamy Latte', 1800.00, 2000.00, 0, '1767514283_4a38af0810b97f167240.jpg'),
(30, 3, 2, 'AMH Jahe Merah', 1000.00, 1500.00, 0, '1767514327_e8cf93cf55cba36fde04.jpg'),
(31, 3, 2, 'Anget Sari Susu Jahe', 1000.00, 1500.00, 0, '1767514372_16fcd18083b6dd5d5cbd.jpg'),
(32, 3, 2, 'Good Day Late Butter', 1800.00, 2000.00, 0, '1767514427_39613a11db22bc21c885.jpg'),
(33, 3, 2, 'Good Day Latte Original', 1800.00, 2000.00, 0, '1767514476_69c536b00e2afcc4ff34.jpg'),
(34, 4, 2, 'Tea Jus Gula Batu', 350.00, 1000.00, 0, '1767514546_efbebf14e988ac18ab95.jpg'),
(35, 4, 2, 'Tea Jus Lemon', 350.00, 1000.00, 0, '1767514578_44bd2371ebb55c8856da.jpg'),
(36, 4, 2, 'Tea Jus Apel', 350.00, 1000.00, 0, '1767514608_1102f25770635b5706ec.jpg'),
(37, 4, 2, 'Tea Jus Melati', 350.00, 1000.00, 0, '1767514635_291aeb77491f2e2e9844.jpg'),
(38, 4, 2, 'Tea Jus Madu', 350.00, 1000.00, 0, '1767514691_02600e0e100281bb8a9d.jpg'),
(39, 4, 2, 'Top Ice Strawberry', 350.00, 1000.00, 0, '1767514718_c4ed731573fa14270510.jpg'),
(40, 4, 2, 'Top Ice Coklat', 350.00, 1000.00, 0, '1767514743_c50b362c9da23d991607.jpg'),
(41, 4, 2, 'Top Ice Cappuccino', 350.00, 1000.00, 0, '1767514794_bfa9150676b45f89e98f.jpg'),
(43, 4, 2, 'Top Ice Vanilla', 350.00, 1000.00, 0, '1767514873_d4cb548ddbcabe3e76f9.jpg'),
(44, 4, 2, 'Teh Sisri Cincau', 350.00, 1000.00, 0, '1767515010_d351c87e5d5972164332.jpg'),
(45, 4, 2, 'Jasjus Mangga', 350.00, 1000.00, 0, '1767515042_0894c068235a303e7965.jpg'),
(46, 4, 2, 'Jasjus Jeruk Peras', 350.00, 1000.00, 0, '1767515081_3eb4fa0c2a7b64024a70.jpg'),
(47, 4, 2, 'Jasjus Jambu', 350.00, 1000.00, 0, '1767515111_0dcc201fc8d922cb3611.jpg'),
(48, 4, 2, 'Jasjus Anggur', 350.00, 1000.00, 0, '1767515150_c72d8b3139229d39eacc.jpg'),
(49, 4, 2, 'Jasjus Leci', 350.00, 1000.00, 0, '1767515189_fed744049dcbcea8eb95.jpg'),
(50, 4, 2, 'Jasjus Kelapa Muda', 350.00, 1000.00, 0, '1767515242_633379b085f71675743c.jpg'),
(51, 4, 2, 'Pop Ice Strawberry', 1300.00, 2000.00, 0, '1767515282_3ea57739484d1e25b73f.jpg'),
(52, 4, 2, 'Pop Ice Mangga', 1300.00, 2000.00, 0, '1767515318_8507c1cd9b7d2cab57b4.jpg'),
(53, 4, 2, 'Pop Ice Permen Karet', 1300.00, 2000.00, 0, '1767515349_481db896937039f58978.jpg'),
(54, 4, 2, 'Pop Ice Taro', 1300.00, 2000.00, 0, '1767515400_d2de478f5c55d16ba5ee.jpg'),
(55, 4, 2, 'Pop Ice Chocolate', 1300.00, 2000.00, 0, '1767515447_3bb57016c5c7fb8540e4.jpg'),
(56, 4, 2, 'Pop Ice Vanilla Blue', 1300.00, 2000.00, 0, '1767515491_3b1600f98a83a1e89214.jpg'),
(57, 4, 2, 'Nutrisari Sweet Orange', 1300.00, 2000.00, 0, '1767515531_411919331345ff4bee07.jpg'),
(58, 4, 2, 'Nutrisari Markisa', 1300.00, 2000.00, 0, '1767515568_820d0a37b10aed75ab6d.jpg'),
(59, 4, 2, 'Nutrisari Blewah', 1300.00, 2000.00, 0, '1767515604_31030641c09eeb68d5db.jpg'),
(60, 5, 3, 'Soklin Cair', 833.33, 1000.00, 0, '1767516593_c950a47e005a434ebe8f.png'),
(61, 5, 3, 'Downy 500', 416.66, 500.00, 0, '1767516730_f7b539fd7ab7e4e4aab4.png'),
(62, 5, 3, 'Downy 1000', 833.33, 1000.00, 0, '1767516802_b603a5e95ad1f74affb7.png'),
(63, 5, 3, 'Molto', 833.33, 1000.00, 0, '1767516844_15dd2795a6b23bb6ba05.png'),
(64, 5, 3, 'Rinso Cair', 833.33, 1000.00, 0, '1767516881_d2ce99ba1cc49d1ea220.png'),
(65, 5, 3, 'Soklin bubuk', 833.33, 1000.00, 0, '1767516930_292565836b41a9f61be3.png'),
(66, 5, 3, 'Daia Bubuk', 833.33, 1000.00, 0, '1767517009_afa091aa3c91dc533868.png'),
(67, 5, 3, 'Rinso bubuk', 833.33, 1000.00, 0, '1767517046_575f1afa9e1b8479b39d.png'),
(68, 5, 3, 'Jaz one bubuk', 833.33, 1000.00, 0, '1767517090_075646e6bdd6d067d144.png'),
(69, 5, 1, 'Sunlight', 1800.00, 2000.00, 0, '1767517125_f39988f3bae494d726ce.png'),
(70, 5, 1, 'Sabun Colek Ekonomi', 1800.00, 2000.00, 0, '1767517171_d20394672ff8edc85c63.png'),
(71, 6, 2, 'Royko Ayam', 208.33, 500.00, 0, '1767517244_44f881cabe4f55daa985.png'),
(72, 6, 2, 'Royko Sapi', 208.33, 500.00, 0, '1767517273_d63d3dd313c675d75011.jpg'),
(73, 6, 2, 'Masako Ayam', 208.33, 500.00, 0, '1767517302_20c7fe9fcd7d8c0220bf.jpg'),
(74, 6, 2, 'Masako Sapi', 208.33, 500.00, 0, '1767517430_6bbdebe082220cd65d40.png'),
(75, 6, 2, 'Ladaku Merica bubuk', 1400.00, 1500.00, 0, '1767517732_45c4452ff184d7e90da5.png'),
(76, 6, 2, 'Bawang putih Halus', 833.33, 1000.00, 0, '1767517883_baf40d1cb45992c1de94.jpg'),
(77, 6, 4, 'Garam Halus', 1250.00, 2000.00, 0, '1767517947_0e559d304b07ec3eb4ea.png'),
(78, 6, 4, 'Garam Kasar', 1250.00, 2000.00, 0, '1767518005_161895d4413dcf69a946.png'),
(79, 6, 2, 'Kecap', 916.66, 1000.00, 0, '1767518089_32f209a9d72ab3cfff91.png'),
(81, 6, 2, 'Saos ABC', 800.00, 1000.00, 0, '1767518203_23efe4f2df69b243d43c.png'),
(82, 6, 2, 'Sambel Terasi', 1800.00, 2000.00, 0, '1767518242_8d98abcb5fc2cef3ad69.png'),
(83, 7, 1, 'Nabati', 1800.00, 2000.00, 0, '1767518290_136ea8d7155d756f8d3b.png'),
(84, 7, 4, 'Malkist', 900.00, 1000.00, 0, '1767518404_3e580d14c0eacfe28b5e.png'),
(85, 7, 4, 'Regal', 900.00, 1000.00, 0, '1767518442_962162e109172698842b.png'),
(86, 7, 4, 'Sagu Keju', 450.00, 500.00, 0, '1767518504_14442a79f866c431e98e.png'),
(87, 7, 4, 'Goriorio', 450.00, 500.00, 0, '1767518541_a0ff393631cd619b0cbd.png'),
(88, 7, 4, 'Wafello', 900.00, 1000.00, 0, '1767518581_6a14b16ffaf0dac6fe85.png'),
(89, 7, 4, 'Tanggo', 900.00, 1000.00, 0, '1767518616_045b98e1bb2c3e1c4ea9.png'),
(90, 7, 5, 'Tricks', 900.00, 1000.00, 0, '1767518654_9b5248f1b703013ab0cc.png'),
(91, 7, 2, 'Tiniwinibiti', 900.00, 1000.00, 0, '1767518690_4409f8fb6e7d3038399f.png'),
(92, 7, 4, 'Tic-Tac', 900.00, 1000.00, 0, '1767518748_d54512e0928235a3b49c.png'),
(93, 7, 4, 'Sukro', 900.00, 1000.00, 0, '1767518777_7b39ebb766d4bac1c807.png'),
(94, 7, 2, 'Spix Mie Goreng', 900.00, 1000.00, 0, '1767518815_94dee29af3946785b4bf.png'),
(95, 7, 2, 'Enaak Original', 900.00, 1000.00, 0, '1767518879_3e04c41581f0d418c5e0.png'),
(96, 7, 2, 'Enaak Pedas', 900.00, 1000.00, 0, '1767518925_ad581b67335b52e18945.png'),
(97, 7, 5, 'Dilan Waffel', 1500.00, 2000.00, 0, '1767518976_aab8f77ec740c4f5950a.png'),
(98, 7, 5, 'Bolu Bonita', 1500.00, 2000.00, 1, '1767527796_219fbba1f0de35aa9a15.png'),
(99, 7, 2, 'Taro', 900.00, 1000.00, 0, '1767519058_a8d26f181d73777f7223.png'),
(101, 7, 2, 'Rinbie', 900.00, 1000.00, 0, '1767519167_0a49b37ab2375f20e7e0.png'),
(102, 7, 2, 'Chiki Gerry', 900.00, 1000.00, 0, '1767519218_b9f51e2281aa2e192c5d.png'),
(103, 7, 2, 'Chitato lite', 1800.00, 2000.00, 0, '1767519371_f8893dcd71c475133934.jpg'),
(104, 7, 2, 'Chitato BBQ', 1800.00, 2000.00, 0, '1767519441_3afa7bc4e5642ac95aeb.png'),
(105, 7, 2, 'Chiki kentang', 1800.00, 2000.00, 0, '1767519483_8559a073208aa6d225a5.png'),
(106, 7, 4, 'Kerupuk kemplang', 1666.66, 2000.00, 0, '1767519594_d2ef69821113cf61687f.png'),
(107, 7, 2, 'Jelly Inako', 900.00, 1000.00, 0, '1767519885_15d620e88e45c0c8cb42.jpg'),
(108, 7, 2, 'Permen Split', 750.00, 1000.00, 0, '1767519960_bab15ceb14fd8bfc3ab9.png'),
(109, 7, 4, 'Marshmellow karakter', 1000.00, 2000.00, 0, '1767520053_f66a4eeb6f5471c8ed78.png');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchase_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `purchase_date` datetime NOT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchase_id`, `user_id`, `purchase_date`, `total_amount`) VALUES
(1, 57, '2026-01-04 19:48:00', 15000.00),
(2, 57, '2026-01-05 14:50:00', 48000.00),
(3, 57, '2026-01-05 15:09:00', 20000.00),
(4, 1, '2026-01-12 12:36:00', 103200.00);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_detail`
--

CREATE TABLE `purchase_detail` (
  `purchase_detail_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  PRIMARY KEY (`purchase_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_detail`
--

INSERT INTO `purchase_detail` (`purchase_detail_id`, `purchase_id`, `product_id`, `price`, `quantity`, `subtotal`) VALUES
(1, 1, 98, 1500.00, 10, 15000.00),
(2, 2, 1, 3000.00, 10, 30000.00),
(3, 2, 22, 1800.00, 10, 18000.00),
(4, 3, 21, 2000.00, 10, 20000.00),
(5, 4, 24, 2800.00, 12, 33600.00),
(6, 4, 25, 2800.00, 12, 33600.00),
(7, 4, 6, 3000.00, 12, 36000.00);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `roles_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`roles_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roles_id`, `name`) VALUES
(1, 'owner'),
(2, 'kasir');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` bigint(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sales_date` datetime NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(12,2) DEFAULT 0.00,
  `amount_paid` decimal(12,2) DEFAULT 0.00,
  `cash_return` decimal(12,2) DEFAULT 0.00,
  `payment_method` enum('cash','hutang') NOT NULL,
  PRIMARY KEY (`sales_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `user_id`, `sales_date`, `total_amount`, `amount_paid`, `cash_return`, `payment_method`) VALUES
(202601041, 57, '2026-01-04 23:25:54', 10000.00, 10000.00, 0.00, 'cash'),
(202601051, 57, '2026-01-05 14:01:04', 4000.00, 5000.00, 1000.00, 'cash'),
(202601052, 57, '2026-01-05 14:44:41', 4000.00, 5000.00, 1000.00, 'cash'),
(202601121, 57, '2026-01-12 12:52:24', 16500.00, 20000.00, 3500.00, 'cash');

-- --------------------------------------------------------

--
-- Table structure for table `sales_detail`
--

CREATE TABLE `sales_detail` (
  `sales_detail_id` int(11) NOT NULL,
  `sales_id` bigint(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `current_capital` decimal(12,2) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  PRIMARY KEY (`sales_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_detail`
--

INSERT INTO `sales_detail` (`sales_detail_id`, `sales_id`, `product_id`, `current_capital`, `price`, `quantity`, `subtotal`) VALUES
(1, 202601041, 98, 1500.00, 2000.00, 5, 10000.00),
(2, 202601051, 98, 1500.00, 2000.00, 2, 4000.00),
(3, 202601052, 98, 1500.00, 2000.00, 2, 4000.00),
(4, 202601121, 1, 3000.00, 3500.00, 1, 3500.00),
(5, 202601121, 24, 2800.00, 3000.00, 2, 6000.00),
(6, 202601121, 6, 3000.00, 3500.00, 2, 7000.00);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(255) NOT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unit_id`, `unit_name`) VALUES
(1, 'PCS'),
(2, 'RENTENG'),
(3, 'LUSIN'),
(4, 'PACK'),
(5, 'BOX'),
(6, 'LITER');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `is_active` int(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `roles_id`, `user_name`, `password_hash`, `user_email`, `is_active`, `created_at`) VALUES
(1, 1, 'Dika', '$2y$10$aU/Qd6Qq50DZpFV.nHYKpuXMt0nFtHXenv9MosGk/P4sj06AR5eu.', 'owner@gmail.com', 1, '2025-12-24 10:23:38'),
(57, 2, 'Laura', '$2y$10$Jv26vQ/U8E2o2Ha2rnX5CeCo57yTBqsJvq8p028q8Q7FGpnvzxu.O', 'laura@gmail.com', 1, '2026-01-02 16:36:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--


--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD KEY `category_id` (`category_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `purchase`
--


--
-- Indexes for table `purchase_detail`
--
ALTER TABLE `purchase_detail`
  ADD KEY `purchase_id` (`purchase_id`);

--
-- Indexes for table `roles`
--


--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sales_detail`
--
ALTER TABLE `sales_detail`
  ADD KEY `sales_id` (`sales_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `units`
--


--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD KEY `roles_id` (`roles_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchase_detail`
--
ALTER TABLE `purchase_detail`
  MODIFY `purchase_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `roles_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales_detail`
--
ALTER TABLE `sales_detail`
  MODIFY `sales_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`);

--
-- Constraints for table `purchase_detail`
--
ALTER TABLE `purchase_detail`
  ADD CONSTRAINT `purchase_detail_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`purchase_id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `sales_detail`
--
ALTER TABLE `sales_detail`
  ADD CONSTRAINT `sales_detail_ibfk_1` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`sales_id`),
  ADD CONSTRAINT `sales_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`roles_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
