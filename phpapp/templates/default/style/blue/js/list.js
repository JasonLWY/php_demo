/*
	EDOOG.COM (C) 2009-2014 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.15
*/	

function MyFollow(catid,skill){
		
	if(NowLogin()>0){
		 
		 $("#loading").dialog({
			  title:"��ע",	
			  width: 200,
			  modal: true,
			  height:'auto'
		 });
		 
		  $("#loading").dialog('open');

		  $("#loading").html('<div class="loading">�ύ������...</div>');
		  $.ajax({
			  type: "GET",
			  url: SURL+'/index.php?app=49&action=9&catid='+catid+'&skill='+skill,
			  success: function(data){
				  $("#loading").html(data);
			  }
		  });  
	
		  
	}else{
		  return false;
	}
	
}

$(function(){	
	 /*	   
	 $("#NowOpenSelect").click( function () { 
										  
	     if($('#OpenSelect').is(":hidden")){
			  $('#OpenSelect').fadeIn(100);
			  $(this).html('�ر�ɸѡ');
		 }else{
			  $('#OpenSelect').fadeOut(100);
			  $(this).html('��ɸѡ');
		 }													  
										  
	});
	*/
	 
    if(moreselect==1){
	      $('#OpenSelect').fadeIn(100);
	}else{
		  $('#OpenSelect').fadeOut(100);
	}
		   
	$.PHPAPPUserMouseover('.user_box','.user_box_show');
	
	 $("#TaskSelectSort").change( function () {
			var Sort=$("#TaskSelectSort").val();	
			window.location.href=Sort;
	});
});