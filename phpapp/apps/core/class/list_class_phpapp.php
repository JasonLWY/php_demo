<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//Select
require_once(Core.'/class/category_class_phpapp.php');

class SelectData extends PHPAPP{

	public $selectarray,$seotitle,$seokeywords,$description,$selecturl,$selecturlall,$catid,$skill,$itemarr,$apps;
	
	function __construct($selectarray=array(),$catid=0,$skill=0){
		   global $siteuri;  
		   $this->selectarray=$selectarray;
		   parent::__construct();
           $this->catid=$catid;
		   $this->skill=$skill;
		   
		   $urltype='';
		   if(!empty($_GET['type'])){
			   if(preg_match('/^[a-z]+$/i',$_GET['type'])){
					 $urltype='/'.$_GET['type'];
			   }else{
					 $urltype='&type='.intval($_GET['type']);
			   }
		   }
					  
		   if($catid>0){
			    if(S_REWRITE_URL){
					  $this->selecturl=SURL.'/'.$siteuri['app'].'/'.$siteuri['action'].$urltype.'.html';
				}else{
			    	  $this->selecturl=SURL.'/index.php?app=10&action='.$this->ac.$urltype;
				}
		   }elseif($skill>0){
			    if(S_REWRITE_URL){
					  $this->selecturl=SURL.'/'.$siteuri['app'].'/'.$siteuri['action'].$urltype.'.html';
				}else{
			    	  $this->selecturl=SURL.'/index.php?app=27&action='.$this->ac.$urltype;
				}
		   }else{
			    
				if(S_REWRITE_URL){
					  $this->selecturl=SURL.'/'.$siteuri['app'].'.html';
				}else{
			    	  $this->selecturl=SURL.'/index.php?app='.$this->app;
				}
		   }
			
		   $this->itemarr=$this->SelectGetData();
	}
	
	
	function MakeSelectAllURL($id='',$value=0){
				   
		  foreach($this->selectarray as $select){
			 
			   if($id==$select['id']){
	   
					   $selecturl.='&'.$select['id'].'='.$value;
						
			   }else{
			   
					   $getvalue=empty($_GET["$select[id]"]) ? 0 : intval($_GET["$select[id]"]);
					   
					   if($getvalue>0){
							$selecturl.='&'.$select['id'].'='.$getvalue;
					   }else{
							$selecturl.='&'.$select['id'].'=0';
					   }
			   }
		   }
							   
           return $selecturl;
	}

