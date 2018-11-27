<?php
/* @var $this TransactionsController */
/* @var $model Transactions */
/* @var $form CActiveForm */
?>
<?
$this->breadcrumbs=array(
	'Admin'=>array('/'.Yii::app()->language.'/admin/'),
	'Manage transactions'=>array('/'.Yii::app()->language.'/admin/transactions'),
	//$model->id=>array('/'.Yii::app()->language.'/admin/viewUser','id'=>$model->id),	
	'Root manage',$model->id,
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
			'label'=>'Currency from',
			'value'=>(real)$model->fromValue.' '.$model->currencyFrom->briefname,
		),
		array(
			'label'=>'Currency to',
			'value'=>(real)$model->toValue.' '.$model->currencyTo->briefname,
		),
		'toAccount',
		'fromAccount',
		array(
			'label'=>'moneyRecieve',
			'value'=>($model->moneyRecieve)?'Yes':'No',
		),
		array(
			'label'=>'moneyTransfer',
			'value'=>($model->moneyTransfer)?'Yes':'No',
		),		
		
		'createDate',
		'updateDate',		
		array(
			'label'=>'Canceled',
			'value'=>($model->isCancelled)?'Yes':'No',
		),
	),
));
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transactions-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>	
	
	<div class="row">
		<?php echo $form->labelEx($model,'fromValue'); ?>
		<?php echo $form->textField($model,'fromValue'); ?>
		<?php echo $form->error($model,'fromValue'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'toValue'); ?>
		<?php echo $form->textField($model,'toValue'); ?>
		<?php echo $form->error($model,'toValue'); ?>
	</div>


	

	<div class="row">
		<?php echo $form->labelEx($model,'toAccount'); ?>
		<?php echo $form->textField($model,'toAccount',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'toAccount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fromAccount'); ?>
		<?php echo $form->textField($model,'fromAccount',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'fromAccount'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'moneyRecieve'); ?>		
		<? echo $form->dropDownList($model,'moneyRecieve',array('0'=>'No','1'=>'Yes'));?>
		<?php echo $form->error($model,'moneyRecieve'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'moneyTransfer'); ?>
		<? echo $form->dropDownList($model,'moneyTransfer',array('0'=>'No','1'=>'Yes'));?>
		<?php echo $form->error($model,'moneyTransfer'); ?>
	</div>
	<div class="row">
	<?php
		echo $form->labelEx($model,'isCancelled');
		echo $form->dropDownList($model,'isCancelled',array('0'=>'No','1'=>'Yes'));
		echo $form->error($model,'isCancelled');		
	?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->