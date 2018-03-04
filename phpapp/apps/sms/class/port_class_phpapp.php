<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class SMSPort extends PHPAPP{
	
	public $post;
	
	function __construct(){	 
	      parent::__construct();
	}
	
	function SendSMS($post){

		 $this->post=$post;
	
		 if($this->post){
			     
			  if(!empty($this->post['sms_msggoid'])){
					 $this->Insert('member_sms',array(
													   'msggoid'=>$this->post['sms_msggoid'], //สีผþศห
													   'msgtoid'=>$this->post['sms_msgtoid'],
													   'mailbox'=>$this->post['sms_mailbox'],
													   'new'=>'1',
													   'subject'=>$this->str($this->post['sms_subject'],200,0,1,1,0,1),
													   'content'=>$this->post['sms_content'],
													   'upid'=>$this->post['sms_upid'],
													   'dateline'=>$this->NowTime()
													   ),
									array());  
					  
					 //UC
				
					 if($uclient=$this->GetClient()){
						 
						   @$uclient->send_sms($this->post['sms_msgtoid'],$this->post['sms_msggoid'],$this->str($this->post['sms_subject'],200,0,1,1,0,1),$this->post['sms_content']);
						   
					 }
		       }
		 }
		  
		
	}
	
}


?>