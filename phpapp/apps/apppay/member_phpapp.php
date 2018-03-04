<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}



class AppPayMemberControls extends PHPAPP{
	
    private $GET,$memberlock;
	
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
		 
		 //冻结
		 $consume=$this->GetMysqlOne('sum(amount) AS moneyout ',"  ".$this->GetTable('consume')." AS a JOIN  ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE b.uid='$this->uid' AND a.paytype=4 AND a.process<5");
		 
		 $this->memberlock=floatval($consume['moneyout']);
		 
	}
	
	
	public function DefaultAction(){
		
		
		  return $this->ShowConsumeAction();
		
	}
	
	
	
	
	public function ShowConsumeAction(){
		   
		   
		    //select -----------------------------------------------------
		   $wheresql=$selectarray='';

		   if(!empty($_GET['SelectData'])){
			   
			     include_once(Core.'/class/admin_class_phpapp.php');
			   
			     $admin=new AdminClass();
				 
				 $wheresqlarr=$admin->getwheresql($_GET,
												  
												  array(
														'cid'=>array('a.cid','int'),	  
														'serial'=>array('a.serial','search'),
														'process'=>array('a.process','int'),
														'flow'=>array('b.flow','int'),
														'paytype'=>array('a.paytype','int'),
														'amount1'=>array('a.amount','part'),
														'amount2'=>array('a.amount','part'),
														'dateline1'=>array('a.dateline','time'),
														'dateline2'=>array('a.dateline','time')
															  
												   )
												  
												  );
				 
				 $wheresql=$wheresqlarr[0];
				 
				 $selectarray=$wheresqlarr[1];
		 
		   }
		   
		   //select end----------------------------------------------------
		   
		   $userinfo=$this->GetLoginInfo($this->uid);
		   
		   include_once(Core.'/class/pages_class_phpapp.php');
		   
		   /*
		   switch ($this->GET['sort']) {
							  case '1':
							  $sort=" AND b.flow='1'";
							  break;
							  case '2':
							  $sort=" AND b.flow='2'";
							  break;
							  case '3':
							  $sort=" AND a.paytype='3'";
							  break;
							  case '4':
							  $sort=" AND a.paytype='4'";
							  break;
							  default:
							  $sort='';
					  }
			*/
			
		   if($wheresql){
			    $wheresql.=" AND b.uid='$this->uid' ";
		   }else{
		        $wheresql=" WHERE b.uid='$this->uid' ";
		   }
		   
		   
		   $page=new Pages(20,$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid $wheresql  ORDER BY a.dateline DESC ");
			 
			 
			$list=$page->ShowResult();
             
		    include(APPS.'/apppay/class/process_class_phpapp.php');
			 
			$getprocess=new TaskProcess();
	
		    include $this->Template('consume_member');
	}
	
	
	
	public function PayDepositAction(){
		  
  
		   include_once(APPS.'/pay/main_phpapp.php');
									
		   $pay=new PayMainControls();
           
		   $paytoolarr=$pay->GetOnLinePay();
		   		
		   $user=$this->GetLoginInfo();
		   
		   include $this->Template('deposit_member');
	}
	
    //提现
	public function PayWithdrawAction(){

		  $member=$this->GetMysqlOne('a.usertype,b.money,b.lock',"  ".$this->GetTable('member')." AS a LEFT JOIN ".$this->GetTable('member_account')." AS b ON a.uid=b.uid WHERE a.uid='$this->uid'");
		  
		  $membertable=$this->GetTypeMember($member['usertype']);
		  
		  $isrealnamepaywithdraw=0;
		  
		  if(PHPAPP::$config['realnamepaywithdraw']){
				  if(!$this->IsSQL($membertable.'_certificate',"WHERE uid='$this->uid' AND status=5")){
						$isrealnamepaywithdraw=1;			
				  } 
			  
		  }
		  
		  if(!$isrealnamepaywithdraw){
			    
			    if($this->GET['op']==1){
					
					   $paymoney=floatval($this->POST['paymoney']);
					   
					   $withdrawsmall=floatval(PHPAPP::$config['withdrawsmall']);
					   
					   $withdrawbig=floatval(PHPAPP::$config['withdrawbig']);
					   
					   if($paymoney>=$withdrawsmall){
						    
						     if($member['money']>=$paymoney){
								  
								   if($paymoney<=$withdrawbig){
								
										 $countarr=$this->MysqlFetchArray("SELECT COUNT(*) AS count FROM ".$this->GetTable('consume')." AS a LEFT JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE b.uid='$this->uid' AND b.flow=2 AND a.paytype=4 AND FROM_UNIXTIME(a.dateline,'%Y-%m-%d')=curdate() GROUP BY curdate()");		
					  
										 $count=empty($countarr[0]['count']) ? 0 : intval($countarr[0]['count']);
								
										 $withdrawnum=intval(PHPAPP::$config['withdrawnum']);
									  
										 if($withdrawnum>$count){
		
										 
												include_once(APPS.'/apppay/class/consume_class_phpapp.php');
		  
												$pay=new UserConsume();
												
												$tablename=$membertable.'_certificate';
												
												$certificate=$this->GetMysqlOne('type,bankid,bankcard'," ".$this->GetTable($tablename)." WHERE uid='$this->uid' AND status=5");
												
												$bankid=$certificate['bankid'];
												
												if($certificate['type']==1){
													
													   $bankarr=$this->GetMysqlOne('bankname'," ".$this->GetTable('bankname')." WHERE bankid='$bankid'");
													   
													   $bankname=$bankarr['bankname'];
													
												}elseif($certificate['type']==2){
													
													   $paytoolarr=$this->GetMysqlOne('name_phpapp'," ".$this->GetTable('pay_tool')." WHERE id_phpapp='$bankid'");
													   
													   $bankname=$paytoolarr['name_phpapp'];
													
												}
												
												//冻结
												
												$lockmoney=$member['lock']+$paymoney;
												
												$nowmoney=$member['money']-$paymoney;
												
												$this->Update('member_account',array('lock'=>$lockmoney,'money'=>$nowmoney),array(),"WHERE uid='$this->uid'");
												
												$newcid=$pay->MakeConsume(array(
																		'subject'=>$this->LanguageArray('apppay','To_cash').$bankname, 
																		'appid'=>$this->app, 
																		'paytype'=>4, 
																		'process'=>1, 
																		'bankcard'=>$certificate['bankcard'], 
																		'amount'=>$paymoney, 
																		'fee'=>floatval(PHPAPP::$config['withdrawfee'])*$paymoney, 
																		'payout'=>$this->uid, 
																		'payin'=>0   // 收入者
																		
												  ));
												
											   
												echo include $this->LanguageArray('apppay','Waiting_for_remittances',1);
												echo $this->CloseNowWindows('#loading',1);
										  
										  
										 }else{
											 
											  //echo '对不起！,您今日已提现'.$withdrawnum.'次，明日再来吧！<br />';
											  echo include $this->LanguageArray('apppay','Number_of_withdrawals',1);
											  echo $this->CloseNowWindows('#loading');
											 
										 }
									 
									 	
								   }else{
										 
										 //echo '对不起！,最大提现金额为'.$withdrawbig.'元！<br />';
										 echo include $this->LanguageArray('apppay','Maximum_cash_withdrawal_amount',1);
					                     echo $this->CloseNowWindows('#loading');
								   }
								  
								  
							 }else{ 
							        //echo '对不起！,您的可用余额不足'.$paymoney.'元不能提现！<br />';
									echo include $this->LanguageArray('apppay','Balance_is_less_than',1);
					                echo $this->CloseNowWindows('#loading');
							 }
							 
						    
					   }else{
						   
						    //echo '对不起！,提现金额不能小'.$withdrawsmall.'元！<br />';
							echo include $this->LanguageArray('apppay','Cash_withdrawal_amount',1);
					        echo $this->CloseNowWindows('#loading');
						   
					   }
					
				}else{
					
			          include $this->Template('withdraw_member');
				}
			   
		  }else{
		
			    $this->Refresh($this->LanguageArray('apppay','You_are_not_realname'),SURL.'/member.php?app=12');
			  
		  }
		  
		
	}
	
	
	
	
	
	
}



?>