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

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist" >
  <tr>
    <td class="datalist_h2 width_160">项目</td>
    <td class="datalist_h2">数据值</td>
  </tr>
  
  <tr>
    <td class="width_160">用户名</td>
    <td><?php echo $value['username']; ?></td>
  </tr>
  
   <tr>
    <td class="width_160">当前头像：</td>
    <td style="padding-top:10px;padding-bottom:10px;"><?php echo $this->GetUserAvatar($value['uid'],1,1); ?></td>
  </tr>
  
  <tr>
    <td class="width_160"><strong>安全信息：</strong></td>
    <td></td>
  </tr>
  
   <tr>
    <td class="width_160">新密码设置：</td>
    <td><input name="password_s" type="password" class="form_input_text form_input_width_200" value=""/></td>
  </tr>
  
  <tr>
    <td class="width_160">安全邮箱设置：</td>
    <td><input name="safeemail_s" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['safeemail'])){ ?><?php echo $value['safeemail']; ?><?php } ?>"/></td>
  </tr>
  
  
  <tr>
    <td class="width_160"><strong>信用信息：</strong></td>
    <td></td>
  </tr>


  <tr>
    <td class="width_160">工作速度评分：</td>
    <td><input name="speed_f" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['speed'])){ ?><?php echo $value['speed']; ?><?php } ?>"/> 5 分最高</td>
  </tr>
  
    <tr>
    <td class="width_160">工作态度评分：</td>
    <td><input name="attitude_f" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['attitude'])){ ?><?php echo $value['attitude']; ?><?php } ?>"/> 5 分最高</td>
  </tr>
  
   <tr>
    <td class="width_160">工作质量评分：</td>
    <td><input name="quality_f" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['quality'])){ ?><?php echo $value['quality']; ?><?php } ?>"/> 5 分最高</td>
  </tr>
  
   <tr>
    <td class="width_160"><strong>用户组信息：</strong></td>
    <td></td>
  </tr>

  
  <tr>
    <td class="width_160">用户类型：</td>
    <td><select name="usertype_d">
        <?php foreach ($membertype as $type){ ?>
          <option value="<?php echo $type['id_phpapp']; ?>" <?php if ($value['usertype']==$type['id_phpapp']){ ?> selected="selected" <?php } ?>><?php echo $type['name_phpapp']; ?></option>
        <?php } ?>
        </select>
    </td>
  </tr>
    
    <tr>
    <td class="width_160">后台管理组：</td>
    <td><select name="admingroup_d">
         <option value="0">无</option>
        <?php foreach ($adminusergroup as $ausergroup){ ?>
          <option value="<?php echo $ausergroup['id_phpapp']; ?>" <?php if ($value['admingroup']==$ausergroup['id_phpapp']){ ?> selected="selected" <?php } ?>><?php echo $ausergroup['name_phpapp']; ?></option>
        <?php } ?>
        </select>
    </td>
  </tr>
  
  <tr>
    <td class="width_160">前台用户组：</td>
    <td><select name="usergroup_d">
        <?php foreach ($usergroup as $group){ ?>
          <option value="<?php echo $group['gid']; ?>" <?php if ($value['usergroup']==$group['gid']){ ?> selected="selected" <?php } ?>><?php echo $group['groupname']; ?></option>
        <?php } ?>
        </select>
    </td>
  </tr>
  
   <tr>
    <td class="width_160"><strong>推广信息：</strong></td>
    <td></td>
  </tr>
  
  <tr>
    <td class="width_160">推广员：</td>
    <td> <input name="unionid_d" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['unionid'])){ ?><?php echo $value['unionid']; ?><?php } ?>"/></td>
  </tr>
  
   <tr>
    <td class="width_160">推广过期时间：</td>
    <td> <input name="uniontime_s" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['uniontime'])){ ?><?php echo $this->Date('Y-m-d',$value['uniontime']); ?><?php } ?>"/> 格式 2012-12-31 (过期小时分秒默认 0:00:00)</td>
  </tr>

  
  <tr>
    <td class="width_160"><strong>财务信息：</strong></td>
    <td></td>
  </tr>
  
  
  <tr>
    <td class="width_160">可用余额：</td>
    <td> <input name="money_f" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['money'])){ ?><?php echo $value['money']; ?><?php } ?>"/> 元</td>
  </tr>


  <tr>
    <td class="width_160">冻结金额：</td>
    <td> <input name="lock_f" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['lock'])){ ?><?php echo $value['lock']; ?><?php } ?>"/> 元</td>
  </tr>
  
  <tr>
    <td class="width_160">推广提成：</td>
    <td> <input name="union_f" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['union'])){ ?><?php echo $value['union']; ?><?php } ?>"/> 元</td>
  </tr>
  
  <tr>
    <td class="width_160">财富金额：</td>
    <td> <input name="wealth_f" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['wealth'])){ ?><?php echo $value['wealth']; ?><?php } ?>"/> 元</td>
  </tr>
  
  <tr>
    <td class="width_160"><strong>资料信息：</strong></td>
    <td></td>
  </tr>
  
  <tr>
    <td class="width_160">积分：</td>
    <td> <input name="credit_d" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['credit'])){ ?><?php echo $value['credit']; ?><?php } ?>"/></td>
  </tr>
  
  <tr>
    <td class="form_input_width_100 addtask_text">性别：</td>
    <td>
    <select name="gender">
        <option value="0"<?php if ($value['gender']==0){ ?> selected="selected"<?php } ?>>保密</option><option value="1"<?php if ($value['gender']==1){ ?> selected="selected"<?php } ?>>男</option><option value="2"<?php if ($value['gender']==2){ ?> selected="selected"<?php } ?>>女</option>
    </select>
    </td>
  </tr>
  
  <tr>
    <td class="form_input_width_100 addtask_text">生日：</td>
    <td>
    <select name="Year" id="SetYear">
        <?php echo $GetYear; ?>
    </select>
    
    <select name="Month" id="SetMonth">
    
         <?php echo $GetMonth; ?>
       
    </select>
    
    <select name="Day" id="SetDay">

    </select>
    </td>
    </tr>
    
   <tr>
    <td class="form_input_width_100 addtask_text">出生地：</td>
    <td id="birthcity">
    <?php if ($value['birthcity']){ ?>
         <?php echo $this->GetSelectCategory('category_city',$value['birthcity'],'birthcity'); ?>
    <?php }else{ ?> 
         <?php echo $this->SetSelectCategory('category_city',$value['birthcity'],'birthcity'); ?>
    <?php } ?>
    </td>
  </tr>
  
  <tr>
    <td class="form_input_width_100 addtask_text">所在地：</td>
    <td id="residecity">
    <?php if ($value['residecity']){ ?>
         <?php echo $this->GetSelectCategory('category_city',$value['residecity'],'residecity'); ?>
    <?php }else{ ?> 
         <?php echo $this->SetSelectCategory('category_city',$value['residecity'],'residecity'); ?>
    <?php } ?>
    </td>
  </tr>
  
  <tr>
    <td class="form_input_width_100 addtask_text">个人主页：</td>
    <td>
       <input name="homepage" type="text"  id="homepage" size="50" maxlength="255" class="form_input_text form_input_width_200"  value="<?php if (!empty($value['homepage'])){ ?><?php echo $value['homepage']; ?><?php } ?>"/>
    </td>
  </tr>  
  
  <tr>
    <td class="width_160"><strong>联系方式：</strong></td>
    <td></td>
  </tr>
  
   <tr>
    <td class="form_input_width_100 addtask_text">Email：</td>
    <td><input name="email" id="email" type="text" size="50" maxlength="255" class="form_input_text form_input_width_200"  value="<?php if ($value['email']){ ?><?php echo $value['email']; ?><?php } ?>" /></td>
  </tr> 

  <tr>
    <td class="form_input_width_100 addtask_text">MSN：</td>
    <td><input name="msn" id="msn" type="text" size="50" maxlength="50" class="form_input_text form_input_width_200"  value="<?php if ($value['msn']){ ?><?php echo $value['msn']; ?><?php } ?>"/></td>
  </tr> 
  
 <tr>
    <td class="form_input_width_100 addtask_text">QQ：</td>
    <td><input name="qq" id="qq" type="text" size="50" maxlength="50" class="form_input_text form_input_width_200"  value="<?php if ($value['qq']){ ?><?php echo $value['qq']; ?><?php } ?>"/></td>
 </tr>
  
 <tr>
    <td class="form_input_width_100 addtask_text">ICQ：</td>
    <td><input name="icq" id="icq" type="text" size="50" maxlength="50" class="form_input_text form_input_width_200"  value="<?php if ($value['icq']){ ?><?php echo $value['icq']; ?><?php } ?>"/></td>
  </tr>  
 
  
  <tr>
    <td class="form_input_width_100 addtask_text">固定电话：</td>
    <td><input name="phone" id="phone" type="text" size="50" maxlength="50" class="form_input_text form_input_width_200"  value="<?php if ($value['phone']){ ?><?php echo $value['phone']; ?><?php } ?>"/></td>
  </tr>  
  
  
    <tr>
    <td class="form_input_width_100 addtask_text">手机：</td>
    <td><input name="mobile" id="mobile" type="text" size="50" maxlength="50" class="form_input_text form_input_width_200" value="<?php if ($value['mobile']){ ?><?php echo $value['mobile']; ?><?php } ?>"/></td>
  </tr> 

</table>

<div class="phpapp_button"><input name="uid" type="hidden" value="<?php echo $id; ?>" /><input name="Submit" type="submit" value="确定" class="form_button"/></div>
</form>


<script type="text/javascript">
$(function(){	
		   
	 $("#SetMonth").change( function () {
									
		    GetDay();
								  
	 });

});


function GetDay() {
	
	         var  Year=$("#SetYear").val();
			 
			 var  Month=$("#SetMonth").val();
			 
			 var dayarr='';
			 
			 var date= new Date(Year,Month,0);
			 
			 var Day=date.getDate();
			 
			 for(var i=1;i<=Day;i++){
				 
				 if('<?php echo $day; ?>'==i){
					  var dayselected=' selected="selected"';
				 }else{
					  var dayselected='';
				 }
				 
				 dayarr+='<option value="'+i+'"'+dayselected+'>'+i+'</option>';
				   
			 }
			
			 
			 $("#SetDay").html(dayarr);
	
}

GetDay();


</script>