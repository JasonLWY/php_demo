<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include(APPS.'/apppay/class/process_class_phpapp.php');

include_once(APPS.'/sellerservice/main_phpapp.php');

include_once(Core.'/class/delete_file_phpapp.php');

//Manage
class SellerServiceMemberControls extends SellerServiceMainControls{
	
	public $POST,$GET,$errors;
	
	public $sid;
	
	function __construct(){	 
	 
		   parent::__construct();
           
		   $this->sid=empty($_GET['sid']) ? 0 : intval($_GET['sid']);

           $postkey=array('Submit'=>'','submit'=>'','SecurityForm'=>'');
			
			
		   $this->POST=$this->POSTArray();
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','sid','op','tid','sort','agree'));
		   
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
		
		  return $this->ServiceManageAction();
		
	}
	
	
    function PayTaskAction(){
		     
			 $uid=$this->uid;
			  
			 $taskarr=$this->GetMysqlOne('*'," ".$this->GetTable('task')." WHERE tid='$this->tid'");
			 
			 $taskmoney=floatval($taskarr['money']);
			 
		     if($taskarr['tid']>0){
				           
		
							 //����û����ý��
							 $user=$this->GetMysqlOne('*'," ".$this->GetTable('member_account')." WHERE uid='$uid'");
							 
							 
							 if($user['money']>=($taskmoney)){
								 
						            //ֱ��֧��
                                    $this->TaskPayComplete($taskmoney);

					         }else{
								 
								    $paymoney=$taskmoney-$user['money'];
						
							        include_once(APPS.'/pay/main_phpapp.php');
									
							        $pay=new PayMainControls();
							        
							        $pay->UserPay('task',$paymoney,$this->tid,2);
							 }
							  
		                     exit();
							 
			 }else{
				    echo '���񲻴���!';
							 
				    echo $this->AjaxRefresh(SURL,1);
			 }
		
	}
	
	function OnLineTaskPayAction(){
		
		 include_once(APPS.'/pay/main_phpapp.php');

		 $pay=new PayMainControls();
							 
		 $pay->GoPayTool($this->POST);
							 
	}
	
	function TaskPayComplete($taskmoney){
		  
		  
		  //�й�����
		  
		  include_once(APPS.'/apppay/class/consume_class_phpapp.php');

		  $pay=new UserConsume();
		  
		  $newcid=$pay->MakeConsume(array(
								  'subject'=>'������񵣱���',  //��������
								  'appid'=>$this->app, 
								  'paytype'=>1, 
								  'process'=>1, 
								  'amount'=>$taskmoney, 
								  'payout'=>$this->uid, 
								  'payin'=>0   // ������
								  
							));
		  
		  
		  
		  $pay->SetSuccessConsume($newcid); 
		  

		  
		  $taskarr=$this->GetMysqlOne('seller,subject,content,time'," ".$this->GetTable('task')." WHERE tid='$this->tid'");
		  
		  //�ӿ�
		  $this->Port(array(
							
							//Login
							'login_uid'=>$this->uid,
							
							//Credit
							'credit_uid'=>$this->uid
							
							//WeiBo
							
							
							
							));
		  
		  if(PHPAPP::$config['task_seller_payauto']>0){
		  
		         $this->UpdateTaskProcess(4,$this->tid);
		  
		  }else{
			     
				 $this->UpdateTaskProcess(3,$this->tid);

		  }
		  
		  //����ʱ��
		  $endtime=$this->NowTime() +(24*60*60*$taskarr['time']);
		  
		  $this->Update('task',array('endtime'=>$endtime),array()," WHERE uid='$this->uid' AND tid='$this->tid'");
		  
		  
		  $send_subject='������֧��������!';
		  $send_content='�𾴵ķ�����,������֧��������,��������������� <a href="'.SURL.'/member.php?app='.$this->app.'&action=5&tid='.$this->tid.'&op=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>';	
		  
								
		  $this->Port(array(
																				
		      //SMS
		      'receive_uid'=>$taskarr['seller'], //�ռ���
				
			  //SMS
			  'sms_subject'=>$send_subject,
			  'sms_content'=>$send_content,
							
			  //EMail
			  'email_title'=>$send_subject,
			  'email_content'=>$send_content,

			  //Mobile
			  'mobile_content'=>$send_subject

						
		 ),6);
		  
		  
		  echo '֧���ɹ�!';
							 
		  echo $this->CloseNowWindows('#loading',1);

	}
		
	
	
	
	
	function SellServiceManageAction(){
		
		   $tid=intval($this->GET['tid']);
		   $task=$this->GetMysqlOne('*'," ".$this->GetTable('task')." WHERE tid='$tid' AND seller='$this->uid'");
		
		   if($this->GET['op']==3){
			   
			        if($task['tid']>0 && $task['seller']==$this->uid){
						  
						  if($task['status']>0){
							   
							    echo '<p>���Ѿ����ù���!</p>';
							  
						  }else{
							    
								$agree=intval($this->GET['agree']);
								
								if(!$agree){
									 $agree=2;
							    }
								
								
								$disagree=$this->str($this->POST['disagree'],200,1,0,1,0,1);

								$this->Update('task',array('status'=>$agree,'disagree'=>$disagree),array()," WHERE seller='$this->uid' AND tid='$tid'");
								
								if($agree==2){
								        $send_subject='�����̲�ͬ��������Ҫ��!';
										
										if($disagree){
											   $disagree='�ܾ���Ϣ���£�</p><p>'.$disagree;
										}else{
											   $disagree='</p><p>������δ��д�ܾ���Ϣ��';
										}
										
										$send_content='<p>�𾴵Ĺ���,�����̲�ͬ�����ķ���Ҫ��'.$disagree.'</p><p><a href="'.SURL.'/member.php?app='.$this->app.'&action=6&tid='.$tid.'&op=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a></p>';

								}else{
										$send_subject='��������ͬ��������Ҫ��!';
										$send_content='�𾴵Ĺ���,��������ͬ�����ķ���Ҫ��,����֧�������� <a href="'.SURL.'/member.php?app='.$this->app.'&action=6&tid='.$tid.'&op=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>';
								}
								
								$this->Port(array(
																				
									 //SMS
									 'receive_uid'=>$task['uid'], //������
						
							
									  //SMS
									  'sms_subject'=>$send_subject,
									  'sms_content'=>$send_content,
													
									  //EMail
									  'email_title'=>$send_subject,
									  'email_content'=>$send_content,
			
									  //Mobile
									  'mobile_content'=>$send_subject
								
											  
							   ),3);
								
							  
								echo '<p>�����ɹ�!</p>';
								
						  }
						   
				           echo $this->CloseNowWindows('#loading',1);
						   
						   
					}else{
						
						   echo '<p>���񲻴���!!</p>';
				           echo $this->CloseNowWindows('#loading');

					}
			   
			   
		
		   }elseif($this->GET['op']==1){
				
					
					if($task['tid']>0 && $task['seller']==$this->uid){
						   
						   $nowdate=@date("Y,m,d,H,i,s");
						   $taskendtime=@date('Y,m,d,H,i,s',$task['endtime']);  	
						   
						   $draft=$this->GetMysqlOne('*'," ".$this->GetTable('task_draft')." WHERE tid='$tid' AND uid='$this->uid'");
	                       
						   $buyersinfo=$this->GetLoginInfo($task['uid'],1);
						   $sellerinfo=$this->GetLoginInfo($task['seller'],1);

						   include $this->Template('show');
						   
					}else{
						
						  $this->Refresh('���񲻴���!','member.php?app='.$this->app.'&action=6');
					}
			
			}elseif($this->GET['op']==2){
			 
					if($this->POST['oderid']){
							 
						  
							 $oderid=$this->ExplodeStrArr($this->POST['oderid']);
							 $idarray=explode(',',$oderid);
							 
							 foreach($idarray as $value){
								 
								    $this->Update('task',array('process'=>9),array()," WHERE seller='$this->uid' AND tid='$value'");
						            
									
									$sellerinfo=$this->GetLoginInfo($this->uid,1);
									
								    $send_subject=$sellerinfo['username'].'�����Ĺ������񲻸���Ȥ,TA�ر�������';
									$send_content=$sellerinfo['username'].'�ر��˹������� <a href="'.SURL.'/member.php?app='.$this->app.'&action=6&tid='.$value.'&op=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>';
									
									$task=$this->GetMysqlOne('uid'," ".$this->GetTable('task')." WHERE tid='$value'");
									
									$this->Port(array(
													
										   //SMS
										  'receive_uid'=>$task['uid'], //�ռ���
									
										
										  //SMS
										  'sms_subject'=>$send_subject,
										  'sms_content'=>$send_content,
														
										  //EMail
										  'email_title'=>$send_subject,
										  'email_content'=>$send_content,
				
										  //Mobile
										  'mobile_content'=>$send_subject
																
																			  
									),4);
																
																
									echo $value.'�رճɹ�!<br />';
									
							 }
							 
							
							 echo $this->CloseNowWindows('#loading',1);
					}
					 
					 
					exit();
					 
			 }else{
					
					include_once(Core.'/class/pages_class_phpapp.php');
					 
					 
					  switch ($this->GET['sort']) {
								case '1':
								$sort=" AND process='1'";
								break;
								case '2':
								$sort=" AND process='2'";
								break;
								case '3':
								$sort=" AND process='3'";
								break;
								case '4':
								$sort=" AND process='4'";
								break;
								case '5':
								$sort=" AND process='5'";
								break;
								default:
								$sort='';
						}
			   
					 $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=6&sort='.$this->GET['sort'],"SELECT * FROM ".$this->GetTable('task')." WHERE seller='$this->uid' $sort ORDER BY tid DESC");
			   
  
			   
					 $list=$page->ShowResult();
		   
				   
					 $getprocess=new TaskProcess();
					 
					 
					 include $this->Template('task_seller_member');
			 }

	
	}
	

