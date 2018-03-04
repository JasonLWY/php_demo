<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


@require_once(Core.'/class/oauth_class_phpapp.php');

@require_once(APPS.'/netease/class/weibooauth.php' );

		  
class NetEaseAPIMainControls extends PHPAPP{
	
    private $POST,$GET,$callback;
	
	function __construct($actionmenu=''){	

		   parent::__construct();
		   
		   $this->POST=$this->POSTArray();
		   
		   $this->callback = SURL.'/index.php?app='.$this->app.'&action=2';
	
	}
	
	
	function DefaultAction(){
		  
		   $this->LoginAPIAction();

	}
	
	
	function LoginAPIAction(){

         $o = new NetWeiboOAuth( PHPAPP::$config['neteaseappkey'] , PHPAPP::$config['neteaseappsecret']);
         $netkeys = $o->getRequestToken();

         $neturl = $o->getAuthorizeURL( $netkeys['oauth_token'] ,true ,$this->callback);

         $_SESSION['163keys'] = $netkeys;

         header("location:$neturl");

	}
	
	function CallbackAction(){
		
		  $o = new NetWeiboOAuth( PHPAPP::$config['neteaseappkey'] , PHPAPP::$config['neteaseappsecret'] , $_SESSION['163keys']['oauth_token'] , $_SESSION['163keys']['oauth_token_secret']  );

          $last_key = $o->getAccessToken(  $_REQUEST['oauth_token'] );
         

          $c = new NetWeiboClient( PHPAPP::$config['neteaseappkey'] , PHPAPP::$config['neteaseappsecret'], $last_key['oauth_token'] , $last_key['oauth_token_secret']  );

          $user = @$this->ConvertArray($c->verify_credentials());
		  
				
		  if($user['name']){
					
			           unset($_SESSION['163keys']);
					   
					   @require_once(APPS.'/member/main_phpapp.php');
					   
					   $weibo=new MemberMainControls();
					   
					   $weibo->LoginWeiBo(array('UserName'=>$user['name'],'EMail'=>$user['email']),$user['name']);
					 

					
		  }else{
			  
			    $this->Refresh('хож╓й╖╟э!',SURL);
		  }
		  
		  
		  
	}
	
	
	
}


?>