<?php if(!defined('IN_PHPAPP')){exit('Data error');} ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo S_CHARSET; ?>" />

<meta http-equiv="X-UA-Compatible" content="IE=8" />

<title><?php if (PHPAPP::$SEO['title']){ ?><?php echo PHPAPP::$SEO['title']; ?> - <?php } ?><?php if ($this->GetActionTitle()){ ?><?php echo $this->GetActionTitle(); ?> - <?php } ?><?php echo $this->GetAppTitle(); ?> - <?php echo PHPAPP::$config['sitename']; ?><?php if (PHPAPP::$config['sitebanner']){ ?> - <?php echo PHPAPP::$config['sitebanner']; ?><?php } ?></title>

<meta name="keywords" content="<?php if (PHPAPP::$SEO['keywords']){ ?><?php echo PHPAPP::$SEO['keywords']; ?><?php }else{ ?><?php if ($this->GetActionKeywords()){ ?><?php echo $this->GetActionKeywords(); ?><?php }else{ ?><?php echo $this->GetAppKeywords(); ?><?php } ?><?php } ?>" />

<meta name="description" content="<?php if (PHPAPP::$SEO['description']){ ?><?php echo PHPAPP::$SEO['description']; ?><?php }else{ ?><?php if ($this->GetActionDescription()){ ?><?php echo $this->GetActionDescription(); ?><?php }else{ ?><?php echo $this->GetAppDescription(); ?><?php } ?><?php } ?>" />

<?php if (!empty($META['robots'])){ ?>
<META NAME="ROBOTS" CONTENT="NOINDEX,NOFOLLOW">
<?php } ?>

<?php if (PHPAPP::$config['sitecolor']){ ?><style type="text/css">html {filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1); }</style><?php } ?>

<?php $siteframewidth=intval(PHPAPP::$config['siteframewidth']); ?>

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

<body>

<!-- JS -->
<!-- Javascript -->

<script type="text/javascript">
var APPID =<?php echo $this->app; ?>;
var SURL ='<?php echo SURL; ?>';
var TURL ='<?php echo TURL; ?>';
var Language='<?php echo $this->lang; ?>';
var CategoryURL ="<?php echo SURL; ?>/member.php?app=10&action=1";
var TaskSkillURL ="<?php echo SURL; ?>/index.php?app=27&action=1";
var timestamp=<?php echo $this->NowTime(); ?>;
</script>


<!--  Public  -->
<script type="text/javascript" src="<?php echo TURL; ?>js/jquery.js?v=<?php echo $this->GetFileVersion(); ?>"></script>

<script type="text/javascript" src="<?php echo TURL; ?>js/dialog.js?v=<?php echo $this->GetFileVersion(); ?>"></script>
<script type="text/javascript" src="<?php echo TURL; ?>js/header.js?v=<?php echo $this->GetFileVersion(); ?>"></script>
<script type="text/javascript" src="<?php echo TURL; ?>js/phpapp.js?v=<?php echo $this->GetFileVersion(); ?>"></script>

<script type="text/javascript" src="<?php echo TURL; ?>js/member.js?v=<?php echo $this->GetFileVersion(); ?>"></script>

<!--  datepicker  -->
<script type="text/javascript" src="<?php echo TURL; ?>js/datepicker-<?php echo $this->lang; ?>.js?v=<?php echo $this->GetFileVersion(); ?>"></script>

<!--  input  -->
<script type="text/javascript" src="<?php echo TURL; ?>js/input.js?v=<?php echo $this->GetFileVersion(); ?>"></script>

<!-- poshytip -->
<script type="text/javascript" src="<?php echo TURL; ?>poshytip/jquery.poshytip.js?v=<?php echo $this->GetFileVersion(); ?>"></script>

<!-- AllCategory -->
<script type="text/javascript" src="<?php echo TURL; ?>js/jquery.tmailsilder.v2.js?v=<?php echo $this->GetFileVersion(); ?>"></script>

<!-- AJAX -->
<script type="text/javascript" src="<?php echo TURL; ?>js/ajax_auto.js?v=<?php echo $this->GetFileVersion(); ?>"></script>



