-- PHPAPP SQL
-- version 2.5
-- http://www.phpapp.cn

--
-- 表的结构 `phpapp_admin`
--

CREATE TABLE `phpapp_admin` (
  `id_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `name_phpapp` char(32) NOT NULL,
  `app_phpapp` mediumtext NOT NULL,
  `action_phpapp` mediumtext NOT NULL,
  `status_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_admin_menu`
--

CREATE TABLE `phpapp_admin_menu` (
  `catid_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `name_phpapp` char(32) NOT NULL,
  `apps_phpapp` int(10) NOT NULL DEFAULT '0',
  `action_phpapp` int(10) NOT NULL DEFAULT '0',
  `status_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  `upid_phpapp` int(10) NOT NULL DEFAULT '0',
  `displayorder_phpapp` int(10) NOT NULL DEFAULT '0',
  `desktop_phpapp` tinyint(1) NOT NULL DEFAULT '1',
  `icon_phpapp` varchar(255) NOT NULL,
  `catalog_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`catid_phpapp`),
  KEY `status_phpapp` (`status_phpapp`),
  KEY `apps_phpapp` (`apps_phpapp`),
  KEY `upid_phpapp` (`upid_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_advertising`
--

CREATE TABLE `phpapp_advertising` (
  `id_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `apps_phpapp` int(10) NOT NULL DEFAULT '0',
  `key_phpapp` char(60) NOT NULL,
  `name_phpapp` char(50) NOT NULL,
  `margin_phpapp` char(16) NOT NULL,
  `type_phpapp` char(10) NOT NULL,
  `parameters_phpapp` text NOT NULL,
  `code_phpapp` text NOT NULL,
  `displayorder_phpapp` int(10) NOT NULL DEFAULT '0',
  `status_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_apps`
--

CREATE TABLE `phpapp_apps` (
  `id_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `name_phpapp` char(32) NOT NULL,
  `class_phpapp` char(32) NOT NULL,
  `dir_phpapp` char(32) NOT NULL,
  `status_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  `version_phpapp` char(12) NOT NULL,
  `show_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  `sole_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  `route_phpapp` char(32) NOT NULL,
  `displayorder_phpapp` int(10) NOT NULL DEFAULT '0',
  `ico_small_phpapp` char(32) NOT NULL,
  `menu_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  `title_phpapp` varchar(255) NOT NULL,
  `keywords_phpapp` varchar(255) NOT NULL,
  `description_phpapp` varchar(255) NOT NULL,
  `internal_phpapp` int(10) NOT NULL DEFAULT '0',
  `filesize_phpapp` int(10) NOT NULL DEFAULT '0',
  `install_phpapp` int(10) NOT NULL DEFAULT '0',
  `developer_phpapp` varchar(36) NOT NULL,
  `update_phpapp` int(10) NOT NULL DEFAULT '0',
  UNIQUE KEY `id_apps` (`id_phpapp`),
  KEY `class_phpapp` (`class_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_apps_action`
--

CREATE TABLE `phpapp_apps_action` (
  `id_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `aid_phpapp` int(10) NOT NULL DEFAULT '0',
  `apps_phpapp` int(10) NOT NULL DEFAULT '0',
  `name_phpapp` char(32) NOT NULL,
  `class_phpapp` char(32) NOT NULL,
  `type_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  `route_phpapp` char(32) NOT NULL,
  `displayorder_phpapp` int(10) NOT NULL DEFAULT '0',
  `status_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  `show_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  `menu_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  `title_phpapp` varchar(255) NOT NULL,
  `keywords_phpapp` varchar(255) NOT NULL,
  `description_phpapp` varchar(255) NOT NULL,
  UNIQUE KEY `id_phpapp` (`id_phpapp`),
  KEY `aid_phpapp` (`aid_phpapp`),
  KEY `apps_phpapp` (`apps_phpapp`),
  KEY `show_phpapp` (`show_phpapp`),
  KEY `description_phpapp` (`description_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_apps_credit`
--

CREATE TABLE `phpapp_apps_credit` (
  `id_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `name_phpapp` varchar(32) NOT NULL,
  `apps_phpapp` int(10) NOT NULL DEFAULT '0',
  `action_phpapp` int(10) NOT NULL DEFAULT '0',
  `usergroup_phpapp` int(10) NOT NULL DEFAULT '0',
  `number_phpapp` int(10) NOT NULL DEFAULT '0',
  `credit_phpapp` float NOT NULL DEFAULT '0',
  `status_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_phpapp`),
  KEY `apps_phpapp` (`apps_phpapp`),
  KEY `action_phpapp` (`action_phpapp`),
  KEY `usergroup_phpapp` (`usergroup_phpapp`),
  KEY `number_phpapp` (`number_phpapp`),
  KEY `status_phpapp` (`status_phpapp`),
  KEY `credit_phpapp` (`credit_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_apps_feed`
--

CREATE TABLE `phpapp_apps_feed` (
  `id_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `name_phpapp` varchar(32) NOT NULL,
  `apps_phpapp` int(10) NOT NULL DEFAULT '0',
  `action_phpapp` int(10) NOT NULL DEFAULT '0',
  `usergroup_phpapp` int(10) NOT NULL DEFAULT '0',
  `status_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_phpapp`),
  KEY `apps_phpapp` (`apps_phpapp`),
  KEY `action_phpapp` (`action_phpapp`),
  KEY `usergroup_phpapp` (`usergroup_phpapp`),
  KEY `status_phpapp` (`status_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_apps_file`
--

CREATE TABLE `phpapp_apps_file` (
  `fid` int(10) NOT NULL DEFAULT '0',
  `appid` int(10) NOT NULL DEFAULT '0',
  `id` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `fid` (`fid`),
  KEY `appid` (`appid`),
  KEY `id` (`id`),
  KEY `uid` (`uid`),
  KEY `type` (`type`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_apps_install`
--

CREATE TABLE `phpapp_apps_install` (
  `id_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `apps_phpapp` int(10) NOT NULL DEFAULT '0',
  `table_phpapp` mediumtext NOT NULL,
  PRIMARY KEY (`id_phpapp`),
  KEY `apps_phpapp` (`apps_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_apps_update`
--

CREATE TABLE `phpapp_apps_update` (
  `id_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `apps_phpapp` int(10) NOT NULL DEFAULT '0',
  `name_phpapp` varchar(255) NOT NULL,
  `required_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  `filesize_phpapp` int(10) NOT NULL DEFAULT '0',
  `date_phpapp` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_autorun`
--

CREATE TABLE `phpapp_autorun` (
  `aid` mediumint(12) NOT NULL AUTO_INCREMENT,
  `appid` tinyint(1) NOT NULL DEFAULT '0',
  `system` tinyint(1) NOT NULL DEFAULT '0',
  `runcode` mediumtext NOT NULL,
  `runtime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`),
  KEY `runtime` (`runtime`),
  KEY `appid` (`appid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_bankname`
--

CREATE TABLE `phpapp_bankname` (
  `bankid` mediumint(8) NOT NULL AUTO_INCREMENT,
  `bankname` varchar(255) NOT NULL,
  PRIMARY KEY (`bankid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_case`
--

CREATE TABLE `phpapp_case` (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `photo` int(10) NOT NULL DEFAULT '0',
  `catid` int(10) NOT NULL DEFAULT '0',
  `width` int(10) NOT NULL DEFAULT '0',
  `height` int(10) NOT NULL DEFAULT '0',
  `keywords` varchar(255) NOT NULL,
  `show` tinyint(1) NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `description` varchar(255) NOT NULL,
  `kkkk` varchar(255) NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `catid` (`catid`),
  KEY `photo` (`photo`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_category`
--

CREATE TABLE `phpapp_category` (
  `catid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `upid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` char(80) NOT NULL,
  `route` char(32) NOT NULL,
  `photolist` tinyint(1) NOT NULL DEFAULT '0',
  `skills` text NOT NULL,
  `nexts` text NOT NULL,
  `color` char(12) NOT NULL,
  `type` char(80) NOT NULL,
  `displayorder` int(3) NOT NULL DEFAULT '0',
  `total` int(10) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `classname` varchar(255) NOT NULL,
  PRIMARY KEY (`catid`),
  KEY `upid` (`upid`),
  KEY `type` (`type`),
  KEY `displayorder` (`displayorder`),
  KEY `name` (`name`),
  KEY `photolist` (`photolist`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_category_city`
--

CREATE TABLE `phpapp_category_city` (
  `catid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `nexts` text NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '0',
  `upid` int(10) NOT NULL DEFAULT '0',
  `displayorder` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`catid`),
  KEY `level` (`level`),
  KEY `upid` (`upid`),
  KEY `displayorder` (`displayorder`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_certificate`
--

CREATE TABLE `phpapp_certificate` (
  `id_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `app_phpapp` int(10) NOT NULL DEFAULT '0',
  `table_phpapp` char(80) NOT NULL,
  `name_phpapp` char(60) NOT NULL,
  `type_phpapp` tinyint(2) NOT NULL DEFAULT '0',
  `icon_small_phpapp` varchar(255) NOT NULL,
  `icon_middle_phpapp` varchar(255) NOT NULL,
  `icon_big_phpapp` varchar(255) NOT NULL,
  `description_phpapp` text NOT NULL,
  `price_phpapp` decimal(10,2) NOT NULL DEFAULT '0.00',
  `time_phpapp` tinyint(3) NOT NULL DEFAULT '1',
  `status_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_phpapp`),
  KEY `app_phpapp` (`app_phpapp`),
  KEY `time_phpapp` (`time_phpapp`),
  KEY `status_phpapp` (`status_phpapp`),
  KEY `price_phpapp` (`price_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_config`
--

CREATE TABLE `phpapp_config` (
  `id_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `app_phpapp` int(10) NOT NULL DEFAULT '0',
  `name_phpapp` varchar(30) NOT NULL,
  `value_phpapp` mediumtext NOT NULL,
  PRIMARY KEY (`id_phpapp`),
  KEY `app_phpapp` (`app_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_consume`
--

CREATE TABLE `phpapp_consume` (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `serial` varchar(22) NOT NULL,
  `appid` int(10) NOT NULL DEFAULT '0',
  `paytype` tinyint(1) NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL,
  `process` tinyint(1) NOT NULL DEFAULT '0',
  `number` int(10) NOT NULL DEFAULT '1',
  `bankcard` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fee` float NOT NULL,
  `refundmoney` decimal(10,2) NOT NULL DEFAULT '0.00',
  `operator` int(10) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`),
  KEY `appid` (`appid`),
  KEY `paytype` (`paytype`),
  KEY `process` (`process`),
  KEY `number` (`number`),
  KEY `amount` (`amount`),
  KEY `fee` (`fee`),
  KEY `operator` (`operator`),
  KEY `dateline` (`dateline`),
  KEY `serial` (`serial`),
  KEY `refundmoney` (`refundmoney`),
  FULLTEXT KEY `subject` (`subject`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_credit`
--

CREATE TABLE `phpapp_credit` (
  `uid` int(10) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `credit` int(10) NOT NULL DEFAULT '0',
  `hao` int(10) NOT NULL DEFAULT '0',
  `zhong` int(10) NOT NULL DEFAULT '0',
  `cha` int(10) NOT NULL DEFAULT '0',
  KEY `credit` (`credit`),
  KEY `uid` (`uid`),
  KEY `type` (`type`),
  KEY `hao` (`hao`),
  KEY `zhong` (`zhong`),
  KEY `cha` (`cha`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_credit_level`
--

CREATE TABLE `phpapp_credit_level` (
  `lid` int(10) NOT NULL AUTO_INCREMENT,
  `small` int(10) NOT NULL DEFAULT '0',
  `big` int(10) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL,
  `style` varchar(150) NOT NULL,
  PRIMARY KEY (`lid`),
  KEY `small` (`small`),
  KEY `big` (`big`),
  KEY `type` (`type`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_credit_score`
--

CREATE TABLE `phpapp_credit_score` (
  `uid` int(10) NOT NULL DEFAULT '0',
  `speed` float NOT NULL DEFAULT '0',
  `attitude` float NOT NULL DEFAULT '0',
  `quality` float NOT NULL DEFAULT '0',
  KEY `uid` (`uid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_customer_service`
--

CREATE TABLE `phpapp_customer_service` (
  `sid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_field`
--

CREATE TABLE `phpapp_field` (
  `id_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `table_phpapp` varchar(36) NOT NULL,
  `field_phpapp` varchar(36) NOT NULL,
  `name_phpapp` varchar(36) NOT NULL,
  `type_phpapp` varchar(36) NOT NULL,
  `default_phpapp` varchar(255) NOT NULL,
  `smalllength_phpapp` int(10) NOT NULL DEFAULT '0',
  `maxlength_phpapp` int(10) NOT NULL DEFAULT '0',
  `value_phpapp` mediumtext NOT NULL,
  `filter_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  `required_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  `status_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  `submit_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  `displayorder_phpapp` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_file`
--

CREATE TABLE `phpapp_file` (
  `fid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `filename` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `filesize` int(10) NOT NULL DEFAULT '0',
  `filetype` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL,
  `ftp` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fid`),
  KEY `filetype` (`filetype`),
  KEY `uid` (`uid`),
  KEY `filesize` (`filesize`),
  KEY `dateline` (`dateline`),
  KEY `ftp` (`ftp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_file_icon`
--

CREATE TABLE `phpapp_file_icon` (
  `fid` int(10) NOT NULL AUTO_INCREMENT,
  `form` char(10) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`fid`),
  KEY `form` (`form`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_file_temp`
--

CREATE TABLE `phpapp_file_temp` (
  `tmpid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `ftype` varchar(255) NOT NULL,
  `tmpname` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `fsize` char(16) NOT NULL,
  `fwidth` int(10) NOT NULL DEFAULT '0',
  `uploadtype` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  UNIQUE KEY `tmpid` (`tmpid`),
  KEY `uid` (`uid`),
  KEY `fwidth` (`fwidth`),
  KEY `uploadtype` (`uploadtype`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_follow`
--

CREATE TABLE `phpapp_follow` (
  `uid` int(10) NOT NULL DEFAULT '0',
  `catids` mediumtext NOT NULL,
  `skills` mediumtext NOT NULL,
  KEY `uid` (`uid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_getdata`
--

CREATE TABLE `phpapp_getdata` (
  `id_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `block_phpapp` int(10) NOT NULL DEFAULT '0',
  `key_phpapp` char(60) NOT NULL,
  `name_phpapp` char(50) NOT NULL,
  `parameters_phpapp` text NOT NULL,
  `code_phpapp` text NOT NULL,
  `template_phpapp` text NOT NULL,
  `status_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_help`
--

CREATE TABLE `phpapp_help` (
  `hid` int(10) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `catid` int(10) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`hid`),
  KEY `dateline` (`dateline`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_language`
--

CREATE TABLE `phpapp_language` (
  `id_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `name_phpapp` varchar(32) NOT NULL,
  `dir_phpapp` char(32) NOT NULL,
  `domain_phpapp` varchar(255) NOT NULL,
  `style_phpapp` char(32) NOT NULL,
  `status_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_phpapp`),
  KEY `apply_phpapp` (`status_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_links`
--

CREATE TABLE `phpapp_links` (
  `lid` mediumint(8) NOT NULL AUTO_INCREMENT,
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `sitename` varchar(100) NOT NULL DEFAULT '',
  `siteurl` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(100) NOT NULL DEFAULT '',
  `logo` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`lid`),
  KEY `displayorder` (`displayorder`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_login_safe`
--

CREATE TABLE `phpapp_login_safe` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` char(36) NOT NULL,
  `loginip` char(60) NOT NULL,
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member`
--

CREATE TABLE `phpapp_member` (
  `uid` int(10) NOT NULL AUTO_INCREMENT,
  `username` char(36) NOT NULL,
  `usertype` tinyint(3) NOT NULL DEFAULT '0',
  `password` char(32) NOT NULL,
  `powercode` char(16) NOT NULL,
  `cookiecode` char(16) NOT NULL,
  `userpost` tinyint(1) NOT NULL DEFAULT '1',
  `admingroup` int(10) NOT NULL DEFAULT '0',
  `usergroup` int(10) NOT NULL DEFAULT '0',
  `safeemail` char(180) NOT NULL,
  `skills` char(50) NOT NULL,
  `email` char(180) NOT NULL,
  `unionid` int(10) NOT NULL,
  `uniontime` int(10) NOT NULL DEFAULT '0',
  `regip` char(32) NOT NULL,
  `loginip` char(32) NOT NULL,
  `dateline` int(10) NOT NULL,
  `logintime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `admingroup` (`admingroup`),
  KEY `usergroup` (`usergroup`),
  KEY `unionid` (`unionid`),
  KEY `uniontime` (`uniontime`),
  KEY `dateline` (`dateline`),
  KEY `logintime` (`logintime`),
  FULLTEXT KEY `username` (`username`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_account`
--

CREATE TABLE `phpapp_member_account` (
  `uid` int(10) NOT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lock` decimal(10,2) NOT NULL DEFAULT '0.00',
  `wealth` decimal(10,2) NOT NULL DEFAULT '0.00',
  `credit` int(10) NOT NULL DEFAULT '0',
  `union` decimal(10,2) NOT NULL DEFAULT '0.00',
  KEY `uid` (`uid`),
  KEY `money` (`money`),
  KEY `lock` (`lock`),
  KEY `wealth` (`wealth`),
  KEY `credit` (`credit`),
  KEY `union` (`union`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_company`
--

CREATE TABLE `phpapp_member_company` (
  `uid` int(10) NOT NULL,
  `about` mediumtext NOT NULL,
  `tasklatitude` float NOT NULL,
  `tasklongitude` float NOT NULL,
  `taskmapzoom` tinyint(2) NOT NULL,
  `residelatitude` float NOT NULL,
  `residelongitude` float NOT NULL,
  `residemapzoom` tinyint(2) NOT NULL DEFAULT '0',
  `taskcity` int(10) NOT NULL DEFAULT '0',
  KEY `uid` (`uid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_company_certificate`
--

CREATE TABLE `phpapp_member_company_certificate` (
  `uid` int(10) NOT NULL DEFAULT '0',
  `company` varchar(60) NOT NULL,
  `businessnumber` varchar(255) NOT NULL,
  `businesslicense` int(10) NOT NULL DEFAULT '0',
  `realname` varchar(60) NOT NULL,
  `idnumber` varchar(255) NOT NULL,
  `frontphoto` int(10) NOT NULL DEFAULT '0',
  `rearphoto` int(10) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `verifymoney` decimal(10,2) NOT NULL DEFAULT '0.00',
  `bankname` varchar(255) NOT NULL,
  `bankid` int(10) NOT NULL,
  `bankcard` varchar(255) NOT NULL,
  `bankaddress` int(10) NOT NULL,
  `errornum` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `pay` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  `errorinfo` text NOT NULL,
  KEY `uid` (`uid`),
  KEY `realname` (`realname`),
  KEY `businesslicense` (`businesslicense`),
  KEY `frontphoto` (`frontphoto`),
  KEY `rearphoto` (`rearphoto`),
  KEY `type` (`type`),
  KEY `verifymoney` (`verifymoney`),
  KEY `errornum` (`errornum`),
  KEY `status` (`status`),
  KEY `pay` (`pay`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_consume`
--

CREATE TABLE `phpapp_member_consume` (
  `fid` int(10) NOT NULL AUTO_INCREMENT,
  `cid` int(10) NOT NULL DEFAULT '0',
  `oid` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `flow` tinyint(1) NOT NULL DEFAULT '0',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`fid`),
  KEY `cid` (`cid`),
  KEY `uid` (`uid`),
  KEY `flow` (`flow`),
  KEY `money` (`money`),
  KEY `oid` (`oid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_credit`
--

CREATE TABLE `phpapp_member_credit` (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `appid` int(10) NOT NULL DEFAULT '0',
  `actionid` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `credit` float NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`),
  KEY `appid` (`appid`),
  KEY `actionid` (`actionid`),
  KEY `uid` (`uid`),
  KEY `credit` (`credit`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_error`
--

CREATE TABLE `phpapp_member_error` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` char(32) NOT NULL,
  `loginkey` char(36) NOT NULL,
  `loginip` char(32) NOT NULL,
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `dateline` (`dateline`),
  KEY `username` (`username`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_feed`
--

CREATE TABLE `phpapp_member_feed` (
  `fid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `username` varchar(60) NOT NULL,
  `app` int(10) NOT NULL DEFAULT '0',
  `action` int(10) NOT NULL DEFAULT '0',
  `title_template` text NOT NULL,
  `title_data` text NOT NULL,
  `content_template` text NOT NULL,
  `content_data` text NOT NULL,
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fid`),
  KEY `uid` (`uid`),
  KEY `dateline` (`dateline`),
  KEY `app` (`app`),
  KEY `action` (`action`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_friend`
--

CREATE TABLE `phpapp_member_friend` (
  `uid` int(10) NOT NULL DEFAULT '0',
  `fuid` int(10) NOT NULL DEFAULT '0',
  `message` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  KEY `uid` (`uid`),
  KEY `fuid` (`fuid`),
  KEY `status` (`status`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_info`
--

CREATE TABLE `phpapp_member_info` (
  `uid` int(10) NOT NULL DEFAULT '0',
  `realname` tinyint(1) NOT NULL DEFAULT '1',
  `themes` int(10) NOT NULL DEFAULT '0',
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `birthday` int(10) NOT NULL DEFAULT '0',
  `avatar` varchar(80) NOT NULL,
  `qq` varchar(20) NOT NULL,
  `icq` varchar(20) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `mobile` varchar(40) NOT NULL,
  `msn` varchar(180) NOT NULL,
  `birthcity` int(10) NOT NULL DEFAULT '0',
  `residecity` int(10) NOT NULL DEFAULT '0',
  `homepage` varchar(255) NOT NULL,
  `certificate` text NOT NULL,
  `timezone` float NOT NULL,
  `domainname` varchar(255) NOT NULL,
  `selltotal` int(10) NOT NULL DEFAULT '0',
  `catid` int(10) NOT NULL DEFAULT '0',
  `securitybao` tinyint(1) NOT NULL DEFAULT '0',
  `securityyuan` tinyint(1) NOT NULL DEFAULT '0',
  `securitygai` tinyint(1) NOT NULL DEFAULT '0',
  `securitywei` tinyint(1) NOT NULL DEFAULT '0',
  `securityshang` tinyint(1) NOT NULL DEFAULT '0',
  KEY `selltotal` (`selltotal`),
  KEY `catid` (`catid`),
  KEY `securityyuan` (`securityyuan`),
  KEY `securitygai` (`securitygai`),
  KEY `securitywei` (`securitywei`),
  KEY `securityshang` (`securityshang`),
  KEY `uid` (`uid`),
  KEY `realname` (`realname`),
  KEY `themes` (`themes`),
  KEY `gender` (`gender`),
  KEY `birthday` (`birthday`),
  KEY `birthcity` (`birthcity`),
  KEY `residecity` (`residecity`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_level`
--

CREATE TABLE `phpapp_member_level` (
  `lid` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(60) NOT NULL,
  `small` int(10) NOT NULL DEFAULT '0',
  `big` int(10) NOT NULL DEFAULT '0',
  `style` varchar(60) NOT NULL,
  `color` varchar(8) NOT NULL,
  PRIMARY KEY (`lid`),
  KEY `small` (`small`),
  KEY `big` (`big`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_mail_certificate`
--

CREATE TABLE `phpapp_member_mail_certificate` (
  `uid` int(10) NOT NULL,
  `oid` int(10) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dateline` int(10) NOT NULL DEFAULT '0',
  `email` char(180) NOT NULL,
  `code` varchar(36) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  KEY `uid` (`uid`),
  KEY `email` (`email`),
  KEY `oid` (`oid`),
  KEY `price` (`price`),
  KEY `dateline` (`dateline`),
  KEY `status` (`status`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_message_set`
--

CREATE TABLE `phpapp_member_message_set` (
  `uid` int(10) NOT NULL DEFAULT '0',
  `setkey` text NOT NULL,
  KEY `uid` (`uid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_message_type`
--

CREATE TABLE `phpapp_member_message_type` (
  `mid` mediumint(8) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `displayorder` mediumint(8) NOT NULL DEFAULT '0',
  `satus` tinyint(1) NOT NULL DEFAULT '0',
  `notice` tinyint(1) NOT NULL DEFAULT '0',
  `email` tinyint(1) NOT NULL DEFAULT '0',
  `phone` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mid`),
  KEY `displayorder` (`displayorder`),
  KEY `satus` (`satus`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_mobile_certificate`
--

CREATE TABLE `phpapp_member_mobile_certificate` (
  `uid` int(10) NOT NULL DEFAULT '0',
  `oid` int(10) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dateline` int(10) NOT NULL DEFAULT '0',
  `mobile` varchar(40) NOT NULL,
  `code` char(8) NOT NULL,
  `errornum` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `number` tinyint(2) NOT NULL DEFAULT '0',
  KEY `uid` (`uid`),
  KEY `oid` (`oid`),
  KEY `price` (`price`),
  KEY `dateline` (`dateline`),
  KEY `errornum` (`errornum`),
  KEY `status` (`status`),
  KEY `number` (`number`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_myfriend`
--

CREATE TABLE `phpapp_member_myfriend` (
  `uid` int(10) NOT NULL,
  `fuid` int(10) NOT NULL,
  KEY `uid` (`uid`),
  KEY `fuid` (`fuid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_notice`
--

CREATE TABLE `phpapp_member_notice` (
  `nid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `new` tinyint(1) NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `cid` int(10) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nid`),
  KEY `uid` (`uid`),
  KEY `dateline` (`dateline`),
  KEY `new` (`new`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_personal`
--

CREATE TABLE `phpapp_member_personal` (
  `uid` int(10) NOT NULL DEFAULT '0',
  `about` mediumtext NOT NULL,
  `tasklatitude` float NOT NULL,
  `tasklongitude` float NOT NULL,
  `taskmapzoom` tinyint(2) NOT NULL,
  `residelatitude` float NOT NULL,
  `residelongitude` float NOT NULL,
  `residemapzoom` tinyint(2) NOT NULL DEFAULT '0',
  `taskcity` int(10) NOT NULL DEFAULT '0',
  KEY `uid` (`uid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_personal_certificate`
--

CREATE TABLE `phpapp_member_personal_certificate` (
  `uid` int(10) NOT NULL DEFAULT '0',
  `realname` varchar(60) NOT NULL,
  `idnumber` varchar(255) NOT NULL,
  `frontphoto` int(10) NOT NULL DEFAULT '0',
  `rearphoto` int(10) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `verifymoney` decimal(10,2) NOT NULL DEFAULT '0.00',
  `bankname` varchar(255) NOT NULL,
  `bankid` int(10) NOT NULL,
  `bankcard` varchar(255) NOT NULL,
  `bankaddress` int(10) NOT NULL,
  `errornum` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `pay` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  `errorinfo` text NOT NULL,
  KEY `uid` (`uid`),
  KEY `realname` (`realname`),
  KEY `frontphoto` (`frontphoto`),
  KEY `rearphoto` (`rearphoto`),
  KEY `type` (`type`),
  KEY `verifymoney` (`verifymoney`),
  KEY `errornum` (`errornum`),
  KEY `status` (`status`),
  KEY `pay` (`pay`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM;

-- --------------------------------------------------------


--
-- 表的结构 `phpapp_member_score`
--

CREATE TABLE `phpapp_member_score` (
  `sid` int(10) NOT NULL AUTO_INCREMENT,
  `seller` int(10) NOT NULL DEFAULT '0',
  `buyer` int(10) NOT NULL DEFAULT '0',
  `appid` int(10) NOT NULL DEFAULT '0',
  `speed` tinyint(1) NOT NULL DEFAULT '0',
  `attitude` tinyint(1) NOT NULL DEFAULT '0',
  `quality` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_security_certificate`
--

CREATE TABLE `phpapp_member_security_certificate` (
  `uid` int(10) NOT NULL DEFAULT '0',
  `sid` mediumint(6) NOT NULL DEFAULT '0',
  `cid` int(10) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dateline` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  KEY `uid` (`uid`),
  KEY `sid` (`sid`),
  KEY `cid` (`cid`),
  KEY `price` (`price`),
  KEY `dateline` (`dateline`),
  KEY `status` (`status`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_security_deduct`
--

CREATE TABLE `phpapp_member_security_deduct` (
  `did` int(10) NOT NULL AUTO_INCREMENT,
  `rid` int(10) NOT NULL DEFAULT '0',
  `oid` int(10) NOT NULL DEFAULT '0',
  `cid` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `sid` int(10) NOT NULL DEFAULT '0',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`did`),
  KEY `rid` (`rid`),
  KEY `uid` (`uid`),
  KEY `sid` (`sid`),
  KEY `money` (`money`),
  KEY `dateline` (`dateline`),
  KEY `cid` (`cid`),
  KEY `oid` (`oid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_sms`
--

CREATE TABLE `phpapp_member_sms` (
  `sid` int(10) NOT NULL AUTO_INCREMENT,
  `msggoid` int(10) NOT NULL DEFAULT '0',
  `msgtoid` int(10) NOT NULL DEFAULT '0',
  `mailbox` tinyint(1) NOT NULL DEFAULT '0',
  `new` tinyint(1) NOT NULL DEFAULT '1',
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `upid` int(10) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`),
  KEY `msggoid` (`msggoid`),
  KEY `msgtoid` (`msgtoid`),
  KEY `mailbox` (`mailbox`),
  KEY `new` (`new`),
  KEY `upid` (`upid`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_type`
--

CREATE TABLE `phpapp_member_type` (
  `id_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `name_phpapp` char(32) NOT NULL,
  `table_phpapp` char(80) NOT NULL,
  `status_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_phpapp`),
  KEY `status_phpapp` (`status_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_union`
--

CREATE TABLE `phpapp_member_union` (
  `uid` int(10) NOT NULL DEFAULT '0',
  `appid` int(10) NOT NULL DEFAULT '0',
  `money` float NOT NULL DEFAULT '0',
  `total` int(10) NOT NULL DEFAULT '0',
  KEY `uid` (`uid`),
  KEY `appid` (`appid`),
  KEY `money` (`money`),
  KEY `total` (`total`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_vip`
--

CREATE TABLE `phpapp_member_vip` (
  `uid` int(10) NOT NULL DEFAULT '0',
  `usergroup` int(10) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `auto` int(10) NOT NULL DEFAULT '0',
  `month` mediumint(8) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `endtime` int(10) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  KEY `uid` (`uid`),
  KEY `usergroup` (`usergroup`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_member_visit`
--

CREATE TABLE `phpapp_member_visit` (
  `uid` int(10) NOT NULL DEFAULT '0',
  `spaceuid` int(10) NOT NULL,
  `dateline` int(10) NOT NULL,
  KEY `uid` (`uid`),
  KEY `dateline` (`dateline`),
  KEY `spaceuid` (`spaceuid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_mobile_consume`
--

CREATE TABLE `phpapp_mobile_consume` (
  `mid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `mobile` char(20) NOT NULL,
  `content` text NOT NULL,
  `datetime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_nav`
--

CREATE TABLE `phpapp_nav` (
  `navid` mediumint(6) NOT NULL AUTO_INCREMENT,
  `navname` char(20) NOT NULL,
  `navurl` varchar(255) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `appid` int(10) NOT NULL DEFAULT '0',
  `blank` tinyint(1) NOT NULL DEFAULT '1',
  `site` tinyint(1) NOT NULL DEFAULT '0',
  `displayorder` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`navid`),
  KEY `default` (`default`),
  KEY `appid` (`appid`),
  KEY `blank` (`blank`),
  KEY `site` (`site`),
  KEY `displayorder` (`displayorder`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_nav_bottom`
--

CREATE TABLE `phpapp_nav_bottom` (
  `navid` int(10) NOT NULL AUTO_INCREMENT,
  `navname` char(20) NOT NULL,
  `navurl` varchar(255) NOT NULL,
  `blank` tinyint(1) NOT NULL DEFAULT '1',
  `displayorder` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`navid`),
  KEY `displayorder` (`displayorder`),
  KEY `blank` (`blank`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_nav_top`
--

CREATE TABLE `phpapp_nav_top` (
  `navid` int(10) NOT NULL AUTO_INCREMENT,
  `navname` char(20) NOT NULL,
  `navurl` varchar(255) NOT NULL,
  `blank` tinyint(1) NOT NULL DEFAULT '1',
  `displayorder` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`navid`),
  KEY `blank` (`blank`),
  KEY `displayorder` (`displayorder`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_pay`
--

CREATE TABLE `phpapp_pay` (
  `payuid` int(10) NOT NULL,
  `payapp` int(10) NOT NULL DEFAULT '0',
  `payorder` varchar(22) NOT NULL,
  `paytool` smallint(6) NOT NULL,
  `paymoney` decimal(10,2) NOT NULL DEFAULT '0.00',
  `dateline` int(10) NOT NULL DEFAULT '0',
  KEY `payuid` (`payuid`),
  KEY `payapp` (`payapp`),
  KEY `paytool` (`paytool`),
  KEY `paymoney` (`paymoney`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_pay_tool`
--

CREATE TABLE `phpapp_pay_tool` (
  `id_phpapp` int(10) NOT NULL DEFAULT '0',
  `name_phpapp` char(32) NOT NULL,
  `logo_phpapp` varchar(255) NOT NULL,
  `displayorder_phpapp` mediumint(8) NOT NULL DEFAULT '0',
  `type_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  `status_phpapp` tinyint(4) NOT NULL DEFAULT '0',
  KEY `id_ phpapp` (`id_phpapp`),
  KEY `displayorder_phpapp` (`displayorder_phpapp`),
  KEY `type_phpapp` (`type_phpapp`),
  KEY `status_phpapp` (`status_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_prop`
--

CREATE TABLE `phpapp_prop` (
  `sid` int(10) NOT NULL AUTO_INCREMENT,
  `appid` int(10) NOT NULL DEFAULT '0',
  `subject` varchar(50) NOT NULL,
  `content` varchar(255) NOT NULL,
  `day` int(10) NOT NULL DEFAULT '1',
  `count` tinyint(1) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `icon` varchar(255) NOT NULL,
  `usergroup` int(10) NOT NULL DEFAULT '0',
  `sell` tinyint(1) NOT NULL DEFAULT '0',
  `buynum` int(10) NOT NULL DEFAULT '10',
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`),
  KEY `appid` (`appid`),
  KEY `day` (`day`),
  KEY `count` (`count`),
  KEY `price` (`price`),
  KEY `status` (`status`),
  KEY `usergroup` (`usergroup`),
  KEY `sell` (`sell`),
  KEY `buynum` (`buynum`),
  KEY `displayorder` (`displayorder`),
  KEY `type` (`type`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_prop_consume`
--

CREATE TABLE `phpapp_prop_consume` (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `did` int(10) NOT NULL DEFAULT '0',
  `sid` int(10) NOT NULL DEFAULT '0',
  `oid` int(10) NOT NULL DEFAULT '0',
  `tid` int(10) NOT NULL DEFAULT '0',
  `app` int(10) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `day` int(10) NOT NULL DEFAULT '0',
  `endtime` int(10) NOT NULL DEFAULT '0',
  `runid` int(10) NOT NULL DEFAULT '0',
  KEY `cid` (`cid`),
  KEY `oid` (`oid`),
  KEY `uid` (`uid`),
  KEY `did` (`did`),
  KEY `sid` (`sid`),
  KEY `runid` (`runid`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_prop_order`
--

CREATE TABLE `phpapp_prop_order` (
  `oid` int(10) NOT NULL AUTO_INCREMENT,
  `sid` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `amount` int(10) NOT NULL DEFAULT '0',
  `process` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`oid`),
  KEY `sid` (`sid`),
  KEY `uid` (`uid`),
  KEY `amount` (`amount`),
  KEY `process` (`process`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_refund_item`
--

CREATE TABLE `phpapp_refund_item` (
  `pid` mediumint(6) NOT NULL AUTO_INCREMENT,
  `project` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_refund_money`
--

CREATE TABLE `phpapp_refund_money` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(10) NOT NULL DEFAULT '0',
  `oid` int(10) NOT NULL DEFAULT '0',
  `tid` int(10) NOT NULL DEFAULT '0',
  `pid` int(10) NOT NULL DEFAULT '0',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `buyerphoto` int(10) NOT NULL DEFAULT '0',
  `sellerphoto` int(10) NOT NULL DEFAULT '0',
  `buyeruid` int(10) NOT NULL DEFAULT '0',
  `selleruid` int(10) NOT NULL DEFAULT '0',
  `buyercontent` mediumtext NOT NULL,
  `sellercontent` mediumtext NOT NULL,
  `process` tinyint(2) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  `serviceuid` int(10) NOT NULL DEFAULT '0',
  `endtime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rid`),
  KEY `cid` (`cid`),
  KEY `oid` (`oid`),
  KEY `tid` (`tid`),
  KEY `pid` (`pid`),
  KEY `money` (`money`),
  KEY `buyeruid` (`buyeruid`),
  KEY `selleruid` (`selleruid`),
  KEY `process` (`process`),
  KEY `dateline` (`dateline`),
  KEY `endtime` (`endtime`),
  KEY `buyerphoto` (`buyerphoto`),
  KEY `sellerphoto` (`sellerphoto`),
  KEY `adminuid` (`serviceuid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_report`
--

CREATE TABLE `phpapp_report` (
  `rid` int(10) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL,
  `tid` int(10) NOT NULL DEFAULT '0',
  `did` int(10) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `dateline` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `award` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`rid`),
  KEY `uid` (`uid`),
  KEY `tid` (`tid`),
  KEY `did` (`did`),
  KEY `dateline` (`dateline`),
  KEY `status` (`status`),
  KEY `award` (`award`),
  KEY `type` (`type`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_report_type`
--

CREATE TABLE `phpapp_report_type` (
  `rid` smallint(6) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `name` char(50) NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_rewrite`
--

CREATE TABLE `phpapp_rewrite` (
  `id_phpapp` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name_phpapp` varchar(255) NOT NULL,
  `original_phpapp` varchar(255) NOT NULL,
  `format_phpapp` varchar(255) NOT NULL,
  `displayorder_phpapp` int(10) NOT NULL DEFAULT '0',
  `status_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_rights`
--

CREATE TABLE `phpapp_rights` (
  `rid` int(10) NOT NULL AUTO_INCREMENT,
  `cid` int(10) NOT NULL DEFAULT '0',
  `oid` int(10) NOT NULL DEFAULT '0',
  `tid` int(10) NOT NULL DEFAULT '0',
  `sid` int(10) NOT NULL DEFAULT '0',
  `buyerphoto` int(10) NOT NULL DEFAULT '0',
  `sellerphoto` int(10) NOT NULL DEFAULT '0',
  `buyeruid` int(10) NOT NULL DEFAULT '0',
  `selleruid` int(10) NOT NULL DEFAULT '0',
  `buyercontent` mediumtext NOT NULL,
  `sellercontent` mediumtext NOT NULL,
  `process` tinyint(2) NOT NULL DEFAULT '0',
  `serviceuid` int(10) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  `endtime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rid`),
  KEY `cid` (`cid`),
  KEY `oid` (`oid`),
  KEY `tid` (`tid`),
  KEY `buyerphoto` (`buyerphoto`),
  KEY `sellerphoto` (`sellerphoto`),
  KEY `buyeruid` (`buyeruid`),
  KEY `selleruid` (`selleruid`),
  KEY `process` (`process`),
  KEY `serviceuid` (`serviceuid`),
  KEY `dateline` (`dateline`),
  KEY `endtime` (`endtime`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_rights_credit`
--

CREATE TABLE `phpapp_rights_credit` (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `rid` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `credit` int(10) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`),
  KEY `uid` (`uid`),
  KEY `credit` (`credit`),
  KEY `dateline` (`dateline`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_security_item`
--

CREATE TABLE `phpapp_security_item` (
  `sid` mediumint(6) NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) NOT NULL,
  `logo` char(32) NOT NULL,
  `project` varchar(255) NOT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `description` text NOT NULL,
  `content` mediumtext NOT NULL,
  `field` char(32) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `displayorder` mediumint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`),
  KEY `money` (`money`),
  KEY `status` (`status`),
  KEY `displayorder` (`displayorder`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_skills`
--

CREATE TABLE `phpapp_skills` (
  `sid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL,
  `route` char(32) NOT NULL,
  `color` char(12) NOT NULL,
  `total` int(10) NOT NULL DEFAULT '0',
  `displayorder` tinyint(5) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `classname` varchar(255) NOT NULL,
  PRIMARY KEY (`sid`),
  KEY `displayorder` (`displayorder`),
  KEY `name` (`name`),
  KEY `total` (`total`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_slide`
--

CREATE TABLE `phpapp_slide` (
  `sid` int(10) NOT NULL AUTO_INCREMENT,
  `appid` int(10) NOT NULL DEFAULT '0',
  `subject` char(60) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `backgroundcolor` char(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`),
  KEY `appid` (`appid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_sns`
--

CREATE TABLE `phpapp_sns` (
  `id_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `app_phpapp` int(10) NOT NULL,
  `name_phpapp` char(80) NOT NULL,
  `icon_small_phpapp` varchar(255) NOT NULL,
  `icon_middle_phpapp` varchar(255) NOT NULL,
  `icon_big_phpapp` varchar(255) NOT NULL,
  `description_phpapp` text NOT NULL,
  `status_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_phpapp`),
  KEY `app_phpapp` (`app_phpapp`),
  KEY `status_phpapp` (`status_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_sns_api`
--

CREATE TABLE `phpapp_sns_api` (
  `appid` int(10) NOT NULL,
  `uid` int(10) NOT NULL DEFAULT '0',
  `apiname` char(36) NOT NULL,
  `apikey` char(10) NOT NULL,
  `followers` int(10) NOT NULL DEFAULT '0',
  KEY `appid` (`appid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_space_style`
--

CREATE TABLE `phpapp_space_style` (
  `sid` int(10) NOT NULL AUTO_INCREMENT,
  `style` char(32) NOT NULL,
  `dir` char(32) NOT NULL,
  `type` tinyint(3) NOT NULL DEFAULT '0',
  `usergroup` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`),
  KEY `type` (`type`),
  KEY `usergroup` (`usergroup`),
  KEY `status` (`status`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task`
--

CREATE TABLE `phpapp_task` (
  `tid` int(10) NOT NULL AUTO_INCREMENT,
  `appid` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `sid` int(10) NOT NULL DEFAULT '0',
  `lang` char(2) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `dateline` int(10) NOT NULL DEFAULT '0',
  `catid` int(10) NOT NULL DEFAULT '0',
  `skills` char(50) NOT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `addmoney` decimal(10,2) NOT NULL DEFAULT '0.00',
  `addmoneynum` int(10) NOT NULL DEFAULT '0',
  `total` int(10) NOT NULL DEFAULT '0',
  `credit` tinyint(1) NOT NULL DEFAULT '0',
  `price1` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price2` decimal(10,2) NOT NULL DEFAULT '0.00',
  `duration` smallint(5) NOT NULL DEFAULT '0',
  `tasktype` tinyint(1) NOT NULL DEFAULT '0',
  `timetype` tinyint(1) NOT NULL DEFAULT '0',
  `props` char(50) NOT NULL,
  `process` tinyint(2) NOT NULL DEFAULT '0',
  `endtime` int(10) NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `cityid` int(10) NOT NULL DEFAULT '0',
  `draft_number` int(10) NOT NULL DEFAULT '0',
  `draft_success` int(10) NOT NULL DEFAULT '0',
  `task_message` int(10) NOT NULL DEFAULT '0',
  `robots` tinyint(1) NOT NULL DEFAULT '0',
  `cloud` tinyint(1) NOT NULL DEFAULT '0',
  `hidedraft` tinyint(1) NOT NULL DEFAULT '0',
  `allowtender` tinyint(1) NOT NULL DEFAULT '0',
  `topbid` decimal(10,2) NOT NULL DEFAULT '0.00',
  `hide` tinyint(1) NOT NULL DEFAULT '0',
  `longitude` float NOT NULL DEFAULT '0',
  `latitude` float NOT NULL DEFAULT '0',
  `mapzoom` tinyint(2) NOT NULL DEFAULT '0',
  `realnametask` tinyint(1) NOT NULL DEFAULT '0',
  `keywords` char(150) NOT NULL,
  `description` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `serviceuid` int(10) NOT NULL DEFAULT '-1',
  `openflash` tinyint(1) NOT NULL DEFAULT '0',
  `seller` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `disagree` varchar(255) NOT NULL,
  `time` int(10) NOT NULL DEFAULT '0',
  `taskphone` char(20) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `appid` (`appid`),
  KEY `uid` (`uid`),
  KEY `lang` (`lang`),
  KEY `dateline` (`dateline`),
  KEY `catid` (`catid`),
  KEY `money` (`money`),
  KEY `price1` (`price1`),
  KEY `price2` (`price2`),
  KEY `process` (`process`),
  KEY `endtime` (`endtime`),
  KEY `cityid` (`cityid`),
  KEY `addmoney` (`addmoney`),
  KEY `total` (`total`),
  KEY `cloud` (`cloud`),
  KEY `draft_success` (`draft_success`),
  KEY `draft_number` (`draft_number`),
  KEY `task_message` (`task_message`),
  KEY `serviceuid` (`serviceuid`),
  KEY `allowtender` (`allowtender`),
  KEY `openflash` (`openflash`),
  KEY `addmoneynum` (`addmoneynum`),
  KEY `seller` (`seller`),
  KEY `sid` (`sid`),
  KEY `time` (`time`),
  FULLTEXT KEY `subject` (`subject`),
  FULLTEXT KEY `full_text_title` (`subject`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_add`
--

CREATE TABLE `phpapp_task_add` (
  `tid` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `dateline` int(10) NOT NULL DEFAULT '0',
  KEY `tid` (`tid`),
  KEY `uid` (`uid`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_count_usergroup`
--

CREATE TABLE `phpapp_task_count_usergroup` (
  `gid` int(10) NOT NULL DEFAULT '0',
  `feetype` tinyint(1) NOT NULL DEFAULT '0',
  `taskfee` float NOT NULL,
  `unionfee` float NOT NULL,
  `addunionfee` float NOT NULL,
  `addtask` tinyint(1) NOT NULL DEFAULT '0',
  `uploadfilestask` tinyint(1) NOT NULL DEFAULT '0',
  `edittask` tinyint(1) NOT NULL DEFAULT '0',
  `realnametask` tinyint(1) NOT NULL DEFAULT '0',
  `messagetask` tinyint(1) NOT NULL DEFAULT '0',
  `increasetask` tinyint(1) NOT NULL DEFAULT '0',
  `addnumbertask` int(10) NOT NULL DEFAULT '0',
  `refundtask` tinyint(1) NOT NULL DEFAULT '0',
  `smallrefundtask` int(10) NOT NULL DEFAULT '0',
  `extendnumbertask` int(10) NOT NULL DEFAULT '0',
  `extendmoneytask` decimal(10,2) NOT NULL DEFAULT '0.00',
  `maxmoneytask` decimal(10,2) NOT NULL DEFAULT '0.00',
  `smallmoneytask` decimal(10,2) NOT NULL DEFAULT '0.00',
  `addmoneytask` decimal(10,2) NOT NULL DEFAULT '0.00',
  `adddraft` tinyint(1) NOT NULL DEFAULT '0',
  `editdraft` tinyint(1) NOT NULL DEFAULT '0',
  `uploadfilesdraft` tinyint(1) NOT NULL DEFAULT '0',
  `commentsdraft` tinyint(1) NOT NULL DEFAULT '0',
  `votedraft` tinyint(1) NOT NULL DEFAULT '0',
  `joinmoneydraft` decimal(10,2) NOT NULL DEFAULT '0.00',
  `addnumberdraft` int(10) NOT NULL DEFAULT '0',
  `appallow` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_draft`
--

CREATE TABLE `phpapp_task_draft` (
  `did` int(10) NOT NULL AUTO_INCREMENT,
  `appid` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `tid` int(10) NOT NULL DEFAULT '0',
  `price` int(10) NOT NULL DEFAULT '0',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `time` tinyint(3) NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `process` tinyint(2) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  `share` tinyint(1) NOT NULL DEFAULT '0',
  `props` varchar(255) NOT NULL,
  `topbid` decimal(10,2) NOT NULL DEFAULT '0.00',
  `proposal` varchar(255) NOT NULL,
  `service` tinyint(1) NOT NULL DEFAULT '0',
  `openflash` tinyint(1) NOT NULL DEFAULT '0',
  `buyer` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`did`),
  KEY `tid` (`tid`),
  KEY `price` (`price`),
  KEY `process` (`process`),
  KEY `service` (`service`),
  KEY `share` (`share`),
  KEY `dateline` (`dateline`),
  KEY `appid` (`appid`),
  KEY `time` (`time`),
  KEY `uid` (`uid`),
  KEY `money` (`money`),
  KEY `openflash` (`openflash`),
  KEY `buyer` (`buyer`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_draft_comment`
--

CREATE TABLE `phpapp_task_draft_comment` (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `appid` int(10) NOT NULL DEFAULT '0',
  `did` int(10) NOT NULL DEFAULT '0',
  `tid` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`),
  KEY `did` (`did`),
  KEY `tid` (`tid`),
  KEY `uid` (`uid`),
  KEY `dateline` (`dateline`),
  KEY `appid` (`appid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_favorites`
--

CREATE TABLE `phpapp_task_favorites` (
  `tid` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  KEY `tid` (`tid`),
  KEY `uid` (`uid`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_grab_usergroup`
--

CREATE TABLE `phpapp_task_grab_usergroup` (
  `gid` int(10) NOT NULL DEFAULT '0',
  `feetype` tinyint(1) NOT NULL DEFAULT '0',
  `taskfee` float NOT NULL,
  `unionfee` float NOT NULL,
  `addunionfee` float NOT NULL,
  `appallow` tinyint(1) NOT NULL DEFAULT '0',
  `addtask` tinyint(1) NOT NULL DEFAULT '0',
  `uploadfilestask` tinyint(1) NOT NULL DEFAULT '0',
  `edittask` tinyint(1) NOT NULL DEFAULT '0',
  `realnametask` tinyint(1) NOT NULL DEFAULT '0',
  `messagetask` tinyint(1) NOT NULL DEFAULT '0',
  `increasetask` tinyint(1) NOT NULL DEFAULT '0',
  `addnumbertask` int(10) NOT NULL DEFAULT '0',
  `refundtask` tinyint(1) NOT NULL DEFAULT '0',
  `smallrefundtask` int(10) NOT NULL DEFAULT '0',
  `extendnumbertask` int(10) NOT NULL DEFAULT '0',
  `extendmoneytask` decimal(10,2) NOT NULL DEFAULT '0.00',
  `maxmoneytask` decimal(10,2) NOT NULL DEFAULT '0.00',
  `smallmoneytask` decimal(10,2) NOT NULL DEFAULT '0.00',
  `addmoneytask` decimal(10,2) NOT NULL DEFAULT '0.00',
  `adddraft` tinyint(1) NOT NULL DEFAULT '0',
  `editdraft` tinyint(1) NOT NULL DEFAULT '0',
  `uploadfilesdraft` tinyint(1) NOT NULL DEFAULT '0',
  `commentsdraft` tinyint(1) NOT NULL DEFAULT '0',
  `votedraft` tinyint(1) NOT NULL DEFAULT '0',
  `joinmoneydraft` decimal(10,2) NOT NULL DEFAULT '0.00',
  `addnumberdraft` int(10) NOT NULL DEFAULT '0',
  `realnameaddtask` tinyint(1) NOT NULL DEFAULT '0',
  `deletebid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gid`),
  KEY `deletebid` (`deletebid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_message`

--

CREATE TABLE `phpapp_task_message` (
  `mid` int(10) NOT NULL AUTO_INCREMENT,
  `appid` int(10) NOT NULL DEFAULT '0',
  `tid` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mid`),
  KEY `tid` (`tid`),
  KEY `uid` (`uid`),
  KEY `dateline` (`dateline`),
  KEY `appid` (`appid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_mode`
--

CREATE TABLE `phpapp_task_mode` (
  `mid` tinyint(3) NOT NULL AUTO_INCREMENT,
  `appid` int(10) NOT NULL DEFAULT '0',
  `name` char(30) NOT NULL,
  `displayorder` tinyint(5) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mid`),
  KEY `appid` (`appid`),
  KEY `status` (`status`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_order`
--

CREATE TABLE `phpapp_task_order` (
  `oid` int(10) NOT NULL AUTO_INCREMENT,
  `cid` int(10) NOT NULL DEFAULT '0',
  `did` int(10) NOT NULL DEFAULT '0',
  `tid` int(10) NOT NULL DEFAULT '0',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sum` decimal(10,2) NOT NULL DEFAULT '0.00',
  `content` mediumtext NOT NULL,
  `buyeruid` int(10) NOT NULL DEFAULT '0',
  `selleruid` int(10) NOT NULL DEFAULT '0',
  `buyer` tinyint(1) NOT NULL DEFAULT '0',
  `seller` tinyint(1) NOT NULL DEFAULT '0',
  `runid` int(10) NOT NULL DEFAULT '0',
  `closetime` int(10) NOT NULL DEFAULT '0',
  `workdate` tinyint(3) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`oid`),
  KEY `did` (`did`),
  KEY `tid` (`tid`),
  KEY `money` (`money`),
  KEY `buyer` (`buyer`),
  KEY `seller` (`seller`),
  KEY `dateline` (`dateline`),
  KEY `closetime` (`closetime`),
  KEY `cid` (`cid`),
  KEY `buyeruid` (`buyeruid`),
  KEY `selleruid` (`selleruid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_order_credit`
--

CREATE TABLE `phpapp_task_order_credit` (
  `oid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `cid` int(10) NOT NULL DEFAULT '0',
  `tid` int(10) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `level` tinyint(1) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `dateline` int(10) NOT NULL DEFAULT '0',
  `auto` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`oid`),
  KEY `uid` (`uid`),
  KEY `tid` (`tid`),
  KEY `type` (`type`),
  KEY `level` (`level`),
  KEY `dateline` (`dateline`),
  KEY `auto` (`auto`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_order_invoice`
--

CREATE TABLE `phpapp_task_order_invoice` (
  `iid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `oid` int(10) NOT NULL DEFAULT '0',
  `invoice` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`iid`),
  KEY `uid` (`uid`),
  KEY `oid` (`oid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_order_message`
--

CREATE TABLE `phpapp_task_order_message` (
  `mid` int(10) NOT NULL AUTO_INCREMENT,
  `appid` int(10) NOT NULL DEFAULT '0',
  `oid` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `dateline` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mid`),
  KEY `uid` (`uid`),
  KEY `dateline` (`dateline`),
  KEY `appid` (`appid`),
  KEY `oid` (`oid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_refund`
--

CREATE TABLE `phpapp_task_refund` (
  `rid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `tid` int(10) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `dateline` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rid`),
  KEY `uid` (`uid`),
  KEY `tid` (`tid`),
  KEY `dateline` (`dateline`),
  KEY `status` (`status`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_select`
--

CREATE TABLE `phpapp_task_select` (
  `catid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `upid` int(10) NOT NULL DEFAULT '0',
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `code` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `catid` (`catid`),
  KEY `upid` (`upid`),
  KEY `displayorder` (`displayorder`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_seller_select`
--

CREATE TABLE `phpapp_task_seller_select` (
  `catid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `upid` int(10) NOT NULL DEFAULT '0',
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `code` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `catid` (`catid`),
  KEY `upid` (`upid`),
  KEY `displayorder` (`displayorder`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_seller_service`
--

CREATE TABLE `phpapp_task_seller_service` (
  `sid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `appid` int(10) NOT NULL DEFAULT '0',
  `catid` int(10) NOT NULL DEFAULT '0',
  `subject` char(160) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `unit` char(10) NOT NULL,
  `time` tinyint(3) NOT NULL DEFAULT '0',
  `logo` int(10) NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sellnum` int(10) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `longitude` float NOT NULL,
  `latitude` float NOT NULL,
  `mapzoom` tinyint(2) NOT NULL DEFAULT '0',
  `realnametask` tinyint(1) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `props` char(50) NOT NULL,
  `topbid` decimal(10,2) NOT NULL DEFAULT '0.00',
  `robots` tinyint(1) NOT NULL DEFAULT '0',
  `openflash` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`),
  KEY `uid` (`uid`),
  KEY `dateline` (`dateline`),
  KEY `catid` (`catid`),
  KEY `robots` (`robots`),
  KEY `openflash` (`openflash`),
  KEY `topbid` (`topbid`),
  KEY `time` (`time`),
  KEY `price` (`price`),
  KEY `status` (`status`),
  KEY `sellnum` (`sellnum`),
  KEY `appid` (`appid`),
  FULLTEXT KEY `subject` (`subject`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_seller_usergroup`
--

CREATE TABLE `phpapp_task_seller_usergroup` (
  `gid` int(10) NOT NULL DEFAULT '0',
  `feetype` tinyint(1) NOT NULL DEFAULT '0',
  `taskfee` float NOT NULL,
  `unionfee` float NOT NULL,
  `addunionfee` float NOT NULL,
  `appallow` tinyint(1) NOT NULL DEFAULT '0',
  `addtask` tinyint(1) NOT NULL DEFAULT '0',
  `buyservice` tinyint(1) NOT NULL DEFAULT '0',
  `uploadfilestask` tinyint(1) NOT NULL DEFAULT '0',
  `edittask` tinyint(1) NOT NULL DEFAULT '0',
  `realnametask` tinyint(1) NOT NULL DEFAULT '0',
  `addnumbertask` int(10) NOT NULL DEFAULT '0',
  `maxmoneytask` decimal(10,2) NOT NULL DEFAULT '0.00',
  `smallmoneytask` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_task_total`
--

CREATE TABLE `phpapp_task_total` (
  `uid` int(10) NOT NULL DEFAULT '0',
  `tasknum` int(10) NOT NULL DEFAULT '0',
  `draftnum` int(10) NOT NULL DEFAULT '0',
  `successnum` int(10) NOT NULL DEFAULT '0',
  `servicenum` int(10) NOT NULL DEFAULT '0',
  KEY `tasknum` (`tasknum`),
  KEY `uid` (`uid`),
  KEY `draftnum` (`draftnum`),
  KEY `successnum` (`successnum`),
  KEY `servicenum` (`servicenum`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_templateblock`
--

CREATE TABLE `phpapp_templateblock` (
  `id_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `apps_phpapp` int(10) NOT NULL DEFAULT '0',
  `label_phpapp` char(60) NOT NULL,
  `quote_phpapp` varchar(255) NOT NULL,
  `status_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_union`
--

CREATE TABLE `phpapp_union` (
  `id_phpapp` int(10) NOT NULL AUTO_INCREMENT,
  `rebate_phpapp` float NOT NULL DEFAULT '0',
  `service_phpapp` int(10) NOT NULL DEFAULT '0',
  `status_phpapp` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_phpapp`),
  KEY `rebate_phpapp` (`rebate_phpapp`),
  KEY `service_phpapp` (`service_phpapp`),
  KEY `status_phpapp` (`status_phpapp`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_usergroup`
--

CREATE TABLE `phpapp_usergroup` (
  `gid` int(10) NOT NULL AUTO_INCREMENT,
  `usertype` tinyint(3) NOT NULL DEFAULT '1',
  `groupname` char(60) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `allowdomainname` tinyint(1) NOT NULL DEFAULT '0',
  `allowlogin` tinyint(1) NOT NULL DEFAULT '0',
  `allowskillnumber` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gid`),
  KEY `usertype` (`usertype`),
  KEY `allowskillnumber` (`allowskillnumber`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `phpapp_userguide`
--

CREATE TABLE `phpapp_userguide` (
  `sid` int(10) NOT NULL AUTO_INCREMENT,
  `appid` int(10) NOT NULL DEFAULT '0',
  `subject` char(60) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`),
  KEY `appid` (`appid`)
) ENGINE=MyISAM;


