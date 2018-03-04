<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

			
		 
	  $lang=empty($_GET['lang']) ? 0 : intval($_GET['lang']);
   
	  require_once('alipay_config.php');

	  require_once('class/alipay_service.php');
   

	  //必填参数
	  $out_trade_no = $this->payorder;		//请与贵网站订单系统中的唯一订单号匹配
	  $subject      = PHPAPP::$config['paygoodsname'];	//订单名称，显示在支付宝收银台里的“商品名称”里，显示在支付宝的交易管理的“商品名称”的列表里。
	  $body         = PHPAPP::$config['paydescription'];	//订单描述、订单详细、订单备注，显示在支付宝收银台里的“商品描述”里
	  $total_fee    = $this->paymoney;	//订单总金额，显示在支付宝收银台里的“应付总额”里
	  
	  //扩展功能参数——网银提前
	  $pay_mode	  = 'bankPay';
	  $defaultbank =$_POST['alipay_bank_type'];
	  
	  if ($pay_mode == "directPay") {
		  $paymethod    = "directPay";	//默认支付方式，四个值可选：bankPay(网银); cartoon(卡通); directPay(余额); CASH(网点支付)
		  $defaultbank  = "";
	  }else {
		  $paymethod    = "bankPay";		//默认支付方式，四个值可选：bankPay(网银); cartoon(卡通); directPay(余额); CASH(网点支付)
		  $defaultbank  = $defaultbank;		//默认网银代号，代号列表见http://club.alipay.com/read.php?tid=8681379
	  }
	  
	  //扩展功能参数——防钓鱼
	  $encrypt_key  = '';					//防钓鱼时间戳，初始值
	  $exter_invoke_ip = '';				//客户端的IP地址，初始值
	  if($antiphishing == 1){
		  $encrypt_key = query_timestamp($partner);
		  $exter_invoke_ip = '';			//获取客户端的IP地址，建议：编写获取客户端IP地址的程序
	  }
	  
	  //扩展功能参数——其他
	  $extra_common_param = '';			//自定义参数，可存放任何内容（除=、&等特殊字符外），不会显示在页面上
	  $buyer_email		= '';			//默认买家支付宝账号
	  
	  //扩展功能参数——分润(若要使用，请按照注释要求的格式赋值)
	  $royalty_type		= "";			//提成类型，该值为固定值：10，不需要修改
	  $royalty_parameters	= "";
	  //提成信息集，与需要结合商户网站自身情况动态获取每笔交易的各分润收款账号、各分润金额、各分润说明。最多只能设置10条
	  //各分润金额的总和须小于等于total_fee
	  //提成信息集格式为：收款方Email_1^金额1^备注1|收款方Email_2^金额2^备注2
	  //如：
	  //royalty_type = "10"
	  //royalty_parameters	= "111@126.com^0.01^分润备注一|222@126.com^0.01^分润备注二"
	  
	  
	  //扩展功能参数——自定义超时(若要使用，请按照注释要求的格式赋值)
	  //该功能默认不开通，
	  //申请开通方式：拨打0571-88158090申请或提交集成申请（https://b.alipay.com/support/helperApply.htm?action=consultationApply）
	  //超时时间，不填默认是15天。设置范围：1m~15d。 m-分钟，h-小时，d-天，1c-当天（无论何时创建，交易都在0点关闭）
	  $it_b_pay			= "";
	  
	  /////////////////////////////////////////////////
	  
	  //构造要请求的参数数组，无需改动
	  $parameter = array(
			  "service"			=> 'create_direct_pay_by_user',	//接口名称，不需要修改
			  "payment_type"		=> "1",               			//交易类型，不需要修改
	  
			  //获取配置文件(alipay_config.php)中的值
			  "partner"			=> $partner,
			  "seller_email"		=> $seller_email,
			  "return_url"		=> $return_url,
			  "notify_url"		=> $notify_url,
			  "_input_charset"	=> $_input_charset,
			  "show_url"			=> $show_url,
	  
			  //从订单数据中动态获取到的必填参数
			  "out_trade_no"		=> $out_trade_no,
			  "subject"			=> $subject,
			  "body"				=> $body,
			  "total_fee"			=> $total_fee,
	  
			  //扩展功能参数——网银提前
			  "paymethod"			=> $paymethod,
			  "defaultbank"		=> $defaultbank,
	  
			  //扩展功能参数——防钓鱼
			  "anti_phishing_key"	=> $encrypt_key,
			  "exter_invoke_ip"	=> $exter_invoke_ip,
	  
			  //扩展功能参数——自定义参数
			  "buyer_email"		=> $buyer_email,
			  "extra_common_param"=> $extra_common_param,
			  
			  //扩展功能参数——分润
			  "royalty_type"		=> $royalty_type,
			  "royalty_parameters"=> $royalty_parameters,
	  
			  //扩展功能参数——自定义超时
			  "it_b_pay"			=> $it_b_pay
	  );
	  
	  //构造请求函数
	  $alipay = new alipay_service($parameter,$key,$sign_type);
	  $sHtmlText = $alipay->build_form();

	  include $this->Template('alipay:send');



?>


