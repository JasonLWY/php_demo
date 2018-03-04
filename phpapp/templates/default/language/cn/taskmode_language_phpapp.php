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

<phpapp language="Visitors_can_not_view">
<p>对不起游客不能查看该应用!</p>
</phpapp>



<phpapp language="Post_mission_failed">
<p>发布任务失败!</p>
</phpapp>


<phpapp language="Form_expiration">
<p>发布任务失败!</p>
</phpapp>


<phpapp language="Enter_the_task_title">
<p>请输入任务标题!</p>
</phpapp>


<phpapp language="Charge_a_security_deposit">
<p>发布任务系统收取担保金!</p>
</phpapp>


<phpapp language="Add_task_succeeds">
<p>发布任务成功!</p>
</phpapp>



<phpapp language="Task_hide">
***任务内容已隐藏登录后可见!***
</phpapp>


<phpapp language="Realname_Contributors">
<p>对不起,任务要求实名投稿! <a href="{SURL}/member.php?app=15" target="_blank">[点击进行实名认证]</a><p>
</phpapp>



<phpapp language="Task_Props_Failed_purchase">
<p>道具购买失败！您的可用余额不足 <strong>{echo $totalservice} 元</strong> ,请充值后再购买！<a href="{echo SURL}/member.php?app=5&action=2&pay={echo $totalservice}" target="_blank"><span class="show_details">[点击充值]</span></a></p>
</phpapp>


<phpapp language="Task_Contributors_Feed">
在 <a href="{echo SURL.$this->GetTaskURL($this->tid,$did)}" target="_blank" title="{echo $task['subject']}">{title}</a> 任务投稿
</phpapp>



<phpapp language="Task_Contributors_SMS_Subject">
{echo $this->username}在您{echo $this->tid}号任务投标了!
</phpapp>



<phpapp language="Task_Contributors_SMS_Content">
{echo $this->username}在您{echo $this->tid}号任务投标了<a href="{echo SURL.$this->GetTaskURL($this->tid,$did)}" target="_blank"><span class="show_details">[查看详细]</span></a>
</phpapp>


<phpapp language="Task_Comment_SMS_Subject">
{echo $this->username}在您{echo $value}号稿件点评了!
</phpapp>


<phpapp language="Task_Comment_SMS_Content">
<p><a href="{SURL}/index.php?app={echo $task['appid']}&action=5&tid={echo $this->tid}&did={echo $value}" target="_blank"><span class="show_details">[查看稿件]</span></a></p>
</phpapp>


<phpapp language="Task_Message_SMS_Subject">
{echo $this->username}在您{echo $this->tid}号任务留言了!
</phpapp>

<phpapp language="Task_Message_SMS_Content">
{echo $this->username}在您{echo $this->tid}号任务留言了!<a href="{echo SURL.$task['url']}" target="_blank"><span class="show_details">[查看详细]</span></a>
</phpapp>


<phpapp language="Draft_Successful_SMS_Subject">
{echo $draft["username"]}您的{echo $value}号稿件中标了!
</phpapp>


<phpapp language="Draft_Successful_SMS_Content">
<p>{echo $draft["username"]}您的{echo $value}号稿件中标了</p>
<p>
<a href="{echo SURL.$this->GetTaskURL($this->tid,$value)}" target="_blank"><span class="show_details">[查看稿件]</span></a> 
<a href="{SURL}/member.php?app=48&action=2&oid={echo $order}" target="_blank"><span class="show_details">[查看订单]</span></a>
</p>
</phpapp>

<phpapp language="Draft_Successful_SMS_Operate">
<p>等您交接源件并确认交接,{echo $getprocess->GetSellerProcessMenu('task_order_credit',$cid)}</p>
</phpapp>


<phpapp language="Draft_Feed_Title_Template">
在 <a href="{echo SURL.$this->GetTaskURL($this->tid,$value)}" target="_blank" title="{echo $draft["subject"]}">{title}</a> 中标了
</phpapp>

<phpapp language="Draft_Confirm_payment">
{echo $value}号稿件中标成功！等待您确认支付！<br />
</phpapp>


<phpapp language="Draft_Confirm_Connect">
{echo $value}号稿件中标成功,等待威客交接！<br />
</phpapp>

<phpapp language="Draft_Unqualified_SMS_Subject">
{echo $draft['username']}您的{echo $value}号稿件不合格!
</phpapp>

<phpapp language="Draft_Unqualified_SMS_Content">
{echo $draft['username']}您的{echo $value}号稿件不合格!<a href="{echo SURL.$this->GetTaskURL($this->tid,$value)}" target="_blank"><span class="show_details">[查看详细]</span></a>
</phpapp>

<phpapp language="Task_NeedToPay_SMS_Subject">
通知：{echo $order} 号订单需要支付担保!
</phpapp>


<phpapp language="Task_NeedToPay_SMS_Content">
{echo $order} 号订单等待您的支付！<a href="{SURL}/member.php?app=48&action=2&oid={echo $order}" target="_blank"><span class="show_details">[查看详细]</span></a> 
</phpapp>


<phpapp language="Task_Expired_SMS_Subject">
您的{echo $task['tid']}号任务已过期!
</phpapp>

<phpapp language="Task_Expired_SMS_Content">
您的{echo $task['tid']}号任务已过期! <a href="{echo SURL.$task['url']}" target="_blank"><span class="show_details">[查看详细]</span></a> 
</phpapp>


<phpapp language="Task_Expired_Service_SMS_Subject">
通知 {echo $task['tid']}号任务已过期！
</phpapp>

<phpapp language="Task_Expired_Service_SMS_Content">
{echo $task['tid']}号任务已过期！等待您的代选处理！<a href="{echo SURL.$task['url']}" target="_blank"><span class="show_details">[查看详细]</span></a>
</phpapp>


<phpapp language="Task_Expired_Task_SMS_Subject">
{echo $task['tid']}号任务过期退款
</phpapp>

<phpapp language="Task_Expired_Task_SMS_Content">
<p>尊敬的雇主您好！{echo $task['tid']}号任务已过期,系统退余额 <span class="color_f60">{echo $money}</span> 元</p><p> <a href="{echo SURL.$task['url']}" target="_blank"><span class="show_details">[查看任务]</span></a></p>
</phpapp>


