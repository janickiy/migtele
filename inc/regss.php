<?
@session_start();

// ��� ������ �������
if($_GET['gvid']) $_SESSION['gvid'] = $_GET['gvid'];
// ��� ���������� �������
if($_GET['gsort']) $_SESSION['gsort'] = $_GET['gsort'];
?>