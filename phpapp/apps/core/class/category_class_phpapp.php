<?php
/*
	EDOOG.COM (C) 2009-2014 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.10
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class CategoryClass extends PHPAPP{


	function __construct(){	 
         
		 parent::__construct();

	}
	

	function MakeCategoryCache($isupdate=0){
          
		  //JS && Route && ID
		  if($isupdate){
			     $this->UpdateCategoryCache();
		  }else{
				  if(!file_exists(SYS.'/data/cache/config/category.php')){
						  $this->UpdateCategoryCache();
				  }
		  }
		  
    }
	
	//更新子类
	function UpdateCategorySubclassID($catid=0){
		
		  set_time_limit(0);
		  
		  $cityarray=$this->GetMysqlArray('*'," ".$this->GetTable('category')." WHERE upid='$catid'");
		  
		  if($cityarray){
			     foreach($cityarray as $citys){
						$this->GetCategorySubclassID($citys['upid'],$citys['catid']);
					    $this->UpdateCategorySubclassID($citys['catid']);
				 }
		  }
				
	}
		
	function GetCategorySubclassID($catid=0){
		 
		   set_time_limit(0);
			
		   $cityarray=$this->GetMysqlArray('*'," ".$this->GetTable('category')." WHERE upid='$catid'");

		 
           if($cityarray){
			     foreach($cityarray as $citys){
					 
					    $citysubarray=$this->GetMysqlArray('*'," ".$this->GetTable('category')." WHERE upid='$citys[catid]'");

						if($this->citynexts){
							 $this->citynexts.=','.$citys['catid'];

						}else{
							 $this->catidid=$citys['catid'];
							 $this->citynexts.=$citys['catid'];
						}
   
						if(is_array($citysubarray)){
							  
					           foreach($citysubarray as $citysubs){
					           		$this->citynexts.=','.$citysubs['catid'];
									
									$cityarray2=$this->GetMysqlArray('*'," ".$this->GetTable('category')." WHERE upid='$citysubs[catid]'");

							        if($cityarray2){
										   foreach($cityarray2 as $citysubs2){
											   
											      $this->citynexts.=','.$citysubs2['catid'];
												  
												  $cityarray3=$this->GetMysqlArray('*'," ".$this->GetTable('category')." WHERE upid='$citysubs2[catid]'");
												  
												  if($cityarray3){
										   				foreach($cityarray3 as $citysubs3){
															  $this->citynexts.=','.$citysubs3['catid'];
														}
												  }
												  
										   }
									}
									
							   }
							
						}

						$this->Update('category',array('nexts'=>$this->citynexts),array(),"WHERE catid='$this->catidid'");
						
						$this->citynexts=$this->catidid='';

						
				 }
				 
	
				 
		   }
		   unset($cityarray);
		   unset($citysubarray);
		   
	}
	
	function UpdateWebsiteCategoryCache(){
           
		   include(SYS.'/data/cache/config/apps.php');
		   include(SYS.'/data/cache/config/route_category.php');
					  
		   $categorysarr=$this->GetMysqlArray('*'," ".$this->GetTable('category')." WHERE upid=0 AND type='49' ORDER BY displayorder ASC ");
		   
		   $categoryhtml='';
		   
		   foreach($categorysarr as $category){
				$categoryhtml.='<li>';
					   $categoryhtml.='<h3 class="mcate-item-hd"><span><a href="'.$this->GetCategoryURL($category['catid'],$category['route'],$apps).'">'.$category['name'].'</a></span></h3><p class="mcate-item-bd">';
					   
					   $categoryssubarr=$this->GetMysqlArray('*'," ".$this->GetTable('category')." WHERE upid='$category[catid]' ORDER BY displayorder ASC ");
					   
					   if($categoryssubarr){
							   foreach($categoryssubarr as $value){
									   $categoryhtml.='<a href="'.$this->GetCategoryURL($value['catid'],$value['route'],$apps).'"><span style="color:'.$value['color'].'">'.$value['name'].'</span></a>';
							   }
						   
					   }
					   
				 $categoryhtml.='</p></li>';
			   
		   }

		   $this->WriteFile(SYS.'/data/cache/config/website_category.php',$categoryhtml);
	}
	
	function UpdateCategoryCache(){

		  $categorysarr=$this->GetMysqlArray('*'," ".$this->GetTable('category')." ORDER BY displayorder ASC ");
		  $phpappcopy="<?php
/*
	EDOOG.COM (C) 2009-2014 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.20
*/	 if(!defined('IN_PHPAPP')){exit('Data error');}"; 
           
		  //ID
		  $config=$phpappcopy.'$categoryarray=array(';
		
		  $arrayvalue='';
		  foreach($categorysarr as $value){
			  
			   if($arrayvalue){
	                 $arrayvalue.=',';
			   }
			 	   
			   $arrayvalue.=$value['catid'].'=>array(\'catid\'=>\''.$value['catid'].'\',\'upid\'=>\''.$value['upid'].'\',\'name\'=>\''.$value['name'].'\',\'skills\'=>\''.$value['skills'].'\',\'nexts\'=>\''.$value['nexts'].'\',\'route\'=>\''.$value['route'].'\',\'color\'=>\''.$value['color'].'\',\'title\'=>\''.$value['title'].'\',\'keywords\'=>\''.$value['keywords'].'\',\'description\'=>\''.$value['description'].'\',\'classname\'=>\''.$value['classname'].'\')';
		 	 	
          }
		 
		  $config.=$arrayvalue.');?>';
		 
		  $this->WriteFile(SYS.'/data/cache/config/category.php',$config);
		  
		  //Route
		  $config=$phpappcopy.'$categoryarray=array(';
		
		  $arrayvalue='';
		  foreach($categorysarr as $value){
			  
			   if($arrayvalue){
	                 $arrayvalue.=',';
			   }
			   
			  $arrayvalue.='\''.$value['route'].'\'=>array(\'catid\'=>\''.$value['catid'].'\',\'upid\'=>\''.$value['upid'].'\',\'name\'=>\''.$value['name'].'\',\'skills\'=>\''.$value['skills'].'\',\'nexts\'=>\''.$value['nexts'].'\',\'route\'=>\''.$value['route'].'\',\'color\'=>\''.$value['color'].'\',\'title\'=>\''.$value['title'].'\',\'keywords\'=>\''.$value['keywords'].'\',\'description\'=>\''.$value['description'].'\',\'classname\'=>\''.$value['classname'].'\')';
          }
		 
		  $config.=$arrayvalue.');?>';
		 
		  $this->WriteFile(SYS.'/data/cache/config/route_category.php',$config);
		  
		  
     }
	
	
	 
	 function GetCategoryID($name=''){

		   if(preg_match('/^[a-z]+$/i',$_GET['action'])){
				 require(SYS.'/data/cache/config/route_category.php');
				 
				 if(!empty($categoryarray)){
					   return intval($categoryarray[$_GET['action']]['catid']);
				 }
		   }else{
		         return intval($_GET['action']);
		   }
	 }
	 
	 
	 function GetCategoryURL($catid,$route='',$apps,$type=''){
		     
			 if($_GET['type']){
			      $type=$_GET['type'];
			 }
			 
			 $urltype='';
			 if(S_REWRITE_URL){
				   $approute=$apps[10]['route_phpapp'];
				   if(preg_match('/^[a-z]+$/i',$type)){
					     $urltype='/'.$type;
				   }else{
					     $urltype='/'.$apps[49]['route_phpapp'];
				   }
				   
				   return SURL.'/'.$approute.'/'.$route.$urltype.'.html';
			 }else{
				 
				   $type=intval($type);

				   if($type>0){
					    $urltype='&type='.$type;
				   }else{
					    $urltype='&type='.$apps[49]['id_phpapp'];  
				   }
				   
				   return SURL.'/index.php?app=10&action='.$catid.$urltype;
			 } 
		
	 }
	
}



?>