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
INSERT INTO `books` VALUES (47,'Brief history of time','<img src=\'../img/stephen(1).webp\'alt=\'book image\' width=\'200\' height=\'300\'>','Stephen Hawkings','Ava and Kaye used to be best friends. Until one night two years ago, vampires broke through the magical barrier protecting their town, and in the ensuing attack, Kaye’s mother was killed, and Ava was turned into a vampire. Since then, Ava has been trapped in her house. Her mother Eugenia needs her: Ava still has her witch powers, and Eugenia must take them in order to hide that she\'s a vampire...','Mladost',15,51,1986,'2022-10-30 13:22:47','2023-05-08 08:47:40','2022-10-30 08:20:07'),(48,'Lord of the rings - fellowship of the ring','<img src=\'../img/lotr.webp\'alt=\'book image\' width=\'200\' height=\'300\'>','J.K. Tolkien','Gospodar prstenova epski je fantastični roman kojeg je napisao engleski akademik i filolog J. R. R. Tolkien. Priča je započeta kao nastavak Tolkienovog ranijeg djela, Hobita, ali se razvila u mnogo veću i kompleksniju priču','Zlatno jaje',12,54,2005,'2022-10-30 13:23:30','2023-04-30 08:49:04','2023-03-14 08:17:15'),(49,'A sea of tranqulity','<img src=\'../img/tranqulity.webp\'alt=\'book image\' width=\'200\' height=\'300\'>','Emily St. John Mandel','A novel of art, time, love, and plague that takes the reader from Vancouver Island in 1912 to a dark colony on the moon three hundred years later, unfurling a story of humanity across centuries and space.','Moon books',43,51,2004,'2022-10-30 13:28:59','2023-04-30 08:49:04','2022-10-30 01:30:54'),(50,'Lessons in chemistry','<img src=\'../img/Chemistry(1).webp\'alt=\'book image\' width=\'200\' height=\'300\'>','Bonnie Garmus','Chemist Elizabeth Zott is not your average woman. In fact, Elizabeth Zott would be the first to point out that there is no such thing as an average woman. But it’s the early 1960s and her all-male team at Hastings Research Institute takes a very unscientific view of equality','Svjetlost Sarajevo',25,50,1986,'2022-10-31 18:17:44','2023-04-03 08:58:22',NULL),(51,'Harry Potter and goblet of fire','<img src=\'../img/plameni_pehar_buybook(1).webp\'alt=\'book image\' width=\'200\' height=\'300\'>','J.K. Rowling','Harry Potter and the Goblet of Fire is a fantasy novel written by British author J. K. Rowling and the fourth novel in the Harry Potter series. It follows Harry Potter, a wizard in his fourth year at Hogwarts School of Witchcraft and Wizardry, and the mystery surrounding the entry of Harry&#039;s name into the Triwizard Tournament, in which he is forced to compete.','Svjetlost Sarajevo',53,51,1986,'2022-10-31 18:22:39','2023-04-27 02:42:48',NULL),(52,'Young mungo','<img src=\'../img/Mungo(1).webp\'alt=\'book image\' width=\'200\' height=\'300\'>','Douglas Stuart','Growing up in a housing estate in Glasgow, Mungo and James are born under different stars--Mungo a Protestant and James a Catholic--and they should be sworn enemies if they&#039;re to be seen as men at all. Yet against all odds, they become best friends as they find a sanctuary in the pigeon dovecote that James has built for his prize racing birds.','England publishing',25,51,1998,'2022-11-13 13:30:32','2023-04-01 06:29:35','2023-03-14 08:17:06'),(53,'The valley of fear','<img src=\'../img/doyle(1).webp\'alt=\'book image\' width=\'200\' height=\'300\'>','Arthur Conan Doyle','The Valley of Fear is the fourth and final Sherlock Holmes novel by British writer Arthur Conan Doyle. It is loosely based on the Molly Maguires and Pinkerton agent James McParland. The story was first published in the Strand Magazine between September 1914 and May 1915. The first book edition was copyrighted in 1914, and it was first published by George H. Doran Company in New York.','2005',4,32,1999,'2022-11-13 13:31:55','2023-08-24 10:16:45','2023-03-24 10:49:34'),(54,'To Paradise','<img src=\'../img/To Paradise(1).webp\'alt=\'book image\' width=\'200\' height=\'300\'>','Hanya Yanagihara','From the author of the classic A Little Life, a bold, brilliant novel spanning three centuries and three different versions of the American experiment, about lovers, family, loss and the elusive promise of utopia.','Lastavica Sarajevo',17,32,2022,'2022-11-13 13:38:09','2023-04-30 08:47:40',NULL),(55,'The Barking book','<img src=\'../img/barkingbook(1).webp\'alt=\'book image\' width=\'200\' height=\'300\'>','Cristiane F. S. Pedote','In this book of poems, the author invites us to travel with her to outer, inner and secret places','Mladinska knjiga',5,8,1986,'2022-11-13 13:41:26','2023-04-07 08:13:24',NULL),(56,'Our Missing Hearts: A Novel','<img src=\'../img/celeste(1).webp\'alt=\'book image\' width=\'200\' height=\'300\'>','Celeste Ng','Twelve-year-old Bird Gardner lives a quiet existence with his loving but broken father, a former linguist who now shelves books in a university library. Bird knows to not ask too many questions, stand out too much, or stray too far. For a decade, their lives have been governed by laws written to preserve “American culture” in the wake of years of economic instability and violence.','Mladost Zagreb',25,53,2004,'2022-11-17 19:42:11','2023-04-01 11:47:15',NULL),(58,'Infernal machines','<img src=\'../img/9222475(1).webp\'alt=\'book image\' width=\'200\' height=\'300\'>','K.W. Jeter','HE INHERITED A WATCHMAKER&#039;S STORE - AND A WHOLE HEAP OF TROUBLE. But idle sometime-musician George has little talent for clockwork. And when a shadowy figure tries to steal an old device from the premises, George finds himself embroiled in a mystery of time travel, music and sexual intrigue. A genuine lost classic, a steampunk original whose time has come.','Ovo je test',25,8,2004,'2022-11-17 19:45:37','2023-04-04 08:54:42',NULL),(59,'Great Gatsby','<img src=\'../img/greatGatsby(1).webp\'alt=\'book image\' width=\'200\' height=\'300\'>','Scot Fitzgerald','The novel was inspired by a youthful romance Fitzgerald had with socialite Ginevra King, and the riotous parties he attended on Long Island&#039;s North Shore in 1922. Following a move to the French Riviera, Fitzgerald completed a rough draft of the novel in 1924. He submitted it to editor Maxwell Perkins, who persuaded Fitzgerald to revise the work over the following winter.','Maxwell Chronicles',25,51,2004,'2022-11-22 20:00:29','2023-03-24 10:50:49',NULL),(77,'Trust','<img src=\'../img/trust(1).webp\'alt=\'book image\' width=\'200\' height=\'300\'>','Hernan Diaz','Even through the roar and effervescence of the 1920s, everyone in New York has heard of Benjamin and Helen Rask. He is a legendary Wall Street tycoon; she is the daughter of eccentric aristocrats. Together, they have risen to the very top of a world of seemingly endless wealth—all as a decade of excess and speculation draws to an end.','0',52,51,2005,'2022-12-19 19:36:26','2023-04-27 02:45:39',NULL),(78,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(79,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(81,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(82,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(83,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(84,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(85,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(93,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(94,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(95,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(97,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(98,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(99,'Memoirs of a Geisha','<img src=\'../img/geisha(1).webp\'alt=\'book image\' width=\'200\' height=\'300\'>','Arthur Golden','In &quot;Memoirs of a Geisha,&quot; we enter a world where appearances are paramount; where a girl&#039;s virginity is auctioned to the highest bidder; where women are trained to beguile the most powerful men; and where love is scorned as illusion. It is a unique and triumphant work of fiction - at once romantic, erotic, suspenseful - and completely unforgettable.','Good Reads',25,53,2004,'2023-02-23 21:14:06','2023-04-01 11:47:46',NULL),(100,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(101,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(102,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(103,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(104,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(105,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(106,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(107,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(108,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(109,'The Witch and the Vampire','<img src=\'../img/witch(1).webp\'alt=\'book image\' width=\'200\' height=\'300\'>','Francesca Flores','Ava and Kaye used to be best friends. Until one night two years ago, vampires broke through the magical barrier protecting their town, and in the ensuing attack, Kaye’s mother was killed, and Ava was turned into a vampire. Since then, Ava has been trapped in her house. Her mother Eugenia needs her: Ava still has her witch powers, and Eugenia must take them in order to hide that she&#039;s a vampire...','Good Reads',37,53,2023,'2023-04-27 13:55:18','2023-04-30 08:47:40',NULL);
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_user_id` int(11) DEFAULT NULL,
  `comment_body` mediumtext COLLATE utf8mb4_unicode_ci,
  `comment_book_id` int(11) DEFAULT NULL,
  `comment_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `comment_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `fk_comment_user_idx` (`comment_user_id`),
  KEY `fk_comment_book_idx` (`comment_book_id`),
  FULLTEXT KEY `body_index` (`comment_body`),
  CONSTRAINT `fk_comment_book` FOREIGN KEY (`comment_book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_comment_user` FOREIGN KEY (`comment_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
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
  `book_description` mediumtext COLLATE utf8_unicode_ci,
  `book_publisher` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
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
-- Table structure for table `rating`
--

DROP TABLE IF EXISTS `rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rating` (
  `rating_id` int(11) NOT NULL AUTO_INCREMENT,
  `rating_user_id` int(11) DEFAULT NULL,
  `rating_mark` smallint(6) DEFAULT NULL,
  `rating_book_id` int(11) DEFAULT NULL,
  `rating_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rating_id`),
  KEY `fk_rating_user_idx` (`rating_user_id`),
  KEY `fk_rating_books_idx` (`rating_book_id`),
  CONSTRAINT `fk_rating_books` FOREIGN KEY (`rating_book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_rating_user` FOREIGN KEY (`rating_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rating`
--

LOCK TABLES `rating` WRITE;
/*!40000 ALTER TABLE `rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `rating` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_customers`
--

LOCK TABLES `users_customers` WRITE;
/*!40000 ALTER TABLE `users_customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_customers` ENABLE KEYS */;
UNLOCK TABLES;

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

-- Dump completed on 2023-12-30 12:25:45
