<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

//print_r($_GET);
?>
<h2>User exchanges</h2>
<div>Thank you for exchange application. <br/>
This is your exchange link (<b>http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?></b>) Please, save it for further operations<br/>
Your exchange id: <b><?=$model->id?></b><br/>
Exchange code (for your partner): <b><?=$model->sourceCode.$model->id?></b><br/>
Exchange currency: <b><?=(real)$model->currencyValueFrom?> <?=$model->currencyFrom->name?></b><br/>
Status of exchange: <span style="font-weight:bold;color:<?=($model->moneyRecieve)?'green;':'red;';?>"><?=($model->moneyRecieve?'Money recieved':'Money not recieved')?></span><br/>
<?if(!$model->moneyRecieve){?>
Please, transfer <b><?=(real)$model->currencyValueFrom?><?=$model->currencyFrom->briefname?></b> to the following account:<br/>
<?=$model->currencyFrom->accountInformation?>
</div>
<?}?>
<div>
<?if($model->destinationCodeLinkActive){?>
Patner's exchange code is activated in <?=date('d.m.Y H:i:s',strtotime($model->destinationCodeLinkActiveTime))?>.
<?}else{?>
Please, give your exchange code to your opponent. Then, he should enter it on the next page: <?=CHtml::link('http://'.$_SERVER['HTTP_HOST'].'/'.Yii::app()->language.'/userexchange/code/','/'.Yii::app()->language.'/userexchange/code/')?>
<?}?>
</div>
<?if($model->destinationCodeLinkActive){?>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'exchange-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
		'focus'=>array($model,'code'),	
	)); ?>
	<div class="form">
	<?if($model->sourceCodeLinkActiveTime){?>
		<span style='color:green;font-weight:bold;'>Code is activated</span>(in <?=$model->sourceCodeLinkActiveTime?>).<br/>
		<?=($model->moneyTransfer)?'Money is transfered. Exchange complete.':'Waiting transfer money to your partner.'?>
	<?}else{?>
	<div class="row">
		<?php echo $form->labelEx($model,'code',array('label'=>'After receiving the money from your partner, it should give you a exchange code(different from that above), please enter it here:')); ?>
		<?php echo $form->textField($model,'code'); ?>
		<?php echo $form->error($model,'code'); ?>
		<?php echo CHtml::submitButton('Save code'); ?>
	</div> 
	<?}?>
	</div>
	<?php $this->endWidget(); ?>
<?}?>