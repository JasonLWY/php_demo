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

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist">
<?php if ($this->GET['op']==3){ ?>

<tr>
<td class="width_160">会员注册成功是否发通知:</td>
<td>
<div id="RadioRegisteredNotice">
<input id="RadioRegisteredNotice1" class="radio" type="radio" name="registerednotice_d" value="0"  <?php if (PHPAPP::$config['registerednotice']==0){ ?>checked<?php } ?>><label for="RadioRegisteredNotice1">否</label> <input id="RadioRegisteredNotice2" type="radio" name="registerednotice_d" value="1" <?php if (PHPAPP::$config['registerednotice']==1){ ?>checked<?php } ?>><label for="RadioRegisteredNotice2">是</label>
</div>
</td>
</tr>

<tr>
<td class="width_160">通知标题:</td>
<td><input name="registerednoticesubject_s" value="<?php echo PHPAPP::$config['registerednoticesubject']; ?>" type="text" class="form_input_text form_input_width_200" /> （可用用户名标签 {<?php echo username; ?>}）</td>
</tr>

<tr>
<td class="width_160">通知内容:</td>
<td>
<textarea name="registerednoticecontent_s" class="form_editor" style="width:600px;height:300px;"><?php echo PHPAPP::$config['registerednoticecontent']; ?></textarea>
</td>
</tr>
<?php }elseif($this->GET['op']==2){ ?>
<tr>
<td>
<!-- 
	phpapp.cn (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.  2011.10.15
-->


<link href="<?php echo TURL; ?>editor.css" rel="stylesheet" type="text/css" />

<div id="UploadMusic"></div>

<div id="UploadPhoto"></div>

<div id="UploadFile"></div>

<div id="phpapp_editor">

<ul>

   <li class="phpappeditorfonts">
   <a href="javascript:;" title="字体类型" id="EditorFonts" onclick="$.PHPAPPButton('#ShowEditorFonts')">
   </a>
   
   <div id="ShowEditorFonts" class="showeditor" style="display:none">
        <a href="javascript:;" onClick="$.SetEditor('FontName','宋体');">宋体</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','黑体');">黑体</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','楷体_GB2312');">楷体_GB2312</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','隶书');">隶书</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','幼圆');">幼圆</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','Arial');">Arial</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','Arial Narrow');">Arial Narrow</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','Arial Black');">Arial Black</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','Comic Sans MS');">Comic Sans MS</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','Courier');">Courier</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','System');">System</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','Times New Roman');">Times New Roman</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','Verdana');">Verdana</a>
   </div>

   </li>
   
   <li class="phpappeditorfontsize">
   <a href="javascript:;" id="EditorFontSize" title="字体大小" onclick="$.PHPAPPButton('#ShowEditorFontSize')">
   </a>
   
   <div id="ShowEditorFontSize" class="showeditor" style="display:none">
        <a href="javascript:;" onClick="$.SetEditor('fontsize',1);"><span style="font-size:10px">1</span></a>
        <a href="javascript:;" onClick="$.SetEditor('fontsize',2);"><span style="font-size:12px">2</span></a>
        <a href="javascript:;" onClick="$.SetEditor('fontsize',3);"><span style="font-size:14px">3</span></a>
        <a href="javascript:;" onClick="$.SetEditor('fontsize',4);" style="height:18px;"><span style="font-size:18px;line-height:18px;">4</span></a>
        <a href="javascript:;" onClick="$.SetEditor('fontsize',5);" style="height:24px;"><span style="font-size:24px;line-height:24px;">5</span></a>
        <a href="javascript:;" onClick="$.SetEditor('fontsize',6);" style="height:36px;"><span style="font-size:36px;line-height:36px;">6</span></a>
        <a href="javascript:;" onClick="$.SetEditor('fontsize',7);" style="height:48px;"><span style="font-size:48px;line-height:48px;">7</span></a>
   </div>
   </li>
   
   <li class="phpappeditortext_Bold">
   <a href="javascript:;" onClick="$.SetEditor('Bold','Bold');" title="粗体"></a>
   </li>
   
   <li class="phpappeditortext_Italic">
   <a href="javascript:;" onClick="$.SetEditor('Italic','Italic');" title="斜体"></a>
   </li>
   
   <li class="phpappeditortext_Underline">
   <a href="javascript:;" onClick="$.SetEditor('Underline','Underline');" title="下划线"></a>
   </li>
   
   <li class="phpappeditortext_ForeColor">
   <a href="javascript:;" title="文字颜色" onclick="$.PHPAPPButton('#ShowEditorForeColor')"></a>
   
   <div id="ShowEditorForeColor" class="showeditor" style="display:none">
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffffff');" style="background-color:#ffffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#cccccc');" style="background-color:#cccccc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#c0c0c0');" style="background-color:#c0c0c0"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#999999');" style="background-color:#999999"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#666666');" style="background-color:#666666"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#333333');" style="background-color:#333333"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#000000');" style="background-color:#000000"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffcccc');" style="background-color:#ffcccc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ff6666');" style="background-color:#ff6666"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ff0000');" style="background-color:#ff0000"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#cc0000');" style="background-color:#cc0000"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#990000');" style="background-color:#990000"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#660000');" style="background-color:#660000"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#330000');" style="background-color:#330000"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffcc99');" style="background-color:#ffcc99"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ff9966');" style="background-color:#ff9966"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ff9900');" style="background-color:#ff9900"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ff6600');" style="background-color:#ff6600"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#cc6600');" style="background-color:#cc6600"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#993300');" style="background-color:#993300"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#663300');" style="background-color:#663300"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffff99');" style="background-color:#ffff99"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffff66');" style="background-color:#ffff66"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffcc66');" style="background-color:#ffcc66"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffcc33');" style="background-color:#ffcc33"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#cc9933');" style="background-color:#cc9933"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#996633');" style="background-color:#996633"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#663333');" style="background-color:#663333"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffffcc');" style="background-color:#ffffcc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffff33');" style="background-color:#ffff33"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffff00');" style="background-color:#ffff00"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffcc00');" style="background-color:#ffcc00"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#999900');" style="background-color:#999900"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#666600');" style="background-color:#666600"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#333300');" style="background-color:#333300"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#99ff99');" style="background-color:#99ff99"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#66ff99');" style="background-color:#66ff99"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#33ff33');" style="background-color:#33ff33"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#33cc00');" style="background-color:#33cc00"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#009900');" style="background-color:#009900"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#006600');" style="background-color:#006600"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#003300');" style="background-color:#003300"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#99ffff');" style="background-color:#99ffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#33ffff');" style="background-color:#33ffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#66cccc');" style="background-color:#66cccc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#00cccc');" style="background-color:#00cccc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#339999');" style="background-color:#339999"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#336666');" style="background-color:#336666"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#003333');" style="background-color:#003333"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ccffff');" style="background-color:#ccffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#66ffff');" style="background-color:#66ffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#33ccff');" style="background-color:#33ccff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#3366ff');" style="background-color:#3366ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#3333ff');" style="background-color:#3333ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#000099');" style="background-color:#000099"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#000066');" style="background-color:#000066"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ccccff');" style="background-color:#ccccff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#9999ff');" style="background-color:#9999ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#6666cc');" style="background-color:#6666cc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#6633ff');" style="background-color:#6633ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#6600cc');" style="background-color:#6600cc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#333399');" style="background-color:#333399"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#330099');" style="background-color:#330099"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffccff');" style="background-color:#ffccff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ff99ff');" style="background-color:#ff99ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#cc66cc');" style="background-color:#cc66cc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#cc33cc');" style="background-color:#cc33cc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#993399');" style="background-color:#993399"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#663366');" style="background-color:#663366"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#330033');" style="background-color:#330033"></a>
   </div>
   
   
   
   
   </li>
   
   <li class="phpappeditortext_BackgroundColor" style="margin-right:8px;">
   <a href="javascript:;" title="文字背景色" onclick="$.PHPAPPButton('#ShowBackgroundColor')"></a>
   
   <div id="ShowBackgroundColor" class="showeditor" style="display:none">
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffffff');" style="background-color:#ffffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#cccccc');" style="background-color:#cccccc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#c0c0c0');" style="background-color:#c0c0c0"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#999999');" style="background-color:#999999"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#666666');" style="background-color:#666666"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#333333');" style="background-color:#333333"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#000000');" style="background-color:#000000"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffcccc');" style="background-color:#ffcccc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ff6666');" style="background-color:#ff6666"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ff0000');" style="background-color:#ff0000"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#cc0000');" style="background-color:#cc0000"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#990000');" style="background-color:#990000"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#660000');" style="background-color:#660000"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#330000');" style="background-color:#330000"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffcc99');" style="background-color:#ffcc99"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ff9966');" style="background-color:#ff9966"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ff9900');" style="background-color:#ff9900"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ff6600');" style="background-color:#ff6600"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#cc6600');" style="background-color:#cc6600"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#993300');" style="background-color:#993300"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#663300');" style="background-color:#663300"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffff99');" style="background-color:#ffff99"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffff66');" style="background-color:#ffff66"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffcc66');" style="background-color:#ffcc66"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffcc33');" style="background-color:#ffcc33"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#cc9933');" style="background-color:#cc9933"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#996633');" style="background-color:#996633"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#663333');" style="background-color:#663333"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffffcc');" style="background-color:#ffffcc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffff33');" style="background-color:#ffff33"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffff00');" style="background-color:#ffff00"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffcc00');" style="background-color:#ffcc00"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#999900');" style="background-color:#999900"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#666600');" style="background-color:#666600"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#333300');" style="background-color:#333300"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#99ff99');" style="background-color:#99ff99"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#66ff99');" style="background-color:#66ff99"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#33ff33');" style="background-color:#33ff33"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#33cc00');" style="background-color:#33cc00"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#009900');" style="background-color:#009900"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#006600');" style="background-color:#006600"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#003300');" style="background-color:#003300"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#99ffff');" style="background-color:#99ffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#33ffff');" style="background-color:#33ffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#66cccc');" style="background-color:#66cccc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#00cccc');" style="background-color:#00cccc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#339999');" style="background-color:#339999"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#336666');" style="background-color:#336666"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#003333');" style="background-color:#003333"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ccffff');" style="background-color:#ccffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#66ffff');" style="background-color:#66ffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#33ccff');" style="background-color:#33ccff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#3366ff');" style="background-color:#3366ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#3333ff');" style="background-color:#3333ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#000099');" style="background-color:#000099"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#000066');" style="background-color:#000066"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ccccff');" style="background-color:#ccccff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#9999ff');" style="background-color:#9999ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#6666cc');" style="background-color:#6666cc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#6633ff');" style="background-color:#6633ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#6600cc');" style="background-color:#6600cc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#333399');" style="background-color:#333399"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#330099');" style="background-color:#330099"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffccff');" style="background-color:#ffccff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ff99ff');" style="background-color:#ff99ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#cc66cc');" style="background-color:#cc66cc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#cc33cc');" style="background-color:#cc33cc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#993399');" style="background-color:#993399"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#663366');" style="background-color:#663366"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#330033');" style="background-color:#330033"></a>
   </div>
   
   </li>
   
   
   <li class="phpappeditortext_JustifyLeft">
   <a href="javascript:;" onClick="$.SetEditor('JustifyLeft','JustifyLeft');" title="左对齐"></a>
   </li>
   
   <li class="phpappeditortext_JustifyCenter">
   <a href="javascript:;" onClick="$.SetEditor('JustifyCenter','JustifyCenter');" title="居中对齐"></a>
   </li>
   
   <li class="phpappeditortext_JustifyRight" style="margin-right:8px;">
   <a href="javascript:;" onClick="$.SetEditor('JustifyRight','JustifyRight');" title="右对齐"></a>
   </li>
   
   <li class="phpappeditortext_AddLink">
   <a href="javascript:;" title="添加超链接" onclick="$.PHPAPPButton('#ShowEditorAddLink');$.IframeSelectionSave('AddLink');"></a>
   
   <div id="ShowEditorAddLink" style="display:none" class="showeditor tablecss" style="width:210px;">
        <h6><dfn><a href="javascript:;" title="关闭链接" onclick="$.CloseID('#ShowEditorAddLink')"></a></dfn>添加链接</h6>
        <div id="LinkURLName" style="display:none">
        <span>请输入链接文字</span>
        <p><input id="addlinkname" type="text" class="form_input_text form_input_width_200"  value=""/></p>
        </div>
        <span>请输入链接地址</span>
        <p><input id="addlinkurl" type="text" class="form_input_text form_input_width_200"  value="http://"/></p>
        <p><input id="addlinkwindow" type="checkbox" value="1" checked />是否新窗口打开</p>
        <p><input type="button" value="确定" class="small blue awesome" onclick="$.SetEditor('AddLink','AddLink');"/> <input type="button" value="取消" class="small orange awesome" onclick="$.CloseID('#ShowEditorAddLink')"/></p>
   </div>
   
   </li>
   
   <li class="phpappeditortext_Unlink">
   <a href="javascript:;" onClick="$.SetEditor('Unlink','Unlink');" title="删除超链接"></a>
   </li>
   
   <li class="phpappeditortext_RemoveFormat">
   <a href="javascript:;" onClick="$.SetEditor('RemoveFormat','RemoveFormat');" title="删除文字格式"></a>
   </li>
   
   <li class="phpappeditortext_AddTable" style="margin-right:8px;">
   <a href="javascript:;" title="插入表格" onclick="$.IframeSelectionSave();$.PHPAPPButton('#ShowEditorAddTable');"></a>
   
   <div id="ShowEditorAddTable" style="display:none" class="showeditor tablecss">
        <h6><dfn><a href="javascript:;" title="关闭插入表格" onclick="$.CloseID('#ShowEditorAddTable')"></a></dfn>插入表格</h6>
        <p>表格行数 <input type="text" id="addtablelines" class="form_input_text form_input_width_150"  value="3" maxlength="6"/> 行</p>
        <p>表格列数 <input type="text" id="addtablerows" class="form_input_text form_input_width_150"  value="3" maxlength="6"/> 列</p>
        <p>表格宽度 <input type="text" id="addtablewidth" class="form_input_text form_input_width_150"  value="300" maxlength="6"/> px</p>
        <p><input type="button" value="确定" class="small blue awesome" onclick="$.AddTableYes()"/> <input type="button" value="取消" class="small orange awesome" onclick="$.CloseID('#ShowEditorAddTable')"/></p>
    </div>

   </li>
   
   <li class="phpappeditortext_Smiley">
   <a href="javascript:;" title="插入表情" onclick="$.IframeSelectionSave();$.PHPAPPButton('#ShowEditorSmiley');"></a>

    <div id="ShowEditorSmiley" style="display:none" class="showeditor tablecss">
        <h6><dfn><a href="javascript:;" title="关闭表情" onclick="$.CloseID('#ShowEditorSmiley')"></a></dfn>添加表情</h6>
        
        <a href="javascript:;" onClick="$.SetEditor('Smiley','1');"><img src="<?php echo SURL; ?>/images/smiley/comcom/1.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','2');"><img src="<?php echo SURL; ?>/images/smiley/comcom/2.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','3');"><img src="<?php echo SURL; ?>/images/smiley/comcom/3.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','4');"><img src="<?php echo SURL; ?>/images/smiley/comcom/4.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','5');"><img src="<?php echo SURL; ?>/images/smiley/comcom/5.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','6');"><img src="<?php echo SURL; ?>/images/smiley/comcom/6.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','7');"><img src="<?php echo SURL; ?>/images/smiley/comcom/7.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','8');"><img src="<?php echo SURL; ?>/images/smiley/comcom/8.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','9');"><img src="<?php echo SURL; ?>/images/smiley/comcom/9.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','10');"><img src="<?php echo SURL; ?>/images/smiley/comcom/10.gif" /></a>
        
        <a href="javascript:;" onClick="$.SetEditor('Smiley','11');"><img src="<?php echo SURL; ?>/images/smiley/comcom/11.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','12');"><img src="<?php echo SURL; ?>/images/smiley/comcom/12.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','13');"><img src="<?php echo SURL; ?>/images/smiley/comcom/13.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','14');"><img src="<?php echo SURL; ?>/images/smiley/comcom/14.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','15');"><img src="<?php echo SURL; ?>/images/smiley/comcom/15.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','16');"><img src="<?php echo SURL; ?>/images/smiley/comcom/16.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','17');"><img src="<?php echo SURL; ?>/images/smiley/comcom/17.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','18');"><img src="<?php echo SURL; ?>/images/smiley/comcom/18.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','19');"><img src="<?php echo SURL; ?>/images/smiley/comcom/19.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','20');"><img src="<?php echo SURL; ?>/images/smiley/comcom/20.gif" /></a>
        
        <a href="javascript:;" onClick="$.SetEditor('Smiley','21');"><img src="<?php echo SURL; ?>/images/smiley/comcom/21.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','22');"><img src="<?php echo SURL; ?>/images/smiley/comcom/22.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','23');"><img src="<?php echo SURL; ?>/images/smiley/comcom/23.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','24');"><img src="<?php echo SURL; ?>/images/smiley/comcom/24.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','25');"><img src="<?php echo SURL; ?>/images/smiley/comcom/25.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','26');"><img src="<?php echo SURL; ?>/images/smiley/comcom/26.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','27');"><img src="<?php echo SURL; ?>/images/smiley/comcom/27.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','28');"><img src="<?php echo SURL; ?>/images/smiley/comcom/28.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','29');"><img src="<?php echo SURL; ?>/images/smiley/comcom/29.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','30');"><img src="<?php echo SURL; ?>/images/smiley/comcom/30.gif" /></a>
        
     </div>

   </li>
   
   <li class="phpappeditortext_UpPic" id="EditorUpPic">
   <div id="UploadPhotoNote" style="display:none"><em>批量上传</em></div>
   <a href="javascript:;" title="批量上传图片" id="PHPAPPUploadPhoto"></a>
   </li>
   
   <li class="phpappeditortext_UpFile" id="EditorUpFile">
   <a href="javascript:;" title="批量上传附件" id="PHPAPPUploadFile"></a>
   </li>
   
   <li class="phpappeditortext_UpMusic" id="EditorUpMusic">
   <a href="javascript:;" title="插入MP3音乐" id="PHPAPPUploadMusic"></a>
   </li>
   
   <li class="phpappeditortext_UpMultimedia" id="EditorUpMultimedia">
   <a href="javascript:;" title="插入视频" id="PHPAPPUploadMultimedia" onclick="$.PHPAPPButton('#ShowEditorMultimedia');"></a>
   		<div id="ShowEditorMultimedia" style="display:none" class="showeditor tablecss">
        <h6><dfn><a href="javascript:;" title="关闭添加视频" onclick="$.CloseID('#ShowEditorMultimedia')"></a></dfn>添加视频地址</h6>
        <p><input type="text" id="addmultimediaurl" class="form_input_text" style="width:300px;" value="http://"/></p>
        目前支持视频地址 优酷,土豆,酷6,56网<br />
        直接格式支持 wmv avi rmvb mov swf flv 格式<br />
        <p><input type="button" value="确定" class="small blue awesome" onclick="$.SetEditor('MultimediaURL');"/></p>
        </div>
   </li>
   
   <li class="phpappeditortext_Paste" id="EditorPaste">
   <a href="javascript:;" onClick="$.SetEditor('Paste');" title="粘贴内容"></a>
   </li>
   
   <!--
   <li class="phpappeditortext_Hide" id="EditorTextHide" style="display:none">
   <a href="javascript:;" onClick="$.SetEditor('Hide');" title="隐藏内容"></a>
   </li>
   -->
   
   
