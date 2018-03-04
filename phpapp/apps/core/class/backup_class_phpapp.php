<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//备份SQL
class BackupSQL extends PHPAPP{
	
	public $DataList;
	
	function __construct(){
		
	}
	
	public function SaveTable($tablearray,$backupname,$filesize){

		  error_reporting(0);
		  set_time_limit(0);
		  $times =@date("Ymd");
		  $filedir=S_BACKUP_DIR.'/'.$times;
		  if(!is_dir($filedir)) {
			    @mkdir($filedir,0777);  
			    $this->WriteFile($filedir.'/index.html','');
		  }
		  
		  $backuplength=$filesize*1024;
		 
		  $TableStatus='-- PHPAPP网站在线应用系统'."\n";
          $TableStatus.='-- Version 2.0'."\n";
		  $TableStatus.='-- 2009-'.@date("Y").' 版权所有'."\n";
          $TableStatus.='-- http://www.phpapp.cn'."\n";
		  $TableStatus.='-- 字符集 '.S_CHARSET."\n";
		  $backupdate=date("Y 年 m 月 d 日 H:i:s");
          $TableStatus.='-- 生成日期: '.$backupdate."\n\n";
          
		  $TableInfo=$TableStatus;
		  
		  $backuptablename='';
		  
		  $newtablename='';

		  foreach($tablearray as $value){

			   if($backuptablename){
				    $backuptablename.=','.$value;
			   }else{
				    $newtablename=$backuptablename=$value;
			   }
			   
			   $TableInfo.='DROP TABLE IF EXISTS '.$value.';'."\n";
					 
			   if($this->IsMysqlTableName($value)){
		             
			         $ShowCreateTable=$this->ShowMysqlTable($value);
                     
					 if($ShowCreateTable){
						   foreach($ShowCreateTable as $value){
							   
								$TableInfo.=$value['Create Table'].';'."\n";
								$TableInfo.="\n";
						   
						   }
					 }

			   }
		  }
		  
		  $Tablewfile=$filedir.'/'.$backupname.'_0.sql';	
		  $this->WriteFile($Tablewfile,$TableInfo);
		  
		  $backupinfo='0|'.$newtablename.'|'.$backupname.'|'.$filesize.'|'.$backuptablename;
		  
		  $this->WriteFile(S_BACKUP_DIR.'/backup_'.$times.'.txt',$backupinfo);
		  
		  unset($TableInfo);
		  unset($TableDatas); 
		  unset($TableStatus);
		  
	}
	
	public function SaveTableData($Number=1,$RowSQL=0){
          
		  error_reporting(0);
		  set_time_limit(0);
		  
		  $times =@date("Ymd");
		  
		  $filedir=S_BACKUP_DIR.'/'.$times;
		  
		 
		  if(file_exists(S_BACKUP_DIR.'/backup_'.$times.'.txt')){
                   
				  $backupinfo=$this->FileGetContents(S_BACKUP_DIR.'/backup_'.$times.'.txt');
				  
				  $backupinfoarray=explode('|',$backupinfo);
				  
				  if(!empty($backupinfoarray[1])){
						   
						   $wfile=$filedir.'/'.$backupinfoarray[2].'_'.$Number.'.sql';	
							
						   if($this->GetBackupDataList($Number,$backupinfoarray,$RowSQL)){
							   
								 $openwrite = @fopen($wfile,"a");
								 fwrite($openwrite,$this->DataList);
								 fclose($openwrite);
								
						   }else{
							   
								$openwrite = @fopen($wfile,"a");
								fwrite($openwrite,$this->DataList);
								fclose($openwrite);
								
								$this->NextBackupName($Number,$backupinfoarray);
								$this->SaveTableData($Number);
						
						   }
							
						   
						   return $Number+=1;
						   
				  }else{
						 
						 $this->DelFile(S_BACKUP_DIR.'/backup_'.$times.'.txt');
						
						 return 'ok';
						 
				  }
	
		  
		  }else{

				return 'ok';
		  }
	
	}
	
	
	
