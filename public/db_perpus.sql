-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2025 at 04:28 PM
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
-- Database: `db_perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_12_28_103638_table_petugas_perpus', 1),
(6, '2024_12_28_130902_create_table_mahasiswa', 1),
(7, '2024_12_29_105143_create_table_buku', 2),
(8, '2024_12_29_165332_create_table_peminjaman_buku', 3),
(9, '2024_12_30_070936_create_table_pengembalian_buku', 3),
(10, '2024_12_30_174429_add_image_buku_to_model_buku_table', 3),
(11, '2025_01_02_144916_add_deleted_at_to_table_buku', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_buku`
--

CREATE TABLE `table_buku` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  `jumlah_buku` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image_buku` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_buku`
--

INSERT INTO `table_buku` (`id`, `kategori`, `judul`, `tahun_terbit`, `jumlah_buku`, `created_at`, `updated_at`, `image_buku`, `deleted_at`) VALUES
(1, 'Fiksi', 'mas here', '2001', 10, '2024-12-29 05:20:29', '2025-01-02 03:39:38', NULL, NULL),
(6, 'hehe', 'hehe', '2021', 10, '2025-01-02 08:05:20', '2025-01-02 08:05:20', 'cover_buku/course-2_hrwfbo.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `table_mahasiswa`
--

CREATE TABLE `table_mahasiswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nim` varchar(255) NOT NULL,
  `fakultas` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_mahasiswa`
--

INSERT INTO `table_mahasiswa` (`id`, `nama`, `nim`, `fakultas`, `alamat`, `jenis_kelamin`, `created_at`, `updated_at`) VALUES
(1, 'Mhs 1', '123456789', 'Fakultas Teknik', 'Semarang', 'Laki-laki', '2024-12-28 07:53:42', '2024-12-28 07:53:42'),
(2, 'rehan', '1029281', 'teknik informatika', 'semarnag', 'Laki-laki', '2025-01-02 03:53:04', '2025-01-02 03:57:30'),
(3, 'bugar', '7162918', 'pitik', 'manyaran', 'Laki-laki', '2025-01-02 04:13:42', '2025-01-02 04:13:42');

-- --------------------------------------------------------

--
-- Table structure for table `table_peminjaman_buku`
--

CREATE TABLE `table_peminjaman_buku` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_mahasiswa` bigint(20) UNSIGNED NOT NULL,
  `id_petugas` bigint(20) UNSIGNED DEFAULT NULL,
  `id_buku` bigint(20) UNSIGNED NOT NULL,
  `fakultas` varchar(255) NOT NULL,
  `nim` varchar(255) NOT NULL,
  `tanggal_peminjaman` date NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `status` enum('menunggu acc','dipinjam','dikembalikan') NOT NULL DEFAULT 'menunggu acc',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_peminjaman_buku`
--

INSERT INTO `table_peminjaman_buku` (`id`, `id_mahasiswa`, `id_petugas`, `id_buku`, `fakultas`, `nim`, `tanggal_peminjaman`, `tanggal_pengembalian`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 1, 'teknik', '123456', '2024-01-01', '2024-01-10', 'dikembalikan', '2024-12-29 23:39:52', '2024-12-30 02:48:51'),
(3, 1, NULL, 1, 'Fakultas Teknik', '123456789', '2024-12-31', '2025-01-02', 'dikembalikan', '2024-12-30 22:14:07', '2024-12-31 06:30:38'),
(5, 1, NULL, 5, 'Fakultas Teknik', '123456789', '2025-01-02', '2025-01-10', 'dipinjam', '2025-01-01 23:10:23', '2025-01-01 23:11:37'),
(6, 1, NULL, 1, 'Fakultas Teknik', '123456789', '2025-01-02', '2025-01-11', 'dikembalikan', '2025-01-02 03:25:54', '2025-01-02 03:39:38'),
(7, 3, NULL, 5, 'pitik', '7162918', '2025-01-02', '2025-01-04', 'dipinjam', '2025-01-02 07:46:39', '2025-01-02 07:52:39'),
(9, 3, NULL, 1, 'pitik', '7162918', '2025-01-02', '2025-01-18', 'menunggu acc', '2025-01-02 08:12:13', '2025-01-02 08:12:13');

-- --------------------------------------------------------

--
-- Table structure for table `table_pengembalian_buku`
--

CREATE TABLE `table_pengembalian_buku` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_peminjaman_buku` bigint(20) UNSIGNED NOT NULL,
  `id_mahasiswa` bigint(20) UNSIGNED NOT NULL,
  `id_petugas` bigint(20) UNSIGNED DEFAULT NULL,
  `id_buku` bigint(20) UNSIGNED NOT NULL,
  `fakultas` varchar(255) NOT NULL,
  `nim` varchar(255) NOT NULL,
  `tanggal_peminjaman` date NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `denda` decimal(10,2) DEFAULT 0.00,
  `status` enum('menunggu acc','dipinjam','dikembalikan') NOT NULL DEFAULT 'menunggu acc',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_pengembalian_buku`
--

INSERT INTO `table_pengembalian_buku` (`id`, `id_peminjaman_buku`, `id_mahasiswa`, `id_petugas`, `id_buku`, `fakultas`, `nim`, `tanggal_peminjaman`, `tanggal_pengembalian`, `denda`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, 1, 'Fakultas Teknik', '123456789', '2024-01-01', '2024-12-15', 3490000.00, 'dikembalikan', '2024-12-30 02:23:02', '2024-12-30 02:48:51'),
(2, 1, 1, NULL, 1, 'Fakultas Teknik', '123456789', '2024-01-01', '2024-12-15', 3490000.00, 'dikembalikan', '2024-12-31 03:19:28', '2024-12-31 06:30:07'),
(5, 3, 1, NULL, 1, 'Fakultas Teknik', '123456789', '2024-12-31', '2025-01-04', 40000.00, 'dikembalikan', '2024-12-31 06:30:25', '2024-12-31 06:30:38'),
(6, 6, 1, NULL, 1, 'Fakultas Teknik', '123456789', '2025-01-02', '2025-01-04', 20000.00, 'dikembalikan', '2025-01-02 03:39:16', '2025-01-02 03:39:38');

-- --------------------------------------------------------

--
-- Table structure for table `table_petugas_perpus`
--

CREATE TABLE `table_petugas_perpus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_petugas_perpus`
--

INSERT INTO `table_petugas_perpus` (`id`, `nama`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Petugas', 'petugas@gmail.com', '$2y$12$H1zKEHQG9s3HuF.kMGG9NuoWZAPg8mcjv1eSqGdDkODVT5BfB4/Pi', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `table_buku`
--
ALTER TABLE `table_buku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_mahasiswa`
--
ALTER TABLE `table_mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_peminjaman_buku`
--
ALTER TABLE `table_peminjaman_buku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_pengembalian_buku`
--
ALTER TABLE `table_pengembalian_buku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_petugas_perpus`
--
ALTER TABLE `table_petugas_perpus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `table_petugas_perpus_email_unique` (`email`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_buku`
--
ALTER TABLE `table_buku`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `table_mahasiswa`
--
ALTER TABLE `table_mahasiswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `table_peminjaman_buku`
--
ALTER TABLE `table_peminjaman_buku`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `table_pengembalian_buku`
--
ALTER TABLE `table_pengembalian_buku`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `table_petugas_perpus`
--
ALTER TABLE `table_petugas_perpus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
