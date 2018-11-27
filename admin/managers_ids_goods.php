<?
require('inc/common.php');
$title = 'Выбор товаров';
$ids_goods = explode(',',$_GET['ids']);
$ids_cattmr = clean($_GET['ids_cattmr']);

ob_start();
?>
<script>
function add_del_item(id,flag)
{
	var $cattmr = jQuery('#'+id);
	var cattmr_name = $cattmr.val();
	var cattmr_id = $cattmr.attr('cid');
	var $list = window.opener.jQuery('#ids_goods');
	
	if(flag==true)
	{
		if(!$list.find('option[value="'+id+'"]').size())
			$list.append('<option value="'+id+'" cid="'+cattmr_id+'">'+cattmr_name+'</option>');		
	}
	else
	{
		// удаляем связку из списка
		$list.find('option[value="'+id+'"]').remove();
	}
}
jQuery(function(){
	jQuery('#ch_all input').click(function(){
		var checked = jQuery(this).attr('checked');
		jQuery('.good input[type="checkbox"]').each(function(){
			jQuery(this).attr('checked',checked);
			add_del_item(jQuery(this).prev().attr('id'),jQuery(this).attr('checked'));
		});
	});
	jQuery('.good input[type="checkbox"]').click(function(){
		add_del_item(jQuery(this).prev().attr('id'),jQuery(this).attr('checked'));
	});
});
window.onunload = function(){ window.opener.jQuery('a.clear').add(window.opener.jQuery('a.red')).show() }
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
#ch_all input { margin-bottom:20px; }
</style>

<h1><?=$title?></h1>
<div id="ch_all"><input type="checkbox"> <span>применить ко всем</span></div>
<?
$query = "SELECT D.name AS cattype,C.name AS catrazdel,A.id,A.name AS good,A.id_cattmr as cid,A.text4 as comment
					FROM mig_goods A
					INNER JOIN mig_cattmr B ON B.id = A.id_cattmr
					INNER JOIN mig_catrazdel C ON C.id = B.id_catrazdel
					INNER JOIN mig_cattype D ON D.id = B.id_cattype
					WHERE B.id IN ({$ids_cattmr})
					ORDER BY D.name,C.name,A.name";

$res = mysql_query($query);
if(@mysql_num_rows($res))
{
	$old_cattype = '';
	$old_catrazdel = '';
	while($row = mysql_fetch_assoc($res))
	{
		$id = $row['id'];
			
		$cattype = $row['cattype'];
		$catrazdel = $row['catrazdel'];
		
		if($cattype!=$old_cattype)
			echo "<h1>{$cattype}</h1>";
		if($catrazdel!=$old_catrazdel)
			echo "<h2>{$catrazdel}</h2>";
			
		$checked = in_array($id,$ids_goods);		
		?>
    <div class="good">
		<input type="hidden" id="<?=$id?>" cid="<?=$row['cid']?>" value="<?=$row['good']?>">
		<input type="checkbox"<?=$checked?' checked':''?>> <?=$row['good']?>
    <?
		if($row['comment'])
		{
			?><div class="comment"><?=$row['comment']?></div><?
		}
		?></div><?
		
		$old_cattype = $cattype;
		$old_catrazdel = $catrazdel;
	}
}

$content = ob_get_clean();

require("tpl_clean.php");
?>

