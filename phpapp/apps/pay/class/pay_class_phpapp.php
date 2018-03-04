<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

// pay
class PayMoney extends PHPAPP{
	
    private $payorder,$payapp,$paytool,$paymoney,$paygoodsname,$paydescription,$dateline;
	
	function __construct($payarr=''){
		
		  parent::__construct();
		  
		  $this->payapp=empty($_GET['app']) ? 0 : intval($_GET['app']);

		  $this->paytool=empty($payarr['PayToolID'])? 0 : $payarr['PayToolID'];
		  
		  $this->paygoodsname=PHPAPP::$config['paygoodsname'];
		  
		  $this->paydescription=PHPAPP::$config['paydescription'];
		  
		  $this->paymoney=empty($payarr['PayMoney']) ? 0 :floatval(trim($payarr['PayMoney']));
		  
		  $this->dateline=$this->NowTime();
		
	}
	

	public function SetPayTools($paymode=''){
		  
		  $timearr=@gettimeofday();
		  
		  $this->payorder=@date('YmdHis',$timearr['sec']).intval(substr($timearr['usec'],0,4));
			   
			   
		  if(!empty($paymode)){
		       $this->paytool=$paymode;
		  }
		  
	      if($this->uid >0){
			  

			   if($this->IsSQL('pay',"WHERE payuid='$this->uid'")){
				       
					  $deltime=$this->dateline-(24*60*60*16);
				      //���16��ǰ
				      $this->Delete('pay',"WHERE payuid='$this->uid' AND dateline<'$deltime' ");

			   }
					
				//��¼֧��
				$this->Insert('pay',array('payapp'=>$this->payapp,'payorder'=>$this->payorder,'paytool'=>$this->paytool,'payuid'=>$this->uid,'paymoney'=>$this->paymoney,'dateline'=>$this->dateline));
  
				$this->PayTools();  

				  
		
				
		  }else{
			   //δ��¼
			   exit('δ��¼');
		  }
	}

	
		 
	public function PayTools(){

		  //��ȡ֧������
		  $paytools=$this->GetMysqlOne('id_phpapp,class_phpapp,dir_phpapp'," ".$this->GetTable('apps')." WHERE id_phpapp='$this->paytool'");
		  
		  if($paytools){
			    
				$payclassname=$paytools['class_phpapp'].'Controls';
				
		        include_once(APPS.'/'.$paytools['dir_phpapp'].'/main_phpapp.php');
				
				//$paytool=new $payclassname;
				
				//$paytool->PaySubmit($this->payorder,$this->paymoney,$paytools['id_phpapp'],$this->paygoodsname,$this->paydescription);
				
				exit();
		 
		  }else{
			    exit('Ӧ�ò�����!');
		  }
	}
	
	
		 
	 public function SetPayMoney($order,$paymoney=0,$payname=''){
           
		  //if($this->uid >0){
		  
				  if($this->IsSQL('consume'," WHERE  serial='$order' AND amount='$paymoney'")){
						  
						   
							 //$this->Refresh('�ö�����֧������',SURL);
							 $this->Refresh('��ֵ�ɹ�!',SURL.'/member.php?app=5');

						  
				  }else{
							
						  if($this->IsSQL('pay'," WHERE payorder='$order' AND paymoney='$paymoney'")){

								  
								  $payname=$this->str($payname,26,1,0,1,0,1);
								  
								  $apps=$this->GetMysqlOne('id_phpapp,name_phpapp'," ".$this->GetTable('apps')." WHERE class_phpapp='$payname'");
								  
								  $payarray=$this->GetMysqlOne('payuid'," ".$this->GetTable('pay')." WHERE payorder='$order' AND paymoney='$paymoney' ");
								 
								  //��¼
								  include_once(APPS.'/apppay/class/consume_class_phpapp.php');
		
								  $pay=new UserConsume();
								  
								  $newcid=$pay->MakeConsume(array(
																  
														  'subject'=>'<p>��ֵ</p>'.$apps['name_phpapp'],  
														  'appid'=>$apps['id_phpapp'], 
														  'serial'=>$order, 
														  'paytype'=>3, 
														  'process'=>1, 
														  'amount'=>$paymoney, 
														  'payout'=>0, 
														  'payin'=>$payarray['payuid']
														  
													));
								  
								  
								  
								  $pay->SetSuccessConsume($newcid); 
								  
								  //$this->Delete('pay'," WHERE payorder='$order' AND paymoney='$paymoney' AND payuid='$this->uid' ");
								  
								  $this->Refresh('��ֵ�ɹ�!',SURL.'/member.php?app=5');
								
						
						  }else{
								
		
								$this->Refresh('�ö��������ڻ��ѹر�!',SURL);
			
								
						  }
				  }
				  
		  //}else{
			     // $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL);
		  //}
			    
		 	 
     }
	 
	 
	 public function PayError(){
		 
		    $this->Refresh('��֤���ϸ�',SURL);
			
	 }



}

 

 
?>