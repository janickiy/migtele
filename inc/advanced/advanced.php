<?
// ����������� INPUT
function aInput($type, $properties, $value="", $spec="") // "���" ���� �����, �������� ����, ��������, ���������� ��� ������������ ����
{
	$rand = rand();
	ob_start();
	switch(strtolower($type))
	{
		// ���� �����
		case "datetime":
			$time_prop = array(" hh:ii", ", true");
		// ����
		case "date":
		?>
			<link type="text/css" rel="stylesheet" href="/inc/advanced/inc/dhtmlgoodies_calendar.css" media="screen"></link>
			<script type="text/javascript" src="/inc/advanced/inc/dhtmlgoodies_calendar.js"></script>
			<input type="text" <?=$properties?> value="<?=$value?>" onClick="displayCalendar(this,'dd.mm.yyyy<?=$time_prop[0]?>',this<?=$time_prop[1]?>)">
		<?
			break;
		
		// ����
		case "color":
		?>	
			<link rel="stylesheet" href="/inc/advanced/inc/colorPicker.css" type="text/css"></link>
			<script type="text/javascript" language="javascript" src="/inc/advanced/inc/colorPicker.js"></script>
			<style>
				input.color<?=$rand?> {	
					background-color: <?=$value?>;	
					color: <?=($value && array_sum(html2rgb($value))<500 ? "white" : "black")?>;
				}
			</style>
			<input type="text" <?=$properties?> class="color<?=$rand?>" value="<?=$value?>" onClick="startColorPicker(this);">
		<?
			break;
		
		// ���� ����� ��������
		case "slidernum":
			if(!$spec)
				$spec = array(200, 0, 10); // ������, �������, ��������
			preg_match("#onChange\s*=\s*[']+(.*)[']+#iU", $properties, $onChange);  // ������: onChange='alert(\"11\");'
			$onChange = $onChange[1];
		?>	
			<link rel="stylesheet" href="/inc/advanced/inc/dhtmlgoodies_slider.css" type="text/css"></link>
			<script type="text/javascript" language="javascript" src="/inc/advanced/inc/dhtmlgoodies_slider.js"></script>
			<style> input.slidernum { text-align:center; border:none; } </style>
			<div id="slider<?=$rand?>" style="clear:both;">
				<span style="float:left; padding-right:5px; width:<?=$spec[0]?>px;"></span><input type="text" <?=$properties?> size="3" class="slidernum" value="<?=$value?>">
			</div>
			<script>
				_target = $("slider<?=$rand?>").getElementsByTagName('SPAN')[0];
				_input = $("slider<?=$rand?>").getElementsByTagName('INPUT')[0];
				form_widget_amount_slider(_target, _input, <?=$spec[0]?>, <?=$spec[1]?>, <?=$spec[2]?>, '<?=$onChange?>');
			</script>
		<?
			break;
		
		// ����� (�� ��������� �����/����)
		case "arrnum":
		?>
			<script>
				function arrnum(obj, val)
				{
					_span = obj.parentNode.parentNode;
					_input = _span.getElementsByTagName("INPUT")[0];
					if(!_input.value || isNaN(_input.value))
						_input.value = 0;
					_input.value = parseInt(_input.value) + val;
					_input.onchange(); // ��� ����������� ��������� ��������� ������
				}
			</script>
			<style> input.arrnum { height:22px; width:50px; } </style>
			<span style="white-space:nowrap;">
				<input type="text" <?=$properties?> class="arrnum" value="<?=$value?>"><img align="absmiddle" src="/inc/advanced/img/updn.gif" usemap="#arrnum<?=$rand?>" width="18" height="22">
				<map name="arrnum<?=$rand?>"><area shape="rect" coords="0,0,18,11" onClick="arrnum(this,1);"><area shape="rect" coords="0,11,18,22" onClick="arrnum(this,-1);"></map>
			</span>
		<?
			break;
		
		// �������� (�� ������ ��������� $_SESSION["antispam"] ��� �������� �����! - ��������� ����� �������� antispam())
		case "antispam":
			preg_match("#name\s*=\s*['\"]+(.*)['\"]+#iU", $properties, $name);
			$name = $name[1];
			$v1 = rand(1000,9990);
			$v2 = rand(1,9);
			// ������� ��������� ����� �������� :)
			if(!@$_SESSION["antispam"]) // �������������� �����
				$_SESSION["antispam"] = rand();
			$str = "{$v1}+{$v2}="; // ������� ������ � html-���
			for($i=0; $i<strlen($str); $i++)
				$html[] = "&#".ord($str[$i]).";";
		?>
			<input type="text" style="border:none; width:54px;" value="<?=implode("", $html)?>" readonly>
			<input type="text" <?=$properties?> value="<?=$value?>" size="10">
			<input type="hidden" value="<?=md5($v1+$v2+$_SESSION["antispam"])?>" name="<?=$name?>_check">
		<?	
			break;
		
		// ������� ��������
		case "starrating":
			list($srcStar0, $srcStar1) = array("/inc/advanced/img/star1.gif", "/inc/advanced/img/star2.gif"); // ���� � �������
			list($width, $height) = array("17", "18"); // ������ � ������ ������
			$count = $spec; // ���������� �����
			preg_match("#name\s*=\s*['\"]+(.*)['\"]+#iU", $properties, $name);
			$name = @$name[1];
		?>
			<script>
				var stopRating<?=$rand?> = false;
				function showRating<?=$rand?>(obj, r)
				{
					if(stopRating<?=$rand?>)
						return;
					var _img = obj.parentNode.getElementsByTagName('IMG');
					for(var i=0; i<_img.length; i++)
						_img[i].src = i>r ? "<?=$srcStar0?>" : "<?=$srcStar1?>";
				}
				function setRating<?=$rand?>(r)
				{
					// ����� ������������ �� ������
					//toajax('/setrating.php?id=<?=$name?>&rating='+r);
					
					// �� ������ ���������� ��������� � ������� ���� � ������������� ����� ��������
					stopRating<?=$rand?> = true;
					$('divRating<?=$rand?>').style.cursor = "auto";
					$('<?=$name?>').value = r;
				}
			</script>
			<div style="height:<?=$height?>px; width:<?=$width*$count?>px; background-image:url(<?=$srcStar0?>); cursor:pointer;" onMouseOver="$('divStars<?=$rand?>').style.visibility='visible';" id="divRating<?=$rand?>">
				<div style="height:<?=$height?>px; width:<?=round($value*$width)?>px; background-image:url(<?=$srcStar1?>);"></div>
				<div style="position:relative; height:<?=$height?>px; width:<?=$width*$count?>px; margin-top:-<?=$height?>px; visibility:hidden;" id="divStars<?=$rand?>" onMouseOut="if(!stopRating<?=$rand?>) this.style.visibility='hidden';">
				<?	for($i=0; $i<$count; $i++) {	
						?><img src="<?=$srcStar0?>" onMouseOver="showRating<?=$rand?>(this,<?=$i?>)" onClick="setRating<?=$rand?>(<?=$i+1?>)"><?
					}
			 ?></div>
			</div>
			<input type="hidden" value="<?=$value?>" name="<?=$name?>" id="<?=$name?>">
		<?
			break;
	}
	return ob_get_clean();
}

// ��������������� ������� ��� �������� ���� � aInput("antispam"...
function antispam($name="code")
{
	$code = (int)$_POST[$name];
	$code_check = mysql_escape_string($_POST["{$name}_check"]);
	return md5($code+$_SESSION["antispam"]) == $code_check;
}

// PHP-���������
function calendar($month="", $date="", $monthf="?month=%s", $datef="?date=%s") // ���-����� ���������, �������� ����, ������ ������ ��� �������� ���������, ������ ������ ��� ����
{
?>	<link rel="stylesheet" type="text/css" href="/inc/advanced/inc/calendar.css">	<?
	require_once("inc/calendar.php");
	return getCalendar($month, $date, $monthf, $datef);
}

?>