<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/index.js"></script>
<?//=Yii::app()->getRequest()->getPreferredLanguage();?>
<?//echo crypt('12345', '$2a$10$NfVgzh0.GhIfjAvqPf0GFg$');?>
<pre>
<?//print_r(Yii::app()->user)?>
<?//=Yii::app()->user->id?>
</pre>
<style>
	.give_currency, .recieve_currency{cursor:pointer;border-radius:3px;padding:3px;}
	.give_currency:hover, .active_give_currency, .recieve_currency:hover{background-color:rgb(230,230,230);}
	#td-for-recieve-currency a{
		color:inherit;
		text-decoration:none;
	}
</style>
<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>