<script type="text/javascript">

      function SubmitAward(OderID){
		    
			var award=parseFloat($("#NewAward").val());
			
			if (isNaN(award) || award<0){
		            alert("您输入的金额格式错误，请重新输入!");
		            $("#NewAward").focus();
		            return false; 
	        }
			
			if(confirm("请收到货后，再确认收货！是否确认并额外奖励"+award+"元?")){
		           $("#loading").html('<div class="loading">提交数据中...</div>');

				   SubmitDelivery(OderID,award);
			
			}
						  
		   
	  }
	  
	  
	  function PaymentOrders(OderID,tid){
		    if(confirm("是否确认要为此订单支付?")){
				 $("#loading").dialog({
						  title:"订单支付",	
						  width: 500,
						  position: ['center',160],
						  height:'auto'
				 });
				 
				 $("#loading").dialog('open');
							  
				 $("#loading").html('<div class="loading">处理支付中...</div>');
				
				 $.ajax({
						  type: "POST",
						  url: SURL+"/member.php?app=48&action=3&op=2",
						  data: 'oderid='+OderID+'&tid='+tid,
						  success: function(data){
								$("#loading").html(data);
						  }
				 });	
		    }
	  }
	  
	  
	  function CloseOrders(OderID,tid){
		    if(confirm("是否确认要关闭订单?")){
				 $("#loading").dialog({
						  title:"订单关闭",	
						  width: 500,
						  position: ['center',160],
						  height:'auto'
				 });
				 
				 $("#loading").dialog('open');
							  
				 $("#loading").html('<div class="loading">处理支付中...</div>');
				
				 $.ajax({
						  type: "POST",
						  url: SURL+"/member.php?app=48&action=3&op=5",
						  data: 'oderid='+OderID+'&tid='+tid,
						  success: function(data){
								$("#loading").html(data);
						  }
				 });	
		    }
	  }
	  
	  
	  function SubmitAddInvoice(OderID,OID){
		         
				var Invoice=$('#Invoice').val();  
				var Content=$('#InvoiceContent').val(); 
				 
				$("#loading").dialog({
						  title:"提交发票",	
						  width: 300,
						  position: ['center',160],
						  height:160
				});
				
				$("#loading").dialog('open');
						  
				$("#loading").html('<div class="loading">提交数据中...</div>');
				
				$.ajax({
						  type: "POST",
						  url: SURL+"/member.php?app=48&action=3&op=4",
						  data: 'oderid='+OderID+'&oid='+OID+'&invoice_s='+Invoice+'&content_s='+Content,
						  success: function(data){
								$("#loading").html(data);
						  }
                });	
				
		  
	  }
      
      function OpenDelivery(oid){
            
              if(oid>0){
      
                    var OderID=oid;
					
					$("#loading").dialog({
								  title:"操作订单",	
								  width: 600,
								  position: ['center',160],
								  height:'auto'
					});
							 
					$("#loading").dialog('open');
						  
					$("#loading").html('<div class="loading">提交数据中...</div>');
					
					$("#loading").html('<strong><span style="color:#F00">额外奖励</span>金额</strong> <input type="text"  id="NewAward" size="50" maxlength="8" class="form_input_text form_input_width_100"  value="0" /> 元 <input type="button" value="确认收货" onclick="SubmitAward(\''+oid+'\')" class="form_button"/><p style="padding-top:6px;"><strong>提示：</strong>额外奖励指您对稿件另奖励的赏金，如果不想奖励默认0元！</p>');
					
					
                    
              }else{
                   var OderID='';
                   $("#orderlist").find("input:checked[name!='checkboxall']").each(function(){
                           var value=$(this).val();  
                           
                           if($(this).attr("disabled")!='disabled'){
                           
                           if(OderID){
                                OderID+=','+value;
                           }else{
                                OderID=value;
                           }
                           }
              
                   }); 	
                   
                   if(!OderID){
                       
                        alert("请选择订单操作!");
                        return false;
                   }
				   
				   if(confirm("请收到货后，再确认收货！是否确认?")){
				
						  $("#loading").dialog({
								  title:"操作订单",	
								  width: 600,
								  position: ['center',160],
								  height:'auto'
						  });
							 
						  $("#loading").dialog('open');
						  
						  $("#loading").html('<div class="loading">提交数据中...</div>');
						  
						  SubmitDelivery(OderID);
					  
					  
				  }
          
                    
              }
          
 
      }
      
      function SubmitDelivery(OderID,award){
            
            var content=$("#OderContent").val();
            
            $.ajax({
                              type: "POST",
                              url: SURL+"/member.php?app=48&action=3&op=1",
                              data: 'oderid='+OderID+'&award='+award,
                              success: function(data){
                                    $("#loading").html(data);
                              }
                     });	
          
      }
      
   function OpenCredit(oid){
            
              if(oid>0){
      
                    var OderID=oid;
                    
              }else{
                   var OderID='';
                   $("#orderlist").find("input:checked[name!='checkboxall']").each(function(){
                           var value=$(this).val();  
                           
                           if($(this).attr("disabled")!='disabled'){
                           
                           if(OderID){
                                OderID+=','+value;
                           }else{
                                OderID=value;
                           }
                           }
              
                   }); 	
                   
                   if(!OderID){
                       
                        alert("请选择订单操作!");
                        return false;
                   }
                    
              }
          
          
          
            $("#TaskCreditLevel").dialog({
                    width: 600,
                    position: ['center',160],
                    height:'auto',
					modal: true,
			        autoOpen: false
            });
               
            $("#TaskCreditLevel").dialog('open');
            

            
            $("#OderID").val(OderID);
            
      
          
      }
      
	  
      function SubmitCredit(OderID){
            
			var OderID=$("#OderID").val();
			
            var level=$("#CreditLevel :checked").val();
			
			var content=$("#OderContent").val();
			
			var workspeed=$("#WorkSpeedValue").val();
			
			var worksattitude=$("#WorksAttitudeValue").val();
			
			var worksquality=$("#WorksQualityValue").val();
			
			$("#TaskCreditLevel").html('<div class="loading">提交数据中...</div>');
            
            $.ajax({
                              type: "POST",
                              url: SURL+"/member.php?app=48&action=3&op=3",
                              data: 'oderid_s='+OderID+'&level='+level+'&content_s='+content+'&speed_d='+workspeed+'&attitude_d='+worksattitude+'&quality_d='+worksquality,
                              success: function(data){
                                    $("#TaskCreditLevel").html(data);
                              }
                     });	
          
      }    
      
	  $(function(){	
				 
			$("#WorksPeed li").mouseover( function () {
					  
					  var id=$(this).attr("id");
					  var num=id.substr(10,1);

					  SetStar('WorksPeed',num);
					  
					  $("#WorksPeedScore").html(num+'.0');
					  
					  $("#WorkSpeedValue").val(num);
					  
			});
			
			$("#WorksAttitude li").mouseover( function () {
					  
					  var id=$(this).attr("id");
					  var num=id.substr(14,1);

					  SetStar('WorksAttitude',num);
					  
					  //alert(id.substr(10,1));
					  
					  $("#WorksAttitudeScore").html(num+'.0');
					  
					  $("#WorksAttitudeValue").val(num);
					  
			});
			
			
			$("#WorksQuality li").mouseover( function () {
					  
					  var id=$(this).attr("id");
					  var num=id.substr(13,1);

					  SetStar('WorksQuality',num);
					  
					  $("#WorksQualityScore").html(num+'.0');
					  
					  $("#WorksQualityValue").val(num);
					  
			});
			
			
	  
	  });
	  
	  function SetStar(id,num){
		  
		   
					  
			for(var i=1; i<=5; i++){
				
				 if(i > num){
				      $("#"+id+"_"+i).removeClass('focus');
				 }else{
					  $("#"+id+"_"+i).addClass('focus');
				 }
			}
			
			
		  
	  }
	  
	  
      </script>
      
      
      <div id="TaskCreditLevel" style="display:none;padding:20px;" title="订单评价">
  
        <div class="credit_level" id="CreditLevel">
        <ul>
        <li class="credit_hao"></li>
        <li class="credit_cha"></li>
        <li class="credit_zhong"></li>
        </ul>
        
        <ul>
        <li><input name="creditradio" type="radio" value="0" checked />好评</li> 
        <li><input name="creditradio" type="radio" value="1"/>中评</li> 
        <li><input name="creditradio" type="radio" value="2"/>差评</li>
        </ul>
        </div>
        
        <div class="task_score">
             <h3>评分：</h3>
             
                 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>
                    <div class="score_works_peed">工作速度：<span id="WorksPeedScore" class="color_f60">0.0</span> 分 &nbsp;
                
                <a href="javascript:;" class="score_level" id="WorksPeed">
                
                      <li title="1分 速度慢得太离谱，非常不满意" id="WorksPeed_1"></li>
                      
                      <li title="2分 速度很慢，不满意" id="WorksPeed_2"></li>
                      
                      <li title="3分 速度还行" id="WorksPeed_3"></li>
                      
                      <li title="4分 速度蛮快，不错" id="WorksPeed_4"></li>
                      
                      <li title="5分 速度非常快，非常不错" id="WorksPeed_5"></li>
                
                </a>
                
                </div>
                
                <input id="WorkSpeedValue" type="hidden" value="0" /></td>
                  </tr>
                  <tr>
                    <td>
                    <div class="score_works_attitude">服务态度：<span id="WorksAttitudeScore" class="color_f60">0.0</span> 分 &nbsp; 
                
                <a href="javascript:;" class="score_level" id="WorksAttitude">
                
                      <li title="1分 卖家态度很差，还骂人、说脏话，简直不把顾客当回事" id="WorksAttitude_1"></li>
                
                      <li title="2分 卖家有点不耐烦，承诺的服务也兑现不了" id="WorksAttitude_2"></li>
                      
                      <li title="3分 卖家回复问题很慢，态度一般，谈不上沟通顺畅" id="WorksAttitude_3"></li>
                      
                      <li title="4分 卖家服务挺好的，沟通挺顺畅的，总体满意，不错" id="WorksAttitude_4"></li>
                      
                      <li title="5分 卖家的服务太棒了，考虑非常周到，完全超出期望值" id="WorksAttitude_5"></li>
                
                </a>
                </div>
                <input  id="WorksAttitudeValue" type="hidden" value="0" />
                    </td>
                  </tr>
                   <tr>
                    <td><div class="score_works_quality">完成质量：<span id="WorksQualityScore" class="color_f60">0.0</span> 分 &nbsp; 
                
                <a href="javascript:;"  class="score_level" id="WorksQuality">
                
                      <li title="1分 差得太离谱，与卖家描述的严重不符，非常不满" id="WorksQuality_1"></li>
                
                      <li title="2分 部分有破损，与卖家描述的不符，不满意" id="WorksQuality_2"></li>
                      
                      <li title="3分 质量一般，没有卖家描述的那么好" id="WorksQuality_3"></li>
                      
                      <li title="4分 质量不错，与卖家描述的基本一致，还是挺满意的" id="WorksQuality_4"></li>
                      
                      <li title="5分 质量非常好，与卖家描述的完全一致，非常满意" id="WorksQuality_5"></li>
                
                </a>
                <input id="WorksQualityValue" type="hidden" value="0" />
                </td>
                  </tr>
                </table>
                
                <p>提示：<span style="color:#999">将鼠标指到星星等级上进行评分</span></p>
        </div>
        
        <p>评语：(100字内)</p>
        
        <textarea id="OderContent" class="form_input_text" style="width:550px;height:100px;margin-bottom:10px;"></textarea><p style="text-align:center;margin-top:10px;">
        <input id="OderID" type="hidden" value="0" />
        <input name="Submit" type="button" value="确认" onclick="SubmitCredit()" class="form_button"/>
        </p>
  
  </div>
      
   </div>


