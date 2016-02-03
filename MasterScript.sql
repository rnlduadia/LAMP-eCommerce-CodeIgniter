-- MySQL dump 10.13  Distrib 5.1.57, for portbld-freebsd8.2 (i386)
--
-- Host: localhost    Database: dev_ot
-- ------------------------------------------------------
-- Server version	5.0.92-log

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
-- Not dumping tablespaces as no INFORMATION_SCHEMA.FILES table on this server
--

--
-- Table structure for table `admin_settings`
--
SET FOREIGN_KEY_CHECKS = 0; -- TOP

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `admin_settings` (
  `auth_apiLogin` text NOT NULL,
  `auth_apiKey` text NOT NULL,
  `auth_apiSandbox` int(11) NOT NULL,
  `supplier_selFee` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_supplier_payment`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `admin_supplier_payment` (
  `asp_id` int(11) NOT NULL auto_increment,
  `asp_amount` text NOT NULL,
  `u_id` int(11) NOT NULL COMMENT 'supplier id',
  `bnk_id` int(11) NOT NULL,
  `asp_date` text NOT NULL,
  `asp_auth_respond` text NOT NULL,
  `asp_value_send` text NOT NULL,
  `asp_summary` text NOT NULL,
  PRIMARY KEY  (`asp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bank_account`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `bank_account` (
  `bnk_id` int(11) NOT NULL auto_increment,
  `u_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `bnk_owner` text NOT NULL,
  `bnk_name` text NOT NULL,
  `bnk_address` text NOT NULL,
  `bnk_account` text NOT NULL,
  `bnk_id_code` text NOT NULL,
  PRIMARY KEY  (`bnk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `billing_address`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `billing_address` (
  `ba_id` int(11) NOT NULL auto_increment,
  `u_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `ba_add1` text NOT NULL,
  `ba_add2` text NOT NULL,
  `ba_city` text NOT NULL,
  `ba_province` text NOT NULL,
  `ba_postal` text NOT NULL,
  `ba_phone_num` text NOT NULL,
  `ba_phone_ext` text NOT NULL,
  `ba_isset` int(11) NOT NULL default '1',
  PRIMARY KEY  (`ba_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `brand`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `brand` (
  `b_id` int(11) NOT NULL auto_increment,
  `m_id` int(11) NOT NULL,
  `b_name` text NOT NULL,
  PRIMARY KEY  (`b_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `buyer_data_feed`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `buyer_data_feed` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `prod_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `buyer_data_feed_files`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `buyer_data_feed_files` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `filename` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(15) NOT NULL,
  `supplier_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `buyer_supplier_detail`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `buyer_supplier_detail` (
  `bsd_id` int(11) NOT NULL auto_increment,
  `bt_id` int(11) NOT NULL,
  `u_supplier` int(11) NOT NULL,
  `u_buyer` int(11) NOT NULL,
  `bsd_total_item` float NOT NULL,
  `bsd_total_paymet` float NOT NULL,
  `bsd_trans_id` text NOT NULL,
  `bsd_correlation_id` text NOT NULL,
  `bsd_ccv2match` text NOT NULL,
  `bsd_ack` text NOT NULL,
  `bsd_timestamp` text NOT NULL,
  `bsd_status` text NOT NULL,
  `bsd_reason` text NOT NULL,
  `bsd_is_feedback` int(11) NOT NULL,
  `bsd_buyer_rate` float NOT NULL,
  `bsd_buyer_feedback` text NOT NULL,
  `bsd_feedback_date` text NOT NULL,
  `bsd_memo` text NOT NULL,
  PRIMARY KEY  (`bsd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `buyer_supplier_message`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `buyer_supplier_message` (
  `bsm_id` int(11) NOT NULL auto_increment,
  `bsd_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `sender_type` text NOT NULL,
  `bsm_subject` text NOT NULL,
  `bsm_message` text NOT NULL,
  `bsm_reason` text NOT NULL,
  `bsm_time` text NOT NULL,
  `bsm_supplier_read` int(11) NOT NULL,
  `bsm_buyer_read` int(11) NOT NULL,
  `bsm_attachment` text NOT NULL,
  PRIMARY KEY  (`bsm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `buyer_supplier_reply`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `buyer_supplier_reply` (
  `bsr_id` int(11) NOT NULL auto_increment,
  `bsm_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `bsr_content` text NOT NULL,
  `bsr_time` text NOT NULL,
  `bsr_attachment` text NOT NULL,
  PRIMARY KEY  (`bsr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `buyer_transaction`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `buyer_transaction` (
  `bt_id` int(11) NOT NULL auto_increment,
  `bt_invoice` text NOT NULL,
  `u_id` int(11) NOT NULL,
  `ccu_id` int(11) NOT NULL,
  `ba_id` int(11) NOT NULL,
  `bt_type` text NOT NULL,
  `bt_trans_id` text NOT NULL,
  `bt_total_payment` float NOT NULL,
  `bt_total_shipping` float NOT NULL,
  `bt_total_item` int(11) NOT NULL,
  `bt_timestamp` text NOT NULL,
  `bt_correlation_id` text NOT NULL,
  `bt_ccv2match` text NOT NULL,
  `bt_ack` text NOT NULL,
  `bt_status` text NOT NULL,
  `bt_time` text NOT NULL,
  `bt_time_payed` text NOT NULL,
  `bt_is_sameBilling_to_ship` int(11) NOT NULL,
  PRIMARY KEY  (`bt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `buyer_transaction_detail`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `buyer_transaction_detail` (
  `btd_id` int(11) NOT NULL auto_increment,
  `bt_id` int(11) NOT NULL,
  `ic_id` int(11) NOT NULL,
  `btd_quan` int(11) NOT NULL,
  `btd_amount` float NOT NULL,
  `btd_shipamount` float NOT NULL,
  `btd_subamount` float NOT NULL,
  `btd_shipped_stat` int(11) NOT NULL,
  `btd_productFee` float default '0',
  PRIMARY KEY  (`btd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `buyer_transaction_ship`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `buyer_transaction_ship` (
  `bts_id` int(11) NOT NULL auto_increment,
  `bt_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `bts_name` text NOT NULL,
  `bts_add1` text NOT NULL,
  `bts_add2` text NOT NULL,
  `bts_city` text NOT NULL,
  `bts_prov` text NOT NULL,
  `bts_postal` text NOT NULL,
  `bts_phone_num` text NOT NULL,
  `bts_phone_ext` text NOT NULL,
  PRIMARY KEY  (`bts_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `category`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `category` (
  `c_id` int(11) NOT NULL auto_increment,
  `c_name` text NOT NULL,
  `c_default` int(11) NOT NULL,
  `c_parent` int(11) NOT NULL default '0',
  `c_level` int(11) NOT NULL default '0',
  `c_link` text NOT NULL,
  `c_feePercent` float NOT NULL,
  `c_default_image` text NOT NULL,
  `c_is_active` enum('0','1') default '1',
  PRIMARY KEY  (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ci_sessions`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `ip_address` varchar(45) NOT NULL default '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text NOT NULL,
  PRIMARY KEY  (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `config`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `config` (
  `config_name` varchar(255) NOT NULL,
  `config_value` longtext NOT NULL,
  `site_id` int(11) unsigned NOT NULL,
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `country`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `country` (
  `c_id` int(11) NOT NULL auto_increment,
  `c_code` text NOT NULL,
  `c_name` text NOT NULL,
  `c_long_name` text NOT NULL,
  `c_iso3` text NOT NULL,
  `c_numcode` text NOT NULL,
  `c_un_member` text NOT NULL,
  `c_calling_code` text NOT NULL,
  `c_ctld` text NOT NULL,
  PRIMARY KEY  (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `credit_card`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `credit_card` (
  `cc_id` int(11) NOT NULL auto_increment,
  `cc_type` text NOT NULL,
  PRIMARY KEY  (`cc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `credit_card_user`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `credit_card_user` (
  `ccu_id` int(11) NOT NULL auto_increment,
  `u_id` int(11) NOT NULL,
  `cc_id` int(11) NOT NULL,
  `ccu_name` text NOT NULL,
  `ccu_number` text NOT NULL,
  `ccu_ccv` text NOT NULL,
  `ccu_exp_month` text NOT NULL,
  `ccu_exp_year` text NOT NULL,
  `ccu_isset` text NOT NULL,
  PRIMARY KEY  (`ccu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `events`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) unsigned NOT NULL auto_increment COMMENT 'Event Primary Key',
  `event_number` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL COMMENT 'User ID',
  `server_id` int(11) unsigned default NULL COMMENT 'The ID of the remote log client',
  `remote_id` int(11) unsigned default NULL COMMENT 'The Event Primary Key from the remote client',
  `event_date` datetime NOT NULL COMMENT 'Event Datetime in local timezone',
  `event_date_utc` datetime NOT NULL COMMENT 'Event Datetime in UTC timezone',
  `event_type` varchar(255) NOT NULL COMMENT 'The type of event',
  `event_source` varchar(255) NOT NULL COMMENT 'Text description of the source of the event',
  `event_severity` varchar(255) NOT NULL COMMENT 'Notice, Warning etc',
  `event_file` text NOT NULL COMMENT 'The full file location of the source of the event',
  `event_file_line` int(11) NOT NULL COMMENT 'The line in the file that triggered the event',
  `event_ip_address` varchar(255) NOT NULL COMMENT 'IP Address of the user that triggered the event',
  `event_summary` varchar(255) default NULL COMMENT 'A summary of the description',
  `event_description` text NOT NULL COMMENT 'Full description of the event',
  `event_trace` longtext COMMENT 'Full PHP trace',
  `event_synced` int(1) unsigned default '0',
  `site_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `event_type` (`event_type`),
  KEY `event_source` (`event_source`),
  KEY `user_id` (`user_id`),
  KEY `server_id` (`server_id`),
  KEY `event_date` (`event_date`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `feed_template`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `feed_template` (
  `SKU` varchar(25) NOT NULL,
  `Barcode` varchar(16) default NULL,
  `Manufacturer_Part_Number` varchar(25) default NULL,
  `Manufacturer_Name` varchar(25) default NULL,
  `Brand_Name` varchar(25) default NULL,
  `Title` varchar(500) default NULL,
  `Description` varchar(2000) default NULL,
  `Category_ID` varchar(25) default NULL,
  `Weight` varchar(15) default NULL,
  `Ship_Alone` varchar(15) default NULL,
  `Height` varchar(15) default NULL,
  `Width` varchar(15) default NULL,
  `Depth` varchar(15) default NULL,
  `LeadTime` varchar(15) default NULL,
  `Quantity_In_Stock` varchar(5) default NULL,
  `Selling_Price` varchar(45) default NULL,
  `MSRP` varchar(45) default NULL,
  `Promo_Text` varchar(255) default NULL,
  `MAP` varchar(45) default NULL,
  `Shipping_Cost` varchar(45) default NULL,
  `ImageURL1` varchar(255) default NULL,
  `ImageURL2` varchar(255) default NULL,
  `ImageURL3` varchar(255) default NULL,
  `ImageURL4` varchar(255) default NULL,
  `ImageURL5` varchar(255) default NULL,
  PRIMARY KEY  (`SKU`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `import_history`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `import_history` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `inserted` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `type` int(1) NOT NULL default '0',
  `created_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inventory`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `inventory` (
  `i_id` int(11) NOT NULL auto_increment,
  `status`  enum('active','deleted') not null default 'active',
  `u_id` int(11) NOT NULL,
  `upc_ean` text NOT NULL,
  `manuf_num` text NOT NULL,
  `m_id` int(11) NOT NULL,
  `b_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `weight` text NOT NULL,
  `weightScale` text NOT NULL,
  `qty` int(11) NOT NULL,
  `sup_fee` float NOT NULL,
  `ship_alone` int(11) NOT NULL,
  `d_height` text NOT NULL,
  `d_width` text NOT NULL,
  `d_dept` text NOT NULL,
  `d_scale` text NOT NULL,
  `i_time` text NOT NULL,
  PRIMARY KEY  (`i_id`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inventory_child`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `inventory_child` (
  `ic_id` int(11) NOT NULL auto_increment,
  `i_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `SKU` text NOT NULL COMMENT 'Supplier type only',
  `ic_quan` int(11) NOT NULL,
  `ic_price` float NOT NULL,
  `ic_retail_price` float NOT NULL,
  `ic_leadtime` text NOT NULL,
  `ic_prom_text` text NOT NULL,
  `ic_time` text NOT NULL,
  `ic_map` text NOT NULL,
  `ic_ship_cost` float NOT NULL,
  `ic_ship_country` int(11) NOT NULL,
  `ic_min_order` int(11) NOT NULL default '1',
  `ic_case_pack` varchar(255) character set utf8 default NULL,
  PRIMARY KEY  (`ic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inventory_image`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `inventory_image` (
  `ii_id` int(11) NOT NULL auto_increment,
  `i_id` int(11) NOT NULL,
  `ii_link` text NOT NULL,
  `ii_name` text NOT NULL,
  `ii_feat` text NOT NULL,
  `ii_time` text NOT NULL,
  PRIMARY KEY  (`ii_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `manufacturer`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `manufacturer` (
  `m_id` int(11) NOT NULL auto_increment,
  `m_name` text NOT NULL,
  PRIMARY KEY  (`m_id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `message_notes`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `message_notes` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `message_id` int(11) unsigned NOT NULL,
  `site_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `message` longtext NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `site_id` (`site_id`),
  KEY `message_id` (`message_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `message_unread`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `message_unread` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `site_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `message_id` int(11) unsigned default NULL,
  `message_note_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `site_id` (`site_id`),
  KEY `message_id` (`message_id`),
  KEY `message_note_id` (`message_note_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `messages`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `site_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `from_user_id` int(11) unsigned NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `date_added` datetime NOT NULL,
  `last_modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `site_id` (`site_id`),
  KEY `user_id` (`user_id`),
  KEY `from_user_id` (`from_user_id`),
  KEY `last_modified` (`last_modified`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_cancel`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `order_cancel` (
  `ocl_id` int(11) NOT NULL auto_increment,
  `ocl_name` text NOT NULL,
  `user_type` int(11) NOT NULL,
  PRIMARY KEY  (`ocl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_refund`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `order_refund` (
  `or_id` int(11) NOT NULL auto_increment,
  `or_name` text NOT NULL,
  PRIMARY KEY  (`or_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_refund_record`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `order_refund_record` (
  `orr_id` int(11) NOT NULL auto_increment,
  `bsd_id` int(11) NOT NULL,
  `orr_date` text NOT NULL,
  `orr_prod_amnt` float NOT NULL,
  `orr_ship_amnt` float NOT NULL,
  `orr_total` float NOT NULL,
  `orr_reason` text NOT NULL,
  `orr_memo` text NOT NULL,
  PRIMARY KEY  (`orr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_return`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `order_return` (
  `o_ret_id` int(11) NOT NULL auto_increment,
  `o_ret_name` text NOT NULL,
  PRIMARY KEY  (`o_ret_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `permission`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `permission` (
  `p_id` int(11) NOT NULL auto_increment,
  `p_name` text NOT NULL,
  PRIMARY KEY  (`p_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `permission_assign`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `permission_assign` (
  `permission_id` int(11) NOT NULL auto_increment,
  `u_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  PRIMARY KEY  (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pop_accounts`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `pop_accounts` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) default NULL,
  `enabled` int(1) unsigned NOT NULL default '0',
  `hostname` varchar(255) NOT NULL,
  `port` int(11) NOT NULL default '110',
  `tls` int(1) NOT NULL default '0',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `download_files` int(1) NOT NULL default '0',
  `department_id` int(11) unsigned NOT NULL,
  `priority_id` int(11) unsigned NOT NULL,
  `leave_messages` int(1) NOT NULL default '0',
  `smtp_account_id` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `site_id` (`site_id`),
  KEY `enabled` (`enabled`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pop_messages`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `pop_messages` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `message_id` text NOT NULL,
  `site_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `message_id` (`message_id`(300)),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `processed_files`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `processed_files` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `path` (`path`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `queue`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `queue` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `data` longtext NOT NULL,
  `type` varchar(255) NOT NULL,
  `start_date` datetime default NULL,
  `date` datetime NOT NULL,
  `retry` int(11) unsigned default '0',
  `site_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scale`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `scale` (
  `s_id` int(11) NOT NULL auto_increment,
  `scale_name` text NOT NULL,
  PRIMARY KEY  (`s_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scale_dimension`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `scale_dimension` (
  `sd_id` int(11) NOT NULL auto_increment,
  `sd_name` text NOT NULL,
  PRIMARY KEY  (`sd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sessions`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(32) NOT NULL default '',
  `session_start` datetime NOT NULL,
  `session_start_utc` datetime NOT NULL,
  `session_expire` datetime NOT NULL,
  `session_expire_utc` datetime NOT NULL,
  `session_data` text,
  `session_active_key` varchar(32) default NULL,
  `ip_address` varchar(100) default NULL,
  `site_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`session_id`),
  KEY `session_expire` (`session_expire`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shipping_carrier`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `shipping_carrier` (
  `sc_id` int(11) NOT NULL auto_increment,
  `sc_name` text NOT NULL,
  `sc_desc` text NOT NULL,
  PRIMARY KEY  (`sc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shipping_carrier_country`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `shipping_carrier_country` (
  `scc_id` int(11) NOT NULL auto_increment,
  `sc_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY  (`scc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `smtp_accounts`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `smtp_accounts` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) default NULL,
  `enabled` int(1) unsigned NOT NULL default '0',
  `hostname` varchar(255) NOT NULL,
  `port` int(11) NOT NULL default '25',
  `tls` int(1) NOT NULL default '0',
  `authentication` int(1) NOT NULL default '0',
  `username` varchar(255) default NULL,
  `password` varchar(255) default NULL,
  `email_address` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `site_id` (`site_id`),
  KEY `enabled` (`enabled`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `state`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `state` (
  `st_id` int(11) NOT NULL auto_increment,
  `c_id` int(11) NOT NULL,
  `st_name` text NOT NULL,
  PRIMARY KEY  (`st_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `storage`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `storage` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `uuid` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `extension` varchar(255) default NULL,
  `description` text,
  `type` varchar(255) default NULL,
  `category_id` int(11) unsigned default NULL,
  `user_id` int(11) unsigned NOT NULL,
  `site_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `subscriptions`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `type` char(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `supplier_datafeeds`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `supplier_datafeeds` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `SKU` varchar(255) NOT NULL,
  `Barcode` bigint(20) NOT NULL,
  `Manufacturer_Part_Number` varchar(255) NOT NULL,
  `Manufacturer_Name` varchar(255) NOT NULL,
  `Brand_Name` varchar(255) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Category_ID` bigint(20) NOT NULL,
  `Ship_Alone` tinyint(1) NOT NULL,
  `Weight` int(11) NOT NULL,
  `Height` int(11) NOT NULL,
  `Width` int(11) NOT NULL,
  `Depth` int(11) NOT NULL,
  `LeadTime` int(11) NOT NULL,
  `Quantity_In_Stock` int(11) NOT NULL,
  `Selling_Price` int(11) NOT NULL,
  `MSRP` int(11) NOT NULL,
  `Promo_Text` varchar(255) NOT NULL,
  `MAP` float NOT NULL,
  `Shipping_Cost` float NOT NULL,
  `ImageURL1` text NOT NULL,
  `ImageURL2` text NOT NULL,
  `ImageURL3` text NOT NULL,
  `ImageURL4` text NOT NULL,
  `ImageURL5` text NOT NULL,
  `ImageURL6` text NOT NULL,
  `Case_Pack` int(11) NOT NULL,
  `Min_Order` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8194 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `supplier_shipprod_info`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `supplier_shipprod_info` (
  `ssi_id` int(11) NOT NULL auto_increment,
  `bsd_id` int(11) NOT NULL,
  `ssi_track` text NOT NULL,
  `ssi_shipMethod` text NOT NULL,
  `ssi_carrier` text NOT NULL,
  `ssi_country` int(11) NOT NULL,
  `ssi_start` text NOT NULL,
  `ssi_end` text NOT NULL,
  `ssi_time` text NOT NULL,
  `u_id` int(11) NOT NULL,
  `ssi_status` int(11) NOT NULL,
  `ssi_shipExtra` float NOT NULL,
  `ssi_supMemo` text NOT NULL,
  PRIMARY KEY  (`ssi_id`),
  KEY `ssi_id` (`ssi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `translation`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `translation` (
  `tr_id` int(11) NOT NULL auto_increment,
  `i_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `tr_title` text NOT NULL,
  `tr_short_desc` text NOT NULL,
  `tr_desc` text NOT NULL,
  `tr_time` text NOT NULL,
  PRIMARY KEY  (`tr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `user` (
  `u_id` int(11) NOT NULL auto_increment,
  `u_username` text NOT NULL,
  `u_pass` text NOT NULL,
  `u_fname` text NOT NULL,
  `u_lname` text NOT NULL,
  `u_email` text NOT NULL,
  `u_company` text NOT NULL,
  `u_permit` text NOT NULL,
  `u_type` int(11) NOT NULL,
  `u_status` int(11) NOT NULL,
  `u_admin_approve` int(11) NOT NULL default '0',
  `u_verify_code` text NOT NULL,
  `u_time` text NOT NULL,
  `u_pic` text NOT NULL,
  `u_superAdmin` int(11) NOT NULL default '0',
  `u_restriction` varchar(1000) NOT NULL default '',
  `u_return` varchar(1000) NOT NULL default '',
  PRIMARY KEY  (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_type`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `user_type` (
  `ut_id` int(11) NOT NULL auto_increment,
  `ut_name` text NOT NULL,
  `ut_protect` int(11) NOT NULL,
  PRIMARY KEY  (`ut_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-07-15 13:42:47

ALTER TABLE inventory_child
    ADD CONSTRAINT inventory_id_fk
    FOREIGN KEY(i_id)
    REFERENCES inventory(i_id);

ALTER TABLE inventory_image
    ADD CONSTRAINT inventory_image_id_fk
    FOREIGN KEY(i_id)
    REFERENCES inventory(i_id);

ALTER TABLE translation
    ADD CONSTRAINT translation_i_id_fk
    FOREIGN KEY(i_id)
    REFERENCES inventory(i_id);

SET FOREIGN_KEY_CHECKS = 1; -- BOTTOM
