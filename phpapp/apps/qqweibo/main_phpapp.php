<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


@require_once(APPS.'/qqweibo/class/Tencent.php');

		  
class QQWeiBoAPIMainControls extends PHPAPP{
	
    private $POST,$GET,$callback;
	
	function __construct($actionmenu=''){	

		   parent::__construct();
		   
		   $this->POST=$this->POSTArray();

		   $this->callback = SURL.'/index.php?app='.$this->app.'&action=2';

		   OAuth::init(PHPAPP::$config['qqweiboappkey'],PHPAPP::$config['qqweiboappsecret']);
	
	}
	
	
	function DefaultAction(){
		  
		   $this->LoginAPIAction();

	}
	
	
	function LoginAPIAction(){

	     $url = OAuth::getAuthorizeURL($this->callback);
		 
         header("location:$url");

	}
	
	function CallbackAction(){
		  
		  if ($_SESSION['t_access_token'] || ($_SESSION['t_openid'] && $_SESSION['t_openkey'])) {//已授权
		  
		        $user = json_decode(Tencent::api('user/info'),true);

				$user =$this->ConvertArray($user['data']);
				
				if($user){  

					   @require_once(APPS.'/member/main_phpapp.php');
					   
					   $weibo=new MemberMainControls();
					   
					   $weibo->LoginWeiBo(array('UserName'=>$user['name'],'EMail'=>$user['email']),$user['name'],$user['fansnum']);
				
					
				}
				
				
		  }else{
			  
				 if($_GET['code']) {//已获得code
						$code = $_GET['code'];
						$openid = $_GET['openid'];
						$openkey = $_GET['openkey'];
						//获取授权token
						$url = OAuth::getAccessToken($code,$this->callback);
						$r = Http::request($url);
						parse_str($r, $out);
						//存储授权数据
						if ($out['access_token']) {
							$_SESSION['t_access_token'] = $out['access_token'];
							$_SESSION['t_refresh_token'] = $out['refresh_token'];
							$_SESSION['t_expire_in'] = $out['expire_in'];
							$_SESSION['t_code'] = $code;
							$_SESSION['t_openid'] = $openid;
							$_SESSION['t_openkey'] = $openkey;
							
							//验证授权
							$r = OAuth::checkOAuthValid();
							if($r){
								  header('Location: '.$this->callback);
							}else{
								  $this->Refresh('认证失败!',SURL);
							}
						}else{
							   $this->Refresh('认证失败!',SURL);
						}
				}else{
					  $this->LoginAPIAction();
				}
				
		  }
		  
		  
		  
	}
	
	
	
}


?>