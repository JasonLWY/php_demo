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



<form action="<?php echo $this->MakeGetParameterURL(); ?>" method="post">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist">
<tr>
<td class="datalist_h2">
ģ������
</td>
<td class="datalist_h2">
Ԥ��ͼ
</td>
<td class="datalist_h2">
ģ����·��/��ʽ���·��
</td>
<td class="datalist_h2">
ģ����ʽ
</td>
</tr> 

<?php foreach ($templatearr as $value){ ?>
    <?php if ($value['filename']!='index.html' && $value['filename']!='index.htm'){ ?>
        <tr>
        <td class="width_160"><input name="S_TEMPLATE_s" type="radio" value="<?php echo $value['filename']; ?>"<?php if ($value['filename']==S_TEMPLATE){ ?>  checked="checked"<?php } ?>/> <?php echo $value['filename']; ?> ģ��</td>
        <td>
         <img name="<?php echo $value['filename']; ?>" src="<?php echo SURL; ?>/phpapp/templates/<?php echo $value['filename']; ?>/preview.png" />
        </td>
         <td>
         <p>/phpapp/templates/<?php echo $value['filename']; ?>/<?php echo PHPAPP::$config['templatepath']; ?>/</p>
         <p>/phpapp/templates/<?php echo $value['filename']; ?>/style/<?php echo PHPAPP::$config['stylepath']; ?>/</p>
        </td>
        <td>
        <?php  $templatestylearr=$this->ReadSysDir(SYS.'/templates/'.$value['filename'].'/style');  ?>
            <select name="stylepath_s" class="form_input_text">
                  <?php foreach ($templatestylearr as $style){ ?>
                        <?php if ($value['filename']!='index.html' && $value['filename']!='index.htm'){ ?>
                        		<option value="<?php echo $style['filename']; ?>"<?php if ($style['filename']==PHPAPP::$config['stylepath']){ ?> selected="selected"<?php } ?>><?php echo $style['filename']; ?></option>
                        <?php } ?>
                  <?php } ?> 
            </select>
        </td>
        </tr> 
    <?php } ?>
<?php } ?> 

<tr>
<td>
վ��ģ����·�� ��
</td>
<td>
<input name="templatepath_s" value="<?php echo PHPAPP::$config['templatepath']; ?>" type="text" class="form_input_text form_input_width_100" />  (�������Է�ֹģ��ֱ�ӱ�����)
</td>
<td>
վ��ģ�������� ��<input name="siteframewidth_d" value="<?php echo PHPAPP::$config['siteframewidth']; ?>" type="text" class="form_input_text form_input_width_100" /> PX 
</td>
<td class="color_999">�޸���������Щҳ�滹��Ҫ�ֶ�����</td>
</tr> 

</table>

<p class="color_999" style="padding-top:10px;">��ʾ���޸� <strong>ģ����·��</strong> ��ͬʱ��Ҫ�ֶ���FTP��¼,�޸�ģ���� <strong><?php echo PHPAPP::$config['templatepath']; ?></strong>  Ŀ¼����Ϊ���ڵ� ģ����·��.</td>
</p> 

<div class="phpapp_button"><input name="Submit" type="submit" value="ʹ��" class="form_button"/></div>
    
</form>