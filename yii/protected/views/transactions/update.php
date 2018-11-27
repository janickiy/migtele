<?php
/* @var $this TransactionsController */
/* @var $model Transactions */

$this->breadcrumbs=array(
	'Transactions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Transactions', 'url'=>array('index')),
	array('label'=>'Create Transactions', 'url'=>array('create')),
	array('label'=>'View Transactions', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Transactions', 'url'=>array('admin')),
);
?>

<h1>Update Transactions <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>