<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class SNSIDMemberControls extends PHPAPP{
	
    private $POST,$GET;
	
	public $api;
	
	function __construct(){	 
	    
		 parent::__construct();
		 
		 $this->api=empty($_GET['api']) ? 0 : intval($_GET['api']);
		 

		 $this->POST=$this->POSTArray();
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','sort'));

		 
		 if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
		 
	}
	
	
	public function DefaultAction(){
		
		  return $this->SetSNSIDAction();
		
	}
	
	
	public function SetSNSIDAction(){
		        
				if($this->api>0){
					  
					  $this->Delete('sns_api'," WHERE uid='$this->uid' AND appid='$this->api'");
					  
					  $this->Refresh('取消成功!','member.php?app=19');
					
				}else{
			    
					  $list=$this->GetMysqlArray('*'," (SELECT DISTINCT * FROM ".$this->GetTable('sns')." WHERE status_phpapp='0') AS a LEFT JOIN (SELECT * FROM ".$this->GetTable('sns_api')."  WHERE uid='$this->uid') AS b ON a.app_phpapp=b.appid ");
	  
					
					  include $this->Template('item_member');
				}
		
		  
	}
	
	
}

?>