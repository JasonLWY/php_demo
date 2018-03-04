<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class CaseMainControls extends PHPAPP{

	  private $POST,$GET,$errors;
	
	  public $catid;
	  
	  function __construct(){	
	  
			 parent::__construct();
			 
			 $item=explode('.',empty($_GET['item']) ? 0 :$_GET['item']);
		   
			 if(!empty($item[1])){
				   $this->catid=intval($item[1]);
			 }else{
			 
				   $this->catid=empty($_GET['item']) ? 0 : intval($_GET['item']);
			 }
			 
			 $postkey=array('Submit'=>'');
			  
			  
			 $this->POST=$this->POSTArray();
			 
			 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','total','catid','hid'));
			 
			 foreach($postkey as $key=>$vaule){
				 if(empty($this->POST[$key])){
					 $this->POST[$key]='';
				 }
			 }
		
	  }
	  
	  function DefaultAction($catid=0,$skill=0,$app=0){
		  
		   if($app==122){
		   		$this->app=$app;
		   }

		   $total=empty($_GET['total']) ? 20 : intval($_GET['total']);
		   
		   require_once(Core.'/class/list_class_phpapp.php');
		   
		   include_once(Core.'/class/skill_class_phpapp.php');
		   
		   $skilldata=new SkillClass();
		   
		   
		   $selectclass=new SelectData($selectarray,$catid,$skill);

           $selectctarray=$selectclass->GetSelectCategory(1);

		   $selectsql=$selectclass->GetSelectOneSQL('',$selectctarray[5],'a.catid');
		   
		   include_once(Core.'/class/pages_class_phpapp.php');
 

			$pageurl=$selectclass->GetSelectAllURL();
				   
		    $page=new Pages(16,$this->GET['page'],$pageurl,"SELECT a.*,c.thumb FROM ".$this->GetTable('case')." AS a LEFT JOIN ".$this->GetTable('file')." AS c ON a.photo=c.fid WHERE a.cid>0 $selectsql ORDER BY a.cid DESC");
		   
		    $list=$page->ShowResult();
			
            //SEO
		    PHPAPP::$SEO['title']=empty($selectctarray[2])? '' :$selectctarray[2];
		    PHPAPP::$SEO['keywords']=empty($selectctarray[3])? '' :$selectctarray[3];
		    PHPAPP::$SEO['description']=empty($selectctarray[4])? '' :$selectctarray[4];
		  

		     include $this->AppsView('case:list');
	  }
	  
	  
	  function ShowAction(){
		  
		  if($this->GET['cid']>0){
			   
			     $cid=$this->GET['cid'];
			     $show=$this->GetMysqlOne('*'," ".$this->GetTable('case')." WHERE cid='$cid'");
				 
		
				 if(!$show){
			           $this->DefaultAction();
		         }else{ 
				       
					   //SEO
					   PHPAPP::$SEO['title']=$show['subject'];
					   PHPAPP::$SEO['keywords']=$show['subject'];
					   PHPAPP::$SEO['description']=$this->str($show['content'],80,0,1,1,0,1);

					   include $this->AppsView('show');
				 }
				  
		   }else{
			     $this->DefaultAction();
		   }
		  
	  }
	  
}

?>