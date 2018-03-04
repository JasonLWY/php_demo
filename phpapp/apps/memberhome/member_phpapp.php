<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//Manage
class MemberHomeMemberControls extends PHPAPP{
	
	function __construct(){	 
		   
		 parent::__construct();
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id'));
		 
		 
		 if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
	}
	
	
	public function DefaultAction(){
		
		
		  return $this->IndexManageAction();
		
	}
	
	
	public function IndexManageAction(){
		
		   $user=$this->GetMysqlOne('c.residecity,b.usertype,b.username,b.uid,b.dateline AS regtime,b.logintime,c.certificate,d.credit,credits,credittype,c.themes,d.money,d.lock,d.wealth,d.union,f.tasknum,f.draftnum,f.successnum',"  (((".$this->GetTable('member')." AS b LEFT JOIN ".$this->GetTable('member_info')." AS c ON b.uid=c.uid)																																																																LEFT JOIN ".$this->GetTable('member_account')." AS d ON b.uid=d.uid) LEFT JOIN ".$this->GetTable('task_total')." AS f ON b.uid=f.uid ) LEFT JOIN ( SELECT type AS credittype,credit AS credits,uid FROM ".$this->GetTable('credit')." WHERE type=2 ) AS e ON b.uid=e.uid WHERE b.uid='$this->uid' ");
		   
		   
		   $moneylock=0;
		   
		   //¶³½á
		   $consume=$this->GetMysqlOne('sum(amount) AS moneyout ',"  ".$this->GetTable('consume')." AS a JOIN  ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE b.uid='$this->uid' AND a.paytype=4 AND a.process<5 ");
		   
		   $moneylock=floatval($consume['moneyout']);
		   
		   
		   include $this->AppsView('home_member');
	}
	

	
	
}

?>