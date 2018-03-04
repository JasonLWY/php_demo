<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class UserConsume extends PHPAPP{
	
	 
	function __construct(){	
	
	      parent::__construct();

	}
	
	
	public function MakeConsume($post=''){
		
		  if($post){
			
						 $post['subject']=$this->str($post['subject'],50,0,0,0,0,1);
						 
						 if(!empty($post['serial'])){
							   $addsql=array('dateline'=>$this->NowTime());
						 }else{
							   $addsql=array('serial'=>$this->GetOrderNumber(),'dateline'=>$this->NowTime());
						 }
					
						 $newid=$this->Insert('consume',$post,$addsql);
						 
						 if($newid){
							   
							   $oid=intval($post['oid']);
							   
							   if($post['payout']>0){

								     $member=$this->GetLoginInfo($post['payout']);
									
								     $this->Insert('member_consume',array('cid'=>$newid,'uid'=>$post['payout'],'flow'=>'2','money'=>$member['money'],'oid'=>$oid),array());  //支出者
								   
							   }else{
								   
							         $member=$this->GetMysqlOne('money'," ".$this->GetTable('member_account')." WHERE uid='0'");
									 
									 $this->Insert('member_consume',array('cid'=>$newid,'uid'=>$post['payout'],'flow'=>'2','money'=>$member['money']),array()); 

							   }
							   
							   if($post['payin']>0){
	
							         $member=$this->GetLoginInfo($post['payin']);
							         $this->Insert('member_consume',array('cid'=>$newid,'uid'=>$post['payin'],'flow'=>'1','money'=>$member['money'],'oid'=>$oid),array());   //收入者
							   }else{
								     
									 $member=$this->GetMysqlOne('money'," ".$this->GetTable('member_account')." WHERE uid='0'");
								     $this->Insert('member_consume',array('cid'=>$newid,'uid'=>$post['payin'],'flow'=>'1','money'=>$member['money']),array());  
								   
							   }
								
							   return $newid;
						 }

				
		  }
		
	}
	
	
	public function CloseConsume($cid=''){
		
		    $this->Update('consume',array('process'=>6),array()," WHERE  cid='$cid' ");
		
	}
	
	
	public function SetSuccessConsume($cid='',$task=''){ 
		
            $loginuid=intval($this->uid);
			
			if($this->IsSQL('consume',"WHERE cid='$cid' AND process<5")){	 
			       
				   $this->Update('consume',array('process'=>5,'dateline'=>$this->NowTime()),array()," WHERE  cid='$cid' ");
				   
				   
				   $consume=$this->GetMysqlOne('*'," ".$this->GetTable('consume')." WHERE cid='$cid'");
				   
	               if($consume['refundmoney']>=$consume['amount']){
					   
					     $ConsumeMoney=($consume['amount']+$consume['fee']) - $consume['refundmoney']; 
					   
				   }else{
					     
						 $ConsumeMoney=$consume['amount']-$consume['refundmoney']; 
					     
				   }
				   
				   //关闭退款
				   if($consume['refundmoney']>0){
						  
						  $this->CloseConsume($cid);
				   }
				   
				   //付款
				   $consumearr=$this->GetMysqlArray('*'," ".$this->GetTable('member_consume')." WHERE cid='$cid'");
				   
				   if($consumearr){
					    
						   foreach($consumearr as $value) {
									
								    $uid=$value['uid'];
								   
									if($value['flow']==2){
							
										  //处理支出者
                                          if($uid==0){
												 //E付宝
												 $apppay=$this->GetMysqlOne('*'," ".$this->GetTable('member_account')." WHERE uid='0'");
												 												 
												 $nowmoney=$apppay['money']-$ConsumeMoney;
												 
												 $this->Update('member_account',array('money'=>$nowmoney),array(),"WHERE uid='0'");
												
												 $this->Update('member_consume',array('money'=>$nowmoney),array(),"WHERE cid='$cid' AND uid='0'");
												
										  }else{
														
												  $member=$this->GetLoginInfo($uid);
												  
												  if($member['money']>=$ConsumeMoney){
												  
														//提现
														if($consume['paytype']==4){
															
															  //$lockmoney=$member['lock']-$ConsumeMoney;
															  
															  //$this->Update('member_account',array('lock'=>$lockmoney),array(),"WHERE uid='$uid'");
															  
															  if($consume['fee']){
																  
																	  $apppay=$this->GetMysqlOne('money'," ".$this->GetTable('member_account')." WHERE uid='0'");
												 
												                      $nowmoney=$apppay['money']+$consume['fee'];
												 
												                      $this->Update('member_account',array('money'=>$nowmoney),array(),"WHERE uid='0'");
																	  
															  }
															  
															  
														}else{
															
															  $nowmoney=$member['money']-$ConsumeMoney;
														
														
														      $this->Update('member_account',array('money'=>$nowmoney,'wealth'=>$member['wealth']-$ConsumeMoney),array(),"WHERE uid='$uid'");
															
															  $this->Update('member_consume',array('money'=>$nowmoney),array(),"WHERE cid='$cid' AND uid='$uid'");
														}
														
														
														$taskorderarr=$this->GetMysqlOne('oid'," ".$this->GetTable('task_order')." WHERE cid='$cid'");
														
														$send_subject=$this->str($consume['subject'],255,1,0,1,0,0,1).'订单交易完成';
				   										$send_content='尊敬的用户：'.$this->str($consume['subject'],255,1,0,1,0,0,1).' 订单交易完成(订单号 '.$consume['serial'].'),本次交易您支出'.$ConsumeMoney.'元,<a href="'.SURL.'/member.php?app=5&action=1&cid='.$cid.'&opensearch=1&SelectData=1" target="_blank"><span class="show_details">[查看详细]</span></a>';
													 
														$this->Port(array(
																	  
																	  //SMS
																	  'receive_uid'=>$uid, //接收人

																	  //SMS
																	  'sms_subject'=>$send_subject,
																	  'sms_content'=>$send_content,
																					
																	  //EMail
																	  'email_title'=>$send_subject,
																	  'email_content'=>$send_content,
											
																	  //Mobile
																	  'mobile_content'=>$send_subject
																	  
																	  ),13);
														
														
												  }else{
													    return false;
												  }
										  
										  }
										  
										  
									}elseif($value['flow']==1){
										
											
											if($uid==0){
												 //E付宝
									  
												 $apppay=$this->GetMysqlOne('*'," ".$this->GetTable('member_account')." WHERE uid='0'");
							
												 $nowmoney=$apppay['money']+$ConsumeMoney;
												 
												 $this->Update('member_account',array('money'=>$nowmoney),array(),"WHERE uid='0'");
												 
												 $this->Update('member_consume',array('money'=>$nowmoney),array(),"WHERE cid='$cid' AND uid='0'");
												 
												
											}else{
												
												 //处理收入者
												
												 $member=$this->GetLoginInfo($uid);

												 $nowmoney=$member['money']+$ConsumeMoney;

												 
												 $this->Update('member_account',array('money'=>$nowmoney,'wealth'=>$member['wealth']+$ConsumeMoney),array(),"WHERE uid='$uid'");
												 
												 
												 $this->Update('member_consume',array('money'=>$nowmoney),array(),"WHERE cid='$cid' AND uid='$uid'");
												 
												 
												 //中标推广者
												 if(!empty($member['unionid']) && !empty($task['table'])){
													     
														 if(time()<intval($member['uniontime']) || intval($member['uniontime'])==0){
															 
																$unionfee=$this->GetTaskFeeValue($task['table'],'unionfee',$ConsumeMoney,1,$member['unionid']);
																
																if($unionfee>0){
																	   
																	   $newcid=$this->MakeConsume(array(
																							 'subject'=>'<p>任务中标</p>推广提成', 
																							 'appid'=>intval($this->app),
																							 'process'=>1,
																							 'amount'=>$unionfee,
																							 'paytype'=>1, 
																							 'payout'=>0,
																							 'payin'=>$member['unionid'],
																							 'sellerurl'=>$task['url']
																							 
																					   ));
																	  
																	  $this->SetSuccessConsume($newcid);
																	  
																	  
																	  $unionmember=$this->GetMysqlOne('*',"  ".$this->GetTable('member_account')." WHERE uid='$member[unionid]'");
																	  
																	  $this->Update('member_account',array('union'=>$unionmember['union']+$unionfee),array()," WHERE uid='$member[unionid]'");
																	  
																	  
																	  
																	  if($this->IsSQL('member_union'," WHERE uid='$member[unionid]' AND appid='$this->app' ")){
												
																			 $memberunion=$this->GetMysqlOne('*'," ".$this->GetTable('member_union')." WHERE uid='$member[unionid]' AND appid='$this->app' ");
																			 
																			 $unionmoney=$memberunion['money']+$unionfee;
																			 
																			 $uniontotal=$memberunion['total']+$unionfee;
																			  
																			 $this->Update('member_union',array('money'=>$unionmoney,'total'=>$uniontotal),array(),"WHERE uid='$member[unionid]' AND appid='$this->app' ");
																		 
																	 }else{
																		 
																			 $this->Insert('member_union',array('uid'=>$member['unionid'],'appid'=>$this->app,'money'=>$unionfee,'total'=>1),array());
																		 
																	 }
																									
																	
																	$send_subject=$task['tid'].'号任务交易完成，您获得推广提成。';
																	$send_content='尊敬的推广员：'.$task['tid'].'号任务交易完成,您获得推广提成 '.$unionfee.'元,<a href="'.SURL.$task['url'].'" target="_blank"><span class="show_details">[查看任务]</span></a>';
													 
																	$this->Port(array(
																				  
																	 
																				  'receive_uid'=>$member['unionid'], 
			
																				  //SMS
																				  'sms_subject'=>$send_subject,
																				  'sms_content'=>$send_content,
																								
																				  //EMail
																				  'email_title'=>$send_subject,
																				  'email_content'=>$send_content,
														
																				  //Mobile
																				  'mobile_content'=>$send_subject
																				  
																				  ),12);
																	
						
																	  
																}
																
														 }
													 
												 }
												 
												 //发布任务推广者
												 if(!empty($task['uid'])){
													   
													     $member=$this->GetLoginInfo($task['uid']);
														 
														 $unionfee=$this->GetTaskFeeValue($task['table'],'addunionfee',$ConsumeMoney,1,$member['unionid']);
														  
														  if($unionfee>0 && intval($member['unionid'])>0){
															     
																 if(time()<intval($member['uniontime']) || intval($member['uniontime'])==0){
																	 
																		 $newcid=$this->MakeConsume(array(
																							   'subject'=>'<p>任务发布</p>推广提成', 
																							   'appid'=>intval($this->app),
																							   'process'=>1,
																							   'amount'=>$unionfee,
																							   'paytype'=>1, 
																							   'payout'=>0,
																							   'payin'=>$member['unionid'],
																							   'sellerurl'=>$task['url']
																							   
																						 ));
																		
																		 $this->SetSuccessConsume($newcid);
																		 
																		 $unionmember=$this->GetMysqlOne('*',"  ".$this->GetTable('member_account')." WHERE uid='$member[unionid]'");
																		
																		 $this->Update('member_account',array('union'=>$unionmember['union']+$unionfee),array()," WHERE uid='$member[unionid]'");
																		 					 
																		 if($this->IsSQL('member_union'," WHERE uid='$member[unionid]' AND appid='$this->app' ")){
												
																				 $memberunion=$this->GetMysqlOne('*'," ".$this->GetTable('member_union')." WHERE uid='$member[unionid]' AND appid='$this->app' ");
																				 
																				 $unionmoney=$memberunion['money']+$unionfee;
																				 
																				 $uniontotal=$memberunion['total']+$unionfee;
																				  
																				 $this->Update('member_union',array('money'=>$unionmoney,'total'=>$uniontotal),array(),"WHERE uid='$member[unionid]' AND appid='$this->app' ");
																			 
																		 }else{
																			 
																				 $this->Insert('member_union',array('uid'=>$member['unionid'],'appid'=>$this->app,'money'=>$unionfee,'total'=>1),array());
																			 
																		 }
																		
																		
																		
																		$send_subject=$task['tid'].'号任务交易完成，您获得推广提成。';
																		$send_content='尊敬的推广员：'.$task['tid'].'号任务交易完成,您获得推广提成 '.$unionfee.'元,<a href="'.SURL.$task['url'].'" target="_blank"><span class="show_details">[查看任务]</span></a>';
													 
																		$this->Port(array(
																				  
																	 
																				  'receive_uid'=>$member['unionid'], 
			
																				  //SMS
																				  'sms_subject'=>$send_subject,
																				  'sms_content'=>$send_content,
																								
																				  //EMail
																				  'email_title'=>$send_subject,
																				  'email_content'=>$send_content,
														
																				  //Mobile
																				  'mobile_content'=>$send_subject
																				  
																				  ),12);
																	
																	 
																 }
																
															    
														  }
													 
												 }
												 
												 
					
											}
					                      
									}
								   
						   }
						   
		                  
						  
						  
						  //退款
						  if($consume['refundmoney']>0){
								  
								  //雇主
								  $newcid=$this->MakeConsume(array(
										  'subject'=>'<p>'.$task['tid'].'号任务</p>订单退款',  
										  'appid'=>$this->app, 
										  'paytype'=>1, 
										  'process'=>1, 
										  'amount'=>$consume['refundmoney'], 
										  'payout'=>0, 
										  'payin'=>$task['uid']
										  
									));
				  
				  
				  
				  				  $this->SetSuccessConsume($newcid); 
				  
								  
								  $send_subject=$task['tid'].'号任务订单退款成功。';
								  $send_content='尊敬的用户：'.$task['tid'].' 号任务订单退款'.$consume['refundmoney'].'元成功！<a href="'.SURL.'/member.php?app=5&action=1&cid='.$newcid.'&opensearch=1&SelectData=1" target="_blank"><span class="show_details">[查看详细]</span></a>';
															 
								  $this->Port(array(
											  
								 
											  'receive_uid'=>$task['uid'], 
		
											  //SMS
											  'sms_subject'=>$send_subject,
											  'sms_content'=>$send_content,
															
											  //EMail
											  'email_title'=>$send_subject,
											  'email_content'=>$send_content,
					
											  //Mobile
											  'mobile_content'=>$send_subject
											  
											  ),20);
																			
						   }
						   
				   
						   return true;

				   }
				   
				   
			}
	} 
	
	
	public function UpdateUserConsumeMoney($amount,$uid){
		
		
		    $newcid=$this->MakeConsume(array(
								   'subject'=>'<p>金钱兑换</p>UC兑换金钱', 
								   'appid'=>3,
								   'process'=>1,
								   'amount'=>$amount,
								   'paytype'=>1, 
								   'payout'=>0,
								   'payin'=>intval($uid)
								   
							 ));
			
			$this->SetSuccessConsume($newcid);
		  
		
	}
	
}

?>