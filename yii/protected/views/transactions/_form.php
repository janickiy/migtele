<?php
/* @var $this TransactionsController */
/* @var $model Transactions */
/* @var $form CActiveForm */
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
		<?php echo $form->labelEx($model,'toСurr'); ?>
		<?php echo $form->textField($model,'toСurr'); ?>
		<?php echo $form->error($model,'toСurr'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fromСurr'); ?>
		<?php echo $form->textField($model,'fromСurr'); ?>
		<?php echo $form->error($model,'fromСurr'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'toValue'); ?>
		<?php echo $form->textField($model,'toValue'); ?>
		<?php echo $form->error($model,'toValue'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fromValue'); ?>
		<?php echo $form->textField($model,'fromValue'); ?>
		<?php echo $form->error($model,'fromValue'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'moneyRecieve'); ?>
		<?php echo $form->textField($model,'moneyRecieve'); ?>
		<?php echo $form->error($model,'moneyRecieve'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'moneyTransfer'); ?>
		<?php echo $form->textField($model,'moneyTransfer'); ?>
		<?php echo $form->error($model,'moneyTransfer'); ?>
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
		<?php echo $form->labelEx($model,'createDate'); ?>
		<?php echo $form->textField($model,'createDate'); ?>
		<?php echo $form->error($model,'createDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updateDate'); ?>
		<?php echo $form->textField($model,'updateDate'); ?>
		<?php echo $form->error($model,'updateDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ownerId'); ?>
		<?php echo $form->textField($model,'ownerId'); ?>
		<?php echo $form->error($model,'ownerId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ownerEmail'); ?>
		<?php echo $form->textField($model,'ownerEmail',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'ownerEmail'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->