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
							  
						  echo '������Ĵ���̫����,��������֤!<br />';
						  echo $this->AjaxRefresh('member.php?app=21&action=1',1);
						  exit();
							
				  }
					
				  if($this->IsSQL('member_mobile_certificate',"WHERE code='$verify' AND uid='$this->uid'")){
					  
					
					   $certificate=$this->GetMysqlOne('price_phpapp'," ".$this->GetTable('certificate')." WHERE app_phpapp='21'");
					   
					   if($certificate['price_phpapp']>0){
						   
							   //����û����ý��
							   $user=$this->GetMysqlOne('*'," ".$this->GetTable('member_account')." WHERE uid='$this->uid'");
							
							   if($user['money']>=$certificate['price_phpapp']){
									  
									  
									  include_once(APPS.'/apppay/class/consume_class_phpapp.php');

									  $pay=new UserConsume();
									  
									  $newcid=$pay->MakeConsume(array(
															  'subject'=>'<p>�ֻ���֤</p>������',  
															  'appid'=>$this->app, 
															  'paytype'=>1, 
															  'process'=>1, 
															  'amount'=>$certificate['price_phpapp'], 
															  'payout'=>$this->uid, 
															  'payin'=>0   // ������
															  
														));
									  
									  $pay->SetSuccessConsume($newcid); 
									  
									  
								}else{
									  echo '�Բ������������֤������ '.$certificate['price_phpapp'].' Ԫ,���ֵ�������';
									  echo $this->AjaxRefresh('member.php?app=5&action=2',1);
									  exit();
								}
						
						}
						
						
					    
						$this->Update('member_mobile_certificate',array('status'=>5),array(),"WHERE uid='$this->uid' ");
						
						$certificates=$this->SetCertificateIcon($this->member['certificate'],'Mobile');
						
						$this->Update('member_info',array('certificate'=>$certificates),array(),"WHERE uid='$this->uid'");
						
						echo '��֤�ɹ�!<br />';
						echo $this->CloseNowWindows('#loading',1);
					  
				  }else{
					  

						$this->Update('member_mobile_certificate',array('errornum'=>$errornum),array(),"WHERE uid='$this->uid' ");
						
						echo '��֤������!<br />';
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
									  
									    echo '<p>�Բ���!���ֻ�����֤����</p><p>�뻻�����ֻ�����!</p>';
										
										echo $this->CloseNowWindows('#loading');
										
									    exit();
								  }
								
								  
								  $ecertificatetime=intval(PHPAPP::$config['mobilecertificatetime'])*60*60 + intval($this->certificate['dateline']);
								  
	  
								  //���ʹ���
								  
								  if($this->certificate['number']>=intval(PHPAPP::$config['mobilecertificatenumber'])){
									  
										if($this->NowTime() > $ecertificatetime){
											  $this->Update('member_mobile_certificate',array('number'=>0),array()," WHERE uid='$this->uid' ");
										}
									  
										echo '�Բ���!'.intval(PHPAPP::$config['mobilecertificatetime']).'Сʱ��ֻ�ܷ���'.intval(PHPAPP::$config['mobilecertificatenumber']).'������������!<br />';
										
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
											
										$content='��л������'.PHPAPP::$config['sitename'].'�ֻ���֤,��֤��Ϊ��'.$code.' ����ҳ����������֤������ֻ���֤���Ǳ��˲���,����Ա���Ϣ��';
										  
										$result=$mobile->SendSMS($mobilenumber,$content);
										  
										if($result=='ok'){
													
											  echo '���ͳɹ�!���ŵ�����Ҫ1-2����,�յ���֤�������ҳ�ύ��֤.<br />';
											  
											  echo $this->AjaxRefresh('member.php?app=21&action=2',1);
											  
										}else{
											
											  echo $result.'<br />';
											  
											  echo $this->CloseNowWindows('#loading');
										}
										
								  }
							
								  
							  
								 
								
						  }else{
								$this->Refresh('�ֻ��Ÿ�ʽ����ȷ!','member.php?app=21&action=1');
						  }
						  
				  }else{
					  
						$this->Refresh('�ύ���ѹ���!','member.php?app=21&action=1');
				  }
						
				
				
			}else{
				   
		           include $this->Template('mobile');
			}
	}
	
	
	
	
	
	
	
}

?>