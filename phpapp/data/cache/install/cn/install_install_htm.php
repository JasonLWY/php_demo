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



<script type="text/javascript" src="<?php echo TURL; ?>js/default.js"></script>
<link href="<?php echo TURL; ?>default.css" rel="stylesheet" type="text/css" />

<style type="text/css">
.grid_slide{
	height: 360px;
}

</style>
<?php if ($issession){ ?>
    
    <div class="install_description">
           <div class="grid_slide" id="SlideList">
     
           <ul id="Slide" style="height:360px;overflow:hidden;">
               
                     <li id="Slide_IMG_1"><img src="./images/ad/grid_big_slide.jpg"/></li>
                     <li id="Slide_IMG_2"><img src="./images/ad/phpapp2_big_slide.jpg"/></li>

           </ul>
            
        </div>
        
        
         <div class="grid_slidetitle" id="SlideTitle">
               <ul>
              
                     <li id="Title_Slide_IMG_1" class="focus"><a href="javascript:;"></a></li>
                     <li id="Title_Slide_IMG_2"><a href="javascript:;"></a></li>
           
               </ul>
         </div>
    
                   
        <script type="text/javascript">
                   SetSlide('#SlideList','#Slide','#SlideTitle',4000);
        </script>
    </div>
    
    <div class="install_mysqldata">
        <div class="install_progress" id="InstallProgress"></div>
        
        <div class="install_percentage">安装进度 <span id="PercentageShow">0</span> %</div>
    </div>
    

<?php }else{ ?>

     <div class="install_wrong">很遗憾！您的空间不支持 SESSION 功能！请联系空间商在 php.ini 开启 SESSION,然后再安装!</div>
	
<?php } ?>



<?php if ($issession){ ?>


<p><a href="javascript:;" onclick="OpenInstallDetail()">[查看安装细节]</a></p>

<iframe width="0" height="0" name="main" style="display:none;" class="install_data"></iframe>
 

<script type="text/javascript">

$.PHPAPPOPENLOADING();

function GetInstallData(){
	iframe=window.parent.frames["main"];
	iframe.window.location.href='<?php echo SURL; ?>/install.php?step=3';
}

GetInstallData();

function OpenInstallDetail(){
	if($('.install_data').is(":hidden")){
		 $('.install_data').show();
	}else{
		 $('.install_data').hide();	
	}
}
</script>

<?php } ?>


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
