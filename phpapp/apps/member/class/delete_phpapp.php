<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class DeleteMember extends PHPAPP{
	
	  
	  function DeleteMemberData($ids=''){
		  
		     $deletearray=array('member','member_account','member_consume','member_credit','member_feed','member_friend','member_info','member_mail_certificate','member_company_certificate','member_mobile_certificate','member_myfriend','member_personal','member_company','member_personal_certificate','member_union','member_visit'); 
		  
		     foreach($deletearray as $value){
		  
		            $this->Delete($value," WHERE uid IN($ids)");
			 
			 }

		     return true;
	  }
	
}


?>