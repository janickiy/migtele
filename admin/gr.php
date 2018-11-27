<?
require('inc/common.php');
$tbl = 'gr';
$rubric = 'Группы оборудования';
$id = (int)@$_GET['id'];

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case 'save':
			foreach($_POST as $key=>$val)
				$$key = clean($val);
			$id = update($tbl,"name='{$name}'",$id);
			?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
			break;
		// ----------------- обновление статуса
		case 'status':
			if($id==1) exit;
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
			if($id==1) exit;
			sql("UPDATE {$prx}cattype SET id_otr='{$id}'");
			update($tbl,'',$id);
			?><script>top.topReload();</script><?
			break;
	}
	exit;
}

ob_start();
// ------------------РЕДАКТИРОВАНИЕ--------------------
if(isset($_GET["red"]))
{
	$rubric .= ' &raquo; '.($id ? 'Редактирование' : 'Добавление');
	$row = getRow("SELECT * FROM {$prx}{$tbl} WHERE id='{$id}'");
	?>
	<form action="?id=<?=$id?>&action=save" method="post" target="ajax">
  <table class="red" width="800">
    <tr>
      <th>Название</th>
      <td><input name="name" type="text" value="<?=$row['name']?>"></td>
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
      <th>Статус</th>
			<th></th>
		</tr>
		<? 
		$res = sql("SELECT * FROM {$prx}{$tbl} ORDER BY sort,id");
		while($row = mysql_fetch_array($res))
		{
			$id = $row['id'];
			?>
			<tr id="tr<?=$id?>">
				<td style="font-weight:bold;">
					<a name="<?=$id?>"></a><span class="st_g">&raquo;</span> <?=$row["name"]?>
				</td>
				<td align="center"><?=$id==1?'':btn_flag($row['status'],$id,'?action=status&id=')?></td>
        <td><?=$id==1?lnkAction('Up,Down,Red'):lnkAction('Up,Down,Red,Del')?></td>
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