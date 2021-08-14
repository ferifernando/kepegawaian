-- MariaDB dump 10.18  Distrib 10.4.17-MariaDB, for osx10.10 (x86_64)
--
-- Host: localhost    Database: kepegawaian
-- ------------------------------------------------------
-- Server version	10.4.17-MariaDB

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
-- Table structure for table `tbl_admin`
--

DROP TABLE IF EXISTS `tbl_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(3) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `hp` varchar(25) DEFAULT NULL,
  `foto` mediumtext DEFAULT NULL,
  `password` mediumtext NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  KEY `level` (`level`),
  CONSTRAINT `level` FOREIGN KEY (`level`) REFERENCES `tbl_level` (`id_level`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_admin`
--

LOCK TABLES `tbl_admin` WRITE;
/*!40000 ALTER TABLE `tbl_admin` DISABLE KEYS */;
INSERT INTO `tbl_admin` VALUES (1,1,'Superadmin','superadmin','0800',NULL,'$2y$10$4jaZ07FdmyYaFOy/XRotkO5dfoeLGhnazBB.aNbMRbvtXfphvoKii',1,'2021-08-05 19:53:41',1,'2021-08-14 00:31:29'),(2,2,'Administrator','admin','08112233','administrator1832.png','$2y$10$hJ6oWlcxo3dVNqrctzU/HeHdpGRJEoGLtWY.dlEvUVleK/tojVOZ6',1,'2021-08-05 19:53:41',2,'2021-08-14 13:23:27');
/*!40000 ALTER TABLE `tbl_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_jabatan`
--

DROP TABLE IF EXISTS `tbl_jabatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_jabatan` (
  `id_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `jabatan` text NOT NULL,
  `gaji` int(11) DEFAULT NULL,
  `created_by` int(3) NOT NULL,
  `created_at` datetime NOT NULL,
  `edited_by` int(3) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_jabatan`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_jabatan`
--

LOCK TABLES `tbl_jabatan` WRITE;
/*!40000 ALTER TABLE `tbl_jabatan` DISABLE KEYS */;
INSERT INTO `tbl_jabatan` VALUES (1,'Komisaris',15000000,2,'2021-08-14 09:32:54',2,'2021-08-14 12:38:59'),(2,'Direktur',15000000,2,'2021-08-14 09:33:35',2,'2021-08-14 12:38:38'),(3,'Manager Operasional',10000000,2,'2021-08-14 09:35:29',2,'2021-08-14 12:38:47'),(4,'Manager Humas',8000000,2,'2021-08-14 12:27:06',NULL,NULL),(5,'Staff',3000000,2,'2021-08-14 12:27:37',2,'2021-08-14 12:27:42');
/*!40000 ALTER TABLE `tbl_jabatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_level`
--

DROP TABLE IF EXISTS `tbl_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_level` (
  `id_level` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(25) NOT NULL,
  `created_by` int(3) NOT NULL,
  `created_at` datetime NOT NULL,
  `edited_by` int(3) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_level`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_level`
--

LOCK TABLES `tbl_level` WRITE;
/*!40000 ALTER TABLE `tbl_level` DISABLE KEYS */;
INSERT INTO `tbl_level` VALUES (1,'Superadmin',1,'2021-08-06 11:45:56',NULL,NULL),(2,'Admin',1,'2021-08-06 11:45:56',2,'2021-08-14 12:24:54'),(3,'Operator',2,'2021-08-06 17:05:32',NULL,NULL);
/*!40000 ALTER TABLE `tbl_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_log_jabatan`
--

DROP TABLE IF EXISTS `tbl_log_jabatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_log_jabatan` (
  `id_log_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `id_pegawai` int(3) NOT NULL,
  `jabatan_lama` int(3) NOT NULL,
  `jabatan_baru` int(3) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_log_jabatan`),
  KEY `pegawai` (`id_pegawai`),
  KEY `jabatan_lama` (`jabatan_lama`),
  KEY `jabatan_baru` (`jabatan_baru`),
  CONSTRAINT `jabatan_baru` FOREIGN KEY (`jabatan_baru`) REFERENCES `tbl_jabatan` (`id_jabatan`),
  CONSTRAINT `jabatan_lama` FOREIGN KEY (`jabatan_lama`) REFERENCES `tbl_jabatan` (`id_jabatan`),
  CONSTRAINT `pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `tbl_pegawai` (`id_pegawai`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_log_jabatan`
--

LOCK TABLES `tbl_log_jabatan` WRITE;
/*!40000 ALTER TABLE `tbl_log_jabatan` DISABLE KEYS */;
INSERT INTO `tbl_log_jabatan` VALUES (1,1,1,2,'2021-08-14 07:02:45'),(2,1,2,4,'2021-08-14 07:05:01');
/*!40000 ALTER TABLE `tbl_log_jabatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pegawai`
--

DROP TABLE IF EXISTS `tbl_pegawai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pegawai` (
  `id_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `jabatan` int(3) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `jenis_kelamin` int(1) NOT NULL COMMENT '0 = laki-laki, 1 = perempuan',
  `nomor_hp` varchar(25) NOT NULL,
  `foto` text NOT NULL,
  `mulai_kerja` date NOT NULL,
  `created_by` int(3) NOT NULL,
  `created_at` datetime NOT NULL,
  `edited_by` int(3) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`),
  KEY `jabatan` (`jabatan`),
  CONSTRAINT `jabatan` FOREIGN KEY (`jabatan`) REFERENCES `tbl_jabatan` (`id_jabatan`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pegawai`
--

LOCK TABLES `tbl_pegawai` WRITE;
/*!40000 ALTER TABLE `tbl_pegawai` DISABLE KEYS */;
INSERT INTO `tbl_pegawai` VALUES (1,4,'John Doe','Jl. Jend. Sudirman, Kota Bandung, Jawa Barat, Indonesia',0,'081234567890','john-doe1021.png','2019-10-14',2,'2021-08-14 13:28:17',2,'2021-08-14 14:05:01');
/*!40000 ALTER TABLE `tbl_pegawai` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER update_jabatan_pegawai
    BEFORE UPDATE 
    ON tbl_pegawai
    FOR EACH ROW 
BEGIN
    INSERT INTO tbl_log_jabatan
    set id_pegawai = OLD.id_pegawai,
    jabatan_lama=old.jabatan,
    jabatan_baru=new.jabatan;
END */;;
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

-- Dump completed on 2021-08-14 15:52:52
