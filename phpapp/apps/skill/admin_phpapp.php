<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class SkillsManageControls extends PHPAPP{
	
    private $actionmenu,$POST,$GET;
	
	function __construct($actionmenu=''){	
            
		   parent::__construct();
		   
	       $this->actionmenu=$actionmenu;
		   
		   $postkey=array('Submit'=>'','value'=>'','Add'=>'');
		   
		   $this->POST=$this->POSTArray();
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','action','value'));
		   
		         
	}
	
	function DefaultAction(){
		
		  return $this->SkillsListAction();
	}
	
	
	function SkillsListAction(){
		  
		  
		  $appid=empty($this->GET['value'])? $this->POST['value'] : $this->GET['value']; 
		  
		  
		  if(!empty($this->POST['Displayorder'])){
			  
			   if($_POST['setdisplayorder']){
				     
					 foreach($_POST['setdisplayorder'] as $key=>$value){
						 
						     $sid=intval($key);
							 $value=intval($value);
							 
							 $this->Update('skills',array('displayorder'=>$value),array()," WHERE sid='$sid'");
	
					 }
					 
					 $refresh= $this->LanguageArray('phpapp','Edited_successfully');
					  
					 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						
					 exit();
				   
			   }
			  
			  
			  
		  }elseif(!empty($this->POST['Submit'])){
               
			   $ids=$this->GetCheckBox($this->POST['checkbox']);
			   
			   if($this->Delete('skills'," WHERE sid IN($ids)")){
			  
			        $refresh= $this->LanguageArray('phpapp','Delete_successfully');

			   }else{
				    $refresh= $this->LanguageArray('phpapp','Delete_failed');

			   }
			   
			   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			  
		  
		  }else{
				
				
				//select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){

					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(
															
														'name'=>array('name','search'), 
														'sid'=>array('sid','int')
															  
												      ) 
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }
			   
			  //select end----------------------------------------------------
				
 
				 include_once(Core.'/class/pages_class_phpapp.php');
			  
				 $orderarr=array(
								 
						  array('order'=>'sid','name'=>'ID'),
						  array('order'=>'name','name'=>'排序/名称'),
						  array('order'=>'route','name'=>'路径'),
						  array('order'=>'title','name'=>'Title'),
						  array('order'=>'total','name'=>'数据关联'),
						  array('order'=>'displayorder','name'=>'排序')
						  );
		  
				 $order='ORDER BY displayorder ASC';
		  
				 $this->GET['iforder']=empty($this->GET['iforder']) ? 2 : $this->GET['iforder'];

				 if($this->GET['iforder']==1){
					  $sqlorder=' ASC';
					  $iforder=2;
				 }else{
					  $sqlorder=' DESC';
					  $iforder=1;
				 }
		  
				 foreach($orderarr as $key=>$value){
					   if($this->GET['sqlorder']==$key){
							 $order='ORDER BY '.$value['order'].$sqlorder;
					   }
				 }
		 

				 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM ".$this->GetTable('skills')."  $wheresql $order");

				 $list=$ajaxpage->ShowResult();

		         include $this->Template('show_manage');
		  }
	}
    
	function AddSkillsAction(){
		 	 	 	
		    
		  if(!empty($this->POST['Add'])){
			  
			     if($_POST['addskills']){

					  foreach($_POST['addskills'] as $key=>$value){

						   if($value['name']){
							   $route=$this->str($value['route'],100,0,0,1,0,0,1);
							   $name=$this->str($value['name'],100,0,0,1,0,0,1);
							   $title=$this->str($value['title'],200,0,0,1,0,0,1);
							   $keywords=$this->str($value['keywords'],250,0,0,1,0,0,1);
							   $description=$this->str($value['description'],300,0,0,1,0,0,1);
							   $displayorder=intval($value['displayorder']);
							   $this->Insert('skills',array('name'=>$name,'route'=>$route,'displayorder'=>$displayorder,'title'=>$title,'keywords'=>$keywords,'description'=>$description),array());
						   }

					  }
					
				 }
				
				 $refresh= $this->LanguageArray('phpapp','Add_success');
				
				echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					
				exit();
				
		  }else{
					include $this->Template('add_manage');
		
		  }
		
	} 
	
	function EditSkillsAction(){

          $sid=empty($this->GET['id'])? 0 : $this->GET['id']; 
		   
		  if($this->POST['Submit']){
				
				if($sid>0){
					
					  $this->Update('skills',$this->POST,array()," WHERE sid='$sid'");
					  
					  $refresh=$this->LanguageArray('phpapp','Edited_successfully');
					  
					  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						
					  exit();
					  
				}
			  
		  }else{
			  
				if($sid>0){
					 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('skills')." WHERE sid='$sid'");
				}else{
					 $manage='';
				}
				
				
				include $this->Template('edit_manage');
		  }
	  
	
	 }
	
	
}


?>