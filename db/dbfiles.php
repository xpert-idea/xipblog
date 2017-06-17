<?php

$querys = array();


$querys[] = "CREATE TABLE  IF NOT EXISTS `"._DB_PREFIX_."xipcategory` (
  `id_xipcategory` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_group` int(10) NOT NULL DEFAULT '0',
  `category_img` varchar(300) NOT NULL DEFAULT '',
  `category_type` varchar(300) NOT NULL DEFAULT '',
  `position`int(10) NOT NULL,
  `active` int(10) NOT NULL,
   PRIMARY KEY (`id_xipcategory`)
) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8";

$querys[] = "CREATE TABLE  IF NOT EXISTS `"._DB_PREFIX_."xipcategory_lang` (
  `id_xipcategory` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_lang` int(10) unsigned NULL ,
  `name` varchar(350) NOT NULL DEFAULT '',
  `link_rewrite` varchar(350) NOT NULL DEFAULT '',
  `title` varchar(350) NOT NULL DEFAULT '',
  `description` longtext,
  `meta_description` longtext,
  `keyword` text,
   PRIMARY KEY (`id_xipcategory`, `id_lang`)
) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8";

$querys[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "xipcategory_shop` (
	`id_xipcategory` int(11) NOT NULL,
	`id_shop` int(11) DEFAULT NULL,
	PRIMARY KEY (`id_xipcategory`,`id_shop`)
)ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8";

$querys[] = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."xipposts` (
  `id_xipposts` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `post_password` varchar(20) NOT NULL DEFAULT '',
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_parent` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `category_default` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_format` varchar(20) NOT NULL DEFAULT 'post',
  `post_img` varchar(300) NOT NULL DEFAULT '',
  `video` longtext NOT NULL,
  `audio` longtext NOT NULL,
  `gallery` longtext NOT NULL,
  `related_products` text NOT NULL,
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  `position`int(10) NOT NULL ,
  `active` int(10) NOT NULL,
  PRIMARY KEY (`id_xipposts`)
) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8";

$querys[] = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."xipposts_lang` (
  `id_xipposts` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_lang` int(10) unsigned NULL ,
  `post_title` text NOT NULL,
  `meta_title` varchar(300) NOT NULL DEFAULT '',
  `meta_description` longtext NOT NULL,
  `meta_keyword` longtext NOT NULL,
  `post_content` longtext NOT NULL,
  `post_excerpt` text NOT NULL,
  `link_rewrite` varchar(400) NOT NULL DEFAULT '',
   PRIMARY KEY (`id_xipposts`, `id_lang`)
) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8";

$querys[] = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "xipposts_shop` (
	`id_xipposts` int(11) NOT NULL,
	`id_shop` int(11) DEFAULT NULL,
	PRIMARY KEY (`id_xipposts`,`id_shop`)
)ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8" ;

$querys[] = "CREATE TABLE  IF NOT EXISTS `"._DB_PREFIX_."xippostmeta` (
  `id_xippostmeta` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_xipposts` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
   PRIMARY KEY (`id_xippostmeta`)
) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8";


$querys[] = "CREATE TABLE  IF NOT EXISTS `"._DB_PREFIX_."xip_image_type`(
  `id_xip_image_type` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `width` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `height` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_shop` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `active` int(11) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_xip_image_type`)
) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8";


$querys[] = "CREATE TABLE  IF NOT EXISTS `"._DB_PREFIX_."xip_category_post`(
  `id_xip_category_post` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_post` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_category` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_xip_category_post`)
) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8";

$querys[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'xip_comments`(
  `id_xip_comments` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `email` varchar(90) DEFAULT NULL,
  `subject` varchar(256) DEFAULT NULL,
  `website` varchar(128) DEFAULT NULL,
  `content` text,
  `id_parent` int(11) DEFAULT NULL,
  `id_post` int(11) DEFAULT NULL,
  `id_customer` int(11) DEFAULT NULL,
  `id_guest` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `uniqueid` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id_xip_comments`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8' ;

$querys_u = array();

$querys_u[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'xipposts`';
$querys_u[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'xippostmeta`';
$querys_u[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'xipcategory`';
$querys_u[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'xipposts_lang`';
$querys_u[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'xipcategory_lang`';
$querys_u[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'xipposts_shop`';
$querys_u[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'xipcategory_shop`';
$querys_u[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'xip_image_type`';
$querys_u[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'xip_category_post`';
$querys_u[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'xip_comments`';