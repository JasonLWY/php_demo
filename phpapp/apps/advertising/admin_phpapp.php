<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

include_once(Core.'/class/admin_class_phpapp.php');

class AdvertisingManageControls extends PHPAPP{
	
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
		  
		  
		  //select -----------------------------------------------------
			   $wheresql=$selectarray='';
	
			   if(!empty($_GET['SelectData'])){
				   
					 $admin=new AdminClass();
					 
					 $wheresqlarr=$admin->getwheresql($_GET,
													  
													  array(
															
														'name_phpapp'=>array('a.name_phpapp','search'), 
														'id_phpapp'=>array('a.id_phpapp','int'),
														'apps_phpapp'=>array('a.apps_phpapp','int'),
														'type_phpapp'=>array('a.type_phpapp','string')
															  
												      ) 
													  
													  
													  );
					 
					 $wheresql=$wheresqlarr[0];
					 
					 $selectarray=$wheresqlarr[1];
			 
			   }

			  //select end----------------------------------------------------
		  
		  if(!empty($this->POST['Show'])){
			  
			   $ids=$this->GetCheckBox($this->POST['checkbox']);

			   $this->Update('advertising',array('status_phpapp'=>0),array(),"WHERE id_phpapp IN($ids)");
			   
			   echo $this->Refresh($this->LanguageArray('phpapp','Set_to_open_successfully'),$this->MakeGetParameterURL());
		  
		  }elseif(!empty($this->POST['Hide'])){
			  
			   $ids=$this->GetCheckBox($this->POST['checkbox']);

			   $this->Update('advertising',array('status_phpapp'=>1),array(),"WHERE id_phpapp IN($ids)");
			   
			   echo $this->Refresh($this->LanguageArray('phpapp','Set_off_success'),$this->MakeGetParameterURL());
			  
		   
		  }elseif(!empty($this->POST['Submit'])){
			  
			   $ids=$this->GetCheckBox($this->POST['checkbox']);

			   if($this->Delete('advertising'," WHERE id_phpapp IN($ids)")){
			  
			        $refresh= $this->LanguageArray('phpapp','Delete_successfully');

			   }else{
				    $refresh= $this->LanguageArray('phpapp','Delete_failed');

			   }
			   
			   echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			  
		  
		  }else{
			  
                 include_once(Core.'/class/pages_class_phpapp.php');
		  
		         $orderarr=array(
						  array('order'=>'a.id_phpapp','name'=>'ID'),
						  array('order'=>'a.name_phpapp','name'=>'广告名称'),
						  array('order'=>'a.apps_phpapp','name'=>'所属应用'),
						  array('order'=>'a.type_phpapp','name'=>'广告类型'),
						  array('order'=>'a.displayorder_phpapp','name'=>'排序'),
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
		 
	
		         $ajaxpage=new Pages(PHPAPP::$config['sys_operation_page'],$this->GET['page'],$this->MakeGetParameterURL(),"SELECT a.*,b.name_phpapp AS appname,b.class_phpapp FROM  ".$this->GetTable('advertising')." AS a JOIN ".$this->GetTable('apps')." AS b ON a.apps_phpapp=b.id_phpapp $wheresql $order");

                 $list=$ajaxpage->ShowResult();
   
		  
		         include $this->Template('list_manage');
		  }
	}
	
	
	function MakeAdParameters(){
		
		
		   $parameters=array();
					  
				
		   if($this->POST['type_phpapp']=='code'){

				   $parameters['htmlcode']=$_POST['htmlcode'];
				   $code=$_POST['htmlcode'];
				  
		   }elseif($this->POST['type_phpapp']=='txt'){
			      
				   $parameters['txtlink']=$_POST['txtlink'];
				   $parameters['txtcolor']=$_POST['txtcolor'];
				   $parameters['txtsize']=$_POST['txtsize'];
				   $parameters['txttitle']=$_POST['txttitle'];
				  
				   $code='<a href="'.$_POST['txtlink'].'" target="_blank" title="'.$_POST['txttitle'].'"><span style="color:'.$_POST['txtcolor'].';font-size:'.$_POST['txtsize'].';">'.$_POST['txttitle'].'</span></a>';
			   
		   }elseif($this->POST['type_phpapp']=='img'){
			      
				   $parameters['imgwidth']=$this->POST['imgwidth'];
				   $parameters['imgheight']=$this->POST['imgheight'];
				   $parameters['imglink']=$_POST['imglink'];
				   $parameters['imgurl']=$_POST['imgurl'];
				   $parameters['imgdescrip']=$_POST['imgdescrip'];
				  
				   if($this->POST['imgwidth']>0){
						$imgwidth='width="'.$this->POST['imgwidth'].'"';
				   }else{
						$imgwidth='';
				   }
				   
				   if($this->POST['imgheight']>0){
						$imgheight='height="'.$this->POST['imgheight'].'"';
				   }else{
						$imgheight='';
				   }
		 
		           $code='<a href="'.$_POST['imglink'].'" target="_blank" title="'.$_POST['imgdescrip'].'"><img src="'.$_POST['imgurl'].'" '.$imgwidth.' '.$imgheight.' alt="'.$_POST['imgdescrip'].'"/></a>';
		 
	
		   }elseif($this->POST['type_phpapp']=='flash'){
			   
			       $parameters['flashwidth']=$this->POST['flashwidth'];
				   $parameters['flashheight']=$this->POST['flashheight'];
				   $parameters['flashlink']=$_POST['flashlink'];
			   

			       if($this->POST['flashwidth']>0){
						$flashwidth='width="'.$this->POST['flashwidth'].'"';
				   }else{
						$flashwidth='';
				   }
				   
				   if($this->POST['flashheight']>0){
						$flashheight='height="'.$this->POST['flashheight'].'"';
				   }else{
						$flashheight='';
				   }
				   
				   $code='<embed src="'.$_POST['flashlink'].'" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" '.$flashwidth.' '.$flashheight.'></embed>';
			   
		   }
		   
		   if($this->POST['margin_phpapp']){
			    $code='<div style="margin-'.$this->POST['margin_phpapp'].'">'.$code.'</div>';
		   }
		
		   return array(serialize($parameters),$code);
	}
	
	
	
