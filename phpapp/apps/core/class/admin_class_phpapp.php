<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class PHPAPPAdmin extends PHPAPP{
	
	function __construct(){
          parent::__construct();
	}
	
	function AdminAccess(){
		
		$menu=$app=$action=$op=$id=$appid='0';
		$actionmenulist='';
		
		$actionclass='DefaultAction';
		$appclass=array('id_phpapp'=>'1','dir_phpapp'=>'admin','class_phpapp'=>'Administrator');
		
		
		if(!empty($_GET['menu'])){
			
			if(is_numeric($_GET['menu'])){
				$menu=intval($_GET['menu']);
			}else{
				exit();
			}
			
		}
		
		if(!empty($_GET['action'])){
			$action=intval($_GET['action']);
		}
		
		if(!empty($_GET['op'])){
			$op=intval($_GET['op']);
		}
		
		if(!empty($_GET['id'])){
			$id=intval($_GET['id']);
		}
		
		if(!empty($_GET['value'])){
			$appid=intval($_GET['value']);
		}
		
		if(!$this->uid){
			   
			   $postkey=array('Submit'=>'');
			   
			   $admindir=$_SERVER['REQUEST_URI']; 
			   
			   $admindir=explode('/',$admindir);
			   
			   $dirnum=count($admindir);
			   
			   $admindir=$admindir[$dirnum-1];
			   
			
			   $POST=$this->POSTArray();
				   
			   foreach($postkey as $key=>$vaule){
				   if(empty($POST[$key])){
					   $POST[$key]='';
				   }
			   }
			   
			   if($POST['Submit']){
				   
					  include(APPS.'/member/main_phpapp.php');
					  
					  $login=new MemberMainControls();
					  
					  if($this->CheckSecurityForm($POST['SecurityForm'])){
						 
						 $isseccode=0;
						 
						 if(!PHPAPP::$config['adminloginiscode']){
							   $isseccode=1;
						 }else{
							   if(PHPAPP::$config['siteclose']){
									 $isseccode=1;
							   }else{
									 $isseccode=$login->SecCode($POST['SecCode']);
							   }
						 }
						 
						 
						 if($isseccode){
								 
								$loginerror=$login->LoginError(1,1);
								
								if($loginerror){
									  $this->Refresh($loginerror,$admindir);
								}else{
									
									 $check=$login->UserLogin(1,1,$admindir,intval($POST['CookieTime']));
									 
									 if($uclient=$this->GetClient($POST['UserName'],$POST['Password'])){
										   $check=$check[0];
										   $uclogin='';
									 }else{
										   $uclogin='';
									 }
									 
									 if($check=='ok'){
									
											$this->Refresh('登录成功!'.$uclogin,$admindir);
										
									 }else{
											
											$loginerror=$login->LoginError(1);
											$this->Refresh($loginerror,$admindir);
									 }
								}
						   
						 }else{
			
							   $this->Refresh('对不起!验证码不正确,请重新输入!',$admindir);
							   
						 }
						 
					  }else{
				 
							$this->Refresh('提交表单已过期!',$admindir);
					  }
					 
					  exit();
				   
			   }else{
			   
			   
					 $isadminfile=0;
					 if(file_exists('admin.php')){
						  $isadminfile=1;
					 }
				  
					 include $this->Template('admin:login');
			   
			   }
					  
		}else{
				
				if(!$this->IsAdmin()){
					  
					  $this->Refresh('非法登录!',SURL);
					
				}else{
					  
					  
					  $admingrouparray=$this->GetMysqlOne('admingroup'," ".$this->GetTable('member')." WHERE uid='$this->uid' ");  
					  
					  if(!intval($admingrouparray['admingroup'])){
							
							
							 $this->Refresh('非法操作!',SURL);
						  
						  
					  }else{
					  
								  $admingroup=$admingrouparray['admingroup'];
					  
								  $adminallowarray=$this->GetMysqlOne('app_phpapp,action_phpapp'," ".$this->GetTable('admin')." WHERE id_phpapp='$admingroup' AND status_phpapp=0 ");  
								 
				
								  $GetAdminMenu=$this->GetMysqlOne('*'," ".$this->GetTable('admin_menu')." WHERE catid_phpapp='$menu' ");   
								  
								  if($GetAdminMenu){
								  
									   //get apps
									   $app=$GetAdminMenu['apps_phpapp'];
									   $appclass=$this->GetMysqlOne('*'," ".$this->GetTable('apps')." WHERE id_phpapp='$app' "); 
													 
									   //admin
									   if($app==1){
										   
											 if($action==0){
												   $action=$GetAdminMenu['action_phpapp'];
											 }
											
											 $GetAdminAction=$this->GetMysqlOne('*',"".$this->GetTable('apps_action')." WHERE status_phpapp=0 AND type_phpapp=1 AND apps_phpapp='$app' AND aid_phpapp='$action'"); 
										   
									  
											 if($GetAdminAction){
												 
												   $actionclass=$GetAdminAction['class_phpapp'].'Action';
												 
												 
											 }else{
												 
												 
												   exit('No data1!');
												  
											 }
											 
											 
									   }else{
									   
											   
									   
											   $GetAdminAction=$this->GetMysqlArray('*'," ".$this->GetTable('apps_action')." WHERE status_phpapp=0 AND type_phpapp=1 AND apps_phpapp='$app' ORDER BY aid_phpapp ASC");
								  
												if($GetAdminAction){
								  
										   
														foreach($GetAdminAction as $value){
												   
															$actionlist='><a href="'.$this->MakeGetParameterURL(array('app'=>$app,'menu'=>$menu,'action'=>$value['aid_phpapp'])).'">'.$value['name_phpapp'].'</a></li>';
														   
															if($value['aid_phpapp']==$action){
														 
																   $actionclass=$value['class_phpapp'].'Action';
														   
																   $actionmenulist.='<li class="now_meun_tab" '.$actionlist;
														   
															}else{
															  
																   if($value['show_phpapp']){
																		 $actionmenulist.='<li class="win" '.$actionlist;
																   }else{
																		$actionmenulist.='<li'.$actionlist;
																   }
														 
															} 
										
														}
											   
											   
														if($actionclass=='DefaultAction'){
								   
														   $actionmenulist='';
															 foreach($GetAdminAction as $key=>$value){
														
																   $actionlist='><a href="'.$this->MakeGetParameterURL(array('app'=>$app,'menu'=>$menu,'action'=>$value['aid_phpapp'])).'">'.$value['name_phpapp'].'</a></li>';
															   
																   if($key==0){
														   
																		$actionmenulist.='<li class="now_meun_tab"'.$actionlist;
														   
																   }else{
														 
																		  if($value['show_phpapp']){
																				$actionmenulist.='<li class="win" '.$actionlist;
																		  }else{
																				$actionmenulist.='<li'.$actionlist;
																		  }
														 
																   } 
										
														   }
												   
														}
								   
								  
								  
											   }else{
													
													if(!$GetAdminMenu['catalog_phpapp']){
														  $actionclass='CatalogListAction';
														  $appclass=array('id_phpapp'=>'0','dir_phpapp'=>'admin','class_phpapp'=>'Administrator');
													}else{
														  exit('No data2!');
													}
											   }
									   
									   }
								  
								  
								  }
								  
								  $isallow=$allowid=$isacallow=false;
								  
								  if($adminallowarray['app_phpapp']){
										  
										  $allowid=$this->ExplodeStrArr($adminallowarray['app_phpapp']);
																				  
										  $allowarray=explode(',',$allowid);
										  
										  if($allowarray){
												
												foreach($allowarray as $allow){
													   if($appclass['id_phpapp']==$allow){
															 
															 $isallow=true;
														   
													   }
												}
											  
										  }
									  
								  }else{
									  
										$isallow=true;
									  
								  }
								  
		
								  
								  if($isallow){
									  
										 if($adminallowarray['action_phpapp'] && $action){
												  
												  $ackey=$appclass['id_phpapp'].':'.$action;
												  
												  $actionallowarray=explode(',',$adminallowarray['action_phpapp']);
												  
												  if($actionallowarray){
														  foreach($actionallowarray as $acvalue){
																if($acvalue==$ackey){
																	  $isacallow=true;
																}
														  }
												  }
											  
										  }elseif($appclass['id_phpapp']==1){
											     
												 $isacallow=true;
											  
										  }elseif(!$adminallowarray['app_phpapp'] && !$adminallowarray['action_phpapp']){
											  
												 $isacallow=true;
											  
										  }
										  
										  if($isacallow){
											  
											    self::$appdir=$appclass['dir_phpapp'];
											  
												include(SYS.'/apps/'.$appclass['dir_phpapp'].'/admin_phpapp.php');
												
											    $ControlClass=$appclass['class_phpapp'].'ManageControls';
										
												$control = new $ControlClass($actionmenulist);
												
												$control->$actionclass();
										  
										  }else{
												
												$this->actionmenu=$actionmenulist;
												
												include $this->AppsView('admin:header');
												
												exit('对不起!该功能您无权限操作!');
											  
										  }
										  
										  
								  }else{
									  
									      $this->actionmenu=$actionmenulist;
												
										  include $this->AppsView('admin:header');
									  
										  exit('对不起!该功能您无权限操作!!');
								  }
					  }
				}
		
		}


	}
	
}


