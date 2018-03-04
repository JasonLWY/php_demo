/*
	EDOOG.COM (C) 2009-2014 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.15
*/	

var loaddataname='加载数据中...';
var taskname='任务';
var draftname='稿件';
var successname='中标';
var servicename='服务';
var addsmsname='发消息';
var creditname='';

var PHPAPPFeedsCache = {};

$(function(){
		$(window).scroll(function(){				  
			if($(this).scrollTop() > ($('#HeaderTop').height()+100)){
					$('#HeaderTop').addClass('header_fixed').fadeIn('fast');
					$('#ScrollUp').addClass('scroll_fixed').fadeIn('fast');
					$('#HeaderTop').removeClass('header_widescreen');
					$('#UserLogin').removeClass('topuserlogin_box');
					$('#Header_Member_Menu').addClass('header_member_widescreen');
					
			} else if($(this).scrollTop() <= ($('#HeaderTop').height()+100) && $('#HeaderTop').hasClass('header_fixed')){
					$('#HeaderTop').removeClass('header_fixed').fadeIn('fast');
					$('#ScrollUp').removeClass('scroll_fixed').fadeOut('fast');
					$('#HeaderTop').addClass('header_widescreen');
					$('#Header_Member_Menu').removeClass('header_member_widescreen');
			}
		});
		
		
		$(".UserPhotoFilter").hover(function(e) {
             $(this).find("div").each(function(){
				   $(this).fadeIn('fast');
			 }); 
			
		}, function(e) {
		    
			 $(this).find(".user_photo_url").each(function(){
					$(this).fadeOut('fast');
			 }); 
		
		});
		
		$(function(){	
		   $(".datalist tr").mouseover(function(){  
				$(this).addClass("over");  
			}).mouseout(function(){  
				$(this).removeClass("over");  
			})
		});
		
		
		$(".navigation_search,.help_input_search").one("click", function () { $(this).val('');$(this).css("color","#333"); });
	

});


$(function(){
         $('#loading').dialog({
			 modal: true,
			 autoOpen: false
         });	
		 
		$('#TipScrollUp,#TopAddTask,#ChangeCityTitle,#UserLogin').poshytip({
			 className: 'tip-green',
			 offsetX: -7,
			 offsetY: 16,
			 allowTipHover: false
		});
		
			
	    $("a").focus(function(){
             this.blur();
        });
		
		
		$('#UserLogin').click(function () {
			  
	          $('.LoginFrame').slideToggle(0,function(){
                    if($(this).css("display")=='none'){
						  $('#UserLogin').removeClass('topuserlogin_focus');
					}else{
						  $('#UserLogin').addClass('topuserlogin_focus');
					}
              });

        });
		
		$('#ShowSystemLanguage').click(function () {
			  
	          $('#SystemLanguageList').slideToggle(0);

        });
		
		
		$("#UserLogin,.LoginFrame,#ShowSystemLanguage,#SystemLanguageList").mouseup(function() {
				return false;
		});
		
		$(document).mouseup(function(e) {
				$('#UserLogin').removeClass('topuserlogin_focus');
				$(".LoginFrame").hide();
				$('#SystemLanguageList').hide();
				//$.PHPAPPCloseNowDiv();
		});		
 
});



