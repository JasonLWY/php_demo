<?php

include('../../api.php');

include(APPS.'/taobao/main_phpapp.php');

$api=new TaoBaoAPIMainControls();

$api->CallbackAction();


?>