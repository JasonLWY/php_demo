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

<input type="hidden" name="lang" value="<?php echo $this->lang; ?>" />
<input type="hidden" name="app" value="<?php echo $this->app; ?>" />
<input type="hidden" name="menu" value="<?php echo $this->GET['menu']; ?>" />
<input type="hidden" name="action" value="<?php echo $this->ac; ?>" />
<input type="hidden" name="page" value="<?php echo $this->GET['page']; ?>" />
<input type="hidden" name="opensearch" value="<?php echo $this->GET['opensearch']; ?>" />

<table border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td class="search_h2">用户UID </td>
    <td><input name="uid" type="text" size="50" maxlength="255" class="form_input_text form_input_width_100"  value="<?php if (!empty($selectarray['uid'])){ ?><?php echo $selectarray['uid']; ?><?php } ?>"/> (用户UID)</td>
    <td class="search_h2">用户名</td>
    <td><input name="username" type="text" size="50" maxlength="255" class="form_input_text form_input_width_200"  value="<?php if (!empty($selectarray['username'])){ ?><?php echo $selectarray['username']; ?><?php } ?>"/> (组合查询时用用户ID)</td>
  </tr>
  
    <tr>
    <td class="search_h2">推广员UID </td>
    <td><input name="unionid" type="text" size="50" maxlength="255" class="form_input_text form_input_width_100"  value="<?php if (!empty($selectarray['unionid'])){ ?><?php echo $selectarray['unionid']; ?><?php } ?>"/> (推广员UID)</td>
  </tr>

    <tr>
    <td class="search_h2">用户组 </td>
    <td> 
    <select name="usergroup">
        <option value="0">不限</option>
        <?php foreach ($usergrouparr as $value){ ?>
              <option value="<?php echo $value['gid']; ?>" <?php if (!empty($selectarray['usergroup'])){ ?><?php if ($selectarray['usergroup']==$value['gid']){ ?> selected="selected"<?php } ?><?php } ?>><?php echo $value['groupname']; ?></option>
        <?php } ?>
    </select> 
    </td>
  </tr>
  
  <tr>
    <td class="search_h2">城市地区 </td>
    <td id="cityid" style="height:24px">
 
    <?php if (!empty($selectarray['cityid'])){ ?>
         <?php echo $this->GetSelectCategory('category_city',$selectarray['cityid'],'cityid'); ?>
    <?php }else{ ?> 
         <?php echo $this->SetSelectCategory('category_city',0,'cityid'); ?>
    <?php } ?> 
 
    </td>
  </tr>
  
  <tr>
    <td class="search_h2">可用余额</td>
    <td><input name="money1" type="text" class="form_input_text" size="10" value="<?php if (!empty($selectarray['money1'])){ ?><?php echo $selectarray['money1']; ?><?php } ?>" style="width:70px;"/> ~ <input name="money2" type="text" class="form_input_text" size="10" value="<?php if (!empty($selectarray['money2'])){ ?><?php echo $selectarray['money2']; ?><?php } ?>" style="width:70px;"/> 格式 10~20</td>
  </tr>
  
   <tr>
    <td class="search_h2">积分</td>
    <td><input name="credit1" type="text" class="form_input_text" size="10" value="<?php if (!empty($selectarray['credit1'])){ ?><?php echo $selectarray['credit1']; ?><?php } ?>" style="width:70px;"/> ~ <input name="credit2" type="text" class="form_input_text" size="10" value="<?php if (!empty($selectarray['credit2'])){ ?><?php echo $selectarray['credit2']; ?><?php } ?>" style="width:70px;"/> 格式 10~20</td>
  </tr>

  <tr>
    <td class="search_h2">注册时间 </td>
    <td><input name="dateline1" type="text" class="form_input_text dateline" size="10" value="<?php if (!empty($selectarray['dateline1'])){ ?><?php echo $selectarray['dateline1']; ?><?php } ?>" style="width:70px;"/> ~ <input name="dateline2" type="text" class="form_input_text dateline" size="10" value="<?php if (!empty($selectarray['dateline2'])){ ?><?php echo $selectarray['dateline2']; ?><?php } ?>" style="width:70px;"/> 格式 (YYYY-MM-DD)</td>
  </tr>
  
   <tr>
    <td class="search_h2">最近登录时间 </td>
    <td><input name="logintime1" type="text" class="form_input_text dateline" size="10" value="<?php if (!empty($selectarray['logintime1'])){ ?><?php echo $selectarray['logintime1']; ?><?php } ?>" style="width:70px;"/> ~ <input name="logintime2" type="text" class="form_input_text dateline" size="10" value="<?php if (!empty($selectarray['logintime2'])){ ?><?php echo $selectarray['logintime2']; ?><?php } ?>" style="width:70px;"/> 格式 (YYYY-MM-DD)</td>
  </tr>
  
     <tr>
    <td class="search_h2">推广过期时间 </td>
    <td><input name="uniontime1" type="text" class="form_input_text dateline" size="10" value="<?php if (!empty($selectarray['uniontime1'])){ ?><?php echo $selectarray['uniontime1']; ?><?php } ?>" style="width:70px;"/> ~ <input name="uniontime2" type="text" class="form_input_text dateline" size="10" value="<?php if (!empty($selectarray['uniontime2'])){ ?><?php echo $selectarray['uniontime2']; ?><?php } ?>" style="width:70px;"/> 格式 (YYYY-MM-DD)</td>
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