class AdminClass extends PHPAPP{


	
	function __construct(){

	}
	
	
	
    function getwheresql($getval='',$filter='',$iswhere=0){

		$sqlvalue=$sqlarr=array();
		$sqlurl='';
		
		foreach($getval as $key=>$value){
			   
			   
			   if(isset($filter[$key])){
			   
					   $keyarr=$filter[$key];
					   
					   if(!empty($keyarr[1])){
							 
							 if($keyarr[1]=='float'){
								  $value=floatval($value);
								  if($value>0){
									  $sqlarr[]=$keyarr[0].'='.$value;
								  }
								  $sqlvalue[$key]=$value;
								  
							 }elseif($keyarr[1]=='int'){
								  $value=intval($value);
								  if($value>0){
									  $sqlarr[]=$keyarr[0].'='.$value;
								  }
								  $sqlvalue[$key]=$value;
								  
							}elseif($keyarr[1]=='string'){
								  $value=$this->str($value,0,1,0,1,0,1);
								  if($value){
									  $sqlarr[]=$keyarr[0]."='".$value."'";
								  }
								  $sqlvalue[$key]=urldecode($value);
								  
							 }elseif($keyarr[1]=='search'){
								  $value=$this->str($value,0,1,0,1,0,1);
								  if($value){
									  $sqlarr[]=$keyarr[0].' REGEXP \''.$value.'\'';  
								  }
								  
								  $sqlvalue[$key]=urldecode($value);
								  
								  
							 }elseif($keyarr[1]=='time'){
								 
								      $value=$this->str($value,0,1,0,1,0,1);
								  
								      $partkey=iconv_substr($key,-1,1,S_CHARSET);
										
									  if($partkey ==1){
											$value=empty($value) ? '' : strtotime($value);
											if($value){
												 $sqlarr[]=$keyarr[0].'>=\''.$value.'\'';  
											}
											
											$sqlvalue[$key]=@date("Y-m-d",$value);
									  }
									  
									  if($partkey ==2){
											$value=empty($value) ? '' : strtotime($value);
											if($value){
												 $sqlarr[]=$keyarr[0].'<=\''.$value.'\'';  
											}
											
											$sqlvalue[$key]=@date("Y-m-d",$value);
									  }
				
						
								  
							 }elseif($keyarr[1]=='part'){
								 
								        $partkey=iconv_substr($key,-1,1,S_CHARSET);
						
										if($partkey ==1){
											
											  if($value){
												   $sqlarr[]=$keyarr[0].'>=\''.floatval($value).'\'';  
											  }
											  
											  $sqlvalue[$key]=floatval($value);
										}
											
										if($partkey ==2){
											
											  if($value){
												   $sqlarr[]=$keyarr[0].'<=\''.floatval($value).'\'';  
											  }
											  
											  $sqlvalue[$key]=floatval($value);
										}	
							 
							 
							 }elseif($keyarr[1]=='city'){
								 
								  $value=intval($value);
								  $categoryarray=$this->GetMysqlOne('catid,nexts'," ".$this->GetTable('category_city')." WHERE catid='$value' ");  
								  
								  if($categoryarray['nexts']){
									  $sqlarr[]=$keyarr[0].' IN ('.$categoryarray['nexts'].')';
								  }
								  
								  $sqlvalue[$key]=$value;
								 
							 }
							 
							
							 

				
							 $sqlurl.='&'.$key.'='.urlencode($value);
							 
					   }
					
			   
			   }
			
		}
		

		$showsql=implode(' AND ',$sqlarr);
  
		if(empty($showsql)){
			$wheresql=array('',$sqlvalue,"$sqlurl");
		}else{
			if($iswhere){
				 $showsql=' AND '.$showsql;
			}else{
			     $showsql='WHERE '.$showsql;
			}
			$wheresql=array("$showsql",$sqlvalue,"$sqlurl");
		}
  
		return $wheresql;
	  
    }
}
	

 
?>