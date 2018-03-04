/*
	EDOOG.COM (C) 2009-2014 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V3.0  2013.3.15
*/	

function TaskAdd(tid){
	
	if(NowLogin()>0){
		   $.PHPAPPOPENLOADING();
		   $("#loading").dialog({
				title:"任务补充",	
				width: 580,
				position: ['center',160],
				modal: true,
				height: 260
		   });

		   $("#loading").dialog('open');
		 
		   $("#loading").html('<div class="loading">读取数据中...</div>');
		   
		   $.ajax({
				type: "GET",
				url: SURL+'/index.php?app=49&action=10&tid='+tid,
				success: function(data){
					$.PHPAPPCLOSELOADING();
					$("#loading").html(data);
				}
		   }); 
		   
		 
	}else{
		  return false;
	}
	 
}


function TaskFavorites(tid){
	
	if(NowLogin()>0){
		   $.PHPAPPOPENLOADING();
		   $("#loading").dialog({
				title:"收藏任务",	
				width: 260,
				modal: true,
				height:160
		   });

		   $("#loading").dialog('open');
		 
		   $("#loading").html('<div class="loading">读取数据中...</div>');
		   
		   $.ajax({
				type: "GET",
				url: SURL+'/index.php?app=49&action=11&tid='+tid,
				success: function(data){
					$.PHPAPPCLOSELOADING();
					$("#loading").html(data);
				}
		   }); 
		   
		 
	}else{
		  return false;
	}
	 
}

function TaskReport(tid,did){
	
	if(NowLogin()>0){
		   $.PHPAPPOPENLOADING();
		   $("#loading").dialog({
				title:"举报信息",	
				width: 600,
				position: ['center',160],
				modal: true,
				height:'auto'
		   });

		   $("#loading").dialog('open');
		 
		   $("#loading").html('<div class="loading">读取数据中...</div>');
		   
		   $.ajax({
				type: "GET",
				url: SURL+'/index.php?app=49&action=12&tid='+tid+'&did='+did,
				success: function(data){
					$.PHPAPPCLOSELOADING();
					$("#loading").html(data);
				}
		   }); 
		   
		 
	}else{
		  return false;
	}
	 
}


function OpenSiteService(tid){
	
	if(NowLogin()>0){
		   $.PHPAPPOPENLOADING();
		   
		   $("#BuyTaskService").dialog({
				title:"购买增值服务",	
				width: 800,
				position: ['center',50],
				modal: true,
				height:'auto'
		   });

		   $("#BuyTaskService").dialog('open');
		   
		   GetServiceList();
		   
		   $.PHPAPPCLOSELOADING();
		 
	}else{
		  return false;
	}
	 
}


function PayTaskMoney(tid){
	
	  if(NowLogin()>0){
		   $.PHPAPPOPENLOADING();
		   
		   $("#loading").dialog({
				title:"任务支付",	
				width: 500,
				position: ['center',150],
				modal: true,
				height:'auto'
		   });

		   $("#loading").dialog('open');
		   
		   $("#loading").html('<div class="loading">读取数据中...</div>');
		   
		   $.ajax({
				type: "GET",
				url: SURL+'/index.php?app=49&action=7&tid='+tid,
				success: function(data){
					$.PHPAPPCLOSELOADING();
					$("#loading").html(data);
				}
		   }); 
		 
	}else{
		  return false;
	}
	
}

function AddTaskMoney(tid,type){
	
	  if(NowLogin()>0){
		   $.PHPAPPOPENLOADING();
		   
		   $("#loading").dialog({
				title:"任务加价加件",	
				width: 500,
				position: ['center',150],
				modal: true,
				height:'auto'
		   });

		   $("#loading").dialog('open');
		   
		   $("#loading").html('<div class="loading">读取数据中...</div>');
		   
		   $.ajax({
				type: "GET",
				url: SURL+'/index.php?app=49&action=8&tid='+tid+'&type='+type,
				success: function(data){
					$.PHPAPPCLOSELOADING();
					$("#loading").html(data);
				}
		   }); 
		 
	}else{
		  return false;
	}
	
}

function BuySiteService(tid){
	if(NowLogin()>0){
		   $.PHPAPPOPENLOADING();
		   var Props=$('#BuyPropsID').val();
		   window.location.href=SURL+"/index.php?app=49&action=5&tid="+tid+"&props="+Props;		
	}else{
		  return false;
	}
}


function SubmitTaskPay(tid){
	
	   if(!VerifyTaskTotal(1)){
			return false;  
	   }
			
	  if(!VerifyTaskMoney(1)){
		   return false;  
	  }
			  
	  var forms=GetFormAll('#TaskPay');
	  
	  $.PHPAPPOPENLOADING();
	  
	  $.ajax({
   			type: "POST",
   			url: SURL+"/index.php?app=49&action=7&tid="+tid,
  		    data: forms,
   			success: function(data){
				  $.PHPAPPCLOSELOADING();
				   if(!isNaN(data)){
				   		window.location.href=SURL+'/index.php?app=80&action=3&tid='+data;
				   }
   			}
	  });
}
