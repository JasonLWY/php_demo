<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class PayMainControls extends PHPAPP{
	
    private $POST,$GET;
	
	function __construct(){	


	       parent::__construct();
		   
		   
		   $this->POST=$this->POSTArray();

		 
		   if($this->uid<1){
				 header('location:'.SURL);
		   }
		         
	}
	
	
	function DefaultAction(){
		
          if($this->POST && $this->POST['PayToolID']){
		        $this->GoPayTool($this->POST);
		  }else{
			    header('location:'.SURL);
		  }
	}
	
	
	function UserPay($tname,$paymoney=0.00,$tid=0,$type=0,$props=''){
		  
		   if($this->uid >0){
                 
				 $this->OnLinePay($tname,$paymoney,$tid,$type,$props);  
					
		   }else{
				  header('location:'.SURL);
		   }
   

	}
	
	
	function OnLinePay($taskmoney,$totalservice,$tid,$type=0,$props=''){
            
			$user=$this->GetLoginInfo();
			
			$paymoney=$taskmoney+$totalservice-$user['money'];
			//读取所有支付接口
			$paytoolarr=$this->GetOnLinePay();
  
			include $this->Template('pay:taskpay');

	}
	
	
	function GetOnLinePay(){

		    return $this->GetMysqlArray('*'," ".$this->GetTable('pay_tool')." WHERE status_phpapp='0' ORDER BY displayorder_phpapp ASC");

	}
	
	
	
	
	function GoPayTool($payarr){
	
		//检查支付工具
		$paytoolid=$payarr['PayToolID'];

		if($this->IsSQL('pay_tool',"WHERE id_phpapp='$paytoolid'")){

			 if($payarr['Submit']){
			   
			      include_once(APPS.'/pay/class/pay_class_phpapp.php');

		          $pay=new PayMoney($payarr);
			
			      $pay->SetPayTools();
			
			 }
			
		}else{
			  header('location:'.SURL);
		}
	}
	
}


?>