<script type="text/javascript">
      
      function SellerOpenDelivery(oid){
            
              if(oid>0){
      
                    var OderID=oid;
                    
              }else{
                   var OderID='';
                   $("#orderlist").find("input:checked[name!='checkboxall']").each(function(){
                           var value=$(this).val();  
                           
                           if($(this).attr("disabled")!='disabled'){
                           
                           if(OderID){
                                OderID+=','+value;
                           }else{
                                OderID=value;
                           }
                           }
              
                   }); 	
                   
                   if(!OderID){
                       
                        alert("请选择订单操作!");
                        return false;
                   }
                    
              }
          

              SellerSubmitDelivery(OderID);
          
      }
      

      function UploadOrderFile(OderID){

			$.SaveContent();
			
            var content=$("#SellContent").val();
			
			$("#loading").dialog({
                    title:"上传订单文件",	
                    width: 300,
                    position: ['center',160],
                    height:160
            });
               
            $("#loading").dialog('open');
            
            $("#loading").html('<div class="loading">上传数据中...</div>');
   
            $.ajax({
					  type: "POST",
					  url: SURL+"/member.php?app=48&action=1&op=4",
					  data: '&oderid_s='+OderID+'&content_s='+content+'&Submit=1',
					  success: function(data){
							$("#loading").html(data);
					  }
             });	
          
      }
	
	  
      function SellerSubmitDelivery(OderID){
            
		   if(confirm("是否确认已上传文件交接?")){
			   
					$("#loading").dialog({
							  title:"确认文件交接",	
							  width: 500,
							  position: ['center',160],
							  height:'auto'
					});
					 
					$("#loading").dialog('open');
								  
					$("#loading").html('<div class="loading">处理确认交接中...</div>');
					
					$.ajax({
							  type: "POST",
							  url: SURL+"/member.php?app=48&action=1&op=2",
							  data: 'oderid_s='+OderID,
							  success: function(data){
									$("#loading").html(data);
							  }
					});	
		   }
          
      }


      function SellerOpenCredit(oid){
            
              if(oid>0){
      
                    var OderID=oid;
                    
              }else{
                   var OderID='';
                   $("#orderlist").find("input:checked[name!='checkboxall']").each(function(){
                           var value=$(this).val();  
                           
                           if($(this).attr("disabled")!='disabled'){
                           
                           if(OderID){
                                OderID+=','+value;
                           }else{
                                OderID=value;
                           }
                           }
              
                   }); 	
                   
                   if(!OderID){
                       
                        alert("请选择订单操作!");
                        return false;
                   }
                    
              }
          
          
          
            $("#loading").dialog({
                    title:"订单评价",	
                    width: 600,
                    position: ['center',160],
                    height:'auto'
            });
               
            $("#loading").dialog('open');
            
            $("#loading").html('<div class="loading">读取数据中...</div>');
            
            
            $("#loading").html('<div class="credit_level" id="SellerCreditLevel"><ul><li class="credit_hao"></li><li class="credit_cha"></li><li class="credit_zhong"></li></ul><ul><li><input name="creditradio" type="radio" value="0" checked />好评</li> <li><input name="creditradio" type="radio" value="1"/>中评</li> <li><input name="creditradio" type="radio" value="2"/>差评</li></ul></div><p>评语：(100字内)</p><textarea id="SellerCreditContent" class="form_input_text" style="width:550px;height:100px;margin-bottom:10px;"></textarea><p style="text-align:center;margin-top:10px;"><input name="Submit" type="button" value="确认" onclick="SellerSubmitCredit(\''+OderID+'\')" class="form_button" style="width:80px"/></p>');
            
      
          
      }
      
	  
      function SellerSubmitCredit(OderID){

            var level=$("#SellerCreditLevel input:checked").val();
			
			var content=$("#SellerCreditContent").val();

            $.ajax({
					  type: "POST",
					  url: SURL+"/member.php?app=48&action=1&op=3",
					  data: 'oderid_s='+OderID+'&level='+level+'&content_s='+content,
					  success: function(data){
							$("#loading").html(data);
					  }
              });	

      }
          
      </script>

<div id="UserPhotoShow"></div>

<!-- Loading -->
<div id="TopLoading" style="display:none" title="loading..."></div>
<div id="loading" style="display:none" title="读取数据中..."></div>

<?php if (PHPAPP::$config['sitenotice']==0){ ?>
    <div id="SiteNotice" class="sitenotice">
    	<?php echo $this->str(PHPAPP::$config['noticecontent'],300,0,1,0,1); ?>
    </div>
<?php } ?>



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
                                 <!--
                                 <strong id="NowCity">南宁市</strong> <a href="<?php echo SURL; ?>" id="ChangeCityTitle" title="切换一个新的城市任务">[切换城市]</a>
                                 -->
                              </div>
                          </div>
 
                          <div id="Header_Member">

                               <?php if ($this->uid>0){ ?>

      <link href="<?php echo TURL; ?>evaluate.css" rel="stylesheet" type="text/css" />
      <!-- 获取当前登录者部分信息 --> 
      <?php  $LoginMemberArray=$this->GetLoginInfo(0,1); $usergroupid=$LoginMemberArray['usergroup'];$loginmemberusergroup=$this->GetMysqlOne('allowskillnumber',"   ".$this->GetTable('usergroup')." WHERE gid='$usergroupid'");
      $noticenum=$this->IsSQL('member_notice'," WHERE uid='$this->uid' AND new=1");
      $smsnum=$this->IsSQL('member_sms'," WHERE msggoid='$this->uid' AND mailbox=1 AND new=1");
       ?>
      
      <script type="text/javascript">
	      var USERID=<?php echo $this->uid; ?>;
		  var USERNAME='<?php echo $this->username; ?>';
		  var UserSkillsNumber=<?php echo $loginmemberusergroup['allowskillnumber']; ?>;
	  </script>
<?php }else{ ?>
      <script type="text/javascript">
	      var USERID=0;
		  var UserSkillsNumber=0;
	  </script>
<?php } ?>

<?php if (!$this->uid){ ?>

      <div class="member_addtask">
              <a href="<?php echo SURL; ?>/index.php?app=49&action=1" title="免费发布一个任务" id="TopAddTask">我要发布任务</a>
      </div>
    
<?php } ?>
                               
