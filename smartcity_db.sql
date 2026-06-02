-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2026 at 06:10 AM
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
-- Database: `smartcity_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporans`
--

CREATE TABLE `laporans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `instansi` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi_laporan` text NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `urgensi` enum('Tinggi','Sedang','Rendah') NOT NULL DEFAULT 'Rendah',
  `confidence_score` double NOT NULL DEFAULT 0,
  `status` enum('Masuk','Diproses','Selesai') NOT NULL DEFAULT 'Masuk',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporans`
--

INSERT INTO `laporans` (`id`, `user_id`, `instansi`, `judul`, `isi_laporan`, `lokasi`, `foto`, `urgensi`, `confidence_score`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN', 'kebakaran daerah cisaladah', 'kebakaran tisu di tepi jalan cisaladah', 'jatinagor', NULL, 'Rendah', 0, 'Selesai', '2026-06-01 05:30:49', '2026-06-01 08:49:25'),
(3, 1, 'DINAS SOSIAL', 'orang gila', 'orang gila', 'caringin', NULL, 'Rendah', 0, 'Masuk', '2026-06-01 06:03:38', '2026-06-01 06:03:38'),
(4, 1, 'DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN', '-', '-', '-', NULL, 'Rendah', 0, 'Selesai', '2026-06-01 08:50:26', '2026-06-01 09:12:13'),
(5, 1, 'DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN', '-', '-', '-', NULL, 'Rendah', 0, 'Selesai', '2026-06-01 08:50:40', '2026-06-01 09:13:13'),
(6, 1, 'DINAS SOSIAL', 'orang luntang lantung', 'sendirian gak makan dan minum', 'jatinagor, Kab. sumedang', NULL, 'Rendah', 0, 'Masuk', '2026-06-01 08:51:34', '2026-06-01 08:51:34'),
(7, 1, 'DINAS SOSIAL', 'orang luntang lantung', 'sendirian gak makan dan minum', 'jatinagor, Kab. sumedang', NULL, 'Rendah', 0, 'Masuk', '2026-06-01 08:57:16', '2026-06-01 08:57:16'),
(8, 1, 'DINAS SOSIAL', 'orang luntang lantung', 'sendirian gak makan dan minum', 'jatinagor, Kab. sumedang', NULL, 'Rendah', 0, 'Masuk', '2026-06-01 08:57:28', '2026-06-01 08:57:28');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_29_065422_create_laporans_table', 1),
(5, '2026_06_01_130705_add_role_and_instansi_to_users_table', 2);

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
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Lw91BU8e0tkULesp07VgJHYpWOYSsATdRSTVSIuq', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSXJUR3c5VU0wbFA0aTdXOGN5Mm03TG0xOHF4U1NjbDdoemhRdE1xeiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yaXdheWF0LXNheWEiO3M6NToicm91dGUiO3M6MTU6ImxhcG9yYW4ucml3YXlhdCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1780372998);

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
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `instansi` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `instansi`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Fitri Sahwalia', 'sahwa@gmail.com', NULL, '$2y$12$VtRHYN51YCOtH7.HvkPCruSzVAWVJ8rhFqbkk7v20X6PWF81XrUXq', 'user', NULL, NULL, '2026-06-01 04:22:14', '2026-06-01 04:22:14'),
(2, 'Test User', 'test@example.com', '2026-06-01 06:11:56', '$2y$12$ykGVPDk.g1RVFOxCSMouLONiEoHSCbzFjp05rS5hpbV2mu/9zCZ/m', 'user', NULL, '0bN9uubYcr', '2026-06-01 06:11:56', '2026-06-01 06:11:56'),
(3, 'Super Admin SmartCity', 'superadmin@smartcity.go.id', NULL, '$2y$12$yPXAGkXQf1FnvS/B92vTVOuNd1q4XbNvl5cUa6g01k6jLGyyTqn8e', 'superadmin', NULL, NULL, '2026-06-01 06:11:57', '2026-06-01 06:11:57'),
(4, 'Admin Dinas Pemadam Kebakaran Dan Penyelamatan', 'admin1@smartcity.go.id', NULL, '$2y$12$tBPuJ/DyjdI77C0khP9IaOXURf8TiNRRw42Jc9boNoXxX5eCRkecu', 'admin_instansi', 'DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN', NULL, '2026-06-01 06:11:58', '2026-06-01 06:11:58'),
(5, 'Admin Dinas Sosial', 'admin2@smartcity.go.id', NULL, '$2y$12$/ra2eNqzK38275OLHVsSR.vlZWnu1ITqr4NWzc1bV8TpEQ4TYDmhG', 'admin_instansi', 'DINAS SOSIAL', NULL, '2026-06-01 06:11:58', '2026-06-01 06:11:58'),
(6, 'Admin Dinas Perhubungan', 'admin3@smartcity.go.id', NULL, '$2y$12$Ol8pquwMmaNJdMBdEXtHhOCxuMFx97bmTt3GkHgjgUcL5u52KKJq6', 'admin_instansi', 'DINAS PERHUBUNGAN', NULL, '2026-06-01 06:11:58', '2026-06-01 06:11:58'),
(7, 'Admin Sekretariat Daerah', 'admin4@smartcity.go.id', NULL, '$2y$12$ZwjZQvunUaYG61Hh7aqZkuaWJZU3whUAoiadchfLwEi8ZnxtAKS/e', 'admin_instansi', 'SEKRETARIAT DAERAH', NULL, '2026-06-01 06:11:59', '2026-06-01 06:11:59'),
(8, 'Admin Sekretariat Dprd', 'admin5@smartcity.go.id', NULL, '$2y$12$y6KNLB1UQD4MVAqBSeEnf.YxBTc/Shf6QUVGckqKg.lIVZXwgmeNa', 'admin_instansi', 'SEKRETARIAT DPRD', NULL, '2026-06-01 06:12:00', '2026-06-01 06:12:00'),
(9, 'Admin Dinas Pendidikan', 'admin6@smartcity.go.id', NULL, '$2y$12$w5Bptl0MaBc7oKVRElz9VOXxNEceQJPAlXb0/iU/znE5mMdZc9M.a', 'admin_instansi', 'DINAS PENDIDIKAN', NULL, '2026-06-01 06:12:00', '2026-06-01 06:12:00'),
(10, 'Admin Satuan Polisi Pamong Praja', 'admin7@smartcity.go.id', NULL, '$2y$12$lpYeCrUQG9hi1bvdy6JSYeQzB3Kn6gZATbSDMs081DmCuLIoKIAMq', 'admin_instansi', 'SATUAN POLISI PAMONG PRAJA', NULL, '2026-06-01 06:12:01', '2026-06-01 06:12:01'),
(11, 'Admin Dinas Kependudukan Dan Pencatatan Sipil', 'admin8@smartcity.go.id', NULL, '$2y$12$.tQUU45MhV8MtIZQGFMaqOkJD4Iv3pU2kkTRYKUa2toMazwViQvzC', 'admin_instansi', 'DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL', NULL, '2026-06-01 06:12:01', '2026-06-01 06:12:01'),
(12, 'Admin Dinas Kesehatan', 'admin9@smartcity.go.id', NULL, '$2y$12$yIoRwHYovOcOw9CqGGA0Q.zwNRJrCn/YhHbLm5.X9Q423w/x1zE7O', 'admin_instansi', 'DINAS KESEHATAN', NULL, '2026-06-01 06:12:02', '2026-06-01 06:12:02'),
(13, 'Admin Badan Penanggulangan Bencana Daerah (bpbd)', 'admin10@smartcity.go.id', NULL, '$2y$12$gsuZpgIhft5MSpeB59UUOuhNCYJm7BxtDOqo1WkMomIaGjJ6uX9VO', 'admin_instansi', 'BADAN PENANGGULANGAN BENCANA DAERAH (BPBD)', NULL, '2026-06-01 06:12:02', '2026-06-01 06:12:02'),
(14, 'Admin Dinas Perumahan, Kawasan Permukiman Dan Pertanahan', 'admin11@smartcity.go.id', NULL, '$2y$12$xKbLcU111.HVcXCF2TbqueqCshJNZCusRJ15HL2Q3Agu6u8RL.90C', 'admin_instansi', 'DINAS PERUMAHAN, KAWASAN PERMUKIMAN DAN PERTANAHAN', NULL, '2026-06-01 06:12:03', '2026-06-01 06:12:03'),
(15, 'Admin Dinas Tenaga Kerja Dan Transmigrasi', 'admin12@smartcity.go.id', NULL, '$2y$12$Ue9XMzlLKu16Zo.C39Lg4eBfm7bnMTJO6.1wize/G2A5fX1DD36Za', 'admin_instansi', 'DINAS TENAGA KERJA DAN TRANSMIGRASI', NULL, '2026-06-01 06:12:03', '2026-06-01 06:12:03'),
(16, 'Admin Dinas Lingkungan Hidup Dan Kehutanan', 'admin13@smartcity.go.id', NULL, '$2y$12$uP3H0TrbLWMjyKbTbppKXeeI7tLI00.qAmQw2kaQLOirv1vlAfx2y', 'admin_instansi', 'DINAS LINGKUNGAN HIDUP DAN KEHUTANAN', NULL, '2026-06-01 06:12:04', '2026-06-01 06:12:04'),
(17, 'Admin Rumah Sakit Umum Daerah Umar Wirahadikusumah', 'admin14@smartcity.go.id', NULL, '$2y$12$JE4FJ/Z79FtLLA8lLLG6GOdnUBFBKIe9LPnD5OtFhwDid/cR8nPIS', 'admin_instansi', 'RUMAH SAKIT UMUM DAERAH UMAR WIRAHADIKUSUMAH', NULL, '2026-06-01 06:12:04', '2026-06-01 06:12:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporans`
--
ALTER TABLE `laporans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporans_user_id_foreign` (`user_id`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laporans`
--
ALTER TABLE `laporans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `laporans`
--
ALTER TABLE `laporans`
  ADD CONSTRAINT `laporans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
