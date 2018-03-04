<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class SNSIDManageControls extends PHPAPP{
	
    private $actionmenu,$POST,$GET;
	
	function __construct($actionmenu=''){	
	
           parent::__construct();
		   
	       $this->actionmenu=$actionmenu;
		   
		   $postkey=array('Submit'=>'','checkbox'=>'');
		   
		   $this->POST=$this->POSTArray();
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','action'));
		         
	}
	
	function DefaultAction(){
		
		  return $this->SNSPortListAction();
	}
	
	
	function SNSPortListAction(){
		

		  if(!empty($this->POST['Submit'])){

               $ids=$this->GetCheckBox($this->POST['checkbox']);
 
			   if($this->Delete('sns'," WHERE id_phpapp IN($ids)")){
			  
			        $refresh= $this->LanguageArray('phpapp','Delete_successfully');
	
			   }else{
				    $refresh= $this->LanguageArray('phpapp','Delete_failed');

			   }
			   
			   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			  
		  
		  }else{
			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		  
		         $orderarr=array(
						  array('order'=>'id_phpapp','name'=>'ID'),
						  array('order'=>'app_phpapp','name'=>'应用ID'),
						  array('order'=>'name_phpapp','name'=>'名称'),
						  array('order'=>'icon_small_phpapp','name'=>'小图标'),
						  array('order'=>'icon_middle_phpapp','name'=>'中图标'),
						  array('order'=>'description_phpapp','name'=>'介绍'),
						  array('order'=>'status_phpapp','name'=>'状态')
						  );
          
		         $order='ORDER BY id_phpapp DESC';
		  
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
		 

		         $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM  ".$this->GetTable('sns')."  $order");

                 $list=$ajaxpage->ShowResult();
   
		  
		         include $this->Template('show_manage');
		  }
	}
	
	function EditSNSPortAction(){
		
		  $id=$this->GET['id'];
				
		  $membertype=$this->GetMysqlArray('*'," ".$this->GetTable('member_type')." ");
				
		  if($this->POST['Submit']){
				
				if($id>0){
					 
					  $this->Update('sns',$this->POST,array()," WHERE id_phpapp='$id'");
					  
					  echo $this->Refresh($this->LanguageArray('phpapp','Add_success'),$this->MakeGetParameterURL());
						
					  exit();
					  
				}
			  
		  }else{
				if($id>0){
					 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('sns')." WHERE id_phpapp='$id'");
				}else{
					 $manage='';
				}
		  }
				  
				  
		  include $this->Template('add_manage');
	
	}
	
	
}


?>