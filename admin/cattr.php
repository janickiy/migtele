<?
require('inc/common.php');
$tbl = "cattr";
$rubric = "Разделы &raquo; Тип-Категория";
$top_menu = "catalog";
$id = (int)@$_GET['id'];

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "save":
			foreach($_POST as $key=>$val)
				$$key = clean($val);
	
			$set = "id_cattype='{$id_cattype}', id_catrazdel='{$id_catrazdel}', text='{$text}', title='{$title}', keywords='{$keywords}', description='{$description}'";
			$id = update($tbl, $set, $id);
			
			?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
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
	<form action="?id=<?=$id?>&action=save" method="post" enctype="multipart/form-data" target="ajax">
		<table class="red" width="1200">
			<tr>
				<th>Тип оборудования</th>
				<td><?=dll("SELECT id, name FROM {$prx}cattype ORDER BY sort", 'name="id_cattype"', $row['id_cattype'])?></td>
			</tr>
			<tr>
				<th>Категория</th>
				<td><?=dll("SELECT id, name FROM {$prx}catrazdel ORDER BY sort", 'name="id_catrazdel"', $row['id_catrazdel'])?></td>
			</tr>
			<tr>
				<th>Текст</th>
				<td>
					<textarea class="ckeditor-textarea" name="text"><?=$row['text']?></textarea>
				</td>
			</tr>
			<tr>
				<th>title</th>
				<td><input name="title" type="text" value="<?=$row['title']?>"></td>
			</tr>
			<tr>
				<th>keywords</th>
				<td><input name="keywords" type="text" value="<?=$row['keywords']?>"></td>
			</tr>
			<tr>
				<th>description</th>
				<td><textarea name="description"><?=$row['description']?></textarea></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><?=btnAction()?></td>
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
			<th>Тип - Категория</th>
			<th></th>
		</tr>
	<? $res = sql("SELECT tr.id, t.name AS cattype, r.name AS catrazdel
					  	FROM {$prx}cattr AS tr
							INNER JOIN {$prx}cattype AS t ON t.id=tr.id_cattype
							INNER JOIN {$prx}catrazdel AS r ON r.id=tr.id_catrazdel
						ORDER BY t.name, r.name");
		while($row = mysql_fetch_array($res))
		{
			$id = $row["id"];
	?>
			<tr id="tr<?=$id?>">
				<td>
					<a name="<?=$id?>"></a>
					<?=$row["cattype"]?> - <?=$row["catrazdel"]?>
				</td>
				<td><?=lnkAction("Red,Del")?></td>
			</tr>
	<?	}	?>
	</table>	
<?
}
$content = ob_get_clean();

require("template.php");
?>