<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5 2012.5.28
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//上传
class Upload extends PHPAPP{

    private $POST,$upload;
	
	public $uid,$allupfilesize,$thumbwidth,$thumbheight,$isthumb;
	
	function __construct($upload=''){
		
        parent::__construct();
			
		$this->POST=empty($_FILES['Filedata']) ? '' : $_FILES['Filedata'];
			 
		$this->upload=$upload;
		
		if(!empty($upload['uid'])){
	          $this->uid=$upload['uid'];
		}
		
		$this->thumbwidth=intval(PHPAPP::$config['thumbwidth']);
		
		$this->thumbheight=intval(PHPAPP::$config['thumbheight']);
		
		$this->isthumb=intval(PHPAPP::$config['isthumb']);
		
		if(!$this->uid>0){
			 exit();
		}

	}
		
	
	function CheckUpload(){
		
		 
		  //判断文件类型
		  if(preg_match('/\./',$this->POST['name'])){
				 
				if($this->POST['size']>0){
	  
					  $is_type=0;
				     
					  $this->allupfilesize=intval(PHPAPP::$config['totalfileuploadsize']);
					  $oneuploadsize=intval(PHPAPP::$config['onefileuploadsize']);

					  //类型
					  if($this->upload['type']==3){
						  $sitefileform=explode(',',PHPAPP::$config['uploadmusictype']);
						  
					  }elseif($this->upload['type']==1){
						   //图片
						   $this->allupfilesize=intval(PHPAPP::$config['totalimageuploadsize']);
						   
						   $sitefileform=explode(',',PHPAPP::$config['uploadphototype']);
						   
						   $oneuploadsize=intval(PHPAPP::$config['oneimageuploadsize']);
					  }else{
						  
						   $sitefileform=explode(',',PHPAPP::$config['uploadfiletype']);
					  }
					  
						
					  $fileform=$this->GetFileForm($this->POST['name']); 
					  //$fileheader=$this->GetFileHeader($this->POST['tmp_name']);
					  if(PHPAPP::$config['fileinfomime']){
					         $fileinfomime=@$this->GetFileInfoMIME($this->POST['tmp_name']);
					  }
			 
			          $ttype=$this->str($this->POST['type'],100,1,0,1,0,1);
							
					  foreach($sitefileform as $forms){
	  
							 if($fileform==$forms){
			                        
									$typeformarr=$this->GetMysqlArray('type,form',"  ".$this->GetTable('file_icon')." WHERE form='$forms'");

									if($typeformarr){
										  
										  $isform=0;
										  
										  if(PHPAPP::$config['fileinfomime']){
												foreach($typeformarr as $fileforms){
													   
													   if($fileinfomime==$fileforms['type']){
															 $isform=1;
													   }
													   
												}
												
										  }else{
											   
											    foreach($typeformarr as $fileforms){
													   
													   if($fileform==$fileforms['form']){
															 $isform=1;
													   }
													   
												}
											  
										  }
										  
										  //$this->WriteFile('mytest.txt',$isform);
									
										  if($isform){
											  
												if($this->upload['type']==1 || $forms=='gif' || $forms=='jpg' || $forms=='png'){
	  
													   $newfilepath=$this->FilePath(S_UPLOAD_DIR,$forms);
													   @$this->IsPhoto($this->POST['tmp_name'],$newfilepath[2]);
	  
													   if(@file_exists($newfilepath[2])){
															 $this->DelFile($newfilepath[2]);
															 $is_type=1;
															 
													   }else{
															 $this->DelFile($newfilepath[2]);
															 return false;
													   }
													   
												}else{
													  $is_type=1;
												}
	  
										  }else{
												$this->DelFile($this->POST['tmp_name']);
												return false;
										  }
									
									}else{
										  $this->DelFile($this->POST['tmp_name']);
										  return false;
									}
							
	
							 }
								  
					  }
					  
				  
					 if($is_type==1){
					
							//判断文件大小
							if($this->POST['size'] < $oneuploadsize){	
						   
								if(!$this->UploadTempFile()){
									  return '上传失败!';
								}
		
							}
		 
						 
					 }
			   }
		  }
	   
	 
	}
	
	
	//上传临时文件
	function UploadTempFile(){
		  		
          $tempfilesizes=$this->GetTempFileSize();
          //检查上传总容量
		  if(($tempfilesizes + $this->POST['size']) > $this->allupfilesize){
			   return false;
		  }else{
	
		      if(!is_dir(S_UPLOAD_DIR)) {
				   @mkdir(S_UPLOAD_DIR,0777);
				   $this->WriteFile(S_UPLOAD_DIR.'/index.html','');
		      }
		   	
		      $fileform=$this->GetFileForm($this->POST['name']); 
		      $newfilepath=$this->FilePath(S_UPLOAD_DIR,$fileform);
			  
			  @move_uploaded_file($this->POST['tmp_name'],$newfilepath[0]); 
			  
              if($this->upload['type']==1){

					//缩略图
					if(!$this->isthumb){
						  $thumbok=$this->photothumb($newfilepath[0],$this->thumbwidth,$this->thumbheight,$newfilepath[1]);
						  
						  if($thumbok){
							    $thumb=$newfilepath[1];
								$fwidth=$thumbok;
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
					

			  }else{
				    $fwidth=0;
			  }

			  
			  $filename=str_replace(';','',$this->POST['name']);
			  
			  $formarr=explode('.',$filename);
		      $num=count($formarr);
 
			  $filename='';
			   
			  for($i=0;$i<$num-1;$i++){
					$filename.=$formarr[$i];
			  }
			  
			  
			  if($filename){
				    if(strlen($filename) > 50) {
			             $fname=substr($filename,0,50);	
				    }else{
					     $fname=$filename;
				    }
			  }else{
				  
				    $fname=$this->RandomText(10);
			  }
			   
			  $fname.='.'.$fileform;
			   

			  $fname=$this->ConvertStr(preg_replace("/\s|\xhh|\ddd/",'',$fname));
												
			  
			  $tmpid=$this->Insert('file_temp',array('uid'=>$this->uid,'uploadtype'=>$this->upload['type'],'fname'=>$fname,'ftype'=>$this->POST['type'],'fsize'=>$this->POST['size'],'tmpname'=>$newfilepath[0],'thumb'=>$thumb,'dateline'=>$this->NowTime(),'fwidth'=>$fwidth),array());
			  
		 
		      return $tmpid;
          
		 }
		  
		  
		
	}
	
	
	function UploadFile(){
		
		  $filetemp=$this->GetMysqlArray('*'," ".$this->GetTable('file_temp')." WHERE uid='$this->uid'");
		  if($filetemp){
			    $fids=array();
				
				//FTP
			    if(PHPAPP::$config['ftp_open']==1){
					 @include_once(Core.'/class/ftp_class_phpapp.php');
					 $ftp=new EDOOGFTP();
			    }
		 
				foreach($filetemp as $value){
					 $fids[]=$this->Insert('file',array('uid'=>$this->uid,'filename'=>$value['fname'],'filepath'=>$value['tmpname'],'filesize'=>$value['fsize'],'filetype'=>$value['uploadtype'],'thumb'=>$value['thumb'],'dateline'=>$this->NowTime(),'ftp'=>PHPAPP::$config['ftp_open']),array());
					 $this->Delete('file_temp'," WHERE uid='$this->uid' AND tmpid='$value[tmpid]' ");
					 
					 if(PHPAPP::$config['ftp_open']==1){
						   $ftp->FtpPut($value['tmpname']);
						   $this->DelFile($value['tmpname']);
						   if($value['thumb']){
							     $ftp->FtpPut($value['thumb']);
						         $this->DelFile($value['thumb']);
						   }
					 }
				}
				
			    return $fids;
		  }else{
			    return false;
		  }
		
		
	}
	
	
	function GetTempFileSize(){
		   //临时文件大小
		  $tempfiles=$this->GetMysqlOne(' sum(fsize) AS sizes '," ".$this->GetTable('file_temp')." WHERE uid=".$this->uid." ORDER BY tmpid DESC");
		  return $tempfiles['sizes'];	
	}
	
	
	function FilePath($dir,$filetype){
		
			 $dir1 = gmdate('Ym');
	         $dir2 = gmdate('j');
			 $times =@date("YmdHis");
			 
			 $filedir=$dir.'/'.$dir1;
			 
			 if(!is_dir($filedir)) {
				 @mkdir($filedir,0777);
				 $this->WriteFile($filedir.'/index.html','');
			 }
			 
			 $filedir=$filedir.'/'.$dir2;
			 
			 if(!is_dir($filedir)){
				 @mkdir($filedir,0777);
				 $this->WriteFile($filedir.'/index.html','');
			 }
			  
			 $newfilename=$this->RandomText(8,1);

			  //组合新文件名	
			 $newfilenamearr[]=$filedir.'/'.$newfilename.$times.'.'.$filetype;
			 $newfilenamearr[]=$filedir.'/'.$newfilename.$times.'_thumb.'.$filetype;
			 $newfilenamearr[]=$filedir.'/'.$newfilename.$times.'_test.'.$filetype;
			 
			 return $newfilenamearr;
	}
	
	function GetPhotoWidth($im){
		
		   $Imagedata = @GetImageSize($im);
	
		   switch ($Imagedata[2]){
			  case 1:
				 $im = @imagecreatefromgif($im);
			  break;
			  case 2:
				 $im = @imagecreatefromjpeg($im);
			  break;
			  case 3:
				 $im = @imagecreatefrompng($im);
			  break;
		   }
		
		   return  @ImageSX($im);
	}
	
	
	function IsPhoto($im,$savepath){
		
			 $Imagedata = @GetImageSize($im);
		  
			 switch ($Imagedata[2]){
				case 1:
				   $im = @imagecreatefromgif($im);
				break;
				case 2:
				   $im = @imagecreatefromjpeg($im);
				break;
				case 3:
				   $im = @imagecreatefrompng($im);
				break;
			 }
			 
			 switch ($Imagedata[2]){
					  case 1:
						   @imagegif($im,$savepath); 
					   break;
					  case 2:
						   @imagejpeg($im,$savepath,99); 
					   break;
					  case 3:
						   @imagepng($im,$savepath); 
					  break;
			 }
	  
			 @imagedestroy($im); 
			 
	}
	
	
	 //缩略图
    function photothumb($im,$photoWidth,$photoHeight,$savepath){

		 $Imagedata = @GetImageSize($im);
	  
		 switch ($Imagedata[2]){
			case 1:
			   $im = @imagecreatefromgif($im);
			break;
			case 2:
			   $im = @imagecreatefromjpeg($im);
			break;
			case 3:
			   $im = @imagecreatefrompng($im);
			break;
		 }
	  
		 $imW = @ImageSX($im);
		 $imH = @ImageSY($im);
		 
		 if($imW>=80){
	  
			  if($imW>=$photoWidth && $imH >=$photoHeight){
			  
	              if($Imagedata[2]==3){

					   if($imW>$imH){
						   $newphotoHeight=$imH/($imW/$photoWidth);
						   $thumb=@imagecreatetruecolor($photoWidth,$newphotoHeight);
						   $alpha = @imagecolorallocatealpha($thumb, 0, 0, 0, 127);
                           @imagefill($thumb, 0, 0, $alpha);
						   @imagecopyresampled($thumb, $im, 0, 0, 0, 0,$photoWidth,$newphotoHeight, $imW, $imH);
					   }else{	
						   $newphotoWidth=$imW/($imH/$photoHeight);
						   $thumb=@imagecreatetruecolor($newphotoWidth,$photoHeight);
						   $alpha = @imagecolorallocatealpha($thumb, 0, 0, 0, 127);
                           @imagefill($thumb, 0, 0, $alpha);
						   @imagecopyresampled($thumb, $im, 0, 0, 0, 0,$photoWidth,$newphotoHeight, $imW, $imH);
					   }

				  }else{
					   if($imW>$imH){
						   $newphotoHeight=$imH/($imW/$photoWidth);
						   $thumb=@imagecreatetruecolor($photoWidth,$newphotoHeight);
						   @imagecopyresized($thumb, $im, 0, 0, 0, 0,$photoWidth,$newphotoHeight, $imW, $imH);
					   }else{	
						   $newphotoWidth=$imW/($imH/$photoHeight);
						   $thumb=@imagecreatetruecolor($newphotoWidth,$photoHeight);
						   @imagecopyresized($thumb, $im, 0, 0, 0, 0,$newphotoWidth,$photoHeight, $imW, $imH);
					   }
				  }
	              
  
				   switch ($Imagedata[2]){
					  case 1:
						   @imagegif($thumb,$savepath); 
					   break;
					  case 2:
						   @imagejpeg($thumb,$savepath,100); 
					   break;
					  case 3:
					       @imagealphablending($thumb,false);
                           @imagesavealpha($thumb,true);
						   @imagepng($thumb,$savepath); 
					  break;
				   }
	  
				   @imagedestroy($im);   
				   @imagedestroy($thumb); 
			      
				  
				  if(@empty($newphotoWidth)){
				        return $this->thumbwidth;
				  }else{
				        return $newphotoWidth;
				  }
			 
			  }else{
				  @imagedestroy($im); 
				  return false;
			  }
		  
		 }else{
			  @imagedestroy($im); 
			  return false;
		 }
		
   }
   
    //图片水印
    function FileWatermark($im,$filepath){

		   $nowtime=@date("Y-m-d H:i:s");

		   $text=str_replace('{username}',$this->username,PHPAPP::$config['watermarkname']);
		   
		   $text=str_replace('{time}',$nowtime,$text);
	
		   $Imagedata = @GetImageSize($im);
		
			switch ($Imagedata[2]){
				  case 1:
					 $im = @imagecreatefromgif($im);
				  break;
				  case 2:
					 $im = @imagecreatefromjpeg($im);
				  break;
				  case 3:
					 $im = @imagecreatefrompng($im);
				  break;
		   }
	
		   $logo = @imagecreatefrompng(PHPAPP::$config['watermarklogopath']);
		   $logoW = @ImageSX($logo);
		   $logoH = @ImageSY($logo);
		   $imW = @ImageSX($im);
		   
		   
		   if($imW){
		   
				 $imH = @ImageSY($im);
		  
				 if($imW > intval(PHPAPP::$config['watermarkminimum'])){
					   //合成新图
					   if(!intval(PHPAPP::$config['blackwatermark'])){
							  @imagecopyresized($im, $im, 0, 0, 0, 0,$imW, $imH, $imW, $imH+25);	
							  $text=@mb_convert_encoding($text, "UTF-8", "UTF-8,GBK,GB2312,BIG5,ISO-8859-1");
							  $textcolor = @imagecolorallocate($im, 255, 255, 255); //白色
				  
							  @imageTTFText($im,10,0,20,$imH-9,$textcolor,PHPAPP::$config['sitefont'],$text);  
					   }
			  
						//合成新图
						if($Imagedata[2]==3){
							  //PNG
							  @imagecopyresampled($im, $logo, $imW-200, $imH-66, 0, 0,$logoW, $logoH, $logoW, $logoH);	
						}else{
							  @imagecopyresized($im, $logo, $imW-200, $imH-66, 0, 0,$logoW, $logoH, $logoW, $logoH);	
						}
						
			  
				 }
		        
				 switch ($Imagedata[2]){
					  case 1:
					  @imagegif($im,$filepath); 
					  break;
					  case 2:
		              @imagejpeg($im,$filepath,100);  
					  break;
					  case 3:
					  @imagealphablending($im,false);
                      @imagesavealpha($im,true);
					  @imagepng($im,$filepath);     
					  break;
				  }
			
				  @imagedestroy($im);    
				  @imagedestroy($logo); 
			
		   }
		   
	
    }
	
	function UploadAvatar(){
		
		  if(!is_dir(S_ATTACHMENT_DIR.'/avatar')) {
			   @mkdir(S_ATTACHMENT_DIR.'/avatar',0777);
			   $this->WriteFile(S_ATTACHMENT_DIR.'/avatar/index.html','');
		  }	
		  
		  $sitefileform=array("jpg","gif","png");
		  $fileheadertype=array('jpg'=>255216,'gif'=>7173,'png'=>13780);
		  $fileheader=$this->GetFileHeader($this->POST['tmp_name']);
				
		  $fileform=$this->GetFileForm($this->POST['name']); 
		  
		  $is_type=0;
	
		  foreach($sitefileform as $forms){

				 if($fileform==$forms){

						 if($fileheadertype[$forms]==$fileheader){

								  $newfilepath=$this->FilePath(S_UPLOAD_DIR,$forms);
								  
								  @$this->IsPhoto($this->POST['tmp_name'],$newfilepath[2]);
			  
			                      if(file_exists($newfilepath[2])){
									     $this->DelFile($newfilepath[2]);
								         $is_type=1;
								  }else{
									     $is_type=0;
									     $this->DelFile($newfilepath[2]);  
								  }
						 }
	
				 }
					  
		  }
					  
		  if($is_type){			  
		
					$udir=substr($this->uid,-2,2);
					
					$avatar =$udir.'/'.$this->uid.'.'.$fileform;
			  
					$this->Update('member_info',array('avatar'=>$avatar),array(),"WHERE uid='$this->uid'");
					
					$this->MakeBigAvatar($fileform);
					
					$this->MakeMiddleAvatar($fileform);
					
					$this->MakeSmallAvatar($fileform);

		  }else{
			    
				$this->Update('member_info',array('avatar'=>''),array(),"WHERE uid='$this->uid'");
			  
		  }
		  
		
	}
	
	
	//生成大图
	function MakeBigAvatar($fileform){
		  
		  $dir=S_ATTACHMENT_DIR.'/avatar/big';
				  
		  $middle=$this->AvatarPath($dir,$fileform);
				 
		  if(!$this->photothumb($this->POST['tmp_name'],200,200,$middle)){
			      
				  if(!$this->photothumb($this->POST['tmp_name'],120,120,$middle)){
		  		  		return $this->photothumb($this->POST['tmp_name'],48,48,$middle);
				  }
			  
		  }
				  
	}
	
	
	//生成中图
	function MakeMiddleAvatar($fileform){
		  
		  $dir=S_ATTACHMENT_DIR.'/avatar/middle';
				  
		  $middle=$this->AvatarPath($dir,$fileform);
				 
		  if(!$this->photothumb($this->POST['tmp_name'],120,120,$middle)){
			  
		  		  return $this->photothumb($this->POST['tmp_name'],48,48,$middle);
			  
		  }
				  
	}
	
	//生成小图
	function MakeSmallAvatar($fileform){
		
		  //生成小图地址 
		  $dir=S_ATTACHMENT_DIR.'/avatar/small';

		  $middle=$this->AvatarPath($dir,$fileform);
		 
		  return $this->photothumb($this->POST['tmp_name'],48,48,$middle);
		
	}
	
	function AvatarPath($dir,$filetype){
		
		     if(!is_dir($dir)) {
				 @mkdir($dir,0777);
				 $this->WriteFile($dir.'/index.html','');
			 }	 
				 
			 $dir1=substr($this->uid,-2,2);
			 
			 $filedir=$dir.'/'.$dir1;
			 
			 if(!is_dir($filedir)) {
				 @mkdir($filedir,0777);
				 $this->WriteFile($filedir.'/index.html','');
			 }
			 
			 return $filedir.'/'.$this->uid.'.'.$filetype;
	}
	
	
	function GetFileHeader($filename){
			$file= @fopen($filename, "rb");
			$bin= fread($file, 2); 
			fclose($file);
			$strInfo  = @unpack("C2chars", $bin);
			return intval($strInfo['chars1'].$strInfo['chars2']);
    }
	
	function GetFileInfoMIME($filename){
	       $finfo = finfo_open(FILEINFO_MIME);
           $mimetype = finfo_file($finfo, $filename);
           finfo_close($finfo);
		   $mimetypearr=explode(';',$mimetype);
		   return $mimetypearr[0];
	}

}


?>