<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class CreditPort extends PHPAPP{
	
	public $post;
	
	function __construct($post,$amount=''){	 
	      parent::__construct();
		  $this->post=$post;
		  return $this->CreditAction($amount);  
	}
	
	function CreditAction($amount=''){
	
		  //Get 
		  
          $userinfo=$this->GetLoginInfo($this->post['credit_uid']);
		  $usergroup=$userinfo['usergroup'];
		  
		  $portarr=$this->GetMysqlOne('*'," ".$this->GetTable('apps_credit')." WHERE apps_phpapp='$this->app' AND action_phpapp='$this->ac' AND usergroup_phpapp='$usergroup'");
		  
		  
		  if($amount){
			   $iscreditarr=1;  
		  }else{
			    if(!empty($portarr)){
					 $iscreditarr=1;  
				}else{
					 $iscreditarr=0;  
			    }
		  }
		    
		  
		  if($iscreditarr>0){
			 
				 $uid=$this->post['credit_uid'];
				 //处理
				 $countarr=$this->MysqlFetchArray("SELECT COUNT(*) AS count,FROM_UNIXTIME(dateline,'%e') AS date FROM ".$this->GetTable('member_credit')." WHERE uid='$uid' AND appid='$this->app' AND actionid='$this->ac' AND FROM_UNIXTIME(dateline,'%e')=DAYOFMONTH(NOW()) GROUP BY DAYOFMONTH(NOW())");		
				  
				 $count=empty($countarr[0]['count']) ? 0 : intval($countarr[0]['count']);
				 
				 
				 
				 if($amount){
					 
					   $portarr['credit_phpapp']=$amount;
						  
					   $iscredit=1;  
					   
				 }else{
					   if($count <= $portarr['number_phpapp']){
						     $iscredit=1;
					   }else{
						     $iscredit=0;
					   }
				 }
				 
				
				 if($iscredit>0){
	                   
					   
					   $this->Insert('member_credit',array('uid'=>$this->post['credit_uid'],'dateline'=>$this->NowTime(),'credit'=>$portarr['credit_phpapp'],'appid'=>$this->app,'actionid'=>$this->ac),array());
					  
				
					   $credit=$userinfo['credit']+$portarr['credit_phpapp'];
					   
					   $this->Update('member_account',array('credit'=>$credit),array()," WHERE uid='$uid'");
					   
					   
					   if($portarr['credit_phpapp']>0){
						    $creditname='积分+ ';
					   }else{
						    $creditname='积分 ';
					   }
					   
					   $msg=$creditname.'<strong>'.$portarr['credit_phpapp'].'</strong><br />';
					   
					   if($this->IsWap()){
						    return $msg;
					   }else{
					         echo $msg;
					   }
					  
				 }
		 
			   
		  }
		 
	}
	
	
}


?>