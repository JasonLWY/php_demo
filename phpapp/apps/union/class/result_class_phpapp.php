<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class UnionResult extends PHPAPP{
	
	public $POST;
	
	function __construct($POST){	
        
		parent::__construct();
		
		$this->POST=empty($POST) ? 0 : $POST;
		
	    $this->UserResult();
	}

	function UserResult(){
		     
			 $uid=$this->POST['uid'];
			 

			 $appid=$this->POST['appid'];
			 
			 
			 $member=$this->GetMysqlOne('unionid,uniontime'," ".$this->GetTable('member')." WHERE uid='$uid'");

			 if(intval($member['unionid'])>0){
			 
			         
					 if(time()<intval($member['uniontime']) || intval($member['uniontime'])==0){
			  
							 //推广员
							 $union=$this->GetMysqlOne('uid,username,usergroup'," ".$this->GetTable('member')." WHERE uid='$member[unionid]'");
							 
							 require_once(APPS.'/apppay/class/consume_class_phpapp.php');
						
							 $pay=new UserConsume();
						
							 if(!empty($this->POST['rebate'])){
								 
										  $money=floatval($this->POST['rebate']);
											
											  
										  $newcid=$pay->MakeConsume(array(
																			  'subject'=>'<p>推广提成</p>'.$this->POST['subject'],
																			  'appid'=>$this->POST['appid'], 
																			  'paytype'=>2, 
																			  'process'=>1, 
																			  'amount'=>$money, 
																			  'number'=>1, 
																			  'payout'=>0, 
																			  'payin'=>$union['uid'] 
												
																	   ));
																  
												
										 $pay->SetSuccessConsume($newcid); 
										 
										 $isport=1;
								 
							 }else{
									
									 $sid=$this->POST['sid'];
			
									 //提成
									 $unionrebate=$this->GetMysqlOne('a.rebate_phpapp'," ".$this->GetTable('union')." AS a JOIN  ".$this->GetTable('prop')." AS b ON a.service_phpapp=b.sid WHERE b.appid='$appid' AND b.usergroup='$union[usergroup]'");
									  
									 if($unionrebate){
										 
										 
											 $money=intval($this->POST['amount']) * floatval($this->POST['price']) * floatval($unionrebate['rebate_phpapp']);
											 
											 if($money>0){
											  
												   $newcid=$pay->MakeConsume(array(
																					'subject'=>'<p>道具推广提成</p>'.$this->POST['subject'],
																					'appid'=>$this->POST['app'], 
																					'paytype'=>2, 
																					'process'=>1, 
																					'amount'=>$money, 
																					'number'=>$this->POST['amount'], 
																					'payout'=>0, 
																					'payin'=>$union['uid'] 
													  
																			 ));
																		
													  
												   $pay->SetSuccessConsume($newcid); 
												   
												   $isport=1;
											 }else{ 
												   $isport=0;
											 }
											 
									 }else{ 
											$isport=0;
									 }
							 }
							 
					 
	             
							 if($isport){
									
				
									   $unionaccount=$this->GetMysqlOne('*'," ".$this->GetTable('member_account')." WHERE uid='$union[uid]'");
									   
									   $unionmoney=$money+$unionaccount['union'];
									   
									   $this->Update('member_account',array('union'=>$unionmoney),array(),"WHERE uid='$union[uid]'");
									   
									
									   if($this->IsSQL('member_union'," WHERE uid='$union[uid]' AND appid='$appid' ")){
												
											   $memberunion=$this->GetMysqlOne('*'," ".$this->GetTable('member_union')." WHERE uid='$union[uid]' AND appid='$appid' ");
											   
											   $money+=$memberunion['money'];
											   
											   $total=$memberunion['total']+1;
												
											   $this->Update('member_union',array('money'=>$money,'total'=>$total),array(),"WHERE uid='$union[uid]' AND appid='$appid' ");
										   
									   }else{
										   
											   $this->Insert('member_union',array('uid'=>$union['uid'],'appid'=>$appid,'money'=>$money,'total'=>1),array());
										   
									   }
												
												
										  
									  $this->Port(array(
																					  
															  //Login
															  'login_uid'=>$union['uid'],
																		  
															  //SMS
															
															  'sms_msggoid'=>$union['uid'], //收件人
															  'sms_msgtoid'=>0,
															  'sms_mailbox'=>'1',
															  'sms_subject'=>'您获得'.$this->POST['subject'].'推广提成',
															  'sms_content'=>$union['username'].'您获得'.$this->POST['subject'].'推广提成 '.$money.' 元',
															
															  //Feed
															  
															  'feed_uid'=>$union['uid'],
															  'feed_username'=>$union['username'],
															  'feed_app'=>$this->POST['app'],
															  'feed_action'=>1,
															  'feed_title_template'=>'获得'.$money.'元{title}',
															  'feed_title_data'=>$this->POST['subject'].'推广提成',
															  'feed_content_template'=>'',
															  'feed_content_data'=>''
																					  
														  
																									
									 ));			
										
								 
							 }
					 
					 }
					 
		
			  
			 }
	
			 
		
	}

		
	
}

?>