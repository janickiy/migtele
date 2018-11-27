<?
setlocale(LC_ALL, 'ru_RU');
require($_SERVER['DOCUMENT_ROOT'] . '/inc/db.php'); //коннектимся к базе
require($_SERVER['DOCUMENT_ROOT'] . '/inc/tree.php'); //коннектимся к базе
require($_SERVER['DOCUMENT_ROOT'] . '/inc/utils.php'); //разные полезные функции

session_start();
$processed = 0;
$ignored = 0;
$serv = $_SERVER['DOCUMENT_ROOT'];

function processFile($fullfilename, $filename, $prx)
{
    global $ignored;
    global $processed;
    global $serv;
    
    //ищем последнюю точку
    $needle = '.';
    $pos = strripos($filename, $needle);

    $basename = '';
    $ext = '';

    if ($pos === false) {
        $ignored++;
        return;
    }
    else {
        $basename = substr($filename, 0, -(strlen($filename) - $pos));
        $ext = ".jpg";
    }

    $newfilename = null;

    if (preg_match('/(.+)_([\d]+)/', $basename, $matches)) {
        $kod = $matches[1];
        $nom = $matches[2];
		$nom = (int)$nom;		
		if ($nom < 1) 
		{
			$ignored++;
			return;
		}
		
		$id = (int)getField("SELECT id from {$prx}goods WHERE kod2 LIKE '{$kod}' OR kod LIKE '{$kod}' LIMIT 1");
		//echo "find good_id: ".$id."<br/>";
		$sql_img = "SELECT id FROM {$prx}goods_img where `id_goods`={$id} order by id";
		$res_arr = getArr($sql_img, true);
		
		//echo "get images for good: ".$res_arr." count: ".count($res_arr)."<br/>";
		$id_img = null;
		if (count($res_arr) > 0 && count($res_arr) > $nom) 
		{
			$id_img_old = $res_arr[$nom-1];
			//echo "exists img num: ".$nom."; img_id: ".$id_img_old."<br/>";
			$path_img = $_SERVER['DOCUMENT_ROOT']."/uploads/goods_img/{$id_img_old}.jpg";
			update('goods_img','',$id_img_old);
			unlink($path_img);
			$id_img = update('goods_img',"id_goods='{$id}'");
		}
		else
		{
			//echo "no images for: ".$id." with num: ".$nom."<br/>";
			$id_img = update('goods_img',"id_goods='{$id}'");
		}
		
		if (!is_null($id_img) && $id_img > 0) {
            $newfilename = $_SERVER['DOCUMENT_ROOT']."/uploads/goods_img/{$id_img}.jpg";
        }
        else {
            $ignored++;
            return;
        }
    }
    else
    {
        $ignored++;
        return;
    }

    if (!is_null($newfilename)) {
        $processed++;
		//echo "copy: ".$fullfilename." to: ".$newfilename."<br/>";
		copy($fullfilename, $newfilename);
		chmod($newfilename,0644);
        unlink($fullfilename);
    }
    else {
        $ignored++;
    }
}

foreach (glob($serv . "/uploads/goods_new/*.*") as $filename)
{
    $ff = explode("/", $filename);
    $countfile = count($ff) - 1;
    $filenam = $ff[$countfile];

    //echo strtolower($filenam)."<br/>";
    if (preg_match('/(.+).(jpg || jpeg)/', strtolower($filenam))) {
        //echo "matches:".strtolower($filenam)."<br/>";
		processFile($filename, $filenam, $prx);
    } else {
		//echo "not matches:".strtolower($filenam)."<br/>";
	}
}

?>
<script>top.alert(("Преобразование картинок завершено.\nОбработано: <?=$processed?>\nПроигнорировано изза ошибок: <?=$ignored?>"))</script>			 			