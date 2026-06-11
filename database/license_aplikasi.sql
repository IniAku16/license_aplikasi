-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2026 at 10:01 AM
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
(17, 'Wenny', '2027-02-27', 0, 'done', '0000-00-00', 0, 'AMT System', 'FEB92FB8783C266D555A', 'IMG_1779336857_6a0e8699e3985.jpg', 'ADOBE', ''),
(18, 'Hamzah', '2027-02-27', 0, 'done', '0000-00-00', 0, 'Accounting', 'FEB92FB8783C266D555A', 'IMG_1779336697_6a0e85f9157b1.jpg', 'ADOBE', ''),
(19, 'Agus Sudarsono', '2027-02-27', 0, 'done', '0000-00-00', 0, 'Finance & Treasury', 'FEB92FB8783C266D555A', 'IMG_1779336963_6a0e8703efb24.jpg', 'ADOBE', ''),
(20, 'Akbar', '2027-02-27', 0, 'done', '0000-00-00', 0, 'Accounting', 'FEB92FB8783C266D555A', 'IMG_1779336741_6a0e86253b744.jpg', 'ADOBE', ''),
(21, 'Yudiar', '2027-01-06', 0, 'done', '0000-00-00', 0, 'Commercial Contract', '67C221202125952F229A', 'IMG_1779337208_6a0e87f865c7f.jpg', 'ADOBE', ''),
(22, 'Bima Aji', '2026-10-04', 0, 'done', '0000-00-00', 0, 'Marketing Development', 'B73B346A7A5400A9DB1A', '', 'ADOBE', ''),
(23, 'Pak Zahirman', '2026-06-30', 0, 'done', '0000-00-00', 1, 'Inf Tech', '8B8471A577DB0A903BFA', 'IMG_1779339050_6a0e8f2a773ea.jpg', 'ADOBE', ''),
(24, 'Paramitha', '2026-06-30', 0, 'done', '0000-00-00', 1, 'Mining Sales & Wenco', '8B8471A577DB0A903BFA', 'IMG_1779339064_6a0e8f388f3ed.jpg', 'ADOBE', ''),
(25, 'Supriyadi', '2026-08-10', 0, 'done', '0000-00-00', 0, 'Tech Support', '61C71633310E10620D0A', 'IMG_1779337912_6a0e8ab851311.jpg', 'ADOBE', ''),
(26, 'Sugiyono', '2026-12-15', 0, 'done', '0000-00-00', 0, 'BPN Training Center', '506BBEBE70FC7D8FAD9A', 'IMG_1779337790_6a0e8a3e5432d.jpg', 'ADOBE', ''),
(27, 'Sudiryono', '2026-12-15', 0, 'done', '0000-00-00', 0, 'BPN Training Center', '506BBEBE70FC7D8FAD9A', 'IMG_1779337799_6a0e8a47a72ae.jpg', 'ADOBE', ''),
(28, 'Pak Kiky', '2026-12-15', 0, 'done', '0000-00-00', 0, 'Inf Tech', '67C221202125952F229A', 'IMG_1779337685_6a0e89d52572a.jpg', 'ADOBE', ''),
(29, 'Dwi swasono', '2026-12-30', 0, 'done', '0000-00-00', 0, 'Jakarta', 'EF35658F04DEF1C288DA', 'IMG_1779337550_6a0e894e95da6.jpg', 'ADOBE', ''),
(30, 'Rusli', '2027-01-02', 0, 'done', '0000-00-00', 0, 'BPN Training Center', 'EF35658F04DEF1C288DA', 'IMG_1779337428_6a0e88d493e9a.jpg', 'ADOBE', ''),
(31, 'Anong', '2027-01-02', 0, 'done', '0000-00-00', 0, 'BPN Training Center', 'EF35658F04DEF1C288DA', 'IMG_1779337444_6a0e88e48732d.jpg', 'ADOBE', ''),
(32, 'Wijanorko', '2027-01-02', 0, 'done', '0000-00-00', 0, 'BPN Training Center', 'EF35658F04DEF1C288DA', 'IMG_1779337453_6a0e88edcfaf4.jpg', 'ADOBE', ''),
(33, 'Yudsar', '2027-01-06', 0, 'done', '0000-00-00', 0, 'Commercial Contract', '67C221202125952F229A', 'IMG_1779337241_6a0e8819069c1.jpg', 'ADOBE', ''),
(92, 'Danang Nurdianjar', '2026-11-17', 0, 'done', '0000-00-00', 0, 'Coorplan', 'LCCDGSSUB11', '', 'CorelDraw Graphics Suite 2026', 'danang@hexindo-tbk.co.id'),
(104, 'BILLY SURYA', '2027-01-04', 0, 'done', '0000-00-00', 0, 'Jakarta', '-', 'IMG_1780970294_6a2773365e146.jpg', 'CANVA', 'qshehexindoho@gmail.com'),
(105, 'GA HO', '2026-07-15', 0, 'done', '0000-00-00', 0, 'Jakarta', '-', 'IMG_1780970431_6a2773bfb2fb8.jpg', 'CANVA', 'departementgaam@gmail.com'),
(106, 'KAMAL', '2027-04-27', 0, 'done', '0000-00-00', 0, 'Balikpapan', '-', 'IMG_1780970582_6a2774561c8a0.jpg', 'CANVA', 'qshebpn@gmail.com'),
(107, 'MURYA PUTRA', '2026-07-14', 0, 'done', '0000-00-00', 0, 'Jakarta', '-', 'IMG_1780970708_6a2774d4e9cd6.jpg', 'CANVA', 'murya@hexindo-tbk.co.id'),
(108, 'ZACHRA PUTRI', '2026-12-16', 0, 'done', '0000-00-00', 0, 'Jakarta', '-', 'IMG_1780970888_6a277588ae288.jpg', 'CANVA', 'media@hexindo-tbk.co.id, danangnurdianjar@hexindo-tbk.co.id,  sitaresmi@hexindo-tbk.co.id');

