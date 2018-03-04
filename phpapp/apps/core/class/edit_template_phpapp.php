<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//edit template
class EditTemplate extends PHPAPP{
	
    public $template_dir,$template_file,$cache_file,$template_content,$dir_phpapp; 

	
	function __construct($appdir=''){
		
		parent::__construct();
		
		global $appclass;

		if($appdir){
			 
			  $this->dir_phpapp=$appdir;
			 
		}else{
			
	          $this->dir_phpapp=$appclass['dir_phpapp'];
		
		}
		
	
		if(!is_dir(SYS.'/templates/'.S_TEMPLATE.'/')){
			   echo S_TEMPLATE.'Ä£°å²»´æÔÚ';
			   exit();
			 
		}
		
        $this->template_file=SYS.'/templates/'.S_TEMPLATE.'/'.PHPAPP::$config['templatepath'].'/';
		$this->template_dir=$this->template_file.$this->dir_phpapp.'/';

		
	}
	
	function TemplateDIR(){
		   global $appclass;
		   return '/templates/'.S_TEMPLATE.'/'.PHPAPP::$config['templatepath'].'/'.$this->dir_phpapp.'/';
	}
	

	function TemplateList(){
		
		
		  $filearray=$this->ReadSysDir($this->template_dir);
		  
		  $newarray=array();
		  
		  $readme=$this->FileGetContents($this->template_file.'phpapp_template.txt');
		  
		  $newreadmearray=array();
		  
		  if($readme){

			   $readmearray=explode("\n",$readme);
			    
			   foreach($readmearray as $value){
				      if($value){
						
				            $newreadmearray[]=explode('|',$value);
					  }
			   }
				
		  }
		  
		  if($filearray){
				foreach($filearray as $value){
					  $fileform=$this->GetFileForm($value['filename']);
					  
					  if($fileform=='htm'){
						     
							 foreach($newreadmearray as $txt){
								   if(!empty($txt[1])){
				
										 if(trim($txt[1])==$value['filename'] && $this->dir_phpapp==trim($txt[0])){
											   $value=array_merge($value,array('filereadme'=>trim($txt[2]),'usesystem'=>trim($txt[3])));
										 }
								   }
							 }
						     
							 $newarray[]=$value;
					  }
				}
				
				return $newarray;
		  
		  }else{
			    return array();
		  }
	}
	
		
	function GetTemplate($file=''){

		  $fp = @fopen($this->template_dir.$file,'r');
		  $content = @fread($fp,@filesize($this->template_dir.$file));
		  fclose($fp);
		  
		  $content = str_replace('</textarea','<-/textarea',$content);
		  $content = str_replace('</form','<-/form',$content);
		  
		  return $content;
		  
	}
	
	function SaveTemplate($post=array()){
		 
		   if($post['filename']){
			   
			     $isajax=empty($_SERVER['HTTP_X_REQUESTED_WITH']) ? '' : $_SERVER['HTTP_X_REQUESTED_WITH'];
								
				 if($isajax=='XMLHttpRequest'){

						$content=stripslashes($this->ConvertStr($_POST['content']));
					 
				 }else{
						$content=stripslashes($_POST['content']);
				 }  
				 

				 $content = str_replace('<-/textarea','</textarea',$content);
				 $content = str_replace('<-/form','</form',$content);
	
			     $this->WriteFile($this->template_dir.$post['filename'],$content);
			   
		   }
		 
	}
    
}

?>