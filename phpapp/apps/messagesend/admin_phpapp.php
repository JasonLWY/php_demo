<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class MessageSendManageControls extends PHPAPP{
	
    public $actionmenu,$POST,$GET;
	
	function __construct($actionmenu=''){	
           
		   parent::__construct();
		   
	       $this->actionmenu=$actionmenu;
		   
		   $postkey=array('Submit'=>'','checkbox'=>'');
		   
		   $this->GET=$this->GETArray();
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->GET[$key])){
				   $this->GET[$key]='';
			   }
		   }
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','action'));
		         
	}
	
	function DefaultAction(){
		
		  return $this->SendAction();
	}
	
	
	function SendAction(){
		  
		  $membertypearr=$this->GetMysqlArray('*'," ".$this->GetTable('member_type')."");
		  $usergrouparr=$this->GetMysqlArray('*',"".$this->GetTable('usergroup')." ");
        
		  if(!empty($this->GET['Submit']) || !empty($this->GET['page'])){
			  
                 if($_GET['content'] && $_GET['subject']){
					 
					   $nownum=empty($_GET['nownum']) ? 1 : intval($_GET['nownum']);
					      
					   $subject=$this->str(urldecode($_GET['subject']),300,1,0,1,0,0,1);
					   
					   $content=$this->str(urldecode($_GET['content']),0,1,0,0,0,0,1);
					   
					   $wheresql='';
					   
					   if($this->GET['useridtype']==1){
						     
							  if($_GET['userid']){
								      
									  $userid=$this->ExplodeStrArr($_GET['userid']);
									  
									  $wheresql.=' a.uid IN('.$userid.')';
								  
							  }
						  
					   }elseif($this->GET['useridtype']==2){
						     
						     if($this->GET['userid1'] && $this->GET['userid2']){
								    
									  $wheresql.=' a.uid>='.intval($this->GET['userid1']) .' AND a.uid<='.intval($this->GET['userid2']);
								  
							  }
						   
					   }
					   
					  if($this->GET['membertype']){
						     
							  if($wheresql){
								   
									$wheresql.= ' AND a.usertype='.intval($this->GET['membertype']);
									
							  }else{
								  
						            $wheresql.= ' a.usertype='.intval($this->GET['membertype']);
							  
							  }
						  
					  }
					  
					  if($this->GET['usergroup']){
						      
							  if($wheresql){
								    $wheresql.= ' AND a.usergroup='.$this->GET['usergroup'];
							  }else{
						            $wheresql.= ' a.usergroup='.$this->GET['usergroup'];
							  }
						  
					  }
					  
					  if($wheresql){
						  
						   $wheresql='WHERE '.$wheresql;
					  }

					  $send=$this->GET['sendnum'];
					  
					  $sqlnum=$this->IsSQL('member',"  AS a JOIN ".$this->GetTable('member_info')." AS b ON a.uid=b.uid $wheresql");
					  
					  if(!$sqlnum){
						  
						    echo $this->Refresh('<p>没有发送用户！</p>','?menu='.intval($_GET['menu']).'&app='.$this->app.'&action='.$this->ac);
						  
					  }else{
					        
							$limit='';
							
							if($this->GET['page']){
								
								 $page=$this->GET['page'];
								 
							}else{
								 $page=0;
							}
							
							if($sqlnum>$send){
							     
								 $total=@ceil($sqlnum/$send);
							
							}else{
								
								 $total=1;
							}
							
							$limit=' LIMIT '.$page.','.$send;
							
					
							$memberarr=$this->GetMysqlArray('a.uid,a.safeemail,b.mobile'," ".$this->GetTable('member')." AS a JOIN ".$this->GetTable('member_info')." AS b ON a.uid=b.uid  $wheresql ORDER BY uid ASC $limit ");
							
							if($memberarr){
						
								 
								   if($this->GET['sendtype']==1){

										 include(APPS.'/sms/class/port_class_phpapp.php');
										  
										 $sms=new SMSPort();
							
										 foreach($memberarr as $member){
											     
												 $sms->SendSMS(array(
																	'sms_msggoid'=>$member['uid'],
																	'sms_msgtoid'=>0,
																	'sms_mailbox'=>1,
																	'sms_subject'=>$subject,
																	'sms_content'=>$content
																	 ));
										 }
									      
									   
								   }elseif($this->GET['sendtype']==2){
									   
									       include(Core.'/class/sms_class_phpapp.php');
						  
										   $mobile=new MobileSMS();
									   
									       foreach($memberarr as $member){
											   
                                                 if(is_numeric($member['mobile'])){ 
												        $mobile->SendSMS($member['mobile'],$subject,$member['uid']);
												 }
											   
										   }
									   
									   
									   
								   }elseif($this->GET['sendtype']==3){
									      
										   include(Core.'/class/filter_class_phpapp.php');
										   
										   $filter=new CharFilter();

										   foreach($memberarr as $member){

												if($filter->CheckStringEmail($member['safeemail'])){ 
												 
												       $this->SendMail($member['safeemail'],$subject,$content);
												
												}
												
										   }
										   
									   
								   }
								   
								   echo $this->Refresh('<p>共有 <strong>'.$total.'</strong> 次发送,正在发送第 <strong>'.$nownum.'</strong> 次,请不要关闭浏览器或窗口！</p>',$this->MakeGetParameterURL(array('useridtype'=>$this->GET['useridtype'],'userid'=>$userid,'userid1'=>$this->GET['userid1'],'userid2'=>$this->GET['userid2'],'membertype'=>$this->GET['membertype'],'usergroup'=>$this->GET['usergroup'],'content'=>$this->str($content,0,0,1,0,0,1),'subject'=>urldecode($subject),'sendnum'=>$send,'page'=>$page+$send,'nownum'=>$nownum+1)));
								   
							}else{
								  
								   echo $this->Refresh('<p>发送完毕！</p>','?menu='.intval($_GET['menu']).'&app='.$this->app.'&action='.$this->ac);
							}
							
							
					  }
					  

				 }else{
					   
					   echo $this->Refresh('<p>请输入标题或内容！</p>','?menu='.intval($_GET['menu']).'&app='.$this->app.'&action='.$this->ac);
				 }
			     
				  exit();
		  
		  }else{
			  
            
		  
		         include $this->Template('send_manage');
		  }
	}
	

}


?>