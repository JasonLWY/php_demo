<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class UnionMemberControls extends PHPAPP{
	
    private $POST,$GET;
	
	function __construct(){	 
	 
		 parent::__construct();
		 
		 $this->POST=$this->POSTArray();
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','sort'));

		 
		 if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
		 
	}
	
	
	public function DefaultAction(){
		
		  return $this->ResultAction();
		
	}

	
	public function ResultAction(){
		        
			    $list=$this->GetMysqlArray('a.name_phpapp AS subject,b.*'," ".$this->GetTable('apps')." AS a JOIN ".$this->GetTable('member_union')." AS b ON a.id_phpapp=b.appid  WHERE b.uid='$this->uid' ORDER BY a.displayorder_phpapp ASC");	 

				include $this->Template('result_member');

		  
	}
	
	
	public function UserAction(){
		
		      include_once(Core.'/class/pages_class_phpapp.php');
		         


			 $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=2',"SELECT * FROM ".$this->GetTable('member')."  WHERE unionid='$this->uid' ORDER BY dateline DESC");
				   
				   
			 $list=$page->ShowResult();
		    
			include $this->Template('user_member');
		
	}

	
}

?>