<?
// -------------------ВЫГРУЗКА----------------------
if(isset($_GET["out"]))
{
	require_once('../inc/common.php');
	header("Content-type: text/xml");
	$site_url = $_SERVER['SERVER_NAME'];
	$usl_pay = set('usl_pay');

    require_once(dirname(__FILE__) . '/../yii/protected/models/Goods.php');
?>
<?='<?xml version="1.0" encoding="windows-1251"?>'?>
	<yml_catalog>
		<shop>
			<name><?=set("ym_name")?></name>
			<company><?=set("ym_company")?></company>
			<url>http://<?=$site_url?>/</url>
			
			<currencies>
				 <currency id="RUR" rate="1"/>
			</currencies>
			
			<categories>
			<?	$res = sql(sprintf($sqlCattmr, "WHERE m.hide=0 AND r.hide=0"));
				while($row = mysql_fetch_array($res))	
				{	
					$ids[] = $row['id'];
				?>
					<category id="<?=$row['id']?>"><?=htmlspecialchars($row['cattmr'],ENT_QUOTES)?></category>
			<?	}	?>
			</categories>
			
			<offers>
			<?	$res = sql("SELECT * FROM {$prx}goods WHERE importNew=0 and hide=0 and none=0 AND id_cattmr IN (".implode(",",$ids).")");
				while($row = mysql_fetch_array($res))
				{	
					$valuta = $row["valuta"];
					$price = $row["price"];
					/**@var $product Goods*/
					$product = Goods::model()->findByPk($row['id']);

					if($row["price"])
					{	
						if($valuta != "rub") 
							$price = $price*$kurs[$valuta];
						$id_img = getField("SELECT id FROM {$prx}goods_img WHERE id_goods='{$row['id']}' ORDER BY sort LIMIT 1");
						?>
            <offer id="<?=$row['id']?>" type="vendor.model">
                <url>http://<?=$site_url?>/<?= $product->getUrl()?></url>
                <price><?=number_format($price,0,"","")?></price>
                <currencyId>RUR</currencyId>
                <categoryId><?=$row['id_cattmr']?></categoryId>
                <?php if($id_img){ ?>
                    <picture>http://<?= $site_url ?>/images/original/uploads/goods_img/<?= $id_img ?>.jpg</picture>
                <?php } ?>
                <vendor><?
								$q = "SELECT A.name FROM {$prx}catmaker A
											INNER JOIN {$prx}cattmr B ON A.id=B.id_catmaker
											WHERE B.id={$row['id_cattmr']}";
								$maker = getField($q);
								echo $maker ? htmlspecialchars($maker,ENT_QUOTES) : 'NoName';
								?></vendor>
                <model><?=htmlspecialchars($row['kod'],ENT_QUOTES)?></model>
                <description><?=htmlspecialchars(strip_tags($row['text1']),ENT_QUOTES)?></description>
            </offer>
            <?	
        	}
				}	
				?>
			</offers>
		</shop>
	</yml_catalog>	
	<?
	exit;
}
// ---------------------------------------------------


require('inc/common.php');
$tbl = "settings";
$rubric = "Товары &raquo; Mix-Маркет";
$top_menu = "goods";
$id = (int)@$_GET['id'];

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "save":
			foreach($_POST as $id=>$val)
			{
				$val = clean($val);
				update($tbl, "value='$val'", $id);
			}
			?><script>top.topBack(true);</script><?
			break;
	}
	exit;
}

ob_start();
// ------------------РЕДАКТИРОВАНИЕ--------------------
?>
<form action="?id=<?=$id?>&action=save" method="post" enctype="multipart/form-data" target="ajax">
	<table class="red" width="600">
		<tr>
			<th>Короткое название магазина</th>
			<td><input name="ym_name" type="text" value="<?=set('ym_name')?>" maxlength="20"></td>
		</tr>
		<tr>
			<th>Полное наименование компании</th>
			<td><input name="ym_company" type="text" value="<?=set('ym_company')?>"></td>
		</tr>
		<tr>
			<td align="center" colspan="2"><?=btnAction("Save,Reset")?></td>
		</tr>
	</table>
</form>	
<br><br>
<table class="content">
	<tr>
		<th>Ссылка на файл выгрузки</th>
	</tr>
	<tr>
		<td><a href="?out" target="_blank">http://<?=$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']?>?out</a></td>
	</tr>
</table>
<?

$content = ob_get_clean();
$tbl = "mixmarket";

require("template.php");
?>