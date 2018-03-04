<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class MemberVipMainControls extends PHPAPP{
	
    public $POST,$GET,$errors;
	
	function __construct(){	
	
		   parent::__construct();
		   
		   $this->POST=$this->POSTArray();
		   
		   $this->GET=$this->GetArray(array());

	}
	
	function DefaultAction(){
		  $this->BuyVIP();
	}
	
	function BuyVIPAction(){
		  include $this->Template('buyvip');
	}
	
}




?>