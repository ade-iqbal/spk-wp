-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2023 at 07:22 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_wp`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `alternatif` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `alternatif`) VALUES
(12, 'Bungo Jaya Cafe'),
(16, 'Yuuki Cafe'),
(20, 'Komo Cafe'),
(21, 'Raudha Cafe'),
(23, 'Badaso Cafe');

-- --------------------------------------------------------

--
-- Table structure for table `detail_alternatif`
--

CREATE TABLE `detail_alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nilai` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_alternatif`
--

INSERT INTO `detail_alternatif` (`id_alternatif`, `id_kriteria`, `nilai`) VALUES
(12, 1, 3),
(12, 2, 3),
(12, 3, 5),
(12, 4, 5),
(12, 5, 1),
(16, 1, 1),
(16, 2, 3),
(16, 3, 1),
(16, 4, 5),
(16, 5, 3),
(20, 1, 1),
(20, 2, 3),
(20, 3, 1),
(20, 4, 3),
(20, 5, 3),
(21, 1, 3),
(21, 2, 3),
(21, 3, 5),
(21, 4, 5),
(21, 5, 3),
(23, 1, 5),
(23, 2, 3),
(23, 3, 5),
(23, 4, 5),
(23, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `kriteria` varchar(50) NOT NULL,
  `kepentingan` smallint(6) NOT NULL,
  `cost_benefit` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kriteria`, `kepentingan`, `cost_benefit`) VALUES
(1, 'Variasi Menu', 5, 'benefit'),
(2, 'Harga', 5, 'cost'),
(3, 'Fasilitas', 3, 'benefit'),
(4, 'Kebersihan', 5, 'benefit'),
(5, 'Suasana', 4, 'benefit');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indexes for table `detail_alternatif`
--
ALTER TABLE `detail_alternatif`
  ADD KEY `kriteria_id_foreign` (`id_kriteria`),
  ADD KEY `alternatif_id_foreign` (`id_alternatif`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_alternatif`
--
ALTER TABLE `detail_alternatif`
  ADD CONSTRAINT `alternatif_id_foreign` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kriteria_id_foreign` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
