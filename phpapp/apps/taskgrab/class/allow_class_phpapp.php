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
			   
			    $this->errors[]='�Բ��������ڵ��û��鲻����������!';
		   }
		   

	}
	
	
	public function realnametaskAllow($value=''){
		
		   if(!$this->usergroup['realnametask']){

			    return $this->pass+=1;
				
		   }else{
			   
			     if($this->IsSQL('member_info'," WHERE realname=1 AND uid='$this->uid'")){
					      
						  echo '<p>�Բ���,����Ҫ��ʵ����֤!</p><p>�����Ƚ���ʵ����֤.</p>';
						  
					      echo $this->AjaxRefresh(SURL.'/member.php?app=12',1);
					  
				  }else{
					    
						  return $this->pass+=1;
					  
				  }
		   }

	}
	
	
	public function realnameaddtaskAllow($value=''){

		   if(!$this->usergroup['realnameaddtask']){

			    return $this->pass+=1;
				
		   }else{
			   
			     if($this->IsSQL('member_info'," WHERE realname=1 AND uid='$this->uid'")){
					      
						  echo '<p>�Բ���,��������Ҫ��ʵ����֤!</p><p>�����Ƚ���ʵ����֤.</p>';
						  
					      echo $this->AjaxRefresh(SURL.'/member.php?app=12',1);
					  
				  }else{
					    
						  return $this->pass+=1;
					  
				  }
		   }

	}



	public function addnumbertaskAllow($value=''){
	
	       if(!$this->usergroup['addnumbertask']){
			   
			     return $this->pass+=1;
			   
		   }else{
			   
				 $countarr=$this->MysqlFetchArray("SELECT COUNT(*) AS count,FROM_UNIXTIME(dateline,'%e') AS date FROM ".$this->GetTable('task')." WHERE uid='$this->uid' AND FROM_UNIXTIME(dateline,'%Y-%m-%d')=curdate() GROUP BY curdate()");		
				  
				 $count=empty($countarr[0]['count']) ? 0 : intval($countarr[0]['count']);
				  
				 if($count <= $this->usergroup['addnumbertask']){
	  
	   
					  return $this->pass+=1;
					  
				 }else{
					 
					  $this->errors[]='�Բ�����ÿ�췢����������ܳ���'.$this->usergroup['addnumbertask'].'��!';
				 }
		   }

	}
	
	
	public function maxmoneytaskAllow($value=''){

		   if($value > $this->usergroup['maxmoneytask']){

				  $this->errors[]='�Բ��������ͽ��ܴ���'.$this->usergroup['maxmoneytask'].'Ԫ!';
			   
				
		   }else{
			   
	             return $this->pass+=1;		    
		   }

	}
	
	
	public function smallmoneytaskAllow($value=''){
		
		
		   if($this->usergroup['smallmoneytask'] <= $value){

			    return $this->pass+=1;
				
		   }else{
			   
			    $this->errors[]='�Բ��������ͽ���С��'.$this->usergroup['smallmoneytask'].'Ԫ!';
		   }

	}
	
	
	public function increasetaskAllow(){
		
		   if(!$this->usergroup['increasetask']){

			    return $this->pass+=1;
				
		   }else{
			   
			    $this->errors[]='�Բ��������ڵ��û���û��Ȩ�޼Ӽ�!';
		   }
	}
	
	public function addmoneytaskAllow($money=0){
	       if($money < $this->usergroup['addmoneytask']){

			     $this->errors[]='�Բ��𣬼Ӽ���С���'.$this->usergroup['addmoneytask'].'Ԫ!';
				
		   }else{
			   
			     return $this->pass+=1;
			   
		   }
	}
	
	
	public function adddraftAllow(){
		
		   if(!$this->usergroup['adddraft']){

			    return $this->pass+=1;
				
		   }else{
			   
			    $this->errors[]='�Բ��������ڵ��û���û��Ȩ�޷�����';
		   }
	}
	
	
	public function joinmoneydraftAllow($value=0){
		
		  if($value <= $this->usergroup['joinmoneydraft'] ){

			    return $this->pass+=1;
				
		   }else{
			   
			    $this->errors[]='�Բ��������ڵ��û���Ͷ���ͽ�Χ���ܳ���'.$this->usergroup['joinmoneydraft'].'Ԫ!';
		   }

	}
	
	public function uploadfilesdraftAllow(){
		
		   if(!$this->usergroup['uploadfilesdraft']){

			    return $this->pass+=1;
				
		   }else{
			   
			    $this->errors[]='�Բ��������ڵ��û���Ͷ�岻���ϴ��ļ�';
		   }

	}
	
	public function uploadfilestaskAllow(){
		
		   if(!$this->usergroup['uploadfilestask']){

			    return $this->pass+=1;
				
		   }else{
			   
			    $this->errors[]='�Բ��������ڵ��û��鷢�������ϴ��ļ�';
		   }

	}
	
	public function votedraftAllow(){
		
		   if(!$this->usergroup['votedraft']){

			    return $this->pass+=1;
				
		   }else{
			   
			    $this->errors[]='�Բ��������ڵ��û��鲻��ͶƱ';
		   }

	}
	
	
	public function commentsdraftAllow(){
		
		   if(!$this->usergroup['commentsdraft']){

			    return $this->pass+=1;
				
		   }else{
			   
			    $this->errors[]='�Բ��������ڵ��û��鲻�ܵ���';
		   }

	}
		
	public function messagetaskAllow(){
		
		   if(!$this->usergroup['messagetask']){

			    return $this->pass+=1;
				
		   }else{
			   
			    $this->errors[]='�Բ��������ڵ��û��鲻������';
		   }

	}
	
	
	public function appallowAllow(){
		
		   if(!$this->usergroup['appallow']){

			    return $this->pass+=1;
				
		   }else{
			   
			    $this->errors[]='�Բ��������ڵ��û��鲻��ʹ�ø�Ӧ��!';
		   }

	}	
	
	
	public function deletebidAllow(){
		
		   if($this->usergroup['deletebid']){

			    return $this->pass+=1;
				
		   }else{
			   
			    $this->errors[]='�Բ��������ڵ��û��鲻��ɾ������!';
		   }

	}	


    public function addnumberdraftAllow(){
		
		   if(!$this->usergroup['addnumberdraft']){
			   
			     return $this->pass+=1;
			   
		   }else{
		   
				 $countarr=$this->MysqlFetchArray("SELECT COUNT(*) AS count,FROM_UNIXTIME(dateline,'%e') AS date FROM ".$this->GetTable('task_draft')." WHERE uid='$this->uid' AND FROM_UNIXTIME(dateline,'%Y-%m-%d')=curdate() GROUP BY curdate()");		
				  
				 $count=empty($countarr[0]['count']) ? 0 : intval($countarr[0]['count']);
				  
				 if($count <= $this->usergroup['addnumberdraft']){
	  
	   
					  return $this->pass+=1;
					  
				 }else{
					 
					  $this->errors[]='�Բ�����ÿ��Ͷ��������ܳ���'.$this->usergroup['addnumberdraft'].'��!';
				 }
		   }
		
	}
	
	
}

?>