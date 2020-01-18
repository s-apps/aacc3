-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: localhost    Database: aacc3
-- ------------------------------------------------------
-- Server version	5.7.29

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
-- Table structure for table `atividade`
--

DROP TABLE IF EXISTS `atividade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atividade` (
  `atividade_id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(11) NOT NULL DEFAULT '0',
  `modalidade_id` int(11) NOT NULL DEFAULT '0',
  `comprovante_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `atividade` text CHARACTER SET latin1 NOT NULL,
  `carga_horaria` time NOT NULL,
  `validacao` int(11) NOT NULL DEFAULT '0' COMMENT '0 = Aguardando validação, 1 = Valido',
  `imagem_comprovante` varchar(255) CHARACTER SET latin1 NOT NULL,
  `horas_inicio` time NOT NULL,
  `horas_termino` time NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`atividade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin5;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atividade`
--

LOCK TABLES `atividade` WRITE;
/*!40000 ALTER TABLE `atividade` DISABLE KEYS */;
/*!40000 ALTER TABLE `atividade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aviso`
--

DROP TABLE IF EXISTS `aviso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aviso` (
  `titulo` varchar(100) NOT NULL,
  `aviso` text NOT NULL,
  `aviso_id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  PRIMARY KEY (`aviso_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aviso`
--

LOCK TABLES `aviso` WRITE;
/*!40000 ALTER TABLE `aviso` DISABLE KEYS */;
/*!40000 ALTER TABLE `aviso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `categoria_id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` text NOT NULL,
  PRIMARY KEY (`categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comprovante`
--

DROP TABLE IF EXISTS `comprovante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comprovante` (
  `comprovante_id` int(11) NOT NULL AUTO_INCREMENT,
  `comprovante` text NOT NULL,
  PRIMARY KEY (`comprovante_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comprovante`
--

LOCK TABLES `comprovante` WRITE;
/*!40000 ALTER TABLE `comprovante` DISABLE KEYS */;
/*!40000 ALTER TABLE `comprovante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `config_id` varchar(100) NOT NULL,
  `limite_atividades` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES ('default',40);
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `curso`
--

DROP TABLE IF EXISTS `curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `curso` (
  `curso_id` int(11) NOT NULL AUTO_INCREMENT,
  `curso` tinytext NOT NULL,
  PRIMARY KEY (`curso_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curso`
--

LOCK TABLES `curso` WRITE;
/*!40000 ALTER TABLE `curso` DISABLE KEYS */;
/*!40000 ALTER TABLE `curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modalidade`
--

DROP TABLE IF EXISTS `modalidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modalidade` (
  `modalidade_id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(11) NOT NULL,
  `comprovante_id` int(11) NOT NULL,
  `modalidade` text NOT NULL,
  `min_horas` time NOT NULL,
  `max_horas` time NOT NULL,
  PRIMARY KEY (`modalidade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modalidade`
--

LOCK TABLES `modalidade` WRITE;
/*!40000 ALTER TABLE `modalidade` DISABLE KEYS */;
/*!40000 ALTER TABLE `modalidade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `professor_leciona`
--

DROP TABLE IF EXISTS `professor_leciona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `professor_leciona` (
  `professor_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  PRIMARY KEY (`professor_id`,`curso_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professor_leciona`
--

LOCK TABLES `professor_leciona` WRITE;
/*!40000 ALTER TABLE `professor_leciona` DISABLE KEYS */;
/*!40000 ALTER TABLE `professor_leciona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `curso_id` int(11) DEFAULT '0',
  `nome` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `senha_temp` varchar(255) DEFAULT NULL,
  `usuario_ra` varchar(45) DEFAULT 'null',
  `nivel` int(1) NOT NULL COMMENT '0 = admin/professor, 1 = aluno',
  PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,NULL,'admin','admin@admin.com','$2y$10$zPAZ4eDoElyxJvmJMm1oSuwdezXNNgaS.rM9h6eYflkWG2JHQ1kga','','',0),(4,1,'Silvério','contato@silverio.eti.br','$2y$10$jugq8iDNlIg093htkBdUOOLvZ0Y2T6FHWryjG./Z0v7MbF6b7PjJS',NULL,'ra123',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'aacc3'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-18 14:52:13
