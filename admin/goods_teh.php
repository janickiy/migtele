<?
require('inc/common.php');
$tbl = "goods_teh";
$title = "Техн.характеристики &raquo; Редактирование";
$id = (int)@$_GET['id'];
$id_goods = (int)@$_GET['id_goods'];

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "saveall":
			if(@$_POST['btnAddBlock'])
			{
				$id = update($tbl, "id_goods='{$id_goods}'");
				update($tbl, "id_goods='{$id_goods}', id_parent='{$id}'");
			}
			foreach((array)@$_POST['name'] as $id=>$name)
			{
				$name = clean($name);
				$text = clean($_POST['text'][$id]);
				$id_parent = $_POST['id_parent'][$id];
				update($tbl, "id_goods='{$id_goods}', id_parent='{$id_parent}', name='{$name}', text='{$text}'", $id);
				
				if($_POST['btnAdd'][$id])
					update($tbl, "id_goods='{$id_goods}', id_parent='{$id}'");

				if($_POST['btnDel'][$id])
				{
					update($tbl, "", $id);
					sql("DELETE FROM {$prx}{$tbl} WHERE id_parent='{$id}'");
				}					
			}
			?><script>top.topReload();</script><?
			break;
		
		case "save":
			foreach($_POST as $key=>$val)
				$$key = clean($val);
			
			$id = update($tbl, "id_goods='{$id_goods}', id_parent='{$id_parent}', name='{$name}', text='{$text}'", $id);
			
			?><script>top.location.href = "?id=<?=$id?>&id_goods=<?=$id_goods?>&rand=<?=rand()?>";</script><?
			break;
	
		case "del":
			$ids = getTreeChilds("SELECT id FROM {$prx}{$tbl} WHERE id_parent = '%s'", $id);
			update($tbl, "", $ids);
			?><script>top.topReload();</script><?
			break;

		case "moveup":
			$move = "up";
		case "movedown":
			moveSort((@$move ? "up" : "down"), $tbl, $id, "id_goods,id_parent");
			?><script>top.topReload();</script><?
			break;			
	}
	exit;
}

ob_start();
?>
<div style="padding:20px;">
<?
	// ------------------РЕДАКТИРОВАНИЕ--------------------
	if(isset($_GET["red"]))
	{
		$rubric .= " &raquo; ".($id ? "Редактирование" : "Добавление");
		$row = getRow("SELECT * FROM {$prx}{$tbl} WHERE id='{$id}'");
	?>
		<form action="?id=<?=$id?>&action=save&id_goods=<?=$id_goods?>" method="post" enctype="multipart/form-data" target="ajax">
			<table class="red" style="width:700px;">
				<tr>
					<th>Блок</th>
					<td><?=dll("SELECT id,name FROM {$prx}{$tbl} WHERE id_parent='0' AND id_goods='{$id_goods}' ORDER BY sort", "name='id_parent'", $row["id_parent"], "")?></td>
				</tr>
				<tr>
					<th>Название</th>
					<td><?=getFck("name",$row['name'],"Basic","100%",100)?></td>
				</tr>
				<tr>
					<th>Текст</th>
					<td><?=getFck("text",$row['text'],"Basic","100%",250)?></td>
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
		<form action="?action=saveall&id_goods=<?=$id_goods?>" target="ajax" method="post">
			<input type="submit" value="Новый блок" name="btnAddBlock">
			<table class="red2" width="600" style="margin-top:5px;">
		<? 
			$sql = "SELECT * FROM {$prx}{$tbl} WHERE id_parent = '%s' AND id_goods='{$id_goods}' ORDER BY sort, id";
			$tree = getTree($sql);
			if($tree)
			foreach ($tree as $vetka) 
			{
				$row =  $vetka["row"];
				$id = $row["id"];
				
				if(!$row["id_parent"])
				{	?>
					<tr>
						<td style="border-top:1px solid #999; font-size:1px; padding-top:5px;" colspan="2">
							<?=getFck("name[{$id}]",$row['name'],"Basic","70%",50)?>
							<input type="submit" value="Удалить блок" name="btnDel[<?=$id?>]" style="width:auto;">
						</td>
					</tr>
			<?	} 
				else 
				{ ?>
					<tr>
						<th>Характеристика</th>
						<td><?=getFck("name[{$id}]",$row['name'],"Basic","100%",100)?></td>
						<td><input type="submit" value="Удалить" name="btnDel[<?=$id?>]" style="width:auto;"></td>
					</tr>
					<tr>
						<th>Текст</th>
						<td>
							<?=getFck("text[{$id}]",$row['text'],"Basic","100%",180)?>
							<input type="hidden" name="id_parent[<?=$id?>]" value="<?=$row['id_parent']?>">
						</td>
					</tr>
					<tr>
						<th></th>
						<td><input type="submit" value="Еще характеристика" name="btnAdd[<?=$row['id_parent']?>]" style="width:auto;"></td>
					</tr>
					<tr>
						<td style="border-top:1px dotted #999; font-size:1px;" colspan="2">&nbsp;</td>
					</tr>
			<?	}	?>
		<?	}	?>
			<tr>
				<td align="center" colspan="2"><?=btnAction("Save")?></td>
			</tr>
		</table>
	</form>
<?	}	?>
</div>
<?
$content = ob_get_clean();

require("tpl_clean.php");
?>

