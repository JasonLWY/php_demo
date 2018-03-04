<?php
/*
	EDOOG.COM (C) 2009-2014 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.12
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class CityClass extends PHPAPP{
   
    public $citynexts,$catidid,$citysubarray;

	function __construct(){	 
         
		 parent::__construct();

	}

	function UpdateCitySubclassID($catid=0){
		
		  set_time_limit(0);
		  
		  $cityarray=$this->GetMysqlArray('*'," ".$this->GetTable('category_city')." WHERE upid='$catid'");
		  
		  if($cityarray){
			     foreach($cityarray as $citys){
						$this->GetCitySubclassID($citys['upid'],$citys['catid']);
					    $this->UpdateCitySubclassID($citys['catid']);
				 }
		  }
				
	}
		
	function GetCitySubclassID($catid=0){
		 
		   set_time_limit(0);
			
		   $cityarray=$this->GetMysqlArray('*'," ".$this->GetTable('category_city')." WHERE upid='$catid'");

		 
           if($cityarray){
			     foreach($cityarray as $citys){
					 
					    $citysubarray=$this->GetMysqlArray('*'," ".$this->GetTable('category_city')." WHERE upid='$citys[catid]'");

						if($this->citynexts){
							 $this->citynexts.=','.$citys['catid'];

						}else{
							 $this->catidid=$citys['catid'];
							 $this->citynexts.=$citys['catid'];
						}
   
						if(is_array($citysubarray)){
							  
					           foreach($citysubarray as $citysubs){
					           		$this->citynexts.=','.$citysubs['catid'];
									
									$cityarray2=$this->GetMysqlArray('*'," ".$this->GetTable('category_city')." WHERE upid='$citysubs[catid]'");

							        if($cityarray2){
										   foreach($cityarray2 as $citysubs2){
											   
											      $this->citynexts.=','.$citysubs2['catid'];
												  
												  $cityarray3=$this->GetMysqlArray('*'," ".$this->GetTable('category_city')." WHERE upid='$citysubs2[catid]'");
												  
												  if($cityarray3){
										   				foreach($cityarray3 as $citysubs3){
															  $this->citynexts.=','.$citysubs3['catid'];
														}
												  }
												  
										   }
									}
									
							   }
							
						}

						$this->Update('category_city',array('nexts'=>$this->citynexts),array(),"WHERE catid='$this->catidid'");
						
						$this->citynexts=$this->catidid='';

						
				 }
				 
	
				 
		   }
		   unset($cityarray);
		   unset($citysubarray);
		   
	}
	
	
}



?>