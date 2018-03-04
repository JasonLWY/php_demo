<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class CertificateMemberControls extends PHPAPP{
	
    private $POST,$GET;

	
	function __construct(){	 
	 
         parent::__construct();
		 
		 $this->cid=empty($_GET['cid']) ? 1 : intval($_GET['cid']);
		 
		 
		 $this->POST=$this->POSTArray();
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','sort'));

		 
		 if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
		 
	}
	
	
	public function DefaultAction(){
		
		  return $this->ItemAction();
		
	}
	
	
	public function ItemAction(){
		   
				
				$user=$this->GetMysqlOne('usertype'," ".$this->GetTable('member')." WHERE uid='$this->uid'");
				
			
				$type=$user['usertype'];
				$usertype="  OR type_phpapp='$type'";
				
				$list=$this->GetMysqlArray('*'," ".$this->GetTable('certificate')." WHERE status_phpapp=0 AND type_phpapp=0 $usertype ");
				 
				 


		        include $this->Template('item_member');

	}
	
	
	
	
	
	public function ShowAction(){
		
			  
             
	  
				 include $this->Template('show_member');
		
	}
	
	
		
		
}

?>