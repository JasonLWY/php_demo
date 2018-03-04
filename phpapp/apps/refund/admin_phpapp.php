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
class RefundMoneyManageControls extends PHPAPP{
	
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
		
		   $this->RefundAction();
	}
	
	
    public function RefundAction(){
		      
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
	
				   if($this->Delete('refund_money'," WHERE rid IN($ids)")){
				  
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
							  array('order'=>'a.pid','name'=>'άȨԭ��'),
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
		 
	                 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.*,c.username AS buyername,c.uid AS buyeruid,d.username AS sellername ,d.uid AS selleruid FROM (".$this->GetTable('refund_money')." AS a JOIN ".$this->GetTable('refund_item')." AS b ON a.pid=b.pid) LEFT JOIN ".$this->GetTable('member')." AS c ON c.uid=a.buyeruid  LEFT JOIN ".$this->GetTable('member')." AS d ON d.uid=a.selleruid $wheresql $order"); 
						 
					 $list=$ajaxpage->ShowResult();
		  
		             include $this->Template('refund_manage');
					 
			  }

		
	}
	
	
	public function ShowAction(){
		
		  $getprocess=new TaskProcess();
			
		  $consumearr=$this->GetMysqlOne('a.*,b.oid,b.tid,b.buyeruid,b.selleruid,b.runid'," ".$this->GetTable('consume')." AS a JOIN ".$this->GetTable('task_order')." AS b ON a.cid=b.cid  WHERE a.cid='$this->cid'");
			
		  $refund=$this->GetMysqlOne('*'," ".$this->GetTable('refund_money')." WHERE rid='$this->rid'");
			
		  $sellerarr=$this->GetMysqlOne('uid,username'," ".$this->GetTable('member')." WHERE uid='$consumearr[selleruid]' ");
		  $buyerarr=$this->GetMysqlOne('uid,username'," ".$this->GetTable('member')." WHERE uid='$consumearr[buyeruid]' ");
			
		  $refunditemarr=$this->GetMysqlOne('*'," ".$this->GetTable('refund_item')." WHERE status=0 AND pid='$refund[pid]' ");

		 if(!empty($this->POST['Submit'])){
			      
				   if($this->IsSQL('refund_money',"WHERE rid='$this->rid' AND process=3")){
						   echo $this->Refresh('�ö����˿��Ѿ��������!',$this->MakeGetParameterURL(array('action'=>1)));
						   exit();
				   }
				   
				   
				   if($refund['process']==2){
					   
					       if($this->POST['money']>$refund['money']){

							     $refresh='�Բ����˿���ܳ�������Ҫ���� '.$refund['money'].'Ԫ��';
								 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
								 exit();
								 
						   }elseif($this->POST['money']<$refund['money']){
							     //���¶���
							     $this->Update('refund_money',array('money'=>$this->POST['money']),array(),"WHERE rid='$this->rid'");
								 $this->Update('consume',array('refundmoney'=>$this->POST['money']),array(),"WHERE cid='$this->cid'");
								 
						   }
					       
						   //�˿�
						   require_once(APPS.'/order/member_phpapp.php');
			
						   $order=new OrderMemberControls();
						   $order->PayTaskOrder($consumearr['cid'],1);
						   
						   
						   //�ɹ�
						   //֪ͨ����
						   $send_subject='������ˮ�� '.$consumearr['serial'].' ͬ���˿�����!';
						   $send_content='���� '.$sellerarr['username'].' ͬ���������˿�����!<a href="'.SURL.'/member.php?app='.$this->app.'&action=1&cid='.$this->cid.'&rid='.$this->rid.'&op=1" target="_blank">[�鿴��ϸ]</a>';
			
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
									
											
						   ),19);
						   
						   $this->Update('refund_money',array('process'=>3),array(),"WHERE rid='$this->rid'");
						  
						   $refresh= $this->LanguageArray('phpapp','Operate_successfully');
				   
				   }else{
				     
				         $refresh='�������Ҳ�ͬ��ʱ�����ܲ����˿';
	               }

				   
				   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			  
		  }else{
				  include $this->Template('process_manage');
		  }
	}

}

?>