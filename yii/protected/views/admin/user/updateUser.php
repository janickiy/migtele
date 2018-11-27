<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Admin'=>array('/'.Yii::app()->language.'/admin/'),
	'Manage users'=>array('/'.Yii::app()->language.'/admin/users'),
	$model->name=>array('/'.Yii::app()->language.'/admin/viewUser','id'=>$model->id),	
	'Update',
);

$this->menu=array(
	array('label'=>'List Users', 'url'=>array('index')),
	array('label'=>'Create Users', 'url'=>array('create')),
	array('label'=>'View Users', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h1>Update Users <?php echo $model->id; ?></h1>

<?php $this->renderPartial('user/_form', array('model'=>$model,'countries'=>$countries,'userRoles'=>$userRoles)); ?>