<?php
/* @var $this TransactionsController */
/* @var $model Transactions */
/* @var $form CActiveForm */
?>

<div class="form" style="border:1px dotted;padding:5px;margin:5px;">
	
	<div class="row">
		<?php echo $form->labelEx($model,'fromValue'); ?>
		<?php echo $form->textField($model,'fromValue'); ?>
		<?php echo $form->error($model,'fromValue'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'fromAccount'); ?>
		<?php echo $form->textField($model,'fromAccount',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'fromAccount'); ?>
	</div>
	<?echo $form->hiddenField($model,'fromCurr',array('value'=>$currency->id)); ?>
	
</div><!-- form -->