    function TaskCreditAction(){
		
		  include_once(Core.'/class/pages_ajax_class_phpapp.php');

		 
		  $ajaxpage=new AjaxPages(20,$this->GET['page'],$this->tid,$this->GET['sqlorder'],$this->GET['iforder'],'AjaxCredit',"SELECT a.*,b.username FROM  ".$this->GetTable('task_order_credit')." AS a LEFT JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid  WHERE a.tid='$this->tid' AND a.type=2 "); 
		
		  $list=$ajaxpage->ShowResult();

		  include $this->AppsView('credit');
	} 

	
	
	
	function ShowMessageAction(){
		
		
		   include_once(Core.'/class/pages_ajax_class_phpapp.php');

		   $tid=intval($this->GET['tid']);
		   
		   $order='ORDER BY mid DESC';
			
		   $ajaxpage=new AjaxPages(10,$this->GET['page'],$tid,$this->GET['sqlorder'],$this->GET['iforder'],'AjaxMessage',"SELECT a.*,b.username FROM  ".$this->GetTable('task_message')." AS a LEFT JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid WHERE a.tid='$tid' $order");

           $list=$ajaxpage->ShowResult();
   
		   include $this->AppsView('message');
		  
		  
	}
   
   
    function  AddMessageAction(){
		
		  if($this->POST['Submit']){	
		  
				 $uid=$this->uid;
						
				 if($uid>0){
					   /*
					    $allow=$this->CheckAllow('task_seller_usergroup',array(
															'messagetask'=>''
													 )
											 );
							*/	
							
							$allow='ok';
			            if($allow=='ok'){
			 
			 
			 
								$this->tid=$this->POST['tid'];
								
								$strings=new CharFilter($this->POST['content']);
								if(empty($this->POST['content'])){
									 echo '��������������!';
									 echo $this->CloseNowWindows('#loading');
								}elseif($strings->CheckLength(5)){ 
									 echo '�Բ���,���Բ�����5����!';
									 echo $this->CloseNowWindows('#loading');
								}else{
									
									 //����
									 $content=$this->str($this->POST['content'],200,0,1,1,0,1);
									 
									 if($this->tid!=0){
										   
										   $task=$this->GetMysqlOne('seller,uid,subject,process'," ".$this->GetTable('task')." WHERE tid='$this->tid'");
										 

										   if($task['process']==6){
											   
											     echo '�÷����ѹر�!���ܲ���<br />';
											   
										   }else{
											   
											     $newid=$this->Insert('task_message',array('appid'=>82,'uid'=>$uid,'tid'=>$this->tid,'content'=>$content,'dateline'=>$this->NowTime()),array());
										   
												 if($task['uid']!=$this->uid){
													 
										
														  $this->Port(array(	 		
																  
																  'login_uid'=>$this->uid,
													
																   'receive_uid'=>$task['uid'], //������
																   
																  //SMS
															 
																  'sms_subject'=>$this->username.'����'.$this->tid.'�ŷ���������!',
																  'sms_content'=>$this->username.'����'.$this->tid.'�ŷ��������ˣ�<a href="member.php?app='.$this->app.'&action=6&tid='.$this->tid.'&op=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>',
																  
																 //EMail
															 
																  'email_title'=>$this->username.'����'.$this->tid.'�ŷ���������!',
																  'email_content'=>$this->username.'����'.$this->tid.'�ŷ��������ˣ�<a href="'.SURL.'/member.php?app='.$this->app.'&action=6&tid='.$this->tid.'&op=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>',
																	  
																	  
																 //Mobile
																 
																 'mobile_content'=>$this->username.'����'.$this->tid.'�ŷ���������!'
															  
														 ),8);
														  
												 }else{
													 
													   $this->Port(array(	 		
																  
																  'receive_uid'=>$task['seller'], //������
																  
																  //SMS

																  'sms_subject'=>$this->username.'��'.$this->tid.'�ŷ�����������!',
																  'sms_content'=>$this->username.'��'.$this->tid.'�ŷ����������ˣ�<a href="member.php?app='.$this->app.'&action=5&tid='.$this->tid.'&op=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>',
																  
																 //EMail
												
																  'email_title'=>$this->username.'��'.$this->tid.'�ŷ�����������!',
																  'email_content'=>$this->username.'��'.$this->tid.'�ŷ����������ˣ�<a href="'.SURL.'/member.php?app='.$this->app.'&action=5&tid='.$this->tid.'&op=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>',
																	  
																	  
																 //Mobile
													
																 'mobile_content'=>$this->username.'��'.$this->tid.'�ŷ�����������!'
															  
														 ),8);
													 
													 
												 }
												 
												 
												 
												 
												 if($newid){
													 
													 
													  //����ͳ��
													  $total=$this->IsSQL('task_message',"WHERE tid='$this->tid'");
													 
													  $this->Update('task',array('task_message'=>$total),array(),"WHERE tid='$this->tid'");
																  
																  
																  
													  echo '�������Գɹ�!<br />';
												 }else{
													  echo '��������ʧ��!<br />';
												 }
												 
										   
										   }
										   
										   echo $this->CloseNowWindows('#loading');
										
									 }else{
										
										   echo '����ID����!<br />';
										   echo $this->CloseNowWindows('#loading');
											
									 }
									
				
								}
						}else{
							  echo '<p>'.$allow.'</p>';
			                  echo $this->CloseNowWindows('#loading');
						}
						
						
				 }else{
					   echo '��ѡ���¼�����!<br />';
					   echo $this->CloseNowWindows('#loading');
		
				 }
				
		
		  }else{
			  
			    include $this->AppsView('addmessage');
			  
		  }
		
		
	}
	
	
	public function AddProjectAction(){
		
		    $tid=intval($this->GET['tid']);
		    $task=$this->GetMysqlOne('*'," ".$this->GetTable('task')." WHERE tid='$tid' AND uid='$this->uid'");
	 
			if($task['process']>2){
				   
				   echo '���Ѿ�֧�����ˣ�';
				   echo $this->CloseNowWindows('#loading');
			}else{
			
					if($task['tid']>0 && $task['uid']==$this->uid){
								
								   
						   include $this->Template('project');
								   
					}else{
						
						  $this->Refresh('���񲻴���!','member.php?app='.$this->app.'&action=6');
					}
			}

		 
	}
	
	
	public function BuyServiceAction(){
		   
		   
		   $tid=intval($this->GET['tid']);
		   $task=$this->GetMysqlOne('*'," ".$this->GetTable('task')." WHERE tid='$tid' AND uid='$this->uid'");

		    
		   if($this->GET['op']==4){
			   
			     	if($task['tid']>0 && $task['uid']==$this->uid){
						
						   
						   if($this->IsSQL('task',"WHERE tid='$this->tid'") && $this->IsSQL('task_draft',"WHERE tid='$this->tid'")){
										   
									//����Ƿ����ù�
									if(!$this->IsSQL('task',"WHERE tid='$this->tid' AND draft_success=1")){
											   
												 $this->Update('task',array('draft_success'=>1),array(),"WHERE  tid='$this->tid'");
												 
		
												 $draft=$this->GetMysqlOne('a.uid,a.did,a.tid,b.subject,c.username'," (".$this->GetTable('task_draft')." AS a LEFT JOIN ".$this->GetTable('task')." AS b ON a.tid=b.tid) LEFT JOIN ".$this->GetTable('member')." AS c ON a.uid=c.uid  WHERE a.tid='$this->tid'");
												  
												 
												 $draftid=$draft['did'];
												 
												 //���ɶ���-------------------------------------------------------------------------------------
		                                        
												 if(!$this->IsSQL('task_order',"WHERE did='$draftid' AND tid='$this->tid'")){
													 
													   
													   if($this->IsSQL('task',"WHERE tid='$this->tid' AND process>1")){
															 $process=2;
													   }else{
															 $process=1;
													   }
													   

													   $serial=$this->GetOrderNumber();
													   
													   $fee=$this->GetTaskFeeValue('task_seller_usergroup','taskfee',$task['money'],0,$draft['uid']);
																					   
													   
													   
													   //Create Consume
                                                       //�Ƿ��й�
													   
													   $order=$this->Insert('task_order',array('buyeruid'=>$task['uid'],'selleruid'=>$draft['uid'],'did'=>$draftid,'tid'=>$this->tid,'money'=>$task['money']-$fee,'sum'=>$task['money'],'dateline'=>$this->NowTime()),array());
													  
	
									   
													   $cid=$this->SetConsume(array(
															   'subject'=>$task['subject'], 
															   'appid'=>intval($this->app),
															   'serial'=>$serial,
															   'process'=>$process,
															   'oid'=>$order,
															   'amount'=>$task['money']-$fee,
															   'fee'=>$fee,
															   'paytype'=>1, //��������
															   'payout'=>0,
															   'payin'=>$draft['uid']    //������ID
															   
														 ));
													  
													   
													   
												 }
												 
							
												 //���ɶ�������----------------------------------------------------------------------------------
												 
												 
											  //����
												  $autodelivery=intval(PHPAPP::$config['task_auto_delivery']);
												  
												  $closetime=$this->NowTime()+($autodelivery*24*60*60);
												  
												  
												  include_once(Core.'/class/auto_class_phpapp.php');
	
												  $auto=new AUTO();
												  
												  $runid=$auto->SetAutoRun(array(
														'app'=>49,
														'runtime'=>$closetime,
														'function'=>'CloseOrder',
														'oid'=>$order,
														'cid'=>$cid,
														'did'=>$draftid,
														'tid'=>$this->tid
												  ));
												  
												  $this->Update('task_order',array('closetime'=>$closetime,'workdate'=>$autodelivery,'runid'=>$runid,'cid'=>$cid),array(),"WHERE oid='$order'");
						 
												 
												 
												 //�б�֪ͨ-------------------------------------------------------------------------------------
                                                 $send_op='';
														   
											     $send_subject=$draft['username'].'����'.$draftid.'�ŷ�����Ʒ����Ѳ�����!';
											   
											     $send_content=$draft['username'].'����'.$draftid.'�ŷ�����Ʒ����Ѳ����ˣ�<a href="'.SURL.'/member.php?app=48&action=2&oid='.$order.'" target="_blank"><span class="show_details">[�鿴����]</span></a>';

												  require_once(APPS.'/apppay/class/process_class_phpapp.php');
												  $getprocess=new TaskProcess();
												  $send_op='<p>��������Դ����ȷ�Ͻ���,'.$getprocess->GetSellerProcessMenu('task_order_credit',$cid).'</p>';
									
												 
												  $this->Port(array(
													  
														 'login_uid'=>$this->uid,
														
														  //Credit
														  'credit_uid'=>$this->uid,
														  
														  'receive_uid'=>$draft['uid'], //������
														  
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
												  
												 
												 //�б�֪ͨ����-------------------------------------------------------------------------------------
												 
	
													   echo '�����ɹ�,�ȴ����ҽ����У�<br />';
													   
												       echo $this->AjaxRefresh(SURL.'/member.php?app=48&action=4&oid='.$order,3);
												 
					
										   }else{
											     
												 echo '�Բ��������Ѿ����ò��ɹ��ˣ�<br />�ȴ����ҷ���<br />';
												 echo $this->CloseNowWindows('#loading');
		
										   }
										   
									
					
						}else{
							  echo '�Բ�������δ�ύ��Ʒ���ܲ��ɣ�<br />';
							  echo $this->CloseNowWindows('#loading');
						}

						  
						   
					}else{
						
						  $this->Refresh('���񲻴���!','member.php?app='.$this->app.'&action=6');
					}
					
					
					
					
		   }elseif($this->GET['op']==1){
					
					
					if($task['tid']>0 && $task['uid']==$this->uid){
						
						   $nowdate=@date("Y,m,d,H,i,s");
						   $taskendtime=@date('Y,m,d,H,i,s',$task['endtime']);  	
  
						   $draft=$this->GetMysqlOne('*'," ".$this->GetTable('task_draft')." WHERE tid='$this->tid' LIMIT 0,1");
						   
						   $buyersinfo=$this->GetLoginInfo($task['uid'],1);

						   $sellerinfo=$this->GetLoginInfo($task['seller'],1);
							
						   include $this->Template('show');
						   
					}else{
						
						  $this->Refresh('���񲻴���!','member.php?app='.$this->app.'&action=6');
					}
			
			}elseif($this->GET['op']==2){
			 
					if($this->POST['oderid']){
							 
						  
							 $oderid=$this->ExplodeStrArr($this->POST['oderid']);
							 $idarray=explode(',',$oderid);
							 
							 foreach($idarray as $value){
									$this->Delete('task'," WHERE uid='$this->uid' AND tid='$value' ");
									echo $value.'�ŷ���ɾ���ɹ�!<br />';
							 }
							 
							
							 echo $this->CloseNowWindows('#loading',1);
					}
					 
					 
					exit();
					 
			 }else{
					
					include_once(Core.'/class/pages_class_phpapp.php');
					 
					 
					  switch ($this->GET['sort']) {
								case '1':
								$sort=" AND process='1'";
								break;
								case '2':
								$sort=" AND process='2'";
								break;
								case '3':
								$sort=" AND process='3'";
								break;
								case '4':
								$sort=" AND process='4'";
								break;
								case '5':
								$sort=" AND process='5'";
								break;
								default:
								$sort='';
						}
			   
					 $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=6&sort='.$this->GET['sort'],"SELECT * FROM ".$this->GetTable('task')." WHERE uid='$this->uid' $sort ORDER BY tid DESC");
			   
  
			   
					 $list=$page->ShowResult();
		   
				   
					 $getprocess=new TaskProcess();
					 
					 
					 include $this->Template('task_member');
			 }

	
			
			
			
	}
	
	public function DeleteService($sid=0){
		  
		  $service=$this->GetMysqlOne('*'," ".$this->GetTable('task_seller_service')." WHERE sid='$sid' AND uid='$this->uid'");

		  $file=new DeleteFile();
		  
		  //ɾ������
		  $file->SetDeleteFile($service['logo']);
		  
		  //ɾ���ļ�
		  $servicearr=$this->GetMysqlArray('fid,id'," ".$this->GetTable('apps_file')." WHERE id='$sid' AND uid='$this->uid' AND type=1 ");
		  
		  foreach($servicearr as $value){
				 $file->SetDeleteFile($value['fid']);
		  }
		  
		  $this->Delete('apps_file'," WHERE id='$sid' AND uid='$this->uid' AND type=1 ");
		  
		  $this->Delete('task_seller_service'," WHERE sid='$sid' AND uid='$this->uid' ");
	}
	
	
	
	public function ServiceManageAction(){
		  
		  
		   if($this->GET['op']==4){
			    
			   if($this->POST['setclose']){
			   
					 $oderid=$this->ExplodeStrArr($this->POST['sid']);
					 $idarray=explode(',',$oderid);
					 
					 foreach($idarray as $value){
							$this->Update('task_seller_service',array('status'=>1),array()," WHERE sid='$value' AND uid='$this->uid' ");
					 }
					 
					 $msg='<p>���ùرճɹ�!</p>';
					  
					 if($this->IsWap()){
						  
						   $this->Refresh($msg,SURL.'/member.php?app='.$this->app.'&action=3');
					 }else{
						  echo $msg;
					      echo $this->CloseNowWindows('#loading',1);
					 }
			   }
			   
		
		  }elseif($this->GET['op']==3){
			    
			   if($this->POST['setsell']){
			   
					 $oderid=$this->ExplodeStrArr($this->POST['sid']);
					 $idarray=explode(',',$oderid);
					 
					 foreach($idarray as $value){
							$this->Update('task_seller_service',array('status'=>0),array()," WHERE sid='$value' AND uid='$this->uid' ");
					 }
					 
					 $msg='<p>���ó��۳ɹ�!</p>';
					  
					 if($this->IsWap()){
						  
						   $this->Refresh($msg,SURL.'/member.php?app='.$this->app.'&action=3');
					 }else{
						  echo $msg;
					      echo $this->CloseNowWindows('#loading',1);
					 }
			   }
			   
		
		  }elseif($this->GET['op']==2){
			    
			   if($this->POST['deleteall']){
			   
					 
					 $servicearr=$this->GetMysqlArray('sid'," ".$this->GetTable('task_seller_service')." WHERE uid='$this->uid' ");
					 
					 
					 foreach($servicearr as $value){
					   
					      $this->DeleteService($value['sid']);

				     }
					 
					 $msg='<p>ɾ���ɹ�!</p>';
					  
					 if($this->IsWap()){
						  
						   $this->Refresh($msg,SURL.'/member.php?app='.$this->app.'&action=3');
					 }else{
						  echo $msg;
					      echo $this->CloseNowWindows('#loading',1);
					 }
			   }
			   
		
		  }elseif($this->GET['op']==1){
			  
	
				   $oderid=$this->ExplodeStrArr($this->POST['sid']);
				   $idarray=explode(',',$oderid);
				   
				   foreach($idarray as $value){
					   
					      $this->DeleteService($value);

				   }
				   
				   $msg='<p>ɾ���ɹ�!</p>';
				   
				   if($this->IsWap()){
					     $this->Refresh($msg,SURL.'/member.php?app='.$this->app.'&action=3');
				   }else{
					     echo $msg;
				         echo $this->CloseNowWindows('#loading',1);
				   }
			  
		  }else{
		  
				 include_once(Core.'/class/pages_class_phpapp.php');
		  
	  
				 $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=3',"SELECT * FROM ".$this->GetTable('task_seller_service')." WHERE uid='$this->uid' ORDER BY dateline DESC");
				   
				   
				 $list=$page->ShowResult();
				 
					   
				 include $this->Template('service_member');
		  }
		
	}
	
	public function SubmitServiceForm($errors='',$isrefresh=0){
		    
			$refreshurl='';
		    if($isrefresh>0){
				 $refreshurl='window.parent.location.href=\''.$this->MakeGetParameterURL().'\'';
			}
			
			echo '<script type="text/javascript">alert("'.$errors.'");window.parent.document.getElementById("SubmitAdd").style.display="block";window.parent.document.getElementById("IsSubmit").style.display="none";'.$refreshurl.'</script>';
			exit();
	}
	
	public function AddServiceAction(){
		   
		   if($this->sid>0){
			   
			      $service=$this->GetMysqlOne('*'," ".$this->GetTable('task_seller_service')." WHERE sid='$this->sid' AND uid='$this->uid' ");
			      
				  
				  if(!$service['sid']){
					    
						$this->Refresh('�Բ���,���񲻴���!','member.php?app='.$this->app.'&action=3');
				 
				        exit();
					  
				  }
			   
		   }
		   
	
		   if($this->POST['submit']){

				 if($this->CheckSecurityForm($this->POST['SecurityForm'])){
					 
					     //Ȩ��
				         if($this->sid>0){
							 
						                $allow=$this->CheckAllow('task_seller_usergroup',array(
																'edittask'=>''
																)
														 );
							 
						 }else{
						                $allow=$this->CheckAllow('task_seller_usergroup',array(
																'addtask'=>'',
																'addnumbertask'=>'',
																'maxmoneytask'=>floatval($this->POST['price']), //������������йܽ��
																'smallmoneytask'=>floatval($this->POST['price']) //������������йܽ��
																)
														 );
						 }
				    
						 if($allow=='ok'){
					   
					             
								 $fieldnum=count($this->GetTableFieldArray('task_seller_service'));
								  
														   
								 if($this->CheckService()==(6+$fieldnum)){
					 
					           				   
										//����
										include_once(Core.'/class/photo_upload_phpapp.php');
		
					  
										 if($_FILES['logophoto']['size']>0){
											   
											   if($_FILES['logophoto']['size']> intval(PHPAPP::$config['oneimageuploadsize'])){
														$errors='�Բ���!���ϴ���ͼƬ���ܳ��� '.(PHPAPP::$config['oneimageuploadsize']/1024).'KB,�������ϴ���'; 										                                                        
														$this->SubmitServiceForm($errors);
														//$this->Refresh($errors,'member.php?app='.$this->app.'&action=1');							   
											   }
											   
											   $logoid=empty($service['logo']) ? 0 : intval($service['logo']);
											   
											   $upload=new UploadPhoto($_FILES['logophoto'],$logoid,180,180);
											   $logophoto=$upload->CheckUpload();
											   
										 }else{
											   
											   if(!empty($service['logo'])){
												     
													 $logophoto=intval($service['logo']);
												   
												   
											   }
											   
											   /*
											   else{
												   
													 $this->Refresh('�Բ���,���ϴ��������ͼƬ!','member.php?app='.$this->app.'&action=1');
													 
													 exit();
													 
											   }
											   */
											  
										 }
									  
									  
									   $description=$this->str($this->POST['content'],200,0,1,1,0,1);
									   if(strlen($this->POST['content'])>200){
											  $description.='...';
									   }
									  
					 
					                   if($this->sid>0){

											  $this->Update('task_seller_service',$this->POST,array('dateline'=>$this->NowTime(),'logo'=>$logophoto,'keywords'=>$this->POST['subject'],'description'=>$description)," WHERE sid='$this->sid' AND uid='$this->uid'");
											
									   }else{
										   
											  $this->sid=$this->Insert('task_seller_service',$this->POST,array('appid'=>$this->app,'logo'=>$logophoto,'uid'=>$this->uid,'dateline'=>$this->NowTime(),'keywords'=>$this->POST['subject'],'description'=>$description));
											 
											  //URL
									          $serviceurl=$this->GetServiceURL($this->sid,$this->uid);
											  $this->Update('task_seller_service',array('url'=>$serviceurl),array()," WHERE sid='$this->sid' AND uid='$this->uid'");
									   
									   }
									   
									  
									
									   $allow=$this->CheckAllow('task_seller_usergroup',array(
																					'uploadfilestask'=>''
																				 )
																	 );
													
													
										if($allow=='ok'){
									   
												   //�ϴ��ļ�
												   $files=$this->UploadFile();
												   
												   if($files){
														 foreach($files as $fid){
															  $this->Insert('apps_file',array('appid'=>$this->app,'fid'=>$fid,'uid'=>$this->uid,'id'=>$this->sid,'type'=>1),array());
														 }
														 
														 $this->ReplaceFileContent($files,'task_seller_service',$this->POST['content']," WHERE sid='$this->sid' ");
												   }
										}else{
											
											  //echo '<p>'.$allow.'</p>';
											  
											  $this->SubmitServiceForm($allow);
											
										}
										
										
                                       $this->UpdateCategoryCount('task_seller_service',$this->POST['catid'],'','');
									   
									   $servicenum=$this->IsSQL('task_seller_service',"WHERE status=0 AND uid='$this->uid'");
			
		                               $this->UpdateTaskCount('servicenum',$servicenum,$this->uid);
									   
									   //$this->Refresh('�����ɹ�!','member.php?app='.$this->app.'&action=3');
									   
									   //header('Location:'.SURL.'/member.php?app='.$this->app.'&action=2&sid='.$this->sid); 
									   
									   echo '<script type="text/javascript">window.parent.document.location.href=\''.SURL.'/member.php?app='.$this->app.'&action=2&sid='.$this->sid.';\'</script>';
									 
					 
					 
				                 }else{
									   
									   $errors='';
									   
									   if($this->errors){
											  foreach($this->errors as $value){
												   if($errors){
													    $errors=','.$value;
												   }else{
												        $errors=$value;
												   }
											  }
									   }
									   
									   
									  $this->SubmitServiceForm($errors);
									  
									   //$this->Refresh($errors,'member.php?app='.$this->app.'&action=1');
								 }
						 }else{
							 
							   $errors='';
							   
							   foreach($allow as $value){
									   if($errors){
											$errors=','.$value;
									   }else{
											$errors=$value;
									   }
							   }
				 
							   $this->SubmitServiceForm($errors);
							   
							   //$this->Refresh($errors,'member.php?app='.$this->app.'&action=3');
						 }
				 
				 
				  }else{
					  
						//$this->Refresh('�ύ���ѹ���!','member.php?app='.$this->app.'&action=1');
						
						$this->SubmitServiceForm('�ύ���ѹ��ڣ������´򿪷��񷢲�ҳ�棡');
				  }
				 
				 
				 
			   
			   
		   }else{
		  
		            include $this->Template('addservice');
		   }
		  
	}
	

	function ServiceConfirmAction(){
         
		   $service=$this->GetMysqlOne('a.*,b.usertype,b.username'," ".$this->GetTable('task_seller_service')." AS a LEFT JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid WHERE a.sid='$this->sid' AND a.uid='$this->uid' ");
         
		   if($service){
			     $buyservice=array();
			     $totalservice=0;
		         $ismap=0;
				 if($props=$service['props']){
					  $servicelist=$this->GetMysqlArray('a.sid,a.subject,a.price,a.icon,b.amount,a.appid'," (SELECT sid,subject,price,icon,appid FROM ".$this->GetTable('prop')." WHERE sell='0' AND sid IN($props)  ORDER BY displayorder ASC ) AS a LEFT JOIN (SELECT sid,amount FROM ".$this->GetTable('prop_order')." WHERE uid='$service[uid]' AND sid IN($props) ) AS b ON a.sid=b.sid");
					  
					  if($servicelist){
							foreach($servicelist as $servicearr){
								   if($servicearr['appid']==72){
									     $ismap=1;
								   }
								   if(!$servicearr['amount']){
										 $totalservice+=$servicearr['price'];
										 $buyservice[]=$servicearr['sid'];
								   }
							}
					  }
				 }
						 
				 if($this->POST['Submit']){
					    
						 if($ismap){

								$member=$this->GetMysqlOne('username,usertype'," ".$this->GetTable('member')." WHERE uid='$this->uid'");
						 
								$membertable=$this->GetTypeMember($member['usertype']);
						 
								$info=$this->GetMysqlOne('*',"  ".$this->GetTable($membertable)."  WHERE uid='$this->uid'");

								if(!$info['residelatitude'] || !$info['residelongitude']){
									   echo '<p>�Բ�����ʹ���˵�ͼ��λ���������õ�ͼλ��.</p>';
									   echo $this->CloseNowWindows('#loading');	
									   exit();
								}
						}
					   
					    if($totalservice){
								  
							    //����û����ý��
								$user=$this->GetMysqlOne('*'," ".$this->GetTable('member_account')." WHERE uid='$this->uid'");
								
								if($user['money']>=($totalservice)){
								
										$this->UseServiceProp($props,$service,$buyservice,0,$this->sid);
	
								}else{
									   
									   echo '<p>���߹���ʧ�ܣ����Ŀ������� <strong>'.$totalservice.' Ԫ</strong> ,���ֵ���ٹ�����ߣ�</p>';
	
								}
							
							 
					    }else{
							
							   $this->UseServiceProp($props,$service,$buyservice,0,$this->sid);
						  
					    }
						
						echo '<p>�����ɹ���</p>';
						
						echo $this->AjaxRefresh(SURL.'/member.php?app='.$this->app.'&action=3',3);
					 
				 }else{
		
						 include $this->AppsView('confirm');
				 }
		   }else{
			    $this->Refresh('���񲻴��ڻ��ѱ�ɾ��!','member.php?app='.$this->app.'&action=3');
		   }
	}
	
	function CheckService(){
		
		        $checknum=0;
				
				$this->POST['catid']=empty($this->POST['catid']) ? '' : $this->POST['catid'];
				
		        //����
				foreach($this->POST as $key=>$value){
				
					   switch($key){
					          case 'subject':
							  
							       $strings=new CharFilter($this->POST['subject']);
								   
								   if(empty($this->POST['subject'])){
							             $this->errors[]='���������!';
								   //}elseif($strings->CheckSpace()){
							             //$this->errors[]='�Բ���,���⺬�зǷ�����!';	 
								   }elseif($strings->CheckLength(5)){  
										 $this->errors[]='�Բ���,���ⲻ����5����!';
								   }elseif($strings->CheckShort(50)){ 
										 $this->errors[]='�Բ���,����̫����!';
								   }else{
									     $checknum+=1;
								   }
		
					          break;
							  case 'price':
							       if(empty($this->POST['price'])){
							             $this->errors[]='������۸�!';
									
								   }elseif($this->POST['price']<1){
										  $this->errors[]='�۸���Ϊ0Ԫ!';
							       }else{
									     $this->POST['price']=floatval($this->POST['price']);
									     $checknum+=1;
								   }
					          break;
							  
							  case 'unit':
							       if(empty($this->POST['unit'])){
							             $this->errors[]='�����뵥λ!';
								   }else{
									     $this->POST['unit']=$this->str($this->POST['unit'],5,1,0,1,0,1);
									     $checknum+=1;
								   }
					          break;
							  
							  case 'time':
							  
							       if(empty($this->POST['time'])){
							             $this->errors[]='������ʱ��!';
								   }elseif($this->POST['time']<1){
									     $this->errors[]='ʱ�䲻��Ϊ0!';
								   }else{
									     $this->POST['time']=intval($this->POST['time']);
									     $checknum+=1;
								   }
					          break;
							  
							  case 'content':
									$strings=new CharFilter($this->POST['content']);
									if(empty($this->POST['content'])){
										 $this->errors[]='����������!';
									}elseif($strings->CheckLength(5)){ 
										 $this->errors[]='�Բ���,���ݲ�����5����!';
									}else{
									     $checknum+=1;
								    }
							  break;
							  
							  case 'catid':
						
							       if(empty($this->POST['catid']) || $this->POST['catid']<0){
							             $this->errors[]='��ѡ�����!';
							       }else{
									     $checknum+=1;
								   }
							  
							  break;
							  
					   }
				}	
				
				
			   //�Զ����ֶ�---------------------------------------------------
			   
			   $fieldresult=$this->GetTableFieldResult('task_seller_service',$this->POST);
			   
               if($fieldresult['checknum']){
				   
					 $checknum+=$fieldresult['checknum'];
					 
					 if($fieldresult['errors']){
						  foreach($fieldresult['errors'] as $value){
								$this->errors[]=$value;
						  }
					 }
					 
					 $this->POST=$fieldresult['post'];
			   
			   }
			   
			   //�Զ����ֶ� end---------------------------------------------------
	
		       return $checknum;
	}
	
	
	function EditTaskAction(){
		 

           $task=$this->GetMysqlOne('*'," ".$this->GetTable('task')." WHERE tid='$this->tid' AND uid='$this->uid' AND process=1 ");
		   
		   if($task){
                
				
				
		        include $this->AppsView('edittask_member');
		   }else{
			   
			    echo '<p>���񲻴���!</p>';
				echo $this->CloseNowWindows('#loading');
		   }
		
	}
	
	
	function TaskManageAction(){
		
		     $task=$this->GetMysqlOne('*'," ".$this->GetTable('task')." WHERE tid='$this->tid'");
		     
			 if($this->GET['op']==7){
				 
				  if($task){
					      
						  if($task['uid']==$this->uid){
							  
							      $content=$this->str($this->POST['content'],200,1,0,1,0,1);
								  
								  if(!$this->IsSQL('task_refund',"WHERE uid='$this->uid' AND tid='$this->tid' AND status>0 ")){
									   
									   
									    $this->Insert('task_refund',array('uid'=>$this->uid,'tid'=>$this->tid,'content'=>$content,'dateline'=>$this->NowTime(),'status'=>1),array());

									   
									    echo '���Ѿ�����ɹ�!';
										echo '<br />'.$this->CloseNowWindows('#loading');
								  }else{
									    echo '���Ѿ��������,��ȴ���������';
									    echo '<br />'.$this->CloseNowWindows('#loading');
								  }
								  
							  
						  }
				  }
		
			 }elseif($this->GET['op']==6){
				 
				  if($task){
					      
						  if($task['uid']==$this->uid){
							  
							       include $this->Template('refund_member');
							  
						  }
				  }
							  
			 }elseif($this->GET['op']==5){
				 
				  if($task){
					      
						  if($task['uid']==$this->uid){
							  

								$allow=$this->CheckAllow('task_seller_usergroup',array(
														'increasetask'=>'',
														'addmoneytask'=>intval($this->POST['increase'])
														)
												 );
				 
				                if($allow=='ok'){
									
									  $money=intval($this->POST['increase']);
									  
									  $member=$this->GetLoginInfo($this->uid);
								
									  if($member['money']>=$money){ 
                                              
											  $taskmoney=$task['money']+$money;
											  
											  $addmoneynum=$task['addmoneynum']+1;
											  
											  $taskaddmoney=$task['addmoney']+$money;
											  
											  //����
											  $endtime=$task['endtime'];
											  
											  $getallow=$this->GetAllow('task_seller_usergroup',array('extendmoneytask','extendnumbertask'));
											  
											  
											  $extendtime=$money/$getallow['extendmoneytask'] * $getallow['extendnumbertask'];

											  $this->Update('task',array('money'=>$taskmoney,'addmoneynum'=>$addmoneynum,'addmoney'=>$taskaddmoney,'endtime'=>$endtime+($extendtime*24*60*60),'process'=>4),array(),"WHERE tid='$this->tid'");  
											   
											   
											   @include_once(APPS.'/apppay/class/consume_class_phpapp.php');
							                   $pay=new UserConsume();
							  
											  $newcid=$pay->MakeConsume(array(
													   'subject'=>'<p>����Ӽ�</p>���ӷ��񵣱���', 
													   'appid'=>intval($this->app),
													   'process'=>1,
													   'amount'=>$money,
													   'paytype'=>1, 
													   'payout'=>$this->uid,   //֧����ID
													   'payin'=>0    //������ID
													   
												 ));
								
											  $pay->SetSuccessConsume($newcid);
  
									          echo '�Ӽ۳ɹ�!';
											  echo '<br />'.$this->CloseNowWindows('#loading',1);
									  
									  }else{
										  
										   echo '�Բ���!��������'.$money.'Ԫ,���ֵ�����!<br />';
										   
										   echo $this->AjaxRefresh('member.php?app=5&action=2',1);
										     
									  }
									  
									  
								}else{
									
									  foreach($allow as $value){
									       echo $value;
									  }
									  
									  echo '<br />'.$this->CloseNowWindows('#loading');
								}
								
								
								
							  
						  }
				  }
			
			 }elseif($this->GET['op']==4){
				 
				 if($task){
					      
						  if($task['uid']==$this->uid){
							    //Ȩ��
								$allow=$this->CheckAllow('task_seller_usergroup',array(
														'increasetask'=>''
														)
												 );
				 
				                if($allow=='ok'){
									
									     $member=$this->GetLoginInfo($this->uid);
										 
										 $getallow=$this->GetAllow('task_seller_usergroup',array('extendmoneytask','extendnumbertask','addmoneytask'));
		
									
							             include $this->Template('increase_member');
								}
							  
						  }
				 }
				 
		
			 }elseif($this->GET['op']==2 || $this->GET['op']==3){
				 
				   
				   
				   if($task){
					      
						  if($task['uid']==$this->uid){
							      
								  
								   @require_once(APPS.'/taskone/main_phpapp.php');
												
								   $taskone=new TaskOneMainControls();
								   
								   $taskone->TaskExpired($this->tid);
								   
								  
								  if($this->GET['op']==2){
									  
										  $endtime=$this->Date('Y-m-d',$task['endtime']);
										  
										  $endday=($task['endtime']-$this->NowTime())/(24*60*60);
										  
										  $hourarr=explode('.',$endday); 
										  
										  $hour='0.'.$hourarr[1];
										  
										  
										  $serviceorderarr=$this->GetMysqlArray('b.count,b.subject,c.*'," (".$this->GetTable('prop_order')." AS a  LEFT JOIN ".$this->GetTable('prop')." AS b ON a.sid=b.sid) LEFT JOIN  ".$this->GetTable('prop_consume')." AS c ON c.oid=a.oid WHERE a.uid='$this->uid' AND c.app='$this->app' AND c.tid='$this->tid'");
										  
										 
										 include $this->Template('task_config_member');
										 
								  }elseif($this->GET['op']==3){
									      
										 
												 
									      $this->POST['service']=empty($this->POST['service']) ? '' : $this->POST['service'];
										  
				                          if($this->POST['service']){
												
												 
												 $this->ConsumeService($this->POST['service']);
													   
												 echo '<p>ʹ�óɹ�</p>';
												       
												 echo $this->CloseNowWindows('#loading',1);

							 
										  }else{
									     
												 echo $taskone->AddProjectAction($this->tid);
										  }
									  
									       
								  }
								  
						  }else{
							  
							    $this->Refresh('���񲻴��ڻ���ɾ��!','member.php?app='.$this->app.'&action=42');
						  }
				   }else{
					     
						  $this->Refresh('���񲻴��ڻ���ɾ��!','member.php?app='.$this->app.'&action=42');
				   }
				 
				   
				 
		
			 }elseif($this->GET['op']==1){
				 
				  if($this->POST['oderid']){
						   
						
						   $oderid=$this->ExplodeStrArr($this->POST['oderid']);
						   $idarray=explode(',',$oderid);
				           
						   foreach($idarray as $value){
							      $this->Delete('task'," WHERE uid='$this->uid' AND tid='$value' ");
								  echo $value.'�ŷ���ɾ���ɹ�!<br />';
						   }
						   
				          
						   echo $this->CloseNowWindows('#loading',1);
				  }
				   
				   
				 
				   exit();
			 }else{
				 
		            include_once(Core.'/class/pages_class_phpapp.php');
				   
				    $sort='';
					
				    if($this->GET['sort']){
						   $sortid=$this->GET['sort'];
						   $sort=" AND process='$sortid'";
					}
			 
			       $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=42&sort='.$this->GET['sort'],"SELECT * FROM ".$this->GetTable('task')." WHERE uid='$this->uid' $sort ORDER BY tid DESC");
			 

			 
			       $list=$page->ShowResult();
		 
				 
				   $getprocess=new TaskProcess();
				   
				   
				   include $this->Template('task_member');
			 }
		
		
		
		      
	}
	
	
	
	
	
	function DraftManageAction(){
		
		
		       include_once(Core.'/class/pages_class_phpapp.php');
				   
				   
					switch ($this->GET['sort']) {
						      case '4':
							  $sort=" AND process='0'";
							  break;
							  case '1':
							  $sort=" AND process='1'";
							  break;
							  case '2':
							  $sort=" AND process='2'";
							  break;
							  case '3':
							  $sort=" AND process='3'";
							  break;
							  default:
							  $sort='';
					  }
			 
			       $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=44&sort='.$this->GET['sort'],"SELECT * FROM ".$this->GetTable('task_draft')." WHERE uid='$this->uid' $sort ORDER BY did DESC");
			 

			 
			       $list=$page->ShowResult();
		 
				 
				   $getprocess=new TaskProcess();
				   
		
		
		
		
		      include $this->Template('draft_member');
	}
	
	

	function UpdateTaskProcess($process,$tid){
		  return $this->Update('task',array('process'=>$process),array(),"WHERE tid='$tid'");
	}
	
	
	
    function AddDraftAction(){

						
		 $task=$this->GetMysqlOne('uid,subject,money'," ".$this->GetTable('task')." WHERE tid='$this->tid'");
		 
		 if($this->POST['Submit']){

				 if($this->IsSQL('task',"WHERE tid='$this->tid' AND process=4")){
					 
					     //Ȩ��
						 /*
						 $allow=$this->CheckAllow('task_seller_usergroup',array(
																'adddraft'=>'',
																'joinmoneydraft'=>floatval($task['money']), //Ͷ���ͽ�Χ
																)
														 );
						 */
						 
						 $allow='ok';
						 
						 if($allow=='ok'){
							 
						         //�Զ����ֶ�---------------------------------------------------
								 $fieldarray=$this->GetTableFieldArray('task_draft');
								 
								 foreach($fieldarray as $key=>$value){
									   
										if($value['required_phpapp']==1){
											   
											   $fieldname=$value['field_phpapp'];
											   
											   $strings=new CharFilter($this->POST[$fieldname]);
											   
											   if(empty($this->POST[$fieldname])){
													 echo '������'.$value['name_phpapp'].'!';
													 echo $this->CloseNowWindows('#loading');
													 exit();
											   }elseif($strings->CheckLength($value['smalllength_phpapp'])){  
													 echo '�Բ���,'.$value['name_phpapp'].'������'.$value['smalllength_phpapp'].'���ַ�!';
													 echo $this->CloseNowWindows('#loading');
													 exit();
											   }elseif($strings->CheckShort($value['maxlength_phpapp'])){
													 echo '�Բ���,'.$value['name_phpapp'].'̫����!';
													 echo $this->CloseNowWindows('#loading');
													 exit();
											   }
											  
										}
				  
								 }
								 
								//�Զ����ֶ� end ---------------------------------------------------
								

								  $strings=new CharFilter($this->POST['content']);
								  
								  if(empty($this->POST['content'])){
									  
										$errors='<p>����������!<p>';
										
										echo $errors;
										echo $this->CloseNowWindows('#loading');
								
										
								  }elseif($strings->CheckLength(2)){ 
								  
										$errors='<p>�Բ������ݲ�����2����!<p>';
											
										echo $errors;
										echo $this->CloseNowWindows('#loading');

										
								  }else{
										
										 $uid=$this->uid;
										
										 if($uid){
											 
												if(!$this->IsSQL('task_draft',"WHERE tid='$this->tid' AND uid='$this->uid'")){
				  
													   
													  if($uid!=$task['uid']){ 
													  
											  
																 $did=$this->Insert('task_draft',$this->POST,array('uid'=>$uid,'appid'=>82,'dateline'=>$this->NowTime(),'tid'=>$this->tid));
																 
															
																
																  /*
																 //�ϴ��ļ�
																 $allow=$this->CheckAllow('task_seller_usergroup',array(
																										'uploadfilesdraft'=>''
																										)
																								 );
																 */
																 
																 if($allow=='ok'){
																		 $files=$this->UploadFile();
																		 
																		 if($files){
																			   foreach($files as $fid){
																					$this->Insert('apps_file',array('appid'=>$this->app,'fid'=>$fid,'uid'=>$this->uid,'id'=>$did,'type'=>3),array());
																			   }
																			   $this->ReplaceFileContent($files,'task_draft',$this->POST['content']," WHERE did='$did' ");
																		 }
																 
																 }else{
																	 
																	 
																	   echo '<p>'.$allow.'</p>';
																	 
																 }
																 
                                                                 
																 $send_subject=$this->username.'����'.$this->tid.'�ŷ����ύ��Ʒ��!';
																 $send_content=$this->username.'����'.$this->tid.'�ŷ����ύ��Ʒ��! <a href="member.php?app='.$this->app.'&action=6&tid='.$this->tid.'&op=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>';
																 
																 $this->Port(array(
																			//Login
																			'login_uid'=>$this->uid,
																			
																			//Credit
																			'credit_uid'=>$this->uid,
																			
																			//SMS
							
																			'receive_uid'=>$task['uid'], //������
																					
																		  //SMS
																		  'sms_subject'=>$send_subject,
																		  'sms_content'=>$send_content,
																						
																		  //EMail
																		  'email_title'=>$send_subject,
																		  'email_content'=>$send_content,
															
																		  //Mobile
																		  'mobile_content'=>$send_subject																					
																  ),2);
																 

																 
																 if($did>0){
					
																	  echo '<p>�ύ��Ʒ�ɹ�!</p>';
																
																	  echo $this->CloseNowWindows('#loading',1);
																	
			  
																 }else{
																	  echo '�ύʧ��!<br />';
																	  echo $this->CloseNowWindows('#loading');
																 }
													  }else{
															  
															  echo '<p>�Բ��𣡲�������</p>';
														
															  echo $this->CloseNowWindows('#loading');
															
															
													  }
											   
											   }else{
													  
				
													  $this->Update('task_draft',$this->POST,array(),"WHERE tid='$this->tid' AND uid='$this->uid'");
													  
													  
													   $files=$this->UploadFile();
																		 
													   if($files){
															 foreach($files as $fid){
																  $this->Insert('apps_file',array('appid'=>$this->app,'fid'=>$fid,'uid'=>$this->uid,'id'=>$did,'type'=>3),array());
															 }
															 
															 $this->ReplaceFileContent($files,'task_draft',$this->POST['content']," WHERE did='$did' ");
													   }
													   
													   
													   	$send_subject=$this->username.'����'.$this->tid.'�ŷ������޸�����Ʒ!';
														$send_content=$this->username.'����'.$this->tid.'�ŷ������޸�����Ʒ! <a href="member.php?app='.$this->app.'&action=6&tid='.$this->tid.'&op=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>';
													   
													   $this->Port(array(
																					
											
															  'receive_uid'=>$task['uid'], //�ռ���
			
															   //SMS
															  'sms_subject'=>$send_subject,
															  'sms_content'=>$send_content,
																			
															  //EMail
															  'email_title'=>$send_subject,
															  'email_content'=>$send_content,
												
															  //Mobile
															  'mobile_content'=>$send_subject	
																		
																		
													  ),2);
													  
													  echo '<p>�޸ĳɹ�!</p>';
													  
													  echo $this->CloseNowWindows('#loading',1);
													 
													  
											   }
										 
										 
										 }else{
											 
											   $errors='<p>�Բ������¼�������</p>';
											   if($this->IsWap()){
													 $this->Refresh($errors,SURL.'/index.php?app='.$this->app.'&action=5&tid='.$this->tid);
											   }else{
													 echo $errors;
													 echo $this->CloseNowWindows('#loading');
											   }
											  
										 }
							  
						         }
								 
						 }else{
							 
							   $errors='';
							   foreach($allow as $value){
								      $errors.='<p>'.$value.'</p>';
							   }
							  
							   if($this->IsWap()){
									 $this->Refresh($errors,SURL.'/index.php?app='.$this->app.'&action=5&tid='.$this->tid);
							   }else{
									 echo $errors;
									 echo $this->CloseNowWindows('#loading');
							   }
							 
						 }
						
				 }else{
					 
					   $errors='<p>�Բ�������ǰ״̬���ܲ�����</p>';
					   if($this->IsWap()){
							 $this->Refresh($errors,SURL.'/index.php?app='.$this->app.'&action=5&tid='.$this->tid);
					   }else{
							 echo $errors;
							 echo $this->CloseNowWindows('#loading');
					   }
					  
				 }
			 
		 }else{


			   $draft=$this->GetMysqlOne('*'," ".$this->GetTable('task_draft')." WHERE tid='$this->tid' AND uid='$this->uid' ORDER BY dateline ASC");
				   

		       include $this->AppsView('adddraft');
			   
		 }
	}	

	
	function TaskReportAction(){
		     
			 $tid=$this->GET['tid'];
			 $did=$this->GET['did'];
			  
			 if($this->IsSQL('task'," WHERE tid='$tid'")){
				 
				     if($this->POST['Submit']){
						 
						   if($this->POST['content']){
							     
								
								 if($did>0){
									   
									   if(!$this->IsSQL('report',"WHERE tid='$tid' AND did='$did' AND uid='$this->uid'")){
										   
										     $this->Insert('report',array('tid'=>$tid,'did'=>$did,'uid'=>$this->uid,'content'=>$this->str($this->POST['content'],200,1,0,1,1,1),'dateline'=>$this->NowTime()),array());
										   
										     echo '<p>�ٱ��ɹ�!</p>';

									   }else{
										     echo '<p>���Ѿ��ٱ�����!</p>';
				                             
									   }  
									   
	
								 }else{
									   
									   if(!$this->IsSQL('report',"WHERE tid='$tid' AND uid='$this->uid'")){
										   
										     $this->Insert('report',array('tid'=>$tid,'uid'=>$this->uid,'content'=>$this->str($this->POST['content'],200,1,0,1,1,1),'dateline'=>$this->NowTime()),array());
										   
										     echo '<p>�ٱ��ɹ�!</p>';

									   }else{
										     echo '<p>���Ѿ��ٱ�����!</p>';
				                             
									   }
								 
								 }
								 
								 echo $this->CloseNowWindows('#loading');
							   
							   
						   }else{
							   
							    echo '<p>������ٱ�����!</p>';
				                echo $this->CloseNowWindows('#loading');
						   }
						 
						 
					 }else{
					 
					        include $this->Template('repotr');
					 }
				   
				 
			 }else{
				 
				    echo '<p>���񲻴���!</p>';
				    echo $this->CloseNowWindows('#loading');
				 
			 }


	}
	
}

?>