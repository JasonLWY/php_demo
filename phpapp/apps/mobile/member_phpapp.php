<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class MobileMemberControls extends PHPAPP{
	
    private $POST,$GET;
	
	public $member,$certificate;
	
	function __construct(){	 
	 
		 parent::__construct();
		 
		 $postkey=array('Submit'=>'');
		 
		 $this->POST=$this->POSTArray();
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','sort'));

		 
		 if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
		  
		 foreach($postkey as $key=>$vaule){
			 if(empty($this->POST[$key])){
				 $this->POST[$key]='';
			 }
		 }
		 
		$this->member=$this->GetMysqlOne('mobile,certificate',"  ".$this->GetTable('member_info')." WHERE uid='$this->uid' ");
		
		$this->certificate=$this->GetMysqlOne('status,number,dateline,errornum,price',"  ".$this->GetTable('member_mobile_certificate')." WHERE uid='$this->uid' ");
		 
	}
	
	
	public function DefaultAction(){
		  
		  if($this->IsSQL('member_mobile_certificate'," WHERE uid='$this->uid' AND status>0")){
			    return $this->MobileVerifyAction();
		  }else{
		        return $this->ShowVerifyAction();
		  }
		
	}
	
	
	public function SuccessVerifyAction(){
		
		
		    include $this->Template('success');
	}
	
	
	public function  MobileVerifyAction(){
		   
		
		    if($this->certificate['status']==5){
				     $this->SuccessVerifyAction();
					 exit();
			}
		   
		   if($this->GET['op']==1){
			   

			      $errornum=$this->certificate['errornum']+1;
				  
			      $verify=intval($this->POST['verify']);
				  
				  
				  if($errornum==4){
							  
						  echo '您输入的错误太多了,请重新认证!<br />';
						  echo $this->AjaxRefresh('member.php?app=21&action=1',1);
						  exit();
							
				  }
					
				  if($this->IsSQL('member_mobile_certificate',"WHERE code='$verify' AND uid='$this->uid'")){
					  
					
					   $certificate=$this->GetMysqlOne('price_phpapp'," ".$this->GetTable('certificate')." WHERE app_phpapp='21'");
					   
					   if($certificate['price_phpapp']>0){
						   
							   //检查用户可用金额
							   $user=$this->GetMysqlOne('*'," ".$this->GetTable('member_account')." WHERE uid='$this->uid'");
							
							   if($user['money']>=$certificate['price_phpapp']){
									  
									  
									  include_once(APPS.'/apppay/class/consume_class_phpapp.php');

									  $pay=new UserConsume();
									  
									  $newcid=$pay->MakeConsume(array(
															  'subject'=>'<p>手机认证</p>手续费',  
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
						
						
					    
						$this->Update('member_mobile_certificate',array('status'=>5),array(),"WHERE uid='$this->uid' ");
						
						$certificates=$this->SetCertificateIcon($this->member['certificate'],'Mobile');
						
						$this->Update('member_info',array('certificate'=>$certificates),array(),"WHERE uid='$this->uid'");
						
						echo '验证成功!<br />';
						echo $this->CloseNowWindows('#loading',1);
					  
				  }else{
					  

						$this->Update('member_mobile_certificate',array('errornum'=>$errornum),array(),"WHERE uid='$this->uid' ");
						
						echo '验证码有误!<br />';
						echo $this->CloseNowWindows('#loading');
					
					  
				  }
		   }else{
		   
		          include $this->Template('verify');
		   }
	}
	
	
	
	public function ShowVerifyAction(){
		    

            if($this->certificate['status']==5){
				     $this->SuccessVerifyAction();
					 exit();
			}

			if($this->GET['op']==1){
				
                  if($this->CheckSecurityForm($this->POST['SecurityForm'])){
					  
						  if(is_numeric($this->POST['mobile'])){
							      
								  $membermobile=$this->POST['mobile'];
								  
							      if($this->IsSQL('member_mobile_certificate'," WHERE mobile='$membermobile' AND status=5 ")>=PHPAPP::$config['mobileusenumber']){
									  
									    echo '<p>对不起!该手机已认证过了</p><p>请换其它手机号码!</p>';
										
										echo $this->CloseNowWindows('#loading');
										
									    exit();
								  }
								
								  
								  $ecertificatetime=intval(PHPAPP::$config['mobilecertificatetime'])*60*60 + intval($this->certificate['dateline']);
								  
	  
								  //发送次数
								  
								  if($this->certificate['number']>=intval(PHPAPP::$config['mobilecertificatenumber'])){
									  
										if($this->NowTime() > $ecertificatetime){
											  $this->Update('member_mobile_certificate',array('number'=>0),array()," WHERE uid='$this->uid' ");
										}
									  
										echo '对不起!'.intval(PHPAPP::$config['mobilecertificatetime']).'小时内只能发送'.intval(PHPAPP::$config['mobilecertificatenumber']).'次明天再来吧!<br />';
										
										echo $this->CloseNowWindows('#loading');
									  
									  
								  }else{
								  
										include(Core.'/class/sms_class_phpapp.php');
								
										$mobile=new MobileSMS();
										
										//$mobile->CheckSum();
										
										$mobilenumber=$this->str($this->POST['mobile'],20,1,0,1,0,1);
										
										$code=$this->RandomText(6,2);
										
										if(!$this->IsSQL('member_mobile_certificate',"WHERE uid='$this->uid'")){
												  
												$this->Insert('member_mobile_certificate',array('oid'=>0,'price'=>0,'code'=>$code,'dateline'=>$this->NowTime(),'uid'=>$this->uid,'status'=>4,'number'=>0,'mobile'=>$mobilenumber),array());
										}else{
											
												$number=$this->certificate['number']+1;
												$this->Update('member_mobile_certificate',array('oid'=>0,'price'=>0,'code'=>$code,'status'=>4,'number'=>$number,'errornum'=>0,'mobile'=>$mobilenumber),array(),"WHERE uid='$this->uid' ");
										}
										
										
										
										$this->Update('member_info',array('mobile'=>$mobilenumber),array(),"WHERE uid='$this->uid' ");
											
										$content='感谢您进行'.PHPAPP::$config['sitename'].'手机认证,验证码为：'.$code.' 请在页面上输入验证码完成手机认证。非本人操作,请忽略本信息。';
										  
										$result=$mobile->SendSMS($mobilenumber,$content);
										  
										if($result=='ok'){
													
											  echo '发送成功!短信到达需要1-2分钟,收到验证码后在网页提交验证.<br />';
											  
											  echo $this->AjaxRefresh('member.php?app=21&action=2',1);
											  
										}else{
											
											  echo $result.'<br />';
											  
											  echo $this->CloseNowWindows('#loading');
										}
										
								  }
							
								  
							  
								 
								
						  }else{
								$this->Refresh('手机号格式不正确!','member.php?app=21&action=1');
						  }
						  
				  }else{
					  
						$this->Refresh('提交表单已过期!','member.php?app=21&action=1');
				  }
						
				
				
			}else{
				   
		           include $this->Template('mobile');
			}
	}
	
	
	
	
	
	
	
}

?>