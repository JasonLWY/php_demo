<?php
/*
	EDOOG.COM (C) 2009-2014 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.5
*/	

define('IN_PHPAPP',TRUE);

define('OPENMOBILE',false);

include('./phpapp/config.php');

error_reporting(0);

@ob_start("ob_gzhandler");

header('Content-type: text/html;charset='.S_CHARSET);

define('PHPAPP_DIR',preg_replace("/\\\/", "/", dirname(__FILE__) ) );

$language='cn';

$app=$action='Default';

$actiontype=0;

include(Core.'/class/core_class_phpapp.php');
include(Core.'/class/admin_class_phpapp.php');

$phpapp=new SystemConfig();
         
$phpapp->MemoryCache();

$phpapp->MysqlConnect();

$phpapp->SetConfigDIR();

$phpapp->GetConfig();
	
$phpapp->SetSystemAppKey();

$systemvalue=$phpapp->SetSystemVariable();
		 
$phpapp->SetStylePath();

$phpapp->GetTimezone();

$phpapp->GetFileIcon();

$phpapp=new PHPAPPAdmin();

$phpapp->AdminAccess();

?>