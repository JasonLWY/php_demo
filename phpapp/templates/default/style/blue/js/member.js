function AddFriend(fuid){
	

	  if(NowLogin()>0){
	   
			$("#loading").dialog({
							  title:"��Ӻ���",	
							  width: 460,
							  modal: true,
							  height:'auto'
			});
					   
			$("#loading").dialog('open');
					   
			$("#loading").html('<div class="loading">��ȡ������...</div>');	
	   
	  
			$.ajax({
							type: "GET",
							url: SURL+'/index.php?app=17&action=4&fuid='+fuid,
							success: function(data){
								 $("#loading").html(data);
							}
			});	
	  }else{
		    return false;
	  }
}


function AddSMS(fuid){
	
	  if(NowLogin()>0){
	
			$("#loading").dialog({
							  title:"������Ϣ",	
							  width: 500,
							  modal: true,
							  height:'auto'
			});
					   
			$("#loading").dialog('open');
					   
			$("#loading").html('<div class="loading">��ȡ������...</div>');	
	   
	  
			$.ajax({
							type: "GET",
							url: SURL+'/index.php?app=7&action=5&fuid='+fuid,
							success: function(data){
								 $("#loading").html(data);
							}
			});	
	  
	  }else{
		    return false;
	  }
}

function ShowMemberMenu(id){
	
	  if($('#MemberMenuID'+id).is(":hidden")){
		    $('#MemberMenuID'+id).show();
			$('#MemberMenuIconID'+id).removeClass('remove');
	  }else{
		    $('#MemberMenuID'+id).hide();
			$('#MemberMenuIconID'+id).addClass('remove');
	  }

}