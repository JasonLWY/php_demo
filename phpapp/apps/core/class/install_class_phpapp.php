<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//安装
class Install extends PHPAPP{

    private $filearray,$AppsSql,$DataSql,$TableSql,$appid;
	
	function __construct($filearray=''){
		
		if($filearray){
			  $this->filearray=$filearray;
			  
			  $this->AppsSql=$filearray['filedirectory'].'/phpapp_apps.sql';
			  
			  $this->AdminSql=$filearray['filedirectory'].'/phpapp_admin.sql';
			  
			  $this->ActionSql=$filearray['filedirectory'].'/phpapp_action.sql';
			  
			  $this->ConfigSql=$filearray['filedirectory'].'/phpapp_config.sql';
			  
			  $this->DataSql=$filearray['filedirectory'].'/phpapp_data.sql';
			  
			  $this->TableSql=$filearray['filedirectory'].'/phpapp_table.sql';
			  
			  $this->AlterSql=$filearray['filedirectory'].'/phpapp_alter.sql';
		
		}

	}
	
	function InstallCode($iszip=0){
		
		   if(!$iszip){
			   
				   include_once(Core.'/class/zip_class_phpapp.php');
				   
				   $zip = new ZIP();
				   
				   if(!$zip->ZipDecomposition($this->filearray)){
					      return false;
				   }
			   
		   }
			     
		   $is_install=$this->filearray['filedirectory'].'/install.php';

				 
		   if(file_exists($is_install)){
			   
				  include_once($is_install);
			   

				  if($INSTALL_CODE=='PHPAPP'){
						 

						 $this->ReplaceTableName();
						 
						 if($this->TableSql){
								   
								 preg_match_all('/DROP TABLE (.*)\;|CREATE TABLE (.*)\;/isU',$this->TableSql,$TableArray);
								 
								 if($TableArray){
										foreach($TableArray[0] as $query){

											  $query=str_replace('ENGINE=MyISAM','ENGINE=MyISAM CHARSET='.DB_CHARSET,$query);
											
											  $this->MysqlQuery($query);
										}
								 }
								 
								 unset($TableArray); 
						 }
						 
						 if($INSTALL_TYPE==1){
                                
								//是否已安装
								$isinstallapp=preg_match('/id\_phpapp/iU',$this->AppsSql,$appssqlarray);
								
								if($isinstallapp){
									  
									    preg_match('/VALUES\(([0-9]+)\,/iU',$this->AppsSql,$appssqlarray);
														   
										$nowappid=intval($appssqlarray[1]);
										
										if($nowappid>0){
											  //卸载
											  $this->UnloadCode($nowappid);
											  
										}
										
									  
								}

								
								$this->MysqlQuery($this->AppsSql);
								$this->appid=mysql_insert_id();
								
								$apparr=$this->GetMysqlOne('id_phpapp,name_phpapp,dir_phpapp'," ".$this->GetTable('apps')." WHERE id_phpapp='$this->appid'");
								
								if(is_dir(SYS.'/apps/'.$apparr['dir_phpapp'])){
									  
									  $this->Delete('apps'," WHERE id_phpapp='$this->appid'");
									  exit('该应用目录已存在！请手动删除 /phpapp/apps/'.$apparr['dir_phpapp'].' 文件夹后再安装！');
								}
								
								  
								$this->Update('apps',array('filesize_phpapp'=>filesize($this->filearray['filepath']),'install_phpapp'=>$this->NowTime(),'update_phpapp'=>$this->NowTime(),'version_phpapp'=>floatval($INSTALL_VERSION)),array()," WHERE id_phpapp='$this->appid'");
							   
						 }else{ 
						 
							   $internal=intval($INSTALL_INTERNAL_ID);
							   
							   $apparr=$this->GetMysqlOne('id_phpapp,name_phpapp,dir_phpapp,filesize_phpapp'," ".$this->GetTable('apps')." WHERE internal_phpapp='$internal'");
							   
							   $this->appid=$apparr['id_phpapp'];
							   
							   //更新记录
							   $updatefilesize=filesize($this->filearray['filepath']);
							   
							   $this->Insert('apps_update',array('apps_phpapp'=>$this->appid,'name_phpapp'=>$INSTALL_NAME,'required_phpapp'=>intval($INSTALL_REQUIRED),'filesize_phpapp'=>$updatefilesize,'date_phpapp'=>$this->NowTime()),array());
							   
							   $updatefilesize=$apparr['filesize_phpapp']+$updatefilesize;
							   
							   $this->Update('apps',array('filesize_phpapp'=>$updatefilesize,'update_phpapp'=>$this->NowTime(),'version_phpapp'=>floatval($INSTALL_VERSION)),array()," WHERE id_phpapp='$this->appid'");
						 }
						 
						 //路径
						 
						 $appdir=SYS.'/apps/'.$apparr['dir_phpapp'];
					
					     $templatedir=SYS.'/templates/'.S_TEMPLATE.'/'.PHPAPP::$config['templatepath'].'/'.$apparr['dir_phpapp'];
						
						 $styledir=SYS.'/templates/'.S_TEMPLATE.'/style/'.PHPAPP::$config['stylepath'].'/'.$apparr['dir_phpapp'];
						 
						 $stylelanguage=SYS.'/templates/'.S_TEMPLATE.'/language/'.$INSTALL_LANGUAGE;
							   
						 $styletemplateblock=SYS.'/templates/'.S_TEMPLATE.'/'.PHPAPP::$config['templatepath'].'/templateblock';
						  
						 
						 if($this->appid){
							   
							   if($this->ActionSql){
									 $dataid=$this->DivisionTableData($this->ActionSql);
									 
									 if($dataid){

											$this->Update('apps_action',array('apps_phpapp'=>$this->appid),array()," WHERE id_phpapp IN($dataid)");
											
									 }
							   }
							
							   if($this->AdminSql){
									 $dataid=$this->DivisionTableData($this->AdminSql);
									 
									 if($dataid){

											$this->Update('admin_menu',array('apps_phpapp'=>$this->appid),array()," WHERE catid_phpapp IN($dataid)");
											
									 }
							   }
							   
							   if($this->ConfigSql){
									 $dataid=$this->DivisionTableData($this->ConfigSql);
									 
									 if($dataid){

											$this->Update('config',array('app_phpapp'=>$this->appid),array()," WHERE id_phpapp IN($dataid)");
											
									 }
							   }
							   
							   if($this->TableSql){
								   
									 preg_match_all('/CREATE TABLE (.*)\(/isU',$this->TableSql,$content);
																					
									 if($content[1]){
										  
										  $tablename='';
										  foreach($content[1] as $value){
											  
												 $value=str_replace('`','',$value);
												 
												 if($tablename){
													   $tablename.=','.$value;
												 }else{
													   $tablename.=$value;
												 }
										  }
										  
										  
										  $installarray=$this->GetMysqlOne('id_phpapp,table_phpapp'," ".$this->GetTable('apps_install')." WHERE apps_phpapp='$this->appid'");
										  
										  if($installarray){
												
												$id_phpapp=$installarray['id_phpapp'];
												
												$this->Update('apps_install',array('table_phpapp'=>$installarray['table_phpapp'].','.$tablename),array()," WHERE id_phpapp='$id_phpapp'");
											  
										  }else{
										  
												$this->Insert('apps_install',array('apps_phpapp'=>$this->appid,'table_phpapp'=>$tablename),array());
										  }
										 
									 }
									 
							   }
							   
							   if($this->AlterSql){
								   
									 preg_match_all('/ALTER TABLE (.*)\;|ALTER TABLE (.*)\)\;/isU',$this->AlterSql,$DataSqlArray);
								 
									 if($DataSqlArray){
										  foreach($DataSqlArray[0] as $query){
											   $this->MysqlQuery($query);
										  }
									 }
							   }
							  
							   if($this->DataSql){
									 
									 $this->DataSql=str_replace('[APPID]',$this->appid,$this->DataSql);
									 
									 preg_match_all('/INSERT INTO (.*)\)\;\n|INSERT INTO (.*)\)\;/isU',$this->DataSql,$DataSqlArray);
								 
									 if($DataSqlArray){
										  foreach($DataSqlArray[0] as $query){
											   $this->MysqlQuery($query);
										  }
									 
									 }
							   }
							   
							   
							   if(!is_dir($appdir)){
									 mkdir($appdir,0777);
							   }
							   
							   if(!is_dir($templatedir)){
									 mkdir($templatedir,0777);
							   }
							   
							   if(!is_dir($styledir)){
									 mkdir($styledir,0777);
							   }
							
							   if(is_dir($this->filearray['filedirectory'].'/phpapp_code')){
								   
									 $this->CopyFile($this->filearray['filedirectory'].'/phpapp_code',$appdir);
							   }
							   
							   if(is_dir($this->filearray['filedirectory'].'/phpapp_template')){
							   
									 $this->CopyFile($this->filearray['filedirectory'].'/phpapp_template',$templatedir);
							   
							   }
							   
							   if(is_dir($this->filearray['filedirectory'].'/phpapp_style')){
							   
									 $this->CopyFile($this->filearray['filedirectory'].'/phpapp_style',$styledir);
							   
							   }
							   
							   if(is_dir($this->filearray['filedirectory'].'/phpapp_language')){
							   
									 $this->CopyFile($this->filearray['filedirectory'].'/phpapp_language',$stylelanguage);
							   
							   }
							   
							   
							   if(is_dir($this->filearray['filedirectory'].'/phpapp_block')){
							   
									 $this->CopyFile($this->filearray['filedirectory'].'/phpapp_block',$styletemplateblock);
							   
							   }
							   
							   
							   $this->DelFile($this->filearray['filepath']);
							   
							   $this->DeleteDir($this->filearray['filedirectory']);
							   
						 
						 }
						 
						 
						 return true;
					  
				  }else{
					   return false;
				  }
				 

				 
		   }else{
				 return false;
		   }
		
	}
	
