<?php if(!defined('IN_PHPAPP')){exit('Data error');} ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo S_CHARSET; ?>" />
<title>PHPAPP��̨����</title>
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
    
<div id="loading" style="display:none" title="��ȡ������..."></div>

<div class="manage_menu"><ul><?php echo $this->actionmenu; ?></ul></div>

<script type="text/javascript">
function NowLogin(){
	 return USERID;
}

function SubmitContent(){
	
	$.SaveContent();	
	
	var content=$("#Content");
	if (content.val()==""){
		  alert("����������!");
		  content.focus();
		  return false; 
	}
}
</script>




<div class="authinfo">

<div class="authh2">ϵͳ��ʾ </div>

<div  class="site_remind">
<ul>

<li><a href="?app=5&menu=10&action=3" target="_blank" class="help_small" title="�� <?php echo intval($deposit); ?> ������δ����"><span class="color_f60"><?php echo intval($deposit); ?></span> ����������</a></li>

<li><a href="?sqlorder=7&iforder=1&menu=102&app=15&action=0" target="_blank" class="help_small" title="�� <?php echo intval($personalcertificate); ?> ����Ա��֤��"><span class="color_f60"><?php echo intval($personalcertificate); ?></span> ��Ա��֤��</a></li>

<li><a href="?sqlorder=7&iforder=1&menu=103&app=16&action=0" target="_blank" class="help_small" title="�� <?php echo intval($companycertificate); ?> ����ҵ��֤��"><span class="color_f60"><?php echo intval($companycertificate); ?></span> ��ҵ��֤��</a></li>

<li><a href="?sqlorder=4&iforder=1&app=21&menu=45&action=7" target="_blank" class="help_small" title="�� <?php echo intval($mobilecertificate); ?> �ֻ���֤��"><span class="color_f60"><?php echo intval($mobilecertificate); ?></span> �ֻ���֤��</a></li>

<li><a href="?sqlorder=4&iforder=1&menu=133&app=14&action=0" target="_blank" class="help_small" title="�� <?php echo intval($mailcertificate); ?> ������֤��"><span class="color_f60"><?php echo intval($mailcertificate); ?></span> ������֤��</a></li>

</ul>

<ul>
<li><a href="?sqlorder=7&iforder=1&menu=44&app=47&action=0" target="_blank" class="help_small" title="�� <?php echo intval($mailcertificate); ?> �ٱ�δ����"><span class="color_f60"><?php echo intval($report); ?></span> �ٱ�</a></li>

<li><a href="?sqlorder=7&iforder=1&menu=126&app=42&action=0" target="_blank" class="help_small" title="�� <?php echo intval($rights); ?> άȨδ����"><span class="color_f60"><?php echo intval($rights); ?></span> άȨ</a></li>

<li><a href="?sqlorder=7&iforder=1&menu=129&app=49&action=1" target="_blank" class="help_small" title="�� <?php echo intval($taskrefund); ?> �����˿�δ����"><span class="color_f60"><?php echo intval($taskrefund); ?></span> �����˿�</a></li>

<li><a href="?sqlorder=7&iforder=1&menu=43&app=43&action=0" target="_blank" class="help_small" title="�� <?php echo intval($orderrefund); ?> �����˿�δ����"><span class="color_f60"><?php echo intval($orderrefund); ?></span> �����˿�</a></li>


<li><a href="?app=5&menu=10&page=0&opensearch=1&paytype=3&dateline1=<?php echo $newdate; ?>&SelectData=1" target="_blank" class="help_small" title="������ <?php echo intval($userpay); ?> �ʳ�ֵ"><span class="color_f60"><?php echo intval($userpay); ?></span> ���ճ�ֵ</a></li>

<li><a href="?app=45&menu=130&action=1" target="_blank" class="help_small" title="���֪ͨ���Լ��ٷ���������Դ">���֪ͨ</a></li>

</ul>

