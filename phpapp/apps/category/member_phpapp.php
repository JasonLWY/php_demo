<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

	
class CategoryMemberControls extends PHPAPP{
	
	function __construct(){	 
	 
		 parent::__construct();
		 
		 $this->POST=$this->POSTArray();
			
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','type'));
		 
		 if($this->uid<1){
			  echo 'ÇëµÇÂ¼ºó²Ù×÷£¡';
		 }
		 
		 
	}
	
	
	public function DefaultAction(){
		
		  return $this->GetCategoryAction();
		
	}
	
	
	public function GetCategoryAction(){
           
		   $tablearr=array('category','category_city');
		   
		   $tablename='';
		   foreach($tablearr as $value){
			    if($this->POST['table']==$value){
					  $tablename=$value;
				}
		   }

		   if(!empty($tablename) && !empty($this->POST['id']) && !empty($this->POST['show'])){
		   
		          echo  $this->SetSelectCategory($tablename,intval($this->POST['id']),$this->POST['show'],intval($this->POST['appid']),intval($this->POST['myfunction']));
		   }
		
		
	}
	
	public function GetSkillAction(){
		 
		  if($this->GET['catid']>0){
			  
			     $catid=$this->GET['catid'];
				 $categoryarr=$this->GetMysqlOne('skills'," ".$this->GetTable('category')." WHERE catid='$catid'");
				 echo $categoryarr['skills'];
		  }
		   
	}
	
	
	
	
}

?>