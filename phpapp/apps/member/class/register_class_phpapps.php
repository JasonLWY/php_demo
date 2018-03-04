<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class SubmitRegister extends MemberMainControls{
	
	public $POST,$errors,$values;
	
	function __construct($POST=array()){	
		   
		$postkey=array('EMail'=>'','UserName'=>'','Password'=>'','UserGroupID'=>'');
		
		$this->POST=$POST;
		
		foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
			  
		 }
	     
	}
	
	
	//检查函数------------------------------------------------------------------------------------------------
	//检查EMail
	function CheckEMail($strlen='',$value='',$check=0){
		 		 
		 $filter=new CharFilter();
		 
	                        if($strlen<=5){
								 $regname='对不起!电子邮箱不能小于<strong>5</strong>位数!';
							}elseif($strlen>=32){
								 $regname='对不起!电子邮箱不能大于<strong>32</strong>位数!';
							}else{
								 if($filter->CheckStringEmail($value)){
									   
									   $email=$this->str($value,80,0,0,1);
									   
									   if(!$check){
										    
										  
										   if($uclient=$this->GetClient($this->POST['UserName'],$this->POST['Password'],$email)){
											   
									
											    $ucreturn = $uclient->checkemail();
												
											    if($ucreturn>0) {
									 	  	 	  	     $regname='yes';
                               	     	 		    }elseif($ucreturn==-4) {
	                                  	 		 	     $regname='对不起!您输入的电子邮箱格式有误!';
                                 	 	 		    }elseif($ucreturn == -5) {
                                     	 	  	  	     $regname='对不起!您输入的电子邮箱系统不允许注册!';
                                 	 	 		    }elseif($ucreturn == -6) {
									 	  			     $regname='对不起!您输入的电子邮箱已经被注册!';
                                 	 			 }
											     
											   
										   }else{
											   
											     if(!$this->IsSQL('member'," WHERE safeemail='$email'")){
													  $regname='yes';
												 }else{
													  $regname='对不起!您输入的电子邮箱已经被注册!';
												 }
										   }
											
									
											
									   }else{
										      if(!$this->IsSQL('member'," WHERE  email='$email'")){
													  $regname='yes';
											  }else{
													  $regname='对不起!您输入的电子邮箱已经被注册!';
											  }
									   }

						  	 	 }else{
							   	        $regname='对不起!您输入的邮箱格式有误!';
						 	     }
							}
			return $regname;				
	}
	
	
	function CheckUserName($strlen='',$value=''){

		 $filter=new CharFilter();
		 
		                    if($strlen<=2){
								 $regname='对不起!昵称不能小于<strong>2</strong>位数!';
							}elseif($strlen>=15){
								 $regname='对不起!昵称不能大于<strong>15</strong>位数!';
							}else{
											
	                             
								   if($this->AllowRegisterUserName()){
								   
								   
										   if($filter->CheckString($value,1)){
		  
											   if($uclient=$this->GetClient($value,$this->POST['Password'],$this->POST['EMail'])){
														 
													   $ucreturn = $uclient->checkename();
													   if($ucreturn>0) {
															  $regname='yes';
													   }elseif($ucreturn == -1) {
															   $regname='对不起!昵称不合法';
													   }elseif($ucreturn == -2) {
															   $regname='对不起!昵称包含要允许注册的词语';
													   }elseif($ucreturn == -3) {
															   $regname='对不起!用户名已经存在!';
													   }
													  
											   }else{
													  
												   
													   if(!$this->IsSQL('member'," WHERE username='$value'")){
																$regname='yes';
													   }else{
																$regname='对不起!用户名已经存在!';
													   }
												   
											   }
						  
				   
										  }else{
		  
											   $regname='对不起!昵称不能含有特殊字符!';
										  }
								   }else{
										  $regname='对不起!用户名已注册!';
								   }
						    }
		  return $regname;					
	}
	
	function CheckPassword($strlen='',$password=''){
 
		    $filter=new CharFilter();
		 
			if($strlen<6){
				 $regname='对不起!密码不能小于<strong>6</strong>位数!';
			}elseif($strlen>=32){
				 $regname='对不起!密码不能大于<strong>32</strong>位数!';
			}else{
				
				 if($filter->CheckSpecialString($password)){
					  $regname='yes';
				 }else{
					  $regname='对不起!密码格式有误,请输入数字字母组合!';
				 }
				 
			}	
			
		    return $regname;				
	}

	//检查函数结束------------------------------------------------------------------------------------------------

	
	
	//check
	function CheckRegister($isseccode=0){
		
		 $checkdata=0;
		 
		 $password='';
		 
		 foreach($this->POST as $key=>$value){
			 
			  if(!$value){
				   if($key=='EMail'){
					   $this->errors[$key]='对不起!电子邮箱不能为空!';
				   }elseif($key=='UserName'){
					   $this->errors[$key]='对不起!昵称不能为空!'; 
				   }elseif($key=='Password'){
					   $this->errors[$key]='对不起!密码不能为空!';
				   }elseif($key=='SecCode'){
					   if(PHPAPP::$config['registeriscode']){
							 if(!$isseccode){
								  $this->errors[$key]='对不起!验证码不能为空!';
							 }
					   }
				   }  
				   
				   
			  }else{
	
                     $strlen=@iconv_strlen($value,S_CHARSET);
				   	  if($key=='EMail'){
						 
						   if(($this->errors[$key]=$this->CheckEMail($strlen,$value))=='yes'){
							   $checkdata+=1;
						   }
					  	    
				   	  }elseif($key=='UserName'){
					       if(($this->errors[$key]=$this->CheckUserName($strlen,$value))=='yes'){
							      $checkdata+=1;
						    }	  	
					  
				   	  }elseif($key=='Password'){
						  
						   if(($this->errors[$key]=$this->CheckPassword($strlen,$value))=='yes'){
							      $checkdata+=1;
						   }		   	
							
				   	  }elseif($key=='Agreement'){
					        $this->errors[$key]='';
				      }elseif($key=='SecCode'){
						   
						    if(!$isseccode){
							
								  if($this->SecCode($value)){
									   $checkdata+=1;
									   $this->errors[$key]='yes';
								  }else{
									   $this->errors[$key]='对不起!验证码不正确,请重新输入!';
								  }
								
							}else{
								 $checkdata+=1;
								 $this->errors[$key]='yes';
							}
					        
				      }
 
				  
			  }
		 }
		 
		 return  $checkdata;
 
	}
	
	function InsertRegister($isopen=0,$islogin=0){
		
		 
		 //入库 and UC
		
		 if($uclient=$this->GetClient($this->POST['UserName'],$this->POST['Password'],$this->POST['EMail'])){
			  
			  $APIuid = $uclient->register();
			  
			  if($APIuid>0){

					    $APIuid =$this->RegisterMember($APIuid);
				 
				  
			  }else{
			         switch($APIuid){
					          case -1:				  
						      echo '用户名不合法';
					          break;
							  case -2:
							  echo '包含要允许注册的词语';				  
							  break;
							  case -3:
							  echo '用户名已经存在';
							  break;
							  case -4:
							  echo 'Email 格式有误';
							  break;
							  case -5:
							  echo 'Email 不允许注册';
							  break;
							  case -6:
							  echo '该 Email 已经被注册';
							  break;
							 
					 }
					 exit();
			  }
			  
			  
		
		 }else{
			 $APIuid =$this->RegisterMember();
		 }
		 
		
		 
		 if($islogin){
			 
			   return $APIuid;
			 
		 }else{
			 
			   //登录
			   if($uclient=$this->GetClient($this->POST['UserName'],$this->POST['Password'],$this->POST['EMail'])){
					 $uclogin=$uclient->login($APIuid); 
			   }
			   
			   $this->SetCookies($APIuid);
				   
			   if(!empty($uclogin)){
					 echo $uclogin;
			   }
			   
			   if(!$isopen){   
					 $this->Port(array(
									   
										//Credit
									   'credit_uid'=>$APIuid
									   
									   ));
					  
					 
					 return $APIuid;
					 
			   }else{
				   
					 return $APIuid;
			   }
 
		 }
		 
	}
	
	function RegisterMember($ucuid=0){
		
	     $powercode=$this->RandomText(16,1);
		 
		 $this->POST['Password']=$this->PasswordKey($this->POST['UserName'],$this->POST['Password'],$powercode);
		 
			 
		 //会员类型
		 $usertype=intval($this->POST['UserType']);
	
		 $nowtype=$this->GetMysqlOne('*'," ".$this->GetTable('member_type')." WHERE id_phpapp='$usertype'");
		 
		 if($this->POST['UserGroupID']>0){
			 
			   
			   $usergroup=$this->POST['UserGroupID'];
			   
			 
		 }else{
		 
			   
			   if($nowtype['table_phpapp']=='member_personal'){
					$usergroup=3;
			   }elseif($nowtype['table_phpapp']=='member_company'){
					$usergroup=5;
			   }
		 
		 }
		 
		 $unionid=empty($_SESSION['UNION']) ? '0' :  intval($_SESSION['UNION']);
		 
		 if($unionid){
		       $addpost=array('dateline'=>$this->NowTime(),'powercode'=>$powercode,'regip'=>$this->GetClientIp(),'safeemail'=>$this->POST['EMail'],'usergroup'=>$usergroup,'unionid'=>$unionid,'uniontime'=>time()+(24*60*60*intval(PHPAPP::$config['uniontime'])));
		 }else{
			   $addpost=array('dateline'=>$this->NowTime(),'powercode'=>$powercode,'regip'=>$this->GetClientIp(),'safeemail'=>$this->POST['EMail'],'usergroup'=>$usergroup);
		 }
		 
		 if($ucuid){
			  $addpost['uid']=$ucuid;
		 }
		 
		 $newuid=$this->Insert('member',$this->POST,$addpost);
	     
		 $this->Insert('member_info',array('uid'=>$newuid));
		 
		 $this->Insert($nowtype['table_phpapp'],array('uid'=>$newuid));
		 
		 $this->Insert('member_account',array('uid'=>$newuid));
		 
		 $this->Insert('member_message_set',array('uid'=>$newuid,'setkey'=>'a:2:{s:5:"email";a:21:{i:1;s:1:"1";i:2;s:1:"1";i:3;s:1:"1";i:4;s:1:"1";i:5;s:1:"1";i:6;s:1:"1";i:7;s:1:"1";i:8;s:1:"1";i:9;s:1:"1";i:10;s:1:"1";i:11;s:1:"1";i:12;s:1:"1";i:13;s:1:"1";i:14;s:1:"1";i:15;s:1:"1";i:16;s:1:"1";i:17;s:1:"1";i:18;s:1:"1";i:19;s:1:"1";i:20;s:1:"1";i:22;s:1:"1";}s:6:"notice";a:18:{i:2;s:1:"1";i:3;s:1:"1";i:4;s:1:"1";i:5;s:1:"1";i:6;s:1:"1";i:7;s:1:"1";i:8;s:1:"1";i:9;s:1:"1";i:10;s:1:"1";i:12;s:1:"1";i:13;s:1:"1";i:14;s:1:"1";i:15;s:1:"1";i:17;s:1:"1";i:18;s:1:"1";i:19;s:1:"1";i:20;s:1:"1";i:22;s:1:"1";}}'));
		 
		 
		  if(PHPAPP::$config['registerednotice']==1){
   
				  $postsms=array(
					  'sms_msggoid'=>$newuid, //收件人
					  'sms_msgtoid'=>0,
					  'sms_mailbox'=>'1',
					  'sms_subject'=>str_replace('{username}',$this->POST['UserName'],PHPAPP::$config['registerednoticesubject']),
					  'sms_content'=>str_replace('{username}',$this->POST['UserName'],PHPAPP::$config['registerednoticecontent'])
				  );
				  
				  
				  include_once(APPS.'/sms/class/port_class_phpapp.php');
				  
				  $sms=new SMSPort();
				  
				  $sms->SendSMS($postsms); //发送
   
		  }

		 //推广
		 if($unionid>0){
		       
			   
			   $unionmember=$this->GetMysqlOne('username'," ".$this->GetTable('member')." WHERE uid='$unionid'");
			   
		 	   $feedarray=array(

							//Feed
							
							'feed_uid'=>$unionid,
							'feed_username'=>$unionmember['username'],
							'feed_app'=>20,
							'feed_action'=>1,
							'feed_title_template'=>'{title}',
							'feed_title_data'=>'邀请 '.$this->POST['UserName'].' 注册会员成功!',
							'feed_content_template'=>'',
							'feed_content_data'=>''

				);	
			   

				include_once(APPS.'/feed/class/port_class_phpapp.php');
				new FeedPort($feedarray);			
	
		 }
		 
		 return $newuid;
		 	
	}
	
	
	function GetCheckResult(){
		return $this->errors;
	}
	
	function GetCheckErrors($return=0){
		 
		 $msg='';
		 
		 foreach($this->errors as $key=>$value){
			   if($value!='yes'){
				    if(!$return){
					     echo '<p>'.$value.'</p>';
					}else{
						 $msg.= '<p>'.$value.'</p>';
					}
			   }
		 }
		 
		 if($return){
			  return $msg;
		 }
		 
		
	}
	
	
	
	//修改密码

	function EditPassword($uid,$post,$isok=0){
		
		            $result='';
					
                    $userarr=$this->GetMysqlOne('uid,powercode,username'," ".$this->GetTable('member')." WHERE uid='$uid'");

					$userkey=$this->PasswordKey($userarr['username'],$post['PasswordOld'],$userarr['powercode']);
							   
					if($this->IsSQL('member'," WHERE uid='$uid' AND password='$userkey' ")){
						  
						    include_once(Core.'/class/filter_class_phpapp.php');
							
							$setpassword=$this->CheckPassword(iconv_strlen($post['Password'],S_CHARSET),$post['Password']);
							
							if($setpassword=='yes'){
								
								    if($post['Password']==$post['PasswordNew']){
										   
										   $newkey=$this->PasswordKey($userarr['username'],$post['Password'],$userarr['powercode']);
										   
										   //本站
										   $this->Update('member',array('password'=>$newkey),array()," WHERE uid='$uid'");
										   
										   //UC
										   if($uclient=$this->GetClient($userarr['username'],$post['PasswordOld'])){
											    
												 $uclient->user_edit($post['Password']);
											   
										   }
										   
										   if($isok){
											     $result='ok';
										   }else{
										         $result='设置成功!<br />';
										   }
									}else{
										 
										  $result='确认密码不一样!<br />';
									}

								   
								
						    }else{
								  $result=$setpassword.'<br />';
							}
							
						   
						
					}else{
						
						 $result='旧密码有误!<br />';
						
				    }		
					
					
				   return $result;
		
		
	}
	
	
	function SetNewPassword($uid=0,$newpassword=''){
		             
					 $userarr=$this->GetMysqlOne('uid,powercode,username'," ".$this->GetTable('member')." WHERE uid='$uid'");
		 
		             $newkey=$this->PasswordKey($userarr['username'],$newpassword,$userarr['powercode']);
										   
					 //本站
					 $this->Update('member',array('password'=>$newkey),array()," WHERE uid='$uid'");
					 
					 //UC
					 if($uclient=$this->GetClient($userarr['username'],$newpassword)){
						  
						   $uclient->user_edit($newpassword,1);
						 
					 }
		
		
	}

	function AllowRegisterUserName(){
		
		  $allowregisterusername=PHPAPP::$config['allowregisterusername'];
		
          if($allowregisterusername){
			  
			    $allowregisterusername=str_replace('*','(.*)',$allowregisterusername);
			    $allowarr=explode(',',$allowregisterusername);
			 
			    foreach($allowarr as $value){
					
					  $mun=@preg_match_all("/$value/i",$this->POST['UserName'],$username);

					  if($mun>0){
						   return false;
					  }
				}
			  
			    return true;
			    
		  }else{
			  
				return true;	 
		  }
	}
	
}

?>