(function($,undefined) {
		  

     jQuery.extend({
			options: {
				
			
				  POPUP:null,     
				  
			
				  POPUPID:null,     
				  
			
				  POPUPView:null,   
				  
			
				  POPUPViewID:null,   
				  
			
				  POPUPWidth:'auto',
				  
			
				  POPUPIsTop:0,
			
				  POPUPHeight:'auto',
				  
			
				  POPUPWidthAuto:0,
				  
		
				  POPUPOffsetsX:0,
				  
				  POPUPOffsetsY:0

				  
			},
			
			PHPAPPHeaderItem:function(ID,View,OffsetX,OffsetY,Width,Height,WidthAuto,IsTop){
				
				  this.options.POPUP =$('#'+ID);
				  
				  this.options.POPUPID =ID;
				  
				  this.options.POPUPView =$('#'+View);
				  
				  this.options.POPUPViewID =View;
				  
				  if(Width >0){
				        this.options.POPUPWidth =Width;
				  }
				  
				  if(Height >0){
				        this.options.POPUPHeight =Height;
				  }
				  
				  this.options.POPUPWidthAuto=WidthAuto;
				   
				  this.options.POPUPOffsetsX=OffsetX;
				 
				  this.options.POPUPOffsetsY=OffsetY;
				  
				  this.options.POPUPIsTop =IsTop;
				  
				 
                  this.PHPAPPHeaderInit();

			},
			
			PHPAPPHeaderInit:function(){
				      
					   if(this.options.POPUPIsTop){
						   var PositionTop=this.options.POPUP.offset().top+this.options.POPUPOffsetsY;
					   }else{
				           var PositionTop=this.options.POPUPOffsetsY;
					   }

			
					   this.PHPAPPSETItemPosition(this.options.POPUP.offset().left+ this.options.POPUPOffsetsX,PositionTop);         
					
					   this.PHPAPPCloseAllItem();

			},
		
			PHPAPPSETItemPosition:function(X,Y){
				   if(this.options.POPUPWidthAuto){
					   
					    var nowwidth=this.options.POPUP.css('width');
					    this.options.POPUPWidth=parseInt(nowwidth)+40;
				   }
				   
				   this.options.POPUPView.css({left:X,top:Y,width:this.options.POPUPWidth,height:this.options.POPUPHeight});
			},
			
			PHPAPPCloseNowDiv:function(){
				  if(this.options.POPUPID){
					  if(this.options.POPUPID!='SelectMoreSkills'){
							  this.options.POPUP.removeClass('active');
							  this.options.POPUPView.fadeOut('fast');
					  }
				  }
			},
			PHPAPPCloseAllItem:function(){
                    
				   $("#Header_Member_Menu ul li").find("a").each(function(){
						 $(this).removeClass('active');
				   }); 
				   
				   var AllItem=[
					   'MemberMessageView',
					   'MemberNoticeView',
					   'MemberTaskFeedView',
					   'MemberMoneyView',
					   'MemberMenuView',
					   'MemberSellerView',
					   'MemberBuyerView',
					   'SelectMoreSkillsView'
				  ]
				  
					 
				   for(var i=0;i<8;i++){
			         
					    if(AllItem[i]==this.options.POPUPViewID){
						 
							   if(this.options.POPUPView.css('display')=='none'){
								     
								
									 this.options.POPUP.addClass('active');
								   
									 this.options.POPUPView.fadeIn('fast');
							   }else{
								     
									 this.options.POPUP.removeClass('active');
									 this.options.POPUPView.fadeOut('fast');
							   }
						   
					    }else{

							  $('#'+AllItem[i]).fadeOut('fast');
						}
					    //alert();
				   }
				  
				  
			},
			

			PHPAPPOPENLOADING:function(loading){
				   var loadingtxt='loading';
				   if(loading){
					    loadingtxt=loading;
				   }
				   $('#TopLoading').attr("title",loadingtxt);
				   $('#TopLoading').html(loadingtxt+'...');
				   $('#TopLoading').fadeIn('fast');
				   
			},
			
			PHPAPPCLOSELOADING:function(){
				   $('#TopLoading').fadeOut('fast');
			},
			
			GetUserMoreInfo:function(uid,userpost){
				    
				  if(PHPAPPFeedsCache[uid]){
					    
						 $('.AjaxUserID'+uid).poshytip('update',PHPAPPFeedsCache[uid].container);
						
				  }else{
					  
					      PHPAPPFeedsCache[uid] = { container: null };
							
						  $.getJSON(SURL+'/index.php?app=2&action=7&uid='+uid+'&userpost='+userpost,
								    function(data) {
		
										 PHPAPPFeedsCache[uid].container = '<div class="jsonuser_info"><div class="jsonuser_avatar">'+data.UserAvatar+'</div><p class="jsonuser_username"><dfn><a href="javascript:;" class="small awesome addsms" onclick="AddSMS('+data.Uid+')">'+addsmsname+'</a></dfn><a href="'+data.ULink+'"><span>'+data.UserName+'</span></a></p><p>'+taskname+data.TaskNum+' &nbsp; '+draftname+data.DraftNum+' &nbsp; '+successname+data.SuccessNum+' &nbsp; '+servicename+data.ServiceNum+'</p><p> '+creditname+data.Credit+'</p></div><div class="jsonuser_attest">'+data.UserCertificate+'</div>';                       
										 
									     $('.AjaxUserID'+uid).poshytip('update',PHPAPPFeedsCache[uid].container);
										 
									}
						  );
				  
				  }
				
			},
			PHPAPPMouseover:function(Obj,fun){


			    $(Obj).mouseover(function(){  
					$(this).addClass("over");  
					if(fun){
						$(this).find(fun).each(function(){
							   $(this).show();
					    }); 			 
					}
				}).mouseout(function(){  
					$(this).removeClass("over");  
					if(fun){
						$(this).find(fun).each(function(){
							   $(this).hide();
					    }); 
					}
				})

			},
			PHPAPPTaskFlash:function(classname,time){

                  var glintval;
				  
			      $(classname).hover(function(){
						clearInterval(glintval);
				  },function(){
						  glintval=setInterval(function(){
							  
							  var Rround=Math.round(Math.random()*25)+230;
							  var Ground=Math.round(Math.random()*25)+230;
							  var Bround=Math.round(Math.random()*25)+230;
							  
		                      $(classname).css("background-color","rgb("+Rround+","+Ground+","+Bround+")") 
							
							 
						  },time);
				  }).trigger('mouseleave');

			},
			PHPAPPUserMouseover:function(Obj,classname){

			    $(Obj).mouseover(function(){  
					$(this).addClass("over");  
					$(this).find(classname).each(function(){
							$(this).addClass("over");  
					}); 	
					 
				}).mouseout(function(){  
                    $(this).removeClass("over");  
					$(this).find(classname).each(function(){
						  $(this).removeClass("over");  
					});
					 
				})

			}
	 
     });


}(jQuery));
