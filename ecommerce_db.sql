-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Jan 2026 pada 13.28
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(4, 2, 2, 1, '2026-01-17 07:14:55', '2026-01-17 08:09:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `created_at`) VALUES
(1, 'Buah-Buahan', 'fruits', 'Berbagai buah segar lokal dan import berkualitas tinggi.', 'img/fruits/banner.jpg', '2025-12-17 02:31:01'),
(2, 'Sayuran Segar', 'vegetables', 'Sayuran organik segar langsung dari petani.', 'img/vegetables/banner.jpg', '2025-12-17 02:31:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `total_amount` decimal(15,2) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','processed','shipped','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `phone`, `address`, `total_amount`, `total`, `status`, `created_at`) VALUES
(1, 2, 'rizki', '081515155115', 'jalan bahagia', 75000.00, 0.00, 'cancelled', '2026-01-17 04:50:23'),
(2, 2, 'rizki', '081515155115', 'jalan bahagia', 75000.00, 0.00, 'completed', '2026-01-17 04:56:24'),
(3, 2, 'NI MADE SULISTYAWATI', '085809159771', 'lampung', 45000.00, 0.00, 'paid', '2026-01-17 07:00:10'),
(4, 13, 'NI MADE SULISTYAWATI', '085809159771', 'lampung', 86000.00, 0.00, 'shipped', '2026-01-17 10:27:20'),
(5, 13, 'NI MADE SULISTYAWATI', '085809159771', 'lampung', 0.00, 0.00, 'shipped', '2026-01-17 10:33:49'),
(6, 13, 'NI MADE SULISTYAWATI', '085809159771', 'lampung', 0.00, 0.00, 'shipped', '2026-01-17 10:34:27'),
(7, 13, 'NI MADE SULISTYAWATI', '085809159771', 'lampung', 135000.00, 0.00, 'shipped', '2026-01-17 10:36:47'),
(8, 13, 'NI MADE SULISTYAWATI', '085809159771', 'lampung', 33000.00, 0.00, 'shipped', '2026-01-17 10:58:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `subtotal`) VALUES
(1, 2, 3, 1, 55000.00, 55000.00),
(2, 3, 2, 1, 25000.00, 25000.00),
(3, 5, 12, 1, 35000.00, 35000.00),
(4, 5, 13, 2, 18000.00, 36000.00),
(5, 6, 6, 2, 60000.00, 120000.00),
(6, 7, 6, 2, 60000.00, 120000.00),
(7, 8, 13, 1, 18000.00, 18000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `berat_jual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `stock`, `category_id`, `created_at`, `berat_jual`) VALUES
(1, 'Apel Segar', 'Apel merah segar dan renyah, kaya vitamin.', 35000.00, 'img/fruits/apple.jpg', 50, 1, '2025-12-17 02:31:01', 0),
(2, 'Pisang Ambon', 'Pisang matang sempurna, manis alami.', 25000.00, 'img/fruits/banana.jpg', 100, 1, '2025-12-17 02:31:01', 0),
(3, 'Anggur Hijau', 'Anggur hijau tanpa biji, juicy dan segar.', 55000.00, 'img/fruits/grape.jpg', 40, 1, '2025-12-17 02:31:01', 0),
(4, 'Kiwi Import', 'Kiwi segar kaya vitamin C.', 45000.00, 'img/fruits/kiwi.jpg', 60, 1, '2025-12-17 02:31:01', 0),
(5, 'Jeruk Sunkist', 'Jeruk manis tanpa biji.', 30000.00, 'img/fruits/orange.jpg', 80, 1, '2025-12-17 02:31:01', 0),
(6, 'Strawberry Premium', 'Strawberry merah segar dan harum.', 60000.00, 'img/fruits/strawberry.jpg', 30, 1, '2025-12-17 02:31:01', 0),
(7, 'Semangka Kuning', 'Semangka manis tanpa biji.', 40000.00, 'img/fruits/watermelon.jpg', 25, 1, '2025-12-17 02:31:01', 0),
(8, 'Brokoli Organik', 'Brokoli hijau segar tinggi serat.', 25000.00, 'img/vegetables/brocoli.jpg', 70, 2, '2025-12-17 02:31:01', 0),
(9, 'Wortel Segar', 'Wortel organik bagus untuk kesehatan mata.', 15000.00, 'img/vegetables/carrot.jpg', 90, 2, '2025-12-17 02:31:01', 0),
(10, 'Cabai Merah', 'Cabai merah pedas segar.', 20000.00, 'img/vegetables/chilli.jpg', 100, 2, '2025-12-17 02:31:01', 0),
(11, 'Lemon Import', 'Lemon segar untuk minuman.', 28000.00, 'img/vegetables/lemon.jpg', 50, 2, '2025-12-17 02:31:01', 0),
(12, 'Paprika Warna-Warni', 'Paprika merah, kuning, hijau.', 35000.00, 'img/vegetables/paprika.jpg', 60, 2, '2025-12-17 02:31:01', 0),
(13, 'Labu Kuning', 'Labu kuning manis untuk kolak.', 18000.00, 'img/vegetables/pumpkin.jpg', 40, 2, '2025-12-17 02:31:01', 0),
(14, 'Tomat Cherry', 'Tomat cherry manis untuk salad.', 32000.00, 'img/vegetables/tomato.jpg', 80, 2, '2025-12-17 02:31:01', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `role` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `role`, `created_at`) VALUES
(1, 'Admin Utama', 'admin@fruitables.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', '', 'admin', '2025-12-17 02:31:01'),
(2, 'rizki', 'rizki@gmail.com', '$2y$10$tm0MzQ4WOovFsZUtZMgLreqE33Ier4p0b2wlYvcb.nCucYgLKjDo.', '', '', 'customer', '2026-01-17 04:43:39'),
(13, 'NI MADE SULISTYAWATI', 'madewati057@gmail.com', '$2y$10$0VnZy2hu0yhTJ.ydsz7tg.eXBcbrz5V0eWUFmEOinF0e31owvOy86', 'madewati057@gmail.co', 'madewati057@gmail.com', 'customer', '2026-01-17 08:58:37');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_product` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
