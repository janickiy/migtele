<?
require('inc/common.php');

$tbl = "users";
$rubric = "Клиенты";
$id = (int)@$_GET['id'];

$sqlmain = "SELECT * FROM {$prx}{$tbl} ORDER BY created_at DESC";
$k = 40;

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
    switch($_GET['action'])
    {

        case "save":
            foreach($_POST as $key=>$val)
                $$key = clean($val);

            $phones = isset($_POST['phones']) ? json_encode($_POST['phones']) : "[null]";

            $addresses = isset($_POST['addresses']) ? $_POST['addresses'] : [];

            foreach ($addresses as $k=>$address){
                $addresses[$k] = iconv('cp1251', 'utf-8', $address);
            }

            $addresses = base64_encode(serialize($addresses));

            $subscribe_order = isset($subscribe_order) ? 1 : 0;
            $subscribe_cart = isset($subscribe_cart) ? 1 : 0;
            $subscribe_view = isset($subscribe_view) ? 1 : 0;
            $subscribe_wishlist = isset($subscribe_wishlist) ? 1 : 0;
            $subscribe_news = isset($subscribe_news) ? 1 : 0;

            update($tbl, "name='{$name}', email='{$email}', phones='{$phones}', delivery_addresses='{$addresses}', type='{$type}', passport='{$passport}', comment='{$comment}', company_name='{$company_name}', tin='{$tin}', juridical_address='{$juridical_address}', actual_address='{$actual_address}', subscribe_order='{$subscribe_order}', subscribe_cart='{$subscribe_cart}', subscribe_view='{$subscribe_view}', subscribe_wishlist='{$subscribe_wishlist}', subscribe_news='{$subscribe_news}'", $id);

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
        <table class="red" width="600">
            <tr>
                <th>ФИО</th>
                <td><input type="text" name="name" value="<?=$row['name']?>"></td>
            </tr>
            <tr>
                <th>Тип</th>
                <td>
                    <select name="type" id="select-user-type">
                        <option value="0" <?=$row['type'] == 0 ? "selected" : ''?>>Юридическое лицо</option>
                        <option value="1" <?=$row['type'] == 1 ? "selected" : ''?>>Физическое лицо</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Email</th>
                <td><input type="text" name="email" value="<?=$row['email']?>"></td>
            </tr>

            <?php
                $phones = json_decode($row['phones']);
            ?>
            <?php foreach ($phones as $phone) { ?>
                <tr>
                    <th>Телефон</th>
                    <td><input type="text" name="phones[]" value="<?=$phone?>"></td>
                </tr>
            <?php } ?>


            <?php
                $addresses = unserialize(base64_decode($row['delivery_addresses']));


            ?>
            <?php foreach ($addresses as $address) { ?>
                <tr>
                    <th>Адрес доставки</th>
                    <td><input type="text" name="addresses[]" value="<?=iconv('utf-8', 'cp1251', $address);?>"></td>
                </tr>
            <?php } ?>


            <tr class="field-individual">
                <th>Паспорт серия, номер</th>
                <td><input type="text" name="passport" value="<?=$row['passport']?>"></td>
            </tr>

            <tr class="field-juridical">
                <th>Название организации</th>
                <td><input type="text" name="company_name" value="<?=$row['company_name']?>"></td>
            </tr>

            <tr class="field-juridical">
                <th>ИНН/КПП</th>
                <td><input type="text" name="tin" value="<?=$row['tin']?>"></td>
            </tr>

            <tr class="field-juridical">
                <th>Юридический адрес</th>
                <td><input type="text" name="juridical_address" value="<?=$row['juridical_address']?>"></td>
            </tr>

            <tr class="field-juridical">
                <th>Фактический адрес</th>
                <td><input type="text" name="actual_address" value="<?=$row['actual_address']?>"></td>
            </tr>


            <tr>
                <th>Комментарий</th>
                <td><textarea name="comment"><?=$row["comment"]?></textarea></td>
            </tr>

            <tr>
                <th>Подписки</th>
            </tr>

            <tr>
                <th>О статусе заказа</th>
                <td><input name="subscribe_order" type="checkbox" <?=$row['subscribe_order'] ? "checked" : ""?> style="width:auto;" value="1"></td>
            </tr>

            <tr>
                <th>О товаре в корзине</th>
                <td><input name="subscribe_cart" type="checkbox" <?=$row['subscribe_cart'] ? "checked" : ""?> style="width:auto;" value="1"></td>
            </tr>

            <tr>
                <th>О просмотренном товаре</th>
                <td><input name="subscribe_view" type="checkbox" <?=$row['subscribe_view'] ? "checked" : ""?> style="width:auto;" value="1"></td>
            </tr>

            <tr>
                <th>О закладках</th>
                <td><input name="subscribe_wishlist" type="checkbox" <?=$row['subscribe_wishlist'] ? "checked" : ""?> style="width:auto;" value="1"></td>
            </tr>

            <tr>
                <th>На новости компании</th>
                <td><input name="subscribe_news" type="checkbox" <?=$row['subscribe_news'] ? "checked" : ""?> style="width:auto;" value="1"></td>
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
{	?>
    <form action="?action=saveall" target="ajax" method="post">
        <table class="content 1">
            <tr>
                <th>№</th>
                <th>ФИО</th>
                <th>Тип</th>
                <th>Email</th>
                <th>Телефон</th>
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
                    <td><?=$row["type"] ? 'Физическое' : 'Юридическое'?> лицо</td>
                    <td><?=$row['email']?></td>
                    <td><?=$row['phone']?></td>
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