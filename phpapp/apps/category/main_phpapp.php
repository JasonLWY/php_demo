<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class CategoryMainControls extends PHPAPP{
	
	public $GET;
	
	function __construct(){	 
	     
		 parent::__construct();
		   
		 $this->POST=$this->POSTArray();
			
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','type'));
		 
	}
	
	
	public function DefaultAction(){
		
		   include_once(Core.'/class/category_class_phpapp.php');
		   
		   $category=new CategoryClass();
		   
		   $category->MakeCategoryCache();
		   
		   if(preg_match('/^[a-z]+$/i',$_GET['type'])){
			     include(SYS.'/data/cache/config/route_apps.php');
		   }else{
		   		 include(SYS.'/data/cache/config/apps.php');
		   }
            
		   $appid=intval($apps[$_GET['type']]['id_phpapp']);
           
		   if($appid==122){  //案例
		
			     include_once(APPS.'/case/main_phpapp.php');
				   
				 $case=new CaseMainControls();
	
				 $case->DefaultAction($category->GetCategoryID(),0,$appid);

		   }elseif($appid==55){  //人才
		
			     include_once(APPS.'/job/main_phpapp.php');
				   
				 $job=new JobMainControls();
	
				 $job->JobList($category->GetCategoryID(),0,$appid);
				 
		   }elseif($appid==82){  //服务
			   
			     include_once(APPS.'/sellerservice/main_phpapp.php');
				   
				 $service=new SellerServiceMainControls();
	
				 $service->SellerServiceListAction($category->GetCategoryID(),0,$appid);
				 
		   }else{ //任务
		   
				 include_once(APPS.'/taskmode/main_phpapp.php');
				   
				 $task=new TaskModeMainControls();
				   
				 $task->TaskListAction($category->GetCategoryID());
		   
		   }
		   
		  
	}
	

	
}



?>