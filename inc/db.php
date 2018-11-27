<?
	//$mysql_conn=array("host"=>"localhost","login"=>"root","pwd"=>"","db"=>"migtele");
	$mysql_conn=array("host"=>"localhost", "login"=>"root", "pwd"=>"", "db"=>"u184926");
				  
	$dblink=mysql_connect($mysql_conn['host'],$mysql_conn['login'],$mysql_conn['pwd']) or exit ("Database connection error");
	mysql_select_db($mysql_conn['db'], $dblink) or exit ("Database not found");
	$prx = "mig_";
	mysql_query("SET NAMES cp1251");	
?>
