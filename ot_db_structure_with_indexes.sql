-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 14, 2014 at 08:06 AM
-- Server version: 5.5.38
-- PHP Version: 5.3.10-1ubuntu3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `OceanTailer`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

CREATE TABLE IF NOT EXISTS `admin_settings` (
  `auth_apiLogin` text NOT NULL,
  `auth_apiKey` text NOT NULL,
  `auth_apiSandbox` int(11) NOT NULL,
  `supplier_selFee` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_supplier_payment`
--

CREATE TABLE IF NOT EXISTS `admin_supplier_payment` (
  `asp_id` int(11) NOT NULL AUTO_INCREMENT,
  `asp_amount` text NOT NULL,
  `u_id` int(11) NOT NULL COMMENT 'supplier id',
  `bnk_id` int(11) NOT NULL,
  `asp_date` text NOT NULL,
  `asp_auth_respond` text NOT NULL,
  `asp_value_send` text NOT NULL,
  `asp_summary` text NOT NULL,
  PRIMARY KEY (`asp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `apruve_requests`
--

CREATE TABLE IF NOT EXISTS `apruve_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bt_id` int(11) NOT NULL,
  `request_id` varchar(255) NOT NULL,
  `total_cents` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Table structure for table `bank_account`
--

CREATE TABLE IF NOT EXISTS `bank_account` (
  `bnk_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `bnk_owner` text NOT NULL,
  `bnk_name` text NOT NULL,
  `bnk_address` text NOT NULL,
  `bnk_account` text NOT NULL,
  `bnk_id_code` text NOT NULL,
  PRIMARY KEY (`bnk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `billing_address`
--

CREATE TABLE IF NOT EXISTS `billing_address` (
  `ba_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `ba_add1` text NOT NULL,
  `ba_add2` text NOT NULL,
  `ba_city` text NOT NULL,
  `ba_province` text NOT NULL,
  `ba_postal` text NOT NULL,
  `ba_phone_num` text NOT NULL,
  `ba_phone_ext` text NOT NULL,
  `ba_isset` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ba_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE IF NOT EXISTS `brand` (
  `b_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_id` int(11) NOT NULL,
  `b_name` text NOT NULL,
  PRIMARY KEY (`b_id`),
  KEY `brand_m_id` (`m_id`),
  KEY `brand_b_name` (`b_name`(255))
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=207 ;

-- --------------------------------------------------------

--
-- Table structure for table `buyer_data_feed`
--

CREATE TABLE IF NOT EXISTS `buyer_data_feed` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `prod_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Table structure for table `buyer_data_feed_files`
--

CREATE TABLE IF NOT EXISTS `buyer_data_feed_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `filename` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(15) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `buyer_supplier_detail`
--

CREATE TABLE IF NOT EXISTS `buyer_supplier_detail` (
  `bsd_id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`bsd_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `buyer_supplier_message`
--

CREATE TABLE IF NOT EXISTS `buyer_supplier_message` (
  `bsm_id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`bsm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `buyer_supplier_reply`
--

CREATE TABLE IF NOT EXISTS `buyer_supplier_reply` (
  `bsr_id` int(11) NOT NULL AUTO_INCREMENT,
  `bsm_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `bsr_content` text NOT NULL,
  `bsr_time` text NOT NULL,
  `bsr_attachment` text NOT NULL,
  PRIMARY KEY (`bsr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `buyer_transaction`
--

CREATE TABLE IF NOT EXISTS `buyer_transaction` (
  `bt_id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`bt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `buyer_transaction_detail`
--

CREATE TABLE IF NOT EXISTS `buyer_transaction_detail` (
  `btd_id` int(11) NOT NULL AUTO_INCREMENT,
  `bt_id` int(11) NOT NULL,
  `ic_id` int(11) NOT NULL,
  `btd_quan` int(11) NOT NULL,
  `btd_amount` float NOT NULL,
  `btd_shipamount` float NOT NULL,
  `btd_subamount` float NOT NULL,
  `btd_shipped_stat` int(11) NOT NULL,
  `btd_productFee` float DEFAULT '0',
  PRIMARY KEY (`btd_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `buyer_transaction_ship`
--

CREATE TABLE IF NOT EXISTS `buyer_transaction_ship` (
  `bts_id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`bts_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` text NOT NULL,
  `c_default` int(11) NOT NULL,
  `c_parent` int(11) NOT NULL DEFAULT '0',
  `c_level` int(11) NOT NULL DEFAULT '0',
  `c_link` text NOT NULL,
  `c_feePercent` float NOT NULL,
  `c_default_image` text NOT NULL,
  `c_is_active` enum('0','1') DEFAULT '1',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=247 ;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `config_name` varchar(255) NOT NULL,
  `config_value` longtext NOT NULL,
  `site_id` int(11) unsigned NOT NULL,
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_code` text NOT NULL,
  `c_name` text NOT NULL,
  `c_long_name` text NOT NULL,
  `c_iso3` text NOT NULL,
  `c_numcode` text NOT NULL,
  `c_un_member` text NOT NULL,
  `c_calling_code` text NOT NULL,
  `c_ctld` text NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=251 ;

-- --------------------------------------------------------

--
-- Table structure for table `credit_card`
--

CREATE TABLE IF NOT EXISTS `credit_card` (
  `cc_id` int(11) NOT NULL AUTO_INCREMENT,
  `cc_type` text NOT NULL,
  PRIMARY KEY (`cc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `credit_card_user`
--

CREATE TABLE IF NOT EXISTS `credit_card_user` (
  `ccu_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `cc_id` int(11) NOT NULL,
  `ccu_name` text NOT NULL,
  `ccu_number` text NOT NULL,
  `ccu_ccv` text NOT NULL,
  `ccu_exp_month` text NOT NULL,
  `ccu_exp_year` text NOT NULL,
  `ccu_isset` text NOT NULL,
  PRIMARY KEY (`ccu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Event Primary Key',
  `event_number` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL COMMENT 'User ID',
  `server_id` int(11) unsigned DEFAULT NULL COMMENT 'The ID of the remote log client',
  `remote_id` int(11) unsigned DEFAULT NULL COMMENT 'The Event Primary Key from the remote client',
  `event_date` datetime NOT NULL COMMENT 'Event Datetime in local timezone',
  `event_date_utc` datetime NOT NULL COMMENT 'Event Datetime in UTC timezone',
  `event_type` varchar(255) NOT NULL COMMENT 'The type of event',
  `event_source` varchar(255) NOT NULL COMMENT 'Text description of the source of the event',
  `event_severity` varchar(255) NOT NULL COMMENT 'Notice, Warning etc',
  `event_file` text NOT NULL COMMENT 'The full file location of the source of the event',
  `event_file_line` int(11) NOT NULL COMMENT 'The line in the file that triggered the event',
  `event_ip_address` varchar(255) NOT NULL COMMENT 'IP Address of the user that triggered the event',
  `event_summary` varchar(255) DEFAULT NULL COMMENT 'A summary of the description',
  `event_description` text NOT NULL COMMENT 'Full description of the event',
  `event_trace` longtext COMMENT 'Full PHP trace',
  `event_synced` int(1) unsigned DEFAULT '0',
  `site_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_type` (`event_type`),
  KEY `event_source` (`event_source`),
  KEY `user_id` (`user_id`),
  KEY `server_id` (`server_id`),
  KEY `event_date` (`event_date`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `feed_template`
--

CREATE TABLE IF NOT EXISTS `feed_template` (
  `SKU` varchar(25) NOT NULL,
  `Barcode` varchar(16) DEFAULT NULL,
  `Manufacturer_Part_Number` varchar(25) DEFAULT NULL,
  `Manufacturer_Name` varchar(25) DEFAULT NULL,
  `Brand_Name` varchar(25) DEFAULT NULL,
  `Title` varchar(500) DEFAULT NULL,
  `Description` varchar(2000) DEFAULT NULL,
  `Category_ID` varchar(25) DEFAULT NULL,
  `Weight` varchar(15) DEFAULT NULL,
  `Ship_Alone` varchar(15) DEFAULT NULL,
  `Height` varchar(15) DEFAULT NULL,
  `Width` varchar(15) DEFAULT NULL,
  `Depth` varchar(15) DEFAULT NULL,
  `LeadTime` varchar(15) DEFAULT NULL,
  `Quantity_In_Stock` varchar(5) DEFAULT NULL,
  `Selling_Price` varchar(45) DEFAULT NULL,
  `MSRP` varchar(45) DEFAULT NULL,
  `Promo_Text` varchar(255) DEFAULT NULL,
  `MAP` varchar(45) DEFAULT NULL,
  `Shipping_Cost` varchar(45) DEFAULT NULL,
  `ImageURL1` varchar(255) DEFAULT NULL,
  `ImageURL2` varchar(255) DEFAULT NULL,
  `ImageURL3` varchar(255) DEFAULT NULL,
  `ImageURL4` varchar(255) DEFAULT NULL,
  `ImageURL5` varchar(255) DEFAULT NULL,
  `ImageURL6` varchar(255) DEFAULT NULL,
  `Case Pack` varchar(3) DEFAULT NULL,
  `Min Order` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`SKU`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `import_history`
--

CREATE TABLE IF NOT EXISTS `import_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `success` int(11) NOT NULL,
  `result_id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `inserted` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `type` int(1) NOT NULL DEFAULT '0',
  `file_type` varchar(255) NOT NULL DEFAULT 'csv',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `import_result`
--

CREATE TABLE IF NOT EXISTS `import_result` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `results` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`i_id`),
  KEY `inventory_u_id` (`u_id`),
  KEY `inventory_m_id` (`m_id`),
  KEY `inventory_b_id` (`b_id`),
  KEY `inventory_c_id` (`c_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65033 ;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_child`
--

CREATE TABLE IF NOT EXISTS `inventory_child` (
  `ic_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `ic_case_pack` int(3) DEFAULT '1',
  `ic_min_order` int(3) DEFAULT '1',
  PRIMARY KEY (`ic_id`),
  KEY `inventory_child_i_id` (`i_id`),
  KEY `inventory_child_u_id` (`u_id`),
  KEY `inventory_child_ic_price` (`ic_price`),
  KEY `inventory_child_ic_retail_price` (`ic_retail_price`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64923 ;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_image`
--

CREATE TABLE IF NOT EXISTS `inventory_image` (
  `ii_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_id` int(11) NOT NULL,
  `ii_link` text NOT NULL,
  `ii_name` text NOT NULL,
  `ii_feat` text NOT NULL,
  `ii_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ii_id`),
  KEY `inventory_image_i_id` (`i_id`),
  KEY `inventory_image_ii_feat` (`ii_feat`(2))
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=571058 ;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

CREATE TABLE IF NOT EXISTS `manufacturer` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_name` text NOT NULL,
  PRIMARY KEY (`m_id`),
  KEY `manufacturer_m_name` (`m_name`(255))
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=223 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `from_user_id` int(11) unsigned NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `date_added` datetime NOT NULL,
  `last_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `user_id` (`user_id`),
  KEY `from_user_id` (`from_user_id`),
  KEY `last_modified` (`last_modified`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `message_notes`
--

CREATE TABLE IF NOT EXISTS `message_notes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(11) unsigned NOT NULL,
  `site_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `message` longtext NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `message_id` (`message_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `message_unread`
--

CREATE TABLE IF NOT EXISTS `message_unread` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `message_id` int(11) unsigned DEFAULT NULL,
  `message_note_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `message_id` (`message_id`),
  KEY `message_note_id` (`message_note_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_cancel`
--

CREATE TABLE IF NOT EXISTS `order_cancel` (
  `ocl_id` int(11) NOT NULL AUTO_INCREMENT,
  `ocl_name` text NOT NULL,
  `user_type` int(11) NOT NULL,
  PRIMARY KEY (`ocl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_refund`
--

CREATE TABLE IF NOT EXISTS `order_refund` (
  `or_id` int(11) NOT NULL AUTO_INCREMENT,
  `or_name` text NOT NULL,
  PRIMARY KEY (`or_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_refund_record`
--

CREATE TABLE IF NOT EXISTS `order_refund_record` (
  `orr_id` int(11) NOT NULL AUTO_INCREMENT,
  `bsd_id` int(11) NOT NULL,
  `orr_date` text NOT NULL,
  `orr_prod_amnt` float NOT NULL,
  `orr_ship_amnt` float NOT NULL,
  `orr_total` float NOT NULL,
  `orr_reason` text NOT NULL,
  `orr_memo` text NOT NULL,
  PRIMARY KEY (`orr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_return`
--

CREATE TABLE IF NOT EXISTS `order_return` (
  `o_ret_id` int(11) NOT NULL AUTO_INCREMENT,
  `o_ret_name` text NOT NULL,
  PRIMARY KEY (`o_ret_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_name` text NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `permission_assign`
--

CREATE TABLE IF NOT EXISTS `permission_assign` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=199 ;

-- --------------------------------------------------------

--
-- Table structure for table `pop_accounts`
--

CREATE TABLE IF NOT EXISTS `pop_accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `enabled` int(1) unsigned NOT NULL DEFAULT '0',
  `hostname` varchar(255) NOT NULL,
  `port` int(11) NOT NULL DEFAULT '110',
  `tls` int(1) NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `download_files` int(1) NOT NULL DEFAULT '0',
  `department_id` int(11) unsigned NOT NULL,
  `priority_id` int(11) unsigned NOT NULL,
  `leave_messages` int(1) NOT NULL DEFAULT '0',
  `smtp_account_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `enabled` (`enabled`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pop_messages`
--

CREATE TABLE IF NOT EXISTS `pop_messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` text NOT NULL,
  `site_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `message_id` (`message_id`(300)),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `processed_files`
--

CREATE TABLE IF NOT EXISTS `processed_files` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `path` (`path`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE IF NOT EXISTS `queue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `data` longtext NOT NULL,
  `type` varchar(255) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `date` datetime NOT NULL,
  `retry` int(11) unsigned DEFAULT '0',
  `site_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `scale`
--

CREATE TABLE IF NOT EXISTS `scale` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `scale_name` text NOT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `scale_dimension`
--

CREATE TABLE IF NOT EXISTS `scale_dimension` (
  `sd_id` int(11) NOT NULL AUTO_INCREMENT,
  `sd_name` text NOT NULL,
  PRIMARY KEY (`sd_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(32) NOT NULL DEFAULT '',
  `session_start` datetime NOT NULL,
  `session_start_utc` datetime NOT NULL,
  `session_expire` datetime NOT NULL,
  `session_expire_utc` datetime NOT NULL,
  `session_data` text,
  `session_active_key` varchar(32) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `site_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `session_expire` (`session_expire`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_carrier`
--

CREATE TABLE IF NOT EXISTS `shipping_carrier` (
  `sc_id` int(11) NOT NULL AUTO_INCREMENT,
  `sc_name` text NOT NULL,
  `sc_desc` text NOT NULL,
  PRIMARY KEY (`sc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_carrier_country`
--

CREATE TABLE IF NOT EXISTS `shipping_carrier_country` (
  `scc_id` int(11) NOT NULL AUTO_INCREMENT,
  `sc_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY (`scc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `smtp_accounts`
--

CREATE TABLE IF NOT EXISTS `smtp_accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `enabled` int(1) unsigned NOT NULL DEFAULT '0',
  `hostname` varchar(255) NOT NULL,
  `port` int(11) NOT NULL DEFAULT '25',
  `tls` int(1) NOT NULL DEFAULT '0',
  `authentication` int(1) NOT NULL DEFAULT '0',
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `enabled` (`enabled`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE IF NOT EXISTS `state` (
  `st_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `st_name` text NOT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE IF NOT EXISTS `storage` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `uuid` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `extension` varchar(255) DEFAULT NULL,
  `description` text,
  `type` varchar(255) DEFAULT NULL,
  `category_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `site_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `type` char(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_datafeeds`
--

CREATE TABLE IF NOT EXISTS `supplier_datafeeds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`),
  KEY `supplier_datafeeds_user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=479982 ;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_shipprod_info`
--

CREATE TABLE IF NOT EXISTS `supplier_shipprod_info` (
  `ssi_id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`ssi_id`),
  KEY `ssi_id` (`ssi_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `translation`
--

CREATE TABLE IF NOT EXISTS `translation` (
  `tr_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `tr_title` text NOT NULL,
  `tr_short_desc` text NOT NULL,
  `tr_desc` text NOT NULL,
  `tr_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tr_id`),
  KEY `translation_i_id` (`i_id`),
  KEY `translation_c_id` (`c_id`),
  KEY `translation_tr_title` (`tr_title`(255))
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65068 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_username` text NOT NULL,
  `u_pass` text NOT NULL,
  `u_fname` text NOT NULL,
  `u_lname` text NOT NULL,
  `u_email` text NOT NULL,
  `u_company` text NOT NULL,
  `u_permit` text NOT NULL,
  `u_type` int(11) NOT NULL,
  `u_status` int(11) NOT NULL,
  `u_admin_approve` int(11) NOT NULL DEFAULT '0',
  `u_verify_code` text NOT NULL,
  `u_time` text NOT NULL,
  `u_pic` text NOT NULL,
  `u_superAdmin` int(11) NOT NULL DEFAULT '0',
  `u_restriction` varchar(1000) NOT NULL DEFAULT '',
  `u_return` varchar(1000) NOT NULL DEFAULT '',
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE IF NOT EXISTS `user_type` (
  `ut_id` int(11) NOT NULL AUTO_INCREMENT,
  `ut_name` text NOT NULL,
  `ut_protect` int(11) NOT NULL,
  PRIMARY KEY (`ut_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
