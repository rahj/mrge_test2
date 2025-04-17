-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: mrge_test2
-- ------------------------------------------------------
-- Server version	8.0.41-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `emails_jobposts`
--

DROP TABLE IF EXISTS `emails_jobposts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `emails_jobposts` (
  `user_email` varchar(255) NOT NULL,
  `flagged` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emails_jobposts`
--

LOCK TABLES `emails_jobposts` WRITE;
/*!40000 ALTER TABLE `emails_jobposts` DISABLE KEYS */;
INSERT INTO `emails_jobposts` VALUES ('test1@gmail.com',0),('test2@gmail.com',0),('test3@gmail.com',1),('test4@gmail.com',0),('test5@gmail.com',0);
/*!40000 ALTER TABLE `emails_jobposts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobposts2`
--

DROP TABLE IF EXISTS `jobposts2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobposts2` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `published` int NOT NULL DEFAULT '0',
  `spam` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobposts2`
--

LOCK TABLES `jobposts2` WRITE;
/*!40000 ALTER TABLE `jobposts2` DISABLE KEYS */;
INSERT INTO `jobposts2` VALUES (4,'test1@gmail.com','adadasdasd','adadasd',0,1),(5,'test2@gmail.com','sdfsfsdf','sfsdfsfsdf',0,1),(6,'test3@gmail.com','dfsfsdfsdf','sdfsdfsd',1,1),(7,'test4@gmail.com','fsdfsdfs','dfsdfsdfsdf',0,0),(8,'test5@gmail.com','sfsdfsfs','fsdfsdfsd',0,0),(9,'test1@gmail.com','asdasdasd','asdasdas',0,0);
/*!40000 ALTER TABLE `jobposts2` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-18  1:23:50
