<?
session_start();

$a = rand(1,999);
$b = 1;
$_SESSION['number_test'.($_GET['sp']?'_'.$_GET['sp']:'')] = $a+$b;

$string = $a.'+'.$b.'=';

// ��������� ������� ���� � �����.
//$back = "back".(rand(1,3)).".gif";
$back = "back1.gif";
$im = imagecreatefromgif($back);
// ������� � ������� ����� ���� - ������.
$color = imagecolorallocate($im, 0, 0, 0);
// ��������� ������� ������, ������� ����� �������.
$px = (imageSX($im)-11.5*strlen($string))/2;
//���������� ���������� �����
$font = imageloadfont("Pointy.gdf");
// ������� ������ ������ ����, ��� ���� � ����������� �����������.
imagestring($im, $font, $px, 1, $string, $color);
// �������� � ���, ��� ����� ������� ������� PNG.
header("Content-type: image/gif");
// ������ - ����� �������: ���������� ������ �������� �
// ����������� �������� �����, �. �. � �������.
imagegif($im);
// � ����� ����������� ������, ������� ���������.
imagedestroy($im);
?>