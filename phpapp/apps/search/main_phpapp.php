<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

require_once(Core.'/class/category_class_phpapp.php');
include_once(Core.'/class/skill_class_phpapp.php');

class SearchMainControls extends PHPAPP{
	
    private $POST,$GET,$errors;
	
	
	function __construct(){	
	       
		   parent::__construct();

		   
		   $postkey=array('Submit'=>'');
			
			
		   $this->POST=$this->POSTArray();
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','total','type','catid','action','search'));
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
      
	}
	
	
	function DefaultAction(){

		 $this->SearchAction();
	}
	
	function SearchAction(){
		   
		   $search=empty($_GET['search']) ? '' : $_GET['search'];
		 
		   $search=urldecode($this->str($search,12,1,0,1,0,1));
		   
		   if($search){
				 
				 $categoryclass=new CategoryClass();
				 $skilldata=new SkillClass();

				 $searchsql=sprintf("WHERE name REGEXP '%s'",htmlspecialchars($search,ENT_QUOTES));
			     //分类
				 $categoryarr=$this->GetMysqlArray('*'," ".$this->GetTable('category')." $searchsql ");
					 
				 //技能	 
		         $skillsarr=$this->GetMysqlArray('*'," ".$this->GetTable('skills')." $searchsql ");
				 
				 $skills='';
				 if($skillsarr){
					  foreach($skillsarr as $value){
						   if($skills){
							     $skills=','.$value['sid'];
						   }else{
							     $skills=$value['sid'];
						   }
					  }
					  
					  $skillarray=$skilldata->GetSkillURL($skills);
				 }
				 

				 include_once(Core.'/class/pages_class_phpapp.php');
	
				 $pageurl=SURL.'/index.php?app=22&search='.urlencode($search);
				
				 $searchsql='';
				
				 if($search){
					  
					   if(PHPAPP::$config['setsearchmode']==1){
							 $searchsql=sprintf("WHERE MATCH (subject) AGAINST ('%s')",htmlspecialchars($search,ENT_QUOTES));
					   }else{
							 $searchsql=sprintf("WHERE subject REGEXP '%s'",htmlspecialchars($search,ENT_QUOTES));
					   }
					   
					   if(PHPAPP::$config['setsearchmode']==1){
						   	 $usersearchsql=sprintf("WHERE MATCH (username) AGAINST ('%s')",htmlspecialchars($search,ENT_QUOTES));
					   }else{
					   		 $usersearchsql=sprintf("WHERE username REGEXP '%s'",htmlspecialchars($search,ENT_QUOTES));
					   }

				 }

				 $page=new Pages(10,$this->GET['page'],$pageurl," SELECT appid,uid,subject,url,description,dateline FROM ".$this->GetTable('task')." $searchsql UNION SELECT appid,uid,subject,url,description,dateline FROM ".$this->GetTable('task_seller_service')." $searchsql UNION SELECT  userpost AS appid,uid,username AS subject,username AS description,uid AS url,dateline FROM ".$this->GetTable('member')." $usersearchsql");

				 $list=$page->ShowResult();
						  
				
		   
		   }else{
		         $list='';
		   }
		   

		   include $this->Template('search');
	}

	
	function ReplaceRed($search='',$content=''){
		 
		 if($search && $content){
		      return str_replace($search,'<span class="red">'.$search.'</span>',$content);
	     }
	}
	
	
}




?>