<?
require('inc/common.php');
$tbl = "sliders";
$rubric = "Слайды";
$id = (int)@$_GET['id'];

$sqlmain = "SELECT * FROM {$prx}{$tbl} ORDER BY id DESC";
$k = 40;

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
    switch($_GET['action'])
    {
        case "save":
            foreach($_POST as $key=>$val)
                $$key = clean($val);


            $hide = $hide ? $hide : 0;
            $in_homepage = $in_homepage ? $in_homepage : 0;

            $set = "name='{$name}', url='{$url}', sort={$sort}, hide={$hide}, in_homepage={$in_homepage}";

            if($id = update($tbl, $set, $id))
            {

                sql("DELETE FROM {$prx}entity_slider WHERE slider_id = {$id}");

                if(count($_POST['ids_cattype'])){

                    foreach ($_POST['ids_cattype'] as $id_cattype){

                        $set = "slider_id={$id}, entity_id={$id_cattype}, entity_type='category'";
                        update('entity_slider', $set);
                    }

                }

                if(count($_POST['ids_catrazdel'])){

                    foreach ($_POST['ids_catrazdel'] as $id_catrazdel){

                        $set = "slider_id={$id}, entity_id={$id_catrazdel}, entity_type='sub_category'";
                        update('entity_slider', $set);
                    }

                }

                if(count($_POST['ids_catmaker'])){

                    foreach ($_POST['ids_catmaker'] as $id_catmaker){

                        $set = "slider_id={$id}, entity_id={$id_catmaker}, entity_type='vendor'";
                        update('entity_slider', $set);
                    }

                }


                // загружаем картинки
                if($_FILES['image']['name'])
                {
                    $path = $_SERVER['DOCUMENT_ROOT']."/img/sliders/{$id}.jpg";
                    @move_uploaded_file($_FILES['image']['tmp_name'],$path);
                    @chmod($path,0644);
                }


                $p = getPage($sqlmain,$id,$k);
                ?><script>top.location.href = "?p=<?=$p?>&id=<?=$id?>&rand=<?=rand()?>#<?=$id?>";</script><?
            }
            else
                errorAlert('Ошибка!');
            break;

        case "del":
            update($tbl, "", $id);
            ?><script>top.topReload();</script><?
            break;
        case "img_del":
            @unlink($_SERVER['DOCUMENT_ROOT']."/img/sliders/{$id}.jpg");
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
        <table class="red2" style="width:800px;">
            <tr>
                <th>Название</th>
                <td><input name="name" type="text" value="<?=$row['name']?>" style="width:50%"></td>
            </tr>
            <tr>
                <th>Ссылка</th>
                <td><input name="url" type="text" value="<?=$row['url']?>" style="width:50%"></td>
            </tr>
            <tr>
                <th>Порядок</th>
                <td><input name="sort" type="text" value="<?=$row['sort']?>" style="width:50%"></td>
            </tr>
            <tr>
                <th>Изображение</th>
                <td valign="middle">
                    <div style="float:left;"><input type="file" name="image"></div>
                    <?
                    if(file_exists($_SERVER['DOCUMENT_ROOT']."/img/sliders/{$id}.jpg"))
                    {
                        ?>
                        <div style="float:left; padding:0 10px;">
                            <a href="/img/sliders/<?=$id?>.jpg" target="my" onClick="openWindow(800,600)">
                                <img src="/img/sliders/<?=$id?>.jpg" width="20" align="absmiddle" title="увеличить" style="border:1px solid #999;">
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
                <th>На главной странице</th>
                <td><input name="in_homepage" type="checkbox" <?=$row['in_homepage'] ? "checked" : ""?> style="width:auto;" value="1"></td>
            </tr>
            <tr>
                <th>Тип</th>
                <?php
                $ids_cattype = $id ? getArr("SELECT entity_id as id FROM {$prx}entity_slider WHERE slider_id={$id} AND  entity_type='category'") : [];
                ?>
                <td><?=dll("SELECT id, name FROM {$prx}cattype ORDER BY name", 'name="ids_cattype[]" multiple size=20', $ids_cattype)?></td>
            </tr>
            <tr>
                <th>Категория</th>
                <?php
                $ids_catrazdel = $id ? getArr("SELECT entity_id as id FROM {$prx}entity_slider WHERE slider_id={$id} AND  entity_type='sub_category'") : [];
                ?>
                <td><?=dll("SELECT id, name FROM {$prx}catrazdel ORDER BY name", 'name="ids_catrazdel[]" multiple size=20', $ids_catrazdel)?></td>
            </tr>
            <tr>
                <th>Вендор</th>
                <?php
                $ids_catmaker = $id ? getArr("SELECT entity_id as id FROM {$prx}entity_slider WHERE slider_id={$id} AND  entity_type='vendor'") : [];
                ?>
                <td><?=dll("SELECT id, name FROM {$prx}catmaker ORDER BY name", 'name="ids_catmaker[]" multiple size=20', $ids_catmaker)?></td>
            </tr>

            <tr>
                <th>Скрыть</th>
                <td><input name="hide" type="checkbox" <?=$row['hide'] ? "checked" : ""?> style="width:auto;" value="1"></td>
            </tr>

            <tr>
                <td align="center" colspan="2"><?=btnAction()?></td>
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
    <table class="content">
        <tr>
            <th>Название</th>
            <th>Ссылка</th>
            <th></th>
        </tr>
        <?
        $p = @$_GET['p'] ? $_GET['p'] : 1;
        $res = sql($sqlmain." LIMIT ".($p-1)*$k.", {$k}");
        while($row = mysql_fetch_array($res))
        {
            $id = $row["id"];
            ?>
            <tr id="tr<?=$id?>">
                <td><?=$row["name"]?></td>
                <td><?=$row["url"]?></td>
                <td><?=lnkAction("Red,Del")?></td>
            </tr>
        <?	}	?>
        <tr>
            <td colspan="4" align="center"><?=lnkPages($sqlmain, $p, $k)?></td>
        </tr>
    </table>
    <?
}
$content = ob_get_clean();

require("template.php");
?>