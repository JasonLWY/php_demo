<?php
/*
	EDOOG.COM (C) 2009-2014 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


include(Core.'/class/my_class_phpapp.php');

class PHPAPP extends MyClass{

	public static $appdir,$config=array(),$fileicon=array(),$SEO=array('title'=>'','keywords'=>'','description'=>''),$appclass=array(),$appactionclass=array();

	public $app,$ac,$lang,$uid,$page,$nowcity,$username;
		
	function __construct(){	 
         
		 parent::__construct();
		  
		 global $systemvalue,$language;
		 //ID int
		 $this->page=$systemvalue['page'];
		 $this->nowcity=$systemvalue['nowcity'];
		 $this->uid=empty($systemvalue['uid']) ? 0 : $systemvalue['uid'];
		 $this->username=empty($systemvalue['username']) ? 0 : $systemvalue['username'];
		 $this->lang=$language;
		 $this->app=$systemvalue['app'];
		 $this->ac=$systemvalue['ac'];

	}
	
	
	function NowTime(){
		  return time();
	}
	
	function GetAppName(){
		 return PHPAPP::$appclass['name_phpapp'];
	}
	
	function GetAppTitle(){
		return PHPAPP::$appclass['title_phpapp'];
	}
	
	function GetAppKeywords(){
		return PHPAPP::$appclass['keywords_phpapp'];
	}
	
	function GetAppDescription(){
		return PHPAPP::$appclass['description_phpapp'];
	}
	
	function GetFileVersion(){
		return PHPAPP::$config['phpappversion'];
	}
	
	function GetActionTitle(){
		return empty(PHPAPP::$appactionclass['title_phpapp']) ? '' : PHPAPP::$appactionclass['title_phpapp'];
	}
	
	function GetActionKeywords(){
		return empty(PHPAPP::$appactionclass['keywords_phpapp']) ? '' : PHPAPP::$appactionclass['keywords_phpapp'];
	}
	
	function GetActionDescription(){
		return empty(PHPAPP::$appactionclass['description_phpapp']) ? '' : PHPAPP::$appactionclass['description_phpapp'];
	}
	
	function GetUserCityId(){
		  global $nowcity;
		  if(!empty($nowcity)){
			   return $nowcity;
		  }else{
			   return $this->nowcity;
		  }
		  
	}
	
	
	
	//系统缓存配置开始--------------------------------------------------------------------------------------------------------
	public function SetConfigDIR(){
		
		 define('ConfigDIR',SYS.'/data/cache/config/');
		 
		 if(!is_dir(ConfigDIR)) {
			   @mkdir(ConfigDIR,0777);
			   $this->WriteFile(ConfigDIR.'index.html','');
	     }
	}
	
	public function SetStylePath(){
		 define('TURL',SDIR.'/phpapp/templates/'.S_TEMPLATE.'/style/'.PHPAPP::$config['stylepath'].'/');
		 define('STYLEURL',SURL.'/phpapp/templates/'.S_TEMPLATE.'/style/'.PHPAPP::$config['stylepath'].'/');
		 define('STYLESYS',SYS.'/templates/'.S_TEMPLATE.'/style/'.PHPAPP::$config['stylepath'].'/');
	}
	  
    public function GetConfig(){
		  static $config=array();

		  if(!file_exists(SYS.'/data/cache/config/config.php')){
                  $this->UpdateConfig();
	      }
		  
		  include(SYS.'/data/cache/config/config.php');
		  
		  return self::$config=$config;
    }
	
	
    function UpdateConfig(){

		  $confiarr=$this->GetMysqlArray('*',$this->GetTable('config'));
		  $config="<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	 if(!defined('IN_PHPAPP')){exit('Data error');}"; 
		 
		  $config.='$config=array(';
		 
		  $arrayvalue='';
		  foreach($confiarr as $value){
			   if($arrayvalue){
	                 $arrayvalue.=',\''.$value['name_phpapp'].'\'=>\''.$value['value_phpapp'].'\'';
			   }else{
				     $arrayvalue.='\''.$value['name_phpapp'].'\'=>\''.$value['value_phpapp'].'\'';
			   }
          }
		 
		  $config.=$arrayvalue.');?>';

		  $this->WriteFile(SYS.'/data/cache/config/config.php',$config);
     }
	 
	 
	 
	function GetApps($ispath=0){
		  static $apps=array();
          
		  if($ispath){
			  if(!file_exists(SYS.'/data/cache/config/route_apps.php')){
					   $this->UpdateRouteApps();
			  }
			  
			  include(SYS.'/data/cache/config/route_apps.php');
		  }else{
			  if(!file_exists(SYS.'/data/cache/config/apps.php')){
					   $this->UpdateApps();
			  }
			  
			  include(SYS.'/data/cache/config/apps.php');
		  }
		  
		  return $apps;
		  
    }
	
	
	 function UpdateApps(){

		  $confiarr=$this->GetMysqlArray('*',$this->GetTable('apps').' WHERE status_phpapp=0 AND show_phpapp=0');
		  $config="<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	 if(!defined('IN_PHPAPP')){exit('Data error');}"; 

		  $config.='$apps=array(';
		
		  $arrayvalue='';
		  foreach($confiarr as $value){
			  
			   if($arrayvalue){
	                 $arrayvalue.=',';
			   }
			   
			   $arrayvalue.=$value['id_phpapp'].'=>array(\'id_phpapp\'=>\''.$value['id_phpapp'].'\',\'route_phpapp\'=>\''.$value['route_phpapp'].'\',\'dir_phpapp\'=>\''.$value['dir_phpapp'].'\',\'class_phpapp\'=>\''.$value['class_phpapp'].'\',\'name_phpapp\'=>\''.$value['name_phpapp'].'\',\'title_phpapp\'=>\''.$value['title_phpapp'].'\',\'keywords_phpapp\'=>\''.$value['keywords_phpapp'].'\',\'description_phpapp\'=>\''.$value['description_phpapp'].'\')';
          }
		 
		  $config.=$arrayvalue.');?>';
		 
		  $this->WriteFile(SYS.'/data/cache/config/apps.php',$config);
     }
	
    function UpdateRouteApps(){

		  $confiarr=$this->GetMysqlArray('*',$this->GetTable('apps').' WHERE status_phpapp=0 AND show_phpapp=0');
		  $config="<?php
/*
	EDOOG.COM (C) 2009-2014 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.5
*/	 if(!defined('IN_PHPAPP')){exit('Data error');}"; 

		  $config.='$apps=array(';
		
		  $arrayvalue='';
		  foreach($confiarr as $value){
			  
			   if($arrayvalue){
	                 $arrayvalue.=',';
			   }
			   
			   $arrayvalue.='\''.$value['route_phpapp'].'\'=>array(\'id_phpapp\'=>\''.$value['id_phpapp'].'\',\'dir_phpapp\'=>\''.$value['dir_phpapp'].'\',\'class_phpapp\'=>\''.$value['class_phpapp'].'\',\'name_phpapp\'=>\''.$value['name_phpapp'].'\',\'title_phpapp\'=>\''.$value['title_phpapp'].'\',\'keywords_phpapp\'=>\''.$value['keywords_phpapp'].'\',\'description_phpapp\'=>\''.$value['description_phpapp'].'\')';
			   
          }
		 
		  $config.=$arrayvalue.');?>';
		 
		  $this->WriteFile(SYS.'/data/cache/config/route_apps.php',$config);
     }
	 
	 
	 public function GetAction($appid='default',$ispath=0){

          if($ispath){
			  if(!file_exists(SYS.'/data/cache/config/route_'.$appid.'_action.php')){
					$this->UpdateRouteAction($appid);
			  }
			  
			  include(SYS.'/data/cache/config/route_'.$appid.'_action.php');
		  }else{

			  if(!file_exists(SYS.'/data/cache/config/apps_'.$appid.'_action.php')){
					$this->UpdateAction($appid);
			  }
			  
			  include(SYS.'/data/cache/config/apps_'.$appid.'_action.php');
		  
		  }

		  return $appsaction;
		  
    }
	
	function UpdateAction($appid){
          $appid=intval($appid);
		  $confiarr=$this->GetMysqlArray('*'," ".$this->GetTable('apps_action')." WHERE apps_phpapp='$appid' AND status_phpapp=0 AND type_phpapp!=1");
		  
		  if($confiarr){
			  
			  $config="<?php
	/*
		EDOOG.COM (C) 2009-2012 EDOOG Inc.
		This is NOT a freeware, use is subject to license terms
		V2.0  2012.3.5
	*/	 if(!defined('IN_PHPAPP')){exit('Data error');}"; 
			 
			  $config.='$appsaction=array(';
			 
			  $arrayvalue='';
			  foreach($confiarr as $value){
				  
				   if($arrayvalue){
						 $arrayvalue.=',';
				   }
				   
				   $arrayvalue.='\''.$value['type_phpapp'].'.'.$value['aid_phpapp'].'\'=>array(\'aid_phpapp\'=>\''.$value['aid_phpapp'].'\',\'route_phpapp\'=>\''.$value['route_phpapp'].'\',\'apps_phpapp\'=>\''.$value['apps_phpapp'].'\',\'class_phpapp\'=>\''.$value['class_phpapp'].'\',\'type_phpapp\'=>\''.$value['type_phpapp'].'\',\'title_phpapp\'=>\''.$value['title_phpapp'].'\',\'keywords_phpapp\'=>\''.$value['keywords_phpapp'].'\',\'description_phpapp\'=>\''.$value['description_phpapp'].'\')';
				   
			  }
			 
			  $config.=$arrayvalue.');?>';
			 
			  $this->WriteFile(SYS.'/data/cache/config/apps_'.$appid.'_action.php',$config);
		  }
     }
	
    function UpdateRouteAction($appid){
          $appid=strtolower($appid);
		  $confiarr=$this->GetMysqlArray('b.*'," ".$this->GetTable('apps')." AS a LEFT JOIN ".$this->GetTable('apps_action')." AS b ON a.id_phpapp=b.apps_phpapp WHERE a.route_phpapp='$appid'  AND a.status_phpapp=0 AND a.show_phpapp=0 AND b.status_phpapp=0 AND b.type_phpapp!=1 ");
		  
		  if($confiarr){
			  
			  $config="<?php
	/*
		EDOOG.COM (C) 2009-2014 EDOOG Inc.
		This is NOT a freeware, use is subject to license terms
		V3.0  2013.3.5
	*/	 if(!defined('IN_PHPAPP')){exit('Data error');}"; 
			 
			  $config.='$appsaction=array(';
			 
			  $arrayvalue='';
			  foreach($confiarr as $value){
				  
				   if($arrayvalue){
						 $arrayvalue.=',';
				   }
				   
				   $arrayvalue.='\''.$value['route_phpapp'].'\'=>array(\'aid_phpapp\'=>\''.$value['aid_phpapp'].'\',\'apps_phpapp\'=>\''.$value['apps_phpapp'].'\',\'class_phpapp\'=>\''.$value['class_phpapp'].'\',\'type_phpapp\'=>\''.$value['type_phpapp'].'\',\'title_phpapp\'=>\''.$value['title_phpapp'].'\',\'keywords_phpapp\'=>\''.$value['keywords_phpapp'].'\',\'description_phpapp\'=>\''.$value['description_phpapp'].'\')';
				   
			  }
			 
			  $config.=$arrayvalue.');?>';
			 
			  $this->WriteFile(SYS.'/data/cache/config/route_'.$appid.'_action.php',$config);
		  }
     }
	 
	 function SystemLanguage(){
          
		  if(!file_exists(SYS.'/data/cache/config/language.php')){
                
				  $confiarr=$this->GetMysqlArray('*',$this->GetTable('language').' WHERE status_phpapp=0');
				  $config='<?php ';
				  $config.='$systemlanguage=array(';
				  $arrayvalue='';
				  foreach($confiarr as $value){
					   if($arrayvalue){
							 $arrayvalue.=',\''.$value['dir_phpapp'].'\'=>array(\'name_phpapp\'=>\''.$value['name_phpapp'].'\',\'domain_phpapp\'=>\''.$value['domain_phpapp'].'\',\'style_phpapp\'=>\''.$value['style_phpapp'].'\')';
					   }else{
							 $arrayvalue.='\''.$value['dir_phpapp'].'\'=>array(\'name_phpapp\'=>\''.$value['name_phpapp'].'\',\'domain_phpapp\'=>\''.$value['domain_phpapp'].'\',\'style_phpapp\'=>\''.$value['style_phpapp'].'\')';
					   }
				  }
				 
				  $config.=$arrayvalue.');?>';
				 
				  $this->WriteFile(SYS.'/data/cache/config/language.php',$config);
		  }
		  
		  include(SYS.'/data/cache/config/language.php');
		  
		  return $systemlanguage;
     }
	 	 
	 public function GetFileIcon(){

		  if(!file_exists(ConfigDIR.'fileicon.php')){
                 $this->UpdateFileIcon();
	      }
		  
		  include(ConfigDIR.'fileicon.php');
		  
		  return self::$fileicon=$fileicon;
		  
    }
	
	function UpdateFileIcon(){

		  $confiarr=$this->GetMysqlArray('*',$this->GetTable('file_icon').' ORDER BY fid ASC ');
		  $config="<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	 if(!defined('IN_PHPAPP')){exit('Data error');}"; 
		 
		  $config.='$fileicon=array(';
		 
		  $arrayvalue='';
		  foreach($confiarr as $value){
			   if($arrayvalue){
	                 $arrayvalue.=',\''.$value['form'].'\'=>\''.$value['icon'].'\'';
			   }else{
				     $arrayvalue.='\''.$value['form'].'\'=>\''.$value['icon'].'\'';
			   }
          }
		 
		  $config.=$arrayvalue.');?>';
		 
		  $this->WriteFile(SYS.'/data/cache/config/fileicon.php',$config);
     }
	 
	 //系统缓存配置结束--------------------------------------------------------------------------------------------------------
	 
     
	 //访问
	 function SiteAccess(){
		 
			global $actiontype;
			
			$appclass=PHPAPP::$appclass;
			$appactionclass=PHPAPP::$appactionclass;

			if(empty($appclass)){
				$appclass='Default';
			}

			$actionclass=$appactionclass['class_phpapp'];
			
			if(empty($actionclass)){
				$actionclass='DefaultAction';
			}else{
				$actionclass.='Action';
			}

			$controls='Controls';
			
			if($actiontype==3){
				 $appfilename='space_phpapp.php';
				 $controls='Space'.$controls;
			}elseif($actiontype==2){
				 $appfilename='member_phpapp.php';
				 $controls='Member'.$controls;
			}else{
				 $appfilename='main_phpapp.php';
				 $controls='Main'.$controls;
			}

			$appclassfile=SYS.'/apps/'.$appclass['dir_phpapp'].'/'.$appfilename;
			
			if(file_exists($appclassfile)){
			        
					self::$appdir=$appclass['dir_phpapp'];
					
					include($appclassfile);
			
					$ControlClass=$appclass['class_phpapp'].$controls;
			
					$control = new $ControlClass;

					$control->$actionclass();
			
			}else{
			
					header("location:".SURL);
					exit();
			
			}
		 
	 }
	 
	 
	 
	 function GetNowCity(){
		    
		    @include_once(Core.'/class/ipcity_class_phpapp.php');
	 }
	 
	 
	 //是否管理员
	 function IsAdmin(){

		   $adminarr=$this->ExplodeStrArr(S_ADMIN);
		   $admins=explode(',',$adminarr);
		   $ifadmin=false;
	  
		   foreach($admins as $value){
			   
			   if(intval($this->uid)==intval($value)){
				    $ifadmin=true;
			   }
			   
		   }
		   return $ifadmin;
     }
	 
	 function Template($name='',$wap=''){
	      include(Core.'/class/template_class_phpapp.php');
          $template = new template($name,$wap);

	      return $template->show();
     }
 
	 
	 
	//获取 文件内容
    function GetFile($filedir){
		if ($open_file = @fopen($filedir, "rb")){		   
			$filecontent=fread($open_file,filesize($filedir));			
			fclose($open_file);
			return $filecontent;
		}else{
	        return false;
		}
    }

    function WriteFile($wfile,$cfile){

        if ($openwrite =  @fopen($wfile, "w")){
		 	 fwrite($openwrite,$cfile);
		 	 fclose($openwrite);
		 	 return true;
	    }else{
		 	 return false;
	    }
    }
	 
	 
	 
	//GET XML
	function GetXMLArray($arrObjData, $arrSkipIndices = array()){
         	$arrData = array();
            if (is_object($arrObjData)) {
                $arrObjData = get_object_vars($arrObjData);
           }
    
           if (is_array($arrObjData)) {
               foreach ($arrObjData as $index => $value) {
                   if (is_object($value) || is_array($value)) {
                       $value = $this->GetXMLArray($value, $arrSkipIndices); 
                   }
                   if (in_array($index, $arrSkipIndices)) {
                       continue;
                   }
                   $arrData[$index] = $value;
               }
           }
           return $arrData;
     }
	 
	 
	 
	 //Language--------------------------------------------------------------------------------------------------------------
	 
	 // appname | 数组名(不填写返回全组) |  cache
	 function LanguageArray($languagename='',$name='',$iscache=0){
		            
		  $cachefile=SYS.'/data/cache/language/'.$this->lang.'/'.$languagename.'_language_phpapp.php';
		  			   
		  if(!file_exists($cachefile)){
				  
				 $this->ShowLanguage($this->lang,$name,$languagename);
		  
		  }
		  
		  include($cachefile);
				 
		  if(!$name){
				return $languagearr;
		  }else{
				if(!empty($languagearr[$name])){
					
					  if($iscache){
							$content = "<?php
/*
	EDOOG.COM (C) 2006-2013 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2013.3.5
*/	
if(!defined('IN_PHPAPP')){exit('Data error');} 

?>"; 
 
							$content .="<?php return '".preg_replace('/{([A-Z]+)}/U',"'.$1.'",preg_replace('/{echo\s+(.*)}/iU',"'.$1.'",trim($languagearr[$name])))."';?>";
							
							$this->WriteFile(SYS.'/data/cache/language/'.$this->lang.'/'.$languagename.'_'.$name.'_language.php',$content);
							
							return SYS.'/data/cache/language/'.$this->lang.'/'.$languagename.'_'.$name.'_language.php';
						  
					  }else{
							return trim($languagearr[$name]);
					  }
					  
				}else{
					  return false;
				}
		  }
				
	 }
	 
     function ShowLanguage($language='cn',$name='',$appname=''){

		  $LanguagDIR=SYS.'/data/cache/language/'.$language.'/'.$appname.'_language_phpapp.php';
		  
		  $LanguagTemplates=SYS.'/templates/'.S_TEMPLATE.'/language/'.$language.'/'.$appname.'_language_phpapp.php';
		  
		  if(!file_exists($LanguagDIR)){
                   $this->UpdateWebLanguage($language,$LanguagTemplates,$appname);
	      }
		  
		  include($LanguagDIR);
		 
		  if(!empty($languagearr[$name])){
		        return $languagearr[$name];
		  }else{
			    return false;
		  }
		 
	 }
	 
	 function UpdateWebLanguage($language,$languagefile,$languagename){

		  $writefiledir=SYS.'/data/cache/language/';
		       
		  $content="<?php
/*
	EDOOG.COM (C) 2009-2013 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.1
*/	 
if(!defined('IN_PHPAPP')){exit('Data error');} 
"."\r"; 
		 
		  if(file_exists($languagefile)){
			    
				$filecontent=$this->GetFile($languagefile);

				$filecontent=trim(preg_replace('/<\?php(.*)\?>/si','',$filecontent));

				$filecontent=str_replace("'",'"',$filecontent);
				
				$filecontent=str_replace('</phpapp>',"',",$filecontent);
				
				$content.='$languagearr=array(';
				
				$content.=preg_replace('/\<phpapp language\=\"(\w+)\"\>/U',"'$1'=>'",$filecontent);
				
				$content.="\r\r".'); ?>';
				
				if(!is_dir($writefiledir)) {
				 	 @mkdir($writefiledir,0777);
				 	 $this->WriteFile($writefiledir.'index.html','');
	    		}
				
				$writefiledir=$writefiledir.$language.'/';
				
				if(!is_dir($writefiledir)) {
				 	 @mkdir($writefiledir,0777);
				 	 $this->WriteFile($writefiledir.'index.html','');
	    		}
					 
		        $this->WriteFile($writefiledir.$languagename.'_language_phpapp.php',$content);
                   
	      }else{
			  
			    return false;
		  }
	

     }
	 
	 
	 //Language-end-------------------------------------------------------------------------------------------------------------
	 
	 
	 
	 
	 function Date($dateformat, $date='',$format=0) {
        
	      $time = $this->NowTime() - $date;
	      $result = '';
	      if($format) {
		      if($time > 24*3600) {
			      $result = @date($dateformat,$date);
		      } elseif ($time > 3600) {
			      $result = intval($time/3600).'小时前';
		      } elseif ($time > 60) {
			      $result = intval($time/60).'分钟前';
		      } elseif ($time > 0) {
			      $result = $time.'秒前';
		      } else {
			      $result = '刚刚';
		      }
      	  }else{
		      $result = @date($dateformat,$date);
	      }
	      return $result;
    }
	
	//Date-Format-end-------------------------------------------------------------------------------------------------------------
	
	
	function POSTArray(){
         $postarr=array();
		 if(is_array($_POST)){
			  
			   foreach($_POST as $key=>$value){
				   
					  $keyarr=explode('_',$key);
					  
					  $count=count($keyarr);
					  	  
					  if($count>1){
						    $keyname='';
					        for($i=0;$i<$count-1;$i++){
							     if($keyname){
							          $keyname.='_'.$keyarr[$i];
								 }else{
									  $keyname=$keyarr[$i];
						 		 }
					        }
						   
						   
						    if($keyarr[$count-1]=='s'){	

							     $isajax=empty($_SERVER['HTTP_X_REQUESTED_WITH']) ? '' : $_SERVER['HTTP_X_REQUESTED_WITH'];
								
								 if($isajax=='XMLHttpRequest'){

					                    $value=$this->ConvertStr($value);
									 
								 }
							
								 $postarr[$keyname]=$this->str($value,0,1,0,0,0,1);
							}elseif($keyarr[$count-1]=='d'){
								 $postarr[$keyname]=intval($value);
							}elseif($keyarr[$count-1]=='f'){
								 $postarr[$keyname]=floatval($value);
							}else{
								 $postarr[$key]=$value;
							}		
						   
						   
					  }else{
						   $postarr[$key]=$value;
					  }
					  
					  
			   }      
		 }
		
		 return $postarr;
	}
	
	
	//Convert
	function ConvertStr($convert){
		
		    if(strtoupper(S_CHARSET)!='UTF-8'){
                  return  mb_convert_encoding($convert,S_CHARSET,"UTF-8"); //转码
	        }else{
				  return $convert;
			}
    }
	
	function ConvertStrToUTF8($convert){
		
		    if(strtoupper(S_CHARSET)!='UTF-8'){
                  return  mb_convert_encoding($convert,'UTF-8',S_CHARSET); 
	        }else{
				  return $convert;
			}
    }
	
	
	function RandomText($count,$lowercase='0'){
	
	     srand((double)microtime()*1000000);
	     $doublenum=mt_rand(10000,1000000);
         srand((double)microtime()*$doublenum); 
	 
	     if($lowercase==1){
	          $numrand=array_flip(array_merge(range(1,9),range('A','N'),range('P','Z'),range('a','n'),range('p','z')));
		 }elseif($lowercase==2){
	          $numrand=array_flip(range(1,9));
		 }else{
	          $numrand=array_flip(array_merge(range(1,9),range('A','N'),range('P','Z'))); 
	     }
		 
	     $textkey='';
         for($i=0;$i<$count;$i++){
	         $textkey .= array_rand($numrand);
	     } 
         return $textkey; 
    }
	
	//View
	function AppsView($filename=''){
		
		  if($this->IsWap()){
			    //wap
				header('Content-Type:text/vnd.wap.wml');
				echo'<?xml version="1.0" encoding="'.S_CHARSET.'"?>';
				return $this->Template($filename,'xml');
		  }else{
		        //www
		
		        return $this->Template($filename);
				
		  }
	}
	
	//Wap
	function IsWap(){
          
		  if(OPENMOBILE){
		       if(stristr($_SERVER['HTTP_ACCEPT'],'text/vnd.wap.wml')){
					 return true;
		       }else{
			         return false;
		       }
		  }else{
			   return false;
		  }
		
    }
	
	
	function MakeSecCode(){
		
	      unset($_SESSION['seccode']);

         $im = imageCreate(112,30); 
		 $Rcolor=mt_rand(0,255);

         $Gcolor=mt_rand(0,53);

         $Bcolor=mt_rand(0,255);

         for($i=0; $i<=190; $i++){
	         // R G B
	         $Gcolors=$i+$Gcolor;
	         $Bcolors=$i+$Bcolor;

	         $color = imagecolorallocate($im,$Rcolor,$Gcolors,$Bcolor);
             $bgcolor=imagefilledrectangle($im,$i-30,0 ,$i-50, 30, $color);
         }

         if(PHPAPP::$config['sitecodefuzzy']==1){
			   //高级模糊
		       $textcolorb=imagecolorallocate($im,$Rcolor,80,$Bcolor);
		       $textcolorc=imagecolorallocate($im,$Rcolor,202,255);
               $bgtxtw=4;
			 
		 }else{
			 
			   $textcolorb=imagecolorallocate($im,0,0,0);
			   $textcolorc=imagecolorallocate($im,$Rcolor,202,255);
			   $bgtxtw=3;
			 
		 }
        
		 
		 

         for($i=0;$i<mt_rand( intval(PHPAPP::$config['sitecodeaddtext1']),intval(PHPAPP::$config['sitecodeaddtext2']));$i++){
              imagedashedline($im, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100), mt_rand(0,100), $textcolorb);
         }

         $font=PHPAPP::$config['seccodefont'];

         $text=$this->RandomText('4');

         $_SESSION['seccode']=md5($text);

         $textcolorf=imagecolorallocate($im,240,200,180);

         for($i=0;$i<4;$i++){
             $textarr[]=substr($text,$i,1);
         }
         $txtw=0;
         foreach($textarr as $key=>$text){
	         $txtw=$txtw+19+$key;
	         $txtnum=mt_rand(-20,20);
			 $txtbig=mt_rand(10,20);
             imageTTFText($im,$txtbig,$txtnum,$txtw-$bgtxtw,25,$textcolorc,$font,$text); 
             imageTTFText($im,$txtbig,$txtnum,$txtw-4,24,$textcolorb,$font,$text);  
         }

         //for($i=0;$i<mt_rand(1,2);$i++){
            // $this->ImageCircle($im,mt_rand(22,60),mt_rand(22,60),mt_rand(18,50),$bgcolor); 
         //}
         
		 if(PHPAPP::$config['sitecodetype']==1){
              header('Content-Type: image/png');
		 }else{
			  header('Content-Type: image/gif');
		 }

         imagepng($im);   
 
         imagedestroy($im);  
	}
	
	
	function str($string,$length,$in_escape='0',$out_escape='0',$html='0',$UBB='0',$filter='0') {
            
			$string = preg_replace('/(.*?)lt\;script(.*?)lt\;\/scriptgt\;(.*?)/si',"$1$3",$string);
			
			$string=trim($string); 
			
			if($out_escape){
				 $string =htmlspecialchars_decode($string);
				 $string=str_replace(array('\r\n','\n','\r'), "</br>",$string);
				 
				 //media
				 require_once(Core.'/class/getswfurl_class_phpapp.php');
				 $getswf = new GetSWFURL($string);
				 $string = $getswf->GetSWFURLList();
				 $string = stripslashes($string);
			}
			 
			if($html){
				$string=strip_tags($string);	//去html
			}
			 
			if($in_escape){
				 
				 
			     $string = str_replace(array('target="_blank"','target=\'_blank\''),'',$string);
			
			     $string = preg_replace("/<a (.*)>/sUi", "<a $1 target=\"_blank\">", $string);

				 
				 $string = str_replace(array('\\'),'',$string);
				 
				 $string=htmlspecialchars($this->filterchars(strip_tags($string,S_HTML_ALLOW)),ENT_QUOTES);
				 
				 if(get_magic_quotes_gpc()){
					    $string = stripslashes($string);
				 }

				 $string=mysql_real_escape_string(addslashes($string));	
				 
			}
		    

			
			if($filter){
				  $filterarr=explode("\n",PHPAPP::$config['textfilter']);
				  if($filterarr){
						foreach($filterarr as $value){
							if($value){
								  $filtetext=explode('=',$value);
								  if(!empty($filtetext[1])){
									  $string=str_ireplace($filtetext[0],$filtetext[1],$string);
								  }else{
									  $string=str_ireplace($filtetext[0],'**',$string);
								  }
							}
						}
				  }
			}
		
		
			if($length && iconv_strlen($string,S_CHARSET) > $length) {	
				$string=iconv_substr($string,0,$length,S_CHARSET);	
			}

			return trim($string);
			
    }

    //过滤非法代码
    function filterchars($string) {

        $pregstr = 'STRONG|U|em|ul|li';
        $string = preg_replace("/<($pregstr) (.*)>/sUi", '<\\1>', $string);
		$string = preg_replace("/(class\=\"(.*)\"|class\=\'(.*)\')/sUi",'', $string);
		$string = preg_replace("/(id\=\"(.*)\"|id\=\'(.*)\')/sUi",'', $string);
		$string = preg_replace('/javascript/sUi','', $string);

        $javascriptstr = 'Click|DblClick|MouseDown|MouseUp|MouseOver|MouseMove|MouseOut|KeyPress|KeyDown|KeyUp|Abort|BeforeUnload|Error |Load|Move|Resize|Scroll|Stop|Unload|Blur|Change|Focus|Reset|Submit|Bounce|Finish|Start|BeforeCopy|BeforeCut|BeforeEditFocus|BeforePaste|BeforeUpdate|CtextMenu|Copy|Cut|Drag|DragDrop|DragEnd|DragEnter|DragLeave|DragOver|DragStart|Drop|LoseCapture|Paste|Select|SelectStart|AfterUpdate|CellChange|DataAvailable|DatasetChanged|DatasetComplete|ErrorUpdate|RowEnter|RowExit|RowsDelete|RowsInserted|AfterPrint|BeforePrint|FilterChange|Help|PropertyChange|ReadyStateChange';
        $string = preg_replace("/on($javascriptstr)/sUi", 'title', $string);
		return $string;
	} 

    function PasswordKey($username,$password,$powercode){
          return md5(md5(md5($password).$powercode).$username);
    }
	
	function GetClientIp(){
        global $_SERVER;
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$realip = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			$realip = $_SERVER['REMOTE_ADDR'];
		} 
		return preg_match('/^[\\d]+\\.[\\d]+\\.[\\d]+\\.[\\d]+$/',$realip)?$realip:'0.0.0.0'; 
    }
    

    function Refresh($msg,$url,$istime=0){
		
		if(empty($msg)){
	        $msg='对不起!您访问的页面不存在!';
        }
		
		if($this->IsWap()){
		     $url=str_replace('index.php','wap.php',$url);
			 
			 if($url==SURL){
				  $url.='/wap.php';
			 }
		}
		
		include $this->AppsView('phpapp:refresh');
	    exit();       
		
	}
	
	function AjaxRefresh($url,$outescape=0){
	     $refresh='<script type="text\/javascript">var rtime=window.setInterval("ShowRefreshTime()",1000); var gotourltime=3; function ShowRefreshTime(){gotourltime=gotourltime -1;document.getElementById("gotourltime").innerHTML=gotourltime;if(!gotourltime){window.clearInterval(rtime);window.location.href="'.$url.'";}} function NowRefresh(){window.clearInterval(rtime);window.location.href="'.$url.'";}<\/script> <span id="gotourltime" style="color:#F60;font-weight: bold;">3<\/span> 秒后跳转<p style="text-align:center;margin-top:20px;"><input type="button" value="立即跳转" class="form_button" onclick="NowRefresh()"/></p>';
		 
		 if($outescape){
			  return stripslashes($refresh);
		 }else{
			  return $refresh;
		 }
		
	}
	
	function AdminAjaxRefresh($menu,$ac,$op,$id,$outescape=0,$value='',$isnowrefresh=0,$gotourltime=3){
		
		 if(!$isnowrefresh){
			   $nowrefresh='<p style="text-align:center;margin-top:20px;"><input type="button" value="立即跳转" class="form_button" onclick="NowRefresh()"/></p>';
		 }else{
			   $nowrefresh='';
		 }
		 
	     $refresh='<script type="text\/javascript">var rtime=window.setInterval("ShowRefreshTime()",1000); var gotourltime='.$gotourltime.'; function ShowRefreshTime(){gotourltime=gotourltime -1;document.getElementById("gotourltime").innerHTML=gotourltime;if(!gotourltime){window.clearInterval(rtime);$.AdminAjax("'.$menu.'","'.$ac.'","'.$op.'","'.$id.'","'.$value.'");}}function NowRefresh(){window.clearInterval(rtime);$.AdminAjax("'.$menu.'","'.$ac.'","'.$op.'","'.$id.'","'.$value.'");}<\/script> <span id="gotourltime" style="color:#F60;font-weight: bold;">'.$gotourltime.'<\/span> 秒后跳转'.$nowrefresh;
		 
		 if($outescape){
			  return stripslashes($refresh);
		 }else{
			  return $refresh;
		 }
		
	}
	
	function CloseNowWindows($id,$location=0){
		 
		 if($location){
			   $url='window.location.reload();';
		 }else{
			   $url='';
		 }
		
	     $refresh='<script type="text\/javascript">var rtime=window.setInterval("ShowRefreshTime()",1000); var gotourltime=3; function ShowRefreshTime(){gotourltime=gotourltime -1;document.getElementById("gotourltime").innerHTML=gotourltime;if(!gotourltime){window.clearInterval(rtime);$("'.$id.'").dialog("close");'.$url.'}} function NowRefresh(){window.clearInterval(rtime);$("'.$id.'").dialog("close");'.$url.'}<\/script> <span id="gotourltime" style="color:#F60;font-weight: bold;">3<\/span> 秒后关闭窗口<p style="text-align:center;margin-top:20px;"><input type="button" value="立即跳转" class="form_button" onclick="NowRefresh()"/></p>';
		 
		return stripslashes($refresh);
		
	}
	
		
	function SetCookieCode($uid=0,$cookiecode=0,$username=0){
		   return iconv_substr(md5($uid.$cookiecode.$username.$uid),0,16,S_CHARSET);
	}
	
	//loading
	function SetDialog($title,$content){
		 return  $refresh='<script type="text/javascript">$(function(){$("#loading").html(\''.$content.'\');$("#loading").dialog({ title: \''.$title.'\' });$("#loading").dialog("open");});</script>';
    }
    
	
	public function GetDialog(){
		
          if(!empty($this->Dialog)){
			    return $this->Dialog;
		  }
		 
	}
	
	
	//预处理
	public function GetArray($newget=array()){
	     $getarr=array();
		 if(is_array($_GET)){
			  
			   foreach($_GET as $key=>$value){
				   
				     $getarr[$key]=intval($value);
					 
			   }
		 }
		 
		 if($newget){
			  foreach($newget as $value){
				   if(empty($getarr[$value])){
			            $getarr[$value]=0;
		           }
			  }
		 }
		 
		 return $getarr;
	}

     //字符串分割判断
     function explodestr($intif,$str){
	 	  $strarray=explode(',',$str);
    	   $strok='';
	 	  foreach($strarray as $value){				 
		 	  if(intval($intif)==intval($value)){
				   $strok=true;
			   }
		   }
		   return $strok;
     }
	
	//字符串分割重组 ID集,排除ID
    function ExplodeStrArr($str,$delid=0){
	      $strarray=explode(',',$str);
          $strok='';
	      if(is_array($strarray)){
	           foreach($strarray as $value){				 
		           $isid=intval($value);
			       if($isid>0 && $isid!=$delid){
				       if(empty($strok)){
			                $strok.=$isid;
				       }else{
					        $strok.=','.$isid;
				       }
				  
		           }
	           }
		  
	      }else{
		      $strok=0;
	      }
	 
	      if(empty($strok)){
		       $strok=0;
	      }
	 
	      return $strok;
     }
	 
	 //Get Contents
	 function  FileGetContents($contents=''){
		  $timeout = stream_context_create(array('http' => array('timeout' =>10)));  
		  return @file_get_contents($contents,0,$timeout);
	 }
	 
	 // 表名 , catid ID , DIV ID , 应用ID
	 function SetSelectCategory($table,$id=0,$select_name='',$appid='',$myfunction=''){
			  
               if($appid){
				    $where='AND type='.$appid;
			   }else{
				    $where='';
			   }
				
		       $this->SetSelect.=$this->GetSelectCategory($table,$id,$select_name,$appid,$myfunction);
	
								
								
				if($this->IsSQL($table," WHERE upid='$id'")){

				  
				  	    $categoryarr=$this->GetMysqlArray('*'," ".$this->GetTable($table)." WHERE  upid='$id' ".$where." ORDER BY displayorder ASC");
					
	
	
						$this->SetSelect.='<select id="'.$select_name.'_Selects_'.$id.'" onchange="GetSelect(\''.$table.'\',\'_Selects_'.$id.'\',\''.$select_name.'\',\''.$appid.'\',\''.$myfunction.'\')" class="form_select_text">'; 
				
						
						$this->SetSelect.='<option value="">请选择</option>';
				
					
						foreach($categoryarr as $value){

							   $this->SetSelect.='<option value="'.$value['catid'].'">'.$value['name'].'</option>';
							
						}
					
					
					      $this->SetSelect.='</select> ';
			        
  
			   }
			   
			   $setselect=$this->SetSelect;
			   
			   unset($this->SetSelect);
			  
			   return  $setselect;
	 }
	 
	 
	 
	 
	 
	 function GetSelectCategory($table,$id=0,$select_name='',$appid='',$myfunction='',$select=0){
		               
			  if($select){
				    $this->GetCategoryDeleteBox($table,$id,$select_name,$appid,$myfunction);
			  }else{
			        $this->GetCategoryDate($table,$id,$select_name,$appid,$myfunction);
			  }
		 
			  if(!empty($this->GetSelect)){	   
					   ksort($this->GetSelect);
					   
					   $selects='';
					   
					   foreach($this->GetSelect as $value){
						       $selects.=$value;
					   }
					   
					   unset($this->GetSelect);
						
					   return $selects;
				   
			  }
			
		 
	 }
	 
	 
	 function  GetCategoryDeleteBox($table,$id=0,$select_name='',$appid='',$myfunction='',$isname=0){
		
		       if($appid){
				    $where='AND type='.$appid;
			   }else{
				    $where='';
			   }
		
		        $categoryone=$this->GetMysqlOne('*'," ".$this->GetTable($table)." WHERE  catid='$id' ".$where." ORDER BY displayorder ASC");
				
				if($categoryone){
					    
					    $categoryarr=$this->GetMysqlArray('*'," ".$this->GetTable($table)." WHERE  upid='$categoryone[upid]' ".$where." ORDER BY displayorder ASC");


						foreach($categoryarr as $key=>$value){
							
							   if($id==$value['catid']){
								      if($isname!=0){
										   $more=' > ';
									  }
								      @$this->GetSelect[$id].=$value['name'].$more;
							   }

						}
			
					   
					   if($categoryone['upid']>0){

						      $this->GetCategoryDeleteBox($table,$categoryone['upid'],$select_name,$appid,$myfunction,1);
							  
					   }
				
			   
			   }
				  
		
		
	}
	 
	 
	function  GetCategoryDate($table,$id=0,$select_name='',$appid='',$myfunction='',$isname=0){

		       if($appid){
				    $where='AND type='.$appid;
			   }else{
				    $where='';
			   }

		        $categoryone=$this->GetMysqlOne('*'," ".$this->GetTable($table)." WHERE  catid='$id' ".$where." ORDER BY displayorder ASC");
				
				if($id>0){
					if(empty($categoryone['catid'])){
						  $categoryone=$this->GetMysqlOne('*'," ".$this->GetTable($table)." WHERE  upid=0 ".$where." ORDER BY displayorder ASC");
					}
				}
				
				if($categoryone){
					    
					    $categoryarr=$this->GetMysqlArray('*'," ".$this->GetTable($table)." WHERE  upid='$categoryone[upid]' ".$where." ORDER BY displayorder ASC");

						if(!$isname){
	
						      @$this->GetSelect[$id].='<select name="'.$select_name.'" id="'.$select_name.'_Select_'.$id.'" onchange="GetSelect(\''.$table.'\',\'_Select_'.$id.'\',\''.$select_name.'\',\''.$appid.'\',\''.$myfunction.'\')" class="form_select_text">';
						
						}else{
							
							  @$this->GetSelect[$id].='<select id="'.$select_name.'_Select_'.$id.'"  onchange="GetSelect(\''.$table.'\',\'_Select_'.$id.'\',\''.$select_name.'\',\''.$appid.'\',\''.$myfunction.'\')" class="form_select_text">';
							
						}
				
					
						foreach($categoryarr as $value){
							
							   if($id==$value['catid']){
								      $selected=' selected="selected"';
							   }else{
								      $selected='';
							   } 
							
							   @$this->GetSelect[$id].='<option value="'.$value['catid'].'"'.$selected.'>'.$value['name'].'</option>';
							
						}
					
					   @$this->GetSelect[$id].='</select> ';
					   
					   
					   if($categoryone['upid']>0){

						      $this->GetCategoryDate($table,$categoryone['upid'],$select_name,$appid,$myfunction,1);
							  
						    
					   }
				
			   
			   }
				  
		
		
	}
	 
	 
	 
	function SetTimezone($timezone = 8){
		  if(function_exists('date_default_timezone_set')){
				   @date_default_timezone_set('Etc/GMT'.($timezone > 0 ? '-' : '+').(abs($timezone)));
		  }
	}
	
	
	function GetTimezone(){
		   
		   return $this->SetTimezone(PHPAPP::$config['timezone']);
	}
	
	
	function GetClient($username='',$password='',$email=''){
				 
		 if(!empty(PHPAPP::$config['uc_open'])){
		 
		      if(PHPAPP::$config['uc_apitype']==1){
			   
			          include_once(APPS.'/ucclient/class/pw_client_class_phpapp.php');
					  
			  }elseif(PHPAPP::$config['uc_apitype']==2){
				  
				      include_once(APPS.'/ucclient/class/pw9_client_class_phpapp.php');
			 
		      }else{
					  include_once(APPS.'/ucclient/class/dz_client_class_phpapp.php');
						
			  }
	
              return new UserClientAPI($username,$password,$email);
			 
		 }else{
			  return  0;
		 }
		 
	}
	
	
	
	function GetOrderNumber($substr=4){	
		   $timearr=@gettimeofday();
		   return @date('YmdHis',$timearr['sec']).intval(substr($timearr['usec'],0,$substr));
	}
	
	
	function SetConsume($post){	
	
	        include_once(APPS.'/apppay/class/consume_class_phpapp.php');										   
			$set=new UserConsume();
			return $set->MakeConsume($post);
	}
	
	
	function GetTypeMember($usertype=''){	

		     include_once(APPS.'/member/class/member_phpapp.php');
		  
			 $mf=new MemberFunction();
			
			 $taskmember=$mf->GetTypeNameMember($usertype);
			 
			 return $taskmember['table_phpapp'];
	}
	
	//是否实名认证
	function IsRealName(){	
	    	

	        $uid=$this->uid;
		
			
	        if($uid>0){
				
				  
				  if($this->IsSQL('member_info',"WHERE uid='$uid' AND realname='0'")){
					  
					    return true;
							   
				  }else{
					    return false;
				  }
				
			}else{
				
				  return false;
				
			}
	}
	
    
	//获取登录者信息
	
	function GetLoginInfo($userid=0,$ismember=0){	
	
	        if($userid>0){
				 $uid=$userid;
			}else{
	             $uid=$this->uid;
			}
			
	        if($uid>0){
				
				 $member=$this->GetMysqlOne('a.username,a.usertype,a.userpost,a.usergroup,a.safeemail,a.unionid,a.uniontime,a.skills,b.money,b.credit'," (".$this->GetTable('member')." AS a  LEFT JOIN  ".$this->GetTable('member_account')." AS b ON a.uid=b.uid ) WHERE a.uid='$uid'");
				 
				 if($member){
					   
					   if($ismember){
						     
							 return $member;
						     
					   }else{
						   
						   	 $membertable=$this->GetTypeMember($member['usertype']);
							 
							 $info=$this->GetMysqlOne('*',"   ".$this->GetTable('member_info')." AS a  LEFT JOIN ".$this->GetTable($membertable)." AS c ON a.uid=c.uid WHERE a.uid='$uid'");
							 
							 return array_merge($member,$info);

					   }
				 
				 }else{
				
				       return false;
				
			     } 
				
		    }else{
				
				  return false;
				
			}
	
	}
	
	
	// 表名,权限
	
	function CheckAllow($table,$post,$app=0){
		  
		  if($app>0){
			  $this->app=$app;
		  }
		  
		  $appclass='';
		  
		  foreach($this->GetApps() as $appsarray){

	           if($appsarray['id_phpapp']==$this->app){
	                  $appclass=$appsarray;
			   }
			
		  }
		  
		 $member=$this->GetLoginInfo();
		 
		 $group=$this->GetMysqlOne('*'," ".$this->GetTable($table)." WHERE gid='$member[usergroup]'");
		 
				
		 if($appclass){
			   include_once(APPS.'/'.$appclass['dir_phpapp'].'/class/allow_class_phpapp.php');										   
			   $check=new Allow($group);
			   return $check->UserAllow($post);
		 }else{
			   return false;
		 }
			
	}
	
	function GetAllow($table,$keyarr){
		
		  $appclass='';
		  
		  foreach($this->GetApps() as $appsarray){

	           if($appsarray['id_phpapp']==$this->app){
	                  $appclass=$appsarray;
			   }
			
		  }
		  
		 $member=$this->GetLoginInfo();
		 
		 $group=$this->GetMysqlOne('*'," ".$this->GetTable($table)." WHERE gid='$member[usergroup]'");
		 
		 if($appclass){
			 
			   $grouparray=array();
			   
			   foreach($keyarr as $value){

					$grouparray[$value]=$group[$value];
					 
			   }
			   
			   return $grouparray;
		 }
	}
	
	//端口 , 消息类型ID
	function Port($post=array(),$allow=array()){
	      include_once(Core.'/class/port_class_phpapp.php');
		  $sysport=new Port($post,$allow);
		  $sysport->SetPort();
	}
	
    //站内短信
	function SiteSmsPort($post=array(),$allow=array()){
	      	     
		 include_once(APPS.'/sms/class/port_class_phpapp.php');
		 $sms=new SMSPort();
		 $sms->SendSMS($post);
		 
	}
	
	function GetUserAvatar($uid=0,$type=0,$ishire=0){
		
		  
		  if(!$uid){
		       $uid=$this->uid;
		  }
		
		  if($uclient=$this->GetClient()){
			    $avatar=str_replace('"',"'",$uclient->getavatar($uid,$type));
		  }else{

			   $member=$this->GetMysqlOne('avatar'," ".$this->GetTable('member_info')." WHERE uid='$uid'");
			  
			   if(!$member['avatar']){
			   
					   if($type==2){
							$avatar='<img src=\''.TURL.'images/member/no_avatar_big.gif\'/>';
					   }elseif($type==1){
							$avatar='<img src=\''.TURL.'images/member/no_avatar_middle.gif\'/>';
					   }else{
							$avatar='<img src=\''.TURL.'images/member/no_avatar_small.gif\'/>';
					   }
					   
			   }else{
				     
					   if($type==2){
							$avatar='<img src=\''.SURL.'/attachment/avatar/big/'.$member['avatar'].'\'/>';
					   }elseif($type==1){
							$avatar='<img src=\''.SURL.'/attachment/avatar/middle/'.$member['avatar'].'\'/>';
					   }else{
							$avatar='<img src=\''.SURL.'/attachment/avatar/small/'.$member['avatar'].'\'/>';
					   }
				   
			   }
 
		  }
		  
		  if($ishire){
				 return '<div class=\'UserPhotoFilter AjaxUserID'.$uid.'\' title=\'\' onmouseover=\'$.GetUserMoreInfo('.$uid.',2)\'><a href=\''.SURL.'/space.php?app=8&uid='.$uid.'\' target=\'_blank\'>'.$avatar.'</a></div>';
		  }else{
				 return '<div class=\'UserPhotoFilter AjaxUserID'.$uid.'\' title=\'\' onmouseover=\'$.GetUserMoreInfo('.$uid.',1)\'><a href=\''.SURL.'/space.php?app=8&uid='.$uid.'\' target=\'_blank\'>'.$avatar.'</a><div class=\'user_photo_url\' title=\'雇用我\'><a href=\''.SURL.'/index.php?app=82&action=2&&uid='.$uid.'\'>雇用我</a></div></div>';
		  }
		
	}
	
	function GetUserLevel($credit=0){

		  if(!file_exists(SYS.'/data/cache/config/userlevel.php')){
                 $this->UpdateUserLevel();
	      }
		  
		  include(SYS.'/data/cache/config/userlevel.php');
		  
		  $title=$style='';
		  foreach($userlevel as $value){
			  
			    if($credit<=$value['big'] &&  $credit>=$value['small']){
					  $title='<span style="color:'.$value['color'].'">'.$value['title'].'</span>';
					  $style=$value['style'];
				}
		  }
		  
		  
		  return array('title'=>$title,'style'=>$style);
		
	}
	
	
	function UpdateUserLevel(){

		  $confiarr=$this->GetMysqlArray('*',$this->GetTable('member_level'));
		  $config="<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	 if(!defined('IN_PHPAPP')){exit('Data error');}"; 
		 
		  $config.='$userlevel=array(';
		 
		  $arrayvalue='';
		  foreach($confiarr as $value){
			   if($arrayvalue){
	                 $arrayvalue.=',array(\'title\'=>\''.$value['title'].'\',\'big\'=>\''.$value['big'].'\',\'small\'=>\''.$value['small'].'\',\'style\'=>\''.$value['style'].'\',\'color\'=>\''.$value['color'].'\')';
			   }else{
				     $arrayvalue.='array(\'title\'=>\''.$value['title'].'\',\'big\'=>\''.$value['big'].'\',\'small\'=>\''.$value['small'].'\',\'style\'=>\''.$value['style'].'\',\'color\'=>\''.$value['color'].'\')';
			   }
          }
		 
		  $config.=$arrayvalue.');?>';
	
	
		  $this->WriteFile(SYS.'/data/cache/config/userlevel.php',$config);
     }
	 
	 
	 function GetCreditLevel($credit=0,$type=0){
		
		  if(!file_exists(SYS.'/data/cache/config/creditlevel.php')){
                 $this->UpdateCreditLevel();
	      }
		  
		  include(SYS.'/data/cache/config/creditlevel.php');
		  
		  
		  foreach($creditlevel as $value){
			  
			    if($credit<=$value['big'] &&  $credit>=$value['small'] && $value['type']==$type){
					
					  return $value['style'];
				}
		  }
		  
		
	}
	
	
	function UpdateCreditLevel(){

		  $confiarr=$this->GetMysqlArray('*',$this->GetTable('credit_level'));
		  $config="<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	 if(!defined('IN_PHPAPP')){exit('Data error');}"; 
		 
		  $config.='$creditlevel=array(';
		 
		  $arrayvalue='';
		  foreach($confiarr as $value){
			   if($arrayvalue){
	                 $arrayvalue.=',array(\'small\'=>\''.$value['small'].'\',\'style\'=>\''.$value['style'].'\',\'big\'=>\''.$value['big'].'\',\'type\'=>\''.$value['type'].'\')';
			   }else{
				     $arrayvalue.='array(\'small\'=>\''.$value['small'].'\',\'style\'=>\''.$value['style'].'\',\'big\'=>\''.$value['big'].'\',\'type\'=>\''.$value['type'].'\')';
			   }
          }
		 
		  $config.=$arrayvalue.');?>';
		 
		  $this->WriteFile(SYS.'/data/cache/config/creditlevel.php',$config);
     }
	 
	function  GetCertificateIcon($icon=''){
		  
		  $title=array('VIP'=>array(26,'VIP'),'Mobile'=>array(21,'手机'),'Mail'=>array(14,'邮箱'),'Personal'=>array(15,'个人实名'),'Company'=>array(16,'公司实名'),'Bao'=>array(44,'诚信保证'),'Yuan'=>array(44,'保证原创'),'Mian'=>array(44,'免费修改'),'San'=>array(44,'三个月维护'),'Shang'=>array(44,'上门维护服务'));
		  
		  $iconarr=explode(',',$icon);
		  $icon='';
		  foreach($iconarr as $value){
			  
			    if($value){
					
					 if($title){
					      $icontitle=$title[$value][1];
					 }else{
						  $icontitle='';
					 }
	
			         $icon.="<a href='".SURL."/member.php?app=".intval($title[$value][0])."' target='_blank'><span class='".$value."Icon' title='".$icontitle."认证'></span></a>";
				
				}
		  }
		  
		  return  $icon;
		
	}
	 
	
	function GetMyFriend($uid){
		
		   $friend=$this->GetMysqlArray('fuid'," ".$this->GetTable('member_myfriend')." WHERE uid='$uid'");
		   $friendid='';
		   if($friend){
			     foreach($friend as $value){
					   if($friendid){
						    $friendid.=','.$value['fuid'];
					   }else{
						    $friendid=$value['fuid'];
					   }
				 }
		   }
		   
		   return $friendid;
	}
	
	function UpdateCredit($uid=0,$type=1,$credit=0,$credittype=0){
		   
		   $allcreditarray=array('hao'=>0,'zhong'=>0,'cha'=>0);
		   if($credittype==2){
			     $allcreditarray['cha']=1;
		   }elseif($credittype==1){
			     $allcreditarray['zhong']=1;
		   }else{
			     $allcreditarray['hao']=1;
		   }
		   
		   if($this->IsSQL('credit'," WHERE uid='$uid' AND type='$type'")){
			       
				   
				   $creditarr=$this->GetMysqlOne('*'," ".$this->GetTable('credit')." WHERE uid='$uid' AND type='$type'");
				   
				   $credit=$creditarr['credit']+$credit;
				   
				   $allcreditarray['cha']+=$creditarr['cha'];
				   
				   $allcreditarray['zhong']+=$creditarr['zhong'];
				   
				   $allcreditarray['hao']+=$creditarr['hao'];
				    
			       $this->Update('credit',array('credit'=>$credit),$allcreditarray,"WHERE uid='$uid' AND type='$type'");
			   
			   
		   }else{
			   
			       $this->Insert('credit',array('uid'=>$uid,'type'=>$type,'credit'=>$credit),$allcreditarray);
			   
		   }
		   
		  
		
	}
	
	
	
	// SendMail
	function SendMail($RcptTo='',$Subject='',$MailBody='',$MailFrom=''){
	      include_once(Core.'/class/sendmail_class_phpapp.php');
		  $mail=new SendMail($RcptTo,$Subject,$MailBody,$MailFrom);
		  $mail->PHPAPPSendMail();
	}
	
	
	function SetCertificateIcon($certificates,$cssname='',$delete=0){
		
		
		    $certificatearr=explode(',',$certificates);
			$iscertificate=0;
			foreach($certificatearr as $value){
				
				  if($value==$cssname){
					    $iscertificate=1;
				  }
				  
			}
			
			if(!$iscertificate){
				  if(!$delete){
						if($certificates){
							 $certificates.=','.$cssname;
						}else{
							 $certificates=$cssname;
						}
				  }
			}else{
				
				  if($delete){
					  
					    $certificates='';
						
						foreach($certificatearr as $value){
				
							  if($value!=$cssname){
									 
									if($certificates){
										 $certificates.=','.$value;
									}else{
										 $certificates=$value;
									}
									 
									 
							  }
							  
						}
					  
					  
				  }
				
			}
			
			return $certificates;
			
	}

	
	function FeedReplace($title='',$template=''){
		    
			return $this->str(str_replace('{title}',$title,$template),999,0,1,0,0,1);
	
	}
	
	
	function UpdateCategoryCount($table,$catid=0,$total=0,$where=''){
		    
			 //更新上级
			 $categoryone=$this->GetMysqlOne('*'," ".$this->GetTable('category')." WHERE  catid='$catid' ");
		
				
			 if($categoryone){
					
						if(!$total){
							  $tasknum=$this->IsSQL($table,"WHERE catid='$catid' $where ");
						}else{
							  $tasknum=$total;
						}	
		
						
						$this->Update('category',array('total'=>$tasknum),array(),"WHERE catid='$catid'");
						
			            
						$upid=$categoryone['upid'];
						
						
					    $categoryarr=$this->GetMysqlOne('*'," ".$this->GetTable('category')." WHERE  catid='$upid' ");
						
						
						if($categoryarr){
							    
								$up=$this->GetMysqlOne(' sum(total) AS totals '," ".$this->GetTable('category')." WHERE  upid='$upid' ");
								
								$this->UpdateCategoryCount($table,$upid,$up['totals']);
							 
						}
						
			
			}
			 
	}
	
		
	function GetFileForm($filename){
		 $formarr=explode('.',$filename);
		 $num=count($formarr);
		 return strtolower($formarr[$num-1]);	
	}
	
	//删除文件
	function DelFile($filepath){
		@unlink($filepath);
	}
	
	function UploadFile(){
		   include_once(Core.'/class/upload_file_phpapp.php');										   
		   $upload=new Upload(array('uid'=>$this->uid));
		   return $upload->UploadFile();
	}
	
	
	function ShowFileIcon($filename=''){
		
		     $form=$this->GetFileForm($filename);
		
	         $icon=PHPAPP::$fileicon[$form];
		
			 if($icon){
				   return $icon;
			 }else{
				   return 'images/fileicon/default.png';
			 }
			
	}
	
	function ConvertArray($convert){
		
		  $convertarr='';
		  
          $convertarr=mb_convert_encoding(serialize($convert),strtoupper(S_CHARSET), "UTF-8");

		  if(strtoupper(S_CHARSET)!='UTF-8'){
			  
			   $convertarr = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'",$convertarr);

		       return unserialize($convertarr);
			   
		  }else{
			   return $convert;
		  }
		
	}


    function FileGetContentPOST($url='',$data=array()){
		
		  $data = http_build_query($data); 
		  
		  $http = array('http'=>array( 
				  'method'=>'POST', 
				  'header'=>"Content-type: application/x-www-form-urlencoded\r\n". "Content-length:".strlen($data)."\r\n", 
				  'content' =>$data,
				  'timeout' =>10
		  )); 
	  
		  $context = stream_context_create($http); 
		  return @file_get_contents($url,false,$context); 
	
    }
	
    function HideDecode($content='',$type=0){
		
		 if(!$type){
		      return preg_replace('/\[hide\](.*)\[\/hide\]/sU','$1',$content);
		 }else{
			 
			  return preg_replace('/\[hide\](.*)\[\/hide\]/sU','***此内容已隐藏登录后可见!***',$content);
			  
		 }
		
	}
	
	//是否客服
	function IsService($sid){
		
		 if($this->uid>0){
			   if($this->uid==$sid){
					return true;
			   }else{
					return false;
			   }
		 }else{
			  return false;
		 }
		  
	}
	
	function SecurityForm(){
		 if($_SESSION['SecurityForm']){
			   return $_SESSION['SecurityForm'];
		 }else{
              unset($_SESSION['SecurityForm']);
		      return  $_SESSION['SecurityForm']=$this->RandomText(16,1);
		 }
	}
	
	function CheckSecurityForm($securityCode=''){
		  
		  
		  $SecurityForm=empty($_SESSION['SecurityForm']) ? '' : $_SESSION['SecurityForm'];
		  
		  if($securityCode==$SecurityForm){
		        return true;
		  }else{
				return false;
		  }
		  
	}
	
	function SystemRunTime(){
		 if(S_START_TIME){
			   $runtime=microtime(true) - S_START_TIME;
			   return 'Total '.number_format($runtime,7).'(s)';
		 }
	}
	
	
	function GetUserTaskSet($tablename='',$uid=0){

			if($tablename && $uid){
				
				  $setsql=$this->GetMysqlOne('*'," ".$this->GetTable($tablename)." WHERE uid='$uid' ");  
					
				  if($setsql){	
				  
				       return unserialize($setsql['set']);
				  }else{
					   return false;
				  }
				  
			}else{
				  return false;
			}
	}
	
	function LevelRate($hao=0,$zhong=0,$cha=0){	
          
		  $totals=$hao+$zhong+$cha;
 
		  return 100-((round($totals/100,2)-round(($hao+$zhong)/100,2))*100);

    }
	
	
	function CreditScore($seller=0,$oid=0,$score){
		
		  if($this->uid>0 && $seller>0  && $oid>0){
			     
				 $speed=intval($score['speed']);
				 
				 $attitude=intval($score['attitude']);
				 
				 $quality=intval($score['quality']);
				 
				 $this->Insert('member_score',array('buyer'=>$this->uid,'seller'=>$seller,'appid'=>$this->app,'oid'=>$oid,'speed'=>$speed,'attitude'=>$attitude,'quality'=>$quality),array());
				 
				 
				 $sellerscore=$this->GetMysqlOne('*'," ".$this->GetTable('credit_score')." WHERE uid='$seller' ");  
				 
				 if(intval($sellerscore['uid']) >0){
					 
					 
					 		 
					   if($speed>0){
						   
						     $newspeed=floor(((floatval($sellerscore['speed'])+$speed)/2) *10)/10;

							 $this->Update('credit_score',array('speed'=>$newspeed),array(),"WHERE uid='$seller'");
							 
					   }
					   
					   if($attitude>0){
						   
						     $newattitude=floor(((floatval($sellerscore['attitude'])+$attitude)/2) *10)/10;
						     
							 $this->Update('credit_score',array('attitude'=>$newattitude),array(),"WHERE uid='$seller'");
							 
					   }
					   
					   
					    if($quality>0){
						   
						     $newquality=floor(((floatval($sellerscore['quality'])+ $quality)/2) *10)/10;

							 $this->Update('credit_score',array('quality'=>$newquality),array(),"WHERE uid='$seller'");
							 
					   }

					 
				 }else{
					   
					   $this->Insert('credit_score',array('uid'=>$seller,'speed'=>$speed,'attitude'=>$attitude,'quality'=>$quality),array());
					   
				 }
				 
				
		  }
		
	}
	
	function SiteClose(){
		
		  if(PHPAPP::$config['siteclose']==1){
	
	              $this->Refresh($this->str(PHPAPP::$config['closedreason'],999999,0,1,0,1),'/',1);

          }
	}
	
	
	public function SetConfig($post=array()){
	
	       $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','action'));
	  
		   if($post){
			    
				$definearray=array();
				 
		        foreach($post as $key=>$value){
					
					  if($key=='S_CACHE_MEMORY_OPEN' ||  $key=='S_CACHE_TIME' || $key=='S_REWRITE_URL' || $key=='S_TEMPLATE' || $key=='S_SITE_LOG' || $key=='S_SITE_LOG_SIZE'){
					       $definearray[$key]=$value;
					  }
					  
					  
					  $value=str_replace("'",'',$value);
					  
		              $this->Update('config',array('value_phpapp'=>$value),array()," WHERE name_phpapp='$key'");
				}
				
				$this->SetConfigINI($definearray);
				
				
		   }
		   
		   $this->UpdateConfig();
							 
		   echo $this->Refresh($this->LanguageArray('phpapp','Set_successfully'),$this->MakeGetParameterURL());
		   
	}
	
	public function SetConfigINI($definearray){

		   if(!empty($definearray)){
			
				   $config=file_get_contents(SYS.'/config.php');
				   
				   foreach($definearray as $key=>$value){
						 $config=preg_replace("/define\(\'$key\'\,(.*)\)\;/U",'define(\''.$key.'\',\''.$value.'\');',$config);
				   } 
				   
				   $this->WriteFile(SYS.'/config.php',$config);
		   
		   }

    }
	
	
	public function ReadSysDir($dir){
		  $dirarr=array();
		  if($dir){
				if ($handle = @opendir($dir)) {
		   
					 while (false !== ($file = readdir($handle))) {
							if ($file != "." && $file != "..") {
								 
								 $dirarr[]=array('filename'=>$file,'filetime'=>@filemtime($dir.$file),'filesize'=>@filesize($dir.$file));
							}
					 }
					 
					 closedir($handle);
				}
				
				return $dirarr;
		  }
	}
	
	public function GetTableFieldArray($tablename=''){
		
		   $table=str_replace(DB_NAME.'.','',$this->GetTable($tablename));
		   return $this->GetMysqlArray('*'," ".$this->GetTable('field')." WHERE table_phpapp='$table' AND status_phpapp=0 ORDER BY displayorder_phpapp ASC");
	}

	public function GetTableFieldForm($field,$value=''){
	
          include_once(Core.'/class/datatable_class_phpapp.php');
		  
		  $data=new DataTable();
		  
		  return $data->MakeFormDate($field,$value);
	}
	
	//复制目录下所有文件到目标目录---------------------------------------------------------------------------------------
	public function CopyFile($source,$dest,$diffDir=''){
		   
		  if(!is_dir($dest.'/'.$diffDir)){
				mkdir($dest.'/'.$diffDir,0777); 
		  }

		  $dir = new DirectoryIterator($source);
		  
		  foreach($dir as $file) {
				if(!$file->isDot()) {
					
					  $filename = $file->getFilename();

					  if($file->isDir()) {
						   $this->CopyFile($source.'/'.$filename,$dest,$diffDir.'/'.$filename); 
					  }else {
						   copy($source.'/'.$filename,$dest.'/'.$diffDir.'/'.$filename); 
					  }
				  
				}
		  }
	   	
	 }
	 
	 //删除目录和目录下所有文件-------------------------------------------------------------------------------------------
	 public function DeleteDir($dir){
		   if (is_dir($dir)) {
				 $objects = scandir($dir);
				 foreach ($objects as $object) {
					   if ($object != "." && $object != "..") {
						     if (filetype($dir."/".$object) == "dir") $this->DeleteDir($dir."/".$object); else unlink($dir."/".$object);
					   }
				 }
				 reset($objects);
				 rmdir($dir);
		   }
     }

	
	public function MakeGetParameterURL($parameter=''){
		
			$makeget=array();

			$GET=$_GET;
			
			if($parameter){
				
				  foreach($parameter as $key=>$value){
						
						unset($GET[$key]); 

				        $makeget[]=$key.'='.urlencode($value);
						
				  }
			}
			
			if($GET){
				  foreach($GET as $key=>$value){

						$makeget[]=$key.'='.urlencode($value);

				  }
			}

			return '?'.implode('&',$makeget);
	}
	
	
	public function GetCheckBox($checkbox='',$explode=0){
		    
			$ids='';
			
		    if($checkbox){
				
				  foreach($checkbox as $value){
					     if($ids){
							  $ids.=','.$value;
						 }else{
							  $ids=$value;
						 }
				  }
				
			}else{
				
				 echo $this->Refresh('<p>请选择数据操作！</p>',$this->MakeGetParameterURL());
					   
				 exit();
				
			}
			
			if($explode){
				  return $ids;
			}else{
			      return $this->ExplodeStrArr($ids);
			}

	}
	
	public function GetTaskFeeValue($table='',$field='',$money=0,$type=0,$uid=0){
		
		
		   $member=$this->GetLoginInfo($uid,1);
		 
		   $group=$this->GetMysqlOne('feetype,taskfee,unionfee,addunionfee'," ".$this->GetTable($table)." WHERE gid='$member[usergroup]'");
			  
		   if($group && $money){

					if($group[$field]){
						   
						   if($type){
							    //推广费
								
							     return  floor(($money*$group[$field])*100)/100;
							   
						   }else{
							     //收费
								 if($group['feetype']){
									   
										return  floor(($group[$field])*100)/100;
									   
								 }else{
									   
										return  floor(($money*$group[$field])*100)/100;
									 
								 }
						   }
							
						
					}else{
		 	                return false;
	                }
				
	       }else{
		 	      return false;
	       }

	}
	
	public function GetTableFieldResult($tablename='',$POST=''){
		
		  $fieldarray=$this->GetTableFieldArray($tablename);
		  
		  $errors=array();
		  $checknum=0;
		  
		  if($fieldarray){
			   
			    foreach($fieldarray as $key=>$value){
				     
					  if($value['required_phpapp']==1){
						     
							 $fieldname=$value['field_phpapp'];
							 
							 
							 if($value['type_phpapp']=='checkbox' && $value['submit_phpapp']==1){
								   
								   $valuenum=count(explode("\n",$value['value_phpapp']));
								   
								   $selectnum=0;
								   
								   $newvalue='';
								   
								   for($i=0;$i<$valuenum;$i++){
									      $newfieldname=$fieldname.'_'.$i;
										  
										  if(!empty($POST[$newfieldname])){
											   $selectnum+=1;
											   if($newvalue){
												     $newvalue.=' '.$POST[$newfieldname];
											   }else{
												     $newvalue=$POST[$newfieldname];
											   }
										  }
									       
								   }
								   
								   $POST[$fieldname]=$newvalue;
								   
								   if($selectnum){
									    $checknum+=1;
								   }else{
									    $errors[]='请选择一个'.$value['name_phpapp'].'值!';	
								   }
								   
								 
							 }elseif($value['type_phpapp']=='text' ||  $value['type_phpapp']=='textarea'){
							 
								   $strings=new CharFilter($POST[$fieldname]);
								  
								   if(empty($POST[$fieldname])){
										 $errors[]='请输入'.$value['name_phpapp'].'!';	 
								   }elseif($strings->CheckLength($value['smalllength_phpapp'])){  
										 $errors[]='对不起！,'.$value['name_phpapp'].'不能少'.$value['smalllength_phpapp'].'个字符!';
								   }elseif($strings->CheckShort($value['maxlength_phpapp'])){
										 $errors[]='对不起！,'.$value['name_phpapp'].'太长了!';
								   }else{
										 $checknum+=1;
								   }
							 
							 }else{
								 
								   $checknum+=1;
								 
							 }
							
					  }else{
						    $checknum+=1;
					  }

			    }
				
				
				return array('checknum'=>$checknum,'errors'=>$errors,'post'=>$POST);
				
		 }else{
			 
			    return false;
			 
		 }
			   
		
	}
	
	public function GetCategoryAllId($tablename='',$id=''){
		
		     $categoryarr=$this->GetMysqlOne('nexts'," ".$this->GetTable($tablename)." WHERE  catid='$id' ORDER BY displayorder ASC");

			 return $categoryarr['nexts'];
		
	}
	
	 function FileList($id,$type=0){
		   
		   $id=intval($id);
		   
		   $type=intval($type);
		   
           return $this->GetMysqlArray('a.*,b.type'," ".$this->GetTable('file')." AS a LEFT JOIN ".$this->GetTable('apps_file')." AS b ON a.fid=b.fid  WHERE appid='$this->app' AND b.id='$id' AND b.type='$type'");
	 }
	
	
	 function ShowAllowError($allow=array(),$url=''){
		 
			   $errors='';
			   foreach($allow as $value){
					  $errors.='<p>'.$value.'</p>';
			   }
			  
			   if($this->IsWap()){
					 $this->Refresh($errors,$url);
			   }else{
					 echo $errors;
					 echo $this->CloseNowWindows('#loading');
			   }
		 
	 }
	 
	 
	 function ReplaceFileContent($files,$tname='',$content='',$where=''){
		 
	        //FTP
		   if(PHPAPP::$config['ftp_open']==1){
			   
			     $fids='';
														 
				 foreach($files as $fid){
					  
					  if($fids){
						   $fids.=','.$fid;
					  }else{
						   $fids=$fid;
					  }
					   
				 }
				 
				 $ftppath='ftp://'.PHPAPP::$config['ftp_username'].':'.PHPAPP::$config['ftp_password'].'@'.PHPAPP::$config['ftp_server'].'/';
				 
				 $filearr=$this->GetMysqlArray('thumb,filepath'," ".$this->GetTable('file')." WHERE fid IN($fids) ");
				 
				 foreach($filearr as $arr){
					   if($arr['thumb']){
							 $content=str_replace($arr['thumb'],$ftppath.$arr['thumb'],$content);
					   }
					   
					   if($arr['filepath']){
							 $content=str_replace($arr['filepath'],$ftppath.$arr['filepath'],$content);
					   }
					   
				 }
				 
				 $this->Update($tname,array('content'=>$content),array()," $where");
				 
		   }
		   
	 }
	 
	 function EDOOGDomain(){
		     
		   if(PHPAPP::$config['userdomainname']==0){
				 $domainarr=explode('.',$_SERVER['SERVER_NAME']);
				 $domain_num=count($domainarr);
				 if($domain_num>2){
	
					  $domainname=$this->str($domainarr[0],20,1,0,1,0,1);
					  
					  $domainname=sprintf(" WHERE  domainname='%s'",$domainname);
	
					  if($this->IsSQL('member_info',$domainname)){
						  
						  $user=$this->GetMysqlOne('uid'," ".$this->GetTable('member_info')."  $domainname ");

		                  if($user['uid']>0){
							  
							   $http='http://www'.PHPAPP::$config['domainname'];
							   
							   header('Location:'.$http.'/space.php?app=8&uid='.$user['uid']); 
							   
							   exit();
						  }
					
					  }
					  
				 }
	  
		   }

		 
	 }

	 
}





