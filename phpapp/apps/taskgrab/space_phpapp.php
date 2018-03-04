<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include(APPS.'/apppay/class/process_class_phpapp.php');

include_once(Core.'/class/pages_class_phpapp.php');
 
class TaskGrabSpaceControls extends PHPAPP{
	
    private $POST,$GET,$errors;
	
	public $spaceuid;
	
	function __construct(){	
	
	       parent::__construct();
            
		   $this->spaceuid=empty($_GET['uid']) ? 0 : intval($_GET['uid']);
		   
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

		 $this->TaskAction();
	}
	
	function  TaskAction(){
		  

          $page=new Pages(15,$this->GET['page'],'space.php?app='.$this->app.'&action=1&uid='.$this->spaceuid,"SELECT * FROM ".$this->GetTable('task_grab')." WHERE process>3 AND uid='$this->spaceuid' GROUP BY tid ORDER BY dateline DESC");
			 
			 
		  $taskgrab=$page->ShowResult();
         
							
							
		  include $this->Template('task_space');
	}
	
	
	function DraftAction(){
		
		  $page=new Pages(10,$this->GET['page'],'space.php?app='.$this->app.'&action=2&uid='.$this->spaceuid,"SELECT * FROM ".$this->GetTable('task_grab_draft')." WHERE uid='$this->spaceuid' AND process=1  ORDER BY did DESC");
			 
			 
		  $list=$page->ShowResult();
		
		  
		  $getprocess=new TaskProcess();
		   
		  include $this->Template('draft_space');
	}
	
	function TransactionAction(){
		  
		  $taskcount=$this->GetMysqlOne('*'," ".$this->GetTable('task_grab_count')." WHERE uid='$this->spaceuid'");
		  
			
		  if($this->GET['op']==1){
			  

			  $order=' AND a.level=0 ';
			  
			  
		  }elseif($this->GET['op']==2){
			  
			  
			  
			  $order=' AND a.level=1 ';
			  
		  }elseif($this->GET['op']==3){
			  
			  
			  $order=' AND a.level=2 ';
			  
			  
		  }else{
			   //全部
               $order='';
			  
		  } 

		
		  $page=new Pages(10,$this->GET['page'],'space.php?app='.$this->app.'&action=3&uid='.$this->spaceuid.'&op='.$this->GET['op'],"SELECT a.*,b.tid,tsubject,c.username FROM  (".$this->GetTable('task_grab_order_credit')." AS a LEFT JOIN ( SELECT subject AS tsubject,tid FROM  ".$this->GetTable('task_grab')." WHERE uid='$this->spaceuid' )AS b ON a.tid=b.tid ) LEFT JOIN ".$this->GetTable('member')." AS c ON a.uid=c.uid  WHERE a.uid!='$this->spaceuid' AND a.type=1  $order");
			 
			 
		  $list=$page->ShowResult();
		
		  
		  include $this->Template('transaction_space');
	}
	
}




?>