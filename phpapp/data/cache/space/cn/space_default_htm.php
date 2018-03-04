<?php if(!defined('IN_PHPAPP')){exit('Data error');} ?><?php 
            
$user=$this->GetMysqlOne('b.username,b.uid,b.dateline AS regtime,b.usergroup,b.logintime,c.certificate,c.domainname,e.credit,e.hao,e.zhong,e.cha,d.credit AS credits,c.themes,c.residecity,g.speed,g.attitude,g.quality',"  (((".$this->GetTable('member')." AS b LEFT JOIN ".$this->GetTable('member_info')." AS c ON b.uid=c.uid)																																																																LEFT JOIN ".$this->GetTable('member_account')." AS d ON b.uid=d.uid)  LEFT JOIN ( SELECT credit,uid,hao,zhong,cha FROM ".$this->GetTable('credit')." WHERE type=1 ) AS e ON b.uid=e.uid ) LEFT JOIN ".$this->GetTable('credit_score')." AS g ON c.uid=g.uid WHERE b.uid='$this->spaceuid' ");

if($this->app=82){
     //SEO
     PHPAPP::$SEO['title']=$service['subject'];
	 PHPAPP::$SEO['keywords']=$service['keywords'];
	 PHPAPP::$SEO['description']=$service['description'];

}else{
      //SEO
      PHPAPP::$SEO['title']=$user['username'].'�ĸ��˿ռ�';
      PHPAPP::$SEO['keywords']=$user['username'].',�ռ�';
      PHPAPP::$SEO['description']=$user['username'].'�ĸ��˿ռ�';
}
                            

 ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

