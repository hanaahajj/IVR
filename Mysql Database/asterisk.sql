CREATE DATABASE  IF NOT EXISTS `asterisk` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `asterisk`;
-- MySQL dump 10.13  Distrib 5.6.24, for Win32 (x86)
--
-- Host: localhost    Database: asterisk
-- ------------------------------------------------------
-- Server version	5.5.44-0ubuntu0.14.04.1

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
-- Table structure for table `district`
--

DROP TABLE IF EXISTS `district`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `district` (
  `DistID` int(11) NOT NULL AUTO_INCREMENT,
  `GovID` int(11) DEFAULT NULL,
  `DistName` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `DistNameEn` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `DistNameFr` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `DistNamePath` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `IsActive` bit(1) DEFAULT b'1',
  `IsDeleted` bit(1) DEFAULT b'0',
  `DateCreated` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`DistID`),
  KEY `gov_id_idx` (`GovID`),
  CONSTRAINT `gov_id` FOREIGN KEY (`GovID`) REFERENCES `governorate` (`GovID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `district`
--

LOCK TABLES `district` WRITE;
/*!40000 ALTER TABLE `district` DISABLE KEYS */;
INSERT INTO `district` VALUES (1,2,'المنيه-الضنية','Mineih-Dinniyi','Mineih-Dinniyi','IRC0060','','\0','0000-00-00 00:00:00'),(2,2,'زغرتا','Zgharta','Zgharta','IRC0061','','\0','0000-00-00 00:00:00'),(3,2,'بشري','Bcharri','Bcharri','IRC0062','','\0','0000-00-00 00:00:00'),(4,2,'طرابلس','Tripoli','Tripoli','IRC0063','','\0','0000-00-00 00:00:00'),(5,2,'الكورة','Koura','Koura','IRC0064','','\0','0000-00-00 00:00:00'),(6,2,'البترون','Batroun','Batroun','IRC0065','','\0','0000-00-00 00:00:00'),(7,1,'بعبدا','Baabda','Baabda','IRC0066','','\0','0000-00-00 00:00:00'),(8,1,'بيروت','Beirut','Beirut','IRC0067','','\0','0000-00-00 00:00:00'),(9,1,'عاليه','Aley','Aley','IRC0068','','\0','0000-00-00 00:00:00'),(10,1,'الشوف','Chouf','Chouf','IRC0069','','\0','0000-00-00 00:00:00'),(11,1,'كسروان','Keserwane','Keserwane','IRC0070','','\0','0000-00-00 00:00:00'),(12,1,'المتن','El-Metn','El-Metn','IRC0071','','\0','0000-00-00 00:00:00'),(13,1,'جبيل','Jbeil','Jbeil','IRC0072','','\0','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `district` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedbackanswer`
--

DROP TABLE IF EXISTS `feedbackanswer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedbackanswer` (
  `FBAnswerID` int(11) NOT NULL AUTO_INCREMENT,
  `FBAnswer` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `FBAnswerEn` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `FBAnswerFr` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `FBAnswerPath` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `IsActive` bit(1) DEFAULT b'1',
  `IsDeleted` bit(1) DEFAULT b'0',
  `DateCreated` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`FBAnswerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedbackanswer`
--

LOCK TABLES `feedbackanswer` WRITE;
/*!40000 ALTER TABLE `feedbackanswer` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedbackanswer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedbackjiracreation`
--

DROP TABLE IF EXISTS `feedbackjiracreation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedbackjiracreation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `RefugeeNamePath` varchar(500) DEFAULT NULL,
  `NationalityID` int(11) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `IsAnonymous` int(11) DEFAULT NULL,
  `SPID` int(11) DEFAULT NULL,
  `ServiceID` int(11) DEFAULT NULL,
  `ServiceType` int(11) DEFAULT NULL,
  `ServiceGov` int(11) DEFAULT NULL,
  `ServiceDist` int(11) DEFAULT NULL,
  `Summary` varchar(500) DEFAULT NULL,
  `Answer1` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `Answer2` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `Answer3` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `Answer4` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `Answer5` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `Answer6` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `Answer7` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `ExtraExplanation` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `ExtraComments` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `DateAdded` datetime DEFAULT '0000-00-00 00:00:00',
  `IssueKey` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `JiraCreated` bit(1) DEFAULT b'0',
  `JiraVetted` bit(1) DEFAULT b'0',
  `JiraLabel` varchar(500) DEFAULT 'IVRFeedback',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedbackjiracreation`
--

LOCK TABLES `feedbackjiracreation` WRITE;
/*!40000 ALTER TABLE `feedbackjiracreation` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedbackjiracreation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedbackquestion`
--

DROP TABLE IF EXISTS `feedbackquestion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedbackquestion` (
  `FBQuestionID` int(11) NOT NULL AUTO_INCREMENT,
  `FBQuestion` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `FBQuestionEn` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `FBQuestionFr` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `FBQuestionPath` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `FBTypeID` int(11) DEFAULT NULL,
  `IsActive` bit(1) DEFAULT NULL,
  `IsDeleted` bit(1) DEFAULT NULL,
  `DateCreated` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`FBQuestionID`),
  KEY `FBType_idx` (`FBTypeID`),
  CONSTRAINT `FBType` FOREIGN KEY (`FBTypeID`) REFERENCES `feedbacktype` (`FBTypeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedbackquestion`
--

LOCK TABLES `feedbackquestion` WRITE;
/*!40000 ALTER TABLE `feedbackquestion` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedbackquestion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedbackresult`
--

DROP TABLE IF EXISTS `feedbackresult`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedbackresult` (
  `FBResultID` int(11) NOT NULL AUTO_INCREMENT,
  `FBQuestionID` int(11) DEFAULT NULL,
  `FBAnswerID` int(11) DEFAULT NULL,
  `FBNextQuestionID` int(11) DEFAULT NULL,
  `IsActive` bit(1) DEFAULT NULL,
  `IsDeleted` bit(1) DEFAULT NULL,
  `DateCreated` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`FBResultID`),
  KEY `nextQuestionID_idx` (`FBNextQuestionID`),
  KEY `asnwerID_idx` (`FBAnswerID`),
  KEY `questionID_idx` (`FBQuestionID`),
  CONSTRAINT `asnwerID` FOREIGN KEY (`FBAnswerID`) REFERENCES `feedbackanswer` (`FBAnswerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nextQuestionID` FOREIGN KEY (`FBNextQuestionID`) REFERENCES `feedbackquestion` (`FBQuestionID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `questionID` FOREIGN KEY (`FBQuestionID`) REFERENCES `feedbackquestion` (`FBQuestionID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedbackresult`
--

LOCK TABLES `feedbackresult` WRITE;
/*!40000 ALTER TABLE `feedbackresult` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedbackresult` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedbacktype`
--

DROP TABLE IF EXISTS `feedbacktype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedbacktype` (
  `FBTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `FBTypeName` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `FBTypeNameEn` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `FBTypeNameFr` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `FBTypeNamePath` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `FisrtQuestion` int(11) DEFAULT NULL,
  `IsActive` bit(1) DEFAULT NULL,
  `IsDeleted` bit(1) DEFAULT NULL,
  `DateCreated` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`FBTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedbacktype`
--

LOCK TABLES `feedbacktype` WRITE;
/*!40000 ALTER TABLE `feedbacktype` DISABLE KEYS */;
INSERT INTO `feedbacktype` VALUES (1,'null','Delivery','null','null',1,'','\0','0000-00-00 00:00:00'),(2,'null','WaitngTime','null','null',1,'','\0','0000-00-00 00:00:00'),(3,'null','Ease of Access','null','null',1,'','\0','0000-00-00 00:00:00'),(4,'null','Employee help','null','null',1,'','\0','0000-00-00 00:00:00'),(5,'null','ExtraComments','null','null',1,'','\0','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `feedbacktype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `focalpointjiracreation`
--

DROP TABLE IF EXISTS `focalpointjiracreation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `focalpointjiracreation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SPID` int(11) DEFAULT NULL,
  `Links` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `DateAdded` datetime DEFAULT '0000-00-00 00:00:00',
  `IssueKey` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `JiraCreated` bit(1) DEFAULT b'0',
  `JiraVetted` bit(1) DEFAULT b'0',
  `JiraLabel` varchar(500) DEFAULT 'IVRFocalPointUpdate',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `focalpointjiracreation`
--

LOCK TABLES `focalpointjiracreation` WRITE;
/*!40000 ALTER TABLE `focalpointjiracreation` DISABLE KEYS */;
INSERT INTO `focalpointjiracreation` VALUES (2,14,'/tmp/asterisk/records/SP/1000/FOCALPOINT/SP_FOCALPIONT_20151019_063529','2015-10-19 06:36:00',NULL,'\0','\0','IVRFocalPointUpdate');
/*!40000 ALTER TABLE `focalpointjiracreation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `governorate`
--

DROP TABLE IF EXISTS `governorate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `governorate` (
  `GovID` int(11) NOT NULL AUTO_INCREMENT,
  `GovName` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `GovNameEn` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `GovNameFr` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `GovNamePath` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `IsActive` bit(1) DEFAULT NULL,
  `IsDeleted` bit(1) DEFAULT NULL,
  `DateCreated` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`GovID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `governorate`
--

LOCK TABLES `governorate` WRITE;
/*!40000 ALTER TABLE `governorate` DISABLE KEYS */;
INSERT INTO `governorate` VALUES (1,'Mount Lebanon','Mount Lebanon','Mount Lebanon','IRC0057','','\0','0000-00-00 00:00:00'),(2,'Tripoli','Tripoli','Tripoli','IRC0058','','\0','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `governorate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pin`
--

DROP TABLE IF EXISTS `pin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pin` (
  `SPID` int(11) NOT NULL,
  `PIN` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`SPID`),
  CONSTRAINT `spid` FOREIGN KEY (`SPID`) REFERENCES `serviceprovider` (`SPID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pin`
--

LOCK TABLES `pin` WRITE;
/*!40000 ALTER TABLE `pin` DISABLE KEYS */;
INSERT INTO `pin` VALUES (14,'5653');
/*!40000 ALTER TABLE `pin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refugeefeedback`
--

DROP TABLE IF EXISTS `refugeefeedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refugeefeedback` (
  `RFBID` int(11) NOT NULL AUTO_INCREMENT,
  `FBQuestionID` int(11) DEFAULT NULL,
  `FBAnswerID` int(11) DEFAULT NULL,
  `DateCreated` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`RFBID`),
  KEY `FBQuestionID_idx` (`FBQuestionID`),
  KEY `FBAnswerID_idx` (`FBAnswerID`),
  CONSTRAINT `FBAnswerID` FOREIGN KEY (`FBAnswerID`) REFERENCES `feedbackanswer` (`FBAnswerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FBQuestionID` FOREIGN KEY (`FBQuestionID`) REFERENCES `feedbackquestion` (`FBQuestionID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refugeefeedback`
--

LOCK TABLES `refugeefeedback` WRITE;
/*!40000 ALTER TABLE `refugeefeedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `refugeefeedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service` (
  `ServiceID` int(11) NOT NULL AUTO_INCREMENT,
  `SPID` int(11) DEFAULT NULL,
  `ServiceTypeID` int(11) DEFAULT NULL,
  `ServiceDistID` int(11) DEFAULT NULL,
  `ServiceName` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `ServiceNameEn` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `ServiceNameFr` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `ServiceNamePath` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `ServiceAddInfoPath` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `ServiceAddInfo` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `IsActive` bit(1) DEFAULT b'1',
  `IsDeleted` bit(1) DEFAULT b'0',
  `DateCreated` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ServiceID`),
  KEY `Service_type_idx` (`ServiceTypeID`),
  KEY `Service_district_idx` (`ServiceDistID`),
  CONSTRAINT `Service_district` FOREIGN KEY (`ServiceDistID`) REFERENCES `district` (`DistID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Service_type` FOREIGN KEY (`ServiceTypeID`) REFERENCES `servicetype` (`ServiceTypeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (11,14,1,7,NULL,NULL,NULL,'/tmp/asterisk/records/SP/1000/SERVICES/SP_SERVICE_20151019_063653','/tmp/asterisk/records/SP/1000/SERVICES/SP_SERVICE_ADD_INFO_20151019_063706',NULL,'','\0','2015-10-19 06:37:15');
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicejiracreation`
--

DROP TABLE IF EXISTS `servicejiracreation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicejiracreation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SerivceID` int(11) DEFAULT NULL,
  `Links` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `DateAdded` datetime DEFAULT '0000-00-00 00:00:00',
  `IssueKey` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `JiraCreated` bit(1) DEFAULT b'0',
  `JiraVetted` bit(1) DEFAULT b'0',
  `JiraLabel` varchar(500) DEFAULT 'IVRServiceCreation',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicejiracreation`
--

LOCK TABLES `servicejiracreation` WRITE;
/*!40000 ALTER TABLE `servicejiracreation` DISABLE KEYS */;
INSERT INTO `servicejiracreation` VALUES (1,NULL,'/tmp/asterisk/records/SP/1000/SERVICES/SP_SERVICE_20151016_044003;/tmp/asterisk/records/SP/1000/SERVICES/SP_SERVICE_ADD_INFO_20151016_044020','2015-10-16 04:40:29',NULL,'','\0','IVRServiceCreation'),(2,NULL,'/tmp/asterisk/records/SP/1000/SERVICES/SP_SERVICE_20151016_044643;/tmp/asterisk/records/SP/1000/SERVICES/SP_SERVICE_ADD_INFO_20151016_044708','2015-10-16 04:47:18',NULL,'','\0','IVRServiceCreation'),(3,NULL,'/tmp/asterisk/records/SP/1000/SERVICES/SP_SERVICE_ADD_INFO_20151016_045441','2015-10-16 04:54:50',NULL,'','\0','IVRServiceCreation'),(4,NULL,'/tmp/asterisk/records/SP/1000/SERVICES/SP_SERVICE_20151016_050133;/tmp/asterisk/records/SP/1000/SERVICES/SP_SERVICE_ADD_INFO_20151016_050149','2015-10-16 05:01:59',NULL,'','\0','IVRServiceCreation'),(5,NULL,'/tmp/asterisk/records/SP/1000/SERVICES/SP_SERVICE_20151016_052228;/tmp/asterisk/records/SP/1000/SERVICES/SP_SERVICE_ADD_INFO_20151016_052245','2015-10-16 05:22:52',NULL,'','\0','IVRServiceCreation'),(6,NULL,'/tmp/asterisk/records/SP/1000/SERVICES/SP_SERVICE_20151016_053706;/tmp/asterisk/records/SP/1000/SERVICES/SP_SERVICE_ADD_INFO_20151016_053723','2015-10-16 05:37:39',NULL,'','\0','IVRServiceCreation'),(7,NULL,'/tmp/asterisk/records/SP/1000/SERVICES/SP_SERVICE_20151016_053830;/tmp/asterisk/records/SP/1000/SERVICES/SP_SERVICE_ADD_INFO_20151016_053843','2015-10-16 05:38:48',NULL,'','\0','IVRServiceCreation'),(8,NULL,'/tmp/asterisk/records/SP/1000/SERVICES/SP_SERVICE_20151019_063653;/tmp/asterisk/records/SP/1000/SERVICES/SP_SERVICE_ADD_INFO_20151019_063706','2015-10-19 06:37:15',NULL,'\0','\0','IVRServiceCreation');
/*!40000 ALTER TABLE `servicejiracreation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `serviceprovider`
--

DROP TABLE IF EXISTS `serviceprovider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `serviceprovider` (
  `SPID` int(11) NOT NULL AUTO_INCREMENT,
  `SPANI` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPTypeID` int(11) DEFAULT NULL,
  `SPPhone` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPName` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPNameEn` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPNameFr` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPNamePath` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPAddress` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPAddressEn` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPAddressFr` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPAddressPath` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPPIN` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPFocalPoint` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPFocalPointEn` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPFocalPointFr` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPFocalPointPath` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPFocalPointPhone` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `IsActive` bit(1) DEFAULT NULL,
  `IsDeleted` bit(1) DEFAULT b'0',
  `DateCreated` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`SPID`),
  KEY `sptype_id_idx` (`SPTypeID`),
  CONSTRAINT `sptype_id` FOREIGN KEY (`SPTypeID`) REFERENCES `servicetype` (`ServiceTypeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `serviceprovider`
--

LOCK TABLES `serviceprovider` WRITE;
/*!40000 ALTER TABLE `serviceprovider` DISABLE KEYS */;
INSERT INTO `serviceprovider` VALUES (14,'1000',1,'03291171',NULL,NULL,NULL,'/tmp/asterisk/records/SP/1000/NAME/SP_NAME_20151019_063417',NULL,NULL,NULL,'/tmp/asterisk/records/SP/1000/ADDRESS/SP_ADDRESS_20151019_063510','5653',NULL,NULL,NULL,'/tmp/asterisk/records/SP/1000/FOCALPOINT/SP_FOCALPIONT_20151019_063529','03333333','','\0','2015-10-19 06:35:52');
/*!40000 ALTER TABLE `serviceprovider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `serviceprovidertype`
--

DROP TABLE IF EXISTS `serviceprovidertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `serviceprovidertype` (
  `SPTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `SPType` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPTypeEn` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPTypeFr` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `SPTypePath` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `IsActive` bit(1) DEFAULT NULL,
  `IsDeleted` bit(1) DEFAULT NULL,
  `DateCreated` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`SPTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `serviceprovidertype`
--

LOCK TABLES `serviceprovidertype` WRITE;
/*!40000 ALTER TABLE `serviceprovidertype` DISABLE KEYS */;
/*!40000 ALTER TABLE `serviceprovidertype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicetype`
--

DROP TABLE IF EXISTS `servicetype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicetype` (
  `ServiceTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `ServiceType` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `ServiceTypeEn` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `ServiceTypeFr` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `ServiceTypePath` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `IsActive` bit(1) DEFAULT NULL,
  `IsDeleted` bit(1) DEFAULT NULL,
  `DateCreated` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ServiceTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicetype`
--

LOCK TABLES `servicetype` WRITE;
/*!40000 ALTER TABLE `servicetype` DISABLE KEYS */;
INSERT INTO `servicetype` VALUES (1,'خدمات التعليم','Education services','Education services','IRC0047','','\0','0000-00-00 00:00:00'),(2,'الخدمات الصحية','Health services','Health services','IRC0048','','\0','0000-00-00 00:00:00'),(3,'المأوى وخدمات الصرف الصحي والنظافة','Shelter & Wash services','Shelter & Wash services','IRC0049','','\0','0000-00-00 00:00:00'),(4,'الخدمات المالية','Financial services','Financial services','IRC0050','','\0','0000-00-00 00:00:00'),(5,'الخدمات القانونية','Legal services','Legal services','IRC0051','','\0','0000-00-00 00:00:00'),(6,'الإعاشات الغذائية','Food security','Food security','IRC0052','','\0','0000-00-00 00:00:00'),(7,'المساعدات العينية الغير غذائية والغير مالية','Material Support (excluding cash and food)','Material Support (excluding cash and food)','IRC0053','','\0','0000-00-00 00:00:00'),(8,'المراكز الإجتماعية','Community centers','Community centers','IRC0054','','\0','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `servicetype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms`
--

DROP TABLE IF EXISTS `sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Text` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `IsActive` int(11) DEFAULT NULL,
  `IsDeleted` int(11) DEFAULT NULL,
  `DateCreated` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms`
--

LOCK TABLES `sms` WRITE;
/*!40000 ALTER TABLE `sms` DISABLE KEYS */;
INSERT INTO `sms` VALUES (1,'asdasd',1,0,'0000-00-00 00:00:00'),(2,'asdasd',1,0,'0000-00-00 00:00:00'),(3,'111',1,0,'0000-00-00 00:00:00'),(4,'22222',1,0,'0000-00-00 00:00:00'),(5,'333333333',1,0,'0000-00-00 00:00:00'),(6,'hassan zreik ',1,0,'0000-00-00 00:00:00'),(7,'hassan zreik ',1,0,'0000-00-00 00:00:00'),(8,'asdasd',1,0,'0000-00-00 00:00:00'),(9,'asdasd',1,0,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `sms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spjiracreation`
--

DROP TABLE IF EXISTS `spjiracreation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spjiracreation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spANI` varchar(500) DEFAULT NULL,
  `spPIN` varchar(500) DEFAULT NULL,
  `spType` int(11) DEFAULT NULL,
  `Links` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `DateAdded` datetime DEFAULT '0000-00-00 00:00:00',
  `IssueKey` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `JiraCreated` bit(1) DEFAULT b'0',
  `JiraVetted` bit(1) DEFAULT b'0',
  `JiraLabel` varchar(500) DEFAULT 'IVRSPRegistration',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spjiracreation`
--

LOCK TABLES `spjiracreation` WRITE;
/*!40000 ALTER TABLE `spjiracreation` DISABLE KEYS */;
INSERT INTO `spjiracreation` VALUES (2,'1000',NULL,1,'/tmp/asterisk/records/SP/1000/NAME/SP_NAME_20151019_063417;/tmp/asterisk/records/SP/1000/ADDRESS/SP_ADDRESS_20151019_063510;/tmp/asterisk/records/SP/1000/FOCALPOINT/SP_FOCALPIONT_20151019_063529','2015-10-19 06:36:00',NULL,'\0','\0','IVRSPRegistration');
/*!40000 ALTER TABLE `spjiracreation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sysdiagram`
--

DROP TABLE IF EXISTS `sysdiagram`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sysdiagram` (
  `SysDiagramID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `PrincipalID` int(11) DEFAULT NULL,
  `Version` int(11) DEFAULT NULL,
  `Definition` varbinary(999) DEFAULT NULL,
  PRIMARY KEY (`SysDiagramID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sysdiagram`
--

LOCK TABLES `sysdiagram` WRITE;
/*!40000 ALTER TABLE `sysdiagram` DISABLE KEYS */;
/*!40000 ALTER TABLE `sysdiagram` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-10-19 16:44:35
