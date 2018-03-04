<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

// SendMail
class SendMail extends PHPAPP{
	
	private $SMTP;
	
	private $SmtpPort;
	
	private $LoginMail;
	
	private $LoginPassword;
	
	private $SendName;
	
	private $SendMailFrom;   //发送 mail 
	
	private $RcptTo;   //接收 mail 

    private $Subject;
	
	private $MailBody;
	
	private $Socket;
	
	private $fp;

	private $dateline;
	
	private $os;
	
	private $headers;
	
                
	function __construct($RcptTo='',$Subject='',$MailBody='',$MailFrom='',$SendName=''){	

	     $this->SMTP=PHPAPP::$config['mailsmtp'];
		 $this->SmtpPort=intval(PHPAPP::$config['mailsmtpport'])?25:intval(PHPAPP::$config['mailsmtpport']);
		 $this->LoginMail=PHPAPP::$config['mailloginname'];
		 $this->LoginPassword=PHPAPP::$config['mailloginpassword'];
		 $this->SendName=empty($SendName)? PHPAPP::$config['sitename']: $SendName;
		 $this->SendMailFrom=empty($MailFrom)?PHPAPP::$config['sitemail']:$MailFrom;
		 $this->RcptTo=$RcptTo;
		 $this->Subject=$this->SendCharset($Subject);
		 $this->MailBody=$this->SendCharset($MailBody);
		 $this->SendName=$this->SendCharset($this->SendName);
		 $this->os=PHPAPP::$config['mailos'] == 1 ? "\r\n" : (PHPAPP::$config['mailos'] == 2 ? "\r" : "\n");
		 $this->headers = "From: $this->SendName<$this->SendMailFrom>{$this->os}X-Priority: 3{$this->os}X-Mailer: PHPAPP V2.0{$this->os}MIME-Version: 1.0{$this->os}Content-type: text/html;Content-Transfer-Encoding: base64{$this->os}";
		 $this->dateline=$this->NowTime();

	}
	
	function PHPAPPSendMail(){

		     if(PHPAPP::$config['mailsendsystem']==1){
			       ignore_user_abort();
			 }
        
             set_time_limit(0);
			 
			 if($this->CheckEmail($this->RcptTo)){
 
					 if(PHPAPP::$config['sendmailmode']==1){
							 $this->SocketSendMail();
					 }elseif(PHPAPP::$config['sendmailmode']==2){
							 $this->FsockSendMail(0);
					 }elseif(PHPAPP::$config['sendmailmode']==3){
							 $this->FsockSendMail(1);
					 }else{
							 $this->PHPSendMail();
					 }
			 }
  
		
	}
	
	function SocketSendMail(){
		
			 if (false == ($this->Socket=@socket_create(AF_INET,SOCK_STREAM,SOL_TCP))) {
				   exit('不能创建Socket!');
			 }
			 					
             if (false == (@socket_connect($this->Socket,$this->SMTP,$this->SmtpPort))) {
                   exit("链接Socket $this->SMTP 失败!");
             }

             $this->SocketWrites('EHLO HELO');
             $this->CommandStatus(220);
             $this->SocketWrites('AUTH LOGIN');
             $this->CommandStatus(250);
             $this->SocketWrites(base64_encode($this->LoginMail));
             $this->CommandStatus(334);
             $this->SocketWrites(base64_encode($this->LoginPassword));
             $this->CommandStatus(334);
			 
             $this->SocketWrites('MAIL FROM:<'.$this->LoginMail.'>');
			 $this->CommandStatus(235); 
			 
			 $RcptToArray=explode(',',$this->RcptTo);
		 
		     foreach($RcptToArray as $value){
			       $this->SocketWrites('RCPT TO:<'.$value.'>');   
			       $this->CommandStatus(250);
			 }
          
             $this->SocketWrites('DATA');

             $this->CommandStatus(250);
			 
			 $MailInfo = 'Message-ID: <'.@date('YmdHs').'.'.substr(md5($this->MailBody.microtime()), 0, 6).rand(100000, 999999).'@'.$_SERVER['HTTP_HOST'].">{$this->os}";

             $MailInfo .= "Date: ".@date('r')."\r\n";

			 $MailInfo .= "To: ".$this->RcptTo."\r\n";

             $MailInfo .= "Subject:".$this->Subject."\r\n"; 

             $MailInfo .= $this->headers."\r\n\r\n"; 

             $MailInfo .= $this->MailBody; 
			 
             @socket_write ($this->Socket, $MailInfo."\r\n.\r\n"); 
			 
             $this->CommandStatus(250);
			 
		     $this->SocketWrites('QUIT');

             socket_close($this->Socket);

	}
	
	
	function SocketWrites($Command){
		 return @socket_write($this->Socket, $Command."\r\n"); 
	}
	
