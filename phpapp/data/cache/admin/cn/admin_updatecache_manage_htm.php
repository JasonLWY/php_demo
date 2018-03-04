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




<form action="<?php echo $this->MakeGetParameterURL(); ?>" method="post">

<div id="UpdateCache<?php echo $this->GET['menu']; ?>1">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist">
  <tr>
    <td class="datalist_h2" style="width:46px"><input type="checkbox" name="checkboxall"  value="1"  onclick="CheckboxAll('UpdateCache<?php echo $this->GET['menu']; ?>1')"/> 全选</td>
    <td class="datalist_h2" colspan="3">更新系统项目</td>
  </tr>
  
  <tr>
    <td><input name="checkbox[]" type="checkbox" value="1" checked="checked"/></td>
    <td style="width:40%">更新系统配置 <span style="color:#999">(数据表 <?php echo DB_TNAME; ?>config)</span></td>

    <td><input name="checkbox[]" type="checkbox" value="3" checked="checked"/></td>
    <td>更新应用数据 <span style="color:#999">(数据表 <?php echo DB_TNAME; ?>apps)</span></td>
  </tr>
 
   <tr>
    <td><input name="checkbox[]" type="checkbox" value="4" checked="checked"/></td>
    <td>更新应用动作数据 <span style="color:#999">(数据表 <?php echo DB_TNAME; ?>apps_action)</span></td>

    <td><input name="checkbox[]" type="checkbox" value="7" checked="checked"/></td>
    <td>更新模板缓存 <span style="color:#999">(HTML模板缓存)</span></td>
  </tr> 
  
  <tr>
    <td><input name="checkbox[]" type="checkbox" value="8" checked="checked"/></td>
    <td>更新后台菜单缓存 <span style="color:#999">(后台菜单缓存)</span></td>
    <td><input name="checkbox[]" type="checkbox" value="11" checked="checked"/></td>
    <td>更新前台菜单缓存 <span style="color:#999">(数据表 <?php echo DB_TNAME; ?>nav)</span></td>
  </tr>

   <tr>
    <td><input name="checkbox[]" type="checkbox" value="5"/></td>
    <td>更新附件图标配置 <span style="color:#999">(数据表 <?php echo DB_TNAME; ?>file_icon)</span></td>
    <td><input name="checkbox[]" type="checkbox" value="9"/></td>
    <td>更新用户头衔标志 <span style="color:#999">(数据表 <?php echo DB_TNAME; ?>member_level)</span></td>
  </tr>
  
  <tr>
    <td><input name="checkbox[]" type="checkbox" value="10"/></td>
    <td>更新用户信用标志 <span style="color:#999">(数据表 <?php echo DB_TNAME; ?>credit_level)</span></td>
    <td><input name="checkbox[]" type="checkbox" value="12"/></td>
    <td>更新数据表缓存</td>
  </tr>
  
  <tr>
    <td><input name="checkbox[]" type="checkbox" value="6"/></td>
    <td>更新memcache缓存 <span style="color:#999">(设置memcache启用才能更新)</span></td>
    <td><input name="checkbox[]" type="checkbox" value="2"/></td>
    <td>更新语言缓存文件</td>
  </tr>  
</table>
</div>  

<div id="UpdateCache<?php echo $this->GET['menu']; ?>2">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist">
  <tr>
    <td class="datalist_h2" style="width:46px"><input type="checkbox" name="checkboxall"  value="1"  onclick="CheckboxAll('UpdateCache<?php echo $this->GET['menu']; ?>2')"/> 全选</td>
    <td class="datalist_h2" colspan="3">更新分类项目</td>
  </tr>
  
  <tr>
    <td style="width:46px"><input name="checkbox[]" type="checkbox" value="13"/></td>
    <td style="width:40%">更新分类缓存 <span style="color:#999">(更新大约3秒~1分钟)</span></td>
    <td style="width:46px"><input name="checkbox[]" type="checkbox" value="14"/></td>
    <td>分类菜单列表 <span style="color:#999">(更新导航的分类弹出列表)</span></td>
  </tr>
  
   <tr>
    <td style="width:46px"><input name="checkbox[]" type="checkbox" value="15"/></td>
    <td>更新技能缓存 <span style="color:#999">(用户使用的技能缓存)</span></td>
    <td style="width:46px"><input name="checkbox[]" type="checkbox" value="16"/></td>
    <td>城市地区分类缓存 <span style="color:#F00">(更新大约3~10分钟)</span></td>
  </tr>
</table>
</div>  

<div id="UpdateCache<?php echo $this->GET['menu']; ?>3">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist"> 
  <tr>
    <td class="datalist_h2" style="width:46px"><input type="checkbox" name="checkboxall"  value="1"  onclick="CheckboxAll('UpdateCache<?php echo $this->GET['menu']; ?>3')"/> 全选</td>
    <td class="datalist_h2" colspan="3">更新URL项目</td>
  </tr>
  
  <tr>
    <td style="width:46px"><input name="checkbox[]" type="checkbox" value="17"/></td>
    <td style="width:40%">更新任务URL <span style="color:#999">(更新大约3秒以上)</span></td>
    <td style="width:46px"><input name="checkbox[]" type="checkbox" value="18"/></td>
    <td>更新服务URL <span style="color:#999">(更新大约3秒以上)</span></td>
  </tr>
   
</table>
</div>
<p style="padding:10px;">提示：<strong>更新分类</strong> 当您添加改动分类时才需要更新它,<strong>更新URL</strong> 当您添加改变应用和动作的伪静态地址时才需要更新它.</p>
<div class="phpapp_button"><input name="Submit" type="submit" value="更新缓存" class="form_button"/></div>

</form>
