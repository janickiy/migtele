<?
require('inc/common.php');
$tbl = "catalog";
$rubric = "Каталог &raquo; Разделы";
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
	
			$set = "id_parent='{$id_parent}', name='{$name}', text='{$text}', title='{$title}', keywords='{$keywords}', description='{$description}'";
			$id = update($tbl, $set, $id);
			
			?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
			break;
	
		case "del":
			$ids = getTreeChilds("SELECT id FROM {$prx}{$tbl} WHERE id_parent = '%s'", $id);
			// проверка
			if(getField("SELECT count(*) as c FROM {$prx}goods WHERE id_catalog IN ({$ids})"))
				errorAlert("Сначала удалите все товары раздела каталога");

			update($tbl, "", $ids);
			?><script>top.topReload();</script><?
			break;
	
		case "moveup":
			$move = "up";
		case "movedown":
			moveSort((@$move ? "up" : "down"), $tbl, $id, "id_parent");
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
		<table class="red" width="800">
			<tr>
				<th>Расположение</th>
				<td><?=dllTree("SELECT id, name FROM {$prx}{$tbl} WHERE id_parent='%s' ORDER BY sort", 'name="id_parent" style="width:auto;"', $row['id_parent'], "", $id)?></td>
			</tr>
			<tr>
				<th>Название</th>
				<td><input name="name" type="text" value="<?=$row['name']?>"></td>
			</tr>
			<tr>
				<th>Текст</th>
				<td><?=getFck("text",$row['text'],"Medium","100%",300)?></td>
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
			<th>Раздел каталога</th>
			<th>Ссылка</th>
			<th></th>
		</tr>
	<? 
		$sql = "SELECT id,name FROM {$prx}{$tbl} WHERE id_parent = '%s' ORDER BY sort";
		$tree = getTree($sql);
		if($tree)
		foreach ($tree as $vetka) 
		{
			$row =  $vetka["row"];
			$id = $row["id"];
			$prefix = getPrefix($vetka["level"]);
	?>
			<tr id="tr<?=$id?>">
				<td <?=(!$vetka["level"] ? 'style="font-weight:bold;"' : "")?>>
					<a name="<?=$id?>"></a><span class="st_g"><?=$prefix?></span>
					<a href="goods.php?id_catalog=<?=$id?>"><?=$row["name"]?></a>
				</td>
				<td><a href="/<?=$tbl?>/<?=$id?>.htm">/<?=$tbl?>/<?=$id?>.htm</a></td>
				<td><?=lnkAction()?></td>
			</tr>
	<?	}	?>
	</table>	
<?
}
$content = ob_get_clean();

require("template.php");
?>