	function GetSelectOne($tableselect='task_select',$iscityid=0){
		  
		  $selectarrnew=array();

		  $selectarr=$this->GetMysqlArray('*'," ".$this->GetTable($tableselect)." WHERE status=0 ORDER BY displayorder ASC");
          
          //重组带KEY
          foreach($selectarr as $select){

			    $selectarrnew[$select['catid']]=$select;
		  }

		  $selectlist=$nowselect='';
			  
		  $selectcatid=array();
			

		  
		  //URL中增加选中的ID
		  $selecturl=$this->GetSelectURL($this->itemarr);
		  

		  if(!empty($selectarrnew[2])){
			    //地区分类
			    //city --------------------------------------------------
				$catidkey=10000;
	            
				foreach($this->itemarr as $keyid=>$value){
					 if($keyid==$catidkey){
						
						 $citycatid=intval($value[0]);
						  
					 }
				}
				
				if($this->nowcity>0){
					   
					  if($citycatid>0){
						  
						      if(empty(PHPAPP::$config['cookie_domain'])){
								   $cookie_domain=false;
							  }else{
								   $cookie_domain=PHPAPP::$config['cookie_domain'];
							  }
							  
							  if(empty(PHPAPP::$config['cookie_path'])){
								   $cookie_path=false;
							  }else{
								   $cookie_path=PHPAPP::$config['cookie_domain'];
							  }
					         
							  setcookie('USERCITYID',$citycatid,time() + 2678400,$cookie_path,$cookie_domain);
					
				      }else{
				
					  		  $citycatid=$this->nowcity;
					  
					  }
					  
				}
				
				
					
			    
				$categoryitemname='';
				
				$categoryarray=$this->GetMysqlArray('catid,name,nexts'," ".$this->GetTable('category_city')." WHERE upid='$citycatid' ORDER BY displayorder ASC");
				
				if($categoryarray){

 					    if($this->itemarr[$catidkey]){
							  $cityselecturl=$this->DeleteSelectURL($this->itemarr,$catidkey);
							  
							  if(count($this->itemarr)>1){
								    $cityselecturl.=';';
							  }
						}else{
							  $cityselecturl=$selecturl;
						}
							  
						foreach($categoryarray as $key=>$value){
			                  
							 
							  
							  $categoryitemname.='<a href="'.$cityselecturl.$catidkey.'.'.$value['catid'].$this->MakeSelectAllURL().'">'.$value['name'].'</a>';				
								
						}
				}
				
				
				if($categoryitemname){	   
						$selectlist.='<li><h2>'.$selectarrnew[2]['name'].':</h2><p>'.$categoryitemname.'</p></li>';
				}
				
				if(!$this->nowcity){
						if($citycatid){
								$cityuparr=$this->GetMysqlOne('name'," ".$this->GetTable('category_city')." WHERE  catid='$citycatid'");
								$nowselect.='<a href="'.$this->DeleteSelectURL($this->itemarr,$catidkey).$this->MakeSelectAllURL().'">'.$cityuparr['name'].'</a> ';
						}
				}
		
		  }
			  
		  
		  
		  foreach($selectarrnew as $key=>$select){
		
                    $itemname='';
				    if($select['upid']==0 && empty($this->itemarr[$select['catid']][0]) && $key!=2){
						  
			
						  foreach($selectarrnew as $subselect){
							     
								 if($select['catid']==$subselect['upid']){
									     $itemname.='<a href="'.$selecturl.$select['catid'].'.'.$subselect['catid'].$this->MakeSelectAllURL().'">'.$subselect['name'].'</a> ';
								 }
							  
						  }
						  
						  
						  $selectlist.='<li><h2>'.$select['name'].':</h2><p>'.$itemname.'</p></li>';
						 
					}elseif($select['upid']==0){
						 
						  if($selectarrnew[$this->itemarr[$select['catid']][0]]['name']){
						  		$nowselect.='<a href="'.$this->DeleteSelectURL($this->itemarr,$select['catid']).$this->MakeSelectAllURL().'">'.$selectarrnew[$this->itemarr[$select['catid']][0]]['name'].'</a> ';
						  }

					}
						
				
		  }

		   
		   
		   return array($nowselect,$selectlist,$selectarrnew);
	}
	
	
	function SelectGetData(){
		
		   $item=empty($_GET['item']) ? '' : $_GET['item'];
		   
		   
		   $itemarr=explode(';',urldecode($item));
		   
		   $newitem=array();

		   if($itemarr[0]){
		   
				 foreach($itemarr as $arr){
					   if($arr){
							 $valuearr=explode('.',$arr);
							 
							 $key=intval($valuearr[0]);
							 
							 $value=empty($valuearr[1]) ? 0 : intval($valuearr[1]);
							 
							 $newitem[$key][]=$value;
					   }
				 }
				 
		   }
		   
		   
		   return $newitem;
		
    }			  
	
	 function GetSelectURL($itemarr,$catid=0,$isurl=0){
		 
		 $selectitem='&item=';
		 
		 $selecturl='';
		
		 if($itemarr){
			   foreach($itemarr as $key=>$value){
					
					 if($key && $value){
						  
						   if($catid != $key){
							   
								 $id=$key.'.'.intval($value[0]);
								 
								 if($newselect!=$id){
									   
									   foreach($value as $val){
											$selecturl.=intval($key).'.'.intval($val).';';
									   }
								 }
						   
						   }
						   
						   
					 }
			   }
		 }
        
		if($isurl){
			  if(!empty($selecturl)){
			  		return $selectitem.$selecturl;
			  }else{
				    return false;
			  }
		}else{
			  return $this->selecturl.$selectitem.$selecturl;
		}
		 
	}
	
	 
	 function DeleteSelectURL($itemarr,$catid=0){
		 
		  $selecturl='&item=';
		  
		  if($itemarr){
			     
				 $items='';
				 foreach($itemarr as $key=>$value){
					    
						if($key && $value){
							
							 if($catid != $key){
								
								   if($items){
								        $items.=';'.$key.'.'.$value[0];
								   }else{
									    $items.=$key.'.'.$value[0];
								   }
								 
								 
							 }
					 
					    }
				 }
				 
				 $selecturl.=$items;
					 
		  }


		 return $this->selecturl.$selecturl;

	}
	
	
	
