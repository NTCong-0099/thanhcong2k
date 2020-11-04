<?php

/**
 * @Project NUKEVIET 3.4
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 - 2012 VINADES.,JSC. All rights reserved
 * @Createdate Sun, 08 Apr 2012 00:00:00 GMT GMT
 */

if(!defined('NV_IS_FILE_MODULES'))die('Stop!!!');$sql_drop_module=array();$sql_drop_module[]="DROP TABLE IF EXISTS `".$db_config['prefix']."_".$lang."_".$module_data."`";$sql_drop_module[]="DROP TABLE IF EXISTS `".$db_config['prefix']."_".$lang."_".$module_data."_categories`";$sql_drop_module[]="DROP TABLE IF EXISTS `".$db_config['prefix']."_".$lang."_".$module_data."_config`";$sql_create_module=$sql_drop_module;$sql_create_module[]="CREATE TABLE IF NOT EXISTS `".$db_config['prefix']."_".$lang."_".$module_data."` (\n  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,\n  `catid` mediumint(8) unsigned NOT NULL,\n  `title` varchar(255) NOT NULL,\n  `alias` varchar(255) NOT NULL,\n  `question` mediumtext NOT NULL,\n  `answer` mediumtext NOT NULL,\n  `weight` smallint(4) unsigned NOT NULL DEFAULT '0',\n  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',\n  `addtime` int(11) unsigned NOT NULL DEFAULT '0',\n  PRIMARY KEY (`id`),\n  UNIQUE KEY `alias` (`alias`),\n  KEY `catid` (`catid`)\n)ENGINE=MyISAM";$sql_create_module[]="CREATE TABLE IF NOT EXISTS `".$db_config['prefix']."_".$lang."_".$module_data."_categories` (\n  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,\n  `parentid` mediumint(8) unsigned NOT NULL,\n  `title` varchar(255) NOT NULL,\n  `alias` varchar(255) NOT NULL,\n  `description` mediumtext NOT NULL,\n  `who_view` tinyint(1) unsigned NOT NULL DEFAULT '0',\n  `groups_view` varchar(255) NOT NULL,\n  `weight` smallint(4) unsigned NOT NULL DEFAULT '0',\n  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',\n  `keywords` mediumtext NOT NULL,\n  PRIMARY KEY (`id`),\n  UNIQUE KEY `alias` (`alias`)  \n)ENGINE=MyISAM";$sql_create_module[]="CREATE TABLE IF NOT EXISTS `".$db_config['prefix']."_".$lang."_".$module_data."_config` (\n  `config_name` varchar(30) NOT NULL,\n  `config_value` varchar(255) NOT NULL,\n  UNIQUE KEY `config_name` (`config_name`)\n)ENGINE=MyISAM";$sql_create_module[]="INSERT INTO `".$db_config['prefix']."_".$lang."_".$module_data."_config` VALUES\n('type_main', '0')";

?>