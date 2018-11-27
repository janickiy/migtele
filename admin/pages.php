<?
require('inc/common.php');
$tbl = "pages";
$rubric = "Страницы";
$id = (int)@$_GET['id'];

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "saveall":
			foreach($_POST["id"] as $id=>$none)
				foreach(array("top","mid","bot") as $key)
				{
					$$key = @$_POST[$key][$id];
					update($tbl, "{$key}='{$$key}'", $id);
				}
			?><script>top.topBack(true);</script><?
			break;

		case "save":
			foreach($_POST as $key=>$val)
				$$key = clean($val);
				
			if(!$link)
				$link = "/".makeUrl($name).".htm";
			
			// проверка
			if(getField("SELECT count(*) as c FROM {$prx}{$tbl} WHERE id<>'{$id}' AND link='{$link}'"))
				errorAlert("Страница с таким именем ссылки уже существует");

            $id_parent = isset($id_parent) && $id_parent ? $id_parent : 0;
            $top = isset($top) ? $top : 0;
            $mid = isset($mid) ? $mid : 0;
            $bot = isset($bot) ? $bot : 0;
            $is_advantage = isset($is_advantage) ? $is_advantage : 0;
            $advantage_order = is_numeric($advantage_order) ? $advantage_order : 0;


			$set = "id_parent='{$id_parent}', name='{$name}', link='{$link}', text='{$text}', top='{$top}', mid='{$mid}', bot='{$bot}',
						title='{$title}', keywords='{$keywords}', description='{$description}', is_advantage='{$is_advantage}', advantage_order='{$advantage_order}', advantage_description='{$advantage_description}', advantage_title='{$advantage_title}'";
			if ($id = update($tbl, $set, $id)){

                // загружаем картинки
                if($_FILES['preview']['name'])
                {
                    $path = $_SERVER['DOCUMENT_ROOT']."/uploads/pages/";

                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }

                    $filename = $path."preview_{$id}.jpg";

                    @move_uploaded_file($_FILES['preview']['tmp_name'],$filename);
                    @chmod($filename,0644);
                }

                if($_FILES['banner']['name'])
                {
                    $path = $_SERVER['DOCUMENT_ROOT']."/uploads/pages/";

                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }

                    $filename = $path."banner_{$id}.jpg";

                    @move_uploaded_file($_FILES['banner']['tmp_name'],$filename);
                    @chmod($filename,0644);
                }

                // загружаем картинки
                if($_FILES['advantage_image']['name'])
                {
                    $path = $_SERVER['DOCUMENT_ROOT']."/uploads/advantages/";

                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }

                    $filename = $path."{$id}.jpg";

                    @move_uploaded_file($_FILES['advantage_image']['tmp_name'],$filename);
                    @chmod($filename,0644);
                }

            };




			?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
			break;
        case "img_preview_del":
            @unlink($_SERVER['DOCUMENT_ROOT']."/uploads/pages/preview_{$id}.jpg");
            ?><script>top.location.href = "?id=<?=$id?>&red";</script><?
            break;
        case "img_banner_del":
            @unlink($_SERVER['DOCUMENT_ROOT']."/uploads/pages/banner_{$id}.jpg");
            ?><script>top.location.href = "?id=<?=$id?>&red";</script><?
            break;
        case "advantage_img_del":
            @unlink($_SERVER['DOCUMENT_ROOT']."/uploads/advantages/{$id}.jpg");
            ?><script>top.location.href = "?id=<?=$id?>&red";</script><?
            break;
		case "del":
			$ids = getTreeChilds("SELECT id FROM {$prx}{$tbl} WHERE id_parent = '%s'", $id);
			update($tbl, "", $ids);
			?><script>top.topReload();</script><?
			break;
	
		case "moveup":
			$move = "up";
		case "movedown":
			moveSort((@$move ? "up" : "down"), $tbl, $id, "id_parent");
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
?>
	<a name="red"></a>
	<form action="?id=<?=$id?>&action=save" method="post" enctype="multipart/form-data" target="ajax">
		<table class="red2" width="80%">
			<tr>
				<th>Расположение</th>
				<td><?=dllTree("SELECT id, name FROM {$prx}{$tbl} WHERE id_parent='%s' ORDER BY sort", 'name="id_parent"', $row['id_parent'], "", $id)?></td>
			</tr>
			<tr>
				<th>Название</th>
				<td><input name="name" type="text" value="<?=$row['name']?>" <?=($row["readonly"] ? "readonly" : "")?>></td>
			</tr>
			<tr>
				<th>Ссылка</th>
				<td><input name="link" type="text" value="<?=$row['link']?>" <?=($row["readonly"] ? "readonly" : "")?>></td>
				<td><img src="img/help.gif" title="Формируется автоматически" onClick="alert(this.title)" alt="[?]" class="hand"></td>
			</tr>
			<tr>
				<th>В верхнем меню</th>
				<td><input name="top" type="checkbox" <?=$row['top'] ? "checked" : ""?> style="width:auto;" value="1"></td>
			</tr><!--
			<tr>
				<th>В меню под корзиной</th>
				<td><input name="mid" type="checkbox" <?/*=$row['mid'] ? "checked" : ""*/?> style="width:auto;" value="1"></td>
			</tr>-->
			<tr>
				<th>В нижнем меню</th>
				<td><input name="bot" type="checkbox" <?=$row['bot'] ? "checked" : ""?> style="width:auto;" value="1"></td>
			</tr>
			<tr>
				<th>Текст</th>
				<td><textarea class="ckeditor-textarea" name="text"><?=$row['text']?></textarea></td>
			</tr>




            <tr>
                <th>Миниатюра</th>
                <td valign="middle">
                    <div style="float:left;"><input type="file" name="preview"></div>
                    <?
                    $preview = "/uploads/pages/preview_{$id}.jpg";
                    if(file_exists($_SERVER['DOCUMENT_ROOT'].$preview))
                    {
                        ?>
                        <div style="float:left; padding:0 10px;">
                            <a href="<?=$preview?>" target="my" onClick="openWindow(800,600)">
                                <img src="<?=$preview?>" width="20" align="absmiddle" title="увеличить" style="border:1px solid #999;">
                            </a>
                        </div>
                        <div style="float:left; padding-top:3px;">
                            <a href="?action=img_preview_del&id=<?=$id?>"  target="ajax">удалить текущее изображение</a>
                        </div>
                        <?
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <th>Баннер</th>
                <td valign="middle">
                    <div style="float:left;"><input type="file" name="banner"></div>
                    <?
                    $banner = "/uploads/pages/banner_{$id}.jpg";
                    if(file_exists($_SERVER['DOCUMENT_ROOT'].$banner))
                    {
                        ?>
                        <div style="float:left; padding:0 10px;">
                            <a href="<?=$banner?>" target="my" onClick="openWindow(800,600)">
                                <img src="<?=$banner?>" width="20" align="absmiddle" title="увеличить" style="border:1px solid #999;">
                            </a>
                        </div>
                        <div style="float:left; padding-top:3px;">
                            <a href="?action=img_banner_del&id=<?=$id?>"  target="ajax">удалить текущее изображение</a>
                        </div>
                        <?
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <th>В блоке преимущества</th>
                <td><input name="is_advantage" type="checkbox" <?=$row['is_advantage'] ? "checked" : ""?> style="width:auto;" value="1"></td>
            </tr>

            <tr>
                <th>Сортировка в блоке преимущества</th>
                <td><input name="advantage_order" type="number" value="<?=$row['advantage_order']?>" ></td>
            </tr>

            <tr>
                <th>Изображение в блоке преимущества</th>
                <td valign="middle">
                    <div style="float:left;"><input type="file" name="advantage_image"></div>
                    <?
                    if(file_exists($_SERVER['DOCUMENT_ROOT']."/uploads/advantages/{$id}.jpg"))
                    {
                        ?>
                        <div style="float:left; padding:0 10px;">
                            <a href="/uploads/advantages/<?=$id?>.jpg" target="my" onClick="openWindow(800,600)">
                                <img src="/uploads/advantages/<?=$id?>.jpg" width="20" align="absmiddle" title="увеличить" style="border:1px solid #999;">
                            </a>
                        </div>
                        <div style="float:left; padding-top:3px;">
                            <a href="?action=advantage_img_del&id=<?=$id?>" target="ajax">удалить текущее изображение</a>
                        </div>
                        <?
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <th>Название для блока в преимуществе</th>
                <td><input name="advantage_title" type="text" value="<?=$row['advantage_title']?>"</td>
            </tr>
            <tr>
                <th>Небольшое описание для блока в преимуществе</th>
                <td><textarea name="advantage_description"><?=$row['advantage_description']?></textarea></td>
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
		</table>

		<?//=getFck("text",$row['text'])?>

		<!--<table class="red2" width="50%">
			<tr>
				<th>title</th>
				<td><input name="title" type="text" value="<?/*=$row['title']*/?>"></td>
			</tr>
			<tr>
				<th>keywords</th>
				<td><input name="keywords" type="text" value="<?/*=$row['keywords']*/?>"></td>
			</tr>
			<tr>
				<th>description</th>
				<td><textarea name="description"><?/*=$row['description']*/?></textarea></td>
			</tr>
		</table>-->
		<div style="padding-top:10px;" align="center"><?=btnAction()?></div>
	</form>			  
<?
}

// -----------------ПРОСМОТР-------------------
else
{
	echo lnkAction("Add");
?>
	<form action="?action=saveall" target="ajax" method="post" id="frmContent">
		<table class="content">
			<tr>
				<th>Название</th>
				<th>Ссылка</th>
				<th>В верхнем меню</th><!--
				<th>В меню под корзиной</th>-->
				<th>В нижнем меню</th>
				<th></th>
			</tr>
		<? 
			$sql = "SELECT id,link,name,readonly,top,mid,bot FROM {$prx}{$tbl} WHERE id_parent = '%s' ORDER BY sort";
			$tree = getTree($sql);
			if($tree)
			foreach ($tree as $vetka) 
			{
				$row =  $vetka["row"];
				$id = $row["id"];
				$prefix = getPrefix($vetka["level"]);
		?>
				<tr id="tr<?=$id?>">
					<td <?=(!$vetka["level"] ? 'style="font-weight:bold;"' : "")?>>
						<a name="<?=$id?>"></a><span class="st_g"><?=$prefix?></span><?=$row["name"]?>
					</td>
					<td><a href="<?=$row["link"]?>"><?=$row["link"]?></a></td>
					<td align="center">
						<input type="hidden" name="id[<?=$id?>]">
						<input name="top[<?=$id?>]" type="checkbox" <?=($row["top"] ? "checked" : "")?> onClick="get('frmContent').submit();" value="1">
					</td><!--
					<td align="center">
						<input name="mid[<?/*=$id*/?>]" type="checkbox" <?/*=($row["mid"] ? "checked" : "")*/?> onClick="get('frmContent').submit();" value="1">
					</td>-->
					<td align="center">
						<input name="bot[<?=$id?>]" type="checkbox" <?=($row["bot"] ? "checked" : "")?> onClick="get('frmContent').submit();" value="1">
					</td>
					<td><?=lnkAction($row["readonly"] ? "Up,Down,Red" : "Up,Down,Red,Del")?></td>
				</tr>
		<?	}	?>
		</table>	
	</form>
<?
}
$content = ob_get_clean();

require("template.php");
?>