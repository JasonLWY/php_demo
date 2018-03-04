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

class RealNamePersonalManageControls extends PHPAPP{
	
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
		    
			//select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){

					 $admin=new AdminClass();
					 
					  $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(
														'uid'=>array('b.uid','int'),
														'status'=>array('a.status','int'),
														'username'=>array('b.username','string'),
														'dateline1'=>array('a.dateline','time'),
														'dateline2'=>array('a.dateline','time')	  
												      ) 
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }
			   
			   
	        //select end----------------------------------------------------
		   
		    if(!empty($this->POST['Failure'])){
				
				 $ids=$this->GetCheckBox($this->POST['checkbox']);
			     
				 $errorinfo=$this->POST['errorinfo'];
				 
			     $yes=$this->Update('member_personal_certificate',array('status'=>6,'errorinfo'=>$errorinfo),array(),"WHERE uid IN($ids)");
				  
			     if($yes){
					 
					  $myinfoarr=$this->GetMysqlArray('uid,certificate',"  ".$this->GetTable('member_info')." WHERE uid IN($ids) ");
					  
					  if($myinfoarr){
		                     
							  foreach($myinfoarr as $myinfo){
							 
							         $certificates=$this->SetCertificateIcon($myinfo['certificate'],'Personal',1);
																					
							         $this->Update('member_info',array('certificate'=>$certificates,'realname'=>1),array(),"WHERE uid='$myinfo[uid]'");
							  
							  }
					  
					  }
				
					  $refresh= $this->LanguageArray('phpapp','Set_successfully');
							   
					  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				 }
			  
		  }elseif(!empty($this->POST['Pay'])){	  
		  
		        $ids=$this->GetCheckBox($this->POST['checkbox']);
		  
		        $this->Update('member_personal_certificate',array('pay'=>1),array(),"WHERE uid IN($ids)");
		  
		        $refresh= '<p>设置成功！</p>';
							   
				echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				
				
		 }elseif(!empty($this->POST['NotPay'])){	  
		  
		        $ids=$this->GetCheckBox($this->POST['checkbox']);
		  
		        $this->Update('member_personal_certificate',array('pay'=>0),array(),"WHERE uid IN($ids)");
		  
		        $refresh= '<p>设置成功！</p>';
							   
				echo $this->Refresh($refresh,$this->MakeGetParameterURL());		
		  
		  }elseif(!empty($this->POST['Cetrificate'])){
			  
			     $ids=$this->GetCheckBox($this->POST['checkbox']);
				 
			     $yes=$this->Update('member_personal_certificate',array('status'=>5),array(),"WHERE uid IN($ids)");
				  
			     if($yes){
				      
					  $myinfoarr=$this->GetMysqlArray('uid,certificate',"  ".$this->GetTable('member_info')." WHERE uid IN($ids) ");
					  
					  if($myinfoarr){
		                     
							  foreach($myinfoarr as $myinfo){
							 
							         $certificates=$this->SetCertificateIcon($myinfo['certificate'],'Personal');
																					
							         $this->Update('member_info',array('certificate'=>$certificates,'realname'=>0),array(),"WHERE uid='$myinfo[uid]'");
							  
							  }
					  
					  }
												
					  $refresh= '<p>认证成功！</p>';
							   
					  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				 }
			  
			  
		  
		  }elseif(!empty($this->POST['Submit'])){

                 $ids=$this->GetCheckBox($this->POST['checkbox']);
				 
				 if($this->Delete('member_personal_certificate'," WHERE uid IN($ids)")){
					 
					  $myinfoarr=$this->GetMysqlArray('uid,certificate',"  ".$this->GetTable('member_info')." WHERE uid IN($ids) ");
					  
					  if($myinfoarr){
		                     
							  foreach($myinfoarr as $myinfo){
							 
							         $certificates=$this->SetCertificateIcon($myinfo['certificate'],'Personal',1);
				
							         $this->Update('member_info',array('certificate'=>$certificates,'realname'=>1),array(),"WHERE uid='$myinfo[uid]'");
							  
							  }
					  
					  }
				
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
						  array('order'=>'a.realname','name'=>'实名'),
						  array('order'=>'c.mobile','name'=>'手机'),
						  array('order'=>'a.type','name'=>'认证类型'),
						  array('order'=>'a.verifymoney','name'=>'认证金额'),
						  array('order'=>'a.pay','name'=>'汇款'),
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
		 

		         $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.username,c.mobile FROM  (".$this->GetTable('member_personal_certificate')." AS a JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid) JOIN ".$this->GetTable('member_info')." AS c ON a.uid=c.uid $wheresql $order");

                 $list=$ajaxpage->ShowResult();
   
		  
		         include $this->Template('list_manage');
		  }
	}
	
	function ShowAction(){
		    
			$id=$this->GET['id'];
			
		    $certificate=$this->GetMysqlOne('*'," ".$this->GetTable('member_personal_certificate')." WHERE uid='$id'");
				  
			$bankarr=$this->GetMysqlArray('*'," ".$this->GetTable('bankname')."");
			
			$onlinebank=$this->GetMysqlArray('*'," ".$this->GetTable('pay_tool')." WHERE type_phpapp=0 ORDER BY displayorder_phpapp ASC");
  
								 
			$member=$this->GetMysqlOne('cookiecode'," ".$this->GetTable('member')." WHERE uid='$id'");
		
		    include $this->Template('show_manage');
		
	}
	
	function EditAction(){
		
		  $id=$this->GET['id'];
				  
		  if($this->POST['Submit']){
				
				if($id>0){
					 
					  $this->Update('member_personal_certificate',$this->POST,array()," WHERE uid='$id'");
					  
					  $refresh= $this->LanguageArray('phpapp','Edited_successfully');
					  
					  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						
					  exit();
					  
				}
			  
		  }else{
				if($id>0){
					 $certificate=$this->GetMysqlOne('*'," ".$this->GetTable('member_personal_certificate')." WHERE uid='$id'");
				  
			         $bankarr=$this->GetMysqlArray('*'," ".$this->GetTable('bankname')."");
			
			         $onlinebank=$this->GetMysqlArray('*'," ".$this->GetTable('pay_tool')." WHERE type_phpapp=0 ORDER BY displayorder_phpapp ASC");
			
				}else{
					 $manage='';
				}
		  }
				  
				  
		  include $this->Template('edit_manage');
	
	}
	
	
	function ConfigAction(){
		
		  if($this->POST['Submit']){
				
				  $this->SetConfig($this->POST);
				
		  }else{

		          include $this->Template('config_manage');
		  
		  }
	}
	
}


?>