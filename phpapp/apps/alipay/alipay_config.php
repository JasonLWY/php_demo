<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	
if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


//���������ID����2088��ͷ��16λ������
$partner		= PHPAPP::$config['alipayid'];

//��ȫ�����룬�����ֺ���ĸ��ɵ�32λ�ַ�
$key			= PHPAPP::$config['alipaykey'];

//ǩԼ֧�����˺Ż�����֧�����ʻ�
$seller_email	= PHPAPP::$config['alipaymail'];

//���׹����з�����֪ͨ��ҳ�� Ҫ�� http://��ʽ������·�����������?id=123�����Զ������
$notify_url		= SURL.'/api/alipay/notify_url.php';

//��������ת��ҳ�� Ҫ�� http://��ʽ������·�����������?id=123�����Զ������
$return_url		= SURL.'/api/alipay/return_url.php';

//��վ��Ʒ��չʾ��ַ���������?id=123�����Զ������
$show_url		= SURL;

//�տ���ƣ��磺��˾���ơ���վ���ơ��տ���������
$mainname		= PHPAPP::$config['sitename'];


//ǩ����ʽ �����޸�
$sign_type		= "MD5";

//�ַ������ʽ Ŀǰ֧�� GBK �� utf-8
$_input_charset	= S_CHARSET;

//����ģʽ,�����Լ��ķ������Ƿ�֧��ssl���ʣ���֧����ѡ��https������֧����ѡ��http
$transport		= "http";

//�����㹦�ܿ��أ�'0'��ʾ�ù��ܹرգ�'1'��ʾ�ù��ܿ�����Ĭ��Ϊ�ر�
$antiphishing	= "0";
//һ�����������޷��رգ������̼�������վ���������ѡ���Ƿ�����
//���������㹦�ܺ󣬷��������������Ա���֧��Զ��XML�����������úøû�����
//��Ҫʹ�÷����㹦�ܣ�����ʹ��POST��ʽ�������ݣ������class�ļ�����alipay_function.php�ļ����ҵ����ļ����·���query_timestamp����

?>