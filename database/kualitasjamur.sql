-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2022 at 02:21 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kualitasjamur`
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
('C01-01', 'C01', 'Cepat', 0, 0, 27.5, 30),
('C01-02', 'C01', 'Normal', 27.5, 30, 30, 32.17),
('C01-03', 'C01', 'Lama', 30, 32.17, 35, 35),
('C02-01', 'C02', 'Cepat', 0, 0, 32.25, 37),
('C02-02', 'C02', 'Normal', 32.25, 37, 37, 42.33),
('C02-03', 'C02', 'Lama', 37, 42.33, 50, 50),
('C03-01', 'C03', 'Sedikit', 0, 0, 26, 30),
('C03-02', 'C03', 'Banyak', 26, 30, 30, 34),
('C03-03', 'C03', 'Terbanyak', 30, 34, 40, 40),
('C04-01', 'C04', 'Ringan', 0, 0, 290, 323),
('C04-02', 'C04', 'Berat', 290, 323, 323, 350),
('C04-03', 'C04', 'Terberat', 323, 350, 400, 400),
('C05-01', 'C05', 'Kurang Baik', 0, 0, 25, 50),
('C05-02', 'C05', 'Baik', 25, 50, 50, 75),
('C05-03', 'C05', 'Terbaik', 50, 75, 100, 100),
('KH1-02', 'KH1', 'Rendah', 0, 0, 0, 5),
('KH1-03', 'KH1', 'Tinggi', 0, 5, 5, 5);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_aturan`
--
ALTER TABLE `tb_aturan`
  MODIFY `id_aturan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tb_rel_alternatif`
--
ALTER TABLE `tb_rel_alternatif`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
