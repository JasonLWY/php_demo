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

function NowLogin(isopen){
	
	  //if login
		   var loginuid=document.getElementById("loginuseruid").innerHTML;
		   if(!isopen){
			   if(loginuid<1){
					  $("#UserLogin").click();
					  $("#LoginUserName").focus();
					  $("#LoginUserName").val('');
			   }
		   }
		   
		   return loginuid;
}

function CheckboxAll(id){
        
		var checkboxall=$("#"+id+" [name='checkboxall']");

        var allcheckbox=checkboxall.val();
		if(allcheckbox>0){
			$("#"+id+" :checkbox[disabled!='true']").attr({checked:true});
			checkboxall.val("");
			
		}else{
			$("#"+id+" :checkbox[disabled!='true']").attr({checked:false});
			checkboxall.val("1");
		}

   
}

function GetSelect(table,id,show,app,myfunction){

		var value=$("#"+show+id).val();
		$("#"+show).html('<div class="loading"></div>');
	    $.ajax({
			  type: "POST",
			  url: CategoryURL,
			  data: "&appid="+app+"&table="+table+"&show="+show+"&id="+value+"&myfunction="+myfunction,
			  success: function(data){
				   $("#"+show).html(data);
			  }
	   });

	   if(myfunction==1){

			  $.get(SURL+"/member.php",{app:'10',action:'2',catid:value},
					  
						function (skills){
							  //alert(skills);
							  $('#SelectSkills').html('');
							  $('#SkillsSelected').val('');
							  $.PHPAPPGetAllSkills(value,skills);
			  });   
			
	   }
}

function SetScroll(table,time){
	
		var Interval;
		$(table).hover(function(){
			clearInterval(Interval);
		},function(){
			  Interval=setInterval(function(){
				  var first=$(table).find('li:first');
				  first.appendTo($(table));
				  
				  var first=$(table).find('li:first');
				  first.hide(300);
				  
				  var last=$(table).find('li:last');
				  
				  last.show();
				  
				  
			  },time)
		}).trigger('mouseleave');
}


function SetScrollBox(table,type){
	    
		var scrollnum=$(table+' li a').length;	 

		if(scrollnum){

				if(type==1){
						  var last=$(table).find('li:last');
						  last.show();
						  var first=$(table).find('li:first');
						  first.appendTo($(table));
						  first=$(table).find('li:first');
						  first.hide(300);  
						  
						  if(!first.html()){
							   SetScrollBox(table,type);
						  }
				}else{
						  var first=$(table).find('li:first');
		
						  first.show(300);
						  var last=$(table).find('li:last');
						  last.prependTo($(table));
						  last=$(table).find('li:last');
						  last.hide();  
						  
						  if(!first.html()){
							   SetScrollBox(table,type);
						  }
		
				}

		}else{
			
			  alert('对不起！没有数据操作！');
			
		}		  
		
}


function GetServiceList(id,type){
	 
	 var BuyProps=$('#BuyPropsID').val();
	 $.ajax({
			type: "GET",
			url: SURL+'/index.php?app=11&props='+BuyProps+'&type='+type,
			success: function(data){
				 if(id){
					  $(id).html(data);
				 }else{
				 	  $("#ServiceList").html(data);
				 }
			}
	 });
	
}

$(function(){	
	 
	 $('.help_small').poshytip({
			 className: 'tip-green',
			 offsetX: -7,
			 offsetY: 16,
			 allowTipHover: false
	 });	
	 
	 
	 $('.UserPhotoFilter').poshytip({
				className: 'tip-darkgray',
				bgImageFrameSize: 11,
				alignY: 'bottom'
	 });  
	 
});

function OpenWebsiteGuide(){

	  $("#WebsiteGuide").dialog({
				title:"用户引导",	
				width: 800,
				modal: true,
				height:510
	  });
	  $.PHPAPPOPENLOADING();
	  $("#WebsiteGuide").html('');
	  $.ajax({
			type: "GET",
			url: SURL+'/index.php?app=158&appid='+APPID,
			success: function(data){
				 $.PHPAPPCLOSELOADING();
				 $("#WebsiteGuide").html(data);
				
			}
	 });
}
	  
function js_strto_time(str_time){
    var new_str = str_time.replace(/:/g,'-');
    new_str = new_str.replace(/ /g,'-');
    var arr = new_str.split("-");
    var datum = new Date(Date.UTC(arr[0],arr[1]-1,arr[2],arr[3]-8,arr[4],arr[5]));
    return strtotime = datum.getTime()/1000;
}

function js_date_time(unixtime) {
    var timestr = new Date(parseInt(unixtime) * 1000);
    var datetime = timestr.toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
    return datetime;
}
