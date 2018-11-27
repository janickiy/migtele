<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Admin'=>array('/'.Yii::app()->language.'/admin/'),
	'Manage users'=>array('/'.Yii::app()->language.'/admin/users'),
	$model->name,	
);

$this->menu=array(
	array('label'=>'Edit information', 'url'=>array('/'.Yii::app()->language.'/admin/updateUser','id'=>$model->id)),
	//array('label'=>'Change password', 'url'=>array('changepassword')),
	//array('label'=>'Create Users', 'url'=>array('create')),
	//array('label'=>'Update Users', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete Users', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	//array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h1>Personal information</h1>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(	
		'email',		
		'display_name',
		'name',		
		'Country.name_'.Yii::app()->language,
		'created_time',
		
	),
));
//$user = Users::model()->findByPk(1);
//print_r($user);
//echo $user->Country->name_ru;
 ?>
