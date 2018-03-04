<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class MemberVIPManageControls extends PHPAPP{
	
    public $actionmenu,$POST,$GET;
	
	function __construct($actionmenu=''){	
           
		   parent::__construct();
		   
	       $this->actionmenu=$actionmenu;
		   
		   $postkey=array('Submit'=>'');
		   
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
				 
				 if($this->Delete('member_vip'," WHERE uid IN($ids)")){
				
					  $refresh= $this->LanguageArray('phpapp','Delete_successfully');			   
				 
				 }else{
					  $refresh= $this->LanguageArray('phpapp','Delete_failed');
							   
				 }
			     
				 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
		  
		  }else{
			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		  
		         $orderarr=array(
						  array('order'=>'a.uid','name'=>'UID'),
						  array('order'=>'b.username','name'=>'用户名'),
						  array('order'=>'a.price','name'=>'消费金额'),
						  array('order'=>'a.status','name'=>'状态'),
						  array('order'=>'a.dateline','name'=>'认证时间')
						  );
          
		         $order='ORDER BY a.uid DESC';
		  
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
		 

		         $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.username FROM  ".$this->GetTable('member_vip')." AS a JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid $order");

                 $list=$ajaxpage->ShowResult();
   
		  
		         include $this->Template('list_manage');
		  }
	}
	
	
	
	function ConfigAction(){
		
		    $membertypearr=$this->GetMysqlArray('*'," ".$this->GetTable('member_type')." WHERE status_phpapp=0 "); 
			
		    if($this->POST['Submit']){
                    

					$submitusergroup=array();
					
					if($_POST['usergroup']){
						
							foreach($_POST['usergroup'] as $key=>$usergroup){
								 
								  foreach($usergroup as $keys=>$value){
									  
								           if(!empty($value['gid'])){
											   
											      $submitusergroup[$key][$keys]=$value;
										   }
								  
								  }
								
							}

					}
					
				    $this->POST['membervip']=serialize($submitusergroup);
				
				    $this->SetConfig($this->POST);
				
			}else{ 
			         
					$membervipset=$nowusergroup=array();
					 
			        if(PHPAPP::$config['membervip']){
						   $membervipset=unserialize(PHPAPP::$config['membervip']);
					}

			       include $this->Template('config_manage');
			
			}
	}
	
	
	
	public function MemberVipDscriptionAction(){
		
		   if($this->POST['Submit']){
		   
		          $this->SetConfig($this->POST);
		   
		   }else{
		
		          include $this->Template('dscription_manage');
		   
		   }
		   
		   
	}
	
	
}


?>