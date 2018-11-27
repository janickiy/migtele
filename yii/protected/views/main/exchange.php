<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/exchange.js"></script>
Вы хотите обменять валюту "<?=$currency1->name?>" на "<?=$currency2->name?>"
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transactions-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>
<?php echo $form->errorSummary($transaction); ?>
<div>Параметры источника:</div>
<?php $this->renderPartial('/currencies/_'.mb_strtolower($currency1->briefname).'From', array('model'=>$transaction,'form'=>$form,'currency'=>$currency1)); ?>
<div>Параметры назначения:</div>
<?php $this->renderPartial('/currencies/_'.mb_strtolower($currency2->briefname).'To', array('model'=>$transaction,'form'=>$form,'currency'=>$currency2)); ?>
<input type="hidden" name="crossrate" id="crossrate" value="<?=$crossRate->value?>" />
<div class="row buttons">
	<?php echo CHtml::submitButton('Transaction create'); ?>
</div>
<?php $this->endWidget(); ?>
