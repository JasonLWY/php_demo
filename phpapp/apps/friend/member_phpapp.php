<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class FriendMemberControls extends PHPAPP{
	
    private $POST,$GET;
	
	function __construct(){	 
	 
		 parent::__construct();

		 $this->POST=$this->POSTArray();
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','sort'));
		 
		 if($this->uid<1){
			   $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
		 
	}
	
	
	public function DefaultAction(){
		
		  return $this->ShowFriendAction();
		
	}

	
	public function ShowFriendAction(){
		
		   $fuid=$this->GetMyFriend($this->uid);
		   
		   if($fuid){
		
				 include_once(Core.'/class/pages_class_phpapp.php');
	  
				 $page=new Pages(32,$this->GET['page'],'member.php?app='.$this->app.'&action=1',"SELECT a.username,a.* FROM ".$this->GetTable('member')." AS a LEFT JOIN  ".$this->GetTable('member_info')." AS b ON a.uid=b.uid  WHERE  a.uid IN($fuid) ");
						 
						 
				 $list=$page->ShowResult();
	
		   
		   }
		   
		   include $this->Template('showfriend_member');
		
		
	}
	
	
	public function MyRequestAction(){
		
		   
		   if($this->GET['op']==1){
			   
                           $fuid=$this->ExplodeStrArr($this->POST['fuid']);
						   $idarray=explode(',',$fuid);
					
						   foreach($idarray as $value){

								  $this->Delete('member_friend'," WHERE uid='$this->uid' AND fuid='$value' AND status=0 ");

						   }
						   
						   echo '撤销成功!<br />';
				          
						   echo $this->CloseNowWindows('#loading',1);			     

		
		   }else{
                 
				 include_once(Core.'/class/pages_class_phpapp.php');
	  
				 $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=1',"SELECT b.message,b.dateline,a.username,b.fuid,c.* FROM (".$this->GetTable('member')." AS a LEFT JOIN ".$this->GetTable('member_friend')." AS b ON a.uid=b.fuid ) LEFT JOIN  ".$this->GetTable('member_info')." AS c ON b.fuid=c.uid  WHERE b.uid='$this->uid' AND status=0 ");
						 						 
				 $list=$page->ShowResult();

				 include $this->Template('myrequest_member');
	       }
		
		
	}
		
		
	public function UserRequestAction(){
		
		   
		   if($this->GET['op']==1){
			   
                           $uid=$this->ExplodeStrArr($this->POST['uid']);
						   $idarray=explode(',',$uid);
					
						   foreach($idarray as $value){
                                  
								  if(!$this->IsSQL('member_myfriend',"WHERE uid='$this->uid' AND fuid='$value'")){
									  
									     $this->Insert('member_myfriend',array('uid'=>$this->uid,'fuid'=>$value),array());
									  
								  }
								  
								  if(!$this->IsSQL('member_myfriend',"WHERE fuid='$this->uid' AND uid='$value'")){
								  
								         $this->Insert('member_myfriend',array('fuid'=>$this->uid,'uid'=>$value),array());
								  }
								  
								  $this->Update('member_friend',array('status'=>1),array()," WHERE fuid='$this->uid' AND uid='$value' AND status=0 ");

						   }
						   
						   echo '批准成功!<br />';
				          
						   echo $this->CloseNowWindows('#loading',1);			     

		
		   }else{

				 include_once(Core.'/class/pages_class_phpapp.php');
	  
				 $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=1',"SELECT b.message,b.dateline,a.username,b.fuid,c.* FROM (".$this->GetTable('member')." AS a LEFT JOIN ".$this->GetTable('member_friend')." AS b ON a.uid=b.uid ) LEFT JOIN  ".$this->GetTable('member_info')." AS c ON b.uid=c.uid  WHERE b.fuid='$this->uid' AND status=0 ");
						 						 
				 $list=$page->ShowResult();

				 include $this->Template('userrequest_member');
	       }
		
		
	}
	
	
	
}

?>