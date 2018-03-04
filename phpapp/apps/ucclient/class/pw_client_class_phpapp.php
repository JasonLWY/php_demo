<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


define('P_W','admincp');

require_once(PHPAPP_DIR.'/api/pw_api/security.php');

require_once(PHPAPP_DIR.'/api/pw_api/pw_common.php');


//UC���ò���

//Ӧ�õ�UCenter������Ϣ(���Ե�UCenter��̨->Ӧ�ù���->�鿴��Ӧ��->���������Ӧ��������Ϣ�����滻)
define('UC_CONNECT',PHPAPP::$config['uc_linktype']); // ���� UCenter �ķ�ʽ: mysql/NULL, Ĭ��Ϊ��ʱΪ fscoketopen(), mysql ��ֱ�����ӵ����ݿ�, Ϊ��Ч��, ������� mysql
define('UC_DBHOST', PHPAPP::$config['uc_dbhost']); // UCenter ���ݿ�����
define('UC_DBUSER', PHPAPP::$config['uc_dbuser']); // UCenter ���ݿ��û���
define('UC_DBPW', PHPAPP::$config['uc_dbpw']); // UCenter ���ݿ�����
define('UC_DBNAME', PHPAPP::$config['uc_dbname']); // UCenter ���ݿ�����
define('UC_DBCHARSET',PHPAPP::$config['uc_dbcharset']); // UCenter ���ݿ��ַ���
define('UC_DBTABLEPRE', PHPAPP::$config['uc_dbpre']); // UCenter ���ݿ��ǰ׺
define('UC_DBCONNECT', '0'); // UCenter ���ݿ�־����� 0=�ر�, 1=��
define('UC_KEY', PHPAPP::$config['uc_key']); // �� UCenter ��ͨ����Կ, Ҫ�� UCenter ����һ��
define('UC_API', PHPAPP::$config['uc_api']); // UCenter �� URL ��ַ, �ڵ���ͷ��ʱ�����˳���
define('UC_CHARSET', PHPAPP::$config['uc_charset']); // UCenter ���ַ���
define('UC_IP', PHPAPP::$config['uc_ip']); // UCenter �� IP, �� UC_CONNECT Ϊ�� mysql ��ʽʱ, ���ҵ�ǰӦ�÷�������������������ʱ, �����ô�ֵ
define('UC_APPID', PHPAPP::$config['uc_appid']); // ��ǰӦ�õ� ID
define('UC_PPP', 20);

@include_once(APPS.'/ucclient/pw_client/uc_client.php');

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
		   return uc_user_register($this->username,md5($this->password),$this->usermail);        
	   }
	   
	   function get_user($userid='',$type=0){ 
			return uc_user_get($userid,$type);
	   }
	   
	   function checkename(){  
	       $checkuser =uc_check_username($this->username);
		   if($checkuser==1){
			   return 1;
		   }elseif($checkuser==-1){
			   return -1;
		   }else{
			   return -3;
		   }     
	   }
	   
	   function checkemail(){ 
		   $emailcount=uc_check_email($this->usermail);

		   if($emailcount>0){
			   return 1;
		   }elseif($emailcount==-3){
			   return -4;
		   }else{
			   return -6;
		   } 
	   }
	
	   function logout(){  
	       return uc_user_synlogout();
	   }
	   
	   function user_login(){ 
           $userarr =uc_user_get($this->username,0);	
		   return uc_user_check($userarr['uid'],md5(UC_KEY.md5($this->password)));
	   }
	   
	   function login($userid){ 
		   $user_login=uc_user_login($userid,md5($this->password),1);
		   return $user_login['synlogin'];
	   }
	   
	   function getavatar($userid,$type){ 
		   $userarr =uc_user_get($userid,1);
		   $usericonarr=explode('|',$userarr['avatar']);
		   
		   if($usericonarr[0]=='none.gif' || empty($usericonarr[0]) || $usericonarr[1]==1){
			    if($type){
	                 $avatar='<img src="'.TURL.'member/images/no_avatar_middle.gif"/>';	
                }else{
	                 $avatar='<img src="'.TURL.'member/images/no_avatar_small.gif"/>';
                }
		   }else{
			    if($usericonarr[1]==2){
					 
					 $avatar='<img src="'.$usericonarr[0].'" />';
					 
				}else{
					
					  if($type){
						   $avatar='<img src="'.UC_API.'/attachment/upload/middle/'.$usericonarr[0].'" />';
					  }else{
						   $avatar='<img src="'.UC_API.'/attachment/upload/small/'.$usericonarr[0].'" />';
					  }
				}
		   }
		   return $avatar;
		   
	   }
	   
	   function avatar($userid){
	       return '<p><a href="'.UC_API.'/profile.php?action=modify&info_type=face" class="my_avatar_icon" style="font-weight:bold;">[���ͬ���޸�ͷ��]</a></p>';
	   }
	   
	   function send_sms($fromuid=0,$msgto=0,$subject='',$message=''){
		   
		    $user=$this->GetMysqlOne('username'," ".$this->GetTable('member')."  WHERE uid='$fromuid'");
	        return  uc_msg_send($fromuid,$user['username'],$msgto,$subject,$message);
	   }
	   
	   function credit_add($uid,$point){
		  $credit=array("$uid"=> array('credit'=>$point));
		  return uc_credit_add($credit);
	   }
     
       function user_edit($newpassword='',$ignoreoldpw=0){
		    $userarr=uc_user_get($this->username,0);
		    $checkedit=uc_user_edit($userarr['uid'],$this->username,md5($newpassword),$this->usermail);
			if($checkedit==1){
				return 1;
			}else{
				return -1;
			}
			
       }
	   
	   function get_creditsettings(){
		   return false;
	   }
	   
	   
	   function feed_add($feed){
		   return false;
	   }


}


?>