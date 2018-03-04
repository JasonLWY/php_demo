<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class MobileManageControls extends PHPAPP{
	
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
		
		   return $this->AccountConfigAction();
	}
	

	function AccountConfigAction(){
		
		  if($this->POST['Submit']){
				
				  $this->SetConfig($this->POST);
				
		  }else{

		          include $this->Template('accountconfig_manage');
		  
		  }
	}
	
	
	function CheckSMSAction(){
		  
		  include_once(Core.'/class/sms_class_phpapp.php');
		  
		  $sms=new MobileSMS();
		  
		  $smsarry=$sms->CheckSum();
		  
		  $overagesum=intval($smsarry['overage']);
		  
		  $smssum=intval($smsarry['sendTotal']);

          include $this->Template('checksms_manage');

	}
	
	
	function SMSUseLogAction(){
		
		    include_once(Core.'/class/pages_class_phpapp.php');
		   
			if($this->POST['Submit']){
				 
				  $ids=$this->GetCheckBox($this->POST['checkbox']);
				   
	  
				  if($this->Delete('mobile_consume'," WHERE mid IN($ids)")){

						$refresh= $this->LanguageArray('phpapp','Delete_successfully');
				   
				  }else{
					   
						$refresh= $this->LanguageArray('phpapp','Delete_failed');

				  }
				   
				  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				 
				  exit();
				  
			 }else{
				 
				   $orderarr=array(
							array('order'=>'a.mid','name'=>'ID'),
							array('order'=>'a.uid','name'=>'用户ID'),
							array('order'=>'b.username','name'=>'用户名'),
							array('order'=>'a.mobile','name'=>'手机码'),
							array('order'=>'a.content','name'=>'发送内容')
							);
			
				   $order='ORDER BY a.mid DESC';
			
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

				   
				   $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.username FROM ".$this->GetTable('mobile_consume')." AS a JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid $order");

				   $list=$ajaxpage->ShowResult();
			 }
			 
			 include $this->Template('smsuselog_manage');
		   
	}  
	
	
	function CertificateAction(){
		  
		 
		  
		  if(!empty($this->POST['Failure'])){
			     
				 $ids=$this->GetCheckBox($this->POST['checkbox']);
				 
			     $yes=$this->Update('member_mobile_certificate',array('status'=>6),array(),"WHERE uid='$ids'");
				  
			     if($yes){
					 
					  $myinfoarr=$this->GetMysqlArray('uid,certificate',"  ".$this->GetTable('member_info')." WHERE uid IN($ids) ");
					  
					  if($myinfoarr){
		                     
							  foreach($myinfoarr as $myinfo){
							 
							         $certificates=$this->SetCertificateIcon($myinfo['certificate'],'Mobile',1);
																					
							         $this->Update('member_info',array('certificate'=>$certificates),array(),"WHERE uid='$myinfo[uid]'");
							  
							  }
					  
					  }
				
					  echo $this->Refresh($this->LanguageArray('phpapp','Set_successfully'),$this->MakeGetParameterURL());
				 }
			  
			  
		  
		  }elseif(!empty($this->POST['Cetrificate'])){
			     
				 $ids=$this->GetCheckBox($this->POST['checkbox']);
				 
			     $yes=$this->Update('member_mobile_certificate',array('status'=>5),array(),"WHERE uid IN($ids)");
				  
			     if($yes){
							   
					  $myinfoarr=$this->GetMysqlArray('uid,certificate',"  ".$this->GetTable('member_info')." WHERE uid IN($ids) ");
					  
					  if($myinfoarr){
		                     
							  foreach($myinfoarr as $myinfo){
							 
							         $certificates=$this->SetCertificateIcon($myinfo['certificate'],'Mobile');
									 $this->Update('member_info',array('certificate'=>$certificates),array(),"WHERE uid='$myinfo[uid]'");
							  
							  }
					  
					  }   
							   
					  echo $this->Refresh('<p>认证成功！</p>',$this->MakeGetParameterURL());
				 }
			  
			  
		  
		  }elseif(!empty($this->POST['Submit'])){
                 
				 $ids=$this->GetCheckBox($this->POST['checkbox']);
				 
				 if($this->Delete('member_mobile_certificate'," WHERE uid IN($ids)")){
					 
					 
					  $myinfoarr=$this->GetMysqlArray('uid,certificate',"  ".$this->GetTable('member_info')." WHERE uid IN($ids) ");
					  
					  if($myinfoarr){
		                     
							  foreach($myinfoarr as $myinfo){
							 
							         $certificates=$this->SetCertificateIcon($myinfo['certificate'],'Mobile',1);
																					
							         $this->Update('member_info',array('certificate'=>$certificates),array(),"WHERE uid='$myinfo[uid]'");
							  
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
						  array('order'=>'a.price','name'=>'认证费用'),
						  array('order'=>'a.mobile','name'=>'认证手机'),
						  array('order'=>'a.status','name'=>'状态'),
						  array('order'=>'a.dateline','name'=>'时间')
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
		 
		  
		         $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.username FROM  ".$this->GetTable('member_mobile_certificate')." AS a JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid $order");

                 $list=$ajaxpage->ShowResult();
		  
		  
		         include $this->Template('certificate_manage');
		  }
		
	}
	
	
	function CertificateConfigAction(){
		   
		    if($this->POST['Submit']){
				
				  $this->SetConfig($this->POST);
				
			}else{
				
		          include $this->Template('config_manage');
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