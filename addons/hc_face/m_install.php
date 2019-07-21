<?php
pdo_query("DROP TABLE IF EXISTS `ims_hcface_avatar`;
CREATE TABLE IF NOT EXISTS `ims_hcface_avatar` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL,
`original` varchar(100) DEFAULT NULL,
`original_token` char(32) DEFAULT NULL,
`avatar` varchar(100) DEFAULT NULL,
`avatar_token` char(32) DEFAULT NULL,
`eye` varchar(100) NOT NULL,
`mouse` varchar(100) NOT NULL,
`nose` varchar(100) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_hcface_banner`;
CREATE TABLE IF NOT EXISTS `ims_hcface_banner` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL,
`title` varchar(100) NOT NULL,
`link` varchar(300) NOT NULL,
`banner` varchar(100) NOT NULL,
`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1关闭',
`displayorder` int(11) NOT NULL,
`createtime` char(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_hcface_cash`;
CREATE TABLE IF NOT EXISTS `ims_hcface_cash` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL,
`uid` int(11) NOT NULL,
`transid` varchar(20) NOT NULL,
`money` decimal(10,2) NOT NULL,
`fee` decimal(10,2) NOT NULL,
`type` tinyint(1) NOT NULL DEFAULT '0',
`status` tinyint(1) NOT NULL DEFAULT '0',
`createtime` char(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_hcface_commission`;
CREATE TABLE IF NOT EXISTS `ims_hcface_commission` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`sub_id` int(11) NOT NULL,
`trade_no` varchar(30) NOT NULL,
`goodsname` varchar(500) NOT NULL,
`goodsthumb` varchar(500) NOT NULL,
`price` decimal(10,2) NOT NULL,
`rate` int(11) NOT NULL,
`profit` decimal(10,2) NOT NULL,
`level` tinyint(1) NOT NULL,
`sort` tinyint(1) NOT NULL,
`status` tinyint(1) NOT NULL DEFAULT '0',
`freeze` tinyint(1) NOT NULL DEFAULT '0',
`createtime` char(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_hcface_goods`;
CREATE TABLE IF NOT EXISTS `ims_hcface_goods` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL,
`title` varchar(50) NOT NULL,
`ctitle` varchar(500) NOT NULL,
`desc` text NOT NULL,
`sub` varchar(200) NOT NULL,
`price` decimal(10,2) NOT NULL,
`oprice` decimal(10,2) NOT NULL,
`discount` int(11) NOT NULL,
`thumb` varchar(200) NOT NULL,
`sales` int(11) NOT NULL,
`type` varchar(5) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `ims_hcface_hand_report`;
CREATE TABLE IF NOT EXISTS `ims_hcface_hand_report` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL,
`uid` int(11) NOT NULL,
`aid` int(11) NOT NULL,
`name` varchar(100) NOT NULL,
`tel` varchar(15) NOT NULL,
`score` int(11) NOT NULL,
`type` text NOT NULL,
`zhihui` text NOT NULL,
`ganqing` text NOT NULL,
`shengming` text NOT NULL,
`zhixiang` text NOT NULL,
`yunshi` text NOT NULL,
`zinv` text NOT NULL,
`createtime` char(10) NOT NULL,
`unlock` tinyint(1) NOT NULL DEFAULT '0',
`isdelete` tinyint(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_hcface_nexus`;
CREATE TABLE IF NOT EXISTS `ims_hcface_nexus` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`pppid` int(11) NOT NULL,
`ppid` int(11) NOT NULL,
`pid` int(11) NOT NULL,
`uid` int(11) NOT NULL,
`ctime` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_hcface_order`;
CREATE TABLE IF NOT EXISTS `ims_hcface_order` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL,
`type` char(2) DEFAULT NULL,
`rid` int(11) NOT NULL,
`uid` int(11) DEFAULT NULL,
`openid` varchar(30) NOT NULL,
`title` varchar(300) NOT NULL,
`trade_no` varchar(30) DEFAULT NULL COMMENT '订单编号',
`transaction_id` varchar(50) NOT NULL,
`money` decimal(10,2) NOT NULL DEFAULT '0.00',
`status` tinyint(1) NOT NULL DEFAULT '0',
`createtime` char(10) NOT NULL,
`paytime` char(10) NOT NULL,
`isdelete` tinyint(1) DEFAULT NULL DEFAULT '0',
PRIMARY KEY (`id`),
KEY `weid` (`weid`),
KEY `uid` (`uid`),
KEY `trade_no` (`trade_no`),
KEY `gid` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_hcface_order_unlock`;
CREATE TABLE IF NOT EXISTS `ims_hcface_order_unlock` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`rid` int(11) NOT NULL,
`type` char(2) NOT NULL,
`uid` int(11) NOT NULL,
`createtime` char(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_hcface_paylog`;
CREATE TABLE IF NOT EXISTS `ims_hcface_paylog` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL,
`money` decimal(10,2) NOT NULL,
`uid` int(11) NOT NULL,
`openid` varchar(30) NOT NULL,
`trade_no` varchar(18) NOT NULL,
`transaction_id` varchar(50) NOT NULL,
`total_fee` decimal(10,2) NOT NULL,
`status` tinyint(1) NOT NULL DEFAULT '0',
`createtime` char(10) NOT NULL,
`paytime` char(10) NOT NULL,
PRIMARY KEY (`id`),
KEY `uid` (`uid`),
KEY `weid` (`weid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_hcface_report`;
CREATE TABLE IF NOT EXISTS `ims_hcface_report` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) DEFAULT NULL,
`uid` int(11) DEFAULT NULL,
`aid` int(11) DEFAULT NULL,
`name` varchar(50) DEFAULT NULL,
`summary` text DEFAULT NULL,
`score` tinyint(3) DEFAULT NULL,
`score_detail` varchar(200) DEFAULT NULL,
`top` varchar(200) DEFAULT NULL,
`eyebrow` varchar(200) DEFAULT NULL,
`eye` varchar(200) DEFAULT NULL,
`eye_desc` text DEFAULT NULL,
`mouse` varchar(200) DEFAULT NULL,
`mouse_desc` text DEFAULT NULL,
`nose` varchar(200) DEFAULT NULL,
`nose_desc` text DEFAULT NULL,
`five1` char(2) DEFAULT NULL,
`five1_rate` tinyint(2) DEFAULT NULL,
`five2` char(2) DEFAULT NULL,
`five2_rate` tinyint(2) DEFAULT NULL,
`five_desc` text DEFAULT NULL,
`emotion` text NOT NULL,
`cause` text NOT NULL,
`createtime` char(10) NOT NULL,
`unlock` tinyint(1) NOT NULL DEFAULT '0',
`tel` varchar(15) NOT NULL,
`isdelete` tinyint(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`),
KEY `uid` (`uid`),
KEY `aid` (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_hcface_setting`;
CREATE TABLE IF NOT EXISTS `ims_hcface_setting` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL DEFAULT '0',
`only` varchar(20) DEFAULT NULL,
`title` varchar(50) NOT NULL,
`value` text NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `only` (`only`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_hcface_upgrade`;
CREATE TABLE IF NOT EXISTS `ims_hcface_upgrade` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL,
`title` varchar(100) NOT NULL,
`trade_no` varchar(20) NOT NULL,
`uid` int(11) NOT NULL,
`openid` varchar(50) NOT NULL,
`price` decimal(10,2) NOT NULL,
`transaction_id` varchar(50) NOT NULL,
`createtime` char(10) NOT NULL,
`paytime` char(10) NOT NULL,
`status` tinyint(1) NOT NULL DEFAULT '0',
`level` tinyint(1) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_hcface_users`;
CREATE TABLE IF NOT EXISTS `ims_hcface_users` (
`uid` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL DEFAULT '0',
`pid` int(11) NOT NULL,
`avatar` varchar(200) DEFAULT NULL,
`nickname` varchar(50) DEFAULT NULL,
`openid` varchar(50) DEFAULT NULL,
`mobile` varchar(15) NOT NULL,
`sessionkey` varchar(50) NOT NULL,
`unionid` varchar(50) NOT NULL,
`gender` tinyint(1) NOT NULL,
`province` varchar(50) DEFAULT NULL,
`city` varchar(50) DEFAULT NULL,
`country` varchar(50) DEFAULT NULL,
`createtime` char(10) DEFAULT NULL,
`status` char(1) DEFAULT NULL DEFAULT '1',
`level` tinyint(1) NOT NULL DEFAULT '1',
`promo_code` varchar(300) NOT NULL,
`receipt_code` varchar(300) NOT NULL,
`vip` tinyint(1) NOT NULL DEFAULT '0',
`money` decimal(10,2) NOT NULL,
`black` tinyint(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`uid`),
UNIQUE KEY `uid` (`uid`),
UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");
