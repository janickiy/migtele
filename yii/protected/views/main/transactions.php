<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<?
$this->breadcrumbs=array(
	'Transactions',
);
?>
<?//print_r($transactions);?>
<h1>My transactions</h1>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$transactions,
	'itemView'=>'_view',
)); ?>
<?	
	/*foreach($transactions as $transaction){
		if($transaction->isCancelled==1){
			$status = '<span style="color:red;">Transaction is canceled</span>';
		}elseif($transaction->moneyRecieve==0){
			$status = '<span style="color:red;">Waiting of receipt of money</span>';
		}elseif($transaction->moneyTransfer==0){
			$status = '<span style="color:green;">The money has been received. Waiting to send money.</span>';
		}else{
			$status = '<span style="color:green;">The transaction completed.</span>';
		}		
		echo '<div class="view">';
		echo '<b>Transaction ID: </b>'.CHtml::encode($transaction->id).'<br/>';		
		echo '<b>You given: </b>'.CHtml::encode((real)$transaction->fromValue).' '.CHtml::encode($transaction->currencyFrom->briefname).'<br/>';		
		echo '<b>You received: </b>'.CHtml::encode((real)$transaction->toValue).' '.CHtml::encode($transaction->currencyTo->briefname).'<br/>';		
		echo '<b>Status: </b>'.$status.'<br/>';	
		echo '<b>Date: </b>'.date('d.m.Y H:i',strtotime($transaction->createDate)).'<br/>';	
		echo '</div>';
		
	}*/
?>
