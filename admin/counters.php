<?
require('inc/common.php');
$tbl = "counters";
$rubric = "��������";
$id = (int)@$_GET['id'];

// -------------------����������----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "save":
			foreach($_POST as $key=>$val)
				$$key = clean($val);
	
			$id = update($tbl, "html='{$html}', note='{$note}', position='{$position}'", $id);

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
// ------------------��������������--------------------
if(isset($_GET["red"]))
{
	$rubric .= " &raquo; ".($id ? "��������������" : "����������");
	$row = getRow("SELECT * FROM {$prx}{$tbl} WHERE id='{$id}'");
?>
	<form action="?id=<?=$id?>&action=save" method="post" enctype="multipart/form-data" target="ajax">
		<table class="red" style="width:600px;">
			<tr>
				<th>��� ��������</th>
				<td><textarea name="html" rows="10"><?=$row['html']?></textarea></td>
			</tr>
			<tr>
				<th>����������</th>
				<td><textarea name="note" rows="5"><?=$row['note']?></textarea></td>
			</tr>
            <tr>
                <th>������������</th>
                <td>
                    <select name="position" id="">
                        <option value="bottom" <?=$row['position'] == 'bottom' ? 'selected' : ''?> >�����</option>
                        <option value="top" <?=$row['position'] == 'top' ? 'selected' : ''?>>������</option>
                    </select>
                </td>
            </tr>
			<tr>
				<td align="center" colspan="2"><?=btnAction()?></td>
			</tr>
		</table>
	</form>			  
<?
}

// -----------------��������-------------------
else
{
	echo lnkAction("Add");
?>
	<table class="content">
		<tr>
			<th>�������</th>
			<th>����������</th>
            <th>������������</th>
			<th></th>
		</tr>
	<? 
		$res = sql("SELECT * FROM {$prx}{$tbl} ORDER BY sort");
		while($row = mysql_fetch_array($res))
		{
			$id = $row["id"];
		?>
			<tr id="tr<?=$id?>">
				<td><?=$row["html"]?></td>
				<td><?=nl2br($row["note"])?></td>
                <td><?=$row['position'] == "top" ? "������" : "�����"?></td>
				<td><?=lnkAction()?></td>
			</tr>
	<?	}	?>
	</table>
<?
}
$content = ob_get_clean();

require("template.php");
?>

