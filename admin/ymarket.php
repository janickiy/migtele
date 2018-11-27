<?php

// -------------------ВЫГРУЗКА----------------------
if (isset($_GET["out"])) {
    require_once('../inc/common.php');

    require_once(dirname(__FILE__) . '/../yii/protected/models/Goods.php');
    require_once(dirname(__FILE__) . '/../yii/protected/models/Catmaker.php');

    header("Content-type: text/xml");

    $site_url = $_SERVER['HTTP_HOST'];
    $usl_pay = set('usl_pay');

    ?><?= '<?xml version="1.0" encoding="windows-1251"?>' ?>
    <!DOCTYPE yml_catalog SYSTEM "shops.dtd">
    <yml_catalog date="<?= date('Y-m-d H:i') ?>">
        <shop>
            <name><?= set("ym_name") ?></name>
            <company><?= set("ym_company") ?></company>
            <url>https://<?= $site_url ?>/</url>

            <currencies>
                <currency id="RUR" rate="1"/>
            </currencies>

            <categories>
                <?
                //Добавляем условие не скрытости вендора в YML(hide_in_YML)
                $sql = sprintf($sqlCattmr, "WHERE m.hide=0 && r.hide=0 && m.hide_in_YML = 0 && tmr.hide_in_YML = 0 && tmr.hide = 0");
//                $sql .= ' LIMIT 10';
                $res = sql($sql);
                while ($row = mysql_fetch_array($res)) {
                    $ids[] = $row['id'];
                    ?>
                    <category id="<?= $row['id'] ?>"><?= htmlspecialchars($row['cattmr'], ENT_QUOTES) ?></category>
                <? } ?>
            </categories>

            <offers>
                <?php $res = sql("SELECT * FROM {$prx}goods WHERE importNew=0 && hide=0 && none=0 && yml=1 && price > 0 && id_cattmr IN (" . implode(",", $ids) . ")");
                while ($row = mysql_fetch_array($res)) {

                    $position = Goods::model()->findByPk($row['id']);
                    /**@var $position Goods */

                    $currency = $row["valuta"];
                    $price = $row["price"];
                    if ($row["price"]) {
                        if ($currency != "rub")
                            $price = $price * $kurs[$currency];
                        if (!number_format($price, 0, "", "")) {
                            continue;
                        }
                        $id_img = getField("SELECT id FROM {$prx}goods_img WHERE id_goods='{$row['id']}' ORDER BY sort LIMIT 1");
                        ?>
                        <offer id="<?= $row['id'] ?>" <?= ($row['yandex_bid'] ? "bid=\"{$row['yandex_bid']}\"" : "") ?>
                               available="<?= $row['nalich'] ? "true" : "false" ?>">
                            <url>http://<?= $site_url ?>/<?= $position->getUrl()?></url>
                            <price><?= number_format($price, 0, "", "") ?></price>
                            <currencyId>RUR</currencyId>
                            <categoryId><?= $row['id_cattmr'] ?></categoryId>
                            <?php if($id_img){ ?>
                            <picture>http://<?= $site_url ?>/images/original/uploads/goods_img/<?= $id_img ?>.jpg</picture>
                            <?php } ?>
                            <name><?= htmlspecialchars($row['name'], ENT_QUOTES) ?></name>
                            <vendor><?= htmlspecialchars($position->vendor->name, ENT_QUOTES) ?></vendor>
                            <vendorCode><?= htmlspecialchars($position->kod, ENT_QUOTES) ?></vendorCode>
                            <model><?= htmlspecialchars($row['name'], ENT_QUOTES) ?></model>
                            <description><?= htmlspecialchars(strip_tags($row['text1']), ENT_QUOTES) ?></description>
                            <sales_notes><?= $usl_pay ?></sales_notes>
                        </offer>
                        <?
                    }
                }
                ?>
            </offers>
        </shop>
    </yml_catalog>
    <?
    exit;
}
// ---------------------------------------------------


require('inc/common.php');
$tbl = "settings";
$rubric = "Товары &raquo; Яндекс-Маркет";
$top_menu = "goods";
$id = (int)@$_GET['id'];

// -------------------СОХРАНЕНИЕ----------------------
if (isset($_GET["action"])) {
    switch ($_GET['action']) {
        case "save":
            foreach ($_POST as $id => $val) {
                $val = clean($val);
                update($tbl, "value='$val'", $id);
            }
            ?>
            <script>top.topBack(true);</script><?
            break;
    }
    exit;
}

ob_start();
// ------------------РЕДАКТИРОВАНИЕ--------------------
?>
    <form action="?id=<?= $id ?>&action=save" method="post" enctype="multipart/form-data" target="ajax">
        <table class="red" width="600">
            <tr>
                <th>Короткое название магазина</th>
                <td><input name="ym_name" type="text" value="<?= set('ym_name') ?>" maxlength="20"></td>
            </tr>
            <tr>
                <th>Полное наименование компании</th>
                <td><input name="ym_company" type="text" value="<?= set('ym_company') ?>"></td>
            </tr>
            <tr>
                <td align="center" colspan="2"><?= btnAction("Save,Reset") ?></td>
            </tr>
        </table>
    </form>
    <br><br>
    <table class="content">
        <tr>
            <th>Ссылка на файл выгрузки</th>
        </tr>
        <tr>
            <td><a href="?out" target="_blank">http://<?= $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] ?>?out</a></td>
        </tr>
    </table>
<?

$content = ob_get_clean();
$tbl = "ymarket";

require("template.php");
?>