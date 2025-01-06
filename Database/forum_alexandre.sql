-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forum_alexandre
CREATE DATABASE IF NOT EXISTS `forum_alexandre` /*!40100 DEFAULT CHARACTER SET latin1 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forum_alexandre`;

-- Listage de la structure de table forum_alexandre. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_alexandre.category : ~6 rows (environ)
DELETE FROM `category`;
INSERT INTO `category` (`id_category`, `name`) VALUES
	(1, 'HTML'),
	(2, 'CSS'),
	(3, 'JAVASCRIPT'),
	(4, 'Python'),
	(5, 'Swift'),
	(6, 'Symfony');

-- Listage de la structure de table forum_alexandre. message
CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL DEFAULT '0',
  `topic_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_message`),
  KEY `FK_message_user` (`user_id`),
  KEY `FK_message_topic` (`topic_id`),
  CONSTRAINT `FK_message_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_message_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_alexandre.message : ~23 rows (environ)
DELETE FROM `message`;
INSERT INTO `message` (`id_message`, `content`, `creationDate`, `user_id`, `topic_id`) VALUES
	(3, 'erdftgh', '2024-12-17 14:49:17', 3, 1),
	(5, 'azeaze', '2024-12-17 23:00:08', 1, 2),
	(6, 'azeazeaze', '2024-12-17 23:00:12', 1, 2),
	(7, 'Oui je vois ce que tu veux dire par l&agrave; !', '2025-01-06 08:39:10', 1, 1),
	(8, 'Bonjour je voudrais avoir vos avis &agrave; chacun : \r\nJe souhaitais faire que mon soit d&#039;une certaine mani&egrave;re', '2025-01-06 08:54:12', 4, 3),
	(9, 'azertyuriktglhgcnfbd', '2025-01-06 09:17:40', 5, 4),
	(10, 'a', '2025-01-06 09:18:06', 5, 5),
	(11, 'azertthjy', '2025-01-06 09:21:32', 5, 1),
	(12, 'aeqrz&quot;stdyfjgk', '2025-01-06 09:22:02', 5, 1),
	(14, 'azeetgytrh', '2025-01-06 09:50:16', 5, 2),
	(15, 'azergtreyzt', '2025-01-06 09:50:22', 5, 2),
	(16, 'azretgthdyjtukyfgil;hj:kb;v,hngfbd', '2025-01-06 09:50:32', 5, 2),
	(17, 'azeazr', '2025-01-06 09:50:42', 5, 6),
	(18, 'aezrtyukiglhom', '2025-01-06 10:32:31', 5, 7),
	(19, 'zaeqzdrfstgdsfhy', '2025-01-06 10:39:19', 5, 7),
	(20, 'azretgyrhtjyfdgsfdqse', '2025-01-06 10:44:10', 5, 3),
	(22, 'azeqrsfdgthyvjbuk,n;il,:m;!', '2025-01-06 10:48:44', 6, 7),
	(23, 'Message &agrave; moi', '2025-01-06 10:48:55', 6, 7),
	(24, 'Tout est dans le nom du sujet', '2025-01-06 10:49:49', 6, 8),
	(26, 'Incompr&eacute;hensible l&agrave;....', '2025-01-06 10:56:03', 6, 7),
	(27, '^poihgvyiopk^l', '2025-01-06 13:45:40', 6, 7),
	(28, 'azqetrgyhju', '2025-01-06 14:20:15', 5, 8),
	(32, 'azeoiuazoeiuazoieu', '2025-01-06 16:34:26', 5, 9);

-- Listage de la structure de table forum_alexandre. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isLocked` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id_topic`),
  KEY `FK_topic_user` (`user_id`),
  KEY `FK_topic_category` (`category_id`),
  CONSTRAINT `FK_topic_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `FK_topic_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_alexandre.topic : ~9 rows (environ)
DELETE FROM `topic`;
INSERT INTO `topic` (`id_topic`, `title`, `creationDate`, `isLocked`, `user_id`, `category_id`) VALUES
	(1, 'test python', '2024-12-17 14:46:55', 0, 1, 4),
	(2, 'azeaze', '2024-12-17 23:00:08', 0, 1, 4),
	(3, 'Question sur les &eacute;l&eacute;ments Flex et Grid', '2025-01-06 08:54:12', 1, 4, 1),
	(4, 'azertyhujikggfhgdfs', '2025-01-06 09:17:40', 1, 5, 2),
	(5, 'azerstgrdyhfujgikgfjghfdd', '2025-01-06 09:18:06', 0, 5, 3),
	(6, 'azertgyheduj', '2025-01-06 09:50:42', 0, 5, 4),
	(7, 'azertysudrufkihyhjgnfbds', '2025-01-06 10:32:31', 0, 5, 1),
	(8, 'Quelles sont les normes en HTML en 2025 ?', '2025-01-06 10:49:49', 0, 6, 1),
	(9, 'Prochain sujet Pelo', '2025-01-06 16:34:26', 0, 5, 6);

-- Listage de la structure de table forum_alexandre. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nickName` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `subscriptionDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userRole` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Membre',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_alexandre.user : ~6 rows (environ)
DELETE FROM `user`;
INSERT INTO `user` (`id_user`, `nickName`, `email`, `password`, `subscriptionDate`, `userRole`) VALUES
	(1, 'test', 'test@test.test', '$2y$10$pYmPqzW9mSCtf2L7ESYZheeSOXCn5ONKX3L9yQI58YF4n4ZUcTIPm', '2024-12-17 13:31:46', 'Membre'),
	(2, 'Admin', 'admin@admin.admin', '$2y$10$t1Ahy1bfoY1VsHHpO4Q.Xui/bZ23ZZjnMGO07DlA8ygRWL7erG9q6', '2024-12-17 14:09:43', 'Admin'),
	(3, 'micka', 'micka@exemple.com', '$2y$10$OYH9EA16fC5ONQ/j6xbhwOb7KIRoM4IcKKe99Oz/Vqy0BmVsJCPLS', '2024-12-17 14:45:55', 'Membre'),
	(4, 'EternalStudent', 'test2@test.fr', '$2y$10$i06iliHCa9LJ65t2MNFXZ.Fnfm3OVw6soZ2pA/DdRHSPKUxvGOEve', '2025-01-06 08:51:45', 'Membre'),
	(5, 'TestGalileo', 'test3@test.fr', '$2y$10$2bYh7IimPoDAchBU8cWui.KoPULT9jFgPMVIBgHe6uWNXv/0Wwi8G', '2025-01-06 09:14:36', 'Admin'),
	(6, 'test', 'test4@test.fr', '$2y$10$OurWuYPKBl19LGGxxJLZquzkTEFvjK9DuS3ZZTVh7s9eCybPgjnfy', '2025-01-06 10:48:30', 'Membre');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
