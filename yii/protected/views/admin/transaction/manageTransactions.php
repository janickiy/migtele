<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<?
$this->breadcrumbs=array(
	'Admin'=>array('/'.Yii::app()->language.'/admin/'),
	'Manage transactions',
);
?>
<h1>Manage transactions</h1>
<?//return false;?>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$transactions,
	'itemView'=>'transaction/_viewTransaction',
)); ?>
