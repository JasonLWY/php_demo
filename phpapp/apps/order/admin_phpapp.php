<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

require_once(APPS.'/order/member_phpapp.php');
require_once(Core.'/class/admin_class_phpapp.php');

//Order
class OrderManageControls extends OrderMemberControls{
	
	
	function __construct($actionmenu=''){	 
         
		 global $appclass;
		 
		 parent::__construct();
		 
		 $this->actionmenu=$actionmenu;
		 
		 $this->app=$appclass['id_phpapp'];
           
	     $this->POST=$this->POSTArray();
		 
		 $postkey=array('Submit'=>'','checkbox'=>'');
	   
	     $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','total','id','op','item','sort','more','tab','did','select'));
	   
	     foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
	     }
		   
		 if($this->uid<1){
			  $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
		 
	}
	
	
	public function DefaultAction(){
		
		  return $this->SellerOrderListAction();
		
	}
	
	public function SellerOrderInfoAction(){

		   $this->SellerOrder($this->GET['id'],1);   
		
	}
	
	public function BuyerOrderInfoAction(){
		   
		   $this->BuyerOrder($this->GET['id'],1);

	}
	
	public function BuyerOrderListAction(){
		      
			  //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													 array(
															
														'oid'=>array('a.oid','int'),  
														'cid'=>array('a.cid','search'),
														'tid'=>array('a.tid','int'),
														'did'=>array('a.did','int'),
														'process'=>array('c.process','int'),
														'amount1'=>array('c.amount','part'),
														'amount2'=>array('c.amount','part'),
														'fee1'=>array('c.fee','part'),
														'fee2'=>array('c.fee','part'),
														'dateline1'=>array('c.dateline','time'),
														'dateline2'=>array('c.dateline','time')
															  
												      ) 
													  
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }
			   
			   //select end----------------------------------------------------
			  
			  if(!empty($this->POST['Pay'])){
		                
		                $idarray=explode(',',$this->GetCheckBox($this->POST['checkbox'],1));
						
						if($idarray){
						
							   foreach($idarray as $value){
									 
									   $value=intval($value);
		  
									   if($this->IsSQL('consume',"WHERE cid='$value' AND process=3")){
								  
											 //支付
											 $this->PayTaskOrder($value);
	  
											 $refresh.=$value.'号订单操作成功!<br />';
									   }else{
											 $refresh.= $value.'号订单操作过了!<br />';
									   }
									   
							   }
						
						}
						
						
                        echo $this->Refresh($refresh,$this->MakeGetParameterURL());
		  
		  
			  }elseif(!empty($this->POST['Delete'])){
	               
				   if($this->uid==1){
					   
						 $ids=$this->GetCheckBox($this->POST['checkbox'],1);
						
						 if($this->Delete('task_order'," WHERE cid IN($ids)")){
						
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
			  
			  
					 $order='ORDER BY a.oid DESC';
			  
					 $this->GET['iforder']=empty($this->GET['iforder']) ? 2 : $this->GET['iforder'];
	
					 if($this->GET['iforder']==1){
						  $sqlorder=' ASC';
                          $iforder=2;
					 }else{
						  $sqlorder=' DESC';
						  $iforder=1;
					 }
			 
	
					 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.uid,b.tid,b.url,b.appid,b.subject,c.process,c.cid FROM (".$this->GetTable('task_order')." AS a LEFT JOIN  ".$this->GetTable('consume')." AS c ON c.cid=a.cid ) LEFT JOIN  ".$this->GetTable('task')." AS b ON a.tid=b.tid $wheresql $order");
	
					 $list=$ajaxpage->ShowResult();
                     
					 $getprocess=new TaskProcess();
		  
		             include $this->Template('buyer_order_manage');
			  }
		
		    
		
	}
	
	public function SellerOrderListAction(){
               
			   //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){

					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(
															
														'oid'=>array('a.oid','int'),  
														'cid'=>array('a.cid','search'),
														'tid'=>array('a.tid','int'),
														'did'=>array('a.did','int'),
														'process'=>array('c.process','int'),
														'amount1'=>array('c.amount','part'),
														'amount2'=>array('c.amount','part'),
														'fee1'=>array('c.fee','part'),
														'fee2'=>array('c.fee','part'),
														'dateline1'=>array('c.dateline','time'),
														'dateline2'=>array('c.dateline','time')
															  
												      )
													  
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }

			   //select end----------------------------------------------------
			   
			  
			  if(!empty($this->POST['Delivery'])){
		  
		                $idarray=explode(',',$this->GetCheckBox($this->POST['checkbox'],1));
						
						$refresh=$this->SetDelivery($idarray,'',1);
						
						$refreshshow='';
						
						foreach($refresh as $value){
							  $refreshshow.=$value;
						}
						
                        echo $this->Refresh($refreshshow,$this->MakeGetParameterURL());
		  
		  
			  }elseif(!empty($this->POST['Delete'])){
	               
				   if($this->uid==1){
					   
					     $ids=$this->GetCheckBox($this->POST['checkbox'],1);

						 if($this->Delete('task_order'," WHERE cid IN($ids)")){
						
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

					 $order='ORDER BY a.oid DESC';
			  
					 $this->GET['iforder']=empty($this->GET['iforder']) ? 2 : $this->GET['iforder'];
	
					 if($this->GET['iforder']==1){
						  $sqlorder=' ASC';
                          $iforder=2;
					 }else{
						  $sqlorder=' DESC';
						  $iforder=1;
					 }
			  
	
					 $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,c.process,c.cid FROM (".$this->GetTable('task_order')." AS a  JOIN  ".$this->GetTable('consume')." AS c ON c.cid=a.cid )LEFT JOIN  ".$this->GetTable('task_draft')." AS b ON a.did=b.did $wheresql $order");
	
					 $list=$ajaxpage->ShowResult();
                     
					 $getprocess=new TaskProcess();

		             include $this->Template('seller_order_manage');
					 
			  }

		
	}
	
}

?>