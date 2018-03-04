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



<div id="ShowAdvancedSearch" class="showadvancedsearch" <?php if (!empty($this->GET['opensearch'])){ ?>style="display:block"<?php } ?>>
<form method="get" action="<?php echo $this->MakeGetParameterURL(); ?>">

<input type="hidden" name="app" value="<?php echo $this->app; ?>" />
<input type="hidden" name="menu" value="<?php echo $this->GET['menu']; ?>" />
<input type="hidden" name="action" value="<?php echo $this->ac; ?>" />
<input type="hidden" name="page" value="<?php echo $this->GET['page']; ?>" />
<input type="hidden" name="opensearch" value="<?php echo $this->GET['opensearch']; ?>" />

<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="search_h2">摘要</td>
    <td><input name="subject" type="text"  size="50" maxlength="255" class="form_input_text form_input_width_200"  value="<?php if (!empty($selectarray['subject'])){ ?><?php echo $selectarray['subject']; ?><?php } ?>"/> (交易摘要)</td>
  </tr>
  
  <tr>
    <td class="search_h2">编号</td>
    <td><input name="cid" type="text" size="50" maxlength="255" class="form_input_text form_input_width_100"  value="<?php if (!empty($selectarray['cid'])){ ?><?php echo $selectarray['cid']; ?><?php } ?>"/> (交易编号)</td>
    <td class="search_h2">流水号</td>
    <td><input name="serial" type="text" size="50" maxlength="255" class="form_input_text form_input_width_200"  value="<?php if (!empty($selectarray['serial'])){ ?><?php echo $selectarray['serial']; ?><?php } ?>"/> (交易流水号)</td>
  </tr>

  <tr>
    <td class="search_h2">用户ID </td>
    <td><input name="uid" type="text" size="50" maxlength="255" class="form_input_text form_input_width_100"  value="<?php if (!empty($selectarray['uid'])){ ?><?php echo $selectarray['uid']; ?><?php } ?>"/> (用户UID)</td>
    <td class="search_h2">用户名</td>
    <td><input name="username" type="text" size="50" maxlength="255" class="form_input_text form_input_width_200"  value="<?php if (!empty($selectarray['username'])){ ?><?php echo $selectarray['username']; ?><?php } ?>"/> (组合查询时用用户ID)</td>
  </tr>
  
  <tr>
    <td class="search_h2">操作员ID </td>
    <td><input name="operator" type="text" size="50" maxlength="255" class="form_input_text form_input_width_100"  value="<?php if (!empty($selectarray['operator'])){ ?><?php echo $selectarray['operator']; ?><?php } ?>"/> (手动充值的操作员UID,显示他操作的订单.)</td>
  </tr>
  
  <tr>
    <td class="search_h2">交易应用 </td>
    <td>
    <?php  $appsarr=$this->GetMysqlArray('id_phpapp,name_phpapp'," ".$this->GetTable('apps')." ORDER BY displayorder_phpapp ASC"); ?>
    <select name="appid">
        <option value="0">不限</option>
        <?php foreach ($appsarr as $value){ ?>
        <option value="<?php echo $value['id_phpapp']; ?>" <?php if (!empty($selectarray['appid'])){ ?><?php if ($selectarray['appid']==$value['id_phpapp']){ ?> selected="selected"<?php } ?><?php } ?>><?php echo $value['name_phpapp']; ?></option>
        <?php } ?>
    </select> 
    </td>
  </tr>
  
   <tr>
    <td class="search_h2">交易流程 </td>
    <td>
    <select name="process">
        <option value="0">不限</option>
        <option value="1" <?php if (!empty($selectarray['process'])){ ?><?php if ($selectarray['process']==1){ ?> selected="selected"<?php } ?><?php } ?>>等待买家付款</option>
        <option value="2" <?php if (!empty($selectarray['process'])){ ?><?php if ($selectarray['process']==2){ ?> selected="selected"<?php } ?><?php } ?>>买家已付款，等待卖家发货</option>
        <option value="3" <?php if (!empty($selectarray['process'])){ ?><?php if ($selectarray['process']==3){ ?> selected="selected"<?php } ?><?php } ?>>卖家已发货,等待买家确认</option>
        <option value="4" <?php if (!empty($selectarray['process'])){ ?><?php if ($selectarray['process']==4){ ?> selected="selected"<?php } ?><?php } ?>>买家退款中</option>
        <option value="5" <?php if (!empty($selectarray['process'])){ ?><?php if ($selectarray['process']==5){ ?> selected="selected"<?php } ?><?php } ?>>买家确认,成功订单</option>
        <option value="6" <?php if (!empty($selectarray['process'])){ ?><?php if ($selectarray['process']==6){ ?> selected="selected"<?php } ?><?php } ?>>关闭订单</option>
    </select> 
    </td>
  </tr>
  
   <tr>
    <td class="search_h2">资金流向 </td>
    <td> 
    <select name="flow" class="form_input_width_100">
        <option value="0">不限</option>
        <option value="2" <?php if (!empty($selectarray['flow'])){ ?><?php if ($selectarray['flow']==2){ ?> selected="selected"<?php } ?><?php } ?>>支出</option>
        <option value="1" <?php if (!empty($selectarray['flow'])){ ?><?php if ($selectarray['flow']==1){ ?> selected="selected"<?php } ?><?php } ?>>收入</option>
    </select> 
    </td>
    </tr>
    
    <tr>
    <td class="search_h2">交易类型 </td>
    <td> 
    <select name="paytype">
        <option value="0">所有交易</option>
        <option value="1" <?php if (!empty($selectarray['paytype'])){ ?><?php if ($selectarray['paytype']==1){ ?> selected="selected"<?php } ?><?php } ?>>担保交易</option>
        <option value="2" <?php if (!empty($selectarray['paytype'])){ ?><?php if ($selectarray['paytype']==2){ ?> selected="selected"<?php } ?><?php } ?>>即时交易</option>
        <option value="3" <?php if (!empty($selectarray['paytype'])){ ?><?php if ($selectarray['paytype']==3){ ?> selected="selected"<?php } ?><?php } ?>>充值交易</option>
        <option value="4" <?php if (!empty($selectarray['paytype'])){ ?><?php if ($selectarray['paytype']==4){ ?> selected="selected"<?php } ?><?php } ?>>提现交易</option>
    </select> 
    </td>
  </tr>
  
  <tr>
    <td class="search_h2">交易金额 </td>
    <td><input name="amount1" type="text" class="form_input_text" size="10" value="<?php if (!empty($selectarray['amount1'])){ ?><?php echo $selectarray['amount1']; ?><?php } ?>" style="width:70px;"/> ~ <input name="amount2" type="text" class="form_input_text" size="10" value="<?php if (!empty($selectarray['amount2'])){ ?><?php echo $selectarray['amount2']; ?><?php } ?>" style="width:70px;"/> 格式 10~20</td>
  </tr>
  
  <tr>
    <td class="search_h2">交易手续费 </td>
    <td><input name="fee1" type="text" class="form_input_text" size="10" value="<?php if (!empty($selectarray['fee1'])){ ?><?php echo $selectarray['fee1']; ?><?php } ?>" style="width:70px;"/> ~ <input name="fee2" type="text" class="form_input_text" size="10" value="<?php if (!empty($selectarray['fee2'])){ ?><?php echo $selectarray['fee2']; ?><?php } ?>" style="width:70px;"/> 格式 10~20</td>
  </tr>
  
  
  <tr>
    <td class="search_h2">退款金额 </td>
    <td><input name="refundmoney1" type="text" class="form_input_text" size="10" value="<?php if (!empty($selectarray['refundmoney1'])){ ?><?php echo $selectarray['refundmoney1']; ?><?php } ?>" style="width:70px;"/> ~ <input name="fee2" type="text" class="form_input_text" size="10" value="<?php if (!empty($selectarray['refundmoney2'])){ ?><?php echo $selectarray['refundmoney2']; ?><?php } ?>" style="width:70px;"/> 格式 10~20</td>
  </tr>
  
  <tr>
    <td class="search_h2">创建时间 </td>
    <td><input name="dateline1" type="text" class="form_input_text dateline" size="10" value="<?php if (!empty($selectarray['dateline1'])){ ?><?php echo $selectarray['dateline1']; ?><?php } ?>" style="width:70px;"/> ~ <input name="dateline2" type="text" class="form_input_text dateline" size="10" value="<?php if (!empty($selectarray['dateline2'])){ ?><?php echo $selectarray['dateline2']; ?><?php } ?>" style="width:70px;"/> 格式 (YYYY-MM-DD)</td>
  </tr>
  
  
   
