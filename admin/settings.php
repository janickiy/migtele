<?
require('inc/common.php');
$tbl = "settings";
$rubric = "Íàñòðîéêè";

// -------------------ÑÎÕÐÀÍÅÍÈÅ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "save":
			foreach($_POST as $id=>$value)
			{
                if($id == 'password' && !$value)
                    continue;

			    if($id == 'password')
			        $value = md5($value);

				$value = clean($value);
				update($tbl, "value='{$value}'", $id);
			}

			foreach($_FILES as $id=>$file)
			{
				$value = upfile("../uploads/{$tbl}/".set($id), $file, @$_POST["del_{$id}"], true);
				update($tbl, "value='{$value}'", $id);
			}

			?><script>top.topReload();</script><?
			break;
	}
	exit;
}

ob_start();
// -----------------ÐÅÄÀÊÒÈÐÎÂÀÍÈÅ-------------------
?>
	<form action="?action=save" method="post" enctype="multipart/form-data" target="ajax">

        <input type="text" style="display:none">
        <input type="password" name="password" style="display:none">

		<table class="red" width="80%">
		<?	$res = sql("SELECT * FROM {$prx}{$tbl} WHERE hide='0' ORDER BY sort");
			while($row = mysql_fetch_array($res))	
			{	?>
				<tr>
					<th><?=$row['name']?></th>
					<td>
					<?	switch($row['type'])
						{
							case "text":	?>
								<input name="<?=$row['id']?>" type="text" value="<?=$row['value']?>">					
						<?		break;
		
							case "password":	?>
								<input name="<?=$row['id']?>" type="password" value="">
						<?		break;
		
							case "checkbox":	?>
								<input name="<?=$row['id']?>" id="<?=$row['id']?>" type="hidden" value="<?=$row['value']?>">
								<input type="checkbox" <?=($row['value']=="true" ? "checked" : "")?> onClick="document.getElementById('<?=$row['id']?>').value=this.checked;" style="width:auto;">					
						<?		break;
		
							case "textarea":	?>
								<textarea name="<?=$row['id']?>"><?=$row['value']?></textarea>
						<?		break;
		
							case "fck":
								echo "<textarea class=\"ckeditor-textarea\" name=\"{$row['id']}\">{$row['value']}</textarea>";
//								echo getFck($row['id'],$row['value'],"Basic","100%",180);
								break;
		
							case "datetime":
							case "date":
								echo aInput($row['type'], "name='{$row['id']}'", $row['value']);	
								break;

							case "color":
								echo aInput("color", "name='{$row['id']}'", $row['value']);	
								break;

							case "file":
								echo fileUpload("/uploads/{$tbl}/{$row['value']}", "name='{$row['id']}' style='width:80%'");	
								break;
						}	?>
					</td>
				</tr>
		<?	}	?>		
			<tr>  
				<td colspan="2" align="center"><?=btnAction("Save")?></td>
			</tr>
		</table>
	</form>			  
<?
$content = ob_get_clean();

require("template.php");
?>