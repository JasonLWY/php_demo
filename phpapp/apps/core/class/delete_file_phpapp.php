<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//Delete
class DeleteFile extends PHPAPP{

	
	function __construct(){
		
        parent::__construct();
			
		if(!$this->uid>0){
			 exit('ฮดตวยผ!');
		}

	}
	
	function SetDeleteFile($fid=0){
	      
		  if($fid>0){
			  
				$delfile=$this->GetMysqlOne('*'," ".$this->GetTable('file')." WHERE fid='$fid'");
							   
				$this->DelFile($delfile['thumb']);
				$this->DelFile($delfile['filepath']);
				
				$this->Delete('file'," WHERE fid='$fid'");
				
		        return true;
				
		  }else{
			  
			    return false;
				
		  }
	
	}
		
	
}


?>