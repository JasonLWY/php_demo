<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class MobileSMS extends PHPAPP{
	
    public $UserID,$Account,$Password,$Port;

	function __construct(){
        
		parent::__construct();
		
        $this->Port='http://xtx.telhk.cn:8888/';
		
		$this->UserID=PHPAPP::$config['mobilesmsuserid'];
		
		$this->Account=PHPAPP::$config['mobilesmsaccount'];
		
		$this->Password=PHPAPP::$config['mobilesmspassword'];
		

	}

	//检查总数
	function CheckSum(){
		   
		   $result=$this->CurlGetContentPOST($this->Port.'sms.aspx',array('action'=>'overage','userid'=>$this->UserID,'account'=>$this->Account,'password'=>$this->Password));

	       $xml=simplexml_load_string($result);
   
		   if($xml->returnstatus=='Sucess'){
			    
				  return array('overage'=>$xml->overage,'sendTotal'=>$xml->sendTotal);
				
		   }else{
			   
			      exit('获取短信失败!请联系PHPAPP官方!');
		   }

		
	}
	
	function SendSMS($mobile='',$content='',$uid=0){
		    
			if(!$uid){
				 $uid=$this->uid;
			}
		
		    $content=$content.' '.PHPAPP::$config['mobilesign'];

		    if($mobile){
		    
				   $result=$this->CurlGetContentPOST($this->Port.'sms.aspx',array('action'=>'send','userid'=>$this->UserID,'account'=>$this->Account,'password'=>$this->Password,'mobile'=>$this->ConvertStrToUTF8($mobile),'content'=>$this->ConvertStrToUTF8($content)));
				   
				   $xml=simplexml_load_string($result);

				   if($xml->returnstatus=='Success'){
					   
					       if($xml->message=='ok'){
							     
								 if($this->uid){
							            $this->Insert('mobile_consume',array('uid'=>$uid,'mobile'=>$mobile,'content'=>$content,'datetime'=>$this->NowTime()),array());
								 }
								 
						         return 'ok';
							   
						   }else{
			   
			                     exit($this->ConvertStr($result).' 发送短信失败!请联系网站客服!');
		                   }
					   
				   }else{
 
			             exit($this->ConvertStr($result).' 短信链接失败!请联系网站客服!');
		           }
	  
			
		   }
		
	}
	
	function CurlGetContentPOST($url='',$data=array()){
	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1); 
			curl_setopt($ch, CURLOPT_POSTFIELDS,$data); 
			$result = curl_exec($ch);
			curl_getinfo($ch);  
			curl_close($ch);
			
			return $result;
			
	}

	
}


?>