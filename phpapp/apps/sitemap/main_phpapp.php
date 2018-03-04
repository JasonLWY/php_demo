<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class SiteMapMainControls extends PHPAPP{
	
	function __construct(){	
	
	       parent::__construct();

	}
	
	function DefaultAction(){
		  
		    $sitenav=$this->GetMysqlArray('*'," ".$this->GetTable('nav')."  ORDER BY displayorder ASC");
			
			include $this->Template('sitemap');
		
	}
	
	
}

?>