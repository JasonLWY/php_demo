<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(Core.'/class/admin_class_phpapp.php');

class CaseManageControls extends PHPAPP{
	
    public $actionmenu,$POST,$GET;
	
	function __construct($actionmenu=''){	

           parent::__construct();

	       $this->actionmenu=$actionmenu;
		   
		   
		   $postkey=array('Submit'=>'','checkbox'=>'');
		   
		   $this->POST=$this->POSTArray();
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','action'));
		         
	}
	
	function DefaultAction(){
		
		  return $this->ListAction();
	}
	
	
	function ListAction(){
		  
		  //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(
															
														'subject'=>array('a.subject','search'), 
														'cid'=>array('a.cid','int')
															  
												      ) 
													  
													  
													  );
					 
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }
			   
			   
	      //select end----------------------------------------------------
			  
			  
		  if(!empty($this->POST['Submit'])){

               $ids=$this->GetCheckBox($this->POST['checkbox']);
  
			   if($this->Delete('case'," WHERE cid IN($ids)")){
			  
			        $refresh= $this->LanguageArray('phpapp','Delete_successfully');

			   
			   }else{
				   
				    $refresh= $this->LanguageArray('phpapp','Delete_failed');
							 
			   }
			   
			   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
		  
		  }else{
			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		  
		         $orderarr=array(
						  array('order'=>'a.cid','name'=>'ID'),
						  array('order'=>'a.subject','name'=>'名称'),
						  array('order'=>'a.catid','name'=>'所属分类')
						  );
          
		         $order='ORDER BY a.cid DESC';
		  
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
		 
	
		         $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.name AS typename FROM  ".$this->GetTable('case')." AS a LEFT JOIN ".$this->GetTable('category')." AS b ON a.catid=b.catid $wheresql $order");

                 $list=$ajaxpage->ShowResult();
   
		  
		         include $this->Template('list_manage');
		  }
	}
	
	
	function AddAction(){
		

		 if(!empty($this->POST['Submit'])) {
	                  
	                  
					  //封面
					  include_once(Core.'/class/photo_upload_phpapp.php');
  
	
					   if(!empty($_FILES['photo']['size'])){
							 if($_FILES['photo']['size']<PHPAPP::$config['oneimageuploadsize']){
					
								   $logoid=empty($manage['photo']) ? 0 : intval($manage['photo']);
								   
								   $upload=new UploadPhoto($_FILES['photo'],$logoid,$this->POST['width'],$this->POST['height']);
								   $logophoto=$upload->CheckUpload();
							 }else{
								 
								   $this->Refresh('对不起！图片不能超过'.intval(PHPAPP::$config['oneimageuploadsize']/1024).'KB!',$this->MakeGetParameterURL());
								   
								   exit();
							 }
							 
					   }else{

							   $this->Refresh('对不起！,请上传封面图片!',$this->MakeGetParameterURL());
							   
							   exit();

					   }
	         
					  $newid=$this->Insert('case',$this->POST,array('photo'=>$logophoto));
					  
					  $files=$this->UploadFile();
												 
					  if($files){
						   foreach($files as $fid){
								$this->Insert('apps_file',array('appid'=>$this->app,'fid'=>$fid,'uid'=>$this->uid,'id'=>$newid,'type'=>1),array());
						   }
						   
						   $this->ReplaceFileContent($files,'case',$this->POST['content']," WHERE cid='$newid' ");
					  }
					  

					  if($newid>0){
						   $refresh= $this->LanguageArray('phpapp','Add_success');
						   
					  }else{
						   $refresh= $this->LanguageArray('phpapp','Add_failed');
					  }
	                 
					  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			
		 }else{  
		

				$categoryarr=$this->GetMysqlArray('*'," ".$this->GetTable('category')." WHERE type='49'");
				
				if(!$categoryarr){
					 
					 echo $this->Refresh('请添加分类后操作!',$this->MakeGetParameterURL(array('action'=>1)));
					  
				}

		        include $this->Template('add_manage');
		 }
		 
		 
		
	}
	
	
	function EditAction(){
		
		 if(!empty($this->POST['Submit'])) {
			  
				 $id=$this->GET['id'];
				 
				 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('case')." WHERE cid='$id' ");
				 
				  //封面
				  include_once(Core.'/class/photo_upload_phpapp.php');


				   if(!empty($_FILES['photo']['size'])){
				
						 if($_FILES['photo']['size']<PHPAPP::$config['oneimageuploadsize']){
							  
							   $logoid=empty($manage['photo']) ? 0 : intval($manage['photo']);
							   
							   $upload=new UploadPhoto($_FILES['photo'],$logoid,$this->POST['width'],$this->POST['height']);
							   $logophoto=$upload->CheckUpload();
						 
						 }else{
								 
								$this->Refresh('对不起！,图片不能超过'.intval(PHPAPP::$config['oneimageuploadsize']/1024).'KB!',$this->MakeGetParameterURL());
								   
							    exit();
					     }
						 
				   }else{
						 
						 if(!empty($manage['photo'])){
							   
							   $logophoto=intval($manage['photo']);
							 
						 }else{
							 
							   $this->Refresh('对不起！,请上传封面图片!',$this->MakeGetParameterURL());
							   
							   exit();
							   
						 }
						
				   }
				   
				 $files=$this->UploadFile();
												 
				 if($files){
					   foreach($files as $fid){
							$this->Insert('apps_file',array('appid'=>$this->app,'fid'=>$fid,'uid'=>$this->uid,'id'=>$id,'type'=>1),array());
					   }
				 }

				 $yes=$this->Update('case',$this->POST,array('photo'=>$logophoto),"WHERE cid='$id'");
		   
				 if($yes){
						$refresh= $this->LanguageArray('phpapp','Edited_successfully');

				 }else{
						$refresh= $this->LanguageArray('phpapp','Edit_failure');
						
				 }
				 
				 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
		
			
		 }else{
		 
		 	     $id=$this->GET['id'];
		         
				 $appid=$this->GET['app'];
				 
				 $categoryarr=$this->GetMysqlArray('*'," ".$this->GetTable('category')." WHERE type='$appid'");
				 
				 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('case')." WHERE cid='$id'");

			     include $this->Template('add_manage');
		 }
	}
	
	
	
}


?>