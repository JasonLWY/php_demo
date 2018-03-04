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



<div id="ShowAdvancedSearch" class="showadvancedsearch" <?php if (!empty($this->GET['opensearch'])){ ?>style="display:block"<?php } ?>>
<form method="get" action="<?php echo $this->MakeGetParameterURL(); ?>">
<input type="hidden" name="app" value="<?php echo $this->app; ?>" />
<input type="hidden" name="menu" value="<?php echo $this->GET['menu']; ?>" />
<input type="hidden" name="action" value="<?php echo $this->ac; ?>" />
<input type="hidden" name="page" value="<?php echo $this->GET['page']; ?>" />
<input type="hidden" name="opensearch" value="<?php echo $this->GET['opensearch']; ?>" />

<table border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td class="search_h2">ID举报</td>
    <td><input name="rid" type="text" size="50" maxlength="255" class="form_input_text form_input_width_100"  value="<?php if (!empty($selectarray['rid'])){ ?><?php echo $selectarray['rid']; ?><?php } ?>"/> </td>
    <td class="search_h2">任务编号</td>
    <td><input name="tid" type="text" size="50" maxlength="255" class="form_input_text form_input_width_100"  value="<?php if (!empty($selectarray['tid'])){ ?><?php echo $selectarray['tid']; ?><?php } ?>"/></td>
  </tr>
  
    <tr>
    <td class="search_h2">稿件编号</td>
    <td><input name="did" type="text" size="50" maxlength="255" class="form_input_text form_input_width_100"  value="<?php if (!empty($selectarray['did'])){ ?><?php echo $selectarray['did']; ?><?php } ?>"/> </td>
    <td class="search_h2"></td>
    <td></td>
  </tr>

  <tr>
    <td class="search_h2">用户ID </td>
    <td><input name="uid" type="text" size="50" maxlength="255" class="form_input_text form_input_width_100"  value="<?php if (!empty($selectarray['uid'])){ ?><?php echo $selectarray['uid']; ?><?php } ?>"/> (用户UID)</td>
    <td class="search_h2">用户名</td>
    <td><input name="username" type="text" size="50" maxlength="255" class="form_input_text form_input_width_200"  value="<?php if (!empty($selectarray['username'])){ ?><?php echo $selectarray['username']; ?><?php } ?>"/> (组合查询时用用户ID)</td>
  </tr>

  <tr>
    <td class="search_h2">发布时间 </td>
    <td><input name="dateline1" type="text" class="form_input_text dateline" size="10" value="<?php if (!empty($selectarray['dateline1'])){ ?><?php echo $selectarray['dateline1']; ?><?php } ?>" style="width:70px;"/> ~ <input name="dateline2" type="text" class="form_input_text dateline" size="10" value="<?php if (!empty($selectarray['dateline2'])){ ?><?php echo $selectarray['dateline2']; ?><?php } ?>" style="width:70px;"/> 格式 (YYYY-MM-DD)</td>
  </tr>
  
  
   
</table>

<li style="text-align:center;padding-top:20px;">
   <input name="SelectData" type="submit" value="搜索" class="form_button"/>
</li>

</form>

</div>

<div class="advancedsearch">
<?php if (empty($this->GET['opensearch'])){ ?>
<a class="small green awesome" href="<?php echo $this->MakeGetParameterURL(array('opensearch'=>1)); ?>">打开筛选</a>
<?php }else{ ?>
<a class="small green awesome" href="<?php echo $this->MakeGetParameterURL(array('opensearch'=>0)); ?>">关闭筛选</a>
<?php } ?>
</div>


<form action="<?php echo $this->MakeGetParameterURL(); ?>" method="post">

