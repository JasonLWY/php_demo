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
				
				  //��֤�ɹ�
				  $dingdan           = $_POST['out_trade_no'];	    //��ȡ֧�������ݹ����Ķ�����
				  $total             = $_POST['total_fee'];			//��ȡ֧�������ݹ������ܼ۸�
						
				  if($_POST['trade_status'] == 'TRADE_FINISHED' ) {    
	
								
						  $pay->SetPayMoney($dingdan,$total,'AlipayTrade');

				  }else { 
				          $pay->PayError();
			  
				  }
			
			}else {
				   
				    $pay->PayError();
				
			}
?>