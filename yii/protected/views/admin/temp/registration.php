<?php
/* @var $this UsersController */
/* @var $model Users */

?>

<h1>Registration</h1>

<?php $this->renderPartial('_form', array(
			'model'=>$model,
			'countries'=>$countries,
		)); ?>