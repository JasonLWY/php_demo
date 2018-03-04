<?php
/*
	EDOOG.COM (C) 2009-2012 EDOOG Inc.
	This is NOT a freeware, use is subject to license terms
	V2.0  2012.3.5
*/	

define('IN_PHPAPP', TRUE);

define('OPENMOBILE', FALSE);

include_once('./phpapp/config.php');

define('PHPAPP_DIR',preg_replace("/\\\/", '/', dirname(__FILE__) ) );

$language='cn';

$app=$action='Default';

$actiontype=3;

include_once(Core.'/main_phpapp.php');

?>