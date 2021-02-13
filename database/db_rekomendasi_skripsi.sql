-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 13 Feb 2021 pada 15.29
-- Versi Server: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rekomendasi_skripsi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL COMMENT 'user id',
  `updated_by` int(10) UNSIGNED NOT NULL COMMENT 'user id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Film', 1, 1, '2021-02-12 17:29:35', '2021-02-12 17:29:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `gender` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1:male; 2:female;',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `gender`, `created_at`, `updated_at`) VALUES
(1, 'Dhani', 'dhani@gmail.com', '08988443311', 1, '2021-02-12 17:36:54', '2021-02-12 17:36:54'),
(2, 'Yuli', 'yuli@gmail.com', '08988443312', 2, '2021-02-12 17:37:09', '2021-02-12 17:38:07'),
(3, 'Mila', 'mila@gmail.com', '08988443311', 2, '2021-02-12 17:37:55', '2021-02-12 17:38:14'),
(4, 'Rudi', 'rudi@gmail.com', '08988443327', 1, '2021-02-12 17:59:27', '2021-02-12 17:59:27'),
(5, 'Gilang', 'gilang@gmail.com', '08988775567', 1, '2021-02-12 18:00:04', '2021-02-12 18:00:04'),
(6, 'Angel', 'angel@gmail.com', '08988447752', 2, '2021-02-13 00:27:54', '2021-02-13 00:27:54'),
(7, 'Anggi', 'anggi@gmail.com', '08988554473', 2, '2021-02-13 00:28:10', '2021-02-13 00:28:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2021_02_04_174622_create_categories_table', 1),
(4, '2021_02_07_160850_create_products_table', 1),
(5, '2021_02_08_223552_create_customers_table', 1),
(6, '2021_02_12_043508_create_reviews_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `total_rating` int(11) NOT NULL DEFAULT '0',
  `total_vote` int(11) NOT NULL DEFAULT '0',
  `image` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(15,2) UNSIGNED NOT NULL,
  `weight` decimal(20,2) UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) UNSIGNED NOT NULL COMMENT 'user id',
  `updated_by` int(10) UNSIGNED NOT NULL COMMENT 'user id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `total_rating`, `total_vote`, `image`, `price`, `weight`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'The Shawshank Redemption', 1, 21, 6, 'the-shawshank-redemption-210213123426.jpg', '70000.00', '500.00', 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', 1, 1, '2021-02-12 17:34:27', '2021-02-12 17:34:27'),
(2, 'The Godfather', 1, 6, 4, 'the-godfather-210213125057.jpg', '65000.00', '500.00', 'An organized crime dynasty\'s aging patriarch transfers control of his clandestine empire to his reluctant son.', 1, 1, '2021-02-12 17:50:57', '2021-02-12 21:32:47'),
(3, 'The Lion King', 1, 15, 6, 'the-lion-king-210213125433.jpg', '68000.00', '500.00', 'Lion prince Simba and his father are targeted by his bitter uncle, who wants to ascend the throne himself.', 1, 1, '2021-02-12 17:54:34', '2021-02-12 23:36:07'),
(4, 'Wall-E', 1, 6, 2, 'wall-e-210213021003.jpg', '60000.00', '500.00', 'In the distant future, a small waste-collecting robot inadvertently embarks on a space journey that will ultimately decide the fate of mankind.', 1, 1, '2021-02-12 19:10:03', '2021-02-13 02:45:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL DEFAULT '0',
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) UNSIGNED NOT NULL COMMENT 'user id',
  `updated_by` int(10) UNSIGNED NOT NULL COMMENT 'user id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reviews`
--

INSERT INTO `reviews` (`id`, `customer_id`, `product_id`, `rating`, `note`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, NULL, 0, 0, NULL, NULL),
(2, 1, 2, 1, NULL, 0, 0, NULL, NULL),
(3, 2, 1, 3, NULL, 0, 0, NULL, NULL),
(4, 3, 1, 2, NULL, 0, 0, NULL, NULL),
(5, 4, 1, 5, NULL, 0, 0, NULL, NULL),
(6, 5, 2, 1, NULL, 0, 0, NULL, NULL),
(7, 6, 1, 2, NULL, 0, 0, NULL, NULL),
(8, 6, 2, 1, NULL, 0, 0, NULL, NULL),
(9, 7, 1, 4, NULL, 0, 0, NULL, NULL),
(10, 7, 2, 3, NULL, 0, 0, NULL, NULL),
(11, 1, 3, 1, NULL, 0, 0, NULL, NULL),
(12, 5, 3, 1, NULL, 0, 0, NULL, NULL),
(13, 6, 3, 1, NULL, 0, 0, NULL, NULL),
(14, 7, 3, 4, NULL, 0, 0, NULL, NULL),
(15, 3, 3, 4, NULL, 0, 0, NULL, NULL),
(16, 4, 3, 4, NULL, 0, 0, NULL, NULL),
(18, 3, 4, 2, 'Baguus', 1, 1, '2021-02-13 01:36:04', '2021-02-13 02:44:44'),
(19, 7, 4, 4, 'Sukaa', 1, 1, '2021-02-13 02:34:45', '2021-02-13 02:45:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `similarities`
--

CREATE TABLE `similarities` (
  `product_id_1` int(11) NOT NULL,
  `product_id_2` int(11) NOT NULL,
  `similarity` varchar(225) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `similarities`
--

INSERT INTO `similarities` (`product_id_1`, `product_id_2`, `similarity`, `updated_at`, `created_at`) VALUES
(1, 2, '0.2075143391598224', '2021-02-13 21:23:13', '2021-02-13 21:23:13'),
(1, 3, '0.07352146220938077', '2021-02-13 21:23:13', '2021-02-13 21:23:13'),
(1, 4, '0.8944271909999159', '2021-02-13 21:23:13', '2021-02-13 21:23:13'),
(2, 3, '0.8660254037844386', '2021-02-13 21:23:13', '2021-02-13 21:23:13'),
(2, 4, '1', '2021-02-13 21:23:13', '2021-02-13 21:23:13'),
(3, 4, '0', '2021-02-13 21:23:13', '2021-02-13 21:23:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1:inactive; 2:active;',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL COMMENT 'user id',
  `updated_by` int(10) UNSIGNED NOT NULL COMMENT 'user id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `status`, `remember_token`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', '$2y$10$Eq5PsnhkontW.uKJJX/X2e9FpFGROt6qmAA233Wuv6853F6x/P2vC', 2, NULL, 1, 1, '2021-02-12 17:12:11', '2021-02-12 17:12:11'),
(2, 'Yaman Lutfi', 'it.yamanlutfi@gmail.com', '$2y$10$IXiuMmmNKwTsaxh43QZYXO6EaXPYT0TZXTs54TWIHNiGoVHFGA5OS', 2, NULL, 1, 1, '2021-02-12 17:23:04', '2021-02-12 17:23:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
