<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

//Powered by PHPAPP.CN (C) 2009-2012 PHPAPP Inc.

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class AuthManageControls extends PHPAPP{

	  public $actionmenu,$POST,$GET,$callback;
	  
	  function __construct($actionmenu=''){	
             
			 parent::__construct();
			 
			 $this->actionmenu=$actionmenu;
			 
			 $postkey=array('Submit'=>'');
			 
			 $this->POST=$this->POSTArray();
			 
			 foreach($postkey as $key=>$vaule){
				 if(empty($this->POST[$key])){
					 $this->POST[$key]='';
				 }
			 }
			 
			 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','action'));
			 
			 $this->callback ='http://'.$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF'].'?menu=5&action=4';
				   
	  }
	  
	  function DefaultAction(){
		  
             $this->InfoAction();
		    
	  }
	  
	  function InfoAction(){
		  
		     $deposit=$this->IsSQL('consume'," WHERE process<5 AND paytype=4 ");
		  
			 $personalcertificate=$this->IsSQL('member_personal_certificate'," WHERE status<5 AND status!=6 ");
			
			 $companycertificate=$this->IsSQL('member_company_certificate'," WHERE status<5 AND status!=6 ");
			
			 $mobilecertificate=$this->IsSQL('member_mobile_certificate'," WHERE status<5 AND status!=6 ");
			
			 $mailcertificate=$this->IsSQL('member_mail_certificate'," WHERE status<5 AND status!=6 ");

			 $report=$this->IsSQL('report'," WHERE status=0 ");
			 
			 $rights=$this->IsSQL('rights'," WHERE process!=3 ");
			 
			 $taskrefund=$this->IsSQL('task_refund'," WHERE status=0 ");
			 
			 $orderrefund=$this->IsSQL('refund_money'," WHERE process!=3 ");
			 
			 $userpay=$this->IsSQL('consume'," WHERE process=5 AND paytype=3 AND dateline>=UNIX_TIMESTAMP(timestamp(date(sysdate()))) AND dateline<=(UNIX_TIMESTAMP()+86400)");
			 
			 
			 $newdate=$this->Date("Y-m-d",time());
			 
			 $os=phpversion();
			 $os .=(@ini_get('safe_mode') ? ' Safe Mode' : NULL);

			 $mysqlarray=$this->MysqlFetchArray('SELECT VERSION() AS version');
			 
			 if(@ini_get('file_uploads')) {
				  $fileupload = ini_get('upload_max_filesize');
			 }else{
				  $fileupload = '<font color="red">Prohibition</font>';
			 }
			 
			 $tablename=$this->MysqlFetchArray('SHOW TABLE STATUS');
			 
			  
			 $Data_length=0;
			 foreach($tablename as $value){
				  $Data_length+=$value['Data_length'];
			 }
				
			 $Data_length=round($Data_length/1024/1024,2);
			
			 include $this->Template('info');
		    
	  }
	  
	  function AuthAction(){

             if($this->POST['Submit']){

                    if(@intval($this->FileGetContentPOST('http://www.phpapp.cn/auth.html',array('domain'=>SURL,'key'=>$this->POST['phpappkey'],'secret'=>$this->POST['phpappsecret']))) == 1){
						
					      $this->POST['phpappauth']=1;
					
					}else{
						
						  $this->POST['phpappauth']=0;
					}
					
				    $this->SetConfig($this->POST);
	

			 }else{
                   
				    $phpappcopy=$this->Date("Y",$this->NowTime());
					
		            include $this->Template('auth');
			 
			 }
	  }
	  
	 /* 
	 function LoginAPIAction(){
		  
		   $o=new PHPAPPAuth2(PHPAPP::$config['phpappkey'],PHPAPP::$config['phpappsecret']);

           return $o->getAuthorizeURL($this->callback);
 	 }
	  
	  
	 function CallbackAction(){
		 
	        $o = new PHPAPPAuth2(PHPAPP::$config['phpappkey'],PHPAPP::$config['phpappsecret']);

			if (isset($_REQUEST['code'])) {
				$keys = array();
				$keys['code'] = $_REQUEST['code'];
				$keys['scope'] = $_REQUEST['scope'];
				$keys['redirect_uri'] = $this->callback;
				
				$token = $o->getAccessToken('code',$keys) ;

			}
			
			if(!empty($token)) {
				 $_SESSION['PHPAPPTOKEN'] = $token;
				 setcookie('phpapp_'.$o->client_id, http_build_query($token) );

				 $this->Refresh('认证成功!',$this->MakeGetParameterURL());
			}else{
				 $this->Refresh('认证失败!',$this->MakeGetParameterURL());
			}
	  
	 }
	 */
}

?>