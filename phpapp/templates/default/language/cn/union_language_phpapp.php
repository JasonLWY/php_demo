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

<phpapp language="emailcode">
      <div style="border: 1px solid #CCC;overflow: hidden;background-color: #F1F8FE;line-height: 22px;">
	  <dl>
	  <dt style="float: left;width: 120px;height: 200px;padding: 20px;text-align: center;">
	  {echo $this->GetUserAvatar($member["uid"],1,1)}
	  <p><a href="{SURL}/space.php?app=8&uid={echo $member["uid"]}" target="_blank">{echo $member["username"]}</a><p>
	  </dt>
	  <dd style="padding: 20px;">
	  <h2 style="font-size: 16px;line-height: 24px;">Hi������{echo $member['username']}����{echo PHPAPP::$config["sitename"]}��������׬Ǯ��������Ҳ���벢��Ϊ�ҵĺ��ѡ�</h2>
	  <p>����뵽�ҵĺ����У���Ϳ���ͨ���ҵĸ�����ҳ�˽��ҵĽ�����һ��������׬Ǯ����ʱ���ұ�����ϵ��</p>
	  <h3 style="font-size: 14px;">�������������ӣ����ܺ�������ע�᣺</h3>
	  <p><a href="{SURL}/?u={echo $member["uid"]}">{SURL}/?u={echo $member["uid"]}</a></p>
	  <h3 style="font-size: 14px;">�����ӵ������������˺ţ������������Ӳ鿴�ҵĸ�����ҳ��</h3>
	  <p><a href="{SURL}/space.php?app=8&uid={echo $member["uid"]}" target="_blank">{SURL}/space.php?app=8&uid={echo $member["uid"]}</a></p>
	  </dd>
	  </dl>
	  </div>
</phpapp>