<div id="Header_Member_Login" class="header_member_login">

    <?php if ($this->uid>0){ ?>
    
        <script type="text/javascript">
            $(function(){
                    $("#MemberMessage").click( function () { $.PHPAPPHeaderItem('MemberMessage','MemberMessageView',-180,68,400); });
                    $("#MemberNotice").click( function () { $.PHPAPPHeaderItem('MemberNotice','MemberNoticeView',-200,68,400); });
                    $("#MemberTaskFeed").click( function () { $.PHPAPPHeaderItem('MemberTaskFeed','MemberTaskFeedView',-240,68,360); });
                    $("#MemberMoney").click( function () { $.PHPAPPHeaderItem('MemberMoney','MemberMoneyView',0,68,138,0,1); });
                    $("#MemberMenu").click( function () { $.PHPAPPHeaderItem('MemberMenu','MemberMenuView',0,68,120,0,1); });
					$("#MemberSeller").click( function () { $.PHPAPPHeaderItem('MemberSeller','MemberSellerView',0,68,120,0,1); });
					$("#MemberBuyer").click( function () { $.PHPAPPHeaderItem('MemberBuyer','MemberBuyerView',0,68,120,0,1); });
            }) 
        </script>
        <span id="loginuseruid" style="display:none"><?php echo $this->uid; ?></span>
        <div id="Header_Member_Item">
    
            <div id="Header_Member_Menu" class="header_member_menu">
      
                <ul>
                    <li class="member_message"><a href="javascript:void(0)" id="MemberMessage" class="default" title="站内短信" onclick="GetMemberMessage()"><sub id="NewMemberMessage"></sub></a></li>
                    <li class="member_notice"><a href="javascript:void(0)" id="MemberNotice" class="default" title="网站通知" onclick="GetMemberNotice()"><sub id="NewMemberNotice"></sub></a></li>
                    <li class="member_taskfeed"><a href="javascript:void(0)" id="MemberTaskFeed" class="default" title="任务动态"><sub id="NewMemberTaskFeed"></sub></a></li>
                    <li><a href="javascript:void(0)" id="MemberMoney" class="default" title="可用余额：￥<?php echo $LoginMemberArray['money']; ?>"><span>￥<?php echo $LoginMemberArray['money']; ?></span></a></li>
                    <li><a href="javascript:void(0)" id="MemberMenu" class="default" title="用户管理"><?php echo $this->username; ?><?php if ($LoginMemberArray['userpost']==1){ ?>(雇主)<?php }elseif($LoginMemberArray['userpost']==2){ ?>(威客)<?php } ?></a></li>
                    
                     <!--
                    <?php if ($LoginMemberArray['userpost']==2){ ?>
                   		 <li><a href="javascript:void(0)" id="MemberBuyer" class="default" title="我是雇主">我是雇主</a></li>
                    <?php }elseif($LoginMemberArray['userpost']==1){ ?>
                    	 <li><a href="javascript:void(0)" id="MemberSeller" class="default" title="我是威客">我是威客</a></li>
                    <?php } ?>
                    -->

                    <?php if ($LoginMemberArray['userpost']==1){ ?>
                         <li class="member_addtask_small"><a href="<?php echo SURL; ?>/index.php?app=49&action=1" title="免费发布一个任务" id="TopAddTask">发布任务</a></li>
                    <?php }elseif($LoginMemberArray['userpost']==2){ ?>
                    	 <li class="member_addtask_small"><a href="<?php echo SURL; ?>/member.php?app=82&action=1" title="免费发布一个服务" id="TopAddTask">发布服务</a></li>
                    <?php } ?>
                </ul>
            </div>
        
            <div id="MemberMessageView" class="header_member_default">
                <div id="TopMessageDataTab" style="border: none;padding:0px;">
                    <ul>
                        <li style="margin-left:10px;"><a href="#TopMessageDataList"><strong>最新站内短信</strong></a></li>
                    </ul>
                    
                    <div id="TopMessageDataList" class="top_member_list">
                        <ul>
                        </ul>
                    </div>
                    <div class="more_info"><dfn><a href="javascript:void(0)" onclick="DeleteMemberMessage(0)">[清空所有]</a></dfn><em><a href="<?php echo SURL; ?>/member.php?app=7">查看更多>></a></em></div>
                        
                  </div>
            </div>
            
            <div id="MemberNoticeView"  class="header_member_default">
                 <div id="TopNoticeDataTab" style="border: none;padding:0px;">
                    <ul>
                        <li style="margin-left:10px;"><a href="#TopNoticeDataList"><strong>最新通知</strong></a></li>
                    </ul>
                    
                    <div id="TopNoticeDataList" class="top_member_list">
                        <ul>
                        </ul>
                    </div>
                    <div class="more_info"><dfn><a href="javascript:void(0)" onclick="DeleteMemberNotice(0)">[清空所有]</a></dfn><em><a href="<?php echo SURL; ?>/member.php?app=45">查看更多>></a></em></div>
                        
                  </div>
            </div> 
        
        
            <div id="MemberTaskFeedView"  class="header_member_default">
                 <div id="TopTaskFeedTab" style="border: none;padding:0px;">
                    <ul>
                        <li style="margin-left:10px;"><a href="#TopFeedViewList"><strong>最新任务动态</strong></a></li>
                    </ul>
                    
                    <div id="TopFeedViewList" class="top_member_list">
                        <ul>
                        </ul>
                    </div>
                    <div class="more_info"><dfn><a href="javascript:void(0)" id="TaskFeedViewEmpty">[清空所有]</a></dfn>
                    
                    <!--
                    <em><a href="<?php echo SURL; ?>/member.php?app=5&action=2">查看更多>></a></em>
                    -->
                    </div>
                        
                  </div>
            </div> 
            
            
            <div id="MemberMoneyView"  class="header_member_default member_menu_list">
                <ul>
                     <li><a href="<?php echo SURL; ?>/member.php?app=5&action=2">我要充值</a></li>
          			 <li><a href="<?php echo SURL; ?>/member.php?app=5&action=3">我要提现</a></li>
                </ul>
            </div> 
            
            <div id="MemberMenuView" class="header_member_default member_menu_list">
                <ul>
                     <li><a href="<?php echo SURL; ?>/member.php?app=9">管理中心</a></li>
                     <?php  $navtop=$this->GetMysqlArray('*'," ".$this->GetTable('nav_top')."  ORDER BY displayorder ASC"); ?>
                     <?php if ($navtop){ ?>
                          <?php foreach ($navtop as $value){ ?>
                               <li><a href="<?php echo $value['navurl']; ?>" <?php if ($value['blank']==0){ ?>target="_blank"<?php } ?>><?php echo $value['navname']; ?></a></li>
                          <?php } ?>
                       
                     <?php } ?>
                    <li><a href="<?php echo SURL; ?>/index.php?app=2&action=10">安全退出</a></li>
                </ul>
            </div> 
            
            <!--
            <div id="MemberSellerView"  class="header_member_default member_menu_list">
                <ul>
                </ul>
            </div> 
            
            <div id="MemberBuyerView"  class="header_member_default member_menu_list">
                <ul>
                </ul>
            </div> 
            -->
        
        </div>
    
          
    <?php }else{ ?>
        <div id="Header_Member_Info" class="header_member_info">
            <ul>
                <span id="loginuseruid" style="display:none">0</span> <span class="loginrefresh" style="display:none">0</span> 
                <li class="nobackground" title="帮助"><a href="<?php echo SURL; ?>/index.php?app=57" title="帮助中心">帮助</a></li><li><a href="<?php echo SURL; ?>/index.php?app=2&action=2" title="免费注册帐号">免费注册</a></li>
                
                <li><a href="javascript:void(0);" title="登录到本站" id="UserLogin" class="topuserlogin_default">登录</a>
                     <div class="LoginFrame" id="NowLoginFrame" title="网站登录">
                             <link href="<?php echo TURL; ?>sns.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">

var loading='<img src="<?php echo TURL; ?>images/loading.gif" alt="正在读取数据中..." />';
var right='<img src="<?php echo TURL; ?>images/right.png" alt="正确" class="checkright" />';
var error='<img src="<?php echo TURL; ?>images/error.png" alt="错误" />';
var SubmitLoginInput='<input type="submit" value="登 录" onclick="return SubmitLoginNow();" class="form_button"/>';
var LoginInputPrompt='用户名/邮箱/手机';


function VerifyLoginPassword(){
	          $('#AjaxLoginPasswordError').html(loading);
		  
              var password=$("#LoginPassword").val();

			  if(!password.length){
				   $('#AjaxLoginPasswordError').html(error);

				   var data='亲,请输入密码!';
			  }else if(password.length<6){
				   
				   $('#AjaxLoginPasswordError').html(error);
				   var data='密码不能小于6位!';
				   
			  }else{
				    $('#AjaxLoginPasswordError').html('');
					var data='密码位数正常!';
			  }

			  $('#LoginPassword').poshytip('update',data);
}

$(function(){
	  
	  $("#PasswordTab").tabs();	
	   
	  $("#SubmitLoginNow").html(SubmitLoginInput);  
	  
	  $("#LoginUserName").val(LoginInputPrompt);
	  
	  $("#SiteLoginUserName").val(LoginInputPrompt);
   
	  $('#LoginUserName,#LoginPassword,#SiteLoginUserName,#SiteLoginPassword').poshytip({
			className: 'tip-green',
			showOn: 'focus',
			alignTo: 'target',
			alignX: 'right',
			alignY: 'center',
			offsetX: 5
      });
	  
	  $("#SiteSecCode").one("click", function(){
			seccode();
	  });
	   
	  $(".LoginUserName,#SiteLoginUserName").one("click", function(){ $(this).val('');$(this).css("color","#333"); });
	 
	  $("#ShowSNS").toggle(
			function () {
			     $("#SNSList").show(500);this.blur();
			},
			function () {
			     $("#SNSList").hide(500);this.blur();
			}
	  );
	  
	  $("#LoginPassword").click( function () {
			  VerifyLoginPassword();
	  });
	  
	  $("#LoginPassword").blur( function () { 
		     VerifyLoginPassword();
      });

});


function SubmitLogin() {

			var username=$("#SiteLoginUserName").val();
			 if(LoginInputPrompt==username){
				  $('#SiteLoginUserName').val('');
				  $('#SiteLoginUserName').focus();
				  $('#SiteAjaxLoginUserNameError').html(error);
				  $('#SiteLoginUserName').poshytip('update','请输入用户名！');
				  return false; 
			 }else{
					 if(!username.length){
						 $('#SiteLoginUserName').focus();
						 $('#SiteAjaxLoginUserNameError').html(error);
						 $('#SiteLoginUserName').poshytip('update','对不起!昵称不能为空!');
		
						 return false; 
					 }else{
						 if(username.length>1){
							 $('#SiteAjaxLoginUserNameError').html('');
						 }else{
							  $('#SiteLoginUserName').focus();
							  $('#SiteAjaxLoginUserNameError').html(error);
							  $('#SiteLoginUserName').poshytip('update','对不起!用户名太短了!');
							 
							  return false; 
						 }
						 
					 }
			 }
		
			 var password=$("#SiteLoginPassword").val();
			 if(!password.length){
				 	
			     $('#SiteLoginPassword').focus();
				 $('#SiteAjaxLoginPasswordError').html(error);
				 $('#SiteLoginPassword').poshytip('update','对不起!密码不能为空!');
				 
		         return false; 
			 }else{
			
				 if(password.length>=6){
				     $('#SiteAjaxLoginPasswordError').html('');
				 }else{
					 $('#SiteLoginPassword').focus();
				     $('#SiteAjaxLoginPasswordError').html(error);
					 $('#SiteLoginPassword').poshytip('update','对不起!密码不能小于6位!');
		
					 return false; 
				 }
			 }
			 
			 
			 
			 <?php if (PHPAPP::$config['loginiscode']){ ?>
			 var seccode=$("#SiteSecCode").val();
			 if(!seccode.length){
			     $('#SiteSecCode').focus();
				 $('#SiteAjaxSecCodeError').html(error);
			     $('#SiteAjaxSecCode').html('<div class="register_reg_tips">对不起!请输入验证码!</div>');
		         return false; 
			 }else{
				 if(seccode.length!=4){
					 $('#SiteSecCode').focus();
				     $('#SiteAjaxSecCodeError').html(error);
			         $('#SiteAjaxSecCode').html('<div class="register_reg_tips">对不起!请输入4位验证码!</div>');
		             return false; 
				 }
			
			 }	
			 
			 <?php } ?>
			 
			
			$("#loading").html('<div class="loading">登录中...</div>');
			$("#loading").dialog('open');
			$("#loading").dialog({ title: '登录框' });
			 
			var forms=GetFormAll('#LoginForm');
			$.ajax({
   			type: "POST",
   			url: SURL+'/index.php?app=2&action=1&rand='+Math.random(),
  		    data: forms,
   			success: function(data){
    			  $("#loading").html(data);
				  return false; 
				  //alert(data);
   			}
			});
			return false; 
									   
 }
 
 
function SubmitLoginNow() {

			 var username=$("#LoginUserName").val();
			 if(LoginInputPrompt==username){
				  $('#LoginUserName').val('');
				  $('#LoginUserName').focus();
				  $('#AjaxLoginUserNameError').html(error);
				  $('#LoginUserName').poshytip('update','请输入用户名！');
				  return false; 
			 }else{
					 if(!username.length){
						 $('#LoginUserName').focus();
						 $('#AjaxLoginUserNameError').html(error);
						 $('#LoginUserName').poshytip('update','对不起!昵称不能为空!');
		
						 return false; 
					 }else{
						 if(username.length>1){
							 $('#AjaxLoginUserNameError').html('');
						 }else{
							  $('#LoginUserName').focus();
							  $('#AjaxLoginUserNameError').html(error);
							  $('#LoginUserName').poshytip('update','对不起!用户名太短了!');
							 
							  return false; 
						 }
						 
					 }
			 }
		
			 var password=$("#LoginPassword").val();
			 if(!password.length){
				 	
			     $('#LoginPassword').focus();
				 $('#AjaxLoginPasswordError').html(error);
				 $('#LoginPassword').poshytip('update','对不起!密码不能为空!');
				 
		         return false; 
			 }else{
			
				 if(password.length>=6){
				     $('#AjaxLoginPasswordError').html('');
				 }else{
					 $('#LoginPassword').focus();
				     $('#AjaxLoginPasswordError').html(error);
					 $('#LoginPassword').poshytip('update','对不起!密码不能小于6位!');
		
					 return false; 
				 }
			 }
            
			 $("#SubmitLogin").html('<div class="loading">登录中...</div>');
			 
	
            var SecurityForm=$("#SecurityForm").val();

			  $.post(SURL+"/index.php?app=2&action=12&rand="+Math.random(),{UserName_s:username,Password_s:password,SecurityForm_s:SecurityForm,SubmitLoginNow:'SubmitLoginNow'},
					
				   function (data){
					  
					   if(data.indexOf('ok')>0 || data=='ok'){
						   
						     if(data=='ok'){
								   LoginNowForm(data);
							 }else{
								 
								   var LoginIframe=document.getElementById("NowLoginIframe");
					               var Iframedoc=LoginIframe.contentWindow.document;
								   Iframedoc.open();
								   Iframedoc.write(data+parent.LoginNowForm(data));
								   Iframedoc.close();
							
							 }
							 
							 
					   }else{
						     $('#LoginUserName').focus();
						     $('#LoginUserName').poshytip('update',data);
							 $("#SubmitLogin").html(SubmitLoginInput);  
					   }

					   //alert(data);
					   return false; 
				   }
			  ); 
	
			return false; 
 }

function LoginNowForm(data) {
     $('#Login_Now').html('<div class="loading"><strong>登录成功！</strong>正在加载数据中...</div>');
	 $.get("<?php echo SURL; ?>/index.php?app=2&action=8",function (data){$('#Header_Member').html(data);}); 
	 $('#UserLogin').removeClass('topuserlogin_focus');
	 $(".LoginFrame").hide();
	 var loginrefresh=parseInt($("span[class='loginrefresh']").last().html());
	 
	 if(loginrefresh==1){
		   window.location.reload(); 
	 }else if(loginrefresh==2){
		   window.location.href=SURL;
	 }
}

function SubmitPasswordForm() {
													  
             var type=$("#ToolType").val();
			 
			 var username=$("#UserName");	
			 var email=$("#EMail");	
			 var mobile=$("#Mobile");	
			 
			 if(username.val()==""){
					   
						  alert("请输入用户名!");
						  username.focus();
						  return false; 
			 }
			 
			 if(type==0){
				 
				   if(email.val()==""){
					   
						  alert("请输入邮箱!");
						  email.focus();
						  return false; 
				   }
				   
			 }else{
				 
				   if(mobile.val()==""){
					   
						  alert("请输入手机号码!");
						  mobile.focus();
						  return false; 
				   }
				   
			 }
			 

					
             var SecCode=$("#SiteSecCode").val();
			 if (SecCode==""){
				    alert("请输入验证码!");
				    $("#SecCode").focus();
				    return false; 
			 }
			  

			$("#loading").html('<div class="loading">提交数据中...</div>');
			$("#loading").dialog('open');
			$("#loading").dialog({ title: '找回密码' });
				
			$.ajax({
				  type: "POST",
				  url: SURL+"/index.php?app=2&action=13&rand="+Math.random(),
				  data: '&SecCode='+SecCode+'&type_d='+type+'&EMail_s='+email.val()+'&Mobile_s='+mobile.val()+'&UserName_s='+username.val(),
				  success: function(data){
					   $("#loading").html(data);
					   return false; 
				  }
			});  
			  
			return false; 
													  
}
	 
	 
function seccode(){
	var img=SURL+'/index.php?app=2&action=9&rand='+Math.random();
	 $('#ShowSecCode').html('<a href="javascript:;" onclick="refreshcode()" style="cursor:hand;" title="点击换一张验证码"><img id="img_seccode" src="'+img+'" align="absmiddle"></a>');
	 $("#SiteSecCode").val("");
}

function refreshcode() {
	
	var img = SURL+'/index.php?app=2&action=9&rand='+Math.random();
	if(document.getElementById('img_seccode')) {
		$('#img_seccode').attr("src",img);
	}
} 

function SetToolType(id) {
	 $('#ToolType').val(id);
}

</script>


<div id="Login_Now" style="padding-top:10px;">

<ul>
    <form id="LoginNowForm">
    <p style="height:36px;"><label class="form_input_label" style="width:80px;">用户名：</label> <input id="LoginUserName" type="text" maxlength="80" class="form_input_text form_input_width_100 LoginUserName" value="" title="请输入登录用户名或邮箱或手机"/><span id="AjaxLoginUserNameError"></span></p>
    
    <p style="height:36px;padding-top:10px;"><label class="form_input_label" style="width:80px;">密码：</label> <input id="LoginPassword" type="password"  class="form_input_text form_input_width_100" title="请输入登录密码"/><span id="AjaxLoginPasswordError"></span></p>
    
    <input type="hidden" id="SecurityForm" value="<?php echo $this->SecurityForm(); ?>"/>
    
    <p style="margin-top:10px;padding-left:80px;" id="SubmitLoginNow"></p>
    
    </form>
    
    <div class="login_sns">
              <h3><em style="float:right;font-style: normal;"><a href="<?php echo SURL; ?>/index.php?app=2&action=13">忘记密码?</a></em><a href="javascript:;" id="ShowSNS" class="sns_down">通过合作网站登录</a></h3>
              <ul id="SNSList" style="display:none;padding-bottom:10px;">
               <?php  $snsarray=$this->GetMysqlArray('*'," ".$this->GetTable('sns')."  WHERE status_phpapp=0 ");  ?>
               <?php if ($snsarray){ ?>
                     <?php foreach ($snsarray as $value){ ?>
                     
                           <li><a href="<?php echo SURL; ?>/index.php?app=<?php echo $value['app_phpapp']; ?>" class="<?php echo $value['icon_small_phpapp']; ?>"><?php echo $value['name_phpapp']; ?>登录</a></li>
                           
                     <?php } ?>
               <?php } ?>
              </ul>
      
    </div>
    
</ul>


</div>



<iframe src="javascript:false;" id="NowLoginIframe" style="display:none;height:0px;width:0px;"></iframe>

                     </div>
                </li>
        
            </ul>
        </div>
    <?php } ?>


