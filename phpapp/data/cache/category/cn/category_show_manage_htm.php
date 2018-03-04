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

<?php if ($list){ ?>

<div id="WindowsForm<?php echo $this->GET['menu']; ?>">

    <div class="datalist category_list">
     
        <ul>
            <li>
                <span class="checkbox_category"><input type="checkbox" name="checkboxall" value="1"  onclick="CheckboxAll('WindowsForm<?php echo $this->GET['menu']; ?>')"/> 全选</span>
                <span>排序/分类名称</span>
                <span class="category_edit">操作</span>
                <span class="category_order">路径</span>
            </li>
            <li class="category_item" id="CatidID0">
                <span class="checkbox_category"></span>
                <span class="add_category_one"><a class="small green awesome" onclick="AddCategoryOne(30)">添加一级分类</a></span>
            </li>

            <?php echo $showlist; ?>

        
        </ul>
    </div>
</div>


<?php }else{ ?>

<div class="datalist category_list">
     
        <ul>
            <li>
                <span class="checkbox_category"><input type="checkbox" name="checkboxall" value="1"  onclick="CheckboxAll('WindowsForm<?php echo $this->GET['menu']; ?>')"/> 全选</span>
                <span>排序/分类名称</span>
                <span class="category_edit">操作</span>
                <span class="category_order">路径</span>
            </li>
            <li class="category_item" id="CatidID0">
                <span class="checkbox_category"></span>
                <span class="add_category_one"><a class="small green awesome" onclick="AddCategoryOne(30)">添加一级分类</a></span>
            </li>

        </ul>
    </div>

<p>没有分类数据!</p>

<?php } ?>



<div class="warning">
    <h3>系统提示：</h3>
    <p>
    添加 任务,人才,服务 的分类请选择 "任务" 这个应用
    </p>  
</div>


<div class="phpapp_button"><input name="Add" type="submit" value="添加" class="form_button"/> <input name="Displayorder" type="submit" value="排序" class="form_button"/> <input name="Submit" type="submit" value="删除" class="form_button"/></div>



</form>




<script type="text/javascript">
$(function(){	
	$.PHPAPPMouseover('.category_item','.show_add');
	
});


function AddCategoryOne(numpx){
	 AutoCategoryID++; 
	 var subclasshtml ='<li><span class="checkbox_category"><input type="checkbox" disabled="disabled"/></span><span class="subclass_icon" style="padding-left:'+numpx+'px"></span> <input name="addcategory[0]['+AutoCategoryID+'][displayorder]" type="text" class="form_input_text form_input_width_50 add_subclass" value="0"/> <input name="addcategory[0]['+AutoCategoryID+'][name]" type="text" class="form_input_text form_input_width_200" value=""/> <?php if ($apps){ ?><select name="addcategory[0]['+AutoCategoryID+'][type]" class="form_select_text"><?php foreach ($apps as $value){ ?><option value="<?php echo $value["id_phpapp"]; ?>" <?php if ($value["id_phpapp"]==49){ ?> selected="selected"<?php } ?>><?php echo $value["name_phpapp"]; ?></option><?php } ?></select><?php } ?></li>';
	 
	 $('#CatidID0').after(subclasshtml);
	 
}

</script>