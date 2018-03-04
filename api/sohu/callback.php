<?php

include('../../api.php');

include(APPS.'/sohu/main_phpapp.php');

$api=new SohuAPIMainControls();

$api->CallbackAction();


?>
