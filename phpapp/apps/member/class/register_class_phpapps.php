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
	
	
	//��麯��------------------------------------------------------------------------------------------------
	//���EMail
	function CheckEMail($strlen='',$value='',$check=0){
		 		 
		 $filter=new CharFilter();
		 
	                        if($strlen<=5){
								 $regname='�Բ���!�������䲻��С��<strong>5</strong>λ��!';
							}elseif($strlen>=32){
								 $regname='�Բ���!�������䲻�ܴ���<strong>32</strong>λ��!';
							}else{
								 if($filter->CheckStringEmail($value)){
									   
									   $email=$this->str($value,80,0,0,1);
									   
									   if(!$check){
										    
										  
										   if($uclient=$this->GetClient($this->POST['UserName'],$this->POST['Password'],$email)){
											   
									
											    $ucreturn = $uclient->checkemail();
												
											    if($ucreturn>0) {
									 	  	 	  	     $regname='yes';
                               	     	 		    }elseif($ucreturn==-4) {
	                                  	 		 	     $regname='�Բ���!������ĵ��������ʽ����!';
                                 	 	 		    }elseif($ucreturn == -5) {
                                     	 	  	  	     $regname='�Բ���!������ĵ�������ϵͳ������ע��!';
                                 	 	 		    }elseif($ucreturn == -6) {
									 	  			     $regname='�Բ���!������ĵ��������Ѿ���ע��!';
                                 	 			 }
											     
											   
										   }else{
											   
											     if(!$this->IsSQL('member'," WHERE safeemail='$email'")){
													  $regname='yes';
												 }else{
													  $regname='�Բ���!������ĵ��������Ѿ���ע��!';
												 }
										   }
											
									
											
									   }else{
										      if(!$this->IsSQL('member'," WHERE  email='$email'")){
													  $regname='yes';
											  }else{
													  $regname='�Բ���!������ĵ��������Ѿ���ע��!';
											  }
									   }

						  	 	 }else{
							   	        $regname='�Բ���!������������ʽ����!';
						 	     }
							}
			return $regname;				
	}
	
	
	function CheckUserName($strlen='',$value=''){

		 $filter=new CharFilter();
		 
		                    if($strlen<=2){
								 $regname='�Բ���!�ǳƲ���С��<strong>2</strong>λ��!';
							}elseif($strlen>=15){
								 $regname='�Բ���!�ǳƲ��ܴ���<strong>15</strong>λ��!';
							}else{
											
	                             
								   if($this->AllowRegisterUserName()){
								   
								   
										   if($filter->CheckString($value,1)){
		  
											   if($uclient=$this->GetClient($value,$this->POST['Password'],$this->POST['EMail'])){
														 
													   $ucreturn = $uclient->checkename();
													   if($ucreturn>0) {
															  $regname='yes';
													   }elseif($ucreturn == -1) {
															   $regname='�Բ���!�ǳƲ��Ϸ�';
													   }elseif($ucreturn == -2) {
															   $regname='�Բ���!�ǳư���Ҫ����ע��Ĵ���';
													   }elseif($ucreturn == -3) {
															   $regname='�Բ���!�û����Ѿ�����!';
													   }
													  
											   }else{
													  
												   
													   if(!$this->IsSQL('member'," WHERE username='$value'")){
																$regname='yes';
													   }else{
																$regname='�Բ���!�û����Ѿ�����!';
													   }
												   
											   }
						  
				   
										  }else{
		  
											   $regname='�Բ���!�ǳƲ��ܺ��������ַ�!';
										  }
								   }else{
										  $regname='�Բ���!�û�����ע��!';
								   }
						    }
		  return $regname;					
	}
	
	function CheckPassword($strlen='',$password=''){
 
		    $filter=new CharFilter();
		 
			if($strlen<6){
				 $regname='�Բ���!���벻��С��<strong>6</strong>λ��!';
			}elseif($strlen>=32){
				 $regname='�Բ���!���벻�ܴ���<strong>32</strong>λ��!';
			}else{
				
				 if($filter->CheckSpecialString($password)){
					  $regname='yes';
				 }else{
					  $regname='�Բ���!�����ʽ����,������������ĸ���!';
				 }
				 
			}	
			
		    return $regname;				
	}

	//��麯������------------------------------------------------------------------------------------------------

	
	
	//check
	function CheckRegister($isseccode=0){
		
		 $checkdata=0;
		 
		 $password='';
		 
		 foreach($this->POST as $key=>$value){
			 
			  if(!$value){
				   if($key=='EMail'){
					   $this->errors[$key]='�Բ���!�������䲻��Ϊ��!';
				   }elseif($key=='UserName'){
					   $this->errors[$key]='�Բ���!�ǳƲ���Ϊ��!'; 
				   }elseif($key=='Password'){
					   $this->errors[$key]='�Բ���!���벻��Ϊ��!';
				   }elseif($key=='SecCode'){
					   if(PHPAPP::$config['registeriscode']){
							 if(!$isseccode){
								  $this->errors[$key]='�Բ���!��֤�벻��Ϊ��!';
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
									   $this->errors[$key]='�Բ���!��֤�벻��ȷ,����������!';
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
		
		 
		 //��� and UC
		
		 if($uclient=$this->GetClient($this->POST['UserName'],$this->POST['Password'],$this->POST['EMail'])){
			  
			  $APIuid = $uclient->register();
			  
			  if($APIuid>0){

					    $APIuid =$this->RegisterMember($APIuid);
				 
				  
			  }else{
			         switch($APIuid){
					          case -1:				  
						      echo '�û������Ϸ�';
					          break;
							  case -2:
							  echo '����Ҫ����ע��Ĵ���';				  
							  break;
							  case -3:
							  echo '�û����Ѿ�����';
							  break;
							  case -4:
							  echo 'Email ��ʽ����';
							  break;
							  case -5:
							  echo 'Email ������ע��';
							  break;
							  case -6:
							  echo '�� Email �Ѿ���ע��';
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
			 
			   //��¼
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
		 
			 
		 //��Ա����
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
					  'sms_msggoid'=>$newuid, //�ռ���
					  'sms_msgtoid'=>0,
					  'sms_mailbox'=>'1',
					  'sms_subject'=>str_replace('{username}',$this->POST['UserName'],PHPAPP::$config['registerednoticesubject']),
					  'sms_content'=>str_replace('{username}',$this->POST['UserName'],PHPAPP::$config['registerednoticecontent'])
				  );
				  
				  
				  include_once(APPS.'/sms/class/port_class_phpapp.php');
				  
				  $sms=new SMSPort();
				  
				  $sms->SendSMS($postsms); //����
   
		  }

		 //�ƹ�
		 if($unionid>0){
		       
			   
			   $unionmember=$this->GetMysqlOne('username'," ".$this->GetTable('member')." WHERE uid='$unionid'");
			   
		 	   $feedarray=array(

							//Feed
							
							'feed_uid'=>$unionid,
							'feed_username'=>$unionmember['username'],
							'feed_app'=>20,
							'feed_action'=>1,
							'feed_title_template'=>'{title}',
							'feed_title_data'=>'���� '.$this->POST['UserName'].' ע���Ա�ɹ�!',
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
	
	
	
	//�޸�����

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
										   
										   //��վ
										   $this->Update('member',array('password'=>$newkey),array()," WHERE uid='$uid'");
										   
										   //UC
										   if($uclient=$this->GetClient($userarr['username'],$post['PasswordOld'])){
											    
												 $uclient->user_edit($post['Password']);
											   
										   }
										   
										   if($isok){
											     $result='ok';
										   }else{
										         $result='���óɹ�!<br />';
										   }
									}else{
										 
										  $result='ȷ�����벻һ��!<br />';
									}

								   
								
						    }else{
								  $result=$setpassword.'<br />';
							}
							
						   
						
					}else{
						
						 $result='����������!<br />';
						
				    }		
					
					
				   return $result;
		
		
	}
	
	
	function SetNewPassword($uid=0,$newpassword=''){
		             
					 $userarr=$this->GetMysqlOne('uid,powercode,username'," ".$this->GetTable('member')." WHERE uid='$uid'");
		 
		             $newkey=$this->PasswordKey($userarr['username'],$newpassword,$userarr['powercode']);
										   
					 //��վ
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