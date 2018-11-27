<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

//print_r($_GET);
?>
<h2>User exchanges</h2>
<div>Thank you for exchange application. <br/>
This is your exchange link (<b>http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?></b>) Please, save it for further operations<br/>
Your exchange code: <b><?=$model->sourceCode?></b><br/>
Status of exchange: <?=($model->moneyRecieve?'Money recieved':'Money not recieved')?><br/>
Please, transfer <b><?=(real)$model->currencyValueFrom?><?=$model->currencyFrom->briefname?></b> to the following account:<br/>
<?=$model->currencyFrom->accountInformation?>
</div>
<div>Please, give your exchange code to your opponent. Then, he should enter it on the next page: <?=CHtml::link($_SERVER['HTTP_HOST'].'/'.Yii::app()->language.'/continueexcahgeuser/','/'.Yii::app()->language.'/continueexcahgeuser/')?> </div>
