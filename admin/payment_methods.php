<?
require('inc/common.php');
$tbl = "payment_methods";
$rubric = "Способоы оплаты";
$id = (int)@$_GET['id'];
$provider_id = (int)@$_GET['provider_id'];




$sqlmain = "SELECT id,sort,name FROM {$prx}{$tbl} ORDER BY sort ASC";
$k = 40;

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
    switch($_GET['action'])
    {
        case "save":
            foreach($_POST as $key=>$val)
                $$key = clean($val);

            $hide = isset($hide) ? $hide : 0;

            $set = "name='{$name}', description='{$description}', type='{$type}', hide={$hide}";
            if ($id = update($tbl, $set, $id)){


                if($_FILES['imgs'])
                {
                    foreach((array) $_FILES['imgs']['tmp_name'] as $num => $file)
                    {
                        if(!$file) continue;

                        // сохраняем в базе
                        if($id_img = update('payment_method_items',"payment_method_id='{$id}'"))
                        {
                            $path = $_SERVER['DOCUMENT_ROOT']."/uploads/payment_methods/{$id_img}.jpg";
                            @move_uploaded_file($file, $path);
                            @chmod($path,0644);
                        }
                    }
                }

                $p = getPage($sqlmain,$id,$k);
                ?><script>top.location.href = "?p=<?=$p?>&id=<?=$id?>&rand=<?=rand()?>#<?=$id?>";</script><?

            };


            break;

        case "save_provider":

            foreach($_POST as $key=>$val)
                $$key = clean($val);

            $hide = isset($hide) ? $hide : 0;

            $set = "name='{$name}', sort={$sort}, payment_method_id={$id}, hide={$hide}";


            if ($provider_id = update('payment_method_items', $set, $provider_id)){


                // загружаем картинки
                if($_FILES['image']['name'])
                {
                    $path = $_SERVER['DOCUMENT_ROOT']."/uploads/payment_methods/{$provider_id}.jpg";
                    @move_uploaded_file($_FILES['image']['tmp_name'],$path);
                    @chmod($path,0644);
                }

                ?><script>top.location.href = "?id=<?=$id?>&red";</script><?
            }


            break;

        case "del":
            update($tbl, "", $id);
            ?><script>top.topReload();</script><?
            break;
        case "img_del":
            $img_id = (int)@$_GET['img_id'];
            update('payment_method_items', "", $img_id);
            @unlink($_SERVER['DOCUMENT_ROOT']."/uploads/payment_methods/{$img_id}.jpg");
            ?><script>top.location.href = "?id=<?=$id?>&red";</script><?
            break;
        case "moveup":
            $move = "up";
        case "movedown":
            moveSort((@$move ? "up" : "down"), $tbl, $id);
            ?><script>top.location.href = "?id=<?=$id?>&rand=<?=rand()?>";</script><?
            break;
        case "provider_moveup":
            $move = "up";
        case "provider_movedown":
            moveSort((@$move ? "up" : "down"), 'payment_method_items', $provider_id, '', "sort", "payment_method_id=".$id);
            ?><script>top.location.href = "?id=<?=$id?>&red";</script><?
            break;
        case "provider_del":
            update('payment_method_items', "", $provider_id);
            @unlink($_SERVER['DOCUMENT_ROOT']."/uploads/payment_methods/{$provider_id}.jpg");
            ?><script>top.location.href = "?id=<?=$id?>&red";</script><?
            break;
        case "provider_img_del":
            @unlink($_SERVER['DOCUMENT_ROOT']."/uploads/payment_methods/{$provider_id}.jpg");
            ?><script>top.location.href = "?id=<?=$id?>&provider_id=<?=$provider_id?>&provider_red";</script><?
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
                <th>Описание</th>
                <td><textarea name="description"><?=$row['description']?></textarea></td>
            </tr>
            <tr>
                <th>Тип</th>
                <td><?=dll([
                        'electronic' => 'Электронные платежи',
                        'pictures' => 'Изображения'
                    ], 'name="type"', $row['type'], array('default','По умолчанию'))?></td>
            </tr>
            <tr>
                <th>Скрыть</th>
                <td><input name="hide" type="checkbox" <?=$row['hide'] ? "checked" : ""?> style="width:auto;" value="1"></td>
            </tr>

            <?php if($row['type'] == 'pictures') { ?>

                <tr>
                    <th>Изображения</th>
                    <td>
                        <div class="gimg" data-id="<?=$id?>">
                            <div class="glist" style="padding-left:0">
                                <div class="add source">
                                    <div id="payment-images">
                                        <div><input type="file" name="imgs[]"></div>
                                    </div>
                                    <div><button type="button" onclick="addImgSource()" title="добавить">ещё</button></div>
                                </div>
                                <div style="clear: both;"></div>
                                <div>
                                <?
                                $ids = getArr("SELECT id FROM {$prx}payment_method_items WHERE payment_method_id='{$row['id']}' ORDER BY sort,id");
                                if($count = sizeof($ids))
                                {
                                    $i=1;
                                    foreach($ids as $id_img)
                                    {
                                        if(!file_exists($_SERVER['DOCUMENT_ROOT']."/uploads/payment_methods/{$id_img}.jpg"))
                                            continue;
                                        ?>
                                        <div class="im">
                                            <div class="i0"><?=$i++?>.</div>
                                            <div class="i2"><a href="/uploads/payment_methods/<?=$id_img?>.jpg" target="my" onClick="openWindow(800,600)" title="просмотреть"><img width="40" src="/uploads/payment_methods/<?=$id_img?>.jpg"></a></div>
                                            <div class="i3"><a href="payment_methods.php?action=img_del&id=<?=$row['id']?>&img_id=<?=$id_img?>" title="удалить" target="ajax"><img src="img/del16.gif"></a></div>
                                        </div>
                                        <?
                                    }
                                }
                                ?>
                                </div>
                            </div>
                        </div>
                        <? /*<a href="goods_img.php?id_goods=<?=$id?>" target="my2" onClick="win=window.open('','my2','resizable=yes,width=512,height=384,scrollbars=1');win.focus();">редактировать</a>*/ ?>
                    </td>

                    <style>
                        #payment-images div{
                            float: none;
                        }
                    </style>
                    <script>
                        function addImgSource() {
                            $('#payment-images').append('<div><input type="file" name="imgs[]"></div>');

                            return false;
                        }
                    </script>
                </tr>

            <?php } ?>

            <?php if($row['type'] == 'electronic') { ?>
                <tr>
                    <th>Провайдеры</th>
                    <td>
                        <div><a href="?provider_red&id=<?=$id?>">Добавить</a></div>

                        <table class="content">
                            <tr>
                                <th>Название</th>
                                <th></th>
                            </tr>
                            <?
                            $sqlprovider = "SELECT id,sort,name FROM {$prx}payment_method_items WHERE payment_method_id={$id} ORDER BY sort ASC";
                            $p = @$_GET['p'] ? $_GET['p'] : 1;
                            $res = sql($sqlprovider." LIMIT ".($p-1)*$k.", {$k}");
                            while($row = mysql_fetch_array($res))
                            {
                                ?>
                                <tr id="tr<?=$id?>">
                                    <td style="width: 50%"><?=$row["name"]?></td>
                                    <td>
                                        <!--<a href="javascript:toajax('?id=<?/*=$id*/?>&action=provider_moveup')"><img src="img/im-arup.gif" hspace="2" alt="вверх" title="вверх" align="absmiddle"></a>-->
                                        <!--<a href="javascript:toajax('?id=<?/*=$id*/?>&action=provider_movedown')"><img src="img/im-ardown.gif" hspace="2" alt="вниз" title="вниз" align="absmiddle"></a>-->
                                        <a href="?id=<?=$id?>&provider_id=<?=$row["id"]?>&provider_red"><img src="img/red16.gif" hspace="2" alt="ред." title="редактировать" align="absmiddle"></a>
                                        <a href="javascript:toajax('?id=<?=$id?>&provider_id=<?=$row["id"]?>&amp;action=provider_del')" onclick="return sure();"><img src="img/del16.gif" hspace="2" alt="уд." title="удалить" align="absmiddle"></a>
                                    </td>
                                </tr>
                            <?	}	?>
                            <tr>
                                <td colspan="4" align="center" ><?=lnkPages($sqlprovider, $p, $k)?></td>
                            </tr>
                        </table>
                        <?

                        ?>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td align="center" colspan="2"><?=btnAction()?></td>
            </tr>
        </table>
    </form>
    <?
}
elseif (isset($_GET["provider_red"])){

    $provider_id = isset($_GET['provider_id']) ? $_GET['provider_id'] : 0;

    $rubric .= " &raquo; ".($provider_id ? "Редактирование провайдера" : "Добавление провайдера");
    $row = getRow("SELECT * FROM {$prx}payment_method_items WHERE id='{$provider_id}'");
    ?>
    <form action="?id=<?=$id?>&provider_id=<?=$provider_id?>&action=save_provider" method="post" enctype="multipart/form-data" target="ajax">
        <table class="red2" style="width:800px;">
            <tr>
                <th>Название</th>
                <td><input name="name" type="text" value="<?=$row['name']?>" style="width:50%"></td>
            </tr>
            <tr>
                <th>Порядок</th>
                <td><input name="sort" type="text" value="<?=$row['sort']?>" style="width:50%"></td>
            </tr>
            <tr>
                <th>Скрыть</th>
                <td><input name="hide" type="checkbox" <?=$row['hide'] ? "checked" : ""?> style="width:auto;" value="1"></td>
            </tr>

            <tr>
                <th>Изображение</th>
                <td valign="middle">
                    <div style="float:left;"><input type="file" name="image"></div>
                    <?
                    if(file_exists($_SERVER['DOCUMENT_ROOT']."/uploads/payment_methods/{$provider_id}.jpg"))
                    {
                        ?>
                        <div style="float:left; padding:0 10px;">
                            <a href="/uploads/payment_methods/<?=$provider_id?>.jpg" target="my" onClick="openWindow(800,600)">
                                <img src="/uploads/payment_methods/<?=$provider_id?>.jpg" width="20" align="absmiddle" title="увеличить" style="border:1px solid #999;">
                            </a>
                        </div>
                        <div style="float:left; padding-top:3px;">
                            <a href="?action=provider_img_del&id=<?=$id?>&provider_id=<?=$provider_id?>"  target="ajax">удалить текущее изображение</a>
                        </div>
                        <?
                    }
                    ?>
                </td>
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
                <td><?=lnkAction()?></td>
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