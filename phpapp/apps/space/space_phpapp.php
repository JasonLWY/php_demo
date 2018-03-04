<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class SpaceSpaceControls extends PHPAPP{
	
    private $POST,$GET,$errors;
	
	public $spaceuid;
	
	function __construct(){	
	
	       parent::__construct();
		   
            
		   $this->spaceuid=empty($_GET['uid']) ? 0 : intval($_GET['uid']);

		   
		   $postkey=array('Submit'=>'');
			
			
		   $this->POST=$this->POSTArray();
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','op'));
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }

      
	}
	
	
	function DefaultAction(){

		 $this->HomeAction();
	}
	
	
	function HomeAction(){
		    
			include_once(Core.'/class/skill_class_phpapp.php');
		   
		    $skilldata=new SkillClass();
				
			$member=$this->GetMysqlOne('usertype,skills,userpost'," ".$this->GetTable('member')." WHERE uid='$this->spaceuid'");
			if(!$member){
				 echo $this->Refresh('用户不存在或已被删除!',SURL);
				 exit();
			}
			
			$skillsarr=$skilldata->GetSkillURL($member['skills']);
					
		    $spacefeed=$this->GetMysqlArray('*'," ".$this->GetTable('member_feed')." WHERE uid='$this->spaceuid'  ORDER BY dateline DESC LIMIT 0,15");
			
			$memberinfo=$this->GetMemberInfo($member['usertype']);
			
			$myfriend=$this->GetMysqlArray('b.uid,b.username,c.avatar'," (".$this->GetTable('member_myfriend')." AS a JOIN ".$this->GetTable('member')." AS b ON a.fuid=b.uid) JOIN ".$this->GetTable('member_info')." AS c ON a.fuid=c.uid  WHERE a.uid='$this->spaceuid'  ORDER BY b.dateline DESC LIMIT 0,18");
			

			$myvisit=$this->GetMysqlArray('b.uid,b.username,c.avatar'," (".$this->GetTable('member_visit')." AS a JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid) JOIN ".$this->GetTable('member_info')." AS c ON a.uid=c.uid  WHERE a.spaceuid='$this->spaceuid'  ORDER BY a.dateline DESC LIMIT 0,18");
			
	        
			$sellerservicearr=$this->GetMysqlArray('a.*,b.thumb'," ".$this->GetTable('task_seller_service')." AS a LEFT JOIN ".$this->GetTable('file')." AS b  ON b.fid=a.logo   WHERE a.status=0 AND a.uid='$this->spaceuid' ORDER BY a.dateline DESC  LIMIT 0,12");
			
			
			$sellercreditarr=$this->GetMysqlArray('a.*,b.money,b.price1,b.price2,b.appid,b.tid,tsubject,c.username'," (".$this->GetTable('task_order_credit')." AS a LEFT JOIN ( SELECT money,price1,price2,subject AS tsubject,tid,appid FROM  ".$this->GetTable('task')." )AS b ON a.tid=b.tid ) LEFT JOIN ".$this->GetTable('member')." AS c ON a.uid=c.uid  WHERE a.uid!='$this->spaceuid' AND a.type='$member[userpost]' ORDER BY a.oid DESC LIMIT 0,10");
			
			 
		    include $this->Template('default');
		  
	}
	
	
	function SpaceStyleAction(){
		   
		   $this->sid=empty($_POST['sid']) ? 0 : intval($_POST['sid']);
		   
		   if($this->sid){
			 
				 $this->Update('member_info',array('themes'=>$this->sid),array()," WHERE uid='$this->uid'");
			     
		   }else{
		   
				 include_once(Core.'/class/pages_ajax_class_phpapp.php');
	  
				  
				 $ajaxpage=new AjaxPages(6,$this->GET['page'],0,$this->GET['sqlorder'],$this->GET['iforder'],'AjaxSpaceStyle',"SELECT * FROM ".$this->GetTable('space_style')." WHERE status=0 ");
	  
				 $list=$ajaxpage->ShowResult();
				 
				 
				 include $this->Template('style');
		   }
	}
	
	
	function AboutAction(){
		
		    $member=$this->GetMysqlOne('usertype'," ".$this->GetTable('member')." WHERE uid='$this->spaceuid'");
			
			if(!$member){
				 echo $this->Refresh('用户不存在或已被删除!',SURL);
				 exit();
			}
			
			$memberinfo=$this->GetMemberInfo($member['usertype']);
			
			include $this->Template('about');
		   
	}
	
	function GetMemberInfo($usertype=0){
		
	        include_once(APPS.'/member/class/member_phpapp.php');
							
			$mf=new MemberFunction();
			
			$taskmember=$mf->GetTypeNameMember($usertype);

			$table_phpapp=$taskmember['table_phpapp'];
			
			return $memberinfo=$this->GetMysqlOne('about'," ".$this->GetTable($table_phpapp)." WHERE uid='$this->spaceuid'");
	}
	
}




?>