<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class FriendMainControls extends PHPAPP{
	
    private $POST,$GET,$errors;
	
	public $fuid;
	
	function __construct(){	
	
	       
		   parent::__construct();
		   
		   
		   $this->fuid=empty($_GET['fuid']) ? 0 : intval($_GET['fuid']);


		   $postkey=array('Submit'=>'');
			
			
		   $this->POST=$this->POSTArray();
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op'));
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
			  
		   }

		   if($this->uid<1){
				    echo '请登录后操作!<br />';
					echo $this->CloseNowWindows('#loading');
					exit();
		   }
		         
	}
	
	
	function DefaultAction(){
		  $this->AddFriendAction();
	}
	
	
	function AddFriendAction(){
		
		  if($this->uid!=$this->fuid){
			  
				   if($this->GET['op']==1){
					   
						  if(!$this->IsSQL('member_friend',"WHERE uid='$this->uid' AND status=0")){
							
								 if($this->IsSQL('member',"WHERE uid='$this->fuid'")){
									   
									   if(!$this->IsSQL('member_myfriend',"WHERE uid='$this->uid' AND fuid='$this->fuid'")){
									   
											 $message=$this->str($this->POST['message'],50,1,0,1);
													
											 $this->Insert('member_friend',array('uid'=>$this->uid,'fuid'=>$this->fuid,'message'=>$message,'dateline'=>$this->NowTime()),array());
											 
											 
											 $this->Port(array(
													
													//Login
													'login_uid'=>$this->uid,
													
													//Credit
													'credit_uid'=>$this->uid,
													
													 //SMS
													'sms_msggoid'=>$this->fuid, 
													'sms_msgtoid'=>0,
													'sms_mailbox'=>'1',
													'sms_subject'=>$this->username.'把您加为好友了!',
													'sms_content'=>$this->username.'申请加您为好友等待您的批准!,<a href="member.php?app=17&action=3" target="_blank">查看详细</a>'
																  
																  
								            ));	
											 
											 
											 echo '发送请求成功，等待对方验证中!<br />';
											 echo $this->CloseNowWindows('#loading');
									   
									   }else{
										    
										     echo '您们已经是好友了!<br />';
									         echo $this->CloseNowWindows('#loading');
									   }
									   

								 }else{
									   echo '用户不存在!<br />';
									   echo $this->CloseNowWindows('#loading');
								 } 
											  
						  }else{
							  
								echo '您已经申请过了,等待对方验证中!<br />';
								echo $this->CloseNowWindows('#loading');
							  
						  }
					   
					   
				   }else{
						   $user=$this->GetMysqlOne('username'," ".$this->GetTable('member')." WHERE uid='$this->fuid'");
						
						   if($user){
						  
								 include $this->Template('addfriend');
								 
						   }else{
							   
								echo '用户不存在!<br />';
								echo $this->CloseNowWindows('#loading');
							   
						   }
				   }
		  }else{
			    echo '对不起,不能加自己为好友!<br />';
				echo $this->CloseNowWindows('#loading');
		  }
	}
	
}




?>