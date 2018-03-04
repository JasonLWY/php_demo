<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(APPS.'/taskmode/public_phpapp.php');

class AllSiteFeedProp extends TaskPublicClass{

	
	function __construct(){	 
	      parent::__construct();
	}
	
	function PropAction($service){
			
			 if($service['serviceid']){ //������
			       $feedtype='����';
			       $taskarr=$this->GetMysqlOne('*'," ".$this->GetTable('task_seller_service')." WHERE sid='$service[sid]' ");
			 }elseif($service['tid']){
				   $feedtype='����';
			 	   $taskarr=$this->GetMysqlOne('*'," ".$this->GetTable('task')." WHERE tid='$service[tid]' ");
			 }

             $feedarray=array(
							//Feed
							
							'feed_uid'=>$this->uid,
							'feed_username'=>$this->username,
							'feed_app'=>$this->app,
							'feed_action'=>$this->ac,
							'feed_title_template'=>'������ <a href="'.SURL.$taskarr['url'].'" target="_blank" title="'.$taskarr['subject'].'">{title}</a> '.$feedtype,
							'feed_title_data'=>$taskarr['subject'],
							'feed_content_template'=>'',
							'feed_content_data'=>$taskarr['content']

							
				);
			 
		    
			$this->AddTaskFeed($feedarray);

	}
	
	
}


?>