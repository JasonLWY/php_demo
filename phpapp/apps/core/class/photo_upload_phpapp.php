<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5 2012.5.28
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(Core.'/class/upload_file_phpapp.php');

//上传图片
class UploadPhoto extends Upload{
	
    private $POST,$upload;
	
	public $allupfilesize,$thumbwidth,$thumbheight,$isthumb,$oldid;
	
	//[新文件数组],[旧ID] ,[缩略图宽] ,[缩略图高] ,[是否缩略 0 开 1关]
	function __construct($POST='',$oldid=0,$thumbwidth=0,$thumbheight=0,$isthumb=0){
		
        parent::__construct();
		
		$this->POST=$POST;
		
		$this->oldid=$oldid;
        
		if($thumbwidth>0){
			
		      $this->thumbwidth=intval($thumbwidth);
			  
		}else{
			
			  $this->thumbwidth=intval(PHPAPP::$config['thumbwidth']);
		}
		
		if($thumbheight>0){
			 
			  $this->thumbheight=intval($thumbheight);
			 
		}else{
		
		      $this->thumbheight=intval(PHPAPP::$config['thumbheight']);
		}
		
		if(intval(PHPAPP::$config['isthumb'])>0){
			
		      $this->isthumb=intval(PHPAPP::$config['isthumb']);
			  
		}else{
			
	          $this->isthumb=$isthumb;
		
		}


		if(!$this->uid>0){
			 exit('未登录!');
		}

	}
	
	
	function CheckUpload(){
		
		  if($this->uid>0){ 
		  
		  //判断文件类型	
		  if(preg_match('/\./',$this->POST['name'])){
				 
				if($this->POST['size']>0){
	  
				$is_type=0;
				
					  $sitefileform=array("jpg","gif","png");
					  $sitefiletype=array('image/pjpeg','image/jpeg','image/gif','image/png','image/x-png');
					  $fileheadertype=array('jpg'=>255216,'gif'=>7173,'png'=>13780);
					  $fileheader=$this->GetFileHeader($this->POST['tmp_name']);
							
					  $fileform=$this->GetFileForm($this->POST['name']); 
							
					  foreach($sitefileform as $forms){
	  
							 if($fileform==$forms){
								 
								   foreach($sitefiletype as $flietype){
									   
										 if($this->POST['type']==$flietype && $fileheadertype[$forms]==$fileheader){
											  $is_type=1;
										 }
									
								   }
	  
							 }
								  
					  }
								  
				  
					 if($is_type==1){
						 
							//判断文件大小
							if($this->POST['size'] < intval(PHPAPP::$config['oneimageuploadsize'])){	
						          		
								  return $this->UploadImage();
								 
			 
							}else{
								  $checkfile='您上传的文件容量太大或未知!';
							} 
		 
						 
					 }else{
		
						  $checkfile='您上传的文件格式不符合!';
							
					 }
	  
			 
			 
				}else{
					 $checkfile='您上传的文件容量太大或未知!';
				}
				
			 }else{
				  $checkfile='您上传的文件容量太大或未知!';
			 }
			  
		  }else{
			   $checkfile='您未登录，请登录后再上传!';
		  }
		  
		  return $checkfile;
		  
	}

	function UploadImage(){
		
		      if(!is_dir(S_UPLOAD_DIR)) {
				   @mkdir(S_UPLOAD_DIR,0777);
				   $this->WriteFile(S_UPLOAD_DIR.'/index.html','');
		      }
		   	
		      $fileform=$this->GetFileForm($this->POST['name']); 
		      $newfilepath=$this->FilePath(S_UPLOAD_DIR,$fileform);
			  
			  @move_uploaded_file($this->POST['tmp_name'],$newfilepath[0]); 
			  
			  @$this->IsPhoto($newfilepath[0],$newfilepath[2]);
			  
			  if(file_exists($newfilepath[2])){
                   
				    $this->DelFile($newfilepath[2]);
					
					//缩略图
					if(!$this->isthumb){
						  $thumbok=$this->photothumb($newfilepath[0],$this->thumbwidth,$this->thumbheight,$newfilepath[1]);
						  
						  if($thumbok){
								$thumb=$newfilepath[1];
								$fwidth=$this->thumbwidth;
						  }else{
								$fwidth=intval($this->GetPhotoWidth($newfilepath[0]));
								$thumb=$newfilepath[0];
						  }
						  
						  //水印
						 if(!intval(PHPAPP::$config['watermarklogo'])){
								  $this->FileWatermark($thumb,$thumb);
						 }
						  
					}else{
						
						 if(!intval(PHPAPP::$config['watermarklogo'])){
								 $this->FileWatermark($newfilepath[0],$newfilepath[0]);
						 }
					}
						  
	  
				   if($this->oldid>0){
						 
						  //删除旧文件
						 $oldfile=$this->GetMysqlOne('*'," ".$this->GetTable('file')." WHERE fid='$this->oldid'");
						 
						 $this->DelFile($oldfile['thumb']);
						 $this->DelFile($oldfile['filepath']);
						 
						 $this->Update('file',array('filename'=>$this->POST['name'],'filepath'=>$newfilepath[0],'filesize'=>$this->POST['size'],'thumb'=>$thumb),array(),"WHERE fid='$this->oldid' ");
	  
						 return $this->oldid;
				   }else{
					   
						 $thumb=empty($thumb) ? $newfilepath[0] : $thumb;
					   
						 $fid=$this->Insert('file',array('uid'=>$this->uid,'filename'=>$this->POST['name'],'filepath'=>$newfilepath[0],'filesize'=>$this->POST['size'],'thumb'=>$thumb,'dateline'=>$this->NowTime(),'ftp'=>0),array());
						  
						 return $fid;
				   }
			 
			 }else{
				  $this->DelFile($newfilepath[0]);
			 }
		
	}
	
}





?>