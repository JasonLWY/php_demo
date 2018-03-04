<?php
/*
	EDOOG.COM (C) 2009-2014 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.1
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


error_reporting(0);

@ob_start("ob_gzhandler");

header('Content-type: text/html;charset='.S_CHARSET);

$welcomeid =empty($_GET['u']) ? 0 : intval($_GET['u']);

if($welcomeid>0){
	 $_SESSION['UNION']=$welcomeid;
}



include(Core.'/class/core_class_phpapp.php');

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

$phpapp->EDOOGDomain();

$phpapp->GetNowCity();

$phpapp->SiteClose();

$phpapp->SiteAccess();

echo $phpapp->GetDialog();

if(!DB_CONNECT){
     mysql_close();
}

$phpapp->WriteSiteLog();

?>