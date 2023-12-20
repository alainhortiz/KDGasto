-- MySQL dump 10.13  Distrib 5.6.23, for Win32 (x86)
--
-- Host: localhost    Database: kdgasto
-- ------------------------------------------------------
-- Server version	5.7.26

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
-- Table structure for table `concepto_gasto`
--

DROP TABLE IF EXISTS `concepto_gasto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `concepto_gasto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `precioCosto` decimal(18,2) NOT NULL,
  `fechaInicio` date DEFAULT NULL,
  `fechaFinal` date DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `concepto_gasto`
--

LOCK TABLES `concepto_gasto` WRITE;
/*!40000 ALTER TABLE `concepto_gasto` DISABLE KEYS */;
/*!40000 ALTER TABLE `concepto_gasto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ficha_costo`
--

DROP TABLE IF EXISTS `ficha_costo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ficha_costo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `precioCosto` decimal(18,2) NOT NULL,
  `precioVenta` decimal(18,2) NOT NULL,
  `fechaCreada` date DEFAULT NULL,
  `fechaModificada` date DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `concepto_gasto_id` int(11) DEFAULT NULL,
  `venta_producto_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_35D3C5CB7645698E` (`producto_id`),
  KEY `IDX_35D3C5CB79EED498` (`concepto_gasto_id`),
  KEY `IDX_35D3C5CB95B1A75B` (`venta_producto_id`),
  CONSTRAINT `FK_35D3C5CB7645698E` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`),
  CONSTRAINT `FK_35D3C5CB79EED498` FOREIGN KEY (`concepto_gasto_id`) REFERENCES `concepto_gasto` (`id`),
  CONSTRAINT `FK_35D3C5CB95B1A75B` FOREIGN KEY (`venta_producto_id`) REFERENCES `venta_producto` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ficha_costo`
--

LOCK TABLES `ficha_costo` WRITE;
/*!40000 ALTER TABLE `ficha_costo` DISABLE KEYS */;
/*!40000 ALTER TABLE `ficha_costo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modalidad_pago`
--

DROP TABLE IF EXISTS `modalidad_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modalidad_pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modalidad_pago`
--

LOCK TABLES `modalidad_pago` WRITE;
/*!40000 ALTER TABLE `modalidad_pago` DISABLE KEYS */;
/*!40000 ALTER TABLE `modalidad_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nivel_acceso`
--

DROP TABLE IF EXISTS `nivel_acceso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nivel_acceso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nivel` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8DFF1AE2AAFC20CB` (`nivel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nivel_acceso`
--

LOCK TABLES `nivel_acceso` WRITE;
/*!40000 ALTER TABLE `nivel_acceso` DISABLE KEYS */;
/*!40000 ALTER TABLE `nivel_acceso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_modalidad_pago`
--

DROP TABLE IF EXISTS `producto_modalidad_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto_modalidad_pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `venta_producto_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `importePagado` decimal(18,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D83D25C595B1A75B` (`venta_producto_id`),
  KEY `IDX_D83D25C5DB38439E` (`usuario_id`),
  CONSTRAINT `FK_D83D25C595B1A75B` FOREIGN KEY (`venta_producto_id`) REFERENCES `venta_producto` (`id`),
  CONSTRAINT `FK_D83D25C5DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_modalidad_pago`
--

LOCK TABLES `producto_modalidad_pago` WRITE;
/*!40000 ALTER TABLE `producto_modalidad_pago` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto_modalidad_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_57698A6A3A909126` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `traza`
--

DROP TABLE IF EXISTS `traza`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `traza` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `operacion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `traza`
--

LOCK TABLES `traza` WRITE;
/*!40000 ALTER TABLE `traza` DISABLE KEYS */;
/*!40000 ALTER TABLE `traza` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `primerApellido` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `segundoApellido` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fechaFinClave` date NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2265B05DF85E0677` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_nivel_acceso`
--

DROP TABLE IF EXISTS `usuario_nivel_acceso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_nivel_acceso` (
  `usuario_id` int(11) NOT NULL,
  `nivel_acceso_id` int(11) NOT NULL,
  PRIMARY KEY (`usuario_id`,`nivel_acceso_id`),
  KEY `IDX_87C79F37DB38439E` (`usuario_id`),
  KEY `IDX_87C79F375108D425` (`nivel_acceso_id`),
  CONSTRAINT `FK_87C79F375108D425` FOREIGN KEY (`nivel_acceso_id`) REFERENCES `nivel_acceso` (`id`),
  CONSTRAINT `FK_87C79F37DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_nivel_acceso`
--

LOCK TABLES `usuario_nivel_acceso` WRITE;
/*!40000 ALTER TABLE `usuario_nivel_acceso` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario_nivel_acceso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_role`
--

DROP TABLE IF EXISTS `usuario_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_role` (
  `usuario_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`usuario_id`,`role_id`),
  KEY `IDX_3E13F07ADB38439E` (`usuario_id`),
  KEY `IDX_3E13F07AD60322AC` (`role_id`),
  CONSTRAINT `FK_3E13F07AD60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  CONSTRAINT `FK_3E13F07ADB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_role`
--

LOCK TABLES `usuario_role` WRITE;
/*!40000 ALTER TABLE `usuario_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta_producto`
--

DROP TABLE IF EXISTS `venta_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venta_producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `precioTotalCosto` decimal(18,2) NOT NULL,
  `precioTotalVenta` decimal(18,2) NOT NULL,
  `isPagado` tinyint(1) NOT NULL,
  `fechaPago` date DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `modalidad_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E054E8BDB38439E` (`usuario_id`),
  KEY `IDX_E054E8B1E092B9F` (`modalidad_id`),
  CONSTRAINT `FK_E054E8B1E092B9F` FOREIGN KEY (`modalidad_id`) REFERENCES `modalidad_pago` (`id`),
  CONSTRAINT `FK_E054E8BDB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta_producto`
--

LOCK TABLES `venta_producto` WRITE;
/*!40000 ALTER TABLE `venta_producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta_producto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-09-18 21:56:22
