CREATE DATABASE  IF NOT EXISTS `software_update` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `software_update`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: software_update
-- ------------------------------------------------------
-- Server version	5.7.20-log

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
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(10) DEFAULT NULL,
  `company_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `kvk` varchar(10) NOT NULL,
  `zip_code` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `location` varchar(45) NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`company_id`),
  UNIQUE KEY `company_id_UNIQUE` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (1,'0252838392','Sqits','sqits@example.com','7348287261','2181DA','van Tetsstraat 11','Hillegom','2018-06-15'),(2,'0252517039','Metro','metro@example.com','2828491912','2184MB','Weerensteinstraat 12','Lisse','2018-06-15');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form`
--

DROP TABLE IF EXISTS `form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form` (
  `form_id` int(11) NOT NULL AUTO_INCREMENT,
  `terms_id` int(11) DEFAULT NULL,
  `type` enum('bug-fix','major-update') NOT NULL,
  `task_nr` varchar(45) NOT NULL,
  `version` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `created_date` date NOT NULL,
  `modified_date` date NOT NULL,
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form`
--

LOCK TABLES `form` WRITE;
/*!40000 ALTER TABLE `form` DISABLE KEYS */;
INSERT INTO `form` VALUES (1,1,'major-update','0001','0.1','Verschillende functies binnen de applicatie hebben een update gekregen, waaronder:\r\n\r\n1. Login\r\n- De gebruiken kan nu inloggen zonder problemen en krijgt een sessie aangeboden via onze server.\r\n- De gebruiker kan niet op een webpagina waar een sessie voor nodig is.\r\n\r\n2. Toevoegen van gebruikers\r\n- Administratoren kunnen nu gebruikers toevoegen zonder problemen\r\n- Telefoonnummers kunnen geen \'duplicate\' errors meer geven.\r\n\r\n3. Toevoegen van formulieren en updates\r\n- Administratoren hebben nu de mogelijkheid om te kiezen tussen een \'bug fix\' en een \'major update\'. Dit maakt de update makkelijker om te sorteren en om te zien of het belangrijk is of niet.\r\n- Updates maken nu gebruik van voorwaarden en updates. Voorwaarden kunnen apart aangemaakt worden buiten update om.\r\n\r\n4. Overzicht van updates\r\n- De icoontjes voor de status van formulieren zijn aangepast om de gebruiker een goed overzicht te geven van de updates.\r\n- De gebruiker kan sorteren op verschillende waardes van updates (status, datum, etc.)\r\n- Meer informatie over de updates valt te zien voor de gebruiker.','2018-06-15','2018-06-15'),(2,1,'bug-fix','0002','0.1.2','Verschillende bugs zijn uit het systeem gehaald. De web-applicatie heeft nu goeie performance en de servers hebben geen down-time meer. We hebben verschillende bugs uit het systeem gehaald, namelijk:\r\n\r\n1. Sessie koppeling met de server\r\n- De localhost server had soms problemen met het achterhalen van de sessie van de gebruiker.\r\n- Via de PHP functies kreeg de server een verkeerde \'input\' van de localhost.\r\n\r\n2. Double the loading speed\r\n- De dubbele laad-icoontjes bij het toevoegen van formulieren en voorwaarden zijn weggehaald. Jammer genoeg moet je nu 2x zo lang wachten totdat ze zijn toegevoegd.\r\n\r\n3. Telefoonnummers\r\n- De telefoonnummers in de database werden soms op verkeerde plekken gezet. In plaats van deze prachtige RNG manier van telefoonnummers toevoegen, hebben we de kans nu opgeschroeft naar 100% voor het toevoegen van telefoonnummers aan gebruikers.\r\n\r\n4. Rare updates\r\n- We hebben de werknemers ontslagen die \"Lorem Ipsum Generator\" gebruikten voor het toevoegen van updates, rare snuiters.\r\n\r\n5. Marnix zijn microfoon probleem is opgelost\r\n- We hebben eindelijk het microfoon probleem van Marnix opgelost! Nooit meer doodse stiltes van die gast.','2018-06-15','2018-06-15');
/*!40000 ALTER TABLE `form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phone`
--

DROP TABLE IF EXISTS `phone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phone` (
  `user_id` int(11) NOT NULL,
  `phone_number` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  UNIQUE KEY `phone_number_UNIQUE` (`phone_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phone`
--

LOCK TABLES `phone` WRITE;
/*!40000 ALTER TABLE `phone` DISABLE KEYS */;
INSERT INTO `phone` VALUES (1,'0640386844'),(2,'0683125985');
/*!40000 ALTER TABLE `phone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `terms`
--

DROP TABLE IF EXISTS `terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `terms` (
  `terms_id` int(11) NOT NULL AUTO_INCREMENT,
  `acceptance` text NOT NULL,
  `service_level_agreement` text NOT NULL,
  `contract` text NOT NULL,
  `signature` text NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`terms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terms`
--

LOCK TABLES `terms` WRITE;
/*!40000 ALTER TABLE `terms` DISABLE KEYS */;
INSERT INTO `terms` VALUES (1,'Met het ondertekenen van dit document is de opdrachtgever bewust van de volgende zaken:\r\n\r\n1. De opdrachtgever geeft akkoord het product in een productieomgeving te gebruiken. Schade door incorrect functioneren van de geaccepteerde applicatie is voor risico van de accepterende klant.\r\n\r\n2. De opdrachtgever heeft bepaald dat het beveiligingsniveau van de applicatie afdoende is, en heeft er bewust voor gekozen al dan niet een beveiliging analyse te laten verrichten.\r\n\r\n3. Alleen fouten in de applicatie die er toe leiden dat de applicatie vast loopt, lijkt vast te lopen, of een foutmelding tonen aan de gebruiker, worden z.s.m. opgelost (best effort) en buiten de standaard release momenten om verholpen.\r\n\r\n4. Bugs dienen altijd via onze online helpdesk te worden gerapporteerd, voorzien van een duidelijke omschrijving. Op deze manier kunnen we u sneller helpen, en proberen we miscommunicatie tot een minimum te beperken.\r\n\r\n5. Met ondertekening van dit document wordt tevens de opdracht waarvoor getekend is in de opdrachtbevestiging officieel afgesloten. Er zal een factuur voor de slottermijn worden verstuurd.\r\n\r\n6. Op al het werk dat op basis van nacalculatie of begroting wordt uitgevoerd zit géén garantie.','Er is voor deze opdracht geen Service Level Agreement (SLA) afgesloten. Alle support zal op \'best-effort\' basis worden geleverd.','Er is voor deze opdracht geen Support-contract afgesloten. Alle werkzaamheden, waaronder technische ondersteuning, het verhelpen van storingen, of het repareren van softwarefouten, zullen apart en op basis van nacalculatie worden gefactureerd.','Op deze overeenkomst zijn onze Algemene Voorwaarden van toepassing, zoals te vinden op onze website, Indien gewenst kunnen de Algemene Voorwaarden per e-mail worden opgevraagd. ondergetekende heeft de Algemene Voorwaarden gelezen en begrepen, en gaat akkoord met deze voorwaarden.','2018-06-15');
/*!40000 ALTER TABLE `terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `update`
--

DROP TABLE IF EXISTS `update`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `update` (
  `update_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `status` enum('declined','accepted','pending') NOT NULL,
  `end_date` date NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`update_id`),
  UNIQUE KEY `update_id_UNIQUE` (`update_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `update`
--

LOCK TABLES `update` WRITE;
/*!40000 ALTER TABLE `update` DISABLE KEYS */;
INSERT INTO `update` VALUES (1,2,1,'accepted','2018-06-30','2018-06-15');
/*!40000 ALTER TABLE `update` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `last_visit` date NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,1,'admin@example.com','$2y$10$K.E6R0iot6SXWczllZ0HtOgegQBmTtdJiPgW2vCPRYtneu8RkZtnS','Jasper','Paardekoper','admin','active','2018-06-15','2018-06-15'),(2,2,'david@example.com','$2y$10$kAresM1wEivHg4DFQIW/5eWlKH4lFsOA/CSzB9a6SSVcc1vNGMCii','David','Bruschke','user','active','2018-06-15','2018-06-15');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-15 13:02:29
