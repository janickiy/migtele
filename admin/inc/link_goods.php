<?
setlocale(LC_ALL, 'ru_RU');
require($_SERVER['DOCUMENT_ROOT'] . '/inc/db.php'); //коннектимся к базе
require($_SERVER['DOCUMENT_ROOT'] . '/inc/tree.php'); //коннектимся к базе
require($_SERVER['DOCUMENT_ROOT'] . '/inc/utils.php'); //разные полезные функции

$tbl = "goods";

function getPos($src, $needle, $start_pos, $offset)
{
    $pos = strpos($src, $needle, $start_pos);
    if ($pos === false) {
        return null;
    }

    return $pos + $offset;
}

function insertLink($src, $insert_link)
{
    //delete exists link
    $pattern = "/<a href='.*\/goods\/.*'.*cursor: default;'><\/a>/i";
    $replacement = "";
    $src = preg_replace($pattern, $replacement, $src);
    $middle_text = floor(strlen($src) / 2);

    $start_p = getPos($src, "<p>", $middle_text, 3);
    $end_p = getPos($src, "</p>", $middle_text, 0);
    $start_div = getPos($src, "<div>", $middle_text, 5);
    $end_div = getPos($src, "</div>", $middle_text, 0);

    $middle_pos = 0;
    foreach (array($start_p, $start_div, $end_p, $end_div) as $pos) {
        if (!is_null($pos) && ($middle_pos == 0 || $middle_pos > $pos)) {
            $middle_pos = $pos;
        }
    }
    $new_string = substr_replace($src, $insert_link, $middle_pos, 0);
    $new_string = str_replace("'", "\\'", $new_string);

    return $new_string;
}

function updateLink($link, $text, $id, $tbl_)
{

    $insert_link = "<a href='http://migtele.ru/tovar/" . $link . ".htm' style='text-decoration: none; color: rgb(0, 0, 0); cursor: default;'></a>";
    $result = insertLink($text, $insert_link);
    $set = "text2='{$result}'";
    sql("UPDATE {$tbl_} SET {$set} WHERE id='{$id}'");
}


$query = "select * from {$prx}goods order by id";
$res = sql($query);

$flag=0;
$num = 0;
$first_id = 0;
$last_link = '';

$prev = null;

    while($row = mysql_fetch_array($res)) 
	{
        $flag=1;
		$num++;
        $text = $row['text2'];
        $id = $row['id'];

        if (!is_null($prev)) {
            updateLink($prev, $text, $id, $prx.$tbl);
        }
        else {
            $first_id = $id;
        }
        $prev = $row['link'];
        $last_link = $prev;
    }

    // set link on first to last
    if ($flag==1 && $first_id > 0) {
        $text = getField("select text2 from {$prx}goods where id='{$first_id}' limit 1");
        updateLink($last_link, $text, $first_id, $prx.$tbl);
    }

?>
<script>top.alert(("Перелинковка товаров завершена. Обработано: <?=$num?> товаров"))</script>