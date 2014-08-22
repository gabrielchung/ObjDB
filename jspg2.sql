-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: jspg2
-- ------------------------------------------------------
-- Server version	5.5.37-0ubuntu0.14.04.1

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
-- Table structure for table `obj`
--

DROP TABLE IF EXISTS `obj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `obj` (
  `scope_read` varchar(45) NOT NULL,
  `scope_read_id` bigint(20) unsigned DEFAULT NULL,
  `scope_write` varchar(45) NOT NULL,
  `scope_write_id` bigint(20) unsigned DEFAULT NULL,
  `namespace` varchar(200) NOT NULL,
  `obj_name` varchar(200) NOT NULL,
  `obj_json` varchar(5000) NOT NULL,
  `id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`namespace`,`obj_name`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `obj`
--

LOCK TABLES `obj` WRITE;
/*!40000 ALTER TABLE `obj` DISABLE KEYS */;
INSERT INTO `obj` VALUES ('GLOBAL',NULL,'USER',1,'test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":21}',21),('GLOBAL',NULL,'USER',1,'test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":22}',22),('GLOBAL',NULL,'USER',1,'test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":23}',23),('GLOBAL',NULL,'USER',1,'test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":24}',24);
/*!40000 ALTER TABLE `obj` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `obj_deleted`
--

DROP TABLE IF EXISTS `obj_deleted`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `obj_deleted` (
  `scope_read` varchar(45) NOT NULL,
  `scope_read_id` varchar(45) DEFAULT NULL,
  `scope_write` varchar(45) NOT NULL,
  `scope_write_id` varchar(45) DEFAULT NULL,
  `namespace` varchar(200) NOT NULL,
  `obj_name` varchar(200) NOT NULL,
  `obj_json` varchar(5000) NOT NULL,
  `id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `obj_deleted`
--

LOCK TABLES `obj_deleted` WRITE;
/*!40000 ALTER TABLE `obj_deleted` DISABLE KEYS */;
INSERT INTO `obj_deleted` VALUES ('GLOBAL',NULL,'GLOBAL',NULL,'test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World\",\"content\":\"Hello! This is the content of this piece of information\",\"modified_timestamp\":1407244019,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":16}',16),('GLOBAL',NULL,'GLOBAL',NULL,'test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World4\",\"content\":\"Hello4! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":16}',16),('USER','1','USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World\",\"content\":\"Hello! This is the content of this piece of information\",\"modified_timestamp\":1407244019,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":17}',17),('GLOBAL',NULL,'GLOBAL',NULL,'test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World4\",\"content\":\"Hello4! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":16}',16),('USER','1','USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World4\",\"content\":\"Hello4! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":17}',17),('GLOBAL',NULL,'GLOBAL',NULL,'test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World\",\"content\":\"Hello! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":16}',16),('USER','1','USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World\",\"content\":\"Hello! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":17}',17),('GLOBAL',NULL,'GLOBAL',NULL,'test_ns','info','{\"id\":16, \"owner_id\":[3,4,6,7],\"title\":\"Hello World1\",\"content\":\"Hello1! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15]}',16),('USER','1','USER','1','test_ns','info','{\"id\":17, \"owner_id\":[3,4,6,7],\"title\":\"Hello World1\",\"content\":\"Hello1! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15]}',17),('GLOBAL',NULL,'GLOBAL',NULL,'test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":16}',16),('USER','1','USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":17}',17),('GLOBAL',NULL,'GLOBAL',NULL,'test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":16}',16),('USER','1','USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":17}',17),('GLOBAL',NULL,'GLOBAL',NULL,'test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":16}',16),('USER','1','USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":17}',17),('GLOBAL',NULL,'GLOBAL',NULL,'test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":16}',16),('GLOBAL',NULL,'GLOBAL',NULL,'test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World\",\"content\":\"Hello! This is the content of this piece of information\",\"modified_timestamp\":1407244019,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":20}',20),('USER','1','USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World\",\"content\":\"Hello! This is the content of this piece of information\",\"modified_timestamp\":1407244019,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":18}',18),('USER','1','USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World\",\"content\":\"Hello! This is the content of this piece of information\",\"modified_timestamp\":1407244019,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":19}',19),('USER','1','USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World\",\"content\":\"Hello! This is the content of this piece of information\",\"modified_timestamp\":1407244019,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":24}',24),('GLOBAL',NULL,'USER','1','test_ns','info','{\"id\":24, \"owner_id\":[3,4,6,7],\"title\":\"Hello World1\",\"content\":\"Hello1! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15]}',24),('USER','1','USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World\",\"content\":\"Hello! This is the content of this piece of information\",\"modified_timestamp\":1407244019,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":21}',21),('USER','1','USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World\",\"content\":\"Hello! This is the content of this piece of information\",\"modified_timestamp\":1407244019,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":22}',22),('USER','1','USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World\",\"content\":\"Hello! This is the content of this piece of information\",\"modified_timestamp\":1407244019,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":23}',23),('USER','1','USER','1','test_ns','info','{\"id\":24, \"owner_id\":[3,4,6,7],\"title\":\"Hello World1\",\"content\":\"Hello1! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15]}',24),('GLOBAL',NULL,'USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":21}',21),('GLOBAL',NULL,'USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":22}',22),('GLOBAL',NULL,'USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":23}',23),('GLOBAL',NULL,'USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":24}',24),('GLOBAL',NULL,'USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":21}',21),('GLOBAL',NULL,'USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":22}',22),('GLOBAL',NULL,'USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":23}',23),('GLOBAL',NULL,'USER','1','test_ns','info','{\"owner_id\":[3,4,6,7],\"title\":\"Hello World2\",\"content\":\"Hello2! This is the content of this piece of information\",\"modified_timestamp\":1407244040,\"creation_timestamp\":1407244019,\"taxonomy_id\":[3,4,5,11,15],\"id\":24}',24);
/*!40000 ALTER TABLE `obj_deleted` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `obj_field`
--

DROP TABLE IF EXISTS `obj_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `obj_field` (
  `namespace` varchar(200) NOT NULL,
  `obj_name` varchar(200) NOT NULL,
  `id` bigint(20) unsigned NOT NULL,
  `field_name` varchar(200) NOT NULL,
  `field_value_str` varchar(200) DEFAULT NULL,
  `field_value_num` decimal(13,3) DEFAULT NULL,
  PRIMARY KEY (`field_name`,`namespace`,`obj_name`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `obj_field`
--

LOCK TABLES `obj_field` WRITE;
/*!40000 ALTER TABLE `obj_field` DISABLE KEYS */;
INSERT INTO `obj_field` VALUES ('test_ns','info',13,'content','Hello! This is the content of this piece of information',NULL),('test_ns','info',14,'content','Hello! This is the content of this piece of information',NULL),('test_ns','info',15,'content','Hello! This is the content of this piece of information',NULL),('test_ns','info',21,'content','Hello2! This is the content of this piece of information',NULL),('test_ns','info',22,'content','Hello2! This is the content of this piece of information',NULL),('test_ns','info',23,'content','Hello2! This is the content of this piece of information',NULL),('test_ns','info',24,'content','Hello2! This is the content of this piece of information',NULL),('test_ns','info',13,'creation_timestamp',NULL,1407244019.000),('test_ns','info',14,'creation_timestamp',NULL,1407244019.000),('test_ns','info',15,'creation_timestamp',NULL,1407244019.000),('test_ns','info',21,'creation_timestamp',NULL,1407244019.000),('test_ns','info',22,'creation_timestamp',NULL,1407244019.000),('test_ns','info',23,'creation_timestamp',NULL,1407244019.000),('test_ns','info',24,'creation_timestamp',NULL,1407244019.000),('test_ns','info',13,'id',NULL,13.000),('test_ns','info',14,'id',NULL,14.000),('test_ns','info',15,'id',NULL,15.000),('test_ns','info',21,'id',NULL,21.000),('test_ns','info',22,'id',NULL,22.000),('test_ns','info',23,'id',NULL,23.000),('test_ns','info',24,'id',NULL,24.000),('test_ns','info',13,'modified_timestamp',NULL,1407244019.000),('test_ns','info',14,'modified_timestamp',NULL,1407244019.000),('test_ns','info',15,'modified_timestamp',NULL,1407244019.000),('test_ns','info',21,'modified_timestamp',NULL,1407244040.000),('test_ns','info',22,'modified_timestamp',NULL,1407244040.000),('test_ns','info',23,'modified_timestamp',NULL,1407244040.000),('test_ns','info',24,'modified_timestamp',NULL,1407244040.000),('test_ns','info',13,'title','Hello World',NULL),('test_ns','info',14,'title','Hello World',NULL),('test_ns','info',15,'title','Hello World',NULL),('test_ns','info',21,'title','Hello World2',NULL),('test_ns','info',22,'title','Hello World2',NULL),('test_ns','info',23,'title','Hello World2',NULL),('test_ns','info',24,'title','Hello World2',NULL);
/*!40000 ALTER TABLE `obj_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seq`
--

DROP TABLE IF EXISTS `seq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seq` (
  `seq_name` varchar(250) NOT NULL,
  `seq_value` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`seq_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seq`
--

LOCK TABLES `seq` WRITE;
/*!40000 ALTER TABLE `seq` DISABLE KEYS */;
INSERT INTO `seq` VALUES ('test_ns\\',24),('test_ns\\foo',28),('test_ns\\info',24);
/*!40000 ALTER TABLE `seq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblUser`
--

DROP TABLE IF EXISTS `tblUser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblUser` (
  `userID` bigint(20) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `creationTS` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keywordSubscription` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblUser`
--

LOCK TABLES `tblUser` WRITE;
/*!40000 ALTER TABLE `tblUser` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblUser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'jspg2'
--
/*!50003 DROP FUNCTION IF EXISTS `fn_get_seq_value` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`%` FUNCTION `fn_get_seq_value`(in_seq_name VARCHAR(200)) RETURNS int(11)
BEGIN
	
	DECLARE v_seq_row_count INT;
	DECLARE v_seq_value BIGINT UNSIGNED;

	SELECT COUNT(1) INTO v_seq_row_count FROM seq WHERE seq_name = in_seq_name;

	IF (v_seq_row_count = 0) THEN

		INSERT INTO seq (seq_name) VALUE (in_seq_name);

		RETURN 0;

	ELSE

		SELECT seq_value + 1 INTO v_seq_value FROM seq WHERE seq_name = in_seq_name;

		UPDATE seq SET seq_value = seq_value + 1;

		RETURN v_seq_value;

	END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-08-22 16:48:28
