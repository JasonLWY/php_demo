<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class FeedPort extends PHPAPP{
	
	public $post;
	
	function __construct($post){	 
	      parent::__construct();
		  $this->post=$post;
		  $this->PortAction();  
	}
	
	function PortAction(){

		   if(!empty($this->post['feed_uid'])){

				  $title_template=$this->str($this->post['feed_title_template'],255,1,0,0,0,1);
				  $title=$this->str($this->post['feed_title_data'],255,1,0,1,0,1);
				  $content=$this->str($this->post['feed_content_data'],100,1,0,1,0,1);
			   
				  $this->Insert('member_feed',array(
												   'uid'=>$this->post['feed_uid'], 
												   'username'=>$this->post['feed_username'],
												   'app'=>$this->post['feed_app'],
												   'action'=>$this->post['feed_action'],
												   'title_template'=>$title_template,
												   'title_data'=>$title,
												   'content_template'=>$this->post['feed_content_template'],
												   'content_data'=>$content,
												   'dateline'=>$this->NowTime()
												   ),
								array());  
				  
				 //UC
				 
				 if($uclient=$this->GetClient()){
					 
					   $feedarr=array('icon'=>'phpapp_'.$this->post['feed_app'],'uid'=>$this->post['feed_uid'],'username'=>$this->post['feed_username'],'title_template'=>$title_template,'body_template'=>$content);    
					  
					   $feedarr['title_data'] = array('username'=>$this->post['feed_username'],'title'=>$title);
				  
					   @$uclient->feed_add($feedarr);
					   
				 }
	
		  }

		 
	}
	
	
}


?>