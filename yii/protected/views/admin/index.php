<?php
/* @var $this UsersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Admin',
);


?>

<h1>Management</h1>

<?
$this->menu=array(
	array('label'=>'Manage users', 'url'=>array(Yii::app()->language.'/admin/users')),
	array('label'=>'Manage currencies', 'url'=>array(Yii::app()->language.'/admin/currencies')),
	array('label'=>'Manage transactions', 'url'=>array(Yii::app()->language.'/admin/transactions')),
	array('label'=>'Manage user exchanges', 'url'=>array(Yii::app()->language.'/admin/userexchanges')),
);
?>
