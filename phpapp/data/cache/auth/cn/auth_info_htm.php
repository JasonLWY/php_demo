<?php if(!defined('IN_PHPAPP')){exit('Data error');} ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo S_CHARSET; ?>" />
<title>PHPAPP后台管理</title>
<head>
	<link rel="stylesheet" href="<?php echo TURL; ?>dialog.css">
    <link rel="stylesheet" href="<?php echo TURL; ?>form.css">
    <link rel="stylesheet" href="<?php echo TURL; ?>admin_common.css">
    <link rel="stylesheet" href="<?php echo TURL; ?>admin_manage.css">
    <link href="<?php echo TURL; ?>credit.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo TURL; ?>poshytip/tip-green/tip-green.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo TURL; ?>poshytip/tip-darkgray/tip-darkgray.css" rel="stylesheet" type="text/css" />
</head>

<body>

<script type="text/javascript">
var SURL ='<?php echo SURL; ?>';
var TURL ='<?php echo TURL; ?>';
var Language='<?php echo $this->lang; ?>';
var USERID='<?php echo $this->uid; ?>';
var CategoryURL ="<?php echo SURL; ?>/member.php?app=10&action=1";
var TaskSkillURL ="<?php echo SURL; ?>/index.php?app=27&action=1";
var UserSkillsNumber=30;
</script>

<script type="text/javascript" src="<?php echo TURL; ?>js/jquery.js?v=<?php echo $this->GetFileVersion(); ?>"></script>
<script type="text/javascript" src="<?php echo TURL; ?>js/table.js?v=<?php echo $this->GetFileVersion(); ?>"></script>
<script type="text/javascript" src="<?php echo TURL; ?>js/input.js?v=<?php echo $this->GetFileVersion(); ?>"></script>
<script type="text/javascript" src="<?php echo TURL; ?>js/dialog.js?v=<?php echo $this->GetFileVersion(); ?>"></script>
<script type="text/javascript" src="<?php echo TURL; ?>js/member.js?v=<?php echo $this->GetFileVersion(); ?>"></script>
<script type="text/javascript" src="<?php echo TURL; ?>js/header.js?v=<?php echo $this->GetFileVersion(); ?>"></script>

<!-- poshytip -->
<script type="text/javascript" src="<?php echo TURL; ?>poshytip/jquery.poshytip.js?v=<?php echo $this->GetFileVersion(); ?>"></script>

<!--  datepicker  -->
<script type="text/javascript" src="<?php echo TURL; ?>js/datepicker-<?php echo $this->lang; ?>.js?v=<?php echo $this->GetFileVersion(); ?>"></script>
<script type="text/javascript" src="<?php echo TURL; ?>js/admin.js?v=<?php echo $this->GetFileVersion(); ?>"></script>
    
<div id="loading" style="display:none" title="读取数据中..."></div>

<div class="manage_menu"><ul><?php echo $this->actionmenu; ?></ul></div>

<script type="text/javascript">
function NowLogin(){
	 return USERID;
}

function SubmitContent(){
	
	$.SaveContent();	
	
	var content=$("#Content");
	if (content.val()==""){
		  alert("请输入内容!");
		  content.focus();
		  return false; 
	}
}
</script>




<div class="authinfo">

<div class="authh2">系统提示 </div>

<div  class="site_remind">
<ul>

<li><a href="?app=5&menu=10&action=3" target="_blank" class="help_small" title="有 <?php echo intval($deposit); ?> 个提现未处理"><span class="color_f60"><?php echo intval($deposit); ?></span> 提现申请中</a></li>

<li><a href="?sqlorder=7&iforder=1&menu=102&app=15&action=0" target="_blank" class="help_small" title="有 <?php echo intval($personalcertificate); ?> 个会员认证中"><span class="color_f60"><?php echo intval($personalcertificate); ?></span> 会员认证中</a></li>

<li><a href="?sqlorder=7&iforder=1&menu=103&app=16&action=0" target="_blank" class="help_small" title="有 <?php echo intval($companycertificate); ?> 个企业认证中"><span class="color_f60"><?php echo intval($companycertificate); ?></span> 企业认证中</a></li>

<li><a href="?sqlorder=4&iforder=1&app=21&menu=45&action=7" target="_blank" class="help_small" title="有 <?php echo intval($mobilecertificate); ?> 手机认证中"><span class="color_f60"><?php echo intval($mobilecertificate); ?></span> 手机认证中</a></li>

<li><a href="?sqlorder=4&iforder=1&menu=133&app=14&action=0" target="_blank" class="help_small" title="有 <?php echo intval($mailcertificate); ?> 邮箱认证中"><span class="color_f60"><?php echo intval($mailcertificate); ?></span> 邮箱认证中</a></li>

</ul>

<ul>
<li><a href="?sqlorder=7&iforder=1&menu=44&app=47&action=0" target="_blank" class="help_small" title="有 <?php echo intval($mailcertificate); ?> 举报未处理"><span class="color_f60"><?php echo intval($report); ?></span> 举报</a></li>

