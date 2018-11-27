<?
require('inc/common.php');
$tbl = "letter";
$rubric = "Сообщения";
$id = (int)@$_GET['id'];

$sqlmain = "SELECT * FROM {$prx}{$tbl} ORDER BY date DESC";
$k = 20;

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "saveall":
			break;

		case "save":
			foreach($_POST as $key=>$val)
				$$key = clean($val);
			
			update($tbl, "note='{$note}'", $id);

			$p = getPage($sqlmain,$id,$k);		
			?><script>top.location.href = "?p=<?=$p?>&id=<?=$id?>&rand=<?=rand()?>#<?=$id?>";</script><?
			break;
	
		case "del":
			update($tbl, "", $id);
			?><script>top.topReload();</script><?
			break;
	}
	exit;
}

ob_start();
// ------------------РЕДАКТИРОВАНИЕ--------------------
if(isset($_GET["red"]))
{
	$rubric .= " &raquo; ".($id ? "Редактирование" : "Добавление");
	$row = getRow("SELECT * FROM {$prx}{$tbl} WHERE id='{$id}'");
?>
	<a name="red"></a>
	<form action="?id=<?=$id?>&action=save" method="post" enctype="multipart/form-data" target="ajax">
		<table class="red" width="500">
			<tr>
				<th>Дата</th>
				<td><?=date("d.m.Y, H:i:s", strtotime($row['date']))?></td>
			</tr>
			<tr>
				<th>Текст</th>
				<td><?=$row["text"]?></td>
			</tr>
			<tr>
				<th>Комментарий</th>
				<td><textarea name="note"><?=$row["note"]?></textarea></td>
			</tr>
			<tr>
				<td align="center" colspan="2"><?=btnAction()?></td>
			</tr>
		</table>
	</form>			  
<?
}

// -----------------ПРОСМОТР-------------------
else
{	?>
	<form action="?action=saveall" target="ajax" method="post">
		<table class="content">
			<tr>
				<th>Дата</th>
				<th>Текст</th>
				<th>Комментарий</th>
				<th></th>
			</tr>
		<? 
			$p = @$_GET['p'] ? $_GET['p'] : 1;
			$sql = $sqlmain." LIMIT ".($p-1)*$k.", {$k}";
			$res = mysql_query($sql);
			while($row = mysql_fetch_array($res))
			{
				$id = $row["id"];
			?>
				<tr id="tr<?=$id?>">
					<td><a name="<?=$id?>"></a><?=date("d.m.Y, H:i:s", strtotime($row["date"]))?></td>
					<td><?=$row["text"]?></td>
					<td><?=nl2br($row["note"])?></td>
					<td><?=lnkAction("Red,Del")?></td>
				</tr>
		<?	}	?>
			<tr>
				<td colspan="4" align="center"><?=lnkPages($sqlmain, $p, $k)?></td>
			</tr>
		</table>	
	</form>
<?
}
$content = ob_get_clean();

require("template.php");
?>