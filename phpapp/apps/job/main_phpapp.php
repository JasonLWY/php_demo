<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.1
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class JobMainControls extends PHPAPP{
	
    public $GET,$errors;
	
	function __construct(){	
	
		   parent::__construct();
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','total','id','op','item','sort','more','tab','did','select'));
      
	}
	
	
	function DefaultAction(){
		
		  $this->JobList();
	}
	
	function JobList($catid=0,$skill=0,$app=0){
		   
		   if($app==55){
		   		$this->app=$app;
		   }
		   
		   
		   $total=empty($_GET['total']) ? 20 : intval($_GET['total']);
		   
		   include_once(Core.'/class/skill_class_phpapp.php');
		   
		   $skilldata=new SkillClass();
		   
           $selectarray=array(
	
					  array('name'=>'默认排序','data'=>array('默认排序','注册时间久到近','注册时间近到久','出售服务从多到少','出售服务从少到多'),'id'=>'sort'),
					  array('name'=>'列表切换','data'=>array('0'=>'0','1'=>'1'),'id'=>'tab'),
					  array('name'=>'更多筛选','data'=>array('0'=>'0','1'=>'1'),'id'=>'more')
			     );
   
   
		   require_once(Core.'/class/list_class_phpapp.php');
		   
		   $selectclass=new SelectData($selectarray,$catid,$skill);

		   $selectitem=$selectclass->GetSelectOne('task_seller_select');

           $selectctarray=$selectclass->GetSelectCategory();

		   $selectsql=$selectclass->GetSelectOneSQL($selectitem[2],$selectctarray[5],'d.catid','d.residecity','c.skills');
		   
		    include_once(Core.'/class/pages_class_phpapp.php');
				

					 //排序
					 switch ($this->GET['sort']) {
							 case '1':
							 $order=' c.dateline ASC';
							 break;
							 case '2':
							 $order=' c.dateline DESC';
							 break;
							 case '3':
							 $order=' d.selltotal DESC';
							 break;
							 case '4':
							 $order=' d.selltotal ASC';
							 break;
							 default:
							 $order=' f.credit DESC ,c.logintime ASC ';
					 }
								
					
							
						   
			$pageurl=$selectclass->GetSelectAllURL();
		   
	       
		   $page=new Pages(16,$this->GET['page'],$pageurl,"SELECT c.*,d.certificate,d.selltotal,f.credit,f.hao,f.zhong,f.cha,g.speed,g.attitude,g.quality,h.residelatitude,h.residelongitude 	,h.residemapzoom,h.about,d.residecity FROM ((((".$this->GetTable('member')." AS c  LEFT JOIN ".$this->GetTable('member_info')." AS d ON c.uid=d.uid)LEFT JOIN ".$this->GetTable('member_account')." AS e ON c.uid=e.uid) LEFT JOIN ".$this->GetTable('credit_score')." AS g ON c.uid=g.uid) LEFT JOIN ".$this->GetTable('member_personal')." AS h ON c.uid=h.uid ) LEFT JOIN ( SELECT credit,uid,hao,zhong,cha FROM ".$this->GetTable('credit')." WHERE type=1 ) AS f ON c.uid=f.uid WHERE c.uid>0 AND c.userpost=2 $selectsql  ORDER BY $order ");
	   
	   
		   $list=$page->ShowResult();
		   

		   
		   
		   //SEO
		   PHPAPP::$SEO['title']=empty($selectctarray[2])? '' :$selectctarray[2];
		   PHPAPP::$SEO['keywords']=empty($selectctarray[3])? '' :$selectctarray[3];
		   PHPAPP::$SEO['description']=empty($selectctarray[4])? '' :$selectctarray[4];
		  
		  include $this->AppsView('job:list');
		
	}
	
}




	
?>