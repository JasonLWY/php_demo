<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

//Manage
class MemberMemberControls extends PHPAPP{
	
    private $GET;
	
	
	function __construct(){	 


		 parent::__construct();
		 
		 
		 $postkey=array('Submit'=>'');
		   
		 $this->POST=$this->POSTArray();
		 
		 	   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
			  
		   }
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id'));
		 
		 
		 if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
	}
	
	
	public function DefaultAction(){
		
		
		  return $this->SetInfoAction();
		
	}
	
	
	public function SetInfoAction(){
		
		
           $member=$this->GetMysqlOne('*',"".$this->GetTable('member')." WHERE  uid='$this->uid'");	  
		   
		   $usergroup=$member['usergroup'];
		   
		   include_once(APPS.'/member/class/member_phpapp.php');
					  
		   $mf=new MemberFunction();
					  
		   $membertable=$mf->GetTypeNameMember($member['usertype']);
		   
		
		  if($this->POST['Submit']){

					  $this->POST['about']=$this->str($this->POST['about'],600,1,0,1,0,1);
					  
					  $this->POST['homepage']=$this->str($this->POST['homepage'],255,1,0,1,0,1);

                      $birthday=strtotime($this->POST['Year'].'-'.$this->POST['Month'].'-'.$this->POST['Day']);
                      
					  $this->POST['birthday']=$birthday;
					  
					  //域名
					  $domainnamelen=strlen($this->POST['domainname']);
					  
					  if($domainnamelen){
					  
							if($domainnamelen <PHPAPP::$config['domainnamesmall']){
								  $this->POST['domainname']='';
								  echo '<p>对不起！您输入的域名太短了</p>';
							}
							
							if($domainnamelen >PHPAPP::$config['domainnamelong']){
								  $this->POST['domainname']=$this->str($this->POST['domainname'],PHPAPP::$config['domainnamelong'],1,0,1,0,1);
								  echo '<p>对不起！您输入的域名太长了</p>';
							}
					  
					  }
					  
                      $this->Update('member',array('userpost'=>$this->POST['userpost']),array()," WHERE uid='$this->uid'");
					  
					  $this->Update('member_info',$this->POST,array()," WHERE uid='$this->uid'");
					  
					  if(!$this->IsSQL($membertable['table_phpapp'],"WHERE uid='$this->uid'")){
						  
						    $this->Insert($membertable['table_phpapp'],array('uid'=>$this->uid,'about'=>$this->POST['about']),array());
							
					  }else{
					        $this->Update($membertable['table_phpapp'],array('about'=>$this->POST['about']),array()," WHERE uid='$this->uid'");
					  }
					  
					  echo '保存成功!<br />';
					  
					  echo $this->CloseNowWindows('#loading');
				
		   
		  }else{

				   
				    $memberinfo=$this->GetMysqlOne('*'," ".$this->GetTable('member_info')." WHERE  uid='$this->uid'");
					$tablename=$this->GetMysqlOne('*'," ".$this->GetTable($membertable['table_phpapp'])." WHERE  uid='$this->uid'");
					
					if(!is_array($tablename)){
						 $tablename=array();
					}
					
				    $info=array_merge($tablename,$memberinfo);

				
				    $year=$this->Date("Y",$info['birthday']);
					
					$month=$this->Date("m",$info['birthday']);
					
					$day=$this->Date("d",$info['birthday']);
		
				
				   //Year Month Day
				   
					$GetYear=$GetMonth='';
					
					$nowyear=$this->Date("Y",$this->NowTime());
					
					for($i=($nowyear);$i>=($nowyear-100);$i--){
						
						 if($year==$i){
							  $yearselected=' selected="selected"';
						 }else{
							  $yearselected='';
						 }
						
						  $GetYear.='<option value="'.$i.'"'.$yearselected.'>'.$i.'</option>';
						
					}
						
					for($i=1;$i<=12;$i++){
						
						 if($month==$i){
							  $monthselected=' selected="selected"';
						 }else{
							  $monthselected='';
						 }
						 
						  $GetMonth.='<option value="'.$i.'"'.$monthselected.'>'.$i.'</option>';
					}
						
						
				
				   include $this->Template('info_member');
		  }
	}
	




	
	public function SetAvatarAction(){
		
		   $phpappavatar=0;
		   if(!empty(PHPAPP::$config['uc_open'])){
                 $myavatar=$this->GetClient();	
		   }else{
			   
			     $member=$this->GetMysqlOne('cookiecode'," ".$this->GetTable('member')." WHERE  uid='$this->uid'");	
			     
                 $phpappavatar=1;
		   }
           
		   
		   include $this->Template('avatar_member');
	}
	

    public function SetContactAction(){

           $member=$this->GetMysqlOne('*'," ".$this->GetTable('member')." WHERE  uid='$this->uid'");	   

		
		  if($this->POST['Submit']){	
		              
					  if($member['email']!=$this->POST['email']){
					  
							include_once(Core.'/class/filter_class_phpapp.php');
	  
							include_once(APPS.'/member/main_phpapp.php');
	  
							$checkmail = new SubmitRegister($this->POST);
							
							$ismail=$checkmail->CheckEMail(iconv_strlen($this->POST['email'],S_CHARSET),$this->POST['email'],1);
					  }else{
						    $ismail='yes';
					  }
					  
					  
					  if($ismail=='yes'){
						  
					        $this->Update('member',array('email'=>$this->POST['email']),array()," WHERE uid='$this->uid'");

				
							$this->Update('member_info',$this->POST,array()," WHERE uid='$this->uid'");
							
							
							echo '保存成功!<br />';

					  }else{
						  
						    echo $ismail.'<br />';
					  }
					  
					  echo $this->CloseNowWindows('#loading',1);	
		  
		  
		  
		  }else{
			  
			  
			    $info=$this->GetMysqlOne('*'," ".$this->GetTable('member_info')." WHERE  uid='$this->uid'");
			  
			  
			  
			    include $this->Template('contact_member');
			  
		  }
		
		
		  
		
	}
	
	
	public function SetPasswordAction(){
		
	       $member=$this->GetMysqlOne('*'," ".$this->GetTable('member')." WHERE  uid='$this->uid'");	   
		   
		   if($this->POST['Submit']){	   
		   
					include_once(APPS.'/member/main_phpapp.php');

					$checkpassword = new SubmitRegister($this->POST);
		         
		            $result=$checkpassword->EditPassword($this->uid,$this->POST,1);
					
					if($result=='ok'){
						
						 $this->Update('member',array('safeemail'=>$this->POST['safeemail']),array()," WHERE uid='$this->uid'");
						
						 echo '设置成功!<br />';
						 
					}else{
						 echo $result;
						
					}
					
		   		   
		            echo $this->CloseNowWindows('#loading',1);	
		   
		   }else{

		          include $this->Template('password_member');
		   }
	}
	
	
	public function SystemSetAction(){
		   
		   if($this->POST['Submit']){
			   
			     unset($this->POST['Submit']);
				 
				 if(!$this->IsSQL('member_message_set',"WHERE uid='$this->uid'")){
					  $this->Insert('member_message_set',array('uid'=>$this->uid,'setkey'=>serialize($this->POST)),array());
				 }else{
					  $this->Update('member_message_set',array('setkey'=>serialize($this->POST)),array()," WHERE uid='$this->uid'");
				 }
				 
				 $this->Refresh('设置成功!','member.php?app=2&action=45');
	
		   }else{
																									   
                 $messagetypearr=$this->GetMysqlArray('*'," ".$this->GetTable('member_message_type')." WHERE satus=0 ORDER BY displayorder ASC,mid ASC");
				 $membersetarr=$this->GetMysqlOne('*'," ".$this->GetTable('member_message_set')." WHERE uid='$this->uid'");
				 
				 $setkeyarray=unserialize($membersetarr['setkey']);

		         include $this->Template('system_member');
		   
		   }
	}
	
}

?>