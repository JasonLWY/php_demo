<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(Core.'/class/zip_class_phpapp.php');

class MakeApplication extends PHPAPP{
	
    public $error,$app,$filename,$tablenum=0,$tablearray,$lang;
	

	function __construct(){
		
             parent::__construct();

	}
	
	
	function Configure($parameter=array()){
		
		   //Ӧ��
		   $param=0;
		   if($parameter['app']>0){
			   
			    $this->app=$parameter['app'];
				
			    $param+=1;
				
		   }else{
                
				$this->error['app']='Ӧ��ID������!';

		   }
		   
		   
		   
		   //�ļ���
		   $char=new CharFilter($parameter['filename']);
		   
		   if($char->IsABC()){
			    
				$this->filename=$parameter['filename'];
				
			    $param+=1;
				
		   }else{
                
				$this->error['filename']='�ļ�����д����!';

		   }
		   
		   //��
		   if($parameter['table']){
			      
				  $this->tablearray=explode('\r\n',$parameter['table']);
				  
				  $this->tablenum=count($this->tablearray);
				  
				  foreach($this->tablearray as $value){
					     
						 if($this->IsMysqlTableName($value)){
							 
							   $param+=1;
							 
						 }else{
							  
							   $this->error['table']=$value.'������!';
							 
						 }
						 
					
				  }
				
		   }
		   
		   
		   return $param;
		
	}
	
