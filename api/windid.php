<?php

include('../api.php');

define('WINDID_CLIENT_KEY',PHPAPP::$config['uc_key']); 

define('WINDID_CLIENT_ID',PHPAPP::$config['uc_appid']);

require_once APPS.'/ucclient/windid_client/src/windid/WindidApi.php';

require_once APPS.'/ucclient/windid_client/src/windid/service/base/WindidUtility.php'; 
          
$_windidkey = getInput('windidkey', 'get');
$_time = (int)getInput('time', 'get');
$_clentid = (int)getInput('clientid', 'get');

$time = time();

if (WindidUtility::appKey(WINDID_CLIENT_ID, $_time, WINDID_CLIENT_KEY) != $_windidkey) showMessage('fail');
if ($time - $_time > 120) showMessage('timeout');
   
$operation = (int)getInput('operation', 'get');

list($method, $args) = getMethod($operation); 

if (!$method) showMessage('fail');


$notify = new notify();
if(!method_exists($notify, $method)) showMessage('success');

$result = call_user_func_array(array($notify,$method), getInput($args,'request')); 

if($result){ 
	 showMessage('success');
}else{
     showMessage('fail');
}
        
    
function getInput($key, $method = 'get') {
    if (is_array($key)) {
            $result = array();
            foreach ($key as $_v) {
                $result[$_v] = getInput($_v, $method);
            }
            return $result;
    }
    switch ($method) {
        case 'get':
          return isset($_GET[$key]) ? $_GET[$key] : null;
        case 'post':
          return isset($_POST[$key]) ? $_POST[$key] : null;  
        case 'request':
          return isset($_REQUEST[$key]) ? $_REQUEST[$key] : null;    
       default:
            return null;
    }
}

function showMessage($message = 'success') {
    echo $message;
    exit();
}

function getMethod($operation) {
    $config = include APPS.'/ucclient/windid_client/src/windid/service/base/WindidNotifyConf.php'; 
    $method = isset($config[$operation]['method']) ? $config[$operation]['method'] : '';
    $args = isset($config[$operation]['args']) ? $config[$operation]['args'] : array();
    return array($method, $args);
}

class notify{
       
    public function test($test) {
        return $test ? true : false;
    }

	public function deleteUser($uid) {
		  include_once(APPS.'/member/class/delete_phpapp.php');
		  $member=new DeleteMember();
		  $member->DeleteMemberData($uid);
		  return true;
	}
       
    public function synLogin($uid) {
		
		include_once(APPS.'/member/main_phpapp.php');
		$member=new MemberMainControls();
		$userarr=$member->GetLoginInfo($uid,1);
        $member->SetCookies($uid,$userarr['username']);
        return true;
    }
           
    public function synLogout($uid) {
		
        include_once(APPS.'/member/main_phpapp.php');
		$member=new MemberMainControls();
        $member->OutLoginAction();
        return true;
    }
  
}

?>