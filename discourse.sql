-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for osx10.10 (x86_64)
--
-- Host: localhost    Database: discourse
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

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
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identification` varchar(20) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'student',
  `avatar_md` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identification` (`identification`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'T202110117','Marielle Basanes','student',NULL,'marielle@example.com'),(2,'T202210202','Catalina Smith','student','/Discourse/assets/images/catalina.webp','catalina@example.com'),(3,'T202110294','Ravi Joshi','student','/Discourse/assets/images/catalina.webp','ravi@example.com'),(4,'T202008123','John Doe','student','/Discourse/assets/images/catalina.webp','john@example.com'),(5,'T202102837','Marco Torres','student','/Discourse/assets/images/catalina.webp','marco@example.com'),(6,'T202210344','Sofia Karim','student',NULL,'sofia@example.com'),(7,'T202110295','Smith Doe','student','/Discourse/assets/images/catalina.webp','smith@example.com');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `author_id` varchar(20) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `is_anonymous` tinyint(4) NOT NULL DEFAULT 0,
  `upvotes` int(11) NOT NULL DEFAULT 0,
  `downvotes` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `fk_comments_parent` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_comments_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,1,'T202210344','Sofia Karim','This is a game changer! On-device inference keeps user data private and offline.',NULL,0,15,0,'2026-06-02 02:02:08'),(2,2,'T202102837','Marco Torres','Totally agree with the points mentioned here. Looking forward to more updates.',NULL,0,10,0,'2026-06-02 02:02:08'),(3,3,'T202110294','Ravi Joshi','Mental health leaves with academic accommodations would be so helpful, especially during midterms.',NULL,0,24,0,'2026-06-02 02:02:08'),(4,4,'T202210202','Catalina Smith','Excellent writeup! Easy to follow and super insightful.',NULL,0,8,0,'2026-06-02 02:02:08'),(5,5,'T202210202','Catalina Smith','I cram the night before but always tell myself I\'ll start early next time 😂',NULL,0,32,0,'2026-06-02 02:02:08'),(6,6,'T202110294','Ravi Joshi','Hallway is always too noisy for group discussions, booking a room is definitely worth it!',NULL,0,18,0,'2026-06-02 02:02:08'),(7,5,'T202210202','Catalina Smith','test',NULL,0,0,0,'2026-06-02 02:25:16'),(8,5,'T202210202','Catalina Smith','hello workd',NULL,0,0,0,'2026-06-02 02:25:41'),(9,5,'T202210202','Catalina Smith','hello world',NULL,0,0,0,'2026-06-02 02:25:50'),(10,11,'T202210202','Catalina Smith','Great post! This is really helpful.',NULL,0,0,0,'2026-06-01 04:16:20'),(11,17,'T202110294','Ravi Joshi','Totally agree with this. The enrollment process really needs improvement.',NULL,0,0,0,'2026-05-30 04:16:20'),(12,12,'T202102837','Marco Torres','I have used the counseling service once and it was actually really good. Highly recommend.',NULL,0,0,0,'2026-06-01 16:16:20'),(13,26,'T202210344','Sofia Karim','The thesis defense tips were exactly what I needed. Thank you so much!',NULL,0,0,0,'2026-05-31 04:16:20'),(14,21,'T202110117','Marielle Basanes','React is definitely the most in-demand right now based on the job postings I have seen.',NULL,0,0,0,'2026-06-01 04:16:20');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `communities`
--

