<?php

include('../../api.php');


require_once (APPS.'/tenpay/classes/PayResponseHandler.class.php');

/* ��Կ */
$key = PHPAPP::$config['tenpaykey'];

/* ����֧��Ӧ����� */
$resHandler = new PayResponseHandler();
$resHandler->setKey($key);

@include_once(APPS.'/pay/class/pay_class_phpapp.php');
$pay=new PayMoney();
	
//�ж�ǩ��
if($resHandler->isTenpaySign()) {
	
		//���׵���
		$transaction_id = $resHandler->getParameter("transaction_id");
		
		//���,�Է�Ϊ��λ
		$total_fee = $resHandler->getParameter("total_fee");
		
		//֧�����
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