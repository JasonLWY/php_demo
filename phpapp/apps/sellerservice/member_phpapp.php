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
				           
		
							 //检查用户可用金额
							 $user=$this->GetMysqlOne('*'," ".$this->GetTable('member_account')." WHERE uid='$uid'");
							 
							 
							 if($user['money']>=($taskmoney)){
								 
						            //直接支付
                                    $this->TaskPayComplete($taskmoney);

					         }else{
								 
								    $paymoney=$taskmoney-$user['money'];
						
							        include_once(APPS.'/pay/main_phpapp.php');
									
							        $pay=new PayMainControls();
							        
							        $pay->UserPay('task',$paymoney,$this->tid,2);
							 }
							  
		                     exit();
							 
			 }else{
				    echo '任务不存在!';
							 
				    echo $this->AjaxRefresh(SURL,1);
			 }
		
	}
	
	function OnLineTaskPayAction(){
		
		 include_once(APPS.'/pay/main_phpapp.php');

		 $pay=new PayMainControls();
							 
		 $pay->GoPayTool($this->POST);
							 
	}
	
	function TaskPayComplete($taskmoney){
		  
		  
		  //托管任务
		  
		  include_once(APPS.'/apppay/class/consume_class_phpapp.php');

		  $pay=new UserConsume();
		  
		  $newcid=$pay->MakeConsume(array(
								  'subject'=>'购买服务担保金',  //交易名称
								  'appid'=>$this->app, 
								  'paytype'=>1, 
								  'process'=>1, 
								  'amount'=>$taskmoney, 
								  'payout'=>$this->uid, 
								  'payin'=>0   // 收入者
								  
							));
		  
		  
		  
		  $pay->SetSuccessConsume($newcid); 
		  

		  
		  $taskarr=$this->GetMysqlOne('seller,subject,content,time'," ".$this->GetTable('task')." WHERE tid='$this->tid'");
		  
		  //接口
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
		  
		  //设置时间
		  $endtime=$this->NowTime() +(24*60*60*$taskarr['time']);
		  
		  $this->Update('task',array('endtime'=>$endtime),array()," WHERE uid='$this->uid' AND tid='$this->tid'");
		  
		  
		  $send_subject='雇主已支付担保金!';
		  $send_content='尊敬的服务商,雇主已支付担保金,请您尽快完成任务！ <a href="'.SURL.'/member.php?app='.$this->app.'&action=5&tid='.$this->tid.'&op=1" target="_blank"><span class="show_details">[查看详细]</span></a>';	
		  
								
		  $this->Port(array(
																				
		      //SMS
		      'receive_uid'=>$taskarr['seller'], //收件人
				
			  //SMS
			  'sms_subject'=>$send_subject,
			  'sms_content'=>$send_content,
							
			  //EMail
			  'email_title'=>$send_subject,
			  'email_content'=>$send_content,

			  //Mobile
			  'mobile_content'=>$send_subject

						
		 ),6);
		  
		  
		  echo '支付成功!';
							 
		  echo $this->CloseNowWindows('#loading',1);

	}
		
	
	
	
	
	function SellServiceManageAction(){
		
		   $tid=intval($this->GET['tid']);
		   $task=$this->GetMysqlOne('*'," ".$this->GetTable('task')." WHERE tid='$tid' AND seller='$this->uid'");
		
		   if($this->GET['op']==3){
			   
			        if($task['tid']>0 && $task['seller']==$this->uid){
						  
						  if($task['status']>0){
							   
							    echo '<p>您已经设置过了!</p>';
							  
						  }else{
							    
								$agree=intval($this->GET['agree']);
								
								if(!$agree){
									 $agree=2;
							    }
								
								
								$disagree=$this->str($this->POST['disagree'],200,1,0,1,0,1);

								$this->Update('task',array('status'=>$agree,'disagree'=>$disagree),array()," WHERE seller='$this->uid' AND tid='$tid'");
								
								if($agree==2){
								        $send_subject='服务商不同意您服务要求!';
										
										if($disagree){
											   $disagree='拒绝信息如下：</p><p>'.$disagree;
										}else{
											   $disagree='</p><p>服务商未填写拒绝信息！';
										}
										
										$send_content='<p>尊敬的雇主,服务商不同意您的服务要求！'.$disagree.'</p><p><a href="'.SURL.'/member.php?app='.$this->app.'&action=6&tid='.$tid.'&op=1" target="_blank"><span class="show_details">[查看详细]</span></a></p>';

								}else{
										$send_subject='服务商已同意您服务要求!';
										$send_content='尊敬的雇主,服务商已同意您的服务要求,请您支付担保金 <a href="'.SURL.'/member.php?app='.$this->app.'&action=6&tid='.$tid.'&op=1" target="_blank"><span class="show_details">[查看详细]</span></a>';
								}
								
								$this->Port(array(
																				
									 //SMS
									 'receive_uid'=>$task['uid'], //接收人
						
							
									  //SMS
									  'sms_subject'=>$send_subject,
									  'sms_content'=>$send_content,
													
									  //EMail
									  'email_title'=>$send_subject,
									  'email_content'=>$send_content,
			
									  //Mobile
									  'mobile_content'=>$send_subject
								
											  
							   ),3);
								
							  
								echo '<p>操作成功!</p>';
								
						  }
						   
				           echo $this->CloseNowWindows('#loading',1);
						   
						   
					}else{
						
						   echo '<p>服务不存在!!</p>';
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
						
						  $this->Refresh('服务不存在!','member.php?app='.$this->app.'&action=6');
					}
			
			}elseif($this->GET['op']==2){
			 
					if($this->POST['oderid']){
							 
						  
							 $oderid=$this->ExplodeStrArr($this->POST['oderid']);
							 $idarray=explode(',',$oderid);
							 
							 foreach($idarray as $value){
								 
								    $this->Update('task',array('process'=>9),array()," WHERE seller='$this->uid' AND tid='$value'");
						            
									
									$sellerinfo=$this->GetLoginInfo($this->uid,1);
									
								    $send_subject=$sellerinfo['username'].'对您的雇用任务不感兴趣,TA关闭了任务！';
									$send_content=$sellerinfo['username'].'关闭了雇用任务 <a href="'.SURL.'/member.php?app='.$this->app.'&action=6&tid='.$value.'&op=1" target="_blank"><span class="show_details">[查看详细]</span></a>';
									
									$task=$this->GetMysqlOne('uid'," ".$this->GetTable('task')." WHERE tid='$value'");
									
									$this->Port(array(
													
										   //SMS
										  'receive_uid'=>$task['uid'], //收件人
									
										
										  //SMS
										  'sms_subject'=>$send_subject,
										  'sms_content'=>$send_content,
														
										  //EMail
										  'email_title'=>$send_subject,
										  'email_content'=>$send_content,
				
										  //Mobile
										  'mobile_content'=>$send_subject
																
																			  
									),4);
																
																
									echo $value.'关闭成功!<br />';
									
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
									 echo '请输入留言内容!';
									 echo $this->CloseNowWindows('#loading');
								}elseif($strings->CheckLength(5)){ 
									 echo '对不起！,留言不能少5个字!';
									 echo $this->CloseNowWindows('#loading');
								}else{
									
									 //过虑
									 $content=$this->str($this->POST['content'],200,0,1,1,0,1);
									 
									 if($this->tid!=0){
										   
										   $task=$this->GetMysqlOne('seller,uid,subject,process'," ".$this->GetTable('task')." WHERE tid='$this->tid'");
										 

										   if($task['process']==6){
											   
											     echo '该服务已关闭!不能操作<br />';
											   
										   }else{
											   
											     $newid=$this->Insert('task_message',array('appid'=>82,'uid'=>$uid,'tid'=>$this->tid,'content'=>$content,'dateline'=>$this->NowTime()),array());
										   
												 if($task['uid']!=$this->uid){
													 
										
														  $this->Port(array(	 		
																  
																  'login_uid'=>$this->uid,
													
																   'receive_uid'=>$task['uid'], //接收人
																   
																  //SMS
															 
																  'sms_subject'=>$this->username.'在您'.$this->tid.'号服务留言了!',
																  'sms_content'=>$this->username.'在您'.$this->tid.'号服务留言了！<a href="member.php?app='.$this->app.'&action=6&tid='.$this->tid.'&op=1" target="_blank"><span class="show_details">[查看详细]</span></a>',
																  
																 //EMail
															 
																  'email_title'=>$this->username.'在您'.$this->tid.'号服务留言了!',
																  'email_content'=>$this->username.'在您'.$this->tid.'号服务留言了！<a href="'.SURL.'/member.php?app='.$this->app.'&action=6&tid='.$this->tid.'&op=1" target="_blank"><span class="show_details">[查看详细]</span></a>',
																	  
																	  
																 //Mobile
																 
																 'mobile_content'=>$this->username.'在您'.$this->tid.'号服务留言了!'
															  
														 ),8);
														  
												 }else{
													 
													   $this->Port(array(	 		
																  
																  'receive_uid'=>$task['seller'], //接收人
																  
																  //SMS

																  'sms_subject'=>$this->username.'在'.$this->tid.'号服务上留言了!',
																  'sms_content'=>$this->username.'在'.$this->tid.'号服务上留言了！<a href="member.php?app='.$this->app.'&action=5&tid='.$this->tid.'&op=1" target="_blank"><span class="show_details">[查看详细]</span></a>',
																  
																 //EMail
												
																  'email_title'=>$this->username.'在'.$this->tid.'号服务上留言了!',
																  'email_content'=>$this->username.'在'.$this->tid.'号服务上留言了！<a href="'.SURL.'/member.php?app='.$this->app.'&action=5&tid='.$this->tid.'&op=1" target="_blank"><span class="show_details">[查看详细]</span></a>',
																	  
																	  
																 //Mobile
													
																 'mobile_content'=>$this->username.'在'.$this->tid.'号服务上留言了!'
															  
														 ),8);
													 
													 
												 }
												 
												 
												 
												 
												 if($newid){
													 
													 
													  //更新统计
													  $total=$this->IsSQL('task_message',"WHERE tid='$this->tid'");
													 
													  $this->Update('task',array('task_message'=>$total),array(),"WHERE tid='$this->tid'");
																  
																  
																  
													  echo '发布留言成功!<br />';
												 }else{
													  echo '发布留言失败!<br />';
												 }
												 
										   
										   }
										   
										   echo $this->CloseNowWindows('#loading');
										
									 }else{
										
										   echo '任务ID有误!<br />';
										   echo $this->CloseNowWindows('#loading');
											
									 }
									
				
								}
						}else{
							  echo '<p>'.$allow.'</p>';
			                  echo $this->CloseNowWindows('#loading');
						}
						
						
				 }else{
					   echo '请选择登录后操作!<br />';
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
				   
				   echo '您已经支付过了！';
				   echo $this->CloseNowWindows('#loading');
			}else{
			
					if($task['tid']>0 && $task['uid']==$this->uid){
								
								   
						   include $this->Template('project');
								   
					}else{
						
						  $this->Refresh('服务不存在!','member.php?app='.$this->app.'&action=6');
					}
			}

		 
	}
	
	
	public function BuyServiceAction(){
		   
		   
		   $tid=intval($this->GET['tid']);
		   $task=$this->GetMysqlOne('*'," ".$this->GetTable('task')." WHERE tid='$tid' AND uid='$this->uid'");

		    
		   if($this->GET['op']==4){
			   
			     	if($task['tid']>0 && $task['uid']==$this->uid){
						
						   
						   if($this->IsSQL('task',"WHERE tid='$this->tid'") && $this->IsSQL('task_draft',"WHERE tid='$this->tid'")){
										   
									//检查是否设置过
									if(!$this->IsSQL('task',"WHERE tid='$this->tid' AND draft_success=1")){
											   
												 $this->Update('task',array('draft_success'=>1),array(),"WHERE  tid='$this->tid'");
												 
		
												 $draft=$this->GetMysqlOne('a.uid,a.did,a.tid,b.subject,c.username'," (".$this->GetTable('task_draft')." AS a LEFT JOIN ".$this->GetTable('task')." AS b ON a.tid=b.tid) LEFT JOIN ".$this->GetTable('member')." AS c ON a.uid=c.uid  WHERE a.tid='$this->tid'");
												  
												 
												 $draftid=$draft['did'];
												 
												 //生成订单-------------------------------------------------------------------------------------
		                                        
												 if(!$this->IsSQL('task_order',"WHERE did='$draftid' AND tid='$this->tid'")){
													 
													   
													   if($this->IsSQL('task',"WHERE tid='$this->tid' AND process>1")){
															 $process=2;
													   }else{
															 $process=1;
													   }
													   

													   $serial=$this->GetOrderNumber();
													   
													   $fee=$this->GetTaskFeeValue('task_seller_usergroup','taskfee',$task['money'],0,$draft['uid']);
																					   
													   
													   
													   //Create Consume
                                                       //是否托管
													   
													   $order=$this->Insert('task_order',array('buyeruid'=>$task['uid'],'selleruid'=>$draft['uid'],'did'=>$draftid,'tid'=>$this->tid,'money'=>$task['money']-$fee,'sum'=>$task['money'],'dateline'=>$this->NowTime()),array());
													  
	
									   
													   $cid=$this->SetConsume(array(
															   'subject'=>$task['subject'], 
															   'appid'=>intval($this->app),
															   'serial'=>$serial,
															   'process'=>$process,
															   'oid'=>$order,
															   'amount'=>$task['money']-$fee,
															   'fee'=>$fee,
															   'paytype'=>1, //交易类型
															   'payout'=>0,
															   'payin'=>$draft['uid']    //收入者ID
															   
														 ));
													  
													   
													   
												 }
												 
							
												 //生成订单结束----------------------------------------------------------------------------------
												 
												 
											  //单人
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
						 
												 
												 
												 //中标通知-------------------------------------------------------------------------------------
                                                 $send_op='';
														   
											     $send_subject=$draft['username'].'您的'.$draftid.'号服务作品买家已采纳了!';
											   
											     $send_content=$draft['username'].'您的'.$draftid.'号服务作品买家已采纳了！<a href="'.SURL.'/member.php?app=48&action=2&oid='.$order.'" target="_blank"><span class="show_details">[查看订单]</span></a>';

												  require_once(APPS.'/apppay/class/process_class_phpapp.php');
												  $getprocess=new TaskProcess();
												  $send_op='<p>等您交接源件并确认交接,'.$getprocess->GetSellerProcessMenu('task_order_credit',$cid).'</p>';
									
												 
												  $this->Port(array(
													  
														 'login_uid'=>$this->uid,
														
														  //Credit
														  'credit_uid'=>$this->uid,
														  
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
												  
												 
												 //中标通知结束-------------------------------------------------------------------------------------
												 
	
													   echo '操作成功,等待卖家交接中！<br />';
													   
												       echo $this->AjaxRefresh(SURL.'/member.php?app=48&action=4&oid='.$order,3);
												 
					
										   }else{
											     
												 echo '对不起！您的已经设置采纳过了！<br />等待卖家发货<br />';
												 echo $this->CloseNowWindows('#loading');
		
										   }
										   
									
					
						}else{
							  echo '对不起！卖方未提交作品不能采纳！<br />';
							  echo $this->CloseNowWindows('#loading');
						}

						  
						   
					}else{
						
						  $this->Refresh('服务不存在!','member.php?app='.$this->app.'&action=6');
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
						
						  $this->Refresh('服务不存在!','member.php?app='.$this->app.'&action=6');
					}
			
			}elseif($this->GET['op']==2){
			 
					if($this->POST['oderid']){
							 
						  
							 $oderid=$this->ExplodeStrArr($this->POST['oderid']);
							 $idarray=explode(',',$oderid);
							 
							 foreach($idarray as $value){
									$this->Delete('task'," WHERE uid='$this->uid' AND tid='$value' ");
									echo $value.'号服务删除成功!<br />';
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
		  
		  //删除封面
		  $file->SetDeleteFile($service['logo']);
		  
		  //删除文件
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
					 
					 $msg='<p>设置关闭成功!</p>';
					  
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
					 
					 $msg='<p>设置出售成功!</p>';
					  
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
					 
					 $msg='<p>删除成功!</p>';
					  
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
				   
				   $msg='<p>删除成功!</p>';
				   
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
					    
						$this->Refresh('对不起！,服务不存在!','member.php?app='.$this->app.'&action=3');
				 
				        exit();
					  
				  }
			   
		   }
		   
	
		   if($this->POST['submit']){

				 if($this->CheckSecurityForm($this->POST['SecurityForm'])){
					 
					     //权限
				         if($this->sid>0){
							 
						                $allow=$this->CheckAllow('task_seller_usergroup',array(
																'edittask'=>''
																)
														 );
							 
						 }else{
						                $allow=$this->CheckAllow('task_seller_usergroup',array(
																'addtask'=>'',
																'addnumbertask'=>'',
																'maxmoneytask'=>floatval($this->POST['price']), //发布服务最大托管金额
																'smallmoneytask'=>floatval($this->POST['price']) //发布服务最低托管金额
																)
														 );
						 }
				    
						 if($allow=='ok'){
					   
					             
								 $fieldnum=count($this->GetTableFieldArray('task_seller_service'));
								  
														   
								 if($this->CheckService()==(6+$fieldnum)){
					 
					           				   
										//封面
										include_once(Core.'/class/photo_upload_phpapp.php');
		
					  
										 if($_FILES['logophoto']['size']>0){
											   
											   if($_FILES['logophoto']['size']> intval(PHPAPP::$config['oneimageuploadsize'])){
														$errors='对不起!您上传的图片不能超过 '.(PHPAPP::$config['oneimageuploadsize']/1024).'KB,请重新上传！'; 										                                                        
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
												   
													 $this->Refresh('对不起！,请上传服务封面图片!','member.php?app='.$this->app.'&action=1');
													 
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
									   
												   //上传文件
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
									   
									   //$this->Refresh('发布成功!','member.php?app='.$this->app.'&action=3');
									   
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
					  
						//$this->Refresh('提交表单已过期!','member.php?app='.$this->app.'&action=1');
						
						$this->SubmitServiceForm('提交表单已过期！请重新打开服务发布页面！');
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
									   echo '<p>对不起！您使用了地图定位服务请设置地图位置.</p>';
									   echo $this->CloseNowWindows('#loading');	
									   exit();
								}
						}
					   
					    if($totalservice){
								  
							    //检查用户可用金额
								$user=$this->GetMysqlOne('*'," ".$this->GetTable('member_account')." WHERE uid='$this->uid'");
								
								if($user['money']>=($totalservice)){
								
										$this->UseServiceProp($props,$service,$buyservice,0,$this->sid);
	
								}else{
									   
									   echo '<p>道具购买失败！您的可用余额不足 <strong>'.$totalservice.' 元</strong> ,请充值后再购买道具！</p>';
	
								}
							
							 
					    }else{
							
							   $this->UseServiceProp($props,$service,$buyservice,0,$this->sid);
						  
					    }
						
						echo '<p>发布成功！</p>';
						
						echo $this->AjaxRefresh(SURL.'/member.php?app='.$this->app.'&action=3',3);
					 
				 }else{
		
						 include $this->AppsView('confirm');
				 }
		   }else{
			    $this->Refresh('服务不存在或已被删除!','member.php?app='.$this->app.'&action=3');
		   }
	}
	
	function CheckService(){
		
		        $checknum=0;
				
				$this->POST['catid']=empty($this->POST['catid']) ? '' : $this->POST['catid'];
				
		        //过虑
				foreach($this->POST as $key=>$value){
				
					   switch($key){
					          case 'subject':
							  
							       $strings=new CharFilter($this->POST['subject']);
								   
								   if(empty($this->POST['subject'])){
							             $this->errors[]='请输入标题!';
								   //}elseif($strings->CheckSpace()){
							             //$this->errors[]='对不起！,标题含有非法代码!';	 
								   }elseif($strings->CheckLength(5)){  
										 $this->errors[]='对不起！,标题不能少5个字!';
								   }elseif($strings->CheckShort(50)){ 
										 $this->errors[]='对不起！,标题太长了!';
								   }else{
									     $checknum+=1;
								   }
		
					          break;
							  case 'price':
							       if(empty($this->POST['price'])){
							             $this->errors[]='请输入价格!';
									
								   }elseif($this->POST['price']<1){
										  $this->errors[]='价格不能为0元!';
							       }else{
									     $this->POST['price']=floatval($this->POST['price']);
									     $checknum+=1;
								   }
					          break;
							  
							  case 'unit':
							       if(empty($this->POST['unit'])){
							             $this->errors[]='请输入单位!';
								   }else{
									     $this->POST['unit']=$this->str($this->POST['unit'],5,1,0,1,0,1);
									     $checknum+=1;
								   }
					          break;
							  
							  case 'time':
							  
							       if(empty($this->POST['time'])){
							             $this->errors[]='请输入时间!';
								   }elseif($this->POST['time']<1){
									     $this->errors[]='时间不能为0!';
								   }else{
									     $this->POST['time']=intval($this->POST['time']);
									     $checknum+=1;
								   }
					          break;
							  
							  case 'content':
									$strings=new CharFilter($this->POST['content']);
									if(empty($this->POST['content'])){
										 $this->errors[]='请输入内容!';
									}elseif($strings->CheckLength(5)){ 
										 $this->errors[]='对不起！,内容不能少5个字!';
									}else{
									     $checknum+=1;
								    }
							  break;
							  
							  case 'catid':
						
							       if(empty($this->POST['catid']) || $this->POST['catid']<0){
							             $this->errors[]='请选择分类!';
							       }else{
									     $checknum+=1;
								   }
							  
							  break;
							  
					   }
				}	
				
				
			   //自定义字段---------------------------------------------------
			   
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
			   
			   //自定义字段 end---------------------------------------------------
	
		       return $checknum;
	}
	
	
	function EditTaskAction(){
		 

           $task=$this->GetMysqlOne('*'," ".$this->GetTable('task')." WHERE tid='$this->tid' AND uid='$this->uid' AND process=1 ");
		   
		   if($task){
                
				
				
		        include $this->AppsView('edittask_member');
		   }else{
			   
			    echo '<p>服务不存在!</p>';
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

									   
									    echo '您已经申请成功!';
										echo '<br />'.$this->CloseNowWindows('#loading');
								  }else{
									    echo '您已经申请过了,请等待处理结果。';
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
											  
											  //延期
											  $endtime=$task['endtime'];
											  
											  $getallow=$this->GetAllow('task_seller_usergroup',array('extendmoneytask','extendnumbertask'));
											  
											  
											  $extendtime=$money/$getallow['extendmoneytask'] * $getallow['extendnumbertask'];

											  $this->Update('task',array('money'=>$taskmoney,'addmoneynum'=>$addmoneynum,'addmoney'=>$taskaddmoney,'endtime'=>$endtime+($extendtime*24*60*60),'process'=>4),array(),"WHERE tid='$this->tid'");  
											   
											   
											   @include_once(APPS.'/apppay/class/consume_class_phpapp.php');
							                   $pay=new UserConsume();
							  
											  $newcid=$pay->MakeConsume(array(
													   'subject'=>'<p>服务加价</p>增加服务担保金', 
													   'appid'=>intval($this->app),
													   'process'=>1,
													   'amount'=>$money,
													   'paytype'=>1, 
													   'payout'=>$this->uid,   //支出者ID
													   'payin'=>0    //收入者ID
													   
												 ));
								
											  $pay->SetSuccessConsume($newcid);
  
									          echo '加价成功!';
											  echo '<br />'.$this->CloseNowWindows('#loading',1);
									  
									  }else{
										  
										   echo '对不起!您的余额不足'.$money.'元,请充值后操作!<br />';
										   
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
							    //权限
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
													   
												 echo '<p>使用成功</p>';
												       
												 echo $this->CloseNowWindows('#loading',1);

							 
										  }else{
									     
												 echo $taskone->AddProjectAction($this->tid);
										  }
									  
									       
								  }
								  
						  }else{
							  
							    $this->Refresh('服务不存在或已删除!','member.php?app='.$this->app.'&action=42');
						  }
				   }else{
					     
						  $this->Refresh('服务不存在或已删除!','member.php?app='.$this->app.'&action=42');
				   }
				 
				   
				 
		
			 }elseif($this->GET['op']==1){
				 
				  if($this->POST['oderid']){
						   
						
						   $oderid=$this->ExplodeStrArr($this->POST['oderid']);
						   $idarray=explode(',',$oderid);
				           
						   foreach($idarray as $value){
							      $this->Delete('task'," WHERE uid='$this->uid' AND tid='$value' ");
								  echo $value.'号服务删除成功!<br />';
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
					 
					     //权限
						 /*
						 $allow=$this->CheckAllow('task_seller_usergroup',array(
																'adddraft'=>'',
																'joinmoneydraft'=>floatval($task['money']), //投稿赏金范围
																)
														 );
						 */
						 
						 $allow='ok';
						 
						 if($allow=='ok'){
							 
						         //自定义字段---------------------------------------------------
								 $fieldarray=$this->GetTableFieldArray('task_draft');
								 
								 foreach($fieldarray as $key=>$value){
									   
										if($value['required_phpapp']==1){
											   
											   $fieldname=$value['field_phpapp'];
											   
											   $strings=new CharFilter($this->POST[$fieldname]);
											   
											   if(empty($this->POST[$fieldname])){
													 echo '请输入'.$value['name_phpapp'].'!';
													 echo $this->CloseNowWindows('#loading');
													 exit();
											   }elseif($strings->CheckLength($value['smalllength_phpapp'])){  
													 echo '对不起！,'.$value['name_phpapp'].'不能少'.$value['smalllength_phpapp'].'个字符!';
													 echo $this->CloseNowWindows('#loading');
													 exit();
											   }elseif($strings->CheckShort($value['maxlength_phpapp'])){
													 echo '对不起！,'.$value['name_phpapp'].'太长了!';
													 echo $this->CloseNowWindows('#loading');
													 exit();
											   }
											  
										}
				  
								 }
								 
								//自定义字段 end ---------------------------------------------------
								

								  $strings=new CharFilter($this->POST['content']);
								  
								  if(empty($this->POST['content'])){
									  
										$errors='<p>请输入内容!<p>';
										
										echo $errors;
										echo $this->CloseNowWindows('#loading');
								
										
								  }elseif($strings->CheckLength(2)){ 
								  
										$errors='<p>对不起！内容不能少2个字!<p>';
											
										echo $errors;
										echo $this->CloseNowWindows('#loading');

										
								  }else{
										
										 $uid=$this->uid;
										
										 if($uid){
											 
												if(!$this->IsSQL('task_draft',"WHERE tid='$this->tid' AND uid='$this->uid'")){
				  
													   
													  if($uid!=$task['uid']){ 
													  
											  
																 $did=$this->Insert('task_draft',$this->POST,array('uid'=>$uid,'appid'=>82,'dateline'=>$this->NowTime(),'tid'=>$this->tid));
																 
															
																
																  /*
																 //上传文件
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
																 
                                                                 
																 $send_subject=$this->username.'在您'.$this->tid.'号服务提交作品了!';
																 $send_content=$this->username.'在您'.$this->tid.'号服务提交作品了! <a href="member.php?app='.$this->app.'&action=6&tid='.$this->tid.'&op=1" target="_blank"><span class="show_details">[查看详细]</span></a>';
																 
																 $this->Port(array(
																			//Login
																			'login_uid'=>$this->uid,
																			
																			//Credit
																			'credit_uid'=>$this->uid,
																			
																			//SMS
							
																			'receive_uid'=>$task['uid'], //接收人
																					
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
					
																	  echo '<p>提交作品成功!</p>';
																
																	  echo $this->CloseNowWindows('#loading',1);
																	
			  
																 }else{
																	  echo '提交失败!<br />';
																	  echo $this->CloseNowWindows('#loading');
																 }
													  }else{
															  
															  echo '<p>对不起！操作有误！</p>';
														
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
													   
													   
													   	$send_subject=$this->username.'在您'.$this->tid.'号服务中修改了作品!';
														$send_content=$this->username.'在您'.$this->tid.'号服务中修改了作品! <a href="member.php?app='.$this->app.'&action=6&tid='.$this->tid.'&op=1" target="_blank"><span class="show_details">[查看详细]</span></a>';
													   
													   $this->Port(array(
																					
											
															  'receive_uid'=>$task['uid'], //收件人
			
															   //SMS
															  'sms_subject'=>$send_subject,
															  'sms_content'=>$send_content,
																			
															  //EMail
															  'email_title'=>$send_subject,
															  'email_content'=>$send_content,
												
															  //Mobile
															  'mobile_content'=>$send_subject	
																		
																		
													  ),2);
													  
													  echo '<p>修改成功!</p>';
													  
													  echo $this->CloseNowWindows('#loading',1);
													 
													  
											   }
										 
										 
										 }else{
											 
											   $errors='<p>对不起！请登录后操作！</p>';
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
					 
					   $errors='<p>对不起！任务当前状态不能操作！</p>';
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
										   
										     echo '<p>举报成功!</p>';

									   }else{
										     echo '<p>您已经举报过了!</p>';
				                             
									   }  
									   
	
								 }else{
									   
									   if(!$this->IsSQL('report',"WHERE tid='$tid' AND uid='$this->uid'")){
										   
										     $this->Insert('report',array('tid'=>$tid,'uid'=>$this->uid,'content'=>$this->str($this->POST['content'],200,1,0,1,1,1),'dateline'=>$this->NowTime()),array());
										   
										     echo '<p>举报成功!</p>';

									   }else{
										     echo '<p>您已经举报过了!</p>';
				                             
									   }
								 
								 }
								 
								 echo $this->CloseNowWindows('#loading');
							   
							   
						   }else{
							   
							    echo '<p>请输入举报内容!</p>';
				                echo $this->CloseNowWindows('#loading');
						   }
						 
						 
					 }else{
					 
					        include $this->Template('repotr');
					 }
				   
				 
			 }else{
				 
				    echo '<p>任务不存在!</p>';
				    echo $this->CloseNowWindows('#loading');
				 
			 }


	}
	
}

?>