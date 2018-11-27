<?php
class ImgUploadController extends Controller
{
    public function actionIndex()
    {        
		//номер функции обратного вызова
        $callback = $_GET['CKEditorFuncNum'];
		//имя фалйа
	   $file_name = mktime().'_'.$_FILES['upload']['name'];
	   //временное имя файла на сервере
	   $file_name_tmp = $_FILES['upload']['tmp_name'];		  
	   //указываем куда складывать изображения
	   $file_new_name = 'images/upload/ckeditor/';		  
	   //формируем полный путь к изображению
	   $full_path = $file_new_name.$file_name;
	   //формируем адрес для атрибута src тега img
	   $http_path = '/images/upload/ckeditor/'.$file_name;
	   $error = '';		   
	   if( copy($file_name_tmp, $full_path) ) {} 
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