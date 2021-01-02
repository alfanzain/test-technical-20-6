-- MySQL dump 10.13  Distrib 5.7.24, for Win64 (x86_64)
--
-- Host: localhost    Database: db_mobile_ganggu_dumbways
-- ------------------------------------------------------
-- Server version	5.7.24

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
-- Current Database: `db_mobile_ganggu_dumbways`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `db_mobile_ganggu_dumbways` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_mobile_ganggu_dumbways`;

--
-- Table structure for table `hero`
--

DROP TABLE IF EXISTS `hero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hero` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `id_role` int(9) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hero`
--

LOCK TABLES `hero` WRITE;
/*!40000 ALTER TABLE `hero` DISABLE KEYS */;
INSERT INTO `hero` VALUES (1,'Phantom Assassin',1,NULL,'The moment she finds her prey, Phantom Assassin strikes.'),(2,'Troll Warlord',1,NULL,'Troll Warlord'),(3,'Void Spirit',1,NULL,'Elder Spirit'),(4,'Mars',3,NULL,'The Impaler'),(5,'Visage',3,NULL,'My familiar dies'),(6,'Earth Spirit',4,NULL,'You rock.'),(7,'Tiny',4,NULL,'Tiny\'s coming in'),(8,'Grimstroke',4,NULL,'Artistry'),(9,'Oracle',4,'5ff06e3d0f226.png','What if?'),(10,'Crystal Maiden',5,'5ff06e4539027.png','Rylai, the Crystal Maiden, is a ranged intelligence hero who uses the power of frost and ice to disable and dispatch her foes. A slow and fragile support, Crystal Maiden\'s strength lies in her battery of strong nukes, disables and slows. Crystal Nova is an area-of-effect nuke that slows enemies\' attack and movement speeds, while Frostbite immobilizes an enemy in a block of ice, dealing moderate damage per second. Coordinating these spells with a laning partner\'s own abilities will bring many an enemy to their knees. Her passive Arcane Aura also improves the mana regeneration for heroes in Rylai\'s team, multiplying their spellcasting in the early game. Later on, she has the potential to lay waste to her enemies in teamfights if she can channel her deadly ultimate Freezing Field uninterrupted. Her global mana aura, strong disables and nukes, and a lack of item dependence make Crystal Maiden a reliable and, with judicious use of her ultimate, a devastating support caster.'),(11,'Jakiro',5,NULL,'Fire and ice!');
/*!40000 ALTER TABLE `hero` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Safe lane'),(2,'Mid lane'),(3,'Off lane'),(4,'Support'),(5,'Hard Support'),(6,'Roamer'),(7,'Feeder');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-02 20:00:10
