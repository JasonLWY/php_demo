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

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist" >
  <tr>
    <td class="datalist_h2 width_160">��Ŀ</td>
    <td class="datalist_h2">����ֵ</td>
  </tr>
  
  <tr>
    <td class="width_160">�û���</td>
    <td><?php echo $value['username']; ?></td>
  </tr>
  
   <tr>
    <td class="width_160">��ǰͷ��</td>
    <td style="padding-top:10px;padding-bottom:10px;"><?php echo $this->GetUserAvatar($value['uid'],1,1); ?></td>
  </tr>
  
  <tr>
    <td class="width_160"><strong>��ȫ��Ϣ��</strong></td>
    <td></td>
  </tr>
  
   <tr>
    <td class="width_160">���������ã�</td>
    <td><input name="password_s" type="password" class="form_input_text form_input_width_200" value=""/></td>
  </tr>
  
  <tr>
    <td class="width_160">��ȫ�������ã�</td>
    <td><input name="safeemail_s" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['safeemail'])){ ?><?php echo $value['safeemail']; ?><?php } ?>"/></td>
  </tr>
  
  
  <tr>
    <td class="width_160"><strong>������Ϣ��</strong></td>
    <td></td>
  </tr>


  <tr>
    <td class="width_160">�����ٶ����֣�</td>
    <td><input name="speed_f" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['speed'])){ ?><?php echo $value['speed']; ?><?php } ?>"/> 5 �����</td>
  </tr>
  
    <tr>
    <td class="width_160">����̬�����֣�</td>
    <td><input name="attitude_f" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['attitude'])){ ?><?php echo $value['attitude']; ?><?php } ?>"/> 5 �����</td>
  </tr>
  
   <tr>
    <td class="width_160">�����������֣�</td>
    <td><input name="quality_f" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['quality'])){ ?><?php echo $value['quality']; ?><?php } ?>"/> 5 �����</td>
  </tr>
  
   <tr>
    <td class="width_160"><strong>�û�����Ϣ��</strong></td>
    <td></td>
  </tr>

  
  <tr>
    <td class="width_160">�û����ͣ�</td>
    <td><select name="usertype_d">
        <?php foreach ($membertype as $type){ ?>
          <option value="<?php echo $type['id_phpapp']; ?>" <?php if ($value['usertype']==$type['id_phpapp']){ ?> selected="selected" <?php } ?>><?php echo $type['name_phpapp']; ?></option>
        <?php } ?>
        </select>
    </td>
  </tr>
    
    <tr>
    <td class="width_160">��̨�����飺</td>
    <td><select name="admingroup_d">
         <option value="0">��</option>
        <?php foreach ($adminusergroup as $ausergroup){ ?>
          <option value="<?php echo $ausergroup['id_phpapp']; ?>" <?php if ($value['admingroup']==$ausergroup['id_phpapp']){ ?> selected="selected" <?php } ?>><?php echo $ausergroup['name_phpapp']; ?></option>
        <?php } ?>
        </select>
    </td>
  </tr>
  
  <tr>
    <td class="width_160">ǰ̨�û��飺</td>
    <td><select name="usergroup_d">
        <?php foreach ($usergroup as $group){ ?>
          <option value="<?php echo $group['gid']; ?>" <?php if ($value['usergroup']==$group['gid']){ ?> selected="selected" <?php } ?>><?php echo $group['groupname']; ?></option>
        <?php } ?>
        </select>
    </td>
  </tr>
  
   <tr>
    <td class="width_160"><strong>�ƹ���Ϣ��</strong></td>
    <td></td>
  </tr>
  
  <tr>
    <td class="width_160">�ƹ�Ա��</td>
    <td> <input name="unionid_d" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['unionid'])){ ?><?php echo $value['unionid']; ?><?php } ?>"/></td>
  </tr>
  
   <tr>
    <td class="width_160">�ƹ����ʱ�䣺</td>
    <td> <input name="uniontime_s" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['uniontime'])){ ?><?php echo $this->Date('Y-m-d',$value['uniontime']); ?><?php } ?>"/> ��ʽ 2012-12-31 (����Сʱ����Ĭ�� 0:00:00)</td>
  </tr>

  
  <tr>
    <td class="width_160"><strong>������Ϣ��</strong></td>
    <td></td>
  </tr>
  
  
  <tr>
    <td class="width_160">������</td>
    <td> <input name="money_f" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['money'])){ ?><?php echo $value['money']; ?><?php } ?>"/> Ԫ</td>
  </tr>


  <tr>
    <td class="width_160">�����</td>
    <td> <input name="lock_f" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['lock'])){ ?><?php echo $value['lock']; ?><?php } ?>"/> Ԫ</td>
  </tr>
  
  <tr>
    <td class="width_160">�ƹ���ɣ�</td>
    <td> <input name="union_f" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['union'])){ ?><?php echo $value['union']; ?><?php } ?>"/> Ԫ</td>
  </tr>
  
  <tr>
    <td class="width_160">�Ƹ���</td>
    <td> <input name="wealth_f" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['wealth'])){ ?><?php echo $value['wealth']; ?><?php } ?>"/> Ԫ</td>
  </tr>
  
  <tr>
    <td class="width_160"><strong>������Ϣ��</strong></td>
    <td></td>
  </tr>
  
  <tr>
    <td class="width_160">���֣�</td>
    <td> <input name="credit_d" type="text" class="form_input_text form_input_width_200" value="<?php if (!empty($value['credit'])){ ?><?php echo $value['credit']; ?><?php } ?>"/></td>
  </tr>
  
  <tr>
    <td class="form_input_width_100 addtask_text">�Ա�</td>
    <td>
    <select name="gender">
        <option value="0"<?php if ($value['gender']==0){ ?> selected="selected"<?php } ?>>����</option><option value="1"<?php if ($value['gender']==1){ ?> selected="selected"<?php } ?>>��</option><option value="2"<?php if ($value['gender']==2){ ?> selected="selected"<?php } ?>>Ů</option>
    </select>
    </td>
  </tr>
  
  <tr>
    <td class="form_input_width_100 addtask_text">���գ�</td>
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
    <td class="form_input_width_100 addtask_text">�����أ�</td>
    <td id="birthcity">
    <?php if ($value['birthcity']){ ?>
         <?php echo $this->GetSelectCategory('category_city',$value['birthcity'],'birthcity'); ?>
    <?php }else{ ?> 
         <?php echo $this->SetSelectCategory('category_city',$value['birthcity'],'birthcity'); ?>
    <?php } ?>
    </td>
  </tr>
  
  <tr>
    <td class="form_input_width_100 addtask_text">���ڵأ�</td>
    <td id="residecity">
    <?php if ($value['residecity']){ ?>
         <?php echo $this->GetSelectCategory('category_city',$value['residecity'],'residecity'); ?>
    <?php }else{ ?> 
         <?php echo $this->SetSelectCategory('category_city',$value['residecity'],'residecity'); ?>
    <?php } ?>
    </td>
  </tr>
  
  <tr>
    <td class="form_input_width_100 addtask_text">������ҳ��</td>
    <td>
       <input name="homepage" type="text"  id="homepage" size="50" maxlength="255" class="form_input_text form_input_width_200"  value="<?php if (!empty($value['homepage'])){ ?><?php echo $value['homepage']; ?><?php } ?>"/>
    </td>
  </tr>  
  
  <tr>
    <td class="width_160"><strong>��ϵ��ʽ��</strong></td>
    <td></td>
  </tr>
  
   <tr>
    <td class="form_input_width_100 addtask_text">Email��</td>
    <td><input name="email" id="email" type="text" size="50" maxlength="255" class="form_input_text form_input_width_200"  value="<?php if ($value['email']){ ?><?php echo $value['email']; ?><?php } ?>" /></td>
  </tr> 

  <tr>
    <td class="form_input_width_100 addtask_text">MSN��</td>
    <td><input name="msn" id="msn" type="text" size="50" maxlength="50" class="form_input_text form_input_width_200"  value="<?php if ($value['msn']){ ?><?php echo $value['msn']; ?><?php } ?>"/></td>
  </tr> 
  
 <tr>
    <td class="form_input_width_100 addtask_text">QQ��</td>
    <td><input name="qq" id="qq" type="text" size="50" maxlength="50" class="form_input_text form_input_width_200"  value="<?php if ($value['qq']){ ?><?php echo $value['qq']; ?><?php } ?>"/></td>
 </tr>
  
 <tr>
    <td class="form_input_width_100 addtask_text">ICQ��</td>
    <td><input name="icq" id="icq" type="text" size="50" maxlength="50" class="form_input_text form_input_width_200"  value="<?php if ($value['icq']){ ?><?php echo $value['icq']; ?><?php } ?>"/></td>
  </tr>  
 
  
  <tr>
    <td class="form_input_width_100 addtask_text">�̶��绰��</td>
    <td><input name="phone" id="phone" type="text" size="50" maxlength="50" class="form_input_text form_input_width_200"  value="<?php if ($value['phone']){ ?><?php echo $value['phone']; ?><?php } ?>"/></td>
  </tr>  
  
  
    <tr>
    <td class="form_input_width_100 addtask_text">�ֻ���</td>
    <td><input name="mobile" id="mobile" type="text" size="50" maxlength="50" class="form_input_text form_input_width_200" value="<?php if ($value['mobile']){ ?><?php echo $value['mobile']; ?><?php } ?>"/></td>
  </tr> 

</table>

<div class="phpapp_button"><input name="uid" type="hidden" value="<?php echo $id; ?>" /><input name="Submit" type="submit" value="ȷ��" class="form_button"/></div>
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