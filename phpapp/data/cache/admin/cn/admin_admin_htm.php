<?php if(!defined('IN_PHPAPP')){exit('Data error');} ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo S_CHARSET; ?>" />
<title>PHPAPP��̨����</title>
<head>
	<link rel="stylesheet" href="<?php echo TURL; ?>dialog.css">
    <link href="<?php echo TURL; ?>header_member.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo TURL; ?>admin_common.css">
    <link rel="stylesheet" href="<?php echo TURL; ?>form.css">
	<script type="text/javascript" src="<?php echo TURL; ?>js/jquery.js?v=<?php echo $this->GetFileVersion(); ?>"></script>
    <script type="text/javascript" src="<?php echo TURL; ?>js/dialog.js?v=<?php echo $this->GetFileVersion(); ?>"></script>
</head>

<body>
<script type="text/javascript">
var SURL ='<?php echo SURL; ?>';
var TURL ='<?php echo TURL; ?>';
var Language='<?php echo $this->lang; ?>';
var CategoryURL ="<?php echo SURL; ?>/member.php?app=10&action=1";
var TaskSkillURL ="<?php echo SURL; ?>/index.php?app=27&action=1";
var USERID='<?php echo $this->uid; ?>';
var USERNAME='<?php echo $this->username; ?>';
</script>
<div id="TopLoading" style="display:none" title="loading..."></div>
<div id="loading" style="display:none" title="��ȡ������..."></div>