DROP TABLE IF EXISTS `communities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `communities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `theme_color` varchar(50) DEFAULT '#1A8B44',
  `icon` varchar(50) DEFAULT 'bi-cpu',
  `bg_class` varchar(50) DEFAULT 'bg-light-success',
  `text_class` varchar(50) DEFAULT 'text-success',
  `members` int(11) NOT NULL DEFAULT 1,
  `posts` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_id` varchar(20) DEFAULT NULL,
  `custom_topics` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `communities`
--

LOCK TABLES `communities` WRITE;
/*!40000 ALTER TABLE `communities` DISABLE KEYS */;
INSERT INTO `communities` VALUES (1,'FEU LIFE','Campus life, events, enrollment tips, and all things FEU Institute of Technology.','FEU TECH','#1A8B44','bi-heart-fill','bg-light-danger','text-danger',5,4,'2026-06-02 02:02:08','T202110117',NULL),(2,'FEU ALABANG LIFE','Campus life, events, enrollment tips, and all things FEU Alabang.','FEU ALABANG','#1A8B44','bi-building-fill','bg-light-warning','text-warning',3,2,'2026-06-02 02:02:08','T202110117',NULL),(3,'Freshies','A community for all the newcomers to share their thoughts and get advice.','my-communities','#1A8B44','bi-people-fill','bg-light-primary','text-primary',3,2,'2026-06-02 02:02:08','T202110117',NULL),(4,'Enrollment','Everything you need to know about enrollment in FEU Diliman.','FEU DILIMAN','#1A8B44','bi-journal-bookmark-fill','bg-light-info','text-info',4,2,'2026-06-02 02:02:08','T202110117',NULL),(5,'Cosplaying','A place for cosplayers to meet and share their passion.','FEU TECH','#1A8B44','bi-palette-fill','bg-light-info','text-info',3,3,'2026-06-02 02:02:08','T202110117',NULL),(6,'FEU TECH DEV','For aspiring developers and software engineers in FEU Tech.','FEU TECH','#1A8B44','bi-cpu','bg-light-success','text-success',5,9,'2026-06-02 02:02:08','T202110117',NULL),(7,'Food Trip Around TECH','Best spots to eat around the campus.','FEU TECH','#1A8B44','bi-cup-hot-fill','bg-light-warning','text-warning',2,2,'2026-06-02 02:02:08','T202110117',NULL),(8,'Thesis Advice','Help and resources for your final year project.','FEU DILIMAN','#1A8B44','bi-journal-bookmark-fill','bg-light-info','text-info',3,2,'2026-06-02 02:02:08','T202110117',NULL),(9,'Alabang Innovators','Tech startup and innovation community in Alabang.','FEU ALABANG','#1A8B44','bi-lightbulb-fill','bg-light-warning','text-warning',2,2,'2026-06-02 02:02:08','T202110117',NULL),(10,'Diliman Artists','Art and creative works from FEU Diliman.','FEU DILIMAN','#1A8B44','bi-palette-fill','bg-light-info','text-info',2,2,'2026-06-02 02:02:08','T202110117',NULL),(11,'Study Group','Find study partners across all campuses.','my-communities','#1A8B44','bi-people-fill','bg-light-primary','text-primary',4,2,'2026-06-02 02:02:08','T202110117',NULL),(12,'Tech Support','IT support and discussions for students.','FEU TECH','#1A8B44','bi-cpu','bg-light-success','text-success',2,2,'2026-06-02 02:02:08','T202110117',NULL),(13,'testing','test','FEU TECH','#1A8B44','bi-cpu','bg-light-success','text-success',1,0,'2026-06-02 03:57:57','T202110117',NULL),(14,'test 123','123','FEU TECH','#d63384','bi-cpu','bg-light-success','text-success',1,0,'2026-06-02 04:18:36','T202110117',NULL),(15,'scaczxcsa','123','FEU TECH','#0b5ed7','bi-cpu','bg-light-primary','text-primary',1,0,'2026-06-02 04:35:55','T202210202','');
/*!40000 ALTER TABLE `communities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `community_members`
--

