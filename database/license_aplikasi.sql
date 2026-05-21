-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2026 at 10:08 AM
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
-- Database: `license_aplikasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `amount` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `product_id`, `payment_date`, `amount`) VALUES
(8, 73, '2026-05-20', 0),
(9, 74, '2026-05-20', 0),
(10, 75, '2026-05-30', 25500000),
(11, 75, '2026-05-26', 50000000),
(15, 76, '2026-05-22', 2500000),
(16, 76, '2026-05-23', 5000000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `order_date` date NOT NULL,
  `harga_order` bigint(20) NOT NULL,
  `payment_status` enum('done') NOT NULL,
  `payment_date` date NOT NULL,
  `request_count` int(11) NOT NULL,
  `departemen` varchar(255) NOT NULL,
  `agreement_number` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `application_name` varchar(100) NOT NULL,
  `email_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `username`, `order_date`, `harga_order`, `payment_status`, `payment_date`, `request_count`, `departemen`, `agreement_number`, `foto`, `application_name`, `email_name`) VALUES
(17, 'Wenny', '2027-02-27', 0, 'done', '0000-00-00', 0, 'AMT System', 'FEB92FB8783C266D555A', 'IMG_1779336857_6a0e8699e3985.jpg', '', ''),
(18, 'Hamzah', '2027-02-27', 0, 'done', '0000-00-00', 0, 'Accounting', 'FEB92FB8783C266D555A', 'IMG_1779336697_6a0e85f9157b1.jpg', '', ''),
(19, 'Agus Sudarsono', '2027-02-27', 0, 'done', '0000-00-00', 0, 'Finance & Treasury', 'FEB92FB8783C266D555A', 'IMG_1779336963_6a0e8703efb24.jpg', '', ''),
(20, 'Akbar', '2027-02-27', 0, 'done', '0000-00-00', 0, 'Accounting', 'FEB92FB8783C266D555A', 'IMG_1779336741_6a0e86253b744.jpg', '', ''),
(21, 'Yudiar', '2027-01-06', 0, 'done', '0000-00-00', 0, 'Commercial Contract', '67C221202125952F229A', 'IMG_1779337208_6a0e87f865c7f.jpg', '', ''),
(22, 'Bima Aji', '2026-10-04', 0, 'done', '0000-00-00', 0, 'Marketing Dev', 'B73B346A7A5400A9DB1A', '', '', ''),
(23, 'Pak Zahirman', '2026-06-30', 0, 'done', '0000-00-00', 0, 'Inf Tech', '8B8471A577DB0A903BFA', 'IMG_1779339050_6a0e8f2a773ea.jpg', '', ''),
(24, 'Paramitha', '2026-06-30', 0, 'done', '0000-00-00', 0, 'Mining Sales Department', '8B8471A577DB0A903BFA', 'IMG_1779339064_6a0e8f388f3ed.jpg', '', ''),
(25, 'Supriyadi', '2026-08-10', 0, 'done', '0000-00-00', 0, 'Technical Support', '61C71633310E10620D0A', 'IMG_1779337912_6a0e8ab851311.jpg', '', ''),
(26, 'Sugiyono', '2026-12-15', 0, 'done', '0000-00-00', 0, 'Training Center Balikpapan', '506BBEBE70FC7D8FAD9A', 'IMG_1779337790_6a0e8a3e5432d.jpg', '', ''),
(27, 'Sudiryono', '2026-12-15', 0, 'done', '0000-00-00', 0, 'Training Center Balikpapan', '506BBEBE70FC7D8FAD9A', 'IMG_1779337799_6a0e8a47a72ae.jpg', '', ''),
(28, 'Pak Kiky', '2026-12-15', 0, 'done', '0000-00-00', 0, 'Inf Tech Development', '67C221202125952F229A', 'IMG_1779337685_6a0e89d52572a.jpg', '', ''),
(29, 'Dwi swasono', '2026-12-30', 0, 'done', '0000-00-00', 0, 'BOD', 'EF35658F04DEF1C288DA', 'IMG_1779337550_6a0e894e95da6.jpg', '', ''),
(30, 'Rusli', '2027-01-02', 0, 'done', '0000-00-00', 0, 'Training Center Balikpapan', 'EF35658F04DEF1C288DA', 'IMG_1779337428_6a0e88d493e9a.jpg', '', ''),
(31, 'Anong', '2027-01-02', 0, 'done', '0000-00-00', 0, 'Training Center Balikpapan', 'EF35658F04DEF1C288DA', 'IMG_1779337444_6a0e88e48732d.jpg', '', ''),
(32, 'Wijanorko', '2027-01-02', 0, 'done', '0000-00-00', 0, 'Training Center Balikpapan', 'EF35658F04DEF1C288DA', 'IMG_1779337453_6a0e88edcfaf4.jpg', '', ''),
(33, 'Yudsar', '2027-01-06', 0, 'done', '0000-00-00', 0, 'Commercial Contract', '67C221202125952F229A', 'IMG_1779337241_6a0e8819069c1.jpg', '', ''),
(78, 'ws', '2026-06-30', 0, 'done', '0000-00-00', 0, 'Mining Sales Department', '34245464', '', 'ADOBA ACCROBAT', 'SS@GMAIL.COM');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`) VALUES
(6, 'deni', 'deni@gmail.com', '$2y$10$btCdLWetZM/iaJl2Xw7jmuDpDKDEZ8kiITABqaf6R1v.6ys0PLJtq'),
(7, 'biyaw', 'BiyaCantikSukses@gmail.com', '$2y$10$lxuEraF6.Hbo61Oq0.4Nfey4Nhijt27ct7/I09ePRe3bt.RRUv8Uq'),
(10, 'ara', 'ara@gmail.com', '$2y$10$bXBFLE/qJyCeNsjuqgs2MekaUsg2eEQTPq4ddDy/UVrmEZ.OILhVO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
