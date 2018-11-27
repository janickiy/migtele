<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

//print_r($_GET);
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
<div class="row">
	<?php echo $form->labelEx($model,'code',array('label'=>'Please, enter your code:')); ?>
	<?php echo $form->textField($model,'code'); ?>
	<?php echo $form->error($model,'code'); ?>
</div>
<div class="row">
	<?php echo $form->labelEx($model,'destinationEmail',array('label'=>'Please, enter your email:')); ?>
	<?php echo $form->textField($model,'destinationEmail'); ?>
	<?php echo $form->error($model,'destinationEmail'); ?>
</div>

<div class="row buttons">
	<?php echo CHtml::submitButton('Continue'); ?>
</div>
<?php $this->endWidget(); ?>
</div>