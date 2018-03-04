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
	
	/* �̻��� */
	$bargainor_id =PHPAPP::$config['tenpayid'];
	
	/* ��Կ */
	$key = PHPAPP::$config['tenpaykey'];
	
	/* ���ش����ַ */
	$return_url = SURL.'/api/tenpay/callback.php';
	
	$sp_billno=iconv_substr($this->payorder,8,20,S_CHARSET);
	
	/* �Ƹ�ͨ���׵��ţ�����Ϊ��10λ�̻���+8λʱ�䣨YYYYmmdd)+10λ��ˮ�� */
	$transaction_id = $bargainor_id .$this->payorder;
	
	/* ����֧��������� */
	$reqHandler = new PayRequestHandler();
	$reqHandler->init();
	$reqHandler->setKey($key);
	
	//----------------------------------------
	//����֧������
	//----------------------------------------
	$reqHandler->setParameter("bargainor_id", $bargainor_id);			//�̻���
	$reqHandler->setParameter("sp_billno", $sp_billno);					//�̻�������
	$reqHandler->setParameter("transaction_id", $transaction_id);		//�Ƹ�ͨ���׵���
	$reqHandler->setParameter("total_fee", $this->paymoney *100);					//��Ʒ�ܽ��,�Է�Ϊ��λ
	$reqHandler->setParameter("return_url", $return_url);				//���ش����ַ
	$reqHandler->setParameter("desc", $this->paygoodsname);	//��Ʒ����
	$reqHandler->setParameter("bank_type",intval($_POST['bank_type']));	//����ID
	
	//�û�ip,���Ի���ʱ��Ҫ�����ip��������ʽ�����ټӴ˲���
	$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);
	
	//�����URL
	$reqUrl = $reqHandler->getRequestURL();
	
	//debug��Ϣ
	//$debugInfo = $reqHandler->getDebugInfo();
	
	//echo "<br/>" . $reqUrl . "<br/>";
	//echo "<br/>" . $debugInfo . "<br/>";
	
	//�ض��򵽲Ƹ�֧ͨ��
	$reqHandler->doSend();


?>
