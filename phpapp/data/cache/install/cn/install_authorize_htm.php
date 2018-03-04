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


<form action="install.php" method="post">
<div class="phpapp_agreement">
<h2>PHPAPP安装协议</h2>
<ul>
<p>
<strong>PHPAPP 软件使用协议</strong></p>
<p>&nbsp;</p>
<p>感谢您使用 PHPAPP威客产品。希望我们的产品能为您提供一个高效快速和强大成熟的威客网站解决方案。</p>
<p>产品名称 PHPAPP威客网站管理系统，以下简称 PHPAPP</p>
<br />
<p>PHPAPP开发商依法独立拥有 PHPAPP 产品著作权（<strong>中国国家版权局著作权登记号 2010SR054257）保留所有权利.</strong></p>
<p>PHPAPP官方网址为 http://www.phpapp.cn</p>
<p>PHPAPP 著作权已在中华人民共和国国家版权局注册，著作权受到法律和国际公约保护。</p>
<p>使用者：无论个人或组织、盈利与否、用途如何（包括以学习和研究为目的），均需仔细阅读本协议，在理解、同意、并遵守本协议的全部条款后，方可开始使用 PHPAPP   软件。</p>
<br />
<p>本授权协议适用且仅适用于 PHPAPP 所有版本，PHPAPP团队拥有对本授权协议的最终解释权。</p>
<br />
<p><strong>一.协议许可的权利 </strong></p>
<p>1.您可以在完全遵守本最终用户授权协议的基础上，将本软件应用于非商业用途，而不必支付软件版权授权费用。</p>
<p>2.您可以在协议规定的约束和限制范围内修改 PHPAPP 源代码(如果被提供的话)或界面风格以适应您的网站要求。</p>
<p>3.您拥有使用本软件构建的网站中全部会员资料、文章及相关信息的所有权，并独立承担与文章内容的相关法律义务。</p>
<p>4.获得商业授权之后，您可以将本软件应用于商业用途，同时依据所购买的授权类型中确定的技术支持期限、技术支持方式和技术支持内容，自购买时刻起，在技术支持期限内拥有通过指定的方式获得指定范围内的技术支持服务。商业授权用户享有反映和提出意见的权力，相关意见将被作为首要考虑，但没有一定被采纳的承诺或保证。</p>
<br />
<p><strong>二.协议规定的约束和限制 </strong></p>
<p>1.未获商业授权之前，不得将本软件用于商业用途（包括但不限于企业网站、经营性网站、以营利为目或实现盈利的网站）。购买商业授权请登陆http://www.phpapp.cn   参考相关说明，也可以致电13277759093了解详情。</p>
<p>2.不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。 </p>
<p>3.无论如何，即无论用途如何、是否经过修改或美化、修改程度如何，只要使用 PHPAPP 的整体或任何部分，未经书面许可，威客网站页面页脚处的 PHPAPP   名称和PHPAPP官方网站 http://www.phpapp.cn 的链接都必须保留，而不能清除或修改。</p>
<p>4.禁止在 PHPAPP 的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。</p>
<p>5.如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回，并承担相应法律责任。</p>
<br />
<p><strong>三.有限担保和免责声明 </strong></p>
<p>1.本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。</p>
<p>2.用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任。</p>
<p>3.PHPAPP官方不对使用本软件构建的网站中的文章或信息承担责任。有关 PHPAPP 最终用户授权协议、商业授权与技术服务的详细内容，均由 PHPAPP   官方网站独家提供。PHPAPP官方拥有在不事先通知的情况下，修改授权协议和服务价目表的权力，修改后的协议或价目表对自改变之日起的新授权用户生效。</p>
<p>4、如果本软件带有其它软件的整合API接口包，这些文件版权不属于PHPAPP官方，请参考相关软件的使用许可合法的使用。</p>
<br />
<p>电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始安装   PHPAPP，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。</p>
</ul>
</div>

<div class="install_now">
<input name="Submit" type="submit" value="我同意协议" class="form_button" style="height:36px;margin-right:10px;"/>

<input type="button" value="我不同意协议" onclick="InstallClose()" class="form_general_button" style="height:36px;"/> 

</div>

</form>

<script type="text/javascript">	 
function InstallClose() {
	 window.location.href="http://www.phpapp.cn";
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