	function ReplaceTableName(){
		  
		  
		  if(file_exists($this->AppsSql)){
		         
				$this->AppsSql=str_replace('phpapp_',DB_TNAME,$this->GetFile($this->AppsSql));
				
		  }else{
			  
			    $this->AppsSql=false;
			  
		  }
		  
		  if(file_exists($this->AdminSql)){
		         
				$this->AdminSql=str_replace('phpapp_',DB_TNAME,$this->GetFile($this->AdminSql));
				
		  }else{
			  
			    $this->AdminSql=false;
			  
		  }
		  
		  if(file_exists($this->ActionSql)){
		         
				$this->ActionSql=str_replace('phpapp_',DB_TNAME,$this->GetFile($this->ActionSql));
				
		  }else{
			  
			    $this->ActionSql=false;
			  
		  }
		  
		  if(file_exists($this->ConfigSql)){
		         
				$this->ConfigSql=str_replace('phpapp_',DB_TNAME,$this->GetFile($this->ConfigSql));
				
		  }else{
			  
			    $this->ConfigSql=false;
			  
		  }
		  
		  
		  if(file_exists($this->DataSql)){
		         
				$this->DataSql=str_replace('phpapp_',DB_TNAME,$this->GetFile($this->DataSql));
				
		  }else{
			  
			    $this->DataSql=false;
			  
		  }
		  
		  if(file_exists($this->TableSql)){
		         
				$this->TableSql=str_replace('phpapp_',DB_TNAME,$this->GetFile($this->TableSql));
				
		  }else{
			  
			    $this->TableSql=false;
			  
		  }
		  
		  
		  if(file_exists($this->AlterSql)){
		         
				$this->AlterSql=str_replace('phpapp_',DB_TNAME,$this->GetFile($this->AlterSql));
				
		  }else{
			  
			    $this->AlterSql=false;
			  
		  }
		  
	}
	
