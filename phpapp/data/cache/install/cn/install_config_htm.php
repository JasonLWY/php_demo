<?php if(!defined('IN_PHPAPP')){exit('Data error');} ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo S_CHARSET; ?>" />

<meta http-equiv="X-UA-Compatible" content="IE=8" />

<title>PHPAPP2.5安装</title>

<meta name="keywords" content="PHPAPP威客程序,威客系统,威客程序,开源威客程序" />

<meta name="description" content="PHPAPP威客程序" />


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

<!-- Widescreen 使用宽屏头部删除 widescreen.css -->
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
<div id="loading" style="display:none" title="读取数据中..."></div>




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
                                 站长梦的开始！！！
                              </div>
                          </div>
                          
                          <div class="site_install">
                             PHPAPP安装
                          </div>

                      </div>

                </div> <!--HeaderTop End-->


<div class="navigation_box">
         <div id="Navigation">  
              <div class="navigation_wrap">
              
                
                <div class="navigation">
                      <ul>   
               
                      <li><a href="<?php echo SURL; ?>/install.php">安装PHPAPP 2.5</a></li>
                      <li><a href="http://www.phpapp.cn/buy.html">购买授权</a></li>
                             
                      </ul>
                     
                </div> <!--navigation End-->
                
    
            </div>   <!--navigation_wrap End-->
    
     </div> <!--Navigation End-->

</div>


<div class="wrap">
<div class="content">


<form id="PHPAPPConfig">
<div class="phpapp_config">
<h2>配置网站信息</h2>
<h5>数据库服务器：<span class="help_small" title="数据库服务器地址"> </span></h5>
<p><input name="dbhost" type="text"  id="dbhost" size="50" maxlength="100" class="form_input_text form_input_width_300"  value="<?php echo DB_HOST; ?>" title="数据库服务器地址"/>
</p>

<h5>数据库用户名：<span class="help_small" title="数据库用户名"> </span></h5>
<p><input name="dbuser" type="text"  id="dbuser" size="50" maxlength="100" class="form_input_text form_input_width_300"  value="<?php echo DB_USER; ?>" title="数据库用户名"/>
</p>

<h5>数据库密码：<span class="help_small" title="数据库密码"> </span></h5>
<p><input name="dbpw" type="text"  id="dbpw" size="50" maxlength="100" class="form_input_text form_input_width_300"  value="<?php echo DB_PW; ?>" title="数据库密码"/>
</p>

<h5>数据库名：<span class="help_small" title="数据库名"> </span></h5>
<p><input name="dbname" type="text"  id="dbname" size="50" maxlength="100" class="form_input_text form_input_width_300"  value="<?php echo DB_NAME; ?>" title="数据库名"/> <input name="dbtname" type="text"  id="dbtname" size="50" maxlength="100" class="form_input_text form_input_width_100"  value="<?php echo DB_TNAME; ?>" title="数据库表前缀"/> 表前缀
</p>

<h5>管理员名称：<span class="help_small" title="管理员名称"> </span></h5>
<p><input name="username" type="text"  id="username" size="50" maxlength="100" class="form_input_text form_input_width_300"  value="admin" title="管理员名称"/>
</p>


<h5>管理员密码：<span class="help_small" title="管理员密码"> </span></h5>
<p><input name="password" type="text"  id="password" size="50" maxlength="100" class="form_input_text form_input_width_300"  value="admin" title="管理员密码"/>
</p>

<h5>管理员邮箱：<span class="help_small" title="管理员邮箱"> </span></h5>
<p><input name="email" type="text"  id="email" size="50" maxlength="100" class="form_input_text form_input_width_300"  value="admin@admin.com" title="管理员邮箱"/>
</p>


<div class="install_now" id="SubmitForm">
<input name="Submit" type="button" value="确认配置安装PHPAPP" onclick="SubmitConfig()" class="form_button" style="height:36px;"/>
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
				alert("请输入数据库服务器地址!");
			}
			dbhost.poshytip('update','请输入数据库服务器地址!');
			return false; 
	  }
	  
	  dbhost.poshytip('update','数据库服务器地址合格!');
	  return true; 
	  
}

function Verifydbuser(isalert){

	  var dbuser=$("#dbuser");
	  if (dbuser.val()==""){
			dbuser.focus();
			if(isalert){
				alert("请输入数据库用户名!");
			}
			dbuser.poshytip('update','请输入数据库用户名!');
			return false; 
	  }
	  
	  dbuser.poshytip('update','数据库用户名合格!');
	  return true; 
	  
}

function Verifydbpw(isalert){

	  var dbpw=$("#dbpw");
	  if (dbpw.val()==""){
			dbpw.focus();
			if(isalert){
				alert("请输入数据库密码!");
			}
			dbpw.poshytip('update','请输入数据库密码!');
			return false; 
	  }
	  
	  dbpw.poshytip('update','数据库密码合格!');
	  return true; 
	  
}

function Verifydbname(isalert){

	  var dbname=$("#dbname");
	  if (dbname.val()==""){
			dbname.focus();
			if(isalert){
				alert("请输入数据库名!");
			}
			dbname.poshytip('update','请输入数据库名!');
			return false; 
	  }
	  
	  dbname.poshytip('update','数据库名合格!');
	  return true; 
	  
}

