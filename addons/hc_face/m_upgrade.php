<?php
pdo_query("CREATE TABLE IF NOT EXISTS `ims_hcface_avatar` (
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

CREATE TABLE IF NOT EXISTS `ims_hcface_nexus` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`pppid` int(11) NOT NULL,
`ppid` int(11) NOT NULL,
`pid` int(11) NOT NULL,
`uid` int(11) NOT NULL,
`ctime` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_hcface_order_unlock` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`rid` int(11) NOT NULL,
`type` char(2) NOT NULL,
`uid` int(11) NOT NULL,
`createtime` char(10) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `ims_hcface_setting` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL DEFAULT '0',
`only` varchar(20) DEFAULT NULL,
`title` varchar(50) NOT NULL,
`value` text NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `only` (`only`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
if(pdo_tableexists('hcface_avatar')) {
	if(!pdo_fieldexists('hcface_avatar',  'id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_avatar')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('hcface_avatar')) {
	if(!pdo_fieldexists('hcface_avatar',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_avatar')." ADD `weid` int(11) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_avatar')) {
	if(!pdo_fieldexists('hcface_avatar',  'original')) {
		pdo_query("ALTER TABLE ".tablename('hcface_avatar')." ADD `original` varchar(100) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_avatar')) {
	if(!pdo_fieldexists('hcface_avatar',  'original_token')) {
		pdo_query("ALTER TABLE ".tablename('hcface_avatar')." ADD `original_token` char(32) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_avatar')) {
	if(!pdo_fieldexists('hcface_avatar',  'avatar')) {
		pdo_query("ALTER TABLE ".tablename('hcface_avatar')." ADD `avatar` varchar(100) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_avatar')) {
	if(!pdo_fieldexists('hcface_avatar',  'avatar_token')) {
		pdo_query("ALTER TABLE ".tablename('hcface_avatar')." ADD `avatar_token` char(32) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_avatar')) {
	if(!pdo_fieldexists('hcface_avatar',  'eye')) {
		pdo_query("ALTER TABLE ".tablename('hcface_avatar')." ADD `eye` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_avatar')) {
	if(!pdo_fieldexists('hcface_avatar',  'mouse')) {
		pdo_query("ALTER TABLE ".tablename('hcface_avatar')." ADD `mouse` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_avatar')) {
	if(!pdo_fieldexists('hcface_avatar',  'nose')) {
		pdo_query("ALTER TABLE ".tablename('hcface_avatar')." ADD `nose` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_banner')) {
	if(!pdo_fieldexists('hcface_banner',  'id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_banner')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('hcface_banner')) {
	if(!pdo_fieldexists('hcface_banner',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_banner')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_banner')) {
	if(!pdo_fieldexists('hcface_banner',  'title')) {
		pdo_query("ALTER TABLE ".tablename('hcface_banner')." ADD `title` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_banner')) {
	if(!pdo_fieldexists('hcface_banner',  'link')) {
		pdo_query("ALTER TABLE ".tablename('hcface_banner')." ADD `link` varchar(300) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_banner')) {
	if(!pdo_fieldexists('hcface_banner',  'banner')) {
		pdo_query("ALTER TABLE ".tablename('hcface_banner')." ADD `banner` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_banner')) {
	if(!pdo_fieldexists('hcface_banner',  'status')) {
		pdo_query("ALTER TABLE ".tablename('hcface_banner')." ADD `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1关闭';");
	}	
}
if(pdo_tableexists('hcface_banner')) {
	if(!pdo_fieldexists('hcface_banner',  'displayorder')) {
		pdo_query("ALTER TABLE ".tablename('hcface_banner')." ADD `displayorder` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_banner')) {
	if(!pdo_fieldexists('hcface_banner',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('hcface_banner')." ADD `createtime` char(10) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_cash')) {
	if(!pdo_fieldexists('hcface_cash',  'id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_cash')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('hcface_cash')) {
	if(!pdo_fieldexists('hcface_cash',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_cash')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_cash')) {
	if(!pdo_fieldexists('hcface_cash',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_cash')." ADD `uid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_cash')) {
	if(!pdo_fieldexists('hcface_cash',  'transid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_cash')." ADD `transid` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_cash')) {
	if(!pdo_fieldexists('hcface_cash',  'money')) {
		pdo_query("ALTER TABLE ".tablename('hcface_cash')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_cash')) {
	if(!pdo_fieldexists('hcface_cash',  'fee')) {
		pdo_query("ALTER TABLE ".tablename('hcface_cash')." ADD `fee` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_cash')) {
	if(!pdo_fieldexists('hcface_cash',  'type')) {
		pdo_query("ALTER TABLE ".tablename('hcface_cash')." ADD `type` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('hcface_cash')) {
	if(!pdo_fieldexists('hcface_cash',  'status')) {
		pdo_query("ALTER TABLE ".tablename('hcface_cash')." ADD `status` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('hcface_cash')) {
	if(!pdo_fieldexists('hcface_cash',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('hcface_cash')." ADD `createtime` char(10) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_commission')) {
	if(!pdo_fieldexists('hcface_commission',  'id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_commission')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('hcface_commission')) {
	if(!pdo_fieldexists('hcface_commission',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_commission')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_commission')) {
	if(!pdo_fieldexists('hcface_commission',  'user_id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_commission')." ADD `user_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_commission')) {
	if(!pdo_fieldexists('hcface_commission',  'sub_id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_commission')." ADD `sub_id` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_commission')) {
	if(!pdo_fieldexists('hcface_commission',  'trade_no')) {
		pdo_query("ALTER TABLE ".tablename('hcface_commission')." ADD `trade_no` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_commission')) {
	if(!pdo_fieldexists('hcface_commission',  'goodsname')) {
		pdo_query("ALTER TABLE ".tablename('hcface_commission')." ADD `goodsname` varchar(500) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_commission')) {
	if(!pdo_fieldexists('hcface_commission',  'goodsthumb')) {
		pdo_query("ALTER TABLE ".tablename('hcface_commission')." ADD `goodsthumb` varchar(500) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_commission')) {
	if(!pdo_fieldexists('hcface_commission',  'price')) {
		pdo_query("ALTER TABLE ".tablename('hcface_commission')." ADD `price` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_commission')) {
	if(!pdo_fieldexists('hcface_commission',  'rate')) {
		pdo_query("ALTER TABLE ".tablename('hcface_commission')." ADD `rate` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_commission')) {
	if(!pdo_fieldexists('hcface_commission',  'profit')) {
		pdo_query("ALTER TABLE ".tablename('hcface_commission')." ADD `profit` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_commission')) {
	if(!pdo_fieldexists('hcface_commission',  'level')) {
		pdo_query("ALTER TABLE ".tablename('hcface_commission')." ADD `level` tinyint(1) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_commission')) {
	if(!pdo_fieldexists('hcface_commission',  'sort')) {
		pdo_query("ALTER TABLE ".tablename('hcface_commission')." ADD `sort` tinyint(1) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_commission')) {
	if(!pdo_fieldexists('hcface_commission',  'status')) {
		pdo_query("ALTER TABLE ".tablename('hcface_commission')." ADD `status` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('hcface_commission')) {
	if(!pdo_fieldexists('hcface_commission',  'freeze')) {
		pdo_query("ALTER TABLE ".tablename('hcface_commission')." ADD `freeze` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('hcface_commission')) {
	if(!pdo_fieldexists('hcface_commission',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('hcface_commission')." ADD `createtime` char(10) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_goods')) {
	if(!pdo_fieldexists('hcface_goods',  'id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_goods')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('hcface_goods')) {
	if(!pdo_fieldexists('hcface_goods',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_goods')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_goods')) {
	if(!pdo_fieldexists('hcface_goods',  'title')) {
		pdo_query("ALTER TABLE ".tablename('hcface_goods')." ADD `title` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_goods')) {
	if(!pdo_fieldexists('hcface_goods',  'ctitle')) {
		pdo_query("ALTER TABLE ".tablename('hcface_goods')." ADD `ctitle` varchar(500) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_goods')) {
	if(!pdo_fieldexists('hcface_goods',  'desc')) {
		pdo_query("ALTER TABLE ".tablename('hcface_goods')." ADD `desc` text NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_goods')) {
	if(!pdo_fieldexists('hcface_goods',  'sub')) {
		pdo_query("ALTER TABLE ".tablename('hcface_goods')." ADD `sub` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_goods')) {
	if(!pdo_fieldexists('hcface_goods',  'price')) {
		pdo_query("ALTER TABLE ".tablename('hcface_goods')." ADD `price` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_goods')) {
	if(!pdo_fieldexists('hcface_goods',  'oprice')) {
		pdo_query("ALTER TABLE ".tablename('hcface_goods')." ADD `oprice` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_goods')) {
	if(!pdo_fieldexists('hcface_goods',  'discount')) {
		pdo_query("ALTER TABLE ".tablename('hcface_goods')." ADD `discount` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_goods')) {
	if(!pdo_fieldexists('hcface_goods',  'thumb')) {
		pdo_query("ALTER TABLE ".tablename('hcface_goods')." ADD `thumb` varchar(200) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_goods')) {
	if(!pdo_fieldexists('hcface_goods',  'sales')) {
		pdo_query("ALTER TABLE ".tablename('hcface_goods')." ADD `sales` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_goods')) {
	if(!pdo_fieldexists('hcface_goods',  'type')) {
		pdo_query("ALTER TABLE ".tablename('hcface_goods')." ADD `type` varchar(5) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('hcface_hand_report')) {
	if(!pdo_fieldexists('hcface_hand_report',  'id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_hand_report')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('hcface_hand_report')) {
	if(!pdo_fieldexists('hcface_hand_report',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_hand_report')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_hand_report')) {
	if(!pdo_fieldexists('hcface_hand_report',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_hand_report')." ADD `uid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_hand_report')) {
	if(!pdo_fieldexists('hcface_hand_report',  'aid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_hand_report')." ADD `aid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_hand_report')) {
	if(!pdo_fieldexists('hcface_hand_report',  'name')) {
		pdo_query("ALTER TABLE ".tablename('hcface_hand_report')." ADD `name` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_hand_report')) {
	if(!pdo_fieldexists('hcface_hand_report',  'tel')) {
		pdo_query("ALTER TABLE ".tablename('hcface_hand_report')." ADD `tel` varchar(15) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_hand_report')) {
	if(!pdo_fieldexists('hcface_hand_report',  'score')) {
		pdo_query("ALTER TABLE ".tablename('hcface_hand_report')." ADD `score` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_hand_report')) {
	if(!pdo_fieldexists('hcface_hand_report',  'type')) {
		pdo_query("ALTER TABLE ".tablename('hcface_hand_report')." ADD `type` text NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_hand_report')) {
	if(!pdo_fieldexists('hcface_hand_report',  'zhihui')) {
		pdo_query("ALTER TABLE ".tablename('hcface_hand_report')." ADD `zhihui` text NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_hand_report')) {
	if(!pdo_fieldexists('hcface_hand_report',  'ganqing')) {
		pdo_query("ALTER TABLE ".tablename('hcface_hand_report')." ADD `ganqing` text NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_hand_report')) {
	if(!pdo_fieldexists('hcface_hand_report',  'shengming')) {
		pdo_query("ALTER TABLE ".tablename('hcface_hand_report')." ADD `shengming` text NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_hand_report')) {
	if(!pdo_fieldexists('hcface_hand_report',  'zhixiang')) {
		pdo_query("ALTER TABLE ".tablename('hcface_hand_report')." ADD `zhixiang` text NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_hand_report')) {
	if(!pdo_fieldexists('hcface_hand_report',  'yunshi')) {
		pdo_query("ALTER TABLE ".tablename('hcface_hand_report')." ADD `yunshi` text NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_hand_report')) {
	if(!pdo_fieldexists('hcface_hand_report',  'zinv')) {
		pdo_query("ALTER TABLE ".tablename('hcface_hand_report')." ADD `zinv` text NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_hand_report')) {
	if(!pdo_fieldexists('hcface_hand_report',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('hcface_hand_report')." ADD `createtime` char(10) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_hand_report')) {
	if(!pdo_fieldexists('hcface_hand_report',  'unlock')) {
		pdo_query("ALTER TABLE ".tablename('hcface_hand_report')." ADD `unlock` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('hcface_hand_report')) {
	if(!pdo_fieldexists('hcface_hand_report',  'isdelete')) {
		pdo_query("ALTER TABLE ".tablename('hcface_hand_report')." ADD `isdelete` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('hcface_nexus')) {
	if(!pdo_fieldexists('hcface_nexus',  'id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_nexus')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('hcface_nexus')) {
	if(!pdo_fieldexists('hcface_nexus',  'pppid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_nexus')." ADD `pppid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_nexus')) {
	if(!pdo_fieldexists('hcface_nexus',  'ppid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_nexus')." ADD `ppid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_nexus')) {
	if(!pdo_fieldexists('hcface_nexus',  'pid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_nexus')." ADD `pid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_nexus')) {
	if(!pdo_fieldexists('hcface_nexus',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_nexus')." ADD `uid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_nexus')) {
	if(!pdo_fieldexists('hcface_nexus',  'ctime')) {
		pdo_query("ALTER TABLE ".tablename('hcface_nexus')." ADD `ctime` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_order')) {
	if(!pdo_fieldexists('hcface_order',  'id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order')." ADD `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('hcface_order')) {
	if(!pdo_fieldexists('hcface_order',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_order')) {
	if(!pdo_fieldexists('hcface_order',  'type')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order')." ADD `type` char(2) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_order')) {
	if(!pdo_fieldexists('hcface_order',  'rid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order')." ADD `rid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_order')) {
	if(!pdo_fieldexists('hcface_order',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order')." ADD `uid` int(11) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_order')) {
	if(!pdo_fieldexists('hcface_order',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order')." ADD `openid` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_order')) {
	if(!pdo_fieldexists('hcface_order',  'title')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order')." ADD `title` varchar(300) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_order')) {
	if(!pdo_fieldexists('hcface_order',  'trade_no')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order')." ADD `trade_no` varchar(30) DEFAULT NULL COMMENT '订单编号';");
	}	
}
if(pdo_tableexists('hcface_order')) {
	if(!pdo_fieldexists('hcface_order',  'transaction_id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order')." ADD `transaction_id` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_order')) {
	if(!pdo_fieldexists('hcface_order',  'money')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order')." ADD `money` decimal(10,2) NOT NULL DEFAULT '0.00';");
	}	
}
if(pdo_tableexists('hcface_order')) {
	if(!pdo_fieldexists('hcface_order',  'status')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order')." ADD `status` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('hcface_order')) {
	if(!pdo_fieldexists('hcface_order',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order')." ADD `createtime` char(10) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_order')) {
	if(!pdo_fieldexists('hcface_order',  'paytime')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order')." ADD `paytime` char(10) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_order')) {
	if(!pdo_fieldexists('hcface_order',  'isdelete')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order')." ADD `isdelete` tinyint(1) DEFAULT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('hcface_order_unlock')) {
	if(!pdo_fieldexists('hcface_order_unlock',  'id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order_unlock')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('hcface_order_unlock')) {
	if(!pdo_fieldexists('hcface_order_unlock',  'rid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order_unlock')." ADD `rid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_order_unlock')) {
	if(!pdo_fieldexists('hcface_order_unlock',  'type')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order_unlock')." ADD `type` char(2) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_order_unlock')) {
	if(!pdo_fieldexists('hcface_order_unlock',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order_unlock')." ADD `uid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_order_unlock')) {
	if(!pdo_fieldexists('hcface_order_unlock',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('hcface_order_unlock')." ADD `createtime` char(10) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_paylog')) {
	if(!pdo_fieldexists('hcface_paylog',  'id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_paylog')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('hcface_paylog')) {
	if(!pdo_fieldexists('hcface_paylog',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_paylog')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_paylog')) {
	if(!pdo_fieldexists('hcface_paylog',  'money')) {
		pdo_query("ALTER TABLE ".tablename('hcface_paylog')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_paylog')) {
	if(!pdo_fieldexists('hcface_paylog',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_paylog')." ADD `uid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_paylog')) {
	if(!pdo_fieldexists('hcface_paylog',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_paylog')." ADD `openid` varchar(30) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_paylog')) {
	if(!pdo_fieldexists('hcface_paylog',  'trade_no')) {
		pdo_query("ALTER TABLE ".tablename('hcface_paylog')." ADD `trade_no` varchar(18) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_paylog')) {
	if(!pdo_fieldexists('hcface_paylog',  'transaction_id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_paylog')." ADD `transaction_id` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_paylog')) {
	if(!pdo_fieldexists('hcface_paylog',  'total_fee')) {
		pdo_query("ALTER TABLE ".tablename('hcface_paylog')." ADD `total_fee` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_paylog')) {
	if(!pdo_fieldexists('hcface_paylog',  'status')) {
		pdo_query("ALTER TABLE ".tablename('hcface_paylog')." ADD `status` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('hcface_paylog')) {
	if(!pdo_fieldexists('hcface_paylog',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('hcface_paylog')." ADD `createtime` char(10) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_paylog')) {
	if(!pdo_fieldexists('hcface_paylog',  'paytime')) {
		pdo_query("ALTER TABLE ".tablename('hcface_paylog')." ADD `paytime` char(10) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `weid` int(11) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `uid` int(11) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'aid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `aid` int(11) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'name')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `name` varchar(50) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'summary')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `summary` text DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'score')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `score` tinyint(3) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'score_detail')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `score_detail` varchar(200) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'top')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `top` varchar(200) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'eyebrow')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `eyebrow` varchar(200) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'eye')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `eye` varchar(200) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'eye_desc')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `eye_desc` text DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'mouse')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `mouse` varchar(200) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'mouse_desc')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `mouse_desc` text DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'nose')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `nose` varchar(200) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'nose_desc')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `nose_desc` text DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'five1')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `five1` char(2) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'five1_rate')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `five1_rate` tinyint(2) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'five2')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `five2` char(2) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'five2_rate')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `five2_rate` tinyint(2) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'five_desc')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `five_desc` text DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'emotion')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `emotion` text NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'cause')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `cause` text NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `createtime` char(10) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'unlock')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `unlock` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'tel')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `tel` varchar(15) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_report')) {
	if(!pdo_fieldexists('hcface_report',  'isdelete')) {
		pdo_query("ALTER TABLE ".tablename('hcface_report')." ADD `isdelete` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('hcface_setting')) {
	if(!pdo_fieldexists('hcface_setting',  'id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_setting')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('hcface_setting')) {
	if(!pdo_fieldexists('hcface_setting',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_setting')." ADD `weid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('hcface_setting')) {
	if(!pdo_fieldexists('hcface_setting',  'only')) {
		pdo_query("ALTER TABLE ".tablename('hcface_setting')." ADD `only` varchar(20) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_setting')) {
	if(!pdo_fieldexists('hcface_setting',  'title')) {
		pdo_query("ALTER TABLE ".tablename('hcface_setting')." ADD `title` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_setting')) {
	if(!pdo_fieldexists('hcface_setting',  'value')) {
		pdo_query("ALTER TABLE ".tablename('hcface_setting')." ADD `value` text NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_upgrade')) {
	if(!pdo_fieldexists('hcface_upgrade',  'id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_upgrade')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('hcface_upgrade')) {
	if(!pdo_fieldexists('hcface_upgrade',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_upgrade')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_upgrade')) {
	if(!pdo_fieldexists('hcface_upgrade',  'title')) {
		pdo_query("ALTER TABLE ".tablename('hcface_upgrade')." ADD `title` varchar(100) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_upgrade')) {
	if(!pdo_fieldexists('hcface_upgrade',  'trade_no')) {
		pdo_query("ALTER TABLE ".tablename('hcface_upgrade')." ADD `trade_no` varchar(20) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_upgrade')) {
	if(!pdo_fieldexists('hcface_upgrade',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_upgrade')." ADD `uid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_upgrade')) {
	if(!pdo_fieldexists('hcface_upgrade',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_upgrade')." ADD `openid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_upgrade')) {
	if(!pdo_fieldexists('hcface_upgrade',  'price')) {
		pdo_query("ALTER TABLE ".tablename('hcface_upgrade')." ADD `price` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_upgrade')) {
	if(!pdo_fieldexists('hcface_upgrade',  'transaction_id')) {
		pdo_query("ALTER TABLE ".tablename('hcface_upgrade')." ADD `transaction_id` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_upgrade')) {
	if(!pdo_fieldexists('hcface_upgrade',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('hcface_upgrade')." ADD `createtime` char(10) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_upgrade')) {
	if(!pdo_fieldexists('hcface_upgrade',  'paytime')) {
		pdo_query("ALTER TABLE ".tablename('hcface_upgrade')." ADD `paytime` char(10) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_upgrade')) {
	if(!pdo_fieldexists('hcface_upgrade',  'status')) {
		pdo_query("ALTER TABLE ".tablename('hcface_upgrade')." ADD `status` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('hcface_upgrade')) {
	if(!pdo_fieldexists('hcface_upgrade',  'level')) {
		pdo_query("ALTER TABLE ".tablename('hcface_upgrade')." ADD `level` tinyint(1) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `uid` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `weid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'pid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `pid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'avatar')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `avatar` varchar(200) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'nickname')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `nickname` varchar(50) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `openid` varchar(50) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'mobile')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `mobile` varchar(15) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'sessionkey')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `sessionkey` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'unionid')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `unionid` varchar(50) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'gender')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `gender` tinyint(1) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'province')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `province` varchar(50) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'city')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `city` varchar(50) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'country')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `country` varchar(50) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `createtime` char(10) DEFAULT NULL;");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'status')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `status` char(1) DEFAULT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'level')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `level` tinyint(1) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'promo_code')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `promo_code` varchar(300) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'receipt_code')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `receipt_code` varchar(300) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'vip')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `vip` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'money')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `money` decimal(10,2) NOT NULL;");
	}	
}
if(pdo_tableexists('hcface_users')) {
	if(!pdo_fieldexists('hcface_users',  'black')) {
		pdo_query("ALTER TABLE ".tablename('hcface_users')." ADD `black` tinyint(1) NOT NULL DEFAULT '0';");
	}	
}
