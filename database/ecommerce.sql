-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2023 at 04:22 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `order_number` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `total_pembayaran` decimal(10,2) NOT NULL,
  `tanggal_order` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `order_number`, `username`, `total_pembayaran`, `tanggal_order`) VALUES
(2, 'ORDER-20230722043324', 'ari', '3050000.00', '2023-07-22 02:33:24'),
(3, '16899940767669', 'ari', '2140000.00', '2023-07-22 02:47:56'),
(4, '16899946649185', 'asas', '1070000.00', '2023-07-22 02:57:44'),
(5, '16899949403961', 'ari', '1030000.00', '2023-07-22 03:02:20'),
(6, '16899953045167', 'ari', '3010000.00', '2023-07-22 03:08:24'),
(7, '16899956244339', 'ari', '14010000.00', '2023-07-22 03:13:44'),
(8, '16899957673714', 'ari', '3000000.00', '2023-07-22 03:16:07'),
(9, '16899959508547', 'ari', '10000.00', '2023-07-22 03:19:10'),
(10, '16899970568384', 'ari', '1000000.00', '2023-07-22 03:37:36'),
(11, '16899974419445', 'ari', '3000000.00', '2023-07-22 03:44:01'),
(12, '16899976174017', 'ari', '3010000.00', '2023-07-22 03:46:57'),
(13, '16899989318024', 'ari', '3020000.00', '2023-07-22 04:08:51'),
(14, '16900011868415', 'ari', '3000000.00', '2023-07-22 04:46:26'),
(15, '16900013162115', 'ari', '6050000.00', '2023-07-22 04:48:36'),
(16, '16900017242074', 'ari', '3010000.00', '2023-07-22 04:55:24'),
(17, '16900522316620', 'ari', '10000.00', '2023-07-22 18:57:11');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`order_detail_id`, `order_id`, `product_id`, `quantity`, `harga_satuan`, `subtotal`) VALUES
(1, 2, 4, 5, '10000.00', '50000.00'),
(2, 2, 2, 3, '1000000.00', '3000000.00'),
(3, 3, 4, 8, '10000.00', '80000.00'),
(4, 3, 2, 2, '1000000.00', '2000000.00'),
(5, 3, 4, 6, '10000.00', '60000.00'),
(6, 4, 4, 1, '10000.00', '10000.00'),
(7, 4, 2, 1, '1000000.00', '1000000.00'),
(8, 4, 5, 6, '10000.00', '60000.00'),
(9, 5, 4, 3, '10000.00', '30000.00'),
(10, 5, 2, 1, '1000000.00', '1000000.00'),
(11, 6, 3, 1, '3000000.00', '3000000.00'),
(12, 6, 4, 1, '10000.00', '10000.00'),
(13, 7, 4, 1, '10000.00', '10000.00'),
(14, 7, 3, 1, '3000000.00', '3000000.00'),
(15, 7, 2, 1, '1000000.00', '1000000.00'),
(16, 7, 5, 1000, '10000.00', '10000000.00'),
(17, 8, 3, 1, '3000000.00', '3000000.00'),
(18, 9, 4, 1, '10000.00', '10000.00'),
(19, 10, 1, 1, '1000000.00', '1000000.00'),
(20, 11, 3, 1, '3000000.00', '3000000.00'),
(21, 12, 3, 1, '3000000.00', '3000000.00'),
(22, 12, 5, 1, '10000.00', '10000.00'),
(23, 13, 4, 1, '10000.00', '10000.00'),
(24, 13, 5, 1, '10000.00', '10000.00'),
(25, 13, 1, 1, '1000000.00', '1000000.00'),
(26, 13, 1, 1, '1000000.00', '1000000.00'),
(27, 13, 1, 1, '1000000.00', '1000000.00'),
(28, 14, 3, 1, '3000000.00', '3000000.00'),
(29, 15, 3, 1, '3000000.00', '3000000.00'),
(30, 15, 2, 3, '1000000.00', '3000000.00'),
(31, 15, 5, 5, '10000.00', '50000.00'),
(32, 16, 3, 1, '3000000.00', '3000000.00'),
(33, 16, 5, 1, '10000.00', '10000.00'),
(34, 17, 4, 1, '10000.00', '10000.00');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `harga_produk` decimal(10,2) NOT NULL,
  `gambar_produk` varchar(255) NOT NULL,
  `deskripsi_produk` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `harga_produk`, `gambar_produk`, `deskripsi_produk`) VALUES
