<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(APPS.'/taskcount/my_phpapp.php');

class TaskCountMainControls extends MyTaskCount{
	
    public $POST,$GET,$errors;
	
	public $tid;
	
	function __construct(){	
	
	       parent::__construct();

		   if($this->uid){

				   $allow=$this->CheckAllow('task_count_usergroup',array('appallow'=>''));
				   $errors='';
				   if($allow!='ok' && $allow){ 
				   
						  foreach($allow as $value){
								$errors.='<p>'.$value.'</p>';
						  }
						  
						  $this->Refresh($errors,SURL);
				   }
				   
		   }else{
			      
				  if(intval(PHPAPP::$config['task_tourist'])){
				  
				        $this->Refresh('�Բ�����û��Ȩ��ʹ�ø�Ӧ�ã�','index.php?app=2&action=1');
				  }
			   
		   }
      
	}
	
	
	function DefaultAction(){
		  
		   $this->ShowTaskAction();
	}
	
	function AddDataAction(){
		   $uid=$this->uid;
		   
	       if($this->POST['Submit']){
			   
			      if($this->CheckSecurityForm($this->POST['SecurityForm'])){
			           		 
						 //Ȩ��
						 $allow=$this->CheckAllow('task_count_usergroup',array(
																'addtask'=>'',
																'realnametask'=>'',
																'addnumbertask'=>'',
																'maxmoneytask'=>intval($this->POST['total']) * floatval($this->POST['money']), //������������йܽ��
																'smallmoneytask'=>intval($this->POST['total']) * floatval($this->POST['money']) //������������йܽ��
																)
														 );

						 if($allow=='ok'){
					  
								 $fieldnum=count($this->GetTableFieldArray('task'));
								  
								 if($this->CheckTask()==(6+$fieldnum)){
									    
										$this->POST['taskphone']=$this->str($this->POST['taskphone'],20,0,1,1,0,1);
										
										$skills=$this->ExplodeStrArr($this->POST['skills']);

										$endtime=strtotime($this->POST['endtime'].$this->Date(" H:i:s",$this->NowTime()));
									
										$description=$this->str($this->POST['content'],200,0,1,1,0,1);
										if(strlen($this->POST['content'])>200){
											 $description.='...';
										}
									
									   //SecurityForm
									 
									   if($this->POST['edittid']>0){
										   
										    $this->tid=intval($this->POST['edittid']);
											
											if($this->IsSQL('task',"WHERE tid='$this->tid' AND process<2")){
												   
												   $this->POST['money']=$this->POST['total'] * $this->POST['money'];
												
											}

											
											$this->Update('task',$this->POST,array('dateline'=>$this->NowTime(),'process'=>1,'skills'=>$skills,'endtime'=>$endtime,'keywords'=>$this->str($this->GetSkillsKeywords($skills),150,0,1,1,0,1),'description'=>$description)," WHERE tid='$this->tid' AND uid='$this->uid' ");
											
									   }else{
										    
										     $this->POST['money']=$this->POST['total'] * $this->POST['money'];
											 
											 $this->tid=$this->Insert('task',$this->POST,array('appid'=>80,'uid'=>$this->uid,'lang'=>$this->lang,'dateline'=>$this->NowTime(),'process'=>1,'skills'=>$skills,'endtime'=>$endtime,'keywords'=>$this->str($this->GetSkillsKeywords($skills),150,0,1,1,0,1),'description'=>$description ));
																						
											 $taskurl=$this->GetTaskURL($this->tid,0,80);
											 $this->Update('task',array('url'=>$taskurl),array()," WHERE tid='$this->tid' AND uid='$this->uid' ");
											 
											 
											  if(PHPAPP::$config['task_assign_service']){
													 $serviceuser=$this->GetMysqlArray('*'," ".$this->GetTable('customer_service')." ORDER BY dateline ASC");    
													 
													 if($serviceuser){
														   //�󶨿ͷ�
														   $suid=$serviceuser[0]['uid'];
														   
														   if(!$suid){
																$suid=1;
														   }
														   
														   $this->Update('customer_service',array('dateline'=>$this->NowTime()),array(),"WHERE uid='$suid'");
														   
														   $this->Update('task',array('serviceuid'=>$suid),array(),"WHERE tid='$this->tid'");
													 }
											 }
									   
									   }
									   
									   
									    $allow=$this->CheckAllow('task_count_usergroup',array(
																					'uploadfilestask'=>''
																				 )
																	 );
																 
										if($allow=='ok'){
									   
												   //�ϴ��ļ�
												   $files=$this->UploadFile();
												   
												   if($files){
														 foreach($files as $fid){
															  $this->Insert('apps_file',array('appid'=>80,'fid'=>$fid,'uid'=>$this->uid,'id'=>$this->tid,'type'=>1),array());
														 }
														 
														 $this->ReplaceFileContent($files,'task',$this->POST['content']," WHERE tid='$this->tid' ");
												   }
										}else{
											
											  $this->ShowAllowError($allow,SURL.'/index.php?app=80&action=5&tid='.$this->tid);
											
										}
									   
									    /*
									    //���·���ͳ��
										$this->UpdateCategoryCount('task',$this->POST['catid'],'',' AND process>0');
										*/
											 
										echo $this->tid;
								 
								 }else{
									   if($this->errors){
											  foreach($this->errors as $value){
												   echo $value.' ';
											  }
									   }
								 }
						 }else{
							 
							   foreach($allow as $value){
									 echo $value.' ';
							   }
							  
						 }
				 
				 
				  }else{
					  
					    echo '������!';
				  }
				 
				 
			   
		   }else{

				 $task=$this->GetMysqlOne('*'," ".$this->GetTable('task')."  WHERE tid='$this->tid' ");
				 
				 $taskmode=$this->GetMysqlArray('*'," ".$this->GetTable('task_mode')." WHERE status=0 ORDER BY displayorder ASC");
				 
				 include $this->AppsView('taskcount:add');
		   }
	}
	