//设置系统配置

class SystemConfig extends PHPAPP{
	
	 public $app,$action;
	 
	 function __construct(){	 
		  $this->app=empty($_GET['app']) ? 'default' : $_GET['app'];
		  $this->action=empty($_GET['action']) ? 'default' : $_GET['action'];
	 }
	 
	 function SetSystemAppKey(){
            global $actiontype,$siteuri;
			// 1 = path
			$ispath=0;
	 		//app
			if(preg_match('/^[a-z]+$/i',$this->app)){
				  $siteuri['app']=$this->app;
				  $ispath=1;
			}elseif(preg_match('/^[0-9]+$/i',$this->app)){
				  $siteuri['app']=$this->app;
				  $ispath=0;
			}else{
				  $siteuri['app']='default';
			}
			
			//action
			if(preg_match('/^[a-z]+$/i',$this->app) && preg_match('/^[a-z]+$/i',$this->action)){
				  $siteuri['action']=$this->action;
			}elseif(preg_match('/^[0-9]+$/i',$this->app) && preg_match('/^[0-9]+$/i',$this->action)){
				  $siteuri['action']=$actiontype.'.'.$this->action;
			}else{
				  $siteuri['action']='default';
			}
	
			$siteapparray=$this->GetApps($ispath);
			$siteactionarray=$this->GetAction($siteuri['app'],$ispath);
			self::$appclass=$siteapparray[$siteuri['app']];
			self::$appactionclass=$siteactionarray[$siteuri['action']];
			
			unset($siteapparray); 
			unset($siteactionarray); 
	 }
			
	 
	 function SetSystemUserLogin(){

		  if(!empty($_SESSION['USER_USERID']) && !empty($_SESSION['USER_COOKIECODE'])){
		        
				$logincookiecode=$this->SetCookieCode($_SESSION['USER_USERID'],$_SESSION['USER_COOKIECODE'],$_SESSION['USER_USERID']);
				$loginuid=intval($_SESSION['USER_USERID']);
				
				if($this->IsSQL('member',"WHERE cookiecode='$logincookiecode' AND uid='$loginuid'")){
					
			          return array('uid'=>intval($_SESSION['USER_USERID']),'username'=>$_SESSION['USER_USERNAME']);
				}else{
					 unset($_SESSION['USER_USERID']); 
			         unset($_SESSION['USER_COOKIECODE']); 
	                 unset($_SESSION['USER_USERNAME']);
				}
				
		  }else{
			   unset($_SESSION['USER_USERID']); 
			   unset($_SESSION['USER_COOKIECODE']); 
	           unset($_SESSION['USER_USERNAME']);
			   return false;
		  }	  

	}
	
	function SetSystemVariable(){
		
		   $systemvalue=$this->SetSystemUserLogin();
		   $systemvalue['page']=empty($_GET['page']) ? 1 : intval($_GET['page']);
		   $systemvalue['app']=PHPAPP::$appclass['id_phpapp'];
		   $systemvalue['ac']=PHPAPP::$appactionclass['aid_phpapp'];
		   		 
		   if(!empty(PHPAPP::$config['ipcityopen'])){
		       $systemvalue['nowcity']=empty($_COOKIE['USERCITYID']) ? 0 : intval($_COOKIE['USERCITYID']);
		   }else{
			   $systemvalue['nowcity']=0;
		   }
		   
		   return $systemvalue;
	}
	
}



?>