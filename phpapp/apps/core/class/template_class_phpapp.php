<?php
/*
	EDOOG.COM (C) 2009-2014 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0 2013.2.10
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//phpapp模板引擎类
class template extends PHPAPP{
	
    public $template_dir,$cache_dir,$cache_time,$template_file,$cache_file,$template_content,$dir_phpapp,$templatefile,$wap; 

	
	function __construct($templatefile='',$wap=''){
		global $language;
		
		$this->wap=$wap;
		
		$templatefilearr=explode(':',$templatefile);
		
		if(!empty($templatefilearr[1])){
			 
			 $this->templatefile=$templatefilearr[1];
		
		     $this->dir_phpapp=$templatefilearr[0];
			
		}else{
		
		      $this->templatefile=$templatefile;
		
		      $this->dir_phpapp=PHPAPP::$appdir;
		}
		
			
		$this->template_dir=SYS.'/templates/'.S_TEMPLATE.'/'.PHPAPP::$config['templatepath'].'/'.$this->dir_phpapp.'/';
		
		$cache_dir=SYS.'/data/cache/'.$this->dir_phpapp.'/';

		if(!is_dir($cache_dir)) {
			  @mkdir($cache_dir,0777);
			  $this->WriteFile($cache_dir.'index.html','');
	    }
		
		$this->cache_dir=SYS.'/data/cache/'.$this->dir_phpapp.'/'.$language.'/';
		
		if(!is_dir($this->cache_dir)) {
				 @mkdir($this->cache_dir,0777);
				 $this->WriteFile($this->cache_dir.'index.html','');
	    }
	    $this->cache_time=S_CACHE_TIME;
		
	}
		
    function show(){
		 global $language;
		 
		 if($this->wap=='xml'){
			 $exe='xml';
		 }else{
			 $exe='htm';
		 }

	     $this->template_file=$this->templatefile.'.'.$exe; 
	    
	     $new_file_name = $this->dir_phpapp.'_'.$this->templatefile.'_'.$exe;  
				 
		 $this->cache_file= $this->cache_dir.$new_file_name . '.php';
		 
		 if($this->wap=='xml'){

			  if(!is_dir($this->template_dir.'xml')) {
				   @mkdir($this->template_dir.'xml',0777);
	          }
			  
			  $template_file_name=$this->template_dir.'xml/'.$this->template_file;
			  
		 }else{
		      $template_file_name=$this->template_dir.$this->template_file;
		 }
		 
		 if(!file_exists($template_file_name)){
				$this->WriteFile($template_file_name,'<p>'.$this->template_file.'</p>'); 
		 }
		
		
		 if(file_exists($this->cache_file)){
			 
			  $cachefiletime=filemtime($this->cache_file);
			  
			  $ttime=time() - $cachefiletime;	
			  
		      if($ttime > $this->cache_time || $ttime<0){
						
				   $this->TemplateCaches($new_file_name,$template_file_name);			     
							
			  }
			  
		 }else{
			   $this->TemplateCaches($new_file_name,$template_file_name);
		 }

		 return $this->cache_file;
		   
	   }
	   
	   
	   function templatehtm(){
					
			$mun=1;
               
			while($mun>=1){
			
				$blockmun=preg_match_all('/{block\s+(\w+)}/iU',$this->template_content,$blockarray);
					
				if($blockmun){
					
					  if($blockarray[1]){
							
							foreach($blockarray[1] as $value){
	
									if($this->IsSQL('templateblock'," WHERE quote_phpapp='$value' AND status_phpapp=0 ")){
										  $this->template_content=preg_replace("/{block\s+$value}/iU",'{template templateblock:'.$value.'}',$this->template_content);
									}else{
										  $this->template_content=preg_replace("/{block\s+$value}/iU",'',$this->template_content);
									}
									
							}
						  
					  }
					  
					  unset($blockarray); 
				
				}
                
				
				
				$preg='/{template\s+(.*)}/U';
				$mun=preg_match_all($preg,$this->template_content,$filename);
				
				$template_file_content='';
				
				foreach( $filename[1] as $filename){
				    
					//分割
					$filenamearr=explode(':',$filename);
					
					if($filenamearr[1]){
						 
						 if($this->wap=='xml'){
							 
							  $newfile=SYS.'/templates/'.S_TEMPLATE.'/'.PHPAPP::$config['templatepath'].'/'.$filenamearr[0].'/xml/'.$filenamearr[1].'.xml';
							  
							  if(!file_exists($newfile)){
						            $this->WriteFile($newfile,'<p>'.$filenamearr[1].'.xml</p>');
					          }
							 
						 }else{
						      $newfile=SYS.'/templates/'.S_TEMPLATE.'/'.PHPAPP::$config['templatepath'].'/'.$filenamearr[0].'/'.$filenamearr[1].'.htm';
							  
							  if(!file_exists($newfile)){
						            $this->WriteFile($newfile,$filenamearr[1].'.htm');
					          }
						 }
 
					}else{
						
						 if($this->wap=='xml'){
							 
							  $newfile=$this->template_dir.'xml/'.$filenamearr[0].'.xml';
							  
							  if(!file_exists($newfile)){
						             $this->WriteFile($newfile,'<p>'.$filenamearr[0].'.xml</p>');
					          }
							 
						 }else{
						      $newfile=$this->template_dir.$filenamearr[0].'.htm';
							  
							  if(!file_exists($newfile)){
						             $this->WriteFile($newfile,$filenamearr[0].'.htm');
					          }
						 }
 
					}

                    
				
			      	if($template_file_content=$this->GetFile($newfile)){
				         $this->template_content=preg_replace("/{template\s+$filename}/U",$template_file_content,$this->template_content);
				    }else{
				         $this->WriteFile($newfile,$filenamearr[0]);
				    }
				
				}
				
			}
					   
	   }
	   
	   
	   function templateif(){ 
	   
	          $this->template_content=preg_replace('/{if\s+(.*)}/U','<?php if ($1){ ?>',$this->template_content);
	     
	          $this->template_content=preg_replace('/{else}/U','<?php }else{ ?>',$this->template_content);
	   
	          $this->template_content=preg_replace('/{elseif\s+(.*)}/U','<?php }elseif($1){ ?>',$this->template_content);
	   
	          $this->template_content=preg_replace('/{\/if}/U','<?php } ?>',$this->template_content);
	   
	   }
	   
	   function templatefor(){ 
	   
	          $this->template_content=preg_replace('/{for\s+(.*)\s+(.*)}/U','<?php foreach ($1 as $2){ ?>',$this->template_content);
	   
	          $this->template_content=preg_replace('/{\/for}/U','<?php } ?>',$this->template_content);
	   
	   }
	 
	   
	   function templatelanguage(){
		   
	          global $language;

			  $preg='/{lang\s+(.*)}/U';
			  
	          $mun=preg_match_all($preg,$this->template_content,$languagename);

			  foreach($languagename[1] as $languagename){
				   
				   //分割
				   $languagenamearr=explode(':',$languagename);
				   
				   if($languagenamearr[1]){
					     $languagecontent=$this->ShowLanguage($language,$languagenamearr[1],$languagenamearr[0]);
				   }else{
				         $languagecontent=$this->ShowLanguage($language,$languagenamearr[0],$this->dir_phpapp);
				   }
	
				   $this->template_content=preg_replace("/{lang\s+$languagename}/U",$languagecontent,$this->template_content);
			  }
	   
	   }

       function TemplateCaches($new_file_name,$template_file_name){
		   
		        ob_start();

				$this->template_content=$this->GetFile($template_file_name);	
				
				$this->templatehtm();

				$this->templatelanguage();
				
				if(S_REWRITE_URL){
				      $this->RouteFormat();	
				}
	
				$admun=preg_match_all('/{ad\s+(\w+)}/iU',$this->template_content,$adarray);
				
				if($admun){
					
				      if($adarray[1]){
						    
							foreach($adarray[1] as $value){
								    
									$advertising=$this->GetMysqlOne('code_phpapp'," ".$this->GetTable('advertising')." WHERE key_phpapp='$value' AND status_phpapp=0 ");
									
									if($advertising['code_phpapp']){
									      $this->template_content=preg_replace("/{ad\s+$value}/iU",$advertising['code_phpapp'],$this->template_content);
									}else{
										  $this->template_content=preg_replace("/{ad\s+$value}/iU",'',$this->template_content);
									}
								    
							}
						  
						    unset($advertising); 
						  
					  }
					  
					  unset($adarray); 
				
				}
				
				$sqlmun=preg_match_all('/{sql\s+(\w+)}/iU',$this->template_content,$sqlarray);
				
				if($sqlmun){
					
				      if($sqlarray[1]){
						    
							foreach($sqlarray[1] as $value){
								    
									$getdataarray=$this->GetMysqlOne('code_phpapp,template_phpapp'," ".$this->GetTable('getdata')." WHERE key_phpapp='$value' AND status_phpapp=0 ");
									
									if($getdataarray['code_phpapp']){
									      $this->template_content=preg_replace("/{sql\s+$value}/iU",htmlspecialchars_decode($getdataarray['code_phpapp'],ENT_QUOTES).htmlspecialchars_decode($getdataarray['template_phpapp'],ENT_QUOTES),$this->template_content);
									}else{
										  $this->template_content=preg_replace("/{sql\s+$value}/iU",'',$this->template_content);
									}
								    
							}
						  
						    unset($getdataarray); 
						  
					  }
					  
					  unset($sqlarray); 
				
				}
				
				$this->template_content=preg_replace('/{echo\s+(.*)}/iU','<?php echo $1; ?>',$this->template_content);
				
				
                $template_content="<?php if(!defined('IN_PHPAPP')){exit('Data error');} ?>";
	
				$this->template_content=preg_replace('/{\/php}/iU',' ?>',preg_replace('/{php}/iU','<?php ',$this->template_content));
				
				$this->templateif();
				
				$this->templatefor();
				
				//通用输出				
				$template_content.=preg_replace('/{(\w+|\$\w+|\$\w+\[\'\w+\'\]|\$\w+\[\w+\])}/iU','<?php echo $1; ?>',$this->template_content);

				if (strlen($template_content)){

				      $this->WriteFile($this->cache_file,$template_content);
					 
				}else{	
				      exit("Can not write to a file");
				}
			    ob_end_clean();

	   }
	  
	   
	   function RouteFormat(){
		        

				$urlmun=preg_match_all("/[\"]\{echo SURL\}[\/][a-z]+\.php(.*)[\"]/U",$this->template_content,$urlarray);
				
				if($urlmun>0){
					   
					   $appsarr=$this->GetMysqlArray('id_phpapp,route_phpapp',$this->GetTable('apps').' WHERE status_phpapp=0 AND show_phpapp=0');

					   //完整[0]
					   foreach($urlarray[0] as $key=>$value){

							  $route=str_ireplace('space.php?','',str_ireplace('index.php?','',$value));
						      
							  $route=str_ireplace('.php?','/',$route);
						  
							  //app
							  $isapp=preg_match('/app\=(\d+)/i',$route,$apparray);
							  if($isapp){
								   $appid=intval($apparray[1]);
								   foreach($appsarr as $apparr){
									   
									      if($apparr['id_phpapp']==$appid){
											     
												 if(preg_match('/app\=(\d+)\&/',$route)){
													   $route=preg_replace('/app\=(\d+)\&/i',$apparr['route_phpapp'].'/',$route);
												 }else{
											     	   $route=preg_replace('/app\=(\d+)/i',$apparr['route_phpapp'],$route);
												 }
										  }
									   
								   }
								   
								   $actype=0;
								   if(strpos($value,'member.php')){
									    $actype=2;
								   }elseif(strpos($value,'space.php')){
									    $actype=3;
								   }
								   
								  //action
								  $isaction=preg_match('/action\=(\d+)/i',$route,$actionarray);
								  if($isaction){						   
									   $acid=intval($actionarray[1]);
				                       $action=$this->GetMysqlOne('id_phpapp,aid_phpapp,apps_phpapp,route_phpapp'," ".$this->GetTable('apps_action')." WHERE apps_phpapp='$appid' AND status_phpapp=0 AND type_phpapp='$actype' AND aid_phpapp='$acid' ");
  
										 if($action['route_phpapp']=='default'){
												$route=substr(preg_replace('/action\=(\d+)/i','',$route),0,-1);
										 }else{ 
												if(preg_match('/action\=(\d+)\&/',$route)){
													 $route=preg_replace('/action\=(\d+)\&/',$action['route_phpapp'].'/',$route);
												}else{
													 $route=preg_replace('/action\=(\d+)/',$action['route_phpapp'],$route);
												}
										 }

								  }
			
	
								  $route=str_ireplace('&','-',$route);
								  $route=substr(preg_replace('/([a-z]+)\=(\d+|.*)/U','$1-$2',$route),0,-1);
	
								  $this->template_content=str_ireplace($value,$route.'.html"',$this->template_content);
								  
						   }

					   }
					
				}
				
	   }

}

?>