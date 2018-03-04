<?php


            include('../../api.php');

            $app=empty($_GET['app']) ? 0 : intval($_GET['app']);
		    $lang=empty($_GET['lang']) ? 1 : intval($_GET['lang']);
	
			@require_once(APPS.'/alipaytrade/alipay_config.php');

            @require_once(APPS.'/alipaytrade/class/alipay_notify.class.php');
			
	        $alipayNotify = new AlipayNotify($aliapy_config);
            $verify_result = $alipayNotify->verifyNotify();
			
			@include_once(APPS.'/pay/class/pay_class_phpapp.php');
			$pay=new PayMoney();
						
			if($verify_result){
				
				  //验证成功
				  $dingdan           = $_POST['out_trade_no'];	    //获取支付宝传递过来的订单号
				  $total             = $_POST['total_fee'];			//获取支付宝传递过来的总价格
						
				  if($_POST['trade_status'] == 'TRADE_FINISHED' ) {    
	
								
						  $pay->SetPayMoney($dingdan,$total,'AlipayTrade');

				  }else { 
				          $pay->PayError();
			  
				  }
			
			}else {
				   
				    $pay->PayError();
				
			}
?>