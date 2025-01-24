-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 24, 2025 at 02:49 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kedai`
--

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_beli` int NOT NULL,
  `Id_makan` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `total_harga` bigint DEFAULT NULL,
  `harga_satuan` bigint NOT NULL,
  `catatan` longtext NOT NULL,
  `id_user` int NOT NULL,
  `nama_pembelian` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `Id_makan` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `harga` bigint NOT NULL,
  `tentang` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `stok` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`Id_makan`, `nama`, `kategori`, `harga`, `tentang`, `gambar`, `stok`) VALUES
(4, 'bluger', 'makanan', 15000, 'roti kasih daging', '888-Cheeseburger.jpg', 11),
(5, 'cupcep', 'dessert', 3000, 'kue cupcep', '6-6115cb2ce3bc6.jpeg', 24);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `role`) VALUES
(1, 'resky', '$2y$10$OzJldz.ORxcb33vDx9MM0.qPLYTzMAfpL7tJ9uiDCoP/25gbDwI2e', 'rezky@gmail.com', 'admin'),
(2, 'admin', '$2y$10$TdxXOSIwSJ4oGRNu3TuXHe8vdlJKqnpFJmOLwwhBmORa8vUC5iyI2', 'admin@gmail.com', 'user'),
(3, 'admin1', '$2y$10$TdxXOSIwSJ4oGRNu3TuXHe8vdlJKqnpFJmOLwwhBmORa8vUC5iyI2', 'admin1@gmail.com', 'admin'),
(4, 'user', '$2y$10$gnmqbkXlg2SQeOLDa3bH4.VyaQ6ecEg7Uh1pJAmcqKJSuYOgntRD6', 'user@gmail.com', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_beli`),
  ADD UNIQUE KEY `Id_makan` (`Id_makan`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`Id_makan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_beli` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`Id_makan`) REFERENCES `produk` (`Id_makan`),
  ADD CONSTRAINT `pembelian_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
