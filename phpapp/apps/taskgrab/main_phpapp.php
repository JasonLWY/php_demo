<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.1
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(APPS.'/taskgrab/my_phpapp.php');

class TaskGrabMainControls extends MyTaskGrab{
	
    public $POST,$GET,$errors;
	
	public $tid;
	
	function __construct(){	
	
		   parent::__construct();
		   
		   if($this->uid){

				   $allow=$this->CheckAllow('task_grab_usergroup',array('appallow'=>''));
				   $errors='';
				   if($allow!='ok' && $allow){ 
				   
						  foreach($allow as $value){
								$errors.='<p>'.$value.'</p>';
						  }
						  
						  $this->Refresh($errors,SURL);
				   }
				   
		   }else{
			      
				  if(intval(PHPAPP::$config['task_grab_tourist'])){
				  
				        $this->Refresh('�Բ�����û��Ȩ��ʹ�ø�Ӧ�ã�','index.php?app=2&action=1');
				  }
			   
		   }
      
	}
	
	
	function DefaultAction(){
		  $this->ShowTaskAction();
	}
	
	//�������
	function AddDataAction(){
			
			if($this->POST['Submit']){

				   
				  if($this->CheckSecurityForm($this->POST['SecurityForm'])){
						
			
						 //Ȩ��
						 $allow=$this->CheckAllow('task_grab_usergroup',array(
																'addtask'=>'',
																'realnameaddtask'=>'',
																'addnumbertask'=>'',
																'maxmoneytask'=>floatval($this->POST['price1']), //������������йܽ��
																'smallmoneytask'=>floatval($this->POST['price1']) //������������йܽ��
																)
														 );
					
				
						 if($allow=='ok'){
					             
								 $this->POST['tasktype']=intval($this->POST['freetasktype']);
								  
								 $fieldnum=count($this->GetTableFieldArray('task'));
							     
								 if($this->POST['tasktype']==2){
									  $checknum=8;
								 }else{
									  $checknum=7;
								 }
								 if($this->CheckTask()==($checknum+$fieldnum)){
									    
										$this->POST['taskphone']=$this->str($this->POST['taskphone'],20,0,1,1,0,1);
										
										$this->POST['money']=floatval($this->POST['freemoney']);
										$this->POST['total']=intval($this->POST['freetotal']);
	
									    $skills=$this->ExplodeStrArr($this->POST['skills']);
                                        
										$endtime=strtotime($this->POST['endtime'].$this->Date(" H:i:s",$this->NowTime()));
									
										$description=$this->str($this->POST['content'],200,0,1,1,0,1);
										if(strlen($this->POST['content'])>200){
											 $description.='...';
										}
										
										if($this->POST['edittid']>0){
											 
											$this->tid=intval($this->POST['edittid']);
											
											$this->Update('task',$this->POST,array('dateline'=>$this->NowTime(),'process'=>1,'skills'=>$skills,'endtime'=>$endtime,'keywords'=>$this->str($this->GetSkillsKeywords($skills),150,0,1,1,0,1),'description'=>$description )," WHERE tid='$this->tid' AND uid='$this->uid' ");
											
										}else{
									        $this->tid=$this->Insert('task',$this->POST,array('appid'=>83,'uid'=>$this->uid,'lang'=>$this->lang,'dateline'=>$this->NowTime(),'process'=>1,'skills'=>$skills,'endtime'=>$endtime,'keywords'=>$this->str($this->GetSkillsKeywords($skills),150,0,1,1,0,1),'description'=>$description ));
																						
											$taskurl=$this->GetTaskURL($this->tid,0,83);
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
										
										
									   $allow=$this->CheckAllow('task_grab_usergroup',array(
																					'uploadfilestask'=>''
																				 )
																	 );
																 
										if($allow=='ok'){
									   
												   //�ϴ��ļ�
												   $files=$this->UploadFile();
												   
												   if($files){
														 
														 foreach($files as $fid){
															   
															  $this->Insert('apps_file',array('appid'=>83,'fid'=>$fid,'uid'=>$this->uid,'id'=>$this->tid,'type'=>1),array());
														 }
														 
														 $this->ReplaceFileContent($files,'task',$this->POST['content']," WHERE tid='$this->tid' ");
														
												   }
												      	  
										}else{
											
											  $this->ShowAllowError($allow,SURL.'/index.php?app=83&action=5&tid='.$this->tid);
											
										}
									   
									   /*
									    //���·���ͳ��
										$this->UpdateCategoryCount('task',$this->POST['catid'],''," AND process>0 AND appid='$this->app' ");
									   
									   */
									   echo $this->tid;
									   
									   
									   
								 }else{
									   if($this->errors){
											  foreach($this->errors as $value){
												   echo $value.',';
											  }
									   }
								 }
								  
								  
						 }else{
							 
							   foreach($allow as $value){
									 echo $value.',';
							   }
							  
						 }
								 // print_r($this->POST);
					 
				 
				  }else{
					  
					    echo '������!';
				  }
				 	
				
			}else{
				
				  $task=$this->GetMysqlOne('*'," ".$this->GetTable('task')."  WHERE tid='$this->tid' ");
				  
		          $taskmode=$this->GetMysqlArray('*'," ".$this->GetTable('task_mode')." WHERE status=0 ORDER BY displayorder ASC");

				  include $this->AppsView('taskgrab:add');
				
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
							             $this->errors[]='�������������!';
								   }elseif($strings->CheckLength(5)){  //�������������С���� ��λ "λ"
										 $this->errors[]='�Բ���,������ⲻ����5����!';
								   }elseif($strings->CheckShort(100)){ //�������������󳤶� ��λ "λ"
										 $this->errors[]='�Բ���,�������̫����!';
								   }else{
									     $checknum+=1;
								   }
		
					          break;
							  case 'price1':
							       if(empty($this->POST['price1'])){
							             $this->errors[]='����������Ԥ��!';
									
								   }elseif($this->POST['price1']<1){
										  $this->errors[]='Ԥ�㲻��Ϊ0Ԫ!';
							       }else{
									     $this->POST['price1']=floatval($this->POST['price1']);
									     $checknum+=1;
								   }
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
							  case 'skills':
						
							       if(empty($this->POST['skills']) || $this->POST['skills']<0){
							             $this->errors[]='��ѡ��������!';
							       }else{
									     $checknum+=1;
								   }
							  
							  break;
							  case 'freetotal':
						
							       if(!intval($this->POST['freetotal'])){
							             $this->errors[]='�������б�����!';
							       }else{
									     $checknum+=1;
								   }
							  
							  break;
 
					   }
					   
	
				}	
				
