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

@require_once(APPS.'/sohu/class/SohuOAuth.php' );

		  
class SohuAPIMainControls extends PHPAPP{
	
    private $POST,$GET,$callback;
	
	function __construct($actionmenu=''){	

		   parent::__construct();
		   
		   $this->POST=$this->POSTArray();
		   
		   $this->callback = SURL.'/api/sohu/callback.php?app='.$this->app;
	
	}
	
	
	function DefaultAction(){
		  
		   $this->LoginAPIAction();

	}
	
	
	function LoginAPIAction(){

			$oauth = new SohuOAuth(PHPAPP::$config['sohuappkey'],PHPAPP::$config['sohuappsecret']);
   
			$request_token = $oauth->getRequestToken($this->callback);
  
			$_SESSION['sohukeys'] = $request_token;
   
			$sohuurl = $oauth->getAuthorizeUrl1($request_token['oauth_token'],$this->callback);
  
			header("location:$sohuurl");

	}
	
	function CallbackAction(){
	
		  $sohu_oauth = new SohuOAuth(PHPAPP::$config['sohuappkey'],PHPAPP::$config['sohuappsecret'],$_SESSION['sohukeys']['oauth_token'] , $_SESSION['sohukeys']['oauth_token_secret']);

          $last_key = $sohu_oauth->getAccessToken($_REQUEST['oauth_token']);
         
		  $c = new SohuOAuthToken(PHPAPP::$config['sohuappkey'],PHPAPP::$config['sohuappsecret'], $last_key['oauth_token'] , $last_key['oauth_token_secret']  );

          $user = @$this->ConvertArray($c->verify_credentials());
		  
		  if(!empty($user->screen_name)){
					
                       unset($_SESSION['sohukeys']);
					   
					   @require_once(APPS.'/member/main_phpapp.php');
					   
					   $weibo=new MemberMainControls();
					   
					   $weibo->LoginWeiBo(array('UserName'=>$user->screen_name,'EMail'=>''),$user->screen_name);
					 

					
		  }else{
			  
			    $this->Refresh('хож╓й╖╟э!',SURL);
		  }
		
		  
		  
	}
	
	
	
}


?>