</ul>


</div>


<script type="text/javascript">
var SURL='<?php echo SURL; ?>';
var uploadmusictitle='上传音乐';
var uploadphototitle='上传图片';
var uploadfiletitle='上传文件';
var getdatatitle='读取数据中';
var editordeletetitle='清空内容';
var editorreducetitle='减少编辑框高度';
var editoraddtitle='添加编辑框高度';
var editorwysiwygtitle='可视编辑';
var editorubbtitle='纯文本代码';
var editoremptytitle='确定是否要清空内容?';
var editorcharset='<?php echo S_CHARSET; ?>';
</script>

<script type="text/javascript" src="<?php echo TURL; ?>js/editor.js"></script>
<script type="text/javascript">$(function(){$.PHPAPPEditor('Content','624','280');});</script>
<textarea name="contact_s" id="Content" class="form_editor"><?php if (!empty(PHPAPP::$config['contact'])){ ?><?php echo PHPAPP::$config['contact']; ?><?php } ?></textarea>
</td>
</tr>

<?php }elseif($this->GET['op']==1){ ?>

<tr>
<td>
<!-- 
	phpapp.cn (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.  2011.10.15
-->


<link href="<?php echo TURL; ?>editor.css" rel="stylesheet" type="text/css" />

<div id="UploadMusic"></div>

<div id="UploadPhoto"></div>

<div id="UploadFile"></div>

<div id="phpapp_editor">

<ul>

   <li class="phpappeditorfonts">
   <a href="javascript:;" title="字体类型" id="EditorFonts" onclick="$.PHPAPPButton('#ShowEditorFonts')">
   </a>
   
   <div id="ShowEditorFonts" class="showeditor" style="display:none">
        <a href="javascript:;" onClick="$.SetEditor('FontName','宋体');">宋体</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','黑体');">黑体</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','楷体_GB2312');">楷体_GB2312</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','隶书');">隶书</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','幼圆');">幼圆</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','Arial');">Arial</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','Arial Narrow');">Arial Narrow</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','Arial Black');">Arial Black</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','Comic Sans MS');">Comic Sans MS</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','Courier');">Courier</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','System');">System</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','Times New Roman');">Times New Roman</a>
        <a href="javascript:;" onClick="$.SetEditor('FontName','Verdana');">Verdana</a>
   </div>

   </li>
   
   <li class="phpappeditorfontsize">
   <a href="javascript:;" id="EditorFontSize" title="字体大小" onclick="$.PHPAPPButton('#ShowEditorFontSize')">
   </a>
   
   <div id="ShowEditorFontSize" class="showeditor" style="display:none">
        <a href="javascript:;" onClick="$.SetEditor('fontsize',1);"><span style="font-size:10px">1</span></a>
        <a href="javascript:;" onClick="$.SetEditor('fontsize',2);"><span style="font-size:12px">2</span></a>
        <a href="javascript:;" onClick="$.SetEditor('fontsize',3);"><span style="font-size:14px">3</span></a>
        <a href="javascript:;" onClick="$.SetEditor('fontsize',4);" style="height:18px;"><span style="font-size:18px;line-height:18px;">4</span></a>
        <a href="javascript:;" onClick="$.SetEditor('fontsize',5);" style="height:24px;"><span style="font-size:24px;line-height:24px;">5</span></a>
        <a href="javascript:;" onClick="$.SetEditor('fontsize',6);" style="height:36px;"><span style="font-size:36px;line-height:36px;">6</span></a>
        <a href="javascript:;" onClick="$.SetEditor('fontsize',7);" style="height:48px;"><span style="font-size:48px;line-height:48px;">7</span></a>
   </div>
   </li>
   
   <li class="phpappeditortext_Bold">
   <a href="javascript:;" onClick="$.SetEditor('Bold','Bold');" title="粗体"></a>
   </li>
   
   <li class="phpappeditortext_Italic">
   <a href="javascript:;" onClick="$.SetEditor('Italic','Italic');" title="斜体"></a>
   </li>
   
   <li class="phpappeditortext_Underline">
   <a href="javascript:;" onClick="$.SetEditor('Underline','Underline');" title="下划线"></a>
   </li>
   
   <li class="phpappeditortext_ForeColor">
   <a href="javascript:;" title="文字颜色" onclick="$.PHPAPPButton('#ShowEditorForeColor')"></a>
   
   <div id="ShowEditorForeColor" class="showeditor" style="display:none">
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffffff');" style="background-color:#ffffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#cccccc');" style="background-color:#cccccc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#c0c0c0');" style="background-color:#c0c0c0"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#999999');" style="background-color:#999999"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#666666');" style="background-color:#666666"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#333333');" style="background-color:#333333"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#000000');" style="background-color:#000000"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffcccc');" style="background-color:#ffcccc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ff6666');" style="background-color:#ff6666"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ff0000');" style="background-color:#ff0000"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#cc0000');" style="background-color:#cc0000"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#990000');" style="background-color:#990000"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#660000');" style="background-color:#660000"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#330000');" style="background-color:#330000"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffcc99');" style="background-color:#ffcc99"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ff9966');" style="background-color:#ff9966"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ff9900');" style="background-color:#ff9900"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ff6600');" style="background-color:#ff6600"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#cc6600');" style="background-color:#cc6600"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#993300');" style="background-color:#993300"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#663300');" style="background-color:#663300"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffff99');" style="background-color:#ffff99"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffff66');" style="background-color:#ffff66"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffcc66');" style="background-color:#ffcc66"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffcc33');" style="background-color:#ffcc33"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#cc9933');" style="background-color:#cc9933"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#996633');" style="background-color:#996633"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#663333');" style="background-color:#663333"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffffcc');" style="background-color:#ffffcc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffff33');" style="background-color:#ffff33"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffff00');" style="background-color:#ffff00"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffcc00');" style="background-color:#ffcc00"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#999900');" style="background-color:#999900"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#666600');" style="background-color:#666600"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#333300');" style="background-color:#333300"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#99ff99');" style="background-color:#99ff99"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#66ff99');" style="background-color:#66ff99"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#33ff33');" style="background-color:#33ff33"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#33cc00');" style="background-color:#33cc00"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#009900');" style="background-color:#009900"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#006600');" style="background-color:#006600"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#003300');" style="background-color:#003300"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#99ffff');" style="background-color:#99ffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#33ffff');" style="background-color:#33ffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#66cccc');" style="background-color:#66cccc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#00cccc');" style="background-color:#00cccc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#339999');" style="background-color:#339999"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#336666');" style="background-color:#336666"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#003333');" style="background-color:#003333"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ccffff');" style="background-color:#ccffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#66ffff');" style="background-color:#66ffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#33ccff');" style="background-color:#33ccff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#3366ff');" style="background-color:#3366ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#3333ff');" style="background-color:#3333ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#000099');" style="background-color:#000099"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#000066');" style="background-color:#000066"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ccccff');" style="background-color:#ccccff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#9999ff');" style="background-color:#9999ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#6666cc');" style="background-color:#6666cc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#6633ff');" style="background-color:#6633ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#6600cc');" style="background-color:#6600cc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#333399');" style="background-color:#333399"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#330099');" style="background-color:#330099"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ffccff');" style="background-color:#ffccff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#ff99ff');" style="background-color:#ff99ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#cc66cc');" style="background-color:#cc66cc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#cc33cc');" style="background-color:#cc33cc"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#993399');" style="background-color:#993399"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#663366');" style="background-color:#663366"></a>
        <a href="javascript:;" onClick="$.SetEditor('ForeColor','#330033');" style="background-color:#330033"></a>
   </div>
   
   
   
   
   </li>
   
   <li class="phpappeditortext_BackgroundColor" style="margin-right:8px;">
   <a href="javascript:;" title="文字背景色" onclick="$.PHPAPPButton('#ShowBackgroundColor')"></a>
   
   <div id="ShowBackgroundColor" class="showeditor" style="display:none">
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffffff');" style="background-color:#ffffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#cccccc');" style="background-color:#cccccc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#c0c0c0');" style="background-color:#c0c0c0"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#999999');" style="background-color:#999999"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#666666');" style="background-color:#666666"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#333333');" style="background-color:#333333"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#000000');" style="background-color:#000000"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffcccc');" style="background-color:#ffcccc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ff6666');" style="background-color:#ff6666"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ff0000');" style="background-color:#ff0000"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#cc0000');" style="background-color:#cc0000"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#990000');" style="background-color:#990000"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#660000');" style="background-color:#660000"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#330000');" style="background-color:#330000"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffcc99');" style="background-color:#ffcc99"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ff9966');" style="background-color:#ff9966"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ff9900');" style="background-color:#ff9900"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ff6600');" style="background-color:#ff6600"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#cc6600');" style="background-color:#cc6600"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#993300');" style="background-color:#993300"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#663300');" style="background-color:#663300"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffff99');" style="background-color:#ffff99"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffff66');" style="background-color:#ffff66"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffcc66');" style="background-color:#ffcc66"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffcc33');" style="background-color:#ffcc33"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#cc9933');" style="background-color:#cc9933"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#996633');" style="background-color:#996633"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#663333');" style="background-color:#663333"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffffcc');" style="background-color:#ffffcc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffff33');" style="background-color:#ffff33"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffff00');" style="background-color:#ffff00"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffcc00');" style="background-color:#ffcc00"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#999900');" style="background-color:#999900"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#666600');" style="background-color:#666600"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#333300');" style="background-color:#333300"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#99ff99');" style="background-color:#99ff99"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#66ff99');" style="background-color:#66ff99"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#33ff33');" style="background-color:#33ff33"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#33cc00');" style="background-color:#33cc00"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#009900');" style="background-color:#009900"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#006600');" style="background-color:#006600"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#003300');" style="background-color:#003300"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#99ffff');" style="background-color:#99ffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#33ffff');" style="background-color:#33ffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#66cccc');" style="background-color:#66cccc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#00cccc');" style="background-color:#00cccc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#339999');" style="background-color:#339999"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#336666');" style="background-color:#336666"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#003333');" style="background-color:#003333"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ccffff');" style="background-color:#ccffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#66ffff');" style="background-color:#66ffff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#33ccff');" style="background-color:#33ccff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#3366ff');" style="background-color:#3366ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#3333ff');" style="background-color:#3333ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#000099');" style="background-color:#000099"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#000066');" style="background-color:#000066"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ccccff');" style="background-color:#ccccff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#9999ff');" style="background-color:#9999ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#6666cc');" style="background-color:#6666cc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#6633ff');" style="background-color:#6633ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#6600cc');" style="background-color:#6600cc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#333399');" style="background-color:#333399"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#330099');" style="background-color:#330099"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ffccff');" style="background-color:#ffccff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#ff99ff');" style="background-color:#ff99ff"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#cc66cc');" style="background-color:#cc66cc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#cc33cc');" style="background-color:#cc33cc"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#993399');" style="background-color:#993399"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#663366');" style="background-color:#663366"></a>
        <a href="javascript:;" onClick="$.SetEditor('BackColor','#330033');" style="background-color:#330033"></a>
   </div>
   
   </li>
   
   
   <li class="phpappeditortext_JustifyLeft">
   <a href="javascript:;" onClick="$.SetEditor('JustifyLeft','JustifyLeft');" title="左对齐"></a>
   </li>
   
   <li class="phpappeditortext_JustifyCenter">
   <a href="javascript:;" onClick="$.SetEditor('JustifyCenter','JustifyCenter');" title="居中对齐"></a>
   </li>
   
   <li class="phpappeditortext_JustifyRight" style="margin-right:8px;">
   <a href="javascript:;" onClick="$.SetEditor('JustifyRight','JustifyRight');" title="右对齐"></a>
   </li>
   
   <li class="phpappeditortext_AddLink">
   <a href="javascript:;" title="添加超链接" onclick="$.PHPAPPButton('#ShowEditorAddLink');$.IframeSelectionSave('AddLink');"></a>
   
   <div id="ShowEditorAddLink" style="display:none" class="showeditor tablecss" style="width:210px;">
        <h6><dfn><a href="javascript:;" title="关闭链接" onclick="$.CloseID('#ShowEditorAddLink')"></a></dfn>添加链接</h6>
        <div id="LinkURLName" style="display:none">
        <span>请输入链接文字</span>
        <p><input id="addlinkname" type="text" class="form_input_text form_input_width_200"  value=""/></p>
        </div>
        <span>请输入链接地址</span>
        <p><input id="addlinkurl" type="text" class="form_input_text form_input_width_200"  value="http://"/></p>
        <p><input id="addlinkwindow" type="checkbox" value="1" checked />是否新窗口打开</p>
        <p><input type="button" value="确定" class="small blue awesome" onclick="$.SetEditor('AddLink','AddLink');"/> <input type="button" value="取消" class="small orange awesome" onclick="$.CloseID('#ShowEditorAddLink')"/></p>
   </div>
   
   </li>
   
   <li class="phpappeditortext_Unlink">
   <a href="javascript:;" onClick="$.SetEditor('Unlink','Unlink');" title="删除超链接"></a>
   </li>
   
   <li class="phpappeditortext_RemoveFormat">
   <a href="javascript:;" onClick="$.SetEditor('RemoveFormat','RemoveFormat');" title="删除文字格式"></a>
   </li>
   
   <li class="phpappeditortext_AddTable" style="margin-right:8px;">
   <a href="javascript:;" title="插入表格" onclick="$.IframeSelectionSave();$.PHPAPPButton('#ShowEditorAddTable');"></a>
   
   <div id="ShowEditorAddTable" style="display:none" class="showeditor tablecss">
        <h6><dfn><a href="javascript:;" title="关闭插入表格" onclick="$.CloseID('#ShowEditorAddTable')"></a></dfn>插入表格</h6>
        <p>表格行数 <input type="text" id="addtablelines" class="form_input_text form_input_width_150"  value="3" maxlength="6"/> 行</p>
        <p>表格列数 <input type="text" id="addtablerows" class="form_input_text form_input_width_150"  value="3" maxlength="6"/> 列</p>
        <p>表格宽度 <input type="text" id="addtablewidth" class="form_input_text form_input_width_150"  value="300" maxlength="6"/> px</p>
        <p><input type="button" value="确定" class="small blue awesome" onclick="$.AddTableYes()"/> <input type="button" value="取消" class="small orange awesome" onclick="$.CloseID('#ShowEditorAddTable')"/></p>
    </div>

   </li>
   
   <li class="phpappeditortext_Smiley">
   <a href="javascript:;" title="插入表情" onclick="$.IframeSelectionSave();$.PHPAPPButton('#ShowEditorSmiley');"></a>

    <div id="ShowEditorSmiley" style="display:none" class="showeditor tablecss">
        <h6><dfn><a href="javascript:;" title="关闭表情" onclick="$.CloseID('#ShowEditorSmiley')"></a></dfn>添加表情</h6>
        
        <a href="javascript:;" onClick="$.SetEditor('Smiley','1');"><img src="<?php echo SURL; ?>/images/smiley/comcom/1.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','2');"><img src="<?php echo SURL; ?>/images/smiley/comcom/2.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','3');"><img src="<?php echo SURL; ?>/images/smiley/comcom/3.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','4');"><img src="<?php echo SURL; ?>/images/smiley/comcom/4.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','5');"><img src="<?php echo SURL; ?>/images/smiley/comcom/5.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','6');"><img src="<?php echo SURL; ?>/images/smiley/comcom/6.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','7');"><img src="<?php echo SURL; ?>/images/smiley/comcom/7.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','8');"><img src="<?php echo SURL; ?>/images/smiley/comcom/8.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','9');"><img src="<?php echo SURL; ?>/images/smiley/comcom/9.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','10');"><img src="<?php echo SURL; ?>/images/smiley/comcom/10.gif" /></a>
        
        <a href="javascript:;" onClick="$.SetEditor('Smiley','11');"><img src="<?php echo SURL; ?>/images/smiley/comcom/11.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','12');"><img src="<?php echo SURL; ?>/images/smiley/comcom/12.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','13');"><img src="<?php echo SURL; ?>/images/smiley/comcom/13.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','14');"><img src="<?php echo SURL; ?>/images/smiley/comcom/14.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','15');"><img src="<?php echo SURL; ?>/images/smiley/comcom/15.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','16');"><img src="<?php echo SURL; ?>/images/smiley/comcom/16.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','17');"><img src="<?php echo SURL; ?>/images/smiley/comcom/17.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','18');"><img src="<?php echo SURL; ?>/images/smiley/comcom/18.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','19');"><img src="<?php echo SURL; ?>/images/smiley/comcom/19.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','20');"><img src="<?php echo SURL; ?>/images/smiley/comcom/20.gif" /></a>
        
        <a href="javascript:;" onClick="$.SetEditor('Smiley','21');"><img src="<?php echo SURL; ?>/images/smiley/comcom/21.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','22');"><img src="<?php echo SURL; ?>/images/smiley/comcom/22.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','23');"><img src="<?php echo SURL; ?>/images/smiley/comcom/23.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','24');"><img src="<?php echo SURL; ?>/images/smiley/comcom/24.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','25');"><img src="<?php echo SURL; ?>/images/smiley/comcom/25.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','26');"><img src="<?php echo SURL; ?>/images/smiley/comcom/26.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','27');"><img src="<?php echo SURL; ?>/images/smiley/comcom/27.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','28');"><img src="<?php echo SURL; ?>/images/smiley/comcom/28.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','29');"><img src="<?php echo SURL; ?>/images/smiley/comcom/29.gif" /></a>
        <a href="javascript:;" onClick="$.SetEditor('Smiley','30');"><img src="<?php echo SURL; ?>/images/smiley/comcom/30.gif" /></a>
        
     </div>

   </li>
   
   <li class="phpappeditortext_UpPic" id="EditorUpPic">
   <div id="UploadPhotoNote" style="display:none"><em>批量上传</em></div>
   <a href="javascript:;" title="批量上传图片" id="PHPAPPUploadPhoto"></a>
   </li>
   
   <li class="phpappeditortext_UpFile" id="EditorUpFile">
   <a href="javascript:;" title="批量上传附件" id="PHPAPPUploadFile"></a>
   </li>
   
   <li class="phpappeditortext_UpMusic" id="EditorUpMusic">
   <a href="javascript:;" title="插入MP3音乐" id="PHPAPPUploadMusic"></a>
   </li>
   
   <li class="phpappeditortext_UpMultimedia" id="EditorUpMultimedia">
   <a href="javascript:;" title="插入视频" id="PHPAPPUploadMultimedia" onclick="$.PHPAPPButton('#ShowEditorMultimedia');"></a>
   		<div id="ShowEditorMultimedia" style="display:none" class="showeditor tablecss">
        <h6><dfn><a href="javascript:;" title="关闭添加视频" onclick="$.CloseID('#ShowEditorMultimedia')"></a></dfn>添加视频地址</h6>
        <p><input type="text" id="addmultimediaurl" class="form_input_text" style="width:300px;" value="http://"/></p>
        目前支持视频地址 优酷,土豆,酷6,56网<br />
        直接格式支持 wmv avi rmvb mov swf flv 格式<br />
        <p><input type="button" value="确定" class="small blue awesome" onclick="$.SetEditor('MultimediaURL');"/></p>
        </div>
   </li>
   
   <li class="phpappeditortext_Paste" id="EditorPaste">
   <a href="javascript:;" onClick="$.SetEditor('Paste');" title="粘贴内容"></a>
   </li>
   
   <!--
   <li class="phpappeditortext_Hide" id="EditorTextHide" style="display:none">
   <a href="javascript:;" onClick="$.SetEditor('Hide');" title="隐藏内容"></a>
   </li>
   -->
   
   
