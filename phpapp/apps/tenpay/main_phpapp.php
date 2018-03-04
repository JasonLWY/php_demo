<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

	if(!defined('IN_PHPAPP')) {
		exit('Data error');
	}

	  
	require_once ("classes/PayRequestHandler.class.php");
	
	/* 商户号 */
	$bargainor_id =PHPAPP::$config['tenpayid'];
	
	/* 密钥 */
	$key = PHPAPP::$config['tenpaykey'];
	
	/* 返回处理地址 */
	$return_url = SURL.'/api/tenpay/callback.php';
	
	$sp_billno=iconv_substr($this->payorder,8,20,S_CHARSET);
	
	/* 财付通交易单号，规则为：10位商户号+8位时间（YYYYmmdd)+10位流水号 */
	$transaction_id = $bargainor_id .$this->payorder;
	
	/* 创建支付请求对象 */
	$reqHandler = new PayRequestHandler();
	$reqHandler->init();
	$reqHandler->setKey($key);
	
	//----------------------------------------
	//设置支付参数
	//----------------------------------------
	$reqHandler->setParameter("bargainor_id", $bargainor_id);			//商户号
	$reqHandler->setParameter("sp_billno", $sp_billno);					//商户订单号
	$reqHandler->setParameter("transaction_id", $transaction_id);		//财付通交易单号
	$reqHandler->setParameter("total_fee", $this->paymoney *100);					//商品总金额,以分为单位
	$reqHandler->setParameter("return_url", $return_url);				//返回处理地址
	$reqHandler->setParameter("desc", $this->paygoodsname);	//商品名称
	$reqHandler->setParameter("bank_type",intval($_POST['bank_type']));	//银行ID
	
	//用户ip,测试环境时不要加这个ip参数，正式环境再加此参数
	$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);
	
	//请求的URL
	$reqUrl = $reqHandler->getRequestURL();
	
	//debug信息
	//$debugInfo = $reqHandler->getDebugInfo();
	
	//echo "<br/>" . $reqUrl . "<br/>";
	//echo "<br/>" . $debugInfo . "<br/>";
	
	//重定向到财付通支付
	$reqHandler->doSend();


?>
