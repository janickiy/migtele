<?
require('inc/common.php');
$tbl = "feature";
$rubric = "Типы оборудования &raquo; Характеристики для подбора товаров";
$top_menu = "cattype";
$id = (int)@$_GET['id'];

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "saveall":
			foreach($_POST["id"] as $id=>$none)
			{
				foreach(array("multi") as $key)
				{
					$$key = @$_POST[$key][$id];
					update($tbl, "{$key}='{$$key}'", $id);
				}
				
				// 
				update($tbl,"to_like=0",$id);
			}
			foreach($_POST['to_like'] as $k=>$v)
				update($tbl,"to_like=1",$k);	
			
			?><script>top.topBack(true);</script><?				
			break;
			
		case "save":
			foreach($_POST as $key=>$v)
				$$key = clean($v);
			
			$set = "id_cattype='{$id_cattype}',name='{$name}',multi='{$multi}',text='{$text}',val='{$val}'";
			$id = update($tbl, $set, $id);

			?><script>top.location.href = "?id_cattype=<?=$id_cattype?>&id=<?=$id?>&rand=<?=rand()?>";</script><?
			break;
	
		case "del":
			update($tbl, "", $id);
			?><script>top.topReload();</script><?
			break;

		case "moveup":
			$move = "up";
		case "movedown":
			moveSort((@$move ? "up" : "down"), $tbl, $id, "id_cattype");
			?><script>top.topReload();</script><?
			break;			
	}
	exit;
}

ob_start();
// ------------------РЕДАКТИРОВАНИЕ--------------------
if(isset($_GET["red"]))
{
	$row = getRow("SELECT * FROM {$prx}{$tbl} WHERE id='{$id}'");
	$rubric .= " &raquo; ".($id ? "Редактирование" : "Добавление");
	if($id)
		$row["id_cattype"] = (int)@$_GET["id_cattype"];
?>
	<form action="?id=<?=$id?>&action=save" method="post" enctype="multipart/form-data" target="ajax">
		<table class="red" width="650">
			<tr>
				<th>Тип оборудования</th>
				<td><?=dll("SELECT id, name FROM {$prx}cattype ORDER BY sort", 'name="id_cattype" style="width:auto;"', $row["id_cattype"])?></td>
			</tr>
			<tr>
				<th>Название</th>
				<td><input name="name" type="text" value="<?=$row['name']?>"></td>
			</tr>
			<tr>
				<th>Варианты значений<br>(через Enter)</th>
				<td><textarea name="val" rows="5"><?=$row['val']?></textarea></td>
			</tr>
			<tr>
				<th>Множественный выбор<br>при подборе</th>
				<td><input name="multi" type="checkbox" <?=$row['multi'] ? "checked" : ""?> style="width:auto;" value="1"></td>
			</tr>
			<tr>
				<th>Поясняющий текст</th>
				<td><?=getFck("text",$row['text'],"Medium","100%",200)?></td>
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
	$id_cattype = (int)@$_GET["id_cattype"];
?>
	<form>
		<table class="content">
			<tr>
				<th>Тип оборудования</th>
				<th><?=dll("SELECT id,name FROM {$prx}cattype ORDER BY sort", 'name="id_cattype" style="width:auto"', $id_cattype, "")?></th>
			</tr>
			<tr>
				<th colspan="2" style="text-align:center;"><?=btnAction("Save", "Открыть")?></th>
			</tr>
		</table>
	</form>	
	<br>
	<?=lnkAction("Add","&id_cattype={$id_cattype}")?>
	<form action="?action=saveall" target="ajax" method="post">
		<table class="content">
			<tr>
				<th>Название</th>
				<th>Значения</th>
				<th>Множественный выбор</th>
                <th>Для выбора подобных товаров</th>
				<th>Поясняющий текст</th>
				<th></th>
			</tr>
		<? 
			$res = sql("SELECT * FROM {$prx}{$tbl} WHERE id_cattype='{$id_cattype}' ORDER BY sort");
			while($row = mysql_fetch_array($res))
			{
				$id = $row["id"];
			?>
				<tr id="tr<?=$id?>">
					<td><b><?=$row["name"]?></b></td>
					<td><?=nl2br($row["val"])?></td>
					<td align="center">
						<input type="hidden" name="id[<?=$id?>]">
						<input name="multi[<?=$id?>]" type="checkbox" <?=($row["multi"] ? "checked" : "")?> onClick="showLoad();this.form.submit();" value="1">
					</td>
                    <td align="center"><input type="checkbox" name="to_like[<?=$row['id']?>]"<?=$row['to_like']?' checked':''?> onClick="showLoad();this.form.submit();"></td>
					<td><?=$row["text"]?></td>
					<td nowrap><?=lnkAction()?></td>
				</tr>
		<?	}	?>
		</table>	
	</form>
<?
}
$content = ob_get_clean();

require("template.php");
?>