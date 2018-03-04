<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class AdvertisingMainControls extends PHPAPP{
	
	public $ad;
	
	function __construct(){	

	       parent::__construct();
		   
           $this->ad=empty($_GET['ad'])? 0 : intval($_GET['ad']);
		         
	}
	
	
	function DefaultAction(){
		   $this->ShowAction();
	}
	
	
	function ShowAction(){
		  
		   $manage=$this->GetMysqlOne('code_phpapp'," ".$this->GetTable('advertising')." WHERE id_phpapp='$this->ad'");
		   
		   header('Content-type: application/x-javascript');
		   
		   echo 'document.write(\'<div>'.$manage['code_phpapp'].'.</div>\');';

	}
	
}



?>



