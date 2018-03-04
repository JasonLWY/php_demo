<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class MemberVIPMemberControls extends PHPAPP{
	
    private $POST,$GET;
	
	
	function __construct(){	 
	 
		 parent::__construct();
		 
		 $postkey=array('Submit'=>'');
		 
		 $this->POST=$this->POSTArray(); 
		   
		   
		 foreach($postkey as $key=>$vaule){
			 if(empty($this->POST[$key])){
				 $this->POST[$key]='';
			 }
		 }
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','sort'));
		 
		 if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
		 if(!PHPAPP::$config['vipisopenmobile']){
			   //mobile
			   if(!$this->IsSQL('member_mobile_certificate',"WHERE uid='$this->uid' AND status=5 ")){
				   
					 $this->Refresh('���Ƚ����ֻ���֤!',SURL.'/member.php?app=21');
					 exit();
			   }
		 }
		 
		 
		 if(!PHPAPP::$config['vipisopenrealname']){
				//personal
					 
			   $userarr=$this->GetLoginInfo($this->uid,1);
			   
			   if($userarr['usertype']==1){

					 $appid=15;
					 
					 if(!$this->IsSQL('member_personal_certificate',"WHERE uid='$this->uid' AND status=5 ")){
						   
						    $this->Refresh('����ʵ����֤!',SURL.'/member.php?app='.$appid);
						 
					 }
			   
			   }elseif($userarr['usertype']==2){
				   
					 $appid=16;
					 
					 if(!$this->IsSQL('member_company_certificate',"WHERE uid='$this->uid' AND status=5 ")){
						   
						    $this->Refresh('����ʵ����֤!',SURL.'/member.php?app='.$appid);
						 
					 }
					 
			   }
			  
		 }
		 
	}
	
	
	public function DefaultAction(){
		
		  return $this->MemberVipVerifyAction();
		
	}
	
	
	
	public function MemberVipVerifyAction(){
		
		  $userarr=$this->GetLoginInfo($this->uid);
		  
		  $myusergroup=$userarr['usergroup'];

		  $myusergroup=$this->GetMysqlOne('groupname'," ".$this->GetTable('usergroup')." WHERE gid='$myusergroup'");
		
		  if($this->IsSQL('member',"WHERE uid='$this->uid'")){

				  
				  if($this->POST['Submit']){
					  
					      $gid=intval($this->POST['usergroup']['gid']);
						  
						  $usergroup=$this->POST['usergroup'][$gid];
						  
						  $nowusergroup=$this->GetMysqlOne('groupname'," ".$this->GetTable('usergroup')." WHERE gid='$gid'");
						  
						  $month=intval($usergroup['month']);
						  
						  $paymoney=floatval($usergroup['price'])* $month;
					
						  
						  if($userarr['money']>=$paymoney){
							  
							  
							      include_once(APPS.'/apppay/class/consume_class_phpapp.php');

								  $pay=new UserConsume();
								  
								  $newcid=$pay->MakeConsume(array(
														  'subject'=>'����'.$nowusergroup['groupname'], 
														  'appid'=>$this->app, 
														  'paytype'=>1, 
														  'process'=>1, 
														  'amount'=>$paymoney, 
														  'payout'=>$this->uid, 
														  'payin'=>0  
														  
													));
								  
								  
								  
								  $pay->SetSuccessConsume($newcid); 
								  
								  
								  //�ƹ�Ա-------------------------------------------------
								  
								  if(!empty($userarr['unionid'])){
									     
										 $unionfee=$paymoney*floatval(PHPAPP::$config['membervipunionfee']);
										
										 if($unionfee>0){
											     
											      $newcid=$pay->MakeConsume(array(
																				 'subject'=>'<p>�ƹ�VIP���</p>�ƹ��Ա'.$this->username, 
																				 'appid'=>intval($this->app),
																				 'process'=>1,
																				 'amount'=>$unionfee,
																				 'paytype'=>1, 
																				 'payout'=>0,
																				 'payin'=>$userarr['unionid']
																				 
																		   ));
																	  
												  $pay->SetSuccessConsume($newcid);
												  

												  $unionmember=$this->GetMysqlOne('*',"  ".$this->GetTable('member_account')." WHERE uid='$userarr[unionid]'");
																	  
												  $this->Update('member_account',array('union'=>$unionmember['union']+$unionfee),array()," WHERE uid='$userarr[unionid]'");
												  	  
												  
												  if($this->IsSQL('member_union'," WHERE uid='$userarr[unionid]' AND appid='$this->app' ")){
							
														 $memberunion=$this->GetMysqlOne('*'," ".$this->GetTable('member_union')." WHERE uid='$userarr[unionid]' AND appid='$this->app' ");
														 
														 $unionmoney=$memberunion['money']+$unionfee;
														 
														 $uniontotal=$memberunion['total']+$unionfee;
														  
														 $this->Update('member_union',array('money'=>$unionmoney,'total'=>$uniontotal),array(),"WHERE uid='$userarr[unionid]' AND appid='$this->app' ");
													 
												  }else{
													 
														 $this->Insert('member_union',array('uid'=>$userarr['unionid'],'appid'=>$this->app,'money'=>$unionfee,'total'=>1),array());
													 
												  }
																				
												  
												  $this->Port(array(
													 
													  'sms_msggoid'=>$userarr['unionid'],
													  'sms_msgtoid'=>0,
													  'sms_mailbox'=>'1',
													  'sms_subject'=>'�ƹ�'.$this->username.'����VIP������ƹ���ɡ�',
													  'sms_content'=>'�𾴵��ƹ�Ա�����ƹ��'.$this->username.'��Ա����ΪVIP,������ƹ���� '.$unionfee.'Ԫ'
													  
													  ));
												  
											 
										 }
										 
										 
								  }
									 
									 
									 
									 
									 
								  
								  //------------------------------------------------------- 
								  
								  
								  
								  if($this->IsSQL('member_vip',"WHERE uid='$this->uid'")){
									    
										$memberviparr=$this->GetMysqlOne('*'," ".$this->GetTable('member_vip')." WHERE uid='$this->uid'");
										
										$endtime=$memberviparr['endtime']+($month*31*24*60*60);
										
										if($userarr['usergroup']==$gid){
											 
											  $this->Update('member_vip',array('endtime'=>$endtime,'price'=>$memberviparr['price']+$paymoney),array()," WHERE uid='$this->uid' ");
											
										}else{
										      
											  $this->Update('member',array('usergroup'=>$gid),array()," WHERE uid='$this->uid' ");
											  
										      $this->Update('member_vip',array('endtime'=>$endtime,'usergroup'=>$gid,'price'=>$memberviparr['price']+$paymoney),array()," WHERE uid='$this->uid' ");
										
										}

	
										$this->Update('autorun',array('runtime'=>$endtime),array()," WHERE aid='$memberviparr[auto]' ");
										
		  
								  }else{
					
										//����
										include_once(Core.'/class/auto_class_phpapp.php');
									   
										$auto=new AUTO();
									   
										$autoday=$month*31;
									   
										$runtime=$this->NowTime()+($autoday*24*60*60);
									   
										$runid=$auto->SetAutoRun(array(
													'app'=>$this->app,
													'runtime'=>$runtime,
													'function'=>'MemberDemote',
													'uid'=>$this->uid
										));
											  
									   
										$this->Insert('member_vip',array('uid'=>$this->uid,'usergroup'=>$gid,'price'=>floatval($paymoney),'endtime'=>$runtime,'status'=>5,'dateline'=>$this->NowTime(),'month'=>$month,'auto'=>$runid),array());

										
										$this->Update('member',array('usergroup'=>$gid),array(),"WHERE uid='$this->uid'");
								  
								  }
								  								
																				
								  //��־-----------------------------------------
								  $myinfo=$this->GetMysqlOne('certificate',"  ".$this->GetTable('member_info')." WHERE uid='$this->uid' ");
								  
								  $certificates=$this->SetCertificateIcon($myinfo['certificate'],'VIP');
											  
								  $this->Update('member_info',array('certificate'=>$certificates),array(),"WHERE uid='$this->uid'");
								  
								  //---------------------------------------------
								  
								  
								  echo $this->Refresh('��ϲ�������ɹ���!',$this->MakeGetParameterURL());
							   
							  
						  }else{
							  
							     echo $this->Refresh('�Բ���!��������'.$paymoney.'Ԫ�����ֵ�����.',SURL.'/member.php?app=5&action=2');
							  
						  }

						  
						  exit();
						
					  
				  }else{

						$membervipset=$nowusergroup=array();
						   
						if(PHPAPP::$config['membervip']){
							   $membervipset=unserialize(PHPAPP::$config['membervip']);
						}
	
						include $this->Template('membervip');
				  }
				  
		   }else{
			   
			     echo $this->Refresh('�Բ���!�����ʵ�ҳ�治����!',SURL.'/member.php?app=12');
		   }
		
	}
	
	
	public function MemberVipDscriptionAction(){
		   
		
		   
		
		   include $this->Template('dscription_member');
	}

}

?>