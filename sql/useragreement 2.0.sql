-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: useragreement
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
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `company_name` varchar(45) NOT NULL,
  `zip_code` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `location` varchar(45) NOT NULL,
  `phone_id` int(11) DEFAULT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `company_id_UNIQUE` (`company_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (1,6,'jasper','paardekooper','foodflix','2255','een straat 89','leidschendam',1,'2018-05-29');
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
  `company_id` int(11) NOT NULL,
  `type` enum('bug-fix','mayor') NOT NULL,
  `version` varchar(10) NOT NULL,
  `task_nr` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `signed_date` datetime NOT NULL,
  `status` enum('accepted','declined','pending') NOT NULL,
  `end_date` date NOT NULL,
  `create_date` date NOT NULL,
  `modified_date` date NOT NULL,
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form`
--

LOCK TABLES `form` WRITE;
/*!40000 ALTER TABLE `form` DISABLE KEYS */;
INSERT INTO `form` VALUES (1,1,'bug-fix','','','','2018-10-10 00:00:00','pending','2018-11-10','2018-10-10','0000-00-00');
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
  `phone_id` varchar(10) NOT NULL,
  PRIMARY KEY (`user_id`,`phone_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phone`
--

LOCK TABLES `phone` WRITE;
/*!40000 ALTER TABLE `phone` DISABLE KEYS */;
INSERT INTO `phone` VALUES (6,'0628652870');
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
  `contact` text NOT NULL,
  `signature` text NOT NULL,
  `image` float DEFAULT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`terms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terms`
--

LOCK TABLES `terms` WRITE;
/*!40000 ALTER TABLE `terms` DISABLE KEYS */;
INSERT INTO `terms` VALUES (1,'ACCEPTATIEMet het ondertekenen van dit document is de opdrachtgever zich bewust van de volgendezaken:1.De opdrachtgever geeft akkoord het product in een productieomgeving te gebruiken.Schade door incorrect functioneren van de geaccepteerde applicatie is voor risico vande accepterende klant.2.De opdrachtgever heeft bepaald dat het beveiligingsniveau van de applicatie afdoendeis, en heeft er bewust voor gekozen al dan niet een beveiliging analyse te latenverrichten.3.Alleen fouten in de applicatie die er toe leiden dat de applicatie vast loopt, lijkt vast telopen, of een foutmelding tonen aan de gebruiker, worden z.s.m. opgelost (best effort)en buiten de standaard release momenten om verholpen.4.Bugs dienen altijd via onze online helpdesk te worden gerapporteerd, voorzien van eenduidelijk omschrijving. Op deze manier kunnen we u sneller helpen, en proberen wemiscommunicatie tot een minimum te beperken.5.Met ondertekening van dit document wordt tevens de opdracht waarvoor getekend is inde opdrachtbevestiging officieel afgesloten. Er zal een factuur voor de slottermijn wordenverstuurd.6.Op al het werk dat op basis van nacalculatie of begroting wordt uitgevoerd zit gééngarantie.Meer informatie over het accepteren van een oplevering is te vinden in onze AlgemeneVoorwaarden artikel 3 met de titel “Contractsduur; uitvoeringstermijnen, uitvoering en wijzigingovereenkomst”.\n','SERVICE LEVEL AGREEMENTEr is voor deze opdracht geen Service Level Agreement (SLA) afgesloten. Alle support zal op‘best-effort’ basis worden geleverd.','SUPPORT CONTRACTEr is voor deze opdracht geen Support-contract afgesloten. Alle werkzaamheden, waarondertechnische ondersteuning, het verhelpen van storingen, of het repareren van softwarefouten,zullen apart en op basis van nacalculatie worden gefactureerd','ONDERTEKENINGOp deze overeenkomst zijn onze Algemene Voorwaarden van toepassing, zoals te vinden oponze website. Indien gewenst kunnen de Algemene Voorwaarden per e-mail wordenopgevraagd. Ondergetekende heeft de Algemene Voorwaarden gelezen en begrepen, en gaatakkoord met deze voorwaarden',1,'2018-05-29');
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
  `user_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `status` enum('declined','accepted','pending') NOT NULL,
  `type` enum('bug-fix','mayor-update') NOT NULL,
  `end_date` date NOT NULL,
  `send_date` date NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`update_id`),
  UNIQUE KEY `update_id_UNIQUE` (`update_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `update`
--

LOCK TABLES `update` WRITE;
/*!40000 ALTER TABLE `update` DISABLE KEYS */;
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
  `company_id` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` enum('yes','no') NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `last_visit` datetime NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (2,'','admin','admin','yes','admin','2018-05-23 00:00:00','2018-05-23 00:00:00'),(3,'','test','test','no','admin','2018-05-09 00:00:00','2018-05-23 00:00:00'),(4,'','marnix','wazaaa','yes','admin','2018-05-01 00:00:00','2018-05-26 00:00:00'),(5,'','ron','$2y$10$EQP0v/qEHreyxYQaffiBWuyqAo1wQDydvk.6bz','yes','admin','2018-05-24 20:56:02','2018-05-24 20:56:02'),(6,'','tester2','$2y$10$Fy/77ntPVR.rBDCXivBw7ujyW64QZ6/JOi.udrcuN97dDlhsRCfSK','no','admin','2018-05-24 21:00:02','2018-05-24 21:00:02'),(7,'paarden','jasper','$2y$10$y5ptr2IiNirBvrUL8hK6LOJHwqlmv65y47mWLNQvm7CxtNGjUS0F.','yes','user','2018-05-27 19:46:50','2018-05-27 19:46:50');
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

-- Dump completed on 2018-05-29 18:58:19
