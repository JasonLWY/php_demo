<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.1
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(Core.'/class/filter_class_phpapp.php');

class TaskPublicClass extends PHPAPP{
	
    public $POST,$GET,$errors;
	
	public $tid,$did;
	
	function __construct(){	
	
		   parent::__construct();

		   $this->tid=empty($_GET['tid']) ? 0 : intval($_GET['tid']);
		   $this->did=empty($_GET['did']) ? 0 : intval($_GET['did']);

		   $postkey=array('Submit'=>'','SecurityForm'=>'','edittid'=>'');
			
			
		   $this->POST=$this->POSTArray();
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','total','id','op','item','sort','more','tab','did','select'));
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
		   
	}
	
	
	function AddTaskInfoShow($view){
		  //�����Ƿ����
		   $this->IsTaskTrue($this->tid);
		   
		   $this->IsTaskAddSuccess($this->tid);

		   $task=$this->GetMysqlOne('a.*,b.usertype,b.username'," ".$this->GetTable('task')." AS a LEFT JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid WHERE a.tid='$this->tid' AND a.uid='$this->uid' ");

		   if($task){
			     $totalservice=0;
				 $skillarr=$this->GetMysqlArray('name'," ".$this->GetTable('skills')." WHERE sid IN($task[skills]) ");
				 if($props=$task['props']){
					  $servicelist=$this->GetMysqlArray('a.sid,a.subject,a.price,a.icon,b.amount,a.appid'," (SELECT sid,subject,price,icon,appid FROM ".$this->GetTable('prop')." WHERE sell='0' AND sid IN($props)  ORDER BY displayorder ASC ) AS a LEFT JOIN (SELECT sid,amount FROM ".$this->GetTable('prop_order')." WHERE uid='$task[uid]' AND sid IN($props) ) AS b ON a.sid=b.sid");
					  
					  if($servicelist){
						    foreach($servicelist as $service){
								   if(!$service['amount']){
									     $totalservice+=$service['price'];
								   }
							}
					  }
				 }
				 
				 $totalmoney=$totalservice+$task['money'];
				 
			     $edittid=$this->tid;
				 $taskmode=$this->GetMysqlArray('*'," ".$this->GetTable('task_mode')." WHERE status=0 ORDER BY displayorder ASC");
				 include $this->AppsView($view);
		   }else{
			    $this->Refresh('���񲻴��ڻ��ѱ�ɾ��!',SURL);
		   }
		  
	}
	
	//ȷ������
	function TaskConfirmAction(){
		  $this->AddTaskInfoShow('confirm');

	}
	
	//�޸�����
	function TaskEditAction(){
		  $this->AddTaskInfoShow('add');
	}
	
	function PayTaskAction($paytype=0){
		     
			 $uid=$this->uid;
			  
			 $this->IsTaskTrue($this->tid);
			 
			 if(!$paytype){
			 	   $this->IsTaskAddSuccess($this->tid);
			 }

			 $taskarr=$this->GetMysqlOne('*'," ".$this->GetTable('task')." WHERE tid='$this->tid'");
			 
			 $taskmoney=floatval($taskarr['money']);
			 
		     if($taskarr['tid']>0){
				           
						     $totalservice=0;
							 $buyservice=array();
							 
							 $props=$taskarr['props'];
							 
							 if($paytype>0){
									  $newprops=$this->ExplodeStrArr($_GET['props']);
									  if($newprops){
										   $props=$newprops;
									  }else{
										   echo 'û��ѡ����ֵ����';
										   echo $this->AjaxRefresh(SURL.$taskarr['url'],1);
										   exit();  
									  }
							 }

							 if($props){

								  $servicelist=$this->GetMysqlArray('a.sid,a.subject,a.price,a.icon,b.amount,a.appid'," (SELECT sid,subject,price,icon,appid FROM ".$this->GetTable('prop')." WHERE sell='0' AND sid IN($props)  ORDER BY displayorder ASC ) AS a LEFT JOIN (SELECT sid,amount FROM ".$this->GetTable('prop_order')." WHERE uid='$taskarr[uid]' AND sid IN($props) ) AS b ON a.sid=b.sid");
								  $ismap=0;
								  if($servicelist){
										foreach($servicelist as $service){
											   if($service['appid']==72){
												    $ismap=1;
											   }
											   if(!$service['amount']){
													 $totalservice+=$service['price'];
													 $buyservice[]=$service['sid'];
											   }
										}
								  }
								  

								  if($ismap){
									   
										$member=$this->GetMysqlOne('username,usertype'," ".$this->GetTable('member')." WHERE uid='$this->uid'");
								 
										$membertable=$this->GetTypeMember($member['usertype']);
								 
										$info=$this->GetMysqlOne('*',"  ".$this->GetTable($membertable)."  WHERE uid='$this->uid'");
									
										if(!$info['tasklatitude'] || !$info['tasklongitude'] || !$info['taskcity']){
											   echo '<p>�Բ�����ʹ���˵�ͼ��λ���������õ�ͼλ��.</p>';
											   echo $this->CloseNowWindows('#loading');	
											   exit();
										}
								  }
			 
							 }

							 
							 //����û����ý��
							 $user=$this->GetMysqlOne('*'," ".$this->GetTable('member_account')." WHERE uid='$uid'");
							 
							 if($paytype>0){
						
								   if($user['money']>=($totalservice)){
									        
											$this->PayServiceProp($props,$taskarr,$buyservice);
											
											if($taskarr['props']){
												 
												  $taskprops=explode(',',$taskarr['props']);
												  
												  $newprops=explode(',',$props);
												  
												  $propsarry=array_unique(array_merge($taskprops,$newprops));
												  
												  $props='';
												  foreach($propsarry as $propid){
													    if($props){
															 $props.=','.$propid;
														}else{
															 $props=$propid;
														}
												  }
												  
											}
											
											$this->Update('task',array('props'=>$props),array()," WHERE tid='$this->tid' ");
									   
								   }else{
									   
									        echo '<p>�Բ������Ŀ������� '.$totalservice.' Ԫ,���ֵ�������</p>';
											echo $this->AjaxRefresh(SURL.'/member.php?app=5&action=2&pay='.$totalservice,1);
											exit();
											
								   }
								 
							 }else{
									 if($user['money']>=($taskmoney+$totalservice)){
										   
											//ֱ��֧��
											$this->TaskPayComplete($taskmoney,$props,$taskarr,$buyservice);
		
									 }else{
										 
											include_once(APPS.'/pay/main_phpapp.php');
											
											$pay=new PayMainControls();
											
											$pay->UserPay($taskmoney,$totalservice,$this->tid);
									 }
							 }
							  
		                     exit();
							 
			 }else{
				    echo '���񲻴���!';
							 
				    echo $this->AjaxRefresh(SURL,1);
			 }
		
	}
	
