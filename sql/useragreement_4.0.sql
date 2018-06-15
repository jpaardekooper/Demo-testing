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
INSERT INTO `company` VALUES (1,'123456789','Company','company@example.com','KVK1011101','2255QQ','Zoeterlaan 90','Zoetermeer','2018-06-06'),(2,'0701658442','DavidMon Go','jasophanger@hotmail.com','G10101ka1','6622AA','DavidLaan 22','Zoetermeer','2018-06-06');
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
  `type` enum('bug-fix','mayor-update') NOT NULL,
  `task_nr` varchar(45) NOT NULL,
  `version` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `created_date` date NOT NULL,
  `modified_date` date NOT NULL,
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form`
--

LOCK TABLES `form` WRITE;
/*!40000 ALTER TABLE `form` DISABLE KEYS */;
INSERT INTO `form` VALUES (1,1,'mayor-update','123456','1','De update heeft als volgt:\r\n\r\n1 flanfdjasfjdksa\r\n2. fjdklafjdkasfjdl\r\n3. fjkdlajfdjfkdl','2018-06-06','2018-06-06');
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
INSERT INTO `phone` VALUES (2,'0612345655'),(1,'0612345678');
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
  `created_date` date NOT NULL,
  PRIMARY KEY (`terms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terms`
--

LOCK TABLES `terms` WRITE;
/*!40000 ALTER TABLE `terms` DISABLE KEYS */;
INSERT INTO `terms` VALUES (1,'ACCEPTATIEMet het ondertekenen van dit document is de opdrachtgever zich bewust van de volgendezaken:\n\n1.De opdrachtgever geeft akkoord het product in een productieomgeving te gebruiken.Schade door incorrect functioneren van de geaccepteerde applicatie is voor risico vande accepterende klant.\n2.De opdrachtgever heeft bepaald dat het beveiligingsniveau van de applicatie afdoendeis, en heeft er bewust voor gekozen al dan niet een beveiliging analyse te latenverrichten.\n3.Alleen fouten in de applicatie die er toe leiden dat de applicatie vast loopt, lijkt vast telopen, of een foutmelding tonen aan de gebruiker, worden z.s.m. opgelost (best effort)en buiten de standaard release momenten om verholpen.4.Bugs dienen altijd via onze online helpdesk te worden gerapporteerd, voorzien van eenduidelijk omschrijving. Op deze manier kunnen we u sneller helpen, en proberen wemiscommunicatie tot een minimum te beperken.5.Met ondertekening van dit document wordt tevens de opdracht waarvoor getekend is inde opdrachtbevestiging officieel afgesloten. Er zal een factuur voor de slottermijn wordenverstuurd.6.Op al het werk dat op basis van nacalculatie of begroting wordt uitgevoerd zit gééngarantie.Meer informatie over het accepteren van een oplevering is te vinden in onze AlgemeneVoorwaarden artikel 3 met de titel “Contractsduur; uitvoeringstermijnen, uitvoering en wijzigingovereenkomst”.\n','voor deze opdracht geen Service Level Agreement (SLA) afgesloten. Alle support zal op‘best-effort’ basis worden geleverd.','voor deze opdracht geen Support-contract afgesloten. Alle werkzaamheden, waarondertechnische ondersteuning, het verhelpen van storingen, of het repareren van softwarefouten,zullen apart en op basis van nacalculatie worden gefactureerd','deze overeenkomst zijn onze Algemene Voorwaarden van toepassing, zoals te vinden oponze website. Indien gewenst kunnen de Algemene Voorwaarden per e-mail wordenopgevraagd. Ondergetekende heeft de Algemene Voorwaarden gelezen en begrepen, en gaatakkoord met deze voorwaarden','2018-05-29');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `update`
--

LOCK TABLES `update` WRITE;
/*!40000 ALTER TABLE `update` DISABLE KEYS */;
INSERT INTO `update` VALUES (1,2,1,'pending','2018-06-30','2018-06-06'),(2,2,1,'pending','2018-06-30','2018-06-06'),(3,2,1,'pending','2018-06-29','2018-06-06');
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
INSERT INTO `user` VALUES (1,1,'admin@example.com','$2y$10$3oiwUsSPyMWNPVgKw1rDx.P1ZTiex7KDf2pzIyRuKvRdSgXoVjH9u','John','Doe','admin','active','2018-06-06','2018-06-06'),(2,2,'david@example.com','$2y$10$GMA9AkFOwWv513tKUFojBOeZj.7VKWoEh42mfGgJZs2vsutdgnG8u','David','Bruschkeleku','user','active','2018-06-06','2018-06-06');
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

-- Dump completed on 2018-06-06 15:36:06
