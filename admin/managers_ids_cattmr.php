<?
require('inc/common.php');
$title = 'Выбор связок &laquo;Тип-Вендор-Категория&raquo;';
$ids_cattmr = explode(',',$_GET['ids']);

ob_start();
?>
<script>
function add_del_item(id,flag)
{
	var $cattmr = jQuery('#'+id);
	var cattmr_name = $cattmr.val();
	var $list = window.opener.jQuery('#ids_cattmr');
	
	if(flag==true)
	{
		if(!$list.find('option[value="'+id+'"]').size())
			$list.append('<option value="'+id+'">'+cattmr_name+'</option>');		
	}
	else
	{
		// удаляем связку из списка
		$list.find('option[value="'+id+'"]').remove();
		window.opener.remove_goods(id);
	}
}
jQuery(function(){
	jQuery('#ch_all input').click(function(){
		var checked = jQuery(this).attr('checked');
		jQuery('.item input[type="checkbox"]').each(function(){
			jQuery(this).attr('checked',checked);
			add_del_item(jQuery(this).prev().attr('id'),jQuery(this).attr('checked'));
		});
	});
	jQuery('.item input[type="checkbox"]').click(function(){
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
$res = sql(sprintf($sqlCattmr,''));
while($row = mysql_fetch_array($res))
{
	$id = $row['id'];
	$checked = in_array($id,$ids_cattmr);
	?>
  <div class="item">
  	<input type="hidden" id="<?=$id?>" value="<?=$row['cattmr']?>">
		<input type="checkbox"<?=$checked?' checked':''?>>
		<?=$row['cattmr']?>
  </div>
  <?
}

$content = ob_get_clean();

require("tpl_clean.php");
?>