function Verifydbtname(isalert){

	  var dbtname=$("#dbtname");
	  if (dbtname.val()==""){
			dbtname.focus();
			if(isalert){
				alert("请输入数据库表前缀!");
			}
			dbtname.poshytip('update','请输入数据库表前缀!');
			return false; 
	  }
	  
	  dbtname.poshytip('update','数据库表前缀合格!');
	  return true; 
	  
}


function Verifyusername(isalert){

	  var username=$("#username");
	  if (username.val()==""){
			username.focus();
			if(isalert){
				alert("请输入管理员名称!");
			}
			username.poshytip('update','请输入管理员名称!');
			return false; 
	  }
	  
	  username.poshytip('update','管理员名称合格!');
	  return true; 
	  
}

function Verifypassword(isalert){

	  var password=$("#password");
	  if (password.val()==""){
			password.focus();
			if(isalert){
				alert("请输入管理员密码!");
			}
			password.poshytip('update','请输入管理员密码!');
			return false; 
	  }
	  
	  password.poshytip('update','管理员密码合格!');
	  return true; 
	  
}

function Verifyemail(isalert){

	  var email=$("#email");
	  if (email.val()==""){
			email.focus();
			if(isalert){
				alert("请输入管理员邮箱!");
			}
			email.poshytip('update','请输入管理员邮箱!');
			return false; 
	  }
	  
	  email.poshytip('update','管理员邮箱合格!');
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
	  $("#SubmitLoadingForm").html('<div class="loading_big">请不要关闭窗口,提交数据中...</div>');
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
					   alert('您已经安装过PHPAPP程序了,如果想重装请删除 /phpapp/data/install.lock 文件，和其它应用包！');
				  }else if(data==2){
					   alert('您的PHP服务器环境版本太低了,最代要求版本 PHP 5.2');
					  
				  }else if(data==3){
					    
					   //$('#dbhost').poshytip('update','数据库地址无法链接成功,请检查数据库地址是否有误!');
					   
					   //$('#dbuser').poshytip('update','数据库地址无法链接成功,请检查数据库用户名是否有误!');
					
					   $('#dbpw').poshytip('update','数据库无法链接成功,请检查数据库地址,用户名,密码是否有误！');
					   $('#dbpw').focus();
				  }else if(data==4){
					   $('#dbname').poshytip('update','数据库已存在！请手动删除该数据库或换其它数据库名称进行操作！');
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
                                     
                                     <li><a href="http://www.phpapp.cn/product.html" title="PHPAPP产品介绍">PHPAPP产品介绍</a></li>
                                     
                                     <li><a href=" http://demo.phpapp.cn" title="PHPAPP威客程序演示">威客程序演示</a></li>
                                    
                                     <li><a href="http://www.phpapp.cn/buy.html">购买授权</a></li>
                                     
                                     <li><a href="http://www.phpapp.cn/help.html">在线帮助</a></li>
                                     
                                     <li><a href="http://bbs.phpapp.cn">PHPAPP官方社区</a></li>
                                     
                               </ul>
                            </div>
                            
                          
                       </div>
                       
                       <div class="footercopyright">
                            <div class="copyright">
                                <p>
                                &copy; 2006-<?php echo $this->Date("Y",$this->NowTime()); ?> <?php if (!intval(PHPAPP::$config['phpappauth'])){ ?><a href="http://www.phpapp.cn" target="_blank">PHPAPP.CN 版权所有</a> 2.5 Beta <?php }else{ ?> <a href="<?php echo SURL; ?>"><?php echo PHPAPP::$config['sitename']; ?></a> <?php } ?> <?php echo $this->SystemRunTime(); ?>
                                </p>
                                
                                <p>
                                在线咨询QQ： 1468078656
                                </p>
                                
                                <p>
                                <?php if (PHPAPP::$config['siteicp']){ ?><a href="http://www.miibeian.gov.cn" target="_blank"><?php echo PHPAPP::$config['siteicp']; ?></a><?php } ?> 
                                <?php if (PHPAPP::$config['sitecount']){ ?><?php echo PHPAPP::$config['sitecount']; ?><?php } ?>
                                </p>

                            
                            </div>
                            
                            <div class="footerauthenticate">
                                <a href="http://www.alipay.com" title="支付宝" class="footeralipay"></a>
                                <a href="" title="工商注册" class="footergongshang"></a>
                                <a href="http://cnnic.cn" title="可信网站认证" class="footercnnic"></a>
                            </div>
                       </div>
                       
                       
                       
                           
                 </div> <!--Footer End-->

 
             </div> <!--SiteSmallWrap End-->
         </div> <!--SiteMiddleWrap End-->
     </div> <!--SiteBigWrap End-->
     
     
     <div id="ScrollUp" class="scroll_default">
     	<a id="TipScrollUp" href="javascript:;" onclick="scrollTo(0,0);" title="返回顶部"></a>
     </div>
     
     <div id="POPLIVE" class="pop_live">
     </div>
     
  </body>
</html>
