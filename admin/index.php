<?
require('inc/common.php');

$rubric = "Система управления сайтом";

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "phpinfo":
			echo phpinfo();
			break;
	}
	exit;
}

ob_start();
// ------------------ПРОСМОТР--------------------
?>
<table class="content">
	<tr>
		<th>Общая информация</th>
	</tr>
	<tr>
		<td style="padding:20px;">
			<a href="settings.php">Название сайта</a>: <b><?=set("title")?></b><br>
			URL: <a href="/"><b>http://<?=$_SERVER['SERVER_NAME']?></b></a><br>
			<!--<br>
			Количество <a href="pages.php">страниц</a>: <b><?=getField("SELECT count(*) AS c FROM {$prx}pages")?></b><br>-->
		</td>
	</tr>
</table>
<br><br>
<table class="content" width="100%">
	<tr>
		<th><a href="visit.php">Статистика посещений</a> сайта</th>
	</tr>
	<tr>
		<td style="padding:20px;">
			<?
				include_once("../inc/advanced/open-flash-chart/open_flash_chart_object.php");
				open_flash_chart_object("100%", 250, "visit.php?action=getdata", false, "../inc/advanced/open-flash-chart/");
			?>
		</td>
	</tr>
</table>
<br><br>
<a name="phpinfo"></a>
<table class="content" width="100%">
	<tr>
		<th><a href="?phpinfo#phpinfo">Показать PHP-info</a></th>
	</tr>
<?	if(isset($_GET["phpinfo"])) {	?>
		<tr>
			<td width="100%"></td>
		</tr>
<?	}	?>
</table>
<?

$content = ob_get_clean();

require("template.php");
?>