<?

require('inc/common.php');

require_once(dirname(__FILE__) . '/../yii/protected/models/Catmaker.php');
require_once(dirname(__FILE__) . '/../yii/protected/models/Cattype.php');
require_once(dirname(__FILE__) . '/../yii/protected/models/Catrazdel.php');

$sqlCattmr = str_replace('ORDER BY tmr.sort', '', $sqlCattmr);
//var_dump($sqlCattmr);
$tbl = "cattmr";
$rubric = "Разделы &raquo; Тип-Вендор-Категория";
$top_menu = "catalog";
$id = (int)@$_GET['id'];

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "saveall":
			foreach($_POST["id"] as $id=>$none)
				foreach(array("hide", 'hide_in_YML') as $key)
				{
					$$key = isset($_POST[$key][$id]) ? $_POST[$key][$id] : 0;

					update($tbl, "{$key}='{$$key}'", $id);
				}
			?><script>top.topBack(true);</script><?
			break;
		case "save":
			foreach($_POST as $key=>$val)
				$$key = clean($val);

            $hg = isset($hg) ? $hg : 0;
            $sr = isset($sr) ? $sr : 0;


			$set = "id_cattype='{$id_cattype}', id_catmaker='{$id_catmaker}', id_catrazdel='{$id_catrazdel}',id_sub_catrazdel='{$id_sub_catrazdel}', text='{$text}', content_title='{$content_title}', text_hide='{$text_hide}',
							text1=".($text1?"'{$text1}'":'NULL').",
							text2=".($text2?"'{$text2}'":'NULL').",
							title='{$title}', keywords='{$keywords}', description='{$description}',hg='{$hg}',sr='{$sr}'";
			$id = update($tbl, $set, $id);
			
			?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
			break;
	
		case "del":

			if($ids_goods = getArr("SELECT id FROM {$prx}goods WHERE id_cattmr='{$id}'"))
			{
				$ids_goods = implode(",",$ids_goods);
				foreach(array("img") as $t)
					sql("DELETE FROM {$prx}goods_{$t} WHERE id_goods IN ({$ids_goods})"); // удаляем из дополнительных таблиц
				sql("DELETE FROM {$prx}goods WHERE id IN ({$ids_goods})"); // удаляем товары
			}

			update($tbl, "", $id);
			?><script>top.topReload();</script><?
			break;
	
		case "moveup":
			$move = "up";
		case "movedown":
			moveSort((@$move ? "up" : "down"), $tbl, $id, "id_catmaker,id_catrazdel");
			?><script>top.topReload();</script><?
			break;			
	}
	exit;
}

ob_start();
// ------------------РЕДАКТИРОВАНИЕ--------------------
if(isset($_GET["red"]))
{
	$rubric .= " &raquo; ".($id ? "Редактирование" : "Добавление");
	$row = getRow("SELECT * FROM {$prx}{$tbl} WHERE id='{$id}'");
	
	if($row)
	{
		foreach(array('id_cattype','id_catmaker','id_catrazdel', 'id_sub_catrazdel') as $val)
			$$val = $row[$val];
	}
	else
	{
		foreach(array('id_cattype','id_catmaker','id_catrazdel', 'id_sub_catrazdel') as $val)
			$$val = (int)$_GET[$val];
	}
	?>
	<form action="?id=<?=$id?>&action=save" method="post" enctype="multipart/form-data" target="ajax">
		<table class="red" width="1200">
			<tr>
				<th>Тип оборудования</th>
				<td><?=dll("SELECT id, name FROM {$prx}cattype ORDER BY name", 'class="select2" name="id_cattype"', $id_cattype)?></td>
			</tr>
			<tr>
				<th>Вендор</th>
				<td><?=dll("SELECT id, name FROM {$prx}catmaker ORDER BY name", 'class="select2" name="id_catmaker"', $id_catmaker)?></td>
			</tr>
			<tr>
				<th>Категория</th>
				<td><?=dll("SELECT id, name FROM {$prx}catrazdel ORDER BY name", 'class="select2" name="id_catrazdel"', $id_catrazdel)?></td>
			</tr>

            <tr>
                <th>Подкатегория</th>
                <td><?=dll("SELECT id, name FROM {$prx}catrazdel ORDER BY name", 'class="select2" name="id_sub_catrazdel"', $id_sub_catrazdel, 'Выберите подкатегорию')?></td>
            </tr>

			<tr>
				<th>Текст</th>
				<td>
					<textarea class="ckeditor-textarea" name="text"><?=$row['text']?></textarea>
				</td>
			</tr>
			<tr>
				<th>Шаблона текста<br>для товара, снизу</th>
				<td>
					<textarea class="ckeditor-textarea" name="text1"><?=$row['text1']?></textarea>
				</td>
				<td rowspan="2" style="width:1%;"><img src="img/help.gif" title="{tovar} - название товара" onClick="alert(this.title)" alt="[?]" class="hand"></td>
			</tr>
			<tr>
				<th>Шаблона текста<br>для товара, справа</th>
				<td>

					<textarea class="ckeditor-textarea" name="text2"><?=$row['text2']?></textarea>
				</td>
			</tr>
			<tr>
				<th>Текст скрытый (футер)</th>
				<td>
					<textarea class="ckeditor-textarea" name="text_hide"><?=$row['text_hide']?></textarea>
				</td>
			</tr>
			<tr>
				<th>Скрывать товары</th>
				<td><input type="checkbox" value="1" name="hg"<?=($row["hg"]?' checked':'')?>></td>
			</tr>
      <tr>
				<th>Разбивать на серии</th>
				<td><input type="checkbox" value="1" name="sr"<?=($row["sr"]?' checked':'')?>></td>
			</tr>
            <tr>
                <th>Название для сайта</th>
                <td><input name="content_title" type="text" value="<?=$row['content_title']?>"></td>
            </tr>
			<tr>
				<th>title</th>
				<td><input name="title" type="text" value="<?=$row['title']?>"></td>
			</tr>
			<tr>
				<th>keywords</th>
				<td><input name="keywords" type="text" value="<?=$row['keywords']?>"></td>
			</tr>
			<tr>
				<th>description</th>
				<td><textarea name="description"><?=$row['description']?></textarea></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><?=btnAction()?></td>
			</tr>
		</table>
	</form>			  
<?
}