<div id="header" class="header">
   <div class="logo" title="PHPAPP">
   </div>
   <div class="tabmenu" id="TabMenu">
       <ul>
         <?php include_once(SYS.'/data/cache/admin/admin_tabmenu_htm.php'); ?>
       </ul>
   </div>
   
   <div class="login">
        <script type="text/javascript">
		    function NowLogin(){
				 return USERID;
			}
			
			$(function(){
                    $("#MemberMessage").click( function () {  $.PHPAPPHeaderItem('MemberMessage','MemberMessageView',-180,40,400); });
                    $("#MemberNotice").click( function () { $.PHPAPPHeaderItem('MemberNotice','MemberNoticeView',-220,40,400); });
                    $("#MemberMenu").click( function () { $.PHPAPPHeaderItem('MemberMenu','MemberMenuView',-2,40,120,0,1); });
            });
			
			//alert();
        </script>

        <div id="Header_Member_Item">
    
            <div id="Header_Member_Menu" class="header_member_menu">
      
                <ul>
                    <li class="member_message"><a href="javascript:void(0)" id="MemberMessage" class="default" title="վ�ڶ���" onclick="GetMemberMessage()"><sub id="NewMemberMessage"></sub></a></li>
                    <li class="member_notice"><a href="javascript:void(0)" id="MemberNotice" class="default" title="��վ֪ͨ" onclick="GetMemberNotice()"><sub id="NewMemberNotice"></sub></a></li>
                    <li><a href="javascript:void(0)" id="MemberMenu" class="default" title="�û�����"><?php echo $this->username; ?>(<?php echo $grouparray['name_phpapp']; ?>)</a></li>
                    
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
            
            
            <div id="MemberMenuView" class="header_member_default member_menu_list">
                <ul>  
                     <li class="login_avatar" title="<?php echo $this->username; ?><?php echo $grouparray['name_phpapp']; ?>"><?php echo $this->GetUserAvatar($this->uid,0,1); ?></li>
                     <li><a href="<?php echo SURL; ?>" target="_blank" title="������վ��ҳ">[��վ��ҳ]</a></li>
                     <li><a href="javascript:;" onclick="$('#ManageAllow').dialog('open');" title="�鿴�ҵĹ���Ȩ��">[����Ȩ��]</a></li>
                     <li><a href="<?php echo SURL; ?>/index.php?app=2&action=10">��ȫ�˳�</a></li>
                </ul>
            </div> 
            
            
       </div>
       
       
       <!--
       <div class="login_avatar" title="<?php echo $this->username; ?><?php echo $grouparray['name_phpapp']; ?>"><?php echo $this->GetUserAvatar($this->uid,0,1); ?></div>
         
       <div class="login_info">
       
       <p>����<?php echo $grouparray['name_phpapp']; ?>, <a href="space.php?app=8&uid=<?php echo $this->uid; ?>" target="_blank" title="<?php echo $this->username; ?><?php echo $grouparray['name_phpapp']; ?>"><span class="manage_user"><?php echo $this->username; ?></span></a> </p>
       <p><a href="javascript:;" onclick="$('#ManageAllow').dialog('open');" title="�鿴�ҵĹ���Ȩ��">[����Ȩ��]</a> <a href="<?php echo SURL; ?>" target="_blank" title="������վ��ҳ">[��վ��ҳ]</a> <a href="index.php?app=2&action=10" title="��ȫ�˳�">[�˳�]</a></p>
       
       </div>
       -->
       <div id="ManageAllow" class="manageallow" style="display:none" title="<?php echo $grouparray['name_phpapp']; ?>����Ȩ���б�">
       
        <ul>
             <?php if ($manageapp){ ?>
             
                <?php 
                
                     $managemenuarray=$this->GetMysqlOne('catid_phpapp,action_phpapp,name_phpapp,apps_phpapp'," ".$this->GetTable('admin_menu')." WHERE apps_phpapp='$manageapp' GROUP BY apps_phpapp ORDER BY displayorder_phpapp ASC");

                
                 ?>
                
                
                <?php if ($managemenuarray){ ?>
                    
                     <?php foreach ($managemenuarray as $value){ ?>
                
                         <li><a href="?menu=<?php echo $value['catid_phpapp']; ?>&action=<?php echo $value['action_phpapp']; ?>" target="main"><?php echo $value['name_phpapp']; ?></li>
                     <?php } ?>
                
                <?php } ?>
             
             <?php }else{ ?>
             
                <li>ȫ������Ȩ��</li>
             
             <?php } ?>
        </ul>

       </div>
   </div>
   
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="sidebar">
      <div id="SideBar" class="sidebar_line">   
          <?php include_once(SYS.'/data/cache/admin/admin_menulist_htm.php'); ?>
      </div>
      <div id="ScrollSideBar" class="scrollsidebar" style="display:none"><a href="javascript:;" onclick="ScrollSet(0);this.blur();"></a> <a href="javascript:;" onclick="ScrollSet(1);this.blur();" style="background-position:left bottom;"></a></div>
      <div class="phpappcopyright">&copy; 2006-<?php echo $this->Date("Y",$this->NowTime()); ?> <a href="http://www.phpapp.cn" target="_blank">phpapp.cn</a></div>
    </td>
    <td valign="top" class="main">
      <div id="main">
      <iframe width="100%" height="100%" scrolling="auto" frameborder="0" name="main"></iframe>
      </div>
    </td>
  </tr>
</table>



<script type="text/javascript">
var NowMenuID=0;
var ScrollHeight=0;
var winH= (window.innerHeight || (window.document.documentElement.clientHeight || window.document.body.clientHeight));
$("#SideBar").css({"height":winH-81});
$("#main").css({"height":winH-63});

	
var href=$("#SideBar ul:nth-child(1) li:nth-child(1) a").attr("href");

if(href=='javascript:;'){
	
	  $("#SideBar ul:nth-child(1) li").removeClass('tab');
	  
	  $("#SideBar ul:nth-child(1) li:nth-child(1) ul li:nth-child(1)").addClass('tab');
	  
	  href=$("#SideBar ul:nth-child(1) li:nth-child(1) ul li:nth-child(1) a").attr("href");
	
}
	
window.parent.frames["main"].window.location.href=href;

