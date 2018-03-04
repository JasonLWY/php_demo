<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(Core.'/class/filter_class_phpapp.php');
include_once(Core.'/class/pages_class_phpapp.php');
include_once(Core.'/class/admin_class_phpapp.php');

class AdministratorManageControls extends PHPAPP{
	
	public $actionmenu,$POST,$GET;
	
    public $catid='',$upid='',$levelid='',$menulist='',$windowslist=''; 
	
	
	function __construct($menulist=''){	 
	        
		   parent::__construct();
		   
		   $this->app=empty($_GET['app']) ? 1 : $_GET['app'];
		   $this->ac=empty($_GET['action']) ? 0 : $_GET['action'];
			
	       $postkey=array('Submit'=>'','appid'=>'','Allow_All'=>'','checkbox'=>'','Hide'=>'','Show'=>'','Update'=>'','Close'=>'','Open'=>'');
	
	       $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','action','value'));
		   
		   $this->POST=$this->POSTArray();
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
		   
	}
	
	
	//Ĭ��
	public function DefaultAction(){
		
		   if(!file_exists(SYS.'/data/cache/admin/admin_tabmenu_htm.php')){
		         $this->UpdateAdminMenu();
		   }

		   $admin=$this->GetMysqlOne('admingroup'," ".$this->GetTable('member')." WHERE uid='$this->uid'");
		   
		   $admingroup=$admin['admingroup'];
		   
		   $grouparray=$this->GetMysqlOne('name_phpapp,app_phpapp'," ".$this->GetTable('admin')." WHERE id_phpapp='$admingroup'");
		   
		   $manageapp=$grouparray['app_phpapp'];

		   include $this->Template('admin');
		
	}
		
		
		
