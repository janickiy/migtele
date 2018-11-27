<?
$goods_marks = array("Описание товара","Тех. хар-ки","Цены","Опции и аксесуары","Документация","Скачать софт","Фотогалерея");

$sqlCattmr = "SELECT 	tmr.id, CONCAT(t.name,' - ',m.name,' - ',r.name, if(IFNULL(tmr.id_sub_catrazdel, false), CONCAT(' - ', sub_r.name), '') ) AS cattmr,
											CONCAT(t.name,' - ',m.name,' - ',r.name, if(IFNULL(tmr.id_sub_catrazdel, false), CONCAT(' - ', sub_r.name), '') ) AS name,
											tmr.*,
											t.name AS cattype,
											m.name AS catmaker,
											r.name AS catrazdel,
											sub_r.name AS sub_catrazdel,
											tmr.id AS id_cattmr,
											t.id AS id_cattype,
											t.id_otr as id_otr,
											m.id AS id_catmaker,
											r.id AS id_catrazdel,
											sub_r.id AS id_sub_catrazdel
							FROM {$prx}cattmr AS tmr
							LEFT JOIN {$prx}cattype AS t ON t.id = tmr.id_cattype
							LEFT JOIN {$prx}catmaker AS m ON m.id = tmr.id_catmaker
							LEFT JOIN {$prx}catrazdel AS r ON r.id = tmr.id_catrazdel
							LEFT JOIN {$prx}catrazdel AS sub_r ON sub_r.id = tmr.id_sub_catrazdel
							%s
							ORDER BY tmr.sort";

// ОБНОВЛЯЕМ ЦЕНЫ ОН-ЛАЙН ПРАЙС В СООТВЕТСТВИИ С КАТАЛОГОМ
function updateOnlinePrice()
{
	global $prx;
	
	$res = sql("SELECT kod, price, valuta FROM {$prx}goods WHERE kod<>''");
	while($row = mysql_fetch_array($res)){
//        $row['kod'] = mysql_real_escape_string($row['kod']);
        $row['kod'] = clean($row['kod']);
        sql("UPDATE {$prx}price SET price='{$row['price']}', valuta='{$row['valuta']}' WHERE kod='{$row['kod']}' AND razd='0'");
    }

}

// УСТАНАВЛИВАЕМ КУРС ДОЛЛАРА
function setKurs()
{
	global $prx;
	$row = getRow("SELECT * FROM {$prx}valuta WHERE date='".date("Y-m-d")."' ORDER BY id DESC");
	if(!$row['usd'] || !$row['eur'])
		update("valuta", "date=NOW(), usd='".getKurs("usd")."', eur= '".getKurs("eur")."'", $row['id']);
   /* if(!$row['usd'])
		update("valuta", "date=NOW(), usd='".getKurs("usd")."'", $row['id']);
	if(!$row['eur'])
		update("valuta", "date=NOW(), eur='".getKurs("eur")."'", $row['id']);*/
}

function showPrice($price, $valuta, $id_goods=0)
{	
	global $kurs, $prx;
	
	if($valuta == "rub")
		$str = number_format(round($price),0,","," ")." Р";
	else
		$str = number_format(round($price*$kurs[$valuta]),0,","," ")." Р";

	return "<b>{$str}</b>";
}
function numberPrice($price)
{
	$price = str_replace('<b>','',$price);
	$price = str_replace('</b>','',$price);
	$price = str_replace(' Р','',$price);
	$price = str_replace(' ','',$price);
	$price = (int)$price;
					
	return $price;
}

function show_sort()
{
	global $prx, $all;
	$count_obj_on_page = $all ? 1000 : ($_SESSION['count_obj_on_page']?$_SESSION['count_obj_on_page']:15);
	$p = (int)$_GET['p'] ? (int)$_GET['p'] : 1;
	$start = $count_obj_on_page*$p-$count_obj_on_page;
	$gvid = $_SESSION['gvid'] ? $_SESSION['gvid'] : 1;
	?>
	<div id="ar_sort">
    <div id="svid">
    	<? $cur = !isset($_SESSION['gvid']) ? '_' : ($_SESSION['gvid']=='1'?'_':''); ?>
    	<div class="vid<?=$cur?>"><div><img src="/img/sort/s2<?=$cur?>.gif" align="absmiddle">плиткой</div><input type="hidden" value="1"></div>
      <? $cur = !isset($_SESSION['gvid']) ? '' : ($_SESSION['gvid']=='2'?'_':''); ?>
      <div class="vid<?=$cur?>"><div><img src="/img/sort/s3<?=$cur?>.gif" align="absmiddle">списком</div><input type="hidden" value="2"></div>
      <? $cur = !isset($_SESSION['gvid']) ? '' : ($_SESSION['gvid']=='3'?'_':''); ?>
      <div class="vid<?=$cur?>"><div><img src="/img/sort/s4<?=$cur?>.gif" align="absmiddle">таблицей</div><input type="hidden" value="3"></div>
    </div>
    <div id="stype">
    	<div style="padding-top:2px">Сортировка</div>
      <div>
        <select>
           <option value="name ASC"<?=$_SESSION['gsort']=='name ASC'?' selected':''?>>По алфавиту (по возрастанию)</option>
           <option value="name DESC"<?=$_SESSION['gsort']=='name DESC'?' selected':''?>>По алфавиту (по убыванию)</option>
           <option value="price ASC"<?=$_SESSION['gsort']=='price ASC'?' selected':''?>>По цене (по возрастанию)</option>
           <option value="price DESC"<?=$_SESSION['gsort']=='price DESC'?' selected':''?>>По цене (по убыванию)</option>
        </select>
      </div>
      <div style="float: right;margin-right:20px;">	
       	<?
        $val = $all ? 'all' : ($_SESSION['count_obj_on_page']==1000 ? 'all' : ($_SESSION['count_obj_on_page']?$_SESSION['count_obj_on_page']:15));
				echo dll(array('15'=>'15','30'=>'30','60'=>'60'),'onChange="toajax(\'/show_catalog.php?action=count_obj_on_page&url='.$_SERVER['REQUEST_URI'].'&limit=\'+this.value)"',$val,array('all','все'));
				?>
      </div>
      <div style="padding-top:2px;margin-left:30px;float: right;">Товаров на странице:</div>
    </div>
  </div>
  <script>
	jQuery(function(){
		$svid = jQuery('#svid');
		$stype = jQuery('#stype');
		$svid.find('div.vid').click(function(){	regSS('<?=$_SERVER['REQUEST_URI']?>','gvid='+jQuery(this).find('input').val()) });
		$stype.find('select:eq(0)').change(function(){ regSS('<?=$_SERVER['REQUEST_URI']?>','gsort='+this.value) });
	});
	</script>
	<?
}

/*function showGoods($ids, $sort="sort")
{
	global $prx, $kurs;
	
	$content = '';
	
	if(is_array($ids))
		$ids = trim(implode(",", $ids),",");
	if($ids)
	{
		// отсеиваем скрытые
		$ids = getArr("SELECT g.id
							FROM {$prx}goods AS g
								INNER JOIN {$prx}cattmr AS tmr ON g.id_cattmr=tmr.id
								INNER JOIN {$prx}catmaker AS m ON tmr.id_catmaker = m.id
								INNER JOIN {$prx}catrazdel AS r ON tmr.id_catrazdel = r.id
							WHERE g.hide=0 AND m.hide=0 AND r.hide=0 AND g.id IN ({$ids})");

		if(is_array($ids))
		{
			$ids = trim(implode(",", $ids),",");
			
			$ids_cattmr = getArr("SELECT DISTINCT id_cattmr FROM {$prx}goods WHERE id IN ({$ids})");
			$ids_cattmr = implode(",", $ids_cattmr);
			$ids_catmaker = getArr("SELECT DISTINCT id_catmaker FROM {$prx}cattmr WHERE id IN ({$ids_cattmr})");
			$ids_catrazdel = getArr("SELECT DISTINCT id_catrazdel FROM {$prx}cattmr WHERE id IN ({$ids_cattmr})");
			
			// группируем по разделу или производителю (если один раздел)
			$group = count($ids_catrazdel)>1 || count($ids_catmaker)<2 ? "razdel" : "maker";
			$ids_group = implode(",", ${"ids_cat".$group});
			
			$res0 = sql("SELECT id, name FROM {$prx}cat{$group} WHERE id IN ({$ids_group}) ORDER BY sort");
			while($row0 = mysql_fetch_array($res0))
			{	
				$res = sql("SELECT g.* FROM {$prx}goods AS g 
										INNER JOIN {$prx}cattmr AS tmr ON tmr.id=g.id_cattmr
										WHERE g.id IN ({$ids}) AND tmr.id_cat{$group}='{$row0['id']}'
										ORDER BY g.{$sort}");
				$i=0;
				$count_goods = @mysql_num_rows($res);
				
				ob_start();
				$find_goods = 0;
				
				while($good = @mysql_fetch_array($res))
				{
					$id = $good['id'];
					$link = $good['link'];
					
					$show_good = true;
					if($_SESSION['mas_ch'])
					{
						$feature1 = unserialize($row['feature1']);
						foreach($_SESSION['mas_ch'] as $n=>$ch)
						{
							if(!$ch)
								continue;
								
							$mas = $feature1[$n];
							
							if(!$mas)
							{
								$show_good = false;
								break;
							}
							
							if(is_array($mas) && !in_array($ch,$mas))
							{
								$show_good = false;
								break;
							}
						}
					}
					
					if(!$show_good)
						continue;
					
					$find_goods++;
					
					$gvid = $_SESSION['gvid'] ? $_SESSION['gvid'] : '1';
					
					// --------------------- ПЛИТКОЙ
					if($gvid==1)
					{
						if(++$i%3==1) echo '<tr>';	
						?><td width="33%" valign="top" height="1%"><?=gvid1($good)?></td><?
					}
					// --------------------- СПИСКОМ
					elseif($gvid=='2')
						gvid2($good);
					// --------------------- ТАБЛИЦЕЙ
					elseif($gvid=='3')
						gvid3($good);
				} //while($good = @mysql_fetch_array($res))
				
				$data = ob_get_clean();
				
				if($data)
				{
					ob_start();
					
					?><h3 style="margin:10px 0 10px 5px;"><?=$row0["name"]?></h3><?
					if($gvid=='1')
					{
						?><table width="100%" border="0" cellpadding="0" cellspacing="5"><?=$data?><?
						// если кол-во товаров меньше 3-x - добавляем пустые ячейки (для выравнивания)
						if($find_goods>0 && $find_goods<3)
							echo str_repeat('<td width="33%" valign="top" height="1%">&nbsp;</td>',(3-$find_goods));
						?></table><?
					}
					else
						echo $data;
					$content .= ob_get_clean();
				}
			} //while($row0 = mysql_fetch_array($res0))
		}
	}
	
	if($content) echo $content;
	else
	{
		?>
    <div align="center" style="margin:20px 0;">
    <h3>По Вашему запросу ничего не найдено</h3>
    <span style="font-size:18px; color:#666;">выберите новые характеристики</span>
    </div>
    <?
	}
}*/

