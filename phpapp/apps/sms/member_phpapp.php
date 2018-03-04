<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class SMSMemberControls extends PHPAPP{
	
    private $POST,$GET;
	
	public  $page,$sid;
	
	public  $smslist=array();
	
	function __construct(){	 
	 
		 parent::__construct();
		 
		 $this->sid=empty($_GET['sid']) ? 0 : intval($_GET['sid']);
		 
		 $this->POST=$this->POSTArray();
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','sort','sid'));

		 
		 if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
		 
	}
	
	
	public function DefaultAction(){
		
		  return $this->GetmailboxAction();
		
	}
	
	
	public function GetMailboxAction($mailbox=1){
		
		
		  if($this->ac==2){
		
				$wheresql=" AND msgtoid='$this->uid' ";
			  
		  }else{
			    
				$wheresql=" AND msggoid='$this->uid' ";
			  
		  }
		  
		
		  if($this->GET['op']==3){
			  
			  if($this->POST['setnew']){
			         
					 $sidarr=$this->ExplodeStrArr($this->POST['sid']);
			
				   
					 $this->Update('member_sms',array('new'=>0),array()," WHERE sid IN($sidarr) $wheresql ");
					 
					 $msg='<p>设置成功!</p>';
					  
					 if($this->IsWap()){
						  
						   $this->Refresh($msg,SURL.'/member.php?app=7&action=1');
					 }else{
						  echo $msg;
					      echo $this->CloseNowWindows('#loading',1);
					 }
			   }
			  
		  
		  }elseif($this->GET['op']==2){
			    
			   if($this->POST['deleteall']){
			   
					 $this->Delete('member_sms'," WHERE mailbox>0 $wheresql ");
					 
					 $msg='<p>删除成功!</p>';
					  
					 if($this->IsWap()){
						  
						   $this->Refresh($msg,SURL.'/member.php?app=7&action=1');
					 }else{
						  echo $msg;
					      echo $this->CloseNowWindows('#loading',1);
					 }
			   }
			   
		
		  }elseif($this->GET['op']==1){
			        
				   $oderid=$this->ExplodeStrArr($this->POST['sid']);

				   $this->Delete('member_sms'," WHERE sid IN($oderid) $wheresql ");
				   
				   $msg='<p>删除成功!</p>';
				   
				   if($this->IsWap()){
					    $this->Refresh($msg,SURL.'/member.php?app=7&action=1');
				   }else{
					     echo $msg;
				         echo $this->CloseNowWindows('#loading',1);
				   }
			  
		  }else{
			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		         
				 if($mailbox==1){
					  $msggoid="msggoid='$this->uid'";
				 }else{
					  $msggoid="msgtoid='$this->uid'";
				 }

				 $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action='.$mailbox,"SELECT * FROM ".$this->GetTable('member_sms')."  WHERE ".$msggoid." AND mailbox='$mailbox' ORDER BY dateline DESC");
				   
				   
				 $list=$page->ShowResult();
	  
	  
				 include $this->AppsView('getmailbox_member');
		  }
		   
	}
	
	
	public function ShowSmsAction(){
		  
		  

		  $this->sid=empty($this->POST['sid']) ? $this->sid : intval($this->POST['sid']);
			  
		  $smsarr=$this->GetMysqlOne('*'," ".$this->GetTable('member_sms')." WHERE sid='$this->sid'");
		  
		  if($smsarr){
			  
			    if(!empty($this->POST['Submit'])){
					  
					  include_once(Core.'/class/filter_class_phpapp.php');
					  
					  $content=$this->str($this->POST['content'],300,1,0,1,0,1);
					  $strings=new CharFilter($content);
					  if(empty($content)){
						   echo $this->Refresh('请输入内容!<br />',$this->MakeGetParameterURL());
					  }elseif($strings->CheckLength(3)){  
						   echo $this->Refresh('对不起！内容不能少3个字!<br />',$this->MakeGetParameterURL());
					  }else{
						   
						   $this->SiteSmsPort(array(
										 
									 //Login
									'login_uid'=>$this->uid,
									
									//Credit
									'credit_uid'=>$this->uid,
									
									 //SMS
									'sms_msggoid'=>$smsarr['msgtoid'], //收件人
									'sms_msgtoid'=>$smsarr['msggoid'],
									'sms_mailbox'=>'1',
									'sms_subject'=>$smsarr['subject'],
									'sms_content'=>$content,
									'sms_upid'=>!empty($smsarr['upid']) ? $smsarr['upid'] : $this->sid
									
									));
					   
							$this->Refresh('发送成功!<br />',$this->MakeGetParameterURL());
						   
					  }
					  
					
				}else{
				
					  $this->Update('member_sms',array('new'=>0),array()," WHERE sid='$this->sid'");
					  
					  include_once(Core.'/class/pages_class_phpapp.php');
					  
					  if($smsarr['upid']>0){
					       $page=new Pages(10,$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.username,b.uid FROM ".$this->GetTable('member_sms')." AS a JOIN ".$this->GetTable('member')." AS b ON a.msgtoid=b.uid WHERE a.upid='$smsarr[upid]' AND a.sid!='$this->sid' OR a.sid='$smsarr[upid]' ORDER BY a.dateline DESC ");
					 
			                $smsarrlist=$page->ShowResult();
					  
					  }

					  					
					  include $this->AppsView('showsms_member');
				}
		  }else{
			  
				return $this->GetmailboxAction();
			  
		  }
		

		  
	}
	
	
	public function WriteSmsAction(){
		
		   if($this->GET['op']==1){
			
			       include_once(Core.'/class/filter_class_phpapp.php');

			       $subject=$this->str($this->POST['subject'],30,1,0,1,0,1);
			       $content=$this->str($this->POST['content'],300,1,0,1,0,1);
			       
				   $checknum=$uid=0;
				   
				   foreach($this->POST as $key=>$value){
					   
					   switch($key){
					          case 'subject':
							  
							       $strings=new CharFilter($subject);
								   
								   if(empty($subject)){
							             echo '请输入标题!<br />';
								   }elseif($strings->CheckSpace()){
							             echo '对不起！标题含有非法代码!<br />';	 
								   }elseif($strings->CheckLength(3)){  
										 echo '对不起！标题不能少3个字!<br />';
								   }elseif($strings->CheckShort(30)){ 
										 echo '对不起！标题太长了!<br />';
								   }else{
									     $checknum+=1;
								   }
		
					          break;
							  case 'content':
									$strings=new CharFilter($content);
									if(empty($content)){
										 echo '请输入内容!<br />';
									}elseif($strings->CheckLength(3)){  
										 echo '对不起！内容不能少3个字!<br />';
									}else{
									     $checknum+=1;
								    }
							  break;
							  
							  case 'SecCode':
						            
									if(PHPAPP::$config['smsscode']==1){
										  $checknum+=1;
									}else{
										  include_once(APPS.'/member/main_phpapp.php');
										  
										  $reg=new MemberMainControls();
							  
										  if($reg->SecCode($this->POST['SecCode'])){
											   $checknum+=1;
										  }else{
											   echo '对不起！验证码有误!<br />';
										  } 
									}
							  
							  break;
							  case 'username':
							        $username=$this->str($this->POST['username'],30,1,0,1,0,1);
							        $userarr=$this->GetMysqlOne('uid'," ".$this->GetTable('member')." WHERE username='$username'");
								    
									if($userarr['uid']==$this->uid){
										 echo '对不起！不能发送给自己!<br />';
									}elseif($userarr['uid']>0 && $userarr['uid']!=$this->uid){
										 $uid=$userarr['uid'];
										 $checknum+=1;
								    }else{
										 echo '对不起！用户不存在!<br />';
									}
							  break;
							  
					   }
					   
					   
			   
				   }
				   
				  if(PHPAPP::$config['smsscode']==1){
					    $checkvlaue=4;
				  }else{
					    $checkvlaue=3;
				  }
				   
			   
			      if($checknum==$checkvlaue){
                       
			
					   $mailbox=empty($this->POST['mailbox']) ? 1 : intval($this->POST['mailbox']);
			
					   if($mailbox>1){
						   
						   
					               $this->SiteSmsPort(array(
										 
										          //Login
												  'login_uid'=>$this->uid,
												  //Credit
												  'credit_uid'=>$this->uid,
												  
												  //SMS
												  'sms_msggoid'=>$uid, //收件人
												  'sms_msgtoid'=>$this->uid,
												  'sms_mailbox'=>'2',
												  'sms_subject'=>$subject,
												  'sms_content'=>$content
												  
									 ));
						   
					   }
					   
					   $this->SiteSmsPort(array(
										 
										           //Login
												  'login_uid'=>$this->uid,
												  
												  //Credit
												  'credit_uid'=>$this->uid,
												  
												   //SMS
												  'sms_msggoid'=>$uid, //收件人
												  'sms_msgtoid'=>$this->uid,
												  'sms_mailbox'=>'1',
												  'sms_subject'=>$subject,
												  'sms_content'=>$content
												  
												  ));
					   
					    echo '发送成功!<br />';
		 
                        echo $this->CloseNowWindows('#loading');
					  
				  }else{
					    echo '发送失败!<br />';
					    echo $this->CloseNowWindows('#loading');
				  }
			   
		   }else{
			   
			   
			    $smsarr=$this->GetMysqlOne('*'," ".$this->GetTable('member_sms')." WHERE sid='$this->sid'");
			   
			    include $this->AppsView('writesms_member');
			   
		   }

		  
	}
	
	
	public function SendmailboxAction(){
		
		
		  return $this->GetmailboxAction(2);
		
		
	}

}

?>