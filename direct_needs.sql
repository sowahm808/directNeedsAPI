-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 07, 2025 at 03:53 AM
-- Server version: 5.7.44
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `direct_needs`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `applicant_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_processor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'submitted',
  `grant_amount` decimal(10,2) DEFAULT NULL,
  `approval_date` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apartment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `children_count` int(11) DEFAULT NULL,
  `children_details` text COLLATE utf8mb4_unicode_ci,
  `assistance_needed` text COLLATE utf8mb4_unicode_ci,
  `snap_benefits` tinyint(1) NOT NULL DEFAULT '0',
  `circumstance_details` text COLLATE utf8mb4_unicode_ci,
  `essential_needs` text COLLATE utf8mb4_unicode_ci,
  `essential_circumstances` text COLLATE utf8mb4_unicode_ci,
  `supporting_documents` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `applicant_id`, `assigned_processor_id`, `status`, `grant_amount`, `approval_date`, `name`, `street_address`, `apartment`, `city`, `state`, `zip`, `phone`, `email`, `role`, `children_count`, `children_details`, `assistance_needed`, `snap_benefits`, `circumstance_details`, `essential_needs`, `essential_circumstances`, `supporting_documents`, `created_at`, `updated_at`) VALUES
(42, 53, NULL, 'approved', 500.00, '2025-04-16 07:02:45', 'Michael Sowah', '5909 Liverpool Street', NULL, 'AUBREY', 'IL', NULL, '7083153517', 'sowahm@gmail.com', 'Grand Parent', 3, 'Female, Male', '\"[\\\"Utilities\\\",\\\"Transportation Costs\\\",\\\"Gasoline\\\"]\"', 0, 'Test', '\"[\\\"Support Groups\\\"]\"', 'Test', 'documents/pSVcrAztAxRwlruUslzTZuDrOb01kR0HlcV73uSS.docx', '2025-04-16 05:05:53', '2025-04-16 07:02:45'),
(43, 53, NULL, 'approved', 600.00, '2025-04-15 15:00:00', 'Greg Lee', '5909 Liverpool Street', NULL, 'AUBREY', 'IL', NULL, '7083153517', 'sowahm@gmail.com', 'Grand Parent', 4, 'Rem', '\"[\\\"Housing Assistance\\\",\\\"Utilities\\\",\\\"Transportation Costs\\\"]\"', 1, 'ssdsd', '\"[\\\"Respite Care\\\",\\\"Therapy Services\\\",\\\"Support Groups\\\"]\"', 'dfgdg', 'documents/d8bHsuYGN8iLIU49R568m45zbj4e7aERbeRM9rYp.pdf', '2025-04-16 07:36:56', '2025-04-17 14:14:42');

-- --------------------------------------------------------

--
-- Table structure for table `application_notes`
--

CREATE TABLE `application_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `note_type` enum('initial','follow_up','contact','approval','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'other',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_notes`
--

INSERT INTO `application_notes` (`id`, `application_id`, `user_id`, `note`, `note_type`, `created_at`, `updated_at`) VALUES
(107, 42, 50, 'Test', 'follow_up', '2025-04-16 05:07:21', '2025-04-16 05:07:21'),
(108, 42, 50, 'Approval was made', 'approval', '2025-04-16 07:02:45', '2025-04-16 07:02:45'),
(109, 43, 50, 'Approved for Utility', 'approval', '2025-04-16 07:39:09', '2025-04-16 07:39:09');

-- --------------------------------------------------------

--
-- Table structure for table `approved_applications`
--

CREATE TABLE `approved_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `applicant_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('approved','denied') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'approved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `communications`
--

CREATE TABLE `communications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('approval_letter','state_resources','partnerships') COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `sent_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diary_reminders`
--

CREATE TABLE `diary_reminders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reminder_date` datetime NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_statements`
--

CREATE TABLE `expense_statements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `total_grant_amount` decimal(10,2) NOT NULL,
  `total_expense` decimal(10,2) NOT NULL,
  `deductions` decimal(10,2) NOT NULL,
  `net_amount` decimal(10,2) GENERATED ALWAYS AS (((`total_grant_amount` - `total_expense`) - `deductions`)) STORED,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `first_contacts`
--

CREATE TABLE `first_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `processor_id` bigint(20) UNSIGNED NOT NULL,
  `contact_date` datetime NOT NULL,
  `contact_method` enum('call','meeting') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('scheduled','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'scheduled',
  `decision_outcome` enum('approved','denied','rmi') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `first_contacts`
--

INSERT INTO `first_contacts` (`id`, `application_id`, `processor_id`, `contact_date`, `contact_method`, `status`, `decision_outcome`, `created_at`, `updated_at`) VALUES
(7, 42, 50, '2025-04-16 00:00:00', 'call', 'scheduled', NULL, '2025-04-16 07:33:59', '2025-04-16 07:33:59');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
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
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(47, '2025_02_23_132031_add_role_to_users_table', 1),
(65, '0001_01_01_000000_create_users_table', 2),
(66, '0001_01_01_000001_create_cache_table', 2),
(67, '0001_01_01_000002_create_jobs_table', 2),
(68, '2025_02_21_222934_create_personal_access_tokens_table', 2),
(69, '2025_02_21_230835_create_applications_table', 2),
(70, '2025_02_21_231356_create_application_notes_table', 2),
(71, '2025_02_21_231635_create_diary_reminders_table', 2),
(72, '2025_02_21_231709_create_payments_table', 2),
(73, '2025_02_21_231739_create_communications_table', 2),
(74, '2025_02_21_231805_create_expense_statements_table', 2),
(75, '2025_02_21_231835_create_audit_logs_table', 2),
(76, '2025_02_23_180351_create_personal_access_tokens_table', 2),
(77, '2025_02_24_184520_create_approved_applications_table', 2),
(78, '2025_02_24_185101_drop_role_column_from_users_table', 2),
(79, '2025_02_26_041839_add_role_to_users_table', 3),
(80, '2025_02_27_063041_create_first_contacts_table', 4),
(81, '2025_02_27_160716_create_verbal_contacts_table', 5),
(82, '2025_02_28_021232_create_payments_table', 6),
(83, '2025_02_28_021351_create_audit_logs_table', 6),
(87, '2025_03_08_040006_add_google_id_to_users_table', 7),
(88, '2025_03_08_052127_update_user_roles_to_include_applicant', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_type` enum('service_provider','applicant') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `recipient_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(3, 'App\\Models\\User', 21, 'auth_token', '5985926152c151672c5228ae2bf9038bf38b4a6449b0978ab00ee16828516e6b', '[\"*\"]', NULL, NULL, '2025-02-26 10:26:46', '2025-02-26 10:26:46'),
(33, 'App\\Models\\User', 23, 'auth_token', 'ea28c72538d706fd0d53fdab7238277faf2f4e4df2ed1bf21fe03c484426c9fe', '[\"*\"]', NULL, NULL, '2025-02-26 12:42:26', '2025-02-26 12:42:26'),
(42, 'App\\Models\\User', 20, 'auth_token', 'aa788037193679ad0bc3cd9730fd2240f2a24c0e16e0c1bcf03776128cf9aa09', '[\"*\"]', '2025-02-26 13:26:41', NULL, '2025-02-26 13:25:14', '2025-02-26 13:26:41'),
(63, 'App\\Models\\User', 43, 'auth_token', 'cdb1f7053220ea99f3d277b683b83ae9c33c68727e591b7fa50322dbc4018e99', '[\"*\"]', '2025-02-28 22:28:08', NULL, '2025-02-28 22:20:14', '2025-02-28 22:28:08'),
(75, 'App\\Models\\User', 43, 'auth_token', '292c506216e7e41354e6f8496a46f78adfce1cec6b2b5afcebdc8a02a8b17834', '[\"*\"]', NULL, NULL, '2025-03-08 10:23:14', '2025-03-08 10:23:14'),
(86, 'App\\Models\\User', 43, 'auth_token', '23b492f2d5be52ee0174da2907dbeab58fa43cdee411a20322b803b7c030fbe8', '[\"*\"]', NULL, NULL, '2025-03-08 12:42:27', '2025-03-08 12:42:27'),
(92, 'App\\Models\\User', 43, 'auth_token', '538b1466543b4301ce3e2ffb813c8f2fa724e58803250921e28e42cdd57571e3', '[\"*\"]', NULL, NULL, '2025-03-08 13:07:34', '2025-03-08 13:07:34'),
(97, 'App\\Models\\User', 43, 'auth_token', '457fc206fa4dedbdb6bc7f5856d0262f1c474823d723a36cb3801fbccb6d40d3', '[\"*\"]', NULL, NULL, '2025-03-08 13:17:40', '2025-03-08 13:17:40'),
(102, 'App\\Models\\User', 43, 'auth_token', '35a273f373856dcbee7fa5e6e945fa5b568f8b390c7c9f3e0ae0d2f4bb056f93', '[\"*\"]', '2025-03-08 13:41:10', NULL, '2025-03-08 13:41:07', '2025-03-08 13:41:10'),
(109, 'App\\Models\\User', 43, 'auth_token', '58a6eca688d2a6cd1738df4c9793945be45054403a9fe9bb430e870e938ae050', '[\"*\"]', '2025-03-08 22:44:15', NULL, '2025-03-08 22:42:23', '2025-03-08 22:44:15'),
(110, 'App\\Models\\User', 43, 'auth_token', '6571242a6fbec45e0f0739b6bf4839729d317c8cefca775721519695e4214e7c', '[\"*\"]', '2025-03-08 22:46:15', NULL, '2025-03-08 22:44:13', '2025-03-08 22:46:15'),
(114, 'App\\Models\\User', 43, 'auth_token', '33d14c68bb1b4dd59e6ed7fe9984e90c9081d9ef86f94ec8c53c5bb22a3598e8', '[\"*\"]', '2025-03-08 22:48:19', NULL, '2025-03-08 22:48:16', '2025-03-08 22:48:19'),
(117, 'App\\Models\\User', 45, 'auth_token', 'da807a2c8d7b329176f9332c11f820a2984aef178b3ad0dfc54b64ab016098fd', '[\"*\"]', '2025-03-08 23:01:18', NULL, '2025-03-08 23:01:15', '2025-03-08 23:01:18'),
(118, 'App\\Models\\User', 45, 'auth_token', 'e1f8f87dae47666e408806c7ca3ffc06f2def6fadfcf1b7349b0698c97d082c7', '[\"*\"]', '2025-03-08 23:04:47', NULL, '2025-03-08 23:04:44', '2025-03-08 23:04:47'),
(119, 'App\\Models\\User', 43, 'auth_token', '283803b946ada184565b315226dd904d2c4667452a114a5975757b4f84eb63e3', '[\"*\"]', '2025-03-08 23:05:24', NULL, '2025-03-08 23:05:21', '2025-03-08 23:05:24'),
(120, 'App\\Models\\User', 45, 'auth_token', '008480f6471f88552f16d6e26cf9b7cd75559af7322e6b800b1d30a473d0b715', '[\"*\"]', '2025-03-08 23:05:45', NULL, '2025-03-08 23:05:42', '2025-03-08 23:05:45'),
(121, 'App\\Models\\User', 45, 'auth_token', 'db11b453ef6ad7685c84cd1bc5519dac1acf1ab038e27938618fbf5c7b56c1a4', '[\"*\"]', '2025-03-08 23:06:33', NULL, '2025-03-08 23:06:30', '2025-03-08 23:06:33'),
(122, 'App\\Models\\User', 45, 'auth_token', 'fda484d09f07551b0ba049be7480655fe032f6926fc4ad01d67a5143d1ac51af', '[\"*\"]', '2025-03-08 23:07:35', NULL, '2025-03-08 23:07:32', '2025-03-08 23:07:35'),
(123, 'App\\Models\\User', 45, 'auth_token', '4bcde264ab7ddb2dc3749c5af43742dce138b091dc47c5bd669c5df1a66832f1', '[\"*\"]', '2025-03-08 23:16:11', NULL, '2025-03-08 23:16:08', '2025-03-08 23:16:11'),
(124, 'App\\Models\\User', 45, 'auth_token', '38b0132160ef45e1de0e4982e3194fb520d02a1a0c0f7e39439f18bbb0a7fa84', '[\"*\"]', '2025-03-08 23:16:50', NULL, '2025-03-08 23:16:47', '2025-03-08 23:16:50'),
(125, 'App\\Models\\User', 45, 'auth_token', '48604b787b8f05ee2e0d7f336fb8601d08290b835b20d0d1a90ce4959a67f569', '[\"*\"]', '2025-03-08 23:18:51', NULL, '2025-03-08 23:18:48', '2025-03-08 23:18:51'),
(126, 'App\\Models\\User', 45, 'auth_token', 'f12d97385776e2d348a84a9e1d6a3463257ad2844a96be202b9c2bdacf414f4b', '[\"*\"]', '2025-03-08 23:24:02', NULL, '2025-03-08 23:23:59', '2025-03-08 23:24:02'),
(127, 'App\\Models\\User', 45, 'auth_token', 'f92dfddcbd24e10c8822703a912607a81f602e252d2ce4cc19b8df60344eefc0', '[\"*\"]', '2025-03-08 23:25:18', NULL, '2025-03-08 23:25:15', '2025-03-08 23:25:18'),
(128, 'App\\Models\\User', 45, 'auth_token', '927f77a42878dc2daf5b24a37ac4aa5dfd92ca8183de721c6439c93581d9f6ee', '[\"*\"]', '2025-03-08 23:26:32', NULL, '2025-03-08 23:26:29', '2025-03-08 23:26:32'),
(131, 'App\\Models\\User', 46, 'auth_token', '699b754dd1c3d1e55962795d94420fc2898d7f651bcd0b9b465bbb60980948d5', '[\"*\"]', '2025-03-09 00:25:02', NULL, '2025-03-09 00:25:00', '2025-03-09 00:25:02'),
(132, 'App\\Models\\User', 45, 'auth_token', 'c9d3b2734fc51c51364896626458be3a8176cf3ec95d916ba3cf5dc4a425dd91', '[\"*\"]', '2025-03-09 00:32:36', NULL, '2025-03-09 00:32:35', '2025-03-09 00:32:36'),
(139, 'App\\Models\\User', 45, 'auth_token', 'fd5f036a1097195afa7878cedb8821389a7ae609199b08def27f7aaecb6bb2dc', '[\"*\"]', '2025-03-09 07:42:05', NULL, '2025-03-09 07:42:04', '2025-03-09 07:42:05'),
(142, 'App\\Models\\User', 45, 'auth_token', '98877a2ad6762a8ad619a1e03bba6749a80140db07dc853095539fc8f768623e', '[\"*\"]', NULL, NULL, '2025-03-09 18:18:09', '2025-03-09 18:18:09'),
(155, 'App\\Models\\User', 45, 'auth_token', 'dcb604c49b686d62dfc16e42c054917652756cb0b9b2b6e83864fa73a4722775', '[\"*\"]', '2025-03-10 18:20:42', NULL, '2025-03-10 18:20:41', '2025-03-10 18:20:42'),
(197, 'App\\Models\\User', 44, 'auth_token', 'c94f03ad3de9854c55d45621327ac5bed804e1307570eb2590d035c59e6d6f6d', '[\"*\"]', '2025-04-16 04:44:34', NULL, '2025-04-16 04:31:22', '2025-04-16 04:44:34'),
(200, 'App\\Models\\User', 51, 'auth_token', '75fd376efcb1064d1acd4112a9f81f416567cc0591647192e12437b4f639e625', '[\"*\"]', '2025-04-16 04:51:56', NULL, '2025-04-16 04:51:56', '2025-04-16 04:51:56'),
(201, 'App\\Models\\User', 52, 'auth_token', 'bfc01b72d79b818e6704b30cf0af4751237e81c8782a0cebba089a70e354f7c6', '[\"*\"]', '2025-04-16 04:53:10', NULL, '2025-04-16 04:53:10', '2025-04-16 04:53:10'),
(210, 'App\\Models\\User', 49, 'auth_token', '4544eab025cccac1304ff0e343872b39ee39094eccc80e008d8496fbe9490fa0', '[\"*\"]', '2025-04-16 08:22:48', NULL, '2025-04-16 08:04:18', '2025-04-16 08:22:48'),
(211, 'App\\Models\\User', 50, 'auth_token', 'bb1516765796e9c26cc52ae2551340ad56e230fafb4100eef85e0afd45a7932a', '[\"*\"]', '2025-04-21 06:12:39', NULL, '2025-04-16 19:56:38', '2025-04-21 06:12:39');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('applicant','supervisor','processor','administrator','auditor') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'applicant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `google_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(49, 'Admin User', 'admin@guardianconnect.com', NULL, NULL, '$2y$12$gprRQ7yVArB9WaDzrjeANu9Avdc5TnhFrnNICaDyYUAk2PdZv6FE6', 'GT6O60ee7OKppz5iUmlbwpJDEwi3Eg628UeyXCSjFJISqWU7aYI2S28B84CI', '2025-04-16 04:45:40', '2025-04-16 07:53:58', 'administrator'),
(50, 'Processor', 'processor@guardianconnect.com', NULL, NULL, '$2y$12$fH5fsbf7coXNJEjouD/z3OHfdpDJXU6qLqvCALGmYR7Y0Kf2JH5LG', 'L4qmz4HXQo0DRFEFpYzlsy9EcsKDHroWBUXJWbFDCRMgPKyhsnMdEBvY4Sop', '2025-04-16 04:49:28', '2025-04-16 05:06:30', 'processor'),
(51, 'Supervisor', 'supervisor@guardianconnect.com', NULL, NULL, '$2y$12$TR5ouxL0JIoxkS4MW4n2ceqqA7dEnWbusqMjTWjKNuyWbfcXCFjqS', NULL, '2025-04-16 04:51:56', '2025-04-16 04:51:56', 'supervisor'),
(52, 'Auditor', 'auditor@guardianconnect.com', NULL, NULL, '$2y$12$2yKRThmAiqxlUgUOqBagvO9E5RJySyyK//Mp9I01KrsWDtMfAPaJW', NULL, '2025-04-16 04:53:10', '2025-04-16 04:53:10', 'auditor'),
(53, 'Michael Sowah', 'sowahm@gmail.com', NULL, NULL, '$2y$12$WuMVECZ4.L3cbv7cHUxIx.J8cFlB3FQUWmVlSSijJ3JoR53lopJ7K', 'vWxiLxRhprPZiSAqbr7J6Zdq1pxtLPQkrvJDKfIknA68pF0JptK836eEWWwM', '2025-04-16 05:03:09', '2025-04-16 07:30:39', 'applicant');

-- --------------------------------------------------------

--
-- Table structure for table `users_backup`
--

CREATE TABLE `users_backup` (
  `id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('applicant','processor','admin','auditor') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'applicant',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_backup`
--

INSERT INTO `users_backup` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mrs. Katlyn Aufderhar V', 'russel.royce@example.com', '2025-02-26 06:13:45', '$2y$12$UjZ5sDxry8WuZeywp0FxjuaWPhxxu8HLi4QBYX.F6.CY8ivCSRnPS', 'applicant', '40aWBPt9ra', '2025-02-26 06:13:47', '2025-02-26 06:13:47'),
(2, 'Lorena Schuppe', 'layne50@example.net', '2025-02-26 06:13:45', '$2y$12$Ngum27YrgJh26Ywmco0oA.pOCPlP5w5NJTXjG1JUIQgImhWwAdDh.', 'applicant', 'O7qXLeenvJ', '2025-02-26 06:13:47', '2025-02-26 06:13:47'),
(3, 'Jefferey Rohan', 'zkuhlman@example.com', '2025-02-26 06:13:45', '$2y$12$wHmttL0ceEgwIn1RCoktqO7ZT5fOz0GVEoU9VQGfb5JR2otHiZ5Xq', 'applicant', 'VVajiuqMAb', '2025-02-26 06:13:47', '2025-02-26 06:13:47'),
(4, 'Alvera O\'Reilly', 'gleichner.dayana@example.com', '2025-02-26 06:13:45', '$2y$12$F5Z8Ry.5lYiNiXvj13qkFuRoqLBG7ClnnTKU41VpZcBShKHEy3soe', 'applicant', 'T1pcP3aNIR', '2025-02-26 06:13:47', '2025-02-26 06:13:47'),
(5, 'Wilhelmine Kerluke', 'zulauf.brooks@example.com', '2025-02-26 06:13:45', '$2y$12$YNs1.ZGTf.PubtoUh1uEZ.cqHtNjUTyr8vdqB/oilMu4AC.zrTgZe', 'applicant', '5CyyWM4Q1a', '2025-02-26 06:13:47', '2025-02-26 06:13:47'),
(6, 'Maxime Stiedemann', 'lue.toy@example.org', '2025-02-26 06:13:46', '$2y$12$HcTgMql6BkA9yp.rgR.Ywe1apND92MWZiYQphM0aEXSm5u/lzUrV.', 'applicant', '9OU5j1OL6D', '2025-02-26 06:13:47', '2025-02-26 06:13:47'),
(7, 'Haven Koepp', 'buster74@example.org', '2025-02-26 06:13:46', '$2y$12$6Ug369WruzayPR4eKXnQBuPBZae9DYhI8Oea0ujOXqRGj7LNvOuDu', 'applicant', 'M4xlWZ0pVp', '2025-02-26 06:13:47', '2025-02-26 06:13:47'),
(8, 'Wilhelmine Langosh', 'wmoore@example.org', '2025-02-26 06:13:46', '$2y$12$nC4NFMaR1Wv6yWXQKzsxrOgdUGpIrRgkDbtWoYa1/FBTO/V8wfoae', 'applicant', 'N7CCJO0eis', '2025-02-26 06:13:47', '2025-02-26 06:13:47'),
(9, 'Adaline Koss', 'jessyca01@example.org', '2025-02-26 06:13:46', '$2y$12$GyklUW12PxcMVZ/Tzsu0eeGrgTUzrUdNFTOXtGSw9Cdg2zzaeyU6.', 'applicant', 'K2H3bR5YOo', '2025-02-26 06:13:47', '2025-02-26 06:13:47'),
(10, 'Ludwig Runolfsdottir', 'dare.dorothea@example.net', '2025-02-26 06:13:46', '$2y$12$NJx0ehh3GmRcn5ApWIKaT.8AH.KkRWLxgFjYSQ/kl3bkAwv5dPLlu', 'applicant', 'MZgIypQLmG', '2025-02-26 06:13:47', '2025-02-26 06:13:47'),
(11, 'Monserrat Walter', 'zblick@example.net', '2025-02-26 06:13:47', '$2y$12$/xwSSWdbY/rqvm.oizwrguVsyLbfBCZGYVnhHrKu1q3mkV0RQDa1y', 'processor', 'HWWBZR8LDU', '2025-02-26 06:13:48', '2025-02-26 06:13:48'),
(12, 'Omer Pfeffer PhD', 'mdoyle@example.net', '2025-02-26 06:13:47', '$2y$12$9S0qiIfqq3BRjkEj6jJ6KuVtrssEkXtvgh4eoJ2v7gXi682WI85o.', 'processor', 'JBwOuXYpEd', '2025-02-26 06:13:48', '2025-02-26 06:13:48'),
(13, 'Elizabeth Bode II', 'korbin.homenick@example.net', '2025-02-26 06:13:47', '$2y$12$OVaF9T7yI3vmnYkUT8V23uJNLDJbi8q0n8grsZ1lj5FJByAiWljNG', 'processor', 'ILXpzqBD8L', '2025-02-26 06:13:48', '2025-02-26 06:13:48'),
(14, 'Prof. Rosendo Stroman IV', 'eprice@example.org', '2025-02-26 06:13:47', '$2y$12$BYRCos37qWyBYELwB0nwP.MAEWFjMR1SFWwMrCJGWynCIIb/3Ixbi', 'processor', 'vbdKQtYsPn', '2025-02-26 06:13:48', '2025-02-26 06:13:48'),
(15, 'Jovany Skiles', 'tcassin@example.org', '2025-02-26 06:13:48', '$2y$12$8skMZOYC/UEM.ViLz0NkCeVIVhS/39Umx/qaAPXObt/8RIwjY3bBa', 'processor', 'cRS6FlUADP', '2025-02-26 06:13:48', '2025-02-26 06:13:48'),
(16, 'Delilah Grimes', 'flittle@example.org', '2025-02-26 06:13:48', '$2y$12$qDmxbLQOzgqljRXnOQaC7uCmYqAdVNTg6apzBmPuEOfQ1/YmRsHX.', 'admin', '0v0aCmw3cf', '2025-02-26 06:13:48', '2025-02-26 06:13:48'),
(17, 'Dr. Julie Auer', 'alexandra30@example.org', '2025-02-26 06:13:48', '$2y$12$KCzph8Mc5RQeNmrRMGIZiOZmpf1RoBiKt4qp3UQibB8DhEftbLoB2', 'admin', 'mdvi5PbDxb', '2025-02-26 06:13:48', '2025-02-26 06:13:48'),
(18, 'Johnnie Funk', 'rhiannon.dubuque@example.com', '2025-02-26 06:13:48', '$2y$12$i/6O3sOmTDB4mnDmtOK0OO9YgAHcirvr5jtM6/tX.yPr8946cUgG6', 'auditor', 'S9XlZVvptF', '2025-02-26 06:13:49', '2025-02-26 06:13:49'),
(19, 'Linwood Schroeder', 'treutel.britney@example.com', '2025-02-26 06:13:48', '$2y$12$AzamWmTVrhEsqG33XDa3s.cl2adNag9JnUlnR9F3gdR4bQsuXaHf2', 'auditor', 'zXzKVAP4km', '2025-02-26 06:13:49', '2025-02-26 06:13:49');

-- --------------------------------------------------------

--
-- Table structure for table `verbal_contacts`
--

CREATE TABLE `verbal_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `processor_id` bigint(20) UNSIGNED NOT NULL,
  `contact_successful` tinyint(1) NOT NULL DEFAULT '0',
  `contact_notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `verbal_contacts`
--

INSERT INTO `verbal_contacts` (`id`, `application_id`, `processor_id`, `contact_successful`, `contact_notes`, `created_at`, `updated_at`) VALUES
(7, 42, 50, 1, NULL, '2025-04-16 07:34:12', '2025-04-16 07:34:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applications_applicant_id_foreign` (`applicant_id`),
  ADD KEY `applications_assigned_processor_id_foreign` (`assigned_processor_id`);

--
-- Indexes for table `application_notes`
--
ALTER TABLE `application_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_notes_application_id_foreign` (`application_id`),
  ADD KEY `application_notes_user_id_foreign` (`user_id`);

--
-- Indexes for table `approved_applications`
--
ALTER TABLE `approved_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approved_applications_application_id_foreign` (`application_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`),
  ADD KEY `audit_logs_application_id_foreign` (`application_id`);

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
-- Indexes for table `communications`
--
ALTER TABLE `communications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `communications_application_id_foreign` (`application_id`);

--
-- Indexes for table `diary_reminders`
--
ALTER TABLE `diary_reminders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diary_reminders_application_id_foreign` (`application_id`),
  ADD KEY `diary_reminders_user_id_foreign` (`user_id`);

--
-- Indexes for table `expense_statements`
--
ALTER TABLE `expense_statements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expense_statements_application_id_foreign` (`application_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `first_contacts`
--
ALTER TABLE `first_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `first_contacts_application_id_foreign` (`application_id`),
  ADD KEY `first_contacts_processor_id_foreign` (`processor_id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_application_id_foreign` (`application_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
-- Indexes for table `verbal_contacts`
--
ALTER TABLE `verbal_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `verbal_contacts_application_id_foreign` (`application_id`),
  ADD KEY `verbal_contacts_processor_id_foreign` (`processor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `application_notes`
--
ALTER TABLE `application_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `approved_applications`
--
ALTER TABLE `approved_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `communications`
--
ALTER TABLE `communications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diary_reminders`
--
ALTER TABLE `diary_reminders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_statements`
--
ALTER TABLE `expense_statements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `first_contacts`
--
ALTER TABLE `first_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `verbal_contacts`
--
ALTER TABLE `verbal_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_applicant_id_foreign` FOREIGN KEY (`applicant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_assigned_processor_id_foreign` FOREIGN KEY (`assigned_processor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `application_notes`
--
ALTER TABLE `application_notes`
  ADD CONSTRAINT `application_notes_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `application_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `approved_applications`
--
ALTER TABLE `approved_applications`
  ADD CONSTRAINT `approved_applications_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `communications`
--
ALTER TABLE `communications`
  ADD CONSTRAINT `communications_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `diary_reminders`
--
ALTER TABLE `diary_reminders`
  ADD CONSTRAINT `diary_reminders_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diary_reminders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expense_statements`
--
ALTER TABLE `expense_statements`
  ADD CONSTRAINT `expense_statements_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `first_contacts`
--
ALTER TABLE `first_contacts`
  ADD CONSTRAINT `first_contacts_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `first_contacts_processor_id_foreign` FOREIGN KEY (`processor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `verbal_contacts`
--
ALTER TABLE `verbal_contacts`
  ADD CONSTRAINT `verbal_contacts_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `verbal_contacts_processor_id_foreign` FOREIGN KEY (`processor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
