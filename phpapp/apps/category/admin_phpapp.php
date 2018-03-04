<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class CategoryManageControls extends PHPAPP{
	
    private $actionmenu,$POST,$GET;
	
	function __construct($actionmenu=''){	
            
		   parent::__construct();
		   
	       $this->actionmenu=$actionmenu;
		   
		   $postkey=array('Submit'=>'','value'=>'','Add'=>'');
		   
		   $this->POST=$this->POSTArray();
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','action','value'));
		   
		         
	}
	
	function DefaultAction(){
		
		  return $this->CategoryListAction();
	}
	
	
	function CategoryListAction(){
		  
		  
		  $appid=empty($this->GET['value'])? $this->POST['value'] : $this->GET['value']; 
		  
		  
		  if(!empty($this->POST['Displayorder'])){
			  
			   if($_POST['setdisplayorder']){
				     
					 foreach($_POST['setdisplayorder'] as $key=>$value){
						 
						     $catid=intval($key);
							 $value=intval($value);
							 
							 $this->Update('category',array('displayorder'=>$value),array()," WHERE catid='$catid'");
	
					 }
					 
					 $refresh= $this->LanguageArray('phpapp','Edited_successfully');
					  
					 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						
					 exit();
				   
			   }
			  
		  
		  }elseif(!empty($this->POST['Add'])){
			  
			    if($_POST['addcategory']){

					  foreach($_POST['addcategory'] as $key=>$categoryarr){
						     
							 $catid=intval($key);
							  
						     foreach($categoryarr as $value){
								   if($value['name']){
									   $type=intval($value['type']);
									   $name=$this->str($value['name'],100,0,0,1,0,0,1);
									   $displayorder=intval($value['displayorder']);
									   $this->Insert('category',array('upid'=>$catid,'name'=>$name,'type'=>$type,'displayorder'=>$displayorder),array());
								   }
							 }
							   
					  }
					
				}
				
				$refresh= $this->LanguageArray('phpapp','Add_success');
				
				echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					
				exit();
			  
			  
		  }elseif(!empty($this->POST['Submit'])){
               
			   $ids=$this->GetCheckBox($this->POST['checkbox']);
			   
			   if($this->Delete('category'," WHERE catid IN($ids)")){
			  
			        $refresh= $this->LanguageArray('phpapp','Delete_successfully');

			   }else{
				    $refresh= $this->LanguageArray('phpapp','Delete_failed');

			   }
			   
			   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			  
		  
		  }else{
			     
				 if($appid){
					  $typesql=" WHERE type='$appid' AND upid='0' ";
				 }else{
					  
					  $typesql=" WHERE upid='0' "; 
				 }
				 
				 $showlist='';
		         $list=$this->GetMysqlArray('*'," ".$this->GetTable('category')." $typesql ORDER BY displayorder ASC ");
                  
				 if($list){ 
				 
				        $this->CategoryNum=0;
						
                        $this->GetCategoryData($list,0,$appid);
						
						$showlist=$this->CategoryData;
						
						unset($this->CategoryData);
				  
				 }
				 
				 $apps=$this->GetMysqlArray('id_phpapp,name_phpapp'," ".$this->GetTable('apps')." WHERE id_phpapp>40");
		  
		         include $this->Template('show_manage');
		  }
	}
	
	
	function GetCategoryData($list,$catid=0,$appid=0,$isone=0){
		    
			
			foreach($list as $key=>$value){
				    
					if($isone){
						   
						   $pleft=0;
						   if($this->CategoryNum){
							   
							     for($i=0;$i<$this->CategoryNum;$i++){
							          $pleft+=30;
						         }
								 
						   }
						   
						   
						   $this->CategoryData.='<li class="category_item" id="CatidID'.$value['catid'].'"><span class="checkbox_category"><input name="checkbox[]" type="checkbox" value="'.$value['catid'].'" /></span><span class="subclass_icon" style="padding-left:'.($pleft+60).'px"></span><input name="setdisplayorder['.$value['catid'].']" type="text" class="form_input_text form_input_width_50 add_subclass" value="'.$value['displayorder'].'"/><span style="padding-left:8px;color:'.$value['color'].'">'.$value['name'].'</span> <span class="smallnum">(ID '.$value['catid'].')</span> <span class="show_add"><a class="small green awesome" onclick="AddSubclass('.$value['catid'].','.($pleft+90).','.$value['type'].')">添加下级</a></span> <span class="category_edit"><a href="'.$this->MakeGetParameterURL(array('action'=>3,'id'=>$value['catid'],'value'=>$value['type'])).'">[编辑]</a></span><span class="category_order">'.$value['route'].'</span></li>';
						   $this->CategoryNum+=1;
						  
					}else{
						
						   $this->CategoryNum=0;
					       $this->CategoryData.='<li class="datalist_h2 category_item" id="CatidID'.$value['catid'].'"><span class="checkbox_category"><input name="checkbox[]" type="checkbox" value="'.$value['catid'].'" /></span><input name="setdisplayorder['.$value['catid'].']" type="text" class="form_input_text form_input_width_50 add_subclass" value="'.$value['displayorder'].'"/> <span style="color:'.$value['color'].'">'.$value['name'].'</span> <span class="smallnum">(ID '.$value['catid'].')</span> <span class="show_add"><a class="small green awesome" onclick="AddSubclass('.$value['catid'].','.($pleft+60).','.$value['type'].')">添加下级</a></span> <span class="category_edit"><a href="'.$this->MakeGetParameterURL(array('action'=>3,'id'=>$value['catid'],'value'=>$value['type'])).'">[编辑]</a></span><span class="category_order">'.$value['route'].'</span></li>';
	
					}
					
					$catid=$value['catid'];
                    
					if($appid){
					      $typesql=" AND type='$appid' ";
					}else{
						  $typesql='';
					}
					
					
				    $subclass=$this->GetMysqlArray('*'," ".$this->GetTable('category')." WHERE upid='$catid' $typesql ORDER BY displayorder ASC ");
					
					if($subclass){
						  $this->GetCategoryData($subclass,$catid,$appid,1);
					}
					
					$this->CategoryNum--;
				  
			}

				
	}
	
	function GetCategoryCityData($list,$catid=0,$appid=0,$isone=0){
		    
			
			foreach($list as $key=>$value){
				    
					if($isone){
						   
						   $pleft=0;
						   if($this->CategoryNum){
							   
							     for($i=0;$i<$this->CategoryNum;$i++){
							          $pleft+=30;
						         }
								 
						   }
						   
						    $this->CategoryData.='<li class="category_item" id="CatidID'.$value['catid'].'"><span class="checkbox_category"><input name="checkbox[]" type="checkbox" value="'.$value['catid'].'" /></span><span class="subclass_icon" style="padding-left:'.($pleft+60).'px"></span><input name="addcategory['.$value['catid'].']" type="text" class="form_input_text form_input_width_50 add_subclass" value="'.$value['displayorder'].'"/><span style="padding-left:8px;">'.$value['name'].'</span> <span class="smallnum">(ID '.$value['catid'].')</span> <span class="show_add"><a class="small green awesome" onclick="AddSubclass('.$value['catid'].','.($pleft+90).','.$value['level'].')">添加下级</a></span> <span class="category_edit"><a href="'.$this->MakeGetParameterURL(array('op'=>1,'id'=>$value['catid'])).'">[编辑]</a></span><span class="category_order">'.$value['displayorder'].'</span></li>';
							
						   $this->CategoryNum+=1;
						  
					}else{
						
						   $this->CategoryNum=0;
						   
						   $this->CategoryData.='<li class="datalist_h2 category_item" id="CatidID'.$value['catid'].'"><span class="checkbox_category"><input name="checkbox[]" type="checkbox" value="'.$value['catid'].'" /></span><input name="addcategory['.$value['catid'].']" type="text" class="form_input_text form_input_width_50 add_subclass" value="'.$value['displayorder'].'"/> <span style="color:'.$value['color'].'">'.$value['name'].'</span> <span class="smallnum">(ID '.$value['catid'].')</span> <span class="show_add"><a class="small green awesome" onclick="AddSubclass('.$value['catid'].','.($pleft+60).','.$value['level'].')">添加下级</a></span> <span class="category_edit"><a href="'.$this->MakeGetParameterURL(array('op'=>1,'id'=>$value['catid'])).'">[编辑]</a></span><span class="category_order">'.$value['displayorder'].'</span></li>';
						   
	
					}
					
					$catid=$value['catid'];

					
				    $subclass=$this->GetMysqlArray('*'," ".$this->GetTable('category_city')." WHERE upid='$catid' ORDER BY displayorder ASC ");
					
					if($subclass){
						  $this->GetCategoryCityData($subclass,$catid,$appid,1);
					}
					
					$this->CategoryNum--;
				  
			}

				
	}

	
	function EditCategoryAction(){
		
		 //技能
		 $skillsarr=$this->GetMysqlArray('*'," ".$this->GetTable('skills')." ");
		 
		 
		 $appid=empty($this->GET['value'])? $this->POST['value'] : $this->GET['value'];
		 
		 $catid=empty($this->GET['id'])? 0 : $this->GET['id'];
	
		 $categoryarr=$this->GetMysqlOne('*'," ".$this->GetTable('category')." WHERE catid='$catid'");
		 
		 if($categoryarr){
			  $category=$this->GetMysqlOne('*'," ".$this->GetTable('category')." WHERE catid='$category[upid]'");
		 }
		 
         $apps=$this->GetMysqlArray('id_phpapp,name_phpapp'," ".$this->GetTable('apps')." WHERE id_phpapp>40");
		 
			   
		  if($this->POST['Submit']){
				
				if($catid>0){
					
					   $skills='';
					   
					   if($_POST['skills']){
						     
							  foreach($_POST['skills'] as $value){
								     if($skills){
										   $skills.=','.intval($value);
									 }else{
								     	   $skills=intval($value);
									 }
							  }
						   
					   }
			
					  $this->POST['skills']=$skills;
					  
					  
					  //封面
					 include_once(Core.'/class/photo_upload_phpapp.php');

  
					 if($_FILES['logophoto']['size']>0){
						   
						   if($_FILES['logophoto']['size']> intval(PHPAPP::$config['oneimageuploadsize'])){
									$errors='对不起!您上传的图片不能超过 '.(PHPAPP::$config['oneimageuploadsize']/1024).'KB,请重新上传！'; 										                                                        
									$this->Refresh($errors,$this->MakeGetParameterURL());							   
						   }
						   
						   $logoid=empty($categoryarr['logo']) ? 0 : intval($categoryarr['logo']);
						   
						   $upload=new UploadPhoto($_FILES['logophoto'],$logoid,100,100);
						   $this->POST['logo']=$upload->CheckUpload();
						   
					 }else{
						   
						   if(!empty($category['logo'])){
								 
								 $this->POST['logo']=intval($category['logo']);
							   
							   
						   }
						  
					 }			 
 
					 
					  $this->Update('category',$this->POST,array()," WHERE catid='$catid'");
					  
					  $refresh= $this->LanguageArray('phpapp','Edited_successfully');
					  
					  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						
					  exit();
					  
				}
			  
		  }else{
				if($catid>0){
					 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('category')." WHERE catid='$catid'");

					 $nowskillsarr=explode(',',$manage['skills']);
				}else{
					 $manage='';
				}
				
				
				include $this->Template('add_manage');
		  }
	  
	
	 }
	
	
	 function UpdateCountAction(){
		    
			
			if($this->POST['Submit']){
				
				  
				   if($this->POST['appid']>0){
					   
					      $appid=$this->POST['appid'];
					     
						  $categoryarr=$this->GetMysqlArray('catid,name'," ".$this->GetTable('category')." WHERE type='$appid' ");

                          foreach($categoryarr as $value){
							  
						        $this->RemoveCategoryCount($value['catid']);
						  
						  }

				   }
			
				   echo $this->Refresh('<p>更新成功!</p>',$this->MakeGetParameterURL());
				   exit();
				  
				
			}else{
		
				  $apps=$this->GetMysqlArray('id_phpapp,name_phpapp'," ".$this->GetTable('apps')."");
			   
			  
				  include $this->Template('updatecount');
			
			}
	 }
	 
	 
	 function RemoveCategoryCount($catid=0){
		    
			 //更新上级
			 $categoryone=$this->GetMysqlOne('*'," ".$this->GetTable('category')." WHERE  catid='$catid' ");
		
				
			 if($categoryone){
					
						
						$this->Update('category',array('total'=>0),array(),"WHERE catid='$catid'");
						
			            
						$upid=$categoryone['upid'];
						
						
					    $categoryarr=$this->GetMysqlOne('*'," ".$this->GetTable('category')." WHERE  catid='$upid' ");
						
						
						if($categoryarr){
								
								$this->UpdateCategoryCount($upid);
							 
						}
						
			
			}
			 
	}
	
	
}


?>