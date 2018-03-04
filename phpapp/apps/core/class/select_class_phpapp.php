<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//筛选
class SelectData extends PHPAPP{

	public $selectarray,$seotitle,$seokeywords,$description,$selecturl,$selecturlall;
	
	function __construct($selectarray=array()){
		    
		   $this->selectarray=$selectarray;
		   parent::__construct();
		   
		   if($this->IsWap()){
			   
			    $this->selecturl='wap.php?app='.$this->app.'&action=10';
				$this->selecturlall='wap.php?app='.$this->app.'&action=10&select=0';
					   
		   }else{
				 if(S_REWRITE_URL){
					   if(PHPAPP::$config['rewrite_type']==1){
							 $this->selecturl=$this->selecturlall=SURL.'/index/lang/'.$this->lang.'/app/'.$this->app.'/action/10';
					   }else{
					         $this->selecturl=$this->selecturlall='index-lang-'.$this->lang.'-app-'.$this->app.'-action-10';
					   }
				 }else{
					   $this->selecturl='index.php?app='.$this->app.'&action=10';
					   $this->selecturlall='index.php?app='.$this->app.'&action=10&select=0';
				 }
		   }

	}

	function GetSelectOne($appid=0,$tablename='',$iscityid=0){
		  
		  $itemarr=$this->SelectGetData();
		   
		  $selectarr=$categoryarr=$this->GetMysqlArray('*'," ".$this->GetTable($tablename)." WHERE status=0 ORDER BY displayorder ASC");
		  
		  //category ------------------------------------------------------------------------------------------------------------------------------------
		  
		  $categoryupid=0;
		  foreach($itemarr as $keyid=>$value){
			    if($keyid==100000){
					
					 $categoryupid=intval($value[0]);
					  
				}
		  }
		  
		  $categorycatid=0;
		  foreach($itemarr as $keyid=>$value){
			    if($keyid==1){
					
					 $categorycatid=intval($value[0]);
					  
				}
		  }
	
		  
		   $uparr=$this->GetMysqlOne('*'," ".$this->GetTable('category')." WHERE type='$appid' AND  catid='$categorycatid'");
		   
		   $upid=empty($uparr['upid']) ? 0 : intval($uparr['upid']); 

		   $categoryarr=$this->GetMysqlArray('*'," ".$this->GetTable('category')." WHERE  type='$appid' AND  upid='$upid' ORDER BY displayorder ASC");
		   
		   
		   if($categoryarr){

	
			     foreach($categoryarr as $value){
					     
						 $selectarr[]=array('catid'=>$value['catid'],'name'=>$value['name'].'('.$value['total'].')','type'=>$appid,'upid'=>1,'code'=>$value['catid'],'title'=>$value['title'],'keywords'=>$value['keywords'],'description'=>$value['description']);

				 }
				 
				 
			   
		   }
		  
		  //category end------------------------------------------------------------------------------------------------------------------------------------
		  
		  
		  
		  
		  //city ------------------------------------------------------------------------------------------------------------------------------------
		  
		  $citycatid=0;
		  foreach($itemarr as $keyid=>$value){
			    if($keyid==2){
					
					 $citycatid=intval($value[0]);
					  
				}
		  }
		  
		  if(!$iscityid){
			   if($this->nowcity>0){
					$citycatid=$this->nowcity;
					$itemarr[2]=array($this->nowcity);
				  
			   }
		  }

		   $cityuparr=$this->GetMysqlOne('*'," ".$this->GetTable('category_city')." WHERE  catid='$citycatid'");
		   
		   $cityupid=empty($cityuparr['upid']) ? 0 : intval($cityuparr['upid']); 

		   $categorycityarr=$this->GetMysqlArray('*'," ".$this->GetTable('category_city')." WHERE  upid='$cityupid' ORDER BY displayorder ASC");
		   
		   
		   if($categorycityarr){


			     foreach($categorycityarr as $value){
					     
						 $selectarr[]=array('catid'=>$value['catid'],'name'=>$value['name'],'type'=>$appid,'upid'=>2,'code'=>$value['catid']);

				 }
				 
			   
		   }
		  
		  //city end------------------------------------------------------------------------------------------------------------------------------------
		  
		  
		  
		  

		 
		  $select='<div class="task_select_title">
              <h2>按条件选择</h2>
              <ul>';
			  
		  $selectcatid=array();
			
			
		  	
		  foreach($selectarr as $catid){
			 
				 if($catid['upid']==0){
					    $selectcatid[$catid['catid']]=$catid['name'];
						
						
						foreach($itemarr as $itemid=>$itemvalue){
						
							   if($itemid == $catid['catid']  && $itemvalue[0]>0){
									 
									 $itemname='';
									 foreach($selectarr as $subclass){
										 
										   if($subclass['upid']==$itemid && $subclass['catid']==$itemvalue[0]){
											     $itemname=$subclass['name'];
												 if(!empty($subclass['title'])){
													   $this->seotitle=$subclass['title'];
												 }else{
													   if(!empty($this->seotitle)){
														    $this->seotitle.=' - '.$itemname;
													   }else{
													        $this->seotitle.=$itemname;
													   }
												 }
												 if(!empty($subclass['keywords'])){
												       $this->seokeywords.=$subclass['keywords'];
										         }
												 
												 if(!empty($subclass['description'])){
												 
												       $this->description.=$subclass['description'];
												 }
										   }
									 }
									 
									 $select.='<li><a href="'.$this->selecturlall.$this->DeleteSelectURL($itemarr,$itemid).'">'.$catid['name'].':'.$itemname.'</a></li>';
								   
							   }
						}
						
					
				 }
		  }
		  
		  
		  
		  //category --------------------------------------------------

		  
		  if($categoryupid>0){
			      $subclassname='';
			      if(!empty($uparr['name'])){
					    $subclassname=$uparr['name'].'分类:';
				  }

			      $subclassuparr=$this->GetMysqlOne('*'," ".$this->GetTable('category')." WHERE type='$appid' AND  catid='$categoryupid'");
				  
				  if(!empty($subclassuparr['name'])){
					    $this->seotitle.=' - '.$subclassuparr['name'];
				  }
				  
				  if(!empty($subclassuparr['keywords'])){
					    $this->seokeywords=$subclassuparr['keywords'];
				  }
				   
				  if(!empty($subclassuparr['description'])){
				   
						$this->description=$subclassuparr['description'];
				  }
				  
			      $select.='<li><a href="'.$this->selecturlall.$this->DeleteSelectURL($itemarr,100000).'">'.$subclassname.$subclassuparr['name'].'('.$subclassuparr['total'].')</a></li>';
		  }
                
		  //category end--------------------------------------------------
		  
		  
		  
		  
		   //city --------------------------------------------------
		  
		  $cityupid=0;
		  foreach($itemarr as $keyid=>$value){
			    if($keyid==100001){
					
					 $cityupid=intval($value[0]);
					  
				}
		  }

		  
		  if($cityupid>0){
			      $subclassname='';
			      if($cityuparr['name']){
					    $subclassname=$cityuparr['name'].'分类:';
				  }
				  
			      $subclassuparr=$this->GetMysqlOne('*'," ".$this->GetTable('category_city')." WHERE catid='$cityupid'");
				  
				  if(!empty($subclassuparr['name'])){
					    $this->seotitle.=' - '.$subclassuparr['name'];
				  }
				  
			      $select.='<li><a href="'.$this->selecturlall.$this->DeleteSelectURL($itemarr,100001).'">'.$subclassname.$subclassuparr['name'].'</a></li>';
		  }
		  
		  
		  $citysubupid=0;
		  foreach($itemarr as $keyid=>$value){
			    if($keyid==100002){
					
					 $citysubupid=intval($value[0]);
					  
				}
		  }
		  
		  
		  if($citysubupid>0 && $cityupid>0){
			      $subclassname='';
			      if($cityuparr['name']){
					    $subclassname=$cityuparr['name'].$subclassuparr['name'].'分类:';
				  }
				  
				  $citysubuparr=$this->GetMysqlOne('name'," ".$this->GetTable('category_city')." WHERE  catid='$citysubupid'");
				  
				  if(!empty($citysubuparr['name'])){
					    $this->seotitle.=' - '.$citysubuparr['name'];
				  }
				  
			      $select.='<li><a href="'.$this->selecturlall.$this->DeleteSelectURL($itemarr,100002).'">'.$subclassname.$citysubuparr['name'].'</a></li>';
		  }
		  
                
		  //city end--------------------------------------------------
		  
		  
		  if(!$this->IsWap()){
			   $moreselect='<em><a href="'.$this->GetSelectAllURL('select',1).'">使用多选</a></em>';
		  }else{
			   $moreselect='';
		  }  
		  
				  
           $select.='</ul>'.$moreselect.'</div><div class="task_if_select"><ul id="last_if_select">';
		   
		   
		
		  
		  
		  //category --------------------------------------------------
	      if($categorycatid>0 && !$categoryupid){
		   
				$categoryarrs=$this->GetMysqlArray('*'," ".$this->GetTable('category')." WHERE  type='$appid' AND  upid='$categorycatid' ORDER BY displayorder ASC");
					   
	            $catidkey=100000;
				$select.='<li><dfn>'.$uparr['name'].'('.$uparr['total'].')：</dfn><div style="width: 660px;">';
					   
					   foreach($categoryarrs as $key=>$value){
		                     
											 
							 $select.='<a href="'.$this->selecturl.$this->GetSelectURL($itemarr,$catidkey,$value['catid']).'">'.$value['name'].'('.$value['total'].')</a>';
								
													
								
					   }
					   
				 $select.='</div></li>';
				 
		  }
	
		  
		  
		  

		 //category end--------------------------------------------------
		 
		 
		 
		  //city --------------------------------------------------
	      if($citycatid>0 && !$cityupid){
		   
				$categorycityarrs=$this->GetMysqlArray('*'," ".$this->GetTable('category_city')." WHERE upid='$citycatid' ORDER BY displayorder ASC");
					   
	            $catidkey=100001;
				$select.='<li><dfn>'.$cityuparr['name'].'：</dfn><div>';
				        
					   	
					   foreach($categorycityarrs as $key=>$value){
			
								 
											 
							 $select.='<a href="'.$this->selecturl.$this->GetSelectURL($itemarr,$catidkey,$value['catid']).'">'.$value['name'].'</a>';
								
													
								
					   }
					   
				 $select.='</div></li>';
		  }
		  
		  

		  
		  if($citycatid>0 && $cityupid>0 && !$citysubupid){
			  
			     
				$categorycityarrs=$this->GetMysqlArray('*'," ".$this->GetTable('category_city')." WHERE upid='$cityupid' ORDER BY displayorder ASC");
				
				$cityupsubarr=$this->GetMysqlOne('*'," ".$this->GetTable('category_city')." WHERE  catid='$cityupid'");
					   
	            $catidkey=100002;
				$select.='<li><dfn>'.$cityuparr['name'].$cityupsubarr['name'].'：</dfn><div>';
				
					   foreach($categorycityarrs as $key=>$value){
			
								 
											 
							 $select.='<a href="'.$this->selecturl.$this->GetSelectURL($itemarr,$catidkey,$value['catid']).'">'.$value['name'].'</a>';
								
													
								
					   }
					   
				 $select.='</div></li>';

		  }

		 //city end--------------------------------------------------
				 



 
		   //showlist
		   $showmore=empty($_GET['more']) ? 0 : intval($_GET['more']);
		   
		   
		   $count=0;
		   
		   foreach($selectcatid as $keys=>$svalue){
			      
				  if(!$showmore){
					   if($count>3){
						     break;
					   }
				  }
			      
			      
				  $iskey=0;
				  
			      foreach($itemarr as $itemid=>$itemvalue){
					  
					     if($itemid == $keys && $itemvalue[0]>0){
							  
							    $iskey=1;
							
						 }elseif($keys==1 && $itemvalue[0]>0){
							
								if(!$categorycatid && $categoryupid>0){
									  $iskey=1;
								}

						 }elseif($keys==2 && $itemvalue[0]>0){
							
								if(!$citycatid && $cityupid>0){
									  $iskey=1;
								}

						 }
						 
				  }
				  
			      if(!$iskey){
			   
			   
			              
						  $select.='<li><dfn>'.$svalue.'：</dfn><div>';
									   
	  
					
						   foreach($selectarr as $key=>$value){
								
								
								if($value['upid']==$keys){
														
										
										//if($this->IsWap()){
											 //$select.='<p><a href="'.$this->selecturl.$this->GetSelectURL($itemarr,$keys,$value['catid']).'">'.$value['name'].'</a></p>';
										//}else{
										     $select.='<a href="'.$this->selecturl.$this->GetSelectURL($itemarr,$keys,$value['catid']).'">'.$value['name'].'</a>';
										//}
								
								}
									 
						   }
											  
						  
											  
						  $select.='</div></li>';
						  
						  
					
				  }
				  
				  $count++;
			   
		   }
		   
		   
		   
		   
		   
		   $select.='</ul></div>';
		   
		   
		   return array($select,$selectarr,$this->seotitle,$this->seokeywords,$this->description);
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
	
	 
	function GetSelectURL($itemarr,$catid=0,$subclass=0,$isadd=0,$itemval=''){
	
           if(S_REWRITE_URL && !$this->IsWap()){
			     
				 if(PHPAPP::$config['rewrite_type']==1){
					   $selecturl='/item/';
				 }else{
				       $selecturl='-item-';
				 }
				 
		   }else{
			   
		         $selecturl='&item=';
		   
		   }
		   
		   
		   
		   if($itemval){
			   
			     $newselect='';
			     $selecturl=$this->selecturl.$selecturl.=$itemval;
			    
		   }else{
                 
				 $newselect=$catid.'.'.$subclass;
				  
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
		   }
		
		   if(!$isadd){
			    $selecturl.=$newselect;
		        return $selecturl.$this->MakeSelectAllURL();
		   }else{ 

			     return $selecturl;
	
		   }
	}
	
	function DeleteSelectURL($itemarr,$catid=0){
		  
		   if(S_REWRITE_URL && !$this->IsWap()){
			     
				 if(PHPAPP::$config['rewrite_type']==1){
					   $selecturl='/item/';
				 }else{
				       $selecturl='-item-';
				 }
				 
		   }else{
			   
		         $selecturl='&item=';
		   
		   }
		   
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

		  if($selecturl!='&item=' || $selecturl!='-item-' || $selecturl!='/item/'){
			    return $selecturl.$this->MakeSelectAllURL();
		  }else{
			    return $this->MakeSelectAllURL();
		  } 
		  
	}
	
	 
	 
	function MakeSelectAllURL($id='',$value=0){
		   
		   $selecturl='';
		   foreach($this->selectarray as $select){
                   
				   if($id==$select['id']){
						 if(S_REWRITE_URL && !$this->IsWap()){
							   
							   if(PHPAPP::$config['rewrite_type']==1){
								     $selecturl.='/'.$select['id'].'/'.$value;
							   }else{
							         $selecturl.='-'.$select['id'].'-'.$value;
							   }
							   
							   
						 }else{
							 
						       $selecturl.='&'.$select['id'].'='.$value;
						 }
				   }else{
					    
						 $getvalue=empty($_GET["$select[id]"]) ? 0 : intval($_GET["$select[id]"]);
						 
						 if(S_REWRITE_URL && !$this->IsWap()){
							   
							   if($getvalue>0){
								    if(PHPAPP::$config['rewrite_type']==1){
										
										 $selecturl.='/'.$select['id'].'/'.$getvalue;
									}else{
									     $selecturl.='-'.$select['id'].'-'.$getvalue;
									
									}
							   }else{
						            if(PHPAPP::$config['rewrite_type']==1){
										  $selecturl.='/'.$select['id'].'/0';
									}else{
									      $selecturl.='-'.$select['id'].'-0';
									}
							   }
							 
							 
						 }else{
							   if($getvalue>0){
									$selecturl.='&'.$select['id'].'='.$getvalue;
							   }else{
						  
									$selecturl.='&'.$select['id'].'=0';
							   }
						 }
						
				   }
						 
				  
				 
		   }
		   
		   if(S_REWRITE_URL && !$this->IsWap()){
			     $ishtml='.html';
		   }else{
			     $ishtml='';
		   }
		   
		   return $selecturl.$ishtml;
	}
	 
	 
	function GetSelectAllURL($id='',$value=0,$catid=''){
		    			
			if($catid){
				 $itemarr=$catid;
			}else{
		         $itemarr=$this->SelectGetData();
			}

		    
		    return  $this->selecturl.$this->GetSelectURL($itemarr,0,0,1).$this->MakeSelectAllURL($id,$value);
	}
	
	
	function GetSelectOneSQL($selectarr,$appid,$city='cityid',$iscityid=0){
		   
		   $itemarr=$this->SelectGetData();
            
		   //page
		   $page=20;
			
		   $wheresql='';
		   
		   $selectsql='';
		   
		   $category='';
		   
		   $categorysubclass='';
		   
		   $categorysql=' AND catid IN(';
									   					   
		   $categorycity='';
		   
		   $categorycitysubclass='';
		   
		   $categorycitysql=' AND '.$city.' IN(';
									   
           
		   foreach($selectarr as $sarr){
			      
				  foreach($itemarr as $key=>$value){
			      
				           if($sarr['upid']==$key){
							     
								 foreach($value as $keyif=>$val){
					                  
									  if($sarr['catid']==$val){
					 
											  if($key==9){
			  
													   $page=intval($sarr['code']);
												  
														 
											   }elseif($key==2){
													 
													 if($categorycity){
														 
														   $categorycity.=','.intval($sarr['code']);
															
													 }else{
														 
														   $categorycity.=intval($sarr['code']);
														 
													 }
			  
											   }elseif($key==1){
													 
													 if($category){
														 
														   $category.=','.intval($sarr['code']);
															
													 }else{
														 
														   $category.=intval($sarr['code']);
														 
													 }
													
													
											   }else{
												   
													 if($sarr['code']){
														    if($keyif>0){
																 $selectsql.=' OR '.$sarr['code'];
															}else{
															     $selectsql.=' AND '.$sarr['code'];
															}
													 }
													 
											   }
									     }
								 
								  }
						   }
			   
		          }
			   
		   }
		   
		   
		   foreach($itemarr as $key=>$value){
					 
					if($key==100000){
								 
 
								foreach($value as $val){
									
										if($categorysubclass){
										 
									             $categorysubclass.=','.intval($val);
										}else{
								   
												 $categorysubclass.=intval($val);
											   
										} 
							    }
	
							   
					 }
					 
		   }
		   
		   
		    foreach($itemarr as $key=>$value){
					 
					if($key==100001){
						
							 foreach($value as $val){	 
									 if($categorycitysubclass){
										 
										   $categorycitysubclass.=','.intval($val);
											
									 }else{
										 
										   $categorycitysubclass.=intval($val);
										 
									 } 
							 }
							   
					 }
					 
		   }
		   
		   
		   foreach($itemarr as $key=>$value){
					 
					if($key==100002){
						
							 foreach($value as $val){	 
							 
									 if($categorycitysubclass){
										 
										   $categorycitysubclass.=','.intval($val);
											
									 }else{
										 
										   $categorycitysubclass.=intval($val);
										 
									 } 
							 }
							   
					 }
					 
		   }
		   

		   if($category){
			     
	
			     $categorysql.=$category;
   
			     if(!$categorysubclass){
					   
					   $categoryarr=$this->GetMysqlArray('*'," ".$this->GetTable('category')." WHERE  type='$appid' AND  upid='$category' ORDER BY displayorder ASC");
					   
					   foreach($categoryarr as $value){
						    $categorysql.=','.$value['catid'];
					   }
					   
					   
					   $categorysql.=')';
				 }else{
					
					   $categorysql.=','.$categorysubclass.')';
					   
				 }
				 
				 
				 $wheresql.=$categorysql;
				
				
		   }
		   

		   if(!$category && $categorysubclass){
			      
				  $categorysql.=$categorysubclass.')';
				  $wheresql.=$categorysql;
				  
		   }


          if(!$iscityid){
				if($this->nowcity>0){
					  $categorycity=$this->nowcity;
				}
		  }

          if($categorycity){
			    
			     $categorycitysql.=$categorycity;
 
			     if(!$categorycitysubclass){
					  
					   $categoryarr=$this->GetMysqlArray('*'," ".$this->GetTable('category_city')." WHERE  upid='$categorycity' ORDER BY displayorder ASC");
					   
					   $categorycityonesql='';
					   foreach($categoryarr as $value){
						    if($categorycityonesql){
						         $categorycityonesql.=','.$value['catid'];
							}else{
								 $categorycityonesql=$value['catid'];
							}
					   }
					  
					   $categoryarr=$this->GetMysqlArray('*'," ".$this->GetTable('category_city')." WHERE  upid IN($categorycityonesql) ORDER BY displayorder ASC");
					   
					   if($categoryarr){
					   
							 foreach($categoryarr as $value){
								  $categorycitysql.=','.$value['catid'];
							 }
							 
							 $categorycitysql.=')';
					   }else{
						     
							 $categorycitysql.=','.$categorycityonesql.')';
						   
					   }
					   
				 }else{
					   
					   $categoryarr=$this->GetMysqlArray('*'," ".$this->GetTable('category_city')." WHERE  upid IN($categorycitysubclass) ORDER BY displayorder ASC");
					   
					   foreach($categoryarr as $value){
						    $categorycitysql.=','.$value['catid'];
					   }
					   
					   $categorycitysql.=','.$categorycitysubclass.')';
					   
				 }
				 
				 
				 $wheresql.=$categorycitysql;
			
				 
		   }

		   
		   if(!$categorycity && $categorycitysubclass){
			       
				  $categoryarr=$this->GetMysqlArray('*'," ".$this->GetTable('category_city')." WHERE  upid IN($categorycitysubclass) ORDER BY displayorder ASC");
				   
				   $categorysubsql='';
				   
				   foreach($categoryarr as $value){
					    if($categorysubsql){
						      $categorysubsql.=','.$value['catid'];
						}else{
							  $categorysubsql.=$value['catid'];
						}
				   }
				   
				  $categorycitysql.=$categorysubsql;
					  
				  $categorycitysql.=$categorycitysubclass.')';
				  $wheresql.=$categorycitysql;
				  
		   }
		   
		   $wheresql.=$selectsql;
		  
		   
		   return  array($wheresql,$page);
		  
	}
	
	
	
	
	//多选
	function GetSelectMuch($appid=0,$tablename=''){
		  
		  $itemarr=$this->SelectGetData();
	
		  $selectarr=$categoryarr=$this->GetMysqlArray('*'," ".$this->GetTable($tablename)." WHERE status=0 ORDER BY displayorder ASC");
		  
		  
		  //category ------------------------------------------------------------------------------------------------------------------------------------
		  
		  
		   $categoryarr=$this->GetMysqlArray('*'," ".$this->GetTable('category')." WHERE  type='$appid' AND  upid='0' ORDER BY displayorder ASC");
		   
		   
		   if($categoryarr){

	
			   
			     foreach($categoryarr as $value){
					     
						 $selectarr[]=array('catid'=>$value['catid'],'name'=>$value['name'].'('.$value['total'].')','type'=>$appid,'upid'=>1,'code'=>$value['catid']);

				 }
				 
				 
			   
		   }
		  
		  //category end------------------------------------------------------------------------------------------------------------------------------------
		  
		  
		  
		  
		  //city ------------------------------------------------------------------------------------------------------------------------------------
		  


		   $categorycityarr=$this->GetMysqlArray('*'," ".$this->GetTable('category_city')." WHERE  upid='0' ORDER BY displayorder ASC");
		   
		   
		   if($categorycityarr){

	
			   
			     foreach($categorycityarr as $value){
					     
						 $selectarr[]=array('catid'=>$value['catid'],'name'=>$value['name'],'type'=>$appid,'upid'=>2,'code'=>$value['catid']);

				 }
				 
				 
			   
		   }
		  
		  //city end------------------------------------------------------------------------------------------------------------------------------------
		  
		  
		  
		  

		 
		  $select='<div class="task_select_title" id="TaskSelectMuch">
              <h2>按条件选择</h2>
              <ul>';
			  
		  $selectcatid=array();
			
			
		  	
		  foreach($selectarr as $catid){
				 if($catid['upid']==0){
					    $selectcatid[$catid['catid']]=$catid['name'];
						
				 }
		  }
		  
  
           $select.='</ul>
              <em><a href="'.$this->GetSelectAllURL('select',0).'" style="background-position: left 7px;">返回单选</a></em>
              </div><div class="task_if_select_much"><ul id="last_if_select" class="task_select_checkbox">';
		   


 
		   //showlist
		   $showmore=empty($_GET['more']) ? 0 : intval($_GET['more']);
		   
		   
		   $count=0;
		   
		   foreach($selectcatid as $keys=>$svalue){
			      
				  if(!$showmore){
					   if($count>3){
						     break;
					   }
				  }
			      
			      $tabselectkey='class="tabselect"';
				  
				  foreach($itemarr as $itemid=>$itemvalue){
					
						 if($itemid==$keys && $itemvalue[0]!=0){
							 
							    $tabselectkey='';
							    
						 }
				  }
                 

			              
				  $select.='<li><dfn>'.$svalue.'：</dfn>';
							   
				  $select.='<a href="javascript:;"  '.$tabselectkey.' value="'.$keys.'.0">全部</a><div id="Select_ID_'.$keys.'">';
			
				   foreach($selectarr as $key=>$value){
						
						
						if($value['upid']==$keys){
							
							    $tabselect='';
								
							    foreach($itemarr as $itemid=>$itemvalue){
					  
									   if($itemid == $value['upid']){
		                                      
											  foreach($itemvalue as $val){
												    if($val==$value['catid']){
														 $tabselect='class="tabselect"';
													}
											  }
		 
											  
									   }
									   
								}
							
								
								$select.='<a href="javascript:;" value="'.$keys.'.'.$value['catid'].'" '.$tabselect.'>'.$value['name'].'</a>';
						
						}
							 
				   }
									  
				  
									  
				  $select.='</div></li>';
						  
						  
					
				
				  
				  $count++;
			   
		   }
		   
		   
		   
		   
		   
		   $select.='</ul><div class="selectsearch"><input name="Submit" type="button" value="搜 索" id="SubmitSelectSearch" class="form_button select_search"/> <input name="Submit" type="button" value="重 置" id="SelectReset" class="form_button select_search"/></div></div>';
		   
		   
		   return array($select,$selectarr,$this->seotitle,$this->seokeywords);
	}
	
	
	
	 
}
 
?>