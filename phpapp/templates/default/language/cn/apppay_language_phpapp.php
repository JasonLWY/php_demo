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

<phpapp language="To_cash">
提现
</phpapp>

<phpapp language="Waiting_for_remittances">
提交申请成功,等待 {echo PHPAPP::$config['sitename']} 汇款处理！<br />
</phpapp>

<phpapp language="Number_of_withdrawals">
对不起！,您今日已提现{echo $withdrawnum}次，明日再来吧！<br />
</phpapp>


<phpapp language="Maximum_cash_withdrawal_amount">
对不起！,最大提现金额为{echo $withdrawbig}元！<br />
</phpapp>


<phpapp language="Balance_is_less_than">
对不起！,您的可用余额不足{echo $paymoney}元不能提现！<br />
</phpapp>


<phpapp language="Cash_withdrawal_amount">
对不起！,提现金额不能小{echo $withdrawsmall}元！<br />
</phpapp>


<phpapp language="You_are_not_realname">
您未实名认证不能使用提现功能!
</phpapp>

<phpapp language="Cash_withdrawal_amount">
对不起！,提现金额不能小{echo $withdrawsmall}元！<br />
</phpapp>

<phpapp language="Pay_is_too_low">
充值不能低于{echo PHPAPP::$config['pay_small_money']}元
</phpapp>






