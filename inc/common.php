<?

@session_start();
//������������� � ������ ������
if (isset($_GET['searchid'])) {
    header("location: /search/" . $_GET['text'] . "/");
    // header("location: /search/".urlencode($_GET['text'])."/");
    // header("location: /search.php?text=".urlencode($_GET['text']));
}

require_once('db.php'); //����������� � ����
require_once('utils.php'); //������ �������� �������
require_once('tree.php'); //������ � �������
require_once('advanced/advanced.php'); //"��������" � �����
// $title = set("title");
// $keywords = set("keywords");
// $description = set("description");
require_once('header.php'); //������� ����� �����
require_once('special.php'); //������� ���������� ��� ������ �������
require_once(dirname(__FILE__) . '/yiiapp.php');
// ������ ������������
$_SESSION['group'] = $_SESSION['group'] ? $_SESSION['group'] : 1;

setVisit(); // ���������� ��������� �����
setKurs();

// ����� ����� �� �����
$kurs = getRow("SELECT eur, usd FROM {$prx}valuta ORDER BY date DESC LIMIT 1");
$kurs["eur"] = $kurs["eur"] + (set("eur_up") * $kurs["eur"] / 100);
$kurs["usd"] = $kurs["usd"] + (set("usd_up") * $kurs["usd"] / 100);
?>
