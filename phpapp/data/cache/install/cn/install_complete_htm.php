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


<div class="install_complete">
<h2>��ϲ������װ��ɣ���л����װPHPAPP��</h2>
    <ul>
        <li>
        <a href="<?php echo SURL; ?>">��ҳ��ַ <?php echo SURL; ?></a>
        </li>
        
        <li>
        <a href="<?php echo SURL; ?>/admin.php">��̨��ַ <?php echo SURL; ?>/admin.php</a>
        </li>
        
        <li>
           <p style="color:#F60">��ʾ������ɾ�����ļ� install.php ,Ȼ���¼��̨����Ҫ��������,�û���Ȩ�޼�α��̬�Ȳ����»��棡(��¼��̨��ˢ��һ�κ�̨)</p>
        </li>
    </ul>
</div>

<div class="install_now">
<a href="<?php echo SURL; ?>" class="large blue awesome" title="������ҳ" style="margin-right:10px;" target="_blank">������ҳ</a>

<a href="<?php echo SURL; ?>/admin.php" class="large green awesome" title="���ʺ�̨" target="_blank">���ʺ�̨</a>

</div>






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
