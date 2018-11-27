<?
$this->breadcrumbs=array(
	'Admin'=>array('/'.Yii::app()->language.'/admin/'),
	'Manage transactions'=>array('/'.Yii::app()->language.'/admin/transactions'),
	//$model->id=>array('/'.Yii::app()->language.'/admin/viewUser','id'=>$model->id),	
	$model->id,
);
$this->menu=array(
	array('label'=>'Root management', 'url'=>array('/'.Yii::app()->language.'/admin/updateTransaction/','id'=>$model->id)),	
);
?>
<div class="form">
<?//print_r($model)?>
<?//return false;?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transactions-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>	
<?
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			array(
				'label'=>'Owner',
				'value'=>$model->owner->display_name,
			),
			array(
				'label'=>'Currency from',
				'value'=>(real)$model->fromValue.' '.$model->currencyFrom->briefname,
			),
			array(
				'label'=>'Currency to',
				'value'=>(real)$model->toValue.' '.$model->currencyTo->briefname,
			),
			'toAccount',
			'fromAccount',
			array(
				'label'=>'moneyRecieve',
				'value'=>($model->moneyRecieve)?'Yes':'No',
			),
			array(
				'label'=>'moneyTransfer',
				'value'=>($model->moneyTransfer)?'Yes':'No',
			),		
			
			'createDate',
			'updateDate',		
			array(
				'label'=>'Canceled',
				'value'=>($model->isCancelled)?'Yes':'No',
			),
			array(
				'label'=>'In work',
				'value'=>($model->inWork)?$model->admin->display_name:'No',
			),
		),
	));
	?>
	<?php echo $form->errorSummary($model); ?>
	<?
		$viewCancelation = (!$model->isCancelled && !$model->moneyRecieve)?TRUE:FALSE;
		$viewGetInWork = (!$model->isCancelled && !$model->inWork && $model->moneyRecieve)?TRUE:FALSE;
		$viewMoneyTransfer = (!$model->isCancelled && $model->inWork==Yii::app()->user->id && !$model->moneyTransfer)?TRUE:FALSE;
		//$viewCancelation = $viewGetInWork = $viewMoneyTransfer = TRUE;
		
	?>
	<?php 
		if($viewCancelation){
			echo $form->labelEx($model,'isCancelled');
			echo $form->dropDownList($model,'isCancelled',array('0'=>'None','1'=>'Canceled'));
			echo $form->error($model,'isCancelled');
		}	
		//echo '<br/>'.CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save');
		if($viewGetInWork){
			echo $form->labelEx($model,'inWork',array('label'=>'Get in work'));
			echo $form->checkBox($model,'inWork',array('value'=>Yii::app()->user->id));
			echo $form->error($model,'inWork');
		}
		if($viewMoneyTransfer){		
			echo $form->labelEx($model,'moneyTransfer');
			echo $form->dropDownList($model,'moneyTransfer',array('0'=>'No','1'=>'Yes'));
			echo $form->error($model,'moneyTransfer');
		}		
		if($viewCancelation||$viewGetInWork||$viewMoneyTransfer){
			echo '<br/>'.CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save');
		}
	?>
<?php $this->endWidget(); ?>
<?
//$txt = "14:usadba:CRbkjdf4wds3:123456789:1.00";
//echo $pd_sign=md5($txt)?>

</div><!-- form -->
<?//=Yii::app()->user->id?>