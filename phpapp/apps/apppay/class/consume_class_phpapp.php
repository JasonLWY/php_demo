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
									
								     $this->Insert('member_consume',array('cid'=>$newid,'uid'=>$post['payout'],'flow'=>'2','money'=>$member['money'],'oid'=>$oid),array());  //֧����
								   
							   }else{
								   
							         $member=$this->GetMysqlOne('money'," ".$this->GetTable('member_account')." WHERE uid='0'");
									 
									 $this->Insert('member_consume',array('cid'=>$newid,'uid'=>$post['payout'],'flow'=>'2','money'=>$member['money']),array()); 

							   }
							   
							   if($post['payin']>0){
	
							         $member=$this->GetLoginInfo($post['payin']);
							         $this->Insert('member_consume',array('cid'=>$newid,'uid'=>$post['payin'],'flow'=>'1','money'=>$member['money'],'oid'=>$oid),array());   //������
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
				   
				   //�ر��˿�
				   if($consume['refundmoney']>0){
						  
						  $this->CloseConsume($cid);
				   }
				   
				   //����
				   $consumearr=$this->GetMysqlArray('*'," ".$this->GetTable('member_consume')." WHERE cid='$cid'");
				   
				   if($consumearr){
					    
						   foreach($consumearr as $value) {
									
								    $uid=$value['uid'];
								   
									if($value['flow']==2){
							
										  //����֧����
                                          if($uid==0){
												 //E����
												 $apppay=$this->GetMysqlOne('*'," ".$this->GetTable('member_account')." WHERE uid='0'");
												 												 
												 $nowmoney=$apppay['money']-$ConsumeMoney;
												 
												 $this->Update('member_account',array('money'=>$nowmoney),array(),"WHERE uid='0'");
												
												 $this->Update('member_consume',array('money'=>$nowmoney),array(),"WHERE cid='$cid' AND uid='0'");
												
										  }else{
														
												  $member=$this->GetLoginInfo($uid);
												  
												  if($member['money']>=$ConsumeMoney){
												  
														//����
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
														
														$send_subject=$this->str($consume['subject'],255,1,0,1,0,0,1).'�����������';
				   										$send_content='�𾴵��û���'.$this->str($consume['subject'],255,1,0,1,0,0,1).' �����������(������ '.$consume['serial'].'),���ν�����֧��'.$ConsumeMoney.'Ԫ,<a href="'.SURL.'/member.php?app=5&action=1&cid='.$cid.'&opensearch=1&SelectData=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>';
													 
														$this->Port(array(
																	  
																	  //SMS
																	  'receive_uid'=>$uid, //������

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
												 //E����
									  
												 $apppay=$this->GetMysqlOne('*'," ".$this->GetTable('member_account')." WHERE uid='0'");
							
												 $nowmoney=$apppay['money']+$ConsumeMoney;
												 
												 $this->Update('member_account',array('money'=>$nowmoney),array(),"WHERE uid='0'");
												 
												 $this->Update('member_consume',array('money'=>$nowmoney),array(),"WHERE cid='$cid' AND uid='0'");
												 
												
											}else{
												
												 //����������
												
												 $member=$this->GetLoginInfo($uid);

												 $nowmoney=$member['money']+$ConsumeMoney;

												 
												 $this->Update('member_account',array('money'=>$nowmoney,'wealth'=>$member['wealth']+$ConsumeMoney),array(),"WHERE uid='$uid'");
												 
												 
												 $this->Update('member_consume',array('money'=>$nowmoney),array(),"WHERE cid='$cid' AND uid='$uid'");
												 
												 
												 //�б��ƹ���
												 if(!empty($member['unionid']) && !empty($task['table'])){
													     
														 if(time()<intval($member['uniontime']) || intval($member['uniontime'])==0){
															 
																$unionfee=$this->GetTaskFeeValue($task['table'],'unionfee',$ConsumeMoney,1,$member['unionid']);
																
																if($unionfee>0){
																	   
																	   $newcid=$this->MakeConsume(array(
																							 'subject'=>'<p>�����б�</p>�ƹ����', 
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
																									
																	
																	$send_subject=$task['tid'].'����������ɣ�������ƹ���ɡ�';
																	$send_content='�𾴵��ƹ�Ա��'.$task['tid'].'�����������,������ƹ���� '.$unionfee.'Ԫ,<a href="'.SURL.$task['url'].'" target="_blank"><span class="show_details">[�鿴����]</span></a>';
													 
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
												 
												 //���������ƹ���
												 if(!empty($task['uid'])){
													   
													     $member=$this->GetLoginInfo($task['uid']);
														 
														 $unionfee=$this->GetTaskFeeValue($task['table'],'addunionfee',$ConsumeMoney,1,$member['unionid']);
														  
														  if($unionfee>0 && intval($member['unionid'])>0){
															     
																 if(time()<intval($member['uniontime']) || intval($member['uniontime'])==0){
																	 
																		 $newcid=$this->MakeConsume(array(
																							   'subject'=>'<p>���񷢲�</p>�ƹ����', 
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
																		
																		
																		
																		$send_subject=$task['tid'].'����������ɣ�������ƹ���ɡ�';
																		$send_content='�𾴵��ƹ�Ա��'.$task['tid'].'�����������,������ƹ���� '.$unionfee.'Ԫ,<a href="'.SURL.$task['url'].'" target="_blank"><span class="show_details">[�鿴����]</span></a>';
													 
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
						   
		                  
						  
						  
						  //�˿�
						  if($consume['refundmoney']>0){
								  
								  //����
								  $newcid=$this->MakeConsume(array(
										  'subject'=>'<p>'.$task['tid'].'������</p>�����˿�',  
										  'appid'=>$this->app, 
										  'paytype'=>1, 
										  'process'=>1, 
										  'amount'=>$consume['refundmoney'], 
										  'payout'=>0, 
										  'payin'=>$task['uid']
										  
									));
				  
				  
				  
				  				  $this->SetSuccessConsume($newcid); 
				  
								  
								  $send_subject=$task['tid'].'�����񶩵��˿�ɹ���';
								  $send_content='�𾴵��û���'.$task['tid'].' �����񶩵��˿�'.$consume['refundmoney'].'Ԫ�ɹ���<a href="'.SURL.'/member.php?app=5&action=1&cid='.$newcid.'&opensearch=1&SelectData=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>';
															 
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
								   'subject'=>'<p>��Ǯ�һ�</p>UC�һ���Ǯ', 
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