	function Make($parameter=array()){
		   
            $zip=new ZIP();
			
            if($this->Configure($parameter)==(2+$this->tablenum)){
				
				  
				  $apparr=$this->GetMysqlOne('*'," ".$this->GetTable('apps')." WHERE id_phpapp='$this->app'");
				  

				  if($apparr['dir_phpapp']){

						  $dir=SYS.'/apps/'.$apparr['dir_phpapp'];
						  
						  $templatedir=SYS.'/templates/'.S_TEMPLATE.'/'.PHPAPP::$config['templatepath'].'/'.$apparr['dir_phpapp'];
						  $styledir=SYS.'/templates/'.S_TEMPLATE.'/style/'.PHPAPP::$config['stylepath'].'/'.$apparr['dir_phpapp'];
						  
						  $makedir=SYS.'/data/make';
						  
						  $tablefile=$makedir.'/'.$apparr['dir_phpapp'].'/phpapp_table.sql';
						  
						  $tableadminfile=$makedir.'/'.$apparr['dir_phpapp'].'/phpapp_admin.sql';
						  
						  $tableactionfile=$makedir.'/'.$apparr['dir_phpapp'].'/phpapp_action.sql';
						  
						  $tableconfigfile=$makedir.'/'.$apparr['dir_phpapp'].'/phpapp_config.sql';
						  
						  $tabledatafile=$makedir.'/'.$apparr['dir_phpapp'].'/phpapp_data.sql';
						  
						  $appfile=$makedir.'/'.$apparr['dir_phpapp'].'/phpapp_apps.sql';
						  
						  
						  //�ļ���---------------------------------------------------------------
						  
						  if(is_dir($dir)){
							      
								  if(!is_dir($makedir.'/'.$apparr['dir_phpapp'])){
								         mkdir($makedir.'/'.$apparr['dir_phpapp'],0777);
								  }
								  
								  if(!is_dir($makedir.'/'.$apparr['dir_phpapp'].'/phpapp_code')){
								         mkdir($makedir.'/'.$apparr['dir_phpapp'].'/phpapp_code',0777);
								  }
								  
								  if(!is_dir($makedir.'/'.$apparr['dir_phpapp'].'/phpapp_template')){
								         mkdir($makedir.'/'.$apparr['dir_phpapp'].'/phpapp_template',0777);
								  }
								  
								  if(!is_dir($makedir.'/'.$apparr['dir_phpapp'].'/phpapp_style')){
								         mkdir($makedir.'/'.$apparr['dir_phpapp'].'/phpapp_style',0777);
								  }
								  
								  
                                  $this->CopyFile(SYS.'/apps/'.$apparr['dir_phpapp'],$makedir.'/'.$apparr['dir_phpapp'].'/phpapp_code');
								  
								  if(is_dir($templatedir)){
									    $this->CopyFile($templatedir,$makedir.'/'.$apparr['dir_phpapp'].'/phpapp_template');
								  }
								  
								  if(is_dir($styledir)){
									    $this->CopyFile($styledir,$makedir.'/'.$apparr['dir_phpapp'].'/phpapp_style');
								  }
						  
						  }
						
						  
						  //��-----------------------------------------------------------------------
						  if($this->tablearray){
								foreach($this->tablearray as $value){
									
										$tableinfo=$this->ShowMysqlTable($value);
		  
										$droptable='DROP TABLE IF EXISTS '.$value.';'."\n";
										
										$table=preg_replace("/AUTO_INCREMENT=(.*)/",'',$tableinfo[0]['Create Table']);
										
										$table=preg_replace("/DEFAULT CHARSET=(\w)+/",'',$table);
										
										$table=str_replace(DB_TNAME,'phpapp_',$table);
										
										$droptable=str_replace(DB_TNAME,'phpapp_',$droptable);
										
										if($openwrite = @fopen($tablefile,"a")){
											  fwrite($openwrite,$droptable.$table.';'."\n");
											  fclose($openwrite);
										}
								
								}
						  }
						  
				
						  
						  //������-----------------------------------------------------------------------
						  
						  $makedata=$this->MakeMysqlInsert($this->GetMysqlArray('*'," ".$this->GetTable('apps')." WHERE id_phpapp='$this->app'"),'apps','id_phpapp');
						  
						  if($makedata){
								if($openwrite = @fopen($appfile,"a")){
										fwrite($openwrite,$makedata."\n");
										fclose($openwrite);
								}
						  }
						  
						  //$makedata=$this->MakeMysqlInsert($this->GetMysqlArray('*'," ".$this->GetTable('admin_menu')." WHERE apps_phpapp='$this->app'"),'admin_menu','catid_phpapp');
						  $makedata=$this->MakeMysqlInsert($this->GetMysqlArray('*'," ".$this->GetTable('admin_menu')." WHERE apps_phpapp='$this->app'"),'admin_menu');
						  
						  if($makedata){
								if($openwrite = @fopen($tableadminfile,"a")){
										fwrite($openwrite,$makedata."\n");
										fclose($openwrite);
								}
						  }
						  
						  $makedata=$this->MakeMysqlInsert($this->GetMysqlArray('*'," ".$this->GetTable('apps_action')." WHERE apps_phpapp='$this->app'"),'apps_action','id_phpapp');
						  
						  if($makedata){
								if($openwrite = @fopen($tableactionfile,"a")){
										fwrite($openwrite,$makedata."\n");
										fclose($openwrite);
								}
						  }
		   
		   
		                  $makedata=$this->MakeMysqlInsert($this->GetMysqlArray('*'," ".$this->GetTable('config')." WHERE app_phpapp='$this->app'"),'config','id_phpapp');
						  
						  if($makedata){
								if($openwrite = @fopen($tableconfigfile,"a")){
										fwrite($openwrite,$makedata."\n");
										fclose($openwrite);
								}
						  }
		   
						  
						  if($parameter['tabledata']){
		                          
								  if($openwrite = @fopen($tabledatafile,"a")){
									    fwrite($openwrite,str_replace(DB_TNAME,'phpapp_',$parameter['tabledata']));
									    fclose($openwrite);
								  }
		   
		                  }
						  
						  
//AD
$readme='PHPAPP����ϵͳ���
+----------------------------------+
PHPAPP ȫ���׼�Ԥ�ȵ���վ����Ӧ��ϵͳ��
PHPAPP ȫ����վӦ�õĿ�����,����ϵͳ���ĳ����ṩ�ḻ��վӦ�ó���
רΪվ����ҵ����ӯ��Ӧ�á�
+----------------------------------+

 PHPAPP�ٷ���վ
+----------------------------------+
http://www.phpapp.cn/
+----------------------------------+

 ��Ӧ�ÿ����߼��
+----------------------------------+
'.$apparr['developer_phpapp'].'
+----------------------------------+

 Ӧ�ð汾��
+----------------------------------+
'.$apparr['version_phpapp'].'
+----------------------------------+

 Ӧ������ʱ��
+----------------------------------+
'.$this->Date('Y-m-d H:i:s',$this->NowTime()).'
+----------------------------------+';
	
	
                         
						  $this->WriteFile($makedir.'/'.$apparr['dir_phpapp'].'/readme.txt',$readme);
						  
						  
						  
//install.php
$phpappcopy=$this->Date("Y",$this->NowTime());
$makedate=$this->Date("Y.m.d",$this->NowTime());
$installfile='<?php
/*
	EDOOG.COM (C) 2006-'.$phpappcopy.' EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V'.$apparr['version_phpapp'].' '.$makedate.'
*/	

//Powered by PHPAPP.CN (C) 2006-'.$phpappcopy.' PHPAPP Inc.

$INSTALL_CODE=\'PHPAPP\';

//������
$INSTALL_DEVELOPER=\''.$apparr['developer_phpapp'].'\';

//�汾��
$INSTALL_VERSION=\''.$apparr['version_phpapp'].'\';

//1 ��װӦ�� 2����Ӧ��
$INSTALL_TYPE=1;

//�ڲ�ʶ��ID  ����Ӧ�ð��õ�
$INSTALL_INTERNAL_ID='.$apparr['internal_phpapp'].';

//��������
$INSTALL_NAME=\''.$apparr['name_phpapp'].'\';

//����Ӧ�ð���Ҫ�� 0 һ�� 1 ��Ҫ
$INSTALL_REQUIRED=0;

//��װģ����  
$INSTALL_STYLE=\''.S_TEMPLATE.'\';

//��װ����Ŀ¼  
$INSTALL_LANGUAGE=\''.PHPAPP::$config['templatepath'].'\';

?>';



						  
						  $this->WriteFile($makedir.'/'.$apparr['dir_phpapp'].'/install.php',$installfile);
						  
						  
						  //ZipAll -----------------------------------------------------------
						  
						  $zip->ZipCompression(SYS.'/data/make/'.$parameter['filename'].'.zip',$makedir.'/'.$apparr['dir_phpapp']);
						  
						  $this->DeleteDir($makedir.'/'.$apparr['dir_phpapp']);
						  
					  
				  }
				
				  return 'ok';

			}else{
				
				  return $this->error;
				
			}
 
	}
	
