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


<form action="install.php" method="post">
<div class="phpapp_agreement">
<h2>PHPAPP��װЭ��</h2>
<ul>
<p>
<strong>PHPAPP ���ʹ��Э��</strong></p>
<p>&nbsp;</p>
<p>��л��ʹ�� PHPAPP���Ͳ�Ʒ��ϣ�����ǵĲ�Ʒ��Ϊ���ṩһ����Ч���ٺ�ǿ������������վ���������</p>
<p>��Ʒ���� PHPAPP������վ����ϵͳ�����¼�� PHPAPP</p>
<br />
<p>PHPAPP��������������ӵ�� PHPAPP ��Ʒ����Ȩ��<strong>�й����Ұ�Ȩ������Ȩ�ǼǺ� 2010SR054257����������Ȩ��.</strong></p>
<p>PHPAPP�ٷ���ַΪ http://www.phpapp.cn</p>
<p>PHPAPP ����Ȩ�����л����񹲺͹����Ұ�Ȩ��ע�ᣬ����Ȩ�ܵ����ɺ͹��ʹ�Լ������</p>
<p>ʹ���ߣ����۸��˻���֯��ӯ�������;��Σ�������ѧϰ���о�ΪĿ�ģ���������ϸ�Ķ���Э�飬����⡢ͬ�⡢�����ر�Э���ȫ������󣬷��ɿ�ʼʹ�� PHPAPP   �����</p>
<br />
<p>����ȨЭ�������ҽ������� PHPAPP ���а汾��PHPAPP�Ŷ�ӵ�жԱ���ȨЭ������ս���Ȩ��</p>
<br />
<p><strong>һ.Э����ɵ�Ȩ�� </strong></p>
<p>1.����������ȫ���ر������û���ȨЭ��Ļ����ϣ��������Ӧ���ڷ���ҵ��;��������֧�������Ȩ��Ȩ���á�</p>
<p>2.��������Э��涨��Լ�������Ʒ�Χ���޸� PHPAPP Դ����(������ṩ�Ļ�)�����������Ӧ������վҪ��</p>
<p>3.��ӵ��ʹ�ñ������������վ��ȫ����Ա���ϡ����¼������Ϣ������Ȩ���������е����������ݵ���ط�������</p>
<p>4.�����ҵ��Ȩ֮�������Խ������Ӧ������ҵ��;��ͬʱ�������������Ȩ������ȷ���ļ���֧�����ޡ�����֧�ַ�ʽ�ͼ���֧�����ݣ��Թ���ʱ�����ڼ���֧��������ӵ��ͨ��ָ���ķ�ʽ���ָ����Χ�ڵļ���֧�ַ�����ҵ��Ȩ�û����з�ӳ����������Ȩ����������������Ϊ��Ҫ���ǣ���û��һ�������ɵĳ�ŵ��֤��</p>
<br />
<p><strong>��.Э��涨��Լ�������� </strong></p>
<p>1.δ����ҵ��Ȩ֮ǰ�����ý������������ҵ��;����������������ҵ��վ����Ӫ����վ����Ӫ��ΪĿ��ʵ��ӯ������վ����������ҵ��Ȩ���½http://www.phpapp.cn   �ο����˵����Ҳ�����µ�13277759093�˽����顣</p>
<p>2.���öԱ��������֮��������ҵ��Ȩ���г��⡢���ۡ���Ѻ�򷢷������֤�� </p>
<p>3.������Σ���������;��Ρ��Ƿ񾭹��޸Ļ��������޸ĳ̶���Σ�ֻҪʹ�� PHPAPP ��������κβ��֣�δ��������ɣ�������վҳ��ҳ�Ŵ��� PHPAPP   ���ƺ�PHPAPP�ٷ���վ http://www.phpapp.cn �����Ӷ����뱣����������������޸ġ�</p>
<p>4.��ֹ�� PHPAPP ��������κβ��ֻ������Է�չ�κ������汾���޸İ汾��������汾�������·ַ���</p>
<p>5.�����δ�����ر�Э������������Ȩ������ֹ��������ɵ�Ȩ�������ջأ����е���Ӧ�������Ρ�</p>
<br />
<p><strong>��.���޵������������� </strong></p>
<p>1.����������������ļ�����Ϊ���ṩ�κ���ȷ�Ļ��������⳥�򵣱�����ʽ�ṩ�ġ�</p>
<p>2.�û�������Ը��ʹ�ñ�������������˽�ʹ�ñ�����ķ��գ�����δ�����Ʒ��������֮ǰ�����ǲ���ŵ�ṩ�κ���ʽ�ļ���֧�֡�ʹ�õ�����Ҳ���е��κ���ʹ�ñ���������������������Ρ�</p>
<p>3.PHPAPP�ٷ�����ʹ�ñ������������վ�е����»���Ϣ�е����Ρ��й� PHPAPP �����û���ȨЭ�顢��ҵ��Ȩ�뼼���������ϸ���ݣ����� PHPAPP   �ٷ���վ�����ṩ��PHPAPP�ٷ�ӵ���ڲ�����֪ͨ������£��޸���ȨЭ��ͷ����Ŀ���Ȩ�����޸ĺ��Э����Ŀ����Ըı�֮���������Ȩ�û���Ч��</p>
<p>4���������������������������API�ӿڰ�����Щ�ļ���Ȩ������PHPAPP�ٷ�����ο���������ʹ����ɺϷ���ʹ�á�</p>
<br />
<p>�����ı���ʽ����ȨЭ����ͬ˫������ǩ���Э��һ����������ȫ�ĺ͵�ͬ�ķ���Ч������һ����ʼ��װ   PHPAPP��������Ϊ��ȫ��Ⲣ���ܱ�Э��ĸ�������������������������Ȩ����ͬʱ���ܵ���ص�Լ�������ơ�Э����ɷ�Χ�������Ϊ����ֱ��Υ������ȨЭ�鲢������Ȩ��������Ȩ��ʱ��ֹ��Ȩ������ֹͣ�𺦣�������׷��������ε�Ȩ����</p>
</ul>
</div>

<div class="install_now">
<input name="Submit" type="submit" value="��ͬ��Э��" class="form_button" style="height:36px;margin-right:10px;"/>

<input type="button" value="�Ҳ�ͬ��Э��" onclick="InstallClose()" class="form_general_button" style="height:36px;"/> 

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
