<?php
/*
	EDOOG.COM (C) 2009-2013 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.1
*/	 
if(!defined('IN_PHPAPP')){exit('Data error');} 
$languagearr=array('To_cash'=>'
提现
',

'Waiting_for_remittances'=>'
提交申请成功,等待 {echo PHPAPP::$config["sitename"]} 汇款处理！<br />
',

'Number_of_withdrawals'=>'
对不起！,您今日已提现{echo $withdrawnum}次，明日再来吧！<br />
',


'Maximum_cash_withdrawal_amount'=>'
对不起！,最大提现金额为{echo $withdrawbig}元！<br />
',


'Balance_is_less_than'=>'
对不起！,您的可用余额不足{echo $paymoney}元不能提现！<br />
',


'Cash_withdrawal_amount'=>'
对不起！,提现金额不能小{echo $withdrawsmall}元！<br />
',


'You_are_not_realname'=>'
您未实名认证不能使用提现功能!
',

'Cash_withdrawal_amount'=>'
对不起！,提现金额不能小{echo $withdrawsmall}元！<br />
',

'Pay_is_too_low'=>'
充值不能低于{echo PHPAPP::$config["pay_small_money"]}元
',); ?>