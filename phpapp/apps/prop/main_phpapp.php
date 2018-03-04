<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class PropMainControls extends PHPAPP{
	
    private $POST,$GET;
	
	public $sid;
	
	function __construct(){	 
	 
         parent::__construct();
		 
		 
		 $this->sid=empty($_POST['sid']) ? 0 : intval($_POST['sid']);
		 
		 $postkey=array('Submit'=>'');
		 
		 $this->POST=$this->POSTArray();
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','sort','type','props','type'));

		 
		 foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		 }
         
		 /*
		 if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 */
		 
		 
	}
	
	
	public function DefaultAction(){

		  return $this->UsePropAction();
		
	}
	
	
	public function UsePropAction(){
		
		    if($this->uid<1){
				 echo '<p>您未登录无法显示增值服务信息,请登录后点击 <a href="javascript:void(0)" title="获取增值服务" onclick="GetServiceList();"><strong>[获取增值服务]</strong></a></p>';
			}else{
				 
				 $type=$this->GET['type'];
				 
				 $props=$this->ExplodeStrArr($_GET['props']);

				 $user=$this->GetMysqlOne('a.*,b.usergroup'," ".$this->GetTable('member_account')." AS a JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid WHERE b.uid='$this->uid'");

				 $servicelist=$this->GetMysqlArray('*'," ".$this->GetTable('prop')." WHERE sell='0' AND type='$type' AND status=0 AND  usergroup='$user[usergroup]' ORDER BY displayorder ASC ");
				
				 //已购买的
				 $myservice=$this->GetMysqlArray('*'," ".$this->GetTable('prop_order')." WHERE uid='$this->uid' AND process=1 AND amount>0");
				
				 include $this->Template('useprop');
			}
	
	}
	
		
		
}

?>