<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
$viewCreateWithdrawRequest = $model->moneyRecieve && !$model->currencyIdTo;
$viewStatusWithdrawRequest = $model->moneyRecieve && $model->currencyIdTo;
$viewCompleteExchange = $model->moneyRecieve && $model->moneyTransfer;
$viewExchangeCode = $model->moneyRecieve && $model->moneyTransfer;
//var_dump($viewCreateWithdrawrequest);
//print_r($_GET);
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/userexchangeStatus.js"></script>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'exchange-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<h2>User exchanges</h2>
<div>
	Thank you for exchange application. <br/>
	This is your exchange link (<b>http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?></b>) Please, save it for further operations<br/>
	Your email: <b><?=$model->destinationEmail?></b><br/>
	Your exchange id: <b><?=$model->id?></b><br/>
	Source currency: <b><?=(real)$model->currencyValueFrom?> <?=$model->currencyFrom->name?></b><br/>	
	Status of exchange: <span style="font-weight:bold;color:<?=($model->moneyRecieve)?'green;':'red;';?>"><?=($model->moneyRecieve?'Money recieved':'Money not recieved')?></span><br/>	
	<div class="form">
	<?if($viewCreateWithdrawRequest){?>
		<div class="row">
			<?php echo $form->labelEx($model,'currencyIdTo',array('label'=>'Choose your withdraw currnecy:')); ?>
			<?php echo $form->dropDownList($model,'currencyIdTo',$aviableWithdrawCurrencies); ?>
			<?php echo $form->error($model,'currencyIdTo'); ?>
		</div>
		<div class="row">
			You recieve: <span id="you-receive" style="font-weight:bold;"><?=(real)$model->currencyValueFrom.' '.$model->currencyFrom->briefname?></span>
		</div>
		<div class="row buttons">
			<?php echo CHtml::submitButton('Create request'); ?>
		</div>
	<?}?>
	<?if($viewStatusWithdrawRequest){?>
		Destination currency: <b><?=(real)$model->currencyValueTo?> <?=$model->currencyTo->name?></b><br/>	
		Status of withdraw currency: <b>Request is created. <?=($model->moneyTransfer)?'Money transfered':'Money not transfered';?>.</b><br/>
		<?if($model->sourceCodeLinkActiveTime){?>
		Exchange code is activated(in <?=$model->sourceCodeLinkActiveTime?>)
		<?}else{?>
		Exchange code: <b><?=$model->destinationCode.$model->id?></b>, please give it to your patrner, when your transfer money to him.<br/>
		<?}?>
	<?}?>
	
	<?if($viewCompleteExchange){?>
		 <div style="color:green;font-weight:bold;">Exchange complete!</div>
	<?}?>
	</div>
	<?php $this->endWidget(); ?>
</div>
<!--Для обновления данных без перезагрузки страницы-->
<div style="display:none;">
	<span id="currency_<?=$model->currencyIdFrom?>"><?=(real)$model->currencyValueFrom.' '.$model->currencyFrom->briefname?></span>
	<?foreach($model->currencyFrom->crossRates as $crossrate){?>
	<span id="currency_<?=$crossrate->to?>"><?=(real)($crossrate->value*$model->currencyValueFrom).' '.$crossrate->toCurrency->briefname?></span>	
	<?}?>
</div>