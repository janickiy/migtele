<?
require('inc/common.php');
$tbl = "price";
$top_menu = "price";
$rubric = "Прайс-листы &raquo; XLS прайсы";
$id = (int)@$_GET['id'];


// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "save":
			foreach(getArr("SELECT id FROM {$prx}catmaker") as $id)
				upfile("../uploads/catmaker/{$id}.xls", $_FILES["file{$id}"], @$_POST["del_file{$id}"]);	

			?><script>top.topReload();</script><?
			break;
	}
	exit;
}

ob_start();
// -----------------ПРОСМОТР-------------------
?>
<form action="?action=save" method="post" enctype="multipart/form-data" target="ajax">
	<table class="content">
		<tr>
			<th>Вендор</th>
			<th>Прайс</th>
		</tr>
	<?	
		$k = 20;	
		$p = @$_GET['p'] ? $_GET['p'] : 1;
		$sqlmain = "SELECT id,name FROM {$prx}catmaker ORDER BY sort";
		$res = sql($sqlmain." LIMIT ".($p-1)*$k.", {$k}");
		while($row = mysql_fetch_array($res))
		{	?>
			<tr>
				<td><?=$row["name"]?></td>
				<td><?=fileUpload("/uploads/catmaker/{$row['id']}.xls", "name='file{$row['id']}' style='width:250px'")?></td>
			</tr>
	<?	}	?>
		<tr>
			<td colspan="2" align="center"><?=btnAction("Save")?></td>
		</tr>
		<tr>
			<td colspan="9" align="center"><?=lnkPages($sqlmain, $p, $k)?></td>
		</tr>
	</table>
</form>
<?

$content = ob_get_clean();
$tbl .= "_xls";
require("template.php");
?>