-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (armv7l)
--
-- Host: localhost    Database: Cyclo
-- ------------------------------------------------------
-- Server version	5.5.46-0+deb7u1

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
-- Current Database: `Cyclo`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `Cyclo` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `Cyclo`;

--
-- Table structure for table `Address`
--

DROP TABLE IF EXISTS `Address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Address` (
  `Add_Id` int(11) NOT NULL AUTO_INCREMENT,
  `FormAdd` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Add_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Address`
--

LOCK TABLES `Address` WRITE;
/*!40000 ALTER TABLE `Address` DISABLE KEYS */;
INSERT INTO `Address` VALUES (1,'Allmendingenweg 9, 3073 Muri bei Bern, Switzerland'),(2,'BogenschÃ¼tzenstrasse 9B, PostParc, 3008 Bern, Switzerland'),(3,'Effingerstrasse 37, 3008 Bern, Switzerland'),(4,'Effingerstrasse 37, 3008 Bern, Switzerland'),(5,'Marzilistrasse 29, 3005 Bern, Switzerland'),(6,'284 Madrona Way NE, Bainbridge Island, WA 98110, USA'),(7,'NA'),(8,'Cantabria, Spain'),(9,'NA'),(10,'3784 Ingraham St, San Diego, CA 92109, USA'),(11,'3784 Ingraham St, San Diego, CA 92109, USA'),(12,'NA'),(13,'Weissensteinstrasse 41, 3007 Bern, Switzerland'),(14,'Marzilistrasse 29, 3005 Bern, Switzerland'),(15,'Mattenhofstrasse, 3007 Bern, Switzerland'),(16,'Brunnmattstrasse 67, 3007 Bern, Switzerland');
/*!40000 ALTER TABLE `Address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Availability`
--

DROP TABLE IF EXISTS `Availability`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Availability` (
  `Aval_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Byke_Id` int(11) NOT NULL,
  `Per_Id` int(11) NOT NULL,
  PRIMARY KEY (`Aval_Id`),
  KEY `Byke_Id` (`Byke_Id`),
  KEY `Per_Id` (`Per_Id`),
  CONSTRAINT `Availability_ibfk_1` FOREIGN KEY (`Byke_Id`) REFERENCES `Bike` (`Byke_Id`),
  CONSTRAINT `Availability_ibfk_2` FOREIGN KEY (`Per_Id`) REFERENCES `Period` (`Per_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Availability`
--

LOCK TABLES `Availability` WRITE;
/*!40000 ALTER TABLE `Availability` DISABLE KEYS */;
INSERT INTO `Availability` VALUES (59,33,94),(60,33,95),(61,33,128),(62,32,129),(63,36,134),(64,36,135),(65,33,136),(66,35,137),(67,35,138),(68,32,139),(70,35,144),(71,33,148);
/*!40000 ALTER TABLE `Availability` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Bike`
--

DROP TABLE IF EXISTS `Bike`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Bike` (
  `Byke_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(255) DEFAULT NULL,
  `Type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Byke_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Bike`
--

LOCK TABLES `Bike` WRITE;
/*!40000 ALTER TABLE `Bike` DISABLE KEYS */;
INSERT INTO `Bike` VALUES (32,'bianchi classic color (green)','race_bike'),(33,'Bmx small frame','BMX'),(34,'jfkjklf','fkÃ²kÃ²lf'),(35,'veloce e precisa','corsa'),(36,'Marca Bianchi, classico  verde, taglia media','Da corsa'),(37,'CHIARA','error'),(38,'Triciclo per bambino 4-5 anni','.'),(39,'menu','menu');
/*!40000 ALTER TABLE `Bike` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `GeoPosition`
--

DROP TABLE IF EXISTS `GeoPosition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GeoPosition` (
  `Geo_id` int(11) NOT NULL AUTO_INCREMENT,
  `Lat` double DEFAULT NULL,
  `Lon` double DEFAULT NULL,
  PRIMARY KEY (`Geo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `GeoPosition`
--

LOCK TABLES `GeoPosition` WRITE;
/*!40000 ALTER TABLE `GeoPosition` DISABLE KEYS */;
INSERT INTO `GeoPosition` VALUES (52,46.928745,7.5146125),(53,45.9685218,7.9697541),(54,46.928745,7.5146125),(55,46.928745,7.5146125),(56,45.9685218,7.9697541),(57,46.928745,7.5146125),(58,46.928745,7.5146125),(59,46.928745,7.5146125),(60,46.928745,7.5146125),(61,46.948341,7.4379471),(62,46.9457671,7.4316632),(63,46.9457671,7.4316632),(64,46.9465427,7.4442543),(65,46.9424203,7.4437811),(66,46.9460014,7.4409963),(67,46.9460014,7.4409963),(68,35.1984499,-80.8694362),(69,46.9460014,7.4409963),(70,46.9460014,7.4409963),(71,46.9460014,7.4409963),(72,46.942634,7.414256),(73,46.941358,7.4243956),(74,46.941358,7.4243956),(75,46.941358,7.4243956),(76,46.9478173,7.4460802),(77,46.9479163,7.4450819),(78,46.942634,7.414256),(79,46.941414,7.424499),(80,46.942634,7.414256),(81,46.9482132,7.4451608),(82,46.942634,7.414256),(83,46.942634,7.414256),(84,46.942634,7.414256),(85,46.941358,7.4243956),(86,46.9477895,7.4435729),(87,46.941358,7.4243956),(88,46.942634,7.414256),(89,46.942634,7.414256),(90,46.942634,7.414256),(91,46.9350521,7.4984728),(92,47.376313,8.5476699),(93,46.942634,7.414256),(94,47.6279319,-122.5189672),(95,46.942634,7.414256),(96,46.942634,7.414256),(97,45.9686133,7.9701784),(98,46.942634,7.414256),(99,46.941358,7.4243956),(100,43.1828396,-3.9878427),(101,46.942634,7.414256),(102,32.7885513,-117.2375885),(103,32.7885513,-117.2375885),(104,46.942634,7.414256),(105,46.939822,7.4242529),(106,46.9424203,7.4437811),(107,46.9407058,7.427647),(108,46.942634,7.414256),(109,46.942634,7.414256),(110,46.9432995,7.4302312),(111,39.2914878,-88.5819603),(112,46.941358,7.4243956),(113,46.941358,7.4243956),(114,46.941358,7.4243956),(115,46.9442817,7.4264306),(116,46.942634,7.414256),(117,46.942634,7.414256),(118,46.942634,7.414256),(119,46.942634,7.414256),(120,46.942634,7.414256),(121,45.9685218,7.9697541),(122,46.942634,7.414256),(123,46.942634,7.414256);
/*!40000 ALTER TABLE `GeoPosition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `IsWhere`
--

DROP TABLE IF EXISTS `IsWhere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `IsWhere` (
  `Where_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Aval_Id` int(11) NOT NULL,
  `Add_Id` int(11) NOT NULL,
  `Geo_Id` int(11) NOT NULL,
  PRIMARY KEY (`Where_Id`),
  KEY `Aval_Id` (`Aval_Id`),
  KEY `Add_Id` (`Add_Id`),
  KEY `Geo_Id` (`Geo_Id`),
  CONSTRAINT `IsWhere_ibfk_1` FOREIGN KEY (`Aval_Id`) REFERENCES `Availability` (`Aval_Id`),
  CONSTRAINT `IsWhere_ibfk_2` FOREIGN KEY (`Add_Id`) REFERENCES `Address` (`Add_Id`),
  CONSTRAINT `IsWhere_ibfk_3` FOREIGN KEY (`Geo_Id`) REFERENCES `GeoPosition` (`Geo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `IsWhere`
--

LOCK TABLES `IsWhere` WRITE;
/*!40000 ALTER TABLE `IsWhere` DISABLE KEYS */;
INSERT INTO `IsWhere` VALUES (1,59,1,60),(2,60,2,61),(3,61,6,94),(4,62,7,95),(5,63,8,100),(6,64,9,101),(7,65,10,102),(8,66,11,103),(9,67,12,104),(10,68,13,105),(12,70,15,110),(13,71,16,114);
/*!40000 ALTER TABLE `IsWhere` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Period`
--

DROP TABLE IF EXISTS `Period`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Period` (
  `Per_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL,
  PRIMARY KEY (`Per_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Period`
--

LOCK TABLES `Period` WRITE;
/*!40000 ALTER TABLE `Period` DISABLE KEYS */;
INSERT INTO `Period` VALUES (91,'2017-05-22 10:00:00','2017-05-22 13:00:00'),(92,'2017-05-22 10:00:00','2017-05-22 13:00:00'),(93,'2017-05-22 06:30:00','2017-05-23 02:30:00'),(94,'2017-05-22 03:30:00','2017-05-22 11:30:00'),(95,'2017-05-22 04:00:00','2017-05-22 19:00:00'),(96,'2017-05-22 07:30:00','2017-05-23 03:30:00'),(97,'2017-05-22 03:30:00','2017-05-22 22:30:00'),(98,'2017-05-22 08:30:00','2017-05-22 11:30:00'),(99,'2017-05-22 06:30:00','2017-05-23 02:30:00'),(100,'2017-05-22 07:00:00','2017-05-22 11:00:00'),(101,'2017-05-22 06:30:00','2017-05-22 11:30:00'),(102,'2017-05-22 03:30:00','2017-05-22 07:30:00'),(103,'2017-05-22 10:00:00','2017-05-22 12:00:00'),(104,'2017-05-22 10:00:00','2017-05-22 12:00:00'),(105,'2017-05-22 10:00:00','2017-05-22 12:00:00'),(106,'2017-05-22 10:30:00','2017-05-22 12:30:00'),(107,'2017-05-22 10:30:00','2017-05-22 12:30:00'),(108,'2017-05-22 10:00:00','2017-05-22 12:00:00'),(109,'2017-05-22 14:00:00','2017-05-22 16:00:00'),(110,'2017-05-22 10:00:00','2017-05-22 12:00:00'),(111,'2017-05-22 11:30:00','2017-05-22 13:30:00'),(112,'2017-05-22 09:30:00','2017-05-22 11:30:00'),(113,'2017-05-22 10:00:00','2017-05-22 12:00:00'),(114,'2017-05-22 08:30:00','2017-05-22 10:30:00'),(115,'2017-05-22 10:00:00','2017-05-22 12:00:00'),(116,'2017-05-22 09:30:00','2017-05-22 11:30:00'),(117,'2017-05-22 10:00:00','2017-05-22 12:00:00'),(118,'2017-05-22 09:30:00','2017-05-22 11:30:00'),(119,'2017-05-22 10:00:00','2017-05-22 12:00:00'),(120,'2017-05-22 08:30:00','2017-05-22 10:30:00'),(121,'2017-05-22 10:00:00','2017-05-22 12:00:00'),(122,'2017-05-22 10:00:00','2017-05-22 12:00:00'),(123,'2017-05-22 03:30:00','2017-05-22 05:30:00'),(124,'2017-05-22 10:00:00','2017-05-22 12:00:00'),(125,'2017-05-22 10:00:00','2017-05-22 12:00:00'),(126,'2017-05-22 10:00:00','2017-05-22 12:00:00'),(127,'2017-06-22 22:00:00','2017-06-23 05:00:00'),(128,'2017-06-30 06:30:00','2017-07-01 01:30:00'),(129,'2017-06-21 19:00:00','2017-06-22 14:00:00'),(130,'2017-06-21 20:00:00','2017-06-22 00:00:00'),(131,'2017-06-21 18:00:00','2017-06-22 06:00:00'),(132,'2017-06-23 10:00:00','2017-06-23 17:00:00'),(133,'2017-06-22 03:00:00','2017-06-22 07:00:00'),(134,'2017-06-22 03:00:00','2017-06-22 23:00:00'),(135,'2017-06-22 10:00:00','2017-06-22 12:00:00'),(136,'2017-06-22 03:00:00','2017-06-22 12:00:00'),(137,'2017-06-22 09:00:00','2017-06-22 18:00:00'),(138,'2017-06-22 20:00:00','2017-06-23 03:00:00'),(139,'2017-06-23 09:30:00','2017-06-23 17:30:00'),(140,'2017-06-23 06:30:00','2017-06-23 19:30:00'),(141,'2017-06-23 10:00:00','2017-06-23 17:00:00'),(142,'2017-06-25 09:00:00','2017-06-25 16:00:00'),(143,'2017-06-25 03:00:00','2017-06-25 07:00:00'),(144,'2017-06-27 04:00:00','2017-06-28 00:00:00'),(145,'2017-06-27 06:30:00','2017-06-27 10:30:00'),(146,'2017-06-27 03:00:00','2017-06-27 10:00:00'),(147,'2017-06-27 07:00:00','2017-06-27 09:00:00'),(148,'2017-06-26 03:00:00','2017-06-26 05:00:00'),(149,'2017-06-26 03:30:00','2017-06-26 05:30:00'),(150,'2017-06-26 04:00:00','2017-06-26 05:00:00'),(151,'2017-06-26 03:30:00','2017-06-26 04:30:00'),(152,'2017-06-26 00:26:00','2017-06-26 09:26:00'),(153,'2017-06-26 03:30:00','2017-06-26 17:30:00'),(154,'2017-06-26 22:30:00','2017-06-27 01:30:00'),(155,'2017-07-06 10:30:00','2017-07-06 14:30:00'),(156,'2017-07-10 03:42:00','2017-07-10 07:42:00'),(157,'2017-06-26 10:30:00','2017-06-26 11:30:00');
/*!40000 ALTER TABLE `Period` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PickUp`
--

DROP TABLE IF EXISTS `PickUp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PickUp` (
  `PickUp_Id` int(11) NOT NULL AUTO_INCREMENT,
  `User_Id` int(11) DEFAULT NULL,
  `Per_Id` int(11) DEFAULT NULL,
  `Byke_Id` int(11) DEFAULT NULL,
  PRIMARY KEY (`PickUp_Id`),
  KEY `User_Id` (`User_Id`),
  KEY `Per_Id` (`Per_Id`),
  KEY `Byke_Id` (`Byke_Id`),
  CONSTRAINT `PickUp_ibfk_1` FOREIGN KEY (`User_Id`) REFERENCES `User` (`User_Id`),
  CONSTRAINT `PickUp_ibfk_2` FOREIGN KEY (`Per_Id`) REFERENCES `Period` (`Per_Id`),
  CONSTRAINT `PickUp_ibfk_3` FOREIGN KEY (`Byke_Id`) REFERENCES `Bike` (`Byke_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PickUp`
--

LOCK TABLES `PickUp` WRITE;
/*!40000 ALTER TABLE `PickUp` DISABLE KEYS */;
INSERT INTO `PickUp` VALUES (1,304160054,114,NULL),(2,304160054,115,NULL),(3,304160054,116,33),(4,304160054,117,33),(5,304160054,118,33),(6,304160054,119,33),(7,304160054,120,33),(8,304160054,121,33),(9,304160054,122,33),(11,304160054,124,32),(12,304160054,125,33),(14,304160054,130,32),(17,304160054,133,32),(18,304160054,141,38),(25,304160054,150,33);
/*!40000 ALTER TABLE `PickUp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Search`
--

DROP TABLE IF EXISTS `Search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Search` (
  `Src_Id` int(11) NOT NULL AUTO_INCREMENT,
  `User_Id` int(11) NOT NULL,
  `Geo_Id` int(11) NOT NULL,
  `Period_Id` int(11) NOT NULL,
  PRIMARY KEY (`Src_Id`),
  KEY `User_Id` (`User_Id`),
  KEY `Geo_Id` (`Geo_Id`),
  KEY `Period_Id` (`Period_Id`),
  CONSTRAINT `Search_ibfk_1` FOREIGN KEY (`User_Id`) REFERENCES `User` (`User_Id`),
  CONSTRAINT `Search_ibfk_2` FOREIGN KEY (`Geo_Id`) REFERENCES `GeoPosition` (`Geo_id`),
  CONSTRAINT `Search_ibfk_3` FOREIGN KEY (`Period_Id`) REFERENCES `Period` (`Per_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Search`
--

LOCK TABLES `Search` WRITE;
/*!40000 ALTER TABLE `Search` DISABLE KEYS */;
INSERT INTO `Search` VALUES (22,304160054,64,98),(23,304160054,66,100),(24,304160054,67,101),(25,304160054,68,102),(26,304160054,69,103),(27,304160054,70,104),(28,304160054,71,105),(29,304160054,72,106),(30,304160054,73,107),(31,304160054,74,108),(32,304160054,75,109),(33,304160054,76,110),(34,304160054,77,111),(35,304160054,78,112),(36,390025747,79,113),(37,304160054,80,114),(38,304160054,81,115),(39,304160054,82,116),(40,304160054,83,117),(41,304160054,84,118),(42,304160054,85,119),(43,304160054,86,120),(44,304160054,87,121),(45,304160054,88,122),(46,304160054,89,123),(47,304160054,90,124),(48,304160054,91,125),(49,304160054,92,126),(50,304160054,93,127),(51,304160054,96,130),(52,304160054,97,131),(53,304160054,98,132),(54,304160054,99,133),(55,304160054,107,141),(56,304160054,108,142),(57,304160054,109,143),(58,304160054,111,145),(59,304160054,112,146),(60,304160054,113,147),(61,304160054,115,149),(62,304160054,116,150),(63,304160054,117,151),(64,304160054,118,152),(65,304160054,119,153),(66,304160054,120,154),(67,304160054,121,155),(68,304160054,122,156),(69,304160054,123,157);
/*!40000 ALTER TABLE `Search` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Share`
--

DROP TABLE IF EXISTS `Share`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Share` (
  `Byke_Id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL,
  PRIMARY KEY (`Byke_Id`),
  KEY `User_Id` (`User_Id`),
  CONSTRAINT `Share_ibfk_1` FOREIGN KEY (`Byke_Id`) REFERENCES `Bike` (`Byke_Id`),
  CONSTRAINT `Share_ibfk_2` FOREIGN KEY (`User_Id`) REFERENCES `User` (`User_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Share`
--

LOCK TABLES `Share` WRITE;
/*!40000 ALTER TABLE `Share` DISABLE KEYS */;
INSERT INTO `Share` VALUES (32,304160054),(33,304160054),(34,304160054),(35,304160054),(36,304160054),(37,304160054),(38,304160054),(39,304160054);
/*!40000 ALTER TABLE `Share` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `State`
--

DROP TABLE IF EXISTS `State`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `State` (
  `State_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Task` int(11) DEFAULT NULL,
  `Step` int(11) DEFAULT NULL,
  `ref` int(11) DEFAULT NULL,
  PRIMARY KEY (`State_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `State`
--

LOCK TABLES `State` WRITE;
/*!40000 ALTER TABLE `State` DISABLE KEYS */;
INSERT INTO `State` VALUES (36,11,5,69);
/*!40000 ALTER TABLE `State` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Todo`
--

DROP TABLE IF EXISTS `Todo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Todo` (
  `State_Id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL,
  PRIMARY KEY (`State_Id`,`User_Id`),
  KEY `User_Id` (`User_Id`),
  CONSTRAINT `Todo_ibfk_1` FOREIGN KEY (`State_Id`) REFERENCES `State` (`State_Id`),
  CONSTRAINT `Todo_ibfk_2` FOREIGN KEY (`User_Id`) REFERENCES `User` (`User_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Todo`
--

LOCK TABLES `Todo` WRITE;
/*!40000 ALTER TABLE `Todo` DISABLE KEYS */;
INSERT INTO `Todo` VALUES (36,304160054);
/*!40000 ALTER TABLE `Todo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `User_Id` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Surname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`User_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (0,'','',''),(304160054,'FulvioPirazzi','Fulvio','Pirazzi'),(361303850,'ChiaraU','chiara',''),(390025747,'','FulvioIT','');
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-26 11:16:27
