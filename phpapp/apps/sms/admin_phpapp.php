<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class SMSManageControls extends PHPAPP{
	
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
		
		  return $this->SMSListAction();
	}
	
	
	function SMSListAction(){
        
		  if(!empty($this->POST['Submit'])){
			  
			     $ids=$this->GetCheckBox($this->POST['checkbox']);

				 if($this->Delete('member_message_type'," WHERE mid IN($ids)")){
				
					  $refresh= '<p>删除消息配置成功！</p>';
				 
				 }else{
					 
					  $refresh= '<p>删除消息配置失败！</p>';	   
				 }
			  
			     echo $this->Refresh($refresh,$this->MakeGetParameterURL());
		  
		  }else{
			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		  
		         $orderarr=array(
						  array('order'=>'mid','name'=>'ID'),
						  array('order'=>'subject','name'=>'名称'),
						  array('order'=>'displayorder','name'=>'排序'),
						  array('order'=>'satus','name'=>'状态')
						  );
          
		         $order='ORDER BY displayorder DESC';
		  
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
		 
		  
		         $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM ".$this->GetTable('member_message_type')."  $order");

                 $list=$ajaxpage->ShowResult();

		         include $this->Template('show_manage');
		  }
	}
	
	function AddSMSAction(){
		

		 if(!empty($this->POST['Submit'])) {
	
	
				$newid=$this->Insert('member_message_type',$this->POST,array());
		
				if($newid>0){
					 $refresh= '<p>添加消息配置成功！</p>';
					 
					 
				}else{
					
					 $refresh=  '<p>添加消息配置失败！</p>';

				}
				
				echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			
			
		 }else{
			   
		        include $this->Template('add_manage');
		 }
		 
		 
		
	}
	
	
	function EditSMSAction(){
		 
		 $id=$this->GET['id'];
		 
		 if(!empty($this->POST['Submit'])) {
			  
				 $yes=$this->Update('member_message_type',$this->POST,array(),"WHERE mid='$id'");
		   
				 if($yes){
				
						echo $this->Refresh('<p>修改应用消息配置成功！</p>',$this->MakeGetParameterURL());
						
				 }else{
					 
						echo $this->Refresh('<p>修改应用消息配置失败！</p>',$this->MakeGetParameterURL());
						
				 }
			
		 }else{
	
		 		 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('member_message_type')." WHERE mid='$id'");
		
				 include $this->Template('add_manage');
		 }
	}
	

}


?>