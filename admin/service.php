<?
require('inc/common.php');
$rubric = "Сервисные функции";

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "base":	// АРХИВ БД
			$file = "arhiv/".$_SERVER['SERVER_NAME'].".sql";
			$fh = fopen($file,"w");
			fwrite($fh, "#Site: {$_SERVER['SERVER_NAME']}\n");
			fwrite($fh, "#DataBase: {$mysql_conn['db']}\n");
			fwrite($fh, "#DateTime: ".date("d.m.Y H:i")."\n\n\n");
	
			$res = sql("SHOW tables FROM `{$mysql_conn['db']}`");
			while($row = mysql_fetch_row($res))
			{
				$tbl = $row[0];
				if(strpos($tbl, $prx)!==false)
				{
					fwrite($fh,"DROP TABLE IF EXISTS `{$tbl}`;\n");
					$tbl_create = sql("SHOW create table `{$tbl}`");
					$tbl_create = @mysql_result($tbl_create,0,'create table');
					fwrite($fh,"{$tbl_create};\n");
					$resf = sql("SELECT * FROM {$tbl}");
					$fld_cnt = mysql_num_fields($resf);
					while($rowf = mysql_fetch_row($resf))
					{
						$str='';
						for($i=0; $i<$fld_cnt; $i++) 
							$str.="'".clean($rowf[$i])."',";
						$str=substr($str,0,strlen($str)-1);
						fwrite($fh,"INSERT INTO {$tbl} VALUES({$str});\n");
					}
					fwrite($fh,"\n");
				}
			}
			fclose($fh);
			
			@unlink($file.".zip");
			exec("zip -r -9 {$file}.zip {$file}");
			if(!file_exists($file.".zip"))
			{
				$zip=new PHPMasterZip(); 
				$zip->ZipFile($file, $file.".zip");
			}
			if(file_exists($file.".zip"))
				@unlink($file);
				
			?><script>top.topReload();</script><?
			break;

		case "site":	// АРХИВ САЙТА
			ini_set("max_execution_time","10800");
			ini_set("memory_limit","32M");
			
			$file = "arhiv/".$_SERVER['SERVER_NAME'].".zip";
			@unlink($file);
			exec("zip -r -9 {$file} {$_SERVER['DOCUMENT_ROOT']}");
			if(!file_exists($file))
			{
				$zip=new PHPMasterZip(); 
				error_reporting(0); // подавляем вывод ошибок
				$zip->ZipDir("../", $file); 
			}
			?><script>top.topReload();</script><?
			break;
	
		case "del": // УДАЛЯЕМ
			@unlink($_GET["file"]);
			?><script>top.topReload();</script><?
			break;
	}
	exit;
}

ob_start();
// -----------------ПРОСМОТР-------------------
?>
	<a name="base"></a>
	<form action="?action=base" method="post" target="ajax">
		<table class="content">
			<tr>
				<th>Архив базы</th>
			</tr>
			<tr>
				<td>
				<? $file = "arhiv/".$_SERVER['SERVER_NAME'].".sql";
					if(file_exists($file.".zip"))
						$file .= ".zip";
					if(file_exists($file)) {	?>
						Архив от <?=date("d.m.Y H:i", filemtime($file))?> - <a href="<?=$file?>" target="_blank"><?=basename($file)?></a> (<?=round(filesize($file)/1024)?> kB) &nbsp; <?=lnkAction("Del", "&file={$file}")?>
				<?	} else { ?>
						Архив не создан
				<? } ?>
				</td>
			</tr>
			<tr>
				<th style="text-align:center"><?=btnAction("Save","Создать")?></th>
			</tr>
		</table>
	</form>
	<br>
	<a name="site"></a>
	<form action="?action=site" method="post" target="ajax">
		<table class="content">
			<tr>
				<th>Архив сайта</th>
			</tr>
			<tr>
				<td>
				<? $file = "arhiv/".$_SERVER['SERVER_NAME'].".zip";
					if(file_exists($file)) {	?>
						Архив от <?=date("d.m.Y H:i", filemtime($file))?> - <a href="<?=$file?>" target="_blank"><?=basename($file)?></a> (<?=round(filesize($file)/1024)?> kB) &nbsp; <?=lnkAction("Del", "&file={$file}")?>
				<?	} else { ?>
						Архив не создан
				<? } ?>
				</td>
			</tr>
			<tr>
				<th style="text-align:center"><?=btnAction("Save","Создать")?></th>
			</tr>
		</table>
	</form>
<?
$content = ob_get_clean();

require("template.php");
?>