<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class EMailManageControls extends PHPAPP{
	
    private $actionmenu,$POST,$GET;
	
	function __construct($actionmenu=''){	
           
		   parent::__construct();
		   
	       $this->actionmenu=$actionmenu;
		   
		   $postkey=array('Submit'=>'','Cetrificate'=>'','checkbox'=>'');
		   
		   $this->POST=$this->POSTArray();
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','action'));
		         
	}
	
	function DefaultAction(){
		
		  return $this->CertificateAction();
	}
	
	
	function CertificateAction(){
		  
		  
		 
		  if(!empty($this->POST['Cetrificate'])){
			  
			     $ids=$this->GetCheckBox($this->POST['checkbox']);
			  
			     $yes=$this->Update('member_mail_certificate',array('status'=>5),array()," WHERE uid='$ids'");
				  
			     if($yes){
					 
					 
					  $myinfoarr=$this->GetMysqlArray('uid,certificate',"  ".$this->GetTable('member_info')." WHERE uid IN($ids) ");
					  
					  if($myinfoarr){
		                     
							  foreach($myinfoarr as $myinfo){
							 
							         $certificates=$this->SetCertificateIcon($myinfo['certificate'],'Mail');
									 $this->Update('member_info',array('certificate'=>$certificates),array(),"WHERE uid='$myinfo[uid]'");
							  
							  }
					  
					  }   
					 
							   
					  echo $this->Refresh('<p>认证成功！</p>',$this->MakeGetParameterURL());
				 }
			  
			  
		  
		  }elseif(!empty($this->POST['Submit'])){
                 
				 $ids=$this->GetCheckBox($this->POST['checkbox']);
				 
				 if($this->Delete('member_mail_certificate'," WHERE uid IN($ids)")){
				      
					  $myinfoarr=$this->GetMysqlArray('uid,certificate',"  ".$this->GetTable('member_info')." WHERE uid IN($ids) ");
					  
					  if($myinfoarr){
		                     
							  foreach($myinfoarr as $myinfo){
							 
							         $certificates=$this->SetCertificateIcon($myinfo['certificate'],'Mail',1);
									 $this->Update('member_info',array('certificate'=>$certificates),array(),"WHERE uid='$myinfo[uid]'");
							  
							  }
					  
					  }   
					  
					  
					  $refresh= $this->LanguageArray('phpapp','Delete_successfully');

				 }else{
					  $refresh=  $this->LanguageArray('phpapp','Delete_failed');
							   
				 }
			  
		         echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				 
		  }else{
			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		  
		         $orderarr=array(
						  array('order'=>'a.uid','name'=>'UID'),
						  array('order'=>'b.username','name'=>'用户名'),
						  array('order'=>'a.price','name'=>'认证费用'),
						  array('order'=>'a.email','name'=>'认证邮箱'),
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
		 
		  
		         $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.username FROM  ".$this->GetTable('member_mail_certificate')." AS a JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid $order");

                 $list=$ajaxpage->ShowResult();
		  
		  
		          include $this->Template('certificate_manage');
		  }
		
	}
	
}


?>