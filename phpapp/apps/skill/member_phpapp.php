<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class SkillsMemberControls extends PHPAPP{
	
    public $POST,$GET;

	function __construct(){	 
	 
		 parent::__construct();
		 
		 $this->POST=$this->POSTArray();
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','sort','sid'));

		 
		 if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
		 
	}
	
	
    function DefaultAction(){
		
		  $this->SetSkillsAction();
		
	}
	
    function SetSkillsAction($issdd=0){
		
		  if($this->POST['Submit']){
			    
				$skills=$this->ExplodeStrArr($this->POST['skills']);
				
			    $this->Update('member',array('skills'=>$skills),array()," WHERE uid='$this->uid'");
				
				$this->Update('member_info',array('catid'=>intval($this->POST['catid'])),array()," WHERE uid='$this->uid'");
			  
			    echo '±£´æ³É¹¦!<br />';
					  
			    echo $this->CloseNowWindows('#loading');
		  }else{
			  
			    $member=$this->GetMysqlOne('skills',"".$this->GetTable('member')." WHERE  uid='$this->uid'");	  
				
				$memberinfo=$this->GetMysqlOne('catid',"".$this->GetTable('member_info')." WHERE  uid='$this->uid'");	  
			  
		  		include $this->Template('skill:set_member');
		  
		  }
		
		
	}

}

?>