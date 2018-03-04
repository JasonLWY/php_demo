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
订单流水号 {echo $consumearr['serial'].$edittxt} 退款申请!
</phpapp>



<phpapp language="Refund_Buyers_Apply_SMS_Content">
雇主 {echo $sellerarr['username']} 申请了退款!<a href="{SURL}/member.php?app={echo $this->app}&action=2&cid={echo $this->cid}&rid={echo $this->rid}&op=1" target="_blank"><span class="show_details">[查看详细]</span></a>
</phpapp>


<phpapp language="Refund_Seller_Agree_SMS_Subject">
订单流水号 {echo $consumearr['serial']} 同意退款申请!
</phpapp>


<phpapp language="Refund_Seller_Apply_SMS_Content">
威客 {echo $sellerarr['username']} 同意了您的退款申请! <a href="{SURL}/member.php?app={echo $this->app}&action=2&cid={echo $this->cid}&rid={echo $this->rid}&op=1" target="_blank"><span class="show_details">[查看详细]</span></a>
</phpapp>

<phpapp language="Refund_Seller_Disagree_SMS_Subject">
订单流水号 {echo $consumearr['serial']} 不同意退款!
</phpapp>



<phpapp language="Refund_Seller_Disagree_SMS_Content">
卖家威客 {echo $sellerarr['username']} 不同意您的退款申请! 本站客服工作人员已介入<a href="{SURL}/member.php?app={echo $this->app}&action=1&cid={echo $this->cid}&rid={echo $this->rid}&op=1" target="_blank"><span class="show_details">[查看详细]</span></a>
</phpapp>