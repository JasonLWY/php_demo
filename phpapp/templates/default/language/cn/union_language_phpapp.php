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
	  <h2 style="font-size: 16px;line-height: 24px;">Hi，我是{echo $member['username']}，在{echo PHPAPP::$config["sitename"]}上做任务赚钱，邀请你也加入并成为我的好友。</h2>
	  <p>请加入到我的好友中，你就可以通过我的个人主页了解我的近况，一起做任务赚钱，随时与我保持联系。</p>
	  <h3 style="font-size: 14px;">请你点击以下链接，接受好友邀请注册：</h3>
	  <p><a href="{SURL}/?u={echo $member["uid"]}">{SURL}/?u={echo $member["uid"]}</a></p>
	  <h3 style="font-size: 14px;">如果你拥有威客上面的账号，请点击以下链接查看我的个人主页：</h3>
	  <p><a href="{SURL}/space.php?app=8&uid={echo $member["uid"]}" target="_blank">{SURL}/space.php?app=8&uid={echo $member["uid"]}</a></p>
	  </dd>
	  </dl>
	  </div>
</phpapp>
