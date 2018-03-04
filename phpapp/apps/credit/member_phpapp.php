<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class CreditMemberControls extends PHPAPP{
	
    public $POST,$GET;
	
	function __construct($uid=0){	 
	 
		 
		 parent::__construct();
		 
		 
		 $this->POST=$this->POSTArray();
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','sort'));
         
		 if($uid>0){
			  $this->uid=$uid;
		 }
		 
		 if($this->uid<1){
			 
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
		 
	}
	
	
	public function DefaultAction(){
		
		  return $this->NowCreditAction();
		
	}
	
	
	public function NowCreditAction(){
		   
		   include_once(APPS.'/member/main_phpapp.php');
		   						
		   $user=$this->GetLoginInfo($this->uid,1);			
		  
		   if($this->GET['op']==1){
			   
			      $uclient=$this->GetClient($this->uid,$this->POST['Password']);
			      if($uclient){
					  
						$login=$uclient->user_login(1);
						
						$amount=intval($this->POST['amount']);

									
						if($login['uid'] <= 0) {
							  echo '<p>您输入的密码有误!或兑换目标网站没有激活帐号!</p>';
						}elseif($user['credit'] -$amount < 0) {
							  echo '<p>对不起，您的积分余额不足 '.$amount.'，兑换失败!</p>';
						}elseif($amount <= 0) {
			                  echo '<p>您要兑换的积分数量输入有误!</p>';
		                }else{
							  
							  $creditsettings=$uclient->get_creditsettings();
							  
							  $tocredits=$this->POST['tocredits'];
							  
							  $creditset=$creditsettings[$tocredits];
                              
							  $uccreditid=0;
							  
							  foreach($creditset['ratiosrc'] as $key=>$value){
								     
									 if($value){
								          $ratiosrc=$value;
										  $uccreditid=intval($key);
									 }
							  }
							  
							  foreach($creditset['ratiodesc'] as $value){
								  
								     $ratiodesc=$value;
							  }

                              foreach($creditset['creditsrc'] as $value){
								  
								     $creditsrc=$value;
							  }
						

                              $newamount = floor($amount * $ratiodesc/$ratiosrc);
							  	

							  list($toappid, $tocredits) = explode('|', $tocredits);
							  //if($uclient->credit_exchange_request($this->uid,$creditsrc,$tocredits, $toappid,$newamount)){
							  if($uclient->credit_exchange_request($this->uid,$uccreditid,$tocredits, $toappid,$newamount)){
								   
								    $nowcredit=$user['credit'] -$amount;
								    
								    $this->Update('member_account',array('credit'=>$nowcredit),array()," WHERE uid='$this->uid'");
									
									$this->Insert('member_credit',array('uid'=>$this->uid,'dateline'=>$this->NowTime(),'appid'=>4,'actionid'=>1,'credit'=>-$amount),array());
									
								    echo '<p>兑换成功!</p>';
	
							  }else{
								    echo '<p>兑换失败!</p>';
							  }
							
						}
						
					
						echo $this->CloseNowWindows('#loading',1);
						
				  }
				 

		   }else{
			     
				 $uclient=$this->GetClient();
				 
				 if($uclient){
	                   $creditsettings=$uclient->get_creditsettings();
				 }
		  
		         include $this->Template('nowcredit_member');
		   }
		
	}
	
	
	
	
	
	public function LogCreditAction(){
		
			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		         

				 $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=2',"SELECT * FROM ".$this->GetTable('member_credit')." WHERE 	uid='$this->uid' ORDER BY dateline DESC");
				   
				   
				 $list=$page->ShowResult();
	  
	  
				 include $this->Template('logcredit_member');
		
	}
	
	
	public function RuleCreditAction(){
		
		    include_once(Core.'/class/pages_class_phpapp.php');
		    
			$user=$this->GetLoginInfo($this->uid);
			$usergroup=$user['usergroup'];

		    $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=3',"SELECT * FROM ".$this->GetTable('apps_credit')." WHERE usergroup_phpapp='$usergroup' ");
				   
				   
		   $list=$page->ShowResult();
	  
		   
		   
		   include $this->Template('rulecredit_member');
		
		
	}
	
	
	public function GetUserCredit($uid=0){
		
		   if(!$uid){
			    $uid=$this->uid;   
		   }
		   
		   $memberarr=$this->GetMysqlOne('credit'," ".$this->GetTable('member_account')." WHERE uid='$uid'");
		   
		   if(!empty($memberarr['credit'])){
			     
				 return intval($memberarr['credit']);
			   
		   }else{
			    
				 return 0;
			   
		   }
		   
	}
		
	
	public function UpdateUserCredit($amount,$uid=0){
		   
		   if(!$uid){
			    $uid=$this->uid;   
		   }

		   if($amount){
			   
				 $membercredit=$this->GetUserCredit($uid);
				 
				 if($amount>0){
				       
					   $nowcredit=$membercredit+$amount;
					   
				       $this->Update('member_account',array('credit'=>$nowcredit),array()," WHERE uid='$uid'");
					   
					   $this->Insert('member_credit',array('uid'=>$uid,'dateline'=>$this->NowTime(),'appid'=>4,'actionid'=>1,'credit'=>$amount),array());
				 
				 }
		   
		   }
		
	}
		
}

?>