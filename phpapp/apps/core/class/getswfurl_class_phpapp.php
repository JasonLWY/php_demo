<?php
/*
	EDOOG.COM (C) 2009-2014 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.5 2012.4.10
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class GetSWFURL{
    
	public $strings;
	
	function __construct($strings){	 
		   
		   $this->strings=$strings;
	}
	
	function GetSWFURLList(){
		   //youku
		   $urlmun=preg_match_all('/\[media\](.*)\[\/media\]/iU',$this->strings,$urlarray);
		   
		   if($urlmun>0){
			    
				   for($i=0;$i<$urlmun;$i++){
				         $this->GetShareSWFURL($urlarray,$i);
				   		 $this->GetYouKuSWFURL($urlarray,$i);
	                     $this->GetTuDouSWFURL($urlarray,$i);
						 $this->GetKU6SWFURL($urlarray,$i);
						 $this->Get56SWFURL($urlarray,$i);
				   }
		   }
		   
		   return $this->strings;
	}
	
	function GetShareSWFURL($urlarray=array(),$key=0){
         
		  $vurl=$urlarray[1][$key];
		  
		  $videoarr=array('wmv','avi','rmvb','mov','swf','flv');

		  $urlarr=explode('.',$vurl);
		  $id=$urlarr[count($urlarr)-1];
		  foreach($videoarr as $video){
			  if($video==$id){
				    $newurl=$this->MakeSWFURL($vurl);
				    $this->strings=str_replace($urlarray[0][$key],$newurl,$this->strings);
			  }
		  }

	}
	
	function GetYouKuSWFURL($urlarray=array(),$key=0){
          
		  //youku.com
		  $vurl=$urlarray[1][$key];
		  if(strpos($vurl,'youku.com')){
			   $urlarr=explode('/',$vurl);
			   //make new url
			   $id=str_replace(array('id_','.html'),'',$urlarr[count($urlarr)-1]);
			   $newurl=$this->MakeSWFURL('http://player.youku.com/player.php/sid/'.$id.'/v.swf');
			   $this->strings=str_replace($urlarray[0][$key],$newurl,$this->strings);
			   
		  }
	}
	
	
	function GetTuDouSWFURL($urlarray=array(),$key=0){
          
		  //tudou.com
		  $vurl=$urlarray[1][$key];
		  if(strpos($vurl,'tudou.com')){
			   $urlarr=explode('/',$vurl);
			   $id=$urlarr[count($urlarr)-2];
			   $newurl=$this->MakeSWFURL('http://www.tudou.com/v/'.$id.'/&resourceId=0_05_05_99&bid=05/v.swf');
			   $this->strings=str_replace($urlarray[0][$key],$newurl,$this->strings);
			   
		  }
	}
	
	function GetKU6SWFURL($urlarray=array(),$key=0){
          
		  //ku6.com
		  $vurl=$urlarray[1][$key];
		  if(strpos($vurl,'ku6.com')){
			   $urlarr=explode('/',$vurl);
			   $id=str_replace(array('.html'),'',$urlarr[count($urlarr)-1]);
			   $newurl=$this->MakeSWFURL('http://player.ku6.com/refer/'.$id.'/v.swf');
			   $this->strings=str_replace($urlarray[0][$key],$newurl,$this->strings);
			   
		  }
	}
	
	
	function Get56SWFURL($urlarray=array(),$key=0){
          
		  //56.com
		  $vurl=$urlarray[1][$key];
		  if(strpos($vurl,'56.com')){
			   $urlarr=explode('/',$vurl);
			   $id=str_replace(array('play_album-aid-9980501_vid-','.html'),'',$urlarr[count($urlarr)-1]);
			   $newurl=$this->MakeSWFURL('http://player.56.com/v_'.$id.'.swf');
			   $this->strings=str_replace($urlarray[0][$key],$newurl,$this->strings);
			   
		  }
	}
	
	function MakeSWFURL($url=''){
		
		  return '<embed src="'.$url.'" allowFullScreen="true" quality="high" width="480" height="400" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>';
	}
	

}


?>