	function PayServiceProp($props='',$taskarr=array(),$buyservice=array()){
		   $this->UseServiceProp($props,$taskarr,$buyservice);
		   
		   echo '����ɹ���';
		   
		   echo $this->AjaxRefresh(SURL.$taskarr['url'],1);
	}
	
	function UseServiceProp($props='',$taskarr=array(),$buyservice=array(),$did=0,$myserviceid=0){
		
		  if($buyservice){
			  include_once(APPS.'/prop/class/prop_class_phpapp.php');								   
			  $buy=new SiteProp();

			  foreach($buyservice as $service){ 

			       $buy->BuyProp(array('sid'=>$service,'amount'=>1,'jump'=>1));
			  }
		  }
		  
		  //ʹ�õ���
		  $this->ConsumeService($props,$did,$myserviceid);
		
	}
	
	function TaskPayComplete($taskmoney,$props='',$taskarr=array(),$buyservice=array()){

		  //�й�����
		  if($taskmoney>0){
				  include_once(APPS.'/apppay/class/consume_class_phpapp.php');
		
				  $pay=new UserConsume();
				  
				  $newcid=$pay->MakeConsume(array(
										  'subject'=>'<p>�й��ͽ�</p>'.$taskarr['tid'].'����',  
										  'appid'=>$this->app, 
										  'paytype'=>1, 
										  'process'=>1, 
										  'amount'=>$taskmoney, 
										  'payout'=>$this->uid, 
										  'payin'=>0
										  
									));
				  
				  
				  
				  $pay->SetSuccessConsume($newcid); 
		  }
		  
		  
		  $this->UseServiceProp($props,$taskarr,$buyservice);
          

		  if(PHPAPP::$config['task_check']>0){
		  
		         $this->UpdateTaskProcess(4,$this->tid);
                 
				 $send_subject='����'.$taskarr['tid'].'���������ͨ�������ɹ���!';
				 $send_content='����'.$taskarr['tid'].'���������ͨ�������ɹ���!,<a href="'.SURL.$taskarr['url'].'" target="_blank">�鿴����</a>';

				  //�ӿ�
				  $this->Port(array(
									
						  //Login
						  'login_uid'=>$this->uid,
						
						  //Credit
						  'credit_uid'=>$this->uid,
						 
						  'receive_uid'=>$this->uid, //������
						  //SMS
						  'sms_subject'=>$send_subject,
						  'sms_content'=>$send_content,
										
						  //EMail
						  'email_title'=>$send_subject,
						  'email_content'=>$send_content,
						  
						  //Mobile
						  'mobile_content'=>$send_subject
							
									
				  ),1);
				  
				 echo '�����ɹ�!';

		  }else{
			     echo '�����ɹ�,���������!';
				 $this->UpdateTaskProcess(3,$this->tid);

		  }
		  
		  
		  $this->Update('task',array('dateline'=>$this->NowTime()),array()," WHERE tid='$this->tid' ");


		  $tasknum=$this->IsSQL('task',"WHERE uid='$this->uid'");
										    
		  $this->UpdateTaskCount('tasknum',$tasknum);	
		  
		  //skills 
		  $this->UpdateTaskSkills($taskarr['skills']);	

		  
							 
		  echo $this->AjaxRefresh(SURL.$taskarr['url'],1);
		  


	}
	
	//������������
	function UpdateTaskProcess($process,$tid){
		  return $this->Update('task',array('process'=>$process),array(),"WHERE tid='$tid'");
	}
	
	function UpdateTaskCount($namenum,$value,$uid=0){
		    
			if(!$uid){
				 $uid=$this->uid;
			}
			
		    if(!$this->IsSQL('task_total'," WHERE uid='$uid' ")){
				 
				   $count=array('uid'=>$uid,$namenum=>$value);
				
				   $this->Insert('task_total',$count,array());
				
			}else{
				   
				   $count=array($namenum=>$value);
				  
	               $this->Update('task_total',$count,array()," WHERE uid='$uid' ");
			}
	}

	 	
     function SetTaskDraftProcess($tablename,$ids,$draftprocess=0,$consumeprocess=0){
		
		      $this->Update($tablename.'_draft',array('process'=>$draftprocess),array(),"WHERE did IN($ids)");
		
			  $draftarr=$this->GetMysqlArray('tid,did,process'," ".$this->GetTable($tablename.'_draft')." WHERE did IN($ids) ");    
			  
			  if($draftarr){
					 foreach($draftarr as $draft){
							
							$draft_success=$this->IsSQL($tablename.'_draft'," WHERE tid='$draft[tid]' AND process=1");
							
							$this->Update($tablename,array('draft_success'=>$draft_success),array(),"WHERE tid='$draft[tid]'");
							
					 }
			  }
			  
			  $weiboorderarray=$this->GetMysqlArray('*'," ".$this->GetTable($tablename.'_order')." WHERE did IN($ids) ");    
			  
			  if($weiboorderarray){
				  
					foreach($weiboorderarray as $value){
						
							@$this->Update('consume',array('process'=>$consumeprocess),array(),"WHERE serial='$value[serial]'");
					}
				  
			  }
			  
			  echo $this->Refresh('���óɹ�!',$this->MakeGetParameterURL());
	 }
	 
	 
	 
