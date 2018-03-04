<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
	UTF8 版本
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


@require_once(APPS.'/sina/class/saetv2.ex.class.php');

		  
class SinaAPIMainControls extends PHPAPP{
	
    private $POST,$GET;
	
	public $callback;
	
	function __construct($actionmenu=''){	
           
		   parent::__construct();
		   
		   $this->POST=$this->POSTArray();
		   
		   $this->callback = SURL.'/index.php?app='.$this->app.'&action=2';
	
	}
	
	
	function DefaultAction(){
		  
		   $this->LoginAPIAction();

	}
	
	
	function LoginAPIAction(){

		  $o = new SaeTOAuthV2( PHPAPP::$config['sinaappkey'] , PHPAPP::$config['sinaappsecret'] );

          $sinaurl = $o->getAuthorizeURL($this->callback);

		  header("location:$sinaurl");

	}
	
	function CallbackAction(){
		
		  $o = new SaeTOAuthV2( PHPAPP::$config['sinaappkey'] , PHPAPP::$config['sinaappsecret'] );

		  if(isset($_REQUEST['code'])) {
				$keys = array();
				$keys['code'] = $_REQUEST['code'];
				$keys['redirect_uri'] = $this->callback;
				try {
					$token = $o->getAccessToken( 'code', $keys ) ;
				} catch (OAuthException $e) {
				}
		  }
		  
		  if ($token) {
			  
			    //$_SESSION['weibotoken'] = $token;
			    //setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
				
				$c = new SaeTClientV2( PHPAPP::$config['sinaappkey'] , PHPAPP::$config['sinaappsecret'],$token['access_token'] );
				$uid_get = $c->get_uid();
				$user = $this->ConvertArray($c->show_user_by_id( $uid_get['uid']));
			   
				if(!empty($user['name'])){
				  
					   unset($_SESSION['SinaKeys']);
					   
					   @require_once(APPS.'/member/main_phpapp.php');
							 
					   $weibo=new MemberMainControls();
	  
					   $weibo->LoginWeiBo(array('UserName'=>$user['name'],'EMail'=>empty($user['email']) ? '' : $user['email']),$user['name'],$user['followers_count']);
	  
				   
				}else{
					
					   $this->Refresh('认证失败!',SURL);
					
				} 
				
		  }else{
			  
				 $this->Refresh('认证失败!',SURL);
			  
		  } 
		  
	}
	
	
	
}


?>