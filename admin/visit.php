<?
require('inc/common.php');

$rubric = "Статистика посещений";
$tbl = "visit";

$graf = @$_GET["graf"];
if(!$date1 = @$_GET["date1"])
{
	$date1 = date("Y-m-d", mktime(0,0,0,date("m")-2,date("d"),date("Y")));
	$date1 = date("d.m.Y", strtotime($date1));
}
if(!$date2 = @$_GET["date2"])
{
	$date2 = getField("SELECT max(date) AS m FROM {$prx}visit_all");
	$date2 = date("d.m.Y", strtotime($date2));
}
if(formatDateTime($date1) > formatDateTime($date2))
{
	$tmp = $date1;
	$date1 = $date2;
	$date2 = $tmp;
}
// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "del":
			if(is_array($_SESSION['priv']))
				errorAlert('У вас нет соответствующих привелегий.');
				
			sql("TRUNCATE TABLE {$prx}visit_day");
			sql("TRUNCATE TABLE {$prx}visit_all");
			?><script>top.topReload();</script><?
			break;
		
		// данные для диаграммы
		case "getdata":
			//http://www.simplecoding.org/open-flash-chart-stroim-grafiki.html
			//http://kurilka.co.ua/archives/open-flash-chart/
			
			$date1 = formatDateTime($date1);
			$date2 = formatDateTime($date2);
			$minDate = getField("SELECT min(date) AS m FROM {$prx}visit_all WHERE date>={$date1}");
			if($date1 < $minDate) $date1 = $minDate;
			$maxDate = getField("SELECT max(date) AS m FROM {$prx}visit_all");
			if($date2 > $maxDate) $date2 = $maxDate;

			// создаем массивы с данными
			$sql = "SELECT %s FROM {$prx}visit_all WHERE date>='{$date1}' AND date<='{$date2}' ORDER BY date";
			$arrUnic = getArr(sprintf($sql, "date, unic"));
			$arrWhole = getArr(sprintf($sql, "date, whole"));
			$maxY = getField(sprintf($sql, "max(".($graf=="unic" ? "unic" : "whole").") AS m"));
			$maxY = round($maxY+$maxY*0.05);
			
			while($date2 >= $date1)
			{
				$unic[$date1] = (int)$arrUnic[$date1];
				$whole[$date1] = (int)$arrWhole[$date1];
				list($y,$m,$d) = explode("-", $date1);
				$date1 = date("Y-m-d", mktime(0,0,0,$m,$d+1,$y));
			}
			// подключаем класс со вспомогательными функциями для построения графика
			include_once("../inc/advanced/open-flash-chart/open-flash-chart.php");
			$g = new graph();
			//$g->title(iconv("", "utf-8", 'Диаграмма посещений'), '{font-size: 26px;}'); // Заголовок
			
			if($graf!="whole")
			{
				$g->set_data(($unic)); // добавляем данные в первый график
				//$g->bar(90, '#003399', 'Уникальные посетители', 11);
				//$g->line_dot(2, 3, '#003399', 'Уникальные посетители', 11);
				$g->area_hollow( 2, 3, 25, '#003399', 'Уникальные посетители', 11 );
			}
			if($graf!="unic")
			{
				$g->set_data(($whole)); // второй график
				$g->line_dot(2, 3, '#FF6600', 'Всего посещений', 11);
			}
			
			$ch = round(count($unic)/12);
			$i = 0;
			foreach($unic as $key=>$val)
			{
				list($y,$m,$d) = explode("-", $key);
				$labelsX[] = ++$i%$ch==0 ? "{$d}.{$m}" : ""; // подписи по оси Х
			}
			$g->set_x_labels(($labelsX));
			
			$g->set_y_max($maxY); // максимальное и минимальное значение по оси Y
			$g->set_y_min(0);
			$g->set_num_decimals(0); // количество десятичных знаков
			$g->set_is_thousand_separator_disabled(true); // отключить разделитель тысячей
			//$g->y_label_steps(12); // количество меток по оси Y
			
			$g->bg_colour = '#FAFAFA'; // цвет фона 
			//$g->set_x_label_style(10, '#898989'); // размер и цвет шрифта меток по осям X и Y соответственно
			//$g->set_y_label_style(10, '#898989');
			$g->x_axis_colour('#808080', '#E4E4E4'); // цвета линии осей и сетки
			$g->y_axis_colour('#808080', '#E4E4E4');

			echo iconv("windows-1251", "utf-8", $g->render());	// отображаем данные
			break;
	}
	exit;
}

