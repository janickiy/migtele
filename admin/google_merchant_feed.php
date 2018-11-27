<?php
// ---------------------------------------------------

require('inc/common.php');
$tbl = "settings";
$rubric = "Товары &raquo; Google Merchant";
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
            <th>Google Merchant название</th>
            <td><input name="google-merchant-feed-name" type="text" value="<?= set('google-merchant-feed-name') ?>" maxlength="20"></td>
        </tr>
        <tr>
            <th>Google Merchant описание</th>
            <td><input name="google-merchant-feed-description" type="text" value="<?= set('google-merchant-feed-description') ?>"></td>
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
        <td>
            <? $gflink = 'https://' . $_SERVER['SERVER_NAME'] . '/google_feed.xml' ?>
            <a href="<?= $gflink ?>" target="_blank"><?= $gflink ?></a>
        </td>
    </tr>
</table>
<?

$content = ob_get_clean();
$tbl = "ymarket";

require("template.php");
?>