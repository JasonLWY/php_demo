<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//�ƹ�
class UnionMainControls extends PHPAPP{
	
	private $POST,$GET;
	
	
	function __construct(){	
	       
		   parent::__construct();
	       
		   
		   if($this->uid<1){
			     $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		   }
		   
		    $postkey=array('Submit'=>'');
			
			
		   $this->POST=$this->POSTArray();
		   
		   $this->GET=$this->GetArray(array('op'));
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
	}
	
	
	public function DefaultAction(){
		 
		
		    $this->HomeAction();
		
	}
	
	
	public function HomeAction(){
		 
		   $member=$this->GetMysqlOne('a.*,b.union'," ".$this->GetTable('member')." AS a JOIN ".$this->GetTable('member_account')." AS b ON a.uid=b.uid WHERE a.uid='$this->uid'");
		   
		   $usergroup=$member['usergroup'];
		   
		   //����
		   $service=$this->GetMysqlArray('*'," ".$this->GetTable('prop')." AS a JOIN ".$this->GetTable('union')." AS b ON a.sid=b.service_phpapp WHERE a.status=0 AND b.status_phpapp=0 AND a.usergroup='$usergroup'  GROUP BY a.sid");
		   
		   
		    //���濪ʼ -------------------------------------------------------------------------
		   
		      
		   $noticelist=$this->GetMysqlArray('*'," ".$this->GetTable('help')." WHERE catid='100' ORDER BY dateline DESC LIMIT 0,4");
		   
		   
		   
		   //���ֿ�ʼ -------------------------------------------------------------------------
		   
		      
		   $paylist=$this->GetMysqlArray('*'," ".$this->GetTable('help')." WHERE catid='101' ORDER BY dateline DESC LIMIT 0,4");
		   
		   
		   //���Ͽ�ʼ -------------------------------------------------------------------------
		   
		      
		   $guaranteelist=$this->GetMysqlArray('*'," ".$this->GetTable('help')." WHERE catid='103' ORDER BY dateline DESC LIMIT 0,4");
		   
		   
	
		   //���Ͽ�ʼ -------------------------------------------------------------------------
		   
		   $rulelist=$this->GetMysqlArray('*'," ".$this->GetTable('help')." WHERE catid='105' ORDER BY dateline DESC LIMIT 0,4");
		   
		   
		   //�ƹ���������
		   $uniontop=$this->GetMysqlArray('a.union,b.username,b.uid'," ".$this->GetTable('member_account')." AS a JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid ORDER BY a.union DESC LIMIT 0,10");
		   
		   
		   //��̬
		   $unionfeed=$this->GetMysqlArray('*'," ".$this->GetTable('member_feed')." WHERE app='20' ORDER BY dateline DESC LIMIT 0,10");
		   
		
		   include $this->Template('home');
	}
	
	
	public function LinkAction(){
		
		  
		   include $this->Template('link');
		
	}
	
	
	public function PhotoAction(){
		
		  
		   include $this->Template('photo');
		
	}
	
	
	
	public function EMailAction() {
		   
		   $member=$this->GetMysqlOne('*'," ".$this->GetTable('member')." WHERE uid='$this->uid'");
			
		   if($this->GET['op']){
			   
				if($this->POST['email']){
					  
					  $email=str_replace(';',',',$this->POST['email']);
					  
					  $emailarr=explode(',',$email);
					  
					  include_once(Core.'/class/filter_class_phpapp.php');
					  
					  $num=count($emailarr);
					  
					  $errornum=0;
					 
					  $filter= new CharFilter();
					
				      $emailcode=include $this->LanguageArray('union','emailcode',1);

					  foreach($emailarr as $value){
						      
		 												  
							  if($filter->CheckStringEmail($value)){
								  
								     
								         $this->SendMail($value,$member['username'].'������һ�������񲢼�Ϊ����',$emailcode,$member['safeemail']);
								  
								  
							  }else{
								    $errornum+=1;
								    echo $value.' �����ʽ����!<br />';
							  }
					  }
					  
					  if($num==$errornum){
						    echo '����ʧ��!<br />';
					  }else{
					        echo '���ͳɹ�!<br />';
					  }
					  echo $this->CloseNowWindows('#loading');
					
				}else{
					
					 echo '����д����!<br />';
					 echo $this->CloseNowWindows('#loading');
					
				}
			    
				
				
			   
		   }else{

				 include $this->Template('email');
				 
		   }
		
	}
	
}




?>