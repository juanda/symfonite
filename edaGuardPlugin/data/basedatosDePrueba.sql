-- MySQL dump 10.13  Distrib 5.1.54, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: symfonite
-- ------------------------------------------------------
-- Server version	5.1.54-1ubuntu4

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
-- Table structure for table `eda_acceso_ambito`
--

DROP TABLE IF EXISTS `eda_acceso_ambito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_acceso_ambito` (
  `id_acceso` int(11) NOT NULL,
  `id_ambito` int(11) NOT NULL,
  `fechainicio` date DEFAULT NULL,
  `fechafin` date DEFAULT NULL,
  `fechacaducidad` date DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'ACTIVO',
  PRIMARY KEY (`id_acceso`,`id_ambito`),
  KEY `id_acceso` (`id_acceso`),
  KEY `id_ambito` (`id_ambito`),
  CONSTRAINT `eda_acceso_ambito_FK_1` FOREIGN KEY (`id_acceso`) REFERENCES `eda_accesos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `eda_acceso_ambito_FK_2` FOREIGN KEY (`id_ambito`) REFERENCES `eda_ambitos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_acceso_ambito`
--

LOCK TABLES `eda_acceso_ambito` WRITE;
/*!40000 ALTER TABLE `eda_acceso_ambito` DISABLE KEYS */;
INSERT INTO `eda_acceso_ambito` VALUES (2,7,NULL,NULL,NULL,'ACTIVO'),(3,8,NULL,NULL,NULL,'ACTIVO'),(4,10,NULL,NULL,NULL,'ACTIVO'),(4,12,NULL,NULL,NULL,'ACTIVO'),(8,1,NULL,NULL,NULL,'ACTIVO'),(8,2,NULL,NULL,NULL,'ACTIVO'),(8,6,NULL,NULL,NULL,'ACTIVO'),(11,4,NULL,NULL,NULL,'ACTIVO'),(12,2,NULL,NULL,NULL,'ACTIVO'),(12,6,NULL,NULL,NULL,'ACTIVO'),(13,5,NULL,NULL,NULL,'ACTIVO'),(13,6,NULL,NULL,NULL,'ACTIVO');
/*!40000 ALTER TABLE `eda_acceso_ambito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_accesos`
--

DROP TABLE IF EXISTS `eda_accesos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_accesos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_perfil` int(11) DEFAULT NULL,
  `delega` tinyint(4) DEFAULT '0',
  `id_delega` int(11) DEFAULT NULL,
  `esinicial` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_perfil` (`id_perfil`),
  KEY `id_delega` (`id_delega`),
  CONSTRAINT `eda_accesos_FK_1` FOREIGN KEY (`id_usuario`) REFERENCES `eda_usuarios` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `eda_accesos_FK_2` FOREIGN KEY (`id_perfil`) REFERENCES `eda_perfiles` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `eda_accesos_FK_3` FOREIGN KEY (`id_delega`) REFERENCES `eda_accesos` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_accesos`
--

LOCK TABLES `eda_accesos` WRITE;
/*!40000 ALTER TABLE `eda_accesos` DISABLE KEYS */;
INSERT INTO `eda_accesos` VALUES (1,1,1,0,NULL,1),(2,1,2,0,NULL,0),(3,2,2,0,NULL,0),(4,2,3,0,NULL,0),(5,2,9,0,NULL,0),(6,3,8,0,NULL,0),(7,3,9,0,NULL,0),(8,3,4,0,NULL,0),(9,4,7,0,NULL,0),(10,4,8,0,NULL,0),(11,4,4,0,NULL,0),(12,5,5,0,NULL,0),(13,6,5,0,NULL,0);
/*!40000 ALTER TABLE `eda_accesos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_ambitos`
--

DROP TABLE IF EXISTS `eda_ambitos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_ambitos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ambitotipo` int(11) DEFAULT NULL,
  `id_periodo` int(11) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'ACTIVO',
  PRIMARY KEY (`id`),
  KEY `id_ambitotipo` (`id_ambitotipo`),
  KEY `id_periodo` (`id_periodo`),
  CONSTRAINT `eda_ambitos_FK_1` FOREIGN KEY (`id_ambitotipo`) REFERENCES `eda_ambitostipos` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `eda_ambitos_FK_2` FOREIGN KEY (`id_periodo`) REFERENCES `eda_periodos` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_ambitos`
--

LOCK TABLES `eda_ambitos` WRITE;
/*!40000 ALTER TABLE `eda_ambitos` DISABLE KEYS */;
INSERT INTO `eda_ambitos` VALUES (1,1,2,'pres','ACTIVO'),(2,1,3,'pres2','ACTIVO'),(3,1,2,'moral','ACTIVO'),(4,1,3,'moral','ACTIVO'),(5,1,3,'capi','ACTIVO'),(6,1,3,'bio','ACTIVO'),(7,3,1,'serweb','ACTIVO'),(8,3,1,'serco','ACTIVO'),(9,3,1,'elec','ACTIVO'),(10,2,1,'platedu','ACTIVO'),(11,2,1,'cont','ACTIVO'),(12,2,1,'mens','ACTIVO');
/*!40000 ALTER TABLE `eda_ambitos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_ambitos_i18n`
--

DROP TABLE IF EXISTS `eda_ambitos_i18n`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_ambitos_i18n` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `id_cultura` char(5) NOT NULL,
  PRIMARY KEY (`id`,`id_cultura`),
  KEY `id_cultura` (`id_cultura`),
  CONSTRAINT `eda_ambitos_i18n_FK_1` FOREIGN KEY (`id`) REFERENCES `eda_ambitos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_ambitos_i18n`
--

LOCK TABLES `eda_ambitos_i18n` WRITE;
/*!40000 ALTER TABLE `eda_ambitos_i18n` DISABLE KEYS */;
INSERT INTO `eda_ambitos_i18n` VALUES (1,'','','en_GB'),(1,'Los presocráticos','','es_ES'),(2,'','','en_GB'),(2,'Los presocráticos','','es_ES'),(3,'','','en_GB'),(3,'La moral en Kant','','es_ES'),(4,'','','en_GB'),(4,'La moral en Kant','','es_ES'),(5,'','','en_GB'),(5,'Iniciación al Capital de Karl Marx','','es_ES'),(6,'','','en_GB'),(6,'Bioética','','es_ES'),(7,'','','en_GB'),(7,'Servidores Web','','es_ES'),(8,'','','en_GB'),(8,'Servidores de correo','','es_ES'),(9,'','','en_GB'),(9,'Electrónica de red','','es_ES'),(10,'','','en_GB'),(10,'Plataforma educativa','','es_ES'),(11,'','','en_GB'),(11,'Programa de contabilidad','','es_ES'),(12,'','','en_GB'),(12,'Mensajería Interna','','es_ES');
/*!40000 ALTER TABLE `eda_ambitos_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_ambitostipos`
--

DROP TABLE IF EXISTS `eda_ambitostipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_ambitostipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_ambitostipos`
--

LOCK TABLES `eda_ambitostipos` WRITE;
/*!40000 ALTER TABLE `eda_ambitostipos` DISABLE KEYS */;
INSERT INTO `eda_ambitostipos` VALUES (1,'Cursos',''),(2,'Proyectos',''),(3,'Áreas','');
/*!40000 ALTER TABLE `eda_ambitostipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_aplicacion_sesiones`
--

DROP TABLE IF EXISTS `eda_aplicacion_sesiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_aplicacion_sesiones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_aplicacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expira` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_aplicacion` (`id_aplicacion`),
  CONSTRAINT `eda_aplicacion_sesiones_FK_1` FOREIGN KEY (`id_aplicacion`) REFERENCES `eda_aplicaciones` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `eda_aplicacion_sesiones_FK_2` FOREIGN KEY (`id_usuario`) REFERENCES `eda_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_aplicacion_sesiones`
--

LOCK TABLES `eda_aplicacion_sesiones` WRITE;
/*!40000 ALTER TABLE `eda_aplicacion_sesiones` DISABLE KEYS */;
INSERT INTO `eda_aplicacion_sesiones` VALUES (1,2,1,'27468401e9f33ee','2011-06-20 09:38:42');
/*!40000 ALTER TABLE `eda_aplicacion_sesiones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_aplicaciones`
--

DROP TABLE IF EXISTS `eda_aplicaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_aplicaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `logotipo` varchar(255) DEFAULT NULL,
  `url` varchar(250) NOT NULL,
  `url_svn` varchar(255) DEFAULT NULL,
  `clave` varchar(20) NOT NULL,
  `id_credencial` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `sf_app` varchar(255) DEFAULT NULL,
  `texto_intro` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clave` (`clave`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `id_credencial` (`id_credencial`),
  CONSTRAINT `eda_aplicaciones_FK_1` FOREIGN KEY (`id_credencial`) REFERENCES `eda_credenciales` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_aplicaciones`
--

LOCK TABLES `eda_aplicaciones` WRITE;
/*!40000 ALTER TABLE `eda_aplicaciones` DISABLE KEYS */;
INSERT INTO `eda_aplicaciones` VALUES (1,'GestionEDAE3','Administración de la plataforma','Administración del Núcleo',NULL,'http://localhost/symfonite/web/backend_dev.php','','cambiar',1,'2011-06-20 09:31:00','2011-06-20 09:31:00','backend','<p>Esta aplicación permite administrar toda la estructura de organizativa de tu centro:</p><ul><li>Las Unidades Organizativas (departamentos, por ejemplo)</li><li>Los perfiles asociados a cada unidad (administradores, contables, profesores ...)</li><li>Los ámbitos de trabajo de cada perfil (cursos para los profesores, por ejemplo)</li><li>Los periodos de funcionamiento (ejercicios académicos, por ejemplo)</li></ul><br/><p>También sirve para registrar las aplicaciones que se acoplen al sistema, para asociarlas a los perfiles que las necesiten y para construir sus menús.</p><p>Y por último, puedes gestionar tus usuarios asignándoles los perfiles que precisen.</p><p>Puedes cambiar este mensaje de introducción a través del menú <i>Aplicaciones</i> de esta misma aplicación.</p>'),(2,'catalogacion','Catalogación de recursos educativos','Aplicación para la catalogación de los recursos educativos de La Madraza',NULL,'http://localhost/symfonite/web/cat_dev.php','','6ec1a15ea190c00',4,'2011-06-20 09:33:49','2011-06-20 09:33:50','',''),(3,'Mensajeria','Mensajería Interna','',NULL,'http://localhost/symfonite/web/mensajeria_dev.php','','036ef21deaa97f5',5,'2011-06-20 10:17:12','2011-06-20 10:17:12','',''),(4,'Contabilidad','Contabilidad','',NULL,'http://localhost/symfonite/web/contabilidad_dev.php','','c9e3d9d879f45c4',6,'2011-06-20 10:17:42','2011-06-20 10:17:42','',''),(5,'PlatEdu','Plataforma educativa','',NULL,'http://localhost/symfonite/web/platedu_dev.php','','66c45f2e9a2b7ee',7,'2011-06-20 10:19:00','2011-06-20 10:19:00','platedu','');
/*!40000 ALTER TABLE `eda_aplicaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_confpersonales`
--

DROP TABLE IF EXISTS `eda_confpersonales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_confpersonales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_aplicacion` int(11) NOT NULL,
  `id_periodo` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `id_ambito` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_aplicacion` (`id_aplicacion`),
  KEY `id_periodo` (`id_periodo`),
  KEY `id_perfil` (`id_perfil`),
  KEY `id_ambito` (`id_ambito`),
  CONSTRAINT `eda_confpersonales_FK_1` FOREIGN KEY (`id_usuario`) REFERENCES `eda_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `eda_confpersonales_FK_2` FOREIGN KEY (`id_aplicacion`) REFERENCES `eda_aplicaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `eda_confpersonales_FK_3` FOREIGN KEY (`id_periodo`) REFERENCES `eda_periodos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `eda_confpersonales_FK_4` FOREIGN KEY (`id_perfil`) REFERENCES `eda_perfiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_confpersonales`
--

LOCK TABLES `eda_confpersonales` WRITE;
/*!40000 ALTER TABLE `eda_confpersonales` DISABLE KEYS */;
INSERT INTO `eda_confpersonales` VALUES (1,1,1,1,1,NULL),(2,1,2,1,1,NULL),(3,3,5,3,4,6);
/*!40000 ALTER TABLE `eda_confpersonales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_control_accesos`
--

DROP TABLE IF EXISTS `eda_control_accesos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_control_accesos` (
  `id` int(11) NOT NULL,
  `caducidad` date DEFAULT NULL,
  `establoqueada` int(11) DEFAULT '0',
  `causabloqueo` varchar(255) DEFAULT NULL,
  `preguntaolvidoclave` varchar(128) DEFAULT NULL,
  `respuestaolvidoclave` varchar(128) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `eda_control_accesos_FK_1` FOREIGN KEY (`id`) REFERENCES `eda_usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_control_accesos`
--

LOCK TABLES `eda_control_accesos` WRITE;
/*!40000 ALTER TABLE `eda_control_accesos` DISABLE KEYS */;
INSERT INTO `eda_control_accesos` VALUES (1,NULL,0,NULL,NULL,NULL,'2011-06-20 09:31:08','2011-06-27 12:16:43'),(2,NULL,0,NULL,NULL,NULL,'2011-06-20 09:48:56','2011-06-20 09:48:56'),(3,NULL,0,NULL,NULL,NULL,'2011-06-20 09:49:11','2011-06-27 07:59:21'),(4,NULL,0,NULL,NULL,NULL,'2011-06-20 09:49:23','2011-06-20 09:49:23'),(5,NULL,0,NULL,NULL,NULL,'2011-06-20 09:49:37','2011-06-20 09:49:37'),(6,NULL,0,NULL,NULL,NULL,'2011-06-20 09:49:47','2011-06-20 09:49:47');
/*!40000 ALTER TABLE `eda_control_accesos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_credenciales`
--

DROP TABLE IF EXISTS `eda_credenciales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_credenciales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_aplicacion` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL DEFAULT '',
  `descripcion` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `id_aplicacion` (`id_aplicacion`),
  CONSTRAINT `eda_credenciales_FK_1` FOREIGN KEY (`id_aplicacion`) REFERENCES `eda_aplicaciones` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_credenciales`
--

LOCK TABLES `eda_credenciales` WRITE;
/*!40000 ALTER TABLE `eda_credenciales` DISABLE KEYS */;
INSERT INTO `eda_credenciales` VALUES (1,1,'GestionEDAE3_ACCESO','Credencial de acceso de la aplicación:GestionEDAE3'),(2,1,'EDAGESTIONPLUGIN_administracion','Administración completa de la aplicación:GestionEDAE3'),(3,1,'EDAGESTIONPLUGIN_administracion_uo','Administración parcial de la aplicación:GestionEDAE3'),(4,2,'catalogacion_ACCESO','Credencial de acceso de la aplicación:catalogacion'),(5,3,'Mensajeria_ACCESO','Credencial de acceso de la aplicación:Mensajeria'),(6,4,'Contabilidad_ACCESO','Credencial de acceso de la aplicación:Contabilidad'),(7,5,'PlatEdu_ACCESO','Credencial de acceso de la aplicación:PlatEdu'),(8,5,'PlatEdu_Docente','Permite usar la funcionalidad de docente de la plataforma educativa.'),(9,5,'PlatEdu_Alumno','Permite usar la funcionalidad de alumno de la plataforma educativa.'),(10,5,'PlatEdu_Admon','Permite usar la funcionalidad de administración de la plataforma educativa.'),(11,5,'PlatEdu_Coord','Permite usar la funcionalidad de coordinación de la plataforma educativa');
/*!40000 ALTER TABLE `eda_credenciales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_culturas`
--

DROP TABLE IF EXISTS `eda_culturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_culturas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` char(5) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_culturas`
--

LOCK TABLES `eda_culturas` WRITE;
/*!40000 ALTER TABLE `eda_culturas` DISABLE KEYS */;
INSERT INTO `eda_culturas` VALUES (1,'es_ES','Español'),(2,'en_GB','English');
/*!40000 ALTER TABLE `eda_culturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_direcciones`
--

DROP TABLE IF EXISTS `eda_direcciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_direcciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipodireccion` int(11) NOT NULL,
  `tipovia` varchar(12) DEFAULT NULL,
  `domicilio` varchar(80) DEFAULT NULL,
  `numero` varchar(15) DEFAULT NULL,
  `escalera` varchar(15) DEFAULT NULL,
  `piso` varchar(15) DEFAULT NULL,
  `letra` char(2) DEFAULT NULL,
  `municipio` varchar(50) DEFAULT NULL,
  `provincia` varchar(50) DEFAULT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `cp` varchar(20) DEFAULT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `id_organismo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tipodireccion` (`id_tipodireccion`),
  KEY `id_persona` (`id_persona`),
  KEY `id_organismo` (`id_organismo`),
  CONSTRAINT `eda_direcciones_FK_1` FOREIGN KEY (`id_tipodireccion`) REFERENCES `eda_tiposdireccion` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `eda_direcciones_FK_2` FOREIGN KEY (`id_persona`) REFERENCES `eda_personas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `eda_direcciones_FK_3` FOREIGN KEY (`id_organismo`) REFERENCES `eda_organismos` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_direcciones`
--

LOCK TABLES `eda_direcciones` WRITE;
/*!40000 ALTER TABLE `eda_direcciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `eda_direcciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_emails`
--

DROP TABLE IF EXISTS `eda_emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `direccion` varchar(255) NOT NULL,
  `predeterminado` tinyint(4) NOT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `id_organismo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_persona` (`id_persona`),
  KEY `id_organismo` (`id_organismo`),
  CONSTRAINT `eda_emails_FK_1` FOREIGN KEY (`id_persona`) REFERENCES `eda_personas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `eda_emails_FK_2` FOREIGN KEY (`id_organismo`) REFERENCES `eda_organismos` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_emails`
--

LOCK TABLES `eda_emails` WRITE;
/*!40000 ALTER TABLE `eda_emails` DISABLE KEYS */;
INSERT INTO `eda_emails` VALUES (1,'rosa@luxemburgo.com',1,2,NULL),(2,'',0,NULL,NULL),(3,'',0,NULL,NULL),(4,'',0,NULL,NULL),(5,'',0,NULL,NULL);
/*!40000 ALTER TABLE `eda_emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_estadisticas_aplicacion`
--

DROP TABLE IF EXISTS `eda_estadisticas_aplicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_estadisticas_aplicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_aplicacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `numero_accesos` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `navegador` varchar(255) DEFAULT NULL,
  `ip_cliente` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_aplicacion` (`id_aplicacion`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `eda_estadisticas_aplicacion_FK_1` FOREIGN KEY (`id_aplicacion`) REFERENCES `eda_aplicaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `eda_estadisticas_aplicacion_FK_2` FOREIGN KEY (`id_usuario`) REFERENCES `eda_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_estadisticas_aplicacion`
--

LOCK TABLES `eda_estadisticas_aplicacion` WRITE;
/*!40000 ALTER TABLE `eda_estadisticas_aplicacion` DISABLE KEYS */;
INSERT INTO `eda_estadisticas_aplicacion` VALUES (1,1,1,6,'2011-06-20 09:31:32','2011-06-27 12:16:43','Mozilla/5.0 (X11; U; Linux x86_64; es-ES; rv:1.9.2.17) Gecko/20110422 Ubuntu/10.10 (maverick) Firefox/3.6.17','127.0.0.1'),(2,5,3,6,'2011-06-20 11:37:47','2011-06-27 07:59:21','Mozilla/5.0 (X11; U; Linux x86_64; es-ES; rv:1.9.2.17) Gecko/20110422 Ubuntu/10.10 (maverick) Firefox/3.6.17','127.0.0.1');
/*!40000 ALTER TABLE `eda_estadisticas_aplicacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_organismos`
--

DROP TABLE IF EXISTS `eda_organismos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_organismos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) DEFAULT NULL,
  `abreviatura` varchar(20) DEFAULT NULL,
  `id_tipoorganismo` int(11) DEFAULT NULL,
  `codigo` varchar(15) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `sitioweb` varchar(80) DEFAULT NULL,
  `correo` varchar(60) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `id_contacto` int(11) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `id_depende` int(11) DEFAULT NULL,
  `id_pais` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_contacto` (`id_contacto`),
  KEY `id_depende` (`id_depende`),
  KEY `id_tipoorganismo` (`id_tipoorganismo`),
  KEY `id_pais` (`id_pais`),
  CONSTRAINT `eda_organismos_FK_1` FOREIGN KEY (`id_tipoorganismo`) REFERENCES `eda_tiposorganismo` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `eda_organismos_FK_2` FOREIGN KEY (`id_contacto`) REFERENCES `eda_personas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `eda_organismos_FK_3` FOREIGN KEY (`id_depende`) REFERENCES `eda_organismos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `eda_organismos_FK_4` FOREIGN KEY (`id_pais`) REFERENCES `gen_paises` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_organismos`
--

LOCK TABLES `eda_organismos` WRITE;
/*!40000 ALTER TABLE `eda_organismos` DISABLE KEYS */;
/*!40000 ALTER TABLE `eda_organismos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_perfil_credencial`
--

DROP TABLE IF EXISTS `eda_perfil_credencial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_perfil_credencial` (
  `id_perfil` int(11) NOT NULL,
  `id_credencial` int(11) NOT NULL,
  PRIMARY KEY (`id_perfil`,`id_credencial`),
  KEY `id_credencial` (`id_credencial`),
  KEY `id_perfil` (`id_perfil`),
  CONSTRAINT `eda_perfil_credencial_FK_1` FOREIGN KEY (`id_perfil`) REFERENCES `eda_perfiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `eda_perfil_credencial_FK_2` FOREIGN KEY (`id_credencial`) REFERENCES `eda_credenciales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_perfil_credencial`
--

LOCK TABLES `eda_perfil_credencial` WRITE;
/*!40000 ALTER TABLE `eda_perfil_credencial` DISABLE KEYS */;
INSERT INTO `eda_perfil_credencial` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(2,5),(3,5),(4,5),(5,5),(6,5),(7,5),(8,5),(9,5),(9,6),(4,7),(5,7),(6,7),(7,7),(4,8),(5,9),(7,10),(6,11);
/*!40000 ALTER TABLE `eda_perfil_credencial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_perfiles`
--

DROP TABLE IF EXISTS `eda_perfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_perfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_uo` int(11) DEFAULT NULL,
  `id_css` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `id_ambitotipo` int(11) DEFAULT NULL,
  `menu` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_uo` (`id_uo`),
  KEY `id_css` (`id_css`),
  KEY `id_ambitotipo` (`id_ambitotipo`),
  CONSTRAINT `eda_perfiles_FK_1` FOREIGN KEY (`id_uo`) REFERENCES `eda_uos` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `eda_perfiles_FK_2` FOREIGN KEY (`id_ambitotipo`) REFERENCES `eda_ambitostipos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_perfiles`
--

LOCK TABLES `eda_perfiles` WRITE;
/*!40000 ALTER TABLE `eda_perfiles` DISABLE KEYS */;
INSERT INTO `eda_perfiles` VALUES (1,1,NULL,'2011-06-20 09:31:08','2011-06-20 09:31:08',NULL,'root.yml'),(2,1,NULL,'2011-06-20 10:11:02','2011-06-20 10:11:02',3,'tele-sistemas.yml'),(3,1,NULL,'2011-06-20 10:11:19','2011-06-20 10:11:19',2,'tele-desarrollador.yml'),(4,2,NULL,'2011-06-20 10:11:00','2011-06-20 10:11:00',1,'form-profesor.yml'),(5,2,NULL,'2011-06-20 10:11:57','2011-06-20 10:11:57',1,'form-alumno.yml'),(6,2,NULL,'2011-06-20 10:12:15','2011-06-20 10:12:15',1,'form-coordinador.yml'),(7,2,NULL,'2011-06-20 10:12:00','2011-06-20 10:12:00',NULL,'form-jefeestudios.yml'),(8,3,NULL,'2011-06-20 10:12:58','2011-06-20 10:12:58',NULL,'secr-secretario.yml'),(9,3,NULL,'2011-06-20 10:13:07','2011-06-20 10:13:07',NULL,'secr-contable.yml');
/*!40000 ALTER TABLE `eda_perfiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_perfiles_i18n`
--

DROP TABLE IF EXISTS `eda_perfiles_i18n`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_perfiles_i18n` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(128) DEFAULT NULL,
  `abreviatura` varchar(255) DEFAULT NULL,
  `id_cultura` char(5) NOT NULL,
  PRIMARY KEY (`id`,`id_cultura`),
  KEY `id_cultura` (`id_cultura`),
  CONSTRAINT `eda_perfiles_i18n_FK_1` FOREIGN KEY (`id`) REFERENCES `eda_perfiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_perfiles_i18n`
--

LOCK TABLES `eda_perfiles_i18n` WRITE;
/*!40000 ALTER TABLE `eda_perfiles_i18n` DISABLE KEYS */;
INSERT INTO `eda_perfiles_i18n` VALUES (1,'SuperAdministrator',NULL,'SuperAdmin','en_GB'),(1,'SuperAdministrador',NULL,'SuperAdmin','es_ES'),(2,'','','','en_GB'),(2,'Sistemas','','','es_ES'),(3,'','','','en_GB'),(3,'Desarrollador','','','es_ES'),(4,'','','','en_GB'),(4,'Profesor','','','es_ES'),(5,'','','','en_GB'),(5,'Alumno','','','es_ES'),(6,'','','','en_GB'),(6,'Coordinador','','','es_ES'),(7,'','','','en_GB'),(7,'Jefe de Estudios','','','es_ES'),(8,'','','','en_GB'),(8,'Secretario','','','es_ES'),(9,'','','','en_GB'),(9,'Contable','','','es_ES');
/*!40000 ALTER TABLE `eda_perfiles_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_periodos`
--

DROP TABLE IF EXISTS `eda_periodos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_periodos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_uo` int(11) NOT NULL,
  `fechainicio` date DEFAULT NULL,
  `fechafin` date DEFAULT NULL,
  `codigo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL DEFAULT '',
  `estado` varchar(255) NOT NULL DEFAULT 'ACTIVO',
  PRIMARY KEY (`id`),
  KEY `id_uo` (`id_uo`),
  CONSTRAINT `eda_periodos_FK_1` FOREIGN KEY (`id_uo`) REFERENCES `eda_uos` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_periodos`
--

LOCK TABLES `eda_periodos` WRITE;
/*!40000 ALTER TABLE `eda_periodos` DISABLE KEYS */;
INSERT INTO `eda_periodos` VALUES (1,1,'2009-01-01',NULL,'UO0','Administración','ACTIVO'),(2,2,'2009-01-01','2009-12-31','PER0','Periodo 1','INACTIVO'),(3,2,'2010-01-01','2010-12-31','PER1','Periodo 2','ACTIVO'),(4,3,'2009-01-01','2009-12-31','PER0','Periodo 1','INACTIVO'),(5,3,'2010-01-01','2010-12-31','PER1','Periodo 2','ACTIVO');
/*!40000 ALTER TABLE `eda_periodos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_personas`
--

DROP TABLE IF EXISTS `eda_personas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_personas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `apellido1` varchar(40) DEFAULT NULL,
  `apellido2` varchar(40) DEFAULT NULL,
  `id_tipodocidentificacion` int(11) DEFAULT NULL,
  `docidentificacion` varchar(32) DEFAULT NULL,
  `id_paisdocidentificacion` int(11) DEFAULT NULL,
  `sexo` varchar(1) DEFAULT NULL,
  `fechanacimiento` date DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `profesion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `docidentificacion` (`docidentificacion`,`id_paisdocidentificacion`),
  KEY `id_tipodocidentificacion` (`id_tipodocidentificacion`),
  KEY `id_paisdocidentificacion` (`id_paisdocidentificacion`),
  CONSTRAINT `eda_personas_FK_1` FOREIGN KEY (`id_tipodocidentificacion`) REFERENCES `eda_tiposdocidentificacion` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `eda_personas_FK_2` FOREIGN KEY (`id_paisdocidentificacion`) REFERENCES `gen_paises` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_personas`
--

LOCK TABLES `eda_personas` WRITE;
/*!40000 ALTER TABLE `eda_personas` DISABLE KEYS */;
INSERT INTO `eda_personas` VALUES (1,'Anselmo','Lorenzo','',NULL,'',NULL,'',NULL,'','2011-06-20 09:31:00','2011-06-20 09:31:00',''),(2,'Rosa','Luxemburgo','',NULL,'',NULL,'',NULL,'','2011-06-20 09:48:00','2011-06-20 09:48:00',''),(3,'Carlos','Marx','',NULL,'',NULL,'',NULL,'','2011-06-20 09:49:00','2011-06-20 09:49:00',''),(4,'Federico','Engels','',NULL,'',NULL,'',NULL,'','2011-06-20 09:49:00','2011-06-20 09:49:00',''),(5,'Teresa','Claramount','',NULL,'',NULL,'',NULL,'','2011-06-20 09:49:00','2011-06-20 09:49:00',''),(6,'María','Zambrano','',NULL,'',NULL,'',NULL,'','2011-06-20 09:49:00','2011-06-20 09:49:00','');
/*!40000 ALTER TABLE `eda_personas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_telefonos`
--

DROP TABLE IF EXISTS `eda_telefonos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_telefonos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numerotelefono` varchar(20) NOT NULL,
  `id_tipotelefono` int(11) NOT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `id_organismo` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tipotelefono` (`id_tipotelefono`),
  KEY `id_persona` (`id_persona`),
  KEY `id_organismo` (`id_organismo`),
  CONSTRAINT `eda_telefonos_FK_1` FOREIGN KEY (`id_tipotelefono`) REFERENCES `eda_tipostelefono` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `eda_telefonos_FK_2` FOREIGN KEY (`id_persona`) REFERENCES `eda_personas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `eda_telefonos_FK_3` FOREIGN KEY (`id_organismo`) REFERENCES `eda_organismos` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_telefonos`
--

LOCK TABLES `eda_telefonos` WRITE;
/*!40000 ALTER TABLE `eda_telefonos` DISABLE KEYS */;
/*!40000 ALTER TABLE `eda_telefonos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_tiposdireccion`
--

DROP TABLE IF EXISTS `eda_tiposdireccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_tiposdireccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_tiposdireccion`
--

LOCK TABLES `eda_tiposdireccion` WRITE;
/*!40000 ALTER TABLE `eda_tiposdireccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `eda_tiposdireccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_tiposdireccion_i18n`
--

DROP TABLE IF EXISTS `eda_tiposdireccion_i18n`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_tiposdireccion_i18n` (
  `id` int(11) NOT NULL,
  `id_idioma` char(5) NOT NULL,
  `nombre` varchar(24) NOT NULL,
  PRIMARY KEY (`id`,`id_idioma`),
  KEY `id_idioma` (`id_idioma`),
  CONSTRAINT `eda_tiposdireccion_i18n_FK_1` FOREIGN KEY (`id`) REFERENCES `eda_tiposdireccion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_tiposdireccion_i18n`
--

LOCK TABLES `eda_tiposdireccion_i18n` WRITE;
/*!40000 ALTER TABLE `eda_tiposdireccion_i18n` DISABLE KEYS */;
/*!40000 ALTER TABLE `eda_tiposdireccion_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_tiposdocidentificacion`
--

DROP TABLE IF EXISTS `eda_tiposdocidentificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_tiposdocidentificacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `funciondecontrol` char(24) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_tiposdocidentificacion`
--

LOCK TABLES `eda_tiposdocidentificacion` WRITE;
/*!40000 ALTER TABLE `eda_tiposdocidentificacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `eda_tiposdocidentificacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_tiposdocidentificacion_i18n`
--

DROP TABLE IF EXISTS `eda_tiposdocidentificacion_i18n`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_tiposdocidentificacion_i18n` (
  `id` int(11) NOT NULL,
  `id_idioma` char(5) NOT NULL,
  `nombre` varchar(24) NOT NULL,
  PRIMARY KEY (`id`,`id_idioma`),
  KEY `id_idioma` (`id_idioma`),
  CONSTRAINT `eda_tiposdocidentificacion_i18n_FK_1` FOREIGN KEY (`id`) REFERENCES `eda_tiposdocidentificacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_tiposdocidentificacion_i18n`
--

LOCK TABLES `eda_tiposdocidentificacion_i18n` WRITE;
/*!40000 ALTER TABLE `eda_tiposdocidentificacion_i18n` DISABLE KEYS */;
/*!40000 ALTER TABLE `eda_tiposdocidentificacion_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_tiposorganismo`
--

DROP TABLE IF EXISTS `eda_tiposorganismo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_tiposorganismo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(20) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_tiposorganismo`
--

LOCK TABLES `eda_tiposorganismo` WRITE;
/*!40000 ALTER TABLE `eda_tiposorganismo` DISABLE KEYS */;
/*!40000 ALTER TABLE `eda_tiposorganismo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_tiposorganismo_i18n`
--

DROP TABLE IF EXISTS `eda_tiposorganismo_i18n`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_tiposorganismo_i18n` (
  `id` int(11) NOT NULL DEFAULT '0',
  `nombre` varchar(255) DEFAULT NULL,
  `abreviatura` varchar(255) DEFAULT NULL,
  `id_idioma` char(5) NOT NULL,
  PRIMARY KEY (`id`,`id_idioma`),
  KEY `id_idioma` (`id_idioma`),
  CONSTRAINT `eda_tiposorganismo_i18n_FK_1` FOREIGN KEY (`id`) REFERENCES `eda_tiposorganismo` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_tiposorganismo_i18n`
--

LOCK TABLES `eda_tiposorganismo_i18n` WRITE;
/*!40000 ALTER TABLE `eda_tiposorganismo_i18n` DISABLE KEYS */;
/*!40000 ALTER TABLE `eda_tiposorganismo_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_tipostelefono`
--

DROP TABLE IF EXISTS `eda_tipostelefono`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_tipostelefono` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_tipostelefono`
--

LOCK TABLES `eda_tipostelefono` WRITE;
/*!40000 ALTER TABLE `eda_tipostelefono` DISABLE KEYS */;
/*!40000 ALTER TABLE `eda_tipostelefono` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_tipostelefono_i18n`
--

DROP TABLE IF EXISTS `eda_tipostelefono_i18n`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_tipostelefono_i18n` (
  `id` int(11) NOT NULL,
  `id_idioma` char(5) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`id`,`id_idioma`),
  KEY `id_idioma` (`id_idioma`),
  CONSTRAINT `eda_tipostelefono_i18n_FK_1` FOREIGN KEY (`id`) REFERENCES `eda_tipostelefono` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_tipostelefono_i18n`
--

LOCK TABLES `eda_tipostelefono_i18n` WRITE;
/*!40000 ALTER TABLE `eda_tipostelefono_i18n` DISABLE KEYS */;
/*!40000 ALTER TABLE `eda_tipostelefono_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_uos`
--

DROP TABLE IF EXISTS `eda_uos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_uos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(20) DEFAULT NULL,
  `observaciones` varchar(128) DEFAULT NULL,
  `marca` varchar(10) DEFAULT 'gral',
  `id_css` int(11) DEFAULT NULL,
  `id_cssimpresion` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  KEY `id_css` (`id_css`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_uos`
--

LOCK TABLES `eda_uos` WRITE;
/*!40000 ALTER TABLE `eda_uos` DISABLE KEYS */;
INSERT INTO `eda_uos` VALUES (1,'UO0','','gral',NULL,NULL,'2011-06-20 09:31:00','2011-06-20 09:31:00'),(2,'UO1','','gral',NULL,NULL,'2011-06-20 09:54:44','2011-06-20 09:54:44'),(3,'UO2','','gral',NULL,NULL,'2011-06-20 09:54:58','2011-06-20 09:54:58');
/*!40000 ALTER TABLE `eda_uos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_uos_i18n`
--

DROP TABLE IF EXISTS `eda_uos_i18n`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_uos_i18n` (
  `id` int(11) NOT NULL DEFAULT '0',
  `nombre` varchar(255) DEFAULT NULL,
  `abreviatura` varchar(255) DEFAULT NULL,
  `cabecera` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `id_cultura` char(5) NOT NULL,
  PRIMARY KEY (`id`,`id_cultura`),
  KEY `id_cultura` (`id_cultura`),
  CONSTRAINT `eda_uos_i18n_FK_1` FOREIGN KEY (`id`) REFERENCES `eda_uos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_uos_i18n`
--

LOCK TABLES `eda_uos_i18n` WRITE;
/*!40000 ALTER TABLE `eda_uos_i18n` DISABLE KEYS */;
INSERT INTO `eda_uos_i18n` VALUES (1,'Telematic','','','','en_GB'),(1,'Telemática','','','','es_ES'),(2,'','','','','en_GB'),(2,'Formación','','','','es_ES'),(3,'','','','','en_GB'),(3,'Secretaría','','','','es_ES');
/*!40000 ALTER TABLE `eda_uos_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_usu_atributos`
--

DROP TABLE IF EXISTS `eda_usu_atributos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_usu_atributos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `formato` varchar(255) DEFAULT NULL,
  `relevancia` varchar(255) DEFAULT NULL,
  `origen` varchar(255) DEFAULT NULL,
  `oid` varchar(255) DEFAULT NULL,
  `urn` varchar(255) DEFAULT NULL,
  `sintaxis_ldap` varchar(255) DEFAULT NULL,
  `indexado` varchar(255) DEFAULT NULL,
  `multivaluado` tinyint(4) DEFAULT NULL,
  `ejemplo` varchar(255) DEFAULT NULL,
  `notas` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_usu_atributos`
--

LOCK TABLES `eda_usu_atributos` WRITE;
/*!40000 ALTER TABLE `eda_usu_atributos` DISABLE KEYS */;
/*!40000 ALTER TABLE `eda_usu_atributos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_usu_atributos_valores`
--

DROP TABLE IF EXISTS `eda_usu_atributos_valores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_usu_atributos_valores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_usu_atributo` int(11) DEFAULT NULL,
  `valor` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `expira` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_usu_atributo` (`id_usu_atributo`),
  CONSTRAINT `eda_usu_atributos_valores_FK_1` FOREIGN KEY (`id_usuario`) REFERENCES `eda_usuarios` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `eda_usu_atributos_valores_FK_2` FOREIGN KEY (`id_usu_atributo`) REFERENCES `eda_usu_atributos` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_usu_atributos_valores`
--

LOCK TABLES `eda_usu_atributos_valores` WRITE;
/*!40000 ALTER TABLE `eda_usu_atributos_valores` DISABLE KEYS */;
/*!40000 ALTER TABLE `eda_usu_atributos_valores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eda_usuarios`
--

DROP TABLE IF EXISTS `eda_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eda_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_sfuser` int(11) DEFAULT NULL,
  `alias` varchar(20) DEFAULT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT '1',
  `fecha_alta` date DEFAULT NULL,
  `fecha_baja` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `id_culturapref` char(5) DEFAULT NULL,
  `tipo` tinyint(4) NOT NULL DEFAULT '0',
  `id_persona` int(11) DEFAULT NULL,
  `id_organismo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `eda_usuarios_U_1` (`alias`),
  KEY `id_persona` (`id_persona`),
  KEY `id_culturapref` (`id_culturapref`),
  KEY `id_organismo` (`id_organismo`),
  KEY `id_sfuser` (`id_sfuser`),
  CONSTRAINT `eda_usuarios_FK_1` FOREIGN KEY (`id_persona`) REFERENCES `eda_personas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `eda_usuarios_FK_2` FOREIGN KEY (`id_organismo`) REFERENCES `eda_organismos` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eda_usuarios`
--

LOCK TABLES `eda_usuarios` WRITE;
/*!40000 ALTER TABLE `eda_usuarios` DISABLE KEYS */;
INSERT INTO `eda_usuarios` VALUES (1,1,'root0000',1,NULL,NULL,'2011-06-20 09:31:08','2011-06-20 09:31:08','es_ES',0,1,NULL),(2,2,'rlux0000',1,NULL,NULL,'2011-06-20 09:48:56','2011-06-20 09:48:56','es_ES',0,2,NULL),(3,3,'cmar0000',1,NULL,NULL,'2011-06-20 09:49:11','2011-06-20 09:49:11','es_ES',0,3,NULL),(4,4,'feng0000',1,NULL,NULL,'2011-06-20 09:49:23','2011-06-20 09:49:23','es_ES',0,4,NULL),(5,5,'tcla0000',1,NULL,NULL,'2011-06-20 09:49:37','2011-06-20 09:49:37','es_ES',0,5,NULL),(6,6,'mzam0000',1,NULL,NULL,'2011-06-20 09:49:47','2011-06-20 09:49:47','es_ES',0,6,NULL);
/*!40000 ALTER TABLE `eda_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gen_comunidades`
--

DROP TABLE IF EXISTS `gen_comunidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gen_comunidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigocomunidad` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gen_comunidades`
--

LOCK TABLES `gen_comunidades` WRITE;
/*!40000 ALTER TABLE `gen_comunidades` DISABLE KEYS */;
/*!40000 ALTER TABLE `gen_comunidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gen_comunidades_i18n`
--

DROP TABLE IF EXISTS `gen_comunidades_i18n`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gen_comunidades_i18n` (
  `id` int(11) NOT NULL,
  `id_cultura` char(5) NOT NULL,
  `nombre` varchar(40) DEFAULT NULL,
  `nombreabrev` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_cultura`),
  KEY `id_cultura` (`id_cultura`),
  CONSTRAINT `gen_comunidades_i18n_FK_1` FOREIGN KEY (`id`) REFERENCES `gen_comunidades` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gen_comunidades_i18n`
--

LOCK TABLES `gen_comunidades_i18n` WRITE;
/*!40000 ALTER TABLE `gen_comunidades_i18n` DISABLE KEYS */;
/*!40000 ALTER TABLE `gen_comunidades_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gen_localidades`
--

DROP TABLE IF EXISTS `gen_localidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gen_localidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigolocal` char(2) DEFAULT NULL,
  `id_provincia` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_provincia` (`id_provincia`),
  CONSTRAINT `gen_localidades_FK_1` FOREIGN KEY (`id_provincia`) REFERENCES `gen_provincias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gen_localidades`
--

LOCK TABLES `gen_localidades` WRITE;
/*!40000 ALTER TABLE `gen_localidades` DISABLE KEYS */;
/*!40000 ALTER TABLE `gen_localidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gen_localidades_i18n`
--

DROP TABLE IF EXISTS `gen_localidades_i18n`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gen_localidades_i18n` (
  `id` int(11) NOT NULL,
  `id_cultura` char(5) NOT NULL,
  `nombre` varchar(40) DEFAULT NULL,
  `nombreabrev` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_cultura`),
  KEY `id_cultura` (`id_cultura`),
  CONSTRAINT `gen_localidades_i18n_FK_1` FOREIGN KEY (`id`) REFERENCES `gen_localidades` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gen_localidades_i18n`
--

LOCK TABLES `gen_localidades_i18n` WRITE;
/*!40000 ALTER TABLE `gen_localidades_i18n` DISABLE KEYS */;
/*!40000 ALTER TABLE `gen_localidades_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gen_paises`
--

DROP TABLE IF EXISTS `gen_paises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gen_paises` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_iso3166_alfa2` char(2) DEFAULT NULL,
  `codigo_iso3166_alfa3` varchar(3) DEFAULT NULL,
  `codigo_iso3166_num` int(11) DEFAULT NULL,
  `paisoterritorio` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_iso3166_alfa2` (`codigo_iso3166_alfa2`),
  UNIQUE KEY `codigo_iso3166_alfa3` (`codigo_iso3166_alfa3`),
  UNIQUE KEY `codigo_iso3166_num` (`codigo_iso3166_num`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gen_paises`
--

LOCK TABLES `gen_paises` WRITE;
/*!40000 ALTER TABLE `gen_paises` DISABLE KEYS */;
/*!40000 ALTER TABLE `gen_paises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gen_paises_i18n`
--

DROP TABLE IF EXISTS `gen_paises_i18n`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gen_paises_i18n` (
  `id` int(11) NOT NULL,
  `id_cultura` char(5) NOT NULL,
  `nombre` varchar(40) DEFAULT NULL,
  `nombreabrev` varchar(20) DEFAULT NULL,
  `nacionalidad` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_cultura`),
  KEY `id_cultura` (`id_cultura`),
  CONSTRAINT `gen_paises_i18n_FK_1` FOREIGN KEY (`id`) REFERENCES `gen_paises` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gen_paises_i18n`
--

LOCK TABLES `gen_paises_i18n` WRITE;
/*!40000 ALTER TABLE `gen_paises_i18n` DISABLE KEYS */;
/*!40000 ALTER TABLE `gen_paises_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gen_provincias`
--

DROP TABLE IF EXISTS `gen_provincias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gen_provincias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigoprov` char(2) DEFAULT NULL,
  `id_comunidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_comunidad` (`id_comunidad`),
  CONSTRAINT `gen_provincias_FK_1` FOREIGN KEY (`id_comunidad`) REFERENCES `gen_comunidades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gen_provincias`
--

LOCK TABLES `gen_provincias` WRITE;
/*!40000 ALTER TABLE `gen_provincias` DISABLE KEYS */;
/*!40000 ALTER TABLE `gen_provincias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gen_provincias_i18n`
--

DROP TABLE IF EXISTS `gen_provincias_i18n`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gen_provincias_i18n` (
  `id` int(11) NOT NULL,
  `id_cultura` char(5) NOT NULL,
  `nombre` varchar(40) DEFAULT NULL,
  `nombreabrev` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_cultura`),
  KEY `id_cultura` (`id_cultura`),
  CONSTRAINT `gen_provincias_i18n_FK_1` FOREIGN KEY (`id`) REFERENCES `gen_provincias` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gen_provincias_i18n`
--

LOCK TABLES `gen_provincias_i18n` WRITE;
/*!40000 ALTER TABLE `gen_provincias_i18n` DISABLE KEYS */;
/*!40000 ALTER TABLE `gen_provincias_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_BreadNav`
--

DROP TABLE IF EXISTS `sf_BreadNav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sf_BreadNav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `module` varchar(128) NOT NULL,
  `action` varchar(128) NOT NULL,
  `credential` varchar(128) DEFAULT NULL,
  `catchall` tinyint(4) DEFAULT NULL,
  `tree_left` int(11) NOT NULL,
  `tree_right` int(11) NOT NULL,
  `tree_parent` int(11) NOT NULL,
  `scope` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sf_BreadNav_FI_1` (`scope`),
  CONSTRAINT `sf_BreadNav_FK_1` FOREIGN KEY (`scope`) REFERENCES `sf_BreadNav_Application` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sf_BreadNav`
--

LOCK TABLES `sf_BreadNav` WRITE;
/*!40000 ALTER TABLE `sf_BreadNav` DISABLE KEYS */;
INSERT INTO `sf_BreadNav` VALUES (1,'Inicio','','inicio','index','EDAGESTIONPLUGIN_administracion',NULL,1,60,0,1),(2,'UOS','','uos','index','EDAGESTIONPLUGIN_administracion',NULL,2,11,0,1),(3,'gestión de uos','','uos','index','EDAGESTIONPLUGIN_administracion',NULL,3,4,0,1),(4,'gestión de periodos','','periodos','index','EDAGESTIONPLUGIN_administracion',NULL,5,6,0,1),(5,'gestión de perfiles','','perfiles','index','EDAGESTIONPLUGIN_administracion',NULL,7,8,0,1),(6,'gestión de ámbitos','','ambitostipos','index','EDAGESTIONPLUGIN_administracion',NULL,9,10,0,1),(7,'Aplicaciones','','aplicaciones','index','EDAGESTIONPLUGIN_administracion',NULL,12,19,0,1),(8,'gestión de aplicaciones','','aplicaciones','index','EDAGESTIONPLUGIN_administracion',NULL,13,14,0,1),(9,'gestión de credenciales','','credenciales','index','EDAGESTIONPLUGIN_administracion',NULL,15,16,0,1),(10,'gestión de culturas','','culturas','index','EDAGESTIONPLUGIN_administracion',NULL,17,18,0,1),(11,'Usuarios','','personas','index','EDAGESTIONPLUGIN_administracion',NULL,20,25,0,1),(12,'gestión de personas','','personas','index','EDAGESTIONPLUGIN_administracion_uo',NULL,21,22,0,1),(13,'gestión de organismos','','organismos','index','EDAGESTIONPLUGIN_administracion_uo',NULL,23,24,0,1),(14,'Localizaciones','','paises','index','EDAGESTIONPLUGIN_administracion',NULL,26,33,0,1),(15,'gestión países','','paises','index','EDAGESTIONPLUGIN_administracion',NULL,27,28,0,1),(16,'gestión de comunidades','','comunidades','index','EDAGESTIONPLUGIN_administracion',NULL,29,30,0,1),(17,'gestión de provincias','','provincias','index','EDAGESTIONPLUGIN_administracion',NULL,31,32,0,1),(18,'Datos Auxiliares','','tiposdoc','index','EDAGESTIONPLUGIN_administracion',NULL,34,43,0,1),(19,'gestión de tipos de documentos','','tiposdoc','index','EDAGESTIONPLUGIN_administracion',NULL,35,36,0,1),(20,'gestión de tipos de direcciones','','tiposdir','tiposdir/index','EDAGESTIONPLUGIN_administracion',NULL,37,38,0,1),(21,'gestión de tipos de organismos','','tiposorg','index','EDAGESTIONPLUGIN_administracion',NULL,39,40,0,1),(22,'gestión de tipos de telefonos','','tipostel','index','EDAGESTIONPLUGIN_administracion',NULL,41,42,0,1),(23,'Identificaciones','','sfGuardUser','index','EDAGESTIONPLUGIN_administracion',NULL,44,53,0,1),(24,'gestión de identificaciones','','sfGuardUser','index','EDAGESTIONPLUGIN_administracion',NULL,45,46,0,1),(25,'gestión de grupos','','sfGuardGroup','index','EDAGESTIONPLUGIN_administracion',NULL,47,48,0,1),(26,'gestión de permisos','','sfGuardPermission','index','EDAGESTIONPLUGIN_administracion',NULL,49,50,0,1),(27,'gestión de atributos','','atributos','index','EDAGESTIONPLUGIN_administracion_uo',NULL,51,52,0,1),(28,'Menus','','sfBreadNavAdmin','index','EDAGESTIONPLUGIN_administracion',NULL,54,59,0,1),(29,'gestión de menús','','sfBreadNavAdmin','index','EDAGESTIONPLUGIN_administracion',NULL,55,56,0,1),(30,'listado de menús','','sfBreadNavAdmin','list','EDAGESTIONPLUGIN_administracion',NULL,57,58,0,1),(31,'Inicio','','inicio','index','PlatEdu_Docente',NULL,1,14,0,2),(35,'Seguimiento','','seguimiento','index','PlatEdu_Docente',NULL,2,7,0,2),(36,'Calificaciones','','calificaciones','index','PlatEdu_Docente',NULL,3,4,0,2),(37,'Notas del profesor','','notas','index','PlatEdu_Docente',NULL,5,6,0,2),(38,'Curso','','actividades','index','PlatEdu_Docente',NULL,8,13,0,2),(39,'Actividades','','actividades','index','PlatEdu_Docente',NULL,9,10,0,2),(40,'Recursos','','recursos','index','PlatEdu_Docente',NULL,11,12,0,2);
/*!40000 ALTER TABLE `sf_BreadNav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_BreadNav_Application`
--

DROP TABLE IF EXISTS `sf_BreadNav_Application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sf_BreadNav_Application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `application` varchar(255) NOT NULL,
  `css` varchar(2000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sf_BreadNav_Application`
--

LOCK TABLES `sf_BreadNav_Application` WRITE;
/*!40000 ALTER TABLE `sf_BreadNav_Application` DISABLE KEYS */;
INSERT INTO `sf_BreadNav_Application` VALUES (1,NULL,'menu_backend','backend',''),(2,NULL,'menu_platedu','platedu','none');
/*!40000 ALTER TABLE `sf_BreadNav_Application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_group`
--

DROP TABLE IF EXISTS `sf_guard_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sf_guard_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sf_guard_group_U_1` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sf_guard_group`
--

LOCK TABLES `sf_guard_group` WRITE;
/*!40000 ALTER TABLE `sf_guard_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `sf_guard_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_group_permission`
--

DROP TABLE IF EXISTS `sf_guard_group_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sf_guard_group_permission` (
  `group_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`permission_id`),
  KEY `sf_guard_group_permission_FI_2` (`permission_id`),
  CONSTRAINT `sf_guard_group_permission_FK_1` FOREIGN KEY (`group_id`) REFERENCES `sf_guard_group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sf_guard_group_permission_FK_2` FOREIGN KEY (`permission_id`) REFERENCES `sf_guard_permission` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sf_guard_group_permission`
--

LOCK TABLES `sf_guard_group_permission` WRITE;
/*!40000 ALTER TABLE `sf_guard_group_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `sf_guard_group_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_permission`
--

DROP TABLE IF EXISTS `sf_guard_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sf_guard_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sf_guard_permission_U_1` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sf_guard_permission`
--

LOCK TABLES `sf_guard_permission` WRITE;
/*!40000 ALTER TABLE `sf_guard_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `sf_guard_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_remember_key`
--

DROP TABLE IF EXISTS `sf_guard_remember_key`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sf_guard_remember_key` (
  `user_id` int(11) NOT NULL,
  `remember_key` varchar(32) DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`,`ip_address`),
  CONSTRAINT `sf_guard_remember_key_FK_1` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sf_guard_remember_key`
--

LOCK TABLES `sf_guard_remember_key` WRITE;
/*!40000 ALTER TABLE `sf_guard_remember_key` DISABLE KEYS */;
/*!40000 ALTER TABLE `sf_guard_remember_key` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_user`
--

DROP TABLE IF EXISTS `sf_guard_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sf_guard_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `algorithm` varchar(128) NOT NULL DEFAULT 'sha1',
  `salt` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_super_admin` tinyint(4) NOT NULL DEFAULT '0',
  `num_login_fails` int(11) DEFAULT '0',
  `token_reset_password` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sf_guard_user_U_1` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sf_guard_user`
--

LOCK TABLES `sf_guard_user` WRITE;
/*!40000 ALTER TABLE `sf_guard_user` DISABLE KEYS */;
INSERT INTO `sf_guard_user` VALUES (1,'anselmo','sha1','f0950e3e1752b554c510315c63f02398','b34ded034861fc268da299426c5edfd9832a99af','2011-06-20 09:31:08','2011-06-27 12:16:43',1,0,0,NULL),(2,'rosa','sha1','b53d44ba09bbee9753fc7818843873f9','323b46edbe037e71daf9562009e078c95afbb480','2011-06-20 09:48:56',NULL,1,0,0,NULL),(3,'carlos','sha1','2c3a9ee6f5e9a62a35c3c2be407650ea','d80fb6374ca88b9b01de0e9d233a466cae5d1011','2011-06-20 09:49:11','2011-06-27 07:59:21',1,0,0,NULL),(4,'federico','sha1','db2b056863f779730096a60fd5e8dfdf','1115b9a9163218c7ea4c21b80a42682dfa02677f','2011-06-20 09:49:23',NULL,1,0,0,NULL),(5,'teresa','sha1','e53924dbffc231e56d1ba66e1392b122','0947c5f818af19f2ddcc8e3ab59a9f8661853e26','2011-06-20 09:49:37',NULL,1,0,0,NULL),(6,'maria','sha1','469f669b79170e9d7f54e8ba2616dbb0','cdde090198e56a61ebf963f291063cc144f30c5e','2011-06-20 09:49:47',NULL,1,0,0,NULL);
/*!40000 ALTER TABLE `sf_guard_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_user_group`
--

DROP TABLE IF EXISTS `sf_guard_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sf_guard_user_group` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `sf_guard_user_group_FI_2` (`group_id`),
  CONSTRAINT `sf_guard_user_group_FK_1` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sf_guard_user_group_FK_2` FOREIGN KEY (`group_id`) REFERENCES `sf_guard_group` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sf_guard_user_group`
--

LOCK TABLES `sf_guard_user_group` WRITE;
/*!40000 ALTER TABLE `sf_guard_user_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `sf_guard_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_user_permission`
--

DROP TABLE IF EXISTS `sf_guard_user_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sf_guard_user_permission` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `sf_guard_user_permission_FI_2` (`permission_id`),
  CONSTRAINT `sf_guard_user_permission_FK_1` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sf_guard_user_permission_FK_2` FOREIGN KEY (`permission_id`) REFERENCES `sf_guard_permission` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sf_guard_user_permission`
--

LOCK TABLES `sf_guard_user_permission` WRITE;
/*!40000 ALTER TABLE `sf_guard_user_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `sf_guard_user_permission` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-06-28 13:15:13
