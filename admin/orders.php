<?
require('inc/common.php');
$tbl = "orders";
$rubric = "������";
$id = (int)@$_GET['id'];

$sqlmain = "SELECT * FROM {$prx}{$tbl} ORDER BY status, date DESC";
$k = 40;

// -------------------����������----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "saveall":
			foreach($_POST["status"] as $id=>$status)
				update($tbl, "status='{$status}'", $id);
			?><script>top.topBack(true);</script><?
			break;

		case "save":
			foreach($_POST as $key=>$val)
				$$key = clean($val);
			
			update($tbl, "status='{$status}', notes='{$notes}'", $id);

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
// ------------------��������������--------------------
if(isset($_GET["red"]))
{
	$rubric .= " &raquo; ".($id ? "��������������" : "����������");
	$row = getRow("SELECT * FROM {$prx}{$tbl} WHERE id='{$id}'");
?>
	<a name="red"></a>
	<form action="?id=<?=$id?>&action=save" method="post" enctype="multipart/form-data" target="ajax">
		<table class="red" width="600">
			<tr>
				<th>����� ������</th>
				<td><?=$row['id']?></td>
			</tr>
            <tr>
				<th>����</th>
				<td><?=date("d.m.Y, H:i:s", strtotime($row['date']))?></td>
			</tr>
			<tr>
				<th>������������</th>
				<td><?=$row["user_info"]?></td>
			</tr>
			<tr>
				<th>�����</th>
				<td><?=$row["order_info"]?></td>
			</tr>
			<tr>
				<th>������</th>
                <?php if($row["cancel"]){ ?>
                    <td>������� ��������</td>
                <?php } else{ ?>
				    <td><?=dllEnum("SHOW COLUMNS FROM {$prx}{$tbl} LIKE 'status'", "name='status' style='width:auto;'", $row['status'])?></td>
                <?php } ?>
			</tr>
			<tr>
				<th>����������</th>
				<td><textarea name="notes"><?=$row["notes"]?></textarea></td>
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
{	?>
	<form action="?action=saveall" target="ajax" method="post">
		<table class="content 1">
			<tr>
				<th>�</th>
				<th>����</th>
				<th>�����</th>
				<th>������</th>
				<th></th>
			</tr>
		<? 
			$arr_color = array("�����"=>"#FFEAEA", "� ���������"=>"#EAFFEF", "��������"=>"#F4F4F4");
			$p = @$_GET['p'] ? $_GET['p'] : 1;
			$sql = $sqlmain." LIMIT ".($p-1)*$k.", {$k}";
			$res = mysql_query($sql);
			while($row = mysql_fetch_array($res))
			{
				$id = $row["id"];
			?>
				<tr id="tr<?=$id?>" bgcolor="<?=$arr_color[$row["status"]]?>">
					<td style="text-align:center;"><b><?=$row["id"]?></b></td>
					<td><a name="<?=$id?>"></a><?=date("d.m.Y", strtotime($row["date"]))?></td>
					<td><?=$row["order_info"]?></td>
					<td><?=dllEnum("SHOW COLUMNS FROM {$prx}{$tbl} LIKE 'status'", "name='status[{$id}]' style='width:auto;' onChange='forms[0].submit();'", $row['status'])?></td>
					<td><?=lnkAction("Red,Del")?></td>
				</tr>
		<?	}	?>
			<tr>
				<td colspan="5" align="center"><?=lnkPages($sqlmain, $p, $k)?></td>
			</tr>
			<tr>
				<th colspan="5" style="text-align:center"><?=btnAction("Update")?></th>
			</tr>
		</table>	
	</form>
<?
}
$content = ob_get_clean();

require("template.php");
?>