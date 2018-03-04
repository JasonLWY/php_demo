<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class RealNamePersonalMemberControls extends PHPAPP{
	
    private $POST,$GET;
	
	
	function __construct(){	 
	 
		 parent::__construct();
		 
		 
		 $this->POST=$this->POSTArray(); 
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','sort'));
		 
		 if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
		 if(!PHPAPP::$config['personalisopenmobile']){
			   //mobile
			   if(!$this->IsSQL('member_mobile_certificate',"WHERE uid='$this->uid' AND status=5 ")){
				   
					 $this->Refresh('请先进行手机认证!','member.php?app=21');
					 exit();
			   }
		 }
		 
	}
	
	
	public function DefaultAction(){
		
		  return $this->RealNameVerifyAction();
		
	}
	
	
	
	public function RealNameVerifyAction(){
		
		  if($this->IsSQL('member',"WHERE uid='$this->uid' AND usertype=1")){
			  
				  include_once(Core.'/class/filter_class_phpapp.php');
				  
				  $certificate=$this->GetMysqlOne('*'," ".$this->GetTable('member_personal_certificate')." WHERE uid='$this->uid'");
				  
				  if($certificate){
						if($certificate['status']==4){
							
							  if(!$this->GET['op']==5){
								   $this->GET['op']=4;
							  }else{
								   $this->GET['op']=5;
							  }
							  
						}elseif($certificate['status']==5){
							  $this->GET['op']=5;
						}elseif($certificate['status']==6){
							  $this->GET['op']=6;
						}
				  }
		
				  
				  $this->POST['type']=empty($this->POST['type']) ? 0 : intval($this->POST['type']);
				   
				  if($this->GET['op']==1){
						
						  $this->Update('member_personal_certificate',array('status'=>1),array(),"WHERE uid='$this->uid' ");
				
				  
				  }elseif($this->GET['op']==2){
		
						if($this->POST['type']==1){
							  //线下银行
							  $checknum=0;
							  
							  $bankaddress=intval($this->POST['bankaddress']);
							  
							  if(!$bankaddress){
									$Error='请选择开户所在地分类!</br>';
							  }else{
									$checknum+=1;
							  }
							  
							  $bankname=$this->str($this->POST['bankname'],255,1,0,1,0,1);
							
							  $string=new CharFilter($bankname);
							  
							   if(empty($bankname)){
									 $Error='请输入支行名称!</br>'; 
							   }elseif($string->CheckLength(3)){ 
									 $Error='对不起！,支行名称不能少3个字!</br>';
							   }else{
									 $checknum+=1;
							   }
							  
							  $bankcard1=$this->str($this->POST['bankcard1'],255,1,0,1,0,1);
							  
							  $string=new CharFilter($bankcard1);
							  
							   if(empty($bankcard1)){
									 $Error='请输入银行卡号!</br>'; 
							   }elseif($string->CheckLength(3)){ 
									 $Error='对不起！,银行卡号不能少3个字!</br>';
							   }else{
									 $checknum+=1;
							   }
							   
							   
							   if($checknum==3){
									   
									  if(!$this->IsSQL('member_personal_certificate',"WHERE uid='$this->uid'")){
										  
											 $this->Insert('member_personal_certificate',array('bankid'=>$this->POST['bankid1'],'bankcard'=>$bankcard1,'bankaddress'=>$bankaddress,'type'=>1,'bankname'=>$bankname,'dateline'=>$this->NowTime(),'uid'=>$this->uid,'status'=>2),array());
									  }else{
										  
											$this->Update('member_personal_certificate',array('bankid'=>$this->POST['bankid1'],'bankcard'=>$bankcard1,'bankaddress'=>$bankaddress,'bankname'=>$bankname,'type'=>1,'status'=>2),array(),"WHERE uid='$this->uid' ");
									  }
								   
							   }else{
									echo $this->Refresh($Error,'member.php?app=15&action=1&op=1');
									exit();
							   }
							   
							
						}elseif($this->POST['type']==2){
							
							  $checknum=0;
							  
							  $bankcard2=$this->str($this->POST['bankcard2'],255,1,0,1,0,1);
							  
							  $string=new CharFilter($bankcard2);
							  
							   if(empty($bankcard2)){
									 echo '请输入在线工具帐号!</br>'; 
							   }elseif($string->CheckLength(3)){ 
									 echo '对不起！,在线工具帐号不能少3个字!</br>';
							   }else{
									 $checknum=1;
							   }
		
							
							   if($checknum==1){
									   
									  if(!$this->IsSQL('member_personal_certificate',"WHERE uid='$this->uid'")){
										  
											 $this->Insert('member_personal_certificate',array('bankid'=>$this->POST['bankid2'],'bankcard'=>$bankcard2,'type'=>2,'dateline'=>$this->NowTime(),'uid'=>$this->uid,'status'=>2),array());
									  }else{
										  
											$this->Update('member_personal_certificate',array('bankid'=>$this->POST['bankid2'],'bankcard'=>$bankcard2,'type'=>2,'status'=>2),array(),"WHERE uid='$this->uid' ");
									  }
								   
							   }else{
									echo $this->CloseNowWindows('#loading',1);
									exit();
							   }
						
						
						
						}
						
						$this->Update('member_personal_certificate',array('status'=>2),array(),"WHERE uid='$this->uid' ");
		
						
				  }elseif($this->GET['op']==3){
							
								$this->Update('member_personal_certificate',array('status'=>3),array(),"WHERE uid='$this->uid' ");
							  
								$checknum=0;
								
								$realname=$this->str($this->POST['realname'],20,1,0,1,0,1);
							  
							   $string=new CharFilter($realname);
							  
							   if(empty($realname)){
									 $Error= '请输入真实姓名!</br>'; 
							   }elseif($string->CheckLength(2)){ 
									 $Error='对不起！,真实姓名不能少2个字!</br>';
							   }else{
									 $checknum+=1;
							   }
								
								
							   $idnumber=$this->str($this->POST['idnumber'],30,1,0,1,0,1);
							  
							   $string=new CharFilter($idnumber);
							  
							   if(empty($idnumber)){
									 $Error= '请输入身份证号!</br>'; 
							   }elseif($string->CheckLength(10)){ 
									 $Error='对不起！,身份证号不能少10个号码!</br>';
							   }else{
									 $checknum+=1;
							   }
							   
							   
							    if($this->IsSQL('member_personal_certificate',"WHERE idnumber='$idnumber' AND status=5 ")){
										
										 echo $this->Refresh('对不起！该身份证信息已经使用！不能重复提交！','member.php?app=15&action=1&op=2');
									     exit();
										
							    }
									
							   
								include_once(Core.'/class/photo_upload_phpapp.php');
		
					  
							   if($_FILES['frontphoto']['size']>0){
								   
								     if($_FILES['frontphoto']['size']> intval(PHPAPP::$config['oneimageuploadsize'])){
											$errors='对不起!您上传的身份证正面照片不能超过 '.(PHPAPP::$config['oneimageuploadsize']/1024).'KB,请重新上传！'; 										   
											$this->Refresh($errors,'member.php?app=15&action=1&op=2');							   
									 }
											   
									 $checknum+=1;
									 $upload=new UploadPhoto($_FILES['frontphoto'],$certificate['frontphoto']);
									 $frontphoto=$upload->CheckUpload();
									 
							   }else{
									if($certificate['frontphoto']>0){
										 $frontphoto=$certificate['frontphoto'];
										 $checknum+=1;
									}else{
										 $Error= '对不起！,请上传身份证正面照片!</br>';
									}
									
							   }
									   
							   if($_FILES['rearphoto']['size']>0){
								     if($_FILES['rearphoto']['size'] > intval(PHPAPP::$config['oneimageuploadsize'])){
											$errors='对不起!您上传的身份证反面照片不能超过 '.(PHPAPP::$config['oneimageuploadsize']/1024).'KB,请重新上传！'; 										   
											$this->Refresh($errors,'member.php?app=15&action=1&op=2');							   
									 }
									 
									 $checknum+=1;
									 $upload=new UploadPhoto($_FILES['rearphoto'],$certificate['rearphoto']);
									 $rearphoto=$upload->CheckUpload();
		
							   }else{
									
									 if($certificate['rearphoto']>0){
										  $rearphoto=$certificate['rearphoto'];
										  $checknum+=1;
									 }else{
										   $Error='对不起！请上传身份证反面照片!</br>';
									 }
		
							   }   
		
		
							  if($checknum==4){
				                     

									$this->Update('member_personal_certificate',array('realname'=>$realname,'idnumber'=>$idnumber,'frontphoto'=>$frontphoto,'rearphoto'=>$rearphoto),array(),"WHERE uid='$this->uid' ");
		
									 
							  }else{
									echo $this->Refresh($Error,'member.php?app=15&action=1&op=2');
									exit();
							  }
		
							
				  }elseif($this->GET['op']==4){
							
							
							if($this->IsSQL('member_personal_certificate',"WHERE uid='$this->uid' AND frontphoto>0 AND rearphoto>0 ")){
								  
								  
								  
									if(!$this->IsSQL('member_personal_certificate',"WHERE uid='$this->uid' AND status=4")){
										   
										   $smallverifymoney=PHPAPP::$config['smallverifymoney'];
										   if($smallverifymoney<=0){
												$smallverifymoney=20;
										   }else{
												$smallverifymoney=$smallverifymoney*100;
										   }
										   
										   srand((double)microtime()*1000000);
										   $verifymoney=(rand(1,$smallverifymoney))/100;
				
										   $this->Update('member_personal_certificate',array('status'=>4,'verifymoney'=>floatval($verifymoney)),array(),"WHERE uid='$this->uid' ");
										
									}
		
								
							}else{  
							        $Error= '对不起！请上传身份证照片!</br>';
									echo $this->Refresh($Error,'member.php?app=15&action=1&op=2');
									exit();
							}	
							
							
				  }elseif($this->GET['op']==5){
					  
							
							if($this->IsSQL('member_personal_certificate',"WHERE uid='$this->uid' AND status=4 AND frontphoto>0 AND rearphoto>0")){
								
		
								  if(!empty($this->POST['verifymoney'])){
									  
										$verify=$this->GetMysqlOne('verifymoney,errornum'," ".$this->GetTable('member_personal_certificate')." WHERE uid='$this->uid'");
										 
										if($verify['verifymoney']==$this->POST['verifymoney']){
											
											   //手续费
											   $certificate=$this->GetMysqlOne('price_phpapp'," ".$this->GetTable('certificate')." WHERE app_phpapp='$this->app'");
											   
											   if($certificate['price_phpapp']>0){
												   
													   //检查用户可用金额
													   $user=$this->GetMysqlOne('*'," ".$this->GetTable('member_account')." WHERE uid='$this->uid'");
													
													   if($user['money']>=$certificate['price_phpapp']){
															  
															  
															  include_once(APPS.'/apppay/class/consume_class_phpapp.php');
		
															  $pay=new UserConsume();
															  
															  $newcid=$pay->MakeConsume(array(
																					  'subject'=>'<p>实名认证</p>手续费',  
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
													  
													    
											
												$this->Update('member_personal_certificate',array('status'=>5),array(),"WHERE uid='$this->uid' ");
												
												
												$myinfo=$this->GetMysqlOne('certificate',"  ".$this->GetTable('member_info')." WHERE uid='$this->uid' ");
													
		
												$certificates=$this->SetCertificateIcon($myinfo['certificate'],'Personal');
													
													
												$this->Update('member_info',array('certificate'=>$certificates,'realname'=>0),array(),"WHERE uid='$this->uid'");
											
												//推广提成
												@require_once(APPS.'/union/class/result_class_phpapp.php');
												
												new UnionResult(array('uid'=>$this->uid,'app'=>$this->app,'appid'=>$this->app,'rebate'=>floatval(PHPAPP::$config['personalcertificatemoney']),'subject'=>'个人实名认证'));


												echo '恭喜您,认证成功!';
												echo $this->CloseNowWindows('#loading',1);
												
											 
											  
										}else{
											  
											  $verify['errornum']+=1;
											  
											  if($verify['errornum']>=3){
												  
													$this->Update('member_personal_certificate',array('status'=>6),array(),"WHERE uid='$this->uid' ");
													
													echo '验证金额有误,您已验证错误3次系统已自动锁定禁止验证!';
													
													echo $this->CloseNowWindows('#loading',1);
													
											  }else{
											  
													$this->Update('member_personal_certificate',array('errornum'=>$verify['errornum']),array(),"WHERE uid='$this->uid' ");
													echo '验证金额有误!';
													echo $this->CloseNowWindows('#loading');
											  }
										}
			
									  
								  }else{
									   echo '请输入确认金额!';
									   echo $this->CloseNowWindows('#loading');
								  }
								  
								  exit();
								
								
							}else{  
							        if($this->IsSQL('member_personal_certificate',"WHERE uid='$this->uid' AND status!=5")){
											$Error= '对不起！身份信息不完整!</br>';
											echo $this->Refresh($Error,'member.php?app=9');
											exit();
									}
							}	
							
							
							
				  }
				  
				  $certificate=$this->GetMysqlOne('*'," ".$this->GetTable('member_personal_certificate')." WHERE uid='$this->uid'");
				  
				  $bankarr=$this->GetMysqlArray('*'," ".$this->GetTable('bankname')."");
				  
				  $onlinebank=$this->GetMysqlArray('*'," ".$this->GetTable('pay_tool')." WHERE type_phpapp=0 AND status_phpapp=0 ORDER BY displayorder_phpapp ASC");
		
									   
				  $member=$this->GetMysqlOne('cookiecode'," ".$this->GetTable('member')." WHERE uid='$this->uid'");
				  $cookiecode=$member['cookiecode'];
				
				  include $this->Template('realpersonal');
				  
		   }else{
			   
			     echo $this->Refresh('对不起！企业用户不能进行个人实名认证！','member.php?app=12');
		   }
		
	}
	
	
}

?>