-- --------------------------------------------------------

--
-- Table structure for table `tb_branch`
--

CREATE TABLE `tb_branch` (
  `id_branch` int(11) NOT NULL,
  `nama_branch` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_branch`
--

INSERT INTO `tb_branch` (`id_branch`, `nama_branch`) VALUES
(1, 'Accounting'),
(2, 'Aceh'),
(3, 'Adaro'),
(4, 'AMNT Project'),
(5, 'AMT System'),
(6, 'AR Collection & Admin'),
(7, 'Banda Aceh'),
(8, 'Bandar Lampung'),
(9, 'Bandung'),
(10, 'Banjarmasin'),
(11, 'Balikpapan'),
(12, 'Balikpapan Project'),
(13, 'Batu Licin'),
(14, 'Bengalon'),
(15, 'Berau'),
(16, 'BPN Training Center'),
(17, 'Branch Sales Support'),
(18, 'Cilegon'),
(19, 'Commercial Contract'),
(20, 'Corp Sec'),
(21, 'Cor Plan & SMO'),
(22, 'Credit Analysis'),
(23, 'Direktur Expat'),
(24, 'Direktur Local'),
(25, 'Export Import'),
(26, 'Finance & Treasury'),
(27, 'Finance Adm'),
(28, 'Finance Balikpapan'),
(29, 'Finance Sangatta'),
(30, 'GA & Assets Management'),
(31, 'GA East & Project'),
(32, 'GAM Kaubun'),
(33, 'General Sales Support'),
(34, 'Gorontalo'),
(35, 'HC East & Project'),
(36, 'HC PA'),
(37, 'HC Recruitment & EPM'),
(38, 'Inf Tech'),
(39, 'Inad'),
(40, 'Jakarta'),
(41, 'Jambi'),
(42, 'Jayapura'),
(43, 'JKT Training Center'),
(44, 'Kendari'),
(45, 'Ketapang'),
(46, 'Kupang'),
(47, 'Legal'),
(48, 'Makassar'),
(49, 'Manado'),
(50, 'Marketing Development'),
(51, 'Medan'),
(52, 'Merak'),
(53, 'Merauke'),
(54, 'Mining Sales & Wenco'),
(55, 'Morowali'),
(56, 'Muara Bungo'),
(57, 'Muara Enim'),
(58, 'Muara Teweh'),
(59, 'NUES'),
(60, 'NUES Balikpapan'),
(61, 'Padang'),
(62, 'Palembang'),
(63, 'Palu'),
(64, 'Pangkal Pinang'),
(65, 'Pani Project'),
(66, 'Parts Inventory & System'),
(67, 'Parts Warehouse'),
(68, 'Parts Warehouse BPN'),
(69, 'Parts Warehouse SGT'),
(70, 'Pekanbaru'),
(71, 'Pontianak'),
(72, 'Procurement & Investment'),
(73, 'Project Sales Support'),
(74, 'PS Support'),
(75, 'QSHE'),
(76, 'QSHE Balikpapan'),
(77, 'Sales Adm'),
(78, 'Sales Planning'),
(79, 'Samarinda'),
(80, 'Samarinda Project'),
(81, 'Sampit'),
(82, 'Sangatta'),
(83, 'Semarang'),
(84, 'Service Admin'),
(85, 'Sims Kideco'),
(86, 'SIS Adaro'),
(87, 'Sorong'),
(88, 'Sungai Baung'),
(89, 'Surabaya'),
(90, 'Tarakan'),
(91, 'Tax'),
(92, 'Tech Support'),
(93, 'Tech Support (Mining)'),
(94, 'Tanjung Pandan'),
(95, 'Training Center'),
(96, 'Vale Soroako'),
(97, 'Value Chain Promotion'),
(98, 'Weda'),
(99, 'Welding SGT'),
(100, 'Welding SMO'),
(101, 'Wetar');

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
(6, 'deni', 'deni@gmail.com', '$2y$10$Yb5CFwOuoS0OQQOKcasATeGPqfKaYZOOAuMB1Xt8SGIsCWbDoHGMi'),
(11, 'Nabila', 'biya@gmail.com', '$2y$10$49Llh4pGDBZXrj1hrqbQFOGSrz/smmuQneVuCIx5FF77BvWOSR8UC');

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
-- Indexes for table `tb_branch`
--
ALTER TABLE `tb_branch`
  ADD PRIMARY KEY (`id_branch`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `tb_branch`
--
ALTER TABLE `tb_branch`
  MODIFY `id_branch` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