<ul>
<?php if ($this->IsSQL('apps',"WHERE class_phpapp='TaskCount'")){ ?>
<?php  $taskcheck=$this->IsSQL('task',"WHERE appid=80 AND process=3 "); ?>
<li>
<a href="?app=80&menu=113&action=&page=0&opensearch=1&subject=&tid=&oid=&uid=&username=&serviceuid=&process=3&dateline1=&dateline2=&endtime1=&endtime2=&SelectData=1" target="_blank" class="help_small" title="�� <?php echo intval($taskcheck); ?> ��������δ��� "><span class="color_f60"><?php echo intval($taskcheck); ?></span> ����δ���</a>
</li>
<?php } ?>

<?php if ($this->IsSQL('apps',"WHERE class_phpapp='TaskGrab'")){ ?>
<?php  $taskcheck=$this->IsSQL('task',"WHERE appid=83 AND process=3 "); ?>
<li>
<a href="?app=83&menu=114&action=&page=0&opensearch=1&subject=&tid=&serial=&uid=&username=&serviceuid=&process=3&dateline1=&dateline2=&endtime1=&endtime2=&SelectData=1" target="_blank" class="help_small" title="�� <?php echo intval($taskcheck); ?> �б�����δ��� "><span class="color_f60"><?php echo intval($taskcheck); ?></span> �б�δ���</a>
</li>
<?php } ?>


<?php if ($this->IsSQL('apps',"WHERE class_phpapp='TaskWeiJi'")){ ?>
<?php  $taskcheck=$this->IsSQL('task',"WHERE appid=78 AND process=3 "); ?>
<li>
<a href="?app=78&menu=114&action=&page=0&opensearch=1&subject=&tid=&serial=&uid=&username=&serviceuid=&process=3&dateline1=&dateline2=&endtime1=&endtime2=&SelectData=1" target="_blank" class="help_small" title="�� <?php echo intval($taskcheck); ?> ΢������δ��� "><span class="color_f60"><?php echo intval($taskcheck); ?></span> ΢��δ���</a>
</li>
<?php } ?>


<?php if ($this->IsSQL('apps',"WHERE class_phpapp='TaskWeiBo'")){ ?>
<?php  $taskcheck=$this->IsSQL('task',"WHERE appid=84 AND process=3 "); ?>
<li>
<a href="?app=84&menu=114&action=&page=0&opensearch=1&subject=&tid=&serial=&uid=&username=&serviceuid=&process=3&dateline1=&dateline2=&endtime1=&endtime2=&SelectData=1" target="_blank" class="help_small" title="�� <?php echo intval($taskcheck); ?> ΢������δ��� "><span class="color_f60"><?php echo intval($taskcheck); ?></span> ΢��δ���</a>
</li>
<?php } ?>


</ul>


</div>

</div>

<div class="authinfo">

<div class="authh2">&#x672C;&#x673A;&#x73AF;&#x5883;&#x4FE1;&#x606F;-&#x672C;&#x6E90;&#x7801;&#x6765;&#x81EA;&#x65B0;&#x777F;&#x793E;&#x533A;&#xFF01;</div>
<ul>
<p>PHPAPP�汾 <?php echo PHPAPP::$config['phpappversion']; ?></p>

<p>PHP �汾 <?php echo $os; ?></p>

<p>MySQL �汾	<?php echo $mysqlarray[0]['version']; ?></p>

<p>����������ϴ���� <?php echo $fileupload; ?></p>

<p>��ǰ���ݿ�ߴ�	<?php echo $Data_length; ?> MB</p>

<p>
register_globals ״̬ 
<?php if ((ini_get('register_globals'))){ ?>
    <span style="color:#F00; font-weight:bold">���� (������������ʱΪ�˳������а�ȫ���ֶ�����php.ini����Ϊ�ر�)</span>
<?php }else{ ?>
	�ر�(����)
<?php } ?>
</p>
</ul>
</div>