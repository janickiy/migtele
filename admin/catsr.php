<?
require('inc/common.php');
$tbl = "catsr";
$rubric = "Разделы &raquo; Серии";
$top_menu = "catalog";
$id = (int)@$_GET['id'];

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "saveall":
			foreach($_POST["id"] as $id=>$none)
				foreach(array("hide") as $key)
				{
					$$key = @$_POST[$key][$id];
					update($tbl, "{$key}='{$$key}'", $id);
				}
			?><script>top.topBack(true);</script><?
			break;

		case "save":
			foreach($_POST as $key=>$val)
				$$key = clean($val);
			
			$id_cattmr = getField("SELECT id FROM {$prx}cattmr WHERE id_cattype='{$id_cattype}' and id_catmaker='{$id_catmaker}' and id_catrazdel='{$id_catrazdel}'");
			if(!$id_cattmr) errorAlert('Не существует данной связки \"Тип-Вендор-Категория\"');
			
			$set = "id_cattmr='{$id_cattmr}',
							name='{$name}',
							text=".($text?"'{$text}'":"NULL").",
							hide='{$hide}',
							title=".($title?"'{$title}'":"NULL").",
							keywords=".($keywords?"'{$keywords}'":"NULL").",
							description=".($description?"'{$description}'":"NULL");
			$id = update($tbl, $set, $id);
			
			/*?><script>top.location.href = "?id=<?=$id?>&id_cattype=<?=$id_cattype?>&id_catmaker=<?=$id_catmaker?>&id_catrazdel=<?=$id_catrazdel?>&rand=<?=rand()?>";</script><?*/
			?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
			break;
	
		case "del":
			sql("UPDATE {$prx}goods SET id_catsr=0 WHERE id_catsr={$id}");
			update($tbl,'',$id);
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
	
	if($row)
	{
		if($tmr = getRow("SELECT id_cattype,id_catmaker,id_catrazdel FROM {$prx}cattmr WHERE id={$row['id_cattmr']}"))
		{
			foreach(array('id_cattype','id_catmaker','id_catrazdel') as $val)
				$$val = $tmr[$val];
		}
	}
	else
	{
		foreach(array('id_cattype','id_catmaker','id_catrazdel') as $val)
			$$val = (int)$_GET[$val];
	}
	
	?>
	<form action="?id=<?=$id?>&action=save" method="post" enctype="multipart/form-data" target="ajax">
		<table class="red" width="800">
      <tr>
				<th style="background-color:#dbdbdb">Тип оборудования</th>
				<td><?=dll("SELECT id, name FROM {$prx}cattype ORDER BY sort", 'name="id_cattype"', $id_cattype, '')?></td>
			</tr>
			<tr>
				<th style="background-color:#dbdbdb">Вендор</th>
				<td><?=dll("SELECT id, name FROM {$prx}catmaker ORDER BY sort", 'name="id_catmaker"', $id_catmaker, '')?></td>
			</tr>
			<tr>
				<th style="background-color:#dbdbdb">Категория</th>
				<td><?=dll("SELECT id, name FROM {$prx}catrazdel ORDER BY sort", 'name="id_catrazdel"', $id_catrazdel, '')?></td>
			</tr>
      <tr>
				<th>Название</th>
				<td><input name="name" type="text" value="<?=htmlspecialchars($row['name'])?>"></td>
			</tr>
			<tr>
				<th>Текст</th>
				<td><?=getFck("text",$row['text'],"Basic","100%",150)?></td>
			</tr>
			<tr>
				<th>Скрыть</th>
				<td><input name="hide" type="checkbox" <?=$row['hide'] ? "checked" : ""?> style="width:auto;" value="1"></td>
			</tr>
			<tr>
				<th>title</th>
				<td><input name="title" type="text" value="<?=htmlspecialchars($row['title'])?>"></td>
			</tr>
			<tr>
				<th>keywords</th>
				<td><input name="keywords" type="text" value="<?=htmlspecialchars($row['keywords'])?>"></td>
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
	foreach(array('id_cattype','id_catmaker','id_catrazdel') as $val)
		$$val = (int)$_GET[$val];
		
	?>
	<form>
		<table class="content">
			<tr>
				<th>Тип</th>
				<th>Вендор</th>
				<th>Категория</th>
			</tr>
			<tr>
				<th><?=dll("SELECT id,name FROM {$prx}cattype ORDER BY sort", 'name="id_cattype" style="width:auto"', $id_cattype, "")?></th>
				<th><?=dll("SELECT id,name FROM {$prx}catmaker ORDER BY sort", 'name="id_catmaker" style="width:auto"', $id_catmaker, "")?></th>
				<th><?=dll("SELECT id,name FROM {$prx}catrazdel ORDER BY sort", 'name="id_catrazdel" style="width:auto"', $id_catrazdel, "")?></th>
			</tr>
			<tr>
				<th colspan="3" style="text-align:center;"><?=btnAction("Save", "Показать")?></th>
			</tr>
		</table>
	</form>	
	<br>
  <?=lnkAction("Add","&id_cattype={$id_cattype}&id_catmaker={$id_catmaker}&id_catrazdel={$id_catrazdel}")?>
  <br>
	<form action="?action=saveall" target="ajax" method="post" id="frmContent">
		<table class="content">
			<tr>
				<th>Название</th>
				<th>Скрыть</th>
				<th></th>
			</tr>
			<? 
			$where = '';
			if($id_cattmr = getField("SELECT id FROM {$prx}cattmr WHERE id_cattype={$id_cattype} and id_catmaker={$id_catmaker} and id_catrazdel={$id_catrazdel}"))
				$where = " and id_cattmr='{$id_cattmr}'";
			elseif($id_cattype||$id_catmaker||$id_catrazdel)
				$where = '=0';
				
			$res = sql("SELECT * FROM {$prx}{$tbl} WHERE 1{$where} ORDER BY sort");
			while($row = mysql_fetch_array($res))
			{
				$id = $row["id"];
				?>
				<tr id="tr<?=$id?>">
					<td><a name="<?=$id?>"></a><a href="goods.php?id_cattmr=<?=$row['id_cattmr']?>&id_catsr=<?=$id?>"><?=$row["name"]?></a></td>
					<td align="center">
						<input type="hidden" name="id[<?=$id?>]">
						<input name="hide[<?=$id?>]" type="checkbox" <?=($row["hide"] ? "checked" : "")?> onClick="get('frmContent').submit();" value="1">
					</td>
					<td><?=lnkAction()?></td>
				</tr>
				<?
				}
			?>
		</table>	
	</form>
<?
}
$content = ob_get_clean();

require("template.php");
?>