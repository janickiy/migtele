<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Personal information'=>array('index'),	
	'Edit information',
);
$this->menu=array(
	//array('label'=>'Edit information', 'url'=>array('edit')),
	array('label'=>'Change password', 'url'=>array('changepassword')),
	//array('label'=>'Create Users', 'url'=>array('create')),
	//array('label'=>'Update Users', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete Users', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	//array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h1>Edit personal info</h1>

<?php //$this->renderPartial('_form', array('model'=>$model)); ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'display_name'); ?>
		<?php echo $form->textField($model,'display_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'display_name'); ?>
	</div>
	<!--div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'password_repeat'); ?>
		<?php echo $form->passwordField($model,'password_repeat',array('size'=>60,'maxlength'=>255)); ?>
		<?php //echo CHtml::activePasswordField($model,'password_repeat',array('size'=>60,'maxlength'=>255)); ?>		
		<?php echo $form->error($model,'password_repeat'); ?>
	</div-->	

	<!--div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div-->

	<div class="row">
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->dropDownList($model, 'country',$countries); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Registration' : 'Save'); ?>
	</div>
<?//print_r($countries);?>
<?php $this->endWidget(); ?>

</div><!-- form -->