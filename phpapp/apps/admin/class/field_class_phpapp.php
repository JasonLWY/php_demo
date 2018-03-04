<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}



class FieldManage extends PHPAPP{
	

	
	function __construct(){	 
	
		
	}
	
	//х╚╡©╤ах║
	public function GetFieldAll(){
		
	     $edoogcopy=$this->Date("Y",$this->NowTime());
		 
		 
		 
		 
		 
		 
		 include $this->Template('admin');
	}
		
	
	
}



?>