</ul>


</div>


<script type="text/javascript">
var SURL='<?php echo SURL; ?>';
var uploadmusictitle='上传音乐';
var uploadphototitle='上传图片';
var uploadfiletitle='上传文件';
var getdatatitle='读取数据中';
var editordeletetitle='清空内容';
var editorreducetitle='减少编辑框高度';
var editoraddtitle='添加编辑框高度';
var editorwysiwygtitle='可视编辑';
var editorubbtitle='纯文本代码';
var editoremptytitle='确定是否要清空内容?';
var editorcharset='<?php echo S_CHARSET; ?>';
</script>

<script type="text/javascript" src="<?php echo TURL; ?>js/editor.js"></script>

<script type="text/javascript">$(function(){$.PHPAPPEditor('Content','624','280');});</script>
<textarea name="about_s" id="Content" class="form_editor"><?php if (!empty(PHPAPP::$config['about'])){ ?><?php echo PHPAPP::$config['about']; ?><?php } ?></textarea>
</td>
</tr>

<?php }else{ ?>
<tr>
<td class="width_160">网站名称:</td>
<td><input name="sitename_s" value="<?php echo PHPAPP::$config['sitename']; ?>" type="text" class="form_input_text form_input_width_200" /></td>
<td class="color_999">网站名称，将显示在浏览器的标头处</td>
</tr>

<tr>
<td class="width_160">网站色彩:</td>
<td>
<div id="RadioSiteColor">
<input id="RadioSiteColor1" class="radio" type="radio" name="sitecolor_d" value="0"  <?php if (PHPAPP::$config['sitecolor']==0){ ?>checked<?php } ?>><label for="RadioSiteColor1">彩色</label> <input id="RadioSiteColor2" type="radio" name="sitecolor_d" value="1" <?php if (PHPAPP::$config['sitecolor']==1){ ?>checked<?php } ?>><label for="RadioSiteColor2">黑白</label>
</div>
</td>
<td class="color_999">&#26032;&#30591;&#31038;&#21306;&#65306;&#104;&#116;&#116;&#112;&#115;&#58;&#47;&#47;&#119;&#119;&#119;&#46;&#48;&#49;&#48;&#120;&#114;&#46;&#99;&#111;&#109;</td>
</tr>

<tr>
<td class="width_160">网站备案号:</td>
<td><input name="siteicp_s" value="<?php echo PHPAPP::$config['siteicp']; ?>" type="text"  class="form_input_text form_input_width_200" /></td>
<td class="color_999">页面底部可以显示 ICP 备案信息，如果网站已备案，在此输入您的备案号，它将显示在页面底部，如果没有请留空</td>
</tr>

<tr>
<td class="width_160">网站顶部公告:</td>
<td>
<div id="RadioSiteNotice">
<input id="RadioSiteNotice1" class="radio" type="radio" name="sitenotice_d" value="0"  <?php if (PHPAPP::$config['sitenotice']==0){ ?>checked<?php } ?>><label for="RadioSiteNotice1">启用</label> <input id="RadioSiteNotice2" class="radio" type="radio" name="sitenotice_d" value="1" <?php if (PHPAPP::$config['sitenotice']==1){ ?>checked<?php } ?>><label for="RadioSiteNotice2">关闭</label>
</div>
</td>
<td class="color_999">网站全局顶部公告</td>
</tr>

<tr>
<td class="width_160">网站顶部公告内容:</td>
<td><input name="noticecontent_s" value="<?php echo PHPAPP::$config['noticecontent']; ?>" type="text" class="form_input_text form_input_width_200"/></td>
<td class="color_999">内容支持HTML代码，200字内</td>
</tr>

<tr>
<td class="width_160">关闭分享与引导栏:</td>
<td>
<div id="RadioSiteCloseGuide">
<input id="RadioSiteCloseGuide1" class="radio" type="radio" name="sitecloseguide_d" value="1"  <?php if (PHPAPP::$config['sitecloseguide']==1){ ?>checked<?php } ?>><label for="RadioSiteCloseGuide1">是</label> <input id="RadioSiteCloseGuide2" class="radio" type="radio" name="sitecloseguide_d" value="0" <?php if (PHPAPP::$config['sitecloseguide']==0){ ?>checked<?php } ?>><label for="RadioSiteCloseGuide2">否</label>
</div>
</td>
<td class="color_999">网站关闭分享与引导栏显示</td>
</tr>

<tr>
<td class="width_160">网站关闭多语言:</td>
<td>
<div id="RadioSiteCloseLanguage">
<input id="RadioSiteCloseLanguage1" class="radio" type="radio" name="sitecloselanguage_d" value="1"  <?php if (PHPAPP::$config['sitecloselanguage']==1){ ?>checked<?php } ?>><label for="RadioSiteCloseLanguage1">是</label> <input id="RadioSiteCloseLanguage2" class="radio" type="radio" name="sitecloselanguage_d" value="0" <?php if (PHPAPP::$config['sitecloselanguage']==0){ ?>checked<?php } ?>><label for="RadioSiteCloseLanguage2">否</label>
</div>
</td>
<td class="color_999">网站关闭底部多语言显示</td>
</tr>

<tr>
<td class="width_160">网站关闭会员注册:</td>
<td>
<div id="RadioSiteCloseRegister">
<input id="RadioSiteCloseRegister1" class="radio" type="radio" name="sitecloseregister_d" value="1"  <?php if (PHPAPP::$config['sitecloseregister']==1){ ?>checked<?php } ?>><label for="RadioSiteCloseRegister1">是</label> <input id="RadioSiteCloseRegister2" class="radio" type="radio" name="sitecloseregister_d" value="0" <?php if (PHPAPP::$config['sitecloseregister']==0){ ?>checked<?php } ?>><label for="RadioSiteCloseRegister2">否</label>
</div>
</td>
<td class="color_999">暂时将网注关闭,所有用户无法注册但可以登录.</td>
</tr>

<tr>
<td class="width_160">网站关闭:</td>
<td>
<div id="RadioSiteClose">
<input id="RadioSiteClose1" class="radio" type="radio" name="siteclose_d" value="1"  <?php if (PHPAPP::$config['siteclose']==1){ ?>checked<?php } ?>><label for="RadioSiteClose1">是</label> <input id="RadioSiteClose2" class="radio" type="radio" name="siteclose_d" value="0" <?php if (PHPAPP::$config['siteclose']==0){ ?>checked<?php } ?>><label for="RadioSiteClose2">否</label>
</div>
</td>
<td class="color_999">暂时将网站关闭,所有用户无法访问,管理员可以访问后台.</td>
</tr>

<tr>
<td class="width_160">网站关闭的原因:</td>
<td><textarea  rows="6"  name="closedreason_s" cols="50" class="form_textarea form_input_width_300"><?php echo $this->str(PHPAPP::$config['closedreason'],0,0,1,0,1); ?></textarea></td>
<td class="color_999">网站关闭时出现的提示信息</td>
</tr>

<tr>
<td class="width_160">网站第三方统计代码:</td>
<td><textarea  rows="6"  name="sitecount" cols="50" class="form_textarea form_input_width_300"><?php echo PHPAPP::$config['sitecount']; ?></textarea></td>
<td class="color_999">页面底部可以显示第三方统计(支持HTML代码)</td>
</tr>

<tr>
<td class="width_160">网站注册协议:</td>
<td><textarea  rows="6"  name="register_agreement" cols="50" class="form_textarea form_input_width_300"><?php echo PHPAPP::$config['register_agreement']; ?></textarea></td>
<td class="color_999">用户注册时显示的协议(支持HTML代码)</td>
</tr>


<tr>
<td class="width_160">默认时区:</td>
<td colspan="2">
<select name="timezone_s" class="form_select_text">
      <option<?php if (PHPAPP::$config['timezone']=='-12'){ ?> selected="selected"<?php } ?> value="-12" title="Eniwetok Island">GMT -12:00 Eniwetok Island</option>
      <option<?php if (PHPAPP::$config['timezone']=='-11'){ ?> selected="selected"<?php } ?> value="-11" title="Midway Island,
Samoa / Apia">GMT -11:00 Midway Island,Samoa / Apia</option>
      <option<?php if (PHPAPP::$config['timezone']=='-10'){ ?> selected="selected"<?php } ?> value="-10" title="U.S.A. / Aleutian *,
U.S.A. / Hawaii">GMT -10:00 U.S.A./Aleutian,U.S.A./Hawaii </option>
      <option<?php if (PHPAPP::$config['timezone']=='-9'){ ?> selected="selected"<?php } ?> value="-9" title="U.S.A. / Alaska *">GMT -09:00 U.S.A. / Alaska *</option>
      <option<?php if (PHPAPP::$config['timezone']=='-8'){ ?> selected="selected"<?php } ?> value="-8" title="Canada / Pacific Canada *,
Mexico / Central/West Mexico **,
U.S.A. / Pacific U.S.A. *">GMT -08:00 Canada / Pacific Canada *,Mexico / Central/West Mexico * ...</option>
      <option<?php if (PHPAPP::$config['timezone']=='-7'){ ?> selected="selected"<?php } ?> value="-7" title="Canada / Mountain Canada *, 
Mexico / Sinaloa **, 
Mexico / Sonora , 
Mexico / Baja California Sur **, 
Mexico / Nayarit **, 
U.S.A. / Mountain U.S.A. *, 
U.S.A. / Arizona , ">GMT -07:00 Canada / Mountain Canada *, Mexico / Sinaloa *, Mexico / Sonora ...  </option>
      <option<?php if (PHPAPP::$config['timezone']=='-6'){ ?> selected="selected"<?php } ?> value="-6" title="Belize / Belmopan , 
Canada / Saskatchewan , 
Canada / Central Canada *, 
Costa Rica / San Jos , 
El Salvador / San Salvador , 
Guatemala / Guatemala City , 
Honduras / Tegucigalpa , 
Mexico / Baja California Norte **, 
Mexico / Mexico City **, 
Nicaragua / Managua , 
U.S.A. / Central U.S.A. *">GMT -06:00 Belize / Belmopan , Canada / Saskatchewan ...</option>
      <option<?php if (PHPAPP::$config['timezone']=='-5'){ ?> selected="selected"<?php } ?> value="-5" title="Bahamas / Nassau *, 
Canada / Eastern Canada *, 
Cayman Islands / Georgetown , 
Colombia / Bogota , 
Cuba / Havana **, 
Ecuador / Quito , 
Haiti / Port-au-Prince , 
Jamaica / Kingston , 
Mexico / Quintana Roo **, 
Panama / Panama , 
Peru / Lima , 
U.S.A. / Indiana East *, 
U.S.A. / Eastern U.S.A. *">GMT -05:00 Bahamas / Nassau *, Canada / Eastern Canada * ... </option>
      <option<?php if (PHPAPP::$config['timezone']=='-4'){ ?> selected="selected"<?php } ?> value="-4" title="Barbados / Bridgetown , 
Bermuda / Hamilton *, 
Bolivia / La Paz , 
Brazil / Central/West Brazil *, 
Canada / Atlantic Canada *, 
Chile / Santiago *, 
Dom. Republic / Santo Domingo , 
Grenada / St. George's , 
Guyana / Georgetown , 
Paraguay / Asuncion *, 
Puerto Rico / San Juan , 
Trinidad and Tobago / Port of Spain ">GMT -04:00 Barbados / Bridgetown, Bermuda / Hamilton *, Bolivia / La Paz ... </option>
      <option<?php if (PHPAPP::$config['timezone']=='-3'){ ?> selected="selected"<?php } ?> value="-3" title="Argentina / Buenos Aires , 
Brazil / Rio de Janeiro *, 
Suriname / Paramaribo , 
Uruguay / Montevideo *">GMT -03:00 Argentina / Buenos Aires, Brazil / Rio de Janeiro * ... </option>
      <option<?php if (PHPAPP::$config['timezone']=='-2'){ ?> selected="selected"<?php } ?> value="-2" title="Brazil / Fernando de Noronha Archip ">GMT -02:00 Brazil / Fernando de Noronha Archip </option>
      <option<?php if (PHPAPP::$config['timezone']=='-1'){ ?> selected="selected"<?php } ?> value="-1" title="Cape Verde / Praia , 
Ivory Coast / Yamoussoukro">GMT -01:00 Cape Verde / Praia , Ivory Coast / Yamoussoukro</option>
      <option<?php if (PHPAPP::$config['timezone']=='0'){ ?> selected="selected"<?php } ?> value="0" title="GMT / GMT , 
Burkina Faso / Ouagadougou , 
England / London **, 
Gambia / Banjul , 
Ghana / Accra , 
Guinea / Conakry , 
Guinea-Bissau / Bissau , 
Iceland / Reykjavik , 
Ireland / Dublin **, 
Liberia / Monrovia , 
Mali / Bamako , 
Mauritania / Nouakchott , 
Morocco / Rabat **, 
Portugal / Lisbon **, 
Scotland / Glasgow **, 
Senegal / Dakar , 
Sierra Leone / Freetown , 
Spain / Canary Islands **, 
Togo / Lome , 
Wales / Cardiff **">GMT &nbsp;00:00   GMT / GMT, Burkina Faso / Ouagadougou, England / London * ...</option>
      <option<?php if (PHPAPP::$config['timezone']=='1'){ ?> selected="selected"<?php } ?> value="1" title="Albania / Tiran **, 
Algeria / Algiers , 
Angola / Luanda , 
Austria / Vienna **, 
Belgium / Brussels **, 
Benin / Cotonou , 
Bosna i Hercegovina / Sarajevo **, 
Cameroon / Yaound , 
Central African Republic / Bangui **, 
Chad / N'Djamena , 
Congo / Brazzaville , 
Congo, Democratic Republic of / Kinshasa , 
Croatia / Zagreb **, 
Czech Republic / Prague **, 
Danmark / Copenhagen **, 
Equatorial Guinea / Malabo , 
France / Paris **, 
Gabon / Libreville , 
Germany / Berlin **, 
Hungary / Budapest **, 
Italy / Rome **, 
Liechtenstein / Vaduz **, 
Luxembourg / Luxembourg **, 
Macedonia / Skopje **, 
Malta / Valletta **, 
Namibia / Windhoek *, 
Netherland / Amsterdam **, 
Niger / Niamey , 
Nigeria / Lagos , 
Norway / Oslo **, 
Poland / Warsaw **, 
Serbia / Belgrade **, 
Serbia / Belgrade **, 
Slovakia / Bratislava **, 
Slovenia / Ljubljana **, 
Spain / Madrid **, 
Sweden / Stockholm **, 
Switzerland / Geneva **, 
Tunisia / Tunis ">GMT +01:00 Albania / Tiran *, Algeria / Algiers, Angola / Luanda ... </option>
      <option<?php if (PHPAPP::$config['timezone']=='2'){ ?> selected="selected"<?php } ?> value="2" title="Botswana / Gaborone , 
Bulgaria / Sofia **, 
Burundi / Bujumbura , 
Congo, Democratic Republic of / Kasai , 
Cyprus / Nicosia **, 
Egypt / Cairo , 
Estonia / Tallinn **, 
Finland / Helsinki **, 
Greece / Athens **, 
Israel / Jerusalem **, 
Jordan / Amman **, 
Latvia / Riga **, 
Lebanon / Beirut **, 
Lesotho / Maseru , 
Libya / Tripoli , 
Lithuania / Vilnius **, 
Malawi / Lilongwe , 
Moldova, Republic / Kishinev **, 
Mozambique / Maputo , 
Palestine / Abu Dis **, 
Romania / Bucharest **, 
Russia / Kaliningrad *, 
Rwanda / Kigali , 
South Africa / Johannesburg , 
Sudan / Khartoum , 
Swaziland / Mbabane , 
Syria / Damascus **, 
Turkey / Istanbul **, 
Ukraine / Kyiv **, 
Zambia / Lusaka , 
Zimbabwe / Harare ">GMT +02:00 Botswana / Gaborone, Bulgaria / Sofia *, Burundi / Bujumbura ... </option>
      <option<?php if (PHPAPP::$config['timezone']=='3'){ ?> selected="selected"<?php } ?> value="3" title="Armenia / Jerevan **, 
Bahrain / Al Manamah , 
Comoros / Moroni , 
Djibouti / Djibouti city , 
Eritrea / Asmara , 
Ethiopia / Adis Abeba , 
Iraq / Baghdad , 
Kenya / Nairobi , 
Kuwait / Al-Kuwayt , 
Madagascar / Antananarivo , 
Qatar / Doha , 
Russia / Moscow *, 
Saudi Arabia / Riyadh , 
Somalia / Mogadishu , 
Tanzania / Dar es Salaam , 
Uganda / Kampala , 
Yeman / Aden ">GMT +03:00 Armenia / Jerevan *, Bahrain / Al Manamah , Comoros / Moroni ...  </option>

      <option<?php if (PHPAPP::$config['timezone']=='4'){ ?> selected="selected"<?php } ?> value="4" title="Azerbaijan / Baku **, 
Mauritius / Port Louis , 
Oman / Muskat , 
Reunion / Saint-Denis , 
Russia / Samara *, 
Seychelles / Victoria , 
United Arab Emirates / Abu Dhabi ">GMT +04:00 Azerbaijan / Baku *, Mauritius / Port Louis, Oman / Muskat ...  </option>

      <option<?php if (PHPAPP::$config['timezone']=='5'){ ?> selected="selected"<?php } ?> value="5" title="Georgia / Tbilisi , 
Kyrgyzstan / Bishkek , 
Pakistan / Islamabad , 
Russia / Yekaterinburg *, 
Tajikistan / Dushanbe , 
Turkmenistan / Ashgabat , 
Uzbekistan / Tashkent ">GMT +05:00 Georgia / Tbilisi, Kyrgyzstan / Bishkek, Pakistan / Islamabad ... </option>

      <option<?php if (PHPAPP::$config['timezone']=='6'){ ?> selected="selected"<?php } ?> value="6" title="Bangladesh / Dhaka , 
Kazakhstan / Alma-Ata , 
Russia / Novosibirsk *, 
Russia / Omsk *">GMT +06:00 Bangladesh / Dhaka, Kazakhstan / Alma-Ata, Russia / Novosibirsk ...</option>

      <option<?php if (PHPAPP::$config['timezone']=='7'){ ?> selected="selected"<?php } ?> value="7" title="Cambodia / Phnom Penh , 
Indonesia / Sumatra , 
Laos / Vientiane , 
Mongolia / West Mongolia , 
Russia / Krasnoyarsk *, 
Thailand / Bangkok , 
Vietnam / Saigon ">GMT +07:00 Cambodia / Phnom Penh, Indonesia / Sumatra, Laos / Vientiane ...  </option>
      <option<?php if (PHPAPP::$config['timezone']=='8'){ ?> selected="selected"<?php } ?> <?php if (!PHPAPP::$config['timezone']){ ?>selected="selected"<?php } ?> value="8" title="北京 , 香港 , 台北,
Australia / Perth , 
Brunei Darussalam / Bandar Seri Begawan , 
Indonesia / Cent. Indonesia , 
Macau / Macau , 
Malaysia / Kuala Lumpur , 
Mongolia / Centr. Mongolia , 
Philippines / Manila , 
Russia / Irkutsk *, 
Sinapore / Singapore , 
">GMT +08:00 北京 , 香港 , 台北 , Australia / Perth ...</option>
      <option<?php if (PHPAPP::$config['timezone']=='9'){ ?> selected="selected"<?php } ?> value="9" title="Indonesia / East Indonesia , 
Japan / Tokyo , 
Korea, Dem. Rep. / Pyongyang , 
Korea, Republic / Seoul , 
Mongolia / East Mongolia , 
Russia / Yakutsk *, 
South Korea / Seoul">GMT +09:00 Indonesia / East Indonesia , Japan / Tokyo , Korea ... </option>

      <option<?php if (PHPAPP::$config['timezone']=='10'){ ?> selected="selected"<?php } ?> value="10" title="Australia / Brisbane , 
Australia / Melbourne *, 
Australia / Sydney *, 
Australia / Hobart *, 
Australia / Victoria *, 
Papua New Guinea / Port Moresby , 
Russia / Vladivostok *">GMT +10:00 Australia / Brisbane , Australia / Melbourne ...</option>
      <option<?php if (PHPAPP::$config['timezone']=='11'){ ?> selected="selected"<?php } ?> value="11" title="Russia / Kamchatka *, 
Russia / Magadan *, 
Vanuatu / Port Vila">GMT +11:00 Russia / Kamchatka *, Russia / Magadan ...</option>
      <option<?php if (PHPAPP::$config['timezone']=='12'){ ?> selected="selected"<?php } ?> value="12" title="Fiji / Suva *, 
New Zealand / Wellington *">GMT +12:00  Fiji / Suva *, New Zealand / Wellington *</option>
      </select>

</td>
</tr>

<?php } ?>
</table>

<div class="phpapp_button"><input type="submit" name="Submit_s" value="提交" class="form_button" onclick="SubmitContent();"/></div>

</form>

<script type="text/javascript">
$('#EditorUpFile').hide();
$("#RadioSiteColor,#RadioSiteNotice,#RadioSiteClose,#RadioSiteCloseRegister,#RadioSiteCloseLanguage,#RadioSiteCloseGuide,#RadioRegisteredNotice").buttonset();
</script>