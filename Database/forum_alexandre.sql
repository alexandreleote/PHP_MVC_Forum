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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_alexandre.message : ~13 rows (environ)
DELETE FROM `message`;
INSERT INTO `message` (`id_message`, `content`, `creationDate`, `user_id`, `topic_id`) VALUES
	(1, 'Id nec inter permissus humilia comitem impetraret monili humilia occideretur fines nullo misceri pretioso misceri mediocrium reginae mediocrium repentina tum mors ferebatur nec amore ad inter impotentia eius nec introducta.\r\n\r\n', '2024-12-14 13:07:49', 1, 1),
	(2, 'Test', '2024-12-15 14:46:00', 1, 6),
	(3, 'Je voudrais tester davantage de fonctions - telles que trouver la meilleur fa&ccedil;on d&#039;afficher tout cela en d&eacute;tails', '2024-12-15 14:50:09', 1, 7),
	(4, 'C&#039;est simple faut avoir de bonnes armes au début de la partie', '2024-12-15 14:50:35', 1, 8),
	(5, 'L&#039;effet parallaxe permet d&#039;ajouter une image en fond avec un rendu int&eacute;ressant lors du scroll de la page.', '2024-12-15 15:05:28', 1, 9),
	(6, 'J&#039;aime bien l&#039;effet !', '2024-12-15 15:35:27', 1, 9),
	(7, 'Est-ce que l&#039;on peut en savoir plus ?', '2024-12-15 15:35:43', 1, 9),
	(8, 'Est-ce que l&#039;on peut en savoir plus ?', '2024-12-15 15:36:13', 1, 9),
	(9, 'Alors pour en savoir plus, il ne faut pas h&eacute;siter &agrave; regarder sur MDN directement !', '2024-12-15 15:36:38', 1, 9),
	(10, 'Et pour en faire une image parallaxe dans un header ?', '2024-12-15 15:37:36', 1, 9),
	(11, 'Moi je n&#039;aime pas on voit cela tout le temps\r\n', '2024-12-15 15:39:14', 1, 9),
	(12, 'Au risque d&#039;en surprendre plus d&#039;un il s&#039;agit vraiment d&#039;une technique habile pour cr&eacute;er de la texture sans trop se presser', '2024-12-15 15:40:17', 1, 9),
	(13, 'Mauvaise cat&eacute;gorie -&gt; il faut faire un ticket pour changer cela', '2024-12-15 15:42:25', 1, 4);

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

-- Listage des données de la table forum_alexandre.topic : ~5 rows (environ)
DELETE FROM `topic`;
INSERT INTO `topic` (`id_topic`, `title`, `creationDate`, `isLocked`, `user_id`, `category_id`) VALUES
	(1, 'Les joies de CSS et du nesting', '2024-12-14 13:07:41', 0, 1, 2),
	(2, 'La sémantique cet outil indispensable', '2024-12-15 12:00:03', 0, 1, 1),
	(3, 'Swift, les bases et ses 10 principales fonctionnalités', '2023-12-15 12:00:30', 0, 1, 5),
	(4, 'Oubliez le sélecteur de document, voici la nouvelle façon plus permissive de cibler un élément', '2022-12-15 12:01:02', 0, 1, 3),
	(5, 'Je suis perdu, j\'ai besoin de votre aide', '2024-02-15 12:01:57', 0, 1, 4),
	(6, 'Test', '2024-12-15 14:46:00', 0, 1, 2),
	(7, 'Test plus long pour savoir de quoi on parle', '2024-12-15 14:50:09', 0, 1, 2),
	(8, 'Comment battre les niveaux dans Havoc Hotel 3', '2024-12-15 14:50:35', 0, 1, 2),
	(9, 'Obtenir un effet parallaxe optimal ', '2024-12-15 15:05:28', 0, 1, 2);

-- Listage de la structure de table forum_alexandre. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nickName` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `subscriptionDate` date NOT NULL,
  `userRole` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_alexandre.user : ~0 rows (environ)
DELETE FROM `user`;
INSERT INTO `user` (`id_user`, `nickName`, `email`, `password`, `subscriptionDate`, `userRole`) VALUES
	(1, 'Alex', 'alex@test.com', '123123123', '2024-12-14', 'Admin');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
