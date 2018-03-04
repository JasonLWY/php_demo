<?php
/*
	EDOOG.COM (C) 2009-2014 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.2
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class SkillsMainControls extends PHPAPP{
	
	public $GET;
	
	function __construct(){	 
	     
		 parent::__construct();
		   
		 $this->POST=$this->POSTArray();
			
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id'));
		 
	}
	
	
	public function DefaultAction(){
		
		   include_once(Core.'/class/skill_class_phpapp.php');
		   
		   $skill=new SkillClass();
		   
		   $skill->MakeSkillCache();
		   
		   
		   if(S_REWRITE_URL){
			     include(SYS.'/data/cache/config/route_apps.php');
				
		   }else{
		   		 include(SYS.'/data/cache/config/apps.php');
		   }
            
		   $appid=intval($apps[$_GET['type']]['id_phpapp']);

		   if($appid==55){  //人才
		
			     include_once(APPS.'/job/main_phpapp.php');
				   
				 $job=new JobMainControls();
	
				 $job->JobList(0,$skill->GetSkillSID(),$appid);
				 
		   }elseif($appid==82){  //服务
			     include_once(APPS.'/sellerservice/main_phpapp.php');
				   
				 $service=new SellerServiceMainControls();
	
				 $service->SellerServiceListAction(0,$skill->GetSkillSID(),$appid);
			   
		   }else{ //任务
				   include_once(APPS.'/taskmode/main_phpapp.php');
				   
				   $task=new TaskModeMainControls();
	
				   $task->TaskListAction(0,$skill->GetSkillSID());
		   }
		
	}
	
	
	public function TaskAction(){

		   $this->DefaultAction();
		
	}
	

	
}



?>