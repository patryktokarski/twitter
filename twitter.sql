-- MySQL dump 10.13  Distrib 5.5.50, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: twitter
-- ------------------------------------------------------
-- Server version	5.5.50-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Messages`
--

DROP TABLE IF EXISTS `Messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`),
  CONSTRAINT `Messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  CONSTRAINT `Messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Messages`
--

LOCK TABLES `Messages` WRITE;
/*!40000 ALTER TABLE `Messages` DISABLE KEYS */;
INSERT INTO `Messages` VALUES (5,4,11,'aaa',0,'2016-11-06 15:26:14'),(6,4,11,'aaa222',0,'2016-11-06 15:27:53'),(7,4,9,'czesc Franio',0,'2016-11-06 15:46:45'),(8,9,4,'Czesc Patryk. Co tam?',0,'2016-11-06 16:07:37'),(9,11,4,'dupa',0,'2016-11-06 17:50:24'),(10,4,11,'Kliknij aby sprawdzic status wiadomosci',0,'2016-11-06 19:14:43'),(11,4,11,'Zrob cos do jedzenia',0,'2016-11-06 19:14:57'),(12,4,10,'Wiadomosc testowa',1,'2016-11-06 19:52:52'),(13,4,10,'12345678901234567890123456789012345678901234567890',1,'2016-11-06 20:11:35'),(14,4,11,'12345678901234567890123456789012345678901234567890',0,'2016-11-06 20:12:48'),(15,11,9,'yooo',1,'2016-11-06 20:45:17');
/*!40000 ALTER TABLE `Messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tweet_id` int(11) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_ibfk_1` (`user_id`),
  KEY `comments_ibfk_2` (`tweet_id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`tweet_id`) REFERENCES `tweets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,4,21,'Siema. Fajnie ze dolaczyles!!','2016-11-05 23:21:03'),(2,9,21,'Czesc','2016-11-05 23:21:51'),(6,4,21,'Co robimy?','2016-11-06 00:12:41'),(7,4,16,'A ja nie','2016-11-06 09:03:34'),(8,4,20,'Komentarz','2016-11-06 19:59:16'),(9,4,20,'1234567890123456789012345678901234567890123456789012345678901234567890','2016-11-06 20:00:08'),(10,4,20,'1234567890123456789012345678901234567890123456789012345678901234567890','2016-11-06 20:00:41'),(11,4,21,'Elo','2016-11-06 21:36:24'),(13,11,16,'tak','2016-11-06 22:08:10'),(14,11,16,'tak','2016-11-06 22:08:26'),(15,11,16,'tak','2016-11-06 22:08:30'),(16,11,23,'wcale nie','2016-11-06 22:13:06'),(17,11,23,'moze jednak','2016-11-06 22:13:46'),(18,11,23,'a tera','2016-11-06 22:15:11'),(19,11,23,'a tera','2016-11-06 22:16:03'),(20,11,23,'a tera','2016-11-06 22:17:30'),(21,11,23,'tstt','2016-11-06 22:17:52'),(22,11,23,'Nie','2016-11-06 22:21:21'),(23,11,23,'Powinno byc ok','2016-11-06 22:24:24'),(24,4,23,'Skonczone!!','2016-11-06 22:28:37');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweets`
--

DROP TABLE IF EXISTS `tweets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `text` varchar(255) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tweets_ibfk_1` (`user_id`),
  CONSTRAINT `tweets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweets`
--

LOCK TABLES `tweets` WRITE;
/*!40000 ALTER TABLE `tweets` DISABLE KEYS */;
INSERT INTO `tweets` VALUES (1,4,'Witam wszystkich','2016-11-04 21:09:18'),(10,4,'Czesc!','2016-11-04 21:26:50'),(14,8,'Siemanko','2016-11-04 22:45:23'),(15,9,'Uruchomili lodowisko na narodowym ;)','2016-11-05 12:32:31'),(16,10,'Lubie placki','2016-11-05 13:56:12'),(17,4,'Glodny jestem','2016-11-05 15:19:42'),(18,9,'Ide po herbate','2016-11-05 15:21:11'),(19,8,'Zimno mi...','2016-11-05 15:22:07'),(20,10,'Powoli robi sie ciemno','2016-11-05 15:30:12'),(21,11,'No siema','2016-11-05 20:23:12'),(23,4,'Uff. To chyba juz wszystko','2016-11-06 22:05:00');
/*!40000 ALTER TABLE `tweets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `hashedPassword` varchar(60) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'Patryk','$2y$10$ldY332Qxyo6Jj.MaOWL/5.vh6QpGRBeiojQhJszSKG4vX5DSZBj0a','ppp@gmail.com'),(8,'Marcin','$2y$10$N6qpxnW7LIDBmKKwk9JSceukRTi5t0.XJc2z/VZcvTm/gyq//rhxm','marcin@gmail.com'),(9,'Franio','$2y$10$mohV5EuPUC3G1sTfW0FbMO.KCVxbuuxuFH6SrGOsUIQtA4.4F84rS','franek@gmail.com'),(10,'Leszek','$2y$10$MvadvUdDlT/R187wPiWzkeL48MVJtloLdgO1pyMDMAjcnb86L0MeW','leszek@gmail.com'),(11,'Sebastian ','$2y$10$Z9Cqz8OGUmHnJIEN9flZ/epswIarVfOElSd8Iombl6nMRmo0kZucO','test@niepodam.pl');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-06 22:44:29
