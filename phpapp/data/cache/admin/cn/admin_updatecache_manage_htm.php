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

<div id="UpdateCache<?php echo $this->GET['menu']; ?>1">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist">
  <tr>
    <td class="datalist_h2" style="width:46px"><input type="checkbox" name="checkboxall"  value="1"  onclick="CheckboxAll('UpdateCache<?php echo $this->GET['menu']; ?>1')"/> ȫѡ</td>
    <td class="datalist_h2" colspan="3">����ϵͳ��Ŀ</td>
  </tr>
  
  <tr>
    <td><input name="checkbox[]" type="checkbox" value="1" checked="checked"/></td>
    <td style="width:40%">����ϵͳ���� <span style="color:#999">(���ݱ� <?php echo DB_TNAME; ?>config)</span></td>

    <td><input name="checkbox[]" type="checkbox" value="3" checked="checked"/></td>
    <td>����Ӧ������ <span style="color:#999">(���ݱ� <?php echo DB_TNAME; ?>apps)</span></td>
  </tr>
 
   <tr>
    <td><input name="checkbox[]" type="checkbox" value="4" checked="checked"/></td>
    <td>����Ӧ�ö������� <span style="color:#999">(���ݱ� <?php echo DB_TNAME; ?>apps_action)</span></td>

    <td><input name="checkbox[]" type="checkbox" value="7" checked="checked"/></td>
    <td>����ģ�建�� <span style="color:#999">(HTMLģ�建��)</span></td>
  </tr> 
  
  <tr>
    <td><input name="checkbox[]" type="checkbox" value="8" checked="checked"/></td>
    <td>���º�̨�˵����� <span style="color:#999">(��̨�˵�����)</span></td>
    <td><input name="checkbox[]" type="checkbox" value="11" checked="checked"/></td>
    <td>����ǰ̨�˵����� <span style="color:#999">(���ݱ� <?php echo DB_TNAME; ?>nav)</span></td>
  </tr>

   <tr>
    <td><input name="checkbox[]" type="checkbox" value="5"/></td>
    <td>���¸���ͼ������ <span style="color:#999">(���ݱ� <?php echo DB_TNAME; ?>file_icon)</span></td>
    <td><input name="checkbox[]" type="checkbox" value="9"/></td>
    <td>�����û�ͷ�α�־ <span style="color:#999">(���ݱ� <?php echo DB_TNAME; ?>member_level)</span></td>
  </tr>
  
  <tr>
    <td><input name="checkbox[]" type="checkbox" value="10"/></td>
    <td>�����û����ñ�־ <span style="color:#999">(���ݱ� <?php echo DB_TNAME; ?>credit_level)</span></td>
    <td><input name="checkbox[]" type="checkbox" value="12"/></td>
    <td>�������ݱ���</td>
  </tr>
  
  <tr>
    <td><input name="checkbox[]" type="checkbox" value="6"/></td>
    <td>����memcache���� <span style="color:#999">(����memcache���ò��ܸ���)</span></td>
    <td><input name="checkbox[]" type="checkbox" value="2"/></td>
    <td>�������Ի����ļ�</td>
  </tr>  
</table>
</div>  

<div id="UpdateCache<?php echo $this->GET['menu']; ?>2">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist">
  <tr>
    <td class="datalist_h2" style="width:46px"><input type="checkbox" name="checkboxall"  value="1"  onclick="CheckboxAll('UpdateCache<?php echo $this->GET['menu']; ?>2')"/> ȫѡ</td>
    <td class="datalist_h2" colspan="3">���·�����Ŀ</td>
  </tr>
  
  <tr>
    <td style="width:46px"><input name="checkbox[]" type="checkbox" value="13"/></td>
    <td style="width:40%">���·��໺�� <span style="color:#999">(���´�Լ3��~1����)</span></td>
    <td style="width:46px"><input name="checkbox[]" type="checkbox" value="14"/></td>
    <td>����˵��б� <span style="color:#999">(���µ����ķ��൯���б�)</span></td>
  </tr>
  
   <tr>
    <td style="width:46px"><input name="checkbox[]" type="checkbox" value="15"/></td>
    <td>���¼��ܻ��� <span style="color:#999">(�û�ʹ�õļ��ܻ���)</span></td>
    <td style="width:46px"><input name="checkbox[]" type="checkbox" value="16"/></td>
    <td>���е������໺�� <span style="color:#F00">(���´�Լ3~10����)</span></td>
  </tr>
</table>
</div>  

<div id="UpdateCache<?php echo $this->GET['menu']; ?>3">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist"> 
  <tr>
    <td class="datalist_h2" style="width:46px"><input type="checkbox" name="checkboxall"  value="1"  onclick="CheckboxAll('UpdateCache<?php echo $this->GET['menu']; ?>3')"/> ȫѡ</td>
    <td class="datalist_h2" colspan="3">����URL��Ŀ</td>
  </tr>
  
  <tr>
    <td style="width:46px"><input name="checkbox[]" type="checkbox" value="17"/></td>
    <td style="width:40%">��������URL <span style="color:#999">(���´�Լ3������)</span></td>
    <td style="width:46px"><input name="checkbox[]" type="checkbox" value="18"/></td>
    <td>���·���URL <span style="color:#999">(���´�Լ3������)</span></td>
  </tr>
   
</table>
</div>
<p style="padding:10px;">��ʾ��<strong>���·���</strong> ������ӸĶ�����ʱ����Ҫ������,<strong>����URL</strong> ������Ӹı�Ӧ�úͶ�����α��̬��ַʱ����Ҫ������.</p>
<div class="phpapp_button"><input name="Submit" type="submit" value="���»���" class="form_button"/></div>

</form>
