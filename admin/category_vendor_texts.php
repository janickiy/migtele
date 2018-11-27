<?
require('inc/common.php');

require_once(dirname(__FILE__) . '/../yii/protected/models/Catmaker.php');
require_once(dirname(__FILE__) . '/../yii/protected/models/Cattype.php');
$tbl = "category_vendor_texts";
$rubric = "���-������ �����";
$id = (int)@$_GET['id'];

$sqlmain = "SELECT * FROM {$prx}{$tbl} ";
$k = 40;


// -------------------����������----------------------
if(isset($_GET["action"]))
{
    switch($_GET['action'])
    {
        case "save":
            foreach($_POST as $key=>$val)
                $$key = clean($val);

            if(!$id_catmaker || !$id_cattype){
                errorAlert("������� ������������");
            }

            $hide = isset($hide) ? $hide : 0;
            $set = "text='{$text}', vendor_id='{$id_catmaker}', category_id='{$id_cattype}', content_title='{$content_title}', hide='{$hide}', title='{$title}', keywords='{$keywords}', description='{$description}', delivery_text='{$delivery_text}', warranty_text='{$warranty_text}'";

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
// ------------------��������������--------------------
if(isset($_GET["red"]))
{
    $rubric .= " &raquo; ".($id ? "��������������" : "����������");
    $row = getRow("SELECT * FROM {$prx}{$tbl} WHERE id='{$id}'");
    ?>
    <form action="?id=<?=$id?>&action=save" method="post" enctype="multipart/form-data" target="ajax">
        <table class="red2" style="width:800px;">

            <tr>
                <th>��� ������������</th>
                <td><?=dll("SELECT id, name FROM {$prx}cattype ORDER BY name", 'class="select2" name="id_cattype"', $row['category_id'])?></td>
            </tr>
            <tr>
                <th>������</th>
                <td><?=dll("SELECT id, name FROM {$prx}catmaker ORDER BY name", 'class="select2" name="id_catmaker"', $row['vendor_id'])?></td>
            </tr>
            <tr>
                <th>�������� ��� �����</th>
                <td><input name="content_title" type="text" value="<?=$row['content_title']?>" style="width:50%"></td>
            </tr>
            <tr>
                <th>�����</th>
                <td><textarea class="ckeditor-textarea" name="text"><?=$row['text']?></textarea></td>
            </tr>
            <tr>
                <th>����� "��������"</th>
                <td><textarea class="ckeditor-textarea" name="warranty_text"><?=$row['warranty_text']?></textarea></td>
            </tr>
            <tr>
                <th>����� "��������"</th>
                <td><textarea class="ckeditor-textarea" name="delivery_text"><?=$row['delivery_text']?></textarea></td>
            </tr>
            <tr>
                <th>������</th>
                <td><input name="hide" type="checkbox" <?=$row['hide'] ? "checked" : ""?> style="width:auto;" value="1"></td>
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
                <td align="center" colspan="2"><?=btnAction()?></td>
            </tr>
        </table>
    </form>
    <?
}

// -----------------��������-------------------
else
{
    echo lnkAction("Add");
    ?>
    <table class="content">
        <tr>
            <th>��������</th>
            <th></th>
        </tr>
        <?
        $p = @$_GET['p'] ? $_GET['p'] : 1;

        $res = sql($sqlmain." LIMIT ".($p-1)*$k.", {$k}");


        while($row = mysql_fetch_array($res))
        {


            /**@var $category Cattype*/
            $category = Cattype::model()->findByPk($row['category_id']);
            /**@var $vendor Catmaker*/
            $vendor = Catmaker::model()->findByPk($row['vendor_id']);

            $id = $row["id"];
            ?>
            <tr id="tr<?=$id?>">
                <td><a href="<?=$category->getUrlWithVendor($vendor)?>"></a><?=$category->name?>-<?=$vendor->name?></td>

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