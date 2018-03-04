<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(APPS.'/taskgrab/main_phpapp.php');

class TaskGrabAutoControls extends TaskGrabMainControls{
	
	private $runarray;
	
	public $lang;
	
	function __construct($runarray=''){	 
	 
		 $this->runarray=$runarray;
		 
		 $this->lang=empty($_GET['lang']) ? 1 : intval($_GET['lang']);

	}
	
	
	function EndServiceDefaultTop(){
		   
		   $topid=$this->runarray['topid'];
		   $this->Delete('task_grab_top'," WHERE topid='$topid' ");
		   
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
					  'sms_subject'=>'����'.$this->runarray['tid'].'������'.$topname.'�Ƽ������ѹ���!',
					  'sms_content'=>'����'.$this->runarray['tid'].'������'.$topname.'�Ƽ������ѹ���,<a href="index.php?app='.$this->runarray['app'].'&action=5&tid='.$this->runarray['tid'].'" target="_blank">�鿴����</a>',
				 );	

		   
		   $port->SendSMS($smsarr);
		
	}
	
	
	function PayTask(){
		
		  
		  $this->PayTaskOrder($this->runarray['oid']);
		
	}
}

?>