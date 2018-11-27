<?php
require(dirname(__FILE__) . '/../../../inc/db.php');
return array(
	'connectionString' => 'mysql:host='.$mysql_conn['host'].';dbname='.$mysql_conn['db'],
	'emulatePrepare' => true,
	'username' => $mysql_conn['login'],
	'password' => $mysql_conn['pwd'],
	'charset' => 'cp1251',
	'enableProfiling' => true,
	'enableParamLogging' => true,
	'tablePrefix' => $prx,
);