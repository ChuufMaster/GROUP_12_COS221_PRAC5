-- MariaDB dump 10.19  Distrib 10.11.2-MariaDB, for osx10.15 (x86_64)
--
-- Host: localhost    Database: group12
-- ------------------------------------------------------
-- Server version	10.11.2-MariaDB

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
-- Table structure for table `all_users`
--

DROP TABLE IF EXISTS `all_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `all_users` (
  `api_key` varchar(32) NOT NULL,
  `first_name` varchar(50) NOT NULL DEFAULT 'anon',
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `num_reviews` int(11) DEFAULT NULL,
  `verified_recently` date DEFAULT NULL,
  PRIMARY KEY (`api_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `all_users`
--

LOCK TABLES `all_users` WRITE;
/*!40000 ALTER TABLE `all_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `all_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chemical_comp`
--

DROP TABLE IF EXISTS `chemical_comp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chemical_comp` (
  `wine_id` int(11) NOT NULL,
  `density` float DEFAULT 0,
  `total_sulfur_dioxide` int(11) DEFAULT 0,
  `pH` float DEFAULT 0,
  `free_sulfur_dioxide` int(11) DEFAULT 0,
  `sulphates` float DEFAULT 0,
  `chlorides` float DEFAULT 0,
  `residual_sugar` float DEFAULT 0,
  `citric_acid` float DEFAULT 0,
  `volatile_acidity` float DEFAULT 0,
  `fixed_acidity` float DEFAULT 0,
  PRIMARY KEY (`wine_id`),
  CONSTRAINT `fk_wine_id` FOREIGN KEY (`wine_id`) REFERENCES `wines` (`wine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chemical_comp`
--

LOCK TABLES `chemical_comp` WRITE;
/*!40000 ALTER TABLE `chemical_comp` DISABLE KEYS */;
/*!40000 ALTER TABLE `chemical_comp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `critic`
--

DROP TABLE IF EXISTS `critic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `critic` (
  `api_key` varchar(32) NOT NULL,
  `certified` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`api_key`),
  CONSTRAINT `fk_api_key` FOREIGN KEY (`api_key`) REFERENCES `all_users` (`api_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `critic`
--

LOCK TABLES `critic` WRITE;
/*!40000 ALTER TABLE `critic` DISABLE KEYS */;
/*!40000 ALTER TABLE `critic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `has_wines`
--

DROP TABLE IF EXISTS `has_wines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `has_wines` (
  `wine_id` int(11) NOT NULL,
  `winery_id` int(11) NOT NULL,
  PRIMARY KEY (`winery_id`),
  UNIQUE KEY `wine_id` (`wine_id`),
  CONSTRAINT `has_wines_ibfk_1` FOREIGN KEY (`wine_id`) REFERENCES `wines` (`wine_id`),
  CONSTRAINT `has_wines_ibfk_2` FOREIGN KEY (`winery_id`) REFERENCES `wineries` (`winery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `has_wines`
--

LOCK TABLES `has_wines` WRITE;
/*!40000 ALTER TABLE `has_wines` DISABLE KEYS */;
/*!40000 ALTER TABLE `has_wines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `is_in_location`
--

DROP TABLE IF EXISTS `is_in_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `is_in_location` (
  `location_id` int(11) NOT NULL,
  `wine_id` int(11) NOT NULL,
  `winery_id` int(11) NOT NULL,
  PRIMARY KEY (`location_id`,`wine_id`,`winery_id`),
  KEY `wine_id` (`wine_id`),
  KEY `winery_id` (`winery_id`),
  CONSTRAINT `is_in_location_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`),
  CONSTRAINT `is_in_location_ibfk_2` FOREIGN KEY (`wine_id`) REFERENCES `wines` (`wine_id`),
  CONSTRAINT `is_in_location_ibfk_3` FOREIGN KEY (`winery_id`) REFERENCES `wineries` (`winery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `is_in_location`
--

LOCK TABLES `is_in_location` WRITE;
/*!40000 ALTER TABLE `is_in_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `is_in_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(50) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `region1` varchar(50) DEFAULT NULL,
  `region2` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `owner`
--

DROP TABLE IF EXISTS `owner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `owner` (
  `api_key` varchar(32) NOT NULL,
  `owner_num` int(11) NOT NULL,
  `confirmed` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`api_key`),
  UNIQUE KEY `owner_num` (`owner_num`),
  CONSTRAINT `owner_ibfk_1` FOREIGN KEY (`api_key`) REFERENCES `all_users` (`api_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `owner`
--

LOCK TABLES `owner` WRITE;
/*!40000 ALTER TABLE `owner` DISABLE KEYS */;
/*!40000 ALTER TABLE `owner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviewed_by`
--

DROP TABLE IF EXISTS `reviewed_by`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviewed_by` (
  `wine_id` int(11) NOT NULL,
  `api_key` varchar(32) NOT NULL,
  `review_id` int(11) NOT NULL,
  PRIMARY KEY (`api_key`),
  KEY `wine_id` (`wine_id`),
  KEY `fk_review_id` (`review_id`),
  CONSTRAINT `fk_review_id` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`review_id`),
  CONSTRAINT `reviewed_by_ibfk_1` FOREIGN KEY (`wine_id`) REFERENCES `wines` (`wine_id`),
  CONSTRAINT `reviewed_by_ibfk_2` FOREIGN KEY (`api_key`) REFERENCES `all_users` (`api_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviewed_by`
--

LOCK TABLES `reviewed_by` WRITE;
/*!40000 ALTER TABLE `reviewed_by` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviewed_by` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `wine_id` int(11) NOT NULL,
  `api_key` varchar(32) NOT NULL,
  `comment` varchar(1024) DEFAULT NULL,
  `rating` tinyint(4) NOT NULL,
  PRIMARY KEY (`review_id`),
  KEY `wine_id` (`wine_id`),
  KEY `api_key` (`api_key`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`wine_id`) REFERENCES `wines` (`wine_id`),
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`api_key`) REFERENCES `critic` (`api_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_media`
--

DROP TABLE IF EXISTS `social_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_media` (
  `api_key` varchar(32) NOT NULL,
  `handle` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`api_key`),
  CONSTRAINT `social_media_ibfk_1` FOREIGN KEY (`api_key`) REFERENCES `all_users` (`api_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_media`
--

LOCK TABLES `social_media` WRITE;
/*!40000 ALTER TABLE `social_media` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wineries`
--

DROP TABLE IF EXISTS `wineries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wineries` (
  `winery_id` int(11) NOT NULL AUTO_INCREMENT,
  `api_key` varchar(32) NOT NULL,
  `winery_name` varchar(50) NOT NULL,
  `certificate` varchar(64) NOT NULL,
  `operational` tinyint(1) DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  PRIMARY KEY (`winery_id`),
  UNIQUE KEY `api_key` (`api_key`),
  KEY `location_id` (`location_id`),
  CONSTRAINT `wineries_ibfk_1` FOREIGN KEY (`api_key`) REFERENCES `owner` (`api_key`),
  CONSTRAINT `wineries_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wineries`
--

LOCK TABLES `wineries` WRITE;
/*!40000 ALTER TABLE `wineries` DISABLE KEYS */;
/*!40000 ALTER TABLE `wineries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wines`
--

DROP TABLE IF EXISTS `wines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wines` (
  `wine_id` int(11) NOT NULL AUTO_INCREMENT,
  `winery_id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `user_rating` float DEFAULT 0,
  `quality` tinyint(1) DEFAULT NULL,
  `alcohol` float NOT NULL,
  `location_id` int(11) NOT NULL,
  PRIMARY KEY (`wine_id`,`winery_id`),
  KEY `winery_id` (`winery_id`),
  KEY `fk_location_id` (`location_id`),
  CONSTRAINT `fk_location_id` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`),
  CONSTRAINT `wines_ibfk_1` FOREIGN KEY (`winery_id`) REFERENCES `wineries` (`winery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wines`
--

LOCK TABLES `wines` WRITE;
/*!40000 ALTER TABLE `wines` DISABLE KEYS */;
/*!40000 ALTER TABLE `wines` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-24 14:32:08