	function AddApplication($parameter=array()){
		
		
		  $appdir=SYS.'/apps/'.$parameter['dir_phpapp'];
		  
		  $templatedir=SYS.'/templates/'.S_TEMPLATE.'/'.PHPAPP::$config['templatepath'].'/'.$parameter['dir_phpapp'];
		  
		  $styledir=SYS.'/templates/'.S_TEMPLATE.'/style/'.PHPAPP::$config['stylepath'].'/'.$parameter['dir_phpapp'];
						  
		  if(!is_dir($appdir)){
				 mkdir($appdir,0777);
		  }
		  
		  if(!is_dir($templatedir)){
				 mkdir($templatedir,0777);
		  }
		  
		  if(!is_dir($styledir)){
				 mkdir($styledir,0777);
		  }
		  
$phpappcopy=$this->Date("Y",$this->NowTime());		  
$makeappdata='<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

//Powered by PHPAPP.CN (C) 2009-'.$phpappcopy.' PHPAPP Inc.

if(!defined(\'IN_PHPAPP\')) {
	exit(\'Data error\');
}

class '.$parameter['class_phpapp'].'MainControls extends PHPAPP{

	  function __construct(){	
	  
	  }
	  
	  function DefaultAction(){

		     include $this->Template(\'default\');
	  }
	  
}

?>';

						  
			 $this->WriteFile($appdir.'/main_phpapp.php',$makeappdata);
			 
			 
			 
$makeapptemplate='{template phpapp:header}


<p>��ϲ��! '.$parameter['class_phpapp'].'Ӧ�����ɳɹ���! ��ǰΪ default.htm ģ������дHTML����</p>

<p>����Ŀ¼λ�� /phpapp/apps/'.$parameter['dir_phpapp'].'</p>

<p>ģ��Ŀ¼λ�� /phpapp/templates/'.S_TEMPLATE.'/'.PHPAPP::$config['templatepath'].'/'.$parameter['dir_phpapp'].'</p>

<p>��ʽĿ¼λ�� /phpapp/templates/'.S_TEMPLATE.'/style/'.PHPAPP::$config['stylepath'].'/'.$parameter['dir_phpapp'].'</p>


<p>�����ļ�����</p>

<p>admin_phpapp.php Ϊ��̨�����ļ�</p>

<p>main_phpapp.php Ϊǰ̨�����ļ�</p>

<p>member_phpapp.php Ϊ��Ա�������ĳ����ļ�</p>

<p>space_phpapp.php Ϊ��Ա�ռ�����ļ�</p>

<p><strong>Ӧ����Ҫ������4���ļ����п���</strong></p>

<p>���࿪���̳����ĵ���鿴PHPAPP�ٷ����� <a href="http://bbs.phpapp.cn/forum-21-1.html" target="_blank">http://bbs.phpapp.cn/forum-21-1.html</a></p>

{template phpapp:footer}'; 
			 
		    $this->WriteFile($templatedir.'/default.htm',$makeapptemplate);
			$this->WriteFile($styledir.'/'.$parameter['dir_phpapp'].'.css','/* '.$parameter['dir_phpapp'].' style */');
			
			$newid=$this->Insert('apps',$parameter,array());
			
			$this->UpdateApps();
			
			
			return $newid;
			
		   
	}
	
}


?>