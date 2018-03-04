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

class SiteNoticeManageControls extends PHPAPP{
	
    private $actionmenu,$POST,$GET;
	
	public  $page,$nid;
	
	function __construct($actionmenu=''){	
	
	       parent::__construct();
           
		   $this->nid=empty($_GET['id']) ? 0 : intval($_GET['id']);
		   
	       $this->actionmenu=$actionmenu;
		   
		   $postkey=array('Submit'=>'','checkbox'=>'','SubmitDeleteOld'=>'');
		   
		   $this->POST=$this->POSTArray();
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','action'));
		         
	}
	
	function DefaultAction(){
		
		  return $this->NoticeListAction();
	}
	
	
	public function NoticeListAction(){
 
 		  //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){

					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(
															
														'subject'=>array('subject','search'), 
														'nid'=>array('nid','int'),
														'dateline1'=>array('dateline','time'),
														'dateline2'=>array('dateline','time')
															  
												      ) 
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }
			   
			   
	      //select end----------------------------------------------------
		  
		  
		 if($this->POST['SubmitDeleteOld']){
				
				//保留最近一个月
				$nowtime=$this->NowTime()-(31*24*60*60);
				
				$this->Delete('member_notice'," WHERE dateline<'$nowtime' ");
			
		        $refresh= $this->LanguageArray('phpapp','Delete_successfully');
				   
				echo $this->Refresh($refresh,$this->MakeGetParameterURL());
		  
	     }elseif($this->POST['Submit']){
			  
                   $ids=$this->GetCheckBox($this->POST['checkbox']);
				
				   if($ids){
				   		$this->Delete('member_notice'," WHERE nid IN($ids) ");
				   }
				   
				   $refresh= $this->LanguageArray('phpapp','Delete_successfully');
				   
				   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
				  
		  }else{
			  
			     include_once(Core.'/class/pages_class_phpapp.php');
				 
			     $orderarr=array(
						  array('order'=>'nid','name'=>'ID'),
						  array('order'=>'uid','name'=>'通知UID'),
						  array('order'=>'subject','name'=>'标题'),
						  array('order'=>'dateline','name'=>'通知时间')
						  );
          
		         $order='ORDER BY nid DESC';
		  
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
		 
	
		         $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT * FROM  ".$this->GetTable('member_notice')." $wheresql $order");

                 $list=$ajaxpage->ShowResult();

	  
				 include $this->Template('noticelist_manage');
		  }
		   
	}
	
	
	
	public function ShowAction(){
	
		  $noticearr=$this->GetMysqlOne('*'," ".$this->GetTable('member_notice')." WHERE nid='$this->nid'");
		  
		  include $this->Template('show_manage');
	}
	
}


?>