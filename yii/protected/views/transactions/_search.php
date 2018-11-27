<?php
/* @var $this TransactionsController */
/* @var $model Transactions */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'toСurr'); ?>
		<?php echo $form->textField($model,'toСurr'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fromСurr'); ?>
		<?php echo $form->textField($model,'fromСurr'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'toValue'); ?>
		<?php echo $form->textField($model,'toValue'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fromValue'); ?>
		<?php echo $form->textField($model,'fromValue'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'moneyRecieve'); ?>
		<?php echo $form->textField($model,'moneyRecieve'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'moneyTransfer'); ?>
		<?php echo $form->textField($model,'moneyTransfer'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'toAccount'); ?>
		<?php echo $form->textField($model,'toAccount',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fromAccount'); ?>
		<?php echo $form->textField($model,'fromAccount',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'createDate'); ?>
		<?php echo $form->textField($model,'createDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updateDate'); ?>
		<?php echo $form->textField($model,'updateDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ownerId'); ?>
		<?php echo $form->textField($model,'ownerId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ownerEmail'); ?>
		<?php echo $form->textField($model,'ownerEmail',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->