<script type="text/javascript">
	$(function() {
		 $(".dateline").datepicker();
		 $(".dateline").datepicker('option',{dateFormat:'yy-mm-dd'});
		 $(".dateline").datepicker('option',$.datepicker.regional['zh-CN']);

	});
</script>


<form action="<?php echo $this->MakeGetParameterURL(); ?>" method="post">

<?php if ($list){ ?>

<div id="WindowsForm<?php echo $this->GET['menu']; ?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist" >
  <tr>
    <td class="datalist_h2" style="width:46px"><input type="checkbox" name="checkboxall" value="1"  onclick="CheckboxAll('WindowsForm<?php echo $this->GET['menu']; ?>')"/> 全选</td>
    
    <?php foreach ($orderarr as $key=>$value){ ?>
    <td class="datalist_h2"><a href="<?php echo $this->MakeGetParameterURL(array('sqlorder'=>$key,'iforder'=>$iforder)); ?>" id="order_<?php echo $this->GET['menu']; ?>_<?php echo $key; ?>"<?php if ($key==$this->GET['sqlorder']){ ?> <?php if ($this->GET['iforder']==2){ ?>  class="downorder"<?php }else{ ?> class="uporder"<?php } ?><?php } ?>><?php echo $value['name']; ?></a></td>
    <?php } ?> 
    
    <td class="datalist_h2">操作</td>
  </tr>

<?php foreach ($list as $value){ ?>
  <tr>
    <td><input name="checkbox[]" type="checkbox" value="<?php echo $value['uid']; ?>" /></td>
    <td><?php echo $value['uid']; ?></td>
    <td><?php echo $value['username']; ?></td>
    <td><?php if ($value['realname']==1){ ?>未认证<?php }else{ ?>已认证<?php } ?></td>
    <td><?php echo $value['groupname']; ?></td>
    <td><?php if ($value['adminname']){ ?><?php echo $value['adminname']; ?><?php } ?></td>
    <td><span class="color_f60"><?php echo $value['money']; ?></span></td>
    <td><?php echo $value['union']; ?></td>
    <td><?php echo $value['unionid']; ?></td>
    <td><?php echo $value['credit']; ?></td>
    <td><?php echo $this->Date('Y-m-d',$value['dateline']); ?></td>
    <td><?php echo $this->Date('Y-m-d',$value['logintime']); ?></td>
    <td><?php if ($value['uniontime']){ ?><?php echo $this->Date('Y-m-d',$value['uniontime']); ?><?php } ?></td>
    <td><a href="<?php echo $this->MakeGetParameterURL(array('action'=>2,'id'=>$value['uid'])); ?>">[编辑]</a></td>
  </tr>
 <?php } ?> 

</table>
</div>
<div class="ajax_page"><?php echo $ajaxpage->ShowPages(); ?></div>

<div class="phpapp_button"><input name="Submit" type="submit" value="删除" class="form_button"/></div>


<?php }else{ ?>


没有数据!

<?php } ?>

</form>