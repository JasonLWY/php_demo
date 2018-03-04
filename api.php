<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

define('IN_PHPAPP', TRUE);

define('OPENMOBILE', FALSE);

include('phpapp/config.php');

define('PHPAPP_DIR',preg_replace("/\\\/", '/', dirname(__FILE__) ) );

header('Content-type: text/html;charset='.S_CHARSET);

include(Core.'/class/core_class_phpapp.php');

$language='cn';

$phpapp=new SystemConfig();
         
$phpapp->MemoryCache();

$phpapp->MysqlConnect();

$phpapp->SetConfigDIR();

$phpapp->GetConfig();
	
$phpapp->SetSystemAppKey();

$systemvalue=$phpapp->SetSystemVariable();

$phpapp->SetStylePath();

$phpapp->GetTimezone();


?>