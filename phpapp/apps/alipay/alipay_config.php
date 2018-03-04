<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	
if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


//合作身份者ID，以2088开头的16位纯数字
$partner		= PHPAPP::$config['alipayid'];

//安全检验码，以数字和字母组成的32位字符
$key			= PHPAPP::$config['alipaykey'];

//签约支付宝账号或卖家支付宝帐户
$seller_email	= PHPAPP::$config['alipaymail'];

//交易过程中服务器通知的页面 要用 http://格式的完整路径，不允许加?id=123这类自定义参数
$notify_url		= SURL.'/api/alipay/notify_url.php';

//付完款后跳转的页面 要用 http://格式的完整路径，不允许加?id=123这类自定义参数
$return_url		= SURL.'/api/alipay/return_url.php';

//网站商品的展示地址，不允许加?id=123这类自定义参数
$show_url		= SURL;

//收款方名称，如：公司名称、网站名称、收款人姓名等
$mainname		= PHPAPP::$config['sitename'];


//签名方式 不需修改
$sign_type		= "MD5";

//字符编码格式 目前支持 GBK 或 utf-8
$_input_charset	= S_CHARSET;

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$transport		= "http";

//防钓鱼功能开关，'0'表示该功能关闭，'1'表示该功能开启。默认为关闭
$antiphishing	= "0";
//一旦开启，就无法关闭，根据商家自身网站情况请慎重选择是否开启。
//开启防钓鱼功能后，服务器、本机电脑必须支持远程XML解析，请配置好该环境。
//若要使用防钓鱼功能，建议使用POST方式请求数据，且请打开class文件夹中alipay_function.php文件，找到该文件最下方的query_timestamp函数

?>