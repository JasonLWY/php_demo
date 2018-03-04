<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


//UC配置参数

//应用的UCenter配置信息(可以到UCenter后台->应用管理->查看本应用->复制里面对应的配置信息进行替换)
define('UC_CONNECT',PHPAPP::$config['uc_linktype']); // 连接 UCenter 的方式: mysql/NULL, 默认为空时为 fscoketopen(), mysql 是直接连接的数据库, 为了效率, 建议采用 mysql
define('UC_DBHOST', PHPAPP::$config['uc_dbhost']); // UCenter 数据库主机
define('UC_DBUSER', PHPAPP::$config['uc_dbuser']); // UCenter 数据库用户名
define('UC_DBPW', PHPAPP::$config['uc_dbpw']); // UCenter 数据库密码
define('UC_DBNAME', PHPAPP::$config['uc_dbname']); // UCenter 数据库名称
define('UC_DBCHARSET',PHPAPP::$config['uc_dbcharset']); // UCenter 数据库字符集
define('UC_DBTABLEPRE', '`'.PHPAPP::$config['uc_dbname'].'`.'.PHPAPP::$config['uc_dbpre']); // UCenter 数据库表前缀
define('UC_DBCONNECT',DB_CONNECT); // UCenter 数据库持久连接 0=关闭, 1=打开
define('UC_KEY', PHPAPP::$config['uc_key']); // 与 UCenter 的通信密钥, 要与 UCenter 保持一致
define('UC_API', PHPAPP::$config['uc_api']); // UCenter 的 URL 地址, 在调用头像时依赖此常量
define('UC_CHARSET', PHPAPP::$config['uc_charset']); // UCenter 的字符集
define('UC_IP', PHPAPP::$config['uc_ip']); // UCenter 的 IP, 当 UC_CONNECT 为非 mysql 方式时, 并且当前应用服务器解析域名有问题时, 请设置此值
define('UC_APPID', PHPAPP::$config['uc_appid']); // 当前应用的 ID
define('UC_PPP', 20);

@include_once(APPS.'/ucclient/uc_client/client.php');


class UserClientAPI extends PHPAPP{
	
	   public $username;  
	
       public $password; 
   
       public $usermail;  
	   
	   public $db;
	  
	   function __construct($username='',$password='',$usermail=''){
		   $this->username=$username;
		   $this->password=$password;
		   $this->usermail=$usermail;  
		   
		   error_reporting('E_ALL ^ E_NOTICE');
	   }
	
	   function register(){   
		   return uc_user_register($this->username,$this->password,$this->usermail);         
	   }
	   
	   function get_user($userid='',$type=0){ 
	        return  uc_get_user($userid,$type);
	   }
	   
	   function checkename(){   
		   return uc_user_checkname($this->username);         
	   }
	   
	   function checkemail(){
	       return uc_user_checkemail($this->usermail);
	   }
	
	   function logout(){
	       return uc_user_synlogout();
	   }
	   
	   function user_login($isuid=0){
	       $APIuser=array();
	       list($APIuser['uid'], $APIuser['name'], $APIuser['password'],$APIuser['email']) = uc_user_login($this->username,$this->password,$isuid);
	       return $APIuser;
	   }
	   
	   function login($userid){
	       return uc_user_synlogin($userid);
	   }
	   
	   
	   function user_delete($username=''){
		   
		    return uc_user_delete($username);
		   
	   }
	   
	   function getavatar($userid,$type){
		   
		   if($type==2){
			    $avatar='<img src="'.UC_API.'/avatar.php?uid='.$userid.'&type=virtual&size=big" />';
		   }elseif($type==1){
		        $avatar='<img src="'.UC_API.'/avatar.php?uid='.$userid.'&type=virtual&size=middle" />';
		   }else{
			    $avatar='<img src="'.UC_API.'/avatar.php?uid='.$userid.'&type=virtual&size=small" />';
		   }
		   
		   return $avatar;
		   
	   }
	   
	   function avatar($userid){
	       return uc_avatar($userid,'virtual',1);
	   }
	   
	   function credit_exchange_request($uid,$creditsrc,$tocredits, $toappid, $netamount){
	        return uc_credit_exchange_request($uid,$creditsrc,$tocredits, $toappid, $netamount);
	   }
     
       function user_edit($newpassword='',$ignoreoldpw=0){ 
		    return @uc_user_edit($this->username,$this->password,$newpassword,$this->usermail,$ignoreoldpw);
       }
	   
	   function feed_add($feed){
	        return uc_feed_add($feed['icon'],$feed['uid'],$feed['username'], $feed['title_template'], $feed['title_data'], $feed['body_template'], $feed['body_data'], '', '', $feed['images']);
	   }
      
	  
	   function send_sms($fromuid=0,$msgto=0,$subject='',$message=''){
	        return  uc_pm_send($fromuid,$msgto,$subject,$message);
	   }
	   
	   
	   function get_creditsettings(){
		   
		    if(file_exists(APPS.'/ucclient/uc_client/data/cache/creditsettings.php')){
	             @include_once(APPS.'/ucclient/uc_client/data/cache/creditsettings.php');
			     return $_CACHE['creditsettings'];
		    }
	   }

}
	
	



?>