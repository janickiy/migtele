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
		// �������� �� ������
		if(!in_array($cur_script,array('goods.php','visit.php')))
		{
			header("Location: visit.php");
			exit;
		}
	}

	require('inc/autoload.php'); //������������ �������
	require('../inc/db.php'); //����������� � ����
	require('../inc/utils.php'); //������ �������� �������
	require('../inc/tree.php'); //������ � �������
	require('../inc/advanced/advanced.php'); //"��������" � �����

	require('../fck/fckeditor.php'); // ��������
	require('special.php'); //������� ���������� ��� �������
	require('phpzip.php'); //����� ��� ������������� �����/��������

	require('file_upload.php'); // �������� ����� � ������� ��� �������� � �������� ��������

	require('menu.php'); // ����� ���� � ������ ������ ��� �������� ���� �������

	require_once(dirname(__FILE__).'/../../inc/yiiapp.php'); 
	// ����� ���� � ������ ������ ��� �������� ���� �������
	//require('excel_import.php'); // ������ ������ �� Exel
	//require('excel_export.php'); // ������� ������ � Exel
	//require('simple_html_dom.php'); // HTML ������

	require('../inc/special.php'); //������� ���������� ��� ������ �������

?>