</div>



      
<?php if ($noticenum>0){ ?>
 	 <script type="text/javascript">$('#NewMemberNotice').html('<?php echo $noticenum; ?>');$('#MemberNotice').addClass('new');</script>
<?php } ?>


<?php if ($smsnum>0){ ?>
 	 <script type="text/javascript">$('#NewMemberMessage').html('<?php echo $smsnum; ?>');$('#MemberMessage').addClass('new');</script>
<?php } ?>


                          </div>

                      </div>

                </div> <!--HeaderTop End-->


<div class="navigation_box">
         <div id="Navigation">  
              <div class="navigation_wrap">
              
                 <div id="SearchTask" class="search_task">
                      <form action='<?php echo SURL; ?>/index.php' method="get" class="navigation_search_form">
      <input name="submit" type="submit" value=" " class="navigation_search_submit"/>
      <input name="search" type="text" value="<?php if (!empty($search)){ ?><?php echo $search; ?><?php }else{ ?>搜索 任务,人才,服务<?php } ?>" class="navigation_search"/>
      <input name="app" type="hidden" value="22"/>
</form>

                 </div>
                 
                  <div id="SiteCategory" class="sw_categorys_nav">
                    <div class="allcategorys">
                    <h3 class="title-item-hd">
                    <a href="javascript:void(0);">
                    所有任务分类
                    <s class="icon"></s>
                    </a>
                    </h3>
                    <ul class="sublist">
                           <?php 
