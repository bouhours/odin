-- MariaDB dump 10.19  Distrib 10.6.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: odin
-- ------------------------------------------------------
-- Server version	10.6.12-MariaDB-0ubuntu0.22.04.1

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
-- Current Database: `odin`
--

/*!40000 DROP DATABASE IF EXISTS `odin`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `odin` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci */;

USE `odin`;

--
-- Temporary table structure for view `absences_access_enseignants`
--

DROP TABLE IF EXISTS `absences_access_enseignants`;
/*!50001 DROP VIEW IF EXISTS `absences_access_enseignants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `absences_access_enseignants` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ENS_ID`,
  1 AS `ENS_NOM`,
  1 AS `ENS_MAIL`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `absences_mail`
--

DROP TABLE IF EXISTS `absences_mail`;
/*!50001 DROP VIEW IF EXISTS `absences_mail`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `absences_mail` AS SELECT
 1 AS `ENS_NOM`,
  1 AS `ET_NOM`,
  1 AS `ABS_DATE`,
  1 AS `COURS_NOM`,
  1 AS `CRENEAU_NOM`,
  1 AS `GROUPE_ENS_ID`,
  1 AS `ABS_ID`,
  1 AS `ET_MAIL`,
  1 AS `GROUPE_ID`,
  1 AS `GROUPE_NOM`,
  1 AS `ABS_REAL_DATE`,
  1 AS `CRENEAU_REAL_START`,
  1 AS `CRENEAU_REAL_END`,
  1 AS `ABS_JUSTIFICATION`,
  1 AS `ABST_NOM` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `absences_pro_mail`
--

DROP TABLE IF EXISTS `absences_pro_mail`;
/*!50001 DROP VIEW IF EXISTS `absences_pro_mail`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `absences_pro_mail` AS SELECT
 1 AS `PROABS_ID`,
  1 AS `PROABS_ENS_ID`,
  1 AS `PROABS_ET_ID`,
  1 AS `PROABS_DATE`,
  1 AS `PROABS_JUSTIFICATION`,
  1 AS `PROABS_EXCUSE`,
  1 AS `PROABS_MAIL`,
  1 AS `PROABS_REAL_DATE`,
  1 AS `PROABS_EXPIRE`,
  1 AS `EDT_NOM`,
  1 AS `EDT_HEURE_DEBUT`,
  1 AS `EDT_HEURE_FIN`,
  1 AS `ENS_NOM` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `affectations_enseignants`
--

DROP TABLE IF EXISTS `affectations_enseignants`;
/*!50001 DROP VIEW IF EXISTS `affectations_enseignants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `affectations_enseignants` AS SELECT
 1 AS `ID`,
  1 AS `ENS_MAT_ID`,
  1 AS `MAT_ENS_ID`,
  1 AS `ENS_MAT_ANNEE_ID`,
  1 AS `ENS_MAT_NOTEUR`,
  1 AS `ENS_MAT_EVALUABLE`,
  1 AS `ENS_MAT_EVAL_DATE_DEBUT`,
  1 AS `ENS_MAT_EVAL_DATE_FIN`,
  1 AS `ENS_MAT_POURSUITE`,
  1 AS `MAT_ID`,
  1 AS `MAT_NOM`,
  1 AS `MAT_UE_ID`,
  1 AS `MAT_CODE_APOGE`,
  1 AS `MAT_COEF`,
  1 AS `MAT_SURMAT_ID`,
  1 AS `MAT_HAS_NOTE`,
  1 AS `MAT_LOCK_ANNEE_ID`,
  1 AS `MAT_START_ANNEE_ID`,
  1 AS `MAT_END_ANNEE_ID`,
  1 AS `UE_ID`,
  1 AS `UE_NOM`,
  1 AS `UE_SEM_ID`,
  1 AS `UE_COEF`,
  1 AS `UE_START_ANNEE_ID`,
  1 AS `UE_END_ANNEE_ID`,
  1 AS `SEM_ID`,
  1 AS `SEM_NOM`,
  1 AS `SEM_FORM_ID`,
  1 AS `SEM_COEF`,
  1 AS `SEM_START_ANNEE_ID`,
  1 AS `SEM_END_ANNEE_ID`,
  1 AS `FORM_ID`,
  1 AS `FORM_NOM`,
  1 AS `FORM_DEPT_ID`,
  1 AS `FORM_PRO`,
  1 AS `FORM_EVALUABLE`,
  1 AS `FORM_EVAL_DEBUT`,
  1 AS `FORM_EVAL_FIN`,
  1 AS `FORM_EVAL_PERIODE_ID`,
  1 AS `FORM_CODE_TROMBI`,
  1 AS `FORM_CODE_APOGEE`,
  1 AS `FORM_JURY_DEBUT`,
  1 AS `FORM_JURY_FIN`,
  1 AS `DEPT_ENS_ID`,
  1 AS `ENS_DEPT_ID`,
  1 AS `ENS_DEPT_CURRENT`,
  1 AS `ANNEE_ID`,
  1 AS `ANNEE_NOM`,
  1 AS `ANNEE_COURANTE`,
  1 AS `ANNEE_CLOSE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio15_notes_moyennes_absences`
--

DROP TABLE IF EXISTS `bio15_notes_moyennes_absences`;
/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_absences`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio15_notes_moyennes_absences` AS SELECT
 1 AS `ET_ID`,
  1 AS `MAT_ID`,
  1 AS `MAT_CODE_APOGE`,
  1 AS `ANNEE_ID`,
  1 AS `MOYMAT_REMONTEE`,
  1 AS `ET_NUMERO_ABS` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio15_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `bio15_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio15_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio15_notes_moyennes_export`
--

DROP TABLE IF EXISTS `bio15_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio15_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio15_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `bio15_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio15_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio15_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `bio15_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio15_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio15_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `bio15_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio15_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio15_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `bio15_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio15_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio15_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `bio15_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio15_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio15_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `bio15_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio15_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio63_notes_moyennes_absences`
--

DROP TABLE IF EXISTS `bio63_notes_moyennes_absences`;
/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_absences`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio63_notes_moyennes_absences` AS SELECT
 1 AS `ET_ID`,
  1 AS `MAT_ID`,
  1 AS `MAT_CODE_APOGE`,
  1 AS `ANNEE_ID`,
  1 AS `MOYMAT_REMONTEE`,
  1 AS `ET_NUMERO_ABS` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio63_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `bio63_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio63_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio63_notes_moyennes_export`
--

DROP TABLE IF EXISTS `bio63_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio63_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio63_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `bio63_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio63_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio63_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `bio63_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio63_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio63_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `bio63_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio63_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio63_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `bio63_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio63_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio63_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `bio63_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio63_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `bio63_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `bio63_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `bio63_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `chimie43_notes_moyennes_absences`
--

DROP TABLE IF EXISTS `chimie43_notes_moyennes_absences`;
/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_absences`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `chimie43_notes_moyennes_absences` AS SELECT
 1 AS `ET_ID`,
  1 AS `MAT_ID`,
  1 AS `MAT_CODE_APOGE`,
  1 AS `ANNEE_ID`,
  1 AS `MOYMAT_REMONTEE`,
  1 AS `ET_NUMERO_ABS` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `chimie43_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `chimie43_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `chimie43_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `chimie43_notes_moyennes_export`
--

DROP TABLE IF EXISTS `chimie43_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `chimie43_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `chimie43_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `chimie43_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `chimie43_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `chimie43_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `chimie43_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `chimie43_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `chimie43_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `chimie43_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `chimie43_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `chimie43_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `chimie43_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `chimie43_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `chimie43_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `chimie43_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `chimie43_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `chimie43_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `chimie43_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `chimie43_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `common_absences`
--

DROP TABLE IF EXISTS `common_absences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_absences` (
  `ABS_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ABS_ENS_ID` int(10) unsigned NOT NULL,
  `ABS_ET_ID` int(10) unsigned NOT NULL,
  `ABS_CRENEAU_ID` int(10) unsigned NOT NULL,
  `ABS_COURS_ID` int(10) unsigned NOT NULL,
  `ABS_DATE` char(10) NOT NULL,
  `ABS_JUSTIFICATION` enum('non','medical','convocation','chef') NOT NULL DEFAULT 'non',
  `ABS_EXCUSE` text DEFAULT NULL,
  `ABS_MAIL` tinyint(1) NOT NULL DEFAULT 0,
  `ABS_REAL_DATE` int(11) unsigned NOT NULL,
  `ABS_EXPIRE` tinyint(1) NOT NULL DEFAULT 0,
  `ABS_ANNEE_ID` int(10) unsigned DEFAULT NULL,
  `ABS_EDT_UID` varchar(65) DEFAULT NULL,
  PRIMARY KEY (`ABS_ID`),
  UNIQUE KEY `ABS_ENS_ID_2` (`ABS_ENS_ID`,`ABS_ET_ID`,`ABS_CRENEAU_ID`,`ABS_COURS_ID`,`ABS_REAL_DATE`) USING BTREE,
  KEY `ABS_ENS_ID` (`ABS_ENS_ID`),
  KEY `ABS_ET_ID` (`ABS_ET_ID`),
  KEY `ABS_CREANEAU_ID` (`ABS_CRENEAU_ID`),
  KEY `ABS_COURS_ID` (`ABS_COURS_ID`),
  CONSTRAINT `common_absences_ibfk_1` FOREIGN KEY (`ABS_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_absences_ibfk_2` FOREIGN KEY (`ABS_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_absences_ibfk_3` FOREIGN KEY (`ABS_CRENEAU_ID`) REFERENCES `common_absences_creneau` (`CRENEAU_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_absences_ibfk_4` FOREIGN KEY (`ABS_COURS_ID`) REFERENCES `common_absences_cours` (`COURS_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5632 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_absences_cours`
--

DROP TABLE IF EXISTS `common_absences_cours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_absences_cours` (
  `COURS_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `COURS_NOM` text NOT NULL,
  `COURS_ENS_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`COURS_ID`),
  KEY `COURS_ENS_ID` (`COURS_ENS_ID`),
  CONSTRAINT `common_absences_cours_ibfk_1` FOREIGN KEY (`COURS_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_absences_creneau`
--

DROP TABLE IF EXISTS `common_absences_creneau`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_absences_creneau` (
  `CRENEAU_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CRENEAU_NOM` text NOT NULL,
  `CRENEAU_DEMI` enum('matin','après-midi') NOT NULL,
  `CRENEAU_REAL_START` int(10) unsigned DEFAULT NULL,
  `CRENEAU_REAL_END` int(10) unsigned DEFAULT NULL,
  `CRENEAU_DEPT_ID` int(10) unsigned NOT NULL,
  `CRENEAU_CLASSIQUE` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`CRENEAU_ID`),
  KEY `CRENEAU_DEPT_ID` (`CRENEAU_DEPT_ID`),
  KEY `CRENEAU_DEMI` (`CRENEAU_DEMI`),
  KEY `CRENEAU_REAL_START` (`CRENEAU_REAL_START`),
  KEY `CRENEAU_REAL_END` (`CRENEAU_REAL_END`),
  KEY `CRENEAU_CLASSIQUE` (`CRENEAU_CLASSIQUE`),
  CONSTRAINT `common_absences_creneau_ibfk_1` FOREIGN KEY (`CRENEAU_DEPT_ID`) REFERENCES `common_departement` (`DEPT_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=830 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_absences_justifications`
--

DROP TABLE IF EXISTS `common_absences_justifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_absences_justifications` (
  `JUSTIF_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `JUSTIF_JUSTIFICATION` enum('non','medical','convocation','chef') NOT NULL,
  `JUSTIF_EXCUSE` text NOT NULL,
  `JUSTIF_ET_ID` int(10) unsigned NOT NULL,
  `JUSTIF_DATE_START` int(10) unsigned NOT NULL,
  `JUSTIF_DATE_END` int(10) unsigned NOT NULL,
  `JUSTIF_HEURE_START` int(10) unsigned NOT NULL,
  `JUSTIF_HEURE_END` int(10) unsigned NOT NULL,
  `JUSTIF_ATTENTE` tinyint(1) NOT NULL DEFAULT 0,
  `JUSTIF_CHEMIN` text DEFAULT NULL,
  `JUSTIF_ENS_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`JUSTIF_ID`),
  KEY `JUSTIF_ET_ID` (`JUSTIF_ET_ID`),
  KEY `JUSTIF_ENS_ID` (`JUSTIF_ENS_ID`),
  KEY `JUSTIF_JUSTIFICATION` (`JUSTIF_JUSTIFICATION`),
  KEY `JUSTIF_DATE_START` (`JUSTIF_DATE_START`),
  KEY `JUSTIF_DATE_END` (`JUSTIF_DATE_END`),
  KEY `JUSTIF_HEURE_START` (`JUSTIF_HEURE_START`),
  KEY `JUSTIF_ATTENTE` (`JUSTIF_ATTENTE`),
  CONSTRAINT `common_absences_justifications_ibfk_1` FOREIGN KEY (`JUSTIF_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_absences_justifications_ibfk_2` FOREIGN KEY (`JUSTIF_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21879 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_absences_signatures`
--

DROP TABLE IF EXISTS `common_absences_signatures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_absences_signatures` (
  `SIGNATURE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SIGNATURE_ET_ID` int(10) unsigned DEFAULT NULL,
  `SIGNATURE_EDT_UID` varchar(65) NOT NULL,
  `SIGNATURE_ENS_ID` int(10) unsigned DEFAULT NULL,
  `SIGNATURE_GROUPE_ID` int(10) unsigned NOT NULL,
  `SIGNATURE` mediumtext NOT NULL,
  `SIGNATURE_MAT_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`SIGNATURE_ID`),
  UNIQUE KEY `SIGNATURE_ET_ID_2` (`SIGNATURE_ET_ID`,`SIGNATURE_EDT_UID`,`SIGNATURE_GROUPE_ID`),
  UNIQUE KEY `SIGNATURE_EDT_UID_2` (`SIGNATURE_EDT_UID`,`SIGNATURE_ENS_ID`,`SIGNATURE_GROUPE_ID`),
  KEY `SIGNATURE_ET_ID` (`SIGNATURE_ET_ID`),
  KEY `SIGNATURE_ENS_ID` (`SIGNATURE_ENS_ID`),
  KEY `SIGNATURE_EDT_UID` (`SIGNATURE_EDT_UID`),
  KEY `SIGNATURE_GROUPE_ID` (`SIGNATURE_GROUPE_ID`),
  KEY `SIGNATURE_MAT_ID` (`SIGNATURE_MAT_ID`),
  CONSTRAINT `common_absences_signatures_ibfk_1` FOREIGN KEY (`SIGNATURE_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_absences_signatures_ibfk_2` FOREIGN KEY (`SIGNATURE_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_absences_signatures_ibfk_3` FOREIGN KEY (`SIGNATURE_MAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_absences_signatures_ibfk_4` FOREIGN KEY (`SIGNATURE_GROUPE_ID`) REFERENCES `common_groupes` (`GROUPE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=343390 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_absences_signatures_backup`
--

DROP TABLE IF EXISTS `common_absences_signatures_backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_absences_signatures_backup` (
  `SIGNATURE_ID` int(10) unsigned NOT NULL,
  `SIGNATURE_ET_ID` int(10) unsigned DEFAULT NULL,
  `SIGNATURE_EDT_UID` varchar(65) NOT NULL,
  `SIGNATURE_ENS_ID` int(10) unsigned DEFAULT NULL,
  `SIGNATURE_GROUPE_ID` int(10) unsigned NOT NULL,
  `SIGNATURE` mediumtext NOT NULL,
  `SIGNATURE_MAT_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`SIGNATURE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_absences_type`
--

DROP TABLE IF EXISTS `common_absences_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_absences_type` (
  `ABST_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ABST_NOM` text NOT NULL,
  PRIMARY KEY (`ABST_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_absences_v2`
--

DROP TABLE IF EXISTS `common_absences_v2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_absences_v2` (
  `ABS_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ABS_ENS_ID` int(10) unsigned NOT NULL,
  `ABS_ET_ID` int(10) unsigned NOT NULL,
  `ABS_CRENEAU_ID` int(10) unsigned DEFAULT NULL,
  `ABS_MAT_ID` int(10) unsigned DEFAULT NULL,
  `ABS_DATE` char(10) NOT NULL,
  `ABS_JUSTIFICATION` enum('non','medical','convocation','chef') NOT NULL DEFAULT 'non',
  `ABS_EXCUSE` text DEFAULT NULL,
  `ABS_MAIL` tinyint(1) NOT NULL DEFAULT 0,
  `ABS_REAL_DATE` int(11) unsigned NOT NULL,
  `ABS_EXPIRE` tinyint(1) NOT NULL DEFAULT 0,
  `ABS_ANNEE_ID` int(10) unsigned DEFAULT NULL,
  `ABS_EDT_UID` varchar(65) DEFAULT NULL,
  `ABS_ABST_ID` int(10) unsigned DEFAULT NULL,
  `ABS_JUSTIF_ENS_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ABS_ID`),
  UNIQUE KEY `ABS_ET_ID_2` (`ABS_ET_ID`,`ABS_CRENEAU_ID`,`ABS_REAL_DATE`),
  UNIQUE KEY `ABS_ENS_ID_2` (`ABS_ENS_ID`,`ABS_ET_ID`,`ABS_REAL_DATE`,`ABS_EDT_UID`),
  KEY `ABS_ENS_ID` (`ABS_ENS_ID`),
  KEY `ABS_ET_ID` (`ABS_ET_ID`),
  KEY `ABS_COURS_ID` (`ABS_MAT_ID`),
  KEY `ABS_ANNEE_ID` (`ABS_ANNEE_ID`),
  KEY `ABS_ABST_ID` (`ABS_ABST_ID`),
  KEY `ABS_CRENEAU_ID` (`ABS_CRENEAU_ID`) USING BTREE,
  KEY `ABS_JUSTIF_ENS_ID` (`ABS_JUSTIF_ENS_ID`),
  KEY `ABS_DATE` (`ABS_DATE`),
  KEY `ABS_JUSTIFICATION` (`ABS_JUSTIFICATION`),
  KEY `ABS_MAIL` (`ABS_MAIL`),
  CONSTRAINT `common_absences_v2_ibfk_1` FOREIGN KEY (`ABS_CRENEAU_ID`) REFERENCES `common_absences_creneau` (`CRENEAU_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_absences_v2_ibfk_10` FOREIGN KEY (`ABS_JUSTIF_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `common_absences_v2_ibfk_2` FOREIGN KEY (`ABS_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_absences_v2_ibfk_3` FOREIGN KEY (`ABS_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_absences_v2_ibfk_7` FOREIGN KEY (`ABS_MAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_absences_v2_ibfk_8` FOREIGN KEY (`ABS_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_absences_v2_ibfk_9` FOREIGN KEY (`ABS_ABST_ID`) REFERENCES `common_absences_type` (`ABST_ID`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=291131 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `common_access_absences`
--

DROP TABLE IF EXISTS `common_access_absences`;
/*!50001 DROP VIEW IF EXISTS `common_access_absences`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_absences` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ACCESS_ENSEIGNANT_ID`,
  1 AS `ACCESS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `common_access_admin`
--

DROP TABLE IF EXISTS `common_access_admin`;
/*!50001 DROP VIEW IF EXISTS `common_access_admin`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_admin` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ACCESS_ENSEIGNANT_ID`,
  1 AS `ACCESS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `common_access_direction`
--

DROP TABLE IF EXISTS `common_access_direction`;
/*!50001 DROP VIEW IF EXISTS `common_access_direction`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_direction` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ACCESS_ENSEIGNANT_ID`,
  1 AS `ACCESS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `common_access_edt`
--

DROP TABLE IF EXISTS `common_access_edt`;
/*!50001 DROP VIEW IF EXISTS `common_access_edt`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_edt` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ACCESS_ENSEIGNANT_ID`,
  1 AS `ACCESS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `common_access_emprunt`
--

DROP TABLE IF EXISTS `common_access_emprunt`;
/*!50001 DROP VIEW IF EXISTS `common_access_emprunt`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_emprunt` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ACCESS_ENSEIGNANT_ID`,
  1 AS `ACCESS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `common_access_etudiants`
--

DROP TABLE IF EXISTS `common_access_etudiants`;
/*!50001 DROP VIEW IF EXISTS `common_access_etudiants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_etudiants` AS SELECT
 1 AS `ET_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ET_ID`,
  1 AS `ET_NOM`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `common_access_jury`
--

DROP TABLE IF EXISTS `common_access_jury`;
/*!50001 DROP VIEW IF EXISTS `common_access_jury`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_jury` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ACCESS_ENSEIGNANT_ID`,
  1 AS `ACCESS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `common_access_mediateur`
--

DROP TABLE IF EXISTS `common_access_mediateur`;
/*!50001 DROP VIEW IF EXISTS `common_access_mediateur`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_mediateur` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ACCESS_ENSEIGNANT_ID`,
  1 AS `ACCESS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `common_access_notes`
--

DROP TABLE IF EXISTS `common_access_notes`;
/*!50001 DROP VIEW IF EXISTS `common_access_notes`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_notes` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ACCESS_ENSEIGNANT_ID`,
  1 AS `ACCESS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `common_access_odin_professionnalisation_enseignant`
--

DROP TABLE IF EXISTS `common_access_odin_professionnalisation_enseignant`;
/*!50001 DROP VIEW IF EXISTS `common_access_odin_professionnalisation_enseignant`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_odin_professionnalisation_enseignant` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ACCESS_ENSEIGNANT_ID`,
  1 AS `ACCESS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `common_access_odin_professionnalisation_etudiants`
--

DROP TABLE IF EXISTS `common_access_odin_professionnalisation_etudiants`;
/*!50001 DROP VIEW IF EXISTS `common_access_odin_professionnalisation_etudiants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_odin_professionnalisation_etudiants` AS SELECT
 1 AS `ET_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ET_ID`,
  1 AS `ET_NOM`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `common_access_perso`
--

DROP TABLE IF EXISTS `common_access_perso`;
/*!50001 DROP VIEW IF EXISTS `common_access_perso`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_perso` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ACCESS_ENSEIGNANT_ID`,
  1 AS `ACCESS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `common_access_planning`
--

DROP TABLE IF EXISTS `common_access_planning`;
/*!50001 DROP VIEW IF EXISTS `common_access_planning`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_planning` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ACCESS_ENSEIGNANT_ID`,
  1 AS `ACCESS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `common_access_poursuites`
--

DROP TABLE IF EXISTS `common_access_poursuites`;
/*!50001 DROP VIEW IF EXISTS `common_access_poursuites`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_poursuites` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ACCESS_ENSEIGNANT_ID`,
  1 AS `ACCESS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `common_access_promotion`
--

DROP TABLE IF EXISTS `common_access_promotion`;
/*!50001 DROP VIEW IF EXISTS `common_access_promotion`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_promotion` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ACCESS_ENSEIGNANT_ID`,
  1 AS `ACCESS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `common_access_retour`
--

DROP TABLE IF EXISTS `common_access_retour`;
/*!50001 DROP VIEW IF EXISTS `common_access_retour`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_retour` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ACCESS_ENSEIGNANT_ID`,
  1 AS `ACCESS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `common_access_soutenances`
--

DROP TABLE IF EXISTS `common_access_soutenances`;
/*!50001 DROP VIEW IF EXISTS `common_access_soutenances`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_soutenances` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ACCESS_ENSEIGNANT_ID`,
  1 AS `ACCESS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `common_access_stage`
--

DROP TABLE IF EXISTS `common_access_stage`;
/*!50001 DROP VIEW IF EXISTS `common_access_stage`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_access_stage` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ACCESS_ENSEIGNANT_ID`,
  1 AS `ACCESS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `common_annee`
--

DROP TABLE IF EXISTS `common_annee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_annee` (
  `ANNEE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ANNEE_NOM` text NOT NULL,
  `ANNEE_COURANTE` tinyint(1) NOT NULL DEFAULT 0,
  `ANNEE_CLOSE` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ANNEE_ID`),
  KEY `ANNEE_COURANTE` (`ANNEE_COURANTE`),
  KEY `ANNEE_CLOSE` (`ANNEE_CLOSE`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_backup_ade_enseignant`
--

DROP TABLE IF EXISTS `common_backup_ade_enseignant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_backup_ade_enseignant` (
  `EDT_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EDT_ENS_ID` int(10) unsigned NOT NULL,
  `EDT_NOM` text NOT NULL,
  `EDT_DATE_DEBUT` int(10) unsigned NOT NULL,
  `EDT_DATE_FIN` int(10) unsigned NOT NULL,
  `EDT_HEURE_DEBUT` int(10) unsigned NOT NULL,
  `EDT_HEURE_FIN` int(10) unsigned NOT NULL,
  `EDT_UID` varchar(65) NOT NULL,
  `EDT_SALLE` text NOT NULL,
  `EDT_ANNEE_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`EDT_ID`),
  KEY `EDT_ENS_ID` (`EDT_ENS_ID`),
  KEY `EDT_UID` (`EDT_UID`),
  KEY `EDT_DATE_DEBUT` (`EDT_DATE_DEBUT`),
  KEY `EDT_ANNEE_ID` (`EDT_ANNEE_ID`),
  CONSTRAINT `common_backup_ade_enseignant_ibfk_1` FOREIGN KEY (`EDT_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_backup_ade_enseignant_ibfk_2` FOREIGN KEY (`EDT_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2670465 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_backup_ade_enseignant_nonfacture`
--

DROP TABLE IF EXISTS `common_backup_ade_enseignant_nonfacture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_backup_ade_enseignant_nonfacture` (
  `NONFACTURE_EDT_UID` varchar(65) NOT NULL,
  UNIQUE KEY `idxUnique` (`NONFACTURE_EDT_UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_backup_ade_etudiant`
--

DROP TABLE IF EXISTS `common_backup_ade_etudiant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_backup_ade_etudiant` (
  `EDT_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EDT_GROUPE_ID` int(10) unsigned NOT NULL,
  `EDT_NOM` text NOT NULL,
  `EDT_DATE_DEBUT` int(10) unsigned NOT NULL,
  `EDT_DATE_FIN` int(10) unsigned NOT NULL,
  `EDT_HEURE_DEBUT` int(10) unsigned NOT NULL,
  `EDT_HEURE_FIN` int(10) unsigned NOT NULL,
  `EDT_UID` varchar(65) NOT NULL,
  `EDT_SALLE` text NOT NULL,
  `EDT_ARCHIVE` int(10) unsigned DEFAULT NULL,
  `EDT_ANNEE_ID` int(10) unsigned DEFAULT NULL,
  `EDT_MASQUE` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`EDT_ID`),
  UNIQUE KEY `EDT_GROUPE_ID` (`EDT_GROUPE_ID`,`EDT_DATE_DEBUT`,`EDT_UID`),
  KEY `EDT_ENS_ID` (`EDT_GROUPE_ID`),
  KEY `EDT_UID` (`EDT_UID`),
  KEY `EDT_DATE_DEBUT` (`EDT_DATE_DEBUT`),
  KEY `EDT_ANNEE_ID` (`EDT_ANNEE_ID`),
  CONSTRAINT `common_backup_ade_etudiant_ibfk_1` FOREIGN KEY (`EDT_GROUPE_ID`) REFERENCES `common_groupes` (`GROUPE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_backup_ade_etudiant_ibfk_2` FOREIGN KEY (`EDT_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3297527 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_charge_enseignant`
--

DROP TABLE IF EXISTS `common_charge_enseignant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_charge_enseignant` (
  `CHARGE_AFFECT_ID` int(10) unsigned NOT NULL,
  `CHARGE_PAYEE` int(10) unsigned DEFAULT NULL,
  `CHARGE_CM` decimal(5,2) DEFAULT NULL,
  `CHARGE_TD` decimal(5,2) DEFAULT NULL,
  `CHARGE_TDR` decimal(5,2) DEFAULT NULL,
  `CHARGE_TP` decimal(5,2) DEFAULT NULL,
  `CHARGE_TPR` decimal(5,2) DEFAULT NULL,
  `CHARGE_GROUPES_TD` decimal(4,0) DEFAULT NULL,
  `CHARGE_GROUPES_TDR` decimal(4,0) DEFAULT NULL,
  `CHARGE_GROUPES_TP` decimal(4,0) DEFAULT NULL,
  `CHARGE_GROUPES_CM` decimal(4,0) DEFAULT NULL,
  `CHARGE_GROUPES_TPR` decimal(4,0) DEFAULT NULL,
  `CHARGE_MULT_CM` decimal(5,2) DEFAULT NULL,
  `CHARGE_MULT_TD` decimal(5,2) DEFAULT NULL,
  `CHARGE_MULT_TDR` decimal(5,2) DEFAULT NULL,
  `CHARGE_MULT_TP` decimal(5,2) DEFAULT NULL,
  `CHARGE_MULT_TPR` decimal(5,2) DEFAULT NULL,
  `CHARGE_SEMAINES_CM` decimal(2,0) DEFAULT NULL,
  `CHARGE_SEMAINES_TD` decimal(2,0) DEFAULT NULL,
  `CHARGE_SEMAINES_TDR` decimal(2,0) DEFAULT NULL,
  `CHARGE_SEMAINES_TP` decimal(2,0) DEFAULT NULL,
  `CHARGE_SEMAINES_TPR` decimal(2,0) DEFAULT NULL,
  `CHARGE_COMMENTAIRE` text DEFAULT NULL,
  `CHARGE_DS` decimal(5,2) DEFAULT NULL,
  `CHARGE_GROUPES_DS` decimal(4,0) DEFAULT NULL,
  `CHARGE_MULT_DS` decimal(5,2) DEFAULT NULL,
  `CHARGE_SEMAINES_DS` decimal(2,0) DEFAULT NULL,
  `CHARGE_TPV` decimal(5,2) DEFAULT NULL,
  `CHARGE_GROUPES_TPV` decimal(4,0) DEFAULT NULL,
  `CHARGE_MULT_TPV` decimal(5,2) DEFAULT NULL,
  `CHARGE_SEMAINES_TPV` decimal(2,0) DEFAULT NULL,
  PRIMARY KEY (`CHARGE_AFFECT_ID`),
  CONSTRAINT `common_charge_enseignant_ibfk_1` FOREIGN KEY (`CHARGE_AFFECT_ID`) REFERENCES `common_enseignants_matieres` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_cloture_sem`
--

DROP TABLE IF EXISTS `common_cloture_sem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_cloture_sem` (
  `CLOT_ET_ID` int(10) unsigned NOT NULL,
  `CLOT_SEM_ID` int(10) unsigned NOT NULL,
  `CLOT_ANNEE_ID` int(10) unsigned NOT NULL,
  `CLOT_NOTE` text NOT NULL,
  `CLOT_RANG` int(11) NOT NULL,
  `CLOT_CLASSEMENT` int(11) NOT NULL,
  PRIMARY KEY (`CLOT_ET_ID`,`CLOT_SEM_ID`,`CLOT_ANNEE_ID`),
  KEY `CLOT_ET_ID` (`CLOT_ET_ID`),
  KEY `CLOT_SEM_ID` (`CLOT_SEM_ID`),
  KEY `CLOT_ANNEE_ID` (`CLOT_ANNEE_ID`),
  CONSTRAINT `common_cloture_sem_ibfk_1` FOREIGN KEY (`CLOT_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_cloture_sem_ibfk_2` FOREIGN KEY (`CLOT_SEM_ID`) REFERENCES `common_semestre` (`SEM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_cloture_sem_ibfk_3` FOREIGN KEY (`CLOT_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_cloture_ue`
--

DROP TABLE IF EXISTS `common_cloture_ue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_cloture_ue` (
  `CLOT_ET_ID` int(10) unsigned NOT NULL,
  `CLOT_UE_ID` int(10) unsigned NOT NULL,
  `CLOT_ANNEE_ID` int(10) unsigned NOT NULL,
  `CLOT_SEM_ID` int(10) unsigned NOT NULL,
  `CLOT_NOTE` text NOT NULL,
  `CLOT_RANG` int(11) NOT NULL,
  `CLOT_CLASSEMENT` int(11) NOT NULL,
  PRIMARY KEY (`CLOT_ET_ID`,`CLOT_UE_ID`,`CLOT_ANNEE_ID`,`CLOT_SEM_ID`),
  KEY `CLOT_ET_ID` (`CLOT_ET_ID`),
  KEY `CLOT_UE_ID` (`CLOT_UE_ID`),
  KEY `CLOT_ANNEE_ID` (`CLOT_ANNEE_ID`),
  KEY `CLOT_SEM_ID` (`CLOT_SEM_ID`),
  CONSTRAINT `common_cloture_ue_ibfk_1` FOREIGN KEY (`CLOT_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_cloture_ue_ibfk_2` FOREIGN KEY (`CLOT_UE_ID`) REFERENCES `common_ue` (`UE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_cloture_ue_ibfk_3` FOREIGN KEY (`CLOT_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_cloture_ue_ibfk_4` FOREIGN KEY (`CLOT_SEM_ID`) REFERENCES `common_semestre` (`SEM_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_clotures_moyennes_annee`
--

DROP TABLE IF EXISTS `common_clotures_moyennes_annee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_clotures_moyennes_annee` (
  `MOYAN_VALEUR` decimal(65,36) DEFAULT NULL,
  `MOYAN_ET_ID` int(10) unsigned NOT NULL,
  `MOYAN_FORM_ID` int(10) unsigned NOT NULL,
  `MOYAN_ANNEE_ID` int(10) unsigned NOT NULL,
  `MOYAN_SPECIAL` enum('ABJ','ABI') DEFAULT NULL,
  PRIMARY KEY (`MOYAN_ET_ID`,`MOYAN_FORM_ID`,`MOYAN_ANNEE_ID`),
  KEY `MOYAN_ET_ID` (`MOYAN_ET_ID`),
  KEY `MOYAN_FORM_ID` (`MOYAN_FORM_ID`),
  KEY `MOYAN_ANNEE_ID` (`MOYAN_ANNEE_ID`),
  CONSTRAINT `common_clotures_moyennes_annee_ibfk_1` FOREIGN KEY (`MOYAN_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_annee_ibfk_2` FOREIGN KEY (`MOYAN_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_annee_ibfk_3` FOREIGN KEY (`MOYAN_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_clotures_moyennes_matiere`
--

DROP TABLE IF EXISTS `common_clotures_moyennes_matiere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_clotures_moyennes_matiere` (
  `MOYMAT_COEF` decimal(6,2) NOT NULL,
  `MOYMAT_MAT_ID` int(10) unsigned NOT NULL,
  `MOYMAT_ET_ID` int(10) unsigned NOT NULL,
  `MOYMAT_ANNEE_ID` int(10) unsigned NOT NULL,
  `MOYMAT_UE_ID` int(10) unsigned NOT NULL,
  `MOYMAT_UE_COEF` decimal(5,2) NOT NULL,
  `MOYMAT_SEM_COEF` decimal(5,2) NOT NULL,
  `MOYMAT_SEM_ID` int(10) unsigned NOT NULL,
  `MOYMAT_FORM_ID` int(10) unsigned NOT NULL,
  `MOYMAT_SURMAT_ID` int(10) unsigned DEFAULT NULL,
  `MOYMAT_VALEUR` decimal(45,12) DEFAULT NULL,
  `MOYMAT_SPECIAL` enum('ABJ','ABI') DEFAULT NULL,
  `MOYMAT_BONUS_SPECIAL` enum('ABJ','ABI') DEFAULT NULL,
  PRIMARY KEY (`MOYMAT_MAT_ID`,`MOYMAT_ET_ID`,`MOYMAT_ANNEE_ID`,`MOYMAT_UE_ID`,`MOYMAT_SEM_ID`,`MOYMAT_FORM_ID`),
  KEY `MOYMAT_MAT_ID` (`MOYMAT_MAT_ID`),
  KEY `MOYMAT_ET_ID` (`MOYMAT_ET_ID`),
  KEY `MOYMAT_ANNEE_ID` (`MOYMAT_ANNEE_ID`),
  KEY `MOYMAT_UE_ID` (`MOYMAT_UE_ID`),
  KEY `MOYMAT_SEM_ID` (`MOYMAT_SEM_ID`),
  KEY `MOYMAT_FORM_ID` (`MOYMAT_FORM_ID`),
  KEY `MOYMAT_SURMAT_ID` (`MOYMAT_SURMAT_ID`),
  CONSTRAINT `common_clotures_moyennes_matiere_ibfk_1` FOREIGN KEY (`MOYMAT_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_ibfk_2` FOREIGN KEY (`MOYMAT_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_ibfk_3` FOREIGN KEY (`MOYMAT_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_ibfk_4` FOREIGN KEY (`MOYMAT_MAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_ibfk_5` FOREIGN KEY (`MOYMAT_SEM_ID`) REFERENCES `common_semestre` (`SEM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_ibfk_6` FOREIGN KEY (`MOYMAT_SURMAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_ibfk_7` FOREIGN KEY (`MOYMAT_UE_ID`) REFERENCES `common_ue` (`UE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_clotures_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `common_clotures_moyennes_matiere_sans_bonus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_clotures_moyennes_matiere_sans_bonus` (
  `MOYMAT_VALEUR` decimal(44,12) DEFAULT NULL,
  `MOYMAT_COEF` decimal(6,2) NOT NULL,
  `MOYMAT_MAT_ID` int(10) unsigned NOT NULL,
  `MOYMAT_ET_ID` int(10) unsigned NOT NULL,
  `MOYMAT_ANNEE_ID` int(10) unsigned NOT NULL,
  `MOYMAT_UE_ID` int(10) unsigned NOT NULL,
  `MOYMAT_UE_COEF` decimal(5,2) NOT NULL,
  `MOYMAT_SEM_COEF` decimal(5,2) NOT NULL,
  `MOYMAT_SEM_ID` int(10) unsigned NOT NULL,
  `MOYMAT_FORM_ID` int(10) unsigned NOT NULL,
  `MOYMAT_SURMAT_ID` int(10) unsigned DEFAULT NULL,
  `MOYMAT_SPECIAL` enum('ABJ','ABI') DEFAULT NULL,
  PRIMARY KEY (`MOYMAT_MAT_ID`,`MOYMAT_ET_ID`,`MOYMAT_ANNEE_ID`,`MOYMAT_UE_ID`,`MOYMAT_SEM_ID`,`MOYMAT_FORM_ID`),
  KEY `MOYMAT_MAT_ID` (`MOYMAT_MAT_ID`),
  KEY `MOYMAT_ET_ID` (`MOYMAT_ET_ID`),
  KEY `MOYMAT_ANNEE_ID` (`MOYMAT_ANNEE_ID`),
  KEY `MOYMAT_UE_ID` (`MOYMAT_UE_ID`),
  KEY `MOYMAT_SEM_ID` (`MOYMAT_SEM_ID`),
  KEY `MOYMAT_FORM_ID` (`MOYMAT_FORM_ID`),
  KEY `MOYMAT_SURMAT_ID` (`MOYMAT_SURMAT_ID`),
  CONSTRAINT `common_clotures_moyennes_matiere_sans_bonus_ibfk_1` FOREIGN KEY (`MOYMAT_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_sans_bonus_ibfk_2` FOREIGN KEY (`MOYMAT_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_sans_bonus_ibfk_3` FOREIGN KEY (`MOYMAT_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_sans_bonus_ibfk_4` FOREIGN KEY (`MOYMAT_MAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_sans_bonus_ibfk_5` FOREIGN KEY (`MOYMAT_SEM_ID`) REFERENCES `common_semestre` (`SEM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_sans_bonus_ibfk_6` FOREIGN KEY (`MOYMAT_SURMAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_sans_bonus_ibfk_7` FOREIGN KEY (`MOYMAT_UE_ID`) REFERENCES `common_ue` (`UE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_clotures_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `common_clotures_moyennes_matiere_somme_bonus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_clotures_moyennes_matiere_somme_bonus` (
  `MOYMAT_BONUS_VALEUR` decimal(27,2) DEFAULT NULL,
  `MOYMAT_MAT_ID` int(10) unsigned NOT NULL,
  `MOYMAT_ET_ID` int(10) unsigned NOT NULL,
  `MOYMAT_ANNEE_ID` int(10) unsigned NOT NULL,
  `MOYMAT_UE_ID` int(10) unsigned NOT NULL,
  `MOYMAT_UE_COEF` decimal(5,2) NOT NULL,
  `MOYMAT_SEM_COEF` decimal(5,2) NOT NULL,
  `MOYMAT_SEM_ID` int(10) unsigned NOT NULL,
  `MOYMAT_FORM_ID` int(10) unsigned NOT NULL,
  `MOYMAT_SURMAT_ID` int(10) unsigned DEFAULT NULL,
  `MOYMAT_BONUS_SPECIAL` enum('ABJ','ABI') DEFAULT NULL,
  PRIMARY KEY (`MOYMAT_MAT_ID`,`MOYMAT_ET_ID`,`MOYMAT_ANNEE_ID`,`MOYMAT_UE_ID`,`MOYMAT_SEM_ID`,`MOYMAT_FORM_ID`),
  KEY `MOYMAT_MAT_ID` (`MOYMAT_MAT_ID`),
  KEY `MOYMAT_ET_ID` (`MOYMAT_ET_ID`),
  KEY `MOYMAT_ANNEE_ID` (`MOYMAT_ANNEE_ID`),
  KEY `MOYMAT_UE_ID` (`MOYMAT_UE_ID`),
  KEY `MOYMAT_SEM_ID` (`MOYMAT_SEM_ID`),
  KEY `MOYMAT_FORM_ID` (`MOYMAT_FORM_ID`),
  KEY `MOYMAT_SURMAT_ID` (`MOYMAT_SURMAT_ID`),
  CONSTRAINT `common_clotures_moyennes_matiere_somme_bonus_ibfk_1` FOREIGN KEY (`MOYMAT_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_somme_bonus_ibfk_2` FOREIGN KEY (`MOYMAT_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_somme_bonus_ibfk_3` FOREIGN KEY (`MOYMAT_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_somme_bonus_ibfk_4` FOREIGN KEY (`MOYMAT_MAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_somme_bonus_ibfk_5` FOREIGN KEY (`MOYMAT_SEM_ID`) REFERENCES `common_semestre` (`SEM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_somme_bonus_ibfk_6` FOREIGN KEY (`MOYMAT_SURMAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_matiere_somme_bonus_ibfk_7` FOREIGN KEY (`MOYMAT_UE_ID`) REFERENCES `common_ue` (`UE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_clotures_moyennes_semestre`
--

DROP TABLE IF EXISTS `common_clotures_moyennes_semestre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_clotures_moyennes_semestre` (
  `MOYSEM_VALEUR` decimal(65,30) DEFAULT NULL,
  `MOYSEM_ET_ID` int(10) unsigned NOT NULL,
  `MOYSEM_FORM_ID` int(10) unsigned NOT NULL,
  `MOYSEM_ANNEE_ID` int(10) unsigned NOT NULL,
  `MOYSEM_COEF` decimal(5,2) NOT NULL,
  `MOYSEM_ID` int(10) unsigned NOT NULL,
  `MOYSEM_SPECIAL` enum('ABJ','ABI') DEFAULT NULL,
  PRIMARY KEY (`MOYSEM_ET_ID`,`MOYSEM_FORM_ID`,`MOYSEM_ANNEE_ID`,`MOYSEM_ID`),
  KEY `MOYSEM_ET_ID` (`MOYSEM_ET_ID`),
  KEY `MOYSEM_FORM_ID` (`MOYSEM_FORM_ID`),
  KEY `MOYSEM_ANNEE_ID` (`MOYSEM_ANNEE_ID`),
  KEY `MOYSEM_ID` (`MOYSEM_ID`),
  CONSTRAINT `common_clotures_moyennes_semestre_ibfk_1` FOREIGN KEY (`MOYSEM_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_semestre_ibfk_2` FOREIGN KEY (`MOYSEM_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_semestre_ibfk_3` FOREIGN KEY (`MOYSEM_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_semestre_ibfk_4` FOREIGN KEY (`MOYSEM_ID`) REFERENCES `common_semestre` (`SEM_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_clotures_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `common_clotures_moyennes_surmatieres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_clotures_moyennes_surmatieres` (
  `MOYMAT_VALEUR` decimal(65,18) DEFAULT NULL,
  `MOYMAT_MAT_ID` int(10) unsigned NOT NULL,
  `MOYMAT_COEF` decimal(6,2) NOT NULL,
  `MOYMAT_ET_ID` int(10) unsigned NOT NULL,
  `MOYMAT_ANNEE_ID` int(10) unsigned NOT NULL,
  `MOYMAT_UE_ID` int(10) unsigned NOT NULL,
  `MOYMAT_UE_COEF` decimal(5,2) NOT NULL,
  `MOYMAT_SEM_COEF` decimal(5,2) NOT NULL,
  `MOYMAT_SEM_ID` int(10) unsigned NOT NULL,
  `MOYMAT_FORM_ID` int(10) unsigned NOT NULL,
  `MOYMAT_SPECIAL` enum('ABJ','ABI') DEFAULT NULL,
  PRIMARY KEY (`MOYMAT_MAT_ID`,`MOYMAT_ET_ID`,`MOYMAT_ANNEE_ID`,`MOYMAT_UE_ID`,`MOYMAT_SEM_ID`,`MOYMAT_FORM_ID`),
  KEY `MOYMAT_MAT_ID` (`MOYMAT_MAT_ID`),
  KEY `MOYMAT_ET_ID` (`MOYMAT_ET_ID`),
  KEY `MOYMAT_ANNEE_ID` (`MOYMAT_ANNEE_ID`),
  KEY `MOYMAT_UE_ID` (`MOYMAT_UE_ID`),
  KEY `MOYMAT_SEM_ID` (`MOYMAT_SEM_ID`),
  KEY `MOYMAT_FORM_ID` (`MOYMAT_FORM_ID`),
  CONSTRAINT `common_clotures_moyennes_surmatieres_ibfk_1` FOREIGN KEY (`MOYMAT_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_surmatieres_ibfk_2` FOREIGN KEY (`MOYMAT_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_surmatieres_ibfk_3` FOREIGN KEY (`MOYMAT_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_surmatieres_ibfk_4` FOREIGN KEY (`MOYMAT_MAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_surmatieres_ibfk_5` FOREIGN KEY (`MOYMAT_SEM_ID`) REFERENCES `common_semestre` (`SEM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_surmatieres_ibfk_6` FOREIGN KEY (`MOYMAT_UE_ID`) REFERENCES `common_ue` (`UE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_clotures_moyennes_ue`
--

DROP TABLE IF EXISTS `common_clotures_moyennes_ue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_clotures_moyennes_ue` (
  `MOYUE_VALEUR` decimal(65,24) DEFAULT NULL,
  `MOYUE_ET_ID` int(10) unsigned NOT NULL,
  `MOYUE_ANNEE_ID` int(10) unsigned NOT NULL,
  `MOYUE_UE_ID` int(10) unsigned NOT NULL,
  `MOYUE_COEF` decimal(5,2) NOT NULL,
  `MOYUE_SEM_COEF` decimal(5,2) NOT NULL,
  `MOYUE_SEM_ID` int(10) unsigned NOT NULL,
  `MOYUE_FORM_ID` int(10) unsigned NOT NULL,
  `MOYUE_COEF_CALC` decimal(28,2) NOT NULL,
  `MOYUE_SPECIAL` enum('ABJ','ABI') DEFAULT NULL,
  PRIMARY KEY (`MOYUE_ET_ID`,`MOYUE_ANNEE_ID`,`MOYUE_UE_ID`,`MOYUE_SEM_ID`,`MOYUE_FORM_ID`),
  KEY `MOYUE_ET_ID` (`MOYUE_ET_ID`),
  KEY `MOYUE_ANNEE_ID` (`MOYUE_ANNEE_ID`),
  KEY `MOYUE_UE_ID` (`MOYUE_UE_ID`),
  KEY `MOYUE_SEM_ID` (`MOYUE_SEM_ID`),
  KEY `MOYUE_FORM_ID` (`MOYUE_FORM_ID`),
  CONSTRAINT `common_clotures_moyennes_ue_ibfk_1` FOREIGN KEY (`MOYUE_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_ue_ibfk_2` FOREIGN KEY (`MOYUE_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_ue_ibfk_3` FOREIGN KEY (`MOYUE_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_ue_ibfk_4` FOREIGN KEY (`MOYUE_SEM_ID`) REFERENCES `common_semestre` (`SEM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_moyennes_ue_ibfk_5` FOREIGN KEY (`MOYUE_UE_ID`) REFERENCES `common_ue` (`UE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_clotures_notes`
--

DROP TABLE IF EXISTS `common_clotures_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_clotures_notes` (
  `NOTES_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NOTES_CONTROLE_ID` int(10) unsigned NOT NULL,
  `NOTES_ET_ID` int(10) unsigned NOT NULL,
  `NOTES_VALEUR` decimal(5,2) DEFAULT NULL,
  `NOTES_SPECIAL` enum('ABJ','ABI') DEFAULT NULL,
  `NOTES_AVIS` text DEFAULT NULL,
  PRIMARY KEY (`NOTES_ID`),
  UNIQUE KEY `NOTES_CONTROLE_ID_2` (`NOTES_CONTROLE_ID`,`NOTES_ET_ID`),
  KEY `NOTES_CONTROLE_ID` (`NOTES_CONTROLE_ID`),
  KEY `NOTES_ET_ID` (`NOTES_ET_ID`),
  CONSTRAINT `common_clotures_notes_ibfk_1` FOREIGN KEY (`NOTES_CONTROLE_ID`) REFERENCES `common_controle` (`CONTROLE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_clotures_notes_ibfk_2` FOREIGN KEY (`NOTES_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1686258 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_controle`
--

DROP TABLE IF EXISTS `common_controle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_controle` (
  `CONTROLE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CONTROLE_NOM` text NOT NULL,
  `CONTROLE_MAT_ID` int(10) unsigned NOT NULL,
  `CONTROLE_VALIDE` tinyint(1) NOT NULL DEFAULT 0,
  `CONTROLE_MOYENNE` enum('0','1','2') NOT NULL DEFAULT '1',
  `CONTROLE_VISIBLE` tinyint(1) NOT NULL DEFAULT 1,
  `CONTROLE_BAREME` decimal(6,1) NOT NULL DEFAULT 20.0,
  `CONTROLE_COEFF` decimal(4,2) NOT NULL DEFAULT 1.00,
  `CONTROLE_ANNEE_ID` int(10) unsigned NOT NULL,
  `CONTROLE_ENS_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`CONTROLE_ID`),
  KEY `CONTROLE_MAT_ID` (`CONTROLE_MAT_ID`),
  KEY `CONTROLE_ANNEE_ID` (`CONTROLE_ANNEE_ID`),
  KEY `CONTROLE_ENS_ID` (`CONTROLE_ENS_ID`),
  KEY `CONTROLE_VALIDE` (`CONTROLE_VALIDE`),
  KEY `CONTROLE_MOYENNE` (`CONTROLE_MOYENNE`),
  KEY `CONTROLE_VISIBLE` (`CONTROLE_VISIBLE`),
  CONSTRAINT `common_controle_ibfk_1` FOREIGN KEY (`CONTROLE_MAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_controle_ibfk_2` FOREIGN KEY (`CONTROLE_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_controle_ibfk_3` FOREIGN KEY (`CONTROLE_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24741 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_cron_mail`
--

DROP TABLE IF EXISTS `common_cron_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_cron_mail` (
  `MAIL_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `MAIL_ADRESSE` varchar(200) NOT NULL,
  `MAIL_TITRE` text NOT NULL,
  `MAIL_CORPS` text NOT NULL,
  PRIMARY KEY (`MAIL_ID`),
  UNIQUE KEY `MAIL_ADRESSE` (`MAIL_ADRESSE`)
) ENGINE=InnoDB AUTO_INCREMENT=6360 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_decision_et_ue`
--

DROP TABLE IF EXISTS `common_decision_et_ue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_decision_et_ue` (
  `DECISION_ET_ID` int(10) unsigned NOT NULL,
  `DECISION_UE_ID` int(10) unsigned NOT NULL,
  `DECISION_ANNEE_ID` int(10) unsigned NOT NULL,
  `DECISION` enum('AKI','AKIC','NAKI','?') NOT NULL DEFAULT '?',
  PRIMARY KEY (`DECISION_ET_ID`,`DECISION_UE_ID`,`DECISION_ANNEE_ID`),
  KEY `DECISION_ANNEE_ID` (`DECISION_ANNEE_ID`),
  KEY `DECISION_UE_ID` (`DECISION_UE_ID`),
  CONSTRAINT `common_decision_et_ue_ibfk_1` FOREIGN KEY (`DECISION_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_decision_et_ue_ibfk_2` FOREIGN KEY (`DECISION_UE_ID`) REFERENCES `common_ue` (`UE_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_decision_et_ue_ibfk_3` FOREIGN KEY (`DECISION_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_departement`
--

DROP TABLE IF EXISTS `common_departement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_departement` (
  `DEPT_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DEPT_NOM` text NOT NULL,
  `DEPT_CODE` varchar(10) DEFAULT NULL,
  `DEPT_ENS_ID` int(10) unsigned DEFAULT NULL,
  `DEPT_POURSUITE_DDEB` int(10) unsigned DEFAULT NULL,
  `DEPT_POURSUITE_DFIN` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`DEPT_ID`),
  UNIQUE KEY `DEPT_CODE` (`DEPT_CODE`),
  KEY `DEPT_ENS_ID` (`DEPT_ENS_ID`),
  CONSTRAINT `common_departement_ibfk_1` FOREIGN KEY (`DEPT_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_dispense_matieres`
--

DROP TABLE IF EXISTS `common_dispense_matieres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_dispense_matieres` (
  `DISP_ET_ID` int(10) unsigned NOT NULL,
  `DISP_MAT_ID` int(10) unsigned NOT NULL,
  `DISP_ANNEE_ID` int(10) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`DISP_ET_ID`,`DISP_MAT_ID`,`DISP_ANNEE_ID`),
  KEY `DISP_ET_ID` (`DISP_ET_ID`),
  KEY `DISP_UE_ID` (`DISP_MAT_ID`),
  KEY `DISP_ANNEE_ID` (`DISP_ANNEE_ID`),
  CONSTRAINT `common_dispense_matieres_ibfk_1` FOREIGN KEY (`DISP_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_dispense_matieres_ibfk_2` FOREIGN KEY (`DISP_MAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_dispense_matieres_ibfk_3` FOREIGN KEY (`DISP_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_dispense_ue`
--

DROP TABLE IF EXISTS `common_dispense_ue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_dispense_ue` (
  `DISP_ET_ID` int(10) unsigned NOT NULL,
  `DISP_UE_ID` int(10) unsigned NOT NULL,
  `DISP_ANNEE_ID` int(10) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`DISP_ET_ID`,`DISP_UE_ID`,`DISP_ANNEE_ID`),
  KEY `DISP_ET_ID` (`DISP_ET_ID`),
  KEY `DISP_UE_ID` (`DISP_UE_ID`),
  KEY `DISP_ANNEE_ID` (`DISP_ANNEE_ID`),
  CONSTRAINT `common_dispense_ue_ibfk_1` FOREIGN KEY (`DISP_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_dispense_ue_ibfk_2` FOREIGN KEY (`DISP_UE_ID`) REFERENCES `common_ue` (`UE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_dispense_ue_ibfk_3` FOREIGN KEY (`DISP_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_edt_changement`
--

DROP TABLE IF EXISTS `common_edt_changement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_edt_changement` (
  `DEMANDE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DEMANDE_ENS_ID` int(10) unsigned NOT NULL,
  `DEMANDE_TYPE` set('CHANGEMENT','ANNULATION','CREATION') NOT NULL,
  `DEMANDE_ADE` text DEFAULT NULL,
  `DEMANDE_COMMENTAIRE` text NOT NULL,
  `DEMANDE_EXECUTOR_ENS_ID` int(10) unsigned DEFAULT NULL,
  `DEMANDE_DONE` tinyint(1) NOT NULL DEFAULT 0,
  `DEMANDE_DATE` text DEFAULT NULL,
  `DEMANDE_DEBUT` text DEFAULT NULL,
  `DEMANDE_FIN` text DEFAULT NULL,
  `DEMANDE_NOM` text DEFAULT NULL,
  `DEMANDE_SALLE` text DEFAULT NULL,
  PRIMARY KEY (`DEMANDE_ID`),
  KEY `DEMANDE_ENS_ID` (`DEMANDE_ENS_ID`),
  KEY `DEMANDE_EXECUTOR_ENS_ID` (`DEMANDE_EXECUTOR_ENS_ID`),
  CONSTRAINT `common_edt_changement_ibfk_1` FOREIGN KEY (`DEMANDE_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_edt_changement_ibfk_2` FOREIGN KEY (`DEMANDE_EXECUTOR_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=919 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_edt_commentaires`
--

DROP TABLE IF EXISTS `common_edt_commentaires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_edt_commentaires` (
  `COMMENTAIRE_AFFECT_ID` int(10) unsigned NOT NULL,
  `COMMENTAIRE_FICHE_ID` int(10) unsigned NOT NULL,
  `COMMENTAIRE` text DEFAULT NULL,
  `COMMENTAIRE_FAUSSE` tinyint(1) NOT NULL DEFAULT 0,
  `COMMENTAIRE_DONE` tinyint(1) NOT NULL DEFAULT 0,
  `COMMENTAIRE_GESTIONNAIRE` text DEFAULT NULL,
  PRIMARY KEY (`COMMENTAIRE_AFFECT_ID`) USING BTREE,
  KEY `COMMENTAIRE_FICHE_ID` (`COMMENTAIRE_FICHE_ID`) USING BTREE,
  CONSTRAINT `common_edt_commentaires_ibfk_2` FOREIGN KEY (`COMMENTAIRE_FICHE_ID`) REFERENCES `common_edt_fiche` (`FICHE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_edt_commentaires_ibfk_3` FOREIGN KEY (`COMMENTAIRE_AFFECT_ID`) REFERENCES `common_enseignants_matieres` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_edt_contraintes`
--

DROP TABLE IF EXISTS `common_edt_contraintes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_edt_contraintes` (
  `CONTRAINTE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CONTRAINTE_FICHE_ID` int(10) unsigned NOT NULL,
  `CONTRAINTE_MAT_ID` int(10) unsigned DEFAULT NULL,
  `CONTRAINTE_ENS_ID` int(10) unsigned NOT NULL,
  `CONTRAINTE_CM` text DEFAULT NULL,
  `CONTRAINTE_TD` text DEFAULT NULL,
  `CONTRAINTE_TDR` text DEFAULT NULL,
  `CONTRAINTE_TP` text DEFAULT NULL,
  `CONTRAINTE_GROUPE_TD` text DEFAULT NULL,
  `CONTRAINTE_GROUPE_TDR` text DEFAULT NULL,
  `CONTRAINTE_GROUPE_TP` text DEFAULT NULL,
  `CONTRAINTE_SEMAINES` int(11) DEFAULT NULL,
  `CONTRAINTE_COMMENTAIRE` text DEFAULT NULL,
  `CONTRAINTE_FAUSSE` tinyint(1) NOT NULL DEFAULT 0,
  `CONTRAINTE_DONE` tinyint(1) NOT NULL DEFAULT 0,
  `CONTRAINTE_GESTIONNAIRE` text DEFAULT NULL,
  PRIMARY KEY (`CONTRAINTE_ID`),
  UNIQUE KEY `CONTRAINTE_FICHE_ID_2` (`CONTRAINTE_FICHE_ID`,`CONTRAINTE_MAT_ID`,`CONTRAINTE_ENS_ID`),
  KEY `CONTRAINTE_FICHE_ID` (`CONTRAINTE_FICHE_ID`),
  KEY `CONTRAINTE_MAT_ID` (`CONTRAINTE_MAT_ID`),
  KEY `CONTRAINTE_ENS_ID` (`CONTRAINTE_ENS_ID`),
  CONSTRAINT `common_edt_contraintes_ibfk_1` FOREIGN KEY (`CONTRAINTE_FICHE_ID`) REFERENCES `common_edt_fiche` (`FICHE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_edt_contraintes_ibfk_2` FOREIGN KEY (`CONTRAINTE_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_edt_contraintes_ibfk_3` FOREIGN KEY (`CONTRAINTE_MAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1852 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_edt_exams`
--

DROP TABLE IF EXISTS `common_edt_exams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_edt_exams` (
  `EXAM_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EXAM_FICHE_ID` int(10) unsigned NOT NULL,
  `EXAM_MAT_ID` int(10) unsigned DEFAULT NULL,
  `EXAM_ENS_ID` int(10) unsigned NOT NULL,
  `EXAM_DUREE` text DEFAULT NULL,
  `EXAM_SALLE` text DEFAULT NULL,
  `EXAM_COMMENTAIRE` text DEFAULT NULL,
  `EXAM_DONE` tinyint(1) NOT NULL DEFAULT 0,
  `EXAM_GESTIONNAIRE` text DEFAULT NULL,
  PRIMARY KEY (`EXAM_ID`),
  KEY `EXAM_FICHE_ID` (`EXAM_FICHE_ID`) USING BTREE,
  KEY `EXAM_MAT_ID` (`EXAM_MAT_ID`) USING BTREE,
  KEY `EXAM_ENS_ID` (`EXAM_ENS_ID`) USING BTREE,
  CONSTRAINT `common_edt_exams_ibfk_1` FOREIGN KEY (`EXAM_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_edt_exams_ibfk_2` FOREIGN KEY (`EXAM_FICHE_ID`) REFERENCES `common_edt_fiche` (`FICHE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_edt_exams_ibfk_3` FOREIGN KEY (`EXAM_MAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=436 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_edt_ferie`
--

DROP TABLE IF EXISTS `common_edt_ferie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_edt_ferie` (
  `FERIE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FERIE_SEMAINE` int(11) NOT NULL,
  `FERIE_JOUR` int(11) NOT NULL,
  PRIMARY KEY (`FERIE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_edt_fiche`
--

DROP TABLE IF EXISTS `common_edt_fiche`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_edt_fiche` (
  `FICHE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FICHE_ENS_ID` int(10) unsigned NOT NULL,
  `FICHE_PERIODE_ID` int(10) unsigned NOT NULL,
  `FICHE_ANNEE_ID` int(10) unsigned NOT NULL,
  `FICHE_DATE_MODIFICATION` datetime DEFAULT NULL,
  PRIMARY KEY (`FICHE_ID`),
  UNIQUE KEY `FICHE_ENS_ID_2` (`FICHE_ENS_ID`,`FICHE_PERIODE_ID`,`FICHE_ANNEE_ID`),
  KEY `FICHE_ENS_ID` (`FICHE_ENS_ID`),
  KEY `FICHE_PERIODE_ID` (`FICHE_PERIODE_ID`),
  KEY `FICHE_ANNEE_ID` (`FICHE_ANNEE_ID`),
  CONSTRAINT `common_edt_fiche_ibfk_1` FOREIGN KEY (`FICHE_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_edt_fiche_ibfk_2` FOREIGN KEY (`FICHE_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_edt_fiche_ibfk_3` FOREIGN KEY (`FICHE_PERIODE_ID`) REFERENCES `common_edt_periode` (`PERIODE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3424 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_edt_indisponibilite`
--

DROP TABLE IF EXISTS `common_edt_indisponibilite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_edt_indisponibilite` (
  `DISPO_FICHE_ID` int(10) unsigned NOT NULL,
  `DISPO_INDISPO` int(10) unsigned NOT NULL,
  `DISPO_ENS_ID` int(10) unsigned DEFAULT NULL,
  UNIQUE KEY `DISPO_FICHE_ID_2` (`DISPO_FICHE_ID`,`DISPO_INDISPO`),
  KEY `DISPO_FICHE_ID` (`DISPO_FICHE_ID`) USING BTREE,
  KEY `DISPO_ENS_ID` (`DISPO_ENS_ID`),
  CONSTRAINT `common_edt_indisponibilite_ibfk_1` FOREIGN KEY (`DISPO_FICHE_ID`) REFERENCES `common_edt_fiche` (`FICHE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_edt_indisponibilite_ibfk_2` FOREIGN KEY (`DISPO_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_edt_periode`
--

DROP TABLE IF EXISTS `common_edt_periode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_edt_periode` (
  `PERIODE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PERIODE_NOM` text NOT NULL,
  `PERIODE_PAIEMENT` text DEFAULT NULL,
  `PERIODE_LIMIT` date DEFAULT NULL,
  `PERIODE_LIMIT_NOTES` date DEFAULT NULL,
  `PERIODE_DEBUT_WARNING` date DEFAULT NULL,
  `PERIODE_ANNEE_ID` int(10) unsigned DEFAULT NULL,
  `PERIODE_FORM_ID_1` int(10) unsigned DEFAULT NULL,
  `PERIODE_FORM_ID_2` int(10) unsigned DEFAULT NULL,
  `PERIODE_TYPE` char(1) NOT NULL DEFAULT 'A',
  `PERIODE_DEBUT` date DEFAULT NULL,
  `PERIODE_FIN` date DEFAULT NULL,
  `PERIODE_EXAM_DEBUT` date DEFAULT NULL,
  `PERIODE_EXAM_FIN` date DEFAULT NULL,
  `PERIODE_SEMAINES` int(11) DEFAULT NULL,
  PRIMARY KEY (`PERIODE_ID`),
  KEY `PERIODE_ANNEE_ID` (`PERIODE_ANNEE_ID`),
  KEY `PERIODE_FORM_ID_1` (`PERIODE_FORM_ID_1`),
  KEY `PERIODE_FORM_ID_2` (`PERIODE_FORM_ID_2`),
  CONSTRAINT `common_edt_periode_ibfk_1` FOREIGN KEY (`PERIODE_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_edt_periode_ibfk_2` FOREIGN KEY (`PERIODE_FORM_ID_1`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `common_edt_periode_ibfk_3` FOREIGN KEY (`PERIODE_FORM_ID_2`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=275 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_emprunt`
--

DROP TABLE IF EXISTS `common_emprunt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_emprunt` (
  `EMPRUNT_OBJ_ID` int(10) unsigned NOT NULL,
  `EMPRUNT_ENS_ID` int(10) unsigned NOT NULL,
  `EMPRUNT_ET_ID` int(10) unsigned DEFAULT NULL,
  `EMPRUNT_EXTERNE` text DEFAULT NULL,
  `EMPRUNT_DATE_OUT` date DEFAULT NULL,
  `EMPRUNT_DATE_RETOUR` text DEFAULT NULL,
  `EMPRUNT_NOMBRE` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`EMPRUNT_OBJ_ID`,`EMPRUNT_ENS_ID`),
  KEY `EMPRUNT_OBJ_ID` (`EMPRUNT_OBJ_ID`),
  KEY `EMPRUNT_ENS_ID` (`EMPRUNT_ENS_ID`),
  CONSTRAINT `common_emprunt_ibfk_1` FOREIGN KEY (`EMPRUNT_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_emprunt_ibfk_3` FOREIGN KEY (`EMPRUNT_OBJ_ID`) REFERENCES `common_objet` (`OBJ_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_emprunt_etudiant`
--

DROP TABLE IF EXISTS `common_emprunt_etudiant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_emprunt_etudiant` (
  `EMPRUNT_OBJ_ID` int(10) unsigned NOT NULL,
  `EMPRUNT_ENS_ID` int(10) unsigned NOT NULL,
  `EMPRUNT_ET_ID` int(10) unsigned NOT NULL,
  `EMPRUNT_EXTERNE` text DEFAULT NULL,
  `EMPRUNT_DATE_OUT` date DEFAULT NULL,
  `EMPRUNT_DATE_RETOUR` text DEFAULT NULL,
  `EMPRUNT_NOMBRE` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`EMPRUNT_OBJ_ID`,`EMPRUNT_ET_ID`,`EMPRUNT_ENS_ID`),
  KEY `EMPRUNT_OBJ_ID` (`EMPRUNT_OBJ_ID`),
  KEY `EMPRUNT_ENS_ID` (`EMPRUNT_ET_ID`),
  KEY `EMPRUNT_ET_ENS_ID` (`EMPRUNT_ENS_ID`),
  CONSTRAINT `common_emprunt_etudiant_ibfk_1` FOREIGN KEY (`EMPRUNT_OBJ_ID`) REFERENCES `common_objet` (`OBJ_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_emprunt_etudiant_ibfk_2` FOREIGN KEY (`EMPRUNT_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_emprunt_etudiant_ibfk_3` FOREIGN KEY (`EMPRUNT_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_enseignant`
--

DROP TABLE IF EXISTS `common_enseignant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_enseignant` (
  `ENS_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ENS_NOM` text NOT NULL,
  `ENS_NOM_DE_FAMILLE` text DEFAULT NULL,
  `ENS_PRENOM` text DEFAULT NULL,
  `ENS_LOGIN` varchar(15) DEFAULT NULL,
  `ENS_NAISSANCE` text DEFAULT NULL,
  `ENS_MAIL` text NOT NULL,
  `ENS_PRETEUR` tinyint(1) NOT NULL DEFAULT 0,
  `ENS_ADE` int(10) unsigned DEFAULT NULL,
  `ENS_EDT` tinyint(1) NOT NULL DEFAULT 1,
  `ENS_EDT_HEBDO` tinyint(1) NOT NULL DEFAULT 1,
  `ENS_GESTIONNAIRE_ADE` tinyint(1) NOT NULL DEFAULT 0,
  `ENS_CODE_EMPLOYE` text DEFAULT NULL,
  `ENS_DIRECTION` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ENS_ID`),
  UNIQUE KEY `ENS_LOGIN` (`ENS_LOGIN`),
  UNIQUE KEY `ENS_ADE` (`ENS_ADE`)
) ENGINE=InnoDB AUTO_INCREMENT=1556 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_enseignants_departement`
--

DROP TABLE IF EXISTS `common_enseignants_departement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_enseignants_departement` (
  `DEPT_ENS_ID` int(10) unsigned NOT NULL,
  `ENS_DEPT_ID` int(10) unsigned NOT NULL,
  `ENS_DEPT_CURRENT` tinyint(1) NOT NULL DEFAULT 0,
  `ENS_DEPT_VACATAIRE` tinyint(1) NOT NULL DEFAULT 0,
  `ENS_DEPT_STAGE` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`DEPT_ENS_ID`,`ENS_DEPT_ID`),
  KEY `DEPT_ENS_ID` (`DEPT_ENS_ID`),
  KEY `ENS_DEPT_ID` (`ENS_DEPT_ID`),
  CONSTRAINT `common_enseignants_departement_ibfk_1` FOREIGN KEY (`DEPT_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_enseignants_departement_ibfk_2` FOREIGN KEY (`ENS_DEPT_ID`) REFERENCES `common_departement` (`DEPT_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_enseignants_matieres`
--

DROP TABLE IF EXISTS `common_enseignants_matieres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_enseignants_matieres` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ENS_MAT_ID` int(10) unsigned NOT NULL,
  `MAT_ENS_ID` int(10) unsigned NOT NULL,
  `ENS_MAT_ANNEE_ID` int(10) unsigned NOT NULL,
  `ENS_MAT_NOTEUR` tinyint(1) NOT NULL DEFAULT 1,
  `ENS_MAT_EVALUABLE` tinyint(1) NOT NULL DEFAULT 0,
  `ENS_MAT_EVAL_DATE_DEBUT` int(11) DEFAULT NULL,
  `ENS_MAT_EVAL_DATE_FIN` int(11) DEFAULT NULL,
  `ENS_MAT_POURSUITE` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ENS_MAT_ID_2` (`ENS_MAT_ID`,`MAT_ENS_ID`,`ENS_MAT_ANNEE_ID`),
  KEY `ENS_MAT_ID` (`ENS_MAT_ID`),
  KEY `MAT_ENS_ID` (`MAT_ENS_ID`),
  KEY `ENS_MAT_ANNEE_ID` (`ENS_MAT_ANNEE_ID`),
  CONSTRAINT `common_enseignants_matieres_ibfk_1` FOREIGN KEY (`ENS_MAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_enseignants_matieres_ibfk_2` FOREIGN KEY (`MAT_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_enseignants_matieres_ibfk_3` FOREIGN KEY (`ENS_MAT_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43551 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_etudiant`
--

DROP TABLE IF EXISTS `common_etudiant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_etudiant` (
  `ET_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ET_NOM` text NOT NULL,
  `ET_NOM_DE_FAMILLE` text DEFAULT NULL,
  `ET_PRENOM` text DEFAULT NULL,
  `ET_LOGIN` varchar(15) DEFAULT NULL,
  `ET_NUMERO` char(20) DEFAULT NULL,
  `ET_MAIL` text DEFAULT NULL,
  `ET_NAISSANCE` text DEFAULT NULL,
  `ET_QUIZZBOX` text DEFAULT NULL,
  `ET_BAC` text NOT NULL DEFAULT '',
  `ET_EDT` tinyint(1) NOT NULL DEFAULT 1,
  `ET_TIERS` tinyint(1) NOT NULL DEFAULT 0,
  `ET_RED` text DEFAULT NULL,
  `ET_SPORTIF` tinyint(1) NOT NULL DEFAULT 0,
  `ET_DEM` tinyint(1) NOT NULL DEFAULT 0,
  `ET_PROFESSIONNALISATION` tinyint(1) NOT NULL DEFAULT 0,
  `ET_TEL` text DEFAULT NULL,
  `ET_ORIGINE` text DEFAULT NULL,
  `ET_ENTREPRISE` text DEFAULT NULL,
  `ET_ADRESSE` text DEFAULT NULL,
  `ET_ADRESSE_2` text DEFAULT NULL,
  `ET_ADRESSE_ENTREPRISE` text DEFAULT NULL,
  `ET_DEBUT` text DEFAULT NULL,
  `ET_HEURES_MAX` int(11) NOT NULL DEFAULT 0,
  `ET_HEURES_FACTUREES` decimal(6,2) NOT NULL DEFAULT 0.00,
  `ET_TUTEUR_ENS_ID` int(10) unsigned DEFAULT NULL,
  `ET_LIEU` text DEFAULT NULL,
  `ET_TUTEUR` text DEFAULT NULL,
  `ET_MAIL_TUTEUR` text DEFAULT NULL,
  `ET_TEL_TUTEUR` text DEFAULT NULL,
  `ET_INFO_LIEU` text DEFAULT NULL,
  `ET_MAX_SEMAINE` int(11) NOT NULL DEFAULT 35,
  PRIMARY KEY (`ET_ID`),
  UNIQUE KEY `ET_NUMERO` (`ET_NUMERO`),
  UNIQUE KEY `ET_LOGIN` (`ET_LOGIN`,`ET_NUMERO`),
  KEY `ET_TUTEUR_ENS_ID` (`ET_TUTEUR_ENS_ID`),
  KEY `ET_DEM` (`ET_DEM`),
  CONSTRAINT `common_etudiant_ibfk_1` FOREIGN KEY (`ET_TUTEUR_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8314 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_etudiant_champs_renseignement`
--

DROP TABLE IF EXISTS `common_etudiant_champs_renseignement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_etudiant_champs_renseignement` (
  `CHAMPS_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CHAMPS_TYPE` enum('text','number','radio','checkbox') NOT NULL,
  `CHAMPS_LABEL` text NOT NULL,
  `CHAMPS_OBLIGATOIRE` tinyint(1) NOT NULL DEFAULT 0,
  `CHAMPS_FORM_ID` int(10) unsigned NOT NULL,
  `CHAMPS_ORDRE` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`CHAMPS_ID`),
  KEY `CHAMPS_FORM_ID` (`CHAMPS_FORM_ID`),
  CONSTRAINT `common_etudiant_champs_renseignement_ibfk_1` FOREIGN KEY (`CHAMPS_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=744 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_etudiant_groupes`
--

DROP TABLE IF EXISTS `common_etudiant_groupes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_etudiant_groupes` (
  `ET_GROUPE_CODE` varchar(100) NOT NULL,
  `GROUPE_ET_ID` int(10) unsigned NOT NULL,
  `ET_GROUPE_ANNEE_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ET_GROUPE_CODE`,`GROUPE_ET_ID`,`ET_GROUPE_ANNEE_ID`),
  KEY `ET_GROUPE_ID` (`ET_GROUPE_CODE`),
  KEY `GROUPE_ET_ID` (`GROUPE_ET_ID`),
  KEY `ET_GROUPE_ANNEE_ID` (`ET_GROUPE_ANNEE_ID`),
  CONSTRAINT `common_etudiant_groupes_ibfk_2` FOREIGN KEY (`GROUPE_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_etudiant_groupes_ibfk_3` FOREIGN KEY (`ET_GROUPE_CODE`) REFERENCES `common_groupes` (`GROUPE_CODE`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_etudiant_groupes_ibfk_4` FOREIGN KEY (`ET_GROUPE_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_etudiant_renseignement`
--

DROP TABLE IF EXISTS `common_etudiant_renseignement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_etudiant_renseignement` (
  `CHAMPS_ET_ID` int(10) unsigned NOT NULL,
  `ET_CHAMPS_ID` int(10) unsigned NOT NULL,
  `CHAMPS_ET_VALEUR` text NOT NULL,
  PRIMARY KEY (`CHAMPS_ET_ID`,`ET_CHAMPS_ID`),
  KEY `ET_CHAMPS_ID` (`ET_CHAMPS_ID`),
  CONSTRAINT `common_etudiant_renseignement_ibfk_1` FOREIGN KEY (`CHAMPS_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_etudiant_renseignement_ibfk_2` FOREIGN KEY (`ET_CHAMPS_ID`) REFERENCES `common_etudiant_champs_renseignement` (`CHAMPS_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_eval_groupe_enseignement`
--

DROP TABLE IF EXISTS `common_eval_groupe_enseignement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_eval_groupe_enseignement` (
  `GROUPE_ID_ID` int(10) unsigned NOT NULL,
  `ID_GROUPE_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`GROUPE_ID_ID`,`ID_GROUPE_ID`),
  KEY `ID_GROUPE_ID` (`ID_GROUPE_ID`),
  CONSTRAINT `common_eval_groupe_enseignement_ibfk_1` FOREIGN KEY (`GROUPE_ID_ID`) REFERENCES `common_enseignants_matieres` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_eval_groupe_enseignement_ibfk_2` FOREIGN KEY (`ID_GROUPE_ID`) REFERENCES `common_groupes` (`GROUPE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_eval_questions`
--

DROP TABLE IF EXISTS `common_eval_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_eval_questions` (
  `EVALQ_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EVALQ_QUESTION` text NOT NULL,
  `EVALQ_EVALT_ID` int(10) unsigned NOT NULL,
  `EVALQ_ORDRE` int(10) unsigned NOT NULL,
  `EVALQ_FORM_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`EVALQ_ID`),
  KEY `EVALQ_EVALT_ID` (`EVALQ_EVALT_ID`),
  KEY `EVALQ_FORM_ID` (`EVALQ_FORM_ID`),
  CONSTRAINT `common_eval_questions_ibfk_1` FOREIGN KEY (`EVALQ_EVALT_ID`) REFERENCES `common_eval_type` (`EVALT_ID`),
  CONSTRAINT `common_eval_questions_ibfk_2` FOREIGN KEY (`EVALQ_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_eval_reponse`
--

DROP TABLE IF EXISTS `common_eval_reponse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_eval_reponse` (
  `EVALR_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EVALR_EVALQ_ID` int(10) unsigned NOT NULL,
  `EVALR_REPONSE` text NOT NULL,
  `EVALR_ORDRE` int(10) unsigned NOT NULL,
  PRIMARY KEY (`EVALR_ID`),
  KEY `EVALR_EVALQ_ID` (`EVALR_EVALQ_ID`),
  CONSTRAINT `common_eval_reponse_ibfk_1` FOREIGN KEY (`EVALR_EVALQ_ID`) REFERENCES `common_eval_questions` (`EVALQ_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_eval_type`
--

DROP TABLE IF EXISTS `common_eval_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_eval_type` (
  `EVALT_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EVALT_TYPE` text NOT NULL,
  PRIMARY KEY (`EVALT_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_evaluation`
--

DROP TABLE IF EXISTS `common_evaluation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_evaluation` (
  `EVAL_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EVAL_ET_ID` int(10) unsigned NOT NULL,
  `EVAL_AFFECT_ID` int(10) unsigned NOT NULL,
  `EVAL_REPONSE` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `EVAL_QUESTION` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `EVAL_Q_ORDRE` int(10) unsigned NOT NULL,
  PRIMARY KEY (`EVAL_ID`),
  KEY `EVAL_ET_ID` (`EVAL_ET_ID`),
  KEY `EVAL_AFFECT_ID` (`EVAL_AFFECT_ID`),
  CONSTRAINT `common_evaluation_ibfk_1` FOREIGN KEY (`EVAL_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_evaluation_ibfk_2` FOREIGN KEY (`EVAL_AFFECT_ID`) REFERENCES `common_enseignants_matieres` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23199 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_formation`
--

DROP TABLE IF EXISTS `common_formation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_formation` (
  `FORM_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FORM_NOM` text NOT NULL,
  `FORM_NOM_COURT` text DEFAULT NULL,
  `FORM_REGIME` text DEFAULT NULL,
  `FORM_DEPT_ID` int(10) unsigned DEFAULT NULL,
  `FORM_PRO` tinyint(1) NOT NULL DEFAULT 0,
  `FORM_EVALUABLE` tinyint(1) NOT NULL DEFAULT 0,
  `FORM_EVAL_DEBUT` int(10) unsigned DEFAULT NULL,
  `FORM_EVAL_FIN` int(10) unsigned DEFAULT NULL,
  `FORM_EVAL_PERIODE_ID` int(10) unsigned DEFAULT NULL,
  `FORM_CODE_TROMBI` text DEFAULT NULL,
  `FORM_CODE_APOGEE` text NOT NULL DEFAULT 'DEF',
  `FORM_JURY_DEBUT` int(11) DEFAULT NULL,
  `FORM_JURY_FIN` int(11) DEFAULT NULL,
  `FORM_CANDIDATURES_STAGE_MAX` tinyint(3) unsigned NOT NULL DEFAULT 3,
  `FORM_CANDIDATURES_STAGE_ET_MAX` tinyint(3) unsigned NOT NULL DEFAULT 3,
  `FORM_NOTE_MIN_VAL_SEMESTRE` decimal(4,2) DEFAULT NULL,
  `FORM_NOTE_MIN_VAL_UE` decimal(4,2) DEFAULT NULL,
  `FORM_MOYENNE_MIN_VAL_SEMESTRE` decimal(4,2) DEFAULT NULL,
  `FORM_MOYENNE_MIN_VAL_ANNEE` decimal(4,2) DEFAULT NULL,
  `FORM_NOTE_MIN_VAL_UE_COMP` decimal(4,2) DEFAULT NULL,
  `FORM_ABSENCES_AUTO` tinyint(1) NOT NULL DEFAULT 0,
  `FORM_AUTORISE_SIGNATURES_ANTICIPEES` tinyint(1) NOT NULL DEFAULT 0,
  `FORM_START_ANNEE_ID` int(10) unsigned DEFAULT 1,
  `FORM_END_ANNEE_ID` int(10) unsigned DEFAULT NULL,
  `FORM_SIGNATURE_SUR_TABLETTES` tinyint(1) NOT NULL DEFAULT 0,
  `FORM_MINUTES_SIGNATURES` int(11) NOT NULL DEFAULT 20,
  PRIMARY KEY (`FORM_ID`),
  KEY `FORM_DEPT_ID` (`FORM_DEPT_ID`),
  KEY `FORM_EVAL_PERIODE_ID` (`FORM_EVAL_PERIODE_ID`),
  KEY `FORM_START_ANNEE_ID` (`FORM_START_ANNEE_ID`),
  KEY `FORM_END_ANNEE_ID` (`FORM_END_ANNEE_ID`),
  KEY `FORM_PRO` (`FORM_PRO`),
  KEY `FORM_ABSENCES_AUTO` (`FORM_ABSENCES_AUTO`),
  CONSTRAINT `common_formation_ibfk_2` FOREIGN KEY (`FORM_DEPT_ID`) REFERENCES `common_departement` (`DEPT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_formation_ibfk_3` FOREIGN KEY (`FORM_EVAL_PERIODE_ID`) REFERENCES `common_edt_periode` (`PERIODE_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `common_formation_ibfk_4` FOREIGN KEY (`FORM_START_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`),
  CONSTRAINT `common_formation_ibfk_5` FOREIGN KEY (`FORM_END_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_groupes`
--

DROP TABLE IF EXISTS `common_groupes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_groupes` (
  `GROUPE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GROUPE_NOM` text NOT NULL,
  `GROUPE_ENS_ID` int(10) unsigned DEFAULT NULL,
  `GROUPE_FEUILLE` tinyint(1) NOT NULL DEFAULT 0,
  `GROUPE_PARENT` int(10) unsigned DEFAULT NULL,
  `GROUPE_CODE` varchar(100) DEFAULT NULL,
  `GROUPE_ADE` int(10) unsigned DEFAULT NULL,
  `GROUPE_FORM_ID` int(10) unsigned DEFAULT NULL,
  `GROUPE_POURSUITE` tinyint(1) NOT NULL DEFAULT 0,
  `GROUPE_DELETED` tinyint(1) NOT NULL DEFAULT 0,
  `GROUPE_PRO` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`GROUPE_ID`),
  UNIQUE KEY `GROUPE_CODE` (`GROUPE_CODE`),
  KEY `GROUPE_ENS_ID` (`GROUPE_ENS_ID`),
  KEY `GROUPE_PARENT` (`GROUPE_PARENT`),
  KEY `GROUPE_FORM_ID` (`GROUPE_FORM_ID`),
  KEY `GROUPE_DELETED` (`GROUPE_DELETED`),
  KEY `GROUPE_FEUILLE` (`GROUPE_FEUILLE`),
  KEY `GROUPE_ADE` (`GROUPE_ADE`),
  CONSTRAINT `common_groupes_ibfk_1` FOREIGN KEY (`GROUPE_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `common_groupes_ibfk_2` FOREIGN KEY (`GROUPE_PARENT`) REFERENCES `common_groupes` (`GROUPE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_groupes_ibfk_3` FOREIGN KEY (`GROUPE_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1613 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_inscription`
--

DROP TABLE IF EXISTS `common_inscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_inscription` (
  `INSCRIPT_ET_ID` int(10) unsigned NOT NULL,
  `INSCRIPT_ANNEE_ID` int(10) unsigned NOT NULL,
  `INSCRIPT_SEM_ID` int(10) unsigned NOT NULL,
  `INSCRIPT_DISP` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`INSCRIPT_ET_ID`,`INSCRIPT_ANNEE_ID`,`INSCRIPT_SEM_ID`),
  KEY `INSCRIPT_ANNEE_ID` (`INSCRIPT_ANNEE_ID`),
  KEY `INSCRIPT_ET_ID` (`INSCRIPT_ET_ID`),
  KEY `INSCRIPT_SEM_ID` (`INSCRIPT_SEM_ID`),
  CONSTRAINT `common_inscription_ibfk_2` FOREIGN KEY (`INSCRIPT_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_inscription_ibfk_3` FOREIGN KEY (`INSCRIPT_SEM_ID`) REFERENCES `common_semestre` (`SEM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_inscription_ibfk_4` FOREIGN KEY (`INSCRIPT_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_jury`
--

DROP TABLE IF EXISTS `common_jury`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_jury` (
  `JURY_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `JURY_NOM` text NOT NULL,
  `JURY_ANNEE_ID` int(10) unsigned NOT NULL,
  `JURY_FORM_ID` int(10) unsigned NOT NULL,
  `JURY_START` int(10) unsigned DEFAULT NULL,
  `JURY_END` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`JURY_ID`),
  KEY `JURY_ANNEE_ID` (`JURY_ANNEE_ID`),
  KEY `JURY_FORM_ID` (`JURY_FORM_ID`),
  CONSTRAINT `common_jury_ibfk_1` FOREIGN KEY (`JURY_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_jury_ibfk_2` FOREIGN KEY (`JURY_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_jury_groupe`
--

DROP TABLE IF EXISTS `common_jury_groupe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_jury_groupe` (
  `GROUPE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GROUPE_NOM` text NOT NULL,
  `GROUPE_FORM_ID` int(10) unsigned NOT NULL,
  `GROUPE_JURY_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`GROUPE_ID`),
  KEY `GROUPE_FORM_ID` (`GROUPE_FORM_ID`),
  KEY `GROUPE_JURY_ID` (`GROUPE_JURY_ID`),
  CONSTRAINT `common_jury_groupe_ibfk_1` FOREIGN KEY (`GROUPE_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_jury_groupe_ibfk_2` FOREIGN KEY (`GROUPE_JURY_ID`) REFERENCES `common_jury` (`JURY_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_jury_groupe_etudiant`
--

DROP TABLE IF EXISTS `common_jury_groupe_etudiant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_jury_groupe_etudiant` (
  `GROUPE_ET_ID` int(10) unsigned NOT NULL,
  `ET_GROUPE_ID` int(10) unsigned NOT NULL,
  KEY `GROUPE_ET_ID` (`GROUPE_ET_ID`),
  KEY `ET_GROUPE_ID` (`ET_GROUPE_ID`),
  CONSTRAINT `common_jury_groupe_etudiant_ibfk_1` FOREIGN KEY (`GROUPE_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_jury_groupe_etudiant_ibfk_2` FOREIGN KEY (`ET_GROUPE_ID`) REFERENCES `common_jury_groupe` (`GROUPE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_jury_vote`
--

DROP TABLE IF EXISTS `common_jury_vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_jury_vote` (
  `VOTE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `VOTE_NOM` text NOT NULL,
  `VOTE_JURY_ID` int(10) unsigned NOT NULL,
  `VOTE_ET_ID` int(10) unsigned NOT NULL,
  `VOTE_GROUPE_ID` int(10) unsigned NOT NULL,
  `VOTE_CLOT` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`VOTE_ID`),
  KEY `VOTE_JURY_ID` (`VOTE_JURY_ID`),
  KEY `VOTE_ET_ID` (`VOTE_ET_ID`),
  KEY `VOTE_GROUPE_ID` (`VOTE_GROUPE_ID`),
  CONSTRAINT `common_jury_vote_ibfk_1` FOREIGN KEY (`VOTE_JURY_ID`) REFERENCES `common_jury` (`JURY_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_jury_vote_ibfk_2` FOREIGN KEY (`VOTE_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_jury_vote_ibfk_3` FOREIGN KEY (`VOTE_GROUPE_ID`) REFERENCES `common_jury_groupe` (`GROUPE_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_jury_vote_enseignant`
--

DROP TABLE IF EXISTS `common_jury_vote_enseignant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_jury_vote_enseignant` (
  `ENS_VOTE_ID` int(10) unsigned NOT NULL,
  `VOTE_ENS_ID` int(10) unsigned NOT NULL,
  `VOTE_VALEUR` enum('Pour','Contre','Abstention') NOT NULL,
  PRIMARY KEY (`ENS_VOTE_ID`,`VOTE_ENS_ID`),
  KEY `VOTE_ENS_ID` (`VOTE_ENS_ID`),
  CONSTRAINT `common_jury_vote_enseignant_ibfk_1` FOREIGN KEY (`ENS_VOTE_ID`) REFERENCES `common_jury_vote` (`VOTE_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_jury_vote_enseignant_ibfk_2` FOREIGN KEY (`VOTE_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_log`
--

DROP TABLE IF EXISTS `common_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_log` (
  `LOG_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `LOG` text NOT NULL,
  PRIMARY KEY (`LOG_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=287 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `common_logon`
--

DROP TABLE IF EXISTS `common_logon`;
/*!50001 DROP VIEW IF EXISTS `common_logon`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `common_logon` AS SELECT
 1 AS `FORM_ID`,
  1 AS `DEPT_ID`,
  1 AS `LOGON_ENS_ID`,
  1 AS `TYPE` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `common_matiere`
--

DROP TABLE IF EXISTS `common_matiere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_matiere` (
  `MAT_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `MAT_NOM` text NOT NULL,
  `MAT_UE_ID` int(10) unsigned NOT NULL,
  `MAT_CODE_APOGE` text NOT NULL,
  `MAT_COEF` decimal(6,2) NOT NULL DEFAULT 1.00,
  `MAT_SURMAT_ID` int(10) unsigned DEFAULT NULL,
  `MAT_HAS_NOTE` tinyint(1) NOT NULL DEFAULT 1,
  `MAT_LOCK_ANNEE_ID` int(10) unsigned DEFAULT 1,
  `MAT_START_ANNEE_ID` int(10) unsigned DEFAULT NULL,
  `MAT_END_ANNEE_ID` int(10) unsigned DEFAULT NULL,
  `MAT_ORDRE` int(11) NOT NULL DEFAULT 1,
  `MAT_COPIE_MAT_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`MAT_ID`),
  KEY `MAT_UE_ID` (`MAT_UE_ID`),
  KEY `MAT_SURMAT_ID` (`MAT_SURMAT_ID`),
  KEY `MAT_LOCK_ANNEE_ID` (`MAT_LOCK_ANNEE_ID`),
  KEY `MAT_ANNEE_ID` (`MAT_START_ANNEE_ID`),
  KEY `MAT_END_ANNEE_ID` (`MAT_END_ANNEE_ID`),
  KEY `MAT_COPIE_MAT_ID` (`MAT_COPIE_MAT_ID`),
  KEY `MAT_HAS_NOTE` (`MAT_HAS_NOTE`),
  CONSTRAINT `common_matiere_ibfk_1` FOREIGN KEY (`MAT_UE_ID`) REFERENCES `common_ue` (`UE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_matiere_ibfk_2` FOREIGN KEY (`MAT_SURMAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `common_matiere_ibfk_3` FOREIGN KEY (`MAT_LOCK_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `common_matiere_ibfk_4` FOREIGN KEY (`MAT_START_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_matiere_ibfk_5` FOREIGN KEY (`MAT_END_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_matiere_ibfk_6` FOREIGN KEY (`MAT_COPIE_MAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20875 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_notes`
--

DROP TABLE IF EXISTS `common_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_notes` (
  `NOTES_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NOTES_CONTROLE_ID` int(10) unsigned NOT NULL,
  `NOTES_ET_ID` int(10) unsigned NOT NULL,
  `NOTES_VALEUR` decimal(5,2) DEFAULT NULL,
  `NOTES_SPECIAL` enum('ABJ','ABI') DEFAULT NULL,
  `NOTES_AVIS` text DEFAULT NULL,
  PRIMARY KEY (`NOTES_ID`),
  UNIQUE KEY `NOTES_CONTROLE_ID_2` (`NOTES_CONTROLE_ID`,`NOTES_ET_ID`),
  KEY `NOTES_CONTROLE_ID` (`NOTES_CONTROLE_ID`),
  KEY `NOTES_ET_ID` (`NOTES_ET_ID`),
  KEY `NOTES_VALEUR` (`NOTES_VALEUR`),
  KEY `NOTES_SPECIAL` (`NOTES_SPECIAL`),
  CONSTRAINT `common_notes_ibfk_1` FOREIGN KEY (`NOTES_CONTROLE_ID`) REFERENCES `common_controle` (`CONTROLE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_notes_ibfk_2` FOREIGN KEY (`NOTES_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1765312 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_objet`
--

DROP TABLE IF EXISTS `common_objet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_objet` (
  `OBJ_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `OBJ_NOM` text NOT NULL,
  `OBJ_LIEU` text NOT NULL,
  `OBJ_STOCK` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`OBJ_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_periodes_matieres`
--

DROP TABLE IF EXISTS `common_periodes_matieres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_periodes_matieres` (
  `PERIODE_MAT_ID` int(10) unsigned NOT NULL,
  `MAT_PERIODE_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`PERIODE_MAT_ID`,`MAT_PERIODE_ID`),
  KEY `PERIODE_MAT_IS` (`PERIODE_MAT_ID`),
  KEY `MAT_PERIODE_ID` (`MAT_PERIODE_ID`),
  CONSTRAINT `common_periodes_matieres_ibfk_1` FOREIGN KEY (`MAT_PERIODE_ID`) REFERENCES `common_edt_periode` (`PERIODE_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_periodes_matieres_ibfk_2` FOREIGN KEY (`PERIODE_MAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_planning`
--

DROP TABLE IF EXISTS `common_planning`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_planning` (
  `PLANNING_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PLANNING_DEPT_ID` int(10) unsigned NOT NULL,
  `PLANNING_ANNEE_ID` int(10) unsigned DEFAULT NULL,
  `PLANNING_CONTENU` text NOT NULL,
  `PLANNING_START_ENS` int(10) unsigned DEFAULT NULL,
  `PLANNING_END_ENS` int(10) unsigned DEFAULT NULL,
  `PLANNING_START_ET` int(10) unsigned DEFAULT NULL,
  `PLANNING_END_ET` int(10) unsigned DEFAULT NULL,
  `PLANNING_START` int(10) unsigned DEFAULT NULL,
  `PLANNING_END` int(10) unsigned DEFAULT NULL,
  `PLANNING_NB_PARALLELE` int(10) unsigned NOT NULL DEFAULT 0,
  `PLANNING_UID` text NOT NULL,
  `PLANNING_PUBLIC` tinyint(4) DEFAULT 0,
  `PLANNING_NB_MEMBRES` int(10) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`PLANNING_ID`),
  UNIQUE KEY `PLANNING_UID` (`PLANNING_UID`) USING HASH,
  KEY `PLANNING_DEPT_ID` (`PLANNING_DEPT_ID`),
  KEY `PLANNING_ANNEE_ID` (`PLANNING_ANNEE_ID`),
  CONSTRAINT `common_planning_ibfk_1` FOREIGN KEY (`PLANNING_DEPT_ID`) REFERENCES `common_departement` (`DEPT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_planning_ibfk_2` FOREIGN KEY (`PLANNING_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_planning_creneau`
--

DROP TABLE IF EXISTS `common_planning_creneau`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_planning_creneau` (
  `CRENEAU_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CRENEAU_PLANNING_ID` int(10) unsigned NOT NULL,
  `CRENEAU_DEBUT` int(10) unsigned NOT NULL,
  `CRENEAU_FIN` int(10) unsigned NOT NULL,
  PRIMARY KEY (`CRENEAU_ID`),
  UNIQUE KEY `CRENEAU_SESSION_ID` (`CRENEAU_PLANNING_ID`,`CRENEAU_DEBUT`,`CRENEAU_FIN`),
  KEY `CRENEAU_DEBUT` (`CRENEAU_DEBUT`),
  KEY `CRENEAU_FIN` (`CRENEAU_FIN`),
  CONSTRAINT `common_planning_creneau_ibfk_1` FOREIGN KEY (`CRENEAU_PLANNING_ID`) REFERENCES `common_planning` (`PLANNING_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_planning_dispo_enseignant`
--

DROP TABLE IF EXISTS `common_planning_dispo_enseignant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_planning_dispo_enseignant` (
  `DISPO_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CRENEAU_ENS_ID` int(10) unsigned NOT NULL,
  `DISPO_CRENEAU_ID` int(10) unsigned NOT NULL,
  `DISPO_DATE` int(11) NOT NULL,
  `DISPO_PLANNING_ID` int(10) unsigned DEFAULT NULL,
  `DISPO_ENS_PRESENTIEL` tinyint(1) NOT NULL DEFAULT 1,
  `DISPO_ENS_TELEPHONIQUE` tinyint(1) NOT NULL DEFAULT 1,
  `DISPO_ENS_VISIO` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`DISPO_ID`),
  UNIQUE KEY `CRENEAU_ENS_ID_2` (`CRENEAU_ENS_ID`,`DISPO_CRENEAU_ID`,`DISPO_DATE`),
  KEY `common_planning_creneau_enseignant_ibfk_2` (`DISPO_CRENEAU_ID`),
  KEY `CRENEAU_ENS_ID` (`CRENEAU_ENS_ID`),
  KEY `DISPO_PLANNING_ID` (`DISPO_PLANNING_ID`),
  CONSTRAINT `common_planning_dispo_enseignant_ibfk_1` FOREIGN KEY (`CRENEAU_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_planning_dispo_enseignant_ibfk_2` FOREIGN KEY (`DISPO_CRENEAU_ID`) REFERENCES `common_planning_creneau` (`CRENEAU_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_planning_dispo_enseignant_ibfk_3` FOREIGN KEY (`DISPO_PLANNING_ID`) REFERENCES `common_planning` (`PLANNING_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2138 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_planning_enseignant`
--

DROP TABLE IF EXISTS `common_planning_enseignant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_planning_enseignant` (
  `ENS_PLANNING_ID` int(10) unsigned NOT NULL,
  `PLANNING_ENS_ID` int(10) unsigned NOT NULL,
  `PLANNING_SOUT_MAX` int(11) DEFAULT NULL,
  `PLANNING_SOUT_FAITES` int(11) DEFAULT NULL,
  `PLANNING_SPE` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ENS_PLANNING_ID`,`PLANNING_ENS_ID`),
  KEY `PLANNING_ENS_ID` (`PLANNING_ENS_ID`),
  KEY `PLANNING_SOUT_MAX` (`PLANNING_SOUT_MAX`),
  KEY `PLANNING_SPE` (`PLANNING_SPE`),
  KEY `PLANNING_SOUT_FAITES` (`PLANNING_SOUT_FAITES`),
  CONSTRAINT `common_planning_enseignant_ibfk_2` FOREIGN KEY (`PLANNING_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_planning_enseignant_ibfk_3` FOREIGN KEY (`ENS_PLANNING_ID`) REFERENCES `common_planning` (`PLANNING_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_planning_rendezvous`
--

DROP TABLE IF EXISTS `common_planning_rendezvous`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_planning_rendezvous` (
  `RDV_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `RDV_PLANNING_ID` int(10) unsigned NOT NULL,
  `RDV_ENS_ID` int(11) unsigned DEFAULT NULL,
  `RDV_DISPO_ID` int(10) unsigned NOT NULL,
  `RDV_DATE_DEL` int(10) unsigned DEFAULT NULL,
  `RDV_TYPE` int(10) unsigned NOT NULL,
  `RDV_SESSION` text NOT NULL,
  PRIMARY KEY (`RDV_ID`),
  UNIQUE KEY `RDV_ENS_ID` (`RDV_ENS_ID`,`RDV_DISPO_ID`),
  KEY `common_planning_rendezvous_ibfk_1` (`RDV_PLANNING_ID`),
  KEY `common_planning_rendezvous_ibfk_2` (`RDV_ENS_ID`),
  KEY `RDV_DISPO_ID` (`RDV_DISPO_ID`),
  KEY `RDV_DATE_DEL` (`RDV_DATE_DEL`),
  CONSTRAINT `common_planning_rendezvous_ibfk_1` FOREIGN KEY (`RDV_PLANNING_ID`) REFERENCES `common_planning` (`PLANNING_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_planning_rendezvous_ibfk_2` FOREIGN KEY (`RDV_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_planning_rendezvous_ibfk_3` FOREIGN KEY (`RDV_DISPO_ID`) REFERENCES `common_planning_dispo_enseignant` (`DISPO_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1301 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_planning_reservation`
--

DROP TABLE IF EXISTS `common_planning_reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_planning_reservation` (
  `RDV_ID` int(10) unsigned NOT NULL,
  `RDV_NOM` text NOT NULL,
  `RDV_PRENOM` text NOT NULL,
  `RDV_NUMERO` varchar(10) NOT NULL,
  `RDV_TEL` text NOT NULL,
  `RDV_MAIL` text NOT NULL,
  `RDV_COMMENTAIRE` text NOT NULL,
  UNIQUE KEY `RDV_ID_2` (`RDV_ID`),
  UNIQUE KEY `RDV_NUMERO` (`RDV_NUMERO`),
  CONSTRAINT `common_planning_reservation_ibfk_1` FOREIGN KEY (`RDV_ID`) REFERENCES `common_planning_rendezvous` (`RDV_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_poursuite_avis`
--

DROP TABLE IF EXISTS `common_poursuite_avis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_poursuite_avis` (
  `AVIS_ET_ID` int(10) unsigned NOT NULL,
  `AVIS_PMAT_ID` int(10) unsigned NOT NULL,
  `AVIS_NIVEAU` text NOT NULL,
  `AVIS_APPRECIATION` text NOT NULL,
  `AVIS_ENS_ID` int(10) unsigned DEFAULT NULL,
  `AVIS_ANNEE_ID` int(11) unsigned NOT NULL DEFAULT 4,
  PRIMARY KEY (`AVIS_ET_ID`,`AVIS_PMAT_ID`,`AVIS_ANNEE_ID`) USING BTREE,
  KEY `AVIS_ET_ID` (`AVIS_ET_ID`),
  KEY `AVIS_PMAT_ID` (`AVIS_PMAT_ID`),
  KEY `AVIS_ENS_ID` (`AVIS_ENS_ID`),
  KEY `AVIS_ANNEE_ID` (`AVIS_ANNEE_ID`),
  CONSTRAINT `common_poursuite_avis_ibfk_1` FOREIGN KEY (`AVIS_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_poursuite_avis_ibfk_2` FOREIGN KEY (`AVIS_PMAT_ID`) REFERENCES `common_poursuite_matiere` (`PMAT_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_poursuite_avis_ibfk_3` FOREIGN KEY (`AVIS_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `common_poursuite_avis_ibfk_4` FOREIGN KEY (`AVIS_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_poursuite_choix_etudiant`
--

DROP TABLE IF EXISTS `common_poursuite_choix_etudiant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_poursuite_choix_etudiant` (
  `CHOIX_ET_ID` int(10) unsigned NOT NULL,
  `CHOIX_ENS_ID` int(10) unsigned NOT NULL,
  `CHOIX_ANNEE_ID` int(10) unsigned NOT NULL,
  `CHOIX_PMAT_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`CHOIX_ET_ID`,`CHOIX_ENS_ID`,`CHOIX_ANNEE_ID`,`CHOIX_PMAT_ID`) USING BTREE,
  KEY `CHOIX_ANNEE_ID` (`CHOIX_ANNEE_ID`),
  KEY `CHOIX_PMAT_ID` (`CHOIX_PMAT_ID`),
  KEY `common_poursuite_choix_etudiant_ibfk_1` (`CHOIX_ENS_ID`),
  CONSTRAINT `common_poursuite_choix_etudiant_ibfk_1` FOREIGN KEY (`CHOIX_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_poursuite_choix_etudiant_ibfk_2` FOREIGN KEY (`CHOIX_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_poursuite_choix_etudiant_ibfk_3` FOREIGN KEY (`CHOIX_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_poursuite_choix_etudiant_ibfk_4` FOREIGN KEY (`CHOIX_PMAT_ID`) REFERENCES `common_poursuite_matiere` (`PMAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_poursuite_etudiants`
--

DROP TABLE IF EXISTS `common_poursuite_etudiants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_poursuite_etudiants` (
  `POURSUITE_ET_ID` int(10) unsigned NOT NULL,
  `POURSUITE_APPRECIATION_G` text NOT NULL,
  `POURSUITE_AVIS` text NOT NULL,
  `POURSUITE_ANNEE_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`POURSUITE_ET_ID`,`POURSUITE_ANNEE_ID`),
  KEY `POURSUITE_ET_ID` (`POURSUITE_ET_ID`),
  KEY `POURSUITE_ANNEE_ID` (`POURSUITE_ANNEE_ID`),
  CONSTRAINT `common_poursuite_etudiants_ibfk_1` FOREIGN KEY (`POURSUITE_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_poursuite_etudiants_ibfk_2` FOREIGN KEY (`POURSUITE_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_poursuite_matiere`
--

DROP TABLE IF EXISTS `common_poursuite_matiere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_poursuite_matiere` (
  `PMAT_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PMAT_NOM` text NOT NULL,
  `PMAT_ENS_ID` int(10) unsigned DEFAULT NULL,
  `PMAT_DEPT_ID` int(10) unsigned DEFAULT NULL,
  `PMAT_MODE` enum('ENS','ALL','PERSO') DEFAULT 'ENS',
  `PMAT_PERSO` text DEFAULT NULL,
  PRIMARY KEY (`PMAT_ID`),
  KEY `PMAT_ENS_ID` (`PMAT_ENS_ID`),
  KEY `PMAT_DEPT_ID` (`PMAT_DEPT_ID`),
  CONSTRAINT `common_poursuite_matiere_ibfk_1` FOREIGN KEY (`PMAT_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `common_poursuite_matiere_ibfk_2` FOREIGN KEY (`PMAT_DEPT_ID`) REFERENCES `common_departement` (`DEPT_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_poursuite_matiere_composition`
--

DROP TABLE IF EXISTS `common_poursuite_matiere_composition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_poursuite_matiere_composition` (
  `MAT_PMAT_ID` int(10) unsigned NOT NULL,
  `PMAT_MAT_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`MAT_PMAT_ID`,`PMAT_MAT_ID`),
  KEY `MAT_ID` (`PMAT_MAT_ID`),
  CONSTRAINT `common_poursuite_matiere_composition_ibfk_1` FOREIGN KEY (`MAT_PMAT_ID`) REFERENCES `common_poursuite_matiere` (`PMAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_poursuite_matiere_composition_ibfk_2` FOREIGN KEY (`PMAT_MAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_poursuite_niveau`
--

DROP TABLE IF EXISTS `common_poursuite_niveau`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_poursuite_niveau` (
  `NIVEAU_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NIVEAU_NOM` text NOT NULL,
  PRIMARY KEY (`NIVEAU_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_poursuite_niveau_matiere`
--

DROP TABLE IF EXISTS `common_poursuite_niveau_matiere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_poursuite_niveau_matiere` (
  `NIVEAU_PMAT_ID` int(10) unsigned NOT NULL,
  `NIVEAU` text NOT NULL,
  `NIVEAU_ANNEE_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`NIVEAU_PMAT_ID`,`NIVEAU_ANNEE_ID`),
  KEY `NIVEAU_ANNEE_ID` (`NIVEAU_ANNEE_ID`),
  CONSTRAINT `common_poursuite_niveau_matiere_ibfk_1` FOREIGN KEY (`NIVEAU_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_poursuite_niveau_matiere_ibfk_2` FOREIGN KEY (`NIVEAU_PMAT_ID`) REFERENCES `common_poursuite_matiere` (`PMAT_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_pro_absences`
--

DROP TABLE IF EXISTS `common_pro_absences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_pro_absences` (
  `PROABS_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PROABS_ENS_ID` int(10) unsigned NOT NULL,
  `PROABS_ET_ID` int(10) unsigned NOT NULL,
  `PROABS_EDT_UID` varchar(65) NOT NULL,
  `PROABS_DATE` char(10) NOT NULL,
  `PROABS_JUSTIFICATION` enum('non','medical','convocation','chef') NOT NULL DEFAULT 'non',
  `PROABS_EXCUSE` text DEFAULT NULL,
  `PROABS_MAIL` tinyint(1) NOT NULL DEFAULT 0,
  `PROABS_REAL_DATE` int(11) unsigned NOT NULL,
  `PROABS_EXPIRE` tinyint(1) NOT NULL DEFAULT 0,
  `PROABS_ANNEE_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`PROABS_ID`),
  UNIQUE KEY `PROABS_ENS_ID_2` (`PROABS_ENS_ID`,`PROABS_ET_ID`,`PROABS_EDT_UID`,`PROABS_REAL_DATE`) USING BTREE,
  KEY `PROABS_ENS_ID` (`PROABS_ENS_ID`),
  KEY `PROABS_ET_ID` (`PROABS_ET_ID`),
  KEY `PROABS_EDT_UID` (`PROABS_EDT_UID`),
  KEY `PROABS_ANNEE_ID` (`PROABS_ANNEE_ID`),
  CONSTRAINT `common_pro_absences_ibfk_1` FOREIGN KEY (`PROABS_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_pro_absences_ibfk_2` FOREIGN KEY (`PROABS_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_pro_absences_ibfk_3` FOREIGN KEY (`PROABS_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=896 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_pro_signatures`
--

DROP TABLE IF EXISTS `common_pro_signatures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_pro_signatures` (
  `SIGNATURE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SIGNATURE_ET_ID` int(10) unsigned DEFAULT NULL,
  `SIGNATURE_EDT_UID` varchar(65) NOT NULL,
  `SIGNATURE_ENS_ID` int(10) unsigned DEFAULT NULL,
  `SIGNATURE_GROUPE_ID` int(10) unsigned NOT NULL,
  `SIGNATURE` mediumtext NOT NULL,
  `SIGNATURE_MAT_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`SIGNATURE_ID`),
  UNIQUE KEY `SIGNATURE_ET_ID_2` (`SIGNATURE_ET_ID`,`SIGNATURE_EDT_UID`,`SIGNATURE_GROUPE_ID`),
  UNIQUE KEY `SIGNATURE_EDT_UID_2` (`SIGNATURE_EDT_UID`,`SIGNATURE_ENS_ID`,`SIGNATURE_GROUPE_ID`),
  KEY `SIGNATURE_ET_ID` (`SIGNATURE_ET_ID`),
  KEY `SIGNATURE_ENS_ID` (`SIGNATURE_ENS_ID`),
  KEY `SIGNATURE_EDT_UID` (`SIGNATURE_EDT_UID`),
  KEY `SIGNATURE_GROUPE_ID` (`SIGNATURE_GROUPE_ID`),
  KEY `SIGNATURE_MAT_ID` (`SIGNATURE_MAT_ID`),
  CONSTRAINT `common_pro_signatures_ibfk_1` FOREIGN KEY (`SIGNATURE_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_pro_signatures_ibfk_2` FOREIGN KEY (`SIGNATURE_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_pro_signatures_ibfk_3` FOREIGN KEY (`SIGNATURE_MAT_ID`) REFERENCES `common_matiere` (`MAT_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=415512 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_pro_signatures_backup`
--

DROP TABLE IF EXISTS `common_pro_signatures_backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_pro_signatures_backup` (
  `SIGNATURE_ID` int(10) unsigned NOT NULL,
  `SIGNATURE_ET_ID` int(10) unsigned DEFAULT NULL,
  `SIGNATURE_EDT_UID` varchar(65) NOT NULL,
  `SIGNATURE_ENS_ID` int(10) unsigned DEFAULT NULL,
  `SIGNATURE_GROUPE_ID` int(10) unsigned NOT NULL,
  `SIGNATURE` mediumtext NOT NULL,
  `SIGNATURE_MAT_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`SIGNATURE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_reel_enseignant`
--

DROP TABLE IF EXISTS `common_reel_enseignant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_reel_enseignant` (
  `REEL_ID` int(10) unsigned NOT NULL,
  `REEL_CM` decimal(5,2) NOT NULL,
  `REEL_TD` decimal(5,2) NOT NULL,
  `REEL_TP` decimal(5,2) NOT NULL,
  PRIMARY KEY (`REEL_ID`),
  CONSTRAINT `common_reel_enseignant_ibfk_1` FOREIGN KEY (`REEL_ID`) REFERENCES `common_enseignants_matieres` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_responsable_formation`
--

DROP TABLE IF EXISTS `common_responsable_formation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_responsable_formation` (
  `RESPONSABLE_FORM_ID` int(10) unsigned NOT NULL,
  `RESPONSABLE_ENS_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`RESPONSABLE_FORM_ID`,`RESPONSABLE_ENS_ID`),
  KEY `RESPONSABLE_FORM_ID` (`RESPONSABLE_FORM_ID`),
  KEY `RESPONSABLE_ENS_ID` (`RESPONSABLE_ENS_ID`),
  CONSTRAINT `common_responsable_formation_ibfk_1` FOREIGN KEY (`RESPONSABLE_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_responsable_formation_ibfk_2` FOREIGN KEY (`RESPONSABLE_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_resultat_niveau`
--

DROP TABLE IF EXISTS `common_resultat_niveau`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_resultat_niveau` (
  `NIVEAU_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NIVEAU_DIPLOME_ID` int(10) unsigned NOT NULL,
  `NIVEAU_NOM` text NOT NULL,
  `NIVEAU_FORM_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`NIVEAU_ID`),
  KEY `NIVEAU_DIPLOME_ID` (`NIVEAU_DIPLOME_ID`),
  KEY `NIVEAU_FORM_ID` (`NIVEAU_FORM_ID`),
  CONSTRAINT `common_resultat_niveau_ibfk_1` FOREIGN KEY (`NIVEAU_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_resultat_niveau_ibfk_2` FOREIGN KEY (`NIVEAU_DIPLOME_ID`) REFERENCES `common_resultats_diplome` (`DIPLOME_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_resultat_regroupement_ue`
--

DROP TABLE IF EXISTS `common_resultat_regroupement_ue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_resultat_regroupement_ue` (
  `REGROUP_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `REGROUP_NIVEAU_ID` int(10) unsigned NOT NULL,
  `REGROUP_NOM` text NOT NULL,
  `REGROUP_PREC_REGROUP_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`REGROUP_ID`),
  KEY `REGROUP_NIVEAU_ID` (`REGROUP_NIVEAU_ID`),
  KEY `REGROUP_PREC_REGROUP_ID` (`REGROUP_PREC_REGROUP_ID`),
  CONSTRAINT `common_resultat_regroupement_ue_ibfk_1` FOREIGN KEY (`REGROUP_NIVEAU_ID`) REFERENCES `common_resultat_niveau` (`NIVEAU_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_resultat_regroupement_ue_ibfk_2` FOREIGN KEY (`REGROUP_PREC_REGROUP_ID`) REFERENCES `common_resultat_regroupement_ue` (`REGROUP_ID`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_resultat_ue`
--

DROP TABLE IF EXISTS `common_resultat_ue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_resultat_ue` (
  `RESULTAT_UE_ID` int(10) unsigned NOT NULL,
  `RESULTAT_UE_COEF` decimal(5,2) unsigned NOT NULL,
  `RESULTAT_REGROUP_ID` int(10) unsigned NOT NULL,
  UNIQUE KEY `RESULTAT_UE_ID` (`RESULTAT_UE_ID`),
  KEY `RESULTAT_REGROUP_ID` (`RESULTAT_REGROUP_ID`),
  CONSTRAINT `common_resultat_ue_ibfk_1` FOREIGN KEY (`RESULTAT_UE_ID`) REFERENCES `common_ue` (`UE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_resultat_ue_ibfk_2` FOREIGN KEY (`RESULTAT_REGROUP_ID`) REFERENCES `common_resultat_regroupement_ue` (`REGROUP_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_resultats_diplome`
--

DROP TABLE IF EXISTS `common_resultats_diplome`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_resultats_diplome` (
  `DIPLOME_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DIPLOME_NOM` text NOT NULL,
  `DIPLOME_ELIM` decimal(5,2) NOT NULL,
  `DIPLOME_VAL` decimal(5,2) NOT NULL,
  PRIMARY KEY (`DIPLOME_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_secretaire`
--

DROP TABLE IF EXISTS `common_secretaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_secretaire` (
  `SECRETAIRE_ENS_ID` int(10) unsigned NOT NULL,
  `SECRETAIRE_FORM_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`SECRETAIRE_ENS_ID`,`SECRETAIRE_FORM_ID`),
  KEY `SECRETAIRE_ENS_ID` (`SECRETAIRE_ENS_ID`),
  KEY `SECRETAIRE_FORM_ID` (`SECRETAIRE_FORM_ID`),
  CONSTRAINT `common_secretaire_ibfk_1` FOREIGN KEY (`SECRETAIRE_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_secretaire_ibfk_2` FOREIGN KEY (`SECRETAIRE_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_semestre`
--

DROP TABLE IF EXISTS `common_semestre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_semestre` (
  `SEM_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SEM_NOM` text NOT NULL,
  `SEM_FORM_ID` int(10) unsigned NOT NULL,
  `SEM_COEF` decimal(5,2) NOT NULL DEFAULT 1.00,
  `SEM_START_ANNEE_ID` int(10) unsigned DEFAULT NULL,
  `SEM_END_ANNEE_ID` int(10) unsigned DEFAULT NULL,
  `SEM_ORDRE` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`SEM_ID`),
  KEY `SEM_UE_ID` (`SEM_FORM_ID`),
  KEY `SEM_ANNEE_ID` (`SEM_START_ANNEE_ID`),
  KEY `SEM_END_ANNEE_ID` (`SEM_END_ANNEE_ID`),
  CONSTRAINT `common_semestre_ibfk_1` FOREIGN KEY (`SEM_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_semestre_ibfk_2` FOREIGN KEY (`SEM_START_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_semestre_ibfk_3` FOREIGN KEY (`SEM_END_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=509 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_semestres_groupes`
--

DROP TABLE IF EXISTS `common_semestres_groupes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_semestres_groupes` (
  `GROUPE_SEM_ID` int(10) unsigned NOT NULL,
  `SEM_GROUPE_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`GROUPE_SEM_ID`,`SEM_GROUPE_ID`),
  KEY `GROUPE_ID` (`SEM_GROUPE_ID`),
  CONSTRAINT `common_semestres_groupes_ibfk_1` FOREIGN KEY (`GROUPE_SEM_ID`) REFERENCES `common_semestre` (`SEM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_semestres_groupes_ibfk_2` FOREIGN KEY (`SEM_GROUPE_ID`) REFERENCES `common_groupes` (`GROUPE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_soutenances_critere`
--

DROP TABLE IF EXISTS `common_soutenances_critere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_soutenances_critere` (
  `CRITERE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CRITERE_SECTION_ID` int(10) unsigned NOT NULL,
  `CRITERE_CONTENU` text NOT NULL,
  PRIMARY KEY (`CRITERE_ID`),
  KEY `CRITERE_SECTION_ID` (`CRITERE_SECTION_ID`),
  CONSTRAINT `common_soutenances_critere_ibfk_1` FOREIGN KEY (`CRITERE_SECTION_ID`) REFERENCES `common_soutenances_section` (`SECTION_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1263 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_soutenances_destination`
--

DROP TABLE IF EXISTS `common_soutenances_destination`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_soutenances_destination` (
  `DEST_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DEST_SESSION_ID` int(10) unsigned NOT NULL,
  `DEST_CONTENU` text NOT NULL,
  `DEST_FORM_ID` int(10) unsigned NOT NULL,
  `DEST_COEF` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`DEST_ID`),
  KEY `DEST_FORM_ID` (`DEST_FORM_ID`),
  KEY `DEST_SESSION_ID` (`DEST_SESSION_ID`),
  CONSTRAINT `common_soutenances_destination_ibfk_1` FOREIGN KEY (`DEST_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_destination_ibfk_2` FOREIGN KEY (`DEST_SESSION_ID`) REFERENCES `common_soutenances_session` (`SESSION_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_soutenances_etudiants`
--

DROP TABLE IF EXISTS `common_soutenances_etudiants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_soutenances_etudiants` (
  `SOUT_ET_ID` int(10) unsigned NOT NULL,
  `SOUT_CRITERE_ID` int(10) unsigned NOT NULL,
  `SOUT_NIVEAU_ID` int(10) unsigned NOT NULL,
  `SOUT_ENS_ID` int(10) unsigned NOT NULL,
  `SOUT_ANNEE_ID` int(10) unsigned NOT NULL,
  `SOUT_SESSION_ID` int(10) unsigned NOT NULL,
  `SOUT_CLOT` tinyint(1) NOT NULL DEFAULT 0,
  `SOUT_MAT_ID` int(10) unsigned DEFAULT NULL,
  `SOUT_NIVEAU_NUMERIQUE` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`SOUT_ET_ID`,`SOUT_CRITERE_ID`,`SOUT_ENS_ID`,`SOUT_ANNEE_ID`,`SOUT_SESSION_ID`) USING BTREE,
  KEY `SOUT_ENS_ID` (`SOUT_ENS_ID`),
  KEY `SOUT_CRITERE_ID` (`SOUT_CRITERE_ID`),
  KEY `SOUT_NIVEAU_ID` (`SOUT_NIVEAU_ID`),
  KEY `SOUT_ANNEE_ID` (`SOUT_ANNEE_ID`),
  KEY `SOUT_SESSION_ID` (`SOUT_SESSION_ID`),
  KEY `SOUT_MAT_ID` (`SOUT_MAT_ID`),
  CONSTRAINT `common_soutenances_etudiants_ibfk_1` FOREIGN KEY (`SOUT_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_etudiants_ibfk_2` FOREIGN KEY (`SOUT_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_etudiants_ibfk_3` FOREIGN KEY (`SOUT_CRITERE_ID`) REFERENCES `common_soutenances_critere` (`CRITERE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_etudiants_ibfk_4` FOREIGN KEY (`SOUT_NIVEAU_ID`) REFERENCES `common_soutenances_niveau` (`NIVEAU_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_etudiants_ibfk_5` FOREIGN KEY (`SOUT_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_etudiants_ibfk_6` FOREIGN KEY (`SOUT_SESSION_ID`) REFERENCES `common_soutenances_session` (`SESSION_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_etudiants_ibfk_7` FOREIGN KEY (`SOUT_MAT_ID`) REFERENCES `common_matiere` (`MAT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_soutenances_explications`
--

DROP TABLE IF EXISTS `common_soutenances_explications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_soutenances_explications` (
  `EXPLICATION_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EXPLICATION_NIVEAU_ID` int(10) unsigned NOT NULL,
  `EXPLICATION_CRITERE_ID` int(10) unsigned NOT NULL,
  `EXPLICATION_CONTENU` text NOT NULL,
  PRIMARY KEY (`EXPLICATION_ID`),
  UNIQUE KEY `EXPLICATION_NIVEAU_ID` (`EXPLICATION_NIVEAU_ID`,`EXPLICATION_CRITERE_ID`),
  KEY `EXPLICATION_CRITERE_ID` (`EXPLICATION_CRITERE_ID`),
  CONSTRAINT `common_soutenances_explications_ibfk_1` FOREIGN KEY (`EXPLICATION_CRITERE_ID`) REFERENCES `common_soutenances_critere` (`CRITERE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_explications_ibfk_2` FOREIGN KEY (`EXPLICATION_NIVEAU_ID`) REFERENCES `common_soutenances_niveau` (`NIVEAU_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6025 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_soutenances_groupes`
--

DROP TABLE IF EXISTS `common_soutenances_groupes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_soutenances_groupes` (
  `GROUPE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GROUPE_NOM` text NOT NULL,
  `GROUPE_FORM_ID` int(10) unsigned NOT NULL,
  `GROUPE_ANNEE_ID` int(10) unsigned NOT NULL,
  `GROUPE_SESSION_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`GROUPE_ID`),
  KEY `GROUPE_FORM_ID` (`GROUPE_FORM_ID`),
  KEY `GROUPE_ANNEE_ID` (`GROUPE_ANNEE_ID`),
  KEY `GROUPE_SESSION_ID` (`GROUPE_SESSION_ID`),
  CONSTRAINT `common_soutenances_groupes_ibfk_1` FOREIGN KEY (`GROUPE_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_groupes_ibfk_2` FOREIGN KEY (`GROUPE_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_groupes_ibfk_3` FOREIGN KEY (`GROUPE_SESSION_ID`) REFERENCES `common_soutenances_session` (`SESSION_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_soutenances_groupes_etudiants`
--

DROP TABLE IF EXISTS `common_soutenances_groupes_etudiants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_soutenances_groupes_etudiants` (
  `COUPLE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GROUPE_ET_ID` int(10) unsigned NOT NULL,
  `ET_GROUPE_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`COUPLE_ID`),
  UNIQUE KEY `GROUPE_ET_ID` (`GROUPE_ET_ID`,`ET_GROUPE_ID`),
  KEY `ET_GROUPE_ID` (`ET_GROUPE_ID`),
  CONSTRAINT `common_soutenances_groupes_etudiants_ibfk_1` FOREIGN KEY (`ET_GROUPE_ID`) REFERENCES `common_soutenances_groupes` (`GROUPE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_groupes_etudiants_ibfk_2` FOREIGN KEY (`GROUPE_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=934 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_soutenances_niveau`
--

DROP TABLE IF EXISTS `common_soutenances_niveau`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_soutenances_niveau` (
  `NIVEAU_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NIVEAU_FORM_ID` int(10) unsigned NOT NULL,
  `NIVEAU_DEST_ID` int(10) unsigned NOT NULL,
  `NIVEAU_CONTENU` text NOT NULL,
  `NIVEAU_POIDS` decimal(4,2) NOT NULL,
  `NIVEAU_MAX` decimal(4,2) DEFAULT NULL,
  `NIVEAU_NUMERIQUE` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`NIVEAU_ID`),
  KEY `common_soutenances_niveau_ibfk_1` (`NIVEAU_FORM_ID`),
  KEY `NIVEAU_DEST_ID` (`NIVEAU_DEST_ID`),
  CONSTRAINT `common_soutenances_niveau_ibfk_1` FOREIGN KEY (`NIVEAU_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_niveau_ibfk_2` FOREIGN KEY (`NIVEAU_DEST_ID`) REFERENCES `common_soutenances_destination` (`DEST_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2078 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_soutenances_planning`
--

DROP TABLE IF EXISTS `common_soutenances_planning`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_soutenances_planning` (
  `PLANNING_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PLANNING_DEPT_ID` int(10) unsigned NOT NULL,
  `PLANNING_ANNEE_ID` int(10) unsigned DEFAULT NULL,
  `PLANNING_CONTENU` text NOT NULL,
  `PLANNING_START_ENS` int(10) unsigned DEFAULT NULL,
  `PLANNING_END_ENS` int(10) unsigned DEFAULT NULL,
  `PLANNING_START_ET` int(10) unsigned DEFAULT NULL,
  `PLANNING_END_ET` int(10) unsigned DEFAULT NULL,
  `PLANNING_SOUTENANCES_START` int(10) unsigned DEFAULT NULL,
  `PLANNING_SOUTENANCES_END` int(10) unsigned DEFAULT NULL,
  `PLANNING_SOUTENANCES_NB_SALLES` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`PLANNING_ID`),
  KEY `PLANNING_DEPT_ID` (`PLANNING_DEPT_ID`),
  KEY `PLANNING_ANNEE_ID` (`PLANNING_ANNEE_ID`),
  CONSTRAINT `common_soutenances_planning_ibfk_1` FOREIGN KEY (`PLANNING_DEPT_ID`) REFERENCES `common_departement` (`DEPT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_planning_ibfk_2` FOREIGN KEY (`PLANNING_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_soutenances_planning_creneau`
--

DROP TABLE IF EXISTS `common_soutenances_planning_creneau`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_soutenances_planning_creneau` (
  `CRENEAU_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CRENEAU_PLANNING_ID` int(10) unsigned NOT NULL,
  `CRENEAU_DEBUT` int(10) unsigned NOT NULL,
  `CRENEAU_FIN` int(10) unsigned NOT NULL,
  PRIMARY KEY (`CRENEAU_ID`),
  UNIQUE KEY `CRENEAU_SESSION_ID` (`CRENEAU_PLANNING_ID`,`CRENEAU_DEBUT`,`CRENEAU_FIN`),
  KEY `CRENEAU_DEBUT` (`CRENEAU_DEBUT`),
  KEY `CRENEAU_FIN` (`CRENEAU_FIN`),
  CONSTRAINT `common_soutenances_planning_creneau_ibfk_1` FOREIGN KEY (`CRENEAU_PLANNING_ID`) REFERENCES `common_soutenances_planning` (`PLANNING_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=209 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_soutenances_planning_creneau_enseignant`
--

DROP TABLE IF EXISTS `common_soutenances_planning_creneau_enseignant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_soutenances_planning_creneau_enseignant` (
  `CRENEAU_DISPO_ID` int(10) unsigned NOT NULL,
  `DISPO_CRENEAU_ID` int(10) unsigned NOT NULL,
  `DISPO_CRENEAU_STAGE_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`CRENEAU_DISPO_ID`,`DISPO_CRENEAU_ID`),
  KEY `DISPO_CRENEAU_ID` (`DISPO_CRENEAU_ID`),
  KEY `DISPO_CRENEAU_STAGE_ID` (`DISPO_CRENEAU_STAGE_ID`),
  CONSTRAINT `common_soutenances_planning_creneau_enseignant_ibfk_1` FOREIGN KEY (`CRENEAU_DISPO_ID`) REFERENCES `common_soutenances_planning_dispo_enseignant` (`DISPO_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_planning_creneau_enseignant_ibfk_2` FOREIGN KEY (`DISPO_CRENEAU_ID`) REFERENCES `common_soutenances_planning_creneau` (`CRENEAU_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_planning_creneau_enseignant_ibfk_3` FOREIGN KEY (`DISPO_CRENEAU_STAGE_ID`) REFERENCES `common_stage` (`STAGE_ID`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_soutenances_planning_dispo_enseignant`
--

DROP TABLE IF EXISTS `common_soutenances_planning_dispo_enseignant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_soutenances_planning_dispo_enseignant` (
  `DISPO_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DISPO_ENS_ID` int(10) unsigned NOT NULL,
  `DISPO_ANNEE_ID` int(10) unsigned NOT NULL,
  `DISPO_PLANNING_ID` int(10) unsigned NOT NULL,
  `DISPO_DATE` int(10) unsigned NOT NULL,
  PRIMARY KEY (`DISPO_ID`),
  UNIQUE KEY `DISPO_ENS_ID` (`DISPO_ENS_ID`,`DISPO_ANNEE_ID`,`DISPO_PLANNING_ID`,`DISPO_DATE`) USING BTREE,
  KEY `DISPO_SESSION_ID` (`DISPO_PLANNING_ID`),
  KEY `DISPO_ANNEE_ID` (`DISPO_ANNEE_ID`),
  KEY `DISPO_DATE` (`DISPO_DATE`),
  CONSTRAINT `common_soutenances_planning_dispo_enseignant_ibfk_1` FOREIGN KEY (`DISPO_PLANNING_ID`) REFERENCES `common_soutenances_planning` (`PLANNING_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_planning_dispo_enseignant_ibfk_2` FOREIGN KEY (`DISPO_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_planning_dispo_enseignant_ibfk_3` FOREIGN KEY (`DISPO_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2504 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_soutenances_planning_enseignant`
--

DROP TABLE IF EXISTS `common_soutenances_planning_enseignant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_soutenances_planning_enseignant` (
  `PLANNING_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PLANNING_ENS_ID` int(10) unsigned NOT NULL,
  `PLANNING_DEPT_ID` int(10) unsigned DEFAULT NULL,
  `PLANNING_SOUT_MAX` int(11) DEFAULT NULL,
  `PLANNING_SOUT_FAITES` int(11) DEFAULT NULL,
  `PLANNING_SPE` tinyint(1) DEFAULT NULL,
  `PLANNING_ANNEE_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`PLANNING_ID`),
  UNIQUE KEY `PLANNING_ENS_ID_2` (`PLANNING_ENS_ID`,`PLANNING_ANNEE_ID`,`PLANNING_DEPT_ID`) USING BTREE,
  KEY `PLANNING_ANNEE_ID` (`PLANNING_ANNEE_ID`),
  KEY `PLANNING_ENS_ID` (`PLANNING_ENS_ID`),
  KEY `PLANNING_DEPT_ID` (`PLANNING_DEPT_ID`),
  KEY `PLANNING_SOUT_MAX` (`PLANNING_SOUT_MAX`),
  KEY `PLANNING_SPE` (`PLANNING_SPE`),
  KEY `PLANNING_SOUT_FAITES` (`PLANNING_SOUT_FAITES`),
  CONSTRAINT `common_soutenances_planning_enseignant_ibfk_1` FOREIGN KEY (`PLANNING_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_planning_enseignant_ibfk_2` FOREIGN KEY (`PLANNING_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_planning_enseignant_ibfk_3` FOREIGN KEY (`PLANNING_DEPT_ID`) REFERENCES `common_departement` (`DEPT_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=368 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_soutenances_planning_incompatibilite`
--

DROP TABLE IF EXISTS `common_soutenances_planning_incompatibilite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_soutenances_planning_incompatibilite` (
  `INCOMPATIBILITE_ENS_ID_1` int(10) unsigned NOT NULL,
  `INCOMPATIBILITE_ENS_ID_2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`INCOMPATIBILITE_ENS_ID_1`,`INCOMPATIBILITE_ENS_ID_2`),
  KEY `INCOMPATIBILITE_ENS_ID_2` (`INCOMPATIBILITE_ENS_ID_2`),
  CONSTRAINT `common_soutenances_planning_incompatibilite_ibfk_1` FOREIGN KEY (`INCOMPATIBILITE_ENS_ID_1`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_planning_incompatibilite_ibfk_2` FOREIGN KEY (`INCOMPATIBILITE_ENS_ID_2`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_soutenances_planning_stage`
--

DROP TABLE IF EXISTS `common_soutenances_planning_stage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_soutenances_planning_stage` (
  `PLANNING_STAGE_ID` int(10) unsigned NOT NULL,
  `STAGE_PLANNING_ID` int(10) unsigned NOT NULL,
  `STAGE_PLANNING_ANNEE_ID` int(10) unsigned NOT NULL,
  `STAGE_DATE_SOUTENANCE` int(10) unsigned DEFAULT NULL,
  `STAGE_SOUTENANCE_CRENEAU_ID` int(10) unsigned DEFAULT NULL,
  `STAGE_JURY_ENS_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`PLANNING_STAGE_ID`,`STAGE_PLANNING_ID`),
  KEY `STAGE_PLANNING_ID` (`STAGE_PLANNING_ID`),
  KEY `STAGE_JURY_ENS_ID` (`STAGE_JURY_ENS_ID`),
  KEY `STAGE_PLANNING_ANNEE_ID` (`STAGE_PLANNING_ANNEE_ID`),
  KEY `STAGE_SOUTENANCE_CRENEAU_ID` (`STAGE_SOUTENANCE_CRENEAU_ID`),
  KEY `STAGE_DATE_SOUTENANCE` (`STAGE_DATE_SOUTENANCE`),
  CONSTRAINT `common_soutenances_planning_stage_ibfk_1` FOREIGN KEY (`PLANNING_STAGE_ID`) REFERENCES `common_stage` (`STAGE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_planning_stage_ibfk_2` FOREIGN KEY (`STAGE_PLANNING_ID`) REFERENCES `common_soutenances_planning` (`PLANNING_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_planning_stage_ibfk_3` FOREIGN KEY (`STAGE_JURY_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_planning_stage_ibfk_4` FOREIGN KEY (`STAGE_PLANNING_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_planning_stage_ibfk_6` FOREIGN KEY (`STAGE_SOUTENANCE_CRENEAU_ID`) REFERENCES `common_soutenances_planning_creneau` (`CRENEAU_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_soutenances_section`
--

DROP TABLE IF EXISTS `common_soutenances_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_soutenances_section` (
  `SECTION_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SECTION_CONTENU` text NOT NULL,
  `SECTION_DEST_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`SECTION_ID`),
  KEY `common_soutenances_section_ibfk_1` (`SECTION_DEST_ID`),
  CONSTRAINT `common_soutenances_section_ibfk_1` FOREIGN KEY (`SECTION_DEST_ID`) REFERENCES `common_soutenances_destination` (`DEST_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=458 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_soutenances_session`
--

DROP TABLE IF EXISTS `common_soutenances_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_soutenances_session` (
  `SESSION_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SESSION_FORM_ID` int(10) unsigned NOT NULL,
  `SESSION_ANNEE_ID` int(10) unsigned DEFAULT NULL,
  `SESSION_CONTENU` text NOT NULL,
  `SESSION_START` int(10) unsigned DEFAULT NULL,
  `SESSION_END` int(10) unsigned DEFAULT NULL,
  `SESSION_HARMONISATION_START` int(10) unsigned DEFAULT NULL,
  `SESSION_HARMONISATION_END` int(10) unsigned DEFAULT NULL,
  `SESSION_PLANNING_START_ENS` int(10) unsigned DEFAULT NULL,
  `SESSION_PLANNING_END_ENS` int(10) unsigned DEFAULT NULL,
  `SESSION_PLANNING_START_ET` int(10) unsigned DEFAULT NULL,
  `SESSION_PLANNING_END_ET` int(10) unsigned DEFAULT NULL,
  `SESSION_PLANNING_SOUTENANCES_START` int(10) unsigned DEFAULT NULL,
  `SESSION_PLANNING_SOUTENANCES_END` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`SESSION_ID`),
  KEY `SESSION_FORM_ID` (`SESSION_FORM_ID`),
  KEY `SESSION_ANNEE_ID` (`SESSION_ANNEE_ID`),
  CONSTRAINT `common_soutenances_session_ibfk_1` FOREIGN KEY (`SESSION_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_soutenances_session_ibfk_2` FOREIGN KEY (`SESSION_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_stage`
--

DROP TABLE IF EXISTS `common_stage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_stage` (
  `STAGE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `STAGE_SUJET` text NOT NULL,
  `STAGE_MAIL` text NOT NULL,
  `STAGE_CONTACT` text NOT NULL,
  `STAGE_ET_ID` int(10) unsigned DEFAULT NULL,
  `STAGE_DATE` int(10) unsigned NOT NULL,
  `STAGE_DATE_AFFECTATION` int(10) unsigned DEFAULT NULL,
  `STAGE_ANNEE_ID` int(10) unsigned NOT NULL,
  `STAGE_ENS_ID` int(10) unsigned DEFAULT NULL,
  `STAGE_CONVENTION` tinyint(1) NOT NULL DEFAULT 0,
  `STAGE_DATE_CONVENTION` int(10) unsigned DEFAULT NULL,
  `STAGE_REF` text NOT NULL,
  `STAGE_SUGGESTION_ENS_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`STAGE_ID`),
  KEY `common_stage_ibfk_1` (`STAGE_ET_ID`),
  KEY `STAGE_ANNEE_ID` (`STAGE_ANNEE_ID`),
  KEY `STAGE_ENS_ID` (`STAGE_ENS_ID`),
  KEY `STAGE_SUGGESTION_ENS_ID` (`STAGE_SUGGESTION_ENS_ID`),
  CONSTRAINT `common_stage_ibfk_1` FOREIGN KEY (`STAGE_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `common_stage_ibfk_3` FOREIGN KEY (`STAGE_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_stage_ibfk_4` FOREIGN KEY (`STAGE_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `common_stage_ibfk_7` FOREIGN KEY (`STAGE_SUGGESTION_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1571 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_stage_etudiants`
--

DROP TABLE IF EXISTS `common_stage_etudiants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_stage_etudiants` (
  `STAGE_ET_ID` int(10) unsigned NOT NULL,
  `ET_STAGE_ID` int(10) unsigned NOT NULL,
  `ET_STAGE_DATE` int(10) unsigned NOT NULL,
  PRIMARY KEY (`STAGE_ET_ID`,`ET_STAGE_ID`),
  KEY `ET_STAGE_ID` (`ET_STAGE_ID`),
  CONSTRAINT `common_stage_etudiants_ibfk_1` FOREIGN KEY (`ET_STAGE_ID`) REFERENCES `common_stage` (`STAGE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_stage_etudiants_ibfk_2` FOREIGN KEY (`STAGE_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_stage_formations`
--

DROP TABLE IF EXISTS `common_stage_formations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_stage_formations` (
  `STAGE_FORM_ID` int(10) unsigned NOT NULL,
  `FORM_STAGE_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`STAGE_FORM_ID`,`FORM_STAGE_ID`),
  KEY `FORM_STAGE_ID` (`FORM_STAGE_ID`),
  CONSTRAINT `common_stage_formations_ibfk_1` FOREIGN KEY (`STAGE_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_stage_formations_ibfk_2` FOREIGN KEY (`FORM_STAGE_ID`) REFERENCES `common_stage` (`STAGE_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_suivi`
--

DROP TABLE IF EXISTS `common_suivi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_suivi` (
  `SUIVI_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SUIVI_ET_ID` int(10) unsigned NOT NULL,
  `SUIVI_DATE` int(10) unsigned NOT NULL,
  `SUIVI_MESSAGE` text NOT NULL,
  `SUIVI_ENS_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`SUIVI_ID`),
  KEY `SUIVI_ET_ID` (`SUIVI_ET_ID`),
  KEY `SUIVI_ENS_ID` (`SUIVI_ENS_ID`),
  CONSTRAINT `common_suivi_ibfk_1` FOREIGN KEY (`SUIVI_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_suivi_ibfk_2` FOREIGN KEY (`SUIVI_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1254 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_tablette_ask`
--

DROP TABLE IF EXISTS `common_tablette_ask`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_tablette_ask` (
  `ASK_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ASK_TABLETTE` varchar(50) NOT NULL,
  `ASK_DATE` int(11) NOT NULL,
  PRIMARY KEY (`ASK_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_tablettes`
--

DROP TABLE IF EXISTS `common_tablettes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_tablettes` (
  `TABLETTE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TABLETTE_UID` varchar(50) NOT NULL,
  `TABLETTE_FORM_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`TABLETTE_ID`),
  UNIQUE KEY `TABLETTE_UID` (`TABLETTE_UID`),
  KEY `TABLETTE_FORM_ID` (`TABLETTE_FORM_ID`),
  CONSTRAINT `common_tablettes_ibfk_1` FOREIGN KEY (`TABLETTE_FORM_ID`) REFERENCES `common_formation` (`FORM_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_ue`
--

DROP TABLE IF EXISTS `common_ue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_ue` (
  `UE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UE_NOM` text NOT NULL,
  `UE_SEM_ID` int(10) unsigned NOT NULL,
  `UE_COEF` decimal(5,2) NOT NULL DEFAULT 1.00,
  `UE_START_ANNEE_ID` int(10) unsigned DEFAULT NULL,
  `UE_END_ANNEE_ID` int(10) unsigned DEFAULT NULL,
  `UE_ORDRE` int(11) NOT NULL DEFAULT 1,
  `UE_CODE_APOGEE` text DEFAULT NULL,
  PRIMARY KEY (`UE_ID`),
  KEY `UE_FORM_ID` (`UE_SEM_ID`),
  KEY `UE_ANNEE_ID` (`UE_START_ANNEE_ID`),
  KEY `UE_END_ANNEE_ID` (`UE_END_ANNEE_ID`),
  CONSTRAINT `common_ue_ibfk_1` FOREIGN KEY (`UE_SEM_ID`) REFERENCES `common_semestre` (`SEM_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_ue_ibfk_2` FOREIGN KEY (`UE_START_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON UPDATE CASCADE,
  CONSTRAINT `common_ue_ibfk_3` FOREIGN KEY (`UE_END_ANNEE_ID`) REFERENCES `common_annee` (`ANNEE_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1927 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_vote`
--

DROP TABLE IF EXISTS `common_vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_vote` (
  `VOTE_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `VOTE_CODE` varchar(20) NOT NULL,
  `VOTE_NOM` text NOT NULL,
  `VOTE_ET_ID` int(10) unsigned NOT NULL,
  `VOTE_CLOT` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`VOTE_ID`),
  KEY `VOTE_ET_ID` (`VOTE_ET_ID`),
  KEY `VOTE_CODE` (`VOTE_CODE`),
  CONSTRAINT `common_vote_ibfk_1` FOREIGN KEY (`VOTE_ET_ID`) REFERENCES `common_etudiant` (`ET_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_vote_enseignant`
--

DROP TABLE IF EXISTS `common_vote_enseignant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_vote_enseignant` (
  `ENS_VOTE_ID` int(10) unsigned NOT NULL,
  `VOTE_ENS_ID` int(10) unsigned NOT NULL,
  `VOTE_VALEUR` enum('Pour','Contre','Abstention') NOT NULL,
  PRIMARY KEY (`ENS_VOTE_ID`,`VOTE_ENS_ID`),
  KEY `VOTE_ENS_ID` (`VOTE_ENS_ID`),
  CONSTRAINT `common_vote_enseignant_ibfk_1` FOREIGN KEY (`ENS_VOTE_ID`) REFERENCES `common_vote` (`VOTE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `common_vote_enseignant_ibfk_2` FOREIGN KEY (`VOTE_ENS_ID`) REFERENCES `common_enseignant` (`ENS_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `direction_access_enseignants`
--

DROP TABLE IF EXISTS `direction_access_enseignants`;
/*!50001 DROP VIEW IF EXISTS `direction_access_enseignants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `direction_access_enseignants` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ENS_ID`,
  1 AS `ENS_NOM`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `edt_access_enseignants`
--

DROP TABLE IF EXISTS `edt_access_enseignants`;
/*!50001 DROP VIEW IF EXISTS `edt_access_enseignants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `edt_access_enseignants` AS SELECT
 1 AS `ENS_ID`,
  1 AS `ENS_NOM`,
  1 AS `ENS_LOGIN`,
  1 AS `ENS_MAIL`,
  1 AS `ENS_PRETEUR`,
  1 AS `ENS_ADE`,
  1 AS `ENS_EDT`,
  1 AS `ENS_EDT_HEBDO`,
  1 AS `ENS_GESTIONNAIRE_ADE`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `edt_interventions`
--

DROP TABLE IF EXISTS `edt_interventions`;
/*!50001 DROP VIEW IF EXISTS `edt_interventions`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `edt_interventions` AS SELECT
 1 AS `ENS_MAT_ID`,
  1 AS `MAT_ENS_ID`,
  1 AS `ENS_MAT_ANNEE_ID`,
  1 AS `PERIODE_MAT_ID`,
  1 AS `MAT_PERIODE_ID`,
  1 AS `ENS_ID`,
  1 AS `ENS_NOM`,
  1 AS `ENS_LOGIN`,
  1 AS `ENS_MAIL`,
  1 AS `ENS_PRETEUR`,
  1 AS `ENS_ADE`,
  1 AS `ENS_EDT`,
  1 AS `ENS_EDT_HEBDO`,
  1 AS `ENS_GESTIONNAIRE_ADE`,
  1 AS `PERIODE_ID`,
  1 AS `PERIODE_NOM`,
  1 AS `PERIODE_LIMIT`,
  1 AS `PERIODE_LIMIT_NOTES`,
  1 AS `PERIODE_DEBUT_WARNING`,
  1 AS `PERIODE_ANNEE_ID`,
  1 AS `PERIODE_FORM_ID_1`,
  1 AS `PERIODE_FORM_ID_2`,
  1 AS `PERIODE_TYPE`,
  1 AS `CLASSEMENT`,
  1 AS `PERIODE_DEBUT`,
  1 AS `PERIODE_FIN`,
  1 AS `PERIODE_EXAM_DEBUT`,
  1 AS `PERIODE_EXAM_FIN`,
  1 AS `PERIODE_SEMAINES`,
  1 AS `ANNEE_ID`,
  1 AS `ANNEE_NOM`,
  1 AS `ANNEE_COURANTE`,
  1 AS `ANNEE_CLOSE`,
  1 AS `MAT_NOM`,
  1 AS `ENS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `edt_periode`
--

DROP TABLE IF EXISTS `edt_periode`;
/*!50001 DROP VIEW IF EXISTS `edt_periode`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `edt_periode` AS SELECT
 1 AS `PERIODE_ID`,
  1 AS `PERIODE_NOM`,
  1 AS `PERIODE_LIMIT`,
  1 AS `PERIODE_DEBUT_WARNING`,
  1 AS `PERIODE_ANNEE_ID`,
  1 AS `PERIODE_FORM_ID_1`,
  1 AS `PERIODE_FORM_ID_2`,
  1 AS `PERIODE_TYPE`,
  1 AS `PERIODE_DEBUT`,
  1 AS `PERIODE_FIN`,
  1 AS `PERIODE_EXAM_DEBUT`,
  1 AS `PERIODE_EXAM_FIN`,
  1 AS `PERIODE_SEMAINES`,
  1 AS `ANNEE_ID`,
  1 AS `ANNEE_NOM`,
  1 AS `ANNEE_COURANTE`,
  1 AS `ANNEE_CLOSE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `emprunt`
--

DROP TABLE IF EXISTS `emprunt`;
/*!50001 DROP VIEW IF EXISTS `emprunt`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `emprunt` AS SELECT
 1 AS `EMPRUNT_OBJ_ID`,
  1 AS `EMPRUNT_ENS_ID`,
  1 AS `EMPRUNT_ET_ID`,
  1 AS `EMPRUNT_EXTERNE`,
  1 AS `EMPRUNT_DATE_OUT`,
  1 AS `EMPRUNT_DATE_RETOUR`,
  1 AS `EMPRUNT_NOMBRE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `emprunt_access_enseignants`
--

DROP TABLE IF EXISTS `emprunt_access_enseignants`;
/*!50001 DROP VIEW IF EXISTS `emprunt_access_enseignants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `emprunt_access_enseignants` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ENS_ID`,
  1 AS `ENS_NOM`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `enseignants_formations`
--

DROP TABLE IF EXISTS `enseignants_formations`;
/*!50001 DROP VIEW IF EXISTS `enseignants_formations`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `enseignants_formations` AS SELECT
 1 AS `ENS_ID`,
  1 AS `ENS_NOM`,
  1 AS `ENS_LOGIN`,
  1 AS `ENS_MAIL`,
  1 AS `ENS_PRETEUR`,
  1 AS `ENS_ADE`,
  1 AS `ENS_EDT`,
  1 AS `ENS_EDT_HEBDO`,
  1 AS `ENS_GESTIONNAIRE_ADE`,
  1 AS `DEPT_ENS_ID`,
  1 AS `ENS_DEPT_ID`,
  1 AS `ENS_DEPT_CURRENT`,
  1 AS `FORM_ID`,
  1 AS `FORM_NOM`,
  1 AS `FORM_DEPT_ID`,
  1 AS `FORM_PRO` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `etudiants_absences`
--

DROP TABLE IF EXISTS `etudiants_absences`;
/*!50001 DROP VIEW IF EXISTS `etudiants_absences`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `etudiants_absences` AS SELECT
 1 AS `ABS_ID`,
  1 AS `ABS_ENS_ID`,
  1 AS `ABS_ET_ID`,
  1 AS `ABS_CRENEAU_ID`,
  1 AS `ABS_MAT_ID`,
  1 AS `ABS_DATE`,
  1 AS `ABS_JUSTIFICATION`,
  1 AS `ABS_EXCUSE`,
  1 AS `ABS_MAIL`,
  1 AS `ET_ID`,
  1 AS `ET_NOM`,
  1 AS `ET_LOGIN`,
  1 AS `ET_NUMERO`,
  1 AS `ET_MAIL`,
  1 AS `ET_NAISSANCE`,
  1 AS `ET_QUIZZBOX`,
  1 AS `ABS_EXPIRE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `etudiants_access_etudiants`
--

DROP TABLE IF EXISTS `etudiants_access_etudiants`;
/*!50001 DROP VIEW IF EXISTS `etudiants_access_etudiants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `etudiants_access_etudiants` AS SELECT
 1 AS `ET_ID`,
  1 AS `ET_NOM`,
  1 AS `ET_LOGIN`,
  1 AS `ET_NUMERO`,
  1 AS `ET_MAIL`,
  1 AS `ET_NAISSANCE`,
  1 AS `ET_QUIZZBOX`,
  1 AS `ET_EDT`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `etudiants_emprunts_objets`
--

DROP TABLE IF EXISTS `etudiants_emprunts_objets`;
/*!50001 DROP VIEW IF EXISTS `etudiants_emprunts_objets`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `etudiants_emprunts_objets` AS SELECT
 1 AS `OBJ_ID`,
  1 AS `OBJ_NOM`,
  1 AS `OBJ_STOCK`,
  1 AS `EMPRUNT_OBJ_ID`,
  1 AS `EMPRUNT_ENS_ID`,
  1 AS `EMPRUNT_ET_ID`,
  1 AS `EMPRUNT_EXTERNE`,
  1 AS `EMPRUNT_DATE_OUT`,
  1 AS `EMPRUNT_DATE_RETOUR`,
  1 AS `EMPRUNT_NOMBRE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `etudiants_groupes`
--

DROP TABLE IF EXISTS `etudiants_groupes`;
/*!50001 DROP VIEW IF EXISTS `etudiants_groupes`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `etudiants_groupes` AS SELECT
 1 AS `GROUPE_ID`,
  1 AS `GROUPE_NOM`,
  1 AS `GROUPE_ENS_ID`,
  1 AS `GROUPE_FEUILLE`,
  1 AS `GROUPE_PARENT`,
  1 AS `GROUPE_CODE`,
  1 AS `GROUPE_ADE`,
  1 AS `GROUPE_FORM_ID`,
  1 AS `GROUPE_POURSUITE`,
  1 AS `GROUPE_DELETED`,
  1 AS `GROUPE_PRO`,
  1 AS `ET_GROUPE_CODE`,
  1 AS `GROUPE_ET_ID`,
  1 AS `ET_GROUPE_ANNEE_ID`,
  1 AS `ET_ID`,
  1 AS `ET_NOM`,
  1 AS `ET_NOM_DE_FAMILLE`,
  1 AS `ET_PRENOM`,
  1 AS `ET_LOGIN`,
  1 AS `ET_NUMERO`,
  1 AS `ET_MAIL`,
  1 AS `ET_NAISSANCE`,
  1 AS `ET_QUIZZBOX`,
  1 AS `ET_BAC`,
  1 AS `ET_EDT`,
  1 AS `ET_TIERS`,
  1 AS `ET_RED`,
  1 AS `ET_SPORTIF`,
  1 AS `ET_DEM`,
  1 AS `ET_PROFESSIONNALISATION`,
  1 AS `ET_TEL`,
  1 AS `ET_ORIGINE`,
  1 AS `ET_ENTREPRISE`,
  1 AS `ET_ADRESSE`,
  1 AS `ET_ADRESSE_2`,
  1 AS `ET_ADRESSE_ENTREPRISE`,
  1 AS `ET_DEBUT`,
  1 AS `ET_HEURES_MAX`,
  1 AS `ET_HEURES_FACTUREES`,
  1 AS `ET_TUTEUR_ENS_ID`,
  1 AS `ET_LIEU`,
  1 AS `ET_TUTEUR`,
  1 AS `ET_MAIL_TUTEUR`,
  1 AS `ET_TEL_TUTEUR`,
  1 AS `ET_INFO_LIEU`,
  1 AS `ET_MAX_SEMAINE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `etudiants_retour`
--

DROP TABLE IF EXISTS `etudiants_retour`;
/*!50001 DROP VIEW IF EXISTS `etudiants_retour`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `etudiants_retour` AS SELECT
 1 AS `ET_ID`,
  1 AS `FORM_ID`,
  1 AS `FORM_EVAL_DEBUT`,
  1 AS `FORM_EVAL_FIN`,
  1 AS `FORM_EVAL_PERIODE_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `extraction_groupes_ade`
--

DROP TABLE IF EXISTS `extraction_groupes_ade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extraction_groupes_ade` (
  `RES_ID` int(10) unsigned NOT NULL,
  `RES_PATH` text NOT NULL,
  `RES_LEAF` tinyint(1) NOT NULL,
  `RES_NAME` text NOT NULL,
  PRIMARY KEY (`RES_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `extraction_res_ade`
--

DROP TABLE IF EXISTS `extraction_res_ade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extraction_res_ade` (
  `EXTRACT_CODE` text NOT NULL,
  `EXTRACT_NUMERO` int(11) unsigned NOT NULL,
  PRIMARY KEY (`EXTRACT_NUMERO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `gea15_notes_moyennes_absences`
--

DROP TABLE IF EXISTS `gea15_notes_moyennes_absences`;
/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_absences`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea15_notes_moyennes_absences` AS SELECT
 1 AS `ET_ID`,
  1 AS `MAT_ID`,
  1 AS `MAT_CODE_APOGE`,
  1 AS `ANNEE_ID`,
  1 AS `MOYMAT_REMONTEE`,
  1 AS `ET_NUMERO_ABS` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gea15_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `gea15_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea15_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gea15_notes_moyennes_export`
--

DROP TABLE IF EXISTS `gea15_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea15_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gea15_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `gea15_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea15_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gea15_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `gea15_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea15_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gea15_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `gea15_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea15_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gea15_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `gea15_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea15_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gea15_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `gea15_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea15_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gea15_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `gea15_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea15_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gea63_notes_moyennes_absences`
--

DROP TABLE IF EXISTS `gea63_notes_moyennes_absences`;
/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_absences`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea63_notes_moyennes_absences` AS SELECT
 1 AS `ET_ID`,
  1 AS `MAT_ID`,
  1 AS `MAT_CODE_APOGE`,
  1 AS `ANNEE_ID`,
  1 AS `MOYMAT_REMONTEE`,
  1 AS `ET_NUMERO_ABS` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gea63_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `gea63_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea63_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gea63_notes_moyennes_export`
--

DROP TABLE IF EXISTS `gea63_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea63_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gea63_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `gea63_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea63_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gea63_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `gea63_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea63_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gea63_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `gea63_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea63_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gea63_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `gea63_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea63_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gea63_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `gea63_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea63_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gea63_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `gea63_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gea63_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `geii03_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `geii03_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `geii03_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `geii03_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `geii03_notes_moyennes_export`
--

DROP TABLE IF EXISTS `geii03_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `geii03_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `geii03_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `geii03_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `geii03_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `geii03_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `geii03_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `geii03_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `geii03_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `geii03_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `geii03_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `geii03_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `geii03_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `geii03_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `geii03_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `geii03_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `geii03_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `geii03_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `geii03_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `geii03_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `geii03_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `geii03_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `geii03_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `geii03_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `geii03_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `geii03_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `geii03_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gim63_notes_moyennes_absences`
--

DROP TABLE IF EXISTS `gim63_notes_moyennes_absences`;
/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_absences`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gim63_notes_moyennes_absences` AS SELECT
 1 AS `ET_ID`,
  1 AS `MAT_ID`,
  1 AS `MAT_CODE_APOGE`,
  1 AS `ANNEE_ID`,
  1 AS `MOYMAT_REMONTEE`,
  1 AS `ET_NUMERO_ABS` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gim63_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `gim63_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gim63_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gim63_notes_moyennes_export`
--

DROP TABLE IF EXISTS `gim63_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gim63_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gim63_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `gim63_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gim63_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gim63_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `gim63_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gim63_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gim63_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `gim63_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gim63_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gim63_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `gim63_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gim63_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gim63_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `gim63_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gim63_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gim63_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `gim63_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gim63_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gmp03_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `gmp03_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `gmp03_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gmp03_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gmp03_notes_moyennes_export`
--

DROP TABLE IF EXISTS `gmp03_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `gmp03_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gmp03_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gmp03_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `gmp03_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `gmp03_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gmp03_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gmp03_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `gmp03_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `gmp03_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gmp03_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gmp03_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `gmp03_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `gmp03_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gmp03_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gmp03_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `gmp03_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `gmp03_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gmp03_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gmp03_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `gmp03_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `gmp03_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gmp03_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gmp03_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `gmp03_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `gmp03_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gmp03_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gte03_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `gte03_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `gte03_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gte03_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gte03_notes_moyennes_export`
--

DROP TABLE IF EXISTS `gte03_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `gte03_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gte03_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gte03_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `gte03_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `gte03_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gte03_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gte03_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `gte03_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `gte03_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gte03_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gte03_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `gte03_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `gte03_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gte03_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gte03_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `gte03_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `gte03_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gte03_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gte03_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `gte03_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `gte03_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gte03_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gte03_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `gte03_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `gte03_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gte03_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf43_notes_moyennes_absences`
--

DROP TABLE IF EXISTS `inf43_notes_moyennes_absences`;
/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_absences`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf43_notes_moyennes_absences` AS SELECT
 1 AS `ET_ID`,
  1 AS `MAT_ID`,
  1 AS `MAT_CODE_APOGE`,
  1 AS `ANNEE_ID`,
  1 AS `MOYMAT_REMONTEE`,
  1 AS `ET_NUMERO_ABS` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf43_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `inf43_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf43_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf43_notes_moyennes_export`
--

DROP TABLE IF EXISTS `inf43_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf43_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf43_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `inf43_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf43_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf43_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `inf43_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf43_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf43_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `inf43_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf43_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf43_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `inf43_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf43_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf43_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `inf43_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf43_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf43_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `inf43_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf43_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf63_notes_moyennes_absences`
--

DROP TABLE IF EXISTS `inf63_notes_moyennes_absences`;
/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_absences`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf63_notes_moyennes_absences` AS SELECT
 1 AS `ET_ID`,
  1 AS `MAT_ID`,
  1 AS `MAT_CODE_APOGE`,
  1 AS `ANNEE_ID`,
  1 AS `MOYMAT_REMONTEE`,
  1 AS `ET_NUMERO_ABS` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf63_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `inf63_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf63_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf63_notes_moyennes_export`
--

DROP TABLE IF EXISTS `inf63_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf63_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf63_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `inf63_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf63_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf63_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `inf63_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf63_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf63_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `inf63_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf63_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf63_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `inf63_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf63_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf63_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `inf63_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf63_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `inf63_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `inf63_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `inf63_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `jury_access_enseignants`
--

DROP TABLE IF EXISTS `jury_access_enseignants`;
/*!50001 DROP VIEW IF EXISTS `jury_access_enseignants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `jury_access_enseignants` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ENS_ID`,
  1 AS `ENS_NOM`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `m23dia43_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `m23dia43_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `m23dia43_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `m23dia43_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `m23dia43_notes_moyennes_export`
--

DROP TABLE IF EXISTS `m23dia43_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `m23dia43_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `m23dia43_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `m23dia43_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `m23dia43_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `m23dia43_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `m23dia43_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `m23dia43_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `m23dia43_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `m23dia43_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `m23dia43_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `m23dia43_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `m23dia43_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `m23dia43_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `m23dia43_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `m23dia43_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `m23dia43_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `m23dia43_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `m23dia43_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `m23dia43_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `m23dia43_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `m23dia43_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `m23dia43_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `m23dia43_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `m23dia43_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `m23dia43_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `m23dia43_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mediateur_access_enseignants`
--

DROP TABLE IF EXISTS `mediateur_access_enseignants`;
/*!50001 DROP VIEW IF EXISTS `mediateur_access_enseignants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mediateur_access_enseignants` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ENS_ID`,
  1 AS `ENS_NOM`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mmi03_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `mmi03_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `mmi03_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mmi03_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mmi03_notes_moyennes_export`
--

DROP TABLE IF EXISTS `mmi03_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `mmi03_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mmi03_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mmi03_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `mmi03_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `mmi03_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mmi03_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mmi03_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `mmi03_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `mmi03_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mmi03_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mmi03_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `mmi03_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `mmi03_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mmi03_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mmi03_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `mmi03_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `mmi03_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mmi03_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mmi03_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `mmi03_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `mmi03_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mmi03_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mmi03_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `mmi03_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `mmi03_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mmi03_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mmi43_notes_moyennes_absences`
--

DROP TABLE IF EXISTS `mmi43_notes_moyennes_absences`;
/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_absences`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mmi43_notes_moyennes_absences` AS SELECT
 1 AS `ET_ID`,
  1 AS `MAT_ID`,
  1 AS `MAT_CODE_APOGE`,
  1 AS `ANNEE_ID`,
  1 AS `MOYMAT_REMONTEE`,
  1 AS `ET_NUMERO_ABS` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mmi43_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `mmi43_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mmi43_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mmi43_notes_moyennes_export`
--

DROP TABLE IF EXISTS `mmi43_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mmi43_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mmi43_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `mmi43_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mmi43_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mmi43_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `mmi43_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mmi43_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mmi43_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `mmi43_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mmi43_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mmi43_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `mmi43_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mmi43_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mmi43_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `mmi43_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mmi43_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mmi43_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `mmi43_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mmi43_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mp63_notes_moyennes_absences`
--

DROP TABLE IF EXISTS `mp63_notes_moyennes_absences`;
/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_absences`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mp63_notes_moyennes_absences` AS SELECT
 1 AS `ET_ID`,
  1 AS `MAT_ID`,
  1 AS `MAT_CODE_APOGE`,
  1 AS `ANNEE_ID`,
  1 AS `MOYMAT_REMONTEE`,
  1 AS `ET_NUMERO_ABS` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mp63_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `mp63_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mp63_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mp63_notes_moyennes_export`
--

DROP TABLE IF EXISTS `mp63_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mp63_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mp63_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `mp63_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mp63_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mp63_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `mp63_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mp63_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mp63_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `mp63_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mp63_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mp63_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `mp63_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mp63_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mp63_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `mp63_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mp63_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `mp63_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `mp63_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `mp63_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `notes_absences`
--

DROP TABLE IF EXISTS `notes_absences`;
/*!50001 DROP VIEW IF EXISTS `notes_absences`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `notes_absences` AS SELECT
 1 AS `ABS_ID`,
  1 AS `ABS_ENS_ID`,
  1 AS `ABS_ET_ID`,
  1 AS `ABS_CRENEAU_ID`,
  1 AS `ABS_MAT_ID`,
  1 AS `ABS_DATE`,
  1 AS `ABS_JUSTIFICATION`,
  1 AS `ABS_EXCUSE`,
  1 AS `ABS_MAIL`,
  1 AS `COURS_ID`,
  1 AS `COURS_NOM`,
  1 AS `COURS_ENS_ID`,
  1 AS `CRENEAU_ID`,
  1 AS `CRENEAU_NOM`,
  1 AS `CRENEAU_DEMI`,
  1 AS `ABS_EXPIRE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `notes_access_enseignants`
--

DROP TABLE IF EXISTS `notes_access_enseignants`;
/*!50001 DROP VIEW IF EXISTS `notes_access_enseignants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `notes_access_enseignants` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ENS_ID`,
  1 AS `ENS_NOM`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `notes_export`
--

DROP TABLE IF EXISTS `notes_export`;
/*!50001 DROP VIEW IF EXISTS `notes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `notes_export` AS SELECT
 1 AS `MAT_ID`,
  1 AS `MAT_NOM`,
  1 AS `MAT_UE_ID`,
  1 AS `MAT_CODE_APOGE`,
  1 AS `MAT_COEF`,
  1 AS `MAT_SURMAT_ID`,
  1 AS `MAT_HAS_NOTE`,
  1 AS `MAT_LOCK_ANNEE_ID`,
  1 AS `MAT_START_ANNEE_ID`,
  1 AS `MAT_END_ANNEE_ID`,
  1 AS `MAT_COPIE_MAT_ID`,
  1 AS `UE_ID`,
  1 AS `UE_NOM`,
  1 AS `UE_SEM_ID`,
  1 AS `UE_COEF`,
  1 AS `UE_START_ANNEE_ID`,
  1 AS `UE_END_ANNEE_ID`,
  1 AS `SEM_ID`,
  1 AS `SEM_NOM`,
  1 AS `SEM_FORM_ID`,
  1 AS `SEM_COEF`,
  1 AS `SEM_START_ANNEE_ID`,
  1 AS `SEM_END_ANNEE_ID`,
  1 AS `FORM_ID`,
  1 AS `FORM_NOM`,
  1 AS `FORM_DEPT_ID`,
  1 AS `FORM_PRO`,
  1 AS `FORM_EVALUABLE`,
  1 AS `FORM_EVAL_DEBUT`,
  1 AS `FORM_EVAL_FIN`,
  1 AS `FORM_EVAL_PERIODE_ID`,
  1 AS `FORM_CODE_TROMBI`,
  1 AS `FORM_CODE_APOGEE`,
  1 AS `FORM_JURY_DEBUT`,
  1 AS `FORM_JURY_FIN` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `perso_access_enseignants`
--

DROP TABLE IF EXISTS `perso_access_enseignants`;
/*!50001 DROP VIEW IF EXISTS `perso_access_enseignants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `perso_access_enseignants` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ENS_ID`,
  1 AS `ENS_NOM`,
  1 AS `ENS_MAIL`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `planning_access_enseignants`
--

DROP TABLE IF EXISTS `planning_access_enseignants`;
/*!50001 DROP VIEW IF EXISTS `planning_access_enseignants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `planning_access_enseignants` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ENS_ID`,
  1 AS `ENS_NOM`,
  1 AS `ENS_MAIL`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `portail_access_enseignants`
--

DROP TABLE IF EXISTS `portail_access_enseignants`;
/*!50001 DROP VIEW IF EXISTS `portail_access_enseignants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `portail_access_enseignants` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ACCESS_ENSEIGNANT_ID`,
  1 AS `ACCESS_DEPT_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `portail_access_etudiants`
--

DROP TABLE IF EXISTS `portail_access_etudiants`;
/*!50001 DROP VIEW IF EXISTS `portail_access_etudiants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `portail_access_etudiants` AS SELECT
 1 AS `ET_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ET_ID`,
  1 AS `ET_NOM` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `poursuites_absences`
--

DROP TABLE IF EXISTS `poursuites_absences`;
/*!50001 DROP VIEW IF EXISTS `poursuites_absences`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `poursuites_absences` AS SELECT
 1 AS `ABS_ID`,
  1 AS `ABS_ENS_ID`,
  1 AS `ABS_ET_ID`,
  1 AS `ABS_CRENEAU_ID`,
  1 AS `ABS_COURS_ID`,
  1 AS `ABS_DATE`,
  1 AS `ABS_JUSTIFICATION`,
  1 AS `ABS_EXCUSE`,
  1 AS `ABS_MAIL`,
  1 AS `COURS_ID`,
  1 AS `COURS_NOM`,
  1 AS `COURS_ENS_ID`,
  1 AS `CRENEAU_DEMI`,
  1 AS `ABS_EXPIRE`,
  1 AS `ABS_REAL_DATE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `poursuites_absences_v2`
--

DROP TABLE IF EXISTS `poursuites_absences_v2`;
/*!50001 DROP VIEW IF EXISTS `poursuites_absences_v2`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `poursuites_absences_v2` AS SELECT
 1 AS `ABS_ID`,
  1 AS `ABS_ENS_ID`,
  1 AS `ABS_ET_ID`,
  1 AS `ABS_CRENEAU_ID`,
  1 AS `ABS_MAT_ID`,
  1 AS `ABS_DATE`,
  1 AS `ABS_JUSTIFICATION`,
  1 AS `ABS_EXCUSE`,
  1 AS `ABS_MAIL`,
  1 AS `ABS_REAL_DATE`,
  1 AS `ABS_EXPIRE`,
  1 AS `ABS_ANNEE_ID`,
  1 AS `CRENEAU_ID`,
  1 AS `CRENEAU_NOM`,
  1 AS `CRENEAU_DEMI`,
  1 AS `CRENEAU_REAL_START`,
  1 AS `CRENEAU_REAL_END`,
  1 AS `CRENEAU_DEPT_ID`,
  1 AS `CRENEAU_CLASSIQUE`,
  1 AS `MAT_ID`,
  1 AS `MAT_NOM`,
  1 AS `MAT_UE_ID`,
  1 AS `MAT_CODE_APOGE`,
  1 AS `MAT_COEF`,
  1 AS `MAT_SURMAT_ID`,
  1 AS `MAT_HAS_NOTE`,
  1 AS `MAT_LOCK_ANNEE_ID` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `poursuites_access_enseignants`
--

DROP TABLE IF EXISTS `poursuites_access_enseignants`;
/*!50001 DROP VIEW IF EXISTS `poursuites_access_enseignants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `poursuites_access_enseignants` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ENS_ID`,
  1 AS `ENS_NOM`,
  1 AS `ENS_MAIL`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `poursuites_pmatieres`
--

DROP TABLE IF EXISTS `poursuites_pmatieres`;
/*!50001 DROP VIEW IF EXISTS `poursuites_pmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `poursuites_pmatieres` AS SELECT
 1 AS `PMAT_ID`,
  1 AS `PMAT_NOM`,
  1 AS `PMAT_ENS_ID`,
  1 AS `MAT_PMAT_ID`,
  1 AS `PMAT_MAT_ID`,
  1 AS `ID`,
  1 AS `ENS_MAT_ID`,
  1 AS `MAT_ENS_ID`,
  1 AS `ENS_MAT_ANNEE_ID`,
  1 AS `ENS_MAT_NOTEUR`,
  1 AS `ENS_MAT_EVALUABLE`,
  1 AS `ENS_MAT_EVAL_DATE_DEBUT`,
  1 AS `ENS_MAT_EVAL_DATE_FIN`,
  1 AS `ENS_MAT_POURSUITE`,
  1 AS `ENS_ID`,
  1 AS `ENS_NOM`,
  1 AS `ENS_LOGIN`,
  1 AS `ENS_MAIL`,
  1 AS `ENS_PRETEUR`,
  1 AS `ENS_ADE`,
  1 AS `ENS_EDT`,
  1 AS `ENS_EDT_HEBDO`,
  1 AS `ENS_GESTIONNAIRE_ADE`,
  1 AS `ANNEE_ID`,
  1 AS `ANNEE_NOM`,
  1 AS `ANNEE_COURANTE`,
  1 AS `ANNEE_CLOSE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `pro_access_enseignants`
--

DROP TABLE IF EXISTS `pro_access_enseignants`;
/*!50001 DROP VIEW IF EXISTS `pro_access_enseignants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `pro_access_enseignants` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ENS_ID`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE`,
  1 AS `ENS_NOM`,
  1 AS `ENS_MAIL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `pro_access_etudiants`
--

DROP TABLE IF EXISTS `pro_access_etudiants`;
/*!50001 DROP VIEW IF EXISTS `pro_access_etudiants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `pro_access_etudiants` AS SELECT
 1 AS `ET_LOGIN`,
  1 AS `ACCESS_NOM`,
  1 AS `ACCESS_ADRESS`,
  1 AS `ET_ID`,
  1 AS `ET_NOM`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `promotion_access_enseignants`
--

DROP TABLE IF EXISTS `promotion_access_enseignants`;
/*!50001 DROP VIEW IF EXISTS `promotion_access_enseignants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `promotion_access_enseignants` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ENS_ID`,
  1 AS `ENS_NOM`,
  1 AS `ENS_MAIL`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `retour_access_enseignants`
--

DROP TABLE IF EXISTS `retour_access_enseignants`;
/*!50001 DROP VIEW IF EXISTS `retour_access_enseignants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `retour_access_enseignants` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ENS_ID`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE`,
  1 AS `ENS_NOM` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `rt63_notes_moyennes_absences`
--

DROP TABLE IF EXISTS `rt63_notes_moyennes_absences`;
/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_absences`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `rt63_notes_moyennes_absences` AS SELECT
 1 AS `ET_ID`,
  1 AS `MAT_ID`,
  1 AS `MAT_CODE_APOGE`,
  1 AS `ANNEE_ID`,
  1 AS `MOYMAT_REMONTEE`,
  1 AS `ET_NUMERO_ABS` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `rt63_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `rt63_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `rt63_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `rt63_notes_moyennes_export`
--

DROP TABLE IF EXISTS `rt63_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `rt63_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `rt63_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `rt63_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `rt63_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `rt63_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `rt63_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `rt63_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `rt63_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `rt63_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `rt63_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `rt63_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `rt63_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `rt63_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `rt63_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `rt63_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `rt63_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `rt63_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `rt63_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `rt63_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `semestres_groupes_code`
--

DROP TABLE IF EXISTS `semestres_groupes_code`;
/*!50001 DROP VIEW IF EXISTS `semestres_groupes_code`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `semestres_groupes_code` AS SELECT
 1 AS `GROUPE_SEM_ID`,
  1 AS `SEM_GROUPE_ID`,
  1 AS `SEM_GROUPE_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `soutenances_access_enseignants`
--

DROP TABLE IF EXISTS `soutenances_access_enseignants`;
/*!50001 DROP VIEW IF EXISTS `soutenances_access_enseignants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `soutenances_access_enseignants` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ENS_ID`,
  1 AS `ENS_NOM`,
  1 AS `ENS_MAIL`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stage_access_enseignants`
--

DROP TABLE IF EXISTS `stage_access_enseignants`;
/*!50001 DROP VIEW IF EXISTS `stage_access_enseignants`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stage_access_enseignants` AS SELECT
 1 AS `ENS_LOGIN`,
  1 AS `ENS_ID`,
  1 AS `ENS_NOM`,
  1 AS `ENS_MAIL`,
  1 AS `ACCESS_DEPT_ID`,
  1 AS `DEPT_CODE` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stid15_notes_moyennes_absences`
--

DROP TABLE IF EXISTS `stid15_notes_moyennes_absences`;
/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_absences`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stid15_notes_moyennes_absences` AS SELECT
 1 AS `ET_ID`,
  1 AS `MAT_ID`,
  1 AS `MAT_CODE_APOGE`,
  1 AS `ANNEE_ID`,
  1 AS `MOYMAT_REMONTEE`,
  1 AS `ET_NUMERO_ABS` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stid15_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `stid15_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stid15_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stid15_notes_moyennes_export`
--

DROP TABLE IF EXISTS `stid15_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stid15_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stid15_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `stid15_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stid15_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stid15_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `stid15_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stid15_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stid15_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `stid15_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stid15_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stid15_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `stid15_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stid15_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stid15_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `stid15_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stid15_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `stid15_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `stid15_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `stid15_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `tc03_notes_moyennes_annee`
--

DROP TABLE IF EXISTS `tc03_notes_moyennes_annee`;
/*!50001 DROP VIEW IF EXISTS `tc03_notes_moyennes_annee`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `tc03_notes_moyennes_annee` AS SELECT
 1 AS `MOYAN_VALEUR`,
  1 AS `MOYAN_ET_ID`,
  1 AS `MOYAN_FORM_ID`,
  1 AS `MOYAN_ANNEE_ID`,
  1 AS `MOYAN_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `tc03_notes_moyennes_export`
--

DROP TABLE IF EXISTS `tc03_notes_moyennes_export`;
/*!50001 DROP VIEW IF EXISTS `tc03_notes_moyennes_export`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `tc03_notes_moyennes_export` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `ET_NUMERO`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_COEF` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `tc03_notes_moyennes_matiere`
--

DROP TABLE IF EXISTS `tc03_notes_moyennes_matiere`;
/*!50001 DROP VIEW IF EXISTS `tc03_notes_moyennes_matiere`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `tc03_notes_moyennes_matiere` AS SELECT
 1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_SPECIAL`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `tc03_notes_moyennes_matiere_sans_bonus`
--

DROP TABLE IF EXISTS `tc03_notes_moyennes_matiere_sans_bonus`;
/*!50001 DROP VIEW IF EXISTS `tc03_notes_moyennes_matiere_sans_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `tc03_notes_moyennes_matiere_sans_bonus` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `tc03_notes_moyennes_matiere_somme_bonus`
--

DROP TABLE IF EXISTS `tc03_notes_moyennes_matiere_somme_bonus`;
/*!50001 DROP VIEW IF EXISTS `tc03_notes_moyennes_matiere_somme_bonus`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `tc03_notes_moyennes_matiere_somme_bonus` AS SELECT
 1 AS `MOYMAT_BONUS_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SURMAT_ID`,
  1 AS `MOYMAT_BONUS_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `tc03_notes_moyennes_semestre`
--

DROP TABLE IF EXISTS `tc03_notes_moyennes_semestre`;
/*!50001 DROP VIEW IF EXISTS `tc03_notes_moyennes_semestre`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `tc03_notes_moyennes_semestre` AS SELECT
 1 AS `MOYSEM_VALEUR`,
  1 AS `MOYSEM_ET_ID`,
  1 AS `MOYSEM_FORM_ID`,
  1 AS `MOYSEM_ANNEE_ID`,
  1 AS `MOYSEM_COEF`,
  1 AS `MOYSEM_ID`,
  1 AS `MOYSEM_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `tc03_notes_moyennes_surmatieres`
--

DROP TABLE IF EXISTS `tc03_notes_moyennes_surmatieres`;
/*!50001 DROP VIEW IF EXISTS `tc03_notes_moyennes_surmatieres`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `tc03_notes_moyennes_surmatieres` AS SELECT
 1 AS `MOYMAT_VALEUR`,
  1 AS `MOYMAT_MAT_ID`,
  1 AS `MOYMAT_COEF`,
  1 AS `MOYMAT_ET_ID`,
  1 AS `MOYMAT_ANNEE_ID`,
  1 AS `MOYMAT_UE_ID`,
  1 AS `MOYMAT_UE_COEF`,
  1 AS `MOYMAT_SEM_COEF`,
  1 AS `MOYMAT_SEM_ID`,
  1 AS `MOYMAT_FORM_ID`,
  1 AS `MOYMAT_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `tc03_notes_moyennes_ue`
--

DROP TABLE IF EXISTS `tc03_notes_moyennes_ue`;
/*!50001 DROP VIEW IF EXISTS `tc03_notes_moyennes_ue`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `tc03_notes_moyennes_ue` AS SELECT
 1 AS `MOYUE_VALEUR`,
  1 AS `MOYUE_ET_ID`,
  1 AS `MOYUE_ANNEE_ID`,
  1 AS `MOYUE_UE_ID`,
  1 AS `MOYUE_COEF`,
  1 AS `MOYUE_SEM_COEF`,
  1 AS `MOYUE_SEM_ID`,
  1 AS `MOYUE_FORM_ID`,
  1 AS `MOYUE_COEF_CALC`,
  1 AS `MOYUE_SPECIAL` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `trombinoscope`
--

DROP TABLE IF EXISTS `trombinoscope`;
/*!50001 DROP VIEW IF EXISTS `trombinoscope`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `trombinoscope` AS SELECT
 1 AS `ET_ID`,
  1 AS `ET_NOM`,
  1 AS `GROUPE_ID`,
  1 AS `GROUPE_NOM`,
  1 AS `GROUPE_ENS_ID`,
  1 AS `ET_NUMERO`,
  1 AS `GROUPE_FEUILLE`,
  1 AS `ET_MAIL`,
  1 AS `ET_BAC`,
  1 AS `ET_NAISSANCE`,
  1 AS `ET_TIERS`,
  1 AS `ET_RED`,
  1 AS `ANNEE_ID`,
  1 AS `ANNEE_NOM`,
  1 AS `FORM_ID`,
  1 AS `FORM_NOM`,
  1 AS `FORM_DEPT_ID`,
  1 AS `FORM_PRO`,
  1 AS `SEM_ID`,
  1 AS `SEM_NOM` */;
SET character_set_client = @saved_cs_client;

--
-- Current Database: `odin`
--

USE `odin`;

--
-- Final view structure for view `absences_access_enseignants`
--

/*!50001 DROP VIEW IF EXISTS `absences_access_enseignants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `absences_access_enseignants` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_enseignant`.`ENS_ID` AS `ENS_ID`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`common_enseignant`.`ENS_MAIL` AS `ENS_MAIL`,`common_access_absences`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_departement`.`DEPT_CODE` AS `DEPT_CODE` from (((`common_access_absences` join `common_enseignants_departement`) join `common_enseignant`) join `common_departement`) where `common_enseignant`.`ENS_ID` = `common_access_absences`.`ACCESS_ENSEIGNANT_ID` and `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 and `common_enseignants_departement`.`ENS_DEPT_ID` = `common_access_absences`.`ACCESS_DEPT_ID` and `common_departement`.`DEPT_ID` = `common_enseignants_departement`.`ENS_DEPT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `absences_mail`
--

/*!50001 DROP VIEW IF EXISTS `absences_mail`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `absences_mail` AS select `common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`etudiants_groupes`.`ET_NOM` AS `ET_NOM`,`common_absences_v2`.`ABS_DATE` AS `ABS_DATE`,`common_matiere`.`MAT_NOM` AS `COURS_NOM`,`common_absences_creneau`.`CRENEAU_NOM` AS `CRENEAU_NOM`,`etudiants_groupes`.`GROUPE_ENS_ID` AS `GROUPE_ENS_ID`,`common_absences_v2`.`ABS_ID` AS `ABS_ID`,`etudiants_groupes`.`ET_MAIL` AS `ET_MAIL`,`etudiants_groupes`.`GROUPE_ID` AS `GROUPE_ID`,`etudiants_groupes`.`GROUPE_NOM` AS `GROUPE_NOM`,`common_absences_v2`.`ABS_REAL_DATE` AS `ABS_REAL_DATE`,`common_absences_creneau`.`CRENEAU_REAL_START` AS `CRENEAU_REAL_START`,`common_absences_creneau`.`CRENEAU_REAL_END` AS `CRENEAU_REAL_END`,`common_absences_v2`.`ABS_JUSTIFICATION` AS `ABS_JUSTIFICATION`,`common_absences_type`.`ABST_NOM` AS `ABST_NOM` from ((((((`common_absences_v2` join `common_enseignant`) join `etudiants_groupes`) join `common_matiere`) join `common_absences_creneau`) join `common_annee`) left join `common_absences_type` on(`common_absences_type`.`ABST_ID` = `common_absences_v2`.`ABS_ABST_ID`)) where `common_absences_v2`.`ABS_JUSTIFICATION` = 'non' and `common_absences_v2`.`ABS_MAIL` = 0 and `common_enseignant`.`ENS_ID` = `common_absences_v2`.`ABS_ENS_ID` and `etudiants_groupes`.`ET_ID` = `common_absences_v2`.`ABS_ET_ID` and `common_matiere`.`MAT_ID` = `common_absences_v2`.`ABS_MAT_ID` and `common_absences_creneau`.`CRENEAU_ID` = `common_absences_v2`.`ABS_CRENEAU_ID` and `etudiants_groupes`.`GROUPE_ENS_ID` is not null and `common_annee`.`ANNEE_ID` = `etudiants_groupes`.`ET_GROUPE_ANNEE_ID` and `common_annee`.`ANNEE_COURANTE` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `absences_pro_mail`
--

/*!50001 DROP VIEW IF EXISTS `absences_pro_mail`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `absences_pro_mail` AS select `common_pro_absences`.`PROABS_ID` AS `PROABS_ID`,`common_pro_absences`.`PROABS_ENS_ID` AS `PROABS_ENS_ID`,`common_pro_absences`.`PROABS_ET_ID` AS `PROABS_ET_ID`,`common_pro_absences`.`PROABS_DATE` AS `PROABS_DATE`,`common_pro_absences`.`PROABS_JUSTIFICATION` AS `PROABS_JUSTIFICATION`,`common_pro_absences`.`PROABS_EXCUSE` AS `PROABS_EXCUSE`,`common_pro_absences`.`PROABS_MAIL` AS `PROABS_MAIL`,`common_pro_absences`.`PROABS_REAL_DATE` AS `PROABS_REAL_DATE`,`common_pro_absences`.`PROABS_EXPIRE` AS `PROABS_EXPIRE`,`common_backup_ade_enseignant`.`EDT_NOM` AS `EDT_NOM`,`common_backup_ade_enseignant`.`EDT_HEURE_DEBUT` AS `EDT_HEURE_DEBUT`,`common_backup_ade_enseignant`.`EDT_HEURE_FIN` AS `EDT_HEURE_FIN`,`enseignants_formations`.`ENS_NOM` AS `ENS_NOM` from ((`common_pro_absences` join `common_backup_ade_enseignant`) join `enseignants_formations`) where `common_pro_absences`.`PROABS_EDT_UID` = `common_backup_ade_enseignant`.`EDT_UID` and `common_backup_ade_enseignant`.`EDT_ENS_ID` = `enseignants_formations`.`ENS_ID` and `common_pro_absences`.`PROABS_MAIL` = 0 group by `common_pro_absences`.`PROABS_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `affectations_enseignants`
--

/*!50001 DROP VIEW IF EXISTS `affectations_enseignants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `affectations_enseignants` AS select `common_enseignants_matieres`.`ID` AS `ID`,`common_enseignants_matieres`.`ENS_MAT_ID` AS `ENS_MAT_ID`,`common_enseignants_matieres`.`MAT_ENS_ID` AS `MAT_ENS_ID`,`common_enseignants_matieres`.`ENS_MAT_ANNEE_ID` AS `ENS_MAT_ANNEE_ID`,`common_enseignants_matieres`.`ENS_MAT_NOTEUR` AS `ENS_MAT_NOTEUR`,`common_enseignants_matieres`.`ENS_MAT_EVALUABLE` AS `ENS_MAT_EVALUABLE`,`common_enseignants_matieres`.`ENS_MAT_EVAL_DATE_DEBUT` AS `ENS_MAT_EVAL_DATE_DEBUT`,`common_enseignants_matieres`.`ENS_MAT_EVAL_DATE_FIN` AS `ENS_MAT_EVAL_DATE_FIN`,`common_enseignants_matieres`.`ENS_MAT_POURSUITE` AS `ENS_MAT_POURSUITE`,`common_matiere`.`MAT_ID` AS `MAT_ID`,`common_matiere`.`MAT_NOM` AS `MAT_NOM`,`common_matiere`.`MAT_UE_ID` AS `MAT_UE_ID`,`common_matiere`.`MAT_CODE_APOGE` AS `MAT_CODE_APOGE`,`common_matiere`.`MAT_COEF` AS `MAT_COEF`,`common_matiere`.`MAT_SURMAT_ID` AS `MAT_SURMAT_ID`,`common_matiere`.`MAT_HAS_NOTE` AS `MAT_HAS_NOTE`,`common_matiere`.`MAT_LOCK_ANNEE_ID` AS `MAT_LOCK_ANNEE_ID`,`common_matiere`.`MAT_START_ANNEE_ID` AS `MAT_START_ANNEE_ID`,`common_matiere`.`MAT_END_ANNEE_ID` AS `MAT_END_ANNEE_ID`,`common_ue`.`UE_ID` AS `UE_ID`,`common_ue`.`UE_NOM` AS `UE_NOM`,`common_ue`.`UE_SEM_ID` AS `UE_SEM_ID`,`common_ue`.`UE_COEF` AS `UE_COEF`,`common_ue`.`UE_START_ANNEE_ID` AS `UE_START_ANNEE_ID`,`common_ue`.`UE_END_ANNEE_ID` AS `UE_END_ANNEE_ID`,`common_semestre`.`SEM_ID` AS `SEM_ID`,`common_semestre`.`SEM_NOM` AS `SEM_NOM`,`common_semestre`.`SEM_FORM_ID` AS `SEM_FORM_ID`,`common_semestre`.`SEM_COEF` AS `SEM_COEF`,`common_semestre`.`SEM_START_ANNEE_ID` AS `SEM_START_ANNEE_ID`,`common_semestre`.`SEM_END_ANNEE_ID` AS `SEM_END_ANNEE_ID`,`common_formation`.`FORM_ID` AS `FORM_ID`,`common_formation`.`FORM_NOM` AS `FORM_NOM`,`common_formation`.`FORM_DEPT_ID` AS `FORM_DEPT_ID`,`common_formation`.`FORM_PRO` AS `FORM_PRO`,`common_formation`.`FORM_EVALUABLE` AS `FORM_EVALUABLE`,`common_formation`.`FORM_EVAL_DEBUT` AS `FORM_EVAL_DEBUT`,`common_formation`.`FORM_EVAL_FIN` AS `FORM_EVAL_FIN`,`common_formation`.`FORM_EVAL_PERIODE_ID` AS `FORM_EVAL_PERIODE_ID`,`common_formation`.`FORM_CODE_TROMBI` AS `FORM_CODE_TROMBI`,`common_formation`.`FORM_CODE_APOGEE` AS `FORM_CODE_APOGEE`,`common_formation`.`FORM_JURY_DEBUT` AS `FORM_JURY_DEBUT`,`common_formation`.`FORM_JURY_FIN` AS `FORM_JURY_FIN`,`common_enseignants_departement`.`DEPT_ENS_ID` AS `DEPT_ENS_ID`,`common_enseignants_departement`.`ENS_DEPT_ID` AS `ENS_DEPT_ID`,`common_enseignants_departement`.`ENS_DEPT_CURRENT` AS `ENS_DEPT_CURRENT`,`common_annee`.`ANNEE_ID` AS `ANNEE_ID`,`common_annee`.`ANNEE_NOM` AS `ANNEE_NOM`,`common_annee`.`ANNEE_COURANTE` AS `ANNEE_COURANTE`,`common_annee`.`ANNEE_CLOSE` AS `ANNEE_CLOSE` from ((((((`common_enseignants_matieres` join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_formation`) join `common_enseignants_departement`) join `common_annee`) where `common_annee`.`ANNEE_ID` = `common_enseignants_matieres`.`ENS_MAT_ANNEE_ID` and `common_annee`.`ANNEE_COURANTE` = 1 and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and `common_formation`.`FORM_DEPT_ID` = `common_enseignants_departement`.`ENS_DEPT_ID` and `common_enseignants_departement`.`DEPT_ENS_ID` = `common_enseignants_matieres`.`MAT_ENS_ID` and `common_matiere`.`MAT_ID` = `common_enseignants_matieres`.`ENS_MAT_ID` and `common_matiere`.`MAT_HAS_NOTE` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio15_notes_moyennes_absences`
--

/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_absences`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio15_notes_moyennes_absences` AS select `common_notes`.`NOTES_ET_ID` AS `ET_ID`,`common_matiere`.`MAT_ID` AS `MAT_ID`,`common_matiere`.`MAT_CODE_APOGE` AS `MAT_CODE_APOGE`,`common_controle`.`CONTROLE_ANNEE_ID` AS `ANNEE_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_REMONTEE`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO_ABS` from ((((`common_notes` join `common_controle`) join `common_matiere`) join `common_etudiant`) join `common_annee`) where `common_matiere`.`MAT_ID` = `common_controle`.`CONTROLE_MAT_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_etudiant`.`ET_ID` = `common_notes`.`NOTES_ET_ID` and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_notes`.`NOTES_ET_ID`,`common_matiere`.`MAT_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio15_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio15_notes_moyennes_annee` AS select sum(`bio15_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `bio15_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`bio15_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`bio15_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`bio15_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`bio15_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`bio15_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `bio15_notes_moyennes_semestre` group by `bio15_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`bio15_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio15_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio15_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `bio15_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `bio15_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio15_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio15_notes_moyennes_matiere` AS select `bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`bio15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`bio15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`bio15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`bio15_notes_moyennes_matiere_sans_bonus` left join `bio15_notes_moyennes_matiere_somme_bonus` on(`bio15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `bio15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `bio15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `bio15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `bio15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `bio15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `bio15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio15_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio15_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 8 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio15_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio15_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 8 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio15_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio15_notes_moyennes_semestre` AS select sum(`bio15_notes_moyennes_ue`.`MOYUE_VALEUR` * `bio15_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`bio15_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`bio15_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`bio15_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`bio15_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`bio15_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`bio15_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`bio15_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `bio15_notes_moyennes_ue` group by `bio15_notes_moyennes_ue`.`MOYUE_SEM_ID`,`bio15_notes_moyennes_ue`.`MOYUE_ET_ID`,`bio15_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio15_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio15_notes_moyennes_surmatieres` AS select sum(if(`bio15_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`bio15_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `bio15_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`bio15_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`bio15_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`bio15_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `bio15_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`bio15_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`bio15_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`bio15_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`bio15_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`bio15_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`bio15_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`bio15_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`bio15_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `bio15_notes_moyennes_matiere` where `bio15_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `bio15_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`bio15_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`bio15_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio15_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `bio15_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio15_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `bio15_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `bio15_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio63_notes_moyennes_absences`
--

/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_absences`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio63_notes_moyennes_absences` AS select `common_notes`.`NOTES_ET_ID` AS `ET_ID`,`common_matiere`.`MAT_ID` AS `MAT_ID`,`common_matiere`.`MAT_CODE_APOGE` AS `MAT_CODE_APOGE`,`common_controle`.`CONTROLE_ANNEE_ID` AS `ANNEE_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_REMONTEE`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO_ABS` from ((((`common_notes` join `common_controle`) join `common_matiere`) join `common_etudiant`) join `common_annee`) where `common_matiere`.`MAT_ID` = `common_controle`.`CONTROLE_MAT_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_etudiant`.`ET_ID` = `common_notes`.`NOTES_ET_ID` and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_notes`.`NOTES_ET_ID`,`common_matiere`.`MAT_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio63_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio63_notes_moyennes_annee` AS select sum(`bio63_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `bio63_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`bio63_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`bio63_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`bio63_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`bio63_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`bio63_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `bio63_notes_moyennes_semestre` group by `bio63_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`bio63_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio63_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio63_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `bio63_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `bio63_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio63_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio63_notes_moyennes_matiere` AS select `bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`bio63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`bio63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`bio63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`bio63_notes_moyennes_matiere_sans_bonus` left join `bio63_notes_moyennes_matiere_somme_bonus` on(`bio63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `bio63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `bio63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `bio63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `bio63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `bio63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `bio63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio63_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio63_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 5 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio63_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio63_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 5 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio63_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio63_notes_moyennes_semestre` AS select sum(`bio63_notes_moyennes_ue`.`MOYUE_VALEUR` * `bio63_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`bio63_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`bio63_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`bio63_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`bio63_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`bio63_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`bio63_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`bio63_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `bio63_notes_moyennes_ue` group by `bio63_notes_moyennes_ue`.`MOYUE_SEM_ID`,`bio63_notes_moyennes_ue`.`MOYUE_ET_ID`,`bio63_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio63_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio63_notes_moyennes_surmatieres` AS select sum(if(`bio63_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`bio63_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `bio63_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`bio63_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`bio63_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`bio63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `bio63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`bio63_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`bio63_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`bio63_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`bio63_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`bio63_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`bio63_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`bio63_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`bio63_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `bio63_notes_moyennes_matiere` where `bio63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `bio63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`bio63_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`bio63_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `bio63_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `bio63_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `bio63_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `bio63_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `bio63_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `chimie43_notes_moyennes_absences`
--

/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_absences`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `chimie43_notes_moyennes_absences` AS select `common_notes`.`NOTES_ET_ID` AS `ET_ID`,`common_matiere`.`MAT_ID` AS `MAT_ID`,`common_matiere`.`MAT_CODE_APOGE` AS `MAT_CODE_APOGE`,`common_controle`.`CONTROLE_ANNEE_ID` AS `ANNEE_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_REMONTEE`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO_ABS` from ((((`common_notes` join `common_controle`) join `common_matiere`) join `common_etudiant`) join `common_annee`) where `common_matiere`.`MAT_ID` = `common_controle`.`CONTROLE_MAT_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_etudiant`.`ET_ID` = `common_notes`.`NOTES_ET_ID` and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_notes`.`NOTES_ET_ID`,`common_matiere`.`MAT_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `chimie43_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `chimie43_notes_moyennes_annee` AS select sum(`chimie43_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `chimie43_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`chimie43_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`chimie43_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`chimie43_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`chimie43_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`chimie43_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `chimie43_notes_moyennes_semestre` group by `chimie43_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`chimie43_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `chimie43_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `chimie43_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `chimie43_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `chimie43_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `chimie43_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `chimie43_notes_moyennes_matiere` AS select `chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`chimie43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`chimie43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`chimie43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`chimie43_notes_moyennes_matiere_sans_bonus` left join `chimie43_notes_moyennes_matiere_somme_bonus` on(`chimie43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `chimie43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `chimie43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `chimie43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `chimie43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `chimie43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `chimie43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `chimie43_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `chimie43_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 9 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `chimie43_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `chimie43_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 9 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `chimie43_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `chimie43_notes_moyennes_semestre` AS select sum(`chimie43_notes_moyennes_ue`.`MOYUE_VALEUR` * `chimie43_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`chimie43_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`chimie43_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`chimie43_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`chimie43_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`chimie43_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`chimie43_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`chimie43_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `chimie43_notes_moyennes_ue` group by `chimie43_notes_moyennes_ue`.`MOYUE_SEM_ID`,`chimie43_notes_moyennes_ue`.`MOYUE_ET_ID`,`chimie43_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `chimie43_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `chimie43_notes_moyennes_surmatieres` AS select sum(if(`chimie43_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`chimie43_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `chimie43_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`chimie43_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`chimie43_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`chimie43_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `chimie43_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`chimie43_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`chimie43_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`chimie43_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`chimie43_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`chimie43_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`chimie43_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`chimie43_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`chimie43_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `chimie43_notes_moyennes_matiere` where `chimie43_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `chimie43_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`chimie43_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`chimie43_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `chimie43_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `chimie43_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `chimie43_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `chimie43_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `chimie43_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_absences`
--

/*!50001 DROP VIEW IF EXISTS `common_access_absences`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_absences` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Absences' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/absences' AS `ACCESS_ADRESS`,`common_enseignants_matieres`.`MAT_ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_formation`.`FORM_DEPT_ID` AS `ACCESS_DEPT_ID` from ((((((`common_formation` join `common_semestre`) join `common_ue`) join `common_matiere`) join `common_enseignants_matieres`) join `common_enseignant`) join `common_enseignants_departement`) where `common_enseignants_matieres`.`MAT_ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_formation`.`FORM_DEPT_ID` = `common_enseignants_departement`.`ENS_DEPT_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and `common_matiere`.`MAT_ID` = `common_enseignants_matieres`.`ENS_MAT_ID` and `common_enseignant`.`ENS_ID` = `common_enseignants_matieres`.`MAT_ENS_ID` group by `common_formation`.`FORM_DEPT_ID`,`common_enseignants_matieres`.`MAT_ENS_ID` union select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Absences' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/absences' AS `ACCESS_ADRESS`,`common_secretaire`.`SECRETAIRE_ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_formation`.`FORM_DEPT_ID` AS `ACCESS_DEPT_ID` from ((`common_secretaire` join `common_formation`) join `common_enseignant`) where `common_enseignant`.`ENS_ID` = `common_secretaire`.`SECRETAIRE_ENS_ID` and `common_formation`.`FORM_ID` = `common_secretaire`.`SECRETAIRE_FORM_ID` group by `common_enseignant`.`ENS_ID`,`common_formation`.`FORM_DEPT_ID` union select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Absences' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/absences' AS `ACCESS_ADRESS`,`common_responsable_formation`.`RESPONSABLE_ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_formation`.`FORM_DEPT_ID` AS `ACCESS_DEPT_ID` from ((`common_responsable_formation` join `common_formation`) join `common_enseignant`) where `common_enseignant`.`ENS_ID` = `common_responsable_formation`.`RESPONSABLE_ENS_ID` and `common_formation`.`FORM_ID` = `common_responsable_formation`.`RESPONSABLE_FORM_ID` group by `common_enseignant`.`ENS_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_admin`
--

/*!50001 DROP VIEW IF EXISTS `common_access_admin`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_admin` AS (select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Admin' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/admin/' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_departement`.`DEPT_ID` AS `ACCESS_DEPT_ID` from ((`common_enseignant` join `common_departement`) join `common_enseignants_departement`) where `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_departement`.`DEPT_ID` = `common_enseignants_departement`.`ENS_DEPT_ID` and `common_enseignant`.`ENS_ID` = `common_departement`.`DEPT_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1) union (select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Admin' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/admin/' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ENS_ID`,`common_departement`.`DEPT_ID` AS `DEPT_ID` from ((((`common_enseignant` join `common_formation`) join `common_departement`) join `common_enseignants_departement`) join `common_responsable_formation`) where `common_enseignant`.`ENS_ID` = `common_responsable_formation`.`RESPONSABLE_ENS_ID` and `common_formation`.`FORM_ID` = `common_responsable_formation`.`RESPONSABLE_FORM_ID` and `common_departement`.`DEPT_ID` = `common_formation`.`FORM_DEPT_ID` and `common_departement`.`DEPT_ID` = `common_enseignants_departement`.`ENS_DEPT_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1) union (select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Admin' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/admin/' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ENS_ID`,`common_departement`.`DEPT_ID` AS `DEPT_ID` from ((((`common_enseignant` join `common_formation`) join `common_departement`) join `common_enseignants_departement`) join `common_secretaire`) where `common_enseignant`.`ENS_ID` = `common_secretaire`.`SECRETAIRE_ENS_ID` and `common_formation`.`FORM_ID` = `common_secretaire`.`SECRETAIRE_FORM_ID` and `common_departement`.`DEPT_ID` = `common_formation`.`FORM_DEPT_ID` and `common_departement`.`DEPT_ID` = `common_enseignants_departement`.`ENS_DEPT_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1) union select distinct 'cebouhou' AS `ENS_LOGIN`,'Admin' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/admin/' AS `ACCESS_ADRESS`,1 AS `ACCESS_ENSEIGNANT_ID`,`common_departement`.`DEPT_ID` AS `ACCESS_DEPT_ID` from `common_departement` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_direction`
--

/*!50001 DROP VIEW IF EXISTS `common_access_direction`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_direction` AS select distinct `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Direction' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/direction' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_enseignants_departement`.`ENS_DEPT_ID` AS `ACCESS_DEPT_ID` from (`common_enseignant` join `common_enseignants_departement`) where `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_enseignant`.`ENS_DIRECTION` = 1 and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_edt`
--

/*!50001 DROP VIEW IF EXISTS `common_access_edt`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_edt` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Emploi du temps' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/edt' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_enseignants_departement`.`ENS_DEPT_ID` AS `ACCESS_DEPT_ID` from (`common_enseignant` join `common_enseignants_departement`) where `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 and (`common_enseignant`.`ENS_ADE` is not null and `common_enseignant`.`ENS_ADE` <> '' or `common_enseignant`.`ENS_GESTIONNAIRE_ADE` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_emprunt`
--

/*!50001 DROP VIEW IF EXISTS `common_access_emprunt`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_emprunt` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Emprunts' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/emprunts' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_enseignants_departement`.`ENS_DEPT_ID` AS `ACCESS_DEPT_ID` from (`common_enseignant` join `common_enseignants_departement`) where `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_ID` = 1 and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_etudiants`
--

/*!50001 DROP VIEW IF EXISTS `common_access_etudiants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_etudiants` AS select `common_etudiant`.`ET_LOGIN` AS `ET_LOGIN`,'Etudiants' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/etudiants' AS `ACCESS_ADRESS`,`common_etudiant`.`ET_ID` AS `ET_ID`,`common_etudiant`.`ET_NOM` AS `ET_NOM`,`common_formation`.`FORM_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_departement`.`DEPT_CODE` AS `DEPT_CODE` from ((((`common_etudiant` join `common_inscription`) join `common_semestre`) join `common_formation`) join `common_departement`) where `common_departement`.`DEPT_ID` = `common_formation`.`FORM_DEPT_ID` and `common_etudiant`.`ET_ID` = `common_inscription`.`INSCRIPT_ET_ID` and `common_semestre`.`SEM_ID` = `common_inscription`.`INSCRIPT_SEM_ID` and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` group by `common_etudiant`.`ET_ID`,`common_departement`.`DEPT_CODE` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_jury`
--

/*!50001 DROP VIEW IF EXISTS `common_access_jury`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_jury` AS select distinct `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Jury' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/jury' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_enseignants_departement`.`ENS_DEPT_ID` AS `ACCESS_DEPT_ID` from (((`common_enseignant` join `common_enseignants_departement`) join `common_formation`) left join `common_responsable_formation` on(`common_formation`.`FORM_ID` = `common_responsable_formation`.`RESPONSABLE_FORM_ID` and `common_enseignant`.`ENS_ID` = `common_responsable_formation`.`RESPONSABLE_ENS_ID`)) where `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 and `common_enseignants_departement`.`ENS_DEPT_ID` = `common_formation`.`FORM_DEPT_ID` and (`common_formation`.`FORM_JURY_DEBUT` <= unix_timestamp() and `common_formation`.`FORM_JURY_FIN` >= unix_timestamp() or `common_enseignant`.`ENS_ID` = `common_responsable_formation`.`RESPONSABLE_ENS_ID` and `common_formation`.`FORM_ID` = `common_responsable_formation`.`RESPONSABLE_FORM_ID`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_mediateur`
--

/*!50001 DROP VIEW IF EXISTS `common_access_mediateur`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_mediateur` AS (select distinct `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Suivi des étudiants' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/mediateur/' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_enseignants_departement`.`ENS_DEPT_ID` AS `ACCESS_DEPT_ID` from (((`common_enseignant` join `common_enseignants_departement`) join `common_groupes`) join `common_formation`) where `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_enseignant`.`ENS_ID` = `common_groupes`.`GROUPE_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_ID` = `common_formation`.`FORM_DEPT_ID` and `common_formation`.`FORM_ID` = `common_groupes`.`GROUPE_FORM_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1) union (select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Suivi des étudiants' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/mediateur/' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_departement`.`DEPT_ID` AS `ACCESS_DEPT_ID` from ((`common_enseignant` join `common_departement`) join `common_enseignants_departement`) where `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_departement`.`DEPT_ID` = `common_enseignants_departement`.`ENS_DEPT_ID` and `common_enseignant`.`ENS_ID` = `common_departement`.`DEPT_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1) union (select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Suivi des étudiants' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/mediateur/' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ENS_ID`,`common_departement`.`DEPT_ID` AS `DEPT_ID` from ((((`common_enseignant` join `common_formation`) join `common_departement`) join `common_enseignants_departement`) join `common_responsable_formation`) where `common_enseignant`.`ENS_ID` = `common_responsable_formation`.`RESPONSABLE_ENS_ID` and `common_formation`.`FORM_ID` = `common_responsable_formation`.`RESPONSABLE_FORM_ID` and `common_departement`.`DEPT_ID` = `common_formation`.`FORM_DEPT_ID` and `common_departement`.`DEPT_ID` = `common_enseignants_departement`.`ENS_DEPT_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 and `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID`) union (select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Suivi des étudiants' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/mediateur/' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ENS_ID`,`common_departement`.`DEPT_ID` AS `DEPT_ID` from ((((`common_enseignant` join `common_formation`) join `common_departement`) join `common_enseignants_departement`) join `common_secretaire`) where `common_enseignant`.`ENS_ID` = `common_secretaire`.`SECRETAIRE_ENS_ID` and `common_formation`.`FORM_ID` = `common_secretaire`.`SECRETAIRE_FORM_ID` and `common_departement`.`DEPT_ID` = `common_formation`.`FORM_DEPT_ID` and `common_departement`.`DEPT_ID` = `common_enseignants_departement`.`ENS_DEPT_ID` and `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_notes`
--

/*!50001 DROP VIEW IF EXISTS `common_access_notes`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_notes` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Notes' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/notes' AS `ACCESS_ADRESS`,`common_enseignants_matieres`.`MAT_ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_formation`.`FORM_DEPT_ID` AS `ACCESS_DEPT_ID` from (((((((`common_formation` join `common_semestre`) join `common_ue`) join `common_matiere`) join `common_enseignants_matieres`) join `common_enseignant`) join `common_enseignants_departement`) join `common_annee`) where `common_enseignants_matieres`.`MAT_ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_formation`.`FORM_DEPT_ID` = `common_enseignants_departement`.`ENS_DEPT_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and `common_matiere`.`MAT_ID` = `common_enseignants_matieres`.`ENS_MAT_ID` and `common_enseignant`.`ENS_ID` = `common_enseignants_matieres`.`MAT_ENS_ID` and `common_enseignants_matieres`.`ENS_MAT_NOTEUR` = 1 and `common_annee`.`ANNEE_ID` = `common_enseignants_matieres`.`ENS_MAT_ANNEE_ID` and `common_annee`.`ANNEE_COURANTE` = 1 group by `common_formation`.`FORM_DEPT_ID`,`common_enseignants_matieres`.`MAT_ENS_ID` union select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Notes' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/notes' AS `ACCESS_ADRESS`,`common_secretaire`.`SECRETAIRE_ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_formation`.`FORM_DEPT_ID` AS `ACCESS_DEPT_ID` from ((`common_secretaire` join `common_formation`) join `common_enseignant`) where `common_enseignant`.`ENS_ID` = `common_secretaire`.`SECRETAIRE_ENS_ID` and `common_formation`.`FORM_ID` = `common_secretaire`.`SECRETAIRE_FORM_ID` group by `common_enseignant`.`ENS_ID`,`common_formation`.`FORM_DEPT_ID` union select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Notes' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/notes' AS `ACCESS_ADRESS`,`common_responsable_formation`.`RESPONSABLE_ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_formation`.`FORM_DEPT_ID` AS `ACCESS_DEPT_ID` from ((`common_responsable_formation` join `common_formation`) join `common_enseignant`) where `common_enseignant`.`ENS_ID` = `common_responsable_formation`.`RESPONSABLE_ENS_ID` and `common_formation`.`FORM_ID` = `common_responsable_formation`.`RESPONSABLE_FORM_ID` group by `common_enseignant`.`ENS_ID`,`common_formation`.`FORM_DEPT_ID` union select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Notes' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/notes' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_formation`.`FORM_DEPT_ID` AS `ACCESS_DEPT_ID` from ((`common_enseignant` join `common_groupes`) join `common_formation`) where `common_enseignant`.`ENS_ID` = `common_groupes`.`GROUPE_ENS_ID` and `common_formation`.`FORM_ID` = `common_groupes`.`GROUPE_FORM_ID` group by `common_enseignant`.`ENS_ID`,`common_formation`.`FORM_DEPT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_odin_professionnalisation_enseignant`
--

/*!50001 DROP VIEW IF EXISTS `common_access_odin_professionnalisation_enseignant`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_odin_professionnalisation_enseignant` AS (select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Professionnalisation' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/professionnalisation/' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_departement`.`DEPT_ID` AS `ACCESS_DEPT_ID` from (((`common_enseignant` join `common_departement`) join `common_enseignants_departement`) join `common_formation`) where `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_departement`.`DEPT_ID` = `common_enseignants_departement`.`ENS_DEPT_ID` and `common_enseignant`.`ENS_ID` = `common_departement`.`DEPT_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 and `common_departement`.`DEPT_ID` = `common_formation`.`FORM_DEPT_ID` and `common_formation`.`FORM_PRO` = 1) union (select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Professionnalisation' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/professionnalisation/' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_departement`.`DEPT_ID` AS `ACCESS_DEPT_ID` from ((((`common_enseignant` join `common_formation`) join `common_departement`) join `common_enseignants_departement`) join `common_responsable_formation`) where `common_enseignant`.`ENS_ID` = `common_responsable_formation`.`RESPONSABLE_ENS_ID` and `common_formation`.`FORM_ID` = `common_responsable_formation`.`RESPONSABLE_FORM_ID` and `common_departement`.`DEPT_ID` = `common_formation`.`FORM_DEPT_ID` and `common_departement`.`DEPT_ID` = `common_enseignants_departement`.`ENS_DEPT_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 and `common_formation`.`FORM_PRO` = 1) union (select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Professionnalisation' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/professionnalisation/' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_departement`.`DEPT_ID` AS `ACCESS_DEPT_ID` from ((((`common_enseignant` join `common_formation`) join `common_departement`) join `common_enseignants_departement`) join `common_secretaire`) where `common_enseignant`.`ENS_ID` = `common_secretaire`.`SECRETAIRE_ENS_ID` and `common_formation`.`FORM_ID` = `common_secretaire`.`SECRETAIRE_FORM_ID` and `common_departement`.`DEPT_ID` = `common_formation`.`FORM_DEPT_ID` and `common_departement`.`DEPT_ID` = `common_enseignants_departement`.`ENS_DEPT_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 and `common_formation`.`FORM_PRO` = 1) union (select distinct `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Professionnalisation' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/professionnalisation/' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_enseignants_departement`.`ENS_DEPT_ID` AS `ACCESS_DEPT_ID` from ((((((`common_enseignant` join `common_enseignants_departement`) join `common_etudiant`) join `common_inscription`) join `common_annee`) join `common_semestre`) join `common_formation`) where `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_enseignant`.`ENS_ID` = `common_etudiant`.`ET_TUTEUR_ENS_ID` and `common_etudiant`.`ET_ID` = `common_inscription`.`INSCRIPT_ET_ID` and `common_annee`.`ANNEE_ID` = `common_inscription`.`INSCRIPT_ANNEE_ID` and `common_annee`.`ANNEE_COURANTE` = 1 and `common_semestre`.`SEM_ID` = `common_inscription`.`INSCRIPT_SEM_ID` and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and `common_enseignants_departement`.`ENS_DEPT_ID` = `common_formation`.`FORM_DEPT_ID` and `common_formation`.`FORM_PRO` = 1) union (select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Professionnalisation' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/professionnalisation/' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_enseignants_departement`.`ENS_DEPT_ID` AS `ACCESS_DEPT_ID` from (((((((`common_enseignant` join `common_enseignants_matieres`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_formation`) join `common_enseignants_departement`) join `common_annee`) where `common_matiere`.`MAT_ID` = `common_enseignants_matieres`.`ENS_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and `common_formation`.`FORM_PRO` = 1 and `common_annee`.`ANNEE_ID` = `common_enseignants_matieres`.`ENS_MAT_ANNEE_ID` and `common_annee`.`ANNEE_COURANTE` = 1 and `common_enseignant`.`ENS_ID` = `common_enseignants_matieres`.`MAT_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_ID` = `common_formation`.`FORM_DEPT_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 group by `common_enseignant`.`ENS_ID`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_odin_professionnalisation_etudiants`
--

/*!50001 DROP VIEW IF EXISTS `common_access_odin_professionnalisation_etudiants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_odin_professionnalisation_etudiants` AS select `common_etudiant`.`ET_LOGIN` AS `ET_LOGIN`,'Professionnalisation' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/professionnalisation' AS `ACCESS_ADRESS`,`common_etudiant`.`ET_ID` AS `ET_ID`,`common_etudiant`.`ET_NOM` AS `ET_NOM`,`common_departement`.`DEPT_ID` AS `ACCESS_DEPT_ID`,`common_departement`.`DEPT_CODE` AS `DEPT_CODE` from (((((`common_etudiant` join `common_inscription`) join `common_annee`) join `common_semestre`) join `common_formation`) join `common_departement`) where `common_departement`.`DEPT_ID` = `common_formation`.`FORM_DEPT_ID` and `common_annee`.`ANNEE_COURANTE` = 1 and `common_annee`.`ANNEE_ID` = `common_inscription`.`INSCRIPT_ANNEE_ID` and `common_etudiant`.`ET_ID` = `common_inscription`.`INSCRIPT_ET_ID` and `common_semestre`.`SEM_ID` = `common_inscription`.`INSCRIPT_SEM_ID` and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and `common_formation`.`FORM_PRO` = 1 and 0 = 1 group by `common_etudiant`.`ET_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_perso`
--

/*!50001 DROP VIEW IF EXISTS `common_access_perso`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_perso` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Mes infos' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/perso' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_enseignants_departement`.`ENS_DEPT_ID` AS `ACCESS_DEPT_ID` from (`common_enseignant` join `common_enseignants_departement`) where `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_planning`
--

/*!50001 DROP VIEW IF EXISTS `common_access_planning`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_planning` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Planification' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/planning' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_enseignants_departement`.`ENS_DEPT_ID` AS `ACCESS_DEPT_ID` from ((`common_enseignant` join `common_enseignants_departement`) join `common_planning`) where `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 and `common_enseignants_departement`.`ENS_DEPT_ID` = `common_planning`.`PLANNING_DEPT_ID` and `common_planning`.`PLANNING_START_ENS` <= unix_timestamp() and `common_planning`.`PLANNING_END_ENS` > unix_timestamp() group by `common_enseignant`.`ENS_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_poursuites`
--

/*!50001 DROP VIEW IF EXISTS `common_access_poursuites`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_poursuites` AS (select distinct `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Poursuites d\'études' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/poursuite' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_enseignants_departement`.`ENS_DEPT_ID` AS `ACCESS_DEPT_ID` from ((((((((`common_poursuite_matiere_composition` join `common_matiere`) join `common_enseignants_matieres`) join `common_enseignant`) join `common_enseignants_departement`) join `common_annee`) join `common_ue`) join `common_semestre`) join `common_formation`) where `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and `common_enseignants_departement`.`ENS_DEPT_ID` = `common_formation`.`FORM_DEPT_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 and `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_matiere`.`MAT_ID` = `common_poursuite_matiere_composition`.`PMAT_MAT_ID` and `common_matiere`.`MAT_ID` = `common_enseignants_matieres`.`ENS_MAT_ID` and `common_enseignant`.`ENS_ID` = `common_enseignants_matieres`.`MAT_ENS_ID` and `common_annee`.`ANNEE_ID` = `common_enseignants_matieres`.`ENS_MAT_ANNEE_ID` and `common_annee`.`ANNEE_COURANTE` = 1 and `common_enseignants_matieres`.`ENS_MAT_POURSUITE` = 1) union (select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Poursuites d\'études' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/poursuite' AS `ACCESS_ADRESS`,`common_secretaire`.`SECRETAIRE_ENS_ID` AS `SECRETAIRE_ENS_ID`,`common_formation`.`FORM_DEPT_ID` AS `ACCESS_DEPT_ID` from ((`common_secretaire` join `common_enseignant`) join `common_formation`) where `common_enseignant`.`ENS_ID` = `common_secretaire`.`SECRETAIRE_ENS_ID` and `common_formation`.`FORM_ID` = `common_secretaire`.`SECRETAIRE_FORM_ID`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_promotion`
--

/*!50001 DROP VIEW IF EXISTS `common_access_promotion`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_promotion` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Promotion' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/promotion' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_enseignants_departement`.`ENS_DEPT_ID` AS `ACCESS_DEPT_ID` from (`common_enseignant` join `common_enseignants_departement`) where `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_retour`
--

/*!50001 DROP VIEW IF EXISTS `common_access_retour`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_retour` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Retour des étudiants' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/retour' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_formation`.`FORM_DEPT_ID` AS `ACCESS_DEPT_ID` from (((((`common_enseignant` join `common_enseignants_matieres`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_formation`) where `common_formation`.`FORM_EVALUABLE` = 1 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_matiere`.`MAT_ID` = `common_enseignants_matieres`.`ENS_MAT_ID` and `common_enseignant`.`ENS_ID` = `common_enseignants_matieres`.`MAT_ENS_ID` group by `common_enseignant`.`ENS_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_soutenances`
--

/*!50001 DROP VIEW IF EXISTS `common_access_soutenances`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_soutenances` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Soutenances' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/soutenances' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_enseignants_departement`.`ENS_DEPT_ID` AS `ACCESS_DEPT_ID` from ((((((`common_soutenances_explications` join `common_soutenances_niveau`) join `common_formation`) join `common_enseignants_departement`) join `common_enseignant`) join `common_soutenances_destination`) join `common_soutenances_session`) where `common_soutenances_destination`.`DEST_ID` = `common_soutenances_niveau`.`NIVEAU_DEST_ID` and `common_soutenances_session`.`SESSION_ID` = `common_soutenances_destination`.`DEST_SESSION_ID` and `common_soutenances_niveau`.`NIVEAU_ID` = `common_soutenances_explications`.`EXPLICATION_NIVEAU_ID` and `common_formation`.`FORM_ID` = `common_soutenances_niveau`.`NIVEAU_FORM_ID` and `common_enseignants_departement`.`ENS_DEPT_ID` = `common_formation`.`FORM_DEPT_ID` and `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 and (`common_soutenances_session`.`SESSION_START` <= unix_timestamp() and `common_soutenances_session`.`SESSION_END` > unix_timestamp() or `common_soutenances_session`.`SESSION_HARMONISATION_START` <= unix_timestamp() and `common_soutenances_session`.`SESSION_HARMONISATION_END` > unix_timestamp()) group by `common_enseignant`.`ENS_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_access_stage`
--

/*!50001 DROP VIEW IF EXISTS `common_access_stage`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_access_stage` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Gestion des stages' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/stage' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_enseignants_departement`.`ENS_DEPT_ID` AS `ACCESS_DEPT_ID` from (`common_enseignant` join `common_enseignants_departement`) where `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 and `common_enseignants_departement`.`ENS_DEPT_STAGE` = 1 union select distinct `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,'Gestion des stages' AS `ACCESS_NOM`,'https://odin.iut.uca.fr/stage' AS `ACCESS_ADRESS`,`common_enseignant`.`ENS_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_logon`.`DEPT_ID` AS `ACCESS_DEPT_ID` from ((`common_logon` join `common_enseignant`) join `common_enseignants_departement`) where `common_enseignant`.`ENS_ID` = `common_logon`.`LOGON_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 and `common_logon`.`DEPT_ID` = `common_enseignants_departement`.`ENS_DEPT_ID` and `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `common_logon`
--

/*!50001 DROP VIEW IF EXISTS `common_logon`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `common_logon` AS select `common_formation`.`FORM_ID` AS `FORM_ID`,`common_formation`.`FORM_DEPT_ID` AS `DEPT_ID`,`common_responsable_formation`.`RESPONSABLE_ENS_ID` AS `LOGON_ENS_ID`,'Responsable' AS `TYPE` from (`common_formation` join `common_responsable_formation`) where `common_responsable_formation`.`RESPONSABLE_FORM_ID` = `common_formation`.`FORM_ID` union select `common_formation`.`FORM_ID` AS `FORM_ID`,`common_formation`.`FORM_DEPT_ID` AS `DEPT_ID`,`common_secretaire`.`SECRETAIRE_ENS_ID` AS `LOGON_ENS_ID`,'Secrétaire' AS `TYPE` from (`common_formation` join `common_secretaire`) where `common_secretaire`.`SECRETAIRE_FORM_ID` = `common_formation`.`FORM_ID` union select `common_formation`.`FORM_ID` AS `FORM_ID`,`common_departement`.`DEPT_ID` AS `DEPT_ID`,`common_departement`.`DEPT_ENS_ID` AS `LOGON_ENS_ID`,'Chef' AS `TYPE` from (`common_departement` join `common_formation`) where `common_departement`.`DEPT_ID` = `common_formation`.`FORM_DEPT_ID` union select `common_formation`.`FORM_ID` AS `FORM_ID`,`common_formation`.`FORM_DEPT_ID` AS `DEPT_ID`,1 AS `LOGON_ENS_ID`,'Admin' AS `TYPE` from `common_formation` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `direction_access_enseignants`
--

/*!50001 DROP VIEW IF EXISTS `direction_access_enseignants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `direction_access_enseignants` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_enseignant`.`ENS_ID` AS `ENS_ID`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`common_access_direction`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_departement`.`DEPT_CODE` AS `DEPT_CODE` from ((`common_access_direction` join `common_enseignant`) join `common_departement`) where `common_enseignant`.`ENS_ID` = `common_access_direction`.`ACCESS_ENSEIGNANT_ID` and `common_departement`.`DEPT_ID` = `common_access_direction`.`ACCESS_DEPT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `edt_access_enseignants`
--

/*!50001 DROP VIEW IF EXISTS `edt_access_enseignants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `edt_access_enseignants` AS select `common_access_edt`.`ACCESS_ENSEIGNANT_ID` AS `ENS_ID`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_enseignant`.`ENS_MAIL` AS `ENS_MAIL`,`common_enseignant`.`ENS_PRETEUR` AS `ENS_PRETEUR`,`common_enseignant`.`ENS_ADE` AS `ENS_ADE`,`common_enseignant`.`ENS_EDT` AS `ENS_EDT`,`common_enseignant`.`ENS_EDT_HEBDO` AS `ENS_EDT_HEBDO`,`common_enseignant`.`ENS_GESTIONNAIRE_ADE` AS `ENS_GESTIONNAIRE_ADE`,`common_access_edt`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_departement`.`DEPT_CODE` AS `DEPT_CODE` from ((`common_access_edt` join `common_enseignant`) join `common_departement`) where `common_departement`.`DEPT_ID` = `common_access_edt`.`ACCESS_DEPT_ID` and `common_enseignant`.`ENS_ID` = `common_access_edt`.`ACCESS_ENSEIGNANT_ID` group by `common_access_edt`.`ACCESS_DEPT_ID`,`common_access_edt`.`ACCESS_ENSEIGNANT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `edt_interventions`
--

/*!50001 DROP VIEW IF EXISTS `edt_interventions`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `edt_interventions` AS select `common_enseignants_matieres`.`ENS_MAT_ID` AS `ENS_MAT_ID`,`common_enseignants_matieres`.`MAT_ENS_ID` AS `MAT_ENS_ID`,`common_enseignants_matieres`.`ENS_MAT_ANNEE_ID` AS `ENS_MAT_ANNEE_ID`,`common_periodes_matieres`.`PERIODE_MAT_ID` AS `PERIODE_MAT_ID`,`common_periodes_matieres`.`MAT_PERIODE_ID` AS `MAT_PERIODE_ID`,`common_enseignant`.`ENS_ID` AS `ENS_ID`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_enseignant`.`ENS_MAIL` AS `ENS_MAIL`,`common_enseignant`.`ENS_PRETEUR` AS `ENS_PRETEUR`,`common_enseignant`.`ENS_ADE` AS `ENS_ADE`,`common_enseignant`.`ENS_EDT` AS `ENS_EDT`,`common_enseignant`.`ENS_EDT_HEBDO` AS `ENS_EDT_HEBDO`,`common_enseignant`.`ENS_GESTIONNAIRE_ADE` AS `ENS_GESTIONNAIRE_ADE`,`common_edt_periode`.`PERIODE_ID` AS `PERIODE_ID`,`common_edt_periode`.`PERIODE_NOM` AS `PERIODE_NOM`,`common_edt_periode`.`PERIODE_LIMIT` AS `PERIODE_LIMIT`,`common_edt_periode`.`PERIODE_LIMIT_NOTES` AS `PERIODE_LIMIT_NOTES`,`common_edt_periode`.`PERIODE_DEBUT_WARNING` AS `PERIODE_DEBUT_WARNING`,`common_edt_periode`.`PERIODE_ANNEE_ID` AS `PERIODE_ANNEE_ID`,`common_edt_periode`.`PERIODE_FORM_ID_1` AS `PERIODE_FORM_ID_1`,`common_edt_periode`.`PERIODE_FORM_ID_2` AS `PERIODE_FORM_ID_2`,`common_edt_periode`.`PERIODE_TYPE` AS `PERIODE_TYPE`,unix_timestamp(`common_edt_periode`.`PERIODE_DEBUT`) AS `CLASSEMENT`,date_format(`common_edt_periode`.`PERIODE_DEBUT`,'%d/%m/%Y') AS `PERIODE_DEBUT`,date_format(`common_edt_periode`.`PERIODE_FIN`,'%d/%m/%Y') AS `PERIODE_FIN`,date_format(`common_edt_periode`.`PERIODE_EXAM_DEBUT`,'%d/%m/%Y') AS `PERIODE_EXAM_DEBUT`,date_format(`common_edt_periode`.`PERIODE_EXAM_FIN`,'%d/%m/%Y') AS `PERIODE_EXAM_FIN`,`common_edt_periode`.`PERIODE_SEMAINES` AS `PERIODE_SEMAINES`,`common_annee`.`ANNEE_ID` AS `ANNEE_ID`,`common_annee`.`ANNEE_NOM` AS `ANNEE_NOM`,`common_annee`.`ANNEE_COURANTE` AS `ANNEE_COURANTE`,`common_annee`.`ANNEE_CLOSE` AS `ANNEE_CLOSE`,`common_matiere`.`MAT_NOM` AS `MAT_NOM`,`common_enseignants_departement`.`ENS_DEPT_ID` AS `ENS_DEPT_ID` from ((((((`common_enseignants_matieres` join `common_periodes_matieres`) join `common_enseignant`) join `common_edt_periode`) join `common_annee`) join `common_matiere`) join `common_enseignants_departement`) where `common_enseignants_departement`.`DEPT_ENS_ID` = `common_enseignant`.`ENS_ID` and `common_enseignant`.`ENS_ID` = `common_enseignants_matieres`.`MAT_ENS_ID` and `common_enseignants_matieres`.`ENS_MAT_ID` = `common_periodes_matieres`.`PERIODE_MAT_ID` and `common_enseignants_matieres`.`ENS_MAT_ANNEE_ID` = `common_edt_periode`.`PERIODE_ANNEE_ID` and `common_edt_periode`.`PERIODE_ID` = `common_periodes_matieres`.`MAT_PERIODE_ID` and `common_annee`.`ANNEE_ID` = `common_edt_periode`.`PERIODE_ANNEE_ID` and `common_enseignants_matieres`.`ENS_MAT_ID` = `common_matiere`.`MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `edt_periode`
--

/*!50001 DROP VIEW IF EXISTS `edt_periode`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `edt_periode` AS select `common_edt_periode`.`PERIODE_ID` AS `PERIODE_ID`,`common_edt_periode`.`PERIODE_NOM` AS `PERIODE_NOM`,`common_edt_periode`.`PERIODE_LIMIT` AS `PERIODE_LIMIT`,`common_edt_periode`.`PERIODE_DEBUT_WARNING` AS `PERIODE_DEBUT_WARNING`,`common_edt_periode`.`PERIODE_ANNEE_ID` AS `PERIODE_ANNEE_ID`,`common_edt_periode`.`PERIODE_FORM_ID_1` AS `PERIODE_FORM_ID_1`,`common_edt_periode`.`PERIODE_FORM_ID_2` AS `PERIODE_FORM_ID_2`,`common_edt_periode`.`PERIODE_TYPE` AS `PERIODE_TYPE`,`common_edt_periode`.`PERIODE_DEBUT` AS `PERIODE_DEBUT`,`common_edt_periode`.`PERIODE_FIN` AS `PERIODE_FIN`,`common_edt_periode`.`PERIODE_EXAM_DEBUT` AS `PERIODE_EXAM_DEBUT`,`common_edt_periode`.`PERIODE_EXAM_FIN` AS `PERIODE_EXAM_FIN`,`common_edt_periode`.`PERIODE_SEMAINES` AS `PERIODE_SEMAINES`,`common_annee`.`ANNEE_ID` AS `ANNEE_ID`,`common_annee`.`ANNEE_NOM` AS `ANNEE_NOM`,`common_annee`.`ANNEE_COURANTE` AS `ANNEE_COURANTE`,`common_annee`.`ANNEE_CLOSE` AS `ANNEE_CLOSE` from (`common_edt_periode` join `common_annee`) where `common_annee`.`ANNEE_ID` = `common_edt_periode`.`PERIODE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `emprunt`
--

/*!50001 DROP VIEW IF EXISTS `emprunt`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `emprunt` AS select `total`.`EMPRUNT_OBJ_ID` AS `EMPRUNT_OBJ_ID`,`total`.`EMPRUNT_ENS_ID` AS `EMPRUNT_ENS_ID`,`total`.`EMPRUNT_ET_ID` AS `EMPRUNT_ET_ID`,`total`.`EMPRUNT_EXTERNE` AS `EMPRUNT_EXTERNE`,`total`.`EMPRUNT_DATE_OUT` AS `EMPRUNT_DATE_OUT`,`total`.`EMPRUNT_DATE_RETOUR` AS `EMPRUNT_DATE_RETOUR`,`total`.`EMPRUNT_NOMBRE` AS `EMPRUNT_NOMBRE` from ((select `etudiants`.`EMPRUNT_OBJ_ID` AS `EMPRUNT_OBJ_ID`,`etudiants`.`EMPRUNT_ENS_ID` AS `EMPRUNT_ENS_ID`,`etudiants`.`EMPRUNT_ET_ID` AS `EMPRUNT_ET_ID`,`etudiants`.`EMPRUNT_EXTERNE` AS `EMPRUNT_EXTERNE`,`etudiants`.`EMPRUNT_DATE_OUT` AS `EMPRUNT_DATE_OUT`,`etudiants`.`EMPRUNT_DATE_RETOUR` AS `EMPRUNT_DATE_RETOUR`,`etudiants`.`EMPRUNT_NOMBRE` AS `EMPRUNT_NOMBRE` from `common_emprunt_etudiant` `etudiants`) union all (select `enseignants`.`EMPRUNT_OBJ_ID` AS `EMPRUNT_OBJ_ID`,`enseignants`.`EMPRUNT_ENS_ID` AS `EMPRUNT_ENS_ID`,`enseignants`.`EMPRUNT_ET_ID` AS `EMPRUNT_ET_ID`,`enseignants`.`EMPRUNT_EXTERNE` AS `EMPRUNT_EXTERNE`,`enseignants`.`EMPRUNT_DATE_OUT` AS `EMPRUNT_DATE_OUT`,`enseignants`.`EMPRUNT_DATE_RETOUR` AS `EMPRUNT_DATE_RETOUR`,`enseignants`.`EMPRUNT_NOMBRE` AS `EMPRUNT_NOMBRE` from `common_emprunt` `enseignants`)) `total` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `emprunt_access_enseignants`
--

/*!50001 DROP VIEW IF EXISTS `emprunt_access_enseignants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `emprunt_access_enseignants` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_emprunt`.`ACCESS_ENSEIGNANT_ID` AS `ENS_ID`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`common_access_emprunt`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_departement`.`DEPT_CODE` AS `DEPT_CODE` from ((`common_access_emprunt` join `common_enseignant`) join `common_departement`) where `common_departement`.`DEPT_ID` = `common_access_emprunt`.`ACCESS_DEPT_ID` and `common_enseignant`.`ENS_ID` = `common_access_emprunt`.`ACCESS_ENSEIGNANT_ID` group by `common_access_emprunt`.`ACCESS_DEPT_ID`,`common_access_emprunt`.`ACCESS_ENSEIGNANT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `enseignants_formations`
--

/*!50001 DROP VIEW IF EXISTS `enseignants_formations`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `enseignants_formations` AS select `common_enseignant`.`ENS_ID` AS `ENS_ID`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_enseignant`.`ENS_MAIL` AS `ENS_MAIL`,`common_enseignant`.`ENS_PRETEUR` AS `ENS_PRETEUR`,`common_enseignant`.`ENS_ADE` AS `ENS_ADE`,`common_enseignant`.`ENS_EDT` AS `ENS_EDT`,`common_enseignant`.`ENS_EDT_HEBDO` AS `ENS_EDT_HEBDO`,`common_enseignant`.`ENS_GESTIONNAIRE_ADE` AS `ENS_GESTIONNAIRE_ADE`,`common_enseignants_departement`.`DEPT_ENS_ID` AS `DEPT_ENS_ID`,`common_enseignants_departement`.`ENS_DEPT_ID` AS `ENS_DEPT_ID`,`common_enseignants_departement`.`ENS_DEPT_CURRENT` AS `ENS_DEPT_CURRENT`,`common_formation`.`FORM_ID` AS `FORM_ID`,`common_formation`.`FORM_NOM` AS `FORM_NOM`,`common_formation`.`FORM_DEPT_ID` AS `FORM_DEPT_ID`,`common_formation`.`FORM_PRO` AS `FORM_PRO` from ((`common_enseignant` join `common_enseignants_departement`) join `common_formation`) where `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_ID` = `common_formation`.`FORM_DEPT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `etudiants_absences`
--

/*!50001 DROP VIEW IF EXISTS `etudiants_absences`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `etudiants_absences` AS select `common_absences_v2`.`ABS_ID` AS `ABS_ID`,`common_absences_v2`.`ABS_ENS_ID` AS `ABS_ENS_ID`,`common_absences_v2`.`ABS_ET_ID` AS `ABS_ET_ID`,`common_absences_v2`.`ABS_CRENEAU_ID` AS `ABS_CRENEAU_ID`,`common_absences_v2`.`ABS_MAT_ID` AS `ABS_MAT_ID`,`common_absences_v2`.`ABS_DATE` AS `ABS_DATE`,`common_absences_v2`.`ABS_JUSTIFICATION` AS `ABS_JUSTIFICATION`,`common_absences_v2`.`ABS_EXCUSE` AS `ABS_EXCUSE`,`common_absences_v2`.`ABS_MAIL` AS `ABS_MAIL`,`common_etudiant`.`ET_ID` AS `ET_ID`,`common_etudiant`.`ET_NOM` AS `ET_NOM`,`common_etudiant`.`ET_LOGIN` AS `ET_LOGIN`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`common_etudiant`.`ET_MAIL` AS `ET_MAIL`,`common_etudiant`.`ET_NAISSANCE` AS `ET_NAISSANCE`,`common_etudiant`.`ET_QUIZZBOX` AS `ET_QUIZZBOX`,`common_absences_v2`.`ABS_EXPIRE` AS `ABS_EXPIRE` from (`common_absences_v2` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `common_absences_v2`.`ABS_ET_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `etudiants_access_etudiants`
--

/*!50001 DROP VIEW IF EXISTS `etudiants_access_etudiants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `etudiants_access_etudiants` AS select `common_etudiant`.`ET_ID` AS `ET_ID`,`common_etudiant`.`ET_NOM` AS `ET_NOM`,`common_etudiant`.`ET_LOGIN` AS `ET_LOGIN`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`common_etudiant`.`ET_MAIL` AS `ET_MAIL`,`common_etudiant`.`ET_NAISSANCE` AS `ET_NAISSANCE`,`common_etudiant`.`ET_QUIZZBOX` AS `ET_QUIZZBOX`,`common_etudiant`.`ET_EDT` AS `ET_EDT`,`common_access_etudiants`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_access_etudiants`.`DEPT_CODE` AS `DEPT_CODE` from (`common_etudiant` join `common_access_etudiants`) where `common_etudiant`.`ET_ID` = `common_access_etudiants`.`ET_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `etudiants_emprunts_objets`
--

/*!50001 DROP VIEW IF EXISTS `etudiants_emprunts_objets`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `etudiants_emprunts_objets` AS select `common_objet`.`OBJ_ID` AS `OBJ_ID`,`common_objet`.`OBJ_NOM` AS `OBJ_NOM`,`common_objet`.`OBJ_STOCK` AS `OBJ_STOCK`,`total`.`EMPRUNT_OBJ_ID` AS `EMPRUNT_OBJ_ID`,`total`.`EMPRUNT_ENS_ID` AS `EMPRUNT_ENS_ID`,`total`.`EMPRUNT_ET_ID` AS `EMPRUNT_ET_ID`,`total`.`EMPRUNT_EXTERNE` AS `EMPRUNT_EXTERNE`,`total`.`EMPRUNT_DATE_OUT` AS `EMPRUNT_DATE_OUT`,`total`.`EMPRUNT_DATE_RETOUR` AS `EMPRUNT_DATE_RETOUR`,`total`.`EMPRUNT_NOMBRE` AS `EMPRUNT_NOMBRE` from (`common_objet` left join ((select `etudiants`.`EMPRUNT_OBJ_ID` AS `EMPRUNT_OBJ_ID`,`etudiants`.`EMPRUNT_ENS_ID` AS `EMPRUNT_ENS_ID`,`etudiants`.`EMPRUNT_ET_ID` AS `EMPRUNT_ET_ID`,`etudiants`.`EMPRUNT_EXTERNE` AS `EMPRUNT_EXTERNE`,`etudiants`.`EMPRUNT_DATE_OUT` AS `EMPRUNT_DATE_OUT`,`etudiants`.`EMPRUNT_DATE_RETOUR` AS `EMPRUNT_DATE_RETOUR`,`etudiants`.`EMPRUNT_NOMBRE` AS `EMPRUNT_NOMBRE` from `common_emprunt_etudiant` `etudiants`) union all (select `enseignants`.`EMPRUNT_OBJ_ID` AS `EMPRUNT_OBJ_ID`,`enseignants`.`EMPRUNT_ENS_ID` AS `EMPRUNT_ENS_ID`,`enseignants`.`EMPRUNT_ET_ID` AS `EMPRUNT_ET_ID`,`enseignants`.`EMPRUNT_EXTERNE` AS `EMPRUNT_EXTERNE`,`enseignants`.`EMPRUNT_DATE_OUT` AS `EMPRUNT_DATE_OUT`,`enseignants`.`EMPRUNT_DATE_RETOUR` AS `EMPRUNT_DATE_RETOUR`,`enseignants`.`EMPRUNT_NOMBRE` AS `EMPRUNT_NOMBRE` from `common_emprunt` `enseignants`)) `total` on(`common_objet`.`OBJ_ID` = `total`.`EMPRUNT_OBJ_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `etudiants_groupes`
--

/*!50001 DROP VIEW IF EXISTS `etudiants_groupes`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `etudiants_groupes` AS select `common_groupes`.`GROUPE_ID` AS `GROUPE_ID`,`common_groupes`.`GROUPE_NOM` AS `GROUPE_NOM`,`common_groupes`.`GROUPE_ENS_ID` AS `GROUPE_ENS_ID`,`common_groupes`.`GROUPE_FEUILLE` AS `GROUPE_FEUILLE`,`common_groupes`.`GROUPE_PARENT` AS `GROUPE_PARENT`,`common_groupes`.`GROUPE_CODE` AS `GROUPE_CODE`,`common_groupes`.`GROUPE_ADE` AS `GROUPE_ADE`,`common_groupes`.`GROUPE_FORM_ID` AS `GROUPE_FORM_ID`,`common_groupes`.`GROUPE_POURSUITE` AS `GROUPE_POURSUITE`,`common_groupes`.`GROUPE_DELETED` AS `GROUPE_DELETED`,`common_groupes`.`GROUPE_PRO` AS `GROUPE_PRO`,`common_etudiant_groupes`.`ET_GROUPE_CODE` AS `ET_GROUPE_CODE`,`common_etudiant_groupes`.`GROUPE_ET_ID` AS `GROUPE_ET_ID`,`common_etudiant_groupes`.`ET_GROUPE_ANNEE_ID` AS `ET_GROUPE_ANNEE_ID`,`common_etudiant`.`ET_ID` AS `ET_ID`,`common_etudiant`.`ET_NOM` AS `ET_NOM`,`common_etudiant`.`ET_NOM_DE_FAMILLE` AS `ET_NOM_DE_FAMILLE`,`common_etudiant`.`ET_PRENOM` AS `ET_PRENOM`,`common_etudiant`.`ET_LOGIN` AS `ET_LOGIN`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`common_etudiant`.`ET_MAIL` AS `ET_MAIL`,`common_etudiant`.`ET_NAISSANCE` AS `ET_NAISSANCE`,`common_etudiant`.`ET_QUIZZBOX` AS `ET_QUIZZBOX`,`common_etudiant`.`ET_BAC` AS `ET_BAC`,`common_etudiant`.`ET_EDT` AS `ET_EDT`,`common_etudiant`.`ET_TIERS` AS `ET_TIERS`,`common_etudiant`.`ET_RED` AS `ET_RED`,`common_etudiant`.`ET_SPORTIF` AS `ET_SPORTIF`,`common_etudiant`.`ET_DEM` AS `ET_DEM`,`common_etudiant`.`ET_PROFESSIONNALISATION` AS `ET_PROFESSIONNALISATION`,`common_etudiant`.`ET_TEL` AS `ET_TEL`,`common_etudiant`.`ET_ORIGINE` AS `ET_ORIGINE`,`common_etudiant`.`ET_ENTREPRISE` AS `ET_ENTREPRISE`,`common_etudiant`.`ET_ADRESSE` AS `ET_ADRESSE`,`common_etudiant`.`ET_ADRESSE_2` AS `ET_ADRESSE_2`,`common_etudiant`.`ET_ADRESSE_ENTREPRISE` AS `ET_ADRESSE_ENTREPRISE`,`common_etudiant`.`ET_DEBUT` AS `ET_DEBUT`,`common_etudiant`.`ET_HEURES_MAX` AS `ET_HEURES_MAX`,`common_etudiant`.`ET_HEURES_FACTUREES` AS `ET_HEURES_FACTUREES`,`common_etudiant`.`ET_TUTEUR_ENS_ID` AS `ET_TUTEUR_ENS_ID`,`common_etudiant`.`ET_LIEU` AS `ET_LIEU`,`common_etudiant`.`ET_TUTEUR` AS `ET_TUTEUR`,`common_etudiant`.`ET_MAIL_TUTEUR` AS `ET_MAIL_TUTEUR`,`common_etudiant`.`ET_TEL_TUTEUR` AS `ET_TEL_TUTEUR`,`common_etudiant`.`ET_INFO_LIEU` AS `ET_INFO_LIEU`,`common_etudiant`.`ET_MAX_SEMAINE` AS `ET_MAX_SEMAINE` from ((`common_groupes` join `common_etudiant_groupes`) join `common_etudiant`) where `common_etudiant`.`ET_ID` = `common_etudiant_groupes`.`GROUPE_ET_ID` and `common_etudiant_groupes`.`ET_GROUPE_CODE` like concat(`common_groupes`.`GROUPE_CODE`,'%') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `etudiants_retour`
--

/*!50001 DROP VIEW IF EXISTS `etudiants_retour`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `etudiants_retour` AS select `common_etudiant`.`ET_ID` AS `ET_ID`,`common_formation`.`FORM_ID` AS `FORM_ID`,`common_formation`.`FORM_EVAL_DEBUT` AS `FORM_EVAL_DEBUT`,`common_formation`.`FORM_EVAL_FIN` AS `FORM_EVAL_FIN`,`common_formation`.`FORM_EVAL_PERIODE_ID` AS `FORM_EVAL_PERIODE_ID` from ((((`common_etudiant` join `common_inscription`) join `common_annee`) join `common_semestre`) join `common_formation`) where `common_annee`.`ANNEE_COURANTE` = 1 and `common_annee`.`ANNEE_ID` = `common_inscription`.`INSCRIPT_ANNEE_ID` and `common_etudiant`.`ET_ID` = `common_inscription`.`INSCRIPT_ET_ID` and `common_semestre`.`SEM_ID` = `common_inscription`.`INSCRIPT_SEM_ID` and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and `common_formation`.`FORM_EVALUABLE` = 1 group by `common_etudiant`.`ET_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea15_notes_moyennes_absences`
--

/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_absences`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea15_notes_moyennes_absences` AS select `common_notes`.`NOTES_ET_ID` AS `ET_ID`,`common_matiere`.`MAT_ID` AS `MAT_ID`,`common_matiere`.`MAT_CODE_APOGE` AS `MAT_CODE_APOGE`,`common_controle`.`CONTROLE_ANNEE_ID` AS `ANNEE_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_REMONTEE`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO_ABS` from ((((`common_notes` join `common_controle`) join `common_matiere`) join `common_etudiant`) join `common_annee`) where `common_matiere`.`MAT_ID` = `common_controle`.`CONTROLE_MAT_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_etudiant`.`ET_ID` = `common_notes`.`NOTES_ET_ID` and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_notes`.`NOTES_ET_ID`,`common_matiere`.`MAT_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea15_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea15_notes_moyennes_annee` AS select sum(`gea15_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `gea15_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`gea15_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`gea15_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`gea15_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`gea15_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`gea15_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `gea15_notes_moyennes_semestre` group by `gea15_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`gea15_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea15_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea15_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `gea15_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `gea15_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea15_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea15_notes_moyennes_matiere` AS select `gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`gea15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`gea15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`gea15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`gea15_notes_moyennes_matiere_sans_bonus` left join `gea15_notes_moyennes_matiere_somme_bonus` on(`gea15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `gea15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `gea15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `gea15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `gea15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `gea15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `gea15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea15_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea15_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 6 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea15_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea15_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 6 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea15_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea15_notes_moyennes_semestre` AS select sum(`gea15_notes_moyennes_ue`.`MOYUE_VALEUR` * `gea15_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`gea15_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`gea15_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`gea15_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`gea15_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`gea15_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`gea15_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`gea15_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `gea15_notes_moyennes_ue` group by `gea15_notes_moyennes_ue`.`MOYUE_SEM_ID`,`gea15_notes_moyennes_ue`.`MOYUE_ET_ID`,`gea15_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea15_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea15_notes_moyennes_surmatieres` AS select sum(if(`gea15_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`gea15_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `gea15_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`gea15_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`gea15_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`gea15_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `gea15_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`gea15_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`gea15_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`gea15_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`gea15_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`gea15_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`gea15_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`gea15_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`gea15_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `gea15_notes_moyennes_matiere` where `gea15_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `gea15_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`gea15_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`gea15_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea15_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `gea15_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea15_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `gea15_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `gea15_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea63_notes_moyennes_absences`
--

/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_absences`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea63_notes_moyennes_absences` AS select `common_notes`.`NOTES_ET_ID` AS `ET_ID`,`common_matiere`.`MAT_ID` AS `MAT_ID`,`common_matiere`.`MAT_CODE_APOGE` AS `MAT_CODE_APOGE`,`common_controle`.`CONTROLE_ANNEE_ID` AS `ANNEE_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_REMONTEE`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO_ABS` from ((((`common_notes` join `common_controle`) join `common_matiere`) join `common_etudiant`) join `common_annee`) where `common_matiere`.`MAT_ID` = `common_controle`.`CONTROLE_MAT_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_etudiant`.`ET_ID` = `common_notes`.`NOTES_ET_ID` and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_notes`.`NOTES_ET_ID`,`common_matiere`.`MAT_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea63_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea63_notes_moyennes_annee` AS select sum(`gea63_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `gea63_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`gea63_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`gea63_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`gea63_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`gea63_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`gea63_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `gea63_notes_moyennes_semestre` group by `gea63_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`gea63_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea63_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea63_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `gea63_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `gea63_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea63_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea63_notes_moyennes_matiere` AS select `gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`gea63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`gea63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`gea63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`gea63_notes_moyennes_matiere_sans_bonus` left join `gea63_notes_moyennes_matiere_somme_bonus` on(`gea63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `gea63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `gea63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `gea63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `gea63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `gea63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `gea63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea63_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea63_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 7 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea63_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea63_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 7 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea63_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea63_notes_moyennes_semestre` AS select sum(`gea63_notes_moyennes_ue`.`MOYUE_VALEUR` * `gea63_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`gea63_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`gea63_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`gea63_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`gea63_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`gea63_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`gea63_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`gea63_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `gea63_notes_moyennes_ue` group by `gea63_notes_moyennes_ue`.`MOYUE_SEM_ID`,`gea63_notes_moyennes_ue`.`MOYUE_ET_ID`,`gea63_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea63_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea63_notes_moyennes_surmatieres` AS select sum(if(`gea63_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`gea63_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `gea63_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`gea63_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`gea63_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`gea63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `gea63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`gea63_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`gea63_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`gea63_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`gea63_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`gea63_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`gea63_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`gea63_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`gea63_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `gea63_notes_moyennes_matiere` where `gea63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `gea63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`gea63_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`gea63_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gea63_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `gea63_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gea63_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `gea63_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `gea63_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `geii03_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `geii03_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `geii03_notes_moyennes_annee` AS select sum(`geii03_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `geii03_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`geii03_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`geii03_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`geii03_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`geii03_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`geii03_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `geii03_notes_moyennes_semestre` group by `geii03_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`geii03_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `geii03_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `geii03_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `geii03_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `geii03_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `geii03_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `geii03_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `geii03_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `geii03_notes_moyennes_matiere` AS select `geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`geii03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`geii03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`geii03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`geii03_notes_moyennes_matiere_sans_bonus` left join `geii03_notes_moyennes_matiere_somme_bonus` on(`geii03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `geii03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `geii03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `geii03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `geii03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `geii03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `geii03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `geii03_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `geii03_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `geii03_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 16 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `geii03_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `geii03_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `geii03_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 16 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `geii03_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `geii03_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `geii03_notes_moyennes_semestre` AS select sum(`geii03_notes_moyennes_ue`.`MOYUE_VALEUR` * `geii03_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`geii03_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`geii03_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`geii03_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`geii03_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`geii03_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`geii03_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`geii03_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `geii03_notes_moyennes_ue` group by `geii03_notes_moyennes_ue`.`MOYUE_SEM_ID`,`geii03_notes_moyennes_ue`.`MOYUE_ET_ID`,`geii03_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `geii03_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `geii03_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `geii03_notes_moyennes_surmatieres` AS select sum(if(`geii03_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`geii03_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `geii03_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`geii03_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`geii03_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`geii03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `geii03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`geii03_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`geii03_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`geii03_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`geii03_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`geii03_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`geii03_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`geii03_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`geii03_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `geii03_notes_moyennes_matiere` where `geii03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `geii03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`geii03_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`geii03_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `geii03_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `geii03_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `geii03_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `geii03_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `geii03_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gim63_notes_moyennes_absences`
--

/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_absences`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gim63_notes_moyennes_absences` AS select `common_notes`.`NOTES_ET_ID` AS `ET_ID`,`common_matiere`.`MAT_ID` AS `MAT_ID`,`common_matiere`.`MAT_CODE_APOGE` AS `MAT_CODE_APOGE`,`common_controle`.`CONTROLE_ANNEE_ID` AS `ANNEE_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_REMONTEE`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO_ABS` from ((((`common_notes` join `common_controle`) join `common_matiere`) join `common_etudiant`) join `common_annee`) where `common_matiere`.`MAT_ID` = `common_controle`.`CONTROLE_MAT_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_etudiant`.`ET_ID` = `common_notes`.`NOTES_ET_ID` and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_notes`.`NOTES_ET_ID`,`common_matiere`.`MAT_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gim63_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gim63_notes_moyennes_annee` AS select sum(`gim63_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `gim63_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`gim63_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`gim63_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`gim63_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`gim63_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`gim63_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `gim63_notes_moyennes_semestre` group by `gim63_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`gim63_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gim63_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gim63_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `gim63_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `gim63_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gim63_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gim63_notes_moyennes_matiere` AS select `gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`gim63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`gim63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`gim63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`gim63_notes_moyennes_matiere_sans_bonus` left join `gim63_notes_moyennes_matiere_somme_bonus` on(`gim63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `gim63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `gim63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `gim63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `gim63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `gim63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `gim63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gim63_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gim63_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 3 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gim63_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gim63_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 3 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gim63_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gim63_notes_moyennes_semestre` AS select sum(`gim63_notes_moyennes_ue`.`MOYUE_VALEUR` * `gim63_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`gim63_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`gim63_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`gim63_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`gim63_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`gim63_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`gim63_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`gim63_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `gim63_notes_moyennes_ue` group by `gim63_notes_moyennes_ue`.`MOYUE_SEM_ID`,`gim63_notes_moyennes_ue`.`MOYUE_ET_ID`,`gim63_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gim63_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gim63_notes_moyennes_surmatieres` AS select sum(if(`gim63_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`gim63_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `gim63_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`gim63_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`gim63_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`gim63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `gim63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`gim63_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`gim63_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`gim63_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`gim63_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`gim63_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`gim63_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`gim63_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`gim63_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `gim63_notes_moyennes_matiere` where `gim63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `gim63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`gim63_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`gim63_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gim63_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `gim63_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gim63_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `gim63_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `gim63_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gmp03_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `gmp03_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gmp03_notes_moyennes_annee` AS select sum(`gmp03_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `gmp03_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`gmp03_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`gmp03_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`gmp03_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`gmp03_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`gmp03_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `gmp03_notes_moyennes_semestre` group by `gmp03_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`gmp03_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gmp03_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `gmp03_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gmp03_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `gmp03_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `gmp03_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gmp03_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `gmp03_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gmp03_notes_moyennes_matiere` AS select `gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`gmp03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`gmp03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`gmp03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`gmp03_notes_moyennes_matiere_sans_bonus` left join `gmp03_notes_moyennes_matiere_somme_bonus` on(`gmp03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `gmp03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `gmp03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `gmp03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `gmp03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `gmp03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `gmp03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gmp03_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `gmp03_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gmp03_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 20 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gmp03_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `gmp03_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gmp03_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 20 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gmp03_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `gmp03_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gmp03_notes_moyennes_semestre` AS select sum(`gmp03_notes_moyennes_ue`.`MOYUE_VALEUR` * `gmp03_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`gmp03_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`gmp03_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`gmp03_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`gmp03_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`gmp03_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`gmp03_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`gmp03_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `gmp03_notes_moyennes_ue` group by `gmp03_notes_moyennes_ue`.`MOYUE_SEM_ID`,`gmp03_notes_moyennes_ue`.`MOYUE_ET_ID`,`gmp03_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gmp03_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `gmp03_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gmp03_notes_moyennes_surmatieres` AS select sum(if(`gmp03_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`gmp03_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `gmp03_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`gmp03_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`gmp03_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`gmp03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `gmp03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`gmp03_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`gmp03_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`gmp03_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`gmp03_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`gmp03_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`gmp03_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`gmp03_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`gmp03_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `gmp03_notes_moyennes_matiere` where `gmp03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `gmp03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`gmp03_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`gmp03_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gmp03_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `gmp03_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gmp03_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `gmp03_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `gmp03_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gte03_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `gte03_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gte03_notes_moyennes_annee` AS select sum(`gte03_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `gte03_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`gte03_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`gte03_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`gte03_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`gte03_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`gte03_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `gte03_notes_moyennes_semestre` group by `gte03_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`gte03_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gte03_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `gte03_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gte03_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `gte03_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `gte03_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gte03_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `gte03_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gte03_notes_moyennes_matiere` AS select `gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`gte03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`gte03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`gte03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`gte03_notes_moyennes_matiere_sans_bonus` left join `gte03_notes_moyennes_matiere_somme_bonus` on(`gte03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `gte03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `gte03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `gte03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `gte03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `gte03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `gte03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gte03_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `gte03_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gte03_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 18 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gte03_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `gte03_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gte03_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 18 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gte03_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `gte03_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gte03_notes_moyennes_semestre` AS select sum(`gte03_notes_moyennes_ue`.`MOYUE_VALEUR` * `gte03_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`gte03_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`gte03_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`gte03_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`gte03_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`gte03_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`gte03_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`gte03_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `gte03_notes_moyennes_ue` group by `gte03_notes_moyennes_ue`.`MOYUE_SEM_ID`,`gte03_notes_moyennes_ue`.`MOYUE_ET_ID`,`gte03_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gte03_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `gte03_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gte03_notes_moyennes_surmatieres` AS select sum(if(`gte03_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`gte03_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `gte03_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`gte03_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`gte03_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`gte03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `gte03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`gte03_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`gte03_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`gte03_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`gte03_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`gte03_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`gte03_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`gte03_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`gte03_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `gte03_notes_moyennes_matiere` where `gte03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `gte03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`gte03_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`gte03_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `gte03_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `gte03_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `gte03_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `gte03_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `gte03_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf43_notes_moyennes_absences`
--

/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_absences`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf43_notes_moyennes_absences` AS select `common_notes`.`NOTES_ET_ID` AS `ET_ID`,`common_matiere`.`MAT_ID` AS `MAT_ID`,`common_matiere`.`MAT_CODE_APOGE` AS `MAT_CODE_APOGE`,`common_controle`.`CONTROLE_ANNEE_ID` AS `ANNEE_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_REMONTEE`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO_ABS` from ((((`common_notes` join `common_controle`) join `common_matiere`) join `common_etudiant`) join `common_annee`) where `common_matiere`.`MAT_ID` = `common_controle`.`CONTROLE_MAT_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_etudiant`.`ET_ID` = `common_notes`.`NOTES_ET_ID` and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_notes`.`NOTES_ET_ID`,`common_matiere`.`MAT_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf43_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf43_notes_moyennes_annee` AS select sum(`inf43_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `inf43_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`inf43_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`inf43_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`inf43_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`inf43_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`inf43_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `inf43_notes_moyennes_semestre` group by `inf43_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`inf43_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf43_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf43_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `inf43_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `inf43_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf43_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf43_notes_moyennes_matiere` AS select `inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`inf43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`inf43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`inf43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`inf43_notes_moyennes_matiere_sans_bonus` left join `inf43_notes_moyennes_matiere_somme_bonus` on(`inf43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `inf43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `inf43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `inf43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `inf43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `inf43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `inf43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf43_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf43_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 13 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf43_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf43_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 13 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf43_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf43_notes_moyennes_semestre` AS select sum(`inf43_notes_moyennes_ue`.`MOYUE_VALEUR` * `inf43_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`inf43_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`inf43_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`inf43_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`inf43_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`inf43_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`inf43_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`inf43_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `inf43_notes_moyennes_ue` group by `inf43_notes_moyennes_ue`.`MOYUE_SEM_ID`,`inf43_notes_moyennes_ue`.`MOYUE_ET_ID`,`inf43_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf43_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf43_notes_moyennes_surmatieres` AS select sum(if(`inf43_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`inf43_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `inf43_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`inf43_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`inf43_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`inf43_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `inf43_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`inf43_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`inf43_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`inf43_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`inf43_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`inf43_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`inf43_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`inf43_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`inf43_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `inf43_notes_moyennes_matiere` where `inf43_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `inf43_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`inf43_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`inf43_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf43_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `inf43_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf43_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `inf43_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `inf43_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf63_notes_moyennes_absences`
--

/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_absences`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf63_notes_moyennes_absences` AS select `common_notes`.`NOTES_ET_ID` AS `ET_ID`,`common_matiere`.`MAT_ID` AS `MAT_ID`,`common_matiere`.`MAT_CODE_APOGE` AS `MAT_CODE_APOGE`,`common_controle`.`CONTROLE_ANNEE_ID` AS `ANNEE_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_REMONTEE`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO_ABS` from ((((`common_notes` join `common_controle`) join `common_matiere`) join `common_etudiant`) join `common_annee`) where `common_matiere`.`MAT_ID` = `common_controle`.`CONTROLE_MAT_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_etudiant`.`ET_ID` = `common_notes`.`NOTES_ET_ID` and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_notes`.`NOTES_ET_ID`,`common_matiere`.`MAT_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf63_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf63_notes_moyennes_annee` AS select sum(`inf63_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `inf63_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`inf63_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`inf63_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`inf63_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`inf63_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`inf63_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `inf63_notes_moyennes_semestre` group by `inf63_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`inf63_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf63_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf63_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `inf63_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `inf63_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf63_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf63_notes_moyennes_matiere` AS select `inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`inf63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`inf63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`inf63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`inf63_notes_moyennes_matiere_sans_bonus` left join `inf63_notes_moyennes_matiere_somme_bonus` on(`inf63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `inf63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `inf63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `inf63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `inf63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `inf63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `inf63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf63_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf63_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 1 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf63_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf63_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 1 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf63_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf63_notes_moyennes_semestre` AS select sum(`inf63_notes_moyennes_ue`.`MOYUE_VALEUR` * `inf63_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`inf63_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`inf63_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`inf63_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`inf63_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`inf63_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`inf63_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`inf63_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `inf63_notes_moyennes_ue` group by `inf63_notes_moyennes_ue`.`MOYUE_SEM_ID`,`inf63_notes_moyennes_ue`.`MOYUE_ET_ID`,`inf63_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf63_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf63_notes_moyennes_surmatieres` AS select sum(if(`inf63_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`inf63_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `inf63_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`inf63_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`inf63_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`inf63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `inf63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`inf63_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`inf63_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`inf63_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`inf63_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`inf63_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`inf63_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`inf63_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`inf63_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `inf63_notes_moyennes_matiere` where `inf63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `inf63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`inf63_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`inf63_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `inf63_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `inf63_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `inf63_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `inf63_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `inf63_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `jury_access_enseignants`
--

/*!50001 DROP VIEW IF EXISTS `jury_access_enseignants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `jury_access_enseignants` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_enseignant`.`ENS_ID` AS `ENS_ID`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`common_access_jury`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_departement`.`DEPT_CODE` AS `DEPT_CODE` from ((`common_access_jury` join `common_enseignant`) join `common_departement`) where `common_enseignant`.`ENS_ID` = `common_access_jury`.`ACCESS_ENSEIGNANT_ID` and `common_departement`.`DEPT_ID` = `common_access_jury`.`ACCESS_DEPT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `m23dia43_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `m23dia43_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `m23dia43_notes_moyennes_annee` AS select sum(`m23dia43_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `m23dia43_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`m23dia43_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`m23dia43_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`m23dia43_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`m23dia43_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`m23dia43_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `m23dia43_notes_moyennes_semestre` group by `m23dia43_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`m23dia43_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `m23dia43_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `m23dia43_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `m23dia43_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `m23dia43_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `m23dia43_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `m23dia43_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `m23dia43_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `m23dia43_notes_moyennes_matiere` AS select `m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`m23dia43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`m23dia43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`m23dia43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`m23dia43_notes_moyennes_matiere_sans_bonus` left join `m23dia43_notes_moyennes_matiere_somme_bonus` on(`m23dia43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `m23dia43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `m23dia43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `m23dia43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `m23dia43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `m23dia43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `m23dia43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `m23dia43_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `m23dia43_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `m23dia43_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 14 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `m23dia43_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `m23dia43_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `m23dia43_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 14 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `m23dia43_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `m23dia43_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `m23dia43_notes_moyennes_semestre` AS select sum(`m23dia43_notes_moyennes_ue`.`MOYUE_VALEUR` * `m23dia43_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`m23dia43_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`m23dia43_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`m23dia43_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`m23dia43_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`m23dia43_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`m23dia43_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`m23dia43_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `m23dia43_notes_moyennes_ue` group by `m23dia43_notes_moyennes_ue`.`MOYUE_SEM_ID`,`m23dia43_notes_moyennes_ue`.`MOYUE_ET_ID`,`m23dia43_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `m23dia43_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `m23dia43_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `m23dia43_notes_moyennes_surmatieres` AS select sum(if(`m23dia43_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`m23dia43_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `m23dia43_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`m23dia43_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`m23dia43_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`m23dia43_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `m23dia43_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`m23dia43_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`m23dia43_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`m23dia43_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`m23dia43_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`m23dia43_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`m23dia43_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`m23dia43_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`m23dia43_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `m23dia43_notes_moyennes_matiere` where `m23dia43_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `m23dia43_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`m23dia43_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`m23dia43_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `m23dia43_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `m23dia43_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `m23dia43_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `m23dia43_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `m23dia43_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mediateur_access_enseignants`
--

/*!50001 DROP VIEW IF EXISTS `mediateur_access_enseignants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mediateur_access_enseignants` AS select distinct `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_enseignant`.`ENS_ID` AS `ENS_ID`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`common_access_mediateur`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_departement`.`DEPT_CODE` AS `DEPT_CODE` from ((`common_access_mediateur` join `common_enseignant`) join `common_departement`) where `common_enseignant`.`ENS_ID` = `common_access_mediateur`.`ACCESS_ENSEIGNANT_ID` and `common_departement`.`DEPT_ID` = `common_access_mediateur`.`ACCESS_DEPT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mmi03_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `mmi03_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mmi03_notes_moyennes_annee` AS select sum(`mmi03_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `mmi03_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`mmi03_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`mmi03_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`mmi03_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`mmi03_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`mmi03_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `mmi03_notes_moyennes_semestre` group by `mmi03_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`mmi03_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mmi03_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `mmi03_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mmi03_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `mmi03_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `mmi03_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mmi03_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `mmi03_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mmi03_notes_moyennes_matiere` AS select `mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`mmi03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`mmi03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`mmi03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`mmi03_notes_moyennes_matiere_sans_bonus` left join `mmi03_notes_moyennes_matiere_somme_bonus` on(`mmi03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `mmi03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `mmi03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `mmi03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `mmi03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `mmi03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `mmi03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mmi03_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `mmi03_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mmi03_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 19 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mmi03_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `mmi03_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mmi03_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 19 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mmi03_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `mmi03_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mmi03_notes_moyennes_semestre` AS select sum(`mmi03_notes_moyennes_ue`.`MOYUE_VALEUR` * `mmi03_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`mmi03_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`mmi03_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`mmi03_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`mmi03_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`mmi03_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`mmi03_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`mmi03_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `mmi03_notes_moyennes_ue` group by `mmi03_notes_moyennes_ue`.`MOYUE_SEM_ID`,`mmi03_notes_moyennes_ue`.`MOYUE_ET_ID`,`mmi03_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mmi03_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `mmi03_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mmi03_notes_moyennes_surmatieres` AS select sum(if(`mmi03_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`mmi03_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `mmi03_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`mmi03_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`mmi03_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`mmi03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `mmi03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`mmi03_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`mmi03_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`mmi03_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`mmi03_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`mmi03_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`mmi03_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`mmi03_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`mmi03_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `mmi03_notes_moyennes_matiere` where `mmi03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `mmi03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`mmi03_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`mmi03_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mmi03_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `mmi03_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mmi03_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `mmi03_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `mmi03_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mmi43_notes_moyennes_absences`
--

/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_absences`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mmi43_notes_moyennes_absences` AS select `common_notes`.`NOTES_ET_ID` AS `ET_ID`,`common_matiere`.`MAT_ID` AS `MAT_ID`,`common_matiere`.`MAT_CODE_APOGE` AS `MAT_CODE_APOGE`,`common_controle`.`CONTROLE_ANNEE_ID` AS `ANNEE_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_REMONTEE`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO_ABS` from ((((`common_notes` join `common_controle`) join `common_matiere`) join `common_etudiant`) join `common_annee`) where `common_matiere`.`MAT_ID` = `common_controle`.`CONTROLE_MAT_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_etudiant`.`ET_ID` = `common_notes`.`NOTES_ET_ID` and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_notes`.`NOTES_ET_ID`,`common_matiere`.`MAT_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mmi43_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mmi43_notes_moyennes_annee` AS select sum(`mmi43_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `mmi43_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`mmi43_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`mmi43_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`mmi43_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`mmi43_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`mmi43_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `mmi43_notes_moyennes_semestre` group by `mmi43_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`mmi43_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mmi43_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mmi43_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `mmi43_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `mmi43_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mmi43_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mmi43_notes_moyennes_matiere` AS select `mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`mmi43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`mmi43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`mmi43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`mmi43_notes_moyennes_matiere_sans_bonus` left join `mmi43_notes_moyennes_matiere_somme_bonus` on(`mmi43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `mmi43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `mmi43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `mmi43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `mmi43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `mmi43_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `mmi43_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mmi43_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mmi43_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 12 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mmi43_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mmi43_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 12 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mmi43_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mmi43_notes_moyennes_semestre` AS select sum(`mmi43_notes_moyennes_ue`.`MOYUE_VALEUR` * `mmi43_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`mmi43_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`mmi43_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`mmi43_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`mmi43_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`mmi43_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`mmi43_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`mmi43_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `mmi43_notes_moyennes_ue` group by `mmi43_notes_moyennes_ue`.`MOYUE_SEM_ID`,`mmi43_notes_moyennes_ue`.`MOYUE_ET_ID`,`mmi43_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mmi43_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mmi43_notes_moyennes_surmatieres` AS select sum(if(`mmi43_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`mmi43_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `mmi43_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`mmi43_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`mmi43_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`mmi43_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `mmi43_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`mmi43_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`mmi43_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`mmi43_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`mmi43_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`mmi43_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`mmi43_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`mmi43_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`mmi43_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `mmi43_notes_moyennes_matiere` where `mmi43_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `mmi43_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`mmi43_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`mmi43_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mmi43_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `mmi43_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mmi43_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `mmi43_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `mmi43_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mp63_notes_moyennes_absences`
--

/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_absences`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mp63_notes_moyennes_absences` AS select `common_notes`.`NOTES_ET_ID` AS `ET_ID`,`common_matiere`.`MAT_ID` AS `MAT_ID`,`common_matiere`.`MAT_CODE_APOGE` AS `MAT_CODE_APOGE`,`common_controle`.`CONTROLE_ANNEE_ID` AS `ANNEE_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_REMONTEE`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO_ABS` from ((((`common_notes` join `common_controle`) join `common_matiere`) join `common_etudiant`) join `common_annee`) where `common_matiere`.`MAT_ID` = `common_controle`.`CONTROLE_MAT_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_etudiant`.`ET_ID` = `common_notes`.`NOTES_ET_ID` and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_notes`.`NOTES_ET_ID`,`common_matiere`.`MAT_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mp63_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mp63_notes_moyennes_annee` AS select sum(`mp63_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `mp63_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`mp63_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`mp63_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`mp63_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`mp63_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`mp63_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `mp63_notes_moyennes_semestre` group by `mp63_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`mp63_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mp63_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mp63_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `mp63_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `mp63_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mp63_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mp63_notes_moyennes_matiere` AS select `mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`mp63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`mp63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`mp63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`mp63_notes_moyennes_matiere_sans_bonus` left join `mp63_notes_moyennes_matiere_somme_bonus` on(`mp63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `mp63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `mp63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `mp63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `mp63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `mp63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `mp63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mp63_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mp63_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 2 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mp63_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mp63_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 2 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mp63_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mp63_notes_moyennes_semestre` AS select sum(`mp63_notes_moyennes_ue`.`MOYUE_VALEUR` * `mp63_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`mp63_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`mp63_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`mp63_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`mp63_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`mp63_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`mp63_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`mp63_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `mp63_notes_moyennes_ue` group by `mp63_notes_moyennes_ue`.`MOYUE_SEM_ID`,`mp63_notes_moyennes_ue`.`MOYUE_ET_ID`,`mp63_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mp63_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mp63_notes_moyennes_surmatieres` AS select sum(if(`mp63_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`mp63_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `mp63_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`mp63_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`mp63_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`mp63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `mp63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`mp63_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`mp63_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`mp63_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`mp63_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`mp63_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`mp63_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`mp63_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`mp63_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `mp63_notes_moyennes_matiere` where `mp63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `mp63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`mp63_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`mp63_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `mp63_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `mp63_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mp63_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `mp63_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `mp63_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `notes_absences`
--

/*!50001 DROP VIEW IF EXISTS `notes_absences`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `notes_absences` AS select `common_absences_v2`.`ABS_ID` AS `ABS_ID`,`common_absences_v2`.`ABS_ENS_ID` AS `ABS_ENS_ID`,`common_absences_v2`.`ABS_ET_ID` AS `ABS_ET_ID`,`common_absences_v2`.`ABS_CRENEAU_ID` AS `ABS_CRENEAU_ID`,`common_absences_v2`.`ABS_MAT_ID` AS `ABS_MAT_ID`,`common_absences_v2`.`ABS_DATE` AS `ABS_DATE`,`common_absences_v2`.`ABS_JUSTIFICATION` AS `ABS_JUSTIFICATION`,`common_absences_v2`.`ABS_EXCUSE` AS `ABS_EXCUSE`,`common_absences_v2`.`ABS_MAIL` AS `ABS_MAIL`,`common_matiere`.`MAT_ID` AS `COURS_ID`,`common_matiere`.`MAT_NOM` AS `COURS_NOM`,`common_absences_v2`.`ABS_ENS_ID` AS `COURS_ENS_ID`,`common_absences_creneau`.`CRENEAU_ID` AS `CRENEAU_ID`,`common_absences_creneau`.`CRENEAU_NOM` AS `CRENEAU_NOM`,`common_absences_creneau`.`CRENEAU_DEMI` AS `CRENEAU_DEMI`,`common_absences_v2`.`ABS_EXPIRE` AS `ABS_EXPIRE` from ((`common_absences_v2` join `common_matiere`) join `common_absences_creneau`) where `common_matiere`.`MAT_ID` = `common_absences_v2`.`ABS_MAT_ID` and `common_absences_creneau`.`CRENEAU_ID` = `common_absences_v2`.`ABS_CRENEAU_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `notes_access_enseignants`
--

/*!50001 DROP VIEW IF EXISTS `notes_access_enseignants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `notes_access_enseignants` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_enseignant`.`ENS_ID` AS `ENS_ID`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`common_access_notes`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_departement`.`DEPT_CODE` AS `DEPT_CODE` from (((`common_access_notes` join `common_enseignants_departement`) join `common_enseignant`) join `common_departement`) where `common_enseignant`.`ENS_ID` = `common_access_notes`.`ACCESS_ENSEIGNANT_ID` and `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 and `common_enseignants_departement`.`ENS_DEPT_ID` = `common_access_notes`.`ACCESS_DEPT_ID` and `common_departement`.`DEPT_ID` = `common_enseignants_departement`.`ENS_DEPT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `notes_export`
--

/*!50001 DROP VIEW IF EXISTS `notes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `notes_export` AS select `common_matiere`.`MAT_ID` AS `MAT_ID`,`common_matiere`.`MAT_NOM` AS `MAT_NOM`,`common_matiere`.`MAT_UE_ID` AS `MAT_UE_ID`,`common_matiere`.`MAT_CODE_APOGE` AS `MAT_CODE_APOGE`,`common_matiere`.`MAT_COEF` AS `MAT_COEF`,`common_matiere`.`MAT_SURMAT_ID` AS `MAT_SURMAT_ID`,`common_matiere`.`MAT_HAS_NOTE` AS `MAT_HAS_NOTE`,`common_matiere`.`MAT_LOCK_ANNEE_ID` AS `MAT_LOCK_ANNEE_ID`,`common_matiere`.`MAT_START_ANNEE_ID` AS `MAT_START_ANNEE_ID`,`common_matiere`.`MAT_END_ANNEE_ID` AS `MAT_END_ANNEE_ID`,`common_matiere`.`MAT_COPIE_MAT_ID` AS `MAT_COPIE_MAT_ID`,`common_ue`.`UE_ID` AS `UE_ID`,`common_ue`.`UE_NOM` AS `UE_NOM`,`common_ue`.`UE_SEM_ID` AS `UE_SEM_ID`,`common_ue`.`UE_COEF` AS `UE_COEF`,`common_ue`.`UE_START_ANNEE_ID` AS `UE_START_ANNEE_ID`,`common_ue`.`UE_END_ANNEE_ID` AS `UE_END_ANNEE_ID`,`common_semestre`.`SEM_ID` AS `SEM_ID`,`common_semestre`.`SEM_NOM` AS `SEM_NOM`,`common_semestre`.`SEM_FORM_ID` AS `SEM_FORM_ID`,`common_semestre`.`SEM_COEF` AS `SEM_COEF`,`common_semestre`.`SEM_START_ANNEE_ID` AS `SEM_START_ANNEE_ID`,`common_semestre`.`SEM_END_ANNEE_ID` AS `SEM_END_ANNEE_ID`,`common_formation`.`FORM_ID` AS `FORM_ID`,`common_formation`.`FORM_NOM` AS `FORM_NOM`,`common_formation`.`FORM_DEPT_ID` AS `FORM_DEPT_ID`,`common_formation`.`FORM_PRO` AS `FORM_PRO`,`common_formation`.`FORM_EVALUABLE` AS `FORM_EVALUABLE`,`common_formation`.`FORM_EVAL_DEBUT` AS `FORM_EVAL_DEBUT`,`common_formation`.`FORM_EVAL_FIN` AS `FORM_EVAL_FIN`,`common_formation`.`FORM_EVAL_PERIODE_ID` AS `FORM_EVAL_PERIODE_ID`,`common_formation`.`FORM_CODE_TROMBI` AS `FORM_CODE_TROMBI`,`common_formation`.`FORM_CODE_APOGEE` AS `FORM_CODE_APOGEE`,`common_formation`.`FORM_JURY_DEBUT` AS `FORM_JURY_DEBUT`,`common_formation`.`FORM_JURY_FIN` AS `FORM_JURY_FIN` from (((`common_matiere` join `common_ue`) join `common_semestre`) join `common_formation`) where `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `perso_access_enseignants`
--

/*!50001 DROP VIEW IF EXISTS `perso_access_enseignants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `perso_access_enseignants` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_perso`.`ACCESS_ENSEIGNANT_ID` AS `ENS_ID`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`common_enseignant`.`ENS_MAIL` AS `ENS_MAIL`,`common_access_perso`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_departement`.`DEPT_CODE` AS `DEPT_CODE` from ((`common_access_perso` join `common_enseignant`) join `common_departement`) where `common_departement`.`DEPT_ID` = `common_access_perso`.`ACCESS_DEPT_ID` and `common_enseignant`.`ENS_ID` = `common_access_perso`.`ACCESS_ENSEIGNANT_ID` group by `common_access_perso`.`ACCESS_DEPT_ID`,`common_access_perso`.`ACCESS_ENSEIGNANT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `planning_access_enseignants`
--

/*!50001 DROP VIEW IF EXISTS `planning_access_enseignants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `planning_access_enseignants` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_planning`.`ACCESS_ENSEIGNANT_ID` AS `ENS_ID`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`common_enseignant`.`ENS_MAIL` AS `ENS_MAIL`,`common_access_planning`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_departement`.`DEPT_CODE` AS `DEPT_CODE` from ((`common_access_planning` join `common_enseignant`) join `common_departement`) where `common_departement`.`DEPT_ID` = `common_access_planning`.`ACCESS_DEPT_ID` and `common_enseignant`.`ENS_ID` = `common_access_planning`.`ACCESS_ENSEIGNANT_ID` group by `common_access_planning`.`ACCESS_DEPT_ID`,`common_access_planning`.`ACCESS_ENSEIGNANT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `portail_access_enseignants`
--

/*!50001 DROP VIEW IF EXISTS `portail_access_enseignants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `portail_access_enseignants` AS select distinct `common_access_admin`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_admin`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_admin`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_admin`.`ACCESS_ENSEIGNANT_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_access_admin`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID` from `common_access_admin` union select distinct `common_access_notes`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_notes`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_notes`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_notes`.`ACCESS_ENSEIGNANT_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_access_notes`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID` from `common_access_notes` union select `common_access_absences`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_absences`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_absences`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_absences`.`ACCESS_ENSEIGNANT_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_access_absences`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID` from `common_access_absences` union select distinct `common_access_promotion`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_promotion`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_promotion`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_promotion`.`ACCESS_ENSEIGNANT_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_access_promotion`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID` from `common_access_promotion` union select distinct `common_access_edt`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_edt`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_edt`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_edt`.`ACCESS_ENSEIGNANT_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_access_edt`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID` from `common_access_edt` union select distinct `common_access_emprunt`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_emprunt`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_emprunt`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_emprunt`.`ACCESS_ENSEIGNANT_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_access_emprunt`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID` from `common_access_emprunt` union select distinct `common_access_odin_professionnalisation_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_odin_professionnalisation_enseignant`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_odin_professionnalisation_enseignant`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_odin_professionnalisation_enseignant`.`ACCESS_ENSEIGNANT_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_access_odin_professionnalisation_enseignant`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID` from `common_access_odin_professionnalisation_enseignant` union select distinct `common_access_retour`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_retour`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_retour`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_retour`.`ACCESS_ENSEIGNANT_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_access_retour`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID` from `common_access_retour` union select `common_access_poursuites`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_poursuites`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_poursuites`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_poursuites`.`ACCESS_ENSEIGNANT_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_access_poursuites`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID` from `common_access_poursuites` union select `common_access_jury`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_jury`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_jury`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_jury`.`ACCESS_ENSEIGNANT_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_access_jury`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID` from `common_access_jury` union select distinct `common_access_mediateur`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_mediateur`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_mediateur`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_mediateur`.`ACCESS_ENSEIGNANT_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_access_mediateur`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID` from `common_access_mediateur` union select distinct `common_access_perso`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_perso`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_perso`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_perso`.`ACCESS_ENSEIGNANT_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_access_perso`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID` from `common_access_perso` union select distinct `common_access_stage`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_stage`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_stage`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_stage`.`ACCESS_ENSEIGNANT_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_access_stage`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID` from `common_access_stage` union select distinct `common_access_soutenances`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_soutenances`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_soutenances`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_soutenances`.`ACCESS_ENSEIGNANT_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_access_soutenances`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID` from `common_access_soutenances` union select distinct `common_access_direction`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_direction`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_direction`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_direction`.`ACCESS_ENSEIGNANT_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_access_direction`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID` from `common_access_direction` union select distinct `common_access_planning`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_planning`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_planning`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_planning`.`ACCESS_ENSEIGNANT_ID` AS `ACCESS_ENSEIGNANT_ID`,`common_access_planning`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID` from `common_access_planning` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `portail_access_etudiants`
--

/*!50001 DROP VIEW IF EXISTS `portail_access_etudiants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `portail_access_etudiants` AS select `common_access_etudiants`.`ET_LOGIN` AS `ET_LOGIN`,`common_access_etudiants`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_etudiants`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_etudiants`.`ET_ID` AS `ET_ID`,`common_access_etudiants`.`ET_NOM` AS `ET_NOM` from `common_access_etudiants` group by `common_access_etudiants`.`ACCESS_NOM`,`common_access_etudiants`.`ET_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `poursuites_absences`
--

/*!50001 DROP VIEW IF EXISTS `poursuites_absences`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `poursuites_absences` AS select `common_absences`.`ABS_ID` AS `ABS_ID`,`common_absences`.`ABS_ENS_ID` AS `ABS_ENS_ID`,`common_absences`.`ABS_ET_ID` AS `ABS_ET_ID`,`common_absences`.`ABS_CRENEAU_ID` AS `ABS_CRENEAU_ID`,`common_absences`.`ABS_COURS_ID` AS `ABS_COURS_ID`,`common_absences`.`ABS_DATE` AS `ABS_DATE`,`common_absences`.`ABS_JUSTIFICATION` AS `ABS_JUSTIFICATION`,`common_absences`.`ABS_EXCUSE` AS `ABS_EXCUSE`,`common_absences`.`ABS_MAIL` AS `ABS_MAIL`,`common_absences_cours`.`COURS_ID` AS `COURS_ID`,`common_absences_cours`.`COURS_NOM` AS `COURS_NOM`,`common_absences_cours`.`COURS_ENS_ID` AS `COURS_ENS_ID`,`common_absences_creneau`.`CRENEAU_DEMI` AS `CRENEAU_DEMI`,`common_absences`.`ABS_EXPIRE` AS `ABS_EXPIRE`,`common_absences`.`ABS_REAL_DATE` AS `ABS_REAL_DATE` from ((`common_absences` join `common_absences_cours`) join `common_absences_creneau`) where `common_absences_cours`.`COURS_ID` = `common_absences`.`ABS_COURS_ID` and `common_absences_creneau`.`CRENEAU_ID` = `common_absences`.`ABS_CRENEAU_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `poursuites_absences_v2`
--

/*!50001 DROP VIEW IF EXISTS `poursuites_absences_v2`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `poursuites_absences_v2` AS select `common_absences_v2`.`ABS_ID` AS `ABS_ID`,`common_absences_v2`.`ABS_ENS_ID` AS `ABS_ENS_ID`,`common_absences_v2`.`ABS_ET_ID` AS `ABS_ET_ID`,`common_absences_v2`.`ABS_CRENEAU_ID` AS `ABS_CRENEAU_ID`,`common_absences_v2`.`ABS_MAT_ID` AS `ABS_MAT_ID`,`common_absences_v2`.`ABS_DATE` AS `ABS_DATE`,`common_absences_v2`.`ABS_JUSTIFICATION` AS `ABS_JUSTIFICATION`,`common_absences_v2`.`ABS_EXCUSE` AS `ABS_EXCUSE`,`common_absences_v2`.`ABS_MAIL` AS `ABS_MAIL`,`common_absences_v2`.`ABS_REAL_DATE` AS `ABS_REAL_DATE`,`common_absences_v2`.`ABS_EXPIRE` AS `ABS_EXPIRE`,`common_absences_v2`.`ABS_ANNEE_ID` AS `ABS_ANNEE_ID`,`common_absences_creneau`.`CRENEAU_ID` AS `CRENEAU_ID`,`common_absences_creneau`.`CRENEAU_NOM` AS `CRENEAU_NOM`,`common_absences_creneau`.`CRENEAU_DEMI` AS `CRENEAU_DEMI`,`common_absences_creneau`.`CRENEAU_REAL_START` AS `CRENEAU_REAL_START`,`common_absences_creneau`.`CRENEAU_REAL_END` AS `CRENEAU_REAL_END`,`common_absences_creneau`.`CRENEAU_DEPT_ID` AS `CRENEAU_DEPT_ID`,`common_absences_creneau`.`CRENEAU_CLASSIQUE` AS `CRENEAU_CLASSIQUE`,`common_matiere`.`MAT_ID` AS `MAT_ID`,`common_matiere`.`MAT_NOM` AS `MAT_NOM`,`common_matiere`.`MAT_UE_ID` AS `MAT_UE_ID`,`common_matiere`.`MAT_CODE_APOGE` AS `MAT_CODE_APOGE`,`common_matiere`.`MAT_COEF` AS `MAT_COEF`,`common_matiere`.`MAT_SURMAT_ID` AS `MAT_SURMAT_ID`,`common_matiere`.`MAT_HAS_NOTE` AS `MAT_HAS_NOTE`,`common_matiere`.`MAT_LOCK_ANNEE_ID` AS `MAT_LOCK_ANNEE_ID` from ((`common_absences_v2` join `common_absences_creneau`) join `common_matiere`) where `common_absences_creneau`.`CRENEAU_ID` = `common_absences_v2`.`ABS_CRENEAU_ID` and `common_matiere`.`MAT_ID` = `common_absences_v2`.`ABS_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `poursuites_access_enseignants`
--

/*!50001 DROP VIEW IF EXISTS `poursuites_access_enseignants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `poursuites_access_enseignants` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_enseignant`.`ENS_ID` AS `ENS_ID`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`common_enseignant`.`ENS_MAIL` AS `ENS_MAIL`,`common_access_poursuites`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_departement`.`DEPT_CODE` AS `DEPT_CODE` from (((`common_access_poursuites` join `common_enseignants_departement`) join `common_enseignant`) join `common_departement`) where `common_enseignant`.`ENS_ID` = `common_access_poursuites`.`ACCESS_ENSEIGNANT_ID` and `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 and `common_enseignants_departement`.`ENS_DEPT_ID` = `common_access_poursuites`.`ACCESS_DEPT_ID` and `common_departement`.`DEPT_ID` = `common_enseignants_departement`.`ENS_DEPT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `poursuites_pmatieres`
--

/*!50001 DROP VIEW IF EXISTS `poursuites_pmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `poursuites_pmatieres` AS select `common_poursuite_matiere`.`PMAT_ID` AS `PMAT_ID`,`common_poursuite_matiere`.`PMAT_NOM` AS `PMAT_NOM`,`common_poursuite_matiere`.`PMAT_ENS_ID` AS `PMAT_ENS_ID`,`common_poursuite_matiere_composition`.`MAT_PMAT_ID` AS `MAT_PMAT_ID`,`common_poursuite_matiere_composition`.`PMAT_MAT_ID` AS `PMAT_MAT_ID`,`common_enseignants_matieres`.`ID` AS `ID`,`common_enseignants_matieres`.`ENS_MAT_ID` AS `ENS_MAT_ID`,`common_enseignants_matieres`.`MAT_ENS_ID` AS `MAT_ENS_ID`,`common_enseignants_matieres`.`ENS_MAT_ANNEE_ID` AS `ENS_MAT_ANNEE_ID`,`common_enseignants_matieres`.`ENS_MAT_NOTEUR` AS `ENS_MAT_NOTEUR`,`common_enseignants_matieres`.`ENS_MAT_EVALUABLE` AS `ENS_MAT_EVALUABLE`,`common_enseignants_matieres`.`ENS_MAT_EVAL_DATE_DEBUT` AS `ENS_MAT_EVAL_DATE_DEBUT`,`common_enseignants_matieres`.`ENS_MAT_EVAL_DATE_FIN` AS `ENS_MAT_EVAL_DATE_FIN`,`common_enseignants_matieres`.`ENS_MAT_POURSUITE` AS `ENS_MAT_POURSUITE`,`common_enseignant`.`ENS_ID` AS `ENS_ID`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_enseignant`.`ENS_MAIL` AS `ENS_MAIL`,`common_enseignant`.`ENS_PRETEUR` AS `ENS_PRETEUR`,`common_enseignant`.`ENS_ADE` AS `ENS_ADE`,`common_enseignant`.`ENS_EDT` AS `ENS_EDT`,`common_enseignant`.`ENS_EDT_HEBDO` AS `ENS_EDT_HEBDO`,`common_enseignant`.`ENS_GESTIONNAIRE_ADE` AS `ENS_GESTIONNAIRE_ADE`,`common_annee`.`ANNEE_ID` AS `ANNEE_ID`,`common_annee`.`ANNEE_NOM` AS `ANNEE_NOM`,`common_annee`.`ANNEE_COURANTE` AS `ANNEE_COURANTE`,`common_annee`.`ANNEE_CLOSE` AS `ANNEE_CLOSE` from ((((`common_poursuite_matiere` join `common_poursuite_matiere_composition`) join `common_enseignants_matieres`) join `common_enseignant`) join `common_annee`) where `common_enseignant`.`ENS_ID` = `common_enseignants_matieres`.`MAT_ENS_ID` and `common_poursuite_matiere_composition`.`PMAT_MAT_ID` = `common_enseignants_matieres`.`ENS_MAT_ID` and `common_poursuite_matiere`.`PMAT_ID` = `common_poursuite_matiere_composition`.`MAT_PMAT_ID` and `common_annee`.`ANNEE_COURANTE` = 1 and `common_annee`.`ANNEE_ID` = `common_enseignants_matieres`.`ENS_MAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `pro_access_enseignants`
--

/*!50001 DROP VIEW IF EXISTS `pro_access_enseignants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `pro_access_enseignants` AS select `common_access_odin_professionnalisation_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_odin_professionnalisation_enseignant`.`ACCESS_ENSEIGNANT_ID` AS `ENS_ID`,`common_access_odin_professionnalisation_enseignant`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_departement`.`DEPT_CODE` AS `DEPT_CODE`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`common_enseignant`.`ENS_MAIL` AS `ENS_MAIL` from (((`common_access_odin_professionnalisation_enseignant` join `common_departement`) join `common_enseignant`) join `common_enseignants_departement`) where `common_enseignant`.`ENS_ID` = `common_enseignants_departement`.`DEPT_ENS_ID` and `common_departement`.`DEPT_ID` = `common_enseignants_departement`.`ENS_DEPT_ID` and `common_departement`.`DEPT_ID` = `common_access_odin_professionnalisation_enseignant`.`ACCESS_DEPT_ID` and `common_enseignant`.`ENS_ID` = `common_access_odin_professionnalisation_enseignant`.`ACCESS_ENSEIGNANT_ID` and `common_enseignants_departement`.`ENS_DEPT_CURRENT` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `pro_access_etudiants`
--

/*!50001 DROP VIEW IF EXISTS `pro_access_etudiants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `pro_access_etudiants` AS select `common_access_odin_professionnalisation_etudiants`.`ET_LOGIN` AS `ET_LOGIN`,`common_access_odin_professionnalisation_etudiants`.`ACCESS_NOM` AS `ACCESS_NOM`,`common_access_odin_professionnalisation_etudiants`.`ACCESS_ADRESS` AS `ACCESS_ADRESS`,`common_access_odin_professionnalisation_etudiants`.`ET_ID` AS `ET_ID`,`common_access_odin_professionnalisation_etudiants`.`ET_NOM` AS `ET_NOM`,`common_access_odin_professionnalisation_etudiants`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_access_odin_professionnalisation_etudiants`.`DEPT_CODE` AS `DEPT_CODE` from `common_access_odin_professionnalisation_etudiants` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `promotion_access_enseignants`
--

/*!50001 DROP VIEW IF EXISTS `promotion_access_enseignants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `promotion_access_enseignants` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_promotion`.`ACCESS_ENSEIGNANT_ID` AS `ENS_ID`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`common_enseignant`.`ENS_MAIL` AS `ENS_MAIL`,`common_access_promotion`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_departement`.`DEPT_CODE` AS `DEPT_CODE` from ((`common_access_promotion` join `common_enseignant`) join `common_departement`) where `common_departement`.`DEPT_ID` = `common_access_promotion`.`ACCESS_DEPT_ID` and `common_enseignant`.`ENS_ID` = `common_access_promotion`.`ACCESS_ENSEIGNANT_ID` group by `common_access_promotion`.`ACCESS_DEPT_ID`,`common_access_promotion`.`ACCESS_ENSEIGNANT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `retour_access_enseignants`
--

/*!50001 DROP VIEW IF EXISTS `retour_access_enseignants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `retour_access_enseignants` AS select `common_access_retour`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_retour`.`ACCESS_ENSEIGNANT_ID` AS `ENS_ID`,`common_access_retour`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_departement`.`DEPT_CODE` AS `DEPT_CODE`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM` from ((`common_access_retour` join `common_departement`) join `common_enseignant`) where `common_departement`.`DEPT_ID` = `common_access_retour`.`ACCESS_DEPT_ID` and `common_enseignant`.`ENS_ID` = `common_access_retour`.`ACCESS_ENSEIGNANT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rt63_notes_moyennes_absences`
--

/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_absences`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `rt63_notes_moyennes_absences` AS select `common_notes`.`NOTES_ET_ID` AS `ET_ID`,`common_matiere`.`MAT_ID` AS `MAT_ID`,`common_matiere`.`MAT_CODE_APOGE` AS `MAT_CODE_APOGE`,`common_controle`.`CONTROLE_ANNEE_ID` AS `ANNEE_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_REMONTEE`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO_ABS` from ((((`common_notes` join `common_controle`) join `common_matiere`) join `common_etudiant`) join `common_annee`) where `common_matiere`.`MAT_ID` = `common_controle`.`CONTROLE_MAT_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_etudiant`.`ET_ID` = `common_notes`.`NOTES_ET_ID` and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_notes`.`NOTES_ET_ID`,`common_matiere`.`MAT_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rt63_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `rt63_notes_moyennes_annee` AS select sum(`rt63_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `rt63_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`rt63_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`rt63_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`rt63_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`rt63_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`rt63_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `rt63_notes_moyennes_semestre` group by `rt63_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`rt63_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rt63_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `rt63_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `rt63_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `rt63_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rt63_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `rt63_notes_moyennes_matiere` AS select `rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`rt63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`rt63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`rt63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`rt63_notes_moyennes_matiere_sans_bonus` left join `rt63_notes_moyennes_matiere_somme_bonus` on(`rt63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `rt63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `rt63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `rt63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `rt63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `rt63_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `rt63_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rt63_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `rt63_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 4 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rt63_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `rt63_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 4 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rt63_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `rt63_notes_moyennes_semestre` AS select sum(`rt63_notes_moyennes_ue`.`MOYUE_VALEUR` * `rt63_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`rt63_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`rt63_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`rt63_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`rt63_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`rt63_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`rt63_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`rt63_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `rt63_notes_moyennes_ue` group by `rt63_notes_moyennes_ue`.`MOYUE_SEM_ID`,`rt63_notes_moyennes_ue`.`MOYUE_ET_ID`,`rt63_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rt63_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `rt63_notes_moyennes_surmatieres` AS select sum(if(`rt63_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`rt63_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `rt63_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`rt63_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`rt63_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`rt63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `rt63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`rt63_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`rt63_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`rt63_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`rt63_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`rt63_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`rt63_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`rt63_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`rt63_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `rt63_notes_moyennes_matiere` where `rt63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `rt63_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`rt63_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`rt63_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rt63_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `rt63_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `rt63_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `rt63_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `rt63_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `semestres_groupes_code`
--

/*!50001 DROP VIEW IF EXISTS `semestres_groupes_code`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `semestres_groupes_code` AS select `common_semestres_groupes`.`GROUPE_SEM_ID` AS `GROUPE_SEM_ID`,`common_semestres_groupes`.`SEM_GROUPE_ID` AS `SEM_GROUPE_ID`,`common_groupes`.`GROUPE_CODE` AS `SEM_GROUPE_CODE` from (`common_semestres_groupes` join `common_groupes`) where `common_groupes`.`GROUPE_ID` = `common_semestres_groupes`.`SEM_GROUPE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `soutenances_access_enseignants`
--

/*!50001 DROP VIEW IF EXISTS `soutenances_access_enseignants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `soutenances_access_enseignants` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_soutenances`.`ACCESS_ENSEIGNANT_ID` AS `ENS_ID`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`common_enseignant`.`ENS_MAIL` AS `ENS_MAIL`,`common_access_soutenances`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_departement`.`DEPT_CODE` AS `DEPT_CODE` from ((`common_access_soutenances` join `common_enseignant`) join `common_departement`) where `common_departement`.`DEPT_ID` = `common_access_soutenances`.`ACCESS_DEPT_ID` and `common_enseignant`.`ENS_ID` = `common_access_soutenances`.`ACCESS_ENSEIGNANT_ID` group by `common_access_soutenances`.`ACCESS_DEPT_ID`,`common_access_soutenances`.`ACCESS_ENSEIGNANT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stage_access_enseignants`
--

/*!50001 DROP VIEW IF EXISTS `stage_access_enseignants`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stage_access_enseignants` AS select `common_enseignant`.`ENS_LOGIN` AS `ENS_LOGIN`,`common_access_stage`.`ACCESS_ENSEIGNANT_ID` AS `ENS_ID`,`common_enseignant`.`ENS_NOM` AS `ENS_NOM`,`common_enseignant`.`ENS_MAIL` AS `ENS_MAIL`,`common_access_stage`.`ACCESS_DEPT_ID` AS `ACCESS_DEPT_ID`,`common_departement`.`DEPT_CODE` AS `DEPT_CODE` from ((`common_access_stage` join `common_enseignant`) join `common_departement`) where `common_departement`.`DEPT_ID` = `common_access_stage`.`ACCESS_DEPT_ID` and `common_enseignant`.`ENS_ID` = `common_access_stage`.`ACCESS_ENSEIGNANT_ID` group by `common_access_stage`.`ACCESS_DEPT_ID`,`common_access_stage`.`ACCESS_ENSEIGNANT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stid15_notes_moyennes_absences`
--

/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_absences`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stid15_notes_moyennes_absences` AS select `common_notes`.`NOTES_ET_ID` AS `ET_ID`,`common_matiere`.`MAT_ID` AS `MAT_ID`,`common_matiere`.`MAT_CODE_APOGE` AS `MAT_CODE_APOGE`,`common_controle`.`CONTROLE_ANNEE_ID` AS `ANNEE_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_REMONTEE`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO_ABS` from ((((`common_notes` join `common_controle`) join `common_matiere`) join `common_etudiant`) join `common_annee`) where `common_matiere`.`MAT_ID` = `common_controle`.`CONTROLE_MAT_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_etudiant`.`ET_ID` = `common_notes`.`NOTES_ET_ID` and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_notes`.`NOTES_ET_ID`,`common_matiere`.`MAT_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stid15_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stid15_notes_moyennes_annee` AS select sum(`stid15_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `stid15_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`stid15_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`stid15_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`stid15_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`stid15_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`stid15_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `stid15_notes_moyennes_semestre` group by `stid15_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`stid15_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stid15_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stid15_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `stid15_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `stid15_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stid15_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stid15_notes_moyennes_matiere` AS select `stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`stid15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`stid15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`stid15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`stid15_notes_moyennes_matiere_sans_bonus` left join `stid15_notes_moyennes_matiere_somme_bonus` on(`stid15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `stid15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `stid15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `stid15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `stid15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `stid15_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `stid15_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stid15_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stid15_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 10 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stid15_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stid15_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 10 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stid15_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stid15_notes_moyennes_semestre` AS select sum(`stid15_notes_moyennes_ue`.`MOYUE_VALEUR` * `stid15_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`stid15_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`stid15_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`stid15_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`stid15_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`stid15_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`stid15_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`stid15_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `stid15_notes_moyennes_ue` group by `stid15_notes_moyennes_ue`.`MOYUE_SEM_ID`,`stid15_notes_moyennes_ue`.`MOYUE_ET_ID`,`stid15_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stid15_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stid15_notes_moyennes_surmatieres` AS select sum(if(`stid15_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`stid15_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `stid15_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`stid15_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`stid15_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`stid15_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `stid15_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`stid15_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`stid15_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`stid15_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`stid15_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`stid15_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`stid15_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`stid15_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`stid15_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `stid15_notes_moyennes_matiere` where `stid15_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `stid15_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`stid15_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`stid15_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `stid15_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `stid15_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `stid15_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `stid15_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `stid15_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `tc03_notes_moyennes_annee`
--

/*!50001 DROP VIEW IF EXISTS `tc03_notes_moyennes_annee`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `tc03_notes_moyennes_annee` AS select sum(`tc03_notes_moyennes_semestre`.`MOYSEM_VALEUR` * `tc03_notes_moyennes_semestre`.`MOYSEM_COEF`) / sum(`tc03_notes_moyennes_semestre`.`MOYSEM_COEF`) AS `MOYAN_VALEUR`,`tc03_notes_moyennes_semestre`.`MOYSEM_ET_ID` AS `MOYAN_ET_ID`,`tc03_notes_moyennes_semestre`.`MOYSEM_FORM_ID` AS `MOYAN_FORM_ID`,`tc03_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` AS `MOYAN_ANNEE_ID`,min(`tc03_notes_moyennes_semestre`.`MOYSEM_SPECIAL`) AS `MOYAN_SPECIAL` from `tc03_notes_moyennes_semestre` group by `tc03_notes_moyennes_semestre`.`MOYSEM_ET_ID`,`tc03_notes_moyennes_semestre`.`MOYSEM_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `tc03_notes_moyennes_export`
--

/*!50001 DROP VIEW IF EXISTS `tc03_notes_moyennes_export`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `tc03_notes_moyennes_export` AS select `total`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`common_etudiant`.`ET_NUMERO` AS `ET_NUMERO`,`total`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`total`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`total`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`total`.`MOYMAT_COEF` AS `MOYMAT_COEF` from (((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `tc03_notes_moyennes_matiere` `matieres`) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF` from `tc03_notes_moyennes_surmatieres` `surmatieres`)) `total` join `common_etudiant`) where `common_etudiant`.`ET_ID` = `total`.`MOYMAT_ET_ID` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_MAT_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `tc03_notes_moyennes_matiere`
--

/*!50001 DROP VIEW IF EXISTS `tc03_notes_moyennes_matiere`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `tc03_notes_moyennes_matiere` AS select `tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` AS `MOYMAT_MAT_ID`,`tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,if(`tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` = 'ABI',NULL,if(ifnull(`tc03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR` > 20,20,ifnull(`tc03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_VALEUR`,0) + `tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_VALEUR`)) AS `MOYMAT_VALEUR`,`tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL`,`tc03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_BONUS_SPECIAL` AS `MOYMAT_BONUS_SPECIAL` from (`tc03_notes_moyennes_matiere_sans_bonus` left join `tc03_notes_moyennes_matiere_somme_bonus` on(`tc03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_MAT_ID` = `tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_MAT_ID` and `tc03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ET_ID` = `tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ET_ID` and `tc03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_ANNEE_ID` = `tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_ANNEE_ID` and `tc03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_UE_ID` = `tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_UE_ID` and `tc03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_SEM_ID` = `tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_SEM_ID` and `tc03_notes_moyennes_matiere_somme_bonus`.`MOYMAT_FORM_ID` = `tc03_notes_moyennes_matiere_sans_bonus`.`MOYMAT_FORM_ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `tc03_notes_moyennes_matiere_sans_bonus`
--

/*!50001 DROP VIEW IF EXISTS `tc03_notes_moyennes_matiere_sans_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `tc03_notes_moyennes_matiere_sans_bonus` AS select sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_notes`.`NOTES_VALEUR` * 20 / `common_controle`.`CONTROLE_BAREME` * `common_controle`.`CONTROLE_COEFF`)) / sum(if(`common_notes`.`NOTES_SPECIAL` = 'ABJ',0,`common_controle`.`CONTROLE_COEFF`)) AS `MOYMAT_VALEUR`,`common_matiere`.`MAT_COEF` AS `MOYMAT_COEF`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 21 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '1' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and (`common_notes`.`NOTES_VALEUR` is not null or `common_notes`.`NOTES_SPECIAL` is not null) and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `tc03_notes_moyennes_matiere_somme_bonus`
--

/*!50001 DROP VIEW IF EXISTS `tc03_notes_moyennes_matiere_somme_bonus`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `tc03_notes_moyennes_matiere_somme_bonus` AS select ifnull(sum(`common_notes`.`NOTES_VALEUR`),0) AS `MOYMAT_BONUS_VALEUR`,`common_matiere`.`MAT_ID` AS `MOYMAT_MAT_ID`,`common_notes`.`NOTES_ET_ID` AS `MOYMAT_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`common_ue`.`UE_ID` AS `MOYMAT_UE_ID`,`common_ue`.`UE_COEF` AS `MOYMAT_UE_COEF`,`common_semestre`.`SEM_COEF` AS `MOYMAT_SEM_COEF`,`common_semestre`.`SEM_ID` AS `MOYMAT_SEM_ID`,`common_semestre`.`SEM_FORM_ID` AS `MOYMAT_FORM_ID`,`common_matiere`.`MAT_SURMAT_ID` AS `MOYMAT_SURMAT_ID`,min(`common_notes`.`NOTES_SPECIAL`) AS `MOYMAT_BONUS_SPECIAL` from ((((((`common_controle` join `common_notes`) join `common_matiere`) join `common_ue`) join `common_semestre`) join `common_annee`) join `common_formation`) where `common_formation`.`FORM_DEPT_ID` = 21 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and ifnull(`common_matiere`.`MAT_COPIE_MAT_ID`,`common_matiere`.`MAT_ID`) = `common_controle`.`CONTROLE_MAT_ID` and `common_ue`.`UE_ID` = `common_matiere`.`MAT_UE_ID` and `common_semestre`.`SEM_ID` = `common_ue`.`UE_SEM_ID` and `common_controle`.`CONTROLE_ID` = `common_notes`.`NOTES_CONTROLE_ID` and `common_controle`.`CONTROLE_MOYENNE` = '2' and `common_controle`.`CONTROLE_VALIDE` = '1' and `common_matiere`.`MAT_HAS_NOTE` = 1 and `common_annee`.`ANNEE_ID` = `common_controle`.`CONTROLE_ANNEE_ID` and `common_annee`.`ANNEE_CLOSE` = 0 group by `common_matiere`.`MAT_ID`,`common_notes`.`NOTES_ET_ID`,`common_controle`.`CONTROLE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `tc03_notes_moyennes_semestre`
--

/*!50001 DROP VIEW IF EXISTS `tc03_notes_moyennes_semestre`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `tc03_notes_moyennes_semestre` AS select sum(`tc03_notes_moyennes_ue`.`MOYUE_VALEUR` * `tc03_notes_moyennes_ue`.`MOYUE_COEF_CALC`) / sum(`tc03_notes_moyennes_ue`.`MOYUE_COEF_CALC`) AS `MOYSEM_VALEUR`,`tc03_notes_moyennes_ue`.`MOYUE_ET_ID` AS `MOYSEM_ET_ID`,`tc03_notes_moyennes_ue`.`MOYUE_FORM_ID` AS `MOYSEM_FORM_ID`,`tc03_notes_moyennes_ue`.`MOYUE_ANNEE_ID` AS `MOYSEM_ANNEE_ID`,`tc03_notes_moyennes_ue`.`MOYUE_SEM_COEF` AS `MOYSEM_COEF`,`tc03_notes_moyennes_ue`.`MOYUE_SEM_ID` AS `MOYSEM_ID`,min(`tc03_notes_moyennes_ue`.`MOYUE_SPECIAL`) AS `MOYSEM_SPECIAL` from `tc03_notes_moyennes_ue` group by `tc03_notes_moyennes_ue`.`MOYUE_SEM_ID`,`tc03_notes_moyennes_ue`.`MOYUE_ET_ID`,`tc03_notes_moyennes_ue`.`MOYUE_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `tc03_notes_moyennes_surmatieres`
--

/*!50001 DROP VIEW IF EXISTS `tc03_notes_moyennes_surmatieres`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `tc03_notes_moyennes_surmatieres` AS select sum(if(`tc03_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`tc03_notes_moyennes_matiere`.`MOYMAT_VALEUR` * `tc03_notes_moyennes_matiere`.`MOYMAT_COEF`)) / sum(if(`tc03_notes_moyennes_matiere`.`MOYMAT_VALEUR` is null,0,`tc03_notes_moyennes_matiere`.`MOYMAT_COEF`)) AS `MOYMAT_VALEUR`,`tc03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` AS `MOYMAT_MAT_ID`,(select `common_matiere`.`MAT_COEF` from `common_matiere` where `common_matiere`.`MAT_ID` = `tc03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`) AS `MOYMAT_COEF`,`tc03_notes_moyennes_matiere`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`tc03_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`tc03_notes_moyennes_matiere`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`tc03_notes_moyennes_matiere`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`tc03_notes_moyennes_matiere`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`tc03_notes_moyennes_matiere`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`tc03_notes_moyennes_matiere`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,min(`tc03_notes_moyennes_matiere`.`MOYMAT_SPECIAL`) AS `MOYMAT_SPECIAL` from `tc03_notes_moyennes_matiere` where `tc03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID` is not null group by `tc03_notes_moyennes_matiere`.`MOYMAT_SURMAT_ID`,`tc03_notes_moyennes_matiere`.`MOYMAT_ET_ID`,`tc03_notes_moyennes_matiere`.`MOYMAT_ANNEE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `tc03_notes_moyennes_ue`
--

/*!50001 DROP VIEW IF EXISTS `tc03_notes_moyennes_ue`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb3 */;
/*!50001 SET character_set_results     = utf8mb3 */;
/*!50001 SET collation_connection      = utf8mb3_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `tc03_notes_moyennes_ue` AS select sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_VALEUR` * `total`.`MOYMAT_COEF`)) / sum(if(`total`.`MOYMAT_SPECIAL` = 'ABJ' and `total`.`MOYMAT_VALEUR` is null,0,`total`.`MOYMAT_COEF`)) AS `MOYUE_VALEUR`,`total`.`MOYMAT_ET_ID` AS `MOYUE_ET_ID`,`total`.`MOYMAT_ANNEE_ID` AS `MOYUE_ANNEE_ID`,`total`.`MOYMAT_UE_ID` AS `MOYUE_UE_ID`,`total`.`MOYMAT_UE_COEF` AS `MOYUE_COEF`,`total`.`MOYMAT_SEM_COEF` AS `MOYUE_SEM_COEF`,`total`.`MOYMAT_SEM_ID` AS `MOYUE_SEM_ID`,`total`.`MOYMAT_FORM_ID` AS `MOYUE_FORM_ID`,sum(`total`.`MOYMAT_COEF`) AS `MOYUE_COEF_CALC`,min(`total`.`MOYMAT_SPECIAL`) AS `MOYUE_SPECIAL` from ((select `matieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`matieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`matieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`matieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`matieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`matieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`matieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`matieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`matieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`matieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `tc03_notes_moyennes_matiere` `matieres` where `matieres`.`MOYMAT_SURMAT_ID` is null) union all (select `surmatieres`.`MOYMAT_VALEUR` AS `MOYMAT_VALEUR`,`surmatieres`.`MOYMAT_COEF` AS `MOYMAT_COEF`,`surmatieres`.`MOYMAT_ET_ID` AS `MOYMAT_ET_ID`,`surmatieres`.`MOYMAT_ANNEE_ID` AS `MOYMAT_ANNEE_ID`,`surmatieres`.`MOYMAT_UE_ID` AS `MOYMAT_UE_ID`,`surmatieres`.`MOYMAT_SEM_COEF` AS `MOYMAT_SEM_COEF`,`surmatieres`.`MOYMAT_SEM_ID` AS `MOYMAT_SEM_ID`,`surmatieres`.`MOYMAT_FORM_ID` AS `MOYMAT_FORM_ID`,`surmatieres`.`MOYMAT_UE_COEF` AS `MOYMAT_UE_COEF`,`surmatieres`.`MOYMAT_SPECIAL` AS `MOYMAT_SPECIAL` from `tc03_notes_moyennes_surmatieres` `surmatieres`)) `total` group by `total`.`MOYMAT_ET_ID`,`total`.`MOYMAT_ANNEE_ID`,`total`.`MOYMAT_UE_ID` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `trombinoscope`
--

/*!50001 DROP VIEW IF EXISTS `trombinoscope`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`odin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `trombinoscope` AS select `etudiants_groupes`.`ET_ID` AS `ET_ID`,`etudiants_groupes`.`ET_NOM` AS `ET_NOM`,`etudiants_groupes`.`GROUPE_ID` AS `GROUPE_ID`,`etudiants_groupes`.`GROUPE_NOM` AS `GROUPE_NOM`,`etudiants_groupes`.`GROUPE_ENS_ID` AS `GROUPE_ENS_ID`,`etudiants_groupes`.`ET_NUMERO` AS `ET_NUMERO`,`etudiants_groupes`.`GROUPE_FEUILLE` AS `GROUPE_FEUILLE`,`etudiants_groupes`.`ET_MAIL` AS `ET_MAIL`,`etudiants_groupes`.`ET_BAC` AS `ET_BAC`,`etudiants_groupes`.`ET_NAISSANCE` AS `ET_NAISSANCE`,`etudiants_groupes`.`ET_TIERS` AS `ET_TIERS`,`etudiants_groupes`.`ET_RED` AS `ET_RED`,`common_annee`.`ANNEE_ID` AS `ANNEE_ID`,`common_annee`.`ANNEE_NOM` AS `ANNEE_NOM`,`common_formation`.`FORM_ID` AS `FORM_ID`,`common_formation`.`FORM_NOM` AS `FORM_NOM`,`common_formation`.`FORM_DEPT_ID` AS `FORM_DEPT_ID`,`common_formation`.`FORM_PRO` AS `FORM_PRO`,`common_semestre`.`SEM_ID` AS `SEM_ID`,`common_semestre`.`SEM_NOM` AS `SEM_NOM` from ((((`etudiants_groupes` join `common_annee`) join `common_formation`) join `common_semestre`) join `semestres_groupes_code`) where `common_annee`.`ANNEE_ID` = `etudiants_groupes`.`ET_GROUPE_ANNEE_ID` and `common_annee`.`ANNEE_COURANTE` = 1 and `common_formation`.`FORM_ID` = `common_semestre`.`SEM_FORM_ID` and `semestres_groupes_code`.`SEM_GROUPE_CODE` like concat(`etudiants_groupes`.`GROUPE_CODE`,'%') and `semestres_groupes_code`.`GROUPE_SEM_ID` = `common_semestre`.`SEM_ID` and `semestres_groupes_code`.`SEM_GROUPE_ID` = `etudiants_groupes`.`GROUPE_ID` */;
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

-- Dump completed on 2023-12-14  3:05:11