</table>

<li style="text-align:center;padding-top:20px;">
   <input name="SelectData" type="submit" value="搜索" class="form_button"/>
</li>

</form>

</div>

<div class="advancedsearch">
<?php if (empty($this->GET['opensearch'])){ ?>
<a class="small green awesome" href="<?php echo $this->MakeGetParameterURL(array('opensearch'=>1)); ?>">打开筛选</a>
<?php }else{ ?>
<a class="small green awesome" href="<?php echo $this->MakeGetParameterURL(array('opensearch'=>0)); ?>">关闭筛选</a>
<?php } ?>
</div>

<script type="text/javascript">
	$(function() {
		 $(".dateline").datepicker();
		 $(".dateline").datepicker('option',{dateFormat:'yy-mm-dd'});
		 $(".dateline").datepicker('option',$.datepicker.regional['zh-CN']);

	});
</script>


<form action="<?php echo $this->MakeGetParameterURL(); ?>" method="post">

<?php if ($list){ ?>

<div id="WindowsForm<?php echo $this->GET['menu']; ?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="datalist" >
  <tr>
    <td class="datalist_h2" style="width:46px"><input type="checkbox" name="checkboxall" value="1"  onclick="CheckboxAll('WindowsForm<?php echo $this->GET['menu']; ?>')"/> 全选</td>
    
    <?php foreach ($orderarr as $key=>$value){ ?>
    <td class="datalist_h2"><a href="<?php echo $this->MakeGetParameterURL(array('sqlorder'=>$key,'iforder'=>$iforder)); ?>" id="order_<?php echo $this->GET['menu']; ?>_<?php echo $key; ?>"<?php if ($key==$this->GET['sqlorder']){ ?> <?php if ($this->GET['iforder']==2){ ?>  class="downorder"<?php }else{ ?> class="uporder"<?php } ?><?php } ?>><?php echo $value['name']; ?></a></td>
    <?php } ?> 
    <td class="datalist_h2">状态</td>
    <td class="datalist_h2" style="width:40px;">详情</td>
  </tr>


<?php foreach ($list as $key=>$value){ ?>
  
  <tr>
   <td<?php if (@ceil($key%2) == 0){ ?> style="background-color:#F7F7F7"<?php } ?>><input name="checkbox[]" type="checkbox" value="<?php echo $value['cid']; ?>"<?php if ($this->uid!=1){ ?> disabled="disabled"<?php } ?>/></td>
   <td<?php if (@ceil($key%2) == 0){ ?> style="background-color:#F7F7F7"<?php } ?>><span style="color:#333; font-family: Arial, Helvetica, sans-serif"><?php echo $value['cid']; ?></span></td>
    <td<?php if (@ceil($key%2) == 0){ ?> style="background-color:#F7F7F7"<?php } ?>><span style="color:#333; font-family: Arial, Helvetica, sans-serif"><?php echo $value['serial']; ?></span></td>
    <td<?php if (@ceil($key%2) == 0){ ?> style="background-color:#F7F7F7"<?php } ?>><?php echo $value['name_phpapp']; ?></td>
    <td<?php if (@ceil($key%2) == 0){ ?> style="background-color:#F7F7F7"<?php } ?>><span style="color:#666; font-family:Georgia, 'Times New Roman', Times, serif"><?php echo $this->Date('Y/m/d <p>H:i:s</p>',$value['dateline']); ?></span></td>
    <td<?php if (@ceil($key%2) == 0){ ?> style="background-color:#F7F7F7"<?php } ?>><span class="consume_subject"><?php echo $this->str($value['subject'],30,0,1,0,0,1); ?></span>
    <?php if ($value['bankcard']){ ?><?php echo $value['bankcard']; ?><?php } ?>
    </td>
    <td<?php if (@ceil($key%2) == 0){ ?> style="background-color:#F7F7F7"<?php } ?>><?php echo $value['number']; ?></td>
    <td<?php if (@ceil($key%2) == 0){ ?> style="background-color:#F7F7F7"<?php } ?>><?php if ($value['flow']==1){ ?>
    <?php if ($value['process']==5){ ?>
     <span style="color:#090;font-weight:bold; font-family:Verdana, Geneva, sans-serif;">+<?php echo $value['amount']; ?></span>
    <?php }else{ ?>
            <?php if ($value['refundmoney']>0){ ?>
                <span style="color:#090;font-weight:bold; font-family:Verdana, Geneva, sans-serif;"><?php if ($value['refundmoney']>=$value['amount']){ ?>+<?php echo $value['amount']+$value['fee']-$value['refundmoney']; ?><?php }elseif($value['refundmoney']< $value['amount']){ ?>+<?php echo $value['amount']-$value['refundmoney']; ?><?php } ?>
                </span>
            <?php }else{ ?>
                 <?php echo $value['amount']; ?>
            <?php } ?>
    <?php } ?>
    <?php }elseif($value['flow']==2){ ?>
    <span style="color:#F60;font-weight:bold;font-family: Verdana, Geneva, sans-serif;">
    
    -<?php echo $value['amount']; ?>

    </span>
    <?php } ?>
    </td>
    <td<?php if (@ceil($key%2) == 0){ ?> style="background-color:#F7F7F7"<?php } ?>><?php echo $value['fee']; ?></td>
    <td<?php if (@ceil($key%2) == 0){ ?> style="background-color:#F7F7F7"<?php } ?>><?php echo $value['refundmoney']; ?></td>
    <td<?php if (@ceil($key%2) == 0){ ?> style="background-color:#F7F7F7"<?php } ?>><?php if ($value['username']){ ?><?php echo $value['username']; ?><?php }else{ ?><?php echo PHPAPP::$config['sitepayname']; ?><?php } ?></td>
    <td<?php if (@ceil($key%2) == 0){ ?> style="background-color:#F7F7F7"<?php } ?>><?php echo $value['money']; ?></td>
    <td<?php if (@ceil($key%2) == 0){ ?> style="background-color:#F7F7F7"<?php } ?>><?php if ($value['operator']){ ?><?php echo $value['operatorname']; ?><?php } ?></td>
    <td<?php if (@ceil($key%2) == 0){ ?> style="background-color:#F7F7F7"<?php } ?>><?php if ($value['flow']==1){ ?><?php echo $getprocess->GetSellerProcessName('','',$value['cid'],0,$value['appid']); ?><?php }elseif($value['flow']==2){ ?><?php echo $getprocess->GetBuyerProcessName('','',$value['cid'],0,$value['appid'],$value['paytype']); ?><?php } ?></td>
    <td<?php if (@ceil($key%2) == 0){ ?> style="background-color:#F7F7F7"<?php } ?>><?php if ($value['paytype']==1){ ?><?php if ($value['oid']){ ?><p><a href="?app=48&menu=132&action=2&id=<?php echo $value['oid']; ?>" target="_blank">卖家</a></p><p><a href="?app=48&menu=132&action=4&id=<?php echo $value['oid']; ?>" target="_blank">买家</a></p><?php } ?><?php } ?></td>
  </tr>
  
 <?php } ?> 

</table>
</div>
<div class="ajax_page"><?php echo $ajaxpage->ShowPages(); ?></div>

<p><strong>注意</strong>：删除时选择恢复用户金额后系统自动将记录中<strong>交易成功</strong>的金额返还给用户.</p>

<?php if ($this->uid==1){ ?>
<p style="padding-top:10px;">选择操作方式 <select name="deletetype_d">
      <option value="1">删除并恢复用户金额</option>
      <option value="0">删除不恢复用户金额</option>
      <option value="2">关闭并恢复用户金额</option>
      <option value="3">关闭不恢复用户金额</option>
    </select> </p>
<div class="phpapp_button"><input name="Submit" type="submit" value="确认操作" class="form_button"/></div>
<?php } ?>

<?php }else{ ?>


<p>没有数据!</p>

<?php } ?>

</form>