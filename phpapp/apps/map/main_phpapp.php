<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class MapMainControls extends PHPAPP{
	
    private $POST,$GET,$errors;
	
	
	function __construct(){	
	
	       parent::__construct();
		   
		   
		   $postkey=array('Submit'=>'');
			
			
		   $this->POST=$this->POSTArray();
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','total','catid','hid'));
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
      
	}
	
	function DefaultAction(){

		 $this->ShowMapAction();
	}
	
	
	function ShowMapAction(){
		  

			include $this->Template('showmap');
		
		
	}
	
	
	function SetMapAction(){
   
		  
		  include $this->Template('setmap');
	}

}

?>