<!-- Widescreen ʹ�ÿ���ͷ��ɾ�� widescreen.css -->
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
		            alert("������Ľ���ʽ��������������!");
		            $("#NewAward").focus();
		            return false; 
	        }
			
			if(confirm("���յ�������ȷ���ջ����Ƿ�ȷ�ϲ����⽱��"+award+"Ԫ?")){
		           $("#loading").html('<div class="loading">�ύ������...</div>');

				   SubmitDelivery(OderID,award);
			
			}
						  
		   
	  }
	  
	  
	  function PaymentOrders(OderID,tid){
		    if(confirm("�Ƿ�ȷ��ҪΪ�˶���֧��?")){
				 $("#loading").dialog({
						  title:"����֧��",	
						  width: 500,
						  position: ['center',160],
						  height:'auto'
				 });
				 
				 $("#loading").dialog('open');
							  
				 $("#loading").html('<div class="loading">����֧����...</div>');
				
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
		    if(confirm("�Ƿ�ȷ��Ҫ�رն���?")){
				 $("#loading").dialog({
						  title:"�����ر�",	
						  width: 500,
						  position: ['center',160],
						  height:'auto'
				 });
				 
				 $("#loading").dialog('open');
							  
				 $("#loading").html('<div class="loading">����֧����...</div>');
				
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
						  title:"�ύ��Ʊ",	
						  width: 300,
						  position: ['center',160],
						  height:160
				});
				
				$("#loading").dialog('open');
						  
				$("#loading").html('<div class="loading">�ύ������...</div>');
				
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
								  title:"��������",	
								  width: 600,
								  position: ['center',160],
								  height:'auto'
					});
							 
					$("#loading").dialog('open');
						  
					$("#loading").html('<div class="loading">�ύ������...</div>');
					
					$("#loading").html('<strong><span style="color:#F00">���⽱��</span>���</strong> <input type="text"  id="NewAward" size="50" maxlength="8" class="form_input_text form_input_width_100"  value="0" /> Ԫ <input type="button" value="ȷ���ջ�" onclick="SubmitAward(\''+oid+'\')" class="form_button"/><p style="padding-top:6px;"><strong>��ʾ��</strong>���⽱��ָ���Ը���������ͽ�������뽱��Ĭ��0Ԫ��</p>');
					
					
                    
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
                       
                        alert("��ѡ�񶩵�����!");
                        return false;
                   }
				   
				   if(confirm("���յ�������ȷ���ջ����Ƿ�ȷ��?")){
				
						  $("#loading").dialog({
								  title:"��������",	
								  width: 600,
								  position: ['center',160],
								  height:'auto'
						  });
							 
						  $("#loading").dialog('open');
						  
						  $("#loading").html('<div class="loading">�ύ������...</div>');
						  
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
                       
                        alert("��ѡ�񶩵�����!");
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
			
			$("#TaskCreditLevel").html('<div class="loading">�ύ������...</div>');
            
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
      
      
      <div id="TaskCreditLevel" style="display:none;padding:20px;" title="��������">
  
        <div class="credit_level" id="CreditLevel">
        <ul>
        <li class="credit_hao"></li>
        <li class="credit_cha"></li>
        <li class="credit_zhong"></li>
        </ul>
        
        <ul>
        <li><input name="creditradio" type="radio" value="0" checked />����</li> 
        <li><input name="creditradio" type="radio" value="1"/>����</li> 
        <li><input name="creditradio" type="radio" value="2"/>����</li>
        </ul>
        </div>
        
        <div class="task_score">
             <h3>���֣�</h3>
             
                 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>
                    <div class="score_works_peed">�����ٶȣ�<span id="WorksPeedScore" class="color_f60">0.0</span> �� &nbsp;
                
                <a href="javascript:;" class="score_level" id="WorksPeed">
                
                      <li title="1�� �ٶ�����̫���ף��ǳ�������" id="WorksPeed_1"></li>
                      
                      <li title="2�� �ٶȺ�����������" id="WorksPeed_2"></li>
                      
                      <li title="3�� �ٶȻ���" id="WorksPeed_3"></li>
                      
                      <li title="4�� �ٶ����죬����" id="WorksPeed_4"></li>
                      
                      <li title="5�� �ٶȷǳ��죬�ǳ�����" id="WorksPeed_5"></li>
                
                </a>
                
                </div>
                
                <input id="WorkSpeedValue" type="hidden" value="0" /></td>
                  </tr>
                  <tr>
                    <td>
                    <div class="score_works_attitude">����̬�ȣ�<span id="WorksAttitudeScore" class="color_f60">0.0</span> �� &nbsp; 
                
                <a href="javascript:;" class="score_level" id="WorksAttitude">
                
                      <li title="1�� ����̬�Ⱥܲ�����ˡ�˵�໰����ֱ���ѹ˿͵�����" id="WorksAttitude_1"></li>
                
                      <li title="2�� �����е㲻�ͷ�����ŵ�ķ���Ҳ���ֲ���" id="WorksAttitude_2"></li>
                      
                      <li title="3�� ���һظ����������̬��һ�㣬̸���Ϲ�ͨ˳��" id="WorksAttitude_3"></li>
                      
                      <li title="4�� ���ҷ���ͦ�õģ���ͨͦ˳���ģ��������⣬����" id="WorksAttitude_4"></li>
                      
                      <li title="5�� ���ҵķ���̫���ˣ����Ƿǳ��ܵ�����ȫ��������ֵ" id="WorksAttitude_5"></li>
                
                </a>
                </div>
                <input  id="WorksAttitudeValue" type="hidden" value="0" />
                    </td>
                  </tr>
                   <tr>
                    <td><div class="score_works_quality">���������<span id="WorksQualityScore" class="color_f60">0.0</span> �� &nbsp; 
                
                <a href="javascript:;"  class="score_level" id="WorksQuality">
                
                      <li title="1�� ���̫���ף����������������ز������ǳ�����" id="WorksQuality_1"></li>
                
                      <li title="2�� ���������������������Ĳ�����������" id="WorksQuality_2"></li>
                      
                      <li title="3�� ����һ�㣬û��������������ô��" id="WorksQuality_3"></li>
                      
                      <li title="4�� �������������������Ļ���һ�£�����ͦ�����" id="WorksQuality_4"></li>
                      
                      <li title="5�� �����ǳ��ã���������������ȫһ�£��ǳ�����" id="WorksQuality_5"></li>
                
                </a>
                <input id="WorksQualityValue" type="hidden" value="0" />
                </td>
                  </tr>
                </table>
                
                <p>��ʾ��<span style="color:#999">�����ָ�����ǵȼ��Ͻ�������</span></p>
        </div>
        
        <p>���(100����)</p>
        
        <textarea id="OderContent" class="form_input_text" style="width:550px;height:100px;margin-bottom:10px;"></textarea><p style="text-align:center;margin-top:10px;">
        <input id="OderID" type="hidden" value="0" />
        <input name="Submit" type="button" value="ȷ��" onclick="SubmitCredit()" class="form_button"/>
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
                       
                        alert("��ѡ�񶩵�����!");
                        return false;
                   }
                    
              }
          

              SellerSubmitDelivery(OderID);
          
      }
      

      function UploadOrderFile(OderID){

			$.SaveContent();
			
            var content=$("#SellContent").val();
			
			$("#loading").dialog({
                    title:"�ϴ������ļ�",	
                    width: 300,
                    position: ['center',160],
                    height:160
            });
               
            $("#loading").dialog('open');
            
            $("#loading").html('<div class="loading">�ϴ�������...</div>');
   
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
            
		   if(confirm("�Ƿ�ȷ�����ϴ��ļ�����?")){
			   
					$("#loading").dialog({
							  title:"ȷ���ļ�����",	
							  width: 500,
							  position: ['center',160],
							  height:'auto'
					});
					 
					$("#loading").dialog('open');
								  
					$("#loading").html('<div class="loading">����ȷ�Ͻ�����...</div>');
					
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
                       
                        alert("��ѡ�񶩵�����!");
                        return false;
                   }
                    
              }
          
          
          
            $("#loading").dialog({
                    title:"��������",	
                    width: 600,
                    position: ['center',160],
                    height:'auto'
            });
               
            $("#loading").dialog('open');
            
            $("#loading").html('<div class="loading">��ȡ������...</div>');
            
            
            $("#loading").html('<div class="credit_level" id="SellerCreditLevel"><ul><li class="credit_hao"></li><li class="credit_cha"></li><li class="credit_zhong"></li></ul><ul><li><input name="creditradio" type="radio" value="0" checked />����</li> <li><input name="creditradio" type="radio" value="1"/>����</li> <li><input name="creditradio" type="radio" value="2"/>����</li></ul></div><p>���(100����)</p><textarea id="SellerCreditContent" class="form_input_text" style="width:550px;height:100px;margin-bottom:10px;"></textarea><p style="text-align:center;margin-top:10px;"><input name="Submit" type="button" value="ȷ��" onclick="SellerSubmitCredit(\''+OderID+'\')" class="form_button" style="width:80px"/></p>');
            
      
          
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
<div id="loading" style="display:none" title="��ȡ������..."></div>

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
                                 <strong id="NowCity">������</strong> <a href="<?php echo SURL; ?>" id="ChangeCityTitle" title="�л�һ���µĳ�������">[�л�����]</a>
                                 -->
                              </div>
                          </div>
 
                          <div id="Header_Member">

                               <?php if ($this->uid>0){ ?>

      <link href="<?php echo TURL; ?>evaluate.css" rel="stylesheet" type="text/css" />
      <!-- ��ȡ��ǰ��¼�߲�����Ϣ --> 
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
              <a href="<?php echo SURL; ?>/index.php?app=49&action=1" title="��ѷ���һ������" id="TopAddTask">��Ҫ��������</a>
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
                    <li class="member_message"><a href="javascript:void(0)" id="MemberMessage" class="default" title="վ�ڶ���" onclick="GetMemberMessage()"><sub id="NewMemberMessage"></sub></a></li>
                    <li class="member_notice"><a href="javascript:void(0)" id="MemberNotice" class="default" title="��վ֪ͨ" onclick="GetMemberNotice()"><sub id="NewMemberNotice"></sub></a></li>
                    <li class="member_taskfeed"><a href="javascript:void(0)" id="MemberTaskFeed" class="default" title="����̬"><sub id="NewMemberTaskFeed"></sub></a></li>
                    <li><a href="javascript:void(0)" id="MemberMoney" class="default" title="��������<?php echo $LoginMemberArray['money']; ?>"><span>��<?php echo $LoginMemberArray['money']; ?></span></a></li>
                    <li><a href="javascript:void(0)" id="MemberMenu" class="default" title="�û�����"><?php echo $this->username; ?><?php if ($LoginMemberArray['userpost']==1){ ?>(����)<?php }elseif($LoginMemberArray['userpost']==2){ ?>(����)<?php } ?></a></li>
                    
                     <!--
                    <?php if ($LoginMemberArray['userpost']==2){ ?>
                   		 <li><a href="javascript:void(0)" id="MemberBuyer" class="default" title="���ǹ���">���ǹ���</a></li>
                    <?php }elseif($LoginMemberArray['userpost']==1){ ?>
                    	 <li><a href="javascript:void(0)" id="MemberSeller" class="default" title="��������">��������</a></li>
                    <?php } ?>
                    -->

                    <?php if ($LoginMemberArray['userpost']==1){ ?>
                         <li class="member_addtask_small"><a href="<?php echo SURL; ?>/index.php?app=49&action=1" title="��ѷ���һ������" id="TopAddTask">��������</a></li>
                    <?php }elseif($LoginMemberArray['userpost']==2){ ?>
                    	 <li class="member_addtask_small"><a href="<?php echo SURL; ?>/member.php?app=82&action=1" title="��ѷ���һ������" id="TopAddTask">��������</a></li>
                    <?php } ?>
                </ul>
            </div>
        
            <div id="MemberMessageView" class="header_member_default">
                <div id="TopMessageDataTab" style="border: none;padding:0px;">
                    <ul>
                        <li style="margin-left:10px;"><a href="#TopMessageDataList"><strong>����վ�ڶ���</strong></a></li>
                    </ul>
                    
                    <div id="TopMessageDataList" class="top_member_list">
                        <ul>
                        </ul>
                    </div>
                    <div class="more_info"><dfn><a href="javascript:void(0)" onclick="DeleteMemberMessage(0)">[�������]</a></dfn><em><a href="<?php echo SURL; ?>/member.php?app=7">�鿴����>></a></em></div>
                        
                  </div>
            </div>
            
            <div id="MemberNoticeView"  class="header_member_default">
                 <div id="TopNoticeDataTab" style="border: none;padding:0px;">
                    <ul>
                        <li style="margin-left:10px;"><a href="#TopNoticeDataList"><strong>����֪ͨ</strong></a></li>
                    </ul>
                    
                    <div id="TopNoticeDataList" class="top_member_list">
                        <ul>
                        </ul>
                    </div>
                    <div class="more_info"><dfn><a href="javascript:void(0)" onclick="DeleteMemberNotice(0)">[�������]</a></dfn><em><a href="<?php echo SURL; ?>/member.php?app=45">�鿴����>></a></em></div>
                        
                  </div>
            </div> 
        
        
            <div id="MemberTaskFeedView"  class="header_member_default">
                 <div id="TopTaskFeedTab" style="border: none;padding:0px;">
                    <ul>
                        <li style="margin-left:10px;"><a href="#TopFeedViewList"><strong>��������̬</strong></a></li>
                    </ul>
                    
                    <div id="TopFeedViewList" class="top_member_list">
                        <ul>
                        </ul>
                    </div>
                    <div class="more_info"><dfn><a href="javascript:void(0)" id="TaskFeedViewEmpty">[�������]</a></dfn>
                    
                    <!--
                    <em><a href="<?php echo SURL; ?>/member.php?app=5&action=2">�鿴����>></a></em>
                    -->
                    </div>
                        
                  </div>
            </div> 
            
            
            <div id="MemberMoneyView"  class="header_member_default member_menu_list">
                <ul>
                     <li><a href="<?php echo SURL; ?>/member.php?app=5&action=2">��Ҫ��ֵ</a></li>
          			 <li><a href="<?php echo SURL; ?>/member.php?app=5&action=3">��Ҫ����</a></li>
                </ul>
            </div> 
            
            <div id="MemberMenuView" class="header_member_default member_menu_list">
                <ul>
                     <li><a href="<?php echo SURL; ?>/member.php?app=9">��������</a></li>
                     <?php  $navtop=$this->GetMysqlArray('*'," ".$this->GetTable('nav_top')."  ORDER BY displayorder ASC"); ?>
                     <?php if ($navtop){ ?>
                          <?php foreach ($navtop as $value){ ?>
                               <li><a href="<?php echo $value['navurl']; ?>" <?php if ($value['blank']==0){ ?>target="_blank"<?php } ?>><?php echo $value['navname']; ?></a></li>
                          <?php } ?>
                       
                     <?php } ?>
                    <li><a href="<?php echo SURL; ?>/index.php?app=2&action=10">��ȫ�˳�</a></li>
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
                <li class="nobackground" title="����"><a href="<?php echo SURL; ?>/index.php?app=57" title="��������">����</a></li><li><a href="<?php echo SURL; ?>/index.php?app=2&action=2" title="���ע���ʺ�">���ע��</a></li>
                
                <li><a href="javascript:void(0);" title="��¼����վ" id="UserLogin" class="topuserlogin_default">��¼</a>
                     <div class="LoginFrame" id="NowLoginFrame" title="��վ��¼">
                             <link href="<?php echo TURL; ?>sns.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">

var loading='<img src="<?php echo TURL; ?>images/loading.gif" alt="���ڶ�ȡ������..." />';
var right='<img src="<?php echo TURL; ?>images/right.png" alt="��ȷ" class="checkright" />';
var error='<img src="<?php echo TURL; ?>images/error.png" alt="����" />';
var SubmitLoginInput='<input type="submit" value="�� ¼" onclick="return SubmitLoginNow();" class="form_button"/>';
var LoginInputPrompt='�û���/����/�ֻ�';


function VerifyLoginPassword(){
	          $('#AjaxLoginPasswordError').html(loading);
		  
              var password=$("#LoginPassword").val();

			  if(!password.length){
				   $('#AjaxLoginPasswordError').html(error);

				   var data='��,����������!';
			  }else if(password.length<6){
				   
				   $('#AjaxLoginPasswordError').html(error);
				   var data='���벻��С��6λ!';
				   
			  }else{
				    $('#AjaxLoginPasswordError').html('');
					var data='����λ������!';
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
				  $('#SiteLoginUserName').poshytip('update','�������û�����');
				  return false; 
			 }else{
					 if(!username.length){
						 $('#SiteLoginUserName').focus();
						 $('#SiteAjaxLoginUserNameError').html(error);
						 $('#SiteLoginUserName').poshytip('update','�Բ���!�ǳƲ���Ϊ��!');
		
						 return false; 
					 }else{
						 if(username.length>1){
							 $('#SiteAjaxLoginUserNameError').html('');
						 }else{
							  $('#SiteLoginUserName').focus();
							  $('#SiteAjaxLoginUserNameError').html(error);
							  $('#SiteLoginUserName').poshytip('update','�Բ���!�û���̫����!');
							 
							  return false; 
						 }
						 
					 }
			 }
		
			 var password=$("#SiteLoginPassword").val();
			 if(!password.length){
				 	
			     $('#SiteLoginPassword').focus();
				 $('#SiteAjaxLoginPasswordError').html(error);
				 $('#SiteLoginPassword').poshytip('update','�Բ���!���벻��Ϊ��!');
				 
		         return false; 
			 }else{
			
				 if(password.length>=6){
				     $('#SiteAjaxLoginPasswordError').html('');
				 }else{
					 $('#SiteLoginPassword').focus();
				     $('#SiteAjaxLoginPasswordError').html(error);
					 $('#SiteLoginPassword').poshytip('update','�Բ���!���벻��С��6λ!');
		
					 return false; 
				 }
			 }
			 
			 
			 
			 <?php if (PHPAPP::$config['loginiscode']){ ?>
			 var seccode=$("#SiteSecCode").val();
			 if(!seccode.length){
			     $('#SiteSecCode').focus();
				 $('#SiteAjaxSecCodeError').html(error);
			     $('#SiteAjaxSecCode').html('<div class="register_reg_tips">�Բ���!��������֤��!</div>');
		         return false; 
			 }else{
				 if(seccode.length!=4){
					 $('#SiteSecCode').focus();
				     $('#SiteAjaxSecCodeError').html(error);
			         $('#SiteAjaxSecCode').html('<div class="register_reg_tips">�Բ���!������4λ��֤��!</div>');
		             return false; 
				 }
			
			 }	
			 
			 <?php } ?>
			 
			
			$("#loading").html('<div class="loading">��¼��...</div>');
			$("#loading").dialog('open');
			$("#loading").dialog({ title: '��¼��' });
			 
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
				  $('#LoginUserName').poshytip('update','�������û�����');
				  return false; 
			 }else{
					 if(!username.length){
						 $('#LoginUserName').focus();
						 $('#AjaxLoginUserNameError').html(error);
						 $('#LoginUserName').poshytip('update','�Բ���!�ǳƲ���Ϊ��!');
		
						 return false; 
					 }else{
						 if(username.length>1){
							 $('#AjaxLoginUserNameError').html('');
						 }else{
							  $('#LoginUserName').focus();
							  $('#AjaxLoginUserNameError').html(error);
							  $('#LoginUserName').poshytip('update','�Բ���!�û���̫����!');
							 
							  return false; 
						 }
						 
					 }
			 }
		
			 var password=$("#LoginPassword").val();
			 if(!password.length){
				 	
			     $('#LoginPassword').focus();
				 $('#AjaxLoginPasswordError').html(error);
				 $('#LoginPassword').poshytip('update','�Բ���!���벻��Ϊ��!');
				 
		         return false; 
			 }else{
			
				 if(password.length>=6){
				     $('#AjaxLoginPasswordError').html('');
				 }else{
					 $('#LoginPassword').focus();
				     $('#AjaxLoginPasswordError').html(error);
					 $('#LoginPassword').poshytip('update','�Բ���!���벻��С��6λ!');
		
					 return false; 
				 }
			 }
            
			 $("#SubmitLogin").html('<div class="loading">��¼��...</div>');
			 
	
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
     $('#Login_Now').html('<div class="loading"><strong>��¼�ɹ���</strong>���ڼ���������...</div>');
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
					   
						  alert("�������û���!");
						  username.focus();
						  return false; 
			 }
			 
			 if(type==0){
				 
				   if(email.val()==""){
					   
						  alert("����������!");
						  email.focus();
						  return false; 
				   }
				   
			 }else{
				 
				   if(mobile.val()==""){
					   
						  alert("�������ֻ�����!");
						  mobile.focus();
						  return false; 
				   }
				   
			 }
			 

					
             var SecCode=$("#SiteSecCode").val();
			 if (SecCode==""){
				    alert("��������֤��!");
				    $("#SecCode").focus();
				    return false; 
			 }
			  

			$("#loading").html('<div class="loading">�ύ������...</div>');
			$("#loading").dialog('open');
			$("#loading").dialog({ title: '�һ�����' });
				
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
	 $('#ShowSecCode').html('<a href="javascript:;" onclick="refreshcode()" style="cursor:hand;" title="�����һ����֤��"><img id="img_seccode" src="'+img+'" align="absmiddle"></a>');
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
    <p style="height:36px;"><label class="form_input_label" style="width:80px;">�û�����</label> <input id="LoginUserName" type="text" maxlength="80" class="form_input_text form_input_width_100 LoginUserName" value="" title="�������¼�û�����������ֻ�"/><span id="AjaxLoginUserNameError"></span></p>
    
    <p style="height:36px;padding-top:10px;"><label class="form_input_label" style="width:80px;">���룺</label> <input id="LoginPassword" type="password"  class="form_input_text form_input_width_100" title="�������¼����"/><span id="AjaxLoginPasswordError"></span></p>
    
    <input type="hidden" id="SecurityForm" value="<?php echo $this->SecurityForm(); ?>"/>
    
    <p style="margin-top:10px;padding-left:80px;" id="SubmitLoginNow"></p>
    
    </form>
    
    <div class="login_sns">
              <h3><em style="float:right;font-style: normal;"><a href="<?php echo SURL; ?>/index.php?app=2&action=13">��������?</a></em><a href="javascript:;" id="ShowSNS" class="sns_down">ͨ��������վ��¼</a></h3>
              <ul id="SNSList" style="display:none;padding-bottom:10px;">
               <?php  $snsarray=$this->GetMysqlArray('*'," ".$this->GetTable('sns')."  WHERE status_phpapp=0 ");  ?>
               <?php if ($snsarray){ ?>
                     <?php foreach ($snsarray as $value){ ?>
                     
                           <li><a href="<?php echo SURL; ?>/index.php?app=<?php echo $value['app_phpapp']; ?>" class="<?php echo $value['icon_small_phpapp']; ?>"><?php echo $value['name_phpapp']; ?>��¼</a></li>
                           
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
      <input name="search" type="text" value="<?php if (!empty($search)){ ?><?php echo $search; ?><?php }else{ ?>���� ����,�˲�,����<?php } ?>" class="navigation_search"/>
      <input name="app" type="hidden" value="22"/>
</form>

                 </div>
                 
                  <div id="SiteCategory" class="sw_categorys_nav">
                    <div class="allcategorys">
                    <h3 class="title-item-hd">
                    <a href="javascript:void(0);">
                    �����������
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
                            
                                 <li><a href="<?php echo SURL; ?>/member.php?app=9">��������</a></li>
                            
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





<link href="<?php echo TURL; ?>space/stylelist.css" rel="stylesheet" type="text/css" />

<link href="<?php echo TURL; ?>form.css" rel="stylesheet" type="text/css" />

<link href="<?php echo TURL; ?>member.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo TURL; ?>js/member.js"></script>

<script type="text/javascript">
$(function(){	
  
    $("#loading").dialog({
			  title:"�ռ���",	
			  width: 606,
			  position: ['center',160],
			  modal: true,
			  autoOpen: false,
              height:'auto'
	});
		 
			  
	$("#ListSpaceStyle").click( function () {
					
					
		 $("#loading").html('<div class="loading">��ȡ������...</div>');
	     $("#loading").dialog('open');

		 $.get(SURL+"/space.php",{app:8,action:2},
			  
		        function (data){
				      $("#loading").html(data);
		 });   			
					
																																																																						  });     
	

   
});

function ChangeStyle(id,dir){
	
		var spacestyle=dir+'/css/space.css';
	   	$("#SpaceStyle").attr("href",spacestyle);						  
										  
	    //alert(id);
	    $.ajax({
				type: "POST",
				url: SURL+'/space.php?app=8&action=2',
				data: "&sid="+id
	    });
	  
}

function AjaxSpaceStyle(id,page,sqlorder,iforder){

	     $("#loading").html('<div class="loading">��ȡ������...</div>');

	  	 $.ajax({
				type: "GET",
				url: SURL+'/space.php',
				data: "app=8&action=2&page="+page,
				success: function(data){
					 $("#loading").html(data);
					 
				}
	    });
}

</script>


<?php if ($user['themes']>0){ ?>
      
      <?php 
      
        $spacestyle=$this->GetMysqlOne('dir'," ".$this->GetTable('space_style')." WHERE sid='$user[themes]'");
        
       ?>
      
      <?php if ($spacestyle){ ?>
      
          <link id="SpaceStyle" href="<?php echo TURL; ?>space/themes/<?php echo $spacestyle['dir']; ?>/css/space.css" rel="stylesheet" type="text/css" />
      <?php }else{ ?>
          <link id="SpaceStyle" href="<?php echo TURL; ?>space/themes/default/css/space.css" rel="stylesheet" type="text/css" />
      <?php } ?>
      
<?php }else{ ?>
      <link id="SpaceStyle" href="<?php echo TURL; ?>space/themes/default/css/space.css" rel="stylesheet" type="text/css" />
<?php } ?>


<script type="text/javascript">
function AddFavoriteSpace(obj,url, title) {
	 
	 if($.browser.msie){
		    window.external.addFavorite(url,title);
	 }else{
		   obj.setAttribute("rel", "sidebar"), obj.title = title, obj.href = url;
	 }
	 
	 return false;
    
};
</script>

<div class="space_main">
     
    
<div class="space_main_left space_main_left_width">

<div class="space_box">
    
    <div class="avatar"><?php echo $this->GetUserAvatar($this->spaceuid,2,1); ?></div>
    
    <div class="space_sign_name"><?php echo $user['username']; ?></div>
        
     
     <div class="space_sign_url">

                     <a href="<?php if ($user['domainname']){ ?> http://<?php echo $user['domainname']; ?><?php echo PHPAPP::$config['domainname']; ?> <?php }else{ ?><?php echo SURL; ?>/space.php?app=8&uid=<?php echo $user['uid']; ?><?php } ?>" onClick="AddFavoriteSpace(this,this.href,this.title);" title="<?php echo $user['username']; ?>" class="small blue awesome">�ղ�</a> 
           

      </div> 
      
      <?php if (!PHPAPP::$config['userspacestyle']){ ?>
      <div class="space_sign_url">
      <?php if ($this->uid==$this->spaceuid){ ?><a href="javascript:;" id="ListSpaceStyle" class="small blue awesome" title="�������">�������</a><?php } ?>
      </div>
      <?php } ?>
      
       <span id="residecity" class="space_residecity">
                <?php if ($user['residecity']){ ?>
                     <?php echo $this->GetSelectCategory('category_city',$user['residecity'],'residecity','','',1); ?>
                <?php } ?>
       </span>
                
     <div class="space_hire">
                      <div class="space_hire_avatar"><?php echo $this->GetUserAvatar($this->spaceuid,0,1); ?></div>
                       <p><a href='<?php echo SURL; ?>/index.php?app=82&action=2&uid=<?php echo $this->spaceuid; ?>'>����TA</a></p>
                 </div>

       
    <div class="user_info">

    
        <p style="display:inline-block;padding-top:6px;"><?php echo $this->GetCertificateIcon($user['certificate'],array('Mobile'=>'�ֻ�','Mail'=>'����','Personal'=>'����ʵ��','Company'=>'��˾ʵ��')); ?></p>
        
   
        <p>
            <?php if ($user['credit']){ ?><span class="<?php echo $this->GetCreditLevel($user['credit'],1); ?>" title="�������û��� <?php echo $user['credit']; ?>"></span> ������ <?php echo $this->LevelRate($user['hao'],$user['zhong'],$user['cha']); ?>% <?php }else{ ?>������������ֵ<?php } ?>
        </p>
     
     
      <div class="user_score">  
      <div class="seller_score_name">
       <p>�����ٶ�</p>
       
       <p>����̬��</p>
       
       <p>�������</p>
       </div>
       
       <div class="seller_score">
       
           <div class="seller_score_works_peed" title="<?php if ($user['speed']){ ?><?php echo $user['speed']; ?><?php }else{ ?>0.0<?php } ?>��"><ul style="width:<?php echo ($user['speed']*16); ?>px;"></ul></div>
           
           <div class="seller_score_works_attitude" title="<?php if ($user['attitude']){ ?><?php echo $user['attitude']; ?><?php }else{ ?>0.0<?php } ?>��"><ul style="width:<?php echo ($user['attitude']*16); ?>px;"></ul></div>
       
           <div class="seller_score_works_quality" title="<?php if ($user['quality']){ ?><?php echo $user['quality']; ?><?php }else{ ?>0.0<?php } ?>��"><ul style="width:<?php echo ($user['quality']*16); ?>px;"></ul></div>
       </div>
       </div>
    
      </div>

</div>


<div class="space_box">

    <?php    
        $apps=$this->GetMysqlArray('*'," ".$this->GetTable('apps')." WHERE id_phpapp IN(8,49,82) AND status_phpapp=0 ORDER BY displayorder_phpapp ASC");
     ?> 
    <div class="space_navigation">
    
        <ul>
        
                <?php foreach ($apps as $value){ ?>
     
        <li<?php if ($this->app==$value['id_phpapp']){ ?> class="tab"<?php }else{ ?><?php if ($value['menu_phpapp']==1){ ?> style="display:none"<?php } ?><?php } ?>><a href='<?php echo SURL; ?>/space.php?app=<?php echo $value['id_phpapp']; ?>&uid=<?php echo $this->spaceuid; ?>'><?php echo $value['name_phpapp']; ?></a></li>
                     

                 <?php } ?>
        
        </ul>
    
    </div>
    
</div>   

</div>   

     
     <div class="space_main_right space_main_right_width">

      <div class="space_box space_list">
      
     <?php    
     $appaction=$this->GetMysqlArray('*'," ".$this->GetTable('apps_action')." WHERE apps_phpapp=".$this->GET['app']." AND type_phpapp=3  ORDER BY displayorder_phpapp ASC");
      ?> 
      
      <?php if ($appaction){ ?>
      <div class="manage_menu" id="ManageMenu">
      <ul>
          <?php foreach ($appaction as $key=>$value){ ?>
               <?php if ($this->ac==0){ ?>
                    <?php if ($key==0){ ?> 
                         <li class="now_meun_tab"><a href='<?php echo SURL; ?>/space.php?app=<?php echo $this->GET['app']; ?>&uid=<?php echo $this->spaceuid; ?>'><?php echo $value['name_phpapp']; ?></a></li>
                    <?php }else{ ?>    
                    <li<?php if ($this->ac==$value['aid_phpapp']){ ?> class="now_meun_tab"<?php }else{ ?><?php if ($value['menu_phpapp']==1){ ?> style="display:none"<?php } ?><?php } ?>><a href='<?php echo SURL; ?>/space.php?app=<?php echo $this->GET['app']; ?>&action=<?php echo $value['aid_phpapp']; ?>&uid=<?php echo $this->spaceuid; ?>'><?php echo $value['name_phpapp']; ?></a></li>
                    
                    <?php } ?>
               <?php }else{ ?>
       <li<?php if ($this->ac==$value['aid_phpapp']){ ?> class="now_meun_tab"<?php }else{ ?><?php if ($value['menu_phpapp']==1){ ?> style="display:none"<?php } ?><?php } ?>><a href='<?php echo SURL; ?>/space.php?app=<?php echo $this->GET['app']; ?>&action=<?php echo $value['aid_phpapp']; ?>&uid=<?php echo $this->spaceuid; ?>'><?php echo $value['name_phpapp']; ?></a></li>
               <?php } ?>
          <?php } ?>
      </ul>
      </div>
      <?php } ?>

            
            
   <?php if ($this->GET['app']==8){ ?>
   </div>
   </div>
   <?php } ?>

   <div class="space_main_right space_main_right_width">
   
             <div class="space_main_right_content">
                   
   
                     <div class="space_box">
                        <h2>�ҵļ��</h2>
                        
                        <div class="about">
                        
                            <?php if ($memberinfo['about']){ ?>
                            
                                 <?php echo $this->str($memberinfo['about'],9999,0,1,0,0,1); ?>
                                 
                            <?php }else{ ?>
                                 ��ʱûд!
                            <?php } ?>
                        
                        </div>
                        
                        
                     </div>   
                     
                        
                     </div>   
                     
                     
                     <div class="space_box">
                        <h2>�ҵļ���</h2>
                        <div class="myskill">
                            <ul>
                                <?php if ($skillsarr){ ?>
                                    <?php foreach ($skillsarr as $key=>$skill){ ?>
                                          <a href="<?php echo $skill['url']; ?>"><?php echo $skill['name']; ?></a> 
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                     </div>   
                     
            		<div class="space_box">
                        <h2>�ҵĶ�̬</h2>
                        
                        <div class="feed">
                        
                          <ul id="ScrollSpaceFeed">


                              <?php if ($spacefeed){ ?>
                                   <?php foreach ($spacefeed as $value){ ?>
                                  <li>
                                    <em><?php echo $this->Date('m-d H:i',$value['dateline'],1); ?></em>
                                    <p><a href="<?php echo SURL; ?>/space.php?app=8&uid=<?php echo $value['uid']; ?>" target="_blank" title="<?php echo $value['username']; ?>"><?php echo $value['username']; ?></a> <span style="color:#999"><?php echo $this->FeedReplace($value['title_data'],$value['title_template']); ?></span></p>
                                    </li>
                                   <?php } ?>
                                   
                                   
                                   <script type="text/javascript">
									   SetScroll('#ScrollSpaceFeed',3000);
								   </script>
                              <?php }else{ ?>
                              
                              <li>û�ж�̬</li>
                              <?php } ?>
                              
                              </ul>
                        
                        </div>
                        
                        
                    
                    </div>
            
                   <div class="space_box">
                        <h2>�ҳ��۵����·���</h2>
                
                        <div class="photo_list">
                        <?php if ($sellerservicearr){ ?>
                        
                        <ul>
                        <?php foreach ($sellerservicearr as $value){ ?>
                        
                        <li>
                                <div class="photo">
                                                               
                                                 <?php if (!empty($value['logo'])){ ?>
                                                            
                                                            <?php if ($value['thumb']){ ?>  
                                                                 <a href="<?php echo SURL; ?><?php echo $value['url']; ?>" title="<?php echo $value['subject']; ?>"><img src="<?php echo SURL; ?>/<?php echo $value['thumb']; ?>"/></a>
                                                            <?php }else{ ?>
                                                                  <img src="<?php echo SURL; ?>/images/seller/nopic.gif"/>
                                                            <?php } ?>
                                                 <?php }else{ ?>
                                                     
                                                     
                                                     <img src="<?php echo SURL; ?>/images/seller/nopic.gif"/>
                                                    
                                                                    
                                                 <?php } ?>
                                 </div>
                                                                
                                                                
                                
                                <h5><a href="<?php echo SURL; ?><?php echo $value['url']; ?>" title="<?php echo $value['subject']; ?>"><?php echo $value['subject']; ?></a></h5>
                        
                                <p>���� <span class="color_f60"><?php echo $value['price']; ?></span> Ԫ/<?php echo $value['unit']; ?></p>
                                
                        </li>
                              
                        
                        <?php } ?>
                        
                        </ul>
     
                        <?php }else{ ?>
                        
                        <p>���޷������</p>
                        
                        <?php } ?>
                        </div>

				 </div>
                 
                <div class="space_box">
                        <h2>�����������</h2>
            
            
           				<?php if ($sellercreditarr){ ?>
                            <div class="seller_credit">
                            <ul>
                            <?php foreach ($sellercreditarr as $key=>$value){ ?>
                                 <li>
                                   <h3><?php if ($value['appid']!=82){ ?><span class="color_f60">��<?php if ($value['price1']>0){ ?><?php echo $value['price1']; ?>-<?php echo $value['price2']; ?><?php }else{ ?><?php echo $value['money']; ?><?php } ?></span>  <a href="<?php echo SURL; ?>/index.php?app=<?php echo $value['appid']; ?>&action=5&tid=<?php echo $value['tid']; ?>" target="_blank"><?php echo $value['tsubject']; ?></a><?php }else{ ?><span style="color:#09C"><?php echo $value['tsubject']; ?>[����˽��]</span><?php } ?></h3>
                                    
                                    
                                    <?php echo $this->GetUserAvatar($value['uid']); ?>
                                     <p class="seller_credit_username"><dfn><?php if ($value['level']==2){ ?><span class="color_f60">����</span><?php }elseif($value['level']==1){ ?>����<?php }else{ ?><span class="seller_credit_hao">����</span><?php } ?></dfn><a href="<?php echo SURL; ?>/space.php?app=8&uid=<?php echo $value['uid']; ?>" target="_blank" title="<?php echo $value['username']; ?>"><?php echo $value['username']; ?></a>  &nbsp;&nbsp; <?php echo $this->Date('Y-m-d',$value['dateline'],1); ?>
                                   </p>
                                    
                                    <p style="padding:10px;white-space:normal;width:760px;word-break:break-all;color:#999;">
                                         <?php if ($value['auto']){ ?>
                                               ϵͳ�Զ�����
                                         <?php }else{ ?>
                                         	   <?php if ($value['content']){ ?><?php echo $value['content']; ?><?php }else{ ?>������<?php } ?>
                                         <?php } ?>
                                    </p>
                             
                                    </li>
                                
                            <?php } ?>
                            </ul>
                            </div>
                        <?php }else{ ?>
                           <p>
                                 ��ʱû������!
                           </p>
					    <?php } ?>


                </div>
          
             
           </div>
   </div>


</div>





				 

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
                                             <h3>��ѡ����ҵ�������</h3>  
                                                <ul>
                                                <?php foreach ($systemlanguage as $value){ ?>
                                                         <li><a href="http://<?php echo $value['domain_phpapp']; ?>" class="<?php echo $value['style_phpapp']; ?>" title="<?php echo $value['name_phpapp']; ?>"><?php echo $value['name_phpapp']; ?></a></li>
                                                <?php } ?>
                                                </ul>
                                            </div>
                                            
                                        <h3><em>LANGUAGE</em><span><a href="javascript:void(0);" title="��ǰ����<?php echo $systemlanguage[$language]['name_phpapp']; ?>" id="ShowSystemLanguage"><?php echo $systemlanguage[$language]['name_phpapp']; ?></a></span></h3>
            
                                        </div>
                                   <?php } ?>
                           <?php } ?>
                       </div>
                       
                       <div class="footercopyright">
                            <div class="copyright">
                                <p>
                                &copy; 2006-<?php echo $this->Date("Y",$this->NowTime()); ?> <?php if (!intval(PHPAPP::$config['phpappauth'])){ ?>������ ��Ȩ����  <?php }else{ ?> <a href="<?php echo SURL; ?>"><?php echo PHPAPP::$config['sitename']; ?></a> <?php } ?> <?php echo $this->SystemRunTime(); ?>
                                </p>
                                
                                <p>
                                �������ߣ�400-000-00000 ������ѯQQ�� 956560090
                                </p>
                                
                                <p>
                                <?php if (PHPAPP::$config['siteicp']){ ?><a href="http://www.miitbeian.gov.cn" target="_blank"><?php echo PHPAPP::$config['siteicp']; ?></a><?php } ?> 
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
     
     
     
     
     <!--[if lte IE 6]> 
    	<link href="<?php echo TURL; ?>form_ie6.css" rel="stylesheet" type="text/css" />
     <![endif]-->

  </body>
</html>