	function AddAction(){
		

		 if(!empty($this->POST['Submit'])) {
	
					  
	                  $parameters=$this->MakeAdParameters();
	  
					  $this->POST['parameters_phpapp']=$parameters[0];
					  $this->POST['code_phpapp']=$parameters[1];
					  
					  $newid=$this->Insert('advertising',$this->POST,array());
					  
					  $appid=$this->POST['apps_phpapp'];
					  
					  $adapp=$this->GetMysqlOne('class_phpapp'," ".$this->GetTable('apps')." WHERE id_phpapp='$appid'");
					  
					  if($adapp){
					       $this->Update('advertising',array('key_phpapp'=>$adapp['class_phpapp'].$newid),array(),"WHERE id_phpapp='$newid'");
					  }
			  
					  if($newid>0){
						   $refresh= $this->LanguageArray('phpapp','Add_success');

					  }else{
						  
						   $refresh= $this->LanguageArray('phpapp','Add_failed');
					  }
					  
					  echo $this->Refresh($refresh,$this->MakeGetParameterURL());
	
			
		 }else{
			   
				$appsarr=$this->GetMysqlArray('*',$this->GetTable('apps'));
				
				$nowtype='code';

		        include $this->Template('add_manage');
		 }
		 
		 
		
	}
	
	
	function EditAction(){
		
		 if(!empty($this->POST['Submit'])) {
			  
				 $id=$this->GET['id'];
  
                 $parameters=$this->MakeAdParameters();
	  
				 $this->POST['parameters_phpapp']=$parameters[0];
				 $this->POST['code_phpapp']=$parameters[1];
                 
				 
				 $appid=$this->POST['apps_phpapp'];
				 
                 $adapp=$this->GetMysqlOne('class_phpapp'," ".$this->GetTable('apps')." WHERE id_phpapp='$appid'");
					  
				 if($adapp){
					   $this->Update('advertising',array('key_phpapp'=>$adapp['class_phpapp'].$id),array(),"WHERE id_phpapp='$id'");
				 }
					  
				 $yes=$this->Update('advertising',$this->POST,array(),"WHERE id_phpapp='$id'");
		   
				 if($yes){
						$refresh= $this->LanguageArray('phpapp','Edited_successfully');
				 }else{
						$refresh= $this->LanguageArray('phpapp','Edit_failure');
				 }
		         
				 echo $this->Refresh($refresh,$this->MakeGetParameterURL());
			
		 }else{
		 
		 	     $id=$this->GET['id'];
		         
				 $appsarr=$this->GetMysqlArray('*',$this->GetTable('apps'));
				 
				 $manage=$this->GetMysqlOne('*'," ".$this->GetTable('advertising')." WHERE id_phpapp='$id'");
				  
				 $nowtype=$manage['type_phpapp'];
				 
				 $showad=@unserialize($manage['parameters_phpapp']);
		
			     include $this->Template('add_manage');
		 }
	}
	
	
	
	function ShowAction(){
		
		    $id=$this->GET['id'];
		    $manage=$this->GetMysqlOne('*'," ".$this->GetTable('advertising')." WHERE id_phpapp='$id'");
			include $this->Template('show_manage');
	}
	
}


?>