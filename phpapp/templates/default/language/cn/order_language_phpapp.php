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
{echo $task['tid']}�������б�������ȷ�Ͻ���!
</phpapp>

<phpapp language="Order_Confirm_Delivery_Content">
{echo $task['tid']}�������б�������ȷ�Ϸ���! <a href="{SURL}/member.php?app=48&action=4&oid={echo $task['oid']}" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>
</phpapp>

<phpapp language="Order_Confirm_Delivery_Operate">
<p>����ȷ��֧��,{echo $getprocess->GetBuyerProcessMenu('task_order_credit',$value)}</p>
</phpapp>


<phpapp language="Order_Refund_Subject">
����{echo $draft['did']}�Ÿ��������ȷ���˿�֧��!
</phpapp>


<phpapp language="Order_Refund_Content">
{echo $draft['did']}�Ÿ��������ȷ���˿�֧��! <a href="{SURL}/member.php?app=48&action=2&oid={echo $taskorder['oid']}" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>
</phpapp>
 
 
<phpapp language="Order_Pay_Subject">
��ϲ��!����{echo $draft['did']}�Ÿ�������ȷ��֧��!
</phpapp>


<phpapp language="Order_Pay_Content">
{echo $draft['did']}�Ÿ�������ȷ��֧��!<a href="{SURL}/member.php?app=48&action=2&oid={echo $taskorder['oid']}" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>
</phpapp>


<phpapp language="Order_Pay_Operate">
<p>����������,{echo $getprocess->GetSellerProcessMenu('task_order_credit',$cid)}</p>
</phpapp>

<phpapp language="Order_Complete_Subject">
��ϲ��!����{echo $task['tid']}�����������!
</phpapp>


<phpapp language="Order_Complete_Content">
<a href="{SURL}/member.php?app=48&action=4&oid={echo $taskorder['oid']}" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>
</phpapp>


<phpapp language="Order_Complete_Operate">
<p>����������,{echo $getprocess->GetBuyerProcessMenu('task_order_credit',$cid)}</p>
</phpapp>


<phpapp language="Order_Message_Subject">
{echo $oid}�Ŷ�����������!
</phpapp>

<phpapp language="Order_Message_Content">
<p><a href="{SURL}/member.php?app=48&action=2&oid={echo $oid}" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a></p>
</phpapp>


<phpapp language="Order_Seller_Evaluate_Subject">
{echo $value}�Ŷ�������������!
</phpapp>


<phpapp language="Order_Seller_Evaluate_Content">
<a href="{SURL}/member.php?app=48&action=4&oid={echo $task['oid']}" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>
</phpapp>

<phpapp language="Order_Buyers_Reward_Subject">
����{echo $this->username} ���������ķ��񣬶��⽱���ͽ�����
</phpapp>


<phpapp language="Order_Buyers_Reward_Content">
<p>�𾴵��û���</p>
<p>����{echo $orderarr['tid']} ������Ͷ���б�� {echo $orderarr['did']}�Ÿ��,����{echo $this->username} ���������ķ����ض��⽱���� <strong>{echo $award}</strong>Ԫ ϣ���ٽ�������</p>
<p>
<a href="{echo SURL.$orderarr['url']}" target="_blank"><span class="show_details">[�鿴����]</span></a>
<a href="{SURL}/member.php?app=48&action=2&oid={echo $orderarr['oid']}" target="_blank"><span class="show_details">[�鿴����]</span></a>
</p>
</phpapp>

<phpapp language="Order_Buyers_Reward_Error">
�Բ����������� <strong>{echo $award}</strong>Ԫ�����ֵ�������<br />
</phpapp>


<phpapp language="Order_Buyers_Waiting_For_Work">
<p>
������֧������ {echo $cid} ����,�ȴ�����������Դ����ȷ�Ͻ���.
<a href="{SURL}/member.php?app=48&action=2&oid={echo $task['oid']}" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>
</p>
<p>{echo $getprocess->GetSellerProcessMenu('task_order_credit',$cid)}</p>
</phpapp>

<phpapp language="Order_Buyers_Evaluate_Subject">
{echo $value}�Ŷ�������������!
</phpapp>

<phpapp language="Order_Buyers_Evaluate_Content">
<a href="{SURL}/member.php?app=48&action=2&oid={echo $draft['oid']}" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>
</phpapp>


<phpapp language="Order_Buyers_Invoice_Edit_Subject">
{echo $draft['tid']}�����񶩵������޸��˷�ƱҪ����!
</phpapp>

<phpapp language="Order_Buyers_Invoice_Subject">
{echo $draft['tid']}�����񶩵�����Ҫ�󿪷�Ʊ��!
</phpapp>

<phpapp language="Order_Buyers_Invoice_Content">
<a href="{SURL}/member.php?app=48&action=2&oid={echo $oid}" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>
</phpapp>

<phpapp language="Order_Buyers_NoMoney">
<p>�Բ�����������<span class="color_f60">{echo $paymoney}</span>Ԫ,���ֵ���ٲ�����</p>
<p><a href="{SURL}/member.php?app=5&action=2&pay={echo ($paymoney-$user['money'])}"><strong>[���������ֵ]</strong></a></p>
</phpapp>

<phpapp language="Order_Buyers_CloseOrder_Subject">
<p>���ź���������������ⲻ��֧����Ŀ,�ر���{echo $oderid}������</p>
</phpapp>

<phpapp language="Order_Buyers_CloseOrder_Content">
<a href="{SURL}/member.php?app=48&action=2&oid={echo $draft['oid']}" target="_blank"><span class="show_details">[�鿴��ϸ]</span></a>
</phpapp>



