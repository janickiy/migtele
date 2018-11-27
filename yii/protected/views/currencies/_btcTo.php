<?php
/* @var $this TransactionsController */
/* @var $model Transactions */
/* @var $form CActiveForm */
?>

<div class="form" style="border:1px dotted;padding:5px;margin:5px;">

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
	<?echo $form->hiddenField($model,'toCurr',array('value'=>$currency->id)); ?>
</div><!-- form -->