	function GetSelectOneSQL($selectarr,$nexts,$catidsqlname='catid',$citysqlname='cityid',$skillssqlname='skills'){
		   
		   $selectsql=$wheresql='';

		   if($nexts){
		   		$wheresql=" AND $catidsqlname IN($nexts) ";					 
		   }
		   
		   if($this->skill>0){
		          $wheresql=" AND instr($skillssqlname,'$this->skill') ";	
		   }
									   					   					   
		   foreach($this->itemarr as $key=>$value){	
				 if($key !=10000 && $selectarr[$value[0]]['code']){
						$selectsql.=' AND '.$selectarr[$value[0]]['code'];
				 }
		   }

		   if($this->itemarr[10000][0] || $this->nowcity>0){
			   
	              if($this->nowcity>0){
					    $cityid=$this->nowcity;
				  }else{
				  		$cityid=intval($this->itemarr[10000][0]);
				  }
				  
				  $categoryarr=$this->GetMysqlOne('nexts'," ".$this->GetTable('category_city')." WHERE catid='$cityid' ");
				   
				  if($categoryarr['nexts']){
					    $wheresql.=' AND '.$citysqlname.' IN('.$categoryarr['nexts'].') ';
				  }
		   }
		   
		   $wheresql.=$selectsql;

		   return  $wheresql;
		  
	}
	
	function GetSelectAllURL($id='',$value=0){	
			
		   return  $this->GetSelectURL($this->SelectGetData(),0).$this->MakeSelectAllURL($id,$value);
	}
	
	
	
	function GetSelectCategory($isshowskills=0){
		   global $siteuri;  
		   $categoryhtml='';
           $categoryname='';
		   if($this->skill>0){
			    $categoryname=$categoryhtml.=$this->GetSelectSkills();
		   }else{
			    $categoryarr=$this->GetMysqlOne('name,skills,title,keywords,description,nexts'," ".$this->GetTable('category')." WHERE catid='$this->catid' ");
			    $categoryname=$categoryarr['name'];
				$this->seotitle=$categoryarr['title'];
				$this->seokeywords=$categoryarr['keywords'];
				$this->description=$categoryarr['description'];
				$this->nexts=$categoryarr['nexts'];

			    $categoryarray=$this->GetMysqlArray('catid,name,route,skills'," ".$this->GetTable('category')." WHERE upid='$this->catid' AND type='49' ORDER BY displayorder ASC");

			    if($categoryarray){

		               $categoryclass=new CategoryClass();
	
					   foreach($categoryarray as $value){
				
						      $categoryhtml.='<a href="'.$categoryclass->GetCategoryURL($value['catid'],$value['route'],$this->GetApps(),$siteuri['app']).$this->GetSelectURL($this->itemarr,0,1).'" class="label"  title="'.$value['name'].'">'.$value['name'].'</a>';
					   }

				}else{
					 if(!$isshowskills){
						 if($categoryarr['skills']){
							   $categoryhtml=$this->GetSelectSkills($categoryarr['skills']);
						 }
					 }
				}
		  
		   }

		   return array($categoryname,$categoryhtml,$this->seotitle,$this->seokeywords,$this->description,$this->nexts);
	}
	
	function GetSelectSkills($skills=0){
		   global $siteuri;  
		   if($this->skill>0){
			      $skills=$this->skill;
		   }
		   
		   $categoryhtml='';
		   
           $skilldata=new SkillClass();
		   $skillsarr=$skilldata->GetSkillURL($skills,$siteuri['app']);
		   
           
		   if($this->skill>0){
				$this->seotitle=$skillsarr[0]['title'];
				$this->seokeywords=$skillsarr[0]['keywords'];
				$this->description=$skillsarr[0]['description'];
		   }
		   
           if($skillsarr){
				foreach($skillsarr as $key=>$skill){
					 $categoryhtml.='<a href="'.$skill['url'].$this->GetSelectURL($this->itemarr,0,1).'" class="label" title="'.$skill['name'].'">'.$skill['name'].'</a>';
				}
		   }
                  			
		   return $categoryhtml;
	}
	
}
 
?>