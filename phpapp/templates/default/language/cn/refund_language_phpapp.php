<?php
/*
	EDOOG.COM (C) 2009-2014 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2012.2.20
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}
?>

<phpapp language="Refund_Buyers_Apply_SMS_Subject">
������ˮ�� {echo $consumearr['serial'].$edittxt} �˿�����!
</phpapp>



<phpapp language="Refund_Buyers_Apply_SMS_Content">
���� {echo $sellerarr['username']} �������˿�!<a href="{SURL}/member.php?app={echo $this->app}&action=2&cid={echo $this->cid}&rid={echo $this->rid}&op=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>
</phpapp>


<phpapp language="Refund_Seller_Agree_SMS_Subject">
������ˮ�� {echo $consumearr['serial']} ͬ���˿�����!
</phpapp>


<phpapp language="Refund_Seller_Apply_SMS_Content">
���� {echo $sellerarr['username']} ͬ���������˿�����! <a href="{SURL}/member.php?app={echo $this->app}&action=2&cid={echo $this->cid}&rid={echo $this->rid}&op=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>
</phpapp>

<phpapp language="Refund_Seller_Disagree_SMS_Subject">
������ˮ�� {echo $consumearr['serial']} ��ͬ���˿�!
</phpapp>



<phpapp language="Refund_Seller_Disagree_SMS_Content">
�������� {echo $sellerarr['username']} ��ͬ�������˿�����! ��վ�ͷ�������Ա�ѽ���<a href="{SURL}/member.php?app={echo $this->app}&action=1&cid={echo $this->cid}&rid={echo $this->rid}&op=1" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>
</phpapp>