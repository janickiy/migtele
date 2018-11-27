<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<?
$this->breadcrumbs=array(
	'Admin'=>array('/'.Yii::app()->language.'/admin/'),
	'Manage user exchanges',
);
?>
<h1>Manage user exchanges</h1>
<?//return false;?>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$transactions,
	'itemView'=>'userexchange/_view',
)); ?>
