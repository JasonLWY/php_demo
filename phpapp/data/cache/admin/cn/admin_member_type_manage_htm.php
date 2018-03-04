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


<?php if ($this->GET['op']==1 || $this->GET['op']==2){ ?>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist">
  <tr>
    <td class="datalist_h2 width_160">项目</td>
    <td class="datalist_h2">数据值</td>
  </tr>
    
    <tr>
    <td class="width_160">名称</td>
    <td> <input name="name_phpapp_s" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($manage['name_phpapp'])){ ?><?php echo $manage['name_phpapp']; ?><?php } ?>"/></td>
  </tr>
  
  
    <tr>
    <td class="width_160">表名</td>
    <td>
    <?php echo $this->GetTable('member_'); ?><input name="table_phpapp_s" type="text" class="form_input_text form_input_width_100" value="<?php if (!empty($manage['table_phpapp'])){ ?><?php echo substr($manage['table_phpapp'],7); ?>" disabled="disabled<?php } ?>"/> <span style="color:#999">表名添加后不能修改</span>
    <?php if (!empty($manage['table_phpapp'])){ ?>
    <input name="table_phpapp_s" type="hidden"  value="<?php echo substr($manage['table_phpapp'],7); ?>"/>
    <?php } ?>
    </td>
  </tr>
  
   <tr>
    <td class="width_160">是否启用</td>
    <td><select name="status_phpapp">
  <option value="0" <?php if (!empty($manage['status_phpapp'])){ ?><?php if ($manage['status_phpapp']==0){ ?> selected="selected" <?php } ?><?php } ?>>启用</option>
  <option value="1" <?php if (!empty($manage['status_phpapp'])){ ?><?php if ($manage['status_phpapp']==1){ ?> selected="selected" <?php } ?><?php } ?>>关闭</option>
</select> </td>
  </tr>
  
</table>

<p style="color:#F00;padding-top:10px;"><strong>提示：添加后还需要手动添加它的相关会员权限,该会员类型才能正常使用！</strong></p>

<div class="phpapp_button"><input name="Submit" type="submit" value="确定" class="form_button"/></div>


<?php }else{ ?>



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
    
    <?php foreach ($list as $key=>$value){ ?>
      <tr>
        <td><input name="checkbox[]" type="checkbox" value="<?php echo $value['id_phpapp']; ?>" <?php if ($value['id_phpapp']==1){ ?>disabled="disabled"<?php } ?>/></td>
        <td><?php echo $value['id_phpapp']; ?></td>
        <td><?php echo $value['name_phpapp']; ?></td>
        <td><?php echo $this->GetTable($value['table_phpapp']); ?></td>
        <td><?php if ($value['status_phpapp']){ ?>关闭<?php }else{ ?>启用<?php } ?></td>
        <td><a href="<?php echo $this->MakeGetParameterURL(array('op'=>2,'id'=>$value['id_phpapp'])); ?>">[编辑]</a></td>
      </tr>
     <?php } ?> 
    
    </table>
    </div>
    
    <div class="ajax_page"><?php echo $ajaxpage->ShowPages(); ?></div>
    
    <div class="phpapp_button"><input name="Submit" type="submit" value="删除" class="form_button"/></div>
    

    <?php } ?>



<?php } ?>

</form>