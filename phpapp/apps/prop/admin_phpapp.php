<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class PropManageControls extends PHPAPP{
	
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
		
		  return $this->PropListAction();
	}
	
	
	function PropListAction(){
		
		   
		  if(!empty($this->POST['Submit'])){

               $ids=$this->GetCheckBox($this->POST['checkbox']);
			   
			   if($this->Delete('prop'," WHERE sid IN($ids)")){
			  
			        $refresh= $this->LanguageArray('phpapp','Delete_successfully');

			   }else{
				    $refresh= $this->LanguageArray('phpapp','Delete_failed');

			   }
			   
			   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			  
		  
		  }else{
			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		  
		         $orderarr=array(
						  array('order'=>'a.sid','name'=>'ID'),
						  array('order'=>'a.appid','name'=>'应用ID'),
						  array('order'=>'b.gid','name'=>'所属组'),
						  array('order'=>'a.subject','name'=>'名称'),
						  array('order'=>'a.price','name'=>'出售价格'),
						  array('order'=>'a.day','name'=>'过期天数'),
						  //array('order'=>'a.count','name'=>'数目参与'),
						  array('order'=>'a.content','name'=>'介绍'),
						  array('order'=>'a.icon','name'=>'LOGO'),
						  array('order'=>'a.displayorder','name'=>'排序'),
						  array('order'=>'a.status','name'=>'状态'),
						  array('order'=>'a.sell','name'=>'是否出售'),
						  array('order'=>'a.type','name'=>'类型')
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
		 

		         $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.* FROM  ".$this->GetTable('prop')." AS a LEFT JOIN ".$this->GetTable('usergroup')." AS b ON a.usergroup=b.gid $order");

                 $list=$ajaxpage->ShowResult();
   
		  
		         include $this->Template('show_manage');
		  }
	}
	
	function EditPropAction(){
		
		  $id=$this->GET['id'];
				  
		  if($this->POST['Submit']){
				
				if($id>0){
					 
					  $this->Update('prop',$this->POST,array()," WHERE sid='$id'");
					  
					  echo $this->Refresh($this->LanguageArray('phpapp','Edited_successfully'),$this->MakeGetParameterURL());
						
					  exit();
					  
				}
			  
		  }else{
				if($id>0){
					 $appsarr=$this->GetMysqlArray('id_phpapp,name_phpapp'," ".$this->GetTable('apps')." WHERE id_phpapp>50");
					 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('prop')." WHERE sid='$id'");
					 $usergrouparr=$this->GetMysqlArray('*'," ".$this->GetTable('usergroup')."");
				}else{
					 $manage='';
				}
		  }
				  
				  
		  include $this->Template('add_manage');
	
	}
	
	
	function AddAction(){
		   
		   if($this->POST['Submit']){
			     
	             $this->Insert('prop',$this->POST,array());

				 echo $this->Refresh($this->LanguageArray('phpapp','Add_success'),$this->MakeGetParameterURL());
				 	
				 exit();
				 
		   }else{
			     
				 $appsarr=$this->GetMysqlArray('id_phpapp,name_phpapp'," ".$this->GetTable('apps')." WHERE id_phpapp>50");
				  
			     $usergrouparr=$this->GetMysqlArray('*'," ".$this->GetTable('usergroup')."");
		   
		         include $this->Template('add_manage');
		   
		   }
		
	}
	
}


?>