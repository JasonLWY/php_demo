<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class Port extends PHPAPP{
	
	public $post,$allow;
	
	function __construct($post=array(),$allow=array()){	 
	
          parent::__construct();
		  
		  $this->post=$post;
		  
		  $this->allow=$allow;

	}
	
	
	function SetPort(){

		 //system
		 if($this->IsSQL('member_message_type'," WHERE satus=0 AND mid='$this->allow' ")){
			    
				 include_once(Core.'/class/auto_class_phpapp.php');
				   
				 $auto=new AUTO();
				   
				 $runtime=$this->NowTime()+10;
				 
				 $runid=$auto->SetAutoRun(array(
						'app'=>49,
						'runtime'=>$runtime,
						'function'=>'SendMessageCode',
						'zipcode'=>serialize($this->post),
						'allow'=>$this->allow
				 ));
			 
		 }
	
		 //credit
		 if(!empty($this->post['credit_uid'])){
				 include_once(APPS.'/credit/class/port_class_phpapp.php');
				 new CreditPort($this->post);
		 }


	}
	
}


?>