<?php

// $imgName = Helpers::mkdir().mktime().rand(1,10000).'.'.end(explode('.',$_FILES['upload']['name']));
// var_dump(file_exists('uploads/ckeditor/'));
$imgName = 'uploads/ckeditor/'.mktime().rand(1,10000).'.'.end(explode('.',$_FILES['upload']['name']));
if(move_uploaded_file($_FILES['upload']['tmp_name'], dirname(__FILE__).'/../../'.$imgName) ) {
	// if($_GET['resize']){
		// $height = (isset($_GET['resizeHeight']))?$_GET['resizeHeight']:600;
		// $width = (isset($_GET['resizeWidth']))?$_GET['resizeWidth']:600;
		// $imgName = ImageHelper::thumb($width,$height,$imgName, array('method' => 'resize'));
	// }				
	// if($_GET['addWaterZnak']){
		// $waterMarkPath = ($_GET['waterMarkPath'])?:'images/waterZnak.png';
		// $imgName = (Helpers::addWaterMarkToImg($imgName,array('waterMarkPath'=>$waterMarkPath)))?:$imgName;
	// }
	
}else{
	$error = 'Some error occured please try again later';
	// $error = print_r($_FILES['upload'],1);
	
}
echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction({$_GET['CKEditorFuncNum']},  '{$imgName}', '{$error}' );</script>";