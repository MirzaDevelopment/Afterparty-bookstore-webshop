-- MySQL dump 10.13  Distrib 8.0.23, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: books_afterparty_git
-- ------------------------------------------------------
-- Server version	5.7.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adm_units`
--

DROP TABLE IF EXISTS `adm_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adm_units` (
  `adm_unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`adm_unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_units`
--

LOCK TABLES `adm_units` WRITE;
/*!40000 ALTER TABLE `adm_units` DISABLE KEYS */;
INSERT INTO `adm_units` VALUES (1,'Unsko-sanski kanton'),(2,'Posavski kanton'),(3,'Tuzlanski kanton'),(4,'Zeničko-dobojski kanton'),(5,'Bosansko-podrinjski kanton'),(6,'Srednjobosanski kanton'),(7,'Hercegovačko-neretvanski kanton'),(8,'Zapadnohercegovački kanton'),(9,'Kanton Sarajevo'),(10,'Kanton 10');
/*!40000 ALTER TABLE `adm_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_category`
--

DROP TABLE IF EXISTS `book_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book_category` (
  `book_category_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `book_category` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `import_time` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`book_category_id`),
  UNIQUE KEY `book_category_UNIQUE` (`book_category`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_category`
--

LOCK TABLES `book_category` WRITE;
/*!40000 ALTER TABLE `book_category` DISABLE KEYS */;
INSERT INTO `book_category` VALUES (6,'Mystery','2022-04-04 20:27:13'),(8,'Horror','2022-04-04 20:31:42'),(29,'Fashion','2022-04-05 21:19:27'),(30,'Documentaries','2022-04-05 21:27:45'),(32,'Detective','2022-04-20 21:40:18'),(34,'Cars/Motors','2022-05-16 19:34:45'),(43,'Automobili','2022-06-28 19:55:57'),(46,'Mortal','2022-07-01 23:30:51'),(49,'Teenagers','2022-09-11 19:26:43'),(50,'Lifestyle','2022-09-21 21:07:09'),(51,'Fiction','2022-10-01 11:48:43'),(52,'Thriller','2022-10-14 22:18:44'),(53,'Romance','2022-10-26 19:44:58'),(54,'Adventure','2022-11-05 15:59:41');
/*!40000 ALTER TABLE `book_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `books` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_title` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book_pic` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book_author` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book_description` varchar(420) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book_publisher` text COLLATE utf8mb4_unicode_ci,
  `book_quantity` smallint(6) DEFAULT NULL,
  `book_category_id` smallint(6) DEFAULT NULL,
  `publish_year` smallint(6) DEFAULT NULL,
  `import_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `book_modified` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT NULL,
  PRIMARY KEY (`book_id`),
  UNIQUE KEY `book_id_UNIQUE` (`book_id`),
  UNIQUE KEY `book_title_UNIQUE` (`book_title`),
  KEY `book_data` (`book_title`,`book_author`),
  KEY `fk_category_idx` (`book_category_id`),
  CONSTRAINT `fk_category` FOREIGN KEY (`book_category_id`) REFERENCES `book_category` (`book_category_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (47,'Brief history of time','<img src=\'../img/stephen(1).jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','Stephen Hawkings','Ava and Kaye used to be best friends. Until one night two years ago, vampires broke through the magical barrier protecting their town, and in the ensuing attack, Kaye’s mother was killed, and Ava was turned into a vampire. Since then, Ava has been trapped in her house. Her mother Eugenia needs her: Ava still has her witch powers, and Eugenia must take them in order to hide that she\'s a vampire...','Mladost',15,51,1986,'2022-10-30 13:22:47','2023-05-08 08:47:40','2022-10-30 08:20:07'),(48,'Lord of the rings - fellowship of the ring','<img src=\'../img/220px-LOTRTTTmovie.jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','J.K. Tolkien','Gospodar prstenova epski je fantastični roman kojeg je napisao engleski akademik i filolog J. R. R. Tolkien. Priča je započeta kao nastavak Tolkienovog ranijeg djela, Hobita, ali se razvila u mnogo veću i kompleksniju priču','Zlatno jaje',12,54,2005,'2022-10-30 13:23:30','2023-04-30 08:49:04','2023-03-14 08:17:15'),(49,'A sea of tranqulity','<img src=\'../img/tranqulity.jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','Emily St. John Mandel','A novel of art, time, love, and plague that takes the reader from Vancouver Island in 1912 to a dark colony on the moon three hundred years later, unfurling a story of humanity across centuries and space.','Moon books',43,51,2004,'2022-10-30 13:28:59','2023-04-30 08:49:04','2022-10-30 01:30:54'),(50,'Lessons in chemistry','<img src=\'../img/Chemistry(1).jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','Bonnie Garmus','Chemist Elizabeth Zott is not your average woman. In fact, Elizabeth Zott would be the first to point out that there is no such thing as an average woman. But it’s the early 1960s and her all-male team at Hastings Research Institute takes a very unscientific view of equality','Svjetlost Sarajevo',25,50,1986,'2022-10-31 18:17:44','2023-04-03 08:58:22',NULL),(51,'Harry Potter and goblet of fire','<img src=\'../img/plameni_pehar_buybook(1).jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','J.K. Rowling','Harry Potter and the Goblet of Fire is a fantasy novel written by British author J. K. Rowling and the fourth novel in the Harry Potter series. It follows Harry Potter, a wizard in his fourth year at Hogwarts School of Witchcraft and Wizardry, and the mystery surrounding the entry of Harry&#039;s name into the Triwizard Tournament, in which he is forced to compete.','Svjetlost Sarajevo',53,51,1986,'2022-10-31 18:22:39','2023-04-27 02:42:48',NULL),(52,'Young mungo','<img src=\'../img/Mungo(1).jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','Douglas Stuart','Growing up in a housing estate in Glasgow, Mungo and James are born under different stars--Mungo a Protestant and James a Catholic--and they should be sworn enemies if they&#039;re to be seen as men at all. Yet against all odds, they become best friends as they find a sanctuary in the pigeon dovecote that James has built for his prize racing birds.','England publishing',25,51,1998,'2022-11-13 13:30:32','2023-04-01 06:29:35','2023-03-14 08:17:06'),(53,'The valley of fear','<img src=\'../img/doyle(1).jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','Arthur Conan Doyle','The Valley of Fear is the fourth and final Sherlock Holmes novel by British writer Arthur Conan Doyle. It is loosely based on the Molly Maguires and Pinkerton agent James McParland. The story was first published in the Strand Magazine between September 1914 and May 1915. The first book edition was copyrighted in 1914, and it was first published by George H. Doran Company in New York.','2005',4,32,1999,'2022-11-13 13:31:55','2023-08-24 10:16:45','2023-03-24 10:49:34'),(54,'To Paradise','<img src=\'../img/To Paradise(1).jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','Hanya Yanagihara','From the author of the classic A Little Life, a bold, brilliant novel spanning three centuries and three different versions of the American experiment, about lovers, family, loss and the elusive promise of utopia.','Lastavica Sarajevo',17,32,2022,'2022-11-13 13:38:09','2023-04-30 08:47:40',NULL),(55,'The Barking book','<img src=\'../img/barkingbook(1).jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','Cristiane F. S. Pedote','In this book of poems, the author invites us to travel with her to outer, inner and secret places','Mladinska knjiga',5,8,1986,'2022-11-13 13:41:26','2023-04-07 08:13:24',NULL),(56,'Our Missing Hearts: A Novel','<img src=\'../img/celeste(1).jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','Celeste Ng','Twelve-year-old Bird Gardner lives a quiet existence with his loving but broken father, a former linguist who now shelves books in a university library. Bird knows to not ask too many questions, stand out too much, or stray too far. For a decade, their lives have been governed by laws written to preserve “American culture” in the wake of years of economic instability and violence.','Mladost Zagreb',25,53,2004,'2022-11-17 19:42:11','2023-04-01 11:47:15',NULL),(58,'Infernal machines','<img src=\'../img/9222475(1).jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','K.W. Jeter','HE INHERITED A WATCHMAKER&#039;S STORE - AND A WHOLE HEAP OF TROUBLE. But idle sometime-musician George has little talent for clockwork. And when a shadowy figure tries to steal an old device from the premises, George finds himself embroiled in a mystery of time travel, music and sexual intrigue. A genuine lost classic, a steampunk original whose time has come.','Ovo je test',25,8,2004,'2022-11-17 19:45:37','2023-04-04 08:54:42',NULL),(59,'Great Gatsby','<img src=\'../img/greatGatsby(1).jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','Scot Fitzgerald','The novel was inspired by a youthful romance Fitzgerald had with socialite Ginevra King, and the riotous parties he attended on Long Island&#039;s North Shore in 1922. Following a move to the French Riviera, Fitzgerald completed a rough draft of the novel in 1924. He submitted it to editor Maxwell Perkins, who persuaded Fitzgerald to revise the work over the following winter.','Maxwell Chronicles',25,51,2004,'2022-11-22 20:00:29','2023-03-24 10:50:49',NULL),(77,'Trust','<img src=\'../img/trust(1).jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','Hernan Diaz','Even through the roar and effervescence of the 1920s, everyone in New York has heard of Benjamin and Helen Rask. He is a legendary Wall Street tycoon; she is the daughter of eccentric aristocrats. Together, they have risen to the very top of a world of seemingly endless wealth—all as a decade of excess and speculation draws to an end.','0',52,51,2005,'2022-12-19 19:36:26','2023-04-27 02:45:39',NULL),(78,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(79,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(81,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(82,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(83,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(84,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(85,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(93,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(94,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(95,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(97,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(98,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(99,'Memoirs of a Geisha','<img src=\'../img/geisha(1).jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','Arthur Golden','In &quot;Memoirs of a Geisha,&quot; we enter a world where appearances are paramount; where a girl&#039;s virginity is auctioned to the highest bidder; where women are trained to beguile the most powerful men; and where love is scorned as illusion. It is a unique and triumphant work of fiction - at once romantic, erotic, suspenseful - and completely unforgettable.','Good Reads',25,53,2004,'2023-02-23 21:14:06','2023-04-01 11:47:46',NULL),(100,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(101,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(102,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(103,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(104,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(105,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(106,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(107,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(108,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(109,'The Witch and the Vampire','<img src=\'../img/witch(1).jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','Francesca Flores','Ava and Kaye used to be best friends. Until one night two years ago, vampires broke through the magical barrier protecting their town, and in the ensuing attack, Kaye’s mother was killed, and Ava was turned into a vampire. Since then, Ava has been trapped in her house. Her mother Eugenia needs her: Ava still has her witch powers, and Eugenia must take them in order to hide that she&#039;s a vampire...','Good Reads',37,53,2023,'2023-04-27 13:55:18','2023-04-30 08:47:40',NULL);
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deleted_books`
--

DROP TABLE IF EXISTS `deleted_books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `deleted_books` (
  `book_id` int(11) DEFAULT NULL,
  `book_title` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `book_pic` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `book_author` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `book_description` varchar(650) COLLATE utf8_unicode_ci DEFAULT NULL,
  `book_publisher` text COLLATE utf8_unicode_ci,
  `book_quantity` smallint(6) DEFAULT NULL,
  `book_category_id` smallint(6) DEFAULT NULL,
  `publish_year` smallint(6) DEFAULT NULL,
  `import_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `book_modified` datetime DEFAULT NULL,
  `delete_time` datetime DEFAULT CURRENT_TIMESTAMP,
  KEY `fk_category_del_books_idx` (`book_category_id`),
  KEY `book_data` (`book_title`,`book_author`),
  CONSTRAINT `fk_category_del_books` FOREIGN KEY (`book_category_id`) REFERENCES `book_category` (`book_category_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deleted_books`
--

LOCK TABLES `deleted_books` WRITE;
/*!40000 ALTER TABLE `deleted_books` DISABLE KEYS */;
/*!40000 ALTER TABLE `deleted_books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deleted_customers`
--

DROP TABLE IF EXISTS `deleted_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `deleted_customers` (
  `customer_id` int(11) DEFAULT NULL,
  `first_name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adress` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adm_unit_id` int(11) DEFAULT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_registered` datetime DEFAULT CURRENT_TIMESTAMP,
  KEY `fk_adm_units_del_idx` (`adm_unit_id`),
  CONSTRAINT `fk_adm_units_del` FOREIGN KEY (`adm_unit_id`) REFERENCES `adm_units` (`adm_unit_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deleted_customers`
--

LOCK TABLES `deleted_customers` WRITE;
/*!40000 ALTER TABLE `deleted_customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `deleted_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deleted_prices`
--

DROP TABLE IF EXISTS `deleted_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `deleted_prices` (
  `price_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `book_price` decimal(5,2) DEFAULT NULL,
  `discount` decimal(10,0) DEFAULT NULL,
  `discounted_price` decimal(5,2) DEFAULT NULL,
  `regular_price_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `regular_price_modified` datetime DEFAULT NULL,
  `discount_price_time` datetime DEFAULT NULL,
  `discount_price_end` datetime DEFAULT NULL,
  KEY `fk_pricing_books_del_idx` (`book_id`),
  CONSTRAINT `fk_pricing_books_del` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deleted_prices`
--

LOCK TABLES `deleted_prices` WRITE;
/*!40000 ALTER TABLE `deleted_prices` DISABLE KEYS */;
/*!40000 ALTER TABLE `deleted_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deleted_transactions`
--

DROP TABLE IF EXISTS `deleted_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `deleted_transactions` (
  `transaction_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `book_quantity` smallint(6) DEFAULT NULL,
  `transaction_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `transaction_status` enum('finished') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_end` datetime DEFAULT NULL,
  `transaction_price` decimal(5,2) DEFAULT NULL,
  KEY `fk_books_idx` (`book_id`),
  KEY `fk_customers_del_idx` (`customer_id`),
  CONSTRAINT `fk_books_del` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_customers_del` FOREIGN KEY (`customer_id`) REFERENCES `users_customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deleted_transactions`
--

LOCK TABLES `deleted_transactions` WRITE;
/*!40000 ALTER TABLE `deleted_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `deleted_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `incomechart`
--

DROP TABLE IF EXISTS `incomechart`;
/*!50001 DROP VIEW IF EXISTS `incomechart`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `incomechart` AS SELECT 
 1 AS `Income`,
 1 AS `date`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `ip_security`
--

DROP TABLE IF EXISTS `ip_security`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ip_security` (
  `ip_id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_adress` varchar(45) DEFAULT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ip_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ip_security`
--

LOCK TABLES `ip_security` WRITE;
/*!40000 ALTER TABLE `ip_security` DISABLE KEYS */;
/*!40000 ALTER TABLE `ip_security` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pricing`
--

DROP TABLE IF EXISTS `pricing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pricing` (
  `price_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL,
  `book_price` decimal(5,2) DEFAULT NULL,
  `discount` decimal(10,0) DEFAULT NULL,
  `discounted_price` decimal(5,2) DEFAULT NULL,
  `regular_price_time` datetime DEFAULT NULL,
  `regular_price_modified` datetime DEFAULT NULL,
  `discount_price_time` datetime DEFAULT NULL,
  `discount_price_end` datetime DEFAULT NULL,
  PRIMARY KEY (`price_id`),
  UNIQUE KEY `price_id_UNIQUE` (`price_id`),
  UNIQUE KEY `book_id_UNIQUE` (`book_id`),
  KEY `fk_data` (`book_price`,`discount`,`discounted_price`),
  CONSTRAINT `fk_pricing` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pricing`
--

LOCK TABLES `pricing` WRITE;
/*!40000 ALTER TABLE `pricing` DISABLE KEYS */;
INSERT INTO `pricing` VALUES (39,47,45.00,90,4.50,NULL,'2022-10-31 06:16:08','2023-02-02 09:25:30','2023-02-02 09:25:12'),(40,48,35.00,NULL,NULL,NULL,'2022-10-30 01:27:14',NULL,NULL),(41,49,8.66,NULL,NULL,NULL,NULL,'2022-11-04 09:45:02','2022-11-17 09:25:06'),(42,50,18.00,NULL,NULL,NULL,NULL,'2022-11-30 08:49:16','2022-12-04 02:46:30'),(43,51,14.00,NULL,NULL,NULL,'2022-11-04 09:22:00','2022-12-30 09:17:12','2023-01-03 01:09:03'),(44,52,25.00,NULL,NULL,NULL,NULL,'2022-11-22 08:45:50','2022-11-22 08:46:25'),(45,53,14.99,25,11.24,NULL,NULL,'2023-01-08 01:06:31','2022-11-27 12:34:54'),(46,54,14.99,NULL,NULL,NULL,'2022-11-22 08:36:08','2022-12-08 09:36:57','2022-12-11 12:32:48'),(47,55,4.99,NULL,NULL,NULL,NULL,'2022-11-30 08:46:36','2022-11-30 08:47:06'),(48,56,4.25,50,2.13,NULL,NULL,'2023-03-02 09:30:23','2023-03-02 09:30:13'),(50,58,25.00,NULL,NULL,NULL,NULL,NULL,NULL),(51,59,15.00,NULL,NULL,NULL,NULL,'2023-01-03 01:12:30','2023-01-08 01:06:15'),(69,77,25.00,NULL,NULL,NULL,NULL,'2023-01-03 01:11:57','2023-01-03 01:12:46'),(70,78,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(71,79,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(73,81,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(74,82,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(75,83,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(76,84,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(77,85,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(84,93,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(85,94,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(86,95,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(87,97,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(88,98,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(89,99,45.00,NULL,NULL,NULL,NULL,NULL,NULL),(90,100,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(91,101,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(92,102,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(93,103,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(94,104,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(95,105,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(96,106,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(97,107,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(98,108,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(99,109,14.95,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `pricing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `quantitychart`
--

DROP TABLE IF EXISTS `quantitychart`;
/*!50001 DROP VIEW IF EXISTS `quantitychart`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `quantitychart` AS SELECT 
 1 AS `Quantity`,
 1 AS `date`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questions` (
  `questions_id` int(11) NOT NULL AUTO_INCREMENT,
  `questions_user_name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `questions_body` varchar(650) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `questions_email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `questions_status` enum('unanswered','answered') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `questions_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`questions_id`),
  UNIQUE KEY `questions_body_UNIQUE` (`questions_body`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `searchtransactions`
--

DROP TABLE IF EXISTS `searchtransactions`;
/*!50001 DROP VIEW IF EXISTS `searchtransactions`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `searchtransactions` AS SELECT 
 1 AS `transaction_id`,
 1 AS `book_title`,
 1 AS `book_author`,
 1 AS `book_price`,
 1 AS `discounted_price`,
 1 AS `book_quantity`,
 1 AS `transaction_date`,
 1 AS `email`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `slider`
--

DROP TABLE IF EXISTS `slider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `slider` (
  `slider_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL,
  `book_title` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book_pic` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book_author` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` enum('1','2','3') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`slider_id`),
  UNIQUE KEY `slider_id_UNIQUE` (`slider_id`),
  KEY `fk_slider_book_idx` (`book_id`),
  CONSTRAINT `fk_slider_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slider`
--

LOCK TABLES `slider` WRITE;
/*!40000 ALTER TABLE `slider` DISABLE KEYS */;
INSERT INTO `slider` VALUES (5,109,'The Witch and the Vampire','<img src=\'../img/witch(1).jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','Francesca Flores','1'),(8,56,'Our Missing Hearts: A Novel','<img src=\'../img/celeste(1).jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','Celeste Ng','2'),(9,99,'Memoirs of a Geisha','<img src=\'../img/geisha(1).jpg\'alt=\'book image\' width=\'200\' height=\'300\'>','Arthur Golden','3');
/*!40000 ALTER TABLE `slider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `statisticforuser`
--

DROP TABLE IF EXISTS `statisticforuser`;
/*!50001 DROP VIEW IF EXISTS `statisticforuser`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `statisticforuser` AS SELECT 
 1 AS `book_id`,
 1 AS `book_title`,
 1 AS `book_author`,
 1 AS `book_pic`,
 1 AS `email`,
 1 AS `book_price`,
 1 AS `discounted_price`,
 1 AS `QUANTITY_TOTAL`,
 1 AS `transaction_time`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `topbooks`
--

DROP TABLE IF EXISTS `topbooks`;
/*!50001 DROP VIEW IF EXISTS `topbooks`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `topbooks` AS SELECT 
 1 AS `transaction_id`,
 1 AS `book_id`,
 1 AS `book_title`,
 1 AS `book_author`,
 1 AS `book_price`,
 1 AS `discounted_price`,
 1 AS `QUANTITY_TOTAL`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `topbuyers`
--

DROP TABLE IF EXISTS `topbuyers`;
/*!50001 DROP VIEW IF EXISTS `topbuyers`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `topbuyers` AS SELECT 
 1 AS `first_name`,
 1 AS `last_name`,
 1 AS `Customer_Mail`,
 1 AS `Income`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `book_quantity` smallint(6) DEFAULT NULL,
  `transaction_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `transaction_status` enum('finished','pending') COLLATE utf8_unicode_ci DEFAULT NULL,
  `transaction_end` datetime DEFAULT NULL,
  `transaction_price` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `fk_status_idx` (`transaction_status`),
  KEY `fk_users_idx` (`customer_id`),
  KEY `fk_books_idx` (`book_id`),
  KEY `fk_status` (`transaction_status`),
  CONSTRAINT `fk_books` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_users` FOREIGN KEY (`customer_id`) REFERENCES `users_customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_status`
--

DROP TABLE IF EXISTS `user_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_status` (
  `user_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `roles` enum('super admin','admin','user','customer') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_status`
--

LOCK TABLES `user_status` WRITE;
/*!40000 ALTER TABLE `user_status` DISABLE KEYS */;
INSERT INTO `user_status` VALUES (1,'super admin'),(2,'admin'),(3,'user');
/*!40000 ALTER TABLE `user_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` char(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) DEFAULT NULL,
  `user_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `user_name_UNIQUE` (`user_name`),
  KEY `FK_STATUS_idx` (`status`),
  KEY `fk_data` (`first_name`,`last_name`,`user_name`),
  CONSTRAINT `FK_user_status` FOREIGN KEY (`status`) REFERENCES `user_status` (`user_status_id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Mirza','Mehagić','SuperAdmin','superadmin@gmail.com','$2y$10$.X4zRxBCNJbrRI8liIcqtOGLqDs/FPhkKPoI/v3PHBiVI/2HIy5ym',1,'2022-01-04 20:49:59','2023-09-08 10:44:40');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_customers`
--

DROP TABLE IF EXISTS `users_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adress` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adm_unit_id` int(11) DEFAULT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_registered` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`customer_id`),
  KEY `FK_adm_units_idx` (`adm_unit_id`),
  KEY `fk_data` (`email`,`first_name`,`last_name`),
  CONSTRAINT `FK_adm_units` FOREIGN KEY (`adm_unit_id`) REFERENCES `adm_units` (`adm_unit_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=315 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_customers`
--

LOCK TABLES `users_customers` WRITE;
/*!40000 ALTER TABLE `users_customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'books_afterparty_git'
--
/*!50003 DROP PROCEDURE IF EXISTS `deleteBookRow` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `deleteBookRow`(newId INT(11))
BEGIN
DELETE FROM books_afterparty.books WHERE books.book_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `deleteCategory` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `deleteCategory`(newCategory varchar (45) )
BEGIN
DELETE FROM books_afterparty.book_category WHERE book_category.book_category=newCategory;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `deleteCustomer` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `deleteCustomer`(newId int(11))
BEGIN
DELETE FROM books_afterparty.users_customers WHERE users_customers.customer_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `deleteCustomerFailed` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `deleteCustomerFailed`(customerId int(11))
BEGIN
DELETE FROM books_afterparty.users_customers WHERE users_customers.customer_id=customerId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `deleteDiscount` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `deleteDiscount`(newDiscount decimal(10,0), newDiscountedPrice decimal(5,2), discountTimeEnd datetime, bookId int(11))
BEGIN
UPDATE books_afterparty.pricing SET discount=newDiscount, discounted_price=newDiscountedPrice, discount_price_end=discountTimeEnd WHERE pricing.book_id=bookId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `deleteQuestions` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `deleteQuestions`(idQuestion INT(11))
BEGIN
DELETE FROM books_afterparty.questions WHERE questions.questions_id=idQuestion;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `deleteRestored` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `deleteRestored`(newId INT(11))
BEGIN
DELETE from deleted_transactions WHERE deleted_transactions.transaction_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `deleteRestoredBooks` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `deleteRestoredBooks`(deletedRestoreId INT(11))
BEGIN
DELETE from deleted_books WHERE deleted_books.book_id=deletedRestoreId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `deleteRestoredCust` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `deleteRestoredCust`(custId INT (11))
BEGIN
DELETE from deleted_customers WHERE deleted_customers.customer_id=custId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `deleteRestoredPrices` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `deleteRestoredPrices`(deletedRestoreId INT(11))
BEGIN
DELETE from deleted_prices WHERE deleted_prices.book_id=deletedRestoreId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `deleteSlider` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `deleteSlider`(newId INT(11))
BEGIN
UPDATE books_afterparty.slider SET book_id=null, book_title=null, book_pic=null, book_author=null WHERE book_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `deleteUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `deleteUser`(userId int(11))
BEGIN
DELETE FROM books_afterparty.users WHERE users.user_id=userId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `delIp` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `delIp`(newIp varchar(45))
BEGIN
DELETE FROM books_afterparty.ip_security WHERE ip_adress=newIp AND timestamp > (now() - interval 10 minute);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insertBooks` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `insertBooks`(newTitle varchar(45), newPic varchar(100), newAuthor varchar (45), newDesc varchar(650), newPublisher TEXT, newQuantity smallint(6), newCategory smallint (11), newYear smallint(6))
BEGIN
INSERT INTO books_afterparty.books (book_title, book_pic, book_author, book_description, book_publisher, book_quantity, book_category_id, publish_year) VALUES (newTitle,  newPic, newAuthor, newDesc, newPublisher, newQuantity, newCategory, newYear);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insertCategory` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `insertCategory`(newCategory varchar(45))
BEGIN
INSERT INTO books_afterparty.book_category (book_category) VALUES (newCategory);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insertCustomer` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `insertCustomer`(firstName varchar (45), lastName varchar (45), email varchar(50), adress varchar (45), postalCode varchar (45), city varchar (45), admUnitId int(11), phoneNumber varchar (15))
BEGIN
INSERT INTO books_afterparty.users_customers (first_name, last_name, email, adress, postal_code, city, adm_unit_id, phone_number) VALUES (firstName, lastName, email, adress, postalCode, city, admUnitId, phoneNumber);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insertDelBooks` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `insertDelBooks`(delBooksId INT(11))
BEGIN
INSERT INTO books_afterparty.deleted_books SELECT book_id, book_title, book_pic, book_author, book_description, book_publisher, book_quantity, book_category_id, publish_year, import_time, book_modified, delete_time FROM books_afterparty.books WHERE books_afterparty.books.book_id=delBooksId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insertDelCust` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `insertDelCust`(customerId INT(11))
BEGIN
INSERT INTO books_afterparty.deleted_customers SELECT customer_id, first_name, last_name, email, adress, postal_code, city, adm_unit_id, phone_number, transaction_registered from books_afterparty.users_customers WHERE books_afterparty.users_customers.customer_id =customerId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insertDelPrices` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `insertDelPrices`(delBooksId INT(11))
BEGIN
INSERT INTO books_afterparty.deleted_prices SELECT price_id, book_id, book_price, discount, discounted_price, regular_price_time, regular_price_modified, discount_price_time, discount_price_end FROM books_afterparty.pricing WHERE books_afterparty.pricing.book_id=delBooksId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insertDelTrans` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `insertDelTrans`(transactionId INT(11), newStatus ENUM('finished', 'pending'))
BEGIN
INSERT INTO books_afterparty.deleted_transactions SELECT transaction_id, book_id, customer_id, book_quantity, transaction_date, transaction_status, transaction_end, transaction_price from books_afterparty.transactions WHERE books_afterparty.transactions.transaction_id =transactionId AND transactions.transaction_status=newStatus;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insertIp` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `insertIp`(newIp VARCHAR(45))
BEGIN
INSERT INTO ip_security (ip_adress) VALUES  (newIp);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insertPrice` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `insertPrice`(newPrice Decimal(5,2), bookId INT(11))
BEGIN
INSERT INTO books_afterparty.pricing (book_price, book_id)  VALUES (newPrice, bookId);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insertQuestion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `insertQuestion`(name varchar (45), body varchar (650), questionEmail varchar (50), questionStatus ENUM('unanswered', 'answered'))
BEGIN
INSERT INTO books_afterparty.questions (questions_user_name, questions_body, questions_email, questions_status) VALUES (name, body, questionEmail, questionStatus);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insertTransaction` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `insertTransaction`(bookId INT(11), customerId INT(11), bookQuantity SMALLINT(6), transactionStatus ENUM('finished', 'pending', 'failed'), transactionPrice DECIMAL(5,2))
BEGIN
INSERT INTO books_afterparty.transactions (book_id, customer_id, book_quantity, transaction_status, transaction_price) VALUES (bookId, customerId , bookQuantity, transactionStatus, transactionPrice);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insertUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `insertUser`(firstName varchar (45), lastName varchar (45), userName varchar (45), email varchar (50), password char (60), status int(11))
BEGIN
INSERT INTO books_afterparty.users (first_name, last_name, user_name, email, password, status) VALUES (firstName, lastName, userName, email, password, status);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `restoreBooks` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `restoreBooks`(restoreBookId INT(11))
BEGIN
UPDATE books_afterparty.books, books_afterparty.deleted_books SET books.book_title=deleted_books.book_title, books.book_pic=deleted_books.book_pic, books.book_author=deleted_books.book_author, books.book_description=deleted_books.book_description, books.book_publisher=deleted_books.book_publisher, books.book_quantity=deleted_books.book_quantity, books.book_category_id=deleted_books.book_category_id, books.publish_year=deleted_books.publish_year, books.import_time=deleted_books.import_time, books.book_modified=deleted_books.book_modified, books.delete_time=deleted_books.delete_time WHERE books.book_id=restoreBookId AND deleted_books.book_id=restoreBookId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `restoreCust` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `restoreCust`(custId INT(11))
BEGIN
UPDATE books_afterparty.users_customers, books_afterparty.deleted_customers SET users_customers.first_name=deleted_customers.first_name, users_customers.last_name=deleted_customers.last_name, users_customers.email=deleted_customers.email, users_customers.adress=deleted_customers.adress, users_customers.postal_code=deleted_customers.postal_code, users_customers.city=deleted_customers.city, users_customers.adm_unit_id=deleted_customers.adm_unit_id, users_customers.phone_number=deleted_customers.phone_number, users_customers.transaction_registered=deleted_customers.transaction_registered WHERE users_customers.customer_id=custId and deleted_customers.customer_id=custId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `restorePrices` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `restorePrices`(restoreBookId INT(11))
BEGIN
UPDATE books_afterparty.pricing, books_afterparty.deleted_prices SET pricing.book_price=deleted_prices.book_price, pricing.discount=deleted_prices.discount, pricing.discounted_price=deleted_prices.discounted_price, pricing.regular_price_time=deleted_prices.regular_price_time, pricing.regular_price_modified=deleted_prices.regular_price_modified, pricing.discount_price_time=deleted_prices.discount_price_time, pricing.discount_price_end=deleted_prices.discount_price_end WHERE pricing.book_id=restoreBookId AND deleted_prices.book_id=restoreBookId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `restoreTrans` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `restoreTrans`(newId INT(11))
BEGIN
UPDATE books_afterparty.transactions, books_afterparty.deleted_transactions SET transactions.book_id=deleted_transactions.book_id, transactions.customer_id=deleted_transactions.customer_id, transactions.book_quantity=deleted_transactions.book_quantity, transactions.transaction_date=deleted_transactions.transaction_date, transactions.transaction_status=deleted_transactions.transaction_status, transactions.transaction_end=deleted_transactions.transaction_end, transactions.transaction_price=deleted_transactions.transaction_price WHERE transactions.transaction_id=newId and deleted_transactions.transaction_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateAll` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateAll`(newId int(11), newTitle varchar(45), newPic varchar(100), newAuthor varchar (45), newDesc varchar(650), newPublisher TEXT, newQuantity smallint(6), newYear smallint(6), bookModified DATETIME)
BEGIN
UPDATE books_afterparty.books SET book_title=newTitle, book_pic=newPic, book_author=newAuthor,  book_description=newDesc, book_publisher=newPublisher, book_quantity=newQuantity, publish_year=newYear, book_modified=bookModified WHERE books.book_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateAllByUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateAllByUser`(firstName varchar (45), lastName varchar(45), userModified DATETIME, userName varchar(45))
BEGIN
UPDATE books_afterparty.users SET first_name=firstName, last_name=lastName, user_modified=userModified WHERE users.user_name=userName;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateAuthor` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateAuthor`(newAuthor varchar(45), newId int(11), bookModified DATETIME)
BEGIN
UPDATE books_afterparty.books SET book_author=newAuthor, book_modified=bookModified WHERE books.book_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateBooksNull` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateBooksNull`(delBooksId INT(11))
BEGIN
UPDATE books_afterparty.books SET book_title=null, book_pic=null, book_author=null, book_description=null, book_publisher=null, book_quantity=null, book_category_id=null, publish_year=null, import_time=null, book_modified=null, delete_time=null WHERE book_id=delBooksId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateCategory` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateCategory`(newCategoryId smallInt(6), newId int(11), bookModified DATETIME)
BEGIN
UPDATE books_afterparty.books SET book_category_id=newCategoryId, book_modified=bookModified WHERE books.book_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateCustNull` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateCustNull`(customerId INT(11))
BEGIN
UPDATE books_afterparty.users_customers SET first_name=null, last_name=null, email=null, adress=null, postal_code=null, city=null, adm_unit_id=null, phone_number=null, transaction_registered=null WHERE books_afterparty.users_customers.customer_id=customerId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateDelDate` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateDelDate`(delBookId INT(11), bookDeleted DATETIME)
BEGIN
UPDATE books_afterparty.books SET delete_time=bookDeleted WHERE books.book_id=delBookId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateDesc` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateDesc`(newDesc varchar(650), newId int(11), bookModified DATETIME)
BEGIN
UPDATE books_afterparty.books SET book_description=newDesc, book_modified=bookModified WHERE books.book_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateDiscount` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateDiscount`(newDiscountPrice DECIMAL(5,2), newId int(11))
BEGIN
UPDATE books_afterparty.pricing SET discounted_price=newDiscountPrice WHERE books_afterparty.pricing.book_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateDiscountPrecentage` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateDiscountPrecentage`(newDiscountPrec DECIMAL(10,0), newID INT(11), newDiscountTime DATETIME)
BEGIN
UPDATE books_afterparty.pricing SET discount=newDiscountPrec, discount_price_time=newDiscountTime WHERE books_afterparty.pricing.book_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateFirstName` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateFirstName`(firstName varchar (45), userModified DATETIME, userId int(11))
BEGIN
UPDATE books_afterparty.users SET first_name=firstName, user_modified=userModified WHERE users.user_id=userId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateFirstNameByUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateFirstNameByUser`(firstName varchar(45), userModified DATETIME, userName varchar(45))
BEGIN
UPDATE books_afterparty.users SET first_name=firstName, user_modified=userModified WHERE users.user_name=userName;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateLastName` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateLastName`(lastName varchar(45), userModfied Datetime, userId int(11))
BEGIN
UPDATE books_afterparty.users SET last_name=lastName, user_modified=userModfied WHERE users.user_id=userId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateLastNameByUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateLastNameByUser`(lastName varchar(45), userModified DATETIME, userName varchar(45))
BEGIN
UPDATE books_afterparty.users SET last_name=lastName, user_modified=userModified WHERE users.user_name=userName;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updatePic` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updatePic`(newPic varchar(100), newId int(11), bookModified DATETIME)
BEGIN
UPDATE books_afterparty.books SET book_pic=newPic, book_modified=bookModified WHERE books.book_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updatePrice` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updatePrice`(newPrice DECIMAL(5,2), newId int(11), bookModified DATETIME)
BEGIN
UPDATE books_afterparty.pricing SET pricing.book_price=newPrice, regular_price_modified=bookModified WHERE pricing.book_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updatePricesNull` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updatePricesNull`(delBooksId INT(11))
BEGIN
UPDATE books_afterparty.pricing SET book_price=null, discount=null, discounted_price=null, regular_price_time=null, regular_price_modified=null, discount_price_time=null, discount_price_end=null WHERE books_afterparty.pricing.book_id=delBooksId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updatePublisher` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updatePublisher`(newPublisher TEXT, newId int(11), bookModified DATETIME)
BEGIN
UPDATE books_afterparty.books SET book_publisher=newPublisher, book_modified=bookModified WHERE books.book_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updatePublishYear` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updatePublishYear`(newPublishYear smallint(6), newId int(11), bookModified DATETIME)
BEGIN
UPDATE books_afterparty.books SET publish_year=newPublishYear, book_modified=bookModified WHERE books.book_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateQuantity` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateQuantity`(newQuantity smallint(6), newId int(11), bookModified DATETIME)
BEGIN
UPDATE books_afterparty.books SET book_quantity=newQuantity, book_modified=bookModified WHERE books.book_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateQuantityTransaction` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateQuantityTransaction`(bookId INT(11), bookQuantity smallint(6), bookModified DATETIME)
BEGIN
UPDATE books_afterparty.books SET book_quantity=bookQuantity, book_modified=bookModified WHERE books_afterparty.books.book_id=bookId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateQuestions` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateQuestions`(questionId int(11))
BEGIN
UPDATE books_afterparty.questions SET questions_status='answered' WHERE questions.questions_id=questionId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateSlider` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateSlider`(newPosition ENUM('1','2','3'), newId INT(11))
BEGIN
UPDATE books_afterparty.slider, books_afterparty.books SET slider.book_id=books.book_id, slider.book_title=books.book_title, slider.book_pic=books.book_pic, slider.book_author=books.book_author WHERE slider.position=newPosition AND books.book_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateTitle` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateTitle`(newTitle varchar(45), newId int(11), bookModified DATETIME)
BEGIN
UPDATE books_afterparty.books SET book_title=newTitle, book_modified=bookModified WHERE books.book_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateTransFinished` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateTransFinished`(newId INT(11), newStatus ENUM('finished', 'pending'), transactionEnd DATETIME)
BEGIN
UPDATE books_afterparty.transactions SET transaction_status=newStatus, transaction_end=transactionEnd WHERE transactions.transaction_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateTransNull` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateTransNull`(transId INT(11), newStatus ENUM('finished', 'pending'))
BEGIN
UPDATE books_afterparty.transactions SET book_id=null, customer_id=null, book_quantity=null, transaction_date=null, transaction_status=null, transaction_end=null, transaction_price=null WHERE transaction_id=transId AND transactions.transaction_status=newStatus;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateTransPending` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateTransPending`(newId INT(11), newStatus ENUM('finished', 'pending'), transactionEnd DATETIME)
BEGIN
UPDATE books_afterparty.transactions SET transaction_status=newStatus, transaction_end=transactionEnd WHERE transactions.transaction_id=newId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateUser`( userId int(11), firstName varchar(45), lastName varchar(45), userEmail varchar(50),  userStatus int(11), userModified datetime)
BEGIN
UPDATE books_afterparty.users SET first_name=firstName, last_name=lastName,  email=userEmail, status=userStatus, user_modified=userModified WHERE users.user_id=userId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateUserEmail` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateUserEmail`(userEmail varchar(50), userModfied Datetime, userId int(11))
BEGIN
UPDATE books_afterparty.users SET email=userEmail, user_modified=userModfied WHERE users.user_id=userId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `updateUserStatus` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Superadmin`@`localhost` PROCEDURE `updateUserStatus`(userStatus int(11), userModified DATETIME, userId int(11))
BEGIN
UPDATE books_afterparty.users SET status=userStatus, user_modified=userModified WHERE users.user_id=userId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `incomechart`
--

/*!50001 DROP VIEW IF EXISTS `incomechart`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`Superadmin`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `incomechart` AS select sum((`transactions`.`transaction_price` * `transactions`.`book_quantity`)) AS `Income`,cast(`transactions`.`transaction_date` as date) AS `date` from ((`transactions` join `books` on((`books`.`book_id` = `transactions`.`book_id`))) join `pricing` on((`books`.`book_id` = `pricing`.`book_id`))) group by cast(`transactions`.`transaction_date` as date) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `quantitychart`
--

/*!50001 DROP VIEW IF EXISTS `quantitychart`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`Superadmin`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `quantitychart` AS select sum(`transactions`.`book_quantity`) AS `Quantity`,cast(`transactions`.`transaction_date` as date) AS `date` from `transactions` where (`transactions`.`book_quantity` is not null) group by cast(`transactions`.`transaction_date` as date) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `searchtransactions`
--

/*!50001 DROP VIEW IF EXISTS `searchtransactions`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`Superadmin`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `searchtransactions` AS select `transactions`.`transaction_id` AS `transaction_id`,`books`.`book_title` AS `book_title`,`books`.`book_author` AS `book_author`,`pricing`.`book_price` AS `book_price`,`pricing`.`discounted_price` AS `discounted_price`,`transactions`.`book_quantity` AS `book_quantity`,`transactions`.`transaction_date` AS `transaction_date`,`users_customers`.`email` AS `email` from (((`transactions` join `books` on((`books`.`book_id` = `transactions`.`book_id`))) join `users_customers` on((`transactions`.`customer_id` = `users_customers`.`customer_id`))) join `pricing` on((`books`.`book_id` = `pricing`.`book_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `statisticforuser`
--

/*!50001 DROP VIEW IF EXISTS `statisticforuser`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`Superadmin`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `statisticforuser` AS select `transactions`.`book_id` AS `book_id`,`books`.`book_title` AS `book_title`,`books`.`book_author` AS `book_author`,`books`.`book_pic` AS `book_pic`,`users_customers`.`email` AS `email`,`pricing`.`book_price` AS `book_price`,`pricing`.`discounted_price` AS `discounted_price`,sum(`transactions`.`book_quantity`) AS `QUANTITY_TOTAL`,group_concat(distinct `transactions`.`transaction_date` separator ',') AS `transaction_time` from (((`transactions` join `books` on((`books`.`book_id` = `transactions`.`book_id`))) join `users_customers` on((`transactions`.`customer_id` = `users_customers`.`customer_id`))) join `pricing` on((`books`.`book_id` = `pricing`.`book_id`))) group by `books`.`book_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `topbooks`
--

/*!50001 DROP VIEW IF EXISTS `topbooks`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`Superadmin`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `topbooks` AS select `transactions`.`transaction_id` AS `transaction_id`,`books`.`book_id` AS `book_id`,`books`.`book_title` AS `book_title`,`books`.`book_author` AS `book_author`,`pricing`.`book_price` AS `book_price`,`pricing`.`discounted_price` AS `discounted_price`,sum(`transactions`.`book_quantity`) AS `QUANTITY_TOTAL` from (((`transactions` join `books` on((`books`.`book_id` = `transactions`.`book_id`))) join `users_customers` on((`transactions`.`customer_id` = `users_customers`.`customer_id`))) join `pricing` on((`books`.`book_id` = `pricing`.`book_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `topbuyers`
--

/*!50001 DROP VIEW IF EXISTS `topbuyers`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`Superadmin`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `topbuyers` AS select group_concat(distinct `users_customers`.`first_name` separator ',') AS `first_name`,group_concat(distinct `users_customers`.`last_name` separator ',') AS `last_name`,concat(`users_customers`.`email`) AS `Customer_Mail`,sum((`transactions`.`transaction_price` * `transactions`.`book_quantity`)) AS `Income` from (`transactions` join `users_customers` on((`transactions`.`customer_id` = `users_customers`.`customer_id`))) group by `Customer_Mail` order by `Income` desc */;
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

-- Dump completed on 2023-09-08 23:42:15
