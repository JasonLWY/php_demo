<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class SinaAPIManageControls extends PHPAPP{
	
    public $actionmenu,$POST,$GET;
	
	function __construct($actionmenu=''){	
           
		   parent::__construct();
		   
	       $this->actionmenu=$actionmenu;
		   
		   $postkey=array('Submit'=>'');
		   
		   $this->POST=$this->POSTArray();
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','action'));
		         
	}
	
	function DefaultAction(){
		
		  return $this->ConfigAction();
	}
	
	
	function ConfigAction(){
		
            $menu=$this->GET['menu'];
			 
			$manage=$this->GetMysqlOne('apps_phpapp'," ".$this->GetTable('admin_menu')." WHERE catid_phpapp='$menu'");
			
			if($this->POST['Submit']){
				
				  $this->SetConfig($this->POST);
				
			}else{
		
			      include $this->Template('sina_config_manage');
			
			}
																				
			
	}
	
	
	
}

?>