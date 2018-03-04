<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(APPS.'/sellerservice/member_phpapp.php');

class SellerServiceAutoControls extends SellerServiceMemberControls{
	
	private $runarray;
	
	public $lang;
	
	function __construct($runarray=''){	 
	 
		 $this->runarray=$runarray;
		 
		 $this->lang=empty($_GET['lang']) ? 1 : intval($_GET['lang']);

	}
	
	
	function EndPropDefaultTop(){
		   
		   $topid=$this->runarray['topid'];
		   $this->Delete('task_seller_service_top'," WHERE topid='$topid' ");
		   
		   include_once(APPS.'/sms/class/port_class_phpapp.php');
		   
		   $port=new SMSPort();
		   
		   if($this->runarray['top']==1){
			      
				 $topname ='��ҳ';
				 
		   }elseif($this->runarray['top']==2){
			    
				 $topname ='�б�';
		   }
		   
		   
		   $smsarr=array(	  
					  //SMS
					  'sms_msggoid'=>$this->runarray['uid'], //�ռ���
					  'sms_msgtoid'=>0,
					  'sms_mailbox'=>'1',
					  'sms_subject'=>'����'.$this->runarray['tid'].'�ŷ���'.$topname.'�Ƽ������ѹ���!',
					  'sms_content'=>'����'.$this->runarray['tid'].'�ŷ���'.$topname.'�Ƽ������ѹ���,<a href="'.$this->GetServiceURL($this->runarray['tid']).'" target="_blank">�鿴����</a>',
				 );	

		   
		   $port->SendSMS($smsarr);
		
	}
	
	function PayTask(){
		
		  
		  $this->PayTaskOrder($this->runarray['oid']);
		
	}
	
	
}

?>