	 function GetSkillsKeywords($ids){
		    
			$skillsarr=$this->GetMysqlArray('*'," ".$this->GetTable('skills')." WHERE sid IN($ids)");
			$Keywords='';
			if($skillsarr){
				
				  foreach($skillsarr as $value){
					     if($Keywords){
							    $Keywords.=','.$value['name'];
						 }else{
							    $Keywords=$value['name'];
						 }
				  }
			}
			
			return $Keywords;
			
	 }
	 
	 
	 function IsTaskTrue($tid=0){
			if(!$this->IsSQL('task'," WHERE tid='$tid' AND uid='$this->uid'")){
				   $this->Refresh('���񲻴��ڻ��ѱ�ɾ��!',SURL);
				   exit();
			}
	 }
	 
	 //�Ƿ񷢲��ɹ�
	 function IsTaskAddSuccess($tid=0){
			if($this->IsSQL('task'," WHERE tid='$tid' AND process>1 AND uid='$this->uid'")){
				   $this->Refresh('�������Ѿ���˹���!',SURL);
				   exit();
			}
	 }
	
	
	 function GetTaskURL($tid,$did=0,$app=0,$string=''){
		  
		  include_once(Core.'/class/makeurl_class_phpapp.php');
		  
		  $make=new MakeTaskAddressUrl();
		  
		  return $make->GetTaskAddress($tid,$did,$app,$string);

	 }

	
	//����------------------------------------------------------------------
	
	function SetPropFlashTask($service=''){
		  
		  if($service['serviceid']){ //������
		       $sid=intval($service['serviceid']);
		       $this->Update('task_seller_service',array('openflash'=>1),array(),"WHERE sid='$sid' ");
		  
		  }elseif($service['did']){ //���
		       $did=intval($service['did']);
			   $this->Update('task_draft',array('openflash'=>1),array(),"WHERE did='$did' ");
		  }else{
			   $this->Update('task',array('openflash'=>1),array(),"WHERE tid='$service[tid]'");
		  }
	}
	
	//�Ƽ�
	function SetPropDefaultTop($service='',$top=0){
          
		  
		   if($service['serviceid']){ //������
		         $sid=intval($service['serviceid']);
				 $servicearr=$this->GetMysqlOne('topbid'," ".$this->GetTable('task_seller_service')." WHERE sid='$sid'");
				 if($servicearr['topbid']>0){
				  	     $this->Update('task_seller_service',array('topbid'=>$servicearr['topbid']+$service['price']),array()," WHERE sid='$sid' ");
				 }else{
						 $this->Update('task_seller_service',array('topbid'=>$service['price']),array(),"WHERE sid='$sid' ");
				 }
		  
		   }elseif($service['did']){ //���
		          $did=intval($service['did']);
				  $draftarr=$this->GetMysqlOne('topbid'," ".$this->GetTable('task_draft')." WHERE did='$did'");
				  
				  if($draftarr['topbid']>0){
				  	     $this->Update('task_draft',array('topbid'=>$draftarr['topbid']+$service['price']),array()," WHERE did='$did' ");
				  }else{
						 $this->Update('task_draft',array('topbid'=>$service['price']),array(),"WHERE did='$did' ");
				  }
			   
		   }else{
				   $taskarr=$this->GetMysqlOne('topbid'," ".$this->GetTable('task')." WHERE tid='$service[tid]'");
		
				   if($taskarr['topbid']>0){
						 $this->Update('task',array('topbid'=>$taskarr['topbid']+$service['price']),array()," WHERE tid='$service[tid]'");
				   }else{
						 $this->Update('task',array('topbid'=>$service['price']),array(),"WHERE tid='$service[tid]'");
				   }
		   }
	}
	
	function AddTaskFeed($feedarray=array()){
		
			include_once(APPS.'/feed/class/port_class_phpapp.php');
			new FeedPort($feedarray);

	}
	
	function HideDraft($service=''){

		   if($service['did']){ //���
		         $this->Update('task_draft',array('share'=>1),array(),"WHERE did='$service[did]'");
		   }else{
		   		 $this->Update('task',array('hidedraft'=>1),array(),"WHERE tid='$service[tid]'");
		   }
		  
	}
	
	function HideTask($service=''){

		  $this->Update('task',array('hide'=>1),array(),"WHERE tid='$service[tid]'");
		  
	}
	
	function NoSearch($service=''){
           
		   if($service['serviceid']){ //������
		         $this->Update('task_seller_service',array('robots'=>1),array(),"WHERE sid='$service[serviceid]'");
		   }else{
		   		 $this->Update('task',array('robots'=>1),array(),"WHERE tid='$service[tid]'");
		   }
		  
	}
	