ob_start();
// ------------------ПРОСМОТР--------------------

$all = getRow("SELECT SUM(unic) AS u, SUM(whole) AS a FROM {$prx}visit_all");
$day["u"] = count(getArr("SELECT DISTINCT ip FROM {$prx}visit_day"));
$day["a"] = getField("SELECT COUNT(*) AS c FROM {$prx}visit_day");

$date = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$yesterday = getRow("SELECT SUM(unic) AS u, SUM(whole) AS a FROM {$prx}visit_all WHERE date='{$date}'");

$date = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-7,date("Y")));
$week = getRow("SELECT SUM(unic) AS u, SUM(whole) AS a FROM {$prx}visit_all WHERE date>='{$date}'");

$date = date("Y-m-d", mktime(0,0,0,date("m")-1,date("d"),date("Y")));
$month = getRow("SELECT SUM(unic) AS u, SUM(whole) AS a FROM {$prx}visit_all WHERE date>='{$date}'");

$date = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")-1));
$year = getRow("SELECT SUM(unic) AS u, SUM(whole) AS a FROM {$prx}visit_all WHERE date>='{$date}'");
?>
<br><br>
<table class="content">
	<tr>
		<th>
		<? $date_start = getField("SELECT date FROM {$prx}visit_all ORDER BY date LIMIT 1");	?>
			Статистика посещений сайта c <?=date("d.m.Y", $date_start ? strtotime($date_start) : time())?>
		</th>
		<th style="text-align:right; font-weight:normal;"><?=lnkAction("Del")?></th>
	</tr>
	<tr>
		<td style="padding:20px;" colspan="2">
		
			<table class="content">
				<tr>
					<th></th>
					<th style="font-weight:normal;">Сегодня</th>
					<th style="font-weight:normal;">Вчера</th>
					<th style="font-weight:normal;">Неделя</th>
					<th style="font-weight:normal;">Месяц</th>
					<th style="font-weight:normal;">Год</th>
					<th>Всего</th>
				</tr>
			<?	foreach(array("u"=>"Уникальных<br>посетителей", "a"=>"Всего<br>посещений") as $key=>$val)
				{	?>
					<tr align="right">
						<th><?=$val?></th>
						<td style="color:#808080"><?=$day[$key]?></td>
						<td><?=(int)$yesterday[$key]?></td>
						<td><?=(int)$week[$key]?></td>
						<td><?=(int)$month[$key]?></td>
						<td><?=(int)$year[$key]?></td>
						<td><b><?=(int)$all[$key]?></b></td>
					</tr>
			<?	}	?>
			</table>

		</td>
	</tr>
</table>
<br>
<br>
<form name="frmContent">
	<table class="content" width="100%">
		<tr>
			<th>
				Диаграмма посещений сайта 
				от <input name="date2" value="<?=$date1?>" maxlength="10" style="width:75px;"> до <input name="date1" value="<?=$date2?>" maxlength="10" style="width:75px;">,
				<?=dll(array(""=>"оба графика","unic"=>"уникальные посетители","whole"=>"всего посещений"), "name='graf'", $graf)?>
				<?=btnAction("save","показать")?>
			</th>
		</tr>
		<tr>
			<td style="padding:20px;">
				<?
					include_once("../inc/advanced/open-flash-chart/open_flash_chart_object.php");
					open_flash_chart_object("100%", 250, "?action=getdata&graf={$graf}&date1={$date1}&date2={$date2}", false, "../inc/advanced/open-flash-chart/");
				?>
			</td>
		</tr>
	</table>
</form>

    <br>
    <a href="/admin/ip_managers.php">Статистика</a>

<?



$content = ob_get_clean();

require("template.php");
?>