<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}



class WebPageMainControls extends PHPAPP{
	
    private $POST,$GET,$errors,$apps;
	
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

		 $this->AboutUsAction();
	}
	
	
	function AboutUsAction(){
		  
		    
			include $this->Template('aboutus');
		
		
	}
	
	function ContactAction(){
		  
		    
			include $this->Template('contact');
		
		
	}

	function LinksAction(){
		    //logo
		    $linklogo=$this->GetMysqlArray('*'," ".$this->GetTable('links')." WHERE logo!='' ORDER BY displayorder ASC");
			
			$linktxt=$this->GetMysqlArray('*'," ".$this->GetTable('links')." WHERE logo='' ORDER BY displayorder ASC");
			
			include $this->Template('links');
		
		
	}
	
    function SiteMapAction(){
		  
		    $apps=$this->GetMysqlArray('b.id_phpapp,b.name_phpapp'," ".$this->GetTable('category')." AS a JOIN  ".$this->GetTable('apps')."  AS b ON a.type=b.id_phpapp  WHERE b.status_phpapp >=0  GROUP BY b.id_phpapp ORDER BY b.displayorder_phpapp ASC");
			
			include $this->Template('sitemap');
		
		
	}
	
	
}

?>