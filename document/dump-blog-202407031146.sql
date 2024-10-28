-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: web-lame.home    Database: blog
-- ------------------------------------------------------
-- Server version	8.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comment` (
  `commentId` int NOT NULL AUTO_INCREMENT,
  `comment` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `isValidated` tinyint(1) NOT NULL DEFAULT '0',
  `userId` int NOT NULL,
  `postId` int NOT NULL,
  PRIMARY KEY (`commentId`),
  KEY `comment_user_FK` (`userId`),
  KEY `comment_post_FK` (`postId`),
  CONSTRAINT `comment_post_FK` FOREIGN KEY (`postId`) REFERENCES `post` (`postId`),
  CONSTRAINT `comment_user_FK` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,'Un article fascinant qui capture parfaitement l\'essence de l\'intelligence artificielle moderne. L\'auteur offre un aperçu clair et informatif des progrès récents, tout en soulignant de manière perspicace les défis éthiques qui accompagnent cette révolution technologique.',1,6,1),(2,'Ce texte met en lumière l\'impact potentiellement révolutionnaire de la technologie 5G sur notre société interconnectée. Les préoccupations soulevées concernant la sécurité et la vie privée incitent à une réflexion approfondie sur les implications de cette avancée technologique.',1,5,2),(3,'Un regard captivant sur l\'émergence de la réalité virtuelle et son influence croissante dans le domaine du divertissement. L\'auteur offre une analyse perspicace des avantages et des défis de cette technologie révolutionnaire, suscitant une réflexion sur l\'avenir du divertissement interactif.',0,4,3),(4,'Un exposé informatif sur le potentiel révolutionnaire de la blockchain et ses nombreuses applications au-delà des cryptomonnaies. L\'auteur met en lumière les possibilités passionnantes offertes par cette technologie tout en soulignant les défis qui doivent encore être relevés pour sa pleine adoption.',0,3,4),(5,'Cet article offre un aperçu perspicace de l\'Internet des objets et de son impact potentiel sur nos vies quotidiennes. Les préoccupations concernant la sécurité et la confidentialité soulignent l\'importance d\'une réglementation efficace pour garantir que cette technologie bénéficie à tous de manière sûre et équitable.',1,2,5),(6,'Un exposé éclairant sur l\'évolution de la cybersécurité dans un paysage numérique en constante évolution. L\'auteur souligne avec pertinence l\'importance croissante de la sécurité des données et de la collaboration internationale pour faire face aux menaces cybernétiques émergentes.',1,1,6),(7,'Un article informatif qui met en lumière les nombreux avantages et défis de l\'Internet des objets. L\'auteur aborde de manière équilibrée les opportunités offertes par cette technologie, tout en soulignant les préoccupations légitimes concernant la sécurité et la vie privée. C\'est une lecture indispensable pour quiconque s\'intéresse à l\'avenir de la connectivité et de la domotique.',1,7,2);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post` (
  `postId` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `message` mediumtext NOT NULL,
  `userId` int NOT NULL,
  `createAt` datetime NOT NULL,
  PRIMARY KEY (`postId`),
  KEY `post_user_FK` (`userId`),
  CONSTRAINT `post_user_FK` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (1,'Les dernières avancées en intelligence artificielle','L\'intelligence artificielle (IA) continue de progresser à pas de géant, ouvrant de nouvelles perspectives dans divers domaines. Les dernières avancées incluent des algorithmes d\'apprentissage automatique plus sophistiqués, des réseaux neuronaux profonds et des applications pratiques dans des domaines tels que la médecine et la finance. Ces progrès rapides soulèvent également des questions éthiques et sociales qui nécessitent une réflexion approfondie pour garantir que l\'IA soit utilisée de manière responsable et bénéfique pour l\'humanité.',1,'2024-04-02 00:00:00'),(2,'Les implications de la 5G sur la connectivité mondiale','La technologie 5G promet une connectivité ultra-rapide et une latence réduite, ouvrant la voie à une nouvelle ère de communication et de technologie. Avec des vitesses de téléchargement jusqu\'à 100 fois plus rapides que la 4G, la 5G facilitera le déploiement de l\'Internet des objets (IdO), des véhicules autonomes et des villes intelligentes. Cependant, elle soulève également des préoccupations en matière de sécurité et de vie privée, nécessitant une réglementation et une gestion adéquates.',2,'2024-04-05 00:00:00'),(3,'La montée en puissance de la réalité virtuelle dans l\'industrie du divertissement','Un regard captivant sur l\'émergence de la réalité virtuelle et son influence croissante dans le domaine du divertissement. L\'auteur offre une analyse perspicace des avantages et des défis de cette technologie révolutionnaire, suscitant une réflexion sur l\'avenir du divertissement interactif.',3,'2024-04-08 00:00:00'),(4,' L\'essor de la blockchain et ses applications potentielles','La blockchain, la technologie sous-jacente aux cryptomonnaies telles que le Bitcoin, suscite un intéret croissant en raison de son potentiel révolutionnaire dans divers secteurs. En plus des transactions financières décentralisées, la blockchain trouve des applications dans la gestion de l\'identité numérique, la traçabilité des chaînes d\'approvisionnement et même le vote électronique sécurisé. Cependant, des défis persistent, notamment en matière de mise à l\'échelle et de réglementation.',4,'2024-04-12 00:00:00'),(5,' Les implications de l\'Internet des objets sur la vie quotidienne','L\'Internet des objets (IdO) promet de transformer radicalement nos vies en connectant des appareils du quotidien à Internet, permettant une automatisation intelligente et une surveillance à distance. Des dispositifs tels que les thermostats intelligents, les réfrigérateurs connectés et les wearables santé offrent des avantages pratiques, mais soulèvent également des préoccupations en matière de sécurité et de confidentialité des données.',5,'2024-04-15 00:00:00'),(6,'L\'évolution de la cybersécurité dans un monde numérique en constante évolution','Dans un monde numérique où les cybermenaces sont de plus en plus sophistiquées, la cybersécurité est devenue une priorité absolue pour les entreprises et les particuliers. Les attaques telles que les ransomwares et les violations de données peuvent causer des dommages importants, mettant en évidence la nécessité de solutions de sécurité avancées telles que l\'intelligence artificielle et la détection comportementale pour prévenir les cyberattaques.',6,'2024-04-18 00:00:00');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `isValidated` tinyint(1) DEFAULT '0',
  `nickname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` enum('isUser','isModerateur','isAdmin') NOT NULL DEFAULT 'isUser',
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'DUPONT','Sophie ','sdupont@mailinator.com','k@A*4q3N',1,'Alexia Tech','isUser'),(2,'LEFEBVRE','Pierre','plefebvez@mailinator.com','D6nQj?{9',1,'Max Cyber','isUser'),(3,'MARTIN','Camille','cmartin@mailinator.com','5fW6Am_?',1,'Nova VR','isUser'),(4,'DURAND','Nicolas','ndurand@mailinator.com','!Xq+6A6z',1,'CryptoWizard','isUser'),(5,'MOREAU','Laura','lmoreau@mailinator.com','+NK39ik)',1,'TechEnthusiast','isUser'),(6,'DUBOIS','Julien','jdubois@mailinator.com','9NHx]~7h',1,'CyberGuardian','isUser'),(7,'MAGAR','Lame','lmagar@mailinator.com','x5plex972',1,'Orcryx','isAdmin');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'blog'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-03 11:46:03
