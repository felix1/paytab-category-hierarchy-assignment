-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 25, 2020 at 03:14 PM
-- Server version: 8.0.11
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_codeigniter`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories_hierarchy`
--

DROP TABLE IF EXISTS `categories_hierarchy`;
CREATE TABLE IF NOT EXISTS `categories_hierarchy` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_category_foreign_key` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories_hierarchy`
--

INSERT INTO `categories_hierarchy` (`id`, `title`, `parent_id`) VALUES
(0, 'Root Category', NULL),
(1, 'Cat 1', 0),
(2, 'Cat 2', 0),
(3, 'Cat 3', 0),
(4, 'Cat 3 1', 3),
(5, 'Cat 3 2', 3),
(6, 'Cat 3 2 1', 5),
(8, 'Cat 1 1', 1),
(9, 'Cat 1 2', 1),
(10, 'Cat 1 3', 1),
(11, 'Cat 1 2 1', 9),
(12, 'Cat 2 1', 2),
(13, 'Cat 2 2', 2),
(14, 'Cat 2 2 1', 13),
(16, 'Cat 1 2 1 1', 11);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories_hierarchy`
--
ALTER TABLE `categories_hierarchy`
  ADD CONSTRAINT `parent_category_foreign_key` FOREIGN KEY (`parent_id`) REFERENCES `categories_hierarchy` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
