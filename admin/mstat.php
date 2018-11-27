<?
require('inc/common.php');
$tbl = "mstat";
$rubric = "Активность менеджеров";
$top_menu = "managers";

function DateAdd($interval, $number, $date) 
{
    $date_time_array = getdate($date);
    $hours = $date_time_array['hours'];
    $minutes = $date_time_array['minutes'];
    $seconds = $date_time_array['seconds'];
    $month = $date_time_array['mon'];
    $day = $date_time_array['mday'];
    $year = $date_time_array['year'];

    switch ($interval) {
    
        case 'yyyy':
            $year+=$number;
            break;
        case 'q':
            $year+=($number*3);
            break;
        case 'm':
            $month+=$number;
            break;
        case 'y':
        case 'd':
        case 'w':
            $day+=$number;
            break;
        case 'ww':
            $day+=($number*7);
            break;
        case 'h':
            $hours+=$number;
            break;
        case 'n':
            $minutes+=$number;
            break;
        case 's':
            $seconds+=$number; 
            break;            
    }
    return $timestamp = mktime($hours,$minutes,$seconds,$month,$day,$year);
}

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "save":
			foreach($_POST as $key=>$val)
				$$key = clean($val);
	
			$set = "id_otr='{$id_otr}', name='{$name}', text='{$text}', feature='{$feature}', title='{$title}', keywords='{$keywords}', description='{$description}'";
			$id = update($tbl, $set, $id);
			
			// загружаем картинки
			if($_FILES['image']['name'])
			{
				@move_uploaded_file($_FILES['image']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."/img/t{$id}.png");
				@chmod($_SERVER['DOCUMENT_ROOT']."/img/t{$id}.png",0644);				
			}
			
			?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
			break;
		
		case "img_del":
			@unlink($_SERVER['DOCUMENT_ROOT']."/img/t{$id}.png");
			?><script>top.location.href = "?id=<?=$id?>&red";</script><?
			break;
		// ----------------- обновление статуса
		case "status":
			update_flag($tbl,'status',$id);
			?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
		break;
		case "moveup":
			$move = "up";
		case "movedown":
			moveSort((@$move ? "up" : "down"), $tbl, $id);
			?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
			break;
		case "del":
			sql("DELETE FROM {$prx}cattmr WHERE id_cattype={$id}");
			sql("DELETE FROM {$prx}cattr WHERE id_cattype={$id}");
			update($tbl,"",$id);
			@unlink($_SERVER['DOCUMENT_ROOT']."/img/t{$id}.png");
			?><script>top.topReload();</script><?
			break;
	}
	exit;
}
// -----------------ПРОСМОТР-------------------
$id = (int)$_GET['manager'];
$manager = getRow("SELECT * FROM {$prx}managers WHERE id='{$id}'");

ob_start();

$d1 = $_GET['start'] ? date('Y-m-d',strtotime($_GET['start'])) : date('Y-m-d',DateAdd('m',-1,mktime()));
$d2 = $_GET['end'] ? date('Y-m-d',strtotime($_GET['end'])) : date('Y-m-d');

?>
<form>
<table class="content" style="margin-bottom:30px;">
	<tr>
    <th>Менеджер</th>
    <th colspan="2"><?=dll("SELECT id,name FROM {$prx}managers ORDER BY name", 'name="manager" style="width:auto"', $manager['id'], array('0','-- все --'))?></th>
  </tr>
  <tr>
	  <th>Период:</th>
    <th>с<?=aInput("date", "name='start'", date('d.m.Y',strtotime($d1)))?></th>
    <th>по<?=aInput("date", "name='end'", date('d.m.Y',strtotime($d2)))?></th>
  </tr>
  <tr><td colspan="3" align="center"><input type="submit" value="показать"></td></tr>
</table>
</form>
<?

if(!$manager)
{
	?><div>выберите менеджера</div><?
	$content = ob_get_clean();
	require('template.php');
	exit;
}

$where = '';
if($d1) $where .= " and DATE_FORMAT(A.`date`,'%Y-%m-%d')>='{$d1}'";
if($d2) $where .= " and DATE_FORMAT(A.`date`,'%Y-%m-%d') < DATE_FORMAT('{$d2}'+INTERVAL 1 DAY,'%Y-%m-%d')";
if(!$d1&&!$d2) $where .= " and DATE_FORMAT(A.`date`,'%Y-%m-%d')='".date('Y-m-d')."'";

$query = "SELECT A.*,B.id as gid,B.id_cattmr,B.kod FROM {$prx}mstat A
					LEFT JOIN {$prx}goods B ON A.id_good=B.id
					WHERE id_manager='{$manager['id']}'{$where}";
$res = mysql_query($query);
if(@mysql_num_rows($res))
{
	?><table class="content"><tr><th>№</th><th>Дата</th><th>Время</th><th>Код товара</th></tr><?
	$i=1;
	while($row = mysql_fetch_assoc($res))
	{
		?>
    <tr>
    	<th><?=$i++?></th>
      <td><?=date('d.m.Y',strtotime($row['date']))?></td>
      <td><?=date('H:i',strtotime($row['date']))?></td>
      <td><a href="goods.php?id=<?=$row['gid']?>&id_cattmr=<?=$row['id_cattmr']?>&red" target="_blank"><?=$row['kod']?></a></td>
    </tr>
    <?
	}
	?></table><?
}

$content = ob_get_clean();
require('template.php');
?>