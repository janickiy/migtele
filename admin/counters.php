<?
require('inc/common.php');
$tbl = "counters";
$rubric = "Счетчики";
$id = (int)@$_GET['id'];

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "save":
			foreach($_POST as $key=>$val)
				$$key = clean($val);
	
			$id = update($tbl, "html='{$html}', note='{$note}', position='{$position}'", $id);

			?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
			break;
	
		case "del":
			update($tbl, "", $id);
			?><script>top.topReload();</script><?
			break;

		case "moveup":
			$move = "up";
		case "movedown":
			moveSort((@$move ? "up" : "down"), $tbl, $id);
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
	<form action="?id=<?=$id?>&action=save" method="post" enctype="multipart/form-data" target="ajax">
		<table class="red" style="width:600px;">
			<tr>
				<th>Код счетчика</th>
				<td><textarea name="html" rows="10"><?=$row['html']?></textarea></td>
			</tr>
			<tr>
				<th>Примечание</th>
				<td><textarea name="note" rows="5"><?=$row['note']?></textarea></td>
			</tr>
            <tr>
                <th>Расположение</th>
                <td>
                    <select name="position" id="">
                        <option value="bottom" <?=$row['position'] == 'bottom' ? 'selected' : ''?> >Внизу</option>
                        <option value="top" <?=$row['position'] == 'top' ? 'selected' : ''?>>Вверху</option>
                    </select>
                </td>
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
{
	echo lnkAction("Add");
?>
	<table class="content">
		<tr>
			<th>Счетчик</th>
			<th>Примечание</th>
            <th>Расположение</th>
			<th></th>
		</tr>
	<? 
		$res = sql("SELECT * FROM {$prx}{$tbl} ORDER BY sort");
		while($row = mysql_fetch_array($res))
		{
			$id = $row["id"];
		?>
			<tr id="tr<?=$id?>">
				<td><?=$row["html"]?></td>
				<td><?=nl2br($row["note"])?></td>
                <td><?=$row['position'] == "top" ? "вверху" : "внизу"?></td>
				<td><?=lnkAction()?></td>
			</tr>
	<?	}	?>
	</table>
<?
}
$content = ob_get_clean();

require("template.php");
?>

