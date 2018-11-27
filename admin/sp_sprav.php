<?
require('inc/common.php');
$tbl = "sp_sprav";
$rubric = "Справочник";
$id = (int)@$_GET['id'];

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "save":
			foreach($_POST as $key=>$val)
				$$key = clean($val);
	
			if($id)
				update($tbl, "name='{$name}'", $id);
			else
				if($arr = explode("\r\n", $name))
					foreach($arr as $name)
						if($name)
							$id = update($tbl, "name='{$name}'");

			?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
			break;
	
		case "del":
			update($tbl, "", $id);
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
?>
	<form action="?id=<?=$id?>&action=save" method="post" enctype="multipart/form-data" target="ajax">
		<table class="red" style="width:600px;">
		<? if($id) {	?>
				<tr>
					<th>Название</th>
					<td style="width:70%"><input name="name" type="text" value="<?=$row['name']?>"></td>
				</tr>
		<?	} else {	?>
				<tr>
					<th style="white-space:normal;">
						Название
						<div style="font-weight:normal;">для добавления сразу несколько записей, напишите их через Enter</div>
					</th>
					<td style="width:70%"><textarea name="name" rows="10"></textarea></td>
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
{
	echo lnkAction("Add");
?>
	<table class="content">
		<tr>
			<th>Название</th>
			<th></th>
		</tr>
	<? 
		$res = sql("SELECT id, name FROM {$prx}{$tbl} ORDER BY sort");
		while($row = mysql_fetch_array($res))
		{
			$id = $row["id"];
		?>
			<tr id="tr<?=$id?>">
				<td><?=$row["name"]?></td>
				<td><?=lnkAction()?></td>
			</tr>
	<?	}	?>
	</table>
<?
}
$content = ob_get_clean();

require("template.php");
?>