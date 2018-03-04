<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

		  
class TaoBaoAPIMainControls extends PHPAPP{
	
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
		  

         $timestamp=@date("Y-m-d H:i:s",time());
		 
		 $sianmake=array('app_key'=>PHPAPP::$config['taobaoappkey'],'target'=>1,'timestamp'=>$timestamp,'sign_method'=>'md5');
		 
         $taovalue=$this->taobaosign($sianmake);
		
		 $taobaourl='http://container.api.taobao.com/container/identify'; 
	
         $taobaourl.=$taovalue['url'].'&sign='.$taovalue['sign'];

		 header("location:$taobaourl");

	}
	
	function CallbackAction(){
		  
		  if($_GET['notify_result']=='success'){
	
				//验证 MD5
				$taovalue=$this->taobaosign($_GET);
			  
				if($_GET['sign'] == $taovalue['sign']){
  
					  $taobao_user_nick=$this->str($_GET['taobao_user_nick'],36,1,0,1,0,1);
				
					  if($taobao_user_nick){
  
							 @require_once(APPS.'/member/main_phpapp.php');
							 
							 //设置 taobao 应用ID 66
							 
							 $weibo=new MemberMainControls(66);
							 
							 $weibo->LoginWeiBo(array('UserName'=>$taobao_user_nick,'EMail'=>''),$taobao_user_nick);
	  
						  
					  }else{
							$this->Refresh('认证失败!',SURL);
					  }
					  
				}else{
					 $this->Refresh('认证失败!',SURL);
				}
				
		  }else{
			  
			    $this->Refresh('认证失败!',SURL);
		  }
		  
		  
	}
	
	
	
	function taobaosign($sianmake=array()){
		   
		   ksort($sianmake);
	  
		   
		   $newsign='';
		   
		   foreach($sianmake as $key=>$value){
				 if($key!='sign'){
					   $newsign.=$key.$value;
				 }
		   }
			
		   $turl='';
		   
		   foreach($sianmake as $key=>$value){
			  
				 if($turl){
					  $turl.='&'.$key.'='.$value;
				 }else{
					  $turl.='?'.$key.'='.$value;
				 }
				 
		   }
		  
		  $sign=strtoupper(md5(PHPAPP::$config['taobaoappsecret'].$newsign.PHPAPP::$config['taobaoappsecret']));
		   
		  return array('sign'=>$sign,'url'=>$turl);
	}
	
}


?>