	function DivisionTableData($datasql){
		  
		  if($datasql){
				preg_match_all('/INSERT INTO (.*)\;/isU',$datasql,$content);
				
				$queryid='';
				if($content[0]){
					
					  foreach($content[0] as $value){
						      
							  $this->MysqlQuery($value);
							  
							  if($queryid){
								    $queryid.=','.mysql_insert_id();
							  }else{
								    $queryid.=mysql_insert_id();
							  }
							 
					  }
					  
					  return $queryid;
					  
				}else{
			         return false;
				}
				
		  }else{
			    return false;
		  }
    }
	
	
	function UnloadCode($appid=0){

		   
		  if($appid){
			     
				 $apparray=$this->GetMysqlArray('a.dir_phpapp,b.table_phpapp'," ".$this->GetTable('apps')." AS a LEFT JOIN ".$this->GetTable('apps_install')." AS b ON a.id_phpapp=b.apps_phpapp WHERE a.id_phpapp IN($appid)");
				
				 if($apparray){
					 
					   //删除文件------------------------------------------------------------------
					   
					   foreach($apparray as $value){
						       
							   
							   $appdir=SYS.'/apps/'.$value['dir_phpapp'];
							   
							   $cachedir=SYS.'/data/cache/'.$value['dir_phpapp'];
							   
							   $templatedir=SYS.'/templates/'.S_TEMPLATE.'/'.PHPAPP::$config['templatepath'].'/'.$value['dir_phpapp'];
		  
		                       $styledir=SYS.'/templates/'.S_TEMPLATE.'/style/'.PHPAPP::$config['stylepath'].'/'.$value['dir_phpapp'];
							   
							   if(is_dir($appdir)){
							        $this->DeleteDir($appdir);
							   }
							   
							   if(is_dir($templatedir)){
							        $this->DeleteDir($templatedir);
							   }
							   
							   if(is_dir($styledir)){
							        $this->DeleteDir($styledir);
							   }
							   
							   if(is_dir($cachedir)){
							        $this->DeleteDir($cachedir);
							   }
							   
							   
							   //删除表
							   if($value['table_phpapp']){
									 $tablearr=explode(',',$value['table_phpapp']);
									 if($tablearr){
										  foreach($tablearr as $tablename){
												 $this->DropTable($tablename);
										  }
									 }
							   }
				  
					   }
					   
					   //删除数据------------------------------------------------------------------
							   
					   $this->Delete('admin_menu'," WHERE apps_phpapp IN($appid)");
					   
					   $this->Delete('apps'," WHERE id_phpapp IN($appid)");
					   
					   $this->Delete('apps_action'," WHERE apps_phpapp IN($appid)");
					   
					   $this->Delete('apps_credit'," WHERE apps_phpapp IN($appid)");
					   
					   $this->Delete('apps_feed'," WHERE apps_phpapp IN($appid)");
					   
					   $this->Delete('apps_install'," WHERE apps_phpapp IN($appid)");

					   $this->Delete('apps_update'," WHERE apps_phpapp IN($appid)");
					   
					   $this->Delete('autorun'," WHERE appid IN($appid)");
					   
					   $this->Delete('category'," WHERE type IN($appid)");
					   
					   $this->Delete('certificate'," WHERE app_phpapp IN($appid)");

					   $this->Delete('config'," WHERE app_phpapp IN($appid)");
					   
					   $this->Delete('consume'," WHERE 	appid IN($appid)");
					   
					   $this->Delete('nav'," WHERE appid IN($appid)");
					   
					   $this->Delete('pay_tool'," WHERE id_phpapp IN($appid)");
					   
					   $this->Delete('prop'," WHERE appid IN($appid)");
					   
					   $this->Delete('prop_consume'," WHERE app IN($appid)");
					   
					   $this->Delete('sns'," WHERE 	app_phpapp IN($appid)");
					   
					   $this->Delete('sns_api'," WHERE 	appid IN($appid)");
					   
					   $this->Delete('templateblock'," WHERE apps_phpapp IN($appid)");
					   
					   $this->Delete('advertising'," WHERE apps_phpapp IN($appid)");
						
						
					   return true;
					   
				 }else{
					   return false;
				 }
		  }else{
			   return false;
		  }
		
	}

}


?>