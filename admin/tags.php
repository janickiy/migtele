<?
require('inc/common.php');
$tbl = "tags";
$rubric = "Метки";
$id = (int)@$_GET['id'];

$sqlmain = "SELECT * FROM {$prx}{$tbl}";
$k = 40;

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
    switch($_GET['action'])
    {

        case "save":

            foreach($_POST as $key=>$val)
                $$key = clean($val);

            $slug = makeUrl($name);

            if(!$category_id){
                errorAlert('Выберите категорию');
            }

            $hide = isset($hide) ? $hide : 0;
            $subcategory_id = isset($subcategory_id) ? $subcategory_id : 0;



            $id = update($tbl, "category_id={$category_id}, subcategory_id={$subcategory_id}, name='{$name}', text='{$text}', title='{$title}', keywords='{$keywords}', description='{$description}', delivery_text='{$delivery_text}', warranty_text='{$warranty_text}', slug='{$slug}', hide='{$hide}'", $id);

            $p = getPage($sqlmain,$id,$k);
            ?><script>top.location.href = "?p=<?=$p?>&id=<?=$id?>&rand=<?=rand()?>#<?=$id?>";</script><?
            break;

        case "del":
            update($tbl, "", $id);
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
        <table class="red" width="80%">

            <tr>
                <th>Название</th>
                <td><input type="text" name="name" value="<?=$row['name']?>"></td>
            </tr>

            <tr>
                <th>Суффикс для url</th>
                <td><input type="text" name="slug" value="<?=$row['slug']?>"></td>
            </tr>

            <tr>
                <th>Текст</th>
                <td><textarea class="ckeditor-textarea" name="text"><?=$row['text']?></textarea></td>
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
                <th>Категория</th>
                <td>

                    <select class="select2" name="" id="select-category">
                        <option value="">Выберите</option>
                    <?php
                        $res = sql("SELECT id, name FROM {$prx}cattype ORDER BY name");
                        while ($category = mysql_fetch_array($res)) {
                            ?>
                            <option
                                    value=""
                                    data-id_catrazdel="0"
                                    data-id_cattype="<?=$category['id']?>"
                                    <?= !$row['subcategory_id'] && $row['category_id'] == $category['id'] ? 'selected' : ''?>
                            >
                                <?=$category['name']?>
                            </option>
                            <?
                            $sub_res = sql("SELECT DISTINCT sub.*, m.id_cattype FROM {$prx}cattmr as m LEFT JOIN {$prx}catrazdel as sub ON sub.id = m.id_catrazdel WHERE m.id_cattype = {$category['id']}");
                            while ($sub_category = mysql_fetch_array($sub_res)) {
                                ?>
                                <option
                                        value=""
                                        data-id_cattype="<?=$category['id']?>"
                                        data-id_catrazdel="<?=$sub_category['id']?>"
                                    <?= $row['subcategory_id'] == $sub_category['id'] && $row['category_id'] == $category['id'] ? 'selected' : ''?>
                                >
                                    <?=$category['name']?> - <?=$sub_category['name']?>
                                </option>
                                <?
                            }
                        }
                    ?>

                    </select>

                    <input type="hidden" name="category_id" value="<?=$row['category_id']?>">
                    <input type="hidden" name="subcategory_id" value="<?=$row['subcategory_id']?>">

                </td>
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

    <form action="?action=saveall" target="ajax" method="post">
        <table class="content 1">
            <tr>
                <th>№</th>
                <th>Название</th>
                <th>Ссылка</th>
                <th></th>
            </tr>



            <?
            $p = @$_GET['p'] ? $_GET['p'] : 1;
            $sql = $sqlmain." LIMIT ".($p-1)*$k.", {$k}";
            $res = mysql_query($sql);
            while($row = mysql_fetch_array($res))
            {
                $id = $row["id"];
                ?>
                <tr id="tr<?=$id?>">
                    <td style="text-align:center;"><b><?=$row["id"]?></b></td>
                    <td><?=$row['name']?></td>
                    <td><a href="/tags/<?=$row['slug']?>.html" target="_blank">/tags/<?=$row['slug']?>.html</a></td>
                    <td><?=lnkAction("Red,Del")?></td>
                </tr>
            <?	}	?>
            <tr>
                <td colspan="5" align="center"><?=lnkPages($sqlmain, $p, $k)?></td>
            </tr>
            <tr>
                <th colspan="5" style="text-align:center"><?=btnAction("Update")?></th>
            </tr>
        </table>
    </form>
    <?
}
$content = ob_get_clean();

require("template.php");
?>