<?
require('inc/common.php');
$tbl = "news";
$rubric = "Новости";
$id = (int)@$_GET['id'];

$sqlmain = "SELECT id,date,name FROM {$prx}{$tbl} ORDER BY date DESC";
$k = 40;

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "save":
			foreach($_POST as $key=>$val)
				$$key = clean($val);

			$date = formatDateTime($date.date(" H:i:s"));
			
			$set = "date='{$date}', name='{$name}', text1='{$text1}', text2='{$text2}'";
			$id = update($tbl, $set, $id);

			$p = getPage($sqlmain,$id,$k);
			?><script>top.location.href = "?p=<?=$p?>&id=<?=$id?>&rand=<?=rand()?>#<?=$id?>";</script><?
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
		<table class="red2" style="width:800px;">
			<tr>
				<th nowrap>Дата (дд.мм.гггг)</th>
				<td><?=aInput("Date", 'name="date" style="width:25%"', ($row['date']>0 ? date("d.m.Y", strtotime($row['date'])) : date("d.m.Y")))?></td>
			</tr>
			<tr>
				<th>Название</th>
				<td><input name="name" type="text" value="<?=$row['name']?>" style="width:50%"></td>
			</tr>
			<tr>
				<th>Текст</th>
				<td><textarea class="ckeditor-textarea" name="text1"><?=$row['text1']?></textarea></td>
<!--				<td>--><?//=getFck("text1",$row['text1'],"Basic","100%",180)?><!--</td>-->
			</tr>
			<tr>
				<th>Подробнее</th>
				<td><textarea class="ckeditor-textarea" name="text2"><?=$row['text2']?></textarea></td>
<!--				<td>--><?//=getFck("text2",$row['text2'],"Medium","100%",400)?><!--</td>-->
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
			<th>Дата</th>
			<th>Название</th>
			<th>Ссылка</th>
			<th></th>
		</tr>
	<? 
		$p = @$_GET['p'] ? $_GET['p'] : 1;
		$res = sql($sqlmain." LIMIT ".($p-1)*$k.", {$k}");
		while($row = mysql_fetch_array($res))
		{
			$id = $row["id"];
	?>
			<tr id="tr<?=$id?>">
				<td><a name="<?=$id?>"></a><?=date("d.m.Y", strtotime($row["date"]))?></td>
				<td><?=$row["name"]?></td>
				<td><a href="/<?=$tbl?>/<?=$id?>.htm">/<?=$tbl?>/<?=$id?>.htm</a></td>
				<td><?=lnkAction("Red,Del")?></td>
			</tr>
	<?	}	?>
		<tr>
			<td colspan="4" align="center"><?=lnkPages($sqlmain, $p, $k)?></td>
		</tr>
	</table>
<?
}
$content = ob_get_clean();

require("template.php");
?>