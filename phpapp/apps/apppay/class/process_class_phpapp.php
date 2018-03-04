<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class TaskProcess extends PHPAPP{
	
	
	function __construct(){	
	
	      parent::__construct();
	     
	}
	
	
	function GetSellerProcessName($tablename,$tablename2,$cid,$type=0,$app='',$paytype=0,$txt=0){
		
		  if($app){
		       $appid=$app;
		  }else{
			   $appid=$this->app;
		  }
		  
		  $order=$this->GetMysqlOne('process'," ".$this->GetTable('consume')." WHERE cid='$cid'");
		  
		  $name='';
		  
		  if(!$type){
					  
				  switch ($order['process']) {
						  case '1':

                          if($paytype==4){
							   $name='<span class="color_f60">等待汇款</span>';
						  }else{
						       $name='<span class="color_f60">等待雇主托管</span>';
						  }
						  

						  break;
						  case '2':
						  $name='<span class="color_f60">雇主已托管</span>';
						  break;
						  case '3':
						  $name='<span class="color_f60">等待雇主确认</span>';
						  break;
						  case '4':
						  $name='<span class="color_f60">雇主退款中</span>';
						  break;
						  case '5':
						  $name='<span class="color_c0b">交易成功</span>';
						  break;
						  case '6':
						  $name='<span class="color_f60">关闭订单</span>';
						  break;
				  }
		  }else{
			  
				  switch ($order['process']) {
						  case '1':
						  		$name='等待雇主托管';
						  break;
						  case '2':

						  		$name='雇主已托管,等待威客工作并文件交接.';
	
						  break;
						  case '3':

							   $name='威客已交接,等待雇主确认接收.';
						  
						  break;
						  case '4':
		
						  		$name='雇主退款中';
						  
						  break;
						  case '5':
						  
								if(!$this->IsSQL($tablename2,"WHERE cid='$cid' AND type=1")){
									  $menu='&nbsp; '.$this->GetSellerProcessMenu($tablename2,$oid);
								}else{
									  $menu='';
								}
											 
						  $name='订单交易成功';
						  
						  if(!$txt){
							   $name.=$menu;
						  }
						  
						  break;
						  case '6':
						  $name='关闭订单';
						  break;
				  }			  
			  	  
		  }
		  
		  
		  return  $name;
		   
	}
	
	
	function GetSellerProcessMenu($tablename,$cid){
		
		  $order=$this->GetMysqlOne('process'," ".$this->GetTable('consume')." WHERE cid='$cid'");
		  
		  switch ($order['process']) {
				  case '2':
				  $name='<p><a class="large red awesome" onclick="SellerSubmitDelivery('.$cid.')">确认交接</a></p>';
				  break;
				  case '4':
				      $name='<a href="'.SURL.'/member.php?app=43&action=2&cid='.$cid.'&op=1" title="查看退款" class="large blue awesome" target="_blank">查看退款</a>';
				  break;  
				  case '5':
				  if(!$this->IsSQL($tablename,"WHERE cid='$cid' AND type=1")){
				       $name='<p><a title="评价" onclick="SellerOpenCredit('.$cid.')" class="large red awesome">评价</a></p>';
				  }else{
					   $name='';
				  }
				  break;
				  default:
				  $name='';
		  }
		  
		  
		  return  $name;
		   
	}

	
	function GetBuyerProcessMenu($tablename,$cid){
		
		  $order=$this->GetMysqlOne('a.cid,a.process,a.dateline,b.tid'," ".$this->GetTable('consume')." AS a LEFT JOIN  ".$this->GetTable('task_order')." AS b ON a.cid=b.cid WHERE a.cid='$cid'");
		  
		  switch ($order['process']) {
			      case '1':
				  $name='<p><a class="large red awesome" title="立即付款" onclick="PaymentOrders('.$cid.','.$order['tid'].')">立即付款</a></p><p style="margin-top:5px"><a class="large blue awesome" title="关闭订单" onclick="CloseOrders('.$cid.','.$order['tid'].')">关闭订单</a></p>';
				  break;
				  case '3':
				  $name='<p><a href="'.SURL.'/member.php?app=43&action=1&cid='.$cid.'" title="申请退款" class="large blue awesome" target="_blank">申请退款</a></p><p style="margin-top:5px"><a title="确认收货" onclick="OpenDelivery('.$cid.')" class="large red awesome">确认收货</a></p>';
				  break;    
				  case '4':
				      $name='<a href="'.SURL.'/member.php?app=43&action=1&cid='.$cid.'&op=1" title="查看退款" class="large blue awesome" target="_blank">查看退款</a>';
				  break;  
				  
				  case '5':
				  
				  if(($order['dateline']+7*24*60*60) > $this->NowTime()){
					   $name='<p><a href="'.SURL.'/member.php?app=42&action=1&cid='.$cid.'" title="维权" class="large blue awesome" target="_blank">维权</a></p>';
				  }
				  
				  if(!$this->IsSQL($tablename,"WHERE cid='$cid' AND type=2")){
				       $name.='<p style="margin-top:5px"><a title="评价" onclick="OpenCredit('.$cid.')" class="large red awesome">评价</a></p>';
				  }else{
					   $name.='';
				  }
				  break;
				  default:
				  $name='';
		  }
		  
		  
		  return  $name;
		   
	}
	
	function GetBuyerProcessWarning($process,$draftorder,$cid){
		  
		  $endtimearray=$this->GetOrderEndTime($cid);
			
		  switch ($process) {
		      case '1':
			        if($draftorder['bidmoney']){
						  $bidmoney='已托管赏金<strong>￥'.$draftorder['bidmoney'].'</strong>';
					}else{
						  $bidmoney='未托管赏金';
					}
					
                	$name='<p>'.$bidmoney.' ,您还需要托管 ￥ <span class="color_f60">'.($draftorder['sum']-$draftorder['bidmoney']).'</span> 元</p>';
					
				    if($endtimearray['runtime']){
					     $name.='<p>雇主必须在 <span class="color_f60">'.intval($endtimearray['endday']).'</span> 天 <span class="color_f60">'.intval($endtimearray['hour']*24).'</span> 小时 <b>'.$endtimearray['endtime'].'</b> 前支付该订单,逾期系统将自动关闭订单和中标！</p>';
					}
                
			  break;
			  case '2':

			        $name='<p>等待威客工作并文件交接</p>';
					if($endtimearray['runtime']){
                        $name.='<p>卖家必须在 <span class="color_f60">'.intval($endtimearray['endday']).'</span> 天 <span class="color_f60">'.intval($endtimearray['hour']*24).'</span> 小时 <b>'.$endtimearray['endtime'].'</b> 前确认交接,否则系统将自动退款订单取消中标！</p>';
					}
			  break;
              case '3':
                    
				    if($endtimearray['runtime']){
					     $name='<p>威客已确认交接, [系统自动确认时间 还有 <span class="color_f60">'.intval($endtimearray['endday']).'</span> 天 <span class="color_f60">'.intval($endtimearray['hour']*24).'</span> 小时 <b>'.$endtimearray['endtime'].'</b> ] <a onclick="ShowOrderFile();" class="small blue awesome">查看威客文件</a></p>';
					   
				    }else{
						
						 $name='<p>威客已确认交接</p>';
					}
					
                    
              break;
              case '4':
			  
				   if($endtimearray['runtime']){
					   	 $name='雇主申请退款中,卖家威客 还有 <span class="color_f60">'.intval($endtimearray['endday']).'</span> 天 <span class="color_f60">'.intval($endtimearray['hour']*24).'</span> 小时 <b>'.$endtimearray['endtime'].'</b> 处理退款申请.如果卖家逾期未处理,本次退款申请将自动达成并退款给雇主。';
				   }else{
				 
					    $refund=$this->GetMysqlOne('*'," ".$this->GetTable('refund_money')." WHERE cid='$cid'");
					    if($refund['process']==2 || $refund['serviceuid']>0){
							 $name='<p>卖家威客不同意退款,客服已介入请双方联系客服处理。</p>';
						}

				   }
				   
				   
              break;
			  
		  }
		  
		   return  $name;
	}
	
	function GetSellerProcessWarning($process,$draftorder,$cid){
		  
		  $endtimearray=$this->GetOrderEndTime($cid);
		  
		  switch ($process) {
		      case '1':
			        if($draftorder['bidmoney']){
						  $bidmoney='已托管赏金<strong>￥'.$draftorder['bidmoney'].'</strong>';
					}else{
						  $bidmoney='未托管赏金';
					}
					
                	$name='雇主 '.$bidmoney;
                
			  break;
              case '2':

                    $name='<p>雇主已托管赏金<strong> ￥'. $draftorder['sum'].'元</strong></p>';
					if($endtimearray['runtime']){
                        $name.='<p>卖家必须在 <span class="color_f60">'.intval($endtimearray['endday']).'</span> 天 <span class="color_f60">'.intval($endtimearray['hour']*24).'</span> 小时 <b>'.$endtimearray['endtime'].'</b> 前确认交接,否则系统将当弃权自动关闭订单和中标！</p>';
					}
              break;
			  case '3':
		
					if($endtimearray['runtime']){
						   $name='威客已交接,等待雇主确认接收. [系统自动确认时间 还有 <span class="color_f60">'.intval($endtimearray['endday']).'</span> 天 <span class="color_f60">'.intval($endtimearray['hour']*24).'</span> 小时 <b>'.$endtimearray['endtime'].'</b> ]';
					}
	
			  break;
              case '4':
                      
					if($endtimearray['runtime']){
						   $name='雇主申请退款中,您还有 <span class="color_f60">'.intval($endtimearray['endday']).'</span> 天 <span class="color_f60">'.intval($endtimearray['hour']*24).'</span> 小时 <b>'.$endtimearray['endtime'].'</b> 处理退款申请.如果您逾期未处理,本次退款申请将自动达成并退款给雇主。';
					}else{
					    $refund=$this->GetMysqlOne('*'," ".$this->GetTable('refund_money')." WHERE cid='$cid'");
					    if($refund['process']==2 || $refund['serviceuid']>0){
							 $name='<p>卖家威客不同意退款,客服已介入请双方联系客服处理。</p>';
						}
						
						$name='<p>卖家威客不同意退款,客服已介入请双方联系客服处理。</p>';
				   }
					
              break;
			 
			  
		  }
		  
		   return  $name;
	}
	
	
	function GetBuyerProcessName($tablename,$tablename2,$cid,$type=0,$app='',$paytype=0,$txt=0){
		
		  if($app){
		       $appid=$app;
		  }else{
			   $appid=$this->app;
		  }
		  
		  $order=$this->GetMysqlOne('process'," ".$this->GetTable('consume')." WHERE cid='$cid' ");
		  
		  $name='';
		  
		  if(!$type){
					  
				  switch ($order['process']) {
						  case '1':
						  
                          if($paytype==4){
							   $name='<span class="color_f60">等待汇款</span>';
						  }else{
						       $name='<span class="color_f60">等待雇主托管</span>';
						  }
						  
						  break;
						  case '2':
						  $name='<span class="color_f60">等待威客交接</span>';
						  break;
						  case '3':
						  $name='<span class="color_f60">威客已交接</span>';
						  break;
						  case '4':
						  $name='<span class="color_f60">雇主退款中</span>';
						  break;
						  case '5':
						  $name='<span class="color_c0b">交易成功</span>';
						  break;
						  case '6':
						  $name='<span class="color_f60">关闭订单</span>';
						  break;
				  }
		  }else{
			  
				  switch ($order['process']) {
						  case '1':
						  $name='等待雇主托管';
						  break;
						  case '2':
						  $name='雇主已托管,等待威客文件交接.';
						  break;
						  case '3':
						  $name='威客已交接,等待雇主确认交接. &nbsp; ';
						  
						  if(!$txt){
							   $name.=$this->GetBuyerProcessMenu($tablename2,$cid);
						  }
						  
						  break;
						  case '4':
						  $name='雇主退款中';
						  break;
						  case '5':
						  
						        if(!$this->IsSQL('task_order_credit',"WHERE cid='$cid' AND type=2")){
									  $menu='&nbsp; '.$this->GetBuyerProcessMenu($tablename2,$cid);
								}else{
									  $menu='';
								}
											 
						  $name='订单交易成功';
						  
						  if(!$txt){
								 $name.=$menu;
						  }
						  
						  
						  break;
						  case '6':
						  $name='关闭订单';
						  break;
				  }			  
			  	  
		  }
		  
		  
		  return  $name;
		   
	}
	
	
	function GetTaskProcesName($proces){

		         switch ($proces) {
						  case '1':
						  $name='<span class="color_f60">待支付托管金</span>';
						  break;
						  case '2':
						  $name='<span class="color_f60">已支付托管金</span>';
						  break;
						  case '3':
						  $name='<span class="color_f60">待审核</span>';
						  break;
						  case '4':
						  $name='<span class="color_f60">进行中</span>';
						  break;
						  case '5':
						  $name='<span class="color_f60">暂投稿中</span>';
						  break;
						  case '6':
						  $name='<span class="color_f60">待选稿中</span>';
						  break;
						  case '7':
						  $name='<span class="color_f60">退款中</span>';
						  break;
						  case '8':
						  $name='<span class="color_f60">结束</span>';
						  break;
						  case '9':
						  $name='<span class="color_f60">关闭</span>';
						  break;
						  default:
				          $name='';
				  }
		
		 return  $name;
	}
	
	function  GetTaskDraftName($proces){
		
		         switch ($proces) {
						  case '0':
						  $name='待中标';
						  break;
						  case '1':
						  $name='<span class="color_f60">中标</span>';
						  break;
						  case '2':
						  $name='<span class="color_f00">不合格</span>';
						  break;
						  case '3':
						  $name='关闭';
						  break;
						  
				  }
		
		 return  $name;
	}
	
	
	function  GetOrderEndTime($cid=0){
		
		      $endorder=$this->GetMysqlOne('a.oid,b.runtime'," ".$this->GetTable('task_order')." AS a JOIN ".$this->GetTable('autorun')." AS b ON a.runid=b.aid WHERE a.cid='$cid'");
					
			  $endtime=$this->Date('Y-m-d',$endorder['runtime']);
			  
			  $endday=($endorder['runtime']-$this->NowTime())/(24*60*60);
			  
			  $hourarr=explode('.',$endday); 
			  
			  $hour='0.'.$hourarr[1];
			  
			  return array('runtime'=>$endorder['runtime'],'endday'=>$endday,'hour'=>$hour,'endtime'=>$endtime,'oid'=>$endorder['oid']);
	}
}

?>