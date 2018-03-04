<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.1
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(APPS.'/taskmode/my_phpapp.php');
	
class TaskModeMainControls extends MyTaskMode{
	
    public $POST,$GET,$errors,$control,$tid,$did;
	
	function __construct(){	
	
		   parent::__construct();
		   
		   $this->tid=empty($_GET['tid']) ? 0 : intval($_GET['tid']);

		   $postkey=array('Submit'=>'','SecurityForm'=>'','edittid'=>'');
			
			
		   $this->POST=$this->POSTArray();
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','total','id','op','item','sort','more','tab','did','select'));
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
      
	}
	
	
	function DefaultAction(){
		
		  $this->TaskListAction();
	}
	
	function AddAction(){
		 
		  if(PHPAPP::$config['task_releasemode']){

				  $this->SetTaskReleaseMode();

		  }else{
				  //ֱ�ӷ���
				  $this->GetExtendControl();
				  
				  $this->control->AddDataAction();
		  }
	}
	
	
	
	function SetTaskReleaseMode(){
		
		    if($this->POST['Submit']){	

				  $this->GetExtendControl(intval($this->POST['appid']));
				  
				  $this->control->AddDataAction();
			
			}else{
		
		          include $this->AppsView('add');
			
			}
	}
	
	
	function GetExtendControl($appid=0){
		   
		   $appwhere='';
		   if($appid>0){
			    $appwhere=" AND b.id_phpapp='$appid' ";
		   }
		
		   $taskmode=$this->GetMysqlOne('b.dir_phpapp,b.class_phpapp'," ".$this->GetTable('task_mode')." AS a LEFT JOIN ".$this->GetTable('apps')." AS b ON a.appid=b.id_phpapp WHERE a.status=0 $appwhere ORDER BY a.displayorder ASC");
		   
		   if($taskmode['dir_phpapp']){
				   $appclassfile=APPS.'/'.$taskmode['dir_phpapp'].'/main_phpapp.php';
				   if(file_exists($appclassfile)){
						include_once($appclassfile);
						$ControlClass=$taskmode['class_phpapp'].'MainControls';
						$this->control = new $ControlClass;
				   }else{
						$this->Refresh('Ӧ�ò����ڣ�',SURL);
				   }
		   }else{
			     $this->Refresh('Ӧ�ò����ڣ�',SURL);
		   }
         
	}
	
	
	function TaskAddAction(){
		
		if($this->POST['Submit']){	
		
			    $this->tid=$this->POST['tid'];
				
				$strings=new CharFilter($this->POST['content']);
				if(empty($this->POST['content'])){
					 echo '�����벹������!';
					 echo $this->CloseNowWindows('#loading');
				}elseif($strings->CheckLength(5)){ 
					 echo '�Բ���,���񲹳䲻����5����!';
					 echo $this->CloseNowWindows('#loading');
				}else{
					
						//����
					$content=$this->str($this->POST['content'],200,0,1,1,0,1);
				    
					if($this->tid!=0){
						
						 $task=$this->GetMysqlOne('uid,subject'," ".$this->GetTable('task')." WHERE tid='$this->tid'");
					     
						 if($task['uid']==$this->uid){
						        $this->Insert('task_add',array('uid'=>$this->uid,'tid'=>$this->tid,'content'=>$content,'dateline'=>$this->NowTime()),array());
								echo '�������񲹳�ɹ�!<br />';
						 }else{
							    echo '�Բ����벻Ҫ�Ƿ���������!<br />';
						 }
					}
					
					echo $this->CloseNowWindows('#loading',1);
					
				}
				
				
		}else{

		      include $this->AppsView('taskadd');
		}
	}
	
