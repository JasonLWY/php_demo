<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

if(!defined('IN_PHPAPP')) {
	exit('Data error');
}

class MemberFunction extends PHPAPP{
	
	  
	  function GetTypeNameMember($id){
		  
		     $membertype=$this->GetMysqlOne('name_phpapp,table_phpapp'," ".$this->GetTable('member_type')." WHERE status_phpapp=0 AND id_phpapp='$id'");

		     return $membertype;
	  }
	
}


?>