-- MariaDB dump 10.19  Distrib 10.5.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: chicheria
-- ------------------------------------------------------
-- Server version	10.5.12-MariaDB-0+deb11u1

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
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `local` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `ci` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titular` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `fechanac` date DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `legalidad` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `categoria` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `razon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `nit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `observacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `tipocliente` tinyint(1) NOT NULL DEFAULT 1,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'ACTIVO',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clientes_ci_unique` (`ci`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'','123','SIN REGISTRO','','0',NULL,'X','','','','','',2,'ACTIVO','2021-10-25 12:24:57','2021-11-15 18:48:15'),(3,'','122','SIN REGISTRO','','1',NULL,'X','','','','','',2,'INACTIVO','2021-10-25 12:40:52','2021-11-12 17:44:39'),(4,'','111','SIN REGISTRO','','1',NULL,'X','','','','','',2,'INACTIVO','2021-10-25 13:10:02','2021-11-12 19:29:12'),(5,'','3414803','ROMAN VILLANUEVA','','76224784',NULL,'X','','','','','',2,'ACTIVO','2021-10-25 15:39:52','2021-10-25 15:39:52'),(9,'','222','SIN REGISTRO','','1',NULL,'X','','','','','',2,'INACTIVO','2021-10-25 16:47:07','2021-11-15 18:48:32'),(10,'','7378523','CARLOS LIZITE','','72328415',NULL,'X','','','','','',2,'ACTIVO','2021-10-25 17:54:42','2021-10-25 17:54:42'),(11,'','2','X','','1',NULL,'X','','','','','',2,'INACTIVO','2021-10-27 12:21:30','2021-11-15 18:48:52'),(12,'','3','X','','3',NULL,'X','','','','','',2,'INACTIVO','2021-10-27 12:23:27','2021-11-15 18:49:00'),(13,'','3532381','NORMA RODRIGUEZ','','75712138',NULL,'X','','','','','',2,'ACTIVO','2021-10-27 13:42:11','2021-10-27 13:42:11'),(14,'','4','X','','4',NULL,'X','','','','','',2,'INACTIVO','2021-10-27 13:49:36','2021-11-15 18:49:07'),(15,'','6','EMA PATON','','6',NULL,'X','','','','','',2,'ACTIVO','2021-10-27 13:58:52','2021-10-27 13:58:52'),(16,'','3529443','WILSON CONDORI','','69571210',NULL,'X','','','','','',2,'ACTIVO','2021-10-27 14:25:19','2021-10-27 14:25:19'),(17,'','8557233','DORA CONDORI','','7332524',NULL,'X','','','','','',2,'ACTIVO','2021-10-27 15:54:48','2021-10-27 15:54:48'),(18,'','5770016','FRANZ PUMA MAMANI','','75716268',NULL,'X','','','','','',2,'ACTIVO','2021-10-28 11:24:06','2021-10-28 11:24:06'),(19,'','2759493','TORRICO','','76140135',NULL,'X','','','','','',2,'ACTIVO','2021-10-28 13:16:34','2021-10-28 13:16:34'),(20,'','4037546','SULEMA RAMIREZ','','74114956',NULL,'X','','','','','',2,'ACTIVO','2021-10-28 14:02:06','2021-10-28 14:02:06'),(21,'','2768120','DAVID COLQUE','','60414123',NULL,'X','','','','','',2,'ACTIVO','2021-10-28 14:11:51','2021-10-28 14:11:51'),(22,'','603785','JUAN CARLOS MANZANO CORONADO','','76150083',NULL,'X','','','','','',2,'ACTIVO','2021-10-28 14:29:19','2021-10-28 14:29:19'),(23,'','3555229','JOSE LUIS MERCADO','','62812615',NULL,'X','','','','','',2,'ACTIVO','2021-10-28 14:33:00','2021-10-28 14:33:00'),(24,'','4041442','CSAR ROJAS','','68326490',NULL,'X','','','','','',2,'ACTIVO','2021-10-28 14:59:15','2021-10-28 14:59:15'),(25,'','5746918','MANUEL','','73802675',NULL,'X','','','','','',2,'ACTIVO','2021-10-28 16:46:18','2021-10-28 16:46:18'),(26,'LOCAL PAREDES','5742912','HENRY ANDER PAREDES MAMANI','PROPIETARIO','72358599','1983-09-21','ZONA INDUSTRIAL','SIN LICENCIA','SIN NIT','','','',1,'ACTIVO','2021-11-12 19:17:20','2021-11-12 19:17:20'),(27,'','1','HERNAN FIGUEROA',NULL,'65438310',NULL,'X',NULL,NULL,'','','',2,'ACTIVO','2021-11-12 19:32:57','2021-11-12 19:32:57'),(28,'','12','ROBERTO DELGADO',NULL,'73802961',NULL,'X',NULL,NULL,'','','',2,'ACTIVO','2021-11-12 19:39:27','2021-11-12 19:39:27'),(29,'','13','DEYMAR PENA',NULL,'75412196',NULL,'X',NULL,NULL,'','','',2,'ACTIVO','2021-11-12 19:41:07','2021-11-12 19:41:07'),(30,'','14','JORGE CHIRI',NULL,'75716662',NULL,'X',NULL,NULL,'','','',2,'ACTIVO','2021-11-12 19:43:18','2021-11-12 19:43:18'),(31,'','7953045','RAUL ALANIS JALDIN',NULL,'63665241',NULL,'',NULL,NULL,'','','',2,'ACTIVO','2021-11-12 19:47:43','2021-11-12 19:47:43'),(32,'','3098138','VEATRIS CONDORI TORRES',NULL,'70432199',NULL,'X',NULL,NULL,'','','',2,'ACTIVO','2021-11-12 20:05:53','2021-11-12 20:05:53'),(33,'','3506530','JHOVANA FERNANDEZ',NULL,'72460203',NULL,'X',NULL,NULL,'','','',2,'ACTIVO','2021-11-12 20:37:56','2021-11-12 20:37:56'),(34,'','15','JORGE MORALES',NULL,'79415325',NULL,'X',NULL,NULL,'','','',2,'ACTIVO','2021-11-12 21:29:22','2021-11-12 21:29:22'),(35,'','16','LUIS COLQUE',NULL,'67221195',NULL,'X',NULL,NULL,'','','',2,'ACTIVO','2021-11-12 21:32:42','2021-11-12 21:32:42'),(36,'','17','JUANA PATON',NULL,'74142475',NULL,'X',NULL,NULL,'','','',2,'ACTIVO','2021-11-12 21:34:56','2021-11-12 21:34:56'),(37,'','18','ANGEL ALBARADO',NULL,'73849545',NULL,'X',NULL,NULL,'','','',2,'ACTIVO','2021-11-12 21:41:56','2021-11-12 21:41:56'),(38,'','20','NOEMI ESTRELLA PAIZ',NULL,'76147224',NULL,'X',NULL,NULL,'','','',2,'ACTIVO','2021-11-13 19:39:51','2021-11-13 19:39:51'),(39,'','21','ALBERTO LLAVE',NULL,'74143825',NULL,'X',NULL,NULL,'','','',2,'ACTIVO','2021-11-13 19:41:09','2021-11-13 19:41:09'),(40,'','23','JORGE LOZANO',NULL,'70425240',NULL,'X',NULL,NULL,'','','',2,'ACTIVO','2021-11-14 14:32:08','2021-11-14 14:32:08'),(41,'','24','POLICIA MOCOLA',NULL,'',NULL,'',NULL,NULL,'','','',2,'ACTIVO','2021-11-14 17:48:11','2021-11-14 17:48:11'),(42,'','19','EFRAIN VALLEJOS',NULL,'74553054',NULL,'',NULL,NULL,'','','',2,'ACTIVO','2021-11-15 19:41:36','2021-11-15 19:41:36'),(43,'','22','MARIA FILOMENA',NULL,'',NULL,'',NULL,NULL,'','','',2,'ACTIVO','2021-11-16 17:33:37','2021-11-16 17:33:37');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalleprestamos`
--

