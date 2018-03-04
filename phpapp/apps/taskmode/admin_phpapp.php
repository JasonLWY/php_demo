<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(APPS.'/taskmode/public_phpapp.php');
 
include_once(Core.'/class/admin_class_phpapp.php');

require_once(APPS.'/apppay/class/process_class_phpapp.php');

//Manage
class TaskModeManageControls extends TaskPublicClass{
	
    private $actionmenu;
	
	public $app,$lang;
	
	function __construct($actionmenu=''){	 
         
		 global $appclass;
		 
		 parent::__construct();
		 
		 $this->actionmenu=$actionmenu;
		 
		 $postkey=array('Submit'=>'','checkbox'=>'');
		
		 $this->POST=$this->POSTArray();
		 
		 foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		 }
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id'));

	}
	
	//Default
	public function DefaultAction(){
		
		  return $this->TaskRefundAction();
		
	}
	
	
	public function TaskRefundAction(){
		       
			   //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(
															
														'rid'=>array('a.rid','int'),
														'tid'=>array('a.tid','int'),
														'uid'=>array('b.uid','int'),
														'username'=>array('b.username','string'),
														'dateline1'=>array('a.dateline','time'),
														'dateline2'=>array('a.dateline','time')
															  
												      ) 
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }
			   
			  
			   //select end----------------------------------------------------
			   
			   if(!empty($this->POST['Refuse'])){
				      
					  $ids=$this->GetCheckBox($this->POST['checkbox']);
					  
					  $this->Update('task_refund',array('status'=>3),array(),"WHERE rid IN($ids)");
					  
					  $taskkarray=$this->GetMysqlArray('b.uid,b.tid,b.subject,b.url'," ".$this->GetTable('task_refund')." AS a LEFT JOIN ".$this->GetTable('task')." AS b ON a.tid=b.tid WHERE a.rid IN($ids)");
			   
					  if($taskkarray){
					       
						   
							 foreach($taskkarray as $value){
					 
								   $this->Port(array(
												  
												  //SMS
												  'receive_uid'=>$value['uid'], //收件人
												  'sms_subject'=>$value['tid'].'任务申请退款失败!',
												  'sms_content'=>'尊敬的用户!您申请的 <a href="'.SURL.$value['url'].'" target="_blank">'.$value['subject'].'</a> 任务退款失败!有其它问题请与客服沟通,谢谢支持！',
												  
												  //EMail
												  'email_title'=>$value['tid'].'任务申请退款失败!',
												  'email_content'=>'尊敬的用户!您申请的 <a href="'.SURL.$value['url'].'" target="_blank">'.$value['subject'].'</a> 任务退款失败!有其它问题请与客服沟通,谢谢支持！',
												  
												   //Mobile
											       'mobile_content'=>$value['tid'].'号任务退款成功!'
												  
												  
								   ),19);
								   
							 }
								 
					  }
					  
				   
				      $refresh= '<p>拒绝成功！</p>';
								 
				      echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				   
			   
			   }elseif(!empty($this->POST['Agree'])){
				     
					 $ids=$this->GetCheckBox($this->POST['checkbox']);
					 
                     include_once(APPS.'/apppay/class/consume_class_phpapp.php');
			  
					 $pay=new UserConsume();
					 
					 $this->Update('task_refund',array('status'=>2),array(),"WHERE rid IN($ids)");
					 
					 $taskarray=$this->GetMysqlArray('b.*'," ".$this->GetTable('task_refund')." AS a LEFT JOIN ".$this->GetTable('task')." AS b ON a.tid=b.tid WHERE a.rid IN($ids)");
					 
					 if($taskarray){
						 
						   foreach($taskarray as $task){
								 $this->TaskRefund($pay,$task);
						   }
					 }
					 
			         $refresh= '<p>退款成功！</p>';
								 
				     echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			   
				 
			   }elseif(!empty($this->POST['Delete'])){
				    
				   $ids=$this->GetCheckBox($this->POST['checkbox']);
	
				   if($this->Delete('task_refund'," WHERE rid IN($ids)")){
				  
						$refresh=$this->LanguageArray('phpapp','Delete_successfully');
				   
				   }else{
						$refresh=$this->LanguageArray('phpapp','Delete_failed');
		
				   }
				   
				   echo $this->Refresh($refresh,$this->MakeGetParameterURL());

			  
			  }else{
				  
					 include_once(Core.'/class/pages_class_phpapp.php');
			  
					 $orderarr=array(
							  array('order'=>'a.rid','name'=>'ID'),
							  array('order'=>'a.uid','name'=>'发布者UID'),
							  array('order'=>'b.username','name'=>'发布者'),
							  array('order'=>'c.money','name'=>'赏金'),
							  array('order'=>'c.subject','name'=>'任务标题'),
							  array('order'=>'a.content','name'=>'退款理由'),
							  array('order'=>'c.process','name'=>'流程'),
							  array('order'=>'a.status','name'=>'退款状态'),
							  array('order'=>'a.dateline','name'=>'申请时间')
							  );
			  
					 $order='ORDER BY a.tid DESC';
			  
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
			 
	
					 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.username,c.subject,c.money,c.serviceuid,c.process,c.endtime,c.dateline,c.url,c.appid FROM  (".$this->GetTable('task_refund')." AS a LEFT JOIN  ".$this->GetTable('member')." AS b ON a.uid=b.uid) LEFT JOIN ".$this->GetTable('task')." AS c ON a.tid=c.tid $wheresql $order");
	
					 $list=$ajaxpage->ShowResult();
                     
					 $getprocess=new TaskProcess();
		  
		             include $this->Template('taskrefund_manage');
					 
			  }

		   
	}
	
	
	public function TaskConfigAction(){
		
		    if($this->POST['Submit']){
				
				   $this->SetConfig($this->POST);
				
			}else{


		          include $this->Template('config_manage');
			}
		
	}
	
}

?>