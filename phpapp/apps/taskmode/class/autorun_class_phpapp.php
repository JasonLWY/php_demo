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

class TaskModeAutoControls extends TaskPublicClass{
	
	private $post,$allow,$senddata,$receiveuid;
	
	function __construct($senddata=array()){	 
	 
		 $this->senddata=$senddata;
		 
		 $this->allow=$this->senddata['allow'];
		 
		 $this->post=unserialize($this->senddata['zipcode']);
		 
		 $this->receiveuid=intval($this->post['receive_uid']);       
	}
	
	
	function SendMessageCode(){ 
          
		  $userinfo=$this->GetLoginInfo($this->receiveuid);
						  
		  if($this->UserIsPort('notice')){
				//SMS
			    $this->Insert('member_notice',array(
											   'uid'=>$this->receiveuid, //收件人
											   'new'=>1, 
											   'subject'=>$this->str($this->post['sms_subject'],200,1,0,1,0,1),
											   'content'=>$this->post['sms_content'],
											   'cid'=>intval($this->post['sms_cid']),
											   'dateline'=>$this->NowTime()
											   ),
				array());  

		  }

		  
		  if($this->UserIsPort('phone')){ 
			      //Mobile
				  if($this->IsSQL('member_mobile_certificate',"  WHERE uid='$this->receiveuid' AND status='5' ")){

						  @require_once(Core.'/class/sms_class_phpapp.php');
				  
						  $mobile=new MobileSMS();
						 
						  @$mobile->SendSMS($userinfo['mobile'],$this->post['mobile_content']);
				   
				  }

		  }

          
		  if($this->UserIsPort('email')){ 
				  //EMAIL
				  if($this->IsSQL('member_mail_certificate',"  WHERE uid='$this->receiveuid' AND status='5' ")){
			
						 @$this->SendMail($userinfo['safeemail'],$this->post['email_title'],$this->post['email_content']);
				   
				  }
				
		  }
		  
		  
		  
		  

	}
	
	
	function UserIsPort($porttype=''){

		   $setarr=$this->GetMysqlOne('setkey'," ".$this->GetTable('member_message_set')." WHERE uid='$this->receiveuid' ");  
		   if($setarr){
			     $setkeyarr=unserialize($setarr['setkey']);
				 
				 if($porttype=='notice'){
					 if($setkeyarr['notice'][$this->allow]){
						  return true;
					 }else{
						  return false;
					 }
				 }
				 
				 if($porttype=='phone'){
					 if($setkeyarr['phone'][$this->allow]){
						  return true;
					 }else{
						  return false;
					 }
				 }
				 
				 if($porttype=='email'){
					 if($setkeyarr['email'][$this->allow]){
						  return true;
					 }else{
						  return false;
					 }
				 }
				 
		   }else{
			     return false;
		   }
	}
	
	
	function AutoEvaluate(){
		    
			$cid=intval($this->senddata['cid']);
			
		    if($this->IsSQL('consume',"WHERE cid='$cid' AND process=5")){
				   
				   $task=$this->GetMysqlOne('a.tid,a.uid,b.oid,b.did'," ".$this->GetTable('task')." AS a LEFT JOIN ".$this->GetTable('task_order')." AS b ON a.tid=b.tid  WHERE b.cid='$cid'");
				   $draft=$this->GetMysqlOne('uid'," ".$this->GetTable('task_draft')." WHERE did='$task[did]'");
					
				   if(!$this->IsSQL('task_order',"WHERE cid='$cid' AND seller=1")){
					   
						   
						   $this->Update('task_order',array('seller'=>1),array(),"WHERE cid='$cid'");

						   $this->Insert('task_order_credit',array('tid'=>$task['tid'],'uid'=>$draft['uid'],'cid'=>$cid,'level'=>0,'type'=>1,'dateline'=>$this->NowTime(),'auto'=>1),array());
						   
				   }
				   
				   //买家
				   if(!$this->IsSQL('task_order',"WHERE cid='$cid' AND buyer=1")){
					   
						   
						   $this->Update('task_order',array('buyer'=>1),array(),"WHERE cid='$cid'");

						   $this->Insert('task_order_credit',array('tid'=>$task['tid'],'uid'=>$task['uid'],'cid'=>$cid,'level'=>0,'type'=>2,'dateline'=>$this->NowTime(),'auto'=>1),array());
						   
				   }
				   
				   
				   if(PHPAPP::$config['auto_delete_order_notice']){
						  $this->Delete('member_notice'," WHERE cid='$cid' ");
				   }
				   
				   require_once(APPS.'/order/member_phpapp.php');
				   
				   $order=new OrderMemberControls();
				   
				   $order->TaskCredit($cid);
										   
		    }
	}
	
