<?
require('inc/common.php');
$top_menu = "price";
$tbl = "price";
$rubric = "Прайс-листы &raquo; On-line прайсы";
$id = (int)@$_GET['id'];

$p = @$_GET['p'] ? $_GET['p'] : 1;
$k = 40;

$id_catmaker = (int)@$_GET['id_catmaker'];
$razd = (int)@$_GET['razd']; // разделитель
$good = (int)@$_GET['good']; // добавить товарную позицию

$sqlmain = "SELECT *	FROM {$prx}{$tbl}	WHERE id_catmaker='{$id_catmaker}' ORDER BY sort, id";

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "save":
			foreach($_POST as $key=>$val)
				$$key = clean($val);
			
			if($good)
			{
				$res = sql("SELECT id,price,valuta FROM {$prx}goods WHERE kod='{$kod}' ORDER BY sort");
				while($row = mysql_fetch_array($res))
				{
					$res1 = sql("SELECT kod,price,valuta FROM {$prx}goods_am WHERE isgroup=0 AND id_goods='{$row['id']}' AND aks=0 ORDER BY sort");
					if(mysql_num_rows($res1))
						while($row1 = mysql_fetch_assoc($res1))
							$id = update($tbl, "id_catmaker='{$id_catmaker}', kod='{$row1['kod']}', price='{$row1['price']}', valuta='{$row1['valuta']}'");
					else
						$id = update($tbl, "id_catmaker='{$id_catmaker}', kod='{$kod}', price='{$row['price']}', valuta='{$row['valuta']}'");
				}
			}
			else
				$id = update($tbl, "id_catmaker='{$id_catmaker}', kod='{$kod}', price='{$price}', valuta='{$valuta}', text='{$text}', razd='{$razd}'", $id);

			$p = getPage($sqlmain, $id, $k);
			?><script>top.location.href = "?id_catmaker=<?=$id_catmaker?>&id=<?=$id?>&p=<?=$p?>&rand=<?=rand()?>";</script><?
			break;

		case "del":
			update($tbl, "", $id);
			?><script>top.topReload();</script><?
			break;

		case "delall":
			sql("DELETE FROM {$prx}{$tbl} WHERE id_catmaker='{$id_catmaker}'");
			?><script>top.topReload();</script><?
			break;

		case "moveup":
			$move = "up";
		case "movedown":
			moveSort((@$move ? "up" : "down"), $tbl, $id, "id_catmaker");
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
	if($id)
		$id_catmaker = $row['id_catmaker'];
?>
	<form action="?id=<?=$id?>&id_catmaker=<?=$id_catmaker?>&razd=<?=$razd?>&good=<?=$good?>&action=save" method="post" enctype="multipart/form-data" target="ajax">
		<table class="red" width="500">
			<tr>
				<th>Вендор</th>
				<td><?=dll("SELECT id,name FROM {$prx}catmaker ORDER BY sort", 'name="id_catmaker"', $id_catmaker)?></td>
			</tr>
		<?	if($razd) {	 ?>
				<tr>
					<th>Текст</th>
					<td><textarea name="text"><?=$row["text"]?></textarea></td>
				</tr>
		<?	} elseif($good) { ?>
				<tr>
					<th>Код товара</th>
					<td><input name="kod" type="text" value="<?=$row['kod']?>"></td>
				</tr>
		<?	} else {	?>
				<tr>
					<th>Код товара</th>
					<td><input name="kod" type="text" value="<?=$row['kod']?>"></td>
				</tr>
				<tr>
					<th>Описание</th>
					<td><textarea name="text"><?=$row["text"]?></textarea></td>
				</tr>
				<tr>
					<th>Цена</th>
					<td>
						<input name="price" value="<?=$row["price"]?>" style="width:100px;"> 
						<?=dllEnum("SHOW COLUMNS FROM {$prx}{$tbl} LIKE 'valuta'", "name='valuta' style='width:auto;'", $row["valuta"])?>
					</td>
				</tr>
		<?	}	?>
			<tr>
				<td colspan="2" align="center"><?=btnAction()?></td>
			</tr>
		</table>
	</form>			  
<?
}

// -----------------ПРОСМОТР-------------------
else
{	?>
	<form>
		<table class="content" width="422">
			<tr>
				<th>Вендор</th>
				<th width="100%"><?=dll("SELECT id,name FROM {$prx}catmaker ORDER BY sort", 'name="id_catmaker" style="width:100%"', $id_catmaker, "")?></th>
			</tr>
			<tr>
				<th colspan="2" style="text-align:center;"><?=btnAction("Save", "Открыть")?></th>
			</tr>
		</table>
	</form>
<?	
	if($id_catmaker)	
	{	?>
		<div style="margin:20px 0 10px 0;">
			<?=lnkAction("Add", "&id_catmaker={$id_catmaker}")?> &nbsp; 
			<a href="?id=0&id_catmaker=<?=$id_catmaker?>&razd=1&red"><img src="img/add16.gif" alt="+" hspace="4" align="absmiddle">добавить разделитель</a> &nbsp; 
			<a href="?id=0&id_catmaker=<?=$id_catmaker?>&good=1&red"><img src="img/add16.gif" alt="+" hspace="4" align="absmiddle">добавить товарную позицию</a> &nbsp; 
			<a href="javascript:toajax('?id_catmaker=<?=$id_catmaker?>&action=delall')" onClick="return sure();"><img src="img/del16.gif" hspace="4" alt="уд." align="absmiddle">удалить все</a>
		</div>
		<table class="content">
			<tr>
				<th>Код товара</th>
				<th>Описание</th>
				<th>Цена</th>
				<th></th>
			</tr>
		<? 
			$res = sql($sqlmain." LIMIT ".($p-1)*$k.", {$k}");
			while($row = mysql_fetch_array($res))
			{	
				$id = $row["id"];
			?>
				<tr id="tr<?=$id?>">
				<?	if($row['razd']) { ?>
						<td colspan="3"><b><?=nl2br($row["text"])?></b></td>
				<?	} else {	?>
						<td nowrap><a name="<?=$id?>"></a><?=$row["kod"]?></td>
						<td><?=nl2br($row["text"])?></td>
						<td align="right" nowrap><?=number_format($row["price"],0,","," ")?> <?=$row["valuta"]?></td>
				<?	}	?>
					<td><?=lnkAction("Up,Down,Red,Del", "&razd={$row['razd']}")?></td>
				</tr>
		<?	}	?>
			<tr>
				<td colspan="5" align="center"><?=lnkPages($sqlmain, $p, $k, "?p=%s&id_catmaker={$id_catmaker}")?></td>
			</tr>
		</table>	
<?	}
}
$content = ob_get_clean();

require("template.php");
?>