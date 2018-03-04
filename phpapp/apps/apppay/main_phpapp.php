<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class AppPayMainControls extends PHPAPP{
	
    private $POST,$GET,$errors;
	
	
	function __construct(){	
	
	        parent::__construct();

		   $postkey=array('Submit'=>'');
			
			
		   $this->POST=$this->POSTArray();

		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
			  
		   }
		         
	}
	
	
	function DefaultAction(){
		 $this->OnLinePayAction();
	}
	
	function OnLinePayAction(){
		
		
		 if($this->POST['PayMoney'] < PHPAPP::$config['pay_small_money']){
			 
			    $this->Refresh(include $this->LanguageArray('apppay','Pay_is_too_low',1),'member.php?app=5&action=2');
			 
		 }else{
		 
			   include_once(APPS.'/pay/main_phpapp.php');
	  
			   $pay=new PayMainControls();
								   
			   $pay->GoPayTool($this->POST);
			   
		 }

	}
	
}




?>