-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Server version: 8.0.12
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sp`
--

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `division_name` varchar(32) NOT NULL,
  `division_description` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`division_id`, `division_name`, `division_description`) VALUES
(1, 'Підрозділ', '');

-- --------------------------------------------------------

--
-- Table structure for table `invites`
--

CREATE TABLE `invites` (
  `invite_id` bigint(20) UNSIGNED NOT NULL,
  `invite_get_user` bigint(20) UNSIGNED DEFAULT NULL,
  `invite_code` varchar(16) NOT NULL,
  `invite_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `invite_disabled` tinyint(1) NOT NULL DEFAULT '0',
  `invite_reg_user` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `request_id` bigint(20) UNSIGNED NOT NULL,
  `request_title` varchar(64) NOT NULL,
  `request_description` varchar(256) NOT NULL,
  `request_user` bigint(20) UNSIGNED NOT NULL,
  `request_division` bigint(20) UNSIGNED DEFAULT NULL,
  `request_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `request_meta`
--

CREATE TABLE `request_meta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `request_id` bigint(20) UNSIGNED NOT NULL,
  `request_status` tinyint(1) NOT NULL,
  `status_set_user` bigint(20) UNSIGNED NOT NULL,
  `meta_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `session_user` bigint(20) UNSIGNED NOT NULL,
  `session_key` varchar(32) NOT NULL,
  `session_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `session_end` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `session_disabled` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `session_user`, `session_key`, `session_start`, `session_end`, `session_disabled`) VALUES
(1, 1, 'kfd5o8pb4ksnq4db0fslvg3lotro8nnn', '2019-01-25 17:00:53', '2019-01-25 17:50:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_email` varchar(64) NOT NULL,
  `user_pass` varchar(256) NOT NULL,
  `user_firstname` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `user_secondname` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `user_lastname` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `user_division` bigint(20) UNSIGNED DEFAULT NULL,
  `user_post` varchar(16) DEFAULT NULL,
  `user_phone` varchar(16) DEFAULT NULL,
  `user_locked` tinyint(1) NOT NULL DEFAULT '0',
  `user_level` tinyint(1) NOT NULL DEFAULT '1',
  `user_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_register` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_pass`, `user_firstname`, `user_secondname`, `user_lastname`, `user_division`, `user_post`, `user_phone`, `user_locked`, `user_level`, `user_update`, `user_register`) VALUES
(1, 'admin@admin', '$2y$10$78j6.oY3/yE9JXmmM07nHesxK7yhOh.qkEq2CplthSdd3ahISD.wO', 'Ім\'я', '', 'Прізвище', 1, 'Посада', 'Телефон', 0, 3, '2019-01-25 17:37:59', '2016-03-12 17:20:01'),
(2, 'moder@moder', '$2y$10$78j6.oY3/yE9JXmmM07nHesxK7yhOh.qkEq2CplthSdd3ahISD.wO', 'Ім\'я', '', 'Прізвище', NULL, '', '', 0, 2, '2019-01-26 00:40:45', '2016-03-12 17:23:55'),
(3, 'user@user', '$2y$10$78j6.oY3/yE9JXmmM07nHesxK7yhOh.qkEq2CplthSdd3ahISD.wO', 'Ім\'я', '', 'Прізвище', NULL, NULL, NULL, 0, 1, '2019-01-26 00:40:56', '2016-03-12 17:27:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`division_id`),
  ADD UNIQUE KEY `division_name` (`division_name`);

--
-- Indexes for table `invites`
--
ALTER TABLE `invites`
  ADD PRIMARY KEY (`invite_id`),
  ADD UNIQUE KEY `invite_reg_user` (`invite_reg_user`),
  ADD KEY `invite_get_user` (`invite_get_user`),
  ADD KEY `invite_code` (`invite_code`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `request_user` (`request_user`),
  ADD KEY `requrest_division` (`request_division`);

--
-- Indexes for table `request_meta`
--
ALTER TABLE `request_meta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `status_set_user` (`status_set_user`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `session_user` (`session_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD KEY `user_division` (`user_division`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `division_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invites`
--
ALTER TABLE `invites`
  MODIFY `invite_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_meta`
--
ALTER TABLE `request_meta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invites`
--
ALTER TABLE `invites`
  ADD CONSTRAINT `get_user_fk_invites` FOREIGN KEY (`invite_get_user`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reg_user_fk_invites` FOREIGN KEY (`invite_reg_user`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_fk_division` FOREIGN KEY (`request_division`) REFERENCES `divisions` (`division_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `requests_fk_users` FOREIGN KEY (`request_user`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `request_meta`
--
ALTER TABLE `request_meta`
  ADD CONSTRAINT `request_meta_fk_users` FOREIGN KEY (`status_set_user`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `request_meta_fr_requests` FOREIGN KEY (`request_id`) REFERENCES `requests` (`request_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_fk_users` FOREIGN KEY (`session_user`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_fk_divisions` FOREIGN KEY (`user_division`) REFERENCES `divisions` (`division_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
