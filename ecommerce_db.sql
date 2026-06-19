-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2026 at 03:16 PM
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
-- Database: `ecommerce_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `account_holder` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `bank_name`, `account_number`, `account_holder`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'BRI', '461901045890534', 'Yoseph krevinsius siga payu', 1, '2026-06-17 18:37:16', '2026-06-17 18:37:16');

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
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Hoodie', 'hoodie', NULL, '2026-06-17 18:32:00', '2026-06-17 18:32:00'),
(2, 'Celana Pendek', 'celana-pendek', NULL, '2026-06-18 20:32:04', '2026-06-18 20:32:04'),
(3, 'Celana Panjang', 'celana-panjang', NULL, '2026-06-18 20:32:14', '2026-06-18 20:32:14'),
(4, 'Sweater', 'sweater', NULL, '2026-06-18 20:32:34', '2026-06-18 20:32:34'),
(5, 'Kameja', 'kameja', NULL, '2026-06-19 05:26:26', '2026-06-19 05:26:26');

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
(4, '2026_01_01_000001_create_categories_table', 1),
(5, '2026_01_01_000002_create_products_table', 1),
(6, '2026_01_01_000003_create_carts_table', 1),
(7, '2026_01_01_000004_create_orders_table', 1),
(8, '2026_01_01_000005_create_order_items_table', 1),
(9, '2026_01_01_000006_create_payments_table', 1),
(10, '2026_01_01_000007_create_shipments_table', 1),
(11, '2026_01_01_000008_add_city_postal_code_to_users_table', 1),
(12, '2026_01_01_000009_create_quantity_discounts_table', 1),
(13, '2026_01_01_000010_create_vouchers_table', 1),
(14, '2026_01_01_000011_add_discount_columns_to_orders_table', 1),
(15, '2026_01_01_000012_create_payment_settings_tables', 1),
(16, '2026_01_01_000013_add_shipping_area_to_orders_table', 1),
(17, '2026_01_01_000014_create_shipment_history_and_fix_shipping_columns', 1),
(18, '2026_06_18_000001_add_shipping_choice_to_orders_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(255) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `quantity_discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `voucher_code` varchar(255) DEFAULT NULL,
  `voucher_discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending_payment','paid','processing','shipped','completed','cancelled') NOT NULL DEFAULT 'pending_payment',
  `shipping_address` text NOT NULL,
  `shipping_province` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(255) DEFAULT NULL,
  `shipping_district` varchar(255) DEFAULT NULL,
  `shipping_detail` text DEFAULT NULL,
  `shipping_distance_km` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `shipping_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `shipping_courier` varchar(255) DEFAULT NULL,
  `shipping_service` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_status` enum('unpaid','paid','rejected') NOT NULL DEFAULT 'unpaid',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_code`, `subtotal`, `quantity_discount`, `voucher_code`, `voucher_discount`, `total_price`, `status`, `shipping_address`, `shipping_province`, `shipping_city`, `shipping_district`, `shipping_detail`, `shipping_distance_km`, `shipping_cost`, `shipping_courier`, `shipping_service`, `payment_method`, `payment_status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 22, 'ORD-1781746699-2298', 85000.00, 0.00, NULL, 0.00, 97000.00, 'processing', 'Jl. Pembeli No. 10,\nPurwokerto Selatan, Banyumas\nJawa Tengah', 'Jawa Tengah', 'Banyumas', 'Purwokerto Selatan', 'Jl. Pembeli No. 10,', 25, 12000.00, NULL, NULL, 'Transfer Bank', 'paid', NULL, '2026-06-17 18:38:19', '2026-06-17 18:39:30'),
(2, 22, 'ORD-1781747865-1092', 85000.00, 0.00, NULL, 0.00, 97000.00, 'cancelled', 'Jl. Pembeli No. 10, Bandung\nMajenang, Cilacap\nJawa Tengah', 'Jawa Tengah', 'Cilacap', 'Majenang', 'Jl. Pembeli No. 10, Bandung', 25, 12000.00, 'JNE', 'OKE', 'Transfer Bank', 'unpaid', NULL, '2026-06-17 18:57:45', '2026-06-18 20:56:56'),
(3, 22, 'ORD-1781747976-7116', 85000.00, 0.00, NULL, 0.00, 97000.00, 'shipped', 'Jl. Pembeli No. 10, Bandung\nCilacap Tengah, Cilacap\nJawa Tengah', 'Jawa Tengah', 'Cilacap', 'Cilacap Tengah', 'Jl. Pembeli No. 10, Bandung', 25, 12000.00, 'JNE', 'YES', 'Transfer Bank', 'paid', NULL, '2026-06-17 18:59:36', '2026-06-18 20:52:50'),
(4, 22, 'ORD-1781839387-3041', 85000.00, 0.00, NULL, 0.00, 117000.00, 'completed', 'Jl. Pembeli No. 10\nLowokwaru, Malang\nJawa Timur', 'Jawa Timur', 'Malang', 'Lowokwaru', 'Jl. Pembeli No. 10', 430, 32000.00, 'JNE', 'YES', 'Transfer Bank', 'paid', NULL, '2026-06-18 20:23:07', '2026-06-18 20:26:54'),
(5, 22, 'ORD-1781870635-1879', 35000.00, 0.00, NULL, 0.00, 127000.00, 'completed', 'Jl. Pembeli No. 10\nEnde Selatan, Ende\nNusa Tenggara Timur', 'Nusa Tenggara Timur', 'Ende', 'Ende Selatan', 'Jl. Pembeli No. 10', 1500, 92000.00, 'JNE', 'YES', 'Transfer Bank', 'paid', NULL, '2026-06-19 05:03:55', '2026-06-19 05:07:17');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 85000.00, '2026-06-17 18:38:19', '2026-06-17 18:38:19'),
(2, 2, 1, 1, 85000.00, '2026-06-17 18:57:45', '2026-06-17 18:57:45'),
(3, 3, 1, 1, 85000.00, '2026-06-17 18:59:36', '2026-06-17 18:59:36'),
(4, 4, 1, 1, 85000.00, '2026-06-18 20:23:07', '2026-06-18 20:23:07'),
(5, 5, 4, 1, 35000.00, '2026-06-19 05:03:55', '2026-06-19 05:03:55');

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `method` varchar(255) NOT NULL,
  `status` enum('pending','confirmed','rejected') NOT NULL DEFAULT 'pending',
  `proof_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `amount`, `method`, `status`, `proof_image`, `created_at`, `updated_at`) VALUES
