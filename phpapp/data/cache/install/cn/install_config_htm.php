<?php if(!defined('IN_PHPAPP')){exit('Data error');} ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo S_CHARSET; ?>" />

<meta http-equiv="X-UA-Compatible" content="IE=8" />

<title>PHPAPP2.5��װ</title>

<meta name="keywords" content="PHPAPP���ͳ���,����ϵͳ,���ͳ���,��Դ���ͳ���" />

<meta name="description" content="PHPAPP���ͳ���" />


<?php $siteframewidth=1000; ?>
<style type="text/css">
.wrap,.header_widescreen{
	width:<?php echo $siteframewidth; ?>px;
}
.header_width,.navigation_box,.footer{
	width:<?php echo $siteframewidth-80; ?>px;
}
.navigation_wrap{
	width:<?php echo $siteframewidth-90; ?>px;
}
.sw_categorys_nav .allcategorys .sublist {
	width:<?php echo $siteframewidth-102; ?>px;
}
.allcategorys .sublist li {
	width:<?php echo $siteframewidth/5; ?>px;
}
.user_list{
	width:<?php echo $siteframewidth-70; ?>px;
}
.user_box,.user_box_show{
	width:<?php echo $siteframewidth/4-30; ?>px;
}
</style>
</head>

<link rel="shortcut icon" href="<?php echo SURL; ?>/favicon.ico" />

<!-- CSS -->
<!-- Public -->
<link href="<?php echo TURL; ?>header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo TURL; ?>header_member.css" rel="stylesheet" type="text/css" />
<link href="<?php echo TURL; ?>dialog.css" rel="stylesheet" type="text/css" />
<link href="<?php echo TURL; ?>phpapp.css" rel="stylesheet" type="text/css" />
<link href="<?php echo TURL; ?>form.css" rel="stylesheet" type="text/css" />
<link href="<?php echo TURL; ?>credit.css" rel="stylesheet" type="text/css" />

<!-- poshytip -->
<link href="<?php echo TURL; ?>poshytip/tip-green/tip-green.css" rel="stylesheet" type="text/css" />
<link href="<?php echo TURL; ?>poshytip/tip-darkgray/tip-darkgray.css" rel="stylesheet" type="text/css" />

<!-- Category -->
<link href="<?php echo TURL; ?>category.css" rel="stylesheet" type="text/css" />

<!-- NationalFlag -->
<link href="<?php echo TURL; ?>nationalflag.css" rel="stylesheet" type="text/css" />

<!-- Widescreen ʹ�ÿ���ͷ��ɾ�� widescreen.css -->
<link href="<?php echo TURL; ?>widescreen.css" rel="stylesheet" type="text/css" />


<link href="<?php echo TURL; ?>install/css/install.css" rel="stylesheet" type="text/css" />

<body>

<!-- JS -->
<script type="text/javascript">
var SURL ='<?php echo SURL; ?>';
var TURL ='<?php echo TURL; ?>';
var Language='<?php echo $this->lang; ?>';
</script>


<!--  Public  -->
<script type="text/javascript" src="<?php echo TURL; ?>js/jquery.js?v=<?php echo $this->GetFileVersion(); ?>"></script>

<script type="text/javascript" src="<?php echo TURL; ?>js/dialog.js?v=<?php echo $this->GetFileVersion(); ?>"></script>
<!--  input  -->
<script type="text/javascript" src="<?php echo TURL; ?>js/input.js?v=<?php echo $this->GetFileVersion(); ?>"></script>

<script type="text/javascript" src="<?php echo TURL; ?>js/header.js?v=<?php echo $this->GetFileVersion(); ?>"></script>
<script type="text/javascript" src="<?php echo TURL; ?>js/phpapp.js?v=<?php echo $this->GetFileVersion(); ?>"></script>

<!-- poshytip -->
<script type="text/javascript" src="<?php echo TURL; ?>poshytip/jquery.poshytip.js?v=<?php echo $this->GetFileVersion(); ?>"></script>


<!-- Loading -->
<div id="TopLoading" style="display:none" title="loading..."></div>
<div id="loading" style="display:none" title="��ȡ������..."></div>




