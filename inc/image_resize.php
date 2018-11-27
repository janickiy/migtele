<?
$src = $_SERVER['DOCUMENT_ROOT'].$_GET['src'];

if(!file_exists($src))
{
	$src = $_SERVER['DOCUMENT_ROOT'].'/uploads/nophoto.gif';
	if(!file_exists($src))
		die();
}

$quality = 90;
$width = (int)@$_GET['width'];
$height = (int)@$_GET['height'];

$size = @getimagesize($src);


if ($size === false) 
	die();

$type = $size['mime'];
$format = strtolower(substr($type, strpos($type, '/')+1));
$icfunc = "imagecreatefrom" . $format;
if (!function_exists($icfunc))
	die();

if(!$width || $width > $size[0])
	$width = $size[0];
if(!$height || $height > $size[1])
	$height = $size[1];

$x_ratio = $width / $size[0];
$y_ratio = $height / $size[1];

$ratio = min($x_ratio, $y_ratio);
$use_x_ratio = ($x_ratio == $ratio);

$width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
$height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);


if($width==$size[0] || $height==$size[1])
{
	header("Content-type:".$type);
	$file = fopen($src,"r");
	fpassthru($file);
}
else
{
	$isrc = $icfunc($src);
	$idest = imagecreatetruecolor($width, $height);
	
	imagecopyresampled($idest, $isrc, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
	
	header("Content-type:image/jpeg");
	imagejpeg($idest, "", $quality);
	
	imagedestroy($isrc);
	imagedestroy($idest);
}
?>