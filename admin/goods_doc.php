<?
require('inc/common.php');
$tbl = "goods_doc";
$title = "Документация &raquo; Редактирование";
$id = (int)@$_GET['id'];
$id_goods = (int)@$_GET['id_goods'];

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "save":
			foreach($_POST as $key=>$val)
				$$key = clean($val);
			
			$file = upfile("../uploads/{$tbl}/".getField("SELECT file FROM {$prx}{$tbl} WHERE id='{$id}'"), $_FILES["file"], @$_POST["del_file"], true);
			$id = update($tbl, "id_parent='{$id_parent}', id_goods='{$id_goods}', name='{$name}', file='{$file}', ico='{$ico}'", $id);
			
			?><script>top.location.href = "?id=<?=$id?>&id_goods=<?=$id_goods?>&rand=<?=rand()?>";</script><?
			break;
	
		case "del":
			update($tbl, "", $id);
			@unlink("../uploads/{$tbl}/".getField("SELECT file FROM {$prx}{$tbl} WHERE id='{$id}'"));
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
			<table class="red" style="width:650px;">
			<?	if((int)@$_GET["isgroup"])
				{	?>
					<tr>
						<th>Название группы</th>
						<td><input type="text" name="name" value="<?=$row["name"]?>"></td>
					</tr>
			<?	} else { ?>
					<tr>
						<th>Группа</th>
						<td><?=dll("SELECT id,name FROM {$prx}{$tbl} WHERE id_goods='{$id_goods}' AND id_parent='0' ORDER BY sort", "name='id_parent'", $row["id_parent"])?></td>
					</tr>
					<tr>
						<th>Название</th>
						<td><?=getFck("name",$row['name'],"Basic","100%",100)?></td>
					</tr>
					<tr>
						<th>Тип ссылки</th>
						<td><?=dllEnum("SHOW COLUMNS FROM {$prx}{$tbl} LIKE 'ico'", "name='ico' style='width:auto;'", $row["ico"])?></td>
					</tr>
					<tr>
						<th>Файл</th>
						<td><?=fileUpload("/uploads/{$tbl}/{$row['file']}", "name='file' style='width:70%'")?></td>
					</tr>
			<?	}	?>
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
		<a href="?id=0&id_goods=<?=$id_goods?>&isgroup=1&red"><img src="img/add16.gif" alt="+" hspace="4" title="добавить группу" align="absmiddle">добавить группу</a> &nbsp; 
		<?=lnkAction("Add", "&id_goods={$id_goods}")?>
		<table class="content">
			<tr>
				<th>Документация</th>
				<th></th>
			</tr>
		<? 
			$res = sql("SELECT id, name FROM {$prx}{$tbl} WHERE id_goods='{$id_goods}' AND id_parent='0' ORDER BY sort");
			while($row = mysql_fetch_array($res))
			{
				$id = $row["id"];
			?>
				<tr id="tr<?=$id?>">
					<td><a name="<?=$id?>"></a><b><?=$row["name"]?></b></td>
					<td><?=lnkAction("Up,Down,Red,Del", "&id_goods={$id_goods}&isgroup=1")?></td>
				</tr>
			<?	$res1 = sql("SELECT id, name, file FROM {$prx}{$tbl} WHERE id_parent='{$row['id']}' ORDER BY sort");
				while($row1 = mysql_fetch_array($res1))
				{	
					$id = $row1["id"];
				?>
					<tr id="tr<?=$id?>">
						<td style="padding-left:30px;">
							<a name="<?=$id?>"></a>
						<?	echo file_exists("../uploads/{$tbl}/{$row1['file']}") && !is_dir("../uploads/{$tbl}/{$row1['file']}")
								? "<a href='/uploads/{$tbl}/{$row1['file']}'>{$row1['name']}</a>"
								: $row1['name'];	?>
						</td>
						<td><?=lnkAction("Up,Down,Red,Del", "&id_goods={$id_goods}&id_parent={$row1['id_parent']}")?></td>
					</tr>
			<?	}
			}	?>
		</table>
<?	}	?>
</div>
<?
$content = ob_get_clean();

require("tpl_clean.php");
?>

