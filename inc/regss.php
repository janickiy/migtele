<?
@session_start();

// тип вывода товаров
if($_GET['gvid']) $_SESSION['gvid'] = $_GET['gvid'];
// тип сортировки товаров
if($_GET['gsort']) $_SESSION['gsort'] = $_GET['gsort'];
?>