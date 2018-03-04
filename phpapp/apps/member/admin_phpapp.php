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

//Manage
class MemberManageControls extends PHPAPP{
	
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
	
	//Default
	public function DefaultAction(){
		
		  return $this->ListAction();
		
	}
	
	
	public function ListAction(){
           
		  //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(
														'uid'=>array('a.uid','int'),
														'username'=>array('a.username','string'),
														'cityid'=>array('d.residecity','city'),
														'unionid'=>array('a.unionid','int'),
														'usergroup'=>array('a.usergroup','int'),
														'money1'=>array('c.money','part'),
														'money2'=>array('c.money','part'),
														'credit1'=>array('c.credit','part'),
														'credit2'=>array('c.credit','part'),
														'dateline1'=>array('a.dateline','time'),
														'dateline2'=>array('a.dateline','time'),
														'logintime1'=>array('a.logintime','time'),
														'logintime2'=>array('a.logintime','time'),
		                                                'uniontime1'=>array('a.uniontime','time'),
														'uniontime2'=>array('a.uniontime','time')
															  
												      ) 
													  
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }

			  //select end----------------------------------------------------
		   
		   $usergrouparr=$this->GetMysqlArray('*'," ".$this->GetTable('usergroup')." ");
		   
		   
		  include_once(APPS.'/member/class/delete_phpapp.php');
		  
		  if(!empty($this->POST['Submit'])){

               $ids=$this->GetCheckBox($this->POST['checkbox']);
			   
			   $del=new DeleteMember();
			   
			   if($del->DeleteMemberData($ids)){
				   
			        $refresh= '<p>删除用户成功！</p>';
							 
			   }else{
				   
				    $refresh= '<p>删除用户失败！</p>'; 
			        
			   }
			   
			   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			  
		  
		  }else{
			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		  
		         $orderarr=array(
						  array('order'=>'a.uid','name'=>'UID'),
						  array('order'=>'a.username','name'=>'用户名'),
						  array('order'=>'d.realname','name'=>'实名认证'),
						  array('order'=>'a.usergroup','name'=>'前台用户组'),
						  array('order'=>'a.admingroup','name'=>'后台管理组'),
						  array('order'=>'c.money','name'=>'可用余额(元)'),
						  //废除 array('order'=>'c.lock','name'=>'冻结金额'), 
						  array('order'=>'c.union','name'=>'推广提成'),
						  array('order'=>'a.unionid','name'=>'推广员UID'),
						  array('order'=>'c.credit','name'=>'积分'),
						  array('order'=>'a.dateline','name'=>'注册时间'),
						  array('order'=>'a.logintime','name'=>'最近登录'),
						  array('order'=>'a.uniontime','name'=>'推广过期')
						  );
          
		         $order='ORDER BY a.uid ASC';
		  
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
		 

		         $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.groupname,c.*,d.realname,e.name_phpapp AS adminname FROM  (((".$this->GetTable('member')." AS a LEFT JOIN ".$this->GetTable('usergroup')." AS b ON a.usergroup=b.gid) LEFT JOIN ".$this->GetTable('member_account')." AS c ON a.uid=c.uid) LEFT JOIN ".$this->GetTable('member_info')." AS d ON a.uid=d.uid) LEFT JOIN ".$this->GetTable('admin')." AS e ON a.admingroup=e.id_phpapp $wheresql $order");

                 $list=$ajaxpage->ShowResult();
   
		  
		         include $this->Template('list_manage');
		  }
		  
		  
	}
	
	
	
	public function EditMemberAction(){
		
		  $id=$this->GET['id'];
		  
		  if(!$id){
		       
			    $refresh= '<p>对不起！用户不存在！</p>';
						   
			    echo $this->Refresh($refresh,$this->MakeGetParameterURL());
		  
		  }else{
			  
			  
			    $value=$this->GetMysqlOne('a.*,b.groupname,c.*,d.*,e.speed,e.attitude,e.quality'," (((".$this->GetTable('member')." AS a LEFT JOIN ".$this->GetTable('usergroup')." AS b ON a.usergroup=b.gid) LEFT JOIN ".$this->GetTable('member_account')." AS c ON a.uid=c.uid) LEFT JOIN ".$this->GetTable('member_info')." AS d ON a.uid=d.uid)LEFT JOIN ".$this->GetTable('credit_score')." AS e ON a.uid=e.uid WHERE a.uid='$id'");
				
				if(!$value){
					
					 $refresh= '<p>对不起！用户不存在！</p>';
						   
			         echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					
				}else{
					
					  $membertype=$this->GetMysqlArray('*'," ".$this->GetTable('member_type')." WHERE status_phpapp=0 ");
					
					  $adminusergroup=$this->GetMysqlArray('*'," ".$this->GetTable('admin')." WHERE status_phpapp=0 ");
					  
					  $usertype=$value['usertype'];
					  
					  $usergroup=$this->GetMysqlArray('*'," ".$this->GetTable('usergroup')." WHERE usertype='$usertype' ");
		
					  if(!empty($this->POST['Submit']) && !empty($this->POST['uid'])) {
						 
						   $uid=$this->POST['uid'];
						   
						   if($this->POST['password']){
							   
							      include_once(APPS.'/member/main_phpapp.php');
	                            
								  $checkpassword = new SubmitRegister($this->POST);
							   
								  $checkpassword->SetNewPassword($uid,$this->POST['password']);
							   
						   }

						   unset($this->POST['password']);
					  
						   $this->POST['homepage']=$this->str($this->POST['homepage'],255,1,0,1,0,1);
	
						   $birthday=strtotime($this->POST['Year'].'-'.$this->POST['Month'].'-'.$this->POST['Day']);
						  
						   $this->POST['birthday']=$birthday;
						   
						   if($this->POST['uniontime']){
						         $this->POST['uniontime']=strtotime($this->POST['uniontime'].' 0:00:00');
						   }
						   
						   $this->Update('member',$this->POST,array()," WHERE uid='$uid'");
	
						   $this->Update('member_info',$this->POST,array()," WHERE uid='$uid'");
						   
						   $this->Update('member_account',$this->POST,array()," WHERE uid='$uid'");
						   
						   if(!$this->IsSQL('credit_score',"WHERE uid='$uid'")){
							    $this->Insert('credit_score',$this->POST,array('uid'=>$uid));
						   }else{
						        $this->Update('credit_score',$this->POST,array()," WHERE uid='$uid'");
						   }
	
						   $usertype=$this->POST['usertype'];
					       
						   if(!$this->IsSQL('member',"WHERE uid='$uid' AND usertype='$usertype'")){
		  
					                include_once(APPS.'/member/class/member_phpapp.php');
					  
		                            $mf=new MemberFunction();
							   
									$membertable=$mf->GetTypeNameMember($usertype);
									
									$usergroup=$this->GetMysqlOne('gid'," ".$this->GetTable('usergroup')." WHERE usertype='$usertype' LIMIT 0,1 ");
										  
									if($usergroup['gid']){
										  $gid=$usergroup['gid'];
										  $this->Update('member',array('usergroup'=>$gid),array()," WHERE uid='$uid'");
									}

		
									if(!$this->IsSQL($membertable['table_phpapp'],"WHERE uid='$uid'")){

										  $this->Insert($membertable['table_phpapp'],array('uid'=>$uid,'about'=>''),array());
										  
									}else{
										  $this->Update($membertable['table_phpapp'],array('about'=>''),array()," WHERE uid='$uid'");
									}

						   }
							
						   $refresh= $this->LanguageArray('phpapp','Edited_successfully');
						   
						   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						
					 }else{
						 
						    $year=$this->Date("Y",$value['birthday']);
					
							$month=$this->Date("m",$value['birthday']);
							
							$day=$this->Date("d",$value['birthday']);
				
						
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
					 
							include $this->Template('edit_manage');
					 }
			   }
		 }
	}

	public function AddMemberAction(){
		
              if(!empty($this->POST['Submit'])){
				   
				     include_once(APPS.'/member/main_phpapp.php');


					 $register = new SubmitRegister($this->POST);
								 
					 //注册
					 $success='';
					
					 if($register->CheckRegister(1)==3){
						
						  $success=$register->InsertRegister(1,1);
						 
					 }else{
					
						  $errors=$register->GetCheckErrors(1);
					 }
					 
					 if($success){	
						  
						  $refresh= '<p>添加成功!</p>';
						 
					 }else{
					 
						  $refresh= '<p>'.$errors.'</p>';

					 }

                     echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					
					
					 exit();

			  }else{
                    
					$usergrouparr=$this->GetMysqlArray('*'," ".$this->GetTable('usergroup')." ");
					
					$membertypearr=$this->GetMysqlArray('*'," ".$this->GetTable('member_type')." WHERE status_phpapp=0 ");
					
		            include $this->Template('addmember_manage');
			  }
	
	}

	
}


?>