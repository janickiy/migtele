<?php
/* @var $this TransactionsController */
/* @var $data Transactions */
?>
<?
//return false;
/*if($data->isCancelled==1){
	$status = '<span style="color:red;">Transaction is canceled</span>';
}elseif($data->moneyRecieve==0){
	$status = '<span style="color:red;">Waiting of receipt of money</span>';
}elseif($data->moneyTransfer==0){
	$status = '<span style="color:green;">The money has been received. Waiting to send money.</span>';
}else{
	$status = '<span style="color:green;">Transaction completed.</span>';
}	*/
$moneyRecieve = ($data->moneyRecieve)?'Yes':'No';
$moneyTransfer = ($data->moneyTransfer)?'Yes':'No';
$recipientCodeActivated = ($data->destinationCodeLinkActive)?'Yes('.date('d.m.Y H:i',strtotime($data->destinationCodeLinkActiveTime)).')':'No';
$sourceCodeActivated = ($data->sourceCodeLinkActiveTime)?'Yes('.date('d.m.Y H:i',strtotime($data->sourceCodeLinkActiveTime)).')':'No';
?>
<div class="view">
	
	
	<?
		echo '<b>Exchange ID: </b>'.CHtml::link(CHtml::encode($data->id), array('/'.Yii::app()->language.'/admin/userexchange','id'=>$data->id)).'<br/>';		
		echo '<b>User: </b>'.CHtml::link(CHtml::encode($data->owner->display_name), array('/'.Yii::app()->language.'/admin/viewUser','id'=>$data->owner->id)).'<br/>';		
		echo '<b>Given: </b>'.CHtml::encode((real)$data->currencyValueFrom).' '.CHtml::encode($data->currencyFrom->briefname).'<br/>';		
		//echo '<b>Received: </b>'.CHtml::encode((real)$data->toValue).' '.CHtml::encode($data->currencyTo->briefname).'<br/>';		
		//echo '<b>Status: </b>'.$status.'<br/>';
		echo '<b>Received money: </b>'.$moneyRecieve.'<br/>';
		echo '<b>Transfer money: </b>'.$moneyTransfer.'<br/>';
		echo '<b>Recipient code activated: </b>'.$recipientCodeActivated.'<br/>';
		echo '<b>Source code activated: </b>'.$sourceCodeActivated.'<br/>';
		echo '<b>Date: </b>'.date('d.m.Y H:i',strtotime($data->createTime)).'<br/>';		
		//echo ($data->inWork)?'<b>In work: </b>'.$data->admin->display_name.'<br/>':'';	
	?>
	<br />
</div>