<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include(Core.'/class/cache_class_phpapp.php');



//mysql
class MySQL extends MemoryCache{
	
    public $mysqlhost; 	
	
	
	function __construct(){
            
		  
	}
   
	 
	public function MysqlConnect(){
		
		 if(DB_CONNECT){
			   $this->mysqlhost = mysql_pconnect(DB_HOST,DB_USER,DB_PW);
		 }else{
			   $this->mysqlhost = mysql_connect(DB_HOST,DB_USER,DB_PW);
		 }
		 
		 
         if (!$this->mysqlhost) {
                die('Could not connect: '.mysql_error());
         }else{
			 
			 
			  if(DB_NAME) {
	
			        mysql_select_db(DB_NAME, $this->mysqlhost);
					
					mysql_query("SET names ".DB_CHARSET);
					
					mysql_query("SET sql_mode=''", $this->mysqlhost);
					 
		      }else{
				    die('Could not connect: dbname');
			  }

			 
			  
		 }
        
 
		
	}
	
	public function GetTable($name){
	      return DB_NAME.'.'.DB_TNAME.$name;
    }
	
	//默认----------------------------
	
	public function MysqlQuery($query){
		  
		  if(!$result=mysql_query($query)){
			   die(mysql_error());
		  }else{
			   
			   return $result;
		  }
  
	}
	
	
	public function MysqlFetchArray($result){
		
		 if($this->GetCache($result)){
	           return $this->GetCache($result);
		 }else{
		 
			  $mysqlarray=array();
			  
              $result=$this->MysqlQuery($result);

			   while ($fetch_array = mysql_fetch_array($result,MYSQL_ASSOC)) {
					 $mysqlarray[] = $fetch_array;
			  }
		  
		      $this->AddCache($result,$mysqlarray,0);
		   
		      return $mysqlarray;
		 }
	}
	
	
	
	public function GetMysqlFieldArray($tablename=''){
          $tablename=$this->GetTable($tablename);
          $fieldarray=$this->getTableStructCache($tablename);//[SWH|+]
          if($fieldarray===false){//[SWH|+]
		    $result=$this->MysqlQuery('SELECT * FROM '.$tablename);
		  
		    $fieldnum=mysql_num_fields($result);
		  
		    $fieldarray=array();
		  
		    for($i=0;$i<$fieldnum;$i++){
			   $fieldname=mysql_field_name($result,$i);
		       $fieldarray[$fieldname]=mysql_field_type($result,$i);
		    }
            $this->mkTableStructCache($tablename,$fieldarray);//[SWH|+]
          }//[SWH|+]
          
		  return $fieldarray;
	}
	
	public function GetMysqlTableNameArray(){
          
		  $tnamelen=strlen(DB_TNAME);
		  
		  return $this->MysqlFetchArray('SHOW TABLE STATUS FROM '.DB_NAME.' WHERE "'.DB_TNAME.'"=substring(Name,1,'.$tnamelen.')');
		   
	}
	
	
	public function IsMysqlTableName($table=''){
          
		   $tnamelen=strlen(DB_TNAME);
		  
		   $result=$this->MysqlQuery('SHOW TABLE STATUS FROM '.DB_NAME.' WHERE Name=\''.$table.'\'');
		  
		   $num_rows = mysql_num_rows($result);
  
		   if($num_rows>0){ 
				  return $num_rows;
		   }else{
				  return false;
		   }
		   
	}
	
	
	public function ShowMysqlTable($table=''){
	
	        return $this->MysqlFetchArray("SHOW CREATE TABLE ".$table);
	}
	
	// 二维数组 | 表名 | 删除字段 | 替换值
	public function MakeMysqlInsert($tablearr=array(),$tablename,$dalete='',$replacearr=''){
		
		   if($tablearr){
		   
				$valuelist='';	
				
				foreach($tablearr as $value){	
				
					  $valuelist.='INSERT INTO '.DB_TNAME.$tablename.'(';
					  
					  $keydata='';
					  $valuedata='';
					  
					  foreach($value as $key=>$val){	
							  
							  if($dalete!=$key){
									  if($keydata){
											$keydata.=',`'.$key.'`';
									  }else{
											$keydata.='`'.$key.'`';
									  }
									  
									  if($replacearr){
										    
											foreach($replacearr as $keyre=>$valuere){
												   
												   if($key==$keyre){
													   
													     $val=$valuere;
														 
												   }
												
											}
									  }
									  
									  if($valuedata){
											$valuedata.=',\''.str_replace('INSERT INTO','insert into',str_replace("'",'&#039;',$val)).'\'';
									  }else{
											$valuedata.='\''.str_replace('INSERT INTO','insert into',str_replace("'",'&#039;',$val)).'\'';
									  }
							  }
					  }
					  
					  $valuelist.=$keydata.')VALUES('.$valuedata.');'."\n";

				}
					  
				unset($tablearr);   
				
				return $valuelist;

		  }else{
			  
			    return false;
		  }
		
		
	}
	
	
    //默认 end-----------------------
	
	
	//Create
	function Create($tablename,$field='',$engine='MyISAM'){
		
		   
		    $query='CREATE TABLE IF NOT EXISTS '.$tablename.' ('.$field;
															 
			$query.=')ENGINE='.$engine.';';												 
															 
		    return $this->MysqlQuery($query);
		
	}
	
