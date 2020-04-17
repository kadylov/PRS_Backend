-- MySQL dump 10.13  Distrib 5.7.25, for linux-glibc2.12 (x86_64)
--
-- Host: ls-a1f8ce36f06eeb4f03f53664d8911745db5895f4.cn5ycdfnko6g.us-east-1.rds.amazonaws.com    Database: peer_review_db
-- ------------------------------------------------------
-- Server version	8.0.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `Admin`
--

LOCK TABLES `Admin` WRITE;
/*!40000 ALTER TABLE `Admin` DISABLE KEYS */;
INSERT  IGNORE INTO `Admin` VALUES (0,'admin','1234','Edward Snipes',3,3,'farsh03@gmail.com',1),(6,'admin1','1234','admin1',1,3,'aaa@ss.ww',0),(7,'prs','1234','John Wallis',3,3,'email@example.com',1);
/*!40000 ALTER TABLE `Admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Admin_Review`
--

LOCK TABLES `Admin_Review` WRITE;
/*!40000 ALTER TABLE `Admin_Review` DISABLE KEYS */;
INSERT  IGNORE INTO `Admin_Review` VALUES (0,2,'2019-11-22','rejected','poor grammar'),(0,27,'2020-03-10','rejected','Poor grammars'),(0,30,'2019-11-22','admitted',''),(0,31,'2020-03-10','admitted',''),(0,34,'2020-03-10','admitted',''),(0,38,'2020-04-15','admitted','');
/*!40000 ALTER TABLE `Admin_Review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Assignment`
--

LOCK TABLES `Assignment` WRITE;
/*!40000 ALTER TABLE `Assignment` DISABLE KEYS */;
INSERT  IGNORE INTO `Assignment` VALUES (0,1,4,'2019-11-12','2020-03-30',0),(0,1,31,'2020-03-18','2020-04-15',1),(0,2,4,'2020-03-04','2020-04-15',1),(0,2,31,'2020-03-18','2020-03-25',1),(0,3,4,'2019-11-12','2019-11-14',0),(0,3,31,'2020-03-18','2020-03-20',1),(0,66,4,'2020-04-07','2020-04-10',1),(0,66,35,'2020-03-18','2020-03-23',0),(0,68,35,'2020-03-18','2020-04-15',1),(0,69,4,'2020-04-14','2020-04-09',1),(0,69,35,'2020-03-18','2019-11-21',1),(0,71,4,'2020-04-01','2020-04-03',1),(0,71,35,'2020-04-07','2020-04-23',1),(0,72,35,'2020-03-18','2020-03-20',1);
/*!40000 ALTER TABLE `Assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Discussion`
--

LOCK TABLES `Discussion` WRITE;
/*!40000 ALTER TABLE `Discussion` DISABLE KEYS */;
INSERT  IGNORE INTO `Discussion` VALUES (1,4,1,'great article','2019-11-13 07:00:00'),(2,4,2,'Yes, it is. But I found some typos','2019-11-13 07:01:00'),(3,4,3,'I wonder who wrote it','2019-11-13 07:02:00'),(4,4,1,'hello','2019-11-13 07:05:00'),(11,4,1,'aaaaaaaaaaaaaaaaaaaaaa','2020-03-13 02:22:15'),(12,4,1,'hello, this is the test message ','2020-03-13 02:23:16'),(13,4,1,'Saluuuutttttt','2020-03-13 02:23:50'),(14,4,1,'aaaaa','2020-03-13 02:23:53'),(15,4,1,'bbbbb','2020-03-13 02:23:55'),(16,4,1,'ccccc','2020-03-13 02:23:56'),(17,4,1,'heeeeyyyy','2020-03-13 02:30:33'),(18,4,1,'hhhhh','2020-03-13 02:31:52'),(19,4,1,'this is todays message','2020-03-13 10:18:08'),(20,4,1,'this is the 2nd test msg','2020-03-13 22:52:55'),(21,4,1,'cool','2020-03-15 08:22:09'),(22,4,2,'Received your last message, Melissa','2020-03-15 08:25:13'),(23,4,2,'My account was deactivated before','2020-03-15 21:54:05'),(24,4,2,'I requested admin to reactivate it, so I could start chatting with you','2020-03-15 21:54:43'),(25,4,2,'This discussion is for work ID: 4, Title: Can you measure the ROI of your .....','2020-03-15 21:56:38'),(26,4,2,'Once Scott connects Work View along with our Scorecards to database, the discuss','2020-03-15 21:59:09'),(27,4,1,'I hope it won\'t take him entire semester to accomplish it','2020-03-15 22:00:31');
/*!40000 ALTER TABLE `Discussion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Review_Summary`
--

LOCK TABLES `Review_Summary` WRITE;
/*!40000 ALTER TABLE `Review_Summary` DISABLE KEYS */;
INSERT  IGNORE INTO `Review_Summary` VALUES (1,2,93,NULL),(2,2,82,NULL),(4,2,95,NULL),(31,2,105,NULL);
/*!40000 ALTER TABLE `Review_Summary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Reviewer`
--

LOCK TABLES `Reviewer` WRITE;
/*!40000 ALTER TABLE `Reviewer` DISABLE KEYS */;
INSERT  IGNORE INTO `Reviewer` VALUES (1,'reviewer1','1234','Melissa Klein',1,2,'1@1.com',1),(2,'reviewer2','1234','Anton Swartz',2,1,'2@1.com',1),(3,'reviewer3','1234','reviewer3 Name',1,1,'reviewer1@r.rr',1),(66,'reviewer4','1234','Mell Gibson',2,1,'ree@ww.rr',1),(68,'Debra Brown','cricket','Debra Brown',2,2,'dparcheta@blue-marble.com',1),(69,'reviewer5','1234','Daug Williams',2,1,'reviewer5@prs.com',1),(70,'reviewer6','1234','reviewer6 name',3,1,'reviewer6@email.com',1),(71,'reviewer7','1234','reviewer7 name',4,1,'reviewer7@ss.ww',1),(72,'reviewer8','1234','reviewer8 name',3,1,'reviewer8@qq.qq',1),(73,'reviewer9','1234','reviewer9 name',3,2,'reviewer9@qq.qq',1),(74,'reviewer10','1234','reviewer10 name',1,1,'reviewer10@qq.qq',0);
/*!40000 ALTER TABLE `Reviewer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `ReviewerCredential`
--

LOCK TABLES `ReviewerCredential` WRITE;
/*!40000 ALTER TABLE `ReviewerCredential` DISABLE KEYS */;
INSERT  IGNORE INTO `ReviewerCredential` VALUES (1,'Academic'),(2,'Practitioner'),(3,'Ph.D'),(4,'Fellow');
/*!40000 ALTER TABLE `ReviewerCredential` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Reviews_History`
--

LOCK TABLES `Reviews_History` WRITE;
/*!40000 ALTER TABLE `Reviews_History` DISABLE KEYS */;
INSERT  IGNORE INTO `Reviews_History` VALUES (4,1,'2020-04-01',22,'Reviwer1\'s comment text'),(4,2,'2019-11-11',48,'Reviwer2\'s comment text'),(4,3,'2019-11-11',22,'Reviwer3\'s comment text'),(31,1,'2019-11-11',66,'Reviewer1\'s comment text');
/*!40000 ALTER TABLE `Reviews_History` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Role`
--

LOCK TABLES `Role` WRITE;
/*!40000 ALTER TABLE `Role` DISABLE KEYS */;
INSERT  IGNORE INTO `Role` VALUES (1,'Reviewer'),(2,'Lead Reviewer'),(3,'Admin');
/*!40000 ALTER TABLE `Role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Rubric`
--

LOCK TABLES `Rubric` WRITE;
/*!40000 ALTER TABLE `Rubric` DISABLE KEYS */;
INSERT  IGNORE INTO `Rubric` VALUES (1,'Goal Setting and Measurement are Fundamental to Communication\nand Public Relations'),(2,'Measuring Communication Outcomes is Recommended Versus Only\nMeasuring Outputs'),(3,'The Effect on Organizational Performance Can and Should Be\nMeasured Where Possible'),(4,'Measurement and Evaluation Require Both Qualitative and\nQuantitative Methods'),(5,'AVEs are not the Value of Communications'),(6,'Social Media Can and Should be Measured Consistently with Other\nMedia Channels'),(7,'Measurement and Evaluation Should be Transparent, Consistent and\nValid'),(8,'Adds to or Advances The Body of Knowledge'),(9,'Spelling/Grammar/Writing Style/Speaking Style'),(10,'Focused and Complete'),(11,'Demonstrates Valid Use of Data, Mathematics and Methods'),(12,'Visualization Elements Aid Comprehension');
/*!40000 ALTER TABLE `Rubric` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Scorecard`
--

LOCK TABLES `Scorecard` WRITE;
/*!40000 ALTER TABLE `Scorecard` DISABLE KEYS */;
INSERT  IGNORE INTO `Scorecard` VALUES (4,1,4,1,0),(4,1,4,2,1),(4,2,4,1,0),(4,2,4,2,1),(4,3,4,1,0),(4,3,4,2,1),(4,4,4,1,0),(4,4,4,2,1),(4,5,4,1,0),(4,5,4,2,1),(4,6,4,1,0),(4,6,4,2,1),(4,7,4,1,0),(4,7,4,2,1),(4,8,4,2,1),(4,9,4,2,1),(4,10,4,2,1),(4,11,4,2,1),(4,12,4,2,1);
/*!40000 ALTER TABLE `Scorecard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Tag`
--

LOCK TABLES `Tag` WRITE;
/*!40000 ALTER TABLE `Tag` DISABLE KEYS */;
INSERT  IGNORE INTO `Tag` VALUES (1,'main','Standard, Brand Measurement, Outcome','false'),(2,'length','Quick read, Medium read, Long read','false'),(3,'level','Basic, Intermediate, Advanced','false'),(4,'metrics','Volume, Impressions, Engagements, Share of Voice, Click-throughs, AVE','true'),(5,'types','Artificial Intelligence, Automated, Human, Influencer identification and tracking, Impact','true'),(6,'purpose','Campaign, Crisis, CSR, Integration, Internal communications, Ongoing, Reputation','false'),(7,'methodologies','Analytics, Big data, Focus group, Human coding, Measurement, Modeling, Survey','true');
/*!40000 ALTER TABLE `Tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Work`
--

LOCK TABLES `Work` WRITE;
/*!40000 ALTER TABLE `Work` DISABLE KEYS */;
INSERT  IGNORE INTO `Work` VALUES (1,'New Metrics for New Media: Toward the Development of Web Measurement Standards','https://www.researchgate.net/publication/228606680_New_Metrics_for_New_Media_Toward_the_Development_of_Web_Measurement_Standards','2019-11-11','1996-09-26','no','scored','TP Novak, DL Hoffman','abca@mail.com','Standard, Ongoing,Measurement'),(2,'Use and measurement of social media for SMEs','https://www.emerald.com/insight/content/doi/10.1108/JSBED-08-2012-0096/full/html','2019-11-11','2019-11-11','no','rejected','M McCann, A Barlow','efg@mail.com','Brand Measurement, Focus group'),(4,'Can you measure the ROI of your social media marketing?','https://www.researchgate.net/publication/228237594_Can_You_Measure_the_ROI_of_Your_Social_Media_Marketing','2019-11-15','2010-10-10','no','assigned',' Donna Hoffman','efg@mail.com','Output, Automated'),(27,'Audiences','https://thearf.org/category/topics/audience-media-measurement/','2020-02-25','2020-02-25','no','rejected','Brad Fay','dparcheta@gmail.com','Standard,Quick read,Basic,Impressions,Measurement,Ongoing,Measurement'),(30,'Measurement and prediction of saturation-pressure relationships in three-phase porous media systems','https://www.sciencedirect.com/science/article/pii/0169772287900179','2020-03-04','1987-01-01','no','accepted','Lenhard, Parker','dparcheta@gmail.com','Outcome,Quick read,Advanced,Engagements,Measurement,Ongoing'),(31,'Guide to Reading Academic Research Papers','https://towardsdatascience.com/guide-to-reading-academic-research-papers-c69c21619de6','2020-03-04','2018-07-28','no','scored','Kyle M Shannon','kyle@mail.com','Outcome,Quick read,Intermediate,Engagements,Impact,CSR,Focus group,Measurement'),(32,'Exploring the Strategic Use of New Media\'s Impact','https://poseidon01.ssrn.com/delivery.php?ID=854006004112116116068016016066104069053032069011093069025100065025000125086107068006030110036003123013013080097085000127114107028051002032011066092087027065015082068040012032017067070120102064097112118080024088127025067098110003126084011024087073084067&EXT=pdf','2020-03-04','2020-03-01','no','new','UM ','dparcheta@gmail.com','Standard,Quick read,Basic,Impressions,Human,Integration,Focus group'),(33,'The publishing delay in scholarly peer-reviewed journals','https://www.independent.org/publications/policy_reports/?gclid=EAIaIQobChMI_KblyMWB6AIVjobACh0n0wDeEAAYASAAEgLnc_D_BwE','2020-03-04','2001-06-20','no','admitted','Bo-Christer Bjorka, David Solomon','bobo@mail.bb','Brand Measurement,Medium read,Basic,Impressions,Engagements,Automated,Human,Crisis,Big data,Focus group'),(34,'Evidence of lean: a review of international peer‐reviewed journal articles','https://www.emerald.com/insight/content/doi/10.1108/09555341311302675/full/html','2020-03-04','2013-11-14','no','admitted','Jan Stentoft Arlbjorn, Per Vagn Freytag','janijani@jan.net','Standard,Quick read,Intermediate,Impressions,Engagements,Influencer identification and tracking,Campaign,Human coding,Modeling'),(35,'Prevalence of Articles With Honorary Authors and Ghost Authors in Peer-Reviewed Medical Journals','https://jamanetwork.com/journals/jama/article-abstract/187772','2020-03-04','2015-07-15','no','assigned','Annette Flanagin, RN, MA; Lisa A. Carey, PhD;','annete@gmail.com','Standard,Quick read,Intermediate,Impressions,Engagements,Automated,Influencer identification and tracking,Campaign,Big data,Focus group'),(36,'Loose Connections between Peer-Reviewed Clinical Journals and Clinical Practice','https://annals.org/aim/article-abstract/704233/loose-connections-between-peer-reviewed-clinical-journals-clinical-practice','2020-03-04','2001-01-09','no','new','R. Brian Haynes, MD, PhD','brian@brian.com','Standard,Quick read,Basic,Impressions,Engagements,Automated,Human,Campaign,Big data,Focus group'),(37,'Endovascular Treatment of Deep Vein Thrombosis','https://www.sciencedirect.com/science/article/abs/pii/S2211745814000698','2020-03-04','2020-03-02','no','new','Julian J.JavierMD','jiull@sds.ww','Standard,Quick read,Intermediate,Impressions,Artificial Intelligence,Integration,Analytics'),(38,'Noninvasive Testing in Peripheral Arterial Disease','https://www.sciencedirect.com/science/article/abs/pii/S2211745814000650','2020-03-04','2020-03-01','no','admitted','IanDel CondeMD','farsh03@gmail.com','Standard,Quick read,Basic,Impressions,Automated,Campaign,Big data'),(44,'ABCs of Measurement','https://www.rwjf.org/en/library/research/2010/06/latest-from-aligning-forces-for-quality-communities/the-abcs-of-measurement.html','2020-03-05','2020-03-03','no','new','Debra ','dparcheta@gmail.com','Standard,Medium read,Basic,Engagements,Influencer identification and tracking,Campaign,Big data'),(45,'Towards Gender Responsive Banana Research','https://hdl.handle.net/10568/102078','2020-03-06','2020-03-01','no','new','Parcheta, Debra','dparcheta@gmail.com','Standard,Quick read,Basic,Impressions,Automated,Campaign,Big data'),(46,'Social Media Measurement That Works','https://www.lyfemarketing.com/blog/social-media-measurement/','2020-03-12','2020-03-10','no','denied','Dan','dparcheta@gmail.co,','Standard,Quick read,Basic,Engagements,Automated,CSR,Big data');
/*!40000 ALTER TABLE `Work` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `WorkStatus`
--

LOCK TABLES `WorkStatus` WRITE;
/*!40000 ALTER TABLE `WorkStatus` DISABLE KEYS */;
INSERT  IGNORE INTO `WorkStatus` VALUES (2,'admitted'),(4,'assigned'),(3,'new'),(1,'rejected'),(6,'retired'),(7,'scored');
/*!40000 ALTER TABLE `WorkStatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'peer_review_db'
--

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed
