<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class SiteNoticeMemberControls extends PHPAPP{
	
    private $POST,$GET;
	
	public  $page,$nid;
	
	
	function __construct(){	 
	 
		 parent::__construct();
		 
		 $this->nid=empty($_GET['nid']) ? 0 : intval($_GET['nid']);
		 
		 $this->POST=$this->POSTArray();
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','sort','sid'));

		 
		 if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
		 
	}
	
	
	public function DefaultAction(){
		
		  return $this->NoticeListAction();
		
	}
	
	
	public function NoticeListAction(){


		  if($this->POST['Submit']){
                   $nids=$this->ExplodeStrArr($this->POST['nid']);
				
				   if($nids){
				   		$this->Delete('member_notice'," WHERE nid IN($nids) AND uid='$this->uid' ");
				   }else{
					    $this->Delete('member_notice'," WHERE uid='$this->uid' ");
				   }
				   
				   echo '<p>É¾³ý³É¹¦!</p>';
			 
				   echo $this->CloseNowWindows('#loading',1);
				  
		  }else{
			  
                 include_once(Core.'/class/pages_class_phpapp.php');

				 $page=new Pages(10,$this->GET['page'],SURL.'/member.php?app='.$this->app.'&action=1',"SELECT * FROM ".$this->GetTable('member_notice')."  WHERE uid='$this->uid' OR uid=0 ORDER BY dateline DESC");
				   
				 $list=$page->ShowResult();
	  
	  
				 include $this->AppsView('noticelist_member');
		  }
		   
	}
	
	
	public function ShowAction(){
	
		  $noticearr=$this->GetMysqlOne('*'," ".$this->GetTable('member_notice')." WHERE nid='$this->nid' AND uid='$this->uid'");
		  
		  if(empty($noticearr['nid'])){
			     header("location: member.php?app=45&action=1");
		  }
		  
		  include $this->AppsView('show_member');
	}
	
}

?>