<?php
/* @var $this CurrenciesController */
/* @var $model Currencies */

$this->breadcrumbs=array(
	'Admin'=>array('/'.Yii::app()->language.'/admin/'),
	'Manage currencies',
);

$this->menu=array(	
	array('label'=>'Create Currencies', 'url'=>array('/'.Yii::app()->language.'/admin/createCurrency/')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#currencies-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Currencies</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
<!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'currencies-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'briefname',
		array(
			'value'=>'number_format($data->stock,2)',
			'name'=>'stock',
		),		
		array(
			'class'=>'CButtonColumn',
			 'updateButtonUrl'=>'"/".Yii::app()->language.Yii::app()->createUrl("/admin/updateCurrency", array("id" => $data->id))',
			 'viewButtonUrl'=>'"/".Yii::app()->language.Yii::app()->createUrl("/admin/viewCurrency", array("id" => $data->id))',
			 'deleteButtonOptions'=>array('style'=>'display:none;'),
		),
	),
)); ?>
