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

<phpapp language="Order_Confirm_Delivery_Subject">
{echo $task['tid']}号任务中标威客已确认交接!
</phpapp>

<phpapp language="Order_Confirm_Delivery_Content">
{echo $task['tid']}号任务中标威客已确认发货! <a href="{SURL}/member.php?app=48&action=4&oid={echo $task['oid']}" target="_blank"><span class="show_details">[查看详细]</span></a>
</phpapp>

<phpapp language="Order_Confirm_Delivery_Operate">
<p>等您确认支付,{echo $getprocess->GetBuyerProcessMenu('task_order_credit',$value)}</p>
</phpapp>


<phpapp language="Order_Refund_Subject">
您的{echo $draft['did']}号稿件雇主已确认退款支付!
</phpapp>


<phpapp language="Order_Refund_Content">
{echo $draft['did']}号稿件雇主已确认退款支付! <a href="{SURL}/member.php?app=48&action=2&oid={echo $taskorder['oid']}" target="_blank"><span class="show_details">[查看详细]</span></a>
</phpapp>
 
 
<phpapp language="Order_Pay_Subject">
恭喜您!您的{echo $draft['did']}号稿件买家已确认支付!
</phpapp>


<phpapp language="Order_Pay_Content">
{echo $draft['did']}号稿件买家已确认支付!<a href="{SURL}/member.php?app=48&action=2&oid={echo $taskorder['oid']}" target="_blank"><span class="show_details">[查看详细]</span></a>
</phpapp>


<phpapp language="Order_Pay_Operate">
<p>等您的评价,{echo $getprocess->GetSellerProcessMenu('task_order_credit',$cid)}</p>
</phpapp>

<phpapp language="Order_Complete_Subject">
恭喜您!您的{echo $task['tid']}号任务交易完成!
</phpapp>


<phpapp language="Order_Complete_Content">
<a href="{SURL}/member.php?app=48&action=4&oid={echo $taskorder['oid']}" target="_blank"><span class="show_details">[查看详细]</span></a>
</phpapp>


<phpapp language="Order_Complete_Operate">
<p>等您的评价,{echo $getprocess->GetBuyerProcessMenu('task_order_credit',$cid)}</p>
</phpapp>


<phpapp language="Order_Message_Subject">
{echo $oid}号订单有留言啦!
</phpapp>

<phpapp language="Order_Message_Content">
<p><a href="{SURL}/member.php?app=48&action=2&oid={echo $oid}" target="_blank"><span class="show_details">[查看详细]</span></a></p>
</phpapp>


<phpapp language="Order_Seller_Evaluate_Subject">
{echo $value}号订单威客已评价!
</phpapp>


<phpapp language="Order_Seller_Evaluate_Content">
<a href="{SURL}/member.php?app=48&action=4&oid={echo $task['oid']}" target="_blank"><span class="show_details">[查看详细]</span></a>
</phpapp>

<phpapp language="Order_Buyers_Reward_Subject">
雇主{echo $this->username} 很满意您的服务，额外奖励赏金啦！
</phpapp>


<phpapp language="Order_Buyers_Reward_Content">
<p>尊敬的用户！</p>
<p>您在{echo $orderarr['tid']} 号任务投稿中标的 {echo $orderarr['did']}号稿件,雇主{echo $this->username} 很满意您的服务，特额外奖励您 <strong>{echo $award}</strong>元 希望再接再厉！</p>
<p>
<a href="{echo SURL.$orderarr['url']}" target="_blank"><span class="show_details">[查看任务]</span></a>
<a href="{SURL}/member.php?app=48&action=2&oid={echo $orderarr['oid']}" target="_blank"><span class="show_details">[查看订单]</span></a>
</p>
</phpapp>

<phpapp language="Order_Buyers_Reward_Error">
对不起！您的余额不足 <strong>{echo $award}</strong>元，请充值后操作！<br />
</phpapp>


<phpapp language="Order_Buyers_Waiting_For_Work">
<p>
雇主已支付担保 {echo $cid} 订单,等待您工作交接源件并确认交接.
<a href="{SURL}/member.php?app=48&action=2&oid={echo $task['oid']}" target="_blank"><span class="show_details">[查看详细]</span></a>
</p>
<p>{echo $getprocess->GetSellerProcessMenu('task_order_credit',$cid)}</p>
</phpapp>

<phpapp language="Order_Buyers_Evaluate_Subject">
{echo $value}号订单雇主已评价!
</phpapp>

<phpapp language="Order_Buyers_Evaluate_Content">
<a href="{SURL}/member.php?app=48&action=2&oid={echo $draft['oid']}" target="_blank"><span class="show_details">[查看详细]</span></a>
</phpapp>


<phpapp language="Order_Buyers_Invoice_Edit_Subject">
{echo $draft['tid']}号任务订单雇主修改了发票要求了!
</phpapp>

<phpapp language="Order_Buyers_Invoice_Subject">
{echo $draft['tid']}号任务订单雇主要求开发票了!
</phpapp>

<phpapp language="Order_Buyers_Invoice_Content">
<a href="{SURL}/member.php?app=48&action=2&oid={echo $oid}" target="_blank"><span class="show_details">[查看详细]</span></a>
</phpapp>

<phpapp language="Order_Buyers_NoMoney">
<p>对不起！您的余额不足<span class="color_f60">{echo $paymoney}</span>元,请充值后再操作！</p>
<p><a href="{SURL}/member.php?app=5&action=2&pay={echo ($paymoney-$user['money'])}"><strong>[点击立即充值]</strong></a></p>
</phpapp>

<phpapp language="Order_Buyers_CloseOrder_Subject">
<p>很遗憾！雇主因个人问题不想支付项目,关闭了{echo $oderid}订单！</p>
</phpapp>

<phpapp language="Order_Buyers_CloseOrder_Content">
<a href="{SURL}/member.php?app=48&action=2&oid={echo $draft['oid']}" target="_blank"><span class="show_details">[查看详细]</span></a>
</phpapp>



