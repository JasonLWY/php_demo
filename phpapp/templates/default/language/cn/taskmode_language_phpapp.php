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
<p>�Բ����οͲ��ܲ鿴��Ӧ��!</p>
</phpapp>



<phpapp language="Post_mission_failed">
<p>��������ʧ��!</p>
</phpapp>


<phpapp language="Form_expiration">
<p>��������ʧ��!</p>
</phpapp>


<phpapp language="Enter_the_task_title">
<p>�������������!</p>
</phpapp>


<phpapp language="Charge_a_security_deposit">
<p>��������ϵͳ��ȡ������!</p>
</phpapp>


<phpapp language="Add_task_succeeds">
<p>��������ɹ�!</p>
</phpapp>



<phpapp language="Task_hide">
***�������������ص�¼��ɼ�!***
</phpapp>


<phpapp language="Realname_Contributors">
<p>�Բ���,����Ҫ��ʵ��Ͷ��! <a href="{SURL}/member.php?app=15" target="_blank">[�������ʵ����֤]</a><p>
</phpapp>



<phpapp language="Task_Props_Failed_purchase">
<p>���߹���ʧ�ܣ����Ŀ������� <strong>{echo $totalservice} Ԫ</strong> ,���ֵ���ٹ���<a href="{echo SURL}/member.php?app=5&action=2&pay={echo $totalservice}" target="_blank"><span class="show_details">[�����ֵ]</span></a></p>
</phpapp>


<phpapp language="Task_Contributors_Feed">
�� <a href="{echo SURL.$this->GetTaskURL($this->tid,$did)}" target="_blank" title="{echo $task['subject']}">{title}</a> ����Ͷ��
</phpapp>



<phpapp language="Task_Contributors_SMS_Subject">
{echo $this->username}����{echo $this->tid}������Ͷ����!
</phpapp>



<phpapp language="Task_Contributors_SMS_Content">
{echo $this->username}����{echo $this->tid}������Ͷ����<a href="{echo SURL.$this->GetTaskURL($this->tid,$did)}" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>
</phpapp>


<phpapp language="Task_Comment_SMS_Subject">
{echo $this->username}����{echo $value}�Ÿ��������!
</phpapp>


<phpapp language="Task_Comment_SMS_Content">
<p><a href="{SURL}/index.php?app={echo $task['appid']}&action=5&tid={echo $this->tid}&did={echo $value}" target="_blank"><span class="show_details">[�鿴���]</span></a></p>
</phpapp>


<phpapp language="Task_Message_SMS_Subject">
{echo $this->username}����{echo $this->tid}������������!
</phpapp>

<phpapp language="Task_Message_SMS_Content">
{echo $this->username}����{echo $this->tid}������������!<a href="{echo SURL.$task['url']}" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>
</phpapp>


<phpapp language="Draft_Successful_SMS_Subject">
{echo $draft["username"]}����{echo $value}�Ÿ���б���!
</phpapp>


<phpapp language="Draft_Successful_SMS_Content">
<p>{echo $draft["username"]}����{echo $value}�Ÿ���б���</p>
<p>
<a href="{echo SURL.$this->GetTaskURL($this->tid,$value)}" target="_blank"><span class="show_details">[�鿴���]</span></a> 
<a href="{SURL}/member.php?app=48&action=2&oid={echo $order}" target="_blank"><span class="show_details">[�鿴����]</span></a>
</p>
</phpapp>

<phpapp language="Draft_Successful_SMS_Operate">
<p>��������Դ����ȷ�Ͻ���,{echo $getprocess->GetSellerProcessMenu('task_order_credit',$cid)}</p>
</phpapp>


<phpapp language="Draft_Feed_Title_Template">
�� <a href="{echo SURL.$this->GetTaskURL($this->tid,$value)}" target="_blank" title="{echo $draft["subject"]}">{title}</a> �б���
</phpapp>

<phpapp language="Draft_Confirm_payment">
{echo $value}�Ÿ���б�ɹ����ȴ���ȷ��֧����<br />
</phpapp>


<phpapp language="Draft_Confirm_Connect">
{echo $value}�Ÿ���б�ɹ�,�ȴ����ͽ��ӣ�<br />
</phpapp>

<phpapp language="Draft_Unqualified_SMS_Subject">
{echo $draft['username']}����{echo $value}�Ÿ�����ϸ�!
</phpapp>

<phpapp language="Draft_Unqualified_SMS_Content">
{echo $draft['username']}����{echo $value}�Ÿ�����ϸ�!<a href="{echo SURL.$this->GetTaskURL($this->tid,$value)}" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>
</phpapp>

<phpapp language="Task_NeedToPay_SMS_Subject">
֪ͨ��{echo $order} �Ŷ�����Ҫ֧������!
</phpapp>


<phpapp language="Task_NeedToPay_SMS_Content">
{echo $order} �Ŷ����ȴ�����֧����<a href="{SURL}/member.php?app=48&action=2&oid={echo $order}" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a> 
</phpapp>


<phpapp language="Task_Expired_SMS_Subject">
����{echo $task['tid']}�������ѹ���!
</phpapp>

<phpapp language="Task_Expired_SMS_Content">
����{echo $task['tid']}�������ѹ���! <a href="{echo SURL.$task['url']}" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a> 
</phpapp>


<phpapp language="Task_Expired_Service_SMS_Subject">
֪ͨ {echo $task['tid']}�������ѹ��ڣ�
</phpapp>

<phpapp language="Task_Expired_Service_SMS_Content">
{echo $task['tid']}�������ѹ��ڣ��ȴ����Ĵ�ѡ����<a href="{echo SURL.$task['url']}" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>
</phpapp>


<phpapp language="Task_Expired_Task_SMS_Subject">
{echo $task['tid']}����������˿�
</phpapp>

<phpapp language="Task_Expired_Task_SMS_Content">
<p>�𾴵Ĺ������ã�{echo $task['tid']}�������ѹ���,ϵͳ����� <span class="color_f60">{echo $money}</span> Ԫ</p><p> <a href="{echo SURL.$task['url']}" target="_blank"><span class="show_details">[�鿴����]</span></a></p>
</phpapp>


