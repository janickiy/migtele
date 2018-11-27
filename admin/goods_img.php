<?
require('inc/common.php');
$tbl = "goods_img";
$title = "Изображения &raquo; Редактирование";
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
			
			$id = update($tbl, "id_goods='{$id_goods}', text='{$text}'", $id);
			
			upfile("../uploads/{$tbl}/{$id}.jpg", $_FILES["file"], @$_POST["del_file"]);
			
			?><script>top.location.href = "?id=<?=$id?>&id_goods=<?=$id_goods?>&rand=<?=rand()?>";</script><?
			break;
	
		case "del":
			update($tbl,'',$id);
			@unlink($_SERVER['DOCUMENT_ROOT']."/uploads/{$tbl}/{$id}.jpg");
			?><script>top.topReload();</script><?
			break;
		case "moveup":
			$move = "up";
		case "movedown":
			moveSort((isset($move) ? "up" : "down"), $tbl, $id, "id_goods");
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
			<table class="red" style="width:450px;">
				<tr>
					<th>Изображение</th>
					<td><?=fileUpload("/uploads/{$tbl}/{$id}.jpg", "name='file' style='width:70%'")?></td>
				</tr>
				<tr>
					<th>Поясняющий текст</th>
					<td><?=getFck("text",$row['text'],"Basic","100%",100)?></td>
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
		<?=lnkAction("Add", "&id_goods={$id_goods}")?>
		<table class="content">
			<tr>
				<th>Изображение</th>
				<th>Поясняющий текст</th>
				<th></th>
			</tr>
		<? 
			$res = sql("SELECT * FROM {$prx}{$tbl} WHERE id_goods='{$id_goods}' ORDER BY sort");
			while($row = mysql_fetch_array($res))
			{
				$id = $row["id"];
			?>
				<tr id="tr<?=$id?>">
					<td align="center">
						<a name="<?=$id?>"></a>
						<a href="/uploads/<?=$tbl?>/<?=$id?>.jpg" target="my" onClick="openWindow(800,600)">
							<img src="/uploads/<?=$tbl?>/-x50/<?=$id?>.jpg" title="увеличить">
						</a>
					</td>
					<td><?=$row["text"]?></td>
					<td><?=lnkAction("Up,Down,Red,Del", "&id_goods={$id_goods}")?></td>
				</tr>
		<?	}	?>
		</table>
<?	}	?>
</div>
<?
$content = ob_get_clean();

require("tpl_clean.php");
?>

