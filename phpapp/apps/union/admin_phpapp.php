<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class UnionManageControls extends PHPAPP{
	
    public $actionmenu,$POST,$GET;
	
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
		
		  return $this->UnionListAction();
	}
	
	
	function UnionListAction(){
		
		   
		  if(!empty($this->POST['Submit'])){
               
			   $ids=$this->GetCheckBox($this->POST['checkbox']);
			   
			   if($this->Delete('union'," WHERE id_phpapp IN($ids)")){
			  
			         $refresh= $this->LanguageArray('phpapp','Delete_successfully');
					
			   }else{
				    
					 $refresh= $this->LanguageArray('phpapp','Delete_failed');
			   }
			  
			   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
		  
		  }else{
			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		  
		         $orderarr=array(
						  array('order'=>'a.id_phpapp','name'=>'ID'),
						  array('order'=>'b.groupname','name'=>'用户组'),
						  array('order'=>'c.subject','name'=>'道具名称'),
						  array('order'=>'a.rebate_phpapp','name'=>'提成'),
						  array('order'=>'a.status_phpapp','name'=>'状态')
						  );
          
		         $order='ORDER BY a.id_phpapp DESC';
		  
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
		 

		         $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.groupname,c.subject FROM  (".$this->GetTable('union')." AS a  LEFT JOIN  ".$this->GetTable('prop')." AS c ON c.sid=a.service_phpapp) LEFT JOIN ".$this->GetTable('usergroup')." AS b ON c.usergroup=b.gid $order");

                 $list=$ajaxpage->ShowResult();
   
		  
		         include $this->Template('show_manage');
		  }
	}
	
	
	function AddUnionAction() {
		
		 
		  if($this->POST['Submit']){
				
				  $this->Insert('union',$this->POST,array()); 
				
				  echo $this->Refresh($this->LanguageArray('phpapp','Add_success'),$this->MakeGetParameterURL());
					
				  exit();

		  }else{
			  
			     $usergrouparray=$this->GetMysqlArray('*'," ".$this->GetTable('usergroup')." ");
				 
				 $proparray=$this->GetMysqlArray('a.*,b.groupname'," ".$this->GetTable('prop')." AS a LEFT JOIN ".$this->GetTable('usergroup')." AS b ON a.usergroup=b.gid ");
			  
			     include $this->Template('add_manage');
			  
		  }
				  
				  
		 
		
	}
	
	function EditUnionAction(){
		
		  $id=$this->GET['id'];
				
		  $usergrouparray=$this->GetMysqlArray('*'," ".$this->GetTable('usergroup')." ");
		  

		  if($this->POST['Submit']){
				
				if($id>0){
					 
					  $this->Update('union',$this->POST,array()," WHERE id_phpapp='$id'");
					  
					  echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
						
					  exit();
					  
				}
			  
		  }else{
				if($id>0){
					 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('union')." WHERE id_phpapp='$id'");
					 
					 $prop=$this->GetMysqlOne('a.subject,a.price,b.groupname'," ".$this->GetTable('prop')." AS a LEFT JOIN ".$this->GetTable('usergroup')." AS b ON a.usergroup=b.gid WHERE a.sid='$manage[service_phpapp]'");
				}else{
					 $manage='';
				}
		  }
				  
				  
		  include $this->Template('add_manage');
	
	}
	
	function ConfigAction(){
		
		
		   if($this->POST['Submit']){
				
				  $this->SetConfig($this->POST);
				
		   }else{
				
		          include $this->Template('config_manage');
		   }
		
	}
	
	
}


?>