DROP TABLE IF EXISTS `detalleprestamos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalleprestamos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `prestamo_id` bigint(20) unsigned NOT NULL,
  `inventario_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detalleprestamos_prestamo_id_foreign` (`prestamo_id`),
  KEY `detalleprestamos_inventario_id_foreign` (`inventario_id`),
  CONSTRAINT `detalleprestamos_inventario_id_foreign` FOREIGN KEY (`inventario_id`) REFERENCES `inventarios` (`id`),
  CONSTRAINT `detalleprestamos_prestamo_id_foreign` FOREIGN KEY (`prestamo_id`) REFERENCES `prestamos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalleprestamos`
--

LOCK TABLES `detalleprestamos` WRITE;
/*!40000 ALTER TABLE `detalleprestamos` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalleprestamos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalles`
--

DROP TABLE IF EXISTS `detalles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `venta_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `producto_id` bigint(20) unsigned NOT NULL,
  `cantidad` int(11) NOT NULL,
  `nombreproducto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` double(11,2) NOT NULL,
  `subtotal` double(11,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detalles_venta_id_foreign` (`venta_id`),
  KEY `detalles_user_id_foreign` (`user_id`),
  KEY `detalles_producto_id_foreign` (`producto_id`),
  CONSTRAINT `detalles_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  CONSTRAINT `detalles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `detalles_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalles`
--

LOCK TABLES `detalles` WRITE;
/*!40000 ALTER TABLE `detalles` DISABLE KEYS */;
INSERT INTO `detalles` VALUES (1,1,1,6,1,'1/4 TURRIL',240.00,240.00,'2021-10-25 12:41:26','2021-10-25 12:41:26'),(2,2,1,11,12,'LATAS',7.00,84.00,'2021-10-25 13:11:01','2021-10-25 13:11:01'),(3,3,1,5,1,'BIDON',100.00,100.00,'2021-10-25 15:40:13','2021-10-25 15:40:13'),(4,4,1,10,10,'BORRA',20.00,200.00,'2021-10-25 16:47:33','2021-10-25 16:47:33'),(5,5,1,10,4,'BORRA',20.00,80.00,'2021-10-25 17:55:58','2021-10-25 17:55:58'),(6,6,1,11,15,'LATAS',7.00,105.00,'2021-10-27 12:22:36','2021-10-27 12:22:36'),(7,7,1,5,1,'BIDON',100.00,100.00,'2021-10-27 12:24:11','2021-10-27 12:24:11'),(8,8,1,6,1,'1/4 TURRIL',240.00,240.00,'2021-10-27 13:42:48','2021-10-27 13:42:48'),(9,9,1,13,1,'CANTARITO',30.00,30.00,'2021-10-27 13:50:05','2021-10-27 13:50:05'),(10,10,1,7,1,'1/2 TURRIL',450.00,450.00,'2021-10-27 13:53:23','2021-10-27 13:53:23'),(11,11,1,6,1,'1/4 TURRIL',240.00,240.00,'2021-10-27 14:01:06','2021-10-27 14:01:06'),(12,12,1,13,1,'CANTARITO',30.00,30.00,'2021-10-27 14:02:34','2021-10-27 14:02:34'),(13,13,1,14,4,'TUTUMA',5.00,20.00,'2021-10-27 14:15:51','2021-10-27 14:15:51'),(14,14,1,6,1,'1/4 TURRIL',240.00,240.00,'2021-10-27 14:22:24','2021-10-27 14:22:24'),(15,15,1,5,1,'BIDON',100.00,100.00,'2021-10-27 14:25:37','2021-10-27 14:25:37'),(16,16,1,6,1,'1/4 TURRIL',240.00,240.00,'2021-10-27 15:56:14','2021-10-27 15:56:14'),(17,17,1,5,2,'BIDON',100.00,200.00,'2021-10-28 11:24:35','2021-10-28 11:24:35'),(18,18,1,12,2,'BIDON VACIO',20.00,40.00,'2021-10-28 11:25:15','2021-10-28 11:25:15'),(19,19,1,6,1,'1/4 TURRIL',240.00,240.00,'2021-10-28 13:02:56','2021-10-28 13:02:56'),(20,20,1,12,1,'BIDON VACIO',20.00,20.00,'2021-10-28 13:03:33','2021-10-28 13:03:33'),(21,21,1,6,1,'1/4 TURRIL',240.00,240.00,'2021-10-28 13:04:55','2021-10-28 13:04:55'),(22,22,1,1,3,'LITRO',5.00,15.00,'2021-10-28 13:05:36','2021-10-28 13:05:36'),(23,23,1,5,1,'BIDON',100.00,100.00,'2021-10-28 13:17:00','2021-10-28 13:17:00'),(24,24,1,1,2,'LITRO',5.00,10.00,'2021-10-28 14:03:06','2021-10-28 14:03:06'),(25,25,1,6,1,'1/4 TURRIL',240.00,240.00,'2021-10-28 14:12:09','2021-10-28 14:12:09'),(26,26,1,13,1,'CANTARITO',30.00,30.00,'2021-10-28 14:15:45','2021-10-28 14:15:45'),(27,27,1,14,4,'TUTUMA',5.00,20.00,'2021-10-28 14:16:24','2021-10-28 14:16:24'),(28,28,1,4,1,'1/2 BIDON',50.00,50.00,'2021-10-28 14:29:59','2021-10-28 14:29:59'),(29,29,1,1,5,'LITRO',5.00,25.00,'2021-10-28 14:33:51','2021-10-28 14:33:51'),(30,30,1,1,15,'LITRO',5.00,75.00,'2021-10-28 15:00:36','2021-10-28 15:00:36'),(31,31,1,4,1,'1/2 BIDON',50.00,50.00,'2021-10-28 16:47:28','2021-10-28 16:47:28'),(32,32,1,11,19,'LATAS',7.00,133.00,'2021-10-28 17:52:12','2021-10-28 17:52:12'),(33,33,1,11,18,'LATAS',7.00,126.00,'2021-11-06 20:48:38','2021-11-06 20:48:38'),(34,34,1,2,1,'VALDE',25.00,25.00,'2021-11-06 20:49:04','2021-11-06 20:49:04'),(35,35,1,4,1,'1/2 BIDON',50.00,50.00,'2021-11-06 20:49:48','2021-11-06 20:49:48'),(36,36,1,5,1,'BIDON',100.00,100.00,'2021-11-06 20:50:11','2021-11-06 20:50:11'),(37,37,1,4,1,'1/2 BIDON',50.00,50.00,'2021-11-06 20:50:39','2021-11-06 20:50:39'),(38,38,1,5,1,'BIDON',100.00,100.00,'2021-11-06 22:00:45','2021-11-06 22:00:45'),(39,39,1,4,1,'1/2 BIDON',50.00,50.00,'2021-11-11 20:05:52','2021-11-11 20:05:52'),(40,40,1,1,6,'LITRO',5.00,30.00,'2021-11-11 20:06:27','2021-11-11 20:06:27'),(41,41,1,10,2,'BORRA',20.00,40.00,'2021-11-11 20:08:12','2021-11-11 20:08:12'),(42,42,1,15,1,'1/2 BORRA',10.00,10.00,'2021-11-11 20:09:17','2021-11-11 20:09:17'),(43,43,1,5,1,'BIDON',100.00,100.00,'2021-11-11 21:38:52','2021-11-11 21:38:52'),(44,44,1,12,1,'BIDON VACIO',20.00,20.00,'2021-11-11 21:41:39','2021-11-11 21:41:39'),(45,45,1,5,1,'BIDON',100.00,100.00,'2021-11-12 17:45:07','2021-11-12 17:45:07'),(46,46,1,10,10,'BORRA',20.00,200.00,'2021-11-12 18:24:25','2021-11-12 18:24:25'),(47,47,1,11,29,'LATAS',7.00,203.00,'2021-11-12 18:37:01','2021-11-12 18:37:01'),(48,48,1,16,1,'1/2 TURRIL',400.00,400.00,'2021-11-12 19:19:38','2021-11-12 19:19:38'),(49,49,1,7,1,'1/2 TURRIL',450.00,450.00,'2021-11-12 19:50:31','2021-11-12 19:50:31'),(50,50,1,13,2,'CANTARITO',25.00,50.00,'2021-11-12 19:54:28','2021-11-12 19:54:28'),(51,51,1,6,1,'1/4 TURRIL',240.00,240.00,'2021-11-12 20:06:12','2021-11-12 20:06:12'),(52,52,1,14,3,'TUTUMA',5.00,15.00,'2021-11-12 20:12:57','2021-11-12 20:12:57'),(53,53,1,6,1,'1/4 TURRIL',240.00,240.00,'2021-11-12 20:30:24','2021-11-12 20:30:24'),(54,54,1,5,1,'BIDON',100.00,100.00,'2021-11-12 20:30:40','2021-11-12 20:30:40'),(55,55,1,7,1,'1/2 TURRIL',450.00,450.00,'2021-11-12 20:38:18','2021-11-12 20:38:18'),(56,56,1,2,1,'VALDE',25.00,25.00,'2021-11-13 13:27:45','2021-11-13 13:27:45'),(57,57,1,5,2,'BIDON',100.00,200.00,'2021-11-13 17:17:23','2021-11-13 17:17:23'),(58,58,1,2,1,'VALDE',25.00,25.00,'2021-11-13 17:17:48','2021-11-13 17:17:48'),(59,59,1,5,1,'BIDON',100.00,100.00,'2021-11-13 17:32:27','2021-11-13 17:32:27'),(60,60,1,2,1,'VALDE',25.00,25.00,'2021-11-13 17:32:55','2021-11-13 17:32:55'),(61,61,1,2,1,'VALDE',25.00,25.00,'2021-11-13 17:33:15','2021-11-13 17:33:15'),(62,62,1,1,2,'LITRO',5.00,10.00,'2021-11-13 17:33:49','2021-11-13 17:33:49'),(63,63,1,7,1,'1/2 TURRIL',450.00,450.00,'2021-11-14 14:30:10','2021-11-14 14:30:10'),(64,64,1,5,1,'BIDON',100.00,100.00,'2021-11-14 14:32:27','2021-11-14 14:32:27'),(65,65,1,5,1,'BIDON',100.00,100.00,'2021-11-14 14:59:27','2021-11-14 14:59:27'),(66,66,1,12,1,'BIDON VACIO',20.00,20.00,'2021-11-14 14:59:45','2021-11-14 14:59:45'),(67,67,1,5,1,'BIDON',100.00,100.00,'2021-11-14 15:10:13','2021-11-14 15:10:13'),(68,68,1,2,3,'VALDE',25.00,75.00,'2021-11-14 16:10:00','2021-11-14 16:10:00'),(69,69,1,5,2,'BIDON',100.00,200.00,'2021-11-14 16:40:18','2021-11-14 16:40:18'),(70,70,1,3,1,'BIDON BLANCO PEQUEÑO',30.00,30.00,'2021-11-14 17:03:17','2021-11-14 17:03:17'),(71,71,1,2,1,'VALDE',25.00,25.00,'2021-11-14 17:36:37','2021-11-14 17:36:37'),(72,72,1,7,1,'1/2 TURRIL',400.00,400.00,'2021-11-14 17:48:47','2021-11-14 17:48:47'),(73,73,1,7,1,'1/2 TURRIL',450.00,450.00,'2021-11-14 17:50:03','2021-11-14 17:50:03'),(74,74,1,5,1,'BIDON',100.00,100.00,'2021-11-14 18:32:51','2021-11-14 18:32:51'),(75,75,1,5,1,'BIDON',100.00,100.00,'2021-11-14 19:43:29','2021-11-14 19:43:29'),(76,76,1,4,1,'1/2 BIDON',50.00,50.00,'2021-11-14 19:43:48','2021-11-14 19:43:48'),(77,77,1,5,2,'BIDON',100.00,200.00,'2021-11-15 19:42:22','2021-11-15 19:42:22'),(78,78,1,10,7,'BORRA',20.00,140.00,'2021-11-15 19:43:25','2021-11-15 19:43:25'),(79,79,1,11,51,'LATAS',7.00,357.00,'2021-11-15 19:44:13','2021-11-15 19:44:13'),(80,80,1,7,1,'1/2 TURRIL',450.00,450.00,'2021-11-15 19:44:41','2021-11-15 19:44:41'),(81,81,1,5,2,'BIDON',100.00,200.00,'2021-11-16 17:25:20','2021-11-16 17:25:20'),(82,82,1,6,1,'1/4 TURRIL',240.00,240.00,'2021-11-16 17:34:01','2021-11-16 17:34:01'),(83,83,1,4,1,'1/2 BIDON',50.00,50.00,'2021-11-16 17:56:43','2021-11-16 17:56:43'),(84,84,1,2,1,'VALDE',25.00,25.00,'2021-11-16 19:46:44','2021-11-16 19:46:44'),(85,85,1,2,1,'VALDE',25.00,25.00,'2021-11-16 19:49:59','2021-11-16 19:49:59'),(86,86,1,2,1,'VALDE',25.00,25.00,'2021-11-16 19:52:08','2021-11-16 19:52:08');
/*!40000 ALTER TABLE `detalles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleados`
--

DROP TABLE IF EXISTS `empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empleados` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ci` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salario` int(11) NOT NULL,
  `fechanac` date NOT NULL,
  `dias` int(11) NOT NULL DEFAULT 0,
  `celular` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `empleados_ci_unique` (`ci`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleados`
--

LOCK TABLES `empleados` WRITE;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `garantias`
--

DROP TABLE IF EXISTS `garantias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `garantias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT '2021-10-25',
  `efectivo` double(11,2) DEFAULT 0.00,
  `fisico` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `observacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `cantidad` int(11) DEFAULT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fechadev` date DEFAULT NULL,
  `userdev_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `inventario_id` bigint(20) unsigned NOT NULL,
  `cliente_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `garantias_userdev_id_foreign` (`userdev_id`),
  KEY `garantias_user_id_foreign` (`user_id`),
  KEY `garantias_inventario_id_foreign` (`inventario_id`),
  KEY `garantias_cliente_id_foreign` (`cliente_id`),
  CONSTRAINT `garantias_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  CONSTRAINT `garantias_inventario_id_foreign` FOREIGN KEY (`inventario_id`) REFERENCES `inventarios` (`id`),
  CONSTRAINT `garantias_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `garantias_userdev_id_foreign` FOREIGN KEY (`userdev_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `garantias`
--

LOCK TABLES `garantias` WRITE;
/*!40000 ALTER TABLE `garantias` DISABLE KEYS */;
/*!40000 ALTER TABLE `garantias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gastos`
--

DROP TABLE IF EXISTS `gastos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gastos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `precio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gastos_user_id_foreign` (`user_id`),
  CONSTRAINT `gastos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gastos`
--

LOCK TABLES `gastos` WRITE;
/*!40000 ALTER TABLE `gastos` DISABLE KEYS */;
INSERT INTO `gastos` VALUES (1,'205','ALMUERZO','2021-10-25','13:56:39',1,'2021-10-25 13:56:39','2021-10-25 13:56:39'),(2,'210','ALMUERZO','2021-10-27','13:47:37',1,'2021-10-27 13:47:37','2021-10-27 13:47:37'),(3,'116','COMPRA DE AGUA','2021-10-27','17:34:16',1,'2021-10-27 17:34:16','2021-10-27 17:34:16'),(4,'250','ALMUERZO','2021-10-28','13:06:14',1,'2021-10-28 13:06:14','2021-10-28 13:06:14'),(5,'13','REFRESCO','2021-10-28','13:31:18',1,'2021-10-28 13:31:18','2021-10-28 13:31:18'),(6,'70','SAJRA HORA','2021-11-06','16:51:01',1,'2021-11-06 20:51:01','2021-11-06 20:51:01'),(7,'240','ALMUERZO','2021-11-11','17:39:38',1,'2021-11-11 21:39:38','2021-11-11 21:39:38'),(8,'9','MARCADORES','2021-11-11','17:40:03',1,'2021-11-11 21:40:03','2021-11-11 21:40:03'),(9,'255','ALMUERZO','2021-11-12','14:37:32',1,'2021-11-12 18:37:32','2021-11-12 18:37:32'),(10,'380','ALMUERZO','2021-11-13','13:34:11',1,'2021-11-13 17:34:11','2021-11-13 17:34:11'),(11,'290','ALMUERZO','2021-11-14','13:38:43',1,'2021-11-14 17:38:43','2021-11-14 17:38:43'),(12,'85','ELVIS','2021-11-14','17:11:34',1,'2021-11-14 21:11:34','2021-11-14 21:11:34'),(13,'85','KEVIN','2021-11-14','17:30:07',1,'2021-11-14 21:30:07','2021-11-14 21:30:07'),(14,'85','CRISTIAN','2021-11-14','17:30:33',1,'2021-11-14 21:30:33','2021-11-14 21:30:33'),(15,'265','ALMUERZO','2021-11-15','15:45:09',1,'2021-11-15 19:45:09','2021-11-15 19:45:09'),(16,'20','SANIDAD','2021-11-15','15:45:29',1,'2021-11-15 19:45:29','2021-11-15 19:45:29'),(17,'10','ACE','2021-11-15','16:03:20',1,'2021-11-15 20:03:20','2021-11-15 20:03:20'),(18,'200','AGUA','2021-11-15','16:04:57',1,'2021-11-15 20:04:57','2021-11-15 20:04:57'),(19,'250','ELECTRICO','2021-11-15','17:29:03',1,'2021-11-15 21:29:03','2021-11-15 21:29:03'),(20,'18','AGUA','2021-11-16','13:34:51',1,'2021-11-16 17:34:51','2021-11-16 17:34:51'),(21,'140','SAJRA HORA','2021-11-16','13:35:12',1,'2021-11-16 17:35:12','2021-11-16 17:35:12'),(22,'240','ALMUERZO','2021-11-16','13:35:33',1,'2021-11-16 17:35:33','2021-11-16 17:35:33');
/*!40000 ALTER TABLE `gastos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gdetalles`
--

DROP TABLE IF EXISTS `gdetalles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gdetalles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `garantia_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `inventario_id` bigint(20) unsigned NOT NULL,
  `cantidad` int(11) NOT NULL,
  `nombreinv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gdetalles_garantia_id_foreign` (`garantia_id`),
  KEY `gdetalles_user_id_foreign` (`user_id`),
  KEY `gdetalles_inventario_id_foreign` (`inventario_id`),
  CONSTRAINT `gdetalles_garantia_id_foreign` FOREIGN KEY (`garantia_id`) REFERENCES `garantias` (`id`),
  CONSTRAINT `gdetalles_inventario_id_foreign` FOREIGN KEY (`inventario_id`) REFERENCES `inventarios` (`id`),
  CONSTRAINT `gdetalles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gdetalles`
--

LOCK TABLES `gdetalles` WRITE;
/*!40000 ALTER TABLE `gdetalles` DISABLE KEYS */;
/*!40000 ALTER TABLE `gdetalles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventarios`
--

DROP TABLE IF EXISTS `inventarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date NOT NULL DEFAULT '2021-10-25',
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 0,
  `detalle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ACTIVO',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventarios`
--

LOCK TABLES `inventarios` WRITE;
/*!40000 ALTER TABLE `inventarios` DISABLE KEYS */;
INSERT INTO `inventarios` VALUES (1,'TURRIL','2021-10-25','TURRIL',996,'','ACTIVO','2021-10-25 12:32:38','2021-11-16 20:28:48'),(2,'BIDON BLANCO','2021-10-25','BIDON BLANCO',960,'','ACTIVO','2021-10-25 12:33:07','2021-11-16 18:47:33'),(3,'BIDON VERDE','2021-10-25','BIDON VERDE',1000,'','ACTIVO','2021-10-25 12:33:41','2021-10-25 12:33:41');
/*!40000 ALTER TABLE `inventarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loginventarios`
--

DROP TABLE IF EXISTS `loginventarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginventarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `agregar` tinyint(1) NOT NULL DEFAULT 1,
  `motivo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inventario_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `loginventarios_inventario_id_foreign` (`inventario_id`),
  KEY `loginventarios_user_id_foreign` (`user_id`),
  CONSTRAINT `loginventarios_inventario_id_foreign` FOREIGN KEY (`inventario_id`) REFERENCES `inventarios` (`id`),
  CONSTRAINT `loginventarios_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loginventarios`
--

LOCK TABLES `loginventarios` WRITE;
/*!40000 ALTER TABLE `loginventarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `loginventarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logprestamos`
--

DROP TABLE IF EXISTS `logprestamos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logprestamos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `motivo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prestamo_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `logprestamos_prestamo_id_foreign` (`prestamo_id`),
  KEY `logprestamos_user_id_foreign` (`user_id`),
  CONSTRAINT `logprestamos_prestamo_id_foreign` FOREIGN KEY (`prestamo_id`) REFERENCES `prestamos` (`id`),
  CONSTRAINT `logprestamos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logprestamos`
--

LOCK TABLES `logprestamos` WRITE;
/*!40000 ALTER TABLE `logprestamos` DISABLE KEYS */;
INSERT INTO `logprestamos` VALUES (1,'2021-11-12',3,NULL,1,1,'2021-11-12 17:54:15','2021-11-12 17:54:15'),(2,'2021-11-14',2,NULL,16,1,'2021-11-14 14:44:44','2021-11-14 14:44:44'),(3,'2021-11-16',6,NULL,22,1,'2021-11-16 17:31:08','2021-11-16 17:31:08'),(4,'2021-11-16',2,NULL,10,1,'2021-11-16 18:47:33','2021-11-16 18:47:33'),(5,'2021-11-16',1,NULL,18,1,'2021-11-16 20:28:48','2021-11-16 20:28:48');
/*!40000 ALTER TABLE `logprestamos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2021_08_09_162604_create_clientes_table',1),(6,'2021_08_09_163016_create_productos_table',1),(7,'2021_08_09_163133_create_ventas_table',1),(8,'2021_08_09_163313_create_inventarios_table',1),(9,'2021_08_09_163625_create_detalles_table',1),(10,'2021_08_09_163911_create_pagos_table',1),(11,'2021_08_09_164506_create_garantias_table',1),(12,'2021_08_11_195257_create_loginventarios_table',1),(13,'2021_08_12_190639_create_empleados_table',1),(14,'2021_08_12_190906_create_sueldos_table',1),(15,'2021_08_12_191634_create_gdetalles_table',1),(16,'2021_08_18_084424_create_gastos_table',1),(17,'2021_08_25_211109_create_prestamos_table',1),(18,'2021_08_25_211404_create_detalleprestamos_table',1),(19,'2021_08_31_101330_create_permisos_table',1),(20,'2021_08_31_110207_create_permiso_user_table',1),(21,'2021_10_21_095633_create_logprestamos_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagos`
--

DROP TABLE IF EXISTS `pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `monto` double(11,2) NOT NULL,
  `observacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pagos_venta_id_foreign` (`venta_id`),
  KEY `pagos_user_id_foreign` (`user_id`),
  CONSTRAINT `pagos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `pagos_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagos`
--

LOCK TABLES `pagos` WRITE;
/*!40000 ALTER TABLE `pagos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pagos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permiso_user`
--

DROP TABLE IF EXISTS `permiso_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permiso_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `permiso_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permiso_user_permiso_id_foreign` (`permiso_id`),
  KEY `permiso_user_user_id_foreign` (`user_id`),
  CONSTRAINT `permiso_user_permiso_id_foreign` FOREIGN KEY (`permiso_id`) REFERENCES `permisos` (`id`),
  CONSTRAINT `permiso_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permiso_user`
--

LOCK TABLES `permiso_user` WRITE;
/*!40000 ALTER TABLE `permiso_user` DISABLE KEYS */;
INSERT INTO `permiso_user` VALUES (1,1,1,NULL,NULL),(2,2,1,NULL,NULL),(3,3,1,NULL,NULL),(4,4,1,NULL,NULL),(5,5,1,NULL,NULL),(6,6,1,NULL,NULL),(7,7,1,NULL,NULL),(8,7,1,NULL,NULL),(9,8,1,NULL,NULL),(10,9,1,NULL,NULL),(11,10,1,NULL,NULL),(12,11,1,NULL,NULL),(13,12,1,NULL,NULL),(14,13,1,NULL,NULL),(15,14,1,NULL,NULL),(16,4,3,NULL,NULL),(17,5,3,NULL,NULL),(18,6,3,NULL,NULL),(19,11,3,NULL,NULL),(20,12,3,NULL,NULL);
/*!40000 ALTER TABLE `permiso_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permisos`
--

DROP TABLE IF EXISTS `permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permisos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos`
--

LOCK TABLES `permisos` WRITE;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
INSERT INTO `permisos` VALUES (1,'Controlar usuarios',NULL,NULL),(2,'Controlar clientes',NULL,NULL),(3,'Controlar productos',NULL,NULL),(4,'Controlar inventario',NULL,NULL),(5,'Venta detalle',NULL,NULL),(6,'Ver historial detalle',NULL,NULL),(7,'Venta local',NULL,NULL),(8,'Ver historial local',NULL,NULL),(9,'Controlar empleados',NULL,NULL),(10,'Reporte empleados',NULL,NULL),(11,'Controlar gastos',NULL,NULL),(12,'Historial prestamos',NULL,NULL),(13,'Historial venta',NULL,NULL),(14,'Historial Anular',NULL,NULL);
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',1,'auth_token','918296f0629f21b7c463af8bf1d7e689a5acdd89570d686a0e31814a3e07295e','[\"*\"]','2021-10-28 18:02:56','2021-10-25 12:08:45','2021-10-28 18:02:56'),(2,'App\\Models\\User',1,'auth_token','cafefc86378a6f4c659b332595383750f1e53c0145fb5d85678274010c5ca4a1','[\"*\"]','2021-10-25 19:59:30','2021-10-25 19:50:02','2021-10-25 19:59:30'),(3,'App\\Models\\User',1,'auth_token','170e8e7805da393f516f03ddf7fda83f3cf5c35c9eaef27beaf22b18dc6fdb25','[\"*\"]','2021-10-28 17:53:22','2021-10-28 17:18:10','2021-10-28 17:53:22'),(7,'App\\Models\\User',1,'auth_token','4b8a145e0ba71704eb659cec731f336fe1f029e9e9579f69dd2e46d9ea81dcd6','[\"*\"]','2021-11-14 17:03:22','2021-11-06 19:16:33','2021-11-14 17:03:22'),(8,'App\\Models\\User',1,'auth_token','be960e279f0f9fce6633d80b5adb0014ede5f60809d77a9d7e456a3bafca7bcb','[\"*\"]','2021-11-13 20:08:15','2021-11-12 17:02:04','2021-11-13 20:08:15'),(9,'App\\Models\\User',1,'auth_token','22a526c8cf9605a988f1c55b2ebd5e0d34ce3531b373025bf951dd8e2b17f088','[\"*\"]','2021-11-16 22:05:28','2021-11-14 17:35:29','2021-11-16 22:05:28');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestamos`
--

DROP TABLE IF EXISTS `prestamos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prestamos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL DEFAULT '2021-10-25',
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'EN PRESTAMO',
  `efectivo` double(11,2) DEFAULT 0.00,
  `fisico` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `observacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `cantidad` int(11) NOT NULL,
  `prestado` int(11) NOT NULL DEFAULT 0,
  `user_id` bigint(20) unsigned NOT NULL,
  `cliente_id` bigint(20) unsigned NOT NULL,
  `inventario_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prestamos_user_id_foreign` (`user_id`),
  KEY `prestamos_cliente_id_foreign` (`cliente_id`),
  KEY `prestamos_inventario_id_foreign` (`inventario_id`),
  CONSTRAINT `prestamos_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  CONSTRAINT `prestamos_inventario_id_foreign` FOREIGN KEY (`inventario_id`) REFERENCES `inventarios` (`id`),
  CONSTRAINT `prestamos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestamos`
--

LOCK TABLES `prestamos` WRITE;
/*!40000 ALTER TABLE `prestamos` DISABLE KEYS */;
INSERT INTO `prestamos` VALUES (1,'2021-10-27','DEVUELTO',90.00,NULL,NULL,3,0,1,17,1,'2021-10-27 15:57:10','2021-11-12 17:54:15'),(3,'2021-11-12','EN PRESTAMO',90.00,NULL,NULL,3,3,1,17,2,'2021-11-12 19:26:27','2021-11-12 19:26:27'),(4,'2021-11-12','EN PRESTAMO',20.00,NULL,NULL,1,1,1,27,2,'2021-11-12 19:33:40','2021-11-12 19:33:40'),(5,'2021-11-12','EN PRESTAMO',20.00,NULL,NULL,1,1,1,28,2,'2021-11-12 19:40:12','2021-11-12 19:40:12'),(6,'2021-11-12','EN PRESTAMO',100.00,NULL,NULL,5,5,1,29,2,'2021-11-12 19:41:38','2021-11-12 19:41:38'),(7,'2021-11-12','EN PRESTAMO',240.00,NULL,NULL,12,12,1,30,2,'2021-11-12 19:43:54','2021-11-12 19:43:54'),(8,'2021-11-12','EN PRESTAMO',200.00,NULL,NULL,1,1,1,31,1,'2021-11-12 19:51:39','2021-11-12 19:51:39'),(10,'2021-11-12','DEVUELTO',60.00,NULL,NULL,2,0,1,33,2,'2021-11-12 20:38:45','2021-11-16 18:47:33'),(11,'2021-11-12','EN PRESTAMO',20.00,NULL,NULL,1,1,1,34,2,'2021-11-12 21:29:58','2021-11-12 21:29:58'),(12,'2021-11-12','EN PRESTAMO',200.00,NULL,NULL,1,1,1,35,1,'2021-11-12 21:33:32','2021-11-12 21:33:32'),(14,'2021-11-12','EN PRESTAMO',20.00,NULL,NULL,1,1,1,37,2,'2021-11-12 21:42:29','2021-11-12 21:42:29'),(15,'2021-11-13','EN PRESTAMO',80.00,NULL,NULL,6,6,1,31,2,'2021-11-13 15:41:08','2021-11-13 15:41:08'),(16,'2021-11-13','DEVUELTO',30.00,NULL,NULL,2,0,1,1,2,'2021-11-13 15:41:43','2021-11-14 14:44:44'),(17,'2021-11-13','EN PRESTAMO',30.00,NULL,NULL,1,1,1,32,2,'2021-11-13 17:39:27','2021-11-13 17:39:27'),(18,'2021-11-13','DEVUELTO',300.00,NULL,NULL,1,0,1,36,1,'2021-11-13 17:58:36','2021-11-16 20:28:48'),(19,'2021-11-13','EN PRESTAMO',NULL,NULL,NULL,1,1,1,38,2,'2021-11-13 19:40:15','2021-11-13 19:40:15'),(20,'2021-11-13','EN PRESTAMO',NULL,NULL,NULL,3,3,1,39,2,'2021-11-13 19:41:37','2021-11-13 19:41:37'),(21,'2021-11-14','EN PRESTAMO',20.00,NULL,NULL,1,1,1,40,2,'2021-11-14 14:32:48','2021-11-14 14:32:48'),(22,'2021-11-14','DEVUELTO',120.00,NULL,NULL,6,0,1,41,2,'2021-11-14 17:49:10','2021-11-16 17:31:08'),(23,'2021-11-15','EN PRESTAMO',100.00,NULL,NULL,2,2,1,42,2,'2021-11-15 19:42:49','2021-11-15 19:42:49'),(24,'2021-11-16','EN PRESTAMO',20.00,NULL,NULL,1,1,1,43,2,'2021-11-16 17:34:21','2021-11-16 17:34:21');
/*!40000 ALTER TABLE `prestamos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `precio` double(11,2) DEFAULT 0.00,
  `observacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'LOCAL',
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'ACTIVO',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'LITRO',5.00,NULL,'DETALLE','ACTIVO','2021-10-25 12:14:11','2021-10-25 12:14:11'),(2,'VALDE',25.00,NULL,'DETALLE','ACTIVO','2021-10-25 12:15:05','2021-10-25 12:15:05'),(3,'BIDON BLANCO PEQUEÑO',30.00,NULL,'DETALLE','ACTIVO','2021-10-25 12:20:54','2021-10-25 12:20:54'),(4,'1/2 BIDON',50.00,'10 LITROS','DETALLE','ACTIVO','2021-10-25 12:23:01','2021-10-25 12:23:01'),(5,'BIDON',100.00,NULL,'DETALLE','ACTIVO','2021-10-25 12:27:30','2021-10-25 12:27:30'),(6,'1/4 TURRIL',240.00,NULL,'DETALLE','ACTIVO','2021-10-25 12:27:59','2021-10-25 12:27:59'),(7,'1/2 TURRIL',450.00,NULL,'DETALLE','ACTIVO','2021-10-25 12:28:30','2021-10-25 12:28:30'),(8,'3/4 TURRIL',690.00,NULL,'DETALLE','ACTIVO','2021-10-25 12:28:59','2021-10-25 12:28:59'),(9,'1 TURRIL',900.00,NULL,'DETALLE','ACTIVO','2021-10-25 12:29:27','2021-10-25 12:29:27'),(10,'BORRA',20.00,NULL,'DETALLE','ACTIVO','2021-10-25 12:30:08','2021-10-25 12:30:08'),(11,'LATAS',7.00,NULL,'DETALLE','ACTIVO','2021-10-25 12:30:24','2021-10-25 12:30:24'),(12,'BIDON VACIO',20.00,NULL,'DETALLE','ACTIVO','2021-10-25 12:30:56','2021-10-25 12:30:56'),(13,'CANTARITO',30.00,NULL,'DETALLE','ACTIVO','2021-10-27 13:48:36','2021-10-27 13:48:36'),(14,'TUTUMA',5.00,NULL,'DETALLE','ACTIVO','2021-10-27 13:48:52','2021-10-27 13:48:52'),(15,'1/2 BORRA',10.00,NULL,'DETALLE','ACTIVO','2021-11-11 20:08:47','2021-11-11 20:08:47'),(16,'1/2 TURRIL',400.00,NULL,'LOCAL','ACTIVO','2021-11-12 19:19:03','2021-11-12 19:19:03');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sueldos`
--

DROP TABLE IF EXISTS `sueldos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sueldos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `monto` double(11,2) NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `obervacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `empleado_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sueldos_empleado_id_foreign` (`empleado_id`),
  KEY `sueldos_user_id_foreign` (`user_id`),
  CONSTRAINT `sueldos_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`),
  CONSTRAINT `sueldos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sueldos`
--

LOCK TABLES `sueldos` WRITE;
/*!40000 ALTER TABLE `sueldos` DISABLE KEYS */;
/*!40000 ALTER TABLE `sueldos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechalimite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','9999-12-31','admin@test.com',NULL,'$2y$10$iYijZIA3cfxPoxi.k1zQeOdeM6y5ZOBHUsiPrt9WPBDkTI0fkuX2W',NULL,NULL,NULL),(3,'casa','2030-01-13','casa@naty.com',NULL,'$2y$10$mnQkKU0Ihylk/qUEdRwgeuXAdMxDkb9qv5jI9rDZBuVx6uJ.qVg2K',NULL,'2021-11-06 19:11:03','2021-11-06 19:11:03');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ventas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `total` double(11,2) DEFAULT NULL,
  `acuenta` double(11,2) DEFAULT NULL,
  `saldo` double(11,2) DEFAULT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `turno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `hora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `fechaentrega` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `telefono1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `telefono2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `envase` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `observacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NINGUNO',
  `user_id` bigint(20) unsigned NOT NULL,
  `cliente_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ventas_user_id_foreign` (`user_id`),
  KEY `ventas_cliente_id_foreign` (`cliente_id`),
  CONSTRAINT `ventas_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  CONSTRAINT `ventas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
INSERT INTO `ventas` VALUES (1,'2021-10-25',240.00,240.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,3,'2021-10-25 12:41:26','2021-10-25 12:41:26'),(2,'2021-10-25',84.00,84.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,4,'2021-10-25 13:11:01','2021-10-25 13:11:01'),(3,'2021-10-25',100.00,100.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,5,'2021-10-25 15:40:13','2021-10-25 15:40:13'),(4,'2021-10-25',200.00,200.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-10-25 16:47:33','2021-10-25 16:47:33'),(5,'2021-10-25',80.00,80.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,10,'2021-10-25 17:55:58','2021-10-25 17:55:58'),(6,'2021-10-27',105.00,105.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,11,'2021-10-27 12:22:36','2021-10-27 12:22:36'),(7,'2021-10-27',100.00,100.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,12,'2021-10-27 12:24:11','2021-10-27 12:24:11'),(8,'2021-10-27',0.00,0.00,0.00,'ANULADO','DETALLE','','','','','','','','modificacion de compra de 1/4 turril a1/2 turril',1,13,'2021-10-27 13:42:48','2021-10-27 13:53:00'),(9,'2021-10-27',30.00,30.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,14,'2021-10-27 13:50:05','2021-10-27 13:50:05'),(10,'2021-10-27',450.00,450.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,13,'2021-10-27 13:53:23','2021-10-27 13:53:23'),(11,'2021-10-27',0.00,0.00,0.00,'ANULADO','DETALLE','','','','','','','','modificacion  de precio de compra de 30 a 240',1,15,'2021-10-27 14:01:06','2021-10-27 14:19:34'),(12,'2021-10-27',30.00,30.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,15,'2021-10-27 14:02:34','2021-10-27 14:02:34'),(13,'2021-10-27',20.00,20.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,14,'2021-10-27 14:15:51','2021-10-27 14:15:51'),(14,'2021-10-27',240.00,240.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,15,'2021-10-27 14:22:24','2021-10-27 14:22:24'),(15,'2021-10-27',100.00,100.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,16,'2021-10-27 14:25:37','2021-10-27 14:25:37'),(16,'2021-10-27',240.00,240.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,17,'2021-10-27 15:56:14','2021-10-27 15:56:14'),(17,'2021-10-28',200.00,200.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,18,'2021-10-28 11:24:35','2021-10-28 11:24:35'),(18,'2021-10-28',40.00,40.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,18,'2021-10-28 11:25:15','2021-10-28 11:25:15'),(19,'2021-10-28',240.00,240.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,3,'2021-10-28 13:02:56','2021-10-28 13:02:56'),(20,'2021-10-28',20.00,20.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-10-28 13:03:33','2021-10-28 13:03:33'),(21,'2021-10-28',240.00,240.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,3,'2021-10-28 13:04:55','2021-10-28 13:04:55'),(22,'2021-10-28',15.00,15.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,3,'2021-10-28 13:05:36','2021-10-28 13:05:36'),(23,'2021-10-28',100.00,100.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,19,'2021-10-28 13:17:00','2021-10-28 13:17:00'),(24,'2021-10-28',10.00,10.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,20,'2021-10-28 14:03:06','2021-10-28 14:03:06'),(25,'2021-10-28',240.00,240.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,21,'2021-10-28 14:12:09','2021-10-28 14:12:09'),(26,'2021-10-28',30.00,30.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,21,'2021-10-28 14:15:45','2021-10-28 14:15:45'),(27,'2021-10-28',20.00,20.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,21,'2021-10-28 14:16:24','2021-10-28 14:16:24'),(28,'2021-10-28',50.00,50.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,22,'2021-10-28 14:29:59','2021-10-28 14:29:59'),(29,'2021-10-28',25.00,25.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,23,'2021-10-28 14:33:51','2021-10-28 14:33:51'),(30,'2021-10-28',75.00,75.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,24,'2021-10-28 15:00:36','2021-10-28 15:00:36'),(31,'2021-10-28',50.00,50.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,25,'2021-10-28 16:47:28','2021-10-28 16:47:28'),(32,'2021-10-28',133.00,133.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-10-28 17:52:12','2021-10-28 17:52:12'),(33,'2021-11-06',126.00,126.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-06 20:48:38','2021-11-06 20:48:38'),(34,'2021-11-06',25.00,25.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-06 20:49:04','2021-11-06 20:49:04'),(35,'2021-11-06',50.00,50.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-06 20:49:48','2021-11-06 20:49:48'),(36,'2021-11-06',100.00,100.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-06 20:50:11','2021-11-06 20:50:11'),(37,'2021-11-06',50.00,50.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-06 20:50:39','2021-11-06 20:50:39'),(38,'2021-11-06',100.00,100.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-06 22:00:45','2021-11-06 22:00:45'),(39,'2021-11-11',50.00,50.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-11 20:05:52','2021-11-11 20:05:52'),(40,'2021-11-11',30.00,30.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-11 20:06:27','2021-11-11 20:06:27'),(41,'2021-11-11',40.00,40.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-11 20:08:12','2021-11-11 20:08:12'),(42,'2021-11-11',10.00,10.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-11 20:09:17','2021-11-11 20:09:17'),(43,'2021-11-11',100.00,100.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-11 21:38:52','2021-11-11 21:38:52'),(44,'2021-11-11',20.00,20.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-11 21:41:39','2021-11-11 21:41:39'),(45,'2021-11-12',0.00,0.00,0.00,'ANULADO','DETALLE','mañana','10:00','2021-11-13','70344117','74158178','X','no','verificacion del sistema',1,1,'2021-11-12 17:45:07','2021-11-12 18:15:57'),(46,'2021-11-12',200.00,200.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-12 18:24:25','2021-11-12 18:24:25'),(47,'2021-11-12',203.00,203.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-12 18:37:01','2021-11-12 18:37:01'),(48,'2021-11-12',400.00,400.00,0.00,'CANCELADO','LOCAL','','','','','','','','NINGUNO',1,26,'2021-11-12 19:19:38','2021-11-12 19:19:38'),(49,'2021-11-12',450.00,450.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,31,'2021-11-12 19:50:31','2021-11-12 19:50:31'),(50,'2021-11-12',50.00,50.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,31,'2021-11-12 19:54:28','2021-11-12 19:54:28'),(51,'2021-11-12',240.00,240.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,32,'2021-11-12 20:06:12','2021-11-12 20:06:12'),(52,'2021-11-12',15.00,15.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,31,'2021-11-12 20:12:57','2021-11-12 20:12:57'),(53,'2021-11-12',0.00,0.00,0.00,'ANULADO','DETALLE','','','','','','','','renovacion de compra a medio turrill',1,9,'2021-11-12 20:30:24','2021-11-12 20:36:50'),(54,'2021-11-12',0.00,0.00,0.00,'ANULADO','DETALLE','','','','','','','','renovacon de compra',1,9,'2021-11-12 20:30:40','2021-11-12 20:37:09'),(55,'2021-11-12',450.00,450.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,33,'2021-11-12 20:38:18','2021-11-12 20:38:18'),(56,'2021-11-13',25.00,25.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-13 13:27:45','2021-11-13 13:27:45'),(57,'2021-11-13',200.00,200.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-13 17:17:23','2021-11-13 17:17:23'),(58,'2021-11-13',25.00,25.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-13 17:17:48','2021-11-13 17:17:48'),(59,'2021-11-13',100.00,100.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-13 17:32:27','2021-11-13 17:32:27'),(60,'2021-11-13',25.00,25.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-13 17:32:55','2021-11-13 17:32:55'),(61,'2021-11-13',25.00,25.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-13 17:33:15','2021-11-13 17:33:15'),(62,'2021-11-13',10.00,10.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-13 17:33:49','2021-11-13 17:33:49'),(63,'2021-11-14',450.00,450.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-14 14:30:10','2021-11-14 14:30:10'),(64,'2021-11-14',100.00,100.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,40,'2021-11-14 14:32:27','2021-11-14 14:32:27'),(65,'2021-11-14',100.00,100.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-14 14:59:27','2021-11-14 14:59:27'),(66,'2021-11-14',20.00,20.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-14 14:59:45','2021-11-14 14:59:45'),(67,'2021-11-14',100.00,100.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-14 15:10:13','2021-11-14 15:10:13'),(68,'2021-11-14',75.00,75.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-14 16:10:00','2021-11-14 16:10:00'),(69,'2021-11-14',200.00,200.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-14 16:40:18','2021-11-14 16:40:18'),(70,'2021-11-14',30.00,30.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-14 17:03:17','2021-11-14 17:03:17'),(71,'2021-11-14',25.00,25.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-14 17:36:37','2021-11-14 17:36:37'),(72,'2021-11-14',400.00,400.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,41,'2021-11-14 17:48:47','2021-11-14 17:48:47'),(73,'2021-11-14',450.00,450.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-14 17:50:03','2021-11-14 17:50:03'),(74,'2021-11-14',100.00,100.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-14 18:32:51','2021-11-14 18:32:51'),(75,'2021-11-14',100.00,100.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-14 19:43:29','2021-11-14 19:43:29'),(76,'2021-11-14',50.00,50.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,9,'2021-11-14 19:43:48','2021-11-14 19:43:48'),(77,'2021-11-15',200.00,200.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,42,'2021-11-15 19:42:22','2021-11-15 19:42:22'),(78,'2021-11-15',140.00,140.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-15 19:43:25','2021-11-15 19:43:25'),(79,'2021-11-15',357.00,357.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-15 19:44:13','2021-11-15 19:44:13'),(80,'2021-11-15',450.00,450.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-15 19:44:41','2021-11-15 19:44:41'),(81,'2021-11-16',200.00,200.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-16 17:25:20','2021-11-16 17:25:20'),(82,'2021-11-16',240.00,240.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,43,'2021-11-16 17:34:01','2021-11-16 17:34:01'),(83,'2021-11-16',50.00,50.00,0.00,'CANCELADO','DETALLE','','','','','','','','NINGUNO',1,1,'2021-11-16 17:56:43','2021-11-16 17:56:43'),(84,'2021-11-16',0.00,0.00,0.00,'ANULADO','DETALLE','','','','','','','','prueba del sistema',1,1,'2021-11-16 19:46:44','2021-11-16 19:47:19'),(85,'2021-11-16',0.00,0.00,0.00,'ANULADO','DETALLE','','','','','','','','prueba del sistema',1,1,'2021-11-16 19:49:59','2021-11-16 19:51:17'),(86,'2021-11-16',0.00,0.00,0.00,'ANULADO','DETALLE','','','','','','','','prueva de sistema',1,1,'2021-11-16 19:52:08','2021-11-16 19:55:25');
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-17  9:05:17