function showGoods($ids,$sort='sort',$showtype=false)
{
//	exit();
    global $prx, $kurs, $all;
	
	$ArrGoods = array();

	$count_obj_on_page = $all ? 1000 : ($_SESSION['count_obj_on_page']?$_SESSION['count_obj_on_page']:15);
	$p = (int)$_GET['p'] ? (int)$_GET['p'] : 1;
	$start = $count_obj_on_page*$p-$count_obj_on_page;
	$gvid = $_SESSION['gvid'] ? $_SESSION['gvid'] : 1;
	
	if(is_array($ids))
		$ids = trim(implode(",", $ids),",");

	if($ids)
	{
		// отсеиваем скрытые и importNew
        $ids = getArr("SELECT g.id
							FROM {$prx}goods AS g
								INNER JOIN {$prx}cattmr AS tmr ON g.id_cattmr=tmr.id
								INNER JOIN {$prx}catmaker AS m ON tmr.id_catmaker = m.id
								INNER JOIN {$prx}catrazdel AS r ON tmr.id_catrazdel = r.id
							WHERE g.hide=0 AND m.hide=0 AND r.hide=0 AND g.id IN ({$ids}) AND g.importNew = 0");


        
        if(is_array($ids))
		{
			$ids = trim(implode(",", $ids),",");
			
			$ids_cattmr = getArr("SELECT DISTINCT id_cattmr FROM {$prx}goods WHERE id IN ({$ids})");
			$ids_cattmr = implode(",", $ids_cattmr);
			$ids_catmaker = getArr("SELECT DISTINCT id_catmaker FROM {$prx}cattmr WHERE id IN ({$ids_cattmr})");
			$ids_catrazdel = getArr("SELECT DISTINCT id_catrazdel FROM {$prx}cattmr WHERE id IN ({$ids_cattmr})");
			
			// группируем по разделу или производителю (если один раздел)
			$group = count($ids_catrazdel)>1 || count($ids_catmaker)<2 ? "razdel" : "maker";
			$ids_group = implode(',',${"ids_cat".$group});
			
			$res0 = sql("SELECT id,name FROM {$prx}cat{$group} WHERE id IN ({$ids_group}) ORDER BY sort,id");
			while($row0 = mysql_fetch_array($res0))
			{	
                $res = sql("SELECT g.id,T.name as tname FROM {$prx}goods AS g 
										INNER JOIN {$prx}cattmr AS tmr ON tmr.id=g.id_cattmr
										INNER JOIN {$prx}cattype AS T ON tmr.id_cattype=T.id
										WHERE g.id IN ({$ids}) AND tmr.id_cat{$group}='{$row0['id']}'
										ORDER BY g.none, g.{$sort}");
				
				while($row = @mysql_fetch_array($res))
				{					
					$show_good = true;
					if($_SESSION['mas_ch'])
					{
						$feature1 = unserialize($row['feature1']);
						foreach($_SESSION['mas_ch'] as $n=>$ch)
						{
							if(!$ch) continue;							
							if(!$mas = $feature1[$n]){ $show_good = false; break; }
							if(is_array($mas) && !in_array($ch,$mas)){ $show_good = false; break; }
						}
					}
					if(!$show_good)	continue;
					
					$ArrGoods[] = array('gid'=>$row['id'],'tname'=>$row['tname'],'rname'=>$row0['name']);
				}				
			} //while($row0 = mysql_fetch_array($res0))
		}
	}
	
    $kol_end=$count_obj_on_page+$start;
    $kol_end=($kol_end>count($ArrGoods)?count($ArrGoods):$kol_end);
	// постраничная навигация
//	ob_start();
  ?>
  <tr>
    <td colspan="2">
     	<?=show_sort()?>	
		 	<? if(count($ArrGoods)){ ?> 
      <div class="nav">
       <div style="float: left;">Показаны <?=$start+1?> - <?=$kol_end?>  из <?=count($ArrGoods)?> по результатам поиска</div>
         <div style="float: right;">
          <?
          $strpage = '';
          if($ArrGoods[$start])
          {
            /*<a href="" onClick="toajax('/show_catalog.php?action=count_obj_on_page&url=<?=$_SERVER['REQUEST_URI']?>&limit=all');return false;">Все на одной странице</a>*/
            $kol_str = ceil(sizeof($ArrGoods)/$count_obj_on_page); // количество страниц
            $lnk = preg_replace("/page[0-9]+\.htm/",'',$_SERVER['REQUEST_URI']);
            ob_start();
              show_navigate_pages($kol_str,$p,$lnk);
            echo $strpage = ob_get_clean();
          }
          ?>
          </div>
      </div>
      <? }?>
    </td>
  </tr>
</table> 
	<?	
//	$nav = ob_get_clean();
//	echo $nav;
	
	if(!$ArrGoods[$start])
	{
		?>
    <div align="center" style="margin:20px 0;">
    <h3>По Вашему запросу ничего не найдено</h3>
    <span style="font-size:18px; color:#666;">измените параметры поиска</span>
    </div>
    <?
		return;
	}
		
	$n=0;
	$data = '';
	$old_group = '';
	for($i=$start; $i<($count_obj_on_page*$p); $i++)
	{
		if(!$ArrGoods[$i]) break;
		
		if($ArrGoods[$i]['rname']!=$old_group)
		{
			if($data)
			{
				if($gvid=='1')
				{
					?><table width="100%" border="0" cellpadding="0" cellspacing="5" id="metka2" class="metka2" style='width:850px; table-layout:fixed;'><?=$data?><?
					// если кол-во товаров меньше 3-x - добавляем пустые ячейки (для выравнивания)
					if($n<3)
						echo str_repeat('<td width="33%" valign="top" height="1%">&nbsp;</td>',(3-$n));
					?></table><?
				}
				else
					echo $data;
			}
			?><h3 style="margin:10px 0 10px 5px;"><?=$showtype?$ArrGoods[$i]['tname'].' &raquo; ':''?><?=$ArrGoods[$i]['rname']?></h3><?
			$n=0;
			$data = '';
		}
		
		ob_start();
			$good = getRow("SELECT * FROM {$prx}goods WHERE id='{$ArrGoods[$i]['gid']}'");
			// --------------------- ПЛИТКОЙ
			if($gvid==1)
			{
				if(++$n%3==1) echo '<tr>';	
				?><td width="33%" valign="top" height="1%"><?=gvid1($good)?></td><?
			}
			// --------------------- СПИСКОМ
			elseif($gvid=='2')
				gvid2($good);
			// --------------------- ТАБЛИЦЕЙ
			elseif($gvid=='3')
				gvid3($good);
		$data .= ob_get_clean();
		
		$old_group = $ArrGoods[$i]['rname'];
	}
	
	if($data)
	{
		if($gvid=='1')
		{
			?><table width="100%" border="0" cellpadding="0" cellspacing="5" id="metka1" class="metka1" style='width:850px;'><?=$data?><?
			// если кол-во товаров меньше 3-x - добавляем пустые ячейки (для выравнивания)
			if($n<3)
				echo str_repeat('<td width="33%" valign="top" height="1%">&nbsp;</td>',(3-$n));
			?></table><?
		}
		else
			echo $data;
		
		if($strpage)
		{
			?>
      <div class="nav" style="float:right; margin-top:5px;">
      	<div style="float:right; margin-right:20px;"><?
				$val = $all ? 'all' : ($_SESSION['count_obj_on_page']==1000 ? 'all' : ($_SESSION['count_obj_on_page']?$_SESSION['count_obj_on_page']:15));
				echo dll(array('15'=>'15','30'=>'30','60'=>'60'),'onChange="toajax(\'/show_catalog.php?action=count_obj_on_page&url='.$_SERVER['REQUEST_URI'].'&limit=\'+this.value)"',$val,array('all','все'));
				?>
				</div>
				<div style="float:right; margin:0 5px 0 0;">Товаров на странице:</div>
      	<div style="float:right; margin:1px 30px 0 20px;"><?=$strpage?></div>
      </div>
      <div style="clear:both"></div>
			<?
		}
		
		?><div style="margin:10px 0"><?=$nav?></div><?
	}
}

function gvid1($good)
{
	global $prx;
	
	$id = $good['id'];
	
	$price = showPrice($good['price'],$good['valuta'],$good['id']);
	$number_price = str_replace('<b>','',$price);
	$number_price = str_replace('</b>','',$number_price);
	$number_price = str_replace(' Р','',$number_price);
	$number_price = str_replace(' ','',$number_price);
	$number_price = (int)$number_price;
	/**@var $product Goods*/
	$product = Goods::model()->findByPk($good['id']);
	//Добавляем пробел после точек и запятых, для корректного переноса текста.
	$good['text1'] = preg_replace('/([,.;])(?=\S)/', '$1 ', $good['text1']);
	?>
	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="gvid1" style="width:276px;">
    <tr>
      <td colspan="2" style="background:url(/img/line3.gif) #F98E3C repeat-x; padding:0 10px;">
        <table><tr><td style="height:40px !important;overflow:hidden;">
        <a href="<?= $product->getUrl()?>" style="font-size:14px;"><b><?=$good['name']?></b></a>
        </td></tr></table>
      </td>
    </tr>
    <tr>
      <td width="50%" height="100%" align="center" valign="top" style="padding:10px;">
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
          <tr valign="bottom">
          <td align="center" valign="top" style="padding-bottom:10px;">
            <?
            if($good['new'])
            {
              ?><div class="new_" title="новинка"></div><?
            }
            $id_img = getField("SELECT id FROM {$prx}goods_img WHERE id_goods='{$id}' ORDER BY sort LIMIT 1");	
            ?>
            <a href="<?= $product->getUrl()?>"><img src="/uploads/goods_img/120x-/<?=$id_img?>.jpg" style="width:100px;"></a>
          </td>
          </tr>
          <tr valign="bottom">
          <td align="center">
            <?
            if($good['none'])
            {
              ?><div class="nalich" style="width:120px">снято с производства</div><?
            }
            else
            {
              ?>
              <table width="100" border="0" cellspacing="0" cellpadding="0">
                <? /*<tr>
                  <td>
                    <div class="nalich"><?=$good["nalich"]?'в наличии':'под заказ'?></div>
                  </td>
                </tr>*/?>
                <tr>
                  <td height="50" align="center" style="background-image:url(/img/price.gif); background-repeat:no-repeat;">
                    <?=$number_price>0 ? $price : "<b>Цена по<br>запросу</b>"?>
                  </td>
                </tr>
                <?
                if($number_price>0)
                {
                  ?>
                  <tr>
                    <td><?=btn('btn_cart','',"toCart({$id}, 0)",false,'100%');?></td>
                  </tr>
                  <?
                }
                ?>
              </table>
              <?
            }
            ?>
            <div style="margin:5px 0 0 0;"><i>Код:</i> <b><?=$good['kod2']?$good['kod2']:$good['kod']?></b></div>
          </td>
          </tr>
        </table>
    	</td>
    	<td valign="top" style="text-align:justify; padding:10px;height:255px;"><div style="overflow: hidden;height:255px; width:120px;"><?=$good['text1']?></div></td>
    </tr>
    <tr>
      <td colspan="2">
        <?
        $flag = false;
        foreach((array)unserialize($good['feature2']) as $val)
          if($val) { $flag = true; break;	}
        ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="5" style="height:40px !important;background-color:#E6E6E6;">
          <tr>
          <td width="<?=$flag?'33%':'50%'?>" align="center">
            <a href="/get_instruction.php?id_good=<?=$id?>" target="my2" onClick="win=window.open('','my2','resizable=yes,width=800,height=600,scrollbars=1');win.focus();">Скачать инструкцию</a>
          </td>
          <?
          if($flag) 
          { 
            ?><td width="33%" align="center"><a href="javascript:toCompare(<?=$id?>)">Сравнить</a></td><?
          }
          ?>
          <td align="center"><a href="<?= $product->getUrl()?>">Подробнее</a></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
	<?
}

function gvid2($good)
{
	global $prx;
	
	$id = $good['id'];

    /**@var $product Goods*/
    $product = Goods::model()->findByPk($good['id']);
	
	$price = showPrice($good['price'],$good['valuta'],$good['id']);
	$number_price = str_replace('<b>','',$price);
	$number_price = str_replace('</b>','',$number_price);
	$number_price = str_replace(' Р','',$number_price);
	$number_price = str_replace(' ','',$number_price);
	$number_price = (int)$number_price;
	//Добавляем пробел после точек и запятых, для корректного переноса текста.
	$good['text1'] = preg_replace('/([,.;])(?=\S)/', '$1 ', $good['text1']);


	?>
  <table width="100%" class="gvid2">
    <tr>
      <td height="40" colspan="3" style="background:#F98E3C url(/img/line3.gif); background-repeat:repeat-x; padding:0 10px;">
        <a href="<?= $product->getUrl()?>" style="font-size:14px;"><b><?=$good['name']?></b></a>
      </td>
    </tr>
    <tr>
      <td valign="top" style="padding:10px 10px 10px 0">
        <?
        if($good['new'])
        {
          ?><div class="new_" title="новинка"></div><?
        }	
        $id_img = getField("SELECT id FROM {$prx}goods_img WHERE id_goods='{$id}' ORDER BY sort LIMIT 1");	
        ?>
        <a href="<?= $product->getUrl()?>"><img src="/uploads/goods_img/120x-/<?=$id_img?>.jpg"></a>
      </td>
      <td valign="top" style="text-align:justify; padding:10px;"><?=$good["text1"]?></td>
      <td valign="top"align="center"  width="150">
        <?
        if($good['none'])
        {
          ?><div class="nalich" style="width:120px">снято с производства</div><?
        }
        else
        {
          ?>
          <table width="120" border="0" cellspacing="0" cellpadding="0">
            <? /*<tr>
              <td>
                <div class="nalich"><?=$good['nalich']?'в наличии':'под заказ'?></div>
              </td>
            </tr>*/?>
            <tr>
            <td height="51" align="center" style="background-image:url(/img/price.gif); background-repeat:no-repeat;">
              <?=$number_price>0 ? $price : "<b>Цена по<br>запросу</b>"?>
            </td>
            </tr>
            <?
            if($number_price>0)
            {
              ?>
              <tr>
                <td><?=btn('btn','<span style="font-size:18px;">Купить</span>',"toCart({$id}, 0)",false,'100%');?></td>
              </tr>
              <?
            }
            ?>
          </table>
          <?
        }
        ?>
        <div style="margin:5px 0 0 0;"><i>Код:</i> <b><?=$good['kod2']?$good['kod2']:$good['kod']?></b></div>
      </td>
    </tr>
    <tr>
      <td colspan="3" height="25" style="background-color:#E6E6E6; padding-right:10px;">
        <div style="float:right"><a href="<?= $product->getUrl()?>">Подробнее</a></div>
        <?
        $flag = false;
        foreach((array)unserialize($good['feature2']) as $val)
          if($val) { $flag = true; break;	}
        if($flag) 
        { 
          ?><div style="float:right; margin-right:50px;"><a href="javascript:toCompare(<?=$id?>)">Сравнить</a></div><?
        }
        ?>                  
        <div style="float:right; margin-right:50px;">
          <a href="/get_instruction.php?id_good=<?=$id?>" target="my2" onClick="win=window.open('','my2','resizable=yes,width=800,height=600,scrollbars=1');win.focus();">Скачать инструкцию</a>
        </div>
      </td>
    </tr>
  </table>
  <?
}

function gvid3($good)
{
	global $prx;
	
	$id = $good['id'];

    /**@var $product Goods*/
    $product = Goods::model()->findByPk($good['id']);
	
	$price = showPrice($good['price'],$good['valuta'],$good['id']);
	$number_price = str_replace('<b>','',$price);
	$number_price = str_replace('</b>','',$number_price);
	$number_price = str_replace(' Р','',$number_price);
	$number_price = str_replace(' ','',$number_price);
	$number_price = (int)$number_price;
	//Добавляем пробел после точек и запятых, для корректного переноса текста.
	$good['text1'] = preg_replace('/([,.;])(?=\S)/', '$1 ', $good['text1']);
	?>
  <table width="100%" class="gvid3">
    <tr>
      <td height="40" colspan="3" style="background:#F98E3C url(/img/line3.gif); background-repeat:repeat-x; padding:0 10px;">
        <a href="<?= $product->getUrl()?>" style="font-size:14px;"><b><?=$good['name']?></b></a>
      </td>
    </tr>
    <tr>
      <td valign="top" style="text-align:justify; padding:10px;"><?=$good['text1']?></td>
      <td valign="top" align="center" width="150" style="padding:10px;">
        <?
        if($good['new'])
        {
          ?><div class="new" title="новинка"></div><?
        }
        ?>
        <? /*<div class="nalich" style="width:120px"><?=$good['none']?'снято с производства':($good['nalich']?'в наличии':'под заказ')?></div>*/?>
        <div style="margin:5px 0 0 0;"><i>Код:</i> <b><?=$good['kod2']?$good['kod2']:$good['kod']?></b></div>
      </td>
      <td valign="top" align="center" width="120">
        <?
        if(!$good['none'])
        {
          ?>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="51" align="center" style="background-image:url(/img/price.gif); background-repeat:no-repeat;">
                <?=$number_price>0 ? $price : "<b>Цена по<br>запросу</b>"?>
              </td>
            </tr>
            <?
            if($number_price>0)
            {
              ?>
              <tr>
                <td><?=btn('btn_cart','',"toCart({$id}, 0)",false,'100%');?></td>
              </tr>
              <?
            }
            ?>
          </table>
          <?
        }
        ?>
      </td>
    </tr>
    <tr>
      <td colspan="3" height="25" style="background-color:#E6E6E6; padding-right:10px;">
        <div style="float:right"><a href="<?= $product->getUrl()?>">Подробнее</a></div>
        <?
        $flag = false;
        foreach((array)unserialize($good['feature2']) as $val)
          if($val) { $flag = true; break;	}
        if($flag) 
        { 
          ?><div style="float:right; margin-right:50px;"><a href="javascript:toCompare(<?=$id?>)">Сравнить</a></div><?
        }
        ?>                  
        <div style="float:right; margin-right:50px;">
          <a href="/get_instruction.php?id_good=<?=$id?>" target="my2" onClick="win=window.open('','my2','resizable=yes,width=800,height=600,scrollbars=1');win.focus();">Скачать инструкцию</a>
        </div>
      </td>
    </tr>
  </table>
  <?
}

// Страницы навигации
// show_navigate_pages(количество страниц,текущая,'ссылка = ?topic=news&page=')
function show_navigate_pages($x,$p,$link)
{
	if($x<2) return;

	?><div class="str_page"><?
  if($p!=1)
  {
  	?><a class="prev" href="<?=$link?>page<?=($p-1)?>.htm" title="">предыдущая</a><?
  }  
  if($x<4)
  {
		for($i=1;$i<=$x;$i++)
		{
			if($i==$p)
				echo "<span class='cur corner5'>{$i}</span>";
			else
				echo "<span>".get_href($link,$i)."</span>";
		}
  }
  if($x==4)
  {
		if($p==1) // 1
			echo "<span class='cur corner5'>".$p."</span><span>".get_href($link,$p+1)."</span><span>...</span><span>".get_href($link,$x)."</span>";
		if($p==2) // 2
			echo "<span>".get_href($link,1)."</span><span class='cur corner5'>".$p."</span><span>".get_href($link,$p+1)."</span><span>...</span><span>".get_href($link,$x)."</span>";
		if(($p-1)==2) // 3
			echo "<span>".get_href($link,1)."</span><span>...</span><span>".get_href($link,$p-1)."</span><span class='cur corner5'>".$p."</span><span>".get_href($link,$x)."</span>";
		if($p==$x) // 4
			echo "<span>".get_href($link,1)."</span><span>...</span><span>".get_href($link,$x-1)."</span><span class='cur corner5'>".$p."</span>";
  }
  if($x>4)
  {
		if($p==1) // 1
			echo "<span class='cur corner5'>1</span><span>".get_href($link,$p+1)."</span><span>...</span><span>".get_href($link,$x)."</span>";
		elseif($p==2) // 2
			echo "<span>".get_href($link,1)."</span><span class='cur corner5'>".$p."</span><span>".get_href($link,$p+1)."</span><span>...</span><span>".get_href($link,$x)."</span>";
		elseif(($p-1)==2) // 3
			echo "<span>".get_href($link,1)."</span><span>...</span><span>".get_href($link,$p-1)."</span><span class='cur corner5'>".$p."</span><span>".get_href($link,$p+1)."</span><span>...</span><span>".get_href($link,$x)."</span>";
		elseif(($x-$p)==1) // 4
			echo "<span>".get_href($link,1)."</span><span>...</span><span>".get_href($link,$p-1)."</span><span class='cur corner5'>".$p."</span><span>".get_href($link,$x)."</span>";
		elseif($p==$x) // 5
			echo "<span>".get_href($link,1)."</span><span>...</span><span>".get_href($link,$x-1)."</span><span class='cur corner5'>".$p."</span>";
		else
			echo "<span>".get_href($link,1)."</span><span>...</span><span>".get_href($link,$p-1)."</span><span class='cur corner5'>".$p."</span><span>".get_href($link,$p+1)."</span><span>...</span><span>".get_href($link,$x)."</span>";
  }
  if($p<$x)
  {
  	?><a class="next" href="<?=$link?>page<?=($p+1)?>.htm" title="">следующая</a><?
  }
  ?></div><?
}
function get_href($link,$page)
{
	ob_start();
	?><a href="<?=$link?>page<?=$page?>.htm"><?=$page?></a><?
	return ob_get_clean();
}

function show_like_goods($id,$feature1,$id_cattype)
{
	global $prx;
	
	if(!$feature1 || $feature1='N;')
		return;
		
	$feature1 = unserialize($feature1);
	$mas = array();
	
	if(!sizeof($feature1))
		return;
		
	$res = sql("SELECT * FROM {$prx}feature WHERE id_cattype='{$id_cattype}' and to_like=1 ORDER BY sort");
	while($row = mysql_fetch_array($res))
	{
		if($feature1[$row["name"]])
			$mas[$row["name"]] = $feature1[$row["name"]];
	}
	
	//print_r($mas)."<br>";
	// все параметры по данному товару,
	// учавствующие в выборе подобных товаров собраны в массив $mas
	
	$find_goods = false;
	$count_ch = sizeof($mas);
	$good_ids = array();
	
	$ids = getArr("SELECT id FROM {$prx}cattmr WHERE $id_cattype={$id_cattype}");
	$res = mysql_query("SELECT id,feature1 FROM {$prx}goods WHERE id_cattmr IN (".($ids ? implode(",",$ids) : 0).") and hide=0 ORDER BY name");
	if(@mysql_num_rows($res))
	{
		while($row = mysql_fetch_assoc($res))
		{
			if($row['id']==$id)
				continue;
			
			$feature1 = unserialize($row['feature1']);
			
			$add_good = true;
			foreach($mas as $k=>$v)
			{
				// если у текущего товара хар-ка не найдена - не выводим
				if(!$feature1[$k])
				{
					$add_good = false;
					break;
				}
				
				// иначе, если хар-ка все-таки есть
				// проверим все значения хар-ки
				foreach($feature1[$k] as $val)
				{
					// если значения тек. хар-ки не найдены в массиве $mas
					if(!in_array($val,$v))
					{
						$add_good = false;
						break 2;
					}
				}						
			}
			
			// если все характеристики соответствуют главному товару
			if($add_good)
			{
				// если в массиве уже есть 6 подобных товаров
				if(sizeof($good_ids)>5)
					break;
				else
					$good_ids[] = $row['id'];
			}
		}
	}
	
	if(sizeof($good_ids))
	{
		// выводим товары
		$ids = trim(implode(",", $good_ids),",");
		echo small_goods("SELECT * FROM {$prx}goods WHERE id IN ({$ids})",'Похожий товар');
	}
}

function show_tying_goods($ids)
{
	global $prx;
	
	echo small_goods("SELECT * FROM {$prx}goods WHERE id IN ({$ids}) and hide=0",'Сопутствующие товары');
}

function small_goods($query,$title)
{
	global $prx;
	
	ob_start();
	
	$res = mysql_query($query);
	$count_goods = @mysql_num_rows($res);
	if($count_goods)
	{
		?>
    <h3 style="margin:10px 0 5px 20px;"><?=$title?></h3>
    <table width="100%" border="0">
		<?
		$i=0;
		while($row = mysql_fetch_assoc($res))
		{
			$id = $row["id"];

            /**@var $product Goods*/
            $product = Goods::model()->findByPk($row["id"]);
			
			if(++$i%3==1) echo '<tr valign=top>';
			
			$price = showPrice($row["price"], $row["valuta"], $row["id"]);
					
			$number_price = str_replace('<b>','',$price);
			$number_price = str_replace('</b>','',$number_price);
			$number_price = str_replace(' Р','',$number_price);
			$number_price = str_replace(' ','',$number_price);
			$number_price = (int)$number_price;
			?>
            <td width="33%" height="1%" style="padding-top:10px;">
				<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="40" style="background:#f98e3c url(/img/line3.gif); background-repeat:repeat-x; padding:0 10px;">
                        <a href="<?= $product->getUrl()?>" style="font-size:14px;"><b><?=$row["name"]?></b></a>
                    </td>
                  </tr>
                  <tr valign="top">
                    <td style="height: 110px;">
                      <table cellpadding="0" cellspacing="0" width="100%"><tr valign="middle">
                        <td width="150" align="center">
                        	<?	
    						$id_img = getField("SELECT id FROM {$prx}goods_img WHERE id_goods='{$id}' ORDER BY sort LIMIT 1");	
    						?>
    						<a href="<?= $product->getUrl()?>"><img src="/uploads/goods_img/80x-/<?=$id_img?>.jpg" border="1"></a>
                        </td>
                        <td align="left" style="padding:0px;padding-top:5px;">
                            <?
    						if($row['text4']!='')
    							echo "<div style='overflow:hidden;height:150px;'>".$row['text4']."</div>";
    						?>
                        	<div style="background:url(/img/price.gif) no-repeat top right;height:50px;text-align: right;margin-top:3px;">
    							<div style="padding: 20px 40px 0px 0px;"><?=$number_price>0 ? $price : "<b>Цена по<br>запросу</b>"?></div>
                            </div>
                        </td>
                      </tr></table>
                    </td>
                  </tr>
                  <tr valign="top">
                  	<td>
                      <table width="100%" cellpadding="0" cellspacing="0">
                       <tr>
                            <td align="left" style="padding-left:10px; background-color:#E6E6E6;"><a href="#" onClick="toCart(<?=$id?>,1);return false;">включить в заказ</a></td>
                            <td height="22" align="right" style="padding-right:10px; background-color:#E6E6E6;"><a href="<?= $product->getUrl()?>">подробнее</a></td>
                       </tr>
                      </table>  
                    </td>
                  </tr>
                </table>
            </td>
            <?
		}
		if($count_goods<3)
			echo str_repeat('<td width="33%" height="1%" style="padding-top:10px;">&nbsp;</td>',(3-$count_goods));
		?></table><?
	}
	
	return ob_get_clean();
}
	
	// БЫСТРЫЙ ПЕРЕХОД
	function getDllQuickMove($dll)
	{
		global $prx, $id_cattype, $id_catmaker, $link;
		switch(strtolower($dll))
		{
			case "type":
				return dll("SELECT id,name FROM {$prx}cattype WHERE status=1 ORDER BY name", 'name="id_cattype" onChange=toajax(\'/quick_move.php?id_cattype=\'+this.value+\'&action=getMaker\')', $id_cattype, "-- тип оборудования --");
			case "maker":
				return dll("SELECT DISTINCT m.id, m.name 
								FROM {$prx}catmaker AS m
									INNER JOIN {$prx}cattmr AS tmr ON tmr.id_catmaker = m.id
								WHERE tmr.id_cattype = '{$id_cattype}' AND m.hide='0'
								ORDER BY m.sort", 
							  'name="id_catmaker" onChange=toajax(\'/quick_move.php?id_cattype='.$id_cattype.'&id_catmaker=\'+this.value+\'&action=getGoods\')', $id_catmaker, "-- производитель --");
			case "goods":
				ob_start();
				$query = "SELECT r.name as razdel,g.link, g.name 
								FROM {$prx}goods AS g
									INNER JOIN {$prx}cattmr AS tmr ON tmr.id = g.id_cattmr
									INNER JOIN {$prx}catrazdel AS r ON r.id = tmr.id_catrazdel
								WHERE tmr.id_cattype = '{$id_cattype}' AND tmr.id_catmaker = '{$id_catmaker}' AND g.hide=0 AND r.hide=0
								ORDER BY r.name,g.name";
				$res = mysql_query($query);
				?>
				<select name="link">
					<option value="">-- оборудование --</option>
				<?
				$old_razdel = '';
				while($arr = @mysql_fetch_assoc($res))
				{
					$razdel = $arr['razdel'];
					if($razdel!=$old_razdel)
					{
						?><optgroup label="<?=$razdel?>" style="font-style:normal;"><?
					}
					else
					{
						?></optgroup><?
					}						
					?>
					<option value="<?=$arr['link']?>" style="padding-left:10px;"><?=$arr['name']?></option>
					<?					
					$old_razdel = $razdel;
				}
				?>
				</select>
				<?
					
				return ob_get_clean();
			
				/*return dll("SELECT g.link, g.name 
								FROM {$prx}goods AS g
									INNER JOIN {$prx}cattmr AS tmr ON tmr.id = g.id_cattmr
									INNER JOIN {$prx}catrazdel AS r ON r.id = tmr.id_catrazdel
								WHERE tmr.id_cattype = '{$id_cattype}' AND tmr.id_catmaker = '{$id_catmaker}' AND g.hide=0 AND r.hide=0
								ORDER BY g.name", 
							  'name="link"', $link, "-- оборудование --");*/
		}
	}
	
	function showQuickMove()
	{
		global $prx;
		ob_start();
		?>
		<style> div.divQM div select { width:100%; margin:2px 0 2px 0; } </style>
		<form action="/quick_move.php" id="quick_frm" target="ajax">
        
			<div style="font-size:14px;"><b><i>БЫСТРЫЙ ПЕРЕХОД</i></b></div>
			<div style="padding:10px 0 10px 0;" class="divQM">
				<div><?=getDllQuickMove("type")?></div>
				<div id="dllMaker"><?=getDllQuickMove("maker")?></div>
				<div id="dllGoods"><?=getDllQuickMove("goods")?></div>
			</div>
			<div align="right" style="margin-right:-10px;"><?=btn('btn2','Показать',"get('quick_frm').submit()",false,'110px')?></div>
			<input type="hidden" name="action" value="move">
		</form>
		<?	
		return ob_get_clean();
	}

// ВЫБОР ПРОИЗВОДИТЕЛЯ
function showQuickGo()
{
	global $prx, $catmaker, $cattype;
	
	if(!$cattype) return;
	if(!$ids_maker = getArr("SELECT DISTINCT id_catmaker FROM {$prx}cattmr WHERE id_cattype={$cattype['id']}")) return;

	ob_start();
	?>
  <div style="font-size:14px;"><b><i>ВЫБОР ПРОИЗВОДИТЕЛЯ</i></b></div>
  <div style="margin:10px 0 10px 0"><?=dll("SELECT id,name FROM {$prx}catmaker WHERE id IN(".implode(',',$ids_maker).") ORDER BY sort,id", 'id="smaker" style="width:100%" size="5"',$catmaker['id'],'')?></div>
	<div align="right" style="margin-right:-10px;"><?=btn('btn2','Показать',"smaker({$cattype['id']},jQuery('#smaker').val())",false,'110px')?></div>
	<?
	return ob_get_clean();
}

// БЫСТРЫЙ ЗАКАЗ
function showFastOrder($id,$name)
{
	global $prx;
	ob_start();
	?>
  <script>
	function sh_order_info(obj)
	{
		var nav = userNavigator();
		display = (nav=='isIE' ? "block" : "table-row");
		$form = jQuery('#fast_order_frm');
		
		switch(obj.value)
		{
			case "Юридическое лицо":
				if(obj.checked==true)
				{
					get('order_details').style.display = display;
					$form.find('input[name="payment"]').eq(0).attr('disabled',true);
					$form.find('input[name="payment"]').eq(1).attr('checked',true);
				}
				break;
			case "Физическое лицо":
				if(obj.checked==true)
				{
					get('order_details').style.display = 'none';
					$form.find('input[name="payment"]').eq(0).attr('disabled',false);
				}
				break;
		}
	}
	</script>
  <style>
	input { border:expression(this.type=='radio' ? 'none' : '1px solid #666666'); }
	</style>
	<form id="fast_order_frm" action="/fast_order.php" method="post" target="ajax">
    <input type="hidden" name="good" value="<?=$id?>">
    <table class="fast_order" border="0">
      <tr><th style="padding-left:10px;">Заказываемое оборудование:</th></tr>
      <tr><td style="padding-bottom:10px;"><b><?=$name?></b></td></tr>
      <tr><th style="padding-left:10px;">Количество: <span class="z">*</span></th></tr>
      <tr><td><input type="text" name="kol" style="width:40px;" value="1"></td></tr>
      
      <tr><td style="padding-top:10px;">
      	<table class="common" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%">
            	<table>
                  <tr><td colspan="2" style="font-style:italic;">Тип клиента:</td></tr>
                  <tr>
                    <th width="20" valign="top" style="vertical-align:top;"><input type="radio" name="lich" value="Юридическое лицо" style="border:none;" checked onClick="sh_order_info(this)"></th>
                    <td style="font-style:italic; font-size:11px; padding-left:5px;">Юридическое лицо</td>
                  </tr>
                  <tr>
                    <th valign="top"><input type="radio" name="lich" value="Физическое лицо" onClick="sh_order_info(this)"></th>
                    <td style="font-style:italic; font-size:11px; padding-left:5px;">Физическое лицо</td>
                  </tr>
                </table>
            </td>
            <td width="50%">
            	<table>
                  <tr><td colspan="2" style="font-style:italic;">Способ оплаты:</td></tr>
                  <tr>
                    <td width="20" valign="top"><input type="radio" name="payment" value="наличный" disabled></td>
                    <td style="font-style:italic; font-size:11px; padding-left:5px;">наличный</td>
                  </tr>
                  <tr>
                    <td valign="top"><input type="radio" name="payment" value="безналичный" checked></td>
                    <td style="font-style:italic; font-size:11px; padding-left:5px;">безналичный</td>
                  </tr>
                </table>
            </td>
          </tr>
        </table>
      </td></tr>
      
      <tr><th style="padding-top:10px;">Контактный телефон: <span class="z">*</span></th></tr>
      <tr><td><input type="text" name="phone"></td></tr>
      <tr><th>E-mail: <span class="z">*</span></th></tr>
      <tr><td><input type="text" name="mail"></td></tr>
      <tr><th>
      	Дополнительная информация:<br>
        <span style="font-size:10px;">(адрес доставки, комментарий и т.д.)</span>
      </th></tr>
      <tr><td><textarea name="info"></textarea></td></tr>
      <tr id="order_details"><th style="padding-top:10px;">
      	Реквизиты: <span class="z">*</span><br>
		<span style="font-size:10px;">Внимание! Реквизиты должны включать следующую информацию:<br>
		Название организации с организационной формой, ИНН/КПП, Юридический адрес, Банковские реквизиты (р/с, название банка, БИК, корр/сч.), Код ОКПО</span><br>
		<textarea name="details" style="margin-top:5px;"></textarea>
      </th></tr>
      <tr><th>Способ связи:</th></tr>
      <tr><td valign="top">	
      	<table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="text-align:left; padding:0;"><input type="radio" name="sv" value="телефон" checked style="width:auto;"></td>
            <td style="text-align:left; padding:0 10px 0 5px;">телефон</td>
            <td style="text-align:left; padding:0;"><input type="radio" name="sv" value="e-mail" style="width:auto;"></td>
            <td style="text-align:left; padding:0 10px 0 5px;">e-mail</td>
          </tr>
        </table>
      </td></tr>
        <tr>
            <td>
<!--                <div class="g-recaptcha" data-sitekey="6Ld2zhQUAAAAAO-xXQV-AI6KJXPRbJosPUTw_ngn"></div>-->
                <div id="google-captcha-1"></div>
            </td>
        </tr>
<!--      <tr><th style="padding-top:10px;">Введите число: <span class="z">*</span></th></tr>-->
<!--        -->
<!--      <tr>-->
<!--      	<td style="padding-left:30px;">-->
<!--      		<img id="captcha" src="/inc/advanced/antirobot/antirobot.php" align="left">-->
<!--            <input type="text" name="kod" style="width:50">-->
<!--            <a href="" target="ajax" onclick="update_captcha();return false;">не видно символы на картинке</a>-->
<!--      	</td>-->
<!--      </tr>-->
      <tr><td style="padding:0 5px 5px 0;">
      <div align="right"><?=btn('btn','Отправить',"get('fast_order_frm').submit()",false,'110px')?></div>
      </td></tr>
    </table>
	</form>
	<?	
	return ob_get_clean();
}

// ЗАКАЗАТЬ ЗВОНОК + ЗАДАТЬ ВОПРОС
function show_call_frm($question=false, $params = array())
{
	global $row;
	?>
  <form action="/call.php?action=send" method="post" target="ajax" id="frm<?=$question?'Quest':'Call'?>">
  <?
	if($question)
	{
		?>
		<input type="hidden" name="gid" value="<?=$row['id']?>">
		<input type="hidden" name="question">
    <?
	}
	?>
  <style>
  table.order {
    width:650px;
  }
  table.order th {
    text-align:right;
    white-space:nowrap;
    width:210px;
  }
  table.order td input {
    width:50%;
  }
  table.order td input[type="radio"] {
    width:auto;
  }
  table.order td textarea {
    width:100%;
    height:100px;
  }
  table.order td {
    width:100%;
  }
  .rz {
    font-size:14px;
    color:#F00;
  }
  </style>
  <table class="order" id="tblPhys">
    <tr>
      <th>ФИО: <span class="rz">*</span></th>
      <td><input type="text" name="name"></td>
    </tr>
    <tr>
      <th>Телефон (с кодом города): <span class="rz">*</span></th>
      <td><input type="text" name="phone"></td>
    </tr>
    <?
		if($question)
		{
			?>
			<tr>
				<th>E-mail: <span class="rz">*</span></th>
				<td><input type="text" name="mail"></td>
			</tr>
      <?
		}
		?>
    <tr>
      <th>Вопрос: <span class="rz">*</span></th>
      <td><textarea name="notes"></textarea></td>
    </tr>
      <!--<tr>

      <th>Введите число: <span class="rz">*</span></th>
      <td>
        <img id="captcha" src="/inc/advanced/antirobot/antirobot.php?sp=<?/*=$question?'quest':'call'*/?>" align="left">
        <input type="text" name="kod" style="width:50">
      </td>
    </tr>-->
      <tr>
          <th></th>
          <td>
              <div id="google-captcha-<?=($params['captcha-index'])?$params['captcha-index']:1?>"></div>
          </td>
      </tr>
    <tr>
      <td colspan="2" align="center"><br>
      <?=btn('btn','отправить',"jQuery('#frm".($question?'Quest':'Call')."').submit()",false,'100px')?>
      </td>
    </tr>
  </table>

  </form>
  <div style="padding:10px;">Поля, отмеченные <span class="rz">*</span> - обязательны для заполнения!</div>
  <?
}
	
function btn($class,$text,$onclick='',$curent=false,$width)
{
	ob_start();
	
	if($width)
		$width = "width:{$width}";
	
	if(!$curent)
	{
		?>
		<table class="<?=$class?>" style="<?=$width?>" cellspacing="0" cellpadding="0" onMouseOver="this.className='<?=$class?>_cur'" onMouseOut="this.className='<?=$class?>'" onClick="<?=$onclick?>">
		  <tr><td align="center"><?=$text?></td></tr>
		</table>
		<?
		return ob_get_clean();
	}
	else
	{
		?>
		<table class="<?=$class?>_cur" cellspacing="0" style="cursor:default; <?=$width?>">
		  <tr><td><?=$text?></td></tr>
		</table>
		<?
		return ob_get_clean();
	}
}

function show_bl($pol,$text,$img,$sort)
{
    ?>
        <div style="float: left;border:0px solid black">
           <div style="float: left;"><img src="../img/paging/lev1.gif" width="2" height="26" /></div>
           <div style="font-size: 10px;font-family: Tahoma;padding:8px 5px 0px 5px;font-weight: bold; float: left;background: url('/img/paging/fon<?=$pol=='act'?'2':'1'?>.gif') repeat-x; height: 18px; <?=$pol=='act'?'color:#fff':'color:#000'?>;cursor:pointer" onclick="RegSessionSort('<?=$_SERVER['REQUEST_URI']?>','/inc/session_sort.php?vid_goods=<?=$sort?>')"><img src="/img/sort/<?=$img?><?=$pol=='act'?'_1':''?>.gif" style="margin-right: 5px;" /><span style="position: relative;top:-3px;left:0px"><?=$text?></span></div>
           <div style="float: left;"><img src="../img/paging/r1.gif" width="2" height="26" /></div>
           <div style="clear: both;"></div>
        </div>   
    <?
}

function show_block_sort($p,$x,$id_cat,$set_good,$go)
{

  // print_r($_SESSION);
  //  print_r($_SESSION['vid_goods']);
    $link="/cat_{$id_cat}/page-%s.htm";
    
    global $prx,$db;
    $sorti=@$_SESSION['gvid']?$_SESSION['gvid']:'plit';
    ?>
      <div style="margin: 20px 10px;">
       <div style="border: 0px solid #F67006;height: 26px;">
         <?
              /* if ($sorti=='categ') $pol='act'; else $pol=''; 
               echo show_bl($pol,'по категориям','1','categ');
                */
               if ($sorti=='plit') $pol='act'; else $pol='';
               echo show_bl($pol,'плиткой','2','plit');

               if ($sorti=='spis') $pol='act'; else $pol='';
               echo show_bl($pol,'списком','3','spis');

               if ($sorti=='tbl') $pol='act'; else $pol='';
               echo show_bl($pol,'таблицей','4','tbl');
         ?> 
          <div style="clear: left;"></div>
        </div> 
        <div style="height: 28px;background: #f67006;clear: both;">
          <div style="float: left;margin:5px 15px">
              <span style="color: #fff;font-size: 10px;font-weight: bold;">Сортировка</span> 
              <select onchange="RegSessionSort('<?=$_SERVER['REQUEST_URI']?>','/inc/session_sort.php?sort='+ this.value)">
                 <option value="name ASC" <?=$_SESSION['sort']=='name ASC'?'selected':''?> >По алфавиту (по возрастанию)</option>
                 <option value="name DESC" <?=$_SESSION['sort']=='name DESC'?'selected':''?>>По алфавиту (по убыванию)</option>
                 <option value="price ASC" <?=$_SESSION['sort']=='price ASC'?'selected':''?>>По цене (по возрастанию)</option>
                 <option value="price DESC" <?=$_SESSION['sort']=='price DESC'?'selected':''?>>По цене (по убыванию)</option>
              </select>
         </div> 

       <?
         if ($go==1) {
       ?>  
         <div style="float: left;margin:5px 15px">
              <span style="color: #fff;font-size: 10px;font-weight: bold;">Товаров на странице</span> 
              <?
               $mass=array(5=>5,10=>10,20=>20,40=>40,80=>80);
               echo dll($mass,"name='sel_col' onchange=\"RegSessionSort('','/inc/session_sort.php?count_goods='+ this.value)\"",$set_good); 
              ?>
         </div>
         
         <div style="float: right; margin: 3px;">
           <?=show_navigate_pages($x,$p,$link)?>
         </div> 
         <div style="clear: both;"></div>
       <?}?>  

        </div>
      </div>
    <?
}


function btn_catalog($class,$text,$onclick='',$curent=false,$width)
{
	ob_start();
	
	if($width)
		$width = "width:{$width}";
	
	if(!$curent)
	{
		?>
		<table class="<?=$class?>" style="<?=$width?>" cellspacing="0" cellpadding="0" onMouseOver="this.className='<?=$class?>_cur'" onMouseOut="this.className='<?=$class?>'" onClick="<?=$onclick?>">
		  <tr><td><?=$text?></td></tr>
		</table>
		<?
		return ob_get_clean();
	}
	else
	{
		?>
		<table class="<?=$class?>_cur" cellspacing="0" style="cursor:default; <?=$width?>">
		  <tr><th></th><td><?=$text?></td></tr>
		</table>
		<?
		return ob_get_clean();
	}
}

function show_up_menu()
{
	global $prx;
	
	ob_start();
	
	?>
  <script>
	function showMenu(obj,id)
	{
		var _div = get('tblMenu').getElementsByTagName('DIV');
		for(var i=0; i < _div.length; i++)
			if(_div[i].id == 'menu'+id)
			{
				_div[i].style.left = absPosition(obj).x + 1 + 'px';
				_div[i].style.top = absPosition(obj).y + 42 + 'px';
				_div[i].style.display = 'block';
			}
			else
				_div[i].style.display = 'none';
	}
	</script>
	<table height="100%" id='tblMenu' align="center" cellpadding="0" cellspacing="0">
      <tr>
      <?	
      $res = sql("SELECT id,name,status FROM {$prx}cattype ORDER BY sort");
      while($row = mysql_fetch_array($res)) 
      {
		  if(!$row['status']) continue;
          /**@var $category Cattype*/
          $category = Cattype::model()->findByPk($row['id']);
          ?>
          <td style="padding:0 2px 0 2px;" onMouseOver="showMenu(this,<?=$row['id']?>)">
              <?=btn('btn',$row['name'],"location.href='{$category->getUrl()}'",false,false)?>
              <!-- выпадающее меню -->
              <div style="border:1px solid #666666; position:absolute; display:none; background-color:#FFF;" id="menu<?=$row['id']?>" onMouseOut="this.style.display='none';">
              <table cellspacing="15">
                  <tr valign="top">
                  <?	
                  foreach(array("maker","razdel") as $cat) 
                  { 
                      ?>
                      <td nowrap>
                      <?	
                      $res1 = sql("SELECT DISTINCT c.id, c.name
                                          FROM {$prx}cattmr AS tmr
                                              INNER JOIN {$prx}cat{$cat} AS c ON tmr.id_cat{$cat} = c.id
                                          WHERE tmr.id_cattype='{$row['id']}'
                                          ORDER BY c.sort");
                      while($row1 = mysql_fetch_array($res1)) 
                      {	
                          ?><a href="/type<?=$row["id"]?>/<?=$cat.$row1["id"]?>/" class="r1"><?=$row1["name"]?></a><br><?	
                      }	
                      ?>
                      <a href="/type<?=$row["id"]?>/" class="r1">Все</a><br>
                      </td>
                      <?	
                  }	
                  ?>
                  </tr>
              </table>
              </div>
          </td>
          <?	
      }	
      ?>
      </tr>
	</table>
  <?
	
	return ob_get_clean();
}

// КОРЗИНА
function show_cart()
{
	global $prx;
	
	$count_goods = 0;
	foreach((array)$_SESSION['cart']['goods'] as $id=>$kol)
		$count_goods += $kol;
		
	//if($count_goods)
	{
		?>
	
 	    <div id="cart" align="center">
           <div style='text-align:center'><img src="/img/cart/cart.png" /></div>
           <div style='overflow: hidden;margin-left:50px;height:45px;'>
              <div style="float: left;color:#fff;font-weight: bold;">
               <div align="center" style="text-align: center;"><span id="cart_count"><?=$count_goods?></span></div>
               <div><img src="/img/cart/shop.png" width="38" height="29" onclick="location.href='/cart.php'" style="cursor: pointer;" title="Перейти в корзину" /></div>
             </div>
             <div style="float: left;color:#fff;font-weight: bold;margin-top:15px;padding-left:8px;">
               <span id="cart_itogo"><?=number_format($_SESSION['cart']['itogo'],0,',',' ')?> р</span>
             </div>   
         </div>
          <div align="left" style="padding-bottom: 3px;margin-top:28px;"><img src="/img/cart/order.png" onmouseover="this.src='/img/cart/order_act.png'" onmouseout="this.src='/img/cart/order.png'" onclick="location.href='/cart.php'" /></div>
      </div>  
		<?
	}
}

function getItogo()
{
	global $prx;
	
	$itogo = 0;
	if($_SESSION['cart']['goods'])
	{
		foreach($_SESSION['cart']['goods'] as $id=>$kol)
		{
			$good = getRow("SELECT price,valuta FROM {$prx}goods WHERE id={$id}");
			
			$price = showPrice($good['price'],$good['valuta']);
			$price = str_replace('<b>','',$price);
			$price = str_replace('</b>','',$price);
			$price = str_replace(' Р','',$price);
			$price = str_replace(' ','',$price);
			
			$itogo += $kol * $price;
		}
	}	
	return $itogo;
}

function show_cont()
{
  global $prx;
  ?>
    <table style="margin-top: 20px;width:585px;" cellpadding="0" cellspacing="0" width="100%">
      <tr valign="middle">
       <td style="padding-left: 80px;width:100%" align="left"><a href="/"><img src="/img/logo.gif" width="195" height="57" /></a></td>
       <td style="padding-left: 25px;" nowrap>
        <div class="head_text">Позвоните прямо сейчас!</div>
        <div class="head_phone"><b style="font-size:21px;"><?=preg_replace('/(\([0-9]+\))/','<span style="font-size:14px;">\\1</span>',nl2br(set("phone")));?></b></div>
        <div class="head_text">Не смогли дозвониться?</div>
        <div><a href="/call.php" class="call_order">Закажите звонок</a></div> 
       </td> 
       <td style="font-size: 12px;font-weight: bold;padding-left:25px;" nowrap>
          <div style="margin-bottom:5px;">
            <img src="/img/cont/email.gif" style="margin-right: 5px;position:relative;top:5px;" /><?=set("email_site")?>
          </div>
          <div style="margin-bottom:5px;">
            <img src="/img/cont/icq.gif" style="margin-right: 5px;position:relative;top:5px;" /> <?=set("icq")?>
          </div>
          <div>
            <img src="/img/cont/skype.gif" style="margin-right: 5px;position:relative;top:5px;" /> <?=set("skype")?>
          </div>
       </td>
      </tr>
      <tr><td colspan="3" style="padding-left: 80px;padding-top:20px;">
          <!--div class="yandexform" onclick="return {'bg': '#ffcc00', 'language': 'ru', 'encoding': '', 'suggest': true, 'tld': 'ru', 'site_suggest': true, 'webopt': false, 'fontsize': 12, 'arrow': true, 'fg': '#000000', 'logo': 'rb', 'websearch': false, 'type': 2}"><form method="get"><input type="hidden" name="searchid" value="1856091"/><input name="text"/><input type="submit" value="Найти"/></form></div><script type="text/javascript" src="http://site.yandex.net/load/form/1/form.js" charset="utf-8"></script-->
          <!--div class="yandexform" onclick="return {'bg': '#F98E3C', 'language': 'ru', 'encoding': '', 'suggest': false, 'tld': 'ru', 'site_suggest': false, 'webopt': false, 'fontsize': 13, 'arrow': false, 'fg': '#000000', 'logo': 'ww', 'websearch': false, 'type': 2}"-->
			<form method="get" action="/index.php" style='background-color:#FE7901;padding:3px;width:490px;' >
				<input type="hidden" name="searchid" value="1856091"/>
				<input name="text" value="<?=strip_tags($_GET['text'])?>" style="background-image:none;width:420px;" />
				<input type="submit" value="Найти"/>
			</form>
		  </div>
		  <!--script type="text/javascript" src="http://site.yandex.net/load/form/1/form.js" charset="utf-8"></script-->
          <div class="head_text" style="margin-top: 5px;"><?=set('search_str')?></div>      
      </td></tr>
    </table>
  <?  
}

function show_otr()
{
	global $prx;
	
	$res = mysql_query("SELECT * FROM {$prx}otr WHERE id_gr='{$_SESSION['group']}' AND status=1 ORDER BY sort,id");
	if(@mysql_num_rows($res))
	{
		?>
    <div id="otr" style="background: url('/img/fon_sh.gif') repeat-x;">
       <div><img src="/img/menu/left.jpg" width="11" height="29" /></div>
			<?
      while($row = mysql_fetch_assoc($res))
      {
				$gl = $row['name']=='Средства связи' ? true : false;
				$link = $gl ? '/' : "/otrasl{$row['id']}/";
        ?><div class='in'><?=btn('btn',$row['name'],"location.href='{$link}'",false,false)?></div><?
      }
		?>
        <div style="float: right;"><img src="/img/menu/right.jpg" width="80" height="29" /></div> 
       <div style="overflow: hidden;position:absolute;top:5px;right:-20px;cursor:pointer;"><img id="operator" title="Задать вопрос" src="/img/operator.png" /></div> 
     </div>
     <?
	}
}


function shapka_leftpart()
{
    
}

function shapka_rightpart()
{
    
}

function show_pages()
{
 global $prx;
	$res = sql("SELECT link,name FROM {$prx}pages WHERE top='1' ORDER BY sort");
	$count = @mysql_num_rows($res);
	if($count)
	 {
		?><table cellpadding="0" cellspacing="0"><tr><td><img src="/img/menu/left_p.jpg" width="76" height="29" /></td><?
        while($row = mysql_fetch_array($res))
		{
 		 $active = false;
		 if($row['link']==$_SERVER['REQUEST_URI'])
		 $active = true;
								
		 ?>
          <td style="padding:5px 5px 3px 5px;background: url('/img/menu/bg_p.jpg') repeat-x;" nowrap><a href="<?=$row['link']?>" class="page_link<?=$active?'_cur':''?>"><?=$row['name']?></a></td>
         <?
		}
		?><td><img src="/img/menu/right_p.jpg" width="10" height="29" /></td></tr></table><?
	}
}

function show_catalog()
{
	global $prx, $id_cattype, $id_catmaker, $id_catrazdel, $id_catsr, $otr;
	
	$ids_otr = getArr("SELECT id FROM {$prx}otr WHERE id_gr='{$_SESSION['group']}'");
	
	$resType = mysql_query("SELECT id,name FROM {$prx}cattype WHERE status=1".($otr?" and id_otr='{$otr['id']}'":" and id_otr IN (".($ids_otr?implode(',',$ids_otr):'0').")")." ORDER BY sort,id");
	while($rowType = @mysql_fetch_assoc($resType))
	{
        /**@var $category Cattype*/
        $category = Cattype::model()->findByPk($rowType['id']);
	    ?>
		<div style="margin:0px 0 1px 0">
		<?=btn('btn_catalog',$rowType['name'],"location.href='{$category->getUrl()}'",$id_cattype==$rowType['id']?true:false,"200px")?>
		</div>
		<?

		if($rowType['id']==$id_cattype)
		{

		    $resRazdel = sql("SELECT DISTINCT B.id, B.name FROM {$prx}cattmr tmr
												INNER JOIN {$prx}catrazdel B ON tmr.id_catrazdel = B.id
												WHERE tmr.id_cattype='{$rowType['id']}' and B.hide=0 
												ORDER BY B.sort,B.id");
			while($rowRazdel = @mysql_fetch_assoc($resRazdel))
			{
                /**@var $section Catrazdel*/
                $section = Catrazdel::model()->findByPk($rowRazdel['id']);
			    if ($rowRazdel['id']==$id_catrazdel)
                {
                    ?><div class="catRazdel<?=$rowRazdel['id']==$id_catrazdel?'_cur':''?>" ><a class="categ" href="<?= $category->getUrlWithSection($section)?>" title='Категория "<?=htmlspecialchars($rowRazdel['name'])?>"'><?=$rowRazdel['name']?></a></div><?
				}
                else
                {
                    ?><div class="catRazdel<?=$rowRazdel['id']==$id_catrazdel?'_cur':''?>" onMouseOver="this.className='catRazdel_cur'" onMouseOut="this.className='catRazdel'"><a class="categ" href="<?= $category->getUrlWithSection($section)?>" title='Категория "<?=htmlspecialchars($rowRazdel['name'])?>"'><?=$rowRazdel['name']?></a></div><?
                }

				if($rowRazdel['id']==$id_catrazdel)
				{
					$resMaker = sql("SELECT DISTINCT B.id, B.name, tmr.id tmrID FROM {$prx}cattmr AS tmr
													INNER JOIN {$prx}catmaker B ON tmr.id_catmaker = B.id
													WHERE tmr.id_cattype='{$rowType['id']}' AND tmr.id_catrazdel='{$rowRazdel['id']}' AND B.hide=0
													 AND tmr.hide = 0
													ORDER BY B.name");
					while($rowMaker = @mysql_fetch_assoc($resMaker))
					{
                        /**@var $vendor Catmaker*/
					    $vendor = Catmaker::model()->findByPk($rowMaker['id'])
					    ?><div class="catMaker"><a href="<?= $category->getUrlWithVendorAndSection($vendor, $section)?>" title='Производитель "<?=htmlspecialchars($rowMaker['name'])?>"'><?=$rowMaker['name']?></a></div><?
						
						if($rowMaker['id']==$id_catmaker)
						{
							$tmr = getRow("SELECT id,hg,sr FROM {$prx}cattmr WHERE id='{$rowMaker['tmrID']}'");
							// если hg=0 (отображать товары)
							
                            if(!$tmr['hg'])
							{
								// по сериям
								if($tmr['sr'])
								{
									$resSr = mysql_query("SELECT id,name FROM {$prx}catsr WHERE id_cattmr='{$tmr['id']}' and hide=0 ORDER BY sort,id");
									while($rowSr = @mysql_fetch_assoc($resSr))
									{
										?><div class="catSr"><a href="/type<?=$rowType['id']?>/maker<?=$rowMaker['id']?>/razdel<?=$rowRazdel['id']?>/sr<?=$rowSr['id']?>/" title='Серия "<?=htmlspecialchars($rowSr['name'])?>"'><?=$rowSr['name']?></a></div><?
										

									}
								}

							} // if(!$tmr['hg'])
						} // if($rowMaker['id']==$id_catmaker)
						else
						{
							$tmr = getRow("SELECT id,hg,sr FROM {$prx}cattmr WHERE id='{$rowMaker['tmrID']}'");
							// если hg=0 (отображать товары)
                            if(!$tmr['hg'])
							{
								ob_start();
								// по сериям
								if($tmr['sr'])
								{
									$resSr = mysql_query("SELECT id,name FROM {$prx}catsr WHERE id_cattmr='{$tmr['id']}' and hide=0 ORDER BY sort,id");
									while($rowSr = @mysql_fetch_assoc($resSr))
									{
										?><div class="catSr"><a href="/type<?=$rowType['id']?>/maker<?=$rowMaker['id']?>/razdel<?=$rowRazdel['id']?>/sr<?=$rowSr['id']?>/" title='Серия "<?=htmlspecialchars($rowSr['name'])?>"'><?=$rowSr['name']?></a></div><?
									}
								}
								// товары без привязки к сериям


								
								if($data = ob_get_clean())
								{
									?><div class="catSrGroup"><?=$data?></div><?
								}
							}
						}
					} // while($rowMaker = @mysql_fetch_assoc($resMaker))
				} // if($rowMaker['id']==$id_catmaker)
				else
				{
					$resMaker = sql("SELECT DISTINCT B.id, B.name, tmr.id tmrID FROM {$prx}cattmr AS tmr
													INNER JOIN {$prx}catmaker B ON tmr.id_catmaker = B.id
													WHERE tmr.id_cattype='{$rowType['id']}' AND tmr.id_catrazdel='{$rowRazdel['id']}' AND B.hide=0 
													&& tmr.hide = 0
													ORDER BY B.name");
					if(@mysql_num_rows($resRazdel))
					{
						?><div class="catMakerGroup"><?
						while($rowMaker = @mysql_fetch_assoc($resMaker))
						{
							/**@var $vendor Catmaker*/
						    $vendor = Catmaker::model()->findByPk($rowMaker['id']);
						    ?><div class="catMaker"><a href="<?= $category->getUrlWithVendorAndSection($vendor, $section)?>" title='Производитель "<?=htmlspecialchars($rowMaker['name'])?>"'><?=$rowMaker['name']?></a></div><?
						}
						?></div><?
					}
				}
			} // while($rowRazdel = @mysql_fetch_assoc($resRazdel))
		} // if($rowType['id']==$id_cattype)
		else
		{
			$resRazdel = sql("SELECT DISTINCT B.id, B.name FROM {$prx}cattmr tmr
												INNER JOIN {$prx}catrazdel B ON tmr.id_catrazdel = B.id
												WHERE tmr.id_cattype='{$rowType['id']}' and B.hide=0 
												ORDER BY B.sort,B.id");
			if(@mysql_num_rows($resRazdel))
			{
				?><div class="catRazdelGroup"><?
				while($rowRazdel = @mysql_fetch_assoc($resRazdel))
				{
					/**@var $section Catrazdel*/
				    $section = Catrazdel::model()->findByPk($rowRazdel['id']);
				    ?><div class="catRazdel"><a href="<?= $category->getUrlWithSection($section)?>" title='Категория "<?=htmlspecialchars($rowRazdel['name'])?>"'><?=$rowRazdel['name']?></a></div><?
				}
				?></div><?
			}
		}
	}
}

function show_footer()
{
	global $prx;
	
	ob_start();
	
	?>
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr valign="bottom">
       <td width="100%">
         <table width="100%" cellpadding="0" cellspacing="0">
           <tr>
             <td width="4px"><img src="/img/footer/left.gif" width="4" height="38" /></td>
             <td style="background: #1280AC;">
              <div style="overflow: hidden;"> 
               <!--form action="/search.php" action="get">
			   
                <input type="hidden" name="site_search" value="1" />
                <div style="float: right;width:200px" align="right"><a style="color: #fff;position:relative;top:-5px;" href="javascript:void(0)" onclick="window.scrollTo(0,0)">Вверх страницы<img style="margin-left: 10px;margin-right:5px;position:relative;top:5px;" src="/img/footer/up.gif" width="20" height="22" /> </a></div>
                <div style="float: right;margin-right:20px;">
                </div>
                <div style="overflow: hidden;">                  
                  <div class="yandexform" onclick="return {'bg': '#F98E3C', 'language': 'ru', 'encoding': '', 'suggest': false, 'tld': 'ru', 'site_suggest': false, 'webopt': false, 'fontsize': 13, 'arrow': false, 'fg': '#000000', 'logo': 'ww', 'websearch': false, 'type': 2}"><form method="get"><input type="hidden" name="searchid" value="1856091"/><input name="text"/><input type="submit" value="Найти"/></form></div><script type="text/javascript" src="http://site.yandex.net/load/form/1/form.js" charset="utf-8"></script>
                </div>
               </form--> 
			   <form method="get" action="/index.php"  >
				 <div style="float: right;width:200px" align="right"><a style="color: #fff;position:relative;top:-5px;" href="javascript:void(0)" onclick="window.scrollTo(0,0)">Вверх страницы<img style="margin-left: 10px;margin-right:5px;position:relative;top:5px;" src="/img/footer/up.gif" width="20" height="22" /> </a></div>
                <div style="float: right;margin-right:20px;">
                </div>
				<div style='background-color:#FE7901;padding:3px;float:left;'>
				<input type="hidden" name="searchid" value="1856091"/>
				<input name="text" value="<?=strip_tags($_GET['text'])?>" style="background-image:none;width:720px;" />
				<input type="submit" value="Найти"/>
				</div>
				</form>
              </div> 
             </td>
             <td width="5px"><img src="/img/footer/right.gif" width="5" height="38" /></td>
           </tr>
         </table>
       </td>
      </tr>
      <tr>
       <td style="background: url('/img/footer/bg.gif') repeat-x top left;height: 120px;">
         <table style="width: 100%;">
           <tr valign="top">
             <td style="padding-left: 10px;" align="left" width="250px">
        	<?	
					$res = sql("SELECT link,name FROM {$prx}pages WHERE bot='1' ORDER BY sort");
					if(@mysql_num_rows($res))
					{
						?><table border="0" cellpadding="0" cellspacing="0"><?
						while($row = mysql_fetch_array($res))
						{
							$active = false;
							if($row['link']==$_SERVER['REQUEST_URI'])
								$active = true;
								
							?><tr><td style="padding-right:3px;padding-bottom:5px;"><a class="page_link<?=$active?'_cur':''?>" href="<?=$row['link']?>" style="color: #fff;font-weight: bold;"><?=$row['name']?></a></td></tr><?
						}
						?></table><?
					}
					?>               
             </td>
             <td style="color: #fff;font-weight: bold;padding-left: 40px;" align="left">
                      <div style="margin-bottom:8px;">
                        <img src="/img/cont/phone.png" style="margin-right: 8px;position:relative;top:5px;" /><?=preg_replace('/(\([0-9]+\))/','<span style="font-size:14px;">\\1</span>',nl2br(set("phone")));?>
                      </div>                   
                      <div style="margin-bottom:5px;">
                        <img src="/img/cont/email.png" style="margin-right: 8px;position:relative;top:3px;" /><?=set("email_site")?>
                      </div>
                      <div style="margin-bottom:5px;">
                        <img src="/img/cont/icq.png" style="margin-right: 5px;position:relative;top:5px;" /> <?=set("icq")?>
                      </div>
                      <div>
                        <img src="/img/cont/skype.png" style="margin-right: 5px;position:relative;top:5px;" /> <?=set("skype")?>
                      </div>
             </td>
             <td style="width: 500px;padding-top:60px;" align="right">
               <?	
				$res = sql("SELECT html FROM {$prx}counters ORDER BY sort");
				while($row = @mysql_fetch_assoc($res))
					echo "&nbsp;{$row['html']}&nbsp;";	
				?>             
             </td>
           </tr>
         </table>
       </td>
      </tr> 
      <tr>
       <td></td>
      </tr>
      <tr>
        <td  align="right" style="font-size:11px;padding:0 10px;">

        </td>
      </tr>
    </table>
    <?
	
	return ob_get_clean();
}
?>