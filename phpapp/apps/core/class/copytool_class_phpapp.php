<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class CopyTools extends PHPAPP{

	
	function __construct(){

	}

	function MakeCopyCategory($catidarray=array(),$appsarray=array()){


		   foreach($catidarray as $catid){
		   
				 $categoryarray=$this->GetMysqlArray('*',"".$this->GetTable('category')." WHERE catid='$catid' ");
				 
				 
				 $insertarray=$this->MakeMysqlInsert($categoryarray,'category','catid');
				 
				 
				 if($insertarray && $categoryarray){
					 
									  
						  foreach($appsarray as $appid){
							  
							  
								 $this->MysqlQuery($insertarray);
								 $cid=mysql_insert_id();
								 
								 $this->Update('category',array('type'=>$appid),array()," WHERE catid='$cid'");
								 
								 //二级
								 $categoryarray2=$this->GetMysqlArray('*',"".$this->GetTable('category')." WHERE upid='$catid' ");
								 
								 if($categoryarray2){
									 
									 
									 
									     foreach($categoryarray2 as $category2){
											 
											       $nowcategoryarray2=$this->GetMysqlArray('*',"".$this->GetTable('category')." WHERE catid='$category2[catid]' ");
												   
												   $insertarray2=$this->MakeMysqlInsert($nowcategoryarray2,'category','catid');
												
												
												   $this->MysqlQuery($insertarray2);
												   
												   $cid2=mysql_insert_id();
												   
												   $this->Update('category',array('type'=>$appid,'upid'=>$cid),array()," WHERE catid='$cid2'");
												
												
		                                           //三级
												   $nowcategoryarray3=$this->GetMysqlArray('*',"".$this->GetTable('category')." WHERE upid='$category2[catid]' ");
												   
												   $insertarray3=$this->MakeMysqlInsert($nowcategoryarray3,'category','catid');
												   

												   preg_match_all('/INSERT INTO (.*)\)\;\n|INSERT INTO (.*)\)\;/isU',$insertarray3,$DataSqlArray3);
											   
												   if($DataSqlArray3){
				  
														   foreach($DataSqlArray3[0] as $query3){
															   
			
																	$this->MysqlQuery($query3);
																	$cid3=mysql_insert_id();
		  
																	$this->Update('category',array('type'=>$appid,'upid'=>$cid2),array()," WHERE catid='$cid3'");
		   
														   }
									  
												   }
												  
											 
										 }
										 
										 
								 }
								 
								 
						  }				   
								   
				 }
		   }
		   

	}
	
	
	function MakeCopyUsergroup($newtable='',$gid='',$usergrouparray=array()){
		    
			 
			 if($newtable && $gid){
				   
				   $taskusergroup=$this->GetMysqlArray('*',"".$this->GetTable($newtable)." WHERE gid='$gid' ");
				 
				   foreach($usergrouparray as $value){
					     
						  if($this->IsSQL($newtable," WHERE gid='$value' ")){ 
						        $this->Delete($newtable," WHERE gid='$value' ");
						  }
						  
						  
						  $insertarray=$this->MakeMysqlInsert($taskusergroup,$newtable,'',array('gid'=>$value));
						  
						  $this->MysqlQuery($insertarray);
				  
				   
				   }
				 
			 }

	}
	
	
	function MakeCopyPort($tablename='',$portarray=array(),$appsarray=array()){
		 
		    if($tablename && $portarray){
				     
					 $portval='';
					 
				     foreach($portarray as $value){
						    
							if($portval){
							     
								  $portval.=','.$value;
								  
							}else{
								
								  $portval=$value;
								  
							}
						 
					 }
			
			         $portconfigarray=$this->GetMysqlArray('*',"".$this->GetTable($tablename)." WHERE id_phpapp IN($portval) ");
					 
			         foreach($appsarray as $value){
					     
							
							$insertarray=$this->MakeMysqlInsert($portconfigarray,$tablename,'id_phpapp',array('apps_phpapp'=>$value));
							
							preg_match_all('/INSERT INTO (.*)\)\;\n|INSERT INTO (.*)\)\;/isU',$insertarray,$DataSqlArray);
							
							
							if($DataSqlArray){
				  
								   foreach($DataSqlArray[0] as $query){
									   
											$this->MysqlQuery($query);
											
								   }
			  
						    }

				   
				    }
			

			}
			
		
	}
	
	 
}
 
?>