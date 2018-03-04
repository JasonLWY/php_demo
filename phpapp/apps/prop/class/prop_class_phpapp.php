<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class SiteProp extends PHPAPP{
	
	public $data;
	
	function __construct($data=''){	

         parent::__construct();
		 
	     $this->data=$data;
		
	}


	function UseProp($tid=0,$url,$did=0,$serviceid=0){

			if(!empty($this->data)){
				   
				    $servicearr=explode(',',$this->data);
	
					foreach($servicearr as $sid){
						    
							$sid=intval($sid);
							
							$amount=1;  //使用数量
							
						    if($this->IsSQL('prop_order'," WHERE sid='$sid' AND process=1 AND uid='$this->uid' AND amount>0 ")){
								 
									$siteservice=$this->GetMysqlOne('amount,oid'," ".$this->GetTable('prop_order')." WHERE sid='$sid' AND process=1 AND uid='$this->uid' AND amount>0 ");
									
									if(intval($siteservice['amount']) >0 ){
										  
										  $nowamount=intval($siteservice['amount']) - $amount;
										  
										  $propinfo=$this->GetMysqlOne('type,day'," ".$this->GetTable('prop')." WHERE sid='$sid' ");
										  
										  $this->Update('prop_order',array('amount'=>$nowamount),array(),"WHERE sid='$sid' AND process=1 AND uid='$this->uid'");
										     
										  if($propinfo['type']==1){
											    //稿件
										        $consume=$this->GetMysqlOne('*'," ".$this->GetTable('prop_consume')." WHERE oid='$siteservice[oid]' AND app='$this->app' AND did='$did' AND uid='$this->uid' ");
												
										  }elseif($propinfo['type']==2){
											    //服务
											    $consume=$this->GetMysqlOne('*'," ".$this->GetTable('prop_consume')." WHERE oid='$siteservice[oid]' AND app='$this->app' AND sid='$serviceid' AND uid='$this->uid' ");
										  }else{
											    //任务
										  		$consume=$this->GetMysqlOne('*'," ".$this->GetTable('prop_consume')." WHERE oid='$siteservice[oid]' AND app='$this->app' AND tid='$tid' AND uid='$this->uid' ");
										  }
										  	
										  
										  //过期天数
										  $day=intval($propinfo['day']);
										  $runid=intval($consume['runid']);
										   
										  if($day>0){
	
												 $propendtime=24*60*60*$day;
												 
												 include_once(Core.'/class/auto_class_phpapp.php');
								  
												 $auto=new AUTO();
												 
												 if($consume['cid']>0){
													  $runoid=intval($consume['cid']);
												 }
										 

												 if($this->IsSQL('autorun'," WHERE aid='$runid' ") ){

													   //更新过期
													   $day=$consume['day']+$day;
													   
													   $endtime=$consume['endtime']+$propendtime;
													   
													   $this->Update('autorun',array('runtime'=>$endtime),array(),"WHERE  aid='$runid'");
													   
													   $this->Update('prop_consume',array('day'=>$day,'endtime'=>$endtime),array(),"WHERE cid='$consume[cid]'");
													 
												 }else{
													   //$serviceid 服务sid
												       $runid=$auto->SetAutoRun(array('app'=>11,'runtime'=>$this->NowTime()+$propendtime,'function'=>'PropEnd','propid'=>$sid,'sid'=>$serviceid,'uid'=>$this->uid,'tid'=>$tid,'did'=>$did,'uid'=>$this->uid));        
													   
													   $runoid=$this->Insert('prop_consume',array('uid'=>$this->uid,'tid'=>$tid,'did'=>$did,'sid'=>$serviceid,'oid'=>$siteservice[oid],'app'=>$this->app,'url'=>$url,'day'=>$day,'endtime'=>$this->NowTime()+$propendtime,'runid'=>$runid),array());
												 }
												  
 
													
										  }else{
  
												   //使用记录
									             $runoid=$this->Insert('prop_consume',array('uid'=>$this->uid,'tid'=>$tid,'did'=>$did,'sid'=>$serviceid,'oid'=>$siteservice[oid],'app'=>$this->app,'url'=>$url),array());
									 
										  }
												
	 
										  
										  //处理功能
										  $this->RunSiteProp($runoid,$did,$serviceid);
										  
									}
									

						
							 }
				
					
					}
					

			}
		
		
	}
	
	
	
	
	
	function BuyProp($service){
		    
			if(!empty($service)){
				

					  $sid=intval($service['sid']);
					  
					  $amount=intval($service['amount']);
					  
					  $siteservice=$this->GetMysqlOne('*'," ".$this->GetTable('prop')." WHERE sid='$sid'");
					  
					  if($amount>0){
							$total=$amount*$siteservice['price'];
					  }else{
							$total=$siteservice['price'];
					  }
					  
					  //限制
					  $myproparr=$this->GetMysqlOne('amount'," ".$this->GetTable('prop_order')." WHERE uid='$this->uid' AND process=1 AND sid='$sid' ");
					  
					  $mypropnum=$amount+$myproparr['amount'];
					  
					  if($this->IsSQL('prop'," WHERE '$mypropnum'>buynum AND sid=$sid ")){
						  
						    echo '<p>对不起！该道具已满仓或购买量超过仓库数 <strong>'.$siteservice['buynum'].'</strong> 个.</p><p>请使用后再购买！</p>';
							echo $this->CloseNowWindows('#ShopService');
					        exit();
					  }

					  //支付
					  
					  $user=$this->GetMysqlOne('*'," ".$this->GetTable('member_account')." WHERE uid='$this->uid'");
							 
							 
					  if($user['money']>= $total){
								
							
							include_once(APPS.'/apppay/class/consume_class_phpapp.php');

							$pay=new UserConsume();
							
							$newcid=$pay->MakeConsume(array(
													'subject'=>'<p>道具</p>'.$siteservice['subject'].'', 
													'appid'=>11, 
													'paytype'=>1, 
													'process'=>1, 
													'number'=>$amount,
													'amount'=>$total, 
													'payout'=>$this->uid, 
													'payin'=>0  
													
											  ));
							
							
							
							$pay->SetSuccessConsume($newcid); 
								
							
							$this->Port(array(
																  
											//Login
											'login_uid'=>$this->uid
												 
							));
															 
																  
							$this->Port(array(			  
																  
																  
											//SMS
											'sms_msggoid'=>$this->uid, //收件人
											'sms_msgtoid'=>0,
											'sms_mailbox'=>'1',
											'sms_subject'=>'购买'.$siteservice['subject'].'道具成功!',
											'sms_content'=>'您购买 <strong>'.$siteservice['subject'].'</strong> 道具成功,您支出'.$total.'元,<a href="'.SURL.'/member.php?app=5&action=1&page=1&sort=2" target="_blank"><span class="show_details">查看详细</span></a>'
											
											//Feed							  
																  
							 ));
								
							
							$oldservice=$this->GetMysqlOne('*'," ".$this->GetTable('prop_order')." WHERE sid='$sid' AND uid='$this->uid'");
							
							
							if($oldservice['oid']>0){
								
								  $oid=$oldservice['oid'];
				
								  $nowamount=$oldservice['amount']+$amount;
								  
		                         
								  $this->Update('prop_order',array('amount'=>$nowamount,'process'=>1),array(),"WHERE oid='$oid'");
							 
							}else{
								 
								  $this->Insert('prop_order',array('sid'=>$sid,'amount'=>$amount,'uid'=>$this->uid,'process'=>1),array());  
								  
							}
							
							
							//提成
							@require_once(APPS.'/union/class/result_class_phpapp.php');
				             
						    $siteservice['amount']=$amount;
							
							$siteservice['uid']=$this->uid;
							
							$siteservice['app']=$this->app;
							 
							 
							new UnionResult($siteservice);
							
							if(!$service['jump']){

									echo '<p>购买成功!</p>';
									
									if($service['refresh']){
										//刷新
										echo '<script type="text/javascript">GetServiceList();</script>';
									}
									
									echo $this->CloseNowWindows('#ShopService');
							}

					 }else{
						 
						   echo '<p>请充值后操作! <a href="member.php?app=5&action=2">[点击充值]</a></p>';
						   echo $this->CloseNowWindows('#ShopService');
					 }
			       

	

			        
			}
		
		
	}
	
	
	
	//处理功能
	function RunSiteProp($cid=0,$did=0,$serviceid=0){
		   
		    $siteservice=$this->GetMysqlOne('a.appid,a.subject,a.price,b.*,c.*'," (".$this->GetTable('prop')." AS a LEFT JOIN ".$this->GetTable('prop_order')." AS b ON a.sid=b.sid ) LEFT JOIN ".$this->GetTable('prop_consume')." AS c ON c.oid=b.oid WHERE c.cid='$cid'");
		    
			$siteservice['did']=$did;
			$siteservice['serviceid']=$serviceid;
			
			$apps=$this->GetMysqlOne('*'," ".$this->GetTable('apps')." WHERE id_phpapp='$siteservice[appid]'");
			
			if($apps){

					$appfile=SYS.'/apps/'.$apps['dir_phpapp'].'/class/prop_class_phpapp.php';

                    if(file_exists($appfile)){
						    
							require_once($appfile);
							
							$prop=$apps['class_phpapp'].'Prop';

							$runservice=new $prop;
						
							$runservice->PropAction($siteservice);
							
					}
		    }

	}

		
	
}

?>