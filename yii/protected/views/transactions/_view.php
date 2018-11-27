<?php
/* @var $this TransactionsController */
/* @var $data Transactions */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('toСurr')); ?>:</b>
	<?php echo CHtml::encode($data->toСurr); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fromСurr')); ?>:</b>
	<?php echo CHtml::encode($data->fromСurr); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('toValue')); ?>:</b>
	<?php echo CHtml::encode($data->toValue); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fromValue')); ?>:</b>
	<?php echo CHtml::encode($data->fromValue); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('moneyRecieve')); ?>:</b>
	<?php echo CHtml::encode($data->moneyRecieve); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('moneyTransfer')); ?>:</b>
	<?php echo CHtml::encode($data->moneyTransfer); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('toAccount')); ?>:</b>
	<?php echo CHtml::encode($data->toAccount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fromAccount')); ?>:</b>
	<?php echo CHtml::encode($data->fromAccount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('createDate')); ?>:</b>
	<?php echo CHtml::encode($data->createDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updateDate')); ?>:</b>
	<?php echo CHtml::encode($data->updateDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ownerId')); ?>:</b>
	<?php echo CHtml::encode($data->ownerId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ownerEmail')); ?>:</b>
	<?php echo CHtml::encode($data->ownerEmail); ?>
	<br />

	*/ ?>

</div>