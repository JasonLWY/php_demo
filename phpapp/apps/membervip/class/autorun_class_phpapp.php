<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(APPS.'/membervip/main_phpapp.php');

class MemberVipAutoControls extends MemberVipMainControls{
	
	private $runarray;
	
	public $lang;
	
	function __construct($runarray=''){	 
	 
		 $this->runarray=$runarray;
		 
		 $this->lang=empty($_GET['lang']) ? 1 : intval($_GET['lang']);

	}
	
	
	function MemberDemote(){
           
		   $uid=intval($this->runarray['uid']);
		   
		   $userarr=$this->GetLoginInfo($uid);
		  
		   $myusergroup=$userarr['usergroup'];
		   
		   $membervipset=$nowusergroup=array();
						   
		   if(PHPAPP::$config['membervip']){
			   
				 $membervipset=unserialize(PHPAPP::$config['membervip']);

				 $nowusergroup=@$membervipset[$userarr[usertype]][$myusergroup];
				 
				 $demote=intval($nowusergroup['demote']);
				 
						 
				 $this->Delete('member_vip'," WHERE uid='$uid' "); 
				 
				 if($demote){
					   $this->Update('member',array('usergroup'=>$demote),array()," WHERE uid='$uid'");
				 }
				 
				 
				 $usergroupname=$this->GetMysqlOne('groupname'," ".$this->GetTable('usergroup')." WHERE gid='$myusergroup'");
				 
				 //sms
				 $this->Insert('member_sms',array(
							   'msggoid'=>$uid, 
							   'msgtoid'=>0,
							   'mailbox'=>1,
							   'new'=>'1',
							   'subject'=>'您购买的VIP过期了',
							   'content'=>'<p>尊敬的用户您好!</p><p>您购买的'.$usergroupname['groupname'].'已过期！重新购买请点 <a href="member.php?&app=26">购买VIP</a></p>',
							   'dateline'=>$this->NowTime()
							   ),
				 array());  
				 
				 
				 //标志-----------------------------------------
				$myinfo=$this->GetMysqlOne('certificate',"  ".$this->GetTable('member_info')." WHERE uid='$uid' ");
				
				$certificates=$this->SetCertificateIcon($myinfo['certificate'],'VIP',1);
								
				$this->Update('member_info',array('certificate'=>$certificates),array(),"WHERE uid='$uid'");
										
				//---------------------------------------------
		   
		   }
		
	}
}

?>