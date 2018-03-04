<?

include('../../api.php');

$key=PHPAPP::$config['chinabankkey'];			//登陆后在上面的导航栏里可能找到“资料管理”，在资料管理的二级导航栏里有“MD5密钥设置” 

$v_oid     =trim($_POST['v_oid']);       // 商户发送的v_oid定单编号   
$v_pmode   =trim($_POST['v_pmode']);    // 支付方式（字符串）   
$v_pstatus =trim($_POST['v_pstatus']);   //  支付状态 ：20（支付成功）；30（支付失败）
$v_pstring =trim($_POST['v_pstring']);   // 支付结果信息 ： 支付完成（当v_pstatus=20时）；失败原因（当v_pstatus=30时,字符串）； 
$v_amount  =trim($_POST['v_amount']);     // 订单实际支付金额
$v_moneytype  =trim($_POST['v_moneytype']); //订单实际支付币种    
$remark1   =trim($_POST['remark1']);      //备注字段1
$remark2   =trim($_POST['remark2']);     //备注字段2
$v_md5str  =trim($_POST['v_md5str']);   //拼凑后的MD5校验值        

$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));

@include_once(APPS.'/pay/class/pay_class_phpapp.php');
$pay=new PayMoney();
			
if($v_md5str==$md5string){
	
		if($v_pstatus=="20"){

			 $pay->SetPayMoney($v_oid,$v_amount,'ChinaBank');
			 
		}else{
			 $pay->PayError();
		}

}else{
	    $pay->PayError();
}
?>