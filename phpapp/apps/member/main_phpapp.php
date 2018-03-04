<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(Core.'/class/filter_class_phpapp.php');


class MemberMainControls extends PHPAPP{
	
	public $POST;
	
	public $UserClient;

	
	function __construct(){	
	     
		 parent::__construct();
         
		 $postkey=array('EMail'=>'','UserName'=>'','Password'=>'','Agreement'=>'','SecCode'=>'','SubmitRegister'=>'','SubmitLoginNow'=>'','Mobile'=>'','SubmitWapLogin'=>'','SecurityForm'=>'');

		 
		 $this->POST=$this->POSTArray();
		 
		 if(!$this->POST){
			    //Register;
		        $this->POST=$this->errors=$this->values=$postkey;
	
		 }
		 
		 foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				    $this->POST[$key]='';
			   }
		 }

		 if(!empty($_GET['checktype'])){

                 $register = new SubmitRegister($this->POST);
				 //check
				 $register->CheckRegister();
				 
				 $checkresult=$register->GetCheckResult();
				 
		 		 switch (intval($_GET['checktype'])) {
		     		  case '1':
		          		   echo $checkresult['UserName'];
				  		   exit();
	          		  break;
			  		  case '2':
			     		   echo $checkresult['EMail'];
				  		   exit();
	         		  break;
					  case '3':
			     		   echo $checkresult['Password'];
				  		   exit();
	         		  break;
					  case '4':
			     		   echo $checkresult['SecCode'];
				  		   exit();
	         		  break;
				  }
		 
		 }

		 
	
	}
	

	function DefaultAction(){

              $this->LoginAction();
		 
	}
		
	
	//登录------------------------------------------------------------------------------------------------

	function LoginAction(){
		
		
		if(!empty($_SESSION['USER_USERID'])){
			
			   header('Location:'.SURL);
		}
		
		if($this->POST['SubmitWapLogin']){
			
				if($this->CheckSecurityForm($this->POST['SecurityForm'])){
	                    
						$this->LoginError(1);
						
						$filter=new CharFilter();
						
						$oknum=0;
						$msg='';
						
						$strlen=iconv_strlen($this->POST['UserName'],S_CHARSET);
						
						if($strlen<1){
							$msg.='<p>请输入用户名!</p>';
						}else{
							 if($strlen<3){
								 
								  $msg.='<p>用户名太短了!</p>';
								 
							 }else{
								  $oknum+=1;
							 }
							
						}
						
						$strlen=iconv_strlen($this->POST['Password'],S_CHARSET);
						
						if($strlen<1){
							 $msg.='<p>请输入密码!</p>';
						}else{
				
							 $oknum+=1;
							
						}
						
						if($oknum){
						
							  if($filter->CheckString($this->POST['UserName'],1)){
									
									$msg=$this->UserLogin(0,1);
		
									if($msg=='ok'){
										
										   $this->Refresh('<p>登录成功!</p>',SURL);
										   exit();
									}
		
									
							  }else{
									$msg.='<p>对不起!用户名不能含有特殊字符!</p>';
											
							  }
						
						
						}
					  
					   
						$this->Refresh($msg,SURL.'/index.php?app=2&action=1');
				}else{

					    $this->Refresh('提交表单已过期!',SURL.'/index.php?app=2&action=1');
				}
				

		}elseif($this->POST['SubmitRegister']) {
			
			  if($this->CheckSecurityForm($this->POST['SecurityForm'])){
                   
				   $this->LoginError(0,1);
				   
				   $islogin=$this->UserLogin();

				   if($islogin=='ok'){
					   
						  echo '登录成功!';
		   
						  echo $this->AjaxRefresh($this->ReturnURL(),1);

				   }else{
				  
						  echo $this->CloseNowWindows('#loading');
				   }
				   
			  }else{
		 
					$this->Refresh('提交表单已过期!',SURL.'/index.php?app=2&action=1');
			  }
			
		 }else{
			 
				//sns
				$snsarray=$this->GetMysqlArray('*'," ".$this->GetTable('sns')."  WHERE status_phpapp=0 ");
				
				$_SESSION['RedirectURL']=$_SESSION['ReturnURL'];
			    unset($_SESSION['ReturnURL']);
				
				include $this->AppsView('login');
		 }

	
	}
	
	//out login
	
	function OutLoginAction(){
		
		 setcookie(session_name(),session_id(),-86400 * 365,PHPAPP::$config['cookie_path'],PHPAPP::$config['cookie_domain']);
		
         //同步退出
	     if($uclient=$this->GetClient($this->POST['UserName'],$this->POST['Password'],$this->POST['EMail'])){
		       $logout=$uclient->logout();	
		 }else{
			   $logout='';
		 }
          
		 unset($_SESSION['USER_USERID']); 
		 unset($_SESSION['USER_USERNAME']);  
		 unset($_SESSION['WeiBoID']); 
		 
		 $_SESSION = array(); 
		 session_destroy();
		 
		 $this->Refresh('退出登录成功!'.$logout,$this->ReturnURL());
		
	}
	
	
	
	//注册
	public function RegisterAction(){
 
		   //关闭注册
		   if(PHPAPP::$config['sitecloseregister']){
			     $this->Refresh('网站已关闭了注册!',SURL);
		   }
		   
		   
		   if(!empty($_SESSION['USER_USERID'])){

			     $this->Refresh('您已经是会员了!',SURL);
			
		   }

		   
		   if($this->POST['SubmitWapLogin']){
			   
			     
				 if($this->CheckSecurityForm($this->POST['SecurityForm'])){
					 
					             $register = new SubmitRegister($this->POST);
								 
								 //注册
								 $success='';
								
								 if($register->CheckRegister(1)==3){
									
									  $success=$register->InsertRegister(1);
									 
								 }else{
								
									  $errors=$register->GetCheckErrors(1);
								 }
								 
								 if($success){	
								      
									  $msg=$this->Port(array(
								 
													  //Credit
													 'credit_uid'=>$success
													 
													 ));
									  
									  $this->Refresh($msg.'恭喜你!注册成功啦!',SURL);
									 
								 }else{
								 
									  $this->Refresh($errors,SURL.'/index.php?app=2&action=2');
								 }
								 exit();
					 
				 }else{
					  
					   $this->Refresh('提交表单已过期!',SURL.'/index.php?app=2&action=2');
				 }
					 

		   }elseif($this->POST['SubmitRegister']){
			    
				  if($this->CheckSecurityForm($this->POST['SecurityForm'])){
				  
						  $agreement=empty($this->POST['Agreement']) ? 0 : 1;
						  
						  if(1==$agreement){   
						  
								 $register = new SubmitRegister($this->POST);
								 //注册
								 $success='';
								 
								 if(PHPAPP::$config['registeriscode']){
									   if($register->CheckRegister()==4){
											$success=$register->InsertRegister();
									   }else{
											$register->GetCheckErrors();
									   }
								 
								 }else{
									   if($register->CheckRegister(1)==3){
											$success=$register->InsertRegister();
									   }else{
											$register->GetCheckErrors();
									   }
									 
								 }
								 
								 
								 if($success){	
								 
									 echo '恭喜你!注册成功啦!';
					   
									 echo $this->AjaxRefresh($this->ReturnURL(),1);
									 
								 }else{
								 
									 echo $this->CloseNowWindows('#loading');
								 }
								 exit();
								 
						  }else{
								echo '对不起!您未接受使用协议不能注册!';
						  }
				  }else{
					  
					   $this->Refresh('提交表单已过期!',SURL.'/index.php');
				  }
				  
		   }else{
			 
			     //user type
				 $membertypearr=$this->GetMysqlArray('*'," ".$this->GetTable('member_type')." WHERE status_phpapp=0");
				 
				 //sns
				 $snsarray=$this->GetMysqlArray('*'," ".$this->GetTable('sns')."  WHERE status_phpapp=0 ");
				 
				 $_SESSION['RedirectURL']=$_SESSION['ReturnURL'];
			     unset($_SESSION['ReturnURL']);

				 include $this->AppsView('register');
		         
		   }

		   
	}
	
	
	
	
	//UserLoginStatus
	
	public function LoginStatusAction(){
		  
	      if($this->uid>0){
			  
				$WeiBoID=empty($_SESSION['WeiBoID']) ? 0 : intval($_SESSION['WeiBoID']);
				
				if($WeiBoID>0){
					  $weibologin=$this->GetMysqlOne('name_phpapp,icon_small_phpapp'," ".$this->GetTable('sns')." WHERE app_phpapp='$WeiBoID' AND  status_phpapp=0 ");
				}
				
		  }
		  
		  
		  include $this->Template('status');
	}
	
	
	
	
	//验证码
	function GetSecCodeAction(){
		 
           $this->MakeSecCode();

	}
	
	
	//WeiBo
	function LoginWeiBo($userinfo=array(),$apiname='',$followers=0){
		

		   if($userinfo){
				 
				 //是否绑定
				 $username=$this->str($userinfo['UserName'],36,1,0,1,0,1);
				 $apiname=$this->str($apiname,36,1,0,1,0,1);
				 $apikey=substr(md5($username),0,6);
				 
				 if($this->uid>0){
				 	  $SNS=$this->GetMysqlOne('*'," ".$this->GetTable('sns_api')." WHERE appid='$this->app' AND uid='$this->uid'");
				 }
				 
				 if(empty($SNS['uid'])){
						$SNS=$this->GetMysqlOne('*'," ".$this->GetTable('sns_api')." WHERE appid='$this->app' AND apikey='$apikey'");
				 }
				 
				 if(!empty($SNS['uid'])){
					   
					   $uid=$SNS['uid'];
					   //登录
					   $member=$this->GetMysqlOne('username,safeemail'," ".$this->GetTable('member')." WHERE uid='$uid'");
                       
					   $this->POST=array('UserName'=>$member['username'],'EMail'=>$member['safeemail'],'Password'=>'');
					   
					   if($uclient=$this->GetClient($this->POST['UserName'],$this->POST['Password'],$this->POST['EMail'])){
					          $uclogin=$uclient->login($uid); 
					   }
					   
					   $this->SetCookies($uid);
					   
					   $_SESSION['WeiBoID']=$this->app;
					   
					   if($this->IsSQL('sns_api',"  WHERE appid='$this->app' AND uid='$uid' ")){
									    
							 $this->Update('sns_api',array('followers'=>$followers),array()," WHERE appid='$this->app' AND uid='$uid'");
									   
					   }
							 
					   $this->Refresh('登录成功!'.$uclogin,SURL);
					   
				 }else{
					 
					   if($this->uid>0){
					         
							  //绑定
							  $this->Insert('sns_api',array('appid'=>$this->app,'uid'=>$this->uid,'apiname'=>$apiname,'apikey'=>$apikey,'followers'=>$followers),array());
							  
							  $this->Refresh('绑定成功!',SURL.'/member.php?app=19');
					 
					   }else{
						   
							 $this->POST=$userinfo;
						     $this->POST['Password']=$this->RandomText(6,1);
							 $this->POST['UserType']=1;
						     
							 //注册
							 $register = new SubmitRegister($this->POST);
							  

							 $regnum=0;
							 
							 $strlen=iconv_strlen($this->POST['UserName'],S_CHARSET);
							 
							 if($register->CheckUserName($strlen,$this->POST['UserName'])=='yes'){
								   $regnum+=1;
							 }else{
								 
								   $this->Refresh('<strong>尊敬的用户!</strong><p>您的用户名已被暂用!</p><p>如已注册过，请用原来账号在本站登录后再绑定即可。</p>',SURL.'/index.php?app=2&action=1');
								   exit();
								  //$this->POST['UserName']=$this->POST['UserName'].$this->RandomText(3,1);
							 }
							
							 
							 $strlen=iconv_strlen($this->POST['EMail'],S_CHARSET);
							 if($register->CheckEMail($strlen,$this->POST['EMail'])=='yes'){
								   $regnum+=1;
							 }else{
								
								  if($strlen>0){
								         $this->POST['EMail']=$this->RandomText(3,1).$this->POST['EMail'];
								  }else{
									     $this->POST['EMail']=$this->RandomText(6,1).'@'.$this->RandomText(3,1).'.com';
								  }
							 }
                        
							 if($regnum!=2){
								   
	                                $register = new SubmitRegister($this->POST);
								 
							 }
								 
								  
							 $uid=$register->InsertRegister(1);
							 
							  //绑定
							 $this->Insert('sns_api',array('appid'=>$this->app,'uid'=>$uid,'apiname'=>$apiname,'apikey'=>$apikey,'followers'=>$followers),array());

					   
							 @require_once(APPS.'/sms/class/port_class_phpapp.php');
							 
							 //SMS
							 $sms=new SMSPort();
						   
							 $sms->SendSMS(array('sms_msggoid'=>$uid,'sms_msgtoid'=>0,'sms_mailbox'=>'1','sms_subject'=>'恭喜您注册成功,点击查看登录密码!','sms_content'=>'您的登录密码为：'.$this->POST['Password'].' <br />请保管好您的密码!'));
							 
							 $_SESSION['WeiBoID']=$this->app;
							 
							 $this->Refresh('登录成功!',SURL);
		
					   }
					 
				 }
				 
				  
		   }
	}
	
		
	//login
	function UserLogin($opensecode=0,$refresh=0,$ucrul=0,$cookietime=0){
	
		    $loginok=0;
		    $msg='';
		
		    $filter=new CharFilter();
			
			if($filter->CheckStringEmail($this->POST['UserName'])){
				
				  $loginok+=1;
				  
				  $email=$this->str($this->POST['UserName'],99,1,0,1);
				  
				  if($this->IsSQL('member_mail_certificate'," AS a LEFT JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid WHERE b.safeemail='$email' AND a.status='5' ")){
					    				  
						$member=$this->GetMysqlOne('username'," ".$this->GetTable('member')." WHERE safeemail='$email'");
						
						$this->POST['UserName']=$member['username'];
					  
				  }else{ 
				  
						 if(!$refresh){
							  echo '<p>对不起!该邮箱不存在或未认证!</p>';
						      echo $this->CloseNowWindows('#loading');
						 }else{
							 
							  return '<p>对不起!该邮箱不存在或未认证!</p>';
						 }
						 
					     exit();
				  }

				  
			}else{
                  
				  
			      if(is_numeric($this->POST['UserName'])){
				        
						$mobile=$this->str($this->POST['UserName'],30,1,0,1);
						 //mobile
						if($this->IsSQL('member_mobile_certificate'," AS a LEFT JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid WHERE a.mobile='$mobile' AND a.status='5' ")){
							
							  $loginok+=1;
							  
							  $member=$this->GetMysqlOne('b.username'," ".$this->GetTable('member_mobile_certificate')." AS a JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid WHERE a.mobile='$mobile' AND a.status='5'");
						
							  $this->POST['UserName']=$member['username'];
							
						}else{
							
							 if($filter->CheckString($this->POST['UserName'],1)){
								  $loginok+=1;
							 }else{
								 
								  if(!$refresh){
								       echo '<p>对不起!昵称不能含有特殊字符!</p>';
								  }else{
									  
									   return '<p>对不起!昵称不能含有特殊字符!</p>';
								  }
								  
								 
							 }
							
							
						}
						 
						 
				   
				  }else{
				 
						if($filter->CheckString($this->POST['UserName'],1)){
							  $loginok+=1;
						}else{
							  if(!$refresh){
							       echo '<p>对不起!用户名不能含有特殊字符!</p>';
							  }else{
								   return '<p>对不起!用户名不能含有特殊字符!</p>';
							  }
	  
						}
				  }
			
			}
			
		 
		    if(!$opensecode){
				 
				 $checknum=2;
				 
				 if(PHPAPP::$config['loginiscode']){
						 if($this->SecCode($this->POST['SecCode'])){
							   $loginok+=1;
						 }else{
							   echo '对不起!验证码不正确,请重新输入!';
							   
						 }

				 }else{
					  
					   $loginok+=1;
					 
				 }
				 
			}else{
				 $checknum=1;
			}

			if($loginok==$checknum){
				
				   //setcookie(session_name(),session_id(),-86400 * 365,PHPAPP::$config['cookie_path'],PHPAPP::$config['cookie_domain']);

				   $username=$this->str($this->POST['UserName'],99,1,0,1);
				   $password=$this->str($this->POST['Password'],99,1,0,1);
				   
				   if($uclient=$this->GetClient($this->POST['UserName'],$this->POST['Password'],$this->POST['EMail'])){
					   
					     $APIuser=$uclient->user_login();
						
						 if(intval($APIuser['uid'])>0){
							 
							    $uid=$APIuser['uid'];
								
								//禁止
								$userarr=$this->GetMysqlOne('uid,usergroup'," ".$this->GetTable('member')." WHERE uid='$uid'");
								
								if($userarr){
									  $usergroup=$userarr['usergroup'];
									  if($this->IsSQL('usergroup'," WHERE gid='$usergroup' AND allowlogin=1 ")){
										    echo '<p>对不起！您的帐号已禁止登录！</p><p>如非恶意的帐号可以联系客服解禁！</p>';
											exit();
									  }
								}
								
						
							    //本站
						        if(!$this->IsSQL('member'," WHERE uid='$uid' ")){
									   $this->POST['EMail']=$APIuser['email'];
									   $this->POST['UserType']=1;
									   $register = new SubmitRegister($this->POST);
									   $register->RegisterMember($uid);
								}
					
			                    $uclogin=$uclient->login($uid); 
		
								$this->SetCookies($uid,'',$cookietime);
								/*
								//Port
								$this->Port(array(
												  //Credit
												  'credit_uid'=>$uid
												  
												  ));
								*/
								
								if(!$opensecode){
									  echo $uclogin;
									 
		                        	  return 'ok';
								}else{
									  
									  if(!$ucrul){
										  
											echo $uclogin;
										  
											return 'ok';  
									  
									  }else{

										    //return array('ok',$uclogin);  
											$this->Refresh('登录成功!'.$uclogin,$ucrul);
			
									  }
								}

							 
						 }else{
							 
							  return $this->LoginError($refresh);
						      /*
					          switch ($APIuser['uid']) {
		     		  		  	    case '-1':
		          		    			   $msg.= '<p>用户不存在,或者被删除</p>';
										   
	          		  		 	    break;
			  		  		  	    case '-2':
			     		   		 	       $msg.=  '<p>用户不存在或密码错误!</p>';
	         		  			    break;
					   		 	    case '-3':
                                           $msg.=  '<p>安全提问错误!</p>';
	         		   		 	    break;
				  		      }
							 
							  
							  if(!$refresh){
								    echo $msg;
							  }else{
								    return $msg;
							  }
							   */
							  //echo $this->CloseNowWindows('#loading');
						 }
					   
				   }else{
					    //本站
						if($this->IsSQL('member'," WHERE username='$username' ")){
							   
							   
							   $userarr=$this->GetMysqlOne('uid,powercode,usergroup'," ".$this->GetTable('member')." WHERE username='$username'");

							   $userkey=$this->PasswordKey($username,$password,$userarr['powercode']);
		
							   if($this->IsSQL('member'," WHERE username='$username' AND password='$userkey' ")){
								      
								
									  $usergroup=$userarr['usergroup'];
									  if($this->IsSQL('usergroup'," WHERE gid='$usergroup' AND allowlogin=1 ")){
											echo '<p>对不起！您的帐号已禁止登录！</p><p>如非恶意的帐号可以联系客服解禁！</p>';
											exit();
									  }
									
								
								      $this->SetCookies($userarr['uid']);
									
									  if(!$opensecode){
							
									       //Port
										    $this->Port(array(
													  //Credit
													  'credit_uid'=>$userarr['uid']
													  
											 ));
									
		                                    echo '登录成功!';
		 
                                            echo $this->AjaxRefresh(SURL,1);
											
											exit();
									  }else{
									        return 'ok';
								      }
								   
								   
							   }else{
								    
									return $this->LoginError($refresh);
									/*
								    if(!$refresh){
								         echo '<p>用户不存在或密码错误!</p>';
									}else{
										 return '<p>用户不存在或密码错误!</p>';
									}
									*/
									
							   }
							   
							
						}else{
							
							 return $this->LoginError($refresh);
							  /*
							  if(!$refresh){
							       echo '<p>用户不存在,或者被删除</p>';
							  }else{
								   return '<p>用户不存在,或者被删除</p>';
							  }
							  */
						}
	
						
				   }
				
			}else{
					   
				  $this->LoginError($refresh);
					   
			}
		 
		
	}
	
	
	function LoginError($refresh='',$isnum=0){
		   
		   $error='';
		   
		   if(PHPAPP::$config['allowloginip']){
			     $loginkey=md5($this->GetClientIp());
		   }else{
			     $loginkey=md5($this->POST['UserName'].$this->GetClientIp());
		   }
		   
		   $membererrorarr=$this->GetMysqlOne('dateline'," ".$this->GetTable('member_error')." WHERE loginkey='$loginkey' ORDER BY id DESC LIMIT 0,1");
		   
		   if(!empty($membererrorarr['dateline'])){
		         $loginerrortime=$membererrorarr['dateline']+60*intval(PHPAPP::$config['memberloginerrortime']);
		   }else{
			     $loginerrortime=0;
		   }
		   
		   $newtime=time() - 60*intval(PHPAPP::$config['memberloginerrortime']);
			
		   if($this->IsSQL('member_error'," WHERE loginkey='$loginkey' AND dateline>'$newtime' ORDER BY id DESC")>=intval(PHPAPP::$config['memberloginerrornum'])  && $loginerrortime > time() ){
				 $logintime=intval(($loginerrortime-time())/60)+1;
				 $error='<p>对不起！您输入的错误太多！</p><p>请 <strong>'.$logintime.'</strong> 分钟后再登录！</p>';
				 
				 if(!$refresh){
					  echo $error;
					  echo $this->CloseNowWindows('#loading');
					  exit();
				 }else{
					  return $error;
				 }
				 

		   }else{
			
			    if(!$isnum){
					   $this->Insert('member_error',array('username'=>$this->POST['UserName'],'loginip'=>$this->GetClientIp(),'loginkey'=>$loginkey,'dateline'=>$this->NowTime()));
					   
					   if((intval(PHPAPP::$config['memberloginerrornum'])-$this->IsSQL('member_error'," WHERE loginkey='$loginkey' AND dateline>'$newtime' ORDER BY id DESC")) ==0){

							  $error='<p>对不起！您输入的错误太多！</p><p>请 <strong>'.intval(PHPAPP::$config['memberloginerrortime']).'</strong> 分钟后再登录！</p>';
					   }else{
							  $error='<p>用户或密码有误！您还有 <strong>'.(intval(PHPAPP::$config['memberloginerrornum'])-$this->IsSQL('member_error'," WHERE loginkey='$loginkey' AND dateline>'$newtime' ORDER BY id DESC")).'</strong> 机会输入！</p>';
					   }
					  
						  
					   if(!$refresh){
							 echo $error;
							 echo $this->CloseNowWindows('#loading');
							 exit();
					   }else{
							 return $error;
					   }
			    }

		   }
		   
	}
	
	//验证码认证
	function SecCode($seccode=0){
		
		$SESSIONSeccode=empty($_SESSION['seccode'])? '' :$_SESSION['seccode'];
		
	    if(md5(strtoupper($seccode))==$SESSIONSeccode){
			 return true;
		}else{
			 return false;
		}
	}
	
	function SetCookies($uid=0,$username='',$cookie_time=''){
		  
		  if(!$this->uid){
			  
				  $this->POST['UserName']=empty($username) ?  $this->POST['UserName']  : $username;
				
				  unset($_SESSION['USER_USERID']);
				  unset($_SESSION['USER_USERNAME']); 
				  unset($_SESSION['USER_COOKIECODE']);
		
				  $_SESSION['USER_USERID']=$uid; 
				  $_SESSION['USER_USERNAME']=$this->POST['UserName']; 
				  $_SESSION['USER_COOKIECODE']=$cookiecode=$this->RandomText(16,1);
		
				  $this->Insert('login_safe',array('username'=>$this->POST['UserName'],'loginip'=>$this->GetClientIp(),'dateline'=>$this->NowTime()));
			
				  $this->Update('member',array('cookiecode'=>$this->SetCookieCode($uid,$cookiecode,$uid),'logintime'=>$this->NowTime(),'loginip'=>$this->GetClientIp()),array()," WHERE uid='$uid'");
				  
				  if(empty(PHPAPP::$config['cookie_domain'])){
					   $cookie_domain=false;
				  }else{
					   $cookie_domain=PHPAPP::$config['cookie_domain'];
				  }
				  
				  if(empty(PHPAPP::$config['cookie_path'])){
					   $cookie_path=false;
				  }else{
					   $cookie_path=PHPAPP::$config['cookie_path'];
				  }
		
				  if(!$cookie_time){
					  
						if(empty(PHPAPP::$config['cookie_time'])){
							 $cookie_time=86400;
						}else{
							
							 $cookie_time=PHPAPP::$config['cookie_time'];
							
						}
						
				  }
				
				  setcookie(session_name(),session_id(),time() + $cookie_time,$cookie_path,$cookie_domain);
		  }
	}
	
	
	function GetMessageAction(){
		 

		  if($this->uid){
			    
				$this->sid=empty($_GET['sid']) ? 0 : intval($_GET['sid']);
				
		        if($this->POST['Submit']){
                  
					   if($this->sid){
							$this->Delete('member_sms'," WHERE sid='$this->sid' AND msggoid='$this->uid' ");
					   }else{
							$this->Delete('member_sms'," WHERE msggoid='$this->uid' ");
					   }
				   
				}else{
				 	   include $this->Template('getsms');
				}
							   
		  }


	}
	
	
	function LoginNowAction(){
	
		if(!empty($_SESSION['USER_USERID'])){
			   echo '您已经登录过了!';
		}
		

		if($this->POST['SubmitLoginNow']) {
			
			   if($this->CheckSecurityForm($this->POST['SecurityForm'])){
				     $this->LoginError(1,1);
		
				     echo $this->UserLogin(1,1);
			   }else{
				   
				     echo '对不起！表单已过期,请重新操作！';
			   }

		 }else{
				
				$this->Refresh('您访问的页面不存在!',SURL);
		 }
		 
	}
	
	
	
	function RetrievePasswordAction(){
		
		
		 if($this->POST['Mobile'] || $this->POST['EMail']) {
			 
	             $username=$this->str($this->POST['UserName'],60,1,0,1,0,1);
				 $email=$this->str($this->POST['EMail'],80,1,0,1,0,1);
				 $mobile=$this->str($this->POST['Mobile'],30,1,0,1,0,1); 
				 
				 if($this->SecCode($this->POST['SecCode'])){
					 
					    if(!$username){
						      echo '请输入用户名!<br />';
				              echo $this->CloseNowWindows('#loading');
							  exit();
					    }
						
						$sqlusername=sprintf(" WHERE username='%s' ",$username);
						
						$userinfo=$this->GetMysqlOne('uid'," ".$this->GetTable('member')." $sqlusername ");
						
						if(intval($userinfo['uid'])>0){
							   
							  $uid=intval($userinfo['uid']);
							
						}else{
							
							  echo '用户名不存在或已删除!<br />';
				              echo $this->CloseNowWindows('#loading');
							  exit();

						}
						
					 
					 
					    $filter=new CharFilter();
						
						//NewPassword
				        $NewPassword=$this->RandomText(6,1);
				 
				        $Content='您在'.PHPAPP::$config['sitename'].'的登录新密码为：'.$NewPassword;
				 
						
					    if($this->POST['type']==0){
					            //email
	
							   if($filter->CheckStringEmail($email)){
									 
									 //认证
									 if($this->IsSQL('member_mail_certificate',"WHERE status='5' AND email='$email'")){
										     
											 $certificate=$this->GetMysqlOne('uid'," ".$this->GetTable('member_mail_certificate')."  WHERE uid='$uid' AND status='5' AND email='$email' ");
											 
											 $password=new SubmitRegister();
										   
											 $password->SetNewPassword($certificate['uid'],$NewPassword);
										
											 $this->SendMail($email,PHPAPP::$config['sitename'].'找回密码!',$Content);
											 
											 echo '发送成功!请注意查收邮件!<br />';
											 echo $this->CloseNowWindows('#loading');
									 }else{
										 
										    echo '邮箱未认证,无法使用该功能!<br />';
									        echo $this->CloseNowWindows('#loading');
								   
									 }
										
							   }else{
								   
									 echo '邮箱格式有误!<br />';
									 echo $this->CloseNowWindows('#loading');
								   
							   }
							   
							   
							 
							 
						 }else{
							   
												 
							  if(is_numeric($mobile)){
									 
									 //认证
									 if($this->IsSQL('member_mobile_certificate',"WHERE status='5' AND mobile='$mobile'")){
										     
											 include(Core.'/class/sms_class_phpapp.php');
						  
								             $mobilesms=new MobileSMS();
											 
											 $certificate=$this->GetMysqlOne('uid'," ".$this->GetTable('member_mobile_certificate')."  WHERE uid='$uid' AND status='5' AND mobile='$mobile' ");
											 
											 $password=new SubmitRegister();
										   
											 $password->SetNewPassword($certificate['uid'],$NewPassword);
										

											  $result=$mobilesms->SendSMS($mobile,$Content);
									
											  if($result=='ok'){
														  
													echo '发送成功!请注意查收手机!<br />';
													
											        echo $this->CloseNowWindows('#loading');
													
											  }else{
												  
													echo $result.'<br />';
													
													echo $this->CloseNowWindows('#loading');
											  }
											 
											 
									 }else{
										 
										    echo '手机未认证,无法使用该功能!<br />';
									        echo $this->CloseNowWindows('#loading');
								   
									 }
										
							   }else{
								   
									 echo '手机号码格式有误!<br />';
									 echo $this->CloseNowWindows('#loading');
								   
							   }
							 
							 
						 }
					 
				 }else{
					   //验证码
					   echo '验证码有误!<br />';
					   echo $this->CloseNowWindows('#loading');
				 }
				 
				 
			
		 }else{
			 
			   //sns
			   $snsarray=$this->GetMysqlArray('*'," ".$this->GetTable('sns')."  WHERE status_phpapp=0 ");
			  
			   
			   include $this->Template('getpassword');
		 }
	}
	
	function ReturnURL(){
		
		 if(!empty($_SESSION['RedirectURL'])){
			  return urldecode($this->str($_SESSION['RedirectURL'],200,1,0,1,0,1));
		 }else{
			  return SURL;
		 }
	}
	
	
	
	function AJAXAction(){
		  
		  if($this->uid>0){
			  
			     $datajson='{';
				 $LoginMemberArray=$this->GetLoginInfo(0,1); 

				 if($LoginMemberArray['userpost']==1){  //雇主
				 
				 	  $UsedID=$this->ExplodeStrArr($_GET['liveids']);
					  if($UsedID){
							$idarr=explode(',',$UsedID);
							$wheresql=' AND a.did NOT IN('.$UsedID.') AND a.did>'.$idarr[0].' ';
					  }else{
							$wheresql='';
					  }
					  
				       //稿件
					  $draftarr=$this->GetMysqlOne('a.*,b.username'," ".$this->GetTable('task_draft')." AS a LEFT JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid WHERE a.dateline>=(UNIX_TIMESTAMP()-10) AND a.buyer='$this->uid' $wheresql ORDER BY a.dateline DESC LIMIT 0,1");
					  
					  if(!empty($draftarr['uid']) && $this->uid>0){
						    $subject='查看'.$draftarr['did'].'号投稿';
						    $description=$draftarr['username'].' 在您的'.$draftarr['tid'].'号任务上投稿啦！';
							
							 include_once(Core.'/class/makeurl_class_phpapp.php');
		  
		 					 $makeurl=new MakeTaskAddressUrl();

						    $datajson.='"TaskID":"'.$draftarr['did'].'","TaskUid":'.$draftarr['uid'].',"TaskAvatar":"'.$this->GetUserAvatar($draftarr['uid'],1,1).'","TaskSubject":"'.$subject.'","TaskDescription":"'.$description.'","TaskUrl":"'.SURL.$makeurl->GetTaskAddress($draftarr['tid'],$draftarr['did'],$draftarr['appid']).'"';
						  
					  }else{
						  
				      		$datajson.='"TaskID":"","TaskUid":"","TaskAvatar":"","TaskSubject":"","TaskDescription":"","TaskUrl":""';
					  }
		         }else{
					 
					  $UsedID=$this->ExplodeStrArr($_GET['liveids']);
					  if($UsedID){
							$idarr=explode(',',$UsedID);
							$wheresql=' AND tid NOT IN('.$UsedID.') AND tid>'.$idarr[0].' ';
					  }else{
							$wheresql='';
					  }
					  //任务 时间小于1 分钟 
					  $taskarr=$this->GetMysqlOne('tid,uid,subject,description,url,skills'," ".$this->GetTable('task')." WHERE lang='$this->lang' AND dateline>=(UNIX_TIMESTAMP()-15) AND process>2 $wheresql ORDER BY dateline DESC LIMIT 0,1");  
					  
					  $taskskillsarr=explode(',',$taskarr['skills']);
					  $userskillsarr=explode(',',$LoginMemberArray['skills']);
					  
					  $isskill=0;
					  if($taskskillsarr && $userskillsarr){
						    foreach($taskskillsarr as $tskill){
									foreach($userskillsarr as $uskill){
										  if($uskill==$tskill){
											   $isskill=1;
										  }
									}
						    }
					  }
					  
					  
					  if(!empty($taskarr['tid']) && $isskill>0){
					   
		                   $datajson.='"TaskID":"'.$taskarr['tid'].'","TaskUid":'.$taskarr['uid'].',"TaskAvatar":"'.$this->GetUserAvatar($taskarr['uid'],1,1).'","TaskSubject":"'.$taskarr['subject'].'","TaskDescription":"'.$taskarr['description'].'","TaskUrl":"'.SURL.$taskarr['url'].'"';
					  
					  }else{
						   
						    $datajson.='"TaskID":"","TaskUid":"","TaskAvatar":"","TaskSubject":"","TaskDescription":"","TaskUrl":""';
						  
					  }
				 }
				 
				 //通知
				 $noticenum=$this->IsSQL('member_notice'," WHERE uid='$this->uid' AND new=1");
				 if($noticenum>0){
					    $datajson.=',"MemberNotice":"'.$noticenum.'"';
				 }else{
					    $datajson.=',"MemberNotice":""';
				 }
				 
				 //短信
				 
				 $smsnum=$this->IsSQL('member_sms'," WHERE msggoid='$this->uid' AND mailbox=1 AND new=1");
				 if($smsnum>0){
					    $datajson.=',"MemberSMS":"'.$smsnum.'"';
				 }else{
					    $datajson.=',"MemberSMS":""';
				 }
				 
				 
				 echo $datajson.'}';

		  }
	

		  //Auto
		  
		  if($this->IsSQL('autorun'," WHERE  ".$this->NowTime()." > runtime ")){

				include(Core.'/class/auto_class_phpapp.php');
						
				$auto=new AUTO();
				
				$auto->Run();
				
		  }


	}
	
	function FastGuideAction(){
		
		  if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		  }
		  
		  $member=$this->GetMysqlOne('*',"".$this->GetTable('member')." WHERE  uid='$this->uid'");	  

		  include $this->Template('fastguide');
	}
	
	function JsonUserInfoAction(){
		   	 	
		  $datajson='{"ULink":"","Uid":"","UserAvatar":"","TaskNum":"","DraftNum":"","SuccessNum":"","Credit":"","UserName":"","DateLine":""}';

		  $uid=intval($_GET['uid']);
		  $usertype=intval($_GET['userpost']);
		  
		  if($uid>0){
			    $member=$this->GetMysqlOne('a.uid,a.username,a.dateline,a.skills,a.userpost,b.tasknum,b.draftnum,b.successnum,b.servicenum,c.certificate'," (".$this->GetTable('member')." AS a LEFT JOIN ".$this->GetTable('task_total')." AS b ON a.uid=b.uid) LEFT JOIN ".$this->GetTable('member_info')." AS c ON a.uid=c.uid  WHERE a.uid='$uid' ");	  

				$credit=$this->GetMysqlOne('*',"".$this->GetTable('credit')." WHERE uid='$uid' AND type='$usertype' ");
				
				if($this->GetCertificateIcon($member['certificate'])){
					
					 $mycertificate=$this->GetCertificateIcon($member['certificate']);
					
				}else{
					 $mycertificate='无任何认证';
				}
				
				if($credit['credit']){
					
					 if($usertype==1){
						  $usertypename='卖家';
					 }else{
						  $usertypename='买家';
					 }
					 
				     $mycredit ="<span class='jsonuser_level_rate'>好评率 ".$this->LevelRate($credit['hao'],$credit['zhong'],$credit['cha'])."%</span> <span class='".$this->GetCreditLevel($credit['credit'],1)."' title='".$usertypename."信用积分 ".$credit['credit']."'></span>";
				
				}else{
					 $mycredit ='暂无信用值';
				}
				
				$datajson='{"ULink":"'.SURL.'/space.php?app=8&uid='.$member['uid'].'","Uid":"'.$member['uid'].'","UserAvatar":"'.$this->GetUserAvatar($member['uid'],1,1).'","TaskNum":"'.intval($member['tasknum']).'","DraftNum":"'.intval($member['draftnum']).'","SuccessNum":"'.intval($member['successnum']).'","ServiceNum":"'.intval($member['servicenum']).'","Credit":"'.$mycredit.'","UserName":"'.$member['username'].'","DateLine":"'.$this->Date('Y-m-d',$member['dateline']).'","UserCertificate":"'.$mycertificate.'"}';
		
		  }
		  
		  echo $datajson;
	}
	
}

include_once(APPS.'/member/class/register_class_phpapps.php');


?>