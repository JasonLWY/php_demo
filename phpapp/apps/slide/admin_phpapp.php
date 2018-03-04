<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class SlideManageControls extends PHPAPP{
	
    private $actionmenu,$POST,$GET;
	
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
		  
		  if(!empty($this->POST['Submit'])){

               $ids=$this->GetCheckBox($this->POST['checkbox']);
  
			   if($this->Delete('slide'," WHERE sid IN($ids)")){
			  
			        $refresh= $this->LanguageArray('phpapp','Delete_successfully');

			   
			   }else{
				   
				    $refresh= $this->LanguageArray('phpapp','Delete_failed');
							 
			   }
			   
			   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
		  
		  }else{
			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		  
		         $orderarr=array(
						  array('order'=>'a.sid','name'=>'ID'),
						  array('order'=>'a.subject','name'=>'广告名称'),
						  array('order'=>'a.appid','name'=>'所属应用'),
						  array('order'=>'a.displayorder','name'=>'排序'),
						  array('order'=>'a.status','name'=>'状态')
						  );
          
		         $order='ORDER BY a.sid DESC';
		  
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
		 
	
		         $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.name_phpapp AS appname FROM  ".$this->GetTable('slide')." AS a JOIN ".$this->GetTable('apps')." AS b ON a.appid=b.id_phpapp $order");

                 $list=$ajaxpage->ShowResult();
   
		  
		         include $this->Template('list_manage');
		  }
	}
	
	
	function AddAction(){
		

		 if(!empty($this->POST['Submit'])) {
	
					  $newid=$this->Insert('slide',$this->POST,array());

					  if($newid>0){
						   $refresh= $this->LanguageArray('phpapp','Add_success');
						   
					  }else{
						   $refresh= $this->LanguageArray('phpapp','Add_failed');
					  }
	                 
					  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			
		 }else{
			   
				$appsarr=$this->GetMysqlArray('*',$this->GetTable('apps'));

		        include $this->Template('add_manage');
		 }
		 
		 
		
	}
	
	
	function EditAction(){
		
		 if(!empty($this->POST['Submit'])) {
			  
				 $id=$this->GET['id'];

				 $yes=$this->Update('slide',$this->POST,array(),"WHERE sid='$id'");
		   
				 if($yes){
						$refresh= $this->LanguageArray('phpapp','Edited_successfully');

				 }else{
						$refresh= $this->LanguageArray('phpapp','Edit_failure');
						
				 }
				 
				 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
		
			
		 }else{
		 
		 	     $id=$this->GET['id'];
		         
				 $appsarr=$this->GetMysqlArray('*',$this->GetTable('apps'));
				 
				 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('slide')." WHERE sid='$id'");

			     include $this->Template('add_manage');
		 }
	}
	
	
	
}


?>