				if($this->POST['tasktype']==2){
					   if(!intval($this->POST['duration'])){
							 $this->errors[]='�����빤��ʱ��!';
					   }else{
							 $checknum+=1;
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

    //������ʾ
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
							
							
                       $taskuser=$this->GetMysqlOne('b.username,b.uid,b.dateline AS regtime,b.logintime,c.certificate,d.credit,credits,credittype',"  ((".$this->GetTable('member')." AS b LEFT JOIN ".$this->GetTable('member_info')." AS c ON b.uid=c.uid)																																																																LEFT JOIN ".$this->GetTable('member_account')." AS d ON b.uid=d.uid) LEFT JOIN ( SELECT type AS credittype,credit AS credits,uid FROM ".$this->GetTable('credit')." WHERE type=2 ) AS e ON b.uid=e.uid WHERE b.uid='$task[uid]' ");

				
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
	

    function GetTaskOperateMenu($task=array()){
		  
		  if($this->uid!=$task['uid'] && $task['process']<7){
		        $operatemenu='<a href="javascript:;" class="task_mybid" onclick="TaskBids(\''.$task['tid'].'\',0);">��ҪͶ��</a>';
		  }
		  
		  return $operatemenu;
	}  
	
	
	function BidsAction(){
		     				  																
			 $did=$this->GET['did'];
					 	 
		     $task=$this->GetMysqlOne('uid,subject,hidedraft,realnametask,price1,catid'," ".$this->GetTable('task')." WHERE tid='$this->tid'");

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
	
			 //Ȩ��
			 $allow=$this->CheckAllow('task_grab_usergroup',array(
													'adddraft'=>'',
													'addnumberdraft'=>'',
													'joinmoneydraft'=>floatval($task['price1']), //Ͷ���ͽ�Χ
													)
											 );
			
		     if($this->uid){ 		 
					
					  if($allow=='ok'){
								 
								 if(!$this->IsSQL('task_draft',"WHERE tid='$this->tid' AND uid='$this->uid'")){
																														 
										 if($task['uid']==$this->uid){
														
												echo '<p>�Բ��������������Լ�Ͷ�꣡</p>';
												echo $this->CloseNowWindows('#loading');
											    exit();	
										 }	
																   
								 }else{
									    if(!$did){
											 echo '<p>�Բ������Ѿ�Ͷ����ˣ�</p>';
											 echo $this->CloseNowWindows('#loading');
											 exit();	
										}
								 }	
							
					 
					 }else{
						 
						   $errors='';
						   foreach($allow as $value){
								  $errors.='<p>'.$value.'</p>';
						   }
				
						   echo $errors;
						   echo $this->CloseNowWindows('#loading');

					 }
						 
						 
			 }else{
											 
				   $errors='<p>�Բ������¼�������</p>';
			
				   echo $this->CloseNowWindows('#loading');
					  
			 }
			  		 
			 if($did){	
				   $draft=$this->GetMysqlOne('*'," ".$this->GetTable('task_draft')." WHERE tid='$this->tid' AND did='$did' AND uid='$this->uid'");
				  
				   if($this->IsSQL('task_draft',"WHERE tid='$this->tid' AND did='$did' AND uid='$this->uid' AND process=1 ")){
					  
					    echo '<p>�Բ��������б겻�����޸ģ�</p>';
					    echo $this->CloseNowWindows('#loading');
					    exit();
				   }
				  
			 }
	         
						  		 
             $this->AddDraft($did,'addbid',$draft);
			
				 
	}
	
    
	function ShowDraftAction(){
		  include $this->AppsView('draft');
	} 
	
	
	function AddCommentAction(){
		 $uid=$this->uid;
				
		 if($uid>0){
			 
			 
			    $allow=$this->CheckAllow('task_grab_usergroup',array(
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
			 
			 
			    $allow=$this->CheckAllow('task_grab_usergroup',array(
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
						  
						  if($task['uid']==$this->uid || $this->IsService($task['serviceuid']) || $this->IsAdmin()){
							   	   
								  $draftid=$this->ExplodeStrArr($this->POST['draftid']);
								  $idarray=explode(',',$draftid);
								
								  if($this->POST['type']==1){
										//����
										
										if(count($idarray)==1 && $draftid!=0){
		
												 $applydraft=0;
												 if($task['money']>0){
										 
													   if($this->IsSQL('consume'," AS a LEFT JOIN ".$this->GetTable('task_order')." AS b ON a.cid=b.cid WHERE b.tid='$this->tid' AND a.process<6")){
															  echo '�б궩���Ѿ�������,��رն����������<br />';
															  echo $this->CloseNowWindows('#loading');
															  exit();
													   }
													   
													   if($this->IsSQL('task_draft',"WHERE tid='$this->tid' AND process=1")){
		
															$applydraft=0;
															
													   }else{
														   
															$applydraft=1;
													   }
												 }else{
													   $applydraft=1;
												 }
													 
												 if($applydraft){
													 
													  $this->Update('task_draft',array('process'=>1,'proposal'=>$this->str($this->POST['proposal'],200,1,0,1,0,1)),array(),"WHERE did='$draftid'");
													 
													  $this->BidMakeTaskOrder($task,'task_grab_usergroup',$draftid);
		
														  
													  echo '�����ɹ�,�ȴ���֧���йܽ�<br />';
													 
												 }else{
													 
													  echo '���Ѿ������б����,��ȡ��֮ǰ���б�������<br />';
												 }
												
												 echo $this->CloseNowWindows('#loading');
											   
										 }
										
											
			
								  }elseif($this->POST['type']==2){
										
										 //Ȩ��
										 $allow=$this->CheckAllow('task_grab_usergroup',array(
																		'deletebid'=>''
																		)
																 );
										 
										 if($allow=='ok'){
												if($this->IsSQL('task_draft',"WHERE tid='$this->tid' AND process=0")){
													
														foreach($idarray as $value){ 
															 
															 //֪ͨ��ɾ����
		
															 
															 $this->Delete('task_draft'," WHERE did='$value'");
															
														}
													  
														
														echo '�����ɹ���<br />';
														
												}else{
														echo '�Բ���Ͷ�����б겻�ܲ������<br />';
		
												}
										 }else{
											   
												echo '�Բ�������ʱû��Ȩ��ɾ����<br />';
										 }
										 
										 echo $this->CloseNowWindows('#loading');
									  
				  
								  }elseif($this->POST['type']==3){
										
										if($this->IsSQL('task_draft',"WHERE tid='$this->tid' AND process=1")){
											
												foreach($idarray as $value){ 
													 
													  $this->Update('task_draft',array('process'=>0),array(),"WHERE did='$value'");
													
												}
											  
												//֪ͨ��ȡ����
												
												echo '�����ɹ���<br />';
												echo $this->CloseNowWindows('#loading');
										}else{
												echo '�Բ���Ͷ��û���б겻�ܲ������<br />';
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
			  
			    echo '��ѡ��Ͷ����в���!<br />';
			    echo $this->CloseNowWindows('#loading');
			  
		  }
		
	}
	
	
}




?>