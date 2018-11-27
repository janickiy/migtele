<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
    <meta http-equiv="Pragma" content="no-cache">
    <title><?=$_SERVER['SERVER_NAME']?> - Администрирование</title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" type="text/css" href="inc/style.css?v=1.2">
    <link rel="stylesheet" href="/admin/css/select2.min.css">
<!--    <script language="JavaScript" src="/inc/jquery-1.4.4.min.js"></script>-->
<!--    <script type="text/javascript" src="/js/jquery.min.js"></script>-->
    <script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>

    <script src="/admin/js/select2.min.js"></script>
    <script src="/admin/js/interested_products.js"></script>
    <script src="/admin/js/selectors.js?v=1.45"></script>
    <script src="/admin/js/users.js"></script>
    <script src="/admin/js/vendor_discount.js"></script>

    <script type="text/javascript" src="/inc/utils.js"></script>
    <script type="text/javascript" src="/inc/special.js"></script>


	<!-- CKEDITOR-->
	<script type="text/javascript" src="/fck/new/ckeditor.js?v=1.2"></script>
	<script type="text/javascript" src="/fck/new/config.js?v=1.6"></script>

    <!-- всплывающие окна --->
    <script type="text/javascript" src="/inc/advanced/jB/jquery.jB.js"></script>
    <script type="text/javascript" src="/inc/advanced/jPop/jquery.jPop.js"></script>
    <link rel="stylesheet" href="/inc/advanced/jPop/jPop.css" type="text/css" />
    <link rel="stylesheet" href="css/start/jquery-ui-1.10.3.custom.min.css" type="text/css" />
	<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.min.js"></script>


</head>

<body>
<iframe src="/inc/none.html" name="ajax" id="ajax" style="display:none; width:100%;"></iframe>


<table width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td style="color:#FFFFFF; padding:8px" bgcolor="#5373AC">
			<div style="float:left; font-weight:bold;">
				<a href="/" style="color:#FFFFFF"><u><?=$_SERVER['SERVER_NAME']?></u></a> - 
				<a href="/admin/" style="color:#FFFFFF">Администрирование</a>
			</div>
			<div style="float:right;"><a href="login.php?action=vyhod" style="color:#FFF">(выход)</a></div>
		</td>
	</tr>
	<tr>
		<td height="60" style="border-bottom:#5373AC 1px solid;">

			<table width="100%">
				<tr>
					<td class="st_zag" style="padding-left:10px;">
						<!-- название раздела -->
						<?=@$rubric?>
					</td>
					<td align="right"><img src="img/load.gif" id="imgLoad" style="visibility:hidden;"></td>
				</tr>
			</table>

		</td>
	</tr>
	<tr>
		<td height="100%" valign="top">
	
			<table width="100%" height="100%" cellspacing="0">
				<tr>
					<td height="100%" width="200" valign="top">
	
						<table cellspacing="0" height="100%" bgcolor="#E1ECFC" width="100%">
							<tr>
								<td height="100%" style="border-right:#D4DCE6 1px solid; padding:25px 4px 10px 4px;" valign="top" nowrap>
									<div style="color:#808080;	font-weight:bold;">Навигация</div>
									<div style="border-top:1px solid #CCCCCC;	margin:5px 8px 0px 0px; padding:8px 0px 0px 8px; line-height:2; color:#003399;">
										<!--левое меню-->
										<?=@$left_menu?>
									</div>
								</td>
							</tr>
						</table>
	
					</td>
					<td valign="top" style="padding:16px;">
						<!--верхнее меню-->
						<?=@topMenu(@$top_menu)?>
						<!-- содержание страницы -->
						<?=@$content?>
					</td>
				</tr>
			</table>

		</td>
	</tr>
	<tr>
		<td style="border-top:#CCCCCC 1px solid; padding:15px;" align="right">
			Разработчик: <a href="http://www.beontop.ru" target="_blank">www.beontop.ru</a>
		</td>
	</tr>
</table>

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
	//FCE
	CKEDITOR.replaceAll( function(textarea,config) {
		if (textarea.className!="ckeditor-textarea") return false; //for only assign a class
		config.font_names = 'Roboto;Arial;Comic Sans MS;Times New Roman;Verdana';
		config.language  = 'ru';
		config.baseHref  = '/';
		config.filebrowserUploadUrl  = '/fck/new/upload.php';
	});
</script>





</body>
</html>
