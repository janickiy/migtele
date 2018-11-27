<?
require('inc/common.php');
require_once 'htmlpurifier/HTMLPurifier.auto.php';
$tbl = 'goods';
$rubric = "CSV ������ (�������� �������)";
$top_menu = 'goods';
$id = (int)@$_GET['id'];

$config = HTMLPurifier_Config::createDefault();
$config->set('Core.Encoding', 'cp1251');
$purifier = new HTMLPurifier($config);

// -------------------����������----------------------
if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case 'import':
			if(!$id_catmaker = (int)$_POST['maker']) errorAlert('�������� �����!');
			if(!$_FILES['file']['name']) errorAlert('�������� ���� �������');
			
			$q = "SELECT A.id FROM {$prx}goods A
						INNER JOIN {$prx}cattmr B ON A.id_cattmr=B.id
						INNER JOIN {$prx}catmaker C ON B.id_catmaker=C.id
						WHERE C.id={$id_catmaker}";
			$ids_good = getArr($q);
			if($ids_good) $ids_good = implode(',',$ids_good);
			else $ids_good = 0;
			
			// ������� ���� �����
			if(!$_SESSION['report']) $_SESSION['report'] = 'upload_'.mktime().'.csv';
			$log = fopen($_SERVER['DOCUMENT_ROOT'].'/tmp/'.$_SESSION['report'],'w');
			fwrite($log,"(1) ��� ������;(2) �������\n");
			
			$errors = 0;

			setlocale(LC_ALL, 'ru_RU.cp1251');
			
			$file = fopen($_FILES['file']['tmp_name'], 'r');
      $start = 1; 
      $i = 0;
			while($row = fgetcsv($file,100000,';')) 
			{
				if($i++>=$start)
				{
					$kod = clean($row[0]);
					$text2 = clean($row[1]);
					
					if(!$kod) { fwrite($log,"{$kod};��� ���� ������ � �����\n"); $errors++; continue; }					
					if(!$text2) { fwrite($log,"{$kod};��� �������� ������ � �����\n"); $errors++; continue; }
										
					$good = getRow("SELECT id,text2 FROM {$prx}goods WHERE id IN ({$ids_good}) and kod='{$kod}'");
					if(!$good) { fwrite($log,"{$kod};��� ���� ������ ���������� ������ �� �����\n"); $errors++; continue;	}
					if($good['text2']) { fwrite($log,"{$kod};����� ��� �������\n"); $errors++; }
					
					
					$clean_html = $purifier->purify($text2);
					update('goods',"text2='{$clean_html}'",$good['id']);
				}
			}
			fclose($file);
			
			// �������� ������ � ������� ��� ��������
			$r = mysql_query("SELECT kod,text2 FROM {$prx}goods WHERE text2=''");
			while($arr = @mysql_fetch_assoc($r))
			{
				fwrite($log,"{$arr['kod']};��� ������ ������ � �����, �� ����� ����������� �����\n");
				$errors++;
			}			
			fclose($log);
			
			?><script>
			alert("������ ��������.\r\n���������� �������: <?=$i-1?>");<?			
			if($errors)
			{
				?>alert("���������� ������.\r\n��������� �����.");<?
			}
			else
				@unlink($_SERVER['DOCUMENT_ROOT'].'/tmp/'.$_SESSION['report']);
			?>
      top.topReload();
      </script><?							
			break;
	}
	exit;
}

ob_start();
?>
<form action="?action=import" name="frm" target="ajax" method="post" enctype="multipart/form-data">
<table class="content" width="450">
  <tr>
    <td>�����</td>
    <td><?=dll("SELECT id,name FROM {$prx}catmaker ORDER BY name",'name="maker"')?></td>
  </tr>
  <tr>
    <td>����</td>
    <td><input type="file" name="file" style="width:100%"></td>
  </tr>
  <tr>
    <td></td>
    <td><?=btnAction('Save','���������')?></td>
  </tr>
  <tr>
    <td colspan="2">
      <b>����:</b><br>��� ������, ��������<br>
      (<i>��. <a href="inc/import.csv">�������</a></i>)
    </td>
  </tr>
  <?
	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/tmp/'.$_SESSION['report']))
	{
		?><tr><td colspan="2" align="right"><a href="/tmp/<?=$_SESSION['report']?>" target="_blank" style="color:#F60;"><b>�����</b></a></td></tr><?
	}
	?>
</table>	
</form>
<?
$content = ob_get_clean();
$tbl .= "_csv";
require("template.php");
?>