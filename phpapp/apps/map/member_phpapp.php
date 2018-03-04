<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class MapMemberControls extends PHPAPP{
	
    private $POST,$GET;
	
	
	function __construct(){	
	
	       parent::__construct();
		   
		   
		   $postkey=array('Submit'=>'');
			
			
		   $this->POST=$this->POSTArray();
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','type'=>'','op'=>''));
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
		   
		   if($this->uid<1){
			     $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		   }
      
	}
	
	function DefaultAction(){

		 $this->TaskMapAction();
	}
	
	
	function TaskMapAction(){
		   
		   $member=$this->GetMysqlOne('username,usertype'," ".$this->GetTable('member')." WHERE uid='$this->uid'");
				 
		   $membertable=$this->GetTypeMember($member['usertype']);
				 
		   $info=$this->GetMysqlOne('*',"  ".$this->GetTable($membertable)."  WHERE uid='$this->uid'");
				 
		   if($this->POST['Submit']){	

                  $this->POST['taskcity']=$this->POST['showselectcity'];

		          $this->Update($membertable,$this->POST,array(),"WHERE uid='$this->uid' ");
		  
		  
		  
		          echo '<p>设置成功</p>';
												       
			      echo $this->CloseNowWindows('#loading');
												 
		   }else{
												 
				 if(!empty($this->GET['op'])){	
				       include $this->Template('setmap_member');
				 }else{
				       include $this->Template('taskmap_member');
				 }
			
		   }
		
		
	}
	
	
	function ResideMapAction(){
   
   
           $member=$this->GetMysqlOne('username,usertype'," ".$this->GetTable('member')." WHERE uid='$this->uid'");
				 
		   $membertable=$this->GetTypeMember($member['usertype']);
		   
		   $user=$this->GetMysqlOne('residecity'," ".$this->GetTable('member_info')." WHERE uid='$this->uid'");
				 
		   $info=$this->GetMysqlOne('*',"  ".$this->GetTable($membertable)."  WHERE uid='$this->uid'");
				 
		   if($this->POST['Submit']){	
		  
		          $this->Update($membertable,$this->POST,array(),"WHERE uid='$this->uid' ");

		          $this->Update('member_info',array('residecity'=>$this->POST['showselectcity']),array(),"WHERE uid='$this->uid' ");
		           
		          echo '<p>设置成功</p>';
												       
			      echo $this->CloseNowWindows('#loading');
												 
		   }else{
												 
				 if(!empty($this->GET['op'])){	
				       include $this->Template('setresidemap_member');
				 }else{		   
				       include $this->Template('residemap_member');
				 }
			
		   }

		 
	}
	
	
	function SetMapInfoAction(){
		
		  //地图反地址
		  if($this->GET['type']){
			  
				//print_r($this->POST);
				if($this->POST['district']){
					  $searchsql=sprintf("WHERE name REGEXP '%s'",$this->POST['district']);
					  
					  $category=$this->GetMysqlOne('catid'," ".$this->GetTable('category_city')." $searchsql");
					  
					  if($category){
							
							echo $this->GetSelectCategory('category_city',intval($category['catid']),'showselectcity');
						  
					  }
				}
				
			  
		  }else{
			   
			    
			  
		  }
		
	}

}

?>