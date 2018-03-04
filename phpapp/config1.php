<?php

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


define('S_START_TIME',microtime(true)); 

//-------------------------------------------------------------------------------------------
//Session
session_start();                                                  // 开启 Session

//-------------------------------------------------------------------------------------------

//路径设定

define('SDIR','');                                        //程序路径 (根目录留空)

//SURL
define('SURL','http://'.$_SERVER ['HTTP_HOST'].SDIR);              //本站网址

//SYS
define('SYS',preg_replace("/\\\/", '/', dirname(__FILE__) ) );     //系统根路径

//Core
define('Core',SYS.'/apps/core' );                                

//Apps
define('APPS',SYS.'/apps' );                                      //应用根路径

//---------------------------------------------------------------------------------------------

//网站配置

define('S_CHARSET','gbk');                    //网站字符集与使用页面语言

define('S_TEMPLATE','default');               //站点目前使用的风格目录名 default 为系统默认风格

define('S_CACHE_TIME','18000');                //模板缓存相隔更新时间 单位秒 18000

define('S_REWRITE_URL','0');                  //伪静态功能 1 为开 0 为关

define('S_CACHE_MEMORY_OPEN','0');            //内存缓存   0 关 1 开

define('S_CACHE_MEMORY_CONNECT','0');         //内存缓存持久连接   0 关 1 开

define('S_SITE_SQL',0);                       //后台是否可以执行SQL 1 可以 0 关闭

define('S_ADMIN','1');                        //管理员 UID, 可以支持多个管理员，之间使用 “,” 分隔。 

define('S_HTML_ALLOW','<a><p><br></br><u><i><b><strong><img><em><span><div><font><h1><h2><h3><h4><h5><h6><ul></li><ol><table><tr><td>');  //编辑器标签


//---------------------------------------------------------------------------------------------

//上传目录设定

define('S_ATTACHMENT_DIR','attachment');      //上传目录

define('S_UPLOAD_DIR',S_ATTACHMENT_DIR.'/upload'); //上传文件目录

define('S_UPLOAD_CERTIFICATE_DIR',S_ATTACHMENT_DIR.'/certificate'); //上传证件目录

define('S_BACKUP_DIR',SYS.'/data/backup');   //设定数据库备份目录

//---------------------------------------------------------------------------------------------

//数据库配置

define('DB_HOST','localhost');                //服务器地址

define('DB_USER','mmsuinikan');                     //用户名

define('DB_PW','123456ddff');                      //密码

define('DB_NAME','123mmsuinikanff');                  //数据库名

define('DB_TNAME','phpapp_');                 //表名前缀

define('DB_CHARSET','gbk');                  //数据库字符集

define('DB_CONNECT','0');                   //数据库持久连接 0 关 1 开


//网站日志配置

define('S_SITE_LOG',0);                       //后台是否开启网站日志 1 可以 0 关闭

define('S_SITE_LOG_SIZE',1024000);            //单个网站日志文件大小 单位 字节

?>