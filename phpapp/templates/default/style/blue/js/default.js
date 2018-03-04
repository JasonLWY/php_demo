function SetSlide(ID,Slide,SlideTitle,time){
	
	  var Interval;
	  
	  var Total=parseInt($("#SlideTitle li").length);
      
	  $(ID).hover(function(){
			clearInterval(Interval);
	  },function(){
			  Interval=setInterval(function(){
				  
				  var NowTitle=$("#SlideTitle li[class='focus']").attr('ID');
					
			      var sid=parseInt(NowTitle.substr(16))+1;
                
				 
				  if(sid>Total){
					   sid=1;
				  }
						
				  //$(Slide+' li').fadeOut("slow");		
				  $(Slide+' li').hide();	
											
				  var first=$(Slide+' li:nth-child('+sid+')');	
				  
				  //first.fadeIn(100);
				  first.show(300);
				  
			      $(SlideTitle+' li').removeClass('focus'); 
				  
				  $('#Title_'+$(Slide+' li:nth-child('+sid+')').attr('ID')).addClass('focus');

				 
			  },time);
	  }).trigger('mouseleave');

}

	  
	  
	  
function SetFreeSlide(ID,time){
	
	  var Interval;
     
	  var NowSlideID=0;
	  
	  var Total=parseInt($(ID+" img").length);
	  
	  $(ID).hover(function(){
			clearInterval(Interval);
	  },function(){
		     
			if(!NowSlideID){
				   
				   var NowImgSrc=$("#FreeSlide_1").attr('src');
						
				   $("#FreeSlide").css('background-image','url('+NowImgSrc+')');
				   
				   NowSlideID=2;

			}
			 
		    Interval=setInterval(function(){

				  var NowImgSrc=$("#FreeSlide_"+NowSlideID).attr('src');
					
				  $("#FreeSlide").css('background-image','url('+NowImgSrc+')');

				  NowSlideID++;
				  
				  if(NowSlideID>Total){
					   NowSlideID=1;
				  }
				 
		    },time);
			  
			
	  }).trigger('mouseleave');
 
}


function SetWeightTask(ID,Slide,time){
	
	  var Interval;
	  
	  $(ID).hover(function(){
			clearInterval(Interval);
	  },function(){
			  Interval=setInterval(function(){
				  var first=$(Slide).find('li:first');	
				  var width=first.width();
				  first.animate({marginLeft:-width+'px'},800,function(){
					   first.css('marginLeft',0).appendTo($(Slide));
				  });
				  
				 
			  },time);
	  }).trigger('mouseleave');
	  
	  
}

function SetWeightTaskArrow(Slide,Arrow){
		  var first=$(Slide).find('li:first');	
		  var width=first.width();
		  if(Arrow==0){
			  var alidearrow='-';
		  }else{
			  var alidearrow='+';
		  }
		  
		  first.animate({marginLeft:alidearrow+width+'px'},800,function(){
			   first.css('marginLeft',0).appendTo($(Slide));
		  });
	  
}

$(function(){	
		   
	 $("#SlideTitle li").mouseover(function(){ 
											
			var id=$(this).attr("id");
				  
		    $("#SlideTitle li").removeClass('focus'); 
			$(this).addClass('focus');
			
			var sid=id.substr(16);
			
			$('#Slide li').hide();	
			
            $('#Slide li:nth-child('+sid+')').show(300);
			
	 });  

    $("#NoticeTab,#TaskOne,#TaskCount,#TaskGrab,#TaskOneRight,#TaskCountRight,#TaskGrabRight").tabs();	


})