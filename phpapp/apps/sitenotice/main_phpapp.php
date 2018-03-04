<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class SiteNoticeMainControls extends PHPAPP{

	function __construct(){	
	
	       parent::__construct();

	}
	
	
	function DefaultAction(){
		  $this->GetNoticeAction();
	}
	
	
	function GetNoticeAction(){
		
		  include $this->Template('notice_new');
		 
	}
	
}




?>