    //[SWH|+]:
    function clearTableStructCache($tablename){
            $files=glob(SYS.'/data/cache/database/table_struct/*.php');
            if($files) foreach($files as $f){
                unlink($f);
            }
            /*
            $cachefile=SYS.'/data/cache/database/table_struct/'.$tablename.'.php';
		    if(file_exists($cachefile)){
                unlink($cachefile);
            }
            */
    }
    function getTableStructCache($tablename){
        //static $CACHE_S=array();
            $cachefile=SYS.'/data/cache/database/table_struct/'.$tablename.'.php';
		    if(file_exists($cachefile)){
               return include($cachefile);
            }else{
               return false;
            }
    }
    function mkTableStructCache($tablename,$array=array()){
            $cachefile=SYS.'/data/cache/database/table_struct/';
		    if(!is_dir($cachefile)){
               mkdir($cachefile,0777,true);
            }
            file_put_contents($cachefile.$tablename.'.php','<?php return '.var_export($array,true).';?>');
    }
    function dataTypeConvert($data,$type){
        switch($type){
            case 'int':
                $data=intval($data);
                break;
            case 'real':
                $data=doubleval($data);
                break;
            case 'timestamp':
                $data=intval($data);
                break;
            case 'string':
            case 'year':
            case 'date':
            case 'time':
            case 'datetime':
            case 'blob':
            default:
                //$data=intval($data);
                break;
        }
        return $data;
    }
    //[SWH|+];

	//DropTable
	
	function DropTable($tablename){
            $this->clearTableStructCache($tablename);
		    $query='DROP TABLE '.$tablename;
											 					 
		    return $this->MysqlQuery($query);
		
	}
	
	//DropTableField
	function DropTableField($tablename,$field){
            $this->clearTableStructCache($tablename);
	        $query='ALTER TABLE '.$tablename.' DROP '.$field;
			
	        return $this->MysqlQuery($query);
	}
	
	function AddTableField($query){
			return $this->MysqlQuery($query);
	}
	
	
	//Insert
	//表名, 插入数组,添加合并数组
	function Insert($tablename,$inserarr=array(),$addarr=array()){
		 
		 $inserarr=array_merge($inserarr,$addarr);
		 
		 $deletearr=$this->GetMysqlFieldArray($tablename);

	     $insertkey=$insertvalue='';
		 foreach($inserarr as $key=>$value){
			  $_key=strtolower($key);
			  if(isset($deletearr[$_key])){
				      if($insertkey){
						   $insertkey.=',`'.$_key.'`';
					  }else{
						   $insertkey.='(`'.$_key.'`';
					  }
					  $value=$this->dataTypeConvert($value,$deletearr[$_key]);
					  if($insertvalue){
						   $insertvalue.=',\''.$value.'\'';
					  }else{
						   $insertvalue.='(\''.$value.'\'';
					  }
			  }
		 }
			   
		 $indata=$insertkey.')VALUES'.$insertvalue.')';
			   
		 $sql=sprintf('INSERT INTO %s %s',$this->GetTable($tablename),$indata);
	
	     $this->MysqlQuery($sql);

	     return mysql_insert_id(); //自增ID返回值

			   
	}
	
	//表名, 修改数组,添加合并数组,条件
	function Update($tablename,$setarray=array(),$addarr=array(),$whereif=''){
		 
		 $setarray=array_merge($setarray,$addarr);
		 
		 $deletearr=$this->GetMysqlFieldArray($tablename);
		 
		 if($setarray){
			  $sqlset='';
			  foreach($setarray as $key=>$value){
			        $_key=strtolower($key);
				    if(isset($deletearr[$_key])){
				           $value=$this->dataTypeConvert($value,$deletearr[$_key]);
				    	   if($sqlset){
							    $sqlset.=',`'.$_key.'`=\''.$value.'\'';
						   }else{
							    $sqlset='`'.$_key.'`=\''.$value.'\'';
						   }
					
					}
			  }
			  
			  $query=sprintf('UPDATE %s SET %s %s',$this->GetTable($tablename),$sqlset,$whereif);
	          //exit($query);
			  return $this->MysqlQuery($query);
			  
		 }else{
			  return false;
		 }
	      
	}
	
	
	function Delete($tablename,$whereif=''){
		
		  $query=sprintf('DELETE FROM %s %s',$this->GetTable($tablename),$whereif);
		  return  $this->MysqlQuery($query);
		
	}
	