	function UpdateAdminMenu(){
		   
		   $tabmenulist=$submenulist='';
	   
		   $tabmenuarr=$this->GetMysqlArray('catid_phpapp,upid_phpapp,name_phpapp',$this->GetTable('admin_menu').' WHERE catid_phpapp!=1 AND status_phpapp=0  AND upid_phpapp=1 OR catid_phpapp=2 ORDER BY displayorder_phpapp ASC'); 
		   
		   $subclass=array();
		   if($tabmenuarr){
			   
			     foreach($tabmenuarr as $key=>$value){
                        
						if($key==0){
						     $tab=' class="tab"';
						}else{
						     $tab='';
						}
						
						$tabmenulist.='<li'.$tab.' id="MainMenu'.$value['catid_phpapp'].'"><a href="javascript:;" onclick="TabMenu('.$value['catid_phpapp'].')">'.$value['name_phpapp'].'</a></li>';
						
						$subclass[]=$value['catid_phpapp'];
				 }
			   
		   }
		   

           $this->WriteFile(SYS.'/data/cache/admin/admin_tabmenu_htm.php',$tabmenulist);
		   
		   
		   if($subclass){
              
				  foreach($subclass as $subkey=>$id){
						  
						  if($subkey!=0){
								$subtab=' style="display:none"';
						  }else{
								$subtab='';
						  }
						  
						  
						  $submenulist.='<ul id="MenuList'.$id.'" '.$subtab.'>'."\n";
						  
					
							   $menulist=$this->GetMysqlArray('catid_phpapp,upid_phpapp,name_phpapp,action_phpapp,apps_phpapp'," ".$this->GetTable('admin_menu')." WHERE upid_phpapp='$id' AND status_phpapp=0 ORDER BY displayorder_phpapp ASC"); 
				
							  
							   if($menulist){
									 
									 foreach($menulist as $key=>$value){
											
						 
											 $submenulistarray=$this->GetMysqlArray('catid_phpapp,upid_phpapp,name_phpapp,action_phpapp,apps_phpapp'," ".$this->GetTable('admin_menu')." WHERE upid_phpapp='$value[catid_phpapp]' AND status_phpapp=0 ORDER BY displayorder_phpapp ASC"); 
	
											 $submenucss=$moretab='';
											 
											 if($submenulistarray){
												 
												   $submenucss=' class="moremenu"';
												   $moretab='href="javascript:;" onclick="MoreTab('.$value['catid_phpapp'].','.$id.')"';
											 
											 }else{
												 
												   if($key==0){ 
														$submenucss=' class="tab"';
												   }
	
												   $moretab='href="?menu='.$value['catid_phpapp'].'&app='.$value['apps_phpapp'].'&action='.$value['action_phpapp'].'" target="main" onclick="MenuList(this,'.$id.','.$value['catid_phpapp'].')"';
											 
											 }
											 
	
											  $submenulist.='<li id="MenuID'.$value['catid_phpapp'].'" '.$submenucss.'><a '.$moretab.'>'.$value['name_phpapp'].'</a>';
			                                  
											  if($submenulistarray){
												  
													 $submenulist.='<ul id="MoreTab'.$value['catid_phpapp'].'">';
													
														  foreach($submenulistarray  as $submenukey=>$subvalue){
														 
																$submenulist.='<li id="MenuID'.$subvalue['catid_phpapp'].'" class="submenu"><a href="?menu='.$subvalue['catid_phpapp'].'&app='.$subvalue['apps_phpapp'].'&action='.$subvalue['action_phpapp'].'" target="main" onclick="MenuList(this,'.$id.','.$subvalue['catid_phpapp'].')">'.$subvalue['name_phpapp'].'</a></li>';
														 
														  }
													 
													 $submenulist.='</ul>'."\n";  
												 
											  }
											
										      $submenulist.='</li>'."\n";  
											
									 }
							  }else{
								  
								    
								     $value=$this->GetMysqlOne('catid_phpapp,upid_phpapp,name_phpapp,apps_phpapp,action_phpapp'," ".$this->GetTable('admin_menu')." WHERE catid_phpapp='$id' AND status_phpapp=0 ORDER BY displayorder_phpapp ASC"); 
									 
									 if($value){
										    
											$moretab='href="?menu='.$value['catid_phpapp'].'&app='.$value['apps_phpapp'].'&action='.$value['action_phpapp'].'" target="main" onclick="MenuList(this,'.$id.','.$value['catid_phpapp'].')"';
											$submenucss=' class="tab"';
											 
										    $submenulist.='<li id="MenuID'.$value['catid_phpapp'].'" '.$submenucss.'><a '.$moretab.'>'.$value['name_phpapp'].'</a>';
										   
										 
										    $submenulist.='</li>'."\n";  
											
											
											if($value['apps_phpapp']==10){
															   
																	   
												   $categorycity=$this->GetMysqlOne('*',"".$this->GetTable('admin_menu')." WHERE apps_phpapp='1' AND action_phpapp=43");
												   
												   
												   $moretab='href="?menu='.$categorycity['catid_phpapp'].'&action='.$categorycity['action_phpapp'].'" target="main" onclick="MenuList(this,'.$id.','.$categorycity['catid_phpapp'].')"';
												   $submenulist.='<li id="MenuID'.$categorycity['catid_phpapp'].'"><a '.$moretab.'>'.$categorycity['name_phpapp'].'</a>';
							 
												   $submenulist.='</li>'."\n";
													
												
												   $categoryarray=$this->GetMysqlArray('type'," ".$this->GetTable('category')." GROUP BY type ORDER BY displayorder ASC"); 
                                                   
												   if($categoryarray){
													     
														 $typeid='';
														 foreach($categoryarray as $category){
														        
																if($typeid){
																	  
																	  $typeid.=','.$category['type'];
																
																}else{
																	
																	  $typeid=$category['type'];
																}
														 
														 }
														
														 if($typeid){
													
													           $appsarray=$this->GetMysqlArray('id_phpapp,name_phpapp'," ".$this->GetTable('apps')." WHERE id_phpapp IN($typeid)"); 
															   
															   foreach($appsarray as $apps){
																	   
																	   $catid='0000'.$apps['id_phpapp'];
																	   
																	   $moretab='href="?menu='.$value['catid_phpapp'].'&action='.$value['action_phpapp'].'&value='.$apps['id_phpapp'].'" target="main" onclick="MenuList(this,'.$id.','.$value['catid_phpapp'].$catid.')"';
																	   $submenulist.='<li id="MenuID'.$value['catid_phpapp'].$catid.'"><a '.$moretab.'>'.$apps['name_phpapp'].'</a>';
												 
																	   $submenulist.='</li>'."\n"; 
																   
															   }
													   
														 }
													   
												   }

											}elseif($value['apps_phpapp']==28){
												
												   $adminmenuarray=$this->GetMysqlArray('catid_phpapp,name_phpapp,apps_phpapp,action_phpapp'," ".$this->GetTable('admin_menu')." WHERE desktop_phpapp=0 ORDER BY displayorder_phpapp ASC"); 
                                                   
												   if($adminmenuarray){
													   
													      foreach($adminmenuarray as $default){
															  
																  $moretab='href="?menu='.$default['catid_phpapp'].'&action='.$default['action_phpapp'].'" target="main" onclick="MenuList(this,'.$id.','.$default['catid_phpapp'].')"';
										
																  $submenulist.='<li id="MenuID'.$default['catid_phpapp'].'"><a '.$moretab.'>'.$default['name_phpapp'].'</a>';
																  $submenulist.='</li>'."\n";  
														  }
												   }
												  
												
											}
											
									 }
									 
							  }
						  
						      $submenulist.='</ul>'."\n";   
					}
              
		   }

		   
		   $this->WriteFile(SYS.'/data/cache/admin/admin_menulist_htm.php',$submenulist);
		 
		    
	}
	
	
	function CategoryCityAction(){
		
		   $this->GetMenuList(array(array('name'=>'�����б�','display'=>''),array('name'=>'�༭����','display'=>'none')));
		   
		   include_once(APPS.'/category/admin_phpapp.php');
		   
		   $category=new CategoryManageControls();
		   
		   
		   $catid=empty($this->GET['id'])? 0 : $this->GET['id'];
		   
		   
		   if($this->GET['op']==1){
			   
				 if($this->POST['Submit']){
				
						  if($catid>0){
							   
								$this->Update('category_city',$this->POST,array()," WHERE catid='$catid'");
								
								$refresh= $this->LanguageArray('phpapp','Edited_successfully');
								
								echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								  
								exit();
								
						  }
						
				}else{
					
					  if($catid>0){
						   $manage=$this->GetMysqlOne('*'," ".$this->GetTable('category_city')." WHERE catid='$catid'");
					  }else{
						   $manage='';
					  }
					  
					  
					  include $this->Template('city_manage');
				}
    
			   
		   }else{
		   
		  
					if(!empty($this->POST['Displayorder'])){
					  
						   if($_POST['setdisplayorder']){
								 
								 foreach($_POST['setdisplayorder'] as $key=>$value){
									 
										 $catid=intval($key);
										 $value=intval($value);
										 
										 $this->Update('category_city',array('displayorder'=>$value),array()," WHERE catid='$catid'");
				
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
													   $name=$this->str($value['name'],100,0,0,1,0,0,1);
													   $displayorder=intval($value['displayorder']);
													   $level=intval($value['type'])+1;
													   $this->Insert('category_city',array('upid'=>$catid,'name'=>$name,'displayorder'=>$displayorder,'level'=>$level),array());
												   }
											 }
									  }
									
								}
								
								$refresh= $this->LanguageArray('phpapp','Add_success');
								
								echo $this->Refresh($refresh,$this->MakeGetParameterURL());
									
								exit();
								
					  }elseif(!empty($this->POST['Submit'])){
						 
						 $ids=$this->GetCheckBox($this->POST['checkbox']);
						 
						 if($this->Delete('category_city'," WHERE catid IN($ids)")){
						
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
		  
						 }else{
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');
		  
						 }
						 
						 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						
					
					}else{
						   
						   $catid=empty($this->GET['catid'])? 0 : $this->GET['catid']; 
						   
						   if($catid>0){
											
								   $showlist='';
								   $list=$this->GetMysqlArray('*'," ".$this->GetTable('category_city')." WHERE catid='$catid' ORDER BY displayorder ASC ");
									
								   if($list){ 
								   
										  $category->CategoryNum=0;
										  
										  $category->GetCategoryCityData($list,0,0);
										  
										  $showlist=$category->CategoryData;
										  
										  unset($category->CategoryData);
									
								   }
						   
						   }
							   
						   $cityarr=$this->GetMysqlArray('*'," ".$this->GetTable('category_city')." WHERE upid='0' ORDER BY displayorder ASC ");
						   
					
						   include $this->Template('city_manage');
				 
				 
		          }
		  }
		  
		
	}
	
	function MakeGetDataParameters(){
		
		   if($_POST['data']){
			   
			      $table=str_replace(DB_TNAME,'',$_POST['data']['table']);
				  
				  $type=$_POST['data']['type'];
				  
				  if($type==1){
				  
				        $number=intval($_POST['data']['number']);
				  
				  }else{
					    $number=$_POST['data']['number'];
				  }
				  
				  $where=$_POST['data']['where'];
				  
				  $dateline=$_POST['data']['dateline'];
				  
				  $wheresql='';
				  
				  if($where){
					    $wheresql.=' WHERE '.$where;
				  }
				  
				  $limit='';
				  if($type==1){
					  
					    $limit.='LIMIT 0,'.$number;
						
				  }else{
					    
						$fieldarray=$this->GetMysqlFieldArray($table);
                        $fieldname='';
						if($fieldarray){
                            foreach($fieldarray as $fieldname=>$fieldtype){
                                break;
                            }
                        }
						//$fieldname=$fieldarray[0];
						
						if($fieldname){
							
							 if($wheresql){
								 
								   $wheresql.=' AND '.$fieldname.' IN('.$number.') ';
								   
							 }else{
								   $wheresql.=' WHERE '.$fieldname.' IN('.$number.') ';
							 } 
							
						}
	
				  }
			   
			      
				  $code=htmlspecialchars('{php} $'.$this->POST['key_phpapp'].'array=\$this->GetMysqlArray(\'*\'," ".\$this->GetTable(\''.$table.'\')."  '.$wheresql.' ORDER BY dateline '.$dateline.' '.$limit.'") {/php}',ENT_QUOTES);
		
		   }
		   

		   return array(serialize($_POST['data']),$code);
	}
	
	
	public function SiteSafetyAction(){
		
		    $this->GetMenuList(array(array('name'=>'�û���¼��־','display'=>''),array('name'=>'��¼������־','display'=>''),array('name'=>'��վ��־','display'=>''),array('name'=>'��ȫ����','display'=>'')));
			
			
			//select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(	
														'username'=>array('username','string'),
														'dateline1'=>array('dateline','time'),
														'dateline2'=>array('dateline','time')	  
												      ) 
													  
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }

			  //select end---------------------------------------------------
			
			if($this->GET['op']==3){
				 
				  if($this->POST['Submit']){
				        $this->SetConfig($this->POST);
				  }
				
			}elseif($this->GET['op']==2){
				
				 $logarr=array();
				 
				 $time=$this->POST['dateline'];
				 
				 if($time){
					 
				      $timearr=explode('-',$time);
					  
					  $timey=intval($timearr[0]).$timearr[1];
					  
					  $timej=$timearr[2];
	                  
					  if(is_dir(SYS.'/data/log/'.$timey.'/'.$timej)) {
					       $logarr=$this->ReadSysDir(SYS.'/data/log/'.$timey.'/'.$timej.'/');
					  }
				 
					  if($this->POST['SelectLog']){
	                        
							if($this->POST['select']){
							
							      $readarr=$this->ReadSiteLog(SYS.'/data/log/'.$timey.'/'.$timej.'/'.$this->POST['select']);
							
							}else{
								 
								 echo $this->Refresh('<p>��ѡ����־�ļ���</p>',$this->MakeGetParameterURL());
								 
								 exit();
								
							}
					  }
	             }
			}else{
				
				 
				 if($wheresql){
					   include_once(Core.'/class/pages_class_phpapp.php');
				
					   $orderarr=array(
								array('order'=>'id','name'=>'���'),
								array('order'=>'username','name'=>'�û���'),
								array('order'=>'loginip','name'=>'��¼IP'),
								array('order'=>'dateline','name'=>'��¼ʱ��')
								);
				
					   $order='ORDER BY id DESC';
				
					   $this->GET['iforder']=empty($this->GET['iforder']) ? 2 : $this->GET['iforder'];
	  
					   if($this->GET['iforder']==1){
							$sqlorder=' ASC';
							$iforder=2;
					   }else{
							$sqlorder=' DESC';
							$iforder=1;
					   }
				
					   foreach($orderarr as $key=>$value){
							 if($this->GET['sqlorder']==$key){
								   $order='ORDER BY '.$value['order'].$sqlorder;
							 }
					   }
			           
					   if($this->GET['op']==1){
						     $tablename='member_error';
					   }else{
						     $tablename='login_safe';
					   }
				
					   $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM  ".$this->GetTable($tablename)." $wheresql  $order");
	  
					   $list=$ajaxpage->ShowResult();
				 }
				
			}

			include $this->Template('sitesafety_manage');	
	}

	public function GetDataAction(){
		
		    $this->GetMenuList(array(array('name'=>'��ǩ�б�','display'=>''),array('name'=>'��ӱ�ǩ','display'=>''),array('name'=>'�޸ı�ǩ','display'=>'none'),array('name'=>'Ԥ����ǩ','display'=>'none')));
			
			$list=$this->GetMysqlTableNameArray();
			
			$templateblockarray=$this->GetMysqlArray('*',$this->GetTable('templateblock'));
			
			if($this->GET['op']==1){
				  
				  if($this->POST['Submit']){
					  
					     $parameters=$this->MakeGetDataParameters();
						 
						 $this->POST['parameters_phpapp']=$parameters['0'];
					     
						 $this->POST['code_phpapp']=$parameters['1'];
						 
						 $this->POST['template_phpapp']=htmlspecialchars($this->POST['template_phpapp'],ENT_QUOTES);
					  
						 $this->Insert('getdata',$this->POST,array());

						 echo $this->Refresh($this->LanguageArray('phpapp','Add_success'),$this->MakeGetParameterURL());
								
						 exit();
				  
				  }
				  
				
			}elseif($this->GET['op']==2){
				   
				  $id=$this->GET['id'];
				  
				  if($this->POST['Update']){
					  
					  
					     $this->Update('getdata',array('code_phpapp'=>htmlspecialchars($this->POST['code_phpapp'],ENT_QUOTES),'template_phpapp'=>htmlspecialchars($this->POST['template_phpapp'],ENT_QUOTES)),array()," WHERE id_phpapp='$id'");
							  
						 echo $this->Refresh('<p>���³ɹ���</p>',$this->MakeGetParameterURL());
								
						 exit();
					    
					  
				  
				  }elseif($this->POST['Submit']){
					    
						if($id>0){
							
							  $parameters=$this->MakeGetDataParameters();
						 
						      $this->POST['parameters_phpapp']=$parameters['0'];
					     
						      $this->POST['code_phpapp']=$parameters['1'];
							  
							  $this->POST['template_phpapp']=htmlspecialchars($this->POST['template_phpapp'],ENT_QUOTES);
							 
							  $this->Update('getdata',$this->POST,array()," WHERE id_phpapp='$id'");
							  
							  echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('getdata')." WHERE id_phpapp='$id'");
							 
							 $data=unserialize($manage['parameters_phpapp']);

						}else{
							 $manage='';
						}
				  }
				  
		    }elseif($this->GET['op']==3){
				
				    $id=$this->GET['id'];
				
					if($id>0){
						
						 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('getdata')." WHERE id_phpapp='$id'");
						  
						 $template_content=htmlspecialchars_decode($manage['code_phpapp'],ENT_QUOTES).htmlspecialchars_decode($manage['template_phpapp'],ENT_QUOTES);

						 $this->WriteFile(SYS.'/templates/'.S_TEMPLATE.'/'.PHPAPP::$config['templatepath'].'/templateblock/datatest.htm',$template_content);
				         
						 $this->DelFile(SYS.'/data/cache/templateblock/admin_datatest_htm.php');
						 
						 echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head>';
						 echo '<link rel="stylesheet" href="'.TURL.'admin_common.css">';
                         echo '<link rel="stylesheet" href="'.TURL.'admin_manage.css">';
                         echo '<link rel="stylesheet" href="'.TURL.'form.css">';
	                     echo '<script type="text/javascript" src="'.TURL.'js/jquery-min.js"></script>';
						 echo '</head><body>';
						 echo '<div class="manage_menu"><ul>'.$this->actionmenu.'</ul></div>';
						 
						 include $this->Template('templateblock:datatest');
						 
						 exit();
						 
					}else{
						 $manage='';
					}
				
			}else{  
			
			
			
			       if($this->POST['Show'] || $this->POST['Hide']){
					   
					    if($this->POST['Show']){
							  $status=0;
						}else{
							  $status=1;
						}
					   
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
					   
					    $this->Update('getdata',array('status_phpapp'=>$status),array()," WHERE id_phpapp IN($ids)");
						
						echo $this->Refresh($this->LanguageArray('phpapp','Set_successfully'),$this->MakeGetParameterURL());
					   
					    exit();

				   
				   }elseif($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
			
						if($this->Delete('getdata'," WHERE id_phpapp IN($ids)")){
	
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');

						}
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
						
				   }else{
					   
						 $orderarr=array(
								  array('order'=>'a.id_phpapp','name'=>'ID'),
								  array('order'=>'b.name_phpapp','name'=>'����ģ��'),
								  array('order'=>'a.block_phpapp','name'=>'����'),
								  array('order'=>'a.key_phpapp','name'=>'��ǩ��'),
								  array('order'=>'a.status_phpapp','name'=>'״̬'),
								  );
				  
						 $order='ORDER BY a.id_phpapp ASC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
                              $iforder=2;
						 }else{
							  $sqlorder=' DESC';
							  $iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.label_phpapp FROM ".$this->GetTable('getdata')." AS a LEFT JOIN ".$this->GetTable('templateblock')." AS b ON a.block_phpapp=b.id_phpapp  $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('getdata_manage');		

		
	}
	
	public function MakeHTMLAction(){
		
		  echo '<p>�ù�����ʱ�رգ�</p>';
		  exit();
	}
	
	
	public function ShareAction(){  $this->SystemConfig('sharecodeset',array(array('name'=>'�����������','display'=>''))); }
	
	public function MakeRewriteAction() {
	
	        $this->GetMenuList(array(array('name'=>'Rewrite�б�','display'=>''),array('name'=>'���Rewrite','display'=>''),array('name'=>'����Rewrite','display'=>''),array('name'=>'�޸�Rewrite','display'=>'none')));
	
			$numbertype='{number}';
			
			$abctype='{abc}';
			
			$alltype='{all}';
			
			$andtype='{and}';
			
			
			if($this->GET['op']==1){
				  
				  if($this->POST['Submit']){
  
						 $this->Insert('rewrite',$this->POST,array());

						 echo $this->Refresh($this->LanguageArray('phpapp','Add_success'),$this->MakeGetParameterURL());
								
						 exit();
				  
				  }
				
				
			}elseif($this->GET['op']==3){
				   
				  $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							 
							  $this->Update('rewrite',$this->POST,array()," WHERE id_phpapp='$id'");

							  echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('rewrite')." WHERE id_phpapp='$id'");
						}else{
							 $manage='';
						}
				  }
				  
		    }elseif($this->GET['op']==2){
				   
				   $rewritedir='/';
				   
				   if($this->POST['Submit']){
					    if($this->POST['rewritedir']){
						     $rewritedir=$this->POST['rewritedir'];
						}
				   }
				
				   include_once(Core.'/class/rewrite_class_phpapp.php');
					  
				   $rewrite=new RewriteFormat();
				  
				   $rewritearray=$rewrite->MakeRewrite($rewritedir);
				
			    
				
			}else{  
			
			       if($this->POST['Close']){
					   
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
					    $this->Update('rewrite',array('status_phpapp'=>1),array()," WHERE id_phpapp IN($ids) ");

						echo $this->Refresh('<p>�رճɹ���</p>',$this->MakeGetParameterURL());
								
						exit();
			
				   }elseif($this->POST['Open']){
					   
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
					    $this->Update('rewrite',array('status_phpapp'=>0),array()," WHERE id_phpapp IN($ids) ");

						echo $this->Refresh('<p>�����ɹ���</p>',$this->MakeGetParameterURL());
								
						exit();
					   
				   
				   }elseif($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
			
						if($this->Delete('rewrite'," WHERE id_phpapp IN($ids)")){
	
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');

						}
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
						
				   }else{
					   
						 $orderarr=array(
								  array('order'=>'id_phpapp','name'=>'ID'),
								  array('order'=>'name_phpapp','name'=>'����'),
								  array('order'=>'format_phpapp','name'=>'��ʽ'),
								  array('order'=>'displayorder_phpapp','name'=>'���ȼ�'),
								  array('order'=>'status_phpapp','name'=>'����')
								  );
				  
						 $order='ORDER BY id_phpapp ASC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
                              $iforder=2;
						 }else{
							  $sqlorder=' DESC';
							  $iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM ".$this->GetTable('rewrite')." $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('rewrite_manage');	
	}
	
	
	public function SiteLinkAction(){
		
		   $this->GetMenuList(array(array('name'=>'���������б�','display'=>''),array('name'=>'�����������','display'=>''),array('name'=>'�޸���������','display'=>'none')));
			
			
			if($this->GET['op']==1){
				  
				  if($this->POST['Submit']){
  
						 $this->Insert('links',$this->POST,array());

						 echo $this->Refresh($this->LanguageArray('phpapp','Add_success'),$this->MakeGetParameterURL());
								
						 exit();
				  
				  }
				
				
			}elseif($this->GET['op']==2){
				   
				  $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							 
							  $this->Update('links',$this->POST,array()," WHERE lid='$id'");
							  
							  echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('links')." WHERE lid='$id'");
						}else{
							 $manage='';
						}
				  }
				  
		    }elseif($this->GET['op']==3){
				
				   if($this->POST['Submit']){
				
				          $this->SetConfig($this->POST);
						  
						  exit();
				
			       }
				
			}else{
				   
				   if($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
			
						if($this->Delete('links'," WHERE lid IN($ids)")){
	
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');

						}
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
						
				   }else{
					   
						 $orderarr=array(
								  array('order'=>'lid','name'=>'ID'),
								  array('order'=>'sitename','name'=>'վ����'),
								  array('order'=>'siteurl','name'=>'URL'),
								  array('order'=>'logo','name'=>'LOGO'),
								  array('order'=>'displayorder','name'=>'����')
								  );
				  
						 $order='ORDER BY lid ASC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
                              $iforder=2;
						 }else{
							  $sqlorder=' DESC';
							  $iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM ".$this->GetTable('links')." $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('links_manage');		
		
	}
	
	
	
	public function BankToolAction() {
		
		   $this->GetMenuList(array(array('name'=>'�����б�','display'=>''),array('name'=>'�������','display'=>''),array('name'=>'�޸�����','display'=>'none'),array('name'=>'���л����Ϣ','display'=>'')));
			
			
			if($this->GET['op']==1){
				  
				  if($this->POST['Submit']){
  
						 $this->Insert('bankname',$this->POST,array());
							   
						 $refresh=$this->LanguageArray('phpapp','Add_success');

						 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								
						 exit();
				  
				  }
				
				
			}elseif($this->GET['op']==2){
				   
				  $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							 
							  $this->Update('bankname',$this->POST,array()," WHERE bankid='$id'");
							  
							  $refresh= $this->LanguageArray('phpapp','Edited_successfully');
							  
							  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('bankname')." WHERE bankid='$id'");
						}else{
							 $manage='';
						}
				  }
				  
		    }elseif($this->GET['op']==3){
				
				   if($this->POST['Submit']){
				
				          $this->SetConfig($this->POST);
						  
						  exit();
				
			       }
				
			}else{
				   
				   if($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
			
						if($this->Delete('bankname'," WHERE bankid IN($ids)")){
	
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');

						}
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
						
				   }else{
					   
						 $orderarr=array(
								  array('order'=>'bankid','name'=>'ID'),
								  array('order'=>'bankname','name'=>'����')
								  );
				  
						 $order='ORDER BY bankid ASC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
                              $iforder=2;
						 }else{
							  $sqlorder=' DESC';
							  $iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM ".$this->GetTable('bankname')." $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('bankname_manage');		
		
	}

	public function SQLBackupAction(){
		
		   $this->GetMenuList(array(array('name'=>'��������','display'=>''),array('name'=>'��ԭ����','display'=>''),array('name'=>'ִ��SQL','display'=>'')));
		   
		   include_once(Core.'/class/backup_class_phpapp.php');
		   
		   $backup=new BackupSQL();
		   
		   
		   if($this->GET['op']==2){
		        
				   if($this->POST['Submit']){
					      
						  if(S_SITE_SQL==1){
							  
							   $quirysql=str_replace("\\", "",$_POST['sql']);
							 
							   if($quirysql){
								     
									 $this->MysqlQuery($quirysql);
								
									 $refresh= '<p>ִ�гɹ�!</p>';
							   }else{
								   
								     $refresh= '<p>û�д���ִ��!</p>';
							   }
							   
						    
						  }else{
							   $refresh= '<p>�ù����ѹر�!</p>';
						  }
						  
						  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						  exit();
					   
				   }
		   
    
			   
		   }else{
		         
				 if($this->GET['value']){
					  
					  $number=$backup->SaveTableData($this->GET['value']);
					  
					  if($number=='ok'){
						  
						    echo $this->Refresh('<p>�������!</p>',$this->MakeGetParameterURL().'&value=0');
							
					  }else{
						  
						    $refresh= '<p>���ڱ�������<strong>'.$this->GET['value'].'</strong>,��ֹ�ر�������򴰿�!</p>';
							
					        echo $this->Refresh($refresh,$this->MakeGetParameterURL(array('value'=>$number)));
					  }
					  
					  exit();
					 
				 }else{
						if($this->POST['Submit']){
							  
							  $id=$this->GetCheckBox($_POST['table'],1);

							  $backup->SaveTable(explode(',',$id),$this->POST['backupname'],$this->POST['backupfilesize']);
							  
							  echo $this->Refresh('<p>���ڱ������ݱ�,��ֹ�ر�������򴰿�!</p>',$this->MakeGetParameterURL(array('value'=>1)));
							   
							  exit();
							
						}else{
							
							   $list=$this->GetMysqlTableNameArray();
							   
							   $nowdate=@date("Ymd");
							   
							   $backupname=@date("Ymd").'_'.$this->RandomText(8,1);
			
						}
				 }
				  
		   }
		   
		   include $this->Template('sqlbackup_manage');
		
	}
	
	
	public function SetOperationAction(){  $this->SystemConfig('setoperation',array(array('name'=>'��̨��������','display'=>''))); }
	
	
	public function AutoTaskAction() {
		
		    $this->GetMenuList(array(array('name'=>'�ƻ��б�','display'=>''),array('name'=>'��Ӽƻ�','display'=>''),array('name'=>'�޸ļƻ�','display'=>'none')));
			
			$apparray=$this->GetMysqlArray('*'," ".$this->GetTable('apps')."");
			
			if($this->GET['op']==1){
				  
				  if($this->POST['Submit']){
  
                         $this->POST['runtime']=strtotime($this->POST['runtime']);
						 
						 $this->POST['runcode']=serialize($this->POST);
						 
						 $this->POST['system']=1;
  
						 $this->Insert('autorun',$this->POST,array());
							   
						 echo $this->Refresh($this->LanguageArray('phpapp','Add_success'),$this->MakeGetParameterURL());
								
						 exit();
				  
				  }
				
				
			}elseif($this->GET['op']==2){
				   
				  $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							  
							  $this->POST['runtime']=strtotime($this->POST['runtime']);
							  
							  $this->Update('autorun',$this->POST,array()," WHERE aid='$id'");
							  
							  echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
	
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('autorun')." WHERE aid='$id'");
						}else{
							 $manage='';
						}
				  }
				
			}else{
				   
				   if($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						 
			
						if($this->Delete('autorun'," WHERE aid IN($ids)")){
	
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');

						}
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
						
				   }else{
					   
						 $orderarr=array(
								  array('order'=>'a.aid','name'=>'ID'),
								  array('order'=>'appname','name'=>'����Ӧ��'),
								  array('order'=>'a.system','name'=>'�ƻ�����'),
								  array('order'=>'a.runtime','name'=>'ִ��ʱ��')
								  );
				  
						 $order='ORDER BY a.aid DESC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
$iforder=2;
						 }else{
							  $sqlorder=' DESC';
							$iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.name_phpapp AS appname FROM ".$this->GetTable('autorun')." AS a LEFT JOIN ".$this->GetTable('apps')." AS b ON a.appid=b.id_phpapp $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		  
		   include $this->Template('autotask_manage');
	}
	
	public function PHPINFOAction(){
		
		   $this->GetMenuList(array(array('name'=>'����������','display'=>'')));
		   
		   $os=phpversion();
           $os .=(@ini_get('safe_mode') ? ' Safe Mode' : NULL);
		   
		   $mysqlarray=$this->MysqlFetchArray('SELECT VERSION() AS version');
		   
		   if(@ini_get('file_uploads')) {
				$fileupload = ini_get('upload_max_filesize');
		   }else{
				$fileupload = '<font color="red">Prohibition</font>';
		   }
		   
		   $tablename=$this->MysqlFetchArray('SHOW TABLE STATUS');
		   
			
		   $Data_length=0;
		   foreach($tablename as $value){
			    $Data_length+=$value['Data_length'];
		   }
			  
		   $Data_length=round($Data_length/1024/1024,2);

		  
		   include $this->Template('phpinfo_manage');	
	}
	
	public function UpdateCacheAction(){
		
		    $this->GetMenuList(array(array('name'=>'�����б�','display'=>'')));
			
		    if($this->POST['Submit']){
                   
				  $ids=$this->GetCheckBox($this->POST['checkbox']);
				  
				  if($ids){
					  
					    $updatearray=explode(',',$ids);
						
						include_once(Core.'/class/category_class_phpapp.php');
						$category=new CategoryClass();
						
						foreach($updatearray as $value){
							 
							  switch ($value){
									case '1':
								         $this->UpdateConfig();
									break;
							        case '2':
										if(is_dir(SYS.'/data/cache/language')){
											  $this->DeleteDir(SYS.'/data/cache/language');
										}
									break;
							        case '3':
									     $this->UpdateApps();
										 $this->UpdateRouteApps();
									break;
									case '4':

										 $apparray=$this->GetMysqlArray('id_phpapp,dir_phpapp,route_phpapp'," ".$this->GetTable('apps')."");
									     
										 foreach($apparray as $value){
											    if($value['route_phpapp']){
														if(file_exists(SYS.'/data/cache/config/route_'.$value['route_phpapp'].'_action.php')){
															    $this->DelFile(SYS.'/data/cache/config/route_'.$value['route_phpapp'].'_action.php');
														}
												}
												
												if(file_exists(SYS.'/data/cache/config/apps_'.$value['id_phpapp'].'_action.php')){
													   $this->DelFile(SYS.'/data/cache/config/apps_'.$value['id_phpapp'].'_action.php');
												}
										 }
	
									break;
									case '5':
									     $this->UpdateFileIcon();
									break;
									case '6':
										  if(S_CACHE_MEMORY_OPEN){
											   @$this->FlushCache();
										  }
									break;
									case '7':
									     $apparray=$this->GetMysqlArray('dir_phpapp'," ".$this->GetTable('apps')."");
									     
										 foreach($apparray as $value){
											 
											    if(is_dir(SYS.'/data/cache/'.$value['dir_phpapp'])){
											           $this->DeleteDir(SYS.'/data/cache/'.$value['dir_phpapp']);
												}
										 }
									    
									break;
									case '8':
									     $this->UpdateAdminMenu();
									break;
									case '9':
									     $this->UpdateUserLevel();
									break;
									case '10':
									     $this->UpdateCreditLevel();
									break;
									case '11':
										 include_once(Core.'/class/menucache_class_phpapp.php');
										 new UpdateMenuCache();
									break;
									case '12':
										  if(is_dir(SYS.'/data/cache/database')){
											      $this->DeleteDir(SYS.'/data/cache/database');
										  }
									break;
									
									//����
									case '13':
										   $category->MakeCategoryCache(1);   
										   $category->UpdateCategorySubclassID();   
									break;
									
									case '14':
										   $category->UpdateWebsiteCategoryCache();
									break;
									
									//����
									case '15':
									       include_once(Core.'/class/skill_class_phpapp.php');
										   $skilldata=new SkillClass();
										   $skilldata->MakeSkillCache(1);   
									break;
									case '16':
									       include_once(Core.'/class/city_class_phpapp.php');
										   $city=new CityClass();
										   $city->UpdateCitySubclassID();
									break;
									
									//����URL
									case '17':
									      
										  include_once(APPS.'/taskmode/public_phpapp.php');
										  $taskmode=new TaskPublicClass();
										  
										  if ($this->IsSQL('apps',"WHERE class_phpapp='TaskCount'")){
											    
												$taskarr=$this->GetMysqlArray('appid,tid'," ".$this->GetTable('task')." ");
												
												if($taskarr){
													  
													  foreach($taskarr as $value){
														    $taskurl=$taskmode->GetTaskURL($value['tid'],0,$value['appid']);
										                    $this->Update('task',array('url'=>$taskurl),array()," WHERE tid='$value[tid]'");
													  }
													
												}
												
			   
										  }
											
										  
									break;
									
									//����URL
									case '18':
									      if ($this->IsSQL('apps',"WHERE class_phpapp='SellerService'")){
											    include_once(APPS.'/sellerservice/main_phpapp.php');
										  		$seller=new SellerServiceMainControls();
											    
												$sellerarr=$this->GetMysqlArray('sid,uid'," ".$this->GetTable('task_seller_service')." ");
												if($sellerarr){
													  
													  foreach($sellerarr as $value){
															$serviceurl=$seller->GetServiceURL($value['sid'],$value['uid'],82);
															$this->Update('task_seller_service',array('url'=>$serviceurl),array()," WHERE sid='$value[sid]'");
													  }
												}
										  }
										 
									break;
							  }
										
						}
				   
				  }
				  

				  echo $this->Refresh('<p>���³ɹ���</p>',$this->MakeGetParameterURL());
				   
				  
			 }else{
				 
				   include $this->Template('updatecache_manage');	
				 
			 }

		
	}
	
	
	 public function ConfigAction(){
		
            $this->GetMenuList(array(array('name'=>'�����б�','display'=>''),array('name'=>'�������','display'=>''),array('name'=>'�޸�����','display'=>'none')));
			
			$apparray=$this->GetMysqlArray('*'," ".$this->GetTable('apps')."");
			
			if($this->GET['op']==1){
				  
				  if($this->POST['Submit']){
  
						 $this->Insert('config',$this->POST,array());

						 echo $this->Refresh($this->LanguageArray('phpapp','Add_success'),$this->MakeGetParameterURL());
						 
						 $this->UpdateConfig();
								
						 exit();
				  
				  }
				
				
			}elseif($this->GET['op']==2){
				   
				  $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							 
							  $this->Update('config',$this->POST,array()," WHERE id_phpapp='$id'");
							  
							  echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
							  
							  $this->UpdateConfig();
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('config')." WHERE id_phpapp='$id'");
						}else{
							 $manage='';
						}
				  }
				
			}else{
				   
				   if($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						 
			
						if($this->Delete('config'," WHERE id_phpapp IN($ids)")){
	
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');

						}
						
						$this->UpdateConfig();
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
						
				   }else{
					   
						 $orderarr=array(
								  array('order'=>'a.id_phpapp','name'=>'ID'),
								  array('order'=>'a.name_phpapp','name'=>'������'),
								  array('order'=>'a.value_phpapp','name'=>'����ֵ'),
								  array('order'=>'appname','name'=>'����Ӧ��')
								  );
				  
						 $order='ORDER BY a.id_phpapp DESC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
$iforder=2;
						 }else{
							  $sqlorder=' DESC';
							$iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.name_phpapp AS appname FROM ".$this->GetTable('config')." AS a JOIN ".$this->GetTable('apps')." AS b ON a.app_phpapp=b.id_phpapp $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('config_manage');		
		
	}


	 public function AppActionAction(){
		
            $this->GetMenuList(array(array('name'=>'�����б�','display'=>''),array('name'=>'��Ӷ���','display'=>''),array('name'=>'�޸Ķ���','display'=>'none')));
			
			$apparray=$this->GetMysqlArray('*'," ".$this->GetTable('apps')."");
			
			if($this->GET['op']==1){
				  
				  if($this->POST['Submit']){
  
						 $this->Insert('apps_action',$this->POST,array());

						 echo $this->Refresh($this->LanguageArray('phpapp','Add_success'),$this->MakeGetParameterURL());
						 
						 $this->UpdateAction();
								
						 exit();
				  
				  }
				
				
			}elseif($this->GET['op']==2){
				   
				  $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							 
							  $this->Update('apps_action',$this->POST,array()," WHERE id_phpapp='$id'");
							  
							  echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
							  
							  $this->UpdateAction();
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('apps_action')." WHERE id_phpapp='$id'");
						}else{
							 $manage='';
						}
				  }
				
			}else{
				   
				   if($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						 
			
						if($this->Delete('apps_action'," WHERE id_phpapp IN($ids)")){
	
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');

						}
						
						$this->UpdateAction();
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
						
				   }else{
					   
					    				
						  //select -----------------------------------------------------
							 $wheresql=$selectarray='';
				  
							 if(!empty($_GET['SelectData'])){
								 
								   $admin=new AdminClass();
								   
								   $wheresqlarr=$admin->getwheresql($_GET,
																	
																	array(	
																	  'apps_phpapp'=>array('a.apps_phpapp','int'),
																	  'name_phpapp'=>array('a.name_phpapp','string'),
																	  'type_phpapp'=>array('a.type_phpapp','int')		
																	) 
																	
																	
																	);
								   
								   $wheresql=$wheresqlarr[0];
								   
								   $selectarray=$wheresqlarr[1];
						   
							 }
			  
							//select end----------------------------------------------------
					   
						 $orderarr=array(
								  array('order'=>'a.aid_phpapp','name'=>'ID'),
								  array('order'=>'a.name_phpapp','name'=>'��������'),
								  array('order'=>'appname','name'=>'����Ӧ��'),
								  array('order'=>'a.class_phpapp','name'=>'������'),
								  array('order'=>'a.route_phpapp','name'=>'α��̬'),
								  array('order'=>'a.type_phpapp','name'=>'����'),
								  array('order'=>'a.title_phpapp','name'=>'SEO title'),
								  array('order'=>'a.displayorder_phpapp','name'=>'����')
								  );
				  
						 $order='ORDER BY a.displayorder_phpapp DESC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
                              $iforder=2;
						 }else{
							  $sqlorder=' DESC';
							  $iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.name_phpapp AS appname FROM ".$this->GetTable('apps_action')." AS a JOIN ".$this->GetTable('apps')." AS b ON a.apps_phpapp=b.id_phpapp $wheresql $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('apps_action_manage');		
		
	}

	
	
	public function CatalogListAction(){
			 
			$menu=$this->GET['menu'];
			
			$desktoparr=$this->GetMysqlArray('catid_phpapp,name_phpapp,upid_phpapp,displayorder_phpapp,icon_phpapp'," ".$this->GetTable('admin_menu')." WHERE  upid_phpapp='$menu' ORDER BY displayorder_phpapp ASC");
			
			include $this->Template('cataloglist_manage');		
	}
	
	
	public function ApplicationAction(){
		    
			$this->GetMenuList(array(array('name'=>'Ӧ���б�','display'=>''),array('name'=>'���߰�װӦ�ð�','display'=>'none'),array('name'=>'���߸���Ӧ��','display'=>'none'),array('name'=>'���ذ�װӦ�ð�','display'=>'none'),array('name'=>'����Ӧ��','display'=>''),array('name'=>'����Ӧ��','display'=>''),array('name'=>'�޸�Ӧ��','display'=>'none'),array('name'=>'����Ӧ�ü�¼','display'=>'none'),array('name'=>'���ذ�װ��ѹ��','display'=>'')));
			
			
			//select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(	
														'name_phpapp'=>array('name_phpapp','search'),
														'id_phpapp'=>array('id_phpapp','int'),
														'class_phpapp'=>array('class_phpapp','string'),
														'dir_phpapp'=>array('dir_phpapp','string'),
														'developer_phpapp'=>array('developer_phpapp','search')
												      ) 
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }

			  //select end----------------------------------------------------
			
			include_once(Core.'/class/make_class_phpapp.php');
			
			$make=new MakeApplication();
			
			
			if($this->GET['op']==8){
				
				if($this->POST['Submit']){
					  
					  if($this->POST['appname']){
							include_once(Core.'/class/install_class_phpapp.php');
			  
							$makedir=SYS.'/data/make/';
							
							$app=new Install(array('installname'=>'�ֶ���װ','filename'=>'','filepath'=>'','filedirectory'=>$makedir.$this->POST['appname']));
						   
							$app->InstallCode(1);
							
							echo $this->Refresh('<p>��װ�ɹ���</p>',$this->MakeGetParameterURL());
					  
					  }else{
						  
						    echo $this->Refresh('<p>������Ŀ¼����</p>',$this->MakeGetParameterURL());
						  
					  }
								
					  exit();
				}else{
					  
					  $newapparray=$this->ReadSysDir(SYS.'/data/make'); 
					  
					  $newappdir=array();
					  
					  if($newapparray){
							  foreach($newapparray as $style){
								   if ($style['filename']!='index.html' && $style['filename']!='index.htm'){
									     
									       $newappdir[]=$style['filename'];
									   
								   }
							  }
					  }
					
					  $sysdir=SYS.'/data/make/';
					  
					  $appinstallarray=array();
					  
					  //Make List
					  if($newappdir){
						      foreach($newappdir as $key=>$appdir){
								   
								    $getconfig=$sysdir.$appdir.'/install.php';
								    if(file_exists($getconfig)){
		
									       include($getconfig);
										   
										   $appinstallarray[$key]=array('installname'=>$INSTALL_NAME,'installdir'=>$appdir,'version'=>$INSTALL_VERSION,'installtype'=>$INSTALL_TYPE,'developer'=>$INSTALL_DEVELOPER);                      
									
								   
									}
								   
							  }
						   
					  }

					
				}
				
				
				
			
			}elseif($this->GET['op']==7){
				       
					   $id=$this->GET['id'];
					   
				       $orderarr=array(
								  array('order'=>'id_phpapp','name'=>'ID'),
								  array('order'=>'name_phpapp','name'=>'����'),
								  array('order'=>'filesize_phpapp','name'=>'���°���С(kb)'),
								  array('order'=>'date_phpapp','name'=>'��װʱ��'),
								  array('order'=>'required_phpapp ','name'=>'��Ҫ��')	
								  );
				  
						 $order='ORDER BY date_phpapp ASC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
                              $iforder=2;
						 }else{
							  $sqlorder=' DESC';
							  $iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM ".$this->GetTable('apps_update')." WHERE apps_phpapp='$id'  $order");
	  
						 $list=$ajaxpage->ShowResult();
						 
				
			}elseif($this->GET['op']==6){
				    
				  $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							 
							  if($this->POST['status_phpapp']){
								    
								    
									$this->Update('admin_menu',array('status_phpapp'=>1),array()," WHERE apps_phpapp='$id'");
									
									$this->Update('templateblock',array('status_phpapp'=>1),array()," WHERE apps_phpapp='$id'");
									
								   
							  }else{
									
									$this->Update('admin_menu',array('status_phpapp'=>0),array()," WHERE apps_phpapp='$id'");
								    
									//$this->Update('templateblock',array('status_phpapp'=>0),array()," WHERE apps_phpapp='$id'");
								  
							  }
							  
							 
							  $this->Update('apps',$this->POST,array()," WHERE id_phpapp='$id'");
							  
							  echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('apps')." WHERE id_phpapp='$id'");
						}else{
							 $manage='';
						}
				  }
			
	        }elseif($this->GET['op']==5){
				    
					if($this->POST['Submit']){

						  $result=$make->Make($this->POST);
						  
						  if($result=='ok'){
								 
								 $error= '<p>�����ɹ�!</p>';
										  
						  }else{
							    
								$error='';
							    foreach($result as $value){
									  $error.= '<p>'.$value.'</p>';
								}
							   
						  }

						  
						  echo $this->Refresh($error,$this->MakeGetParameterURL());
					   
					      exit();
						
					}else{
				  
				          $apparr=$this->GetMysqlArray('id_phpapp,name_phpapp'," ".$this->GetTable('apps')." WHERE internal_phpapp=0 AND id_phpapp>=50");
					
					}
					
			}elseif($this->GET['op']==4){
				    
				  if($this->POST['Submit']){
						
						$addnum=0;
						$error='';
						
						if(!$this->POST['name_phpapp']){
							 $error.='<p>Ӧ��������Ϊ��!</p>';
						}else{
							 $addnum+=1;
						}
						
						if(!$this->POST['class_phpapp']){
							 $error.='<p>�������ܿ�!</p>';
						}else{
							  
							 $class_phpapp=$this->POST['class_phpapp'];
							 
							 if($this->IsSQL('apps'," WHERE class_phpapp='$class_phpapp'")){
								   
								   $error.='<p>�����ѱ�����!</p>';
								 
							 }else{
								   $addnum+=1;
							 }
							 
						}
						
						
						if(!$this->POST['dir_phpapp']){
							 $error.='<p>Ŀ¼�����ܿ�!</p>';
						}else{
							  
							 $dir_phpapp=$this->POST['dir_phpapp'];
							 if($this->IsSQL('apps'," WHERE dir_phpapp='$dir_phpapp'")){
								   
								   $error.='<p>Ŀ¼���ѱ�����!</p>';
								 
							 }else{
								   $addnum+=1;
							 }
							 
						}
						
						if($addnum!=3){

						     echo $this->Refresh($error,$this->MakeGetParameterURL());
							 
						}else{
							 
							 $newid=$make->AddApplication($this->POST);
							 
							 $refresh= '<p>�����ɹ�!</p><p><a href="'.SURL.'/index.php?app='.$newid.'" target="_blank">[����鿴Ӧ�÷��ʵ�ַ]</p>';
							 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						}
						
					    exit();
				  }
					
					

			}else{
				   
				   if($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
			
						include_once(Core.'/class/install_class_phpapp.php');
			     
				        $app=new Install();
			
						if($app->UnloadCode($ids)){
	
							  $refresh= '<p>ж�سɹ���</p>';
						 
						}else{
							 
							  $refresh= '<p>ж��ʧ�ܣ�</p>';

						}
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
						
				   }else{
					   
						 $orderarr=array(
								  array('order'=>'id_phpapp','name'=>'ID'),
								  array('order'=>'name_phpapp','name'=>'����'),
								  array('order'=>'developer_phpapp','name'=>'������'),
								  array('order'=>'dir_phpapp','name'=>'Ӧ��·��'),
								  array('order'=>'route_phpapp','name'=>'α��̬��'),
								  array('order'=>'filesize_phpapp','name'=>'Ӧ�ô�С(kb)'),
								  array('order'=>'version_phpapp','name'=>'�汾��'),
								  array('order'=>'version_phpapp','name'=>'���¸���'),
								  array('order'=>'status_phpapp','name'=>'ǰ̨״̬'),
								  array('order'=>'displayorder_phpapp','name'=>'����')
								  );
				  
						 $order='ORDER BY displayorder_phpapp ASC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
                              $iforder=2;
						 }else{
							  $sqlorder=' DESC';
							  $iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM ".$this->GetTable('apps')." $wheresql $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('application_manage');		
			
		
	}
	
	
	public function SiteAdminNavAction(){
		    
			$appid=empty($this->GET['value']) ? 0 :$this->GET['value'];
				
		    $this->GetMenuList(array(array('name'=>'�˵��б�','display'=>''),array('name'=>'��Ӳ˵�','display'=>''),array('name'=>'�޸Ĳ˵�','display'=>'none')));
			
			$appsarr=$this->GetMysqlArray('id_phpapp,name_phpapp'," ".$this->GetTable('apps')."");
		
			
			$adminmenuarr=$this->GetMysqlArray('catid_phpapp,name_phpapp,upid_phpapp'," ".$this->GetTable('admin_menu')."");
			
			
			if($this->POST['Hide']){
				
				 $ids=$this->GetCheckBox($this->POST['checkbox']);
					  
				 $this->Update('admin_menu',array('desktop_phpapp'=>1),array()," WHERE catid_phpapp IN($ids)");
					  
				 echo $this->Refresh('<p>�����ɹ���</p>',$this->MakeGetParameterURL());
								
				 exit();
				 
			
			}elseif($this->POST['Show']){
				
				 $ids=$this->GetCheckBox($this->POST['checkbox']);
					  
				 $this->Update('admin_menu',array('desktop_phpapp'=>0),array()," WHERE catid_phpapp IN($ids)");
					  
				 echo $this->Refresh('<p>�����ɹ���</p>',$this->MakeGetParameterURL());
								
				 exit();
				 
			
			}elseif($this->GET['op']==4){
				
		         $ids=$this->GetCheckBox($this->POST['checkbox']);
				 
				 if($ids){
					    
						$updateid=explode(',',$ids);
						
					    foreach($updateid as $key=>$value){
							 
							 $this->Update('admin_menu',array('displayorder_phpapp'=>$key),array()," WHERE catid_phpapp='$value'");
							    
						}
					 
				 }

				 
				 exit();
				 
			}elseif($this->GET['op']==3){
				
				
				  echo $this->GetPhpappActionID($this->GET['appid']);
				  
				  exit();
				
				
			}elseif($this->GET['op']==1){
				  
				  if($this->POST['Submit']){
  
						 $this->Insert('admin_menu',$this->POST,array());

						 echo $this->Refresh($this->LanguageArray('phpapp','Add_success'),$this->MakeGetParameterURL());
								
						 exit();
				  
				  }
				
				
			}elseif($this->GET['op']==2){
				   
				  $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							 
							  $this->Update('admin_menu',$this->POST,array()," WHERE catid_phpapp='$id'");

							  echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('admin_menu')." WHERE catid_phpapp='$id'");
						}else{
							 $manage='';
						}
				  }
				
			}else{
				   
				   if($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
						$this->Delete('admin_menu'," WHERE catid_phpapp IN($ids)");
	
						echo $this->Refresh($this->LanguageArray('phpapp','Delete_successfully'),$this->MakeGetParameterURL());
					   
					    exit();
						
				   }else{
					   
						 $orderarr=array(
								  array('order'=>'catid_phpapp','name'=>'ID'),
								  array('order'=>'name_phpapp','name'=>'����'),
								  array('order'=>'appname','name'=>'����Ӧ��'),
								  array('order'=>'status_phpapp','name'=>'״̬'),
								  array('order'=>'displayorder_phpapp','name'=>'����')
								  );
				  
						 $order='ORDER BY displayorder_phpapp ASC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
                              $iforder=2;
						 }else{
							  $sqlorder=' DESC';
							  $iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.name_phpapp AS appname FROM ".$this->GetTable('admin_menu')." AS a LEFT JOIN ".$this->GetTable('apps')." AS b ON a.apps_phpapp=b.id_phpapp  $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('admin_menu_manage');		

	}
	
	
	public function CustomerServiceAction(){
		
		
		   $this->GetMenuList(array(array('name'=>'�ͷ��б�','display'=>''),array('name'=>'��ӿͷ�','display'=>''),array('name'=>'�޸Ŀͷ�','display'=>'none')));
		   
		   	
			if($this->GET['op']==1){
				  
				  if($this->POST['Submit']){
  
						 $this->Insert('customer_service',$this->POST,array());
							   
						 $refresh= $this->LanguageArray('phpapp','Add_success');

						 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								
						 exit();
				  
				  }
				
				
			}elseif($this->GET['op']==2){
				   
				  $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							 
							  $this->Update('customer_service',$this->POST,array()," WHERE sid='$id'");
							  
							  $refresh= $this->LanguageArray('phpapp','Edited_successfully');
							  
							  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('customer_service')." WHERE sid='$id'");
						}else{
							 $manage='';
						}
				  }
				
			}else{
				   
				   if($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
			
						if($this->Delete('customer_service'," WHERE sid IN($ids)")){
	
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');

						}
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
						
				   }else{
					   
						 $orderarr=array(
								  array('order'=>'a.sid','name'=>'�ͷ�ID'),
								  array('order'=>'a.uid','name'=>'�û�UID'),
								  array('order'=>'b.username','name'=>'�û���')
								  );
				  
						 $order='ORDER BY displayorder ASC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
                              $iforder=2;
						 }else{
							  $sqlorder=' DESC';
							  $iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.username FROM ".$this->GetTable('customer_service')." AS a JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('customerservice_manage');		
		   
		
	}
	
	public function SiteBottomNavAction(){
		
		   $this->GetMenuList(array(array('name'=>'�����б�','display'=>''),array('name'=>'��ӵ���','display'=>''),array('name'=>'�޸ĵ���','display'=>'none')));
			
			
			if($this->GET['op']==1){
				  
				  if($this->POST['Submit']){
  
						 $this->Insert('nav_bottom',$this->POST,array());

						 echo $this->Refresh($this->LanguageArray('phpapp','Add_success'),$this->MakeGetParameterURL());
								
						 exit();
				  
				  }
				
				
			}elseif($this->GET['op']==2){
				   
				  $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							 
							  $this->Update('nav_bottom',$this->POST,array()," WHERE navid='$id'");

							  echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('nav_bottom')." WHERE navid='$id'");
						}else{
							 $manage='';
						}
				  }
				
			}else{
				   
				   if($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
						$this->Delete('nav_bottom'," WHERE navid IN($ids)");
	
						echo $this->Refresh($this->LanguageArray('phpapp','Delete_successfully'),$this->MakeGetParameterURL());
					   
					    exit();
						
				   }else{
					   
						 $orderarr=array(
								  array('order'=>'navid','name'=>'ID'),
								  array('order'=>'navname','name'=>'����'),
								  array('order'=>'blank','name'=>'��������'),
								  array('order'=>'displayorder','name'=>'����')
								  );
				  
						 $order='ORDER BY displayorder ASC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
$iforder=2;
						 }else{
							  $sqlorder=' DESC';
							$iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM ".$this->GetTable('nav_bottom')." $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('sitetopnav_manage');		
		
	}
	
	
	public function SiteTopNavAction(){
		
		   $this->GetMenuList(array(array('name'=>'�����б�','display'=>''),array('name'=>'��ӵ���','display'=>''),array('name'=>'�޸ĵ���','display'=>'none')));
			
			
			if($this->GET['op']==1){
				  
				  if($this->POST['Submit']){
  
						 $this->Insert('nav_top',$this->POST,array());
							   
						 echo $this->Refresh($this->LanguageArray('phpapp','Add_success'),$this->MakeGetParameterURL());
								
						 exit();
				  
				  }
				
				
			}elseif($this->GET['op']==2){
				   
				  $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							 
							  $this->Update('nav_top',$this->POST,array()," WHERE navid='$id'");

							  echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('nav_top')." WHERE navid='$id'");
						}else{
							 $manage='';
						}
				  }
				
			}else{
				   
				   if($this->POST['Submit']){
					   
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
						$this->Delete('nav_top'," WHERE navid IN($ids)");
	
						echo $this->Refresh($this->LanguageArray('phpapp','Delete_successfully'),$this->MakeGetParameterURL()); 
					   
					    exit();
						
				   }else{
					   
						 $orderarr=array(
								  array('order'=>'navid','name'=>'ID'),
								  array('order'=>'navname','name'=>'����'),
								  array('order'=>'blank','name'=>'��������'),
								  array('order'=>'displayorder','name'=>'����')
								  );
				  
						 $order='ORDER BY displayorder ASC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
$iforder=2;
						 }else{
							  $sqlorder=' DESC';
							$iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM ".$this->GetTable('nav_top')." $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('sitetopnav_manage');		
		
		  
		
	}
	
	
	public function SiteNavAction(){
		  
	        $this->GetMenuList(array(array('name'=>'�����б�','display'=>''),array('name'=>'��ӵ���','display'=>''),array('name'=>'�޸ĵ���','display'=>'none')));
			
			
			$appsarr=$this->GetMysqlArray('id_phpapp,name_phpapp'," ".$this->GetTable('apps')."");
			
			if($this->GET['op']==1){
				  
				  if($this->POST['Submit']){
  
						 $this->Insert('nav',$this->POST,array());
							  
						 echo $this->Refresh($this->LanguageArray('phpapp','Add_success'),$this->MakeGetParameterURL());
								
						 exit();
				  
				  }
				
				
			}elseif($this->GET['op']==2){
				   
				  $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							 
							  $this->Update('nav',$this->POST,array()," WHERE navid='$id'");
							  
							  echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('nav')." WHERE navid='$id'");
						}else{
							 $manage='';
						}
				  }
				
			}else{
				   
				   if($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
			
						$this->Delete('nav'," WHERE navid IN($ids)");
	
	
						echo $this->Refresh($this->LanguageArray('phpapp','Delete_successfully'),$this->MakeGetParameterURL());
						
					   
					    exit();
						
				   }else{
					   
						 $orderarr=array(
								  array('order'=>'navid','name'=>'ID'),
								  array('order'=>'navname','name'=>'����'),
								  array('order'=>'blank','name'=>'��������'),
								  array('order'=>'displayorder','name'=>'����')
								  );
				  
						 $order='ORDER BY displayorder ASC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
                              $iforder=2;
						 }else{
							  $sqlorder=' DESC';
							  $iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM ".$this->GetTable('nav')." $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('sitenav_manage');		
		
	}

	
	
	public function FeedAction(){

		   $this->GetMenuList(array(array('name'=>'��̬�б�','display'=>'')));
		   
		   //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(
															
														'title_data'=>array('title_data','search'), 
														'fid'=>array('fid','int'),
														'uid'=>array('uid','int'),
														'username'=>array('username','string'),
														'app'=>array('app','int'),
														'dateline1'=>array('dateline','time'),
														'dateline2'=>array('dateline','time')
															  
												      ) 
													  
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }

			  //select end----------------------------------------------------
			  
		  

			 if($this->POST['Submit']){
				 
  
				  $ids=$this->GetCheckBox($this->POST['checkbox']);
	  
				  if($this->Delete('member_feed'," WHERE fid IN($ids)")){

						$refresh= $this->LanguageArray('phpapp','Delete_successfully');
				   
				  }else{
					   
						$refresh= $this->LanguageArray('phpapp','Delete_failed');

				  }
				   
				  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				 
				  exit();
				  
			 }else{
				 
				   $orderarr=array(	 
							array('order'=>'fid','name'=>'ID'),
							array('order'=>'uid','name'=>'�û�ID'),
							array('order'=>'username','name'=>'�û���'),
							array('order'=>'title_data','name'=>'����'),
							array('order'=>'dateline','name'=>'����ʱ��')
							);
			
				   $order='ORDER BY fid DESC';
			
				   $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
   
				   if($this->GET['iforder']==1){
						$sqlorder=' ASC';
                        $iforder=2;
				   }else{
						$sqlorder=' DESC';
						$iforder=1;
				   }
			
				   foreach($orderarr as $key=>$value){
						 if($this->GET['sqlorder']==$key){
							   $order='ORDER BY '.$value['order'].$sqlorder;
						 }
				   }

				   
				   $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM ".$this->GetTable('member_feed')." $wheresql  $order");

				   $list=$ajaxpage->ShowResult();
			 
			 }
				  
		
			
		    include $this->Template('member_feed_manage');	
		
		
		
	}
	
	
	public function SMSAction(){
		
	       $this->GetMenuList(array(array('name'=>'��Ϣ�б�','display'=>''),array('name'=>'�޸���Ϣ','display'=>'none')));
		   
		   //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(
															
														'subject'=>array('a.subject','search'), 
														'sid'=>array('a.sid','int'),
														'uid'=>array('b.uid','int'),
														'username'=>array('b.username','string'),
														'dateline1'=>array('a.dateline','time'),
														'dateline2'=>array('a.dateline','time')
															  
												      ) 
													  
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }

			  //select end----------------------------------------------------
			  
		  
		   if($this->GET['op']==1){
				   
				  $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							 
							  $this->Update('member_sms',$this->POST,array()," WHERE sid='$id'");
							  
							  $refresh= $this->LanguageArray('phpapp','Edited_successfully');
							  
							  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('member_sms')." WHERE sid='$id'");
						}else{
							 $manage='';
						}
				  }
				
			}else{
				   
				   if($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
			
						if($this->Delete('member_sms'," WHERE sid IN($ids)")){
	
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');

						}
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
						
				   }else{
					   
						 $orderarr=array(	 
								  array('order'=>'a.sid','name'=>'ID'),
								  array('order'=>'a.msggoid','name'=>'�û�ID'),
								  array('order'=>'b.username','name'=>'�û���'),
								  array('order'=>'a.subject','name'=>'����'),
								  array('order'=>'a.dateline','name'=>'����ʱ��')
								  );
				  
						 $order='ORDER BY a.uid DESC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
                              $iforder=2;
						 }else{
							  $sqlorder=' DESC';
							  $iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.username FROM ".$this->GetTable('member_sms')." AS a JOIN ".$this->GetTable('member')." AS b ON a.msggoid=b.uid $wheresql $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('member_sms_manage');	
		
		
		
		
    }
	
	
	
	public function UnionAction(){
		
		   $this->GetMenuList(array(array('name'=>'�ƹ��б�','display'=>''),array('name'=>'�޸����','display'=>'none')));
		   
		   //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(

														'uid'=>array('b.uid','int'),
														'username'=>array('b.username','string'),
														'appid'=>array('a.appid','int'),
														'money'=>array('a.money','int'),
														'total'=>array('a.total','float')	  
												      ) 
													  
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }

			  //select end----------------------------------------------------
			  
		  
		   if($this->GET['op']==1){
				   
				  $id=$this->GET['id'];
				  
				  $appid=$this->GET['appid'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							 
							  $this->Update('member_union',$this->POST,array()," WHERE uid='$id' AND appid='$appid' ");
							  
							  $refresh= $this->LanguageArray('phpapp','Edited_successfully');
							  
							  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('member_union')." WHERE uid='$id' AND appid='$appid'");
						}else{
							 $manage='';
						}
				  }
				
			}else{
				   
				   if($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
			
						if($this->Delete('member_union'," WHERE uid IN($ids)")){
	
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');

						}
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
						
				   }else{
					   
						 $orderarr=array(
								  array('order'=>'a.uid','name'=>'UID'),
								  array('order'=>'b.username','name'=>'�û���'),
								  array('order'=>'a.name_phpapp','name'=>'�ƹ�Ӧ��'),
								  array('order'=>'a.money','name'=>'�����(Ԫ)'),
								  array('order'=>'a.total','name'=>'���ƹ�����')
								  );
				  
						 $order='ORDER BY a.uid DESC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
                              $iforder=2;
						 }else{
							  $sqlorder=' DESC';
							  $iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.username,c.name_phpapp FROM (".$this->GetTable('member_union')." AS a JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid) LEFT JOIN ".$this->GetTable('apps')." AS c ON a.appid=c.id_phpapp $wheresql $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('member_union_manage');	
		
		
		
		
    }
		
		
   
    public function CreditAction(){
		
		   $this->GetMenuList(array(array('name'=>'�����б�','display'=>''),array('name'=>'�޸�����','display'=>'none')));
		   
		    //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(

														'uid'=>array('b.uid','int'),
														'username'=>array('b.username','string'),
														'type'=>array('a.type','int'),
														'credit1'=>array('a.credit','part'),
														'credit2'=>array('a.credit','part')
															  
												      ) 
													  
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }

			  //select end----------------------------------------------------
		   
		  
		   if($this->GET['op']==1){
				   
				  $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							  
							  $type=intval($this->POST['type']);
							  
							  $this->Update('credit',$this->POST,array()," WHERE uid='$id' AND type='$type' ");
							  
							  $refresh= $this->LanguageArray('phpapp','Edited_successfully');
							  
							  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
					    
						$type=$this->GET['type'];
						
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('credit')." WHERE uid='$id' AND type='$type' ");
						}else{
							 $manage='';
						}
				  }
				
			}else{
				   
				   if($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
			
						if($this->Delete('credit'," WHERE uid IN($ids)")){
	
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');

						}
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
						
				   }else{
					   
						 $orderarr=array(
								  array('order'=>'a.uid','name'=>'UID'),
								  array('order'=>'b.username','name'=>'�û���'),
								  array('order'=>'a.type','name'=>'����'),
								  array('order'=>'a.credit','name'=>'���û���')
								  );
				  
						 $order='ORDER BY a.uid DESC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
                              $iforder=2;
						 }else{
							  $sqlorder=' DESC';
							  $iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.username FROM ".$this->GetTable('credit')." AS a JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid  $wheresql $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('credit_manage');	
		
		
		
		
    }


    public function CreditLevelAction(){
		
            $this->GetMenuList(array(array('name'=>'��־�б�','display'=>''),array('name'=>'��ӱ�־','display'=>''),array('name'=>'�޸ı�־','display'=>'none')));
			
			
			if($this->GET['op']==1){
				  
				  if($this->POST['Submit']){
  
						 $this->Insert('credit_level',$this->POST,array());
							   
						 $refresh= $this->LanguageArray('phpapp','Add_success');

						 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								
						 exit();
				  
				  }
				
				
			}elseif($this->GET['op']==2){
				   
				  $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							 
							  $this->Update('credit_level',$this->POST,array()," WHERE lid='$id'");
							  
							  $refresh= $this->LanguageArray('phpapp','Edited_successfully');
							  
							  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('credit_level')." WHERE lid='$id'");
						}else{
							 $manage='';
						}
				  }
				
			}else{
				   
				   if($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						 
			
						if($this->Delete('credit_level'," WHERE lid IN($ids)")){
	
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');

						}
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
						
				   }else{
					   
						 $orderarr=array(
								  array('order'=>'lid','name'=>'ID'),
								  array('order'=>'small','name'=>'��Сֵ'),
								  array('order'=>'big','name'=>'���ֵ'),
								  array('order'=>'style','name'=>'��ʽ����'),
								  array('order'=>'type','name'=>'����')
								  );
				  
						 $order='ORDER BY lid DESC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
                              $iforder=2;
						 }else{
							  $sqlorder=' DESC';
							  $iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM ".$this->GetTable('credit_level')." $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('credit_level_manage');		
		
	}

	
	public function UserLevelAction(){
		
            $this->GetMenuList(array(array('name'=>'ͷ���б�','display'=>''),array('name'=>'���ͷ��','display'=>''),array('name'=>'�޸�ͷ��','display'=>'none')));
			
			
			if($this->GET['op']==1){
				  
				  if($this->POST['Submit']){
  
						 $this->Insert('member_level',$this->POST,array());
							   
						 $refresh= $this->LanguageArray('phpapp','Add_success');

						 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								
						 exit();
				  
				  }
				
				
			}elseif($this->GET['op']==2){
				   
				  $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							 
							  $this->Update('member_level',$this->POST,array()," WHERE lid='$id'");
							  
							  $refresh= $this->LanguageArray('phpapp','Edited_successfully');
							  
							  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('member_level')." WHERE lid='$id'");
						}else{
							 $manage='';
						}
				  }
				
			}else{
				   
				   if($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
			
						if($this->Delete('member_level'," WHERE lid IN($ids)")){
	
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');

						}
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						
					    exit();
						
				   }else{
					   
						 $orderarr=array(
								  array('order'=>'lid','name'=>'ID'),
								  array('order'=>'title','name'=>'����'),
								  array('order'=>'small','name'=>'��Сֵ'),
								  array('order'=>'big','name'=>'���ֵ'),
								  array('order'=>'style','name'=>'��ʽ����'),
								  array('order'=>'color','name'=>'��ɫ')
								  );
				  
						 $order='ORDER BY lid DESC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
                              $iforder=2;
						 }else{
							  $sqlorder=' DESC';
							  $iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM ".$this->GetTable('member_level')." $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('member_level_manage');		
		
	}
	
	
	//��̨����
	
	public function AdminUsergroupAction(){
		
	       $this->GetMenuList(array(array('name'=>'�û����б�','display'=>''),array('name'=>'����û���','display'=>''),array('name'=>'�޸��û���','display'=>'none')));
		   
		   $appsarr=$this->GetMysqlArray('*'," ".$this->GetTable('apps')." ");
		   
		   $appsactionarr=$this->GetMysqlArray('*'," ".$this->GetTable('apps_action')." WHERE apps_phpapp=1 AND type_phpapp=1 ");
		   
				   
		   if($this->GET['op']==2){
			     
				  $id=empty($_GET['id']) ? 0 : $_GET['id'];
				 
			      if($this->POST['Submit']){
					    
						if($id>0){
							
							   $allowid=$acallowid='';
							   
							   foreach($this->POST as $key=>$value){
									if(substr($key,0,6)=='Allow_'){

										   if(intval($allowid)>0 && $value){
												 $allowid.=','.$value;
										   }else{
												 $allowid.=$value;
										   }  

									}
									
									 
							   }
									 
							   foreach($this->POST as $key=>$value){
									if(substr($key,0,13)=='Action_Allow_'){

										   if($acallowid){
												 $acallowid.=','.$value;
										   }else{
												 $acallowid.=$value;
										   }  

									}
									
									 
							   }
							
							
			
							  $this->POST['app_phpapp']=$allowid;
							  
							  $this->POST['action_phpapp']=$acallowid;
							 
							  $this->Update('admin',$this->POST,array()," WHERE id_phpapp='$id'");
							  
							  $refresh=$this->LanguageArray('phpapp','Edited_successfully');
							  
							  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('admin')." WHERE id_phpapp='$id'");
							 
							 if($manage['app_phpapp']){
								 
							       $app_phpapp=explode(',',$manage['app_phpapp']);
								   
								   $appsallowarray=$this->GetMysqlArray('id_phpapp,name_phpapp,class_phpapp'," ".$this->GetTable('apps')." WHERE id_phpapp IN($manage[app_phpapp])");
							 
							       $action_phpapp=explode(',',$manage['action_phpapp']);
							 
							 }else{
								   $app_phpapp=array();
							 }

							 
							 

						}else{
							 $manage='';
						}
				  }
			   
           }elseif($this->GET['op']==1){
		   
		         $app_phpapp_all='all';
				 $app_phpapp='';
				
		         if($this->POST['Submit']){
					     
						 $allowid='';
						 
						 if($this->POST['Allow_All']!='all'){
							   
							   foreach($this->POST as $key=>$value){
									if(substr($key,0,6)=='Allow_'){
										
										   if(intval($allowid)>0 && $value){
												 $allowid.=','.$value;
										   }else{
												 $allowid.=$value;
										   }  
									}
									 
							   }
							   
						 }else{
							   $allowid='all';
						 }
						 
						 $this->POST['app_phpapp']=$allowid;
						 
						 $this->Insert('admin',$this->POST,array());
						 
						 $refresh= $this->LanguageArray('phpapp','Add_success');
						 
						 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						 
						 exit();
				 }

			   
		   }else{
			        

					if($this->POST['Submit']){
						 
						 $ids=$this->GetCheckBox($this->POST['checkbox']);

						 if($this->Delete('admin'," WHERE id_phpapp IN($ids)")){
	
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');

						}
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
						 
					}else{
						
						   $orderarr=array(
								array('order'=>'id_phpapp','name'=>'ID'),
								array('order'=>'name_phpapp','name'=>'�û�������'),
								array('order'=>'app_phpapp','name'=>'����Ȩ��'),
								array('order'=>'status_phpapp','name'=>'״̬')
								);
				
						   $order='ORDER BY id_phpapp DESC';
					
						   $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
				
						   if($this->GET['iforder']==1){
								$sqlorder=' ASC';
                                $iforder=2;
						   }else{
								$sqlorder=' DESC';
							    $iforder=1;
						   }
					
						   foreach($orderarr as $key=>$value){
								 if($this->GET['sqlorder']==$key){
									   $order='ORDER BY '.$value['order'].$sqlorder;
								 }
						   }
				
						  
						   $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM  ".$this->GetTable('admin')." $order");
				
						   $list=$ajaxpage->ShowResult();
					}
			     
		   }
		   

		   include $this->Template('admin_manage');
	}
	
	
	//�Զ����ֶ�
	
	public function FieldAction(){
		
		  $this->GetMenuList(array(array('name'=>'�ֶ��б�','display'=>''),array('name'=>'����ֶ�','display'=>''),array('name'=>'�޸��ֶ�','display'=>'none')));  
		  
		  include_once(Core.'/class/datatable_class_phpapp.php');
		   
		  
		  $formtypearray=array('text'=>'�����ı���','textarea'=>'�����ı���','radio'=>'��ѡ��','checkbox'=>'��ѡ��','select'=>'�����˵�','selectmultiple'=>'��ѡ�б��');
		  
		  
		  $data=new DataTable();
		  
		  if($this->GET['op']==2){
                  $id=$this->GET['id'];
                  if(!empty($this->POST['Submit'])){
					  
					    if($id>0){
							 
							  $this->Update('field',$this->POST,array()," WHERE id_phpapp='$id'");
							  
							  echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
								
						      exit();
							  
						}

					  
				  }else{
					  
					    $list=$this->GetMysqlTableNameArray();
						
					    if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('field')." WHERE id_phpapp='$id'");
						}else{
							 $manage='';
						}	
					  
				  }

		  }elseif($this->GET['op']==1){
                   
				   $list=$this->GetMysqlTableNameArray();
				  
				   
		           if(!empty($this->POST['Submit'])){

						  if(preg_match('/^[a-z]+/',$this->POST['field_phpapp'])){
                          
								$tnamelen=strlen(DB_TNAME);
								
								$tablename=substr($this->POST['table_phpapp'],$tnamelen);	
	  
								$tablearray=$this->GetMysqlFieldArray($tablename);
								
								$is_field=1;
								foreach($tablearray['name'] as $value){
									  if($value==$this->POST['field_phpapp']){
										   $is_field=0;
									  }
								}
							  
								if(!isset($tablearray[$this->POST['field_phpapp']])){
	  
									 $data->AddTableFieldDate($this->POST);
									 
									 $this->Insert('field',$this->POST,array());
	  
									 $refresh= $this->LanguageArray('phpapp','Add_success');
									
								}else{
									
									 $refresh= '<p>���ʧ�ܣ��ֶ��Ѵ��ڣ�</p>';
								}
						  }else{
							    $refresh= '<p>�ֶ�������Сд��ĸ��ͷ��</p>';
						  }
						  
				          echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						  exit();
				   }
				  
		  
		  }else{

                  if($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
						$fieldarray=$this->GetMysqlArray('table_phpapp,field_phpapp',' '.$this->GetTable('field')." WHERE id_phpapp IN($ids) ");
						
						foreach($fieldarray as $value){
							  
							  $this->DropTableField($value['table_phpapp'],$value['field_phpapp']);
							  
						}
			
						if($this->Delete('field'," WHERE id_phpapp IN($ids)")){
	                           
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');

						}
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
						
				   }else{
					   
				         $orderarr=array(  
								  array('order'=>'id_phpapp','name'=>'ID'),
								  array('order'=>'table_phpapp','name'=>'���ڱ�'),
								  array('order'=>'field_phpapp','name'=>'�ֶ���'),
								  array('order'=>'status_phpapp','name'=>'״̬')
								  );
				  
						 $order='ORDER BY id_phpapp DESC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
                              $iforder=2;
						 }else{
							  $sqlorder=' DESC';
							  $iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),'SELECT * FROM '.$this->GetTable('field')." $order");
	  
						 $list=$ajaxpage->ShowResult();
				   }
			  
		  }
		  
		  include $this->Template('field_manage');
	}
	
	
	//ģ��
	public function TemplateAction() {
		  
          include_once(Core.'/class/edit_template_phpapp.php');
		  
		  $this->GetMenuList(array(array('name'=>'ģ�����','display'=>''),array('name'=>'ģ���޸�','display'=>'none')));
		  
		  $apps=$this->GetMysqlArray('id_phpapp,name_phpapp,dir_phpapp',' '.$this->GetTable('apps').' WHERE id_phpapp NOT IN(4,7,13,14,18,21) AND status_phpapp=0');
		  
		  $appid=empty($this->GET['value'])? $this->POST['appid'] : $this->GET['value'];
		
		  if($appid>0){
				$nowapps=$this->GetMysqlOne('id_phpapp,name_phpapp,dir_phpapp',' '.$this->GetTable('apps')." WHERE id_phpapp='$appid' AND status_phpapp=0");
		  }
		  
		  if(!empty($nowapps)){
				
				$appdir=$nowapps['dir_phpapp'];
				
		  }else{
			  
				$appdir='';
		  }
		  
		  
		  if($this->GET['op']==1){
			    
			  
			    $tpl=new EditTemplate($appdir);
							
				if(!empty($this->POST['Submit'])){
	
					  $tpl->SaveTemplate($this->POST);
					  
					  echo $this->Refresh('<p>����ɹ���</p>',$this->MakeGetParameterURL());
	
				}else{
					
					  if($_GET['id']){
							 
							$dir=$tpl->TemplateDIR(); 
							
							$template=$tpl->GetTemplate($_GET['id']);
		  
							include $this->Template('templates_manage');
							
					  }else{
						  
							echo $this->Refresh('<p>δָ���ļ���</p>',$this->MakeGetParameterURL());
							
					  }
				
				}
				  
			  

		  }else{
			  
				$tpl=new EditTemplate($appdir);

				$list=$tpl->TemplateList();
				
				$dir=$tpl->TemplateDIR(); 
				
				$filesizeall=0;

				include $this->Template('templates_manage');			  
			  
		  }
			
	}
	
	
	//վ��ģ��
	public function SiteTemplatesAction(){
		
		    $this->GetMenuList(array(array('name'=>'վ��ģ��','display'=>'')));
			
            $templatearr=$this->ReadSysDir(SYS.'/templates');
			 
			if($this->POST['Submit']){
				 
				  $this->SetConfig($this->POST);
				  
				  $refresh='<p>����ɹ���</p>';	
				   
		    	  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						  
				  exit();
				  
			}else{
			
		    	  include $this->Template('sitetemplates_manage');
			}
		
	}
	
	
	
	//�ʼ�����
	
	public function EmailSetAction(){

		   $this->GetMenuList(array(array('name'=>'�ʼ�����','display'=>''),array('name'=>'���Է���','display'=>'')));
		   
		   if($this->GET['op']==1){
			     
				 if($this->POST['Submit']){
					    
						if(!$this->POST['receivemail'] && !$this->POST['emailtitle'] && !$this->POST['emailcontent']){
						      
							  $refresh='<p>����ʧ�ܣ�</p>';	
							  
						}else{
						
							  $this->SendMail($this->POST['receivemail'],$this->POST['emailtitle'],$this->POST['emailcontent']);
	  
							  $refresh='<p>���ͳɹ���</p>';	
						
						}
						
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						  
						exit();
				 }
				 
		   }else{
			   
			     if($this->POST['Submit']){
					 
					   $this->SetConfig($this->POST);
					   exit();
				 }
			   
		   }
		   
		   
		    include $this->Template('emailset_manage');
		
	}
	
	
	//�������
	
	public function TermFilterAction(){  $this->SystemConfig('termfilter',array(array('name'=>'�����������','display'=>''))); }
	
	
	//��������
	public function AnnexSetAction(){ 
	       
		   $this->GetMenuList(array(array('name'=>'��������','display'=>''),array('name'=>'������־','display'=>''),array('name'=>'��ӱ�־','display'=>''),array('name'=>'�޸ı�־','display'=>'none'),array('name'=>'��������','display'=>'')));
		   
		   
		   if($this->GET['op']==4){
		          
				   //select -----------------------------------------------------
				   $wheresql=$selectarray='';
		
				   if(!empty($_GET['SelectData'])){
					   
						 $admin=new AdminClass();
						 
						 $wheresqlarr=$admin->getwheresql($_GET,
														  
														  array(
															'fid'=>array('a.fid','int'),	
															'filename'=>array('a.filename','search'), 
															'uid'=>array('b.uid','int'),
															'username'=>array('b.username','string'),
															'dateline1'=>array('a.dateline','time'),
															'dateline2'=>array('a.dateline','time')  
														  ) 
														  
														  
														  );
						 
						 $wheresql=$wheresqlarr[0];
						 
						 $selectarray=$wheresqlarr[1];
				 
				   }
	
				  //select end----------------------------------------------------

				  
				  if($this->POST['Submit']){
					    
						 $ids=$this->GetCheckBox($this->POST['checkbox']);
						 
						 $filearr=$this->GetMysqlArray('*'," ".$this->GetTable('file')." WHERE fid IN($ids)");
				         
						 if($filearr){
								 foreach($filearr as $file){
									  
										$this->DelFile(PHPAPP_DIR.'/'.$file['filepath']);
									    $this->Delete('file'," WHERE fid='$file[fid]'");
										$refresh.='<p>'.$file['fid'].'�Ÿ���ɾ���ɹ�!</p>';
								 }
						 }
			   
						 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					
					  
				  }else{
					  
						$orderarr=array(
								array('order'=>'a.fid','name'=>'ID'),
								array('order'=>'b.uid','name'=>'�û�ID'),
								array('order'=>'b.username','name'=>'�û���'),
								array('order'=>'a.filename','name'=>'�ļ���'),
								array('order'=>'a.filepath','name'=>'·��'),
								array('order'=>'a.filesize','name'=>'��С(MB)'),
								array('order'=>'a.ftp','name'=>'����Զ��'),
								array('order'=>'a.dateline','name'=>'�ϴ�ʱ��')
								);
				
					   $order='ORDER BY a.fid DESC';
				
					   $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
			
					   if($this->GET['iforder']==1){
							$sqlorder=' ASC';
                            $iforder=2;
					   }else{
							$sqlorder=' DESC';
							$iforder=1;
					   }
				
					   foreach($orderarr as $key=>$value){
							 if($this->GET['sqlorder']==$key){
								   $order='ORDER BY '.$value['order'].$sqlorder;
							 }
					   }
			
					   
					   $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.uid,b.username FROM  ".$this->GetTable('file')." AS a JOIN    ".$this->GetTable('member')." AS b ON a.uid=b.uid $wheresql $order");
			
					   $list=$ajaxpage->ShowResult();
				  }
		   
		   
		   
		   }elseif($this->GET['op']==3){
		   
		          $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							 
							  $this->Update('file_icon',$this->POST,array()," WHERE fid='$id'");
							  
							  echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('file_icon')." WHERE fid='$id'");
						}else{
							 echo $this->AdminAjaxRefresh($this->GET['menu'],$this->GET['action'],1,0,1);
							 exit();
						}
				  }
				  
		   }elseif($this->GET['op']==2){
		   
		   
		         if($this->POST['Submit']){
					 
						 $this->Insert('file_icon',$this->POST,array());
						 
						 echo $this->Refresh($this->LanguageArray('phpapp','Add_success'),$this->MakeGetParameterURL());
						 exit();
				 }
		   
		   
		   
		   
		   }elseif($this->GET['op']==1){
			      
				 if($this->POST['Submit']){
					 
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
						
						if($this->Delete('file_icon'," WHERE fid IN($ids)")){
	
							  $refresh=$this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh=$this->LanguageArray('phpapp','Delete_failed');

						}
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
					   
					   
					   
				 }else{
					 	   
					   $orderarr=array(
								array('order'=>'fid','name'=>'ID'),
								array('order'=>'form','name'=>'��ʽ'),
								array('order'=>'icon','name'=>'ͼ��'),
								array('order'=>'type','name'=>'����')
								);
				
					   $order='ORDER BY fid DESC';
				
					   $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
			
					   if($this->GET['iforder']==1){
							$sqlorder=' ASC';
                            $iforder=2;
					   }else{
							$sqlorder=' DESC';
							$iforder=1;
					   }
				
					   foreach($orderarr as $key=>$value){
							 if($this->GET['sqlorder']==$key){
								   $order='ORDER BY '.$value['order'].$sqlorder;
							 }
					   }
			
					   
					   $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM  ".$this->GetTable('file_icon')." $order");
			
					   $list=$ajaxpage->ShowResult();
					 
				 }
			   
		   }else{
			    
				if($this->POST['Submit']){
					   $this->SetConfig($this->POST);
					   exit();
				}
			   
		   }
	
	       include $this->Template('annexset_manage');
	
	}
	
	
	//���Թ���
	public function LanguageAction(){
		
		 $this->GetMenuList(array(array('name'=>'�����б�','display'=>''),array('name'=>'�������','display'=>''),array('name'=>'�޸�����','display'=>'none')));
		 
		 if($this->GET['op']==1){
			    if($this->POST['Submit']){
					  $newid=$this->Insert('language',$this->POST,array());
					 
					  if($newid>0){
						   $refresh= $this->LanguageArray('phpapp','Add_success');
						   
					  }else{
						   $refresh= $this->LanguageArray('phpapp','Add_failed');
					  }
	                 
					  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					 
				}
		 }elseif($this->GET['op']==2){
			      
				  $id=$this->GET['id'];
				  
			      if($id>0){
					   $manage=$this->GetMysqlOne('*'," ".$this->GetTable('language')." WHERE id_phpapp='$id'");
				  }else{
					   echo $this->AdminAjaxRefresh($this->GET['menu'],$this->GET['action'],0,0,1);
					   exit();
				  }
				  
				  if($this->POST['Submit']){
					   
							$this->Update('language',$this->POST,array()," WHERE id_phpapp='$id'");
							

							echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
							  
							exit();
				  }
				  
				  
		 }else{
			    
				 if($this->POST['Submit']){
					 
					    $ids=$this->GetCheckBox($this->POST['checkbox']);
  
					    if($this->Delete('language'," WHERE id_phpapp IN($ids)")){
					  
							$refresh= $this->LanguageArray('phpapp','Delete_successfully');
					   
					    }else{
						   
							$refresh= $this->LanguageArray('phpapp','Delete_failed');
									 
					    }

						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								
						exit();
					 
				 }else{
								   
					   $orderarr=array(
								array('order'=>'id_phpapp','name'=>'ID'),
								array('order'=>'name_phpapp','name'=>'����'),
								array('order'=>'dir_phpapp','name'=>'Ŀ¼'),
								array('order'=>'domain_phpapp','name'=>'����'),
								array('order'=>'style_phpapp','name'=>'��ʽ'),
								array('order'=>'status_phpapp','name'=>'״̬')
								);
				
					   $order='ORDER BY id_phpapp DESC';
				
					   $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
			
					   if($this->GET['iforder']==1){
							$sqlorder=' ASC';
							$iforder=2;
					   }else{
							$sqlorder=' DESC';
							$iforder=1;
					   }
				
					   foreach($orderarr as $key=>$value){
							 if($this->GET['sqlorder']==$key){
								   $order='ORDER BY '.$value['order'].$sqlorder;
							 }
					   }
			
					   
					   $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM  ".$this->GetTable('language')." $order");
			 
			           $list=$ajaxpage->ShowResult();


				 }
				 
				 
		 }
		
		 include $this->Template('language_manage');
		   
	}
	
	
	//��֤��

	public function VerifyCodeSetAction(){  $this->SystemConfig('verifycodeset',array(array('name'=>'��֤������','display'=>''))); }
	
	
	
	//ͼƬˮӡ
	public function WatermarkSetAction(){  $this->SystemConfig('watermarkset',array(array('name'=>'ͼƬˮӡ����','display'=>''))); }
	
	
	
	//�Ż�����------------------------------------------------------------------------------------
	public function OptimizationSetAction(){   
            
			if($this->POST['Submit']){
				
				  
				  if ($this->GET['op']==7){
				  
						if($this->POST['query_cache_type']){
							
							   
							   if($this->POST['query_cache_type']=='ON'){
									
									$this->MysqlQuery('SET GLOBAL query_cache_type = ON');
							   }else{
								   
									$this->MysqlQuery('SET GLOBAL query_cache_type = OFF');
							   }
							   
							   if($this->POST['query_cache_wlock_invalidate']=='ON'){
									
									$this->MysqlQuery('SET GLOBAL query_cache_wlock_invalidate = ON');
							   }else{
								   
									$this->MysqlQuery('SET GLOBAL query_cache_wlock_invalidate = OFF');
							   }
							   
							   $query_cache_limit_value=intval($this->POST['query_cache_limit']);
							   
							   $this->MysqlQuery("SET GLOBAL query_cache_limit =$query_cache_limit_value");
							  
							   $query_cache_min_res_unit_value=intval($this->POST['query_cache_min_res_unit']);
							   
							   $this->MysqlQuery("SET GLOBAL query_cache_min_res_unit =$query_cache_min_res_unit_value");
							   
							   $query_cache_size_value=intval($this->POST['query_cache_size']);
							   
							   $this->MysqlQuery("SET GLOBAL query_cache_size =$query_cache_size_value");
							
						}
				  
				  }else{
				  
				  
				        $this->SetConfig($this->POST);
				  
				  }

				
			}else{
				
				  $this->GetMenuList(array(
										   array('name'=>'α��̬���ַ','display'=>''),
										   array('name'=>'COOKIE����','display'=>''),
										   array('name'=>'�û��ռ���������','display'=>''),
										   array('name'=>'SEO����','display'=>''),
										   array('name'=>'�ڴ滺������','display'=>''),
										   array('name'=>'��ҳ�Ż�����','display'=>''),
										   //array('name'=>'ȫ�ļ�������','display'=>''),
										   array('name'=>'MYSQL��������','display'=>'')

										   ));
				
				  $setarr=$this->MysqlFetchArray("SHOW VARIABLES LIKE '%query_cache%'");
				  
				  $cacheset=array();
				  if($setarr){
						foreach($setarr as $cache){
							  $cacheset[$cache[Variable_name]]=$cache['Value'];
						}
				  }
				
				  
				  include $this->Template('optimizationset_manage');
			}
	}
	
	
	
	//վ������--------------------------------------------------------------------------------------
	public function SiteSetAction(){ $this->SystemConfig('siteset',array(array('name'=>'��վ��Ϣ����','display'=>''),array('name'=>'��������','display'=>''),array('name'=>'��ϵ��ʽ','display'=>''),array('name'=>'��Աע��֪ͨ','display'=>'')));  }
	
	
	
	
	
	
	//��Ա����----------------------------------------------------------------------------------------
	public function MemberTypeAction(){
		
		    $this->GetMenuList(array(array('name'=>'��Ա�����б�','display'=>''),array('name'=>'��ӻ�Ա����','display'=>''),array('name'=>'�޸Ļ�Ա����','display'=>'none')));
			
			
			if($this->GET['op']==1 || $this->GET['op']==2){
				  if($this->POST['Submit']){
				
				           if(!$this->POST['name_phpapp']){
							   
							    $refresh= '<p>���Ʋ���Ϊ�գ�</p>';
							 
			                    echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								exit();
						   }
						   
						   
						   if(empty($this->POST['table_phpapp'])){
							   
							    $refresh= '<p>��������Ϊ�ջ����޸ģ�</p>';
							 
			                    echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								exit();
						   }
						   
						   if($this->POST['table_phpapp']){
							    
								  $string=new CharFilter($this->POST['table_phpapp']);
								  
								  if(!$string->IsABC()){
									    
										$refresh= '<p>����ֻ��������ĸ��ϣ�</p>';

										echo $this->Refresh($refresh,$this->MakeGetParameterURL());
										
								        exit();
								
								  }
						   }
						   
				  
				  }
				
			}
			
			if($this->GET['op']==1){
				  
				  if($this->POST['Submit']){
				          
						 $this->POST['table_phpapp']='member_'.$this->POST['table_phpapp'];
						  
						 $field="`uid` int(10) NOT NULL DEFAULT '0',`about` mediumtext NOT NULL,`tasklatitude` float NOT NULL,`tasklongitude` float NOT NULL,`taskmapzoom` tinyint(2) NOT NULL,`residelatitude` float NOT NULL,`residelongitude` float NOT NULL,`residemapzoom` tinyint(2) NOT NULL DEFAULT '0',`taskcity` int(10) NOT NULL DEFAULT '0',KEY `uid` (`uid`)";
						  
                         if($this->Create($this->GetTable($this->POST['table_phpapp']),$field)){
							   
							   $this->Insert('member_type',$this->POST,array());
							   
							   $refresh= $this->LanguageArray('phpapp','Add_success');
							   
						 }else{
							 
							   $refresh= '<p>���������ã�</p>';
								
						 }
						 
						 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								
						 exit();
						  
				  
				  }
				
				
			}elseif($this->GET['op']==2){
				   
				  $id=$this->GET['id'];
				  
				  if($this->POST['Submit']){
					    
						if($id>0){
							 
							  $this->POST['table_phpapp']='member_'.$this->POST['table_phpapp'];
							 
							  $this->Update('member_type',$this->POST,array()," WHERE id_phpapp='$id'");
							  
							  $refresh= $this->LanguageArray('phpapp','Edited_successfully');
							  
							  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('member_type')." WHERE id_phpapp='$id'");
						}else{
							 $manage='';
						}
				  }
				
			}else{
				   
				   if($this->POST['Submit']){
					   
		
					    $ids=$this->GetCheckBox($this->POST['checkbox']);

						
						$memberarr=$this->GetMysqlArray('*'," ".$this->GetTable('member_type')." WHERE id_phpapp IN($ids) ");
						
						foreach($memberarr as $value){
							  $this->DropTable($this->GetTable($value['table_phpapp']));
						}
						
						
						if($this->Delete('member_type'," WHERE id_phpapp IN($ids)")){
	
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');

						}
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
						
				   }else{
					   
					   
						 
					   
						 $orderarr=array(
								  array('order'=>'id_phpapp','name'=>'ID'),
								  array('order'=>'name_phpapp','name'=>'����'),
								  array('order'=>'table_phpapp','name'=>'����'),
								  array('order'=>'status_phpapp','name'=>'״̬')
								  );
				  
						 $order='ORDER BY id_phpapp DESC';
				  
						 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
		 
						 if($this->GET['iforder']==1){
							  $sqlorder=' ASC';
                              $iforder=2;
						 }else{
							  $sqlorder=' DESC';
							  $iforder=1;
						 }
				  
						 foreach($orderarr as $key=>$value){
							   if($this->GET['sqlorder']==$key){
									 $order='ORDER BY '.$value['order'].$sqlorder;
							   }
						 }
	  
						 
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM  ".$this->GetTable('member_type')." $order");
	  
						 $list=$ajaxpage->ShowResult();
				   
				   }
				  
			}
			
		    include $this->Template('member_type_manage');
	}
	
	
	//ǰ̨�û���------------------------------------------------------------------------------------------------
	public function UserGroupAction() {
		   
		   $this->GetMenuList(array(array('name'=>'�û����б�','display'=>''),array('name'=>'����û���','display'=>''),array('name'=>'�޸��û���','display'=>'none')));
		   
		   $memberarr=$this->GetMysqlArray('*'," ".$this->GetTable('member_type')."");
		   
				   
		   if($this->GET['op']==2){
			     
				  $id=empty($_GET['id']) ? 0 : $_GET['id'];
				 
			      if($this->POST['Submit']){
					    
						if($id>0){
							 
							 
							  $this->Update('usergroup',$this->POST,array()," WHERE gid='$id'");
							  
							  $refresh= $this->LanguageArray('phpapp','Edited_successfully');
							  
							  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								
						      exit();
							  
						}
					  
				  }else{
						if($id>0){
							 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('usergroup')." WHERE gid='$id'");
						}else{
							 $manage='';
						}
				  }
			   
           }elseif($this->GET['op']==1){
		   
		   
		         if($this->POST['Submit']){
					 
						 $this->Insert('usergroup',$this->POST,array());
						 
						 $refresh= $this->LanguageArray('phpapp','Add_success');
						 
						 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						 
						 exit();
				 }

			   
		   }else{
			        

					if($this->POST['Submit']){
						 
						$ids=$this->GetCheckBox($this->POST['checkbox']);

						if($this->Delete('usergroup'," WHERE gid IN($ids)")){
	
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');

						}
						 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					   
					    exit();
						 
					}else{
						
						   $orderarr=array(
								array('order'=>'a.gid','name'=>'ID'),
								array('order'=>'a.groupname','name'=>'�û���'),
								array('order'=>'b.name_phpapp','name'=>'�û�����')
								);
				
						   $order='ORDER BY gid DESC';
					
						   $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
				
						   if($this->GET['iforder']==1){
								$sqlorder=' ASC';
                                $iforder=2;
						   }else{
								$sqlorder=' DESC';
							    $iforder=1;
						   }
					
						   foreach($orderarr as $key=>$value){
								 if($this->GET['sqlorder']==$key){
									   $order='ORDER BY '.$value['order'].$sqlorder;
								 }
						   }
				
						  
						   $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.name_phpapp  FROM  ".$this->GetTable('usergroup')." AS a LEFT JOIN ".$this->GetTable('member_type')." AS b ON a.usertype=b.id_phpapp $order");
				
						   $list=$ajaxpage->ShowResult();
					}
			     
		   }
		   

		   include $this->Template('usergroup_manage');
	}
	
	
	
	//�˵�
	public function GetMenuList($menulist=''){
		
		    $url=$this->MakeGetParameterURL();
			
			foreach($menulist as $key=>$value){
				
				  if($value['display']==='none'){
					   $display=' class="menu_display_none"';
				  }else{
					   $display='';
				  }
				  
				  
				  if($this->GET['op']==$key){
					   
					   $this->actionmenu.='<li class="now_meun_tab"><a href="'.$url.'&op='.$key.'">'.$value['name'].'</a></li>';
					   
				  }else{
					 
					   $this->actionmenu.='<li'.$display.'><a href="'.$url.'&op='.$key.'">'.$value['name'].'</a></li>';
				  }
			}
		
	}
	
	public function SystemConfig($tname,$menuname=array()){
	
	        $this->GetMenuList($menuname);
		
		    if($this->POST['Submit']){
				  
				  $files=$this->UploadFile();
												   
				  if($files){
						 foreach($files as $fid){
							  $this->Insert('apps_file',array('appid'=>1,'fid'=>$fid,'uid'=>$this->uid,'id'=>1,'type'=>1),array());
						 }
				  }
				  
				  $this->SetConfig($this->POST);
				
			}else{
		
			      include $this->Template($tname.'_manage');
			
			}
	}
	
	public function GetPhpappActionID($appid=0,$ac=0){
		   
		   $actionarr=$this->GetMysqlArray('id_phpapp,aid_phpapp,apps_phpapp,name_phpapp'," ".$this->GetTable('apps_action')." WHERE apps_phpapp='$appid'  ");
		   
		   $actionlist='';
		   
		   if($actionarr){
			   
			     foreach($actionarr as $value){
					 
						if($value['aid_phpapp']==$ac){
							  $selected=' selected="selected"';
						}else{
							  $selected='';
						}
					    
						$actionlist.='<option value="'.$value['aid_phpapp'].'"'.$selected.'>'.$value['name_phpapp'].'</option>';
					    
				 }
			   
		   }else{
			     
				 $actionlist='<option value="0">��</option>';
			   
		   }
		   
		   return $actionlist;
		
	}

}



?>
