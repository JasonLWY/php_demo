<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class SMSMainControls extends PHPAPP{
	
    private $POST,$GET,$errors;
	
	public $fuid;
	
	function __construct(){	
	
	       parent::__construct();
			
		   $this->fuid=empty($_GET['fuid']) ? 0 : intval($_GET['fuid']);
            
		   
		   $postkey=array('Submit'=>'');
			
			
		   $this->POST=$this->POSTArray();
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op'));
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
			  
		   }
		   
		   if($this->uid<1){
				    echo '请登录后操作!<br />';
					echo $this->CloseNowWindows('#loading');
					exit();
		   }
		         
	}
	
	
	function DefaultAction(){
		  $this->NowAddSMSAction();
	}
	
	
	function NowAddSMSAction(){
		
		
	      if($this->uid!=$this->fuid){
			  
			      if($this->IsSQL('member',"WHERE uid='$this->fuid'")){
					  
						   $nowaddsms=1;
						   
						   $smsarr['msggoid']=$this->fuid;
						   
						   
						   include $this->AppsView('form_sms');
					  
					  
					  
					  
				  }else{
						   echo '用户不存在!<br />';
						   echo $this->CloseNowWindows('#loading');
				  } 
			  
			  
		  }else{
			  
			    echo '对不起,不能发送给自己!<br />';
				echo $this->CloseNowWindows('#loading');
		  }
		 
	}
	
}




?>