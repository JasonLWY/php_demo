<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class PropMemberControls extends PHPAPP{
	
    private $POST,$GET;
	
	public $sid;
	
	function __construct(){	 
	 
         parent::__construct();
		 
		 
		 $this->sid=empty($_POST['sid']) ? 0 : intval($_POST['sid']);
		 
		 $postkey=array('Submit'=>'');
		 
		 $this->POST=$this->POSTArray();
		   
		 $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','sort'));

		 
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
		
		  return $this->ItemAction();
		
	}
	
	
	public function ItemAction(){
		        
				 $user=$this->GetLoginInfo($this->uid,1);
				 
				 if($this->GET['op']){
					 
					   include_once(Core.'/class/pages_ajax_class_phpapp.php');

			
					   $ajaxpage=new AjaxPages(10,$this->GET['page'],$this->app,$this->GET['sqlorder'],$this->GET['iforder'],'AjaxItem',"SELECT * FROM  ".$this->GetTable('prop')." WHERE status='0' AND sell='0' AND usergroup='$user[usergroup]' ORDER BY displayorder ASC");
			  
					   $list=$ajaxpage->ShowResult();
					   
					   
					   
					   include $this->Template('ajax_item_member');
					 
				 }else{

					   include_once(Core.'/class/pages_class_phpapp.php');
					   
	  
					   $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=1',"SELECT * FROM ".$this->GetTable('prop')." WHERE status='0' AND sell='0' AND usergroup='$user[usergroup]' ORDER BY displayorder ASC");
						 
						 
					   $list=$page->ShowResult();
			
	  
					   include $this->Template('item_member');
				 
				 }

	}
	
	public function BuyPropAction(){
		     
			 if($this->sid){
		
				    $service=$this->GetMysqlOne('*'," ".$this->GetTable('prop')." WHERE sid='$this->sid'");
					
					if($service){
						
						
						       if($this->POST['Submit']){
								      
									   if(intval($this->POST['amount'])>0){
									  
											   include_once(APPS.'/prop/class/prop_class_phpapp.php');
											   
											   $buy=new SiteProp();
						
											   $buy->BuyProp(array('sid'=>$this->sid,'amount'=>$this->POST['amount'],'refresh'=>intval($this->POST['refresh'])));
									   
									   }else{
										   
										    echo '<p>数目格式有误请重请输入！</p>';
						                    echo $this->CloseNowWindows('#ShopService');
									   }
								      
								   
							   }else{
						
				                      include $this->Template('buyprop_member');
							   }
				   
					}else{
						  echo '<p>服务不存在</p>';
						  echo $this->CloseNowWindows('#ShopService');
			        }
			 
			 }else{
				   echo '<p>服务不存在</p>';
				   echo $this->CloseNowWindows('#ShopService');
			 }
			 
			 
		
	}
	
	
	
	public function MyPropAction(){
		
			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		         

				 $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=2',"SELECT a.type,a.content,a.buynum,a.subject,a.count,a.icon,b.* FROM ".$this->GetTable('prop')." AS a LEFT JOIN ".$this->GetTable('prop_order')." AS b ON a.sid=b.sid WHERE b.uid='$this->uid'  AND a.sell='0' AND b.process=1 ORDER BY b.oid DESC");
				   
				   
				 $list=$page->ShowResult();
	  
	  
				 include $this->Template('myprop_member');
		
	}
	
	

	public function UseRecordAction(){
		
                  include_once(Core.'/class/pages_class_phpapp.php');
		         

				 $page=new Pages(10,$this->GET['page'],'member.php?app='.$this->app.'&action=3',"SELECT a.subject,a.count,a.icon,b.*,c.* FROM (".$this->GetTable('prop')." AS a JOIN ".$this->GetTable('prop_order')." AS b ON a.sid=b.sid) JOIN ".$this->GetTable('prop_consume')." AS c ON c.oid=b.oid  WHERE  a.sell='0' AND b.uid='$this->uid' ORDER BY c.cid DESC");
				   
				   
				 $list=$page->ShowResult();
	  
	  
				 include $this->Template('userecord_member');
		
	}
		
		
}

?>