-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: paymentengine
-- ------------------------------------------------------
-- Server version	5.1.73-log

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
-- Table structure for table `st_payment_account_branch_mapping`
--

DROP TABLE IF EXISTS `st_payment_account_branch_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_account_branch_mapping` (
  `serno` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `bankid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `accountno` varchar(25) NOT NULL DEFAULT '',
  `branchid` varchar(10) NOT NULL DEFAULT '',
  `status` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`serno`)
) ENGINE=InnoDB AUTO_INCREMENT=222 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_account_branch_mapping`
--

LOCK TABLES `st_payment_account_branch_mapping` WRITE;
/*!40000 ALTER TABLE `st_payment_account_branch_mapping` DISABLE KEYS */;
INSERT INTO `st_payment_account_branch_mapping` VALUES (1,2,'262000032464','1','Y'),(2,2,'262000032464','10','Y'),(3,2,'262000032464','12','Y'),(4,2,'262000032464','13','Y'),(5,2,'262000032464','17','Y'),(6,2,'262000032464','20','Y'),(7,2,'262000032464','21','Y'),(8,2,'262000032464','23','Y'),(9,2,'262000032464','25','Y'),(10,2,'342000039163','6','Y'),(11,2,'342000039163','20','Y'),(12,2,'342000039163','23','Y'),(13,2,'1182000011629','3','Y'),(14,2,'1182000011629','5','Y'),(15,2,'1042000012629','4','Y'),(16,2,'62000034222','11','Y'),(17,2,'42000027359','2','Y'),(18,2,'42000027359','15','Y'),(19,2,'42000027359','16','Y'),(20,2,'4462000003762','7','Y'),(21,2,'4462000003762','24','Y'),(22,2,'142320003767','14','Y'),(23,2,'142320003767','18','Y'),(24,2,'142320003767','19','Y'),(25,2,'142320003767','22','Y'),(26,2,'142320003767','8','Y'),(27,2,'142320003767','9','Y'),(28,1,'913020055544763','1','N'),(30,8,'1681400004720','1','Y'),(31,8,'1681400004720','2','N'),(32,8,'1681400004720','3','Y'),(33,8,'1681400004720','4','Y'),(34,8,'1681400004720','5','N'),(35,8,'1681400004720','7','Y'),(36,8,'1681400004720','10','Y'),(37,8,'1681400004720','11','N'),(38,8,'1681400004720','12','Y'),(39,8,'1681400004720','13','Y'),(40,8,'1681400004720','14','N'),(41,8,'1681400004720','15','Y'),(42,8,'1681400004720','16','Y'),(43,8,'1681400004720','17','N'),(44,8,'1681400004720','19','Y'),(45,8,'1681400004720','24','Y'),(47,6,'60091943962','1','Y'),(48,6,'60091943962','2','Y'),(49,6,'60091943962','3','Y'),(50,6,'60091943962','4','Y'),(51,6,'60091943962','5','Y'),(52,6,'60091943962','6','Y'),(53,6,'60091943962','7','Y'),(54,6,'60091943962','8','Y'),(55,6,'60091943962','9','Y'),(56,6,'60091943962','10','Y'),(57,6,'60091943962','11','Y'),(58,6,'60091943962','12','Y'),(59,6,'60091943962','13','Y'),(60,6,'60091943962','14','Y'),(61,6,'60091943962','15','Y'),(62,6,'60091943962','16','Y'),(63,6,'60091943962','17','Y'),(64,6,'60091943962','18','Y'),(65,6,'60091943962','19','Y'),(66,6,'60091943962','20','Y'),(67,6,'60091943962','21','Y'),(68,1,'915020040731963','11','Y'),(69,1,'915020041501989','3','Y'),(70,1,'915020041501989','4','Y'),(71,1,'915020041501989','5','Y'),(72,1,'915020043510877','14','N'),(73,1,'915020043510877','18','N'),(74,1,'915020043510877','19','N'),(75,1,'915020043510877','22','N'),(76,1,'915020043510877','8','N'),(77,1,'915020043510877','9','N'),(78,1,'915020042140691','6','Y'),(79,1,'915020042140691','10','Y'),(80,1,'915020042140691','12','Y'),(81,1,'915020042140691','13','Y'),(82,1,'915020042140691','17','Y'),(83,1,'915020042140691','20','Y'),(84,1,'915020042140691','21','Y'),(85,1,'915020042140691','23','Y'),(86,1,'915020042140691','25','Y'),(87,1,'915020045983415','7','N'),(88,1,'915020045983415','2','N'),(89,1,'915020045983415','15','N'),(90,1,'915020045983415','16','N'),(91,1,'915020045983415','24','N'),(100,1,'915020041501989','1','Y'),(101,8,'1681400004720','6','Y'),(102,8,'1681400004720','8','N'),(103,8,'1681400004720','9','Y'),(104,8,'1681400004720','18','Y'),(105,8,'1681400004720','20','Y'),(106,8,'1681400004720','21','Y'),(107,8,'1681400004720','22','Y'),(108,8,'1681400004720','23','Y'),(109,8,'1681400004720','25','Y'),(110,1,'913020055544763','2','N'),(111,1,'913020055544763','3','N'),(112,1,'913020055544763','4','N'),(113,1,'913020055544763','5','N'),(114,1,'913020055544763','6','N'),(115,1,'913020055544763','7','N'),(116,1,'913020055544763','8','N'),(117,1,'913020055544763','9','N'),(118,1,'913020055544763','10','N'),(119,1,'913020055544763','11','N'),(120,1,'913020055544763','12','N'),(121,1,'913020055544763','13','N'),(122,1,'913020055544763','14','N'),(123,1,'913020055544763','15','N'),(124,1,'913020055544763','16','N'),(125,1,'913020055544763','17','N'),(126,1,'913020055544763','18','N'),(127,1,'913020055544763','19','N'),(128,1,'913020055544763','20','N'),(129,1,'913020055544763','21','N'),(130,1,'913020055544763','22','N'),(131,1,'913020055544763','23','N'),(132,1,'913020055544763','24','N'),(133,1,'913020055544763','25','N'),(134,1,'915020041501989','2','Y'),(135,1,'915020041501989','6','Y'),(136,1,'915020041501989','7','Y'),(137,1,'915020041501989','8','Y'),(138,1,'915020041501989','9','Y'),(139,1,'915020041501989','10','Y'),(140,1,'915020041501989','11','Y'),(141,1,'915020041501989','12','Y'),(142,1,'915020041501989','13','Y'),(143,1,'915020041501989','14','Y'),(144,1,'915020041501989','15','Y'),(145,1,'915020041501989','16','Y'),(146,1,'915020041501989','17','Y'),(147,1,'915020041501989','18','Y'),(148,1,'915020041501989','19','Y'),(149,1,'915020041501989','20','Y'),(150,1,'915020041501989','21','Y'),(151,1,'915020041501989','22','Y'),(152,1,'915020041501989','23','Y'),(153,1,'915020041501989','24','Y'),(154,1,'915020041501989','25','Y'),(155,1,'915020042140691','1','Y'),(156,1,'915020042140691','2','Y'),(157,1,'915020042140691','3','Y'),(158,1,'915020042140691','4','Y'),(159,1,'915020042140691','5','Y'),(160,1,'915020042140691','7','Y'),(161,1,'915020042140691','8','Y'),(162,1,'915020042140691','9','Y'),(163,1,'915020042140691','11','Y'),(164,1,'915020042140691','14','Y'),(165,1,'915020042140691','15','Y'),(166,1,'915020042140691','16','Y'),(167,1,'915020042140691','18','Y'),(168,1,'915020042140691','19','Y'),(169,1,'915020042140691','22','Y'),(170,1,'915020042140691','24','Y'),(171,4,'678676767676767','1','Y'),(172,4,'898989898989','1','Y'),(173,4,'31031663553','1','Y'),(174,4,'31031663553','2','Y'),(175,4,'31031663553','3','Y'),(176,4,'31031663553','4','Y'),(177,4,'31031663553','5','Y'),(178,4,'31031663553','6','Y'),(179,4,'31031663553','7','Y'),(180,4,'31031663553','8','Y'),(181,4,'31031663553','9','Y'),(182,4,'31031663553','10','Y'),(183,4,'31031663553','11','Y'),(184,4,'31031663553','12','Y'),(185,4,'31031663553','13','Y'),(186,4,'31031663553','14','Y'),(187,4,'31031663553','15','Y'),(188,4,'31031663553','16','Y'),(189,4,'31031663553','17','Y'),(190,4,'31031663553','18','Y'),(191,4,'31031663553','19','Y'),(192,4,'31031663553','20','Y'),(193,4,'31031663553','21','Y'),(194,4,'31031663553','22','Y'),(195,4,'31031663553','23','Y'),(196,4,'31031663553','24','Y'),(197,4,'31031663553','25','Y'),(198,1,'915020040731963','1','Y'),(199,1,'915020040731963','2','Y'),(200,1,'915020040731963','3','Y'),(201,1,'915020040731963','4','Y'),(202,1,'915020040731963','5','Y'),(203,1,'915020040731963','6','Y'),(204,1,'915020040731963','7','Y'),(205,1,'915020040731963','8','Y'),(206,1,'915020040731963','9','Y'),(207,1,'915020040731963','10','Y'),(208,1,'915020040731963','12','Y'),(209,1,'915020040731963','13','Y'),(210,1,'915020040731963','14','Y'),(211,1,'915020040731963','15','Y'),(212,1,'915020040731963','16','Y'),(213,1,'915020040731963','17','Y'),(214,1,'915020040731963','18','Y'),(215,1,'915020040731963','19','Y'),(216,1,'915020040731963','20','Y'),(217,1,'915020040731963','21','Y'),(218,1,'915020040731963','22','Y'),(219,1,'915020040731963','23','Y'),(220,1,'915020040731963','24','Y'),(221,1,'915020040731963','25','Y');
/*!40000 ALTER TABLE `st_payment_account_branch_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_bank_account_master`
--

DROP TABLE IF EXISTS `st_payment_bank_account_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_bank_account_master` (
  `serno` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `provider_id` smallint(5) unsigned NOT NULL,
  `bankid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `accountno` varchar(25) NOT NULL DEFAULT '',
  `ifsc_code` varchar(20) DEFAULT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'N',
  `offline_status` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`serno`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_bank_account_master`
--

LOCK TABLES `st_payment_bank_account_master` WRITE;
/*!40000 ALTER TABLE `st_payment_bank_account_master` DISABLE KEYS */;
INSERT INTO `st_payment_bank_account_master` VALUES (1,2,1,'913020055544763',NULL,'N','N'),(2,2,1,'915020040731963',NULL,'Y','N'),(3,2,1,'915020041501989',NULL,'Y','N'),(4,2,1,'915020043510877',NULL,'Y','N'),(5,2,1,'915020042140691',NULL,'Y','N'),(6,2,1,'915020045983415',NULL,'Y','N'),(7,2,2,'262000032464',NULL,'Y','N'),(8,2,2,'342000039163',NULL,'Y','N'),(9,2,2,'1182000011629',NULL,'Y','N'),(10,2,2,'1042000012629',NULL,'Y','N'),(11,2,2,'62000034222',NULL,'Y','N'),(12,2,2,'42000027359',NULL,'Y','N'),(13,2,2,'4462000003762',NULL,'Y','N'),(14,2,2,'142320003767',NULL,'Y','N'),(15,2,4,'678676767676767',NULL,'Y','N'),(16,2,3,'54405006091',NULL,'Y','N'),(17,2,3,'345353453453',NULL,'Y','N'),(18,2,4,'898989898989',NULL,'Y','N'),(19,2,4,'31031663553',NULL,'Y','N'),(20,2,6,'60091943962',NULL,'Y','N'),(21,2,8,'1681400004720',NULL,'Y','N'),(23,2,5,'8888888888888888',NULL,'Y','N'),(24,2,4,'8888888777777',NULL,'Y','N'),(25,2,8,'666666666666666',NULL,'Y','N'),(26,2,8,'5656565656',NULL,'Y','N'),(27,2,5,'7878787878',NULL,'Y','N'),(28,2,7,'567567567567',NULL,'Y','N'),(29,2,7,'11111111111111111',NULL,'Y','N'),(32,6,59,'PAYYES','IFSC456','N',''),(33,6,58,'ICICI907','','Y','N'),(34,2,6,'55555555555999',NULL,'Y','N'),(35,6,60,'IND{CODE}DD','INDUS','Y','N'),(36,6,58,'TEST{CODE}','hgjhghj3454545','Y','N'),(37,6,58,'PAYES{CODE}','ertrdg','Y','N');
/*!40000 ALTER TABLE `st_payment_bank_account_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_bank_master`
--

DROP TABLE IF EXISTS `st_payment_bank_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_bank_master` (
  `bankid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `provider_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `bankcode` varchar(10) NOT NULL DEFAULT '',
  `bankname` varchar(50) NOT NULL DEFAULT '',
  `logo` varchar(200) DEFAULT '',
  `uiorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `status` enum('Y','N') NOT NULL DEFAULT 'N',
  `provider_bankcode` varchar(10) DEFAULT '',
  PRIMARY KEY (`bankid`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_bank_master`
--

LOCK TABLES `st_payment_bank_master` WRITE;
/*!40000 ALTER TABLE `st_payment_bank_master` DISABLE KEYS */;
INSERT INTO `st_payment_bank_master` VALUES (1,2,'AXIS','AXIS BANK','/webroot/banklogo/10012018150228axis.png',2,'Y','PwAXIS'),(2,2,'HDFC','HDFC Bank','/webroot/banklogo/10012018150236hdfc bank.png',5,'N','PwHDFC'),(3,2,'ICIC','ICICI Bank','/webroot/banklogo/10012018150728icici-bank-logo.jpg',1,'N','PwICICI'),(4,2,'SBI','SBI Bank','/webroot/banklogo/10012018150322sbi.png',3,'Y','PwSBI'),(5,2,'PNB','PNB BANK','/webroot/banklogo/10012018151402pnb.png',8,'Y','PwPNB'),(6,2,'BOM','Bank Of Maharashtra','',7,'Y','PwBOM'),(7,2,'BOB','Bank of Baroda','',9,'Y','PwBOB'),(8,2,'YESB','YES BANK','',10,'Y','PwYES'),(9,2,'CANB','CANARA BANK','',11,'Y','PwCANARA'),(10,3,'AXIB','AXIS BANK','/webroot/banklogo/10012018150228axis.png',3,'N','PwAXIS'),(11,3,'SRSWT','Saraswat Bank Net Banking','',1,'Y','PwSRSWT'),(12,3,'ICIB','ICICI Netbanking','',2,'Y','PwICICI'),(13,3,'HDFB','HDFC Bank','/webroot/banklogo/10012018150236hdfc bank.png',4,'Y','PwHDFC'),(14,3,'YESB','Yes Bank','',5,'Y','PwYES'),(15,3,'BOIB','Bank of India','',6,'Y','PwBOI'),(16,3,'BOMB','Bank of Maharashtra','',7,'Y','PwBOM'),(17,3,'CABB','Canara Bank','',8,'Y','PwCANARA'),(18,3,'CSBN','Catholic Syrian Bank','',9,'Y','PwCSBN'),(19,3,'CBIB','Central Bank Of India','',10,'Y','PwCBI'),(20,3,'CUBB','CITY UNION BANK','',11,'Y','PwCUB'),(21,3,'CRPB','Corporation Bank','',12,'Y','PwCRPB'),(22,3,'DSHB','Deutsche bank Netbanking','',13,'Y','PwDSHB'),(23,3,'DCBB','Development Credit Bank','',14,'Y','PwDCBB'),(24,3,'DLSB','Dhanlaxmi Netbanking','',15,'Y','PwDLSB'),(25,3,'FEDB','Federal Bank','',16,'Y','PwFEDB'),(26,3,'INDB','Indian Bank','',17,'Y','PwINDB'),(27,3,'INOB','Indian Overseas Bank','',18,'Y','PwINOB'),(28,3,'INIB','IndusInd Bank','',19,'Y','PwINDUSIND'),(29,3,'IDBB','IDBI Bank','',20,'Y','PwIDBI'),(30,3,'162B','kotak bank Netbanking','',21,'Y','PwKTKB'),(31,3,'JAKB','Jammu and Kashmir Bank','',22,'Y','PwJAKB'),(32,3,'KRKB','Karnataka Bank','',23,'Y','PwKRK'),(33,3,'KRVB','Karur Vysya-Retail Netbanking','',24,'Y','PwKRVB'),(34,3,'KRVBC','Karur Vysya - Corporate Netbanking','',25,'Y','PwKRVBC'),(35,3,'CPNB','Punjab National Bank - Corporate Netbanking','',26,'Y','PwPNBC'),(36,3,'PNBB','Punjab National Bank - Retail Netbanking','',27,'Y','PwPNB'),(37,3,'SOIB','South Indian Bank','',28,'Y','PwSOIB'),(38,3,'SBBJB','State Bank of Bikaner and Jaipur','',29,'Y','PwSBBJB'),(39,3,'SBHB','State Bank of Hyderabad','',30,'Y','PwSBHB'),(40,3,'SBIB','State Bank of India','',31,'Y','PwSBI'),(41,3,'SBMB','State Bank of Mysore','',32,'Y','PwSBM'),(42,3,'SBTB','State Bank of Travancore','',33,'Y','PwSBT'),(43,3,'UBIBC','Union Bank - Corporate Netbanking','',34,'Y','PwUNBC'),(44,3,'UBIB','Union Bank - Retail Netbanking','',35,'Y','PwUNB'),(45,3,'UNIB','United Bank Of India','',36,'Y','PwUNIB'),(46,3,'VJYB','Vijaya Bank','',37,'Y','PwVJYB'),(47,3,'SYNDB','Syndicate Bank','',38,'Y','PwSYNDB'),(48,3,'ADBB','Andhra Bank','',39,'Y','PwADBB'),(49,3,'UCOB','UCO Bank','',40,'Y','PwUCOB'),(50,3,'TMBB','Tamilnad Mercantile Bank','',41,'Y','PwTMBB'),(51,3,'SBPB','State Bank of Patiala','',42,'Y','PwSBPB'),(52,3,'OBCB','Oriental Bank of commerce','',43,'Y','PwOBCB'),(53,3,'JSBNB','Janata Sahakari Bank Pune','',44,'Y','PwJSBPB'),(54,3,'INGB','ING Vysya Bank','',45,'Y','PwINGB'),(55,3,'DCBCORP','DCB Bank - Corporate Netbanking','',46,'Y','PwDCB'),(56,3,'AIRNB','Airtel Payments Bank','',47,'Y','PwAIRPB'),(57,3,'DENN','Dena Bank','',48,'Y','PwDENB'),(58,6,'ICICI','ICICI Bank','/webroot/banklogo/10012018150728icici-bank-logo.jpg',2,'N','PwICICI'),(59,6,'YESB','YES Bank','',1,'N','PwYES'),(60,6,'INDUSIND','INDUSIND Bank','',3,'Y','PwINDUSIND'),(61,4,'AXIS','AXIS BANK','/webroot/banklogo/10012018150228axis.png',0,'N','PwAXIS'),(62,5,'AXIS','AXIS BANK','/webroot/banklogo/10012018150228axis.png',0,'Y','PwAXIS'),(65,7,'AXIX','AXIS BANK','/webroot/banklogo/10012018150228axis.png',0,'N','PwAXIS'),(70,2,'asdasd','asdasd','',6,'Y','asdasd'),(71,2,'sdfsd','sdfsdf','',4,'Y','sdfsdf'),(72,2,'sdfsdf','sdfsdfsdf','/webroot/banklogo/17012018165719Screenshot_20171221-182449.png',0,'N','sdfsdfsdf');
/*!40000 ALTER TABLE `st_payment_bank_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_bank_statement_schema`
--

DROP TABLE IF EXISTS `st_payment_bank_statement_schema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_bank_statement_schema` (
  `serno` int(11) NOT NULL AUTO_INCREMENT,
  `bankid` char(50) DEFAULT NULL,
  `bankname` char(100) NOT NULL DEFAULT '',
  `column_no` int(11) NOT NULL DEFAULT '0',
  `column_name` char(100) NOT NULL DEFAULT '',
  `column_type` char(100) NOT NULL DEFAULT '',
  `column_data_type` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`serno`),
  KEY `bankcode` (`bankid`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_bank_statement_schema`
--

LOCK TABLES `st_payment_bank_statement_schema` WRITE;
/*!40000 ALTER TABLE `st_payment_bank_statement_schema` DISABLE KEYS */;
INSERT INTO `st_payment_bank_statement_schema` VALUES (1,'1','Axis Bank',3,'Tran Date','Transaction Date','date'),(2,'1','Axis Bank',4,'Chq No','Cheque No','AN:0:0'),(3,'1','Axis Bank',5,'Particulars','Remarks','AN:0:0'),(4,'1','Axis Bank',9,'Debit','Debit Amount','DOUBLE:0:0'),(5,'1','Axis Bank',13,'Credit','Credit Amount','DOUBLE:0:0'),(6,'1','Axis Bank',15,'Balance','Balance','DOUBLE:0:0'),(7,'2','HDFC Bank',1,'Transaction Date','Transaction Date','datetime'),(9,'2','HDFC Bank',4,'Description','Remarks','AN:0:0'),(10,'2','HDFC Bank',5,'Debit Amount','Debit Amount','DOUBLE:0:0'),(11,'2','HDFC Bank',6,'Credit Amount','Credit Amount','DOUBLE:0:0'),(12,'2','HDFC Bank',7,'Running Balance','Balance','DOUBLE:0:0'),(13,'3','ICICI Bank',2,'Transaction ID','Transaction ID','AN:0:0'),(14,'3','ICICI Bank',4,'Txn Posted Date','Transaction Date','datetime'),(15,'3','ICICI Bank',5,'ChequeNo.','Cheque No','AN:0:0'),(16,'3','ICICI Bank',6,'Description','Remarks','AN:0:0'),(17,'3','ICICI Bank',9,'Available Balance(INR)','Balance','DOUBLE:0:0'),(18,'4','SBI Bank',1,'Txn Date','Transaction Date','date'),(19,'4','SBI Bank',3,'Description','Remarks','AN:0:0'),(20,'4','SBI Bank',4,'Ref No./Cheque No.','Transaction ID','AN:0:0'),(21,'4','SBI Bank',5,'Branch Code','Branch Code','AN:0:0'),(22,'4','SBI Bank',6,'Debit','Debit Amount','DOUBLE:0:0'),(23,'4','SBI Bank',7,'Credit','Credit Amount','DOUBLE:0:0'),(24,'4','SBI Bank',8,'Balance','Balance','DOUBLE:0:0'),(33,'6','Bank Of Maharashtra',1,'Post Date','Transaction Date','date'),(34,'6','Bank Of Maharashtra',3,'Cheque No','Cheque No','AN:0:0'),(35,'6','Bank Of Maharashtra',4,'Particulars','Remarks','AN:0:0'),(36,'6','Bank Of Maharashtra',5,'DR','Debit Amount','DOUBLE:0:0'),(37,'6','Bank Of Maharashtra',6,'CR','Credit Amount','DOUBLE:0:0'),(38,'6','Bank Of Maharashtra',7,'Balance','Balance','DOUBLE:0:0'),(39,'6','Bank Of Maharashtra',8,'TR Location','Transaction Location','AN:0:0'),(57,'1','Axis Bank',16,'Init. Br','Branch Name','AN:0:0'),(60,'4','SBI Bank',9,'Circle Name','Cir Name','AN:0:0'),(61,'4','SBI Bank',10,'Branch Name','Branch Name','AN:0:0'),(62,'10','Bank of Baroda',2,'Date','Transaction Date','date'),(63,'10','Bank of Baroda',3,'Description(Remark)','Remarks','AN:0:0'),(64,'10','Bank of Baroda',4,'Cheque No.','Cheque No','AN:0:0'),(65,'10','Bank of Baroda',5,'Debit Amount','Debit Amount','DOUBLE:0:0'),(66,'10','Bank of Baroda',6,'Credit Amount','Credit Amount','DOUBLE:0:0'),(67,'10','Bank of Baroda',7,'Balance','Balance','DOUBLE:0:0'),(68,'12','CANARA BANK',1,'Transaction Date','Transaction Date','datetime'),(69,'12','CANARA BANK',2,'Value Date','Transaction Date','date'),(70,'12','CANARA BANK',3,'Cheque No.','Cheque No','AN:0:0'),(71,'12','CANARA BANK',4,'Description','Remarks','AN:0:0'),(72,'12','CANARA BANK',6,'Debit','Debit Amount','DOUBLE:0:0'),(73,'12','CANARA BANK',7,'Credit','Credit Amount','DOUBLE:0:0'),(74,'12','CANARA BANK',8,'Balance','Balance','DOUBLE:0:0'),(75,'12','CANARA BANK',5,'Transaction Branch Code','Branch Code','AN:0:0'),(76,'11','YES BANK',1,'Transaction Date','Transaction Date','datetime'),(77,'11','YES BANK',2,'Value Date','Transaction Date','date'),(78,'11','YES BANK',3,'Transaction Amount','Transaction Amount','DOUBLE:0:0'),(79,'11','YES BANK',5,'Transaction Description','Remarks','AN:0:0'),(80,'11','YES BANK',6,'Reference No.','Transaction ID','AN:0:0'),(81,'11','YES BANK',8,'Branch Code','Branch Code','AN:0:0'),(82,'11','YES BANK',9,'Branch Name','Branch Name','AN:0:0'),(83,'11','YES BANK',10,'Running Balance','Balance','DOUBLE:0:0'),(84,'5','PNB Bank',1,'Txn No.','Transaction ID','AN:0:0'),(85,'5','PNB Bank',3,'Txn Date','Transaction Date','date'),(86,'5','PNB Bank',5,'Description','Remarks','AN:0:0'),(87,'5','PNB Bank',8,'Branch Name','Branch Name','AN:0:0'),(88,'5','PNB Bank',9,'Cheque No.','Cheque No','AN:0:0'),(89,'5','PNB Bank',10,'Dr Amount','Debit Amount','DOUBLE:0:0'),(90,'5','PNB Bank',13,'Cr Amount','Credit Amount','DOUBLE:0:0'),(91,'5','PNB Bank',15,'Balance','Balance','DOUBLE:0:0'),(92,'2','HDFC Bank',3,'Reference No.','Transaction ID','AN:0:0'),(93,'11','YES BANK',4,'Debit / Credit','Transaction Type','AN:0:0');
/*!40000 ALTER TABLE `st_payment_bank_statement_schema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_bank_statements`
--

DROP TABLE IF EXISTS `st_payment_bank_statements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_bank_statements` (
  `serno` int(11) NOT NULL AUTO_INCREMENT,
  `statement_date` date NOT NULL DEFAULT '0000-00-00',
  `transaction_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bankid` char(50) NOT NULL DEFAULT '',
  `bankname` char(100) NOT NULL DEFAULT '',
  `bank_account_no` char(50) NOT NULL DEFAULT '',
  `cheque_no` char(50) NOT NULL DEFAULT '',
  `remarks` text NOT NULL,
  `debit_amount` double NOT NULL DEFAULT '0',
  `credit_amount` double NOT NULL DEFAULT '0',
  `balance` double NOT NULL DEFAULT '0',
  `transaction_id` char(255) NOT NULL DEFAULT '',
  `branch_name` char(50) NOT NULL DEFAULT '',
  `branch_code` char(50) NOT NULL DEFAULT '',
  `transaction_location` char(100) NOT NULL DEFAULT '',
  `flag_auth` char(1) NOT NULL DEFAULT 'N',
  `flag_grant` char(1) NOT NULL DEFAULT 'N',
  `grant_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `auth_date` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`serno`),
  UNIQUE KEY `check_redundent1` (`debit_amount`,`credit_amount`,`balance`,`bank_account_no`),
  UNIQUE KEY `check_redundent` (`transaction_date`,`bankid`,`bankname`,`cheque_no`,`remarks`(100),`debit_amount`,`credit_amount`,`balance`,`transaction_id`,`branch_name`,`branch_code`,`transaction_location`),
  KEY `trandate` (`transaction_date`),
  KEY `bankid` (`bankid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_bank_statements`
--

LOCK TABLES `st_payment_bank_statements` WRITE;
/*!40000 ALTER TABLE `st_payment_bank_statements` DISABLE KEYS */;
INSERT INTO `st_payment_bank_statements` VALUES (1,'2017-12-29','2017-12-29 00:00:00','1','Axis Bank','915020041501989','','BY CASH DEPOSITBNA/APRH12505/5774/011117/THANE',0,62000,10518038.46,'','223','','','N','N','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'2017-12-29','2017-12-29 00:00:00','1','Axis Bank','915020041501989','','MOB/TPFT/SANJAY NARAYAN /911010055014054',0,1000,10519038.46,'','1438','','','N','N','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'2017-12-29','2017-12-29 00:00:00','1','Axis Bank','915020041501989','','BY CASH DEPOSITBNA/T3RO134201/5312/011117/THANE',0,5010,10524038.46,'','223','','','N','N','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'2017-12-29','2017-12-29 00:00:00','1','Axis Bank','915020041501989','','SAK/CASH DEP/SAK024892341/2762/BY CASH self',0,36000,10560038.46,'','2762','','','N','N','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'2017-12-29','2017-12-29 00:00:00','1','Axis Bank','915020041501989','','SAK/CASH DEP/SAK024894223/2769/BY CASH jitendra',0,105000,10665038.46,'','2769','','','N','N','0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,'2017-12-29','2017-12-29 00:00:00','1','Axis Bank','915020041501989','','SAK/CASH DEP/SAK024917705/1239/BY CASH',0,15300,10680338.46,'','1239','','','N','N','0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,'2017-12-29','2017-12-29 00:00:00','1','Axis Bank','915020041501989','','BY CASH DEPOSITBNA/S3RH86201/7225/011117/PUNE',0,15300,10725538.46,'','223','','','N','N','0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,'2017-12-29','2017-12-29 00:00:00','1','Axis Bank','915020041501989','','SAK/CASH DEP/SAK024908788/2203/BY CASH',0,62000,18932938.46,'','3903','','','N','N','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `st_payment_bank_statements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_branch_master`
--

DROP TABLE IF EXISTS `st_payment_branch_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_branch_master` (
  `branchid` int(3) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `branchname` varchar(150) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `contact_email` varchar(100) NOT NULL,
  `contact_phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `country_code` varchar(20) NOT NULL,
  `head_user_id` int(10) DEFAULT NULL,
  `gstin` varchar(255) DEFAULT NULL,
  `company_agent_code` varchar(255) DEFAULT NULL,
  `pw_state` text,
  `pw_db_serno` int(11) DEFAULT NULL,
  `pw_branch` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`branchid`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `branchname` (`branchname`),
  UNIQUE KEY `contact_email` (`contact_email`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_branch_master`
--

LOCK TABLES `st_payment_branch_master` WRITE;
/*!40000 ALTER TABLE `st_payment_branch_master` DISABLE KEYS */;
INSERT INTO `st_payment_branch_master` VALUES (1,'B001','Delhi/NCR','SUGAL AND DAMANI UTILITY SERVICES PVT. LTD.','delhi_ncr@sugaldamani.com','9458355879','6/35 W.E.A. KAROL BAGH NEW DELHI - 110005','IN',1,'','','Delhi',5,'B01',NULL,NULL),(2,'B002','CHENNAI','Sugal','chennai@sugaldamani.com','9675258476','No:7, Anna Salai, City Center  Plaza, 3rd Floor, Chennai-2 PH:044-28592434.','IN',2,'','','TAMILNADU',7,'B01',NULL,NULL),(3,'B003','MUMBAI','Sugal and Damani Utility Services Pvt Ltd','mumbai@sugaldamani.com','9815982412','512, 5th Floor, Corporate Office Building,Nirmal Lifestyle, L.B.S. Road,Mulund (W), Mumbai . 400080.','IN',3,'','','MAHARASHTRA',9,'B01',NULL,NULL),(4,'B004','PUNE','Sugal and Damani Utility Services Pvt Ltd','pune@sugaldamani.com','9952691625','A-27, 1st Floor, 45 Dr Ambedkar Road,Malawankar Industrial Estate,Next to Old RTO, Pune . 411001','IN',4,'','','MAHARASHTRA',9,'B02',NULL,NULL),(5,'B005','NAGPUR','Sugal and Damani Utility Services Pvt Ltd','nagpur@sugaldamani.com','9379274726','C-201, 2nd Floor, Kailash Industrial Complex,Ghatkopar Powai Link Road,Vikhroli (W), Mumbai - 400079','IN',5,'','','MAHARASHTRA',9,'B05',NULL,NULL),(6,'B006','Ludhiana','Sugal & Damani Utility Services Pvt. Ltd.','ludhiana@sugaldamani.com','9614956968','Sant Dass Street, Clock Tower, Ludhiana','IN',6,'','','PUNJAB',10,'B01',NULL,NULL),(7,'B007','KARNATAKA','Sugal','karnataka@sugaldamani.com','9670050396','No. 31/4, 1st floor,Vanivilasa Road,Opp Vasavi Convention Center, Near Metlife, Basavanagudi, Bangalore - 560004.','IN',7,'','','KARNATAKA',11,'B01',NULL,NULL),(8,'B008','Kolkata','Sugal & Damani Utility Services Pvt. Ltd.','kolkata@sugaldamani.com','9041735082','46A, Pandit Madan Mohan Malvia Sarani, Indra Prasth Building, Kolkata:-700020','IN',8,'','','WEST BENGAL',12,'B01',NULL,NULL),(9,'B009','Andaman AND Nicobar','Sugal & Damani Utility Services Pvt. Ltd.','andaman_and_nicobar@sugaldamani.com','9879830752','201, Green Wood Plaza, Green Wood City, Sector-45, Gurgaon-1122002','IN',9,'','','WEST BENGAL',12,'B02',NULL,NULL),(10,'B010','UTTAR PRADESH','Sugal & Damani Utility Services Pvt. Ltd.','uttar_pradesh@sugaldamani.com','9447619460','UTTAR PRADESH','IN',10,'','','UTTAR PRADESH',15,'B01',NULL,NULL),(11,'B011','AHMEDABAD','Sugal','ahmedabad@sugaldamani.com','9256642186','218, 4th Floor, Moon Light Complex, Drive in Road.Ahmedabad - 380054 Gujrat','IN',11,'','','GUJARAT',16,'B01',NULL,NULL),(12,'B012','Haryana','Sugal & Damani Utility Services Pvt. Ltd.','haryana@sugaldamani.com','9021178124','Haryana','IN',12,'','','HARYANA',17,'B01',NULL,NULL),(13,'B013','Rajasthan','Sugal & Damani Utility Services Pvt. Ltd.','rajasthan@sugaldamani.com','9657863970','Jaipur','IN',13,'','','RAJASTHAN',18,'B01',NULL,NULL),(14,'B014','RANCHI','Sugal','ranchi@sugaldamani.com','9774643422','Indraprastha Building, 46-A, Pandit  Madan, Mohan Malvia Sarani,  Chakrabaria Road (North) Kolkata - 700020','IN',14,'','','JHARKHAND',19,'B01',NULL,NULL),(15,'B015','Andhrapradesh','Sugal & Damani Utility Services Pvt. Ltd.','amravati@sugaldamani.com','9732216715','Amravati','IN',15,'','','ANDHRA PRADESH',22,'B01',NULL,NULL),(16,'B016','Hyderabad','Sugal & Damani Utility Services Pvt. Ltd.','hyderabad@sugaldamani.com','9743359339','Hyderabad','IN',16,'','','ANDHRA PRADESH',22,'B02',NULL,NULL),(17,'B017','INDORE','Sugal & Damani Utility Services Pvt. Ltd.','indore@sugaldamani.com','9628386306','INDORE','IN',17,'','','MADHYA PRADESH',25,'B01',NULL,NULL),(18,'B018','GUWAHATI','Sugal','guwahati@sugaldamani.com','9853040619','Indraprastha Building, 46-A, Pandit  Madan, Mohan Malvia Sarani,  Chakrabaria Road (North) Kolkata - 700020','IN',18,'','','ASSAM',26,'B01',NULL,NULL),(19,'B019','BHUBHNESHWAR','Sugal','bhubhneshwar@sugaldamani.com','9724560212','BHUBHNESHWAR','IN',19,'','','ORRISA',27,'B01',NULL,NULL),(20,'B020','SHIMLA','Sugal & Damani Utility Services Pvt. Ltd.','shimla@sugaldamani.com','9743001398','SHIMLA','IN',20,'','','HIMACHAL PRADESH',28,'B01',NULL,NULL),(21,'B021','RAIPUR','Sugal & Damani Utility Services Pvt. Ltd.','raipur@sugaldamani.com','9410474023','RAIPUR','IN',21,'','','CHATTISGARH',29,'B01',NULL,NULL),(22,'B022','NORTH EAST','Sugal & Damani Utility Services Pvt. Ltd.','north_east@sugaldamani.com','9870967444','NORTH EAST','IN',22,'','','NORTH EAST',30,'B01',NULL,NULL),(23,'B023','JAMMU','Sugal & Damani Utility Services Pvt. Ltd.','jammu@sugaldamani.com','9460759344','JAMMU','IN',23,'','','JAMMU AND KASHMIR',32,'B01',NULL,NULL),(24,'B024','KERALA','Sugal & Damani Utility Services Pvt. Ltd.','kerala@sugaldamani.com','9338308389','KERALA','IN',24,'','','KERALA',33,'B01',NULL,NULL),(25,'B025','BIHAR','Sugal & Damani Utility Services Pvt. Ltd.','bihar@sugaldamani.com','9441773122','BIHAR','IN',25,'','','BIHAR',34,'B01',NULL,NULL);
/*!40000 ALTER TABLE `st_payment_branch_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_branch_master_old`
--

DROP TABLE IF EXISTS `st_payment_branch_master_old`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_branch_master_old` (
  `branchid` int(3) NOT NULL AUTO_INCREMENT,
  `pw_state` char(100) NOT NULL,
  `pw_branch` char(3) NOT NULL,
  `branchname` char(50) DEFAULT NULL,
  PRIMARY KEY (`branchid`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_branch_master_old`
--

LOCK TABLES `st_payment_branch_master_old` WRITE;
/*!40000 ALTER TABLE `st_payment_branch_master_old` DISABLE KEYS */;
INSERT INTO `st_payment_branch_master_old` VALUES (1,'5','B01','Delhi/NCR'),(2,'7','B01','CHENNAI'),(3,'9','B01','MUMBAI'),(4,'9','B02','PUNE'),(5,'9','B05','NAGPUR'),(6,'10','B01','Ludhiana'),(7,'11','B01','KARNATAKA'),(8,'12','B01','Kolkata'),(9,'12','B02','Andaman AND Nicobar'),(10,'15','B01','UTTAR PRADESH'),(11,'16','B01','AHMEDABAD'),(12,'17','B01','Haryana'),(13,'18','B01','Rajasthan'),(14,'19','B01','RANCHI'),(15,'22','B01','Amravati'),(16,'24','B01','All India'),(17,'25','B01','INDORE'),(18,'26','B01','GUWAHATI'),(19,'27','B01','BHUBHNESHWAR'),(20,'28','B01','SHIMLA'),(21,'28','B02','LUDHIANA'),(22,'29','B01','RAIPUR'),(23,'30','B01','NORTH EAST'),(24,'32','B01','JAMMU'),(25,'33','B01','KERALA'),(26,'34','B01','BIHAR'),(27,'22','B02','Hyderabad');
/*!40000 ALTER TABLE `st_payment_branch_master_old` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_card_master`
--

DROP TABLE IF EXISTS `st_payment_card_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_card_master` (
  `serno` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `mode_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `card_type` varchar(50) NOT NULL DEFAULT '',
  `logo` varchar(50) NOT NULL DEFAULT '',
  `uiorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `status` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`serno`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_card_master`
--

LOCK TABLES `st_payment_card_master` WRITE;
/*!40000 ALTER TABLE `st_payment_card_master` DISABLE KEYS */;
INSERT INTO `st_payment_card_master` VALUES (1,6,'RUPAY','logo/rupay.png',3,'N'),(2,6,'VISA','logo/cdfvisa.jpg',2,'N'),(3,6,'MASTER','logo/master.jpg',1,'N'),(4,6,'MESTRO','logo/maestro.png',4,'N'),(5,7,'RUPAY','logo/rupay.png',1,'N'),(6,7,'VISA','logo/cdfvisa.jpg',2,'N'),(7,7,'MASTER','logo/master.jpg',3,'N'),(8,7,'MESTRO','logo/maestro.png',4,'N'),(9,7,'XYZ','logo/new.jpg',5,'Y');
/*!40000 ALTER TABLE `st_payment_card_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_db_master`
--

DROP TABLE IF EXISTS `st_payment_db_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_db_master` (
  `serno` int(2) NOT NULL AUTO_INCREMENT,
  `state` char(100) NOT NULL DEFAULT '',
  `brand` char(2) NOT NULL DEFAULT '',
  `acdb` char(20) NOT NULL DEFAULT '',
  `acdbip` char(20) NOT NULL DEFAULT '',
  `acdblogin` char(20) NOT NULL DEFAULT '',
  `acdbpassword` char(20) NOT NULL DEFAULT '',
  `pwdb` char(20) NOT NULL DEFAULT '',
  `pwdbip` char(20) NOT NULL DEFAULT '',
  `pwdblogin` char(20) NOT NULL DEFAULT '',
  `pwdbpassword` char(20) NOT NULL DEFAULT '',
  `pltablename` char(20) NOT NULL DEFAULT '',
  `status` int(1) NOT NULL DEFAULT '0',
  `entrydate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`serno`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_db_master`
--

LOCK TABLES `st_payment_db_master` WRITE;
/*!40000 ALTER TABLE `st_payment_db_master` DISABLE KEYS */;
INSERT INTO `st_payment_db_master` VALUES (5,'DELHI','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(7,'TAMILNADU','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(9,'MAHARASHTRA','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(10,'PUNJAB','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(11,'KARNATAKA','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(12,'WEST BENGAL','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(14,'ALL STATES','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',0,'0000-00-00 00:00:00'),(15,'UTTAR PRADESH','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(16,'GUJARAT','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(17,'HARYANA','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(18,'RAJASTHAN','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(19,'JHARKHAND','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(22,'ANDHRA PRADESH','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(23,'ORGANIZED RETAIL','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',2,'0000-00-00 00:00:00'),(24,'DIRECT SALE','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(25,'MADHYA PRADESH','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(26,'ASSAM','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(27,'ORRISA','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(28,'HIMACHAL PRADESH','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(29,'CHATTISGARH','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(30,'NORTH EAST','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(32,'JAMMU AND KASHMIR','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(33,'KERALA','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'0000-00-00 00:00:00'),(34,'BIHAR','PW','payworld2016','172.20.2.37','tender','tender','payworld2016','172.20.2.37','tender','tender','',1,'2010-12-14 14:58:19');
/*!40000 ALTER TABLE `st_payment_db_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_menu_master`
--

DROP TABLE IF EXISTS `st_payment_menu_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_menu_master` (
  `menucode` int(11) NOT NULL AUTO_INCREMENT,
  `menuname` varchar(50) NOT NULL DEFAULT '',
  `menuicon` varchar(30) NOT NULL DEFAULT 'fa fa-circle-o',
  `menuaction` varchar(100) NOT NULL DEFAULT '',
  `menuindex` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `parent` int(11) NOT NULL DEFAULT '0',
  `finyearaccess` enum('BOTH','CURRENT') NOT NULL DEFAULT 'CURRENT',
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `access` enum('HO','BOTH') DEFAULT 'HO',
  PRIMARY KEY (`menucode`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_menu_master`
--

LOCK TABLES `st_payment_menu_master` WRITE;
/*!40000 ALTER TABLE `st_payment_menu_master` DISABLE KEYS */;
INSERT INTO `st_payment_menu_master` VALUES (1,'Payment Time Limit','fa fa-clock-o','pwBoMaster/paymentTimeLimit',6,1,17,'BOTH','Y','HO'),(2,'Payment Mode','fa fa-money','pwBoMaster/paymentMode ',4,1,17,'BOTH','N','HO'),(3,'Map Payment Provider','fa fa-sitemap','pwBoMaster/mapPaymentProvider',8,1,17,'BOTH','Y','HO'),(4,'Payment Bank','fa fa-bank','pwBoMaster/addPaymentBank',1,1,17,'BOTH','Y','HO'),(5,'Payment Cards','fa fa-credit-card','pwBoMaster/addPaymnetCards',5,1,17,'BOTH','N','HO'),(6,'REQUEST-Add Account Number','fa  fa-cc-visa','pwBoMaster/addPaymentAccounts',2,1,17,'BOTH','Y','HO'),(7,'Payment Rate List','fa fa-inr','pwBoMaster/paymentRateList',4,1,17,'BOTH','Y','HO'),(8,'User','fa fa-user','',2,0,0,'BOTH','Y','HO'),(9,'Menu Access Rights','fa fa-universal-access','pwBoUser/updateMenuRights',4,1,8,'BOTH','Y','HO'),(10,'Create New User','fa fa-user-plus','pwBoUser/createNewUser',1,1,8,'BOTH','Y','HO'),(11,'Edit User Details','fa-edit (alias)','pwBoUser/editUserDetails',2,1,8,'BOTH','Y','HO'),(12,'Access Days & Time ','fa-calendar','pwBoUser/changeAccessTimeandday',3,1,8,'BOTH','Y','HO'),(13,'Branch Rights ','fa fa-home','pwBoUser/changeBranchRights',5,1,8,'BOTH','Y','HO'),(14,'Payment','fa fa-credit-card','',1,0,0,'BOTH','Y','BOTH'),(15,'Upload Bank Statement','fa fa-upload','pwBoPayment/uploadBankStatement',1,1,14,'BOTH','Y','BOTH'),(16,'Payment Request','fa fa-files-o','pwBoPayment/generateReceipt',2,1,14,'BOTH','Y','BOTH'),(17,'Master','fa fa-th','',3,0,0,'BOTH','Y','HO'),(18,'Agent Payment Authentication','fa fa-sign-in','pwBoPayment/agentPaymentAuthentication',3,1,14,'BOTH','Y','BOTH'),(19,'REQUEST-Account Branch Mapping','fa fa-sitemap','pwBoMaster/mapAccountBranch',3,1,17,'BOTH','Y','HO'),(20,'Retailer Payment Authentication','fa fa-sign-in','pwBoPayment/retailerPaymentAuthentication',4,1,14,'BOTH','Y','BOTH'),(21,'Offline Granting Access Rights','fa fa-exclamation-triangle','pwBoMaster/offlineGrantAccessRights',7,1,17,'BOTH','N','HO'),(22,'ECOLLECT-Add Account Number','fa fa-cc-visa','pwBoMaster/addEcollectPaymentAccounts',5,1,17,'BOTH','Y','HO');
/*!40000 ALTER TABLE `st_payment_menu_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_menu_rights`
--

DROP TABLE IF EXISTS `st_payment_menu_rights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_menu_rights` (
  `serno` int(11) NOT NULL AUTO_INCREMENT,
  `usercode` int(11) NOT NULL DEFAULT '0',
  `menucode` int(11) NOT NULL DEFAULT '0',
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`serno`)
) ENGINE=MyISAM AUTO_INCREMENT=200 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_menu_rights`
--

LOCK TABLES `st_payment_menu_rights` WRITE;
/*!40000 ALTER TABLE `st_payment_menu_rights` DISABLE KEYS */;
INSERT INTO `st_payment_menu_rights` VALUES (117,1,3,'Y'),(121,1,7,'Y'),(115,1,1,'Y'),(118,1,4,'Y'),(119,1,5,'Y'),(120,1,6,'Y'),(123,1,9,'Y'),(8,6,1,'Y'),(9,6,4,'Y'),(10,6,6,'Y'),(124,1,10,'Y'),(122,1,8,'Y'),(125,1,11,'Y'),(14,6,8,'Y'),(15,6,9,'Y'),(16,6,10,'Y'),(17,2,2,'N'),(18,2,3,'N'),(19,2,4,'N'),(20,2,5,'N'),(21,2,9,'Y'),(22,2,8,'Y'),(23,2,10,'Y'),(116,1,2,'Y'),(126,1,12,'Y'),(127,1,13,'Y'),(140,2,1,'N'),(141,2,11,'Y'),(142,2,12,'Y'),(143,2,13,'Y'),(144,2,6,'N'),(145,2,7,'N'),(146,6,12,'Y'),(147,6,3,'Y'),(148,8,8,'Y'),(149,8,9,'Y'),(150,8,12,'Y'),(151,6,2,'Y'),(152,8,5,'Y'),(153,6,5,'Y'),(154,6,7,'Y'),(155,6,11,'Y'),(156,6,13,'Y'),(157,1,14,'Y'),(158,3,1,'Y'),(159,3,2,'Y'),(160,3,3,'Y'),(161,3,4,'Y'),(162,3,5,'Y'),(163,3,6,'Y'),(164,3,7,'Y'),(165,3,8,'Y'),(166,3,9,'Y'),(167,3,10,'Y'),(168,3,11,'Y'),(169,3,12,'Y'),(170,3,13,'Y'),(171,3,14,'Y'),(172,2,14,'Y'),(173,1,15,'Y'),(174,1,16,'Y'),(175,2,15,'Y'),(176,2,16,'Y'),(177,8,1,'Y'),(178,8,2,'Y'),(179,8,3,'Y'),(180,8,4,'Y'),(181,8,6,'Y'),(182,8,7,'Y'),(183,8,10,'Y'),(184,8,11,'Y'),(185,8,13,'Y'),(186,8,14,'Y'),(187,8,15,'Y'),(188,8,16,'Y'),(189,1,17,'Y'),(190,2,17,'N'),(191,1,18,'Y'),(192,2,18,'Y'),(193,1,19,'Y'),(194,2,19,'N'),(195,1,20,'Y'),(196,2,20,'Y'),(197,1,21,'Y'),(198,2,21,'N'),(199,1,22,'Y');
/*!40000 ALTER TABLE `st_payment_menu_rights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_mode_master`
--

DROP TABLE IF EXISTS `st_payment_mode_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_mode_master` (
  `mode_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `type` enum('REQUEST','COLLECT','PAYMENT') NOT NULL DEFAULT 'REQUEST',
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `display_mode` enum('Y','N') NOT NULL DEFAULT 'Y',
  `branchlist` text,
  PRIMARY KEY (`mode_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_mode_master`
--

LOCK TABLES `st_payment_mode_master` WRITE;
/*!40000 ALTER TABLE `st_payment_mode_master` DISABLE KEYS */;
INSERT INTO `st_payment_mode_master` VALUES (1,'CashInOffice','REQUEST','Y','Y','1,3,5'),(2,'CashInBank','REQUEST','Y','Y','1,3,5,4'),(3,'Cheque','REQUEST','Y','Y','1,3,5'),(4,'NetBanking','REQUEST','Y','Y','1,3,5'),(5,'NetBanking','PAYMENT','Y','Y','1,3,5'),(6,'DebitCard','PAYMENT','Y','Y','1,3,5'),(7,'CreditCard','PAYMENT','Y','Y','1,3,5'),(8,'UPI','PAYMENT','Y','Y','1,3,5'),(9,'UPI','REQUEST','Y','Y','1,3,5'),(10,'Ecollect','COLLECT','Y','Y','1,3,5');
/*!40000 ALTER TABLE `st_payment_mode_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_payment_request`
--

DROP TABLE IF EXISTS `st_payment_payment_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_payment_request` (
  `serno` bigint(20) NOT NULL AUTO_INCREMENT,
  `dateval` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `branch_id` char(3) NOT NULL DEFAULT '',
  `brand` char(2) NOT NULL DEFAULT '',
  `countercode` char(20) NOT NULL DEFAULT '',
  `counter_agentcode` char(20) NOT NULL DEFAULT '',
  `dstbtr_code` char(20) NOT NULL DEFAULT '',
  `chequeno` char(10) DEFAULT NULL,
  `chequedate` date DEFAULT NULL,
  `bankid` int(11) DEFAULT NULL,
  `mode_id` smallint(5) unsigned NOT NULL,
  `narration` text NOT NULL,
  `requested_panel` enum('APOS','WEBPOS','API','MPOS','BOPOS','PAYLITE') DEFAULT NULL,
  `request_usercode` varchar(10) NOT NULL DEFAULT '',
  `request_username` char(30) NOT NULL DEFAULT '',
  `auth_usercode` varchar(10) DEFAULT '',
  `auth_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `grant_usercode` varchar(10) DEFAULT '',
  `grant_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `revoke_usercode` varchar(10) DEFAULT '',
  `revoke_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Remarks` varchar(200) DEFAULT '',
  `status` enum('AUTHENTICATED','GRANTED','REVOKED','PENDING') DEFAULT 'PENDING',
  `deposit_date` date DEFAULT '0000-00-00',
  `bank_account_no` char(30) DEFAULT NULL,
  `receipt_url` text,
  `request_for` enum('AGENT','RETAILER','API') DEFAULT NULL,
  `amount` double NOT NULL,
  `transaction_no` char(30) DEFAULT NULL,
  `statement_no` int(11) DEFAULT NULL,
  `deposit_branch_code` varchar(50) DEFAULT NULL,
  `cheque_bank_name` varchar(100) DEFAULT NULL,
  `bank_ref_number` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`serno`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_payment_request`
--

LOCK TABLES `st_payment_payment_request` WRITE;
/*!40000 ALTER TABLE `st_payment_payment_request` DISABLE KEYS */;
INSERT INTO `st_payment_payment_request` VALUES (1,'2018-01-09 17:45:00','1','PW','5da07','Agent','','','0000-00-00',1,2,'Test remarks 62000','BOPOS','1','su','','0000-00-00 00:00:00','1','2018-01-10 09:38:44','','0000-00-00 00:00:00','','GRANTED','2017-12-29','915020041501989','/webroot/payment_request_receipt/09012018174500Screenshot from 2018-01-03 15-05-06.png','AGENT',62000,'1',0,'AXIB90','',NULL),(2,'2018-01-09 17:49:34','1','PW','5da07','Agent','','CHQ234','2018-01-02',1,3,'Test','BOPOS','1','su','2','2018-01-10 10:50:33','1','2018-01-13 14:47:04','','0000-00-00 00:00:00','','GRANTED','2017-12-29','915020041501989','','AGENT',5010,'2',3,'HDFC009','HDFC',NULL),(3,'2018-01-10 10:42:49','1','PW','5da07','Agent','','SDF567','2018-01-02',1,3,'Test remarks 1000','BOPOS','1','su','2','2018-01-10 10:46:19','','0000-00-00 00:00:00','1','2018-01-10 10:49:00','','REVOKED','2017-12-29','915020041501989','/webroot/payment_request_receipt/10012018104249image.png','AGENT',1000,NULL,0,'AXIB987','HDFC',''),(4,'2018-01-10 11:08:36','1','PW','5da07','Agent','','','0000-00-00',NULL,1,'test','BOPOS','1','su','2','2018-01-24 10:03:58','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','AUTHENTICATED','2018-01-10','','','AGENT',45200,NULL,0,'','',''),(5,'2018-01-10 12:01:00','1','PW','5da07','Agent','','','0000-00-00',1,2,'dfsdf','BOPOS','1','su','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2017-12-29','915020041501989','','AGENT',10,NULL,NULL,'sdas','',''),(6,'2018-01-10 12:01:50','1','PW','5da07','Agent','','','0000-00-00',2,2,'01010','BOPOS','1','su','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-03','342000039163','','AGENT',10,NULL,NULL,'101','',''),(7,'2018-01-10 12:04:15','1','PW','5da07','Agent','','','0000-00-00',2,2,'1010','BOPOS','1','su','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-03','1042000012629','','AGENT',10,NULL,NULL,'1010','',''),(8,'2018-01-10 12:07:13','1','PW','5da07','Agent','','','0000-00-00',1,2,'sdfsd','BOPOS','1','su','','0000-00-00 00:00:00','1','2018-01-15 16:42:04','','0000-00-00 00:00:00','','GRANTED','2018-01-09','915020041501989','','AGENT',34,'3',0,'sdfsd','',''),(9,'2018-01-10 12:13:26','1','PW','5da07','Agent','','','0000-00-00',2,2,'12','BOPOS','1','su','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-03','1182000011629','/webroot/payment_request_receipt/10012018121326PW-Cash-DT-02.jpg','AGENT',12,NULL,NULL,'12','',''),(10,'2018-01-10 13:33:55','1','PW','5da07','Agent','','','0000-00-00',1,2,'test','BOPOS','1','su','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-09','915020041501989','','AGENT',14500,NULL,NULL,'4ioi','',''),(11,'2018-01-10 15:05:22','1','PW','5da07','Agent','','','0000-00-00',1,2,'sdfsdf','BOPOS','1','su','','0000-00-00 00:00:00','1','2018-01-16 10:33:06','','0000-00-00 00:00:00','','GRANTED','2018-01-09','915020041501989','','AGENT',123445,'8',0,'3456','',''),(12,'2018-01-10 15:16:52','1','PW','5da07','Agent','','','0000-00-00',1,2,'nhjghjgh','BOPOS','1','su','2','2018-01-24 10:00:04','1','2018-01-24 18:04:16','','0000-00-00 00:00:00','','GRANTED','2018-01-09','915020041501989','','AGENT',45000,'9',0,'456','',''),(13,'2018-01-10 15:23:13','1','PW','5da07','Agent','','','0000-00-00',1,2,'Test','BOPOS','1','su','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-09','915020041501989','','AGENT',45000,NULL,NULL,'LOP09','',''),(14,'2018-01-10 15:24:15','1','PW','5da07','Agent','','','0000-00-00',1,2,'test','BOPOS','1','su','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-08','915020041501989','','AGENT',47800,NULL,NULL,'JKU87','',''),(15,'2018-01-10 15:25:08','1','PW','5da07','Agent','','','0000-00-00',1,2,'test','BOPOS','1','su','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-09','915020041501989','','AGENT',7822,NULL,NULL,'asdfasdf','',''),(16,'2018-01-10 15:27:10','1','PW','5da07','Agent','','','0000-00-00',1,2,'sdfsd','BOPOS','1','su','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-08','915020041501989','','AGENT',78000,NULL,NULL,'fr','',''),(17,'2018-01-10 16:00:37','1','PW','510571','5da07','','','0000-00-00',1,2,'sdfsdf','BOPOS','1','su','','0000-00-00 00:00:00','1','2018-01-15 16:51:05','','0000-00-00 00:00:00','','GRANTED','2018-01-01','915020041501989','','RETAILER',458100,'4',0,'sdfs','',''),(18,'2018-01-10 16:02:35','1','PW','5da07','Agent','','','0000-00-00',1,2,'123','BOPOS','1','su','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-09','915020041501989','','AGENT',45000,NULL,NULL,'458','',''),(19,'2018-01-10 16:44:43','1','PW','5da07','Agent','','','0000-00-00',1,2,'Test remarks','BOPOS','1','su','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-03','915020041501989','','AGENT',45000,NULL,NULL,'BH89','',''),(20,'2018-01-10 16:46:13','1','PW','5da07','Agent','','','0000-00-00',1,2,'Test','BOPOS','1','su','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-08','915020041501989','','AGENT',12500,NULL,NULL,'ML09','',''),(21,'2018-01-10 16:55:24','1','PW','510571','5da07','','','0000-00-00',1,2,'test','BOPOS','1','su','','0000-00-00 00:00:00','1','2018-01-15 16:54:11','','0000-00-00 00:00:00','','GRANTED','2018-01-01','915020041501989','','RETAILER',78000,'5',0,'LK09','',''),(22,'2018-01-10 16:56:33','1','PW','5da07','Agent','','CHQ876','2018-01-08',1,3,'Test','BOPOS','1','su','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-01','915020041501989','','AGENT',45000,NULL,NULL,'MK87','HDFC',''),(23,'2018-01-10 18:23:04','1','PW','5da07','Agent','','','0000-00-00',1,5,'Test','BOPOS','1','su','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','GRANTED','2018-01-09','915020041501989','','AGENT',678,NULL,NULL,'ABH987','',''),(24,'2018-01-11 11:38:23','1','PW','5da07','Agent','','','0000-00-00',2,2,'sdfsd','BOPOS','1','su','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-02','1042000012629','','AGENT',788888,NULL,NULL,'dsgfsd','',''),(25,'2018-01-13 14:59:34','1','PW','5da07','Agent','','','0000-00-00',1,2,'Test','BOPOS','2','prateek','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2017-12-29','915020041501989','','AGENT',62000,NULL,NULL,'AXIB','',''),(26,'2018-01-15 16:56:53','1','PW','510571','5da07','','CHG789','0000-00-00',1,3,'Test','BOPOS','1','su','','0000-00-00 00:00:00','1','2018-01-15 16:58:42','','0000-00-00 00:00:00','','GRANTED','2017-12-29','915020041501989','','RETAILER',45130,'6',0,'AVIbh','HDFC',''),(27,'2018-01-15 17:12:15','1','PW','510571','5da07','','','0000-00-00',1,4,'TEST','BOPOS','1','su','','0000-00-00 00:00:00','1','2018-01-15 17:12:53','','0000-00-00 00:00:00','','GRANTED','2018-01-05','915020041501989','','RETAILER',14500,'7',0,'DERF','','REF'),(28,'2018-01-23 11:12:47','1','PW','5da07','Agent','',NULL,NULL,1,2,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-23','915020041501989','30','AGENT',12,NULL,NULL,'121212',NULL,NULL),(29,'2018-01-23 11:18:54','1','PW','5da07','Agent','',NULL,NULL,1,2,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-20','915020042140691','','AGENT',11,NULL,NULL,'1451',NULL,NULL),(30,'2018-01-23 12:22:29','1','PW','5da07','Agent','','123','2018-01-16',4,3,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-23','678676767676767','31','AGENT',200,NULL,NULL,'qwqw','test a',NULL),(31,'2018-01-23 12:36:52','1','PW','5da07','Agent','','454541','2018-01-23',6,3,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-23','60091943962','','AGENT',11,NULL,NULL,'345345','sdfsdfsdf',NULL),(32,'2018-01-23 12:53:41','1','PW','5da07','Agent','',NULL,NULL,1,2,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-23','915020041501989','','AGENT',1,NULL,NULL,'11',NULL,NULL),(33,'2018-01-23 12:58:00','1','PW','5da07','Agent','',NULL,NULL,4,2,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-23','678676767676767','','AGENT',12,NULL,NULL,'21',NULL,NULL),(34,'2018-01-23 12:59:54','1','PW','5da07','Agent','',NULL,NULL,1,2,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-23','915020040731963','','AGENT',11,NULL,NULL,'121',NULL,NULL),(35,'2018-01-23 13:03:37','1','PW','5da07','Agent','',NULL,NULL,1,2,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-23','915020041501989','','AGENT',12,NULL,NULL,'12121',NULL,NULL),(36,'2018-01-23 13:07:26','1','PW','5da07','Agent','',NULL,NULL,1,2,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-23','915020040731963','','AGENT',3,NULL,NULL,'34',NULL,NULL),(37,'2018-01-23 14:29:06','1','PW','5da07','Agent','',NULL,NULL,4,2,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-23','898989898989','','AGENT',12,NULL,NULL,'12',NULL,NULL),(38,'2018-01-23 15:02:05','1','PW','5da07','Agent','',NULL,NULL,4,2,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-23','678676767676767','','AGENT',12,NULL,NULL,'12',NULL,NULL),(39,'2018-01-23 15:10:51','1','PW','5da07','Agent','',NULL,NULL,4,2,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-23','678676767676767','','AGENT',12,NULL,NULL,'121',NULL,NULL),(40,'2018-01-23 15:14:16','1','PW','5da07','Agent','','1212','2018-01-23',1,3,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-23','915020041501989','','AGENT',12,NULL,NULL,'df','sdfsdf',NULL),(41,'2018-01-23 15:24:14','1','PW','5da07','Agent','',NULL,NULL,4,2,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-23','898989898989','','AGENT',12,NULL,NULL,'121',NULL,NULL),(42,'2018-01-23 15:27:34','1','PW','5da07','Agent','','121212','2018-01-23',1,3,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-23','915020041501989','','AGENT',12,NULL,NULL,'rwer','sasd',NULL),(43,'2018-01-23 15:38:20','1','PW','5da07','Agent','','1212','2018-01-23',1,3,'TEST API','APOS','5da07','hemant','2','2018-01-24 10:04:35','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','AUTHENTICATED','2018-01-23','915020041501989','32','AGENT',12,NULL,0,'2312','drwer',NULL),(44,'2018-01-23 15:41:19','1','PW','5da07','Agent','','12312','2018-01-23',1,3,'TEST API','APOS','5da07','hemant','2','2018-01-24 10:04:20','','0000-00-00 00:00:00','1','2018-01-24 18:09:40','','REVOKED','2018-01-23','915020041501989','','AGENT',12,NULL,0,'123','asdasd',NULL),(45,'2018-01-23 15:49:44','1','PW','5da07','Agent','',NULL,NULL,4,2,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-23','898989898989','','AGENT',12,NULL,NULL,'121',NULL,NULL),(46,'2018-01-23 15:51:08','1','PW','5da07','Agent','',NULL,NULL,4,2,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-23','678676767676767','','AGENT',12,NULL,NULL,'121',NULL,NULL),(47,'2018-01-23 17:23:24','1','PW','5da07','Agent','',NULL,NULL,4,4,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-23','678676767676767','','AGENT',12,NULL,NULL,'12',NULL,'121212'),(48,'2018-01-24 13:02:39','1','PW','5da07','Agent','',NULL,NULL,4,4,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-24','898989898989','','AGENT',12,NULL,NULL,'12',NULL,'waweqw'),(49,'2018-01-25 16:49:51','1','PW','5da07','Agent','','12121','2018-01-25',6,3,'TEST API','APOS','5da07','hemant','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','PENDING','2018-01-25','60091943962','','AGENT',12,NULL,NULL,'','weasd',NULL),(50,'2018-01-31 09:58:02','1','PW','5da07','Agent','','122','2018-01-31',6,3,'TEST API','APOS','5da07','hemant','2','2018-01-31 10:01:44','','0000-00-00 00:00:00','','0000-00-00 00:00:00','','AUTHENTICATED','2018-01-31','60091943962','34','AGENT',12,NULL,0,'1212','asdasa',NULL);
/*!40000 ALTER TABLE `st_payment_payment_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_payreq_time_limit`
--

DROP TABLE IF EXISTS `st_payment_payreq_time_limit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_payreq_time_limit` (
  `mode_id` int(10) unsigned NOT NULL DEFAULT '0',
  `time_slot` char(200) NOT NULL DEFAULT '',
  `branchid` varchar(10) NOT NULL DEFAULT '',
  `entrydate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_payreq_time_limit`
--

LOCK TABLES `st_payment_payreq_time_limit` WRITE;
/*!40000 ALTER TABLE `st_payment_payreq_time_limit` DISABLE KEYS */;
INSERT INTO `st_payment_payreq_time_limit` VALUES (1,'0@16-18','1','2018-01-19 16:01:50'),(2,'5@15-19','1','2018-01-19 16:01:50'),(1,'0@16-18','2','2018-01-17 17:51:01'),(2,'','2','2018-01-17 17:51:01'),(3,'5@15-19','1','2018-01-19 16:01:50'),(1,'0@3-12','8','2018-01-16 18:28:12'),(4,'','1','2018-01-19 16:01:49'),(9,'','1','2018-01-19 16:01:50'),(1,'2@2-6','6','2018-01-17 10:33:23');
/*!40000 ALTER TABLE `st_payment_payreq_time_limit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_provider_master`
--

DROP TABLE IF EXISTS `st_payment_provider_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_provider_master` (
  `provider_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `type` enum('REQUEST','COLLECT','PAYMENT') NOT NULL,
  PRIMARY KEY (`provider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_provider_master`
--

LOCK TABLES `st_payment_provider_master` WRITE;
/*!40000 ALTER TABLE `st_payment_provider_master` DISABLE KEYS */;
INSERT INTO `st_payment_provider_master` VALUES (1,'PwOffice','Y','REQUEST'),(2,'PwBank','Y','REQUEST'),(3,'PayU','Y','PAYMENT'),(4,'EBS','Y','PAYMENT'),(5,'TPSL','Y','PAYMENT'),(6,'PwEcollect','Y','COLLECT'),(7,'Paytm','Y','PAYMENT');
/*!40000 ALTER TABLE `st_payment_provider_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_provider_mode_map`
--

DROP TABLE IF EXISTS `st_payment_provider_mode_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_provider_mode_map` (
  `serno` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mode_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `provider_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `branchid` varchar(10) NOT NULL DEFAULT '',
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`serno`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_provider_mode_map`
--

LOCK TABLES `st_payment_provider_mode_map` WRITE;
/*!40000 ALTER TABLE `st_payment_provider_mode_map` DISABLE KEYS */;
INSERT INTO `st_payment_provider_mode_map` VALUES (1,1,1,'1','Y'),(2,1,1,'2','Y'),(3,1,1,'3','Y'),(4,1,1,'4','Y'),(5,1,1,'5','Y'),(6,1,1,'6','Y'),(7,1,1,'7','Y'),(8,1,1,'8','Y'),(9,1,1,'9','Y'),(10,1,1,'10','Y'),(11,1,1,'11','Y'),(12,1,1,'12','Y'),(13,1,1,'13','Y'),(14,1,1,'14','Y'),(15,1,1,'15','Y'),(16,1,1,'16','Y'),(17,1,1,'17','Y'),(18,1,1,'18','Y'),(19,1,1,'19','Y'),(20,1,1,'20','Y'),(21,1,1,'21','Y'),(22,1,1,'22','Y'),(23,1,1,'23','Y'),(24,1,1,'24','Y'),(25,1,1,'25','Y'),(26,4,2,'1','Y'),(27,4,2,'2','Y'),(28,4,2,'3','Y'),(29,4,2,'4','Y'),(30,4,2,'5','Y'),(31,4,2,'6','Y'),(32,4,2,'7','Y'),(33,4,2,'8','Y'),(34,4,2,'9','Y'),(35,4,2,'10','Y'),(36,4,2,'11','Y'),(37,4,2,'12','Y'),(38,4,2,'13','Y'),(39,4,2,'14','Y'),(40,4,2,'15','Y'),(41,4,2,'16','Y'),(42,4,2,'17','Y'),(43,4,2,'18','Y'),(44,4,2,'19','Y'),(45,4,2,'20','Y'),(46,4,2,'21','Y'),(47,4,2,'22','Y'),(48,4,2,'23','Y'),(49,4,2,'24','Y'),(50,4,2,'25','Y'),(51,9,2,'1','Y'),(52,9,2,'2','Y'),(53,9,2,'3','Y'),(54,9,2,'4','Y'),(55,9,2,'5','Y'),(56,9,2,'6','Y'),(57,9,2,'7','Y'),(58,9,2,'8','Y'),(59,9,2,'9','Y'),(60,9,2,'10','Y'),(61,9,2,'11','Y'),(62,9,2,'12','Y'),(63,9,2,'13','Y'),(64,9,2,'14','Y'),(65,9,2,'15','Y'),(66,9,2,'16','Y'),(67,9,2,'17','Y'),(68,9,2,'18','Y'),(69,9,2,'19','Y'),(70,9,2,'20','Y'),(71,9,2,'21','Y'),(72,9,2,'22','Y'),(73,9,2,'23','Y'),(74,9,2,'24','Y'),(75,9,2,'25','Y'),(76,2,2,'1','N'),(77,3,2,'1','Y'),(78,5,3,'1','Y'),(79,5,4,'1','Y'),(80,5,5,'1','Y'),(81,5,7,'1','Y');
/*!40000 ALTER TABLE `st_payment_provider_mode_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_rate_list`
--

DROP TABLE IF EXISTS `st_payment_rate_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_rate_list` (
  `serno` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mode_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ratedate` date DEFAULT '0000-00-00',
  `provider_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `bank_id` int(10) unsigned DEFAULT NULL,
  `account_no` varchar(25) DEFAULT '',
  `minslabamt` double NOT NULL DEFAULT '0',
  `maxslabamt` double NOT NULL DEFAULT '0',
  `amount` float unsigned NOT NULL DEFAULT '0',
  `gst` enum('Inclusive','Exclusive') NOT NULL DEFAULT 'Inclusive',
  `ratemode` enum('Amount','Percentage') NOT NULL DEFAULT 'Amount',
  `entrydate` datetime DEFAULT '0000-00-00 00:00:00',
  `app_type` enum('Agent','Retailer','Distributor') NOT NULL,
  PRIMARY KEY (`serno`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_rate_list`
--

LOCK TABLES `st_payment_rate_list` WRITE;
/*!40000 ALTER TABLE `st_payment_rate_list` DISABLE KEYS */;
INSERT INTO `st_payment_rate_list` VALUES (1,10,'2018-01-09',6,60,'',1000,2000,2,'Inclusive','Amount','2018-01-09 16:28:37','Agent'),(2,10,'2018-01-09',6,60,'',2100,2500,10,'Inclusive','Amount','2018-01-09 16:54:12','Agent'),(3,10,'2018-01-09',6,60,'',100,500,20,'Inclusive','Amount','2018-01-09 17:18:48','Agent'),(4,10,'2018-01-09',6,60,'',10,50,10,'Inclusive','Amount','2018-01-09 17:29:06','Agent'),(5,10,'2018-01-09',6,60,'',2010,2090,56,'Inclusive','Amount','2018-01-09 17:30:26','Agent'),(6,1,'2018-01-11',1,NULL,'',100,5000,10,'Inclusive','Amount','2018-01-10 11:01:38','Agent');
/*!40000 ALTER TABLE `st_payment_rate_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_transactions`
--

DROP TABLE IF EXISTS `st_payment_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_transactions` (
  `transaction_no` bigint(30) NOT NULL AUTO_INCREMENT,
  `snd_transno` char(30) NOT NULL,
  `transaction_date` date NOT NULL DEFAULT '0000-00-00',
  `mode_id` char(3) NOT NULL DEFAULT '',
  `provider_id` char(3) NOT NULL DEFAULT '',
  `branch_id` char(3) NOT NULL DEFAULT '',
  `countercode` char(20) NOT NULL DEFAULT '',
  `counter_agentcode` char(20) NOT NULL DEFAULT '',
  `dstbtr_code` char(20) NOT NULL DEFAULT '',
  `requested_panel` enum('APOS','WEBPOS','API','MPOS','BOPOS','PAYLITE') DEFAULT NULL,
  `request_for` enum('AGENT','RETAILER','API') DEFAULT NULL,
  `transaction_amount` double DEFAULT NULL,
  `charge_amount` double DEFAULT NULL,
  `gst_amount` double NOT NULL,
  `commission_amount` double DEFAULT NULL,
  `tds_amount` double DEFAULT NULL,
  `remarks` text,
  `bankid` int(11) DEFAULT NULL,
  `bank_account_no` char(30) DEFAULT NULL,
  `bank_ref_number` varchar(30) DEFAULT NULL,
  `cheque_date` date DEFAULT '0000-00-00',
  `deposit_date` date DEFAULT '0000-00-00',
  `narration` text NOT NULL,
  `dateval` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `transaction_mode` enum('CREDIT','DEBIT') DEFAULT NULL,
  `response_flag` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`transaction_no`),
  UNIQUE KEY `transaction_no` (`transaction_no`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_transactions`
--

LOCK TABLES `st_payment_transactions` WRITE;
/*!40000 ALTER TABLE `st_payment_transactions` DISABLE KEYS */;
INSERT INTO `st_payment_transactions` VALUES (1,'TEST!@#$','2018-01-10','2','2','1','','Agent','','BOPOS','AGENT',NULL,NULL,0,NULL,NULL,NULL,1,'915020041501989','','0000-00-00','2017-12-29','Test remarks 62000','2018-01-10 09:38:43','CREDIT','N'),(2,'TEST!@#$','2018-01-13','3','2','1','5da07','Agent','','BOPOS','AGENT',5010,0,0,0,0,'',1,'915020041501989','CHQ234 ','2018-01-02','2017-12-29','Test','2018-01-13 14:47:04','CREDIT','N'),(3,'TEST!@#$','2018-01-15','2','2','1','5da07','Agent','','BOPOS','AGENT',NULL,NULL,0,NULL,NULL,NULL,1,'915020041501989',' ','0000-00-00','2018-01-09','sdfsd','2018-01-15 16:42:04','CREDIT','N'),(4,'TEST!@#$','2018-01-15','2','2','1','510571','5da07','','BOPOS','RETAILER',NULL,NULL,0,NULL,NULL,NULL,1,'915020041501989',' ','0000-00-00','2018-01-01','sdfsdf','2018-01-15 16:51:05','CREDIT','N'),(5,'TEST!@#$','2018-01-15','2','2','1','510571','5da07','','BOPOS','RETAILER',NULL,NULL,0,NULL,NULL,NULL,1,'915020041501989',' ','0000-00-00','2018-01-01','test','2018-01-15 16:54:11','CREDIT','N'),(6,'TEST!@#$','2018-01-15','3','2','1','510571','5da07','','BOPOS','RETAILER',NULL,NULL,0,NULL,NULL,NULL,1,'915020041501989','CHG789 ','0000-00-00','2017-12-29','Test','2018-01-15 16:58:42','CREDIT','N'),(7,'TEST!@#$','2018-01-15','4','2','1','510571','5da07','','BOPOS','RETAILER',NULL,NULL,0,NULL,NULL,NULL,1,'915020041501989',' REF','0000-00-00','2018-01-05','TEST','2018-01-15 17:12:53','CREDIT','N'),(8,'TEST!@#$','2018-01-16','2','2','1','5da07','Agent','','BOPOS','AGENT',NULL,NULL,0,NULL,NULL,NULL,1,'915020041501989',' ','0000-00-00','2018-01-09','sdfsdf','2018-01-16 10:33:06','CREDIT','N'),(9,'TEST!@#$','2018-01-24','2','2','1','5da07','Agent','','BOPOS','AGENT',NULL,NULL,0,NULL,NULL,NULL,1,'915020041501989',' ','0000-00-00','2018-01-09','nhjghjgh','2018-01-24 18:04:16','CREDIT','N');
/*!40000 ALTER TABLE `st_payment_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `st_payment_user_master`
--

DROP TABLE IF EXISTS `st_payment_user_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `st_payment_user_master` (
  `usercode` int(11) NOT NULL AUTO_INCREMENT,
  `loginname` char(20) DEFAULT NULL,
  `password` char(40) NOT NULL DEFAULT '',
  `db_branch` text NOT NULL,
  `name` char(50) DEFAULT '',
  `ph` char(20) NOT NULL DEFAULT '',
  `pwdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pwdate_byuser` int(11) NOT NULL DEFAULT '0',
  `stime` time NOT NULL DEFAULT '00:00:01',
  `etime` time NOT NULL DEFAULT '23:59:59',
  `accessdays` char(15) DEFAULT '',
  `creationdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `db_group` text,
  `session_id` varchar(255) DEFAULT NULL,
  `loggedin` datetime DEFAULT '0000-00-00 00:00:00',
  `noofattempt` int(2) NOT NULL DEFAULT '0',
  `email` char(100) DEFAULT '',
  `block` char(1) DEFAULT '',
  `block_date` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`usercode`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `st_payment_user_master`
--

LOCK TABLES `st_payment_user_master` WRITE;
/*!40000 ALTER TABLE `st_payment_user_master` DISABLE KEYS */;
INSERT INTO `st_payment_user_master` VALUES (1,'su','202CB962AC59075B964B07152D234B70','0:HO','Administrator','8285503177','2017-12-12 10:48:13',0,'00:00:00','23:59:59','0,1,2,3,4,5,6','2015-04-14 00:00:00','0','','2018-02-14 14:52:23',0,'aad@gmail.com','N','2017-06-19 12:16:12'),(2,'prateek','202CB962AC59075B964B07152D234B70','5:B01#7:B01#9:B01@B02#10:B01#11:B01#12:B01@B02','Prateek','7777777777','2017-12-12 10:48:13',0,'00:00:00','23:59:59','0,1,2,3,4,5,6','2015-04-14 00:00:00','5:7:9:10:11:12','','2018-01-31 10:00:59',0,'s.hdf.gfd@gmail.com','N','2017-07-03 10:25:30'),(3,'neeraj','202CB962AC59075B964B07152D234B70','5:B01#7:B01#10:B01','neeraj kumar','9999999999','2017-12-12 10:48:13',0,'00:00:00','23:59:59','0,1,2,3,4,5,6','2015-09-07 14:06:58','5:7:10','','2017-12-18 11:15:07',0,'neeraj@gmail.com','N','2017-06-22 14:50:46'),(17,'asdasd','E9510081AC30FFA83F10B68CDE1CAC07','HO','dfgdfgdfg','8888888888','2017-12-12 10:48:13',0,'00:00:00','23:59:59','0,3,6','2017-12-12 17:38:18','0',NULL,'0000-00-00 00:00:00',0,'','N','0000-00-00 00:00:00'),(5,'yumi','202CB962AC59075B964B07152D234B70','12:B01@B02','yumika','1234567890','2017-12-12 10:48:13',0,'11:03:03','11:03:03','0,1,2,3,4,5,6','2015-11-21 11:04:59','12 ','','2017-11-02 12:47:30',0,'yumika@YAHOO.COM','N','2017-06-22 14:56:34'),(4,'taruna','202CB962AC59075B964B07152D234B70','5:B01#7:B01#9:B01@B02','gupta','9540573440','2017-12-12 10:48:13',0,'00:00:00','23:59:59','0,1,2,3','2015-11-21 11:03:03','5:7:9','','2017-11-23 18:35:15',0,'taruna.gupta@sugaldamani.com','N','0000-00-00 00:00:00'),(15,'sadasd232','149815EB972B3C370DEE3B89D645AE14','HO','asdasd','9999999999','2017-12-12 10:48:13',0,'00:00:00','23:59:59','','2017-12-12 17:32:44','0',NULL,'0000-00-00 00:00:00',0,'','N','0000-00-00 00:00:00'),(16,'dsfsdf','81DC9BDB52D04DC20036DBD8313ED055','HO','sdfgdfg','8966666666','2017-12-12 10:48:13',0,'00:00:00','23:59:59','','2017-12-12 17:37:40','0',NULL,'0000-00-00 00:00:00',0,'dfsd@fdf.com','N','0000-00-00 00:00:00'),(6,'shubham','202CB962AC59075B964B07152D234B70',':HO','Administator','1234567890','2017-12-12 10:48:13',0,'00:00:00','23:59:59','0,1,2,3,4,5,6','2015-04-14 00:00:00','0','','2017-12-15 15:08:42',0,'shubham@gmail.com','N','0000-00-00 00:00:00'),(18,'asdasdasd123','202CB962AC59075B964B07152D234B70','','sdfsdfsdf','8888888888','2017-12-14 12:48:50',0,'00:00:00','23:59:59','','2017-12-14 12:48:50',NULL,NULL,'0000-00-00 00:00:00',0,'ghgf@dfd.com','N','0000-00-00 00:00:00'),(7,'vinay','202CB962AC59075B964B07152D234B70',':HO','Vinay Kumar','9015969877','2017-12-12 10:48:13',0,'00:00:00','23:59:59','0,1,2,3,4,5,6','2017-03-14 16:36:10','0','','2017-12-07 14:47:48',0,'vinay.kumar@sugaldamani.com','N','2017-06-30 15:58:28'),(8,'ankan','202CB962AC59075B964B07152D234B70','5:B01#7:B01#9:B01@B02@B05','ankan vermaaaaa','9999999999','2017-12-12 10:48:13',0,'00:00:00','23:59:59','0,1,2,3,4,5,6','2017-12-12 10:48:13','5:7:9',NULL,'2017-12-20 11:59:01',0,'dfgsdfsdfsdf@dfdf.com','N','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `st_payment_user_master` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-19 17:01:39
