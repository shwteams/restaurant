-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: restorant_db
-- ------------------------------------------------------
-- Server version	5.6.17

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
-- Table structure for table `t_bill`
--

DROP TABLE IF EXISTS `t_bill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_bill` (
  `lg_BILL_ID` varchar(20) NOT NULL,
  `dt_DATE` datetime DEFAULT NULL,
  `str_STATUS` varchar(20) DEFAULT NULL,
  `dt_CREATED` datetime DEFAULT NULL,
  `str_CREATED_BY` varchar(20) DEFAULT NULL,
  `dt_UPDATED` datetime DEFAULT NULL,
  `str_UPDATED_BY` varchar(20) DEFAULT NULL,
  `lg_COMMAND_ID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`lg_BILL_ID`),
  KEY `lg_COMMAND_ID` (`lg_COMMAND_ID`),
  CONSTRAINT `t_bill_fk1` FOREIGN KEY (`lg_COMMAND_ID`) REFERENCES `t_command` (`lg_COMMAND_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_bill`
--

LOCK TABLES `t_bill` WRITE;
/*!40000 ALTER TABLE `t_bill` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_bill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_canalnotification`
--

DROP TABLE IF EXISTS `t_canalnotification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_canalnotification` (
  `lg_CANALNOTIFICATION_ID` varchar(40) NOT NULL,
  `str_NAME` varchar(100) DEFAULT NULL,
  `str_DESCRIPTION` varchar(100) DEFAULT NULL,
  `dt_CREATED` datetime DEFAULT NULL,
  `dt_UPDATED` datetime DEFAULT NULL,
  `str_STATUT` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`lg_CANALNOTIFICATION_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_canalnotification`
--

LOCK TABLES `t_canalnotification` WRITE;
/*!40000 ALTER TABLE `t_canalnotification` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_canalnotification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_command`
--

DROP TABLE IF EXISTS `t_command`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_command` (
  `lg_COMMAND_ID` varchar(20) NOT NULL,
  `dt_DATE` datetime DEFAULT NULL,
  `int_NUMBER_DISH` int(11) DEFAULT '1',
  `str_STATUS` varchar(20) DEFAULT NULL,
  `dt_CREATED` datetime DEFAULT NULL,
  `str_CREATED_BY` varchar(20) DEFAULT NULL,
  `dt_UPDATED` datetime DEFAULT NULL,
  `str_UPDATED_BY` varchar(20) DEFAULT NULL,
  `lg_TABLE_ID` varchar(20) DEFAULT NULL,
  `lg_CONSOMMATION_ID` varchar(20) DEFAULT NULL,
  `lg_CUSTOMER_ID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`lg_COMMAND_ID`),
  KEY `lg_TABLE_ID` (`lg_TABLE_ID`),
  KEY `lg_CONSOMMATION_ID` (`lg_CONSOMMATION_ID`),
  KEY `lg_CUSTOMER_ID` (`lg_CUSTOMER_ID`),
  CONSTRAINT `t_command_fk3` FOREIGN KEY (`lg_CUSTOMER_ID`) REFERENCES `t_customer` (`lg_CUSTOMER_ID`),
  CONSTRAINT `t_command_fk1` FOREIGN KEY (`lg_TABLE_ID`) REFERENCES `t_table` (`lg_TABLE_ID`),
  CONSTRAINT `t_command_fk2` FOREIGN KEY (`lg_CONSOMMATION_ID`) REFERENCES `t_consommation` (`lg_CONSOMMATION_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_command`
--

LOCK TABLES `t_command` WRITE;
/*!40000 ALTER TABLE `t_command` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_command` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_consommation`
--

DROP TABLE IF EXISTS `t_consommation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_consommation` (
  `lg_CONSOMMATION_ID` varchar(20) NOT NULL,
  `str_WORDING` varchar(45) DEFAULT NULL,
  `dbe_PRICE` double DEFAULT NULL,
  `str_STATUS` varchar(20) DEFAULT NULL,
  `dt_CREATED` datetime DEFAULT NULL,
  `str_CREATED_BY` varchar(20) DEFAULT NULL,
  `dt_UPDATED` datetime DEFAULT NULL,
  `str_UPDATED_BY` varchar(20) DEFAULT NULL,
  `lg_COMSOMMATION_TYPE_ID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`lg_CONSOMMATION_ID`),
  KEY `lg_COMSOMMATION_TYPE_ID` (`lg_COMSOMMATION_TYPE_ID`),
  CONSTRAINT `t_consommation_fk1` FOREIGN KEY (`lg_COMSOMMATION_TYPE_ID`) REFERENCES `t_consummation_type` (`lg_CONSUMMATION_TYPE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_consommation`
--

LOCK TABLES `t_consommation` WRITE;
/*!40000 ALTER TABLE `t_consommation` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_consommation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_consummation_type`
--

DROP TABLE IF EXISTS `t_consummation_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_consummation_type` (
  `lg_CONSUMMATION_TYPE_ID` varchar(20) NOT NULL,
  `str_WORDING` varchar(45) DEFAULT NULL,
  `str_STATUS` varchar(20) DEFAULT NULL,
  `dt_CREATED` datetime DEFAULT NULL,
  `str_CREATED_BY` varchar(20) DEFAULT NULL,
  `dt_UPDATED` datetime DEFAULT NULL,
  `str_UPDATED_BY` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`lg_CONSUMMATION_TYPE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_consummation_type`
--

LOCK TABLES `t_consummation_type` WRITE;
/*!40000 ALTER TABLE `t_consummation_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_consummation_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_customer`
--

DROP TABLE IF EXISTS `t_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_customer` (
  `lg_CUSTOMER_ID` varchar(20) NOT NULL,
  `str_FIRST_NAME` varchar(45) DEFAULT NULL,
  `str_LAST_NAME` varchar(45) DEFAULT NULL,
  `str_PHONE` varchar(20) DEFAULT NULL,
  `str_STATUS` varchar(20) DEFAULT NULL,
  `dt_CREATED` datetime DEFAULT NULL,
  `str_CREATED_BY` varchar(20) DEFAULT NULL,
  `dt_UPDATED` datetime DEFAULT NULL,
  `str_UPDATED_BY` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`lg_CUSTOMER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_customer`
--

LOCK TABLES `t_customer` WRITE;
/*!40000 ALTER TABLE `t_customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_evaluation`
--

DROP TABLE IF EXISTS `t_evaluation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_evaluation` (
  `lg_EVALUATION_ID` varchar(20) NOT NULL,
  `str_REMARK` text,
  `int_MARK` int(11) DEFAULT '5',
  `str_STATUS` varchar(20) DEFAULT NULL,
  `dt_CREATED` datetime DEFAULT NULL,
  `str_CREATED_BY` varchar(20) DEFAULT NULL,
  `dt_UPDATED` datetime DEFAULT NULL,
  `str_UPDATED_BY` varchar(20) DEFAULT NULL,
  `lg_CUSTOMER_ID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`lg_EVALUATION_ID`),
  KEY `lg_CUSTOMER_ID` (`lg_CUSTOMER_ID`),
  CONSTRAINT `t_evaluation_fk1` FOREIGN KEY (`lg_CUSTOMER_ID`) REFERENCES `t_customer` (`lg_CUSTOMER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_evaluation`
--

LOCK TABLES `t_evaluation` WRITE;
/*!40000 ALTER TABLE `t_evaluation` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_evaluation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_notification`
--

DROP TABLE IF EXISTS `t_notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_notification` (
  `lg_NOTIFICATION_ID` varchar(20) NOT NULL,
  `str_SUBJECT` varchar(100) DEFAULT NULL,
  `str_DESCRIPTION` text,
  `P_KEY_SENDER` varchar(20) DEFAULT NULL,
  `P_KEY_RECEIVER` varchar(20) DEFAULT NULL,
  `str_STATUT` varchar(20) DEFAULT NULL,
  `dt_CREATED` datetime DEFAULT NULL,
  `dt_UPDATED` datetime DEFAULT NULL,
  `lg_CANALNOTIFICATION_ID` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`lg_NOTIFICATION_ID`),
  KEY `t_notification_fk1` (`lg_CANALNOTIFICATION_ID`),
  CONSTRAINT `t_notification_fk1` FOREIGN KEY (`lg_CANALNOTIFICATION_ID`) REFERENCES `t_canalnotification` (`lg_CANALNOTIFICATION_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=304 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_notification`
--

LOCK TABLES `t_notification` WRITE;
/*!40000 ALTER TABLE `t_notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_sms`
--

DROP TABLE IF EXISTS `t_sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_sms` (
  `lg_SMS_ID` int(20) NOT NULL AUTO_INCREMENT,
  `str_DESCRIPTION` text,
  `str_DESTINATAIRE` varchar(20) DEFAULT NULL,
  `str_CREATED_BY` varchar(40) DEFAULT NULL,
  `str_UPDATED_BY` varchar(40) DEFAULT NULL,
  `dt_CREATED` datetime DEFAULT NULL,
  `dt_UPDATED` datetime DEFAULT NULL,
  `str_STATUT` varchar(20) DEFAULT NULL,
  `lg_CUSTOMER_ID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`lg_SMS_ID`),
  KEY `t_SMS_fk` (`lg_CUSTOMER_ID`),
  CONSTRAINT `t_SMS_fk` FOREIGN KEY (`lg_CUSTOMER_ID`) REFERENCES `t_customer` (`lg_CUSTOMER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_sms`
--

LOCK TABLES `t_sms` WRITE;
/*!40000 ALTER TABLE `t_sms` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_sms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_smstoken`
--

DROP TABLE IF EXISTS `t_smstoken`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_smstoken` (
  `lg_SMSTOKEN_ID` int(20) NOT NULL AUTO_INCREMENT,
  `str_ACCESSTOKEN` varchar(56) DEFAULT NULL,
  `int_EXPRIRESIN` double DEFAULT NULL,
  `int_DAYSNUMBER` int(11) DEFAULT '0',
  `dt_EXPIRATION` datetime DEFAULT NULL,
  `dt_CREATED` datetime DEFAULT NULL,
  `dt_UPDATED` datetime DEFAULT NULL,
  `str_STATUT` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`lg_SMSTOKEN_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_smstoken`
--

LOCK TABLES `t_smstoken` WRITE;
/*!40000 ALTER TABLE `t_smstoken` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_smstoken` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_table`
--

DROP TABLE IF EXISTS `t_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_table` (
  `lg_TABLE_ID` varchar(20) NOT NULL,
  `str_WORDING` varchar(45) DEFAULT NULL,
  `int_NUMBER_PLACE` int(11) DEFAULT NULL,
  `str_STATUS` varchar(20) DEFAULT NULL,
  `dt_CREATED` datetime DEFAULT NULL,
  `str_CREATED_BY` varchar(20) DEFAULT NULL,
  `dt_UPDATED` datetime DEFAULT NULL,
  `str_UPDATED_BY` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`lg_TABLE_ID`),
  UNIQUE KEY `lg_TABLE_ID` (`lg_TABLE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_table`
--

LOCK TABLES `t_table` WRITE;
/*!40000 ALTER TABLE `t_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `v_get_command_list`
--

DROP TABLE IF EXISTS `v_get_command_list`;
/*!50001 DROP VIEW IF EXISTS `v_get_command_list`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v_get_command_list` (
  `dt_DATE` tinyint NOT NULL,
  `int_NUMBER_DISH` tinyint NOT NULL,
  `str_WORDING_TABLE` tinyint NOT NULL,
  `int_NUMBER_PLACE` tinyint NOT NULL,
  `str_WORDING_CONSOMMATION` tinyint NOT NULL,
  `dbe_PRICE` tinyint NOT NULL,
  `str_FIRST_NAME` tinyint NOT NULL,
  `str_LAST_NAME` tinyint NOT NULL,
  `str_PHONE` tinyint NOT NULL,
  `lg_CUSTOMER_ID` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'restorant_db'
--

--
-- Final view structure for view `v_get_command_list`
--

/*!50001 DROP TABLE IF EXISTS `v_get_command_list`*/;
/*!50001 DROP VIEW IF EXISTS `v_get_command_list`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_get_command_list` AS select `t_command`.`dt_DATE` AS `dt_DATE`,`t_command`.`int_NUMBER_DISH` AS `int_NUMBER_DISH`,`t_table`.`str_WORDING` AS `str_WORDING_TABLE`,`t_table`.`int_NUMBER_PLACE` AS `int_NUMBER_PLACE`,`t_consommation`.`str_WORDING` AS `str_WORDING_CONSOMMATION`,`t_consommation`.`dbe_PRICE` AS `dbe_PRICE`,`t_customer`.`str_FIRST_NAME` AS `str_FIRST_NAME`,`t_customer`.`str_LAST_NAME` AS `str_LAST_NAME`,`t_customer`.`str_PHONE` AS `str_PHONE`,`t_customer`.`lg_CUSTOMER_ID` AS `lg_CUSTOMER_ID` from (((`t_command` join `t_table`) join `t_consommation`) join `t_customer`) where ((`t_command`.`lg_TABLE_ID` = `t_table`.`lg_TABLE_ID`) and (`t_command`.`lg_CUSTOMER_ID` = `t_customer`.`lg_CUSTOMER_ID`) and (`t_command`.`lg_CONSOMMATION_ID` = `t_consommation`.`lg_CONSOMMATION_ID`)) group by `t_command`.`dt_DATE`,`t_customer`.`lg_CUSTOMER_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-08  1:27:52
