<?php

    include('../../api.php');

 
	@include_once(APPS.'/yeepay/yeepayCommon.php');
		
	#	只有支付成功时易宝支付才会通知商户.
	##支付成功回调有两次，都会通知到在线支付请求参数中的p8_Url上：浏览器重定向;服务器点对点通讯.
	
	#	解析返回参数.
	$return = getCallBackValue($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
	
	#	判断返回签名是否正确（True/False）
	$bRet = CheckHmac($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
	#	以上代码和变量不需要修改.
	@include_once(APPS.'/pay/class/pay_class_phpapp.php');
	$pay=new PayMoney();		
	#	校验码正确.
	if($bRet){
		
		if($r1_Code=="1"){
			
			
			  if($r9_BType=="1"){
	  
				    $pay->SetPayMoney($r6_Order,$r3_Amt/100,'Yeepay');
				  
			  }elseif($r9_BType=="2"){
		  
				    $pay->SetPayMoney($r6_Order,$r3_Amt/100,'Yeepay');
			  }
		}
		
	}else{
		  $pay->PayError();
	}
   
?>