// -----------------ПРОСМОТР-------------------
else
{
	foreach(array('id_cattype','id_catmaker','id_catrazdel', 'id_sub_catrazdel') as $val)
		$$val = (int)$_GET[$val];
	?>
	<form>
		<table class="content">
			<tr>
				<th>Тип</th>
				<th>Вендор</th>
				<th>Категория</th>
                <th>Подкатегория</th>

			</tr>
			<tr>
				<th><?=dll("SELECT id,name FROM {$prx}cattype ORDER BY name", 'name="id_cattype" style="width:auto"', $id_cattype, "")?></th>
				<th><?=dll("SELECT id,name FROM {$prx}catmaker ORDER BY name", 'name="id_catmaker" style="width:auto"', $id_catmaker, "")?></th>
				<th><?=dll("SELECT id,name FROM {$prx}catrazdel ORDER BY name", 'name="id_catrazdel" style="width:auto"', $id_catrazdel, "")?></th>
                <th><?=dll("SELECT id,name FROM {$prx}catrazdel ORDER BY name", 'name="id_sub_catrazdel" style="width:auto"', $id_sub_catrazdel, "")?></th>
			</tr>
			<tr>
				<th colspan="3" style="text-align:center;"><?=btnAction("Save", "Показать")?></th>
			</tr>
		</table>
	</form>
  <br>
  <?=lnkAction("Add","&id_cattype={$id_cattype}&id_catmaker={$id_catmaker}&id_catrazdel={$id_catrazdel}&id_sub_catrazdel={$id_sub_catrazdel}")?>
	<?php
	$getData = $_GET;
	$getData['orderBy'] = 'clickCount';
	$urlData = http_build_query($getData);
	?>
	<a href="?<?=$urlData?>">
		<img src="img/arr-sort-down.gif" hspace="2" alt="ред." title="Отсортировать по количеству кликов" align="absmiddle">
		Отсортировать по количеству кликов
	</a>
  <br>
	<form action="?action=saveall" target="ajax" method="post" id="frmContent">
	<table class="content">
		<tr>
			<th>Тип - Вендор - Категория</th>
			<th>Ссылка</th>
			<th>Количество кликов</th>
			<th>Скрыть</th>
    		<th>Скрыть в YML</th>
			<th></th>
		</tr>
		<?
		$where = '';
		if($id_cattype) 	$where .= " and tmr.id_cattype={$id_cattype}";
		if($id_catmaker) 	$where .= " and tmr.id_catmaker={$id_catmaker}";
		if($id_catrazdel) $where .= " and tmr.id_catrazdel={$id_catrazdel}";
		if($id_sub_catrazdel) $where .= " and tmr.id_sub_catrazdel={$id_sub_catrazdel}";
	$orderBy = 'ORDER BY tmr.sort';
	if(isset($_GET['orderBy'])){
		switch($_GET['orderBy']){
			case 'clickCount':
				$orderBy = ' ORDER BY tmr.clickCount DESC ';
				break;
		}
	}
	$sql = 	sprintf($sqlCattmr,$where?"WHERE 1{$where}":'');
	$sql .= $orderBy;



    $res = sql($sql);
		while($row = mysql_fetch_array($res))
		{

			/**@var $category Cattype*/
		    $category = Cattype::model()->findByPk($row['id_cattype']);
            /**@var $vendor Catmaker*/
			$vendor = Catmaker::model()->findByPk($row['id_catmaker']);
            /**@var $section Catrazdel*/
			$section = Catrazdel::model()->findByPk($row['id_catrazdel']);
			$sub_section = Catrazdel::model()->findByPk($row['id_sub_catrazdel']);

		    $id = $row["id"];
			?>
			<tr id="tr<?=$id?>">
				<td>
					<a name="<?=$id?>"></a>
					<a href="goods.php?id_cattmr=<?=$id?>"><?=$row["cattype"]?> - <?=$row["catmaker"]?> - <?=$row["catrazdel"]?> <?=$sub_section ? ' - '.$sub_section->name : ''?></a>
				</td>
				<td>
					<a href="/<?= $category->getUrlWithVendorAndSection($vendor, $section, $sub_section)?>">
						/<?= $category->getUrlWithVendorAndSection($vendor, $section, $sub_section)?>
					</a>
				</td>
				<td><?=$row['clickCount']?></td>
                <td align="center">
                    <input type="hidden" name="id[<?=$id?>]">
                    <input name="hide[<?=$id?>]" class="js-submit" type="checkbox" <?=($row["hide"] ? "checked" : "")?> onClick="get('frmContent').submit();" value="1">
                </td>
                <td align="center">
                    <input type="hidden" name="id[<?=$id?>]">
                    <input name="hide_in_YML[<?=$id?>]"  type="checkbox" <?=($row["hide_in_YML"] ? "checked" : "")?> onClick="get('frmContent').submit();" value="1">
                </td>
				<td><?=lnkAction()?></td>
			</tr>
			<?
		}
	?>
	</table>
	</form>
<?
}
$content = ob_get_clean();

require("template.php");
?>