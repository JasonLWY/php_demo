<?php

include('../../api.php');


require_once (APPS.'/tenpay/classes/PayResponseHandler.class.php');

/* 密钥 */
$key = PHPAPP::$config['tenpaykey'];

/* 创建支付应答对象 */
$resHandler = new PayResponseHandler();
$resHandler->setKey($key);

@include_once(APPS.'/pay/class/pay_class_phpapp.php');
$pay=new PayMoney();
	
//判断签名
if($resHandler->isTenpaySign()) {
	
		//交易单号
		$transaction_id = $resHandler->getParameter("transaction_id");
		
		//金额,以分为单位
		$total_fee = $resHandler->getParameter("total_fee");
		
		//支付结果
		$pay_result = $resHandler->getParameter("pay_result");
	
		if("0"==$pay_result){
	
				$orderid=iconv_substr($transaction_id,10,20,S_CHARSET);
			
				$pay->SetPayMoney($orderid,$total_fee/100,'Tenpay');
				

		}else{
		
			   $pay->PayError();
		}
	
}else{
	  $pay->PayError();
}



?>