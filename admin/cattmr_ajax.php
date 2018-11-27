<?php

require('inc/common_ajax.php');

$tbl = "cattmr";

$q = isset($_GET['q']) ? iconv( 'utf-8', 'cp1251', $_GET['q']) : '';

$where = $q ? "WHERE cat.name LIKE '%{$q}%' OR sub.name LIKE '%{$q}%' OR ven.name LIKE '%{$q}%'" : "";

$res = sql("
            SELECT mr.id as id, cat.name as cat_name, sub.name as sub_name , ven.name as ven_name 
            FROM {$prx}{$tbl} as mr 
            LEFT JOIN {$prx}cattype as cat ON mr.id_cattype = cat.id
            LEFT JOIN {$prx}catrazdel as sub ON mr.id_catrazdel = sub.id
            LEFT JOIN {$prx}catmaker as ven ON mr.id_catmaker = ven.id
            {$where}  
            LIMIT 100
       ");


$cattmrs = [];

while($row = mysql_fetch_assoc($res)) {

    $cattmrs['items'][] = array(
        'id' => $row['id'],
        'text' => normJsonStr($row['cat_name']).' - '.normJsonStr($row['ven_name']).' - '.normJsonStr($row['sub_name'])
    );

}


echo json_encode($cattmrs, JSON_UNESCAPED_UNICODE);


function normJsonStr($str){
    $str = preg_replace_callback('/\\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
    return iconv('cp1251', 'utf-8', $str);
}

?>


