<?
require('inc/common.php');
$tbl = "goods";
$rubric = "������ &raquo; XLS ������ (� ���������)";
$top_menu = "goods";
$id = (int)@$_GET['id'];

// -------------------����������----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		// ------------------ ������
		case "import":
			require_once('inc/excel_import.php');
			
			$id_cattmr = (int)$_POST['id_cattmr'];
			$id_catsr = (int)$_POST['id_catsr'];
			
			$rows = @excel_make_sheets($_FILES['file']['tmp_name']);

			foreach($rows as $line=>$row)
			{
				if(!$line) continue;
				
				$count['count']++;
				
				$ncol = $row[3] ? 4 : 3; // ���-�� �������
				
				if($ncol==3)
				{
					$arr = array('kod','name','text');
					list($kod,$name,$text) = $row;
				}
				else
				{
					$arr = array('kod','kod2','name','text');
					list($kod,$kod2,$name,$text) = $row;
				}
				foreach($arr as $val)
					$$val = clean($$val);
					
				if(!$kod) continue;
				
				$id = getField("SELECT id FROM {$prx}{$tbl} WHERE kod='{$kod}'");
				
				$set = "id_cattmr='{$id_cattmr}',
								id_catsr='{$id_catsr}',
								kod='{$kod}',
								kod2=".($ncol==4?"'{$kod2}'":'NULL').",
								name='{$name}',
								text1='{$text}',
								text2='{$text}',
								nalich=1,
								hide=1";

                $set .= $id ? ", updated_at = NOW()" : ", created_at = NOW()";

				if(!$id)
				{
					$link = makeUrl($name);
					if(getField("SELECT COUNT(*) FROM {$prx}{$tbl} WHERE link='{$link}'"))
						$link .= '_'.rand(1,100);
					$set .= ",link='{$link}'";
                    $set .= ", price_markup = ".rand(5, 15);
					
					if($id = update($tbl,$set,$id)) $count['insert']++;
					else $count['error']++;
				}
				
				
			}
			?><script>
				alert("������ ��������.\r\n\r\n�����: <?=(int)$count['count']?>\r\n���������: <?=(int)$count['insert']?>\r\n������: <?=(int)$count['error']?>");
				top.document.forms["frmContent"].reset();
				top.topBack(true);
			</script><?
			break;
		// ------------------- ������ �����
		case 'update_sr':
			if($id_cattmr = (int)$_GET['id_cattmr'])
				echo dll("SELECT id,name FROM {$prx}catsr WHERE id_cattmr={$id_cattmr} ORDER BY name",'name="id_catsr" style="width:auto"','','');
			
			break;
	}
	exit;
}

ob_start();
// ------------------��������������--------------------
{
	?>
  <script>
	function update_sr(id_cattmr)
	{
		jQuery.ajax({
			type: 'GET',
			url: 'goods_xls_prv.php',
			data: 'action=update_sr&id_cattmr='+id_cattmr,
			success: function(data){
				if(data) jQuery('#sr').html(data);
			}
		});
	}
	</script>
	<form action="?action=import" target="ajax" method="post" name="frmContent" enctype="multipart/form-data">
		<table class="content" width="450">
			<tr>
				<th>������������</th>
        <td>
        	<?
					$q = str_replace('ORDER BY tmr.sort','ORDER BY cattmr',sprintf($sqlCattmr,''));
					echo dll($q, 'name="id_cattmr" style="width:auto;" onChange="update_sr(this.value)"','','');
					?>
        </td>
			</tr>
      <tr>
				<th>�����</th>
        <td id="sr"></td>
			</tr>
			<tr>
      	<th>����:</th>
				<td><input type="file" name="file"></td>
			</tr>
      <tr>
				<td colspan="2" align="right"><?=btnAction("Save", "���������")?></td>
			</tr>
      <tr>
      	<td colspan="2">
					<b>������ �����:</b><br>
          <i>��� 1, ��������, ��������</i>
          <br /><b>����:</b><br>
          <i>��� 1, ��� 2, ��������, ��������</i>
				</td>
			</tr>
		</table>	
	</form>
	<?
}
$content = ob_get_clean();
$tbl .= "_xls_prv";
require("template.php");
?>