require(SYS.'/data/cache/config/website_category.php');
 ?>
                    </ul>
                    </div>
                 </div>
            
             
                  <script type="text/javascript">
                      $('#SiteCategory').Z_TMAIL_SIDER_V2();
                  </script>
            
                <div class="navigation">
                      <ul>   
                            <?php $nav=$this->GetMysqlArray('navname,navurl,blank,site,appid'," ".$this->GetTable('nav')." ORDER BY displayorder ASC "); ?>

                            <?php if ($nav){ ?> 
                            
                                  <?php foreach ($nav as $key=>$value){ ?>
                                  
                                        <?php if ($value['site']==0){ ?>
                                                <li id="Nav_ID_<?php echo $value['appid']; ?>"><a href="<?php echo SURL; ?>/<?php echo $value['navurl']; ?>"<?php if (!$value['blank']){ ?> target="_blank"<?php } ?>><?php echo $value['navname']; ?></a></li> 
                                   
                                        <?php }else{ ?>
                                            	<li><a href="<?php echo $value['navurl']; ?>"<?php if (!$value['blank']){ ?> target="_blank"<?php } ?>><?php echo $value['navname']; ?></a></li>
                                        <?php } ?>
                                   
                                  <?php } ?>
                            
                            <?php } ?>
                            
                            <!--
                            <?php if ($this->uid){ ?>
                            
                                 <li><a href="<?php echo SURL; ?>/member.php?app=9">管理中心</a></li>
                            
                            <?php } ?>
                            -->
                            
                      </ul>
                     
                </div> <!--navigation End-->
                
    
            </div>   <!--navigation_wrap End-->
    
     </div> <!--Navigation End-->

</div>

<script type="text/javascript">
$(function(){	
	   var nowappid='<?php echo $this->app; ?>';
	   if(nowappid==10 || nowappid==27){
		    nowappid=49;
	   }
	   $("#Nav_ID_"+nowappid).addClass("focus");
	   
});
</script>


</div>


<div class="wrap">
<div class="content">



<?php if (PHPAPP::$config['sitecloseguide']==0){ ?>
<div id="SiteTool"> 
   <div class="site_share"><?php if (!PHPAPP::$config['opensharecode']){ ?>

<?php echo PHPAPP::$config['sharecode']; ?>

<?php } ?>

</div>
   <div id="SiteGuide" class="site_guide"><a class="small awesome" onclick="OpenWebsiteGuide(<?php echo $this->app; ?>)"><span class="balloon_ico">新手操作引导</span></a></div>
   <div id="WebsiteGuide" style="display:none">
   </div>
</div>
<?php } ?>

<script type="text/javascript" src="<?php echo TURL; ?>js/default.js"></script>
<link href="<?php echo TURL; ?>default.css" rel="stylesheet" type="text/css" />
<link href="<?php echo TURL; ?>member.css" rel="stylesheet" type="text/css" />




