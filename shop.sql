-- MySQL dump 10.13  Distrib 5.5.24, for Win32 (x86)
--
-- Host: localhost    Database: shop
-- ------------------------------------------------------
-- Server version	5.5.24-log

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
-- Table structure for table `sp_attribute`
--

DROP TABLE IF EXISTS `sp_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sp_attribute` (
  `attr_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `attr_name` varchar(32) NOT NULL COMMENT '属性名称',
  `type_id` smallint(5) unsigned NOT NULL COMMENT '归属类型，类型的主键id',
  `attr_sel` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0:输入框[后台维护商品处] 前台展示处[直接输出信息](唯一)  1:下拉列表[后台维护商品处] 单选按钮[前台展示处](多选)',
  `attr_write` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0:手工录入  1:从列表选择',
  `attr_vals` varchar(256) NOT NULL DEFAULT '' COMMENT '供下拉列表设置的选取项目,例如颜色：白色,红色,绿色,多个可选值通过逗号分隔',
  PRIMARY KEY (`attr_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='属性表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sp_attribute`
--

LOCK TABLES `sp_attribute` WRITE;
/*!40000 ALTER TABLE `sp_attribute` DISABLE KEYS */;
INSERT INTO `sp_attribute` VALUES (1,'屏幕尺寸',1,'0','0',''),(2,'颜色',1,'1','0','白色,黑色,金色,银色'),(3,'CPU处理器',1,'0','0',''),(4,'网络制式',1,'0','0',''),(5,'机身内存',1,'1','0','16G,32G,64G,128G'),(7,'待机时间',1,'0','0',''),(8,'作者',2,'0','0',''),(9,'出版社',2,'0','0',''),(10,'出版日期',2,'0','0',''),(11,'字数',2,'0','0',''),(12,'型号',3,'0','0',''),(13,'详细规格',3,'0','0',''),(14,'笔记本尺寸',3,'0','0',''),(15,'处理器类型',3,'0','0',''),(16,'配件',1,'1','0','线控耳机,蓝牙耳机,数据线'),(17,'手机类型',1,'1','0','翻盖,滑板,直板,折叠,智能');
/*!40000 ALTER TABLE `sp_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sp_auth`
--

DROP TABLE IF EXISTS `sp_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sp_auth` (
  `auth_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `auth_name` varchar(20) NOT NULL COMMENT '权限名称',
  `auth_pid` smallint(6) unsigned NOT NULL COMMENT '父id',
  `auth_c` varchar(32) NOT NULL DEFAULT '' COMMENT '控制器',
  `auth_a` varchar(32) NOT NULL DEFAULT '' COMMENT '操作方法',
  `auth_path` varchar(32) NOT NULL DEFAULT '' COMMENT '全路径',
  `auth_level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '权限等级，从0开始计数',
  PRIMARY KEY (`auth_id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sp_auth`
--

LOCK TABLES `sp_auth` WRITE;
/*!40000 ALTER TABLE `sp_auth` DISABLE KEYS */;
INSERT INTO `sp_auth` VALUES (101,'商品管理',0,'','','101',0),(102,'订单管理',0,'','','102',0),(103,'权限管理',0,'','','103',0),(104,'商品分类',101,'Category','showlist','101-104',1),(105,'商品列表',101,'Goods','showlist','101-105',1),(106,'添加商品',101,'Goods','add','101-106',1),(107,'订单列表',102,'Order','showlist','102-107',1),(108,'打印订单',102,'Order','dayin','102-108',1),(109,'添加订单',102,'Order','add','102-109',1),(110,'管理员列表',103,'Manager','showlist','103-110',1),(111,'角色列表',103,'Role','showlist','103-111',1),(112,'权限列表',103,'Auth','showlist','103-112',1),(114,'商品品牌',101,'brand','showlist','101-114',1),(115,'促销管理',0,'','','115',0),(116,'商品类型',101,'Type','showlist','101-116',1);
/*!40000 ALTER TABLE `sp_auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sp_goods`
--

DROP TABLE IF EXISTS `sp_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sp_goods` (
  `goods_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `goods_name` varchar(128) NOT NULL COMMENT '商品名称',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `goods_number` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '商品数量',
  `goods_weight` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品重量',
  `type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '类型id',
  `goods_introduce` text COMMENT '商品详情介绍',
  `brand_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品所属品牌',
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品所属分类',
  `goods_big_logo` char(128) NOT NULL DEFAULT '' COMMENT '图片logo大图',
  `goods_small_logo` char(128) NOT NULL DEFAULT '' COMMENT '图片logo小图',
  `sale_time` int(11) NOT NULL DEFAULT '0' COMMENT '商品上架时间',
  `is_del` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0:正常  1:删除',
  `add_time` int(11) NOT NULL COMMENT '添加商品时间',
  `upd_time` int(11) NOT NULL COMMENT '修改商品时间',
  PRIMARY KEY (`goods_id`),
  UNIQUE KEY `goods_name` (`goods_name`),
  KEY `goods_price` (`goods_price`),
  KEY `add_time` (`add_time`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='商品表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sp_goods`
--

LOCK TABLES `sp_goods` WRITE;
/*!40000 ALTER TABLE `sp_goods` DISABLE KEYS */;
INSERT INTO `sp_goods` VALUES (1,'OPPO R9',2499.00,100,129,0,'充电五分钟，通话两小时',0,0,'','',0,'0',1476941429,1476941429),(2,'小米Note2',2999.00,200,149,0,'一面成熟，一面天真。',0,0,'','',0,'0',1476941676,1476941676),(3,'三星Note7',4999.00,100,150,0,'小米出5，VIVO出7，华为出9，三星出炸!',0,0,'','',0,'0',1476954624,1476954624),(4,'魅族PRO6',2299.00,100,139,0,'&lt;p&gt;&lt;span style=&quot;color: rgb(255, 0, 0);&quot;&gt;小的大不一样&lt;/span&gt;&lt;/p&gt;',0,0,'','',0,'0',1476961010,1476961010),(5,'&lt;script&gt;alert(\'我来黑你了!\')&lt;/script&gt;',2000.00,200,200,0,'&lt;p&gt;水至清则无鱼&lt;/p&gt;',0,0,'','',0,'0',1476961180,1476961180),(6,'&lt;script&gt;alert(&quot;我要黑你&quot;)&lt;/script&gt;',100.00,100,100,0,'&lt;p&gt;我要黑你了哦&lt;br/&gt;&lt;/p&gt;',0,0,'','',0,'0',1476961492,1476961492),(7,'&lt;script&gt;alert(\'我黑你\')&lt;/script&gt;',1.00,1,1,0,'&lt;p&gt;&amp;lt;script&amp;gt;alert(&amp;#39;我要黑你。。&amp;#39;)&amp;lt;/script&amp;gt;&lt;/p&gt;',0,0,'','',0,'0',1476964533,1476964533),(8,'小米1',1999.00,100,139,0,'',0,0,'./Public/Upload/logo/2016-10-31/5816ecc236eb4.jpg','',0,'0',1477897410,1477897410),(9,'小米2',1999.00,200,129,0,'',0,0,'./Public/Upload/logo/2016-10-31/58171f2d5a321.jpg','./Public/Upload/logo/2016-10-31/small_58171f2d5a321.jpg',0,'0',1477910317,1477910317),(10,'小米3',1999.00,100,139,0,'<p>这是小米3<span style=\"color:rgb(255,0,0);\">手机</span>。</p>',0,0,'./Public/Upload/logo/2016-10-31/58173382e33bc.jpg','./Public/Upload/logo/2016-10-31/small_58173382e33bc.jpg',0,'0',1477915522,1477915522),(12,'小米4',1999.00,100,149,0,'<p>这是小米手机之<span style=\"color:rgb(255,0,0);\">小米4</span>。</p>',0,0,'./Public/Upload/logo/2016-10-31/581735de16314.jpg','./Public/Upload/logo/2016-10-31/small_581735de16314.jpg',0,'0',1477916126,1477932303),(13,'小米5',1999.00,200,129,0,'<p>知识小米手机之米5，<strong><span style=\"color:rgb(0,176,240);\">快的有点狠</span></strong>。</p>',0,0,'./Public/Upload/logo/2016-10-31/581736ec4c372.jpg','./Public/Upload/logo/2016-10-31/small_581736ec4c372.jpg',0,'0',1477916396,1477916396),(14,'小米6',1999.00,100,109,0,'<p>这是小米6。还没出世呢。。。</p>',0,0,'./Public/Upload/logo/2016-10-31/5817375ec342a.jpg','./Public/Upload/logo/2016-10-31/small_5817375ec342a.jpg',0,'0',1477916510,1477916510),(15,'小米7',1999.00,100,119,0,'<p>这是小米7，哈哈哈</p>',0,0,'./Public/Upload/logo/2016-10-31/5817385a46296.jpg','./Public/Upload/logo/2016-10-31/small_5817385a46296.jpg',0,'0',1477916762,1477916762),(16,'小米8',1999.00,10,100,0,'<p>这是小米8。。。</p>',0,0,'./Public/Upload/logo/2016-10-31/581738cf7bb65.jpg','./Public/Upload/logo/2016-10-31/small_581738cf7bb65.jpg',0,'0',1477916879,1477916879),(17,'小米99',1999.00,100,1000,0,'<p>小米9哇</p>',0,0,'./Public/Upload/logo/2016-10-31/581762c6863f7.jpg','./Public/Upload/logo/2016-10-31/small_581762c6863f7.jpg',0,'0',1477918166,1477927622),(18,'小米10',1999.00,100,119,0,'<p>这是小米手机之<span style=\"color:rgb(255,0,0);\">小米10</span>。</p>',0,0,'./Public/Upload/logo/2016-10-31/581762b7ccd47.jpg','./Public/Upload/logo/2016-10-31/small_581762b7ccd47.jpg',0,'0',1477925280,1477927607),(19,'小米笔记本',3999.00,100,2,0,'<p>这是小米笔记本。。</p>',0,0,'./Public/Upload/logo/2016-11-01/58176f7b56b5c.jpg','./Public/Upload/logo/2016-11-01/small_58176f7b56b5c.jpg',0,'0',1477930875,1477930875),(20,'小米11',1999.00,100,100,0,'<p>小米手机11</p>',0,0,'./Public/Upload/logo/2016-11-01/58176ff876a04.jpg','./Public/Upload/logo/2016-11-01/small_58176ff876a04.jpg',0,'0',1477931000,1477931000),(21,'三星S7',4999.00,100,120,0,'<p>三星S6。。</p>',0,0,'./Public/Upload/logo/2016-11-01/581771f58bb7f.jpg','./Public/Upload/logo/2016-11-01/small_581771f58bb7f.jpg',0,'0',1477931509,1477931509),(22,'三星S7edge',5000.00,100,120,0,'<p>三星S7edge</p>',0,0,'./Public/Upload/logo/2016-11-01/5817727ce7d75.jpg','./Public/Upload/logo/2016-11-01/small_5817727ce7d75.jpg',0,'0',1477931645,1477931645),(23,'小米66',1999.00,100,100,0,'<p>小米66666</p>',0,0,'./Public/Upload/logo/2016-11-01/581775ac20e95.jpg','./Public/Upload/logo/2016-11-01/small_581775ac20e95.jpg',0,'0',1477932460,1477932460),(24,'华为Mate9',3999.00,100,169,0,'<p>华为最新旗舰手机<span style=\"color:rgb(255,0,0);\">Mate9</span>要发布啦。</p>',0,0,'./Public/Upload/logo/2016-11-02/581a035868487.jpg','./Public/Upload/logo/2016-11-02/small_581a035868487.jpg',0,'0',1478099801,1478099801),(25,'iphone7',5388.00,20,120,1,'<p>iphone7</p><p><img src=\"/ueditor/php/upload/image/20161104/1478274666101193.jpg\" alt=\"1478274666101193.jpg\" /></p><p><img src=\"/ueditor/php/upload/image/20161104/1478274666115875.jpg\" alt=\"1478274666115875.jpg\" /></p><p><img src=\"/ueditor/php/upload/image/20161104/1478274666898632.jpg\" alt=\"1478274666898632.jpg\" /></p><p><img src=\"/ueditor/php/upload/image/20161104/1478274666299415.jpg\" alt=\"1478274666299415.jpg\" /></p><p><img src=\"/ueditor/php/upload/image/20161104/1478274666305439.jpg\" alt=\"1478274666305439.jpg\" /></p><p><img src=\"/ueditor/php/upload/image/20161104/1478274666989042.jpg\" alt=\"1478274666989042.jpg\" /></p><p><br /></p>',0,0,'./Public/Upload/logo/2016-11-04/581bfd509d9c9.jpg','./Public/Upload/logo/2016-11-04/small_581bfd509d9c9.jpg',0,'0',1478229329,1478409035),(26,'联想Y485笔记本电脑',6300.00,100,2,3,'<p>这是联想笔记本电脑</p><p><img src=\"/ueditor/php/upload/image/20161105/1478276933388447.jpg\" alt=\"1478276933388447.jpg\" /></p><p><img src=\"/ueditor/php/upload/image/20161105/1478276933100216.jpg\" alt=\"1478276933100216.jpg\" /></p><p><img src=\"/ueditor/php/upload/image/20161105/1478276933114963.jpg\" alt=\"1478276933114963.jpg\" /></p><p><img src=\"/ueditor/php/upload/image/20161105/1478276933134160.jpg\" alt=\"1478276933134160.jpg\" /></p><p><img src=\"/ueditor/php/upload/image/20161105/1478276933127714.jpg\" alt=\"1478276933127714.jpg\" /></p><p><img src=\"/ueditor/php/upload/image/20161105/1478276933663464.jpg\" alt=\"1478276933663464.jpg\" /></p><p><br /></p>',0,0,'./Public/Upload/logo/2016-11-05/581d409bcc054.jpg','./Public/Upload/logo/2016-11-05/small_581d409bcc054.jpg',0,'0',1478276947,1478408455);
/*!40000 ALTER TABLE `sp_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sp_goods_attr`
--

DROP TABLE IF EXISTS `sp_goods_attr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sp_goods_attr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `attr_id` smallint(5) unsigned NOT NULL COMMENT '属性id',
  `attr_value` varchar(32) NOT NULL COMMENT '商品对应属性的值',
  PRIMARY KEY (`id`),
  KEY `attr_id` (`attr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=165 DEFAULT CHARSET=utf8 COMMENT='商品-属性关联表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sp_goods_attr`
--

LOCK TABLES `sp_goods_attr` WRITE;
/*!40000 ALTER TABLE `sp_goods_attr` DISABLE KEYS */;
INSERT INTO `sp_goods_attr` VALUES (164,25,17,'智能'),(163,25,16,'蓝牙耳机'),(162,25,16,'线控耳机'),(161,25,7,'48小时'),(160,25,5,'16G'),(159,25,5,'64G'),(158,25,5,'128G'),(157,25,4,'4G+'),(156,25,3,'A10'),(154,25,2,'银色'),(155,25,2,'黑色'),(138,26,15,'酷睿Intel i7处理器'),(137,26,14,'15.6'),(136,26,13,'无'),(135,26,12,'联想Y485'),(153,25,2,'金色'),(152,25,1,'4.7');
/*!40000 ALTER TABLE `sp_goods_attr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sp_goods_pics`
--

DROP TABLE IF EXISTS `sp_goods_pics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sp_goods_pics` (
  `pics_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `pics_big` char(128) NOT NULL DEFAULT '' COMMENT '相册大图800*800',
  `pics_mid` char(128) NOT NULL DEFAULT '' COMMENT '相册中图350*350',
  `pics_sma` char(128) NOT NULL DEFAULT '' COMMENT '相册小图50*50',
  PRIMARY KEY (`pics_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='商品-相册关联表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sp_goods_pics`
--

LOCK TABLES `sp_goods_pics` WRITE;
/*!40000 ALTER TABLE `sp_goods_pics` DISABLE KEYS */;
INSERT INTO `sp_goods_pics` VALUES (12,23,'./Public/Upload/pictures/2016-11-01/big_581775ac5a27f.jpg','./Public/Upload/pictures/2016-11-01/mid_581775ac5a27f.jpg','./Public/Upload/pictures/2016-11-01/small_581775ac5a27f.jpg'),(10,12,'./Public/Upload/pictures/2016-11-01/big_5817750f967d0.jpg','./Public/Upload/pictures/2016-11-01/mid_5817750f967d0.jpg','./Public/Upload/pictures/2016-11-01/small_5817750f967d0.jpg'),(11,23,'./Public/Upload/pictures/2016-11-01/big_581775ac56dfa.jpg','./Public/Upload/pictures/2016-11-01/mid_581775ac56dfa.jpg','./Public/Upload/pictures/2016-11-01/small_581775ac56dfa.jpg'),(14,23,'./Public/Upload/pictures/2016-11-01/big_581775ac62561.jpg','./Public/Upload/pictures/2016-11-01/mid_581775ac62561.jpg','./Public/Upload/pictures/2016-11-01/small_581775ac62561.jpg'),(13,23,'./Public/Upload/pictures/2016-11-01/big_581775ac5d96e.jpg','./Public/Upload/pictures/2016-11-01/mid_581775ac5d96e.jpg','./Public/Upload/pictures/2016-11-01/small_581775ac5d96e.jpg'),(9,17,'./Public/Upload/pictures/2016-11-01/big_581774fb366ed.jpg','./Public/Upload/pictures/2016-11-01/mid_581774fb366ed.jpg','./Public/Upload/pictures/2016-11-01/small_581774fb366ed.jpg'),(7,18,'./Public/Upload/pictures/2016-10-31/big_581759a0e0b2a.jpg','./Public/Upload/pictures/2016-10-31/mid_581759a0e0b2a.jpg','./Public/Upload/pictures/2016-10-31/small_581759a0e0b2a.jpg'),(8,18,'./Public/Upload/pictures/2016-10-31/big_581759a0e3418.jpg','./Public/Upload/pictures/2016-10-31/mid_581759a0e3418.jpg','./Public/Upload/pictures/2016-10-31/small_581759a0e3418.jpg'),(15,24,'./Public/Upload/pictures/2016-11-02/big_581a03595b22e.jpg','./Public/Upload/pictures/2016-11-02/mid_581a03595b22e.jpg','./Public/Upload/pictures/2016-11-02/small_581a03595b22e.jpg'),(16,24,'./Public/Upload/pictures/2016-11-02/big_581a03595f1ef.jpg','./Public/Upload/pictures/2016-11-02/mid_581a03595f1ef.jpg','./Public/Upload/pictures/2016-11-02/small_581a03595f1ef.jpg'),(17,24,'./Public/Upload/pictures/2016-11-02/big_581a035962748.jpg','./Public/Upload/pictures/2016-11-02/mid_581a035962748.jpg','./Public/Upload/pictures/2016-11-02/small_581a035962748.jpg'),(18,25,'./Public/Upload/pictures/2016-11-04/big_581bfd5125b8b.jpg','./Public/Upload/pictures/2016-11-04/mid_581bfd5125b8b.jpg','./Public/Upload/pictures/2016-11-04/small_581bfd5125b8b.jpg'),(19,25,'./Public/Upload/pictures/2016-11-04/big_581bfd512b0b1.jpg','./Public/Upload/pictures/2016-11-04/mid_581bfd512b0b1.jpg','./Public/Upload/pictures/2016-11-04/small_581bfd512b0b1.jpg'),(20,25,'./Public/Upload/pictures/2016-11-04/big_581bfd512dc5a.jpg','./Public/Upload/pictures/2016-11-04/mid_581bfd512dc5a.jpg','./Public/Upload/pictures/2016-11-04/small_581bfd512dc5a.jpg'),(21,25,'./Public/Upload/pictures/2016-11-04/big_581caf9405155.jpg','./Public/Upload/pictures/2016-11-04/mid_581caf9405155.jpg','./Public/Upload/pictures/2016-11-04/small_581caf9405155.jpg'),(22,25,'./Public/Upload/pictures/2016-11-04/big_581cafaf8a636.jpg','./Public/Upload/pictures/2016-11-04/mid_581cafaf8a636.jpg','./Public/Upload/pictures/2016-11-04/small_581cafaf8a636.jpg'),(32,26,'./Public/Upload/pictures/2016-11-05/big_581d411876896.jpg','./Public/Upload/pictures/2016-11-05/mid_581d411876896.jpg','./Public/Upload/pictures/2016-11-05/small_581d411876896.jpg'),(24,25,'./Public/Upload/pictures/2016-11-04/big_581cafc02d86c.jpg','./Public/Upload/pictures/2016-11-04/mid_581cafc02d86c.jpg','./Public/Upload/pictures/2016-11-04/small_581cafc02d86c.jpg'),(31,26,'./Public/Upload/pictures/2016-11-05/big_581d410006a5d.jpg','./Public/Upload/pictures/2016-11-05/mid_581d410006a5d.jpg','./Public/Upload/pictures/2016-11-05/small_581d410006a5d.jpg'),(27,26,'./Public/Upload/pictures/2016-11-05/big_581cb75432f45.jpg','./Public/Upload/pictures/2016-11-05/mid_581cb75432f45.jpg','./Public/Upload/pictures/2016-11-05/small_581cb75432f45.jpg'),(28,26,'./Public/Upload/pictures/2016-11-05/big_581cb754351a1.jpg','./Public/Upload/pictures/2016-11-05/mid_581cb754351a1.jpg','./Public/Upload/pictures/2016-11-05/small_581cb754351a1.jpg'),(29,26,'./Public/Upload/pictures/2016-11-05/big_581cb7543729b.jpg','./Public/Upload/pictures/2016-11-05/mid_581cb7543729b.jpg','./Public/Upload/pictures/2016-11-05/small_581cb7543729b.jpg'),(30,26,'./Public/Upload/pictures/2016-11-05/big_581cb754388de.jpg','./Public/Upload/pictures/2016-11-05/mid_581cb754388de.jpg','./Public/Upload/pictures/2016-11-05/small_581cb754388de.jpg');
/*!40000 ALTER TABLE `sp_goods_pics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sp_manager`
--

DROP TABLE IF EXISTS `sp_manager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sp_manager` (
  `mg_id` int(11) NOT NULL AUTO_INCREMENT,
  `mg_name` varchar(32) NOT NULL,
  `mg_pwd` varchar(32) NOT NULL,
  `mg_time` int(10) unsigned NOT NULL COMMENT '时间',
  `role_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  PRIMARY KEY (`mg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sp_manager`
--

LOCK TABLES `sp_manager` WRITE;
/*!40000 ALTER TABLE `sp_manager` DISABLE KEYS */;
INSERT INTO `sp_manager` VALUES (1,'admin','123456',1364287269,0),(10,'jim','123456',1664287269,50),(11,'bob','123456',1365787269,51);
/*!40000 ALTER TABLE `sp_manager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sp_order`
--

DROP TABLE IF EXISTS `sp_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sp_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` mediumint(8) unsigned NOT NULL COMMENT '下订单会员id',
  `order_number` varchar(32) NOT NULL COMMENT '订单编号',
  `order_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单总金额',
  `order_pay` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '支付方式 0支付宝 1微信  2银行卡快捷支付',
  `order_fapiao_title` enum('0','1') NOT NULL DEFAULT '0' COMMENT '发票抬头 0个人 1公司',
  `order_fapiao_company` varchar(32) NOT NULL DEFAULT '' COMMENT '公司名称',
  `order_fapiao_content` varchar(32) NOT NULL DEFAULT '' COMMENT '发票内容',
  `cgn_id` int(10) unsigned NOT NULL COMMENT 'consignee收货人地址-外键',
  `order_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '订单状态： 0未付款、1已付款',
  `add_time` int(10) unsigned NOT NULL COMMENT '记录生成时间',
  `upd_time` int(10) unsigned NOT NULL COMMENT '记录修改时间',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_number` (`order_number`),
  KEY `cgn_id` (`cgn_id`),
  KEY `add_time` (`add_time`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='订单表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sp_order`
--

LOCK TABLES `sp_order` WRITE;
/*!40000 ALTER TABLE `sp_order` DISABLE KEYS */;
INSERT INTO `sp_order` VALUES (14,1,'itcastshop50-20161107012423-1605',38840.00,'0','0','','',12,'0',1478453063,1478453063),(15,1,'itcastshop50-20161107121424-6250',16776.00,'0','0','','',12,'0',1478492064,1478492064),(16,1,'itcastshop50-20161107150852-9764',5288.00,'0','0','','',12,'0',1478502532,1478502532),(17,1,'itcastshop50-20161107150952-6476',5288.00,'0','0','','',12,'0',1478502592,1478502592);
/*!40000 ALTER TABLE `sp_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sp_order_goods`
--

DROP TABLE IF EXISTS `sp_order_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sp_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `order_id` int(10) unsigned NOT NULL COMMENT '订单id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品单价',
  `goods_number` tinyint(4) NOT NULL DEFAULT '1' COMMENT '购买单个商品数量',
  `goods_total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品小计价格',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='商品订单关联表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sp_order_goods`
--

LOCK TABLES `sp_order_goods` WRITE;
/*!40000 ALTER TABLE `sp_order_goods` DISABLE KEYS */;
INSERT INTO `sp_order_goods` VALUES (31,14,25,5288.00,5,26440.00),(32,14,26,6200.00,2,12400.00),(33,15,25,5288.00,2,10576.00),(34,15,26,6200.00,1,6200.00),(35,16,25,5288.00,1,5288.00),(36,17,25,5288.00,1,5288.00);
/*!40000 ALTER TABLE `sp_order_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sp_role`
--

DROP TABLE IF EXISTS `sp_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sp_role` (
  `role_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL COMMENT '角色名称',
  `role_auth_ids` varchar(128) NOT NULL DEFAULT '' COMMENT '拥有操作权限id信息串,7,5',
  `role_auth_ac` text COMMENT '拥有操作权限对应的控制器/操作方法串，action/controller User-showlist,Order-showlist,控制器-操作,控制器-操作,控制器-操作',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sp_role`
--

LOCK TABLES `sp_role` WRITE;
/*!40000 ALTER TABLE `sp_role` DISABLE KEYS */;
INSERT INTO `sp_role` VALUES (50,'主管','101,104,105,106,114,116,102,108','Category-showlist,Goods-showlist,Goods-add,Order-dayin,brand-showlist,Type-showlist'),(51,'经理','101,105,106,102,107,108','Goods-showlist,Goods-add,Order-showlist,Order-dayin');
/*!40000 ALTER TABLE `sp_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sp_type`
--

DROP TABLE IF EXISTS `sp_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sp_type` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `type_name` varchar(32) NOT NULL COMMENT '类型名称',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='类型表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sp_type`
--

LOCK TABLES `sp_type` WRITE;
/*!40000 ALTER TABLE `sp_type` DISABLE KEYS */;
INSERT INTO `sp_type` VALUES (1,'手机'),(2,'书'),(3,'笔记本电脑');
/*!40000 ALTER TABLE `sp_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sp_user`
--

DROP TABLE IF EXISTS `sp_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sp_user` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_name` varchar(32) NOT NULL COMMENT '会员名称',
  `user_email` varchar(64) NOT NULL DEFAULT '' COMMENT '邮箱',
  `user_pwd` char(32) NOT NULL COMMENT '密码',
  `openid` char(32) NOT NULL DEFAULT '' COMMENT 'qq登录的openid信息',
  `user_sex` enum('男','女','保密') NOT NULL DEFAULT '男' COMMENT '性别',
  `user_check` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否激活, 0:未激活  1:已激活',
  `user_check_code` char(32) NOT NULL DEFAULT '' COMMENT '邮箱验证激活码',
  `add_time` int(11) NOT NULL COMMENT '注册时间',
  `is_del` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否删除, 0:正常  1:被删除',
  PRIMARY KEY (`user_id`),
  KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='会员表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sp_user`
--

LOCK TABLES `sp_user` WRITE;
/*!40000 ALTER TABLE `sp_user` DISABLE KEYS */;
INSERT INTO `sp_user` VALUES (1,'tom','tom@163.com','123','','男','1','',1456814643,'0'),(11,'mary','2226230644@qq.com','123','','男','1','',1460011681,'0'),(12,'bob','2226230644@qq.com','123','','男','1','',1460012413,'0'),(13,'jim','2226230644@qq.com','123','','男','1','d8e8003f57e2fd39a34b98230de33dc9',1460012763,'0'),(14,'bier','tom@163.com','123','','男','1','',1456814643,'0'),(15,'taishan','2226230644@qq.com','123','','男','1','',1460011681,'0'),(16,'linken','2226230644@qq.com','123','','男','1','',1460012413,'0'),(17,'joy','2226230644@qq.com','123','','男','1','',1460012763,'0');
/*!40000 ALTER TABLE `sp_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-07 15:19:05
