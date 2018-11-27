<?php
require('inc/common.php');
$top_menu = "goods";
if(isset($_POST['Goods'])){
    foreach($_POST['Goods'] as $id => $data){
        GoodSaver::save($data, $_FILES['Goods']['tmp_name'][$id]['gimg'] , array(
            'id' => $id,
        ), true);
    }
    updateOnlinePrice();
    $url = 'goods.php?';
    if(isset($_GET['importNew']))
        $url .= 'importNew='.$_GET['importNew'].'&';
    if(isset($_GET['valid']))
        $url .= 'valid='.$_GET['valid'].'&';
//    exit();
    exit("<script>location.href='{$url}'</script>");
}
ob_start();
?>
<form method="post" enctype="multipart/form-data">
<?php
foreach($_GET['id'] as $id){
    $row = getRow("SELECT * FROM {$prx}goods WHERE id='{$id}'");
    Display::staticRender('_good',array(
        'style' => $style,
        'id' => $id,
        'row' => $row,
        'id_cattmr' => $row['id_cattmr'],
        'sqlCattmr' => $sqlCattmr,
        'id_cattype' => $id_cattype,
    ));
}
?></form><script language="JavaScript" src="/inc/gimg.js?v=1"></script><?php
$content = ob_get_clean();

require("template.php");
?>

