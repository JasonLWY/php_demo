<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class CreditManageControls extends PHPAPP{
	
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
		
		  return $this->CreditListAction();
	}
	
	
	function CreditListAction(){
		
		   
		  if(!empty($this->POST['Submit'])){
			  
			   $ids=$this->GetCheckBox($this->POST['checkbox']);

			   if($this->Delete('apps_credit'," WHERE id_phpapp IN($ids)")){
			  
			        $refresh='<p>删除积分成功！</p>';
							 
			   }else{
				    $refresh='<p>删除积分失败！</p>';	 
			        
			   }
			  
			   echo $this->Refresh($refresh,$this->MakeGetParameterURL());

		  }else{
			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		  
		         $orderarr=array(
						  array('order'=>'a.id_phpapp','name'=>'ID'),
						  array('order'=>'c.id_phpapp','name'=>'所属应用'),
						  array('order'=>'a.name_phpapp','name'=>'积分名称'),
						  array('order'=>'a.usergroup_phpapp','name'=>'前台用户组'),
						  array('order'=>'a.number_phpapp','name'=>'每日奖励次数'),
						  array('order'=>'a.credit_phpapp','name'=>'积分'),
						  array('order'=>'a.status_phpapp','name'=>'状态')
						  );
          
		         $order='ORDER BY a.id_phpapp DESC';
		  
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
		 

		         $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.groupname,c.id_phpapp AS appid,c.name_phpapp AS appname FROM  (".$this->GetTable('apps_credit')." AS a LEFT JOIN ".$this->GetTable('usergroup')." AS b ON a.usergroup_phpapp=b.gid) LEFT JOIN ".$this->GetTable('apps')." AS c ON a.apps_phpapp=c.id_phpapp $order");

                 $pointslist=$ajaxpage->ShowResult();
   
		  
		         include $this->Template('show_manage');
		  }
	}
	
	
	function AddCreditAction(){
		

		 if(!empty($this->POST['Submit'])) {
	
				$appid=$this->POST['apps_phpapp'];
				
				$acid=$this->POST['action_phpapp'];
				
				$usergroup=$this->POST['usergroup_phpapp'];
		
				if($this->IsSQL('apps_credit',"WHERE apps_phpapp='$appid' AND action_phpapp='$acid' AND usergroup_phpapp='$usergroup'")){
					

					    echo $this->Refresh('<p>对不起！该应用积分您已经添加过了！</p>',$this->MakeGetParameterURL());
				
				}else{
					
						$newid=$this->Insert('apps_credit',$this->POST,array());
				
						if($newid>0){
							
							 echo $this->Refresh('<p>添加应用积分成功！</p>',$this->MakeGetParameterURL());
							 
						}else{

							 echo $this->Refresh('<p>添加应用积分失败！</p>',$this->MakeGetParameterURL());
						}
				}
			
		 }else{
			   
			    //用户组
				$usergrouparr=$this->GetMysqlArray('*',$this->GetTable('usergroup'));
				
                $appsarr=$this->GetMysqlArray('id_phpapp,name_phpapp'," ".$this->GetTable('apps')."");
			    
		        include $this->Template('add_manage');
		 }
		 
		 
		
	}
	
	
	function EditCreditAction(){
		

		 if(!empty($this->POST['Submit'])) {
			  
			   $id=$this->GET['id'];
			   
			   $appid=$this->POST['apps_phpapp'];
				
			   $acid=$this->POST['action_phpapp'];
				
			   $usergroup=$this->POST['usergroup_phpapp'];
			 
			   if($this->IsSQL('apps_credit',"WHERE apps_phpapp='$appid' AND action_phpapp='$acid' AND usergroup_phpapp='$usergroup'") >1){
					 
					 echo $this->Refresh('<p>对不起！该应用积分相同！</p>',$this->MakeGetParameterURL());
					 
			   }else{
			 
			   	     $yes=$this->Update('apps_credit',$this->POST,array(),"WHERE id_phpapp='$id'");
			   
			  		 if($yes){
		
							echo $this->Refresh('<p>修改应用积分成功！</p>',$this->MakeGetParameterURL());
			   		 }else{

							echo $this->Refresh('<p>修改应用积分失败！</p>',$this->MakeGetParameterURL());
			   		 }
			   }
			
		 }else{
		 
		 		 $id=$this->GET['id'];
		 	
		 		 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('apps_credit')." WHERE id_phpapp='$id'");
				 
		 		 $gid=$manage['usergroup_phpapp'];
				 
				 $appid=$manage['apps_phpapp'];
		 
		 		 $usergrouparr=$this->GetMysqlArray('*',$this->GetTable('usergroup'));
				 
				 $appsarr=$this->GetMysqlArray('id_phpapp,name_phpapp'," ".$this->GetTable('apps')."");

				 include $this->Template('add_manage');
		 }
	}
	
	
	public function GetPhpappActionID($appid=0,$ac=0){
		 
		   if($appid){
			    $wheresql=" WHERE apps_phpapp='$appid' AND type_phpapp!=1 ";
		   }else{
			    $wheresql=' WHERE type_phpapp!=1 ';
		   }
		   
		   $actionarr=$this->GetMysqlArray('id_phpapp,aid_phpapp,apps_phpapp,name_phpapp'," ".$this->GetTable('apps_action')." $wheresql ");
		   
		   $actionlist='';
		   
		   if($actionarr){
			   
			     foreach($actionarr as $value){
					 
						if($value['aid_phpapp']==$ac){
							  $selected=' selected="selected"';
						}else{
							  $selected='';
						}
					    
						$actionlist.='<option value="'.$value['aid_phpapp'].'"'.$selected.'>'.$value['name_phpapp'].'</option>';
					    
				 }
			   
		   }else{
			     
				 $actionlist='<option value="0">无</option>';
			   
		   }
		   
		   return $actionlist;
		
	}
	
}


?>