DROP TABLE IF EXISTS `community_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `community_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `community_title` varchar(255) NOT NULL,
  `identification` varchar(20) NOT NULL,
  `role` enum('admin','member') NOT NULL DEFAULT 'member',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_comm` (`community_title`,`identification`),
  CONSTRAINT `fk_member_comm` FOREIGN KEY (`community_title`) REFERENCES `communities` (`title`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `community_members`
--

LOCK TABLES `community_members` WRITE;
/*!40000 ALTER TABLE `community_members` DISABLE KEYS */;
INSERT INTO `community_members` VALUES (1,'FEU LIFE','T202210202','member'),(2,'FEU TECH DEV','T202210202','member'),(8,'Study Group','T202210202','member'),(10,'FEU LIFE','T202110117','admin'),(11,'FEU LIFE','T202110294','member'),(12,'FEU LIFE','T202008123','member'),(13,'FEU LIFE','T202102837','member'),(14,'FEU ALABANG LIFE','T202110117','admin'),(15,'FEU ALABANG LIFE','T202210344','member'),(16,'FEU ALABANG LIFE','T202110295','member'),(17,'Freshies','T202110117','admin'),(18,'Freshies','T202210202','member'),(19,'Freshies','T202110294','member'),(20,'Enrollment','T202110117','admin'),(21,'Enrollment','T202008123','member'),(22,'Enrollment','T202210202','member'),(23,'Enrollment','T202102837','member'),(24,'Cosplaying','T202210202','member'),(25,'Cosplaying','T202110295','member'),(26,'Cosplaying','T202210344','member'),(27,'FEU TECH DEV','T202110117','admin'),(28,'FEU TECH DEV','T202110294','member'),(29,'FEU TECH DEV','T202102837','member'),(30,'FEU TECH DEV','T202008123','member'),(31,'Food Trip Around TECH','T202110117','admin'),(33,'Food Trip Around TECH','T202210344','member'),(34,'Thesis Advice','T202110117','admin'),(35,'Thesis Advice','T202110294','member'),(37,'Thesis Advice','T202008123','member'),(38,'Alabang Innovators','T202102837','member'),(39,'Alabang Innovators','T202110295','member'),(40,'Diliman Artists','T202210344','member'),(41,'Diliman Artists','T202110117','admin'),(42,'Study Group','T202110117','admin'),(43,'Study Group','T202110294','member'),(44,'Study Group','T202008123','member'),(45,'Tech Support','T202110117','admin'),(46,'Tech Support','T202102837','member'),(50,'test 123','T202210202','member'),(55,'testing','T202210202','member'),(56,'scaczxcsa','T202210202','admin');
/*!40000 ALTER TABLE `community_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `feedback` text NOT NULL,
  `identification` varchar(20) NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications_content`
--

DROP TABLE IF EXISTS `notifications_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identification` varchar(20) DEFAULT NULL,
  `is_global` tinyint(4) NOT NULL DEFAULT 0,
  `recipient_type` varchar(50) DEFAULT NULL,
  `application` varchar(100) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications_content`
--

