<?php if(!defined('IN_PHPAPP')){exit('Data error');} ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo S_CHARSET; ?>" />
<title>ϵͳ��ʾҳ��</title>

<?php if (!$istime){ ?>
<meta http-equiv="refresh" content="2;url=<?php echo $url; ?>">
<?php } ?>

<link href="<?php echo TURL; ?>refresh.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div class="showmsg">

<h2>ϵͳ��ʾ</h2>

<ul><p><?php echo $msg; ?><p></ul>

<?php if (!$istime){ ?>
<div class="opmenu"><a href="<?php echo $url; ?>">�ֶ���ת</a> | <a href="<?php echo SURL; ?>">������ҳ</a></div>
<?php } ?>

</div>
<div class="footer"><p>&copy; <?php echo $this->Date("Y",$this->NowTime()); ?> <?php echo PHPAPP::$config['sitename']; ?> ��Ȩ����</p></div>

</body>

</html>