<?
	@session_start();
	
	if(!@$_SESSION['priv'])
	{
		header("Location: login.php?action=vhodc&urlback=".$_SERVER['REQUEST_URI']);
		exit;
	}
	
	if(is_array($_SESSION['priv']))
	{
		$cur_script = basename($_SERVER['SCRIPT_FILENAME']);
		// разрешен ли доступ
		if(!in_array($cur_script,array('goods.php','visit.php')))
		{
			header("Location: visit.php");
			exit;
		}
	}

	require('inc/autoload.php'); //автозагрузка классов
	require('../inc/db.php'); //коннектимся к базе
	require('../inc/utils.php'); //разные полезные функции
	require('../inc/tree.php'); //работа с деревом
	require('../inc/advanced/advanced.php'); //"навороты" к сайту

	require('../fck/fckeditor.php'); // редактор
	require('special.php'); //функции специально для админки
	require('phpzip.php'); //класс для архивирования файла/каталога

	require('file_upload.php'); // загрузка файла и функции для загрузки и обратоки картинки

	require('menu.php'); // левое меню и группы ссылок для верхнего меню админки

	require_once(dirname(__FILE__).'/../../inc/yiiapp.php'); 
	// левое меню и группы ссылок для верхнего меню админки
	//require('excel_import.php'); // импорт данных из Exel
	//require('excel_export.php'); // экспорт данных в Exel
	//require('simple_html_dom.php'); // HTML парсер

	require('../inc/special.php'); //функции специально для данной системы

?>