<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class TemplateBlockManageControls extends PHPAPP{
	
    private $actionmenu,$POST,$GET;
	
	function __construct($actionmenu=''){	
           
		   parent::__construct();
		   
	       $this->actionmenu=$actionmenu;
		   
		   $postkey=array('Submit'=>'','checkbox'=>'');
		   
		   $this->POST=$this->POSTArray();
		   
		   foreach($postkey as $key=>$vaule){
			   if(empty($this->POST[$key])){
				   $this->POST[$key]='';
			   }
		   }
		   
		   $this->GET=$this->GetArray(array('sqlorder','iforder','action','page','id','op','action'));
		         
	}
	
	function DefaultAction(){
		
		  return $this->ListAction();
	}
	
	
	function ListAction(){
		  
		  if(!empty($this->POST['Submit'])){

               $ids=$this->GetCheckBox($this->POST['checkbox']);
  
			   if($this->Delete('templateblock'," WHERE id_phpapp IN($ids)")){
			  
			        $refresh=  $this->LanguageArray('phpapp','Delete_successfully');

			   
			   }else{
				   
				    $refresh=  $this->LanguageArray('phpapp','Delete_failed');
							 
			   }
			   
			   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
		  
		  }else{
			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		  
		         $orderarr=array(
						  array('order'=>'a.id_phpapp','name'=>'ID'),
						  array('order'=>'a.label_phpapp','name'=>'标签名'),
						  array('order'=>'a.quote_phpapp','name'=>'模板调用名'),
						  array('order'=>'a.quote_phpapp','name'=>'模板文件'),
						  array('order'=>'a.apps_phpapp','name'=>'所属应用'),
						  array('order'=>'a.status_phpapp','name'=>'状态')
						  );
          
		         $order='ORDER BY a.id_phpapp DESC';
		  
		         $this->GET['iforder']=empty($this->GET['iforder']) ? 2 : $this->GET['iforder'];

		         if($this->GET['iforder']==1){
			          $sqlorder=' ASC';
                      $iforder=2;
		         }else{
			          $sqlorder=' DESC';
					  $iforder=1;
		         }
		  
		         foreach($orderarr as $key=>$value){
			           if($this->GET['sqlorder']==$key){
					         $order='ORDER BY '.$value['order'].$sqlorder;
				       }
		         }
		 
	
		         $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.name_phpapp AS appname FROM  ".$this->GetTable('templateblock')." AS a JOIN ".$this->GetTable('apps')." AS b ON a.apps_phpapp=b.id_phpapp $order");

                 $list=$ajaxpage->ShowResult();
   
		  
		         include $this->Template('list_manage');
		  }
	}
	
	
	function AddAction(){
		

		 if(!empty($this->POST['Submit'])) {
	                  
               if($this->POST['quote_phpapp']){
				   
					  $newid=$this->Insert('templateblock',$this->POST,array());
					  
					  if($newid>0){
						  
						  	$this->MaketTemplateBlockFile($this->POST['quote_phpapp']);
					  
						    $refresh= $this->LanguageArray('phpapp','Add_success');
						   
					  }else{
						    $refresh= $this->LanguageArray('phpapp','Add_failed');
					  }
	                 
			   }else{
				   
				    $refresh= '<p>调用名不能为空！</p>';
				   
			   }
			   
			   
			    echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			
		 }else{
			   
				$appsarr=$this->GetMysqlArray('*',$this->GetTable('apps'));

		        include $this->Template('add_manage');
		 }
		 
		 
		
	}
	
	
	function EditAction(){
		
		 if(!empty($this->POST['Submit'])) {
			     
				 if($this->POST['quote_phpapp']){
					   $id=$this->GET['id'];
				   
					   $yes=$this->Update('templateblock',$this->POST,array(),"WHERE id_phpapp='$id'");
				 
					   if($yes){
						   
							  $this->MaketTemplateBlockFile($this->POST['quote_phpapp']);
											   
							  $refresh= $this->LanguageArray('phpapp','Edited_successfully');
	  
					   }else{
							  $refresh= $this->LanguageArray('phpapp','Edit_failure');
							  
					   }
				 
				 }else{
					 
					   $refresh= '<p>调用名不能为空！</p>';
				 }
				 
				 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
		
			
		 }else{
		 
		 	     $id=$this->GET['id'];
		         
				 $appsarr=$this->GetMysqlArray('*',$this->GetTable('apps'));
				 
				 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('templateblock')." WHERE id_phpapp='$id'");

			     include $this->Template('add_manage');
		 }
	}
	
	
	function BlockAction(){
		
		     include_once(Core.'/class/edit_template_phpapp.php');
		
		     $id=$this->GET['id'];
			 
			 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('templateblock')." WHERE id_phpapp='$id'");
			 
			 $tpl=new EditTemplate('templateblock');
			 
			 $dir=$tpl->TemplateDIR(); 
			 
			 if(!empty($this->POST['Submit'])) {
				 
				    $tpl->SaveTemplate($this->POST);
					  
					echo $this->Refresh('<p>保存成功！</p>',$this->MakeGetParameterURL());

			 }else{
				 
				   if($manage['quote_phpapp']){
						 
	  
						 $template=$tpl->GetTemplate($manage['quote_phpapp'].'.htm');
	  
				   }else{
				   
						 $template='';
				   
				   }
				   
				   
				   include $this->Template('block_manage');
			 
			 }
		
	}
	
	
	function MaketTemplateBlockFile($blockname=''){
		
		    global $language;
			
		    if($blockname){
				    
					$blockdir=SYS.'/templates/'.S_TEMPLATE.'/'.$language.'/templateblock';
					
					if(!file_exists($blockdir.'/'.$blockname.'.htm')){
					
					       $this->WriteFile($blockdir.'/'.$blockname.'.htm','');
					
					}
				
			}
		
	}
	
	
}


?>