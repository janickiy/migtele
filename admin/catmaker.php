<?
require('inc/common.php');
$tbl = "catmaker";
$rubric = "Разделы &raquo; Вендоры";
$top_menu = "catalog";
$id = (int)@$_GET['id'];

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
    switch($_GET['action'])
    {
        case "saveall":
            foreach($_POST["id"] as $id=>$none)
                foreach(array("hide","hide_in_YML") as $key)
                {
                    $$key = @$_POST[$key][$id];
                    $$key = $$key ? $$key : 0;
                    update($tbl, "{$key}='{$$key}'", $id);
                }
            ?><script>top.topBack(true);</script><?
            break;

        case "save":
            foreach($_POST as $key=>$val)
                $$key = clean($val);

            $slug = $slug ? Helpers::str2url($slug) : makeUrl($name);

            $hide = isset($hide) ? $hide : 0;
            $set = "name='{$name}', text='{$text}', hide='{$hide}', title='{$title}', keywords='{$keywords}', description='{$description}', delivery_text='{$delivery_text}', warranty_text='{$warranty_text}', slug='{$slug}'";

            if($id = update($tbl, $set, $id))
            {

                sql("DELETE FROM {$prx}vendor_discounts WHERE vendor_id = {$id}");

                if(isset($_POST['discount'])){

                    foreach ($_POST['discount'] as $discount){
                        $value = $discount['value'];
                        $quantity = $discount['quantity'];
                        $set = "vendor_id={$id}, value= {$value}, quantity={$quantity}";
                        update('vendor_discounts', $set);
                    }

                }


                // загружаем картинки
                if($_FILES['image']['name'])
                {
                    $path = $_SERVER['DOCUMENT_ROOT']."/img/vendors/{$id}.jpg";
                    @move_uploaded_file($_FILES['image']['tmp_name'],$path);
                    @chmod($path,0644);
                }


                // загружаем картинки
                if($_FILES['certificate']['name'])
                {
                    $path = $_SERVER['DOCUMENT_ROOT']."/uploads/certificates/{$id}.jpg";
                    @move_uploaded_file($_FILES['image']['tmp_name'],$path);
                    @chmod($path,0644);
                }

                //upfile("../uploads/{$tbl}/{$id}.xls", $_FILES["file"], @$_POST["del_file"]);

                ?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
            }
            else
                errorAlert('Ошибка!');
            break;

        case "del":
            if($ids = getArr("SELECT id FROM {$prx}cattmr WHERE id_catmaker = '{$id}'"))
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
            sql("DELETE FROM {$prx}cattmr WHERE id_catmaker='{$id}'"); // удаляем из связки вендор-категория
            sql("DELETE FROM {$prx}price WHERE id_catmaker='{$id}'"); // удаляем из прайс-листов
            update($tbl, "", $id);
            @unlink("../uploads/{$tbl}/{$id}.xls");
            @unlink($_SERVER['DOCUMENT_ROOT']."/uploads/certificates/{$id}.jpg");
            @unlink($_SERVER['DOCUMENT_ROOT']."/img/vendors/{$id}.jpg");
            ?><script>top.topReload();</script><?
            break;

        case "moveup":
            $move = "up";
        case "movedown":
            moveSort((@$move ? "up" : "down"), $tbl, $id);
            ?><script>top.topReload();</script><?
            break;

        case "img_del":
            @unlink($_SERVER['DOCUMENT_ROOT']."/img/vendors/{$id}.jpg");
            ?><script>top.location.href = "?id=<?=$id?>&red";</script><?
            break;
        case "certificate_del":
            @unlink($_SERVER['DOCUMENT_ROOT']."/uploads/certificates/{$id}.jpg");
            ?><script>top.location.href = "?id=<?=$id?>&red";</script><?
            break;
        case 'sortAbc':

            sortByName($prx, $tbl);

            ?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?

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
        <table class="red" width="80%">
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
                    if(file_exists($_SERVER['DOCUMENT_ROOT']."/img/vendors/{$id}.jpg"))
                    {
                        ?>
                        <div style="float:left; padding:0 10px;">
                            <a href="/img/vendors/<?=$id?>.jpg" target="my" onClick="openWindow(800,600)">
                                <img src="/img/vendors/<?=$id?>.jpg" width="20" align="absmiddle" title="увеличить" style="border:1px solid #999;">
                            </a>
                        </div>
                        <div style="float:left; padding-top:3px;">
                            <a href="?action=img_del&id=<?=$id?>" target="ajax">удалить текущее изображение</a>
                        </div>
                        <?
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <th>Сертификат</th>
                <td valign="middle">
                    <div style="float:left;"><input type="file" name="certificate"></div>
                    <?
                    if(file_exists($_SERVER['DOCUMENT_ROOT']."/uploads/certificates/{$id}.jpg"))
                    {
                        ?>
                        <div style="float:left; padding:3px 10px 0 10px;">
                            <a href="/certificates/<?=$id?>.jpg" target="my" onClick="openWindow(800,600)">
                                <img src="img/image.png" align="absmiddle" title="увеличить">
                            </a>
                        </div>
                        <div style="float:left; padding-top:3px;">
                            <a href="javascript:toajax('?action=certificate_del&id=<?=$id?>')">удалить текущее изображение</a>
                        </div>
                        <?
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <th>Текст</th>
                <td><textarea class="ckeditor-textarea" name="text"><?=$row['text']?></textarea></td>
                <!--				<td>--><?//=getFck("text",$row['text'],"Medium","100%",300)?><!--</td>-->
            </tr>
            <tr>
                <th>Текст "Гарантия"</th>
                <td><textarea class="ckeditor-textarea" name="warranty_text"><?=$row['warranty_text']?></textarea></td>
            </tr>
            <tr>
                <th>Текст "Доставка"</th>
                <td><textarea class="ckeditor-textarea" name="delivery_text"><?=$row['delivery_text']?></textarea></td>
            </tr>
            <!--			<tr>
				<th>Прайс-лист</th>
				<td><?=fileUpload("/uploads/{$tbl}/{$id}.xls", "name='file' style='width:70%'")?></td>
			</tr>
-->

            <tr>
                <th>Скидки</th>
                <td>
                    <a href="#" class="add-vendor-discount"><img src="img/add16.gif" alt="+" hspace="4" title="добавить" >добавить</a>
                    <table class="content vendor-discount" style="width: 300px;">
                        <thead>
                        <tr>
                            <th align="center">Размер скидки в %</th>
                            <th align="center">Количество товара</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        if($id){
                            $sql = "SELECT * FROM {$prx}vendor_discounts WHERE vendor_id = {$id}";
                            $res = sql($sql);
                            $k = 0;
                            while ($discount = mysql_fetch_array($res)) { ?>
                                <?php $k++; ?>
                                <tr data-id="<?=$k?>">
                                    <td><input type="text" name="discount[<?=$k?>][value]" value="<?=$discount['value']?>"></td>
                                    <td><input type="text" name="discount[<?=$k?>][quantity]" value="<?=$discount['quantity']?>"></td>
                                    <td>
                                        <a href="#" class="remove"><img src="img/del16.gif"
                                                                        hspace="2" alt="уд."
                                                                        title="удалить"
                                                                        align="absmiddle"></a>
                                    </td>
                                </tr>
                            <?php }
                        }?>

                        </tbody>
                    </table>

                </td>
            </tr>

            <tr>
                <th>Скрыть</th>
                <td><input name="hide" type="checkbox" <?=$row['hide'] ? "checked" : ""?> style="width:auto;" value="1"></td>
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
    <a href="?action=sortAbc"><img src="img/arr-sort-down.gif" hspace="2" alt="ред." title="Отсортировать по алфавиту" align="absmiddle">Отсортировать по алфавиту</a>
    <form action="?action=saveall" target="ajax" method="post" id="frmContent">
        <table class="content">
            <tr>
                <th>Название</th>
                <!--<th>Прайс-лист</th>-->
                <!--<th>Ссылка</th>-->
                <th>Скрыть</th>
                <th>Скрыть в YML</th>
                <th></th>
            </tr>
            <?
            $res = sql("SELECT id, name, hide, hide_in_YML FROM {$prx}{$tbl} ORDER BY name");
            while($row = mysql_fetch_array($res))
            {
                $id = $row["id"];
                ?>
                <tr id="tr<?=$id?>">
                    <td><a name="<?=$id?>"></a><a href="goods.php?id_catmaker=<?=$id?>"><?=$row["name"]?></a></td>
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
            <?	}	?>
        </table>
    </form>
    <script>
        $('.js-submit').change(function(){
            $(this).parents('form').submit();
        });
    </script>
    <?
}
$content = ob_get_clean();

require("template.php");
?>