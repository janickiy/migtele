<?
require('inc/common.php');
$tbl = "call_orders";
$rubric = "Заказы звонка специалиста";
$id = (int)@$_GET['id'];

$sqlmain = "SELECT * FROM {$prx}{$tbl} ORDER BY date DESC";
$k = 40;

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
    switch($_GET['action'])
    {
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
    $rubric .= " &raquo; Просмотр";
    $row = getRow("SELECT * FROM {$prx}{$tbl} WHERE id='{$id}'");

    $question = $row['mail'] ? true : false;

    ?>
    <a name="red"></a>
    <table class="red" width="600">
        <tr>
            <th>№</th>
            <td><b><?=$row['id']?></b></td>
        </tr>
        <tr>
            <th>Дата</th>
            <td><?=date("d.m.Y, H:i:s", strtotime($row['date']))?></td>
        </tr>
        <tr>
            <th>ФИО</th>
            <td><?=$row["name"]?></td>
        </tr>
        <tr>
            <th>Телефон (с кодом города)</th>
            <td><?=$row["phone"]?></td>
        </tr>
        <?
        if($question)
        {
            ?>
            <tr>
                <th>E-mail</th>
                <td><a href="mailto:<?=$row['mail']?>"><?=$row['mail']?></a></td>
            </tr>
            <?
        }
        ?>
        <?if($row['product_id']){?>
            <tr>
                <th>Товар</th>
                <?$product = getRow("SELECT * FROM {$prx}goods WHERE id='{$row['product_id']}'");?>
                <td>
                    <a target="_blank" href="/tovar/<?=$product['link']?>.htm"><?=$product['name']?></a>
                </td>
            </tr>
        <?}?>
        <?if($row['products_count']){?>
            <tr>
                <th>Количество товара</th>
                <td><?=$row['products_count']?></td>
            </tr>
        <?}?>
        <tr>
            <th>Вопрос</th>
            <td><?=break_to_str($row["notes"])?></td>
        </tr>
    </table>
    <?
}

// -----------------ПРОСМОТР-------------------
else
{	?>
    <table class="content 1">
        <tr>
            <th>№</th>
            <th>Дата</th>
            <th>Комментарий</th>
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
                <td><?=$row["id"]?></td>
                <td><a name="<?=$id?>"></a><?=date("d.m.Y", strtotime($row["date"]))?></td>
                <td><?=break_to_str($row["notes"])?></td>
                <td><?=lnkAction("Red,Del")?></td>
            </tr>
        <?	}	?>
        <tr>
            <td colspan="5" align="center"><?=lnkPages($sqlmain, $p, $k)?></td>
        </tr>
    </table>
    <?
}
$content = ob_get_clean();

require("template.php");
?>