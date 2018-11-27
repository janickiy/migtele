<?

@session_start();
//Переадресация в случае поиска
if (isset($_GET['searchid'])) {
    header("location: /search/" . $_GET['text'] . "/");
    // header("location: /search/".urlencode($_GET['text'])."/");
    // header("location: /search.php?text=".urlencode($_GET['text']));
}

require_once('db.php'); //коннектимся к базе
require_once('utils.php'); //разные полезные функции
require_once('tree.php'); //работа с деревом
require_once('advanced/advanced.php'); //"навороты" к сайту
// $title = set("title");
// $keywords = set("keywords");
// $description = set("description");
require_once('header.php'); //собирем шапку сайта
require_once('special.php'); //функции специально для данной системы
require_once(dirname(__FILE__) . '/yiiapp.php');
// Группа оборудования
$_SESSION['group'] = $_SESSION['group'] ? $_SESSION['group'] : 1;

setVisit(); // статистика посещений сайта
setKurs();

// КУРСЫ ВАЛЮТ НА САЙТЕ
$kurs = getRow("SELECT eur, usd FROM {$prx}valuta ORDER BY date DESC LIMIT 1");
$kurs["eur"] = $kurs["eur"] + (set("eur_up") * $kurs["eur"] / 100);
$kurs["usd"] = $kurs["usd"] + (set("usd_up") * $kurs["usd"] / 100);
?>
