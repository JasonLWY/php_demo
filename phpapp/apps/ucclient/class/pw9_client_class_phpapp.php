<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

require_once APPS.'/ucclient/windid_client/src/windid/WindidApi.php';

$this->SetTimezone(PHPAPP::$config['timezone']);

class UserClientAPI extends PHPAPP{
	
	   public $username;  
	
       public $password; 
   
       public $usermail;  
	   
	   public $db;
	   
	   public $uid;
	  
	   function __construct($username='',$password='',$usermail=''){
		   
		   parent::__construct();
		   $this->username=$username;
		   $this->password=$password;
		   $this->usermail=$usermail;

		   error_reporting('E_ALL ^ E_NOTICE');
		   
	   }
	
	   function register(){ 
		     $api = WindidApi::api('user');
			 return $api->register($this->username,$this->usermail,$this->password);
	   }
	   
	   function get_user($userid='',$type=0){ 
	        $api = WindidApi::api('user');
            return $api->getUser($userid,$type);
	   }
	   
	   function checkename(){  
	  
		   $api = WindidApi::api('user');
           $checkuser=$api->getUser($this->username,2);
		   if(empty($checkuser['uid'])){
			   return 1;
		   }else{
			   return -3;
		   }     
		   
	   }
	   
	   function checkemail(){ 
		   $api = WindidApi::api('user');
           $checkuser=$api->getUser($this->usermail,3);
		   if(empty($checkuser['uid'])){
			   return 1;
		   }else{
			   return -6;
		   }     
	   }
	
	   function logout(){  
			 $api = WindidApi::api('user');
             return $api->synLogout($this->uid);
	   }
	   
	   function user_login(){ 
		   $api = WindidApi::api('user');
           $userarr =$api->login($this->username,$this->password,2,false);

		   if($userarr[0]>0){
			     return $userarr[1];
		   }else{
			     return -1;
		   }
		   
	   }
	   
	   function login($userid){ 
		    $api = WindidApi::api('user');
			$synString = $api->synLogin($userid);
			return $synString;
	   }
	   

	   function verifyavatar($url){
			if(file_get_contents($url,0,null,0,1)){
				return 1;
			}else{
				return 0;
			}
	   }
	   
	   function getavatar($userid,$type){ 
	       
            $api = WindidApi::api('avatar');
			if($type==2){
				 $imgavatar='big';
			}elseif($type==1){
				 $imgavatar='middle';
			}else{
				 $imgavatar='small';
			}
			
            $useravatar=$api->getAvatar($userid,$imgavatar);

			$avatar='<img src="'.$useravatar.'" />';

		    return $avatar;
		   
	   }
	   
	   function avatar($userid){

		    $api = WindidApi::api('avatar');

		    $avatardata=$api->showFlash($userid,1);

		    $avatardata.= '<script>window.uploadSuccess = function() {updateavatar();};</script>';

            return $avatardata;
			
	   }
	   

	   function user_edit($newpassword='',$ignoreoldpw=0){
		  
			$api = WindidApi::api('user');
            $checkedit=$api->editUser($this->uid,$this->password,array('password'=>$newpassword));
			if($checkedit==1){
				return 1;
			}else{
				return -1;
			}
			
       }
	   
	   /**************************** 以下暂时未使用 ****************************/
	   
	   function edit_creditsettings($uid, $type, $value, $isset = false){
		   $api = WindidApi::api('user');
           return $api->editCredit($uid,$type,$value,$isset);
	   }		  
				  
	   function get_creditsettings($uid){
		    $api = WindidApi::api('user');
            $pwuser=$api->getUserCredit($uid);
			if($pwuser['credit1']){
				  return intval($pwuser['credit1']);
			}else{
				  return 0;
			}
	   }
	   
	   function credit_add($uid,$credit){
		     return false;
	   }
	   
	   function send_sms($fromuid=0,$msgto=0,$subject='',$message=''){
		     
			 return false;
			 /*
			 $api = WindidApi::api('message');
             return $api->send($msgto,$message,$fromuid);
			 */
	   }

	   function feed_add($feed){
		     return false;
	   }


}


?>