<div id="SiteBigWrap">  
   <div id="SiteMiddleWrap">
        <div id="SiteSmallWrap">

            <div id="Header">
                <div id="HeaderTop" class="header_default header_widescreen">  
                      <div class="header_width">  
                          <div class="header_before">
                              <div id="header_logo">
                                  <a href="<?php echo SURL; ?>" title="<?php echo PHPAPP::$config['sitename']; ?>"></a>
                              </div>
                               <div id="HeaderCity" class="header_city">
                                 վ���εĿ�ʼ������
                              </div>
                          </div>
                          
                          <div class="site_install">
                             PHPAPP��װ
                          </div>

                      </div>

                </div> <!--HeaderTop End-->


<div class="navigation_box">
         <div id="Navigation">  
              <div class="navigation_wrap">
              
                
                <div class="navigation">
                      <ul>   
               
                      <li><a href="<?php echo SURL; ?>/install.php">��װPHPAPP 2.5</a></li>
                      <li><a href="http://www.phpapp.cn/buy.html">������Ȩ</a></li>
                             
                      </ul>
                     
                </div> <!--navigation End-->
                
    
            </div>   <!--navigation_wrap End-->
    
     </div> <!--Navigation End-->

</div>


<div class="wrap">
<div class="content">


<form id="PHPAPPConfig">
<div class="phpapp_config">
<h2>������վ��Ϣ</h2>
<h5>���ݿ��������<span class="help_small" title="���ݿ��������ַ"> </span></h5>
<p><input name="dbhost" type="text"  id="dbhost" size="50" maxlength="100" class="form_input_text form_input_width_300"  value="<?php echo DB_HOST; ?>" title="���ݿ��������ַ"/>
</p>

<h5>���ݿ��û�����<span class="help_small" title="���ݿ��û���"> </span></h5>
<p><input name="dbuser" type="text"  id="dbuser" size="50" maxlength="100" class="form_input_text form_input_width_300"  value="<?php echo DB_USER; ?>" title="���ݿ��û���"/>
</p>

<h5>���ݿ����룺<span class="help_small" title="���ݿ�����"> </span></h5>
<p><input name="dbpw" type="text"  id="dbpw" size="50" maxlength="100" class="form_input_text form_input_width_300"  value="<?php echo DB_PW; ?>" title="���ݿ�����"/>
</p>

<h5>���ݿ�����<span class="help_small" title="���ݿ���"> </span></h5>
<p><input name="dbname" type="text"  id="dbname" size="50" maxlength="100" class="form_input_text form_input_width_300"  value="<?php echo DB_NAME; ?>" title="���ݿ���"/> <input name="dbtname" type="text"  id="dbtname" size="50" maxlength="100" class="form_input_text form_input_width_100"  value="<?php echo DB_TNAME; ?>" title="���ݿ��ǰ׺"/> ��ǰ׺
</p>

<h5>����Ա���ƣ�<span class="help_small" title="����Ա����"> </span></h5>
<p><input name="username" type="text"  id="username" size="50" maxlength="100" class="form_input_text form_input_width_300"  value="admin" title="����Ա����"/>
</p>


<h5>����Ա���룺<span class="help_small" title="����Ա����"> </span></h5>
<p><input name="password" type="text"  id="password" size="50" maxlength="100" class="form_input_text form_input_width_300"  value="admin" title="����Ա����"/>
</p>

<h5>����Ա���䣺<span class="help_small" title="����Ա����"> </span></h5>
<p><input name="email" type="text"  id="email" size="50" maxlength="100" class="form_input_text form_input_width_300"  value="admin@admin.com" title="����Ա����"/>
</p>


<div class="install_now" id="SubmitForm">
<input name="Submit" type="button" value="ȷ�����ð�װPHPAPP" onclick="SubmitConfig()" class="form_button" style="height:36px;"/>
</div>
<p id="SubmitLoadingForm" style="display:none;padding-top:20px;"></p>

</div>

</form>

<script type="text/javascript">

function Verifydbhost(isalert){

	  var dbhost=$("#dbhost");
	  if (dbhost.val()==""){
			dbhost.focus();
			if(isalert){
				alert("���������ݿ��������ַ!");
			}
			dbhost.poshytip('update','���������ݿ��������ַ!');
			return false; 
	  }
	  
	  dbhost.poshytip('update','���ݿ��������ַ�ϸ�!');
	  return true; 
	  
}

function Verifydbuser(isalert){

	  var dbuser=$("#dbuser");
	  if (dbuser.val()==""){
			dbuser.focus();
			if(isalert){
				alert("���������ݿ��û���!");
			}
			dbuser.poshytip('update','���������ݿ��û���!');
			return false; 
	  }
	  
	  dbuser.poshytip('update','���ݿ��û����ϸ�!');
	  return true; 
	  
}

