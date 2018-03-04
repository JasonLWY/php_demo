<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

require_once(APPS.'/apppay/class/process_class_phpapp.php');

require_once(APPS.'/apppay/class/consume_class_phpapp.php');

//Order
class OrderMemberControls extends PHPAPP{
	
	
	function __construct(){	 
	 
		 parent::__construct();
           
	     $this->POST=$this->POSTArray();
		 
		 $postkey=array('Submit'=>'');
	   
	     $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','total','id','op','item','sort','more','tab','did','select'));
	   
	     foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
	     }
		   
		 if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
		 
	}
	
	
	public function DefaultAction(){
		
		  return $this->SellerListOrderAction();
		
	}
	
	//订单
	public function SellerListOrderAction(){
	
		    //威客
			$this->SellerListOrder();
		 
	}
	
	public function BuyerListOrderAction(){
		
	       //雇主
	       $this->BuyerListOrder();
	
	}
	
	public function SellerOrderAction(){
		
		   //威客
		   $this->SellerOrder();
	}
	
	public function  BuyerOrderAction(){
		
	       //雇主
		   $this->BuyerOrder();
	}
				
	
	public function BuyerOrder($oid=0,$adminmanage=0){
		
		   if(!$oid){
			    $oid=$this->GET['oid'];
		   } 
		   
		   if($adminmanage){
			    $wheresql='';
		   }else{
			    $wheresql=" AND b.uid='$this->uid' ";
		   }
		   
		   $draftorder=$this->GetMysqlOne('a.*,a.content AS ocontent,b.money AS bidmoney,b.*,c.process,c.amount,c.fee,c.refundmoney'," (".$this->GetTable('task_order')." AS a LEFT JOIN  ".$this->GetTable('consume')." AS c ON c.cid=a.cid ) LEFT JOIN ".$this->GetTable('task')." AS b ON a.tid=b.tid WHERE a.oid='$oid' $wheresql ");
		   
		   if($draftorder){
				 
				 $did=$draftorder['did'];
				 
				  //稿件显示
				 $draft=$this->GetMysqlOne('a.*,b.username,b.usertype,b.email,c.*'," (".$this->GetTable('task_draft')." AS a LEFT JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid  )LEFT JOIN ".$this->GetTable('member_info')." AS c ON a.uid=c.uid   WHERE a.did='$did'");

				 //评价
				 $credit=$this->GetMysqlOne('level,content,dateline,auto'," ".$this->GetTable('task_order_credit')." WHERE cid='$draftorder[cid]' AND type=1");
				 
                 //发票
				 $invoice=$this->GetMysqlOne('*'," ".$this->GetTable('task_order_invoice')." WHERE oid='$draftorder[oid]' ");


				 $getprocess=new TaskProcess();
				 
				 
				 include $this->Template('buyer_order_member');
			   
		   }else{
			     if($adminmanage){
					   $this->Refresh('对不起!订单不存在!',$this->MakeGetParameterURL(array('action'=>1)));
				 }else{
				 	   $this->Refresh('对不起!订单不存在!',SURL.'/member.php?app=48&action=1');
				 }
			   
		   }	   		   
		   
	}
						  
						  
	
	public function SellerOrder($oid=0,$adminmanage=0){

		   if(!$oid){
			    $oid=$this->GET['oid'];
		   } 
		   
		   if($adminmanage){
			    $wheresql='';
		   }else{
			    $wheresql=" AND a.selleruid='$this->uid' ";
		   }
				   
		   $draftorder=$this->GetMysqlOne('a.*,b.tid,c.process,c.amount,c.fee,c.refundmoney,b.money AS bidmoney'," (".$this->GetTable('task_order')." AS a LEFT JOIN  ".$this->GetTable('consume')." AS c ON c.cid=a.cid ) LEFT JOIN ".$this->GetTable('task')." AS b ON a.tid=b.tid WHERE a.oid='$oid' $wheresql");
		   
		   
		   if($draftorder){
				 
				  
				 $did=$draftorder['did'];
				 
				 $draft=$this->GetMysqlOne('a.*,b.username,b.usertype,b.email,c.*'," (".$this->GetTable('task_draft')." AS a LEFT JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid  )LEFT JOIN ".$this->GetTable('member_info')." AS c ON a.uid=c.uid   WHERE a.did='$did'");

				 //稿件显示
				 
				 $tid=$draftorder['tid'];
				 
				 $task=$this->GetMysqlOne('a.*,b.username'," ".$this->GetTable('task')." AS a LEFT JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid WHERE tid='$tid'");

				 //评价
				 $credit=$this->GetMysqlOne('level,content,dateline,auto'," ".$this->GetTable('task_order_credit')." WHERE cid='$draftorder[cid]' AND type=1");
				 
				  //发票
				 $invoice=$this->GetMysqlOne('*'," ".$this->GetTable('task_order_invoice')." WHERE oid='$draftorder[oid]'");
				 
                 
				 $files=$this->FileList($draftorder['oid'],3);
				  
				  
				 $getprocess=new TaskProcess();
				 
				 include $this->Template('seller_order_member');
			   
		   }else{
			     
				 if($adminmanage){
					   $this->Refresh('对不起!订单不存在!',$this->MakeGetParameterURL(array('action'=>1)));
				 }else{
				 	   $this->Refresh('对不起!订单不存在!',SURL.'/member.php?app=48&action=1');
				 }
			   
		   }
	   
		  
	}
	
	public function BuyerListOrder(){
		

			if(!empty($this->POST['oderid'])){	
			
					$oderid=$this->ExplodeStrArr($this->POST['oderid']);		   
					$idarray=explode(',',$oderid);
			}
		   
		    if($this->GET['op']==5){
				
				  if($this->IsSQL('consume',"WHERE cid='$oderid' AND process=1")){
					     
						$pay=new UserConsume();
						
						$pay->CloseConsume($oderid);
						
						//通知---------------
						$draft=$this->GetMysqlOne('a.tid,a.uid,b.oid'," ".$this->GetTable('task_draft')." AS a LEFT JOIN ".$this->GetTable('task_order')." AS b ON a.did=b.did  WHERE b.cid='$oderid'");
						 
						$send_subject=include $this->LanguageArray('order','Order_Buyers_CloseOrder_Subject',1);
						
						$send_content=include $this->LanguageArray('order','Order_Buyers_CloseOrder_Content',1);
						
						if(PHPAPP::$config['auto_delete_order_notice']){
					          $this->Delete('member_notice'," WHERE cid='$oderid'");
					    }
						
						$this->Port(array(
											
								   //Login
								  'login_uid'=>$this->uid,
								
								  //Credit
								  'credit_uid'=>$this->uid,
									
								  
								  'receive_uid'=>$draft['uid'], //接收人
								  
								  //SMS
								  'sms_subject'=>$send_subject,
								  'sms_content'=>$send_content,
												
								  //EMail
								  'email_title'=>$send_subject,
								  'email_content'=>$send_content,
		
								  //Mobile
								  'mobile_content'=>$send_subject
									
											
						 ),9);
						
						 
						echo '关闭成功！';
						
				  }else{
					   
					    echo '当状态不能关闭！';
					  
				  }
				  
				  echo $this->CloseNowWindows('#loading',1);
				
			}elseif($this->GET['op']==4){
				
				 if($this->IsSQL('consume',"WHERE cid='$oderid' AND process!=6")){
					  $oid=intval($this->POST['oid']);
					  
					  $invoice=$this->str($this->POST['invoice'],200,1,0,1,0,1);
					  
					  $content=$this->str($this->POST['content'],500,1,0,1,0,1);
					  
					  $draft=$this->GetMysqlOne('a.tid,a.uid,b.oid'," ".$this->GetTable('task_draft')." AS a LEFT JOIN ".$this->GetTable('task_order')." AS b ON a.did=b.did  WHERE b.cid='$oderid'");
					  
					  
					  if($this->IsSQL('task_order_invoice',"WHERE oid='$oid' AND uid='$this->uid'")){
					  
						   $this->Update('task_order_invoice',array('invoice'=>$invoice,'content'=>$content),array(),"WHERE oid='$oid' AND uid='$this->uid'");
						   
						   $send_subject=include $this->LanguageArray('order','Order_Buyers_Invoice_Edit_Subject',1);
						   
						   echo '修改成功！';
					  }else{
												   
						   $this->Insert('task_order_invoice',array('oid'=>$oid,'invoice'=>$invoice,'content'=>$content,'uid'=>$this->uid),array());
						   
						   $send_subject=include $this->LanguageArray('order','Order_Buyers_Invoice_Subject',1);
						   
						  
						   echo '保存成功！';
					  }
					  
					  $send_content=include $this->LanguageArray('order','Order_Buyers_Invoice_Content',1);
					  
					  $this->Port(array(
											
								   //Login
								  'login_uid'=>$this->uid,
								
								  //Credit
								  'credit_uid'=>$this->uid,
									
								  
								  'receive_uid'=>$draft['uid'], //接收人
								  
								  //SMS
								  'sms_subject'=>$send_subject,
								  'sms_content'=>$send_content,
												
								  //EMail
								  'email_title'=>$send_subject,
								  'email_content'=>$send_content,
		
								  //Mobile
								  'mobile_content'=>$send_subject
									
											
						 ),9);
						
				 }else{
					   
					   echo '订单已关闭,不能操作！';
					 
				 }
												   
				  echo $this->CloseNowWindows('#loading');
				
			}elseif($this->GET['op']==3){
				 
                    $content=$this->str($this->POST['content'],100,1,0,0,0,1);
							 
					if($this->POST['oderid']){
						   
					
						   foreach($idarray as $value){
							   
							      $value=intval($value);
								   
	                              if($this->IsSQL('consume',"WHERE cid='$value' AND process=5")){
								   
									   if(!$this->IsSQL('task_order_credit',"WHERE cid='$value' AND type=2 AND uid='$this->uid'")){
										   
											  
											   $this->Update('task_order',array('buyer'=>1),array(),"WHERE cid='$value'");
											   
											   
											   $draft=$this->GetMysqlOne('a.tid,a.uid,b.oid'," ".$this->GetTable('task_draft')." AS a LEFT JOIN ".$this->GetTable('task_order')." AS b ON a.did=b.did  WHERE b.cid='$value'");
												
											   $this->Insert('task_order_credit',array('tid'=>$draft['tid'],'cid'=>$value,'level'=>$this->POST['level'],'type'=>2,'uid'=>$this->uid,'dateline'=>$this->NowTime(),'content'=>$content),array());
											   
											   
											   $this->CreditScore($draft['uid'],$draft['oid'],$this->POST);
											   
											   
											   $this->TaskCredit($value);
										       
											   
											   if(PHPAPP::$config['auto_delete_order_notice']){
													  $this->Delete('member_notice'," WHERE cid='$value' AND uid='$this->uid'");
											   }
																	  
											  //通知--------------------------------------------------------------
				   
											   $send_subject=include $this->LanguageArray('order','Order_Buyers_Evaluate_Subject',1);
											   $send_content=include $this->LanguageArray('order','Order_Buyers_Evaluate_Content',1);
							
											  //接口
											  $this->Port(array(
																
													  //Login
													  'login_uid'=>$this->uid,
													
													  //Credit
													  'credit_uid'=>$this->uid,
													  
													  'receive_uid'=>$draft['uid'], //接收人
													  
													  //SMS
													  'sms_subject'=>$send_subject,
													  'sms_content'=>$send_content,
													  'sms_cid'=>$value,
																	
													  //EMail
													  'email_title'=>$send_subject,
													  'email_content'=>$send_content,
							
													  //Mobile
													  'mobile_content'=>$send_subject
														
																
											  ),14);
											  
											  //通知 end--------------------------------------------------------------
										 
											   
											   
											  echo $value.'号订单评价成功!<br />';
									   }else{
											  echo $value.'号订单评价过了!<br />';
									   }	
									   
								   }else{
										  echo '当前状态不能评价！';
								   }	

						   }
				          
						   echo $this->CloseNowWindows('#loading',1);
				 
				   }
			}elseif($this->GET['op']==2){
				
					$cid=intval($this->POST['oderid']);
					$tid=intval($this->POST['tid']);
					
					$consume=$this->GetMysqlOne('*'," ".$this->GetTable('consume')." WHERE cid='$cid'");
					
					if($consume['cid']){
						     
						    if($this->IsSQL('consume',"WHERE cid='$cid' AND process>1")){
								   
								   echo '您已经支付过了！';
						           echo $this->CloseNowWindows('#loading');
								
							}else{
								
									$task=$this->GetMysqlOne('a.tid,a.appid,a.subject,a.money,b.runid,b.did,b.oid'," ".$this->GetTable('task')." AS a JOIN ".$this->GetTable('task_order')." AS b ON a.tid=b.tid  WHERE a.tid='$tid'");
									
									if($task['runid']>0){
										   $this->Delete('autorun'," WHERE aid='$task[runid]'");
									}
									   
									$user=$this->GetMysqlOne('money'," ".$this->GetTable('member_account')." WHERE uid='$this->uid'");
									
									$paymoney=$consume['amount']+$consume['fee']-$task['money'];
									
									if($user['money']>=($paymoney) && $task['tid']>0 && $task['did']>0){
										  
										  $pay=new UserConsume();
										  
										  //托管本站
										  //Create Consume
										  $newcid=$pay->MakeConsume(array(
												  'subject'=>'<p>托管支付</p>'.$task['subject'], 
												  'appid'=>$task['appid'], 
												  'paytype'=>1, 
												  'process'=>1, 
												  'amount'=>$paymoney,
												  'payout'=>$this->uid, 
												  'payin'=>0
										  ));
				
										  $pay->SetSuccessConsume($newcid); 
		
										  $this->Update('consume',array('process'=>2),array()," WHERE  cid='$cid' ");
										  
										  //关闭

										  $draft=$this->GetMysqlOne('uid,did,time'," ".$this->GetTable('task_draft')." WHERE did='$task[did]'");
										  
										  $draftime=$draft['time'];
										  if(!$draft['time']){
											   $draftime=1;
										  }
										  
										  $closetime=$this->NowTime()+($draft['time']*24*60*60);

										  include_once(Core.'/class/auto_class_phpapp.php');

										  $auto=new AUTO();
										  
										  $runid=$auto->SetAutoRun(array(
												'app'=>49,
												'runtime'=>$closetime,
												'function'=>'CloseOrder',
												'oid'=>$task['oid'],
												'cid'=>$cid,
												'did'=>$task['did'],
												'tid'=>$tid
										  ));
										  
										  $this->Update('task_order',array('closetime'=>$closetime,'workdate'=>$draft['time'],'runid'=>$runid),array(),"WHERE oid='$task[oid]'");
										  
									
										  
										  //交接通知-------------------------------------------------------------------------------------
						
										  require_once(APPS.'/apppay/class/process_class_phpapp.php');
										  $getprocess=new TaskProcess();
										  $send_op=include $this->LanguageArray('order','Order_Buyers_Waiting_For_Work',1);
										 
										  if(PHPAPP::$config['auto_delete_order_notice']){
												$this->Delete('member_notice'," WHERE cid='$cid'");
										  }
						
										  //接口
										  $this->Port(array(
															
												  
												  'receive_uid'=>$draft['uid'], //接收人
												  
												  //SMS
												  'sms_subject'=>$send_subject,
												  'sms_content'=>$send_content.$send_op,
												  'sms_cid'=>$cid,
																
												  //EMail
												  'email_title'=>$send_subject,
												  'email_content'=>$send_content,
						
												  //Mobile
												  'mobile_content'=>$send_subject
															
										   ),3);
										  
										  
										  	  
										  echo '支付'.$consume['serial'].'订单成功！';
										  
										  echo $this->CloseNowWindows('#loading',1);
									}else{
										
										  echo include $this->LanguageArray('order','Order_Buyers_NoMoney',1);
									}
									
							}
					
						  
					}else{
						
						  echo '对不起！订单不存在！';
						  echo $this->CloseNowWindows('#loading');
					}
					
					

			}elseif($this->GET['op']==1){
				
			
				
                    if($this->POST['oderid']){
						   
						   $pay=new UserConsume();

                           foreach($idarray as $value){
							   
							     $value=$this->str($value,22,1,0,1,0,1);
							   
	
							     if($this->IsSQL('consume',"WHERE cid='$value' AND process=3")){
									 
							           //额外奖励-----------------------------------------------------------
									   $consumeinfo=$this->GetMysqlOne('b.uid'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid  WHERE a.cid='$value' AND flow=1 ");
									   
									   $award=floatval($this->POST['award']);
									   
									   if($award>0 && $consumeinfo){
										   
										     //检查用户可用金额
							                 $user=$this->GetMysqlOne('money'," ".$this->GetTable('member_account')." WHERE uid='$this->uid'");
							 
							 
							                 if($user['money']>=($award)){
												 
												     
													 $orderarr=$this->GetMysqlOne('b.appid,a.tid,a.did,a.oid,b.url'," ".$this->GetTable('task_order')." AS a LEFT JOIN ".$this->GetTable('task')." AS b ON a.tid=b.tid WHERE a.cid='$value'");
								 
													 $newcid=$pay->MakeConsume(array(
															  'subject'=>'中标额外奖励',  
															  'appid'=>$orderarr['appid'], 
															  'paytype'=>1, 
															  'process'=>1, 
															  'amount'=>$award, 
															  'payout'=>$this->uid, 
															  'payin'=>$consumeinfo['uid']
															  
														));
	  
													 $pay->SetSuccessConsume($newcid); 
													 
													 
													 
													  //通知--------------------------------------------------------------
													 $send_subject=include $this->LanguageArray('order','Order_Buyers_Reward_Subject',1);
													 
													 $send_content=include $this->LanguageArray('order','Order_Buyers_Reward_Content',1);
													 
											
													  //接口
													  $this->Port(array(
																		
															  //Login
															  'login_uid'=>$this->uid,
															
															  //Credit
															  'credit_uid'=>$this->uid,
															  
															  'receive_uid'=>$consumeinfo['uid'], //接收人
															  
															  //SMS
															  'sms_subject'=>$send_subject,
															  'sms_content'=>$send_content,
																			
															  //EMail
															  'email_title'=>$send_subject,
															  'email_content'=>$send_content,
									
															  //Mobile
															  'mobile_content'=>$send_subject
																
																		
													  ),15);
													  
													  //通知 end--------------------------------------------------------------
													 
													 
							                 }else{
												 
												  echo include $this->LanguageArray('order','Order_Buyers_Reward_Error',1);
												  echo $this->CloseNowWindows('#loading',1);
												  exit();
												 
											 }
										   
									   }
									   
									   // 奖励 end -----------------------------------------------------------
									   
									   
									   //支付
									   $this->PayTaskOrder($value);

									   
									   echo $value.'号订单操作成功!<br />';
								 }else{
									   echo $value.'号订单操作过了!<br />';
								 }
							     
						   }
						   
						   echo $this->CloseNowWindows('#loading',1);
						
						
					}else{
						   echo '没有选择订单操作!<br />';
						   echo $this->CloseNowWindows('#loading');
					}	 
				   
   
				
			}else{
				
                    include_once(Core.'/class/pages_class_phpapp.php');
				   
				   
					switch ($this->GET['sort']) {
							  case '1':
							  $time=$this->NowTime()-(24*60*60*31*3);
							  $sort=" AND a.dateline>='$time'";
							  break;
							  case '2':
							  $sort=" AND c.process='1'";
							  break;
							  case '3':
							  $sort=" AND c.process='2'";
							  break;
							  case '4':
							  $sort=" AND c.process='3'";
							  break;
							  case '5':
							  $sort=" AND c.process='5'";
							  break;
							  case '6':
							  $sort=" AND c.process='6'";
							  break;
							  case '7':
							  $sort=" AND a.buyer='0' AND c.process='5' ";
							  break;
							  default:
							  $sort='';
					  }
			 
			       $page=new Pages(10,$this->GET['page'],'member.php?app=48&action=3&sort='.$this->GET['sort'],"SELECT a.*,b.uid,b.tid,b.url,b.subject,c.process,c.cid FROM (".$this->GetTable('task_order')." AS a LEFT JOIN  ".$this->GetTable('consume')." AS c ON c.cid=a.cid ) LEFT JOIN  ".$this->GetTable('task')." AS b ON a.tid=b.tid WHERE b.uid='$this->uid' $sort GROUP BY a.oid ORDER BY a.oid DESC");
			 

			 
			       $list=$page->ShowResult();


			       $getprocess=new TaskProcess();				
				
				
				   include $this->Template('buyer_member');
				
			}
	
			
	}
	
	
	public function SellerListOrder(){
	         //稿件订单
			 
			if(!empty($this->POST['oderid'])){	
			
					$oderid=$this->ExplodeStrArr($this->POST['oderid']);
								   
					$idarray=explode(',',$oderid);
			}
			
			
			if($this->GET['op']==4){
				   if($this->POST['Submit']){
					   
						   $content=$this->POST['content'];
						   
						   $oid=intval($oderid);
							
						   $this->Update('task_order',array('content'=>$content),array()," WHERE oid='$oid'");
							 
						   //文件
						   $files=$this->UploadFile();
				   
						   if($files){
								 foreach($files as $fid){
									  $this->Insert('apps_file',array('appid'=>$this->app,'fid'=>$fid,'uid'=>$this->uid,'id'=>$oid,'type'=>3),array());
								 }
								 $this->ReplaceFileContent($files,'task_order',$content," WHERE oid='$oid' ");
						   }
						   
						   echo '上传成功！';
						   echo $this->CloseNowWindows('#loading',1);
				   }
						   
			}elseif($this->GET['op']==3){
				 
                    $content=$this->str($this->POST['content'],100,1,0,0,0,1);
							 
					if(!empty($this->POST['oderid'])){	
					
						   foreach($idarray as $value){
							   
							       $value=intval($value);
								   
							       if($this->IsSQL('consume',"WHERE cid='$value' AND process=5")){
									   
										   if(!$this->IsSQL('task_order_credit',"WHERE cid='$value' AND type=1 AND uid='$this->uid'")){
											   
												   
												   $this->Update('task_order',array('seller'=>1),array(),"WHERE cid='$value'");
						
												   
												   $task=$this->GetMysqlOne('a.tid,a.uid,b.oid'," ".$this->GetTable('task')." AS a LEFT JOIN ".$this->GetTable('task_order')." AS b ON a.tid=b.tid  WHERE b.cid='$value'");
											   
												   $this->Insert('task_order_credit',array('tid'=>$task['tid'],'cid'=>$value,'level'=>$this->POST['level'],'type'=>1,'uid'=>$this->uid,'dateline'=>$this->NowTime(),'content'=>$content),array());
												   
											       
												   if(PHPAPP::$config['auto_delete_order_notice']){
													       $this->Delete('member_notice'," WHERE cid='$value' AND uid='$this->uid'");
											       }
											   
													 //通知--------------------------------------------------------------
				   
													   $send_subject=include $this->LanguageArray('order','Order_Seller_Evaluate_Subject',1);
													   $send_content=include $this->LanguageArray('order','Order_Seller_Evaluate_Content',1);
									
													  //接口
													  $this->Port(array(
																		
															  //Login
															  'login_uid'=>$this->uid,
															
															  //Credit
															  'credit_uid'=>$this->uid,
															  
															  'receive_uid'=>$task['uid'], //接收人
															  
															  //SMS
															  'sms_subject'=>$send_subject,
															  'sms_content'=>$send_content,
															  'sms_cid'=>$value,
																			
															  //EMail
															  'email_title'=>$send_subject,
															  'email_content'=>$send_content,
									
															  //Mobile
															  'mobile_content'=>$send_subject
																
																		
													  ),14);
													  
													  //通知 end--------------------------------------------------------------
													
													$this->TaskCredit($value);
													
													
													echo $value.'号订单评价成功!<br />';
										   }else{
													echo $value.'号订单评价过了!<br />';
										   }	
								   }else{
											echo '当前状态不能评价！';
								   }		   

						   }
				          
						   echo $this->CloseNowWindows('#loading',1);
				 
				   }
				 
			 }elseif($this->GET['op']==2){
				 
				
				 if(!empty($this->POST['oderid'])){	
				 
				       $this->SetDelivery($idarray);

					   echo $this->CloseNowWindows('#loading',1);
					 
				 }else{
					   echo '没有选择订单操作!<br />';
					   echo $this->CloseNowWindows('#loading');
				 }	 
				 
				 
			 }elseif($this->GET['op']==1){
	                
					$content=$this->str($this->POST['content'],99999,1,0,0,0,1);
					
					if(!empty($this->POST['oderid'])){	


                            $this->SetDelivery($idarray,$content);

						    echo $this->CloseNowWindows('#loading',1);
						
						
					}else{
						   echo '没有选择订单操作!<br />';
						   echo $this->CloseNowWindows('#loading');
					}	 
							 

			 }else{
				 
				   include_once(Core.'/class/pages_class_phpapp.php');
				   
				
					switch ($this->GET['sort']) {
							  case '1':
							  $time=$this->NowTime()-(24*60*60*31*3);
							  $sort=" AND a.dateline>='$time'";
							  break;
							  case '2':
							  $sort=" AND c.process='1'";
							  break;
							  case '3':
							  $sort=" AND c.process='2'";
							  break;
							  case '4':
							  $sort=" AND c.process='3'";
							  break;
							  case '5':
							  $sort=" AND c.process='5'";
							  break;
							  case '6':
							  $sort=" AND c.process='6'";
							  break;
							  case '7':
							  $sort=" AND a.seller='0' ";
							  break;
							  default:
							  $sort='';
					  }
			 
			       $page=new Pages(10,$this->GET['page'],'member.php?app=48&action=1&sort='.$this->GET['sort'],"SELECT a.*,c.process,c.cid FROM (".$this->GetTable('task_order')." AS a LEFT JOIN  ".$this->GetTable('consume')." AS c ON c.cid=a.cid )LEFT JOIN  ".$this->GetTable('task_draft')." AS b ON a.did=b.did WHERE b.uid='$this->uid' $sort GROUP BY a.oid ORDER BY a.oid DESC");
			 

			 
			       $list=$page->ShowResult();


			       $getprocess=new TaskProcess();
			 
			 
	
			       include $this->Template('seller_member');
			 }
	}

	
	function SetDelivery($idarray=array(),$content='',$isshow=0){
		
		      $deliveryarray=array();
		
	          if($idarray){
	                     foreach($idarray as $value){
							    
								 $value=intval($value);
								
							     if($this->IsSQL('consume',"WHERE cid='$value' AND process=2")){
									
									   
									   $this->Update('consume',array('process'=>3),array(),"WHERE cid='$value'");
									   
									   $task=$this->GetMysqlOne('b.uid,b.subject,b.tid,a.oid,a.runid'," ".$this->GetTable('task_order')." AS a LEFT JOIN  ".$this->GetTable('task')." AS b ON a.tid=b.tid  WHERE a.cid='$value'");
									   
									   if($task['runid']>0){
										      $this->Delete('autorun'," WHERE aid='$task[runid]'");
									   }
									   
									   //自动
									   include_once(Core.'/class/auto_class_phpapp.php');
									   
									   $auto=new AUTO();
									   
									   $autoday=intval(PHPAPP::$config['task_auto_verifypay']);
									   
									   $runtime=$this->NowTime()+($autoday*24*60*60);
									   
									   $runid=$auto->SetAutoRun(array(
													'app'=>49,
													'runtime'=>$runtime,
													'function'=>'PayTask',
													'cid'=>$value
										));
									 
									   $this->Update('task_order',array('runid'=>$runid),array(),"WHERE cid='$value'");
									  
									   
									   
									   $send_op='';
														   
									   $send_subject=include $this->LanguageArray('order','Order_Confirm_Delivery_Subject',1);
									   
									   $send_content=include $this->LanguageArray('order','Order_Confirm_Delivery_Content',1);
									   
									   $getprocess=new TaskProcess();
									   $send_op=include $this->LanguageArray('order','Order_Confirm_Delivery_Operate',1);
									  
					             
									  if(PHPAPP::$config['auto_delete_order_notice']){
											$this->Delete('member_notice'," WHERE cid='$value'");
									  }
									  
									  //接口
									  $this->Port(array(
														
											  //Login
											  'login_uid'=>$this->uid,
											
											  //Credit
											  //'credit_uid'=>$this->uid,
											  
											  'receive_uid'=>$task['uid'], //接收人
											  
											  //SMS
											  'sms_subject'=>$send_subject,
											  'sms_content'=>$send_content.$send_op,
											  'sms_cid'=>$value,
															
											  //EMail
											  'email_title'=>$send_subject,
											  'email_content'=>$send_content,
					
											  //Mobile
											  'mobile_content'=>$send_subject
												
														
									   ),5);
														  
								
									   
									   $deliveryarray[]='<p>'.$value.'订单操作成功!</p>';
									   
								 }else{
									   $deliveryarray[]='<p>'.$value.'订单操作过了!</p>';
								 }
							     
						   }
			  }
			  
			  
			  if($isshow){
					return $deliveryarray;
			  }else{
				  
				    foreach($deliveryarray as $value){
					      echo  $value;
					}
			  }
	
	}
	
	function RefundTaskOrder($cid){
		   
		   if($this->IsSQL('consume'," WHERE cid='$cid' AND process=4 ")){

		   }
		
	}
	
	
	function PayTaskOrder($cid,$refund=0){
		  
		  if($this->IsSQL('consume'," WHERE cid='$cid' AND process!=8 AND process>1 ")){
			  
				$consume=$this->GetMysqlOne('cid'," ".$this->GetTable('consume')." WHERE cid='$cid'");
				
				if($consume){
						
						//任务结束
						$taskorder=$this->GetMysqlOne('tid,money,did,oid'," ".$this->GetTable('task_order')." WHERE cid='$cid'");
						
						$tid=$taskorder['tid'];
						
						$task=$this->GetMysqlOne('tid,uid,url,money,total,draft_success,sid'," ".$this->GetTable('task')." WHERE tid='$tid'");
						
						$did=$taskorder['did'];

						$draft=$this->GetMysqlOne('uid,did'," ".$this->GetTable('task_draft')." WHERE did='$did'");
						
						
						$pay=new UserConsume();
						
						//修改出售量
						if($task['sid']>0){
							   
							   $sellnum=$this->IsSQL('task'," WHERE sid='$task[sid]' AND draft_success>0 ");
							   
							   $this->Update('task_seller_service',array('sellnum'=>$sellnum),array(),"WHERE sid='$task[sid]'");
							   
							   //用户
							   $selltotal=$this->IsSQL('task'," WHERE sid>0 AND draft_success>0 ");
							   
							   $this->Update('member_info',array('selltotal'=>$selltotal),array(),"WHERE uid='$draft[uid]'");
							   
							   $this->Update('task',array('process'=>8,'endtime'=>$this->NowTime()),array(),"WHERE tid='$tid'");
							   
							   $pay->SetSuccessConsume($consume['cid'],array('uid'=>$task['uid'],'tid'=>$tid,'url'=>$task['url'],'table'=>'task_seller_usergroup'));

						}elseif($task['total']>1){
							   if(($task['draft_success']) >= intval($task['total'])){
									  $this->Update('task',array('process'=>8,'endtime'=>$this->NowTime(),'topbid'=>0),array(),"WHERE tid='$tid'");
							   }
								
							   //推广员,中标的金额加入
							   $pay->SetSuccessConsume($consume['cid'],array('uid'=>$task['uid'],'tid'=>$tid,'url'=>$task['url'],'table'=>'task_count_usergroup'));
						
						}else{
							   if($task['money']>0){
								
									 $this->Update('task',array('process'=>8,'endtime'=>$this->NowTime(),'topbid'=>0),array(),"WHERE tid='$tid'");
							   
							   }
								
							   $pay->SetSuccessConsume($consume['cid'],array('uid'=>$task['uid'],'tid'=>$tid,'url'=>$task['url'],'table'=>'task_grab_usergroup'));
						
						}

   
   
   					   $send_op='';
					   
					   if($refund==1){
						   
						    $this->Update('refund_money',array('endtime'=>$this->NowTime(),'process'=>3),array()," WHERE cid='$consume[cid]' AND buyeruid='$task[uid]'");
						    //退款
						    $send_subject=include $this->LanguageArray('order','Order_Refund_Subject',1);
							$send_content=include $this->LanguageArray('order','Order_Refund_Content',1);
					   }else{
							$send_subject=include $this->LanguageArray('order','Order_Pay_Subject',1);
							   
							$send_content=include $this->LanguageArray('order','Order_Pay_Content',1);
							
							//自动评价
							include_once(Core.'/class/auto_class_phpapp.php');
									   
						    $auto=new AUTO();
						   
						    $autoday=intval(PHPAPP::$config['task_auto_evaluate']);
						   
						    $runtime=$this->NowTime()+($autoday*24*60*60);
						   
						    $runid=$auto->SetAutoRun(array(
										'app'=>49,
										'runtime'=>$runtime,
										'function'=>'AutoEvaluate',
										'cid'=>$cid,
										'oid'=>$taskorder['oid']
							));
					   }
					   
					   $getprocess=new TaskProcess();
					   
					   if(!$refund){
					   		 $send_op=include $this->LanguageArray('order','Order_Pay_Operate',1);
					   }
					   
					  //del 通知
					  if(PHPAPP::$config['auto_delete_order_notice']){
					        $this->Delete('member_notice'," WHERE cid='$consume[cid]'");
					  }
	
					  //威客
					  $this->Port(array(
										
							  //Login
							  'login_uid'=>$this->uid,
							
							  //Credit
							  'credit_uid'=>$this->uid,
							  
							  'receive_uid'=>$draft['uid'], //接收人
							  
							  //SMS
							  'sms_subject'=>$send_subject,
							  'sms_content'=>$send_content.$send_op,
							  'sms_cid'=>$consume['cid'],
											
							  //EMail
							  'email_title'=>$send_subject,
							  'email_content'=>$send_content,
	
							  //Mobile
							  'mobile_content'=>$send_subject
								
										
					   ),6);
					  
					  if(!$refund){
						  
							  $send_subject=include $this->LanguageArray('order','Order_Complete_Subject',1);
							  $send_content=include $this->LanguageArray('order','Order_Complete_Content',1);
							  $send_op=include $this->LanguageArray('order','Order_Complete_Operate',1);
							  //雇主
							  $this->Port(array(
												
									  
									  'receive_uid'=>$task['uid'], //接收人
									  
									  //SMS
									  'sms_subject'=>$send_subject,
									  'sms_content'=>$send_content.$send_op,
									  'sms_cid'=>$consume['cid'],
													
									  //EMail
									  'email_title'=>$send_subject,
									  'email_content'=>$send_content,
			
									  //Mobile
									  'mobile_content'=>$send_subject
										
												
							   ),6);
					  
					  }
				}
		  }
	}
	
	function AddMessageAction(){

		  if($this->POST['Submit']){	
		 										 
				$oid=intval($this->POST['oid']);
				
				include_once(Core.'/class/filter_class_phpapp.php');
				
				$strings=new CharFilter($this->POST['content']);
				if(empty($this->POST['content'])){
					 echo '请输入留言内容!';
					 echo $this->CloseNowWindows('#loading');
				}elseif($strings->CheckLength(5)){ 
					 echo '对不起！留言不能少5个字!';
					 echo $this->CloseNowWindows('#loading');
				}else{
					
					 //过虑
					 $content=$this->str($this->POST['content'],200,0,1,1,0,1);
					 
					 if($oid){
						   
						   $newid=$this->Insert('task_order_message',array('appid'=>$this->app,'uid'=>$this->uid,'oid'=>$oid,'content'=>$content,'dateline'=>$this->NowTime()),array());
					
						   if($newid){		
						          
								  $send_subject=include $this->LanguageArray('order','Order_Message_Subject',1);
								  
								  $send_content=$content;
								  
								  $send_content.=include $this->LanguageArray('order','Order_Message_Content',1);
								  
								  $draft=$this->GetMysqlOne('a.tid,a.uid,b.oid'," ".$this->GetTable('task_draft')." AS a LEFT JOIN ".$this->GetTable('task_order')." AS b ON a.did=b.did  WHERE b.oid='$oid'");
						          
								  if($draft['uid']==$this->uid){
									    //通知雇主
										$task=$this->GetMysqlOne('uid'," ".$this->GetTable('task')."  WHERE tid='$draft[tid]'");
									    $receive_uid=$task['uid'];
								  }else{
									    $receive_uid=$draft['uid'];
								  }
								  
								  $this->Port(array(
													
										   //Login
										  'login_uid'=>$this->uid,
										
										  //Credit
										  'credit_uid'=>$this->uid,
											
										  
										  'receive_uid'=>$receive_uid, //接收人
										  
										  //SMS
										  'sms_subject'=>$send_subject,
										  'sms_content'=>$send_content,
														
										  //EMail
										  'email_title'=>$send_subject,
										  'email_content'=>$send_content,
				
										  //Mobile
										  'mobile_content'=>$send_subject
											
													
								 ),9);
					  
								echo '发布留言成功!<br />';
						   }else{
								echo '发布留言失败!<br />';
						   }
						
					 }else{
						
						   echo '订单ID有误!<br />';
							
					 }
					

				}
					
						
	      }
				
		
		
	}
	
	function ShowMessageAction(){
           
		   $oid=intval($this->GET['oid']);

		   include $this->AppsView('message');
		   
	}
	
	
	function TaskCredit($oid=0){
		
                      if($this->IsSQL('task_order_credit',"WHERE cid='$oid'") ==2){
						  
									if(PHPAPP::$config['auto_delete_order_notice']){
										 $this->Delete('member_notice'," WHERE cid='$oid'");
									}
							 
									$credit=$this->GetMysqlArray('*'," ".$this->GetTable('task_order_credit')." WHERE cid='$oid'");
									    
									foreach($credit as $key=>$order){
										   
										   if($key==0){
											   $type=1;
										   }else{
											   $type=0;
										   }
												   
										   if($order['type']==1){
						  
												   if($credit[$key]['level']==1){
														 //中评
														 $this->UpdateCredit($credit[$type]['uid'],2,PHPAPP::$config['task_zhongping'],1);
													   
												   }elseif($credit[$key]['level']==2){
														 //差评
														 $this->UpdateCredit($credit[$type]['uid'],2,PHPAPP::$config['task_chaping'],2);
												   }else{
														 //好评
														 $this->UpdateCredit($credit[$type]['uid'],2,PHPAPP::$config['task_haoping'],0);
												   }
										   
										   }elseif($order['type']==2){
	                                               

												   if($credit[$key]['level']==1){
														
														 $this->UpdateCredit($credit[$type]['uid'],1,PHPAPP::$config['task_zhongping'],1);
													   
												   }elseif($credit[$key]['level']==2){
														
														 $this->UpdateCredit($credit[$type]['uid'],1,PHPAPP::$config['task_chaping'],2);
												   }else{
														
														 $this->UpdateCredit($credit[$type]['uid'],1,PHPAPP::$config['task_haoping'],0);
												   }
												   
										   }
									}
							 			
										   
					  }
										   		
		
	}
	
	
	
}

?>