<?php
/* @var $this CurrenciesController */
/* @var $model Currencies */

$this->breadcrumbs=array(
	'Admin'=>array('/'.Yii::app()->language.'/admin/'),
	'Manage currencies'=>array('/'.Yii::app()->language.'/admin/currencies'),
	$model->name,	
);

$this->menu=array(	
	array('label'=>'Edit Currency', 'url'=>array('/'.Yii::app()->language.'/admin/UpdateCurrency/','id'=>$model->id)),	
	array('label'=>'Create Currencies', 'url'=>array('/'.Yii::app()->language.'/admin/createCurrency/')),
	
);
?>

<h1>View Currencies #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'briefname',
		array(
			'label'=>'Reserve',
			'value'=>(real)$model->stock
		),
		'accountInformation'
	),
)); ?>
<?
	foreach($model->crossRates as $crossRate){
		echo "{$crossRate->fromCurrency->briefname} -> {$crossRate->toCurrency->briefname} = ".round($crossRate->value,6).'<br/>';
	}
?>
