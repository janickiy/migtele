<?php
/* @var $this CurrenciesController */
/* @var $model Currencies */

$this->breadcrumbs=array(
	'Admin'=>array('/'.Yii::app()->language.'/admin/'),
	'Manage currencies'=>array('/'.Yii::app()->language.'/admin/currencies'),	
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Currencies', 'url'=>array('/'.Yii::app()->language.'/admin/currencies')),	
);
?>

<h1>Create Currencies</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'currencies-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'briefname'); ?>
		<?php echo $form->textField($model,'briefname',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'briefname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stock'); ?>
		<?php echo $form->textField($model,'stock',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'stock'); ?>
	</div>	

	<div class="row">
		<?php echo $form->labelEx($model,'accountInformation'); ?>
		<?php echo $form->textArea($model,'accountInformation',array('size'=>60,'maxlength'=>256,'style'=>'width:400px;')); ?>
		<?php echo $form->error($model,'accountInformation'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>