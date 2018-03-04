<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class EMailMemberControls extends PHPAPP{
	
    private $POST,$GET;
	
	
	function __construct(){	 
	 
		 parent::__construct();

		 $this->POST=$this->POSTArray();
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','sort'));


		 if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
		 
	}
	
	
	public function DefaultAction(){
		  
		  if($this->IsSQL('member_mail_certificate'," WHERE uid='$this->uid' AND status>0")){
			    return $this->ShowEMailVerifyAction();
		  }else{
		        return $this->EMailVerifyAction();
		  }
		
	}
	
	public function EMailVerifyAction(){
          
		  $member=$this->GetMysqlOne('safeemail',"  ".$this->GetTable('member')." WHERE uid='$this->uid' ");
		  
		  
		  //是否认证过
	
		  if($this->IsSQL('member_mail_certificate'," WHERE uid='$this->uid' AND status=5")){
				

				  $this->ShowEMailVerifyAction();
					 
		  }else{
			  
			  
				if($this->GET['op']>0){
					   $isrmail=0;
					   if($this->IsSQL('member_mail_certificate'," WHERE uid='$this->uid'")){
						    
							if($this->IsSQL('member_mail_certificate'," WHERE uid='$this->uid' AND dateline< (UNIX_TIMESTAMP()-86400) ")){
								  $isrmail=0;
							}else{
								  $isrmail=1;
							}
						     
					   }
					   
					   if(!$isrmail){
						   $activation=$this->MakeCode();
						 
						   $certificate=$this->GetMysqlOne('price_phpapp',"  ".$this->GetTable('certificate')." WHERE app_phpapp='$this->app' ");
						
						   $this->SendMail($member['safeemail'],PHPAPP::$config['sitename'].'邮箱认证','<b>'.PHPAPP::$config['sitename'].'邮箱认证</b> <a href="'.$activation['url'].'" target="_blank">点击激活</a> <p>或手动复制以下激活链接地址放到浏览器地址栏中回车</p><p>'.$activation['url'].'</p>');
						   
						   if($this->IsSQL('member_mail_certificate'," WHERE uid='$this->uid' AND status>0")){
							   
								  $this->Update('member_mail_certificate',array('code'=>$activation['code'],'status'=>1),array(),"WHERE uid='$this->uid'");
						   
						   }else{
							   
								  $this->Insert('member_mail_certificate',array('uid'=>$this->uid,'email'=>$member['safeemail'],'price'=>$certificate['price_phpapp'],'oid'=>0,'dateline'=>$this->NowTime(),'status'=>1,'code'=>$activation['code']),array());      
						   
						   }
													 
						   
						   echo '发送成功，请登录邮箱激活!<br />';
					   
					   }else{
						   echo '您已经发送过了!24小时后才能再发送.<br />';
					   }
					   
					   echo $this->CloseNowWindows('#loading',1);
				 
					  
					   
					
				}else{
					
					    if($this->IsSQL('member_mail_certificate'," WHERE uid='$this->uid' AND status=6")){
					          include $this->Template('mailverify_member');
						}elseif($this->IsSQL('member_mail_certificate'," WHERE uid='$this->uid' AND status>1")){
							
							  $this->ShowEMailVerifyAction();
							
						}else{
						      include $this->Template('mailverify_member');
						}
					
				}
		  
		  }
		
	}
	
	
	
	
	public function ShowEMailVerifyAction(){
	
		     $member=$this->GetMysqlOne('safeemail',"  ".$this->GetTable('member')." WHERE uid='$this->uid' ");
			 
		     $mycertificate=$this->GetMysqlOne('*',"  ".$this->GetTable('member_mail_certificate')." WHERE uid='$this->uid' ");
	       
		   
		     include $this->Template('showverify_member');
		  
	}
	
	
	public function ActivationEMailAction(){
		
		  $code=$_GET['code'];
		  
		  if($this->uid==$this->GET['uid']){
			  
				$mycertificate=$this->GetMysqlOne('*',"  ".$this->GetTable('member_mail_certificate')." WHERE uid='$this->uid' ");
				
				if($mycertificate['status']!=5){
						if($mycertificate){ 
						
								if($this->NowTime() > ($mycertificate['dateline']+86400)){
									
										$this->Update('member_mail_certificate',array('status'=>6),array(),"WHERE uid='$this->uid'");
										//失败
										$this->Refresh('认证失败!','member.php?app=12');
								}else{
									
									  if($mycertificate['code']==$code){
										  
										    //手续费
										   $certificate=$this->GetMysqlOne('price_phpapp'," ".$this->GetTable('certificate')." WHERE app_phpapp='$this->app'");
										   
										   if($certificate['price_phpapp']>0){
											   
												   //检查用户可用金额
												   $user=$this->GetMysqlOne('*'," ".$this->GetTable('member_account')." WHERE uid='$this->uid'");
												
												   if($user['money']>=$certificate['price_phpapp']){
														  
														  
														  include_once(APPS.'/apppay/class/consume_class_phpapp.php');
	
														  $pay=new UserConsume();
														  
														  $newcid=$pay->MakeConsume(array(
																				  'subject'=>'<p>邮箱认证</p>手续费',  
																				  'appid'=>$this->app, 
																				  'paytype'=>1, 
																				  'process'=>1, 
																				  'amount'=>$certificate['price_phpapp'], 
																				  'payout'=>$this->uid, 
																				  'payin'=>0   // 收入者
																				  
																			));
														  
														  $pay->SetSuccessConsume($newcid); 
														  
														  
													}else{
														  echo '对不起！你的余额不足认证手续费 '.$certificate['price_phpapp'].' 元,请充值后操作！';
														  echo $this->AjaxRefresh('member.php?app=5&action=2',1);
														  exit();
													}
											
											}
				                            
											$member=$this->GetMysqlOne('safeemail',"  ".$this->GetTable('member')." WHERE uid='$this->uid' ");
											
											$this->Update('member_mail_certificate',array('status'=>5,'email'=>$member['safeemail']),array(),"WHERE uid='$this->uid'");
											
											$myinfo=$this->GetMysqlOne('certificate',"  ".$this->GetTable('member_info')." WHERE uid='$this->uid' ");
											

											$certificates=$this->SetCertificateIcon($myinfo['certificate'],'Mail');
											
											
											$this->Update('member_info',array('certificate'=>$certificates),array(),"WHERE uid='$this->uid'");
											
											
											$this->Refresh('认证成功!','member.php?app=12');
			  
									  }else{
										  
										   //失败
										   $this->Update('member_mail_certificate',array('status'=>6),array(),"WHERE uid='$this->uid'");
										   $this->Refresh('认证失败!','member.php?app=12');
										   
									  }
									 
									
								}
						}else{
							 $this->Refresh('认证不存在!','member.php?app=12');
						}
				}else{
					  $this->Refresh('认证过了!','member.php?app=12');
				}
		  }else{
			    $this->Refresh('用户ID不一致!','member.php?app=12');
		  }
		
	}
	
	
	function MakeCode(){
		
			$code=$this->RandomText(32,1);
			
	
			$activationarr=array('url'=>SURL.'/member.php?app='.$this->app.'&action=3&uid='.$this->uid.'&code='.$code,'code'=>$code);	
		
			
			return $activationarr;
	}
	
}

?>