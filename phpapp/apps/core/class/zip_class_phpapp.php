<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class ZIP{
	
	  protected $zip;
	  protected $Default;
	  protected $ignored_names;
	  
	  function __construct() {
		    $this->zip = new ZipArchive();
	  }
	  
	  function  ZipCompression($file, $folder, $ignored=null){
	  
			
			$this->ignored_names = is_array($ignored) ? $ignored : $ignored ? array($ignored) : array();
			if ($this->zip->open($file, ZIPARCHIVE::CREATE)!==TRUE) {
				throw new Exception("cannot open <$file>\n");
			}

            $this->Default=$folder;

			$this->ZipDirectory();

			$this->zip->close();
	  
	  }
	  
	  
	  function ZipDirectory($folder='', $parent=null) {
			$full_path = $this->Default.$parent.$folder;
			$zip_path = $parent.$folder;
			$this->zip->addEmptyDir($zip_path);
			if(is_dir($full_path)){
				  $dir = new DirectoryIterator($full_path);
				  foreach($dir as $file) {
					  if(!$file->isDot()) {
						  $filename = $file->getFilename();
						  if(!in_array($filename, $this->ignored_names)){
							  if($file->isDir()) {
								   $this->ZipDirectory($filename,$zip_path.'/');
							  }else {
								   $this->zip->addFile($full_path.'/'.$filename,$zip_path.'/'.$filename);
							  }
						  }
					  }
				  }
			}
	  }
	  
	  
	  function  ZipDecomposition($filearray=''){
		  
		   if ($this->zip->open($filearray['filepath']) === TRUE){ 
		   
		        $this->zip->extractTo($filearray['filedirectory']);
				
				$this->zip->close();
				
				return true;
		   }else{
			    return false;   
		   }
		   

	  }
	  
			
}


?>