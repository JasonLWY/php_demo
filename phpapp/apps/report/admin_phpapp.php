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

include_once(APPS.'/taskmode/public_phpapp.php');

//Manage
class ReportManageControls extends TaskPublicClass{
	
    private $actionmenu;
	
	public $app;
	
	function __construct($actionmenu=''){	 
         
		 global $appclass;
		 
		 parent::__construct();
		 
		 $this->actionmenu=$actionmenu;
		 
		 $postkey=array('Submit'=>'','checkbox'=>'');
		
		 $this->POST=$this->POSTArray();
		 
		 foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		 }
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id'));

	}

    public function DefaultAction(){
		
		   $this->ReportAction();
	}
	
	
    public function ReportAction(){
		      
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
			   
			  if(!empty($this->POST['SubmitAward'])){
				      
					  $ids=$this->GetCheckBox($this->POST['checkbox']);
		             
					  $repotrarray=$this->GetMysqlArray('tid,did,uid'," ".$this->GetTable('report')." WHERE rid IN($ids)");
					 
					  $repotrid='';
					  
					  if($repotrarray){
						 
						   foreach($repotrarray as $value){
							       
								   $userinfo=$this->GetLoginInfo($value['uid']);
								   
								   $credit=$userinfo['credit']+$this->POST['award'];
								   
                                   $this->Update('member_account',array('credit'=>$credit),array()," WHERE uid='$value[uid]'");
								   
								   $getaward='';
								   
								   if($this->POST['award']!=0){
								         $getaward='您获取得'.$this->POST['award'].' 积分。';
								   }
								   
                                   $this->Port(array(
																					
											  //SMS
											  'receive_uid'=>$value['uid'], 
											  'sms_subject'=>$userinfo['username'].'你举报的任务已处理!',
											  'sms_content'=>$userinfo['username'].'你举报的任务已处理,'.$getaward.'<a href="'.$this->GetTaskURL($value['tid'],$value['did']).'" target="_blank">查看任务</a>'
																					
								   ),7);
										
							   
						   }

						   
					  }
					   
					   
					  $this->Update('report',array('status'=>1,'award'=>$this->POST['award']),array()," WHERE rid IN($ids)");
					  
			          $refresh= '<p>处理成功！</p>';
								 
					  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			
			
			  }elseif(!empty($this->POST['Delete'])){
				  
				   $ids=$this->GetCheckBox($this->POST['checkbox']);
	
				   if($this->Delete('report'," WHERE rid IN($ids)")){
				  
						$refresh=$this->LanguageArray('phpapp','Delete_successfully');
				   
				   }else{
						$refresh=$this->LanguageArray('phpapp','Delete_failed');
	
				   }
				   
				   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				  
			  
			  }else{
				  
					 include_once(Core.'/class/pages_class_phpapp.php');
			  
					 $orderarr=array(
							  array('order'=>'a.rid','name'=>'ID'),
							  array('order'=>'a.uid','name'=>'举报者UID'),
							  array('order'=>'f.id_phpapp','name'=>'任务类型'),
							  array('order'=>'b.username','name'=>'举报类型'),
							  array('order'=>'b.username','name'=>'举报者'),
							  array('order'=>'c.subject','name'=>'任务标题'),
							  array('order'=>'c.process','name'=>'任务流程'),
							  array('order'=>'a.type','name'=>'举报理由'),
							  array('order'=>'a.status','name'=>'处理状态'),
							  array('order'=>'a.award','name'=>'奖励积分'),
							  array('order'=>'a.dateline','name'=>'申请时间')
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
			 
	
					 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,r.name,b.username,c.subject,c.appid,c.process AS tprocess,c.serviceuid,d.process AS dprocess,f.name_phpapp,f.id_phpapp FROM  ((((".$this->GetTable('report')." AS a  LEFT JOIN ".$this->GetTable('report_type')."  AS r ON a.type=r.rid  )  LEFT JOIN  ".$this->GetTable('member')." AS b ON a.uid=b.uid) LEFT JOIN ".$this->GetTable('task')." AS c ON a.tid=c.tid) LEFT JOIN ".$this->GetTable('task_draft')." AS d ON a.did=d.did) LEFT JOIN  ".$this->GetTable('apps')." AS f ON c.appid=f.id_phpapp $wheresql $order");
	
					 $list=$ajaxpage->ShowResult();
                     
					 $getprocess=new TaskProcess();
		  
		             include $this->Template('report_manage');
					 
			  }

		
	}

}

?>