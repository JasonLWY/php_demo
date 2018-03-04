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
							   $name='<span class="color_f60">�ȴ����</span>';
						  }else{
						       $name='<span class="color_f60">�ȴ������й�</span>';
						  }
						  

						  break;
						  case '2':
						  $name='<span class="color_f60">�������й�</span>';
						  break;
						  case '3':
						  $name='<span class="color_f60">�ȴ�����ȷ��</span>';
						  break;
						  case '4':
						  $name='<span class="color_f60">�����˿���</span>';
						  break;
						  case '5':
						  $name='<span class="color_c0b">���׳ɹ�</span>';
						  break;
						  case '6':
						  $name='<span class="color_f60">�رն���</span>';
						  break;
				  }
		  }else{
			  
				  switch ($order['process']) {
						  case '1':
						  		$name='�ȴ������й�';
						  break;
						  case '2':

						  		$name='�������й�,�ȴ����͹������ļ�����.';
	
						  break;
						  case '3':

							   $name='�����ѽ���,�ȴ�����ȷ�Ͻ���.';
						  
						  break;
						  case '4':
		
						  		$name='�����˿���';
						  
						  break;
						  case '5':
						  
								if(!$this->IsSQL($tablename2,"WHERE cid='$cid' AND type=1")){
									  $menu='&nbsp; '.$this->GetSellerProcessMenu($tablename2,$oid);
								}else{
									  $menu='';
								}
											 
						  $name='�������׳ɹ�';
						  
						  if(!$txt){
							   $name.=$menu;
						  }
						  
						  break;
						  case '6':
						  $name='�رն���';
						  break;
				  }			  
			  	  
		  }
		  
		  
		  return  $name;
		   
	}
	
	
	function GetSellerProcessMenu($tablename,$cid){
		
		  $order=$this->GetMysqlOne('process'," ".$this->GetTable('consume')." WHERE cid='$cid'");
		  
		  switch ($order['process']) {
				  case '2':
				  $name='<p><a class="large red awesome" onclick="SellerSubmitDelivery('.$cid.')">ȷ�Ͻ���</a></p>';
				  break;
				  case '4':
				      $name='<a href="'.SURL.'/member.php?app=43&action=2&cid='.$cid.'&op=1" title="�鿴�˿�" class="large blue awesome" target="_blank">�鿴�˿�</a>';
				  break;  
				  case '5':
				  if(!$this->IsSQL($tablename,"WHERE cid='$cid' AND type=1")){
				       $name='<p><a title="����" onclick="SellerOpenCredit('.$cid.')" class="large red awesome">����</a></p>';
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
				  $name='<p><a class="large red awesome" title="��������" onclick="PaymentOrders('.$cid.','.$order['tid'].')">��������</a></p><p style="margin-top:5px"><a class="large blue awesome" title="�رն���" onclick="CloseOrders('.$cid.','.$order['tid'].')">�رն���</a></p>';
				  break;
				  case '3':
				  $name='<p><a href="'.SURL.'/member.php?app=43&action=1&cid='.$cid.'" title="�����˿�" class="large blue awesome" target="_blank">�����˿�</a></p><p style="margin-top:5px"><a title="ȷ���ջ�" onclick="OpenDelivery('.$cid.')" class="large red awesome">ȷ���ջ�</a></p>';
				  break;    
				  case '4':
				      $name='<a href="'.SURL.'/member.php?app=43&action=1&cid='.$cid.'&op=1" title="�鿴�˿�" class="large blue awesome" target="_blank">�鿴�˿�</a>';
				  break;  
				  
				  case '5':
				  
				  if(($order['dateline']+7*24*60*60) > $this->NowTime()){
					   $name='<p><a href="'.SURL.'/member.php?app=42&action=1&cid='.$cid.'" title="άȨ" class="large blue awesome" target="_blank">άȨ</a></p>';
				  }
				  
				  if(!$this->IsSQL($tablename,"WHERE cid='$cid' AND type=2")){
				       $name.='<p style="margin-top:5px"><a title="����" onclick="OpenCredit('.$cid.')" class="large red awesome">����</a></p>';
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
						  $bidmoney='���й��ͽ�<strong>��'.$draftorder['bidmoney'].'</strong>';
					}else{
						  $bidmoney='δ�й��ͽ�';
					}
					
                	$name='<p>'.$bidmoney.' ,������Ҫ�й� �� <span class="color_f60">'.($draftorder['sum']-$draftorder['bidmoney']).'</span> Ԫ</p>';
					
				    if($endtimearray['runtime']){
					     $name.='<p>���������� <span class="color_f60">'.intval($endtimearray['endday']).'</span> �� <span class="color_f60">'.intval($endtimearray['hour']*24).'</span> Сʱ <b>'.$endtimearray['endtime'].'</b> ǰ֧���ö���,����ϵͳ���Զ��رն������б꣡</p>';
					}
                
			  break;
			  case '2':

			        $name='<p>�ȴ����͹������ļ�����</p>';
					if($endtimearray['runtime']){
                        $name.='<p>���ұ����� <span class="color_f60">'.intval($endtimearray['endday']).'</span> �� <span class="color_f60">'.intval($endtimearray['hour']*24).'</span> Сʱ <b>'.$endtimearray['endtime'].'</b> ǰȷ�Ͻ���,����ϵͳ���Զ��˿��ȡ���б꣡</p>';
					}
			  break;
              case '3':
                    
				    if($endtimearray['runtime']){
					     $name='<p>������ȷ�Ͻ���, [ϵͳ�Զ�ȷ��ʱ�� ���� <span class="color_f60">'.intval($endtimearray['endday']).'</span> �� <span class="color_f60">'.intval($endtimearray['hour']*24).'</span> Сʱ <b>'.$endtimearray['endtime'].'</b> ] <a onclick="ShowOrderFile();" class="small blue awesome">�鿴�����ļ�</a></p>';
					   
				    }else{
						
						 $name='<p>������ȷ�Ͻ���</p>';
					}
					
                    
              break;
              case '4':
			  
				   if($endtimearray['runtime']){
					   	 $name='���������˿���,�������� ���� <span class="color_f60">'.intval($endtimearray['endday']).'</span> �� <span class="color_f60">'.intval($endtimearray['hour']*24).'</span> Сʱ <b>'.$endtimearray['endtime'].'</b> �����˿�����.�����������δ����,�����˿����뽫�Զ���ɲ��˿��������';
				   }else{
				 
					    $refund=$this->GetMysqlOne('*'," ".$this->GetTable('refund_money')." WHERE cid='$cid'");
					    if($refund['process']==2 || $refund['serviceuid']>0){
							 $name='<p>�������Ͳ�ͬ���˿�,�ͷ��ѽ�����˫����ϵ�ͷ�����</p>';
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
						  $bidmoney='���й��ͽ�<strong>��'.$draftorder['bidmoney'].'</strong>';
					}else{
						  $bidmoney='δ�й��ͽ�';
					}
					
                	$name='���� '.$bidmoney;
                
			  break;
              case '2':

                    $name='<p>�������й��ͽ�<strong> ��'. $draftorder['sum'].'Ԫ</strong></p>';
					if($endtimearray['runtime']){
                        $name.='<p>���ұ����� <span class="color_f60">'.intval($endtimearray['endday']).'</span> �� <span class="color_f60">'.intval($endtimearray['hour']*24).'</span> Сʱ <b>'.$endtimearray['endtime'].'</b> ǰȷ�Ͻ���,����ϵͳ������Ȩ�Զ��رն������б꣡</p>';
					}
              break;
			  case '3':
		
					if($endtimearray['runtime']){
						   $name='�����ѽ���,�ȴ�����ȷ�Ͻ���. [ϵͳ�Զ�ȷ��ʱ�� ���� <span class="color_f60">'.intval($endtimearray['endday']).'</span> �� <span class="color_f60">'.intval($endtimearray['hour']*24).'</span> Сʱ <b>'.$endtimearray['endtime'].'</b> ]';
					}
	
			  break;
              case '4':
                      
					if($endtimearray['runtime']){
						   $name='���������˿���,������ <span class="color_f60">'.intval($endtimearray['endday']).'</span> �� <span class="color_f60">'.intval($endtimearray['hour']*24).'</span> Сʱ <b>'.$endtimearray['endtime'].'</b> �����˿�����.���������δ����,�����˿����뽫�Զ���ɲ��˿��������';
					}else{
					    $refund=$this->GetMysqlOne('*'," ".$this->GetTable('refund_money')." WHERE cid='$cid'");
					    if($refund['process']==2 || $refund['serviceuid']>0){
							 $name='<p>�������Ͳ�ͬ���˿�,�ͷ��ѽ�����˫����ϵ�ͷ�����</p>';
						}
						
						$name='<p>�������Ͳ�ͬ���˿�,�ͷ��ѽ�����˫����ϵ�ͷ�����</p>';
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
							   $name='<span class="color_f60">�ȴ����</span>';
						  }else{
						       $name='<span class="color_f60">�ȴ������й�</span>';
						  }
						  
						  break;
						  case '2':
						  $name='<span class="color_f60">�ȴ����ͽ���</span>';
						  break;
						  case '3':
						  $name='<span class="color_f60">�����ѽ���</span>';
						  break;
						  case '4':
						  $name='<span class="color_f60">�����˿���</span>';
						  break;
						  case '5':
						  $name='<span class="color_c0b">���׳ɹ�</span>';
						  break;
						  case '6':
						  $name='<span class="color_f60">�رն���</span>';
						  break;
				  }
		  }else{
			  
				  switch ($order['process']) {
						  case '1':
						  $name='�ȴ������й�';
						  break;
						  case '2':
						  $name='�������й�,�ȴ������ļ�����.';
						  break;
						  case '3':
						  $name='�����ѽ���,�ȴ�����ȷ�Ͻ���. &nbsp; ';
						  
						  if(!$txt){
							   $name.=$this->GetBuyerProcessMenu($tablename2,$cid);
						  }
						  
						  break;
						  case '4':
						  $name='�����˿���';
						  break;
						  case '5':
						  
						        if(!$this->IsSQL('task_order_credit',"WHERE cid='$cid' AND type=2")){
									  $menu='&nbsp; '.$this->GetBuyerProcessMenu($tablename2,$cid);
								}else{
									  $menu='';
								}
											 
						  $name='�������׳ɹ�';
						  
						  if(!$txt){
								 $name.=$menu;
						  }
						  
						  
						  break;
						  case '6':
						  $name='�رն���';
						  break;
				  }			  
			  	  
		  }
		  
		  
		  return  $name;
		   
	}
	
	
	function GetTaskProcesName($proces){

		         switch ($proces) {
						  case '1':
						  $name='<span class="color_f60">��֧���йܽ�</span>';
						  break;
						  case '2':
						  $name='<span class="color_f60">��֧���йܽ�</span>';
						  break;
						  case '3':
						  $name='<span class="color_f60">�����</span>';
						  break;
						  case '4':
						  $name='<span class="color_f60">������</span>';
						  break;
						  case '5':
						  $name='<span class="color_f60">��Ͷ����</span>';
						  break;
						  case '6':
						  $name='<span class="color_f60">��ѡ����</span>';
						  break;
						  case '7':
						  $name='<span class="color_f60">�˿���</span>';
						  break;
						  case '8':
						  $name='<span class="color_f60">����</span>';
						  break;
						  case '9':
						  $name='<span class="color_f60">�ر�</span>';
						  break;
						  default:
				          $name='';
				  }
		
		 return  $name;
	}
	
	function  GetTaskDraftName($proces){
		
		         switch ($proces) {
						  case '0':
						  $name='���б�';
						  break;
						  case '1':
						  $name='<span class="color_f60">�б�</span>';
						  break;
						  case '2':
						  $name='<span class="color_f00">���ϸ�</span>';
						  break;
						  case '3':
						  $name='�ر�';
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