<li><a href="?sqlorder=7&iforder=1&menu=126&app=42&action=0" target="_blank" class="help_small" title="有 <?php echo intval($rights); ?> 维权未处理"><span class="color_f60"><?php echo intval($rights); ?></span> 维权</a></li>

<li><a href="?sqlorder=7&iforder=1&menu=129&app=49&action=1" target="_blank" class="help_small" title="有 <?php echo intval($taskrefund); ?> 任务退款未处理"><span class="color_f60"><?php echo intval($taskrefund); ?></span> 任务退款</a></li>

<li><a href="?sqlorder=7&iforder=1&menu=43&app=43&action=0" target="_blank" class="help_small" title="有 <?php echo intval($orderrefund); ?> 订单退款未处理"><span class="color_f60"><?php echo intval($orderrefund); ?></span> 订单退款</a></li>


<li><a href="?app=5&menu=10&page=0&opensearch=1&paytype=3&dateline1=<?php echo $newdate; ?>&SelectData=1" target="_blank" class="help_small" title="今日有 <?php echo intval($userpay); ?> 笔充值"><span class="color_f60"><?php echo intval($userpay); ?></span> 今日充值</a></li>

<li><a href="?app=45&menu=130&action=1" target="_blank" class="help_small" title="清空通知可以减少服务器的资源">清空通知</a></li>

</ul>

<ul>
<?php if ($this->IsSQL('apps',"WHERE class_phpapp='TaskCount'")){ ?>
<?php  $taskcheck=$this->IsSQL('task',"WHERE appid=80 AND process=3 "); ?>
<li>
<a href="?app=80&menu=113&action=&page=0&opensearch=1&subject=&tid=&oid=&uid=&username=&serviceuid=&process=3&dateline1=&dateline2=&endtime1=&endtime2=&SelectData=1" target="_blank" class="help_small" title="有 <?php echo intval($taskcheck); ?> 悬赏任务未审核 "><span class="color_f60"><?php echo intval($taskcheck); ?></span> 悬赏未审核</a>
</li>
<?php } ?>

<?php if ($this->IsSQL('apps',"WHERE class_phpapp='TaskGrab'")){ ?>
<?php  $taskcheck=$this->IsSQL('task',"WHERE appid=83 AND process=3 "); ?>
<li>
<a href="?app=83&menu=114&action=&page=0&opensearch=1&subject=&tid=&serial=&uid=&username=&serviceuid=&process=3&dateline1=&dateline2=&endtime1=&endtime2=&SelectData=1" target="_blank" class="help_small" title="有 <?php echo intval($taskcheck); ?> 招标任务未审核 "><span class="color_f60"><?php echo intval($taskcheck); ?></span> 招标未审核</a>
</li>
<?php } ?>


<?php if ($this->IsSQL('apps',"WHERE class_phpapp='TaskWeiJi'")){ ?>
<?php  $taskcheck=$this->IsSQL('task',"WHERE appid=78 AND process=3 "); ?>
<li>
<a href="?app=78&menu=114&action=&page=0&opensearch=1&subject=&tid=&serial=&uid=&username=&serviceuid=&process=3&dateline1=&dateline2=&endtime1=&endtime2=&SelectData=1" target="_blank" class="help_small" title="有 <?php echo intval($taskcheck); ?> 微计任务未审核 "><span class="color_f60"><?php echo intval($taskcheck); ?></span> 微计未审核</a>
</li>
<?php } ?>


<?php if ($this->IsSQL('apps',"WHERE class_phpapp='TaskWeiBo'")){ ?>
<?php  $taskcheck=$this->IsSQL('task',"WHERE appid=84 AND process=3 "); ?>
<li>
<a href="?app=84&menu=114&action=&page=0&opensearch=1&subject=&tid=&serial=&uid=&username=&serviceuid=&process=3&dateline1=&dateline2=&endtime1=&endtime2=&SelectData=1" target="_blank" class="help_small" title="有 <?php echo intval($taskcheck); ?> 微博任务未审核 "><span class="color_f60"><?php echo intval($taskcheck); ?></span> 微博未审核</a>
</li>
<?php } ?>


</ul>


</div>

</div>

<div class="authinfo">

<div class="authh2">&#x672C;&#x673A;&#x73AF;&#x5883;&#x4FE1;&#x606F;-&#x672C;&#x6E90;&#x7801;&#x6765;&#x81EA;&#x65B0;&#x777F;&#x793E;&#x533A;&#xFF01;</div>
<ul>
<p>PHPAPP版本 <?php echo PHPAPP::$config['phpappversion']; ?></p>

<p>PHP 版本 <?php echo $os; ?></p>

<p>MySQL 版本	<?php echo $mysqlarray[0]['version']; ?></p>

<p>服务器最大上传许可 <?php echo $fileupload; ?></p>

<p>当前数据库尺寸	<?php echo $Data_length; ?> MB</p>

<p>
register_globals 状态 
<?php if ((ini_get('register_globals'))){ ?>
    <span style="color:#F00; font-weight:bold">开启 (当您看到开启时为了程序运行安全请手动设置php.ini配置为关闭)</span>
<?php }else{ ?>
	关闭(正常)
<?php } ?>
</p>
</ul>
</div>