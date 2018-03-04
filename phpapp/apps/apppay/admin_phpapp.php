<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(Core.'/class/pages_class_phpapp.php');
include_once(Core.'/class/admin_class_phpapp.php');

class AppPayManageControls extends PHPAPP{
	
    private $actionmenu,$POST;
	
	public $GET;
	
	function __construct($actionmenu=''){	
           
		   parent::__construct();
		   
	       $this->actionmenu=$actionmenu;
		   
		   $postkey=array('Submit'=>'','Deposit'=>'','Check'=>'','checkbox'=>'');
		   
		   $this->POST=$this->POSTArray();
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','action','value'));
		   
		   if(!$this->uid){
			   
			     $refresh=$this->LanguageArray('phpapp','Please_login_actions');
				 
				 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				 
				 exit();
				 
		   }
		         
	}
	
	
	public function DefaultAction(){
		
		
		  return $this->ConsumeAction();
		
	}
	
	

	public function ConsumeAction(){
		   
		   //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(	
														'subject'=>array('a.subject','search'),
														'cid'=>array('a.cid','int'),
														'serial'=>array('a.serial','string'),
														'uid'=>array('c.uid','int'),
														'username'=>array('c.username','string'),
														'operator'=>array('a.operator','int'),
														'appid'=>array('a.appid','int'),
														'process'=>array('a.process','int'),
														'flow'=>array('b.flow','int'),
														'paytype'=>array('a.paytype','int'),
														'amount1'=>array('a.amount','part'),
														'amount2'=>array('a.amount','part'),
														'fee1'=>array('a.fee','part'),
														'fee2'=>array('a.fee','part'),
														'refundmoney1'=>array('a.refundmoney','part'),
														'refundmoney2'=>array('a.refundmoney','part'),
														'dateline1'=>array('a.dateline','time'),
														'dateline2'=>array('a.dateline','time')
															  
												      ) 
													  
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }

			  //select end----------------------------------------------------
		   
		   
		   
		   if($this->POST['Submit']){
			                          
				  $ids=$this->GetCheckBox($this->POST['checkbox']);
				  
				  if($this->POST['deletetype']>1){
					     
						if($this->POST['deletetype']==2){
							   $this->SetConsumeInfo($ids);   
						}
						
						$this->Update('consume',array('process'=>6),array()," WHERE process<6 AND cid IN($ids) ");
					   
					    
						$refresh= $this->LanguageArray('phpapp','Set_off_success');
						
				  }else{
				  
						if($this->POST['deletetype']){
							  $this->SetConsumeInfo($ids);
						}
						
	  
						if($this->Delete('consume'," WHERE  process<6 AND cid IN($ids)")){
							
							  $this->Delete('member_consume'," WHERE cid IN($ids)");
							  
							  
							  $refresh= $this->LanguageArray('phpapp','Delete_successfully');
						 
						}else{
							 
							  $refresh= $this->LanguageArray('phpapp','Delete_failed');
	  
						}
						
						
				  }
				  
				  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				 
				  exit();
				  
			 }else{
			 
				  $orderarr=array(
							array('order'=>'a.cid','name'=>'���'),
							array('order'=>'a.serial','name'=>'��ˮ��'),
							array('order'=>'a.appid','name'=>'Ӧ��'),
							array('order'=>'a.dateline','name'=>'����ʱ��'),
							array('order'=>'a.subject','name'=>'ժҪ'),
							array('order'=>'a.number','name'=>'����'),
							array('order'=>'a.amount','name'=>'���׽��(Ԫ)'),
							array('order'=>'a.fee','name'=>'������(Ԫ)'),
							array('order'=>'a.refundmoney','name'=>'�˿�'),
							array('order'=>'c.uid','name'=>'�����û�'),
							array('order'=>'b.money','name'=>'���׺����(Ԫ)'),
							array('order'=>'a.operator','name'=>'����Ա')
							);
			
				   $order='ORDER BY a.serial DESC';
			
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
		           
				   if($wheresql){
					    $wheresql.=' AND b.uid>0 ';
				   }else{
					    $wheresql=' WHERE b.uid>0 ';
				   }

				   $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.money,b.flow,b.oid,c.username,d.money AS nowmoney,e.username AS operatorname,f.name_phpapp FROM  ((((".$this->GetTable('consume')." AS a LEFT JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid) LEFT JOIN ".$this->GetTable('member')." AS c ON b.uid=c.uid) LEFT JOIN ".$this->GetTable('member_account')." AS d ON b.uid=d.uid) LEFT JOIN ".$this->GetTable('member')." AS e ON a.operator=e.uid) JOIN ".$this->GetTable('apps')." AS f ON a.appid=f.id_phpapp $wheresql GROUP BY a.cid $order");
	  
				   $list=$ajaxpage->ShowResult();
		  
				   
				  include(APPS.'/apppay/class/process_class_phpapp.php');
				   
				  $getprocess=new TaskProcess();
				  
				  include $this->Template('consume_manage');
			}
	
		    
	}
	
	
	
	public function PayAction(){
		  
		  //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(	
														'subject'=>array('a.subject','search'),
														'cid'=>array('a.cid','int'),
														'serial'=>array('a.serial','string'),
														'uid'=>array('c.uid','int'),
														'username'=>array('e.username','string'),
														'operator'=>array('a.operator','int'),
														'appid'=>array('a.appid','int'),
														'process'=>array('a.process','int'),
														'flow'=>array('b.flow','int'),
														'paytype'=>array('a.paytype','int'),
														'amount1'=>array('a.amount','part'),
														'amount2'=>array('a.amount','part'),
														'fee1'=>array('a.fee','part'),
														'fee2'=>array('a.fee','part'),
														'dateline1'=>array('a.dateline','time'),
														'dateline2'=>array('a.dateline','time')
															  
												      ) 
													  
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }

			  //select end----------------------------------------------------
  
		   if($this->POST['Submit']){
					   
		          $ids=$this->GetCheckBox($this->POST['checkbox']);
				  
				  if($this->POST['deletetype']){
				        $this->SetConsumeInfo($ids);
				  }
	  
				  if($this->Delete('consume'," WHERE cid IN($ids)")){
                        
						$this->Delete('member_consume'," WHERE cid IN($ids)");
						
						$refresh= $this->LanguageArray('phpapp','Delete_successfully');
				   
				  }else{
					   
						$refresh= $this->LanguageArray('phpapp','Delete_failed');

				  }
				   
				  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				 
				  exit();
				  
			 }else{
			 
				  $orderarr=array(
							array('order'=>'a.cid','name'=>'���'),
							array('order'=>'a.serial','name'=>'��ˮ��'),
							array('order'=>'a.appid','name'=>'Ӧ��'),
							array('order'=>'a.dateline','name'=>'����ʱ��'),
							array('order'=>'a.subject','name'=>'ժҪ'),
							array('order'=>'a.number','name'=>'����'),
							array('order'=>'a.amount','name'=>'���׽��(Ԫ)'),
							array('order'=>'a.fee','name'=>'������(Ԫ)'),
							array('order'=>'c.uid','name'=>'�����û�'),
							array('order'=>'b.money','name'=>'���׺����(Ԫ)'),
							array('order'=>'a.operator','name'=>'����Ա')
							);
			
				   $order='ORDER BY a.serial DESC';
			
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
		           
				   if($wheresql){
					    $wheresql.=' AND a.paytype=3 AND b.uid>0 AND b.flow=1 ';
				   }else{
					    $wheresql=' WHERE a.paytype=3 AND b.uid>0 AND b.flow=1 ';
				   }
	  
				   $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.money,b.flow,b.oid,c.username,d.money AS nowmoney,e.username AS operatorname,f.name_phpapp FROM  ((((".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid) JOIN ".$this->GetTable('member')." AS c ON b.uid=c.uid) JOIN ".$this->GetTable('member_account')." AS d ON b.uid=d.uid) LEFT JOIN ".$this->GetTable('member')." AS e ON a.operator=e.uid) JOIN ".$this->GetTable('apps')." AS f ON a.appid=f.id_phpapp $wheresql GROUP BY a.cid $order");
	  
				   $list=$ajaxpage->ShowResult();
		  
				   
				  include(APPS.'/apppay/class/process_class_phpapp.php');
				   
				  $getprocess=new TaskProcess();
		   
		          include $this->Template('consume_manage');
			 }
	}
	
    
	public function DepositAction(){
           
		   //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(	
														'subject'=>array('a.subject','search'),
														'cid'=>array('a.cid','int'),
														'serial'=>array('a.serial','string'),
														'uid'=>array('c.uid','int'),
														'username'=>array('c.username','string'),
														'operator'=>array('a.operator','int'),
														'appid'=>array('a.appid','int'),
														'process'=>array('a.process','int'),
														'flow'=>array('b.flow','int'),
														'paytype'=>array('a.paytype','int'),
														'amount1'=>array('a.amount','part'),
														'amount2'=>array('a.amount','part'),
														'fee1'=>array('a.fee','part'),
														'fee2'=>array('a.fee','part'),
														'dateline1'=>array('a.dateline','time'),
														'dateline2'=>array('a.dateline','time')
															  
												      ) ,1
													  
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }

			  //select end----------------------------------------------------
			
			
		   if($this->POST['Failure']){
			     //Failure
				 $ids=$this->GetCheckBox($this->POST['checkbox']);
				 
				 include_once(APPS.'/apppay/class/consume_class_phpapp.php');

		         $pay=new UserConsume();

				 $consumeid=explode(',',$ids);

				 foreach($consumeid as $value){
					 
				 		$pay->CloseConsume($value);
						
				 }
				 
				 $this->SetConsumeInfo($ids,1);   

				$failureinfo=$this->POST['failureinfo'];	
				
				 //SMS
				foreach($consumeid as $value){
				 
				         $useridarr=$this->GetMysqlOne('uid',"  ".$this->GetTable('member_consume')."  WHERE flow=2 AND cid='$value' ");
			
						 if($useridarr['uid']){
							 
							     $memberarr=$this->GetMysqlOne('username',"  ".$this->GetTable('member')." WHERE uid='$useridarr[uid]' ");
					             
								 $this->Port(array(	 		
											  									  
										  //SMS
										  'receive_uid'=>$useridarr['uid'], 
										  'sms_subject'=>$memberarr['username'].'�����������ʧ��!',
										  'sms_content'=>'<p>�𾴵��û����ã�</p>�����������ʧ��(#'.$value.')�ѹرգ�ԭ��'.$failureinfo.'<a href="'.SURL.'/member.php?app=5&action=1&page=0&opensearch=1&cid=&serial=&process=0&flow=0&paytype=4&amount1=&amount2=&dateline1=&dateline2=&SelectData=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>',
										  'email_title'=>$memberarr['username'].'�����������ʧ��!',
										  'email_content'=>'�𾴵��û����ã������������ʧ��(#'.$value.')�ѹرգ�ԭ��'.$failureinfo.'<a href="'.SURL.'/member.php?app=5&action=1&page=0&opensearch=1&cid=&serial=&process=0&flow=0&paytype=4&amount1=&amount2=&dateline1=&dateline2=&SelectData=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>',
										  'mobile_content'=>$memberarr['username'].'���ã������������ʧ�ܣ���ע����գ�'.PHPAPP::$config['sitename']
								
								),6);

							
						 }
						 
				 }
				 
				 
                 $refresh= $this->LanguageArray('phpapp','Set_successfully');
				 
				 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				 
				 exit();
				 
			   
		   
		   }elseif($this->POST['Deposit']){
			     
                 $ids=$this->GetCheckBox($this->POST['checkbox']);
				  
				 include_once(APPS.'/apppay/class/consume_class_phpapp.php');

		         $pay=new UserConsume();
				 
				 $consumeid=explode(',',$ids);
		         
		         
				 foreach($consumeid as $value){
					 
		              $pay->SetSuccessConsume($value); 
				 
				 }
				 
	          
				 foreach($consumeid as $value){
				 
				         $useridarr=$this->GetMysqlOne('uid',"  ".$this->GetTable('member_consume')."  WHERE flow=2 AND cid='$value' ");
			
						 if($useridarr['uid']){
							 
							     $memberarr=$this->GetMysqlOne('username',"  ".$this->GetTable('member')." WHERE uid='$useridarr[uid]' ");
					
								 $this->Port(array(	 		
											  									  
										  //SMS
										  'receive_uid'=>$useridarr['uid'], 
										  'sms_subject'=>$memberarr['username'].'������������Ѵ���ɹ�!',
										  'sms_content'=>'<p>�𾴵��û����ã�</p>�����������(#'.$value.')�Ѵ���ɹ���<a href="'.SURL.'/member.php?app=5&action=1&page=1&sort=4" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>',
										  'email_title'=>$memberarr['username'].'������������Ѵ���ɹ�!',
												'email_content'=>'<p>�𾴵��û����ã�</p>�����������(#'.$value.')�Ѵ���ɹ���<a href="'.SURL.'/member.php?app=5&action=1&page=1&sort=4" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>',
										  'mobile_content'=>$memberarr['username'].'���ã�������������Ѵ���ɹ�����ע����գ� '.PHPAPP::$config['sitename']
								
								),6);
								 
							
						 }
						 
				 }
			
				 
				 
                 $refresh= $this->LanguageArray('phpapp','Set_successfully');
				 
				 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				 
				 exit();
				 

		   }elseif($this->POST['Submit']){
					   
				  $ids=$this->GetCheckBox($this->POST['checkbox']);
				  
	              $this->SetConsumeInfo($ids,1);   
				  
				  $memberconsumearr=$this->GetMysqlArray('a.amount,b.uid'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid  WHERE a.cid IN($ids) AND b.uid>0 AND b.flow=2 ");
				  
				  foreach($memberconsumearr as $value){

						 $memberaccount=$this->GetMysqlOne('*'," ".$this->GetTable('member_account')." WHERE uid='$value[uid]'");
						 
						 if($memberaccount){
							   $nowlock=$memberaccount['lock']-$value['amount'];
							   $this->Update('member_account',array('lock'=>$nowlock),array(),"WHERE uid='$value[uid]'");
						 } 
					  
				  }
				  
				  if($this->Delete('consume'," WHERE cid IN($ids)")){
                        
						$this->Delete('member_consume'," WHERE cid IN($ids)");
						
						$refresh= $this->LanguageArray('phpapp','Delete_successfully');
				   
				  }else{
					   
						$refresh= $this->LanguageArray('phpapp','Delete_failed');

				  }
				   
				  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				 
				  exit();
				  
			 }else{
			 
				  $orderarr=array(
							array('order'=>'a.serial','name'=>'��ˮ��'),
							array('order'=>'a.dateline','name'=>'����ʱ��'),
							array('order'=>'a.subject','name'=>'���ֿ���'),
							array('order'=>'a.amount','name'=>'���׽��(Ԫ)'),
							array('order'=>'a.fee','name'=>'������(Ԫ)'),
							array('order'=>'a.amount','name'=>'ʵ��(Ԫ)'),
							array('order'=>'c.uid','name'=>'�����û�'),
							array('order'=>'e.realname','name'=>'ʵ����֤'),
							array('order'=>'c.uid','name'=>'�û�ʵ��'),
							array('order'=>'e.mobile','name'=>'�û��ֻ�'),
							array('order'=>'b.money','name'=>'���׺����(Ԫ)')
							);
			
				   $order='ORDER BY a.serial DESC';
			
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
		           
				   if($wheresql){
					    $wheresql.=' AND a.paytype=4 AND b.uid>0  AND b.flow=2 ';
				   }else{
					    $wheresql=' WHERE a.paytype=4 AND b.uid>0 AND b.flow=2 ';
				   }
	 
				   $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.money,b.uid,b.flow,c.username,c.usertype,d.money AS nowmoney,e.realname,e.mobile FROM  (((".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid) JOIN ".$this->GetTable('member')." AS c ON b.uid=c.uid) JOIN ".$this->GetTable('member_account')." AS d ON b.uid=d.uid) JOIN ".$this->GetTable('member_info')." AS e ON b.uid=e.uid $wheresql  GROUP BY a.cid $order");
	  
				   $list=$ajaxpage->ShowResult();
		  
				   
				   include(APPS.'/apppay/class/process_class_phpapp.php');
				   
				   $getprocess=new TaskProcess();
		    

		           include $this->Template('deposit_manage');
			 }
		
	}
	
	public function CertificateAction(){
		

		    $id=$this->GET['id'];
				  
			if($id>0){
				
				 $userinfo=$this->GetLoginInfo($id);
				 
				 $membertype=$this->GetTypeMember($userinfo['usertype']);
				 
				 $certificate=$this->GetMysqlOne('*'," ".$this->GetTable($membertype.'_certificate')." WHERE uid='$id' AND status=5");
				 
				 $bankarr=$this->GetMysqlArray('*'," ".$this->GetTable('bankname')."");
				  
				 $onlinebank=$this->GetMysqlArray('*'," ".$this->GetTable('pay_tool')." WHERE type_phpapp=0 ORDER BY displayorder_phpapp ASC");
				  
			}else{
				 $certificate='';
			}
		

		    include $this->Template('certificate_manage');
		
	}
	
	function AccountConvertStr($convert,$charset='GBK'){
		
		    if(strtoupper(S_CHARSET)!=strtoupper($charset)){
				  return  mb_convert_encoding($convert,$charset,S_CHARSET); 
	        }else{
				  return $convert;
			}
    }
	
	public function AccountDownAction(){
		   
			if($this->POST['Submit']){
				  
				  $wheresql=''; 	
				  
				  if($this->POST['type']){
					    $paytype=$this->POST['type'];
					    $wheresql.=" AND paytype='$paytype' "; 	
					  
				  }
				  
				 		 
				 if($this->POST['downtype']){
					   $aid1=$this->POST['account1'];
					   $aid2=$this->POST['account2'];
                       $wheresql.=" AND a.cid>=$aid1 AND a.cid<=$aid2 ";
				 }
				 

				 $accountsarr=$this->GetMysqlArray('a.*,b.money,b.flow,b.uid,c.username,d.money AS nowmoney'," ((".$this->GetTable('consume')." AS a LEFT JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid) LEFT JOIN ".$this->GetTable('member')." AS c ON b.uid=c.uid) LEFT JOIN ".$this->GetTable('member_account')." AS d ON b.uid=d.uid WHERE b.uid>0 $wheresql ORDER BY a.cid ASC");
				 include(APPS.'/apppay/class/process_class_phpapp.php');
				   
				 $getprocess=new TaskProcess();
				     
				 header("Content-type:application/vnd.ms-excel"); 
				 header("Content-Disposition:attachment; filename=".@date('Y_m_d')."_Account_Data.xls");
				 header("Content-Transfer-Encoding: binary");
					 
				 if(!empty($accountsarr)){
					 
					
						   echo $this->AccountConvertStr('���ID',$this->POST['character']).chr(9);
						   echo $this->AccountConvertStr('��ˮ��',$this->POST['character']).chr(9);
						   echo $this->AccountConvertStr('����ʱ��',$this->POST['character']).chr(9);
						   echo $this->AccountConvertStr('ժҪ',$this->POST['character']).chr(9);
						   echo $this->AccountConvertStr('��������',$this->POST['character']).chr(9);
						   echo $this->AccountConvertStr('����',$this->POST['character']).chr(9);
						   echo $this->AccountConvertStr('���׽��(Ԫ)',$this->POST['character']).chr(9);	
						   echo $this->AccountConvertStr('������(Ԫ)',$this->POST['character']).chr(9);
						   echo $this->AccountConvertStr('ʵ��(Ԫ)',$this->POST['character']).chr(9);
						   echo $this->AccountConvertStr('�����û�',$this->POST['character']).chr(9);	
						   echo $this->AccountConvertStr('���׺����(Ԫ)',$this->POST['character']).chr(9);	
						   echo $this->AccountConvertStr('Ŀǰ���(Ԫ)',$this->POST['character']).chr(9);	
						   echo $this->AccountConvertStr('����״̬',$this->POST['character']).chr(9);
						   echo chr(13);
						  

					   foreach($accountsarr as $value){
						   if ($value['uid']>0){
								$username=$value['username'];
						   }else{
								$username=PHPAPP::$config['sitepayname'];
						   }
						   
						   
						   if ($value['flow']==1){
						   
						      $proces=$getprocess->GetSellerProcessName('','',$value['serial'],0,$value['appid']);
						  
					       }elseif ($value['flow']==2){
							   
							  $proces=$getprocess->GetBuyerProcessName('','',$value['serial'],0,$value['appid'],$value['paytype']);
						  
						   }
						   
						   if ($value['paytype']==1){
								$accounttype=$this->AccountConvertStr('��������',$this->POST['character']);
						   }elseif($value['paytype']==2){
								$accounttype=$this->AccountConvertStr('��ʱ����',$this->POST['character']);
						   }elseif($value['paytype']==3){
								$accounttype=$this->AccountConvertStr('��ֵ����',$this->POST['character']);
						   }elseif($value['paytype']==4){
								$accounttype=$this->AccountConvertStr('���ֽ���',$this->POST['character']);
						   }
						   
						   $bankcard='';
						   if ($value['bankcard']){
							    
								$bankcard=$value['bankcard'];
							   
						   }
						   
	  
						   echo $value['cid'].chr(9);
						   echo 'ID '.$value['serial'].chr(9);
						   echo @date('Y/m/d H:i',$value['dateline']).chr(9);
						   echo $this->AccountConvertStr($this->str($value['subject'],999,0,1,1,0,1),$this->POST['character']).' '.$bankcard.chr(9);	
						   echo $accounttype.chr(9);	
						   echo $value['number'].chr(9);	
						   echo $value['amount'].chr(9);	
						   echo $value['fee'].chr(9);
						   echo $value['amount']-$value['fee'].chr(9);
						   echo $this->AccountConvertStr($username,$this->POST['character']).chr(9);	
						   echo $value['money'].chr(9);	
						   echo $value['nowmoney'].chr(9);	
						   echo $this->AccountConvertStr($this->str($proces,9999,0,1,1,0,1),$this->POST['character']).chr(9);	
						   echo chr(13);
					   }
				 }
				 
				  echo $this->AccountConvertStr('����ʱ��',$this->POST['character']).chr(9);
				  echo @date('Y/m/d H:i').chr(9);
				  
				
				  exit();
				  
			}else{
			
				include $this->Template('accountdown_manage');
		   
			}
	}
	
	public function TotalAction(){
		  
		  
		  if($this->GET['datetype']==3){
			  $dateline=0;	
				if($_GET['dateline']){
					
					 $timearr=explode('-',$_GET['dateline']);
					 $dateline=strtotime(intval($timearr[0]).'-'.intval($timearr[1]).'-'.intval($timearr[2]).' 0:00:00');
					 $dateline2=$dateline+24*60*60;
					 
					 //��վ����
					 $siteincome=$this->GetMysqlOne('sum(amount) AS amounts'," ".$this->GetTable('consume')." WHERE paytype=3 AND process=5 AND dateline>'$dateline' AND dateline<'$dateline2' ");

					 
				}
			  
		  }elseif($this->GET['datetype']==2){
			  
				$dateline=0;	
				if($_GET['dateline']){
					
					 $timearr=explode('-',$_GET['dateline']);
					 $dateline=strtotime(intval($timearr[0]).'-'.intval($timearr[1]).'-'.intval($timearr[2]).' 0:00:00');
					 $dateline2=$dateline+24*60*60;
					 
					 //��վ����
					 $siteincome=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=2 AND b.uid>0 AND a.paytype<3 AND a.dateline>'$dateline' AND a.dateline<'$dateline2' ");
					 
					 
					 //���񵣱���-------------------------------------------------------
					$TaskMoneyIncome=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=2 AND b.uid>0 AND a.paytype=1 AND a.appid NOT IN(11,12,5,15,16,14,21,26) AND a.dateline>'$dateline' AND a.dateline<'$dateline2' ");
					
					$TaskMoneyIncomeApps[]=$this->GetMysqlArray('c.id_phpapp,c.name_phpapp,sum(a.amount) AS amounts'," (".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid) JOIN ".$this->GetTable('apps')." AS c ON a.appid=c.id_phpapp WHERE a.process=5 AND b.flow=2 AND b.uid>0 AND a.paytype=1 AND a.appid NOT IN(11,12,5,15,16,14,21,26) AND a.dateline>'$dateline' AND a.dateline<'$dateline2'  GROUP BY a.appid ");
						   
						   
					 //���񵣱��� end-------------------------------------------------------
					 
					 //���� --------------------------------------------------------
					 $PropMoneyIncome=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=2 AND b.uid>0 AND a.appid=11 AND a.dateline>'$dateline' AND a.dateline<'$dateline2' ");
						   
	  
					 //���� end----------------------------------------------------------------
					 
					 //����VIP----------------------------------------------------------------
					 $VIPMoneyIncome=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=2 AND b.uid>0 AND a.appid=26 AND a.dateline>'$dateline' AND a.dateline<'$dateline2' ");
					 

					 //����VIP end----------------------------------------------------------------
					 
					 
					 //�û���֤----------------------------------------------------------------
					 $CertificateMoneyIncome=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=2 AND b.uid>0 AND a.appid IN(14,15,16,21) AND a.dateline>'$dateline' AND a.dateline<'$dateline2' ");
					 

					 //�û���֤ end----------------------------------------------------------------
					 
					 
					 //��վ֧��
					 $sitepay=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=1 AND b.uid>0 AND a.paytype<3 AND a.dateline>'$dateline' AND a.dateline<'$dateline2'");
					 
					 //���񵣱���-------------------------------------------------------
					 $TaskMoneyPay=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=1 AND b.uid>0 AND a.paytype=1 AND a.appid NOT IN(11,5,15,16,14,21) AND a.dateline>'$dateline' AND a.dateline<'$dateline2' ");
						   
						   
					 $TaskMoneyPayApps[]=$this->GetMysqlArray('c.id_phpapp,c.name_phpapp,sum(a.amount) AS amounts'," (".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid) JOIN ".$this->GetTable('apps')." AS c ON a.appid=c.id_phpapp WHERE a.process=5 AND b.flow=1 AND b.uid>0 AND a.paytype=1 AND a.appid NOT IN(11,5,15,16,14,21) AND a.dateline>'$dateline' AND a.dateline<'$dateline2'  GROUP BY a.appid ");
					 
					 
					 //���񵣱��� end-------------------------------------------------------
						   
					 //����----------------------------------------------------------------
					 $PropMoneyPay=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=1 AND b.uid>0 AND a.appid=11 AND a.dateline>'$dateline' AND a.dateline<'$dateline2' ");
					 //���� end----------------------------------------------------------------
					 
					 //�����ƹ�ʵ����֤----------------------------------------------------------------
					 $CertificateMoneyPay=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=1 AND b.uid>0 AND a.appid IN(15,16) AND a.dateline>'$dateline' AND a.dateline<'$dateline2' ");
					 
					 //�����ƹ�ʵ����֤ end----------------------------------------------------------------
					 
					 
					 //UC�һ����----------------------------------------------------------------
					 $UCMoneyPay=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=2 AND b.uid>0 AND a.appid=3 AND a.dateline>'$dateline' AND a.dateline<'$dateline2' ");
					 
					 //UC�һ���� end----------------------------------------------------------------
					 
					 
					 $SiteProfitMoney=$siteincome['amounts']-$sitepay['amounts'];
					 
					 
					 
				}

		  }else{
		
				$num=@date('Y')-2009;
				
				if($this->GET['value']){
				
					  $PayMoney=$DepositMoney=$ConsumeMoney=$SiteIncomeMoney=$SitePayMoney=$SiteProfitMoney=$TaskMoneyIncome=$PropMoneyIncome=$TaskMoneyIncomeApps=array();
					  for($i=1;$i<13;$i++){
						  
						   $nowdate=$this->GetNowTime($i,$this->GET['value']);
						   
						   //֧��
						   $ConsumeMoney[]= $this->GetMysqlOne('sum(amount) AS amounts'," ".$this->GetTable('consume')." WHERE paytype<3 AND process=5 AND dateline>$nowdate[0] AND dateline<$nowdate[1] ");
						   
						   
						   //��ֵ
						   $PayMoney[]= $this->GetMysqlOne('sum(amount) AS amounts'," ".$this->GetTable('consume')." WHERE paytype=3 AND process=5 AND dateline>$nowdate[0] AND dateline<$nowdate[1] ");
						   
						   
						   //����-------------------------------------------------------------
						   $DepositMoney[]= $this->GetMysqlOne('sum(amount) AS amounts'," ".$this->GetTable('consume')." WHERE paytype=4 AND process=5 AND dateline>$nowdate[0] AND dateline<$nowdate[1] "); 
						   
						   //���� end---------------------------------------------------------
						   
						   
						   
						   //��վ����
						   $siteincome=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=2 AND b.uid>0 AND a.paytype<3 AND a.dateline>$nowdate[0] AND a.dateline<$nowdate[1] ");
						   $SiteIncomeMoney[]= $siteincome;
						   
						   
						   //���񵣱���-------------------------------------------------------
						   $TaskMoneyIncome[]=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=2 AND b.uid>0 AND a.paytype=1 AND a.appid NOT IN(11,12,5,15,16,14,21,26) AND a.dateline>$nowdate[0] AND a.dateline<$nowdate[1] ");
						   
						   
						   $TaskMoneyIncomeApps[]=$this->GetMysqlArray('c.id_phpapp,c.name_phpapp,sum(a.amount) AS amounts'," (".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid) JOIN ".$this->GetTable('apps')." AS c ON a.appid=c.id_phpapp WHERE a.process=5 AND b.flow=2 AND b.uid>0 AND a.paytype=1 AND a.appid NOT IN(11,12,5,15,16,14,21,26) AND a.dateline>$nowdate[0] AND a.dateline<$nowdate[1]  GROUP BY a.appid ");
						   
						   
						   //���񵣱��� end-------------------------------------------------------
						   
						   
						   
						   
						   //����----------------------------------------------------------------
						   $PropMoneyIncome[]=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=2 AND b.uid>0 AND a.appid=11 AND a.dateline>$nowdate[0] AND a.dateline<$nowdate[1] ");
						   
	  
						   //���� end----------------------------------------------------------------
						   
						   //����VIP----------------------------------------------------------------
						   $VIPMoneyIncome[]=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=2 AND b.uid>0 AND a.appid=26 AND a.dateline>$nowdate[0] AND a.dateline<$nowdate[1] ");
						   
	  
						   //����VIP end----------------------------------------------------------------
						   
						   
						   //�û���֤----------------------------------------------------------------
						   $CertificateMoneyIncome[]=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=2 AND b.uid>0 AND a.appid IN(14,15,16,21) AND a.dateline>$nowdate[0] AND a.dateline<$nowdate[1] ");
						   
	  
						   //�û���֤ end----------------------------------------------------------------
						   
						   
	  
	  
	  
	  
						   //��վ֧��
						   $sitepay=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=1 AND b.uid>0 AND a.paytype<3 AND a.dateline>$nowdate[0] AND a.dateline<$nowdate[1] ");
						   $SitePayMoney[]= $sitepay;
						   
						   
							//���񵣱���-------------------------------------------------------
						   $TaskMoneyPay[]=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=1 AND b.uid>0 AND a.paytype=1 AND a.appid NOT IN(11,5,15,16,14,21) AND a.dateline>$nowdate[0] AND a.dateline<$nowdate[1] ");
						   
						   
						   $TaskMoneyPayApps[]=$this->GetMysqlArray('c.id_phpapp,c.name_phpapp,sum(a.amount) AS amounts'," (".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid) JOIN ".$this->GetTable('apps')." AS c ON a.appid=c.id_phpapp WHERE a.process=5 AND b.flow=1 AND b.uid>0 AND a.paytype=1 AND a.appid NOT IN(11,5,15,16,14,21) AND a.dateline>$nowdate[0] AND a.dateline<$nowdate[1]  GROUP BY a.appid ");
						   
						   
						   //���񵣱��� end-------------------------------------------------------
						   
						   //����----------------------------------------------------------------
						   $PropMoneyPay[]=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=1 AND b.uid>0 AND a.appid=11 AND a.dateline>$nowdate[0] AND a.dateline<$nowdate[1] ");
						   //���� end----------------------------------------------------------------
						   
						   //�����ƹ�ʵ����֤----------------------------------------------------------------
						   $CertificateMoneyPay[]=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=1 AND b.uid>0 AND a.appid IN(15,16) AND a.dateline>$nowdate[0] AND a.dateline<$nowdate[1] ");
						   
						   //�����ƹ�ʵ����֤ end----------------------------------------------------------------
						   
						   
						   //UC�һ����----------------------------------------------------------------
						   $UCMoneyPay[]=$this->GetMysqlOne('sum(a.amount) AS amounts'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON a.cid=b.cid WHERE a.process=5 AND b.flow=2 AND b.uid>0 AND a.appid=3 AND a.dateline>$nowdate[0] AND a.dateline<$nowdate[1] ");
						   
						   //UC�һ���� end----------------------------------------------------------------
						   
						   
						   $SiteProfitMoney[]=$siteincome['amounts']-$sitepay['amounts'];
					 
					 
				       } 
					 
				 }
				
		  }

		  include $this->Template('total_manage');
	}
	
	
	public function GetNowTime($mon,$nowyear){
			 $nowyear1=$nowyear.'-'.$mon.'-1';
			 $nowmon=$nowyear.'-'.$mon;
			 $nowday=date("t",strtotime($nowmon));
		 	 $nowyear2=$nowyear.'-'.$mon.'-'.$nowday;
		 	 $nowyear1=strtotime($nowyear1);
		 	 $nowyear2=strtotime($nowyear2); 
			 $timearr=array("$nowyear1","$nowyear2");
			 return $timearr;
	}
	
	
	public function UserPayAction(){
		   
		   
		    if($this->POST['Submit']){
				  
				   include_once(APPS.'/apppay/class/consume_class_phpapp.php');

		           $pay=new UserConsume();
		           
				   if($this->POST['PayType']==1){
				   
						 $newcid=$pay->MakeConsume(array(
										'subject'=>'<p>��ֵ</p>'.$this->POST['subject'],
										'appid'=>$this->app, 
										'paytype'=>3, 
										'process'=>1, 
										'amount'=>$this->POST['PayMoney'], 
										'payout'=>0, 
										'payin'=>$this->POST['uid'],
										'operator'=>$this->uid
										
								  ));
						 
				   }else{
					   
					     $newcid=$pay->MakeConsume(array(
										'subject'=>'<p>�۷�</p>'.$this->POST['subject'],
										'appid'=>$this->app, 
										'paytype'=>3, 
										'process'=>1, 
										'amount'=>$this->POST['PayMoney'], 
										'payout'=>$this->POST['uid'], 
										'payin'=>0,
										'operator'=>$this->uid
										
								  ));
					   
					   
				   }
		  
		           $pay->SetSuccessConsume($newcid); 
				     
						  
				   echo $this->Refresh('<p>�����ɹ�!</p>',$this->MakeGetParameterURL());
				   
				   exit();
				
			   
			   
			}elseif($this->POST['Check']){
				   
				     
				     $userinfo=$this->GetLoginInfo($this->POST['uid']);
					 
					 if(!$userinfo){
						 
						  echo $this->Refresh($this->LanguageArray('phpapp','User_does_not_exist'),$this->MakeGetParameterURL());
				 
				          exit();
						 
					 }
					 
				
			}
			

			include $this->Template('userpay_manage');
	}
	
	
	function ConfigAction(){
		
		  if($this->POST['Submit']){
				
				  $this->SetConfig($this->POST);
				
		  }else{

		          include $this->Template('config_manage');
		  
		  }
	}
	
	
	function SetConsumeInfo($ids,$isprocess=0){
	          
			  if($isprocess){
				    $process='';
			  }else{ 
				    $process=' a.process=5 AND ';
			  }
			  
	          $consumearr=$this->GetMysqlArray('*'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('member_consume')." AS b ON  a.cid=b.cid WHERE $process b.uid>0 AND a.cid IN($ids)");

			  foreach($consumearr as $value){
				  
					 $memberaccount=$this->GetMysqlOne('money'," ".$this->GetTable('member_account')." WHERE uid='$value[uid]' ");
					 $apppayaccount=$this->GetMysqlOne('money'," ".$this->GetTable('member_account')." WHERE uid='0' ");
					
					 if($value['flow']==1){
						  
						   $membernowmoney=$memberaccount['money']-$value['amount'];
						  
						   $apppaynowmoney=$apppayaccount['money']+$value['amount'];

					 }else{
						   
						   $membernowmoney=$memberaccount['money']+$value['amount'];
						  
						   $apppaynowmoney=$apppayaccount['money']-$value['amount'];
						 
					 }
				   
					 $this->Update('member_account',array('money'=>$membernowmoney),array(),"WHERE uid='$value[uid]'");
						
					 $this->Update('member_account',array('money'=>$apppaynowmoney),array(),"WHERE uid='0'");
				  
			  }
	 }
}



?>