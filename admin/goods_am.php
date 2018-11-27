<?
require('inc/common.php');
$tbl = "goods_am";
$aks = @$_GET["aks"];
$title = ($aks ? "Аксессуары" : "Модификации")." &raquo; Редактирование";
$id = (int)@$_GET['id'];
$id_goods = (int)@$_GET['id_goods'];

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "saveall":
			foreach($_POST["id"] as $id=>$none)
				foreach(array("yml", "hide", "nalich") as $key)
				{
					$$key = @$_POST[$key][$id];
					update($tbl, "{$key}='{$$key}'", $id);
				}
			?><script>top.topBack(true);</script><?
			break;

		case "save":
			foreach($_POST as $key=>$val)
				$$key = clean($val);
			
			$set = "isgroup='{$isgroup}', id_parent='{$id_parent}', nalich='{$nalich}', id_goods='{$id_goods}', kod='{$kod}', name='{$name}', 
						aks='{$aks}', yml='{$yml}', hide='{$hide}', text='{$text}', price='{$price}', valuta='{$valuta}'";
			$id = update($tbl, $set, $id);
			
			upfile("../uploads/{$tbl}/{$id}.jpg", $_FILES["file"], @$_POST["del_file"]);
			
			updateOnlinePrice();
			
			?><script>top.location.href = "?id=<?=$id?>&id_goods=<?=$id_goods?>&aks=<?=$aks?>&rand=<?=rand()?>";</script><?
			break;
	
		case "del":
			update($tbl, "", $id);
			sql("DELETE FROM {$prx}{$tbl} WHERE id_parent='{$id}'");
			@unlink("../uploads/{$tbl}/{$id}.jpg");
			?><script>top.topReload();</script><?
			break;

		case "moveup":
			$move = "up";
		case "movedown":
			moveSort((@$move ? "up" : "down"), $tbl, $id, "aks,id_goods,id_parent");
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
		<form action="?id=<?=$id?>&action=save&id_goods=<?=$id_goods?>&aks=<?=$aks?>" method="post" enctype="multipart/form-data" target="ajax">
			<table class="red" style="width:600px;">
			<?	if((int)@$_GET["isgroup"])
				{	?>
					<tr>
						<th>Название</th>
						<td>
							<input name="name" type="text" value="<?=$row['name']?>">
							<input type="hidden" value="1" name="isgroup">
						</td>
					</tr>
			<?	}
				else
				{	?>
					<tr>
						<th>Группа</th>
						<td><?=dll("SELECT id,name FROM {$prx}{$tbl} WHERE id_goods='{$id_goods}' AND aks='{$aks}' AND isgroup=1 ORDER BY sort", "name='id_parent'", $row["id_parent"], "")?></td>
					</tr>
					<tr>
						<th>Код</th>
						<td><input name="kod" type="text" value="<?=$row['kod']?>"></td>
					</tr>
					<tr>
						<th>Название</th>
						<td><input name="name" type="text" value="<?=$row['name']?>"></td>
					</tr>
					<tr>
						<th>Изображение</th>
						<td><?=fileUpload("/uploads/{$tbl}/{$id}.jpg", "name='file' style='width:80%'")?></td>
					</tr>
					<tr>
						<th>Описание</th>
						<td><?=getFck("text",$row['text'],"Basic","100%",140)?></td>
					</tr>
					<tr>
						<th>Цена</th>
						<td>
							<input name="price" value="<?=$row["price"]?>" style="width:100px;"> 
							<?=dllEnum("SHOW COLUMNS FROM {$prx}{$tbl} LIKE 'valuta'", "name='valuta' style='width:auto;'", $row["valuta"])?>
						</td>
					</tr>
					<tr>
						<th>В наличии</th>
						<td><input type="checkbox" value="1" name="nalich" <?=($row["nalich"] ? "checked" : "")?>></td>
						<td style="width:1%;"><img src="img/help.gif" title="Только для модификаций" onClick="alert(this.title)" alt="[?]" class="hand"></td>
					</tr>
					<!--<tr>
						<th>Выгружать в YML</th>
						<td><input type="checkbox" value="1" name="yml" <?=($row["yml"] ? "checked" : "")?>></td>
					</tr>-->
			<?	}	?>
				<tr>
					<th>Скрыть</th>
					<td><input type="checkbox" value="1" name="hide" <?=($row["hide"] ? "checked" : "")?>></td>
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
		<a href="?id=0<?="&id_goods={$id_goods}&aks={$aks}"?>&isgroup=1&red"><img src="img/add16.gif" alt="+" hspace="4" title="добавить группу" align="absmiddle">добавить группу</a> &nbsp; 
		<?=lnkAction("Add", "&id_goods={$id_goods}&aks={$aks}")?>
		<form action="?action=saveall" target="ajax" method="post" id="frmContent">
			<table class="content">
				<tr>
					<th>Изображение</th>
					<th>Код</th>
					<th>Название</th>
					<th>Цена</th>
					<th>В наличии</th>
					<!--<th style="text-align:center;">Выгружать<br>в YML</th>-->
					<th>Скрыть</th>
					<th></th>
				</tr>
			<? function showRow($row)
				{
					global $tbl, $id_goods, $aks, $id;
					ob_start();
				?>
					<tr id="tr<?=$id?>">
					<?	if($row["isgroup"])
						{	?>
							<td colspan="4"><b><?=$row["name"]?></b></td>
					<?	}
						else
						{	?>
							<td align="center">
								<a name="<?=$id?>"></a>
								<a href="/uploads/<?=$tbl?>/<?=$id?>.jpg" target="my" onClick="openWindow(800,600)">
									<img src="/uploads/<?=$tbl?>/-x50/<?=$id?>.jpg" title="увеличить">
								</a>
							</td>
							<td><?=$row["kod"]?></td>
							<td><?=$row["name"]?></td>
							<td><?=number_format($row["price"],2,","," ")?> <?=$row["valuta"]?></td>
							<td align="center">
								<input name="nalich[<?=$id?>]" type="checkbox" <?=($row["nalich"] ? "checked" : "")?> onClick="get('frmContent').submit();" value="1">
							</td>
							<!--<td align="center">
								<input name="yml[<?=$id?>]" type="checkbox" <?=($row["yml"] ? "checked" : "")?> onClick="get(frmContent').submit();" value="1">
							</td>-->
					<?	}	?>
						<td align="center">
							<input type="hidden" name="id[<?=$id?>]">
							<input name="hide[<?=$id?>]" type="checkbox" <?=($row["hide"] ? "checked" : "")?> onClick="get('frmContent').submit();" value="1">
						</td>
						<td nowrap><?=lnkAction("Up,Down,Red,Del", "&id_goods={$id_goods}&aks={$aks}&isgroup={$row['isgroup']}")?></td>
					</tr>
				<?	
					return ob_get_clean();
				}
			
				$res = sql("SELECT * FROM {$prx}{$tbl} WHERE id_goods='{$id_goods}' AND aks='{$aks}' AND isgroup=0 AND id_parent=0 ORDER BY sort");
				while($row = mysql_fetch_array($res))
				{
					$id = $row["id"];
					echo showRow($row);
				}	
				
				$res = sql("SELECT * FROM {$prx}{$tbl} WHERE id_goods='{$id_goods}' AND aks='{$aks}' AND isgroup=1 ORDER BY sort");
				while($row = mysql_fetch_array($res))
				{
					$id = $row["id"];
					echo showRow($row);

					$res1 = sql("SELECT * FROM {$prx}{$tbl} WHERE id_parent='{$id}' ORDER BY sort");
					while($row1 = mysql_fetch_array($res1))
					{
						$id = $row1["id"];
						echo showRow($row1);
					}
				}	
			?>
			</table>
		</form>
<?	}	?>
</div>
<?
$content = ob_get_clean();

require("tpl_clean.php");
?>