	function TaskFavoritesAction(){
		  if($this->tid!=0){
				 if($this->uid){
					    if($this->IsSQL('task_favorites',"WHERE tid='$this->tid' AND uid='$this->uid'")){
							 echo '���Ѿ��ղع���!<br />';
						}else{
							 $this->Insert('task_favorites',array('uid'=>$this->uid,'tid'=>$this->tid,'dateline'=>$this->NowTime()),array());
							 echo '�ղسɹ�!<br />';
						}

				 }else{
						echo '�Բ������¼�����!<br />';
				 }
		   }
					
		   echo $this->CloseNowWindows('#loading');
	}
	
	
	function ReportAction(){
        
		$this->did=$this->GET['did'];
		
		if($this->did>0){
			
			  $reportinfo=$this->GetMysqlOne('a.uid,a.content AS description,b.*,c.appid'," (".$this->GetTable('task_draft')." AS a LEFT JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid ) LEFT JOIN ".$this->GetTable('task')." AS c ON a.tid=c.tid WHERE a.tid='$this->tid' AND a.did='$this->did' ");      
 
			
		}
		
		if($this->tid>0 && $this->did<1){
			  $reportinfo=$this->GetMysqlOne('a.uid,a.description,a.url,b.*'," ".$this->GetTable('task')." AS a LEFT JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid WHERE a.tid='$this->tid'");      
		}
		
		if($this->IsSQL('report',"WHERE tid='$this->tid' AND did='$this->did' AND uid='$this->uid'")){
				echo '����Ϣ���Ѿ��ٱ����ˣ��������յ��ᾡ�촦��,лл����֧�֣�<br />';
				echo $this->CloseNowWindows('#loading');
				exit();
		}
		//����
		$reporttypearr=$this->GetMysqlArray('*'," ".$this->GetTable('report_type')."");
		
		 
		if($this->POST['Submit']){	

		       if($this->uid){
				      
					 //֪ͨ���ٱ���

					  $send_content='<p>����������Ϣ����</p>';
					  $send_content.='<p>'.$reportinfo['description'].'</p>';
					  
					  
					  if($this->did>0){
				      	    $send_subject='��������'.$this->did.'�Ÿ���ѱ��ٱ�!';
							$send_content.='<p><a href="'.SURL.'/index.php?app='.$reportinfo['appid'].'&action=5&tid='.$this->tid.'&did='.$this->did.'" target="_blank">�鿴���</a></p>';
					  }
					  
					  if($this->tid>0 && $this->did<1){
						    $send_subject='��������'.$this->tid.'�������ѱ��ٱ�!';
							$send_content.='<p><a href="'.SURL.$reportinfo['url'].'" target="_blank">�鿴����</a></p>';
					  }



					  //����
					  $this->Port(array(
										
							   //Login
							  'login_uid'=>$this->uid,
							
							  //Credit
							  'credit_uid'=>$this->uid,
							  	
							  
							  'receive_uid'=>$reportinfo['uid'], //������
							  
							  //SMS
							  'sms_subject'=>$send_subject,
							  'sms_content'=>$send_content,
											
							  //EMail
							  'email_title'=>$send_subject,
							  'email_content'=>$send_content,
	
							  //Mobile
							  'mobile_content'=>$send_subject
								
										
					   ),7);
				   
				   
				   
				   
				   
					   
					 $this->Insert('report',array('type'=>$this->POST['reporttype'],'uid'=>$this->uid,'tid'=>$this->tid,'did'=>$this->did,'dateline'=>$this->NowTime()),array());
					 echo '�ٱ��ɹ������ǻᾡ�촦��<br />';

			   }else{
				     echo '�Բ������¼�����!<br />';
			   }
			   
			   echo $this->CloseNowWindows('#loading');
		}else{

		      include $this->AppsView('taskreport');
		}
		
	}
	
	
	function BuyServiceAction(){
        
		$task=$this->GetMysqlOne('uid,subject,url,appid,process'," ".$this->GetTable('task')." WHERE tid='$this->tid'");

		if($task['process']>1 && $task['process']<5){
				if($task['uid']==$this->uid){
					
					$props=$this->ExplodeStrArr($_GET['props']);
					if($props){
							$totalservice=0;
							
							if($props){
								  $servicelist=$this->GetMysqlArray('a.sid,a.subject,a.price,a.icon,b.amount,a.appid'," (SELECT sid,subject,price,icon,appid FROM ".$this->GetTable('prop')." WHERE sell='0' AND sid IN($props)  ORDER BY displayorder ASC ) AS a LEFT JOIN (SELECT sid,amount FROM ".$this->GetTable('prop_order')." WHERE uid='$task[uid]' AND sid IN($props) ) AS b ON a.sid=b.sid");
								  
								  if($servicelist){
										foreach($servicelist as $service){
											   if(!$service['amount']){
													 $totalservice+=$service['price'];
											   }
										}
								  }
							 }
							 
							$totalmoney=$totalservice;
							
							include $this->AppsView('propconfirm');
					 }else{
						
						  $this->Refresh('��û����ֵ������',SURL.$task['url']);
					 }
				
				}else{
					
					 $this->Refresh('��û��Ȩ�޹���',SURL.$task['url']);
				}
				
			}else{
				
				 $this->Refresh('�Բ�������ǰ״̬���ܹ������',SURL.$task['url']);
			}

	}
	
