<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include(APPS.'/apppay/class/process_class_phpapp.php');

include_once(APPS.'/taskmode/public_phpapp.php');
	
class TaskModeMemberControls extends TaskPublicClass{
	
	function __construct(){	 
	 
		 parent::__construct();
		 
		 if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
		 
	}
	
	
	public function DefaultAction(){
		
		  return $this->TaskMemberAction();
		
	}
	
	
	public function TaskMemberAction(){
		   
		  if($this->GET['op']==1){
				 
				  if($this->POST['oderid']){
						
						   $oderid=$this->ExplodeStrArr($this->POST['oderid']);
						   $idarray=explode(',',$oderid);
				           
						   foreach($idarray as $value){
							      $this->Delete('task'," WHERE uid='$this->uid' AND tid='$value' ");
								  echo $value.'号任务删除成功!<br />';
						   }
						   
				          
						   echo $this->CloseNowWindows('#loading',1);
				  }
				   
				   
				 
				   exit();
				   
		  }else{
				  
				include_once(Core.'/class/pages_class_phpapp.php');
					   
					   
				$sort='';
				
				if($this->GET['sort']){
					   $sortid=$this->GET['sort'];
					   $sort=" AND process='$sortid'";
				}
				
			    $page=new Pages(10,$this->GET['page'],'member.php?&app=49&action=10&sort='.$this->GET['sort'],"SELECT * FROM ".$this->GetTable('task')." WHERE uid='$this->uid' AND appid!=82 $sort ORDER BY tid DESC");
		 
	
			    $list=$page->ShowResult();
	 
			 
			    $getprocess=new TaskProcess();
			   
			   
			   include $this->Template('task_member');
		   
		  }
		  
		  
		 
	}
	
	
	
	function DraftMemberAction(){
		
		
		       include_once(Core.'/class/pages_class_phpapp.php');
				   
				   
					switch ($this->GET['sort']) {
						      case '4':
							  $sort=" AND process='0'";
							  break;
							  case '1':
							  $sort=" AND process='1'";
							  break;
							  case '2':
							  $sort=" AND process='2'";
							  break;
							  case '3':
							  $sort=" AND process='3'";
							  break;
							  default:
							  $sort='';
					  }
			 
			       $page=new Pages(10,$this->GET['page'],'member.php?app=49&action=11&sort='.$this->GET['sort'],"SELECT * FROM ".$this->GetTable('task_draft')." WHERE appid!=82 AND uid='$this->uid' $sort ORDER BY did DESC");
			 

			 
			       $list=$page->ShowResult();
		 
				 
				   $getprocess=new TaskProcess();
				   

		
		      include $this->Template('draft_member');
	}

    function CommentMemberAction(){
		
		
		       include_once(Core.'/class/pages_class_phpapp.php');
				   

			   $page=new Pages(10,$this->GET['page'],'member.php?app=49&action=12',"SELECT a.*,b.url FROM ".$this->GetTable('task_draft_comment')." AS a JOIN  ".$this->GetTable('task')." AS b ON a.tid=b.tid WHERE a.uid='$this->uid' AND b.appid!=82 ORDER BY a.cid DESC");
		 

			   $list=$page->ShowResult();
	
		
		      include $this->Template('comment_member');
	}

 	function FavoritesMemberAction(){
		
		  if($this->GET['op']==1){
			
			     if($this->POST['oderid']){
						
						   $oderid=$this->ExplodeStrArr($this->POST['oderid']);
						   $idarray=explode(',',$oderid);
				           
						   foreach($idarray as $value){
							      $this->Delete('task_favorites'," WHERE uid='$this->uid' AND tid='$value' ");
								  echo $value.'号任务收藏删除成功!<br />';
						   }
						   
						   echo $this->CloseNowWindows('#loading',1);
				  }
				   
				   exit();
				   
		  }else{
		       include_once(Core.'/class/pages_class_phpapp.php');
				   

			   $page=new Pages(10,$this->GET['page'],'member.php?app=49&action=13',"SELECT * FROM ".$this->GetTable('task_favorites')." AS a JOIN  ".$this->GetTable('task')." AS b ON a.tid=b.tid WHERE a.uid='$this->uid' AND b.appid!=82 ORDER BY a.dateline DESC");
		 

			   $list=$page->ShowResult();
	
	
			   $getprocess=new TaskProcess();
		
		      include $this->Template('favorites_member');
		  }
	}
	
	
	function  FollowMemberAction(){
		      
			  include_once(Core.'/class/pages_class_phpapp.php');
			  
			  $follow=$this->GetMysqlOne('*'," ".$this->GetTable('follow')." WHERE uid='$this->uid'");      
              
			  $catids=$skills=0;
			  
			  $sort=1;
			  
			  $list=array();
				
			  if($this->GET['sort']){
					$sort=$this->GET['sort'];
			  }
			  
			  if($sort==1){
				  
				  if(!empty($follow['catids'])){   //分类
					   
						$catids=$follow['catids'];
						
						$id=$this->GET['id'];
						if($id>0){
								
								$newcatids=$this->ExplodeStrArr($catids,$id);
								$this->Update('follow',array('catids'=>$newcatids),array(),"WHERE uid='$this->uid'");
								
								echo  '取消成功！';
								echo $this->CloseNowWindows('#loading',1);
								exit();
						}
				  
						
						$page=new Pages(10,$this->GET['page'],'member.php?app=49&action=14&sort='.$this->GET['sort'],"SELECT * FROM ".$this->GetTable('category')." WHERE catid IN($catids) ORDER BY displayorder DESC");
						
						include_once(Core.'/class/category_class_phpapp.php');
						include(SYS.'/data/cache/config/apps.php');
	
	              		$category=new CategoryClass();
	
						$list=$page->ShowResult();
				  }
				  

			  }elseif($sort==2){
				  
				  if(!empty($follow['skills'])){ 
					   
						$skills=$follow['skills'];
						
						$id=$this->GET['id'];
						if($id>0){
								
								$newskills=$this->ExplodeStrArr($skills,$id);
								$this->Update('follow',array('skills'=>$newskills),array(),"WHERE uid='$this->uid'");
								
								echo  '取消成功！';
								echo $this->CloseNowWindows('#loading',1);
								exit();
						}
						
						$page=new Pages(10,$this->GET['page'],'member.php?app=49&action=14&sort='.$this->GET['sort'],"SELECT * FROM ".$this->GetTable('skills')." WHERE sid IN($skills) ORDER BY displayorder DESC");
	
						$list=$page->ShowResult();
						
						include_once(Core.'/class/skill_class_phpapp.php');
			   
	                    $skilldata=new SkillClass();
						
						$skillarr=$skilldata->GetSkillURL($skills);

				  }

			  }
			  
	
		      include $this->Template('follow_member');
	}
	
}

?>