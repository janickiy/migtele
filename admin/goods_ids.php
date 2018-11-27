<?
require('inc/common.php');
$title = "—опутствующие товары &raquo; –едактирование";
$id_good = (int)@$_GET['id_good'];

$ids_goods = getField("SELECT ids_goods FROM {$prx}goods WHERE id={$id_good}");
if($ids_goods)
	$mas_ids = explode(",", $ids_goods);
else
	$mas_ids = array();

ob_start();
?>
<script>
var top = window.opener.document;

function add_del_good(id,flag)
{
	var g_name = document.getElementById(id).value;
	var list = top.getElementById('ids_goods');
	
	if(flag==true)
	{
		list.options[list.options.length] = new Option(g_name,id);
	}
	else
	{
		// удал€ем товар из списка соп. товаров
		for(var k=0; k<list.options.length; k++)
		{
			if(list.options[k].value==id)
			{
				list.options[k] = null;
				continue;
			}
		}
	}
}
</script>
<style>
body
{
	padding:10px;
	font-size:12px;
}
h1
{
	margin:0 0 10px 0;
	font: bold 18px Verdana, Geneva, sans-serif;
	background-color:#000;
	color:#fff;
}
h2
{
	margin:0 0 10px 20px;
	font: bold 14px Verdana, Geneva, sans-serif;
	color: #000;
}
.good
{
	margin:5px 0;
	padding:0 10px 0 40px;
}
.comment
{
	font:normal 11px Verdana, Geneva, sans-serif;
	color: #000;
	background-color: #CCC;
	padding:3px 5px;
	margin:0 0 0 25px;
}
</style>
<?
$query  = "SELECT D.name AS cattype,C.name AS catrazdel,A.id,A.name AS good,A.text4 as comment ";
$query .= "FROM mig_goods A ";
$query .= "		INNER JOIN mig_cattmr B ON B.id = A.id_cattmr ";
$query .= "		INNER JOIN mig_catrazdel C ON C.id = B.id_catrazdel ";
$query .= "		INNER JOIN mig_cattype D ON D.id = B.id_cattype ";
$query .= "ORDER BY D.name,C.name,A.name";

$res = mysql_query($query);
if(@mysql_num_rows($res))
{
	$old_cattype = '';
	$old_catrazdel = '';
	while($row = mysql_fetch_assoc($res))
	{
		$id = $row['id'];
		
		// текущий товар пропускаем
		if($id==$id_good)	continue;
			
		$cattype = $row['cattype'];
		$catrazdel = $row['catrazdel'];
		
		if($cattype!=$old_cattype)
			echo "<h1>{$cattype}</h1>";
		if($catrazdel!=$old_catrazdel)
			echo "<h2>{$catrazdel}</h2>";
			
		$checked = false;				
		if(is_array($mas_ids) && in_array($id,$mas_ids))
			$checked = true;
		
		?>
        <div class="good">
		<input type="hidden" id="<?=$id?>" value="<?=$row['good']?>">
		<input type="checkbox" id="ch_<?=$id?>"<?=$checked?' checked':''?> onClick="add_del_good(<?=$id?>,this.checked)"> <?=$row['good']?>
        <?
		if($row['comment']!='')
		{
			?><div class="comment"><?=$row['comment']?></div><?
		}
		?>
        </div>
		<?
		
		$old_cattype = $cattype;
		$old_catrazdel = $catrazdel;
	}
}




/*$ids = getArr("SELECT id FROM {$prx}cattmr WHERE id_cattype='{$id_cattype}'");
$ids = getArr("SELECT id FROM {$prx}goods WHERE id_cattmr IN (".($ids ? implode(",",$ids) : 0).") ORDER BY name");

if(is_array($ids))
	$ids = trim(implode(",", $ids),",");
if($ids)
{
	// отсеиваем скрытые
	$ids = getArr("SELECT g.id
						FROM {$prx}goods AS g
							INNER JOIN {$prx}cattmr AS tmr ON g.id_cattmr=tmr.id
							INNER JOIN {$prx}catrazdel AS r ON tmr.id_catrazdel = r.id
						WHERE g.id IN ({$ids})");
	if(is_array($ids))
	{
		$ids = trim(implode(",", $ids),",");
		
		$ids_cattmr = getArr("SELECT DISTINCT id_cattmr FROM {$prx}goods WHERE id IN ({$ids})");
		$ids_cattmr = implode(",", $ids_cattmr);
		$ids_catrazdel = implode(",", getArr("SELECT DISTINCT id_catrazdel FROM {$prx}cattmr WHERE id IN ({$ids_cattmr})"));
		//print_r($ids_catrazdel);	
		
		$res0 = sql("SELECT id, name FROM {$prx}catrazdel WHERE id IN ({$ids_catrazdel}) ORDER BY sort");
		while($row0 = @mysql_fetch_array($res0))
		{	
			?>
			<h3 style="margin:10px 0;"><?=$row0["name"]?></h3>
			<?
			$res = sql("SELECT g.* FROM {$prx}goods AS g 
								INNER JOIN {$prx}cattmr AS tmr ON tmr.id=g.id_cattmr
							WHERE g.id IN ({$ids}) AND tmr.id_catrazdel='{$row0['id']}'
							ORDER BY g.name");
			
			$i=0;
			$count_goods = @mysql_num_rows($res);
			while($row = @mysql_fetch_array($res))
			{	
				$id = $row["id"];
				
				// текущий товар пропускаем
				if($id==$id_goods)
					continue;
				
				$checked = false;				
				if(is_array($mas_ids) && in_array($id,$mas_ids))
					$checked = true;
				
				?>
                <input type="hidden" id="<?=$id?>" value="<?=$row['name']?>">
                <input type="checkbox" id="ch_<?=$id?>"<?=$checked?' checked':''?> onClick="add_del_good(<?=$id?>,this.checked)">
                <?=$row['name']?><br>
				<?
			}
		}
	}
}*/

$content = ob_get_clean();

require("tpl_clean.php");
?>