	function PayServiceAction(){
		
		 if($this->ExplodeStrArr($_GET['props'])){
		 
			 $task=$this->GetMysqlOne('uid,subject,url,appid,process'," ".$this->GetTable('task')." WHERE tid='$this->tid'");
			 
			 if($task['process']>1 && $task['process']<5){
					 if($task['uid']==$this->uid){
							
						   include_once(APPS.'/taskmode/public_phpapp.php');
						  
						   $pay=new TaskPublicClass();
						   
						   $pay->PayTaskAction(1); //����֧��
						
					 }else{
						
						   $this->Refresh('��û��Ȩ�޹���',SURL.$task['url']);
					 }
					 
			 }else{
				
				   $this->Refresh('�Բ�������ǰ״̬���ܹ������',SURL.$task['url']);
			 } 
		 }else{
				
				$this->Refresh('��û����ֵ������',SURL.$task['url']);
		 }
		
	}
	
	
	function TaskPayAction(){
		
		 if($this->tid){
		 
			 $task=$this->GetMysqlOne('*'," ".$this->GetTable('task')." WHERE tid='$this->tid'");
			
			 if($task['uid']==$this->uid){
					
				     if($this->POST['Submit']){	
					      
							if(!$this->POST['total']){
								  echo '������������';
								  exit();
							}
							
							if(!$this->POST['money']){
								  echo '�������ͽ�';
								  exit();
							}
							
							$this->POST['money']=$this->POST['total'] * $this->POST['money'];
							
							$this->Update('task',$this->POST,array('process'=>1)," WHERE tid='$this->tid' AND uid='$this->uid' ");	
			                
							echo $this->tid;

					 }else{
						   
						   include $this->AppsView('taskpay');
						 
					 }
				
			 }else{
				
				   echo '��û��Ȩ��֧����';
				   
				   echo $this->CloseNowWindows('#loading');
			 }
		 }else{
				
				echo '���񲻴��ڣ�';
				
			    echo $this->CloseNowWindows('#loading');
		 }
		 
		
		
	}
	
	
	function AddMoneyAction(){

		 if($this->tid){
		 
			 $task=$this->GetMysqlOne('*'," ".$this->GetTable('task')." WHERE tid='$this->tid'");
			
			 if($task['uid']==$this->uid){
					
				     if($this->POST['Submit']){	
								
							if(!$this->GET['type']){
									
								   $money=intval($this->POST['increase']);
									
								   if(!$money){
										  echo '������Ӽ��ͽ�';
										  echo $this->CloseNowWindows('#loading');
										  exit();
								   }
								   
								   if($task['total']==1 && $task['draft_success']>0){
									   
									      echo '�Բ���!Ŀǰ����״̬���ܼӼۣ�<br />';
													 
										  echo $this->CloseNowWindows('#loading');
										  
									      exit();
							
							       }elseif($task['process']>5 || $task['process']<3 ){
									   
										  echo '�Բ���!Ŀǰ����״̬���ܼӼۣ�<br />';
													 
										  echo $this->CloseNowWindows('#loading');
										  
									      exit();
										  
								   }else{
									   
									   
										  $allow=$this->CheckAllow('task_count_usergroup',array(
																  'increasetask'=>'',
																  'addmoneytask'=>intval($this->POST['increase'])
																  ),80
														   );
						   
										  if($allow=='ok'){

												$member=$this->GetLoginInfo($this->uid);
										  
												if($member['money']>=$money){ 
														
														$taskmoney=$task['money']+$money;
														
														$addmoneynum=$task['addmoneynum']+1;
														
														$taskaddmoney=$task['addmoney']+$money;
														//����
														$endtime=$task['endtime'];
														
														$getallow=$this->GetAllow('task_count_usergroup',array('extendmoneytask','extendnumbertask'));
														
														
														$extendtime=$money/$getallow['extendmoneytask'] * $getallow['extendnumbertask'];
		  
														$this->Update('task',array('money'=>$taskmoney,'addmoneynum'=>$addmoneynum,'addmoney'=>$taskaddmoney,'endtime'=>$endtime+($extendtime*24*60*60),'process'=>4),array(),"WHERE tid='$this->tid'");  
														 
														 
														 @include_once(APPS.'/apppay/class/consume_class_phpapp.php');
														 $pay=new UserConsume();
										
														$newcid=$pay->MakeConsume(array(
																 'subject'=>'<p>����Ӽ�</p>���������ͽ�', 
																 'appid'=>intval($this->app),
																 'process'=>1,
																 'amount'=>$money,
																 'paytype'=>1, 
																 'payout'=>$this->uid,   //֧����ID
																 'payin'=>0    //������ID
																 
														   ));
										  
														$pay->SetSuccessConsume($newcid);
														
													   //֪ͨͶ����	
													  
													   $taskdraftarr=$this->GetMysqlArray('uid'," ".$this->GetTable('task_draft')." WHERE tid='$this->tid' AND process=0 GROUP BY uid ");
													  
													   if($taskdraftarr){
														  
															  $send_subject=$this->tid.'������Ӽ���!';
															  $send_content=$this->tid.'������Ӽ���'.$money.'Ԫ!<p><a href="'.SURL.$task['url'].'" target="_blank">�鿴����</a></p>';
															  
															  foreach($taskdraftarr as $taskdraft){
																	  $this->Port(array(
                                                                              
																			  'credit_uid'=>$this->uid,
																			  
																			  'receive_uid'=>$taskdraft['uid'], //������
																			  
																			  //SMS
																			  'sms_subject'=>$send_subject,
																			  'sms_content'=>$send_content,
																							
																			  //EMail
																			  'email_title'=>$send_subject,
																			  'email_content'=>$send_content,
													
																			  //Mobile
																			  'mobile_content'=>$send_subject
																				
																						
																	   ),11);
															  }
				
													    }
														
														
			
														echo '�Ӽ۳ɹ�!';
														echo '<br />'.$this->CloseNowWindows('#loading',1);
												
												}else{
													
													 echo '�Բ���!��������'.$money.'Ԫ,���ֵ�����!<br />';
													 
													 echo $this->AjaxRefresh(SURL.'/member.php?app=5&action=2&pay='.$money,1);
													   
												}
												
												
										  }else{
											  
												foreach($allow as $value){
													 echo $value;
												}
												
												echo '<br />'.$this->CloseNowWindows('#loading');
										  }
								   }
								   
							}else{
								
								   if($task['process']>5 || $task['process']<3 ){
									   
										  echo '�Բ���!Ŀǰ����״̬���ܼӼ���<br />';
													 
										  echo $this->CloseNowWindows('#loading');
									   
									   
								   }else{
									   
										  $item=intval($this->POST['item']);
										  
										  if(!$item){
												  echo '�����������';
												  echo $this->CloseNowWindows('#loading');
												  exit();
								          }
												
										  if($item>0){
	
												$member=$this->GetLoginInfo($this->uid);
										
												$money=$item * floor($task['money']/$task['total']*100)/100;
										  
												if($member['money']>=$money){ 
	
														@include_once(APPS.'/apppay/class/consume_class_phpapp.php');
														$pay=new UserConsume();
										
														$newcid=$pay->MakeConsume(array(
																 'subject'=>'<p>����Ӽ�</p>�����������', 
																 'appid'=>intval($this->app),
																 'process'=>1,
																 'amount'=>$money,
																 'paytype'=>1, 
																 'payout'=>$this->uid,   //֧����ID
																 'payin'=>0    //������ID
																 
														   ));
										  
														$pay->SetSuccessConsume($newcid);
														
														$taskmoney=$task['money']+$money;
														
														$tasktotal=$task['total']+$item;
		
														$this->Update('task',array('money'=>$taskmoney,'total'=>$tasktotal,'process'=>4),array(),"WHERE tid='$this->tid'");  
														 
			
			
													   //֪ͨͶ����	
													  
													   $taskdraftarr=$this->GetMysqlArray('uid'," ".$this->GetTable('task_draft')." WHERE tid='$this->tid' AND process=0 GROUP BY uid ");
													  
													   if($taskdraftarr){
														  
															  $send_subject=$this->tid.'������Ӽ���!';
															  $send_content=$this->tid.'���������'.$item.'������!<p><a href="'.SURL.$task['url'].'" target="_blank">�鿴����</a></p>';
															  
															  foreach($taskdraftarr as $taskdraft){
																	  $this->Port(array(
                                                                              
																			  'credit_uid'=>$this->uid,
																			  
																			  'receive_uid'=>$taskdraft['uid'], //������
																			  
																			  //SMS
																			  'sms_subject'=>$send_subject,
																			  'sms_content'=>$send_content,
																							
																			  //EMail
																			  'email_title'=>$send_subject,
																			  'email_content'=>$send_content,
													
																			  //Mobile
																			  'mobile_content'=>$send_subject
																				
																						
																	   ),11);
															  }
				
													    }
														
														echo '�Ӽ��ɹ�!';
														echo '<br />'.$this->CloseNowWindows('#loading',1);
												
												}else{
													
													 echo '�Բ���!��������'.$money.'Ԫ,���ֵ�����!<br />';
													 
													 echo $this->AjaxRefresh(SURL.'/member.php?app=5&action=2&pay='.$money,1);
													   
												}
												
												
										  }else{
													
													 echo '�Բ���!���ļӵļ�������Ϊ0��,��������д!<br />';
													 
													 echo '<br />'.$this->CloseNowWindows('#loading');
													   
										  }
	
								   }
								
							}

			                
							   
							   
							   //echo $this->tid;
					 }else{
						   
						   
			
							//Ȩ��
							$allow=$this->CheckAllow('task_count_usergroup',array(
													'increasetask'=>''
													),80
											 );

							if($allow=='ok'){
									 
									 $member=$this->GetLoginInfo($this->uid);
									 
									 if(!$this->GET['type']){
	
										   $getallow=$this->GetAllow('task_count_usergroup',array('extendmoneytask','extendnumbertask','addmoneytask'));
										   
										   include $this->Template('increase');
									 }else{
										   include $this->Template('item');
									 }
							}
						 
					 }
				
			 }else{
				
				   echo '��û��Ȩ��֧����';
				   
				   echo $this->CloseNowWindows('#loading');
			 }
		 }else{
				
				echo '���񲻴��ڣ�';
				
			    echo $this->CloseNowWindows('#loading');
		 }
		 
		
	}
	
	
	
