<?
require('inc/common.php');
$tbl = "valuta";
$rubric = " ÛÒ˚ ‚‡Î˛Ú";
$id = (int)@$_GET['id'];

// -------------------—Œ’–¿Õ≈Õ»≈----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "save":
			foreach($_POST as $id=>$value)
			{
				$value = clean($value);
				update("settings", "value='{$value}'", $id);
			}
			?><script>top.topBack();</script><?
			break;
	}
	exit;
}

ob_start();
// ------------------–≈ƒ¿ “»–Œ¬¿Õ»≈--------------------
?>
	<form action="?id=<?=$id?>&action=save" method="post" enctype="multipart/form-data" target="ajax">
		<table class="red" style="width:400px;">
		<?	$res = sql("SELECT * FROM {$prx}settings WHERE id IN ('usd_up','eur_up') ORDER BY sort");
			while($row = mysql_fetch_array($res))	
			{	?>
				<tr>
					<th><?=$row['name']?></th>
					<td><input name="<?=$row['id']?>" type="text" value="<?=$row['value']?>"></td>
				</tr>
		<?	}	?>		
			<tr>
				<td align="center" colspan="2"><?=btnAction("Save,Reset")?></td>
			</tr>
		</table>
	</form>			  
	<br><br>
	<table class="content">
		<tr>
			<th>ƒ‡Ú‡</th>
			<th>USD</th>
			<th>EUR</th>
		</tr>
	<? 
		$res = sql("SELECT * FROM {$prx}{$tbl} ORDER BY date DESC LIMIT 30");
		while($row = mysql_fetch_array($res))
		{
			$id = $row["id"];
		?>
			<tr id="tr<?=$id?>">
				<td><?=date("d.m.Y", strtotime($row["date"]))?></td>
				<td><?=$row["usd"]?></td>
				<td><?=$row["eur"]?></td>
			</tr>
	<?	}	?>
	</table>
<?

$content = ob_get_clean();

require("template.php");
?>