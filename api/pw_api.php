<?php

error_reporting(0);
define('P_W','admincp');

include('../api.php');

define('R_P',PHPAPP_DIR.'/');
define('D_P',R_P);

require_once(PHPAPP_DIR.'/api/pw_api/security.php');

require_once(PHPAPP_DIR.'/api/pw_api/pw_common.php');

require_once(PHPAPP_DIR.'/api/pw_api/class_base.php');

$api = new api_client();

$response = $api->run($_POST + $_GET);

if($response) {
	echo $api->dataFormat($response);
}

?>