	function CheckTask(){
		
		        $checknum=0;
				
				$this->POST['catid']=empty($this->POST['catid']) ? '' : $this->POST['catid'];
				
		        //����
				foreach($this->POST as $key=>$value){
					   
					   switch($key){
					          case 'subject':
							  
							       $strings=new CharFilter($this->POST['subject']);
								   
								   if(empty($this->POST['subject'])){
							             $this->errors[]=$this->LanguageArray('taskmode','Enter_the_task_title');
								   }elseif($strings->CheckLength(5)){  //�������������С���� ��λ "λ"
										 $this->errors[]='�Բ���,������ⲻ����5����!';
								   }elseif($strings->CheckShort(50)){ //�������������󳤶� ��λ "λ"
										 $this->errors[]='�Բ���,�������̫����!';
								   }else{
									     $checknum+=1;
								   }
		
					          break;
							  case 'total':
							       if(empty($this->POST['total'])){
							             $this->errors[]='��������������!';
									
								   }elseif($this->POST['total']<1){
										  $this->errors[]='��������Ϊ0!';
							       }else{
									     $this->POST['total']=intval($this->POST['total']);
									     $checknum+=1;
								   }
					          break;
							  case 'money':
							       /*
							       if(empty($this->POST['money'])){
							             $this->errors[]='�����������ͽ�!';
							
							       }else{
									     $this->POST['money']=floatval($this->POST['money']);
									     $checknum+=1;
								   }
								   */
								   
								   $this->POST['money']=floatval($this->POST['money']);
								   $checknum+=1;
					          break;
							  case 'endtime':
							       
								   $endtime=strtotime($this->POST['endtime'].$this->Date(" H:i:s",$this->NowTime()));
								   
								   $nowtime=$this->NowTime() + 24*60*60;
	
							       if(empty($this->POST['endtime'])){
							             $this->errors[]='����������ʱ��!';
								   }elseif($endtime > ($this->NowTime()+PHPAPP::$config['task_endtime']*24*60*60)){
									     $this->errors[]='����ʱ�䲻�ܴ���'.PHPAPP::$config['task_endtime'].'��!';
								   }elseif($endtime < $nowtime){
									     $this->errors[]='����ʱ�䲻�ܴ���1��!';
							       }else{
									     $checknum+=1;
								   }
						
					          break;
							  
							  case 'content':
									$strings=new CharFilter($this->POST['content']);
									if(empty($this->POST['content'])){
										 $this->errors[]='��������������!';
									}elseif($strings->CheckLength(5)){  //��������������С���� ��λ "λ"
										 $this->errors[]='�Բ���,�������ݲ�����5����!';
									}else{
									     $checknum+=1;
								    }
							  break;
							  
							  case 'catid':
						
							       if(empty($this->POST['catid']) || $this->POST['catid']<0){
							             $this->errors[]='��ѡ���������!';
							       }else{
									     $checknum+=1;
								   }
							  
							  break;
							  
					   }
				}	
				
				
			   //�Զ����ֶ�---------------------------------------------------
			   
			   $fieldresult=$this->GetTableFieldResult('task',$this->POST);
			   
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
	
    function GetTaskOperateMenu($task=array()){
		  
		  if($this->uid!=$task['uid'] && $task['process']<7){
		        $operatemenu='<a href="javascript:;" class="task_mybid" onclick="AddDraft(\''.$task['tid'].'\',0);">��ҪͶ��</a>';
		  }
		  
		  return $operatemenu;
	}  
	
	function ShowTaskAction(){
		
		  if($this->tid){
			    

				$task=$this->GetMysqlOne('a.*,b.usertype,b.username'," ".$this->GetTable('task')." AS a LEFT JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid WHERE tid='$this->tid'");
				
				if($task){
					
	
						$hide=0;
						 
						if(PHPAPP::$config['task_tourist_content']==1){
							  
							  $hide=1;
							
						}else{
							  
							  if($task['hide']){
									$hide=1;
							  }
							
						}
						
		 				$taskaddarr=$this->GetMysqlArray('*'," ".$this->GetTable('task_add')." WHERE tid='$this->tid' ORDER BY dateline ASC");
		 
						$files=$this->FileList($task['tid'],1);
				         
						 //skills
						include_once(Core.'/class/skill_class_phpapp.php');
		   
		                $skilldata=new SkillClass();
				
				        $skillsarr=$skilldata->GetSkillURL($task['skills']);
				
	                    $notcheck=intval($this->IsSQL('task_draft',"WHERE tid='$this->tid' AND process=0"));
							
						$yescheck=intval($this->IsSQL('task_draft',"WHERE tid='$this->tid' AND process>0"));
							
					    $mycheck=intval($this->IsSQL('task_draft',"WHERE tid='$this->tid' AND uid='$this->uid'"));
						
						$draftsuccess=$this->GetMysqlOne(' sum(money) AS moneys '," ".$this->GetTable('task_draft')." WHERE tid='$this->tid' ");
					
						$taskuser=$this->GetMysqlOne('b.username,b.uid,b.dateline AS regtime,b.logintime,c.certificate,d.credit,credits,credittype '," ((".$this->GetTable('member')." AS b LEFT JOIN ".$this->GetTable('member_info')." AS c ON b.uid=c.uid)																																																																LEFT JOIN ".$this->GetTable('member_account')." AS d ON b.uid=d.uid) LEFT JOIN ( SELECT type AS credittype,credit AS credits,uid FROM ".$this->GetTable('credit')." WHERE type=2 ) AS e ON b.uid=e.uid  WHERE b.uid='$task[uid]' ");

				
						$nowdate=@date("Y,m,d,H,i,s");
						$taskendtime=@date('Y,m,d,H,i,s',$task['endtime']);  	
						
						
						$META['robots']=$task['robots'];
						
						//SEO
						PHPAPP::$SEO['title']='��'.$task['money'].'Ԫ '.$task['subject'];
						PHPAPP::$SEO['keywords']=$task['keywords'];
						PHPAPP::$SEO['description']=$task['description'];
						
						//����
						$this->TaskExpired($this->tid);
						
						include $this->AppsView('show');
				  
					
				}else{
					
				      $this->Refresh('���񲻴��ڻ��ѱ�ɾ��!',SURL);
			    }
				
				
				
		  }else{
			    
				$this->Refresh('���񲻴��ڻ��ѱ�ɾ��!',SURL);
		  }
	}
	
	
	
	function AddDraftAction(){

		 $did=$this->GET['did'];
		 
		 $task=$this->GetMysqlOne('uid,subject,hidedraft,realnametask,money,total,draft_success,allowtender'," ".$this->GetTable('task')." WHERE tid='$this->tid'");
		 
		 if($task['realnametask']==1){
			 
				 if(!$this->IsRealName()){
					  
					  $errors=include $this->LanguageArray('taskmode','Realname_Contributors',1);
					  
					  if($this->IsWap()){
						  
						   $this->Refresh($errors,SURL.'/index.php?app='.$this->app.'&action=5&tid='.$this->tid);
					  }else{
						   echo $errors;
						   echo $this->CloseNowWindows('#loading');
					  }
					  exit();
				 }
			  
		 }
		 
		 //����
		 if(!$this->IsSQL('member',"WHERE uid='$this->uid' AND skills!='' ")){
			    
				include_once(APPS.'/skill/member_phpapp.php');
				
				$myskills=new SkillsMemberControls();
				
				$myskills->SetSkillsAction(1);
				
				exit();
		 }
		 
 
		 
		 if($this->IsSQL('task',"WHERE tid='$this->tid' AND process=4")){
			 
				 //Ȩ��
				 $allow=$this->CheckAllow('task_count_usergroup',array(
														'adddraft'=>'',
														'addnumberdraft'=>'',
														'joinmoneydraft'=>floatval($task['money']/ intval($task['total'])), //Ͷ���ͽ�Χ
														)
												 );
				 
				 if($allow=='ok'){
						   
						   
						 if($task['allowtender']){
							   if($this->IsSQL('task_draft',"WHERE tid='$this->tid' AND uid='$this->uid'")){
									 echo '<p>�Բ������Ѿ�Ͷ�����,��������ֻ��Ͷһ�θ����</p>';
									 echo $this->CloseNowWindows('#loading');
									 exit();
							   } 
						 }

								
						 $uid=$this->uid;
						 
						 if($uid){
							 
								if( $this->IsSQL('task_draft',"WHERE tid='$this->tid' AND process=0") < (intval($task['total'])-$task['draft_success'] + intval(PHPAPP::$config['task_count_broaden_add']) )){
  
									   
									  if($uid==$task['uid']){ 
											  
											  $errors='<p>�Բ��������������Լ�Ͷ�꣡</p>';
											  if($this->IsWap()){
												   $this->Refresh($errors,SURL.'/index.php?app='.$this->app.'&action=5&tid='.$this->tid);
											  }else{
												  
												   echo $errors;
												   echo $this->CloseNowWindows('#loading');
											  }
											  exit();
											
									  }
							   
							   }else{
									  
									  $this->UpdateTaskProcess(5,$this->tid);
									
									  $errors='<p>�Բ���Ͷ��̫���˵ȴ���������Ͷ�壡</p>';
									  if($this->IsWap()){
										   $this->Refresh($errors,SURL.'/index.php?app='.$this->app.'&action=5&tid='.$this->tid);
									  }else{
										  
										   echo $errors;
										   echo $this->CloseNowWindows('#loading');
									  }
									  exit();
									  
							   }
						 
						 
						 }else{
							 
							   $errors='<p>�Բ������¼�������</p>';
							   if($this->IsWap()){
									 $this->Refresh($errors,SURL.'/index.php?app='.$this->app.'&action=5&tid='.$this->tid);
							   }else{
									 echo $errors;
									 echo $this->CloseNowWindows('#loading');
							   }
							   exit();
							  
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
					   exit();
					 
				 }
				
		 }else{
			 
			   $errors='<p>�Բ�������ǰ״̬���ܲ�����</p>';
			   if($this->IsWap()){
					 $this->Refresh($errors,SURL.'/index.php?app='.$this->app.'&action=5&tid='.$this->tid);
			   }else{
					 echo $errors;
					 echo $this->CloseNowWindows('#loading');
			   }
			   exit();
			  
		 }
			 

		 
		 if($did){	
			   $draft=$this->GetMysqlOne('*'," ".$this->GetTable('task_draft')." WHERE tid='$this->tid' AND did='$did' AND uid='$this->uid'");
			  
			   if($this->IsSQL('task_draft',"WHERE tid='$this->tid' AND did='$did' AND uid='$this->uid' AND process=1 ")){
				  
					echo '<p>�Բ��������б겻�����޸ģ�</p>';
					echo $this->CloseNowWindows('#loading');
					exit();
			   }
			  
		 }
	
		 $this->AddDraft($did,'adddraft',$draft);
   

	}
	
	
	
	function ShowDraftAction(){

		   include $this->AppsView('draft');
		
	}
	
	function AddCommentAction(){
		 $uid=$this->uid;
				
		 if($uid>0){
			 
			 
			    $allow=$this->CheckAllow('task_count_usergroup',array(
															'commentsdraft'=>''
													 )
											 );
				$this->AddComment($uid,$allow);
								
		 }else{
			   echo '��ѡ���¼�����!<br />';
			   echo $this->CloseNowWindows('#loading');

		 }
		
		
	}
	
	
	function  AddMessageAction(){
		 $uid=$this->uid;
				
		 if($uid>0){
			 
			 
			    $allow=$this->CheckAllow('task_count_usergroup',array(
															'messagetask'=>''
													 )
											 );
				$this->AddMessage($uid,$allow);
								
		 }else{
			   echo '��ѡ���¼�����!<br />';
			   echo $this->CloseNowWindows('#loading');

		 }
		
		
	}
	
		
		
	function ApplyDraftAction($show=0){
		
		  if(!empty($this->POST['draftid'])){
			    
				$uid=$this->uid;
				
				if($uid>0){
						  $this->tid=$this->POST['tid'];
						  
						  $task=$this->GetMysqlOne('uid,subject,money,total,draft_success,serviceuid'," ".$this->GetTable('task')." WHERE tid='$this->tid'");
						  
						  if($task['money']<=0){
							    echo '�Բ�����δ֧���ͽ���ʱ���ܶԸ��������<br />';
								echo $this->CloseNowWindows('#loading');
								exit();
						  }
						  
					
						  if($task['uid']==$this->uid || $this->IsService($task['serviceuid']) || $this->IsAdmin()){
							  
	
								  $draftsuccess=$this->GetMysqlOne(' sum(money) AS moneys '," ".$this->GetTable('task_draft')." WHERE tid='$this->tid' ");
								  
								  $money=floor(floatval($task['money']-$draftsuccess['moneys'])/intval($task['total']-$task['draft_success'])*100)/100;
								  
								  $draftid=$this->ExplodeStrArr($this->POST['draftid']);
								  $idarray=explode(',',$draftid);
								
								  if($this->POST['type']){
										//����
										
										if(count($idarray) <= (intval($task['total']) - intval($task['draft_success']) )){
											  
											  set_time_limit(0);
											  
											  foreach($idarray as $value){ 
											
													 if($this->IsSQL('task_draft',"WHERE did='$value' AND process=0")){
														   
														   //����Ƿ����
														   if($this->IsSQL('task_draft',"WHERE tid='$this->tid' AND process=1") < intval($task['total'])){
															   
																 $this->Update('task_draft',array('process'=>1,'proposal'=>$this->str($this->POST['proposal'],200,1,0,1,0,1)),array(),"WHERE did='$value'");
																 
																 //���ɶ���-------------------------------------------------------------------------------------
						  
																 if(!$this->IsSQL('task_order',"WHERE did='$value' AND tid='$this->tid'")){
																	 
																	   
																	   if($this->IsSQL('task',"WHERE tid='$this->tid' AND process>1")){
																			 $process=2;
																	   }else{
																			 $process=1;
																	   }
																	   
																	   $draft=$this->GetMysqlOne('uid'," ".$this->GetTable('task_draft')." WHERE did='$value'");
																	   
																	   $serial=$this->GetOrderNumber();
																	   
																	   //�շ�
																	   $fee=$this->GetTaskFeeValue('task_count_usergroup','taskfee',$money,0,$draft['uid']);
																	   
																	   $order=$this->Insert('task_order',array('did'=>$value,'buyeruid'=>$task['uid'],'selleruid'=>$draft['uid'],'tid'=>$this->tid,'money'=>$money-$fee,'sum'=>$money,'dateline'=>$this->NowTime()),array());
																	
																	   $cid=$this->SetConsume(array(
																			   'subject'=>$task['subject'], 
																			   'appid'=>intval($this->app),
																			   'serial'=>$serial,
																			   'process'=>$process,
																			   'amount'=>$money-$fee,
																			   'oid'=>$order,
																			   'fee'=>$fee,
																			   'paytype'=>1, //��������
																			   'payout'=>0,   //֧����ID
																			   'payin'=>$draft['uid']    //������ID
																			   
																		 ));
																	   
																		
																		$this->Update('task_order',array('cid'=>$cid),array(),"WHERE oid='$order'");
																	   
																 }
																 
						  
																	
																 //���ɶ�������----------------------------------------------------------------------------------
																 
																  $draft=$this->GetMysqlOne('a.uid,a.tid,b.subject,c.username'," (".$this->GetTable('task_draft')." AS a LEFT JOIN ".$this->GetTable('task')." AS b ON a.tid=b.tid) LEFT JOIN ".$this->GetTable('member')." AS c ON a.uid=c.uid  WHERE a.did='$value'");
																 
																 
																 
																 //�б�֪ͨ-------------------------------------------------------------------------------------
																   $send_op='';
																   
																   $send_subject=include $this->LanguageArray('taskmode','Draft_Successful_SMS_Subject',1);
																   
																   $send_content=include $this->LanguageArray('taskmode','Draft_Successful_SMS_Content',1);
																   
																   if($task['total']==1){
																		 require_once(APPS.'/apppay/class/process_class_phpapp.php');
																		 $getprocess=new TaskProcess();
																		 $send_op=include $this->LanguageArray('taskmode','Draft_Successful_SMS_Operate',1);
																   }
												
																  //�ӿ�
																  $this->Port(array(
																					
																		  //Login
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
																		  'mobile_content'=>$send_subject,
																		  
																		  //feed
																		  'feed_uid'=>$draft['uid'],
																		  'feed_username'=>$draft['username'],
																		  'feed_app'=>49,
																		  'feed_title_template'=>include $this->LanguageArray('taskmode','Draft_Feed_Title_Template',1),
																		  'feed_title_data'=>$draft['subject'],
																		  'feed_content_template'=>'',
																		  'feed_content_data'=>''
																			
																					
																   ),3);
						  
			
							
																 $successnum=$this->IsSQL('task_draft',"WHERE process=1 AND uid='$draft[uid]'");
																 
																 $this->Update('task_draft',array('money'=>$money),array(),"WHERE did='$value'");
																	
																 $this->UpdateTaskCount('successnum',$successnum,$draft['uid']);
																 
																 
																 $successnum=$this->IsSQL('task_draft',"WHERE process=1 AND tid='$this->tid'");
											 
																 $this->Update('task',array('draft_success'=>$successnum),array(),"WHERE tid='$this->tid'");
						
																 
																 //�б�֪ͨ����-------------------------------------------------------------------------------------
																 
																 //��¼�ͷ�
																 if($uid==$task['serviceuid']){
																	   $this->Update('task_draft',array('service'=>1),array(),"WHERE did='$value'");
																 }
																 
																 if(!$show){
																	 
																	   if($process==2){
																			
		
																			if($task['total']>1){
																				
																				  include_once(APPS.'/order/member_phpapp.php');
																				  
																				  $taskorder=new OrderMemberControls();
		
																				  echo  include $this->LanguageArray('taskmode','Draft_Confirm_payment',1);
																				  
																				  $taskorder->SetDelivery(array($cid),'',1);
				
																				
																			}else{
																				  
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
																						'did'=>$value,
																						'tid'=>$this->tid
																				  ));
																				  
																				  $this->Update('task_order',array('closetime'=>$closetime,'workdate'=>$autodelivery,'runid'=>$runid),array(),"WHERE oid='$order'");
																				  
																				  echo  include $this->LanguageArray('taskmode','Draft_Confirm_Connect',1);
																			
																			}
																			
																			
																	   }else{
																			echo '�����ɹ�,�ȴ�������֧���йܽ�<br />';
																	   }	   
		
																 
																 }
																  
															 
														 }else{
															   
															   if(!$show){
																	 echo '�Բ��������б����������꣡<br />';
																	 $this->UpdateTaskProcess(5,$this->tid);
															   }
															 
														 }
														 
													}
											  }
											  
											  
											  echo $this->CloseNowWindows('#loading');
											
										}else{
											  echo '�Բ�������������������б��������޸ģ�<br />';
											  echo $this->CloseNowWindows('#loading');
										}
										
								  }else{
										
										if($this->IsSQL('task_draft',"WHERE tid='$this->tid' AND process=1") < intval($task['total'])){
											
												foreach($idarray as $value){ 
													
													 if($this->IsSQL('task_draft',"WHERE did='$value' AND process=0")){
															  
															  $this->UpdateTaskProcess(4,$this->tid);
															   
															  $this->Update('task_draft',array('process'=>2,'proposal'=>$this->str($this->POST['proposal'],200,1,0,1,0,1)),array(),"WHERE did='$value'");
		
															  $draft=$this->GetMysqlOne('a.uid,a.tid,b.subject,c.username'," (".$this->GetTable('task_draft')." AS a LEFT JOIN ".$this->GetTable('task')." AS b ON a.tid=b.tid) LEFT JOIN ".$this->GetTable('member')." AS c ON a.uid=c.uid  WHERE a.did='$value'");
															  
										
															   $send_subject=include $this->LanguageArray('taskmode','Draft_Unqualified_SMS_Subject',1);
															   
															   $send_content=include $this->LanguageArray('taskmode','Draft_Unqualified_SMS_Content',1);
													
											
															   //�ӿ�
															   $this->Port(array(
																				
																	  //Login
																	  'login_uid'=>$this->uid,
																	
																	  //Credit
																	  'credit_uid'=>$this->uid,
																	  
																	  'receive_uid'=>$draft['uid'], //������
																	  
																	  //SMS
																	  'sms_subject'=>$send_subject,
																	  'sms_content'=>$send_content,
																					
																	  //EMail
																	  'email_title'=>$send_subject,
																	  'email_content'=>$send_content,
											
																	  //Mobile
																	  'mobile_content'=>$send_subject
																				
															   ),4);
						  
						
													 }
													
												}
											  
												echo '�����ɹ���<br />';
												echo $this->CloseNowWindows('#loading');
										}else{
												echo '�Բ���������ɲ��ܲ������<br />';
												echo $this->CloseNowWindows('#loading');
											
										}
										
										
										
									  
				  
								  }
						  
						  
						  }else{
							    echo '�Բ�����û��Ȩ�޲�����<br />';
								echo $this->CloseNowWindows('#loading');
								exit();
							  
						  }
				}else{
					  echo '��ѡ���¼�����!<br />';
			          echo $this->CloseNowWindows('#loading');
				}
			  
		  }else{
			  
			    echo '��ѡ�������в���!<br />';
			    echo $this->CloseNowWindows('#loading');
			  
		  }
		
	}
	
	
}




?>