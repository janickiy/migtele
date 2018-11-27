<?
require('inc/common.php');
$tbl = "mail_templates";
$rubric = "Шаблоны писем";
$id = (int)@$_GET['id'];

$sqlmain = "SELECT id, name FROM {$prx}{$tbl}";
$k = 40;

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
    switch($_GET['action'])
    {
        case "save":
            foreach($_POST as $key=>$val)
                $$key = clean($val);


            $set = "subject='{$subject}', title='{$title}', description='{$description}', body='{$body}'";
            $id = update($tbl, $set, $id);

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
    <form action="?id=<?=$id?>&action=save" method="post" enctype="multipart/form-data" target="ajax">
        <table class="red2" style="width:800px;">
            <tr>
                <th>Тема</th>
                <td><input name="subject" type="text" value="<?=$row['subject']?>" style="width:50%"></td>
            </tr>
            <tr>
                <th>Заголовок</th>
                <td><input name="title" type="text" value="<?=$row['title']?>" style="width:50%"></td>
            </tr>
            <tr>
                <th>Подзаголовок</th>
                <td><input name="description" type="text" value="<?=$row['description']?>" style="width:50%"></td>
            </tr>
            <?php if($row['shortcodes']) { ?>
            <tr>
                <th>Возможные шорткоды</th>
                <td><?=$row['shortcodes']?></td>
            </tr>
            <?php } ?>
            <tr>
                <th>Сообщение</th>
                <td><textarea class="ckeditor-textarea" name="body"><?=$row['body']?></textarea></td>
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
                <td><?=lnkAction("Red")?></td>
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