<?
require('inc/common.php');
$tbl = "delivery_methods";
$rubric = "Способы доставки";
$id = (int)@$_GET['id'];
$tc_id = (int)@$_GET['tc_id'];

$sqlmain = "SELECT id,name FROM {$prx}{$tbl} ORDER BY sort DESC";
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
            $api_name = isset($api_name) ? $api_name : null;

            $set = "name='{$name}',api_name='{$api_name}', description='{$description}', hide={$hide}, price={$price}";

            switch ($type){
                case "pickup":
                    $set .= ", coordinate='{$coordinate}', address='{$address}', phone='{$phone}', days='{$days}',  hours='{$hours}'";
                    break;
                case "in_russia":
                    $set .= ", text_to_store='{$text_to_store}', text_to_door='{$text_to_door}'";
                    break;
            }

            $id = update($tbl, $set, $id);

            if($id){
                // загружаем картинки
                if($_FILES['file']['name'])
                {
                    $row = getRow("SELECT * FROM {$prx}{$tbl} WHERE id='{$id}'");
                    if($row['file'])
                        @unlink($_SERVER['DOCUMENT_ROOT'].$row['file']);

                    $file_path = "/uploads/delivery/".$id."/";
                    $path = $_SERVER['DOCUMENT_ROOT'].$file_path;

                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }

                    @move_uploaded_file($_FILES['file']['tmp_name'], $path.$_FILES['file']['name']);
                    @chmod($path.$_FILES['file']['name'],0644);

                    $file = $file_path . $_FILES['file']['name'];

                    update($tbl, "file='{$file}'", $id);
                }

                // загружаем картинки
                if($_FILES['image']['name'])
                {
                    $path = $_SERVER['DOCUMENT_ROOT']."/uploads/delivery/";

                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }

                    $filename = $path."{$id}.jpg";

                    @move_uploaded_file($_FILES['image']['tmp_name'],$filename);
                    @chmod($filename,0644);
                }
            }

            $p = getPage($sqlmain,$id,$k);
            ?><script>top.location.href = "?p=<?=$p?>&id=<?=$id?>&rand=<?=rand()?>#<?=$id?>";</script><?
            break;

        case "del":
            update($tbl, "", $id);
            ?><script>top.topReload();</script><?
            break;
        case "img_del":
            @unlink($_SERVER['DOCUMENT_ROOT']."/uploads/delivery/{$id}.jpg");
            ?><script>top.location.href = "?id=<?=$id?>&red";</script><?
            break;
        case "file_del":

            $row = getRow("SELECT * FROM {$prx}{$tbl} WHERE id='{$id}'");

            @unlink($_SERVER['DOCUMENT_ROOT'].$row['file']);
            update($tbl, "file=''", $id);

            ?><script>top.location.href = "?id=<?=$id?>&red";</script><?
            break;

        case "save_tc":

            foreach($_POST as $key=>$val)
                $$key = clean($val);

            $hide = isset($hide) ? $hide : 0;

            $set = "name='{$name}', description='{$description}', delivery_method_id={$id}, hide={$hide}";


            if ($provider_id = update('delivery_method_items', $set, $tc_id)){

                ?><script>top.location.href = "?id=<?=$id?>&red";</script><?
            }


            break;

        case "tc_moveup":
            $move = "up";
        case "tc_movedown":
            moveSort((@$move ? "up" : "down"), 'delivery_method_items', $tc_id, '', "sort");
            ?><script>top.location.href = "?id=<?=$id?>&red";</script><?
            break;
        case "tc_del":
            update('delivery_method_items', "", $tc_id);
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

        <input type="hidden" name="type" value="<?=$row['type']?>">

        <table class="red2" style="width:800px;">
            <tr>
                <th>Название</th>
                <td><input name="name" type="text" value="<?=$row['name']?>" style="width:50%"></td>
            </tr>

            <?php if($row['type'] == 'in_moscow') { ?>

                <tr>
                    <th>Название используемое при отправки данных по API</th>
                    <td><input name="api_name" type="text" value="<?=$row['api_name']?>" style="width:50%"></td>
                </tr>

            <?php } ?>

            <tr>
                <th>Изображение</th>
                <td valign="middle">
                    <div style="float:left;"><input type="file" name="image"></div>
                    <?
                    $preview = "/uploads/delivery/{$id}.jpg";
                    if(file_exists($_SERVER['DOCUMENT_ROOT'].$preview))
                    {
                        ?>
                        <div style="float:left; padding:0 10px;">
                            <a href="<?=$preview?>" target="my" onClick="openWindow(800,600)">
                                <img src="<?=$preview?>" width="20" align="absmiddle" title="увеличить" style="border:1px solid #999;">
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
                <th>Цена (0 - бесплатно)</th>
                <td><input name="price" type="number" value="<?=$row['price']?>" style="width:50%"></td>
            </tr>
            <tr>
                <th>Описание</th>
                <td><textarea name="description" rows="5"><?=$row['description']?></textarea></td>
            </tr>





            <?php if($row['type'] == 'pickup') { ?>

                <tr>
                    <th>Загрузить карту в pdf</th>
                    <td valign="middle">
                        <div style="float:left;">
                            <input type="file" name="file" style="width:100%">
                        </div>
                        <?php if($row['file']){ ?>
                            <div style="float:left;"><a href="<?=$row['file']?>" target="_blank">Просмотреть текущий файл</a></div>
                            <div style="float:left; margin-left: 15px"><a href="?action=file_del&id=<?=$id?>"  target="ajax">Удалить текущий файл</a></div>
                        <?php } ?>
                    </td>

                </tr>
                <tr>
                    <th>Отметить координаты на карте</th>
                    <td>
                        <input type="hidden" name="coordinate" value="<?=$row['coordinate']?>">
                        <?php
                        $coordinate = $row['coordinate'] ? explode(',', $row['coordinate']) : ['55.6961298', '37.4930935'];
                        ?>
                        <div id="map" style="width: 300px; height: 200px; margin: 10px 0;"  data-lat="<?=trim($coordinate[0])?>" data-lng="<?=trim($coordinate[1])?>"></div>
                        <script async defer
                                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkG46bTzP07uJ75WdKjx6IGgEFtfzf4CI&callback=initMap">
                        </script>
                        <script>
                            function initMap() {

                                var $map = $('#map');
                                var uluru = {lat: $map.data('lat'), lng: $map.data('lng')};
                                var map = new google.maps.Map(document.getElementById($map.attr('id')), {
                                    zoom: 16,
                                    center: uluru
                                });
                                var marker = new google.maps.Marker({
                                    position: uluru,
                                    map: map
                                });

                                google.maps.event.addListener(map, 'click', function(event) {
                                    marker.setPosition(event.latLng);
                                    var lat = event.latLng.lat();
                                    var lng = event.latLng.lng();
                                    $('input[name="coordinate"]').val(lat+','+lng);
                                });

                            }
                        </script>
                    </td>
                </tr>
                <tr>
                    <th>Адрес</th>
                    <td><input name="address" type="text" value="<?=$row['address']?>" style="width:50%"></td>
                </tr>

                <tr>
                    <th>Телефон</th>
                    <td><input name="phone" type="text" value="<?=$row['phone']?>" style="width:50%"></td>
                </tr>




                <tr>
                    <th>Рабочие дни</th>
                    <td><input name="days" type="text" value="<?=$row['days']?>" style="width:50%"></td>
                </tr>

                <tr>
                    <th>Рабочее время</th>
                    <td><input name="hours" type="text" value="<?=$row['hours']?>" style="width:50%"></td>
                </tr>

            <?php } ?>

            <?php if($row['type'] == 'in_russia') { ?>

                <tr>
                    <th>Описание для опции "До склада ТК"</th>
                    <td><textarea name="text_to_store" id="" cols="30" rows="4"><?=$row['text_to_store']?></textarea></td>
                </tr>

                <tr>
                    <th>Описание для опции "До двери"</th>
                    <td><textarea name="text_to_door" id="" cols="30" rows="4"><?=$row['text_to_door']?></textarea></td>
                </tr>

                <tr>
                    <th>Транспортные компании</th>
                    <td>
                        <div><a href="?tc_red&id=<?=$id?>">Добавить</a></div>

                        <table class="content">
                            <tr>
                                <th>Название</th>
                                <th></th>
                            </tr>
                            <?
                            $sqltc = "SELECT id,sort,name FROM {$prx}delivery_method_items WHERE delivery_method_id={$id} ORDER BY sort ASC";
                            $p = @$_GET['p'] ? $_GET['p'] : 1;
                            $res = sql($sqltc." LIMIT ".($p-1)*$k.", {$k}");
                            while($row = mysql_fetch_array($res))
                            {
                                ?>
                                <tr id="tr<?=$row["id"]?>">
                                    <td style="width: 50%"><?=$row["name"]?></td>
                                    <td>
                                        <a href="javascript:toajax('?id=<?=$id?>&tc_id=<?=$row["id"]?>&action=tc_moveup')"><img src="img/im-arup.gif" hspace="2" alt="вверх" title="вверх" align="absmiddle"></a>
                                        <a href="javascript:toajax('?id=<?=$id?>&tc_id=<?=$row["id"]?>&action=tc_movedown')"><img src="img/im-ardown.gif" hspace="2" alt="вниз" title="вниз" align="absmiddle"></a>
                                        <a href="?id=<?=$id?>&tc_id=<?=$row["id"]?>&tc_red"><img src="img/red16.gif" hspace="2" alt="ред." title="редактировать" align="absmiddle"></a>
                                        <a href="javascript:toajax('?id=<?=$id?>&tc_id=<?=$row["id"]?>&amp;action=tc_del')" onclick="return sure();"><img src="img/del16.gif" hspace="2" alt="уд." title="удалить" align="absmiddle"></a>
                                    </td>
                                </tr>
                            <?	}	?>
                            <tr>
                                <td colspan="4" align="center" ><?=lnkPages($sqltc, $p, $k)?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            <?php } ?>


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
elseif (isset($_GET["tc_red"])){


    $rubric .= " &raquo; ".($tc_id ? "Редактирование" : "Добавление")." транспортной компании";
    $row = getRow("SELECT * FROM {$prx}delivery_method_items WHERE id='{$tc_id}'");
    ?>
    <form action="?id=<?=$id?>&tc_id=<?=$tc_id?>&action=save_tc" method="post" enctype="multipart/form-data" target="ajax">
        <table class="red2" style="width:800px;">
            <tr>
                <th>Название</th>
                <td><input name="name" type="text" value="<?=$row['name']?>" style="width:50%"></td>
            </tr>
            <tr>
                <th>Описание</th>
                <td><textarea name="description" id="" cols="30" rows="5"><?=$row['description']?></textarea></td>
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
                <td><?=lnkAction("Up, Down, Red")?></td>
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