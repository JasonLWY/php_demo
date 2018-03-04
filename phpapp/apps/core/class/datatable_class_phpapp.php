<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}


class DataTable extends PHPAPP{


		
	function __construct(){	 
		

	}
	
	public function AddTableFieldDate($post=array()){
		
		     $query='ALTER TABLE '.$post['table_phpapp'].' ADD '.$post['field_phpapp'];
							   
							   
			 if($post['filter_phpapp']==1){
				  $query.=" INT(10) NOT NULL DEFAULT '0'";
			 }elseif($post['filter_phpapp']==2){
				  $query.=" FLOAT NOT NULL";
			 }elseif($post['filter_phpapp']==3){

				  if($post['type_phpapp']=='textarea'){
						$query.=" MEDIUMTEXT NOT NULL";
				  }elseif($post['type_phpapp']=='checkbox'){	
						$query.=" TEXT NOT NULL";
				  }else{
						$query.=" VARCHAR(255) NOT NULL";
				  }
				  
			 }
			 

			 return $this->AddTableField($query);
	}
	
	
	public function MakeFormDate($field=array(),$value=array()){
		
		   $form='';
		   
		   $fieldname=$field["field_phpapp"];
		   
		   $fieldnamefilter='';
		   
		   if($field['filter_phpapp']==1){
			   
			    $fieldnamefilter.=$fieldname.'_d';
			   
		   }elseif($field['filter_phpapp']==2){
			    
				$fieldnamefilter.=$fieldname.'_f';
				 
		   }else{
				
				$fieldnamefilter.=$fieldname.'_s';
			   
		   }
            
		   $fieldvalue=empty($value[$fieldname]) ? '' : $value[$fieldname];
			
		   if(!empty($fieldvalue)){
				
				 $default=$fieldvalue;
				
		   }else{
				 $default=$field['default_phpapp'];
		   }
		   
		   if($field['value_phpapp']){
		        $valarray=explode("\n",$field['value_phpapp']);
		   }else{
			    $valarray='';
		   }
		   
		   
		   
		   switch($field['type_phpapp']) {
				case 'text':
			         $form='<input name="'.$fieldnamefilter.'" type="text"  id="'.$field['field_phpapp'].'" maxlength="'. $field['maxlength_phpapp'].'" class="form_input_text form_input_width_300"  value="'.$default.'"/>';
				break;
				case 'textarea':
				     $form='<textarea name="'.$fieldnamefilter.'" id="'.$field['field_phpapp'].'" class="form_textarea form_input_width_300 field_textarea"></textarea>';
				break;
				case 'radio':
				     
					 if($valarray){

							  foreach($valarray as $key=>$value){
								      $keyarry=explode('|',$value);
									  if($key==0){
										   $checked='checked';
									  }else{
										   if($fieldvalue==$keyarry[0]){
												$checked='checked';
									       }else{
											    $checked='';
										   }
									  }
									  
									  $newvalue=str_replace('"',"'",$keyarry[0]);
									 
									  $form.='<input name="'.$fieldnamefilter.'" type="radio" value="'.$newvalue.'" '.$checked.'/>'.$this->str($keyarry[1],99999,0,1,0,0,1).' ';
							  }
 
							  
					 }

				break;
				case 'checkbox':
				
				     if($valarray){

							  foreach($valarray as $key=>$value){
								      $keyarry=explode('|',$value);
									  if($key==0){
										   $checked='checked';
									  }else{
										   if($fieldvalue==$keyarry[0]){
												$checked='checked';
									       }else{
											    $checked='';
										   }
									  }
									  
									  if($field['submit_phpapp']){
										    $keyname='_'.$key;
									  }else{
										    $keyname='';
									  }
									  
									  $newvalue=str_replace('"',"'",$keyarry[0]);
									  
									  $form.='<input name="'.$fieldname.$keyname.'_s" type="checkbox" value="'.$newvalue.'" '.$checked.'/>'.$this->str($keyarry[1],99999,0,1,0,0,1).' ';
							  }
 
							  
					 }
				
				break;
				
				case ('select'||'selectmultiple'):
				
				     if($field['type_phpapp']=='selectmultiple'){
				
				           $multiple='multiple="multiple"';
						   
					 }else{
						   $multiple='';
					 }
				
				     if($valarray){
                              $form.='<select name="'.$fieldnamefilter.'" '.$multiple.'>';
							  
							  foreach($valarray as $key=>$selectvalue){
								      $keyarry=explode('|',$selectvalue);
									  if($key==0){
										   $checked='selected="selected"';
									  }else{
										   if($fieldvalue==$keyarry[0]){
												$checked='selected="selected"';
									       }else{
											    $checked='';
										   }
									  }
									  
									  $form.='<option value="'.$keyarry[0].'" '.$checked.'>'.$this->str($keyarry[1],99999,0,1,0,0,1).'</option>';
							  }
 
							  $form.='</select>';
					 }
				
				break;
				
		   }
		  
		   return $form;
		   
	}


}


?>