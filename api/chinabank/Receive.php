<?

include('../../api.php');

$key=PHPAPP::$config['chinabankkey'];			//��½��������ĵ�����������ҵ������Ϲ����������Ϲ���Ķ������������С�MD5��Կ���á� 

$v_oid     =trim($_POST['v_oid']);       // �̻����͵�v_oid�������   
$v_pmode   =trim($_POST['v_pmode']);    // ֧����ʽ���ַ�����   
$v_pstatus =trim($_POST['v_pstatus']);   //  ֧��״̬ ��20��֧���ɹ�����30��֧��ʧ�ܣ�
$v_pstring =trim($_POST['v_pstring']);   // ֧�������Ϣ �� ֧����ɣ���v_pstatus=20ʱ����ʧ��ԭ�򣨵�v_pstatus=30ʱ,�ַ������� 
$v_amount  =trim($_POST['v_amount']);     // ����ʵ��֧�����
$v_moneytype  =trim($_POST['v_moneytype']); //����ʵ��֧������    
$remark1   =trim($_POST['remark1']);      //��ע�ֶ�1
$remark2   =trim($_POST['remark2']);     //��ע�ֶ�2
$v_md5str  =trim($_POST['v_md5str']);   //ƴ�պ��MD5У��ֵ        

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