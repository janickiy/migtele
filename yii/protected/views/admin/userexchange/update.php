<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

//print_r($_GET);
?>
<?
$this->breadcrumbs=array(
	'Admin'=>array('/'.Yii::app()->language.'/admin/'),
	'Manage user exchanges'=>array('/'.Yii::app()->language.'/admin/userexchanges/'),
	$model->id
);
?>
<?
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'label'=>'Owner',
			'value'=>$model->owner->display_name,
		),
		array(
			'label'=>'Currency',
			'value'=>(real)$model->currencyValueFrom.' '.$model->currencyFrom->briefname,
		),
		'createTime',
		array(
			'label'=>'moneyRecieve',
			'value'=>($model->moneyRecieve)?'Yes':'No',
		),
		array(
			'label'=>'moneyTransfer',
			'value'=>($model->moneyTransfer)?'Yes':'No',
		),		
		array(
			'label'=>'Recipient code activated',
			'value'=>($model->destinationCodeLinkActive)?'Yes('.date('d.m.Y H:i',strtotime($model->destinationCodeLinkActiveTime)).')':'No',
		),
		array(
			'label'=>'Source code activated',
			'value'=>($model->sourceCodeLinkActiveTime)?'Yes('.date('d.m.Y H:i',strtotime($model->sourceCodeLinkActiveTime)).')':'No',
		),
		'destinationEmail',
	),
));
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'code-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
<?if(!$model->moneyRecieve){?>
<div class="row">
	<?php echo $form->labelEx($model,'moneyRecieve'); ?>
	<?php echo $form->dropDownList($model,'moneyRecieve',array(0=>'No',1=>'Yes')); ?>
	<?php echo $form->error($model,'moneyRecieve'); ?>	
</div>
<?}?>
<?if(!$model->moneyTransfer){?>
<div class="row">
	<?php echo $form->labelEx($model,'moneyTransfer'); ?>
	<?php echo $form->dropDownList($model,'moneyTransfer',array(0=>'No',1=>'Yes')); ?>
	<?php echo $form->error($model,'moneyTransfer'); ?>	
</div>
<?}?>
<?if(!$model->moneyTransfer || !$model->moneyRecieve){?>
<div class="row buttons">
	<?php echo CHtml::submitButton('Save'); ?>
</div>
<?}?>
<?php $this->endWidget(); ?>
</div>