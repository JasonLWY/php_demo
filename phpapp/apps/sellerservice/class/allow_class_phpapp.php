<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class Allow extends PHPAPP{
	
	public $usergroup,$pass;
	
	function __construct($usergroup=''){	 
	 
		 parent::__construct();
		 
		 $this->usergroup=$usergroup;
		 
		 $this->pass=0;
	
		 if($this->uid<1){
			 $this->Refresh($this->LanguageArray('phpapp','Please_login_actions'),SURL.'/index.php?app=2&action=1');
		 }
		 
	}
	
	
	public function UserAllow($post){

		   foreach($post as $key=>$value){

			     $function=$key.'Allow';
				 
			     $this->$function($value);
		   }
		
          if(count($post)==$this->pass){
			  	  
			   return 'ok';	   
			   
		  }else{
			    
			   return $this->errors;
		  }

		
	}
	
	
	
	
	public function addtaskAllow($value=''){
		
		 
		   if(!$this->usergroup['addtask']){

			    return $this->pass+=1;
				
		   }else{
			   
			    $this->errors[]='对不起，您所在的用户组不允许发布服务!';
		   }
		   

	}
	
	
	public function realnametaskAllow($value=''){
		
		   if($this->usergroup['realnametask']){

			    return $this->pass+=1;
				
		   }else{
			   
			      
				  
				  if(!$this->IsSQL('member_info'," WHERE realname=0 AND uid='$this->uid'")){
					  
					      $this->Refresh('<p>对不起,服务要求实名购买!</p><p>请您先进行实名认证.</p>','member.php?app=12');
					  
				  }else{
					    
						  return $this->pass+=1;
					  
				  }

				
		   }

	}


	public function edittaskAllow($value=''){
		
		   if(!$this->usergroup['edittask']){

			    return $this->pass+=1;
				
		   }else{
			   
			    $this->errors[]='对不起，您所在的用户组不允许修改服务!';
		   }

	}


	public function addnumbertaskAllow($value=''){
	
	       if(!$this->usergroup['addnumbertask']){
			   
			     return $this->pass+=1;
			   
		   }else{
		   
				 $countarr=$this->MysqlFetchArray("SELECT COUNT(*) AS count,FROM_UNIXTIME(dateline,'%e') AS date FROM ".$this->GetTable('task_seller_service')." WHERE uid='$this->uid' AND FROM_UNIXTIME(dateline,'%e')=DAYOFMONTH(NOW()) GROUP BY DAYOFMONTH(NOW())");		
				  
				 $count=empty($countarr[0]['count']) ? 0 : intval($countarr[0]['count']);
				  
				 if($count <= $this->usergroup['addnumbertask']){
	  
	   
					  return $this->pass+=1;
					  
				 }else{
					 
					  $this->errors[]='对不起，您每天发服务次数不能超过'.$this->usergroup['addnumbertask'].'次!';
				 }
		   }

	}
	
	
	public function maxmoneytaskAllow($value=''){

		   if($value > $this->usergroup['maxmoneytask']){

				  $this->errors[]='对不起，服务价格不能大于'.$this->usergroup['maxmoneytask'].'元!';
			   
				
		   }else{
			   
	             return $this->pass+=1;		    
		   }

	}
	
	
	public function smallmoneytaskAllow($value=''){
		
		
		   if($this->usergroup['smallmoneytask'] <= $value){

			    return $this->pass+=1;
				
		   }else{
			   
			    $this->errors[]='对不起，服务价格不能小于'.$this->usergroup['smallmoneytask'].'元!';
		   }

	}
	

    public function appallowAllow(){
		
		   if(!$this->usergroup['appallow']){

			    return $this->pass+=1;
				
		   }else{
			   
			    $this->errors[]='对不起，你所在的用户组不能查看该服务!';
		   }

	}	
	
	public function buyserviceAllow(){
		
		   if(!$this->usergroup['buyservice']){

			    return $this->pass+=1;
				
		   }else{
			   
			    $this->errors[]='对不起，你所在的用户组不能购买该服务!';
		   }

	}	
	
	public function uploadfilestaskAllow(){
		
		   if(!$this->usergroup['uploadfilestask']){

			    return $this->pass+=1;
				
		   }else{
			   
			    $this->errors[]='对不起，你所在的用户组发任务不能上传文件';
		   }

	}
	
}

?>