<?php if ($list){ ?>

<div id="WindowsForm<?php echo $this->GET['menu']; ?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist" >
  <tr>
    <td class="datalist_h2" style="width:46px"><input type="checkbox" name="checkboxall"  value="1"  onclick="CheckboxAll('WindowsForm<?php echo $this->GET['menu']; ?>')"/> 全选</td>
    
    <?php foreach ($orderarr as $key=>$value){ ?>
    <td class="datalist_h2"><a href="<?php echo $this->MakeGetParameterURL(array('sqlorder'=>$key,'iforder'=>$iforder)); ?>" id="order_<?php echo $this->GET['menu']; ?>_<?php echo $key; ?>"<?php if ($key==$this->GET['sqlorder']){ ?> <?php if ($this->GET['iforder']==2){ ?>  class="downorder"<?php }else{ ?> class="uporder"<?php } ?><?php } ?>><?php echo $value['name']; ?></a></td>
    <?php } ?> 
    
    <td class="datalist_h2" style="width:60px">查看</td>
    
  </tr>

<?php foreach ($list as $value){ ?>
                          
  <tr>
    <td><input name="checkbox[]" type="checkbox" value="<?php echo $value['rid']; ?>" /></td>
    <td><?php echo $value['rid']; ?></td>
    <td><?php echo $value['uid']; ?></td>
    <td><?php echo $value['name_phpapp']; ?></td>
    <td><?php if ($value['did']){ ?>稿件 #<?php echo $value['did']; ?><?php }else{ ?>任务 #<?php echo $value['tid']; ?><?php } ?></td>
    <td><a href="space.php?lang=<?php echo $this->lang; ?>&app=8&uid=<?php echo $value['uid']; ?>" target="_blank" title="<?php echo $value['username']; ?>"><?php echo $value['username']; ?></a></td>
    <td><a href="<?php echo SURL; ?>/index.php?app=<?php echo $value['appid']; ?>&action=5&tid=<?php echo $value['tid']; ?>&did=<?php echo $value['did']; ?>" target="_blank"><?php echo $value['subject']; ?></a><?php if ($value['serviceuid']>0){ ?><span style="color:#06C">[<?php echo $value['serviceuid']; ?>号客服代选]</span><?php } ?></td>
    <td>
     <?php if ($value['did']){ ?>
     <?php echo $getprocess->GetTaskDraftName($value['dprocess']); ?>
     <?php }else{ ?>
     <?php echo $getprocess->GetTaskProcesName($value['tprocess']); ?>
     <?php } ?>
     </td>
    <td>
    <p><?php echo $value['name']; ?></p>
    <?php if ($value['content']){ ?><p><?php echo $value['content']; ?></p><?php } ?>
    </td>
    <td><?php if ($value['status']){ ?><span style="color:#F30">已处理</span><?php }else{ ?>未处理<?php } ?></td>
        <td>
    
    <?php if ($value['award']){ ?>
    
         <?php echo $value['award']; ?>
    
    <?php }else{ ?>不奖惩<?php } ?></td>
    <td><?php echo $this->Date("Y/m/d H:i:s",$value['dateline']); ?></td>
    <td><?php if ($value['appid']!=82){ ?><a href="<?php echo SURL; ?>/index.php?app=<?php echo $value['appid']; ?>&action=5&tid=<?php echo $value['tid']; ?>&did=<?php echo $value['did']; ?>" target="_blank">查看</a><?php } ?></td>
  </tr>
 <?php } ?> 

</table>

<div class="ajax_page"><?php echo $ajaxpage->ShowPages(); ?></div>

<p>奖惩积分：<select name="award_f" style="width:120px;" class="form_select_text"><option value="10">+10</option><option value="9">+9</option><option value="8">+8</option><option value="7">+7</option><option value="6">+6</option><option value="5">+5</option><option value="4">+4</option><option value="3">+3</option><option value="2">+2</option><option value="1">+1</option><option value="0" selected>不奖惩</option><option value="-1">-1</option><option value="-2">-2</option><option value="-3">-3</option><option value="-4">-4</option><option value="-5">-5</option><option value="-6">-6</option><option value="-7">-7</option><option value="-8">-8</option><option value="-9">-9</option><option value="-10">-10</option></select> 分</p>

</div>

<div class="phpapp_button"><input name="SubmitAward" type="submit" value="奖惩" class="form_button"/> <input name="Delete" type="submit" value="删除" class="form_button"/></div>



<?php }else{ ?>


<p>没有数据!</p>

<?php } ?>

