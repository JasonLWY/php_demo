$(function(){	

	  $("#SetAppsPhpappID").change( function() {
			var appid=$(this).val();							  

			$.ajax({
				  type: "GET",
				  url: '?',
				  data: "menu=12&action=23&op=3&appid="+appid,
				  success: function(data){
					   $("#ShowActionPhpappID").html(data);
				  }
		   });
	  });
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


var AutoCategoryID=0;

function AddSubclass(id,numpx,type){
	 
	 AutoCategoryID++; 
	 
	 var subclasshtml ='<li><span class="checkbox_category"><input type="checkbox" disabled="disabled"/></span><span class="subclass_icon" style="padding-left:'+numpx+'px"></span> <input name="addcategory['+id+']['+AutoCategoryID+'][displayorder]" type="text" class="form_input_text form_input_width_50 add_subclass" value="0"/> <input name="addcategory['+id+']['+AutoCategoryID+'][name]" type="text" class="form_input_text form_input_width_200" value=""/><input name="addcategory['+id+']['+AutoCategoryID+'][type]" type="hidden" value="'+type+'" /></li>';
	 
	 $('#CatidID'+id).after(subclasshtml);
	 
}



$(function(){	
	 
	 $('.help_small').poshytip({
			 className: 'tip-green',
			 offsetX: -7,
			 offsetY: 16,
			 allowTipHover: false
	 });	
	 
});



