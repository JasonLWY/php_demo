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
   

	  //�������
	  $out_trade_no = $this->payorder;		//�������վ����ϵͳ�е�Ψһ������ƥ��
	  $subject      = PHPAPP::$config['paygoodsname'];	//�������ƣ���ʾ��֧��������̨��ġ���Ʒ���ơ����ʾ��֧�����Ľ��׹���ġ���Ʒ���ơ����б��
	  $body         = PHPAPP::$config['paydescription'];	//����������������ϸ��������ע����ʾ��֧��������̨��ġ���Ʒ��������
	  $total_fee    = $this->paymoney;	//�����ܽ���ʾ��֧��������̨��ġ�Ӧ���ܶ��
	  
	  //��չ���ܲ�������������ǰ
	  $pay_mode	  = 'bankPay';
	  $defaultbank =$_POST['alipay_bank_type'];
	  
	  if ($pay_mode == "directPay") {
		  $paymethod    = "directPay";	//Ĭ��֧����ʽ���ĸ�ֵ��ѡ��bankPay(����); cartoon(��ͨ); directPay(���); CASH(����֧��)
		  $defaultbank  = "";
	  }else {
		  $paymethod    = "bankPay";		//Ĭ��֧����ʽ���ĸ�ֵ��ѡ��bankPay(����); cartoon(��ͨ); directPay(���); CASH(����֧��)
		  $defaultbank  = $defaultbank;		//Ĭ���������ţ������б��http://club.alipay.com/read.php?tid=8681379
	  }
	  
	  //��չ���ܲ�������������
	  $encrypt_key  = '';					//������ʱ�������ʼֵ
	  $exter_invoke_ip = '';				//�ͻ��˵�IP��ַ����ʼֵ
	  if($antiphishing == 1){
		  $encrypt_key = query_timestamp($partner);
		  $exter_invoke_ip = '';			//��ȡ�ͻ��˵�IP��ַ�����飺��д��ȡ�ͻ���IP��ַ�ĳ���
	  }
	  
	  //��չ���ܲ�����������
	  $extra_common_param = '';			//�Զ���������ɴ���κ����ݣ���=��&�������ַ��⣩��������ʾ��ҳ����
	  $buyer_email		= '';			//Ĭ�����֧�����˺�
	  
	  //��չ���ܲ�����������(��Ҫʹ�ã��밴��ע��Ҫ��ĸ�ʽ��ֵ)
	  $royalty_type		= "";			//������ͣ���ֵΪ�̶�ֵ��10������Ҫ�޸�
	  $royalty_parameters	= "";
	  //�����Ϣ��������Ҫ����̻���վ���������̬��ȡÿ�ʽ��׵ĸ������տ��˺š��������������˵�������ֻ������10��
	  //����������ܺ���С�ڵ���total_fee
	  //�����Ϣ����ʽΪ���տEmail_1^���1^��ע1|�տEmail_2^���2^��ע2
	  //�磺
	  //royalty_type = "10"
	  //royalty_parameters	= "111@126.com^0.01^����עһ|222@126.com^0.01^����ע��"
	  
	  
	  //��չ���ܲ��������Զ��峬ʱ(��Ҫʹ�ã��밴��ע��Ҫ��ĸ�ʽ��ֵ)
	  //�ù���Ĭ�ϲ���ͨ��
	  //���뿪ͨ��ʽ������0571-88158090������ύ�������루https://b.alipay.com/support/helperApply.htm?action=consultationApply��
	  //��ʱʱ�䣬����Ĭ����15�졣���÷�Χ��1m~15d�� m-���ӣ�h-Сʱ��d-�죬1c-���죨���ۺ�ʱ���������׶���0��رգ�
	  $it_b_pay			= "";
	  
	  /////////////////////////////////////////////////
	  
	  //����Ҫ����Ĳ������飬����Ķ�
	  $parameter = array(
			  "service"			=> 'create_direct_pay_by_user',	//�ӿ����ƣ�����Ҫ�޸�
			  "payment_type"		=> "1",               			//�������ͣ�����Ҫ�޸�
	  
			  //��ȡ�����ļ�(alipay_config.php)�е�ֵ
			  "partner"			=> $partner,
			  "seller_email"		=> $seller_email,
			  "return_url"		=> $return_url,
			  "notify_url"		=> $notify_url,
			  "_input_charset"	=> $_input_charset,
			  "show_url"			=> $show_url,
	  
			  //�Ӷ��������ж�̬��ȡ���ı������
			  "out_trade_no"		=> $out_trade_no,
			  "subject"			=> $subject,
			  "body"				=> $body,
			  "total_fee"			=> $total_fee,
	  
			  //��չ���ܲ�������������ǰ
			  "paymethod"			=> $paymethod,
			  "defaultbank"		=> $defaultbank,
	  
			  //��չ���ܲ�������������
			  "anti_phishing_key"	=> $encrypt_key,
			  "exter_invoke_ip"	=> $exter_invoke_ip,
	  
			  //��չ���ܲ��������Զ������
			  "buyer_email"		=> $buyer_email,
			  "extra_common_param"=> $extra_common_param,
			  
			  //��չ���ܲ�����������
			  "royalty_type"		=> $royalty_type,
			  "royalty_parameters"=> $royalty_parameters,
	  
			  //��չ���ܲ��������Զ��峬ʱ
			  "it_b_pay"			=> $it_b_pay
	  );
	  
	  //����������
	  $alipay = new alipay_service($parameter,$key,$sign_type);
	  $sHtmlText = $alipay->build_form();

	  include $this->Template('alipay:send');



?>


