<?php
/*
	EDOOG.COM (C) 2009-2010 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V1.0  2010.12.5
*/
if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

// FTP
class EDOOGFTP extends PHPAPP{
	
	private $conn;
	
	function __construct(){
          
		  parent::__construct();
		  
		  $this->FtpOpen();
	}
	
	public function FtpOpen(){
		
	    if(PHPAPP::$config['ftp_open']==1){

             $this->conn= ftp_connect(PHPAPP::$config['ftp_server']) or die("Couldn't connect to".PHPAPP::$config['ftp_server']); 

             if (!@ftp_login($this->conn,PHPAPP::$config['ftp_username'],PHPAPP::$config['ftp_password'])){
	              exit("Couldn't connect as".PHPAPP::$config['ftp_username']);   
             }

	    }
		
	}	
	
	public function FtpPut($newfilepath){ 
	
	      $dirarr=explode('/',$newfilepath);
		  $dirmun=count($dirarr);
		  $path='';
		  $filename='';

		  for($i=0; $i<$dirmun-1;$i++) {
			    
				 if($dirmun!=($i+1)){
			           $path.= '/'.$dirarr[$i];
				 }
                
				 if(!@ftp_chdir($this->conn,$path)) {
  
					   @ftp_mkdir($this->conn,$path);
					   
					   @ftp_chdir($this->conn,$path);
					   
					   @ftp_put($this->conn,'index.html','./attachment/index.html',FTP_BINARY);
				 }
				
		  }

		  @ftp_chdir($this->conn,$path);

          @ftp_put($this->conn,$dirarr[$dirmun-1],PHPAPP_DIR.'/'.$newfilepath,FTP_BINARY);

	}
	
	public function FtpGet($file){
	    return  @readfile(ftp_get($this->conn,$file,$ftp,FTP_BINARY));
	}
	
    public function FtpDelete($file){
        @ftp_delete($this->conn,$file);
	}
	
	public function Ftpmdtm($file){
		 return @ftp_mdtm($this->conn,$file);
	}
	 
}

 
?>