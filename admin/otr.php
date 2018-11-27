<?
require('inc/common.php');
$tbl = 'otr';
$rubric = 'Отрасли оборудования';
$id = (int)@$_GET['id'];

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case 'save':
			foreach($_POST as $key=>$val)
				$$key = clean($val);
			
			$set = "id_gr='{$id_gr}' ,text='{$text}', title='{$title}', keywords='{$keywords}', description='{$description}'";
			if(getField("SELECT name FROM {$prx}{$tbl} WHERE id='{$id}'")!='Средства связи')
				$set .= ", name='{$name}'";
			$id = update($tbl, $set, $id);
			?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
			break;
		// ----------------- обновление статуса
		case 'status':
			if(getField("SELECT name FROM {$prx}{$tbl} WHERE id='{$id}'")!='Средства связи')
				update_flag($tbl,'status',$id);
			?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
		break;
		case 'moveup':
			$move = "up";
		case 'movedown':
			moveSort((@$move ? "up" : "down"), $tbl, $id);
			?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
			break;
		case 'del':
			if(getField("SELECT name FROM {$prx}{$tbl} WHERE id='{$id}'")!='Средства связи')
			{
				sql("UPDATE {$prx}cattype SET id_otr='{$id}'");
				update($tbl,'',$id);
			}
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
	$gl = $row['name']=='Средства связи' ? true : false;

	?>
	<form action="?id=<?=$id?>&action=save" method="post" target="ajax">
		<table class="red" width="80%">
			<tr>
				<th>Группа</th>
				<td><?=dll("SELECT id,name FROM {$prx}gr ORDER BY sort,id", 'name="id_gr" style="width:auto;"',$row['id_gr'],array('0','-- отсутствует --'))?></td>
			</tr>
      <tr>
				<th>Название</th>
				<td><input name="name" type="text" value="<?=$row['name']?>"<?=$gl?' readonly':''?>></td>
			</tr>
      <tr>
				<th>Текст</th>
		  		<td><textarea class="ckeditor-textarea" name="text"><?=$row['text']?></textarea></td>
<!--				<td>--><?//=getFck("text",$row['text'],"Medium","100%",300)?><!--</td>-->
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
	?>
  <?=lnkAction("Add", "")?>
	<table class="content">
		<tr>
    	<th>Название</th>
			<th>Ссылка</th>
      <th>Статус</th>
			<th></th>
		</tr>
		<? 
		$res = sql("SELECT * FROM {$prx}{$tbl} ORDER BY sort");
		while($row = mysql_fetch_array($res))
		{
			$id = $row["id"];
			$gl = $row['name']=='Средства связи' ? true : false;
			?>
			<tr id="tr<?=$id?>">
				<td style="font-weight:bold;">
					<a name="<?=$id?>"></a><span class="st_g">&raquo;</span> <?=$row["name"]?>
				</td>
				<td>
        	<? $link = $gl ? '/' : "/otrasl{$id}/"; ?>          
					<a href="<?=$link?>" target="_blank"><?=$link?></a>
        </td>
				<td align="center"><?=$gl?'':btn_flag($row['status'],$id,'?action=status&id=')?></td>
        <td><?=$gl?lnkAction('Up,Down,Red'):lnkAction('Up,Down,Red,Del')?></td>
			</tr>
			<?	
		}	
		?>
	</table>	
	<?
}
$content = ob_get_clean();

require("template.php");
?>