	function RealNameTask($service=''){
           
		   if($service['serviceid']){ 
		   		 $this->Update('task_seller_service',array('realnametask'=>1),array(),"WHERE sid='$service[serviceid]'");
		   }else{
		   		 $this->Update('task',array('realnametask'=>1),array(),"WHERE tid='$service[tid]'");
		   }
		  
	}
	
	
	function AllowTender($service=''){

		   $this->Update('task',array('allowtender'=>1),array(),"WHERE tid='$service[tid]'");
		  
	}

	
	function SetMapLocation($service=''){
            
		   $member=$this->GetMysqlOne('usertype'," ".$this->GetTable('member')." WHERE uid='$this->uid'");
				 
		   $membertable=$this->GetTypeMember($member['usertype']);
				 
		   $info=$this->GetMysqlOne('tasklongitude,tasklatitude,taskmapzoom,taskcity,residelatitude,residelongitude,residemapzoom',"  ".$this->GetTable($membertable)."  WHERE uid='$this->uid'");	 
		   
		   if($service['serviceid']){ 
		         $this->Update('task_seller_service',array('longitude'=>$info['residelongitude'],'latitude'=>$info['residelatitude'],'mapzoom'=>$info['residemapzoom']),array()," WHERE sid='$service[serviceid]' AND uid='$this->uid'");	
		   }else{
		   		 $this->Update('task',array('longitude'=>$info['tasklongitude'],'latitude'=>$info['tasklatitude'],'mapzoom'=>$info['taskmapzoom'],'cityid'=>$info['taskcity']),array()," WHERE tid='$this->tid' AND uid='$this->uid'");	
		   
		   }
		  
	}
	
	
	function ConsumeService($props='',$did=0,$serviceid=0){
		
	      //ʹ�õ���
		  include_once(APPS.'/prop/class/prop_class_phpapp.php');
		  $service= new SiteProp($props);
		  
		  $taskarr=$this->GetMysqlOne('*'," ".$this->GetTable('task')." WHERE tid='$this->tid' ");
 
		  $url=$taskarr['url'];
		  
		  if($did>0){
			   $url='/index.php?app='.$taskarr['appid'].'&tid='.$this->tid.'&did='.$did;
		  }
		  
		  if($serviceid>0){
			  
               $url='/index.php?app=82&sid='.$serviceid;
			  
		  }

		  $service->UseProp($this->tid,$url,$did,$serviceid);

		  //���õ���--------------------------------------------------------
		  $group=$this->GetMysqlOne('usergroup'," ".$this->GetTable('member')." WHERE uid='$this->uid'");


		  if($this->IsSQL('prop'," WHERE appid=61 AND status=0 AND sell=1 AND usergroup='$group[usergroup]' ")){
			  
                $feedarray=array(
								 
							'feed_uid'=>$this->uid,
							'feed_username'=>$this->username,
							'feed_app'=>$this->app,
							'feed_action'=>$this->ac,
							'feed_title_template'=>'������ <a href="'.SURL.$taskarr['url'].'" target="_blank" title="'.$taskarr['subject'].'">{title}</a> ����',
							'feed_title_data'=>$taskarr['subject'],
							'feed_content_template'=>'',
							'feed_content_data'=>$taskarr['content']

							
				);
	
				$this->AddTaskFeed($feedarray);
		  }
		 

		  if($this->IsSQL('prop'," WHERE appid=60 AND status=0 AND sell=1 AND usergroup='$group[usergroup]' ")){
		        $this->NoSearch(array('tid'=>$this->tid,'serviceid'=>$serviceid));
		  }
		  

		  if($this->IsSQL('prop'," WHERE appid=62 AND status=0 AND sell=1 AND usergroup='$group[usergroup]' ")){

			     $this->SetPropFlashTask(array('tid'=>$this->tid,'serviceid'=>$serviceid));
		  }
		  

		  if($this->IsSQL('prop'," WHERE appid=63 AND status=0 AND sell=1 AND usergroup='$group[usergroup]' ")){

				$this->SetPropDefaultTop(array('tid'=>$this->tid,'serviceid'=>$serviceid));
		  }
		  

		  if($this->IsSQL('prop'," WHERE appid=64 AND status=0 AND sell=1 AND usergroup='$group[usergroup]' ")){

			    $this->HideDraft(array('tid'=>$this->tid,'serviceid'=>$serviceid));
		  }
		  
		  if($this->IsSQL('prop'," WHERE appid=53 AND status=0 AND sell=1 AND usergroup='$group[usergroup]' ")){

			    $this->HideTask(array('tid'=>$this->tid,'serviceid'=>$serviceid));
		  }
		  

		  if($this->IsSQL('prop'," WHERE appid=71 AND status=0 AND sell=1 AND usergroup='$group[usergroup]' ")){

			    $this->RealNameTask(array('tid'=>$this->tid,'serviceid'=>$serviceid));
		  }
		  

		  if($this->IsSQL('prop'," WHERE appid=72 AND status=0 AND sell=1 AND usergroup='$group[usergroup]' ")){

			    $this->SetMapLocation(array('tid'=>$this->tid,'serviceid'=>$serviceid));
		  }
		  
		  
		  if($this->IsSQL('prop'," WHERE appid=74 AND status=0 AND sell=1 AND usergroup='$group[usergroup]' ")){

			    $this->AllowTender(array('tid'=>$this->tid,'serviceid'=>$serviceid));
		  }
		  
		  //���õ��� end----------------------------------------------------

	}
	