(1, 'Tas', '1000000.00', 'tas.jpg', 'Vestor mengambil pendekatan yang tidak lazim untuk menggabungkan gaya dengan fungsi. Garis ini dirancang dengan tata letak dua nada yang selaras namun menarik yang menawarkan gaya bisnis urban yang lebih muda. Interior Vestor juga dirancang dengan cermat untuk para profesional bisnis dengan banyak organisator dan kompartemen. Bagian laptop dilapisi dengan lapisan pelindung khusus dengan bantalan penyerap goncangan, yang melindungi laptop Anda saat bepergian. Tersedia dalam berbagai gaya, Vestor adalah aksesori yang sempurna untuk semua profesional bisnis perkotaan.\r\n\r\n-Warna: Hitam\r\n\r\n-Bahan: 80% POLYESTER 20% PU\r\n\r\n-Dimensi: 43,0 x 29,0 x 13,0cm\r\n\r\n-Volume: 16L\r\n\r\n-Berat: 1.27kg\r\n\r\nBerat pengiriman : 8KG (Berat pengiriman dihitung dari dimensi P x L x T) Dus koper pengiriman. Mohon tanyakan ketersediaan stok sebelum order ya kak. Terimakasih :)'),
(2, 'Ipad', '1000000.00', 'ipad.jpg', 'Garis ini dirancang dengan tata letak dua nada yang selaras namun menarik yang menawarkan gaya bisnis urban yang lebih muda. Interior Vestor juga dirancang dengan cermat untuk para profesional bisnis dengan banyak organisator dan kompartemen. Bagian laptop dilapisi dengan lapisan pelindung khusus dengan bantalan penyerap goncangan, yang melindungi laptop Anda saat bepergian. Tersedia dalam berbagai gaya, Vestor adalah aksesori yang sempurna untuk semua profesional bisnis perkotaan.\r\n\r\n-Warna: Hitam\r\n\r\n-Bahan: 80% POLYESTER 20% PU\r\n\r\n-Dimensi: 43,0 x 29,0 x 13,0cm\r\n\r\n-Volume: 16L\r\n\r\n-Berat: 1.27kg\r\n\r\nBerat pengiriman : 8KG (Berat pengiriman dihitung dari dimensi P x L x T) Dus koper pengiriman. Mohon tanyakan ketersediaan stok sebelum order ya kak. Terimakasih :)'),
(3, 'Laptop', '3000000.00', 'laptop.jpg', 'Vestor mengambil pendekatan yang tidak lazim untuk menggabungkan gaya dengan fungsi. Garis ini dirancang dengan tata letak dua nada yang selaras namun menarik yang menawarkan gaya bisnis urban yang lebih muda. Interior Vestor juga dirancang dengan cermat untuk para profesional bisnis dengan banyak organisator dan kompartemen. Bagian laptop dilapisi dengan lapisan pelindung khusus dengan bantalan penyerap goncangan, yang melindungi laptop Anda saat bepergian. Tersedia dalam berbagai gaya, Vestor adalah aksesori yang sempurna untuk semua profesional bisnis perkotaan.\r\n\r\n-Warna: Hitam\r\n\r\n-Dimensi: 43,0 x 29,0 x 13,0cm\r\n\r\n-Volume: 16L\r\n\r\n-Berat: 1.27kg\r\n\r\nBerat pengiriman : 8KG (Berat pengiriman dihitung dari dimensi P x L x T) Dus koper pengiriman. Mohon tanyakan ketersediaan stok sebelum order ya kak. Terimakasih :)'),
(4, 'Buku', '10000.00', 'Buku.jpg', 'Jadi ini buku latihan soal matematika ya, Jer? Bukan! Kata orang, selama masih hidup, manusia akan terus menghadapi masalah demi masalah. Dan itulah yang akan kuceritakan dalam buku ini, yaitu bagaimana aku menghadapi setiap persoalan di dalam hidupku. Dimulai dari aku yang lahir dekat dengan hari meletusnya kerusuhan di tahun 1998, bagaimana keluargaku berusaha menyekolahkanku dengan kondisi ekonomi yang terbatas, sampai pada akhirnya aku berhasil mendapatkan beasiswa penuh S1 di Jepang. Manusia tidak akan pernah lepas dari masalah kehidupan, betul. Tapi buku ini tidak hanya berisi cerita sedih dan keluhan ini-itu. Ini adalah catatan perjuanganku sebagai Jerome Polin Sijabat, pelajar Indonesia di Jepang yang iseng memulai petualangan di YouTube lewat channel Nihongo Mantappu. Yuk, naik roller coaster di kehidupanku yang penuh dengan kalkulasi seperti matematika. It may not gonna be super fun, but I promise it would worth the ride. Minasan, lets go, MANTAPPU JIWA!\r\n\r\nSpesifikasi\r\n\r\nJumlah Halaman : 224.0\r\nTanggal Terbit : 19 Agustus 2019\r\nISBN : 9786020632414\r\nPenerbit : Gramedia Pustaka Utama\r\nBerat : 0.3 kg\r\nLebar : 13.5 cm\r\nPanjang : 20.0 cm'),
(5, 'Pensil', '10000.00', 'pensil.jpg', 'Dan itulah yang akan kuceritakan dalam buku ini, yaitu bagaimana aku menghadapi setiap persoalan di dalam hidupku. Dimulai dari aku yang lahir dekat dengan hari meletusnya kerusuhan di tahun 1998, bagaimana keluargaku berusaha menyekolahkanku dengan kondisi ekonomi yang terbatas, sampai pada akhirnya aku berhasil mendapatkan beasiswa penuh S1 di Jepang. Manusia tidak akan pernah lepas dari masalah kehidupan, betul. Tapi buku ini tidak hanya berisi cerita sedih dan keluhan ini-itu. Ini adalah catatan perjuanganku sebagai Jerome Polin Sijabat, pelajar Indonesia di Jepang yang iseng memulai petualangan di YouTube lewat channel Nihongo Mantappu. Yuk, naik roller coaster di kehidupanku yang penuh dengan kalkulasi seperti matematika. It may not gonna be super fun, but I promise it would worth the ride. Minasan, lets go, MANTAPPU JIWA!\r\n\r\nSpesifikasi\r\n\r\nJumlah Halaman : 224.0\r\nTanggal Terbit : 19 Agustus 2019\r\nISBN : 9786020632414\r\nPenerbit : Gramedia Pustaka Utama\r\nBerat : 0.3 kg\r\nLebar : 13.5 cm\r\nPanjang : 20.0 cm');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`) VALUES
(1, 'admin', '123', ''),
(2, 'ari', 'ari', 'Mochamad Ari Pratama'),
(3, 'jajang', 'jajang', 'Jajang'),
(4, 'asas', '111', 'Mochamad Ari Pratama');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
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
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`),
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
