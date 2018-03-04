<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class  ReportMemberControls extends PHPAPP{
	
    private $POST,$GET;
	
	public $sid;
	
	function __construct(){	 
	 
         parent::__construct();

		 $postkey=array('Submit'=>'');
		 
		 $this->POST=$this->POSTArray();
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','sort'));

		 
		 foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		 }

		 if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
		 
	}
	
	
	public function DefaultAction(){
		
		  return $this->MyReportAction();
		
	}
	
	
	public function MyReportAction(){
		        

			   include_once(Core.'/class/pages_class_phpapp.php');
			   

			   $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=1',"SELECT a.*,b.name,c.appid FROM (".$this->GetTable('report')." AS a JOIN ".$this->GetTable('report_type')." AS b  ON a.type=b.rid) LEFT JOIN ".$this->GetTable('task')." AS c ON a.tid=c.tid  WHERE a.uid='$this->uid' ORDER BY a.dateline DESC");
				 
				 
			   $list=$page->ShowResult();
	

			   include $this->Template('myreport_member');
				 
				

	}
	
	
		
}

?>