<!--PHPAPP2.0首页头部-->



<!--格子首页头部-->




<!--free首页头部-->
<div class="default_main">
       
    
        <div class="free_introduction_task">
               <p>有需求?</p>
               <h5>专业威客帮你解决问题</h5>
               <a href="<?php echo SURL; ?>/index.php?app=49&action=1" class="big orange awesome">立刻发布任务</a>
        </div>
     

       <div id="SlideList">
          
       <?php  $slidearray=$this->GetMysqlArray('*'," ".$this->GetTable('slide')." WHERE appid='56' AND status=0 ORDER BY displayorder ASC"); ?>
       <?php if ($slidearray){ ?>
           <ul id="Slide" style="height:360px;overflow:hidden;">
               
               <?php foreach ($slidearray as $key=>$value){ ?>
                     <li id="Slide_IMG_<?php echo $key+1; ?>"><a href="<?php echo $value['link']; ?>" target="_blank" title="<?php echo $value['subject']; ?>"><img src="<?php echo $value['image']; ?>" title="<?php echo $value['subject']; ?>" /></a></li>
               <?php } ?>
           
           </ul>

       <?php }else{ ?>
            <p>暂无数据 650* 360 px</p>
       <?php } ?>
            
</div>

<?php if ($slidearray){ ?>
     <div class="grid_slidetitle" id="SlideTitle">
           <ul>
           <?php foreach ($slidearray as $key=>$value){ ?>
                 <li id="Title_Slide_IMG_<?php echo $key+1; ?>"<?php if (($key+1)==1){ ?> class="focus"<?php } ?>><a href="<?php echo $value['link']; ?>" target="_blank" target="<?php echo $value['subject']; ?>"></a></li>
           <?php } ?>
           </ul>
     </div>
<?php } ?>    
    


</div>

           
<script type="text/javascript">
		SetSlide('#SlideList','#Slide','#SlideTitle',4000);
</script>

<!--free首页流程-->
<div class="free_process">
<h2><span class="color_f60">5</span> 步即可完成交易</h2>
<ul>
	<li style="text-indent: 40px;"><a href="<?php echo SURL; ?>/index.php?app=49&action=1">1.发布任务</a></li>
    <li style="text-indent: 25px;">2.选择威客稿件中标</li>
    <li style="text-indent: 60px;">3.托管赏金</li>
    <li style="text-indent: 50px;">4.威客交接完成稿件</li>
    <li style="text-indent: 50px;">5.雇主接收并确认支付</li>
</ul>
</div>

<!--free首页任务-->
<link href="<?php echo TURL; ?>task.css" rel="stylesheet" type="text/css" />
<?php 
    include_once(Core.'/class/skill_class_phpapp.php');		   
    $skilldata=new SkillClass();
 ?>          
           