	//is sql
	function IsSQL($tablename,$whereif=''){
	
          $query=sprintf('SELECT * FROM %s %s',$this->GetTable($tablename),$whereif);
		  $result=$this->MysqlQuery($query);

           $num_rows = mysql_num_rows($result);

	       if($num_rows>0){ 
		          return $num_rows;
	       }else{
	              return false;
	       }
		 
     }
	 
	//读取单条数组
	public function GetMysqlOne($key='*',$whereif=''){
		  
	     $sqldata= array();
	  
	     $query=sprintf('SELECT %s FROM %s',$key,$whereif);

	     $sqldata=mysql_fetch_array($this->MysqlQuery($query),MYSQL_ASSOC);

	     if (is_array($sqldata)){ 
		       return $sqldata;
	     }else{
	           return false;
	     }

     }
	
	 
	 
	//读取整个数据数组
	public function GetMysqlArray($key='*',$whereif=''){
		 
		   $sqldata= array();
	  
		   $query=sprintf('SELECT %s FROM %s',$key,$whereif);

		   $sqldata=$this->MysqlFetchArray($query);
  
		   if (is_array($sqldata)){
				 
				 return $sqldata;
		   }else{
				 return false;
		   }
		

     }
	 
	 
	 public function ReadSiteLog($logfile=''){
		   
		   if($logfile){

				include_once($logfile);
				
				if($logarray){
					
					  return $logarray;
					  
				}else{
					  return false;
				}
		   }else{
			   
			    return false;
		   }
		 
	 }

     
	 public function WriteSiteLog($query=''){
		   
		   if(S_SITE_LOG){

				   $dir = gmdate('Ym');
				   $dir2 = gmdate('d');
				   $filedir=SYS.'/data/log/'.$dir;
				 
				   if(!is_dir($filedir)) {
						@mkdir($filedir,0777);
						$this->WriteFile($filedir.'/index.html','');
				   }
				   
				   $filedir.='/'.$dir2;
				   
				   if(!is_dir($filedir)) {
						@mkdir($filedir,0777);
						$this->WriteFile($filedir.'/index.html','');
				   }
				   
				   
				   if(!file_exists($filedir.'/'.gmdate('Ymd').'_1.php')){
						 $logfile=$filedir.'/'.gmdate('Ymd').'_1.php';
						 $this->MakeFileLog($logfile);
				   }else{
										   
						 $filenum=$this->ReadSysDir($filedir.'/');
							   
						 $lognum=count($filenum)-1;
						 
						 $logfilesize=filesize($filedir.'/'.gmdate('Ymd').'_'.$lognum.'.php');
				   
						 if($logfilesize>= intval(S_SITE_LOG_SIZE)){
  
							   $logfile=$filedir.'/'.gmdate('Ymd').'_'.($lognum+1).'.php';
							   
							   $this->MakeFileLog($logfile);
						 }else{
							   $logfile=$filedir.'/'.gmdate('Ymd').'_'.$lognum.'.php';
						 }
				   }

				   
				   $logarray="\n".'$logarray[]=array('."\n".'\'time\'=>\''.@date('Ymd H:i:s').'\','."\n".'\'uid\'=>'.intval($_SESSION['USER_USERID']).','."\n".'\'url\'=>\''.htmlspecialchars('http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"],ENT_QUOTES).'\','."\n".'\'ip\'=>\''.$this->GetClientIp().'\');'."\n";
				   
				   $fp=fopen($logfile,'a');
				   
				   fwrite($fp,$logarray);
				   
				   fclose($fp);

		   }
		   
		 
	 }
	 
	 public function MakeFileLog($logfile=''){
	 
	          if(!file_exists($logfile)){
						     
					$copylog="<?php
/*

  EDOOG.COM (C) 2009-".gmdate('Y')." EDOOG Inc.
  This is NOT a freeware, use is subject to license terms
  V2.0  2012.6.5
*/	 
if(!defined('IN_PHPAPP')){exit('Data error');}
?>"."\n"; 

					 $copylog.='<?php $logarray=array();'."\n";
						  
					 $this->WriteFile($logfile,$copylog);
						   
			 }
	 }
}

?>