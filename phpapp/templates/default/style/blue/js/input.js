$(function(){	

	$(".form_input_text").click( function () {$(this).css("border","1px solid #F90");$(this).css("background-color","#FFFDF2");});
	
	$(".form_input_text").focusout( function () {$(this).css("border-top","1px solid #999");$(this).css("border-top","1px solid #999");$(this).css("border-right","1px solid #CCC");$(this).css("border-bottom","1px solid #CCC");$(this).css("border-left","1px solid #999");$(this).css("background-color","#FFFFFF");});     
   
    $(".dateline").datepicker();
	//$(".dateline").datepicker('option',{dateFormat:'yy-mm-dd'});
	//$(".dateline").datepicker('option',$.datepicker.regional['zh-CN']);
   //$("input[type='button']").click( function () { $(this).attr("disabled","disabled"); });

});