<div class="default_main">
     <?php  $freelist=$this->GetMysqlArray('*'," ".$this->GetTable('task')." WHERE process>0 AND appid!=82 ORDER BY topbid DESC ,process ASC,dateline DESC LIMIT 0,10"); ?>

     <?php if ($freelist){ ?>
     
             <div class="task_parameter">
                    <ul>
                        <li>用户</li>
                        <li style="width: 350px;">标题</li>
                        <li style="width: 120px;">投稿/中标</li>
                        <li style="width: 180px;">技能</li>
                        <li style="width: 120px;">截止时间</li>
                        <li>操作</li>
                     </ul>
              </div>
          
              <?php foreach ($freelist as $key=>$value){ ?>
                 <div class="task_bid_show task_item<?php if ($value['openflash']){ ?> flashbid<?php } ?>">
                    <div class="task_item_info">
                        <?php if ($value['topbid']>0){ ?><div class="task_top" title="推荐"></div><?php } ?>
                        <div class="task_list_avatar"><?php echo $this->GetUserAvatar($value['uid'],0,1); ?></div>
                        <div class="task_list_subject">
                        <p><span class="color_f60">￥<?php if ($value['price1']>0){ ?><?php echo $value['price1']; ?>-<?php echo $value['price2']; ?><?php }else{ ?><?php echo $value['money']; ?><?php } ?></span> 
                        
                        <?php if ($value['credit']==1){ ?><span class="task_list_credit">保证选标</span><?php }elseif($value['credit']==2){ ?><span class="task_list_credit">不保证选标</span><?php } ?>
                        <?php if ($value['appid']==80){ ?><span class="task_list_credit">悬赏</span><?php }elseif($value['appid']==83){ ?><span class="task_list_credit">招标</span><?php } ?>
                        </p>
                        <p><a href="<?php echo SURL; ?><?php echo $value['url']; ?>" target="_blank"><?php echo $value['subject']; ?> <?php if ($value['addmoney']>0){ ?> <b>+<?php echo $value['addmoney']; ?></b><?php } ?></a> <?php if ($value['topid']>0){ ?><span class="top_icon" title="推荐置顶"></span><?php } ?>
                        </p>
                        </div>
                        <div class="task_list_draft"><?php echo $value['draft_number']; ?>/<?php echo $value['draft_success']; ?></div>
                        <div class="task_skill">
                            <?php  $skillsarr=$skilldata->GetSkillURL($value['skills']);  ?>
                            <ul>
                                <?php if ($skillsarr){ ?>
                                    <?php $newkey=0; ?>
                                    <?php foreach ($skillsarr as $key=>$skill){ ?>
                                         <?php $newkey++; ?>
                                         <li><a href="<?php echo $skill['url']; ?>"><?php echo $skill['name']; ?><?php if ($newkey!=count($skillsarr)){ ?>,<?php } ?></a></li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="task_endtime"><?php echo $this->Date('Y-m-d',$value['endtime']); ?></div>
                        <a href="<?php echo SURL; ?><?php echo $value['url']; ?>" class="small blue awesome viewtask">查看任务</a>
                    </div>
                    <p class="task_description">
                    	<?php if ($value['hide']){ ?><?php if (!$this->uid){ ?><span class="color_f60">任务内容已隐藏,请登录后查看！</span><?php }else{ ?>简介：<?php echo $value['description']; ?><?php } ?><?php }else{ ?>简介：<?php echo $value['description']; ?><?php } ?>
                    </p>
                 </div>
              <?php } ?>
          
       <?php }else{ ?>
             <p>暂时没有任务!</p>
       <?php } ?>

</div>


<script type="text/javascript">
$(function(){	
	$.PHPAPPMouseover('.task_item','.task_description');
	$.PHPAPPTaskFlash('.flashbid',5000);
});
</script>

<!--free首页技能-->
<div class="free_skills">
     <?php  $freeskills=$this->GetMysqlArray('*'," ".$this->GetTable('skills')." ORDER BY total DESC ,displayorder ASC LIMIT 0,75");if(!empty($LoginMemberArray['skills'])){ $myskills=explode(',',$LoginMemberArray['skills']);}
      ?>
     <h2>热门技能</h2>
     
     <ul>
    
         <?php if ($freeskills){ ?>
                <?php foreach ($freeskills as $value){ ?>
                      <?php  $ismyskill=0; ?>
                      <?php foreach ($myskills as $myskill){ ?>
                            <?php if ($myskill==$value['sid']){ ?>
                                 <?php  $ismyskill=1; ?>
                            <?php } ?>
                      <?php } ?>
                       
                      <?php  $skillsarr=$skilldata->GetSkillURL($value['sid']);  ?>
                      <?php if ($skillsarr){ ?>
                               <li><a href="<?php echo $skillsarr[$value['sid']]['url']; ?>"><span<?php if ($ismyskill){ ?> class="color_f60"<?php } ?>><?php echo $value['name']; ?>(<?php echo $value['total']; ?>)</span></a></li>
                      <?php } ?>
                <?php } ?>
         <?php } ?>
         
     </ul>

</div>



<!--PHPAPP2.0首页任务列表-->



<!--格子分类任务-->



<!--格子分类人才-->



<!--格子分类服务-->



<!--PHPAPP 2.0 服务商滚动-->
<?php 

   $servicetop=$this->GetMysqlArray('a.sid,a.uid,a.url,a.subject,b.thumb,a.unit,a.price'," ".$this->GetTable('task_seller_service')." AS a LEFT JOIN  ".$this->GetTable('file')." AS b ON  b.fid=a.logo  WHERE a.status=0 AND a.topbid>0  ORDER BY a.topbid DESC,a.dateline DESC LIMIT 0,24");

 ?>



<div class="seller_service">
<h3><dfn><a href="<?php echo SURL; ?>/index.php?app=82">更多></a></dfn>推荐服务</h3>

<?php if ($servicetop){ ?>
<ul id="ScrollService">
    <?php foreach ($servicetop as $key=>$value){ ?>

    <?php if ($key==0 || $key==4 || $key==8 || $key==12 || $key==16 || $key==20){ ?><li><?php } ?>
     <div>             
           <?php if (!empty($value['thumb'])){ ?>
                      
                      <?php if ($value['thumb']){ ?>  
                           <a href="<?php echo SURL; ?><?php echo $value['url']; ?>" class="help_small" style="background-image:none;" title="<?php echo $value['subject']; ?> </p>报价<?php echo $value['price']; ?>/<?php echo $value['unit']; ?></p>"><img src="<?php echo $value['thumb']; ?>"/></a>
                      <?php }else{ ?>
                            <img src="<?php echo SURL; ?>/images/seller/nopic.gif"/>
                      <?php } ?>
           <?php }else{ ?>
               
               
               <img src="<?php echo SURL; ?>/images/seller/nopic.gif"/>
              
                              
           <?php } ?>
    
    </div>
    <?php if ($key==3 || $key==7 || $key==11 || $key==15 || $key==19 || $key==23){ ?> </li><?php } ?>   
    

    <?php } ?>
</ul>  
<?php }else{ ?>
<li>暂没有数据</li>
<?php } ?>


</div>

<script type="text/javascript">		
	SetScroll('#ScrollService',3000);
</script>


<!--PHPAPP 2.0 帮助-->


<div class="default_main">

    <div class="default_site_help">
        <ul>
            <li class="site_help">新手指南</li>
            <li><a href="a">新人发任务指南</a></li>
            <li><a href="a">新人接任务指南</a></li>
            <li><a href="a"><?php echo PHPAPP::$config['sitename']; ?>规则</a></li>
        </ul>
        
        <ul>
            <li class="site_auction">诚信保障</li>
            <li><a href="a">收货满意后付款</a></li>
            <li><a href="a">服务商担保投标赔付</a></li>
            <li><a href="a">无卖家投标退款</a></li>
            <li><a href="a">有标雇主未选官方代选</a></li>
        </ul>
        
        <ul>
            <li class="site_pay">支付方式</li>
            <li><a href="a">支付宝</a></li>
            <li><a href="a">财付通</a></li>
            <li><a href="a">线下银行汇款</a></li>
        </ul>
        
        <ul>
            <li class="site_heart">售后服务</li>
            <li>程序咨询：0771-</li>
            <li>咨询QQ：1468078656</li>
        </ul>
    </div>
    
</div>


<!--PHPAPP 2.0 友情链接-->
<?php 
	//logo
	$linklogo=$this->GetMysqlArray('*'," ".$this->GetTable('links')." WHERE logo!='' ORDER BY displayorder ASC LIMIT 0,20");
			
	$linktxt=$this->GetMysqlArray('*'," ".$this->GetTable('links')." WHERE logo='' ORDER BY displayorder ASC LIMIT 0,20");
	   
 ?>



<div class="default_main">
     <div class="default_link">
         <h2><dfn><a href="<?php echo SURL; ?>/index.php?app=23&action=3">更多</a></dfn>友情链接</h2>
         
          <ul>
            <?php if ($linklogo){ ?>
              
              <?php foreach ($linklogo as $value){ ?>
              <li> <a href="<?php echo $value['siteurl']; ?>" target="_blank" title="<?php echo $value['description']; ?>"><img name="<?php echo $value['sitename']; ?>" src="<?php echo $value['logo']; ?>" title="<?php echo $value['sitename']; ?>" /></a>
              </li>
              <?php } ?>
           <?php } ?>
         </ul>
         <ul>
             <?php if ($linktxt){ ?>
              
              <?php foreach ($linktxt as $value){ ?>
              <li>
               <a href="<?php echo $value['siteurl']; ?>" target="_blank" title="<?php echo $value['description']; ?>"><?php echo $value['sitename']; ?></a>
              </li>
              <?php } ?>
           <?php } ?>
         </ul>
     </div>
</div>


<!--底部-->

				 

                     </div> <!--content End-->
                 </div> <!--wrap End-->
                 
                 <div id="Footer" class="footer">   
                      <div class="footermenu">
                            <div class="footermenulist">
                               <ul>
                                     <?php  $navtop=$this->GetMysqlArray('*'," ".$this->GetTable('nav_bottom')."  ORDER BY displayorder ASC"); ?>
                                     <?php if ($navtop){ ?>
                                         <?php foreach ($navtop as $key=>$value){ ?>
                                             <li><a href="<?php echo $value['navurl']; ?>" <?php if ($value['blank']==0){ ?>target="_blank"<?php } ?> title="<?php echo $value['navname']; ?>"><?php echo $value['navname']; ?></a></li>
                                         <?php } ?>
                                     <?php } ?>
                               </ul>
                            </div>
                            
                           <?php if (PHPAPP::$config['sitecloselanguage']==0){ ?> 
                                   <?php if ($systemlanguage=$this->SystemLanguage()){ ?> 
                                        <div id="SystemLanguage" class="systemlanguage">
                                        <?php  global $language; ?>
                                        
                                            <div id="SystemLanguageList" class="languagelist">   
                                             <h3>请选择国家地区语言</h3>  
                                                <ul>
                                                <?php foreach ($systemlanguage as $value){ ?>
                                                         <li><a href="http://<?php echo $value['domain_phpapp']; ?>" class="<?php echo $value['style_phpapp']; ?>" title="<?php echo $value['name_phpapp']; ?>"><?php echo $value['name_phpapp']; ?></a></li>
                                                <?php } ?>
                                                </ul>
                                            </div>
                                            
                                        <h3><em>LANGUAGE</em><span><a href="javascript:void(0);" title="当前语言<?php echo $systemlanguage[$language]['name_phpapp']; ?>" id="ShowSystemLanguage"><?php echo $systemlanguage[$language]['name_phpapp']; ?></a></span></h3>
            
                                        </div>
                                   <?php } ?>
                           <?php } ?>
                       </div>
                       
                       <div class="footercopyright">
                            <div class="copyright">
                                <p>
                                &copy; 2006-<?php echo $this->Date("Y",$this->NowTime()); ?> <?php if (!intval(PHPAPP::$config['phpappauth'])){ ?>威客网 版权所有  <?php }else{ ?> <a href="<?php echo SURL; ?>"><?php echo PHPAPP::$config['sitename']; ?></a> <?php } ?> <?php echo $this->SystemRunTime(); ?>
                                </p>
                                
                                <p>
                                服务热线：400-000-00000 在线咨询QQ： 956560090
                                </p>
                                
                                <p>
                                <?php if (PHPAPP::$config['siteicp']){ ?><a href="http://www.miitbeian.gov.cn" target="_blank"><?php echo PHPAPP::$config['siteicp']; ?></a><?php } ?> 
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
     
     
     
     
     <!--[if lte IE 6]> 
    	<link href="<?php echo TURL; ?>form_ie6.css" rel="stylesheet" type="text/css" />
     <![endif]-->

  </body>
</html>

