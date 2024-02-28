-- -------------------------------------------------------------
-- TablePlus 3.7.1(332)
--
-- https://tableplus.com/
--
-- Database: sample
-- Generation Time: 2024-02-28 17:08:47.5710
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


CREATE TABLE `articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `article_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `articles` (`id`, `user_id`, `title`, `body`, `created_at`, `updated_at`) VALUES
('1', '2', 'Test Article 1', 'Bpdy of test article 1', '2024-02-27 14:21:06', '2024-02-27 14:21:06'),
('3', '2', 'Test Article 3', 'Bpdy of test article 3', '2024-02-27 14:25:22', '2024-02-27 14:25:22'),
('4', '2', 'Article 4 1', 'Article Body 4', '2024-02-28 10:54:02', '2024-02-28 11:12:44');

INSERT INTO `likes` (`id`, `user_id`, `article_id`, `created_at`, `updated_at`) VALUES
('1', '3', '1', '2024-02-28 08:11:46', '2024-02-28 08:11:46'),
('3', '3', '3', '2024-02-28 09:12:58', '2024-02-28 09:12:58'),
('4', '2', '1', '2024-02-28 09:19:27', '2024-02-28 09:19:27'),
('5', '4', '3', '2024-02-28 09:24:27', '2024-02-28 09:24:27');

INSERT INTO `users` (`id`, `email`, `password`, `created_at`, `updated_at`) VALUES
('2', 'divyaraj@gmail.com', '$2y$10$SXbXcWylnLfb4Ou4jdObseSxSsUPNTOsEWF2MyTTzLO4hLdMtMcp2', '2024-02-27 13:36:24', '2024-02-27 13:36:24'),
('3', 'divyaraj1@gmail.com', '$2y$10$.n3ffLuxENQcjN3410IhbuntBg0Gm8YPREMCKMNrA/smTWG942502', '2024-02-27 13:43:46', '2024-02-27 13:43:46'),
('4', 'divyaraj3@gmail.com', '$2y$10$OIjfBYSdkat7clN9RUSt7.0NwVBVVlrwsKkwbzwC1sAKx3kDTgUfK', '2024-02-28 09:18:14', '2024-02-28 09:18:14');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;