	function PayTask(){
          
		  require_once(APPS.'/order/member_phpapp.php');
		  
		  $order=new OrderMemberControls();
		  $order->PayTaskOrder(intval($this->senddata['cid']),0);
		
	}
	
	function CloseOrder(){
	      
		  //关订单
		  $cid=intval($this->senddata['cid']);
		  if($this->IsSQL('consume',"WHERE cid='$cid' AND process<3 ")){	 
		          
				  if($this->IsSQL('consume',"WHERE cid='$cid' AND process=1 ")){	 
		  		  		$this->Update('consume',array('process'=>6),array()," WHERE  cid='$cid' ");
				  }
				  
				  //关中标
				  $did=intval($this->senddata['did']);
				  if($did>0){
						$this->Update('task_draft',array('process'=>2,'money'=>0),array(),"WHERE did='$did'");
				  }
				  
				  
				  if($this->IsSQL('consume',"WHERE cid='$cid' AND process=2 ")){	 
		                      
							  $this->Update('consume',array('process'=>6),array()," WHERE  cid='$cid' ");
							  
							  //更新任务中标
							  $tid=intval($this->senddata['tid']);
		
							  if($tid>0){
								  $successnum=$this->IsSQL('task_draft',"WHERE process=1 AND tid='$tid'");				 
								  $this->Update('task',array('draft_success'=>$successnum),array(),"WHERE tid='$tid'");
					
								  //返还
								  $task=$this->GetMysqlOne('uid,process,appid'," ".$this->GetTable('task')." WHERE tid='$tid'");
								  $consume=$this->GetMysqlOne('amount,fee'," ".$this->GetTable('consume')." WHERE cid='$cid'");
								  
								  $money=$consume['amount']+$consume['fee'];
								  
								  $oid=intval($this->senddata['oid']);

								  //任务已关闭
								  $isrefund=0;
								  
								  if($task['appid']==83){
									    $isrefund=1;
								  }elseif($task['process']>7 && $money>0 && $oid>0){
									    $isrefund=1;
								  }
								  
								  
								  if($isrefund>0){
									  
										  include_once(APPS.'/apppay/class/consume_class_phpapp.php');
										
										  $pay=new UserConsume();
										  
										  $newcid=$pay->MakeConsume(array(
																  'subject'=>'<p>退订单担保金</p>'.$oid.'号订单',  
																  'appid'=>$this->app, 
																  'paytype'=>1, 
																  'process'=>1, 
																  'amount'=>$money, 
																  'payout'=>0, 
																  'payin'=>$task['uid']
																  
															));
										  
										  
										  
										  $pay->SetSuccessConsume($newcid); 
										  
								 
										   //通知
										   $send_subject=$oid.' 号订单卖家威客未完成任务系统退款!';
										   $send_content='卖家威客在规定的时间内未能完成任务交接,系统自动退款 '.$money.' 元! <a href="'.SURL.'/member.php?app=48&action=2&oid='.$oid.'" target="_blank">[查看详细]</a>';
							
										   //接口
										   $this->Port(array(
												 
												  'receive_uid'=>$task['uid'], //接收人
												  //SMS
												  'sms_subject'=>$send_subject,
												  'sms_content'=>$send_content,
																
												  //EMail
												  'email_title'=>$send_subject,
												  'email_content'=>$send_content,
												  
												  //Mobile
												  'mobile_content'=>$send_subject
													
															
										   ),19);
								  }
				  
				            }
							
				  }
		  }
		  
	}
	
	
	function RefundOrder(){
		
		  require_once(APPS.'/order/member_phpapp.php');
		  
		  $order=new OrderMemberControls();
		  $order->PayTaskOrder(intval($this->senddata['cid']),1);
	}

}

?>