(1, 1, 97000.00, 'Transfer Bank', 'confirmed', 'payments/IPLiWl1HKzwPBMNV8soqZpDh254uxr7uNzWmtmQT.jpg', '2026-06-17 18:38:19', '2026-06-17 18:39:30'),
(2, 2, 97000.00, 'Transfer Bank', 'pending', NULL, '2026-06-17 18:57:45', '2026-06-17 18:57:45'),
(3, 3, 97000.00, 'Transfer Bank', 'confirmed', 'payments/YK5DNxkDqN5WWIE6vq9WaPDT0wyDQf7Q2lAw2wOq.jpg', '2026-06-17 18:59:36', '2026-06-17 19:00:18'),
(4, 4, 117000.00, 'Transfer Bank', 'confirmed', 'payments/kaLzzMEmzI8gZB29L7DtuZHdv1ZmaK34dVFKb01Z.jpg', '2026-06-18 20:23:07', '2026-06-18 20:24:17'),
(5, 5, 127000.00, 'Transfer Bank', 'confirmed', 'payments/Y58C3CnIO0plvI4gI29CZqDOto3msTOvqk2Ty8WW.jpg', '2026-06-19 05:03:55', '2026-06-19 05:05:06');

-- --------------------------------------------------------

--
-- Table structure for table `payment_settings`
--

