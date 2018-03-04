<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class UserGuideMainControls extends PHPAPP{
	
    private $actionmenu,$POST,$GET;
	
	public $appid;
	
	function __construct(){	
           
		   parent::__construct();
		   
		   $this->appid=empty($_GET['appid']) ? 56 : intval($_GET['appid']);
		   
		   $postkey=array('Submit'=>'','checkbox'=>'');
		   
		   $this->POST=$this->POSTArray();
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','action'));
		         
	}
	
	function DefaultAction(){

		     $list=$this->GetMysqlArray('*'," ".$this->GetTable('userguide')." WHERE appid='$this->appid' AND status=0 ORDER BY displayorder ASC ");
		  
		     include $this->Template('list');

	}
	
	
	
}


?>