<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class HelpMainControls extends PHPAPP{
	
    private $POST,$GET,$errors;
	
	public $catid;
	
	function __construct(){	
	
	       parent::__construct();
		   
		   $item=explode('.',empty($_GET['item']) ? 0 :$_GET['item']);
		   
		   if(!empty($item[1])){
			     $this->catid=intval($item[1]);
		   }else{
		   
		         $this->catid=empty($_GET['item']) ? 0 : intval($_GET['item']);
		   }
		   
		   $postkey=array('Submit'=>'');
			
			
		   $this->POST=$this->POSTArray();
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','total','item','hid'));
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
      
	}
	
	function DefaultAction(){

		   $search=empty($_GET['search']) ? '' : $_GET['search'];
		 
		   $search=urldecode($this->str($search,12,1,0,1,0,1));
		   
		   if($search){
			   
			     include_once(Core.'/class/pages_class_phpapp.php');
				  
				 $pageurl=SURL.'/index.php?app=57&search='.urlencode($search);
				
				 $searchsql='';
				
				 if($search){
					  
					   if(PHPAPP::$config['setsearchmode']==1){
							 $searchsql=sprintf("WHERE MATCH (subject) AGAINST ('%s')",htmlspecialchars($search,ENT_QUOTES));
					   }else{
							 $searchsql=sprintf("WHERE subject REGEXP '%s'",htmlspecialchars($search,ENT_QUOTES));
					   }
				 }

				 $page=new Pages(10,$this->GET['page'],$pageurl," SELECT * FROM ".$this->GetTable('help')." $searchsql ");

				 $list=$page->ShowResult();

			     include $this->Template('search');
		   }else{
			   
			     $this->HomeAction();
		   }
	}
	
	
	function HomeAction(){
		  
		    $categoryarr=$this->GetMysqlArray('total,name,catid,classname'," ".$this->GetTable('category')." WHERE type='$this->app' AND upid='$this->catid' ORDER BY displayorder ASC");
			   
		    if(!$categoryarr){
				
				
				   $category=$this->GetMysqlOne('total,name,catid,classname,title,keywords,description'," ".$this->GetTable('category')." WHERE type='$this->app' AND catid='$this->catid' ORDER BY displayorder ASC");
				   
				   if($category){
					   
					     PHPAPP::$SEO['title']=$category['title'];
		                 PHPAPP::$SEO['keywords']=$category['keywords'];
		                 PHPAPP::$SEO['description']=$category['description'];
						 
						 $categoryname=$category['name'];

						 include_once(Core.'/class/pages_class_phpapp.php');
						 
						 $page=new Pages(20,$this->GET['page'],'index.php?app='.$this->app.'&action=1&item='.$this->catid,"SELECT * FROM ".$this->GetTable('help')."  WHERE catid='$this->catid' ORDER BY dateline DESC");
						 
						 $list=$page->ShowResult();
				   }

			}
			
		    
			include $this->AppsView('list');
		
		
	}
	
	
	function ShowAction(){
		
		   if($this->GET['hid']>0){
			   
			      $categoryarr=$this->GetMysqlArray('total,name,catid,classname'," ".$this->GetTable('category')." WHERE type='$this->app' AND upid='$this->catid' ORDER BY displayorder ASC");
			   
			     $hid=$this->GET['hid'];
			     $showhelp=$this->GetMysqlOne('*'," ".$this->GetTable('help')." WHERE hid='$hid'");
				 
		
				 if(!$showhelp){
			           $this->HomeAction();
		         }else{ 
				       
					   //SEO
					   PHPAPP::$SEO['title']=$showhelp['subject'];
					   PHPAPP::$SEO['keywords']=$showhelp['subject'];
					   PHPAPP::$SEO['description']=$this->str($showhelp['content'],80,0,1,1,0,1);

					   include $this->AppsView('show');
				 }
				  
		   }else{
			     $this->HomeAction();
		   }
		   
		   
		
	}
	
	function ReplaceRed($search='',$content=''){
		 
		 if($search && $content){
		      return str_replace($search,'<span class="red">'.$search.'</span>',$content);
	     }
	}
	

}

?>