function Verifydbpw(isalert){

	  var dbpw=$("#dbpw");
	  if (dbpw.val()==""){
			dbpw.focus();
			if(isalert){
				alert("���������ݿ�����!");
			}
			dbpw.poshytip('update','���������ݿ�����!');
			return false; 
	  }
	  
	  dbpw.poshytip('update','���ݿ�����ϸ�!');
	  return true; 
	  
}

function Verifydbname(isalert){

	  var dbname=$("#dbname");
	  if (dbname.val()==""){
			dbname.focus();
			if(isalert){
				alert("���������ݿ���!");
			}
			dbname.poshytip('update','���������ݿ���!');
			return false; 
	  }
	  
	  dbname.poshytip('update','���ݿ����ϸ�!');
	  return true; 
	  
}

function Verifydbtname(isalert){

	  var dbtname=$("#dbtname");
	  if (dbtname.val()==""){
			dbtname.focus();
			if(isalert){
				alert("���������ݿ��ǰ׺!");
			}
			dbtname.poshytip('update','���������ݿ��ǰ׺!');
			return false; 
	  }
	  
	  dbtname.poshytip('update','���ݿ��ǰ׺�ϸ�!');
	  return true; 
	  
}


function Verifyusername(isalert){

	  var username=$("#username");
	  if (username.val()==""){
			username.focus();
			if(isalert){
				alert("���������Ա����!");
			}
			username.poshytip('update','���������Ա����!');
			return false; 
	  }
	  
	  username.poshytip('update','����Ա���ƺϸ�!');
	  return true; 
	  
}

function Verifypassword(isalert){

	  var password=$("#password");
	  if (password.val()==""){
			password.focus();
			if(isalert){
				alert("���������Ա����!");
			}
			password.poshytip('update','���������Ա����!');
			return false; 
	  }
	  
	  password.poshytip('update','����Ա����ϸ�!');
	  return true; 
	  
}

function Verifyemail(isalert){

	  var email=$("#email");
	  if (email.val()==""){
			email.focus();
			if(isalert){
				alert("���������Ա����!");
			}
			email.poshytip('update','���������Ա����!');
			return false; 
	  }
	  
	  email.poshytip('update','����Ա����ϸ�!');
	  return true; 
	  
}


 $('#dbhost,#dbuser,#dbpw,#dbname,#dbtname,#username,#password,#email').poshytip({
		className: 'tip-green',
		showOn: 'focus',
		alignTo: 'target',
		alignX: 'right',
		alignY: 'center',
		offsetX: 5
  });
 

$("#dbhost").blur( function () { 
	  
		return Verifydbhost(0);
});

$("#dbuser").blur( function () { 
	  
		return Verifydbuser(0);
});

$("#dbpw").blur( function () { 
	  
		return Verifydbpw(0);
});

$("#dbname").blur( function () { 
	  
		return Verifydbname(0);
});
	
$("#dbtname").blur( function () { 
	  
		return Verifydbtname(0);
});


$("#username").blur( function () { 
	  
		return Verifyusername(0);
});


$("#password").blur( function () { 
	  
		return Verifypassword(0);
});

