<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class MakeTaskAddressUrl extends PHPAPP{
	  
	  public $POST,$GET,$errors;

	  function __construct() {
		     parent::__construct();
	  }
	  
	  function GetTaskAddress($tid,$did,$app,$string){
			if($app){
				   $this->app=$app;
			}
			if(S_REWRITE_URL){
				  
					  $this->GetApps();
					  $this->GetAction($this->app);
					  include(SYS.'/data/cache/config/apps.php');
					  $approute=$apps[$this->app]['route_phpapp'];
					  
					  if($did>0){
							return  '/'.$approute.'/tid-'.$tid.'-did-'.$did.'.html';
					  }else{
							return  '/'.$approute.'/tid-'.$tid.'.html';
					  }
					 
						  
			  }else{
					  if($did>0){
						   return '/index.php?app='.$this->app.'&tid='.$tid.'&did='.$did;
					  }else{
						   return '/index.php?app='.$this->app.'&tid='.$tid;
					  }
			  }
	  }
	  
	  
	  function GetServiceAddress($sid,$uid,$app,$string){
			if($app){
				   $this->app=$app;
			}

			if(S_REWRITE_URL){
				  
					  $this->GetApps();
					  $this->GetAction($this->app);
					  include(SYS.'/data/cache/config/apps.php');
					  include(SYS.'/data/cache/config/apps_'.$this->app.'_action.php');
	 
					  $approute=$apps[$this->app]['route_phpapp'];
	
					  $actionroute=$appsaction['3.1']['route_phpapp'];

			          return '/'.$approute.'/sid-'.$sid.'.html';

			  }else{
					  return '/index.php?app='.$this->app.'&sid='.$sid;
			  }
	  }
	 		
}


?>