	function CommandStatus($Code){
		 $socketread=intval(substr(@socket_read ($this->Socket, 1024), 0, 3));
		 if($socketread != $Code){
			 return false;
		 }else{
		     return true;
		 }

	}
	
	
	function FsockSendMail($issocket=0){
		
		 if(!$this->fp = fsockopen($this->SMTP, $this->SmtpPort, $errno, $errstr, 30)) {
			 exit("链接fsockopen $this->SMTP 失败!");
		 }
		 
		 stream_set_blocking($this->fp, true);
		 
         $this->FsockWrites('EHLO HELO');
		 
		 $this->FsockWrites('AUTH LOGIN');
		 
		 $this->FsockWrites(base64_encode($this->LoginMail));
		 
		 $this->FsockWrites(base64_encode($this->LoginPassword));
		 
		 $this->FsockWrites('MAIL FROM: <'.$this->LoginMail.'>');
		 
		 $this->FsockWrites('RCPT TO: <'.$this->RcptTo.'>');
		 
		 $this->FsockWrites('DATA');
		 
		 if(!$issocket){

		       $this->FsockWrites('EHLO HELO');
		 
		       if($this->FsockWrites('AUTH LOGIN')!=334 ){
					exit('登录认证失败!');
			   }

			   if($this->FsockWrites(base64_encode($this->LoginMail))!=334 ){
					exit('帐号认证失败!');
			   }
			   

			   if($this->FsockWrites(base64_encode($this->LoginPassword))!=235){
					exit('密码认证失败!');
			   }
			   
			   fwrite($this->fp,'MAIL FROM: <'.$this->LoginMail.'>'."\r\n");
			   fgets($this->fp, 512);
			   
			   $RcptToArray=explode(',',$this->RcptTo);
			   
			   foreach($RcptToArray as $value){
					fwrite($this->fp,'RCPT TO: <'.$value.'>'."\r\n");
					fgets($this->fp, 512);
			   }
			   
			   fwrite($this->fp,'DATA'."\r\n");
		 
		 }
		 
		 fgets($this->fp, 512);
		
		 $this->headers.= 'Message-ID: <'.@date('YmdHs').'.'.substr(md5($this->MailBody.microtime()), 0, 6).rand(100000, 999999).'@'.$_SERVER['HTTP_HOST'].">{$this->os}";
		 fwrite($this->fp, "Date: ".@date('r')."\r\n");
		 fwrite($this->fp, "To: ".$this->RcptTo."\r\n");
		 fwrite($this->fp, "Subject: ".$this->Subject."\r\n");
		 fwrite($this->fp, $this->headers."\r\n");
		 fwrite($this->fp, "\r\n\r\n");
		 fwrite($this->fp, $this->MailBody."\r\n.\r\n");
		 fgets($this->fp, 512);
		 fwrite($this->fp, "QUIT\r\n");
		 fclose($this->fp);
			   
		 	
	}
	
	function FsockWrites($Command){
		 fwrite($this->fp, $Command."\r\n"); 

		 $returninfo= fgets($this->fp, 512);
		 
		 /*
		 if($Command=='AUTH LOGIN'){
			 echo intval(substr($returninfo, 0, 3));
			 exit();
		 }
		 */

		 return intval(substr($returninfo, 0, 3));
	}

     function PHPSendMail(){
	     ini_set("SMTP",$this->SMTP); 
         ini_set('smtp_port',$this->SmtpPort);
         ini_set('sendmail_from',$this->SendMailFrom); 
		 
		 $RcptToArray=explode(',',$this->RcptTo);
		 foreach($RcptToArray as $value){
              @mail($value,$this->Subject,$this->MailBody,$this->headers); 
		 }
     }

     function SendCharset($convert){
	
		 if(PHPAPP::$config['mailsendcharset']==1){  
			 return  mb_convert_encoding($convert, "GBK", "UTF-8"); 
		 }elseif(PHPAPP::$config['mailsendcharset']==2){
			 return  mb_convert_encoding($convert, "UTF-8", "GBK");
		 }else{
			 return $convert;
		 }
	 }
	 
	  function CheckEmail($email){

		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
	
				if(!preg_replace('/[\w]+|\@|\./','',$email)){

	                 if(preg_match('/([\w]+)(\@)([\w]+)(\.)([\w]+)/',$email)){
					     return true;
				     }else{
						 return false;
		             }
						 
				}else{
				     return false;
				}
	
		 }else{
			  return false;
		 }
		 
					 
  }
         
}

?>