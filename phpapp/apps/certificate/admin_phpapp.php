<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class CertificateManageControls extends PHPAPP{
	
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
		
		  return $this->CertificateListAction();
	}
	
	
	function CertificateListAction(){
		
		   
		  if(!empty($this->POST['Submit'])){
			  
			   $ids=$this->GetCheckBox($this->POST['checkbox']);

			   if($this->Delete('certificate'," WHERE id_phpapp IN($ids)")){
			  
			        $refresh= $this->LanguageArray('phpapp','Delete_successfully');
							 
			   }else{
				   
				    $refresh= $this->LanguageArray('phpapp','Delete_failed');
							 
			   }
			   
			   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			  
		  
		  }else{
			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		  
		         $orderarr=array(
						  array('order'=>'a.id_phpapp','name'=>'ID'),
						  array('order'=>'a.app_phpapp','name'=>'应用ID'),
						  array('order'=>'a.table_phpapp','name'=>'使用表名'),
						  array('order'=>'a.name_phpapp','name'=>'名称'),
						  array('order'=>'a.type_phpapp','name'=>'用户类型'),
						  array('order'=>'a.icon_small_phpapp','name'=>'小图标'),
						  array('order'=>'a.icon_middle_phpapp','name'=>'中图标'),
						  array('order'=>'a.price_phpapp','name'=>'认证费用'),
						  array('order'=>'a.time_phpapp','name'=>'处理时间'),
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
		 
		         $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.name_phpapp AS typename FROM  ".$this->GetTable('certificate')." AS a LEFT JOIN ".$this->GetTable('member_type')." AS b ON a.type_phpapp=b.id_phpapp $order");

                 $list=$ajaxpage->ShowResult();
   
		  
		         include $this->Template('show_manage');
		  }
	}
	
	function EditCertificateAction(){
		
		  $id=$this->GET['id'];
				
		  $membertype=$this->GetMysqlArray('*'," ".$this->GetTable('member_type')." ");
				
		  if($this->POST['Submit']){
				
				if($id>0){
					 
					  $this->Update('certificate',$this->POST,array()," WHERE id_phpapp='$id'");
					  
					  echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
						
					  exit();
					  
				}
			  
		  }else{
				if($id>0){
					 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('certificate')." WHERE id_phpapp='$id'");
				}else{
					 $manage='';
				}
		  }
				  
				  
		  include $this->Template('add_manage');
	
	}
	
	
}


?>