<?php
/* @var $this TransactionsController */
/* @var $model Transactions */

$this->breadcrumbs=array(
	'Transactions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Transactions', 'url'=>array('index')),
	array('label'=>'Manage Transactions', 'url'=>array('admin')),
);
?>

<h1>Create Transactions</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>