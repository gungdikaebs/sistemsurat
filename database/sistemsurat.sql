-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 16, 2024 at 03:27 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistemsurat`
--

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id_divisi` int NOT NULL,
  `nama_divisi` varchar(100) NOT NULL,
  `singkatan` varchar(100) NOT NULL
);

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id_divisi`, `nama_divisi`, `singkatan`) VALUES
(1, 'Keuangan', 'KEUA'),
(2, 'Sumber Daya Manusia', 'SDMA'),
(3, 'Pemasaran', 'PSRN'),
(4, 'Produksi', 'PRDK'),
(5, 'IT Support', 'ITSP');

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id_surat` int NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `judul_surat` varchar(100) NOT NULL,
  `file_path` varchar(200) NOT NULL,
  `id_user` int NOT NULL,
  `id_divisi` int NOT NULL,
  `tanggal_surat` date NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `status_approve` tinyint(1) NOT NULL
);

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id_surat`, `no_surat`, `judul_surat`, `file_path`, `id_user`, `id_divisi`, `tanggal_surat`, `perihal`, `status_approve`) VALUES
(141, '01/KEUA/KEUA/VI/2024', 'Surat untuk Keuangan', 'public/uploads/pertemuan_1_pengenalan_komputer (1).pptx', 1, 1, '2024-06-16', 'Surat untuk Keuangan', 1),
(142, '02/KEUA/SDMA/VI/2024', 'Surat Untuk SDM', 'public/uploads/Tugas Pertemuan 5.pdf', 1, 2, '2024-06-16', 'Surat Untuk SDM', 1),
(144, '03/KEUA/PSRN/VI/2024', 'Surat Untuk Pemasaran', 'public/uploads/Tugas Pertemuan 5.pdf', 1, 3, '2024-06-16', 'Surat Untuk Pemasaran', 1),
(145, '04/KEUA/PRDK/VI/2024', 'Surat Untuk Produksi', 'public/uploads/pertemuan_5_Memori.pdf', 1, 4, '2024-06-16', 'Surat Untuk Produksi', 1),
(147, '05/KEUA/ITSP/VI/2024', 'Surat Untuk IT Sup', 'public/uploads/pertemuan_1_pengenalan_komputer (1).pptx', 1, 5, '2024-06-16', 'Surat Untuk IT Sup', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `id_divisi` int NOT NULL,
  `leveluser` tinyint(1) NOT NULL
);

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `id_divisi`, `leveluser`) VALUES
(1, 'ebes', '$2y$10$c9Y8EaoGqS4wH3/k5A3UJ.xFodXs/mYVFhb7A/CrD8LFjoz2q7DmK', 1, 1),
(2, 'rika', '$2y$10$P.8dLG005QLJ7eKJSj3kTOdAxBzwhLt6M0Yn20tEASoj0Wxh1Kcga', 2, 1),
(3, 'sandhika', '$2y$10$4ZZ7pkEdx0NOFsqBgz36m.DuoAd9trRDJFBv.SEa.SA5Gugl/l95.', 4, 0),
(4, 'tia', '$2y$10$409QLbLYDGtRNorq7OIT6O1v7Sv91CAmnpAJiLwmY1e3Zk81zRkgm', 4, 0),
(5, 'angel', '$2y$10$CbHzqkYIeAtvUbykWGhDtuaTNU23J/SRX0y.ymxIdAVmAw7BJTR.q', 1, 0),
(6, 'aisyah', '$2y$10$wDnH0sASAiM8tD6A/MGRLuEo49.88x45MTZ/Affsl0k6WCYlvPyJu', 5, 0),
(7, 'eden', '$2y$10$NW2qn2QQUJkEqfCDjmMM2.EjjZXwye9neGLWYOriybWj4.3NyEaWq', 2, 0),
(8, 'jovian', '$2y$10$9UzZ82915.QOJzGhwnMAAOuV8yPGdIxfQb9OMWuwixxbZgwxYStO.', 3, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id_surat`),
  ADD KEY `fk_surat_divisi` (`id_divisi`),
  ADD KEY `fk_surat_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `fk_user_divisi` (`id_divisi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id_divisi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id_surat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `surat`
--
ALTER TABLE `surat`
  ADD CONSTRAINT `fk_surat_divisi` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id_divisi`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_surat_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_divisi` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id_divisi`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
