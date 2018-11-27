<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Admin'=>array('/'.Yii::app()->language.'/admin/'),
	'Manage users',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#users-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?//print_r($model);?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'email',
		//'display_name',		
		'name',
		'created_time',
		'Country.name_en',		
		array(
			'name'=>'role',			
			'filter'=>array(				
				'administrator'=>'administrator',
				'moderator'=>'moderator',
				'user'=>'user',
			),
		),
		
		/*
		'country',
		'created_time',
		*/
		array(
			'class'=>'CButtonColumn',
			// 'updateButtonUrl'=>'"/".Yii::app()->language.Yii::app()->createUrl("/admin/updateUser", array("id" => $data->id))',
			'updateButtonUrl'=>'Yii::app()->createUrl(Yii::app()->language."/admin/updateUser", array("id" => $data->id))',
			 'viewButtonUrl'=>'Yii::app()->createUrl(Yii::app()->language."/admin/viewUser", array("id" => $data->id))',
			 //'viewButtonUrl'=>'"/".Yii::app()->language.Yii::app()->createUrl("/".Yii::app()->language.Yii::app()->createUrl."/admin/viewUser", array("id" => $data->id))',
			 'deleteButtonOptions'=>array('style'=>'display:none;'),
		),
	),
)); ?>