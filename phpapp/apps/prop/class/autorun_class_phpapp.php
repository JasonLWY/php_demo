<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class PropAutoControls extends PHPAPP{
	
	private $post,$allow,$senddata,$receiveuid;
	
	function __construct($senddata=array()){	 
		 
		 $this->senddata=$senddata;
		 
		 $this->allow=$this->senddata['allow'];
		 
		 $this->post=unserialize($this->senddata['zipcode']);
		 
		 $this->receiveuid=intval($this->post['receive_uid']);     
	}
	
	function PropEnd(){
		
		    $uid=intval($this->senddata['uid']);
		    
			$tid=intval($this->senddata['tid']);
			
			$did=intval($this->senddata['did']);
			
		    $sid=intval($this->senddata['sid']);
		   
		    $propid=intval($this->senddata['propid']);
			
			$proparr=$this->GetMysqlOne('appid,type,day'," ".$this->GetTable('prop')." WHERE sid='$propid' ");
			
			$memberarr=$this->GetMysqlOne('username'," ".$this->GetTable('member')." WHERE uid='$uid' ");
			
			$send_subject='<p>尊敬的'.$memberarr['username'].',您的购买增值服务过期了！</p>';
			
			//type 0 任务 1稿件 2 服务
			if($proparr['type']==1){
				  
				  $taskarr=$this->GetMysqlOne('appid,url'," ".$this->GetTable('task')." WHERE tid='$tid' ");
				  //稿件

				  if($proparr['appid']==62){
		
						 //SetPropFlashTask
						 $this->Update('task_draft',array('openflash'=>0),array(),"WHERE did='$did' ");
	
			             $send_content='<p>您购买的闪烁服务已到期！<a href="'.SURL.'/index.php?app='.$taskarr['appid'].'&tid='.$tid.'&did='.$did.'" target="_blank"><span class="show_details">[查看稿件]</span></a></p>';
				  }
				  
		
				  if($proparr['appid']==63){
		
						//SetPropDefaultTop
						$this->Update('task_draft',array('topbid'=>0),array(),"WHERE did='$did' ");
					    $send_content='<p>您购买的推荐置顶服务已到期！<a href="'.SURL.'/index.php?app='.$taskarr['appid'].'&tid='.$tid.'&did='.$did.'" target="_blank"><span class="show_details">[查看稿件]</span></a></p>';
				  }
				  
		
				  if($proparr['appid']==64){
		
						//HideDraft
						$this->Update('task_draft',array('share'=>0),array(),"WHERE did='$did'");
						$send_content='<p>您购买的隐藏稿件服务已到期！<a href="'.SURL.'/index.php?app='.$taskarr['appid'].'&tid='.$tid.'&did='.$did.'" target="_blank"><span class="show_details">[查看稿件]</span></a></p>';
						
				  }
				  

			}elseif($proparr['type']==2){
				
				  $taskarr=$this->GetMysqlOne('url'," ".$this->GetTable('task_seller_service')." WHERE sid='$sid' ");
				  
				  //服务
				  
				  if($proparr['appid']==60){
						//NoSearch
						$this->Update('task_seller_service',array('robots'=>0),array(),"WHERE sid='$sid'");
						$send_content='<p>您购买的屏蔽搜索引擎服务已到期！<a href="'.SURL.$taskarr['url'].'" target="_blank"><span class="show_details">[查看服务]</span></a></p>';
				  }
				  
		
				  if($proparr['appid']==62){
		
						 //SetPropFlashTask
						 $this->Update('task_seller_service',array('openflash'=>0),array(),"WHERE sid='$sid' ");
						 $send_content='<p>您购买的闪烁服务已到期！<a href="'.SURL.$taskarr['url'].'" target="_blank"><span class="show_details">[查看服务]</span></a></p>';
				  }
				  
		
				  if($proparr['appid']==63){
		
						//SetPropDefaultTop
						$this->Update('task_seller_service',array('topbid'=>0),array(),"WHERE sid='$sid' ");
						$send_content='<p>您购买的推荐置顶服务已到期！<a href="'.SURL.$taskarr['url'].'" target="_blank"><span class="show_details">[查看服务]</span></a></p>';
				  }
				  
		
				  if($proparr['appid']==71){
		
						//RealNameTask
						$this->Update('task_seller_service',array('realnametask'=>0),array(),"WHERE sid='$sid'");
						$send_content='<p>您购买的实名认证服务已到期！<a href="'.SURL.$taskarr['url'].'" target="_blank"><span class="show_details">[查看服务]</span></a></p>';
				  }
				  
		
				  if($proparr['appid']==72){
		
						//SetMapLocation
						$this->Update('task_seller_service',array('longitude'=>0,'latitude'=>0,'mapzoom'=>0),array()," WHERE sid='$sid'");	
						$send_content='<p>您购买的地图定位服务已到期！<a href="'.SURL.$taskarr['url'].'" target="_blank"><span class="show_details">[查看服务]</span></a></p>';
				  }

				
			}else{
				
				  $taskarr=$this->GetMysqlOne('url'," ".$this->GetTable('task')." WHERE tid='$tid' ");
				  
				  //任务
				  if($proparr['appid']==60){
						//NoSearch
						$this->Update('task',array('robots'=>0),array(),"WHERE tid='$tid'");
						$send_content='<p>您购买的屏蔽搜索引擎服务已到期！<a href="'.SURL.$taskarr['url'].'" target="_blank"><span class="show_details">[查看任务]</span></a></p>';
				  }
				  
		
				  if($proparr['appid']==62){
		
						 //SetPropFlashTask
						 $this->Update('task',array('openflash'=>0),array(),"WHERE tid='$tid'");
						 $send_content='<p>您购买的闪烁服务已到期！<a href="'.SURL.$taskarr['url'].'" target="_blank"><span class="show_details">[查看任务]</span></a></p>';
				  }
				  
		
				  if($proparr['appid']==63){
		
						//SetPropDefaultTop
						$this->Update('task',array('topbid'=>0),array(),"WHERE tid='$tid'");	 
			            $send_content='<p>您购买的推荐置顶服务已到期！<a href="'.SURL.$taskarr['url'].'" target="_blank"><span class="show_details">[查看任务]</span></a></p>';
				  }
				  
		
				  if($proparr['appid']==64){
		
						//HideDraft
						$this->Update('task',array('hidedraft'=>0),array(),"WHERE tid='$tid'");
						$send_content='<p>您购买的隐藏任务稿件内容服务已到期！<a href="'.SURL.$taskarr['url'].'" target="_blank"><span class="show_details">[查看任务]</span></a></p>';
						
				  }
				  
				  if($proparr['appid']==53){
		
						//HideTask
						 $this->Update('task',array('hide'=>0),array(),"WHERE tid='$tid'");
						 $send_content='<p>您购买的隐藏任务内容服务已到期！<a href="'.SURL.$taskarr['url'].'" target="_blank"><span class="show_details">[查看任务]</span></a></p>';
				  }
				  
		
				  if($proparr['appid']==71){
		
						//RealNameTask
						$this->Update('task',array('realnametask'=>0),array(),"WHERE tid='$tid'");
						$send_content='<p>您购买的实名认证服务已到期！<a href="'.SURL.$taskarr['url'].'" target="_blank"><span class="show_details">[查看任务]</span></a></p>';
				  }
				  
		
				  if($proparr['appid']==72){
		
						//SetMapLocation
						$this->Update('task',array('longitude'=>0,'latitude'=>0,'mapzoom'=>0,'cityid'=>0),array()," WHERE tid='$tid'");	
						$send_content='<p>您购买的地图定位服务已到期！<a href="'.SURL.$taskarr['url'].'" target="_blank"><span class="show_details">[查看任务]</span></a></p>';
				  }
				  
				  
				  if($proparr['appid']==74){
		
						//AllowTender
						$this->Update('task',array('allowtender'=>0),array(),"WHERE tid='$tid'");
						$send_content='<p>您购买的限制投标服务已到期！<a href="'.SURL.$taskarr['url'].'" target="_blank"><span class="show_details">[查看任务]</span></a></p>';
				  }
				
				
			}
			
			
			
			//通知--------------------------------------------------------------
			 
			 if($send_subject && $send_content){
					  //接口
					  $this->Port(array(
							  
							  'receive_uid'=>$uid, //接收人
							  
							  //SMS
							  'sms_subject'=>$send_subject,
							  'sms_content'=>$send_content,
											
							  //EMail
							  'email_title'=>$send_subject,
							  'email_content'=>$send_content,
		
							  //Mobile
							  'mobile_content'=>$send_subject
								
										
					  ),23);

			 }
			 
			 //通知 end--------------------------------------------------------------
			
		
	}
	
}

?>