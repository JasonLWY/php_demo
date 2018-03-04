<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

require_once(APPS.'/apppay/class/process_class_phpapp.php');

//Manage
class RightsManageControls extends PHPAPP{
	
    private $actionmenu;
	
	public $app,$cid,$rid;
	
	function __construct($actionmenu=''){	 
         
		 global $appclass;
		 
		 parent::__construct();
		 
		 $this->actionmenu=$actionmenu;
		 
		 $postkey=array('Submit'=>'','checkbox'=>'');
		 
		 $this->cid=empty($_GET['cid']) ? 0 : intval($_GET['cid']);
		 $this->rid=empty($_GET['rid']) ? 0 : intval($_GET['rid']);
		 
		 $this->POST=$this->POSTArray();
		 
		 foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		 }
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id'));

	}

    public function DefaultAction(){
		
		   $this->RightsAction();
	}
	
	
    public function RightsAction(){
		      
			  //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(
															
														'rid'=>array('a.rid','int'),
														'tid'=>array('a.tid','int'),
														'did'=>array('d.did','int'),
														'uid'=>array('b.uid','int'),
														'username'=>array('b.username','string'),
														'dateline1'=>array('a.dateline','time'),
														'dateline2'=>array('a.dateline','time')
															  
												      ) 
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }
			   
			   
			   //select end----------------------------------------------------
			 
			 if(!empty($this->POST['Delete'])){
				  
				   $ids=$this->GetCheckBox($this->POST['checkbox']);
	
				   if($this->Delete('rights'," WHERE rid IN($ids)")){
				  
						$refresh=$this->LanguageArray('phpapp','Delete_successfully');
				   
				   }else{
						$refresh=$this->LanguageArray('phpapp','Delete_failed');
	
				   }
				   
				   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				  
			  
			  }else{
				  
					 include_once(Core.'/class/pages_class_phpapp.php');
			  
					 $orderarr=array(
							  array('order'=>'a.rid','name'=>'ID'),
							  array('order'=>'a.oid','name'=>'�������'),  	
							  array('order'=>'a.tid','name'=>'������'),  
							  array('order'=>'a.serviceuid','name'=>'�ͷ�UID'),  
							  array('order'=>'a.buyeruid','name'=>'��ҹ���'),
							  array('order'=>'a.selleruid','name'=>'��������'),
							  array('order'=>'a.sid','name'=>'άȨԭ��'),
							  array('order'=>'a.process','name'=>'��������'),
							  array('order'=>'a.dateline','name'=>'����ʱ��')
							  );
			  
					 $order='ORDER BY a.rid DESC';
			  
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
		 
	                 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.*,c.username AS buyername,c.uid AS buyeruid,d.username AS sellername ,d.uid AS selleruid FROM (".$this->GetTable('rights')." AS a JOIN ".$this->GetTable('security_item')." AS b ON a.sid=b.sid) LEFT JOIN ".$this->GetTable('member')." AS c ON c.uid=a.buyeruid  LEFT JOIN ".$this->GetTable('member')." AS d ON d.uid=a.selleruid $wheresql $order"); 
						 
					 $list=$ajaxpage->ShowResult();
		  
		             include $this->Template('rights_manage');
					 
			  }

		
	}
	
	
	public function ShowAction(){
		
		  $getprocess=new TaskProcess();
			
		  $consumearr=$this->GetMysqlOne('a.*,b.oid,b.tid,b.buyeruid,b.selleruid,b.runid'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('task_order')." AS b ON a.cid=b.cid  WHERE a.cid='$this->cid'");
			
		  $refund=$this->GetMysqlOne('*'," ".$this->GetTable('rights')." WHERE rid='$this->rid'");
			
		  $sellerarr=$this->GetMysqlOne('uid,username'," ".$this->GetTable('member')." WHERE uid='$consumearr[selleruid]' ");
		  $buyerarr=$this->GetMysqlOne('uid,username'," ".$this->GetTable('member')." WHERE uid='$consumearr[buyeruid]' ");
			
		  $refunditemarr=$this->GetMysqlOne('*'," ".$this->GetTable('security_item')." WHERE status=0 AND sid='$refund[sid]' ");

		 if(!empty($this->POST['Submit'])){
			      
				   if($this->IsSQL('rights',"WHERE rid='$this->rid' AND process=3")){
						   echo $this->Refresh('�ö���άȨ�Ѿ��������!',$this->MakeGetParameterURL(array('action'=>1)));
						   exit();
				   }
				  
				   if($this->POST['money']>0){
						
						$money=floatval($this->POST['money']);
						
						if($this->IsSQL('member_security_certificate'," WHERE uid='$consumearr[selleruid]' AND sid='$refund[sid]' AND status=5 AND price>='$money'")){
							
							  require_once(APPS.'/security/member_phpapp.php');
							  
							  $security=new SecurityMemberControls();
							  
							  $security->SecurityDeduction($this->rid,$refund['sid'],$consumearr['selleruid'],$consumearr['buyeruid'],$money,$refunditemarr,$consumearr);
							
						}else{
							
							  $refresh= '����'.$sellerarr['username'].' û����֤'.$refunditemarr['project'].' ���Ͻ���Ͻ���'.$money.'Ԫ�����ܿ۳���';
				  
				  			  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
							  exit();
						}
						
						
					   
				   }
				   
				   //credit
				   $credit=intval($this->POST['credit']);
				   if($credit){
						   if($this->IsSQL('credit'," WHERE uid='$consumearr[selleruid]' AND type=1 ")){
							     $creditarr=$this->GetMysqlOne('credit,cha'," ".$this->GetTable('credit')." WHERE uid='$consumearr[selleruid]' AND type=1 ");
								 $this->Update('credit',array('credit'=>$creditarr['credit']-$credit,'cha'=>$creditarr['cha']+1),array()," WHERE uid='$consumearr[selleruid]' AND type=1");
						   }else{
							   
							     $this->Insert('credit',array('uid'=>$consumearr['selleruid'],'type'=>1,'credit'=>-$credit,'cha'=>1),array());
						   }
						   

						   $this->Insert('rights_credit',array('uid'=>$consumearr['selleruid'],'rid'=>$this->rid,'credit'=>$credit,'dateline'=>$this->NowTime()),array());
				   
						   //����
						   $send_subject=$refunditemarr['project'].' ���Ϸ���άȨ�۳����û���֪ͨ!';
							   
						   $send_content='�𾴵��û������������ '.$refunditemarr['project'].' ���Ϸ���άȨЭ����,�ͷ��۳��������û��� '.$credit.' �� <a href="'.SURL.'/member.php?app=42&action=2&cid='.$consumearr['cid'].'&rid='.$this->rid.'&op=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>';
						   
				   }else{
					   
					       $send_subject=$refunditemarr['project'].' ���Ϸ���άȨ����֪ͨ!';
							   
						   $send_content='�𾴵��û������������ '.$refunditemarr['project'].' ���Ϸ���άȨЭ����,δ�۳��������û��� <a href="'.SURL.'/member.php?app=42&action=2&cid='.$consumearr['cid'].'&rid='.$this->rid.'&op=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>';
					      
				   }
				   
						   //�ӿ�
						   $this->Port(array(
											
								  'receive_uid'=>$consumearr['selleruid'], //������
								  
								  //SMS
								  'sms_subject'=>$send_subject,
								  'sms_content'=>$send_content,
												
								  //EMail
								  'email_title'=>$send_subject,
								  'email_content'=>$send_content,
		
								  //Mobile
								  'mobile_content'=>$send_subject
									
											
						   ),17);
						   
						   
						   //����
						if($credit){	   
						      $send_content='�𾴵��û���������� '.$refunditemarr['project'].' ���Ϸ���άȨЭ����,�ͷ��۳����ҵ����û��� '.$credit.' �� <a href="'.SURL.'/member.php?app=42&action=1&cid='.$consumearr['cid'].'&rid='.$this->rid.'&op=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>';
						}else{
							  $send_content='�𾴵��û���������� '.$refunditemarr['project'].' ���Ϸ���άȨЭ���� <a href="'.SURL.'/member.php?app=42&action=1&cid='.$consumearr['cid'].'&rid='.$this->rid.'&op=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>';
						}
		
						   //�ӿ�
						   $this->Port(array(
											
								  'receive_uid'=>$consumearr['buyeruid'], //������
								  
								  //SMS
								  'sms_subject'=>$send_subject,
								  'sms_content'=>$send_content,
												
								  //EMail
								  'email_title'=>$send_subject,
								  'email_content'=>$send_content,
		
								  //Mobile
								  'mobile_content'=>$send_subject
									
											
						   ),17);
							   
		
				   
				   $this->Update('rights',array('process'=>3),array(),"WHERE rid='$this->rid'");
				  
				   $refresh= $this->LanguageArray('phpapp','Operate_successfully');
				  
				   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			  
		  }else{
				  include $this->Template('process_manage');
		  }
	}

}

?>