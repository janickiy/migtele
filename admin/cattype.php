<?
require('inc/common.php');
require_once(dirname(__FILE__) . '/../yii/protected/models/Cattype.php');

$tbl = "cattype";
$interested_product_table = 'entity_interested_products';
$rubric = "Типы оборудования";
$top_menu = "cattype";
$id = (int)@$_GET['id'];

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
    switch($_GET['action'])
    {
        case "save":
            foreach($_POST as $key=>$val)
                $$key = clean($val);

            $slug = Helpers::str2url($slug);

            $slug = !$slug ? makeUrl($name) : $slug;

            $set = "id_otr='{$id_otr}', name='{$name}', text='{$text}', title='{$title}', keywords='{$keywords}', description='{$description}', delivery_text='{$delivery_text}', warranty_text='{$warranty_text}', slug='{$slug}', banner_url='{$banner_url}'";
            $id = update($tbl, $set, $id);

            // загружаем картинки
            if($_FILES['image']['name'])
            {
                @move_uploaded_file($_FILES['image']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."/img/t{$id}.png");
                @chmod($_SERVER['DOCUMENT_ROOT']."/img/t{$id}.png",0644);
            }


            if($_FILES['banner']['name'])
            {
                @move_uploaded_file($_FILES['banner']['tmp_name'],$_SERVER['DOCUMENT_ROOT']."/img/banner/{$id}.jpg");
                @chmod($_SERVER['DOCUMENT_ROOT']."/img/banner/{$id}.jpg",0644);
            }




            ?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
            break;

        case "img_del":
            @unlink($_SERVER['DOCUMENT_ROOT']."/img/t{$id}.png");
            ?><script>top.location.href = "?id=<?=$id?>&red";</script><?
            break;
        case "img_banner_del":
            @unlink($_SERVER['DOCUMENT_ROOT']."/img/banner/{$id}.jpg");
            ?><script>top.location.href = "?id=<?=$id?>&red";</script><?
            break;
        // ----------------- обновление статуса
        case "status":
            update_flag($tbl,'status',$id);
            ?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
            break;
        case "moveup":
            $move = "up";
        case "movedown":
            moveSort((@$move ? "up" : "down"), $tbl, $id);
            ?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
            break;
        case "del":

            if($ids = getArr("SELECT id FROM {$prx}cattmr WHERE id_cattype = '{$id}'"))
            {
                errorAlert('Невозможно удалить. Элемент связан в тип-вендор-категория');
            }

            sql("DELETE FROM {$prx}cattmr WHERE id_cattype={$id}");
            sql("DELETE FROM {$prx}cattr WHERE id_cattype={$id}");
            update($tbl,"",$id);
            @unlink($_SERVER['DOCUMENT_ROOT']."/img/t{$id}.png");
            ?><script>top.topReload();</script><?
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
                <th>Отрасль</th>
                <td><?=dll("SELECT id,name FROM {$prx}otr ORDER BY sort,id", 'name="id_otr" style="width:auto;"', $row['id_otr'], array('0','-- не определена --'))?></td>
            </tr>
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
                    if(file_exists($_SERVER['DOCUMENT_ROOT']."/img/t{$id}.png"))
                    {
                        ?>
                        <div style="float:left; padding:0 10px;">
                            <a href="/img/t<?=$id?>.png" target="my" onClick="openWindow(800,600)">
                                <img src="/img/t<?=$id?>.png" width="20" align="absmiddle" title="увеличить" style="border:1px solid #999;">
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
                <th>Текст</th>
                <td><textarea class="ckeditor-textarea" name="text"><?=$row['text']?></textarea></td>
                <!--				<td>--><?//=getFck("text",$row['text'],"Medium","100%",300)?><!--</td>-->
            </tr>
            <tr>
                <th>Баннер в меню</th>
                <td valign="middle">
                    <div style="float:left;"><input type="file" name="banner"></div>
                    <?
                    if(file_exists($_SERVER['DOCUMENT_ROOT']."/img/banner/{$id}.jpg"))
                    {
                        ?>
                        <div style="float:left; padding:0 10px;">
                            <a href="/img/banner/<?=$id?>.jpg" target="my" onClick="openWindow(800,600)">
                                <img src="/img/banner/<?=$id?>.jpg" width="20" align="absmiddle" title="увеличить" style="border:1px solid #999;">
                            </a>
                        </div>
                        <div style="float:left; padding-top:3px;">
                            <a href="?action=img_banner_del&id=<?=$id?>" target="ajax">удалить текущее изображение</a>
                        </div>
                        <?
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Ссылка для баннера в меню</th>
                <td><input name="banner_url" type="text" value="<?=$row['banner_url']?>"></td>
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
                <td colspan="2" align="center"><?=btnAction()?></td>
            </tr>
        </table>
    </form>
    <?
}

// -----------------ПРОСМОТР-------------------
else
{
    $otr = (int)$_GET['otr'];
    ?>
    <table class="content" style="margin-bottom:30px;" >
        <tr>
            <th>Отрасль</th>
            <th><?=dll("SELECT id,name FROM {$prx}otr ORDER BY sort,id", 'name="id_cattype" style="width:auto" onChange="location.href=\''.$tbl.'.php?otr=\'+this.value"', $otr, array('0','-- не важно --'))?></th>
        </tr>
    </table>

    <?=lnkAction('Add','')?>
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

    <table class="content">
        <tr>
            <th>Изображение</th>
            <th>Название</th>
            <th>Ссылка</th>
            <th>Статус</th>
            <th>Кол-во кликов</th>
            <th></th>
        </tr>
        <?php
        $orderBy = ' ORDER BY sort ';
        if(isset($_GET['orderBy'])){
            switch($_GET['orderBy']){
                case 'clickCount':
                    $orderBy = ' ORDER BY clickCount DESC, sort ';
                    break;
            }
        }
        //		$sql = "SELECT * FROM {$prx}{$tbl}".($otr?" WHERE id_otr='{$otr}'":'')." ORDER BY sort";
        $sql = "SELECT * FROM {$prx}{$tbl}".($otr?" WHERE id_otr='{$otr}'":'').$orderBy;
        $res = sql($sql);
        while($row = mysql_fetch_array($res))
        {
            /**@var $category Cattype*/
            $category = Cattype::model()->findByPk($row['id']);
            $id = $row["id"];
            ?>
            <tr id="tr<?=$id?>">
                <td>
                    <?
                    if(file_exists($_SERVER['DOCUMENT_ROOT']."/img/t{$id}.png"))
                    {
                        ?><img src="/img/t<?=$id?>.png" width="100" title="увеличить"><?
                    }
                    ?>
                </td>
                <td style="font-weight:bold;">
                    <a name="<?=$id?>"></a><span class="st_g">&raquo;</span>
                    <a href="feature.php?id_cattype=<?=$id?>" title="перейти к характеристикам"><?=$row["name"]?></a>
                </td>
                <td><a href="/<?= $category->getUrl()?>">/<?= $category->getUrl()?></a></td>
                <td align="center"><?=btn_flag($row['status'],$id,'?action=status&id=')?></td>
                <td align="center"><?=$row['clickCount']?></td>
                <td><?=lnkAction("Up,Down,Red,Del")?></td>
            </tr>
            <?
        }
        ?>
    </table>
    <?
}
$content = ob_get_clean();

require("template.php");
?>