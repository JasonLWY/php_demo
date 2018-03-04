<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class PayManageControls extends PHPAPP{
	
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
		
		  return $this->PayToosListAction();
	}
	
	
	function PayToosListAction(){
		
        
		  if(!empty($this->POST['Submit'])){
			  
			   $ids=$this->GetCheckBox($this->POST['checkbox']);

			   if($this->Delete('pay_tool'," WHERE id_phpapp IN($ids)")){
			  
			        $refresh= $this->LanguageArray('phpapp','Delete_successfully');

			   
			   }else{
				    $refresh= $this->LanguageArray('phpapp','Delete_failed');

			   }
			   
			   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			  
		  
		  }else{
			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		  
		         $orderarr=array(
						  array('order'=>'id_phpapp','name'=>'应用ID'),
						  array('order'=>'name_phpapp','name'=>'接口名称'),
						  array('order'=>'logo_phpapp','name'=>'LOGO'),
						  array('order'=>'displayorder_phpapp','name'=>'排序'),
						  array('order'=>'status_phpapp','name'=>'状态')
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
		 
		         $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM  ".$this->GetTable('pay_tool')." $order");

                 $list=$ajaxpage->ShowResult();
   
		  
		         include $this->Template('show_manage');
		  }
	}
	
	function EditPayToolAction(){
		
		  $id=$this->GET['id'];
				  
		  if($this->POST['Submit']){
				
				if($id>0){
					 
					  $this->Update('pay_tool',$this->POST,array()," WHERE id_phpapp='$id'");
					  
					  echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
						
					  exit();
					  
				}
			  
		  }else{
				if($id>0){
					 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('pay_tool')." WHERE id_phpapp='$id'");
				}else{
					 $manage='';
				}
		  }
				  
				  
		  include $this->Template('add_manage');
	
	}
	
    function AddAction(){
		   
		   if($this->POST['Submit']){
			   
	             $this->Insert('pay_tool',$this->POST,array());

				 echo $this->Refresh($this->LanguageArray('phpapp','Add_success'),$this->MakeGetParameterURL());
				 	
				 exit();
				 
		   }else{
			     
				 $appsarr=$this->GetMysqlArray('id_phpapp,name_phpapp'," ".$this->GetTable('apps')." WHERE id_phpapp>50");
		   
		         include $this->Template('add_manage');
		   
		   }
		
	}	
}


?>