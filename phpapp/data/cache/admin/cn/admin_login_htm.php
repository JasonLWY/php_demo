<?php if(!defined('IN_PHPAPP')){exit('Data error');} ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo S_CHARSET; ?>" />
<title>PHPAPP��̨��¼</title>
<head>
    <link rel="stylesheet" href="<?php echo TURL; ?>admin_login.css">
    <link rel="stylesheet" href="<?php echo TURL; ?>form.css">
</head>

<body>

<script type="text/javascript" src="<?php echo TURL; ?>js/jquery.js?v=<?php echo $this->GetFileVersion(); ?>"></script>
<script type="text/javascript" src="<?php echo TURL; ?>js/table.js?v=<?php echo $this->GetFileVersion(); ?>"></script>
<script type="text/javascript" src="<?php echo TURL; ?>js/input.js?v=<?php echo $this->GetFileVersion(); ?>"></script>
<script type="text/javascript" src="<?php echo TURL; ?>js/dialog.js?v=<?php echo $this->GetFileVersion(); ?>"></script>
<script type="text/javascript" src="<?php echo TURL; ?>js/phpapp.js?v=<?php echo $this->GetFileVersion(); ?>"></script>

<script type="text/javascript">

function seccode(){
	 var img='index.php?app=2&action=9&rand='+Math.random();
	 $('#ShowSecCode').html('<a href="javascript:;" onclick="refreshcode()" style="cursor:hand;" title="�����һ����֤��"><img id="img_seccode" src="'+img+'" align="absmiddle"></a>');
	 $("#SecCode").val("");
}

function refreshcode() {
	
	var img = 'index.php?app=2&action=9&rand='+Math.random();
	if(document.getElementById('img_seccode')) {
		$('#img_seccode').attr("src",img);
	}
}

function GetSecCode(){
	seccode();
}


function SubmitLogin(){
		  var LoginUserName=$("#LoginUserName");
		  if (LoginUserName.val()==""){
				alert("�������û���!");
				LoginUserName.focus();
				return false; 
		  }
		  
		  if (LoginUserName.val().length<2){
				alert("�û���������������������!");
				LoginUserName.focus();
				return false; 
		  }
		  
		  var LoginPassword=$("#LoginPassword");
		  if (LoginPassword.val()==""){
				alert("����������!");
				LoginPassword.focus();
				return false; 
		  }
		  
		  if (LoginPassword.val().length<5){
				alert("���볤����������������!");
				LoginPassword.focus();
				return false; 
		  }
		  
		  var SecCode=$("#SecCode");
		  if (SecCode.val()==""){
				alert("��������֤��!");
				SecCode.focus();
				return false; 
		  }
		  
		  if (SecCode.val().length!=4){
				alert("��֤�볤����������������!");
				SecCode.focus();
				return false; 
		  }

}

</script>

<div class="login">
<h2>��̨��¼</h2>
<ul>
<form action="<?php echo $admindir; ?>" method="post">
  <li><label class="form_input_label" id="UserNameLabel">�û�����</label> <input name="UserName_s" id="LoginUserName" type="text" maxlength="80"  class="form_input_text form_input_width_150 loginusername" autocomplete="off" value=""/><span id="AjaxUserNameError"></span></li>
      
  <li><label class="form_input_label">���룺</label> <input name="Password_s" id="LoginPassword" type="password" maxlength="32"  class="form_input_text form_input_width_150" autocomplete="off" value=""/><span id="AjaxPasswordError"></span></li>
   
   <?php if (PHPAPP::$config['adminloginiscode']){ ?>
       <?php if (!PHPAPP::$config['siteclose']){ ?>
       <li style="width:368px;"><label class="form_input_label">��֤�룺</label> <input name="SecCode" id="SecCode" type="text" maxlength="4" onclick="GetSecCode();" class="form_input_text" style="width:120px;float:left;" value="���������ʾ��֤��"/><div id="ShowSecCode"></div></li>
       <?php } ?>
   <?php } ?>
   
   <li>
   <label class="form_input_label">��¼ʱ�䣺</label>
   <select name="CookieTime">
       <option value="86400">����1��</option>
       <option value="259200">����3��</option>
       <option value="31104000">���ñ���</option>
       <option value="10">������</option>
   </select>

   </li>
   <?php if ($isadminfile){ ?><li class="adminfile" style="height:16px;">��ʾ��Ϊ�˰�ȫ�������޸ĺ�̨�ļ�����!</li><?php } ?>
   
   <li style="text-align:center;height:32px;padding-top:6px;"><input name="Submit" type="submit" onclick="return SubmitLogin();" value="��¼" class="login_submit" style="height:32px;"/></li>
   
   <input type="hidden" name="SecurityForm_s" value="<?php echo $this->SecurityForm(); ?>"/>
   
</form>  
</ul>
</div>
</body>
</html>