function TabMenu(id){
	
	NowMenuID=id;
	
	$("#TabMenu ul li").removeClass('tab');
	
	$("#MainMenu"+id).addClass('tab');

	$("#SideBar>ul").hide();

	$("#MenuList"+id).show();
	
	var listheight=$("#MenuList"+id).css('height');

	if((parseInt(winH)-parseInt(listheight))<160){
			$("#SideBar").css({"height":winH-107});
			$("#ScrollSideBar").show();
	}else{
		    $("#ScrollSideBar").hide();
		    $("#SideBar").css({"height":winH-81});
	}

	
	var menuhref='';
	
	$("#MenuList"+id).find("li[class*='tab']>a").each(function(){
	         menuhref=$(this).attr("href");
    }); 

	if(menuhref=='javascript:;'){
		
		  menuhref=$("#MenuList"+id+" li:nth-child(1) ul li:nth-child(1) a").attr("href");

	}else if(!menuhref){
		  var hrefid=$("#MenuList"+id+" li:first-child ul li a:first-child");
		  menuhref=hrefid.attr("href");
		  $("#MenuList"+id+" li:first-child ul li:first-child").addClass('tab');
		  hrefid.addClass('tab');
	}

	window.parent.frames["main"].window.location.href=menuhref;
	
}

function MenuList(href,menu,id){
	
	$("#MenuList"+menu+" li").removeClass('tab');
	
	$("#MenuID"+id).addClass('tab');

}


function ScrollSet(type){

	  if(type==1){
			ScrollHeight=ScrollHeight-100;
			$("#MenuList"+NowMenuID).css('margin-top',ScrollHeight);

	  }else{
			ScrollHeight=ScrollHeight+100;
		    $("#MenuList"+NowMenuID).css('margin-top',ScrollHeight);
		  
	  }
	  //alert();
}

function MoreTab(menu,listid){
	
	var display=$("#MoreTab"+menu).css('display');
	
	$("#MenuList"+listid+" li").removeClass('tab');
	
	$("#MenuID"+menu+" li:nth-child(1)").addClass('tab');

	if(display=='none'){
		  $("#MenuID"+menu).removeClass('lessset');
		  $("#MenuID"+menu).addClass('moreset');
	      $("#MoreTab"+menu).css('display','block');
	}else{
		  $("#MenuID"+menu).removeClass('moreset');
		  $("#MenuID"+menu).addClass('lessset');
	      $("#MoreTab"+menu).css('display','none');
	}
}


$("#TabMenu a,#SideBar ul li a").focus(function(){
        this.blur();
});


$("#ManageAllow").dialog({
			width: 800,
			position: ['center',120],
			modal: true,
			autoOpen: false,
			minHeight:500,
			height:500
			
});

function GetFormAll(FormId){
	 var formall='';
	 $(FormId).find("input,select,textarea").each(function(){
			  var value=$(this).val();  
			  var name=$(this).attr("name");
			  var type=$(this).attr("type");
	
			  if(!$(this).attr("multiple")){
				 
			      value=value.replace(/\&nbsp;/g,'');
			      //value=value.replace(/\&/g,'');
			  }
			   
			  //if(name.search(/_s/i)>0){
	
			  //}
			  
			 if(type=='radio' || type=='checkbox'){
				    if($(this).attr("checked")){
						
		                  
						  if(name){
							   if(formall){
									formall+="&"+name+"="+encodeURIComponent(value);
							   }else{
									formall=name+"="+encodeURIComponent(value);
							   }
						  }
						  
					}
			  }else{

					if(name){
						 if(formall){
							  formall+="&"+name+"="+encodeURIComponent(value);
						 }else{
							  formall=name+"="+encodeURIComponent(value);
						 }
					}
					
			  }

     }); 	
 
     return formall;
}
	
</script>

<script type="text/javascript" src="<?php echo TURL; ?>js/input.js"></script>
<script type="text/javascript" src="<?php echo TURL; ?>poshytip/jquery.poshytip.js"></script>
<script type="text/javascript" src="<?php echo TURL; ?>js/header.js"></script>
<script type="text/javascript" src="<?php echo TURL; ?>js/ajax_auto.js"></script>
<script type="text/javascript" src="<?php echo TURL; ?>js/member.js"></script>
</body>
</html>

