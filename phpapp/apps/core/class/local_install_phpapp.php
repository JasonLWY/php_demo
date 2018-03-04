<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//本地安装
class LocalInstall extends PHPAPP{

    private $POST;
	
	public $uid;
	
	function __construct(){
		
        parent::__construct();
			
		$this->POST=empty($_FILES['Filedata']) ? '' : $_FILES['Filedata'];

	}
	
	function UploadFile(){
		
		  if($this->POST){
			  
				$newfilename=$this->RandomText(8,1);
				
				$filedirectory=SYS.'/data/make/'.$newfilename;
				
				$newfilepath=SYS.'/data/make/'.$newfilename.'.zip';
				 
			    @move_uploaded_file($this->POST['tmp_name'],$newfilepath); 
				
			    return array('filename'=>$newfilename,'filepath'=>$newfilepath,'filedirectory'=>$filedirectory);
		  }else{
			    return false;
		  }
		
		
	}
	
		
    function InstallApp(){
		
		   $filearray=$this->UploadFile();
		   
		   if($filearray['filename']){
			    
				 include_once(Core.'/class/install_class_phpapp.php');
			     
				 $app=new Install($filearray);
				 
				 $app->InstallCode();
				 
		   }else{
			     return false;
		   }
	}
	

}


?>