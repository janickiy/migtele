<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<title><?=$_SERVER['SERVER_NAME']?> - <?=@$title?></title>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	<link rel="stylesheet" type="text/css" href="inc/style.css">
  <script language="JavaScript" src="/inc/jquery-1.4.4.min.js"></script>
	<script language="JavaScript" src="/inc/utils.js"></script>
	<script language="JavaScript" src="/inc/special.js"></script>
</head>
<body>
<iframe src="/inc/none.html" name="ajax" id="ajax" style="display:none; width:100%;"></iframe>

<?=@$content?>

<script>
	// раскрашиваем таблицы "content"
	var _tables, i, _tr, j;
	_tables = document.getElementsByTagName("TABLE");
	for(i in _tables)
		if(_tables[i].className == "content")
		{
			_tr = _tables[i].getElementsByTagName("TR");
			for(j=0; j<_tr.length; j++)
				if(j%2)
					_tr[j].className = "second";
		}
	// подсветка строки
<?	$trId = @$_SESSION['id_active'] ? $_SESSION['id_active'] : @$_GET["id"];
	unset($_SESSION['id_active']);	?>
	try { get('tr<?=$trId?>').className='active'; }
	catch(e) {}  
	// подсветка ссылки
	try { get('a_<?=@$tbl?>').className='active'; }
	catch(e) {}  
</script>
</body>
</html>
