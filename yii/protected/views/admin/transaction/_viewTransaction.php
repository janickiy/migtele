<?php
/* @var $this TransactionsController */
/* @var $data Transactions */
?>
<?
//return false;
if($data->isCancelled==1){
	$status = '<span style="color:red;">Transaction is canceled</span>';
}elseif($data->moneyRecieve==0){
	$status = '<span style="color:red;">Waiting of receipt of money</span>';
}elseif($data->moneyTransfer==0){
	$status = '<span style="color:green;">The money has been received. Waiting to send money.</span>';
}else{
	$status = '<span style="color:green;">Transaction completed.</span>';
}	
?>
<div class="view">
	
	
	<?
		echo '<b>Transaction ID: </b>'.CHtml::link(CHtml::encode($data->id), array('/'.Yii::app()->language.'/admin/transaction','id'=>$data->id)).'<br/>';		
		echo '<b>User: </b>'.CHtml::link(CHtml::encode($data->owner->display_name), array('/'.Yii::app()->language.'/admin/viewUser','id'=>$data->owner->id)).'<br/>';		
		echo '<b>Given: </b>'.CHtml::encode((real)$data->fromValue).' '.CHtml::encode($data->currencyFrom->briefname).'<br/>';		
		echo '<b>Received: </b>'.CHtml::encode((real)$data->toValue).' '.CHtml::encode($data->currencyTo->briefname).'<br/>';		
		echo '<b>Status: </b>'.$status.'<br/>';
		echo '<b>Date: </b>'.date('d.m.Y H:i',strtotime($data->createDate)).'<br/>';		
		echo ($data->inWork)?'<b>In work: </b>'.$data->admin->display_name.'<br/>':'';	
	?>
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