$("#email").blur( function () { 
	  
		return Verifyemail(0);
});

	 
function SubmitConfig() {
	          
	  if(!Verifydbhost(1)){
		   return false;  
	  }
	  
	  if(!Verifydbuser(1)){
		   return false;  
	  }
	 
	  if(!Verifydbpw(1)){
		   return false;  
	  }
	  
	  if(!Verifydbname(1)){
		   return false;  
	  }
	  
	  if(!Verifydbtname(1)){
		   return false;  
	  }
	  
	  if(!Verifyusername(1)){
		   return false;  
	  }
	  
	  if(!Verifypassword(1)){
		   return false;  
	  }
	  
	  if(!Verifyemail(1)){
		   return false;  
	  }

	  SubmitConfigData();
	 
}
	 
	  
function SubmitConfigData(){
	  $.PHPAPPOPENLOADING();

	  //POST
	  $("#SubmitLoadingForm").html('<div class="loading_big">�벻Ҫ�رմ���,�ύ������...</div>');
	  $('#SubmitLoadingForm').show();
	  $("#SubmitForm").hide();
	  
	   var forms=GetFormAll('#PHPAPPConfig');	
	   
	  $.ajax({
   			type: "POST",
   			url: SURL+"/install.php?step=1",
  		    data: forms+'&Submit=1',
   			success: function(data){
		
				  $.PHPAPPCLOSELOADING();
				  $('#SubmitLoadingForm').hide();
				  $('#SubmitForm').show();
				  if(data==1){
					   alert('���Ѿ���װ��PHPAPP������,�������װ��ɾ�� /phpapp/data/install.lock �ļ���������Ӧ�ð���');
				  }else if(data==2){
					   alert('����PHP�����������汾̫����,���Ҫ��汾 PHP 5.2');
					  
				  }else if(data==3){
					    
					   //$('#dbhost').poshytip('update','���ݿ��ַ�޷����ӳɹ�,�������ݿ��ַ�Ƿ�����!');
					   
					   //$('#dbuser').poshytip('update','���ݿ��ַ�޷����ӳɹ�,�������ݿ��û����Ƿ�����!');
					
					   $('#dbpw').poshytip('update','���ݿ��޷����ӳɹ�,�������ݿ��ַ,�û���,�����Ƿ�����');
					   $('#dbpw').focus();
				  }else if(data==4){
					   $('#dbname').poshytip('update','���ݿ��Ѵ��ڣ����ֶ�ɾ�������ݿ���������ݿ����ƽ��в�����');
					   $('#dbname').focus();
						
				  }else if(data=='ok'){
					   window.location.href=SURL+'/install.php?step=2';
				  }
   			}
	  });

	
	
}


</script>


                     </div> <!--content End-->
                 </div> <!--wrap End-->
                 
                 <div id="Footer" class="footer">   
                      <div class="footermenu">
                            <div class="footermenulist">
                               <ul>
                                     
                                     <li><a href="http://www.phpapp.cn/product.html" title="PHPAPP��Ʒ����">PHPAPP��Ʒ����</a></li>
                                     
                                     <li><a href=" http://demo.phpapp.cn" title="PHPAPP���ͳ�����ʾ">���ͳ�����ʾ</a></li>
                                    
                                     <li><a href="http://www.phpapp.cn/buy.html">������Ȩ</a></li>
                                     
                                     <li><a href="http://www.phpapp.cn/help.html">���߰���</a></li>
                                     
                                     <li><a href="http://bbs.phpapp.cn">PHPAPP�ٷ�����</a></li>
                                     
                               </ul>
                            </div>
                            
                          
                       </div>
                       
                       <div class="footercopyright">
                            <div class="copyright">
                                <p>
                                &copy; 2006-<?php echo $this->Date("Y",$this->NowTime()); ?> <?php if (!intval(PHPAPP::$config['phpappauth'])){ ?><a href="http://www.phpapp.cn" target="_blank">PHPAPP.CN ��Ȩ����</a> 2.5 Beta <?php }else{ ?> <a href="<?php echo SURL; ?>"><?php echo PHPAPP::$config['sitename']; ?></a> <?php } ?> <?php echo $this->SystemRunTime(); ?>
                                </p>
                                
                                <p>
                                ������ѯQQ�� 1468078656
                                </p>
                                
                                <p>
                                <?php if (PHPAPP::$config['siteicp']){ ?><a href="http://www.miibeian.gov.cn" target="_blank"><?php echo PHPAPP::$config['siteicp']; ?></a><?php } ?> 
                                <?php if (PHPAPP::$config['sitecount']){ ?><?php echo PHPAPP::$config['sitecount']; ?><?php } ?>
                                </p>

                            
                            </div>
                            
                            <div class="footerauthenticate">
                                <a href="http://www.alipay.com" title="֧����" class="footeralipay"></a>
                                <a href="" title="����ע��" class="footergongshang"></a>
                                <a href="http://cnnic.cn" title="������վ��֤" class="footercnnic"></a>
                            </div>
                       </div>
                       
                       
                       
                           
                 </div> <!--Footer End-->

 
             </div> <!--SiteSmallWrap End-->
         </div> <!--SiteMiddleWrap End-->
     </div> <!--SiteBigWrap End-->
     
     
     <div id="ScrollUp" class="scroll_default">
     	<a id="TipScrollUp" href="javascript:;" onclick="scrollTo(0,0);" title="���ض���"></a>
     </div>
     
     <div id="POPLIVE" class="pop_live">
     </div>
     
  </body>
</html>
