<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
//print_r($_GET);
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/exchange.js"></script>
<h2>User exchanges</h2>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'userexchange-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
<div class="row">
	<?php echo $form->labelEx($model,'currencyIdFrom',array('label'=>'Choose your currency')); ?>
	<?php echo $form->dropDownList($model,'currencyIdFrom',$currencies); ?>
	<?php echo $form->error($model,'currencyIdFrom'); ?>
</div>
<div class="row">
	<?php echo $form->labelEx($model,'currencyValueFrom',array('label'=>'Choose a value')); ?>
	<?php echo $form->textField($model,'currencyValueFrom'); ?>
	<?php echo $form->error($model,'currencyValueFrom'); ?>
</div>

<div class="row buttons">
	<?php echo CHtml::submitButton('Transaction create'); ?>
</div>
<?php $this->endWidget(); ?>