LOCK TABLES `notifications_content` WRITE;
/*!40000 ALTER TABLE `notifications_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications_engagement`
--

DROP TABLE IF EXISTS `notifications_engagement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications_engagement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notifications_id` int(11) NOT NULL,
  `identification` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `notifications_id` (`notifications_id`),
  CONSTRAINT `fk_engagement_noti` FOREIGN KEY (`notifications_id`) REFERENCES `notifications_content` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications_engagement`
--

LOCK TABLES `notifications_engagement` WRITE;
/*!40000 ALTER TABLE `notifications_engagement` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications_engagement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poll_options`
--

DROP TABLE IF EXISTS `poll_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poll_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `option_text` varchar(255) NOT NULL,
  `votes` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `fk_poll_options_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poll_options`
--

LOCK TABLES `poll_options` WRITE;
/*!40000 ALTER TABLE `poll_options` DISABLE KEYS */;
INSERT INTO `poll_options` VALUES (1,5,'Start early, study consistently',124),(2,5,'Cram the night before',199),(3,5,'Rely on group chats and past papers',84),(4,5,'Pray and submit anyway',35);
/*!40000 ALTER TABLE `poll_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poll_votes`
--

DROP TABLE IF EXISTS `poll_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poll_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `identification` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_post_vote` (`post_id`,`identification`),
  KEY `option_id` (`option_id`),
  CONSTRAINT `fk_poll_votes_option` FOREIGN KEY (`option_id`) REFERENCES `poll_options` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_poll_votes_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poll_votes`
--

LOCK TABLES `poll_votes` WRITE;
/*!40000 ALTER TABLE `poll_votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `poll_votes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text DEFAULT NULL,
  `author_id` varchar(20) NOT NULL,
  `community` varchar(100) NOT NULL DEFAULT 'FEUTech',
  `topic` varchar(100) NOT NULL DEFAULT 'GENERAL',
  `tags` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `upvotes` int(11) NOT NULL DEFAULT 0,
  `downvotes` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_anonymous` tinyint(4) NOT NULL DEFAULT 0,
  `is_poll` tinyint(4) NOT NULL DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `fk_posts_author` FOREIGN KEY (`author_id`) REFERENCES `accounts` (`identification`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'The silent revolution in edge AI — why on-device inference is changing everything','A decade optimizing for server-side compute, but the thermal envelope of modern SoCs has quietly crossed a threshold nobody was paying attention to. Here\'s why 2025 is the last year data centers dominate AI inference at scale.<br><br>The numbers are staggering — a modern mobile chip can...','T202110294','FEU TECH DEV','TECHNOLOGY','Technology','silent-revolution-edge-ai',214,0,'2026-06-02 02:02:08',0,0,NULL),(2,'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec.','T202008123','FEU TECH DEV','TECHNOLOGY','Technology','lorem-ipsum-dolor-sit-amet',214,0,'2026-06-02 02:02:08',0,0,NULL),(3,'What if FEU had a no-grade-penalty mental health leave policy?','Just thinking — a lot of students I know failed a whole semester because they were dealing with severe anxiety during midterms. The university had no mechanism to help them — just a strict drop policy or failure. Other universities have mental health leaves where students can pause without academic penalty. Should FEU implement something similar?','T202210202','FEU TECH DEV','TECHNOLOGY','Ideas','what-if-feu-had-mental-health-leave',214,0,'2026-06-02 02:02:08',1,0,NULL),(4,'Lorem ipsum dolor sit amet consectetur adipiscing elit.','Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam uma tempor.','T202008123','FEU TECH DEV','TECHNOLOGY','Technology','lorem-ipsum-consectetur-adipiscing',214,0,'2026-06-02 02:02:08',0,0,NULL),(5,'📊 Poll: How do you actually study for finals? Be honest.','Curious how my fellow FEU Tech students survive finals season. Drop your honest answer below 👇','T202102837','FEU LIFE','FEU','FEU • Academics','poll-how-do-you-study-finals',456,0,'2026-06-02 02:02:08',0,1,NULL),(6,'FEU Tech library study rooms — worth booking or just use the hallway?','Finally tried booking one of the new study rooms in the library. Honest review: the booking system is clunky, the AC is questionable, but the soundproofing is actually great. Worth it for group study if you plan ahead.<br><br>Not ideal for solo cramming though — the chairs are surprisingly uncomfortable for long sessions.','T202210202','FEU TECH DEV','TECHNOLOGY','FEU • Campus Life','feu-tech-library-study-rooms',214,0,'2026-06-02 02:02:08',0,0,'https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?q=80&w=1200&auto=format&fit=crop'),(7,'test','test','T202210202','FEU TECH DEV','GAMING','test','test',0,0,'2026-06-02 02:23:48',0,0,NULL),(8,'sadas','asdas','T202210202','FEU TECH DEV','FEU','asdas','sadas',0,0,'2026-06-02 02:26:48',0,0,NULL),(9,'test','test','T202210202','Cosplaying','Culture','','test-1',0,0,'2026-06-02 04:01:41',1,0,NULL),(10,'Is the FEU LIFE event calendar accurate this sem?','Been checking the calendar for upcoming events but it seems like half of them are already done and not updated. Anyone else notice this?','T202102837','FEU LIFE','FEU','feu,events','feu-life-event-calendar',87,2,'2026-05-31 04:16:20',0,0,NULL),(11,'Tips for surviving the first week of classes','Just finished my first week as a freshie. Here are some things I wish I knew before coming in — hope this helps other newbies!','T202210202','FEU LIFE','LIFESTYLE','lifestyle,freshie','tips-first-week-classes',134,1,'2026-05-28 04:16:20',0,0,NULL),(12,'Mental health resources available at FEU?','Has anyone actually used the counseling services? Wondering if they are accessible and whether appointments are easy to get.','T202110117','FEU LIFE','ISSUES','mental-health,wellness','mental-health-resources-feu',203,4,'2026-06-01 04:16:20',1,0,NULL),(13,'Best jeepney routes going to FEU Alabang from Muntinlupa','Had so much trouble commuting on my first day. Here is the route breakdown that actually works for me from Tunasan.','T202210344','FEU ALABANG LIFE','LIFESTYLE','commute,alabang,transport','jeepney-routes-feu-alabang',56,0,'2026-05-30 04:16:20',0,0,NULL),(14,'Alabang canteen recommendations — honest tier list','Rated every food stall in the Alabang campus canteen. Some surprises in here, especially the pasta place near the registrar.','T202110295','FEU ALABANG LIFE','LIFESTYLE','food,canteen,alabang','alabang-canteen-recommendations',91,1,'2026-05-26 04:16:20',0,0,NULL),(15,'Welcome to FEU! Ask anything here — upperclassmen will answer','Starting this thread so freshies can ask questions without feeling judged. No question is too basic. We got you!','T202110294','Freshies','FEU','freshie,welcome,advice','welcome-freshies-ask-anything',178,0,'2026-05-23 04:16:20',0,0,NULL),(16,'How does the grading system work exactly?','Coming from a different school system. Can someone explain how weighted grades and the prelim/midterm/finals breakdown works here?','T202110117','Freshies','ACADEMICS','grading,academics,freshie','how-grading-system-works',67,0,'2026-05-29 04:16:20',0,0,NULL),(17,'Enrollment tips that actually work — from a 4th year student','After four years of enrollment nightmares, here is what I learned. These tricks cut my enrollment time by half.','T202008123','Enrollment','ACADEMICS','enrollment,tips,academics','enrollment-tips-4th-year',312,3,'2026-05-27 04:16:20',0,0,NULL),(18,'Is it possible to cross-enroll to another campus?','Trying to take a subject not offered in my campus this sem. Anyone done this before and how did the process go?','T202210202','Enrollment','ACADEMICS','enrollment,cross-enroll','cross-enroll-between-campuses',44,1,'2026-05-31 04:16:20',0,0,NULL),(19,'Looking for cosplay group for the upcoming convention','Planning to go to ToyCon next month and looking for others from FEU who want to group cosplay. Drop your Discord below!','T202210202','Cosplaying','CREATIVE','cosplay,convention,toycon','cosplay-group-convention',73,0,'2026-05-25 04:16:20',0,0,NULL),(20,'Budget cosplay tips — how I made a full costume for under 500 pesos','Sharing my process for making a decent Demon Slayer costume on a student budget. Lots of thrift store tricks involved.','T202110295','Cosplaying','CREATIVE','cosplay,budget,diy','budget-cosplay-under-500',148,2,'2026-05-19 04:16:20',0,0,NULL),(21,'Which tech stack should I learn for internship applications?','Applying for internships next sem and not sure what to prioritize. React, Node, Django, or Spring Boot? What are local companies looking for?','T202110294','FEU TECH DEV','TECHNOLOGY','tech,internship,programming','tech-stack-for-internship',224,5,'2026-05-30 04:16:20',0,0,NULL),(22,'Free resources to learn system design before interviews','Compiled a list of free materials that helped me crack my internship technical interview. Includes YouTube playlists and GitHub repos.','T202102837','FEU TECH DEV','TECHNOLOGY','system-design,interview,resources','free-system-design-resources',189,1,'2026-05-24 04:16:20',0,0,NULL),(23,'Hidden gem alert — tapsilog place near the parking lot','Most students overlook this spot because it looks sketchy from the outside but the food is incredible and the servings are huge. 150 pesos all in.','T202210344','Food Trip Around TECH','LIFESTYLE','food,tapsilog,cheap','hidden-gem-tapsilog-parking',97,0,'2026-05-28 04:16:20',0,0,NULL),(24,'Milk tea ranking near campus — tested 8 different shops','Spent way too much money on this but you deserve the honest ranking. Spoiler: the cheapest one actually won.','T202008123','Food Trip Around TECH','LIFESTYLE','food,milktea,review','milk-tea-ranking-near-campus',156,3,'2026-05-22 04:16:20',0,0,NULL),(25,'How to choose a thesis topic that will actually get approved','After getting rejected twice, I finally figured out what panelists want to see in a proposal. Here is my framework.','T202110294','Thesis Advice','ACADEMICS','thesis,research,academics','how-to-choose-thesis-topic',267,4,'2026-05-18 04:16:20',0,0,NULL),(26,'Thesis defense survival guide — what to expect and how to prepare','Just passed my defense last week. Sharing everything from the panel questions to the technical setup issues I encountered.','T202210202','Thesis Advice','ACADEMICS','thesis,defense,academics','thesis-defense-survival-guide',198,2,'2026-05-13 04:16:20',0,0,NULL),(27,'Startup event this Saturday at FEU Alabang — free entry','An innovation fair is happening this weekend. Expect startup pitches, tech demos, and networking. Students can join for free.','T202102837','Alabang Innovators','IDEAS','startup,innovation,event','startup-event-feu-alabang',43,0,'2026-06-01 04:16:20',0,0,NULL),(28,'Looking for co-founders for an edtech startup idea','Have a validated idea for an app that helps students track academic deadlines. Looking for a tech co-founder with React Native skills.','T202110295','Alabang Innovators','IDEAS','startup,edtech,cofounder','looking-for-cofounder-edtech',38,1,'2026-05-27 04:16:20',0,0,NULL),(29,'Digital art commission prices — what is fair for student artists?','Seeing a lot of artists undersell themselves. Want to open a discussion on what fair pricing looks like for commissions in the Philippines.','T202210344','Diliman Artists','CREATIVE','art,commission,digital-art','digital-art-commission-prices',119,2,'2026-05-29 04:16:20',0,0,NULL),(30,'Free online tools every digital artist should know','From Krita to Figma, these are the tools I use daily as a broke student who cannot afford Adobe subscriptions.','T202110117','Diliman Artists','CREATIVE','art,tools,free-resources','free-tools-digital-artist',88,0,'2026-05-25 04:16:20',0,0,NULL),(31,'Online study group for Data Structures and Algorithms — join us','Meeting every Sunday at 2pm via Discord. We solve LeetCode problems and discuss CS fundamentals. All levels welcome.','T202110294','Study Group','ACADEMICS','study,algorithms,cs','study-group-data-structures',82,0,'2026-05-26 04:16:20',0,0,NULL),(32,'Best study spots in the campus that are actually quiet','Library is always full. Here are five alternative spots that are actually quiet and have power outlets.','T202008123','Study Group','ACADEMICS','study,campus,tips','best-study-spots-campus',165,1,'2026-05-21 04:16:20',0,0,NULL),(33,'My laptop keeps crashing during online exams — what do I do?','This has happened three times already during timed assessments. Screen goes black and I lose all my answers. Is it a hardware or software issue?','T202110117','Tech Support','TECHNOLOGY','laptop,tech-help,exams','laptop-crashes-online-exams',54,0,'2026-05-31 04:16:20',1,0,NULL),(34,'How to set up VS Code for web development — beginner guide','Step-by-step setup guide including all the extensions that actually matter. Tested on Windows 11 and MacOS.','T202102837','Tech Support','TECHNOLOGY','vscode,webdev,beginners','vscode-setup-web-development',134,0,'2026-05-17 04:16:20',0,0,NULL);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saved_posts`
--

DROP TABLE IF EXISTS `saved_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saved_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `identification` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_post_save` (`post_id`,`identification`),
  KEY `identification` (`identification`),
  CONSTRAINT `saved_posts_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `saved_posts_ibfk_2` FOREIGN KEY (`identification`) REFERENCES `accounts` (`identification`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saved_posts`
--

LOCK TABLES `saved_posts` WRITE;
/*!40000 ALTER TABLE `saved_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `saved_posts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-02 12:37:38
