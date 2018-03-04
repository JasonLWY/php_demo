<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class EditorMainControls extends PHPAPP{
	
    private $POST,$GET,$errors;
	
	public $fid;
	
	function __construct(){	
	
	       parent::__construct();
		   
		   $this->fid=empty($_GET['fid']) ? 0 : intval($_GET['fid']);
            
		   
		   $postkey=array('Submit'=>'');
			
			
		   $this->POST=$this->POSTArray();
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op'));
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
			  
		   }
		   
	
		         
	}
	
	function DefaultAction(){
		  if($this->fid>0){
	
				$file=$this->GetMysqlOne('*'," ".$this->GetTable('file')." WHERE fid='$this->fid'");
				if($file){
					  
					 $this->DownFile($file);

				}
				
		  }
	}
	
	function  MusicAction(){
         
		  if($this->uid>0){
			  
			   $oneupfilesize=round(intval(PHPAPP::$config['oneimageuploadsize'])/1024,2);

               $allupfilesize=round(intval(PHPAPP::$config['totalimageuploadsize'])/1024/1024,2);


		       include $this->Template('music');
		  }
	}
	
	function  PhotoAction(){
         
		  if($this->uid>0){
			  
			   $oneupfilesize=round(intval(PHPAPP::$config['oneimageuploadsize'])/1024,2);

               $allupfilesize=round(intval(PHPAPP::$config['totalimageuploadsize'])/1024/1024,2);


		       include $this->Template('photo');
		  }
	}
	
	
	function  FileAction(){
         
		  if($this->uid>0){
			  
			   $oneupfilesize=round(intval(PHPAPP::$config['onefileuploadsize'])/1024,2);

               $allupfilesize=round(intval(PHPAPP::$config['totalfileuploadsize'])/1024/1024,2);
               

		       include $this->Template('file');
		  }
	}
	
	function TempFileUploadAction(){
		    
             $this->uid=intval($_GET['uid']);
			 if($this->uid>0){
				   $member=$this->GetMysqlOne('cookiecode'," ".$this->GetTable('member')." WHERE uid='$this->uid'");
				   
				   if($member['cookiecode']==$_GET['cookiecode'] && $member['cookiecode']){
						 include(Core.'/class/upload_file_phpapp.php');
						 $upload=new Upload(array('uid'=>$this->uid,'type'=>intval($_GET['type'])));
						 $upload->CheckUpload();
				   }
			 }
			
	 }
	 
	 
	 
	 function GetTempPhotoAction(){
		   
		   if($this->uid>0){

			     if($this->GET['op']>0){
					   $fid=$this->ExplodeStrArr($this->POST['fid']);
					   //删除图片
					   $delfile=$this->GetMysqlArray('tmpname,thumb'," ".$this->GetTable('file_temp')." WHERE uid='$this->uid' AND tmpid IN($fid) ");
					   
					   foreach($delfile as $value){
						       $this->DelFile($value['tmpname']);
							   $this->DelFile($value['thumb']);
					   }
					  
					   
					   $this->Delete('file_temp'," WHERE uid='$this->uid' AND tmpid IN($fid) ");
				 }
			     
				 include_once(Core.'/class/pages_ajax_class_phpapp.php');
				  
				 $ajaxpage=new AjaxPages(8,$this->GET['page'],$this->uid,$this->GET['sqlorder'],$this->GET['iforder'],'GetTempPhoto',"SELECT * FROM  ".$this->GetTable('file_temp')." WHERE uid='$this->uid' AND uploadtype='1' ORDER BY dateline DESC");
	  
				 $list=$ajaxpage->ShowResult();
				 
				 include $this->Template('photolist');
		   }
	 }
	 
	 
	 
    function GetFileListAction($filetemp='filelist',$type=0){
		  
		  if($this->uid>0){

			     if($this->GET['op']>0){
					   $fid=$this->ExplodeStrArr($this->POST['fid']);
					   //删除文件
					   $delfile=$this->GetMysqlArray('tmpname'," ".$this->GetTable('file_temp')." WHERE uid='$this->uid' AND tmpid IN($fid) ");
					   
					   foreach($delfile as $value){
						       $this->DelFile($value['tmpname']);
					   }
					  
					   
					   $this->Delete('file_temp'," WHERE uid='$this->uid' AND tmpid IN($fid) ");
				 }
			     
				 include_once(Core.'/class/pages_ajax_class_phpapp.php');
				  
				 $ajaxpage=new AjaxPages(8,$this->GET['page'],$this->uid,$this->GET['sqlorder'],$this->GET['iforder'],'GetTempFile',"SELECT * FROM  ".$this->GetTable('file_temp')." WHERE uid='$this->uid' AND uploadtype='$type' ORDER BY dateline DESC");
	  
				 $list=$ajaxpage->ShowResult();
				 
				 include $this->Template($filetemp);
		   }
	}
 
     function GetTempFileAction(){
		   
		   $this->GetFileListAction('filelist',2);
	 }
	 
	 
	 function GetTempMusicAction(){
		    
			$this->GetFileListAction('musiclist',3);
	 }
	 
	 
	
    function  UsergroupAction(){
         
		if($this->uid>0){
			 $member=$this->GetMysqlOne('cookiecode'," ".$this->GetTable('member')." WHERE uid='$this->uid'");
			 $cookiecode=$member['cookiecode'];
		}else{
			 exit();
		}
		
		$type=empty($_GET['type']) ? 0 : intval($_GET['type']);
		if($type==3){
			 $uploadtype='Music';
		}elseif($type==1){
			 $uploadtype='Image';
		}else{
			 $uploadtype='File';
		}

		$tempfiles=$this->GetMysqlOne(' sum(fsize) AS sizes '," ".$this->GetTable('file_temp')." WHERE uid=".$this->uid." AND uploadtype='$type' ORDER BY tmpid DESC");
		
		 header("Expires: Thu, 01 Jan 1970 00:00:01 GMT");

         header("Cache-Control: no-cache, must-revalidate");

         header("Pragma: no-cache");


		 header('Content-Type: text/xml;charset='.S_CHARSET);
		 
	     echo '<?xml version="1.0" encoding="'.S_CHARSET.'"?>

				<phpapp>

				<item name="ItemFileName"> 
				<language>文件名</language> 
				</item>
				
				<item name="ItemFileSize"> 
				<language>文件大小</language> 
				</item>
				
				<item name="ItemComplete"> 
				<language>上传进度</language>
				</item>
				
				<item name="ItemComplete"> 
				<language>上传进度</language>
				</item>
				
				
				<item name="ItemButtonBrowse">
				<language>浏览</language>
				</item>
				
				<item name="ItemButtonUpload">
				<language>上传</language>
				</item>
				
				<item name="ItemButtonDelete">
				<language>删除</language>
				</item>
				
				<item name="ItemUploadType">
				<language>'.$uploadtype.'</language>
				</item>
				
				<item name="ItemButtonDeleteAll">
				<language>清空</language>
				</item>
				
				<item name="ItemUseSizeLanguage">
				<language>已使用</language>
				</item>
				
				<item name="ItemOneImageUploadSize">
				<language>'.intval(PHPAPP::$config['oneimageuploadsize']).'</language>
				</item>
				
				<item name="ItemTotalImageUploadSize">
				<language>'.intval(PHPAPP::$config['totalimageuploadsize']).'</language>
				</item>
				
				<item name="ItemOneFileUploadSize">
				<language>'.intval(PHPAPP::$config['onefileuploadsize']).'</language>
				</item>
				
				<item name="ItemTotalFileUploadSize">
				<language>'.intval(PHPAPP::$config['totalfileuploadsize']).'</language>
				</item>
				
				<item name="ItemMusicType">
				<language>'.PHPAPP::$config['uploadmusictype'].'</language>
				</item>
				
				<item name="ItemImageType">
				<language>'.PHPAPP::$config['uploadphototype'].'</language>
				</item>
				
				<item name="ItemFileType">
				<language>'.PHPAPP::$config['uploadfiletype'].'</language>
				</item>
				
				<item name="ItemUploadURL">
				<language>'.SURL.'/index.php?app=18&amp;action=4&amp;type='.$type.'&amp;uid='.$this->uid.'&amp;cookiecode='.$cookiecode.'</language>
				</item>
				
				
				<item name="ItemYesLabel">
				<language>确定</language>
				</item>
				
				
				<item name="ItemNoLabel">
				<language>继续</language>
				</item>
				
				<item name="ItemNoLabel">
				<language>继续</language>
				</item>
				
				
				<item name="ItemUploadAllCompleteLanguage">
				<language>全部上传完成</language>
				</item>
				
				
				<item name="ItemUploadCompleteLanguage">
				<language>上传完成</language>
				</item>
				
				
				<item name="ItemUploadProgressLanguage">
				<language>上传进度</language>
				</item>
				
				
				<item name="ItemYouUploadLanguage">
				<language>您上传的</language>
				</item>
				
				
				<item name="ItemImageSizeUploadLanguage">
				<language>图片太大了！图片大小不能超过</language>
				</item>
				
				<item name="ItemFileSizeUploadLanguage">
				<language>文件太大了！文件大小不能超过</language>
				</item>
				
				
				<item name="ItemImageSizeErrorUploadLanguage">
				<language>上传图片容量有误</language>
				</item>
				
				
				<item name="ItemFileSizeErrorUploadLanguage">
				<language>上传文件容量有误</language>
				</item>
				
				<item name="ItemExcuseMeImageErrorUploadLanguage">
				<language>对不起！图片总大小不能超过</language>
				</item>
				
				<item name="ItemExcuseMeFileErrorUploadLanguage">
				<language>对不起！文件总大小不能超过</language>
				</item>
				
				
				<item name="ItemAddFilesUploadLanguage">
				<language>上传文件为空！请浏览添加文件！</language>
				</item>
				
				<item name="ItemFilesUploadLanguage">
				<language>上传数据</language>
				</item>
				
				<item name="ItemTotalUploadLanguage">
				<language>总共上传</language>
				</item>
				
				<item name="ItemOneFileLanguage">
				<language>个文件</language>
				</item>
				
				
				<item name="ItemUploadNowLanguage">
				<language>当前正在上传第</language>
				</item>
				
				<item name="ItemSizeNowLanguage">
				<language>当前总大小</language>
				</item>
				
				<item name="ItemAllowUpload">
				<language>'.$tempfiles['sizes'].'</language>
				</item>

				
				</phpapp>';
	
		
	}
	
	
	function UploadAvatarAction(){
		
		  $this->uid=intval($_GET['uid']);
		  if($this->uid>0){
			  
				 $member=$this->GetMysqlOne('cookiecode'," ".$this->GetTable('member')." WHERE uid='$this->uid'");

				 if($member['cookiecode']==$_GET['cookiecode']){

						include(Core.'/class/photo_upload_phpapp.php');
						$upload=new Upload(array('uid'=>$this->uid));
                        $upload->UploadAvatar();
		
						
				 }
		  }
						 
	}
	
	
	function DownFile($downfile){

		$filetype=$this->GetFileForm($downfile['filename']);
		
		$icons=$this->GetMysqlArray('*'," ".$this->GetTable('file_icon')." ORDER BY fid ASC");
		
	    $ctype='';
		foreach($icons as $value){
			  if($filetype==$value['form']){
				   $ctype=$value['type'];
			  }
		}
		
		if(!$ctype){
		     $ctype="application/force-download";
		}
		
		@header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
		@header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		@header('Cache-Control: max-age=31536000'); 
		@header('Content-Encoding: none');          
		@header('Content-Type: '.$ctype.'');          
		@header('Content-Disposition: attachment; filename="'.$downfile['filename'].'"');  
		@header('Pragma: no-cache');           
		@header('Expires: 0');
        
		if($downfile['ftp']==1){
			  @readfile('ftp://'.PHPAPP::$config['ftp_username'].':'.PHPAPP::$config['ftp_password'].'@'.PHPAPP::$config['ftp_server'].'/'.$downfile['filepath']); 
			  exit();
		}else{
			  $fd = fopen($downfile['filepath'], "rb");         
			  print @fread($fd, filesize($downfile['filepath']));
			  flush();  
		      fclose($fd);
		}
	         
	}
	
}