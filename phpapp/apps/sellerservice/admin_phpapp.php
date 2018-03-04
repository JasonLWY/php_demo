<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(APPS.'/sellerservice/member_phpapp.php');
include_once(Core.'/class/admin_class_phpapp.php');

//Manage
class SellerServiceManageControls extends SellerServiceMemberControls{
	
    private $actionmenu;
	
	public $app,$lang;
	
	function __construct($actionmenu=''){	 
         
		 global $appclass;
		 
		 parent::__construct();
		 
		 $this->actionmenu=$actionmenu;
		 
		 $this->app=$appclass['id_phpapp'];
		 
		 $postkey=array('Submit'=>'','checkbox'=>'');
		
		 $this->POST=$this->POSTArray();
		 
		 foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		 }
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id'));

	}
	
	//Default
	public function DefaultAction(){
		
		  return $this->TaskAdminAction();
		
	}
	
	//任务管理
	public function TaskAdminAction(){
		     
			  //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(
															
														'subject'=>array('a.subject','search'), 
														'tid'=>array('a.tid','int'),
														'oid'=>array('c.oid','search'),
														'uid'=>array('b.uid','int'),
														'username'=>array('b.username','string'),
														'process'=>array('a.process','int'),
														'dateline1'=>array('a.dateline','time'),
														'dateline2'=>array('a.dateline','time'),
														'endtime1'=>array('a.endtime','time'),
														'endtime2'=>array('a.endtime','time')
															  
												      ) 
													  
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }
			   
			  if($wheresql){
				    $wheresql.=' AND a.appid=82 ';
			  }else{
				    $wheresql=' WHERE a.appid=82 ';
			  }

			  //select end----------------------------------------------------
			   
			   if(!empty($this->POST['CloseVerify'])){
				   
				    $ids=$this->GetCheckBox($this->POST['checkbox']);
				  
	                $idarr=explode(',',$ids);
				  
				    foreach($idarr as $tid){
						  
						   if($this->IsSQL('task'," WHERE tid='$tid' AND process>2 AND process<7 ")){
							     $this->Update('task',array('process'=>3),array(),"WHERE tid='$tid' AND process>2 AND process<7");
								 $refresh.='<p>'.$tid.'号任务取消审核成功！</p>';
						   }else{
							     $refresh.='<p>'.$tid.'号任务已结束关闭或未支付赏金不能取消审核！</p>';
						   }
						
					}
								 
					echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			  
			   }elseif(!empty($this->POST['Verify'])){
				    
					$ids=$this->GetCheckBox($this->POST['checkbox']);
					
	                $idarr=explode(',',$ids);
					
					foreach($idarr as $tid){
						  
						   if($this->IsSQL('task'," WHERE tid='$tid' AND process=3 ")){
							     $this->Update('task',array('process'=>4),array(),"WHERE tid='$tid' AND process=3");
								 $refresh.='<p>'.$tid.'号任务审核成功！</p>';
						   }else{
							     $refresh.='<p>'.$tid.'号任务未支付托管金或已审核过了！</p>';
						   }
						
					}
								 
					echo $this->Refresh($refresh,$this->MakeGetParameterURL());
					
			   }elseif(!empty($this->POST['RefundClose'])){
				    
					 $ids=$this->GetCheckBox($this->POST['checkbox']);
						 
					 if($ids){
						   
						   $task=$this->GetMysqlArray('*'," ".$this->GetTable('task')." WHERE tid IN($ids)");
						   
						   @include_once(APPS.'/apppay/class/consume_class_phpapp.php');
						   $pay=new UserConsume();
							  
                           foreach($task as $value){
							      
								  if($this->IsSQL('task'," WHERE tid='$value[tid]' AND process>7 ")){
									   $refresh.='<p>'.$value['tid'].'号任务已经关闭过了！</p>';
								  }elseif($this->IsSQL('task'," WHERE tid='$value[tid]' AND process>2 AND process<7 ")){
								       $this->TaskRefund($pay,$value);
									   $refresh.='<p>'.$value['tid'].'号任务操作成功！</p>';
								  }else{
									   $refresh.='<p>'.$value['tid'].'号任务未支付不能退款！</p>';
								  }
							   
						   }

					 }
								 
					 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			   
			  }elseif(!empty($this->POST['Close'])){
				    
					$ids=$this->GetCheckBox($this->POST['checkbox']);
 
	                $this->Update('task',array('process'=>9),array(),"WHERE tid IN($ids)");  
				   
					$refresh='<p>关闭成功！</p>';
								 
					echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						
			  }elseif(!empty($this->POST['Delete'])){
	               
				   if($this->uid==1){
					   
						 $ids=$this->GetCheckBox($this->POST['checkbox']);
						 
						 if($this->Delete('task'," WHERE tid IN($ids)")){
						
							  $refresh=$this->LanguageArray('phpapp','Delete_successfully');
									   
							  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						 
						 }else{
							  $refresh=$this->LanguageArray('phpapp','Delete_failed');
									   
							  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						 }
						 
				   }else{
					   
					      echo $this->Refresh('对不起！该功能只有创始人才能操作！',$this->MakeGetParameterURL());
				   }
			  
			  }else{
				  
					 include_once(Core.'/class/pages_class_phpapp.php');
			  
					 $orderarr=array(
							  array('order'=>'a.tid','name'=>'ID'),
							  array('order'=>'a.uid','name'=>'发布者UID'),
							  array('order'=>'b.username','name'=>'发布者'),
							  array('order'=>'a.money','name'=>'赏金'),
							  array('order'=>'a.subject','name'=>'标题'),
							  array('order'=>'a.process','name'=>'流程'),
							  array('order'=>'a.endtime','name'=>'结束时间'),
							  array('order'=>'a.dateline','name'=>'发布时间')
							  );
			  
					 $order='ORDER BY a.tid DESC';
			  
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
			 
	
					 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.username,c.oid FROM  (".$this->GetTable('task')." AS a LEFT JOIN  ".$this->GetTable('member')." AS b ON a.uid=b.uid) LEFT JOIN ".$this->GetTable('task_order')." AS c ON a.tid=c.tid $wheresql GROUP BY tid $order");
	
					 $list=$ajaxpage->ShowResult();
                     
					 $getprocess=new TaskProcess();
		  
		             include $this->Template('task_manage');
					 
			  }
			  
	}
	
	
	public function EditTaskAdminAction(){
		  
		  
		   if(!empty($this->POST['Submit'])){
			      
				  $id=empty($this->GET['id']) ? 0 : $this->GET['id'];
				  
				  $this->POST['endtime']=time()+24*60*60*$this->POST['endtime'];
				  
				  //SEO
				  $this->POST['description']=$this->str($this->POST['content'],80,0,1,1,0,1);
	
				  $this->Update('task',$this->POST,array(),"WHERE tid='$id'");  
				  
				  $refresh= '<p>修改成功!</p>';
				  
				  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			   
		   }else{
		  
				 $id=empty($this->GET['id']) ? 0 : $this->GET['id'];
				
				 $task=$this->GetMysqlOne('*'," ".$this->GetTable('task')." WHERE tid='$id'");
				 
				 if($task){
					  
					  include $this->Template('edittask_manage');
					  
				 }else{
					 
					  $refresh= '<p>任务不存在!</p>';
					  echo $this->Refresh($refresh,$this->MakeGetParameterURL().'&action=20');
				 }
				 
		   }
		  
	}
	
	public function EditDraftAction(){
		  
		   $admindraft=1;
		   
		   if(!empty($this->POST['Submit'])){
			      
				  $id=empty($this->GET['id']) ? 0 : $this->GET['id'];

				  $this->Update('task_draft',$this->POST,array(),"WHERE did='$id'");  
				  
				   $files=$this->UploadFile();
												   
				   if($files){
						 foreach($files as $fid){
							  $this->Insert('apps_file',array('appid'=>$this->app,'fid'=>$fid,'uid'=>$this->uid,'id'=>$id,'type'=>2),array());
						 }
				   }
				  
				   echo '<p>修改成功!</p>';
				  
				   echo $this->CloseNowWindows('#loading');
			   
		   }else{
		  
				 $did=empty($this->GET['id']) ? 0 : $this->GET['id'];
				
				 $draft=$this->GetMysqlOne('*'," ".$this->GetTable('task_draft')." WHERE did='$did'");
				 
				 if($draft){
					  
					  include $this->Template('editdraft_manage');
					  
				 }else{
					 
					  $refresh= '<p>稿件不存在!</p>';
					  echo $this->Refresh($refresh,$this->MakeGetParameterURL().'&action=21');
				 }
				 
		   }
		  
	}
	
	//稿件管理
	public function DraftAdminAction(){
		
		      //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(
															
														'did'=>array('a.did','int'),
														'tid'=>array('a.tid','int'),
														'uid'=>array('b.uid','int'),
														'username'=>array('b.username','string'),
														'process'=>array('a.process','int'),
														'dateline1'=>array('a.dateline','time'),
														'dateline2'=>array('a.dateline','time')
															  
												      ) 
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }
                
			  if($wheresql){
				    $wheresql.=' AND a.appid=82 ';
			  }else{
				    $wheresql=' WHERE a.appid=82 ';
			  }
			  
			   //select end----------------------------------------------------
			   
		      if(!empty($this->POST['Submit'])){
	               
				   $ids=$this->GetCheckBox($this->POST['checkbox']);
				   
				   if($this->Delete('task_draft'," WHERE did IN($ids)")){
				  
						$refresh=$this->LanguageArray('phpapp','Delete_successfully');
								 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				   
				   }else{
						$refresh=$this->LanguageArray('phpapp','Delete_failed');
								 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				   }
				  
			  
			  }else{
				  
					 include_once(Core.'/class/pages_class_phpapp.php');
			  
					 $orderarr=array(
							  array('order'=>'a.did','name'=>'ID'),
							  array('order'=>'a.uid','name'=>'发布者UID'),
							  array('order'=>'b.username','name'=>'发布者'),
							  array('order'=>'a.dateline','name'=>'发布时间')
							  );
			  
					 $order='ORDER BY a.did DESC';
			  
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
			 
	
					 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.username FROM  ".$this->GetTable('task_draft')." AS a LEFT JOIN  ".$this->GetTable('member')." AS b ON a.uid=b.uid $wheresql $order");
	
					 $list=$ajaxpage->ShowResult();
                     
					 $getprocess=new TaskProcess();
		  
		             include $this->Template('draft_manage');
					 
			  } 
		
		  
	}
	
	
	
	//留言管理
	public function MessageAdminAction(){
		      
			  //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(
															
														'mid'=>array('a.mid','int'),
														'tid'=>array('a.tid','int'),
														'uid'=>array('b.uid','int'),
														'username'=>array('b.username','string'),
														'dateline1'=>array('a.dateline','time'),
														'dateline2'=>array('a.dateline','time')
															  
												      ) 
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }
			   
			  if($wheresql){
				    $wheresql.=' AND a.appid=82 ';
			  }else{
				    $wheresql=' WHERE a.appid=82 ';
			  }
			  
			   //select end----------------------------------------------------
			   
			   
		      if(!empty($this->POST['Submit'])){
				  
				   $ids=$this->GetCheckBox($this->POST['checkbox']);
	
				   if($this->Delete('task_message'," WHERE mid IN($ids)")){
				  
						$refresh=$this->LanguageArray('phpapp','Delete_successfully');
								 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				   
				   }else{
						$refresh=$this->LanguageArray('phpapp','Delete_failed');
								 
						echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				   }
				  
			  
			  }else{
				  
					 include_once(Core.'/class/pages_class_phpapp.php');
			  
					 $orderarr=array(
							  array('order'=>'a.mid','name'=>'ID'),
							  array('order'=>'a.tid','name'=>'任务ID'),
							  array('order'=>'a.uid','name'=>'发布者UID'),
							  array('order'=>'b.username','name'=>'发布者'),
							  array('order'=>'a.content ','name'=>'内容'),
							  array('order'=>'a.dateline','name'=>'发布时间')
							  );
			  
					 $order='ORDER BY a.mid DESC';
			  
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
			 

					 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.username FROM  ".$this->GetTable('task_message')." AS a LEFT JOIN  ".$this->GetTable('member')." AS b ON a.uid=b.uid $wheresql $order");
	
					 $list=$ajaxpage->ShowResult();
		  
		             include $this->Template('message_manage');
					 
			  } 
		
		   
	}



    //基本配置
	public function ConfigAdminAction(){


            if($this->POST['Submit']){
				
				   $this->SetConfig($this->POST);
				
			}else{


		          include $this->Template('config_manage');
			}
	
	}

   
    //应用信息
	public function CopyRightAction(){
		
		    include_once(APPS.'/sellerservice/version_phpapp.php');
		          
			include $this->Template('copyright_manage');
		
		
	}
	

	public function SelectAction(){
		 
		 
		    if(!empty($this->POST['Submit'])){
	
	               $ids=$this->GetCheckBox($this->POST['checkbox']);
				  
				   if($this->Delete('task_seller_select'," WHERE catid IN($ids)")){
				  
						$refresh=$this->LanguageArray('phpapp','Delete_successfully');
				   
				   }else{
						$refresh=$this->LanguageArray('phpapp','Delete_failed');
								 
				   }
				   
				   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			  
			}else{
				  
				 include_once(Core.'/class/pages_class_phpapp.php');
	  
				 $orderarr=array(
							array('order'=>'catid','name'=>'ID'),
							array('order'=>'name','name'=>'名称'),
							array('order'=>'code','name'=>'代码'),
							array('order'=>'status','name'=>'状态'),
							);
			
				   $order='ORDER BY catid DESC';
			
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
			
				   $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM ".$this->GetTable('task_seller_select')." $order");
		
				   $list=$ajaxpage->ShowResult();
		
				   include $this->Template('select_manage');
		   
			}
		
	}
	
	
	
	public function AddSelectAction(){
        
				 
			 if(!empty($this->POST['Submit'])) {
				 
					
					$catid=$this->Insert('task_seller_select',$this->POST);
  
					$refresh=$this->LanguageArray('phpapp','Add_success');
						 
					echo $this->Refresh($refresh,$this->MakeGetParameterURL().'&id='.$catid);
					
					exit();

			 }else{
				 
				    $select=$this->GetMysqlArray('*'," ".$this->GetTable('task_seller_select')." ORDER BY displayorder ASC");
		   
					include $this->Template('addselect_manage');
			 
			 }
		  
	}
	
	
	public function EditSelectAction(){
			  
			 $id=empty($this->GET['id']) ? 0 : $this->GET['id'];
			
			 if(!empty($this->POST['Submit'])) {

				    $this->Update('task_seller_select',$this->POST,array()," WHERE catid='$id'");
  
					$refresh=$this->LanguageArray('phpapp','Edited_successfully');
						 
					echo $this->Refresh($refresh,$this->MakeGetParameterURL().'&id='.$id);
					
					exit();

			 }else{
				 
				    $select=$this->GetMysqlArray('*'," ".$this->GetTable('task_seller_select')." ORDER BY displayorder ASC");
					
					$manage=$this->GetMysqlOne('*'," ".$this->GetTable('task_seller_select')." WHERE catid='$id'");
		   
					include $this->Template('addselect_manage');
			 
			 }
		  
	}
	
	
	
	public function EditServiceAction(){
		  
		   $adminservice=1;
		   
		   $this->sid=$sid=empty($this->GET['id']) ? 0 : $this->GET['id'];
		  
		   $service=$this->GetMysqlOne('*'," ".$this->GetTable('task_seller_service')." WHERE sid='$sid'");
		  
		   if(!empty($this->POST['submit'])){
			      
				  $description=$this->str($this->POST['content'],200,0,1,1,0,1);
				  if(strlen($this->POST['content'])>200){
					    $description.='...';
				  }
				  $this->POST['description']=$description;

				  $this->Update('task_seller_service',$this->POST,array(),"WHERE sid='$sid'");  
				  
				  //封面
				  include_once(Core.'/class/photo_upload_phpapp.php');


				   if($_FILES['logophoto']['size']>0){
						 
						 if($_FILES['logophoto']['size']> intval(PHPAPP::$config['oneimageuploadsize'])){
								$errors='对不起!您上传的图片不能超过 '.(PHPAPP::$config['oneimageuploadsize']/1024).'KB,请重新上传！'; 									                      
								$this->SubmitServiceForm($errors);
	   
					    }
											   
						 $logoid=empty($service['logo']) ? 0 : intval($service['logo']);
						 
						 $upload=new UploadPhoto($_FILES['logophoto'],$logoid,160,160);
						 $logophoto=$upload->CheckUpload();
						 
				   }else{
						 
						 if(!empty($service['logo'])){
							   
							   $logophoto=intval($service['logo']);
							 
							 
						 }
						 /*
						 else{
							 
							   $this->Refresh('对不起！,请上传服务封面图片!',$this->MakeGetParameterURL().'&action=23');
							   
							   exit();
							   
						 }
						 */
						
				   }
			  
				  
				   //上传文件
				   $files=$this->UploadFile();
				   
				   if($files){
						 foreach($files as $fid){
							  $this->Insert('apps_file',array('appid'=>$this->app,'fid'=>$fid,'uid'=>$this->uid,'id'=>$sid,'type'=>1),array());
						 }
						 
						 $this->ReplaceFileContent($files,'task_seller_service',$this->POST['content']," WHERE sid='$sid' ");
				   }
				  
				   $refresh= '修改成功!';
				   $this->SubmitServiceForm($refresh,1);
				   //echo $this->Refresh($refresh,$this->MakeGetParameterURL(array('action'=>23)));
			   
		   }else{
		  
				 
				 if($service){
					  
					  include $this->Template('editservice_manage');
					  
				 }else{
					 
					  $refresh= '服务不存在!';
					  $this->SubmitServiceForm($refresh);
					  //echo $this->Refresh($refresh,$this->MakeGetParameterURL(array('action'=>21)));
				 }
				 
		   }
		  
	}
	
	function SellServiceAction(){
		   
		           
		     //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){

					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(
	
														'subject'=>array('a.subject','search'),
														'sid'=>array('a.sid','int'),
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
			  
		     //TOP------------------------------------------ 
             $tasktop=0;
			 
			 if(!empty($this->POST['ListTop'])){  

                    $tasktop=1;
			 }
			 
			 if(!empty($this->POST['ListTop']) || !empty($this->POST['TopClose'])){   
			 
			        $ids=$this->GetCheckBox($this->POST['checkbox']);
				
					$idarr=explode(',',$ids);
				  
				    foreach($idarr as $sid){

							$this->Update('task_seller_service',array('topbid'=>$tasktop),array(),"WHERE sid='$sid'"); 
	
					}
				   
					$refresh='<p>设置成功！</p>';
								 
					echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			 }
					
			 //TOP end------------------------------------------ 		
			 
		   if(!empty($this->POST['Submit'])){
	
	               $ids=$this->GetCheckBox($this->POST['checkbox']);
				  
				   if($this->Delete('task_seller_service'," WHERE sid IN($ids)")){
				  
						$refresh=$this->LanguageArray('phpapp','Delete_successfully');
				   
				   }else{
						$refresh=$this->LanguageArray('phpapp','Delete_failed');
								 
				   }
				 
				   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			  
			}else{
				  
				 include_once(Core.'/class/pages_class_phpapp.php');
	  
				 $orderarr=array(
							array('order'=>'a.sid','name'=>'ID'),
							array('order'=>'a.uid','name'=>'发布者ID'),
							array('order'=>'b.username','name'=>'用户名'),
							array('order'=>'a.subject','name'=>'标题'),
							array('order'=>'a.price','name'=>'价格'),
							array('order'=>'a.sellnum','name'=>'出售次数'),
							array('order'=>'a.dateline','name'=>'发布时间'),
							array('order'=>'a.status','name'=>'状态'),
							);
			
				   $order='ORDER BY a.sid DESC';
			
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
			
				   $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.username FROM ".$this->GetTable('task_seller_service')." AS a LEFT JOIN ".$this->GetTable('member')." AS b ON a.uid=b.uid $wheresql $order");
		
				   $list=$ajaxpage->ShowResult();
		
				   include $this->Template('sellservice_manage');
		   
			}
		

	}
	
	public function TaskRefundAction(){
		       
			   //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(
															
														'rid'=>array('a.rid','int'),
														'tid'=>array('a.tid','int'),
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
			   
			   if(!empty($this->POST['Refuse'])){
				      
					  $ids=$this->GetCheckBox($this->POST['checkbox']);
					  
					  $this->Update('task_seller_refund',array('status'=>3),array(),"WHERE rid IN($ids)");
					  
					  
					  $taskkarray=$this->GetMysqlArray('b.uid,b.tid,b.subject'," ".$this->GetTable('task_seller_refund')." AS a LEFT JOIN ".$this->GetTable('task')." AS b ON a.tid=b.tid WHERE a.rid IN($ids)");
			   
					  if($taskkarray){
					       
						   
							 foreach($taskkarray as $value){
						
								   $this->Port(array(
												  
												  //SMS
												  'sms_msggoid'=>$value['uid'], //收件人
												  'sms_msgtoid'=>0,
												  'sms_mailbox'=>'1',
												  'sms_subject'=>$value['tid'].'任务申请退款失败!',
												  'sms_content'=>'尊敬的用户!您申请的 <a href="'.$this->GetTaskURL($value['tid']).'" target="_blank">'.$value['subject'].'</a> 任务退款失败!有其它问题请与客服沟通,谢谢支持！',
												  
												  //EMail
												  'email_uid'=>$value['uid'],
												  'email_title'=>$value['tid'].'任务申请退款失败!',
												  'email_content'=>'尊敬的用户!您申请的 <a href="'.$this->GetTaskURL($value['tid']).'" target="_blank">'.$value['subject'].'</a> 任务退款失败!有其它问题请与客服沟通,谢谢支持！',
												  
												   //Mobile
											       'mobile_uid'=>$value['uid'],
											       'mobile_content'=>$value['tid'].'号任务退款成功!'
												  
												  
								   ));
								   
							 }
								 
					  }
					  
				   
				      $refresh= '<p>拒绝成功！</p>';
								 
				      echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				   
			   
			   }elseif(!empty($this->POST['Agree'])){
				     
					 $ids=$this->GetCheckBox($this->POST['checkbox']);
					 
                     include_once(APPS.'/apppay/class/consume_class_phpapp.php');
			  
					 $pay=new UserConsume();
					 
					 $this->Update('task_seller_refund',array('status'=>2),array(),"WHERE rid IN($ids)");
					 
					 $taskarray=$this->GetMysqlArray('*'," ".$this->GetTable('task_seller_refund')." AS a LEFT JOIN ".$this->GetTable('task')." AS b ON a.tid=b.tid WHERE a.rid IN($ids)");
					 
					 if($taskarray){
						 
						   foreach($taskarray as $task){
								 $this->TaskRefund($pay,$task);
						   }
					 }
					 
			         $refresh= '<p>退款成功！</p>';
								 
				     echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			   
				 
			   }elseif(!empty($this->POST['Delete'])){
				    
				   $ids=$this->GetCheckBox($this->POST['checkbox']);
	
				   if($this->Delete('task_seller_refund'," WHERE rid IN($ids)")){
				  
						$refresh=$this->LanguageArray('phpapp','Delete_successfully');
				   
				   }else{
						$refresh=$this->LanguageArray('phpapp','Delete_failed');
		
				   }
				   
				   echo $this->Refresh($refresh,$this->MakeGetParameterURL());

			  
			  }else{
				  
					 include_once(Core.'/class/pages_class_phpapp.php');
			  
					 $orderarr=array(
							  array('order'=>'a.rid','name'=>'ID'),
							  array('order'=>'a.uid','name'=>'发布者UID'),
							  array('order'=>'b.username','name'=>'发布者'),
							  array('order'=>'c.money','name'=>'赏金'),
							  array('order'=>'c.subject','name'=>'任务标题'),
							  array('order'=>'a.content','name'=>'退款理由'),
							  array('order'=>'c.process','name'=>'流程'),
							  array('order'=>'a.status','name'=>'退款状态'),
							  array('order'=>'a.dateline','name'=>'申请时间')
							  );
			  
					 $order='ORDER BY a.tid DESC';
			  
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
			 
	
					 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.username,c.subject,c.money,c.process,c.endtime,c.dateline FROM  (".$this->GetTable('task_seller_refund')." AS a LEFT JOIN  ".$this->GetTable('member')." AS b ON a.uid=b.uid) LEFT JOIN ".$this->GetTable('task')." AS c ON a.tid=c.tid $wheresql $order");
	
					 $list=$ajaxpage->ShowResult();
                     
					 $getprocess=new TaskProcess();
		  
		             include $this->Template('taskrefund_manage');
					 
			  }

		   
	}
	
	function TaskRefund($pay,$task){
		
		   if($this->IsSQL('task'," WHERE tid='$task[tid]' AND process>2 AND process<7 ")){
				//退款
				$this->Update('task',array('process'=>9,'endtime'=>$this->NowTime()),array(),"WHERE tid='$task[tid]' AND process>2 AND process<7 ");
				
				//财富
				$member=$this->GetLoginInfo($task['uid']);
						 
				$this->Update('member_account',array('wealth'=>$member['wealth']-$task['money']),array(),"WHERE uid='$task[uid]'");
				
				$newcid=$pay->MakeConsume(array(
						 'subject'=>'系统退担保金', 
						 'appid'=>intval($this->app),
						 'process'=>1,
						 'amount'=>$task['money'],
						 'paytype'=>1, 
						 'payout'=>0,   
						 'payin'=>$task['uid']
						 
				   ));
  
				$pay->SetSuccessConsume($newcid);
				
				
				   if($task){
					       
						
							   $this->Port(array(
											  
											  //SMS
											  'sms_msggoid'=>$task['uid'], //收件人
											  'sms_msgtoid'=>0,
											  'sms_mailbox'=>'1',
											  'sms_subject'=>$task['tid'].'任务退款成功!',
											  'sms_content'=>'尊敬的用户!您的 <a href="'.$this->GetTaskURL($task['tid']).'" target="_blank">'.$task['subject'].'</a> 任务退款成功!有其它问题请与客服沟通,谢谢支持！',
											  
											  //EMail
											  'email_uid'=>$task['uid'],
											  'email_title'=>$task['tid'].'任务退款成功!',
											  'email_content'=>'尊敬的用户!您的 <a href="'.$this->GetTaskURL($task['tid']).'" target="_blank">'.$task['subject'].'</a> 任务退款成功!有其它问题请与客服沟通,谢谢支持！', 
											  
											  //Mobile
											  'mobile_uid'=>$task['uid'],
											  'mobile_content'=>$task['tid'].'号任务退款成功!'
											  
											  
							   ));
				
								 
					  }
		   }

	}
	
	
	public function AddAllowAction(){
		
			     $usergrouparray=$this->GetMysqlArray('*'," ".$this->GetTable('usergroup')." ");          
				 
			     if(!empty($this->POST['Submit'])) {
					 
					    $gid=empty($this->POST['gid']) ? 0 : $this->POST['gid'];
				
						if($this->IsSQL('task_seller_usergroup',"WHERE gid='$gid'")){
							

							   $yes=$this->Update('task_seller_usergroup',$this->POST,array(),"WHERE gid='$gid'");
						       
							   if($yes){
									   $refresh= '<p>配置权限成功！</p>';

							   }else{
								
									   $refresh= '<p>配置权限失败！</p>';

							   }
							   
							   echo $this->Refresh($refresh,$this->MakeGetParameterURL().'&action=26');
							   
							   exit();
					
					    }else{
						
								$gid=$this->Insert('task_seller_usergroup',$this->POST);

								$refresh='<p>添加权限成功！</p>';
									 
								echo $this->Refresh($refresh,$this->MakeGetParameterURL().'&action=26');
								
								exit();
								
					    }
					 
					 
					 
				 }else{
			   
                         include $this->Template('addallow_manage');
				 
				 }
		

	}
	
	
	public function EditAllowAction(){
		
			     $usergrouparray=$this->GetMysqlArray('*'," ".$this->GetTable('usergroup')." ");          
				 
			     if(!empty($this->POST['Submit'])) {
					 
					    $gid=empty($this->POST['gid']) ? 0 : $this->POST['gid'];
			
						if($this->IsSQL('task_seller_usergroup',"WHERE gid='$gid'")){
					
	
							   $yes=$this->Update('task_seller_usergroup',$this->POST,array(),"WHERE gid='$gid'");
						       
							   if($yes){
									  $refresh= '<p>配置权限成功！</p>';
							   }else{
								
									  $refresh= '<p>配置权限失败！</p>'; 
							   }
							   
							   echo $this->Refresh($refresh,$this->MakeGetParameterURL().'&action=26');
							   
							   exit();
					
					    }else{
						
								$gid=$this->Insert('task_seller_usergroup',$this->POST);

								$refresh= '<p>添加权限成功！</p>';
									 
								echo $this->Refresh($refresh,$this->MakeGetParameterURL().'&action=26');
								
								exit();
								
					    }
					 
					 
					 
				 }else{
					 
					    $gid=$this->GET['id'];
					    $nowvalue=$this->GetMysqlOne('*'," ".$this->GetTable('task_seller_usergroup')." WHERE gid='$gid'");
					 
				 }
			   
                 include $this->Template('addallow_manage');
		
		
	}
	
	//权限配置
	public function AllowAdminAction(){
		
				
				 if(!empty($this->POST['Submit'])) {
					 
					     $ids=$this->GetCheckBox($this->POST['checkbox']);
					  
					     if($this->Delete('task_seller_usergroup'," WHERE gid IN($ids)")){
				  
							  $refresh=$this->LanguageArray('phpapp','Delete_successfully');
							 
						 }else{
							  $refresh=$this->LanguageArray('phpapp','Delete_failed');
									   
						 }
						 
						 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
						 
						 exit();
				  
					 
				 }else{
					 
						 include_once(Core.'/class/pages_class_phpapp.php');
						 include_once(APPS.'/member/class/member_phpapp.php');
				  
						 $orderarr=array(
								  array('order'=>'a.gid','name'=>'ID'),
								  array('order'=>'a.groupname','name'=>'用户组名称'),
								  array('order'=>'a.usertype','name'=>'会员类型'),
								  array('order'=>'b.gid','name'=>'权限配置情况'),
								  );
				  
						 $order='ORDER BY a.gid DESC';
				  
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
				 
						 
						 $MF= new MemberFunction();
				  
				  
						 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.gid AS groupid FROM  ".$this->GetTable('usergroup')." AS a  LEFT JOIN ".$this->GetTable('task_seller_usergroup')." AS b ON a.gid=b.gid $order");
		
						 $list=$ajaxpage->ShowResult();
		
				 }

		       
			    include $this->Template('allow_manage');
	}

	
	
}

?>