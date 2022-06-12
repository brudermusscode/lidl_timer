-- MariaDB dump 10.19  Distrib 10.7.3-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: lidl_timer_dev
-- ------------------------------------------------------
-- Server version	10.7.3-MariaDB-1:10.7.3+maria~focal

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cron_jobs`
--

DROP TABLE IF EXISTS `cron_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cron_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `script_name` text DEFAULT NULL,
  `last_run` timestamp NULL DEFAULT NULL,
  `next_run` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cron_jobs`
--

LOCK TABLES `cron_jobs` WRITE;
/*!40000 ALTER TABLE `cron_jobs` DISABLE KEYS */;
INSERT INTO `cron_jobs` VALUES
(1,'update_last_vote_date.php','2022-06-14 06:11:28','2022-06-14 06:11:58','2022-06-12 10:46:07','2022-06-14 06:11:28');
/*!40000 ALTER TABLE `cron_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `main_settings`
--

DROP TABLE IF EXISTS `main_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `main_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `favicon` text DEFAULT NULL,
  `is_main` int(11) NOT NULL DEFAULT 0,
  `show_errors` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `main_settings`
--

LOCK TABLES `main_settings` WRITE;
/*!40000 ALTER TABLE `main_settings` DISABLE KEYS */;
INSERT INTO `main_settings` VALUES
(1,'LiDL Timer','/favicon.ico',0,1);
/*!40000 ALTER TABLE `main_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `main_urls`
--

DROP TABLE IF EXISTS `main_urls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `main_urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main` text DEFAULT NULL,
  `github` text DEFAULT NULL,
  `styles` text DEFAULT NULL,
  `scripts` text DEFAULT NULL,
  `icons` text DEFAULT NULL,
  `images` text DEFAULT NULL,
  `fonts` text DEFAULT NULL,
  `sounds` text DEFAULT NULL,
  `jobs` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `main_urls`
--

LOCK TABLES `main_urls` WRITE;
/*!40000 ALTER TABLE `main_urls` DISABLE KEYS */;
INSERT INTO `main_urls` VALUES
(1,'http://localhost','https://www.github.com/brudermusscode/lidl_timer','http://localhost/app/assets/stylesheets/compiled','http://localhost/app/assets/scripts','http://localhost/app/assets/icons','http://localhost/app/assets/images','http://localhost/app/assets/fonts','http://localhost/app/assets/sounds','http://localhost/app/jobs');
/*!40000 ALTER TABLE `main_urls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_authentications`
--

DROP TABLE IF EXISTS `user_authentications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_authentications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `code` varchar(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_authentications`
--

LOCK TABLES `user_authentications` WRITE;
/*!40000 ALTER TABLE `user_authentications` DISABLE KEYS */;
INSERT INTO `user_authentications` VALUES
(1,1,'2416','2022-06-02 21:18:46','2022-06-02 21:18:49'),
(2,1,'8365','2022-06-02 21:22:48','2022-06-02 21:22:51'),
(3,1,'7409','2022-06-02 21:23:42','2022-06-02 21:23:45'),
(4,1,'8072','2022-06-02 21:51:40','2022-06-02 21:53:45'),
(5,1,'7321','2022-06-02 21:53:38','2022-06-02 21:53:45'),
(6,1,'8156','2022-06-02 22:14:11','2022-06-10 10:45:08'),
(7,1,'9510','2022-06-10 10:45:03','2022-06-10 10:45:08'),
(8,1,'3942','2022-06-11 11:50:21','2022-06-11 12:55:02'),
(9,1,'1027','2022-06-11 11:50:42','2022-06-11 12:55:02'),
(10,1,'8204','2022-06-11 11:57:05','2022-06-11 12:55:02'),
(11,1,'4278','2022-06-11 11:57:39','2022-06-11 12:55:02'),
(12,1,'0984','2022-06-11 11:57:53','2022-06-11 12:55:02'),
(13,1,'8169','2022-06-11 12:54:58','2022-06-11 12:55:02'),
(14,3,'6925','2022-06-11 13:02:35','2022-06-11 13:03:26'),
(15,4,'7413','2022-06-11 13:38:50','2022-06-11 13:38:53'),
(16,4,'5714','2022-06-11 14:48:34','2022-06-11 14:48:38'),
(17,3,'5832','2022-06-13 18:24:19','2022-06-13 18:24:22'),
(18,3,'7854','2022-06-13 18:26:33','2022-06-13 18:26:36'),
(19,1,'7896','2022-06-14 07:00:53','2022-06-14 07:00:56'),
(20,3,'2304','2022-06-14 07:01:28','2022-06-14 07:01:31'),
(21,3,'9317','2022-06-13 04:00:26','2022-06-13 04:00:30'),
(22,3,'6803','2022-06-11 23:24:48','2022-06-11 23:34:42'),
(23,3,'0637','2022-06-11 23:26:19','2022-06-11 23:34:42'),
(24,3,'1385','2022-06-11 23:26:53','2022-06-11 23:34:42'),
(25,1,'6934','2022-06-11 23:27:34',NULL),
(26,1,'8167','2022-06-11 23:28:23',NULL),
(27,3,'3685','2022-06-11 23:34:38','2022-06-11 23:34:42');
/*!40000 ALTER TABLE `user_authentications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_sessions`
--

DROP TABLE IF EXISTS `user_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` text DEFAULT NULL,
  `serial` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_sessions_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_sessions`
--

LOCK TABLES `user_sessions` WRITE;
/*!40000 ALTER TABLE `user_sessions` DISABLE KEYS */;
INSERT INTO `user_sessions` VALUES
(11,4,'388a0bfd1030ce975ec12b9c72c1ef059a3c35682bac721936a9fb4c6f0bd12723b5','d59374cb11b4fc2f3d0396338cbc5ab39f6632b654b7df42fc681b24f0501fcf8a61','2022-06-11 14:48:38','2022-06-11 14:48:38'),
(14,1,'37facb3b94307e45f14a1394d6faf87369b30df57f57f6b5a10a003aa155134045c2','c7a4bdcc9e31081c6b76cc90220f53efde41da319fb6590db923a005e7b4d2da3285','2022-06-14 07:00:56','2022-06-14 07:00:56'),
(17,3,'449515bebd329e1778cb8cc3261c4ca18ad325a50c97d4419235fccdebea3d56fe01','7b8f5aff419b5de947267c89c0dfb15409ad8b43023c730c447d9409a480efafbbc4','2022-06-11 23:34:42','2022-06-11 23:34:42');
/*!40000 ALTER TABLE `user_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_votes`
--

DROP TABLE IF EXISTS `user_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `vote_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_votes`
--

LOCK TABLES `user_votes` WRITE;
/*!40000 ALTER TABLE `user_votes` DISABLE KEYS */;
INSERT INTO `user_votes` VALUES
(2,3,1,'2022-06-13 09:07:01',NULL);
/*!40000 ALTER TABLE `user_votes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `image` text DEFAULT NULL,
  `username` text DEFAULT NULL,
  `mail` text NOT NULL,
  `password` text DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,1,NULL,NULL,'js@deltacity.net',NULL,'2022-06-02 21:17:48','2022-06-02 20:48:39',NULL),
(2,0,NULL,NULL,'ass@deltacity.net',NULL,'2022-06-02 21:17:48','2022-06-02 20:48:39',NULL),
(3,1,NULL,NULL,'justinleonseidel@protonmail.com',NULL,'2022-06-11 13:03:26','2022-06-11 13:02:35','2022-06-11 13:03:26'),
(4,1,NULL,NULL,'justinleonseidel@gmail.com',NULL,'2022-06-11 13:38:53','2022-06-11 13:38:50','2022-06-11 13:38:53');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vote_settings`
--

DROP TABLE IF EXISTS `vote_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vote_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `opens_at` time DEFAULT NULL,
  `closes_at` time DEFAULT NULL,
  `last_vote_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vote_settings`
--

LOCK TABLES `vote_settings` WRITE;
/*!40000 ALTER TABLE `vote_settings` DISABLE KEYS */;
INSERT INTO `vote_settings` VALUES
(1,'06:00:00','12:00:00','2022-06-14','2022-06-11 16:30:12',NULL);
/*!40000 ALTER TABLE `vote_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `count` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votes`
--

LOCK TABLES `votes` WRITE;
/*!40000 ALTER TABLE `votes` DISABLE KEYS */;
INSERT INTO `votes` VALUES
(1,3,'2022-06-13','12:10:00',2,'2022-06-13 09:55:21',NULL);
/*!40000 ALTER TABLE `votes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-12 12:17:44
