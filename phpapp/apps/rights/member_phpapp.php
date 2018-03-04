<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}
	
require_once(APPS.'/apppay/class/process_class_phpapp.php');
	
class RightsMemberControls extends PHPAPP{
	
	public $POST,$GET,$errors;
	
	public $cid,$rid,$op;
	
	function __construct(){	 
	 
		 parent::__construct();
		 
		 $this->cid=empty($_GET['cid']) ? 0 : intval($_GET['cid']);
		 $this->rid=empty($_GET['rid']) ? 0 : intval($_GET['rid']);
		 $this->op=empty($_GET['op']) ? 0 : intval($_GET['op']);
		 
		 $postkey=array('Submit'=>'','submit'=>'','disagree'=>'');
				
	     $this->POST=$this->POSTArray();
	   
	     $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','sid','op','tid','sort','agree'));
	   
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
		
		  return $this->MyRightsAction();
		
	}
	
	public function  AddRightsAction(){
		  
		  if($this->cid>0){
			  

					$getprocess=new TaskProcess();
					
					$consumearr=$this->GetMysqlOne('a.*,b.oid,b.tid,b.buyeruid,b.selleruid,b.runid'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('task_order')." AS b ON a.cid=b.cid  WHERE a.cid='$this->cid' AND a.process=5 AND b.buyeruid='$this->uid'");
					
					//认证
					$selleruid=$consumearr['selleruid'];
					$issellersecurity=0;
					if($this->IsSQL('member_security_certificate'," WHERE sid=1 AND uid='$selleruid' ")){
						 $issellersecurity=1;
					}
					
							   
					if($this->rid>0){
						   $refund=$this->GetMysqlOne('*'," ".$this->GetTable('rights')." WHERE rid='$this->rid' AND buyeruid='$this->uid'");
					}else{
						   
						   $refund=$this->GetMysqlOne('*'," ".$this->GetTable('rights')." WHERE cid='$this->cid' AND buyeruid='$this->uid'");
						   
						   if($refund['rid']>0){
								 $this->rid=$refund['rid'];
						   }
						
					}
					
					if($consumearr['cid']>0){
						
						   $sellerarr=$this->GetMysqlOne('uid,username'," ".$this->GetTable('member')." WHERE uid='$consumearr[selleruid]' ");
						   $buyerarr=$this->GetMysqlOne('uid,username'," ".$this->GetTable('member')." WHERE uid='$consumearr[buyeruid]' ");
						   
						   if($this->uid!=$consumearr['buyeruid']){
				
							      $this->Refresh('对不起!您没有权限操作!',SURL.'/member.php?app='.$this->app.'&action=1');
					       }
						   
						   //维权时间
						   $rightsendtime=$consumearr['dateline']+intval(PHPAPP::$config['orders_rights_date'])*24*60*60;
						   
						   if($this->POST['submit']){
							   
							      if($this->IsSQL('rights',"WHERE cid='$this->cid' AND process=3")){
						
										$this->Refresh('该订单您已经申请维权并处理过了!',SURL.'/member.php?app='.$this->app.'&action=1');
								  }
										 
								  if($rightsendtime > $this->NowTime()){
	
	
										$this->POST['content']=$this->str($this->POST['content'],0,0,0,1,0,0,1);	
										
										include_once(Core.'/class/photo_upload_phpapp.php');
			
						  
										 if($_FILES['buyerphoto']['size']>0){
											   
											   $photoid=empty($refund['buyerphoto']) ? 0 : intval($refund['buyerphoto']);
											   
											   $upload=new UploadPhoto($_FILES['buyerphoto'],$photoid);
											   $photoid=$upload->CheckUpload();
											   
										 }else{
											   
											   if(!empty($refund['buyerphoto'])){
													 
													 $photoid=intval($refund['buyerphoto']);
												   
												   
											   }
											  
										 }
										
			 
									   $edittxt='';
									   if($this->rid>0){
											$edittxt='修改了';
									   }
											 
									   if($this->rid>0){
	
											  $this->Update('rights',$this->POST,array('dateline'=>$this->NowTime(),'buyeruid'=>$consumearr['buyeruid'],'selleruid'=>$consumearr['selleruid'],'tid'=>$consumearr['tid'],'cid'=>$consumearr['cid'],'oid'=>$consumearr['oid'],'buyerphoto'=>$photoid,'process'=>1)," WHERE rid='$this->rid' AND buyeruid='$this->uid'");
											
									   }else{
										   
											  $this->rid=$this->Insert('rights',$this->POST,array('buyeruid'=>$consumearr['buyeruid'],'selleruid'=>$consumearr['selleruid'],'tid'=>$consumearr['tid'],'cid'=>$consumearr['cid'],'oid'=>$consumearr['oid'],'buyerphoto'=>$photoid,'dateline'=>$this->NowTime(),'process'=>1));
											 
									   
									   }
									   
									   
									   //上传文件
									   $files=$this->UploadFile();
									   
									   if($files){
											 foreach($files as $fid){
												  $this->Insert('apps_file',array('appid'=>$this->app,'fid'=>$fid,'uid'=>$this->uid,'id'=>$this->rid,'type'=>1),array());
											 }
									   }
	
									   
									   //通知卖家
									   $send_subject='订单流水号 '.$consumearr['serial'].$edittxt.' 维权申请!';
									   $send_content='雇主 '.$buyerarr['username'].' 申请了维权!<a href="'.SURL.'/member.php?app='.$this->app.'&action=2&cid='.$this->cid.'&rid='.$this->rid.'&op=1" target="_blank">[查看详细]</a>';
					
									   //接口
									   $this->Port(array(
											 
											  'receive_uid'=>$consumearr['selleruid'], //接收人
											  //SMS
											  'sms_subject'=>$send_subject,
											  'sms_content'=>$send_content,
															
											  //EMail
											  'email_title'=>$send_subject,
											  'email_content'=>$send_content,
											  
											  //Mobile
											  'mobile_content'=>$send_subject
												
														
									   ),18);
									   
									  
									  if(!$this->IsSQL('rights',"WHERE rid='$this->rid' AND serviceuid>0")){
										 
											 $serviceuser=$this->GetMysqlArray('*'," ".$this->GetTable('customer_service')." ORDER BY dateline ASC");    			 
										
											 $suid=intval($serviceuser[0]['uid']);
										   
											 if(!$suid){
												  $suid=1;
											 }else{
										   
												  $this->Update('customer_service',array('dateline'=>$this->NowTime()),array(),"WHERE uid='$suid'");
											 
											 }
										 
											 $this->Update('rights',array('serviceuid'=>$suid),array()," WHERE rid='$this->rid' AND buyeruid='$this->uid' ");
									 
									  }
							
													   
									   
									  $this->Refresh('申请维权成功!',SURL.'/member.php?app='.$this->app.'&action=1&cid='.$this->cid.'&rid='.$this->rid.'&op=1');
								
								}else{
									   $this->Refresh('对不起！维权时间已超过'.PHPAPP::$config['orders_rights_date'].'天不能再申请维权！',SURL.'/member.php?app=42');
								}	 
										   
						   }else{
						   
								   
								   $refunditemarr=$this->GetMysqlOne('*'," ".$this->GetTable('security_item')." WHERE status=0 AND sid='$refund[sid]' ");
													   
								   if($this->op>0){
	
										 include $this->Template('process_member');
	
								   }else{
									   
	                                      
										 if($consumearr['process']==6){
										      include $this->Template('process_member');
									     }else{
										 
											  if($this->IsSQL('rights',"WHERE cid='$this->cid' AND process=3")){
							
													$this->Refresh('该订单您已经申请维权并处理过了!',SURL.'/member.php?app='.$this->app.'&action=1');
											  }
											
											
											  $refunditemarr=$this->GetMysqlArray('*'," ".$this->GetTable('security_item')." WHERE status=0");
											  include $this->Template('addrights_member');
										 }
	
								   }
						   
						   }
									  
							
					}else{
						
						   $this->Refresh('对不起！订单目前状态不能操作申请维权！',SURL.'/member.php?app=42');
					}
					
					
					      
		   
		  }else{
			  
			    $this->DefaultAction();
			  
		  }
	}
	
	
	public function ReceivedRightsAction(){

			
			$getprocess=new TaskProcess();
			
			$consumearr=$this->GetMysqlOne('a.*,b.oid,b.tid,b.buyeruid,b.selleruid,b.runid'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('task_order')." AS b ON a.cid=b.cid  WHERE a.cid='$this->cid' AND a.process=5 AND b.selleruid='$this->uid'");
			
			$refund=$this->GetMysqlOne('*'," ".$this->GetTable('rights')." WHERE cid='$this->cid' AND selleruid='$this->uid'");
			
			if($refund['rid']>0){
				   $this->rid=$refund['rid'];
		    }		
			 
			if($this->rid>0){
                 
				 $sellerarr=$this->GetMysqlOne('username'," ".$this->GetTable('member')." WHERE uid='$consumearr[selleruid]' ");
				 $buyerarr=$this->GetMysqlOne('uid,username'," ".$this->GetTable('member')." WHERE uid='$consumearr[buyeruid]' ");

				  if($this->uid!=$consumearr['selleruid']){
			
						$this->Refresh('对不起!您没有权限操作!',SURL.'/member.php?app='.$this->app.'&action=1&cid='.$this->cid.'&rid='.$this->rid.'&op=1');
				  }
					  
				 $rightsendtime=$consumearr['dateline']+7*24*60*60;
					   
				 if($this->POST['submit']){
	
					  
					  if($this->IsSQL('rights',"WHERE rid='$this->rid' AND process=3")){
							
							 $this->Refresh('该维权已处理过了!',SURL.'/member.php?app='.$this->app.'&action=2&cid='.$this->cid.'&rid='.$this->rid.'&op=1');
					  }
							
					  if($rightsendtime > $this->NowTime()){
					 
						   $this->POST['content']=$this->str($this->POST['content'],0,0,0,1,0,0,1);	
					 
						   include_once(Core.'/class/photo_upload_phpapp.php');
			
						  
							 if($_FILES['sellerphoto']['size']>0){
								   
								   $photoid=empty($refund['sellerphoto']) ? 0 : intval($refund['sellerphoto']);
								   
								   $upload=new UploadPhoto($_FILES['sellerphoto'],$photoid);
								   $photoid=$upload->CheckUpload();
								   
							 }else{
								   
								   if(!empty($refund['sellerphoto'])){
										 
										 $photoid=intval($refund['sellerphoto']);
									   
									   
								   }
								  
							 }
						   
						   $this->Update('rights',$this->POST,array('endtime'=>$this->NowTime(),'sellerphoto'=>$photoid,'process'=>2)," WHERE rid='$this->rid' AND selleruid='$this->uid'");
						   
						   $files=$this->UploadFile();
									   
						   if($files){
								 foreach($files as $fid){
									  $this->Insert('apps_file',array('appid'=>$this->app,'fid'=>$fid,'uid'=>$this->uid,'id'=>$this->rid,'type'=>1),array());
								 }
						   }
						   
						   
 
							 //通知雇主
						
							 $send_subject='订单流水号 '.$consumearr['serial'].' 卖家威客发表了维权!';
							 $send_content='卖家威客 '.$sellerarr['username'].' 发表了维权! 相关要求请联系客服工作人员处理 <a href="'.SURL.'/member.php?app='.$this->app.'&action=1&cid='.$this->cid.'&rid='.$this->rid.'&op=1" target="_blank">[查看详细]</a>';
							 
							 $this->Port(array(
								 
								  'receive_uid'=>$consumearr['buyeruid'], //接收人
								  //SMS
								  'sms_subject'=>$send_subject,
								  'sms_content'=>$send_content,
												
								  //EMail
								  'email_title'=>$send_subject,
								  'email_content'=>$send_content,
								  
								  //Mobile
								  'mobile_content'=>$send_subject
									
											
							 ),18);
							   		   
						   
						     $this->Refresh('发表维权成功!',SURL.'/member.php?app='.$this->app.'&action=2&cid='.$this->cid.'&rid='.$this->rid.'&op=1');
						   
	               	   }else{
							 $this->Refresh('对不起！维权时间已超过7天不能再申请维权！',SURL.'/member.php?app=42');
					   }	
				
				 }else{
					  
					  $refunditemarr=$this->GetMysqlOne('*'," ".$this->GetTable('security_item')." WHERE status=0 AND sid='$refund[sid]' ");

					  if($this->op>0){
					  		include $this->Template('process_member');
					  }else{
						  
						    if($this->IsSQL('rights',"WHERE rid='$this->rid' AND process=3")){
							
								  $this->Refresh('该维权已处理过了!',SURL.'/member.php?app='.$this->app.'&action=2&cid='.$this->cid.'&rid='.$this->rid.'&op=1');
							}
							
							include $this->Template('dealrights_member');
					  }
				 }
			
			
			}else{
				  include_once(Core.'/class/pages_class_phpapp.php');
						   
				  $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=1',"SELECT a.*,b.*,c.username,c.uid FROM (".$this->GetTable('rights')." AS a JOIN ".$this->GetTable('security_item')." AS b ON a.sid=b.sid) JOIN ".$this->GetTable('member')." AS c ON c.uid=a.buyeruid  WHERE a.selleruid='$this->uid' ORDER BY a.dateline DESC");
						 
					 
				  $list=$page->ShowResult();
			   
				  include $this->Template('receivedlist_member');
				
			}

	}
	
	
	public function MyRightsAction(){
		
		  include_once(Core.'/class/pages_class_phpapp.php');
			   
		  $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=1',"SELECT a.*,b.*,c.username,c.uid FROM (".$this->GetTable('rights')." AS a LEFT JOIN ".$this->GetTable('security_item')." AS b ON a.sid=b.sid) JOIN ".$this->GetTable('member')." AS c ON c.uid=a.selleruid  WHERE a.buyeruid='$this->uid' ORDER BY a.dateline DESC");
			 
			 
		  $list=$page->ShowResult();
	   
		  include $this->Template('mylist_member');	  
			 
	}
	
	
}

?>