	//�б�
	function TaskListAction($catid=0,$skill=0){

		   
		   include_once(Core.'/class/skill_class_phpapp.php');
		   
		   $skilldata=new SkillClass();
		   
           $selectarray=array(
	
					  array('name'=>'Ĭ������','data'=>array('Ĭ������','���Ӹߵ���','���ӵ͵���','�μ��������ٵ���','�μ������Ӷൽ��','ʣ��ʱ����ٵ���','ʣ��ʱ��Ӷൽ��','�Ƽ�����'),'id'=>'sort'),	
					  array('name'=>'�б��л�','data'=>array('0'=>'0','1'=>'1'),'id'=>'tab'),
					  
					  array('name'=>'����ɸѡ','data'=>array('0'=>'0','1'=>'1'),'id'=>'more')
			     );
   
   
		   require_once(Core.'/class/list_class_phpapp.php');
		   
		   $selectclass=new SelectData($selectarray,$catid,$skill);

		   $selectitem=$selectclass->GetSelectOne('task_select');
		   
		   $selectctarray=$selectclass->GetSelectCategory();

		   $selectsql=$selectclass->GetSelectOneSQL($selectitem[2],$selectctarray[5]);
		   
		    include_once(Core.'/class/pages_class_phpapp.php');
				

					 //����
					 switch ($this->GET['sort']) {
							 case '1':
							 $order=' money DESC';
							 break;
							 case '2':
							 $order=' money ASC';
							 break;
							 case '3':
							 $order=' draft_number ASC';
							 break;
							 case '4':
							 $order=' draft_number DESC';
							 break;
							 case '5':
							 $order=' endtime ASC';
							 break;
							 case '6':
							 $order=' endtime DESC';
							 break;
							 case '7':
							 $order=' topbid DESC';
							 break;
							 default:
							 $order=' topbid DESC ,process ASC,dateline DESC ';
					 }
								
					
							
						   
				    $pageurl=$selectclass->GetSelectAllURL();
				   
				    $page=new Pages(20,$this->GET['page'],$pageurl,"SELECT * FROM ".$this->GetTable('task')." WHERE	appid!=82 AND lang='$this->lang' AND process>0 $selectsql ORDER BY $order ");
			 

			   
			       $list=$page->ShowResult();
				   

				   
				   //SEO
				   PHPAPP::$SEO['title']=empty($selectctarray[2])? '' :$selectctarray[2];
				   PHPAPP::$SEO['keywords']=empty($selectctarray[3])? '' :$selectctarray[3];
				   PHPAPP::$SEO['description']=empty($selectctarray[4])? '' :$selectctarray[4];
				   
		
				   include $this->AppsView('taskmode:list');
		    
	}
	
	
	function MyFollowAction(){
		   
		   $catid=$this->GET['catid'];

		   $skill=$this->GET['skill'];
	
		   $follow=$this->GetMysqlOne('*'," ".$this->GetTable('follow')." WHERE uid='$this->uid' ");
		   

		   if($follow['catids'] && $catid){
			     $catidsarr=explode(',',$follow['catids']);	
				 $iscatid=0;
				 foreach($catidsarr as $value){
					  if($catid==$value){
						   $iscatid=1;
					  }
				 }
				 
				 if($iscatid){
					   echo '<p>���Ѿ���ע���ˣ�</p>';
				   	   echo $this->CloseNowWindows('#loading');
					   exit();
				 }else{
					   $follow['catids'].=','.$catid;
				 }
			  	 
		   }elseif(!$follow['catids'] && $catid){
			     $follow['catids']=$catid;
		   }
		   
		   //skills			
		   if($follow['skills'] && $skill){
			  	 
				 $skillsarr=explode(',',$follow['skills']);	
				 $isskill=0;
				 foreach($skillsarr as $value){
					  if($skill==$value){
						   $isskill=1;
					  }
				 }
				 
				 if($isskill){
					   echo '<p>���Ѿ���ע���ˣ�</p>';
				   	   echo $this->CloseNowWindows('#loading');
					   exit();
				 }else{
					   $follow['skills'].=','.$skill;
				 }
				 
				 
				 
		   }elseif(!$follow['skills'] && $skill){
			     $follow['skills']=$skill;
		   }
				 
		   if(!empty($follow['uid'])){
			     $this->Update('follow',array('catids'=>$follow['catids'],'skills'=>$follow['skills']),array(),"WHERE uid='$this->uid'");  
		   }else{
			     $this->Insert('follow',array('uid'=>$this->uid,'catids'=>$follow['catids'],'skills'=>$follow['skills']),array());
		   }
		   
		   echo '<p>��ע�ɹ���</p>';
		   echo $this->CloseNowWindows('#loading');
	}
	
}




	
?>