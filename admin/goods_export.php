<?
session_start();
// require('inc/common.php');
require_once(dirname(__FILE__) . '/../inc/yiiapp.php');
if((isset($_SESSION['priv'])&&$_SESSION['priv']=='admin')===FALSE)
	exit();
// print_r($_SESSION);
// echo 123;
require_once(dirname(__FILE__).'/../yii/protected/models/Goods.php');
$models = Goods::model()->findAllbyAttributes(array('valid'=>0));
// header("location:http://ya.ru");
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=export.csv");
header("Pragma: no-cache");
header("Expires: 0");
foreach($models as $model){
	echo "{$model->name};{$model->kod};".PHP_EOL;
}
// echo count($models);