CREATE TABLE `payment_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `qris_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_settings`
--

INSERT INTO `payment_settings` (`id`, `qris_image`, `created_at`, `updated_at`) VALUES
(1, NULL, '2026-06-17 18:37:07', '2026-06-17 18:37:07');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `stock`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Hoodie Hitam', 'hoodie-coklat-Lb2cY', 'Hoodie \r\nBahan Cotton\r\nUkuran ( L )', 85000.00, 11, 'products/62eDWt1RLI9gKFatdlOCLhvclPfZCIfysJL5Ic1L.jpg', 1, '2026-06-17 18:35:07', '2026-06-19 05:20:01'),
(2, 1, 'Hoodie Abu-abu', 'hoodie-abu-abu-jfUQ0', 'Hoodie Abu-abu\r\nBahan : Fleece \r\nUkuran ( XL )', 75000.00, 10, 'products/ptmmh6ciHjvB1YGB0QK5GU4PCV751zIC4ZJf5qRM.jpg', 1, '2026-06-17 18:36:39', '2026-06-19 05:18:55'),
(3, 2, 'Jeans Denim', 'jeans-uw1Jo', 'Bahan Denim\r\nUkuran ( 29 )', 65000.00, 10, 'products/jQBInGddd8IfSz4WZb63BwZB5T2Ifoz8ON0rArFt.jpg', 1, '2026-06-18 20:34:14', '2026-06-19 05:23:11'),
(4, 2, 'Celana Jeans', 'celana-harian-V2xL7', 'Bahan Denim\r\nUkuran ( 32 )', 35000.00, 9, 'products/D5JINUzmkMP7gpd2M3anqdzJMw1WOjQBqWNoUdDE.jpg', 1, '2026-06-18 20:35:23', '2026-06-19 05:22:55'),
(5, 3, 'Cinok', 'jeans-biru-RzG77', 'Bahan Cotton\r\nUkuran ( 32 )', 75000.00, 10, 'products/f6yDNZkmRNJTYqrzEbydaUg5y6U0aO3BmKRMxEPB.webp', 1, '2026-06-18 20:36:00', '2026-06-19 05:23:51'),
(6, 4, 'Sweater Cream', 'sweater-cream-mNhjm', 'Sweater Rajut\r\nUkuran ( M )', 75000.00, 10, 'products/eiukexqZP6SW6AWa08ygTAMZudI128oYHSsNl2dA.jpg', 1, '2026-06-18 20:41:44', '2026-06-19 05:16:55'),
(7, 4, 'Sweater Coklat', 'sweater-coklat-eIDz3', 'Sweater Rajut \r\nUkuran ( XL )', 75000.00, 10, 'products/sbsi6nI7OHm1ybwCPButcyoVYgdScwGP4Uhgat9E.jpg', 1, '2026-06-18 20:42:38', '2026-06-19 05:16:03'),
(8, 5, 'Flanel Hitam Putih', 'flanel-oUINy', 'Bahan Cotton\r\nUkuran ( L )', 65000.00, 10, 'products/CztZRxRNK1e5tPry28UlwgH7XnXfVL7uXuk9Ld2d.jpg', 1, '2026-06-19 05:27:38', '2026-06-19 05:29:07'),
(9, 5, 'Flanel Abu Putih', 'flanel-abu-putih-iC3MN', 'Bahan Cotton\r\nUkuran ( L )', 65000.00, 10, 'products/OVtHvKk8DEtiOtpgV5mAf8uIt9IM3OrYLCopNtIG.webp', 1, '2026-06-19 05:28:50', '2026-06-19 05:28:50');

-- --------------------------------------------------------

--
-- Table structure for table `quantity_discounts`
--

CREATE TABLE `quantity_discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `min_items` int(10) UNSIGNED NOT NULL,
  `discount_percent` tinyint(3) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quantity_discounts`
--

INSERT INTO `quantity_discounts` (`id`, `min_items`, `discount_percent`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 10, 1, '2026-06-17 07:04:13', '2026-06-18 20:43:06'),
(2, 3, 15, 1, '2026-06-17 07:04:13', '2026-06-18 20:43:06');

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
('gIqya8X7qgR5JfG9Y3RRBSuinit25MVC0dUTBkud', 21, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieDNCZ0VHQWFUMDFuTFZqYlVUWFVmWHhuNktmSUFoaDNDWXpta0pQayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjIxO30=', 1781872181);

-- --------------------------------------------------------

--
-- Table structure for table `shipments`
--

CREATE TABLE `shipments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `courier` enum('JNE','J&T','SiCepat','POS','AnterAja') NOT NULL,
  `service` varchar(255) DEFAULT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `shipping_cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','processing','shipped','delivered','returned') NOT NULL DEFAULT 'pending',
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `received_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipments`
--

INSERT INTO `shipments` (`id`, `order_id`, `courier`, `service`, `tracking_number`, `shipping_cost`, `status`, `shipped_at`, `delivered_at`, `received_at`, `notes`, `created_at`, `updated_at`) VALUES
(1, 3, 'JNE', 'YES', '02', 12000.00, 'shipped', '2026-06-18 20:52:50', NULL, NULL, NULL, '2026-06-17 19:00:43', '2026-06-18 20:52:50'),
(2, 4, 'JNE', 'YES', '03', 32000.00, 'delivered', '2026-06-18 20:26:03', '2026-06-18 20:26:54', '2026-06-18 20:26:54', NULL, '2026-06-18 20:24:47', '2026-06-18 20:26:54'),
(3, 5, 'JNE', 'YES', '04', 92000.00, 'delivered', '2026-06-19 05:06:34', '2026-06-19 05:07:17', '2026-06-19 05:07:17', NULL, '2026-06-19 05:05:48', '2026-06-19 05:07:17');

-- --------------------------------------------------------

--
-- Table structure for table `shipment_history`
--

CREATE TABLE `shipment_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipment_history`
--

INSERT INTO `shipment_history` (`id`, `order_id`, `status`, `description`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 3, 'processing', 'Pesanan dibuat dan siap diproses.', 21, '2026-06-17 19:00:43', '2026-06-17 19:00:43'),
(2, 4, 'processing', 'Pesanan dibuat dan siap diproses.', 21, '2026-06-18 20:24:47', '2026-06-18 20:24:47'),
(3, 4, 'processing', 'Pesanan sedang diproses oleh admin.', 21, '2026-06-18 20:25:53', '2026-06-18 20:25:53'),
(4, 4, 'shipped', 'Pesanan telah dikirim ke kurir JNE. No. Resi: 03', 21, '2026-06-18 20:26:03', '2026-06-18 20:26:03'),
(5, 4, 'completed', 'Pesanan telah diterima oleh customer pada 19 Jun 2026, 03:26 WIB.', 22, '2026-06-18 20:26:54', '2026-06-18 20:26:54'),
(6, 3, 'processing', 'Pesanan sedang diproses oleh admin.', 21, '2026-06-18 20:52:43', '2026-06-18 20:52:43'),
(7, 3, 'shipped', 'Pesanan telah dikirim ke kurir JNE. No. Resi: 02', 21, '2026-06-18 20:52:50', '2026-06-18 20:52:50'),
(8, 5, 'processing', 'Pesanan dibuat dan siap diproses.', 21, '2026-06-19 05:05:48', '2026-06-19 05:05:48'),
(9, 5, 'processing', 'Pesanan sedang diproses oleh admin.', 21, '2026-06-19 05:06:14', '2026-06-19 05:06:14'),
(10, 5, 'shipped', 'Pesanan telah dikirim ke kurir JNE. No. Resi: 04', 21, '2026-06-19 05:06:34', '2026-06-19 05:06:34'),
(11, 5, 'completed', 'Pesanan telah diterima oleh customer pada 19 Jun 2026, 12:07 WIB.', 22, '2026-06-19 05:07:17', '2026-06-19 05:07:17');

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
  `role` enum('admin','pembeli') NOT NULL DEFAULT 'pembeli',
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `address`, `city`, `postal_code`, `remember_token`, `created_at`, `updated_at`) VALUES
(21, 'Administrator', 'admin@admin.com', '2026-06-17 07:05:08', '$2y$12$C7Gkx/z7B.vVTxKUVapFPOZKuRq4fSSWelocSTzJ5v6zZdzC297WO', 'admin', '081234567890', 'Jl. Admin No. 1, Jakarta', NULL, NULL, NULL, '2026-06-17 07:05:08', '2026-06-17 07:05:08'),
(22, 'Pembeli Contoh', 'buyer@test.com', '2026-06-17 07:05:10', '$2y$12$ULdDPg5DkOriVjEFDEHq8uH0Sph1Me15SPsriYSSVaviHOGObmvKa', 'pembeli', '089876543210', 'Jl. Pembeli No. 10, Bandung', NULL, NULL, NULL, '2026-06-17 07:05:10', '2026-06-17 07:05:10');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` enum('percent','fixed') NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `min_purchase` decimal(15,2) NOT NULL DEFAULT 0.00,
  `max_uses` int(10) UNSIGNED DEFAULT NULL,
  `used_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_code_unique` (`order_code`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `payment_settings`
--
ALTER TABLE `payment_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `quantity_discounts`
--
ALTER TABLE `quantity_discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shipments_order_id_unique` (`order_id`);

--
-- Indexes for table `shipment_history`
--
ALTER TABLE `shipment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipment_history_created_by_foreign` (`created_by`),
  ADD KEY `shipment_history_order_id_created_at_index` (`order_id`,`created_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vouchers_code_unique` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_settings`
--
ALTER TABLE `payment_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `quantity_discounts`
--
ALTER TABLE `quantity_discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shipments`
--
ALTER TABLE `shipments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shipment_history`
--
ALTER TABLE `shipment_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipments`
--
ALTER TABLE `shipments`
  ADD CONSTRAINT `shipments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipment_history`
--
ALTER TABLE `shipment_history`
  ADD CONSTRAINT `shipment_history_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `shipment_history_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
