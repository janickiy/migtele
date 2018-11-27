<?
	session_start();
	
	if(!@$_SESSION['priv'])
	{
	  header("Location: ../login.php?action=vhodc&urlback=".$_SERVER['REQUEST_URI']);
	  exit();
	}
	
	$file = @$_GET['link'];
	
	if(!file_exists($file))
	{
		header("HTTP/1.0 404 Not Found");
		die("Файл не существует");
	}	
	
	$size = filesize($file);
	header("Content-Disposition: attachment; filename=".$file);
	header("Content-Length: ".$size);
	header("Content-Type: application/octet-stream");
	$fp = fopen($file,'rb');
	fpassthru($fp);
	fclose($fp);

?>