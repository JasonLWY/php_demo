<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.1
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(APPS.'/taskmode/public_phpapp.php');

class MyTaskGrab extends TaskPublicClass{
	
    public $POST,$GET,$errors;
	
	public $tid;
	
	function __construct(){	
	
		   parent::__construct();
      
	}
	
	function DefaultAction(){

	}
	
	
}




?>