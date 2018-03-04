<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

require_once(APPS.'/qq/comm/config.php');
require_once(CLASS_PATH."QC.class.php");
		  
class QQAPIMainControls extends PHPAPP{
	
    private $POST,$GET,$callback;
	
	function __construct(){	

           parent::__construct();
		   
		   $this->POST=$this->POSTArray();

		   $this->callback = SURL.'/index.php?app='.$this->app.'&action=2';
	
	}
	
	
	function DefaultAction(){
		  
		   $this->LoginAPIAction();

	}
	
	
	function LoginAPIAction(){
		
		  if(!file_exists(APPS.'/qq/comm/inc.php')){
			  
			      $config='{"appid":"'.PHPAPP::$config['qqappkey'].'","appkey":"'.PHPAPP::$config['qqappsecret'].'","callback":"'.urlencode($this->callback).'","scope":"get_user_info","errorReport":true,"storageType":"file"}';
                  $this->WriteFile(APPS.'/qq/comm/inc.php',$config);
	      }
		  
          $qc = new QC();
          $qc->qq_login();
	}
	
	function CallbackAction(){

		  $qc = new QC();
		  $qcc = new QC($qc->qq_callback(),$qc->get_openid());
          $arr = $qcc->get_user_info();

		  $user = $this->ConvertArray($arr);

		  if($user){
					  
					   @require_once(APPS.'/member/main_phpapp.php');
					   
					   $weibo=new MemberMainControls();
					   
					   $weibo->LoginWeiBo(array('UserName'=>$user['nickname'],'EMail'=>''),$user['nickname']);

					
		  }else{
			  
			    $this->Refresh('хож╓й╖╟э!',SURL);
		  }
		  
		  
		  
	}

	
}


?>