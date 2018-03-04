<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(APPS.'/taskmode/public_phpapp.php');

class SellerServiceMainControls extends TaskPublicClass{
	
    public $POST,$GET,$errors;
	
	public $tid,$sid,$seller,$spaceuid;
	
	function __construct(){	
	
	       
		   parent::__construct();
		   
		   
		   $this->sid=empty($_GET['sid']) ? 0 : intval($_GET['sid']);
		   
		   $this->tid=empty($_GET['tid']) ? 0 : intval($_GET['tid']);
		   
		   $this->seller=empty($_GET['uid']) ? 0 : intval($_GET['uid']);

		   $postkey=array('Submit'=>'','SecurityForm'=>'','edittid'=>'');
			
			
		   $this->POST=$this->POSTArray();
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','total','id','op','mobile','sort','more','tab','did','select'));
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }

	}
	
	
	function DefaultAction(){
          if($this->sid>0){
			    $this->ShowAction();
		  }else{
		  		$this->SellerServiceListAction();
		  }
	}
	
	function ShowAction(){
	
			  $service=$this->GetMysqlOne('a.*,b.filepath',"  ".$this->GetTable('task_seller_service')." AS a LEFT JOIN ".$this->GetTable('file')." AS b  ON b.fid=a.logo  WHERE a.status=0  AND a.sid='$this->sid' ");   
			  
			  
			  if($this->uid){
  
					 $allow=$this->CheckAllow('task_seller_usergroup',array(
															  'appallow'=>''
															  )
													   );
					 $errors='';
					 if($allow!='ok' && $allow){ 
					 
							foreach($allow as $value){
								  $errors.='<p>'.$value.'</p>';
							}
							
							$this->Refresh($errors,SURL);
					 }
					 
			  }else{
					
					if(intval(PHPAPP::$config['task_seller_tourist'])){
					
						  $this->Refresh($this->LanguageArray('taskone','Visitors_can_not_view'),SURL.'/index.php?app='.$this->app);
					}
				 
			  }
			  
			  
			  $allow='ok';
			  
			  if($allow=='ok' || $this->IsAdmin()){

					if($service['sid']>0){
				          
						  $this->spaceuid=$service['uid'];
				   
						  include $this->Template('service_show_space');
						 
					}else{
						  $this->Refresh('���񲻴���!',SURL.'/index.php?app='.$this->app.'&sid='.$this->sid);
					}
						  
			  }else{ 
	  
					$errors='';
								   
					foreach($allow as $value){
						 $errors.=$value.'<br />';
					}
					
					$this->Refresh($errors,'index.php?app='.$this->app);
			  }
	}

	
	function AddDataAction(){
		
		   $tid=intval($this->GET['tid']);
		   $this->seller=$this->spaceuid=intval($this->GET['uid']);

		   $task=$this->GetMysqlOne('*'," ".$this->GetTable('task')." WHERE tid='$tid' AND uid='$this->uid'");
		   
		   $allow=$this->CheckAllow('task_seller_usergroup',array(
															'buyservice'=>'',
															'realnametask'=>''
															)
		   											 );
		   
		  if($allow!='ok'){
				  $errors='';
								 
				  foreach($allow as $value){
					   $errors.=$value.'<br />';
				  }
				  
				  $this->Refresh($errors,'index.php?app='.$this->app);
				  exit();
		  }
	
		  if($this->tid>0){
				
				$task=$this->GetMysqlOne('*'," ".$this->GetTable('task')." WHERE tid='$this->tid' AND uid='$this->uid' ");
				$this->seller=$task['seller'];
				if($task['tid']>0){
					  
					  if($task['process']>3 || $task['status']==1){
						    
							 $this->Refresh('�Բ���,��ǰ״̬�����޸�!',SURL.'/member.php?app='.$this->app.'&action=6&op=1&tid='.$this->tid);
						    
					  }
					  					   
				}
		  
		  }

		  if($this->sid>0){
		        $service=$this->GetMysqlOne('*'," ".$this->GetTable('task_seller_service')." WHERE sid='$this->sid'");
				
				if($service['realnametask']==1){
					 
					     if(!$this->IsRealName()){
							  
							  $errors='<p>�Բ���,����Ҫ��ʵ������!<p>';
							  
							  if($this->IsWap()){
								  
								   $this->Refresh($errors,'index.php?app='.$this->app.'&action=1');
							  }else{
								   $this->Refresh($errors,'index.php?app='.$this->app.'&action=1');
							  }
							  exit();
						 }
					  
					   
				 }
				 
		  }else{
			    $service='';
		  }


		  if($this->seller>0){
			   
			   if($this->seller == $this->uid){
				   
				       $this->Refresh('�Բ���,���ܹ����Լ�!','index.php?app='.$this->app.'&action=1');
					   
			   }else{
			  
	
					 $seller=$this->GetMysqlOne('a.username,b.*',"  ".$this->GetTable('member')." AS a LEFT JOIN ".$this->GetTable('member_info')." AS b ON a.uid=b.uid WHERE a.uid='$this->seller' ");          
				 

					 if($seller['uid']>0){
						  
							  $memberinfo=$this->GetMysqlOne('mobile'," ".$this->GetTable('member_info')." WHERE uid='$this->uid' ");
                     
							  if($this->GET['op']==3){
								  
								    
									$this->Refresh('�����ɹ�,�ȴ�����ȷ��','member.php?app='.$this->app.'&action=6&op=1&tid='.$this->tid);
								    
								  
							  }elseif($this->GET['op']==2){
					
							 
										   include $this->AppsView('verify');
			  
										   exit();
					  
						   
					          }elseif($this->GET['op']==1 && $this->POST['Submit']){
								            
						
									  //if($this->CheckSecurityForm($this->POST['SecurityForm'])){
											  //Ȩ��
																											
					  	
											   $allow=$this->CheckAllow('task_seller_usergroup',array(
																					  'addtask'=>'',
																					  'realnametask'=>'',
																					  'addnumbertask'=>'',
																					  'maxmoneytask'=>floatval($this->POST['money']), //������������йܽ��
																					  'smallmoneytask'=>floatval($this->POST['money']) //������������йܽ��
																					  )
																		   );
			
											   
											   if($allow=='ok'){
								
													   $fieldnum=count($this->GetTableFieldArray('task'));
								  
								                       if($this->CheckTask()==(4+$fieldnum)){
	
														    $description=$this->str($this->POST['content'],200,0,1,1,0,1);
															if(strlen($this->POST['content'])>200){
																 $description.='...';
															}

																	
														   if($this->sid>0 || $this->seller>0 && !$this->tid){
	  
															    $this->tid=$this->Insert('task',$this->POST,array('appid'=>82,'sid'=>$this->sid,'process'=>1,'uid'=>$this->uid,'seller'=>$this->seller,'dateline'=>$this->NowTime(),'description'=>$description));
																
																
																
																$this->Update('task',array('url'=>'/member.php?app=82&action=6&tid='.$this->tid.'&op=1'),array()," WHERE tid='$this->tid' AND uid='$this->uid'");                                              
																
																
																$send_subject=$this->username.'�������ķ�������';
																$send_content='�����ѹ������ķ���!�ȴ�����ȷ�� <a href="'.SURL.'/member.php?app='.$this->app.'&action=5&tid='.$this->tid.'&op=1" target="_blank"><span class="show_details>[�鿴��ϸ]</span></a>';
																
																$this->Port(array(
																				
																	   //SMS
																	  'receive_uid'=>$this->seller, //�ռ���
																
																	
																	  //SMS
																	  'sms_subject'=>$send_subject,
																	  'sms_content'=>$send_content,
																					
																	  //EMail
																	  'email_title'=>$send_subject,
																	  'email_content'=>$send_content,
											
																	  //Mobile
																	  'mobile_content'=>$send_subject
																
																			  
										                       ),2);
																
																
																
																
														   }elseif(!$this->sid && $this->tid>0){
															  
																  $this->Update('task',$this->POST,array('status'=>0,'description'=>$description)," WHERE tid='$this->tid' AND uid='$this->uid'");
														   
														   }
														   
														   
														   if($allow=='ok'){
									   
																	   //�ϴ��ļ�
																	   $files=$this->UploadFile();
																	   
																	   if($files){
																			 foreach($files as $fid){
																				  $this->Insert('apps_file',array('appid'=>$this->app,'fid'=>$fid,'uid'=>$this->uid,'id'=>$this->tid,'type'=>2),array());
																			 }
																			 
																			 $this->ReplaceFileContent($files,'task',$this->POST['content']," WHERE tid='$this->tid' ");
																	   }
																	   
															}else{
																
																  $this->ShowAllowError($allow,"index.php?app=$this->app&action=2&tid=$this->tid");
																
															}
														   
														   
														    //2��
															header("Location: index.php?app=$this->app&action=2&tid=$this->tid&op=2");

					   
													   }else{
															 
															 $errors='';
															 
															 if($this->errors){
																	foreach($this->errors as $value){
																		 $errors.='<p>'.$value.'</p>';
																	}
															 }
															 
															 $this->Refresh($errors,'index.php?app='.$this->app.'&action=1');
													   }
											   }else{
												   
													 $errors='';
													 
													 foreach($allow as $value){
														   $errors.=$value.'<br />';
													 }
													 
													 $this->Refresh($errors,'index.php?app='.$this->app.'&action=1');
											   }
									   
									    /*
										}else{
											
											  $this->Refresh('�ύ���ѹ���!','index.php?app='.$this->app.'&action=1');
										}
				                        */
													  
								  
								  
							  }else{
	  
									include $this->AppsView('add');
							  }
							 
					 
					 }else{
						 
							 $this->Refresh('��ѡ���������!!','index.php?app='.$this->app.'&action=1');
					 }
					 
			   
			   }
			  
		  }else{
			    $this->Refresh('��ѡ���������!','index.php?app='.$this->app.'&action=1');
		  }
		   
		   
		   
	}
	
	
	
	function CheckTask(){
		
		        $checknum=0;

		        //����
				foreach($this->POST as $key=>$value){
					   
					   switch($key){
					          case 'subject':
							  
							       $strings=new CharFilter($this->POST['subject']);
								   
								   if(empty($this->POST['subject'])){
							             $this->errors[]='���������!';
								   /*
								   }elseif($strings->CheckSpace()){
							             $this->errors[]='�Բ���,���⺬�зǷ�����!';	 
										 */
								   }elseif($strings->CheckLength(5)){  //�������������С���� ��λ "λ"
										 $this->errors[]='�Բ���,���ⲻ����5����!';
								   }elseif($strings->CheckShort(200)){ //�������������󳤶� ��λ "λ"
										 $this->errors[]='�Բ���,����̫����!';
								   }else{
									     $checknum+=1;
								   }
		
					          break;
							  case 'money':
							       if(empty($this->POST['money'])){
							             $this->errors[]='�������ͽ�!';
									
								   }elseif($this->POST['money']<1){
										  $this->errors[]='�ͽ���Ϊ0Ԫ!';
							       }else{
									     $this->POST['money']=floatval($this->POST['money']);
									     $checknum+=1;
								   }
					          break;
							  case 'time':
							  
							       if(empty($this->POST['time'])){
							             $this->errors[]='����������ʱ��!';
								   }elseif($this->POST['time']<1){
									     $this->errors[]='����ʱ�䲻��Ϊ0!';
								   }else{
									     $checknum+=1;
								   }
					          break;
							  
							  case 'content':
									$strings=new CharFilter($this->POST['content']);
									if(empty($this->POST['content'])){
										 $this->errors[]='����������!';
									}elseif($strings->CheckLength(5)){  //��������������С���� ��λ "λ"
										 $this->errors[]='�Բ���,���ݲ�����5����!';
									}else{
									     $checknum+=1;
								    }
							  break;
							  
							  
					   }
				}	
				
				
				//�Զ����ֶ�---------------------------------------------------

			   $fieldresult=$this->GetTableFieldResult('task',$this->POST);
			   
               if($fieldresult['checknum']){
				   
					 $checknum+=$fieldresult['checknum'];
					 
					 if($fieldresult['errors']){
						  foreach($fieldresult['errors'] as $value){
								$this->errors[]=$value;
						  }
					 }
					 
					 $this->POST=$fieldresult['post'];
			   
			   }
			   
			   //�Զ����ֶ� end---------------------------------------------------
		
		       return $checknum;
	}
	
	
	
	
	
	function SellerServiceListAction($catid=0,$skill=0,$app=0){
		   
		   if($app==82){
		   		$this->app=$app;
		   }
		   
		   include_once(Core.'/class/skill_class_phpapp.php');
		   
		   $skilldata=new SkillClass();
		
           $selectarray=array(
	
					  array('name'=>'Ĭ������','data'=>array('Ĭ������','���۴Ӹߵ���','���۴ӵ͵���','���ʱ����ٵ���','���ʱ��Ӷൽ��','���������ٵ���','�������Ӷൽ��'),'id'=>'sort'),	
					  array('name'=>'ɸѡģʽ','data'=>array('0'=>'0','1'=>'1'),'id'=>'select'),
					  array('name'=>'��ʾ����','data'=>array('0'=>'0','1'=>'1'),'id'=>'more'),
					  array('name'=>'�б��л�','data'=>array('0'=>'0','1'=>'1'),'id'=>'tab')
			     );
   
   
		   require_once(Core.'/class/list_class_phpapp.php');
		   
		   $selectclass=new SelectData($selectarray,$catid,$skill);

		   $selectitem=$selectclass->GetSelectOne('task_seller_select');

           $selectctarray=$selectclass->GetSelectCategory();

		   $selectsql=$selectclass->GetSelectOneSQL($selectitem[2],$selectctarray[5],'a.catid','d.residecity','c.skills');
		   
		    include_once(Core.'/class/pages_class_phpapp.php');
				

			 //����
			 switch ($this->GET['sort']) {
					 case '1':
					 $order=' a.price DESC';
					 break;
					 case '2':
					 $order=' a.price ASC';
					 break;
					 case '3':
					 $order=' a.time ASC';
					 break;
					 case '4':
					 $order=' a.time DESC';
					 break;
					 case '5':
					 $order=' a.sellnum ASC';
					 break;
					 case '6':
					 $order=' a.sellnum DESC';
					 break;
					 default:
					 $order=' a.topbid DESC , a.sellnum DESC ';
			}
						

				
				   $pageurl=$selectclass->GetSelectAllURL();
				   
			       $page=new Pages(16,$this->GET['page'],$pageurl,"SELECT a.*,c.username,c.dateline AS regtime,c.logintime,d.certificate,d.residecity,f.credit,g.speed,g.attitude,g.quality,h.thumb FROM (((((".$this->GetTable('task_seller_service')." AS a LEFT JOIN ".$this->GetTable('member')." AS c ON a.uid=c.uid) LEFT JOIN ".$this->GetTable('member_info')." AS d ON c.uid=d.uid)LEFT JOIN ".$this->GetTable('member_account')." AS e ON c.uid=e.uid) LEFT JOIN ".$this->GetTable('credit_score')." AS g ON c.uid=g.uid) LEFT JOIN ( SELECT credit,uid FROM ".$this->GetTable('credit')." WHERE type=1 ) AS f ON c.uid=f.uid ) LEFT JOIN ".$this->GetTable('file')." AS h  ON h.fid=a.logo WHERE a.status=0 $selectsql GROUP BY a.sid  ORDER BY $order ");
				   
			 
			       $list=$page->ShowResult();

				   //SEO
				   PHPAPP::$SEO['title']=empty($selectctarray[2])? '' :$selectctarray[2];
				   PHPAPP::$SEO['keywords']=empty($selectctarray[3])? '' :$selectctarray[3];
				   PHPAPP::$SEO['description']=empty($selectctarray[4])? '' :$selectctarray[4];
				   
				   include $this->AppsView('sellerservice:list');
		
	}
	
	
	function GetServiceURL($sid,$uid=0,$app=0){
		  if(!$uid){
			   $uid=$this->uid;
		  }
		  
		  if(!$app){
			  $app=$this->app;
		  }
		  
		  include_once(Core.'/class/makeurl_class_phpapp.php');
		  
		  $make=new MakeTaskAddressUrl();
		  
		  return $make->GetServiceAddress($sid,$uid,$app,$string);
		  
	}
}




?>