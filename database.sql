-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 21, 2024 at 10:51 PM
-- Server version: 10.11.6-MariaDB-0+deb12u1
-- PHP Version: 8.2.20
-- Made by Meandoyou and StingAving https://github.com/g0k1/love-stresser

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `lovestresser`
--

CREATE DATABASE IF NOT EXISTS `lovestresser` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `lovestresser`;

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `content` text NOT NULL,
  `date` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `attacks`
--

CREATE TABLE `attacks` (
  `id` int(11) NOT NULL,
  `user_token` varchar(255) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `port` int(11) NOT NULL,
  `method` varchar(50) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `attack_logs`
--

CREATE TABLE `attack_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attack_layer` varchar(255) NOT NULL,
  `attack_target` varchar(255) NOT NULL,
  `attack_duration` int(11) NOT NULL,
  `attack_method` varchar(255) NOT NULL,
  `attack_port` varchar(255) NOT NULL,
  `attack_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `blacklist`
--

CREATE TABLE `blacklist` (
  `id` int(11) NOT NULL,
  `host` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `grabber_data`
--

CREATE TABLE `grabber_data` (
  `id` int(11) NOT NULL,
  `code` varchar(8) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `loc` varchar(255) DEFAULT NULL,
  `org` varchar(255) DEFAULT NULL,
  `postal` varchar(20) DEFAULT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `os` varchar(255) DEFAULT NULL,
  `screen` varchar(255) DEFAULT NULL,
  `gpu` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `name` varchar(255) DEFAULT 'NONE',
  `is_vpn` tinyint(1) DEFAULT 0,
  `is_proxy` tinyint(1) DEFAULT 0,
  `is_tor` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `images_admin`
--

CREATE TABLE `images_admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `plan_codes`
--

CREATE TABLE `plan_codes` (
  `code` varchar(255) NOT NULL,
  `plan` varchar(255) NOT NULL,
  `redeem_time` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `redeemed` tinyint(4) DEFAULT 0,
  `duration` varchar(10) DEFAULT NULL,
  `is_sellix` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `grabber_ids`
--

CREATE TABLE `grabber_ids` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `discord_id` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `banned` tinyint(1) DEFAULT 0,
  `rank` varchar(255) DEFAULT 'member',
  `plan` varchar(255) DEFAULT 'free',
  `concurents` int(11) DEFAULT 0,
  `max_time` int(11) DEFAULT 0,
  `methods` text DEFAULT NULL,
  `daily_attacks_limit` text DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `guilds` text DEFAULT NULL,
  `plan_expire` datetime DEFAULT NULL,
  `ban_reason` varchar(255) DEFAULT NULL,
  `profile_type` varchar(255) DEFAULT NULL,
  `profile_background` text DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `announcements`
--

ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attacks`
--

ALTER TABLE `attacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attack_logs`
--

ALTER TABLE `attack_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `blacklist`
--

ALTER TABLE `blacklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grabber_data`
--

ALTER TABLE `grabber_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grabber_ids`
--

ALTER TABLE `grabber_ids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--

ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `images_admin`
--

ALTER TABLE `images_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `plan_codes`
--

ALTER TABLE `plan_codes`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `users`
--

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discord_id` (`discord_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `token` (`token`),
  ADD UNIQUE KEY `display_name` (`display_name`);

--
-- AUTO_INCREMENT for table `announcements`
--

ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attacks`
--

ALTER TABLE `attacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2196;

--
-- AUTO_INCREMENT for table `attack_logs`
--

ALTER TABLE `attack_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5596;

--
-- AUTO_INCREMENT for table `blacklist`
--

ALTER TABLE `blacklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `grabber_data`
--

ALTER TABLE `grabber_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `grabber_ids`
--

ALTER TABLE `grabber_ids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `images`
--

ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `images_admin`
--

ALTER TABLE `images_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=854;

--
-- Constraints for table `attack_logs`
--

ALTER TABLE `attack_logs`
  ADD CONSTRAINT `attack_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;
