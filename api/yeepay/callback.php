<?php

    include('../../api.php');

 
	@include_once(APPS.'/yeepay/yeepayCommon.php');
		
	#	ֻ��֧���ɹ�ʱ�ױ�֧���Ż�֪ͨ�̻�.
	##֧���ɹ��ص������Σ�����֪ͨ������֧����������е�p8_Url�ϣ�������ض���;��������Ե�ͨѶ.
	
	#	�������ز���.
	$return = getCallBackValue($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
	
	#	�жϷ���ǩ���Ƿ���ȷ��True/False��
	$bRet = CheckHmac($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
	#	���ϴ���ͱ�������Ҫ�޸�.
	@include_once(APPS.'/pay/class/pay_class_phpapp.php');
	$pay=new PayMoney();		
	#	У������ȷ.
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