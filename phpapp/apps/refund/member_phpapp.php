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
	
class RefundMoneyMemberControls extends PHPAPP{
	
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
		
		  return $this->MyRefundAction();
		
	}
	
	public function  AddRefundAction(){

		  
		  if($this->cid>0){
		        
				$getprocess=new TaskProcess();
				
				$consumearr=$this->GetMysqlOne('a.*,b.oid,b.tid,b.buyeruid,b.selleruid,b.runid'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('task_order')." AS b ON a.cid=b.cid  WHERE a.cid='$this->cid' AND a.process>2 AND a.process<7 AND b.buyeruid='$this->uid'");
								
						   
				if($this->rid>0){
					   $refund=$this->GetMysqlOne('*'," ".$this->GetTable('refund_money')." WHERE rid='$this->rid' AND buyeruid='$this->uid'");
				}else{
					   
					   $refund=$this->GetMysqlOne('*'," ".$this->GetTable('refund_money')." WHERE cid='$this->cid' AND buyeruid='$this->uid'");
					   
					   if($refund['rid']>0){
						     $this->rid=$refund['rid'];
					   }
					
				}

				
				if($consumearr['cid']>0){
					
					   $sellerarr=$this->GetMysqlOne('uid,username'," ".$this->GetTable('member')." WHERE uid='$consumearr[selleruid]' ");
					   $buyerarr=$this->GetMysqlOne('uid,username'," ".$this->GetTable('member')." WHERE uid='$consumearr[buyeruid]' ");
                       
					   if($this->uid!=$consumearr['buyeruid']){
				
							  $this->Refresh('对不起!您没有权限操作!',SURL.'/member.php?app='.$this->app.'&action=1&cid='.$this->cid.'&rid='.$this->rid.'&op=1');
					   }

					   if($this->POST['submit']){
						      
					   
							  if($this->IsSQL('refund_money',"WHERE cid='$this->cid' AND process=3")){
						
									  $this->Refresh('该订单您已经申请退款并处理过了!',SURL.'/member.php?app='.$this->app.'&action=1');
							  }
										 
						      if($consumearr['process']!=6){
						   
						   
						            $this->POST['money']=floatval($this->POST['money']);	
									$this->POST['content']=$this->str($this->POST['content'],0,0,0,1,0,0,1);	
									
									$consumemoney=$consumearr['amount']+$consumearr['fee'];
									
									if($this->POST['money']> $consumemoney){
										    
										    $this->Refresh('对不起您申请的退款金额不能大于 '.$consumemoney.' 元！',SURL.'/member.php?app='.$this->app.'&action=1&cid='.$this->cid);
									}
				  
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
									
		                           
								   $this->Update('consume',array('refundmoney'=>$this->POST['money'],'process'=>4),array()," WHERE cid='$consumearr[cid]'");
								   
								   $edittxt='';
								   if($this->rid>0){
									    $edittxt='修改了';
								   }
										 
						  		   if($this->rid>0){

										  $this->Update('refund_money',$this->POST,array('dateline'=>$this->NowTime(),'buyeruid'=>$consumearr['buyeruid'],'selleruid'=>$consumearr['selleruid'],'tid'=>$consumearr['tid'],'cid'=>$consumearr['cid'],'oid'=>$consumearr['oid'],'buyerphoto'=>$photoid,'process'=>1)," WHERE rid='$this->rid' AND buyeruid='$this->uid'");
										
								   }else{
									   
										  $this->rid=$this->Insert('refund_money',$this->POST,array('buyeruid'=>$consumearr['buyeruid'],'selleruid'=>$consumearr['selleruid'],'tid'=>$consumearr['tid'],'cid'=>$consumearr['cid'],'oid'=>$consumearr['oid'],'buyerphoto'=>$photoid,'dateline'=>$this->NowTime(),'process'=>1));
										 
									      $autorunarr=$this->GetMysqlOne('*'," ".$this->GetTable('autorun')." WHERE aid='$consumearr[runid]' ");
										  
									      if($autorunarr['aid']>0){
											    
												 //加7天
												 $newruntime=$autorunarr['runtime']+7*24*60*60;
												 
												 $runcode=serialize(array(
														'app'=>49,
														'runtime'=>$newruntime,
														'function'=>'RefundOrder',
														'cid'=>$consumearr['cid']
												 ));
												  
												 $this->Update('autorun',array('runcode'=>$runcode,'runtime'=>$newruntime),array()," WHERE aid='$consumearr[runid]'");
											  
										  }
								   
								   }
								   
								   
								   //上传文件
								   $files=$this->UploadFile();
								   
								   if($files){
										 foreach($files as $fid){
											  $this->Insert('apps_file',array('appid'=>$this->app,'fid'=>$fid,'uid'=>$this->uid,'id'=>$this->rid,'type'=>1),array());
										 }
								   }

								   
								   //通知卖家
								   $send_subject=include $this->LanguageArray('refund','Refund_Buyers_Apply_SMS_Subject',1);
								   $send_content=include $this->LanguageArray('refund','Refund_Buyers_Apply_SMS_Content',1);
				
								   if(PHPAPP::$config['auto_delete_order_notice']){
										$this->Delete('member_notice'," WHERE cid='$this->cid'");
								   }
					  
								   //接口
								   $this->Port(array(
										 
										  'receive_uid'=>$consumearr['selleruid'], //接收人
										  //SMS
										  'sms_subject'=>$send_subject,
										  'sms_content'=>$send_content,
										  'sms_cid'=>$this->cid,
														
										  //EMail
										  'email_title'=>$send_subject,
										  'email_content'=>$send_content,
										  
										  //Mobile
										  'mobile_content'=>$send_subject
											
													
								   ),19);
												   
								   
								    $this->Refresh('申请退款成功!',SURL.'/member.php?app='.$this->app.'&action=1&cid='.$this->cid.'&rid='.$this->rid.'&op=1');
								   
							  }else{
								  
								    $this->Refresh('对不起！订单目前状态不能操作退款申请!',SURL.'/member.php?app='.$this->app.'&action=1&cid='.$this->cid.'&rid='.$this->rid.'&op=1');
							  }
								   
									   
					   }else{
					   
							   
					           $refunditemarr=$this->GetMysqlOne('*'," ".$this->GetTable('refund_item')." WHERE status=0 AND pid='$refund[pid]' ");
							   					   
							   if($this->op>0){
									
								   
								     include $this->Template('process_member');
									 
									 
							   }else{
							   
		                             if($consumearr['process']==6){
										   include $this->Template('process_member');
									 }else{
										   
										   if($this->IsSQL('refund_money',"WHERE cid='$this->cid' AND process=3")){

									              $this->Refresh('该订单您已经申请退款并处理过了!',SURL.'/member.php?app='.$this->app.'&action=1');
							               }
									 
										   $refunditemarr=$this->GetMysqlArray('*'," ".$this->GetTable('refund_item')." WHERE status=0");
							   		 	   include $this->Template('addrefund_member');
									 }
							   
							   }
					   
					   }
				
				}else{
					
					   $this->Refresh('对不起！订单目前状态不能操作退款申请！',SURL.'/member.php?app=43');
				}
		   
		   
		  }else{
			  
			    $this->DefaultAction();
			  
		  }
	}
	
	
	public function ReceivedRefundAction(){
            
			
			$getprocess=new TaskProcess();
			
			$consumearr=$this->GetMysqlOne('a.*,b.oid,b.tid,b.buyeruid,b.selleruid,b.runid'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('task_order')." AS b ON a.cid=b.cid  WHERE a.cid='$this->cid' AND a.process>2 AND a.process<7 AND b.selleruid='$this->uid'");
			
			$refund=$this->GetMysqlOne('*'," ".$this->GetTable('refund_money')." WHERE cid='$this->cid' AND selleruid='$this->uid'");
			
			if($refund['rid']>0){
				   $this->rid=$refund['rid'];
		    }		
			
			
			 
			if($this->rid>0){
                 
				 $sellerarr=$this->GetMysqlOne('uid,username'," ".$this->GetTable('member')." WHERE uid='$consumearr[selleruid]' ");
				 $buyerarr=$this->GetMysqlOne('uid,username'," ".$this->GetTable('member')." WHERE uid='$consumearr[buyeruid]' ");
                 
				  				 
				  if($this->uid!=$consumearr['selleruid']){
				
					   $this->Refresh('对不起!您没有权限操作!',SURL.'/member.php?app='.$this->app.'&action=1&cid='.$this->cid.'&rid='.$this->rid.'&op=1');
				  }

				 if($this->POST['submit'] || $this->POST['disagree']){
					  

					  if($this->IsSQL('refund_money',"WHERE rid='$this->rid' AND process=3")){
							 $this->Refresh('该退款已处理过了!',SURL.'/member.php?app='.$this->app.'&action=2&cid='.$this->cid.'&rid='.$this->rid.'&op=1');
					  }
								 
					  if($consumearr['process']!=6){
						  
						   if($this->POST['submit']){
								$dealrefund=3;
						   }elseif($this->POST['disagree']){
								$dealrefund=2;
						   }
						   
						   //echo $dealrefund;
						   
						   //exit();
						   
						   $this->Delete('autorun'," WHERE aid='$consumearr[runid]'");
	
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
						   
						   $this->Update('refund_money',$this->POST,array('endtime'=>$this->NowTime(),'sellerphoto'=>$photoid,'process'=>$dealrefund)," WHERE rid='$this->rid' AND selleruid='$this->uid'");
						   
						   $files=$this->UploadFile();
									   
						   if($files){
								 foreach($files as $fid){
									  $this->Insert('apps_file',array('appid'=>$this->app,'fid'=>$fid,'uid'=>$this->uid,'id'=>$this->rid,'type'=>1),array());
								 }
						   }
						   
						   if($dealrefund==3){
							   //退款
							   require_once(APPS.'/order/member_phpapp.php');
			  
							   $order=new OrderMemberControls();
							   $order->PayTaskOrder($consumearr['cid'],1);
							   
							   
							   //成功
							   //通知卖家
							   $send_subject=include $this->LanguageArray('refund','Refund_Seller_Agree_SMS_Subject',1);
							   $send_content=include $this->LanguageArray('refund','Refund_Seller_Apply_SMS_Content',1);
							   
							   if(PHPAPP::$config['auto_delete_order_notice']){
										$this->Delete('member_notice'," WHERE cid='$this->cid'");
							   }
			
							   //接口
							   $this->Port(array(
									 
									  'receive_uid'=>$consumearr['buyeruid'], //接收人
									  //SMS
									  'sms_subject'=>$send_subject,
									  'sms_content'=>$send_content,
									  'sms_cid'=>$this->cid,
													
									  //EMail
									  'email_title'=>$send_subject,
									  'email_content'=>$send_content,
									  
									  //Mobile
									  'mobile_content'=>$send_subject
										
												
							   ),19);
						   
						   }else{
							     //不同意
							     //客服介入
								 if(!$this->IsSQL('refund_money',"WHERE rid='$this->rid' AND serviceuid>0")){
									 
										 $serviceuser=$this->GetMysqlArray('*'," ".$this->GetTable('customer_service')." ORDER BY dateline ASC");    			 
									
										 $suid=intval($serviceuser[0]['uid']);
									   
										 if(!$suid){
											  $suid=1;
										 }else{
										 	  $this->Update('customer_service',array('dateline'=>$this->NowTime()),array(),"WHERE uid='$suid'");
										 }
									   
										 $this->Update('refund_money',array('serviceuid'=>$suid),array()," WHERE rid='$this->rid' AND selleruid='$this->uid' ");
								 
								 }
								
								 
							     //通知雇主
							
							     $send_subject=include $this->LanguageArray('refund','Refund_Seller_Disagree_SMS_Subject',1);
							     $send_content=include $this->LanguageArray('refund','Refund_Seller_Disagree_SMS_Content',1);
							     
							     $this->Port(array(
									 
									  'receive_uid'=>$consumearr['buyeruid'], //接收人
									  //SMS
									  'sms_subject'=>$send_subject,
									  'sms_content'=>$send_content,
									  'sms_cid'=>$this->cid,
													
									  //EMail
									  'email_title'=>$send_subject,
									  'email_content'=>$send_content,
									  
									  //Mobile
									  'mobile_content'=>$send_subject
										
												
							     ),19);
							   
						   }
										   
						   
						   $this->Refresh('处理退款成功!',SURL.'/member.php?app='.$this->app.'&action=2&cid='.$this->cid.'&rid='.$this->rid.'&op=1');
					  }else{
							
						   $this->Refresh('对不起！订单目前状态不能操作退款申请！',SURL.'/member.php?app='.$this->app.'&action=2&cid='.$this->cid.'&rid='.$this->rid.'&op=1');
					  }
				
				 }else{
					  
					  $refunditemarr=$this->GetMysqlOne('*'," ".$this->GetTable('refund_item')." WHERE status=0 AND pid='$refund[pid]' ");

					  if($this->op>0){
					  		include $this->Template('process_member');
					  }else{
						    
							if($consumearr['process']==6){
								 include $this->Template('process_member');
							}else{
								 
								 if($this->IsSQL('refund_money',"WHERE rid='$this->rid' AND process=3")){
								  		$this->Refresh('该退款已处理过了!',SURL.'/member.php?app='.$this->app.'&action=2&cid='.$this->cid.'&rid='.$this->rid.'&op=1');
							     }
								 
								 include $this->Template('dealrefund_member');
							}
					  }
				 }
			
			
			}else{
				 include_once(Core.'/class/pages_class_phpapp.php');
						   
				   $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=1',"SELECT a.*,b.*,c.username,c.uid FROM (".$this->GetTable('refund_money')." AS a JOIN ".$this->GetTable('refund_item')." AS b ON a.pid=b.pid) JOIN ".$this->GetTable('member')." AS c ON c.uid=a.buyeruid  WHERE a.selleruid='$this->uid' ORDER BY a.dateline DESC");
						 
					 
				  $list=$page->ShowResult();
			   
				  include $this->Template('receivedlist_member');
				
			}

	}
	
	
	public function MyRefundAction(){
		
		  include_once(Core.'/class/pages_class_phpapp.php');
			   
		  $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=1',"SELECT a.*,b.*,c.username,c.uid FROM (".$this->GetTable('refund_money')." AS a JOIN ".$this->GetTable('refund_item')." AS b ON a.pid=b.pid) JOIN ".$this->GetTable('member')." AS c ON c.uid=a.selleruid  WHERE a.buyeruid='$this->uid' ORDER BY a.dateline DESC");
			 
			 
		  $list=$page->ShowResult();
	   
		  include $this->Template('mylist_member');	  
			 
	}
	
	
}

?>