	//��Ӹ��
	function AddDraft($did,$template='adddraft',$draft=array()){
		    
			$task=$this->GetMysqlOne('tid,appid,uid,subject,hidedraft,realnametask,price1,catid,money,url'," ".$this->GetTable('task')." WHERE tid='$this->tid'");
			
		    if($this->POST['Submit']){
                   
				   
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
						  
							$errors='<p>������Ͷ������!<p>';
							
							if($this->IsWap()){
								
								 $this->Refresh($errors,SURL.'/index.php?app='.$this->app.'&action=5&tid='.$this->tid);
							}else{
								 echo $errors;
								 echo $this->CloseNowWindows('#loading');
							}
							
							exit();
							
					  }elseif($strings->CheckLength(2)){  //����Ͷ��������С���� ��λ "λ"
					  
							$errors='<p>�Բ���,Ͷ�����ݲ�����2����!<p>';
							
							if($this->IsWap()){
								
								 $this->Refresh($errors,SURL.'/index.php?app='.$this->app.'&action=5&tid='.$this->tid);
							}else{
								
								 echo $errors;
								 echo $this->CloseNowWindows('#loading');
							}
							
							exit();
							
							
							
					  }
						  
						  
						  
				   
				   
				   //�б�
				   if($template=='addbid'){
					   
					    if($task['money']>0 && $this->POST['price']<$task['money']){
							  
							 echo '<p>�Բ��𱨼۲�������б궨��</p>';
						
				        	 echo $this->CloseNowWindows('#loading');	
							 
						     exit();
						}
						
						$content=$this->str($this->POST['content'],500,0,1,1,0,1);
					   
				   }else{
					    
						$content=$this->str($this->POST['content'],99999,0,1,0,0,1);
					   
				   }
				   
				   $props=$this->POST['props']=$this->ExplodeStrArr($this->POST['props']);

				   if($did>0){

						 $this->Update('task_draft',$this->POST,array('dateline'=>$this->NowTime(),'content'=>$content)," WHERE did='$did' AND uid='$this->uid'");
						
				   }else{
					   
						 $did=$this->Insert('task_draft',$this->POST,array('appid'=>$this->app,'uid'=>$this->uid,'tid'=>$this->tid,'dateline'=>$this->NowTime(),'content'=>$content,'buyer'=>$task['uid']));
				   
				   }
				   
				   
				   //�ϴ��ļ�
				   $files=$this->UploadFile();
				   													 
				   if($files){
						   foreach($files as $fid){
								$this->Insert('apps_file',array('appid'=>$this->app,'fid'=>$fid,'uid'=>$this->uid,'id'=>$did,'type'=>2),array());
						   }
						   
						   $this->ReplaceFileContent($files,'task_draft',$content," WHERE did='$did' ");
				   }
												   
				  
				   //����
				   if($props){
				   			
				  			 $servicelist=$this->GetMysqlArray('a.sid,a.subject,a.price,a.icon,b.amount,a.appid'," (SELECT sid,subject,price,icon,appid FROM ".$this->GetTable('prop')." WHERE sell='0' AND sid IN($props)  ORDER BY displayorder ASC ) AS a LEFT JOIN (SELECT sid,amount FROM ".$this->GetTable('prop_order')." WHERE uid='$this->uid' AND sid IN($props) ) AS b ON a.sid=b.sid");
							  
							  $totalservice=0;
							  $buyservice=array();
							  
							  if($servicelist){
									foreach($servicelist as $service){
										 
										   if(!$service['amount']){
												 $totalservice+=$service['price'];
												 $buyservice[]=$service['sid'];
										   }
									}
							  }
							  
							  if($totalservice){
								  
								 
									 //����û����ý��
							 		$user=$this->GetMysqlOne('*'," ".$this->GetTable('member_account')." WHERE uid='$this->uid'");
									
									if($user['money']>=($totalservice)){
										   
											$this->UseServiceProp($props,$task,$buyservice,$did);
		
									}else{
										   
										   echo include $this->LanguageArray('taskmode','Task_Props_Failed_purchase',1);

									}
									
									 
							  }else{
								    
									$this->UseServiceProp($props,$task,$buyservice,$did);
								  
							  }
							  
				   }
				   
				   
				   
				  //֪ͨ--------------------------------------------------------------

				   $send_subject=include $this->LanguageArray('taskmode','Task_Contributors_SMS_Subject',1);
				   $send_content=include $this->LanguageArray('taskmode','Task_Contributors_SMS_Content',1);

				  //�ӿ�
				  $this->Port(array(
									
						  //Login
						  'login_uid'=>$this->uid,
						
						  //Credit
						  'credit_uid'=>$this->uid,
						  
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
				  
				  //֪ͨ end--------------------------------------------------------------

 
				  $feedarray=array(

							//Feed
							'feed_uid'=>$this->uid,
							'feed_username'=>$this->username,
							'feed_app'=>$this->app,
							'feed_action'=>$this->ac,
							'feed_title_template'=>include $this->LanguageArray('taskmode','Task_Contributors_Feed',1),
							'feed_title_data'=>$task['subject'],
							'feed_content_template'=>'',
							'feed_content_data'=>$this->POST['content']														
																					
					);		
							
							
				   $this->AddTaskFeed($feedarray);
				
				   //ͳ��
				   $total=$this->IsSQL('task_draft',"WHERE tid='$this->tid'");
				   
				   $this->Update('task',array('draft_number'=>$total),array(),"WHERE tid='$this->tid'");
				     
					
				   if($template=='addbid'){
					   
					     echo '<p>Ͷ��ɹ���</p>';
				   }else{
						 echo '<p>Ͷ��ɹ���</p>';
				   }
				   
				   if($user['money']>=($totalservice)){
					    echo $this->CloseNowWindows('#loading');	
				   }
				 
												
			}else{
				  include $this->AppsView($template);
			}
				 
		 
		 
	}
	
	//��ӵ���
	function AddComment($uid,$allow){

																 
		if($allow=='ok'){

				$this->tid=$this->POST['tid'];
				
				$draftid=$this->ExplodeStrArr($this->POST['draftid']);
				
				$strings=new CharFilter($this->POST['content']);
				if(empty($this->POST['content'])){
					 echo '��������������!';
					 echo $this->CloseNowWindows('#loading');
				}elseif($strings->CheckLength(2)){ 
					 echo '�Բ���,�������ݲ�����2����!';
					 echo $this->CloseNowWindows('#loading');
				}else{
					
					 //����
					 $content=$this->str($this->POST['content'],200,0,1,1,0,1);
					 
					 if($draftid!=0){
						   
						   $idarray=explode(',',$draftid);
						   
						   $task=$this->GetMysqlOne('uid,appid,subject,url'," ".$this->GetTable('task')." WHERE tid='$this->tid'");
						   
						   foreach($idarray as $value){
							   
								$newid=$this->Insert('task_draft_comment',array('appid'=>$this->app,'uid'=>$uid,'did'=>$value,'tid'=>$this->tid,'content'=>$content,'dateline'=>$this->NowTime()),array());
								
		  
						
								   $draft=$this->GetMysqlOne('uid'," ".$this->GetTable('task_draft')." WHERE did='$value'");
							
								   if($draft['uid']!=$this->uid){
									   
										    //֪ͨ--------------------------------------------------------------
											 $send_subject=include $this->LanguageArray('taskmode','Task_Comment_SMS_Subject',1);
											 
											 $send_content=$content;
											 $send_content.=include $this->LanguageArray('taskmode','Task_Comment_SMS_Content',1);
											 	
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
														
																
											  ),16);
											  
											  //֪ͨ end--------------------------------------------------------------
								  
											  
								   }else{
									         //�ӿ�
											  $this->Port(array(
																
													  //Login
													  'login_uid'=>$this->uid,
													
													  //Credit
													  'credit_uid'=>$this->uid
													  
											  ),16);
									   
								   }
								
								
						   }
						   
						   if($newid){
								echo '�������۳ɹ�!<br />';
						   }else{
								echo '��������ʧ��!<br />';
						   }
						   
						   echo $this->CloseNowWindows('#loading');
						
					 }else{
						
						   echo '��ѡ�������в���!<br />';
						   echo $this->CloseNowWindows('#loading');
							
					 }
					

				}
				
		}else{
			
			 $this->ShowAllowError($allow,SURL.'/index.php?app='.$this->app.'&action=5&tid='.$this->tid);
		}
				

		
	}
	
	
	
	function  AddMessage($uid,$allow){
		
		  if($this->POST['Submit']){	
		 										 
			            if($allow=='ok'){

								$this->tid=$this->POST['tid'];
								
								$strings=new CharFilter($this->POST['content']);
								if(empty($this->POST['content'])){
									 echo '��������������!';
									 echo $this->CloseNowWindows('#loading');
								}elseif($strings->CheckLength(2)){ 
									 echo '�Բ���,�������Բ�����2����!';
									 echo $this->CloseNowWindows('#loading');
								}else{
									
									 //����
									 $content=$this->str($this->POST['content'],200,0,1,1,0,1);
									 
									 if($this->tid!=0){
										   
										 
										   $newid=$this->Insert('task_message',array('appid'=>$this->app,'uid'=>$uid,'tid'=>$this->tid,'content'=>$content,'dateline'=>$this->NowTime()),array());
										   
										   $task=$this->GetMysqlOne('uid,subject,url'," ".$this->GetTable('task')." WHERE tid='$this->tid'");
										   
	
										   if($task['uid']!=$this->uid){
											       
									                  $send_subject=include $this->LanguageArray('taskmode','Task_Message_SMS_Subject',1);
													  $send_content=include $this->LanguageArray('taskmode','Task_Message_SMS_Content',1);
													  
													  $this->Port(array(
																		
															   //Login
															  'login_uid'=>$this->uid,
															
															  //Credit
															  'credit_uid'=>$this->uid,
																
															  
															  'receive_uid'=>$task['uid'], //������
															  
															  //SMS
															  'sms_subject'=>$send_subject,
															  'sms_content'=>$send_content,
																			
															  //EMail
															  'email_title'=>$send_subject,
															  'email_content'=>$send_content,
									
															  //Mobile
															  'mobile_content'=>$send_subject
																
																		
													   ),8);
				
												   
										   }
										   
										   
										    $feedarray=array(

													'feed_uid'=>$this->uid,
													'feed_username'=>$this->username,
													'feed_app'=>$this->app,
													'feed_action'=>$this->ac,
													'feed_title_template'=>'�� <a href="'.SURL.$task['url'].'#DraftShow-2" target="_blank" title="'.$task['subject'].'">{title}</a> ��������',
													'feed_title_data'=>$task['subject'],
													'feed_content_template'=>'',
													'feed_content_data'=>$content								
																											
											);		
													
													
										   $this->AddTaskFeed($feedarray);
										  
										   
										   if($newid){
											   
											   
												//����ͳ��
												$total=$this->IsSQL('task_message',"WHERE tid='$this->tid'");
											   
												$this->Update('task',array('task_message'=>$total),array(),"WHERE tid='$this->tid'");
															
															
															
												echo '�������Գɹ�!<br />';
										   }else{
												echo '��������ʧ��!<br />';
										   }
										   
										   echo $this->CloseNowWindows('#loading');
										
									 }else{
										
										   echo '����ID����!<br />';
										   echo $this->CloseNowWindows('#loading');
											
									 }
									
				
								}
						}else{
							  $this->ShowAllowError($allow,SURL.'/index.php?app='.$this->app.'&action=5&tid='.$this->tid);
						}
						
	      }
				
		
		
	}
	
	function ShowCommentAction(){

		   include $this->AppsView('taskmode:comment');
		   
	}
	
	
	function ShowMessageAction(){
   
		   include $this->AppsView('taskmode:message');
		  
	}
   
    function UpdateTaskSkills($skills=''){
          
		  if($skills){
			    $skillsarr=$this->GetMysqlArray('*'," ".$this->GetTable('skills')."  WHERE sid IN($skills)");
				  
				foreach($skillsarr as $value){
					  $total=$value['total']+1;
					  $this->Update('skills',array('total'=>$total),array()," WHERE sid='$value[sid]' ");
				}
		  }
	
    }
	
	function BidMakeTaskOrder($task,$feetable,$draftid){
		
		 $draft=$this->GetMysqlOne('a.uid,a.tid,b.username,price,time'," ".$this->GetTable('task_draft')." AS a LEFT JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid  WHERE a.did='$draftid'");
										 
		 //�շ�
		 $fee=$this->GetTaskFeeValue($feetable,'taskfee',$draft['price'],0,$draft['uid']);
		 
		  //���ɶ���
		 $serial=$this->GetOrderNumber();
         
		 //$worktime=$this->NowTime()+($draft['time']*24*60*60);
		
		 //3���֧�����ɹر�ʱ��
		 include_once(Core.'/class/auto_class_phpapp.php');
		   
		 $auto=new AUTO();
		   
		 $autoday=3;  //3��ر�
		   
		 $runtime=$this->NowTime()+($autoday*24*60*60);
        
		 $order=$this->Insert('task_order',array('did'=>$draftid,'buyeruid'=>$task['uid'],'selleruid'=>$draft['uid'],'tid'=>$this->tid,'sum'=>$draft['price'],'money'=>$draft['price']-$fee,'workdate'=>$draft['time'],'dateline'=>$this->NowTime()),array());
				
		//Create Consume
		$cid=$this->SetConsume(array(
			   'subject'=>$task['subject'], 
			   'appid'=>49,
			   'serial'=>$serial,
			   'process'=>1,
			   'amount'=>$draft['price']-$fee,
			   'fee'=>$fee,
			   'oid'=>$order,
			   'paytype'=>1, //��������
			   'payout'=>0,   //֧����ID
			   'payin'=>$draft['uid']
		 ));
		

		
		 $runid=$auto->SetAutoRun(array(
				'app'=>49,
				'runtime'=>$runtime,
				'function'=>'CloseOrder',
				'oid'=>$order,
				'cid'=>$cid,
				'did'=>$draftid,
				'tid'=>$draft['tid']
		 ));
		
		 $this->Update('task_order',array('runid'=>$runid,'cid'=>$cid),array(),"WHERE oid='$order'");
		 
		 
		  //֪ͨ����֧��-------------------------------------------------------------------------------------
           require_once(APPS.'/apppay/class/process_class_phpapp.php');
		   $getprocess=new TaskProcess();
		   $send_op='<p>'.$getprocess->GetBuyerProcessMenu('task_order_credit',$cid).'</p>';

		   $send_subject=include $this->LanguageArray('taskmode','Task_NeedToPay_SMS_Subject',1);
		   
		   $send_content=include $this->LanguageArray('taskmode','Task_NeedToPay_SMS_Content',1);

		  //�ӿ�
		  $this->Port(array(
				  
				  'receive_uid'=>$task['uid'], //������
				  
				  //SMS
				  'sms_subject'=>$send_subject,
				  'sms_content'=>$send_content.$send_op,
				  'sms_cid'=>$cid,
								
				  //EMail
				  'email_title'=>$send_subject,
				  'email_content'=>$send_content,

				  //Mobile
				  'mobile_content'=>$send_subject,

							
		   ),3);
		 
		 
		 
		 
		 //�б�֪ͨ-------------------------------------------------------------------------------------
		   $value=$draftid;
		   
		   $send_op='';
		   
		   $send_subject=include $this->LanguageArray('taskmode','Draft_Successful_SMS_Subject',1);
		   
		   $send_content=include $this->LanguageArray('taskmode','Draft_Successful_SMS_Content',1);

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
								
				  //EMail
				  'email_title'=>$send_subject,
				  'email_content'=>$send_content,

				  //Mobile
				  'mobile_content'=>$send_subject,
							
		   ),3);
														  

		 $successnum=$this->IsSQL('task_draft',"WHERE process=1 AND uid='$draft[uid]'");
			
		 $this->UpdateTaskCount('successnum',$successnum,$draft['uid']);
		 
		 $successnum=$this->IsSQL('task_draft',"WHERE process=1 AND tid='$this->tid'");
		 
		 $this->Update('task',array('draft_success'=>$successnum),array(),"WHERE tid='$this->tid'");
		 
		 
	}
	
	
	
	function PayTaskOrder($oid){
		  
		  if($this->IsSQL('consume'," WHERE cid='$oid' AND process!=8 AND process>1  ")){
			  
				$consume=$this->GetMysqlOne('cid'," ".$this->GetTable('consume')." WHERE cid='$oid'");
				
				if($consume){
						
						//�������
						$taskorder=$this->GetMysqlOne('tid,money,did,oid'," ".$this->GetTable('task_order')." WHERE cid='$oid'");
						
						$tid=$taskorder['tid'];
						
						$task=$this->GetMysqlOne('uid,total,draft_success,url'," ".$this->GetTable('task')." WHERE tid='$tid'");
						
						if(($task['draft_success']) >= intval($task['total'])){
							  $this->Update('task',array('process'=>8,'endtime'=>$this->NowTime(),'topbid'=>0),array(),"WHERE tid='$tid'"); 
						}
												 
					
						include_once(APPS.'/apppay/class/consume_class_phpapp.php');
			  
						$pay=new UserConsume();
						
						$pay->SetSuccessConsume($consume['cid'],array('uid'=>$task['uid'],'tid'=>$tid,'url'=>$task['url'],'table'=>'task_count_usergroup'));
						
						
						$did=$taskorder['did'];
						
						$draft=$this->GetMysqlOne('uid,did'," ".$this->GetTable('task_draft')." WHERE did='$did'");
							
																
					   $send_op='';
														   
					   $send_subject=include $this->LanguageArray('order','Order_Pay_Subject',1);
					   
					   $send_content=include $this->LanguageArray('order','Order_Pay_Content',1);
					   
					   $getprocess=new TaskProcess();
					   $send_op=include $this->LanguageArray('order','Order_Pay_Operate',1);
					   
					   
	
					  //����
					  $this->Port(array(
										
							  //Login
							  'login_uid'=>$this->uid,
							
							  //Credit
							  'credit_uid'=>$this->uid,
							  
							  'receive_uid'=>$draft['uid'], //������
							  
							  //SMS
							  'sms_subject'=>$send_subject,
							  'sms_content'=>$send_content.$send_op,
											
							  //EMail
							  'email_title'=>$send_subject,
							  'email_content'=>$send_content,
	
							  //Mobile
							  'mobile_content'=>$send_subject
								
										
					   ),6);
					  
					  
					   $send_subject=include $this->LanguageArray('order','Order_Complete_Subject',1);
					   $send_content=include $this->LanguageArray('order','Order_Complete_Content',1);
					   $send_op=include $this->LanguageArray('order','Order_Complete_Operate',1);
					   //����
					   $this->Port(array(
										
							  
							  'receive_uid'=>$task['uid'], //������
							  
							  //SMS
							  'sms_subject'=>$send_subject,
							  'sms_content'=>$send_content.$send_op,
											
							  //EMail
							  'email_title'=>$send_subject,
							  'email_content'=>$send_content,
	
							  //Mobile
							  'mobile_content'=>$send_subject
								
										
					    ),6);

						
				}
		  }
	}
	
	
	function TaskExpired($tid=0){
	      
		   //�Ƿ����
		   if($this->IsSQL('task'," WHERE tid='$tid' AND UNIX_TIMESTAMP() > endtime AND process>1 AND process<7")){

		         //ѡ����ʽ
                 $task=$this->GetMysqlOne('uid,tid,credit,draft_success,total,url,money,process'," ".$this->GetTable('task')." WHERE tid='$tid'");  
				
				 if($task){
					 
					   if($this->IsSQL('task'," WHERE tid='$tid' AND process>1 AND process<6")){
					   
							  $send_subject=include $this->LanguageArray('taskmode','Task_Expired_SMS_Subject',1);
							   
							  $send_content=include $this->LanguageArray('taskmode','Task_Expired_SMS_Content',1);
	
							  //����
							  $this->Port(array(

									  'receive_uid'=>$task['uid'], //������
									  
									  //SMS
									  'sms_subject'=>$send_subject,
									  'sms_content'=>$send_content,
													
									  //EMail
									  'email_title'=>$send_subject,
									  'email_content'=>$send_content,
			
									  //Mobile
									  'mobile_content'=>$send_subject
										
												
							   ),22);
							  
					   }
					 
					   $this->UpdateTaskProcess(6,$tid);  
					   
					   @include_once(APPS.'/apppay/class/consume_class_phpapp.php');
					   $pay=new UserConsume();
					   
						//��֤ѡ�� 
					   if($task['credit']==1){
							  

							  $draftuser=$this->GetMysqlArray('did,uid'," ".$this->GetTable('task_draft')." WHERE process=0 AND tid='$tid' ");  
									         
							  $draftnum=count($draftuser);

							  if($draftnum>0){
								  
								     if(floatval($task['money'])<0.01){
										     $this->Update('task',array('process'=>9,'endtime'=>$this->NowTime()),array(),"WHERE tid='$task[tid]'");
									 }else{
												     
											 if($this->IsSQL('task'," WHERE serviceuid<1 AND tid='$tid'")){
														 
													 $serviceuser=$this->GetMysqlArray('*'," ".$this->GetTable('customer_service')." ORDER BY dateline ASC");    
													 
													 if($serviceuser){
														   //�󶨿ͷ�
														   $suid=$serviceuser[0]['uid'];
														   
														   if(!$suid){
																$suid=1;
														   }
														   
														   $this->Update('customer_service',array('dateline'=>$this->NowTime()),array(),"WHERE uid='$suid'");
														   
														   $this->Update('task',array('serviceuid'=>$suid),array(),"WHERE tid='$tid'");
														   
														   //֪ͨ�ͷ�
														   $send_subject=include $this->LanguageArray('taskmode','Task_Expired_Service_SMS_Subject',1);
														   $send_content=include $this->LanguageArray('taskmode','Task_Expired_Service_SMS_Content',1);
											
														   $this->Port(array(
																				
																	  
																	  'receive_uid'=>$suid, //������
																	  
																	  //SMS
																	  'sms_subject'=>$send_subject,
																	  'sms_content'=>$send_content.$send_op,
																					
																	  //EMail
																	  'email_title'=>$send_subject,
																	  'email_content'=>$send_content,
											
																	  //Mobile
																	  'mobile_content'=>$send_subject
																		
																				
															),22);
													 }
											 }
									 
									 }

							  }else{
											   
									 $this->TaskRefund($pay,$task);
												 
							  }
							  
						}else{
											   
							 $this->TaskRefund($pay,$task);
												 
					    }

				 }
		   
		  }else{
			  
			    $this->Update('task',array('process'=>9,'endtime'=>$this->NowTime()),array(),"WHERE tid='$task[tid]'");
		  }
	
    }
	
	function TaskRefund($pay,$task){
		   
		   if($this->IsSQL('task'," WHERE tid='$task[tid]' AND process>2 AND process<7 ")){
			   
			     //if(!$this->IsSQL('task_draft'," WHERE tid='$task[tid]' AND process=0 ")){
			   
						//������
						$this->Update('task',array('process'=>9,'endtime'=>$this->NowTime()),array(),"WHERE tid='$task[tid]'");
						
						//�ظ��
						$this->Update('task_draft',array('process'=>2),array(),"WHERE tid='$task[tid]' AND process=0 ");
						
						
						if($this->IsSQL('task'," WHERE tid='$task[tid]' AND appid=80 ")){
							
								$draftsuccess=$this->GetMysqlOne(' sum(money) AS moneys '," ".$this->GetTable('task_draft')." WHERE tid='$task[tid]' ");
								
								
								if(($task['total']-$task['draft_success'])>0){
									
				  
										$money=floatval($task['money']-$draftsuccess['moneys']);
										
										if($money>0){
										
												//�Ƹ�
												$member=$this->GetLoginInfo($task['uid']);
											   
												$this->Update('member_account',array('wealth'=>$member['wealth']-$money),array(),"WHERE uid='$task[uid]'");
												
						  
												$newcid=$pay->MakeConsume(array(
														 'subject'=>'<p>ϵͳ�˵�����</p>'.$task['tid'].'������', 
														 'appid'=>intval($this->app),
														 'process'=>1,
														 'amount'=>$money,
														 'paytype'=>1, 
														 'payout'=>0,   //֧����ID
														 'payin'=>$task['uid']
														 
												   ));
								  
												$pay->SetSuccessConsume($newcid);
												
												 $send_subject=include $this->LanguageArray('taskmode','Task_Expired_Task_SMS_Subject',1);
												 $send_content=include $this->LanguageArray('taskmode','Task_Expired_Task_SMS_Content',1);
									
												   $this->Port(array(
																		
															  
															  'receive_uid'=>$task['uid'], //������
															  
															  //SMS
															  'sms_subject'=>$send_subject,
															  'sms_content'=>$send_content,
																			
															  //EMail
															  'email_title'=>$send_subject,
															  'email_content'=>$send_content,
									
															  //Mobile
															  'mobile_content'=>$send_subject
																
																		
													),22);
										}
								
								}
						}else{
							   
							  $money=floatval($task['money']);
							  
							  $newcid=$pay->MakeConsume(array(
										 'subject'=>'ϵͳ��Ԥ����'.$task['tid'].'������', 
										 'appid'=>intval($this->app),
										 'process'=>1,
										 'amount'=>$money,
										 'paytype'=>1, 
										 'payout'=>0,   //֧����ID
										 'payin'=>$task['uid']
												 
							   ));
						  
							  $pay->SetSuccessConsume($newcid);
							  
							  $send_subject=include $this->LanguageArray('taskmode','Task_Expired_Task_SMS_Subject',1);
							  $send_content=include $this->LanguageArray('taskmode','Task_Expired_Task_SMS_Content',1);
				
							   $this->Port(array(
													
										  
										  'receive_uid'=>$task['uid'], //������
										  
										  //SMS
										  'sms_subject'=>$send_subject,
										  'sms_content'=>$send_content,
														
										  //EMail
										  'email_title'=>$send_subject,
										  'email_content'=>$send_content,
				
										  //Mobile
										  'mobile_content'=>$send_subject
											
													
								),22);
						}
				 //}else{
					 
					   //������
					  // $this->Update('task',array('process'=>9,'endtime'=>$this->NowTime()),array(),"WHERE tid='$task[tid]'");
				//}
				
		   }else{
					 
				 //������
				 $this->Update('task',array('process'=>9,'endtime'=>$this->NowTime()),array(),"WHERE tid='$task[tid]'");
		   }

	}
	
}




	
?>