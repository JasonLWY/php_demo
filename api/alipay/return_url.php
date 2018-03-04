<?php


            include('../../api.php');

            $app=empty($_GET['app']) ? 0 : intval($_GET['app']);
		    $lang=empty($_GET['lang']) ? 1 : intval($_GET['lang']);
	
			@require_once(APPS.'/alipay/alipay_config.php');

            @require_once(APPS.'/alipay/class/alipay_notify.php');
			
	        @$alipay = new alipay_notify($partner,$key,$sign_type,$_input_charset,$transport);  
			
			@$verify_result = $alipay->return_verify();  
			
			@include_once(APPS.'/pay/class/pay_class_phpapp.php');
			$pay=new PayMoney();
						
			
			if($verify_result){
				
				  $dingdan = $_GET['out_trade_no'];	//获取订单号
				  $trade_no	= $_GET['trade_no'];	//获取支付宝交易号
				  $total = $_GET['total_fee'];	//获取总价格
				  
						
				  if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
	
								
						  $pay->SetPayMoney($dingdan,$total,'Alipay');

				  }else { 
				          $pay->PayError();
			  
				  }
			
			}else {
				   
				    $pay->PayError();
				
			}
?>