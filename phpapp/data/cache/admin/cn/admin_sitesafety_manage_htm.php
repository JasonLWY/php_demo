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





<?php if ($this->GET['op']==3){ ?>
<form action="<?php echo $this->MakeGetParameterURL(); ?>" method="POST">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist">

<tr>
<td colspan="3"><strong>��վ����ע����Ϣ:</strong></td>
</tr>

<tr>
<td class="width_160">����ע���û���:</td>
<td><textarea  rows="6"  name="allowregisterusername_s" cols="50" class="form_textarea form_input_width_300"><?php echo PHPAPP::$config['allowregisterusername']; ?></textarea></td>
<td class="color_999">����û�����, ���Ÿ��� ���û������ * ��ʾ������˼</td>
</tr>


<tr>
<td colspan="3"><strong>������վ��־:</strong></td>
</tr>

<tr>
<td class="width_160">�Ƿ�����վ��־:</td>
<td><input class="radio" type="radio" name="S_SITE_LOG_d" value="1"  <?php if (S_SITE_LOG==1){ ?>checked<?php } ?>>&nbsp;���� <input class="radio" type="radio" name="S_SITE_LOG_d" value="0" <?php if (S_SITE_LOG==0){ ?>checked<?php } ?>>&nbsp;�ر�</td>
<td class="color_999">(��������������Ӳ�̿ռ�,��Ҫ�����ֶ�������־�ļ�,������������رա�)</td>
</tr>

<tr>
<td class="width_160">��վ��־�����ļ���С:</td>
<td><input name="S_SITE_LOG_SIZE_d" value="<?php echo S_SITE_LOG_SIZE; ?>" type="text" class="form_input_text form_input_width_200" /> ��λ bit(�ֽ�)</td>
<td class="color_999">(1KB =1024 bit�ֽ�)</td>
</tr>

<tr>
<td colspan="3"><strong>�û���¼��������:</strong></td>
</tr>

<tr>
<td class="width_160">�Ƿ�����IP</td>
<td><input class="radio" type="radio" name="allowloginip_d" value="0"  <?php if (PHPAPP::$config['allowloginip']==0){ ?>checked<?php } ?>>&nbsp;���� <input  type="radio" name="allowloginip_d" value="1" <?php if (PHPAPP::$config['allowloginip']==1){ ?>checked<?php } ?>>&nbsp;����</td>
<td class="color_999"></td>
</tr>


<tr>
<td class="width_160">���������:</td>
<td><input name="memberloginerrornum_d" value="<?php echo PHPAPP::$config['memberloginerrornum']; ?>" type="text" class="form_input_text form_input_width_200" /> ��</td>
<td class="color_999"></td>
</tr>

<tr>
<td class="width_160">������ֹʱ��:</td>
<td><input name="memberloginerrortime_d" value="<?php echo PHPAPP::$config['memberloginerrortime']; ?>" type="text" class="form_input_text form_input_width_200" /> ����</td>
<td class="color_999">(������������ֹ��¼��ʱ��)</td>
</tr>

</table>

<div class="phpapp_button"><input type="submit" name="Submit_s" value="�ύ" class="form_button"/></div>

<?php }elseif($this->GET['op']==2){ ?>

<form action="<?php echo $this->MakeGetParameterURL(); ?>" method="POST">

    <?php if (S_SITE_LOG){ ?>
        
          <table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist">
        
          <tr>
            <td>  
   
            ��ѯʱ�� <input name="dateline_s" type="text" class="form_input_text dateline" size="10" value="<?php if (!empty($this->POST['dateline'])){ ?><?php echo $this->POST['dateline']; ?><?php } ?>" style="width:90px;"/>
            <input name="SelectData" type="submit" value="��ѯ" class="form_button"/> <span style="font-weight:normal;color:#999">��ʽ (YYYY-MM-DD) ��־Ŀ¼·�� <?php echo SDIR; ?>/phpapp/data/log</span>
          </td>
          </tr>
        </table>
           
           
         <?php if ($logarr){ ?>
          <table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist">
          
          
          <tr>
                <td  class="datalist_h2">ѡ��</td><td  class="datalist_h2">��־�ļ���</td><td  class="datalist_h2">��־��С(KB)</td><td  class="datalist_h2">��־ʱ��</td>
          </tr>
              
          <?php foreach ($logarr as $value){ ?>
              
              <?php if ($value['filename']!='index.html' && $value['filename']!='index.htm'){ ?> 
              <tr>
                    <td><input name="select" type="radio" value="<?php echo $value['filename']; ?>"<?php if ($this->POST['select']==$value['filename']){ ?> checked="checked"<?php } ?>/></td><td><?php echo $value['filename']; ?></td><td><?php echo floor($value['filesize']/1024*100)/100; ?></td><td><?php echo $this->Date('Y/m/d H:i:s',$value['filetime']); ?></td>
              </tr>
              <?php } ?>
          <?php } ?>
         </table>
         
         <div class="phpapp_button">ɸѡ �û�UID��<input name="uid_d" type="text" class="form_input_text" size="10" value="<?php if (!empty($this->POST['uid'])){ ?><?php echo $this->POST['uid']; ?><?php } ?>" style="width:90px;"/>  �û�IP��ַ��<input name="ip_s" type="text" class="form_input_text" size="30" value="<?php if (!empty($this->POST['ip'])){ ?><?php echo $this->POST['ip']; ?><?php } ?>" style="width:90px;"/> </div>
         <div class="phpapp_button" style="padding-bottom:10px;"><input name="SelectLog" type="submit" value="���ļ�" class="form_button"/></div>
         
         <?php } ?>
         
         
         <?php if ($readarr){ ?>
              
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist">
          
          
                <tr>
                      <td  class="datalist_h2" style="width:120px;">�����û�UID</td><td class="datalist_h2" style="width:120px;">�û�IP</td><td  class="datalist_h2">��ȡ��ַ</td><td  class="datalist_h2" style="width:120px;">����ʱ��</td>
                </tr>
                    
                <?php foreach ($readarr as $value){ ?>
                    
                    <?php if ($this->POST['uid']>0 || $this->POST['ip']){ ?>
                        
                        <?php if ($this->POST['uid']==$value['uid'] || $this->POST['ip']==$value['ip']){ ?>
                        <tr>
                          <td><?php if ($value['uid']){ ?><?php echo $value['uid']; ?><?php }else{ ?>�ο�<?php } ?></td><td><?php echo $value['ip']; ?></td><td><?php echo $value['url']; ?></td><td><?php echo $value['time']; ?></td>
                        </tr>
                        <?php } ?>
                         
                    <?php }else{ ?>
                    <tr>
                          <td><?php if ($value['uid']){ ?><?php echo $value['uid']; ?><?php }else{ ?>�ο�<?php } ?></td><td><?php echo $value['ip']; ?></td><td><?php echo $value['url']; ?></td><td><?php echo $value['time']; ?></td>
                    </tr>
                    <?php } ?>
       
                <?php } ?>
               </table>
               
         <?php } ?>
         
    <?php }else{ ?>
     
      <p style="padding:10px;">�ù����ѹر�,������ <strong>��ȫ����</strong> �п���.</p>
    
    <?php } ?>

<?php }else{ ?>

<form action="<?php echo $this->MakeGetParameterURL(); ?>" method="get">

<input type="hidden" name="lang" value="<?php echo $this->lang; ?>" />
<input type="hidden" name="app" value="<?php echo $this->app; ?>" />
<input type="hidden" name="menu" value="<?php echo $this->GET['menu']; ?>" />
<input type="hidden" name="action" value="<?php echo $this->ac; ?>" />
<input type="hidden" name="page" value="<?php echo $this->GET['page']; ?>" />
<input type="hidden" name="op" value="<?php echo $this->GET['op']; ?>" />

  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist">

  <tr>
    <td>  

    �û��� <input name="username" type="text" size="50" maxlength="255" class="form_input_text form_input_width_100"  value="<?php if (!empty($selectarray['username'])){ ?><?php echo $selectarray['username']; ?><?php } ?>"/>
  
    ��ѯʱ�� <input name="dateline" type="text" class="form_input_text dateline" size="10" value="<?php if (!empty($selectarray['dateline1'])){ ?><?php echo $selectarray['dateline1']; ?><?php } ?>" style="width:90px;"/> ~ <input name="dateline" type="text" class="form_input_text dateline" size="10" value="<?php if (!empty($selectarray['dateline2'])){ ?><?php echo $selectarray['dateline2']; ?><?php } ?>" style="width:90px;"/>
    <input name="SelectData" type="submit" value="��ѯ" class="form_button"/> <span style="font-weight:normal;color:#999">��ʽ (YYYY-MM-DD)</span>
  </td>
  </tr>
</table>

<?php if ($list){ ?>

<div id="WindowsForm<?php echo $this->GET['menu']; ?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist" >
  <tr>

    <?php foreach ($orderarr as $key=>$value){ ?>
    <td class="datalist_h2"><a href="<?php echo $this->MakeGetParameterURL(array('sqlorder'=>$key,'iforder'=>$iforder)); ?>" id="order_<?php echo $this->GET['menu']; ?>_<?php echo $key; ?>"<?php if ($key==$this->GET['sqlorder']){ ?> <?php if ($this->GET['iforder']==2){ ?>  class="downorder"<?php }else{ ?> class="uporder"<?php } ?><?php } ?>><?php echo $value['name']; ?></a></td>
    <?php } ?> 

  </tr>

<?php foreach ($list as $value){ ?>
  <tr>
  
    <td><?php echo $value['id']; ?></td>
    <td><?php echo $value['username']; ?></td>
    <td><?php echo $value['loginip']; ?></td>
    <td><?php echo $this->Date('Y/m/d H:i:s',$value['dateline']); ?></td>
  
  </tr>
 <?php } ?> 

</table>
</div>
<div class="ajax_page"><?php echo $ajaxpage->ShowPages(); ?></div>

<?php }else{ ?>

<p style="padding:10px;">��ʱû�����ݣ��������û�����ʱ�� ���в�ѯ.</p>

<?php } ?>
  
  
  
<?php } ?>


</form>


<script type="text/javascript">

$(function() {
	 $(".dateline").datepicker();
	 $(".dateline").datepicker('option',{dateFormat:'yy-mm-dd'});
	 $(".dateline").datepicker('option',$.datepicker.regional['zh-CN']);
});

</script>
