-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: navi
-- ------------------------------------------------------
-- Server version	5.6.39-log

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
-- Table structure for table `sites`
--

DROP TABLE IF EXISTS `sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) NOT NULL DEFAULT '',
  `class` varchar(100) NOT NULL DEFAULT '默认',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '网站名称',
  `url` varchar(255) NOT NULL DEFAULT '',
  `ico` varchar(255) NOT NULL DEFAULT '',
  `summary` varchar(255) DEFAULT '',
  `up` int(11) NOT NULL DEFAULT '0' COMMENT '点赞数',
  `down` int(11) NOT NULL DEFAULT '0',
  `click` int(11) NOT NULL DEFAULT '0',
  `total_click` int(11) NOT NULL DEFAULT '0',
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sites`
--

LOCK TABLES `sites` WRITE;
/*!40000 ALTER TABLE `sites` DISABLE KEYS */;
INSERT INTO `sites` VALUES (1,'default','常用','百度','http://baidu.com','http://baidu.com/favicon.ico','常用的网站',0,0,0,0,'2018-05-20 10:39:15','2018-05-13 08:13:39'),(6,'default','默认','WWW.SINA.COM','http://www.sina.com','http://cdn.website.h.qhimg.com/index.php?domain=sina.com','新浪首页',0,0,0,0,'2018-05-20 10:39:38','2018-05-19 11:50:04'),(17,'default','默认','Laravel学院 - 优质Laravel中文学习资源平台','laravelacademy.org','/ico/laravelacademy.org.png','Laravel学院致力于提供优质Laravel中文学习资源',0,0,0,0,'2018-05-23 09:56:05','2018-05-20 09:03:46'),(19,'banli','我的工具','百度网盘，让美好永远陪伴','http://pan.baidu.com','/ico/pan.baidu.com.ico','百度网盘为您提供文件的网络备份、同步和分享服务。空间大、速度快、安全稳固，支持教育网加速，支持手机端。现在注册即有机会享受15G的免费存储空间',0,0,0,0,'2018-05-24 05:12:32','2018-05-20 09:11:43'),(21,'banli','技术站点','github','http://github.com','http://github.com/favicon.ico','GitHub brings together the world’s largest community of developers to discover, share, and build better software. From open source projects to private team repositories, we’re your all-in-one platform for collaborative development.',0,0,0,0,'2018-05-20 09:18:48','2018-05-20 09:16:10'),(22,'default','默认','stackoverflow','http://stackoverflow.com','http://cdn.website.h.qhimg.com/index.php?domain=stackoverflow.com','stackoverflow',0,0,0,0,'2018-05-20 10:39:04','2018-05-20 10:39:04'),(23,'default','技术论坛','segmentfault','http://segmentfault.com','http://cdn.website.h.qhimg.com/index.php?domain=segmentfault.com','SegmentFault ( www.sf.gg ) 是中国领先的开发者技术社区。 我们希望为编程爱好者提供一个纯粹、高质的技术交流的平台， 与开发者一起学习、交流与成长，创造属于开发者的时代！',0,0,0,0,'2018-05-20 10:42:02','2018-05-20 10:42:02'),(25,'banli','技术站点','Laravel学院 - 优质Laravel中文学习资源平台','http://laravelacademy.org','/ico/laravelacademy.org.png','Laravel学院致力于提供优质Laravel中文学习资源',0,0,0,0,'2018-05-26 09:55:03','2018-05-23 10:00:27'),(27,'banli','技术站点','SegmentFault 思否','http://segmentfault.com','/ico/segmentfault.com.ico','SegmentFault ( www.sf.gg ) 是中国领先的开发者技术社区。 我们希望为编程爱好者提供一个纯粹、高质的技术交流的平台， 与开发者一起学习、交流与成长，创造属于开发者的时代！',0,0,0,0,'2018-05-26 09:55:03','2018-05-23 10:05:21'),(29,'banli','默认','OPSX','https://opsx.alibaba.com/mirror','/ico/opsx.alibaba.com.png','阿里云开源镜像站由阿里巴巴的天基团队支持。 目前提供 Debian、Ubuntu、 Fedora、Arch Linux、 CentOS、openSUSE、Scientific Linux、Gentoo 等多个发行版的软件安装源和ISO下载服务，我们竭力为互联网用户提供全面，高效和稳定的软件服务。',0,0,0,0,'2018-05-23 10:55:01','2018-05-23 10:55:01'),(32,'banli','团队项目','Teambition | Team Collaboration Solutions','https://www.teambition.com/project/5af5be9e53d81501c2f1edbd/tasks/scrum/5af5be9e53d81501c2f1edbf','/ico/www.teambition.com.ico','Teambition is a simple, efficient project collaboration tool where you can manage projects, track progress, store project files, and make your team work more efficient.',0,0,0,0,'2018-05-23 21:42:54','2018-05-23 11:07:55'),(35,'banli','技术站点','Server Fault','https://serverfault.com/questions/890161/site-to-site-ipsec-routing-ubuntu-strongswan','/ico/serverfault.com.ico','Q&amp;A for system and network administrators',0,0,0,0,'2018-05-26 08:11:51','2018-05-23 21:41:52'),(36,'banli','工作','Sign in · GitLab','http://git.huanleguang.com/hyaf_zs/code','/ico/git.huanleguang.com.ico','GitLab Community Edition',0,0,0,0,'2018-05-23 23:25:57','2018-05-23 23:25:57'),(40,'banli','技术站点','Stack Overflow - Where Developers Learn, Share, &amp; Build Careers','https://stackoverflow.com/questions/29706933/tell-curl-to-read-hosts-file','/ico/stackoverflow.com.ico','Stack Overflow | The World’s Largest Online Community for Developers',0,0,0,0,'2018-05-24 05:10:32','2018-05-24 00:28:14'),(41,'banli','技术博客','SysAdmins | Linux Tutorials','https://sysadmins.co.za/setup-a-site-to-site-ipsec-vpn-with-strongswan-on-ubuntu/','/ico/sysadmins.co.za.png','Linux and Open Source Enthusiast.',0,0,0,0,'2018-05-26 09:47:10','2018-05-24 00:42:25'),(42,'banli','团队项目','聊天室','http://119.29.207.21:8001/group/supertool','/ico/example.png',NULL,0,0,0,0,'2018-05-24 05:11:14','2018-05-24 00:48:29'),(43,'banli','团队项目','板栗云','http://blog.cnfunny.cn/','/ico/blog.cnfunny.cn.ico','study from life.',0,0,0,0,'2018-05-26 09:47:43','2018-05-24 05:14:19'),(45,'banli','我的工具','Seafile','http://share.cnfunny.cn/','/ico/share.cnfunny.cn.ico','我的共享盘',0,0,0,0,'2018-05-24 09:04:45','2018-05-24 09:04:30'),(46,'banli','技术博客','nginx端口代理','http://www.hoohack.me/2015/12/10/nginx-non80-port-forward','/ico/www.hoohack.me.ico','personal blog',0,0,0,0,'2018-05-24 10:03:21','2018-05-24 10:03:21'),(47,'banli','常用站点','西部数码-云服务器、虚拟主机、域名注册15年老牌服务商！','https://www.west.cn/Manager/','http://www.west.cn/favicon.ico',NULL,0,0,0,0,'2018-05-26 08:04:01','2018-05-24 10:05:28'),(48,'banli','我的工具','宝塔面板（东京）','http://45.32.14.203:8888/site','/ico/www.bt.cn.ico','宝塔面板是一款使用方便、功能强大且终身免费的服务器管理软件，支持Linux与Windows系统。一键配置：LAMP/LNMP、网站、数据库、FTP、SSL，通过Web端轻松管理服务器。',0,0,0,0,'2018-05-24 10:46:12','2018-05-24 10:06:56'),(50,'default','常用站点','鸠摩搜索','https://www.jiumodiary.com/','/ico/www.jiumodiary.com.png','鸠摩搜索引擎',0,0,0,0,'2018-05-26 07:48:24','2018-05-26 07:48:24'),(51,'banli','默认','鸠摩搜索','https://www.jiumodiary.com/','/ico/www.jiumodiary.com.png','鸠摩搜索引擎',0,0,0,0,'2018-05-26 07:49:12','2018-05-26 07:49:12'),(52,'banli','常用站点','电影天堂_免费电影_迅雷电影下载','http://www.dytt8.net/','http://www.dytt8.net/favicon.ico',NULL,0,0,0,0,'2018-05-26 08:03:48','2018-05-26 07:53:05'),(53,'banli','github仓库收藏','github.com','https://github.com/nicoverbruggen/image-generator','/ico/github.com.ico','字符生成图片',0,0,0,0,'2018-05-26 09:51:55','2018-05-26 09:51:06'),(54,'banli','技术博客','SegmentFault 思否','https://segmentfault.com/a/1190000003776715','/ico/segmentfault.com.ico','页面 loading 效果的实现',0,0,0,0,'2018-05-26 11:29:38','2018-05-26 11:29:38'),(55,'banli','技术博客','69,300 Free Icons (SVG, PNG)','https://icons8.com/preloaders/','/ico/icons8.com.ico','loading gif生成',0,0,0,0,'2018-05-26 11:33:12','2018-05-26 11:30:53');
/*!40000 ALTER TABLE `sites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) NOT NULL DEFAULT '',
  `passwd` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(80) NOT NULL,
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `user_id_2` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'banli','320','banli@cnn.cn','2018-05-20 05:27:06','2018-05-20 05:27:06'),(2,'default','320','banli@cnn.cn','2018-05-20 10:38:36','2018-05-20 10:38:36'),(3,'test','test','banli@123','2018-05-21 07:49:17','2018-05-21 07:49:17');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-27  4:12:21
