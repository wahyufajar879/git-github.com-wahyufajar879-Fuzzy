-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2022 at 08:17 AM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penerimaankaryawan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `user` varchar(16) NOT NULL,
  `pass` varchar(16) NOT NULL,
  `level` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`user`, `pass`, `level`) VALUES
('admin', 'admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_alternatif`
--

CREATE TABLE `tb_alternatif` (
  `kode_alternatif` varchar(16) NOT NULL,
  `nama_alternatif` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `total` double NOT NULL,
  `rank` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_aturan`
--

CREATE TABLE `tb_aturan` (
  `id_aturan` int(11) NOT NULL,
  `no_aturan` int(11) DEFAULT NULL,
  `kode_kriteria` varchar(16) DEFAULT NULL,
  `operator` varchar(16) DEFAULT NULL,
  `kode_himpunan` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_aturan`
--

INSERT INTO `tb_aturan` (`id_aturan`, `no_aturan`, `kode_kriteria`, `operator`, `kode_himpunan`) VALUES
(1, 1, 'C01', 'AND', 'C01-01'),
(2, 1, 'C02', 'AND', 'C02-01'),
(3, 1, 'C03', 'AND', 'C03-01'),
(4, 1, 'C04', 'AND', 'C04-01'),
(5, 2, 'C01', 'AND', 'C01-01'),
(6, 2, 'C02', 'AND', 'C02-01'),
(7, 2, 'C03', 'AND', 'C03-02'),
(8, 2, 'C04', 'AND', 'C04-02'),
(9, 3, 'C01', 'AND', 'C01-01'),
(10, 3, 'C02', 'AND', 'C02-01'),
(11, 3, 'C03', 'AND', 'C03-03'),
(12, 3, 'C04', 'AND', 'C04-02'),
(13, 4, 'C01', 'AND', 'C01-01'),
(14, 4, 'C02', 'AND', 'C02-01'),
(15, 4, 'C03', 'AND', 'C03-04'),
(16, 4, 'C04', 'AND', 'C04-02'),
(17, 5, 'C01', 'AND', 'C01-01'),
(18, 5, 'C02', 'AND', 'C02-02'),
(19, 5, 'C03', 'AND', 'C03-01'),
(20, 5, 'C04', 'AND', 'C04-01'),
(21, 6, 'C01', 'AND', 'C01-01'),
(22, 6, 'C02', 'AND', 'C02-02'),
(23, 6, 'C03', 'AND', 'C03-02'),
(24, 6, 'C04', 'AND', 'C04-01'),
(25, 7, 'C01', 'AND', 'C01-01'),
(26, 7, 'C02', 'AND', 'C02-02'),
(27, 7, 'C03', 'AND', 'C03-03'),
(28, 7, 'C04', 'AND', 'C04-02'),
(29, 8, 'C01', 'AND', 'C01-01'),
(30, 8, 'C02', 'AND', 'C02-02'),
(31, 8, 'C03', 'AND', 'C03-04'),
(32, 8, 'C04', 'AND', 'C04-01'),
(33, 9, 'C01', 'AND', 'C01-01'),
(34, 9, 'C02', 'AND', 'C02-03'),
(35, 9, 'C03', 'AND', 'C03-01'),
(36, 9, 'C04', 'AND', 'C04-01'),
(37, 10, 'C01', 'AND', 'C01-01'),
(38, 10, 'C02', 'AND', 'C02-03'),
(39, 10, 'C03', 'AND', 'C03-02'),
(40, 10, 'C04', 'AND', 'C04-02'),
(41, 11, 'C01', 'AND', 'C01-01'),
(42, 11, 'C02', 'AND', 'C02-03'),
(43, 11, 'C03', 'AND', 'C03-03'),
(44, 11, 'C04', 'AND', 'C04-01'),
(45, 12, 'C01', 'AND', 'C01-01'),
(46, 12, 'C02', 'AND', 'C02-03'),
(47, 12, 'C03', 'AND', 'C03-04'),
(48, 12, 'C04', 'AND', 'C04-01'),
(49, 13, 'C01', 'AND', 'C01-02'),
(50, 13, 'C02', 'AND', 'C02-01'),
(51, 13, 'C03', 'AND', 'C03-01'),
(52, 13, 'C04', 'AND', 'C04-02'),
(53, 14, 'C01', 'AND', 'C01-02'),
(54, 14, 'C02', 'AND', 'C02-01'),
(55, 14, 'C03', 'AND', 'C03-02'),
(56, 14, 'C04', 'AND', 'C04-02'),
(57, 15, 'C01', 'AND', 'C01-02'),
(58, 15, 'C02', 'AND', 'C02-01'),
(59, 15, 'C03', 'AND', 'C03-03'),
(60, 15, 'C04', 'AND', 'C04-01'),
(61, 16, 'C01', 'AND', 'C01-02'),
(62, 16, 'C02', 'AND', 'C02-01'),
(63, 16, 'C03', 'AND', 'C03-04'),
(64, 16, 'C04', 'AND', 'C04-02'),
(65, 17, 'C01', 'AND', 'C01-02'),
(66, 17, 'C02', 'AND', 'C02-02'),
(67, 17, 'C03', 'AND', 'C03-01'),
(68, 17, 'C04', 'AND', 'C04-01'),
(69, 18, 'C01', 'AND', 'C01-02'),
(70, 18, 'C02', 'AND', 'C02-02'),
(71, 18, 'C03', 'AND', 'C03-02'),
(72, 18, 'C04', 'AND', 'C04-01'),
(73, 19, 'C01', 'AND', 'C01-02'),
(74, 19, 'C02', 'AND', 'C02-02'),
(75, 19, 'C03', 'AND', 'C03-03'),
(76, 19, 'C04', 'AND', 'C04-01'),
(77, 20, 'C01', 'AND', 'C01-02'),
(78, 20, 'C02', 'AND', 'C02-02'),
(79, 20, 'C03', 'AND', 'C03-04'),
(80, 20, 'C04', 'AND', 'C04-02'),
(81, 21, 'C01', 'AND', 'C01-02'),
(82, 21, 'C02', 'AND', 'C02-03'),
(83, 21, 'C03', 'AND', 'C03-01'),
(84, 21, 'C04', 'AND', 'C04-02'),
(85, 22, 'C01', 'AND', 'C01-02'),
(86, 22, 'C02', 'AND', 'C02-03'),
(87, 22, 'C03', 'AND', 'C03-02'),
(88, 22, 'C04', 'AND', 'C04-02'),
(89, 23, 'C01', 'AND', 'C01-02'),
(90, 23, 'C02', 'AND', 'C02-03'),
(91, 23, 'C03', 'AND', 'C03-03'),
(92, 23, 'C04', 'AND', 'C04-02'),
(93, 24, 'C01', 'AND', 'C01-02'),
(94, 24, 'C02', 'AND', 'C02-03'),
(95, 24, 'C03', 'AND', 'C03-04'),
(96, 24, 'C04', 'AND', 'C04-02'),
(97, 25, 'C01', 'AND', 'C01-03'),
(98, 25, 'C02', 'AND', 'C02-01'),
(99, 25, 'C03', 'AND', 'C03-01'),
(100, 25, 'C04', 'AND', 'C04-02'),
(101, 26, 'C01', 'AND', 'C01-03'),
(102, 26, 'C02', 'AND', 'C02-01'),
(103, 26, 'C03', 'AND', 'C03-02'),
(104, 26, 'C04', 'AND', 'C04-01'),
(105, 27, 'C01', 'AND', 'C01-03'),
(106, 27, 'C02', 'AND', 'C02-01'),
(107, 27, 'C03', 'AND', 'C03-03'),
(108, 27, 'C04', 'AND', 'C04-02'),
(109, 28, 'C01', 'AND', 'C01-03'),
(110, 28, 'C02', 'AND', 'C02-01'),
(111, 28, 'C03', 'AND', 'C03-04'),
(112, 28, 'C04', 'AND', 'C04-01'),
(113, 29, 'C01', 'AND', 'C01-03'),
(114, 29, 'C02', 'AND', 'C02-02'),
(115, 29, 'C03', 'AND', 'C03-01'),
(116, 29, 'C04', 'AND', 'C04-02'),
(117, 30, 'C01', 'AND', 'C01-03'),
(118, 30, 'C02', 'AND', 'C02-02'),
(119, 30, 'C03', 'AND', 'C03-02'),
(120, 30, 'C04', 'AND', 'C04-01'),
(121, 31, 'C01', 'AND', 'C01-03'),
(122, 31, 'C02', 'AND', 'C02-02'),
(123, 31, 'C03', 'AND', 'C03-03'),
(124, 31, 'C04', 'AND', 'C04-01'),
(125, 32, 'C01', 'AND', 'C01-03'),
(126, 32, 'C02', 'AND', 'C02-02'),
(127, 32, 'C03', 'AND', 'C03-04'),
(128, 32, 'C04', 'AND', 'C04-02'),
(129, 33, 'C01', 'AND', 'C01-03'),
(130, 33, 'C02', 'AND', 'C02-03'),
(131, 33, 'C03', 'AND', 'C03-01'),
(132, 33, 'C04', 'AND', 'C04-02'),
(133, 34, 'C01', 'AND', 'C01-03'),
(134, 34, 'C02', 'AND', 'C02-03'),
(135, 34, 'C03', 'AND', 'C03-02'),
(136, 34, 'C04', 'AND', 'C04-02'),
(137, 35, 'C01', 'AND', 'C01-03'),
(138, 35, 'C02', 'AND', 'C02-03'),
(139, 35, 'C03', 'AND', 'C03-03'),
(140, 35, 'C04', 'AND', 'C04-01'),
(141, 36, 'C01', 'AND', 'C01-03'),
(142, 36, 'C02', 'AND', 'C02-03'),
(143, 36, 'C03', 'AND', 'C03-04'),
(144, 36, 'C04', 'AND', 'C04-01'),
(145, 37, 'C01', 'AND', 'C01-04'),
(146, 37, 'C02', 'AND', 'C02-01'),
(147, 37, 'C03', 'AND', 'C03-01'),
(148, 37, 'C04', 'AND', 'C04-02'),
(149, 38, 'C01', 'AND', 'C01-04'),
(150, 38, 'C02', 'AND', 'C02-01'),
(151, 38, 'C03', 'AND', 'C03-02'),
(152, 38, 'C04', 'AND', 'C04-02'),
(153, 39, 'C01', 'AND', 'C01-04'),
(154, 39, 'C02', 'AND', 'C02-01'),
(155, 39, 'C03', 'AND', 'C03-03'),
(156, 39, 'C04', 'AND', 'C04-01'),
(157, 40, 'C01', 'AND', 'C01-04'),
(158, 40, 'C02', 'AND', 'C02-01'),
(159, 40, 'C03', 'AND', 'C03-04'),
(160, 40, 'C04', 'AND', 'C04-02'),
(161, 41, 'C01', 'AND', 'C01-04'),
(162, 41, 'C02', 'AND', 'C02-02'),
(163, 41, 'C03', 'AND', 'C03-01'),
(164, 41, 'C04', 'AND', 'C04-02'),
(165, 42, 'C01', 'AND', 'C01-04'),
(166, 42, 'C02', 'AND', 'C02-02'),
(167, 42, 'C03', 'AND', 'C03-02'),
(168, 42, 'C04', 'AND', 'C04-02'),
(169, 43, 'C01', 'AND', 'C01-04'),
(170, 43, 'C02', 'AND', 'C02-02'),
(171, 43, 'C03', 'AND', 'C03-03'),
(172, 43, 'C04', 'AND', 'C04-02'),
(173, 44, 'C01', 'AND', 'C01-04'),
(174, 44, 'C02', 'AND', 'C02-02'),
(175, 44, 'C03', 'AND', 'C03-04'),
(176, 44, 'C04', 'AND', 'C04-01'),
(177, 45, 'C01', 'AND', 'C01-04'),
(178, 45, 'C02', 'AND', 'C02-03'),
(179, 45, 'C03', 'AND', 'C03-01'),
(180, 45, 'C04', 'AND', 'C04-01'),
(181, 46, 'C01', 'AND', 'C01-04'),
(182, 46, 'C02', 'AND', 'C02-03'),
(183, 46, 'C03', 'AND', 'C03-02'),
(184, 46, 'C04', 'AND', 'C04-02'),
(185, 47, 'C01', 'AND', 'C01-04'),
(186, 47, 'C02', 'AND', 'C02-03'),
(187, 47, 'C03', 'AND', 'C03-03'),
(188, 47, 'C04', 'AND', 'C04-01'),
(189, 48, 'C01', 'AND', 'C01-04'),
(190, 48, 'C02', 'AND', 'C02-03'),
(191, 48, 'C03', 'AND', 'C03-04'),
(192, 48, 'C04', 'AND', 'C04-02');

-- --------------------------------------------------------

--
-- Table structure for table `tb_himpunan`
--

CREATE TABLE `tb_himpunan` (
  `kode_himpunan` varchar(16) NOT NULL,
  `kode_kriteria` varchar(16) DEFAULT NULL,
  `nama_himpunan` varchar(255) DEFAULT NULL,
  `n1` double DEFAULT NULL,
  `n2` double DEFAULT NULL,
  `n3` double DEFAULT NULL,
  `n4` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_himpunan`
--

INSERT INTO `tb_himpunan` (`kode_himpunan`, `kode_kriteria`, `nama_himpunan`, `n1`, `n2`, `n3`, `n4`) VALUES
('C01-01', 'C01', 'Kurang', 0, 0, 70, 74),
('C01-02', 'C01', 'Cukup', 70, 76, 76, 82),
('C01-03', 'C01', 'Baik', 76, 83, 83, 90),
('C01-04', 'C01', 'Sangat Baik', 83, 88, 100, 100),
('C02-01', 'C02', 'Sedikit', 0, 0, 2, 5),
('C02-02', 'C02', 'Sedang', 2, 5, 5, 8),
('C02-03', 'C02', 'Banyak', 5, 8, 10, 10),
('C03-01', 'C03', 'Kurang', 0, 0, 70, 74),
('C03-02', 'C03', 'Cukup', 70, 76, 76, 82),
('C03-03', 'C03', 'Baik', 76, 83, 83, 90),
('C03-04', 'C03', 'Sangat Baik', 83, 88, 100, 100),
('C04-01', 'C04', 'Tidak Lolos', 0, 0, 75, 80),
('C04-02', 'C04', 'Lolos', 75, 85, 100, 100);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kriteria`
--

CREATE TABLE `tb_kriteria` (
  `kode_kriteria` varchar(16) NOT NULL,
  `nama_kriteria` varchar(255) DEFAULT NULL,
  `batas_bawah` double DEFAULT NULL,
  `batas_atas` double DEFAULT NULL,
  `dicari` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_rel_alternatif`
--

CREATE TABLE `tb_rel_alternatif` (
  `ID` int(11) NOT NULL,
  `kode_alternatif` varchar(16) DEFAULT NULL,
  `kode_kriteria` varchar(16) DEFAULT NULL,
  `nilai` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user` varchar(16) NOT NULL,
  `pass` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user`, `pass`) VALUES
('admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`user`);

--
-- Indexes for table `tb_alternatif`
--
ALTER TABLE `tb_alternatif`
  ADD PRIMARY KEY (`kode_alternatif`);

--
-- Indexes for table `tb_aturan`
--
ALTER TABLE `tb_aturan`
  ADD PRIMARY KEY (`id_aturan`);

--
-- Indexes for table `tb_himpunan`
--
ALTER TABLE `tb_himpunan`
  ADD PRIMARY KEY (`kode_himpunan`);

--
-- Indexes for table `tb_kriteria`
--
ALTER TABLE `tb_kriteria`
  ADD PRIMARY KEY (`kode_kriteria`);

--
-- Indexes for table `tb_rel_alternatif`
--
ALTER TABLE `tb_rel_alternatif`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_aturan`
--
ALTER TABLE `tb_aturan`
  MODIFY `id_aturan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;
--
-- AUTO_INCREMENT for table `tb_rel_alternatif`
--
ALTER TABLE `tb_rel_alternatif`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
