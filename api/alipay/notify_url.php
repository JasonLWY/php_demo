<?php


            include('../../api.php');

            $app=empty($_GET['app']) ? 0 : intval($_GET['app']);
		    $lang=empty($_GET['lang']) ? 1 : intval($_GET['lang']);
	
			@require_once(APPS.'/alipay/alipay_config.php');

            @require_once(APPS.'/alipay/class/alipay_notify.php');
			
	        @$alipay = new alipay_notify($partner,$key,$sign_type,$_input_charset,$transport);  
			@$verify_result = $alipay->notify_verify();  
			
			@include_once(APPS.'/pay/class/pay_class_phpapp.php');
			$pay=new PayMoney();
	
			if($verify_result){
				
				  //��֤�ɹ�
				  $dingdan           = $_POST['out_trade_no'];	    //��ȡ֧�������ݹ����Ķ�����
				  $total             = $_POST['total_fee'];			//��ȡ֧�������ݹ������ܼ۸�
						
				  if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {    
	
								
						  $pay->SetPayMoney($dingdan,$total,'Alipay');

				  }else { 
				          $pay->PayError();
			  
				  }
			
			}else {
				   
				    $pay->PayError();
				
			}
?>