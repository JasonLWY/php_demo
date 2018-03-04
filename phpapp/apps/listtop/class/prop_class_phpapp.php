<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(APPS.'/taskmode/public_phpapp.php');

class ListTopProp extends TaskPublicClass{

	function __construct(){	 
	      parent::__construct();
		  
	}
	
	function PropAction($siteservice){
		     
		 $this->SetPropDefaultTop($siteservice,2);
		 
	}
	
}


?>