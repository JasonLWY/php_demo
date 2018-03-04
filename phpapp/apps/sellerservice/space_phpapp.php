<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


include_once(Core.'/class/pages_class_phpapp.php');
 
class SellerServiceSpaceControls extends PHPAPP{
	
    private $POST,$GET,$errors;
	
	public $spaceuid,$sid;
	
	function __construct(){	
	
	       parent::__construct();
            
		   $this->spaceuid=empty($_GET['uid']) ? 0 : intval($_GET['uid']);
		   
		   $this->sid=empty($_GET['sid']) ? 0 : intval($_GET['sid']);
		   
		   $postkey=array('Submit'=>'');
			
			
		   $this->POST=$this->POSTArray();
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','total','id','op','real','pay','money','process','draft','credit','dateline','endtime','sort','more','catid'));
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
		   
		   if(!$this->IsSQL('member'," WHERE uid='$this->spaceuid'")){
				 echo $this->Refresh('用户不存在或已被删除!',SURL);
				 exit();
		   }
      
	}
	
	
	function DefaultAction(){

		 $this->ServiceListAction();
	}
	
	function  ServiceListAction(){
		  
		  $page=new Pages(15,$this->GET['page'],'space.php?app='.$this->app.'&action=1&uid='.$this->spaceuid,"SELECT a.*,b.thumb FROM ".$this->GetTable('task_seller_service')." AS a LEFT JOIN ".$this->GetTable('file')." AS b  ON b.fid=a.logo   WHERE a.status=0 AND a.uid='$this->spaceuid' ORDER BY a.dateline DESC");
			 
			 
		  $list=$page->ShowResult();
		 
							
							
		  include $this->Template('service_space');
	
	
	}
	
	
}




?>