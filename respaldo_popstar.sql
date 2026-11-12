-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: popstar
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Current Database: `popstar`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `popstar` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `popstar`;

--
-- Table structure for table `catalogo_discos`
--

DROP TABLE IF EXISTS `catalogo_discos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogo_discos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(180) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `artista` varchar(200) NOT NULL,
  `precio` decimal(10,2) unsigned NOT NULL,
  `imagen` varchar(1024) NOT NULL,
  `stock` int(10) unsigned NOT NULL DEFAULT 5,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `catalogo_discos_codigo_unico` (`codigo`),
  KEY `catalogo_discos_titulo_artista` (`titulo`,`artista`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogo_discos`
--

LOCK TABLES `catalogo_discos` WRITE;
/*!40000 ALTER TABLE `catalogo_discos` DISABLE KEYS */;
INSERT INTO `catalogo_discos` VALUES (1,'after-hours-the-weeknd','AFTER HOURS','THE WEEKND',850.00,'./imagenes/albums/after-hours.webp',5,'2026-11-04 22:03:24',1),(2,'random-access-memories-daft-punk','RANDOM ACCESS MEMORIES','DAFT PUNK',920.00,'./imagenes/albums/ram.webp',5,'2026-11-04 22:03:24',1),(3,'lust-for-life-lana-del-rey','LUST FOR LIFE','LANA DEL REY',780.00,'./imagenes/albums/lust-for-life.webp',5,'2026-11-04 22:03:24',1),(4,'abbey-road-the-beatles','ABBEY ROAD','THE BEATLES',990.00,'./imagenes/albums/abbey-road.webp',4,'2026-11-04 22:03:24',1),(5,'am-arctic-monkeys','AM','ARCTIC MONKEYS',750.00,'./imagenes/albums/am.webp',5,'2026-11-04 22:03:24',1),(6,'gta-san-andreas-ost-varios','GTA SAN ANDREAS OST','VARIOS',700.00,'./imagenes/albums/gta.webp',5,'2026-11-04 22:03:24',1),(7,'in-utero-nirvana','IN UTERO','NIRVANA',820.00,'./imagenes/albums/in-utero.webp',5,'2026-11-04 22:03:24',1),(8,'starboy-the-weeknd','STARBOY','THE WEEKND',850.00,'./imagenes/albums/starboy.webp',5,'2026-11-04 22:03:24',1),(9,'thriller-michael-jackson','THRILLER','MICHAEL JACKSON',950.00,'https://is1-ssl.mzstatic.com/image/thumb/Music115/v4/32/4f/fd/324ffda2-9e51-8f6a-0c2d-c6fd2b41ac55/074643811224.jpg/600x600bb.jpg',3,'2026-11-04 22:03:24',1),(10,'the-dark-side-of-the-moon-pink-floyd','THE DARK SIDE OF THE MOON','PINK FLOYD',1100.00,'https://is1-ssl.mzstatic.com/image/thumb/Music221/v4/3e/76/b0/3e76b0e3-762b-2286-a019-8afb19cee541/886445635829.jpg/600x600bb.jpg',4,'2026-11-04 22:03:24',1),(11,'rumours-fleetwood-mac','RUMOURS','FLEETWOOD MAC',890.00,'https://is1-ssl.mzstatic.com/image/thumb/Music124/v4/4d/13/ba/4d13bac3-d3d5-7581-2c74-034219eadf2b/081227970949.jpg/600x600bb.jpg',5,'2026-11-04 22:03:24',1),(12,'blonde-frank-ocean','BLONDE','FRANK OCEAN',980.00,'https://is1-ssl.mzstatic.com/image/thumb/Music115/v4/bb/45/68/bb4568f3-68cd-619d-fbcb-4e179916545d/BlondCover-Final.jpg/600x600bb.jpg',5,'2026-11-04 22:03:24',1),(13,'damn-kendrick-lamar','DAMN.','KENDRICK LAMAR',870.00,'https://is1-ssl.mzstatic.com/image/thumb/Music112/v4/ab/16/ef/ab16efe9-e7f1-66ec-021c-5592a23f0f9e/17UMGIM88793.rgb.jpg/600x600bb.jpg',5,'2026-11-04 22:03:24',1),(14,'happier-than-ever-billie-eilish','HAPPIER THAN EVER','BILLIE EILISH',860.00,'https://is1-ssl.mzstatic.com/image/thumb/Music125/v4/02/b7/6d/02b76dd3-4006-bc65-9f33-33b70a95222a/21UMGIM36684.rgb.jpg/600x600bb.jpg',5,'2026-11-04 22:03:24',1),(15,'un-verano-sin-ti-bad-bunny','UN VERANO SIN TI','BAD BUNNY',900.00,'https://is1-ssl.mzstatic.com/image/thumb/Music112/v4/3e/04/eb/3e04ebf6-370f-f59d-ec84-2c2643db92f1/196626945068.jpg/600x600bb.jpg',5,'2026-11-04 22:03:24',1),(16,'ok-computer-radiohead','OK COMPUTER','RADIOHEAD',880.00,'https://is1-ssl.mzstatic.com/image/thumb/Music116/v4/07/60/ba/0760ba0f-148c-b18f-d0ff-169ee96f3af5/634904078164.png/600x600bb.jpg',5,'2026-11-04 22:03:24',1),(17,'currents-tame-impala','CURRENTS','TAME IMPALA',840.00,'https://is1-ssl.mzstatic.com/image/thumb/Music115/v4/a8/2e/b4/a82eb490-f30a-a321-461a-0383c88fec95/15UMGIM23316.rgb.jpg/600x600bb.jpg',5,'2026-11-04 22:03:24',1),(18,'a-night-at-the-opera-queen','A NIGHT AT THE OPERA','QUEEN',960.00,'https://is1-ssl.mzstatic.com/image/thumb/Music211/v4/dd/86/92/dd86925d-484d-8ee7-3985-ef3264214269/602527644264.jpg/600x600bb.jpg',5,'2026-11-04 22:03:24',1),(19,'demon-days-gorillaz','DEMON DAYS','GORILLAZ',820.00,'https://is1-ssl.mzstatic.com/image/thumb/Music125/v4/1c/0f/81/1c0f818a-e458-dd84-6f1b-ccbdf5fe14d6/825646291045.jpg/600x600bb.jpg',5,'2026-11-04 22:03:24',1),(20,'canci-on-animal-soda-stereo','CANCIÓN ANIMAL','SODA STEREO',790.00,'https://is1-ssl.mzstatic.com/image/thumb/Music125/v4/60/18/68/601868f7-68ba-9416-af42-b26b2f68035f/mzi.qyqtvoxs.jpg/600x600bb.jpg',5,'2026-11-04 22:03:24',1),(21,'american-teen-khalid','AMERICAN TEEN','KHALID',780.00,'https://upload.wikimedia.org/wikipedia/en/7/7d/Khalid_-_American_Teen.png',5,'2026-11-04 22:03:24',1),(22,'free-spirit-khalid','FREE SPIRIT','KHALID',817.00,'https://upload.wikimedia.org/wikipedia/en/1/1b/Khalid_-_Free_Spirit.png',5,'2026-11-04 22:03:24',1),(23,'suncity-khalid','SUNCITY','KHALID',854.00,'https://picsum.photos/seed/popstar-disco-3/600/600',5,'2026-11-04 22:03:24',1),(24,'vessel-twenty-one-pilots','VESSEL','TWENTY ONE PILOTS',891.00,'https://upload.wikimedia.org/wikipedia/en/0/0f/Twenty_One_Pilots_-_Vessel.png',5,'2026-11-04 22:03:24',1),(25,'blurryface-twenty-one-pilots','BLURRYFACE','TWENTY ONE PILOTS',928.00,'https://picsum.photos/seed/popstar-disco-5/600/600',5,'2026-11-04 22:03:24',1),(26,'trench-twenty-one-pilots','TRENCH','TWENTY ONE PILOTS',965.00,'https://picsum.photos/seed/popstar-disco-6/600/600',5,'2026-11-04 22:03:24',1),(27,'scaled-and-icy-twenty-one-pilots','SCALED AND ICY','TWENTY ONE PILOTS',1002.00,'https://picsum.photos/seed/popstar-disco-7/600/600',5,'2026-11-04 22:03:24',1),(28,'clancy-twenty-one-pilots','CLANCY','TWENTY ONE PILOTS',1039.00,'https://picsum.photos/seed/popstar-disco-8/600/600',5,'2026-11-04 22:03:24',1),(29,'ctrl-sza','CTRL','SZA',1076.00,'https://picsum.photos/seed/popstar-disco-9/600/600',5,'2026-11-04 22:03:24',1),(30,'sos-sza','SOS','SZA',792.00,'https://picsum.photos/seed/popstar-disco-10/600/600',5,'2026-11-04 22:03:24',1),(31,'trapsoul-bryson-tiller','TRAPSOUL','BRYSON TILLER',829.00,'https://picsum.photos/seed/popstar-disco-11/600/600',5,'2026-11-04 22:03:24',1),(32,'21-adele','21','ADELE',866.00,'https://picsum.photos/seed/popstar-disco-12/600/600',5,'2026-11-04 22:03:24',1),(33,'25-adele','25','ADELE',903.00,'https://picsum.photos/seed/popstar-disco-13/600/600',5,'2026-11-04 22:03:24',1),(34,'30-adele','30','ADELE',940.00,'https://picsum.photos/seed/popstar-disco-14/600/600',5,'2026-11-04 22:03:24',1),(35,'future-nostalgia-dua-lipa','FUTURE NOSTALGIA','DUA LIPA',977.00,'https://picsum.photos/seed/popstar-disco-15/600/600',5,'2026-11-04 22:03:24',1),(36,'channel-orange-frank-ocean','CHANNEL ORANGE','FRANK OCEAN',1014.00,'https://picsum.photos/seed/popstar-disco-16/600/600',5,'2026-11-04 22:03:24',1),(37,'lemonade-beyonc-e','LEMONADE','BEYONCÉ',1051.00,'https://picsum.photos/seed/popstar-disco-17/600/600',5,'2026-11-04 22:03:24',1),(38,'anti-rihanna','ANTI','RIHANNA',1088.00,'https://picsum.photos/seed/popstar-disco-18/600/600',5,'2026-11-04 22:03:24',1),(39,'melodrama-lorde','MELODRAMA','LORDE',804.00,'https://picsum.photos/seed/popstar-disco-19/600/600',5,'2026-11-04 22:03:24',1),(40,'pure-heroine-lorde','PURE HEROINE','LORDE',841.00,'https://picsum.photos/seed/popstar-disco-20/600/600',5,'2026-11-04 22:03:24',1),(41,'teenage-dream-katy-perry','TEENAGE DREAM','KATY PERRY',878.00,'https://picsum.photos/seed/popstar-disco-21/600/600',5,'2026-11-04 22:03:24',1),(42,'dookie-green-day','DOOKIE','GREEN DAY',915.00,'https://picsum.photos/seed/popstar-disco-22/600/600',5,'2026-11-04 22:03:24',1),(43,'american-idiot-green-day','AMERICAN IDIOT','GREEN DAY',952.00,'https://picsum.photos/seed/popstar-disco-23/600/600',5,'2026-11-04 22:03:24',1),(44,'the-black-parade-my-chemical-romance','THE BLACK PARADE','MY CHEMICAL ROMANCE',989.00,'https://picsum.photos/seed/popstar-disco-24/600/600',5,'2026-11-04 22:03:24',1),(45,'three-cheers-for-sweet-revenge-my-chemical-romance','THREE CHEERS FOR SWEET REVENGE','MY CHEMICAL ROMANCE',1026.00,'https://picsum.photos/seed/popstar-disco-25/600/600',5,'2026-11-04 22:03:24',1),(46,'is-this-it-the-strokes','IS THIS IT','THE STROKES',1063.00,'https://picsum.photos/seed/popstar-disco-26/600/600',5,'2026-11-04 22:03:24',1),(47,'room-on-fire-the-strokes','ROOM ON FIRE','THE STROKES',1100.00,'https://picsum.photos/seed/popstar-disco-27/600/600',5,'2026-11-04 22:03:24',1),(48,'in-rainbows-radiohead','IN RAINBOWS','RADIOHEAD',816.00,'https://picsum.photos/seed/popstar-disco-28/600/600',5,'2026-11-04 22:03:24',1),(49,'kid-a-radiohead','KID A','RADIOHEAD',853.00,'https://picsum.photos/seed/popstar-disco-29/600/600',5,'2026-11-04 22:03:24',1),(50,'origin-of-symmetry-muse','ORIGIN OF SYMMETRY','MUSE',890.00,'https://picsum.photos/seed/popstar-disco-30/600/600',5,'2026-11-04 22:03:24',1),(51,'absolution-muse','ABSOLUTION','MUSE',927.00,'https://picsum.photos/seed/popstar-disco-31/600/600',5,'2026-11-04 22:03:24',1),(52,'black-holes-and-revelations-muse','BLACK HOLES AND REVELATIONS','MUSE',964.00,'https://picsum.photos/seed/popstar-disco-32/600/600',5,'2026-11-04 22:03:24',1),(53,'parachutes-coldplay','PARACHUTES','COLDPLAY',1001.00,'https://picsum.photos/seed/popstar-disco-33/600/600',5,'2026-11-04 22:03:24',1),(54,'a-rush-of-blood-to-the-head-coldplay','A RUSH OF BLOOD TO THE HEAD','COLDPLAY',1038.00,'https://picsum.photos/seed/popstar-disco-34/600/600',5,'2026-11-04 22:03:24',1),(55,'viva-la-vida-or-death-and-all-his-friends-coldplay','VIVA LA VIDA OR DEATH AND ALL HIS FRIENDS','COLDPLAY',1075.00,'https://picsum.photos/seed/popstar-disco-35/600/600',5,'2026-11-04 22:03:24',1),(56,'hybrid-theory-linkin-park','HYBRID THEORY','LINKIN PARK',791.00,'https://picsum.photos/seed/popstar-disco-36/600/600',5,'2026-11-04 22:03:24',1),(57,'meteora-linkin-park','METEORA','LINKIN PARK',828.00,'https://picsum.photos/seed/popstar-disco-37/600/600',5,'2026-11-04 22:03:24',1),(58,'toxicity-system-of-a-down','TOXICITY','SYSTEM OF A DOWN',865.00,'https://picsum.photos/seed/popstar-disco-38/600/600',5,'2026-11-04 22:03:24',1),(59,'mezmerize-system-of-a-down','MEZMERIZE','SYSTEM OF A DOWN',902.00,'https://picsum.photos/seed/popstar-disco-39/600/600',5,'2026-11-04 22:03:24',1),(60,'songs-for-the-deaf-queens-of-the-stone-age','SONGS FOR THE DEAF','QUEENS OF THE STONE AGE',939.00,'https://picsum.photos/seed/popstar-disco-40/600/600',5,'2026-11-04 22:03:24',1),(61,'the-new-abnormal-the-strokes','THE NEW ABNORMAL','THE STROKES',976.00,'https://picsum.photos/seed/popstar-disco-41/600/600',5,'2026-11-04 22:03:24',1),(62,'discovery-daft-punk','DISCOVERY','DAFT PUNK',1013.00,'https://picsum.photos/seed/popstar-disco-42/600/600',5,'2026-11-04 22:03:24',1),(63,'homework-daft-punk','HOMEWORK','DAFT PUNK',1050.00,'https://picsum.photos/seed/popstar-disco-43/600/600',5,'2026-11-04 22:03:24',1),(64,'cross-justice','CROSS','JUSTICE',1087.00,'https://picsum.photos/seed/popstar-disco-44/600/600',5,'2026-11-04 22:03:24',1),(65,'true-avicii','TRUE','AVICII',803.00,'https://picsum.photos/seed/popstar-disco-45/600/600',5,'2026-11-04 22:03:24',1),(66,'stories-avicii','STORIES','AVICII',840.00,'https://picsum.photos/seed/popstar-disco-46/600/600',5,'2026-11-04 22:03:24',1),(67,'worlds-porter-robinson','WORLDS','PORTER ROBINSON',877.00,'https://picsum.photos/seed/popstar-disco-47/600/600',5,'2026-11-04 22:03:24',1),(68,'nurture-porter-robinson','NURTURE','PORTER ROBINSON',914.00,'https://picsum.photos/seed/popstar-disco-48/600/600',5,'2026-11-04 22:03:24',1),(69,'in-return-odesza','IN RETURN','ODESZA',951.00,'https://picsum.photos/seed/popstar-disco-49/600/600',5,'2026-11-04 22:03:24',1),(70,'a-moment-apart-odesza','A MOMENT APART','ODESZA',988.00,'https://picsum.photos/seed/popstar-disco-50/600/600',5,'2026-11-04 22:03:24',1),(71,'skin-flume','SKIN','FLUME',1025.00,'https://picsum.photos/seed/popstar-disco-51/600/600',5,'2026-11-04 22:03:24',1),(72,'immunity-jon-hopkins','IMMUNITY','JON HOPKINS',1062.00,'https://picsum.photos/seed/popstar-disco-52/600/600',5,'2026-11-04 22:03:24',1),(73,'settle-disclosure','SETTLE','DISCLOSURE',1099.00,'https://picsum.photos/seed/popstar-disco-53/600/600',5,'2026-11-04 22:03:24',1),(74,'welcome-reality-nero','WELCOME REALITY','NERO',815.00,'https://picsum.photos/seed/popstar-disco-54/600/600',5,'2026-11-04 22:03:24',1),(75,'syro-aphex-twin','SYRO','APHEX TWIN',852.00,'https://picsum.photos/seed/popstar-disco-55/600/600',5,'2026-11-04 22:03:24',1),(76,'play-moby','PLAY','MOBY',889.00,'https://picsum.photos/seed/popstar-disco-56/600/600',5,'2026-11-04 22:03:24',1),(77,'kind-of-blue-miles-davis','KIND OF BLUE','MILES DAVIS',926.00,'https://picsum.photos/seed/popstar-disco-57/600/600',5,'2026-11-04 22:03:24',1),(78,'time-out-dave-brubeck','TIME OUT','DAVE BRUBECK',963.00,'https://picsum.photos/seed/popstar-disco-58/600/600',5,'2026-11-04 22:03:24',1),(79,'blue-train-john-coltrane','BLUE TRAIN','JOHN COLTRANE',1000.00,'https://picsum.photos/seed/popstar-disco-59/600/600',5,'2026-11-04 22:03:24',1),(80,'a-love-supreme-john-coltrane','A LOVE SUPREME','JOHN COLTRANE',1037.00,'https://picsum.photos/seed/popstar-disco-60/600/600',5,'2026-11-04 22:03:24',1),(81,'mingus-ah-um-charles-mingus','MINGUS AH UM','CHARLES MINGUS',1074.00,'https://picsum.photos/seed/popstar-disco-61/600/600',5,'2026-11-04 22:03:24',1),(82,'head-hunters-herbie-hancock','HEAD HUNTERS','HERBIE HANCOCK',790.00,'https://picsum.photos/seed/popstar-disco-62/600/600',5,'2026-11-04 22:03:24',1),(83,'getz-gilberto-stan-getz','GETZ/GILBERTO','STAN GETZ',827.00,'https://picsum.photos/seed/popstar-disco-63/600/600',5,'2026-11-04 22:03:24',1),(84,'chet-baker-sings-chet-baker','CHET BAKER SINGS','CHET BAKER',864.00,'https://picsum.photos/seed/popstar-disco-64/600/600',5,'2026-11-04 22:03:24',1),(85,'bitches-brew-miles-davis','BITCHES BREW','MILES DAVIS',901.00,'https://picsum.photos/seed/popstar-disco-65/600/600',5,'2026-11-04 22:03:24',1),(86,'i-put-a-spell-on-you-nina-simone','I PUT A SPELL ON YOU','NINA SIMONE',938.00,'https://picsum.photos/seed/popstar-disco-66/600/600',5,'2026-11-04 22:03:24',1),(87,'good-kid-m-a-a-d-city-kendrick-lamar','GOOD KID, M.A.A.D CITY','KENDRICK LAMAR',975.00,'https://picsum.photos/seed/popstar-disco-67/600/600',5,'2026-11-04 22:03:24',1),(88,'to-pimp-a-butterfly-kendrick-lamar','TO PIMP A BUTTERFLY','KENDRICK LAMAR',1012.00,'https://picsum.photos/seed/popstar-disco-68/600/600',5,'2026-11-04 22:03:24',1),(89,'mr-morale-the-big-steppers-kendrick-lamar','MR. MORALE & THE BIG STEPPERS','KENDRICK LAMAR',1049.00,'https://picsum.photos/seed/popstar-disco-69/600/600',5,'2026-11-04 22:03:24',1),(90,'illmatic-nas','ILLMATIC','NAS',1086.00,'https://picsum.photos/seed/popstar-disco-70/600/600',5,'2026-11-04 22:03:24',1),(91,'it-was-written-nas','IT WAS WRITTEN','NAS',802.00,'https://picsum.photos/seed/popstar-disco-71/600/600',5,'2026-11-04 22:03:24',1),(92,'ready-to-die-the-notorious-b-i-g','READY TO DIE','THE NOTORIOUS B.I.G.',839.00,'https://picsum.photos/seed/popstar-disco-72/600/600',5,'2026-11-04 22:03:24',1),(93,'life-after-death-the-notorious-b-i-g','LIFE AFTER DEATH','THE NOTORIOUS B.I.G.',876.00,'https://picsum.photos/seed/popstar-disco-73/600/600',5,'2026-11-04 22:03:24',1),(94,'the-college-dropout-kanye-west','THE COLLEGE DROPOUT','KANYE WEST',913.00,'https://picsum.photos/seed/popstar-disco-74/600/600',5,'2026-11-04 22:03:24',1),(95,'late-registration-kanye-west','LATE REGISTRATION','KANYE WEST',950.00,'https://picsum.photos/seed/popstar-disco-75/600/600',5,'2026-11-04 22:03:24',1),(96,'graduation-kanye-west','GRADUATION','KANYE WEST',987.00,'https://picsum.photos/seed/popstar-disco-76/600/600',5,'2026-11-04 22:03:24',1),(97,'my-beautiful-dark-twisted-fantasy-kanye-west','MY BEAUTIFUL DARK TWISTED FANTASY','KANYE WEST',1024.00,'https://picsum.photos/seed/popstar-disco-77/600/600',5,'2026-11-04 22:03:24',1),(98,'astroworld-travis-scott','ASTROWORLD','TRAVIS SCOTT',1061.00,'https://picsum.photos/seed/popstar-disco-78/600/600',5,'2026-11-04 22:03:24',1),(99,'rodeo-travis-scott','RODEO','TRAVIS SCOTT',1098.00,'https://picsum.photos/seed/popstar-disco-79/600/600',5,'2026-11-04 22:03:24',1),(100,'take-care-drake','TAKE CARE','DRAKE',814.00,'https://picsum.photos/seed/popstar-disco-80/600/600',5,'2026-11-04 22:03:24',1),(101,'2014-forest-hills-drive-j-cole','2014 FOREST HILLS DRIVE','J. COLE',851.00,'https://picsum.photos/seed/popstar-disco-81/600/600',5,'2026-11-04 22:03:24',1),(102,'yhlqmdlg-bad-bunny','YHLQMDLG','BAD BUNNY',888.00,'https://picsum.photos/seed/popstar-disco-82/600/600',5,'2026-11-04 22:03:24',1),(103,'el-ultimo-tour-del-mundo-bad-bunny','EL ÚLTIMO TOUR DEL MUNDO','BAD BUNNY',925.00,'https://picsum.photos/seed/popstar-disco-83/600/600',5,'2026-11-04 22:03:24',1),(104,'motomami-rosal-ia','MOTOMAMI','ROSALÍA',962.00,'https://picsum.photos/seed/popstar-disco-84/600/600',5,'2026-11-04 22:03:24',1),(105,'el-mal-querer-rosal-ia','EL MAL QUERER','ROSALÍA',999.00,'https://picsum.photos/seed/popstar-disco-85/600/600',5,'2026-11-04 22:03:24',1),(106,'bocanada-gustavo-cerati','BOCANADA','GUSTAVO CERATI',1036.00,'https://picsum.photos/seed/popstar-disco-86/600/600',5,'2026-11-04 22:03:24',1),(107,'d-onde-jugar-an-los-ni-nos-man-a','¿DÓNDE JUGARÁN LOS NIÑOS?','MANÁ',1073.00,'https://picsum.photos/seed/popstar-disco-87/600/600',5,'2026-11-04 22:03:24',1),(108,'sue-no-stereo-soda-stereo','SUEÑO STEREO','SODA STEREO',789.00,'https://picsum.photos/seed/popstar-disco-88/600/600',5,'2026-11-04 22:03:24',1),(109,'re-caf-e-tacvba','RE','CAFÉ TACVBA',826.00,'https://picsum.photos/seed/popstar-disco-89/600/600',5,'2026-11-04 22:03:24',1),(110,'romance-luis-miguel','ROMANCE','LUIS MIGUEL',863.00,'https://picsum.photos/seed/popstar-disco-90/600/600',5,'2026-11-04 22:03:24',1),(111,'hasta-la-ra-iz-natalia-lafourcade','HASTA LA RAÍZ','NATALIA LAFOURCADE',900.00,'https://picsum.photos/seed/popstar-disco-91/600/600',5,'2026-11-04 22:03:24',1),(112,'lim-on-y-sal-julieta-venegas','LIMÓN Y SAL','JULIETA VENEGAS',937.00,'https://picsum.photos/seed/popstar-disco-92/600/600',5,'2026-11-04 22:03:24',1),(113,'mon-laferte-vol-1-mon-laferte','MON LAFERTE VOL. 1','MON LAFERTE',974.00,'https://picsum.photos/seed/popstar-disco-93/600/600',5,'2026-11-04 22:03:24',1),(114,'un-d-ia-normal-juanes','UN DÍA NORMAL','JUANES',1011.00,'https://picsum.photos/seed/popstar-disco-94/600/600',5,'2026-11-04 22:03:24',1),(115,'d-onde-est-an-los-ladrones-shakira','DÓNDE ESTÁN LOS LADRONES?','SHAKIRA',1048.00,'https://picsum.photos/seed/popstar-disco-95/600/600',5,'2026-11-04 22:03:24',1),(116,'entren-los-que-quieran-calle-13','ENTREN LOS QUE QUIERAN','CALLE 13',1085.00,'https://picsum.photos/seed/popstar-disco-96/600/600',5,'2026-11-04 22:03:24',1),(117,'when-we-all-fall-asleep-where-do-we-go-billie-eilish','WHEN WE ALL FALL ASLEEP, WHERE DO WE GO?','BILLIE EILISH',801.00,'https://picsum.photos/seed/popstar-disco-97/600/600',5,'2026-11-04 22:03:24',1),(118,'revolver-the-beatles','REVOLVER','THE BEATLES',838.00,'https://picsum.photos/seed/popstar-disco-98/600/600',5,'2026-11-04 22:03:24',1),(119,'goodbye-yellow-brick-road-elton-john','GOODBYE YELLOW BRICK ROAD','ELTON JOHN',875.00,'https://picsum.photos/seed/popstar-disco-99/600/600',5,'2026-11-04 22:03:24',1),(120,'automatic-for-the-people-r-e-m','AUTOMATIC FOR THE PEOPLE','R.E.M.',912.00,'https://picsum.photos/seed/popstar-disco-100/600/600',5,'2026-11-04 22:03:24',1),(121,'back-to-black-amy-winehouse','BACK TO BLACK','AMY WINEHOUSE',790.00,'https://picsum.photos/seed/popstar-nuevo-1/600/600',5,'2026-11-04 22:03:24',1),(122,'purple-rain-prince','PURPLE RAIN','PRINCE',833.00,'https://picsum.photos/seed/popstar-nuevo-2/600/600',5,'2026-11-04 22:03:24',1),(123,'sign-o-the-times-prince','SIGN O’ THE TIMES','PRINCE',876.00,'https://picsum.photos/seed/popstar-nuevo-3/600/600',5,'2026-11-04 22:03:24',1),(124,'the-miseducation-of-lauryn-hill-lauryn-hill','THE MISEDUCATION OF LAURYN HILL','LAURYN HILL',919.00,'https://picsum.photos/seed/popstar-nuevo-4/600/600',5,'2026-11-04 22:03:24',1),(125,'in-the-aeroplane-over-the-sea-neutral-milk-hotel','IN THE AEROPLANE OVER THE SEA','NEUTRAL MILK HOTEL',962.00,'https://picsum.photos/seed/popstar-nuevo-5/600/600',5,'2026-11-04 22:03:24',1),(126,'blue-joni-mitchell','BLUE','JONI MITCHELL',1005.00,'https://picsum.photos/seed/popstar-nuevo-6/600/600',5,'2026-11-04 22:03:24',1),(127,'grace-jeff-buckley','GRACE','JEFF BUCKLEY',1048.00,'https://picsum.photos/seed/popstar-nuevo-7/600/600',5,'2026-11-04 22:03:24',1),(128,'hounds-of-love-kate-bush','HOUNDS OF LOVE','KATE BUSH',790.00,'https://picsum.photos/seed/popstar-nuevo-8/600/600',5,'2026-11-04 22:03:24',1),(129,'music-from-big-pink-the-band','MUSIC FROM BIG PINK','THE BAND',833.00,'https://picsum.photos/seed/popstar-nuevo-9/600/600',5,'2026-11-04 22:03:24',1),(130,'hotel-california-eagles','HOTEL CALIFORNIA','EAGLES',876.00,'https://picsum.photos/seed/popstar-nuevo-10/600/600',5,'2026-11-04 22:03:24',1),(131,'the-queen-is-dead-the-smiths','THE QUEEN IS DEAD','THE SMITHS',919.00,'https://picsum.photos/seed/popstar-nuevo-11/600/600',5,'2026-11-04 22:03:24',1),(132,'low-david-bowie','LOW','DAVID BOWIE',962.00,'https://picsum.photos/seed/popstar-nuevo-12/600/600',5,'2026-11-04 22:03:24',1),(133,'remain-in-light-talking-heads','REMAIN IN LIGHT','TALKING HEADS',1005.00,'https://picsum.photos/seed/popstar-nuevo-13/600/600',5,'2026-11-04 22:03:24',1),(134,'born-to-run-bruce-springsteen','BORN TO RUN','BRUCE SPRINGSTEEN',1048.00,'https://picsum.photos/seed/popstar-nuevo-14/600/600',5,'2026-11-04 22:03:24',1),(135,'speak-now-taylor-swift','SPEAK NOW','TAYLOR SWIFT',790.00,'https://picsum.photos/seed/popstar-nuevo-15/600/600',5,'2026-11-04 22:03:24',1),(136,'1989-taylor-swift','1989','TAYLOR SWIFT',833.00,'https://picsum.photos/seed/popstar-nuevo-16/600/600',5,'2026-11-04 22:03:24',1),(137,'guts-olivia-rodrigo','GUTS','OLIVIA RODRIGO',876.00,'https://picsum.photos/seed/popstar-nuevo-17/600/600',5,'2026-11-04 22:03:24',1),(138,'harry-s-house-harry-styles','HARRY’S HOUSE','HARRY STYLES',919.00,'https://picsum.photos/seed/popstar-nuevo-18/600/600',5,'2026-11-04 22:03:24',1),(139,'afrodisiaco-rauw-alejandro','AFRODISIACO','RAUW ALEJANDRO',962.00,'https://picsum.photos/seed/popstar-nuevo-19/600/600',5,'2026-11-04 22:03:24',1),(140,'safari-j-balvin','SAFARI','J BALVIN',1005.00,'https://picsum.photos/seed/popstar-nuevo-20/600/600',4,'2026-11-04 22:03:24',1);
/*!40000 ALTER TABLE `catalogo_discos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mensajes_contacto`
--

DROP TABLE IF EXISTS `mensajes_contacto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mensajes_contacto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `correo` varchar(254) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensajes_contacto`
--

LOCK TABLES `mensajes_contacto` WRITE;
/*!40000 ALTER TABLE `mensajes_contacto` DISABLE KEYS */;
/*!40000 ALTER TABLE `mensajes_contacto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordenes`
--

DROP TABLE IF EXISTS `ordenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordenes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) unsigned DEFAULT NULL,
  `subtotal` decimal(10,2) unsigned NOT NULL,
  `descuento` decimal(10,2) unsigned NOT NULL DEFAULT 0.00,
  `envio` decimal(10,2) unsigned NOT NULL,
  `total` decimal(10,2) unsigned NOT NULL,
  `estado` varchar(30) NOT NULL DEFAULT 'confirmado_demo',
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `ordenes_usuario_fecha` (`usuario_id`,`creado_en`),
  CONSTRAINT `ordenes_usuario_fk` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_popstar` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordenes`
--

LOCK TABLES `ordenes` WRITE;
/*!40000 ALTER TABLE `ordenes` DISABLE KEYS */;
INSERT INTO `ordenes` VALUES (1,NULL,2050.00,0.00,120.00,2170.00,'confirmado_demo','2026-11-04 22:04:58'),(3,NULL,1005.00,100.50,120.00,1024.50,'confirmado_demo','2026-11-05 17:16:01'),(4,NULL,950.00,0.00,120.00,1070.00,'confirmado_demo','2026-11-06 00:33:59'),(5,8,990.00,99.00,120.00,1011.00,'confirmado_demo','2026-11-06 16:23:59');
/*!40000 ALTER TABLE `ordenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordenes_discos`
--

DROP TABLE IF EXISTS `ordenes_discos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordenes_discos` (
  `orden_id` bigint(20) unsigned NOT NULL,
  `disco_id` int(10) unsigned NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `artista` varchar(200) NOT NULL,
  `precio_unitario` decimal(10,2) unsigned NOT NULL,
  `cantidad` int(10) unsigned NOT NULL,
  PRIMARY KEY (`orden_id`,`disco_id`),
  KEY `ordenes_discos_disco_fk` (`disco_id`),
  CONSTRAINT `ordenes_discos_disco_fk` FOREIGN KEY (`disco_id`) REFERENCES `catalogo_discos` (`id`),
  CONSTRAINT `ordenes_discos_orden_fk` FOREIGN KEY (`orden_id`) REFERENCES `ordenes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordenes_discos`
--

LOCK TABLES `ordenes_discos` WRITE;
/*!40000 ALTER TABLE `ordenes_discos` DISABLE KEYS */;
INSERT INTO `ordenes_discos` VALUES (1,9,'THRILLER','MICHAEL JACKSON',950.00,1),(1,10,'THE DARK SIDE OF THE MOON','PINK FLOYD',1100.00,1),(3,140,'SAFARI','J BALVIN',1005.00,1),(4,9,'THRILLER','MICHAEL JACKSON',950.00,1),(5,4,'ABBEY ROAD','THE BEATLES',990.00,1);
/*!40000 ALTER TABLE `ordenes_discos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resultados_quiz`
--

DROP TABLE IF EXISTS `resultados_quiz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resultados_quiz` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) unsigned NOT NULL,
  `perfil` varchar(30) NOT NULL,
  `respuestas_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`respuestas_json`)),
  `realizado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `resultados_quiz_usuario_fecha` (`usuario_id`,`realizado_en`),
  CONSTRAINT `resultados_quiz_usuario_fk` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_popstar` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resultados_quiz`
--

LOCK TABLES `resultados_quiz` WRITE;
/*!40000 ALTER TABLE `resultados_quiz` DISABLE KEYS */;
/*!40000 ALTER TABLE `resultados_quiz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_popstar`
--

DROP TABLE IF EXISTS `usuarios_popstar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_popstar` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `correo` varchar(254) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
  `contrasena_hash` varchar(255) NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `acepta_promociones` tinyint(1) NOT NULL DEFAULT 0,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `rol` enum('cliente','empleado','administrador') NOT NULL DEFAULT 'cliente',
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuarios_popstar_correo_unico` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_popstar`
--

LOCK TABLES `usuarios_popstar` WRITE;
/*!40000 ALTER TABLE `usuarios_popstar` DISABLE KEYS */;
INSERT INTO `usuarios_popstar` VALUES (7,'admin','admin@gmail.com','$2y$10$3ZDGD56Zd6Xeg31bc8KSt.Cr4dF7.F3WymXWkUNk2/fVjiqaG9Lfa',NULL,1,'2026-11-06 16:20:08','administrador'),(8,'irvin','correodeprueba@gmail.com','$2y$10$VEmZSI9rfONXfnmDWDVIc.N3WymaYVhj.vfAnxHQINR7OjUpRHukq',NULL,1,'2026-11-06 16:22:51','cliente');
/*!40000 ALTER TABLE `usuarios_popstar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'popstar'
--

--
-- Dumping routines for database 'popstar'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-12 17:24:52
