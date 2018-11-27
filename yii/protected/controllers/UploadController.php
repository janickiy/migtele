<?php

class UploadController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionIndex()
    {        
		//номер функции обратного вызова
        $callback = $_GET['CKEditorFuncNum'];
		//имя фалйа
	   // $file_name = mktime().'_'.$_FILES['upload']['name'];
	   $array = explode('.',$_FILES['upload']['name']);
	   $ext =  $array[count($array)-1];
	   $file_name = mktime().rand(1,10000).'.'.$ext;
	   //временное имя файла на сервере
	   $file_name_tmp = $_FILES['upload']['tmp_name'];		  
	   //указываем куда складывать изображения
	   $file_new_name = 'images/upload/ckeditor/';		  
	   //формируем полный путь к изображению
	   $full_path = $file_new_name.$file_name;
	   //формируем адрес для атрибута src тега img
	   $http_path = Yii::app()->request->baseUrl.'/images/upload/ckeditor/'.$file_name;
	   $error = '';
// echo 	$file_name_tmp.'|'.$full_path;exit();
	   if( copy($file_name_tmp, $full_path) ) {
		echo 'true';
	   } 
	   else
	   {
		   $error = 'Some error occured please try again later';
		   $http_path = '';
		}
		
		echo "<script type=\"text/javascript\">
			 window.parent.CKEDITOR.tools.callFunction(".$callback.",  \"".$http_path."\", \"".$error."\" );
		 </script>";
    }	
}
