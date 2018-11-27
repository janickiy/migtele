<?
require('inc/common.php');
$tbl = "catrazdel";
$rubric = "Разделы &raquo; Категории";
$top_menu = "catalog";
$id = (int)@$_GET['id'];

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "saveall":
			foreach($_POST["id"] as $id=>$none)
				foreach(array("hide") as $key)
				{
					$$key = @$_POST[$key][$id];
					update($tbl, "{$key}='{$$key}'", $id);
				}
			?><script>top.topBack(true);</script><?
			break;

		case "save":
			foreach($_POST as $key=>$val)
				$$key = clean($val);

            $slug = $slug ? Helpers::str2url($slug) : makeUrl($name);

			$hide = isset($hide) ? $hide : 0;
            $in_last_order = isset($in_last_order) ? $in_last_order : 0;
			$set = "name='{$name}', text='{$text}', content_title='{$content_title}', hide='{$hide}', in_last_order='{$in_last_order}', title='{$title}', keywords='{$keywords}', description='{$description}', delivery_text='{$delivery_text}', warranty_text='{$warranty_text}', slug='{$slug}'";
			$id = update($tbl, $set, $id);

            // загружаем картинки
            if($_FILES['image']['name'])
            {
                $path = $_SERVER['DOCUMENT_ROOT']."/uploads/catrazdel/";

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $filename = $path."{$id}.jpg";

                @move_uploaded_file($_FILES['image']['tmp_name'],$filename);
                @chmod($filename,0644);
            }

			?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
			break;
	
		case "del":
			if($ids = getArr("SELECT id FROM {$prx}cattmr WHERE id_catrazdel = '{$id}'"))
			{
                errorAlert('Невозможно удалить. Элемент связан в тип-вендор-категория');

				$ids = implode(",",$ids);
				if($ids_goods = getArr("SELECT id FROM {$prx}goods WHERE id_cattmr IN ({$ids})"))
				{
					$ids_goods = implode(",",$ids_goods);
					foreach(array("img","doc","teh","am") as $t)
						sql("DELETE FROM {$prx}goods_{$t} WHERE id_goods IN ({$ids_goods})"); // удаляем из дополнительных таблиц
					sql("DELETE FROM {$prx}goods WHERE id IN ({$ids_goods})"); // удаляем товары
				}
			}
			sql("DELETE FROM {$prx}cattmr WHERE id_catrazdel='{$id}'"); // удаляем из связки вендор-категория
			update($tbl, "", $id);
			?><script>top.topReload();</script><?
			break;
	
		case "moveup":
			$move = "up";
		case "movedown":
			moveSort((@$move ? "up" : "down"), $tbl, $id);
			?><script>top.topReload();</script><?
			break;
        case 'sortAbc':

            sortByName($prx, $tbl);

            ?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?

            break;
        case "img_del":
            @unlink($_SERVER['DOCUMENT_ROOT']."/uploads/catrazdel/{$id}.jpg");
            ?><script>top.location.href = "?id=<?=$id?>&red";</script><?
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
?>
	<form action="?id=<?=$id?>&action=save" method="post" enctype="multipart/form-data" target="ajax">
		<table class="red" width="1200">
            <tr>
                <th>Название</th>
                <td><input name="name" type="text" value="<?=$row['name']?>"></td>
            </tr>
            <tr>
                <th>Суфикс для URL</th>
                <td><input name="slug" type="text" value="<?=$row['slug']?>"></td>
            </tr>
            <tr>
                <th>Изображение</th>
                <td valign="middle">
                    <div style="float:left;"><input type="file" name="image"></div>
                    <?
                    $image = "/uploads/catrazdel/{$id}.jpg";
                    if(file_exists($_SERVER['DOCUMENT_ROOT'].$image))
                    {
                        ?>
                        <div style="float:left; padding:0 10px;">
                            <a href="<?=$image?>" target="my" onClick="openWindow(800,600)">
                                <img src="<?=$image?>" width="20" align="absmiddle" title="увеличить" style="border:1px solid #999;">
                            </a>
                        </div>
                        <div style="float:left; padding-top:3px;">
                            <a href="?action=img_del&id=<?=$id?>"  target="ajax">удалить текущее изображение</a>
                        </div>
                        <?
                    }
                    ?>
                </td>
            </tr>
			<tr>
				<th>Текст</th>
				<td>
					<textarea class="ckeditor-textarea" name="text"><?=$row['text']?></textarea>
				</td>
			</tr>
			<tr>
				<th>Текст "Гарантия"</th>
				<td><textarea class="ckeditor-textarea" name="warranty_text"><?=$row['warranty_text']?></textarea></td>
			</tr>
			<tr>
				<th>Текст "Доставка"</th>
				<td><textarea class="ckeditor-textarea" name="delivery_text"><?=$row['delivery_text']?></textarea></td>
			</tr>
			<tr>
				<th>Скрыть</th>
				<td><input name="hide" type="checkbox" <?=$row['hide'] ? "checked" : ""?> style="width:auto;" value="1"></td>
			</tr>
            <tr>
				<th>Последняя категория</th>
				<td><input name="in_last_order" type="checkbox" <?=$row['in_last_order'] ? "checked" : ""?> style="width:auto;" value="1"></td>
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
	echo lnkAction("Add");

?>
	<?php
	$getData = $_GET;
	$getData['orderBy'] = 'clickCount';
	$urlData = http_build_query($getData);
	?>
	<a href="?<?=$urlData?>">
		<img src="img/arr-sort-down.gif" hspace="2" alt="ред." title="Отсортировать по количеству кликов" align="absmiddle">
		Отсортировать по количеству кликов
	</a>
    <a href="?action=sortAbc"><img src="img/arr-sort-down.gif" hspace="2" alt="ред." title="Отсортировать по алфавиту" align="absmiddle">Отсортировать по алфавиту</a>
	<form action="?action=saveall" target="ajax" method="post" id="frmContent">
		<table class="content">
			<tr>
				<th>Название</th>
				<!--<th>Ссылка</th>-->
				<th>Кол-во кликов</th>
				<th>Скрыть</th>
				<th></th>
			</tr>
		<?
		$orderBy = ' ORDER BY sort ';
		$orderBy = ' ORDER BY sort ';
		if(isset($_GET['orderBy'])){
			switch($_GET['orderBy']){
				case 'clickCount':
					$orderBy = ' ORDER BY clickCount DESC, sort ';
					break;
			}
		}
		$sql = "SELECT id,name,hide,clickCount FROM {$prx}{$tbl} ".$orderBy;
		$res = sql($sql);
			while($row = mysql_fetch_array($res))
			{
				$id = $row["id"];
		?>
				<tr id="tr<?=$id?>">
					<td><a name="<?=$id?>"></a><a href="goods.php?id_catrazdel=<?=$id?>"><?=$row["name"]?></a></td>
					<td><?=$row['clickCount']?></td>
					<!--<td><a href="/<?=$tbl?>/<?=$id?>/">/<?=$tbl?>/<?=$id?>/</a></td>-->
					<td align="center">
						<input type="hidden" name="id[<?=$id?>]">
						<input name="hide[<?=$id?>]" type="checkbox" <?=($row["hide"] ? "checked" : "")?> onClick="get('frmContent').submit();" value="1">
					</td>
					<td><?=lnkAction()?></td>
				</tr>
		<?	}	?>
		</table>	
	</form>
<?
}
$content = ob_get_clean();

require("template.php");
?>