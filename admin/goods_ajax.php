<?php

require('inc/common_ajax.php');

$tbl = "goods";

$q = isset($_GET['q']) ? $_GET['q'] : '';

$where = $q ? "WHERE kod LIKE '%{$q}%' OR name LIKE '%{$q}%'" : "";

$res = sql("SELECT * FROM {$prx}{$tbl} {$where}  LIMIT 100");

$products = [];



while($row = mysql_fetch_assoc($res)) {

    $products['items'][] = array(
        'id' => $row['id'],
        'text' => normJsonStr($row['name'])
    );

}


echo json_encode($products, JSON_UNESCAPED_UNICODE);


function normJsonStr($str){
    $str = preg_replace_callback('/\\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
    return iconv('cp1251', 'utf-8', $str);
}

?>