    public function GetBackupDataList($Number,$backupinfoarray,$RowSQL){
	         
			$DataRows=100;
			 
	        $times =@date("Ymd");
		  
		    $filedir=S_BACKUP_DIR.'/'.$times;
	
			$value=str_replace(DB_TNAME,'',$backupinfoarray[1]);

			$tablearray=explode(',',$backupinfoarray[4]);
 
			$Rows=$this->IsSQL($value);
			
			if($Rows){
					
					$this->WriteFile($filedir.'/'.$backupinfoarray[2].'_'.$Number.'.sql','');
					
					$NowRows=intval(@ceil($Rows/$DataRows));
					
					if($NowRows){
						 $fornum=$NowRows;
					}else{
						 $fornum=1;
					}
					
			
					if(!$RowSQL){
						$RowSQL=intval($backupinfoarray[0]);
					}
					
					$filelen=0;
					
					
					$nextbackup=0;
					

					for($i=0;$i<$fornum;$i++){

						  $StartRows=($i*$DataRows)+$RowSQL;
						  
						  $this->DataList.=$this->GetMakeMysqlDataList($value,$StartRows,$DataRows);
						  
						  $filelen=iconv_strlen($this->DataList,S_CHARSET);
						  
						  if($filelen>=(intval($backupinfoarray[3])*1024)){
							  
								 $backupinfo=$StartRows+$DataRows.'|'.$backupinfoarray[1].'|'.$backupinfoarray[2].'|'.$backupinfoarray[3].'|'.$backupinfoarray[4];
									   
								 $this->WriteFile(S_BACKUP_DIR.'/backup_'.$times.'.txt',$backupinfo);
								 
								 $nextbackup=1;
								 
								 break;
						  }
					}
					
					if($nextbackup){

						 return true;
					
					}else{
						
						 return false;
					
					}
					  
			 }else{
				   return false;
			 }
			 
	}
					  
	
	
	public function GetMakeMysqlDataList($tablename,$StartRows,$DataRows){
		
			 $tabledataarray=$this->MysqlFetchArray("SELECT * FROM ".$this->GetTable($tablename)." LIMIT $StartRows,$DataRows");
				
		     if($tabledataarray){
					
				   return $this->MakeMysqlInsert($tabledataarray,$tablename);

			 }else{
				 
				   return false;
			 }

	}
	
	
	
	public function NextBackupName($Number,$backupinfoarray){
		
			$nowtable=str_replace(DB_TNAME,'',$backupinfoarray[1]);
			
			$tablearray=explode(',',$backupinfoarray[4]);
		    
			$times =@date("Ymd");
			
			$newtable='';
			foreach($tablearray as $key=>$value){
		
				    if($value==(DB_TNAME.$nowtable)){
						  $id=$key+1;
						  $newtable=@$tablearray[$id];
					}
				
			}

			if(!empty($newtable)){
			     
				  $backupinfo='0|'.$newtable.'|'.$backupinfoarray[2].'|'.$backupinfoarray[3].'|'.$backupinfoarray[4];

				  $this->WriteFile(S_BACKUP_DIR.'/backup_'.$times.'.txt',$backupinfo);
				
			}else{
				  $this->DelFile(S_BACKUP_DIR.'/backup_'.$times.'.txt');
			}
		    
	}
	
	
	
	public function RestoreData($backupfile,$Number=1,$backupdate='',$backupselect=''){

		   set_time_limit(0);
		   
		   if($Number==1){
		   
		          $backupname=S_BACKUP_DIR.'/'.$backupdate.'/'.$backupselect.'_0.sql';
		             
				  $backupcontent=$this->FileGetContents($backupname);
					 
				  if($backupcontent){
							  
						 $sql = str_replace("\r", "\n", $backupcontent);
						 $contents= explode(";\n",trim($sql));
						 
						 foreach($contents as $value){
							   if($value){
									  $this->MysqlQuery($value);
							   }
						 }
				  }
		   
		   }
           
		   if(file_exists($backupfile)){
			   
				   $backupcontent=$this->FileGetContents($backupfile);
				   
			
				   if($backupcontent){
						 
						  
						  if($Number){
							    
								$contents=explode('INSERT INTO',$backupcontent);

								foreach($contents as $value){
									 if($value){
											$this->MysqlQuery('INSERT INTO '.$value);
									 }
								}

								return $Number+=1;
						  
						  }else{
							  
							   return 'ok';
						  }
		
				   }else{
					   
						 return 'ok';
					   
				   }
				   
		   }else{
			   
			     return 'ok';
		   }
		   
		   
	}

	 
}

 
?>