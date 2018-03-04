<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	
if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//อ๘ีพสืาณ
class DefaultMainControls extends PHPAPP{
	
	
	function __construct(){	
	
	       parent::__construct();
		  
	}
	
	
	public function DefaultAction(){
          global $iswap;
          
		  $citysql='';
		  
		  if($this->nowcity>0){
		        $nowcity=$this->GetCategoryAllId('category_city',$this->nowcity);

				if($nowcity){
				     $citysql=" AND cityid IN($nowcity)";
				}
		  }
		  

		  if(!@empty($iswap)){
			     
				 if($this->IsWap()){
					   include $this->AppsView('default');
				 }else{
			           include $this->Template('wap');
				 }
				
			  
		  }else{ 

		         include $this->Template('default');
		   
		  }
		
	}
	
	
}




?>