<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class MemberHomeManageControls extends PHPAPP{
	
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

			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		  
		         $orderarr=array(
								  array('order'=>'a.id_phpapp','name'=>'ID'),
								  array('order'=>'b.name_phpapp','name'=>'所属模块'),
								  array('order'=>'a.block_phpapp','name'=>'名称'),
								  array('order'=>'a.key_phpapp','name'=>'显示数或ID'),
								  array('order'=>'a.status_phpapp','name'=>'状态'),
								  );
				  
				 $order='ORDER BY a.id_phpapp ASC';
		  
				 $this->GET['iforder']=empty($this->GET['iforder']) ? 1 : $this->GET['iforder'];
 
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

				 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.label_phpapp FROM ".$this->GetTable('getdata')." AS a LEFT JOIN ".$this->GetTable('templateblock')." AS b ON a.block_phpapp=b.id_phpapp WHERE b.apps_phpapp='$this->app' $order");

				 $list=$ajaxpage->ShowResult();
				 
		         include $this->Template('list_manage');
		 
	}

	
}


?>