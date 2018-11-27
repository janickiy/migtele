<?php
error_reporting(E_ERROR );
/* ini_set('error_reporting', E_ALL);
 define('YII_ENABLE_ERROR_HANDLER', true);
 define('YII_ENABLE_EXCEPTION_HANDLER', true);*/
/*error_reporting(E_ALL);
ini_set("display_startup_errors","1");
ini_set("display_errors","1");*/
require_once(dirname(__FILE__).'/../yii/core/yii.php');
Yii::createWebApplication(dirname(__FILE__).'/../yii/protected/config/main.php');
