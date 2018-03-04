<?php
/*
	EDOOG.COM (C) 2009-2014 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.10
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class SkillClass extends PHPAPP{

    public $apps,$skillsroute,$skillsarray;
	 
	function __construct(){	 
         
		 parent::__construct();
		 
		 require(SYS.'/data/cache/config/apps.php');
		 
		 $this->apps=$apps;
		 
		 $this->MakeSkillCache();

		 require(SYS.'/data/cache/config/route_skills.php');

		 $this->skillsroute=$skillsarray;
		 
		 require(SYS.'/data/cache/config/skills.php');
		 
		 $this->skillsarray=$skillsarray;

	}
	

	function MakeSkillCache($isupdate=0){
          
		  //JS && Route && ID
		  if($isupdate){
			    $this->UpdateSkillCache();
		  }else{
				  if(!file_exists(SYS.'/data/cache/config/skills.php')){
						  $this->UpdateSkillCache();
				  }
		  }
		  
    }
	
	
	function UpdateSkillCache(){
          		  
		  if(!is_dir(SYS.'/data/cache/js')){
				mkdir(SYS.'/data/cache/js',0777); 
		  }
		  
		  //All
		  $skillsarr=$this->GetMysqlArray('*'," ".$this->GetTable('skills')." ORDER BY displayorder ASC ");
		  $phpappcopy="<?php
			/*
				EDOOG.COM (C) 2009-2014 EDOOG Inc.
				This is NOT a freeware, use is subject to license terms
				V2.5  2013.5.20
			*/	 if(!defined('IN_PHPAPP')){exit('Data error');}"; 
					   
		  //ID
		  $config=$phpappcopy.'$skillsarray=array(';
		
		  $arrayvalue='';
		  foreach($skillsarr as $value){
			  
			   if($arrayvalue){
					 $arrayvalue.=',';
			   }
			   
			   $arrayvalue.=$value['sid'].'=>array(\'sid\'=>\''.$value['sid'].'\',\'name\'=>\''.$value['name'].'\',\'route\'=>\''.$value['route'].'\',\'color\'=>\''.$value['color'].'\',\'title\'=>\''.$value['title'].'\',\'keywords\'=>\''.$value['keywords'].'\',\'description\'=>\''.$value['description'].'\',\'classname\'=>\''.$value['classname'].'\')';
				
		  }
		 
		  $config.=$arrayvalue.');?>';
		 
		  $this->WriteFile(SYS.'/data/cache/config/skills.php',$config);
					  
		  //Route
		  $config=$phpappcopy.'$skillsarray=array(';
		
		  $arrayvalue='';
		  foreach($skillsarr as $value){
			  
			   if($arrayvalue){
					 $arrayvalue.=',';
			   }
			   
			  $arrayvalue.='\''.$value['route'].'\'=>array(\'sid\'=>\''.$value['sid'].'\',\'name\'=>\''.$value['name'].'\',\'route\'=>\''.$value['route'].'\',\'color\'=>\''.$value['color'].'\',\'title\'=>\''.$value['title'].'\',\'keywords\'=>\''.$value['keywords'].'\',\'description\'=>\''.$value['description'].'\',\'classname\'=>\''.$value['classname'].'\')';
		  }
		 
		  $config.=$arrayvalue.');?>';
		 
		  $this->WriteFile(SYS.'/data/cache/config/route_skills.php',$config);
		  
		  //Category
		  
		  $categoryarr=$this->GetMysqlArray('catid,skills'," ".$this->GetTable('category')." ORDER BY displayorder ASC ");
		  
		  foreach($categoryarr as $category){
                   
				   if($category['skills']){
						  $skillsarr=$this->GetMysqlArray('*'," ".$this->GetTable('skills')." WHERE  sid IN ($category[skills])  ORDER BY displayorder ASC ");
						  if($skillsarr){
								  //JS
								  $arrayvalue='var Sarr= new Array(); //PHPAPP 2.5 SKILLS DATA'."\n";
								  foreach($skillsarr as $value){
						
									   $arrayvalue.='Sarr['.$value['sid'].']=\''.$this->ConvertStrToUTF8($value['name']).'\';';
								  }
								  
								  $this->WriteFile(SYS.'/data/cache/js/skillsdata'.$category['catid'].'.js',"\xEF\xBB\xBF".$arrayvalue);
						  }
				   }
		  }
		  
     }
	
	 function GetSkillName($ids){
		   
		   if($ids){
			   
				 $newskillsarray=array();
				 if($this->skillsarray){
					   
					   $idarr=explode(',',$this->ExplodeStrArr($ids));
					   foreach($idarr as $id){
						      $newskillsarray[]=$this->skillsarray[$id];
					   }
				 }
				 

				 return $newskillsarray;
		   }else{
			     
				 return array();
			   
		   }
	 }
	 
	 function GetSkillURL($ids,$type=''){
		   
           if($_GET['type']){
			    $type=$_GET['type'];
		   }
			 
		   $newskillsarray=$this->GetSkillName($ids);
		   
		   $urltype='';
		   if($newskillsarray){
			
				 $skillsurlarray=array();
				 if(S_REWRITE_URL){
		
		              $approute=$this->apps[27]['route_phpapp'];
					  
					  if(!$type){
						   $type=$this->apps[49]['route_phpapp'];
					  }
					  
					  if(preg_match('/^[a-z]+$/i',$type)){
					        $urltype='/'.$type;
				      }
				   
					  foreach($newskillsarray as $key=>$value){
						      $skillsurlarray[$value['sid']]['name']=$value['name'];
							  $skillsurlarray[$value['sid']]['title']=$value['title'];
							  $skillsurlarray[$value['sid']]['keywords']=$value['keywords'];
							  $skillsurlarray[$value['sid']]['description']=$value['description'];
							  $skillsurlarray[$value['sid']]['url']=SURL.'/'.$approute.'/'.$value['route'].$urltype.'.html';
					  }
				 }else{
					 
					  $type=intval($type);

				  	  if($type>0){
					        $urltype='&type='.$type;
				      }
				   
					  foreach($newskillsarray as $key=>$value){
						      $skillsurlarray[$value['sid']]['name']=$value['name'];
							  $skillsurlarray[$value['sid']]['title']=$value['title'];
							  $skillsurlarray[$value['sid']]['keywords']=$value['keywords'];
							  $skillsurlarray[$value['sid']]['description']=$value['description'];
							  $skillsurlarray[$value['sid']]['url']=SURL.'/index.php?app=27&sid='.$value['sid'].$urltype;
					  }
				 }
				 
				 return $skillsurlarray;
			   
		   }else{
			     
				 return array();
			   
		   }
	 }
	 
	 function GetSkillSID($name=''){
			
		   if(preg_match('/^[a-z]+$/i',$_GET['action'])){
				 
				 if($this->skillsroute){
					   return intval($this->skillsroute[$_GET['action']]['sid']);
				 }
		   }else{
		         return intval($_GET['action']);
		   }
	 }
	
}



?>