<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.7.10
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class UpdateMenuCache extends PHPAPP{

	
	function __construct(){
		   
		   parent::__construct();
		   
           $this->UpdateSiteMenu();
	}

	function UpdateSiteMenu(){
           global $appclass,$language;
		   
           $navarr=$this->GetMysqlArray('*'," ".$this->GetTable('nav')." ORDER BY displayorder ASC");
		   
		   $navid='';
		   
		   if($navarr){
			      
				  foreach($navarr as $nav){
						if($navid){
							 $navid.=','.$nav['appid']; 
						}else{
							 $navid=$nav['appid'];  
						}
				  }
			   
		   }
		   
		   if($navid){
			     
				  
				  
				  $templatedir=SYS.'/templates/'.S_TEMPLATE.'/'.$language.'/phpapp/sitemenucache.htm';
				  
					  
						$navigation='<div id="navigation"><div id="navigation_menu"><ul>';
						
						foreach($navarr as $key=>$value){
							
							       if(!$value['blank']){
									   
									    $blank=' target="_blank" ';
									   
								   }else{
									    $blank='';
								   }
							  
								  if ($value['site']==0){
									  if ($value['appid']<1){
										    $navigation.='<li id="Nav_ID_'.$value['appid'].'"><a href="'.$value['navurl'].'"'.$blank.'>'.$value['navname'].'</a></li>';
									  }else{
										    
											if($value['appid']==9){
												   $navigation.='<li id="Nav_ID_'.$value['appid'].'"><a href="member.php?app='.$value['appid'].'"'.$blank.'>'.$value['navname'].'</a>'."\n";
											}else{
											
										           $navigation.='<li id="Nav_ID_'.$value['appid'].'"><a href="index.php?app='.$value['appid'].'"'.$blank.'>'.$value['navname'].'</a>'."\n";
											}
											
											if($value['appid']==83){
												  $categoryarr=$this->GetMysqlArray('catid,total,name,color'," ".$this->GetTable('category')." WHERE upid=0 AND type='82' ORDER BY displayorder ASC");
											}else{
											      $categoryarr=$this->GetMysqlArray('catid,total,name,color'," ".$this->GetTable('category')." WHERE upid=0 AND type='$value[appid]' ORDER BY displayorder ASC");
											}
											 
											 if($categoryarr){
												 
													 $navigation.='<ul id="ChildMenuShow_'.$value['appid'].'" class="menushowlist" style="display:none">'."\n";
											         
													 $categorycount=count($categoryarr);
													 
													 foreach($categoryarr as $keys=>$onevalue){
		  
		                                                  if($value['appid']==83){
															    $taskonecategorysubclass=$this->GetMysqlArray('*'," ".$this->GetTable('category')." WHERE type='82' AND upid='$onevalue[catid]' ORDER BY displayorder ASC");         
														  }else{
														  
														        $taskonecategorysubclass=$this->GetMysqlArray('*'," ".$this->GetTable('category')." WHERE type='$value[appid]' AND upid='$onevalue[catid]' ORDER BY displayorder ASC");         
														  }
														  
														  if($onevalue['color']){
																$color=' style="color:'.$onevalue['color'].';"';
														   }else{
																$color='';
														   }
														   
														  if ($taskonecategorysubclass){ 
														          
																  if($keys==0){
																	   $ulstyle=' style="border-top-style:none;" ';
																  }elseif($categorycount-1==$keys){
																	   $ulstyle=' style="border-bottom-style:none;" ';
																  }else{
																	   $ulstyle='';
																  }
																  
																  $navigation.='     <ul'.$ulstyle.'><h4><a href="index.php?app='.$value['appid'].'&item=1.'.$onevalue['catid'].'">'.$onevalue['name'].'</a></h4><div>'."\n";
																   
														  }else{
																 
																  $navigation.='     <li style="border-bottom: 1px solid #E8F3FF;"><a href="index.php?app='.$value['appid'].'&action=10&item=1.'.$onevalue['catid'].'"><span '.$color.'>'.$onevalue['name'].'</span></a></li>'."\n";
														  }
																 
																	 
														  if ($taskonecategorysubclass){
															  
																   foreach($taskonecategorysubclass as $subvalue){
																		   $navigation.='     <li><a href="index.php?app='.$value['appid'].'&item=1.'.$subvalue['catid'].'"><span '.$color.'>'.$subvalue['name'].'</span></a></li>'."\n";
																   }
																   
																   $navigation.='     </div></ul>'."\n";
											  
														  } 
															 
														 
													 }
													 
													  $navigation.='</ul>'."\n";
											 
											 }
												   
												  
								       }
												   
										   
										    $navigation.='</li>'."\n\n";
								
								  }else{
									  $navigation.='<li><a href="'.$value['navurl'].'"'.$blank.'>'.$value['navname'].'</a></li>';
								  }
							   
						}
						
						
						$navigation.='</ul></div></div>'."\n\n";
						
                        
						$navigation.='<script type="text/javascript">$(function(){'."\n";
																				
						foreach($navarr as $key=>$value){
							   
							   if($value['appid']>0){
						             $navigation.='$("#Nav_ID_'.$value['appid'].'").hover( function (){$("#Nav_ID_'.$value['appid'].'").addClass("nowfocus");$("#ChildMenuShow_'.$value['appid'].'").fadeIn(0);},function (){$("#Nav_ID_'.$value['appid'].'").removeClass("nowfocus");$("#ChildMenuShow_'.$value['appid'].'").fadeOut(0);}); '."\n"; 
							   }
						
						}
						
						
						$navigation.='absolutewidth=parseInt(($(document.body).width()-980)/2);$(".menushowlist").css("left",absolutewidth);});'."\n"; 
						$navigation.='</script>';

						$this->WriteFile($templatedir,$navigation);
					  
			
			   
			   
		   }
		
	}
	
	 
}
 
?>